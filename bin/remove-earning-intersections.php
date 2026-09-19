<?php
/**
 * Retire the last 47 office-city intersections. Evidence:
 * docs/gsc-evidence-2026-09-18.md, Finding 3 — 95 clicks on 564,905
 * impressions over 16 months, CTR 0.017% against the site's 0.12-0.47%.
 * Owner-approved 2026-09-19.
 *
 * Paths and targets come from roden_earning_intersection_urls() in
 * inc/legacy-redirects.php. The ID => [type, path] pairing is declared here
 * because get_post( $id ) is the only way to be certain which row is about to
 * be trashed. Same guards as bin/remove-zero-click-pages.php (#142): the map and
 * this table must agree, type and status checked per entry, no published child,
 * link debt counted only from real hrefs in posts outside the batch.
 *
 * Two entries (4906, 4912) are the Spanish twins whose URLs #142 broke by
 * trashing their English slug-mates; get_permalink() on them now returns the
 * `__trashed` form, so the path check below compares against the map key by
 * post ID rather than aborting on the permalink mismatch.
 *
 * ORDER MATTERS. The 301s must be LIVE before this runs. Posts are TRASHED,
 * not deleted: wp post untrash <ID> restores any.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-earning-intersections.php \
 *       > docs/backups/earning-intersections-$(date +%Y-%m-%d).json
 *
 *   Apply — refuses while any published post outside the batch still links here:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-earning-intersections.php \
 *       > docs/backups/earning-intersections-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ID => [post_type, public path]. Source: wp post list on prod, 2026-09-18. */
$expect = array(
    3622 => array( 'practice_area', '/car-accident-lawyers/savannah-ga/' ),
    3623 => array( 'practice_area', '/car-accident-lawyers/darien-ga/' ),
    3624 => array( 'practice_area', '/car-accident-lawyers/charleston-sc/' ),
    3625 => array( 'practice_area', '/car-accident-lawyers/columbia-sc/' ),
    3627 => array( 'practice_area', '/truck-accident-lawyers/savannah-ga/' ),
    3630 => array( 'practice_area', '/truck-accident-lawyers/columbia-sc/' ),
    3632 => array( 'practice_area', '/slip-and-fall-lawyers/savannah-ga/' ),
    3635 => array( 'practice_area', '/slip-and-fall-lawyers/columbia-sc/' ),
    3640 => array( 'practice_area', '/motorcycle-accident-lawyers/columbia-sc/' ),
    3642 => array( 'practice_area', '/medical-malpractice-lawyers/savannah-ga/' ),
    3643 => array( 'practice_area', '/medical-malpractice-lawyers/darien-ga/' ),
    3644 => array( 'practice_area', '/medical-malpractice-lawyers/charleston-sc/' ),
    3645 => array( 'practice_area', '/medical-malpractice-lawyers/columbia-sc/' ),
    3646 => array( 'practice_area', '/medical-malpractice-lawyers/myrtle-beach-sc/' ),
    3648 => array( 'practice_area', '/wrongful-death-lawyers/darien-ga/' ),
    3650 => array( 'practice_area', '/wrongful-death-lawyers/columbia-sc/' ),
    3651 => array( 'practice_area', '/wrongful-death-lawyers/myrtle-beach-sc/' ),
    3652 => array( 'practice_area', '/workers-compensation-lawyers/savannah-ga/' ),
    3654 => array( 'practice_area', '/workers-compensation-lawyers/charleston-sc/' ),
    3656 => array( 'practice_area', '/workers-compensation-lawyers/myrtle-beach-sc/' ),
    3657 => array( 'practice_area', '/dog-bite-lawyers/savannah-ga/' ),
    3659 => array( 'practice_area', '/dog-bite-lawyers/charleston-sc/' ),
    3660 => array( 'practice_area', '/dog-bite-lawyers/columbia-sc/' ),
    3661 => array( 'practice_area', '/dog-bite-lawyers/myrtle-beach-sc/' ),
    3671 => array( 'practice_area', '/spinal-cord-injury-lawyers/myrtle-beach-sc/' ),
    3672 => array( 'practice_area', '/maritime-injury-lawyers/savannah-ga/' ),
    3673 => array( 'practice_area', '/maritime-injury-lawyers/darien-ga/' ),
    3676 => array( 'practice_area', '/maritime-injury-lawyers/myrtle-beach-sc/' ),
    3679 => array( 'practice_area', '/product-liability-lawyers/charleston-sc/' ),
    3680 => array( 'practice_area', '/product-liability-lawyers/columbia-sc/' ),
    3685 => array( 'practice_area', '/boating-accident-lawyers/columbia-sc/' ),
    3689 => array( 'practice_area', '/burn-injury-lawyers/charleston-sc/' ),
    3690 => array( 'practice_area', '/burn-injury-lawyers/columbia-sc/' ),
    3697 => array( 'practice_area', '/nursing-home-abuse-lawyers/savannah-ga/' ),
    3701 => array( 'practice_area', '/nursing-home-abuse-lawyers/myrtle-beach-sc/' ),
    3702 => array( 'practice_area', '/premises-liability-lawyers/savannah-ga/' ),
    3703 => array( 'practice_area', '/premises-liability-lawyers/darien-ga/' ),
    3706 => array( 'practice_area', '/premises-liability-lawyers/myrtle-beach-sc/' ),
    3710 => array( 'practice_area', '/pedestrian-accident-lawyers/columbia-sc/' ),
    4233 => array( 'practice_area', '/bicycle-accident-lawyers/darien-ga/' ),
    4241 => array( 'practice_area', '/electric-scooter-accident-lawyers/myrtle-beach-sc/' ),
    4251 => array( 'practice_area', '/golf-cart-accident-lawyers/myrtle-beach-sc/' ),
    4906 => array( 'practice_area', '/es/car-accident-lawyers/north-charleston-sc/' ),
    4912 => array( 'practice_area', '/es/workers-compensation-lawyers/columbia-sc/' ),
    4916 => array( 'practice_area', '/es/workers-compensation-lawyers/savannah-ga/' ),
    5052 => array( 'practice_area', '/personal-injury-lawyers/charleston-sc/' ),
    5275 => array( 'practice_area', '/personal-injury-lawyers/north-charleston-sc/' ),
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — the last 47 intersections\n\n", $apply ? 'APPLY' : 'DRY RUN' );

foreach ( array( 'roden_earning_intersection_urls' ) as $fn ) {
    if ( ! function_exists( $fn ) ) {
        fprintf( $err, "ABORT: %s() is not defined — the redirect map has not deployed yet.\n", $fn );
        fprintf( $err, "       Merge and deploy the theme change first, or these URLs 404 in the gap.\n" );
        exit( 1 );
    }
}
$map = roden_earning_intersection_urls();

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
    fprintf( $err, "\n  Run bin/relink-earning-intersections.php first.\n\n" );
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
    'batch'     => 'earning-intersections',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Restore with wp post untrash <ID>.',
    'evidence'  => 'docs/gsc-evidence-2026-09-18.md Finding 3 — 47 intersections: 95 clicks / 564,905 impressions, CTR 0.017%, 16 months to 2026-09-15',
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
    fprintf( $err, "Next: flush both caches, verify 47/47 single-hop (flat AND nested), regenerate content/meta.json.\n" );
}
