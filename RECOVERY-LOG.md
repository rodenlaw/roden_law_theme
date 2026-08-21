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
| *pending deploy* | **(b)** non-office city pages | 1,659 | 1,651 | 8 | Approved 2026-08-21. Redirects committed, CMS deletion prepared and dry-run clean. **Not yet applied — see ordering below.** |

### Batch (b) — the eight non-office SC town pages

Hilton Head (5331), Orangeburg (5332), Sumter (5333), Spartanburg (5334),
Rock Hill (5335), Fort Mill (5336), Greer (5337), Simpsonville (5338).

Published 2026-08-20, 129–168 unique words each, no office in any of these
markets, and **zero inbound internal links** in post content, post meta or the
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
| 2026-08-21 | Phase 0.4 — 301 tracking-parameter URLs to their clean path; utm_* parked in a cookie so intake attribution survives the redirect | `inc/legacy-redirects.php`, `inc/intake-webhook.php` |

## Update boundaries to measure against

| Update | Window |
|---|---|
| Aug 2026 spam | began 8/18 — rolling at audit time |
| *(next core)* | *the verdict this plan exists to change* |
