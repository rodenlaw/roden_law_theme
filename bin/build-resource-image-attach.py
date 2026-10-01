#!/usr/bin/env python3
"""Embed generated resource images into bin/attach-resource-images.php run scripts.

    python3 bin/build-resource-image-attach.py <list.tsv> <image-dir> <out-dir> [--per 4] [--only slug,slug]

Reads <image-dir>/manifest.json (written by bin/gen-resource-images.mjs). Each English
resource with a generated JPG becomes a new-image item. Each Spanish twin (es-<slug>) whose
English twin is in this set becomes a reuse item, placed right after its twin in the same run
file, with the Spanish title as alt. Writes run-01.php, run-02.php, ... with --per English
images per file. Each file stays well under a few MB.
"""
import base64, html, json, pathlib, sys

args = sys.argv[1:]
lst, imgdir, outdir = pathlib.Path(args[0]), pathlib.Path(args[1]), pathlib.Path(args[2])
per = int(args[args.index('--per') + 1]) if '--per' in args else 4
only = set(args[args.index('--only') + 1].split(',')) if '--only' in args else None
root = pathlib.Path(__file__).resolve().parent.parent
tpl = (root / 'bin/attach-resource-images.php').read_text()
assert tpl.count('__ITEMS__') == 1
manifest = json.loads((imgdir / 'manifest.json').read_text())

rows = []
for line in lst.read_text().strip().split('\n')[1:]:
    pid, juris, slug, title = line.split('\t')
    rows.append({'post': int(pid), 'slug': slug, 'title': html.unescape(title)})
spanish = {r['slug'][3:]: r for r in rows if r['slug'].startswith('es-')}

groups = []
for r in rows:
    if r['slug'].startswith('es-') or r['slug'] not in manifest or (only and r['slug'] not in only):
        continue
    m = manifest[r['slug']]
    jpg = (imgdir / m['file']).read_bytes()
    assert len(jpg) > 20000, r['slug']
    alt = r['title']
    assert '\\' not in alt
    group = [{'post': r['post'], 'slug': r['slug'], 'alt': alt, 'file': f"{r['slug']}-featured.jpg",
              'b64': base64.b64encode(jpg).decode()}]
    es = spanish.get(r['slug'])
    if es:
        group.append({'post': es['post'], 'slug': es['slug'], 'alt': es['title'], 'reuse_slug': r['slug']})
    groups.append(group)

outdir.mkdir(parents=True, exist_ok=True)
for old in outdir.glob('run-*.php'):
    old.unlink()
n = 0
for i in range(0, len(groups), per):
    items = [it for g in groups[i:i + per] for it in g]
    n += 1
    payload = base64.b64encode(json.dumps(items, ensure_ascii=False).encode()).decode()
    (outdir / f'run-{n:02d}.php').write_text(tpl.replace('__ITEMS__', payload))
print(f'{len(groups)} images, {sum(len(g) - 1 for g in groups)} Spanish twins, {n} run files in {outdir}')
