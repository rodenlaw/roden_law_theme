#!/usr/bin/env python3
"""Embed data/practice-area-drafts/2026-09/ga-statewide/*.json into
bin/create-ga-statewide-pages.php (piped to `wp eval-file -`, so it cannot read
the repo). Writes the runnable script to stdout."""
import base64, json, pathlib, sys
root = pathlib.Path(__file__).resolve().parent.parent
order = ['georgia-personal-injury-lawyer', 'georgia-car-accident-lawyers', 'georgia-truck-accident-lawyers',
         'georgia-motorcycle-accident-lawyer', 'georgia-wrongful-death-lawyer', 'georgia-workers-compensation-lawyer']
pages = [json.loads((root / f'data/practice-area-drafts/2026-09/ga-statewide/{s}.json').read_text()) for s in order]
tpl = (root / 'bin/create-ga-statewide-pages.php').read_text()
assert tpl.count('__PAGES__') == 1
sys.stdout.write(tpl.replace('__PAGES__', base64.b64encode(json.dumps(pages, ensure_ascii=False).encode()).decode()))
