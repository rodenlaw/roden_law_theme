<?php
/**
 * Retire the six root-level city pages for Greenville, Spartanburg and
 * Florence. Evidence: data/site-health/doorway-audit-2026-09-18.md — one click
 * on 2,322 impressions over 16 months, no office in any of the three cities,
 * and no Google Ads reference in any of the four Roden Law accounts (ads,
 * sitelinks, page feeds, Performance Max, 90-day paid landing pages, checked
 * 2026-09-19). Owner-approved 2026-09-19.
 *
 * Same guards as bin/remove-earning-intersections.php (#143): map and table
 * must agree, type and status checked per entry, no published child, link
 * debt counted only from real hrefs in posts outside the batch. Post type is
 * 'page' this time, which is hierarchical, so the child guard is live.
 *
 * ORDER MATTERS. The 301s must be LIVE before this runs. Posts are TRASHED,
 * not deleted: wp post untrash <ID> restores any.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-root-city-pages.php \
 *       > docs/backups/root-city-pages-$(date +%Y-%m-%d).json
 *   Apply — refuses while any published post outside the batch still links here:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-root-city-pages.php \
 *       > docs/backups/root-city-pages-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ID => [post_type, public path]. Source: wp post list on prod, 2026-09-18. */
$expect = array(
    4827 => array( 'page', '/spartanburg-sc-car-accident-lawyer/' ),
    4828 => array( 'page', '/greenville-sc-car-accident-lawyer/' ),
    4829 => array( 'page', '/florence-sc-car-accident-lawyer/' ),
    4830 => array( 'page', '/greenville-sc-workers-compensation-lawyer/' ),
    4831 => array( 'page', '/spartanburg-sc-workers-compensation-lawyer/' ),
    4832 => array( 'page', '/florence-sc-workers-compensation-lawyer/' ),
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — the 6 root city pages\n\n", $apply ? 'APPLY' : 'DRY RUN' );

foreach ( array( 'roden_root_city_page_urls' ) as $fn ) {
    if ( ! function_exists( $fn ) ) {
        fprintf( $err, "ABORT: %s() is not defined — the redirect map has not deployed yet.\n", $fn );
        fprintf( $err, "       Merge and deploy the theme change first, or these URLs 404 in the gap.\n" );
        exit( 1 );
    }
}
$map = roden_root_city_page_urls();

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
    if ( str_replace( '__trashed/', '/', $actual ) === trailingslashit( $path ) ) {
        $actual = trailingslashit( $path ); // the two Spanish twins whose permalink #142 renamed
    }
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
        $lp = str_replace( '__trashed/', '/', trailingslashit( (string) wp_parse_url( get_permalink( $lid ), PHP_URL_PATH ) ) );
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
    fprintf( $err, "\n  Run bin/relink-root-city-pages.php first.\n\n" );
    if ( $apply ) {
        fprintf( $err, "ABORT: refusing to trash pages that are still linked.\n" );
        exit( 1 );
    }
} else {
    fprintf( $err, "  No inbound editorial links outside the batch. Nothing to relink.\n\n" );
}

/* ---- Backup before touching anything ---- */

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'root-city-pages',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Restore with wp post untrash <ID>.',
    'evidence'  => 'data/site-health/doorway-audit-2026-09-18.md — 6 root city pages: 1 click / 2,322 impressions over 16 months; no Google Ads reference in any of the four accounts (checked 2026-09-19)',
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
        'redirects_to'  => $map[ $expect[ $p->ID ][1] ],
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
        fprintf( $err, "  would trash  %-5d %-14s %s\n", $p->ID, $p->post_type, $path );
        continue;
    }
    if ( wp_trash_post( $p->ID ) ) {
        $done++;
        fprintf( $err, "  trashed      %-5d %-14s %s\n", $p->ID, $p->post_type, $path );
    } else {
        fprintf( $err, "  FAILED       %-5d %s\n", $p->ID, $path );
    }
}

fprintf( $err, "\n%s: %d of %d\n", $apply ? 'Trashed' : 'Would trash', $apply ? $done : count( $found ), count( $found ) );
if ( $apply ) {
    fprintf( $err, "Backup captured on STDOUT. Restore any post with: wp post untrash <ID>\n" );
    fprintf( $err, "Next: flush both caches, verify 6/6 single-hop, regenerate content/meta.json.\n" );
}
