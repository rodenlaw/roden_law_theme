#!/usr/bin/env python3
"""Build the per-URL performance inventory for rodenlaw.com. Read-only inputs."""
import csv, json, re, collections
from urllib.parse import urlsplit

S = "/private/tmp/claude-501/-Users-brianhaas-Code-blue-sky-studio-client-rodenlaw-website/e917fd50-6345-43fe-87e7-7a86e455c207/scratchpad"
OUT = S + "/sitemap"
RAW = OUT + "/raw"
REPO = "/Users/brianhaas/Code/blue-sky-studio/client-rodenlaw-website"

rows = json.load(open(S + "/doorway-rows.json"))
SITEMAP = {r["url"]: r for r in rows}

# ------------------------------------------------------------ url normalisation
def norm(u):
    p = urlsplit(u)
    path = p.path or "/"
    if not path.endswith("/") and "." not in path.rsplit("/", 1)[-1]:
        path += "/"
    host = p.netloc.lower()
    gbp = bool(p.query) and "gmb" in p.query.lower()
    variant = bool(p.query) or bool(p.fragment) or host != "rodenlaw.com"
    return path, variant, gbp, host

def load_pages(fn):
    agg = collections.defaultdict(lambda: {"c": 0, "i": 0, "pw": 0.0, "qc": 0, "qi": 0, "qpw": 0.0, "gbp": False, "raw": set()})
    for r in csv.DictReader(open(fn)):
        path, hasq, gbp, host = norm(r["page"])
        c, i, pos = int(r["clicks"]), int(r["impressions"]), float(r["position"])
        a = agg[path]
        a["raw"].add(r["page"])
        if hasq:
            a["qc"] += c; a["qi"] += i; a["qpw"] += pos * i
            if gbp: a["gbp"] = True
        else:
            a["c"] += c; a["i"] += i; a["pw"] += pos * i
    return agg

P16 = load_pages(RAW + "/pages16.csv")
P90 = load_pages(RAW + "/pages90.csv")
P30 = load_pages(RAW + "/pages30.csv")

def metrics(a):
    if not a:
        return dict(clicks=0, impressions=0, position=None, qs_clicks=0, qs_impressions=0)
    tot_i = a["i"]
    return dict(
        clicks=a["c"], impressions=a["i"],
        position=round(a["pw"] / tot_i, 1) if tot_i else None,
        qs_clicks=a["qc"], qs_impressions=a["qi"],
    )

# ------------------------------------------------------------ queries
def load_queries(fn):
    out = []
    for r in csv.DictReader(open(fn)):
        path, hasq, gbp, _ = norm(r["page"])
        out.append((path, hasq, r["query"], int(r["clicks"]), int(r["impressions"]), float(r["position"])))
    return out

Q90 = load_queries(RAW + "/q90.csv")
Q16 = load_queries(RAW + "/q16.csv")
Q30 = load_queries(RAW + "/q30.csv")
QPOST = load_queries(RAW + "/qpost.csv")

top_q = collections.defaultdict(lambda: collections.Counter())
top_q_pos = {}
for path, hasq, q, c, i, pos in Q90:
    top_q[path][q] += i
    k = (path, q)
    a = top_q_pos.setdefault(k, [0, 0.0, 0])
    a[0] += i; a[1] += pos * i; a[2] += c

# ------------------------------------------------------------ classification
PRACTICE_SLUGS = [
    ("rideshare", r"uber|lyft|rideshare"),
    ("truck", r"truck|18-wheeler|semi|tractor-trailer|commercial-vehicle"),
    ("motorcycle", r"motorcycle"),
    ("pedestrian", r"pedestrian"),
    ("bicycle", r"bicycle|bike|cyclist"),
    ("wrongful_death", r"wrongful-death|fatal"),
    ("workers_comp", r"workers-comp|work-comp|workplace"),
    ("premises", r"slip-and-fall|premises|slip|trip-and-fall"),
    ("dog_bite", r"dog-bite|dog"),
    ("med_mal", r"malpractice|hipaa|hospital-negligence|misdiagnos|surgical"),
    ("car", r"car-accident|auto|rear-end|t-bone|intersection|underinsured|uninsured|hit-and-run|drunk-driv|distracted|highway|i-26|i-95|i-16|i-526|road|avenue|street|boulevard|crash|wreck|collision"),
    ("generic_pi", r"personal-injury|injury-lawyer|accident-lawyer"),
]

