#!/usr/bin/env python3
"""
Study #2 — truck-involved fatal crashes, 2020-2024, one study per state.

Two separate, state-specific reports come out of this script: Georgia and South
Carolina. They share a method, not a narrative. Nothing here compares the two
states, and neither report should.

    python3 bin/truck-study-analysis.py --fars-dir <dir> --out research/

<dir> holds the extracted FARS folders, laid out as <dir>/<year>/FARS<year>NationalCSV/
with accident.csv, vehicle.csv and person.csv in each (the same layout as Study #1).

DATA
    NHTSA Fatality Analysis Reporting System (FARS), national annual files,
    2020-2024, downloaded 2026-09-30 from
    https://static.nhtsa.gov/nhtsa/downloads/FARS/<year>/National/FARS<year>NationalCSV.zip

    FARS is a census of crashes on US public roads in which someone died within
    30 days. It is FATAL CRASHES ONLY. It says nothing about injury or
    property-damage crashes, and every figure here must be described as fatal.

DEFINITIONS (identical to Study #1, bin/corridor-report-analysis.py)
    Large truck   vehicle.BODY_TYP in 60-79 — NHTSA's medium/heavy vehicle range,
                  GVWR over 10,000 lb. It includes single-unit trucks, step vans,
                  medium/heavy pickups and motor homes as well as tractor-trailers.
    Truck-tractor vehicle.BODY_TYP 66, reported alongside as a subset because it is
                  what most readers mean by "semi" or "18-wheeler".
    Truck-involved
                  At least one large truck in the crash. NOT an attribution of
                  fault: FARS records what was present, not who was responsible.
    Death         person.INJ_SEV == 4 (fatal injury). Cross-checked against
                  accident.FATALS; the script aborts if the two disagree.
    Person type   Truck occupant: driver/passenger/unknown occupant (PER_TYP 1, 2, 9)
                  of a vehicle whose BODY_TYP is 60-79. Other-vehicle occupant: any
                  other motor-vehicle occupant (PER_TYP 1, 2, 3, 9). Pedestrian:
                  PER_TYP 5. Cyclist: PER_TYP 6, 7. Other non-occupant: the rest.
    Route class   accident.ROUTE. Interstate = 1. US or state route = 2, 3, 12.
                  Everything else (county, local, other, unknown) = other.
                  US and state highways are combined because Georgia's coding of the
                  two swings from year to year (Georgia US routes are also state
                  routes: ROUTE 2 counts of 149, 57, 69, 260 and 72 for 2020-2024),
                  and because South Carolina began coding its state secondary roads
                  (TWAY_ID "SSR-") as ROUTE 12 in 2023-2024, where earlier years had
                  them as State Highway.
    Named interstate
                  TWAY_ID beginning I-<number>, which captures ramps and
                  directional variants. Crashes where ROUTE is 1 are counted.
    Land use      accident.RUR_URB (1 rural, 2 urban, other values unknown).
    Time of day   accident.HOUR; 99 = unknown and excluded from time-of-day shares.
    Day of week   accident.DAY_WEEK, 1 = Sunday. Weekend = Saturday and Sunday.
    Work zone     accident.WRK_ZONE 1-4 (construction, maintenance, utility, type
                  unknown). 0 = none.

KNOWN LIMITS, stated because the reports state them
    * Counts, not rates. There is no truck-miles-travelled denominator here, so
      "more fatal crashes" on a road or in a county is not "more dangerous per mile".
    * 2024 is the newest annual file and may be revised. FARS is republished as
      cases are completed; every figure is a snapshot of the files downloaded.
    * TWAY_ID and ROUTE are entered by the reporting officer and coding practice
      changes between years (see Route class above).
    * Work-zone status is recorded where the officer noted it; small counts.
"""

import argparse, csv, json, os, re, sys
from collections import Counter, defaultdict

STATES = {'13': ('GA', 'Georgia', 'ga'), '45': ('SC', 'South Carolina', 'sc')}
LARGE_TRUCK = set(range(60, 80))
TRUCK_TRACTOR = {66}
ROUTE_CLASS = {1: 'interstate', 2: 'us_state', 3: 'us_state', 12: 'us_state'}
INTERSTATE = re.compile(r'^I-?\s*(\d+)')
NAMED = re.compile(r'^(I|US|SR|SSR|CR)-?\s*(\d+[A-Z]?)\b')
VARIANT = re.compile(r'\bALT\b|\d+\s?ALT\b|\bBYP(?:ASS)?\b|\bBUS(?:INESS)?\b|\b\d+A\b')
OCCUPANT = {1, 2, 9}
DAYS = {1: 'Sunday', 2: 'Monday', 3: 'Tuesday', 4: 'Wednesday', 5: 'Thursday', 6: 'Friday', 7: 'Saturday'}
DOWNLOADED = '2026-09-30'
# Groupings of FARS COUNTYNAME values reported as a unit (the Charleston office's
# three-county market). Within-state only.
COUNTY_GROUPS = {'SC': {'charleston_tri_county': {'CHARLESTON (19)', 'BERKELEY (15)', 'DORCHESTER (35)'}}}


