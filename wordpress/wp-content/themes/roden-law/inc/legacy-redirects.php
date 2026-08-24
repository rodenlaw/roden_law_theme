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
   301: legacy Yoast sitemap URLs → core sitemap index.

   /sitemap_index.xml and /{type}-sitemap{N}.xml predate the move to WP
   core sitemaps. They fall through to the blog template and serve a
   200 text/html page — a soft-200 that parses as a broken sitemap for
   anything (GSC included) still holding the old references.
   ------------------------------------------------------------------ */

add_action( 'template_redirect', 'roden_legacy_sitemap_redirects', 1 );

function roden_legacy_sitemap_redirects() {
    $path = wp_parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH ) ?: '/';

    // Never touch core sitemap URLs (/wp-sitemap*.xml renders on this same
    // hook at priority 10 — matching them here would break live sitemaps).
    if ( 0 === strpos( $path, '/wp-sitemap' ) ) {
        return;
    }

    // WPE's front proxy rewrites the Yoast URL shapes before PHP sees them
    // (verified via header probe 2026-07-08): /sitemap_index.xml arrives as
    // /index.php?sitemap=1, /{type}-sitemap{N}.xml as /index.php?sitemap=…
    // — the original path is unrecoverable, but the injected query var is
    // the fingerprint. Core sitemap requests never carry ?sitemap= in the
    // real client query string (their rewrite is WP-internal), so this only
    // matches proxied legacy URLs (or direct ?sitemap= probes, same intent).
    if ( '/index.php' === $path && isset( $_GET['sitemap'] ) ) {
        wp_safe_redirect( home_url( '/wp-sitemap.xml/' ), 301 );
        exit;
    }

    // Path-shape fallback for environments without the proxy rewrite
    // (dev installs, future WPE config changes).
    if ( preg_match( '#^/(sitemap_index\.xml|[a-z0-9_-]+-sitemap[0-9]*\.xml)$#', $path ) ) {
        wp_safe_redirect( home_url( '/wp-sitemap.xml/' ), 301 );
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

    // /es/* redirect REMOVED 2026-07-06: the Spanish site is live (bespoke
    // locale layer in inc/i18n.php). The old blanket /es/* → / 301 dated from
    // the 2026-05-05 Polylang removal and was killing every Spanish page.

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

    // /es/[anything] redirect REMOVED 2026-07-06 — Spanish site is live.

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
        // CATEGORY 17: duplicate warehouse sub-types — 2026-07-31
        // "Warehouse & Logistics Injury" (4630, SC-scoped, published
        // 2026-04-20) and "Warehouse and Distribution Injury" (4109, both
        // states, 2026-03-10) both rendered on all four SC location pages —
        // straight keyword cannibalization between two near-identical pages.
        //
        // 4109 survives: older, covers GA and SC, 5 FAQs vs 3, and the only
        // one with inbound internal links (4630 had zero). 4630's genuinely
        // distinct material — temporary/staffing-agency worker rights and
        // heat illness — was merged into 4109 first, so the redirect does
        // not drop content.
        // ══════════════════════════════════════════════════════════════

        '/workers-compensation-lawyers/warehouse-logistics-injury/' => '/workers-compensation-lawyers/warehouse-distribution-injury/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 17b: duplicate Savannah neighborhoods — 2026-07-31
        // Ardsley Park and Georgetown each existed twice: once flat under
        // /savannah/ and once nested under its district. The district-nested
        // version wins both times — Savannah's other direct children are
        // CITIES (Pooler, Rincon, Guyton, Statesboro), so a neighborhood
        // sitting at that level is structurally wrong, and the nested pages
        // also carry ~50% more content. Neither had inbound internal links,
        // so nothing is lost by choosing on structure.
        //
        // Note this is the opposite choice from CATEGORY 15's Guyton and
        // Springfield, and deliberately so: those two ARE Effingham County
        // towns, so flat-under-the-office-city was correct for them.
        // The rule is cities flat, neighborhoods under their district.
        // ══════════════════════════════════════════════════════════════

        '/locations/georgia/savannah/ardsley-park/' => '/locations/georgia/savannah/midtown-savannah/ardsley-park-chatham-crescent/',
        '/locations/georgia/savannah/georgetown/'   => '/locations/georgia/savannah/southside-savannah/georgetown-savannah/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 16: dead flat LPs — 2026-07-08 SEO/GEO audit item G2
        // Former flat landing-page URLs (present as routes in the Next.js
        // mirror, so they were live pages) returning hard 404s with no
        // redirect. Zero Semrush backlinks/keywords — hygiene 301s to the
        // closest silo equivalents.
        // ══════════════════════════════════════════════════════════════

        '/truck-accident-lawyers-columbia-sc/'      => '/truck-accident-lawyers/columbia-sc/',
        '/truck-accident-lawyers-near-me/'          => '/practice-areas/truck-accident-lawyers/',
        '/south-carolina-rear-end-accident-lawyer/' => '/car-accident-lawyers/rear-end-collision/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 15: duplicate location pages — 2026-07-08 audit item #5
        // Same town published under two parents (keyword cannibalization),
        // plus city-under-itself pages duplicating their office parent.
        // Losing posts were set to draft directly; the one-shot script that did
        // it was removed with the rest of the dead seeders (see git history).
        // ══════════════════════════════════════════════════════════════

        '/locations/georgia/savannah/effingham-county/guyton/'              => '/locations/georgia/savannah/guyton/',
        '/locations/georgia/savannah/effingham-county/springfield/'         => '/locations/georgia/savannah/springfield/',
        '/locations/south-carolina/charleston/mount-pleasant/sullivans-island/' => '/locations/south-carolina/charleston/sullivans-island/',
        '/locations/south-carolina/columbia/columbia/'                      => '/locations/south-carolina/columbia/',
        '/locations/south-carolina/myrtle-beach/myrtle-beach/'              => '/locations/south-carolina/myrtle-beach/',
        '/locations/georgia/darien/darien/'                                 => '/locations/georgia/darien/',

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
        // '/es/' => '/' removed 2026-07-06 — the Spanish homepage is live.
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

/* ------------------------------------------------------------------
   301: campaign-tag URLs -> clean canonical path.

   Phase 0 item 4. The six Google Business Profiles link to their location
   pages with a campaign tag appended. Those variants return 200 and already
   emit a correct canonical to the clean path, and Google indexes and ranks
   them anyway, because a canonical is a hint and six strong external links
   outvote it. /locations/south-carolina/myrtle-beach/?utm_campaign=gmb_mb
   carries ~3% of sitewide traffic in place of the clean URL. A 301 is a
   directive, so it settles what the canonical could not.

   WHY `ref` AND NOT `utm_*`. WP Engine strips utm_* and gclid from the
   request before it reaches PHP, then reattaches them to the URL returned to
   the visitor (wpengine.com/support/utm-gclid-variables-caching/). A handler
   keyed on utm_* cannot fire on this host. Verified live on 2026-08-21:
   WordPress's own redirect_canonical preserved ?cb=23957 while
   ?utm_campaign=TESTVALUE vanished from the otherwise identical request.

   So the profiles must tag with ?ref=gmb_<market>, which WP Engine passes
   through untouched. Do not "fix" this by adding utm_* back to the list
   below — it will look right and do nothing.

   The already-indexed ?utm_campaign= variants cannot be redirected from PHP
   for the same reason. They decay once the profiles stop linking them and
   the canonical reasserts. The alternative, a WP Engine cache exclusion for
   utm_*, was rejected: it makes every tagged request bypass page cache,
   which is the highest-intent traffic on the site.

   ATTRIBUTION. The intake webhook reads campaign data off the Gravity Forms
   entry's source_url, which derives from the Referer. This redirect fires
   before the browser ever renders the tagged URL, so a later form submit
   would carry the clean path and lose the tag. The value is parked in a
   cookie first and the webhook falls back to it, mapping ref -> utm_campaign
   so downstream CRM reporting keys on the field it always has.

   gclid is not handled here. WP Engine strips it too, and the theme already
   captures it client-side via sessionStorage in functions.php, which is the
   pattern WP Engine recommends for stripped parameters.
   ------------------------------------------------------------------ */

if ( ! defined( 'RODEN_REF_COOKIE' ) ) {
    define( 'RODEN_REF_COOKIE', 'roden_ref' );
}

/**
 * Campaign-tag parameters stripped from indexable URLs.
 *
 * Must contain only parameters WP Engine passes through to PHP. utm_* and
 * gclid do not qualify — see the note above.
 *
 * @return string[]
 */
function roden_tracking_params() {
    return array( 'ref' );
}

add_action( 'template_redirect', 'roden_canonicalize_tracking_params', 1 );

function roden_canonicalize_tracking_params() {
    // Never interfere with admin, AJAX, REST, cron, previews or feeds.
    if ( is_admin() || wp_doing_ajax() || is_preview() || is_feed() ) {
        return;
    }
    if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
        return;
    }
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
        return;
    }

    // Only ever redirect idempotent reads. A POST carries form data.
    $method = isset( $_SERVER['REQUEST_METHOD'] ) ? strtoupper( (string) $_SERVER['REQUEST_METHOD'] ) : 'GET';
    if ( 'GET' !== $method && 'HEAD' !== $method ) {
        return;
    }

    if ( empty( $_GET ) || ! is_array( $_GET ) ) {
        return;
    }

    $tracking = roden_tracking_params();
    $present  = array_intersect( $tracking, array_keys( $_GET ) );
    if ( empty( $present ) ) {
        return;
    }

    // Park the value before dropping it, so lead attribution survives.
    roden_stash_ref_cookie( $_GET, $tracking );

    // Keep every non-campaign parameter (pagination, search, form state...).
    $keep = array();
    foreach ( $_GET as $k => $v ) {
        if ( ! in_array( $k, $tracking, true ) ) {
            $keep[ $k ] = $v;
        }
    }

    $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) $_SERVER['REQUEST_URI'] : '/';
    $path        = (string) wp_parse_url( $request_uri, PHP_URL_PATH );
    if ( '' === $path ) {
        $path = '/';
    }

    $dest = home_url( $path );

    if ( ! empty( $keep ) ) {
        // add_query_arg() encodes values itself - pre-encoding double-escapes.
        $dest = add_query_arg( wp_unslash( $keep ), $dest );
    }

    wp_redirect( $dest, 301 );
    exit;
}

