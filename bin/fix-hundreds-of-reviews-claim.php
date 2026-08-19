<?php
/**
 * Remove the "hundreds of client reviews" claim from published content.
 *
 * PR #33 corrected this figure in two places: it gated the schema
 * AggregateRating behind RODEN_MIN_AGGREGATE_REVIEWS, and it made
 * trust_stats['reviews'] derive from the live per-office Google Business
 * Profile sum instead of the hand-written "Hundreds of 5-Star Reviews".
 *
 * It did not reach the prose. The claim is hand-typed into published post
 * bodies, FAQ answers and Why Hire blocks across the site, where no derivation
 * can correct it. Live GBP totals, verified 2026-08-19:
 *
 *     Savannah 59 · Darien 0 · Charleston 105 · North Charleston 2
 *     Columbia 2 · Myrtle Beach 2   =   170 total
 *
 * 170 is not "hundreds". The claim is false as published, and it is false in
 * FAQ answers that feed FAQPage schema — so it is machine-readable and
 * quotable, which is how the review-count problem became visible in the first
 * place.
 *
 * WHAT IS NOT CHANGED, and why:
 *
 *   The 4.9 rating stays. It is accurate: weighting each office's own rating by
 *   its own review count gives 4.903 across the 170. Removing a true statement
 *   alongside a false one would be its own kind of sloppiness.
 *
 *   No replacement number is written in. Substituting "170+" would fix today's
 *   sentence and recreate exactly the drift this is cleaning up — the counts
 *   move every month, and 123 hand-typed figures cannot track them. The count
 *   claim is removed outright and the accurate rating carries the sentence.
 *
 *   _roden_key_takeaways is untouched. Two Spanish posts there say "cientos de
 *   miles de dolares" — hundreds of thousands of DOLLARS, about settlement
 *   values, not reviews. The patterns below target "reseñas"/"reviews"
 *   specifically so those cannot be caught.
 *
 * Anything that matches the detector but none of the rewrite patterns is
 * REPORTED, never guessed at. A sentence shape this script does not recognise
 * is left alone for a human.
 *
 * Run from the repo over stdin — never added to the theme:
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/fix-hundreds-of-reviews-claim.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/fix-hundreds-of-reviews-claim.php
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

global $wpdb;
$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ── Sanity-check the premise before rewriting anything ─────────────────── */

$firm  = roden_firm_data();
$total = 0;
$weighted = 0.0;
foreach ( $firm['offices'] as $o ) {
	$c = (int) $o['review_count'];
	$total += $c;
	if ( $c > 0 && '' !== $o['review_rating'] ) {
		$weighted += $c * (float) $o['review_rating'];
	}
}
$avg = $total ? round( $weighted / $total, 2 ) : 0;
printf( "live GBP total: %d reviews, weighted average %.2f stars\n", $total, $avg );
if ( $total >= 200 ) {
	printf( "ABORT  the total is now %d — \"hundreds\" may be defensible. Re-check before running.\n", $total );
	exit( 1 );
}
printf( "%d is not \"hundreds\" — proceeding to remove the count claim, keeping the rating.\n\n", $total );

/* ── Patterns ───────────────────────────────────────────────────────────── */

// Detects a review-COUNT claim. Deliberately does not match a bare "4.9".
$detect = '/hundreds of (?:client |verified |google )*reviews|cientos de rese\x{00F1}as|cientos de opiniones/iu';

/*
 * The claim spans HTML markup, in at least three shapes:
 *   holds a <strong>4.9-star average from hundreds of client reviews</strong>.
 *   and a <strong>4.9-star rating</strong> from hundreds of client reviews,
 *   and a <strong>4.9-star average rating</strong> from hundreds of reviews,
 *
 * A plain-text pattern matches none of them — the first attempt at this script
 * caught 14 of 123 bodies for exactly that reason. GAP below allows tags and
 * entities between words, and the callback refuses to touch any span whose
 * tags are not internally balanced, so a rewrite can never leave broken markup.
 */
define( 'RODEN_GAP', '(?:<[^>]*>|\s|&nbsp;)*' );
define( 'RODEN_GAP1', '(?:<[^>]*>|\s|&nbsp;)+' );

/**
 * Rebuild a matched span as an accurate phrase, preserving tag balance.
 * Returns the span untouched when its markup is unbalanced.
 */
