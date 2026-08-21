# SEO Pre-emption Plan — rodenlaw.com

**Handoff document for Claude Code.** Drop this file in the repo root (or reference it from the WordPress project) and work through the phases in order. Self-contained: all diagnosis, evidence, decision rules, and acceptance criteria are here — no prior conversation context needed.

**Prepared:** 2026-08-21 · from a forensic SEO audit (Semrush data, live-site inspection, Google update timeline)
**Companion:** georgiaautolaw.com has a parallel plan (`SEO-RECOVERY-PLAN.md` in its repo). Same owner, same playbook, same attacking link networks. That site is deep in suppression; this one is early-stage. The mission here is **pre-emption, not rescue** — ship before the next core update re-rates the domain.

---

## 1. Situation (read before touching anything)

rodenlaw.com is in the **early stage of an algorithmic quality decline** — the same trajectory that destroyed georgiaautolaw.com twelve months ahead of it. Not yet confirmed whether a manual action exists (owner must check GSC — see Phase 0). Technicals are healthy (WordPress, proper per-type sitemaps, correct canonicals, indexable robots); do not hunt for a technical bug.

**The trajectory (Semrush, US db):**

| Month | Keywords top 100 | Pos 1–3 | Est. traffic | Event |
|---|---|---|---|---|
| Nov 2024 | 3,950 | 85 | 7,280 | Traffic peak |
| Jul 2025 | 4,417 | 144 | 2,667 | Top-3 peak · Jun 2025 core hits |
| Feb 2026 | 3,953 | 71 | 1,139 | Stepped down by Jun + Dec 2025 cores |
| May 2026 | 6,971 | 145 | 3,150 | Mar 2026 core recovery high · May core begins |
| Jun 2026 | 5,993 | 98 | 2,309 | May 2026 core verdict · Jun spam update |
| Jul 2026 | 5,720 | 68 | 1,701 | Current — decline in progress |

Pattern: Google re-rates this domain at every update, each verdict harsher (top-3: 144 → 71 → recovered to 145 → cut to 68 by the May 2026 core, −53% in two months). Traffic −77% from peak even while keyword totals grew — long-tail accumulating, head terms dying. georgiaautolaw.com showed this exact oscillation for a year before the December 2025 core collapsed it. Assume the next core update delivers that verdict here **unless the site changes first**.

**Root causes, ranked:**

1. **Doorway architecture (primary risk).** ~1,500 total URLs: ~470 location pages FIVE levels deep (state → metro → suburb → neighborhood → subdivision: `/locations/south-carolina/charleston/mount-pleasant/old-village/`, `/locations/south-carolina/north-charleston/goose-creek/liberty-hall-plantation/`, `/locations/georgia/savannah/pooler/godley-station/`) + ~650–700 practice URLs including micro-permutations (`/workers-compensation-lawyers/gulfstream-aerospace-injury/`, `/car-accident-lawyers/i-26-accident/`) + `/es/` mirror. Templated place-name-swap content, verified by sampling. **Key difference from the sister site: 6 real offices** — Savannah GA, Darien GA, Charleston SC, North Charleston SC, Columbia SC, Myrtle Beach SC — so city-level pages for real markets are legitimate. The liability is everything below city level.
2. **Spam link networks — identical to the sister site.** "darksidelinks" injection network (26 domains, first seen 2026-02-24, same timestamp as on georgiaautolaw.com — one operation hit both), same PBN vendor (5 domains, Jun 2026), "quarterlinks25" Telegram network (5 domains). Plus three unexplained domain-name anchor blasts (see Phase 0 blockers).
3. **GBP tracking URLs indexed.** `/locations/south-carolina/myrtle-beach/?utm_campaign=gmb_mb` ranks in place of the clean URL; with 6 offices, expect ~6 variants.
4. **Brand-identity split.** Site says "Roden Law"; registered name and citations say "Roden + Love, LLC"; a rebrand domain (rodenlovelaw.com, currently not resolving) is being seeded into anchor text at scale.

**Site strengths to protect:** attorney profile pages already exist (`/attorneys/eric-roden/` etc.); the blog comparison cluster is the strongest non-brand asset (`/blog/compensatory-damages-vs-punitive-damages/` = 14% of traffic, `/blog/fault-vs-no-fault-car-insurance/` = 8%); Spanish city hubs have real traction (several `/es/` pages outrank English equivalents); 68 top-3 rankings still alive.

**Known stack:** WordPress. Sitemap index at `/sitemap.xml` → `wp-sitemap-posts-{post,page,attorney,practice_area,location,case_result,resource}-1.xml` + `wp-sitemap-eshubs-1.xml`. Locations and practice areas are custom post types — the cull happens in the CMS, and redirects likely via the site's redirect plugin or server config. Confirm the redirect mechanism before Phase 1.

