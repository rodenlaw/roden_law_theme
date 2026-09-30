# Study #2 — state truck-crash deaths, working notes

Owner, 2026-09-30: "for study 2, let's do the truck-crash deaths, but keep them state specific".
Two separate studies (GA, SC). No cross-state comparison in either.

## Data
- FARS national CSV 2020-2024, downloaded 2026-09-30 (13:51 UTC) to session scratchpad (not committed).
- File dates inside zips: 2020 accident.csv 2022-10-31; 2021 accident 2024-11-11; 2022 2025-10-15;
  2023 2025-10-06; 2024 2025-11-20 (2024 is the newest file and may be revised).
- sha256 of zips:
  - 2020 b2806902b3da9b45c632499f82e1c74fd108238ae7f67e108ebf40360ee4c9c3
  - 2021 743c19a13884614430d295289e655c5ad32b0a025a11e5b2149dfb57acae389b
  - 2022 989448d7a2f3964264c96a3cdb220f6c413c782a33eb759781f520c5acb5f744
  - 2023 edde841eb493e55751961b36bac2d1ce8750f601cb8e6e183a525723bb62bab0
  - 2024 5112727a8c0dc91ffee27ca05bddb073934f2d192ce4fae997da767dccdbe04f

## Coding findings (from exploring raw values)
- ROUTE: GA's split between US Highway (2) and State Highway (3) swings year to year
  (US: 149, 57, 69, 260, 72) because GA US routes are also state routes. Split is not usable;
  report a combined "US or state route" bucket.
- SC 2024 (and 5 cases in 2023) introduced ROUTE 12 "Secondary Route" (TWAY_ID prefix SSR-);
  earlier years coded the same roads as State Highway (SR-). Grouped with US/state.
- GA 2023-24 uses ROUTE 95 "Other" for city streets (CS-) — grouped as other.
- WRK_ZONE present all years (0 none, 1-4 work zone types). pandas default NA parsing turns "None"
  into NaN; the script uses the csv module.
- BODY_TYP 60-79 in GA+SC 2020-24 vehicles: 66 truck-tractor dominates (1,017 vehicles); 61-63 single-unit
  (579); 67 medium/heavy pickup >10k lb (156); 65 motor home (10). Same definition as Study #1.
- Deaths = person INJ_SEV 4 (checked against accident FATALS).

## Progress
- [x] download + explore
- [x] bin/truck-study-analysis.py; cross-check vs Study #1: GA I-95 32 + SC I-26 39 + SC I-95 38 = 109
      truck-involved, GA I-95 45.1%. Matches Study #1 exactly.
- [x] GA non-interstate route ranking withheld: same road recorded as US-27/SR-1, US-41/SR-3, US-1/SR-4
      in different years. Stats carry `named_route_note`; the GA body says why it does not rank them.
- [x] SC US-17: raw TWAY_ID folded ALT / BYPASS / BUS / 17A variants into US-17 (34). They now get their
      own label; mainline US-17 = 28. The verifier caught the prose still saying 34; prose fixed.
- [x] SC 2024: truck share 13.3% (highest of five years) while all fatal crashes 948 (lowest); the rise
      is non-tractor trucks (45 -> 70) while tractor crashes fell (66 -> 56). Reported with caveats only.
- [x] Charts: bin/truck-study-charts.py -> research/*.svg + theme assets/charts/*.svg, rendered via
      [roden_chart] (Study #1's wp_kses_post fix). Secondary colour changed #7aa8bf -> #4f93c4: the old one
      failed the dataviz chroma floor and 3:1 contrast. Primary #0b5c8a unchanged. All bars direct-labelled.
- [x] Bodies: GA ~1,280 words, SC ~1,300 words. No statutes. Links: state pillar + office truck page.
- [x] bin/truck-study-verify.py: 321/321 numeric tokens (GA 161, SC 160) matched in order to claims;
      264 computed from stats, 32 named definitional constants, 21 study years, 4 download-date parts.
      Plus dataset cross-check (GA 52/52, SC 45/45), prose assertions, guards, meta (31 tokens, lengths).
      Mutation test: changing one number in each body fails the check.
- [x] research/truck-study-meta.json.

## Open before publishing
- Dataset hrefs assume /wp-content/uploads/2026/10/<file>.csv. A seeder (copy seed-corridor-report.php)
  must attach the CSV and rewrite the href to the real attachment URL (it sets _roden_dataset_url).
- Theme chart SVGs are in wordpress/** and will ship on the next deploy; they are inert until a page
  uses the shortcode. No CSS change, so no Version bump needed.
- _roden_last_reviewed stays unset until an attorney has actually read the page.