def reader(path):
    """FARS ships some years with a UTF-8 BOM; normalise the first column name."""
    f = open(path, encoding='latin-1')
    rd = csv.DictReader(f)
    rd.fieldnames = [fn.lstrip('﻿\xef\xbb\xbf').strip() for fn in rd.fieldnames]
    return f, rd


def to_int(v, default=None):
    try:
        return int(str(v).strip())
    except (TypeError, ValueError):
        return default


def time_band(h):
    if h is None or h > 23:
        return 'unknown'
    if h < 6:
        return 'overnight (midnight-5:59 a.m.)'
    if h < 12:
        return 'morning (6-11:59 a.m.)'
    if h < 18:
        return 'afternoon (noon-5:59 p.m.)'
    return 'evening (6-11:59 p.m.)'


def load(fars_dir, years):
    """Return every GA/SC fatal crash (truck-involved or not) with truck and death detail."""
    crashes = []
    for y in years:
        base = os.path.join(fars_dir, str(y), f'FARS{y}NationalCSV')
        acc = {}
        f, rd = reader(os.path.join(base, 'accident.csv'))
        with f:
            for r in rd:
                if r['STATE'] in STATES:
                    acc[(r['STATE'], r['ST_CASE'])] = r
        veh_body = {}
        trucks, tractors = Counter(), Counter()
        bodies = defaultdict(list)
        f, rd = reader(os.path.join(base, 'vehicle.csv'))
        with f:
            for r in rd:
                k = (r['STATE'], r['ST_CASE'])
                if k not in acc:
                    continue
                bt = to_int(r['BODY_TYP'])
                veh_body[k + (r['VEH_NO'],)] = bt
                if bt in LARGE_TRUCK:
                    trucks[k] += 1
                    bodies[k].append(bt)
                if bt in TRUCK_TRACTOR:
                    tractors[k] += 1
        deaths = defaultdict(Counter)
        f, rd = reader(os.path.join(base, 'person.csv'))
        with f:
            for r in rd:
                k = (r['STATE'], r['ST_CASE'])
                if k not in acc or to_int(r['INJ_SEV']) != 4:
                    continue
                pt = to_int(r['PER_TYP'])
                if pt in OCCUPANT and veh_body.get(k + (r['VEH_NO'],)) in LARGE_TRUCK:
                    cat = 'truck_occupant'
                elif pt in (1, 2, 3, 9):
                    cat = 'other_vehicle_occupant'
                elif pt == 5:
                    cat = 'pedestrian'
                elif pt in (6, 7):
                    cat = 'cyclist'
                else:
                    cat = 'other_nonoccupant'
                deaths[k][cat] += 1
        for k, r in acc.items():
            fat = int(r['FATALS'])
            d = deaths[k]
            if sum(d.values()) != fat:
                sys.exit(f'{y} {k}: person-file deaths {sum(d.values())} != FATALS {fat}')
            route = to_int(r['ROUTE'])
            tway = r['TWAY_ID'].strip().upper()
            m = INTERSTATE.match(tway)
            rc = ROUTE_CLASS.get(route, 'other')
            nm = NAMED.match(tway)
            # Alternate, bypass and business routes are different roads from the
            # mainline ("US-17 ALT", "US-17 N HWY 17A", "US-17 BYPASS", "... BUS").
            # Give them their own label rather than folding them into the mainline.
            variant = ''
            if nm and VARIANT.search(tway[nm.end():]):
                variant = ' ' + VARIANT.search(tway[nm.end():]).group(0).replace(' ', '')
            hour = to_int(r['HOUR'])
            dow = to_int(r['DAY_WEEK'])
            ru = to_int(r['RUR_URB'])
            crashes.append(dict(
                year=y, state=STATES[k[0]][0], st_case=k[1],
                county=r['COUNTYNAME'].strip(), fatalities=fat,
                truck_involved=trucks[k] > 0, truck_tractor_involved=tractors[k] > 0,
                large_trucks=trucks[k], truck_body_types=' '.join(str(b) for b in sorted(bodies[k])),
                deaths_truck_occupants=d['truck_occupant'],
                deaths_other_vehicle_occupants=d['other_vehicle_occupant'],
                deaths_pedestrians=d['pedestrian'], deaths_cyclists=d['cyclist'],
                deaths_other_nonoccupants=d['other_nonoccupant'],
                route_class=rc, route_code=route if route is not None else '',
                interstate=('I-' + m.group(1)) if (m and rc == 'interstate') else '',
                named_route=(nm.group(1) + '-' + nm.group(2) + variant) if nm else '',
                roadway=r['TWAY_ID'].strip(),
                land_use={1: 'Rural', 2: 'Urban'}.get(ru, 'Unknown'),
                hour=hour if hour is not None and hour <= 23 else '',
                time_band=time_band(hour),
                day_of_week=DAYS.get(dow, 'Unknown'),
                work_zone=to_int(r['WRK_ZONE'], 0) in (1, 2, 3, 4),
                vehicles=to_int(r['VE_TOTAL'], 0),
                latitude=r.get('LATITUDE', '').strip(), longitude=r.get('LONGITUD', '').strip(),
            ))
    return crashes


