<?php
/**
 * Create 4 verified case_result CPT posts.
 *
 * Usage:  wp eval-file wp-content/themes/roden-law/create-case-results.php
 *
 * Idempotent — skips posts whose title already exists.
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	echo "This script must be run via WP-CLI: wp eval-file wp-content/themes/roden-law/create-case-results.php\n";
	exit( 1 );
}

$results = array(
	array(
		'title'  => 'Truck Accident',
		'amount' => '$27,000,000',
		'type'   => 'Settlement',
		'desc'   => 'Client paralyzed in collision with commercial semi-truck.',
	),
	array(
		'title'  => 'Product Liability',
		'amount' => '$10,860,000',
		'type'   => 'Verdict',
		'desc'   => 'Defective product caused catastrophic injury.',
	),
	array(
		'title'  => 'Premises Liability',
		'amount' => '$9,800,000',
		'type'   => 'Recovery',
		'desc'   => 'Client suffered severe injury due to negligent property maintenance.',
	),
	array(
		'title'  => 'Auto Accident',
		'amount' => '$3,000,000',
		'type'   => 'Settlement',
		'desc'   => 'Wrongful death — surviving spouse of auto accident victim.',
	),
);

$created = 0;
$skipped = 0;

echo "\n=== Creating Case Result Posts ===\n\n";

foreach ( $results as $r ) {
	// Check if a case_result with this title already exists.
	$existing = get_posts( array(
		'post_type'   => 'case_result',
		'title'       => $r['title'],
		'post_status' => 'any',
		'numberposts' => 1,
	) );

	if ( ! empty( $existing ) ) {
		echo "[SKIP] \"{$r['title']}\" already exists (ID {$existing[0]->ID}).\n";
		$skipped++;
		continue;
	}

	$post_id = wp_insert_post( array(
		'post_type'   => 'case_result',
		'post_title'  => $r['title'],
		'post_status' => 'publish',
		'post_name'   => sanitize_title( $r['title'] ),
	), true );

	if ( is_wp_error( $post_id ) ) {
		echo "[ERROR] Failed to create \"{$r['title']}\": " . $post_id->get_error_message() . "\n";
		continue;
	}

	update_post_meta( $post_id, '_roden_case_amount', $r['amount'] );
	update_post_meta( $post_id, '_roden_case_type', $r['type'] );
	update_post_meta( $post_id, '_roden_description', $r['desc'] );

	echo "[OK] Created \"{$r['title']}\" (ID {$post_id}) — {$r['amount']} {$r['type']}\n";
	$created++;
}

echo "\nDone: {$created} created, {$skipped} skipped.\n";
