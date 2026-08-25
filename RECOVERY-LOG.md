# rodenlaw.com — recovery log

Companion to `SEO-PREEMPTION-PLAN-rodenlaw.md`. One entry per shipped batch, one
KPI snapshot per completed Google update. **Judge nothing between update
boundaries** (plan §6.2) — intra-update movement is noise.

## KPI baseline — Jul 2026 (pre-cleanup)

| Metric | Baseline |
|---|---|
| Positions 1–3 | **68** |
| Est. monthly traffic | 1,701 |
| Keywords top 100 | 5,720 |
| Published URLs (all public types) | 1,659 |
| Location + practice-area URLs (the doorway scope) | 668 |

Source: Semrush US database, plan §1. URL counts from
`bin/export-url-inventory.php` against production, 2026-08-21.

**Success = positions 1–3 holds or climbs through the next core update instead
of halving again.** Traffic is the lagging confirmation, not the trigger.

## URL inventory at baseline

| Post type | URLs | Notes |
|---|---:|---|
| post | 484 | Guardrail keep — strongest non-brand asset |
| practice_area | 449 | 404 keep · 11 consolidate · 34 remove |
| location | 219 | 14 keep · 117 evaluate · 88 remove |
| case_result | 156 | Guardrail keep |
| case-result *(legacy CPT)* | 156 | **129 duplicate the above at a second live URL** |
| resource | 78 | Guardrail keep |
| page | 65 | Guardrail keep |
| testimonial | 21 | Not in sitemap |
| attorney | 17 | Guardrail keep |
| staff | 14 | Not in sitemap |

## Resolved — the 250–350 acceptance criterion

Plan §4 originally set an end state of ~250–350 URLs. **That number was an
artifact, not a target**, and it has been retired (see the amendment in §4 of the
plan).

Where it came from: §1 estimated ~1,500 total URLs of which ~470 were location
and ~650–700 practice — so `1,500 − 1,145 ≈ 355`. The end-state figure was simply
whatever the audit's arithmetic left over. It encoded no view about which pages
deserve to survive.

Where it went wrong — the total was nearly right, the split was not:

| | Audit | Actual | Source |
|---|---:|---:|---|
| Total URLs | ~1,500 | 1,439 indexable · 1,659 public | sitemaps · post-type enumeration |
| Location | ~470 | **219** | `wp-sitemap-posts-location-1.xml` |
| Practice area | ~650–700 | **449** | `wp-sitemap-posts-practice_area-1.xml` |
| Doorway share of site | ~76% | **46%** | derived |
| Blog | uncounted | **484** | `wp-sitemap-posts-post-1.xml` |

Guardrail-protected types alone are 991 URLs, so ~250–350 could only have been
reached by cutting the blog and case results that §2 explicitly forbids touching.

**Restated criterion, same intent:** every URL below city level gone, every
non-office city×practice gone, every micro-permutation merged or redirected, and
nothing legitimate removed — measured as **418–535 location + practice-area URLs,
down from 668**. The five structural criteria (classified exactly once, zero
internal 404s, zero internal links through 301s, sitemaps 200-only, 20 spot-checked
single-hop redirects) were always the real test and are unchanged.

### Progress against the restated criterion

Target: **418–535 location + practice-area URLs, down from 668.**

| | Location + practice area | All public URLs |
|---|---:|---:|
| Baseline (2026-08-21) | 668 | 1,659 |
| After batch (b) — 8 removed | 660 | 1,651 |
| After batch (d) — 34 removed | 626 | 1,617 |
| After batch (a) — 88 removed | **538** | **1,529** |
| Remaining to the top of the target band | 3 | — |

Still to come: batch (c) practice micro-permutations (11 consolidate, staged
2026-08-24) and the 109 tier-3 EVALUATE rows pending the GSC export.

**Batch (e) is closed as N/A.** All 125 `/es/` rows in `url-triage.csv` classify
KEEP, and none mirrors a page removed by (a), (b), (c) or (d) — the Spanish
location tree is only the six office cities, which are a guardrail keep. Plan
rule 8 has nothing to act on. Verified two ways: every `/es/` row cross-checked
against the REMOVE and CONSOLIDATE sets by both full path and terminal slug (zero
overlap on either), and an hreflang reciprocity spot-check on survivors — Charleston
and Darien, both locales — confirming self-canonical per locale, reciprocal `en`/`es`
alternates and `x-default` on English.

*(The line this replaces listed (a), (e) and (f) as outstanding; (a) and (f)
completed the same day it was written.)*

### The `/resources/` corridor band — reclassified 2026-08-24

Recorded here separately from the batch sequence because it changes what the GSC
export is worth, not what has shipped.

`url-triage.csv` had all 78 `resource` pages as KEEP, reason "guardrail keep-list:
resource page" — a guardrail written for the statewide legal library that swept up
a second, unrelated body of work sharing the post type. Post IDs separate them
cleanly: library **4806–5223** (19 pages), April 2026 corridor campaign
**4617–4690** (48 pages), a 116-ID gap and no overlap. Plan §8 already named one of
the 48 as a micro-permutation example while the triage protected it.

The 48 are now **EVALUATE**, and the distinction from REMOVE is load-bearing. The
templating claim was measured, not assumed, and it does not hold: pairwise
self-similarity on live `entry-content` runs **1.2–1.8×** the library baseline and
converges toward parity at longer n-grams. These are 700–1,955 words of
substantively distinct prose, unlike the 250-word place-name swaps of batches (a)
and (d). Nothing here may be removed on a duplicate-content argument.

The case against them is the generative pattern and the query overlap it left —
5 slugs on I-26, 5 on construction zones, 6 on ports — plus the site's own
`roden_related_resources()` surfacing none of them, even on
`/truck-accident-lawyers/charleston-sc/`, whose most obvious companions sit in this
band.

**Consequence for the owner list:** the 16-month GSC export now decides **157**
URLs, not 109.

