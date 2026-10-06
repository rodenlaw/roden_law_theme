#!/usr/bin/env python3
"""Freshness-loop benchmark: refreshed blog posts vs the never-refreshed control.

Baseline: docs/gsc-2026-10-06/ (16 months to 2026-10-03, sc-domain:rodenlaw.com).
Cohorts are frozen in docs/gsc-2026-10-06/cohorts.json — refreshed = the 79 queue posts
live with _roden_last_reviewed >= 2026-09-23; control = the 279 live EN posts never queued.
Do not rebuild the cohorts from a later content/meta.json: later edits would move posts
between groups and the comparison would stop being like-for-like.

Usage (checkpoint):
    ~/.venvs/google-ads/bin/python bin/freshness-benchmark.py --post 2026-10-15 2026-11-11
    ~/.venvs/google-ads/bin/python bin/freshness-benchmark.py --post 2026-10-15 2026-11-11 --pull

--pull fetches blog page x date for the post window (domain property, dataState final) into
the --cache file; without it the cached file is read. The baseline window is fixed to the 28
days before the September 2026 spam update began (2026-08-27 → 2026-09-23); per-post rows also
show each post's own 28 days before its refresh.
"""
import argparse, collections, csv, datetime as dt, gzip, importlib.util, json, pathlib, sys
from urllib.parse import urlparse

ROOT = pathlib.Path(__file__).resolve().parent.parent
BASE = ROOT / "docs" / "gsc-2026-10-06"
GSC = pathlib.Path.home() / "Code/blue-sky-studio/internal-ai-scripts/scripts/seo/gsc-fetch.py"
SITE = "sc-domain:rodenlaw.com"
BASELINE = (dt.date(2026, 8, 27), dt.date(2026, 9, 23))
D = dt.date.fromisoformat


def norm(u):
    p = urlparse(u).path
    return p if p.endswith("/") else p + "/"


def load(rows, into):
    for r in rows:
        x = into[norm(r["page"])][D(r["date"])]
        i = int(r["impressions"])
        x[0] += int(r["clicks"]); x[1] += i; x[2] += float(r["position"]) * i


def pull(start, end, out):
    spec = importlib.util.spec_from_file_location("g", GSC)
    g = importlib.util.module_from_spec(spec); spec.loader.exec_module(g)
    s = g.session()
    rows = g.query(s, SITE, start, end, ["page", "date"],
                   filters=[{"dimension": "page", "operator": "includingRegex", "expression": "/blog/"}])
    with open(out, "w", newline="") as f:
        w = csv.writer(f); w.writerow(["page", "date", "clicks", "impressions", "ctr", "position"])
        for r in rows:
            w.writerow(r["keys"] + [r["clicks"], r["impressions"], r["ctr"], r["position"]])
    print(f"pulled {len(rows)} rows -> {out}", file=sys.stderr)


def win(days, a, b):
    c = i = p = 0
    for d, x in days.items():
        if a <= d <= b:
            c += x[0]; i += x[1]; p += x[2]
    return c, i, (p / i if i else None)


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--post", nargs=2, required=True, metavar=("START", "END"))
    ap.add_argument("--pull", action="store_true")
    ap.add_argument("--cache", default="/tmp/roden-blog-page-date-post.csv")
    ap.add_argument("--out", help="per-post CSV")
    a = ap.parse_args()
    ps, pe = D(a.post[0]), D(a.post[1])
    if a.pull:
        pull(a.post[0], a.post[1], a.cache)

    bd = collections.defaultdict(lambda: collections.defaultdict(lambda: [0, 0, 0.0]))
    with gzip.open(BASE / "blog_page_date.csv.gz", "rt") as f:
        load(csv.DictReader(f), bd)
    post = collections.defaultdict(lambda: collections.defaultdict(lambda: [0, 0, 0.0]))
    with open(a.cache) as f:
        load(csv.DictReader(f), post)

    co = json.loads((BASE / "cohorts.json").read_text())
    ref = {u: D(d) for u, d in co["refreshed"].items()}
    groups = {
        "refreshed 09-23..25": [u for u, d in ref.items() if d <= D("2026-09-25")],
        "refreshed 10-02..05": [u for u, d in ref.items() if d >= D("2026-10-02")],
        "all refreshed": list(ref),
        "control (never refreshed)": co["control"],
    }
    nb, npd = (BASELINE[1] - BASELINE[0]).days + 1, (pe - ps).days + 1
    print(f"baseline {BASELINE[0]}..{BASELINE[1]} ({nb}d)  vs  post {ps}..{pe} ({npd}d), per day\n")
    print(f"{'group':28} {'n':>3}  {'clk/d':>6} {'impr/d':>7} {'pos':>5}  ->  {'clk/d':>6} {'impr/d':>7} {'pos':>5}  {'clk%':>6} {'impr%':>6}")
    for name, us in groups.items():
        b = [win(bd.get(u, {}), *BASELINE) for u in us]
        p = [win(post.get(u, {}), ps, pe) for u in us]
        bc, bi = sum(x[0] for x in b), sum(x[1] for x in b)
        pc, pi = sum(x[0] for x in p), sum(x[1] for x in p)
        bp = sum((x[2] or 0) * x[1] for x in b) / bi if bi else 0
        pp = sum((x[2] or 0) * x[1] for x in p) / pi if pi else 0
        dc = 100 * (pc / npd) / (bc / nb) - 100 if bc else float("nan")
        di = 100 * (pi / npd) / (bi / nb) - 100 if bi else float("nan")
        print(f"{name:28} {len(us):3d}  {bc/nb:6.1f} {bi/nb:7.0f} {bp:5.1f}  ->  {pc/npd:6.1f} {pi/npd:7.0f} {pp:5.1f}  {dc:+6.0f} {di:+6.0f}")
    print("\nRead the refreshed rows against the control row: the difference is the refresh effect;"
          "\nthe control's own change is the update/seasonality everyone got.")

    if a.out:
        with open(a.out, "w", newline="") as f:
            w = csv.writer(f)
            w.writerow(["url", "refreshed", "pre28_clicks", "pre28_impr", "pre28_pos",
                        "post_clicks_per28", "post_impr_per28", "post_pos"])
            for u, rd in sorted(ref.items(), key=lambda kv: kv[1]):
                b = win(bd.get(u, {}), rd - dt.timedelta(28), rd - dt.timedelta(1))
                p = win(post.get(u, {}), ps, pe)
                w.writerow([u, rd, b[0], b[1], round(b[2], 1) if b[2] else "",
                            round(p[0] * 28 / npd, 1), round(p[1] * 28 / npd), round(p[2], 1) if p[2] else ""])
        print(f"per-post -> {a.out}")


if __name__ == "__main__":
    main()
