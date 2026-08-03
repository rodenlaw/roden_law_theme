<?php
/**
 * Append Spanish FAQs to existing Spanish posts.
 *
 * WHY THIS EXISTS
 * ---------------
 * The Spanish silo shipped with roughly half the FAQ depth of its English
 * counterpart — 372 questions against 625 across the 77 paired pages, and the
 * SC personal-injury hub sat at 22 against 95. `_roden_faqs` feeds the FAQPage
 * schema, so that gap is a direct loss of AI-answer surface in Spanish.
 *
 * WHAT IT DOES
 * ------------
 * APPENDS to `_roden_faqs`; it never rewrites what is already published, so a
 * partial run can be resumed and a re-run is a no-op. Questions already present
 * on the post (compared on a normalised form — case, accents and punctuation
 * folded) are skipped rather than duplicated, which is the failure mode when a
 * writer re-adapts an English FAQ that was already translated.
 *
 * It also refuses to write a FAQ set that would exceed the English twin's
 * count. Parity is the goal; overshooting means the writer invented questions,
 * and invented legal Q&A is the thing this whole silo cannot afford.
 *
 * PAYLOAD
 * -------
 * Expects RODEN_FAQ_JSON, keyed by the ES permalink path:
 *
 *   { "/es/practice-areas/car-accident-lawyers/": [ {"question": "...",
 *       "answer": "..."}, ... ], ... }
 *
 * Build it with bin/es-build-seed.sh, which prepends the payload and leaves PHP
 * mode open (it defines RODEN_SEED_JSON; this script accepts either name).
 *
 * Modes: dry-run (default) | apply.
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}

$raw = null;
if ( defined( 'RODEN_FAQ_JSON' ) ) {
	$raw = RODEN_FAQ_JSON;
} elseif ( defined( 'RODEN_SEED_JSON' ) ) {
	$raw = RODEN_SEED_JSON;
}
if ( null === $raw ) {
	fwrite( STDERR, "Define RODEN_FAQ_JSON (or RODEN_SEED_JSON) — see bin/es-build-seed.sh.\n" );
	exit( 1 );
}

$mode = isset( $args[0] ) ? $args[0] : 'dry-run';
if ( ! in_array( $mode, array( 'dry-run', 'apply' ), true ) ) {
	fwrite( STDERR, "Unknown mode '$mode'. Use dry-run | apply.\n" );
	exit( 1 );
}

$payload = json_decode( $raw, true );
if ( ! is_array( $payload ) ) {
	fwrite( STDERR, 'Payload is not valid JSON: ' . json_last_error_msg() . "\n" );
	exit( 1 );
}

/** Fold case, accents and punctuation so "¿Cuánto cuesta?" matches "cuanto cuesta". */
$norm = function ( $s ) {
	$s = mb_strtolower( (string) $s, 'UTF-8' );
	$s = strtr(
		$s,
		array(
			'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
			'ü' => 'u', 'ñ' => 'n',
		)
	);
	return trim( preg_replace( '/[^a-z0-9 ]+/', '', $s ) );
};

$added_total = 0;
$pages       = 0;
$errors      = 0;

foreach ( $payload as $es_path => $new_faqs ) {
	$es_id = url_to_postid( home_url( $es_path ) );
	if ( ! $es_id ) {
		printf( "ERROR  %-58s ES post not found\n", $es_path );
		$errors++;
		continue;
	}
	if ( 'es' !== get_post_meta( $es_id, '_roden_locale', true ) ) {
		printf( "ERROR  %-58s not a Spanish post\n", $es_path );
		$errors++;
		continue;
	}

	$existing = get_post_meta( $es_id, '_roden_faqs', true );
	$existing = is_array( $existing ) ? $existing : array();

	// Cap at the English twin's count — never exceed parity.
	$en_id  = (int) get_post_meta( $es_id, '_roden_translation_of', true );
	$en_faq = $en_id ? get_post_meta( $en_id, '_roden_faqs', true ) : array();
	$cap    = is_array( $en_faq ) ? count( $en_faq ) : 0;

	$seen = array();
	foreach ( $existing as $f ) {
		$seen[ $norm( $f['question'] ) ] = true;
	}

	$added = array();
	$dupes = 0;
	foreach ( $new_faqs as $f ) {
		if ( empty( $f['question'] ) || empty( $f['answer'] ) ) {
			continue;
		}
		$k = $norm( $f['question'] );
		if ( isset( $seen[ $k ] ) ) {
			$dupes++;
			continue;
		}
		$seen[ $k ] = true;
		$added[]    = array( 'question' => $f['question'], 'answer' => $f['answer'] );
	}

	$final = array_merge( $existing, $added );
	if ( $cap && count( $final ) > $cap ) {
		printf(
			"ERROR  %-58s would reach %d FAQs, English twin has %d — refusing to exceed parity\n",
			$es_path,
			count( $final ),
			$cap
		);
		$errors++;
		continue;
	}

	printf(
		"%s %-58s %d -> %d (of %d EN)%s\n",
		( 'apply' === $mode ? 'UPDATE' : 'WOULD ' ),
		$es_path,
		count( $existing ),
		count( $final ),
		$cap,
		$dupes ? sprintf( '  [%d dupes skipped]', $dupes ) : ''
	);

	if ( 'apply' === $mode && $added ) {
		update_post_meta( $es_id, '_roden_faqs', $final );
		update_post_meta( $es_id, '_roden_last_reviewed', gmdate( 'Y-m-d' ) );
	}

	$added_total += count( $added );
	$pages++;
}

printf(
	"\nmode=%s  pages=%d  FAQs %s=%d  errors=%d\n",
	$mode,
	$pages,
	( 'apply' === $mode ? 'added' : 'would add' ),
	$added_total,
	$errors
);
if ( 'apply' === $mode && $added_total ) {
	echo "Then: wp cache flush && wp page-cache flush, and regenerate content/meta.json.\n";
}
