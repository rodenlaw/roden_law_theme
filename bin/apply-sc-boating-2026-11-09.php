<?php
/**
 * SC boating corrections, 2026-11-09. Source: data/facts/remediation-2026-11-09-sc-boating-authorities.md
 * (F1, F2, F5-F13). Owner, 2026-11-09: "fix the four boating pages and merge #161".
 * The corrections rest on SC Title 50 Ch. 21 authorities verified against primary text and queued
 * as pendingAuthorities (internal-ai-scripts PR #161); NOT yet attorney-signed. F2 (DOHSA) and the
 * F7 civil-adverse-inference clause are deleted, not rewritten, until Gillin rules. F3 (federal
 * cite) is left for Gillin. Georgia halves are unchanged.
 *
 * Same mechanics as bin/apply-sc-followups-2026-10-27.php.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/apply-sc-boating-2026-11-09.php > docs/backups/sc-boating-2026-11-09.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$edits = json_decode( <<<'EDITS'
[
 {
  "post": 3616,
  "field": "faq:3:answer",
  "from": "South Carolina has the same 0.08% threshold (S.C. Code § 50-21-114).",
  "to": "South Carolina's law turns on impairment instead: it is a crime to operate a moving motorboat or sailboat while materially and appreciably impaired (S.C. Code § 50-21-112), and a BAC of 0.08% or more allows the inference that the operator was under the influence (S.C. Code § 50-21-114).",
  "item": "F1: SC has no per-se BAC limit"
 },
 {
  "post": 3616,
  "field": "_roden_pillar_compensation_intro",
  "from": "On navigable waters in death cases, **DOHSA limits recovery to pecuniary losses** for non-seamen passengers — **barring noneconomic loss-of-society claims** entirely (a major trap for the unwary). ",
  "to": "",
  "item": "F2: DOHSA scope misstated; deleted pending Gillin"
 },
 {
  "post": 4144,
  "field": "content",
  "from": "<p>Both Georgia and South Carolina prohibit operating any vessel with a blood alcohol concentration (BAC) of 0.08% or higher, mirroring DUI thresholds for motor vehicles:</p>",
  "to": "<p>Georgia prohibits operating any vessel with a blood alcohol concentration (BAC) of 0.08% or higher, mirroring DUI thresholds for motor vehicles; South Carolina makes impaired operation the crime, and a BAC of 0.08% or more lets the court infer impairment:</p>",
  "item": "F5: SC has no per-se BAC limit"
 },
 {
  "post": 4144,
  "field": "faq:0:answer",
  "from": "Both states set the legal limit at 0.08% BAC for boaters 21 and older, the same threshold as driving. Georgia law (O.C.G.A. § 52-7-12) and South Carolina law (S.C. Code § 50-21-112) criminalize operating any vessel at or above this level.",
  "to": "Georgia sets the legal limit at 0.08% BAC for boaters 21 and older, the same threshold as driving (O.C.G.A. § 52-7-12). South Carolina sets no fixed limit: S.C. Code § 50-21-112 makes it a crime to operate a moving motorboat or sailboat while materially and appreciably impaired, and under § 50-21-114 a BAC of 0.08% or more allows the inference that the operator was under the influence.",
  "item": "F6: SC has no per-se BAC limit"
 },
 {
  "post": 4144,
  "field": "content",
  "from": "Refusal to submit to testing can result in license suspensions and adverse inferences in civil proceedings.",
  "to": "Refusal to submit to testing can result in license suspensions.",
  "item": "F7: civil adverse inference unsupported; clause deleted pending Gillin"
 },
 {
  "post": 4340,
  "field": "faq:3:answer",
  "from": "Under S.C. Code section 50-21-112, operating a boat with a BAC of 0.08 percent or higher is illegal.",
  "to": "Under S.C. Code section 50-21-112, operating a boat while materially and appreciably impaired by alcohol or drugs is a crime, and under section 50-21-114 a BAC of 0.08 percent or higher supports the inference that the operator was under the influence.",
  "item": "F8: SC has no per-se BAC limit"
 },
 {
  "post": 4340,
  "field": "content",
  "from": "The legal limit is a <strong>blood alcohol concentration (BAC) of 0.08%</strong> — the same as for driving a car.",
  "to": "A <strong>blood alcohol concentration (BAC) of 0.08%</strong> or more — the same figure used for driving — supports the inference that the operator was under the influence (S.C. Code § 50-21-114).",
  "item": "F9: SC has no per-se BAC limit"
 },
 {
  "post": 4340,
  "field": "content",
  "from": "South Carolina law requires reporting boating accidents involving death, injury requiring medical treatment beyond first aid, disappearance of a person, or property damage exceeding $2,000 to the South Carolina Department of Natural Resources (SCDNR) within 48 hours",
  "to": "South Carolina law requires reporting a boating accident to the South Carolina Department of Natural Resources (SCDNR) within 48 hours if it causes a death, an injury that needs medical treatment or causes loss of consciousness, or property damage above the Coast Guard minimum (now $2,000), and immediately if someone dies, loses consciousness or is seriously injured",
  "item": "F10: federal reporting list given as SC's"
 },
 {
  "post": 4352,
  "field": "content",
  "from": "<strong>BUI</strong> — operating a personal watercraft with a BAC of 0.08% or higher is illegal (S.C. Code § 50-21-112)",
  "to": "<strong>BUI</strong> — operating a personal watercraft while materially and appreciably impaired by alcohol or drugs is a crime, and a BAC of 0.08% or higher supports the inference of impairment (S.C. Code § 50-21-112; § 50-21-114)",
  "item": "F11: SC has no per-se BAC limit"
 },
 {
  "post": 4352,
  "field": "faq:2:answer",
  "from": "Boating Under the Influence is illegal in SC at 0.08 percent BAC under S.C. Code section 50-21-112.",
  "to": "Boating Under the Influence is operating a boat in SC while materially and appreciably impaired by alcohol or drugs (S.C. Code section 50-21-112); a BAC of 0.08 percent or more supports the inference of impairment (section 50-21-114).",
  "item": "F12: SC has no per-se BAC limit"
 },
 {
  "post": 4352,
  "field": "faq:5:answer",
  "from": "Operators must be 16+, need boater education if born after Jan 1 1988, must wear life jackets, cannot operate sunset to sunrise, must observe no-wake zones, and BUI at 0.08 BAC is illegal.",
  "to": "Operators born after July 1, 2007 need a South Carolina boating safety certificate or a qualifying adult 18 or older aboard, everyone on a jet ski must wear a life jacket, jet skis cannot operate sunset to sunrise, operators must observe no-wake zones, and operating while impaired by alcohol or drugs is a crime.",
  "item": "F13: no SC minimum age; certificate birth date; per-se BAC"
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