def practice_of(url):
    u = url.lower()
    for name, rx in PRACTICE_SLUGS:
        if re.search(rx, u):
            return name
    return None

PLACE_MARKET = {
    "savannah": "Savannah GA", "pooler": "Savannah GA", "richmond-hill": "Savannah GA",
    "darien": "Darien GA", "brunswick": "Darien GA", "mcintosh": "Darien GA",
    "charleston": "Charleston SC", "mount-pleasant": "Charleston SC", "ravenel": "Charleston SC",
    "folly-road": "Charleston SC", "king-street": "Charleston SC", "johns-island": "Charleston SC",
    "maybank-highway": "Charleston SC", "daniel-island": "Charleston SC", "sullivans-island": "Charleston SC",
    "calhoun": "Charleston SC", "west-ashley": "Charleston SC",
    "north-charleston": "North Charleston SC", "ashley-phosphate": "North Charleston SC",
    "ladson": "North Charleston SC", "dorchester": "North Charleston SC", "summerville": "North Charleston SC",
    "goose-creek": "North Charleston SC", "aviation-avenue": "North Charleston SC", "access-road": "North Charleston SC",
    "rivers-avenue": "North Charleston SC",
    "columbia": "Columbia SC", "blythewood": "Columbia SC", "lexington": "Columbia SC",
    "myrtle-beach": "Myrtle Beach SC", "conway": "Myrtle Beach SC", "surfside-beach": "Myrtle Beach SC",
    "georgetown": "Myrtle Beach SC", "murrells-inlet": "Myrtle Beach SC",
}

def market_of(url, place):
    u = url.lower()
    if "north-charleston" in u:
        return "North Charleston SC"
    if place and place in PLACE_MARKET:
        return PLACE_MARKET[place]
    for k in sorted(PLACE_MARKET, key=len, reverse=True):
        if re.search(r"(^|[/-])" + re.escape(k) + r"([/-]|$)", u):
            return PLACE_MARKET[k]
    if "georgia" in u or re.search(r"-ga/", u):
        return "statewide GA"
    if "south-carolina" in u or re.search(r"-sc/", u):
        return "statewide SC"
    return "none"

def page_type(url):
    u = url[3:] if url.startswith("/es/") else url
    if url.startswith("/es") and u in ("", "/"):
        u = "/"
    if u == "/":
        return "home"
    parts = [p for p in u.split("/") if p]
    head = parts[0]
    if head == "practice-areas":
        return "practice_hub" if len(parts) == 1 else "pillar"
    if head == "locations":
        return {1: "locations_index", 2: "state_hub"}.get(len(parts), "location_hub")
    if head == "resources":
        return "resource_index" if len(parts) == 1 else "resource"
    if head == "blog":
        return "blog_index" if len(parts) == 1 else "blog"
    if head == "case-results":
        return "case_results"
    if head == "attorneys":
        return "attorney"
    if head.startswith("south-carolina-") or head.startswith("georgia-"):
        return "state_practice"
    if head == "class-action-lawyers":
        return "pillar" if len(parts) == 1 else "subtype"
    if head.endswith("-lawyers") and len(parts) == 2:
        return "subtype"
    return "about_contact_other"

def status(m16, m90):
    c90, i90, p90 = m90["clicks"], m90["impressions"], m90["position"]
    if c90 >= 10 or (p90 is not None and p90 <= 10 and i90 >= 500):
        return "WINNER"
    if p90 is not None and 10 < p90 <= 20 and i90 >= 300:
        return "PROMISING"
    if m16["clicks"] == 0 and i90 < 100:
        return "DEAD"
    return "OK"

def with_gbp(a):
    return bool(a and a["gbp"])

inventory = []
for r in rows:
    url = r["url"]
    lang = "es" if url.startswith("/es/") or url == "/es/" else "en"
    base = page_type(url)
    m16, m90 = metrics(P16.get(url)), metrics(P90.get(url))
    tq = []
    for q, i in top_q[url].most_common(3):
        a = top_q_pos[(url, q)]
        tq.append({"query": q, "impressions": i, "clicks": a[2], "position": round(a[1] / a[0], 1) if a[0] else None})
    inventory.append({
        "url": url,
        "page_type": "es_twin" if lang == "es" else base,
        "base_type": base,
        "language": lang,
        "geo": r["geo"], "belowFloor": r["belowFloor"], "place": r["place"],
        "market": market_of(url, r["place"]),
        "practice": practice_of(url),
        "clicks16": m16["clicks"], "impr16": m16["impressions"], "pos16": m16["position"],
        "clicks90": m90["clicks"], "impr90": m90["impressions"], "pos90": m90["position"],
        "variant_clicks16": m16["qs_clicks"], "variant_impr16": m16["qs_impressions"],
        "variant_clicks90": m90["qs_clicks"], "variant_impr90": m90["qs_impressions"],
        "gbp_landing": with_gbp(P16.get(url)),
        "top_queries90": tq,
        "status": status(m16, m90),
    })

