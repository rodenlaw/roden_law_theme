<?php
/**
 * Remove the stale "$575 per week" Georgia TTD maximum from two blog posts.
 *
 * WHAT IS WRONG
 * -------------
 * Two posts state a hard maximum weekly temporary-total-disability benefit of
 * $575, as though it were a fixed feature of Georgia law:
 *
 *   1801  "...pay two-thirds of your average weekly wage, not exceeding $575 per week"
 *   1801  "...but cannot exceed $575."
 *   1841  "...up to two-thirds of your average weekly earnings, up to $575 a week"
 *
 * It is not fixed. O.C.G.A. § 34-9-261 sets a maximum that the General Assembly
 * raises periodically, and the figure that governs a claim is the one in effect
 * on the DATE OF INJURY. The Board's own published summary
 * (sbwc.georgia.gov/document/publication/provisionspdf, PDF dated 2025-07-15)
 * carries the whole progression across its date columns:
 *
 *   $500   $525   $550   $575   $675   $725   $800
 *
 * So $575 was right for a window that closed years ago. The site's own
 * /blog/workers-compensation-faqs/ already says this correctly:
 *
 *   "The maximum weekly benefit is set by statute and adjusted periodically by
 *    the State Board of Workers' Compensation, so the cap that applies depends
 *    on your date of injury. Confirm the current figure before relying on it."
 *
 * WHAT REPLACES IT, AND WHY THE FIGURE IS KEPT
 * --------------------------------------------
 * The site has already settled how it words this, in four places that were
 * reviewed and are not defective:
 *
 *   3652, 3653  practice_area  "subject to a statutory maximum of $800 per week
 *                              for injuries on or after July 1, 2023"
 *   4107, 5167  _roden_faqs    same figure, same qualifier, citing § 34-9-261
 *
 * That form is what makes it safe: the figure is bound to a date range rather
 * than asserted as a permanent feature, so it stays literally true when the
 * next bracket opens. These two posts are brought onto it. Writing a vaguer
 * "set by statute, ask us" sentence instead would have been defensible on its
 * own but would have left the site saying two different things.
 *
 * ONE CAVEAT WORTH RECORDING. A non-governmental source asserts an $850 maximum
 * from 2026-07-01. No Act and no Board notice corroborating it was found, and
 * the Board's own published summary (PDF dated 2025-07-15) still tops out at
 * $800. If that increase is real, all SIX of the placements above are stale
 * together, which a single grep for "34-9-261" or "per week" now finds.
 *
 * Anchored on ~60 characters of surrounding prose and asserted unique, so a post
 * edited since this was written fails closed instead of being rewritten.
 *
 * The anchors carry a literal U+2019 apostrophe, not &#8217;. Both posts store
 * the character directly - 17 of them in 1801, zero entities - and an anchor
 * written with the entity matched nothing.
 *
 * Uses wp_slash(); see the Gotchas section of CLAUDE.md.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-stale-ttd-max-figure.php
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-stale-ttd-max-figure.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

/**
 * Each edit accepts EITHER the original $575 wording or the interim wording an
 * earlier pass of this script wrote, and lands on the same final text. That
 * makes the script idempotent and reproducible from either state.
 */
$EDITS = array(
	array(
		'id'  => 1801,
		'old' => array(
			'workers’ compensation benefits pay two-thirds of your average weekly wage, not exceeding $575 per week.',
			'workers’ compensation benefits pay two-thirds of your average weekly wage, up to a maximum weekly amount set by statute. That maximum is adjusted periodically by the State Board of Workers’ Compensation, so the cap that applies depends on your date of injury.',
		),
		'new' => 'workers’ compensation benefits pay two-thirds of your average weekly wage, subject to a statutory maximum of $800 per week for injuries on or after July 1, 2023 (O.C.G.A. § 34-9-261). The cap that applies is the one in effect on your date of injury.',
	),
	array(
		'id'  => 1801,
		'old' => array(
			'two-thirds of your average weekly wage at the time of the accident, but cannot exceed $575.',
			'two-thirds of your average weekly wage at the time of the accident, but cannot exceed the statutory maximum in effect for your date of injury.',
		),
		'new' => 'two-thirds of your average weekly wage at the time of the accident, but cannot exceed the statutory maximum in effect on your date of injury — $800 per week for injuries on or after July 1, 2023.',
	),
	array(
		'id'  => 1841,
		'old' => array(
			'you may be able to receive up to two-thirds of your average weekly earnings, up to $575 a week.',
			'you may be able to receive up to two-thirds of your average weekly earnings, up to the maximum weekly amount set by statute for your date of injury. Confirm the current figure before relying on it.',
		),
		'new' => 'you may be able to receive up to two-thirds of your average weekly earnings, up to the statutory maximum for your date of injury — $800 per week for injuries on or after July 1, 2023 (O.C.G.A. § 34-9-261).',
	),
);

echo $APPLY ? "mode: apply\n" : "mode: dry-run\n";
echo str_repeat( '=', 72 ), "\n";

$applied = $failed = 0;
$backup  = array();

foreach ( $EDITS as $n => $e ) {
	$id  = (int) $e['id'];
	$c   = get_post_field( 'post_content', $id );
	if ( ! $c ) {
		printf( "FAIL  #%d post %d has no content\n", $n + 1, $id );
		$failed++;
		continue;
	}
	$anchor = null;
	foreach ( (array) $e['old'] as $cand ) {
		if ( 1 === substr_count( $c, $cand ) ) {
			$anchor = $cand;
			break;
		}
	}
	if ( null === $anchor ) {
		if ( false !== strpos( $c, $e['new'] ) ) {
			printf( "OK    #%d post %d already carries the final wording\n", $n + 1, $id );
			continue;
		}
		printf( "FAIL  #%d post %d: no anchor matched exactly once\n", $n + 1, $id );
		$failed++;
		continue;
	}
	$new = str_replace( $anchor, $e['new'], $c );

	printf( "%s  #%d post %d\n      - %s\n      + %s\n",
		$APPLY ? 'WRITE' : 'WOULD', $n + 1, $id,
		substr( $anchor, 0, 96 ), substr( $e['new'], 0, 96 ) );

	if ( $APPLY ) {
		if ( ! isset( $backup[ $id ] ) ) {
			$backup[ $id ] = $c;
		}
		$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $new ) ), true );
		if ( is_wp_error( $r ) ) {
			printf( "      !! %s\n", $r->get_error_message() );
			$failed++;
			continue;
		}
		clean_post_cache( $id );
		if ( false !== strpos( get_post_field( 'post_content', $id ), $anchor ) ) {
			printf( "      !! READBACK: anchor still present\n" );
			$failed++;
			continue;
		}
	}
	$applied++;
}

echo str_repeat( '=', 72 ), "\n";
printf( "%s: %d   failed: %d\n", $APPLY ? 'written' : 'would write', $applied, $failed );

// No instance of the stale figure may survive in either post.
foreach ( array( 1801, 1841 ) as $id ) {
	$left = substr_count( (string) get_post_field( 'post_content', $id ), '$575' );
	printf( "post %d: '\$575' occurrences remaining: %d\n", $id, $left );
	if ( $APPLY && $left ) {
		$failed++;
	}
}

if ( $APPLY && $backup ) {
	echo "\n--- BACKUP (original post_content) ---\n";
	echo wp_json_encode( $backup, JSON_UNESCAPED_SLASHES ), "\n";
}

if ( $failed ) {
	exit( 1 );
}
