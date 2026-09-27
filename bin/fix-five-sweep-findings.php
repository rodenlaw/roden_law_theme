<?php
/**
 * The five live-content findings from the Roden claims sweep run with the merged
 * law packs (internal-ai-scripts #67), 2026-09-26. Owner, 2026-09-26: "fix those
 * five posts which have been reviewed" — Georgia items reviewed by Eric Roden,
 * South Carolina items by Graeham C. Gillin. Every corrected sentence states only
 * what the signed packs hold.
 *
 * 1. 1671 body — § 56-5-1260 carried the $1,000 threshold, which is § 56-5-1270's
 *    (SC 56-5-1260, SC 56-5-1270). The text below is the final wording: pass 1
 *    joined both statutes in one sentence, which the claims engine's pairing
 *    check reads as § 56-5-1260 + "$1,000", so pass 2 split it per statute
 *    (backup: docs/backups/five-sweep-findings-1671-pass2-2026-09-26.json).
 * 2. 1820 body — "a city or municipal county" given six months; a county gets
 *    twelve (GA 36-33-5, GA 36-11-1, GA 50-21-26).
 * 3. 2647 body — Georgia notice given as "6 to 12 months" without saying which
 *    (same authorities).
 * 4. 3493 _roden_faqs[4] (also FAQPage structured data) — "city, county or state
 *    agency … as little as six months"; six months is the city period only.
 * 5. 4624 body — the SC Tort Claims Act said to "require strict notice
 *    compliance"; it imposes no pre-suit notice (SC 15-78-110, SC 15-78-80).
 *
 * Bodies: direct column write (no wp_update_post(), so no wp_unslash() pass and
 * no post_modified stamp). FAQ: update_post_meta( wp_slash() ). Exact-match,
 * once each; every write read back.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-five-sweep-findings.php > docs/backups/five-sweep-findings-2026-09-26.json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-five-sweep-findings.php > docs/backups/five-sweep-findings-2026-09-26.json
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply = isset( $args[0] ) && 'apply' === $args[0];
global $wpdb;

$bodies = array(
	array( 1671,
		'South Carolina law requires you to report any accident involving injury, death, or property damage exceeding $1,000 (S.C. Code § 56-5-1260).',
		'South Carolina law requires you to notify police immediately after a crash that injures or kills anyone (S.C. Code § 56-5-1260). If no officer investigated a crash involving injury or $1,000 or more in property damage, you must also file a written report with the DMV within 15 days (S.C. Code § 56-5-1270).' ),
	array( 1820,
		'If you are filing a claim against a city or municipal county, you have six months to provide notice about your claim. Likewise, if you are filing a claim against the state, you must present notice of your claim within 12 months of the accident.',
		'If you are filing a claim against a city, you have six months to provide notice about your claim (O.C.G.A. § 36-33-5). If you are filing a claim against a county or the state, you must present notice of your claim within 12 months (O.C.G.A. §§ 36-11-1, 50-21-26).' ),
	array( 2647,
		'Georgia requires ante-litem notice within 6 to 12 months, and South Carolina requires suit within 2 years, with no pre-suit notice.',
		'Georgia requires ante-litem notice within six months for a claim against a city and twelve months for a county or the State, and South Carolina requires suit within 2 years, with no pre-suit notice.' ),
	array( 4624,
		'the city or SCDOT may be partially liable under the South Carolina Tort Claims Act — but these claims require strict notice compliance',
		'the city or SCDOT may be partially liable under the South Carolina Tort Claims Act — but these claims have their own deadline: suit within two years, or three years if a verified claim is filed with the agency within one year (S.C. Code §§ 15-78-110, 15-78-80)' ),
);

$faqs = array(
	array( 3493, 4,
		'Claims against a city, county or state agency require written notice much sooner — as little as six months (O.C.G.A. § 36-33-5).',
		'Claims against a government require written notice much sooner: six months for a city (O.C.G.A. § 36-33-5) and twelve months for a county or the State (O.C.G.A. §§ 36-11-1, 50-21-26).' ),
);

$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'five-sweep-findings', 'mode' => $apply ? 'apply' : 'dry-run', 'bodies' => array(), 'faqs' => array() );

foreach ( $bodies as $b ) {
	list( $id, $from, $to ) = $b;
	$before = (string) $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d AND post_status = 'publish'", $id ) );
	$n      = substr_count( $before, $from );
	if ( 1 !== $n ) {
		fwrite( STDERR, "ABORT: {$id} body contains the sentence {$n} times, expected 1.\n" );
		exit( 1 );
	}
	$after                = str_replace( $from, $to, $before );
	$backup['bodies'][]   = array( 'ID' => $id, 'body_before' => $before, 'body_after' => $after );
	fwrite( STDERR, sprintf( "  %s %d body\n", $apply ? 'fixed' : 'would fix', $id ) );
	if ( $apply ) {
		$wpdb->update( $wpdb->posts, array( 'post_content' => $after ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
		$now = (string) $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
		if ( $now !== $after ) {
			fwrite( STDERR, "FAILED: body read-back mismatch on {$id}\n" );
			exit( 1 );
		}
		clean_post_cache( $id );
	}
}

foreach ( $faqs as $f ) {
	list( $id, $idx, $from, $to ) = $f;
	$before = get_post_meta( $id, '_roden_faqs', true );
	if ( ! is_array( $before ) || ! isset( $before[ $idx ]['answer'] ) || 1 !== substr_count( $before[ $idx ]['answer'], $from ) ) {
		fwrite( STDERR, "ABORT: {$id} _roden_faqs[{$idx}] does not contain the sentence exactly once.\n" );
		exit( 1 );
	}
	$after                     = $before;
	$after[ $idx ]['answer']   = str_replace( $from, $to, $before[ $idx ]['answer'] );
	$backup['faqs'][]          = array( 'ID' => $id, 'index' => $idx, 'faqs_before' => $before, 'faqs_after' => $after );
	fwrite( STDERR, sprintf( "  %s %d _roden_faqs[%d]\n", $apply ? 'fixed' : 'would fix', $id, $idx ) );
	if ( $apply ) {
		update_post_meta( $id, '_roden_faqs', wp_slash( $after ) );
		wp_cache_delete( $id, 'post_meta' );
		if ( get_post_meta( $id, '_roden_faqs', true ) !== $after ) {
			fwrite( STDERR, "FAILED: FAQ read-back mismatch on {$id}\n" );
			exit( 1 );
		}
		clean_post_cache( $id );
	}
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fwrite( STDERR, sprintf( "\n%s: %d bodies, %d FAQ\n", $apply ? 'Fixed' : 'Would fix', count( $bodies ), count( $faqs ) ) );
