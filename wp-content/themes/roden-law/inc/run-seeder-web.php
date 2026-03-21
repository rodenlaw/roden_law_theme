<?php
/**
 * Temporary web-callable seeder runner.
 *
 * Triggers the Spanish translation seeder via HTTPS when SSH is unavailable.
 * Protected by a one-time secret token. DELETE THIS FILE after use.
 *
 * Usage: https://rodenlawdev1.wpenginepowered.com/?roden_run_seeder=<token>
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// One-time secret — change or delete file after use
define( 'RODEN_SEEDER_TOKEN', 'xK9mP2vL7nQ4wR8j' );

add_action( 'init', function () {
    if ( ! isset( $_GET['roden_run_seeder'] ) ) {
        return;
    }

    if ( $_GET['roden_run_seeder'] !== RODEN_SEEDER_TOKEN ) {
        wp_die( 'Unauthorized.', 'Unauthorized', array( 'response' => 403 ) );
    }

    // Prevent timeout
    set_time_limit( 120 );

    // Capture output
    ob_start();

    // The seeder uses WP_CLI::log/success/warning — stub them for web context
    if ( ! class_exists( 'WP_CLI' ) ) {
        class WP_CLI {
            public static function log( $msg ) { echo esc_html( $msg ) . "\n"; }
            public static function success( $msg ) { echo '[SUCCESS] ' . esc_html( $msg ) . "\n"; }
            public static function warning( $msg ) { echo '[WARNING] ' . esc_html( $msg ) . "\n"; }
            public static function error( $msg ) { echo '[ERROR] ' . esc_html( $msg ) . "\n"; }
        }
    }

    // Run the seeder
    require_once get_template_directory() . '/inc/seed-spanish-translations.php';

    // Flush rewrite rules
    flush_rewrite_rules();
    echo "\n[SUCCESS] Rewrite rules flushed.\n";

    $output = ob_get_clean();

    // Output as plain text
    header( 'Content-Type: text/plain; charset=utf-8' );
    echo $output;
    exit;
});
