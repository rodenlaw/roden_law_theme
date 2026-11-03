#!/usr/bin/env python3
"""
Build the self-contained seeder for Study #2's South Carolina report.

    python3 bin/build-sc-truck-seed.py > /tmp/seed-sc-truck.php
    ssh $H "wp --path=$P eval-file -"       < /tmp/seed-sc-truck.php   # dry run
    ssh $H "wp --path=$P eval-file - apply" < /tmp/seed-sc-truck.php   # draft

Done-when 1 of content-plan/2026-11.md entry 3: the verifier passes on the exact
payload the seeder carries. So this runs bin/truck-study-verify.py first and
refuses to build on any failure, then reads the same files the verifier read
(research/sc-truck-study-body.html, research/truck-study-meta.json -> sc, the
CSV), records their sha256 in the payload, and prepends it to
bin/seed-sc-truck-study.php. The body goes in byte-for-byte; the only change the
server makes is pointing the dataset href at the real media-library URL.

Writes the PHP to stdout; everything else to stderr.
"""
import hashlib, json, os, re, subprocess, sys, datetime

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
R = os.path.join(ROOT, 'research')
say = lambda *a: print(*a, file=sys.stderr)

v = subprocess.run([sys.executable, os.path.join(ROOT, 'bin', 'truck-study-verify.py'), '--research', R + '/'],
                   capture_output=True, text=True)
last = (v.stdout.strip().splitlines() or [''])[-1]
if v.returncode != 0:
    say(v.stdout[-3000:], v.stderr[-2000:])
    sys.exit(f'truck-study-verify.py failed (exit {v.returncode}): not building a seed from unverified figures')
say('verifier:', last)

meta = json.load(open(os.path.join(R, 'truck-study-meta.json')))['sc']
body = open(os.path.join(R, 'sc-truck-study-body.html'), encoding='utf-8').read()
csv_name = meta['dataset']
csv_body = open(os.path.join(R, csv_name), encoding='utf-8').read()

slug = meta['slug'].strip('/').split('/')[-1]
assert meta['slug'] == f'/resources/{slug}/', meta['slug']
hrefs = re.findall(r'href="([^"]*' + re.escape(csv_name) + r')"', body)
assert len(hrefs) == 1, f'expected one dataset href in the body, found {hrefs}'
for c in meta['charts']:
    assert f'[roden_chart name="{c}"]' in body, f'chart {c} missing from body'
    assert os.path.exists(os.path.join(ROOT, 'wordpress/wp-content/themes/roden-law/assets/charts', c + '.svg')), f'{c}.svg not in the theme'
for l in meta['links_to']:
    assert f'href="{l}"' in body, f'link {l} missing from body'
assert not re.search(r'O\.C\.G\.A\.|S\.C\. Code|§', body + meta['excerpt']), 'statute in a research asset'

sha = lambda s: hashlib.sha256(s.encode('utf-8')).hexdigest()
head = subprocess.run(['git', '-C', ROOT, 'rev-parse', '--short', 'HEAD'], capture_output=True, text=True).stdout.strip()
dirty = subprocess.run(['git', '-C', ROOT, 'status', '--porcelain', '--', 'research/'], capture_output=True, text=True).stdout.strip()
payload = {
    'slug': slug,
    'title': meta['title'],
    'content': body,
    'excerpt': meta['excerpt'],
    'meta_title': meta['meta_title'],
    'meta_description': meta['meta_description'],
    'jurisdiction': 'sc',
    'author_slug': 'graeham-c-gillin',
    'author_user': 'Roden Law',
    'practice_category': 'truck-accidents',
    'csv_name': csv_name,
    'csv_body': csv_body,
    'csv_href_in_body': hrefs[0],
    'review_on_record': {
        'date': '2026-10-26',
        'source': 'Gillin approved the SC report on the October attorney review (item sc-truck-report, 2026-10-26)',
    },
    'built_at': datetime.datetime.now().isoformat(timespec='seconds'),
    'git_head': head + (' +uncommitted research/' if dirty else ''),
    'verifier': last,
    'content_sha256': sha(body),
    'csv_sha256': sha(csv_body),
}
js = json.dumps(payload, ensure_ascii=False)
if '\nRODENJSON' in js or js.startswith('RODENJSON'):
    sys.exit('payload contains the heredoc delimiter')
seeder = open(os.path.join(ROOT, 'bin', 'seed-sc-truck-study.php'), encoding='utf-8').read().split('\n', 1)[1]
sys.stdout.write("<?php define('RODEN_SEED_JSON', <<<'RODENJSON'\n" + js + "\nRODENJSON\n);\n" + seeder)
say(f"built: {slug} | body {len(body)} bytes sha256 {payload['content_sha256'][:12]} | csv {len(csv_body)} bytes | "
    f"{len(meta['charts'])} charts | git {payload['git_head']}")
