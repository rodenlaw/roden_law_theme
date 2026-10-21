# Granularity-floor cull — 2026-10-21

Owner decision 2026-10-21: "go with 1" (keep 11, hold 2, merge 6, retire 30 + the 5 middle-tier posts).

The site-health floor check (data/site-health/latest.json, 2026-10-21) flagged 54 sitemap URLs whose slug targets a street, route segment, landmark or sub-municipal place. Across all 54: **578 clicks in 16 months, 22 in the last 28 days**.

Sources: 16 months = docs/gsc-2026-10-06/pages_16mo.csv (to 2026-10-03; www and query-string variants folded). 28 days = data/gsc/latest.json (2026-09-21 to 2026-10-18). Ledger = data/seo/ledger.json.

## Decision rules
- **Keep (11):** 18 or more clicks in 16 months. Together 363 of the 578 clicks, average positions 7–10.
- **Hold (2):** ledger `waiting` until December after the October freshness refresh; changing them now spoils that measurement.
- **Merge (6):** a weaker page on the same road as a kept page. Redirect only; carrying any unique facts onto the target is deferred to the target's ledger date.
- **Retire (30):** 0–9 clicks in 16 months, at most 1 in 28 days. The test #142 and #149 used.
- **Retire, middle tier (5):** 10–13 clicks in 16 months, at most 1 in 28 days; in their own map function (`roden_floor_cull_mid_urls()`) so they can be dropped.

Retire destination: the live wave-1 office page for the post's city and practice where one exists, otherwise the practice pillar. 21 of the 30 are truck-corridor resources published 2026-04-24, so their 16-month figure covers about six months.

## Doorway ratio
- Before: 165 / 691 = 23.88% (`bin/doorway-ratio-now.mjs`, 2026-10-21). All 41 count as location-targeted.
- After: 124 / 650 = **19.08%**. Headroom under the 25% ceiling goes from about 10 to about 46 new location-targeted pages.
- The floor check still lists 13 pages (11 kept + 2 held), all by decision.

## Pre-flight on prod (read-only, 2026-10-21)
- 41/41 published; none hierarchical, no children; none already in the removal map; map chain-free against prod's live removal and legacy maps.
- Spanish twins: one. Post 5001's twin, 5004 (`/es/blog/east-bay-street-savannah-pedestrian-accident-lawyer/`), is already a draft with its own redirect (`roden_zero_click_blog_urls()`). Drafting 5001 (not trashing) leaves it untouched.
- Google Ads (6625646641, 9363754842): none of the 41 is an ad final URL or sitelink (120 URLs checked). No GBP link points at them.
- Inbound body links from published pages outside the batch: 32 of the 41 have them; `bin/relink-floor-cull.php` rewrites them. `_roden_see_also` references on 9 pages resolve through the removal map at render time (`roden_resolve_see_also_url()`), so no meta rewrite.
- One legacy alias pointed into the set (`/car-accidents-on-coleman-boulevard/`); repointed to the final target.

