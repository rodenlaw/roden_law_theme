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
 * Inject "Resources" link into the primary/mobile nav.
 *
 * Appends after the last </li> in the menu (end of top-level items).
 * If "Blog" is found, inserts after it. Otherwise appends to the end
 * of the menu before the Contact item.
 */
add_filter( 'wp_nav_menu_items', 'roden_inject_resources_nav_link', 10, 2 );
function roden_inject_resources_nav_link( $items, $args ) {
    if ( 'primary' !== $args->theme_location && 'mobile' !== $args->theme_location ) {
        return $items;
    }

    // Don't add if already present.
    if ( false !== strpos( $items, '/resources/' ) ) {
        return $items;
    }

    $resources_link = '<li class="menu-item"><a href="' . esc_url( home_url( '/resources/' ) ) . '">Resources</a></li>';

    // Try to insert after a Blog link (any format).
    $blog_pattern = '/(<li[^>]*>\\s*<a[^>]*>[^<]*Blog[^<]*<\/a>\\s*<\/li>)/i';
    if ( preg_match( $blog_pattern, $items ) ) {
        $items = preg_replace( $blog_pattern, '$1' . "\n" . $resources_link, $items, 1 );
        return $items;
    }

    // Fallback: insert before the Contact menu item.
    $contact_pattern = '/(<li[^>]*>\\s*<a[^>]*>[^<]*Contact[^<]*<\/a>)/i';
    if ( preg_match( $contact_pattern, $items ) ) {
        $items = preg_replace( $contact_pattern, $resources_link . "\n" . '$1', $items, 1 );
        return $items;
    }

    // Last resort: append to end.
    $items .= "\n" . $resources_link;

    return $items;
}
