# Site-health remediation — 2026-09-11

Source report: `data/site-health/latest.json` — crawl of production
(`https://rodenlaw.com`), 1230 sitemap URLs, generated 2026-09-10T18:10Z.
Overall: `pass: false`.

Production drift was checked before any work started, per `CLAUDE.md`. All 81
theme files matched the repo — no uncommitted prod edits to rescue.

Every finding class in the report is listed below. Report-only status does not
mean silence: Roden's post-deploy site-health job is observation-only until
2026-09-24, and these findings are recorded regardless.

## Summary

| Check | Finding class | Count | Status | PR |
|---|---|---|---|---|
| a11y | `HEADING_SKIP:h1->h3` | 467 | **Fixed** | #133 |
| a11y | `LOW_MAIN_TEXT_RATIO` | 162 | Deferred | — |
| a11y | `EMPTY_ALT` | 135 | Deferred | — |
| a11y | `DUPLICATE_TITLE` | 64 | Deferred | — |
| a11y | `WEAK_ALT` | 1 | Deferred | — |
| a11y | `TABLE_NO_TH` | 1 | Deferred | — |
| a11y | `AMBIGUOUS_LINK_NAME` (notice) | 26 | Deferred | — |
| redirects | `CHAIN` (2 hops) | 28 | **Fixed** | #134 |
| redirects | departed-attorney destinations disagree | 4 | **Disputed — owner** | — |
| redirects | `LOST` (404) | 24 | Deferred — owner | — |
| crawl | internal links taking a redirect hop | 14 | **Fixed** | #135 |
| crawl | unreachable from `/` — class actions | 15 | **Fixed** | #135 |
| crawl | orphans — case results | 156 | **Fixed** | #136 |
| crawl | orphans — root-level SC landing pages | 6 | Deferred — owner | — |
| crawl | `badStatus` | 0 | Passing | — |
| crawl | `falseAffordances` | 0 | Passing | — |
| floor | granularity-floor violations | 162 | Deferred — out of scope | — |
| doorway | ratio 40.9% vs 25% ceiling | 1 | Deferred — out of scope | — |
| linktopics | cross-topic links | 0 | Passing | — |
| canonicals | canonical defects | 0 | Passing | — |
| wikidata | entity mismatches | 0 | Passing (none referenced) | — |

Expected post-deploy movement: `HEADING_SKIP 467 → 0`, `chains 28 → 0`,
`linkProblems 14 → 0`, `orphans 162 → 6`, `unreachable 177 → 6`.

## Fixed

### a11y — `HEADING_SKIP` on 467 pages (PR #133)

**Two** emitters, not one, both rendering in the hero between the `h1` and the
first content `h2`: `<h3 class="form-title">` in
`roden_contact_form_sidebar()` (`inc/template-tags.php:1077`) and
`<h3 class="nap-name">` in `templates/template-intersection.php:133`. The
checker records only the first skip per page, so on intersection pages the NAP
block masked the form. A stratified 370-page sample of the failing set split
219 / 151 between them with no third cause.

Both lifted to `h2`. Classes kept — the CSS selectors are class-only, so no CSS
changed and no version bump was needed. The `Free Case Review` msgid is
byte-identical, so `/es/` pages do not fall back to English.

Verified with the vendored checker's own `auditHtml()` against live production
HTML for 381 of the 467 failing pages: `HEADING_SKIP before=381, after=0`, no
new issues, and a 20-page clean control unaffected.

### redirects — 28 two-hop chains (PR #134)

Fixed at the two rules that generate them, not at the 28 instances.

`redirects.csv` was **not** edited. Its only columns are `URL,Last crawled` — it
is the replay fixture, not a rule table. Editing it would change what is tested,
not what the server does.

- 24 blog chains: `roden_resolve_legacy_blog_dest()` returned the consolidation
  map's value verbatim, and 12 of those values are root-level blog slugs that
  the blog catch-all then 301s again. New `roden_normalize_blog_dest()` collapses
  the hop; its condition is byte-identical to the catch-all it pre-empts, so it
  cannot resolve anywhere the second hop would not have gone.
