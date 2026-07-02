<?php
/**
 * Seeder: SC Personal Injury FAQ hub v2 — expand to ~90 categorized questions.
 *
 * SC competitor gap analysis 2026-06-29, roadmap row 8 ("FAQ hub v2 — 80-120 Qs").
 * REPLACES the _roden_faqs meta on the existing hub (slug
 * south-carolina-personal-injury-faq) with the full categorized set from
 * data/sc-pi-faq-hub-v2.json. Category keys drive on-page <h3> grouping
 * (roden_faq_section) and all Q&As emit into the FAQPage schema.
 *
 * Idempotent — safe to re-run; it just re-writes the meta from the JSON.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-faq-hub-v2.php
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slug = 'south-carolina-personal-injury-faq';
$hub  = get_page_by_path( $slug, OBJECT, 'resource' );
if ( ! $hub ) {
	WP_CLI::error( "Hub \"{$slug}\" not found — run seed-resource-sc-faq-hub.php first." );
	return;
}

$json = file_get_contents( __DIR__ . '/data/sc-pi-faq-hub-v2.json' );
$faqs = json_decode( $json, true );
if ( ! is_array( $faqs ) || empty( $faqs ) ) {
	WP_CLI::error( 'sc-pi-faq-hub-v2.json is missing, invalid, or empty.' );
	return;
}

update_post_meta( $hub->ID, '_roden_faqs', $faqs );

// Light-touch intro refresh: mention the expanded, categorized coverage.
$intro = '<p>Below, Roden Law answers roughly ' . count( $faqs ) . ' of the most common <strong>South Carolina personal injury</strong> questions, grouped by topic &mdash; from filing deadlines and comparative fault to what your case is worth, insurance, medical bills, and specific accident types. These answers describe South Carolina law specifically and are a starting point, not legal advice for your situation.</p>';
$new_content = preg_replace( '/^\s*<p>.*?<\/p>/s', $intro, (string) $hub->post_content, 1 );
if ( $new_content && $new_content !== $hub->post_content ) {
	wp_update_post( array( 'ID' => $hub->ID, 'post_content' => $new_content ) );
}

WP_CLI::success( sprintf( 'Updated hub (ID %d, /resources/%s/): %d categorized FAQs written to _roden_faqs.', $hub->ID, $slug, count( $faqs ) ) );
