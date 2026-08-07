<?php
/**
 * Freshness-signal coverage report.
 *
 * `_roden_last_reviewed` is the firm's own answer to "when did an attorney last
 * check this page?" It licenses `reviewedBy` in schema and, since #28, renders
 * visibly. What it is NOT is something to backfill: setting it asserts a review
 * happened, and schema-helpers.php is explicit that "asserting a review that may
 * not have happened is not a trust signal worth manufacturing."
 *
 * So the field will always lag, and the useful thing is to MEASURE the lag
 * rather than close it artificially. Run this before and after a review sprint.
 *
 * Reports three things:
 *   1. Coverage by post type, split EN/ES.
 *   2. The E-E-A-T gap — pages showing an attorney byline with no review on
 *      record. That mismatch is the actual defect, not the empty field.
 *   3. Reviews going stale — pages whose review date is older than the
 *      threshold, which need RE-review, not a first one.
 *
 *   ssh <prod> "wp --path=<site> eval-file -" < bin/report-freshness-coverage.php
 *   ssh <prod> "wp --path=<site> eval-file - 365" < bin/...   # custom stale threshold
 *
 * Read-only. Writes nothing.
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}

$stale_days = isset( $args[0] ) ? max( 1, (int) $args[0] ) : 180;
$types      = array( 'post', 'resource', 'practice_area', 'location', 'page' );
$now        = time();

printf( "Freshness coverage — %s   (stale threshold: %d days)\n", gmdate( 'Y-m-d' ), $stale_days );
echo str_repeat( '=', 78 ) . "\n\n";
printf( "%-15s %7s %7s %9s %9s %9s\n", 'type', 'total', 'has', 'missing', 'byline-gap', 'stale' );
echo str_repeat( '-', 78 ) . "\n";

$tot = $has = $miss = $gap = $stale = 0;
$stale_list = array();
$gap_list   = array();

foreach ( $types as $t ) {
	$ids = get_posts( array(
		'post_type'   => $t,
		'post_status' => 'publish',
		'numberposts' => -1,
		'fields'      => 'ids',
	) );

	$t_has = $t_miss = $t_gap = $t_stale = 0;

	foreach ( $ids as $id ) {
		$rev = trim( (string) get_post_meta( $id, '_roden_last_reviewed', true ) );
		if ( '' === $rev ) {
			$t_miss++;
			// A byline with no review is the mismatch worth surfacing: the page
			// already tells the reader an attorney stands behind it.
			if ( get_post_meta( $id, '_roden_author_attorney', true ) ) {
				$t_gap++;
				$gap_list[] = $id;
			}
			continue;
		}
		$t_has++;
		$ts = strtotime( $rev );
		if ( $ts && ( $now - $ts ) > ( $stale_days * DAY_IN_SECONDS ) ) {
			$t_stale++;
			$stale_list[] = array( $id, $rev, (int) floor( ( $now - $ts ) / DAY_IN_SECONDS ) );
		}
	}

	printf( "%-15s %7d %7d %9d %9d %9d\n", $t, count( $ids ), $t_has, $t_miss, $t_gap, $t_stale );
	$tot   += count( $ids );
	$has   += $t_has;
	$miss  += $t_miss;
	$gap   += $t_gap;
	$stale += $t_stale;
}

echo str_repeat( '-', 78 ) . "\n";
printf( "%-15s %7d %7d %9d %9d %9d\n", 'TOTAL', $tot, $has, $miss, $gap, $stale );
printf( "\ncoverage: %.1f%% (%d of %d)\n", $tot ? ( $has / $tot ) * 100 : 0, $has, $tot );

echo "\n" . str_repeat( '=', 78 ) . "\n";
echo "E-E-A-T GAP — attorney byline shown, no review on record\n";
printf( "  %d pages. These are the ones that read as reviewed and are not.\n", $gap );

echo "\n" . str_repeat( '=', 78 ) . "\n";
printf( "REVIEWS GOING STALE — older than %d days\n", $stale_days );
if ( ! $stale_list ) {
	echo "  none\n";
} else {
	usort( $stale_list, function ( $a, $b ) { return $b[2] - $a[2]; } );
	foreach ( array_slice( $stale_list, 0, 25 ) as $s ) {
		printf( "  %4d days  %s  #%d  %s\n", $s[2], $s[1], $s[0], wp_make_link_relative( get_permalink( $s[0] ) ) );
	}
	if ( count( $stale_list ) > 25 ) {
		printf( "  … and %d more\n", count( $stale_list ) - 25 );
	}
}
