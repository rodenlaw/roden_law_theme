<?php
/**
 * Roden Law — Legacy Content Redirects
 *
 * 301 redirects for old practice-area CPT pages → new practice_area CPT pages.
 * Generated March 2026 from dev site audit.
 *
 * TOTAL: 135+ redirects across 10 categories + 4 pattern-based rules
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ------------------------------------------------------------------
   Neutralize old practice-area (hyphen) CPT registered by ACF.
   Keeps posts accessible in wp-admin but removes front-end URLs,
   archives, and sitemap entries.
   ------------------------------------------------------------------ */

add_filter( 'register_post_type_args', 'roden_neutralize_old_practice_area_cpt', 10, 2 );

function roden_neutralize_old_practice_area_cpt( $args, $post_type ) {
    if ( 'practice-area' === $post_type ) {
        $args['public']              = false;
        $args['publicly_queryable']  = false;
        $args['exclude_from_search'] = true;
        $args['has_archive']         = false;
        $args['show_ui']             = true;
        $args['show_in_menu']        = true;
        $args['label']               = 'Old Practice Areas (Legacy)';
        $args['labels']['name']      = 'Old Practice Areas (Legacy)';
        $args['labels']['menu_name'] = 'Old PAs (Legacy)';
    }

    if ( 'class-action' === $post_type ) {
        $args['public']              = false;
        $args['publicly_queryable']  = false;
        $args['exclude_from_search'] = true;
        $args['has_archive']         = false;
        $args['show_ui']             = true;
        $args['show_in_menu']        = true;
        $args['label']               = 'Old Class Actions (Legacy)';
        $args['labels']['name']      = 'Old Class Actions (Legacy)';
        $args['labels']['menu_name'] = 'Old CAs (Legacy)';
    }

    return $args;
}

/* ------------------------------------------------------------------
   Header nav: "View All Service Areas" pointed at ?page_id=3126, a
   deleted page (sitewide 404). Rewrite that menu item to the live
   Practice Areas hub. Robust to menu-item ID changes — matches the URL.
   Remove this filter once the menu item is fixed in Appearance → Menus.
   ------------------------------------------------------------------ */

add_filter( 'wp_nav_menu_objects', 'roden_fix_dead_nav_links', 10, 2 );

function roden_fix_dead_nav_links( $items, $args ) {
    foreach ( $items as $item ) {
        if ( isset( $item->url ) && false !== strpos( $item->url, 'page_id=3126' ) ) {
            $item->url = home_url( '/practice-areas/' );
        }
    }
    return $items;
}

/* ------------------------------------------------------------------
   301: duplicate CPT path → canonical top-level URL.

   Child practice_area posts (intersection + sub-type) resolve at BOTH
   the canonical rewrite path /{pillar}/{child}/ AND WordPress's native
   hierarchical CPT path /practice-areas/{pillar}/{child}/. The latter is
   a duplicate (served 200, canonical-tagged to the top-level). 301 it to
   the canonical so the duplicate stops serving 200 for external/legacy
   hits. Internal links are already fixed at the source by the
   post_type_link filter (roden_pa_permalink). Pillars are untouched.
   ------------------------------------------------------------------ */

add_action( 'template_redirect', 'roden_redirect_duplicate_pa_path', 1 );