def pct(a, b, nd=1):
    return round(a / b * 100, nd) if b else 0.0


def deaths_of(rows):
    return sum(r['fatalities'] for r in rows)


def state_stats(rows, years, st, name):
    t = [r for r in rows if r['truck_involved']]
    tt = [r for r in rows if r['truck_tractor_involved']]
    nt = [r for r in rows if not r['truck_involved']]
    s = dict(
        state=st, state_name=name,
        source=f'NHTSA FARS national annual files 2020-2024, downloaded {DOWNLOADED}',
        scope=f'Fatal crashes only, {name}, 2020-2024. Truck-involved = at least one vehicle BODY_TYP 60-79; not fault.',
        all_crashes=len(rows), all_deaths=deaths_of(rows),
        truck_crashes=len(t), truck_deaths=deaths_of(t),
        truck_share_crashes_pct=pct(len(t), len(rows)), truck_share_deaths_pct=pct(deaths_of(t), deaths_of(rows)),
        tractor_crashes=len(tt), tractor_deaths=deaths_of(tt),
        tractor_share_of_truck_crashes_pct=pct(len(tt), len(t)),
        tractor_share_crashes_pct=pct(len(tt), len(rows)),
        deaths_per_crash=dict(truck_involved=round(deaths_of(t) / len(t), 2),
                              no_large_truck=round(deaths_of(nt) / len(nt), 2)),
        multi_death_truck_crashes=sum(1 for r in t if r['fatalities'] > 1),
    )
    # Per year.
    s['by_year'] = {}
    for y in years:
        a = [r for r in rows if r['year'] == y]
        ty = [r for r in a if r['truck_involved']]
        tty = [r for r in a if r['truck_tractor_involved']]
        s['by_year'][str(y)] = dict(
            all_crashes=len(a), all_deaths=deaths_of(a), truck_crashes=len(ty), truck_deaths=deaths_of(ty),
            truck_share_crashes_pct=pct(len(ty), len(a)), tractor_crashes=len(tty), tractor_deaths=deaths_of(tty),
            non_tractor_truck_crashes=len(ty) - len(tty))
    yv = [s['by_year'][str(y)]['truck_deaths'] for y in years]
    s['peak_year_truck_deaths'] = str(years[yv.index(max(yv))])
    s['low_year_truck_deaths'] = str(years[yv.index(min(yv))])
    shares = [s['by_year'][str(y)]['truck_share_crashes_pct'] for y in years]
    s['truck_share_range_pct'] = [min(shares), max(shares)]
    # Deaths by person type, in truck-involved crashes.
    cats = ['truck_occupants', 'other_vehicle_occupants', 'pedestrians', 'cyclists', 'other_nonoccupants']
    pt = {c: sum(r['deaths_' + c] for r in t) for c in cats}
    pt['pedestrians_and_cyclists'] = pt['pedestrians'] + pt['cyclists']
    pt['outside_truck'] = s['truck_deaths'] - pt['truck_occupants']
    s['deaths_by_person_type'] = {k: dict(deaths=v, pct=pct(v, s['truck_deaths'])) for k, v in pt.items()}
    ttp = {c: sum(r['deaths_' + c] for r in tt) for c in cats}
    ttp['outside_truck'] = s['tractor_deaths'] - ttp['truck_occupants']
    s['tractor_deaths_by_person_type'] = {k: dict(deaths=v, pct=pct(v, s['tractor_deaths'])) for k, v in ttp.items()}
    # County.
    cc = Counter(r['county'] for r in rows)
    tc = Counter(r['county'] for r in t)
    td = Counter()
    for r in t:
        td[r['county']] += r['fatalities']
    s['counties_with_truck_crash'] = len(tc)
    s['counties_with_any_fatal_crash'] = len(cc)
    # Years in which ROUTE 12 (state secondary route) appears among ALL fatal crashes.
    s['route_code_12_years'] = sorted({str(r['year']) for r in rows if r['route_code'] == 12})
    s['by_county_top10'] = [dict(county=re.sub(r'\s*\(\d+\)$', '', c).title(), county_raw=c, truck_crashes=n,
                                 truck_deaths=td[c], all_crashes=cc[c], truck_share_pct=pct(n, cc[c]))
                            for c, n in sorted(tc.items(), key=lambda kv: (-kv[1], -td[kv[0]], kv[0]))[:10]]
    top10 = sum(c['truck_crashes'] for c in s['by_county_top10'])
    s['top10_county_share_of_truck_crashes_pct'] = pct(top10, len(t))
    s['top10_county_truck_crashes'] = top10
    # Route class.
    s['by_route_class'] = {}
    for rc in ('interstate', 'us_state', 'other'):
        a = [r for r in rows if r['route_class'] == rc]
        b = [r for r in t if r['route_class'] == rc]
        s['by_route_class'][rc] = dict(truck_crashes=len(b), truck_deaths=deaths_of(b),
                                       pct_of_truck_crashes=pct(len(b), len(t)),
                                       all_crashes=len(a), truck_share_pct=pct(len(b), len(a)),
                                       pct_of_all_crashes=pct(len(a), len(rows)))
    # Named interstates.
    ia = Counter(r['interstate'] for r in rows if r['interstate'])
    it = Counter(r['interstate'] for r in t if r['interstate'])
    idd = Counter()
    for r in t:
        if r['interstate']:
            idd[r['interstate']] += r['fatalities']
    s['by_interstate'] = [dict(route=k, truck_crashes=n, truck_deaths=idd[k], all_crashes=ia[k],
                               truck_share_pct=pct(n, ia[k]))
                          for k, n in sorted(it.items(), key=lambda kv: (-kv[1], kv[0]))]
    # Named non-interstate routes (US / SR / SSR / CR as recorded in TWAY_ID).
    nr = Counter(r['named_route'] for r in t if r['named_route'] and r['route_class'] != 'interstate')
    s['by_named_route_top10'] = [dict(route=k, truck_crashes=n) for k, n in
                                 sorted(nr.items(), key=lambda kv: (-kv[1], kv[0]))[:10]]
    if st == 'GA':
        # Georgia's US routes all carry a state-route number too, and officers record
        # either one: US 27 appears as both "US-27" and "SR-1", US 41 as "US-41" and
        # "SR-3", US 1 as "US-1" and "SR-4", in different years. A ranking of these
        # labels splits one road into two and is not publishable.
        s['named_route_note'] = ('NOT RELIABLE for Georgia: US/SR concurrency is recorded '
                                 'inconsistently (US-27/SR-1, US-41/SR-3, US-1/SR-4). Do not publish.')
    for group, members in COUNTY_GROUPS.get(st, {}).items():
        g = [r for r in t if r['county'] in members]
        ga = [r for r in rows if r['county'] in members]
        s.setdefault('county_groups', {})[group] = dict(
            counties=sorted(re.sub(r'\s*\(\d+\)$', '', c).title() for c in members),
            truck_crashes=len(g), truck_deaths=deaths_of(g), all_crashes=len(ga),
            truck_share_pct=pct(len(g), len(ga)))
    # Land use.
    s['land_use'] = {}
    for lu in ('Rural', 'Urban', 'Unknown'):
        a = [r for r in rows if r['land_use'] == lu]
        b = [r for r in t if r['land_use'] == lu]
        s['land_use'][lu.lower()] = dict(truck_crashes=len(b), truck_deaths=deaths_of(b),
                                         pct_of_truck_crashes=pct(len(b), len(t)),
                                         all_crashes=len(a), truck_share_pct=pct(len(b), len(a)),
                                         pct_of_all_crashes=pct(len(a), len(rows)))
    # Time of day, known hours only.
    def bands(rs):
        k = [r for r in rs if r['time_band'] != 'unknown']
        c = Counter(r['time_band'] for r in k)
        return {b: dict(crashes=c[b], pct=pct(c[b], len(k))) for b in
                ('overnight (midnight-5:59 a.m.)', 'morning (6-11:59 a.m.)',
                 'afternoon (noon-5:59 p.m.)', 'evening (6-11:59 p.m.)')}, len(k)
    s['time_of_day'] = {}
    for label, rs in (('truck_involved', t), ('no_large_truck', nt)):
        b, n = bands(rs)
        daytime = sum(1 for r in rs if r['hour'] != '' and 6 <= r['hour'] < 18)
        s['time_of_day'][label] = dict(bands=b, known_hour=n, unknown_hour=len(rs) - n,
                                       daytime_6am_6pm=daytime, daytime_pct=pct(daytime, n))
    # Day of week.
    s['day_of_week'] = {}
    for label, rs in (('truck_involved', t), ('no_large_truck', nt)):
        c = Counter(r['day_of_week'] for r in rs)
        known = sum(v for k, v in c.items() if k != 'Unknown')
        wk = c['Saturday'] + c['Sunday']
        s['day_of_week'][label] = dict(by_day={d: c[d] for d in DAYS.values()}, known=known,
                                       weekday=known - wk, weekday_pct=pct(known - wk, known),
                                       weekend=wk, weekend_pct=pct(wk, known))
    # Work zone.
    wz = [r for r in t if r['work_zone']]
    wza = [r for r in rows if r['work_zone']]
    s['work_zone'] = dict(truck_crashes=len(wz), truck_deaths=deaths_of(wz), pct_of_truck_crashes=pct(len(wz), len(t)),
                          all_crashes=len(wza), truck_share_pct=pct(len(wz), len(wza)),
                          no_truck_pct_in_work_zone=pct(len(wza) - len(wz), len(nt)))
    # Vehicle mix.
    s['single_vehicle_truck_crashes'] = sum(1 for r in t if r['vehicles'] == 1)
    body = Counter()
    for r in t:
        for b in r['truck_body_types'].split():
            body[int(b)] += 1
    s['truck_vehicles_by_body_type'] = {str(k): v for k, v in sorted(body.items())}
    s['truck_vehicles'] = sum(body.values())
    s['single_unit_truck_vehicles'] = sum(v for k, v in body.items() if 60 <= k <= 64)
    s['medium_heavy_pickup_vehicles'] = body.get(67, 0)
    s['tractor_vehicles'] = body.get(66, 0)
    return s


