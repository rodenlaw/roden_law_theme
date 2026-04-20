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

/**
 * Inject "Resources" link into the About Us submenu of the primary nav.
 *
 * Works whether the menu is a WP admin-assigned menu or the fallback.
 * Appends the link after "Blog" inside the About Us sub-menu.
 */
add_filter( 'wp_nav_menu_items', 'roden_inject_resources_nav_link', 10, 2 );
function roden_inject_resources_nav_link( $items, $args ) {
    if ( 'primary' !== $args->theme_location && 'mobile' !== $args->theme_location ) {
        return $items;
    }

    $resources_link = '<li class="menu-item"><a href="' . esc_url( home_url( '/resources/' ) ) . '">Resources</a></li>';

    // Insert after the Blog link inside the About Us sub-menu.
    $blog_pattern = '/(<a[^>]*href="[^"]*\/blog\/[^"]*"[^>]*>Blog<\/a><\/li>)/i';
    if ( preg_match( $blog_pattern, $items ) ) {
        $items = preg_replace( $blog_pattern, '$1' . "\n" . '                ' . $resources_link, $items, 1 );
    }

    return $items;
}
