#!/usr/bin/env bash
#
# Plan and run the city-page FAQ dedupe (bin/apply-city-faq-dedupe.php).
# Same stdin transport as bin/build-faq-migration.sh.
#
#   bin/build-city-faq-dedupe.sh          # build the plan from content/meta.json, dry run on prod
#   bin/build-city-faq-dedupe.sh apply    # write; the backup lands in docs/backups/
#
# The plan is rebuilt from content/meta.json on every run, so regenerate that
# file first (CLAUDE.md) if prod may have moved. The seeder refuses any page
# whose _roden_faqs no longer matches the plan.
#
# No fact-registry gate: this removes entries and writes no text.
#
set -euo pipefail
here="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
repo="$(dirname "$here")"
SEEDER="$here/apply-city-faq-dedupe.php"
HOST="${WPE_HOST:-rodenlawprod@rodenlawprod.ssh.wpengine.net}"
SITE="${WPE_PATH:-/home/wpe-user/sites/rodenlawprod}"
KEY="${WPE_KEY:-$HOME/.ssh/wpengine_ed25519}"

tmp_base="$(mktemp -t city-faq-dedupe)"
plan="$tmp_base.json"
tmp="$tmp_base.php"
trap 'rm -f "$tmp_base" "$plan" "$tmp"' EXIT

# A city page is a practice_area at /<practice>-lawyers/<market>-<sc|ga>/.
# An entry is "copied" when the same answer, with place names masked, sits on
# two or more city pages.
python3 - "$repo/content/meta.json" "$plan" <<'PY'
import json, re, sys, collections
posts = json.load(open(sys.argv[1]))['posts']
city = sorted(k for k, v in posts.items()
              if v['type'] == 'practice_area' and re.fullmatch(r'/[a-z-]+-lawyers/[a-z-]+-(sc|ga)/', k))
places = {'charleston', 'north charleston', 'columbia', 'savannah', 'myrtle beach', 'darien',
          'south carolina', 'georgia', 'lowcountry', 'midlands', 'chatham', 'richland', 'horry', 'mcintosh'}
def key(s):
    s = s.lower()
    for p in sorted(places, key=len, reverse=True):
        s = s.replace(p, '<place>')
    return re.sub(r'\W+', ' ', s).strip()
cnt = collections.Counter()
for c in city:
    for k in {key(f['answer']) for f in posts[c]['meta'].get('_roden_faqs') or []}:
        cnt[k] += 1
plan = {}
for c in city:
    faqs = posts[c]['meta'].get('_roden_faqs') or []
    rm = [f['question'] for f in faqs if cnt[key(f['answer'])] >= 2]
    if rm:
        plan[c] = {'expect': faqs, 'remove': rm}
json.dump(plan, open(sys.argv[2], 'w'), ensure_ascii=False)
print(f"plan: {len(city)} city pages, {sum(len(v['remove']) for v in plan.values())} copied FAQs on {len(plan)} pages", file=sys.stderr)
PY

{
  printf "<?php define('RODEN_SEED_JSON', <<<'RODENJSON'\n"
  cat "$plan"
  printf "\nRODENJSON\n);\n"
  tail -n +2 "$SEEDER"
} > "$tmp"
php -l "$tmp" > /dev/null || { echo "built seeder has a syntax error" >&2; exit 1; }

echo "running against $HOST:$SITE ${*:-(dry run)}"
out="$(mktemp -t city-faq-dedupe-out)"
set +e
ssh -i "$KEY" -o ConnectTimeout=25 "$HOST" "wp --path=$SITE eval-file - ${*:-}" < "$tmp" | tee "$out"
status=${PIPESTATUS[0]}
set -e
if grep -q BACKUP-JSON-BEGIN "$out"; then
  dest="$repo/docs/backups/city-faq-dedupe-$(date +%Y-%m-%d).json"
  sed -n '/BACKUP-JSON-BEGIN/,/BACKUP-JSON-END/p' "$out" | sed '1d;$d' > "$dest"
  echo "backup: $dest"
fi
rm -f "$out"
exit "$status"
