# GSC evidence pack — the EVALUATE decisions
**Data:** `docs/gsc-2026-08-24/`, exported 2026-08-24 · **2025-07-23 → 2026-08-22 (13 months)**

This is the analysis `OWNER-CHECKLIST.md` said the EVALUATE rows were blocked on. It
covers both populations the export was needed for: the 48 corridor `/resources/` pages
and the 117 nested location pages.

## Read the export's limits first

`Pages.csv` is **1,000 rows, minimum 1 click**. It is the top pages *by clicks*, so every
page that earned **zero** clicks is absent entirely — and the site has ~1,309 indexable
URLs. Two consequences:

1. Absence from the file is meaningful and is used that way below: **zero clicks in 13
   months.**
2. **Impressions for those pages are unknown.** A page can rank steadily and never be
   clicked. That distinction matters before anything is deleted, and this export cannot
   make it — it needs a GSC API pull or an impressions-sorted export.

Also note the window is **13 months, not the 16** the checklist asked for.

## Site-wide proportion, for scale

Across the top-1,000 pages: **24,691 clicks · 7,810,894 impressions.**

| Population | Pages | With ≥1 click | Clicks | Share |
|---|---:|---:|---:|---:|
| Blog *(guardrail KEEP)* | 484 | 341 | 16,639 | **67.4%** |
| Corridor band *(EVALUATE)* | 48 | 37 | 311 | 1.3% |
| Legal library *(KEEP)* | 19 | 15 | 273 | 1.1% |
| Nested locations *(EVALUATE)* | 117 | 43 | 91 | 0.4% |

The blog is the site, and the guardrails are right about that.

---

## Finding 1 — the corridor band is not dead, and folding all 48 would cost real traffic

I expected this to confirm the pages were doorway chaff. **It does not.**

37 of 48 earn clicks, at average positions of 7–12 — page one. The band earns
**311 clicks** against the legal library's 273, on more pages but in the same order of
magnitude. Per page that is 6.5 vs 14.4, so the library is ~2× better per
URL, but the corridor pages are demonstrably working.

Value is concentrated: the **top 10 carry 234 of 311 clicks (75%)**.

Plan rule 4's own test is "real rankings, traffic or genuine service history." By that
test most of this band passes, and the Steinberg plan's instinct to fold all of them into
the Corridor Report would discard page-one long-tail to build an asset that has to earn
its position from zero.

**Recommendation:** keep the performers as-is; fold only the **11 zero-click
pages** into Study #1 as chapters, with 301s. Revisit the weak tail (1–3 clicks over 13
months, which is noise) once the study exists and can absorb them.

### Corridor pages earning clicks — keep

