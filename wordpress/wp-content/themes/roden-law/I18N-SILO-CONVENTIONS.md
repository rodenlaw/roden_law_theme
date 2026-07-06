# Spanish (i18n) Silo Conventions — Roden Law

Status: **BUILT (Phase 1, 2026-07) — bespoke, no plugin.** The locale layer lives in
`inc/i18n.php` (decision: no multilingual plugins — Polylang/WPML rejected). ES posts
are separate posts linked by `_roden_translation_of` / `_roden_translation_es` meta;
CPT posts carry an internal `es-` slug prefix mapped to public `/es/` URLs by
`inc/rewrite-rules.php` + permalink filters; pages live as children of the top-level
`es` page. Chrome translates via gettext (`languages/es_ES.mo`). One deviation from
§3 below: hreflang ships as per-page head tags (scale is <1K URLs), not sitemap
`<xhtml:link>` — revisit if the ES silo grows past ~2-3K URLs. Content seeds via
`inc/es/seed-es-batch-*.php` (drafts; publish after review). The rules below remain
the contract.

---

## 1. URL structure — subdirectory, mirror the silo

Spanish lives under an `/es/` subdirectory that **mirrors the English silo exactly**:

```
EN:  /car-accident-lawyers/                 ES:  /es/car-accident-lawyers/
EN:  /car-accident-lawyers/charleston-sc/    ES:  /es/car-accident-lawyers/charleston-sc/
EN:  /practice-areas/                        ES:  /es/practice-areas/   (index)
```

- **Subdirectory, not subdomain or `?lang=`.** Easiest to consolidate authority; no
  separate-domain trust split.
- **Same slugs** as English (keep `car-accident-lawyers`, `charleston-sc`). Translating
  slugs adds redirect/maintenance overhead for no ranking gain in legal queries; the
  city-state slugs are proper nouns regardless.
- **Always prefix `/es/`** — never hide the locale from the URL. Hiding it stops Google
  distinguishing the two versions.
- Locale prefix, trailing slash, and lowercase must be **consistent** across the URL,
  canonical, hreflang, and sitemap. 301 any non-canonical format to canonical.
- Reuse the canonical-vs-duplicate discipline already in place: the `/es/` pages must
  serve a single 200 URL each (no `/es/practice-areas/{pillar}/{child}/` duplicate —
  extend `roden_pa_permalink` and `roden_redirect_duplicate_pa_path` to be locale-aware).

## 2. Canonical — self-canonical per locale, never cross-locale

- Every `/es/` page self-canonicals to its own `/es/` URL.
- **Never** cross-locale canonical (`/es/...` → `/...`) — that suppresses indexing of
  the entire Spanish version.
- The canonical URL must appear in its own hreflang set, or all hreflang for that page
  is ignored. Canonical overrides hreflang when they conflict.
- Protocol + domain must match across canonical, hreflang, and sitemap (`https://` +
  same host). `roden_get_canonical_url()` will need a locale-aware branch.

## 3. hreflang — reciprocal, self-referencing, with x-default

Each page (EN and ES) carries the full cluster:

```
en        → https://rodenlaw.com/car-accident-lawyers/charleston-sc/
es        → https://rodenlaw.com/es/car-accident-lawyers/charleston-sc/
x-default → https://rodenlaw.com/car-accident-lawyers/charleston-sc/   (English fallback)
```

- **Self-reference required** — each page includes itself in the set, or the whole set
  is dropped.
- **Reciprocal** — if EN points to ES, ES must point back, or the pair is ignored.
- **Valid codes** — `en`, `es` (add region only if a true regional variant ships;
  `es` is correct for general Spanish — do not invent `es-US` without distinct content).
- `x-default` points to the English page (the default-locale fallback).
- All hreflang targets must return **200**, be indexable, and equal their own canonical.
  Broken/redirected hreflang targets invalidate the cluster and waste crawl budget.

**Delivery at this scale:** ~300+ silo pages × 2 locales → deliver hreflang via the
**XML sitemap** (`<xhtml:link>` with `xmlns:xhtml`), not per-page `<head>` tags. The
core WP sitemap doesn't emit `<xhtml:link>`; plan a custom sitemap (or a plugin) that
adds reciprocal alternates incl. self + `x-default`. `<xhtml:link>` children don't count
toward the 50K-URL limit, but watch the 50MB file cap (~2K–5K URLs/file with alternates).

## 4. Content — translate everything, not just chrome

- Translate **all** visible content: title, meta description, H1/headings, body, FAQs,
  schema text fields — not just nav/footer. Boilerplate-only translation reads as
  duplicate content and can trigger scaled-content concerns.
- Keep jurisdiction/legal accuracy: O.C.G.A. / S.C. Code citations, statute-of-limitations
  values, phone numbers, and office NAP localized correctly per office.
- Don't ship `/es/` pages you can't make genuinely useful — the helpful-content signal is
  site-wide, so thin Spanish pages can drag English rankings too. Better to launch a
  smaller, fully-translated `/es/` silo than 300 thin ones.
- Don't `noindex` thin locales (wastes crawl) and don't cross-canonical (conflicts with
  hreflang) — just don't create the page until it's real.

## 5. WordPress implementation checklist (when building)

- Choose the mechanism: Polylang/WPML, or a bespoke locale layer. Whatever the choice,
  the URL/canonical/hreflang rules above are the contract.
- Remove/relax `roden_force_en_us_locale()` for `/es/` requests.
- Make locale-aware: `roden_get_canonical_url()`, `roden_pa_permalink` (post_type_link),
  `roden_redirect_duplicate_pa_path`, the rewrite rules in `inc/rewrite-rules.php`, and
  the breadcrumb builder (`roden_schema_breadcrumbs`) — the "Practice Areas" crumb and
  parent crumb must resolve to `/es/...`.
- Custom hreflang sitemap (see §3). Keep noindex PPC landing pages excluded per
  `roden_noindex_page_templates()`.
- Validate a sample EN/ES pair in Google's Rich Results Test + the hreflang in Search
  Console once live.
