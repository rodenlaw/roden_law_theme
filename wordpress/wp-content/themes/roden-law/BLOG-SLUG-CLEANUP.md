# Blog Slug Cleanup & Sitemap Remediation

**Date:** 2026-03-22
**Site:** rodenlaw.com
**Permalink structure:** `/blog/%postname%/`
**Sitemap:** `wp-sitemap-posts-post-1.xml` (377 URLs)

This is a Claude Code execution plan. It covers four objectives:
1. Strip `blog-` prefix from 241 old slugs and set up 301 redirects
2. Ensure all valid blog posts are in the sitemap
3. Ensure redirected/drafted pages are NOT in the sitemap
4. Move service/landing pages out of the blog post type

---

## IMPORTANT CONSTRAINTS

- All code changes go into the EXISTING theme files in this repo
- Slug changes are done via a one-time PHP script that updates `post_name` in the database
- 301 redirects for old `/blog/blog-[slug]/` → `/blog/[slug]/` are handled by a pattern-based redirect (NOT 241 individual entries)
- Do NOT run SSH commands or attempt to verify remote deployment
- Do NOT delete posts — only change status to Draft where needed
- Commit and push to GitHub for WP Engine auto-deploy

---

## Task 1: Pattern-Based Redirect for blog- Prefix Slugs

### Why a pattern redirect instead of 241 individual entries

Adding 241 lines to the redirect map is wasteful and slow. Instead, add a single `preg_match` pattern to `inc/legacy-redirects.php` that catches any `/blog/blog-[slug]/` URL and redirects to `/blog/[slug]/`.

### Implementation

**File to edit:** `inc/legacy-redirects.php`

In the `roden_legacy_content_redirects()` function, find the blog post catch-all block (around line 98). Add the following **BEFORE** the existing catch-all (so it fires first):

```php
    // ── Strip "blog-" prefix from old slugs ──────────────────────────────
    // Old posts had slugs like "blog-what-to-do-when-you-are-in-a-car-accident"
    // which now resolve to /blog/blog-what-to-do.../
    // Redirect to /blog/what-to-do.../ (the new slug after bulk rename)
    if ( preg_match( '#^/blog/blog-(.+?)/?$#', $clean_path, $m ) ) {
        wp_redirect( home_url( '/blog/' . $m[1] . '/' ), 301 );
        exit;
    }
```

This catches ALL `/blog/blog-*` URLs and strips the `blog-` prefix. It works immediately even before the slugs are renamed in the database, because WordPress will 404 on the old slug and this redirect fires on `template_redirect`.

**Important:** This pattern redirect must be placed BEFORE the root-level catch-all block, so the execution order is:
1. Explicit redirect map (Categories 0–11)
2. Pattern: `/case-result/` → `/case-results/`
3. Pattern: `/testimonial/` → `/testimonials/`
4. Pattern: `/staff/` → `/attorneys/`
5. Pattern: `/class-action/` → 410
6. **NEW: Pattern: `/blog/blog-*` → `/blog/*` (strip blog- prefix)**
7. Existing catch-all: root-level slug → `/blog/[slug]/`

---

## Task 2: Bulk Rename Slugs in Database

### One-time PHP script: Strip `blog-` prefix from all post slugs

Create a new file `inc/batch-strip-blog-prefix.php`:

```php
<?php
/**
 * ONE-TIME USE: Bulk-rename post slugs to strip "blog-" prefix.
 *
 * Run via WP-CLI:   wp eval-file wp-content/themes/roden-law/inc/batch-strip-blog-prefix.php
 * Or add temporarily to functions.php with an admin_init hook (remove after running).
 *
 * IMPORTANT: The pattern redirect in legacy-redirects.php handles 301s
 * from old /blog/blog-[slug]/ to new /blog/[slug]/ URLs automatically.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $wpdb;

// Find all published posts whose slug starts with "blog-"
$posts = $wpdb->get_results(
    "SELECT ID, post_name, post_title
     FROM {$wpdb->posts}
     WHERE post_type = 'post'
       AND post_status IN ('publish', 'draft', 'pending')
       AND post_name LIKE 'blog-%'
     ORDER BY ID ASC"
);

$renamed  = 0;
$skipped  = 0;
$conflicts = array();

foreach ( $posts as $post ) {
    $old_slug = $post->post_name;
    $new_slug = preg_replace( '/^blog-/', '', $old_slug );

    // Skip if slug doesn't actually start with blog-
    if ( $new_slug === $old_slug ) {
        $skipped++;
        continue;
    }

    // Check for slug conflicts — another post might already use the new slug
    $existing = $wpdb->get_var( $wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts}
         WHERE post_name = %s AND post_type = 'post' AND ID != %d",
        $new_slug,
        $post->ID
    ) );

    if ( $existing ) {
        $conflicts[] = array(
            'post_id'  => $post->ID,
            'old_slug' => $old_slug,
            'new_slug' => $new_slug,
            'conflict_id' => $existing,
        );
        continue;
    }

    // Rename the slug
    $wpdb->update(
        $wpdb->posts,
        array( 'post_name' => $new_slug ),
        array( 'ID' => $post->ID ),
        array( '%s' ),
        array( '%d' )
    );

    $renamed++;

    // Log progress every 50 posts
    if ( $renamed % 50 === 0 ) {
        if ( defined( 'WP_CLI' ) ) {
            WP_CLI::log( "Renamed {$renamed} slugs so far..." );
        }
    }
}

// Clean permalink cache
clean_post_cache( 0 );
wp_cache_flush();

// Output results
$summary = "BLOG SLUG CLEANUP: Renamed {$renamed} slugs, skipped {$skipped}, conflicts: " . count( $conflicts );

if ( defined( 'WP_CLI' ) ) {
    WP_CLI::success( $summary );
    if ( ! empty( $conflicts ) ) {
        WP_CLI::warning( 'Slug conflicts found:' );
        foreach ( $conflicts as $c ) {
            WP_CLI::log( "  Post {$c['post_id']}: {$c['old_slug']} → {$c['new_slug']} (conflicts with post {$c['conflict_id']})" );
        }
    }
} else {
    error_log( $summary );
    if ( ! empty( $conflicts ) ) {
        error_log( 'Conflicts: ' . print_r( $conflicts, true ) );
    }
}
```

### How to run

**Option A — WP-CLI (preferred):**
```bash
wp eval-file wp-content/themes/roden-law/inc/batch-strip-blog-prefix.php
```

**Option B — One-time admin_init hook:**
Add this to `functions.php`, deploy, visit wp-admin once, then IMMEDIATELY remove it:
```php
add_action( 'admin_init', function() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    if ( get_transient( 'roden_blog_slugs_stripped' ) ) return;
    require_once get_template_directory() . '/inc/batch-strip-blog-prefix.php';
    set_transient( 'roden_blog_slugs_stripped', true, DAY_IN_SECONDS * 30 );
});
```

### Expected results

- ~241 posts renamed (e.g., `blog-what-to-do-when-you-are-in-a-car-accident` → `what-to-do-when-you-are-in-a-car-accident`)
- Any slug conflicts logged (e.g., if `what-to-do-when-you-are-in-a-car-accident` already exists as a different post)
- Conflicts must be resolved manually before those slugs are renamed

### The 241 slugs being renamed

For reference, here is the full list of `blog-` prefix slugs currently in the sitemap. After rename, each becomes the slug without the `blog-` prefix:

```
blog-first-steps-in-a-medical-malpractice-case
blog-truck-accident-reconstruction
blog-after-boat-accident-guide
blog-claims-against-at-fault-drivers-who-died
blog-benefits-for-workplace-violence
blog-value-of-pain-and-suffering
blog-when-does-a-sprained-ankle-become-a-work-injury
blog-calculating-compensation-for-whiplash-injuries
blog-liability-for-epilepsy-related-car-accidents
blog-steps-of-a-burn-injury-case
blog-impact-of-surgery-recommendation
blog-answering-insurance-questions-after-crash
blog-steps-after-work-injury
blog-releasing-medical-records
blog-supporting-a-whiplash-claim
blog-commercial-truck-accidents-who-is-at-fault
blog-what-to-do-if-your-workers-compensation-claim-is-denied
blog-compensatory-damages-vs-punitive-damages
blog-the-importance-of-gathering-evidence-after-a-motorcycle-accident
blog-the-most-common-causes-of-truck-accidents
blog-the-role-of-vocational-rehabilitation-in-workers-compensation-cases
blog-7-mistakes-to-avoid-after-a-motorcycle-accident
blog-5-most-common-types-of-medical-malpractice-in-2023
blog-5-benefits-of-hiring-a-truck-accident-attorney-in-2023
blog-how-long-can-someone-sue-you-after-a-car-accident
blog-what-to-do-when-you-are-in-a-car-accident
blog-are-accident-lawyers-worth-it
blog-how-do-i-know-if-i-have-a-personal-injury-case
blog-does-workers-compensation-cover-prescriptions
blog-can-someone-sue-me-for-a-car-accident
blog-is-there-a-limit-for-medical-negligence-claims
blog-when-does-workers-compensation-stop-paying
blog-what-are-the-upsides-of-filing-a-personal-injury-lawsuit
blog-can-an-insurance-company-go-against-a-police-report
blog-what-are-the-benefits-of-workers-compensation-claims
blog-tips-for-choosing-a-motor-vehicle-accident-attorney
blog-how-long-can-a-person-stay-on-workers-compensation
blog-what-is-the-role-of-a-personal-injury-lawyer-in-a-case
blog-is-workers-compensation-an-employee-benefit
blog-i-was-in-a-car-accident-should-i-pursue-a-personal-injury-claim
blog-why-wont-a-personal-lawyer-take-my-case
blog-why-is-workers-compensation-so-important-to-have
blog-how-can-an-attorney-help-with-my-car-accident-claim
blog-why-should-i-consult-a-personal-injury-lawyer-for-my-accident
blog-does-worker-compensation-cover-employee-negligence
blog-why-should-i-hire-an-accident-lawyer-after-an-accident
blog-when-is-the-right-time-to-hire-a-personal-injury-lawyer
blog-am-i-eligible-for-workers-compensation
blog-can-a-car-accident-lawyer-help-with-claiming-insurance-benefits
blog-should-i-file-a-personal-injury-or-a-workers-compensation-claim
blog-what-if-i-suspect-medical-malpractice
blog-what-happens-if-i-resign-while-on-workers-compensation
blog-steps-to-take-if-you-are-involved-in-a-bicycle-hit-and-run
blog-why-is-having-a-personal-injury-lawyer-important
blog-when-should-you-hire-an-attorney-after-being-in-an-accident
blog-what-are-the-benefits-of-hiring-a-workers-compensation-lawyer
blog-maximum-medical-improvement-in-an-injury-claim
blog-driving-record-and-injury-claim
blog-filing-a-claim-for-an-injured-minor
blog-benefits-of-an-accident-reconstruction-expert
blog-claims-for-lost-wages
blog-liability-for-sudden-emergency-accidents
blog-switching-lawyers-during-a-case
blog-how-car-insurers-use-private-investigators
blog-understanding-vicarious-liability
blog-liens-and-your-personal-injury-claims
blog-letters-of-protection-for-injury-victims
blog-importance-of-eyewitness-testimony
blog-accident-claims-with-an-expired-license
blog-car-insurance-add-ons
blog-liability-for-crashes-in-heavy-rainfall
blog-resolving-claims-through-arbitration
blog-continuing-post-accident-medical-treatment
blog-car-insurance-claim-denial-tactics
blog-options-for-denied-injury-claims
blog-when-to-consider-settling-a-claim
blog-demand-letters-in-personal-injury-cases
blog-independent-medical-exams
blog-options-for-recovering-more-than-policy-limits
blog-mediation-for-a-personal-injury-claim
blog-paying-medical-bills-during-a-claim
blog-questions-about-filing-a-lawsuit
blog-why-injury-claims-may-be-delayed
blog-discovery-process-in-personal-injury-cases
blog-liability-waivers-and-injury-lawsuits
blog-police-report-as-proof-of-liability
blog-expert-witness-testimony
blog-liability-for-crashes-caused-by-teen-drivers
blog-lane-change-accident-liability
blog-choosing-your-personal-injury-lawyer
blog-when-do-injury-claims-go-to-court
blog-pedestrian-liability-for-car-accidents
blog-liability-for-accidents-with-borrowed-vehicles
blog-follow-doctors-orders-after-accident
blog-traffic-tickets-and-car-accident-claims
blog-how-covid-19-affects-a-workers-comp-claim
blog-personal-injury-lawsuit-vs-insurance-claim
blog-how-to-handle-calls-from-insurance-companies
blog-insurance-company-ignoring-demand-letter
blog-certification-of-permanent-injury
blog-animal-accident-insurance-coverage
blog-start-personal-injury-claim-from-home
blog-damage-coverage-for-stolen-car
blog-fault-vs-no-fault-car-insurance
blog-liability-for-school-bus-crash
blog-valuing-compensation-for-a-personal-injury
blog-workers-comp-medical-coverage
blog-contingency-fee-system
blog-liability-in-a-driverless-car-crash
blog-deposition-in-a-personal-injury-claim
blog-negligence-vs-gross-negligence
blog-using-uninsured-underinsured-motorist-coverage-in-georgia
blog-qualifications-for-car-accident-witnesses
blog-compensation-while-not-wearing-seat-belt
blog-accident-my-fault-can-i-receive-workers-comp
blog-workers-comp-for-carpal-tunnel-syndrome
blog-turkey-fryer-injury-claims
blog-major-injuries-from-minor-car-accidents
blog-changing-workers-comp-doctors-in-georgia
blog-refusing-opioid-prescription-in-workers-comp-claim
blog-georgia-law-on-steps-after-car-accident
blog-drunk-pedestrian-injury-claims
blog-georgia-law-on-tailgating-accident-liability
blog-taxes-on-car-crash-settlement-in-georgia
blog-punitive-damages-in-drunk-driving-accident
blog-what-happens-to-workers-comp-if-employer-bankrupts
blog-benefit-of-a-personal-injury-pain-diary
blog-determining-fault-in-multi-vehicle-accidents
blog-workers-comp-for-skin-cancer
blog-work-zone-car-accident-liability
blog-how-using-social-media-can-hurt-an-accident-claim
blog-personal-injury-calculating-loss-of-earning-capacity
blog-reasons-for-workers-comp-claim-denial
blog-using-dashcams-as-evidence-of-fault-in-a-car-accident
blog-rear-end-collision-liability
blog-trucking-regulations-and-accident-cases
blog-third-party-fault-for-work-injuries
blog-aggressive-driving-in-georgia
blog-workers-compensation-faqs
blog-workers-compensation-benefit-types
blog-negligence-and-18-wheeler-accidents
blog-dealing-with-uber-lyft-accident
blog-medical-treatment-after-accident
blog-avoiding-motorcycle-crash-injuries
blog-georgia-super-speeder-law
blog-car-accidents-and-daylight-savings-time
blog-nursing-home-abuse-warning-signs
blog-documents-for-personal-injury-claim
blog-teenagers-and-driving-distracted
blog-steps-after-slip-and-fall-injury
blog-steps-after-dog-bite
blog-advantages-of-a-medical-malpractice-attorney
blog-safe-driving-in-construction-zones
blog-road-hazard-car-accident-liability
blog-workers-compensation-car-accident
blog-nursing-home-liability
blog-seven-safe-driving-tips
blog-passenger-car-accident-claim
blog-slip-and-fall-negligence-elements
blog-filing-medication-error-lawsuit
blog-car-accident-claim-evidence
blog-appealing-a-denied-workers-compensation-claim
blog-workers-compensation-claim-process-georgia
blog-truck-accident-liability
blog-recovering-damages-with-pre-existing-injuries
blog-personal-injury-lawsuit-steps
blog-how-do-i-know-if-i-have-a-medical-malpractice-case
blog-georgia-wrongful-death-lawsuit
blog-brain-injury-claim
blog-benefits-of-hiring-personal-injury-lawyer
blog-duty-of-care-personal-injury-claim
blog-social-media-personal-injury-claim
blog-third-party-liability-for-work-injury
blog-roadway-hazard-auto-accident
blog-proving-negligence-personal-injury
blog-four-common-construction-accidents
blog-driving-tips-around-trucks
blog-informed-consent
blog-summer-road-trip-safety
blog-choking-at-nursing-homes
blog-how-spinal-cord-injuries-affect-you
blog-avoiding-bicycle-accidents
blog-hospital-liability-for-medical-malpractice
blog-truck-accident-injuries
blog-blind-spot-accidents
blog-steps-after-truck-accident
blog-dog-bite-prevention-tips
blog-lawsuit-for-work-injury
blog-signs-of-concussion-from-car-crash
blog-fault-for-car-accident
blog-financial-abuse-at-nursing-homes
blog-georgia-comparative-negligence-law
blog-steps-after-hit-and-run-accident
blog-georgia-statute-of-limitations
blog-burn-injury-workers-compensation
blog-do-you-need-a-workers-compensation-lawyer
blog-savannah-ppi-attorney
blog-valid-premises-liability-claim-georgia
blog-atm-attack-liability
blog-workers-compensation-2017
blog-high-risk-occupations-2017
blog-longshoreman-injury-claims
blog-gym-injury-liability
blog-2017-safest-college-campuses-in-georgia
blog-much-worth-ga-worker-compared-states
blog-settle-workers-comp-case
blog-beginning-motorcycle-biker-risks
blog-get-auto-accident-claim-georgia
blog-georgia-worker-injury-statistics-prevention
blog-pedestrian-safety-georgia
blog-safest-hospitals-georgia
blog-help-teen-safer-driver
blog-safe-bike-riding-georgias-roadways
blog-dui-accidents
blog-summer-driving-safety-tips
blog-common-driver-distractions
blog-avoid-dangerous-medication-errors
blog-dangerous-tools-garage
blog-child-passenger-automobile-safety-georgia
blog-drowsy-driving-epidemic-georgia
blog-steps-take-slip-fall-accident-georgia
blog-protecting-child-burn-injuries-home
blog-college-campus-safety-tips-every-student-should-know
blog-dangerous-products-child-will-find-around-house
blog-protect-child-dog-bite-injury
blog-choosing-the-right-nursing-home-for-your-loved-one
blog-overview-georgia-distracted-driving-laws
blog-georgia-car-seat-law-overview
blog-safety-tips-driving-work-zones-georgia
blog-common-workplace-injuries-georgia
blog-boating-safely-in-georgia
blog-workers-comp-benefits-georgia-taxable
blog-leg-pain-and-leg-injuries-from-crash
blog-understanding-eye-injuries-after-a-savannah-car-accident
blog-how-loud-music-increases-crash-risk-charleston
blog-liability-and-causes-for-backing-up-crashes-in-charleston
blog-filing-soft-tissue-injury-claims-in-charleston
blog-sapelo-island-ferry-dock-collapse-causing-fatality-and-serious-injuries
blog-free-consultation-with-charleston-personal-injury-lawyer
blog-shoulder-injuries-after-charleston-car-crash
blog-charleston-reckless-driving-crash
```

