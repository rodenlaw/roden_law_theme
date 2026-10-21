<?php
/**
 * Retire the 41 floor-cull pages: 6 merged onto a kept page on the same road,
 * 35 retired (30 low earners + 5 middle-tier). Evidence:
 * docs/floor-cull-2026-10-21.md. Owner-approved 2026-10-21
 * ("go with 1").
 *
 * Paths and targets come from roden_floor_cull_urls() and
 * roden_floor_cull_mid_urls() in inc/legacy-redirects.php, so the redirect map
 * and the removal set cannot drift. The ID => [type, path] pairing is declared
 * here, because get_post( $id ) is the only way to be certain which row is
 * about to change.
 *
 * Pages are set to DRAFT, not trashed. WordPress purges the trash after 30 days
 * (EMPTY_TRASH_DAYS); drafts are kept, stay out of the sitemap and are not
 * public. Written straight to post_status, not through wp_update_post(), so the
 * wp_insert_post_data guardrails cannot rewrite content and post_modified is
 * not stamped. To bring one back: remove its redirect-map line, check the
 * doorway ratio, publish.
 *
 * Post 5001's Spanish twin (5004) is already a draft with its own redirect
 * (roden_zero_click_blog_urls()); drafting 5001 does not rename it.
 *
 * ORDER MATTERS. The 301s must be LIVE before this runs, or these URLs 404 in
 * the gap.
 *
 *   Dry run (default) — reports inbound links; nothing is changed:
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-floor-cull.php \
 *       > docs/backups/floor-cull-$(date +%Y-%m-%d).json
 *
 *   Apply — refuses while any published post outside the batch still links here:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-floor-cull.php \
 *       > docs/backups/floor-cull-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ID => [post_type, public path]. Source: prod pre-flight, 2026-10-21. */