/**
 * Store the inbound campaign tag in a short-lived cookie.
 *
 * Read back by the intake webhook once the 301 above has cleaned the URL.
 *
 * @param array    $params   Raw request parameters.
 * @param string[] $tracking Campaign keys to persist.
 */
function roden_stash_ref_cookie( $params, $tracking ) {
    if ( headers_sent() ) {
        return;
    }

    $tags = array();
    foreach ( $tracking as $k ) {
        if ( ! empty( $params[ $k ] ) && is_string( $params[ $k ] ) ) {
            $tags[ $k ] = sanitize_text_field( wp_unslash( $params[ $k ] ) );
        }
    }
    if ( empty( $tags ) ) {
        return;
    }

    setcookie(
        RODEN_REF_COOKIE,
        wp_json_encode( $tags ),
        array(
            'expires'  => time() + ( 30 * DAY_IN_SECONDS ),
            'path'     => COOKIEPATH ? COOKIEPATH : '/',
            'domain'   => COOKIE_DOMAIN,
            'secure'   => is_ssl(),
            'httponly' => false, // readable by the form JS if it ever needs it
            'samesite' => 'Lax',
        )
    );
}

/* ------------------------------------------------------------------
   301: Phase 1 removals — URLs culled by the SEO pre-emption plan.

   Path-keyed rather than post-ID-keyed on purpose: these fire whether or
   not the underlying post still exists, so the redirect can ship BEFORE
   the CMS entry is deleted. That ordering is the point — deploy first and
   the page stops being indexable immediately; delete the post afterwards
   so it cannot regenerate. Reversing it would open a 404 window, which
   the plan forbids.

   Registered at priority 0, ahead of the tracking-parameter handler, so a
   removed URL carrying utm_* still resolves in a SINGLE hop rather than
   chaining removal→clean→destination.

   Batch (b), shipped 2026-08-21: the eight non-office city pages published
   2026-08-20. No office in any of these markets, ~270-320 unique words
   each against a median of 843 for the office-city pages, and zero inbound
   internal links anywhere in post content, post meta or the nav menus —
   orphans from the day they were created. The
   service-area data behind them stays in $firm['service_areas']; it feeds
   the city x practice pages, which are a separate decision.
   ------------------------------------------------------------------ */

