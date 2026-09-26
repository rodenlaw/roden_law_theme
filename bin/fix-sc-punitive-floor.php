<?php
/**
 * State the current South Carolina punitive-damages floor wherever the site
 * gives the unindexed 2011 figure (2026-09-26).
 *
 * S.C. Code § 15-32-530(A) caps punitive damages at the greater of three times
 * compensatory damages or $500,000, and (D) indexes the $500,000 to CPI every
 * year. For 2026 it is $739,245 (RFA memo 2026-02-03, S.C. State Register
 * 2026-02-27). The sweep rule `sc-punitive-floor-unindexed` found 29
 * occurrences on 21 pages: 21 in post bodies and 8 in FAQ answers, which also
 * publish as FAQPage structured data. Correction approved by Gillin 2026-09-26:
 * keep each page's wording and pair the figure with the index and the current
 * amount. Each "$500,000" becomes "$739,245, the 2026 inflation-indexed figure",
 * which reads correctly whether a citation, a comma or more prose follows.
 *
 * Only a "$500,000" with "three times"/"3x"/"treble" AND "punitive" or
 * "15-32-530" within 220 characters (tags stripped) is touched, and never one
 * already paired with "739,245" or "index". The dry run must find exactly the
 * sweep's count per page and field, or the apply refuses.
 *
 * Bodies: direct column write (no wp_update_post(), so no wp_unslash() pass and
 * no post_modified stamp). FAQs: update_post_meta( wp_slash() ). Every write is
 * read back.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-sc-punitive-floor.php > docs/backups/sc-punitive-floor-2026-09-26.json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-sc-punitive-floor.php > docs/backups/sc-punitive-floor-2026-09-26.json
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

global $wpdb;
$apply = isset( $args[0] ) && 'apply' === $args[0];

/* Expected hits per page and field: the sweep's 29, plus 3 the dry run found in the same claim class. */
$expect = array(
	1646 => array( 'body' => 1, 'faqs' => 1 ),
	1647 => array( 'body' => 1 ),
	1669 => array( 'body' => 2 ), // + a table cell the sweep missed
	1673 => array( 'body' => 1, 'faqs' => 1 ),
	1675 => array( 'body' => 1 ),
	1681 => array( 'body' => 1 ),
	1683 => array( 'body' => 1 ),
	1703 => array( 'body' => 1 ),
	1722 => array( 'body' => 1 ),
	1810 => array( 'body' => 1 ),
	2647 => array( 'body' => 1 ),
	3440 => array( 'body' => 1, 'faqs' => 1 ),
	4144 => array( 'body' => 1, 'faqs' => 1 ),
	4189 => array( 'body' => 1, 'faqs' => 1 ),
	4349 => array( 'body' => 1, 'faqs' => 1 ), // FAQ writes "section 15-32-530"; the sweep missed it
	4360 => array( 'body' => 2 ), // + "greater of $500,000 or three times", reversed order
	4534 => array( 'body' => 1 ),
	4562 => array( 'body' => 1, 'faqs' => 1 ),
	4584 => array( 'body' => 1 ),
	4806 => array( 'body' => 1, 'faqs' => 1 ),
	4809 => array( 'body' => 1, 'faqs' => 1 ),
);

$log = array();

/**
 * Replace every qualifying "$500,000" in $text. Returns [ new text, hit count ].
 */
$patch = function ( $text, $where ) use ( &$log ) {
	$hits = 0;
	$out  = preg_replace_callback(
		'/\$500,000/',
		function ( $m ) use ( $text, &$hits, $where, &$log ) {
			$pos    = $m[0][1];
			$window = wp_strip_all_tags( substr( $text, max( 0, $pos - 220 ), 440 + strlen( $m[0][0] ) ) );
			$lower  = strtolower( $window );
			$qual   = preg_match( '/three times|\b3x\b|3 times|treble|triple/', $lower )
				&& ( false !== strpos( $lower, 'punitive' ) || false !== strpos( $lower, '15-32-530' ) )
				&& ! preg_match( '/739,245|index/', $lower );
			if ( ! $qual ) {
				return $m[0][0];
			}
			$hits++;
			$next = substr( $text, $pos + strlen( $m[0][0] ), 2 );
			$rep  = '$739,245, the 2026 inflation-indexed figure';
			// Continuing prose ("… figure, in South Carolina") needs its own comma;
			// a citation, comma, period or closing bracket does not.
			if ( ' ' === substr( $next, 0, 1 ) && '(' !== substr( $next, 1, 1 ) ) {
				$rep .= ',';
			}
			$log[] = $where . ' :: …' . trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( substr( $text, max( 0, $pos - 90 ), 90 ) ) ) ) . ' [' . $rep . ']' . trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( substr( $text, $pos + 8, 60 ) ) ) );
			return $rep;
		},
		$text,
		-1,
		$count,
		PREG_OFFSET_CAPTURE
	);
	return array( $out, $hits );
};

