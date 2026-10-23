<?php
/**
 * Record which state(s) a page's legal content covers. It writes `_roden_jurisdiction` only.
 *
 *   ssh $H "wp ... eval-file - b64:$(base64 < map.json)"       < bin/record-jurisdictions.php
 *   ssh $H "wp ... eval-file - b64:$(base64 < map.json) apply" < bin/record-jurisdictions.php
 *
 * map.json: [{ "post_id": 1744, "jurisdiction": "both" }, ...]  (ga | sc | both)
 *
 * This claims no review. It records a fact about the page (whose law it
 * states), which roden_page_reviewers() checks a reviewer's bar admission
 * against. First use: the 62 reviewed pages read on 2026-10-22, all of them
 * two-state (docs/reviews/confirm-jurisdiction-2026-10.md). Owner approval is
 * required before 'apply'.
 *
 * Refuses a post that already records a different jurisdiction unless the row
 * names the value it replaces: { "post_id": 4689, "jurisdiction": "both",
 * "from": "ga" } changes it only while the page still records 'ga'. Prints, per post, whether it names a
 * reviewer before and after. Before values are printed as BACKUP-JSON.
 */

$raw   = (string) ( $args[0] ?? '' );
$apply = in_array( 'apply', $args, true );
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (add 'apply' to write) ===\n\n";
if ( 0 === strpos( $raw, 'b64:' ) ) {
	$raw = base64_decode( substr( $raw, 4 ) );
} elseif ( $raw && is_readable( $raw ) ) {
	$raw = file_get_contents( $raw );
}
$rows = json_decode( $raw, true );
if ( ! is_array( $rows ) ) {
	echo "No map: pass b64:<json> or a readable path.\n";
	return;
}

$norm = array( 'ga' => 'ga', 'georgia' => 'ga', 'georgia-only' => 'ga', 'sc' => 'sc', 'south-carolina' => 'sc', 'south-carolina-only' => 'sc', 'both' => 'both' );
$names = function ( $id ) {
	return function_exists( 'roden_page_reviewers' ) ? implode( ' + ', wp_list_pluck( roden_page_reviewers( $id ), 'post_title' ) ) : '?';
};
$todo = array();
foreach ( $rows as $r ) {
	$id   = absint( $r['post_id'] ?? 0 );
	$want = $norm[ strtolower( trim( (string) ( $r['jurisdiction'] ?? '' ) ) ) ] ?? '';
	$post = $id ? get_post( $id ) : null;
	if ( ! $post || 'publish' !== $post->post_status || ! $want ) {
		printf( "  REFUSE [%d]: %s\n", $id, ! $want ? 'bad jurisdiction' : 'not published' );
		continue;
	}
	$have_raw = (string) get_post_meta( $id, '_roden_jurisdiction', true );
	$have     = $norm[ strtolower( trim( $have_raw ) ) ] ?? '';
	// A deliberate correction names the value it replaces ("from"); it goes
	// through only while the page still records exactly that value.
	$from = isset( $r['from'] ) ? ( $norm[ strtolower( trim( (string) $r['from'] ) ) ] ?? 'invalid' ) : null;
	if ( $have && $have !== $want && $from !== $have ) {
		printf( "  REFUSE [%d] %s: records '%s', map says '%s'%s\n", $id, $post->post_name, $have_raw, $want, null === $from ? ' (add "from" to correct it deliberately)' : " (map's from '{$r['from']}' does not match)" );
		continue;
	}
	if ( $have === $want ) {
		printf( "  same   [%d] %s: already %s\n", $id, $post->post_name, $have_raw );
		continue;
	}
	$todo[ $id ] = array( 'want' => $want, 'before' => $have_raw, 'named' => $names( $id ) );
	printf( "  set    [%d] %s -> %s (reviewedBy now: %s)\n", $id, $post->post_name, $want, $todo[ $id ]['named'] ?: 'none' );
}
printf( "\n%d to set.\n", count( $todo ) );
if ( ! $todo || ! $apply ) {
	return;
}

$backups = array();
foreach ( $todo as $id => $t ) {
	$backups[ $id ] = $t['before'];
	update_post_meta( $id, '_roden_jurisdiction', wp_slash( $t['want'] ) );
	clean_post_cache( $id );
}
echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\n\n--- VERIFY ---\n";
$bad = 0;
foreach ( $todo as $id => $t ) {
	$ok   = get_post_meta( $id, '_roden_jurisdiction', true ) === $t['want'];
	$bad += $ok ? 0 : 1;
	printf( "  [%d] %s, reviewedBy %s -> %s\n", $id, $ok ? 'ok' : 'WRONG', $t['named'] ?: 'none', $names( $id ) ?: 'none' );
}
printf( "%d of %d set.\nDone.\n", count( $todo ) - $bad, count( $todo ) );
