# Phase 0: Immediate Blog Fixes — Execution Plan

**Priority:** CRITICAL
**Estimated time:** 30 minutes
**Risk:** Low (targeted additions to existing redirect system)

Execution plan for Phase 0 immediate fixes from the blog/sitemap audit (2026-03-22).

---

## Current State (as of 2026-03-22)

- **`inc/legacy-redirects.php`** — Already loaded via `functions.php` (line 27), fires on `template_redirect` at priority 1, contains 135+ redirects across 10 categories
- **Permalink structure** — Changed to `/blog/%postname%/` — blog posts now live at `/blog/[slug]/`
- **Permalink Manager Pro** — REMOVED (was creating bloat). No more `permalink-manager-uris` option or custom URI overrides to worry about.
- **Category 7** in legacy-redirects.php — Was SKIPPED, waiting for exactly this permalink change. Now needs to be ACTIVATED.

All Phase 0 fixes go into the EXISTING `inc/legacy-redirects.php`. Do NOT create a separate file.

---

## IMPORTANT CONSTRAINTS

- Do NOT create a new `inc/redirects.php` — use the existing `inc/legacy-redirects.php`
- Do NOT modify `functions.php` — it already loads `legacy-redirects.php` at line 27
- Do NOT reference Permalink Manager plugin — it has been removed
- Do NOT run `ssh` or attempt to verify remote deployment
- Work locally, commit, and push to GitHub only

---

## Task 1: Activate Category 7 (Root-Level Blog Post Redirects)

**Why:** The permalink structure has changed from `/%postname%/` to `/blog/%postname%/`. The 7 root-level blog posts identified in Category 7 now need redirects from their old root URLs to their new `/blog/` URLs. This was the exact scenario Category 7 was waiting for.

**File to edit:** `inc/legacy-redirects.php`

Find this block (around lines 297–302):

```php
        // ══════════════════════════════════════════════════════════════
        // CATEGORY 7: Root-level blog posts (7 pages)
        // SKIPPED — permalink structure is /%postname%/ so these posts
        // already live at root. Redirects would break working URLs.
        // Re-enable after changing permalink structure to /blog/%postname%/.
        // ══════════════════════════════════════════════════════════════
```

Replace it with:

```php
        // ══════════════════════════════════════════════════════════════
        // CATEGORY 7: Root-level blog posts → /blog/ prefix
        // ACTIVATED 2026-03-22 — permalink structure changed to /blog/%postname%/
        // Permalink Manager Pro removed. These redirects catch old root URLs.
        // ══════════════════════════════════════════════════════════════

        '/a-pedestrians-guide-to-claiming-lost-wages-in-charleston/'          => '/blog/a-pedestrians-guide-to-claiming-lost-wages-in-charleston/',
        '/filing-a-claim-after-a-hazmat-truck-crash-in-charleston/'           => '/blog/filing-a-claim-after-a-hazmat-truck-crash-in-charleston/',
        '/how-poor-truck-maintenance-causes-charleston-accidents/'            => '/blog/how-poor-truck-maintenance-causes-charleston-accidents/',
        '/your-guide-to-justice-after-a-charleston-truck-accident/'           => '/blog/your-guide-to-justice-after-a-charleston-truck-accident/',
        '/a-guide-to-car-accident-claims-at-columbias-toughest-intersections/' => '/blog/a-guide-to-car-accident-claims-at-columbias-toughest-intersections/',
        '/protecting-your-rights-after-a-myrtle-beach-car-accident/'         => '/blog/protecting-your-rights-after-a-myrtle-beach-car-accident/',
```

**Note:** The original Category 7 listed 7 posts but only 6 are shown above because the Columbia truck accident post (`/a-practical-guide-after-a-truck-accident-in-downtown-columbia/`) is a duplicate that gets handled separately in Category 11 below (redirected to the canonical version, not to `/blog/`).

---

## Task 2: Add Category 11 — Phase 0 Immediate Fixes

**File to edit:** `inc/legacy-redirects.php`

