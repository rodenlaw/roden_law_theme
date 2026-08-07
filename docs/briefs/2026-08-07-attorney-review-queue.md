# Attorney review queue — the freshness signal

**Generated:** 2026-08-07 · **Baseline coverage: 8.1% (101 of 1,246 published pages)**

## Why there is a queue and not a backfill

`_roden_last_reviewed` is the firm's own answer to *"when did an attorney last check this
page?"* Setting it licenses `reviewedBy` in schema, and since PR #28 it renders visibly.
`schema-helpers.php` states the constraint plainly:

> `_roden_author_attorney` records attribution, not review, and asserting a review that may
> not have happened is not a trust signal worth manufacturing.

Stamping 1,145 pages would assert 1,145 attorney reviews that never happened and emit
structured-data claims for each, on YMYL legal content. So this ranks the work instead.

**The real defect is not the empty field.** It is that **875 pages already display an
attorney byline with no review on record** — they read as reviewed and are not.

## Tiers

Three independent axes, not one opaque score: organic traffic (Semrush), legal risk
(statutory citations and SB 68 subject matter), and staleness (months since `post_modified`).

| Tier | Pages | Est. monthly traffic | What it is |
|---|---:|---:|---|
| **P1** | 32 | 916 | traffic ≥5 **and** makes legal-rule claims — start here |
| **P2** | 716 | 0 | heavy legal-rule content, no measured traffic |
| **P3** | 1 | 439 | traffic but low legal risk |
| **P4** | 164 | 0 | some legal-rule content, no traffic |
| **P5** | 232 | 0 | low risk, no traffic (mostly location pages) |

**32 P1 pages carry 916 of the ~1355 monthly organic traffic.** That is the
whole first sprint — roughly 65% of the site's organic exposure, and every one of them makes
a checkable legal claim.

## P1 — review these first

`risk` weights statutory citations highest (4), then deadlines/fault/seat-belt (3), then
damages, premises and medical specials (2). `stale` is months since last modification.

| Traffic | Risk | Stale | Type | URL | Risk flags |
|---:|---:|---:|---|---|---|
| 241 | 13 | 0mo | post | `/blog/compensatory-damages-vs-punitive-damages/` | statute,fault,damages,premises,medspecials |
| 168 | 12 | 3mo | resource | `/resources/two-notch-road-truck-accidents-columbia/` | statute,fault,sol,damages |
| 114 | 14 | 4mo | post | `/blog/fault-vs-no-fault-car-insurance/` | statute,fault,sol,damages,medspecials |
| 62 | 7 | 1mo | practice_area | `/truck-accident-lawyers/charleston-sc/` | statute,fault |
| 36 | 7 | 3mo | post | `/blog/south-carolina-statute-of-limitations-personal-injury/` | statute,sol |
| 34 | 14 | 1mo | post | `/blog/calculating-compensation-for-whiplash-injuries/` | statute,fault,sol,damages,medspecials |
| 24 | 13 | 1mo | practice_area | `/golf-cart-accident-lawyers/north-charleston-sc/` | statute,seatbelt,fault,sol |
| 19 | 12 | 1mo | practice_area | `/pedestrian-accident-lawyers/charleston-sc/` | statute,fault,sol,damages |
| 17 | 14 | 4mo | practice_area | `/car-accident-lawyers/savannah-ga/` | statute,fault,sol,damages,medspecials |
| 17 | 7 | 1mo | practice_area | `/dog-bite-lawyers/charleston-sc/` | statute,sol |
| 17 | 5 | 5mo | location | `/locations/georgia/darien/st-simons-island/` | sol,damages |
| 14 | 10 | 1mo | practice_area | `/boating-accident-lawyers/columbia-sc/` | statute,fault,sol |
| 12 | 12 | 1mo | post | `/blog/garden-city-dean-forest-road-truck-accident-lawyer/` | statute,fault,sol,medspecials |
| 12 | 10 | 1mo | practice_area | `/spinal-cord-injury-lawyers/columbia-sc/` | statute,fault,sol |
| 12 | 7 | 1mo | post | `/blog/brunswick-i-95-truck-accident-lawyer/` | statute,fault |
| 10 | 10 | 1mo | post | `/blog/diminished-value-claims-after-car-accident/` | statute,fault,sol |
| 9 | 10 | 1mo | post | `/blog/ashley-phosphate-i-26-south-carolinas-deadliest-intersection/` | statute,fault,sol |
| 9 | 7 | 4mo | post | `/blog/can-an-insurance-company-go-against-a-police-report/` | statute,fault |
| 9 | 6 | 0mo | post | `/blog/is-workers-compensation-an-employee-benefit/` | statute,medspecials |
| 8 | 9 | 5mo | practice_area | `/atv-side-by-side-accident-lawyers/side-by-side-utv-accident/` | statute,seatbelt,damages |
| 7 | 13 | 1mo | post | `/blog/value-of-pain-and-suffering/` | statute,fault,damages,premises,medspecials |
| 7 | 12 | 1mo | practice_area | `/burn-injury-lawyers/columbia-sc/` | statute,fault,sol,premises |
| 7 | 12 | 1mo | practice_area | `/car-accident-lawyers/columbia-sc/` | statute,fault,sol,damages |
| 7 | 10 | 5mo | practice_area | `/dog-bite-lawyers/savannah-ga/` | statute,fault,sol |
| 6 | 14 | 5mo | location | `/locations/south-carolina/columbia/` | statute,fault,sol,damages,premises |
| 6 | 12 | 5mo | practice_area | `/medical-malpractice-lawyers/savannah-ga/` | statute,fault,sol,damages |
| 6 | 12 | 1mo | practice_area | `/motorcycle-accident-lawyers/charleston-sc/` | statute,fault,sol,damages |
| 6 | 12 | 1mo | practice_area | `/car-accident-lawyers/charleston-sc/` | statute,fault,sol,damages |
| 5 | 15 | 0mo | post | `/blog/rollover-crashes-and-what-they-do-to-your-body/` | statute,seatbelt,fault,sol,damages |
| 5 | 14 | 1mo | practice_area | `/wrongful-death-lawyers/charleston-sc/` | statute,fault,sol,damages,medspecials |
| 5 | 9 | 1mo | practice_area | `/construction-accident-lawyers/columbia-sc/` | statute,fault,damages |
| 5 | 4 | 4mo | post | `/blog/how-long-can-a-person-stay-on-workers-compensation/` | statute |

