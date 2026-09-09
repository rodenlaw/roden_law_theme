<?php
/**
 * Move hand-typed "Last reviewed: <date>" lines out of post_content and into
 * _roden_last_reviewed, where the theme already governs them.
 *
 * WHAT IS WRONG
 * -------------
 * 112 published blog posts carry the review date as literal prose in the body.
 * The theme has a field for exactly this — inc/meta-boxes.php tells editors it
 * "Publishes as lastReviewed + reviewedBy" — and roden_last_reviewed_html()
 * renders it with locale-aware formatting. The body line bypasses all of it:
 *
 *   - It is frozen. Nothing updates it, and it survives every content edit.
 *   - It licenses no schema. roden_schema_review_fields() reads the META, so a
 *     page can display a review date and emit none.
 *   - On 19 posts it CONTRADICTS the meta field, and both render. Before this
 *     ran, /blog/tenmile-i-26-best-car-accident-lawyer-north-charleston/ showed
 *     "Last reviewed: September 2, 2026" from the field and "Last reviewed:
 *     2026-08-05" from the body, on the same page. All 19 overlapping posts
 *     disagreed; none agreed.
 *
 * WHY THIS IS NOT MANUFACTURING A REVIEW CLAIM. bin/report-freshness-coverage.php
 * is right that _roden_last_reviewed must not be backfilled with guesses —
 * "asserting a review that may not have happened is not a trust signal worth
 * manufacturing." Nothing here is guessed. Every date moved is one the firm
 * already publishes on that page; this relocates an existing public claim into
 * the field that governs it, and deletes the frozen copy.
 *
 * WHAT IT CHANGES BEYOND THE MOVE. Setting the field licenses `reviewedBy` in
 * schema, naming _roden_author_attorney. Five of the body lines already named a
 * reviewer, and all five name the same attorney the author meta does — checked
 * before writing, so schema will not contradict the prose it replaces.
 *
 * A SIDE EFFECT WORTH RECORDING. Two of these lines described Graeham C. Gillin
 * as "founding partner". The attorney records give his title as "Partner, COO";
 * Eric Roden and Tyler Love are the founding partners. Both wrong instances sit
 * inside lines this removes, so the error goes with them.
 *
 * Idempotent: a post with no matching line is reported OK and skipped.
 * Uses wp_slash() on both writes; see the Gotchas section of CLAUDE.md.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/migrate-hardcoded-review-lines.php
 *   ssh $H "wp --path=$P eval-file - apply" < bin/migrate-hardcoded-review-lines.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

/*
 * Shapes observed across all 112: <p>…</p>, a bare <em>…</em> with no wrapper,
 * plain text with a trailing full stop, and any of those with a trailing
 * " — by <Attorney>, <title>, Roden Law (<office>)" attribution. The date is
 * anchored explicitly so the tail cannot run past the line it belongs to.
 */
$RE = '#(?:<p[^>]*>)?\s*(?:<em>|<strong>|<i>)?\s*(?:Last reviewed|Última revisión)\s*[:：]?\s*'
	. '(\d{4}-\d{2}-\d{2}|[A-Z][a-z]+\s+\d{1,2},\s*\d{4})'
	. '(?:[^<\n]{0,120})?\s*(?:</em>|</strong>|</i>)?\s*(?:</p>)?\s*#u';

global $wpdb;
$ids = $wpdb->get_col(
	"SELECT ID FROM {$wpdb->posts}
	 WHERE post_status = 'publish'
	   AND post_content REGEXP '(Last reviewed|Última revisión)'
	 ORDER BY ID"
);

printf( "%s — %d candidate posts\n", $APPLY ? 'mode: apply' : 'mode: dry-run', count( $ids ) );
echo str_repeat( '=', 76 ), "\n";

$moved = $already = $skipped = $failed = 0;
$conflicts = 0;
$backup = array();
$sizes  = array();

