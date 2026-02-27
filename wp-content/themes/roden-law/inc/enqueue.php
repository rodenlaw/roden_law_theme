<?php
/**
 * Enqueue Styles & Scripts
 *
 * Front-end: Google Fonts, style.css, theme.css, navigation.js, theme.js
 * Admin: admin.css + admin.js on CPT edit screens for meta box UI
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   FRONT-END ASSETS
   ========================================================================== */

add_action( 'wp_enqueue_scripts', 'roden_enqueue_assets' );
function roden_enqueue_assets() {
    $theme_version = wp_get_theme()->get( 'Version' );

    // Google Fonts — Merriweather (headings) + Inter (body)
    wp_enqueue_style(
        'roden-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Merriweather:wght@700;800;900&display=swap',
        array(),
        null
    );

    // Main stylesheet (theme header + design tokens)
    wp_enqueue_style(
        'roden-style',
        get_stylesheet_uri(),
        array( 'roden-google-fonts' ),
        $theme_version
    );

    // Theme component & layout styles
    wp_enqueue_style(
        'roden-theme',
        get_template_directory_uri() . '/assets/css/theme.css',
        array( 'roden-style' ),
        $theme_version
    );

    // Mobile navigation toggle
    wp_enqueue_script(
        'roden-navigation',
        get_template_directory_uri() . '/js/navigation.js',
        array(),
        $theme_version,
        true
    );

    // Theme JS (FAQ accordion, smooth scroll, GA tracking, sticky header)
    wp_enqueue_script(
        'roden-theme',
        get_template_directory_uri() . '/assets/js/theme.js',
        array(),
        $theme_version,
        true
    );
}

/* ==========================================================================
   ADMIN ASSETS — Meta box UI (repeaters, conditional fields)
   ========================================================================== */

add_action( 'admin_enqueue_scripts', 'roden_enqueue_admin_assets' );
function roden_enqueue_admin_assets( $hook ) {
    // Only load on post edit/new screens
    if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
        return;
    }

    $theme_version = wp_get_theme()->get( 'Version' );

    // Admin CSS for meta box styling
    $admin_css = get_template_directory() . '/assets/css/admin.css';
    if ( file_exists( $admin_css ) ) {
        wp_enqueue_style(
            'roden-admin',
            get_template_directory_uri() . '/assets/css/admin.css',
            array(),
            $theme_version
        );
    }

    // Admin JS for repeater fields (FAQs, education, awards)
    wp_enqueue_script(
        'roden-admin',
        get_template_directory_uri() . '/js/admin.js',
        array( 'jquery' ),
        $theme_version,
        true
    );
}
