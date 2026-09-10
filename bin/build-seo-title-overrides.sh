#!/usr/bin/env bash
#
# Build and run the FAQ backfill on prod. Same stdin transport as
# bin/build-why-hire-seed.sh.
#
#   bin/build-seo-title-overrides.sh <drafts.json>          # dry run
#   bin/build-seo-title-overrides.sh <drafts.json> apply    # write
#
# Drafts MUST pass bin/verify-faq-drafts.py first; this script refuses to build
# a payload that has not been verified in the same invocation.
#
set -euo pipefail
here="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
repo="$(dirname "$here")"

JSON="${1:?usage: build-seo-title-overrides.sh <drafts.json> [apply]}"
shift || true
SEEDER="$here/apply-seo-title-overrides.php"
HOST="${WPE_HOST:-rodenlawprod@rodenlawprod.ssh.wpengine.net}"
SITE="${WPE_PATH:-/home/wpe-user/sites/rodenlawprod}"
KEY="${WPE_KEY:-$HOME/.ssh/wpengine_ed25519}"

[ -f "$JSON" ]   || { echo "missing payload: $JSON" >&2; exit 1; }
[ -f "$SEEDER" ] || { echo "missing seeder: $SEEDER" >&2; exit 1; }

# No registry gate here: the payload is a map of paths to title strings, not
# legal prose. The applier enforces its own invariants (length, uniqueness,
# practice keyword present, slug identity) and refuses the batch otherwise.

tmp_base="$(mktemp -t seo-title-overrides)"
tmp="$tmp_base.php"
trap 'rm -f "$tmp_base" "$tmp"' EXIT

{
  printf "<?php define('RODEN_SEED_JSON', <<<'RODENJSON'\n"
  cat "$JSON"
  printf "\nRODENJSON\n);\n"
  tail -n +2 "$SEEDER"
} > "$tmp"

php -l "$tmp" > /dev/null || { echo "built seeder has a syntax error" >&2; exit 1; }
echo "running against $HOST:$SITE ${*:-(dry run)}"
ssh -i "$KEY" -o ConnectTimeout=25 "$HOST" "wp --path=$SITE eval-file - ${*:-}" < "$tmp"
