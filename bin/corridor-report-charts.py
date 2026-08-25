#!/usr/bin/env python3
"""
Charts for the I-26/I-95 Corridor Report — inline SVG, generated from the same
stats file as the prose so the two cannot drift apart.

    python3 bin/corridor-report-charts.py --stats research/corridor-report-stats.json \
        --out research/

Inline SVG rather than an image or a chart library, for three reasons. The theme
has no charting dependency and this report should not add one. An <img> would put
the report's central finding in a file that screen readers and text extractors
cannot read. And an embeddable chart that a journalist can view-source is more
useful than a PNG.

Colours are set from CSS custom properties with literal fallbacks, so the charts
follow the site's palette where it defines one and still render standalone.
"""
import argparse, json

def bar_chart(segments, out):
    W, BAR_H, GAP, LEFT, TOP = 720, 34, 18, 132, 56
    H = TOP + len(segments) * (BAR_H + GAP) + 46
    mx = max(s['pct'] for s in segments)
    scale = (W - LEFT - 90) / mx
    p = [f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {W} {H}" role="img" '
         f'aria-labelledby="ccTitle ccDesc" style="max-width:100%;height:auto;font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif">',
         '<title id="ccTitle">Share of fatal crashes involving a large truck, by corridor segment</title>',
         '<desc id="ccDesc">' + '; '.join(f"{s['label']} {s['pct']} percent of {s['crashes']} fatal crashes" for s in segments) +
         '. Source: NHTSA FARS 2020 to 2024.</desc>',
         f'<text x="0" y="22" font-size="15" font-weight="700" fill="var(--roden-text,#111)">Fatal crashes involving a large truck, 2020&#8211;2024</text>',
         f'<text x="0" y="41" font-size="12.5" fill="var(--roden-muted,#555)">Share of all fatal crashes on each corridor segment</text>']
    for i, s in enumerate(segments):
        y = TOP + i * (BAR_H + GAP)
        w = s['pct'] * scale
        fill = 'var(--roden-accent,#0b5c8a)' if i == 0 else 'var(--roden-bar,#7aa8bf)'
        p.append(f'<text x="{LEFT-12}" y="{y+22}" text-anchor="end" font-size="13.5" fill="var(--roden-text,#111)">{s["label"]}</text>')
        p.append(f'<rect x="{LEFT}" y="{y}" width="{w:.1f}" height="{BAR_H}" fill="{fill}" rx="3"/>')
        p.append(f'<text x="{LEFT+w+10:.1f}" y="{y+22}" font-size="13.5" font-weight="600" fill="var(--roden-text,#111)">{s["pct"]}%</text>')
        p.append(f'<text x="{LEFT+w+62:.1f}" y="{y+22}" font-size="12" fill="var(--roden-muted,#666)">{s["truck"]} of {s["crashes"]}</text>')
    p.append(f'<text x="0" y="{H-12}" font-size="11.5" fill="var(--roden-muted,#666)">Source: NHTSA Fatality Analysis Reporting System, 2020&#8211;2024 annual files. Fatal crashes only.</text>')
    p.append('</svg>')
    open(out, 'w').write('\n'.join(p))
    return '\n'.join(p)


def year_chart(by_year, out):
    W, H, LEFT, BOT, TOP = 720, 300, 44, 46, 52
    years = sorted(by_year)
    mx = max(v['crashes'] for v in by_year.values())
    bw = (W - LEFT - 20) / len(years)
    p = [f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {W} {H}" role="img" '
         f'aria-labelledby="yrTitle yrDesc" style="max-width:100%;height:auto;font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif">',
         '<title id="yrTitle">Fatal crashes per year on I-26 and I-95 in Georgia and South Carolina</title>',
         '<desc id="yrDesc">' + '; '.join(f"{y}: {by_year[y]['crashes']} fatal crashes, {by_year[y]['truck_crashes']} involving a large truck" for y in years) + '.</desc>',
         '<text x="0" y="22" font-size="15" font-weight="700" fill="var(--roden-text,#111)">Fatal crashes per year, I-26 and I-95 (GA + SC)</text>',
         '<text x="0" y="41" font-size="12.5" fill="var(--roden-muted,#555)">Darker segment: at least one large truck involved</text>']
    for i, y in enumerate(years):
        v = by_year[y]
        x = LEFT + i * bw + bw * 0.18
        w = bw * 0.64
        h = (v['crashes'] / mx) * (H - TOP - BOT)
        th = (v['truck_crashes'] / mx) * (H - TOP - BOT)
        p.append(f'<rect x="{x:.1f}" y="{H-BOT-h:.1f}" width="{w:.1f}" height="{h:.1f}" fill="var(--roden-bar,#c3d7e2)" rx="2"/>')
        p.append(f'<rect x="{x:.1f}" y="{H-BOT-th:.1f}" width="{w:.1f}" height="{th:.1f}" fill="var(--roden-accent,#0b5c8a)" rx="2"/>')
        p.append(f'<text x="{x+w/2:.1f}" y="{H-BOT-h-8:.1f}" text-anchor="middle" font-size="12.5" font-weight="600" fill="var(--roden-text,#111)">{v["crashes"]}</text>')
        p.append(f'<text x="{x+w/2:.1f}" y="{H-BOT+18:.1f}" text-anchor="middle" font-size="12.5" fill="var(--roden-muted,#555)">{y}</text>')
    p.append(f'<text x="0" y="{H-10}" font-size="11.5" fill="var(--roden-muted,#666)">Source: NHTSA Fatality Analysis Reporting System. Fatal crashes only; 2024 file may be revised.</text>')
    p.append('</svg>')
    open(out, 'w').write('\n'.join(p))
    return '\n'.join(p)


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument('--stats', required=True)
    ap.add_argument('--out', default='research')
    a = ap.parse_args()
    st = json.load(open(a.stats))
    segs = [dict(label=k, pct=v['truck_share_pct'], truck=v['truck_crashes'], crashes=v['crashes'])
            for k, v in sorted(st['by_segment'].items(), key=lambda kv: -kv[1]['truck_share_pct'])]
    bar_chart(segs, f'{a.out}/chart-truck-share.svg')
    year_chart({int(k): v for k, v in st['by_year'].items()}, f'{a.out}/chart-by-year.svg')
    print(f"wrote {a.out}/chart-truck-share.svg and {a.out}/chart-by-year.svg")

if __name__ == '__main__':
    main()
