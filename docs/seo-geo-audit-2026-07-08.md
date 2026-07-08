# SEO/GEO Audit — rodenlaw.com (Production WP)

**Date:** 2026-07-08 (afternoon — post-deploy of audit items #1–#8)
**Scope:** Live production checks: technical baseline, verification of this morning's technical-audit fixes, plus the GEO layer (AI-crawler access, llms.txt, JSON-LD coverage by template, FAQPage/answer-first signals).
**Relationship to `technical-seo-audit-2026-07-08.md`:** this run re-verified that audit's findings against the live site after today's fix deploys, then extended into GEO/AI-search coverage the morning audit didn't touch.

---

## Executive summary

The technical foundation remains excellent and **6 of the morning audit's 8 fixes are verified live**. The GEO fundamentals are unusually strong for a law-firm site: every major AI crawler explicitly allowed, `llms.txt` (12.9KB) + `llms-full.txt` (69.7KB) live, and the core money templates (pillars, silo intersections, locations, blog, resources) all carry FAQPage + LegalService/LocalBusiness schema.

The new findings cluster in two places:

1. **The class-action section is invisible to both Google and AI engines** — 14 live child pages not in any sitemap, breadcrumb-only schema, keyword-less titles, zero presence in llms.txt/llms-full.txt.
2. **Three former landing pages 404 with no redirect** — `/truck-accident-lawyers-columbia-sc/`, `/truck-accident-lawyers-near-me/`, `/south-carolina-rear-end-accident-lawyer/` (all had routes in the Next.js mirror, so they were live pages at some point). Not covered by `legacy-redirects.php` and not in the June 404 audit.

---

## Verification of this morning's fixes (live checks)

| Finding | Status live | Evidence |
|---|---|---|
| F1 `/es/blog/` hub | ✅ FIXED | Self-canonical, Spanish title ("Blog de Lesiones Personales"), reciprocal hreflang with `/blog/`, `/es/blog/page/2/` = 200, present in `wp-sitemap-eshubs-1.xml` |
| F2 EN blog schema locale leak | ✅ FIXED | Blog JSON-LD mainEntity now lists 10 EN post URLs, zero `/es/` |
| F3 legacy Yoast sitemaps | ✅ FIXED | All three 301 → `/wp-sitemap.xml/` |
| F4 location titles | ✅ FIXED | "Irmo, SC Personal Injury Lawyers – Roden Law" pattern confirmed on 3 samples |
| F5 duplicate locations | ✅ FIXED | Deeper twins + self-child pages all 301 to canonical variants (6/6) |
| F6 hub hreflang | ✅ FIXED | `/practice-areas/`, `/locations/`, `/resources/` emit en/es/x-default; ES targets (`/es/practice-areas/` etc.) all 200 |
| F7 ES nav/footer links | ✅ MOSTLY FIXED | Footer on `/es/` has zero EN links; one residual EN link to `/locations/south-carolina/` remains in the page body/nav |
| F8 case-result titles | ⚠️ NOT RESOLVED LIVE | 8 identical `$100,000 Settlement \| Auto Accident – Roden Law` titles still live. Code ships a location-term suffix (232a1ba dropped the year fallback) but the terms are empty on all 156 posts — **this is now an editorial task, not a code task** |

---

## GEO layer — what's healthy (verified)

| Area | Result |
|---|---|
| AI crawler access | robots.txt explicitly allows GPTBot, OAI-SearchBot, ChatGPT-User, PerplexityBot, Perplexity-User, ClaudeBot, Claude-SearchBot, anthropic-ai, Google-Extended, Applebot-Extended, cohere-ai, Amazonbot, Bytespider |
| llms.txt | 200, text/plain, 12.9KB — firm credentials, practice areas, offices, attorneys, jurisdiction facts, En Español section, citation guidance |
| llms-full.txt | 200, 69.7KB, same section structure at depth |
| Pillar pages | LegalService + Person + FAQPage + WebPage + BreadcrumbList |
| Silo intersection pages (enriched) | FAQPage + HowTo + LegalService + LocalBusiness/LawFirm + Person + WebPage (sampled: truck/columbia-sc, car/savannah-ga, dog-bite/charleston-sc) |
| Location pages | LocalBusiness/LegalService/LawFirm + FAQPage |
| Blog posts | BlogPosting + FAQPage |
| Resource posts | BlogPosting + FAQPage + Key Takeaways box present (sampled 2) |
| ES deep pages | LegalService + FAQPage (sampled SC car-accident ES twin) |
| SC statewide LP | LegalService + FAQPage + BreadcrumbList |
| Homepage | 11 JSON-LD blocks: Organization/LawFirm + LegalService + 6× office LocalBusiness + WebPage + WebSite + BreadcrumbList; 1.02s load |

---

## New findings

### G1 — Class-action section is weak in search and invisible to AI — HIGH
**Correction 2026-07-08 (execution pre-check):** the original "not in any XML sitemap" claim was a measurement artifact — the sitemap XML is one line and the check used `grep -c` (lines) instead of `grep -o` (occurrences). All 15 class-action URLs (hub + 14 children, regular WP pages under parent 4046) ARE in `wp-sitemap-posts-page-1.xml`, verified live. The remaining three defects are real and verified:
- **Breadcrumb-only JSON-LD** — no LegalService, no FAQPage, on pages competing in the most schema-saturated mass-tort SERPs there are.
- **Keyword-less titles** — `Camp Lejeune – Roden Law` (no "lawsuit", "lawyer", or claim language).
- **Zero mentions in llms.txt or llms-full.txt** — AI engines reading the firm profile have no idea Roden handles mass torts.

**Fix:** add a title template (`{Tort} Lawsuit Lawyers – Roden Law`); extend the schema builder (LegalService; FAQPage only where real FAQ content exists) to the hub + children; add a "Class Actions & Mass Torts" section to the llms generator (**bump `RODEN_LLMS_TXT_VERSION`** or the static file stays stale).

### G2 — Three dead LPs 404 with no redirects — HIGH (pending GSC confirmation)
`/truck-accident-lawyers-columbia-sc/`, `/truck-accident-lawyers-near-me/`, `/south-carolina-rear-end-accident-lawyer/` all return hard 404s. All three existed as routes in the Next.js mirror (built from the live WP URL set), so they were real pages — likely casualties of the PA silo dedup. They're absent from `legacy-redirects.php` and the June 15 404 audit.

**Fix:** check GSC for impressions/backlinks, then 301: columbia-sc flat → `/truck-accident-lawyers/columbia-sc/`; near-me → `/practice-areas/truck-accident-lawyers/`; SC rear-end → `/car-accident-lawyers/rear-end-collision/`.

### G3 — `/es/` homepage is schema-starved — MEDIUM
The EN homepage emits 11 JSON-LD blocks; `/es/` emits **one** (BreadcrumbList). No LawFirm/Organization, no office LocalBusiness, no `inLanguage: es` entity on the Spanish front door. Title/meta/hreflang are fine.

**Fix:** extend the homepage schema builder to the ES twin with `inLanguage: "es"` (deep ES pages already do this correctly).

### G4 — GA statewide LP schema is inconsistent with SC — MEDIUM-LOW
`/georgia-car-accident-lawyer/` emits FAQPage only; `/south-carolina-car-accident-lawyers/` emits LegalService + FAQPage + BreadcrumbList. Same page tier, different schema — the GA LP predates the schema builder hookup.

### G5 — Case-result pages: weak schema + duplicate titles — LOW
156 indexable case results carry generic `CreativeWork` schema and (per F8) duplicate titles pending editorial location terms. Consider populating the location terms in bulk from case metadata, and/or richening schema.

### G6 — Residual EN link on `/es/` — LOW
One `href="https://rodenlaw.com/locations/south-carolina/"` remains on `/es/` outside the footer (the ES twin `/es/locations/` exists).

### Notes / no action
- `/llms` and `/llms-full` 301 to the `.txt` versions — correct.
- EN homepage title still omits the brand (cosmetic, carried over from morning audit).
- EN homepage has no FAQPage — optional GEO opportunity, not a defect.

---

## Prioritized action plan

| # | Fix | Effort | Where |
|---|---|---|---|
| 1 | Class-action: sitemap provider + title template + LegalService/FAQPage schema | M | sitemap init + seo-meta.php + schema builder |
| 2 | Class-action section in llms.txt/llms-full + version bump | S | llms generator, `RODEN_LLMS_TXT_VERSION` |
| 3 | GSC-check + 301 the 3 dead LPs | S | legacy-redirects.php |
| 4 | ES homepage schema graph (`inLanguage: es`) | S | schema builder |
| 5 | GA statewide LP: add LegalService + BreadcrumbList | S | LP template/schema hookup |
| 6 | Populate case-result location terms (unblocks F8 titles) | M (editorial/bulk) | wp-admin terms or seeder |
| 7 | Swap last EN link on `/es/` | S | nav render |