$backup = array(
	'generated' => gmdate( 'c' ),
	'batch'     => 'sc-punitive-floor',
	'mode'      => $apply ? 'apply' : 'dry-run',
	'note'      => 'Per post: body before/after and _roden_faqs before/after. Restore bodies by writing "body_before" to wp_posts.post_content; FAQs with update_post_meta( $id, "_roden_faqs", wp_slash( faqs_before ) ).',
	'posts'     => array(),
);
$plans = array();
$total = 0;

foreach ( $expect as $id => $want ) {
	$body_before = (string) $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	list( $body_after, $bh ) = $patch( $body_before, "{$id} body" );

	$faqs_before = get_post_meta( $id, '_roden_faqs', true );
	$faqs_after  = $faqs_before;
	$fh          = 0;
	if ( is_array( $faqs_before ) ) {
		foreach ( $faqs_after as $i => $f ) {
			if ( is_array( $f ) && isset( $f['answer'] ) && is_string( $f['answer'] ) ) {
				list( $a, $h ) = $patch( $f['answer'], "{$id} faqs[{$i}]" );
				$faqs_after[ $i ]['answer'] = $a;
				$fh += $h;
			}
		}
	}

	$got = array( 'body' => $bh, 'faqs' => $fh );
	foreach ( array( 'body', 'faqs' ) as $k ) {
		$w = isset( $want[ $k ] ) ? $want[ $k ] : 0;
		if ( $got[ $k ] !== $w ) {
			fwrite( STDERR, "MISMATCH: post {$id} {$k}: found {$got[$k]}, sweep expects {$w}\n" );
			if ( $apply ) {
				fwrite( STDERR, "ABORT: nothing written.\n" );
				exit( 1 );
			}
		}
	}
	$total += $bh + $fh;
	$plans[ $id ] = compact( 'body_before', 'body_after', 'bh', 'faqs_before', 'faqs_after', 'fh' );
	$backup['posts'][] = array( 'ID' => $id, 'url' => wp_make_link_relative( get_permalink( $id ) ), 'body_hits' => $bh, 'faq_hits' => $fh, 'body_before' => $body_before, 'body_after' => $body_after, 'faqs_before' => $faqs_before, 'faqs_after' => $faqs_after );
}

foreach ( $log as $l ) {
	fwrite( STDERR, "  {$l}\n" );
}

if ( $apply ) {
	foreach ( $plans as $id => $p ) {
		if ( $p['bh'] ) {
			$wpdb->update( $wpdb->posts, array( 'post_content' => $p['body_after'] ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
			$now = (string) $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
			if ( $now !== $p['body_after'] ) {
				fwrite( STDERR, "FAILED: body read-back mismatch on {$id}\n" );
				exit( 1 );
			}
		}
		if ( $p['fh'] ) {
			update_post_meta( $id, '_roden_faqs', wp_slash( $p['faqs_after'] ) );
			wp_cache_delete( $id, 'post_meta' );
			if ( get_post_meta( $id, '_roden_faqs', true ) !== $p['faqs_after'] ) {
				fwrite( STDERR, "FAILED: FAQ read-back mismatch on {$id}\n" );
				exit( 1 );
			}
		}
		clean_post_cache( $id );
	}
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fwrite( STDERR, ( $apply ? 'Applied' : 'Dry run' ) . ": {$total} replacements across " . count( $expect ) . " posts (expected 32)\n" );
