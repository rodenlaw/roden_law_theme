<?php
/**
 * Retire the 14 geo blog posts that never earned a click: 0 clicks in 16 months,
 * under 100 impressions in 90 days. Evidence: docs/site-architecture/evidence/
 * inventory.csv (status DEAD). Owner-approved 2026-09-26, step 1 of
 * docs/site-architecture/README.md — they fund the office practice pages.
 *
 * Paths and targets come from roden_dead_geo_post_urls() in
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
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-dead-geo-posts.php \
 *       > docs/backups/dead-geo-posts-$(date +%Y-%m-%d).json
 *
 *   Apply — refuses while any published post outside the batch still links here:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-dead-geo-posts.php \
 *       > docs/backups/dead-geo-posts-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ID => [post_type, public path]. Source: prod pre-flight, 2026-09-26. */
$expect = array(
    2546 => array( 'post', '/blog/can-a-witness-be-forced-to-testify-for-a-savannah-car-crash-case/' ),
    2768 => array( 'post', '/blog/what-are-my-legal-options-after-a-rideshare-crash-in-charleston/' ),
    2792 => array( 'post', '/blog/filing-soft-tissue-injury-claims-in-charleston/' ),
    2872 => array( 'post', '/blog/how-delayed-injuries-could-impact-your-charleston-car-crash-claim/' ),
    3054 => array( 'post', '/blog/compensation-for-car-crash-facial-injuries-charleston/' ),
    3226 => array( 'post', '/blog/liability-for-charleston-underride-truck-crashes/' ),
    3515 => array( 'post', '/blog/a-pedestrians-guide-to-claiming-lost-wages-in-charleston/' ),
    3521 => array( 'post', '/blog/filing-a-claim-after-a-hazmat-truck-crash-in-charleston/' ),
    3531 => array( 'post', '/blog/how-poor-truck-maintenance-causes-charleston-accidents/' ),
    3563 => array( 'post', '/blog/protecting-your-rights-after-a-myrtle-beach-car-accident/' ),
    3572 => array( 'post', '/blog/proving-a-tourist-was-at-fault-in-your-charleston-accident/' ),
    3576 => array( 'post', '/blog/recovering-lost-wages-after-a-truck-accident-on-i-526/' ),
    3578 => array( 'post', '/blog/seeking-justice-after-a-fatigued-trucker-accident-on-i-26/' ),
    4336 => array( 'post', '/blog/port-of-charleston-injury-claims-longshoremen-dock-workers/' ),
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — 14 zero-click geo blog posts\n\n", $apply ? 'APPLY' : 'DRY RUN' );

if ( ! function_exists( 'roden_dead_geo_post_urls' ) ) {
    fprintf( $err, "ABORT: roden_dead_geo_post_urls() is not defined — the redirect map has not deployed yet.\n" );
    fprintf( $err, "       Merge and deploy the theme change first, or these URLs 404 in the gap.\n" );
    exit( 1 );
}
$map = roden_dead_geo_post_urls();

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
    fprintf( $err, "\n  Run bin/relink-dead-geo-posts.php first.\n\n" );
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
    'batch'     => 'dead-geo-posts',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Set to draft, not trashed. Restore: remove the path from roden_dead_geo_post_urls(), check the doorway ratio, publish.',
    'evidence'  => 'docs/site-architecture/evidence/inventory.csv — 14 posts: 0 clicks in 16 months, <100 impressions in 90 days each',
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
    update_post_meta( $p->ID, '_roden_retired', '2026-09-26 dead-geo-posts' );
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
    fprintf( $err, "Next: flush both caches, verify 14/14 single-hop, regenerate content/meta.json.\n" );
}
