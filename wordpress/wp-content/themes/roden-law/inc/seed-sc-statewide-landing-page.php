<?php
/**
 * Seeder: Create the SC Statewide Car Accident Lawyer landing page.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-sc-statewide-landing-page.php
 *
 * @package Roden_Law
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$slug = 'south-carolina-car-accident-lawyer';

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
    if ( $current_template !== 'templates/template-landing-sc-statewide.php' ) {
        update_post_meta( $page->ID, '_wp_page_template', 'templates/template-landing-sc-statewide.php' );
        WP_CLI::success( "Updated template assignment to SC Statewide Landing Page." );
    } else {
        WP_CLI::log( "Template already assigned correctly." );
    }
    return;
}

$page_id = wp_insert_post( array(
    'post_title'   => 'South Carolina Car Accident Lawyers',
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

update_post_meta( $page_id, '_wp_page_template', 'templates/template-landing-sc-statewide.php' );

WP_CLI::success( "Created page: \"South Carolina Car Accident Lawyers\" (ID {$page_id}) at /{$slug}/" );
WP_CLI::log( "Template: Landing Page — SC Statewide" );
WP_CLI::log( "Run: wp rewrite flush" );