- 4 attorney chains: `roden_legacy_attorney_redirect()` rewrote to
  `/attorneys/[name]/` without checking whether that profile still serves. New
  `roden_resolve_attorney_dest()` consults both retirement mechanisms. This also
  retires the hand-maintained `$static_names` list that caused the drift.

All 28 finals were traced against production and all return 200. Every existing
final destination is preserved exactly.

### crawl — 14 internal links taking a redirect hop, 15 unreachable URLs (PR #135)

`crawl.mjs` truncates its "linked from" list to the first two sources, so the
report's named pages are samples, not the extent. All fixes are at the emitting
function.

- 11 staff profile links: `roden_attorneys_grid()` linked cards for team members
  whose `_roden_team_role` is `staff`, whose pages `roden_staff_redirect()` 301s
  away. Staff already have `roden_staff_grid()`, which renders the same card
  unlinked — the meta box states the contract explicitly. The exclusion now lives
  in the query, so all six previously-wrong call sites are correct, including the
  four templates that share the practice-area rendering. All 11 stay visible in
  the "Our Staff" sections; only the links go.
- `/class-actions/`: Main Menu item 2327 is bound to page 2324, still published,
  whose URL 301s to `/class-action-lawyers/`. The stale sitewide link and the
  15 unreachable class-action URLs are the same defect — a crawler does not
  count a redirect as a click path. `roden_fix_dead_nav_links()` gains a second
  branch, matching the precedent already in that filter.
- `/terms-privacy-policy/` → `/privacy-policy/` and `/free-case-review/` →
  `/contact/`, hardcoded in nine templates. URLs only; msgids untouched.

**There is no post-content component to this class.** A read-only sweep of all
four publishing surfaces — `post_content`, `post_excerpt`,
`_roden_key_takeaways`, `_roden_faqs` — across 1259 published items found zero
occurrences of any of the three stale targets. That zero was not taken at face
value: the live pages were checked directly, and the `/class-actions/` link is a
header nav item. No content patcher was shipped, because one that rewrote
nothing would be a spent script that reads as authoritative and is not.

`bin/repoint-class-actions-menu-item.php` rebinds the menu item to the live
pillar so the filter branch can later be deleted. It is **not required** for the
fix and **has not been run** — applying it is an owner action.

### crawl — 156 orphaned case results (PR #136)

Not a pagination limit. `roden_case_results_grid()` rendered `.result-card` as a
plain `<div>` with **no `<a href>` at all**, so `/case-results/` emitted zero
links to any case result (confirmed live: 0 matching hrefs). Pagination alone
would have fixed nothing. The same unlinked markup was inlined twice — in the
grid and again in `roden_load_more_results_handler()`.

A single `roden_case_result_card()` now renders it, wrapped in a link, used by
both call sites. `page-case-results.php` also renders a complete server-side
index of all 156, because the Load More button is JS and a crawler cannot press
it. `style.css` `Version:` bumped 1.4.20 → 1.4.21 for the CSS change; flush
`wp cache flush` and `wp page-cache flush` after deploy.

## Disputed — needs an owner decision

### Departed-attorney redirect destinations disagree with each other

Two conventions are live at once, produced by two different mechanisms:

| URL | Final | Mechanism |
|---|---|---|
| `/who-we-are/attorneys/zach-stohr/` | `/about/` | legacy map |
| `/who-we-are/attorneys/kiley-reidy/` | `/about/` | legacy map |
| `/who-we-are/attorneys/leah-crane/` | `/attorneys/` | `roden_staff_redirect()` |
| `/who-we-are/attorneys/ja-moore/` | `/attorneys/` | `roden_staff_redirect()` |

`hillary-burris`, `haley-yokeley` and `marina-baldwin` are also in the departed
map; `stephanie-aguirre`, `maddie-dowling`, `amsi-raudales` and five others
carry `_roden_team_role = staff`.

