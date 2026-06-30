<?php
/**
 * Optimizer: capture the "motorcycle crash lawyer" (5,400/mo) and
 * "motorcycle wreck lawyer" (1,600/mo) head-term phrasings on the MOTORCYCLE
 * PILLAR (SC competitor gap analysis 2026-06-29, P0-3 second half — the
 * motorcycle mirror of the 18-wheeler treatment).
 *
 * Why not re-title the pillar H1? The pillar H1/title must keep the dominant
 * "Motorcycle Accident Lawyers" phrasing. Roden ranks pos 0 for the "crash" and
 * "wreck" synonyms despite owning the cluster because those exact phrasings do
 * not appear on the page. So instead of changing the H1, this optimizer:
 *   1) Adds a synonym-rich sentence to the pillar body (_roden_why_hire) that
 *      uses "motorcycle crash lawyers" and "motorcycle wreck lawyers" naturally,
 *      with an exact-match internal link UP to the new indexable SC statewide
 *      motorcycle pillar (/south-carolina-motorcycle-accident-lawyer/).
 *   2) Sets a head-term-rich meta description that includes the crash/wreck
 *      synonyms (drives <title>/OG description via seo-meta.php).
 *
 * Mirrors optimize-truck-pillar-18wheeler-link.php exactly (same mechanism:
 * _roden_why_hire renders via the_content; sentinel-guarded idempotency).
 * The slug/URL is unchanged — no redirect required.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/optimize-motorcycle-crash-wreck.php
 *
 * Idempotent — safe to re-run.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$pillar_slug = 'motorcycle-accident-lawyers';
$sc_pillar   = '/south-carolina-motorcycle-accident-lawyer/';
$sentinel    = 'href="' . $sc_pillar . '"'; // idempotency sentinel: the link itself

$pillar = get_page_by_path( $pillar_slug, OBJECT, 'practice_area' );
if ( ! $pillar ) {
    WP_CLI::error( "Motorcycle pillar '{$pillar_slug}' not found." );
    return;
}
$pillar_id = $pillar->ID;

// Synonym-rich sentence with an exact-match anchor (real HTML — rendered via
// the_content). Naturally uses "motorcycle crash lawyers" + "motorcycle wreck
// lawyers" so the page matches those head-term phrasings.
$anchor_sentence = '<p>Whether you call it a motorcycle accident, a motorcycle crash, or a motorcycle wreck, our motorcycle crash lawyers and motorcycle wreck lawyers handle them all &mdash; fighting the insurer bias that riders face. If your crash happened in South Carolina, see our <a href="' . $sc_pillar . '">South Carolina motorcycle accident lawyers</a> page for state-specific guidance.</p>';

// 1) Append the synonym sentence + exact-match link to the pillar body.
$why_hire = (string) get_post_meta( $pillar_id, '_roden_why_hire', true );

if ( '' !== $why_hire ) {
    if ( false !== strpos( $why_hire, $sentinel ) ) {
        WP_CLI::log( 'Pillar _roden_why_hire already links to the SC motorcycle pillar — skipping body edit.' );
    } else {
        update_post_meta( $pillar_id, '_roden_why_hire', $why_hire . "\n" . $anchor_sentence );
        WP_CLI::success( 'Appended "motorcycle crash/wreck lawyers" synonym sentence + exact-match link to the motorcycle pillar body (_roden_why_hire).' );
    }
} else {
    $content = (string) $pillar->post_content;
    if ( false !== strpos( $content, $sentinel ) ) {
        WP_CLI::log( 'Pillar post_content already links to the SC motorcycle pillar — skipping body edit.' );
    } else {
        wp_update_post( array(
            'ID'           => $pillar_id,
            'post_content' => $content . "\n" . $anchor_sentence,
        ) );
        WP_CLI::success( 'Appended synonym sentence + exact-match link to the motorcycle pillar post_content (why_hire was empty).' );
    }
}

// 2) Head-term-rich meta description including the crash/wreck synonyms.
$meta_desc = 'Injured in a motorcycle crash? Roden Law\'s motorcycle accident, crash, and wreck lawyers fight insurer bias and recover maximum compensation across Georgia and South Carolina. Free case review — no fee unless we win.';
update_post_meta( $pillar_id, '_roden_meta_description', $meta_desc );
WP_CLI::success( 'Set head-term-rich meta description (includes "motorcycle crash" / "wreck" synonyms).' );

WP_CLI::log( '--- NOTE ---' );
WP_CLI::log( 'Pillar H1/slug unchanged (keeps dominant "Motorcycle Accident Lawyers") — no redirect required.' );
WP_CLI::log( 'Run AFTER seed-sc-pillar-motorcycle.php so the linked SC pillar exists.' );
WP_CLI::log( 'Done.' );