### Corridor fold — decided 2026-08-24

The GSC evidence resolved the corridor band, and the answer was not the one the
Steinberg plan assumed. **37 of the 48 keep their URLs**; **11 fold** into Study #1.

| | Pages | Clicks, 13 mo | Disposition |
|---|---:|---:|---|
| Performers | 37 | 311 | **KEEP** — page-one positions, more clicks than the whole 19-page legal library |
| Zero-click | 11 | 0 | **CONSOLIDATE** — 301 to the practice pillar, repoint to the Corridor Report on publication |

Steinberg §3 priority 1 has the road pages' value flowing into the Corridor
Report. That is right for the dead ones and wrong for the rest: folding all 48
would have discarded working long-tail to build an asset that then starts from
zero. The plan's instinct was sound and its scope was not.

The 11 live in their own `roden_corridor_fold_urls()` rather than in the Phase 1
array, because this decision came from evidence rather than the plan's
classification rules, and because repointing the targets at the study later should
be a self-contained edit rather than a hunt through 130 batch entries.

301 targets are practice pillars rather than a surviving sibling corridor page.
A sibling would read better and would risk a chain if it is ever folded; pillars
are guardrail keeps, so the target is chain-proof by construction.

The bodies are harvested before the trash step: ~12,900 words across the 11,
captured by `bin/fold-corridor-zero-click.php`'s dry run. A content harvest that
ends in a redirect, not a deletion.

**Confidence bound, recorded because it is easy to lose:** the GSC UI export caps
`Pages.csv` at 1,000 rows with a 1-click minimum, so zero-click pages are absent
and their **impressions are unknown**. "Zero clicks" is certain; "invisible" is
not. That is why these 301 rather than 404, and why the bodies are kept.

The 117 nested location pages — 66 of them zero-click — are **deferred** on the
same gap, pending Search Console API access.

### The 66 dead location pages — decided 2026-08-25

The last of the EVALUATE backlog, and the Search Console API is what settled it.
The UI export could not: it caps at 1,000 rows with a one-click minimum and
omitted every page in this set, which is why they read as "zero clicks,
impressions unknown" on 2026-08-24. The API pull returns 2,789 pages to the
export's 999.

**21,548 impressions. 1 click. CTR 0.005%.** Against the site's own rate at
matching positions:

| Avg position | Rest of site | The 66 |
|---|---:|---:|
| 5–10 | 0.48% | **0.00%** (0 of 6,814) |
| 10–15 | 0.41% | 0.01% |
| 15–20 | 0.21% | 0.00% |

At positions 5–10 the site's own rate predicts about 33 clicks. They produced
zero. These are not pages that never got a chance: Google matches them to
queries, serves them, and no human wants them.

Targets are the parent office-city hub. That differs from batch (a), which
deliberately redirected *past* the tier-3 municipalities to the tier-2 hub because
those municipalities were still EVALUATE and might later go. These 66 **are** that
tier-3 layer; with them resolved the parent is both the natural target and a
guardrail keep, so it is chain-proof. All six hubs verified 200 before shipping.

Two things done differently, both learned from earlier batches. The paths live in
`roden_dead_location_urls()` and both scripts read them from there rather than
carrying a copy, so the redirect map and the removal set cannot drift — batches
(a), (b) and (d) each held their own list. And the removal script *reports* inbound
editorial links on a dry run instead of only aborting, so one pass sizes the relink
workload; it still refuses to apply while any remain. Batch (a) found 53 links
across 23 posts, so this is not a formality.

Expected after: location URLs 123 → 57, all public 1,529 → 1,463.

### End-state arithmetic

| Scope | Now | After definite removals | If all EVALUATE also go |
|---|---:|---:|---:|
| Location + practice area *(the gate)* | 668 | 535 | 418 |
| Indexable (sitemap) | 1,439 | 1,306 | 1,189 |
| All public URLs | 1,659 | 1,526 | 1,409 |
| All public, less the 129 legacy case-result duplicates | 1,659 | 1,397 | 1,280 |

"Definite removals" = 122 REMOVE + 11 CONSOLIDATE. The 117 EVALUATE rows split
into 8 city-tier towns and 109 nested municipalities; see the recommendation in
`OWNER-CHECKLIST.md`.

---

## Batch log

| Date | Batch | URLs before | URLs after | Removed | Notes |
|---|---|---:|---:|---:|---|
| 2026-08-21 | **(b)** non-office city pages | 1,659 | 1,651 | 8 | **COMPLETE.** Redirects live, 8 posts trashed, caches flushed. Verified after deletion: 8/8 single-hop 301, no 404s; location sitemap 219 → 211. Backup: `docs/backups/batch-b-sc-town-locations-2026-08-21.json`. |
| 2026-08-21 | **(f)** duplicate case-result URLs | 1,529 | 1,529 | 0 | **COMPLETE.** 129 duplicate URLs 301 single-hop to their canonical twin; all 27 legacy-only slugs still return 200, proving the pattern did not over-match. No post removed — duplicate *URLs*, not duplicate content. Retiring the 27 remains an open decision. |
| 2026-08-21 | **(a)** neighbourhood + subdivision | 1,617 | 1,529 | 88 | **COMPLETE.** Relink applied (53 links, 23 posts, `post_modified` preserved), redirects live, 88 posts trashed, caches flushed. Verified after deletion: 88/88 single-hop 301, no 404s; location sitemap 211 → 123. Backups: `batch-a-relink-*.json`, `batch-a-neighborhood-locations-*.json`. |
| 2026-08-21 | **(d)** non-office city×practice | 1,651 | 1,617 | 34 | **COMPLETE.** Redirects live, 34 posts trashed, caches flushed. Verified after deletion: 34/34 single-hop 301, no 404s; practice_area sitemap 449 → 415; intersection grids self-healed to pillars, zero surviving links. Backup: `docs/backups/batch-d-nonoffice-city-practice-2026-08-21.json`. |
| 2026-08-25 | **(c)** practice micro-permutations | 1,529 | 1,518 | 11 | **COMPLETE.** Relink applied (51 links, 42 posts, `post_modified` preserved), redirects live, 11 posts trashed, caches flushed. Verified after deletion: 11/11 single-hop 301 flat **and** nested; zero remaining inbound body links; practice_area sitemap 415 → 404. Backups: `batch-c-relink-2026-08-25.json`, `batch-c-micro-permutations-2026-08-25.json` — the latter is also Study #1's source text. |