---

## Task 3: Sitemap Cleanup — Remove Redirected/Invalid Pages

The following URLs are currently in `wp-sitemap-posts-post-1.xml` and MUST be removed by drafting the posts:

### 3A: Broken slug (still in sitemap)

```
https://rodenlaw.com/blog/request-your-free-case-review-today-main_phone_number/
```
**Action:** Set post to Draft in wp-admin. The redirect in Category 11 of `legacy-redirects.php` already sends this to `/contact/`.

### 3B: Duplicate Coleman Boulevard posts (both in sitemap)

```
https://rodenlaw.com/blog/car-accidents-on-coleman-boulevard/
https://rodenlaw.com/blog/car-accidents-on-coleman-boulevard-in-mount-pleasant/ (KEEP)
```
**Action:** Merge content into the Mount Pleasant version. Draft the shorter-slug version.

### 3C: Duplicate Columbia truck accident guides (all 3 in sitemap)

```
https://rodenlaw.com/blog/a-practical-guide-after-a-truck-accident-in-downtown-columbia/
https://rodenlaw.com/blog/your-first-steps-after-a-truck-accident-in-downtown-columbia-sc/
https://rodenlaw.com/blog/your-step-by-step-guide-after-a-downtown-columbia-truck-accident/ (KEEP)
```
**Action:** Merge content into the canonical version. Draft the other two.

