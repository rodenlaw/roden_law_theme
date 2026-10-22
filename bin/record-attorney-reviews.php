<?php
/**
 * Record attorney reviews: the only way `reviewedBy` reaches a page that has none.
 *
 *   ssh $H "wp --path=... eval-file - <reviews.json>"       < bin/record-attorney-reviews.php
 *   ssh $H "wp --path=... eval-file - <reviews.json> apply" < bin/record-attorney-reviews.php
 *
 * <reviews.json> is a path ON THE SERVER, or '-' for an inline JSON argument as
 * the third arg. Each entry records ONE review that an attorney actually did,
 * relayed by the owner:
 *
 *   [{ "post_id": 1693, "reviewer": "graeham-c-gillin", "date": "2026-10-28",
 *      "jurisdiction": "sc", "source": "Brian, 2026-10-28: Gillin reviewed batch 1" }]
 *
 *   reviewer      attorney post slug
 *   date          Y-m-d the review happened (never "today" by default)
 *   jurisdiction  ga | sc | both. Optional where the post already records one;
 *                 required where it does not, because the reviewer has to be
 *                 checked against something
 *   source        whose word this is. Required: a review with no source is
 *                 exactly the claim this site refuses to manufacture
 *
 * REFUSES an entry when:
 *   - the reviewer is not a published attorney post
 *   - the reviewer is not admitted in every state the page covers
 *     (roden_attorney_bar_states() against roden_page_jurisdiction_states()),
 *     because the theme would not publish that name anyway, and recording it
 *     would only make the database disagree with the page
 *   - the date is in the future or before the post was published
 *   - the post's recorded jurisdiction differs from the entry's (fix one first)
 *   - source is missing
 *
 * Writes `_roden_last_reviewed`, `_roden_reviewed_by` and, where empty,
 * `_roden_jurisdiction`. Writes go through update_post_meta( wp_slash() ), per
 * CLAUDE.md. Before values are printed as BACKUP-JSON. Regenerate
 * content/meta.json after an apply.
 */

$file  = $args[0] ?? '';
$apply = in_array( 'apply', $args, true );
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (add 'apply' to write) ===\n\n";

$raw = ( '-' === $file ) ? ( $args[1] ?? '' ) : ( $file && is_readable( $file ) ? file_get_contents( $file ) : '' );
$rows = json_decode( (string) $raw, true );
if ( ! is_array( $rows ) ) {
	echo "No reviews: pass a readable JSON file path, or '-' and the JSON.\n";
	return;
}

$norm = array( 'ga' => 'ga', 'georgia' => 'ga', 'georgia-only' => 'ga', 'sc' => 'sc', 'south-carolina' => 'sc', 'south-carolina-only' => 'sc', 'both' => 'both' );
$ok   = array();
foreach ( $rows as $i => $r ) {
	$id   = absint( $r['post_id'] ?? 0 );
	$post = $id ? get_post( $id ) : null;
	$why  = array();

	if ( ! $post || 'publish' !== $post->post_status ) {
		$why[] = 'post not published';
	}
	if ( empty( $r['source'] ) ) {
		$why[] = 'no source';
	}
	$date = (string) ( $r['date'] ?? '' );
	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) || ! strtotime( $date ) ) {
		$why[] = 'bad date';
	} elseif ( $date > gmdate( 'Y-m-d' ) ) {
		$why[] = 'date in the future';
	} elseif ( $post && $date < substr( $post->post_date, 0, 10 ) ) {
		$why[] = 'date before the post was published';
	}

	$atty = get_page_by_path( (string) ( $r['reviewer'] ?? '' ), OBJECT, 'attorney' );
	if ( ! $atty || 'publish' !== $atty->post_status ) {
		$why[] = 'reviewer is not a published attorney';
	}

	$have = $post ? (string) get_post_meta( $id, '_roden_jurisdiction', true ) : '';
	$have = $norm[ strtolower( trim( $have ) ) ] ?? '';
	$want = $norm[ strtolower( trim( (string) ( $r['jurisdiction'] ?? '' ) ) ) ] ?? '';
	if ( $have && $want && $have !== $want ) {
		$why[] = "jurisdiction conflict (post: $have, entry: $want)";
	}
	$scope = $have ? $have : $want;
	if ( ! $scope ) {
		$why[] = 'no jurisdiction on the post or the entry';
	}
	if ( $atty && $scope && function_exists( 'roden_attorney_bar_states' ) ) {
		$needs = array( 'ga' => array( 'Georgia' ), 'sc' => array( 'South Carolina' ), 'both' => array( 'Georgia', 'South Carolina' ) )[ $scope ];
		$miss  = array_diff( $needs, roden_attorney_bar_states( $atty->ID ) );
		if ( $miss ) {
			$why[] = $atty->post_title . ' is not admitted in ' . implode( ' and ', $miss );
		}
	}

	$label = $post ? wp_make_link_relative( get_permalink( $id ) ) : "#$id";
	if ( $why ) {
		printf( "  REFUSE [%d] %s: %s\n", $id, $label, implode( '; ', $why ) );
		continue;
	}
	$ok[ $id ] = array( 'atty' => $atty, 'date' => $date, 'scope' => $scope, 'set_scope' => ! $have, 'source' => $r['source'] );
	printf( "  ok     [%d] %s: %s, %s (%s)%s\n", $id, $label, $atty->post_title, $date, $scope, $have ? '' : ' +jurisdiction' );
}

printf( "\n%d to record, %d refused.\n", count( $ok ), count( $rows ) - count( $ok ) );
if ( ! $ok || ! $apply ) {
	echo $ok ? "Dry run. Add 'apply' to write.\n" : '';
	return;
}

$backups = array();
foreach ( $ok as $id => $o ) {
	$backups[ $id ] = array(
		'_roden_last_reviewed' => get_post_meta( $id, '_roden_last_reviewed', true ),
		'_roden_reviewed_by'   => get_post_meta( $id, '_roden_reviewed_by', true ),
		'_roden_jurisdiction'  => get_post_meta( $id, '_roden_jurisdiction', true ),
	);
	update_post_meta( $id, '_roden_last_reviewed', wp_slash( $o['date'] ) );
	update_post_meta( $id, '_roden_reviewed_by', (int) $o['atty']->ID );
	if ( $o['set_scope'] ) {
		update_post_meta( $id, '_roden_jurisdiction', wp_slash( $o['scope'] ) );
	}
	clean_post_cache( $id );
}
echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\n\n--- VERIFY ---\n";
$bad = 0;
foreach ( $ok as $id => $o ) {
	$named = function_exists( 'roden_page_reviewer' ) ? roden_page_reviewer( $id ) : null;
	$good  = get_post_meta( $id, '_roden_last_reviewed', true ) === $o['date'] && $named && $named->ID === $o['atty']->ID;
	$bad  += $good ? 0 : 1;
	printf( "  [%d] %s\n", $id, $good ? 'ok: publishes reviewedBy ' . $named->post_title : 'CHECK' );
}
printf( "%d of %d verified.\nDone.\n", count( $ok ) - $bad, count( $ok ) );
