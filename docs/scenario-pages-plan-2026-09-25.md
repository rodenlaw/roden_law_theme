# Practice-area scenario pages — plan, 2026-09-25

**Status: step 1 in progress (template fix PR). Step 2 (retirement) needs the owner's go.**

The 196 flat `/<practice>-lawyers/<scenario>/` pages. Search Console (`sc-domain:rodenlaw.com`,
16 months to 2026-09-21, plus 90- and 28-day windows, flat and nested URL forms summed); all 196
rendered live on 2026-09-25 and compared shingle by shingle (8-word, place names masked);
read-only prod pre-flight the same day. Per-page data: `docs/scenario-pages-2026-09-25.csv`.

## What they are

| Group | Pages | Words | Template | Closest-sibling overlap | Pillar overlap | Clicks 16 mo / 90 d / 28 d |
|---|---:|---:|---:|---:|---:|---|
| Class action / mass tort (`/class-action-lawyers/*`) | 14 | 1,768 | 0% | 1% | 0% | 138 / 33 / 11 |
| Practice scenarios | 182 | 2,015 | 39% | 52% | 43% | 397 / 142 / 55 |

**The class-action pages are original. Leave them alone.**

**The scenario pages are real pages inside a shared wrapper.** Each carries about 900 words of its
own: median 936 shingles found on no sibling, not in the template and not on the pillar. The other
~1,100 words are the pillar's generic blocks, re-rendered on every child: four elements of
negligence, economic vs. non-economic damages, the statute-of-limitations section, the comparative
fault boxes, "Results at a Glance". That is why 123 of 182 share half or more of their text with a
sibling.

They earn and are not collapsing, unlike the pipeline posts: 55 clicks in the last 28 days, 31 pages
with a click in that window. The clicks are spread out: the top 10 hold 160 of 397.

All 182 were published in the March 2026 rebuild (176 in March, 6 in April), so every page has had
six months. No live Spanish twins. 127 are linked from other posts' bodies.

## Top earners

| Path | Clicks 16 mo | 90 d | 28 d | Impr 90 d | Pos 90 d |
|---|---:|---:|---:|---:|---:|
| `/dog-bite-lawyers/dog-on-dog-attack/` | 40 | 19 | 4 | 2196 | 10.8 |
| `/nursing-home-abuse-lawyers/financial-exploitation-seniors/` | 33 | 13 | 5 | 1524 | 12.5 |
| `/car-accident-lawyers/government-vehicle-accident/` | 13 | 5 | 2 | 795 | 10.8 |
| `/dog-bite-lawyers/landlord-liability-dog-attack/` | 12 | 6 | 3 | 321 | 10.9 |
| `/product-liability-lawyers/dangerous-pharmaceutical-drug/` | 12 | 8 | 4 | 1460 | 15.4 |
| `/golf-cart-accident-lawyers/golf-course-cart-accident/` | 12 | 3 | 2 | 978 | 60.1 |
| `/burn-injury-lawyers/house-apartment-fire-burn/` | 10 | 6 | 3 | 473 | 20.8 |
| `/premises-liability-lawyers/elevator-escalator-accident/` | 10 | 5 | 0 | 828 | 23.0 |
| `/pedestrian-accident-lawyers/backing-up-parking-lot-accident/` | 9 | 2 | 2 | 1079 | 10.5 |
| `/dog-bite-lawyers/loose-unleashed-dog-attack/` | 9 | 7 | 3 | 573 | 11.0 |
| `/atv-side-by-side-accident-lawyers/child-atv-injury/` | 8 | 2 | 0 | 923 | 20.1 |
| `/nursing-home-abuse-lawyers/assisted-living-abuse/` | 7 | 3 | 1 | 244 | 29.2 |
| `/spinal-cord-injury-lawyers/cauda-equina-syndrome/` | 7 | 2 | 1 | 2308 | 20.8 |
| `/electric-scooter-accident-lawyers/escooter-vehicle-collision/` | 7 | 5 | 2 | 2586 | 31.6 |
| `/electric-scooter-accident-lawyers/escooter-pedestrian-accident/` | 7 | 1 | 0 | 1282 | 20.2 |

## The plan

### Step 1 — take the generic blocks out of the scenario template (in progress)

