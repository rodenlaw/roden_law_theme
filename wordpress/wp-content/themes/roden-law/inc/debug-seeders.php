<?php
/**
 * Wrapper: Include and run seeder scripts that fail with wp eval-file directly.
 *
 * Usage: wp eval-file wp-content/themes/roden-law/inc/debug-seeders.php
 *
 * Note: Some seeder scripts silently fail when run directly via wp eval-file
 * on WP Engine, but work fine when included from this wrapper. Keep this file
 * available for future seeders that exhibit the same behavior.
 *
 * @package Roden_Law
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

set_error_handler( function( $errno, $errstr, $errfile, $errline ) {
    WP_CLI::warning( "PHP Error [{$errno}]: {$errstr} in {$errfile}:{$errline}" );
    return true;
} );

// Add seeder filenames here:
$seeders = array(
    // 'seed-example-subtypes.php',
);

if ( empty( $seeders ) ) {
    WP_CLI::log( 'No seeders configured. Edit this file to add seeder filenames to the $seeders array.' );
    return;
}

foreach ( $seeders as $file ) {
    $path = __DIR__ . '/' . $file;
    if ( ! file_exists( $path ) ) {
        WP_CLI::warning( "File not found: {$file}" );
        continue;
    }
    WP_CLI::log( '' );
    WP_CLI::log( "=== Running: {$file} ===" );
    try {
        include $path;
    } catch ( \Throwable $e ) {
        WP_CLI::error( 'Exception in ' . $file . ': ' . $e->getMessage(), false );
    }
}

WP_CLI::log( '' );
WP_CLI::success( 'All seeders finished.' );
