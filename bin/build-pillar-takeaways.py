#!/usr/bin/env python3
"""Embed data/practice-area-drafts/2026-09/pillar-takeaways/takeaways.json into
bin/set-pillar-takeaways.php (piped to `wp eval-file -`). Writes to stdout."""
import base64, json, pathlib, sys
root = pathlib.Path(__file__).resolve().parent.parent
data = json.loads((root / 'data/practice-area-drafts/2026-09/pillar-takeaways/takeaways.json').read_text())
data = {k: {'text': v['text']} for k, v in data.items()}
tpl = (root / 'bin/set-pillar-takeaways.php').read_text()
assert tpl.count('__DATA__') == 1
sys.stdout.write(tpl.replace('__DATA__', base64.b64encode(json.dumps(data, ensure_ascii=False).encode()).decode()))