After PR #134 all are one hop to a 200, so none is a chain. Picking one
convention is a content decision, not redirect hygiene, so **each destination was
preserved exactly as-is**. The owner should decide whether a departed attorney
lands on `/about/` or `/attorneys/`, after which one mechanism can be retired.

## Deferred

### a11y warnings and notices — 303 warnings, 26 notices

`LOW_MAIN_TEXT_RATIO` 162, `EMPTY_ALT` 135, `DUPLICATE_TITLE` 64, `WEAK_ALT` 1,
`TABLE_NO_TH` 1, plus `AMBIGUOUS_LINK_NAME` 26 as notices. Non-gating at the
client's `strict: false`, so they do not affect pass/fail. Left deliberately —
`DUPLICATE_TITLE` and `LOW_MAIN_TEXT_RATIO` overlap the granularity-floor and
doorway questions below and should be decided with them, not ahead of them.

### redirects — 24 `LOST` legacy URLs returning 404

22 are retired sub-municipal neighbourhoods under Goose Creek, North Charleston
and Summerville — consistent with the granularity floor and correctly gone,
though each still wants an explicit destination or a deliberate 410 rather than
a bare 404.

Two are **not** sub-municipal and may have been retired in error:

- `/locations/south-carolina/charleston/moncks-corner/`
- `/locations/south-carolina/charleston/hanahan/`

Both are incorporated South Carolina municipalities and therefore *at* the
allowed floor, not below it. Owner decision pending on whether to restore them
or retire them deliberately. Not fixed.

### crawl — 6 orphaned root-level SC landing pages

`/spartanburg-sc-car-accident-lawyer/`, `/greenville-sc-car-accident-lawyer/`,
`/florence-sc-car-accident-lawyer/`, and the three
`*-sc-workers-compensation-lawyer/` twins.

Nothing links to them and they sit at the site root rather than under
`/locations/`, which is the shape of paid landing pages. If they are ad
destinations, being orphaned is intentional and they should be excluded from the
sitemap rather than linked. The owner needs to confirm. **Not linked from a hub,
because linking them would raise the doorway ratio that is already over ceiling.**

### floor — 162 granularity-floor violations, and doorway — 40.9% vs 25% ceiling

Explicitly out of scope for this pass. These are 156 genuine
sub-municipal / route / ZIP / county targets in the blog archive. They are a
content-strategy decision the owner has not made, they entangle with the open
legal-accuracy remediation and with the Spanish twins, and the recovery plan's
§2 forbids touching the blog.

Recorded, not touched. No orphan in this pass was fixed by adding a location
page, and nothing in PRs #133–#136 adds a geographic URL, so neither number
moves.

## Passing — no action

`linktopics` (40,432 internal links in rendered `<main>`, 0 cross-topic),
`canonicals` (1230/1230 checked, single canonical host), `wikidata` (no Wikidata
references found anywhere — worth noting this passes vacuously), and crawl's
`badStatus: 0` and `falseAffordances: 0`.

## One observation worth recording

The live half of `bin/check-unslashed-post-writes.php` currently validates
**zero** published JSON-LD blocks:

```
embedded JSON-LD blocks: 0   invalid: 0
PASS
```

That is not a blind sweep — but it is a vacuous one. An independent probe found
174 rows whose `post_content` contains `ld+json`, **none** of them
`post_status = 'publish'`; published schema is now emitted by the theme, which
regenerates on render and cannot be damaged by a content write. The real
backslash-bearing surface today is `_roden_faqs` (1313 rows with content), which
that half of the guard does not read.

The guard is still correct and still worth running. But a `PASS` from it should
not be read as "the JSON-LD surface was exercised", and the guard would be
stronger if its live half also parsed `_roden_faqs`.

## Re-run after deploy

`a11y`, `redirects` and `crawl` are all live-mode checks, so none can produce a
true "after" until these merge and deploy. Per the client's runbook:

```
node vendor/site-health/site-health.mjs a11y      --repo . --base https://rodenlaw.com
node vendor/site-health/site-health.mjs redirects --repo . --base https://rodenlaw.com --live
node vendor/site-health/site-health.mjs crawl     --repo . --base https://rodenlaw.com
```