`templates/template-subtype.php` stops rendering the four generic legal sections and the stats
block. It renders one compact box instead: the filing deadline for the page's jurisdiction and the
fault rule, each from the same statute resolver and strings as before, plus a link to the pillar's
full treatment. The deadlines also stay in the sidebar badge. The "what to do" steps stay, because
they feed the HowTo structured data and a curated set per practice.

Simulated on the 182 rendered pages (sections removed, box not yet added):

| | Before | After |
|---|---:|---:|
| Median words | 2,015 | 1,506 |
| Template share | 39% | 21% |
| Closest-sibling overlap | 51% | 38% |
| Pillar overlap | 43% | 34% |
| Pages ≥50% shared with a sibling | 123 | **0** |

No URL changes, no effect on the doorway ratio, fully reversible. Pillars keep the full sections:
they are the canonical home of that material.

### Step 2 — retire the 64 that have never earned a click (awaiting the owner)

66 scenario pages have **0 clicks in 16 months on 42,544 impressions**. Two are kept because they sit
near page one: `jogger-runner-accident` (position 13.9, 194 impressions in 90 days) and
`medical-malpractice-death` (13.0, 308). The other 64 go to draft and 301 to their pillar, the
same mechanics as the 09-25 cull. 44 of them are linked from other posts and need a relink.

**The doorway ratio sets the ceiling.** These are not place pages, so removing them shrinks the
denominator: 171 / 749 = 22.83% today; retiring 64 gives **171 / 685 = 24.96%**. All 66 would be
25.04% and fail. After step 2 there is no headroom for removing any further non-place page without
retiring place pages first. The metric penalises removing thin pages, which is backwards; whether it
should measure differently is a question for the site-health owner, separate from this plan.

### Step 3 — keep the 116 that earn, and re-measure

Re-read them 90 days after step 1 ships. The next lever, if the pillars still overlap each other at
~76%, is the same treatment for `template-practice-area.php` with a single canonical explainer.

## Found along the way

`roden_ai_stats_block()` states "Combined attorney experience across **5** office locations" while
the next row says "our **six** offices", and its "Source: … updated <current month>" line stamps
whatever the current month is, so it always looks fresh. Step 1 removes the block from scenario
pages; the pillar copy still needs the count fixed and a real date.

## The 64 proposed for retirement