json.dump(inventory, open(OUT + "/inventory.json", "w"), indent=1)
with open(OUT + "/inventory.csv", "w", newline="") as f:
    cols = [k for k in inventory[0] if k != "top_queries90"] + ["top_queries90"]
    w = csv.DictWriter(f, fieldnames=cols)
    w.writeheader()
    for row in inventory:
        rr = dict(row)
        rr["top_queries90"] = " | ".join(f'{q["query"]} ({q["impressions"]})' for q in row["top_queries90"])
        w.writerow(rr)

# ------------------------------------------------------------ retired URLs
php = open(REPO + "/wordpress/wp-content/themes/roden-law/inc/legacy-redirects.php").read()
RMAP = {}
for a, b in re.findall(r"'(/[^']*)'\s*=>\s*'(/[^']*)'", php):
    RMAP.setdefault(a if a.endswith("/") else a + "/", b)
for a in re.findall(r"'(/[^']*)'\s*=>\s*false", php):
    RMAP.setdefault(a, "410 GONE")
TRIAGE = {}
for r in csv.DictReader(open(REPO + "/url-triage.csv")):
    p = urlsplit(r["url"]).path
    TRIAGE[p] = r
    if r["redirect_target"] and p not in RMAP:
        RMAP[p] = r["redirect_target"]

def canon_pa(p):
    m = re.match(r"^(/es)?/practice-areas/([a-z0-9-]+-lawyers)/([^/]+)/$", p)
    return f"{m.group(1) or ''}/{m.group(2)}/{m.group(3)}/" if m else p

def resolve(p):
    hops, cur, how = [], p, None
    for _ in range(6):
        nxt = None
        if cur in RMAP:
            nxt = RMAP[cur]; how = how or "map"
        elif canon_pa(cur) != cur:
            nxt = canon_pa(cur); how = how or "nested-pa"
        elif re.match(r"^/(blog/)?case-results?/[^/]+/$", cur):
            nxt = "/case-results/"; how = how or "case-result pattern"
        elif re.match(r"^/class-action-lawyers/[^/]+/[^/]+/$", cur):
            nxt = "/class-action-lawyers/"; how = how or "pattern"
        elif re.match(r"^/staff/", cur):
            nxt = "/attorneys/"; how = how or "pattern"
        if not nxt:
            m = re.match(r"^(/es)?/([a-z0-9-]+-lawyers)/[a-z0-9-]+-(ga|sc)/$", cur)
            if m and cur not in SITEMAP and hops:
                nxt = f"{m.group(1) or ''}/practice-areas/{m.group(2)}/"; how = how + "+fallback"
        if not nxt or nxt == "410 GONE":
            if nxt == "410 GONE":
                hops.append(nxt)
            break
        nxt = nxt.split("#")[0] if nxt.startswith("/case-results/") else nxt
        hops.append(nxt); cur = nxt
        if cur in SITEMAP:
            break
    return (hops[-1] if hops else None), how, len(hops)

retired = []
for path, a in P30.items():
    if path in SITEMAP:
        continue
    tot_i = a["i"] + a["qi"]
    if tot_i == 0:
        continue
    tgt, how, n = resolve(path)
    tr = TRIAGE.get(path)
    tq = [f"{q} ({i})" for q, i in top_q[path].most_common(3)]
    retired.append({
        "url": path, "impr30": tot_i, "clicks30": a["c"] + a["qc"],
        "pos30": round((a["pw"] + a["qpw"]) / tot_i, 1),
        "impr90": (P90.get(path) or {"i": 0, "qi": 0})["i"] + (P90.get(path) or {"i": 0, "qi": 0})["qi"],
        "clicks16": (P16.get(path) or {"c": 0, "qc": 0})["c"] + (P16.get(path) or {"c": 0, "qc": 0})["qc"],
        "param_or_gbp_only": a["i"] == 0,
        "redirect_target": tgt, "resolved_by": how, "hops": n,
        "target_in_sitemap": bool(tgt and tgt in SITEMAP),
        "triage_class": tr["classification"] if tr else None,
        "top_queries90": tq,
    })
