<?php
/**
 * Follow-ups from the 2026-11-09 Love-queue triage (otherFindings), owner 2026-11-09: "do the 1690 and 4117 fixes".
 * Deletions only: 1690 machine-guard list item, 1690 drug-test presumption takeaway (the body/FAQ wording is card E5,
 * waiting on the D6 decision), 4117 FAQ 2 leash-law negligence-per-se sentence. No new claim.
 *
 * Same mechanics as bin/apply-sc-followups-2026-10-27.php.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/apply-love-followups-2026-11-09.php > docs/backups/love-followups-2026-11-09.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$edits = json_decode( <<<'EDITS'
[
 {
  "post": 1690,
  "field": "content",
  "from": "<li><strong>Ignoring safety protocols:</strong> A factory worker who bypasses a machine guard to speed up production and loses a finger is covered</li>\n",
  "to": "",
  "item": "D 1690: machine-guard item (§ 34-9-17(a) wilful failure to use a safety appliance)"
 },
 {
  "post": 1690,
  "field": "_roden_key_takeaways",
  "from": " A positive drug test in Georgia creates a rebuttable presumption, not an automatic denial.",
  "to": "",
  "item": "D 1690: drug-test presumption takeaway (E5 class)"
 },
 {
  "post": 4117,
  "field": "faq:2:answer",
  "from": " Violation of local leash laws constitutes negligence per se in many jurisdictions, making it easier to establish liability.",
  "to": "",
  "item": "D 4117: leash-law negligence per se"
 }
]
EDITS
, true );
if ( ! is_array( $edits ) ) { fwrite( STDERR, "ABORT: edit table did not parse\n" ); exit( 1 ); }

// Build working copies per post and surface.
$work = array(); $orig = array();
foreach ( $edits as $e ) {
	$p = $e['post'];
	if ( ! isset( $work[ $p ] ) ) {
		$post = get_post( $p );
		if ( ! $post || 'publish' !== $post->post_status ) { fwrite( STDERR, "ABORT: $p missing or not published\n" ); exit( 1 ); }
		$work[ $p ] = array( 'content' => $post->post_content );
		$orig[ $p ] = array( 'content' => $post->post_content );
	}
	$surface = 0 === strpos( $e['field'], 'faq:' ) ? '_roden_faqs' : $e['field'];
	if ( ! isset( $work[ $p ][ $surface ] ) ) {
		$v = get_post_meta( $p, $surface, true );
		if ( '' === $v || null === $v ) { fwrite( STDERR, "ABORT: $p has no $surface\n" ); exit( 1 ); }
		$work[ $p ][ $surface ] = $v; $orig[ $p ][ $surface ] = $v;
	}
}
$fail = 0; $log = array();
foreach ( $edits as $e ) {
	$p = $e['post'];
	if ( 0 === strpos( $e['field'], 'faq:' ) ) {
		list( , $i, $k ) = explode( ':', $e['field'] );
		$s = isset( $work[ $p ]['_roden_faqs'][ $i ][ $k ] ) ? $work[ $p ]['_roden_faqs'][ $i ][ $k ] : null;
	} else {
		$s = $work[ $p ][ $e['field'] ];
	}
	$n = is_string( $s ) ? substr_count( $s, $e['from'] ) : -1;
	if ( 1 !== $n ) { fwrite( STDERR, "MISMATCH {$e['item']} $p {$e['field']}: matched $n\n" ); $fail++; continue; }
	$s = str_replace( $e['from'], $e['to'], $s );
	if ( 0 === strpos( $e['field'], 'faq:' ) ) { $work[ $p ]['_roden_faqs'][ $i ][ $k ] = $s; } else { $work[ $p ][ $e['field'] ] = $s; }
	$log[] = array( 'item' => $e['item'], 'post' => $p, 'field' => $e['field'], 'from' => $e['from'], 'to' => $e['to'] );
	fwrite( STDERR, ( $apply ? 'fixing' : 'would fix' ) . " {$e['item']} $p {$e['field']}\n" );
}
if ( $fail ) { fwrite( STDERR, "ABORT: $fail mismatches, nothing written\n" ); exit( 1 ); }

$out = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'edits' => $log, 'before' => $orig );
if ( $apply ) {
	global $wpdb; $now = gmdate( 'Y-m-d H:i:s' );
	foreach ( $work as $p => $surfaces ) {
		foreach ( $surfaces as $key => $val ) {
			if ( $val === $orig[ $p ][ $key ] ) continue;
			if ( 'content' === $key ) {
				$r = wp_update_post( wp_slash( array( 'ID' => $p, 'post_content' => $val ) ), true );
				if ( is_wp_error( $r ) ) { fwrite( STDERR, "FAILED write $p content: " . $r->get_error_message() . "\n" ); exit( 1 ); }
			} else {
				update_post_meta( $p, $key, wp_slash( $val ) );
			}
		}
		update_post_meta( $p, '_roden_content_modified', wp_slash( $now ) );
		clean_post_cache( $p ); wp_cache_delete( $p, 'post_meta' );
		foreach ( $surfaces as $key => $val ) {
			if ( 'content' === $key ) {
				$back = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $p ) );
			} else {
				$raw  = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s", $p, $key ) );
				$back = maybe_unserialize( $raw );
			}
			if ( $back !== $val ) { fwrite( STDERR, "FAILED read-back $p $key\n" ); exit( 1 ); }
		}
		fwrite( STDERR, "read-back OK $p\n" );
	}
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
