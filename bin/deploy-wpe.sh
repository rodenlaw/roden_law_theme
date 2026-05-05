#!/usr/bin/env bash
#
# FALLBACK deploy script for the Roden Law WordPress theme.
#
# Normal deploy path: push to GitHub `main` → the .github/workflows/deploy.yml
# action does `git subtree split` and pushes the wordpress/ subtree to BOTH
# rodenlawdev1 AND rodenlawprod via WPE git remotes. That handles 99% of cases.
#
# Use this script when:
#   - GitHub Actions is down or rate-limited
#   - You need to skip CI for an emergency hot-fix
#   - You want to ship uncommitted changes (NOTE: script still requires
#     committed changes — it deploys from the git index, not working tree)
#
# What it does (when you DO need it):
#   - Stages tracked theme files via `git checkout-index` (only committed
#     code deploys; working-tree edits silently skipped by design)
#   - rsyncs over SSH directly to /sites/rodenlawprod/wp-content/themes/roden-law/
#   - Flushes WP object cache + WPE Varnish (`wp page-cache flush`)
#   - Verifies critical theme files exist on the server
#
# This script ONLY targets prod (rodenlawprod). For dev (rodenlawdev1),
# push to main and let the GitHub Action handle it.
#
# Usage:
#   bin/deploy-wpe.sh             # full deploy: rsync + flush both caches
#   bin/deploy-wpe.sh --dry-run   # preview file changes; no transfer, no flush
#
# Prerequisites:
#   - Run from repo root
#   - SSH key at ~/.ssh/wpengine_ed25519
#
# History: this script was the primary deploy mechanism briefly (2026-05-05)
# while the deploy.yml workflow was still dev-only. After the workflow was
# extended to also push prod, this became the fallback.

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
