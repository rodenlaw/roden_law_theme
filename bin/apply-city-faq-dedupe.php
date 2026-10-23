<?php
/**
 * Remove FAQ entries that are copied across the city practice-area pages.
 *
 * Payload (injected as RODEN_SEED_JSON by bin/build-city-faq-dedupe.sh):
 *   { "<permalink path>": { "expect": [ {question, answer}, ... ],   // _roden_faqs as the plan saw it
 *                           "remove": [ "<exact question>", ... ] } }
 *
 * WHY THIS EXISTS
 * ---------------
 * The content-similarity baseline (2026-10-23) found the 11 city pages
 * (/car-accident-lawyers/charleston-sc/ and siblings) sharing a median 57% of
 * their text with a sibling once place names are masked. 34 of their 66 FAQ
 * answers are the same answer on 2-5 city pages: the filing deadline, partial
 * fault, the contingency fee, the uninsured driver, who is liable for a truck
 * crash. The page's own state-law box already states the deadline and fault
 * rule, and the parent pillar carries the full FAQ (10-11 questions); the city
 * template links to it (template-intersection.php, same PR). This removes the
 * copies and keeps every FAQ that only one city page carries.
 *
 * Removal only: no answer is written or reworded, so no new claim is published.
 * FAQ answers also render as FAQPage structured data; removing them removes
 * them from both.
 *
 * GUARDS. The write is refused unless the page's current _roden_faqs equals
 * `expect` exactly (a page edited since the plan was built fails closed), every
 * question in `remove` is present exactly once, and the result keeps the
 * remaining entries in their original order. wp_slash() on the write (CLAUDE.md
 * Gotchas). Readback is checked.
 *
 *   bin/build-city-faq-dedupe.sh            # dry run
 *   bin/build-city-faq-dedupe.sh apply      # write; prints a BACKUP block to keep
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}
if ( ! defined( 'RODEN_SEED_JSON' ) ) {
	fwrite( STDERR, "RODEN_SEED_JSON is not defined - run through bin/build-city-faq-dedupe.sh.\n" );
	exit( 1 );
}

$mode = isset( $args[0] ) ? $args[0] : 'dry-run';
if ( ! in_array( $mode, array( 'dry-run', 'apply' ), true ) ) {
	fwrite( STDERR, "Unknown mode '$mode'. Use dry-run | apply.\n" );
	exit( 1 );
}

$payload = json_decode( RODEN_SEED_JSON, true );
if ( ! is_array( $payload ) ) {
	fwrite( STDERR, 'Payload is not valid JSON: ' . json_last_error_msg() . "\n" );
	exit( 1 );
}

echo "mode: $mode\n", str_repeat( '=', 72 ), "\n";
$applied = $failed = 0;
$backup  = array();

foreach ( $payload as $path => $spec ) {
	$expect = isset( $spec['expect'] ) ? $spec['expect'] : null;
	$remove = isset( $spec['remove'] ) ? $spec['remove'] : null;
	if ( ! is_array( $expect ) || ! is_array( $remove ) || ! $remove ) {
		printf( "FAIL  %s\n      malformed entry\n", $path );
		$failed++;
		continue;
	}

	$post_id = url_to_postid( home_url( $path ) );
	$post    = $post_id ? get_post( $post_id ) : null;
	if ( ! $post || 'practice_area' !== $post->post_type || 'publish' !== $post->post_status ) {
		printf( "FAIL  %s\n      does not resolve to a published practice_area\n", $path );
		$failed++;
		continue;
	}
	if ( basename( untrailingslashit( $path ) ) !== $post->post_name ) {
		printf( "FAIL  %s\n      resolved post %d has slug '%s'\n", $path, $post_id, $post->post_name );
		$failed++;
		continue;
	}

	$current = get_post_meta( $post_id, '_roden_faqs', true );
	$norm    = function ( $list ) {
		return array_map( function ( $f ) {
			return array( 'question' => (string) $f['question'], 'answer' => (string) $f['answer'] );
		}, is_array( $list ) ? $list : array() );
	};
	if ( $norm( $current ) !== $norm( $expect ) ) {
		printf( "SKIP  %s\n      _roden_faqs changed since the plan was built - not touching\n", $path );
		$failed++;
		continue;
	}

	$keep  = array();
	$found = array();
	foreach ( $current as $f ) {
		if ( in_array( (string) $f['question'], $remove, true ) ) {
			$found[] = (string) $f['question'];
			continue;
		}
		$keep[] = $f;
	}
	if ( count( $found ) !== count( $remove ) || count( array_unique( $found ) ) !== count( $found ) ) {
		printf( "FAIL  %s\n      remove list does not match exactly once each (%d of %d)\n", $path, count( $found ), count( $remove ) );
		$failed++;
		continue;
	}

	printf( "%s  %s\n      post %d: %d FAQs -> %d (removing %d)\n",
		'apply' === $mode ? 'WRITE' : 'WOULD', $path, $post_id, count( $current ), count( $keep ), count( $found ) );
	foreach ( $found as $q ) {
		echo "        - $q\n";
	}

	if ( 'apply' === $mode ) {
		$backup[ $path ] = array( 'id' => $post_id, '_roden_faqs' => $current );
		if ( $keep ) {
			update_post_meta( $post_id, '_roden_faqs', wp_slash( $keep ) );
		} else {
			delete_post_meta( $post_id, '_roden_faqs' );
		}
		clean_post_cache( $post_id );
		$rb = get_post_meta( $post_id, '_roden_faqs', true );
		if ( $norm( $rb ) !== $norm( $keep ) ) {
			printf( "      !! READBACK MISMATCH - %d entries, expected %d\n", is_array( $rb ) ? count( $rb ) : 0, count( $keep ) );
			$failed++;
			continue;
		}
	}
	$applied++;
}

echo str_repeat( '=', 72 ), "\n";
printf( "%s: %d, failed/skipped: %d\n", 'apply' === $mode ? 'written' : 'would write', $applied, $failed );
if ( 'apply' === $mode && $backup ) {
	echo "BACKUP-JSON-BEGIN\n", wp_json_encode( $backup, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ), "\nBACKUP-JSON-END\n";
}
exit( $failed ? 1 : 0 );
