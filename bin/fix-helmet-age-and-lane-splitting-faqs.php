<?php
/**
 * Two follow-ups from the Charleston motorcycle legal sweep
 * (data/facts/remediation-2026-09-28-charleston-motorcycle.md). Owner,
 * 2026-09-28: "Go ahead on 1 and 2". Both rest on authorities Graeham C. Gillin
 * signed that day (SC 56-5-3660, SC 56-5-3640; internal-ai-scripts #68).
 *
 * 1. "Adult riders" on the SC personal injury FAQ (4814 FAQ 49/50) and its
 *    Spanish twin (4937 FAQ 57/58). § 56-5-3660 runs to 21, not 18; each answer
 *    was conditioned on 21 elsewhere, so imprecise rather than false.
 * 2. /motorcycle-accident-lawyers/lane-splitting-accident/ (4073) FAQ 0: the
 *    uncited "South Carolina has similar prohibitions" and the other-states claim
 *    "Only California explicitly permits lane splitting by statute". The Georgia
 *    sentence is left as it was, for the GA reviewer.
 *
 * All are FAQ answers, so also FAQPage structured data. update_post_meta(
 * wp_slash() ), exact-match once each, one write per post, read back.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-helmet-age-and-lane-splitting-faqs.php > docs/backups/helmet-lane-faqs-2026-09-28.json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-helmet-age-and-lane-splitting-faqs.php > docs/backups/helmet-lane-faqs-2026-09-28.json
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply = isset( $args[0] ) && 'apply' === $args[0];

$faqs = array(
	array( 4814, 49,
		'simply because an adult rider was not wearing a helmet',
		'simply because a rider 21 or older was not wearing a helmet' ),
	array( 4814, 50,
		'since the law does not require a helmet for adult riders.',
		'since South Carolina requires a helmet only for riders under 21 (S.C. Code § 56-5-3660).' ),
	array( 4937, 57,
		'un motociclista adulto no llevara casco',
		'un motociclista de 21 años o más no llevara casco' ),
	array( 4937, 58,
		'porque la ley no exige casco para los motociclistas adultos.',
		'porque Carolina del Sur exige casco únicamente a los menores de 21 años (S.C. Code § 56-5-3660).' ),
	array( 4073, 0,
		'South Carolina has similar prohibitions. Only California explicitly permits lane splitting by statute.',
		'South Carolina law likewise prohibits riding between lanes of traffic or between adjacent rows of vehicles (S.C. Code § 56-5-3640).' ),
);

$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'helmet-lane-faqs', 'mode' => $apply ? 'apply' : 'dry-run', 'faqs' => array() );

$by_post = array();
foreach ( $faqs as $f ) {
	$by_post[ $f[0] ][] = $f;
}
foreach ( $by_post as $id => $list ) {
	if ( 'publish' !== get_post_status( $id ) ) {
		fwrite( STDERR, "ABORT: {$id} is not published.\n" );
		exit( 1 );
	}
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
fwrite( STDERR, sprintf( "\n%s: %d FAQ answers across %d posts\n", $apply ? 'Fixed' : 'Would fix', count( $faqs ), count( $by_post ) ) );