| Path | Impr 16 mo | Impr 90 d | Pos 90 d | → Pillar |
|---|---:|---:|---:|---|
| `/bicycle-accident-lawyers/distracted-driver-bicycle-accident/` | 183 | 41 | 9.4 | `/practice-areas/bicycle-accident-lawyers/` |
| `/bicycle-accident-lawyers/hit-and-run-bicycle-accident/` | 291 | 4 | 10.2 | `/practice-areas/bicycle-accident-lawyers/` |
| `/bicycle-accident-lawyers/road-hazard-bicycle-crash/` | 150 | 13 | 10.1 | `/practice-areas/bicycle-accident-lawyers/` |
| `/boating-accident-lawyers/commercial-vessel-accident/` | 166 | 12 | 16.2 | `/practice-areas/boating-accident-lawyers/` |
| `/boating-accident-lawyers/jet-ski-personal-watercraft/` | 906 | 305 | 44.2 | `/practice-areas/boating-accident-lawyers/` |
| `/boating-accident-lawyers/kayak-canoe-accident/` | 271 | 39 | 12.4 | `/practice-areas/boating-accident-lawyers/` |
| `/boating-accident-lawyers/sailboat-accident/` | 88 | 11 | 16.6 | `/practice-areas/boating-accident-lawyers/` |
| `/boating-accident-lawyers/speedboat-powerboat-collision/` | 259 | 123 | 31.3 | `/practice-areas/boating-accident-lawyers/` |
| `/brain-injury-lawyers/anoxic-hypoxic-brain-injury/` | 1190 | 69 | 18.1 | `/practice-areas/brain-injury-lawyers/` |
| `/brain-injury-lawyers/birth-related-brain-injury/` | 493 | 99 | 7.7 | `/practice-areas/brain-injury-lawyers/` |
| `/brain-injury-lawyers/penetrating-brain-injury/` | 254 | 40 | 12.8 | `/practice-areas/brain-injury-lawyers/` |
| `/brain-injury-lawyers/severe-traumatic-brain-injury/` | 437 | 37 | 19.9 | `/practice-areas/brain-injury-lawyers/` |
| `/burn-injury-lawyers/defective-product-burn/` | 120 | 30 | 10.3 | `/practice-areas/burn-injury-lawyers/` |
| `/burn-injury-lawyers/workplace-burn-injury/` | 577 | 29 | 23.0 | `/practice-areas/burn-injury-lawyers/` |
| `/car-accident-lawyers/construction-vehicle-accident/` | 238 | 61 | 12.2 | `/practice-areas/car-accident-lawyers/` |
| `/car-accident-lawyers/delivery-vehicle-accident/` | 563 | 112 | 50.6 | `/practice-areas/car-accident-lawyers/` |
| `/car-accident-lawyers/distracted-driving-accident/` | 2339 | 20 | 13.8 | `/practice-areas/car-accident-lawyers/` |
| `/car-accident-lawyers/drunk-driver-accident/` | 208 | 34 | 13.7 | `/practice-areas/car-accident-lawyers/` |
| `/car-accident-lawyers/hit-and-run-accident/` | 245 | 27 | 15.6 | `/practice-areas/car-accident-lawyers/` |
| `/car-accident-lawyers/multi-vehicle-pileup/` | 412 | 86 | 16.3 | `/practice-areas/car-accident-lawyers/` |
| `/car-accident-lawyers/service-vehicle-accident/` | 173 | 24 | 18.7 | `/practice-areas/car-accident-lawyers/` |
| `/car-accident-lawyers/t-bone-accident/` | 1875 | 42 | 27.1 | `/practice-areas/car-accident-lawyers/` |
| `/car-accident-lawyers/uber-lyft-accident/` | 945 | 8 | 17.5 | `/practice-areas/car-accident-lawyers/` |
| `/construction-accident-lawyers/crane-heavy-equipment-accident/` | 568 | 95 | 18.7 | `/practice-areas/construction-accident-lawyers/` |
| `/construction-accident-lawyers/falling-object-injury/` | 2217 | 799 | 16.6 | `/practice-areas/construction-accident-lawyers/` |
| `/construction-accident-lawyers/roofing-accident/` | 602 | 18 | 7.4 | `/practice-areas/construction-accident-lawyers/` |
| `/electric-scooter-accident-lawyers/road-hazard-escooter-crash/` | 443 | 33 | 9.2 | `/practice-areas/electric-scooter-accident-lawyers/` |
| `/golf-cart-accident-lawyers/golf-cart-rollover/` | 404 | 9 | 10.8 | `/practice-areas/golf-cart-accident-lawyers/` |
| `/maritime-injury-lawyers/commercial-fishing-injury/` | 974 | 346 | 22.4 | `/practice-areas/maritime-injury-lawyers/` |
| `/maritime-injury-lawyers/jones-act-seaman-claim/` | 743 | 18 | 17.4 | `/practice-areas/maritime-injury-lawyers/` |
| `/motorcycle-accident-lawyers/drunk-driver-motorcycle-accident/` | 629 | 69 | 11.7 | `/practice-areas/motorcycle-accident-lawyers/` |
| `/motorcycle-accident-lawyers/head-on-motorcycle-collision/` | 179 | 2 | 16.0 | `/practice-areas/motorcycle-accident-lawyers/` |
| `/motorcycle-accident-lawyers/intersection-motorcycle-accident/` | 447 | 126 | 17.3 | `/practice-areas/motorcycle-accident-lawyers/` |
| `/motorcycle-accident-lawyers/left-turn-accident/` | 415 | 29 | 10.3 | `/practice-areas/motorcycle-accident-lawyers/` |
| `/motorcycle-accident-lawyers/rear-end-motorcycle-accident/` | 122 | 5 | 12.4 | `/practice-areas/motorcycle-accident-lawyers/` |
| `/pedestrian-accident-lawyers/crosswalk-accident/` | 354 | 6 | 5.2 | `/practice-areas/pedestrian-accident-lawyers/` |
| `/pedestrian-accident-lawyers/distracted-driver-pedestrian-accident/` | 691 | 44 | 11.6 | `/practice-areas/pedestrian-accident-lawyers/` |
| `/pedestrian-accident-lawyers/drunk-driver-pedestrian-accident/` | 700 | 44 | 8.5 | `/practice-areas/pedestrian-accident-lawyers/` |
| `/pedestrian-accident-lawyers/intersection-pedestrian-accident/` | 555 | 54 | 17.3 | `/practice-areas/pedestrian-accident-lawyers/` |
| `/premises-liability-lawyers/apartment-complex-injury/` | 555 | 85 | 12.7 | `/practice-areas/premises-liability-lawyers/` |
| `/premises-liability-lawyers/restaurant-hotel-injury/` | 615 | 49 | 10.3 | `/practice-areas/premises-liability-lawyers/` |
| `/product-liability-lawyers/defective-auto-parts/` | 282 | 97 | 28.3 | `/practice-areas/product-liability-lawyers/` |
| `/product-liability-lawyers/defective-childrens-product/` | 466 | 84 | 12.5 | `/practice-areas/product-liability-lawyers/` |
| `/slip-and-fall-lawyers/parking-lot-fall/` | 649 | 50 | 11.6 | `/practice-areas/slip-and-fall-lawyers/` |
| `/slip-and-fall-lawyers/wet-floor-accident/` | 452 | 146 | 22.0 | `/practice-areas/slip-and-fall-lawyers/` |
| `/slip-and-fall-lawyers/workplace-slip-and-fall/` | 390 | 24 | 9.8 | `/practice-areas/slip-and-fall-lawyers/` |
| `/spinal-cord-injury-lawyers/complete-spinal-cord-injury/` | 120 | 16 | 7.9 | `/practice-areas/spinal-cord-injury-lawyers/` |
| `/spinal-cord-injury-lawyers/herniated-ruptured-disc/` | 869 | 62 | 24.9 | `/practice-areas/spinal-cord-injury-lawyers/` |
| `/spinal-cord-injury-lawyers/incomplete-spinal-cord-injury/` | 293 | 42 | 24.5 | `/practice-areas/spinal-cord-injury-lawyers/` |
| `/spinal-cord-injury-lawyers/tetraplegia-quadriplegia/` | 1969 | 124 | 36.2 | `/practice-areas/spinal-cord-injury-lawyers/` |
| `/truck-accident-lawyers/18-wheeler-semi-truck-accident/` | 296 | 18 | 23.2 | `/practice-areas/truck-accident-lawyers/` |
| `/truck-accident-lawyers/brake-failure-accident/` | 1234 | 204 | 16.0 | `/practice-areas/truck-accident-lawyers/` |
| `/truck-accident-lawyers/cement-truck-accident/` | 1035 | 45 | 13.3 | `/practice-areas/truck-accident-lawyers/` |
| `/truck-accident-lawyers/commercial-van-delivery-truck-accident/` | 230 | 26 | 17.4 | `/practice-areas/truck-accident-lawyers/` |
| `/truck-accident-lawyers/fatigued-trucker-accident/` | 1655 | 78 | 33.1 | `/practice-areas/truck-accident-lawyers/` |
| `/truck-accident-lawyers/hazardous-materials-accident/` | 923 | 71 | 20.8 | `/practice-areas/truck-accident-lawyers/` |
| `/truck-accident-lawyers/underride-override-accident/` | 3004 | 1158 | 26.6 | `/practice-areas/truck-accident-lawyers/` |
| `/workers-compensation-lawyers/construction-worker-injury/` | 287 | 20 | 20.5 | `/practice-areas/workers-compensation-lawyers/` |
| `/workers-compensation-lawyers/factory-manufacturing-injury/` | 430 | 175 | 23.5 | `/practice-areas/workers-compensation-lawyers/` |
| `/workers-compensation-lawyers/fatal-workplace-accident/` | 1340 | 914 | 37.5 | `/practice-areas/workers-compensation-lawyers/` |
| `/workers-compensation-lawyers/port-worker-injury/` | 465 | 113 | 41.4 | `/practice-areas/workers-compensation-lawyers/` |
| `/workers-compensation-lawyers/warehouse-distribution-injury/` | 180 | 45 | 25.8 | `/practice-areas/workers-compensation-lawyers/` |
| `/wrongful-death-lawyers/defective-product-death/` | 241 | 106 | 25.3 | `/practice-areas/wrongful-death-lawyers/` |
| `/wrongful-death-lawyers/fatal-truck-accident/` | 181 | 37 | 29.8 | `/practice-areas/wrongful-death-lawyers/` |