CSV_FIELDS = ['year', 'state', 'st_case', 'county', 'fatalities', 'truck_tractor_involved', 'large_trucks',
              'truck_body_types', 'deaths_truck_occupants', 'deaths_other_vehicle_occupants',
              'deaths_pedestrians', 'deaths_cyclists', 'deaths_other_nonoccupants', 'route_class',
              'route_code', 'interstate', 'named_route', 'roadway', 'land_use', 'hour', 'time_band',
              'day_of_week', 'work_zone', 'vehicles', 'latitude', 'longitude']


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument('--fars-dir', required=True)
    ap.add_argument('--out', default='research')
    ap.add_argument('--years', default='2020,2021,2022,2023,2024')
    a = ap.parse_args()
    years = [int(y) for y in a.years.split(',')]

    crashes = load(a.fars_dir, years)
    if not crashes:
        sys.exit('No crashes found — check --fars-dir points at extracted FARS folders.')
    os.makedirs(a.out, exist_ok=True)

    for code, (st, name, slug) in STATES.items():
        rows = [r for r in crashes if r['state'] == st]
        t = [r for r in rows if r['truck_involved']]
        # newline and lineterminator both '\n' — see bin/corridor-report-analysis.py:
        # a CRLF file will not checksum-match the one this script produces.
        with open(os.path.join(a.out, f'{slug}-truck-fatal-crashes-2020-2024.csv'), 'w', newline='\n') as fh:
            w = csv.DictWriter(fh, fieldnames=CSV_FIELDS, lineterminator='\n', extrasaction='ignore')
            w.writeheader()
            w.writerows(t)
        s = state_stats(rows, years, st, name)
        with open(os.path.join(a.out, f'{slug}-truck-study-stats.json'), 'w') as fh:
            json.dump(s, fh, indent=2)
            fh.write('\n')
        print(f"{name}: {s['all_crashes']} fatal crashes, {s['truck_crashes']} truck-involved "
              f"({s['truck_share_crashes_pct']}%), {s['truck_deaths']} deaths; "
              f"tractor subset {s['tractor_crashes']} crashes")
        print(f"  wrote {a.out}/{slug}-truck-fatal-crashes-2020-2024.csv ({len(t)} rows) and {slug}-truck-study-stats.json")


if __name__ == '__main__':
    main()
