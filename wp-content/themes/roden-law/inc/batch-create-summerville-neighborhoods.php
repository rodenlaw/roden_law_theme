<?php
/**
 * Batch Create Summerville Sub-Neighborhood Pages
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/batch-create-summerville-neighborhoods.php
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WP_CLI' ) ) {
    echo "This script must be run via WP-CLI: wp eval-file wp-content/themes/roden-law/inc/batch-create-summerville-neighborhoods.php\n";
    exit( 1 );
}

$data_file = get_template_directory() . '/inc/data/summerville-neighborhoods.json';
if ( ! file_exists( $data_file ) ) {
    WP_CLI::error( 'Data file not found: ' . $data_file );
    return;
}

$neighborhoods = json_decode( file_get_contents( $data_file ), true );
if ( ! is_array( $neighborhoods ) || empty( $neighborhoods ) ) {
    WP_CLI::error( 'Failed to parse neighborhood data or file is empty.' );
    return;
}

WP_CLI::log( sprintf( 'Found %d neighborhoods in data file.', count( $neighborhoods ) ) );

$parent = get_page_by_path( 'south-carolina/charleston/summerville', OBJECT, 'location' );
if ( ! $parent ) {
    WP_CLI::error( 'Summerville location page not found at path: south-carolina/charleston/summerville' );
    return;
}

WP_CLI::log( sprintf( 'Summerville parent page found: ID %d', $parent->ID ) );

$created = 0;
$skipped = 0;
$errors  = 0;

foreach ( $neighborhoods as $n ) {
    $existing = get_page_by_path( 'south-carolina/charleston/summerville/' . $n['slug'], OBJECT, 'location' );
    if ( $existing ) {
        WP_CLI::log( sprintf( 'SKIP: %s already exists (ID: %d)', $n['name'], $existing->ID ) );
        $skipped++;
        continue;
    }

    $post_content = '';
    if ( ! empty( $n['content_hook'] ) ) {
        $paragraphs = array_filter( array_map( 'trim', explode( "\n", $n['content_hook'] ) ) );
        $post_content = implode( "\n\n", array_map( function( $p ) { return '<p>' . $p . '</p>'; }, $paragraphs ) );
    }

    $post_id = wp_insert_post( array(
        'post_type'    => 'location',
        'post_title'   => $n['name'],
        'post_name'    => $n['slug'],
        'post_parent'  => $parent->ID,
        'post_status'  => 'draft',
        'post_content' => $post_content,
    ) );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( sprintf( 'FAIL: %s — %s', $n['name'], $post_id->get_error_message() ) );
        $errors++;
        continue;
    }

    update_post_meta( $post_id, '_roden_is_neighborhood', true );
    update_post_meta( $post_id, '_roden_parent_office_key', 'charleston' );
    update_post_meta( $post_id, '_roden_neighborhood_roads', $n['roads'] ?? '' );
    update_post_meta( $post_id, '_roden_neighborhood_hospitals', $n['hospitals'] ?? '' );
    update_post_meta( $post_id, '_roden_neighborhood_landmarks', $n['landmarks'] ?? '' );
    update_post_meta( $post_id, '_roden_neighborhood_service_area', $n['service_area'] ?? '' );
    update_post_meta( $post_id, '_roden_neighborhood_population', $n['population'] ?? '' );
    update_post_meta( $post_id, '_roden_neighborhood_court', $n['court'] ?? '' );

    if ( ! empty( $n['h1'] ) ) update_post_meta( $post_id, '_roden_neighborhood_h1', $n['h1'] );
    if ( ! empty( $n['priority'] ) ) update_post_meta( $post_id, '_roden_neighborhood_priority', $n['priority'] );
    if ( ! empty( $n['faqs'] ) && is_array( $n['faqs'] ) ) update_post_meta( $post_id, '_roden_faqs', $n['faqs'] );
    if ( ! empty( $n['meta_title'] ) ) {
        update_post_meta( $post_id, 'rank_math_title', $n['meta_title'] );
        update_post_meta( $post_id, '_yoast_wpseo_title', $n['meta_title'] );
    }
    if ( ! empty( $n['meta_description'] ) ) {
        update_post_meta( $post_id, 'rank_math_description', $n['meta_description'] );
        update_post_meta( $post_id, '_yoast_wpseo_metadesc', $n['meta_description'] );
    }

    WP_CLI::success( sprintf( 'CREATED: %s (ID: %d, Priority: %s)', $n['name'], $post_id, $n['priority'] ?? '?' ) );
    $created++;
}

WP_CLI::log( '' );
WP_CLI::success( sprintf( 'Batch complete! Created: %d | Skipped: %d | Errors: %d | Total: %d', $created, $skipped, $errors, count( $neighborhoods ) ) );

if ( $created > 0 ) {
    WP_CLI::log( '' );
    WP_CLI::log( 'All new pages are saved as DRAFTS. Review in WP admin, then publish.' );
    WP_CLI::log( '  wp rewrite flush' );
}
