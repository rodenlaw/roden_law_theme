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

## Open discrepancy — the 250–350 acceptance criterion

Plan §4 sets an end state of ~250–350 URLs. That is not reachable while the
plan's own guardrails hold. Guardrail-protected types alone (blog, case results,
pages, resources, attorneys, testimonials, staff) are **991 URLs** before a
single location or practice page is counted. The audit's estimate of ~470
location and ~650–700 practice URLs overstated the doorway layer — the real
figure is 219 and 449, while the blog (484) went uncounted.

Full doorway cleanup lands the site at **~1,420–1,537 URLs**, removing 122
outright plus up to 117 more pending the rankings check. Either the 250–350
figure is scoped to location+practice only (where the honest end state is
418–535), or it assumed cuts the guardrails forbid. **Owner decision required
before Phase 1 batch (a) ships.**

---

## Batch log

_No batches shipped yet. Phase 1 is gated on owner approval of `url-triage.csv`._

| Date | Batch | URLs before | URLs after | Removed | Notes |
|---|---|---:|---:|---:|---|
| — | — | — | — | — | — |

## Shipped outside the batch sequence

| Date | Change | Ref |
|---|---|---|
| 2026-08-21 | Phase 0.4 — 301 tracking-parameter URLs to their clean path; utm_* parked in a cookie so intake attribution survives the redirect | `inc/legacy-redirects.php`, `inc/intake-webhook.php` |

## Update boundaries to measure against

| Update | Window |
|---|---|
| Aug 2026 spam | began 8/18 — rolling at audit time |
| *(next core)* | *the verdict this plan exists to change* |