### Batch (c) — two things the plan did not predict

**PR #61 was wrong that batch (c) needed no link stripping.** The reasoning was
that all 11 are linked from their parent pillar by `$child_subtypes`, a
`get_posts()` query that self-heals on trash. True, and not the whole picture: a
DB sweep found **42 editorial links in post bodies across 25 posts**, which no
template query touches. Batch (a) hit the same thing at 53 links. *"The grid
self-heals" answers a different question from "is this URL linked", and only the
second one gates a removal.* The removal script's guard caught it, which is why
it aborts rather than warns.

Relink handled 51 links across 42 posts once both address forms were counted.
`post_modified` verified untouched afterwards — two of the sampled posts still
show `post_modified === post_date`.

**And the nested practice-area form was 404ing since batch (d) shipped.** Every
child `practice_area` has a flat canonical and a nested duplicate;
`roden_redirect_duplicate_pa_path()` 301s nested → flat but resolves through
`get_post()`, so it stops the moment the post is trashed, and the removal map is
keyed only on the flat path. So `/practice-areas/car-accident-lawyers/summerville-sc/`
and its siblings had been returning **404 since 2026-08-21** — a live breach of
the §2 no-404s rule, invisible because the flat form 301s correctly and that is
what anyone would spot-check.

Fixed by canonicalising the request path before the map lookup, reusing
`roden_canonicalize_pa_path()`. Verified: batch (d)'s nested URLs now 301
single-hop to 200, live pillars and live intersections unaffected. The repair
covers every future practice-area removal without a second set of keys.

Worth keeping as a verification habit: **check both address forms after a
removal, not just the canonical one.**

### Applied 2026-08-25 — corridor fold and the 66 dead location pages

Both shipped end to end: redirects deployed, relinks applied, posts trashed,
caches flushed, verified after deletion.

| | Removed | Relinked | Verified |
|---|---:|---|---|
| Corridor fold | 11 resources | 20 links / 18 posts | 11/11 single-hop 301 → 200 |
| Dead locations | 66 locations | 43 links / 21 posts | 66/66 single-hop 301 → 200 |

Sitemaps: location **123 → 57**, resource **78 → 67**, practice_area **415 → 404**.
Indexable **1,310 → 1,222**. Zero remaining inbound body links to any removed URL
across all three maps. `post_modified` untouched on all 23 relinked posts that are
still published (the 3 that were stamped are ones this batch trashed, where
`wp_trash_post()` legitimately stamps and nothing renders).

**Doorway ratio: 29.2% pre-cull → 22.7% this morning → 19.0% now**, against
Steinberg Principle 1's ≤25%. Location pages alone are 4.7%. All 175 surviving
city×practice pages are in the six office markets, which is the defensible tier
under rule 6. *The ratio is no longer the constraint on this site.*

### Three defects this batch surfaced, none of which the plan predicted

Each was found by a guard or a sweep rather than by reasoning, and each is now
fixed in a way that covers future batches rather than just this one.

1. **The nested practice-area form 404s after a trash.** Live since batch (d)
   shipped on 2026-08-21 and invisible because the flat form 301s correctly — which
   is what anyone spot-checks. Fixed by canonicalising before the map lookup.
2. **Editorial body links are not the same as template links.** "The pillar grid
   self-heals" was true and did not answer "is this URL linked". 42 body links on
   batch (c), 20 on the corridor fold, 43 on the locations.
3. **`_roden_see_also` is post_meta, so every body sweep misses it.** Five published
   pages kept see-also entries pointing at the folded resources. Fixed by resolving
   see-also URLs through the removal map at render time.

**Verification habits worth carrying forward:** check *both* address forms after a
removal; sweep post_meta as well as post_content; and confirm `post_modified` on
the posts that are still published, separately from the ones you trashed.

### Track E — the guardrail holes, closed 2026-08-25

The cull removed 196 URLs and nothing stopped any of them coming back. Two
seeders in `bin/` with their payloads still on disk would have recreated 42 in a
single run, and eight forbidden location drafts were sitting in the CMS one
Publish click from live. Both plans said "no new location pages, no exceptions";
neither was enforced anywhere.

| Hole | Closed by |
|---|---|
| A Publish click recreates a banned page type | `inc/content-guardrails.php` gates the transition to `publish` |
| 8 forbidden drafts in the CMS | trashed, backup `docs/backups/location-drafts-2026-08-25.json` |
| Seeders that recreate batches (b) and (d) | retired with their payloads; `bin/README.md` records why |

**Two rules with different lifetimes, and that distinction is the design.**
Sub-city pages are banned *permanently* and survive the freeze being lifted. New
city-tier pages are *frozen* behind `RODEN_LOCATION_FREEZE`, because the plan
explicitly allows one with a partner-approved business case — a real future need,
so it gets a documented switch rather than a wall. A third check catches a bug
rather than a policy breach (a slug equal to its parent's, which publishes a
duplicate office hub at a nested URL) and runs first, so the freeze cannot swallow
it and report the wrong reason.

**Proven against production, not just unit-tested.** Attempting to publish a
sub-city page and a duplicate-of-parent page both came back as `draft`; an
ordinary blog post published normally; all three test posts force-deleted with no
residue. `php bin/test-content-guardrails.php` covers ten cases standalone, and
two of them caught real bugs during development — the duplicate-slug check
originally sat in an `else` branch, and the sub-city ban did not survive the
freeze being lifted until a test said so.