/**
 * Removed path => 301 destination. Append future batches here.
 *
 * @return array<string,string>
 */
function roden_phase1_removed_urls() {
    return array(
        // Batch (b) — non-office city pages failing plan rule 4.
        '/locations/south-carolina/fort-mill/'    => '/locations/south-carolina/',
        '/locations/south-carolina/greer/'        => '/locations/south-carolina/',
        '/locations/south-carolina/hilton-head/'  => '/locations/south-carolina/',
        '/locations/south-carolina/orangeburg/'   => '/locations/south-carolina/',
        '/locations/south-carolina/rock-hill/'    => '/locations/south-carolina/',
        '/locations/south-carolina/simpsonville/' => '/locations/south-carolina/',
        '/locations/south-carolina/spartanburg/'  => '/locations/south-carolina/',
        '/locations/south-carolina/sumter/'       => '/locations/south-carolina/',

        // Batch (a) — neighbourhood and subdivision pages below city level,
        // plan rule 3. Targets are the tier-2 city hub, not the immediate
        // parent: the tier-3 municipalities above some of these are still
        // EVALUATE, and pointing at one would risk a chain if it later goes.
        '/locations/georgia/savannah/downtown-savannah/'                                        => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/downtown-savannah/historic-district/'                      => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/downtown-savannah/river-street/'                           => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/eastside-savannah/'                                        => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/effingham-county/egypt/'                                   => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/effingham-county/marlow/'                                  => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/effingham-county/south-effingham/'                         => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/hinesville/fort-stewart-area/'                             => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/midtown-savannah/'                                         => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/midtown-savannah/ardsley-park-chatham-crescent/'           => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/pooler/godley-station/'                                    => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/pooler/west-pooler/'                                       => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/port-wentworth/town-center/'                               => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/richmond-hill/city-center/'                                => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/rincon/town-center/'                                       => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/southside-savannah/'                                       => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/southside-savannah/georgetown-savannah/'                   => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/southside-savannah/savannah-quarters/'                     => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/statesboro/georgia-southern/'                              => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/westside-savannah/'                                        => '/locations/georgia/savannah/',
        '/locations/georgia/savannah/wilmington-island/town-center/'                            => '/locations/georgia/savannah/',
        '/locations/south-carolina/charleston/daniel-island/'                                   => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/downtown-charleston/'                             => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/downtown-charleston/ansonborough/'                => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/downtown-charleston/cannonborough-elliotborough/' => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/downtown-charleston/french-quarter/'              => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/downtown-charleston/harleston-village/'           => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/downtown-charleston/king-street-district/'        => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/downtown-charleston/south-of-broad/'              => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/downtown-charleston/the-crosstown/'               => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/downtown-charleston/wagener-terrace/'             => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/mount-pleasant/belle-hall/'                       => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/mount-pleasant/carolina-park/'                    => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/mount-pleasant/dunes-west/'                       => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/mount-pleasant/ion/'                              => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/mount-pleasant/old-village/'                      => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/mount-pleasant/park-west/'                        => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/mount-pleasant/rivertowne/'                       => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/mount-pleasant/shem-creek/'                       => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/mount-pleasant/snee-farm/'                        => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/west-ashley/'                                     => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/west-ashley/ashley-river-road/'                   => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/west-ashley/avondale/'                            => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/west-ashley/byrnes-downs/'                        => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/west-ashley/citadel-mall-area/'                   => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/west-ashley/grand-oaks-plantation/'               => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/west-ashley/shadowmoss/'                          => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/west-ashley/south-windermere/'                    => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/charleston/west-ashley/west-ashley-park/'                    => '/locations/south-carolina/charleston/',
        '/locations/south-carolina/columbia/northeast-columbia/'                                => '/locations/south-carolina/columbia/',
        '/locations/south-carolina/myrtle-beach/carolina-forest/the-farm/'                      => '/locations/south-carolina/myrtle-beach/',
        '/locations/south-carolina/myrtle-beach/conway/historic-district/'                      => '/locations/south-carolina/myrtle-beach/',
        '/locations/south-carolina/myrtle-beach/garden-city-beach/pier-area/'                   => '/locations/south-carolina/myrtle-beach/',
        '/locations/south-carolina/myrtle-beach/georgetown/historic-district/'                  => '/locations/south-carolina/myrtle-beach/',
        '/locations/south-carolina/myrtle-beach/little-river/waterfront/'                       => '/locations/south-carolina/myrtle-beach/',
        '/locations/south-carolina/myrtle-beach/murrells-inlet/marshwalk/'                      => '/locations/south-carolina/myrtle-beach/',
        '/locations/south-carolina/myrtle-beach/myrtle-beach/golden-mile/'                      => '/locations/south-carolina/myrtle-beach/',
        '/locations/south-carolina/myrtle-beach/myrtle-beach/grande-dunes/'                     => '/locations/south-carolina/myrtle-beach/',
        '/locations/south-carolina/myrtle-beach/myrtle-beach/market-common/'                    => '/locations/south-carolina/myrtle-beach/',
        '/locations/south-carolina/myrtle-beach/north-myrtle-beach/barefoot-landing/'           => '/locations/south-carolina/myrtle-beach/',
        '/locations/south-carolina/myrtle-beach/socastee/socastee-village/'                     => '/locations/south-carolina/myrtle-beach/',
        '/locations/south-carolina/myrtle-beach/surfside-beach/town-center/'                    => '/locations/south-carolina/myrtle-beach/',
        '/locations/south-carolina/north-charleston/charleston-heights/'                        => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/chicora-cherokee/'                          => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/dorchester-terrace-waylyn/'                 => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/ferndale/'                                  => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/goose-creek/boulder-bluff/'                 => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/goose-creek/brickhope-plantation/'          => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/goose-creek/carnes-crossroads/'             => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/goose-creek/crowfield-plantation/'          => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/goose-creek/devon-forest/'                  => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/goose-creek/howe-hall/'                     => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/goose-creek/liberty-hall-plantation/'       => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/goose-creek/westchester/'                   => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/liberty-hill/'                              => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/northwoods/'                                => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/oak-terrace-preserve/'                      => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/olde-north-charleston/'                     => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/park-circle/'                               => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/summerville/cane-bay/'                      => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/summerville/historic-district/'             => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/summerville/knightsville/'                  => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/summerville/nexton/'                        => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/summerville/pine-forest-inn/'               => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/summerville/sangaree/'                      => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/summerville/summers-corner/'                => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/summerville/wescott/'                       => '/locations/south-carolina/north-charleston/',
        '/locations/south-carolina/north-charleston/wescott-plantation/'                        => '/locations/south-carolina/north-charleston/',

        // Batch (d) — city x practice in markets with no office, plan rule 7.
        '/car-accident-lawyers/blythewood-sc/'          => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/conway-sc/'              => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/fort-mill-sc/'           => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/goose-creek-sc/'         => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/greer-sc/'               => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/irmo-sc/'                => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/moncks-corner-sc/'       => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/mount-pleasant-sc/'      => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/north-myrtle-beach-sc/'  => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/orangeburg-sc/'          => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/rock-hill-sc/'           => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/simpsonville-sc/'        => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/spartanburg-sc/'         => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/summerville-sc/'         => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/sumter-sc/'              => '/practice-areas/car-accident-lawyers/',
        '/motorcycle-accident-lawyers/spartanburg-sc/'  => '/practice-areas/motorcycle-accident-lawyers/',
        '/motorcycle-accident-lawyers/summerville-sc/'  => '/practice-areas/motorcycle-accident-lawyers/',
        '/personal-injury-lawyers/conway-sc/'           => '/practice-areas/personal-injury-lawyers/',
        '/personal-injury-lawyers/goose-creek-sc/'      => '/practice-areas/personal-injury-lawyers/',
        '/personal-injury-lawyers/hilton-head-sc/'      => '/practice-areas/personal-injury-lawyers/',
        '/personal-injury-lawyers/mount-pleasant-sc/'   => '/practice-areas/personal-injury-lawyers/',
        '/personal-injury-lawyers/orangeburg-sc/'       => '/practice-areas/personal-injury-lawyers/',
        '/personal-injury-lawyers/pawleys-island-sc/'   => '/practice-areas/personal-injury-lawyers/',
        '/personal-injury-lawyers/summerville-sc/'      => '/practice-areas/personal-injury-lawyers/',
        '/slip-and-fall-lawyers/goose-creek-sc/'        => '/practice-areas/slip-and-fall-lawyers/',
        '/truck-accident-lawyers/conway-sc/'            => '/practice-areas/truck-accident-lawyers/',
        '/truck-accident-lawyers/moncks-corner-sc/'     => '/practice-areas/truck-accident-lawyers/',
        '/truck-accident-lawyers/rock-hill-sc/'         => '/practice-areas/truck-accident-lawyers/',
        '/truck-accident-lawyers/spartanburg-sc/'       => '/practice-areas/truck-accident-lawyers/',
        '/truck-accident-lawyers/summerville-sc/'       => '/practice-areas/truck-accident-lawyers/',
        '/workers-compensation-lawyers/goose-creek-sc/' => '/practice-areas/workers-compensation-lawyers/',
        '/workers-compensation-lawyers/rock-hill-sc/'   => '/practice-areas/workers-compensation-lawyers/',
        '/workers-compensation-lawyers/spartanburg-sc/' => '/practice-areas/workers-compensation-lawyers/',
        '/workers-compensation-lawyers/summerville-sc/' => '/practice-areas/workers-compensation-lawyers/',

        // Batch (c) — practice micro-permutations, plan rule 5: single-road and
        // single-employer pages that exist to catch a query, not to answer one.
        // Targets are the parent pillar for now. Several of these carry real
        // substance (gulfstream 2,003 words, savannah-port 1,489, i-26 1,072)
        // and the Steinberg plan reuses that material in the I-26/I-95 Corridor
        // Report and the Port Worker Injury Report. When those studies publish,
        // repoint the target here — this map is a flat path lookup consulted
        // once at template_redirect, so changing a destination stays single-hop
        // and needs no second migration.
        '/car-accident-lawyers/ashley-phosphate-road-accident/'    => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/dorchester-road-accident/'          => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/i-26-accident/'                     => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/i-526-accident/'                    => '/practice-areas/car-accident-lawyers/',
        '/car-accident-lawyers/rivers-avenue-accident/'            => '/practice-areas/car-accident-lawyers/',
        '/motorcycle-accident-lawyers/dorchester-road-motorcycle/' => '/practice-areas/motorcycle-accident-lawyers/',
        '/pedestrian-accident-lawyers/rivers-avenue-pedestrian/'   => '/practice-areas/pedestrian-accident-lawyers/',
        '/truck-accident-lawyers/i-26-truck-accident/'             => '/practice-areas/truck-accident-lawyers/',
        '/workers-compensation-lawyers/boeing-aerospace-injury/'     => '/practice-areas/workers-compensation-lawyers/',
        '/workers-compensation-lawyers/gulfstream-aerospace-injury/' => '/practice-areas/workers-compensation-lawyers/',
        '/workers-compensation-lawyers/savannah-port-worker-injury/' => '/practice-areas/workers-compensation-lawyers/',
    );
}

