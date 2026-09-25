<?php
/**
 * Retire the 64 practice-area scenario pages that never earned a click: 0 clicks
 * in 16 months on 40,587 impressions. Plan and per-page data:
 * docs/scenario-pages-plan-2026-09-25.md (step 2). Owner-approved 2026-09-25.
 *
 * Paths and targets come from roden_zero_click_scenario_urls() in
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
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-zero-click-scenarios.php \
 *       > docs/backups/zero-click-scenarios-$(date +%Y-%m-%d).json
 *
 *   Apply — refuses while any published post outside the batch still links here:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-zero-click-scenarios.php \
 *       > docs/backups/zero-click-scenarios-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ID => [post_type, public path]. Source: prod pre-flight, 2026-09-25. */
$expect = array(
    4048 => array( 'practice_area', '/car-accident-lawyers/drunk-driver-accident/' ),
    4051 => array( 'practice_area', '/car-accident-lawyers/hit-and-run-accident/' ),
    4052 => array( 'practice_area', '/car-accident-lawyers/distracted-driving-accident/' ),
    4055 => array( 'practice_area', '/car-accident-lawyers/multi-vehicle-pileup/' ),
    4056 => array( 'practice_area', '/car-accident-lawyers/delivery-vehicle-accident/' ),
    4058 => array( 'practice_area', '/car-accident-lawyers/service-vehicle-accident/' ),
    4060 => array( 'practice_area', '/car-accident-lawyers/construction-vehicle-accident/' ),
    4062 => array( 'practice_area', '/car-accident-lawyers/t-bone-accident/' ),
    4063 => array( 'practice_area', '/truck-accident-lawyers/18-wheeler-semi-truck-accident/' ),
    4064 => array( 'practice_area', '/truck-accident-lawyers/fatigued-trucker-accident/' ),
    4066 => array( 'practice_area', '/truck-accident-lawyers/brake-failure-accident/' ),
    4067 => array( 'practice_area', '/truck-accident-lawyers/underride-override-accident/' ),
    4068 => array( 'practice_area', '/truck-accident-lawyers/commercial-van-delivery-truck-accident/' ),
    4069 => array( 'practice_area', '/truck-accident-lawyers/hazardous-materials-accident/' ),
    4071 => array( 'practice_area', '/motorcycle-accident-lawyers/head-on-motorcycle-collision/' ),
    4072 => array( 'practice_area', '/motorcycle-accident-lawyers/left-turn-accident/' ),
    4074 => array( 'practice_area', '/motorcycle-accident-lawyers/rear-end-motorcycle-accident/' ),
    4076 => array( 'practice_area', '/motorcycle-accident-lawyers/drunk-driver-motorcycle-accident/' ),
    4077 => array( 'practice_area', '/motorcycle-accident-lawyers/intersection-motorcycle-accident/' ),
    4079 => array( 'practice_area', '/pedestrian-accident-lawyers/crosswalk-accident/' ),
    4080 => array( 'practice_area', '/pedestrian-accident-lawyers/intersection-pedestrian-accident/' ),
    4082 => array( 'practice_area', '/pedestrian-accident-lawyers/distracted-driver-pedestrian-accident/' ),
    4083 => array( 'practice_area', '/pedestrian-accident-lawyers/drunk-driver-pedestrian-accident/' ),
    4093 => array( 'practice_area', '/slip-and-fall-lawyers/wet-floor-accident/' ),
    4094 => array( 'practice_area', '/slip-and-fall-lawyers/parking-lot-fall/' ),
    4098 => array( 'practice_area', '/slip-and-fall-lawyers/workplace-slip-and-fall/' ),
    4100 => array( 'practice_area', '/wrongful-death-lawyers/fatal-truck-accident/' ),
    4103 => array( 'practice_area', '/wrongful-death-lawyers/defective-product-death/' ),
    4107 => array( 'practice_area', '/workers-compensation-lawyers/construction-worker-injury/' ),
    4108 => array( 'practice_area', '/workers-compensation-lawyers/factory-manufacturing-injury/' ),
    4109 => array( 'practice_area', '/workers-compensation-lawyers/warehouse-distribution-injury/' ),
    4114 => array( 'practice_area', '/workers-compensation-lawyers/fatal-workplace-accident/' ),
    4123 => array( 'practice_area', '/maritime-injury-lawyers/jones-act-seaman-claim/' ),
    4128 => array( 'practice_area', '/maritime-injury-lawyers/commercial-fishing-injury/' ),
    4131 => array( 'practice_area', '/product-liability-lawyers/defective-auto-parts/' ),
    4136 => array( 'practice_area', '/product-liability-lawyers/defective-childrens-product/' ),
    4139 => array( 'practice_area', '/boating-accident-lawyers/jet-ski-personal-watercraft/' ),
    4140 => array( 'practice_area', '/boating-accident-lawyers/speedboat-powerboat-collision/' ),
    4142 => array( 'practice_area', '/boating-accident-lawyers/sailboat-accident/' ),
    4143 => array( 'practice_area', '/boating-accident-lawyers/kayak-canoe-accident/' ),
    4145 => array( 'practice_area', '/boating-accident-lawyers/commercial-vessel-accident/' ),
    4147 => array( 'practice_area', '/burn-injury-lawyers/workplace-burn-injury/' ),
    4154 => array( 'practice_area', '/burn-injury-lawyers/defective-product-burn/' ),
    4156 => array( 'practice_area', '/construction-accident-lawyers/crane-heavy-equipment-accident/' ),
    4159 => array( 'practice_area', '/construction-accident-lawyers/falling-object-injury/' ),
    4161 => array( 'practice_area', '/construction-accident-lawyers/roofing-accident/' ),
    4174 => array( 'practice_area', '/bicycle-accident-lawyers/hit-and-run-bicycle-accident/' ),
    4175 => array( 'practice_area', '/bicycle-accident-lawyers/road-hazard-bicycle-crash/' ),
    4176 => array( 'practice_area', '/bicycle-accident-lawyers/distracted-driver-bicycle-accident/' ),
    4185 => array( 'practice_area', '/golf-cart-accident-lawyers/golf-cart-rollover/' ),
    4201 => array( 'practice_area', '/brain-injury-lawyers/severe-traumatic-brain-injury/' ),
    4203 => array( 'practice_area', '/brain-injury-lawyers/penetrating-brain-injury/' ),
    4204 => array( 'practice_area', '/brain-injury-lawyers/anoxic-hypoxic-brain-injury/' ),
    4206 => array( 'practice_area', '/brain-injury-lawyers/birth-related-brain-injury/' ),
    4208 => array( 'practice_area', '/spinal-cord-injury-lawyers/complete-spinal-cord-injury/' ),
    4209 => array( 'practice_area', '/spinal-cord-injury-lawyers/incomplete-spinal-cord-injury/' ),
    4211 => array( 'practice_area', '/spinal-cord-injury-lawyers/tetraplegia-quadriplegia/' ),
    4212 => array( 'practice_area', '/spinal-cord-injury-lawyers/herniated-ruptured-disc/' ),
    4217 => array( 'practice_area', '/premises-liability-lawyers/restaurant-hotel-injury/' ),
    4218 => array( 'practice_area', '/premises-liability-lawyers/apartment-complex-injury/' ),
    4226 => array( 'practice_area', '/electric-scooter-accident-lawyers/road-hazard-escooter-crash/' ),
    4625 => array( 'practice_area', '/car-accident-lawyers/uber-lyft-accident/' ),
    4628 => array( 'practice_area', '/truck-accident-lawyers/cement-truck-accident/' ),
    4631 => array( 'practice_area', '/workers-compensation-lawyers/port-worker-injury/' ),
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — 64 zero-click scenario pages\n\n", $apply ? 'APPLY' : 'DRY RUN' );

if ( ! function_exists( 'roden_zero_click_scenario_urls' ) ) {
    fprintf( $err, "ABORT: roden_zero_click_scenario_urls() is not defined — the redirect map has not deployed yet.\n" );
    fprintf( $err, "       Merge and deploy the theme change first, or these URLs 404 in the gap.\n" );
    exit( 1 );
}
$map = roden_zero_click_scenario_urls();

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
    fprintf( $err, "\n  Run bin/relink-zero-click-scenarios.php first.\n\n" );
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
    'batch'     => 'zero-click-scenarios',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Set to draft, not trashed. Restore: remove the path from roden_zero_click_scenario_urls(), check the doorway ratio, publish.',
    'evidence'  => 'docs/scenario-pages-plan-2026-09-25.md — 64 scenario pages: 0 clicks / 40,587 impressions, 16 months to 2026-09-21',
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
    update_post_meta( $p->ID, '_roden_retired', '2026-09-25 zero-click-scenarios' );
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
    fprintf( $err, "Next: flush both caches, verify 64/64 single-hop, flat and nested, regenerate content/meta.json.\n" );
}
