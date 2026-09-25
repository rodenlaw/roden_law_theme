<?php
/**
 * Retire the 75 stale place pages: 29 sub-municipal location pages and 46 posts
 * from the local-SEO pipeline's street-and-neighbourhood output. Evidence:
 * docs/cull-evidence-2026-09-25.md. Owner-approved 2026-09-25 (Brunswick kept).
 *
 * Paths and targets come from roden_stale_place_urls() in
 * inc/legacy-redirects.php, so the redirect map and the removal set cannot
 * drift. The ID => [type, path] pairing is declared here, because get_post( $id )
 * is the only way to be certain which row is about to change.
 *
 * Pages are set to DRAFT, not trashed. WordPress purges the trash after 30 days
 * (EMPTY_TRASH_DAYS); drafts are kept, stay out of the sitemap and are not
 * public. Written straight to post_status, not through wp_update_post(), so the
 * wp_insert_post_data guardrails cannot rewrite content and post_modified is
 * not stamped. To bring one back: remove its redirect-map line, check the
 * doorway ratio, publish.
 *
 * ORDER MATTERS. The 301s must be LIVE before this runs, or these URLs 404 in
 * the gap.
 *
 *   Dry run (default) — reports inbound links; nothing is changed:
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-stale-place-pages.php \
 *       > docs/backups/stale-place-pages-$(date +%Y-%m-%d).json
 *
 *   Apply — refuses while any published post outside the batch still links here:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-stale-place-pages.php \
 *       > docs/backups/stale-place-pages-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ID => [post_type, public path]. Source: prod pre-flight, 2026-09-25. */