| Page | Clicks | Impressions | Avg pos |
|---|---:|---:|---:|
| `/resources/i-95-widening-construction-zone-ga-sc/` | 109 | 10375 | 7.19 |
| `/resources/blythewood-i-77-truck-accidents/` | 25 | 3974 | 9.43 |
| `/resources/us-52-truck-train-accidents-goose-creek/` | 23 | 1234 | 8.06 |
| `/resources/bay-street-truck-accidents-savannah-historic-district/` | 19 | 479 | 7.31 |
| `/resources/dangerous-roads-north-charleston/` | 18 | 1694 | 6.77 |
| `/resources/pedestrian-bicycle-safety-north-charleston/` | 10 | 1254 | 8.42 |
| `/resources/georgetown-county-us-17-truck-accidents/` | 8 | 728 | 8.77 |
| `/resources/i-20-truck-accidents-columbia/` | 8 | 1703 | 8.87 |
| `/resources/bush-river-road-i-26-truck-accidents-columbia/` | 7 | 1040 | 9.04 |
| `/resources/dean-forest-road-truck-accidents-pooler/` | 7 | 586 | 7.1 |
| `/resources/port-of-savannah-truck-routes/` | 7 | 392 | 7.9 |
| `/resources/broad-river-road-truck-accidents-columbia/` | 6 | 607 | 11.23 |
| `/resources/two-notch-road-truck-accidents-columbia/` | 6 | 972 | 9.21 |
| `/resources/columbia-i-26-i-20-i-77-interchange-truck-accidents/` | 5 | 5745 | 6.99 |
| `/resources/i-526-construction-zone-truck-accidents-charleston/` | 5 | 240 | 7.97 |
| `/resources/i-95-truck-accidents-savannah-brunswick/` | 5 | 413 | 9.74 |
| `/resources/dorchester-road-truck-accidents-north-charleston/` | 4 | 217 | 9.53 |
| `/resources/aviation-avenue-i-26-truck-accidents/` | 3 | 230 | 9.64 |
| `/resources/highway-22-truck-accidents-conway-bypass/` | 3 | 599 | 10.47 |
| `/resources/i-16-i-95-construction-zone-truck-accidents/` | 3 | 306 | 11 |
| `/resources/logging-truck-accidents-us-17-mcintosh-glynn/` | 3 | 681 | 9.56 |
| `/resources/pooler-warehouse-district-truck-accidents/` | 3 | 515 | 8.06 |
| `/resources/port-access-road-truck-accidents-leatherman-terminal/` | 3 | 338 | 7.56 |
| `/resources/spruill-avenue-port-trucks-north-charleston/` | 3 | 368 | 7.9 |
| `/resources/abercorn-street-truck-accidents-savannah/` | 2 | 345 | 7.94 |
| `/resources/carolina-crossroads-construction-zone-truck-accidents/` | 2 | 544 | 7.55 |
| `/resources/i-77-truck-accidents-columbia-rock-hill/` | 2 | 1727 | 7.89 |
| `/resources/north-charleston-truck-accident-guide/` | 2 | 514 | 11.5 |
| `/resources/us-17-sc-544-truck-accidents-surfside-beach/` | 2 | 249 | 7.61 |
| `/resources/ashley-phosphate-i-26-truck-accidents/` | 1 | 312 | 8.79 |
| `/resources/i-16-truck-accidents-savannah/` | 1 | 242 | 9.97 |
| `/resources/i-516-truck-accidents-port-savannah/` | 1 | 125 | 11.67 |
| `/resources/i-526-truck-accidents-charleston/` | 1 | 210 | 9.15 |
| `/resources/jimmy-deloach-connector-truck-accidents-savannah/` | 1 | 389 | 9.13 |
| `/resources/personal-injury-claim-charleston-county-court/` | 1 | 271 | 12.24 |
| `/resources/rivers-avenue-truck-accidents-north-charleston/` | 1 | 120 | 10.09 |
| `/resources/summerville-truck-accidents-i-26-corridor/` | 1 | 339 | 8.89 |

### Corridor pages with zero clicks in 13 months — fold into Study #1

Impressions unknown per the caveat above; confirm before redirecting.

| Page | Clicks | Impressions | Avg pos |
|---|---:|---:|---:|
| `/resources/construction-zone-accidents-north-charleston/` | 0 | — | — |
| `/resources/highway-501-truck-accidents-conway-myrtle-beach/` | 0 | — | — |
| `/resources/lexington-county-truck-accidents-distribution-corridor/` | 0 | — | — |
| `/resources/mount-pleasant-truck-accidents-wando-welch/` | 0 | — | — |
| `/resources/ogeechee-road-truck-accidents-savannah/` | 0 | — | — |
| `/resources/port-of-charleston-truck-routes/` | 0 | — | — |
| `/resources/rideshare-accident-north-charleston/` | 0 | — | — |
| `/resources/seasonal-truck-accidents-myrtle-beach/` | 0 | — | — |
| `/resources/us-17-truck-accidents-grand-strand/` | 0 | — | — |
| `/resources/what-to-do-after-car-accident-north-charleston/` | 0 | — | — |
| `/resources/workers-comp-north-charleston-warehouse-port/` | 0 | — | — |

---

## Finding 2 — the nested location pages are the dead weight, and it is not close

**74 of 117 earned zero clicks in 13 months.** The 43 that
earned any produced **91 clicks between them** — 0.8 per page over more
than a year. Only two pages clear 5 clicks.

One page is worth naming because it is the doorway signature in a single row:
`/locations/south-carolina/north-charleston/goose-creek/` has **13,248 impressions and 2
clicks**. Google serves it constantly; nobody wants it.

This is the population plan rule 4 was written for, and the data says so far more clearly
than it says anything about the corridor band.

**Recommendation:** the 74 zero-click pages are REMOVE candidates under rule 4,
301 to the parent office-city hub — the same chain-proof target batch (a) used. The
43 with clicks split at a natural break: Woodbine (21) and Folkston (6) are
worth keeping; the rest sit at 1–4 clicks over 13 months.

**This is a deletion decision on 74+ URLs and needs owner sign-off before any
batch is built.**

### Nested location pages earning clicks