add_action( 'template_redirect', 'roden_phase1_removal_redirects', 0 );

function roden_phase1_removal_redirects() {
    if ( is_admin() || wp_doing_ajax() || is_preview() || is_feed() ) {
        return;
    }
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
        return;
    }

    $method = isset( $_SERVER['REQUEST_METHOD'] ) ? strtoupper( (string) $_SERVER['REQUEST_METHOD'] ) : 'GET';
    if ( 'GET' !== $method && 'HEAD' !== $method ) {
        return;
    }

    $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) $_SERVER['REQUEST_URI'] : '/';
    $path        = (string) wp_parse_url( $request_uri, PHP_URL_PATH );
    if ( '' === $path ) {
        return;
    }
    $path = trailingslashit( $path );

    $map = roden_phase1_removed_urls();
    if ( ! isset( $map[ $path ] ) ) {
        return;
    }

    wp_redirect( home_url( $map[ $path ] ), 301 );
    exit;
}

/* ------------------------------------------------------------------
   301: legacy case-result CPT → the canonical /case-results/ URL.

   Phase 1 batch (f). 156 case results are published twice: once as the
   `case_result` CPT at /case-results/{slug}/ (sitemap-listed, canonical)
   and once as the legacy hyphen-slug `case-result` CPT at
   /blog/case-result/{slug}/. 129 of them share a slug, both return 200,
   and the legacy URL SELF-canonicalises — so Google sees 129 independent
   duplicate pairs rather than one canonical page each.

   Matched by pattern rather than a hardcoded list of 129 paths, and the
   redirect only fires when a published `case_result` with that slug
   actually exists. That matters: 27 legacy slugs have NO counterpart, and
   those are left serving their own content rather than being swept into
   the archive. Case results are guardrail-protected (plan §2) and those 27
   are unique posts, not leftovers — retiring them is a separate decision,
   not a side effect of de-duplication.

   The legacy CPT is therefore NOT neutralised here. Doing so would remove
   the front-end URL for those 27 as well. Once they are dealt with, add
   'case-result' to roden_neutralize_old_practice_area_cpt() above and this
   handler becomes the sole route.

   `case_result` is non-hierarchical, so a slug lookup is reliable against
   it — unlike `location` and `practice_area`.
   ------------------------------------------------------------------ */

