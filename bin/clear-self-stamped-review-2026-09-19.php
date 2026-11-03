<?php
/**
 * Clear the 2026-09-19 review date on the five reference pages published that day
 * without an attorney's read (helmet GA/SC, golf cart SC, moped GA/SC).
 *
 * Each was commissioned, statute-checked and published on 2026-09-19, and
 * _roden_last_reviewed was set to that date on the owner's word (RECOVERY-LOG,
 * 2026-09-19 entries; build-resource-seed.py also hard-coded it until #307). No
 * attorney review is recorded for any of them: _roden_reviewed_by is empty and
 * none is in the October attorney review. The date renders a visible "Last
 * reviewed" line and schema lastReviewed. Owner decision 2026-11-03: remove it,
 * as on 5348 (2026-10-23), and add the five to the attorney review queue; set
 * the date and reviewer through bin/record-attorney-reviews.php on a real read.
 *
 * Not touched: 5352 and 5353 (the two-state guides), whose 2026-09-19 date
 * records a review the owner confirmed that day.
 *
 * Exact-match guard, per post: right post type and slug, the meta holds exactly
 * one value '2026-09-19', and no _roden_reviewed_by. Any post that fails is
 * reported and the whole run aborts before writing anything.
 * delete_post_meta() does not move post_modified.
 *
 * Usage (dry run by default; APPLY=1 to write):
 *   ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file -" < bin/clear-self-stamped-review-2026-09-19.php
 *   ssh $H "APPLY=1 wp --path=/home/wpe-user/sites/rodenlawprod eval-file -" < bin/clear-self-stamped-review-2026-09-19.php
 */

$targets = array(
	6312 => 'georgia-helmet-laws',
	6313 => 'south-carolina-helmet-laws',
	6314 => 'south-carolina-golf-cart-laws',
	6315 => 'georgia-moped-laws',
	6316 => 'south-carolina-moped-laws',
);
$key      = '_roden_last_reviewed';
$expected = '2026-09-19';
$apply    = '1' === getenv( 'APPLY' );

$problems = array();
$before   = array();
foreach ( $targets as $id => $slug ) {
	$p = get_post( $id );
	if ( ! $p || 'resource' !== $p->post_type || $slug !== $p->post_name ) {
		$problems[] = "post $id is not resource '$slug'";
		continue;
	}
	$vals = get_post_meta( $id, $key, false );
	if ( array( $expected ) !== $vals ) {
		$problems[] = "post $id $key is " . wp_json_encode( $vals ) . ", expected [\"$expected\"]";
	}
	$by = get_post_meta( $id, '_roden_reviewed_by', true );
	if ( '' !== $by && array() !== $by && null !== $by ) {
		$problems[] = "post $id has _roden_reviewed_by " . wp_json_encode( $by ) . ': a recorded review, not touching it';
	}
	$before[ $id ] = array( 'slug' => $slug, 'status' => $p->post_status, $key => $vals, 'post_modified' => $p->post_modified );
}

echo 'before: ' . wp_json_encode( $before ) . "\n";
if ( $problems ) {
	fwrite( STDERR, "ABORT, nothing written:\n  - " . implode( "\n  - ", $problems ) . "\n" );
	exit( 1 );
}
if ( ! $apply ) {
	echo 'DRY RUN: would delete ' . $key . ' on ' . count( $targets ) . " posts. Re-run with APPLY=1.\n";
	exit( 0 );
}

$fail = 0;
foreach ( $targets as $id => $slug ) {
	if ( ! delete_post_meta( $id, $key, $expected ) ) {
		fwrite( STDERR, "FAIL: delete_post_meta on $id returned false\n" );
		$fail++;
		continue;
	}
	clean_post_cache( $id );
	$after = get_post_meta( $id, $key, false );
	printf( "cleared %d %s: %s = %s; post_modified %s -> %s\n", $id, $slug, $key, wp_json_encode( $after ), $before[ $id ]['post_modified'], get_post( $id )->post_modified );
	if ( array() !== $after ) {
		$fail++;
	}
}
exit( $fail ? 1 : 0 );