LIVE = {}
for line in open(RAW + "/check-results.txt"):
    parts = line.split()
    if len(parts) >= 2:
        LIVE[parts[0]] = (parts[1], parts[2] if len(parts) > 2 else "")
LIVE["/brunswick/personal-injury-lawyer/"] = ("301", "https://rodenlaw.com/practice-areas/personal-injury-lawyers/")
for r in retired:
    r["kind"] = "retired/redirected"; r["live_check_2026_09_26"] = None
    if r["url"] in LIVE:
        code, loc = LIVE[r["url"]]
        r["live_check_2026_09_26"] = code
        if code == "301":
            r["redirect_target"] = urlsplit(loc).path; r["resolved_by"] = "live check"
            r["target_in_sitemap"] = r["redirect_target"] in SITEMAP
        elif code == "200":
            r["kind"] = "live but not in sitemap (index/archive/testimonial/other)"
        elif code == "404":
            r["kind"] = "404"
retired.sort(key=lambda r: -r["impr30"])
json.dump(retired, open(OUT + "/retired-with-impressions.json", "w"), indent=1)
with open(OUT + "/retired-with-impressions.csv", "w", newline="") as f:
    w = csv.DictWriter(f, fieldnames=list(retired[0].keys()))
    w.writeheader()
    for r in retired:
        rr = dict(r); rr["top_queries90"] = " | ".join(r["top_queries90"]); w.writerow(rr)

# ------------------------------------------------------------ query clusters
MARKET_TERMS = [
    ("North Charleston SC", r"north charleston|n\.? charleston|goose creek|summerville|ladson|hanahan|moncks corner|ashley phosphate|rivers ave"),
    ("Charleston SC", r"charleston|mount pleasant|mt\.? pleasant|west ashley|james island|johns island|daniel island|folly beach|sullivans? island|isle of palms|kiawah|ravenel|downtown chs|\bchs\b"),
    ("Columbia SC", r"columbia|lexington|irmo|cayce|blythewood|forest acres|chapin|richland county|lexington county"),
    ("Myrtle Beach SC", r"myrtle beach|conway|murrells inlet|surfside|garden city sc|georgetown|little river|horry|carolina forest|socastee|pawleys"),
    ("Savannah GA", r"savannah|pooler|richmond hill|rincon|tybee|effingham|hinesville|chatham county|port wentworth|bloomingdale|wilmington island|isle of hope|garden city ga"),
    ("Darien GA", r"darien|brunswick|st\.? simons|saint simons|jekyll|mcintosh|glynn|jesup|kingsland|st\.? marys|ludowici"),
    ("statewide SC", r"south carolina|\bsc\b|s\.c\.|carolina del sur"),
    ("statewide GA", r"georgia|\bga\b"),
]
PRACTICE_TERMS = [
    ("rideshare", r"uber|lyft|rideshare|ride share"),
    ("truck", r"truck|18 wheeler|18-wheeler|semi\b|tractor trailer|big rig|commercial vehicle|cami[oó]n"),
    ("motorcycle", r"motorcycle|motorbike|motocicleta"),
    ("pedestrian", r"pedestrian|peat[oó]n|hit by a car"),
    ("x_golf_cart", r"golf cart"),
    ("x_atv_utv", r"\batv\b|utv|side by side|side-by-side"),
    ("x_scooter", r"scooter"),
    ("bicycle", r"bicycle|bike|cyclist|bicicleta"),
    ("x_boating", r"boat|jet ski|watercraft|pwc"),
    ("wrongful_death", r"wrongful death|muerte"),
    ("workers_comp", r"workers'? ?comp|workman|work comp|workmans|worker'?s comp|on the job injur|workplace injur|work injur|compensaci[oó]n"),
    ("premises", r"slip|trip and fall|premises|resbal|ca[ií]da"),
    ("dog_bite", r"dog|animal bite|mordedura"),
    ("med_mal", r"malpractice|medical negligence|misdiagnos|surgical error|birth injur|hipaa|hospital negligence|negligencia m[eé]dica"),
    ("x_nursing_home", r"nursing home|elder abuse"),
    ("x_brain_spinal", r"brain|tbi|spinal|paraly"),
    ("x_burn", r"burn"),
    ("x_product_masstort", r"product liab|defective|class action|lawsuit|recall|ozempic|roundup|camp lejeune|paraquat|talc|hair relaxer|afff|ivc|troubled teen"),
    ("x_maritime", r"maritime|jones act|longshore|cruise|offshore"),
    ("x_construction", r"construction"),
    ("car", r"\bcar\b|auto|vehicle|wreck|collision|crash|rear end|t-bone|hit and run|dui|drunk driv|carro|coche|uninsured|underinsured"),
    ("generic_pi", r"personal injury|injury (lawyer|attorney|law)|accident (lawyer|attorney|law)|lesiones|abogado de accidente"),
]
COMMERCIAL = re.compile(r"lawyer|attorney|law firm|abogad|legal help|near me|firm")
BRAND = re.compile(r"roden|rodenlaw|site:")

