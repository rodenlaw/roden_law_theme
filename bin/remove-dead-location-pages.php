<?php
/**
 * Retire the 66 nested location pages that Google serves and nobody clicks.
 *
 * Plan rule 4 keeps a non-office city page only where there are "real rankings,
 * traffic or genuine service history". Over 2025-07-23 to 2026-08-22 these 66 took
 * 21,548 impressions and earned 1 click — CTR 0.005%, against the site's own 0.48%
 * at matching positions. Evidence: docs/gsc-evidence-2026-08-24.md, Finding 3.
 * Owner-approved 2026-08-25.
 *
 * The paths and targets are NOT duplicated here. They are read from
 * roden_dead_location_urls() in inc/legacy-redirects.php, so the redirect map and
 * the removal set cannot drift apart — batches (a), (b) and (d) each carried their
 * own copy, which is a class of bug waiting to happen. What IS declared here is the
 * ID => path pairing, because get_post( $id ) is the only way to be certain which
 * row is about to be trashed, and pairing IDs to paths by array index is how batch
 * (b) nearly trashed the wrong pages.
 *
 * ORDER MATTERS. The 301s must be LIVE before this runs, or these URLs 404 in the
 * gap. They are path-keyed and fire whether or not the post exists.
 *
 * Posts are TRASHED, not force-deleted. Reversible with wp post untrash <ID>.
 *
 *   Dry run (default) — reports inbound links; nothing is changed:
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-dead-location-pages.php \
 *       > docs/backups/dead-locations-$(date +%Y-%m-%d).json
 *
 *   Apply — refuses to run while any published post still links here:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-dead-location-pages.php \
 *       > docs/backups/dead-locations-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ID => public path. Source: docs/url-inventory-2026-08-21.csv, cross-checked live. */
