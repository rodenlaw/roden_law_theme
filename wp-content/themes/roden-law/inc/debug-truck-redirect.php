<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

global $wpdb;

// 1. Check SmartCrawl redirects
$table = $wpdb->prefix . 'smartcrawl_redirects';
$rows = $wpdb->get_results( "SELECT * FROM {$table}" );
WP_CLI::log( "SmartCrawl redirects (" . count( $rows ) . " total):" );
foreach ( $rows as $r ) {
    if ( stripos( $r->source, 'truck' ) !== false || stripos( $r->destination, 'truck' ) !== false ) {
        WP_CLI::log( "  [{$r->id}] {$r->source} => {$r->destination} (type: {$r->type})" );
    }
}

// 2. Check if old slug still exists anywhere
$post_1631 = get_post( 1631 );
WP_CLI::log( '' );
WP_CLI::log( "Post 1631 slug: " . ( $post_1631 ? $post_1631->post_name : 'NOT FOUND' ) );
WP_CLI::log( "Post 1631 status: " . ( $post_1631 ? $post_1631->post_status : 'N/A' ) );

// 3. Check _wp_old_slug for any post
$old_slugs = $wpdb->get_results(
    "SELECT post_id, meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_wp_old_slug' AND meta_value LIKE '%truck-accident-lawyer%'"
);
WP_CLI::log( '' );
WP_CLI::log( "Old slug redirects (" . count( $old_slugs ) . "):" );
foreach ( $old_slugs as $s ) {
    WP_CLI::log( "  Post {$s->post_id}: {$s->meta_value}" );
}

// 4. Check post 4230
$post_4230 = get_post( 4230 );
WP_CLI::log( '' );
WP_CLI::log( "Post 4230 slug: " . ( $post_4230 ? $post_4230->post_name : 'NOT FOUND' ) );
WP_CLI::log( "Post 4230 status: " . ( $post_4230 ? $post_4230->post_status : 'N/A' ) );
WP_CLI::log( "Post 4230 template: " . get_post_meta( 4230, '_wp_page_template', true ) );

// 5. Check WP Engine redirect options
$wpe_redirects = get_option( 'wpe_redirects', array() );
WP_CLI::log( '' );
WP_CLI::log( "WP Engine redirects option: " . ( empty( $wpe_redirects ) ? 'empty' : print_r( $wpe_redirects, true ) ) );

// 6. Check Rank Math redirects
$rm_table = $wpdb->prefix . 'rank_math_redirections';
$rm_exists = $wpdb->get_var( "SHOW TABLES LIKE '{$rm_table}'" );
if ( $rm_exists ) {
    $rm_rows = $wpdb->get_results( "SELECT * FROM {$rm_table} WHERE sources LIKE '%truck%'" );
    WP_CLI::log( '' );
    WP_CLI::log( "Rank Math redirects: " . count( $rm_rows ) );
    foreach ( $rm_rows as $r ) {
        WP_CLI::log( "  {$r->sources} => {$r->url_to}" );
    }
}

WP_CLI::success( 'Done.' );