### 3D: After slug rename, old blog- URLs will auto-drop from sitemap

Once the slugs are renamed in the database (Task 2), the sitemap will automatically reflect the new URLs (e.g., `/blog/what-to-do-when-you-are-in-a-car-accident/` instead of `/blog/blog-what-to-do...`). No manual sitemap editing needed — WordPress regenerates `wp-sitemap-posts-post-1.xml` dynamically.

---

## Task 4: Move Service/Landing Pages Out of Blog Post Type

### Pages to convert from `post` to `page`:

**4A: Savannah PPI Attorney page**
- Current: `https://rodenlaw.com/blog/blog-savannah-ppi-attorney/` (or `/blog/savannah-ppi-attorney/` after rename)
- Problem: This is a service page for a specific attorney/office, not educational blog content
- Action: Change post_type from `post` to `page`. Set up redirect from old URL to new page URL.

**4B: Charleston Free Consultation page**
- Current: `https://rodenlaw.com/blog/blog-free-consultation-with-charleston-personal-injury-lawyer/`
- Problem: This is a lead-gen CTA page, not a blog post
- Action: Change post_type from `post` to `page`. Set up redirect from old URL to new page URL or to `/contact/`.

### Script to convert post type

Add to `inc/batch-strip-blog-prefix.php` or create a separate one-time script:

```php
/**
 * Convert service/landing pages from post to page type.
 * Run via WP-CLI: wp eval-file wp-content/themes/roden-law/inc/batch-convert-service-pages.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$service_slugs = array(
    'blog-savannah-ppi-attorney',
    'blog-free-consultation-with-charleston-personal-injury-lawyer',
);

global $wpdb;

foreach ( $service_slugs as $slug ) {
    $post = get_page_by_path( $slug, OBJECT, 'post' );

    // Also check without blog- prefix (in case rename already ran)
    if ( ! $post ) {
        $clean_slug = preg_replace( '/^blog-/', '', $slug );
        $post = get_page_by_path( $clean_slug, OBJECT, 'post' );
    }

    if ( ! $post ) {
        $msg = "NOT FOUND: {$slug}";
        defined( 'WP_CLI' ) ? WP_CLI::warning( $msg ) : error_log( $msg );
        continue;
    }

    // Change post type to page
    $wpdb->update(
        $wpdb->posts,
        array( 'post_type' => 'page' ),
        array( 'ID' => $post->ID ),
        array( '%s' ),
        array( '%d' )
    );

    clean_post_cache( $post->ID );

    $msg = "Converted post {$post->ID} ({$slug}) from post → page";
    defined( 'WP_CLI' ) ? WP_CLI::success( $msg ) : error_log( $msg );
}
```

After conversion, add redirects in `legacy-redirects.php` Category 11:

```php
        // Service pages moved from blog to pages
        '/blog/savannah-ppi-attorney/'                                         => '/savannah-ppi-attorney/',
        '/blog/blog-savannah-ppi-attorney/'                                    => '/savannah-ppi-attorney/',
        '/blog/free-consultation-with-charleston-personal-injury-lawyer/'       => '/free-consultation-with-charleston-personal-injury-lawyer/',
        '/blog/blog-free-consultation-with-charleston-personal-injury-lawyer/'  => '/free-consultation-with-charleston-personal-injury-lawyer/',
```

