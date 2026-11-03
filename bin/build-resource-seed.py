# Convert a WordPress markdown draft (pi-content-writer output) into a payload for
# bin/en-seed-resource-page.php and write the ready-to-pipe seed script.
#
#   python3 bin/build-resource-seed.py <draft.md> <slug> <attorney-post-id> "<Attorney Name>" <jurisdiction> <out-dir> \
#          [--sol-ga "<deadline text>"] [--sol-sc "<deadline text>"] [--reviewed YYYY-MM-DD --reviewed-by "<Name>"]
#   e.g. python3 bin/build-resource-seed.py data/practice-area-drafts/2026-09/south-carolina-golf-cart-laws.md \
#          south-carolina-golf-cart-laws 3732 "Graeham C. Gillin" south-carolina-only /tmp/seeds
#
# Body -> HTML (headings, paragraphs, lists, tables, links, bold/italic); "Key Takeaways"
# -> _roden_key_takeaways prose; "Frequently Asked Questions" **Q:**/**A:** pairs ->
# _roden_faqs (plain-text answers, since they render into FAQPage). Guards: no meta block
# leaks into the body; no backslash anywhere (wp_unslash eats them); takeaways present;
# six or more FAQs. Generalised 2026-09-19 from build-helmet-seeds.py, which hard-coded the
# two helmet pages.
#
# 2026-11-03 (SC medical malpractice sweep, data/facts/remediation-2026-11-03-sc-medmal-draft.md):
# - FAQs: both layouts parse, "**Q: q**" + "**A:** a" (2026-09 drafts) and "**Q:** q", blank line,
#   "**A:** a" (2026-11 drafts). The old regex read 0 FAQs from the latter (P1).
# - No review date unless one is given. The payload used to carry a hard-coded
#   _roden_last_reviewed of 2026-09-19, which single-resource.php renders as "Last reviewed":
#   a review claim on every page seeded since (P2). --reviewed and --reviewed-by set it, together,
#   on the day of the real attorney review; without them the payload carries neither key.
# - Deadline sidebar: roden_filing_deadlines_sidebar() resolves practice-area deadlines only on
#   practice_area posts, so a resource falls back to the general tort statute (S.C. Code § 15-3-530,
#   O.C.G.A. § 9-3-33) unless _roden_sol_sc / _roden_sol_ga is set (R1). --sol-sc / --sol-ga set them.
#   A body citing a non-tort deadline statute (medical malpractice, workers' comp) without the
#   matching flag is refused, because the sidebar would contradict the page.
import re,json,sys,html
USAGE='usage: build-resource-seed.py <draft.md> <slug> <atty-id> "<Attorney Name>" <jurisdiction> <out-dir> [--sol-ga TEXT] [--sol-sc TEXT] [--reviewed YYYY-MM-DD --reviewed-by NAME]'
pos=[]; opts={}; a=sys.argv[1:]; i=0
while i<len(a):
    if a[i] in ('--sol-ga','--sol-sc','--reviewed','--reviewed-by'):
        if i+1>=len(a): sys.exit(f'{a[i]} needs a value\n'+USAGE)
        opts[a[i]]=a[i+1]; i+=2
    elif a[i].startswith('--'): sys.exit(f'unknown option {a[i]}\n'+USAGE)
    else: pos.append(a[i]); i+=1
if len(pos) != 6:
    sys.exit(USAGE)
DRAFT, SLUG, ATTY_ID, ATTY_NAME, JURIS, S = pos[0], pos[1], int(pos[2]), pos[3], pos[4], pos[5]
SOL_GA, SOL_SC, REVIEWED, REVIEWED_BY = opts.get('--sol-ga'), opts.get('--sol-sc'), opts.get('--reviewed'), opts.get('--reviewed-by')
if bool(REVIEWED) != bool(REVIEWED_BY):
    sys.exit('--reviewed and --reviewed-by go together: a review date names who reviewed')
if REVIEWED and not re.fullmatch(r'\d{4}-\d{2}-\d{2}',REVIEWED):
    sys.exit('--reviewed must be YYYY-MM-DD')
