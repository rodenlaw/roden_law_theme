#!/usr/bin/env python3
"""
I-26 / I-95 Corridor Report — the analysis behind /resources/i-26-i-95-corridor-report/.

Committed because the report's only real asset is that anyone can check it. Run
this against the same FARS files and you get the same numbers, or the report is
wrong and should be corrected.

    python3 bin/corridor-report-analysis.py --fars-dir <dir> --out research/

DATA
    NHTSA Fatality Analysis Reporting System (FARS), national annual files,
    2020-2024, downloaded 2026-08-25 from
    https://static.nhtsa.gov/nhtsa/downloads/FARS/<year>/National/FARS<year>NationalCSV.zip

    FARS is a census of crashes on US public roads in which someone died within
    30 days. It is FATAL CRASHES ONLY. It says nothing about injury or
    property-damage crashes, and every figure here must be described as fatal.
    State all-severity collision data (SCDPS, GDOT) would answer a different and
    broader question; it is not public in a form this script can consume.

DEFINITIONS
    Corridor      accident.TWAY_ID matching ^I-26 or ^I-95, which captures the
                  mainline plus its ramps and directional variants ("I-95 NB",
                  "I-26 EXIT RAMP"). Verified against the raw value list.
    Large truck   vehicle.BODY_TYP in 60-79 — NHTSA's medium/heavy vehicle range,
                  GVWR over 10,000 lb. Reported alongside the truck-tractor-only
                  subset (BODY_TYP 66) because the two answer different
                  questions and the gap between them is small enough to state.
    Truck-involved
                  At least one such vehicle in the crash. NOT an attribution of
                  fault: FARS records what was present, not who was responsible,
                  and the report must not imply otherwise.

KNOWN LIMITS, stated because the report states them
    * Counts are crashes and deaths, not rates. Without vehicle-miles-travelled
      by corridor segment, "more fatal crashes" is not "more dangerous per mile".
    * 2024 is the most recent annual file and may be revised. FARS is republished
      as cases are completed, so any figure here is a snapshot of that file.
    * TWAY_ID is entered by the reporting officer. Spelling variants are handled;
      an unrecorded route is invisible to this analysis either way.
"""

import argparse, csv, json, os, re, sys
from collections import Counter, defaultdict

STATES = {'13': 'GA', '45': 'SC'}
CORRIDOR = re.compile(r'^I-(26|95)\b')
LARGE_TRUCK = set(range(60, 80))
TRUCK_TRACTOR = {66}


def reader(path):
    """FARS ships some years with a UTF-8 BOM, which turns the first column name
    into '﻿STATE'. Normalise rather than special-casing by year."""
    f = open(path, encoding='latin-1')
    rd = csv.DictReader(f)
    rd.fieldnames = [fn.lstrip('﻿\xef\xbb\xbf').strip() for fn in rd.fieldnames]
    return f, rd


