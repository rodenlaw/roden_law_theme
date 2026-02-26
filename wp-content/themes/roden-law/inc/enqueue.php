<?php
/**
 * Enqueue Styles & Scripts
 *
 * Extracted from functions.php — centralizes all front-end asset loading.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'roden_enqueue_assets' );
function roden_enqueue_assets() {
    $theme_version = wp_get_theme()->get( 'Version' );

    // Google Fonts
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
