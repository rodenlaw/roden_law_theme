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

### The 13 EVALUATE location pages — decided 2026-09-18

The last rows the triage held under rule 4. They survived #68 because each had at
least one click in the 13-month baseline, which was the whole test at the time. A
fresh Search Console API pull on 2026-09-18 (`docs/gsc-2026-09-18/`, 16 months to
2026-09-15 plus the post-cull window from 2026-08-26) settles them:

| Window | Clicks | Impressions |
|---|---:|---:|
| Baseline, 13 months to 2026-08-22 | 19 | 8,303 |
| 16 months to 2026-09-15 | 19 | 9,515 |
| Since the cull, 2026-08-26 on | **0** | 1,069 |

Three more months add no clicks. At positions 5–10 the 13 converted 11 of 5,089
impressions where the site's own rate predicts 24 — weaker than the site, not the
flat zero that condemned the 66, but rule 4 asks for "real rankings, traffic or
genuine service history" and only the first is present. Murrells Inlet is where the
Myrtle Beach GBP is registered, which is an address question, not a page one.
Every one of the 13 is an unincorporated place (CDP, barrier island, naval base),
so the site-health granularity floor flags all of them and none can be rescued by
adding it to the municipality list.

Same mechanics as #68: paths in `roden_evaluate_location_urls()`, both scripts read
from it, the removal script reports link debt on a dry run and refuses to apply
while any remains. One new guard: it also refuses to trash a page that still has a
published child, because `location` is hierarchical and the tier-4 children of
these were retired in batch (a) — the guard proves that rather than assuming it.

Targets are the parent office-city hub, verified 200 on 2026-09-18. Expected after:
location URLs 57 → 44, indexable 1,230 → 1,217. **Doorway ratio as site-health
measures it: 40.6% → 39.9%.** This closes the rule-4 backlog and the location half
of the granularity floor; it does not move the ratio materially, because that
ratio is now carried by the blog (193 location-targeted posts) and the office-city
intersections (177), neither of which Phase 1 governs.

### Applied 2026-09-18 — the 13 EVALUATE location pages

Shipped end to end the same day: redirects deployed in #141, relink applied, posts
trashed, caches flushed, verified after deletion.

| | Removed | Relinked | Verified |
|---|---:|---|---|
| EVALUATE locations | 13 locations | 11 links / 5 posts (all Ladson) | 13/13 single-hop 301 → 200 |

Sitemaps: location **57 → 44**, indexable **1,230 → 1,217**. `post_modified` untouched
on all five relinked posts. The child-page guard found nothing to refuse, which
confirms batch (a) had already cleared the tier-4 layer under these. Live JSON-LD
guard PASS after the relink's direct column write. `content/meta.json` regenerated:
the 13 location entries gone, nothing else changed.

**Doorway ratio as site-health measures it: 40.6% → 39.9%** (486 of 1,217), and the
granularity floor 156 → 143. The location post type no longer carries a floor
violation. What remains is the blog (116 sub-municipal posts EN + ES) and the
truck-corridor resources (26), which is a content-strategy decision, not a rule-4 one.

### The zero-click intersections and the zero-click sub-municipal posts — decided 2026-09-18

Two owner decisions, both taken on the same Search Console API evidence
(`docs/gsc-evidence-2026-09-18.md`, 16 months to 2026-09-15).

**Rule 6 reopened.** The 2026-08-25 entry above called the 175 office-city intersections
"the defensible tier under rule 6". Measured, the tier fails the #68 test at ten times the
scale: **798,103 impressions, 98 clicks, 0.01% CTR in every position band** against the
site's 0.12–0.47%, where the site's own rates predict about 1,800 clicks. 129 of the 177
have zero clicks on 232,293 impressions. Those 129 go, 301 to the practice pillar as batch
(d) did. The 48 that earned a click (98 between them) are held for a separate decision.

**The blog protection stands, and the rule-4 test is applied inside it.** The sub-floor
posts earn 881 clicks as a set and the top of it is genuine; none of those move. 60 posts
have zero clicks in 16 months on 6,526 impressions — 36 English, 24 Spanish twins, mostly
the pipeline's street-plus-subdivision output from July and August. Those go, 301 to the
practice pillar the slug names, per rule 5. Same shape as the corridor fold on 2026-08-24:
keep the performers, fold the dead.

Mechanics: paths in `roden_zero_click_intersection_urls()` and
`roden_zero_click_blog_urls()`, both scripts read from them. The relink script also
rewrites the NESTED intersection form (`/practice-areas/{practice}/{city}/`) and skips
posts the batch is itself retiring; the removal script counts link debt only from posts
outside the batch. Pre-flight on 2026-09-18: 244 body links across 120 outside-batch posts,
zero nested-form hits, zero `_roden_see_also` references, zero published children.
All 33 pillar targets verified 200. Three of the 189 postdate the 2026-08-21 triage
inventory (`personal-injury-lawyers/savannah-ga`, the EN and ES `wando-gardens-…` posts)
and have no triage row; the other 186 are flipped KEEP → REMOVE with the evidence.

Expected after: indexable 1,217 → 1,028, location-targeted 486 → 297. **Doorway ratio
39.9% → 28.9%.** Practice-area sitemap 404 → 275; post sitemap 452 → 392.

### Applied 2026-09-18 — the zero-click intersections and posts

Shipped end to end the same day: redirects deployed in #142, relink applied, posts
trashed, caches flushed, verified after deletion.

| | Removed | Relinked | Verified |
|---|---:|---|---|
| Zero-click intersections | 129 practice_area (93 EN, 36 ES) | 263 links / 120 posts, with the 60 posts | 189/189 flat + 93/93 EN nested, single-hop 301 → 200 |
| Zero-click sub-municipal posts | 60 posts (36 EN, 24 ES) | | |

Sitemaps: practice_area **405 → 276**, post **486 → 426**, indexable **1,217 → 1,028**.
`post_modified` untouched on the relinked posts. Zero retired URLs linked from any rendered
hub, pillar or index page (17 templates swept). Live JSON-LD guard PASS after the direct
column writes. `content/meta.json` regenerated: `_count` 1,054 → 865, plus a handful of
Spanish posts whose meta had changed on prod since the last regen (drift the deploy warns
about, unrelated to this batch).

**Doorway ratio as site-health measures it: 39.9% → 28.9%** (297 of 1,028); granularity
floor 143 → 83. What remains location-targeted: the 83 sub-municipal posts and
resources that earn clicks (guardrail keep, and the data agrees), the 48 intersections
that earned a click (98 between them), the 44 location hubs, and the 6 legacy root city
pages. Reaching 25% from here is either the 48 + 6 (24.9%) or about 160 non-location pages.

**One defect surfaced, fixed in the script before apply.** The removal script's link-debt
check was a substring LIKE, and an English intersection path is a suffix of its Spanish
twin's (`/workers-compensation-lawyers/columbia-sc/` sits inside
`/es/workers-compensation-lawyers/columbia-sc/`). The dry run reported one phantom link
from a Spanish state page to a Spanish intersection that stays live. The check now counts
only a real href (path preceded by a quote or the host), the same forms the relink script
rewrites, so the two cannot disagree. Carry forward: **any path check on this bilingual
site must anchor the start of the path.**

### The last 47 intersections — decided 2026-09-19

Rule 6 closed. The 47 office-city intersections that survived #142 because they had
earned a click were measured on the same window: **95 clicks on 564,905 impressions,
CTR 0.017%**, 28 of them with exactly one click. The tier fails the #68 test as a whole.
They go, 301 to the practice pillar; with them the city × practice layer is gone entirely.
Evidence: `docs/gsc-evidence-2026-09-18.md`, Finding 3.

**A defect from #142, found by this batch's inventory.** Two Spanish intersections that
#142 did not touch (`/es/car-accident-lawyers/north-charleston-sc/`,
`/es/workers-compensation-lawyers/columbia-sc/`) had become unreachable: the theme builds a
Spanish intersection's permalink from its English twin's, so trashing the English page
renamed the Spanish URL to `…__trashed/` and the real URL 301'd there and on to the pillar.
A full audit of production found exactly the 202 intended posts in the trash and no other
page misrouting (47 published slug-mates checked, 45 fine). Both twins are in this batch,
which makes their redirect single-hop at priority 0 and then retires them. **Carry forward:
never trash an English page whose Spanish twin is meant to stay live; check
`_roden_translation_es` before any practice-area or blog removal.**

Mechanics as #142, with the two renamed permalinks tolerated by ID. Pre-flight 2026-09-19:
293 real hrefs across 231 outside-batch posts, zero see-also references, zero published
children. All 22 pillar targets verified 200. 47 triage rows KEEP → REMOVE.

Expected after: indexable 1,028 → 981, location-targeted 297 → 250. **Doorway ratio
28.9% → 25.5%.**

### Applied 2026-09-19 — the last 47 intersections

Shipped end to end: redirects deployed in #143, relink applied, posts trashed, caches
flushed, verified after deletion.

| | Removed | Relinked | Verified |
|---|---:|---|---|
| The last 47 intersections | 47 practice_area (44 EN, 3 ES) | 317 links / 231 posts | 47/47 flat + 44/44 EN nested, single-hop 301 → 200 |

Sitemaps: practice_area **276 → 229**, indexable **1,028 → 981**. `post_modified` untouched
on the relinked posts. Live JSON-LD guard PASS. `content/meta.json` regenerated,
`_count` 865 → 818. Production trash audited: 47 trashed today, exactly the batch; no
published page shares a slug with any of them, so the #142 twin defect cannot recur here.

**The city × practice layer is gone.** 176 intersections existed on 2026-09-17; 0 remain.
What is left under `/{practice}-lawyers/` is the sub-type pages, which are not
location-targeted.

**Doorway ratio as site-health measures it: 28.9% → 25.5%** (250 of 981); granularity
floor unchanged at 83. The 250 still counted: 83 sub-municipal posts and resources that
earn clicks, 110 blog posts and resources at the municipality level, the 44 location hubs
and their 6 Spanish twins, the 6 legacy root city pages, and one classifier false positive.
Half a point from the ceiling: the 6 root pages take it to 25.0% exactly, and every
non-location page the reference layer adds moves it further.

**Cache note for the verification habit.** The hub and pillar grids self-heal on trash, but
the edge cache in front of the site serves rendered pages for up to 600 seconds. A template
sweep run inside that window shows the retired links still present (52 hits across 8
pages here, 0 on a cache-busted fetch). Sweep after the cache has turned over, or bust it.

### The six root-level city pages — decided 2026-09-19

Greenville, Spartanburg and Florence × car accident / workers' compensation, created
2026-06-30 as pages on the statewide-pillar template alongside the PI landing pages. No
office in any of the three cities; the `/locations/` pages for the same towns went in batch
(b) under rule 4. These sat outside every earlier batch because they are pages at the site
root, not a custom post type. Search Console, 16 months: **one click between the six, on
2,322 impressions.**

The open question was paid traffic. Checked 2026-09-19 across all four Roden Law ad
accounts (two search, two Local Services): 540 non-removed ads' final URLs, sitelink and
promotion assets, page-feed assets, the one Performance Max campaign (paused), campaign
tracking templates, and every landing page with paid clicks between 2026-06-21 and
2026-09-18. **Zero references.** Paid traffic lands on the statewide
`/south-carolina-car-accident-lawyer` page (1,273 clicks in 90 days) and the Columbia
hub (576), neither of which any batch has touched.

Pre-flight on prod: zero inbound links, zero see-also references, zero children, zero nav
menu items, no Spanish twins, no hard-coded references in the theme or on the statewide
page. Target is the practice pillar. Expected after: indexable 981 → 975, location-
targeted 250 → 244, **doorway ratio 25.5% → 25.0%.**

### Applied 2026-09-19 — the six root city pages

Shipped end to end: redirects deployed in #144, relink run and confirmed a no-op, six pages
trashed, caches flushed, 6/6 verified single-hop 301 → 200. Page sitemap **46 → 40**,
indexable **981 → 975**. `content/meta.json` regenerated, `_count` 818 → 812. Trash
audited: 53 today, exactly the 47 + 6; no published page shares a slug with any of them.

**Doorway ratio as site-health measures it: 25.5% → 25.0%** — 244 of 975, which is
25.03% unrounded. The check compares the unrounded figure to the ceiling, so it still
reports FAIL by three hundredths of a point. What decides it now is the one classifier
false positive: `/boating-accident-lawyers/dock-marina-injury/`, a practice sub-type page
counted as a landmark doorway on the token `dock-marina`. Without it the figure is 243 of
975, 24.9%, and the check passes. The fix is one line in the toolkit's generic-preceder
list, followed by a re-vendor; it is not a content change and nothing on the site should
move for it. Failing that, the first non-location page the reference layer publishes
flips the check on its own.

**Where the week landed.** 2026-09-17: 499 of 1,230, 40.6%. 2026-09-19: 244 of 975,
25.0%. Five batches, 255 pages retired, every one on Search Console evidence, all with
single-hop 301s verified after deletion, every trashed post recoverable by ID. The 244
still counted are the 44 location hubs and their 6 Spanish twins, the 193 blog posts and
resources with a place in the slug that earn clicks, and the one false positive.

### The two-state guides — record corrected and review closed, 2026-09-19

The content director, planning a third reference-layer page, found that the two two-state
guides (`/resources/georgia-vs-south-carolina-comparative-negligence/`, post 5352, and
`/resources/georgia-vs-south-carolina-filing-deadlines/`, post 5353) were **published on
2026-08-25 at 21:41, the day they were drafted** — not held as drafts, as the October plays
file and the Q4 strategy both said when written on 2026-09-10. Their `_roden_last_reviewed`
carried 2026-08-25, the publish minute: a seeder self-stamp, not an attorney's read, on
pages whose template publishes `lastReviewed` and `reviewedBy` in schema.

The owner confirmed on 2026-09-19 that the attorney review is complete. `_roden_last_reviewed`
is now 2026-09-19 on both posts, caches flushed. The plays file (`referenceLayer` reason and
notes, `spanish` reason, evidence E14, and the blocking waits-on item) and the strategy
(lane table, open items, "what would change this") are corrected to match, each with a note
saying what they originally said. `validate-plays.mjs` passes.

Two things stand. The guides carry a single attorney author (Eric Roden) where the
citability standard asks for a GA + SC co-byline; that is an attribution decision for the
firm, not corrected here. And the lesson for the seeders: **a script that publishes must not
also write `_roden_last_reviewed`** — the meta-box copy already says "leave blank if no
review has happened", and the field is what licenses the schema review claim.

### The helmet claim class, and the fifth surface — 2026-09-19

The two helmet-law drafts read the 20 pages carrying helmet claims and found a false
statement of law on the motorcycle pillar: "Georgia does not require helmets for riders over
18." § 40-6-315 is universal, and the same page's FAQ and negligence intro said so. A sweep of
the four known surfaces reported the pillar clean. The sentence was in
`_roden_common_injuries` — a serialized pillar section none of the sweeps, and not the
content-meta export, had ever read. A sweep of every post-meta key found 22 helmet rows across
four such fields. Fourth time a claim has survived on a surface the sweep did not read.

Nine edits across five posts (`bin/fix-helmet-claims.php`, backup
`docs/backups/helmet-claims-2026-09-19.json`, record
`data/facts/remediation-2026-09-19-helmet.md`): the false statement corrected; two
unqualified "no statewide helmet law" sentences on the bicycle pillar qualified to bicycles;
an unsourced municipal-helmet claim removed from three surfaces of the e-scooter pillar; a
flat "can be used as evidence of comparative fault" reframed as the insurer's argument on
two surfaces of a blog post; one age threshold made exact. Verified live, zero survivals
across all bodies and all meta, JSON-LD guard PASS. `bin/export-content-meta.php` now exports
`_roden_common_injuries`, `_roden_common_causes`, `_roden_why_hire` and
`_roden_pillar_negligence_intro`. The Georgia items that could not be traced (bicycle
under-16, e-bike classes) are flagged for the attorneys, not changed.

**Carry forward: sweep every meta key, not the list you know.** Start from the postmeta
table and the search term, not from the field names.

*Later the same day:* the Georgia bicycle and e-bike helmet statutes were traced on
codes.findlaw.com (Justia and LegiScan 403). Six sections joined the Verified table
(`docs/statute-verification-tracker.md`, "2026-09-19 helmet pass"): every uncited Georgia
statement on the live pages matched the text, so nothing more was corrected. The pass did
surface something the site had never said: `§ 40-6-296(d)(5)` and `§ 40-6-303(c)(5)` bar
treating a bicycle or e-bike helmet violation as evidence of negligence, while the
motorcycle statute is silent. The Georgia draft now states both; its remaining open tags are
mopeds, scooters, ATVs and golf carts.

### The two helmet pages published — 2026-09-19

Owner considered both drafts reviewed and asked for publication. Before anything moved:
every `[VERIFY — attorney]` tag was resolved in the drafts — the Georgia moped, scooter, ATV
and golf-cart rows, which no one had traced, were **cut** rather than published untraced; the
South Carolina claims, all traced to scstatehouse.gov by the writer, kept their citations
and lost their markers; the motorcycle admissibility question stays framed as a question for
the rider's attorney. Ten South Carolina sections joined the Verified table with the owner's
sign-off. "Last reviewed" set to 2026-09-19 on both, by the owner's word this time rather
than by a seeder stamp.

Published through `bin/en-seed-resource-page.php` (payloads in `research/guides/seed-*-helmet-laws.json`,
converter `bin/build-helmet-seeds.py`): **post 6312 `/resources/georgia-helmet-laws/`** (Eric
Roden, `georgia-only`) and **post 6313 `/resources/south-carolina-helmet-laws/`** (Graeham C.
Gillin, `south-carolina-only`). Every seeder guard passed on dry run: attorney ID resolves to
the named attorney, takeaways and FAQs in meta not body, and the jurisdiction gate — the
Georgia page carries no `S.C. Code §` and the South Carolina page no `O.C.G.A. §`. Verified
live: both 200, FAQPage schema present, `lastReviewed` 2026-09-19 in schema, cross-links
resolve both ways, zero tag leaks, both in the resource sitemap. Live JSON-LD guard PASS.
`content/meta.json` regenerated, `_count` 812 → 814.

**Doorway ratio as site-health measures it: 25.0% → 24.97%** (244 of 977). Under the
ceiling; the check passes. From 40.6% on 2026-09-17.

### The classifier false positive — fixed at the source, 2026-09-19

