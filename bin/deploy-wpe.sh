#!/usr/bin/env bash
#
# Deploy the Roden Law WordPress theme to WP Engine production.
#
# Why this exists: the repo is a monorepo (wordpress/ + next/) but WP
# Engine's git deploy maps repo root → site root. Theme files end up at
# /sites/rodenlawprod/wordpress/wp-content/themes/roden-law/ instead of
# the active path /sites/rodenlawprod/wp-content/themes/roden-law/, and
# every `git push production main` wipes the live theme. This script
# bypasses WPE git deploy entirely and rsyncs the theme straight into
# the active path over SSH, then flushes object + Varnish caches.
#
# See ../memory/feedback_wpe_deploy_path_mismatch.md for the long story.
#
# Usage:
#   bin/deploy-wpe.sh             # full deploy: rsync + flush both caches
#   bin/deploy-wpe.sh --dry-run   # preview file changes; no transfer, no flush
#
# Prerequisites:
#   - Run from repo root
#   - SSH key at ~/.ssh/wpengine_ed25519
#   - All changes you want deployed are COMMITTED (script deploys from the
#     git index via `git checkout-index`, not the working tree)

set -euo pipefail

THEME_SRC_DIR="wordpress/wp-content/themes/roden-law"
WPE_HOST="rodenlawprod@rodenlawprod.ssh.wpengine.net"
WPE_THEME_PATH="/sites/rodenlawprod/wp-content/themes/roden-law"
SSH_KEY="$HOME/.ssh/wpengine_ed25519"
SSH_OPTS=(-i "$SSH_KEY" -o StrictHostKeyChecking=no -o ConnectTimeout=10)

if [ ! -d "$THEME_SRC_DIR" ]; then
  echo "ERROR: run from repo root (expected $THEME_SRC_DIR)" >&2
  exit 1
fi

DRY_RUN=""
if [ "${1:-}" = "--dry-run" ]; then
  DRY_RUN="--dry-run"
  echo ">>> DRY RUN — no files transferred, no caches flushed"
fi

# ── stage tracked files only ────────────────────────────────────────────
# `git checkout-index` extracts files from the git index, so it honors
# .gitignore by definition (ignored files are not in the index). This
# means: only COMMITTED changes deploy. Working-tree edits without a
# commit will not appear on prod. That is intentional.
STAGING=$(mktemp -d -t roden-deploy.XXXXXXXX)
trap 'rm -rf "$STAGING"' EXIT

echo ">>> staging tracked files into $STAGING"
git checkout-index -a -f --prefix="$STAGING/"

STAGED_THEME="$STAGING/$THEME_SRC_DIR"
if [ ! -d "$STAGED_THEME" ]; then
  echo "ERROR: staging missing $STAGED_THEME (uncommitted theme?)" >&2
  exit 1
fi

# ── rsync to WPE active theme path ──────────────────────────────────────
# Excludes mirror the theme's .gitignore intent: some files were tracked
# in earlier commits before being added to .gitignore, so git still has
# them in the index. Don't ship docs/spreadsheets/build artifacts to prod.
echo ">>> rsync $THEME_SRC_DIR/ → $WPE_HOST:$WPE_THEME_PATH/"
rsync -av --delete $DRY_RUN \
  --exclude='.gitignore' \
  --exclude='*.md' \
  --exclude='*.docx' \
  --exclude='*.xlsx' \
  --exclude='*.jsx' \
  --exclude='setup-scaffold.sh' \
  -e "ssh ${SSH_OPTS[*]}" \
  "$STAGED_THEME/" \
  "$WPE_HOST:$WPE_THEME_PATH/"

if [ -n "$DRY_RUN" ]; then
  echo ">>> dry run complete"
  exit 0
fi

# ── flush caches ────────────────────────────────────────────────────────
# Stderr is suppressed because a 3rd-party plugin (wp-health) emits
# noisy PHP 8.4 nullable-parameter deprecations on every wp-cli call.
echo ">>> flush WP object cache (memcache/transients)"
ssh "${SSH_OPTS[@]}" "$WPE_HOST" "cd /sites/rodenlawprod && wp cache flush 2>/dev/null"

echo ">>> flush WPE page cache (Varnish)"
ssh "${SSH_OPTS[@]}" "$WPE_HOST" "cd /sites/rodenlawprod && wp page-cache flush 2>/dev/null"

# ── verify ──────────────────────────────────────────────────────────────
echo ">>> verify deployed theme files exist"
ssh "${SSH_OPTS[@]}" "$WPE_HOST" \
  "test -f $WPE_THEME_PATH/style.css && \
   test -f $WPE_THEME_PATH/functions.php && \
   test -f $WPE_THEME_PATH/inc/firm-data.php && \
   test -f $WPE_THEME_PATH/templates/template-intersection.php && \
   echo '  ✓ critical theme files present' || \
   echo '  ✗ MISSING critical theme files'"

echo
echo ">>> done. Live: https://rodenlaw.com/"
