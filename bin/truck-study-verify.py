#!/usr/bin/env python3
"""
Verify every number in the Study #2 report bodies against the stats and the dataset.

    python3 bin/truck-study-verify.py --research research/

Study #1 verified its 33 figures programmatically before publication and one
failed. This does the same for Study #2, more strictly:

1. EVERY numeric token in the visible text of each body is extracted, in order:
   digits ("1,042", "13.6", "5:59"), route numbers ("I-75", "US 17") and number
   words ("one", "five", "ten", "half"). Shortcodes and tags (hrefs included)
   are stripped first.
2. That sequence must match, token for token, an ordered list of claims below.
   Each claim is either an expression over the stats JSON that must render to
   exactly the text on the page, or a named definitional constant (the 30-day
   FARS rule, the 10,000 lb threshold, BODY_TYP codes). A number added to the
   prose without a claim fails; a claim whose value changes fails.
3. The stats JSON is cross-checked against the crash-level CSV, so the dataset
   the page links to agrees with the numbers the page prints.
4. Non-numeric statements that carry a factual load ("most were outside the
   truck", "the rise came from trucks other than tractor-trailers") are
   asserted against the data.
5. Guard rails: the required links are present, the dataset link names the
   published CSV, the body is 1,000-1,600 words, and there is no statute or
   legal claim (research assets carry none).

Exit status is non-zero on any failure. If this fails, fix the prose, not the check.
"""
import argparse, csv, html, json, os, re, sys
from collections import Counter
from decimal import Decimal, ROUND_HALF_UP

TOKEN = re.compile(r"I-\d+|US \d+|\d{1,2}:\d{2}|\d{1,3}(?:,\d{3})+(?:\.\d+)?|\d+(?:\.\d+)?|"
                   r"\b(?:one|two|three|four|five|six|seven|eight|nine|ten|eleven|twelve|"
                   r"twice|half|dozen)\b", re.I)
WORDS = {'one': 1, 'two': 2, 'three': 3, 'four': 4, 'five': 5, 'six': 6, 'seven': 7,
         'eight': 8, 'nine': 9, 'ten': 10}

# Definitional constants: facts about the method, not findings. Each is named.
CONST = {
    '30': 'FARS scope: death within 30 days of the crash',
    '10,000': 'large-truck threshold, GVWR over 10,000 lb',
    '60': 'BODY_TYP range start', '79': 'BODY_TYP range end', '66': 'BODY_TYP truck-tractor',
    '6': 'daytime band starts 6 a.m. / ends 6 p.m.', '5:59': 'daytime band ends 5:59 p.m.',
    'one': 'definition or wording ("at least one large truck", "one label", "one year")',
    'One': 'wording ("One year is not a trend")',
    'two': 'wording (a count of named things in the same sentence)',
}


class S(dict):
    """Attribute access over the stats JSON."""
    def __getattr__(self, k):
        v = self[k]
        return S(v) if isinstance(v, dict) else v


def half_up(x, nd=0):
    q = Decimal(1).scaleb(-nd)
    return str(Decimal(repr(x)).quantize(q, rounding=ROUND_HALF_UP))


def p0(a, b):
    return half_up(a * 100 / b, 0)


def p1(a, b):
    return half_up(a * 100 / b, 1)


def n(x):
    return f'{x:,}'


def visible_text(raw):
    t = re.sub(r'\[roden_chart[^\]]*\]', ' ', raw)
    t = re.sub(r'<[^>]+>', ' ', t)
    return re.sub(r'\s+', ' ', html.unescape(t)).strip()


# ---------------------------------------------------------------------------
# Claims. Each entry: (token as printed, expression). The expression is Python
# evaluated with s (stats), yrs (by_year), helpers above, and returns a string;
# 'K' marks a definitional constant from CONST; 'Y' a year of the study period;
# 'D' part of the download date recorded in stats['source'].
# ---------------------------------------------------------------------------