Find the closing of the return array (around line 328–330):

```php
        '/class-action-lawyers/' => '/practice-areas/',

    );
}
```

Insert the following BEFORE the closing `);`:

```php
        // ══════════════════════════════════════════════════════════════
        // CATEGORY 11: Blog audit — Phase 0 immediate fixes (2026-03-22)
        // Broken slugs, duplicate content consolidation
        // ══════════════════════════════════════════════════════════════

        // Broken template-variable slug → contact page
        '/request-your-free-case-review-today-main_phone_number/' => '/contact/',

        // Duplicate Coleman Boulevard posts → canonical version
        '/car-accidents-on-coleman-boulevard/' => '/blog/car-accidents-on-coleman-boulevard-in-mount-pleasant/',

        // Duplicate Columbia truck accident guides → single canonical post
        '/your-first-steps-after-a-truck-accident-in-downtown-columbia-sc/' => '/blog/your-step-by-step-guide-after-a-downtown-columbia-truck-accident/',
        '/a-practical-guide-after-a-truck-accident-in-downtown-columbia/'   => '/blog/your-step-by-step-guide-after-a-downtown-columbia-truck-accident/',
```

**Important — redirect targets use `/blog/` prefix** because the permalink structure has changed. The canonical blog posts now live at `/blog/[slug]/`, so all redirect targets for blog content must include the `/blog/` prefix. The broken-slug post redirects to `/contact/` which is a page (not a post), so it has no `/blog/` prefix.

---

## Task 3: Handle ALL Old Root-Level Blog URLs

**Why this matters:** With the permalink change from `/%postname%/` to `/blog/%postname%/`, WordPress should automatically serve posts at their new `/blog/` URLs. However, **every old root-level URL that was indexed by Google, shared on social media, or linked from external sites will now 404** unless redirected.

Category 7 only covers 6 specific posts. But the sitemap audit found **~375 blog posts** that were previously at root URLs. ALL of them need redirects.

**Recommended approach — add a pattern-based catch-all redirect:**

In `inc/legacy-redirects.php`, find the `roden_legacy_content_redirects()` function. After the existing pattern-based redirects (the `preg_match` blocks for `/case-result/`, `/testimonial/`, `/staff/`, `/class-action/`), add:

```php
    // ── Blog post catch-all: old /%postname%/ → /blog/%postname%/ ────────
    // With permalink structure changed to /blog/%postname%/, old root-level
    // blog URLs need to redirect. Check if a post exists at /blog/[slug]/
    // before redirecting (to avoid catching practice areas or other CPTs).
    $slug = trim( $clean_path, '/' );
    if ( $slug
         && false === strpos( $slug, '/' )            // single-segment path only
         && ! is_front_page()                          // skip homepage
         && 0 !== strpos( $slug, 'wp-' )               // skip WordPress system paths
    ) {
        $post_obj = get_page_by_path( $slug, OBJECT, 'post' );
        if ( $post_obj && 'publish' === $post_obj->post_status ) {
            wp_redirect( home_url( '/blog/' . $slug . '/' ), 301 );
            exit;
        }
    }
```

