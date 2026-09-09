#!/usr/bin/env bash
#
# Build and run the FAQ backfill on prod. Same stdin transport as
# bin/build-why-hire-seed.sh.
#
#   bin/build-faq-backfill.sh <drafts.json>          # dry run
#   bin/build-faq-backfill.sh <drafts.json> apply    # write
#
# Drafts MUST pass bin/verify-faq-drafts.py first; this script refuses to build
# a payload that has not been verified in the same invocation.
#
set -euo pipefail
here="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
repo="$(dirname "$here")"

JSON="${1:?usage: build-faq-backfill.sh <drafts.json> [apply]}"
shift || true
SEEDER="$here/apply-faq-backfill.php"
HOST="${WPE_HOST:-rodenlawprod@rodenlawprod.ssh.wpengine.net}"
SITE="${WPE_PATH:-/home/wpe-user/sites/rodenlawprod}"
KEY="${WPE_KEY:-$HOME/.ssh/wpengine_ed25519}"
CANDIDATES="${FAQ_CANDIDATES:-}"

[ -f "$JSON" ]   || { echo "missing payload: $JSON" >&2; exit 1; }
[ -f "$SEEDER" ] || { echo "missing seeder: $SEEDER" >&2; exit 1; }

# The registry gate. Never build a payload that has not just passed it.
if [ -n "$CANDIDATES" ]; then
  echo "verifying drafts against data/faq-fact-registry.json ..."
  python3 "$here/verify-faq-drafts.py" "$JSON" "$CANDIDATES" \
    || { echo "drafts FAILED verification - refusing to build" >&2; exit 1; }
else
  echo "FAQ_CANDIDATES is not set - cannot verify drafts. Refusing to build." >&2
  echo "  export FAQ_CANDIDATES=/path/to/faq-candidates.json" >&2
  exit 1
fi

tmp_base="$(mktemp -t faq-backfill)"
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
