<?php
/**
 * /car-accident-lawyers/government-vehicle-accident/ (post 4059) stated the South
 * Carolina Tort Claims Act wrongly. Found by the Columbia car legal sweep, L1
 * (data/facts/remediation-2026-09-28-columbia-car.md), which links here, as does
 * the live Charleston car page. Owner, 2026-09-28: "those have been reviewed.
 * publish them" (Graeham C. Gillin's review).
 *
 * - Body: "Claims must be filed with the appropriate governmental entity, and the
 *   entity has 180 days to investigate before a lawsuit can be filed" — the claim
 *   is optional and suit may be brought either way (§§ 15-78-80, 15-78-90(b)).
 * - Body: "For multiple entities, the total cap is $1.2 million per occurrence" —
 *   § 15-78-120 caps at $300,000 / $600,000 regardless of the number of agencies;
 *   the $1.2 million limits are for government-employed physicians and dentists.
 * - Body "Critical Deadlines", FAQ 5: no South Carolina deadline given, and FAQ 5
 *   said "the standard personal injury statute of limitations also applies",
 *   which § 15-78-110 displaces in South Carolina.
 * - Excerpt (the Article description) and FAQ 0: "strict notice" stated for both
 *   states; South Carolina has no notice requirement.
 *
 * Georgia and federal sentences are unchanged (Georgia is for its reviewer).
 * Body and excerpt: direct column write (post_modified untouched). FAQs:
 * update_post_meta( wp_slash() ). Exact-match once each; every write read back.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-government-vehicle-sctca.php > docs/backups/government-vehicle-sctca-2026-09-28.json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-government-vehicle-sctca.php > docs/backups/government-vehicle-sctca-2026-09-28.json
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply = isset( $args[0] ) && 'apply' === $args[0];
$id    = 4059;
global $wpdb;

$fields = array(
	'post_content' => array(
		array(
			'<li><strong>Filing requirements:</strong> Claims must be filed with the appropriate governmental entity, and the entity has 180 days to investigate before a lawsuit can be filed.</li>',
			'<li><strong>Filing requirements:</strong> Filing a verified claim with the agency is optional, and you may sue whether or not you file one. Suit must be brought within two years, or within three years if a verified claim was filed with the agency within one year (S.C. Code §§ 15-78-80, 15-78-110).</li>',
		),
		array(
			'<li><strong>Damage caps:</strong> Recovery against a single government entity is capped at $300,000 per claimant and $600,000 per occurrence. For multiple entities, the total cap is $1.2 million per occurrence.</li>',
			'<li><strong>Damage caps:</strong> Recovery is capped at $300,000 per person and $600,000 per occurrence, however many government entities are involved (S.C. Code § 15-78-120). The higher $1.2 million limits apply only when the harm was caused by a government-employed physician or dentist.</li>',
		),
		array(
			'can permanently bar your claim — even if the standard personal injury statute of limitations has not expired.',
			'can permanently bar your claim — even if the standard personal injury statute of limitations has not expired. In South Carolina, suit must be filed within two years, or three years if a verified claim is filed with the agency within one year (S.C. Code §§ 15-78-110, 15-78-80).',
		),
	),
	'post_excerpt' => array(
		array(
			'Our lawyers navigate sovereign immunity rules and strict notice deadlines to pursue your claim.',
			'Our lawyers handle the sovereign immunity rules, filing deadlines and, where they apply, notice requirements for your claim.',
		),
	),
);

$faqs = array(
	array( 0,
		'Strict notice and filing requirements apply.',
		'Georgia and federal claims have strict notice and filing requirements; South Carolina has a shorter filing deadline but no notice requirement.' ),
	array( 5,
		'federal claims must be filed within 2 years under the FTCA. The standard personal injury statute of limitations also applies.',
		'federal claims must be filed within 2 years under the FTCA. In South Carolina, suit must be filed within two years, or three years if a verified claim is filed with the agency within one year (S.C. Code §§ 15-78-110, 15-78-80).' ),
);

$row = $wpdb->get_row( $wpdb->prepare( "SELECT post_status, post_content, post_excerpt FROM {$wpdb->posts} WHERE ID = %d", $id ) );
if ( ! $row || 'publish' !== $row->post_status ) {
	fwrite( STDERR, "ABORT: {$id} is not published.\n" );
	exit( 1 );
}

$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'government-vehicle-sctca', 'mode' => $apply ? 'apply' : 'dry-run', 'ID' => $id );
$update = array();
foreach ( $fields as $col => $pairs ) {
	$before = (string) $row->$col;
	$after  = $before;
	foreach ( $pairs as $pr ) {
		if ( 1 !== substr_count( $after, $pr[0] ) ) {
			fwrite( STDERR, "ABORT: {$col} does not contain the sentence exactly once: " . substr( $pr[0], 0, 60 ) . "\n" );
			exit( 1 );
		}
		$after = str_replace( $pr[0], $pr[1], $after );
	}
	$backup[ $col ] = array( 'before' => $before, 'after' => $after );
	$update[ $col ] = $after;
	fwrite( STDERR, sprintf( "  %s %s (%d sentences)\n", $apply ? 'fixed' : 'would fix', $col, count( $pairs ) ) );
}

$fbefore = get_post_meta( $id, '_roden_faqs', true );
$fafter  = $fbefore;
foreach ( $faqs as $f ) {
	list( $idx, $from, $to ) = $f;
	if ( ! is_array( $fafter ) || ! isset( $fafter[ $idx ]['answer'] ) || 1 !== substr_count( $fafter[ $idx ]['answer'], $from ) ) {
		fwrite( STDERR, "ABORT: _roden_faqs[{$idx}] does not contain the sentence exactly once.\n" );
		exit( 1 );
	}
	$fafter[ $idx ]['answer'] = str_replace( $from, $to, $fafter[ $idx ]['answer'] );
	fwrite( STDERR, sprintf( "  %s _roden_faqs[%d]\n", $apply ? 'fixed' : 'would fix', $idx ) );
}
$backup['faqs'] = array( 'before' => $fbefore, 'after' => $fafter );

if ( $apply ) {
	$wpdb->update( $wpdb->posts, $update, array( 'ID' => $id ), array( '%s', '%s' ), array( '%d' ) );
	$now = $wpdb->get_row( $wpdb->prepare( "SELECT post_content, post_excerpt FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	if ( $now->post_content !== $update['post_content'] || $now->post_excerpt !== $update['post_excerpt'] ) {
		fwrite( STDERR, "FAILED: body/excerpt read-back mismatch\n" );
		exit( 1 );
	}
	update_post_meta( $id, '_roden_faqs', wp_slash( $fafter ) );
	wp_cache_delete( $id, 'post_meta' );
	if ( get_post_meta( $id, '_roden_faqs', true ) !== $fafter ) {
		fwrite( STDERR, "FAILED: FAQ read-back mismatch\n" );
		exit( 1 );
	}
	clean_post_cache( $id );
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fwrite( STDERR, sprintf( "\n%s: 3 body sentences, excerpt, 2 FAQ answers\n", $apply ? 'Fixed' : 'Would fix' ) );