The eight drafts were never published, so there is no URL, no index entry and no
redirect: sitemaps are unchanged at location 57 / practice_area 404. Three of them
duplicated their own parent office city, two sat under a parent batch (a) had
already trashed, and one was a second Sullivan's Island page whose tier-3 twin was
removed the same day for taking 540 impressions and no clicks.

**Left deliberately:** `practice_area` draft 4630, *Warehouse & Logistics Injury
Lawyers* (553 words, April 2026). It is a practice sub-type rather than a location
page, so it is a content decision for after the freeze, not a guardrail matter.

### Statistics audit — applied 2026-08-25

Five numeric claims repeating verbatim across **12 published pages** were removed:
22 removals, verified zero remaining. Full trace in `docs/stat-audit-2026-08-25.md`;
before/after and the removal log in `docs/backups/stat-remediation-2026-08-25.json`.

**Two of the five were not merely uncited — they were wrong.**

*"South Carolina recorded 3,167 large truck crashes in 2024"* does not reproduce.
Three sources gave three numbers for the same quantity: the site's 3,167, an FMCSA
MCMIS snapshot at 3,342, and the FMCSA portal queried live at 1,107 (flagged
incomplete). FMCSA counts are a rolling snapshot, so **any bare figure without a
source and a snapshot date is indefensible** — a structural problem, not a typo.

*"23% increase in fatal truck accidents"* runs the wrong way. FMCSA shows SC fatal
large-truck crashes falling 122 → 74 in 2024; the FARS series (113/131/120/111/126)
peaks at +15.9% in any year pair. Nothing produces 23%.

The other three — "354 collisions", "62 injuries", "2,500 truck-related crashes" —
could not be verified from any reachable public source.

**A trap worth remembering:** a general web search returned *"According to the most
recent data from FMCSA, South Carolina recorded 3,167 large truck crashes in
2024"* — almost the site's own wording. That is very likely the search engine
paraphrasing these pages back. Circular sourcing is how a number survives four
years and twelve pages; confirm against the agency portal, never a search summary.

Dated honestly: `_roden_last_refreshed` set on all 12, `_roden_last_reviewed` left
alone, `post_modified` not stamped. The theme documents that distinction and cites
the 2026-08-07 seat-belt corrections as precedent — copy that was wrong, fixed by
someone who is not a lawyer.

**Two things this did NOT fix, both recorded rather than quietly left:**

1. `/blog/ashley-phosphate-i-26-south-carolinas-deadliest-intersection/` — three
   uncited claims removed from the body, but **the headline still asserts the
   ranking**. Retitling a published post is an editorial decision; a suggested
   title is in the audit doc.
2. **The audit was scoped too narrowly.** A pattern scan found ~30 further pages
   carrying superlative rankings, ratio claims or aggregate counts. They are only
   *shaped* like the removed claims — some will be properly sourced — so they need
   a per-claim assessment pass, not a sweep. Start with
   `/resources/abercorn-street-truck-accidents-savannah/`, a GSC-confirmed keeper
   asserting both a ranking and a serious-injury ratio in consecutive sentences.

### Statistics audit round 2 — sitewide, applied 2026-08-25

Round 1 recorded that its scope was too narrow. This is the systematic pass:
**14 further edits across 11 pages**, verified to zero. Full assessment in
`docs/stat-audit-round2-2026-08-25.md`.

A sweep of every published post produced 1,004 candidate sentences; filtering out
legal thresholds, dollar figures and statute citations left **254 across 163
pages**, split by whether the claim is falsifiable.

**The pattern that decided most of it: nationally-sourced claims held up, local
ones did not.** "563 of South Carolina's 1,038 traffic deaths in 2024" checks out
exactly against FARS. Every local road ranking failed — none named a retrievable
publication, and the one that could be tested was wrong.

**Proven false:** *"Chatham County reported 59 traffic deaths in 2022 — a top-5
county statewide."* FARS gives Chatham **40 deaths, ranked #8** of 152 Georgia
counties. 59 is **Clayton County's** figure, the actual #5. Both halves wrong.

**Upgraded rather than deleted:** *"US-17 is the most dangerous road in Horry
County"* turned out directionally supportable — FARS 2024 shows US-17 with more
fatal crashes than any other Horry roadway, 6 of the county's 57. Replaced with
that sourced statement citing the exact annual file and access date. The
accompanying "2,181 motor vehicle accidents" is all-severity, absent from FARS,
and went. **That is the outcome to aim for: an unsourced superlative becomes a
smaller, checkable, cited fact.**

Removed elsewhere: the Ashley Phosphate statewide ranking (3 pages, including as
link anchor text), tri-county and Horry County intersection rankings on two
**location pages**, a Columbia interchange crash/injury/fatality count, a
"most dangerous construction zone in the Southeast", and Savannah's "#1 most
dangerous intersection" with its "1 in 4 crashes" ratio.

