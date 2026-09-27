<?php
/**
 * Georgia workers' comp deadline errors in two live posts, found by the Savannah
 * workers' comp legal sweep (data/facts/remediation-2026-09-26-savannah-wc.md,
 * L1/L2). Owner, 2026-09-26: "those have been reviewed. fix them now" (Eric Roden).
 *
 * - 1809 FAQ 0 and body: "Employees usually have 10 days to make a report";
 *   O.C.G.A. § 34-9-80 requires notice within 30 days (GA 34-9-80).
 * - 1809 FAQ 4 and 1808 FAQ 2 (both also FAQPage structured data): the claim
 *   deadline given as a flat "one year from the date of the accident"; § 34-9-82
 *   also runs from the last employer-furnished treatment and the last weekly
 *   benefit payment (GA 34-9-82).
 *
 * Not changed: 1809 FAQ 1 (the employer's First Report "within 10 days"), which
 * the sweep could not verify and is outside this review.
 *
 * Body: direct column write (no post_modified stamp). FAQs: update_post_meta(
 * wp_slash() ). Exact-match, once each; every write read back.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-ga-wc-posts.php > docs/backups/ga-wc-posts-2026-09-26.json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-ga-wc-posts.php > docs/backups/ga-wc-posts-2026-09-26.json
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply = isset( $args[0] ) && 'apply' === $args[0];
global $wpdb;

$flat_from = "Georgia allows one year from the date of the accident to file a workers' compensation claim (O.C.G.A. § 34-9-82).";
$flat_to   = "Georgia generally allows one year from the date of the accident to file a workers' compensation claim, or one year from the last medical treatment your employer paid for, or two years from the last weekly benefit payment (O.C.G.A. § 34-9-82).";

$bodies = array(
	array( 1809,
		'Employees usually have 10 days to make a report, but it is best to do so immediately.',
		'Georgia law requires you to give notice within 30 days of the accident (O.C.G.A. § 34-9-80), but it is best to do so immediately.' ),
);

$faqs = array(
	array( 1809, 0,
		'Employees usually have 10 days to make a report, but doing it immediately protects the claim far better than waiting does.',
		'Georgia law requires notice within 30 days of the accident (O.C.G.A. § 34-9-80), but doing it immediately protects the claim far better than waiting does.' ),
	array( 1809, 4, $flat_from, $flat_to ),
	array( 1808, 2, $flat_from, $flat_to ),
);

$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'ga-wc-posts', 'mode' => $apply ? 'apply' : 'dry-run', 'bodies' => array(), 'faqs' => array() );

foreach ( $bodies as $b ) {
	list( $id, $from, $to ) = $b;
	$before = (string) $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d AND post_status = 'publish'", $id ) );
	if ( 1 !== substr_count( $before, $from ) ) {
		fwrite( STDERR, "ABORT: {$id} body does not contain the sentence exactly once.\n" );
		exit( 1 );
	}
	$after              = str_replace( $from, $to, $before );
	$backup['bodies'][] = array( 'ID' => $id, 'body_before' => $before, 'body_after' => $after );
	fwrite( STDERR, sprintf( "  %s %d body\n", $apply ? 'fixed' : 'would fix', $id ) );
	if ( $apply ) {
		$wpdb->update( $wpdb->posts, array( 'post_content' => $after ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
		if ( (string) $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) ) !== $after ) {
			fwrite( STDERR, "FAILED: body read-back mismatch on {$id}\n" );
			exit( 1 );
		}
		clean_post_cache( $id );
	}
}

// Accumulate per post, write once (a post can carry several FAQ fixes).
$by_post = array();
foreach ( $faqs as $f ) {
	$by_post[ $f[0] ][] = $f;
}
foreach ( $by_post as $id => $list ) {
	$before = get_post_meta( $id, '_roden_faqs', true );
	$after  = $before;
	foreach ( $list as $f ) {
		list( , $idx, $from, $to ) = $f;
		if ( ! is_array( $after ) || ! isset( $after[ $idx ]['answer'] ) || 1 !== substr_count( $after[ $idx ]['answer'], $from ) ) {
			fwrite( STDERR, "ABORT: {$id} _roden_faqs[{$idx}] does not contain the sentence exactly once.\n" );
			exit( 1 );
		}
		$after[ $idx ]['answer'] = str_replace( $from, $to, $after[ $idx ]['answer'] );
		fwrite( STDERR, sprintf( "  %s %d _roden_faqs[%d]\n", $apply ? 'fixed' : 'would fix', $id, $idx ) );
	}
	$backup['faqs'][] = array( 'ID' => $id, 'faqs_before' => $before, 'faqs_after' => $after );
	if ( $apply ) {
		update_post_meta( $id, '_roden_faqs', wp_slash( $after ) );
		wp_cache_delete( $id, 'post_meta' );
		if ( get_post_meta( $id, '_roden_faqs', true ) !== $after ) {
			fwrite( STDERR, "FAILED: FAQ read-back mismatch on {$id}\n" );
			exit( 1 );
		}
		clean_post_cache( $id );
	}
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fwrite( STDERR, sprintf( "\n%s: %d body, %d FAQ answers\n", $apply ? 'Fixed' : 'Would fix', count( $bodies ), count( $faqs ) ) );