if SOL_SC and 'S.C. Code §' not in SOL_SC: sys.exit('--sol-sc must cite S.C. Code §')
if SOL_GA and 'O.C.G.A. §' not in SOL_GA: sys.exit('--sol-ga must cite O.C.G.A. §')
# Deadline statutes that are not the general tort statute the sidebar falls back to.
NON_TORT_DEADLINES={'SC':[r'§\s*15-3-545',r'§\s*42-15-40'],'GA':[r'§\s*9-3-71',r'§\s*34-9-82']}
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
            # "**Q: q**\n**A:** a" (2026-09) or "**Q:** q\n\n**A:** a" (2026-11)
            for mm in re.finditer(r'\*\*Q:(?:\*\*)?\s*(.+?)(?:\*\*)?\s*\n\s*\*\*A:\*\*\s*(.+?)(?=\n\s*\n\s*\*\*Q:|\n\s*\n(?!\s*\*\*A:)|\Z)',sec,re.S):
                q=mm.group(1).strip(); a=re.sub(r'\s+',' ',mm.group(2)).strip()
                a=re.sub(r'\[([^\]]+)\]\((/[^)\s]+|https?://[^)\s]+)\)',r'\1',a).replace('**','').replace('*','')
                faqs.append({'question':q,'answer':a})
        else: keep.append(sec)
    content=md_to_html('\n'.join(keep))
    assert 'Key Takeaways' not in content and 'Frequently Asked' not in content, 'meta block leaked into body'
    assert '\\' not in content and all('\\' not in f['question']+f['answer'] for f in faqs) and '\\' not in (takeaways or ''), 'backslash in content'
    assert takeaways, 'no Key Takeaways parsed'
    assert len(faqs)>=6, f'{len(faqs)} FAQs parsed (need 6+): check the Q/A layout'
    assert all(f['question'] and f['answer'] and '**' not in f['question'] for f in faqs), 'a parsed FAQ is empty or kept markup'
    for st,pats in NON_TORT_DEADLINES.items():
        flag=SOL_SC if st=='SC' else SOL_GA
        hit=[p for p in pats if re.search(p,content)]
        if hit and not flag:
            sys.exit(f"body cites a {st} deadline statute other than the tort default ({', '.join(hit)}) but no --sol-{st.lower()} was given: "
                     "the Filing Deadlines sidebar would show the general tort statute on this page")
    meta={'_roden_author_attorney':atty_id,'_roden_jurisdiction':juris,'_roden_key_takeaways':takeaways,'_roden_faqs':faqs,'_roden_see_also':[],'_roden_meta_description':meta_desc}
    if SOL_GA: meta['_roden_sol_ga']=SOL_GA
    if SOL_SC: meta['_roden_sol_sc']=SOL_SC
    if REVIEWED: meta['_roden_last_reviewed']=REVIEWED; meta['_roden_reviewed_by']=REVIEWED_BY
    payload={'slug':slug,'title':title,'excerpt':excerpt,'content':content,'expected_attorney':atty_name,'image':'','meta':meta}
    json.dump(payload,open(f'{S}/seed-{slug}.json','w'),indent=1,ensure_ascii=False)
    seeder=open('bin/en-seed-resource-page.php').read().split('\n',1)[1]
    open(f'{S}/seed-{slug}.php','w').write("<?php define('RODEN_SEED_JSON', <<<'RODENJSON'\n"+json.dumps(payload,ensure_ascii=False)+"\nRODENJSON\n);\n"+seeder)
    print(slug,'| content chars',len(content),'| takeaways chars',len(takeaways),'| faqs',len(faqs),'| GA cites',content.count('O.C.G.A. §'),'| SC cites',content.count('S.C. Code §'),'| tables',content.count('<table>'),'| links',content.count('<a href'),
      '| sol_ga',repr(SOL_GA),'| sol_sc',repr(SOL_SC),'| last_reviewed',(f'{REVIEWED} by {REVIEWED_BY}' if REVIEWED else 'NOT SET'))
build(SLUG, ATTY_ID, ATTY_NAME, JURIS)
