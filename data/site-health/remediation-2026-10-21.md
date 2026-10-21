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
| a11y | `HEADING_SKIP:h1->h3` | 467 | 2 | Deferred: new, hub template | — |
| a11y | `EMPTY_ALT` | 135 | 34 | **Fixed** | #212 |
| a11y | `LOW_MAIN_TEXT_RATIO` | 162 | 10 | Deferred | — |
| a11y | `DUPLICATE_TITLE` | 64 | 4 | Deferred: out of scope (hubs) | — |
| a11y | `WEAK_ALT` | 1 | 1 | Deferred: out of scope | — |
| a11y | `TABLE_NO_TH` | 1 | 1 | Deferred: out of scope | — |
| a11y | `AMBIGUOUS_LINK_NAME` (notice) | 26 | 32 | Deferred | — |
| redirects | `LOST`: old Charleston-parent neighbourhoods and Ladson | 22 | 23 | **Fixed** | #213 |
| redirects | `LOST`: Hanahan, Moncks Corner | 2 | 2 | Deferred: owner | — |
| redirects | `LOST`: bare Goose Creek, Summerville (old path) | 0 | 2 | Deferred: owner, **new** | — |
| redirects | `LOST`: root-level aliases of retired blog posts | 0 | 12 | Deferred: **new** | — |
| redirects | `LOST`: other | 0 | 2 | Deferred: **new** | — |
| redirects | `CHAIN` (2 hops) | 28 | 3 | Deferred: **new** cause | — |
| redirects | departed-attorney destinations disagree | 4 | — | Disputed: owner (unchanged) | — |
| crawl | links that 404 or redirect | 14 | 0 | Passing | — |
| crawl | orphans | 162 | 3 | Deferred: owner, **new** set | — |
| crawl | `badStatus`, `falseAffordances` | 0 | 0 | Passing | — |
| floor | granularity-floor violations | 162 | 54 | Deferred: out of scope | — |
| doorway | location-targeted ratio | 40.9% | 23.9% | **Passing** (ceiling 25%) | — |
| linktopics | cross-topic links | 0 | 0 | Passing (25,536 links) | — |
| canonicals | canonical defects | 0 | 0 | Passing (691/691) | — |
| wikidata | entity mismatches | 0 | 0 | Passing, vacuously (none referenced) | — |

Expected post-deploy movement: `EMPTY_ALT 34 → 0`, `redirects lost 41 → 18`.

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

## Needs an owner decision

### Hanahan, Moncks Corner, and now Goose Creek and Summerville

Excluded by the owner: `/locations/south-carolina/charleston/hanahan/` and
`/…/moncks-corner/`. Both are incorporated municipalities, possibly retired in
error. Their current-hierarchy addresses already 301 to the North Charleston hub
(`roden_dead_location_urls()`).

