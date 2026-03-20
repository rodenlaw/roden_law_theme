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

    // Google Fonts — loaded async via preload pattern (non-render-blocking)
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
        array(),
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
        array( 'strategy' => 'defer', 'in_footer' => true )
    );

    // Theme JS (FAQ accordion, smooth scroll, GA tracking, sticky header)
    wp_enqueue_script(
        'roden-theme',
        get_template_directory_uri() . '/assets/js/theme.js',
        array(),
        $theme_version,
        array( 'strategy' => 'defer', 'in_footer' => true )
    );
}

/* ==========================================================================
   PERFORMANCE: Preconnect, non-render-blocking fonts, deferred CSS
   ========================================================================== */

// Preload hero images (moved from WPCode snippet)
add_action( 'wp_head', 'roden_preload_hero_images', 1 );
function roden_preload_hero_images() {
    if ( ! is_front_page() ) {
        return;
    }
    $upload_dir = wp_get_upload_dir()['baseurl'];
    $theme_dir  = get_template_directory_uri();

    echo '<link rel="preload" as="image" href="' . esc_url( $upload_dir ) . '/assets/media/images/bg-hero-home-columns.webp" type="image/webp" media="(min-width: 768px)">' . "\n";
    echo '<link rel="preload" as="image" href="' . esc_url( $upload_dir ) . '/2025/02/bg-hero-home-columns_mobile.webp" type="image/webp" media="(max-width: 767px)">' . "\n";
    echo '<link rel="preload" as="image" href="' . esc_url( $theme_dir ) . '/assets/images/img-hero-eric-roden-2024-desktop.webp" type="image/webp" media="(min-width: 1199px)">' . "\n";
    echo '<link rel="preload" as="image" href="' . esc_url( $theme_dir ) . '/assets/images/img-hero-eric-roden-2024-tablet.webp" type="image/webp" media="(min-width: 768px)">' . "\n";
    echo '<link rel="preload" as="image" href="' . esc_url( $theme_dir ) . '/assets/images/img-hero-eric-roden-2024-mobile.webp" type="image/webp" media="(max-width: 767px)">' . "\n";
}

// Preconnect to Google Fonts domains
add_action( 'wp_head', 'roden_preconnect_hints', 1 );
function roden_preconnect_hints() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}

// Make Google Fonts non-render-blocking via media swap
add_filter( 'style_loader_tag', 'roden_async_google_fonts', 10, 4 );
function roden_async_google_fonts( $html, $handle, $href, $media ) {
    if ( 'roden-google-fonts' === $handle ) {
        // Preload + swap: loads font CSS without blocking render
        $html  = '<link rel="preload" as="style" href="' . esc_url( $href ) . '" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
        $html .= '<noscript><link rel="stylesheet" href="' . esc_url( $href ) . '"></noscript>' . "\n";
    }
    return $html;
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
