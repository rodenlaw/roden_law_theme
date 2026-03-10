<?php
/**
 * Debug: Test why certain seeders produce no output.
 * wp eval-file wp-content/themes/roden-law/inc/debug-seeders.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( 'Debug script started.' );

// Check pillar posts exist
$slugs = array(
    'medical-malpractice-lawyers',
    'brain-injury-lawyers',
    'spinal-cord-injury-lawyers',
    'premises-liability-lawyers',
    'electric-scooter-accident-lawyers',
);

foreach ( $slugs as $slug ) {
    $p = get_page_by_path( $slug, OBJECT, 'practice_area' );
    if ( ! $p ) {
        $p = get_page_by_path( $slug, OBJECT, 'practice-area' );
    }
    if ( $p ) {
        WP_CLI::log( "FOUND: {$slug} => ID {$p->ID}, type {$p->post_type}" );
    } else {
        WP_CLI::warning( "MISSING: {$slug}" );
    }
}

// Check memory
WP_CLI::log( 'Memory: ' . round( memory_get_usage() / 1024 / 1024, 2 ) . 'MB / limit: ' . ini_get( 'memory_limit' ) );

WP_CLI::success( 'Debug complete.' );
