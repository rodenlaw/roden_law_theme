#!/usr/bin/env python3
"""
Classify the URL inventory per SEO-PREEMPTION-PLAN-rodenlaw.md Phase 1.

Rules are first-match-wins, in the plan's order. Input is the CSV produced by
bin/export-url-inventory.php. Output is url-triage.csv.

This script decides nothing on its own that the plan leaves to evidence: rule 4
("keep only those with real rankings/traffic") needs the GSC export that is an
[OWNER] deliverable, so those URLs land in EVALUATE with the dependency named
rather than being silently guessed into KEEP or REMOVE.
"""
import csv, sys

BASE = 'https://rodenlaw.com'

# The six markets with a real office. Everything else is a service area.
OFFICE_CITIES = {
    ('georgia', 'savannah'), ('georgia', 'darien'),
    ('south-carolina', 'charleston'), ('south-carolina', 'north-charleston'),
    ('south-carolina', 'columbia'), ('south-carolina', 'myrtle-beach'),
}
OFFICE_SLUGS = {'savannah-ga', 'darien-ga', 'charleston-sc', 'north-charleston-sc',
                'columbia-sc', 'myrtle-beach-sc'}

# Tier-3 slugs that are districts *of the office city above them*, not separate
# municipalities. These are the plan's rule-3 case: below city level.
DISTRICTS = {
    'downtown-charleston', 'west-ashley', 'daniel-island',
    'downtown-savannah', 'midtown-savannah', 'southside-savannah',
    'eastside-savannah', 'westside-savannah',
    'charleston-heights', 'chicora-cherokee', 'dorchester-terrace-waylyn',
    'ferndale', 'liberty-hill', 'northwoods', 'oak-terrace-preserve',
    'olde-north-charleston', 'park-circle', 'wescott-plantation',
    'northeast-columbia',
}

# Rule 5: single-road and single-employer permutations.
ROAD_MARKERS = ('i-26', 'i-526', 'i-95', 'i-16', 'i-77', 'i-85', 'i-20',
                'road-accident', 'avenue-accident', 'highway-accident',
                'two-notch', 'ashley-phosphate', 'dorchester-road', 'rivers-avenue')
EMPLOYER_MARKERS = ('gulfstream', 'boeing', 'savannah-port-worker')


def segs(url):
    p = url.replace(BASE, '').strip('/')
    s = [x for x in p.split('/') if x]
    es = bool(s and s[0] == 'es')
    if es:
        s = s[1:]
    return s, es


def is_road_or_employer(child):
    return (any(m in child for m in ROAD_MARKERS)
            or any(m in child for m in EMPLOYER_MARKERS))