def interstate_rows(s, k):
    rows = []
    for r in s['by_interstate'][:k]:
        rows += [(r['route'], f"'{r['route']}'"),
                 (n(r['truck_crashes']), f"n(iv('{r['route']}')['truck_crashes'])"),
                 (n(r['truck_deaths']), f"n(iv('{r['route']}')['truck_deaths'])"),
                 (n(r['all_crashes']), f"n(iv('{r['route']}')['all_crashes'])"),
                 (p0(r['truck_crashes'], r['all_crashes']), f"p0(iv('{r['route']}')['truck_crashes'], iv('{r['route']}')['all_crashes'])")]
    return rows


def county_rows(s):
    rows = []
    for i, r in enumerate(s['by_county_top10']):
        c = f"s.by_county_top10[{i}]"
        rows += [(n(r['truck_crashes']), f"n({c}['truck_crashes'])"),
                 (n(r['truck_deaths']), f"n({c}['truck_deaths'])"),
                 (n(r['all_crashes']), f"n({c}['all_crashes'])"),
                 (p0(r['truck_crashes'], r['all_crashes']), f"p0({c}['truck_crashes'], {c}['all_crashes'])")]
    return rows


def ga_claims(s):
    # Table rows are generated from the stats and checked to be the top-k in order;
    # the county-name column is checked separately (names are not numbers).
    return [
        ('2020', 'Y'), ('2024', 'Y'), ('1,151', 'n(s.truck_deaths)'), ('1,042', 'n(s.truck_crashes)'),
        ('one', 'K'), ('13.6', 'p1(s.truck_crashes, s.all_crashes)'), ('7,673', 'n(s.all_crashes)'),
        ('five', 'WORDS_R[len(yrs)]'),
        ('271', 'n(max(v["truck_deaths"] for v in yrs.values()))'), ('2022', 's.peak_year_truck_deaths'),
        ('203', 'n(yrs["2024"]["truck_deaths"])'), ('2024', 'Y'),
        ('11.9', 'str(min(v["truck_share_crashes_pct"] for v in yrs.values()))'),
        ('14.5', 'str(max(v["truck_share_crashes_pct"] for v in yrs.values()))'),
        ('2024', 'Y'),
        ('82', 'p0(dp("outside_truck"), s.truck_deaths)'),
        ('1,151', 'n(s.truck_deaths)'), ('947', 'n(dp("outside_truck"))'),
        ('806', 'n(dp("other_vehicle_occupants"))'), ('131', 'n(dp("pedestrians"))'),
        ('8', 'n(dp("cyclists"))'), ('204', 'n(dp("truck_occupants"))'),
        ('18', 'p0(dp("truck_occupants"), s.truck_deaths)'),
        ('623', 'n(s.tractor_crashes)'), ('82', 'p0(tp("outside_truck"), s.tractor_deaths)'),
        ('707', 'n(s.tractor_deaths)'),
        ('15', 'p0(rc("interstate")["all_crashes"], s.all_crashes)'),
        ('30', 'p0(rc("interstate")["truck_crashes"], s.truck_crashes)'),
        ('316', 'n(rc("interstate")["truck_crashes"])'),
        ('28', 'p0(rc("interstate")["truck_crashes"], rc("interstate")["all_crashes"])'),
        ('16', 'p0(rc("us_state")["truck_crashes"], rc("us_state")["all_crashes"])'),
        ('5', 'p0(rc("other")["truck_crashes"], rc("other")["all_crashes"])'),
        ('I-75', 's.by_interstate[0]["route"]'), ('98', 'n(iv("I-75")["truck_crashes"])'),
        ('119', 'n(iv("I-75")["truck_deaths"])'), ('two', 'K'), ('20', '"20" if top_share_20()[:2] == ["I-95", "I-16"] else "x"'),
        ('45', 'p0(iv("I-95")["truck_crashes"], iv("I-95")["all_crashes"])'), ('I-95', '"I-95"'),
        ('32', 'n(iv("I-95")["truck_crashes"])'), ('71', 'n(iv("I-95")["all_crashes"])'),
        ('43', 'p0(iv("I-16")["truck_crashes"], iv("I-16")["all_crashes"])'), ('I-16', '"I-16"'),
        ('26', 'n(iv("I-16")["truck_crashes"])'), ('60', 'n(iv("I-16")["all_crashes"])'),
    ] + interstate_rows(s, 6) + [
        ('half', '"half" if rc("us_state")["truck_crashes"] * 2 > s.truck_crashes else "x"'),
        ('600', 'n(rc("us_state")["truck_crashes"])'), ('one', 'K'), ('two', 'K'),
        ('61', 'p0(tod("truck_involved")["daytime_6am_6pm"], tod("truck_involved")["known_hour"])'),
        ('6', 'K'), ('6', 'K'),
        ('42', 'p0(tod("no_large_truck")["daytime_6am_6pm"], tod("no_large_truck")["known_hour"])'),
        ('83', 'p0(dow("truck_involved")["weekday"], dow("truck_involved")["known"])'),
        ('65', 'p0(dow("no_large_truck")["weekday"], dow("no_large_truck")["known"])'),
        ('145', 'n(s.counties_with_truck_crash)'), ('ten', 'WORDS_R[len(s.by_county_top10)]'),
        ('30', 'p0(s.top10_county_truck_crashes, s.truck_crashes)'),
    ] + county_rows(s) + [
        ('four', '"four"'),  # asserted below: ranks 1-4 are Fulton, DeKalb, Gwinnett, Cobb
        ('I-75', '"I-75" if on_route("BARTOW (15)", "I-75") else "x"'),
        ('I-20', '"I-20" if on_route("DOUGLAS (97)", "I-20") else "x"'),
        ('26', 'n(county("Chatham")["truck_crashes"])'), ('30', 'n(county("Chatham")["truck_deaths"])'),
        ('45', 'p0(lu("rural")["truck_crashes"], s.truck_crashes)'),
        ('36', 'p0(lu("rural")["all_crashes"], s.all_crashes)'),
        ('17', 'p0(lu("rural")["truck_crashes"], lu("rural")["all_crashes"])'),
        ('12', 'p0(lu("urban")["truck_crashes"], lu("urban")["all_crashes"])'),
        ('42', 'n(s.work_zone["truck_crashes"])'), ('4', 'p0(s.work_zone["truck_crashes"], s.truck_crashes)'),
        ('48', 'n(s.work_zone["truck_deaths"])'),
        ('29', 'p0(s.work_zone["truck_crashes"], s.work_zone["all_crashes"])'),
        ('144', 'n(s.work_zone["all_crashes"])'),
        ('30', 'K'), ('10,000', 'K'), ('60', 'p0(s.tractor_crashes, s.truck_crashes)'), ('2024', 'Y'),
        ('2020', 'Y'), ('2024', 'Y'), ('30', 'D'), ('2026', 'D'), ('one', 'K'), ('60', 'K'), ('79', 'K'), ('66', 'K'),
        ('two', 'K'), ('6', 'K'), ('5:59', 'K'),
        ('one', 'K'), ('1,042', 'n(csv_rows)'), ('2020', 'Y'), ('2024', 'Y'),
    ]


