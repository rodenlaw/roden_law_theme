#!/usr/bin/env python3
"""
Gate drafted FAQ blocks against data/faq-fact-registry.json and the source post body.

    python3 bin/verify-faq-drafts.py <drafts.json> <candidates.json>

Exits non-zero if any draft fails, so it can gate an apply run.

WHY THIS EXISTS
---------------
A FAQ answer is published twice - visibly through roden_faq_section() and again
as FAQPage JSON-LD through roden_schema_faq_page(). Every legal-accuracy incident
this repo has recorded was a claim that was wrong in one of those surfaces:
workers' comp pages carrying the TORT statute of limitations (2026-07-30, and
again on the Spanish twins 2026-07-31), S.C. Code 15-38-15 cited for the
plaintiff's comparative bar (31 instances across 23 pages, commit 6c0ee36), and
15-78-50 cited for a Tort Claims Act deadline it does not contain (#117).

Those are not typos. They are the same failure: a plausible citation written from
recall rather than from a source. This file makes that structurally impossible to
ship - a citation absent from the registry, or paired with a quantity the
registry does not allow for it, fails the run.

CHECK 5 IS THE IMPORTANT ONE. Every number in an answer must either be
registry-backed or appear in the post body that already cleared review. A drafted
answer cannot introduce a figure the source page never made.
"""
import json, re, sys

MIGRATE = "--migrate" in sys.argv
if MIGRATE:
    sys.argv.remove("--migrate")
if len(sys.argv) < 3:
    sys.exit("usage: verify-faq-drafts.py [--migrate] <drafts.json> <candidates.json>")

REG = json.load(open("data/faq-fact-registry.json"))
drafts = json.load(open(sys.argv[1]))
cands = json.load(open(sys.argv[2]))

AUTH = REG["authorities"]
CITE_RE = re.compile(r'(?:O\.C\.G\.A\.|S\.C\.\s*Code(?:\s*Ann\.)?)\s*§+\s*([0-9][0-9A-Za-z\-.]*)')
CASE_RE = re.compile(r'\b([A-Z][A-Za-z]+ v\. [A-Z][A-Za-z. ]+?)(?:,|\s*\()')
WORDNUM = r'one|two|three|four|five|six|seven|eight|nine|ten|twelve|thirty|sixty|ninety'
# Spelled-out durations count as quantities too. "two years" on a workers' comp
# page is the exact shape of the 2026-07-30 incident, and a digits-only pattern
# reads straight past it.
NUM_RE  = re.compile(
    r'\$[\d,]+(?:\.\d+)?'
    r'|\b\d+(?:\.\d+)?\s*(?:%|percent)'
    r'|\b(?:\d+|' + WORDNUM + r')[- ]?(?:year|month|day|week)s?\b',
    re.I)
DUR_RE  = re.compile(r'^(?:\d+|' + WORDNUM + r')[- ]?(?:year|month|day|week)s?$', re.I)
MIN_A, MAX_A = 180, 500
MIN_N, MAX_N = 4, 8
WINDOW = 160  # chars either side of a citation that count as 'paired with' it

def cite_key(matched):
    """Map a matched citation back to its registry key.

    Keyed off the matched text itself, not the characters preceding it: the
    match already contains the "O.C.G.A." / "S.C. Code" prefix, and reading
    backwards from m.start() lands before that prefix and always answered SC.
    """
    st = "GA" if "O.C.G.A" in matched else "SC"
    sect = CITE_RE.search(matched).group(1)
    return f"{st} {sect.rstrip('.')}"

def strip_html(t):
    return re.sub(r'<[^>]+>', ' ', t)

fails, warns, checked = [], [], 0

