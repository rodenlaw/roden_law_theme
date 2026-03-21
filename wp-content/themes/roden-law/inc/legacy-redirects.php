<?php
/**
 * Roden Law — Legacy Content Redirects
 *
 * 301 redirects for old practice-area CPT pages → new practice_area CPT pages.
 * Generated March 2026 from dev site audit.
 *
 * TOTAL: 122 redirects across 7 categories
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ------------------------------------------------------------------
   Neutralize old practice-area (hyphen) CPT registered by ACF.
   Keeps posts accessible in wp-admin but removes front-end URLs,
   archives, and sitemap entries.
   ------------------------------------------------------------------ */

add_filter( 'register_post_type_args', 'roden_neutralize_old_practice_area_cpt', 10, 2 );

function roden_neutralize_old_practice_area_cpt( $args, $post_type ) {
    if ( 'practice-area' !== $post_type ) {
        return $args;
    }

    $args['public']              = false;
    $args['publicly_queryable']  = false;
    $args['exclude_from_search'] = true;
    $args['has_archive']         = false;
    $args['show_ui']             = true;
    $args['show_in_menu']        = true;
    $args['label']               = 'Old Practice Areas (Legacy)';
    $args['labels']['name']      = 'Old Practice Areas (Legacy)';
    $args['labels']['menu_name'] = 'Old PAs (Legacy)';

    return $args;
}

/* ------------------------------------------------------------------
   301 Redirects — old URLs → new URLs
   ------------------------------------------------------------------ */

add_action( 'template_redirect', 'roden_legacy_content_redirects', 1 );

function roden_legacy_content_redirects() {
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
}