$expect = array(
    3762 => array( 'location', '/locations/south-carolina/charleston/mount-pleasant/' ),
    3764 => array( 'location', '/locations/south-carolina/north-charleston/summerville/' ),
    3766 => array( 'location', '/locations/south-carolina/north-charleston/goose-creek/' ),
    3767 => array( 'location', '/locations/south-carolina/charleston/james-island/' ),
    3773 => array( 'location', '/locations/south-carolina/charleston/isle-of-palms/' ),
    3788 => array( 'location', '/locations/georgia/savannah/pooler/' ),
    3792 => array( 'location', '/locations/georgia/savannah/port-wentworth/' ),
    3797 => array( 'location', '/locations/georgia/savannah/hinesville/' ),
    3798 => array( 'location', '/locations/georgia/savannah/statesboro/' ),
    3811 => array( 'location', '/locations/georgia/savannah/bryan-county/' ),
    3814 => array( 'location', '/locations/south-carolina/myrtle-beach/conway/' ),
    3817 => array( 'location', '/locations/south-carolina/myrtle-beach/surfside-beach/' ),
    3823 => array( 'location', '/locations/south-carolina/myrtle-beach/georgetown/' ),
    3832 => array( 'location', '/locations/south-carolina/myrtle-beach/andrews/' ),
    3840 => array( 'location', '/locations/south-carolina/columbia/west-columbia/' ),
    3841 => array( 'location', '/locations/south-carolina/columbia/cayce/' ),
    3846 => array( 'location', '/locations/south-carolina/columbia/forest-acres/' ),
    3850 => array( 'location', '/locations/south-carolina/columbia/chapin/' ),
    3856 => array( 'location', '/locations/south-carolina/columbia/batesburg-leesville/' ),
    3857 => array( 'location', '/locations/south-carolina/columbia/elgin/' ),
    3865 => array( 'location', '/locations/georgia/darien/kingsland/' ),
    3867 => array( 'location', '/locations/georgia/darien/waycross/' ),
    3868 => array( 'location', '/locations/georgia/darien/jesup/' ),
    3869 => array( 'location', '/locations/georgia/darien/folkston/' ),
    3872 => array( 'location', '/locations/georgia/darien/woodbine/' ),
    3873 => array( 'location', '/locations/georgia/darien/nahunta/' ),
    3875 => array( 'location', '/locations/georgia/darien/blackshear/' ),
    3876 => array( 'location', '/locations/georgia/darien/alma/' ),
    3877 => array( 'location', '/locations/georgia/darien/hoboken/' ),
    4702 => array( 'post', '/blog/eastern-wharf-savannah-pedestrian-bike-accidents/' ),
    4704 => array( 'post', '/blog/rideshare-accident-i-26-tenmile-north-charleston/' ),
    4707 => array( 'post', '/blog/i-526-mount-pleasant-wando-bridge-accident/' ),
    4709 => array( 'post', '/blog/us-17-truck-accident-broadfield-glynn-county/' ),
    4711 => array( 'post', '/blog/sunset-boulevard-us-378-lexington-medical-center-accident/' ),
    4713 => array( 'post', '/blog/dog-bite-surfside-beach-29575/' ),
    4715 => array( 'post', '/blog/i-16-port-freight-truck-accident-garden-city-savannah/' ),
    4717 => array( 'post', '/blog/pedestrian-accident-dorchester-road-school-zone-29418-north-charleston/' ),
    4719 => array( 'post', '/blog/atlantic-coastal-highway-us-17-rideshare-uber-lyft-crash-savannah-intermodal-transit-center/' ),
    4721 => array( 'post', '/blog/motorcycle-accident-i-95-glynn-county-brunswick-darien/' ),
    4723 => array( 'post', '/blog/credit-one-stadium-event-day-crashes-daniel-island-beekman-street/' ),
    4725 => array( 'post', '/blog/hit-and-run-drunk-driver-crashes-ashley-river-road-sc-61-west-ashley-greenwood-park/' ),
    4727 => array( 'post', '/blog/i-77-truck-accident-northeast-columbia-richland-county/' ),
    4729 => array( 'post', '/blog/drunk-driver-crash-south-kings-highway-us-17-business-surfside-beach-29575/' ),
    4731 => array( 'post', '/blog/columbia-airport-expressway-us-378-truck-accident-springdale-lexington-county/' ),
    4733 => array( 'post', '/blog/north-rhett-avenue-truck-accident-hanahan-berkeley-county/' ),
    4735 => array( 'post', '/blog/rifle-range-road-mount-pleasant-car-accident-heritage-park-west/' ),
    4738 => array( 'post', '/blog/litchfield-beach-pawleys-island-us-17-car-accident-georgetown-county/' ),
    4742 => array( 'post', '/blog/us-17-i-95-darien-wrongful-death-mcintosh-county/' ),
    4744 => array( 'post', '/blog/garden-city-eden-loop-truck-accident-lawyer/' ),
    4748 => array( 'post', '/blog/daniel-island-i-526-wando-bridge-truck-accident-berkeley-county/' ),
    4750 => array( 'post', '/blog/international-boulevard-airport-rideshare-uber-lyft-crash-north-charleston/' ),
    4754 => array( 'post', '/blog/surfside-beach-golf-colony-golf-cart-accident-lawyer/' ),
    4756 => array( 'post', '/blog/yamacraw-village-pedestrian-accident-lawyer/' ),
    4758 => array( 'post', '/blog/mcintosh-county-drunk-driver-accident-lawyer/' ),
    4760 => array( 'post', '/blog/mount-pleasant-johnnie-dodds-us-17-wrongful-death-car-accident-lawyer/' ),
    4766 => array( 'post', '/blog/south-kings-highway-us-17-business-underinsured-motorist-lawyer/' ),
    4768 => array( 'post', '/blog/savannah-veterans-parkway-car-accident-lawyer/' ),
    4770 => array( 'post', '/blog/darien-river-boating-accident-lawyer/' ),
    4774 => array( 'post', '/blog/hanahan-murray-avenue-highland-park-bicycle-accident-lawyer/' ),
    4796 => array( 'post', '/blog/eulonia-us-17-ocean-highway-rideshare-uber-accident-lawyer-mcintosh-county/' ),
    4798 => array( 'post', '/blog/mount-pleasant-mark-clark-expressway-i-526-motorcycle-accident-lawyer/' ),
    4802 => array( 'post', '/blog/st-andrews-road-widewater-18-wheeler-accident-lawyer-richland-county/' ),
    4804 => array( 'post', '/blog/litchfield-pawleys-island-golf-cart-accident-lawyer-georgetown-county/' ),
    4948 => array( 'post', '/es/blog/eulonia-us-17-ocean-highway-rideshare-uber-accident-lawyer-mcintosh-county/' ),
    4958 => array( 'post', '/blog/garden-city-ga-21-augusta-road-car-accident-lawyer/' ),
    4978 => array( 'post', '/blog/mount-pleasant-johnnie-dodds-us-17-uninsured-motorist-lawyer/' ),
    5025 => array( 'post', '/blog/cayce-12th-street-uninsured-motorist-lawyer/' ),
    5037 => array( 'post', '/blog/eastern-wharf-harbor-street-electric-scooter-accident-lawyer/' ),
    5039 => array( 'post', '/es/blog/eastern-wharf-harbor-street-electric-scooter-accident-lawyer/' ),
    5045 => array( 'post', '/blog/boys-estate-glynn-county-best-car-accident-lawyer/' ),
    5047 => array( 'post', '/es/blog/boys-estate-glynn-county-best-car-accident-lawyer/' ),
    5049 => array( 'post', '/blog/n-lake-drive-us-17-business-best-car-accident-lawyer/' ),
    5119 => array( 'post', '/es/blog/n-lake-drive-us-17-business-best-car-accident-lawyer/' ),
    5160 => array( 'post', '/blog/old-fort-jackson-savannah-fatal-truck-accident-lawyer/' ),
    5228 => array( 'post', '/es/blog/old-fort-jackson-savannah-fatal-truck-accident-lawyer/' ),
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — 29 sub-municipal locations + 46 pipeline posts\n\n", $apply ? 'APPLY' : 'DRY RUN' );

if ( ! function_exists( 'roden_stale_place_urls' ) ) {
    fprintf( $err, "ABORT: roden_stale_place_urls() is not defined — the redirect map has not deployed yet.\n" );
    fprintf( $err, "       Merge and deploy the theme change first, or these URLs 404 in the gap.\n" );
    exit( 1 );
}
$map = roden_stale_place_urls();

/* The map and this script must describe exactly the same set. */
$paths       = array_map( function ( $e ) { return $e[1]; }, $expect );
$only_map    = array_diff( array_keys( $map ), $paths );
$only_script = array_diff( $paths, array_keys( $map ) );
if ( $only_map || $only_script ) {
    fprintf( $err, "ABORT: the redirect map and this script disagree.\n" );
    foreach ( $only_map as $p )    { fprintf( $err, "  in map, not here:    %s\n", $p ); }
    foreach ( $only_script as $p ) { fprintf( $err, "  here, not in map:    %s\n", $p ); }
    exit( 1 );
}

global $wpdb;
$found     = array();
$link_debt = array();
$retiring  = array_keys( $map );

foreach ( $expect as $id => $e ) {
    list( $type, $path ) = $e;
    $p = get_post( $id );

    if ( ! $p instanceof WP_Post ) {
        fprintf( $err, "ABORT: ID %d not found.\n", $id );
        exit( 1 );
    }
    if ( $type !== $p->post_type ) {
        fprintf( $err, "ABORT: ID %d is post_type '%s', expected '%s'.\n", $id, $p->post_type, $type );
        exit( 1 );
    }
    if ( 'publish' !== $p->post_status ) {
        fprintf( $err, "ABORT: ID %d is '%s', not published — already actioned?\n", $id, $p->post_status );
        exit( 1 );
    }
    $actual = trailingslashit( (string) wp_parse_url( get_permalink( $p ), PHP_URL_PATH ) );
    if ( $actual !== trailingslashit( $path ) ) {
        fprintf( $err, "ABORT: ID %d is at %s, expected %s.\n", $id, $actual, $path );
        exit( 1 );
    }
    if ( in_array( $actual, array_values( $map ), true ) ) {
        fprintf( $err, "ABORT: %s is a redirect TARGET — that is a pillar.\n", $actual );
        exit( 1 );
    }

    /* Hierarchical guard: a practice_area with a published child would orphan it into a 404. */
    if ( is_post_type_hierarchical( $p->post_type ) ) {
        $kids = get_posts( array( 'post_type' => $p->post_type, 'post_parent' => $p->ID, 'post_status' => 'publish', 'fields' => 'ids', 'numberposts' => -1 ) );
        if ( $kids ) {
            fprintf( $err, "ABORT: %s still has %d published child page(s): %s\n", $actual, count( $kids ), implode( ', ', $kids ) );
            exit( 1 );
        }
    }

    /*
     * Inbound editorial links from published posts OUTSIDE this batch. Links from
     * pages the batch is itself retiring die with them. Reported on a dry run,
     * fatal on apply.
     */
    $like = '%' . $wpdb->esc_like( $actual ) . '%';
    $ids  = $wpdb->get_col( $wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_type NOT IN ('revision') AND ID <> %d AND post_content LIKE %s",
        $id, $like
    ) );
    $ext = 0;
    foreach ( $ids as $lid ) {
        $lp = trailingslashit( (string) wp_parse_url( get_permalink( $lid ), PHP_URL_PATH ) );
        if ( in_array( $lp, $retiring, true ) ) {
            continue;
        }
        /*
         * The LIKE is a substring match, and an English path is a suffix of its
         * Spanish twin's: '/workers-compensation-lawyers/columbia-sc/' sits inside
         * '/es/workers-compensation-lawyers/columbia-sc/'. Only count a real href,
         * i.e. the path preceded by a quote or by the site's own host — the same
         * forms the relink script rewrites, so the two cannot disagree.
         */
        $c = (string) get_post_field( 'post_content', $lid );
        if ( false !== strpos( $c, '"' . $actual ) || false !== strpos( $c, "'" . $actual ) || false !== strpos( $c, untrailingslashit( home_url() ) . $actual ) ) {
            $ext++;
        }
    }
    if ( $ext > 0 ) {
        $link_debt[ $actual ] = $ext;
    }
    $found[] = $p;
}

