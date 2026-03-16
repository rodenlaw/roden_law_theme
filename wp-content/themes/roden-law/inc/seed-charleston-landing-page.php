<?php
/**
 * Seeder: Create the Charleston Car Accident Lawyer landing page.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-charleston-landing-page.php
 *
 * @package Roden_Law
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$slug = 'charleston-car-accident-lawyer';

// Check if page already exists.
$existing = get_posts( array(
    'post_type'   => 'page',
    'name'        => $slug,
    'post_status' => 'any',
    'numberposts' => 1,
) );

if ( ! empty( $existing ) ) {
    $page = $existing[0];
    WP_CLI::log( "Page already exists: \"{$page->post_title}\" (ID {$page->ID})" );
    // Ensure the template is assigned.
    $current_template = get_post_meta( $page->ID, '_wp_page_template', true );
    if ( $current_template !== 'templates/template-landing-charleston.php' ) {
        update_post_meta( $page->ID, '_wp_page_template', 'templates/template-landing-charleston.php' );
        WP_CLI::success( "Updated template assignment to Charleston Landing Page." );
    } else {
        WP_CLI::log( "Template already assigned correctly." );
    }
    return;
}

$page_id = wp_insert_post( array(
    'post_title'   => 'Charleston Car Accident Lawyers',
    'post_name'    => $slug,
    'post_type'    => 'page',
    'post_status'  => 'publish',
    'post_content' => '',
    'menu_order'   => 0,
), true );

if ( is_wp_error( $page_id ) ) {
    WP_CLI::error( 'Failed to create page: ' . $page_id->get_error_message() );
    return;
}

update_post_meta( $page_id, '_wp_page_template', 'templates/template-landing-charleston.php' );

WP_CLI::success( "Created page: \"Charleston Car Accident Lawyers\" (ID {$page_id}) at /{$slug}/" );
WP_CLI::log( "Template: Landing Page — Charleston" );
WP_CLI::log( "Run: wp rewrite flush" );
