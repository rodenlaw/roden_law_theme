<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

$pa_post_type = 'practice_area';
if ( ! post_type_exists( $pa_post_type ) ) {
    $pa_post_type = 'practice-area';
}

echo "Post type: {$pa_post_type}\n";

$eric = get_page_by_path( 'eric-roden', OBJECT, 'attorney' );
$author_attorney_id = $eric ? $eric->ID : 0;
echo "Eric ID: {$author_attorney_id}\n";

$post_id = wp_insert_post( array(
    'post_type'    => $pa_post_type,
    'post_title'   => 'E-Bike Accident Lawyers',
    'post_name'    => 'e-bike-accident-lawyers',
    'post_content' => '<h2>E-Bike Accident Lawyers Serving Georgia &amp; South Carolina</h2><p>Test content.</p>',
    'post_excerpt' => 'Test excerpt for e-bike accident lawyers.',
    'post_status'  => 'publish',
    'post_parent'  => 0,
    'post_author'  => 1,
), true );

if ( is_wp_error( $post_id ) ) {
    echo "INSERT FAILED: " . $post_id->get_error_message() . "\n";
} else {
    echo "CREATED ID: {$post_id}\n";

    update_post_meta( $post_id, '_roden_jurisdiction', 'both' );
    update_post_meta( $post_id, '_roden_sol_ga', 'O.C.G.A. § 9-3-33' );
    update_post_meta( $post_id, '_roden_sol_sc', 'S.C. Code § 15-3-530' );
    if ( $author_attorney_id ) {
        update_post_meta( $post_id, '_roden_author_attorney', $author_attorney_id );
    }
    echo "Meta set OK\n";
}