def bucket_market(q):
    for name, rx in MARKET_TERMS:
        if re.search(rx, q):
            return name
    return "none"

def bucket_practice(q):
    if BRAND.search(q):
        return "brand"
    for name, rx in PRACTICE_TERMS:
        if re.search(rx, q):
            return name
    return "other"

def newagg():
    return {"i": 0, "c": 0, "pw": 0.0, "best": None, "ci": 0, "cc": 0, "cpw": 0.0, "cbest": None,
            "urls": collections.Counter(), "curls": collections.Counter(), "qs": collections.Counter(),
            "cqs": collections.Counter(), "gbp_i": 0}

def agg_queries(Q):
    cl = collections.defaultdict(newagg)
    for path, hasq, q, c, i, pos in Q:
        ql = q.lower()
        a = cl[(bucket_market(ql), bucket_practice(ql))]
        a["i"] += i; a["c"] += c; a["pw"] += pos * i
        if i >= 10:
            a["best"] = pos if a["best"] is None else min(a["best"], pos)
        path = path + "?[param/GBP]" if hasq else path
        a["urls"][path] += i; a["qs"][q] += i
        if hasq:
            a["gbp_i"] += i
        if COMMERCIAL.search(ql):
            a["ci"] += i; a["cc"] += c; a["cpw"] += pos * i
            if i >= 10:
                a["cbest"] = pos if a["cbest"] is None else min(a["cbest"], pos)
            a["curls"][path] += i; a["cqs"][q] += i
    return cl

CL16, CL90, CL30, CLPOST = agg_queries(Q16), agg_queries(Q90), agg_queries(Q30), agg_queries(QPOST)

# live page coverage per market x practice: dedicated (hub/subtype/state page) vs partial (blog/resource)
dedicated, partial = collections.defaultdict(list), collections.defaultdict(list)
for row in inventory:
    if row["language"] != "en":
        continue
    mk, pr, bt = row["market"], row["practice"], row["base_type"]
    if bt == "location_hub" and mk != "none":
        dedicated[(mk, "generic_pi")].append(row["url"])
    if row["url"] == "/south-carolina-personal-injury-lawyer/":
        dedicated[("statewide SC", "generic_pi")].append(row["url"])
    if bt == "state_hub":
        dedicated[("statewide GA" if "georgia" in row["url"] else "statewide SC", "generic_pi")].append(row["url"])
    if pr and mk != "none":
        (dedicated if bt in ("subtype", "state_practice", "location_hub") else partial)[(mk, pr)].append(row["url"])

def url_share(counter, total, n=5, live_only=False):
    out = []
    for u, i in counter.most_common():
        if live_only and u not in SITEMAP:
            continue
        out.append({"url": u, "impressions": i, "share": round(i / total, 3) if total else 0, "in_sitemap": u.split("?")[0] in SITEMAP})
        if len(out) >= n:
            break
    return out

