#!/usr/bin/env python3
"""Embed the "apply"-class edits from data/facts/linked-pages-batch-2026-09-28.json
into bin/apply-linked-pages-batch.php (which is piped to `wp eval-file -` and
cannot read the repo). Writes the runnable script to stdout's target path.

    python3 bin/build-linked-pages-batch.py > /tmp/apply-linked-pages-batch.run.php
"""
import base64
import json
import pathlib
import sys

root = pathlib.Path(__file__).resolve().parent.parent
edits = json.loads((root / 'data/facts/linked-pages-batch-2026-09-28.json').read_text())
keep = [
    {k: e[k] for k in ('id', 'post_id', 'field', 'from', 'to')}
    for e in edits
    if e.get('class') == 'apply' and e.get('from') and e.get('to') is not None
]
tpl = (root / 'bin/apply-linked-pages-batch.php').read_text()
assert tpl.count('__EDITS__') == 1
payload = base64.b64encode(json.dumps(keep, ensure_ascii=False).encode()).decode()
sys.stdout.write(tpl.replace('__EDITS__', payload))
print(f'{len(keep)} apply edits embedded', file=sys.stderr)
