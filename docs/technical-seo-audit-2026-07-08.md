# Technical SEO Audit — rodenlaw.com (Production)

**Date:** 2026-07-08
**Scope:** Production WordPress site only. Full crawl of all 1,333 sitemap URLs + deep-dive on the 81 Spanish `/es/` pages and their 78 English counterparts.
**Method:** Live HTTP checks (status, canonicals, hreflang, robots meta, titles, meta descriptions, headers), server-rendered JSON-LD inspection via raw HTML (WP emits schema server-side, so curl sees it), sitemap parsing. PageSpeed Insights API was quota-blocked (keyless), so CWV field data is from direct timing/header measurement only.

---

## Executive summary

The site's technical foundation is in excellent shape — this audit found **zero indexation blockers** across all 1,333 sitemap URLs (every one returns 200, self-canonical, indexable, titled, with a meta description). The Spanish build is near-textbook: all 78 EN↔ES hreflang pairs are perfectly reciprocal with x-default, exact mapping, self-canonicals, unique Spanish titles/descriptions, fully translated content, and `inLanguage: es` schema.

The issues that remain cluster around **one high-priority gap (the `/es/blog/` hub is self-sabotaged)**, a schema locale leak on the English blog, legacy sitemap soft-200s, and an on-page opportunity on ~219 location pages with keyword-less titles plus a handful of duplicate location pages.

**Top 5 priorities:**
1. Fix the `/es/blog/` hub (cross-locale canonical, English title/H1, broken pagination, absent from sitemap)
2. Exclude Spanish posts from the English `/blog/` page's Blog JSON-LD
3. 301 the legacy Yoast sitemap URLs to `/wp-sitemap.xml/`
4. Add a keyword title template to location pages ("City – Roden Law" → "City, ST Personal Injury Lawyers | Roden Law")
5. Consolidate 6 duplicate/self-child location pages

---

## What's healthy (verified, not assumed)

| Area | Result |
|---|---|
| Indexation | 1,333/1,333 sitemap URLs return 200, self-canonical, no noindex, no X-Robots-Tag blocks |
| Host/protocol | www + http variants 301 once to `https://rodenlaw.com/`; trailing-slash 301s clean; no redirect chains found |
| robots.txt | Clean; only `/wp-admin/` blocked; sitemap referenced; AI crawlers explicitly allowed; `/llms.txt` live (200, text/plain) |
| 404 handling | Garbage URLs (EN and ES) return true 404s — no soft-404 pattern on content URLs |
| hreflang (78 pairs) | Self-referencing + reciprocal + `x-default` on every pair; exact 1:1 mapping verified both directions; zero broken clusters |
| ES canonicals | All 81 ES pages self-canonical (no cross-locale canonicals except `/es/blog/` — see F1) |
| ES on-page | 0 missing meta descriptions, 0 duplicate titles, `<html lang="es-ES">`, fully translated (1 stray English string in a template) |
| ES schema | LegalService, FAQPage, BreadcrumbList, Organization with `inLanguage: "es"` — server-rendered |
| ES discoverability | EN pages link to their ES twins (4 links each incl. switcher); all 81 ES URLs in the sitemap; no orphans |
| Content depth | Location pages ~3,000 words rendered text; unique per-page descriptions even on duplicate-slug pages |
| Performance signals | TTFB 200–385ms, Brotli, Cloudflare + WPE edge cache HIT, HTML 17–21KB, lazy-loading + WebP in use |
| Security | Full HTTPS, no mixed content on sampled templates |
| Meta descriptions (EN) | 0 missing in a 38-URL stratified sample across all post types |

---

## Findings

