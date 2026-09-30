#!/usr/bin/env python3
"""
Charts for Study #2 (state truck-crash deaths, 2020-2024) — inline SVG generated
from the same stats files as the prose, so the two cannot drift apart.

    python3 bin/truck-study-charts.py --stats research/ga-truck-study-stats.json \
        research/sc-truck-study-stats.json --out research/ \
        --theme-dir wordpress/wp-content/themes/roden-law/assets/charts

Handled exactly as Study #1 (bin/corridor-report-charts.py): the SVG is NEVER
written into post_content, because wp_kses_post() strips <svg> and the first save
by an editor without unfiltered_html would silently delete every chart. The page
body carries [roden_chart name="..."] shortcodes instead; inc/research-charts.php
reads the file from assets/charts/ at render time. --theme-dir writes the copies
the shortcode reads; the research/ copies are the reviewable originals.

Each state gets three charts, named <st>-truck-<chart>.svg:
    by-year     deaths in truck-involved fatal crashes per year
    who-died    those deaths by person type
    when        daytime and weekday shares, truck-involved vs other fatal crashes

Colours come from CSS custom properties with literal fallbacks (Study #1's
palette). Identity is never carried by colour alone: every bar is direct-labelled.
Each bar has a <title> child, which browsers show as a hover tooltip.
"""
import argparse, json, os

FONT = 'font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif'
TEXT, MUTED = 'var(--roden-text,#111)', 'var(--roden-muted,#555)'
ACCENT, BAR = 'var(--roden-accent,#0b5c8a)', 'var(--roden-bar,#4f93c4)'
SOURCE = ('Source: NHTSA Fatality Analysis Reporting System, 2020&#8211;2024 annual files. '
          'Fatal crashes only; 2024 file may be revised.')


def svg_open(cid, w, h, title, desc):
    return [f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {w} {h}" role="img" '
            f'aria-labelledby="{cid}T {cid}D" style="max-width:100%;height:auto;{FONT}">',
            f'<title id="{cid}T">{title}</title>', f'<desc id="{cid}D">{desc}</desc>']


def fmt(n):
    return f'{n:,}'


def by_year(st, cid):
    W, H, LEFT, BOT, TOP = 720, 320, 20, 66, 62
    ys = sorted(st['by_year'])
    mx = max(st['by_year'][y]['truck_deaths'] for y in ys)
    bw = (W - LEFT - 20) / len(ys)
    name = st['state_name']
    p = svg_open(cid, W, H, f'Deaths in truck-involved fatal crashes in {name}, by year, 2020 to 2024',
                 '; '.join(f"{y}: {st['by_year'][y]['truck_deaths']} deaths in {st['by_year'][y]['truck_crashes']} "
                           f"truck-involved fatal crashes, {st['by_year'][y]['truck_share_crashes_pct']} percent of "
                           f"all fatal crashes" for y in ys) + '. Source: NHTSA FARS.')
    p += [f'<text x="0" y="22" font-size="15" font-weight="700" fill="{TEXT}">Deaths in truck-involved fatal crashes, {name}</text>',
          f'<text x="0" y="41" font-size="12.5" fill="{MUTED}">Per year. Below each year: truck-involved crashes as a share of all fatal crashes</text>']
    for i, y in enumerate(ys):
        v = st['by_year'][y]
        x = LEFT + i * bw + bw * 0.2
        w = bw * 0.6
        h = v['truck_deaths'] / mx * (H - TOP - BOT)
        p.append(f'<rect x="{x:.1f}" y="{H-BOT-h:.1f}" width="{w:.1f}" height="{h:.1f}" fill="{ACCENT}" rx="3">'
                 f'<title>{y}: {v["truck_deaths"]} deaths, {v["truck_crashes"]} crashes</title></rect>')
        p.append(f'<text x="{x+w/2:.1f}" y="{H-BOT-h-8:.1f}" text-anchor="middle" font-size="13" font-weight="600" fill="{TEXT}">{v["truck_deaths"]}</text>')
        p.append(f'<text x="{x+w/2:.1f}" y="{H-BOT+18:.1f}" text-anchor="middle" font-size="12.5" fill="{TEXT}">{y}</text>')
        p.append(f'<text x="{x+w/2:.1f}" y="{H-BOT+35:.1f}" text-anchor="middle" font-size="11.5" fill="{MUTED}">{v["truck_share_crashes_pct"]}%</text>')
    p.append(f'<text x="0" y="{H-8}" font-size="11" fill="{MUTED}">{SOURCE}</text>')
    p.append('</svg>')
    return '\n'.join(p)