---

## 2. Guardrails

- **Never remove or degrade:** homepage; the 6 office-city hub pages and their state parents; statewide/primary practice pages; attorney profiles; case results; the blog comparison cluster; `/es/` counterparts of all of the above; contact/about.
- **Every removed URL gets a single-hop, server-side 301.** No 404s, no chains, no client-side redirects.
- **Batched deploys with owner approval** per batch (see Phase 1 ordering). Never mass-delete in one push.
- **No new location, neighborhood, road, or permutation pages** for the duration of this project, no exceptions.
- **No domain migration.** Whatever the rodenlovelaw.com rebrand plans are, a migration during active down-rating compounds the damage. Freeze until rankings are stable for two quarters post-cleanup.
- **Do not touch the GSC disavow file except to add** (per Phase 0).
- Preserve GA/GSC verification and existing schema plumbing through template changes.
- Small labeled commits (`phase0:`, `phase1:`…), revertible.

---

## 3. Phase 0 — Urgent (this week)

Items marked **[OWNER]** cannot be done in code — surface them as a checklist to the site owner and track completion.

1. **[OWNER] Check GSC → Manual Actions** for this property. (georgiaautolaw.com was clean; confirm here. If an action exists, this plan becomes the reconsideration evidence package.)
2. **[OWNER — BLOCKER for disavow completeness] Answer the domain-ownership question:** who owns/commissioned `rodenlovelaw.com`, `policylimitscharters.com`, and `iluvgus.com`? Each got ~95–119 referring domains linking to rodenlaw.com with the bare domain as anchor text, all appearing Nov 2025–Jan 2026 — not organic velocity. If a citation/link vendor is doing this, identify and **stop them**; the darksidelinks timestamps prove one operation targets both firm properties.
3. **Build and upload the disavow file** (partial now, don't wait on #2): the clusters below are disavowable today. Reuse the georgiaautolaw disavow domain list for the shared networks — the darksidelinks and PBN clusters are the same networks; verify each domain actually links to rodenlaw.com via the GSC link export or Semrush before including. Add the quarterlinks25 sources. Hold the three domain-name anchor networks out until #2 is answered, then extend the file.
4. **Fix GBP tracking variants in code:** 301 any URL with `utm_campaign=gmb_*` (and generally strip/canonicalize `utm_*` on indexable URLs) to the clean path. Known live example: `/locations/south-carolina/myrtle-beach/?utm_campaign=gmb_mb`. **[OWNER]** update the website links in all six Google Business Profiles to clean URLs.
5. **Baseline export [OWNER]:** GSC performance by page and query (16 months) + indexed-page list; save as the before-picture for `RECOVERY-LOG.md`.

---

## 4. Phase 1 — Cut the doorway layer (weeks 2–6)

Produce `url-triage.csv` first (columns: `url, post_type, level, classification, redirect_target, reason`), enumerate from the WP post types (authoritative), cross-check against the sitemaps. Owner approves the CSV **before** any deletion.

**Classification rules — first match wins:**

1. **KEEP** — everything in the Guardrails keep-list.
2. **KEEP (office-city tier)** — location pages at city level for the 6 office markets, plus their `/es/` counterparts.
3. **REMOVE (301 → parent city page)** — every location page **below city level**: neighborhoods, districts, subdivisions, "waterfront", "historic-district", etc. (~400 URLs). These cannot be edited into legitimacy; their existence is the problem. If the parent city page is itself slated for removal, redirect to the nearest kept ancestor.
4. **EVALUATE (city tier, non-office markets)** — city pages for markets with no office (e.g. the Savannah-GA satellite towns under Darien): keep only those with real rankings/traffic or genuine service history, with honest "served from our X office" framing; 301 the rest to the state or nearest office-city page.
5. **CONSOLIDATE (practice micro-permutations)** — single-road pages (`i-26-accident`, Two Notch Road, Ashley Phosphate), single-employer pages (`gulfstream-aerospace-injury`, `savannah-port-worker-injury`), and hyper-narrow variants: merge any with real traffic into the parent practice page or convert to a bylined blog/resource post (road-safety content that earns links is fine as content, not as a lawyer landing page); 301 the rest to the parent practice page.
6. **KEEP (city×practice, office cities)** — e.g. `/truck-accident-lawyers/charleston-sc/`: defensible tier. Keep the ones with substance/rankings; flag thin ones for rewrite in Phase 2 rather than deletion.
7. **REMOVE (city×practice, non-office cities)** — 301 to the statewide practice page.
8. **MIRROR RULE (`/es/`)** — Spanish pages live or die with their English counterpart, EXCEPT: any `/es/` page currently outranking or out-earning its English twin is kept regardless. Verify reciprocal hreflang on all survivors.

**Execution order (batches):** (a) sub-neighborhood + neighborhood location pages, (b) non-office city pages failing rule 4, (c) practice micro-permutations, (d) non-office city×practice, (e) `/es/` mirror sync. After each batch: delete the CMS entries so pages can't regenerate, strip internal links to removed URLs (menus, footers, "areas we serve" blocks, related-links modules), regenerate sitemaps.

**Acceptance criteria:** end-state ~250–350 URLs, every URL classified exactly once, zero internal 404s, zero internal links resolving through 301s, sitemaps contain only 200-status canonical URLs, spot-check 20 removed URLs → single-hop 301 to a sensible target.

---

## 5. Phase 2 — Consolidate strengths (weeks 4–10)

1. **Six flagship city hubs:** office photos, address/hours matching GBP exactly, the attorneys who practice there (linked profiles), county courts/venues, real case results from that market, embedded GBP reviews. If two hubs read identically with the city swapped, rewrite until they don't.
2. **Blog comparison cluster expansion:** the damages/insurance comparison posts are the site's best non-brand asset. Add attorney bylines + "reviewed by [attorney]" to all legal-claims posts; build out the cluster (statute of limitations by state, GA vs SC fault rules, settlement timelines) instead of location pages.
3. **Schema pass:** `LegalService` + `LocalBusiness` NAP for the 6 real offices only; `Person`/`Attorney` on profiles; `author` wired to bylines; `FAQPage` only where page-unique.
4. **Brand alignment [OWNER decision]:** one name everywhere — site currently says "Roden Law", registrations/citations say "Roden + Love, LLC". Align site, GBP, and citations to the chosen name. Domain migration stays frozen per Guardrails.

---

## 6. Phase 3 — Measure across updates (ongoing)

1. Create `RECOVERY-LOG.md`: date shipped per batch, URL counts before/after, KPI baseline — **pos 1–3 count = 68 (Jul 2026)**, est. traffic 1,701, keywords 5,720.
2. After each confirmed Google core/spam update completes, append a KPI snapshot. **Success = pos 1–3 holds or climbs through the next core update instead of halving again.** Judge nothing between update boundaries.
3. If the next core update still steps the site down despite shipped cleanup, do NOT re-add pages; escalate to a content-quality pass on the survivors instead.

---

## 7. Already done / open items

- ✅ Full audit published (2026-08-21): https://claude.ai/code/artifact/87212b51-04b3-4712-bdbd-97bb1cb2cc7d
- ✅ Sister-site (georgiaautolaw.com) disavow uploaded 2026-08-21; its recovery plan exists separately — do not mix the two repos' work.
- ⬜ GSC Manual Actions check for rodenlaw.com — **not yet confirmed**.
- ⬜ rodenlaw.com disavow file — **not yet built/uploaded** (Phase 0 item 3).
- ⬜ Ownership answer on rodenlovelaw.com / policylimitscharters.com / iluvgus.com — **blocker** for disavow completeness and vendor shutdown.

## 8. Reference — evidence samples

- Doorway examples: `/locations/south-carolina/charleston/mount-pleasant/old-village/` (sampled: ~1,300 words, place-name-swap template, no nearby office), `/locations/south-carolina/north-charleston/goose-creek/liberty-hall-plantation/`, `/locations/georgia/savannah/pooler/godley-station/`, `/locations/south-carolina/myrtle-beach/little-river/waterfront/`.
- Micro-permutation examples: `/workers-compensation-lawyers/gulfstream-aerospace-injury/`, `/workers-compensation-lawyers/savannah-port-worker-injury/`, `/car-accident-lawyers/i-26-accident/`, `/resources/two-notch-road-truck-accidents-columbia/`.
- Spam anchor evidence: "join our telegram https://t.me/s/darksidelinks" (26 domains, first seen 2026-02-24 — identical to sister site); PBN vendor sales-copy anchor (5 domains, Jun 2026); "our telegram chanel https://t.me/s/quarterlinks25" (5 domains); domain-name anchor blasts: rodenlovelaw.com ×119 domains, policylimitscharters.com ×95, iluvgus.com ×22 (Nov 2025–Jan 2026).
- Traffic concentration: homepage 35%, compensatory-vs-punitive post 14%, fault-vs-no-fault post 8%, `/truck-accident-lawyers/charleston-sc/` 3%, Myrtle Beach GBP-utm URL 3%.
- Google updates through audit date: Jun 2025 core (6/30–7/17), Aug 2025 spam (8/26–9/22), Dec 2025 core (12/11–12/29), Mar 2026 spam (3/24–3/25), Mar 2026 core (3/27–4/8), May 2026 core (5/21–6/2), Jun 2026 spam (6/24–6/26), Aug 2026 spam (began 8/18, rolling at audit time).