for path, entries in drafts.items():
    src = cands.get(path)
    if not src:
        fails.append((path, "-", f"no source post in candidates file"))
        continue
    body = strip_html(src["content"]).lower()
    title_ctx = (src["title"] + " " + " ".join(src.get("categories") or [])).lower()

    # ---- 4. shape ----
    if not (MIN_N <= len(entries) <= MAX_N):
        fails.append((path, "-", f"{len(entries)} FAQs (house pattern is {MIN_N}-{MAX_N})"))

    seen_q = set()
    for i, e in enumerate(entries):
        checked += 1
        q, a = e.get("question", ""), e.get("answer", "")
        tag = f"#{i+1}"
        if set(e.keys()) - {"question", "answer"}:
            fails.append((path, tag, f"unexpected keys: {sorted(set(e.keys())-{'question','answer'})}"))
        if not q.rstrip().endswith("?"):
            fails.append((path, tag, "question does not end in '?'"))
        if q.lower() in seen_q:
            fails.append((path, tag, "duplicate question within post"))
        seen_q.add(q.lower())
        if not (MIN_A <= len(a) <= MAX_A):
            warns.append((path, tag, f"answer {len(a)} chars (house range {MIN_A}-{MAX_A})"))

        al = a.lower()
        ctx = (al + " " + title_ctx)
        # Is this answer already published verbatim in the post body? Migration of
        # existing on-page content does not introduce a new claim; authoring one does.
        norm = lambda t: re.sub(r"[^a-z0-9]+", " ", t.lower()).strip()
        na = norm(a)
        verbatim = len(na) > 60 and na[:120] in norm(body)

        # The documented recurring error: 15-38-15 given as the authority for the
        # PLAINTIFF's bar. Correct where it covers apportionment among defendants
        # AND Nelson carries the bar, so the discriminator is Nelson's presence.
        if "15-38-15" in a.replace(" ", "") and re.search(r"\b(bar|at fault|recover)\b", al):
            if "nelson" not in al:
                fails.append((path, tag, "S.C. Code 15-38-15 used where the plaintiff's bar is discussed without citing Nelson v. Concrete Supply Co."))

        # ---- 1. every citation must be in the registry ----
        cites_found = []
        for m in CITE_RE.finditer(a):
            key = cite_key(m.group(0))
            cites_found.append(key)
            if key not in AUTH:
                # In migration mode the test is narrower and more exact: is THIS
                # citation already published in the post body? Moving an existing
                # on-page citation into meta introduces no new claim, whereas
                # authoring one from recall does. Whole-answer verbatim matching
                # was too strict here - extraction normalises whitespace and tags,
                # so a correct migration failed on formatting rather than content.
                sect_in_body = MIGRATE and re.search(re.escape(key.split(" ", 1)[1]), body)
                if sect_in_body:
                    warns.append((path, tag, f"unregistered citation {key} (already published in this post's body)"))
                else:
                    fails.append((path, tag, f"UNREGISTERED citation: {key}"))
        for m in CASE_RE.finditer(a):
            nm = m.group(1).strip()
            if not any(nm.split(" v.")[0] in k for k in AUTH):
                warns.append((path, tag, f"case cite not in registry: {nm}"))
            else:
                cites_found.append(next(k for k in AUTH if nm.split(" v.")[0] in k))

        # ---- 2 + 3. forbidden contexts and quantity pairing ----
        for key in cites_found:
            spec = AUTH.get(key)
            if not spec:
                continue
            for bad in spec.get("forbidden_contexts", []):
                if bad in ctx:
                    fails.append((path, tag, f"{key} used in forbidden context '{bad}'"))
            allowed = [q.lower() for q in spec.get("quantities", [])]
            if allowed:
                # Durations near this citation, by CHARACTER WINDOW rather than
                # sentence. Splitting on /(?<=[.!?])\s+/ breaks inside the
                # citation itself - "O.C.G.A. § 34-9-82" is three "sentences" -
                # which parked the quantity and its citation in different
                # fragments and let "two years (O.C.G.A. § 34-9-82)" pass. Same
                # abbreviation trap documented in verify-statute-consistency.php.
                sect = key.split(" ", 1)[1]
                for sm in re.finditer(re.escape(sect), a):
                    lo, hi = max(0, sm.start() - WINDOW), min(len(a), sm.end() + WINDOW)
                    for qm in NUM_RE.findall(a[lo:hi]):
                        qn = qm.lower().strip()
                        if DUR_RE.match(qn) and not any(x in qn for x in allowed):
                            if MIGRATE and verbatim:
                                warns.append((path, tag, f"{key} near '{qm}' (already published in body)"))
                            else:
                                fails.append((path, tag, f"{key} paired with '{qm}' - registry allows {spec['quantities']}"))

        # ---- banned pairings ----
        for bp in REG["banned_pairings"]:
            if any(c in ctx for c in bp.get("if_context", [])):
                for fc in bp.get("forbid_cites", []) or []:
                    if fc.replace(" ", "") in a.replace(" ", ""):
                        fails.append((path, tag, f"BANNED PAIRING [{bp['pattern']}]: {fc}"))
                for fp in bp.get("forbid_phrases", []):
                    if fp in al:
                        fails.append((path, tag, f"BANNED PAIRING [{bp['pattern']}]: phrase '{fp}'"))

        # ---- 5. grounding: every number must be registry-backed or in the body ----
        registry_nums = set()
        for key in cites_found:
            for qv in AUTH.get(key, {}).get("quantities", []):
                registry_nums.add(qv.lower())
        for num in NUM_RE.findall(a):
            n = num.lower().strip()
            if n in registry_nums or any(n in rn or rn in n for rn in registry_nums):
                continue
            digits = re.sub(r'[^\d]', '', n)
            if digits and digits in re.sub(r'[^\d]', '', body):
                continue
            if n in body:
                continue
            fails.append((path, tag, f"UNGROUNDED figure '{num}' - not in registry and not in post body"))

print(f"posts: {len(drafts)}   faq entries: {checked}")
if warns:
    print(f"\n--- warnings ({len(warns)}) ---")
    for p, t, m in warns[:40]:
        print(f"  {t:<4} {m}\n       {p}")
if fails:
    print(f"\n--- FAILURES ({len(fails)}) ---")
    for p, t, m in fails:
        print(f"  {t:<4} {m}\n       {p}")
    sys.exit(1)
print("\nAll drafts pass.")