def sc_claims(s):
    return [
        ('2020', 'Y'), ('2024', 'Y'), ('669', 'n(s.truck_deaths)'), ('601', 'n(s.truck_crashes)'),
        ('one', 'K'), ('12.0', 'p1(s.truck_crashes, s.all_crashes)'), ('5,019', 'n(s.all_crashes)'),
        ('five', 'WORDS_R[len(yrs)]'),
        ('one', 'K'),
        ('11.4', 'str(min(v["truck_share_crashes_pct"] for v in yrs.values()))'),
        ('13.3', 'str(max(v["truck_share_crashes_pct"] for v in yrs.values()))'),
        ('2020', 'Y'), ('2024', 'Y'), ('2024', 'Y'),
        ('126', 'n(yrs["2024"]["truck_crashes"])'), ('141', 'n(yrs["2024"]["truck_deaths"])'),
        ('948', 'n(yrs["2024"]["all_crashes"])'), ('five', 'WORDS_R[len(yrs)]'),
        ('2024', 'Y'), ('two', 'K'), ('56', 'n(yrs["2024"]["tractor_crashes"])'), ('five', 'WORDS_R[len(yrs)]'),
        ('2024', 'Y'), ('One', 'K'),
        ('86', 'p0(dp("outside_truck"), s.truck_deaths)'),
        ('669', 'n(s.truck_deaths)'), ('572', 'n(dp("outside_truck"))'),
        ('503', 'n(dp("other_vehicle_occupants"))'), ('59', 'n(dp("pedestrians"))'),
        ('10', 'n(dp("cyclists"))'), ('97', 'n(dp("truck_occupants"))'),
        ('14', 'p0(dp("truck_occupants"), s.truck_deaths)'),
        ('319', 'n(s.tractor_crashes)'), ('86', 'p0(tp("outside_truck"), s.tractor_deaths)'),
        ('359', 'n(s.tractor_deaths)'),
        ('64', 'p0(lu("rural")["truck_crashes"], s.truck_crashes)'), ('384', 'n(lu("rural")["truck_crashes"])'),
        ('601', 'n(s.truck_crashes)'), ('53', 'p0(lu("rural")["all_crashes"], s.all_crashes)'),
        ('14', 'p0(lu("rural")["truck_crashes"], lu("rural")["all_crashes"])'),
        ('9', 'p0(lu("urban")["truck_crashes"], lu("urban")["all_crashes"])'),
        ('10', 'p0(rc("interstate")["all_crashes"], s.all_crashes)'),
        ('26', 'p0(rc("interstate")["truck_crashes"], s.truck_crashes)'),
        ('157', 'n(rc("interstate")["truck_crashes"])'),
        ('30', 'p0(rc("interstate")["truck_crashes"], rc("interstate")["all_crashes"])'),
        ('10', 'p0(rc("us_state")["truck_crashes"], rc("us_state")["all_crashes"])'),
    ] + interstate_rows(s, 5) + [
        ('I-26', '"I-26" if max(s.by_interstate, key=lambda r: r["truck_deaths"])["route"] == "I-26" else "x"'),
        ('51', 'n(iv("I-26")["truck_deaths"])'),
        ('I-95', 'top_share_20()[0]'), ('20', '"20"'),
        ('36', 'p0(iv("I-95")["truck_crashes"], iv("I-95")["all_crashes"])'),
        ('435', 'n(rc("us_state")["truck_crashes"])'),
        ('US 17', '"US " + s.by_named_route_top10[0]["route"].split("-")[1]'),
        ('28', 'n(s.by_named_route_top10[0]["truck_crashes"])'),
        ('64', 'p0(tod("truck_involved")["daytime_6am_6pm"], tod("truck_involved")["known_hour"])'),
        ('6', 'K'), ('6', 'K'),
        ('39', 'p0(tod("no_large_truck")["daytime_6am_6pm"], tod("no_large_truck")["known_hour"])'),
        ('85', 'p0(dow("truck_involved")["weekday"], dow("truck_involved")["known"])'),
        ('63', 'p0(dow("no_large_truck")["weekday"], dow("no_large_truck")["known"])'),
        ('46', 'n(s.counties_with_truck_crash) if s.counties_with_truck_crash == s.counties_with_any_fatal_crash else "x"'),
        ('one', 'K'), ('ten', 'WORDS_R[len(s.by_county_top10)]'),
        ('47', 'p0(s.top10_county_truck_crashes, s.truck_crashes)'),
    ] + county_rows(s) + [
        ('three', 'WORDS_R[len(s.county_groups["charleston_tri_county"]["counties"])]'),
        ('70', 'n(s.county_groups["charleston_tri_county"]["truck_crashes"])'),
        ('81', 'n(s.county_groups["charleston_tri_county"]["truck_deaths"])'),
        ('I-26', '"I-26" if on_route("DORCHESTER (35)", "I-26") else "x"'),
        ('20', 'p0(county("Dorchester")["truck_crashes"], county("Dorchester")["all_crashes"])'),
        ('7', 'p0(county("Charleston")["truck_crashes"], county("Charleston")["all_crashes"])'),
        ('22', 'n(s.work_zone["truck_crashes"])'), ('4', 'p0(s.work_zone["truck_crashes"], s.truck_crashes)'),
        ('29', 'n(s.work_zone["truck_deaths"])'),
        ('47', 'p0(s.work_zone["truck_crashes"], s.work_zone["all_crashes"])'),
        ('47', 'n(s.work_zone["all_crashes"])'),
        ('30', 'K'), ('10,000', 'K'), ('53', 'p0(s.tractor_crashes, s.truck_crashes)'), ('2024', 'Y'),
        ('2020', 'Y'), ('2024', 'Y'), ('30', 'D'), ('2026', 'D'), ('one', 'K'), ('60', 'K'), ('79', 'K'), ('66', 'K'),
        ('2023', '"2023" if ssr_years() == ["2023", "2024"] else "x"'),
        ('2024', '"2024" if ssr_years() == ["2023", "2024"] else "x"'),
        ('6', 'K'), ('5:59', 'K'),
        ('one', 'K'), ('601', 'n(csv_rows)'), ('2020', 'Y'), ('2024', 'Y'),
    ]


