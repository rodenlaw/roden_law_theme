<?php
/**
 * South Carolina follow-ups to the October attorney review, drafted 2026-10-27
 * from Graeham C. Gillin's answers (3130(a), 3230 "yes"; Q-3435; Q-6160) and
 * from survivors the claim-class sweep found (E31 class on 1674/1693; the
 * § 59-63-75 short title in two FAQs). Owner, 2026-10-27: "apply those proposed
 * changes in 1-6 now and we'll get Gillin to review in the future". NOT yet
 * attorney-reviewed: the wording went to Gillin by email (draft 2026-10-27).
 *
 * Same mechanics as bin/apply-gillin-sc-2026-10.php: exact match once on
 * every surface before any write; one write per surface via wp_slash; read
 * back from the table; _roden_content_modified set per post.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/apply-sc-followups-2026-10-27.php > docs/backups/sc-followups-2026-10-27.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$edits = json_decode( <<<'EDITS'
[
 {
  "post": 4478,
  "field": "content",
  "from": "<li>The duty to yield applies at both <strong>marked and unmarked crosswalks</strong></li>",
  "to": "<li>Where traffic-control signals are not in place or not in operation, the duty to yield applies at both <strong>marked and unmarked crosswalks</strong></li>",
  "item": "1: § 56-5-3130(a) condition"
 },
 {
  "post": 4478,
  "field": "faq:0:answer",
  "from": "Yes. S.C. Code § 56-5-3130 requires drivers",
  "to": "Yes, where no traffic signal is in place or working. S.C. Code § 56-5-3130(a) then requires drivers",
  "item": "1: § 56-5-3130(a) condition"
 },
 {
  "post": 4478,
  "field": "content",
  "from": "The word \"notwithstanding\" is key — it means this duty applies <em>regardless</em> of any other provision, including situations where the pedestrian does not have the right of way.",
  "to": "The opening words, \"notwithstanding other provisions of any local ordinance,\" mean no local ordinance can lower this duty. The duty also applies when the pedestrian does not have the right of way.",
  "item": "2: § 56-5-3230 gloss"
 },
 {
  "post": 4172,
  "field": "content",
  "from": "<a href=\"https://www.scstatehouse.gov/code/t56c005.php\" target=\"_blank\" rel=\"noopener\">S.C. Code § 56-5-3435</a> grants cyclists the same rights as vehicle drivers and prohibits drivers from making turns across a cyclist's path unless the turn can be made safely.",
  "to": "<a href=\"https://www.scstatehouse.gov/code/t56c005.php\" target=\"_blank\" rel=\"noopener\">S.C. Code § 56-5-3420</a> gives cyclists the same rights and duties as drivers, subject to statutory exceptions, and § 56-5-3435 requires a driver passing a cyclist to keep a safe operating distance.",
  "item": "3: re-cite to § 56-5-3420"
 },
 {
  "post": 4172,
  "field": "faq:3:answer",
  "from": "South Carolina (S.C. Code § 56-5-3435)",
  "to": "South Carolina (S.C. Code § 56-5-3420)",
  "item": "3: re-cite to § 56-5-3420"
 },
 {
  "post": 4173,
  "field": "content",
  "from": "<a href=\"https://www.scstatehouse.gov/code/t56c005.php\" target=\"_blank\" rel=\"noopener\">S.C. Code § 56-5-3435</a> grants cyclists identical rights and duties as motor vehicle operators, including the right of way at intersections when traveling with a green signal or stop-sign priority.",
  "to": "<a href=\"https://www.scstatehouse.gov/code/t56c005.php\" target=\"_blank\" rel=\"noopener\">S.C. Code § 56-5-3420</a> gives cyclists the same rights and duties as drivers, subject to statutory exceptions, so the ordinary right-of-way rules at intersections apply to them.",
  "item": "3: re-cite to § 56-5-3420"
 },
 {
  "post": 4173,
  "field": "faq:2:answer",
  "from": "South Carolina law (S.C. Code § 56-5-3435)",
  "to": "South Carolina law (S.C. Code § 56-5-3420)",
  "item": "3: re-cite to § 56-5-3420"
 },
 {
  "post": 1790,
  "field": "content",
  "from": "the driver's guilty plea proves the other driver",
  "to": "the driver's guilty plea shows the other driver",
  "item": "4: guilty plea not proof"
 },
 {
  "post": 1674,
  "field": "content",
  "from": "<li><strong>Choice of physician:</strong> South Carolina gives injured workers more flexibility in choosing their treating physician than Georgia. You can typically select your own doctor, though the insurer can request a change under certain circumstances (S.C. Code § 42-15-60).</li>",
  "to": "<li><strong>Choice of physician:</strong> In South Carolina the employer may choose and furnish the treating physician, and the injured worker must accept that physician (S.C. Code § 42-15-60).</li>",
  "item": "5: § 42-15-60 physician"
 },
 {
  "post": 1693,
  "field": "content",
  "from": "<li><strong>Choice of physician:</strong> Unlike Georgia, South Carolina gives injured workers more flexibility in choosing their own treating physician (S.C. Code § 42-15-60)</li>",
  "to": "<li><strong>Choice of physician:</strong> The employer may choose and furnish the treating physician (S.C. Code § 42-15-60)</li>",
  "item": "5: § 42-15-60 physician"
 },
 {
  "post": 4207,
  "field": "faq:2:answer",
  "from": "South Carolina's Youth Athletic Concussion Prevention Act (S.C. Code § 59-63-75)",
  "to": "South Carolina's student-athlete concussion law (S.C. Code § 59-63-75)",
  "item": "6: § 59-63-75 name"
 },
 {
  "post": 4205,
  "field": "faq:0:answer",
  "from": "South Carolina's Youth Athletic Concussion Prevention Act (S.C. Code § 59-63-75)",
  "to": "South Carolina's student-athlete concussion law (S.C. Code § 59-63-75)",
  "item": "6: § 59-63-75 name"
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
