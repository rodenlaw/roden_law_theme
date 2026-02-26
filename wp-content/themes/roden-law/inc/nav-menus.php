<?php
/**
 * Navigation Menus
 *
 * Extracted from functions.php — registers theme nav menu locations.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'roden_register_nav_menus' );
function roden_register_nav_menus() {
    register_nav_menus( array(
        'primary' => __( 'Primary Navigation', 'roden-law' ),
        'footer'  => __( 'Footer Navigation', 'roden-law' ),
        'mobile'  => __( 'Mobile Navigation', 'roden-law' ),
    ) );
}