def assertions(st, s, rows):
    """Non-numeric statements in the prose that carry a factual load."""
    y = s['by_year']
    d = s['deaths_by_person_type']
    tod, dow = s['time_of_day']['no_large_truck'], s['day_of_week']['no_large_truck']['by_day']
    peak_band = max(tod['bands'].items(), key=lambda kv: kv[1]['crashes'])[0]
    top_days = sorted(dow, key=lambda k: -dow[k])[:2]
    a = [
        ('most of those killed were outside the truck', d['outside_truck']['deaths'] * 2 > s['truck_deaths']),
        ('other fatal crashes peak in the evening', peak_band.startswith('evening')),
        ('other fatal crashes peak on Saturdays and Sundays', set(top_days) == {'Saturday', 'Sunday'}),
        ('every year stated in the share range', all(s['truck_share_range_pct'][0] <= v['truck_share_crashes_pct']
                                                    <= s['truck_share_range_pct'][1] for v in y.values())),
        ('county table order matches stats top 10', True),  # checked by county_names()
    ]
    if st == 'GA':
        top4 = [c['county'] for c in s['by_county_top10'][:4]]
        shares = sorted(s['by_county_top10'], key=lambda c: -c['truck_share_pct'])[:2]
        a += [
            ('four largest totals are Fulton, DeKalb, Gwinnett, Cobb', top4 == ['Fulton', 'Dekalb', 'Gwinnett', 'Cobb']),
            ('highest shares in the top-10 list are Bartow and Douglas', {c['county'] for c in shares} == {'Bartow', 'Douglas'}),
            ('peak year of truck deaths is 2022', s['peak_year_truck_deaths'] == '2022'),
            ('Georgia named non-interstate routes are not ranked (flagged unreliable)', 'named_route_note' in s),
        ]
    else:
        a += [
            ('most truck-involved crashes happened on rural roads', s['land_use']['rural']['truck_crashes'] * 2 > s['truck_crashes']),
            ('2024 had the highest truck share of the five years', y['2024']['truck_share_crashes_pct'] == max(v['truck_share_crashes_pct'] for v in y.values())),
            ('2024 had the fewest fatal crashes of the five years', y['2024']['all_crashes'] == min(v['all_crashes'] for v in y.values())),
            ('2024 tractor crashes were the lowest of the five years', y['2024']['tractor_crashes'] == min(v['tractor_crashes'] for v in y.values())),
            ('the 2024 rise came from non-tractor trucks', y['2024']['truck_crashes'] > y['2023']['truck_crashes']
             and y['2024']['tractor_crashes'] < y['2023']['tractor_crashes']
             and y['2024']['non_tractor_truck_crashes'] > y['2023']['non_tractor_truck_crashes']),
            ('most truck-involved crashes were on US/state routes', s['by_route_class']['us_state']['truck_crashes'] * 2 > s['truck_crashes']),
            ('US 17 count excludes alternate/bypass/business variants',
             all(re.match(r'^US-17(\s|$)', r['roadway'].upper())
                 and not re.search(r'ALT|BUS|BYP|\b17A\b', r['roadway'].upper()[5:])
                 for r in rows if r['named_route'] == 'US-17')),
        ]
    return a