$expect = array(
    3768 => '/locations/south-carolina/charleston/johns-island/',
    3771 => '/locations/south-carolina/north-charleston/hanahan/',
    3772 => '/locations/south-carolina/charleston/folly-beach/',
    3774 => '/locations/south-carolina/charleston/sullivans-island/',
    3776 => '/locations/south-carolina/north-charleston/moncks-corner/',
    3777 => '/locations/south-carolina/charleston/kiawah-island/',
    3778 => '/locations/south-carolina/charleston/seabrook-island/',
    3780 => '/locations/south-carolina/charleston/awendaw/',
    3781 => '/locations/south-carolina/charleston/hollywood/',
    3782 => '/locations/south-carolina/charleston/ravenel/',
    3783 => '/locations/south-carolina/charleston/meggett/',
    3784 => '/locations/south-carolina/charleston/wadmalaw-island/',
    3785 => '/locations/south-carolina/charleston/edisto-island/',
    3786 => '/locations/south-carolina/charleston/mcclellanville/',
    3789 => '/locations/georgia/savannah/richmond-hill/',
    3790 => '/locations/georgia/savannah/rincon/',
    3791 => '/locations/georgia/savannah/garden-city/',
    3793 => '/locations/georgia/savannah/wilmington-island/',
    3794 => '/locations/georgia/savannah/tybee-island/',
    3799 => '/locations/georgia/savannah/effingham-county/',
    3800 => '/locations/georgia/savannah/bloomingdale/',
    3802 => '/locations/georgia/savannah/isle-of-hope/',
    3803 => '/locations/georgia/savannah/thunderbolt/',
    3806 => '/locations/georgia/savannah/springfield/',
    3807 => '/locations/georgia/savannah/guyton/',
    3815 => '/locations/south-carolina/myrtle-beach/north-myrtle-beach/',
    3818 => '/locations/south-carolina/myrtle-beach/socastee/',
    3819 => '/locations/south-carolina/myrtle-beach/garden-city-beach/',
    3822 => '/locations/south-carolina/myrtle-beach/pawleys-island/',
    3824 => '/locations/south-carolina/myrtle-beach/forestbrook/',
    3825 => '/locations/south-carolina/myrtle-beach/longs/',
    3826 => '/locations/south-carolina/myrtle-beach/loris/',
    3827 => '/locations/south-carolina/myrtle-beach/aynor/',
    3828 => '/locations/south-carolina/myrtle-beach/litchfield-beach/',
    3829 => '/locations/south-carolina/myrtle-beach/red-hill/',
    3830 => '/locations/south-carolina/myrtle-beach/burgess/',
    3831 => '/locations/south-carolina/myrtle-beach/bucksport/',
    3833 => '/locations/south-carolina/myrtle-beach/atlantic-beach/',
    3834 => '/locations/south-carolina/myrtle-beach/briarcliffe-acres/',
    3835 => '/locations/south-carolina/myrtle-beach/wampee/',
    3836 => '/locations/south-carolina/myrtle-beach/galivants-ferry/',
    3837 => '/locations/south-carolina/myrtle-beach/green-sea/',
    3839 => '/locations/south-carolina/columbia/lexington/',
    3842 => '/locations/south-carolina/columbia/irmo/',
    3843 => '/locations/south-carolina/columbia/st-andrews/',
    3844 => '/locations/south-carolina/columbia/seven-oaks/',
    3845 => '/locations/south-carolina/columbia/dentsville/',
    3848 => '/locations/south-carolina/columbia/oak-grove/',
    3849 => '/locations/south-carolina/columbia/blythewood/',
    3851 => '/locations/south-carolina/columbia/woodfield/',
    3854 => '/locations/south-carolina/columbia/hopkins/',
    3855 => '/locations/south-carolina/columbia/springdale/',
    3858 => '/locations/south-carolina/columbia/south-congaree/',
    3859 => '/locations/south-carolina/columbia/pine-ridge/',
    3860 => '/locations/south-carolina/columbia/camden/',
    3861 => '/locations/south-carolina/columbia/gaston/',
    3862 => '/locations/south-carolina/columbia/pelion/',
    3866 => '/locations/georgia/darien/st-marys/',
    3874 => '/locations/georgia/darien/ludowici/',
    3878 => '/locations/georgia/darien/dock-junction/',
    3880 => '/locations/georgia/darien/waverly/',
    3881 => '/locations/georgia/darien/white-oak/',
    3882 => '/locations/georgia/darien/townsend/',
    3883 => '/locations/georgia/darien/eulonia/',
    3884 => '/locations/georgia/darien/odum/',
    3885 => '/locations/georgia/darien/screven/',
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — 66 dead location pages\n\n", $apply ? 'APPLY' : 'DRY RUN' );

if ( ! function_exists( 'roden_dead_location_urls' ) ) {
    fprintf( $err, "ABORT: roden_dead_location_urls() is not defined — the redirect map has not deployed yet.\n" );
    fprintf( $err, "       Merge and deploy the theme change first, or these URLs 404 in the gap.\n" );
    exit( 1 );
}
$map = roden_dead_location_urls();

/* The map and this script must describe exactly the same set. */
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

    /*
     * Guard: an office-city hub must never end up in here. The six hubs are the
     * redirect targets, so trashing one would turn 11-17 redirects into a chain
     * or a 404 in a single step.
     */
    if ( in_array( $actual, array_values( $map ), true ) ) {
        fprintf( $err, "ABORT: %s is a redirect TARGET — that is an office-city hub.\n", $actual );
        exit( 1 );
    }

    /*
     * Inbound editorial links. Batch (a) found 53 across 23 blog posts, so this is
     * a real possibility, not a formality. On a dry run this REPORTS rather than
     * aborts, so one pass tells you the whole relink workload; on apply it is fatal,
     * because shipping it would leave those links resolving through a 301.
     */
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
    fprintf( $err, "\n  Run bin/relink-dead-locations.php first. It repoints each href at the\n" );
    fprintf( $err, "  parent hub, preserves the anchor text, and does NOT stamp post_modified.\n\n" );
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
    'batch'     => 'dead-location-pages',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Restore with wp_untrash_post( ID ).',
    'evidence'  => 'docs/gsc-evidence-2026-08-24.md Finding 3 — 21,548 impressions, 1 click, CTR 0.005%',
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
    fprintf( $err, "Next: flush both caches, verify 66/66 single-hop, regenerate content/meta.json.\n" );
}
