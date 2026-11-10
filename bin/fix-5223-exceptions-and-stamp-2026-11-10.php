<?php
/**
 * /resources/georgia-statute-of-limitations/ (post 5223), owner 2026-11-10: "do the small fix now".
 *
 * 1. The body and FAQ 1 list the Georgia limitation exceptions as if the list were complete
 *    ("The exceptions that genuinely exist are ..."), yet omit fraud tolling (O.C.G.A. § 9-3-96).
 *    § 9-3-96 is not in the GA law pack, so it is not added; the wording is softened to
 *    "main" instead. Wording only, no new claim.
 * 2. _roden_last_reviewed = 2026-08-07 is the publish day, written by the seeder, with no
 *    _roden_reviewed_by: a self-stamp, same class as 5348 (cleared 2026-10-23). Deleted until
 *    an attorney actually reads the page.
 *
 * Same mechanics as bin/apply-love-followups-2026-11-09.php: working copy per surface, exact
 * single-match guard, one write per surface with wp_slash, DB read-back, _roden_content_modified.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-5223-exceptions-and-stamp-2026-11-10.php > docs/backups/fix-5223-2026-11-10.json
 */
$apply   = isset( $args[0] ) && 'apply' === $args[0];
$post_id = 5223;
$stamp   = '2026-08-07';
$edits   = array(
	array(
		'field' => 'content',
		'from'  => '<p>The exceptions that genuinely exist are statutory and narrow:',
		'to'    => '<p>The main statutory exceptions are narrow:',
		'item'  => 'body: exceptions list no longer reads as exhaustive (omits § 9-3-96)',
	),
	array(
		'field' => 'faq:1:answer',
		'from'  => 'The exceptions are narrow and statutory:',
		'to'    => 'The main exceptions are narrow and statutory:',
		'item'  => 'FAQ 1: same, also published as FAQPage structured data',
	),
);

$post = get_post( $post_id );
if ( ! $post || 'publish' !== $post->post_status || 'resource' !== $post->post_type || 'georgia-statute-of-limitations' !== $post->post_name ) {
	fwrite( STDERR, "ABORT: $post_id is not the published GA SOL resource\n" ); exit( 1 );
}
$stamp_vals = get_post_meta( $post_id, '_roden_last_reviewed', false );
if ( array( $stamp ) !== $stamp_vals ) {
	fwrite( STDERR, 'ABORT: _roden_last_reviewed is ' . wp_json_encode( $stamp_vals ) . ", expected [\"$stamp\"]\n" ); exit( 1 );
}
if ( array() !== get_post_meta( $post_id, '_roden_reviewed_by', false ) ) {
	fwrite( STDERR, "ABORT: _roden_reviewed_by is set; this may be a real review\n" ); exit( 1 );
}

$work = array( 'content' => $post->post_content, '_roden_faqs' => get_post_meta( $post_id, '_roden_faqs', true ) );
$orig = $work;
if ( ! is_array( $work['_roden_faqs'] ) ) { fwrite( STDERR, "ABORT: no _roden_faqs array\n" ); exit( 1 ); }

$fail = 0; $log = array();
foreach ( $edits as $e ) {
	if ( 0 === strpos( $e['field'], 'faq:' ) ) {
		list( , $i, $k ) = explode( ':', $e['field'] );
		$s = isset( $work['_roden_faqs'][ $i ][ $k ] ) ? $work['_roden_faqs'][ $i ][ $k ] : null;
	} else {
		$s = $work[ $e['field'] ];
	}
	$n = is_string( $s ) ? substr_count( $s, $e['from'] ) : -1;
	if ( 1 !== $n ) { fwrite( STDERR, "MISMATCH {$e['item']}: matched $n\n" ); $fail++; continue; }
	$s = str_replace( $e['from'], $e['to'], $s );
	if ( 0 === strpos( $e['field'], 'faq:' ) ) { $work['_roden_faqs'][ $i ][ $k ] = $s; } else { $work[ $e['field'] ] = $s; }
	$log[] = array( 'item' => $e['item'], 'post' => $post_id, 'field' => $e['field'], 'from' => $e['from'], 'to' => $e['to'] );
	fwrite( STDERR, ( $apply ? 'fixing' : 'would fix' ) . " {$e['item']}\n" );
}
if ( $fail ) { fwrite( STDERR, "ABORT: $fail mismatches, nothing written\n" ); exit( 1 ); }
fwrite( STDERR, ( $apply ? 'deleting' : 'would delete' ) . " _roden_last_reviewed = $stamp\n" );

$out = array(
	'generated' => gmdate( 'c' ),
	'mode'      => $apply ? 'apply' : 'dry-run',
	'edits'     => $log,
	'deleted'   => array( '_roden_last_reviewed' => $stamp ),
	'before'    => array( $post_id => array_merge( $orig, array( '_roden_last_reviewed' => $stamp, '_roden_content_modified' => get_post_meta( $post_id, '_roden_content_modified', true ) ) ) ),
);

if ( $apply ) {
	global $wpdb;
	$r = wp_update_post( wp_slash( array( 'ID' => $post_id, 'post_content' => $work['content'] ) ), true );
	if ( is_wp_error( $r ) ) { fwrite( STDERR, 'FAILED write content: ' . $r->get_error_message() . "\n" ); exit( 1 ); }
	update_post_meta( $post_id, '_roden_faqs', wp_slash( $work['_roden_faqs'] ) );
	delete_post_meta( $post_id, '_roden_last_reviewed', $stamp );
	update_post_meta( $post_id, '_roden_content_modified', wp_slash( gmdate( 'Y-m-d H:i:s' ) ) );
	clean_post_cache( $post_id ); wp_cache_delete( $post_id, 'post_meta' );

	$back = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $post_id ) );
	if ( $back !== $work['content'] ) { fwrite( STDERR, "FAILED read-back content\n" ); exit( 1 ); }
	$raw = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = '_roden_faqs'", $post_id ) );
	if ( maybe_unserialize( $raw ) !== $work['_roden_faqs'] ) { fwrite( STDERR, "FAILED read-back _roden_faqs\n" ); exit( 1 ); }
	$left = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = '_roden_last_reviewed'", $post_id ) );
	if ( '0' !== (string) $left ) { fwrite( STDERR, "FAILED: _roden_last_reviewed still present\n" ); exit( 1 ); }
	fwrite( STDERR, "read-back OK $post_id\n" );
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
