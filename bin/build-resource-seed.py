# Convert a WordPress markdown draft (pi-content-writer output) into a payload for
# bin/en-seed-resource-page.php and write the ready-to-pipe seed script.
#
#   python3 bin/build-resource-seed.py <draft.md> <slug> <attorney-post-id> "<Attorney Name>" <jurisdiction> <out-dir>
#   e.g. python3 bin/build-resource-seed.py data/practice-area-drafts/2026-09/south-carolina-golf-cart-laws.md \
#          south-carolina-golf-cart-laws 3732 "Graeham C. Gillin" south-carolina-only /tmp/seeds
#
# Body -> HTML (headings, paragraphs, lists, tables, links, bold/italic); "Key Takeaways"
# -> _roden_key_takeaways prose; "Frequently Asked Questions" **Q:**/**A:** pairs ->
# _roden_faqs (plain-text answers, since they render into FAQPage). Guards: no meta block
# leaks into the body; no backslash anywhere (wp_unslash eats them); takeaways present;
# six or more FAQs. Generalised 2026-09-19 from build-helmet-seeds.py, which hard-coded the
# two helmet pages.
import re,json,sys,html
if len(sys.argv) != 7:
    sys.exit(__doc__ or 'usage: build-resource-seed.py <draft.md> <slug> <atty-id> "<Attorney Name>" <jurisdiction> <out-dir>')
DRAFT, SLUG, ATTY_ID, ATTY_NAME, JURIS, S = sys.argv[1], sys.argv[2], int(sys.argv[3]), sys.argv[4], sys.argv[5], sys.argv[6]
def inline(t):
    t=html.escape(t,quote=False)
    t=re.sub(r'\[([^\]]+)\]\((https?://[^)\s]+|/[^)\s]+)\)',r'<a href="\2">\1</a>',t)
    t=re.sub(r'\*\*(.+?)\*\*',r'<strong>\1</strong>',t)
    t=re.sub(r'(?<!\*)\*(?!\*)(.+?)(?<!\*)\*(?!\*)',r'<em>\1</em>',t)
    return t
def table(lines):
    rows=[[c.strip() for c in l.strip().strip('|').split('|')] for l in lines if not re.match(r'^\|[-| ]+\|$',l.strip())]
    h='<table><thead><tr>'+''.join(f'<th>{inline(c)}</th>' for c in rows[0])+'</tr></thead><tbody>'
    for r in rows[1:]: h+='<tr>'+''.join(f'<td>{inline(c)}</td>' for c in r)+'</tr>'
    return h+'</tbody></table>'
def md_to_html(md):
    out=[]; lines=md.split('\n'); i=0; para=[]
    def flush():
        nonlocal para
        if para: out.append('<p>'+inline(' '.join(para))+'</p>'); para=[]
    while i<len(lines):
        l=lines[i]
        if l.startswith('|'):
            flush(); j=i
            while j<len(lines) and lines[j].startswith('|'): j+=1
            out.append(table(lines[i:j])); i=j; continue
        if l.startswith('## '): flush(); out.append(f'<h2>{inline(l[3:])}</h2>'); i+=1; continue
        if l.startswith('### '): flush(); out.append(f'<h3>{inline(l[4:])}</h3>'); i+=1; continue
        if l.startswith('- '):
            flush(); j=i; items=[]
            while j<len(lines) and lines[j].startswith('- '): items.append(lines[j][2:]); j+=1
            out.append('<ul>'+''.join(f'<li>{inline(x)}</li>' for x in items)+'</ul>'); i=j; continue
        if l.strip()=='' : flush(); i+=1; continue
        para.append(l.strip()); i+=1
    flush(); return '\n'.join(out)
def build(slug, atty_id, atty_name, juris):
    md=open(DRAFT).read()
    fm,body=md.split('\n---\n',1)
    m=re.search(r'^meta_description: "(.+)"$',fm,re.M); excerpt=re.search(r'^excerpt: "(.+)"$',fm,re.M).group(1); meta_desc=m.group(1) if m else excerpt
    title=re.search(r'^title: "(.+)"$',fm,re.M).group(1)
    body=re.sub(r'^# .+\n','',body.strip()); body=re.sub(r'^Last reviewed:.*\n','',body,flags=re.M)
    secs=re.split(r'\n(?=## )',body); takeaways=None; faqs=[]; keep=[]
    for sec in secs:
        h=sec.split('\n',1)[0]
        if h.startswith('## Key Takeaways'):
            items=[re.sub(r'^- ','',x) for x in sec.split('\n')[1:] if x.startswith('- ')]; takeaways=' '.join(inline(x) for x in items)
        elif h.startswith('## Frequently Asked'):
            for mm in re.finditer(r'\*\*Q: (.+?)\*\*\n\*\*A:\*\* (.+?)(?=\n\n|\Z)',sec,re.S):
                q=mm.group(1).strip(); a=re.sub(r'\s+',' ',mm.group(2)).strip()
                a=re.sub(r'\[([^\]]+)\]\((/[^)\s]+|https?://[^)\s]+)\)',r'\1',a).replace('**','').replace('*','')
                faqs.append({'question':q,'answer':a})
        else: keep.append(sec)
    content=md_to_html('\n'.join(keep))
    assert 'Key Takeaways' not in content and 'Frequently Asked' not in content, 'meta block leaked into body'
    assert '\\' not in content and all('\\' not in f['question']+f['answer'] for f in faqs) and '\\' not in (takeaways or ''), 'backslash in content'
    assert takeaways and len(faqs)>=6
    payload={'slug':slug,'title':title,'excerpt':excerpt,'content':content,'expected_attorney':atty_name,'image':'',
      'meta':{'_roden_author_attorney':atty_id,'_roden_jurisdiction':juris,'_roden_key_takeaways':takeaways,'_roden_faqs':faqs,'_roden_see_also':[],'_roden_last_reviewed':'2026-09-19','_roden_meta_description':meta_desc}}
    json.dump(payload,open(f'{S}/seed-{slug}.json','w'),indent=1,ensure_ascii=False)
    seeder=open('bin/en-seed-resource-page.php').read().split('\n',1)[1]
    open(f'{S}/seed-{slug}.php','w').write("<?php define('RODEN_SEED_JSON', <<<'RODENJSON'\n"+json.dumps(payload,ensure_ascii=False)+"\nRODENJSON\n);\n"+seeder)
    print(slug,'| content chars',len(content),'| takeaways chars',len(takeaways),'| faqs',len(faqs),'| GA cites',content.count('O.C.G.A. §'),'| SC cites',content.count('S.C. Code §'),'| tables',content.count('<table>'),'| links',content.count('<a href'))
build(SLUG, ATTY_ID, ATTY_NAME, JURIS)
