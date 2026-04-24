<?php
/**
 * Test seeder — minimal truck corridor test.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

WP_CLI::log( 'Test seeder starting...' );

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $graeham ? $graeham->ID : 0;
WP_CLI::log( $author_id ? "Author: Graeham C. Gillin (ID {$author_id})" : 'WARNING: Attorney not found.' );

$terms = array();
$t = term_exists( 'truck-accidents', 'practice_category' );
if ( ! $t ) {
    $t = wp_insert_term( 'Truck Accidents', 'practice_category', array( 'slug' => 'truck-accidents' ) );
}
$terms['truck-accidents'] = is_array( $t ) ? (int) $t['term_id'] : (int) $t;

$resources = array(
    array(
        'title'      => 'TEST Truck Corridor Page — Delete Me',
        'slug'       => 'test-truck-corridor-delete-me',
        'excerpt'    => 'Test page for truck corridor seeder. Delete after testing.',
        'categories' => array( 'truck-accidents' ),
        'content'    => <<<'HTML'
<h2>Test Page</h2>
<p>This is a test page to verify the truck corridor seeder works on WP Engine.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Is this a test?',
                'answer'   => 'Yes, this is a test page.',
            ),
        ),
    ),
);

$created = 0;
$skipped = 0;

foreach ( $resources as $r ) {
    $existing = get_page_by_path( $r['slug'], OBJECT, 'resource' );
    if ( $existing ) {
        WP_CLI::log( "SKIP: \"{$r['title']}\" already exists (ID {$existing->ID})" );
        $skipped++;
        continue;
    }

    $post_id = wp_insert_post( array(
        'post_type'    => 'resource',
        'post_title'   => $r['title'],
        'post_name'    => $r['slug'],
        'post_status'  => 'draft',
        'post_content' => $r['content'],
        'post_excerpt' => $r['excerpt'],
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "FAILED: \"{$r['title']}\" — " . $post_id->get_error_message() );
        continue;
    }

    update_post_meta( $post_id, '_roden_author_attorney', $author_id );
    update_post_meta( $post_id, '_roden_jurisdiction', 'sc' );

    if ( ! empty( $r['faqs'] ) ) {
        update_post_meta( $post_id, '_roden_faqs', $r['faqs'] );
    }

    WP_CLI::success( "CREATED: \"{$r['title']}\" (ID {$post_id}) → /resources/{$r['slug']}/" );
    $created++;
}

WP_CLI::log( "Done. Created: {$created} | Skipped: {$skipped}" );
