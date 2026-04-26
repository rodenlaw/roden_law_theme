<?php
/**
 * Update the truck accident landing page slug from truck-accident-lawyer
 * to south-carolina-truck-accident-lawyer.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/update-truck-landing-slug.php
 *
 * @package Roden_Law
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$old_slug = 'truck-accident-lawyer';
$new_slug = 'south-carolina-truck-accident-lawyer';

// Find existing page.
$pages = get_posts( array(
    'post_type'   => 'page',
    'name'        => $old_slug,
    'post_status' => 'any',
    'numberposts' => 1,
) );

if ( empty( $pages ) ) {
    // Maybe it was already renamed.
    $pages = get_posts( array(
        'post_type'   => 'page',
        'name'        => $new_slug,
        'post_status' => 'any',
        'numberposts' => 1,
    ) );
    if ( ! empty( $pages ) ) {
        WP_CLI::log( "Page already has the new slug: /{$new_slug}/ (ID {$pages[0]->ID})" );
        return;
    }
    WP_CLI::error( 'Page not found with either slug.' );
    return;
}

$page = $pages[0];
wp_update_post( array(
    'ID'        => $page->ID,
    'post_name' => $new_slug,
    'post_title' => 'South Carolina Truck Accident Lawyer',
) );

WP_CLI::success( "Updated page (ID {$page->ID}): /{$old_slug}/ → /{$new_slug}/" );
WP_CLI::log( "Run: wp rewrite flush" );
