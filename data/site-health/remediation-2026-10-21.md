# Site-health remediation — 2026-10-21

Source report: `data/site-health/latest.json` (gitignored; regenerate with the
command below), a live crawl of production (`https://rodenlaw.com`), 691
sitemap URLs, generated 2026-10-21T14:16Z. Overall: `pass: false`.

```
node internal-ai-scripts/scripts/site-health/site-health.mjs --repo . \
  --base https://rodenlaw.com --json --out data/site-health/latest.json
```

The previous report (2026-09-10, 1230 sitemap URLs) predated PRs #133–#136,
the September culls (#141, #147 and the 09-18/09-19 batches) and the doorway
work. The sitemap is 539 URLs smaller, so many counts fell for that reason
alone. The deltas below are against `remediation-2026-09-11.md`.

Production drift was checked before any work started, per `CLAUDE.md`. All 188
tracked theme files matched the repo, so there were no uncommitted prod edits to
rescue.

The approved scope for this pass was the live re-crawl, featured-image
`EMPTY_ALT`, and the retired sub-municipal neighbourhood URLs that return a bare
404. Every other class is recorded below with its status. Report-only does
not mean silence (see the open question at the end).

## Summary

| Check | Finding class | 09-10 | 10-21 | Status | PR |
|---|---|---|---|---|---|
| a11y | `HEADING_SKIP:h1->h3` | 467 | 2 | **Fixed** (second pass) | #221 |
| a11y | `EMPTY_ALT` | 135 | 34 | **Fixed** | #212 |
| a11y | `LOW_MAIN_TEXT_RATIO` | 162 | 10 | Deferred | — |
| a11y | `DUPLICATE_TITLE` | 64 | 4 | Deferred: out of scope (hubs) | — |
| a11y | `WEAK_ALT` | 1 | 1 | Deferred: out of scope | — |
| a11y | `TABLE_NO_TH` | 1 | 1 | Deferred: out of scope | — |
| a11y | `AMBIGUOUS_LINK_NAME` (notice) | 26 | 32 | Deferred | — |
| redirects | `LOST`: old Charleston-parent neighbourhoods and Ladson | 22 | 23 | **Fixed** | #213 |
| redirects | `LOST`: Hanahan, Moncks Corner | 2 | 2 | **Fixed**: owner chose redirect-only | #213 |
| redirects | `LOST`: bare Goose Creek, Summerville (old path) | 0 | 2 | **Fixed** (second pass; alias only) | #219 |
| redirects | `LOST`: root-level aliases of retired blog posts | 0 | 12 | **Fixed** (second pass) | #219 |
| redirects | `LOST`: Murrells Inlet (state-level alias) | 0 | 1 | **Fixed** (second pass) | #219 |
| redirects | `LOST`: `/practice-areas/truck-accident-lawyers/drunk-driver-accident/` | 0 | 1 | Deferred: owner (destination) | — |
| redirects | `CHAIN` (2 hops) | 28 | 3 | **Fixed** (second pass) | #219 |
| redirects | departed-attorney destinations disagree | 4 | — | Disputed: owner (unchanged) | — |
| crawl | links that 404 or redirect | 14 | 0 | Passing | — |
| crawl | orphans | 162 | 3 | **Fixed** (second pass) | #220 |
| crawl | `badStatus`, `falseAffordances` | 0 | 0 | Passing | — |
| floor | granularity-floor violations | 162 | 54 | Deferred: out of scope | — |
| doorway | location-targeted ratio | 40.9% | 23.9% | **Passing** (ceiling 25%) | — |
| linktopics | cross-topic links | 0 | 0 | Passing (25,536 links) | — |
| canonicals | canonical defects | 0 | 0 | Passing (691/691) | — |
| wikidata | entity mismatches | 0 | 0 | Passing, vacuously (none referenced) | — |

Expected post-deploy movement: `EMPTY_ALT 34 → 0`, `redirects lost 41 → 18` (first pass, #212/#213).
After the second pass deploys: `redirects lost 41 → 1, chains 3 → 0`, `crawl orphans 3 → 0`,
`a11y HEADING_SKIP 2 → 0`. The one remaining LOST is the deferred drunk-driver URL.

## Fixed

### a11y — `EMPTY_ALT` on 34 pages, 44 images (PR #212)

Every empty-alt image on all 34 pages is a `.wp-post-image` printing its
attachment's empty `_wp_attachment_image_alt`. That covers the 32 post heroes
(26 `/blog/`, 6 `/es/blog/`) and the `/blog/` and `/es/blog/` archive cards.

Fixed once at the emitter, not per template. Between core's
`begin_/end_fetch_post_thumbnail_html` actions, an empty alt falls back to the
title of the post the image is featured on (alt = title, as the resource images
are since 6e37e9f). Explicit caller alts and set attachment alts are untouched.
There are no msgids and no CSS/JS, so no version bump.

The only previous fallback lived in `templates/parts/content-blog-card.php`,
which nothing loads. Every archive renders `template-parts/content-card.php`.

Verified two ways, both read-only:

- **Prod `wp eval-file`.** All 274 posts with a featured image, rendered at 4
  sizes: empty alts went from 128 (post) + 16 (staff) to 0. Explicit alt was
  preserved 274/274, no fallback leaked outside a thumbnail fetch, and every
  filled alt equals the post title.
- **Checker `auditHtml()` on live HTML** with the change as a DOM transform:
  `EMPTY_ALT before=44, after=0`. No other finding moved, and a 15-page clean
  control was unchanged.

### redirects — 23 old Charleston-parent location URLs (PR #213)

North Charleston, Goose Creek, Summerville and Ladson were re-parented from
Charleston to the North Charleston hub with no rule for the old addresses. Those
addresses survived only through WordPress's 404 slug guess, which sees published
posts only. Each retirement in that subtree therefore turned its old alias into
a bare 404, while the current address correctly 301s.

The fix: `roden_phase1_removal_redirects()` translates the old address to the
current hierarchy before its lookup, only on a 404, and acts only when the
translated path is a removal already decided. It is the same shape as its
practice-area canonicalisation. All 23 aliases (22 neighbourhoods + Ladson) 301
in one hop to `/locations/south-carolina/north-charleston/` (200), exactly where
their current addresses already go. `redirects.csv` is the replay fixture and was
not edited.

**Rule applied:** a retired sub-municipal place 301s to its nearest live parent.
That is the municipality page where it serves, otherwise the office hub. Every
URL in this class has such a parent, so none gets a 410.

Verified on prod's real removal map (read-only `wp eval-file`), by a live trace
(23 sources 404 today; 23 translated paths already 301 to the hub; hub 200), and
by a unit check of the edge cases.

## Second pass (2026-10-21) — three owner-approved PRs

Approved scope: exactly three PRs, one per class. They are the redirects LOST
and CHAIN list except drunk-driver-accident, the three GA orphans, and the hub
HEADING_SKIP. Granularity floor, duplicate titles, `EMPTY_ALT`, `TABLE_NO_TH` and
`LOW_MAIN_TEXT_RATIO` stay out of scope. Prod drift was re-checked first (188/188
theme files match `main`, which includes #213, so #213 is live). A live re-trace
of the 44 reported URLs showed 25 already resolving (the 23 from #213, plus
Hanahan and Moncks Corner). That left 19.

### redirects — 15 LOST + 3 CHAIN (#219)

All in `inc/legacy-redirects.php`. Three generators, each fixed once:

- **12 root-level aliases of retired blog posts.** These do *not* reach
  `roden_resolve_legacy_blog_dest()`, which is only called for `/blog-*/` and
  `/blog/blog-*/` prefixes. They fall through to the blog catch-all, which needs
  a published post, and the post is a retired draft. The `/blog/{slug}/` key is in
  `roden_phase1_removed_urls()`. `roden_phase1_removal_redirects()` now maps
  `/{slug}/` to that key on a 404 (`roden_root_blog_alias_key()`). This is the
  same shape as the practice-area and Charleston canonicalisations. Every future
  blog retirement covers its root alias automatically.
- **3 chains** through `/blog/your-step-by-step-guide-after-a-downtown-columbia-truck-accident/`,
  plus that slug's own root alias. `roden_redirect_dest_or_fallback()`, the funnel
  for every legacy-map destination, now follows destinations through the removal
  map (`roden_resolve_removed_dest()`). The removal handler does the same for its
  own targets, so a retired destination can never chain again.
- **Murrells Inlet** (`/locations/south-carolina/murrells-inlet/`): the only
  state-level place alias in the fixture. It gets an explicit entry
  (`roden_orphan_alias_urls()`) pointing at the retired Myrtle Beach child's
  removal key, which resolves to `/locations/south-carolina/myrtle-beach/`.
- **Bare Goose Creek and Summerville** under the old Charleston parent: removed
  from the held list in `roden_canonicalize_charleston_location_path()` (#213).
  They now land on `/locations/south-carolina/north-charleston/`, where their
  current addresses already go. This decides only the old alias. Restoring
  either page remains open. Separate commit so it can be dropped on its own.

**Verified** with the real `template_redirect` pipeline on prod's real maps:
a read-only `wp eval-file` loads the patched file under a renamed prefix, unhooks
the live versions, and intercepts `wp_redirect`. The unpatched baseline reproduced
the live trace of all 44 URLs exactly. Across all 997 fixture URLs plus all 691
sitemap URLs, exactly 18 results changed, all from LOST/CHAIN to one hop. No
sitemap URL redirects, so nothing served is shadowed. Every final destination was
then fetched live: all 200.

Replay of the 44 reported URLs. "Today" is production now (`main`, #213 live).
"After" is the patched pipeline.

| # | Report | Source | Today (main, live) | After this PR | Hops | Live status of final |
|---|---|---|---|---|---|---|
| 1 | LOST | `/can-a-witness-be-forced-to-testify-for-a-savannah-car-crash-case/` | 404 | `/blog/qualifications-for-car-accident-witnesses/` | 1 | 200 |
| 2 | LOST | `/compensation-for-car-crash-facial-injuries-charleston/` | 404 | `/practice-areas/car-accident-lawyers/` | 1 | 200 |
| 3 | LOST | `/your-guide-to-documenting-a-james-island-parkway-car-accident/` | 404 | `/practice-areas/car-accident-lawyers/` | 1 | 200 |
| 4 | LOST | `/how-delayed-injuries-could-impact-your-charleston-car-crash-claim/` | 404 | `/practice-areas/car-accident-lawyers/` | 1 | 200 |
| 5 | LOST | `/recovering-lost-wages-after-a-truck-accident-on-i-526/` | 404 | `/blog/claims-for-lost-wages/` | 1 | 200 |
| 6 | CHAIN | `/blog/a-practical-guide-after-a-truck-accident-in-downtown-columbia/` | 2 hops | `/practice-areas/truck-accident-lawyers/` | 1 | 200 |
| 7 | LOST | `/locations/south-carolina/charleston/ladson/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 8 | LOST | `/locations/south-carolina/charleston/north-charleston/northwoods/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 9 | LOST | `/what-to-do-after-a-truck-accident-on-i-526-in-charleston/` | 404 | `/practice-areas/truck-accident-lawyers/` | 1 | 200 |
| 10 | LOST | `/locations/south-carolina/charleston/moncks-corner/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 11 | LOST | `/locations/south-carolina/charleston/north-charleston/ferndale/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 12 | LOST | `/locations/south-carolina/charleston/north-charleston/wescott-plantation/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 13 | LOST | `/locations/south-carolina/charleston/north-charleston/liberty-hill/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 14 | LOST | `/locations/south-carolina/charleston/goose-creek/devon-forest/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 15 | LOST | `/port-of-charleston-injury-claims-longshoremen-dock-workers/` | 404 | `/blog/longshoreman-injury-claims/` | 1 | 200 |
| 16 | LOST | `/proving-a-tourist-was-at-fault-in-your-charleston-accident/` | 404 | `/practice-areas/car-accident-lawyers/` | 1 | 200 |
| 17 | LOST | `/locations/south-carolina/charleston/goose-creek/` | 404 | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 18 | LOST | `/locations/south-carolina/charleston/goose-creek/howe-hall/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 19 | LOST | `/locations/south-carolina/charleston/hanahan/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 20 | LOST | `/locations/south-carolina/charleston/summerville/summers-corner/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 21 | LOST | `/goose-creek-car-accidents-military-traffic-us-52/` | 404 | `/practice-areas/car-accident-lawyers/` | 1 | 200 |
| 22 | LOST | `/locations/south-carolina/charleston/summerville/` | 404 | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 23 | CHAIN | `/your-first-steps-after-a-truck-accident-in-downtown-columbia-sc/` | 2 hops | `/practice-areas/truck-accident-lawyers/` | 1 | 200 |
| 24 | LOST | `/your-guide-to-rideshare-accidents-in-downtown-charleston/` | 404 | `/practice-areas/car-accident-lawyers/` | 1 | 200 |
| 25 | LOST | `/locations/south-carolina/charleston/north-charleston/charleston-heights/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 26 | LOST | `/locations/south-carolina/charleston/summerville/sangaree/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 27 | LOST | `/locations/south-carolina/charleston/goose-creek/carnes-crossroads/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 28 | LOST | `/locations/south-carolina/charleston/goose-creek/westchester/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 29 | LOST | `/locations/south-carolina/charleston/goose-creek/boulder-bluff/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 30 | LOST | `/locations/south-carolina/charleston/north-charleston/park-circle/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 31 | LOST | `/locations/south-carolina/charleston/goose-creek/crowfield-plantation/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 32 | LOST | `/locations/south-carolina/charleston/summerville/historic-district/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 33 | LOST | `/seeking-justice-after-a-fatigued-trucker-accident-on-i-26/` | 404 | `/practice-areas/truck-accident-lawyers/` | 1 | 200 |
| 34 | LOST | `/locations/south-carolina/charleston/goose-creek/brickhope-plantation/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 35 | LOST | `/locations/south-carolina/charleston/north-charleston/oak-terrace-preserve/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 36 | LOST | `/locations/south-carolina/charleston/summerville/cane-bay/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 37 | LOST | `/locations/south-carolina/charleston/north-charleston/chicora-cherokee/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 38 | LOST | `/locations/south-carolina/charleston/goose-creek/liberty-hall-plantation/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 39 | LOST | `/locations/south-carolina/charleston/summerville/wescott/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 40 | CHAIN | `/a-practical-guide-after-a-truck-accident-in-downtown-columbia/` | 2 hops | `/practice-areas/truck-accident-lawyers/` | 1 | 200 |
| 41 | LOST | `/practice-areas/truck-accident-lawyers/drunk-driver-accident/` | 404 | `—` | 0 | 404 (deferred) |
| 42 | LOST | `/your-step-by-step-guide-after-a-downtown-columbia-truck-accident/` | 404 | `/practice-areas/truck-accident-lawyers/` | 1 | 200 |
| 43 | LOST | `/locations/south-carolina/charleston/north-charleston/olde-north-charleston/` | 1 hop (#213) | `/locations/south-carolina/north-charleston/` | 1 | 200 |
| 44 | LOST | `/locations/south-carolina/murrells-inlet/` | 404 | `/locations/south-carolina/myrtle-beach/` | 1 | 200 |

`redirects.csv` is the replay fixture and was not edited.

### crawl — 3 orphaned Georgia statewide pages (#220)

No template linked any of the six GA statewide pages (posts 6317–6322). Car,
personal injury and wrongful death were reachable only through hand-written
links in three resource bodies (6329–6331). The SC six are linked sitewide from
footer column 4 (266beed), and Georgia had no equivalent. The column now lists
Georgia above South Carolina, in the same order as the offices column. There are
no `/es/` twins for the GA pages, so the Georgia list renders on English pages
only (Spanish stays in its silo, as #161). The fix is a link from a hub-level
template, not a new page, so the doorway ratio and floor are untouched.
`linktopics` reads `<main>` only, so footer links do not count there.

Verified by rendering the patched `footer.php` on prod, read-only. `/` and
`/locations/georgia/` emit all six GA links. `/es/` and `/es/locations/` emit
only the six `/es/` SC links, unchanged. There is one new msgid (`%s — Georgia`,
an aria-label) in `es_ES.po`. A recompile of the unchanged `.po` was
byte-identical to the committed `.mo` before it was added. Version 1.4.31.

Noticed, not fixed (out of scope): `roden_sc_statewide_pillar_slug()` maps car
accidents to `south-carolina-car-accident-lawyer`, but the page is
`…-lawyers`. The SC car uplink on SC intersections therefore never renders.

### a11y — `HEADING_SKIP:h1->h3` on `/practice-areas/` and `/locations/` (#221)

`archive-practice_area.php` (card h3s) and the location branch of `archive.php`
(`roden_location_cards()` h3s) sat directly under the hero h1. Each grid now
has a visually hidden h2 (`.screen-reader-text`), with no visual change and no
CSS. The card h3s stay h3, because `roden_location_cards()` is shared with the
practice-areas hub, where it already sits under a visible "Our Offices" h2. Both
msgids already exist and are translated. The `/es/` hubs are separate pages with
visible h2 groups and were already clean.

Verified with the checker's `auditHtml()` on live HTML, with the insertion
applied: both pages HEADING_SKIP 1 → 0. The controls (`/es/practice-areas/`,
`/es/locations/`, `/`, a GA pillar) were unchanged.

## Deferred / needs an owner decision

### `/practice-areas/truck-accident-lawyers/drunk-driver-accident/` (LOST)

No post and no rule. Its destination awaits the owner (probably the truck
pillar, or a 410). Excluded from the second pass by the owner.

### Goose Creek, Summerville (and the #147 "sub-municipal" label)

Their old aliases now redirect (above). Whether the incorporated
municipalities retired in #147 should come back is still open. The label point
stands: that docblock calls several incorporated municipalities
"sub-municipal", including Mount Pleasant, Conway, Georgetown, Cayce, West
Columbia, Pooler, Statesboro and Hinesville.

### Departed-attorney destinations

Unchanged from 2026-09-11 and still open.

### a11y — remaining warnings

`LOW_MAIN_TEXT_RATIO` 10 (hubs, contact, testimonials, one attorney),
`DUPLICATE_TITLE` 4 (hubs, excluded), `WEAK_ALT` 1
(`/blog/workers-compensation-faqs/`, excluded), `TABLE_NO_TH` 1
(`/blog/much-worth-ga-worker-compared-states/`, excluded), and
`AMBIGUOUS_LINK_NAME` 32 notices. These are non-gating at `strict: false`.

### floor — 54 granularity-floor violations

Down from 162. Out of scope by standing decision. Nothing in #212 or #213 adds a
geographic URL.

## Passing

`doorway` now passes at 23.9% (165 of 691; ceiling 25%). `linktopics`,
`canonicals`, crawl `badStatus` / `linkProblems` / `falseAffordances` also pass.
`wikidata` passes vacuously: no Wikidata references exist to check.

## Open question — the post-deploy job is still in observation mode

`.github/workflows/deploy.yml` (the `site-health` job) says "OBSERVATION MODE
until 2026-09-24". As of `origin/main` today it still carries
`continue-on-error: true` and `--report-only`, so a red result still does not
fail the deploy, four weeks past that date. Ending observation mode is the
owner's call. The workflow comment says how: delete the `continue-on-error`
line and drop `--report-only`. If it is ended before the second-pass PRs
deploy, the 18 LOST URLs and 3 chains left after #213 would turn the job red.
After they deploy, the deferred drunk-driver URL alone would, so it needs a
destination (or a 410) before observation mode ends.

## Re-run after #212, #213 and the second-pass PRs deploy

```
node vendor/site-health/site-health.mjs a11y      --repo . --base https://rodenlaw.com
node vendor/site-health/site-health.mjs redirects --repo . --base https://rodenlaw.com --live
node vendor/site-health/site-health.mjs crawl     --repo . --base https://rodenlaw.com
```

Flush `wp cache flush` and `wp page-cache flush` first (600 s edge cache).