### Two that deserve attention beyond their rank

- **`/blog/compensatory-damages-vs-punitive-damages/`** — the #2 page on the site at 241/mo,
  and squarely in the subject matter SB 68 revised (§ 9-10-184 anchoring, the new
  phantom-damages section, bifurcation under new § 51-12-15). High traffic, high risk, never
  reviewed.
- **`/blog/south-carolina-statute-of-limitations-personal-injury/`** — a blog post ranking for
  SOL intent while `/resources/south-carolina-statute-of-limitations/` exists as the canonical
  resource. Worth resolving the overlap during review.

## The rest

- **P2 — 716 pages.** Heavy legal-rule content with no measured organic traffic. Low
  urgency for traffic, real exposure for accuracy: these still state the law to whoever lands
  on them, and they feed FAQPage schema.
- **P4/P5 — 396 pages.** Thin legal content; mostly location pages, which
  carry no byline and therefore no E-E-A-T mismatch.
- **Spanish — 44 pages** in the queue. Review the
  English twin first; the Spanish copy inherits its legal facts.

## Stopping the decay

Two scripts ship with this:

- **`bin/report-freshness-coverage.php`** — re-run any time for coverage by type, the
  byline-gap count, and reviews going stale past a threshold (default 180 days). Run it
  before and after a sprint. Today's baseline: 8.1%, 875-page gap, 0 stale.
- **`bin/set-last-reviewed.php`** — the safe way to stamp pages *after* a real review. It
  refuses a future or non-ISO date, refuses a page with no published attorney (a review date
  with nobody to attribute it to is a `reviewedBy` claim with no subject), and **refuses to
  stamp across a bar line** — an SC-jurisdiction page bylined to a Georgia-only attorney is
  rejected. That is the 2026-07-21 failure, and it gets worse once a review date turns the
  byline into a formal assertion.

New pages are already covered: `bin/en-seed-resource-page.php` sets the field from its payload.

## Suggested cadence

1. Work P1 (32 pages) in one pass; stamp with `set-last-reviewed.php` as each is signed off.
2. Re-run the coverage report — P1 alone takes the traffic-weighted coverage from ~0% to most
   of the site's organic exposure, even though raw page coverage only moves 8.1% → 10.7%.
3. Then work P2 by practice-area cluster rather than page-by-page, since the legal facts
   repeat within a cluster.
4. Re-review at 180 days; the report flags them.

**Traffic-weighted coverage is the metric worth reporting to the client, not page count.**
1,145 unreviewed pages sounds alarming; 32 pages standing between you and most of the
organic exposure is a plan.
