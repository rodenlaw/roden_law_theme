<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

$pa_post_type = 'practice_area';
if ( ! post_type_exists( $pa_post_type ) ) {
    $pa_post_type = 'practice-area';
}
if ( ! post_type_exists( $pa_post_type ) ) {
    echo "NO POST TYPE FOUND\n";
    return;
}
echo "Post type: {$pa_post_type}\n";

$existing = get_posts( array(
    'post_type'   => $pa_post_type,
    'name'        => 'e-bike-accident-lawyers',
    'post_parent' => 0,
    'post_status' => array( 'publish', 'draft', 'pending', 'private', 'trash' ),
    'numberposts' => 1,
) );

echo "Existing count: " . count( $existing ) . "\n";
if ( ! empty( $existing ) ) {
    echo "Found ID: " . $existing[0]->ID . " Status: " . $existing[0]->post_status . " Type: " . $existing[0]->post_type . "\n";
}

$eric = get_page_by_path( 'eric-roden', OBJECT, 'attorney' );
echo "Eric: " . ( $eric ? $eric->ID : 'NOT FOUND' ) . "\n";
