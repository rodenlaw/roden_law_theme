<?php
/**
 * Clear the seeder's self-stamped review date on Study #1 (post 5348,
 * /resources/i-26-i-95-corridor-report/).
 *
 * _roden_last_reviewed = 2026-08-25 was written at publish by the seeder, not by
 * an attorney's read, yet it renders a visible "Last reviewed" line and schema
 * lastReviewed. Owner decision 2026-10-23: remove it until Joshua Dorminy (GA)
 * and Graeham C. Gillin (SC) have actually read the page; set it then.
 *
 * Exact-match guard: deletes only if the post is the corridor report and the
 * meta holds exactly one value, '2026-08-25'. Anything else aborts untouched.
 * delete_post_meta() does not move post_modified.
 *
 * Usage (dry run by default; APPLY=1 to write):
 *   ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file -" < bin/clear-self-stamped-review-5348.php
 *   ssh $H "APPLY=1 wp --path=/home/wpe-user/sites/rodenlawprod eval-file -" < bin/clear-self-stamped-review-5348.php
 */

$post_id  = 5348;
$key      = '_roden_last_reviewed';
$expected = '2026-08-25';
$apply    = '1' === getenv( 'APPLY' );

$p = get_post( $post_id );
if ( ! $p || 'resource' !== $p->post_type || 'i-26-i-95-corridor-report' !== $p->post_name ) {
	fwrite( STDERR, "ABORT: post $post_id is not the corridor report\n" );
	exit( 1 );
}

$vals = get_post_meta( $post_id, $key, false );
if ( array( $expected ) !== $vals ) {
	fwrite( STDERR, 'ABORT: ' . $key . ' is ' . wp_json_encode( $vals ) . ", expected [\"$expected\"]\n" );
	exit( 1 );
}

$modified_before = $p->post_modified;
echo "post $post_id ($p->post_name): $key = $expected\n";

if ( ! $apply ) {
	echo "DRY RUN: would delete $key. Re-run with APPLY=1.\n";
	exit( 0 );
}

if ( ! delete_post_meta( $post_id, $key, $expected ) ) {
	fwrite( STDERR, "FAIL: delete_post_meta returned false\n" );
	exit( 1 );
}
clean_post_cache( $post_id );

$after    = get_post_meta( $post_id, $key, false );
$modified = get_post( $post_id )->post_modified;
echo 'after: ' . $key . ' = ' . wp_json_encode( $after ) . "; post_modified $modified_before -> $modified\n";
exit( array() === $after ? 0 : 1 );
