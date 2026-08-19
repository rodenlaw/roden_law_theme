#!/usr/bin/env bash
#
# Build and run the SC office Why Hire backfill on prod.
# Same stdin transport as bin/build-sc-intersection-seed.sh.
#
#   bin/build-why-hire-seed.sh          # dry run
#   bin/build-why-hire-seed.sh apply    # write
#
set -euo pipefail
here="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
repo="$(dirname "$here")"

JSON="${SEED_JSON:-$repo/data/why-hire-sc-offices-2026-08-19.json}"
SEEDER="$here/backfill-why-hire-sc-offices.php"
HOST="${WPE_HOST:-rodenlawprod}"
SITE="${WPE_PATH:-/home/wpe-user/sites/rodenlawprod}"

[ -f "$JSON" ]   || { echo "missing payload: $JSON" >&2; exit 1; }
[ -f "$SEEDER" ] || { echo "missing seeder: $SEEDER" >&2; exit 1; }
python3 -c "import json,sys; json.load(open(sys.argv[1]))" "$JSON" \
  || { echo "payload is not valid JSON" >&2; exit 1; }

tmp_base="$(mktemp -t why-hire-seed)"
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
ssh "$HOST" "wp --path=$SITE eval-file - ${*:-}" < "$tmp"
