# Spanish (/es/) Phase 1 — Deploy & Seed Runbook

Date: 2026-07-06 · Branch: `i18n/es-spanish-phase1` · No plugins — bespoke locale layer (`inc/i18n.php`).

## What ships

- **Plumbing** (inert until content publishes): `/es/` rewrite rules, locale-aware canonicals/permalinks/breadcrumbs, per-page hreflang (en/es/x-default), `es_ES.mo` gettext chrome, EN↔ES language switcher (top bar + mobile nav + footer — hidden until the ES homepage is published), form `lang` field → Spanish confirmation + `/es/gracias/` redirect + `lead_language` on GF entries + `language` in the intake webhook payload, llms.txt "En Español" section.
- **Content seeders** (`inc/es/`): ~21 pages as **drafts** — `/es/` home, practice-areas + locations hubs, about, contact, gracias, 6 office pages, 10 pillar pages.

## URL model

| English | Spanish |
|---|---|
| `/` | `/es/` |
| `/practice-areas/car-accident-lawyers/` | `/es/practice-areas/car-accident-lawyers/` |
| `/locations/georgia/savannah/` | `/es/locations/georgia/savannah/` |
| `/contact/`, `/about/`, `/thank-you/` | `/es/contact/`, `/es/about/`, `/es/gracias/` |

Internals: ES pages are children of the top-level `es` page (native URLs). ES CPT posts use internal `es-` slugs (`es-car-accident-lawyers`) mapped to public URLs by rewrites + permalink filters; any internal-path hit 301s to the `/es/` URL. Linkage meta: `_roden_locale`, `_roden_translation_of` (ES→EN), `_roden_translation_es` (EN→ES).

## 1. Deploy theme

```bash
# from repo root, branch merged/pushed as usual (push as the rodenlaw account)
bin/deploy-wpe.sh
```

Then **flush permalinks** (required — new rewrite rules):

```bash
ssh rodenlawprod@rodenlawprod.ssh.wpengine.net "cd sites/rodenlawprod && wp rewrite flush"
```

Purge WPE cache. EN site must be byte-identical: spot-check title/canonical/hreflang(absent)/nav on `/`, a pillar, an intersection, a location, `/contact/`.

## 2. Seed Spanish drafts (one batch at a time)

```bash
ssh rodenlawprod@rodenlawprod.ssh.wpengine.net
cd sites/rodenlawprod
T=wp-content/themes/roden-law/inc/es
for b in 01-core-pages 02-locations-ga 03-locations-sc-a 04-locations-sc-b \
         05-pillars-auto 06-pillars-work 07-pillars-road 08-pillars-premises 09-pillars-serious; do
  echo "include '$PWD/$T/es-seed-lib.php'; include '$PWD/$T/seed-es-batch-$b.php';" | wp eval-file -
done
```

Batches are idempotent (skip if `_roden_translation_es` already set) and abort loudly on slug collisions. **Batch 01 must run first** (creates the `es` root page the others' URLs hang off).

Sanity count: `wp post list --post_status=draft --meta_key=_roden_locale --meta_value=es --format=count` → expect ~21.

## 3. Review → publish

Preview drafts in wp-admin (Pages + Practice Areas + Locations filtered by draft). Spanish legal copy — especially the TCPA consent string in `languages/es_ES.po` and the SOL statements — should get a fluent-speaker read.

Publish **by ID** (drafts publish by ID, not slug), `es` root page FIRST (it gates the switcher):

```bash
wp post list --post_status=draft --meta_key=_roden_locale --meta_value=es --format=ids
wp post update <ids…> --post_status=publish
wp rewrite flush
```

Purge WPE cache again (switcher renders into cached EN HTML).

## 4. Verify

- `/es/` 200, Spanish chrome (header/footer/form/FAQ headings) + `<html lang="es-ES">` + `lang-es` body class.
- View-source an EN/ES pair (`/practice-areas/car-accident-lawyers/` ↔ `/es/practice-areas/car-accident-lawyers/`): self-canonical per locale; reciprocal hreflang trio en/es/x-default on both.
- `/practice-areas/es-car-accident-lawyers/` → 301 → `/es/practice-areas/car-accident-lawyers/`.
- `/wp-sitemap.xml/` lists ES URLs in `/es/` form; `/es/wp-sitemap.xml` still 404s (intentional — single sitemap).
- EN homepage/archives/search show no Spanish posts; switcher round-trips EN↔ES; untranslated EN page → switcher goes to `/es/`.
- `/es/contact/` form: Spanish labels + consent, submit → GF entry with `lead_language=es`, webhook payload has `language: es`, redirect to `/es/gracias/` (noindex, not in sitemap).
- Rich Results Test one ES pillar (FAQPage in Spanish, `inLanguage: es`) + one ES location (LocalBusiness).
- `/llms` shows the "En Español" section (version bumped to 2026-07-06.1 — regenerates on deploy).

## 5. Search Console / GA4

- GSC (same property covers `/es/`): URL-inspect 3 ES pages, request indexing; watch Page indexing + hreflang for ~2 weeks.
- GA4: register custom dimension `site_language` (already pushed to dataLayer before GTM on every page); annotate launch.

## Known items for Phase 2

- **Intersection template article bug (Spanish)**: the intersection legal paragraph interpolates an English article ("a"/"an") computed in PHP into the translated string — on ES intersection pages it would read "en a accidente…". Fix the article helper to be locale-aware (or drop `%1$s` into the Spanish translation) before seeding ES intersections. No Phase 1 page is affected.
- **`.po` upkeep**: after any new `__()` string ships, regenerate (`wp i18n make-pot . languages/roden-law.pot --domain=roden-law --exclude=".claude,node_modules,inc/es"`), add Spanish msgstrs, and `msgfmt --check languages/es_ES.po -o languages/es_ES.mo`. The `.mo` is what runtime reads — commit both.
- **Fluent-speaker review**: the es_ES.po legal strings (TCPA consent, footer disclaimers) and seeded page copy were AI-drafted; get a fluent Spanish speaker at the firm to sign off before or shortly after publish.

## Phase 2 / 3 (not in this pass)

Remaining 12 pillars; intersections for Charleston/N. Charleston/Columbia/Savannah/Myrtle Beach × car/truck/workers-comp/construction (child ES posts under ES pillars — rewrites + templates already handle them); statewide LPs; resources/FAQ hub. Revisit sitemap-based hreflang only if the ES silo passes ~2-3K URLs.
