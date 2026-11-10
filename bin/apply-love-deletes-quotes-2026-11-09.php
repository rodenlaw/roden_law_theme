<?php
/**
 * Love-queue deletions and misquote fixes, 2026-11-09. Source: data/facts/reviews/2026-10-attorney/triage-2026-11-09.md
 * Owner, 2026-11-09: "do 1 and 2 now" = (1) the 19 DELETE cards, (2) the misquotes in the existing-quotes inventory.
 * "D" items are deletions (one, G29, swaps the FAQ's false sentence for the page's own live body sentence so the
 * answer still answers its question). "Q" items make a quotation match the statute (2025 Georgia Code on Justia,
 * read 2026-11-09). 1650 was dropped: its live text is unquoted paraphrase. No disclosure lines added here.
 * Not attorney-reviewed; deletions add no claim.
 *
 * Same mechanics as bin/apply-sc-followups-2026-10-27.php.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/apply-love-deletes-quotes-2026-11-09.php > docs/backups/love-deletes-quotes-2026-11-09.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$edits = json_decode( <<<'EDITS'
[
 {
  "post": 1695,
  "field": "content",
  "from": "you tripped over your own feet, operated a machine incorrectly, or ignored a safety rule — you are",
  "to": "you tripped over your own feet — you are",
  "item": "D E8: safety-rule example (§ 34-9-17(a))"
 },
 {
  "post": 1693,
  "field": "content",
  "from": "exempt in many cases depending on employer size</li>",
  "to": "exempt in many cases</li>",
  "item": "D F21: employer-size qualifier"
 },
 {
  "post": 4173,
  "field": "faq:2:answer",
  "from": "Cyclists have the same rights as motor vehicles at intersections. Under Georgia law (O.C.G.A. § 40-6-294) and",
  "to": "Cyclists have the same rights as vehicles at intersections. Under Georgia law and",
  "item": "D E45: § 40-6-294 cite, 'motor'"
 },
 {
  "post": 4168,
  "field": "faq:1:answer",
  "from": "assisted living facilities — called \"personal care homes\" — under",
  "to": "assisted living facilities under",
  "item": "D E52: personal care homes"
 },
 {
  "post": 4116,
  "field": "faq:2:answer",
  "from": "In both Georgia and South Carolina, settlements for minor children must be approved by a judge to ensure they are fair and in the child's best interest.",
  "to": "Georgia law (O.C.G.A. § 29-3-3) and South Carolina law (S.C. Code § 62-5-433) require judicial approval of minor settlements exceeding certain thresholds.",
  "item": "D G29: FAQ now reuses the page's own body sentence"
 },
 {
  "post": 4205,
  "field": "faq:0:answer",
  "from": ", violating Georgia's Return to Play Act (O.C.G.A. § 20-2-324.1) or South Carolina's student-athlete concussion law (S.C. Code § 59-63-75)",
  "to": "",
  "item": "D G21: concussion-act liability"
 },
 {
  "post": 4205,
  "field": "content",
  "from": "youth concussion safety laws that establish standards of care for sports organizations:",
  "to": "youth concussion safety laws:",
  "item": "D G21: standards-of-care gloss"
 },
 {
  "post": 4170,
  "field": "content",
  "from": "incorporate these federal standards and impose additional state requirements",
  "to": "impose state requirements",
  "item": "D E50: unread 'incorporate' claim"
 },
 {
  "post": 4087,
  "field": "faq:0:answer",
  "from": "same rights and duties as motor vehicle operators",
  "to": "same rights and duties as vehicle operators",
  "item": "D E40: 'motor' (§ 40-6-291)"
 },
 {
  "post": 4087,
  "field": "content",
  "from": "same rights and responsibilities as motor vehicle operators",
  "to": "same rights and responsibilities as vehicle operators",
  "item": "D E40: 'motor' (§ 40-6-291)"
 },
 {
  "post": 4172,
  "field": "content",
  "from": "same rights and duties as drivers of motor vehicles.",
  "to": "same rights and duties as drivers of vehicles.",
  "item": "D E42: 'motor' (§ 40-6-291)"
 },
 {
  "post": 4172,
  "field": "faq:3:answer",
  "from": "same rights and duties as motor vehicle drivers.",
  "to": "same rights and duties as vehicle drivers.",
  "item": "D E43: 'motor' (§ 40-6-291)"
 },
 {
  "post": 4178,
  "field": "content",
  "from": "grants cyclists the same rights as motor vehicles.",
  "to": "grants cyclists the same rights as vehicles.",
  "item": "D E46: 'motor' (§ 40-6-291)"
 },
 {
  "post": 1722,
  "field": "content",
  "from": " (as amended in 2024, for offers made on or after April 22, 2024)",
  "to": " (as amended in 2024)",
  "item": "D E58: offer-date applicability"
 },
 {
  "post": 1840,
  "field": "content",
  "from": " This can apply to victims who suffer <a href=\"/practice-areas/brain-injury-lawyers/\">traumatic brain injuries</a> that prevent them from understanding their legal rights.",
  "to": "",
  "item": "D Q-1840: TBI tolling application"
 },
 {
  "post": 4229,
  "field": "content",
  "from": " Drivers who fail to yield the right of way to an e-scooter rider proceeding lawfully through an intersection are negligent per se — meaning their violation of the traffic law establishes fault as a matter of law.",
  "to": "",
  "item": "D Q-F31: negligence per se"
 },
 {
  "post": 4190,
  "field": "content",
  "from": " Golf cart operators on Georgia streets are subject to the same traffic laws that govern motor vehicle drivers, including the duty to yield to pedestrians in crosswalks and exercise caution in areas where pedestrians are present.",
  "to": "",
  "item": "D Q-F38: PTV traffic-law hook"
 },
 {
  "post": 4190,
  "field": "content",
  "from": "local ordinances similarly require",
  "to": "local ordinances require",
  "item": "D Q-F38: 'similarly'"
 },
 {
  "post": 1676,
  "field": "content",
  "from": "pauses the limitation, but not the repose, until",
  "to": "pauses the limitation until",
  "item": "D Q-1676: repose tolling"
 },
 {
  "post": 1693,
  "field": "content",
  "from": "receive enhanced and potentially lifetime benefits",
  "to": "receive enhanced benefits",
  "item": "D R1: lifetime benefits"
 },
 {
  "post": 4162,
  "field": "content",
  "from": "negligence per se in personal injury claims — meaning the violator is automatically considered negligent.",
  "to": "negligence per se in personal injury claims.",
  "item": "D R2: per se gloss"
 },
 {
  "post": 4227,
  "field": "content",
  "from": "evidence of negligence per se — meaning the rider is presumed to have been negligent.",
  "to": "evidence of negligence per se.",
  "item": "D R3: per se gloss"
 },
 {
  "post": 1752,
  "field": "content",
  "from": "must be \"reasonable and necessary\" to cure",
  "to": "must be \"reasonably required\" to cure",
  "item": "Q 1752: statutes say 'reasonably required' (§ 34-9-200(a); § 42-15-60)"
 },
 {
  "post": 1752,
  "field": "content",
  "from": "The phrase \"reasonable and necessary\" gives",
  "to": "The phrase \"reasonably required\" gives",
  "item": "Q 1752: statutes say 'reasonably required'"
 },
 {
  "post": 1838,
  "field": "content",
  "from": "a plaintiff may recover damages as long as their own negligence is not \"equal to or greater than\" the negligence of the defendant.",
  "to": "the plaintiff \"shall not be entitled to receive any damages if the plaintiff is 50 percent or more responsible for the injury or damages claimed.\"",
  "item": "Q 1838: § 51-12-33(g) verbatim (2025 text)"
 },
 {
  "post": 3616,
  "field": "_roden_pillar_compensation_intro",
  "from": "**\"full value of life\" measure (O.C.G.A. § 51-4-1)**",
  "to": "**\"full value of the life of the decedent\" measure (O.C.G.A. § 51-4-1)**",
  "item": "Q 3616: § 51-4-1(1) verbatim"
 },
 {
  "post": 5354,
  "field": "content",
  "from": "within the national economy.”",
  "to": "within the national economy for which such employee is otherwise qualified”.",
  "item": "Q 5354: § 34-9-200.1(g)(6)(A) quote completed (2025 text)"
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
