<?php
/**
 * Record attorney reviews: the only way `reviewedBy` reaches a page that has none.
 *
 *   ssh $H "wp --path=... eval-file - <reviews.json>"       < bin/record-attorney-reviews.php
 *   ssh $H "wp --path=... eval-file - <reviews.json> apply" < bin/record-attorney-reviews.php
 *
 * <reviews.json> is a path ON THE SERVER, or '-' followed by the JSON inline. Over
 * ssh, pass it base64-encoded, since shell quoting mangles JSON:
 *   ssh $H "wp ... eval-file - - b64:$(base64 < reviews.json)" < bin/record-attorney-reviews.php Each entry records ONE review that an attorney actually did,
 * relayed by the owner:
 *
 *   [{ "post_id": 1693, "reviewer": "graeham-c-gillin", "date": "2026-10-28",
 *      "jurisdiction": "sc", "source": "Brian, 2026-10-28: Gillin reviewed batch 1" }]
 *
 *   reviewer      attorney post slug, or an array of two for a two-state page
 *                 (no attorney is admitted in both GA and SC)
 *   date          Y-m-d the review happened (never "today" by default)
 *   jurisdiction  ga | sc | both. Optional where the post already records one;
 *                 required where it does not, because the reviewer has to be
 *                 checked against something
 *   source        whose word this is. Required: a review with no source is
 *                 exactly the claim this site refuses to manufacture
 *
 * REFUSES an entry when:
 *   - a reviewer is not a published attorney post
 *   - a reviewer is admitted in none of the page's states, or the reviewers
 *     together are not admitted in every state the page covers
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
if ( 0 === strpos( (string) $raw, 'b64:' ) ) {
	$raw = base64_decode( substr( $raw, 4 ) ); // survives ssh quoting: '-' b64:$(base64 < reviews.json)
}
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

	$attys = array();
	foreach ( (array) ( $r['reviewer'] ?? array() ) as $slug ) {
		$a = get_page_by_path( (string) $slug, OBJECT, 'attorney' );
		if ( ! $a || 'publish' !== $a->post_status ) {
			$why[] = "reviewer '$slug' is not a published attorney";
		} else {
			$attys[ $a->ID ] = $a;
		}
	}
	if ( ! $attys && ! $why ) {
		$why[] = 'no reviewer';
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
	if ( $attys && $scope && function_exists( 'roden_attorney_bar_states' ) ) {
		$needs = array( 'ga' => array( 'Georgia' ), 'sc' => array( 'South Carolina' ), 'both' => array( 'Georgia', 'South Carolina' ) )[ $scope ];
		$held  = array();
		foreach ( $attys as $a ) {
			$bars = roden_attorney_bar_states( $a->ID );
			if ( ! array_intersect( $needs, $bars ) ) {
				$why[] = $a->post_title . ' is admitted in none of ' . implode( ', ', $needs );
			}
			$held = array_merge( $held, $bars );
		}
		$miss = array_diff( $needs, $held );
		if ( $miss ) {
			$why[] = 'no reviewer is admitted in ' . implode( ' and ', $miss );
		}
	}

	$label = $post ? wp_make_link_relative( get_permalink( $id ) ) : "#$id";
	if ( $why ) {
		printf( "  REFUSE [%d] %s: %s\n", $id, $label, implode( '; ', $why ) );
		continue;
	}
	$ok[ $id ] = array( 'attys' => $attys, 'date' => $date, 'scope' => $scope, 'set_scope' => ! $have, 'source' => $r['source'] );
	printf( "  ok     [%d] %s: %s, %s (%s)%s\n", $id, $label, implode( ' + ', wp_list_pluck( $attys, 'post_title' ) ), $date, $scope, $have ? '' : ' +jurisdiction' );
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
	update_post_meta( $id, '_roden_reviewed_by', implode( ',', array_keys( $o['attys'] ) ) );
	if ( $o['set_scope'] ) {
		update_post_meta( $id, '_roden_jurisdiction', wp_slash( $o['scope'] ) );
	}
	clean_post_cache( $id );
}
echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\n\n--- VERIFY ---\n";
$bad = 0;
foreach ( $ok as $id => $o ) {
	$named = function_exists( 'roden_page_reviewers' ) ? wp_list_pluck( roden_page_reviewers( $id ), 'ID' ) : array();
	$want  = array_keys( $o['attys'] );
	sort( $named );
	sort( $want );
	$good  = get_post_meta( $id, '_roden_last_reviewed', true ) === $o['date'] && $named === $want;
	$bad  += $good ? 0 : 1;
	printf( "  [%d] %s\n", $id, $good ? 'ok: publishes reviewedBy ' . implode( ' + ', wp_list_pluck( $o['attys'], 'post_title' ) ) : 'CHECK' );
}
printf( "%d of %d verified.\nDone.\n", count( $ok ) - $bad, count( $ok ) );