add_action( 'template_redirect', 'roden_legacy_case_result_redirect', 0 );

function roden_legacy_case_result_redirect() {
    if ( is_admin() || wp_doing_ajax() || is_preview() || is_feed() ) {
        return;
    }
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
        return;
    }

    $method = isset( $_SERVER['REQUEST_METHOD'] ) ? strtoupper( (string) $_SERVER['REQUEST_METHOD'] ) : 'GET';
    if ( 'GET' !== $method && 'HEAD' !== $method ) {
        return;
    }

    $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) $_SERVER['REQUEST_URI'] : '/';
    $path        = (string) wp_parse_url( $request_uri, PHP_URL_PATH );

    if ( ! preg_match( '#^/blog/case-result/([^/]+)/?$#', $path, $m ) ) {
        return;
    }

    $slug = sanitize_title( $m[1] );
    if ( '' === $slug ) {
        return;
    }

    $twin = get_posts( array(
        'post_type'        => 'case_result',
        'post_status'      => 'publish',
        'name'             => $slug,
        'posts_per_page'   => 1,
        'fields'           => 'ids',
        'no_found_rows'    => true,
        'suppress_filters' => false,
    ) );

    // No canonical twin: leave the legacy page serving its own content.
    if ( empty( $twin ) ) {
        return;
    }

    $dest = get_permalink( $twin[0] );
    if ( ! $dest ) {
        return;
    }

    wp_redirect( $dest, 301 );
    exit;
}
