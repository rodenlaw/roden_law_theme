<?php
/**
 * Debug: Wrap failing seeder in try-catch with error handler.
 * wp eval-file wp-content/themes/roden-law/inc/debug-seeders.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Catch all errors
set_error_handler( function( $errno, $errstr, $errfile, $errline ) {
    WP_CLI::warning( "PHP Error [{$errno}]: {$errstr} in {$errfile}:{$errline}" );
    return true;
} );

register_shutdown_function( function() {
    $error = error_get_last();
    if ( $error && in_array( $error['type'], array( E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR ) ) ) {
        echo "FATAL ERROR: {$error['message']} in {$error['file']}:{$error['line']}\n";
    }
} );

WP_CLI::log( 'Loading medical malpractice seeder via include...' );

try {
    include __DIR__ . '/seed-medical-malpractice-subtypes.php';
} catch ( \Throwable $e ) {
    WP_CLI::error( 'Exception: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine() );
}

WP_CLI::success( 'Wrapper finished.' );
