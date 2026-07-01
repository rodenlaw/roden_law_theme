<?php
/**
 * Optimizer: reciprocal internal links from the firm-wide PRACTICE-AREA pillars
 * DOWN to the matching indexable SC statewide pillars (internal-linking audit
 * 2026-07-01, fix #1).
 *
 * Why: after the SC statewide pillars shipped, every SC pillar linked UP to its
 * generic practice-area page, but the practice-area pages sent nothing back — link
 * equity flowed one direction only. This appends one contextual, exact-match anchor
 * to each practice-area body (_roden_why_hire) pointing at its SC pillar, so the
 * silo links both ways and the SC head term gets an authority pass from the highest-
 * authority page in each cluster.
 *
 * Mechanism mirrors optimize-truck-pillar-18wheeler-link.php: the practice-area
 * template renders _roden_why_hire through the_content, so a real <a> renders. We
 * append one sentence with an exact-match anchor. Idempotent — the link itself is
 * the sentinel, so re-runs skip. Falls back to post_content when why_hire is empty.
 *
 * Car accident points at the PLURAL /south-carolina-car-accident-lawyers/ pillar
 * (audit fix #4). The singular /south-carolina-car-accident-lawyer/ is the noindex
 * PPC landing page, so we never link the practice-area page to that URL.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/optimize-pa-sc-pillar-backlinks.php
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$pa_post_type = post_type_exists( 'practice_area' ) ? 'practice_area' : 'practice-area';

// practice-area slug => [ SC pillar URL, exact-match anchor text ].
// NOTE: car accident points at the PLURAL indexable pillar (audit fix #4). The
// singular /south-carolina-car-accident-lawyer/ is the noindex PPC landing page.
$map = array(
    'personal-injury-lawyers' => array(
        '/south-carolina-personal-injury-lawyer/',
        'South Carolina personal injury lawyers',
    ),
    'car-accident-lawyers' => array(
        '/south-carolina-car-accident-lawyers/',
        'South Carolina car accident lawyers',
    ),
    'motorcycle-accident-lawyers' => array(
        '/south-carolina-motorcycle-accident-lawyer/',
        'South Carolina motorcycle accident lawyers',
    ),
    'truck-accident-lawyers' => array(
        '/south-carolina-truck-accident-lawyers/',
        'South Carolina truck accident lawyers',
    ),
    'workers-compensation-lawyers' => array(
        '/south-carolina-workers-compensation-lawyer/',
        'South Carolina workers&rsquo; compensation lawyers',
    ),
    'wrongful-death-lawyers' => array(
        '/south-carolina-wrongful-death-lawyer/',
        'South Carolina wrongful death lawyers',
    ),
);

$appended = 0;
$skipped  = 0;
$missing  = 0;

foreach ( $map as $pa_slug => $target ) {
    list( $url, $anchor ) = $target;
    $sentinel = 'href="' . $url . '"'; // idempotency sentinel: the link itself.

    $pa = get_page_by_path( $pa_slug, OBJECT, $pa_post_type );
    if ( ! $pa ) {
        WP_CLI::warning( "Practice-area '{$pa_slug}' not found — skipping." );
        $missing++;
        continue;
    }
    $pa_id = $pa->ID;

    // One contextual, SC-specific sentence with an exact-match anchor.
    $sentence = '<p>Serving South Carolina? Roden Law also maintains a dedicated <a href="'
        . $url . '">' . $anchor . '</a> page covering the deadlines, statutes, and '
        . 'comparative-fault rules specific to South Carolina.</p>';

    $why_hire = (string) get_post_meta( $pa_id, '_roden_why_hire', true );

    if ( '' !== $why_hire ) {
        if ( false !== strpos( $why_hire, $sentinel ) ) {
            WP_CLI::log( "'{$pa_slug}' _roden_why_hire already links to {$url} — skipping." );
            $skipped++;
        } else {
            update_post_meta( $pa_id, '_roden_why_hire', $why_hire . "\n" . $sentence );
            WP_CLI::success( "Appended SC-pillar backlink to '{$pa_slug}' body (_roden_why_hire) → {$url}." );
            $appended++;
        }
    } else {
        // Fallback: practice-area renders post_content when _roden_why_hire is empty.
        $content = (string) $pa->post_content;
        if ( false !== strpos( $content, $sentinel ) ) {
            WP_CLI::log( "'{$pa_slug}' post_content already links to {$url} — skipping." );
            $skipped++;
        } else {
            wp_update_post( array(
                'ID'           => $pa_id,
                'post_content' => $content . "\n" . $sentence,
            ) );
            WP_CLI::success( "Appended SC-pillar backlink to '{$pa_slug}' post_content (why_hire empty) → {$url}." );
            $appended++;
        }
    }
}

WP_CLI::log( '--- SUMMARY ---' );
WP_CLI::log( "Appended: {$appended}  Skipped (already linked): {$skipped}  Missing: {$missing}" );
WP_CLI::log( 'Car accident targets the plural indexable pillar (audit fix #4).' );
WP_CLI::log( 'Run seed-sc-pillar-car-accident.php FIRST so the plural pillar exists.' );
WP_CLI::log( 'Done.' );