**New:** `/locations/south-carolina/charleston/goose-creek/` and
`/…/summerville/` now 404 too. They did not on 2026-09-10. They died when
`roden_stale_place_urls()` (#147, 2026-09-25) retired the Goose Creek and
Summerville pages. Goose Creek (city) and Summerville (town) are incorporated,
which is the same question as Hanahan and Moncks Corner. They are held on an
explicit list in `roden_canonicalize_charleston_location_path()`. Removing an
entry is the whole change once decided.

Worth noting for that decision: the #147 docblock calls its 29 location pages
"sub-municipal". Several in that list are incorporated municipalities, including
Mount Pleasant, Conway, Georgetown, Cayce, West Columbia, Pooler, Statesboro and
Hinesville. The retirement was evidence-based on clicks, not on the floor, but
the label is wrong. If the Hanahan and Moncks Corner question is about "retired
in error because it was mislabelled", it applies to that whole list.

### Three orphaned Georgia statewide pages (new)

`/georgia-truck-accident-lawyers/`, `/georgia-motorcycle-accident-lawyer/` and
`/georgia-workers-compensation-lawyer/`. Nothing links to them, so they are also
the 3 URLs unreachable from `/`. They appear to be among the P2 Georgia statewide
pages. The September orphan set (156 case results, 6 SC root landers) is gone:
the case results were fixed by #136 and folded into one page, and the landers
were retired 2026-09-19.

Linking them from a hub is the normal fix and does not move the doorway ratio,
which is sitemap-based. But whether these three are meant to be reachable is an
architecture decision. Not touched.

### Departed-attorney destinations

Unchanged from 2026-09-11 and still open.

## Deferred — new findings, not in this pass's approved scope

### redirects — 12 root-level aliases of retired blog posts (new)

`/can-a-witness-be-forced-to-testify-for-a-savannah-car-crash-case/`,
`/compensation-for-car-crash-facial-injuries-charleston/`,
`/your-guide-to-documenting-a-james-island-parkway-car-accident/`,
`/how-delayed-injuries-could-impact-your-charleston-car-crash-claim/`,
`/recovering-lost-wages-after-a-truck-accident-on-i-526/`,
`/what-to-do-after-a-truck-accident-on-i-526-in-charleston/`,
`/port-of-charleston-injury-claims-longshoremen-dock-workers/`,
`/proving-a-tourist-was-at-fault-in-your-charleston-accident/`,
`/goose-creek-car-accidents-military-traffic-us-52/`,
`/your-guide-to-rideshare-accidents-in-downtown-charleston/`,
`/seeking-justice-after-a-fatigued-trucker-accident-on-i-26/`,
`/your-step-by-step-guide-after-a-downtown-columbia-truck-accident/`.

This is the same shape as #213. A read-only probe found every one is a retired
(draft, `_roden_retired`) post whose `/blog/{slug}/` form **is** in
`roden_phase1_removed_urls()`. The root `/{slug}/` form is not. The root→`/blog/`
catch-all only matches published posts, so retiring the post killed the root
alias. The generator fix is the same pattern: canonicalise `/{slug}/` to
`/blog/{slug}/` before the removal-map lookup, then each lands where its `/blog/`
form already goes. This is minor redirect hygiene, recommended for the next pass.

### redirects — 3 two-hop chains (new cause)

`/blog/a-practical-guide-after-a-truck-accident-in-downtown-columbia/`,
`/a-practical-guide-after-a-truck-accident-in-downtown-columbia/` and
`/your-first-steps-after-a-truck-accident-in-downtown-columbia-sc/`. The legacy
consolidation map sends all three to
`/blog/your-step-by-step-guide-after-a-downtown-columbia-truck-accident/`, which
was retired afterwards and now 301s to `/practice-areas/truck-accident-lawyers/`.
The generator is `roden_redirect_dest_or_fallback()`, the single funnel for
legacy-map destinations, which does not consult the removal map. Resolving
destinations through `roden_phase1_removed_urls()` there fixes this class for
every future retirement too. Recommended for the next pass, together with the 12
above.

### redirects — 2 other LOST

- `/practice-areas/truck-accident-lawyers/drunk-driver-accident/`. No post and
  no rule. Needs a target (probably the truck pillar) or a 410.
- `/locations/south-carolina/murrells-inlet/`. A root-level form of the place
  retired as `/myrtle-beach/murrells-inlet/` on 2026-09-18. Needs a rule to
  `/locations/south-carolina/myrtle-beach/`.

### a11y — `HEADING_SKIP:h1->h3` on `/practice-areas/` and `/locations/` (new)

The cards on both hub pages are `h3`s directly under the hero `h1`, with no `h2`
section heading. Practice-area cards on the first; `h3.location-city` on the
second. This is a hub-template defect, a minor heading-level repair. Not in
scope this pass.

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
line and drop `--report-only`. If it is ended, the 18 LOST URLs and 3 chains
left after #213 would turn the job red until they are fixed, so the two
deferred redirect classes above should ship first.

## Re-run after #212 and #213 deploy

```
node vendor/site-health/site-health.mjs a11y      --repo . --base https://rodenlaw.com
node vendor/site-health/site-health.mjs redirects --repo . --base https://rodenlaw.com --live
```

Flush `wp cache flush` and `wp page-cache flush` first (600 s edge cache).
