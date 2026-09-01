<?php
/**
 * Point /blog/myrtle-beach-dangerous-roads-intersections/ at the published
 * Grand Strand Fatal Crash Report.
 *
 *   ssh $H "wp --path=... eval-file -"       < bin/link-myrtle-beach-report.php
 *   ssh $H "wp --path=... eval-file - apply" < bin/link-myrtle-beach-report.php
 *
 * The correction in 84bd02e sourced the seasonality figures to NHTSA FARS
 * directly, because post 5398 was still a draft and pointing a live page at an
 * unpublished URL would have been a broken link. It is published now, so the
 * citation gets its internal target.
 *
 * The link is placed on the source line inside the seasonality section — the one
 * place on the page where a reader is being asked to accept a number that
 * contradicts what the page used to say. That is where the working is worth
 * showing.
 *
 * Refuses to run if the target is not a published resource, so this cannot
 * silently create a link into a draft or a 404.
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (pass 'apply' to write) ===\n\n";

$target = get_post( 5398 );
if ( ! $target || 'resource' !== $target->post_type ) {
    echo "ABORT: post 5398 is not a resource\n";
    return;
}
if ( 'publish' !== $target->post_status ) {
    echo "ABORT: target is '{$target->post_status}', not published. Not linking into a draft.\n";
    return;
}
$url = wp_make_link_relative( get_permalink( 5398 ) );
printf( "  target: %s (%s)\n", $url, $target->post_status );

$post = get_post( 4537 );
if ( ! $post || 'myrtle-beach-dangerous-roads-intersections' !== $post->post_name ) {
    echo "ABORT: post 4537 is not the Myrtle Beach roads post\n";
    return;
}

$search  = '<em>Source: NHTSA Fatality Analysis Reporting System, 2020–2024.</em>';
$replace = '<em>Source: NHTSA Fatality Analysis Reporting System, 2020–2024 — see our <a href="' . $url . '">Grand Strand Fatal Crash Report</a> for the full analysis, the stated limits, and the crash-level dataset.</em>';

if ( false !== strpos( $post->post_content, $url ) ) {
    echo "  SKIP: page already links to the report\n";
    return;
}
$n = substr_count( $post->post_content, $search );
if ( 1 !== $n ) {
    echo "  FAIL ($n occurrences, expected 1): source line not found verbatim\n";
    return;
}
echo "  ok: source line -> linked citation\n";

if ( ! $apply ) {
    echo "\nDry run complete.\n";
    return;
}

echo "\nBACKUP-JSON: " . wp_json_encode( array( 'post_id' => 4537, 'post_content' => $post->post_content ) ) . "\n";

wp_update_post( array(
    'ID'           => 4537,
    'post_content' => str_replace( $search, $replace, $post->post_content ),
), true );
clean_post_cache( 4537 );

$after = get_post( 4537 );
echo "\n--- VERIFY ---\n";
echo 'link present   : ' . ( false !== strpos( $after->post_content, $url ) ? 'yes' : 'NO' ) . "\n";
echo 'link count     : ' . substr_count( $after->post_content, $url ) . "\n";
echo 'source line kept: ' . ( false !== strpos( $after->post_content, 'NHTSA Fatality Analysis Reporting System' ) ? 'yes' : 'NO' ) . "\n";
echo "\nDone.\n";
