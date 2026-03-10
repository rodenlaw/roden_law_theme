<?php
/**
 * Fix: Change slug of old draft post 1631 (truck-accident-lawyer) to avoid
 * conflicting with the new landing page at /south-carolina-truck-accident-lawyer/.
 *
 * wp eval-file wp-content/themes/roden-law/inc/debug-truck-redirect.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Rename old draft post 1631 so its slug doesn't capture traffic.
$old_post = get_post( 1631 );
if ( $old_post && $old_post->post_name === 'truck-accident-lawyer' ) {
    wp_update_post( array(
        'ID'        => 1631,
        'post_name' => 'truck-accident-lawyer-old-draft',
    ) );
    WP_CLI::success( "Renamed post 1631 slug: truck-accident-lawyer → truck-accident-lawyer-old-draft" );
} else {
    WP_CLI::log( "Post 1631 slug is already: " . ( $old_post ? $old_post->post_name : 'NOT FOUND' ) );
}

// Also check SmartCrawl redirects table for any relevant redirects.
global $wpdb;
$sc_redirects = $wpdb->get_results(
    "SELECT * FROM {$wpdb->prefix}smartcrawl_redirects WHERE source LIKE '%truck-accident-lawyer%' OR destination LIKE '%truck-accident-lawyer%' LIMIT 10"
);
if ( ! empty( $sc_redirects ) ) {
    WP_CLI::log( 'SmartCrawl redirects found:' );
    foreach ( $sc_redirects as $r ) {
        WP_CLI::log( "  {$r->source} → {$r->destination}" );
    }
} else {
    WP_CLI::log( 'No SmartCrawl redirects matching truck-accident-lawyer.' );
}

WP_CLI::success( 'Done.' );
