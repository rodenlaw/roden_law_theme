<?php
/**
 * Wrapper: Run all 4 remaining failing seeders via include.
 * wp eval-file wp-content/themes/roden-law/inc/debug-seeders.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

set_error_handler( function( $errno, $errstr, $errfile, $errline ) {
    WP_CLI::warning( "PHP Error [{$errno}]: {$errstr} in {$errfile}:{$errline}" );
    return true;
} );

$seeders = array(
    'seed-brain-injury-subtypes.php',
    'seed-spinal-cord-subtypes.php',
    'seed-premises-liability-subtypes.php',
    'seed-escooter-subtypes.php',
);

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