if ( $link_debt ) {
    fprintf( $err, "\n%d of %d URLs still have inbound links in published post bodies outside this batch:\n", count( $link_debt ), count( $expect ) );
    foreach ( $link_debt as $path => $n ) {
        fprintf( $err, "    %2d post(s) -> %s\n", $n, $path );
    }
    fprintf( $err, "\n  Run bin/relink-stale-place-pages.php first.\n\n" );
    if ( $apply ) {
        fprintf( $err, "ABORT: refusing to retire pages that are still linked.\n" );
        exit( 1 );
    }
} else {
    fprintf( $err, "  No inbound editorial links outside the batch. Nothing to relink.\n\n" );
}

/* ---- Backup before touching anything ---- */

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'stale-place-pages',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Set to draft, not trashed. Restore: remove the path from roden_stale_place_urls(), check the doorway ratio, publish.',
    'evidence'  => 'docs/cull-evidence-2026-09-25.md — 29 locations: 81 clicks / 16 months, 9 in the last 28 days; 46 posts: 340 / 16 months, 5 in the last 28 days',
    'link_debt' => $link_debt,
    'posts'     => array(),
);
foreach ( $found as $p ) {
    $backup['posts'][] = array(
        'ID'            => (int) $p->ID,
        'post_title'    => $p->post_title,
        'post_name'     => $p->post_name,
        'post_type'     => $p->post_type,
        'post_status'   => $p->post_status,
        'post_parent'   => (int) $p->post_parent,
        'post_date_gmt' => $p->post_date_gmt,
        'permalink'     => get_permalink( $p ),
        'redirects_to'  => $map[ trailingslashit( (string) wp_parse_url( get_permalink( $p ), PHP_URL_PATH ) ) ],
        'post_content'  => $p->post_content,
        'post_excerpt'  => $p->post_excerpt,
        'meta'          => get_post_meta( $p->ID ),
    );
}
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

/* ---- Act ---- */

$done = 0;
foreach ( $found as $p ) {
    $path = (string) wp_parse_url( get_permalink( $p ), PHP_URL_PATH );
    if ( ! $apply ) {
        fprintf( $err, "  would draft  %-5d %-14s %s\n", $p->ID, $p->post_type, $path );
        continue;
    }
    $ok = $wpdb->update( $wpdb->posts, array( 'post_status' => 'draft' ), array( 'ID' => $p->ID ), array( '%s' ), array( '%d' ) );
    clean_post_cache( $p->ID );
    if ( false !== $ok && 'draft' === get_post_status( $p->ID ) ) {
        $done++;
        fprintf( $err, "  drafted      %-5d %-14s %s\n", $p->ID, $p->post_type, $path );
    } else {
        fprintf( $err, "  FAILED       %-5d %s\n", $p->ID, $path );
    }
}

fprintf( $err, "\n%s: %d of %d\n", $apply ? 'Drafted' : 'Would draft', $apply ? $done : count( $found ), count( $found ) );
if ( $apply ) {
    fprintf( $err, "Backup captured on STDOUT.\n" );
    fprintf( $err, "Next: flush both caches, verify 75/75 single-hop, regenerate content/meta.json.\n" );
}
