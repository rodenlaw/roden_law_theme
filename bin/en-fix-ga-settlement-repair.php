<?php
/**
 * Repair two botched replacements from bin/en-fix-ga-settlement-pages.php.
 *
 * That script used preg_replace with dollar amounts in the REPLACEMENT string.
 * PHP reads "$25" and "$100" there as backreferences (up to two digits), not
 * literals, so "$25,000 and $100,000" was written to the page as ",000 and
 * 0,000". Likewise "$1" in the fourth edit referenced a group that did not
 * exist — the apostrophe class was not parenthesised — so "the firm's" became
 * "the firms".
 *
 * Lesson: never put a dollar amount, or any $, in a preg_replace replacement.
 * This repair uses str_replace only — no pattern language, nothing to interpret.
 *
 * Usage:
 *   ssh <prod> "wp --path=<site> eval-file -"       < bin/en-fix-ga-settlement-repair.php
 *   ssh <prod> "wp --path=<site> eval-file - apply" < bin/en-fix-ga-settlement-repair.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}

$mode = isset( $args[0] ) ? $args[0] : 'dry-run';
if ( ! in_array( $mode, array( 'dry-run', 'apply' ), true ) ) {
	fwrite( STDERR, "Unknown mode '$mode'. Use dry-run | apply.\n" );
	exit( 1 );
}

$car_id   = url_to_postid( home_url( '/resources/georgia-car-accident-settlement-value/' ) );
$truck_id = url_to_postid( home_url( '/resources/georgia-truck-accident-settlement-value/' ) );

$repairs = array(
	array(
		'label' => 'GA car takeaways — restore the dollar amounts',
		'id'    => $car_id,
		'field' => '_roden_key_takeaways',
		'from'  => 'fall between roughly ,000 and 0,000 for moderate injuries',
		'to'    => 'fall between roughly $25,000 and $100,000 for moderate injuries',
	),
	array(
		'label' => 'GA car body — restore the dollar amounts',
		'id'    => $car_id,
		'field' => 'post_content',
		'from'  => 'fall between roughly <strong>,000 and 0,000</strong> for moderate injuries',
		'to'    => 'fall between roughly <strong>$25,000 and $100,000</strong> for moderate injuries',
	),
	array(
		'label' => 'GA truck — restore the apostrophe',
		'id'    => $truck_id,
		'field' => 'post_content',
		'from'  => 'These are the firms own reported figures.',
		'to'    => 'These are the firm\'s own reported figures.',
	),
);

$buffers = array();
$failed  = 0;

foreach ( $repairs as $r ) {
	$key = $r['id'] . '|' . $r['field'];
	if ( ! isset( $buffers[ $key ] ) ) {
		$buffers[ $key ] = array(
			'id'    => $r['id'],
			'field' => $r['field'],
			'value' => ( 'post_content' === $r['field'] )
				? get_post( $r['id'] )->post_content
				: get_post_meta( $r['id'], $r['field'], true ),
		);
	}

	$hits                     = substr_count( $buffers[ $key ]['value'], $r['from'] );
	$buffers[ $key ]['value'] = str_replace( $r['from'], $r['to'], $buffers[ $key ]['value'] );

	if ( 1 !== $hits ) {
		printf( "ABORT  %-46s expected 1 occurrence, found %d\n", $r['label'], $hits );
		$failed++;
	} else {
		printf( "OK     %-46s 1 occurrence\n", $r['label'] );
	}
}

if ( $failed ) {
	printf( "\n%d repair(s) did not match. NOTHING WRITTEN.\n", $failed );
	exit( 1 );
}

if ( 'dry-run' === $mode ) {
	printf( "\nAll %d repairs matched. Dry run — nothing written.\n", count( $repairs ) );
	exit( 0 );
}

foreach ( $buffers as $b ) {
	if ( 'post_content' === $b['field'] ) {
		$res = wp_update_post( array( 'ID' => $b['id'], 'post_content' => $b['value'] ), true );
		if ( is_wp_error( $res ) ) {
			printf( "FAILED post %d: %s\n", $b['id'], $res->get_error_message() );
			exit( 1 );
		}
	} else {
		update_post_meta( $b['id'], $b['field'], $b['value'] );
	}
	printf( "wrote  post %d  %s\n", $b['id'], $b['field'] );
}
printf( "\nRepaired %d strings.\n", count( $repairs ) );