$expect = array(
    3487 => array( 'post', '/blog/what-to-do-after-a-bike-crash-on-charlestons-ravenel-bridge/' ),
    3451 => array( 'post', '/blog/a-step-by-step-guide-for-folly-road-car-accidents/' ),
    4664 => array( 'resource', '/resources/ashley-phosphate-i-26-truck-accidents/' ),
    4649 => array( 'resource', '/resources/i-16-truck-accidents-savannah/' ),
    4648 => array( 'resource', '/resources/i-95-truck-accidents-savannah-brunswick/' ),
    4670 => array( 'resource', '/resources/abercorn-street-truck-accidents-savannah/' ),
    4690 => array( 'resource', '/resources/georgetown-county-us-17-truck-accidents/' ),
    4654 => array( 'resource', '/resources/i-20-truck-accidents-columbia/' ),
    4680 => array( 'resource', '/resources/bush-river-road-i-26-truck-accidents-columbia/' ),
    4672 => array( 'resource', '/resources/dean-forest-road-truck-accidents-pooler/' ),
    3456 => array( 'post', '/blog/a-guide-to-car-wrecks-on-aviation-avenue-near-charleston-airport/' ),
    4679 => array( 'resource', '/resources/two-notch-road-truck-accidents-columbia/' ),
    4674 => array( 'resource', '/resources/dorchester-road-truck-accidents-north-charleston/' ),
    3444 => array( 'post', '/blog/what-to-do-after-a-car-crash-on-savannah-highway/' ),
    4339 => array( 'post', '/blog/rivers-avenue-pedestrian-deaths-north-charleston/' ),
    4656 => array( 'resource', '/resources/columbia-i-26-i-20-i-77-interchange-truck-accidents/' ),
    4685 => array( 'resource', '/resources/i-526-construction-zone-truck-accidents-charleston/' ),
    4346 => array( 'post', '/blog/car-accidents-ladson-i-26-exit-203-danger-zone/' ),
    4681 => array( 'resource', '/resources/highway-22-truck-accidents-conway-bypass/' ),
    4682 => array( 'resource', '/resources/us-17-sc-544-truck-accidents-surfside-beach/' ),
    4338 => array( 'post', '/blog/savannah-highway-truck-accidents-west-ashley-us-17/' ),
    4354 => array( 'post', '/blog/i-526-expansion-construction-zone-accidents-charleston/' ),
    4642 => array( 'post', '/blog/pedestrian-safety-park-circle-north-charleston/' ),
    4675 => array( 'resource', '/resources/spruill-avenue-port-trucks-north-charleston/' ),
    4676 => array( 'resource', '/resources/port-access-road-truck-accidents-leatherman-terminal/' ),
    4677 => array( 'resource', '/resources/aviation-avenue-i-26-truck-accidents/' ),
    4347 => array( 'post', '/blog/johns-island-accidents-no-hospital-emergency-room/' ),
    4655 => array( 'resource', '/resources/i-77-truck-accidents-columbia-rock-hill/' ),
    4364 => array( 'post', '/blog/daniel-island-accidents-event-traffic-golf-carts/' ),
    4366 => array( 'post', '/blog/west-ashley-vs-downtown-charleston-driving-risks/' ),
    5001 => array( 'post', '/blog/east-bay-street-savannah-pedestrian-accident-lawyer/' ),
    4650 => array( 'resource', '/resources/i-516-truck-accidents-port-savannah/' ),
    4661 => array( 'resource', '/resources/i-526-truck-accidents-charleston/' ),
    4663 => array( 'resource', '/resources/rivers-avenue-truck-accidents-north-charleston/' ),
    4665 => array( 'resource', '/resources/summerville-truck-accidents-i-26-corridor/' ),
    4684 => array( 'resource', '/resources/jimmy-deloach-connector-truck-accidents-savannah/' ),
    3435 => array( 'post', '/blog/car-accidents-on-i-26-in-north-charleston/' ),
    4370 => array( 'post', '/blog/ben-sawyer-boulevard-bridge-accidents-sullivans-island/' ),
    4353 => array( 'post', '/blog/maybank-highway-car-accidents-johns-island/' ),
    3461 => array( 'post', '/blog/car-accidents-on-coleman-boulevard-in-mount-pleasant/' ),
    3483 => array( 'post', '/blog/filing-an-emotional-distress-claim-after-a-ravenel-bridge-accident/' ),
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — 41 floor-cull pages\n\n", $apply ? 'APPLY' : 'DRY RUN' );

if ( ! function_exists( 'roden_floor_cull_urls' ) ) {
    fprintf( $err, "ABORT: roden_floor_cull_urls() is not defined — the redirect map has not deployed yet.\n" );
    fprintf( $err, "       Merge and deploy the theme change first, or these URLs 404 in the gap.\n" );
    exit( 1 );
}
// The five middle-tier posts live in their own function so the owner can drop
// them; if it is gone, they are simply not part of the run.
$map = array_merge(
    roden_floor_cull_urls(),
    function_exists( 'roden_floor_cull_mid_urls' ) ? roden_floor_cull_mid_urls() : array()
);
$expect = array_filter( $expect, function ( $e ) use ( $map ) { return isset( $map[ $e[1] ] ); } );

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
    fprintf( $err, "\n  Run bin/relink-floor-cull.php first.\n\n" );
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
    'batch'     => 'floor-cull',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Set to draft, not trashed. Restore: remove the path from roden_floor_cull_urls() / roden_floor_cull_mid_urls(), check the doorway ratio, publish.',
    'evidence'  => 'docs/floor-cull-2026-10-21.md — 41 of the 54 floor-check pages; 16-month and 28-day GSC per URL',
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
    // Keeps the retired draft out of content/meta.json (bin/export-content-meta.php).
    update_post_meta( $p->ID, '_roden_retired', '2026-10-21 floor-cull' );
    clean_post_cache( $p->ID );
    // Read back from the table, not get_post_status(): on WP Engine the persistent
    // object cache can still hand back 'publish' straight after the write, which
    // reported four successful drafts as FAILED on 2026-09-25.
    $now = $wpdb->get_var( $wpdb->prepare( "SELECT post_status FROM {$wpdb->posts} WHERE ID = %d", $p->ID ) );
    if ( false !== $ok && 'draft' === $now ) {
        $done++;
        fprintf( $err, "  drafted      %-5d %-14s %s\n", $p->ID, $p->post_type, $path );
    } else {
        fprintf( $err, "  FAILED       %-5d %s\n", $p->ID, $path );
    }
}

fprintf( $err, "\n%s: %d of %d\n", $apply ? 'Drafted' : 'Would draft', $apply ? $done : count( $found ), count( $found ) );
if ( $apply ) {
    fprintf( $err, "Backup captured on STDOUT.\n" );
    fprintf( $err, "Next: flush both caches, verify 41/41 single-hop, regenerate content/meta.json.\n" );
}