def hbars(cid, title, desc, heading, sub, rows, label_w=250):
    """rows: (label, value, value_label, fill)."""
    W, BAR_H, GAP, TOP = 720, 30, 14, 58
    H = TOP + len(rows) * (BAR_H + GAP) + 34
    mx = max(r[1] for r in rows)
    scale = (W - label_w - 130) / mx
    p = svg_open(cid, W, H, title, desc)
    p += [f'<text x="0" y="22" font-size="15" font-weight="700" fill="{TEXT}">{heading}</text>',
          f'<text x="0" y="41" font-size="12.5" fill="{MUTED}">{sub}</text>']
    for i, (label, val, vlab, fill) in enumerate(rows):
        y = TOP + i * (BAR_H + GAP)
        w = max(val * scale, 2)
        p.append(f'<text x="{label_w-12}" y="{y+20}" text-anchor="end" font-size="13" fill="{TEXT}">{label}</text>')
        p.append(f'<rect x="{label_w}" y="{y}" width="{w:.1f}" height="{BAR_H}" fill="{fill}" rx="3"><title>{label}: {vlab}</title></rect>')
        p.append(f'<text x="{label_w+w+10:.1f}" y="{y+20}" font-size="13" font-weight="600" fill="{TEXT}">{vlab}</text>')
    p.append(f'<text x="0" y="{H-8}" font-size="11" fill="{MUTED}">{SOURCE}</text>')
    p.append('</svg>')
    return '\n'.join(p)


def who_died(st, cid):
    d = st['deaths_by_person_type']
    name = st['state_name']
    rows = [('In other vehicles', 'other_vehicle_occupants'), ('In the large truck', 'truck_occupants'),
            ('Pedestrians', 'pedestrians'), ('Cyclists', 'cyclists'), ('Other people outside a vehicle', 'other_nonoccupants')]
    rows = [(lab, d[k]['deaths'], f"{fmt(d[k]['deaths'])} ({d[k]['pct']}%)", ACCENT if k != 'truck_occupants' else BAR)
            for lab, k in rows if d[k]['deaths'] > 0]
    return hbars(cid, f'Who died in truck-involved fatal crashes in {name}, 2020 to 2024',
                 '; '.join(f'{r[0]}: {r[2]}' for r in rows) + f". Total {fmt(st['truck_deaths'])} deaths. Source: NHTSA FARS.",
                 f'Who died in truck-involved fatal crashes, {name}',
                 f"{fmt(st['truck_deaths'])} deaths, 2020&#8211;2024, by where the person was", rows, label_w=230)


def when(st, cid):
    t, o = st['time_of_day'], st['day_of_week']
    name = st['state_name']
    rows = [('Truck-involved: 6 a.m.&#8211;6 p.m.', t['truck_involved']['daytime_pct'], ACCENT),
            ('Other fatal crashes: 6 a.m.&#8211;6 p.m.', t['no_large_truck']['daytime_pct'], BAR),
            ('Truck-involved: Monday&#8211;Friday', o['truck_involved']['weekday_pct'], ACCENT),
            ('Other fatal crashes: Monday&#8211;Friday', o['no_large_truck']['weekday_pct'], BAR)]
    rows = [(a, b, f'{b}%', c) for a, b, c in rows]
    return hbars(cid, f'When truck-involved fatal crashes happen in {name}, compared with other fatal crashes',
                 '; '.join(f'{r[0]}: {r[2]}'.replace('&#8211;', ' to ') for r in rows) + '. Source: NHTSA FARS 2020 to 2024.',
                 f'Truck-involved fatal crashes skew to daytime and weekdays, {name}',
                 'Share of fatal crashes in daytime hours and on weekdays, 2020&#8211;2024', rows, label_w=290)


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument('--stats', nargs='+', required=True)
    ap.add_argument('--out', default='research')
    ap.add_argument('--theme-dir', default=None, help='also write the copies [roden_chart] reads')
    a = ap.parse_args()
    for path in a.stats:
        st = json.load(open(path))
        s = st['state'].lower()
        for chart, fn in (('by-year', by_year), ('who-died', who_died), ('when', when)):
            name = f'{s}-truck-{chart}'
            svg = fn(st, name.replace('-', ''))
            for d in filter(None, (a.out, a.theme_dir)):
                os.makedirs(d, exist_ok=True)
                with open(os.path.join(d, name + '.svg'), 'w') as fh:
                    fh.write(svg)
            print(f'wrote {name}.svg')


if __name__ == '__main__':
    main()