clusters = []
for k in set(CL16) | set(CL90):
    mk, pr = k
    a, b = CL16.get(k) or newagg(), CL90.get(k) or newagg()
    t, pz = CL30.get(k) or newagg(), CLPOST.get(k) or newagg()
    # cannibalization: last 30 days, commercial queries, live URLs (canonical form, GBP-param rows excluded)
    # each holding >=15% of the cluster's live-URL impressions and >=30 impressions
    live30 = sum(i for u, i in t["curls"].items() if u in SITEMAP)
    sig = [u for u in url_share(t["curls"], live30, 50, live_only=True) if u["share"] >= 0.15 and u["impressions"] >= 30]
    clusters.append({
        "market": mk, "practice": pr,
        "impressions16": a["i"], "clicks16": a["c"],
        "avg_pos16": round(a["pw"] / a["i"], 1) if a["i"] else None, "best_pos16": a["best"],
        "commercial_impressions16": a["ci"], "commercial_clicks16": a["cc"],
        "commercial_avg_pos16": round(a["cpw"] / a["ci"], 1) if a["ci"] else None,
        "commercial_best_pos16": a["cbest"],
        "commercial_impressions90": b["ci"], "commercial_clicks90": b["cc"],
        "commercial_avg_pos90": round(b["cpw"] / b["ci"], 1) if b["ci"] else None,
        "param_url_impressions16": a["gbp_i"],
        "receiving_urls_commercial16": url_share(a["curls"], a["ci"], 6),
        "receiving_urls_commercial90": url_share(b["curls"], b["ci"], 6),
        "commercial_impressions30": t["ci"], "commercial_clicks30": t["cc"],
        "commercial_avg_pos30": round(t["cpw"] / t["ci"], 1) if t["ci"] else None,
        "live_url_impressions30": live30,
        "post_retirement_0920_0924_commercial_impressions": pz["ci"],
        "post_retirement_0920_0924_avg_pos": round(pz["cpw"] / pz["ci"], 1) if pz["ci"] else None,
        "post_retirement_0920_0924_receivers": url_share(pz["curls"], pz["ci"], 5),
        "distinct_urls_commercial30": len(t["curls"]),
        "cannibalization30": len(sig) >= 2,
        "cannibalizing_urls30": [f'{u["url"]} ({u["share"]:.0%})' for u in sig] if len(sig) >= 2 else [],
        "dedicated_live_pages": sorted(set(dedicated.get(k, []))),
        "partial_live_pages": sorted(set(partial.get(k, [])))[:10],
        "top_commercial_queries16": [f"{q} ({i})" for q, i in a["cqs"].most_common(5)],
        "top_queries16": [f"{q} ({i})" for q, i in a["qs"].most_common(5)],
    })
clusters.sort(key=lambda c: -c["commercial_impressions16"])
json.dump(clusters, open(OUT + "/query-clusters.json", "w"), indent=1)
with open(OUT + "/query-clusters.csv", "w", newline="") as f:
    cols = ["market", "practice", "commercial_impressions16", "commercial_clicks16", "commercial_avg_pos16", "commercial_best_pos16",
            "commercial_impressions90", "commercial_clicks90", "commercial_avg_pos90",
            "impressions16", "clicks16", "avg_pos16", "best_pos16", "param_url_impressions16",
            "commercial_impressions30", "commercial_avg_pos30", "live_url_impressions30", "post_retirement_0920_0924_commercial_impressions", "post_retirement_0920_0924_avg_pos", "post_retirement_0920_0924_receivers", "distinct_urls_commercial30", "cannibalization30", "cannibalizing_urls30", "dedicated_live_pages", "partial_live_pages",
            "receiving_urls_commercial16", "receiving_urls_commercial90", "top_commercial_queries16"]
    w = csv.DictWriter(f, fieldnames=cols, extrasaction="ignore")
    w.writeheader()
    fmt = lambda L: " | ".join(f'{u["url"]} {u["share"]:.0%}{"" if u["in_sitemap"] else " [retired]"}' for u in L)
    for c in clusters:
        rr = dict(c)
        for k2 in ("cannibalizing_urls30", "dedicated_live_pages", "partial_live_pages", "top_commercial_queries16"):
            rr[k2] = " | ".join(c[k2])
        rr["receiving_urls_commercial16"] = fmt(c["receiving_urls_commercial16"])
        rr["receiving_urls_commercial90"] = fmt(c["receiving_urls_commercial90"])
        rr["post_retirement_0920_0924_receivers"] = fmt(c["post_retirement_0920_0924_receivers"])
        w.writerow(rr)

# totals sanity
print("pages16 total", sum(a["c"] for a in P16.values()), sum(a["i"] for a in P16.values()))
print("q16 total", sum(r[3] for r in Q16), sum(r[4] for r in Q16))
print("inventory", len(inventory), collections.Counter(r["status"] for r in inventory))
print("retired", len(retired), sum(r["impr30"] for r in retired))