### F1 — `/es/blog/` hub is self-sabotaged — HIGH
**Issue:** The Spanish blog hub at `/es/blog/` correctly lists the 12 Spanish posts, but:
- Its canonical points **cross-locale to `https://rodenlaw.com/blog/`** — this tells Google to ignore the page entirely (canonical overrides everything else).
- Title is bare `Roden Law`; H1 is English "Roden Law Blog".
- No hreflang pair with `/blog/` (and `/blog/` has none pointing back).
- Not in the XML sitemap.
- It links to `/es/blog/page/2/` which returns **404** (the `/es/blog/` rewrite doesn't cover `/page/N/`), while `/blog/page/2/` works.
- It also links to the English category URL `/blog/category/wrongful-death/`.

**Impact:** High. The hub for all Spanish blog content is uncrawlable-by-design and unindexable. The 12 posts survive because they're individually in the sitemap and cross-linked from EN twins, but the ES blog silo has no indexable entry point.
**Fix:** In `inc/i18n.php` + the rewrite layer: self-canonical `/es/blog/`, Spanish title/H1/meta, hreflang pair with `/blog/`, add `/es/blog/page/N/` rewrites, localize the category link (or drop it), add `/es/blog/` to the sitemap.

### F2 — English `/blog/` Blog schema lists the 12 Spanish posts as its mainEntity — HIGH
**Issue:** The visible post loop on `/blog/` correctly excludes Spanish posts, but the Blog JSON-LD `mainEntity.itemListElement` contains the 11–12 most recent posts unfiltered — currently all `/es/blog/…` URLs with Spanish names. The schema query is missing the locale filter the display query has.
**Impact:** Medium-high. The English blog page declares Spanish documents as its main entities — conflicting language signals on the site's primary content hub, and the schema misrepresents the page.
**Evidence:** `curl https://rodenlaw.com/blog/` → JSON-LD itemList = 11 `/es/blog/` URLs; visible hrefs = EN URLs only.
**Fix:** Apply the same locale exclusion to the recent-posts query feeding the Blog schema (and mirror it: `/es/blog/`'s schema should list ES posts).

### F3 — Legacy Yoast sitemap URLs serve soft-200 HTML — MEDIUM
**Issue:** `sitemap_index.xml`, `page-sitemap.xml`, `post-sitemap.xml` all return **200 with `text/html`** (a blog-page render) instead of 404/301. `/sitemap.xml` correctly serves XML; `/wp-sitemap.xml` 301s to the trailing-slash version (robots.txt already points there).
**Impact:** Medium. If GSC or any crawler retains the old Yoast sitemap references, it fetches an HTML page that parses as a broken sitemap; the soft-200 also invites duplicate-content crawling of the blog page under XML URLs.
**Fix:** 301 all three legacy patterns (`/sitemap_index.xml`, `/{type}-sitemap.xml`) → `https://rodenlaw.com/wp-sitemap.xml/`.

### F4 — Location pages have keyword-less titles ("City – Roden Law") — MEDIUM
**Issue:** The ~219 location pages (and sub-neighborhood pages) use the bare template `{City} – Roden Law` — e.g. `Irmo – Roden Law` (22 chars). 109 pages sitewide have titles under 30 characters, almost all locations. No service keyword, no state.
**Impact:** Medium — these pages carry ~3,000 words of unique local content but their strongest ranking signal is wasted. Also creates cross-state duplicate titles (`Georgetown – Roden Law` = GA neighborhood + SC city).
**Fix:** Title template like `{City}, {ST} Personal Injury Lawyers | Roden Law` (H1 can stay local-flavored). One filter in the theme covers all of them.

### F5 — Duplicate / self-child location pages — MEDIUM
**Issue:** Several cities exist twice in the location tree, all 200 + self-canonical + in the sitemap (i.e., true keyword cannibalization, each with separately written content):
- `/locations/georgia/savannah/guyton/` **and** `/locations/georgia/savannah/effingham-county/guyton/`
- `/locations/georgia/savannah/springfield/` **and** `/locations/georgia/savannah/effingham-county/springfield/`
- `/locations/south-carolina/charleston/sullivans-island/` **and** `/locations/south-carolina/charleston/mount-pleasant/sullivans-island/`
- Self-child pages duplicating their parent: `columbia/columbia/`, `myrtle-beach/myrtle-beach/`, `darien/darien/`
(`georgetown`, `town-center`, `historic-district` collisions are genuinely different places — no action.)
**Impact:** Medium. Two pages splitting link equity and competing for identical queries ("Guyton GA personal injury lawyer").
**Fix:** Pick the canonical location for each (suggest the shallower/older URL), 301 the twin, remove from sitemap. For self-child pages, 301 into the parent city page.

### F6 — Hub pages missing hreflang (3 pairs) — MEDIUM-LOW
**Issue:** `/practice-areas/`, `/locations/`, `/resources/` and their ES twins emit **no hreflang at all** (symmetric absence, so nothing is broken — the pairs are just unlinked). All six pages are otherwise healthy (200, self-canonical, in sitemap).
**Fix:** Register these three pairs in the i18n pair map so they emit the same en/es/x-default set as everything else.

### F7 — Spanish pages' nav/footer link to English URLs that have Spanish twins — MEDIUM-LOW
**Issue:** On `/es/` (and ES templates generally), nav/footer links point at the **English** versions of pages that have live ES twins — e.g. `/south-carolina-car-accident-lawyers/`, `/resources/`, `/locations/south-carolina/` instead of their `/es/…` equivalents. (Links to pages with no twin — attorneys, testimonials — are fine as-is.)
**Impact:** Medium-low. Bleeds Spanish users into English pages mid-journey and starves ES pages of internal links (their only in-site links are the per-page switchers).
**Fix:** In the nav/footer render path, when locale=es and a twin exists in the pair map, swap the href.

### F8 — Case-result duplicate titles — LOW
**Issue:** ~60 case-result URLs share titles like `$100,000 Settlement | Auto Accident – Roden Law` (8 identical). Inherent to the post type, but they're 156 indexable URLs.
**Fix:** Append a differentiator (injury type, county, or year) to the title template.

### F9 — Homepage images missing alt text — RETRACTED (false positive)
**Correction 2026-07-08:** all 10 homepage `<img>` tags DO have alt text (badges + hero portrait included). The original check split tags on line breaks, and these tags put `alt` on the line after `src`. Verified with a whole-tag parse against the live HTML. No action needed.

### F10 — Title truncation at scale — LOW
**Issue:** 750/1,333 titles exceed 65 characters (long descriptive law-firm titles; front-loaded keywords mostly survive truncation). No action needed beyond keeping key terms in the first ~55 chars on new templates.

### Notes / no-action observations
- `<html lang="es-ES">` — content targets US Spanish speakers; `es-US` (or just `es`) would be marginally more accurate. hreflang correctly uses bare `es`, which is what matters.
- WP core sitemaps can't carry `<xhtml:link>` hreflang alternates — not needed while the HTML tags are complete, but if ES scales past a few hundred pages, a custom sitemap with alternates is the durable path.
- EN homepage title (`Personal Injury Lawyers in Georgia & South Carolina`) omits the brand; every other page includes it. Cosmetic.
- CWV field data unverified this run (PSI quota). Lab signals are strong; re-run PSI with an API key or pull the GSC CWV report to confirm.

---

## Prioritized action plan

| # | Fix | Effort | Where |
|---|---|---|---|
| 1 | `/es/blog/` hub: self-canonical, ES title/H1, hreflang pair, `/page/N/` rewrites, add to sitemap | S–M | `inc/i18n.php` + rewrites |
| 2 | Locale-filter the Blog JSON-LD recent-posts query on `/blog/` | S | schema builder |
| 3 | 301 legacy Yoast sitemap URLs → `/wp-sitemap.xml/` | S | rewrites/.htaccess |
| 4 | Location title template with keyword + state | S | theme title filter |
| 5 | 301 the 6 duplicate/self-child location pages | M (needs canonical-pick decisions) | redirects + sitemap |
| 6 | hreflang for the 3 hub pairs | S | i18n pair map |
| 7 | Localize ES nav/footer links where twins exist | M | nav/footer render |
| 8 | Case-result title differentiator | S | title template |
| 9 | Alt text on homepage badges/hero | S | theme partials |