def classify(r):
    """Return (classification, redirect_target, reason)."""
    url = r['url']
    s, es = segs(url)
    t = r['post_type']
    prefix = '/es' if es else ''

    # ---- Rule 1: guardrail keeps -------------------------------------
    if t in ('attorney', 'case_result', 'case-result', 'staff', 'testimonial', 'resource'):
        return 'KEEP', '', f'Guardrail keep-list: {t} page.'
    if t == 'post':
        return 'KEEP', '', 'Guardrail keep-list: blog. Strongest non-brand asset.'
    if t == 'page':
        return 'KEEP', '', 'Guardrail keep-list: core site page.'

    # ---- Locations ---------------------------------------------------
    if t == 'location':
        if not s or s[0] != 'locations':
            return 'EVALUATE', '', 'Location post outside /locations/ — inspect manually.'
        tier = len(s) - 1          # 1=state 2=city 3=suburb 4=neighborhood
        state = s[1] if tier >= 1 else ''
        city  = s[2] if tier >= 2 else ''

        if tier == 1:
            return 'KEEP', '', 'Guardrail keep-list: state parent of the office hubs.'

        if tier == 2:
            if (state, city) in OFFICE_CITIES:
                return 'KEEP', '', 'Rule 2: city-level hub for a real office market.'
            return ('EVALUATE', f'{prefix}/locations/{state}/',
                    'Rule 4: city page in a market with no office. Published 2026-08-20, so it '
                    'has no ranking history to justify a keep — needs the GSC baseline before a '
                    'final call. Default is 301 to the state page.')

        if tier == 3:
            parent = f'{prefix}/locations/{state}/{city}/'
            sub = s[3]
            if sub in DISTRICTS:
                return ('REMOVE', parent,
                        'Rule 3: district of the office city above it, i.e. below city level. '
                        'Cannot be edited into legitimacy.')
            return ('EVALUATE', parent,
                    'Rule 4: separate municipality nested under the nearest office city. Keep '
                    'only with real rankings/traffic or genuine service history — needs the GSC '
                    'baseline. Default is 301 to the parent city hub.')

        if tier >= 4:
            return ('REMOVE', f'{prefix}/locations/{state}/{city}/',
                    'Rule 3: neighborhood/subdivision page below city level. 301 to parent city.')

    # ---- Practice areas ----------------------------------------------
    if t == 'practice_area':
        if len(s) != 2:
            return 'EVALUATE', '', 'Unexpected practice-area depth — inspect manually.'
        pillar, child = s[0], s[1]

        if pillar == 'practice-areas':
            return 'KEEP', '', 'Guardrail keep-list: statewide/primary practice page.'

        parent = f'{prefix}/practice-areas/{pillar}/'

        if is_road_or_employer(child):
            return ('CONSOLIDATE', parent,
                    'Rule 5: single-road / single-employer permutation. Merge substance into the '
                    'parent practice page, or re-home as a bylined blog/resource post; 301 the URL.')

        if child in OFFICE_SLUGS:
            return ('KEEP', '',
                    'Rule 6: city x practice in an office market — the defensible tier.')

        if child.endswith('-sc') or child.endswith('-ga'):
            return ('REMOVE', parent,
                    'Rule 7: city x practice in a market with no office. 301 to the statewide '
                    'practice page.')

        return ('KEEP', '',
                'Accident-type subtype of the pillar, not a place permutation — outside the '
                'doorway pattern the plan targets.')

    return 'EVALUATE', '', f'Unhandled post_type {t} — inspect manually.'


def main(src, dest):
    rows = list(csv.DictReader(open(src)))
    # Mirror rule 8: an /es/ page inherits its English twin's verdict.
    verdicts = {}
    for r in rows:
        c, tgt, why = classify(r)
        verdicts[r['url']] = (c, tgt, why)

    out = csv.writer(open(dest, 'w', newline=''))
    out.writerow(['url', 'post_type', 'level', 'classification',
                  'redirect_target', 'reason', 'locale', 'unique_words', 'post_id'])

    counts = {}
    for r in rows:
        c, tgt, why = verdicts[r['url']]
        s, es = segs(r['url'])
        if es:
            twin = BASE + '/' + '/'.join(s) + '/'
            if twin in verdicts:
                tc, _, _ = verdicts[twin]
                if tc != c:
                    c, why = tc, ('Rule 8 mirror: follows its English twin. ' + why)
            why += (' Rule 8 exception: keep regardless if this /es/ page outranks or '
                    'out-earns its English twin — verify before removing.')
        tier = len(s) - 1 if s and s[0] == 'locations' else len(s)
        counts[c] = counts.get(c, 0) + 1
        out.writerow([r['url'], r['post_type'], tier, c, tgt, why,
                      r['locale'], r['words'], r['post_id']])

    total = sum(counts.values())
    for k in sorted(counts, key=lambda x: -counts[x]):
        print(f'  {k:12} {counts[k]:5}  ({counts[k]*100.0/total:.1f}%)')
    print(f'  {"TOTAL":12} {total:5}')
    keep = counts.get('KEEP', 0)
    print(f'\n  End state if every EVALUATE is removed: {keep} URLs')
    print(f'  End state if every EVALUATE is kept:    {keep + counts.get("EVALUATE",0)} URLs')
    print('  Plan target: 250-350 URLs')


if __name__ == '__main__':
    main(sys.argv[1], sys.argv[2])
