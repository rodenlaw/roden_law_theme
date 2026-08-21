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

Still to come: batch (a) neighbourhood/subdivision pages (88), batch (c) practice
micro-permutations (11 consolidate), batch (e) `/es/` mirror sync, batch (f) the
129 duplicate case results, and the 109 tier-3 EVALUATE rows pending the GSC
export.

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
| 2026-08-21 | **(a)** neighbourhood + subdivision | 1,617 | 1,529 | 88 | **COMPLETE.** Relink applied (53 links, 23 posts, `post_modified` preserved), redirects live, 88 posts trashed, caches flushed. Verified after deletion: 88/88 single-hop 301, no 404s; location sitemap 211 → 123. Backups: `batch-a-relink-*.json`, `batch-a-neighborhood-locations-*.json`. |
| 2026-08-21 | **(d)** non-office city×practice | 1,651 | 1,617 | 34 | **COMPLETE.** Redirects live, 34 posts trashed, caches flushed. Verified after deletion: 34/34 single-hop 301, no 404s; practice_area sitemap 449 → 415; intersection grids self-healed to pillars, zero surviving links. Backup: `docs/backups/batch-d-nonoffice-city-practice-2026-08-21.json`. |

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

## Update boundaries to measure against

| Update | Window |
|---|---|
| Aug 2026 spam | began 8/18 — rolling at audit time |
| *(next core)* | *the verdict this plan exists to change* |
