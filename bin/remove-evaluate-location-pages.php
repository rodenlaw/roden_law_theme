<?php
/**
 * Retire the 13 EVALUATE location pages — the last of the rule-4 backlog.
 *
 * They survived #68 because each had at least one click in the 13-month Search
 * Console baseline. A fresh API pull on 2026-09-18 (16 months to 2026-09-15,
 * docs/gsc-2026-09-18/) adds nothing: 19 clicks in total, all before the August
 * cull, zero on 1,069 impressions in the 24 days since. Rankings without traffic
 * and no service history; plan rule 4's default is a 301 to the parent hub.
 * Evidence: data/site-health/doorway-audit-2026-09-18.md. Owner-approved
 * 2026-09-18.
 *
 * Paths and targets are read from roden_evaluate_location_urls() in
 * inc/legacy-redirects.php so the redirect map and the removal set cannot drift.
 * The ID => path pairing IS declared here, because get_post( $id ) is the only
 * way to be certain which row is about to be trashed (see #68 for why).
 *
 * ORDER MATTERS. The 301s must be LIVE before this runs, or these URLs 404 in
 * the gap. They are path-keyed and fire whether or not the post exists.
 *
 * Posts are TRASHED, not force-deleted. Reversible with wp post untrash <ID>.
 *
 *   Dry run (default) — reports inbound links; nothing is changed:
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-evaluate-location-pages.php \
 *       > docs/backups/evaluate-locations-$(date +%Y-%m-%d).json
 *
 *   Apply — refuses to run while any published post still links here:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-evaluate-location-pages.php \
 *       > docs/backups/evaluate-locations-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ID => public path. Source: wp post list --post_type=location on prod, 2026-09-18. */
$expect = array(
    3770 => '/locations/south-carolina/north-charleston/ladson/',
    3804 => '/locations/georgia/savannah/whitemarsh-island/',
    3805 => '/locations/georgia/savannah/skidaway-island/',
    3816 => '/locations/south-carolina/myrtle-beach/carolina-forest/',
    3820 => '/locations/south-carolina/myrtle-beach/little-river/',
    3821 => '/locations/south-carolina/myrtle-beach/murrells-inlet/',
    3847 => '/locations/south-carolina/columbia/red-bank/',
    3853 => '/locations/south-carolina/columbia/lugoff/',
    3864 => '/locations/georgia/darien/st-simons-island/',
    3870 => '/locations/georgia/darien/jekyll-island/',
    3879 => '/locations/georgia/darien/kings-bay/',
    3886 => '/locations/georgia/darien/sea-island/',
    3887 => '/locations/georgia/darien/harrietts-bluff/',
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — 13 EVALUATE location pages\n\n", $apply ? 'APPLY' : 'DRY RUN' );

if ( ! function_exists( 'roden_evaluate_location_urls' ) ) {
    fprintf( $err, "ABORT: roden_evaluate_location_urls() is not defined — the redirect map has not deployed yet.\n" );
    fprintf( $err, "       Merge and deploy the theme change first, or these URLs 404 in the gap.\n" );
    exit( 1 );
}
$map = roden_evaluate_location_urls();

$only_map    = array_diff( array_keys( $map ), array_values( $expect ) );
$only_script = array_diff( array_values( $expect ), array_keys( $map ) );
if ( $only_map || $only_script ) {
    fprintf( $err, "ABORT: the redirect map and this script disagree.\n" );
    foreach ( $only_map as $p )    { fprintf( $err, "  in map, not here:    %s\n", $p ); }
    foreach ( $only_script as $p ) { fprintf( $err, "  here, not in map:    %s\n", $p ); }
    exit( 1 );
}

global $wpdb;
$found = array();
$link_debt = array();

foreach ( $expect as $id => $path ) {
    $p = get_post( $id );

    if ( ! $p instanceof WP_Post ) {
        fprintf( $err, "ABORT: ID %d not found.\n", $id );
        exit( 1 );
    }
    if ( 'location' !== $p->post_type ) {
        fprintf( $err, "ABORT: ID %d is post_type '%s', expected 'location'.\n", $id, $p->post_type );
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

    /* An office-city hub is a redirect TARGET and must never be trashed here. */
    if ( in_array( $actual, array_values( $map ), true ) ) {
        fprintf( $err, "ABORT: %s is a redirect TARGET — that is an office-city hub.\n", $actual );
        exit( 1 );
    }

    /* Child pages: trashing a hierarchical parent would orphan them into 404s. */
    $children = get_posts( array( 'post_type' => 'location', 'post_parent' => $p->ID, 'post_status' => 'any', 'fields' => 'ids', 'numberposts' => -1 ) );
    $live_children = array_filter( $children, function ( $cid ) { return 'publish' === get_post_status( $cid ); } );
    if ( $live_children ) {
        fprintf( $err, "ABORT: %s still has %d published child page(s): %s\n", $actual, count( $live_children ), implode( ', ', $live_children ) );
        exit( 1 );
    }

    /* Inbound editorial links — reported on dry run, fatal on apply. */
    $like = '%' . $wpdb->esc_like( $actual ) . '%';
    $refs = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status='publish' AND post_type NOT IN ('revision') AND ID <> %d AND post_content LIKE %s",
        $id, $like
    ) );
    if ( $refs > 0 ) {
        $link_debt[ $actual ] = $refs;
    }

    $found[] = $p;
}

if ( $link_debt ) {
    fprintf( $err, "\n%d of %d URLs still have inbound links in published post bodies:\n", count( $link_debt ), count( $expect ) );
    foreach ( $link_debt as $path => $n ) {
        fprintf( $err, "    %2d post(s) -> %s\n", $n, $path );
    }
    fprintf( $err, "\n  Run bin/relink-evaluate-locations.php first.\n\n" );
    if ( $apply ) {
        fprintf( $err, "ABORT: refusing to trash pages that are still linked.\n" );
        exit( 1 );
    }
} else {
    fprintf( $err, "  No inbound editorial links. Nothing to relink.\n\n" );
}

/* ---- Backup before touching anything ---- */

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'evaluate-location-pages',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Restore with wp post untrash <ID>.',
    'evidence'  => 'data/site-health/doorway-audit-2026-09-18.md — 19 clicks / 9,515 impressions over 16 months, 0 clicks since 2026-08-26',
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
        fprintf( $err, "  would trash  %-5d %s\n", $p->ID, $path );
        continue;
    }
    if ( wp_trash_post( $p->ID ) ) {
        $done++;
        fprintf( $err, "  trashed      %-5d %s\n", $p->ID, $path );
    } else {
        fprintf( $err, "  FAILED       %-5d %s\n", $p->ID, $path );
    }
}

fprintf( $err, "\n%s: %d of %d\n", $apply ? 'Trashed' : 'Would trash', $apply ? $done : count( $found ), count( $found ) );
if ( $apply ) {
    fprintf( $err, "Backup captured on STDOUT. Restore any post with: wp post untrash <ID>\n" );
    fprintf( $err, "Next: flush both caches, verify 13/13 single-hop, regenerate content/meta.json.\n" );
}