def csv_crosscheck(s, rows):
    """The published dataset must reproduce the stats."""
    t = rows
    tt = [r for r in t if r['truck_tractor_involved'] == 'True']
    fat = lambda rs: sum(int(r['fatalities']) for r in rs)
    chk = [
        ('rows == truck_crashes', len(t), s['truck_crashes']),
        ('sum fatalities == truck_deaths', fat(t), s['truck_deaths']),
        ('tractor rows == tractor_crashes', len(tt), s['tractor_crashes']),
        ('tractor fatalities == tractor_deaths', fat(tt), s['tractor_deaths']),
    ]
    for k in ('truck_occupants', 'other_vehicle_occupants', 'pedestrians', 'cyclists', 'other_nonoccupants'):
        chk.append((f'deaths_{k}', sum(int(r['deaths_' + k]) for r in t), s['deaths_by_person_type'][k]['deaths']))
    chk.append(('person-type deaths sum to fatalities', sum(sum(int(r['deaths_' + k]) for k in
               ('truck_occupants', 'other_vehicle_occupants', 'pedestrians', 'cyclists', 'other_nonoccupants')) for r in t),
               fat(t)))
    for y, v in s['by_year'].items():
        ry = [r for r in t if r['year'] == y]
        chk += [(f'{y} crashes', len(ry), v['truck_crashes']), (f'{y} deaths', fat(ry), v['truck_deaths'])]
    cc = Counter(r['county'] for r in t)
    for c in s['by_county_top10']:
        chk.append((f"county {c['county']}", cc[c['county_raw']], c['truck_crashes']))
    ic = Counter(r['interstate'] for r in t if r['interstate'])
    for r in s['by_interstate']:
        chk.append((f"interstate {r['route']}", ic[r['route']], r['truck_crashes']))
    for k, v in s['by_route_class'].items():
        chk.append((f'route class {k}', sum(1 for r in t if r['route_class'] == k), v['truck_crashes']))
    for k in ('rural', 'urban'):
        chk.append((f'land use {k}', sum(1 for r in t if r['land_use'].lower() == k), s['land_use'][k]['truck_crashes']))
    chk.append(('work zone', sum(1 for r in t if r['work_zone'] == 'True'), s['work_zone']['truck_crashes']))
    known = [r for r in t if r['hour'] != '']
    chk.append(('daytime', sum(1 for r in known if 6 <= int(r['hour']) < 18),
                s['time_of_day']['truck_involved']['daytime_6am_6pm']))
    chk.append(('weekday', sum(1 for r in t if r['day_of_week'] not in ('Saturday', 'Sunday', 'Unknown')),
                s['day_of_week']['truck_involved']['weekday']))
    return chk


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument('--research', default='research')
    a = ap.parse_args()
    fails, total_tokens, total_checks = 0, 0, 0
    global WORDS_R
    WORDS_R = {v: k for k, v in WORDS.items()}

    for st, slug, pillar, office in (('GA', 'ga', '/georgia-truck-accident-lawyers/', '/truck-accident-lawyers/savannah-ga/'),
                                     ('SC', 'sc', '/south-carolina-truck-accident-lawyers/', '/truck-accident-lawyers/charleston-sc/')):
        s = S(json.load(open(os.path.join(a.research, f'{slug}-truck-study-stats.json'))))
        csv_name = f'{slug}-truck-fatal-crashes-2020-2024.csv'
        rows = list(csv.DictReader(open(os.path.join(a.research, csv_name))))
        raw = open(os.path.join(a.research, f'{slug}-truck-study-body.html')).read()
        text = visible_text(raw)
        yrs = s['by_year']

        env = dict(s=s, yrs=yrs, n=n, p0=p0, p1=p1, WORDS_R=WORDS_R, csv_rows=len(rows),
                   dp=lambda k: s['deaths_by_person_type'][k]['deaths'],
                   tp=lambda k: s['tractor_deaths_by_person_type'][k]['deaths'],
                   rc=lambda k: s['by_route_class'][k], lu=lambda k: s['land_use'][k],
                   tod=lambda k: s['time_of_day'][k], dow=lambda k: s['day_of_week'][k],
                   iv=lambda k: next(r for r in s['by_interstate'] if r['route'] == k),
                   county=lambda k: next(c for c in s['by_county_top10'] if c['county'] == k),
                   top_share_20=lambda: [r['route'] for r in sorted((r for r in s['by_interstate'] if r['all_crashes'] >= 20),
                                                                    key=lambda r: -r['truck_crashes'] / r['all_crashes'])],
                   on_route=lambda c, i: any(r['county'] == c and r['interstate'] == i for r in rows),
                   ssr_years=lambda: s['route_code_12_years'],
                   len=len, max=max, min=min, str=str, sorted=sorted)

        print(f'\n=== {s.state_name} ({slug}-truck-study-body.html) ===')
        found = [m.group(0) for m in TOKEN.finditer(text)]
        claims = ga_claims(s) if st == 'GA' else sc_claims(s)
        ok = 0
        for i in range(max(len(found), len(claims))):
            tok = found[i] if i < len(found) else '<none>'
            if i >= len(claims):
                print(f'  FAIL #{i+1}: "{tok}" in text has no claim'); fails += 1; continue
            want, expr = claims[i]
            if expr == 'K':
                good = tok == want and want in CONST
                why = CONST.get(want, 'NOT A KNOWN CONSTANT')
            elif expr == 'Y':
                good = tok == want and want in yrs
                why = 'study year'
            elif expr == 'D':
                good = tok == want and want in s['source'].replace('-09-', ' September ').replace('-', ' ') and (
                    re.search(r'2026-09-30', s['source']) is not None)
                why = 'download date in stats source'
            else:
                try:
                    v = eval(expr, env)
                    v = str(v)
                except Exception as e:  # noqa
                    v = f'ERROR {e}'
                good = tok == want == v
                why = f'{expr} -> {v}'
            if good:
                ok += 1
            else:
                fails += 1
                ctx = text[max(0, text.find(tok) - 40):text.find(tok) + 40] if tok in text else ''
                print(f'  FAIL #{i+1}: text "{tok}", claim "{want}" ({why})  ...{ctx}...')
        total_tokens += len(found)
        total_checks += ok
        print(f'  numeric tokens: {len(found)} in text, {len(claims)} claims, {ok} verified')

        # County names in the table must match the stats order.
        names = re.findall(r'<tr><td>([A-Za-z]+)</td><td>\d', raw)
        want_names = [c['county'].lower() for c in s['by_county_top10']]
        got = [x.lower() for x in names if x.lower() in want_names]
        good = got == want_names
        print(f'  county table order: {"ok" if good else "FAIL " + str(got)}'); fails += not good

        for label, cond in assertions(st, s, rows):
            print(f'  assert {label}: {"ok" if cond else "FAIL"}'); fails += not cond

        bad = [(l, a_, b) for l, a_, b in csv_crosscheck(s, rows) if a_ != b]
        print(f'  dataset cross-check: {len(csv_crosscheck(s, rows)) - len(bad)}/{len(csv_crosscheck(s, rows))} ok')
        for l, a_, b in bad:
            print(f'    FAIL {l}: csv {a_} != stats {b}')
        fails += len(bad)

        words = len(text.split())
        guards = [
            (f'word count {words} within 1,000-1,600', 1000 <= words <= 1600),
            (f'links {pillar}', f'href="{pillar}"' in raw),
            (f'links {office}', f'href="{office}"' in raw),
            ('dataset link names the published CSV', re.search(r'href="[^"]*/' + re.escape(csv_name) + '"', raw) is not None),
            ('no statute or legal claim', not re.search(r'§|O\.C\.G\.A|S\.C\. Code|statute|limitation|liab|negligen|entitled|compensation', text, re.I)),
            ('fault disclaimer present', 'not fault' in text.lower() or 'involvement is not fault' in text.lower()),
            ('no inline SVG (wp_kses_post strips it; use [roden_chart])', '<svg' not in raw.lower()),
            ('every [roden_chart] has an SVG in the theme', all(os.path.exists(os.path.join(
                os.path.dirname(os.path.abspath(a.research)), 'wordpress/wp-content/themes/roden-law/assets/charts', c + '.svg'))
                for c in re.findall(r'\[roden_chart name="([a-z0-9-]+)"', raw))),
            ('no comparison with the other state', not re.search(r'South Carolina' if st == 'GA' else r'Georgia', text)),
        ]
        for label, cond in guards:
            print(f'  guard {label}: {"ok" if cond else "FAIL"}'); fails += not cond

    # Proposed titles and meta. Short fields, so each number must be one of the
    # headline values below, recomputed from the stats; lengths are Google's limits.
    meta_path = os.path.join(a.research, 'truck-study-meta.json')
    meta_tokens = 0
    if os.path.exists(meta_path):
        meta = json.load(open(meta_path))
        print('\n=== truck-study-meta.json ===')
        for slug in ('ga', 'sc'):
            s = json.load(open(os.path.join(a.research, f'{slug}-truck-study-stats.json')))
            d = s['deaths_by_person_type']
            allowed = {n(s['truck_deaths']), n(s['truck_crashes']), p1(s['truck_crashes'], s['all_crashes']),
                       p0(d['outside_truck']['deaths'], s['truck_deaths']),
                       p0(s['land_use']['rural']['truck_crashes'], s['truck_crashes'])} | set(s['by_year'])
            m = meta[slug]
            for field in ('title', 'meta_title', 'meta_description', 'excerpt'):
                for tok in TOKEN.findall(m[field]):
                    meta_tokens += 1
                    good = tok in allowed or (tok.lower() in CONST and CONST[tok.lower()].startswith('definition'))
                    if not good:
                        print(f'  FAIL {slug}.{field}: "{tok}" is not a headline value'); fails += 1
            for field, lim in (('meta_title', 60), ('meta_description', 155)):
                good = len(m[field]) <= lim
                print(f'  {slug}.{field}: {len(m[field])} chars (<= {lim}) {"ok" if good else "FAIL"}'); fails += not good
            state_name = s['state_name'].lower().replace(' ', '-')
            good = m['slug'] == f'/resources/{state_name}-truck-crash-deaths-2020-2024/'
            print(f'  {slug}.slug {m["slug"]}: {"ok" if good else "FAIL"}'); fails += not good
            # Meta claims must also be backed by the body's own checks: the outside-the-truck
            # and rural percentages are only allowed because the body states and verifies them.
        print(f'  meta numeric tokens checked: {meta_tokens}')

    print(f'\n{total_checks}/{total_tokens} numeric tokens verified across both bodies; {fails} failure(s).')
    sys.exit(1 if fails else 0)


if __name__ == '__main__':
    main()
