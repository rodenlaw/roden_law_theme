# Cull evidence — sub-municipal locations and pipeline street posts, 2026-09-25

**Status: for owner review. Nothing has been changed.**

Search Console API against `sc-domain:rodenlaw.com`, 2025-05-12 → 2026-09-21 (16 months) and
2026-08-24 → 09-21 (28 days). Pre-flight read-only on prod the same day. Machine-readable map:
`docs/cull-map-2026-09-25.csv`.

## Why now

The doorway check reads **243 / 824 = 29.49%, FAIL** (ceiling 25%). The case-results fold (#146)
removed 156 non-place URLs, so the ratio rose without a single place page being added. The two groups
below are what is left of the scaled place layer besides the blog posts that earn:

| Group | URLs | Clicks 16 mo | Clicks 28 d | Zero-click 16 mo | ≥5 clicks 16 mo |
|---|---:|---:|---:|---:|---:|
| Sub-municipal location pages (`/locations/<state>/<office>/<town>/`) | 30 | 81 | 9 | 0 | 3 |
| Local-SEO pipeline street/place posts (41 EN, 5 ES) | 46 | 340 | 5 | 13 | 13 |

## The trend is the finding

| Period | Pipeline clicks / impr | Sub-municipal clicks / impr |
|---|---:|---:|
| 2026-04 | 0 / 0 | 38 / 10,395 |
| 2026-05 | 148 / 5,524 | 18 / 15,495 |
| 2026-06 | 131 / 7,986 | 9 / 6,296 |
| 2026-07 | 30 / 2,587 | 1 / 1,987 |
| Aug 24 → Sep 21 (4 wk) | 4 / 2,036 | 9 / 4,833 |

82% of the pipeline posts' lifetime clicks came in May and June, before the May core update
landed. Since the August spam update they earn about one click a week between all 46.

**The CTR test does not condemn them.** At matched positions the location pages earned 0.49× the
site's blog/resource rate over 16 months but 1.65× in the last 90 days; the pipeline posts 1.87×
then 0×. With 21 and 13 query-visible clicks the samples are too small either way. So this isn't
the "shown and refused" signature of the 09-18 intersections. The case is volume, trend and the
ratio, not refusal.

## Effect on the ratio (vendored classifier)

| Scope | Place / total | Ratio |
|---|---:|---:|
| Now | 243 / 824 | 29.49% FAIL |
| Retire the 30 locations only | 213 / 794 | 26.83% FAIL |
| Retire the 46 posts only | 200 / 778 | 25.71% FAIL |
| **Retire both (76)** | **170 / 748** | **22.73% PASS** |
| Both, keeping Brunswick | 171 / 749 | 22.83% PASS |

73 of the 76 are counted as place pages; 27 are below the municipality floor.

## Pre-flight (prod, read-only)

- All 76 resolve (30 `location`, 46 `post`). **Zero published children** under any location.
- Spanish twins: 11 of the English posts have one. 5 are published and **all 5 are in this batch**. The
  other 6 are already in the trash. No live twin would be renamed `__trashed`.
- **8 of the 76 are linked from outside posts: 32 post-links in all** (each linking post counted once per URL), all needing a relink to the targets (mostly the
  Mount Pleasant, Summerville, Goose Creek, James Island and Isle of Palms location pages, and four
  early pipeline posts). **Zero** `_roden_see_also` or other meta references.
- Every target is a published pillar or office page (all 47 pillar URLs checked against the live sitemap).

Redirect rules, following the 09-18 batch: a post goes to the practice pillar its slug names
(`/es/` twin → the `/es/` pillar). `uninsured`, `drunk-driver`, `hit-and-run`, `rideshare` go to car
accident; `18-wheeler` and `freight` to truck. A location goes to its parent office page.

## Judgment calls for the owner

1. **Brunswick** (`/locations/georgia/darien/brunswick/`) is the only page in either group earning
   now: 7 of its 10 lifetime clicks came in the last 28 days, on 1,254 impressions. The old Business
   Profile URL `www.rodenlaw.com/brunswick/personal-injury-lawyer/` still sends traffic toward
   Brunswick. Keeping it costs 0.1 points of ratio. **Recommend keep.**
2. **Woodbine** has 21 clicks, the most in the location group, but 0 in the last 28 days. Recommend retire.
3. **The Litchfield Beach post** (80 clicks) and **the I-95 motorcycle post** (62) were the pipeline's two
   real performers. Both have 0 clicks in the last 28 days. The I-16 port freight post was refreshed on
   09-24 by the freshness loop (24 clicks, 0 recent). Recommend retire all three; the refresh was not
   a decision to keep it.
4. This reverses the 09-18 "blog protection stands" rule for these 33 posts that earned a click, and the
   09-19 note that the location hubs were legitimate. Both were decided on 16-month totals, which the
   trend above no longer supports.

## Sub-municipal location pages (30)

| Path | Clicks 16 mo | Impr 16 mo | Pos | Clicks 28 d | Impr 28 d | Posts linking in | → Target |
|---|---:|---:|---:|---:|---:|---:|---|
| `/locations/georgia/darien/woodbine/` | 21 | 2416 | 10.1 | 0 | 186 | 0 | `/locations/georgia/darien/` |
| `/locations/georgia/darien/brunswick/` | 10 | 3810 | 13.8 | 7 | 1254 | 0 | `/locations/georgia/darien/` |
| `/locations/georgia/darien/folkston/` | 6 | 1331 | 14.4 | 0 | 111 | 0 | `/locations/georgia/darien/` |
| `/locations/georgia/darien/waycross/` | 4 | 1396 | 9.8 | 0 | 38 | 0 | `/locations/georgia/darien/` |
| `/locations/georgia/darien/nahunta/` | 3 | 2630 | 7.0 | 0 | 35 | 0 | `/locations/georgia/darien/` |
| `/locations/south-carolina/charleston/mount-pleasant/` | 3 | 2069 | 17.1 | 0 | 1238 | 10 | `/locations/south-carolina/charleston/` |
| `/locations/south-carolina/columbia/forest-acres/` | 3 | 753 | 8.9 | 0 | 84 | 0 | `/locations/south-carolina/columbia/` |
| `/locations/south-carolina/north-charleston/summerville/` | 3 | 477 | 26.1 | 0 | 108 | 5 | `/locations/south-carolina/north-charleston/` |
| `/locations/south-carolina/north-charleston/goose-creek/` | 2 | 13975 | 13.7 | 0 | 706 | 4 | `/locations/south-carolina/north-charleston/` |
| `/locations/georgia/darien/kingsland/` | 2 | 1709 | 12.9 | 0 | 187 | 0 | `/locations/georgia/darien/` |
| `/locations/south-carolina/columbia/west-columbia/` | 2 | 1053 | 12.5 | 1 | 280 | 0 | `/locations/south-carolina/columbia/` |
| `/locations/south-carolina/columbia/elgin/` | 2 | 833 | 24.3 | 0 | 54 | 0 | `/locations/south-carolina/columbia/` |
| `/locations/south-carolina/myrtle-beach/surfside-beach/` | 2 | 644 | 11.7 | 0 | 3 | 0 | `/locations/south-carolina/myrtle-beach/` |
| `/locations/georgia/darien/alma/` | 2 | 643 | 9.5 | 1 | 35 | 0 | `/locations/georgia/darien/` |
| `/locations/south-carolina/myrtle-beach/conway/` | 1 | 1185 | 11.8 | 0 | 55 | 0 | `/locations/south-carolina/myrtle-beach/` |
| `/locations/georgia/darien/hoboken/` | 1 | 949 | 9.4 | 0 | 1 | 0 | `/locations/georgia/darien/` |
| `/locations/south-carolina/charleston/james-island/` | 1 | 899 | 13.3 | 0 | 205 | 3 | `/locations/south-carolina/charleston/` |
| `/locations/georgia/darien/jesup/` | 1 | 756 | 10.4 | 0 | 7 | 0 | `/locations/georgia/darien/` |
| `/locations/south-carolina/columbia/batesburg-leesville/` | 1 | 667 | 24.4 | 0 | 6 | 0 | `/locations/south-carolina/columbia/` |
| `/locations/georgia/savannah/port-wentworth/` | 1 | 611 | 10.2 | 0 | 25 | 0 | `/locations/georgia/savannah/` |
| `/locations/georgia/savannah/statesboro/` | 1 | 577 | 11.1 | 0 | 5 | 0 | `/locations/georgia/savannah/` |
| `/locations/south-carolina/myrtle-beach/georgetown/` | 1 | 540 | 13.6 | 0 | 5 | 0 | `/locations/south-carolina/myrtle-beach/` |
| `/locations/south-carolina/columbia/cayce/` | 1 | 518 | 9.3 | 0 | 27 | 0 | `/locations/south-carolina/columbia/` |
| `/locations/georgia/darien/blackshear/` | 1 | 472 | 10.9 | 0 | 25 | 0 | `/locations/georgia/darien/` |
| `/locations/georgia/savannah/hinesville/` | 1 | 328 | 11.5 | 0 | 8 | 0 | `/locations/georgia/savannah/` |
| `/locations/south-carolina/charleston/isle-of-palms/` | 1 | 312 | 9.6 | 0 | 58 | 6 | `/locations/south-carolina/charleston/` |
| `/locations/south-carolina/myrtle-beach/andrews/` | 1 | 241 | 22.8 | 0 | 53 | 0 | `/locations/south-carolina/myrtle-beach/` |
| `/locations/georgia/savannah/pooler/` | 1 | 229 | 14.0 | 0 | 2 | 0 | `/locations/georgia/savannah/` |
| `/locations/south-carolina/columbia/chapin/` | 1 | 218 | 12.0 | 0 | 2 | 0 | `/locations/south-carolina/columbia/` |
| `/locations/georgia/savannah/bryan-county/` | 1 | 146 | 9.9 | 0 | 5 | 0 | `/locations/georgia/savannah/` |

## Pipeline street/place posts (46)

| Path | Clicks 16 mo | Impr 16 mo | Pos | Clicks 28 d | Impr 28 d | Posts linking in | → Target |
|---|---:|---:|---:|---:|---:|---:|---|
| `/blog/litchfield-beach-pawleys-island-us-17-car-accident-georgetown-county/` | 80 | 2795 | 6.0 | 0 | 247 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/motorcycle-accident-i-95-glynn-county-brunswick-darien/` | 62 | 2024 | 11.8 | 0 | 234 | 0 | `/practice-areas/motorcycle-accident-lawyers/` |
| `/blog/us-17-truck-accident-broadfield-glynn-county/` | 31 | 1440 | 11.3 | 1 | 118 | 0 | `/practice-areas/truck-accident-lawyers/` |
| `/blog/i-16-port-freight-truck-accident-garden-city-savannah/` | 24 | 1573 | 7.9 | 0 | 138 | 0 | `/practice-areas/truck-accident-lawyers/` |
| `/blog/us-17-i-95-darien-wrongful-death-mcintosh-county/` | 21 | 1393 | 9.1 | 0 | 188 | 0 | `/practice-areas/wrongful-death-lawyers/` |
| `/blog/drunk-driver-crash-south-kings-highway-us-17-business-surfside-beach-29575/` | 20 | 496 | 7.5 | 0 | 39 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/i-77-truck-accident-northeast-columbia-richland-county/` | 16 | 1471 | 8.7 | 1 | 204 | 0 | `/practice-areas/truck-accident-lawyers/` |
| `/blog/sunset-boulevard-us-378-lexington-medical-center-accident/` | 14 | 986 | 7.4 | 0 | 123 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/hit-and-run-drunk-driver-crashes-ashley-river-road-sc-61-west-ashley-greenwood-park/` | 13 | 484 | 7.7 | 1 | 69 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/north-rhett-avenue-truck-accident-hanahan-berkeley-county/` | 10 | 583 | 8.5 | 1 | 87 | 0 | `/practice-areas/truck-accident-lawyers/` |
| `/blog/pedestrian-accident-dorchester-road-school-zone-29418-north-charleston/` | 8 | 594 | 7.4 | 0 | 35 | 0 | `/practice-areas/pedestrian-accident-lawyers/` |
| `/blog/i-526-mount-pleasant-wando-bridge-accident/` | 6 | 884 | 8.2 | 0 | 14 | 1 | `/practice-areas/car-accident-lawyers/` |
| `/blog/rifle-range-road-mount-pleasant-car-accident-heritage-park-west/` | 6 | 749 | 9.2 | 0 | 88 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/credit-one-stadium-event-day-crashes-daniel-island-beekman-street/` | 4 | 417 | 8.9 | 1 | 95 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/daniel-island-i-526-wando-bridge-truck-accident-berkeley-county/` | 3 | 599 | 6.9 | 0 | 21 | 0 | `/practice-areas/truck-accident-lawyers/` |
| `/blog/mount-pleasant-johnnie-dodds-us-17-wrongful-death-car-accident-lawyer/` | 3 | 186 | 10.8 | 0 | 17 | 0 | `/practice-areas/wrongful-death-lawyers/` |
| `/blog/surfside-beach-golf-colony-golf-cart-accident-lawyer/` | 2 | 197 | 12.3 | 0 | 8 | 0 | `/practice-areas/golf-cart-accident-lawyers/` |
| `/blog/litchfield-pawleys-island-golf-cart-accident-lawyer-georgetown-county/` | 2 | 117 | 12.1 | 0 | 12 | 0 | `/practice-areas/golf-cart-accident-lawyers/` |
| `/blog/atlantic-coastal-highway-us-17-rideshare-uber-lyft-crash-savannah-intermodal-transit-center/` | 1 | 389 | 9.6 | 0 | 9 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/rideshare-accident-i-26-tenmile-north-charleston/` | 1 | 382 | 9.5 | 0 | 6 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/columbia-airport-expressway-us-378-truck-accident-springdale-lexington-county/` | 1 | 227 | 19.1 | 0 | 8 | 2 | `/practice-areas/truck-accident-lawyers/` |
| `/blog/eulonia-us-17-ocean-highway-rideshare-uber-accident-lawyer-mcintosh-county/` | 1 | 215 | 8.7 | 0 | 29 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/mcintosh-county-drunk-driver-accident-lawyer/` | 1 | 163 | 11.0 | 0 | 8 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/international-boulevard-airport-rideshare-uber-lyft-crash-north-charleston/` | 1 | 139 | 7.9 | 0 | 3 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/hanahan-murray-avenue-highland-park-bicycle-accident-lawyer/` | 1 | 129 | 12.1 | 0 | 5 | 0 | `/practice-areas/bicycle-accident-lawyers/` |
| `/blog/mount-pleasant-johnnie-dodds-us-17-uninsured-motorist-lawyer/` | 1 | 99 | 9.2 | 0 | 20 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/st-andrews-road-widewater-18-wheeler-accident-lawyer-richland-county/` | 1 | 85 | 11.3 | 0 | 5 | 0 | `/practice-areas/truck-accident-lawyers/` |
| `/blog/old-fort-jackson-savannah-fatal-truck-accident-lawyer/` | 1 | 85 | 14.5 | 0 | 51 | 0 | `/practice-areas/truck-accident-lawyers/` |
| `/blog/mount-pleasant-mark-clark-expressway-i-526-motorcycle-accident-lawyer/` | 1 | 77 | 8.7 | 0 | 16 | 0 | `/practice-areas/motorcycle-accident-lawyers/` |
| `/blog/yamacraw-village-pedestrian-accident-lawyer/` | 1 | 65 | 14.0 | 0 | 1 | 0 | `/practice-areas/pedestrian-accident-lawyers/` |
| `/blog/garden-city-ga-21-augusta-road-car-accident-lawyer/` | 1 | 55 | 13.0 | 0 | 30 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/cayce-12th-street-uninsured-motorist-lawyer/` | 1 | 48 | 16.9 | 0 | 8 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/south-kings-highway-us-17-business-underinsured-motorist-lawyer/` | 1 | 42 | 19.0 | 0 | 3 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/dog-bite-surfside-beach-29575/` | 0 | 438 | 13.6 | 0 | 20 | 0 | `/practice-areas/dog-bite-lawyers/` |
| `/blog/eastern-wharf-harbor-street-electric-scooter-accident-lawyer/` | 0 | 237 | 5.9 | 0 | 16 | 0 | `/practice-areas/electric-scooter-accident-lawyers/` |
| `/blog/eastern-wharf-savannah-pedestrian-bike-accidents/` | 0 | 213 | 9.9 | 0 | 6 | 1 | `/practice-areas/pedestrian-accident-lawyers/` |
| `/blog/boys-estate-glynn-county-best-car-accident-lawyer/` | 0 | 195 | 8.4 | 0 | 73 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/garden-city-eden-loop-truck-accident-lawyer/` | 0 | 153 | 12.8 | 0 | 21 | 0 | `/practice-areas/truck-accident-lawyers/` |
| `/blog/darien-river-boating-accident-lawyer/` | 0 | 109 | 15.8 | 0 | 3 | 0 | `/practice-areas/boating-accident-lawyers/` |
| `/blog/savannah-veterans-parkway-car-accident-lawyer/` | 0 | 79 | 16.3 | 0 | 7 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/blog/n-lake-drive-us-17-business-best-car-accident-lawyer/` | 0 | 48 | 23.1 | 0 | 9 | 0 | `/practice-areas/car-accident-lawyers/` |
| `/es/blog/eastern-wharf-harbor-street-electric-scooter-accident-lawyer/` | 0 | 32 | 25.1 | 0 | 13 | 0 | `/es/practice-areas/electric-scooter-accident-lawyers/` |
| `/es/blog/n-lake-drive-us-17-business-best-car-accident-lawyer/` | 0 | 29 | 39.8 | 0 | 5 | 0 | `/es/practice-areas/car-accident-lawyers/` |
| `/es/blog/eulonia-us-17-ocean-highway-rideshare-uber-accident-lawyer-mcintosh-county/` | 0 | 24 | 15.4 | 0 | 0 | 0 | `/es/practice-areas/car-accident-lawyers/` |
| `/es/blog/boys-estate-glynn-county-best-car-accident-lawyer/` | 0 | 0 |  | 0 | 0 | 0 | `/es/practice-areas/car-accident-lawyers/` |
| `/es/blog/old-fort-jackson-savannah-fatal-truck-accident-lawyer/` | 0 | 0 |  | 0 | 0 | 0 | `/es/practice-areas/truck-accident-lawyers/` |
