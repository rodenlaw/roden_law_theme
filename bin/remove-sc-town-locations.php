<?php
/**
 * Phase 1 batch (b) — retire the eight non-office SC town location pages.
 *
 * SEO pre-emption plan rule 4: city pages in markets with no office, kept only
 * with real rankings/traffic or genuine service history. These eight were
 * published 2026-08-20, carry 270-322 unique words against a median of 843 for
 * the office-city pages, and have zero inbound internal links in post content,
 * post meta or the nav menus.
 *
 * ORDER MATTERS. The 301s in inc/legacy-redirects.php
 * (roden_phase1_removed_urls) must be LIVE before this runs, or the eight URLs
 * 404 in the gap. The redirects are path-keyed so they fire whether or not the
 * post still exists — deploy first, then run this.
 *
 * Posts are TRASHED, not force-deleted: trashed posts are non-public, so the
 * page cannot regenerate, and the action stays reversible. The database is not
 * in this repo and has no undo, so a full JSON backup of every post and its
 * meta is written to STDOUT on both dry and apply runs. Status goes to STDERR.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-sc-town-locations.php \
 *       > backup-8-towns.json
 *
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-sc-town-locations.php \
 *       > backup-8-towns.json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/*
 * ID => slug, as one map rather than two parallel arrays. Keeping them separate
 * invites an index-pairing bug, and did: the IDs ascend while the slugs were
 * alphabetical, so every pair was wrong. The verification below caught it, but
 * the shape that made it possible is gone.
 * Source: url-triage.csv, location tier 2, non-office markets.
 */
$expect = array(
    5331 => 'hilton-head',
    5332 => 'orangeburg',
    5333 => 'sumter',
    5334 => 'spartanburg',
    5335 => 'rock-hill',
    5336 => 'fort-mill',
    5337 => 'greer',
    5338 => 'simpsonville',
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — Phase 1 batch (b)\n\n", $apply ? 'APPLY' : 'DRY RUN' );

/* ---- Resolve, and refuse to guess ---------------------------------- */

/*
 * Resolved by ID, not by slug. `location` is a hierarchical post type and
 * get_posts( 'name' => ... ) resolves unreliably against those — it has failed
 * silently on this CPT before. The IDs come from the reviewed url-triage.csv,
 * and every one is verified against its expected slug and path below, so a
 * mismatched ID aborts rather than deleting the wrong page.
 */
$found = array();
foreach ( $expect as $id => $slug ) {
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
    if ( $p->post_name !== $slug ) {
        fprintf( $err, "ABORT: ID %d has slug '%s', expected '%s'.\n", $id, $p->post_name, $slug );
        exit( 1 );
    }

    // Guard: must be a city-tier SC location, i.e. /locations/south-carolina/{slug}/
    $path = (string) wp_parse_url( get_permalink( $p ), PHP_URL_PATH );
    if ( trailingslashit( $path ) !== "/locations/south-carolina/{$slug}/" ) {
        fprintf( $err, "ABORT: ID %d is at %s, not the expected city-tier path.\n", $id, $path );
        exit( 1 );
    }

    // Guard: never touch an office market.
    $offices = array( 'savannah', 'darien', 'charleston', 'north-charleston', 'columbia', 'myrtle-beach' );
    if ( in_array( $slug, $offices, true ) ) {
        fprintf( $err, "ABORT: %s is an office market.\n", $slug );
        exit( 1 );
    }

    // Guard: refuse if anything still links here.
    $like = '%' . $GLOBALS['wpdb']->esc_like( "/locations/south-carolina/{$slug}/" ) . '%';
    $refs = (int) $GLOBALS['wpdb']->get_var( $GLOBALS['wpdb']->prepare(
        "SELECT COUNT(*) FROM {$GLOBALS['wpdb']->posts} WHERE post_status='publish' AND ID <> %d AND post_content LIKE %s",
        $id, $like
    ) );
    if ( $refs > 0 ) {
        fprintf( $err, "ABORT: %d published posts still link to %s — strip those first.\n", $refs, $slug );
        exit( 1 );
    }

    $found[] = $p;
}

if ( count( $found ) !== count( $expect ) ) {
    fprintf( $err, "ABORT: resolved %d of %d.\n", count( $found ), count( $expect ) );
    exit( 1 );
}

/* ---- Backup everything before touching anything --------------------- */

$backup = array(
    'generated'  => gmdate( 'c' ),
    'batch'      => 'phase1-b-sc-town-locations',
    'mode'       => $apply ? 'apply' : 'dry-run',
    'note'       => 'Restore with wp_untrash_post( ID ), or recreate from post + meta below.',
    'posts'      => array(),
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
        'post_content'  => $p->post_content,
        'post_excerpt'  => $p->post_excerpt,
        'meta'          => get_post_meta( $p->ID ),
    );
}
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

/* ---- Act ------------------------------------------------------------ */

$done = 0;
foreach ( $found as $p ) {
    $path = (string) wp_parse_url( get_permalink( $p ), PHP_URL_PATH );
    if ( ! $apply ) {
        fprintf( $err, "  would trash  %-5d %s\n", $p->ID, $path );
        continue;
    }
    $res = wp_trash_post( $p->ID );
    if ( $res ) {
        $done++;
        fprintf( $err, "  trashed      %-5d %s\n", $p->ID, $path );
    } else {
        fprintf( $err, "  FAILED       %-5d %s\n", $p->ID, $path );
    }
}

fprintf( $err, "\n%s: %d of %d\n", $apply ? 'Trashed' : 'Would trash', $apply ? $done : count( $found ), count( $found ) );
if ( $apply ) {
    fprintf( $err, "Backup captured on STDOUT. Restore any post with: wp post untrash <ID>\n" );
    fprintf( $err, "Next: regenerate sitemaps, flush caches, and verify the eight 301s.\n" );
}
