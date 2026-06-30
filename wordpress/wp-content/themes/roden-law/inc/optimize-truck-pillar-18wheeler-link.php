<?php
/**
 * Optimizer: surface the "18-wheeler accident lawyer" head term from the TRUCK
 * PILLAR and pass an exact-match internal link down to the 18-wheeler sub-type
 * page (SC competitor gap analysis 2026-06-29, P0-3, pillar-side half).
 *
 * Companion to optimize-18-wheeler-headterm.php (which re-titles the sub-type).
 *
 * Why: the truck pillar (/practice-areas/truck-accident-lawyers/) is the highest-
 * authority page in the cluster. It already AUTO-LISTS its child sub-type pages
 * (template-practice-area.php $child_subtypes loop), so after the sub-type is
 * re-titled to "18-Wheeler Accident Lawyers" the head term already appears in that
 * list. This optimizer adds one extra exact-match anchor link inside the pillar's
 * body copy (_roden_why_hire) to reinforce the term-to-page match for
 * "18 wheeler accident lawyer" (9,900/mo) / "18 wheeler accident attorney" (6,600/mo).
 *
 * Mechanism: the pillar template renders _roden_why_hire through the_content
 * (template-practice-area.php line ~185), so a real <a> tag renders correctly.
 * We append one sentence with an exact-match HTML anchor. Idempotent — a sentinel
 * check prevents duplicate appends on re-run. The slug/URL is unchanged elsewhere.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/optimize-truck-pillar-18wheeler-link.php
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$pillar_slug = 'truck-accident-lawyers';
$subtype_url = '/truck-accident-lawyers/18-wheeler-semi-truck-accident/';
$sentinel    = 'href="' . $subtype_url . '"'; // idempotency sentinel: the link itself

$pillar = get_page_by_path( $pillar_slug, OBJECT, 'practice_area' );
if ( ! $pillar ) {
    WP_CLI::error( "Truck pillar '{$pillar_slug}' not found." );
    return;
}
$pillar_id = $pillar->ID;

// Build the exact-match anchor sentence (real HTML — rendered via the_content).
$anchor_sentence = '<p>The most catastrophic commercial-truck claims involve tractor-trailers and big rigs. Our <a href="' . $subtype_url . '">18-wheeler accident lawyers</a> handle these semi-truck cases specifically, taking on the trucking companies, their insurers, and every other liable party.</p>';

// Prefer the pillar body field the template actually renders (_roden_why_hire).
$why_hire = (string) get_post_meta( $pillar_id, '_roden_why_hire', true );

if ( '' !== $why_hire ) {
    if ( false !== strpos( $why_hire, $sentinel ) ) {
        WP_CLI::log( 'Pillar _roden_why_hire already links to the 18-wheeler page — skipping.' );
    } else {
        update_post_meta( $pillar_id, '_roden_why_hire', $why_hire . "\n" . $anchor_sentence );
        WP_CLI::success( 'Appended exact-match "18-wheeler accident lawyers" link to the truck pillar body (_roden_why_hire).' );
    }
} else {
    // Fallback: pillar renders post_content when _roden_why_hire is empty.
    $content = (string) $pillar->post_content;
    if ( false !== strpos( $content, $sentinel ) ) {
        WP_CLI::log( 'Pillar post_content already links to the 18-wheeler page — skipping.' );
    } else {
        wp_update_post( array(
            'ID'           => $pillar_id,
            'post_content' => $content . "\n" . $anchor_sentence,
        ) );
        WP_CLI::success( 'Appended exact-match "18-wheeler accident lawyers" link to the truck pillar post_content (why_hire was empty).' );
    }
}

WP_CLI::log( '--- NOTE ---' );
WP_CLI::log( 'The pillar already auto-lists the re-titled "18-Wheeler Accident Lawyers" sub-type via $child_subtypes.' );
WP_CLI::log( 'Run optimize-18-wheeler-headterm.php FIRST (re-titles the sub-type), then this file.' );
WP_CLI::log( 'Done.' );
