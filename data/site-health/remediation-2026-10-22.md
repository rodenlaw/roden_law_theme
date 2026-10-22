# Site-health remediation, 2026-10-22

Source report: `data/site-health/latest.json` (gitignored), generated 2026-10-22T20:59Z.
It is a live crawl of production (`https://rodenlaw.com`) covering 650 sitemap URLs, with
overall `pass: false`. It is the first report after the 2026-10-21 granularity-floor cull
(#223/#224) and the second-pass PRs (#219–#221). All of those are live: production
matched `origin/main` on every tracked theme file (101/101 md5) before work started, so
there were no uncommitted prod edits to rescue.

```
node internal-ai-scripts/scripts/site-health/site-health.mjs --repo . \
  --base https://rodenlaw.com --json --out data/site-health/latest.json
```

The owner approved this scope: the one redirect LOST and the three crawl orphans, in one
PR, because both come from the floor cull. Everything else is recorded below.

## Summary

| Check | Finding class | 10-21 | 10-22 | Status | PR |
|---|---|---|---|---|---|
| redirects | `LOST` `/blog/car-accidents-on-coleman-boulevard/` | 0 | 1 | **Fixed** | #247 |
| redirects | `LOST` (all other) / `CHAIN` | 41 / 3 | 0 / 0 | Passing (#219 live) | — |
| crawl | orphans / unreachable from `/` (3 `/resources/` guides) | 3 | 3 / 3 | **Fixed** | #247 |
| crawl | not 200, links that 404 or redirect, false affordances | 0 | 0 | Passing | — |
| floor | granularity-floor violations | 54 | 13 | Deferred: owner keep-list decision pending | — |
| doorway | location-targeted ratio | 23.9% | 19.1% | Passing (ceiling 25%), unchanged by #247 | — |
| a11y | `LOW_MAIN_TEXT_RATIO` 10, `WEAK_ALT` 1, `TABLE_NO_TH` 1 (warnings) | 12 | 12 | Deferred: out of scope, non-gating | — |
| linktopics | cross-topic links | 0 | 0 | Passing (23,926 links) | — |
| canonicals | canonical defects | 0 | 0 | Passing (650/650) | — |
| wikidata | entity mismatches | 0 | 0 | Passing, vacuously (none referenced) | — |

The `/practice-areas/truck-accident-lawyers/drunk-driver-accident/` LOST that was deferred
on 10-21 is gone from this report. The owner gave it a destination (truck pillar) in
`roden_orphan_alias_urls()`.

## Fixed (#247)

### redirects: `/blog/car-accidents-on-coleman-boulevard/` returned 404

`redirects.csv:234`. The legacy map in `inc/legacy-redirects.php` has the root form
(`/car-accidents-on-coleman-boulevard/`, a deleted duplicate). The removal map has
`/blog/car-accidents-on-coleman-boulevard-in-mount-pleasant/`, the post retired on
10-21 in `roden_floor_cull_mid_urls()`. Both go to `/car-accident-lawyers/charleston-sc/`.
The `/blog/` form of the duplicate had no rule. It resolved only through WordPress's
404 slug guess, which matched the published `…-in-mount-pleasant` post by prefix.
Retiring that post took the guess with it.

The legacy map does not normalise `/blog/` prefixes. Its convention is an explicit key
per URL form (for example the `/blog/savannah-ppi-attorney/` and
`/blog/blog-savannah-ppi-attorney/` pairs). An explicit entry was therefore added under
the root form, with the same target, through the same funnel
(`roden_redirect_dest_or_fallback()`).

**Verified** on prod's real maps with a read-only `wp eval-file`. It loads `main`'s and
the patched `inc/legacy-redirects.php` under a renamed prefix, unhooks the live handlers,
intercepts `wp_redirect`, and runs `$wp->main()` plus `template_redirect` per path over
all 997 fixture URLs and all 650 sitemap URLs.
- The `main` baseline reproduced a live one-hop trace of the fixture exactly: 0
  mismatches on the 974 URLs without a query string. The harness cannot model the 23
  query-string rows, and they are identical in both runs.
- Exactly one result differed between `main` and patched:
  `/blog/car-accidents-on-coleman-boulevard/` went from 404 to 301
  `/car-accident-lawyers/charleston-sc/` (1 hop). The target is live 200 and in the
  sitemap.
- No sitemap URL redirects in the patched run (650/650 serve), so nothing served is
  shadowed.

Harness note for next time: give each request a clone of the original `$wp`. A
`new WP()` lacks the CPT query vars that `register_post_type()` added (`practice_area`),
so `url_to_postid()` returns 0 for intersections and the funnel falls back to the pillar.
Reusing the one global `$wp` carries 404 state between requests. Either mistake makes the
baseline disagree with live (169 and 24 rows respectively here).

Noticed, not fixed: 30 root-level keys in the legacy map have no `/blog/` form. 18 of
those `/blog/` forms 404 live (`/blog/contact-us/`, `/blog/who-we-are/`, ...). None is
in the replay fixture, and most were never blog URLs, so there is no evidence anyone
requests them. Coleman was the only one with crawl history.

### crawl: 3 orphaned resources, unreachable from `/`

- `/resources/north-charleston-truck-accident-guide/` (4632)
- `/resources/pedestrian-bicycle-safety-north-charleston/` (4639)
- `/resources/personal-injury-claim-charleston-county-court/` (4640)

The generator is the "Legal Resources for {city}" block in
`templates/template-location.php`, which renders every office page. It fetched the **6
newest** resources sitewide and only then filtered them by office slug. Since September
the 6 newest have all been GA/SC statewide guides with no city in the slug, so nothing
matched and the section rendered on **no** office page (probe: 0 of 6 EN office pages).
These three are resources #43–45 of 47. They were reachable only through blog posts that
the 10-21 floor cull retired.

The block now queries every published resource in the request's locale (47 EN, 11 ES),
keeps those whose slug names the office's market or city, and then caps the list at 6. It
no longer pads the list with the newest non-local resources: that would now put Georgia
statewide guides on South Carolina office pages, and the padding never reached a page
anyway. There are no new strings (no msgid change), no CSS/JS (no Version bump), no new
page, and no content or database edit.

Effect (both templates rendered on prod, read-only, for every office page):

| Office page | Before | After |
|---|---|---|
| `/locations/south-carolina/charleston/` | no section | the 3 orphans + `dangerous-roads-north-charleston` |
| `/locations/georgia/savannah/` | no section | 2 Savannah truck guides |
| `/locations/south-carolina/columbia/` | no section | Broad River Road truck guide |
| `/locations/south-carolina/myrtle-beach/` | no section | Grand Strand fatal crash report |
| `/locations/georgia/darien/` | no section | no section (no local resource) |
| 4 `/es/` office pages (rendered in an ES context) | no section | no section (ES resource slugs name no city) |

A full HTML diff of the Charleston page shows the new section as the only change (plus
per-process image `fetchpriority`/`loading` attributes, a harness artifact). `/` links
the Charleston office, so all three become reachable. The checker's `auditHtml()` on live
Charleston HTML with the section spliced in: issues 0 → 0, warnings 0 → 0. All 8 newly
linked anchors pass the `linktopics` topic rules. No URL is added, so doorway (19.1%)
and the floor are untouched. Under the 90-day window this counts as a link fix (minor),
with no merge or retitle.

Not done, for the owner: `/locations/south-carolina/north-charleston/` is a
neighbourhood-flagged location. It renders through `templates/single-location-neighborhood.php`,
which has no resources block, so the two North Charleston guides are linked from
Charleston rather than from the North Charleston hub. A hub block would be a new
section on a shared template. The obvious helper, `roden_related_resources()`, has the
same newest-N-then-filter shape (`count + 16`), so it cannot reach these guides either.
That helper also feeds intersection and sub-type pages, so changing it changes the
legally swept resource lists across many pages.

## Deferred

- **floor, 13 granularity-floor violations.** Owner keep-list decision pending
  (`docs/floor-cull-2026-10-21.md`). Excluded from this pass by the owner.
- **a11y warnings.** `LOW_MAIN_TEXT_RATIO` 10, `WEAK_ALT` 1, `TABLE_NO_TH` 1. These are
  non-gating (650/650 pages clean of issues) and excluded by the owner.
- **deploy.yml observation mode.** The site-health job is still `continue-on-error` /
  `--report-only` (until-date 2026-09-24 passed). Ending it is the owner's call and out
  of scope here. After #247 deploys, the floor's 13 are the only gating failures left,
  so ending observation mode before the keep-list decision would turn the job red.

## Re-run after #247 deploys

Flush both cache layers first (600 s edge cache), from `~/sites/rodenlawprod`:
`wp cache flush && wp page-cache flush`.

```
node vendor/site-health/site-health.mjs redirects --repo . --base https://rodenlaw.com --live
node vendor/site-health/site-health.mjs crawl     --repo . --base https://rodenlaw.com
```

Expected: `redirects … ok: 997 · chains: 0 · lost: 0` and
`crawl … orphans: 0 · unreachable from /: 0`.
