<?php
/**
 * Correct _roden_last_reviewed values that predate the post they describe, and
 * report the class site-wide.
 *
 *   ssh $H "wp --path=... eval-file -"       < bin/fix-lastreviewed-before-publish.php
 *   ssh $H "wp --path=... eval-file - apply" < bin/fix-lastreviewed-before-publish.php
 *
 * WHY THIS MATTERS. `_roden_last_reviewed` publishes as `lastReviewed` on the
 * WebPage node (inc/schema-helpers.php, shipped in #85). It is a claim that a
 * named attorney read the page on a given date. A value EARLIER than the post's
 * own creation date cannot be true — the content did not exist to be read — so
 * it is a freshness signal asserting something that did not happen, which is the
 * exact failure inc/schema-helpers.php warns against and which
 * bin/seed-corridor-report.php refuses to manufacture at seed time.
 *
 * Found on post 5398, seeded and published 2026-09-01 carrying a review date of
 * 2026-08-31.
 *
 * WHAT IT SETS. The post's own publish date, not today's. That is the earliest
 * date on which a review could have happened, and it is the only defensible
 * value available from data: a later date would be a guess about when a human
 * read something, and inventing that is the thing being corrected. Where the
 * real review happened later, an editor should set the true date — this only
 * removes the impossible claim.
 *
 * Posts with no _roden_last_reviewed are NOT given one. An absent signal is
 * honest; a fabricated one is not.
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (pass 'apply' to write) ===\n\n";

$rows = get_posts( array(
    'post_type'   => array( 'post', 'page', 'resource', 'practice_area', 'location' ),
    'post_status' => 'publish',
    'numberposts' => -1,
    'fields'      => 'ids',
) );

$with     = 0;
$bad      = array();
$backups  = array();

foreach ( $rows as $id ) {
    $reviewed = trim( (string) get_post_meta( $id, '_roden_last_reviewed', true ) );
    if ( '' === $reviewed ) {
        continue;
    }
    $with++;

    $post_day = substr( get_post( $id )->post_date, 0, 10 );
    $rev_day  = substr( $reviewed, 0, 10 );

    // String compare is safe on Y-m-d and avoids timezone drift from strtotime.
    if ( $rev_day >= $post_day ) {
        continue;
    }

    $bad[ $id ] = array( 'url' => get_permalink( $id ), 'reviewed' => $rev_day, 'published' => $post_day );
}

printf( "published posts carrying _roden_last_reviewed : %d\n", $with );
printf( "review date EARLIER than publish date         : %d\n\n", count( $bad ) );

foreach ( $bad as $id => $b ) {
    printf( "  [%d] %s\n       reviewed %s < published %s\n", $id, $b['url'], $b['reviewed'], $b['published'] );
}

if ( ! $bad ) {
    echo "\nNothing to correct.\n";
    return;
}
if ( ! $apply ) {
    echo "\nDry run. Re-run with 'apply' to set each to its publish date.\n";
    return;
}

foreach ( $bad as $id => $b ) {
    $backups[ $id ] = array( 'url' => $b['url'], '_roden_last_reviewed' => $b['reviewed'] );
    update_post_meta( $id, '_roden_last_reviewed', $b['published'] );
    clean_post_cache( $id );
    printf( "  set %d: %s -> %s\n", $id, $b['reviewed'], $b['published'] );
}

echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\n";

echo "\n--- VERIFY ---\n";
$still = 0;
foreach ( array_keys( $bad ) as $id ) {
    $r = substr( (string) get_post_meta( $id, '_roden_last_reviewed', true ), 0, 10 );
    $p = substr( get_post( $id )->post_date, 0, 10 );
    printf( "  [%d] reviewed %s vs published %s : %s\n", $id, $r, $p, ( $r >= $p ? 'ok' : 'STILL BAD' ) );
    if ( $r < $p ) { $still++; }
}
printf( "\n%d remaining incoherent.\nDone.\n", $still );