`/boating-accident-lawyers/dock-marina-injury/`, a practice sub-type, had counted as a
landmark doorway since the first audit because `dock` was not in the classifier's
generic-preceder list. Fixed in the toolkit (`internal-ai-scripts` #53, one word) and
re-vendored here; `vendor.mjs roden --check` passes. Controls: `boat-dock-accident` also
clears, while `ripley-light-marina-…`, `i-26-truck-accidents-columbia` and the
`wando-gardens-faber-place-drive-…` slug still classify as places. The re-vendor also
carried three files the toolkit had moved ahead on since the last vendor (#48: cull-key
matching in `internal-links`, chain detection in `redirects`, location prefixes in
`site-urls`), all static-mode paths this WordPress client does not exercise.

**Doorway ratio: 24.97% → 24.87%** (243 of 977); granularity floor 83 → 82. Both numbers
now describe content only.

### Golf-cart law: a repealed statute cited as current on four pages — 2026-09-19

Verifying the next reference-layer topic (SC golf-cart law, the plan's strongest B3 gap by
demand) found that `S.C. Code § 56-2-105`, which four live pages cited as current law, was
**repealed 2025-05-22** by 2025 Act No. 64 §2 and replaced by `§ 56-2-90`. Sixteen months.
Two more pages cited `§ 56-2-100` (low-speed vehicles) and `§ 56-3-115` (today a hearing-loss
registration notation) for golf-cart eligibility; two sub-type pages said South Carolina has
no statewide golf-cart statute; the Charleston island-communities post said golf-cart
liability insurance is not required (the permit requires proof of it); the Daniel Island post
put the operator age at 15 (it is 16). Verification: `docs/statute-verification-tracker.md`
"2026-09-19 golf-cart pass"; record: `data/facts/golf-cart-verification-2026-09-19.md`.

Fixed the same day on the owner's word: 15 edits across 9 surfaces on 7 posts
(`bin/fix-golf-cart-claims.php`, backup `docs/backups/golf-cart-claims-2026-09-19.json`),
cumulative per surface, verified live, zero survivals across all bodies and all meta,
JSON-LD guard PASS. No page retired.

**Two lessons.** A verified section can stop existing — the method now re-reads each
section's HISTORY line on every pass (tracker watch items). And the two old-site URLs
`/blog/south-carolina-golf-cart-laws/` and `/blog/myrtle-beach-golf-cart-laws/` earned 194
clicks over 16 months and 301 to the accident pillar, which does not state the law: the
reference page `/resources/south-carolina-golf-cart-laws/` should take those redirects when
it publishes.

### DUI citations closed — 2026-09-21

The last open item from the 19th. Both DUI sections were unreadable then; both read today.
`O.C.G.A. § 40-6-391(a)` reaches "any moving vehicle", so it applies to mopeds, golf carts and
e-bikes without a definitional chain. `S.C. Code § 56-5-2930(A)` reaches "a motor vehicle";
a moped is one by definition (`§ 56-1-10(26)`) and a golf cart is one because it is
self-propelled (`§ 56-1-10(7)`), and the chapter's own interlock carve-out for "a moped or
motorcycle" confirms the reading. Seven edits across four pages — the two moped pages, the
golf-cart page and the golf-cart DUI sub-type — verified live, JSON-LD guard PASS.

The method note matters more than the citations: **the state's chapter pages are readable by a
direct download even when the fetch tool truncates them.** Two of Friday's "unreadable"
sections were readable all along.

### E-bike classification made precise — 2026-09-21

The item the Georgia moped writer flagged on the 19th. The e-bike pillar made speed the trigger
for an e-bike becoming a moped and offered "a moped or motor vehicle" as alternatives. The
statutes hinge on motor power — 750 W either side of the line; Georgia's moped at 2 bhp, 30 mph
and automatic drive (`§ 40-1-1(28)`), South Carolina's at 750–1,500 W (`§ 56-1-10(26)`) — and a
Georgia moped is a motor vehicle (`§ 40-1-1(33)`, read for this pass with `(29)`). Imprecise
rather than false, on the one page that is the firm's statement of the rule. Five edits on
three surfaces (`bin/fix-ebike-classification.php`), verified live, JSON-LD guard PASS. Record
in `data/facts/moped-verification-2026-09-19.md`.

### The two moped-law pages published — 2026-09-19

The last B3 gap. Owner asked for the full cycle ("do that moped law now"). Eighteen sections
verified in a day (`docs/statute-verification-tracker.md`, "2026-09-19 moped pass"): the Georgia
sections on codes.findlaw.com; the South Carolina moped article verbatim on scstatehouse.gov;
the licence sections first from the enrolled text of 2017 Act No. 89, then verbatim from the
chapter page by a direct download — the fetch tool truncates that 383 KB page, `curl` does not,
which is the method note to carry forward. The one section no primary source reachable today
would yield was South Carolina's DUI statute, so neither page cites it. Record:
`data/facts/moped-verification-2026-09-19.md`.

Only three live pages mention mopeds. One error: the e-bike pillar said an over-threshold
e-bike becomes a moped "requiring title, registration, and insurance"; `§ 56-2-3010` says
mopeds are registered but "not required to be titled or insured". Fixed on three surfaces
before the pages were written (`bin/fix-moped-claims.php`).

Published, one page per state as the helmet pages were: **post 6315
`/resources/georgia-moped-laws/`** (Eric Roden — every rider and passenger helmeted, 15 with
any licence class, exempt from registration, insurance not addressed and not asserted) and
**post 6316 `/resources/south-carolina-moped-laws/`** (Graeham C. Gillin — licence or moped
licence at 15, under-16 daylight rule, registered but not titled or insured, under-21 helmet,
right lane, 35 mph cap, off highways posted above 55). Seeder guards passed; live, FAQPage
schema, `lastReviewed` 2026-09-19 on the owner's word, cross-links both ways, no divergence
from the e-bike pillar or the helmet pages. **Doorway ratio 24.85% → 24.80%** (243 of 980).

**The reference layer, end of 2026-09-19:** five statewide pages published this day — GA and
SC helmet law, SC golf-cart law, GA and SC moped law — every one on statutes verified against
primary text the same day, with 24 live-page corrections found along the way, four of them
false statements of law. The B3 list in `KNOWLEDGE-BASE-PLAN-rodenlaw.md` is now clear.

### The golf-cart reference page published — 2026-09-19

`/resources/south-carolina-golf-cart-laws/` (post 6314), Graeham C. Gillin, `south-carolina-only`,
built on `§ 56-2-90` with the 2025 change explained and the low-speed-vehicle distinction under
`§ 56-2-100`, `§ 56-1-10` and `§ 56-2-120`. Published the same day it was commissioned, on
the owner's word ("run both now"), through `bin/en-seed-resource-page.php` with the payload
from `bin/build-resource-seed.py` (the helmet converter, generalised to take the page's details
as arguments). Every seeder guard passed; live 200, FAQPage schema, `lastReviewed` 2026-09-19,
no Georgia citation. The two old-site law URLs that had earned 194 clicks while landing on the
accident pillar now 301 to it (#145). **Doorway ratio 24.87% → 24.85%** (243 of 978).

**The writer found three more live errors** while reading the eight pages that state the
rule — none of which the morning's pass, which searched for the repealed section and three
known phrasings, had reached: the pillar FAQ said neither state requires golf-cart seat belts
(`§ 56-2-90(E)` has required them for passengers under 12 since 2025-05-22, and the FAQ
publishes as structured data); the Charleston island post said a cart modified past 20 mph
"may have effectively created an unregistered, uninsured LSV" (`§ 56-2-120(A)` says the State
issues no VIN to retrofitted golf carts and they do not qualify), and its golf-cart-vs-LSV
table said registration and insurance are not required (both are, `§ 56-2-90(A)`); the Surfside
post attributed the town's road permission to the state statute. Fixed before the page
published (`bin/fix-golf-cart-claims-2.php`, 5 edits, 4 surfaces, 3 posts), verified live,
JSON-LD guard PASS.

**Lesson.** A claim-class sweep that searches for known wrong phrasings finds the phrasings it
knows. Having a writer read the neighbouring pages against the verified statute, sentence by
sentence, is a different instrument and found what the search did not. Commission the
reference page and the neighbour read together.

### Helmet citations backfilled — 2026-09-19

With the Georgia sections on the Verified table, the bicycle pillar, the e-bike pillar and the
Georgia bike-safety post got the citations their correct-but-uncited statements lacked:
`§ 40-6-296(d)` for the under-16 bicycle rule, `§ 40-6-303(b)–(c)` for Class III, `§ 40-6-301`
for why the bicycle rule reaches Class I and II, and `S.C. Code § 56-5-3520` for the South
Carolina e-bike statement. Twelve edits, seven surfaces, three posts, no claim changed
(`bin/backfill-helmet-citations.php`, `data/facts/remediation-2026-09-19-helmet.md`). One
script lesson: several edits on the same surface must accumulate on one working copy and write
once; computing each from the original and writing in turn lets the last erase the rest.

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
| 2026-09-18 | **EVALUATE** the 13 rule-4 survivors | 1,230 | 1,217 | 13 | **COMPLETE.** Redirects deployed (#141), relink applied (11 links, 5 posts, all to Ladson, `post_modified` preserved), 13 posts trashed, caches flushed. Verified after deletion: 13/13 single-hop 301 → 200; location sitemap 57 → 44; live JSON-LD guard PASS. Backups: `evaluate-locations-relink-2026-09-18.json`, `evaluate-locations-2026-09-18.json`. |
| 2026-09-18 | **Zero-click** intersections (129) + sub-municipal posts (60) | 1,217 | 1,028 | 189 | **COMPLETE.** Redirects deployed (#142), relink applied (263 links, 120 posts, `post_modified` preserved), 189 posts trashed, caches flushed. Verified after deletion: 189/189 flat single-hop 301 → 200, 93/93 EN nested forms likewise; the ES nested form never existed (404 on a surviving ES intersection too, zero GSC rows). practice_area sitemap 405 → 276, post 486 → 426. Live JSON-LD guard PASS. Backups: `zero-click-relink-2026-09-18.json`, `zero-click-pages-2026-09-18.json`. |
| 2026-09-19 | **The last 47** intersections (rule 6 closed) | 1,028 | 981 | 47 | **COMPLETE.** Redirects deployed (#143), relink applied (317 links, 231 posts, `post_modified` preserved), 47 posts trashed, caches flushed. Verified after deletion: 47/47 flat and 44/44 EN nested single-hop 301 → 200; the two Spanish twins #142 had broken now redirect in one hop. practice_area sitemap 276 → 229. Live JSON-LD guard PASS. No published page shares a slug with the 47; none misroutes. Backups: `earning-intersections-relink-2026-09-19.json`, `earning-intersections-2026-09-19.json`. |
| 2026-09-19 | **Six root city pages** (Greenville, Spartanburg, Florence) | 981 | 975 | 6 | **COMPLETE.** Redirects deployed (#144), relink a confirmed no-op (0 links), 6 pages trashed, caches flushed. Verified after deletion: 6/6 single-hop 301 → 200; page sitemap 46 → 40. Google Ads clear across all four accounts. Backup: `root-city-pages-2026-09-19.json`. |
| 2026-09-25 | **Case results** folded into one filterable page | 980 | 824 | 156 | **COMPLETE.** Singles 301 to `/case-results/#{slug}` (#146); posts kept as the page's data, none trashed. Verified: 423/427 old URLs (singles, legacy, old-site) single-hop to a live anchor, 4 malformed legacy slugs to the page, 0 failures; `case_result` sitemap removed. Counts are sitemap URLs, not the 08-21 inventory. |
| 2026-09-25 | **Stale place pages**: 29 sub-municipal locations + 46 pipeline posts (Brunswick kept) | 824 | 749 | 75 | **COMPLETE.** Redirects deployed (#147), relink applied (52 links, 22 posts, `post_modified` preserved), 75 pages set to **draft** (not trashed) and marked `_roden_retired`, caches flushed. Verified: 75/75 single-hop 301 → 200 (19 targets); 0 links on 27 swept pages; live JSON-LD guard PASS. Doorway **29.49% → 22.83% PASS**. Backups: `stale-place-relink-2026-09-25.json`, `stale-place-pages-2026-09-25.json`. |
| 2026-09-25 | **Zero-click scenario pages** (64 of 182; step 1 template fix shipped first in #148) | 749 | 685 | 64 | **COMPLETE.** Redirects deployed (#149), 2 legacy redirects repointed off the set, relink applied (85 links, 55 posts, flat + nested), 64 pages drafted and marked `_roden_retired`, 1 meta link unwrapped (truck pillar `_roden_why_hire`), caches flushed. Verified: 128/128 flat + nested single-hop 301 → 200; 0 links left on the 18 pillars; JSON-LD guard PASS. Doorway **22.83% → 24.96% PASS**, with no non-place headroom left. |
| 2026-09-26 | **Dead geo posts** (14; site-architecture step 1, Rule 6 reopened) | 685 | 671 | 14 | **COMPLETE.** Redirects deployed (#159), 12 legacy redirects repointed off the set, Brunswick profile URL → Darien hub, relink applied (1 link, 1 post), 14 posts drafted and marked `_roden_retired`, caches flushed. Verified: 27/27 single-hop 301 → 200; 0 references left in bodies or meta; JSON-LD guard PASS. Doorway **24.96% → 23.40% PASS**, 10 geo slots freed for wave 1. |
| 2026-09-26 | **Spanish office hubs** (Darien, North Charleston) | 671 | 669 | 2 | **COMPLETE.** Redirects deployed (#160) to the English office hubs, relink applied (4 links, 2 posts), 2 hubs drafted and marked `_roden_retired`, template office links fixed (#161), caches flushed. Verified: 2/2 single-hop 301 → 200; 0 references on rendered /es/ pages; JSON-LD guard PASS. Doorway **23.40% → 23.17% PASS**. |
| 2026-09-26 | **Charleston car accident page restored** (first allowlisted office practice page) | 669 | 670 | −1 | **LIVE.** #162 template + allowlist, #163 template claim fixes after a FAILED sweep, pillar intros corrected, published behind the redirect, #164 redirect removed. Verified: 200, self canonical, map, nested + 10 legacy URLs single-hop to it, in sitemap, 72 internal links restored, JSON-LD guard PASS. Doorway **23.17% → 23.28% PASS**. Reviewed by Gillin (owner, 2026-09-26). |
| 2026-09-26 | **Charleston truck accident page restored** (office practice page #2) | 670 | 671 | −1 | **LIVE.** #167 allowlist, truck pillar intros corrected, legal sweep PASS (signed SC pack), warnings fixed (#168 directions), published behind the redirect, #169 redirect removed. Verified: 200, self canonical, map, nested + 2 legacy URLs single-hop, 22 links restored, JSON-LD guard PASS. Doorway **23.28% → 23.40% PASS**. Reviewed by Gillin (owner, 2026-09-26). |
| 2026-09-26 | **Savannah car accident page restored** (office practice page #3, first GA) | 671 | 672 | −1 | **LIVE.** #170 essay + map + allowlist, #171 GA step 5, sweep PASS, warnings fixed (#172), published behind the redirect, #173 redirect removed. Verified: 200, self canonical, map, nested + 7 legacy URLs single-hop, 60 links restored, JSON-LD guard PASS. Doorway **23.40% → 23.51% PASS**. Reviewed by Eric Roden (owner, 2026-09-26). |
| 2026-09-26 | **Savannah truck accident page restored** (office practice page #4) | 672 | 673 | −1 | **LIVE.** Allowlist (#172), truck pillar GA branch corrected (passes 3–4), sweep PASS, W1/W2 fixed, published behind the redirect, #174 redirect removed. Verified: 200, self canonical, map, nested + legacy URL single-hop, 9 links restored, JSON-LD guard PASS. Doorway **23.51% → 23.63% PASS**. Reviewed by Eric Roden (owner, 2026-09-26). |
| 2026-09-26 | **Charleston workers' comp page restored** (office practice page #5, first WC) | 673 | 674 | −1 | **LIVE.** #175 SC WC steps + allowlist, #176 sidebar deadline, WC pillar intros corrected, sweep FAIL fixed (#177 template; internal-ai-scripts #66 three WC authorities signed), published behind the redirect, #178 redirect removed. Verified: 200, self canonical, map, 2-yr sidebar, nested + legacy URL single-hop, 2 links restored, JSON-LD guard PASS. Doorway **23.63% → 23.74% PASS**. Reviewed by Gillin (owner, 2026-09-26). |
| 2026-09-26 | **Savannah workers' comp page restored** (office practice page #6) | 674 | 675 | −1 | **LIVE.** #179 essay + allowlist, WC pillar GA branch, sweep FAIL fixed (#180: full § 34-9-82 deadline on step 5/law box/sidebar; notice 'right away, no later than'), published behind the redirect, #181 redirect removed. Verified: 200, self canonical, map, nested + legacy URL single-hop, 18 links restored, JSON-LD guard PASS. Doorway **23.74% → 23.85% PASS**. Reviewed by Eric Roden incl. §§ 34-9-11, 34-9-17 (owner, 2026-09-26). |

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

### The comparative-negligence guide was nearly an orphan — 2026-08-26

It had **one** inbound link. A brand-new authority page with one inbound link does
not rank, however good it is, and this one is the flagship of the two-state
cluster.

493 published pages mention comparative fault, which is exactly why this needed
judgement rather than a sweep: linking from all of them would be worse than
linking from none. Four were chosen because the guide answers the question their
reader is already asking, plus one resource hub:

| Page | Why |
|---|---|
| `georgia-comparative-negligence-law` (1838) | the closest topical parent on the site; has its own GA-vs-SC comparison table |
| `south-carolina-comparative-fault-partially-at-fault` (4367) | the SC counterpart, with its own GA comparison section |
| `determining-fault-in-multi-vehicle-accidents` (1773) | apportionment among multiple defendants *is* the guide's subject |
| `fault-for-car-accident` (1836) | Georgia-only page where the border case is the obvious next question |
| `south-carolina-personal-injury-faq` (4814) | resource hub — `_roden_see_also`, no body edit |

**1 → 6 inbound.** All five verified rendering live; the target resolves 200 with
zero redirect hops.

Note the split in method, which is a property of the theme rather than a
preference: `roden_see_also_links()` is called only from `single-resource.php` and
`template-subtype.php`, so `_roden_see_also` renders on resources and nowhere
else. Blog posts and practice-area pillars need a body edit. Four of these five
were posts.

The other two guides sit at 3 and 2 inbound and were left alone. The workers'
comp guide's two are the pillar and a sibling guide, which is the structurally
right shape; adding volume for its own sake is what built the doorway problem.

### Act 42 linking applied — 2026-08-26

The firm published 5355 and set `_roden_last_reviewed`, so the linker's guard
opened and the pass ran.

**Nine of ten placed automatically. One was refused and placed by hand**, which is
the behaviour the script was built for rather than a shortfall. `4076
drunk-driver-motorcycle-accident` is a short page whose dram-shop paragraph
genuinely *is* its last block, so the rule that skips the final 15% — there to
avoid landing after "no fee unless we win your case" — excluded it correctly. It
has no closing CTA, so appending there was right, and it was done manually.

Worth noting what 4076 cites: **S.C. Code § 61-4-580**, which Act 42 amended at
subsection (B). The page pointing at the change is citing a section the change
touched.

All ten verified live. The target resolves 200 with zero redirect hops, and the
five practice-area links resolve to their flat canonicals
(`/car-accident-lawyers/drunk-driver-accident/` and siblings) rather than the
nested `/practice-areas/` form that 301s.

The published page renders intact — 12 headings, the comparison table, FAQPage
schema, and `lastReviewed`/`reviewedBy` from the fix in #85. Zero O.C.G.A.
citations, which is what `south-carolina-only` requires and what keeps Georgia
readers away from South Carolina law.

Task 15 closed. `content/meta.json` regenerated to include the new page.

### The Act 42 page, and why 22 pointers became 10 — 2026-08-26

**The page**: `/resources/south-carolina-liquor-liability-2026/`, draft 5355,
written only from `docs/briefs/2026-08-26-sc-act42-liquor-liability.md`. Seeded
`south-carolina-only`, which the seeder enforces by rejecting any O.C.G.A.
citation in the body.

Verifying two sections the brief had only listed by subject turned up a detail
worth the page on its own: **Act 42 inserted the word "knowingly" into
S.C. Code § 61-6-2220**, the prohibition on serving a person in an intoxicated
condition. One word in an eleven-section act, and it adds a knowledge element to
the statutory hook a dram-shop claim hangs on.

**22 pointers became 10, and the cut is objective.** Twelve of the 22 pages
mention over-serving once or twice as a bullet in a list of possible defendants.
A pointer to a statute-change page from there is noise, and indiscriminate
internal linking is the habit this recovery exists to unwind. A page qualifies if
a heading names the topic (5 pages) or it appears six or more times across body,
FAQs and takeaways (5 more). Both lists, with counts, are in the script so the
decision is reviewable.

**The linker refuses to run.** `bin/link-act42-page.php` aborts while the target
is a draft, because linking ten pages to an unpublished page is a defect, not a
head start. It finds its own insertion point at run time rather than carrying
frozen anchors that would be stale by the time the page is published.

**Two hazards found while testing the placement, neither hypothetical:**

1. **90 published pages carry `<script type="application/ld+json">` inside
   `post_content`**, three of them among the ten targets. Inserting HTML near one
   corrupts the structured data silently. The linker now refuses to place inside
   a JSON-LD block. Swept separately: **no previously-corrected claim survives
   inside one** — checked, not assumed.

2. **The last keyword hit is usually in the closing call to action.** Early
   versions placed the pointer after "There is no fee unless we win your case"
   and after an office address. Hits in the final 15% are now skipped, and the
   enclosing block must actually contain the keyword — a proximity window was
   tried first and picked up an address paragraph sitting near one.

Two pages (4076, 4729) are reported for manual placement rather than guessed at.

### Act 42 verified — and the alarm I raised was too loud — 2026-08-26

Read 2025 Act No. 42 (H.3430) against the enrolled text and both codified
versions. Fact base: `docs/briefs/2026-08-26-sc-act42-liquor-liability.md`.

**The headline is a negative finding, and it corrects my own earlier one.**
`docs/sc-act42-exposure-2026-08-25.md` called this "a live legal-accuracy exposure
of the same class as the seat-belt rule." It is not. The seat-belt rule was
*actively false* for sixteen months. A sweep of all four content surfaces found
**no page that Act 42 makes false**: none states the alcohol exception, none ties
joint and several liability to alcohol, and the three pages pairing "alcohol" with
"exception" are about *Georgia* punitive-damages caps. What exists is 25 pages
describing SC dram-shop liability accurately but without the 2026 rule. Worth
fixing; not an emergency. Saying so accurately matters more than the urgency did.

**What the Act actually does.** § 15-38-15(F) was *narrowed*, not simply gutted:
alcohol and gross negligence came out of the carve-out, wilful/wanton/reckless/
intentional and illegal drugs stayed, and the consequence — joint and several
liability for all of subsection (A)'s damages — is now express. The 50% threshold
in subsection (A) did **not** change. In place of the alcohol carve-out the Act
added § 61-2-147: where a verdict is rendered against **both** a licensee and a
driver charged under § 56-5-2930, § 56-5-2933 or § 56-5-2945, the licensee is
jointly and severally liable for **50% of actual damages**. One route to full joint
liability closed and a narrower, more specific one opened.

**A verification trap worth recording.** The Statehouse serves amended bills with
`sc_strike`/`sc_insert` spans. Strip the tags and struck text reads as retained —
which inverts § 15-38-15(F) completely. I did exactly that mid-verification and
briefly concluded the alcohol exception had survived. Resolve the markup, or read
the codified section, which publishes both versions with effective-date notes.

**Fixed:** the comparative-negligence guide (5352), the only page mentioning Act
42. It said the removal brought dram-shop cases "under the same comparative-fault
rules" — it is the apportionment rules, not comparative fault — and omitted
§ 61-2-147 entirely, which made the change read as one-directionally bad for
claimants.

**Not done:** the authoritative page, and a scoped pointer on the remaining 22
pages. Five Georgia-only pages are explicitly out of scope; Act 42 has nothing to
do with them and adding it would be a new error.

### Ten false legal claims fixed, and the guide that would not verify — 2026-08-25

Setting out to write the last two two-state guides meant verifying the law they
would rest on. That verification found **ten false claims across six published
pages**. Full trace, with sources, in `docs/wc-um-audit-2026-08-25.md`.

The two that matter most, both of which would cost a client real money:

**Georgia's filing deadline ran from the wrong event.** `steps-after-work-injury`
said a claim could be filed "2 years from the last authorized medical treatment."
O.C.G.A. § 34-9-82 gives **one** year from the last remedial treatment and **two**
years from the last payment of weekly benefits. The page merged the two and
attached the longer period to the more common event — so a worker whose last
treatment was eighteen months ago would read it and conclude they still had time.
They had none.

**South Carolina's 500-week cap was described as extendable.** Two pages said PTD
benefits "may be extended if the worker proves continued total disability."
§ 42-9-10(A) says the opposite: *"in no case may the period covered by the
compensation exceed five hundred weeks except as provided in subsection (C)"* — a
closed list of paraplegia, quadriplegia and physical brain damage. One page also
listed amputation as qualifying for lifetime benefits. It does not.

Also fixed: Georgia's panel-of-physicians rule was stated backwards (the worker
chooses, not the employer), and South Carolina's UM/UIM rules were wrong in both
directions on two different pages — UM described as waivable when § 38-77-150
makes it mandatory, UIM described as mandatory when § 38-77-160 only requires it
be offered. The site asserted both halves of the truth and both halves of the
error, sometimes within the same page.

**Shipped:** the workers' compensation guide, draft 5354. Its spine is a point
only a two-state practice would notice — both states cap wage benefits and both
have a route past the cap, but Georgia's is a *functional test* that can be argued
and South Carolina's is a *categorical list* of three conditions. So the headline
400-vs-500-week comparison inverts for the most badly injured workers. The
filing-deadlines guide's deliberately blank South Carolina workers' comp cell is
also now filled, the deadline having been verified.

**Not shipped:** the UM/UIM guide. Georgia offers two structurally different forms
of UM coverage — "added on" and "reduced by" — that can differ by the entire value
of the coverage on the same crash, and the operative text of O.C.G.A. § 33-7-11
could not be obtained from any primary source available here. Six routes were
tried; all six are recorded. Writing it from memory is precisely what left the
seat-belt rule wrong for sixteen months, so it waits for the statute. 33 pages
cite that section and 86 mention stacking, so the exposure is real and is scoped.

**The pattern, again.** Every one of these was found by checking a fact in order to
write something new — none by reading the pages, which read fluently and carry
correct statute numbers beside incorrect statements of what those statutes say. A
citation is not a verification, and here it keeps being mistaken for one.

### The re-sweep: 21 more survivals, and four surfaces — 2026-08-25

Re-sweeping the earlier statistical corrections against meta found **21 survivals
across 15 pages** — figures the audits had removed from bodies, still published
elsewhere on the same pages.

A claim on this site can live in **four** places. The earlier rounds swept one.

| Surface | Swept before today |
|---|---|
| `post_content` | yes |
| `_roden_faqs` (also FAQPage schema) | no — fixed earlier today |
| `_roden_key_takeaways` (the box **above** the article) | **no** |
| `post_excerpt` (the Article `description` in schema) | **no** |

**The false negative worth remembering.** After the FAQ fixes, the sweep against
`content/meta.json` reported zero survivals. The live pages still showed them.
`_roden_key_takeaways` was not in the export whitelist, so the sweep read the
field, got nothing, and called it a pass. *A sweep that cannot see a field reports
zero, not "unknown."* It surfaced only because the live pages were checked too.

Adding that field found two more. Adding `post_excerpt` found the last two: both
Ashley Phosphate pages still called it *"the most dangerous intersection in South
Carolina"* in the excerpt that becomes the schema `description` — on pages whose
own bodies say it ranked **second**.

**Not everything found was wrong.** Three pages carry "62 injuries between 2011
and 2015"; two cite the Post and Courier. The third had the same true figure with
no source, so it was **cited, not deleted**. Likewise "a crash every three days" at
Ashley Phosphate is real and sourced — only the superlative attached to it was
false, and the pages now carry the sourced figure *and* the true ranking.

`bin/apply-faq-remediation.php` became `bin/apply-meta-remediation.php`, handling
FAQ entries, plain meta and `post_excerpt` under one exact-match guard. Four
surfaces do not warrant four scripts. `content/meta.json` now versions the
takeaways box (278 pages) and the excerpt (483) — both invisible to review until
today.

### The FAQ meta was a blind spot — 2026-08-25

PRs #82 and #83 merged, and the corrected pages were then checked live. Eight of
nine were clean. `/steps-after-work-injury/` still carried the false workers' comp
deadline — on a page whose body had just been fixed and whose `post_content` sweep
returned zero.

It was in `_roden_faqs`, which the sweep had never looked at. **FAQ answers render
into FAQPage structured data**, so the false deadline was not just published, it was
being handed to search engines as the machine-readable answer to "How long do I
have to file a workers' compensation claim?"

Re-sweeping meta by claim *class* rather than by string found two more, including
`how-to-maximize-your-car-accident-compensation-in-south-carolina`, which asks
*"Does South Carolina require uninsured motorist coverage?"* and answered that
insurers must merely offer it and you can decline in writing. The question is
exactly right and the answer is exactly backwards.

Total for the pass: **thirteen false or materially misleading claims across nine
pages.**

Built in response: `bin/apply-faq-remediation.php`, with the same exact-match guard
and read-back as the body patcher. The rule it encodes — *when a claim is corrected
in a body, sweep the meta for the same claim class, never the same string* — is the
part worth keeping. The FAQ words it differently every time, which is exactly why a
string sweep misses it.

Also worth recording: the first live check showed both the corrected FAQ and the
old one, because Cloudflare was still serving an edge copy and a cache-buster query
string did not defeat it. Two clean fetches minutes apart is the check that means
something.

### § 15-38-15 resolved, brand standardised, and SC tort reform found — 2026-08-25

**The threshold.** The site stated S.C. Code § 15-38-15 two ways. The statute
reads *"joint and several liability does not apply to any defendant whose conduct
is determined to be **less than fifty percent** of the total fault"* — so a
defendant at exactly 50% **is** jointly liable. `/resources/south-carolina-comparative-negligence/`
was right; `/blog/truck-accident-liability/` said "more than 50%" and was wrong.
Corrected to the statutory wording, and the two-state guide now quotes it directly
rather than hedging.

**And verifying that turned up something much larger.** South Carolina enacted
comprehensive tort and liquor-liability reform — **2025 Act No. 42 (H.3430),
effective 1 January 2026** — and **nothing on this site mentions it**. It removed
the alcohol exception from § 15-38-15 and created § 61-2-147, under which a
licensee faces joint and several liability for 50% of actual damages where a DUI
defendant and an establishment are both liable.

**24 published pages discuss South Carolina dram-shop liability. Zero mention the
statute that changed it eight months ago.** Assessment and recommended sequence in
`docs/sc-act42-exposure-2026-08-25.md`. Deliberately not attempted here: doing it
from a summary is exactly how the Georgia seat-belt error happened.

**Brand: standardised to Roden Law.** The infrastructure was already correct —
blogname, `firm-data` name and legal entity, all post meta. Twenty marketing-copy
references across 17 old blog posts updated.

**Two categories deliberately excluded, and a find-and-replace would have ruined
both.** The three testimonial pages quote clients saying "Roden + Love" — editing
a client's words falsifies the testimonial. The two privacy policies name
*"Roden + Love, LLC"* as the entity collecting personal data; that is a legal
identification, and changing it without confirming the registered entity name
could make the notice inaccurate. Both left for the firm to decide. *(Also noted:
the privacy policy exists twice, at `privacy-policy` and `privacy-policy-2`.)*

### Site architecture: Rule 6 reopened, 14 dead geo posts retired — decided 2026-09-26

**Owner's decisions, 2026-09-26**, on `docs/site-architecture/README.md` (the plan and its
evidence: per-URL GSC inventory, market × practice demand, competitor SERP page types):

1. **"reopen rule 6".** Rule 6 was closed on 2026-09-19. It now reopens for a **capped,
   allowlisted** set of office practice pages, restored at their old URLs and single-state.
   Wave 1 is 11 pages, with Charleston car accident first. Wave 2 is gated on wave-1 results.
   Each page still needs the legal sweep and the attorney's sign-off.
2. **"retire those pages".** The inventory's DEAD geo pages (0 clicks in 16 months, under 100
   impressions in 90 days) fund wave 1 under the 25% ceiling.
3. **"use the Darien area, not Brunswick".** The Darien office page is the Business Profile
   landing page for the Darien area.
4. **"those offices are closed. don't include those".** The listings tagged atlanta and
   jacksonville that show up in GSC are closed offices. They are out of the plan.

**This batch: 14 posts, not 16.** The inventory flagged 16 DEAD geo pages. Two of them are
held: `/es/locations/georgia/darien/` (4869) and `/es/locations/south-carolina/north-charleston/`
(4883). Both are Spanish office hubs on the guardrail keep-list, and both are linked from `/es/`
and `/es/locations/`. The owner can retire them separately. Doorway ratio after:
**157 / 671 = 23.40%**.

**Pre-flight on prod, 2026-09-26 (read-only):**
- All 14 are published posts, with no Spanish twin, no child pages and no `_roden_see_also`
  reference.
- One inbound body link: post 2944 → soft-tissue post. No inbound links in meta.
- 12 existing legacy redirects pointed into the set: `-2`/`-3` slug duplicates, root-level
  slugs, and two merged posts (`can-witnesses-be-forced…` with 2,233 impressions and
  `stomach-pain-after-a-car-accident-in-charleston` with 1,558). All 12 are repointed straight
  to the final target, so none becomes a chain.
- Every target returns 200.
- The map is `roden_dead_geo_post_urls()`.
- The Brunswick profile URL `/brunswick/personal-injury-lawyer/` went through the city-first
  handler to the retired `darien-ga` PI page and on to the national pillar. It now 301s to
  `/locations/georgia/darien/` via `roden_gbp_landing_urls()`, which is merged into the
  priority-0 removal map.

**Applied 2026-09-26.** Redirects deployed in #159 (`87c0ac9`); prod `legacy-redirects.php`
md5 matches the repo.
- **Relink:** 1 link in 1 post (2944 → `/blog/supporting-a-whiplash-claim/`), with
  `post_modified` untouched. Backup: `docs/backups/dead-geo-relink-2026-09-26.json`.
- **Removal:** 14/14 drafted and marked `_roden_retired`. Read back from the table: 14 draft.
  Backup: `docs/backups/dead-geo-posts-2026-09-26.json`.
- **Sweep:** published post bodies and every post-meta value checked for all 14 paths — 0
  references left.
- **Caches:** object cache and page cache both flushed.
- **Verified live, sequentially with cache-busting:** **27/27** single-hop 301 → 200. That is
  the 14 retired posts, the 12 repointed legacy redirects, and the Brunswick profile URL →
  `/locations/georgia/darien/`.
- **Doorway: 171 / 685 = 24.96% → 157 / 671 = 23.40%, PASS**, which frees 10 geo slots for
  wave 1. JSON-LD guard PASS. `content/meta.json` `_count` 678 → 664: exactly the 14.

### Savannah workers' comp page live (office practice page #6) — 2026-09-26

**Owner, 2026-09-26:**
- "do the Savannah's WC page"
- "this has been reviewed - those 2 statutes have been reviewed as well": Eric Roden reviewed the
  page and O.C.G.A. §§ 34-9-11 (exclusive remedy) and 34-9-17 (willful misconduct /
  intoxication). His review is dated 2026-09-26.
- "publish it when the sweep clears"

Both statutes remain *pending* in the shared GA pack; for Roden, Eric Roden's review is the
approval. The panel of physicians (§ 34-9-201) is stated uncited in the page copy and cited in the
essay; it rests on the same review.

**Shipped:**
- **#179** — Savannah WC essay:
  - "only Level I" dropped;
  - the unverified "35 Barnard Street field office" cut;
  - the deadline no longer reads as a flat "one year … not two".
  - Also the allowlist entry.
- **WC pillar pass 3 (DB):** the GA branch cites § 34-9-11 instead of "§ 34-9-1 et seq.", and
  § 34-9-265 is dropped.
- **Content** (`bin/rebuild-savannah-workers-comp.php`, post 3652): GA only, Eric Roden as author.
  - All three prongs of § 34-9-82;
  - 30-day notice (§ 34-9-80);
  - the weekly maximum with no figure (§ 34-9-261);
  - the panel, § 34-9-11 and § 34-9-17.
- **Legal sweep: FAIL on template text** (`data/facts/remediation-2026-09-26-savannah-wc.md`).
  **#180** fixed it:
  - WC step 5 / HowTo, the law box and the sidebar showed "1 year from the date of injury
    (§ 34-9-82)", dropping the treatment and benefit-payment extensions. The GA override now
    carries `deadline_detail` (the comparison table's approved, translated string).
  - Notice now reads "right away, and no later than 30 / 90 days" for GA and SC. This also
    reaches the live Charleston WC page.
- **Publish:** behind the #143 redirect first, then **#181** removed the redirect.
- **Verified live:**
  - The page returns 200, has a self canonical and the map.
  - The nested URL and the legacy URL each 301 to it in one hop.
  - 18 internal links restored across 18 posts.
  - JSON-LD guard PASS; `content/meta.json` regenerated.
  - **Doorway 161 / 675 = 23.85% PASS.**

**Open from the sweep (not blocking):**
- **L1 — live error.** `/blog/workers-compensation-claim-process-georgia/` FAQ 1, also in FAQPage
  schema, says employees "usually have 10 days to make a report"; § 34-9-80 gives 30.
- **L2.** Two posts' FAQs give a flat one-year deadline: that post and
  `/blog/appealing-a-denied-workers-compensation-claim/`.
- **Flat one-year wording in other templates:** the Darien WC essay, the generated key
  takeaways, and two-state takeaways that render "1 years".
- **W4.** The third-party examples don't mention that co-workers can't be sued (§ 34-9-11(a)).
- **Proposed GA pack rules:** `ga-wc-two-years-from-injury` and `ga-wc-notice-wrong-days`.

### The five sweep findings fixed; toolkit checkout back on main — 2026-09-26

**Owner, 2026-09-26:** "fix that internal-ai-scripts checkout issue, then fix those five posts
which have been reviewed". Georgia items were reviewed by Eric Roden; South Carolina items by
Graeham C. Gillin.

- **Toolkit checkout:** it was clean, with no stashes and nothing unique on the branch. It
  switched from the superseded `law/comparison-table-2026-09-26` to `main` at `894c315`. The
  validator shows both packs signed.
- **`bin/fix-five-sweep-findings.php`** corrects four bodies (direct column write,
  `post_modified` untouched) and one FAQ (`update_post_meta( wp_slash() )`). Every write was read
  back.
  - **1671:** the $1,000 threshold moved from § 56-5-1260 to § 56-5-1270, split into one sentence
    per statute.
  - **1820:** a county gets twelve months, not six. City six months (§ 36-33-5); county or State
    twelve (§§ 36-11-1, 50-21-26).
  - **2647:** Georgia notice now says which period applies: six months for a city, twelve for a
    county or the State.
  - **3493** (FAQ 4, also FAQPage structured data): the same city/county split.
  - **4624:** the SCTCA "requires strict notice compliance" became the actual deadline: two
    years, or three with a verified claim (§§ 15-78-110, 15-78-80).
  - Backups: `docs/backups/five-sweep-findings-2026-09-26.json` and `-1671-pass2`.
- **Verified:**
  - Roden claims sweep against a **fresh** export: **0 findings**. The first re-run read the
    17:51 cached export; the sweep needs `--fresh` after any content write.
  - JSON-LD guard PASS; `content/meta.json` regenerated.

### Savannah WC sweep L1/L2 and the flat § 34-9-82 templates fixed — 2026-09-26

**Owner, 2026-09-26:** "those have been reviewed. fix them now" (Georgia, reviewed by Eric Roden).

- **#182** (`64d8e56`), the template fixes:
  - Single-state statutory takeaways use `deadline_detail`.
  - The two-state WC takeaways no longer print "1 years"; Georgia gets the full § 34-9-82
    phrase.
  - The Darien WC essay now reads "generally one year … extended by employer-furnished
    treatment or weekly benefit payments". It renders only on the Darien WC office page, which
    is not live, so this fix is latent.
- **`bin/fix-ga-wc-posts.php`**: one body (direct column write) and three FAQ answers
  (`update_post_meta( wp_slash() )`), exact-match, each read back.
  Backup: `docs/backups/ga-wc-posts-2026-09-26.json`.
  - **1809**, body and FAQ 0 (the log above called it FAQ 1): "usually have 10 days to make a
    report" became "notice within 30 days of the accident (O.C.G.A. § 34-9-80)".
  - **1809 FAQ 4** and **1808 FAQ 2** (both also in FAQPage schema): the flat one-year claim
    deadline now carries all three § 34-9-82 prongs (one year from injury, one year from the
    last employer-paid treatment, two years from the last weekly benefit).
- **Verified live** (cache-busted):
  - Both posts show the new text in the page and in the JSON-LD; the old sentences are gone.
  - The WC pillar and all four WC subtypes render the #182 takeaways, with no "1 years" and no
    tort deadline.
  - Fresh claims sweep: **0 findings**. JSON-LD guard PASS. `content/meta.json` regenerated;
    the diff is exactly the three FAQ answers.

**Still open, not in this review:**
- 1809 still says the Employer's First Report "must be filed within 10 days" (body and FAQ 1).
  That is an employer duty, not the employee notice, and no pack authority verifies it.
- W4: co-worker immunity (§ 34-9-11(a)).
- The two proposed GA pack rules.

### Charleston motorcycle page live — wave 1, office practice page #7 — 2026-09-28

**Owner, 2026-09-28:** "move on to the next batch", "merge #183 now", then "these have been
reviewed by Gillin today" (the page, and §§ 56-5-3640 and 56-5-3660).

- **Pillar intros (post 3607, live):** removals only.
  - The unsourced "helmet defense … most courts" case-law survey is gone.
  - So is "lane-splitting is illegal in both states".
  - "Both states allow UM/UIM stacking" and the household-coverage layering claim became the
    signed SC UM/UIM wording (§§ 38-77-150, 38-77-160).
  - Script: `bin/fix-motorcycle-pillar-intros.php`.
- **Law pack (internal-ai-scripts #68):** §§ 56-5-3640 (lane use; no lane splitting) and
  56-5-3660 (helmets under 21 only), read against scstatehouse.gov and signed by Gillin
  2026-09-28. The SC pack now holds 34 authorities.
- **Content** (`bin/rebuild-charleston-motorcycle-accident.php`, post 3639): SC only, Gillin
  byline, no statistic.
- **Legal sweep: FAIL** (`data/facts/remediation-2026-09-28-charleston-motorcycle.md`).
  Fixed on the draft before publish:
  - **E1:** FAQ 3 said an "adult rider" without a helmet broke no law; § 56-5-3660 runs to 21.
    It now says "21 or older".
  - **W1 (option B):** "which of your policies applies depends on its terms" cut.
  - **W2:** the two-abreast exception to the lane rule added.
  - **W3:** "about a block" to the courthouse.
  - **W5:** the link to the stacking resource removed.
- **#183** added the allowlist entry. The page was published behind the redirect, then **#184**
  removed the redirect.
- **Verified live:**
  - The page returns 200 with a self canonical, the map and 7 JSON-LD blocks.
  - The nested and legacy URLs each 301 to it in one hop; the Spanish URL keeps its redirect.
  - Fresh claims sweep: **0 findings**. JSON-LD guard PASS. `content/meta.json` regenerated.
  - **Doorway 162 / 676 = 23.96% PASS.**
- **Links:** nothing to restore. #142's only English link came from post 5052, which is retired
  now. The pillar and the Charleston hub link to the page from their templates.

**Open, for Gillin's packet (not blocking):**
- W1 option A: § 38-77-30 (a motorcycle policy must carry UM) and the § 38-77-160
  vehicle-involved limit.
- W4: `/motorcycle-accident-lawyers/lane-splitting-accident/` FAQ 0 says "only California", and
  its SC sentence is uncited.
- W5: `/resources/south-carolina-um-uim-stacking/` still makes the stacking claim.
- `/resources/south-carolina-personal-injury-faq/` says "adult riders" (FAQ 50, and FAQ 58 in
  Spanish). It is conditioned on 21, so it is imprecise rather than false.
- Proposed rule `sc-helmet-adult-threshold`.
- The Spanish twin (post 5184) stays retired; it was never rebuilt.

**Follow-up the same day.** Owner: "Go ahead on 1 and 2".

`bin/fix-helmet-age-and-lane-splitting-faqs.php` changed 5 FAQ answers, each also FAQPage schema.
Backup: `docs/backups/helmet-lane-faqs-2026-09-28.json`.
- **4814 FAQ 49/50** and the Spanish twin **4937 FAQ 57/58**: "adult rider(s)" became "21 or
  older", and FAQ 50/58 now cite § 56-5-3660.
- **4073 FAQ 0** (lane splitting): "South Carolina has similar prohibitions. Only California
  explicitly permits…" became the § 56-5-3640 rule. The Georgia sentence is unchanged.
- Verified live and in the schema. Fresh sweep: 0 findings. JSON-LD guard PASS. meta.json
  regenerated.

**Still for Gillin:**
- 4814 FAQ 49/50 (and 57/58) say helmet use "runs through ordinary comparative fault" and is
  "not an automatic bar". That is uncited helmet-defense law, the class removed from the pillar.
- 4073 FAQ 2 says "some states have legalized lane filtering", an other-states claim.

### Columbia car page live — wave 1, office practice page #8; government-vehicle SCTCA fixed — 2026-09-28

**Owner, 2026-09-28:** "then move to the next page", then "those have been reviewed. publish
them". That covers Gillin's review of the page, the Columbia essay and the government-vehicle
corrections.

- **#185** — the Columbia office essay, English and Spanish. It renders on Columbia office
  practice pages; the hub shows only the directions. Removed:
  - the Tyler Odyssey / 365-day Rule 40 / "mandatory" mediation procedure;
  - "disproportionately from one place";
  - "$2.08B", "largest in agency history" and "through 2029" (SCDOT now says 2034);
  - I-77 as part of Malfunction Junction (it is I-20/I-26);
  - "only Level I";
  - the stacking claim.

  Also:
  - Directions rewritten. There is no I-277 in Columbia; SC 277 becomes Bull Street.
  - Map embed added: place ChIJQZdkRQCl-IgRVi202Pu6b1I, verified to resolve to 1545 Sumter St
    Suite B.
  - Allowlist entry.
- **Content** (`bin/rebuild-columbia-car-accident.php`, post 3625): SC only, Gillin byline. It
  reuses the Charleston car page's reviewed SC rules wording and does not link the stacking
  resource.
- **Legal sweep: PASS** (`data/facts/remediation-2026-09-28-columbia-car.md`). Fixed on the
  draft:
  - W1: Lexington County venue line.
  - W3: truck link to the pillar.
  - W2 (the template resources box shows a Myrtle Beach card) is open.
- **L1 fixed live** (`bin/fix-government-vehicle-sctca.php`, post 4059). Backup:
  `docs/backups/government-vehicle-sctca-2026-09-28.json`.
  - "Claims must be filed … 180 days to investigate" → the claim is optional
    (§§ 15-78-80, 15-78-110).
  - "$1.2 million per occurrence for multiple entities" → $300,000 / $600,000 however many
    entities (§ 15-78-120); the $1.2M limits apply only to government physicians and dentists.
  - Added the SC two-year deadline to "Critical Deadlines" and FAQ 5, and dropped FAQ 5's "the
    standard statute of limitations also applies".
  - Excerpt and FAQ 0 no longer claim SC notice requirements.
  - Georgia and federal sentences unchanged.
- **Publish:** behind the redirect first, then **#186** removed it.
- **Verified live:**
  - The page returns 200 with a self canonical, the map and 7 JSON-LD blocks. The nested and
    legacy URLs each 301 to it in one hop; the Spanish URL keeps its redirect.
  - 3 anchors restored in 2 posts (1714, 3553). Four source posts are retired, and 1740 no
    longer mentions Columbia.
  - Fresh sweep: 0 findings. JSON-LD guard PASS. meta.json regenerated.
  - **Doorway 163 / 677 = 24.08% PASS.**

**Open (sweep L2–L6, not blocking):**
- Four Columbia resources cite § 15-78-80 for the caps (should be § 15-78-120).
- The Carolina Crossroads and I-20 resources still carry "$2.08B" and "I-26/I-20/I-77".
- `/resources/columbia-i-26-i-20-i-77-interchange-truck-accidents/`: wrong title and
  superlatives.
- Richland 2023 crash figures conflict across pages.
- US-1 / Augusta Road is in Lexington County.
- The Columbia guide says "extreme negligence" as the punitive standard; this needs Gillin.
- Proposed sweep rules:
  - extend `sctca-mandatory-notice`;
  - new `sctca-cap-multiple-entities`;
  - new `sctca-caps-cited-to-15-78-80`.

**Follow-up the same day.** Owner: "let's fix these last 4 items before moving on".

The follow-up legal sweep of both scripts FAILED on three items, R1–R3; all were fixed before
apply. Its verdict is appended to the Columbia remediation file.

- **Columbia resources** (`bin/fix-columbia-resources-claims.php`: 25 edits, 7 posts).
  Backup: `docs/backups/columbia-resources-claims-2026-09-28.json`.
  - **Damage caps:** the four liability tables and Crossroads now cite §§ 15-78-110 and
    15-78-120 for the caps (previously § 15-78-80).
  - **Crossroads cost:** $2.08B → **$2.69B**, the project homepage's figure; its /about page is
    stale. Also on the homepage: 14 miles, 134,000+ vehicles a day, mid-2030s.
  - Cut "busiest interchange system in South Carolina".
  - The corridor is no longer called Malfunction Junction; that is the I-20/I-26 interchange
    inside it.
  - **4655:** the I-20/I-77 interchange is northeast of downtown, not "south of Columbia"
    (R1, 5 places).
  - The "I-26/I-20/I-77 interchange" anchors were reworded.
  - **3518 (punitive damages):** "extreme negligence or recklessness" now reads "only in rare
    cases, proved by clear and convincing evidence (§ 15-33-135)". The conduct standard has no
    pack authority, so it is left out.
- **4656 rewritten in place** (`bin/rewrite-columbia-interchange-resource.php`). Same URL: 5,852
  impressions at position 7 on "i-26 and i-77 interchange columbia".
  - Now: three separate interchanges. I-77 begins at I-26 Exit 116 in Cayce; I-20/I-26
    (Malfunction Junction) is west of downtown; I-20/I-77 is northeast.
  - The false I-26 → I-20 → I-77 "weaving" route is gone.
  - "Joint and several … full amount" became: a defendant under 50% "generally" pays only its
    share (§ 15-38-15, R2). Nelson governs your own share of fault.
  - Cut: the unsourced 584-deaths figure, "only city", "most dangerous" and "legally
    requires".
  - Backup: `docs/backups/columbia-interchange-resource-2026-09-28.json`.
- **#187 (template):** the resources box on office pages drops resources whose slug names
  another office's market. It is titled "Local" only when something local remains; otherwise it
  reads "{State} {practice} Resources". Spanish msgid added; .mo recompiled (625). Verified on 6
  office pages.
- **Columbia directions:** nothing left to verify. #185 cut them to the checked routes (SC 277 /
  Bull St, I-126), with no final turns.
- Fresh sweep: 0 findings. JSON-LD guard PASS. meta.json regenerated.

**For Gillin:**
- `SC 15-38-15` was verified 2026-09-08, but the section was amended 2026-01-01.
  - Proposed pack amendment: the (F) exception for wilful, reckless or drug-involved conduct;
    non-party fault under (G)–(H); and (C)(a), which treats a carrier and its driver as one
    party.
  - Pages can state the exception only after he signs.
- Still open from L5: Broad River's "Most Dangerous Truck Corridors" heading and the conflicting
  Richland crash figures.

### North Charleston car page live — wave 1, office practice page #9 — 2026-09-28

**Owner, 2026-09-28:** "go to the next page in wave 1", then "reviewed - publish it" (Gillin's
review).

- **#188** — North Charleston office.
  - Essay (EN and ES): cut the unsourced "hazard profile is dominated by", "recurring crash
    corridors" and "flown to MUSC".
  - Hospitals confirmed: Trident (Level II, 9330 Medical Plaza Dr) and MUSC University Medical
    Center (Level I).
  - Directions cut to the address; the Exit 213 / Montague / Spruill turns were unverifiable.
  - Map embed added: place ChIJS2CVHEh7_ogRIEA4SfdJ3A8, verified to resolve to 2703 Spruill Ave.
  - Allowlist entry.
- **Content** (`bin/rebuild-north-charleston-car-accident.php`, post 4540): SC only, Gillin
  byline, the reviewed SC rules wording. Venue is hedged for the Berkeley and Dorchester parts
  of the city.
- **Legal sweep: PASS** (`data/facts/remediation-2026-09-28-north-charleston-car.md`).
  - W1: "near Park Circle", which #188 introduced, is wrong; the office is in Union Heights,
    about 2.5 mi south. **#189** dropped the neighborhood from the directions, and the draft now
    says "in North Charleston".
  - W2: the essay's venue line gained the Berkeley/Dorchester hedge (EN and ES).
  - W3 is open: the "Our North Charleston Attorneys" heading renders empty, because no attorney
    is assigned to the office.
- **Publish:** behind the redirect first, then **#190** removed it.
- **Verified live:**
  - The page returns 200 with a self canonical, the map and 7 JSON-LD blocks. The nested URL
    301s to it; the Spanish URL keeps its redirect.
  - `/practice-areas/north-charleston/…` never existed (0 rows in 16 months of GSC); only
    Charleston had that old URL form.
  - 1 anchor restored (3435); the other 4 source posts are retired.
  - Fresh sweep: 0 findings. JSON-LD guard PASS. meta.json regenerated.
  - **Doorway 164 / 678 = 24.19% PASS.**

**Open, linked pages (sweep L1–L9, not blocking):**
- **L1, live error:** `/blog/north-charleston-crime-rate-hit-and-run/` says leaving the scene
  of any injury crash is a felony carrying up to 25 years. Under § 56-5-1210 that is only for
  a death; a non-great-bodily-injury crash is a misdemeanor. It also says UIM is "required".
- **L2:** the dangerous-roads resource cites § 15-78-80 for the SCTCA deadline.
- **L3:** the Rivers Avenue post gets § 56-5-3130 backwards.
- **L4:** the wrongful-death deadline is cited to § 15-51-20 in 5 places.
- **L5:** the Ladson post has a notice implication, "Town of Ladson", and the wrong Exit 199.
- **L6:** the settlement-value resource says UM is merely "offered".
- **L7:** Ashley Phosphate: "applies to all claims", and a garbled "SS".
- **L8:** the government-vehicle FAQ still says the caps are "against a single government
  entity"; the commercial-vehicle and bus FAQs carry notice wording.
- **L9:** the statewide car page's stacking line.

**Follow-up the same day.** Owner: "fix those FAQs and then do the last wave 1 pages".

`bin/fix-hit-and-run-and-sctca-faqs.php` made 7 edits across 4 posts. Backup:
`docs/backups/hit-and-run-sctca-faqs-2026-09-28.json`.
- **4645 (L1):** leaving the scene of an injury crash is a misdemeanor; great bodily injury is a
  felony carrying up to 10 years, and a death a felony carrying up to 25 (§ 56-5-1210). UM is
  required (§ 38-77-150) and UIM offered (§ 38-77-160), in the body and the key takeaways. The
  unsourced crime-rate and uninsured-rate figures are still there.
- **4059 FAQ 2:** the caps apply "however many government entities are involved"
  (§ 15-78-120). The body intro's "notice" is scoped to Georgia and federal claims.
- **4054 FAQ 4 / 4061 FAQ 5:** South Carolina requires no notice; the SCTCA two-year deadline
  applies (three years with a verified claim). Georgia wording is unchanged.
- Verified live. Fresh sweep: 0 findings. JSON-LD guard PASS. meta.json regenerated.

### Charleston wrongful death and medical malpractice live — wave 1 complete (11 of 11) — 2026-09-28

**Owner, 2026-09-28:** "fix those FAQs and then do the last wave 1 pages", then "Gillin has
reviewd".

- **Pillar intros** (`bin/fix-wd-medmal-pillar-intros.php`, two passes, live).
  - Med mal:
    - The caps were given as the $350,000 / $1.05M base. They are now the 2026 $596,001 /
      $1,788,002, with all four exceptions.
    - "Punitive for gross negligence" became the clear-and-convincing burden (§ 15-33-135).
    - The affidavit is now cited to § 15-36-100, filed with the § 15-79-125 notice.
  - Wrongful death: two-state text, "within 3 years of death", and damage elements that
    §§ 15-51-40 and 15-5-90 do not list, all replaced with what the statutes say.
- **Law pack (internal-ai-scripts #69):** §§ 15-51-10, 15-51-40, 15-5-90, 15-79-125 and
  15-36-100 signed by Gillin 2026-09-28. The SC pack now holds 39 authorities.
- **#192:** a new `tort` statute override. SC med mal's law box, sidebar and HowTo now show
  § 15-3-545, without the no-fault treatment. The wrongful-death and med-mal steps on SC pages
  state SC law only.
- **Legal sweeps:** both FAILED on one item each, and both were fixed before publish.
  - **Wrongful death E1:** the "no cap" FAQ now names the punitive cap (§ 15-32-530) and the
    charity cap (§ 33-56-180).
  - **Med mal E1:** the essay named § 15-3-530.
  - **#193:**
    - Law box: "no recovery if the person who died was more than 50% at fault".
    - Wrongful-death CTA added.
    - `local_context_wd` / `local_context_mm` essays for Charleston (EN + ES).
    - "Generally" added to the med-mal deadline.
    - Two step phrasings changed.
  - **Med mal page:**
    - Cap exceptions: all four are now listed.
    - Tort Claims Act: the $1.2M government-physician limit and "no punitive damages" added.
    - The link to 4562 was dropped: stale caps, an invented 90-day wait and minors' rules, and
      an unverifiable case.
- **Publish:** both went live behind their redirects, then **#194** removed them.
- **Verified live:**
  - Both pages return 200 with self canonicals, the map and 7 JSON-LD blocks. The nested and
    legacy `/practice-areas/charleston/…` URLs each 301 to them in one hop.
  - Links restored: med mal 3 (4349, 4363); wrongful death 0, because all three source posts
    are retired.
  - Fresh sweep: 0 findings. JSON-LD guard PASS. meta.json regenerated.
  - **Doorway 166 / 680 = 24.41% PASS.**

**Open (for Gillin, not blocking):**
- When the wrongful-death clock starts: § 15-3-530(6) says "upon the death", but the signed
  entry doesn't hold it. Also: whether § 15-3-545 governs a malpractice death, and the "date
  of loss" for a government defendant.
- Confirm the decedent-fault reading.
- Pack amendments to § 15-3-545 ((B) foreign object, (D) minors), § 15-32-230 (emergency
  gross-negligence standard), and *Hook v. Rothstein* if he confirms it.

**Open (linked pages, live):**
- 4562: caps, the 90-day wait, minors' rules and the case.
- 4349 / 4363: the 90-day wait, the expert rule, § 15-32-230.
- 4195 (birth injury): minors' tolling.
- Georgia's "full value of life" measure on SC wrongful-death subtypes (4101, 4104–4106).
- 4099: distribution "by dependency".
- 4102: statutory-employer immunity.
- 4861: "notice" wording.

### Linked-page batch: 109 fixes across 20 pages — 2026-09-28

**Owner, 2026-09-28:** "let's work through all the linked pages now".

The open linked-page findings from the 2026-09-26..28 sweeps were consolidated and each checked
against live text: `data/facts/linked-pages-batch-2026-09-28.json` (132 entries) and `.md` (the
review packets). The 109 `apply` edits rest only on the signed SC pack (39 authorities) or on a
checked non-legal fact. Each was exact-match once, applied in array order, and read back:
`bin/apply-linked-pages-batch.php`, embedded by `bin/build-linked-pages-batch.py`. Backup:
`docs/backups/linked-pages-batch-2026-09-28.json`.

- **Med mal posts 4562, 4349, 4363 and 4195 (56 edits):**
  - Caps updated to the 2026 $596,001 / $1,788,002 (§ 15-32-220).
  - Removed:
    - the invented 90-day pre-filing wait (§ 15-79-125: the notice is filed with the
      affidavit, pauses the deadline, and mediation follows within 90–120 days);
    - "mediation after filing";
    - the "eighth birthday" and "under six" minors' rules;
    - the untraceable "Platt v. CSX".
  - The repose is now cited to § 15-3-545, not (B).
  - 4349's "gross negligence" as the punitive standard became the § 15-33-135 burden.
- **Wrongful-death subtypes 4099, 4101, 4102, 4104, 4105 and 4106, and resource 4861:**
  - SC damages and distribution now follow § 15-51-40 ("by dependency" removed).
  - SCTCA "notice" wording is now the two-year deadline; 4106 FAQ 4's notice line is scoped to
    Georgia.
  - The SC deadline and the § 15-51-20 personal-representative rule were added.
  - Georgia's "full value of the life" sentences are unchanged, for the GA reviewer.
- **North Charleston posts 4617, 4337, 4339, 4346 and 4645, plus 4809:**
  - § 15-78-110 cited for the SCTCA deadline.
  - Wrongful-death deadline moved from § 15-51-20 to § 15-3-530.
  - UM is required (§ 38-77-150) and UIM only offered (§ 38-77-160).
  - Ladson / Exit 199 facts fixed; the garbled "SS" fixed.
- **Columbia posts 4678, 4679 and 3553:**
  - Richland 2023 figures now match the SCDPS Fact Book (12,450 collisions, 58 fatal); the
    unsourced 12,731 / 65 were wrong.
  - US-1 no longer called "Augusta Road".
  - The report-threshold wording now uses § 56-5-1260 / 1270.
- **Verified:**
  - Every `from` string matched once on prod.
  - All replacements replayed clean (115/115, positive controls fired).
  - Live FAQPage JSON-LD parses on 7 spot-checked pages.
  - JSON-LD guard PASS. Fresh sweep: 0 findings. meta.json regenerated.

**Open:**
- **For Gillin: 13 items**, 7 with ready wording. They need authorities not yet in the pack:
  - § 15-32-230 (emergency gross negligence);
  - §§ 42-1-400/-410 (statutory employer);
  - § 56-5-3130;
  - § 15-7-30;
  - *Hook v. Rothstein*;
  - amendments to § 15-3-545 (B)/(D), § 15-3-530(6) and § 15-36-100.
- **For the GA reviewer: 6 items**, including "full value of the life" on 4099, 4101, 4102,
  4104 and 4105.
- **Source-or-cut: 4 items** that cannot be cut cleanly in place.
- 4106, 4337, 4339 and 4346 carry `_roden_last_reviewed` 2026-09-02, which now dates copy
  changed today.
- **The same error classes survive on 10 unlinked posts** (next batch):
  - 1646, 1696, 1813, 1668, 4350: 90-day wait, caps, minors;
  - 4075: hit-and-run felony;
  - 4859, 4860: SCTCA notice;
  - 4635: § 15-78-80;
  - 4644: "adult riders".

### Linked-page batch 2: Gillin's new authorities signed, 42 more fixes — 2026-09-28

**Owner, 2026-09-28:** "consider all to have been reviewed this afternoon", then "record
Gillin's signature on those".

- **internal-ai-scripts #70** (`df1c4ca`): each authority read against primary text first. The
  SC pack now holds **45 signed authorities**.
  - Added as signed by Gillin:
    - § 15-32-230 (emergency / obstetric gross-negligence standard, physicians only);
    - §§ 42-1-400 and 42-1-410 (statutory employer);
    - § 56-5-3130 (crosswalk yield where signals are absent or out);
    - § 15-7-30 (venue by type of defendant);
    - *Hook v. Rothstein*, 281 S.C. 541 (Ct. App. 1984) (professional disclosure standard).
  - Amended: § 15-3-545 now covers (B) foreign object and (D) minors; § 15-36-100 states the
    three-of-five-years rule.
- **`data/facts/linked-pages-batch-2-2026-09-28.json`**: 42 edits on 15 posts, applied through
  `bin/apply-linked-pages-batch.php` (builder now takes the batch path). Backup:
  `docs/backups/linked-pages-batch-2-2026-09-28.json`.
  - Minors' and foreign-object rules on 4562, 4349 and 4195.
  - The ER gross-negligence standard on 4363 and 4197.
  - The expert rule on 4349 and 4363.
  - *Hook* disclosure standard on 4199 (causation left as it was).
  - Statutory-employer framing on 4102.
  - Crosswalk rule on 4339.
  - Venue on 4346.
  - Other-states lane-filtering line cut on 4073.
  - Unsourced superlatives hedged on 4363 and 4339.
  - 4645's crime-rate and uninsured-rate figures removed.
  - Georgia, page wording only (GA pack untouched): med-mal cite corrected to § 9-3-71 on 4363
    and 4349; "In Georgia," prefixed to the "full value of the life" sentences on 4099, 4101,
    4102, 4104 and 4105.
- **Review stamps:** the four posts already stamped 2026-09-02 (4106, 4337, 4339, 4346) were
  refreshed to 2026-09-28 (`bin/restamp-linked-pages-reviewed.php`). Posts with no stamp were
  left alone.
- **Verified:** every edit matched once on prod. FAQPage JSON-LD parses on 6 spot-checked pages.
  JSON-LD guard PASS. Fresh sweep: 0 findings. meta.json regenerated.

**Decision needed (in the batch .md):**
- WD-G1: malpractice-death deadline, § 15-3-545 vs § 15-3-530(6).
- WD-G3: funeral expenses and the creditors line.
- WD-G4: caps on the nursing-home wrongful-death page.
- NC-G3: the stacking statement.
- MC-G1: keep or cut the helmet comparative-fault lines.
- GA-1, GA-2, GA-4, GA-6 (Georgia).

**Still open:** the same error classes on 10 unlinked posts (1646, 1696, 1813, 1668, 4350,
4075, 4859, 4860, 4635, 4644).

### Linked-page batch 3: the 10 unlinked posts, 69 fixes — 2026-09-28

**Owner, 2026-09-28:** "Move on to the next batch".

`data/facts/linked-pages-batch-3-2026-09-28.json` (75 entries) was built from a read-only dump
and applied through `bin/apply-linked-pages-batch.php`: 69 edits on 10 posts, each matched once
on prod and read back. Backup: `docs/backups/linked-pages-batch-3-2026-09-28.json`.

- **Med-mal posts 1646, 1668, 1696, 1813 and 4350:**
  - 2026 caps.
  - The 90-day wait and invented minors' rules removed; § 15-3-545 (B) and (D) as signed.
  - The three-of-five-years expert rule; the affidavit is filed with the Notice of Intent, not
    at trial.
  - 1646's punitive floor updated to $739,245 for 2026.
  - "Absolute" dropped from the repose sentence.
- **4075, hit-and-run motorcycle page:**
  - § 56-5-1210's three tiers (the "felony for any injury" wording removed).
  - UM is required, not "unless rejected in writing" (§ 38-77-150), with the § 38-77-170
    unknown-driver conditions.
- **4859 and 4860, slip-and-fall / premises settlement resources:** the SCTCA "notice" wording
  became the two-year deadline; the charity cap (§ 33-56-180) added.
- **4635, highway construction zone:**
  - The SCTCA is no longer cited as § 15-78-80, and its caps are stated as always applying
    (§ 15-78-120).
  - Two-year deadline.
  - An unsourced FHWA "20–40%" figure cut.
- **4644, Dorchester Road motorcycle post:**
  - "Adult riders" became the under-21 rule.
  - Wrongful death is brought by the personal representative; pre-death pain moved to the
    survival claim.
  - Unsourced statistics cut.
- **Verified:** all replacements replayed clean (70/70, controls fired). FAQPage JSON-LD parses
  on 6 spot-checked pages. JSON-LD guard PASS. Fresh sweep: 0 findings. meta.json regenerated.

**For Gillin:**
- **B3-G1:** 4635 says speeding fines are doubled in construction zones. 2017 Act No. 81
  appears to have deleted the work-zone provision of § 56-5-1535. Is any doubled-fine rule
  current?
- **B3-G2:** does the SCTCA reach a private contractor working for SCDOT?

**For the GA reviewer:**
- 4075: Georgia hit-and-run "injury" should be "serious injury" (GA 40-6-270).
- 1696: Georgia minors and § 9-3-72 cells.

### Construction-zone page: no doubled work-zone fines; SCTCA excludes contractors — 2026-09-29

**Owner, 2026-09-29:** "Research the actual current statute…", then "Gillin signed off — record
them and apply". This resolves B3-G1 and B3-G2.

**Research (scstatehouse.gov, 2026-09-29):**
- 2017 Act No. 81 rewrote § 56-5-1535, "deleting the provision relating to speeding in work
  zones", and repealed § 56-5-1536. South Carolina has no doubled work-zone speeding fine.
- In force now:
  - endangerment of a highway worker (§ 56-5-1535): $500–$1,000; $1,000–$2,000 with an injury;
    $2,000–$5,000 for great bodily injury; 2 or 4 points; the fines cannot be waived;
  - no passing in work zones (§ 56-5-1895).
- § 15-78-30(c): a Tort Claims Act "employee" "does not include an independent contractor doing
  business with the State".

**Changes:**
- **internal-ai-scripts #71:** §§ 56-5-1535, 56-5-1895 and 15-78-30 signed by Gillin. The SC
  pack now holds 48 authorities.
- **Post 4635** (`data/facts/work-zone-batch-2026-09-29.json`, 3 edits, through the batch
  applier; backup `docs/backups/work-zone-batch-2026-09-29.json`):
  - The "Enhanced Penalties" section (doubled fines, enhanced reckless driving) became "Work
    Zone Laws in South Carolina", stating §§ 56-5-1535 and 1895.
  - The SCTCA paragraph now covers SCDOT's claim only.
  - The contractor paragraph cites § 15-78-30(c): no SCTCA deadline or caps on the contractor's
    own negligence.
- **Verified live.** JSON-LD guard PASS. Fresh sweep: 0 findings.

### P0 hygiene: thin pages noindexed, hubs in the sitemap, 404s redirected — 2026-09-29

**Owner, 2026-09-29:** "let's save those remaining questions and move on to the next step".
The questions are saved in `data/facts/open-legal-questions.md`. Next step: the plan's
unfinished P0 items (`docs/site-architecture`, from `evidence/retired-with-impressions.csv`:
53 live non-sitemap URLs, 9 404s with impressions).

- **#195 `noindex,follow`** via `wp_robots`:
  - category archives;
  - paged blog and archive pages;
  - the 21 testimonial singles;
  - `/test/` and the two PPC landers already excluded from the sitemap.

  Tags, taxonomies, search, author and date archives were already noindexed by
  `roden_output_noindex_pages()`. Verified live on 6 URLs, and absent on /blog/, office pages
  and hubs.
- **#195 `hubs` sitemap** (`wp-sitemap-hubs-1.xml`, listed in the index): /attorneys/ (259
  clicks in 16 months), /practice-areas/, /locations/ and /resources/, which were in no
  sitemap.
- **#195 redirects** (`roden_p0_hygiene_urls()`, all single-hop 301s):
  - /privacy-policy-2/ → /privacy-policy/;
  - five 404s to the live pages that replaced them;
  - the "premisesliability" typo URL, which fell through to the Columbia car page, → the
    premises pillar.
  - Blog pagination past the last page (/blog/page/42/ and up) is left to 404.
- **Not done here:**
  - Pointing each Business Profile at its /locations/ hub and the /contact-us/ appointment
    links: GBP dashboard work, for the owner.
  - `/wp-sitemap.xml` 301s to a trailing-slash version, a pre-existing quirk that crawlers
    follow.

### P2 step 1: office hubs retitled to the head term — 2026-09-29

**Owner, 2026-09-29:** "start P2".

- **Evidence** (`evidence/query-clusters.csv`, generic PI, 16 months):
  - Charleston: 264,949 impressions and 31 clicks. The last 30 days split between the homepage
    (44%) and the hub (40%), at position 17.2.
  - Savannah: 199,570 impressions and 8 clicks, at 24.5.
  - Columbia: 23,376 at 25.1. North Charleston: 46,584 at 16.1. Darien: 23,445 (65% to the
    Brunswick sub-page). Myrtle Beach: 21,038 at 31.4.
- **`bin/retitle-office-hubs.php`:** `_roden_meta_title` on the 6 English hubs, now "[City]
  Personal Injury Lawyer | Roden Law" ("Columbia, SC", "Darien, GA"). The old auto-titles led
  with the place ("Charleston, SC – South Carolina Personal Injury Lawyers – Roden Law"). The
  H1 and post_title are unchanged. Verified live. Backup:
  `docs/backups/office-hub-titles-2026-09-29.json`.
- **Grids:** already live (Charleston 6, Savannah 3, Columbia 1, North Charleston 1), fed by
  the allowlist.
- **Homepage:** two-state title, H1 and description, and no Charleston targeting beyond the
  office list. No de-dup edit.
- **hreflang:** the EN/ES Charleston hubs are reciprocal, x-default is EN, both are
  self-canonical, and the ES page is fully Spanish. No defect. The 42% ES share on North
  Charleston queries predates the ES hub retirement.

**Measure:** re-pull the Charleston and Savannah PI clusters in 4–6 weeks.

### P2: six Georgia statewide pages live; GBP handoff; statewide callouts fixed — 2026-09-29

**Owner, 2026-09-29:**
- "send the GBP office page url changes to Clickup Roden Law SEO, assign to Emma, due tomorrow…
  Then… start the Georgia statewide pages. Those are cleared by Eric Roden."
- "Leave the Brunswick page for now, but Darien is the actual office page."

- **GBP (ClickUp 86bc9bckb, Emma McIntyre, due 2026-09-30):** per-office website and
  appointment URL changes, and LocalDominator directions.
  - Live profiles (Local Falcon): Charleston, Savannah and Columbia link to the homepage.
    Darien, North Charleston and Myrtle Beach link to their hubs with `?ref=gmb_…`, which the
    site 301s off. UTM parameters survive (200, clean canonical), so the new links use UTM.
  - Appointment links move from /contact-us/ (a 301) to /contact/. Columbia's could not be read
    through the API.
- **#196:**
  - `template-pillar-ga-statewide.php` (Savannah and Darien offices, GA law from firm data).
  - GA LegalService schema.
  - Shared `roden_statewide_law_callout()`. This fixed a live error: the SC workers' comp
    statewide page showed "3 years … personal injury lawsuit" and the 51% bar. It now shows
    the § 42-15-40 claim deadline, 90-day notice (§ 42-15-20) and no-fault; verified EN and ES.
- **#197:** wrongful-death callout "gives families N years to file a wrongful death lawsuit"
  (GA and the live SC page; Spanish added, .mo 632); the fault card prints its citation;
  LegalService description "personal injury injury victims" fixed; the workers' comp callout
  drops the SOL / comparative-negligence links.
- **Pages 6317–6322** (`bin/create-ga-statewide-pages.php`, `bin/publish-ga-statewide-pages.php`):
  written from the signed GA pack only, Eric Roden author, stamped reviewed 2026-09-29.
  - Legal sweep (`data/facts/remediation-2026-09-29-ga-statewide.md`): 5 PASS, 1 FAIL.
    - E1 on the personal injury page: med mal "from injury or discovery"; § 9-3-71(a) has no
      discovery rule. Fixed on 3 surfaces before publish.
    - W1 on workers' comp: the co-worker carve-out added (§ 34-9-11(a)).
  - Left out, because the Georgia statute text could not be fetched here: the helmet law
    (§ 40-6-315) and wrongful-death standing (§§ 51-4-2, 51-4-5).
- **Verified live:** all 6 return 200, self-canonical, indexable, in the page sitemap, with
  LegalService + FAQPage + BreadcrumbList; no SC text in the article body. JSON-LD guard PASS.
  Fresh sweep: 0 findings. meta.json regenerated. **Doorway 166 / 690 = 24.06% PASS.**

**Open:**
- **Shared GA pack:** the signed `GA 9-3-71` claim says "from the date of injury or
  discovery". § 9-3-71(a) has no discovery rule. The pack is shared, so it is not edited
  here; raise it with the pack owner.
- **The same med-mal "discovery" wording is live on 8 pages:**
  - FAQs on anesthesia-error, emergency-room-negligence, informed-consent-failure,
    hospital-acquired-infection and medication-error;
  - "from discovery" under § 9-3-33 on nursing-home-neglect, dangerous-pharmaceutical-drug
    and defective-medical-device.
- The "at-fault state" sentence on the car page has no signed authority.
- The § 33-7-11 citation vs the pending § 33-34-4.

### Georgia pack § 9-3-71 corrected; "discovery" fixed on 14 pages — 2026-09-29

**Owner, 2026-09-29:** "Let's fix the Georgia Law pack and the discovery error before moving
on".

- **Statute** (Justia, 2020 Code, read 2026-09-29):
  - § 9-3-71(a): "within two years after the date on which an injury or death … occurred".
    There is no discovery rule.
  - (b): five-year repose.
  - § 9-3-72: foreign object, one year from discovery.
  - § 9-3-73: minors under five, until two years after the fifth birthday.
- **internal-ai-scripts #73:**
  - The shared GA pack's `GA 9-3-71` claim ("injury or discovery") was corrected. A
    `correction` record (was / why / source) notes that the pack signer's re-verification is
    pending, since the signature covered the old wording.
  - New error rule `ga-medmal-discovery-rule`.
  - **#75** stops the rule flagging correct repose sentences ("regardless of when …
    discovered"). Fixtures 8/8.
- **`data/facts/ga-discovery-batch-2026-09-29.json`:** 17 edits on 14 posts, through the batch
  applier. Backup: `docs/backups/ga-discovery-batch-2026-09-29.json`.
  - Med-mal blog posts 1668, 1696 (FAQ and the Georgia "Discovery rule" table cell), 1798
    and 1857.
  - The /locations/georgia/ FAQ.
  - Misdiagnosis 4193.
  - The FAQs on 4194, 4196, 4197, 4198 and 4199.
  - Nursing-home neglect 4164.
  - Drug 4133 and device 4132: "from discovery" under § 9-3-33 became "from the date of
    injury", per the signed pack. Their hedged "discovery rule *may* extend" lines (case law
    on latent injuries) are kept. 4132's body was already correct.
  - South Carolina sentences are untouched; SC has a discovery rule (§ 15-3-545).
- **Verified:** live FAQPage JSON-LD parses; no old strings remain. JSON-LD guard PASS. Fresh
  sweep with the new rule: **0 findings**. meta.json regenerated.

### P3 step 1: pillar consolidation — generic sections onto the personal injury pillar — 2026-09-29

**Owner, 2026-09-29:** "Let's go to P3 - consolidate before expanding new resource pages".

- **Measured first** on the 25 live pillars (8-word shingles, as in the scenario-pages plan):
  - Median template share 37%; closest-sibling overlap 43% (the plan's "~76%" was an
    estimate); 5 pillars ≥50% shared.
  - The four generic sections were 84–100% identical: Statute of Limitations, Do I Have a
    Case (four elements), Types of Compensation and Comparative Fault. With the GA-vs-SC
    table and the related-guides block, they are about 60% of all shared text.
- **#200** (`template-practice-area.php`, same treatment as `template-subtype.php` on
  2026-09-25):
  - The **personal injury pillar is the canonical explainer** and keeps all four sections.
  - The other pillars keep the GA/SC comparison table plus one link to it; the Spanish
    pillars link to the Spanish PI pillar.
  - Workers' comp keeps its statutory deadline and no-fault sections, and drops the
    four-elements and pain-and-suffering sections, which never applied to it.
  - No URL changes; reversible.
- **Legal (same PR):** "There is no cap on compensatory damages" on the PI pillar and the
  office-page compensation section was wrong for med mal (§ 15-32-220), government and charity
  claims. It now reads "generally not capped in an ordinary injury case, although …".
  4 msgids added; .mo 636.
- **Measured after, live:** template share **28%**, closest sibling **35%**, pillars ≥50%
  shared **1**, median words 3,256 → 2,780. Matches the simulation (27% / 33% / 1).
- **Housekeeping:** the push first failed with 403 because gh was left on the Blue Sky account
  after an internal-ai-scripts merge. Switch back to rodenlaw after every toolkit PR.

**Next (P3 step 2):** the remaining shared text is the generated Key Takeaways (90% identical)
and the chrome blocks. Writing real takeaways per pillar would cut it further before new
resource pages.

### P3 step 2: hand-written pillar Key Takeaways; 29 live pillar errors fixed — 2026-09-29

**Owner, 2026-09-29:** "do the key takeaways now".

- **Takeaways:** all 24 English pillars had the generated paragraph (`roden_pa_key_takeaways_text`).
  - It was ~86% identical on average and wrong in places: "injured in a wrongful death"; the
    med-mal pillar given the tort deadline.
  - Hand-written, practice-specific replacements use signed SC/GA authorities only. Max
    pairwise overlap 19.8%.
  - Legal sweep (`data/facts/remediation-2026-09-29-pillar-takeaways.md`): 18 PASS, 6 changed.
    One was an error: the med-mal outer limits were written as absolute, but foreign objects
    and minors are exceptions.
  - Installed with `bin/set-pillar-takeaways.php` (writes only where empty; read back).
    Backup: `docs/backups/pillar-takeaways-2026-09-29.json`.
- **Live pillar errors the writer found, confirmed by the sweep:**
  - **20 data fixes on 12 pillars** (`data/facts/pillar-conflicts-batch-2026-09-29.json`,
    batch applier), 17 of them FAQ answers, so the FAQPage schema changed too:
    - pedestrian: "both states require UM unless rejected in writing" (SC UM is mandatory,
      § 38-77-150);
    - wrongful death: "3 years from the date of death" (SC) and "full value" cited to
      § 51-4-2 (it is § 51-4-1);
    - med mal: cap figures;
    - "SC threshold 51%" wording on several pillars;
    - the brain-injury discovery claim.
  - **3 meta fixes** (`bin/fix-pillar-meta-2026-09-29.php`):
    - M-WC1: the WC "comparative-fault rules" line became "benefit rules";
    - M-WC2: WC meta description "generally allows 1 year";
    - M-MM1: med-mal expert affidavit cites §§ 15-36-100, 15-79-125.
  - **#201 template:**
    - T-WC1/2/3: the WC pillar lead, GA card and sidebar now print the full § 34-9-82 rule.
    - T-WC4: filing-venue grammar.
    - T-MM1: § 15-36-100 added to the two-state med-mal step.
    - T-WD3: wrongful-death comparison intro. Spanish added; .mo 639.
- **Measured live:**

  | | Template share | Closest sibling | Pillars ≥50% shared |
  |---|---|---|---|
  | Original | 37% | 43% | 5 |
  | After #200 | 28% | 35% | 1 |
  | Now | **23%** | **31%** | **0** |

- **Verified:** JSON-LD guard PASS, all pillar JSON-LD parses. Fresh sweep: 0 findings.
  meta.json regenerated.

**Open** (in the remediation .md):
- **Gillin:** T-WD1, the WD comparison "3 years from the date of death".
- **GA reviewer:** T-WD2 and M-WD1 (§ 51-4-2), PB-WD3 (the one-third rule is inverted),
  M-MM2 (§ 9-11-9.1 "immediate dismissal"), M-PED1 (§ 40-6-91).
- **Spanish pillar twins** were not swept.
- **Engine gap:** it caught none of the 23 wrong strings; the .md proposes 5 rules.

### Columbia post: Georgia law removed; Study #2 built — 2026-09-30

- **GA-6, resolved.** Owner: "The georgia law does not belong in the Columbia post".
  - `data/facts/columbia-post-ga-removal-2026-09-30.json`, 6 removal-only edits on 3553
    (`/blog/columbia-dangerous-intersections-roads/`), through the batch applier. Backup:
    `docs/backups/columbia-post-ga-removal-2026-09-30.json`.
  - Removed: the TOC entry and H2 ("South Carolina and Georgia Laws" became "South Carolina
    Laws"), the Georgia travel intro, the Georgia deadline (§ 9-3-33) and fault (§ 51-12-33)
    sentences, and FAQ 1's Georgia sentence (also FAQPage).
  - Verified live: no O.C.G.A. in the article; the only "Georgia" left is site chrome. JSON-LD
    parses.
- **Study #2 committed, not published** (`b2c40ee`): Georgia and South Carolina truck-crash
  deaths 2020–2024, two state-specific FARS reports.
  - GA: 1,151 deaths in 1,042 truck-involved fatal crashes (13.6%).
  - SC: 669 deaths in 601 (12.0%).
  - `bin/truck-study-verify.py`: 321/321 numbers verified. Chart SVGs go in the theme with the
    publishing PR.
  - Needs an attorney read before `_roden_last_reviewed` is set.
- **Georgia statute research** (`data/facts/ga-statute-research-2026-09-30.md`): primary-text
  findings for Eric Roden's packet.

### Law pack: #62 superseded by #67, rebuilt on the signed SC pack — 2026-09-26

**Owner, 2026-09-26:** "what do we need to do with #62? Those are signed", then "yes".

internal-ai-scripts #62 (the comparison-table pack changes) was branched before the SC sign-off
(#65) and before #64/#66. Merged as-is, it would have done three things:
- reset SC to unsigned and blanked every `verifiedBy`;
- dropped §§ 56-5-1260 and 56-5-1270;
- overwritten the three signed workers' comp authorities.

**#67** (`894c315`) carries its substance onto current main instead, and #62 is closed as
superseded. These SC items were approved by Gillin on 2026-09-26 and are signed in the pack:
- § 15-32-530: the indexed punitive floor, $739,245 for 2026;
- § 15-32-220: the 2026 med-mal caps, $596,001 / $1,788,002;
- § 22-3-10: concurrent magistrate jurisdiction;
- two new authorities: S.C. Const. art. V, § 11, and § 33-56-180 (the charitable cap);
- two rules: `sc-circuit-court-dollar-floor` and `sc-punitive-floor-unindexed`.

The GA side adds 10 pending authorities (inert until signed) and one rule. Validator: SC signed
with 32 authorities; GA signed with 22 authorities plus 10 pending. Fixtures 22/22, 22/22 and
36/36.

**The Roden content sweep with the merged packs found 5 pre-existing live-content findings.**
None comes from the new rules. They are to fix:
- `/blog/what-to-do-when-you-are-in-a-car-accident/` — `SC 56-5-1260`: "arolina law requires you to report any accident involving injury, death, or property damage exceeding $1,000 (S.C. Code § 56-5-1260).. At-fault insurance system: Like Georgia, South Carolina is a fault-based state. The a"
- `/blog/roadway-hazard-auto-accident/` — `county-ante-litem-6-months`: "iling a personal injury claim against the government. If you are filing a claim against a city or municipal county, you have six months to provide notice about your claim. Likewise, if you are filing a claim against the "
- `/blog/rollover-crashes-and-what-they-do-to-your-body/` — `municipal-ante-litem-12-months`: "oad maintenance may be liable. Claims against government entities carry shorter deadlines: Georgia requires ante-litem notice within 6 to 12 months, and South Carolina requires suit within 2 years, with no pre-suit notic"
- `/blog/how-pain-and-suffering-is-calculated-after-an-accident-in-georgia/` — `county-ante-litem-6-months`: "ans losing your right to recover compensation, including pain and suffering damages. Claims against a city, county or state agency require written notice much sooner — as little as six months (O.C.G.A. § 36-33-5)."
- `/blog/ashley-phosphate-i-26-south-carolinas-deadliest-intersection/` — `sctca-mandatory-notice`: "esponsibility. Government liability: If road design or signal timing contributed to your crash, the city or SCDOT may be partially liable under the South Carolina Tort Claims Act — but these claims require strict notice "

### Charleston workers' comp page live (office practice page #5, the first WC page) — 2026-09-26

**Owner, 2026-09-26:**
- "start Charleston workers' comp"
- "yes, publish": Gillin reviewed the page.
- "add those three sections in the WC page as reviewed by Gillin"

**Shipped:**
- **#175** — SC workers' comp steps 2–3 (and HowTo) no longer describe Georgia's posted panel of
  physicians; South Carolina has none. Allowlist entry.
- **#176** — the office-page sidebar deadline reuses the practice-area statute. It had shown the
  3-year tort deadline on a WC page.
- **WC pillar intros (DB, `bin/fix-wc-pillar-intros.php`, two passes).**
  - SC branch: § 42-1-540 replaces the § 42-1-10 cite, and § 42-9-10 (with the lifetime benefit)
    replaces the § 42-9-30 cite.
  - "Uncapped" medical is removed, along with the two-state 400/500-week sentence.
  - "Non-employer tortfeasors" becomes "someone other than your employer".
- **Content** (`bin/rebuild-charleston-workers-comp.php`, post 3654): SC only, Gillin as author.
- **Legal sweep: FAIL** (`data/facts/remediation-2026-09-26-charleston-wc.md`). The page copy was
  correct; the failures were:
  - **E1:** the SC statewide up-link promised a "comparative-fault rule" on a no-fault page. Fixed
    in **#177**, along with the fault-framed bottom CTA and an unsourced line in step 1.
  - **B1:** §§ 42-1-540, 42-9-60 and 42-9-10 were not in the signed SC pack. Added as signed by
    Gillin in internal-ai-scripts **#66**; SC now holds 30 authorities.
  - The page warnings were fixed in the copy: the lifetime benefit under § 42-9-10(C), the "under
    the Act" hedge, and notice due "right away, no later than 90 days".
- **Publish:** behind the #143 redirect first, then **#178** removed the redirect.
- **Verified live:**
  - The page returns 200, has a self canonical and the map.
  - The sidebar shows 2 yr / § 42-15-40.
  - The nested URL and the legacy URL each 301 to it in one hop.
  - 2 of 2 internal links restored.
  - JSON-LD guard PASS; `content/meta.json` regenerated.
  - **Doorway 160 / 674 = 23.74% PASS.**

**Open:** internal-ai-scripts #62 carries §§ 42-1-540, 42-9-60 and 42-9-10 unsigned; it must drop
them when rebased. The two-state WC pillar still shows the Georgia panel steps. Those steps are
correct for Georgia but are presented as universal there.

### Savannah truck accident page live (office practice page #4) — 2026-09-26

**Owner, 2026-09-26:**
- "publish it when the sweep clears, then start Savannah truck"
- "yes, it has all been reviewed": Eric Roden reviewed the page. His review is dated 2026-09-26.

**Shipped:**
- **Allowlist** entry in #172.
- **Truck pillar intros, passes 3 and 4 (DB):**
  - Pass 3 removed the GA-branch § 40-1-112 drafting note and the $250,000 / § 51-12-5.1 figure.
  - Pass 4 dropped the GA-branch punitive sentence. "Gross … failures" names the standard Georgia
    excludes (it requires willful misconduct or conscious indifference), and § 51-12-5.1 is not
    in the GA pack.
- **Content** (`bin/rebuild-savannah-truck-accident.php`, post 3627): Georgia only. It covers
  Garden City Terminal and the freight corridors, who can be responsible, the ante litem
  deadlines, § 33-7-11 and the court, with Eric Roden as author.
- **Legal sweep: PASS** (`data/facts/remediation-2026-09-26-savannah-truck.md`). W1 (the punitive
  sentence) and W2 (the I-16/I-95 line no longer asserts current work zones) were fixed before
  publish.
- **Publish:** behind the #143 redirect first, then **#174** removed the redirect.
- **Verified live:**
  - The page returns 200, has a self canonical and the map.
  - The nested URL and the legacy `/practice-areas/savannah/truck-accident-lawyers/` each 301 to it
    in one hop.
  - The Charleston truck page is unaffected (SC branch only).
  - 9 internal links restored across 8 posts.
  - JSON-LD guard PASS; `content/meta.json` regenerated.
  - **Doorway 159 / 673 = 23.63% PASS.**

**Open:** `GA 51-12-5.1` is proposed as a pending GA authority. Its primary text could not be
fetched, so it must be read before Eric Roden signs it.

### Savannah car accident page live (office practice page #3, the first in Georgia) — 2026-09-26

**Owner, 2026-09-26:**
- "then start Savannah car"
- "The Georgia claims have been signed off on by Roden", then "this has been reviewed": Eric Roden
  reviewed the page. His review is dated 2026-09-26.
- "publish it when the sweep clears"

**Shipped:**
- **#170** — the Savannah office essay (EN and ES):
  - "only Level I" dropped, along with an unsourced e-filing vendor.
  - The § 33-7-11 "stacking" and § 40-1-112 direct-action sentence (neither is in the GA pack)
    replaced with the pack's § 33-7-11 claim.
  - Map embed added for the Savannah Business Profile. There was none, so the location page had
    used an address map.
  - Allowlist entry.
- **#171** — GA what-to-do step 5 now states only the § 40-6-270 duty the GA pack holds; the
  police report is framed as advice.
- **Content** (`bin/rebuild-savannah-car-accident.php`, post 3622): Georgia only. It cites
  §§ 9-3-33, 9-3-32, 51-12-33, 36-33-5, 36-11-1, 50-21-26 and 33-7-11, uses the Chatham FARS
  figure, and names Eric Roden as author.
- **Legal sweep: PASS** (`data/facts/remediation-2026-09-26-savannah-car.md`). Its four low
  warnings were fixed in **#172**:
  - LifeStar line cut;
  - SR 204 wording;
  - trial line softened;
  - office-page resources now filtered by the resource's own `_roden_jurisdiction`. An SC crash
    report had appeared on the GA page.
- **Publish:** behind the #143 redirect first, then **#173** removed the redirect.
- **Verified live:**
  - The page returns 200, has a self canonical and the map.
  - The nested URL and 7 legacy URLs each 301 to it in one hop, including
    `/practice-areas/savannah/car-accident-lawyers/` (238k impressions in 16 months).
  - 60 internal links restored across 56 posts.
  - JSON-LD guard PASS; `content/meta.json` regenerated.
  - **Doorway 158 / 672 = 23.51% PASS.**
- **Truck pillar intros pass 3:** the GA-branch § 40-1-112 drafting note and the $250,000 /
  § 51-12-5.1 figure removed. Neither is in the GA pack.

**Open GA-pack questions for Eric Roden (from the sweep):**
- § 40-6-270's scope (injury/death/attended-vehicle crashes) is narrower than the pack's claim.
- § 40-6-273 (police-report duty) is not in the pack.
- § 33-7-11: UM is included unless rejected in writing, which is stronger than "must offer".

### Charleston truck accident page live (office practice page #2); SC police-report step fixed — 2026-09-26

**Owner, 2026-09-26:**
- "fix the police report step, then start Charleston truck"
- "Set Gillin's review date as today. He has reviewed all this content."
- "publish it when the sweep clears"

**Shipped:**
- **#166 — police-report step.** On SC pages, what-to-do step 5 and its HowTo schema now state
  both duties from the signed pack: § 56-5-1260 (immediate police notice for an injury or death
  crash) and § 56-5-1270 (DMV report within 15 days when no officer investigated). Georgia and
  two-state pages keep the general sentence until O.C.G.A. § 40-6-273 is in the GA pack.
- **#167 — allowlist.** `truck-accident-lawyers/charleston-sc` added.
- **Truck pillar intros (DB)** (`bin/fix-truck-pillar-intros.php`):
  - removed "neighboring states … no cap", § 58-23-10 and MCS-90, which are not in the pack, and
    the literal asterisks;
  - moved the punitive sentence into the SC branch, with § 15-33-135;
  - left the GA branches as they were.
- **Content** (`bin/rebuild-charleston-truck-accident.php`, post 3629): SC only. It covers the
  port terminals and freight corridors (terminal names checked on scspa.com), one FARS figure
  from `data/statistics.json`, who can be responsible, the SCTCA, UM/UIM, the court, and six FAQs.
- **Legal sweep: PASS** against the signed SC pack (`data/facts/remediation-2026-09-26-charleston-truck.md`).
  Its warnings were fixed before publish:
  - FAQ 5 now carries the verified-claim extension;
  - the punitive sentence has its authority;
  - **#168** corrected the office directions. 127 King is between Broad and Queen, not near
    Calhoun. This was also live on the car and location pages.
- **Publish:** behind the #142 redirect first, then **#169** removed the redirect. Gillin's
  review is dated 2026-09-26 on the owner's word.
- **Verified live:**
  - The page returns 200, has a self canonical and the map.
  - The nested URL and 2 legacy URLs each 301 to it in one hop.
  - 22 internal links restored across 14 posts (11 skipped: retired posts).
  - JSON-LD guard PASS; `content/meta.json` regenerated.
  - **Doorway 157 / 671 = 23.40% PASS.**

**Open:**
- "Cases successfully handled" in the stats block (carried over from the car sweep).
- FMCSA, and the broker liability authority from *Montgomery v. Caribe Transport II* (U.S.
  2026), are proposed as pending authorities for Gillin's next packet. Which pack holds federal
  law is undecided.
- The GA truck-pillar branch still carries the drafting note "verify current posture before
  filing"; it is for the GA reviewer.

### SC law pack signed by Graeham C. Gillin — 2026-09-26

**Owner, 2026-09-26:** "consider the SC pack signed by Gillin", then "Gillin's sign off confirmed".
Recorded in internal-ai-scripts **#65** (`cf4a43b`): `signOff` is set to signed, attorney Graeham
C. Gillin, 2026-09-26, and `verifiedBy` is set on all 27 authorities.

- **Two authorities added first (#64):** § 56-5-1260 (immediate police notice for injury or death
  crashes) and § 56-5-1270 (DMV report within 15 days when no officer investigated). Both were
  read against scstatehouse.gov the same day.
- **`SC 22-3-10` had never been verified.** It was read against the statute before the signature
  (concurrent magistrate jurisdiction up to $7,500), and the owner confirmed the sign-off covers it.
- **What the signature changes:** the FAQ gate can now accept SC authorities as the source for new
  claims, and the SC pack is no longer advisory.
- **Open:** internal-ai-scripts #62 adds SC authorities with `verifiedBy: null`. It needs to move
  them to `pendingAuthorities[]` (or have them re-signed) before it merges.

### Charleston car accident page rebuilt and live — the first office practice page, 2026-09-26

**Owner's decisions, 2026-09-26:** rebuild `/car-accident-lawyers/charleston-sc/` as a South
Carolina–only page with the King St map, and reopen Rule 6 for an allowlist. **"Gillin has
reviewed all of this"** is recorded as his review, with today's date in `_roden_last_reviewed`.

**Shipped:**
- **#162** — allowlist `roden_office_practice_allowlist()`, the office/map block on
  `template-intersection.php`, and the "All Locations" grid hidden below two siblings. Theme
  version 1.4.30; es_ES +2 strings.
- **Content** — `bin/rebuild-charleston-car-accident.php` wrote post 3624 while it was still a
  draft. Statutes come only from `law/SC.json`; there is no punitive figure and no crash
  statistic.
- **Legal sweep** (`data/facts/remediation-2026-09-26-charleston-car.md`): **FAIL**. The one
  error and the blocking warnings were all in *shared* template text, not the page's copy.
- **#163 fixed the shared template text:**
  - The Charleston and North Charleston office essays (EN and ES) told readers the SC Tort Claims
    Act has "shorter notice deadlines". It has none; the sentence is removed.
  - The 2,500 / 354 crash statistics, which were removed from post bodies on 08-25, are removed
    here too.
  - "only Level I" is dropped.
  - The unsourced court-procedure claims are cut.
  - The deadline widget now reads "usually ends".
  - `_roden_pillar_compensation_intro` is added to the meta export; no sweep could see it before.
- **Car pillar intros, DB** (`bin/fix-car-pillar-intros.php`, two passes). The first pass
  applied the sweep's corrections. The second narrowed them to statements already on the page
  Gillin reviewed, so nothing unreviewed was published. The SC text is inside `{{SC}}`.
- **Two unsupported marketing lines** removed from the page copy.
- **Publish** (`bin/publish-charleston-car-accident.php`): published behind the #143 redirect
  first, then **#164** removed the redirect.
- **Verified live:**
  - The page returns 200, has a self canonical and the map.
  - The nested URL and 10 legacy URLs each 301 to it in one hop.
  - It is in the sitemap.
  - JSON-LD guard PASS; `content/meta.json` regenerated.
  - **Doorway 156 / 670 = 23.28% PASS.**
- **Links in:** `bin/restore-charleston-car-links.php` restored **72** of the 82 anchors that #143
  repointed to the pillar, across 66 posts. The other 10 were in retired posts or in one post
  edited since. Backup: `docs/backups/charleston-car-links-restore-2026-09-26.json`.

**Open from the sweep (not blocking; the owner decides):**
- W7: the what-to-do step 5 police-report wording (both states, HowTo).
- W8: "170+ verified Google reviews" and "successfully handled" vs the writer profile.
- W9: Nolan Alexander (Of Counsel, Charleston) is on the page but not in `client.json`.
- W10: a Georgia moped link in the resources block.
- W12: the case-results grid shows non-car results.
- The Savannah, Darien and Columbia office essays carry the same "only Level I" and court-procedure
  patterns. Fix them before those offices' wave-1 pages.

### The two Spanish office hubs retired — 2026-09-26

**Owner's instruction, 2026-09-26:** "retire (but don't delete) those two spanish pages".
The pages are `/es/locations/georgia/darien/` (4869) and `/es/locations/south-carolina/north-charleston/`
(4883). Both had 0 clicks in 16 months and under 100 impressions in 90 days. They were held out
of #159 because they are office hubs. Each now 301s to its English office hub, via
`roden_dead_es_hub_urls()` (#160, `a3e2928`).

**Applied 2026-09-26:**
- **Relink:** 4 links across `/es/` (4862) and `/es/locations/` (4864). Backup:
  `docs/backups/dead-es-hub-relink-2026-09-26.json`.
- **Removal:** 2/2 drafted and marked `_roden_retired`; the table read-back shows draft.
  Backup: `docs/backups/dead-es-hubs-2026-09-26.json`.
- **Verified live:** 2/2 single-hop 301 → 200.
- **hreflang:** the English hubs no longer point at the Spanish URLs.
  `roden_get_translation_id()` only pairs published posts.
- **Doorway: 157 / 671 → 155 / 669 = 23.17%, PASS.** JSON-LD guard PASS.
  `content/meta.json` `_count` 664 → 662.

**Defect found and fixed (#161, `f65c059`).** The body relink could not reach the Spanish
menu, footer, contact page or homepage. Those build `/es/locations/…` from firm data, so every
`/es/` page still carried four sitewide links to the 301s. `roden_office_url()` now links a
Spanish hub only while its `es-{city}` post is published, and otherwise the English hub. After
the deploy and flush: 0 references on `/es/`, `/es/locations/`, `/es/contact/`, a Spanish office
page and `/es/practice-areas/`, and the four live Spanish hubs are still linked. **A body
relink does not cover template-built links. Grep the rendered pages as well.**

### SC punitive floor corrected across content — 2026-09-26

Gillin's approved pattern (review item 1): keep each page's wording and pair the figure with
the index and the current amount. Each unindexed "$500,000" became **"$739,245, the 2026
inflation-indexed figure"**, which reads correctly before a citation, a comma or more prose.
- `bin/fix-sc-punitive-floor.php`: **32 replacements on 21 posts** (23 bodies, 9 FAQ answers).
  That is the sweep's 29 plus 3 the dry run found in the same claim class: a second table
  cell on 1669, a 4349 FAQ that writes "section 15-32-530", and a reversed "greater of
  $500,000 or three times" sentence on 4360. Bodies written straight to the column, FAQs via
  `update_post_meta( wp_slash() )`, all read back. Backup:
  `docs/backups/sc-punitive-floor-2026-09-26.json`.
- `bin/fix-sc-punitive-floor-meta.php`: two statements the sweep never reported, in the
  **med-mal pillar's FAQ 5** (3608) and the **"Punitive damages" glossary term** on 1663 (also
  published as DefinedTerm). The Georgia half of that term gained "in most cases". Backup:
  `docs/backups/sc-punitive-floor-meta-2026-09-26.json`.
- **Verified:** a fresh sweep shows 0 `sc-punitive-floor-unindexed` findings. A regex pass over
  every published body, excerpt and meta value finds no unindexed statement left; its three
  hits (1663, 1756, 1790) already name the index later in the sentence. The live med-mal pillar
  and 1663 carry $739,245 in their FAQPage/DefinedTerm JSON-LD. JSON-LD guard PASS.
  `content/meta.json` regenerated.

**Rule gap, for the legal-accuracy lead:** the rule's `unless` is evaluated over the whole
field, so the med-mal pillar FAQ escaped because another sentence in the same answer says
"adjusted annually for inflation" (about the § 15-32-220 cap). It should be scoped to the
sentence that asserts the claim. The sweep also missed the reversed "greater of $500,000 or
three times" order in one sentence on 4360.

**Every February:** $739,245 becomes stale when the RFA publishes. The rule's `unless` accepts
"739,245", so it will not catch that. The annual update has to be deliberate: this table
cell, the med-mal caps, and these 34 content statements.

**Still open, older findings, not this work:** the sweep reports 4 findings under other rules:
`county-ante-litem-6-months` (2), `municipal-ante-litem-12-months`, `sctca-mandatory-notice`.

### SC items approved by Gillin; the full comparison table ships — 2026-09-26

**Owner, 2026-09-26: "Gillin approves these."** That is the SC wording in the review email
(items 1 and 3–9), as proposed: keep the $739,245 figure and update it each February. Items 10
(does § 15-3-545 reach nursing-home claims) and 11 (maritime fault on the boating pillar) were
questions, not proposals, so those cells are unchanged. Item 12: the rule stays at error; it
is moot once the 26 pages are fixed.

`roden_jurisdiction_comparison_table()` rebuilt as a list of rows, every cell as approved:
- **General pillars:** deadline; comparative fault (SC now "50% or less", citing *Nelson*);
  Compensatory Damages Cap; Punitive Damages Cap (SC $739,245, 2026, indexed); Minimum Auto
  Insurance (motor-vehicle pillars, both cited); Filing Court (no dollar floors).
- **Medical malpractice:** repose in both deadline cells; GA compensatory cites *Nestlehutt*;
  SC non-economic caps $596,001 / $1,788,002.
- **Nursing home:** SC compensatory cell with the malpractice and charitable caps.
- **Wrongful death:** SC deadline runs from the date of death.
- **Workers' comp:** its own six rows (claim deadline, notice, fault, damages, punitive, where
  to file). **Maritime:** still no table.
- **Source line:** "Sources: Georgia and South Carolina statutes and court decisions, as cited
  in each row."
- **Spanish:** 33 new strings, `es_ES.mo` 611 entries. Rendered in memory on prod for eight
  pillars before merge.

**Annual maintenance:** each February, when the RFA publishes, the SC punitive floor
($739,245) and the med-mal caps ($596,001 / $1,788,002) change. Update the cells and the
Spanish.

### Georgia comparison-table items approved; the SC-independent ones shipped — 2026-09-26

**Owner, 2026-09-26: "The georgia items have been approved in the remediation plan."** This is
Roden's sign-off for every Georgia cell in `data/facts/remediation-2026-09-26.md`. Shipped
because they stand without an SC cell:
- **Medical-malpractice pillar, GA deadline:** "2 years; 5-year repose (O.C.G.A. § 9-3-71)", in
  place of the bare citation. Spanish: "2 años; plazo máximo de 5 años (O.C.G.A. § 9-3-71)".
- **Minimum Auto Insurance:** the GA cell cites O.C.G.A. § 33-34-4, and the row renders only on
  the motor-vehicle pillars (car, truck, motorcycle, bicycle, pedestrian, e-scooter, e-bike).
  Hiding it elsewhere removes the SC cell there, so it states nothing new about SC.
- **Spanish heading:** "Leyes de Abogados de Negligencia Médica" → "Leyes de Negligencia Médica".

**Staged until Gillin approves the SC side:** the Compensatory and Punitive Damages Cap rows,
Filing Court, and the workers' comp table. Each pairs an approved GA cell with a pending SC
one, and the table cannot show one without the other. The source-line change goes with them,
since the new rows are the ones that cite cases.

### Who signs law for Roden content; a competitor link removed — 2026-09-26

**Owner, 2026-09-26:** Georgia claims on rodenlaw.com are signed off by **Graeham Gillin or
Eric Roden**, the same as South Carolina (Gillin's rule, 2026-09-23). A shared law pack's
signature is not approval for Roden content. The Georgia items in
`data/facts/remediation-2026-09-26.md` go to Gillin or Eric Roden before they publish.

**A live post linked to a competing firm.** `/blog/how-poor-truck-maintenance-causes-charleston-accidents/`
(3531) sent readers to a competitor's contact page ("broader resources like the team at …")
before offering Roden's. Retired draft 3528 linked "contacting a personal injury attorney" to
the same page. Both are removed with `bin/remove-competitor-links.php`: 3531 keeps only
Roden's contact link; 3528's link is unwrapped. Backup:
`docs/backups/competitor-links-2026-09-26.json`. A sweep of every post body, meta value,
excerpt and option for competitor and other outside firm names found no other instance.

### Comparison table: false rows removed pending sign-off — 2026-09-26

**Owner, 2026-09-26: "apply the fixes when it's done".** The legal-accuracy lead verified every
cell of `roden_jurisdiction_comparison_table()` against primary text
(`data/facts/remediation-2026-09-26.md`; pack PR internal-ai-scripts #62). Findings:
- Both **Filing Court** cells are false. GA: $15,000 is the magistrate ceiling (§ 15-10-2);
  superior and state courts have no floor. SC: magistrate jurisdiction is concurrent up to
  $7,500 (§ 22-3-10); circuit court is general.
- **Damage Cap, compensatory**, false unqualified in both states (government caps). The SC cell
  is false outright on the medical-malpractice and nursing-home pillars (§ 15-32-220).
- **Damage Cap, SC punitive.** The #151 wording is still wrong: § 15-32-530(D) indexes the
  $500,000 floor, which is **$739,245 for 2026**.
- **Workers' comp and maritime pillars.** The tort rows are wrong there; maritime showed the
  federal Jones Act and Longshore periods under "Georgia" and "South Carolina".
- **Deadlines, comparative fault, 25/50/25 minimums:** correct. The deadline cells rendered a bare
  citation with no period.

**What shipped**, which removes every false claim and adds none that needs sign-off:
- the Damage Cap and Filing Court rows are removed;
- the table is suppressed on the workers' comp and maritime pillars (and their `es-` twins);
- deadline cells print "N years (cite)" from the statute resolver when the pillar meta is the
  general citation (39 pillars). Practice-specific meta (med-mal § 9-3-71 / § 15-3-545,
  boating's admiralty note) renders exactly as before, because the resolver would print the
  wrong statute there.

Rendered in memory on prod for car, med-mal, boating, ES med-mal, WC and ES maritime before
merge.

**Held for sign-off, per the owner's 2026-09-23 rule** (anything stating SC law is reviewed by
Gillin; the new GA authorities sit in the pack's `pendingAuthorities` until an attorney signs them):
- the corrected Damage Cap and Filing Court rows;
- the per-practice variants (med-mal repose and caps, nursing home, SC wrongful-death SOL, a
  full workers' comp table);
- the SC comparative-fault wording "50% or less (Nelson)";
- auto-insurance citations, and limiting that row to motor-vehicle pillars.

All exact wording is in the plan.

**Also open:** 26 content pages (34 hits, 12 in FAQs that also publish as structured data)
still state the unindexed SC $500,000 punitive floor. The new pack rule
`sc-punitive-floor-unindexed` blocks publishes touching them at error level; Gillin should rule
error vs. warn.

### Two "updated this month" stamps, and a false SC punitive-damages claim — 2026-09-25

**Owner, 2026-09-25: "yes"** to replacing the stats block's always-current date. The same
class had a second instance, and that one surfaced a false legal claim:
- **Stats block ("Results at a Glance", every pillar).** "Source: … updated <month>" printed the
  current month on every render. It now prints `trust_stats['stats_as_of']` = **2026-08**: GBP
  review counts and rating checked live 2026-08-19, $300M+ confirmed by the firm 2026-08-26.
  `cases` and `experience` are firm-reported with no separate date, and the firm-data comment
  says so. Bump it only on a real re-check.
- **GA/SC comparison table (every pillar).** "Source: Georgia Code (O.C.G.A.) and South
  Carolina Code of Laws. Verified <current month>." No record shows the table as a whole was
  ever verified, so the line now names its sources and no date.
- **The table's SC "Damage Cap" cell said "no statutory punitive cap (jury discretion)". That
  is false.** S.C. Code § 15-32-530 caps punitive damages at the greater of 3x compensatory or
  $500,000, with the (C) exceptions (fact base: `docs/briefs/2026-09-03-sc-punitive-damages-cap.md`).
  The 09-03 remediation fixed content and never reached this theme string, which was live on
  every English and Spanish pillar with a "Verified <this month>" stamp under it. Now: "No cap
  on compensatory damages; punitive damages capped at the greater of 3x compensatory damages or
  $500,000, with exceptions (S.C. Code § 15-32-530)". Spanish re-added and `es_ES.mo`
  recompiled: 576 entries, only these two changed.
- Claim-class sweep of every published post body, meta value and excerpt found five other
  punitive-cap statements. All are accurate: the GA $250,000 cap with its intent and impairment
  exceptions (FAQs 1790 and 2586, post 3493), GA product liability uncapped with the 75% state
  share (pillar 3615), and SC "the punitive cap can disappear entirely" (4858, per (C)).

**For the legal-accuracy lead, not fixed here:** the same table's "Filing Court" row says
"Superior Court (claims over $15,000)" and "Circuit Court (claims over $7,500)". Georgia's
superior courts have no dollar floor ($15,000 is the magistrate-court ceiling). The "No cap on
compensatory damages" cells render on the medical-malpractice pillar too, where SC's
non-economic cap (§ 15-32-220) applies. Both need a pack check before they are reworded.

### Office count corrected to six — 2026-09-25

**Owner, 2026-09-25: "there are 6 offices"** (Savannah, Darien, Charleston, North Charleston,
Columbia, Myrtle Beach; `inc/firm-data.php` already held 6). The site said 5 in seven places:
- **Theme:** the "Results at a Glance" stats block, "Combined attorney experience across 5
  office locations", on every pillar; the practice-area archive, "We serve clients from 5
  locations"; the theme description. Both front-end strings now take the count from
  `trust_stats['offices']`, and the Spanish is updated with the same placeholder. `es_ES.mo`
  was recompiled locally; the catalog is still 576 entries, with only those two swapped.
- **Content:** four post bodies said "five offices" (1816, 1703, 1712, 1715). Post 1712 also
  listed the five by name and left out North Charleston; it now lists all six. Applied by
  `bin/fix-office-count.php` with exact-match fragments, direct column write and read-back.
  Backup: `docs/backups/office-count-2026-09-25.json`.
- A sweep of every published post body, meta value, excerpt and option found no other
  instance, in English or Spanish.

Still open on the same block: its "Source: … updated <month>" line prints the current month
on every render, so it always claims to be fresh.

### Zero-click scenario pages — decided 2026-09-25

**Owner's instruction, 2026-09-25:** "run step 2 and retire the 64 pages". That is step 2 of
`docs/scenario-pages-plan-2026-09-25.md`. 64 of the 182 practice-area scenario pages have 0
clicks in 16 months on 40,587 impressions, all published in the March 2026 rebuild. The two
zero-click pages near page one stay (`jogger-runner-accident`, `medical-malpractice-death`).
Each retired page goes to its pillar. Doorway ratio after: **171 / 685 = 24.96%**, which leaves
no headroom for retiring any further non-place page.

Pre-flight 2026-09-25: all 64 published, no children, no Spanish twins; 35 linked from 78
posts, rewritten flat and nested (85 links across 55 posts, dry run); 54 `_roden_see_also`
references, which resolve through the map at render (`roden_resolve_see_also_url()`), so none is
rewritten. Two existing legacy redirects pointed INTO the set
(`/blog/amazon-fedex-delivery-crashes/` → delivery-vehicle-accident,
`/workers-compensation-lawyers/warehouse-logistics-injury/` →
warehouse-distribution-injury). Both are repointed straight to the pillar, so neither becomes a
chain. Map in `roden_zero_click_scenario_urls()`. Pages go to draft with `_roden_retired`.

**Applied 2026-09-25.** Step 1 (#148, `51fbb40`) verified first: 182/182 scenario pages
render the rules box, none renders the old sections, HowTo is still present on all 182, and
the JSON-LD guard passes. Then step 2 (#149, `6c6a435`):
- Relink: 85 links across 55 posts, flat and nested, `post_modified` untouched. Backup:
  `docs/backups/zero-click-scenario-relink-2026-09-25.json`.
- Removal drafted all 64 and marked them `_roden_retired`; the database shows 64 draft and 64
  marked. The script reported four as FAILED (4107, 4108, 4109, 4114): its read-back used
  `get_post_status()`, and WP Engine's object cache still returned `publish`. It now reads
  the table, here and in `remove-stale-place-pages.php`. Backup:
  `docs/backups/zero-click-scenarios-2026-09-25.json`.
- Verified live: **128/128** (64 flat + 64 nested) single-hop 301 to the pillar; all 18 pillars
  return 200; both repointed legacy URLs 301 in one hop.
- The pillar sweep found one link the relink cannot reach: truck pillar 3605 links the
  18-wheeler page from `_roden_why_hire`, meta rather than body. A sweep of every published
  meta value for all 139 URLs retired today found only that one. It is unwrapped with the
  anchor text kept, written through `wp_slash()` and read back. Backup:
  `docs/backups/zero-click-scenarios-meta-unwrap-2026-09-25.json`. **Relink scripts only see
  `post_content`; sweep meta too.**
- **Doorway 171 / 685 = 24.96%, PASS.** JSON-LD guard PASS. `content/meta.json` 742 → 678: the
  64 removed, plus the one changed truck-pillar entry.

### Stale place pages — decided 2026-09-25

**Owner's approval, 2026-09-25:** retire the whole round in `docs/cull-evidence-2026-09-25.md`,
keeping Brunswick. That is 75 URLs: 29 sub-municipal location pages and 46 local-SEO pipeline
street/place posts (41 EN, 5 ES).

It reverses two earlier calls, both made on 16-month totals: "the blog protection stands"
(09-18, which kept every place post that had earned a click) and "the location hubs are
legitimate" (09-19). The totals hid the collapse. The pipeline posts earned 82% of their 340
clicks in May–June and 5 in the four weeks to 09-21; the town pages 81 in 16 months and 9
recently. The CTR-at-position test is inconclusive (samples of 21 and 13 clicks), so the case is
volume, trend and ratio, not refusal. Doorway ratio **29.49% → 22.83%**.

Shape, as 09-18: a post goes to the practice pillar its slug names (`/es/` twin to the `/es/`
pillar); a town page goes to its parent office page. Map in `roden_stale_place_urls()`; both
scripts read it. **Pages are set to draft, not trashed** (see the trash-to-draft entry below).
Pre-flight 2026-09-25: no published children; all 5 live Spanish twins in the batch; 52 links
across 22 outside posts to relink; 0 meta references; no existing redirect points into the set;
every target published. Pre-deploy dry run of both scripts, with the map function prepended:
75/75 IDs, types, paths and statuses match.

**Applied 2026-09-25.** PR #147 merged (`630100e`), deploy run 36191064328 succeeded.
- Relink applied: 52 links across 22 posts, href only, direct column write, `post_modified`
  untouched. Backup: `docs/backups/stale-place-relink-2026-09-25.json`.
- Removal dry run reported no link debt. Apply **drafted 75/75**, with full content and meta
  backed up to `docs/backups/stale-place-pages-2026-09-25.json`. Caches flushed.
- Verified live: **75/75 single-hop 301 to the mapped target, all 19 targets 200.** No links to
  the retired URLs on 27 swept pages: the 19 targets, home, blog index, locations hubs,
  Brunswick, `/es/`, resources. Live JSON-LD guard PASS.
- **Doorway ratio 171 / 749 = 22.83%, PASS.**
- `content/meta.json`: the export includes drafts on purpose (content about to publish), so
  the first regeneration pulled in all 330 retired drafts (817 → 1,072). Retired drafts now
  carry `_roden_retired`: the 255 restored earlier, these 75, and anything future removal
  scripts draft. `bin/export-content-meta.php` skips them. Regenerated: **817 → 742**, exactly
  the 75 removed, nothing else changed. To republish a retired page, delete its
  `_roden_retired` along with its redirect-map line.

### Retired pages moved from trash to draft — 2026-09-25

**Owner's instruction, 2026-09-25.** Every batch so far *trashed* its pages, on the
assumption they stayed "recoverable by ID". They do not: WordPress empties the trash after
`EMPTY_TRASH_DAYS` (30 on this host). **The 08-21 and 08-25 batches were already purged from
the database** and survive only as the JSON in `docs/backups/`, which holds content, excerpt,
meta, permalink and redirect target. There is no restore script yet, and a rebuilt page gets
a new ID.

The 255 still in the trash (09-18: 202; 09-19: 53) were due to purge around Oct 18–19. They
are now **drafts**, applied with `bin/restore-trash-to-draft.php`:

- 60 posts, 176 practice_area, 13 location, 6 page. All were published before being trashed.
  Original slugs restored from `_wp_desired_post_slug`, with 0 collisions. Trash markers cleared.
- Written straight to `post_status`/`post_name`, not through `wp_untrash_post()`, whose
  `wp_insert_post` path runs the `wp_insert_post_data` guardrails and could rewrite content.
- Four older trashed items with no trash timestamp were left alone: media-plugin folder 677,
  "Who We Are" page 1985 (slug `attorneys`), duplicate post 3491, Park Circle location 3779.
  The purge never touches them.
- Backup: `docs/backups/trash-to-draft-2026-09-25.json`.

Verified after apply: 0 timestamped posts left in trash. **255/255 retired URLs still 301 to
the same target** (the redirects match the request path, not post status). Sitemap
unchanged at 824 and doorway ratio unchanged at 29.49%, so no draft leaked into anything
public.

**From here, retirement batches set pages to draft, not trash.** To bring one back: remove
its redirect-map line, check the doorway ratio, publish. The location freeze
(`inc/content-guardrails.php`) still blocks publishing a location without the switch.

### Case results folded into one page — decided 2026-09-25

**Owner's instruction, 2026-09-25:** fold every case result into a single, filterable page.
It overrides the plan §2 guardrail as far as single URLs go (plan amended the same day). The
results themselves all stay on the site.

Evidence (`docs/gsc-audit-90d-2026-09-23.md` 09-25 addendum; search data pulled 2026-09-25):

| | URLs | 16-month clicks | Impressions |
|---|---:|---:|---:|
| `/case-results/{slug}/` singles | 156 (104 ever shown) | **2** | 716 |
| `/case-results/` page | 1 | 21 | 9,840 |
| old-site `/case-result/{slug}/` (already 301ing) | 115 seen | 21 | 3,881 |
| legacy `/blog/case-result/{slug}/` | 156 | 0 | 0 |

A rendered sample of 20 singles: median 129 words, **84% template**, about 20 unique words each.
The data behind them is amount + result type + a category held only in the title; 0 of 156
have a description, body, practice or location term, or Spanish twin, and 1 names an
attorney. 86 posts sit in 24 groups identical on amount and type.

Shape:
- `page-case-results.php` renders all 156 server-side, largest first, each as
  `<li id="{slug}">`, with case-type / result / amount filters. The filter bar is `hidden`
  until JS runs, so without JS every result shows. The featured card, the 20-card grid with
  AJAX Load More, and the separate text index are gone; one list replaces all three.
- Every single URL 301s to its anchor in one hop: `/case-results/{slug}/`,
  `/blog/case-result/{slug}/` (all 156 now, including the 27 batch (f) left serving) and
  old-site `/case-result/{slug}/`. The legacy slug drifts (`-truck-accidents`, `mva-`,
  `workers-comp-`) are resolved. Dry run against prod: 152/156 legacy and 115/115 old-site
  slugs land on an anchor; the other 4 (`2969`, `100000-recovery-animal-attack` titled
  $130,000, `200000-policy-limit-auto-accident`, `75000-recovery-truck-accident`) land on the
  page.
- `case_result` dropped from the sitemap and from site search. Result strips elsewhere link
  to the anchors, and `llms.txt` lists them the same way.
- The posts are **not** trashed: they are the page's data and feed the homepage, about,
  attorney and location strips. Nothing to relink: 0 posts link a single result in
  content or meta.

**Applied 2026-09-25.** PR #146 merged (`9113cc7`), deploy run 36181718900 succeeded,
both caches flushed. Verified live, sequentially with cache-busting query strings:
- 156/156 `/case-results/{slug}/`, 152/156 `/blog/case-result/{slug}/` and 115/115 old-site
  `/case-result/{slug}/` 301 in one hop to an anchor that exists on the page. The 4 malformed
  legacy slugs land on `/case-results/`. Zero failures.
- `/case-results/` returns 200 with 156 `<li id>` anchors. The sitemap index no longer lists
  `case_result`; that sub-sitemap is 404; **sitemap 980 → 824 URLs**.
- About, attorney and location result strips link anchors, with 0 links left to singles.
  `llms.txt` regenerated with anchor links.
- Browser: an old single URL lands on its anchor, highlighted. Truck Accident shows 25;
  adding $1M+ shows 1 ($27M); adding Verdict shows 0 with the empty message; reset shows 156.
- Live JSON-LD guard PASS. `content/meta.json` regenerated with no diff; no post data changed.

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

## 2026-09-30 — Spanish pillar twins + post 1874: 59 legal fixes applied

Owner: "apply them". First legal sweep of the 23 Spanish practice-area pillar twins (never swept) and
the live GA car-seat post 1874 (data/facts/remediation-2026-09-30-es-pillars.md). 59 apply-class edits
on 23 posts via bin/apply-linked-pages-batch.php (data/facts/es-pillars-batch-2026-09-30.json); dry
run clean first, owner ran the apply. Backup: docs/backups/es-pillars-batch-2026-09-30.json. Worst
fixed: 4881 FAQ said SC has no med-mal noneconomic cap. Caches flushed; JSON-LD guard PASS;
content/meta.json regenerated. Held: 12 attorney items (Eric / Gillin), 12 Spanish template/.mo
issues (theme PR), 16-edit EN residuals batch staged (en-pillars-residuals-batch-2026-09-30.json).

## 2026-09-30 — English pillar residuals: 16 legal fixes applied

Same error classes as the Spanish batch, still live on 11 English pillars (FAQ answers only):
government-claim notice, GA city notice at 12 months, minors "tolled", unscoped "full value", SC
punitive exceptions, WC deadline/notice cites. Batch data/facts/en-pillars-residuals-batch-2026-09-30.json;
dry run clean, owner ran the apply. Backup docs/backups/en-pillars-residuals-batch-2026-09-30.json.
Caches flushed; JSON-LD guard PASS; content/meta.json regenerated. Staged, not applied:
bin/fix-pillar-meta-2026-09-30.php (4 apply-class meta fixes, dry run clean).

Meta patcher applied the same day (owner ran it): 4 edits in 3 fields; backup docs/backups/pillar-meta-2026-09-30.json; caches flushed; content/meta.json regenerated.

## 2026-09-30 — Three Georgia resource guides created as drafts

Car seat laws (6329), uninsured motorist coverage (6330), wrongful death settlement value (6331), all
resource drafts under /resources/, reviewed by Tyler Love (3730) on 2026-09-30
(data/facts/attorney-approvals-2026-09-30.md). Owner approved the "full value" wording as written and the
DUI date ("on or after May 14, 2025", SB 121). Built by bin/build-ga-resource-seeds.py; read back OK.
Not published. Post 1874 (/blog/georgia-car-seat-law-overview/) 301 decision waits on publish plus a
short SC paragraph.

## 2026-09-30 — Gillin (SC) and Tyler Love (GA) approvals applied to live pages

94 content edits on 34 posts + 4 meta edits (data/facts/approvals-batch-2026-09-30.json,
approvals-meta-2026-09-30.json; plan remediation-2026-09-30-approvals.md). Classes: GA seat-belt rule
limited to suits commenced on/after 2025-04-21 (1759 had stated the opposite); 1874 physician exception;
SC stacking to Gillin's § 38-77-160 wording; SC malpractice-death deadline to § 15-3-545; funeral and
creditor wording; nursing-home caps; motorcycle helmet lines cut to § 56-5-3660. Owner ran both applies.
Backups docs/backups/approvals-*-2026-09-30.json. Caches flushed; JSON-LD guard PASS; content/meta.json
regenerated. Review stamps left unchanged (targeted corrections). Tools: bin/apply-meta-batch.php +
bin/build-meta-batch.py (generic meta edits).

## 2026-09-30 — Georgia resource guides published; car-seat post folded in

Published /resources/georgia-car-seat-laws/ (6329), /resources/georgia-uninsured-motorist-coverage/ (6330)
and /resources/georgia-wrongful-death-settlement-value/ (6331), reviewed by Tyler Love. The car-seat guide now
links the SC car-seat guide in place of the old post's two-state comparison. Rendered-page sweep 326/326 clean.
Links added (data/facts/ga-guides-links-2026-09-30.json; backup docs/backups/ga-guides-links-2026-09-30.json):
6318 and 1757 -> UM guide, 6321 -> WD value guide. #204 redirects /blog/georgia-car-seat-law-overview/ to
the car-seat guide (deploy clean, drift guard passed); 1874 retired to draft (bin/retire-ga-car-seat-post.php).