**Deliberately left:** generic superlatives that describe a hazard rather than
rank a named place ("left-turn crashes are among the most dangerous on this
road") — not falsifiable, not a liability. And
`/blog/myrtle-beach-dangerous-roads-intersections/`, whose claims name the SC
Highway Patrol and City of Myrtle Beach police records — weaker than a full
citation, but a different class from a bare assertion.

**Still open:** the Ashley Phosphate post's *headline* still asserts "South
Carolina's Deadliest Intersection" while both rounds have now stripped its
supporting evidence from the body. That is the worst of both states and needs an
editorial decision.

### Study #1 published — the I-26 / I-95 Corridor Report, 2026-08-25

`/resources/i-26-i-95-corridor-report/`. The first of the Steinberg plan's §3
linkable research assets, and the first thing on this site built to be checked
rather than to rank.

**323 fatal crashes, 374 deaths, 109 truck-involved** on I-26 and I-95 across both
states, 2020–2024, from NHTSA FARS. The headline is a two-state finding no
single-state competitor can produce: **45% of fatal crashes on Georgia's I-95
involve a large truck, against 27% on South Carolina's I-26** — an ordering that
holds under the stricter tractor-trailer-only definition (39/25/18), which is why
both are published.

The analysis script, the chart generator and the 323-row dataset all ship with it.
All 33 figures in the prose were verified programmatically against the dataset
before publication; one failed and was corrected. After the same day's statistics
audit removed 36 unchecked claims from 21 pages, publishing a research report
without applying that test to its own numbers would have been indefensible.

**Six of the folded corridor redirects now point at it** (PR #74), verified 6/6
single-hop 301 → 200. The other five deliberately still point at practice pillars:
a rideshare page, a workers-comp page, a what-to-do-after guide and the port
truck-routes page are not what a corridor crash study answers, and sending them
there would be a worse landing. **Repointing should mean the destination is more
relevant, not merely newer.**

Three defects were found and fixed between seeding and publication, none of which
would have surfaced from reading the code:

1. **Inline SVG is destroyed by `wp_kses_post`.** The charts rendered correctly,
   but the first editor without `unfiltered_html` to hit Update would have
   silently deleted them and ~4 KB of report. Replaced with the `[roden_chart]`
   shortcode, which is plain text to KSES; SVGs now live in `assets/charts/`.
2. **The seeder was not safe to run twice** — it duplicated the dataset
   attachment and reset `post_author` to 0 on update. Both fixed; it has to run
   again every year when the next FARS file lands.
3. **The report promised a downloadable dataset and did not link it.** On a study
   whose entire value is citability, that was the most important link on the page.

**Operational notes worth keeping.** Publishing through the classic editor
round-trips content through `wpautop` and strips seeded `<p>` tags, so later edits
must anchor on plain text. And **Cloudflare fronts WP Engine**: `wp cache flush`
and `wp page-cache flush` clear the origin while the edge keeps serving for up to
ten minutes, so verify page content with a cache-buster or read the database
directly.

**Outstanding:** `_roden_last_reviewed` is unset. It publishes `lastReviewed` and
`reviewedBy` in schema and should be set once — and only once — an attorney has
genuinely read the page.

### Ashley Phosphate corrected, and three of my removals reversed — 2026-08-25

Reviewing the headline found a source neither earlier round reached, and it cuts
both ways.

**The claim was false, and worse than uncited.** A *Post and Courier* analysis of
preliminary SCDPS data, 2011–2015, records **629 crashes** at Ashley Phosphate and
I-26 — the most of any intersection in the tri-county, but **second statewide**
behind I-20 at US-176. And decisively for a page calling it the *deadliest*:
**none of the 629 was fatal**, though 181 people were injured.

Wrong on both halves. Not first in the state, and by the only published figures
not deadly at all — high-frequency, low-severity, which is a better fact than the
one the page asserted. Corrected rather than deleted, with the citation. Title now
*"Why Ashley Phosphate & I-26 Is the Tri-County's Highest-Crash Intersection"* — a
superlative that is true. Anchor text on an English and a Spanish post repeated
the false ranking and was reworded.

**Three claims removed earlier today were accurate**, and are restored with the
citation: "one collision every three days" at Ashley Phosphate; College Park Road
/ Exit 203 at 381 collisions, second in the tri-county; and 62 injuries at Rivers
Avenue / I-526, the highest injury total in the top ten.

Removing them was defensible on the evidence then available — uncited, and nothing
I could reach confirmed them. But **"I could not verify this" is not the same
finding as "this is false", and the remedy for the first is a source, not a
deletion.** For the remaining backlog: search for the source before removing a
claim, not only for a contradiction. A local paper analysing state data does not
surface from an agency portal query.

**Left deliberately:** the slug still reads `…south-carolinas-deadliest-intersection`.
Changing it costs a 301 and an exact-match URL during an active recovery; the
title and body are what a reader sees. Recorded for a later URL-hygiene pass,
along with `/resources/rivers-avenue-truck-accidents-north-charleston/` calling
Rivers Avenue "one of the four deadliest roads in Charleston County" — a
falsifiable ranking neither round assessed.

### Rivers Avenue corrected — 2026-08-25

Sourced first this time, per the lesson from the Ashley Phosphate review, and the
source existed.

**Live 5 News, July 2026, citing SCDOT traffic data:** *"four of the county's five
deadliest roads are in North Charleston"* — Rivers Avenue, Dorchester Road, Ashley
Phosphate Road and Remount Road. Verified by fetching the article directly rather
than trusting a search summary.

The page claimed Rivers Avenue was **"one of the four deadliest roads in Charleston
County"**. That is a real misreading of a real source: the four are not the county's
four deadliest, they are the four *in North Charleston* among its five deadliest.
The page claimed a higher rank than its own evidence supports. Corrected to what
SCDOT actually says, with the citation and the other three corridors named.

Two more on the same page:

* The heading **"North Charleston's Deadliest Corridor"** asserted a rank nobody
  published — SCDOT names four corridors and ranks none against the others. Now
  simply "Truck Accidents on Rivers Avenue, North Charleston".
* **"This interchange is one of the most dangerous in the Charleston metro area"**
  was unsourced, but the figure behind it exists: the Rivers Avenue/I-526
  interchange produced **62 injuries, 2011–2015 — the highest injury total in the
  tri-county top ten**. Replaced the assertion with the fact, cited.

That last one is the pattern worth repeating: an unsourced superlative usually has
a smaller, checkable, more interesting fact underneath it. The superlative is what
someone wrote when they could not be bothered to find the number.

### Claims assessment round 4 — the backlog, mostly not removed — 2026-08-25

Round 3's method applied to what was left: **search for the source before removing
a claim.** The result is mostly *not* removal. Full reasoning in
`docs/stat-audit-round4-2026-08-25.md`.

A re-scan after rounds 1–3 returned 133 claim-shaped sentences across 98 pages.
Splitting by whether the subject is a **rankable place** or a **hazard type**
collapses it: 36 sentences across 35 pages are hazard statements — "underride
crashes are among the deadliest truck accident types", "trench collapses are among
the deadliest hazards in construction" — which describe a mechanism, not a
rankable place. Not falsifiable, not a liability, **left alone.** Earlier rounds
nearly swept them up.

Of the 26 place-ranking pages, most are table-of-contents lines or anchor text
pointing at three roundup pages. Those roundups are what actually carry the risk.

**Verified true and upgraded:** *"National safety studies have ranked I-95 as one
of the most dangerous highways in the entire country."* FARS 2022–2024 puts I-95
**second of 222 interstate designations** by fatal crashes — 924 crashes, 1,020
deaths, behind only I-10. The claim was right; "national safety studies" named
nothing checkable. Replaced with the figure and the source.

**Removed:** *"1 in 4 accidents classified as dangerous-level collisions"* —
*dangerous-level collision* is not a recognised classification in FARS, SCDPS or
GDOT reporting. The phrase does not mean anything.

**Left alone, and this is the part worth remembering.** Two claims survived
because my evidence did not address them. The Savannah page says Chatham County
ranks top-five in Georgia **for total collisions**, citing GDOT; I tested it
against FARS, found Chatham sixth to eighth by *deaths*, and nearly corrected the
page on that basis. FARS counts deaths, the claim counts collisions, and Chatham
is Georgia's fifth-most-populous county. Same for Columbia's I-20 claim, qualified
"by crash volume" — where FARS happens to agree on direction anyway (I-20 leads
Richland and Lexington on fatal crashes, 35 to I-77's 31).

**A claim is only falsified by evidence measuring the same thing it measures.**
Rounds 1–2 removed claims for being unverifiable; round 3 found three of those
were true; round 4 nearly removed two more on a metric mismatch. Every error this
week has pointed the same way — toward deleting things that were fine.

**Flagged, not removed:** Columbia's *"934 collisions, killing 5, injuring 260"* —
specific, all-severity, unsourced. The right next step is a records request to
SCDPS, not a deletion.

### Columbia page sourced rather than stripped — 2026-08-25

The flagged claim resolved better than expected, and the method is the point.

The page carried four numeric claims, each hedged as **"in a single recent
year"** — a phrase that is its own tell. Rather than remove them, I went looking
for where they came from, and pulled the **SCDPS Traffic Collision Fact Book, 2023
edition** directly and extracted its tables.

**The claims were real.** SCDPS publishes county totals *and* selected
intersection tables, and every figure on the page matched that shape — right
tables, right structure, wrong (or rather, unnamed) year. Not invented: undated
and uncited.

All four are now dated and cited to the primary source:

| Was | Now |
|---|---|
| "more than 12,700 collisions… top five counties" | **12,450 in 2023, third of 46 counties**, 58 fatal, 60 killed |
| Malfunction Junction "91 collisions, two fatal" | **145 collisions in 2023, none fatal**, 28 injured (Lexington County table) |
| SC-12 at I-77 "104 collisions, 38 injuries, one fatality" | **116 collisions in 2023**, one fatal, 29 injured (Richland County table) |
| I-20 Richland "934 collisions, killing 5, injuring 260" | **35 fatal crashes on I-20 in Richland+Lexington 2020–2024** (FARS), 21 in Richland alone; **2,176 collisions on I-20 statewide in 2023** (SCDPS) |

The last one is the only genuine substitution. **SCDPS does not publish a
route-by-county table** — statewide route totals and county totals are separate
tables — so "934 collisions on I-20 in Richland" cannot have come from the Fact
Book and could not be located anywhere. Replaced with two figures that can be
checked: the fatal count from FARS, which does support that cut, and the statewide
I-20 total from SCDPS.

Worth noting the claim was *not* fabricated even there: FARS records exactly **5
deaths on I-20 in Richland in both 2020 and 2023**, matching the "killing 5" half.
Someone had real data and did not write down where it came from.

**Zero "recent year" phrases remain on the page.** Verified live.

This is the fourth-round method paying off: the page went from four undated
assertions to four dated, cited figures, and none of them had to be deleted. An
unsourced number is usually a sourcing failure, not a fabrication — and the
remedy is the source.

### Two-state guides — drafted 2026-08-25, and an outdated statute found

Steinberg plan §4's differentiator: content no single-state firm can write. Two
guides seeded as **drafts** (posts 5352, 5353) in `/resources/`, awaiting attorney
review. Notes for that review in `research/guides/REVIEW-NOTES.md`.

* **Comparative negligence: the 50% and 51% bars.** The lead fact is the whole
  argument for two-state content — *a driver found exactly 50% at fault recovers
  nothing in Georgia and half their damages in South Carolina.* Covers the bars,
  apportionment, and what each state lets a jury hear about a seat belt.
* **Filing deadlines.** Two years in Georgia against three in South Carolina,
  plus the deadlines that run shorter than the headline — workers' compensation at
  one year in Georgia, South Carolina government claims at two.

**Every legal statement traces to a verified source** — the SB 68 brief's
allowlist, or one of the site's existing verified pages (5223, 4810, 4811).
Nothing from a secondary summary, because that brief records that *every*
secondary source reviewed for it got at least one thing wrong. 24 statements,
each traced individually.

#### The find: two pages stated Georgia law as it was before April 2025

While assembling the fact base, `/blog/kemira-plant-drive-savannah-fatal-truck-accident-lawyer/`
and its Spanish twin were asserting that failure to wear a seat belt **is not
admissible** in Georgia and cannot reduce a family's recovery.

That was true until SB 68 revised O.C.G.A. § 40-8-76.1(d) on **21 April 2025**.
It has been wrong for sixteen months — on a fatal-crash page, telling bereaved
families that a defence is unavailable when it is now available. Both pages
corrected; all four pages citing § 40-8-76.1 now state current law.

This is worse than an unsourced statistic, and it was found by accident while
gathering facts for something else. **The site needs a standing check that
recent statutory changes have propagated** — the seat-belt reversal reached the
two dedicated pages and missed the blog posts that mention it in passing, which
is the shared-template drift pattern in a different costume.

#### Also flagged, not fixed

`/resources/south-carolina-comparative-negligence/` and a blog page state
**S.C. Code § 15-38-15 two different ways** — "50% or more" versus "more than
50%". Those differ at exactly 50%, the same one-point distinction the guide
exists to explain, so the guide describes the rule **without asserting the
threshold** pending resolution against the statute.

### SB 68 propagation audit — 2026-08-25

Written because one statutory change was found unpropagated for sixteen months,
by accident. This checks the other seven. **One real failure, already fixed;
everything else clean.** Full method and per-section table in
`docs/sb68-propagation-audit-2026-08-25.md`.

**Five of SB 68's eight sections appear on zero pages** — anchoring, pleading
timing, dismissal, attorney's fees, bifurcation, negligent security. All
procedural. The site is client-facing, never stated those rules, and cannot have
got them wrong.

**The one substantive change that reaches a client's case — whether a jury hears
about their seat belt — is exactly the one that failed to propagate.** Worth
naming: the sections most likely to appear on the site are the sections most
likely to go stale, so a "which sections do we even mention" pass is the cheap
first move on any future amendment.

**§ 51-12-33 — 283 pages, all clean.** SB 68 did not amend the 50% bar, and the
source brief records that claiming it did is the commonest error in circulation.
No page makes it. The one flag was a false positive: the SOL page correctly says
*"SB 68 altered no deadline"*, caught by a regex hunting the assertion rather
than its negation.

**§ 51-12-5.1 — verified, and the site is right.** The brief left punitive damages
unverified while 54 pages cite the section, so it was checked against the
statutory text: (g) caps tort punitive damages at $250,000; (f) removes the limit
for specific intent or impairment **against an active tort-feasor**; (e) removes
it for product liability. SB 68 amended none of them. Of 61 sentences, 59 state it
accurately. Two omit the active-tort-feasor limit, but both concern the impaired
driver — who is the active tort-feasor — so both are correct as written. Flagged
as imprecise where a second defendant exists, not changed.

**What is still missing:** nothing on this site systematically tracks whether a
statutory change has reached the pages stating the old rule. The cheapest standing
version is to sweep every page citing an amended section, not just the page about
it. That is precisely how the seat-belt reversal survived sixteen months.

### Batch (f) — the duplicated case-result URLs

156 case results are published twice: as `case_result` at `/case-results/{slug}/`
(sitemap-listed, canonical) and as the legacy hyphen-slug `case-result` CPT at
`/blog/case-result/{slug}/`. **129 share a slug**, both return 200, and the
legacy URL *self-canonicalises* — so Google sees 129 independent duplicate pairs.

Matched by pattern, not a hardcoded list, and the redirect fires **only where a
published `case_result` with that slug exists**. Zero inbound internal links.

**The 27 legacy-only slugs are deliberately left serving their own content.**
My earlier plan amendment assumed they were leftovers and said to sweep them into
`/case-results/`. That assumption was wrong: they are unique posts, not orphan
URLs, and case results are guardrail-protected under plan §2. The legacy CPT is
therefore *not* neutralised yet — doing so would remove their front-end URL as a
side effect.

What they actually are, measured rather than assumed:

- 57–174 bytes of `post_content` each — a sentence or two
- raw `<br>` markup in every title (`$27,000,000 Settlement | Truck <br> Accident`)
- one slug is literally `2969`; one title reads `$750,00` (a digit short);
  one has slug `100000-recovery-animal-attack` against a `$130,000` title
- top value $27,000,000 — **already present in the canonical CPT**, whose range
  ($27M, $10.86M, $9.8M, $3.35M…) dwarfs the legacy-only set's second-place $950k
- **zero** legacy-only values exceed the canonical CPT's maximum

So they carry no credential the site does not already publish, and every one is
malformed. Recommendation is to retire them to `/case-results/` and then
neutralise the CPT — but that is a call on guardrail-protected content, so it is
recorded here rather than taken silently.

### Batch (a) — the 88 neighbourhood and subdivision pages

Rule 3: every location page below city level. 19 at tier 3 (districts of an
office city — West Ashley, Downtown Charleston, Park Circle, Midtown Savannah…)
and 69 at tier 4 (subdivisions — Old Village, Godley Station, Liberty Hall
Plantation…). 209–342 unique words. This is the layer the audit named as the
primary doorway liability.

**Redirect targets are the tier-2 city hub, not the immediate parent.** Several
of these sit under a tier-3 municipality (Mount Pleasant, Goose Creek,
Summerville) that is still EVALUATE. Pointing at one would risk a 301 chain if
it is later removed; the office-city hub above it is a guaranteed keep, so every
target is chain-proof by construction.

**These were not orphans.** 23 blog posts carried 53 contextual editorial links
into them — the first batch where the plan's "strip internal links" step had
real work. `bin/relink-batch-a-locations.php` repoints the href at the parent
city hub and leaves the anchor text alone, so "West Ashley" still reads as a
link and simply resolves to Charleston rather than being unwrapped.

That script writes `post_content` as a direct column update rather than through
`wp_update_post()`, deliberately. `wp_update_post()` stamps `post_modified`, and
`single.php` renders an "Updated <date>" line from it with schema `dateModified`
and `og:article:modified_time` alongside — so repointing a hyperlink would have
advertised 23 legal blog posts as freshly updated. On a site being re-rated for
quality that is the wrong signal. Verified: all 34 candidate `post_modified`
values identical before and after.

| Step | Status |
|---|---|
| Relink 53 links across 23 posts | **Applied.** 0 inbound refs remain; anchor text preserved; `post_modified` byte-identical before and after |
| 88 redirects | **Live.** 88/88 single-hop, verified before and after deletion |
| Trash 88 posts | **Applied.** 88/88; location sitemap 211 → 123 |

### Batch (d) — the 34 non-office city×practice pages

Rule 7: city×practice in a market with no office, 301 to the statewide practice
page. All English, 195–354 unique words (median 251) against a median of 843 for
the office-city pages that are kept.

17 towns: Summerville (5), Goose Creek (4), Spartanburg (4), Conway (3), Rock
Hill (3), Moncks Corner (2), Mount Pleasant (2), Orangeburg (2), and one each for
Blythewood, Fort Mill, Greer, Hilton Head, Irmo, North Myrtle Beach, Pawleys
Island, Simpsonville, Sumter.

**Internal links need no stripping.** `roden_intersection_grid()` queries for
each intersection post and links to the pillar when it is absent, so trashing
these makes every "Cases We Handle" grid fall back on its own. Verified against
the function rather than assumed, and confirmed by a DB sweep: zero inbound
references in post content or post meta.

Applied 2026-08-21. The self-healing claim was verified on the live site, not
just against the function: Summerville's location page now renders 24 statewide
pillar links and zero links to removed pages, and a DB sweep finds no published
post linking to any trashed city×practice URL.

Batch (b) confirmed the ordering works: after its 8 posts were trashed the URLs
still returned single-hop 301s rather than 404s, because the redirect map is
keyed on path and never consulted the post.

**Note on the office-city pages that stay:** the thinnest sits at 280 words.
Rule 6 flags those for a Phase 2 rewrite, not deletion.

### Batch (b) — the eight non-office SC town pages

Hilton Head (5331), Orangeburg (5332), Sumter (5333), Spartanburg (5334),
Rock Hill (5335), Fort Mill (5336), Greer (5337), Simpsonville (5338).

Published 2026-08-20, 270–322 unique words each against a median of 843 for
the office-city pages, no office in any of these markets, and **zero inbound
internal links** in post content, post meta or the
nav menus — orphans from creation. All eight 301 to
`/locations/south-carolina/`.

**Ordering is not optional.** The 301s must be live before the CMS entries go,
or the eight URLs 404 in the gap and the plan forbids 404s. The redirects are
path-keyed (`roden_phase1_removed_urls()`), so they fire whether or not the post
still exists:

1. Merge the PR → deploy. **This alone completes the SEO removal** — the pages
   stop being indexable the moment the redirect is live.
2. `ssh $H "wp --path=$P eval-file - apply" < bin/remove-sc-town-locations.php > backup-8-towns.json`
   → trashes the entries so the pages cannot regenerate. Reversible with
   `wp post untrash <ID>`; the JSON backup carries full content and meta.
3. Flush both cache layers, then verify the eight 301s resolve single-hop.

The service-area data behind these towns stays in `$firm['service_areas']` — it
feeds the city×practice pages, which are a separate decision (see below).

**Left standing deliberately:** the 14 practice-area pages for these same towns
(`/car-accident-lawyers/rock-hill-sc/` and siblings, 80–103 unique words each).
They classify REMOVE under rule 7 and are batch (d), not batch (b). Removing the
location pages without them leaves the same doorway pattern live at the
city×practice tier.

## Shipped outside the batch sequence

| Date | Change | Ref |
|---|---|---|
| 2026-08-21 | Phase 0.4 — 301 tracking-parameter URLs to their clean path; campaign tag parked in a cookie so intake attribution survives the redirect | `inc/legacy-redirects.php`, `inc/intake-webhook.php` |
| 2026-08-21 | Phase 1 batch (b) — the 8 non-office town pages 301 to the state hub. **Verified live: all 8 single-hop.** | `inc/legacy-redirects.php` |
| 2026-08-21 | Phase 0.4 retargeted `utm_*` → `ref` after the first version shipped and was verified **inert** — WP Engine strips `utm_*` before PHP. See the amendment in plan §3 item 4. | `inc/legacy-redirects.php`, `inc/intake-webhook.php` |

## KPI snapshot — GSC, 2026-08-24

First snapshot against real search-console data rather than Semrush estimates.
Source `docs/gsc-2026-08-24/Chart.csv`, 2025-07-23 → 2026-08-22.

| Month | Clicks | Impressions |
|---|---:|---:|
| 2025-08 | 3,673 | 1,346,853 |
| 2025-09 | 2,979 | 747,007 |
| 2025-10 | 2,440 | 514,344 |
| 2025-11 | 2,243 | 569,427 |
| 2025-12 | 1,944 | 525,767 |
| 2026-01 | 1,181 | 369,211 |
| 2026-02 | 1,045 | 335,540 |
| 2026-03 | 1,022 | 413,172 |
| 2026-04 | 1,668 | 690,740 |
| 2026-05 | 1,978 | 938,993 |
| 2026-06 | 1,458 | 634,891 |
| 2026-07 | 1,191 | 455,824 |
| 2026-08 *(to 8/22)* | 825 | 314,247 |

The shape matches the Semrush trajectory in plan §1 and adds detail it could not
see: the Dec 2025 core steps clicks down through January, March–May 2026 recovers
to roughly half the prior peak, and the May 2026 core reverses it again. **August
is tracking to ~1,150 — the lowest full month in the window.**

Note this is measured *during* the Aug 2026 spam update and *before* any of the
cull has had time to be re-crawled at scale. Per plan §6.2 it is a baseline, not a
verdict. **Judge nothing until the next core update completes.**

Positions 1–3 stays the success metric (baseline 68, Semrush Jul 2026); GSC
average position is not the same measurement and the two must not be conflated.

## Update boundaries to measure against

| Update | Window |
|---|---|
| Aug 2026 spam | began 8/18 — rolling at audit time |
| *(next core)* | *the verdict this plan exists to change* |
