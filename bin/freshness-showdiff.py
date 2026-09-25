#!/usr/bin/env python3
"""Print the changed words of each edit in <runDir>/edits.json (built by bin/freshness-build-patch.mjs --dry-run)."""
import json, re, html, difflib, sys
R=sys.argv[1]
E=json.load(open(R+'/edits.json'))
strip=lambda s: html.unescape(re.sub(r'<a href="([^"]+)"[^>]*>(.*?)</a>', r'\2 [\1]', re.sub(r'\s+',' ', s))).strip()
strip2=lambda s: re.sub(r'<(?!/?a\b)[^>]+>', '', s)
for i,e in enumerate(E,1):
    b,a=strip(strip2(e['before'])),strip(strip2(e['after']))
    sm=difflib.SequenceMatcher(None,b.split(),a.split())
    chg=[(t,' '.join(b.split()[i1:i2]),' '.join(a.split()[j1:j2])) for t,i1,i2,j1,j2 in sm.get_opcodes() if t!='equal']
    print(f"--- edit {i} · {e['surface']} ---"); [print(f"  {t}: '{x[:120]}' -> '{y[:260]}'") for t,x,y in chg[:5]]
