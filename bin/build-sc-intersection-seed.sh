#!/usr/bin/env bash
#
# Build a self-contained seeder for the SC intersection pages and run it on prod.
#
# Same transport as bin/es-build-seed.sh: nothing outside the site directory
# persists on WP Engine between SSH sessions, and scp/sftp are refused by the
# host, so the JSON payload is prepended to the PHP script as a define() and the
# whole thing is piped to `wp eval-file -` over stdin.
#
#   bin/build-sc-intersection-seed.sh                 # dry run
#   bin/build-sc-intersection-seed.sh apply           # create drafts
#   bin/build-sc-intersection-seed.sh apply publish   # publish (needs FAQs on every page)
#
set -euo pipefail

here="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
repo="$(dirname "$here")"

JSON="${SEED_JSON:-$repo/data/sc-intersections-2026-08-19.json}"
SEEDER="$here/seed-sc-intersections.php"
HOST="${WPE_HOST:-rodenlawprod}"
SITE="${WPE_PATH:-/home/wpe-user/sites/rodenlawprod}"

[ -f "$JSON" ]   || { echo "missing payload: $JSON" >&2; exit 1; }
[ -f "$SEEDER" ] || { echo "missing seeder: $SEEDER" >&2; exit 1; }

# Fail early on a malformed payload rather than halfway through a prod run.
python3 -c "import json,sys; json.load(open(sys.argv[1]))" "$JSON" \
  || { echo "payload is not valid JSON" >&2; exit 1; }

# mktemp gives us the file; we want a .php sibling so `php -l` is happy.
tmp_base="$(mktemp -t sc-intersection-seed)"
tmp="$tmp_base.php"
trap 'rm -f "$tmp_base" "$tmp"' EXIT

{
  printf "<?php define('RODEN_SEED_JSON', <<<'RODENJSON'\n"
  cat "$JSON"
  printf "\nRODENJSON\n);\n"
  # Strip the seeder's own opening tag so PHP mode stays open.
  tail -n +2 "$SEEDER"
} > "$tmp"

php -l "$tmp" > /dev/null || { echo "built seeder has a syntax error" >&2; exit 1; }

echo "running against $HOST:$SITE ${*:-(dry run)}"
ssh "$HOST" "wp --path=$SITE eval-file - ${*:-}" < "$tmp"