This catch-all:
- Only fires on single-segment root URLs (won't interfere with `/practice-areas/[slug]/` or `/attorneys/[name]/`)
- Verifies a published post actually exists with that slug before redirecting
- Skips homepage and WP system paths
- Falls through silently if no matching post is found (lets WordPress handle 404s normally)

**Place this AFTER all the explicit redirect map checks and pattern-based redirects**, so the map takes priority. It acts as a safety net for the hundreds of blog posts not individually listed.

---

## Task 4: Draft Broken/Duplicate Posts in WordPress Admin

**Manual steps** — Claude Code cannot execute these.

### 4A: Draft the broken-slug post
1. WordPress Admin → Posts → search "free case review"
2. Find the post with slug `request-your-free-case-review-today-main_phone_number`
3. Set to **Draft**

### 4B: Draft the duplicate Coleman Blvd post
1. Posts → search "Coleman Boulevard"
2. Merge any unique content into the canonical version (`car-accidents-on-coleman-boulevard-in-mount-pleasant`)
3. Set the shorter-slug duplicate to **Draft**

### 4C: Draft the duplicate Columbia truck posts
1. Posts → search "truck accident downtown Columbia"
2. Merge unique content into: `your-step-by-step-guide-after-a-downtown-columbia-truck-accident`
3. Set the other two to **Draft**

---

## Task 5: Google Search Console Cleanup

**Manual step** — after deploy.

1. Google Search Console → Removals → New Request
2. Submit: `https://rodenlaw.com/request-your-free-case-review-today-main_phone_number/`
3. Also monitor for 404 spikes from old root-level blog URLs — the catch-all redirect in Task 3 should prevent this, but verify in the Coverage report over the next 7 days

---

## Code Change Summary

**ONE file edited:** `inc/legacy-redirects.php`

Changes:
1. **Category 7 activated** — 6 explicit root→/blog/ redirects for previously identified posts
2. **Category 11 added** — 4 redirects for broken slug + duplicates
3. **Catch-all pattern added** — Redirects any root-level slug to `/blog/[slug]/` if a matching published post exists

No other files change.

---

## Verification Checklist (after deploy)

**Phase 0 specific:**
- [ ] `rodenlaw.com/request-your-free-case-review-today-main_phone_number/` → 301 to `/contact/`
- [ ] `rodenlaw.com/car-accidents-on-coleman-boulevard/` → 301 to `/blog/car-accidents-on-coleman-boulevard-in-mount-pleasant/`
- [ ] `rodenlaw.com/your-first-steps-after-a-truck-accident-in-downtown-columbia-sc/` → 301 to `/blog/your-step-by-step-guide-after-a-downtown-columbia-truck-accident/`
- [ ] `rodenlaw.com/a-practical-guide-after-a-truck-accident-in-downtown-columbia/` → 301 to `/blog/your-step-by-step-guide-after-a-downtown-columbia-truck-accident/`

**Category 7 activation:**
- [ ] `rodenlaw.com/a-pedestrians-guide-to-claiming-lost-wages-in-charleston/` → 301 to `/blog/a-pedestrians-guide-to-claiming-lost-wages-in-charleston/`
- [ ] `rodenlaw.com/protecting-your-rights-after-a-myrtle-beach-car-accident/` → 301 to `/blog/protecting-your-rights-after-a-myrtle-beach-car-accident/`

**Catch-all pattern:**
- [ ] `rodenlaw.com/blog-what-to-do-when-you-are-in-a-car-accident/` → 301 to `/blog/blog-what-to-do-when-you-are-in-a-car-accident/`
- [ ] `rodenlaw.com/charleston-medical-malpractice-hospital-claim-south-carolina/` → 301 to `/blog/charleston-medical-malpractice-hospital-claim-south-carolina/`

**No false positives:**
- [ ] `rodenlaw.com/practice-areas/car-accident-lawyers/` → loads normally (NOT redirected)
- [ ] `rodenlaw.com/attorneys/eric-roden/` → loads normally (NOT redirected — multi-segment path)
- [ ] `rodenlaw.com/contact/` → loads normally (is a page, not a post)
- [ ] `rodenlaw.com/locations/georgia/savannah/` → loads normally (NOT redirected)
- [ ] Existing legacy redirects (Categories 0–10) still function correctly

---

## Git Workflow

```bash
git add inc/legacy-redirects.php
git commit -m "Phase 0: Activate Category 7 blog redirects, add broken/duplicate fixes, add root→blog catch-all"
git push origin main
```

---

## Future Phases (Not In Scope Here)

- **Phase 1:** Move service/landing pages out of blog post type
- **Phase 2:** ~~Change permalink structure~~ DONE — now `/blog/%postname%/`
- **Phase 3:** Strip `blog-` prefix from old slugs, shorten long slugs
- **Phase 4:** Update outdated 2017/COVID content
- **Phase 5:** Install Rank Math, configure separate sitemaps, submit to GSC