function roden_reviews_callback( $m, $plain, $bold ) {
	$span   = $m[0];
	$opens  = preg_match_all( '/<[a-z][^>]*>/i', $span );
	$closes = preg_match_all( '/<\/[a-z]+>/i', $span );
	if ( $opens !== $closes ) {
		return $span; // leave it for a human rather than emit broken markup
	}
	return $opens > 0 ? $bold : $plain;
}

$G  = RODEN_GAP;
$G1 = RODEN_GAP1;

$callbacks = array(
	// "a 4.9-star [average] [rating] from|across|in hundreds of [client] reviews"
	'/\ba' . $G1 . '4\.9-star' . $G . '(?:average' . $G . ')?(?:rating' . $G . ')?(?:from|across|in)' . $G
		. '(?:(?:more than|over)' . $G1 . ')?hundreds' . $G . 'of' . $G . '(?:(?:client|verified|google)' . $G . ')*reviews(?:<\/[a-z]+>)*/iu'
		=> array( 'a 4.9-star average client rating', 'a <strong>4.9-star average client rating</strong>' ),

	// "4.9 stars from hundreds of client reviews"
	'/\b4\.9' . $G1 . 'stars?' . $G . '(?:from|across|in)' . $G . '(?:(?:more than|over)' . $G1 . ')?hundreds' . $G . 'of' . $G
		. '(?:(?:client|verified|google)' . $G . ')*reviews(?:<\/[a-z]+>)*/iu'
		=> array( '4.9 stars on average', '<strong>4.9 stars on average</strong>' ),

	// Spanish: "promedio de 4.9 estrellas con|en|y cientos de reseñas [de clientes]"
	'/promedio' . $G1 . 'de' . $G1 . '4\.9' . $G1 . 'estrellas' . $G . '(?:,' . $G . ')?(?:con|en|y|sobre)' . $G1
		. 'cientos' . $G1 . 'de' . $G1 . 'rese\x{00F1}as(?:' . $G1 . 'de' . $G1 . 'clientes)?(?:<\/[a-z]+>)*/iu'
		=> array( 'promedio de 4.9 estrellas', 'promedio de <strong>4.9 estrellas</strong>' ),

	// Spanish: "4.9 estrellas y cientos de reseñas de clientes"
	'/4\.9' . $G1 . 'estrellas' . $G . '(?:,' . $G . ')?y' . $G1 . 'cientos' . $G1 . 'de' . $G1
		. 'rese\x{00F1}as(?:' . $G1 . 'de' . $G1 . 'clientes)?(?:<\/[a-z]+>)*/iu'
		=> array( '4.9 estrellas', '<strong>4.9 estrellas</strong>' ),
);

$meta_keys = array( '_roden_why_hire', '_roden_hero_intro', '_roden_meta_description', '_roden_expert_quote' );

/**
 * Apply the rewrites to a string; returns array( $new, $changed, $leftover ).
 */
function roden_fix_reviews( $text, $callbacks, $detect ) {
	if ( ! is_string( $text ) || '' === $text ) {
		return array( $text, false, false );
	}
	if ( ! preg_match( $detect, $text ) ) {
		return array( $text, false, false );
	}
	$new = $text;
	foreach ( $callbacks as $pat => $forms ) {
		list( $plain, $bold ) = $forms;
		$new = preg_replace_callback(
			$pat,
			function ( $m ) use ( $plain, $bold ) {
				return roden_reviews_callback( $m, $plain, $bold );
			},
			$new
		);
	}
	$leftover = (bool) preg_match( $detect, $new );
	return array( $new, $new !== $text, $leftover );
}

/* ── Sweep ──────────────────────────────────────────────────────────────── */

$posts = $wpdb->get_results( "SELECT ID, post_type, post_title, post_content, post_excerpt FROM {$wpdb->posts} WHERE post_status = 'publish'" );

$stats    = array( 'body' => 0, 'excerpt' => 0, 'faqs' => 0, 'meta' => 0 );
$touched  = array();
$unmatched = array();

