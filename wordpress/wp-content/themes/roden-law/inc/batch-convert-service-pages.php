<?php
/**
 * ONE-TIME USE: Convert service/landing pages from post to page type.
 *
 * Run via WP-CLI:   wp eval-file wp-content/themes/roden-law/inc/batch-convert-service-pages.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$service_slugs = array(
    'blog-savannah-ppi-attorney',
    'blog-free-consultation-with-charleston-personal-injury-lawyer',
);

global $wpdb;

foreach ( $service_slugs as $slug ) {
    $post = get_page_by_path( $slug, OBJECT, 'post' );

    // Also check without blog- prefix (in case rename already ran)
    if ( ! $post ) {
        $clean_slug = preg_replace( '/^blog-/', '', $slug );
        $post = get_page_by_path( $clean_slug, OBJECT, 'post' );
    }

    if ( ! $post ) {
        $msg = "NOT FOUND: {$slug}";
        defined( 'WP_CLI' ) ? WP_CLI::warning( $msg ) : error_log( $msg );
        continue;
    }

    // Change post type to page
    $wpdb->update(
        $wpdb->posts,
        array( 'post_type' => 'page' ),
        array( 'ID' => $post->ID ),
        array( '%s' ),
        array( '%d' )
    );

    clean_post_cache( $post->ID );

    $msg = "Converted post {$post->ID} ({$slug}) from post → page";
    defined( 'WP_CLI' ) ? WP_CLI::success( $msg ) : error_log( $msg );
}
