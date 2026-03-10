<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

global $wpdb;

// Check for any pages with truck-accident-lawyer in the slug
$results = $wpdb->get_results(
    "SELECT ID, post_name, post_status, post_type FROM {$wpdb->posts} WHERE post_name LIKE '%truck-accident-lawyer%' LIMIT 20"
);

WP_CLI::log( 'Posts with truck-accident-lawyer in slug:' );
foreach ( $results as $r ) {
    WP_CLI::log( "  ID {$r->ID} | {$r->post_name} | {$r->post_status} | {$r->post_type}" );
}

// Check for _wp_old_slug meta
$old_slugs = $wpdb->get_results(
    "SELECT post_id, meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_wp_old_slug' AND meta_value LIKE '%truck-accident-lawyer%'"
);

WP_CLI::log( '' );
WP_CLI::log( 'Old slug redirects:' );
foreach ( $old_slugs as $s ) {
    WP_CLI::log( "  Post {$s->post_id} | old slug: {$s->meta_value}" );
}

// Check WP Engine redirects table if it exists
$tables = $wpdb->get_results( "SHOW TABLES LIKE '%redirect%'" );
WP_CLI::log( '' );
WP_CLI::log( 'Redirect tables: ' . count( $tables ) );
foreach ( $tables as $t ) {
    $vals = get_object_vars( $t );
    WP_CLI::log( '  ' . reset( $vals ) );
}

WP_CLI::success( 'Debug done.' );