foreach ( $ids as $id ) {
	$content = get_post_field( 'post_content', $id );
	$n = preg_match_all( $RE, $content, $m, PREG_SET_ORDER );

	if ( 0 === $n ) {
		printf( "SKIP  [%d] review text present but no line matched — inspect by hand\n", $id );
		$skipped++;
		continue;
	}
	if ( $n > 1 ) {
		printf( "FAIL  [%d] %d matching lines — refusing to guess\n", $id, $n );
		$failed++;
		continue;
	}

	$body_date = trim( $m[0][1] );
	$ts        = strtotime( $body_date );
	if ( ! $ts ) {
		printf( "FAIL  [%d] unparseable date '%s'\n", $id, $body_date );
		$failed++;
		continue;
	}
	$iso = gmdate( 'Y-m-d', $ts );

	$meta        = trim( (string) get_post_meta( $id, '_roden_last_reviewed', true ) );
	$new_content = preg_replace( $RE, '', $content, 1 );
	$removed     = strlen( $content ) - strlen( $new_content );
	$sizes[]     = $removed;

	// A line is ~40-160 bytes. Anything larger means the pattern over-reached.
	if ( $removed > 260 ) {
		printf( "FAIL  [%d] removal of %d bytes is too large — pattern over-reached\n", $id, $removed );
		$failed++;
		continue;
	}
	if ( preg_match( '/(Last reviewed|Última revisión)/u', $new_content ) ) {
		printf( "FAIL  [%d] review text survives removal\n", $id );
		$failed++;
		continue;
	}

	$note = '';
	if ( '' === $meta ) {
		$note = sprintf( 'set meta %s', $iso );
	} elseif ( $meta !== $iso ) {
		$note = sprintf( 'meta %s KEPT (body said %s)', $meta, $iso );
		$conflicts++;
	} else {
		$note = sprintf( 'meta %s already agrees', $meta );
	}

	printf( "%s  [%d] -%d bytes  %s\n", $APPLY ? 'WRITE' : 'WOULD', $id, $removed, $note );

	if ( $APPLY ) {
		$backup[ $id ] = array( 'post_content' => $content, 'meta_before' => $meta );

		if ( '' === $meta ) {
			update_post_meta( $id, '_roden_last_reviewed', wp_slash( $iso ) );
		}
		$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $new_content ) ), true );
		if ( is_wp_error( $r ) ) {
			printf( "      !! %s\n", $r->get_error_message() );
			$failed++;
			continue;
		}
		clean_post_cache( $id );

		$rb_body = get_post_field( 'post_content', $id );
		$rb_meta = trim( (string) get_post_meta( $id, '_roden_last_reviewed', true ) );
		if ( preg_match( '/(Last reviewed|Última revisión)/u', $rb_body ) || '' === $rb_meta ) {
			printf( "      !! READBACK: body clean=%s  meta='%s'\n",
				preg_match( '/(Last reviewed|Última revisión)/u', $rb_body ) ? 'NO' : 'yes', $rb_meta );
			$failed++;
			continue;
		}
	}
	$moved++;
}

echo str_repeat( '=', 76 ), "\n";
printf( "%s: %d   skipped: %d   failed: %d   (body/meta conflicts resolved in favour of the field: %d)\n",
	$APPLY ? 'migrated' : 'would migrate', $moved, $skipped, $failed, $conflicts );
if ( $sizes ) {
	sort( $sizes );
	printf( "bytes removed per post: min=%d median=%d max=%d\n", $sizes[0], $sizes[ intdiv( count( $sizes ), 2 ) ], end( $sizes ) );
}

$left = (int) $wpdb->get_var(
	"SELECT COUNT(*) FROM {$wpdb->posts}
	 WHERE post_status='publish' AND post_content REGEXP '(Last reviewed|Última revisión)'"
);
printf( "posts still carrying a hardcoded review line: %d\n", $left );

if ( $APPLY && $backup ) {
	echo "\n--- BACKUP (original post_content + prior meta) ---\n";
	echo wp_json_encode( $backup, JSON_UNESCAPED_SLASHES ), "\n";
}

if ( $failed ) {
	exit( 1 );
}
