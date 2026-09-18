# GSC evidence pack — the intersection layer and the sub-municipal blog

**Data:** `docs/gsc-2026-09-18/` and the site-wide pulls behind this document, from the
Search Console API via `gsc-fetch.py --mode pages` against the URL-prefix property
`https://rodenlaw.com/`. **16 months to 2026-09-15**, with a 90-day window (2026-06-15 on)
as a check. Classification of every sitemap URL is the vendored site-health doorway check,
the same one the post-deploy job runs.

This is the evidence for the two owner decisions the 2026-09-18 doorway audit said were
needed: reopening plan rule 6 for the office-city intersections, and applying the corridor-
band per-post test to the blog's sub-municipal posts. Both were approved 2026-09-18.

## Where the ratio stood

After #141 retired the 13 EVALUATE location pages: **486 of 1,217 indexable URLs, 39.9%**,
against a 25% ceiling. What carries it:

| Bucket | URLs | Below floor | Zero clicks, 16 mo | Clicks, 16 mo |
|---|---:|---:|---:|---:|
| Blog (EN) | 193 | 92 | 61 | 1,949 |
| Intersections (EN) | 138 | 1 | 93 | 95 |
| ES intersections | 39 | 0 | 36 | 3 |
| Locations (hubs, states, office cities) | 38 | 0 | 0 | 426 |
| Resources (truck-corridor series) | 38 | 26 | 1 | 335 |
| ES blog | 28 | 24 | 28 | 0 |
| Legacy root city pages | 6 | 0 | 5 | 1 |
| ES locations | 6 | 0 | 4 | 4 |

## Finding 1 — the office-city intersections fail the #68 test, at ten times the scale

Plan rule 6 kept city × practice pages in the six office markets as "the defensible tier".
The recovery log said on 2026-08-25 that "all 175 surviving city×practice pages are in the
six office markets, which is the defensible tier under rule 6". That was a rule judgment.
Nobody had measured the tier.

**798,103 impressions. 98 clicks. CTR 0.01% in every position band.**

| Avg position | Rest of site | The 177 intersections | | | Expected at site rate |
|---|---:|---:|---:|---:|---:|
| | CTR | impressions | clicks | CTR | |
| 5–10 | 0.47% | 5,287 | 0 | 0.00% | 25 |
| 10–15 | 0.43% | 114,777 | 16 | 0.01% | 495 |
| 15–20 | 0.28% | 308,335 | 42 | 0.01% | 855 |
| 20+ | 0.12% | 369,704 | 40 | 0.01% | 460 |

At the site's own rates those impressions predict about 1,800 clicks. The best page in the
layer, `/car-accident-lawyers/columbia-sc/`, earned 9 clicks on 55,955 impressions. The
Charleston car-accident intersection earned 6 on 88,998. Google serves these pages
constantly and nobody wants them: the doorway signature the 2026-08-24 pack named for the
66, here on a layer that is 23 practices × 6 cities plus a Spanish mirror.

**129 of the 177 have zero clicks in 16 months, on 232,293 impressions.** 13 of those were
never served at all. By city: Charleston 51, Myrtle Beach 20, Darien 20, Savannah 20,
Columbia 18. Every Spanish intersection but three is in the set.

By practice, the layer's whole click yield:

| Practice | Pages | Clicks | Impressions |
|---|---:|---:|---:|
| car-accident-lawyers | 11 | 22 | 263,688 |
| medical-malpractice-lawyers | 6 | 20 | 69,038 |
| workers-compensation-lawyers | 12 | 10 | 72,160 |
| premises-liability-lawyers | 6 | 6 | 13,730 |
| dog-bite-lawyers | 6 | 5 | 36,629 |
| every other practice (18) | 136 | 35 | 342,858 |

**Recommendation — APPROVED 2026-09-18:** retire the 129 zero-click intersections, 301 to
the practice pillar, as batch (d) did for the non-office cities. The 48 that earned a click
are a separate decision; they earn 98 clicks between them and keeping them costs about 3.5
points of ratio.

## Finding 2 — the blog's sub-municipal posts: keep the earners, fold the zero-click set

The blog is guardrail-protected as a population and the data still says it should be: 67%
of the site's clicks. The 143 sub-floor posts and resources earned 881 clicks, and the top
of the set is genuine: the Ravenel Bridge cyclist guide at 113, the Litchfield/Pawleys US-17
post at 80, the I-95 Glynn County motorcycle post at 62. **None of those move.**

**60 sub-floor blog posts have zero clicks in 16 months, on 6,526 impressions between
them.** 36 English, 24 Spanish twins. Most are the local-SEO pipeline's street-plus-
subdivision output from July and August (`wando-gardens-faber-place-drive-…`,
`green-grove-mark-clark-expressway-…`, `n-lake-drive-dick-pond-road-sc-544-…`), which the
Q4 strategy already identified as sub-municipal targeting against a failing floor.

This is the corridor-band test from 2026-08-24, applied per post: fold the zero-click set,
keep the performers. It does not reopen the blog protection; it applies the plan's own rule
4 test inside it.

**Recommendation — APPROVED 2026-09-18:** retire the 60, 301 to the practice pillar the
slug names (car, truck, motorcycle, pedestrian, boating, ATV, golf cart; rideshare, drunk-
driving, bus and uninsured-motorist posts to car accidents), Spanish posts to the Spanish
pillar. Plan rule 5's treatment for micro-permutations.

## What this does to the ratio

| Step | Retire | Indexable | Location-targeted | Ratio |
|---|---:|---:|---:|---:|
| After #141 | | 1,217 | 486 | 39.9% |
| 1. The 129 zero-click intersections | 129 | 1,088 | 357 | 32.8% |
| 2. The 60 zero-click sub-floor posts | 60 | 1,028 | 297 | 28.9% |
| 3. The 48 earning intersections (not decided) | 48 | 980 | 249 | 25.4% |
| 4. The 6 legacy root city pages (not decided) | 6 | 974 | 243 | 24.9% |

Steps 1 and 2 are this batch. After them, 25% needs either step 3 and 4 or roughly 160
substantive non-location pages.

## Not in this batch, and why

- **The 48 intersections with clicks.** Weak (98 clicks on 565,810 impressions) but not
  zero. Decide with the reference-layer pace in view: keeping them means the reference
  layer has to produce ~160 pages to reach the ceiling.
- **The 83 sub-floor posts that earn.** Guardrail keep, and the data agrees.
- **The 6 root pages for Greenville, Spartanburg and Florence.** Created 2026-06-30 with the
  other PI landing pages, 1 click between them. If Google Ads lands on them they need a
  noindex or a new final URL, not a 301. Check the campaigns first.
- **The truck-corridor resources.** 26 below the floor, but 37 of 38 earn clicks; the
  2026-08-24 pack already settled this band.
