<?php
/**
 * Seed script: Create the Georgia Car Accident landing page.
 *
 * Usage (on WP Engine):
 *   wp eval-file wp-content/themes/roden-law/inc/seed-ga-landing.php
 */

defined( 'ABSPATH' ) || exit;

$page_id = wp_insert_post( array(
    'post_type'     => 'page',
    'post_title'    => 'Georgia Car Accident Lawyer',
    'post_name'     => 'georgia-car-accident-lawyer',
    'post_status'   => 'publish',
    'page_template' => 'templates/template-landing-ga-car-accident.php',
) );

if ( is_wp_error( $page_id ) ) {
    WP_CLI::error( $page_id->get_error_message() );
} else {
    WP_CLI::success( "Created page ID: $page_id" );
}
