<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Try inserting directly
$pa_post_type = 'practice_area';
if ( ! post_type_exists( $pa_post_type ) ) {
    $pa_post_type = 'practice-area';
}

echo "Using post type: {$pa_post_type}\n";

// Check what the seeder's get_posts finds
$existing = get_posts( array(
    'post_type'   => $pa_post_type,
    'name'        => 'e-bike-accident-lawyers',
    'post_parent' => 0,
    'post_status' => array( 'publish', 'draft', 'pending', 'private', 'trash' ),
    'numberposts' => 1,
) );
echo "Existing (seeder query): " . count( $existing ) . "\n";

// Try a broader search
global $wpdb;
$rows = $wpdb->get_results( "SELECT ID, post_type, post_name, post_status, post_parent FROM {$wpdb->posts} WHERE post_name = 'e-bike-accident-lawyers' LIMIT 10" );
echo "DB matches for slug 'e-bike-accident-lawyers': " . count( $rows ) . "\n";
foreach ( $rows as $r ) {
    echo "  ID={$r->ID} type={$r->post_type} status={$r->post_status} parent={$r->post_parent}\n";
}

// Try inserting a test post
$test_id = wp_insert_post( array(
    'post_type'    => $pa_post_type,
    'post_title'   => 'E-Bike Accident Lawyers TEST',
    'post_name'    => 'e-bike-accident-lawyers-test-delete-me',
    'post_content' => 'test',
    'post_status'  => 'draft',
    'post_parent'  => 0,
    'post_author'  => 1,
), true );

if ( is_wp_error( $test_id ) ) {
    echo "INSERT FAILED: " . $test_id->get_error_message() . "\n";
} else {
    echo "TEST INSERT OK: ID {$test_id}\n";
    wp_delete_post( $test_id, true );
    echo "Cleaned up test post\n";
}
