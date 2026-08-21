<?php
/**
 * Phase 1 batch (d) — retire the non-office city x practice pages.
 *
 * SEO pre-emption plan rule 7: city x practice in a market with no office,
 * 301 to the statewide practice page. All 34 are English, 195-354 unique words
 * (median 251) against a median of 843 for the office-city pages that are kept,
 * and none carries an inbound internal link in post content or post meta.
 *
 * Internal links need no stripping: roden_intersection_grid() in
 * inc/template-tags.php queries for each intersection post and links to the
 * pillar when it is absent, so trashing these makes the grids fall back on
 * their own. Verified against the function, not assumed.
 *
 * ORDER MATTERS. The 301s in inc/legacy-redirects.php
 * (roden_phase1_removed_urls) must be LIVE before this runs, or these URLs
 * 404 in the gap. They are path-keyed so they fire whether or not the post
 * exists — deploy first, then run this.
 *
 * Posts are TRASHED, not force-deleted. A full JSON backup of every post and
 * its meta goes to STDOUT on both dry and apply runs; status goes to STDERR.
 * The database is not in this repo and has no undo.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-nonoffice-city-practice.php \
 *       > backup-batch-d.json
 *
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-nonoffice-city-practice.php \
 *       > backup-batch-d.json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/*
 * ID => public path, as one map rather than two parallel arrays — pairing them
 * by index is how batch (b) nearly trashed the wrong pages.
 * Source: url-triage.csv, practice_area rows classified REMOVE under rule 7.
 */
$expect = array(
    5241 => '/car-accident-lawyers/summerville-sc/',
    5242 => '/truck-accident-lawyers/summerville-sc/',
    5243 => '/motorcycle-accident-lawyers/summerville-sc/',
    5244 => '/workers-compensation-lawyers/summerville-sc/',
    5245 => '/personal-injury-lawyers/summerville-sc/',
    5246 => '/car-accident-lawyers/goose-creek-sc/',
    5247 => '/workers-compensation-lawyers/goose-creek-sc/',
    5248 => '/personal-injury-lawyers/goose-creek-sc/',
    5249 => '/slip-and-fall-lawyers/goose-creek-sc/',
    5250 => '/car-accident-lawyers/moncks-corner-sc/',
    5251 => '/truck-accident-lawyers/moncks-corner-sc/',
    5252 => '/car-accident-lawyers/mount-pleasant-sc/',
    5253 => '/personal-injury-lawyers/mount-pleasant-sc/',
    5254 => '/personal-injury-lawyers/hilton-head-sc/',
    5255 => '/car-accident-lawyers/conway-sc/',
    5256 => '/truck-accident-lawyers/conway-sc/',
    5257 => '/personal-injury-lawyers/conway-sc/',
    5258 => '/car-accident-lawyers/north-myrtle-beach-sc/',
    5259 => '/personal-injury-lawyers/pawleys-island-sc/',
    5260 => '/car-accident-lawyers/orangeburg-sc/',
    5261 => '/personal-injury-lawyers/orangeburg-sc/',
    5262 => '/car-accident-lawyers/sumter-sc/',
    5263 => '/car-accident-lawyers/blythewood-sc/',
    5264 => '/car-accident-lawyers/irmo-sc/',
    5265 => '/car-accident-lawyers/spartanburg-sc/',
    5266 => '/truck-accident-lawyers/spartanburg-sc/',
    5267 => '/motorcycle-accident-lawyers/spartanburg-sc/',
    5268 => '/workers-compensation-lawyers/spartanburg-sc/',
    5269 => '/car-accident-lawyers/rock-hill-sc/',
    5270 => '/truck-accident-lawyers/rock-hill-sc/',
    5271 => '/workers-compensation-lawyers/rock-hill-sc/',
    5272 => '/car-accident-lawyers/fort-mill-sc/',
    5273 => '/car-accident-lawyers/greer-sc/',
    5274 => '/car-accident-lawyers/simpsonville-sc/',
);

/* The six markets with a real office. Never touch these. */
$office_slugs = array( 'savannah-ga', 'darien-ga', 'charleston-sc', 'north-charleston-sc', 'columbia-sc', 'myrtle-beach-sc' );

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — Phase 1 batch (d)\n\n", $apply ? 'APPLY' : 'DRY RUN' );

global $wpdb;
$found = array();

foreach ( $expect as $id => $path ) {
    $p = get_post( $id );

    if ( ! $p instanceof WP_Post ) {
        fprintf( $err, "ABORT: ID %d not found.\n", $id );
        exit( 1 );
    }
    if ( 'practice_area' !== $p->post_type ) {
        fprintf( $err, "ABORT: ID %d is post_type '%s', expected 'practice_area'.\n", $id, $p->post_type );
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

    // Guard: the child slug must not be an office market.
    $child = basename( untrailingslashit( $actual ) );
    if ( in_array( $child, $office_slugs, true ) ) {
        fprintf( $err, "ABORT: %s is an office market.\n", $child );
        exit( 1 );
    }

    // Guard: refuse if anything still links here.
    $like = '%' . $wpdb->esc_like( $actual ) . '%';
    $refs = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status='publish' AND ID <> %d AND post_content LIKE %s",
        $id, $like
    ) );
    if ( $refs > 0 ) {
        fprintf( $err, "ABORT: %d published posts still link to %s — strip those first.\n", $refs, $actual );
        exit( 1 );
    }

    $found[] = $p;
}

if ( count( $found ) !== count( $expect ) ) {
    fprintf( $err, "ABORT: resolved %d of %d.\n", count( $found ), count( $expect ) );
    exit( 1 );
}

/* ---- Backup before touching anything ---- */

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'phase1-d-nonoffice-city-practice',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Restore with wp_untrash_post( ID ), or recreate from post + meta below.',
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
    fprintf( $err, "Next: flush caches, then verify the 34 redirects resolve single-hop.\n" );
}