---

## Execution Order

This order matters — deploy the redirect FIRST, then rename slugs.

### Step 1: Deploy redirect pattern (immediate — code change)
1. Edit `inc/legacy-redirects.php` — add the `blog-` prefix strip pattern (Task 1)
2. Commit and push to GitHub
3. Wait for WP Engine deploy

### Step 2: Run bulk slug rename (after redirect is live)
1. SSH or WP-CLI into WP Engine
2. Run `wp eval-file wp-content/themes/roden-law/inc/batch-strip-blog-prefix.php`
3. Check output for conflicts
4. Resolve any slug conflicts manually

### Step 3: Manual drafting in wp-admin (after slug rename)
1. Draft the broken-slug post (Task 3A)
2. Merge and draft duplicate Coleman Blvd post (Task 3B)
3. Merge and draft duplicate Columbia truck posts (Task 3C)

### Step 4: Convert service pages (after drafting)
1. Run `wp eval-file wp-content/themes/roden-law/inc/batch-convert-service-pages.php`
2. Add service page redirects to `legacy-redirects.php`
3. Commit and push

### Step 5: Verify sitemap
1. Check `https://rodenlaw.com/wp-sitemap-posts-post-1.xml`
2. Confirm: NO URLs contain `/blog/blog-` prefix (all should be `/blog/[clean-slug]/`)
3. Confirm: broken slug NOT in sitemap
4. Confirm: duplicate posts NOT in sitemap (they're drafted)
5. Confirm: service pages NOT in post sitemap (they're now pages)
6. Confirm: all valid posts ARE in sitemap

---

## Verification Checklist

### Redirects working:
- [ ] `/blog/blog-what-to-do-when-you-are-in-a-car-accident/` → 301 to `/blog/what-to-do-when-you-are-in-a-car-accident/`
- [ ] `/blog/blog-georgia-comparative-negligence-law/` → 301 to `/blog/georgia-comparative-negligence-law/`
- [ ] `/blog/blog-workers-compensation-faqs/` → 301 to `/blog/workers-compensation-faqs/`
- [ ] `/blog/request-your-free-case-review-today-main_phone_number/` → 301 to `/contact/`
- [ ] `/blog/car-accidents-on-coleman-boulevard/` → 301 to `/blog/car-accidents-on-coleman-boulevard-in-mount-pleasant/`

### Sitemap clean:
- [ ] No `/blog/blog-` prefix URLs in sitemap
- [ ] No broken slug in sitemap
- [ ] No duplicate pages in sitemap
- [ ] No service/landing pages in post sitemap
- [ ] All 370+ valid blog posts present in sitemap

### No false positives:
- [ ] `/blog/dangerous-savannah-intersections/` loads normally (does NOT match `blog-` strip pattern because slug doesn't start with `blog-`)
- [ ] `/blog/charleston-medical-malpractice-hospital-claim-south-carolina/` loads normally
- [ ] Practice area pages unaffected
- [ ] Existing legacy redirects (Categories 0–11) still work

---

## Git Workflow

```bash
# Step 1: Add redirect pattern + batch scripts
git add inc/legacy-redirects.php inc/batch-strip-blog-prefix.php inc/batch-convert-service-pages.php
git commit -m "Add blog- prefix strip redirect and batch rename/convert scripts for blog cleanup"
git push origin main

# Step 4: After running scripts and adding service page redirects
git add inc/legacy-redirects.php
git commit -m "Add service page redirects after blog-to-page conversion"
git push origin main
```

---

## Summary

| Action | Count | Method |
|--------|-------|--------|
| Strip `blog-` prefix from slugs | 241 | Batch DB script + pattern redirect |
| Draft broken/duplicate posts | 4 | Manual in wp-admin |
| Convert service pages to page type | 2 | Batch DB script |
| New redirects added | 1 pattern + 4 explicit | `legacy-redirects.php` |
| Sitemap entries removed | ~6 | Auto (draft status + type change) |
| Valid posts retained in sitemap | ~371 | Auto (WordPress generates dynamically) |