foreach ( $posts as $p ) {
	$post_changed = false;
	$updates      = array();

	list( $body, $changed, $left ) = roden_fix_reviews( $p->post_content, $callbacks, $detect );
	if ( $changed ) { $updates['post_content'] = $body; $stats['body']++; $post_changed = true; }
	if ( $left )    { $unmatched[] = sprintf( '#%d post_content', $p->ID ); }

	list( $exc, $changed, $left ) = roden_fix_reviews( $p->post_excerpt, $callbacks, $detect );
	if ( $changed ) { $updates['post_excerpt'] = $exc; $stats['excerpt']++; $post_changed = true; }
	if ( $left )    { $unmatched[] = sprintf( '#%d post_excerpt', $p->ID ); }

	// Scalar meta
	$meta_updates = array();
	foreach ( $meta_keys as $k ) {
		$v = get_post_meta( $p->ID, $k, true );
		list( $nv, $changed, $left ) = roden_fix_reviews( $v, $callbacks, $detect );
		if ( $changed ) { $meta_updates[ $k ] = $nv; $stats['meta']++; $post_changed = true; }
		if ( $left )    { $unmatched[] = sprintf( '#%d %s', $p->ID, $k ); }
	}

	// FAQs — array of question/answer pairs, feeds FAQPage schema
	$faqs     = get_post_meta( $p->ID, '_roden_faqs', true );
	$faq_new  = $faqs;
	$faq_hit  = false;
	if ( is_array( $faqs ) ) {
		foreach ( $faqs as $i => $f ) {
			foreach ( array( 'question', 'answer' ) as $part ) {
				if ( ! isset( $f[ $part ] ) ) { continue; }
				list( $nv, $changed, $left ) = roden_fix_reviews( $f[ $part ], $callbacks, $detect );
				if ( $changed ) { $faq_new[ $i ][ $part ] = $nv; $faq_hit = true; }
				if ( $left )    { $unmatched[] = sprintf( '#%d _roden_faqs[%d].%s', $p->ID, $i, $part ); }
			}
		}
	}
	if ( $faq_hit ) { $stats['faqs']++; $post_changed = true; }

	if ( ! $post_changed ) { continue; }
	$touched[] = $p->ID;

	if ( ! $apply ) { continue; }

	if ( $updates ) {
		$res = wp_update_post( array_merge( array( 'ID' => $p->ID ), $updates ), true );
		if ( is_wp_error( $res ) ) {
			printf( "  ERROR #%d %s\n", $p->ID, $res->get_error_message() );
			continue;
		}
	}
	foreach ( $meta_updates as $k => $v ) { update_post_meta( $p->ID, $k, $v ); }
	if ( $faq_hit ) { update_post_meta( $p->ID, '_roden_faqs', $faq_new ); }
}

printf( "%s\n", str_repeat( '-', 74 ) );
printf( "posts %s : %d\n", $apply ? 'changed' : 'to change', count( $touched ) );
printf( "  post_content : %d\n", $stats['body'] );
printf( "  post_excerpt : %d\n", $stats['excerpt'] );
printf( "  _roden_faqs  : %d\n", $stats['faqs'] );
printf( "  scalar meta  : %d\n", $stats['meta'] );

if ( $unmatched ) {
	printf( "\nUNMATCHED — detector fired but no rewrite applied, left for a human (%d):\n", count( $unmatched ) );
	foreach ( array_slice( $unmatched, 0, 40 ) as $u ) { printf( "  %s\n", $u ); }
	if ( count( $unmatched ) > 40 ) { printf( "  ... and %d more\n", count( $unmatched ) - 40 ); }
}

if ( $apply ) {
	// Independent re-scan of the whole site.
	$left_body = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_status='publish'
		AND (post_content REGEXP 'hundreds of (client |verified |google )*reviews'
		  OR post_content LIKE '%cientos de rese%')" );
	printf( "\nre-scan: published posts still asserting a review count in the body: %d\n", count( $left_body ) );
	if ( $left_body ) { printf( "  %s\n", implode( ', ', array_slice( $left_body, 0, 20 ) ) ); }
	printf( "\nNext: wp cache flush && wp page-cache flush.\n" );
	printf( "Note: the 4.9 rating remains hand-typed across the site and is accurate today (%.2f).\n", $avg );
	printf( "It will drift the same way the counts did. Deriving it from firm-data is the real fix.\n" );
} else {
	printf( "\nDry run. Re-run with `apply` to write.\n" );
}
