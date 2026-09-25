#!/usr/bin/env python3
"""Stage blog posts for a Tier B freshness refresh (WordPress path).

  node --input-type=module -e "…createAdapter({client:'roden', fresh:true}).readAll()"   # refresh the cache first
  python3 bin/freshness-stage.py <runRoot> /blog/slug-a/ /blog/slug-b/ …

Writes <runRoot>/run-<id>/{body.html,body.before.html,meta.json,meta.before.json} from
data/content-cache/wp-export.json and prints each post's shape (words, FAQs, key takeaways
location, review date, author, jurisdiction mentions, statutes cited, tel: hrefs, dollar figures).
The facts pack goes in the same directory as facts-<id>.json; the refresher edits body.html and
meta.json in place; bin/freshness-build-patch.mjs turns the diff into an exact-match patch.
"""
import json, re, os, sys
S=sys.argv[1]
paths=sys.argv[2:]
d=json.load(open('data/content-cache/wp-export.json')); M=json.load(open('content/meta.json'))['posts']
GA=re.compile(r'O\.C\.G\.A|Georgia'); SC=re.compile(r'S\.C\. Code|South Carolina')
for path in paths:
    p=[x for x in d['documents'] if x['path']==path][0]; R=f"{S}/run-{p['id']}"; os.makedirs(R,exist_ok=True)
    meta={"excerpt":p['excerpt'],"keyTakeaways":p['meta']['keyTakeaways'],"faqs":p['meta']['faqs'],"metaDescription":p['meta']['metaDescription']}
    for n in ['body.html','body.before.html']: open(f"{R}/{n}",'w').write(p['content'])
    for n in ['meta.json','meta.before.json']: json.dump(meta,open(f"{R}/{n}",'w'),indent=1,ensure_ascii=False)
    body=re.sub('<[^>]+>',' ',p['content']); mm=M.get(path,{}).get('meta',{})
    print("id",p['id'],"|",path); print("  title:",p['title'])
    print("  modified",p['modified'],"| words",len(body.split()),"| faqs",len(p['meta']['faqs']),"| keyTakeaways",'meta' if p['meta']['keyTakeaways'] else ('body' if 'Key Takeaways' in p['content'] else 'none'),"| lastReviewed",repr(p['meta']['lastReviewed']),"| author",p['meta']['author'])
    print("  twin:",mm.get('_roden_translation_es'),"| GA",len(GA.findall(body)),"| SC",len(SC.findall(body)),"| statutes:",sorted(set(re.findall(r'(?:O\.C\.G\.A\. §|S\.C\. Code §) ?[\d\-\.]+',body)))[:14], "| tel:", sorted(set(re.findall(r'tel:[+\d]+',p['content']))), "| justia:", len(re.findall('law.justia.com',p['content'])), "| dollar figures:", len(re.findall(r'\$[\d,]+',body)))
    print("  H2s:", re.findall(r'<h2[^>]*>(.*?)</h2>',p['content'])[:12])