## The 54
| Tier | URL | ID | Clicks 16 mo | Impr 16 mo | Pos | Clicks 28 d | Impr 28 d | Ledger | Destination |
|---|---|---:|---:|---:|---:|---:|---:|---|---|
| keep | `/blog/a-cyclists-guide-after-a-ravenel-bridge-accident/` |  | 113 | 4706 | 10.2 | 0 | 29 | unknown | — |
| keep | `/blog/savannah-dangerous-highways-i16-i95-abercorn/` |  | 33 | 3245 | 8.6 | 4 | 297 | waiting to 2027-01-01 | — |
| keep | `/resources/blythewood-i-77-truck-accidents/` |  | 28 | 4238 | 9.5 | 3 | 174 | free | — |
| keep | `/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/` |  | 28 | 4362 | 8.9 | 1 | 245 | waiting to 2026-12-31 | — |
| keep | `/blog/folly-road-car-accidents-james-island-charleston/` |  | 27 | 3017 | 8.8 | 1 | 311 | waiting to 2027-01-04 | — |
| keep | `/blog/carriage-tour-accidents-downtown-charleston-liability/` |  | 25 | 1704 | 8.8 | 4 | 273 | unknown | — |
| keep | `/blog/darien-brunswick-dangerous-roads-i95-us17/` |  | 25 | 4557 | 9 | 2 | 442 | unknown | — |
| keep | `/resources/bay-street-truck-accidents-savannah-historic-district/` |  | 23 | 709 | 7.3 | 2 | 68 | free | — |
| keep | `/resources/us-52-truck-train-accidents-goose-creek/` |  | 23 | 1495 | 8.2 | 0 | 166 | free | — |
| keep | `/blog/lower-king-street-pedestrian-safety/` |  | 20 | 2888 | 9.2 | 0 | 221 | waiting to 2026-12-08 | — |
| keep | `/blog/what-to-do-after-a-hit-and-run-in-downtown-charleston/` |  | 18 | 2817 | 16.7 | 1 | 79 | unknown | — |
| hold | `/blog/18-wheeler-wrecks-on-the-arthur-ravenel-jr-bridge-us-17/` |  | 13 | 2731 | 10.3 | 0 | 1 | waiting to 2026-12-08 | — |
| hold | `/blog/motorcycle-accidents-dorchester-road-data/` |  | 12 | 637 | 7.9 | 0 | 26 | waiting to 2026-12-31 | — |
| merge | `/blog/what-to-do-after-a-bike-crash-on-charlestons-ravenel-bridge/` | 3487 | 13 | 1561 | 12.2 | 0 | 1 | unknown | `/blog/a-cyclists-guide-after-a-ravenel-bridge-accident/` |
| merge | `/resources/i-95-truck-accidents-savannah-brunswick/` | 4648 | 5 | 433 | 9.7 | 0 | 28 | unknown | `/blog/savannah-dangerous-highways-i16-i95-abercorn/` |
| merge | `/blog/a-step-by-step-guide-for-folly-road-car-accidents/` | 3451 | 3 | 1721 | 9.5 | 0 | 7 | unknown | `/blog/folly-road-car-accidents-james-island-charleston/` |
| merge | `/resources/abercorn-street-truck-accidents-savannah/` | 4670 | 2 | 380 | 7.9 | 0 | 35 | free | `/blog/savannah-dangerous-highways-i16-i95-abercorn/` |
| merge | `/resources/i-16-truck-accidents-savannah/` | 4649 | 1 | 268 | 10.1 | 0 | 24 | unknown | `/blog/savannah-dangerous-highways-i16-i95-abercorn/` |
| merge | `/resources/ashley-phosphate-i-26-truck-accidents/` | 4664 | 1 | 313 | 8.8 | 0 | 0 | unknown | `/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/` |
| retire (mid) | `/blog/car-accidents-on-i-26-in-north-charleston/` | 3435 | 13 | 4914 | 34.2 | 0 | 22 | unknown | `/car-accident-lawyers/north-charleston-sc/` |
| retire (mid) | `/blog/ben-sawyer-boulevard-bridge-accidents-sullivans-island/` | 4370 | 12 | 1628 | 8.3 | 0 | 88 | unknown | `/car-accident-lawyers/charleston-sc/` |
| retire (mid) | `/blog/maybank-highway-car-accidents-johns-island/` | 4353 | 10 | 1172 | 9.8 | 1 | 116 | unknown | `/car-accident-lawyers/charleston-sc/` |
| retire (mid) | `/blog/car-accidents-on-coleman-boulevard-in-mount-pleasant/` | 3461 | 10 | 1184 | 24.1 | 0 | 13 | unknown | `/car-accident-lawyers/charleston-sc/` |
| retire (mid) | `/blog/filing-an-emotional-distress-claim-after-a-ravenel-bridge-accident/` | 3483 | 10 | 1847 | 13.2 | 0 | 17 | unknown | `/car-accident-lawyers/charleston-sc/` |
| retire | `/resources/georgetown-county-us-17-truck-accidents/` | 4690 | 9 | 839 | 9.5 | 1 | 63 | unknown | `/practice-areas/truck-accident-lawyers/` |
| retire | `/resources/i-20-truck-accidents-columbia/` | 4654 | 8 | 1934 | 9.2 | 0 | 155 | unknown | `/practice-areas/truck-accident-lawyers/` |
| retire | `/resources/bush-river-road-i-26-truck-accidents-columbia/` | 4680 | 8 | 1288 | 9.2 | 0 | 110 | unknown | `/practice-areas/truck-accident-lawyers/` |
| retire | `/resources/dean-forest-road-truck-accidents-pooler/` | 4672 | 7 | 642 | 7.6 | 0 | 56 | free | `/truck-accident-lawyers/savannah-ga/` |
| retire | `/blog/a-guide-to-car-wrecks-on-aviation-avenue-near-charleston-airport/` | 3456 | 6 | 1172 | 23.6 | 0 | 27 | unknown | `/car-accident-lawyers/north-charleston-sc/` |
| retire | `/resources/two-notch-road-truck-accidents-columbia/` | 4679 | 6 | 1383 | 8.8 | 0 | 266 | free | `/practice-areas/truck-accident-lawyers/` |
| retire | `/resources/dorchester-road-truck-accidents-north-charleston/` | 4674 | 5 | 398 | 9.3 | 1 | 163 | unknown | `/practice-areas/truck-accident-lawyers/` |
| retire | `/blog/what-to-do-after-a-car-crash-on-savannah-highway/` | 3444 | 5 | 2364 | 11.7 | 0 | 3 | unknown | `/car-accident-lawyers/charleston-sc/` |
| retire | `/blog/rivers-avenue-pedestrian-deaths-north-charleston/` | 4339 | 5 | 539 | 10.8 | 0 | 16 | unknown | `/practice-areas/pedestrian-accident-lawyers/` |
| retire | `/resources/columbia-i-26-i-20-i-77-interchange-truck-accidents/` | 4656 | 5 | 5863 | 7 | 0 | 40 | unknown | `/practice-areas/truck-accident-lawyers/` |
| retire | `/resources/i-526-construction-zone-truck-accidents-charleston/` | 4685 | 5 | 248 | 7.9 | 0 | 0 | free | `/truck-accident-lawyers/charleston-sc/` |
| retire | `/blog/car-accidents-ladson-i-26-exit-203-danger-zone/` | 4346 | 4 | 748 | 8.2 | 0 | 23 | unknown | `/car-accident-lawyers/north-charleston-sc/` |
| retire | `/resources/highway-22-truck-accidents-conway-bypass/` | 4681 | 4 | 906 | 10.4 | 0 | 199 | unknown | `/practice-areas/truck-accident-lawyers/` |
| retire | `/resources/us-17-sc-544-truck-accidents-surfside-beach/` | 4682 | 3 | 280 | 7.9 | 1 | 131 | unknown | `/practice-areas/truck-accident-lawyers/` |
| retire | `/blog/savannah-highway-truck-accidents-west-ashley-us-17/` | 4338 | 3 | 654 | 8 | 0 | 18 | unknown | `/truck-accident-lawyers/charleston-sc/` |
| retire | `/blog/i-526-expansion-construction-zone-accidents-charleston/` | 4354 | 3 | 357 | 13.7 | 0 | 9 | unknown | `/car-accident-lawyers/charleston-sc/` |
| retire | `/blog/pedestrian-safety-park-circle-north-charleston/` | 4642 | 3 | 682 | 8.1 | 0 | 5 | unknown | `/practice-areas/pedestrian-accident-lawyers/` |
| retire | `/resources/spruill-avenue-port-trucks-north-charleston/` | 4675 | 3 | 436 | 7.8 | 0 | 66 | unknown | `/practice-areas/truck-accident-lawyers/` |
| retire | `/resources/port-access-road-truck-accidents-leatherman-terminal/` | 4676 | 3 | 353 | 7.5 | 0 | 11 | unknown | `/practice-areas/truck-accident-lawyers/` |
| retire | `/resources/aviation-avenue-i-26-truck-accidents/` | 4677 | 3 | 243 | 9.5 | 0 | 6 | unknown | `/practice-areas/truck-accident-lawyers/` |
| retire | `/blog/johns-island-accidents-no-hospital-emergency-room/` | 4347 | 2 | 316 | 12.1 | 0 | 28 | unknown | `/car-accident-lawyers/charleston-sc/` |
| retire | `/resources/i-77-truck-accidents-columbia-rock-hill/` | 4655 | 2 | 1820 | 8.1 | 0 | 51 | free | `/practice-areas/truck-accident-lawyers/` |
| retire | `/blog/daniel-island-accidents-event-traffic-golf-carts/` | 4364 | 1 | 501 | 15.4 | 0 | 2 | free | `/car-accident-lawyers/charleston-sc/` |
| retire | `/blog/west-ashley-vs-downtown-charleston-driving-risks/` | 4366 | 1 | 503 | 11.4 | 0 | 5 | free | `/car-accident-lawyers/charleston-sc/` |
| retire | `/blog/east-bay-street-savannah-pedestrian-accident-lawyer/` | 5001 | 1 | 47 | 39.6 | 0 | 11 | unknown | `/practice-areas/pedestrian-accident-lawyers/` |
| retire | `/resources/i-516-truck-accidents-port-savannah/` | 4650 | 1 | 133 | 11.5 | 0 | 4 | free | `/truck-accident-lawyers/savannah-ga/` |
| retire | `/resources/i-526-truck-accidents-charleston/` | 4661 | 1 | 262 | 9.9 | 0 | 59 | unknown | `/truck-accident-lawyers/charleston-sc/` |
| retire | `/resources/rivers-avenue-truck-accidents-north-charleston/` | 4663 | 1 | 155 | 11.8 | 0 | 46 | unknown | `/practice-areas/truck-accident-lawyers/` |
| retire | `/resources/summerville-truck-accidents-i-26-corridor/` | 4665 | 1 | 348 | 9 | 0 | 2 | unknown | `/practice-areas/truck-accident-lawyers/` |
| retire | `/resources/jimmy-deloach-connector-truck-accidents-savannah/` | 4684 | 1 | 420 | 9.1 | 0 | 16 | unknown | `/truck-accident-lawyers/savannah-ga/` |

## Follow-ups
- Merge carry-over (unique facts onto the targets), at each target's ledger date: `/blog/a-cyclists-guide-after-a-ravenel-bridge-accident/` (ledger unknown), `/blog/folly-road-car-accidents-james-island-charleston/` (waiting to 2027-01-04), `/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/` (waiting to 2026-12-31), `/blog/savannah-dangerous-highways-i16-i95-abercorn/` (waiting to 2027-01-01).
- Floor-check keep-list: the 13 remaining pages fail by decision. Proposed: an allowlist in the toolkit's floor check so pages kept on evidence stop failing the gate.
