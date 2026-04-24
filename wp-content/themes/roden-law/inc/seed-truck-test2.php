<?php
/**
 * Test seeder 2 - one real resource from Myrtle Beach.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

WP_CLI::log( 'Test2 starting...' );

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $graeham ? $graeham->ID : 0;
WP_CLI::log( $author_id ? "Author ID {$author_id}" : 'No attorney' );

$terms = array();
$t = term_exists( 'truck-accidents', 'practice_category' );
if ( ! $t ) {
    $t = wp_insert_term( 'Truck Accidents', 'practice_category', array( 'slug' => 'truck-accidents' ) );
}
$terms['truck-accidents'] = is_array( $t ) ? (int) $t['term_id'] : (int) $t;

$content_501 = '<h2>Highway 501: The Grand Strand Most Dangerous Truck Corridor</h2>';
$content_501 .= '<p>Highway 501 is the primary commercial artery connecting Conway to Myrtle Beach and it is one of the most dangerous roads in Horry County for truck accidents.</p>';
$content_501 .= '<p>South Carolina recorded <strong>3,167 large truck crashes statewide in 2024</strong>.</p>';
$content_501 .= '<h2>Crash Hotspots on Highway 501</h2>';
$content_501 .= '<h3>Highway 501 &amp; Four Mile Road (Conway)</h3>';
$content_501 .= '<p>This intersection was ranked the <strong>highest priority for safety improvements</strong> by the SCDOT Highway Improvement Safety Program. With <strong>42 documented accidents since 2008, including 2 fatal crashes</strong>, this is ground zero for truck collisions.</p>';
$content_501 .= '<h2>Your Legal Rights</h2>';
$content_501 .= '<ul><li><strong>Statute of limitations:</strong> 3 years (S.C. Code 15-3-530)</li><li><strong>Comparative fault:</strong> Recovery if less than 51% at fault</li></ul>';
$content_501 .= '<h2>Free Consultation</h2>';
$content_501 .= '<p>Call <a href="tel:+18436121980">(843) 612-1980</a> for a free consultation.</p>';

$resources = array(
    array(
        'title'   => 'Highway 501 Truck Accidents: Conway to Myrtle Beach',
        'slug'    => 'highway-501-truck-accidents-conway-myrtle-beach',
        'excerpt' => 'Guide to truck accidents on Highway 501 between Conway and Myrtle Beach, South Carolina.',
        'content' => $content_501,
        'faqs'    => array(
            array(
                'question' => 'What are the most dangerous intersections on Highway 501?',
                'answer'   => 'The SCDOT ranked Highway 501 and Four Mile Road in Conway as the highest priority.',
            ),
        ),
    ),
);

$created = 0;
$skipped = 0;

foreach ( $resources as $r ) {
    $existing = get_page_by_path( $r['slug'], OBJECT, 'resource' );
    if ( $existing ) {
        WP_CLI::log( "SKIP: already exists (ID {$existing->ID})" );
        $skipped++;
        continue;
    }

    $post_id = wp_insert_post( array(
        'post_type'    => 'resource',
        'post_title'   => $r['title'],
        'post_name'    => $r['slug'],
        'post_status'  => 'publish',
        'post_content' => $r['content'],
        'post_excerpt' => $r['excerpt'],
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "FAILED: " . $post_id->get_error_message() );
        continue;
    }

    update_post_meta( $post_id, '_roden_author_attorney', $author_id );
    update_post_meta( $post_id, '_roden_jurisdiction', 'sc' );

    if ( ! empty( $r['faqs'] ) ) {
        update_post_meta( $post_id, '_roden_faqs', $r['faqs'] );
    }

    $term_ids = array( $terms['truck-accidents'] );
    wp_set_object_terms( $post_id, $term_ids, 'practice_category' );

    WP_CLI::success( "CREATED ID {$post_id}" );
    $created++;
}

WP_CLI::log( "Done. Created: {$created} | Skipped: {$skipped}" );