| Page | Clicks | Impressions | Avg pos |
|---|---:|---:|---:|
| `/locations/georgia/darien/woodbine/` | 21 | 2227 | 9.77 |
| `/locations/georgia/darien/folkston/` | 6 | 1218 | 14.27 |
| `/locations/georgia/darien/st-simons-island/` | 4 | 1727 | 8.32 |
| `/locations/georgia/darien/waycross/` | 4 | 1358 | 9.73 |
| `/locations/georgia/darien/brunswick/` | 3 | 2554 | 12.39 |
| `/locations/south-carolina/columbia/forest-acres/` | 3 | 667 | 9.05 |
| `/locations/south-carolina/charleston/mount-pleasant/` | 3 | 713 | 19.28 |
| `/locations/georgia/darien/nahunta/` | 3 | 2595 | 7.03 |
| `/locations/south-carolina/north-charleston/summerville/` | 3 | 364 | 26.03 |
| `/locations/south-carolina/myrtle-beach/carolina-forest/` | 2 | 179 | 12.03 |
| `/locations/south-carolina/columbia/elgin/` | 2 | 779 | 24.21 |
| `/locations/south-carolina/north-charleston/goose-creek/` | 2 | 13248 | 12.92 |
| `/locations/georgia/darien/jekyll-island/` | 2 | 355 | 12.46 |
| `/locations/georgia/darien/kingsland/` | 2 | 1521 | 11.98 |
| `/locations/georgia/darien/sea-island/` | 2 | 63 | 8.78 |
| `/locations/south-carolina/myrtle-beach/surfside-beach/` | 2 | 641 | 11.72 |
| `/locations/georgia/darien/alma/` | 1 | 608 | 9.5 |
| `/locations/south-carolina/myrtle-beach/andrews/` | 1 | 188 | 23.25 |
| `/locations/south-carolina/columbia/batesburg-leesville/` | 1 | 661 | 24.56 |
| `/locations/georgia/darien/blackshear/` | 1 | 447 | 10.77 |
| `/locations/georgia/savannah/bryan-county/` | 1 | 141 | 9.62 |
| `/locations/south-carolina/columbia/cayce/` | 1 | 491 | 9.25 |
| `/locations/south-carolina/columbia/chapin/` | 1 | 216 | 12.08 |
| `/locations/south-carolina/myrtle-beach/conway/` | 1 | 1129 | 11.66 |
| `/locations/south-carolina/myrtle-beach/georgetown/` | 1 | 535 | 13.52 |
| `/locations/georgia/darien/harrietts-bluff/` | 1 | 182 | 8.85 |
| `/locations/georgia/savannah/hinesville/` | 1 | 320 | 11.49 |
| `/locations/georgia/darien/hoboken/` | 1 | 948 | 9.37 |
| `/locations/south-carolina/charleston/isle-of-palms/` | 1 | 254 | 7.74 |
| `/locations/south-carolina/charleston/james-island/` | 1 | 693 | 12.16 |
| `/locations/georgia/darien/jesup/` | 1 | 749 | 10.39 |
| `/locations/georgia/darien/kings-bay/` | 1 | 712 | 8.16 |
| `/locations/south-carolina/north-charleston/ladson/` | 1 | 458 | 13.55 |
| `/locations/south-carolina/myrtle-beach/little-river/` | 1 | 1499 | 7.69 |
| `/locations/south-carolina/columbia/lugoff/` | 1 | 587 | 8.27 |
| `/locations/south-carolina/myrtle-beach/murrells-inlet/` | 1 | 1777 | 17 |
| `/locations/georgia/savannah/pooler/` | 1 | 227 | 14.07 |
| `/locations/georgia/savannah/port-wentworth/` | 1 | 586 | 9.75 |
| `/locations/south-carolina/columbia/red-bank/` | 1 | 319 | 9.37 |
| `/locations/georgia/savannah/skidaway-island/` | 1 | 329 | 15.88 |
| `/locations/georgia/savannah/statesboro/` | 1 | 571 | 11.14 |
| `/locations/south-carolina/columbia/west-columbia/` | 1 | 773 | 10.08 |
| `/locations/georgia/savannah/whitemarsh-island/` | 1 | 116 | 10.65 |

### Zero clicks in 13 months — 74 pages

