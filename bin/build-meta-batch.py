#!/usr/bin/env python3
"""Embed a meta-edit list ([{id, post, key, sub, from, to}]) into bin/apply-meta-batch.php.

    python3 bin/build-meta-batch.py data/facts/<batch>.json > run.php
"""
import base64, json, pathlib, sys
root = pathlib.Path(__file__).resolve().parent.parent
edits = [{k: e[k] for k in ('id', 'post', 'key', 'sub', 'from', 'to')} for e in json.loads((root / sys.argv[1]).read_text())]
assert all(chr(92) not in e['to'] for e in edits), 'backslash in a replacement'
tpl = (root / 'bin/apply-meta-batch.php').read_text()
assert tpl.count('__EDITS__') == 1
sys.stdout.write(tpl.replace('__EDITS__', base64.b64encode(json.dumps(edits, ensure_ascii=False).encode()).decode()))
print(f'{len(edits)} meta edits embedded', file=sys.stderr)