function roden_redirect_duplicate_pa_path() {
    if ( ! function_exists( 'roden_is_pa_singular' ) || ! roden_is_pa_singular() ) {
        return;
    }

    $post = get_post();
    if ( ! $post || ! $post->post_parent ) {
        return; // Pillars (no parent) keep /practice-areas/{slug}/.
    }

    $canonical = roden_get_canonical_url( $post );
    if ( ! $canonical ) {
        return;
    }

    // Compare path-only to avoid host/query noise and redirect loops.
    $canonical_path = trailingslashit( (string) wp_parse_url( $canonical, PHP_URL_PATH ) );
    $request_path   = trailingslashit( strtok( $_SERVER['REQUEST_URI'], '?' ) );

    if ( $request_path !== $canonical_path ) {
        $qs     = ( isset( $_SERVER['QUERY_STRING'] ) && '' !== $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '';
        wp_safe_redirect( $canonical . $qs, 301 );
        exit;
    }
}

/* ------------------------------------------------------------------
   301 Redirects — old URLs → new URLs
   ------------------------------------------------------------------ */

add_action( 'template_redirect', 'roden_legacy_content_redirects', 1 );

function roden_legacy_content_redirects() {
    // Deleted pages still indexed/linked as raw ?page_id= permalinks.
    // (Query strings are stripped below, so handle them before path matching.)
    if ( isset( $_GET['page_id'] ) ) {
        $dead_page_ids = array(
            '3126' => '/practice-areas/', // "Service Areas" (also linked from header nav)
            '1894' => '/',                // deleted page, destination unknown → home
        );
        $pid = (string) $_GET['page_id'];
        if ( isset( $dead_page_ids[ $pid ] ) ) {
            wp_redirect( home_url( $dead_page_ids[ $pid ] ), 301 );
            exit;
        }
    }

    // Neutralized legacy practice-area CPT raw permalinks
    // (?post_type=practice-area&p=ID). The CPT is non-public (see
    // roden_neutralize_old_practice_area_cpt above), so these all 404.
    // Send the whole family to the practice-areas hub.
    if ( isset( $_GET['post_type'], $_GET['p'] ) && 'practice-area' === $_GET['post_type'] ) {
        wp_redirect( home_url( '/practice-areas/' ), 301 );
        exit;
    }

    $request = rtrim( $_SERVER['REQUEST_URI'], '/' ) . '/';

    // Strip query strings for matching
    $clean_path = strtok( $request, '?' );
    $clean_path = rtrim( $clean_path, '/' ) . '/';

    $redirects = roden_get_legacy_redirect_map();

    if ( isset( $redirects[ $clean_path ] ) ) {
        $dest = $redirects[ $clean_path ];

        // 410 Gone for permanently removed content (value === false).
        if ( false === $dest ) {
            status_header( 410 );
            nocache_headers();
            echo '<h1>410 Gone</h1><p>This page has been permanently removed.</p>';
            exit;
        }

        wp_redirect( home_url( $dest ), 301 );
        exit;
    }

    // ── Pattern-based redirects ──────────────────────────────────────────
    // These handle entire URL prefixes rather than individual pages.

    // /es/* → / (Polylang removed 2026-05-05; Spanish content was 1 empty
    // placeholder + 2 drafts. Pre-removal, /es/* was already in an infinite
    // 301 redirect loop, so nothing was indexed. This 301 prevents future 404s
    // if Google or any external link ever surfaces an /es/ URL.)
    if ( preg_match( '#^/es(/.*)?$#', $clean_path ) ) {
        wp_redirect( home_url( '/' ), 301 );
        exit;
    }

    // /case-result/[slug]/ → /case-results/[slug]/ (old singular → new plural CPT slug)
    // Only redirect to the specific result if it still exists; otherwise the
    // pluralized path 404s (many old case-result posts were removed). Fall
    // back to the live /case-results/ archive.
    if ( preg_match( '#^/case-result/([^/]+)/?$#', $clean_path, $m ) ) {
        $cr   = get_page_by_path( $m[1], OBJECT, 'case_result' );
        $dest = ( $cr && 'publish' === $cr->post_status )
            ? get_permalink( $cr->ID )
            : home_url( '/case-results/' );
        wp_redirect( $dest, 301 );
        exit;
    }

    // /testimonial/[slug]/ → /testimonials/[slug]/ (old singular → new plural CPT slug)
    if ( preg_match( '#^/testimonial/([^/]+)/?$#', $clean_path, $m ) ) {
        wp_redirect( home_url( '/testimonials/' . $m[1] . '/' ), 301 );
        exit;
    }

    // /staff/[name]/ → /attorneys/ (old staff CPT pages)
    if ( preg_match( '#^/staff/[^/]+/?$#', $clean_path ) ) {
        wp_redirect( home_url( '/attorneys/' ), 301 );
        exit;
    }

    // /class-action/[slug]/ → /class-action-lawyers/[slug]/ (old CPT → new child pages)
    if ( preg_match( '#^/class-action/([^/]+)/?$#', $clean_path, $m ) ) {
        wp_redirect( home_url( '/class-action-lawyers/' . $m[1] . '/' ), 301 );
        exit;
    }

    // /class-action-lawyers/[category]/[case]/ → /class-action-lawyers/ (nested old class-action pages)
    if ( preg_match( '#^/class-action-lawyers/[^/]+/[^/]+/?$#', $clean_path ) ) {
        wp_redirect( home_url( '/class-action-lawyers/' ), 301 );
        exit;
    }

    // ── City-first intersection redirects ──────────────────────────────
    // Old format: /[city]/[pa-slug]/ and /[city]/[pa-slug]/[subtype]/
    // New format: /[pa-slug]/[city-state]/
    // Covers savannah, charleston, brunswick (edge cases), albany, macon

    // Map of old PA slugs → current PA slugs (only where they differ)
    $pa_slug_map = array(
        'medical-malpractice-attorneys'  => 'medical-malpractice-lawyers',
        'medical-malpractice-attorney'   => 'medical-malpractice-lawyers',
        'maritime-lawyers'               => 'maritime-injury-lawyers',
        'nursing-home-abuse-attorneys'   => 'nursing-home-abuse-lawyers',
        'nursing-home-abuse-attorney'    => 'nursing-home-abuse-lawyers',
        'nursing-home-abuse-lawyer'      => 'nursing-home-abuse-lawyers',
        'slip-and-fall-attorneys'        => 'slip-and-fall-lawyers',
        'slip-and-fall-attorney'         => 'slip-and-fall-lawyers',
        'slip-and-fall-lawyer'           => 'slip-and-fall-lawyers',
        'workers-compensation-attorney'  => 'workers-compensation-lawyers',
        'workers-compensation-lawyer'    => 'workers-compensation-lawyers',
        'personal-injury-lawyer'         => 'personal-injury-lawyers',
        'car-accident-lawyer'            => 'car-accident-lawyers',
        'truck-accident-lawyer'          => 'truck-accident-lawyers',
        'burn-injury-lawyer'             => 'burn-injury-lawyers',
        'brain-injury-lawyer'            => 'brain-injury-lawyers',
        'wrongful-death-lawyer'          => 'wrongful-death-lawyers',
        'boating-accident-lawyer'        => 'boating-accident-lawyers',
        'spinal-cord-injury-lawyer'      => 'spinal-cord-injury-lawyers',
        'motorcycle-accident-lawyer'     => 'motorcycle-accident-lawyers',
        'construction-accident-lawyer'   => 'construction-accident-lawyers',
        'dog-bite-lawyer'                => 'dog-bite-lawyers',
        'product-liability-lawyer'       => 'product-liability-lawyers',
        'coronavirus-business-claims'    => 'car-accident-lawyers', // deprecated → most relevant pillar
    );

    // City → destination slug mapping (cities with offices)
    $city_dest = array(
        'savannah'   => 'savannah-ga',
        'charleston' => 'charleston-sc',
        'brunswick'  => 'darien-ga',
    );

    // /[city]/[pa-slug]/[subtype]/ → /[pa-slug]/[city-state]/ (3-segment, check first)
    if ( preg_match( '#^/(savannah|charleston|brunswick)/([^/]+)/([^/]+)/?$#', $clean_path, $m ) ) {
        $city    = $m[1];
        $pa_slug = isset( $pa_slug_map[ $m[2] ] ) ? $pa_slug_map[ $m[2] ] : $m[2];
        $dest    = $city_dest[ $city ];
        wp_redirect( home_url( '/' . $pa_slug . '/' . $dest . '/' ), 301 );
        exit;
    }

    // /[city]/[pa-slug]/ → /[pa-slug]/[city-state]/ (2-segment)
    if ( preg_match( '#^/(savannah|charleston|brunswick)/([^/]+)/?$#', $clean_path, $m ) ) {
        $city    = $m[1];
        $pa_slug = isset( $pa_slug_map[ $m[2] ] ) ? $pa_slug_map[ $m[2] ] : $m[2];
        $dest    = $city_dest[ $city ];
        wp_redirect( home_url( '/' . $pa_slug . '/' . $dest . '/' ), 301 );
        exit;
    }

    // /albany/[pa-slug]/ and /macon/[pa-slug]/ → /practice-areas/[pa-slug]/ (no office)
    if ( preg_match( '#^/(albany|macon)/([^/]+)/?$#', $clean_path, $m ) ) {
        $pa_slug = isset( $pa_slug_map[ $m[2] ] ) ? $pa_slug_map[ $m[2] ] : $m[2];
        wp_redirect( home_url( '/practice-areas/' . $pa_slug . '/' ), 301 );
        exit;
    }

    // /macon/practice-areas/ and /albany/practice-areas/ → /practice-areas/
    if ( preg_match( '#^/(macon|albany)/practice-areas/?$#', $clean_path ) ) {
        wp_redirect( home_url( '/practice-areas/' ), 301 );
        exit;
    }

    // /practice-areas/[city]/[pa-slug]/[subtype]/ → /[pa-slug]/[city-state]/ (3-segment under practice-areas)
    if ( preg_match( '#^/practice-areas/(savannah|charleston|brunswick)/([^/]+)/([^/]+)/?$#', $clean_path, $m ) ) {
        $city    = $m[1];
        $pa_slug = isset( $pa_slug_map[ $m[2] ] ) ? $pa_slug_map[ $m[2] ] : $m[2];
        $dest    = $city_dest[ $city ];
        wp_redirect( home_url( '/' . $pa_slug . '/' . $dest . '/' ), 301 );
        exit;
    }

    // /practice-areas/[city]/[pa-slug]/ → /[pa-slug]/[city-state]/ (2-segment under practice-areas)
    if ( preg_match( '#^/practice-areas/(savannah|charleston|brunswick)/([^/]+)/?$#', $clean_path, $m ) ) {
        $city    = $m[1];
        $pa_slug = isset( $pa_slug_map[ $m[2] ] ) ? $pa_slug_map[ $m[2] ] : $m[2];
        $dest    = $city_dest[ $city ];
        wp_redirect( home_url( '/' . $pa_slug . '/' . $dest . '/' ), 301 );
        exit;
    }

    // /practice-areas/[albany|macon]/[pa-slug]/ → /practice-areas/[pa-slug]/ (no office)
    if ( preg_match( '#^/practice-areas/(albany|macon)/([^/]+)/?$#', $clean_path, $m ) ) {
        $pa_slug = isset( $pa_slug_map[ $m[2] ] ) ? $pa_slug_map[ $m[2] ] : $m[2];
        wp_redirect( home_url( '/practice-areas/' . $pa_slug . '/' ), 301 );
        exit;
    }

    // /practice-area/[slug]/ → /practice-areas/[corrected-slug]/ (old singular CPT)
    if ( preg_match( '#^/practice-area/([^/]+)/?$#', $clean_path, $m ) ) {
        $pa_slug = isset( $pa_slug_map[ $m[1] ] ) ? $pa_slug_map[ $m[1] ] : $m[1];
        // Ensure trailing 's' for pluralization if not in map
        if ( substr( $pa_slug, -1 ) !== 's' ) {
            $pa_slug .= 's';
        }
        wp_redirect( home_url( '/practice-areas/' . $pa_slug . '/' ), 301 );
        exit;
    }

    // /practice-area-location/[city]/ → /practice-areas/ (old taxonomy-style URLs)
    if ( preg_match( '#^/practice-area-location/[^/]+#', $clean_path ) ) {
        wp_redirect( home_url( '/practice-areas/' ), 301 );
        exit;
    }

    // /tag/[slug]/ → /blog/ (old tag archives, taxonomy removed from sitemap)
    if ( preg_match( '#^/tag/[^/]+/?$#', $clean_path ) ) {
        wp_redirect( home_url( '/blog/' ), 301 );
        exit;
    }

    // /es/[anything] → / (Spanish content removed)
    if ( preg_match( '#^/es/.+#', $clean_path ) ) {
        wp_redirect( home_url( '/' ), 301 );
        exit;
    }

    // /who-we-are/attorney/[name]/ → /attorneys/[name]/ (singular 'attorney' variant)
    if ( preg_match( '#^/who-we-are/attorney/([^/]+)/?$#', $clean_path, $m ) ) {
        wp_redirect( home_url( '/attorneys/' . $m[1] . '/' ), 301 );
        exit;
    }

    // /attorney/[mangled-slug]/ → /attorneys/ (old CPT with bad slugs)
    if ( preg_match( '#^/attorney/[^/]+/?$#', $clean_path ) ) {
        wp_redirect( home_url( '/attorneys/' ), 301 );
        exit;
    }

    // ── Strip "blog-" prefix from old slugs ──────────────────────────────
    // Old posts had slugs like "blog-what-to-do-when-you-are-in-a-car-accident"
    // now resolving to /blog/blog-what-to-do.../. Many of these posts were
    // later consolidated or deleted, so a blind redirect to /blog/[slug]/
    // produced a 301→404 chain. roden_resolve_legacy_blog_dest() picks the
    // correct live destination (consolidation target, live post, or /blog/).
    if ( preg_match( '#^/blog/blog-(.+?)/?$#', $clean_path, $m ) ) {
        wp_redirect( roden_resolve_legacy_blog_dest( $m[1] ), 301 );
        exit;
    }

    // Root-level /blog-[slug]/ (old /%postname%/ posts whose slug began "blog-").
    if ( preg_match( '#^/blog-(.+?)/?$#', $clean_path, $m ) ) {
        wp_redirect( roden_resolve_legacy_blog_dest( $m[1] ), 301 );
        exit;
    }

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
}

/**
 * Resolve where a legacy "blog-"-prefixed slug should 301 to.
 * Order: explicit consolidation map (root-level key) → a live /blog/[slug]/
 * post → /blog/ archive fallback. Never returns a known-404 URL.
 */
function roden_resolve_legacy_blog_dest( $base ) {
    $base = trim( $base, '/' );

    // 1. Consolidation map keyed at root level (CATEGORY 12 entries), e.g.
    //    '/why-should-i-hire-an-accident-lawyer-after-an-accident/' => '/are-...'
    $map = roden_get_legacy_redirect_map();
    $key = '/' . $base . '/';
    if ( isset( $map[ $key ] ) && false !== $map[ $key ] ) {
        return home_url( $map[ $key ] );
    }

    // 2. A live blog post actually exists at /blog/[slug]/.
    $post_obj = get_page_by_path( $base, OBJECT, 'post' );
    if ( $post_obj && 'publish' === $post_obj->post_status ) {
        return home_url( '/blog/' . $base . '/' );
    }

    // 3. Safe fallback — the blog index (200), never a 404.
    return home_url( '/blog/' );
}

function roden_get_legacy_redirect_map() {
    return array(

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 14: 404 remediation — 2026-06-15
        // Live-site audit found these returning a hard 404 with no redirect
        // (pages live as recently as April 2026). See docs/404-audit-2026-06-15.md
        // ══════════════════════════════════════════════════════════════

        // Old top-level practice-area pages (single segment never matched the
        // /[pa]/[city]/ intersection rewrite, so they 404). → pillar pages.
        '/burn-injury-lawyers/'          => '/practice-areas/burn-injury-lawyers/',
        '/construction-accident-lawyers/' => '/practice-areas/construction-accident-lawyers/',
        '/product-liability-lawyers/'    => '/practice-areas/product-liability-lawyers/',
        '/slip-and-fall-lawyers/'        => '/practice-areas/slip-and-fall-lawyers/',
        '/workers-compensation-lawyers/' => '/practice-areas/workers-compensation-lawyers/',
        '/wrongful-death-lawyers/'       => '/practice-areas/wrongful-death-lawyers/',

        // Old CTA + stray index pages
        '/free-case-review/'             => '/contact/',
        '/practice-areas/brunswick/'     => '/practice-areas/',
        '/practice-areas/general/'       => '/practice-areas/',

        // Intended sub-type page that was never created
        '/car-accident-lawyers/rideshare-accident/' => '/practice-areas/car-accident-lawyers/',

        // Taxonomy archives removed from the site
        '/category/lost-wages-support/'              => '/blog/',
        '/class-action-category/dangerous-drugs/'    => '/class-action-lawyers/',
        '/class-action-category/defective-medical-devices/' => '/class-action-lawyers/',
        '/class-action-category/defective-products/' => '/class-action-lawyers/',
        '/class-action-lawyers/dangerous-drugs/'     => '/class-action-lawyers/',

        // Deleted / renamed blog posts → closest live topical page
        '/blog/a-practical-guide-after-a-truck-accident-in-downtown-columbia/' => '/blog/your-step-by-step-guide-after-a-downtown-columbia-truck-accident/',
        '/blog/accidents-near-musc-and-calhoun-street/'        => '/car-accident-lawyers/charleston-sc/',
        '/accidents-near-musc-and-calhoun-street/'             => '/car-accident-lawyers/charleston-sc/',
        '/blog/blunt-force-trauma-after-savannah-car-crash/'   => '/blog/blunt-force-trauma-from-a-crash-what-you-need-to-know/',
        '/blog/can-passengers-be-at-fault-for-a-savannah-crash/' => '/car-accident-lawyers/savannah-ga/',
        '/blog/charleston-car-crash-facial-injuries/'          => '/car-accident-lawyers/charleston-sc/',
        '/blog/charleston-port-drayage-truck-accidents/'       => '/truck-accident-lawyers/charleston-sc/',
        '/blog/highway-hypnosis-what-it-is-why-it-is-a-crash-risk/' => '/practice-areas/car-accident-lawyers/',
        '/blog/highway-road-shoulder-accidents-in-charleston/' => '/car-accident-lawyers/charleston-sc/',
        '/blog/how-to-get-your-charleston-police-accident-report/' => '/car-accident-lawyers/charleston-sc/',
        '/blog/i-was-in-a-car-accident-should-i-pursue-a-personal-injury-claim/' => '/how-do-i-know-if-i-have-a-personal-injury-case/',
        '/blog/legal-help-shoulder-injuries-after-charleston-car-crash/' => '/car-accident-lawyers/charleston-sc/',
        '/blog/liability-for-backing-up-crashes-in-charleston/' => '/car-accident-lawyers/charleston-sc/',
        '/blog/myrtle-beach-golf-cart-laws/'                   => '/practice-areas/golf-cart-accident-lawyers/',
        '/blog/south-carolina-golf-cart-laws/'                 => '/practice-areas/golf-cart-accident-lawyers/',
        '/blog/request-your-free-case-review-today-main_phone_number/' => '/contact/',
        '/blog/sapelo-island-ferry-dock-collapse-causing-fatality-and-serious-injuries/' => '/practice-areas/maritime-injury-lawyers/',
        '/blog/south-carolina-car-accident-settlement-amounts/' => '/blog/average-personal-injury-settlement-amounts/',
        '/blog/south-carolina-truck-crash-evidence-eld-dashcam-spoliation/' => '/practice-areas/truck-accident-lawyers/',
        '/blog/what-are-the-benefits-of-workers-compensation-claims/' => '/am-i-eligible-for-workers-compensation/',

        // Root-level deleted posts + a misspelled-path URL still indexed
        '/who-is-at-fault-in-a-charleston-merge-accident/'            => '/car-accident-lawyers/charleston-sc/',
        '/thank-you-ppc-2/'                                          => '/',
        '/practice-ares/savannah/savannah-slip-and-fall-accidents/'  => '/slip-and-fall-lawyers/savannah-ga/',


        // ══════════════════════════════════════════════════════════════
        // CATEGORY 0: Old page URLs → new page URLs
        // ══════════════════════════════════════════════════════════════

        '/who-we-are/'              => '/about/',
        '/who-we-are/attorneys/'    => '/attorneys/',
        '/contact-us/'              => '/contact/', // PM custom URI fixed to 'contact' — this redirect is now safe
        '/practice-areas/service-areas/' => '/locations/',

        // Departed attorneys — profile pages 301 to /about/.
        // Their attorney CPT posts are also moved to draft status so they
        // stop appearing in the attorneys grid.
        '/attorneys/kiley-reidy/'    => '/about/',
        '/attorneys/zach-stohr/'     => '/about/',
        '/attorneys/hillary-burris/' => '/about/',
        '/attorneys/haley-yokeley/'  => '/about/',
        '/attorneys/marina-baldwin/' => '/about/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 1: Old pillar pages with different slugs (6 pages)
        // ══════════════════════════════════════════════════════════════

        '/practice-areas/maritime-lawyers/'              => '/practice-areas/maritime-injury-lawyers/',
        '/practice-areas/medical-malpractice-attorneys/'  => '/practice-areas/medical-malpractice-lawyers/',
        '/practice-areas/nursing-home-abuse-attorneys/'   => '/practice-areas/nursing-home-abuse-lawyers/',
        '/practice-areas/slip-and-fall-attorneys/'        => '/practice-areas/slip-and-fall-lawyers/',
        // PI pillar redirect removed 2026-05-05 (F-NEW-1c shipped): the post
        // /practice-areas/personal-injury-lawyers/ now exists and renders the
        // pillar template directly. The earlier F-NEW-1b interim 301 → home is
        // gone. If the post is ever deleted, restore this entry to avoid the
        // URL falling through to a real 404.
        '/practice-areas/coronavirus-business-claims/'    => false, // 410 Gone — deprecated content

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 2: Savannah old intersection pages (18 pages)
        // Old: /practice-areas/savannah/[slug]/
        // New: /practice-areas/[slug]/savannah-ga/
        // ══════════════════════════════════════════════════════════════

        '/practice-areas/savannah/car-accident-lawyers/'          => '/car-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/truck-accident-lawyers/'        => '/truck-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/slip-and-fall-attorneys/'       => '/slip-and-fall-lawyers/savannah-ga/',
        '/practice-areas/savannah/motorcycle-accident-lawyers/'   => '/motorcycle-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/' => '/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/wrongful-death-lawyers/'        => '/wrongful-death-lawyers/savannah-ga/',
        '/practice-areas/savannah/workers-compensation-lawyers/'  => '/workers-compensation-lawyers/savannah-ga/',
        '/practice-areas/savannah/dog-bite-lawyers/'              => '/dog-bite-lawyers/savannah-ga/',
        '/practice-areas/savannah/brain-injury-lawyers/'          => '/brain-injury-lawyers/savannah-ga/',
        '/practice-areas/savannah/spinal-cord-injury-lawyers/'    => '/spinal-cord-injury-lawyers/savannah-ga/',
        '/practice-areas/savannah/maritime-lawyers/'              => '/maritime-injury-lawyers/savannah-ga/',
        '/practice-areas/savannah/product-liability-lawyers/'     => '/product-liability-lawyers/savannah-ga/',
        '/practice-areas/savannah/boating-accident-lawyers/'      => '/boating-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/burn-injury-lawyers/'           => '/burn-injury-lawyers/savannah-ga/',
        '/practice-areas/savannah/construction-accident-lawyers/' => '/construction-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/nursing-home-abuse-attorneys/'  => '/nursing-home-abuse-lawyers/savannah-ga/',
        '/practice-areas/savannah/personal-injury-lawyers/'       => '/personal-injury-lawyers/savannah-ga/', // Updated ROD-63: PI pages now live
        '/practice-areas/savannah/coronavirus-business-claims/'   => '/car-accident-lawyers/savannah-ga/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 3: Charleston old intersection pages (16 pages)
        // Old: /practice-areas/charleston/[slug]/
        // New: /practice-areas/[slug]/charleston-sc/
        // ══════════════════════════════════════════════════════════════

        '/practice-areas/charleston/car-accident-lawyers/'          => '/car-accident-lawyers/charleston-sc/',
        '/practice-areas/charleston/truck-accident-lawyers/'        => '/truck-accident-lawyers/charleston-sc/',
        '/practice-areas/charleston/slip-and-fall-lawyer/'          => '/slip-and-fall-lawyers/charleston-sc/',
        '/practice-areas/charleston/motorcycle-accident-lawyers/'   => '/motorcycle-accident-lawyers/charleston-sc/',
        '/practice-areas/charleston/medical-malpractice-attorney/'  => '/medical-malpractice-lawyers/charleston-sc/',
        '/practice-areas/charleston/wrongful-death-lawyers/'        => '/wrongful-death-lawyers/charleston-sc/',
        '/practice-areas/charleston/workers-compensation-lawyer/'   => '/workers-compensation-lawyers/charleston-sc/',
        '/practice-areas/charleston/dog-bite-lawyers/'              => '/dog-bite-lawyers/charleston-sc/',
        '/practice-areas/charleston/brain-injury-lawyers/'          => '/brain-injury-lawyers/charleston-sc/',
        '/practice-areas/charleston/spinal-cord-injury-lawyers/'    => '/spinal-cord-injury-lawyers/charleston-sc/',
        '/practice-areas/charleston/product-liability-lawyers/'     => '/product-liability-lawyers/charleston-sc/',
        '/practice-areas/charleston/boating-accident-lawyers/'      => '/boating-accident-lawyers/charleston-sc/',
        '/practice-areas/charleston/burn-injury-lawyers/'           => '/burn-injury-lawyers/charleston-sc/',
        '/practice-areas/charleston/construction-accident-lawyers/' => '/construction-accident-lawyers/charleston-sc/',
        '/practice-areas/charleston/nursing-home-abuse-attorneys/'  => '/nursing-home-abuse-lawyers/charleston-sc/',
        '/practice-areas/charleston/personal-injury-lawyer/'        => '/personal-injury-lawyers/charleston-sc/', // Updated ROD-63: PI pages now live

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 4a: Albany pages — no office (16 pages)
        // Redirect to pillar pages
        // ══════════════════════════════════════════════════════════════

        '/practice-areas/albany/boating-accident-lawyers/'      => '/practice-areas/boating-accident-lawyers/',
        '/practice-areas/albany/brain-injury-lawyers/'          => '/practice-areas/brain-injury-lawyers/',
        '/practice-areas/albany/burn-injury-lawyer/'            => '/practice-areas/burn-injury-lawyers/',
        '/practice-areas/albany/car-accident-lawyers/'          => '/practice-areas/car-accident-lawyers/',
        '/practice-areas/albany/construction-accident-lawyers/' => '/practice-areas/construction-accident-lawyers/',
        '/practice-areas/albany/dog-bite-lawyers/'              => '/practice-areas/dog-bite-lawyers/',
        '/practice-areas/albany/medical-malpractice-attorney/'  => '/practice-areas/medical-malpractice-lawyers/',
        '/practice-areas/albany/motorcycle-accident-lawyers/'   => '/practice-areas/motorcycle-accident-lawyers/',
        '/practice-areas/albany/nursing-home-abuse-lawyers/'    => '/practice-areas/nursing-home-abuse-lawyers/',
        '/practice-areas/albany/personal-injury-lawyers/'       => '/practice-areas/',
        '/practice-areas/albany/product-liability-lawyers/'     => '/practice-areas/product-liability-lawyers/',
        '/practice-areas/albany/slip-and-fall-lawyers/'         => '/practice-areas/slip-and-fall-lawyers/',
        '/practice-areas/albany/spinal-cord-injury-lawyers/'    => '/practice-areas/spinal-cord-injury-lawyers/',
        '/practice-areas/albany/truck-accident-lawyers/'        => '/practice-areas/truck-accident-lawyers/',
        '/practice-areas/albany/workers-compensation-lawyer/'   => '/practice-areas/workers-compensation-lawyers/',
        '/practice-areas/albany/wrongful-death-lawyers/'        => '/practice-areas/wrongful-death-lawyers/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 4b: Brunswick pages — former office, now Darien
        // Redirect /practice-areas/brunswick/* → Darien intersection pages
        // Redirect /brunswick/* → Darien intersection pages
        // ══════════════════════════════════════════════════════════════

        '/practice-areas/brunswick/boating-accident-lawyers/'      => '/boating-accident-lawyers/darien-ga/',
        '/practice-areas/brunswick/brain-injury-lawyers/'          => '/brain-injury-lawyers/darien-ga/',
        '/practice-areas/brunswick/burn-injury-lawyers/'           => '/burn-injury-lawyers/darien-ga/',
        '/practice-areas/brunswick/car-accident-lawyer/'           => '/car-accident-lawyers/darien-ga/',
        '/practice-areas/brunswick/construction-accident-lawyers/' => '/construction-accident-lawyers/darien-ga/',
        '/practice-areas/brunswick/dog-bite-lawyers/'              => '/dog-bite-lawyers/darien-ga/',
        '/practice-areas/brunswick/medical-malpractice-attorney/'  => '/medical-malpractice-lawyers/darien-ga/',
        '/practice-areas/brunswick/motorcycle-accident-lawyers/'   => '/motorcycle-accident-lawyers/darien-ga/',
        '/practice-areas/brunswick/nursing-home-abuse-lawyer/'     => '/nursing-home-abuse-lawyers/darien-ga/',
        '/practice-areas/brunswick/personal-injury-lawyer/'        => '/personal-injury-lawyers/darien-ga/',
        '/practice-areas/brunswick/product-liability-lawyers/'     => '/product-liability-lawyers/darien-ga/',
        '/practice-areas/brunswick/slip-and-fall-lawyer/'          => '/slip-and-fall-lawyers/darien-ga/',
        '/practice-areas/brunswick/spinal-cord-injury-lawyers/'    => '/spinal-cord-injury-lawyers/darien-ga/',
        '/practice-areas/brunswick/truck-accident-lawyers/'        => '/truck-accident-lawyers/darien-ga/',
        '/practice-areas/brunswick/workers-compensation-attorney/' => '/workers-compensation-lawyers/darien-ga/',
        '/practice-areas/brunswick/wrongful-death-lawyers/'        => '/wrongful-death-lawyers/darien-ga/',

        // /brunswick/[slug]/ format — singular/variant slugs not covered above
        '/brunswick/medical-malpractice-attorney/'   => '/medical-malpractice-lawyers/darien-ga/',
        '/brunswick/workers-compensation-attorney/'  => '/workers-compensation-lawyers/darien-ga/',
        '/brunswick/nursing-home-abuse-lawyer/'      => '/nursing-home-abuse-lawyers/darien-ga/',
        '/brunswick/slip-and-fall-lawyer/'           => '/slip-and-fall-lawyers/darien-ga/',

        // /brunswick/[slug]/ format (no /practice-areas/ prefix)
        '/brunswick/boating-accident-lawyers/'      => '/boating-accident-lawyers/darien-ga/',
        '/brunswick/brain-injury-lawyers/'          => '/brain-injury-lawyers/darien-ga/',
        '/brunswick/burn-injury-lawyers/'           => '/burn-injury-lawyers/darien-ga/',
        '/brunswick/car-accident-lawyers/'          => '/car-accident-lawyers/darien-ga/',
        '/brunswick/construction-accident-lawyers/' => '/construction-accident-lawyers/darien-ga/',
        '/brunswick/dog-bite-lawyers/'              => '/dog-bite-lawyers/darien-ga/',
        '/brunswick/medical-malpractice-lawyers/'   => '/medical-malpractice-lawyers/darien-ga/',
        '/brunswick/motorcycle-accident-lawyers/'   => '/motorcycle-accident-lawyers/darien-ga/',
        '/brunswick/nursing-home-abuse-lawyers/'    => '/nursing-home-abuse-lawyers/darien-ga/',
        '/brunswick/personal-injury-lawyers/'       => '/personal-injury-lawyers/darien-ga/',
        '/brunswick/personal-injury-lawyer/'        => '/personal-injury-lawyers/darien-ga/',
        '/brunswick/product-liability-lawyers/'     => '/product-liability-lawyers/darien-ga/',
        '/brunswick/slip-and-fall-lawyers/'         => '/slip-and-fall-lawyers/darien-ga/',
        '/brunswick/spinal-cord-injury-lawyers/'    => '/spinal-cord-injury-lawyers/darien-ga/',
        '/brunswick/truck-accident-lawyers/'        => '/truck-accident-lawyers/darien-ga/',
        '/brunswick/workers-compensation-lawyers/'  => '/workers-compensation-lawyers/darien-ga/',
        '/brunswick/wrongful-death-lawyers/'        => '/wrongful-death-lawyers/darien-ga/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 4c: Macon pages — no office (17 pages)
        // Redirect to pillar pages
        // ══════════════════════════════════════════════════════════════

        '/practice-areas/macon/boating-accident-lawyers/'      => '/practice-areas/boating-accident-lawyers/',
        '/practice-areas/macon/brain-injury-lawyers/'          => '/practice-areas/brain-injury-lawyers/',
        '/practice-areas/macon/burn-injury-lawyers/'           => '/practice-areas/burn-injury-lawyers/',
        '/practice-areas/macon/car-accident-lawyers/'          => '/practice-areas/car-accident-lawyers/',
        '/practice-areas/macon/construction-accident-lawyers/' => '/practice-areas/construction-accident-lawyers/',
        '/practice-areas/macon/dog-bite-lawyers/'              => '/practice-areas/dog-bite-lawyers/',
        '/practice-areas/macon/maritime-lawyers/'              => '/practice-areas/maritime-injury-lawyers/',
        '/practice-areas/macon/medical-malpractice-attorneys/' => '/practice-areas/medical-malpractice-lawyers/',
        '/practice-areas/macon/motorcycle-accident-lawyers/'   => '/practice-areas/motorcycle-accident-lawyers/',
        '/practice-areas/macon/nursing-home-abuse-attorneys/'  => '/practice-areas/nursing-home-abuse-lawyers/',
        '/practice-areas/macon/personal-injury-lawyers/'       => '/practice-areas/',
        '/practice-areas/macon/product-liability-lawyers/'     => '/practice-areas/product-liability-lawyers/',
        '/practice-areas/macon/slip-and-fall-attorneys/'       => '/practice-areas/slip-and-fall-lawyers/',
        '/practice-areas/macon/spinal-cord-injury-lawyers/'    => '/practice-areas/spinal-cord-injury-lawyers/',
        '/practice-areas/macon/truck-accident-lawyers/'        => '/practice-areas/truck-accident-lawyers/',
        '/practice-areas/macon/workers-compensation-lawyers/'  => '/practice-areas/workers-compensation-lawyers/',
        '/practice-areas/macon/wrongful-death-lawyers/'        => '/practice-areas/wrongful-death-lawyers/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 5: Savannah sub-type pages (23 pages)
        // Unique content — redirect to closest new intersection page
        // ══════════════════════════════════════════════════════════════

        '/practice-areas/savannah/car-accident-lawyers/bike-accidents/'        => '/car-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/car-accident-lawyers/bus-accidents/'         => '/car-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/car-accident-lawyers/georgia-pip-insurance/' => '/car-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/car-accident-lawyers/hit-and-run-accidents/' => '/car-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/car-accident-lawyers/pedestrian-accidents/'  => '/pedestrian-accident-lawyers/savannah-ga/',

        '/practice-areas/savannah/medical-malpractice-attorneys/cosmetic-surgery/'       => '/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/dental-negligence/'      => '/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/faq/'                    => '/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/hospital-negligence/'    => '/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/medication-errors/'      => '/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/misdiagnosis/'           => '/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/ob-gyn-negligence/'      => '/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/orthopedic-injury/'      => '/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/psychiatric-negligence/' => '/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/surgical-errors/'        => '/medical-malpractice-lawyers/savannah-ga/',

        '/practice-areas/savannah/nursing-home-abuse-attorneys/bedsores/'                    => '/nursing-home-abuse-lawyers/savannah-ga/',
        '/practice-areas/savannah/nursing-home-abuse-attorneys/faqs/'                        => '/nursing-home-abuse-lawyers/savannah-ga/',
        '/practice-areas/savannah/nursing-home-abuse-attorneys/malnutrition-and-dehydration/' => '/nursing-home-abuse-lawyers/savannah-ga/',
        '/practice-areas/savannah/nursing-home-abuse-attorneys/resident-bill-of-rights/'     => '/nursing-home-abuse-lawyers/savannah-ga/',

        '/practice-areas/savannah/product-liability-lawyers/faq/'                         => '/product-liability-lawyers/savannah-ga/',
        '/practice-areas/savannah/slip-and-fall-attorneys/premises-liability/'             => '/premises-liability-lawyers/savannah-ga/',
        '/practice-areas/savannah/wrongful-death-lawyers/georgia-punitive-damages-lawyer/' => '/wrongful-death-lawyers/savannah-ga/',
        '/practice-areas/savannah/wrongful-death-lawyers/statute-of-limitations/'         => '/wrongful-death-lawyers/savannah-ga/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 6: Orphaned & test pages (3 pages)
        // ══════════════════════════════════════════════════════════════

        '/truck-accident-lawyer-2/'      => '/practice-areas/truck-accident-lawyers/',
        '/columbia-car-accident-lawyers/' => '/car-accident-lawyers/columbia-sc/',
        '/practice-area/3536/'           => '/practice-areas/',

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

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 8: Old staff / attorney URLs (26+ pages)
        // Old CPT used /staff/[name]/ and /who-we-are/attorneys/[name]/
        // ══════════════════════════════════════════════════════════════

        '/who-we-are/attorneys/allison-marani/'      => '/attorneys/',
        '/who-we-are/attorneys/j-michael-parsons/'  => '/attorneys/',
        '/who-we-are/attorneys/joseph-padgett/'     => '/attorneys/',
        '/who-we-are/attorneys/troy-a-williams/'    => '/attorneys/',
        '/who-we-are/attorneys/caroline-shaw/'       => '/attorneys/',
        '/who-we-are/attorneys/jeff-fitzpatrick-jr/' => '/attorneys/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 9: Old city practice area index pages
        // ══════════════════════════════════════════════════════════════

        '/savannah/practice-areas/'   => '/practice-areas/',
        '/charleston/practice-areas/' => '/practice-areas/',
        '/brunswick/practice-areas/'  => '/practice-areas/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 10: Misc old pages
        // ══════════════════════════════════════════════════════════════

        '/areas-we-serve/'     => '/locations/',
        '/es/'                 => '/',
        // '/class-action-lawyers/' redirect removed — page template exists and should render (page-class-action-lawyers.php)

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

        // Service pages moved from blog to pages
        '/blog/savannah-ppi-attorney/'                                         => '/savannah-ppi-attorney/',
        '/blog/blog-savannah-ppi-attorney/'                                    => '/savannah-ppi-attorney/',
        '/blog/free-consultation-with-charleston-personal-injury-lawyer/'       => '/free-consultation-with-charleston-personal-injury-lawyer/',
        '/blog/blog-free-consultation-with-charleston-personal-injury-lawyer/'  => '/free-consultation-with-charleston-personal-injury-lawyer/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 12: Blog audit — Duplicate content redirects (2026-03-25)
        // Thin posts consolidated into stronger rewritten articles
        // ══════════════════════════════════════════════════════════════

        // "Can a car accident lawyer help with insurance" → "Are accident lawyers worth it"
        '/can-a-car-accident-lawyer-help-with-claiming-insurance-benefits/' => '/are-accident-lawyers-worth-it/',

        // "Car accident claims: why you need an attorney" → "Are accident lawyers worth it"
        '/how-can-an-attorney-help-with-my-car-accident-claim/' => '/are-accident-lawyers-worth-it/',

        // "Should I pursue a PI claim after car accident" → "Do I have a PI case"
        '/i-was-in-a-car-accident-should-i-pursue-a-personal-injury-claim/' => '/how-do-i-know-if-i-have-a-personal-injury-case/',

        // "Upsides of filing a PI lawsuit" → "Do I have a PI case"
        '/what-are-the-upsides-of-filing-a-personal-injury-lawsuit/' => '/how-do-i-know-if-i-have-a-personal-injury-case/',

        // "Benefits of WC claims" → "Am I eligible for WC"
        '/what-are-the-benefits-of-workers-compensation-claims/' => '/am-i-eligible-for-workers-compensation/',

        // "Why is WC so important" → "Am I eligible for WC"
        '/why-is-workers-compensation-so-important-to-have/' => '/am-i-eligible-for-workers-compensation/',

        // "Why consult a PI lawyer" → "Are accident lawyers worth it"
        '/why-should-i-consult-a-personal-injury-lawyer-for-my-accident/' => '/are-accident-lawyers-worth-it/',

        // "Why hire an accident lawyer" → "Are accident lawyers worth it"
        '/why-should-i-hire-an-accident-lawyer-after-an-accident/' => '/are-accident-lawyers-worth-it/',

        // "Why is having a PI lawyer important" → "Are accident lawyers worth it"
        '/why-is-having-a-personal-injury-lawyer-important/' => '/are-accident-lawyers-worth-it/',

        // "When should you hire an attorney" → "Are accident lawyers worth it"
        '/when-should-you-hire-an-attorney-after-being-in-an-accident/' => '/are-accident-lawyers-worth-it/',

        // "Benefits of hiring a WC lawyer" → "Are accident lawyers worth it"
        '/what-are-the-benefits-of-hiring-a-workers-compensation-lawyer/' => '/are-accident-lawyers-worth-it/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 13: Sitemap audit — 2026-03-30
        // URLs found in sitemap returning 404
        // ══════════════════════════════════════════════════════════════

        // Old paginated practice area archive
        '/practice-areas/general/page/24/' => '/practice-areas/',

        // Old privacy policy slug
        '/terms-privacy-policy/' => '/privacy-policy/',

        // Old results page → case results
        '/results/' => '/case-results/',

        // Old pillar slug variants
        '/practice-areas/medical-malpractice-attorneys/' => '/practice-areas/medical-malpractice-lawyers/',

        // Root-level blog posts that may have been renamed (catch-all won't find them)
        '/car-crash-crush-injuries-in-charleston/'                                        => '/blog/car-crash-crush-injuries-in-charleston/',
        '/should-i-worry-if-i-have-stomach-pain-after-a-car-accident-in-charleston/'      => '/blog/stomach-pain-after-a-car-accident-in-charleston/',
        '/a-charleston-residents-guide-to-tourist-car-accidents/'                          => '/blog/a-charleston-residents-guide-to-tourist-car-accidents/',

        // Ivy Montano — slug mismatch (old: ivy-montano, current: ivy-s-montano)
        '/who-we-are/attorneys/ivy-montano/' => '/attorneys/ivy-s-montano/',

    );
}
