<?php
/**
 * Shared insert routine for the indexable SC statewide pillar seeders.
 *
 * Each seed-sc-pillar-*.php file defines these variables, then does:
 *   require __DIR__ . '/_sc-pillar-insert.php';
 *
 * Required vars from the caller:
 *   $slug, $title, $template, $practice, $meta_desc, $key_takeaways,
 *   $content (html), $faqs (array of ['question'=>, 'answer'=>])
 *
 * Creates the page as a DRAFT (publish gate: human review). Idempotent — if the
 * slug already exists, it back-fills the template + meta instead of duplicating.
 * SC-only: pins _roden_jurisdiction = 'SC' so no GA O.C.G.A. law bleeds in.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( empty( $slug ) || empty( $title ) || empty( $template ) ) {
    WP_CLI::error( '_sc-pillar-insert.php: missing required $slug / $title / $template.' );
    return;
}

$faqs          = isset( $faqs ) && is_array( $faqs ) ? $faqs : array();
$content       = isset( $content ) ? $content : '';
$meta_desc     = isset( $meta_desc ) ? $meta_desc : '';
$key_takeaways = isset( $key_takeaways ) ? $key_takeaways : '';
$practice      = isset( $practice ) ? $practice : '';

// Hard publish-gate guard: every pillar must carry Key Takeaways.
if ( '' === trim( (string) $key_takeaways ) ) {
    WP_CLI::error( "ABORT: \"{$title}\" has no _roden_key_takeaways — publish gate requires it." );
    return;
}

$existing = get_posts( array(
    'post_type'   => 'page',
    'name'        => $slug,
    'post_status' => 'any',
    'numberposts' => 1,
) );

if ( ! empty( $existing ) ) {
    $page_id = $existing[0]->ID;
    WP_CLI::log( "Page already exists: \"{$title}\" (ID {$page_id}) — back-filling template + meta." );
    wp_update_post( array(
        'ID'           => $page_id,
        'post_content' => $content,
        'post_excerpt' => $meta_desc,
    ) );
} else {
    $page_id = wp_insert_post( array(
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_type'    => 'page',
        'post_status'  => 'draft',
        'post_content' => $content,
        'post_excerpt' => $meta_desc,
        'menu_order'   => 0,
    ), true );

    if ( is_wp_error( $page_id ) ) {
        WP_CLI::warning( "FAILED to create \"{$title}\": " . $page_id->get_error_message() );
        return;
    }
    WP_CLI::success( "CREATED (DRAFT): \"{$title}\" (ID {$page_id}) → /{$slug}/" );
}

update_post_meta( $page_id, '_wp_page_template',      $template );
update_post_meta( $page_id, '_roden_pillar_practice', $practice );
update_post_meta( $page_id, '_roden_jurisdiction',    'SC' );
update_post_meta( $page_id, '_roden_key_takeaways',   $key_takeaways );
update_post_meta( $page_id, '_roden_meta_description', $meta_desc );
update_post_meta( $page_id, '_roden_faqs',            $faqs );

WP_CLI::log( '- ' . count( $faqs ) . ' FAQs, Key Takeaways set, template ' . $template . ', jurisdiction SC.' );
WP_CLI::log( 'Run after all pillars: wp rewrite flush' );
WP_CLI::log( 'Done.' );
