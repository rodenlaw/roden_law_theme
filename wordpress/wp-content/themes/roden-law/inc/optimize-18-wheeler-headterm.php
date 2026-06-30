<?php
/**
 * Optimizer: re-title the existing 18-Wheeler / Semi-Truck sub-type page to LEAD
 * with the head term "18-Wheeler Accident Lawyer" (SC competitor gap analysis
 * 2026-06-29, P0-3).
 *
 * Why: Roden ranks position 0 for "18 wheeler accident lawyer" (9,900/mo),
 * "18 wheeler accident attorney" (6,600/mo) and ~12 long-tail variants despite
 * owning the truck pillar. Root cause: the page H1/title-tag read "18-Wheeler /
 * Semi-Truck Accident Lawyers" — the slash dilutes the exact-match head term.
 * The theme derives both the H1 and the <title> tag from post_title (see
 * inc/seo-meta.php), and the sub-type template appends " in Georgia & South
 * Carolina", so re-titling fixes the H1, the title tag, and the breadcrumb.
 *
 * This is a re-title + meta-description optimization, NOT a rewrite — the page
 * body already has pillar-depth content. We also tighten the H1 emphasis inside
 * the body and set a head-term-rich meta description.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/optimize-18-wheeler-headterm.php
 *
 * Idempotent — safe to re-run. URL/slug is preserved (no redirect needed).
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$slug = '18-wheeler-semi-truck-accident';

// Resolve by slug (robust if the post ID ever changes).
$post = get_page_by_path( $slug, OBJECT, 'practice_area' );
if ( ! $post ) {
    // Fall back to the known ID from prior seeders.
    $post = get_post( 4063 );
}
if ( ! $post || 'practice_area' !== $post->post_type ) {
    WP_CLI::error( "18-wheeler sub-type page not found (slug '{$slug}' / ID 4063)." );
    return;
}

$post_id  = $post->ID;
$new_title = '18-Wheeler Accident Lawyers';

WP_CLI::log( "Target: \"{$post->post_title}\" (ID {$post_id}) — slug preserved /truck-accident-lawyers/{$slug}/" );

// 1) Re-title to lead with the exact head term (preserve the slug/URL).
if ( $post->post_title !== $new_title ) {
    $res = wp_update_post( array(
        'ID'         => $post_id,
        'post_title' => $new_title,
        // post_name intentionally NOT changed — keeps the URL stable, no redirect.
    ), true );
    if ( is_wp_error( $res ) ) {
        WP_CLI::error( 'Failed to re-title: ' . $res->get_error_message() );
        return;
    }
    WP_CLI::success( "Re-titled to \"{$new_title}\" (H1 + <title> + breadcrumb now lead with the head term)." );
} else {
    WP_CLI::log( 'Title already optimized — skipping re-title.' );
}

// 2) Tighten the leading body H2 so the on-page first heading also leads with the
//    head term (the template renders post_title as H1; this is the first body H2).
$content = $post->post_content;
$old_h2  = '<h2>18-Wheeler &amp; Semi-Truck Accident Lawyers Serving Georgia and South Carolina</h2>';
$new_h2  = '<h2>18-Wheeler Accident Lawyers Serving Georgia and South Carolina</h2>';
if ( false !== strpos( $content, $old_h2 ) ) {
    $content = str_replace( $old_h2, $new_h2, $content );
    wp_update_post( array( 'ID' => $post_id, 'post_content' => $content ) );
    WP_CLI::success( 'Updated leading body H2 to lead with "18-Wheeler Accident Lawyers".' );
} else {
    WP_CLI::log( 'Leading body H2 already optimized or not found — skipping.' );
}

// 3) Head-term-rich meta description (drives <title>/OG description via seo-meta.php).
$meta_desc = 'Injured in an 18-wheeler accident? Roden Law\'s 18-wheeler accident lawyers take on trucking companies and their insurers across Georgia and South Carolina. Free case review — no fees unless we win.';
update_post_meta( $post_id, '_roden_meta_description', $meta_desc );
WP_CLI::success( 'Set head-term-rich meta description.' );

// 4) Ensure the post excerpt also leads with the head term (used in cards/OG fallbacks).
$new_excerpt = 'Injured in an 18-wheeler accident in Georgia or South Carolina? Our 18-wheeler accident lawyers take on big trucking companies and their insurers to recover maximum compensation for crash victims.';
if ( $post->post_excerpt !== $new_excerpt ) {
    wp_update_post( array( 'ID' => $post_id, 'post_excerpt' => $new_excerpt ) );
    WP_CLI::success( 'Updated excerpt to lead with the head term.' );
}

WP_CLI::log( '--- NOTE ---' );
WP_CLI::log( 'Slug/URL unchanged (/truck-accident-lawyers/18-wheeler-semi-truck-accident/) — no redirect required.' );
WP_CLI::log( 'Pair with optimize-truck-pillar-18wheeler-link.php to surface the head term from the truck pillar H1 area.' );
WP_CLI::log( 'Done.' );