| Page | Clicks | Impressions | Avg pos |
|---|---:|---:|---:|
| `/locations/south-carolina/myrtle-beach/atlantic-beach/` | 0 | — | — |
| `/locations/south-carolina/charleston/awendaw/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/aynor/` | 0 | — | — |
| `/locations/georgia/savannah/bloomingdale/` | 0 | — | — |
| `/locations/south-carolina/columbia/blythewood/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/briarcliffe-acres/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/bucksport/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/burgess/` | 0 | — | — |
| `/locations/south-carolina/columbia/camden/` | 0 | — | — |
| `/locations/south-carolina/columbia/dentsville/` | 0 | — | — |
| `/locations/georgia/darien/dock-junction/` | 0 | — | — |
| `/locations/south-carolina/charleston/edisto-island/` | 0 | — | — |
| `/locations/georgia/savannah/effingham-county/` | 0 | — | — |
| `/locations/georgia/darien/eulonia/` | 0 | — | — |
| `/locations/south-carolina/charleston/folly-beach/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/forestbrook/` | 0 | — | — |
| `/locations/south-carolina/fort-mill/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/galivants-ferry/` | 0 | — | — |
| `/locations/georgia/savannah/garden-city/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/garden-city-beach/` | 0 | — | — |
| `/locations/south-carolina/columbia/gaston/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/green-sea/` | 0 | — | — |
| `/locations/south-carolina/greer/` | 0 | — | — |
| `/locations/georgia/savannah/guyton/` | 0 | — | — |
| `/locations/south-carolina/north-charleston/hanahan/` | 0 | — | — |
| `/locations/south-carolina/hilton-head/` | 0 | — | — |
| `/locations/south-carolina/charleston/hollywood/` | 0 | — | — |
| `/locations/south-carolina/columbia/hopkins/` | 0 | — | — |
| `/locations/south-carolina/columbia/irmo/` | 0 | — | — |
| `/locations/georgia/savannah/isle-of-hope/` | 0 | — | — |
| `/locations/south-carolina/charleston/johns-island/` | 0 | — | — |
| `/locations/south-carolina/charleston/kiawah-island/` | 0 | — | — |
| `/locations/south-carolina/columbia/lexington/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/litchfield-beach/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/longs/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/loris/` | 0 | — | — |
| `/locations/georgia/darien/ludowici/` | 0 | — | — |
| `/locations/south-carolina/charleston/mcclellanville/` | 0 | — | — |
| `/locations/south-carolina/charleston/meggett/` | 0 | — | — |
| `/locations/south-carolina/north-charleston/moncks-corner/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/north-myrtle-beach/` | 0 | — | — |
| `/locations/south-carolina/columbia/oak-grove/` | 0 | — | — |
| `/locations/georgia/darien/odum/` | 0 | — | — |
| `/locations/south-carolina/orangeburg/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/pawleys-island/` | 0 | — | — |
| `/locations/south-carolina/columbia/pelion/` | 0 | — | — |
| `/locations/south-carolina/columbia/pine-ridge/` | 0 | — | — |
| `/locations/south-carolina/charleston/ravenel/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/red-hill/` | 0 | — | — |
| `/locations/georgia/savannah/richmond-hill/` | 0 | — | — |
| `/locations/georgia/savannah/rincon/` | 0 | — | — |
| `/locations/south-carolina/rock-hill/` | 0 | — | — |
| `/locations/georgia/darien/screven/` | 0 | — | — |
| `/locations/south-carolina/charleston/seabrook-island/` | 0 | — | — |
| `/locations/south-carolina/columbia/seven-oaks/` | 0 | — | — |
| `/locations/south-carolina/simpsonville/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/socastee/` | 0 | — | — |
| `/locations/south-carolina/columbia/south-congaree/` | 0 | — | — |
| `/locations/south-carolina/spartanburg/` | 0 | — | — |
| `/locations/south-carolina/columbia/springdale/` | 0 | — | — |
| `/locations/georgia/savannah/springfield/` | 0 | — | — |
| `/locations/south-carolina/columbia/st-andrews/` | 0 | — | — |
| `/locations/georgia/darien/st-marys/` | 0 | — | — |
| `/locations/south-carolina/charleston/sullivans-island/` | 0 | — | — |
| `/locations/south-carolina/sumter/` | 0 | — | — |
| `/locations/georgia/savannah/thunderbolt/` | 0 | — | — |
| `/locations/georgia/darien/townsend/` | 0 | — | — |
| `/locations/georgia/savannah/tybee-island/` | 0 | — | — |
| `/locations/south-carolina/charleston/wadmalaw-island/` | 0 | — | — |
| `/locations/south-carolina/myrtle-beach/wampee/` | 0 | — | — |
| `/locations/georgia/darien/waverly/` | 0 | — | — |
| `/locations/georgia/darien/white-oak/` | 0 | — | — |
| `/locations/georgia/savannah/wilmington-island/` | 0 | — | — |
| `/locations/south-carolina/columbia/woodfield/` | 0 | — | — |