def load(fars_dir, years):
    rows = []
    for y in years:
        base = os.path.join(fars_dir, str(y), f'FARS{y}NationalCSV')
        acc = {}
        f, rd = reader(os.path.join(base, 'accident.csv'))
        with f:
            for r in rd:
                if r['STATE'] in STATES:
                    acc[(r['STATE'], r['ST_CASE'])] = r
        trucks, tractors = set(), set()
        f, rd = reader(os.path.join(base, 'vehicle.csv'))
        with f:
            for r in rd:
                k = (r['STATE'], r['ST_CASE'])
                if k not in acc:
                    continue
                try:
                    bt = int(r['BODY_TYP'])
                except (TypeError, ValueError):
                    continue
                if bt in LARGE_TRUCK:
                    trucks.add(k)
                if bt in TRUCK_TRACTOR:
                    tractors.add(k)
        for k, r in acc.items():
            m = CORRIDOR.match(r['TWAY_ID'].strip().upper())
            if not m:
                continue
            rows.append(dict(
                year=y, state=STATES[k[0]], corridor='I-' + m.group(1),
                county=r['COUNTYNAME'].strip(), fatalities=int(r['FATALS']),
                truck_involved=k in trucks, truck_tractor_involved=k in tractors,
                land_use=r['RUR_URBNAME'].strip(), roadway=r['TWAY_ID'].strip(),
                latitude=r.get('LATITUDE', ''), longitude=r.get('LONGITUD', ''),
            ))
    return rows


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument('--fars-dir', required=True)
    ap.add_argument('--out', default='research')
    ap.add_argument('--years', default='2020,2021,2022,2023,2024')
    a = ap.parse_args()
    years = [int(y) for y in a.years.split(',')]

    rows = load(a.fars_dir, years)
    if not rows:
        sys.exit('No corridor crashes found — check --fars-dir points at extracted FARS folders.')
    os.makedirs(a.out, exist_ok=True)

    # newline='\n' rather than '': csv defaults to CRLF, which makes the published
    # file differ byte-for-byte from the one this script produces locally. For a
    # dataset whose whole purpose is that someone can reproduce it, a checksum that
    # does not match is a needless doubt.
    with open(os.path.join(a.out, 'i26-i95-corridor-fatal-crashes-2020-2024.csv'), 'w', newline='\n') as fh:
        # lineterminator='\n' as well as newline='\n': csv.writer defaults to CRLF
        # independently of how the file was opened, so setting only one of the two
        # leaves the output unchanged — which is exactly what happened first time.
        w = csv.DictWriter(fh, fieldnames=list(rows[0].keys()), lineterminator='\n')
        w.writeheader()
        w.writerows(rows)

    t = [r for r in rows if r['truck_involved']]
    stats = {
        'source': 'NHTSA FARS national annual files 2020-2024, accessed 2026-08-25',
        'scope': 'Fatal crashes only, on I-26 and I-95 in Georgia and South Carolina',
        'crashes': len(rows), 'deaths': sum(r['fatalities'] for r in rows),
        'truck_crashes': len(t), 'truck_deaths': sum(r['fatalities'] for r in t),
        'truck_tractor_crashes': sum(1 for r in rows if r['truck_tractor_involved']),
        'by_year': {}, 'by_segment': {}, 'by_county': [], 'land_use': {},
    }
    for y in years:
        s = [r for r in rows if r['year'] == y]
        ty = [r for r in s if r['truck_involved']]
        stats['by_year'][y] = dict(crashes=len(s), deaths=sum(r['fatalities'] for r in s),
                                   truck_crashes=len(ty), truck_deaths=sum(r['fatalities'] for r in ty))
    for st in ('GA', 'SC'):
        for co in ('I-26', 'I-95'):
            s = [r for r in rows if r['state'] == st and r['corridor'] == co]
            if not s:
                continue
            ts = [r for r in s if r['truck_involved']]
            stats['by_segment'][f'{st} {co}'] = dict(
                crashes=len(s), deaths=sum(r['fatalities'] for r in s),
                truck_crashes=len(ts), truck_deaths=sum(r['fatalities'] for r in ts),
                truck_share_pct=round(len(ts) / len(s) * 100, 1))
    cc = Counter((r['state'], r['county']) for r in rows)
    tc = Counter((r['state'], r['county']) for r in t)
    for (st, co), n in cc.most_common():
        stats['by_county'].append(dict(state=st, county=co, crashes=n, truck_crashes=tc[(st, co)],
                                       truck_share_pct=round(tc[(st, co)] / n * 100, 1)))
    stats['land_use'] = dict(Counter(r['land_use'] for r in t))
    stats['deaths_per_crash'] = {
        'truck_involved': round(sum(r['fatalities'] for r in t) / len(t), 3),
        'no_large_truck': round(sum(r['fatalities'] for r in rows if not r['truck_involved'])
                                / max(1, len(rows) - len(t)), 3)}

    with open(os.path.join(a.out, 'corridor-report-stats.json'), 'w') as fh:
        json.dump(stats, fh, indent=2)

    print(f"{stats['crashes']} fatal crashes, {stats['deaths']} deaths, "
          f"{stats['truck_crashes']} truck-involved ({stats['truck_crashes']/stats['crashes']*100:.0f}%)")
    for k, v in stats['by_segment'].items():
        print(f"  {k}: {v['crashes']:>3} crashes, {v['truck_share_pct']}% truck-involved")
    print(f"  truck-tractor-only subset: {stats['truck_tractor_crashes']} crashes")
    print(f"wrote {a.out}/i26-i95-corridor-fatal-crashes-2020-2024.csv and corridor-report-stats.json")


if __name__ == '__main__':
    main()