function roden_get_legacy_redirect_map() {
    return array(

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 0: Old page URLs → new page URLs
        // ══════════════════════════════════════════════════════════════

        '/who-we-are/'              => '/about/',
        '/who-we-are/attorneys/'    => '/attorneys/',
        '/contact-us/'              => '/contact/', // PM custom URI fixed to 'contact' — this redirect is now safe
        '/practice-areas/service-areas/' => '/locations/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 1: Old pillar pages with different slugs (6 pages)
        // ══════════════════════════════════════════════════════════════

        '/practice-areas/maritime-lawyers/'              => '/practice-areas/maritime-injury-lawyers/',
        '/practice-areas/medical-malpractice-attorneys/'  => '/practice-areas/medical-malpractice-lawyers/',
        '/practice-areas/nursing-home-abuse-attorneys/'   => '/practice-areas/nursing-home-abuse-lawyers/',
        '/practice-areas/slip-and-fall-attorneys/'        => '/practice-areas/slip-and-fall-lawyers/',
        // '/practice-areas/personal-injury-lawyers/' — LIVE pillar page now exists; redirect removed (ROD-63)
        '/practice-areas/coronavirus-business-claims/'    => false, // 410 Gone — deprecated content

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 2: Savannah old intersection pages (18 pages)
        // Old: /practice-areas/savannah/[slug]/
        // New: /practice-areas/[slug]/savannah-ga/
        // ══════════════════════════════════════════════════════════════

        '/practice-areas/savannah/car-accident-lawyers/'          => '/practice-areas/car-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/truck-accident-lawyers/'        => '/practice-areas/truck-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/slip-and-fall-attorneys/'       => '/practice-areas/slip-and-fall-lawyers/savannah-ga/',
        '/practice-areas/savannah/motorcycle-accident-lawyers/'   => '/practice-areas/motorcycle-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/' => '/practice-areas/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/wrongful-death-lawyers/'        => '/practice-areas/wrongful-death-lawyers/savannah-ga/',
        '/practice-areas/savannah/workers-compensation-lawyers/'  => '/practice-areas/workers-compensation-lawyers/savannah-ga/',
        '/practice-areas/savannah/dog-bite-lawyers/'              => '/practice-areas/dog-bite-lawyers/savannah-ga/',
        '/practice-areas/savannah/brain-injury-lawyers/'          => '/practice-areas/brain-injury-lawyers/savannah-ga/',
        '/practice-areas/savannah/spinal-cord-injury-lawyers/'    => '/practice-areas/spinal-cord-injury-lawyers/savannah-ga/',
        '/practice-areas/savannah/maritime-lawyers/'              => '/practice-areas/maritime-injury-lawyers/savannah-ga/',
        '/practice-areas/savannah/product-liability-lawyers/'     => '/practice-areas/product-liability-lawyers/savannah-ga/',
        '/practice-areas/savannah/boating-accident-lawyers/'      => '/practice-areas/boating-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/burn-injury-lawyers/'           => '/practice-areas/burn-injury-lawyers/savannah-ga/',
        '/practice-areas/savannah/construction-accident-lawyers/' => '/practice-areas/construction-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/nursing-home-abuse-attorneys/'  => '/practice-areas/nursing-home-abuse-lawyers/savannah-ga/',
        '/practice-areas/savannah/personal-injury-lawyers/'       => '/practice-areas/car-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/coronavirus-business-claims/'   => '/practice-areas/car-accident-lawyers/savannah-ga/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 3: Charleston old intersection pages (16 pages)
        // Old: /practice-areas/charleston/[slug]/
        // New: /practice-areas/[slug]/charleston-sc/
        // ══════════════════════════════════════════════════════════════

        '/practice-areas/charleston/car-accident-lawyers/'          => '/practice-areas/car-accident-lawyers/charleston-sc/',
        '/practice-areas/charleston/truck-accident-lawyers/'        => '/practice-areas/truck-accident-lawyers/charleston-sc/',
        '/practice-areas/charleston/slip-and-fall-lawyer/'          => '/practice-areas/slip-and-fall-lawyers/charleston-sc/',
        '/practice-areas/charleston/motorcycle-accident-lawyers/'   => '/practice-areas/motorcycle-accident-lawyers/charleston-sc/',
        '/practice-areas/charleston/medical-malpractice-attorney/'  => '/practice-areas/medical-malpractice-lawyers/charleston-sc/',
        '/practice-areas/charleston/wrongful-death-lawyers/'        => '/practice-areas/wrongful-death-lawyers/charleston-sc/',
        '/practice-areas/charleston/workers-compensation-lawyer/'   => '/practice-areas/workers-compensation-lawyers/charleston-sc/',
        '/practice-areas/charleston/dog-bite-lawyers/'              => '/practice-areas/dog-bite-lawyers/charleston-sc/',
        '/practice-areas/charleston/brain-injury-lawyers/'          => '/practice-areas/brain-injury-lawyers/charleston-sc/',
        '/practice-areas/charleston/spinal-cord-injury-lawyers/'    => '/practice-areas/spinal-cord-injury-lawyers/charleston-sc/',
        '/practice-areas/charleston/product-liability-lawyers/'     => '/practice-areas/product-liability-lawyers/charleston-sc/',
        '/practice-areas/charleston/boating-accident-lawyers/'      => '/practice-areas/boating-accident-lawyers/charleston-sc/',
        '/practice-areas/charleston/burn-injury-lawyers/'           => '/practice-areas/burn-injury-lawyers/charleston-sc/',
        '/practice-areas/charleston/construction-accident-lawyers/' => '/practice-areas/construction-accident-lawyers/charleston-sc/',
        '/practice-areas/charleston/nursing-home-abuse-attorneys/'  => '/practice-areas/nursing-home-abuse-lawyers/charleston-sc/',
        '/practice-areas/charleston/personal-injury-lawyer/'        => '/practice-areas/car-accident-lawyers/charleston-sc/',

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

        '/practice-areas/savannah/car-accident-lawyers/bike-accidents/'        => '/practice-areas/car-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/car-accident-lawyers/bus-accidents/'         => '/practice-areas/car-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/car-accident-lawyers/georgia-pip-insurance/' => '/practice-areas/car-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/car-accident-lawyers/hit-and-run-accidents/' => '/practice-areas/car-accident-lawyers/savannah-ga/',
        '/practice-areas/savannah/car-accident-lawyers/pedestrian-accidents/'  => '/practice-areas/pedestrian-accident-lawyers/savannah-ga/',

        '/practice-areas/savannah/medical-malpractice-attorneys/cosmetic-surgery/'       => '/practice-areas/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/dental-negligence/'      => '/practice-areas/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/faq/'                    => '/practice-areas/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/hospital-negligence/'    => '/practice-areas/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/medication-errors/'      => '/practice-areas/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/misdiagnosis/'           => '/practice-areas/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/ob-gyn-negligence/'      => '/practice-areas/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/orthopedic-injury/'      => '/practice-areas/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/psychiatric-negligence/' => '/practice-areas/medical-malpractice-lawyers/savannah-ga/',
        '/practice-areas/savannah/medical-malpractice-attorneys/surgical-errors/'        => '/practice-areas/medical-malpractice-lawyers/savannah-ga/',

        '/practice-areas/savannah/nursing-home-abuse-attorneys/bedsores/'                    => '/practice-areas/nursing-home-abuse-lawyers/savannah-ga/',
        '/practice-areas/savannah/nursing-home-abuse-attorneys/faqs/'                        => '/practice-areas/nursing-home-abuse-lawyers/savannah-ga/',
        '/practice-areas/savannah/nursing-home-abuse-attorneys/malnutrition-and-dehydration/' => '/practice-areas/nursing-home-abuse-lawyers/savannah-ga/',
        '/practice-areas/savannah/nursing-home-abuse-attorneys/resident-bill-of-rights/'     => '/practice-areas/nursing-home-abuse-lawyers/savannah-ga/',

        '/practice-areas/savannah/product-liability-lawyers/faq/'                         => '/practice-areas/product-liability-lawyers/savannah-ga/',
        '/practice-areas/savannah/slip-and-fall-attorneys/premises-liability/'             => '/practice-areas/premises-liability-lawyers/savannah-ga/',
        '/practice-areas/savannah/wrongful-death-lawyers/georgia-punitive-damages-lawyer/' => '/practice-areas/wrongful-death-lawyers/savannah-ga/',
        '/practice-areas/savannah/wrongful-death-lawyers/statute-of-limitations/'         => '/practice-areas/wrongful-death-lawyers/savannah-ga/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 6: Orphaned & test pages (3 pages)
        // ══════════════════════════════════════════════════════════════

        '/truck-accident-lawyer-2/'      => '/practice-areas/truck-accident-lawyers/',
        '/columbia-car-accident-lawyers/' => '/practice-areas/car-accident-lawyers/columbia-sc/',
        '/practice-area/3536/'           => '/practice-areas/',

        // ══════════════════════════════════════════════════════════════
        // CATEGORY 7: Root-level blog posts (7 pages)
        // SKIPPED — permalink structure is /%postname%/ so these posts
        // already live at root. Redirects would break working URLs.
        // Re-enable after changing permalink structure to /blog/%postname%/.
        // ══════════════════════════════════════════════════════════════

    );
}
