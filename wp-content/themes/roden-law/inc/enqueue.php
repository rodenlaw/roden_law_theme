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
    $min           = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

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
        get_template_directory_uri() . '/assets/css/theme' . $min . '.css',
        array( 'roden-style' ),
        $theme_version
    );

    // Mobile navigation toggle
    wp_enqueue_script(
        'roden-navigation',
        get_template_directory_uri() . '/js/navigation' . $min . '.js',
        array(),
        $theme_version,
        array( 'strategy' => 'defer', 'in_footer' => true )
    );

    // Theme JS (FAQ accordion, smooth scroll, sticky header)
    wp_enqueue_script(
        'roden-theme',
        get_template_directory_uri() . '/assets/js/theme' . $min . '.js',
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
    // Homepage: preload background + founder images.
    if ( is_front_page() ) {
        $upload_dir = wp_get_upload_dir()['baseurl'];
        $theme_dir  = get_template_directory_uri();

        echo '<link rel="preload" as="image" href="' . esc_url( $upload_dir ) . '/assets/media/images/bg-hero-home-columns.webp" type="image/webp" media="(min-width: 768px)">' . "\n";
        echo '<link rel="preload" as="image" href="' . esc_url( $upload_dir ) . '/2025/02/bg-hero-home-columns_mobile.webp" type="image/webp" media="(max-width: 767px)">' . "\n";
        echo '<link rel="preload" as="image" href="' . esc_url( $theme_dir ) . '/assets/images/img-hero-eric-roden-2024-desktop.webp" type="image/webp" media="(min-width: 1199px)">' . "\n";
        echo '<link rel="preload" as="image" href="' . esc_url( $theme_dir ) . '/assets/images/img-hero-eric-roden-2024-tablet.webp" type="image/webp" media="(min-width: 768px)">' . "\n";
        echo '<link rel="preload" as="image" href="' . esc_url( $theme_dir ) . '/assets/images/img-hero-eric-roden-2024-mobile.webp" type="image/webp" media="(max-width: 767px)">' . "\n";
        return;
    }

    // Interior pages: preload featured image (LCP candidate).
    if ( is_singular( array( 'practice_area', 'location', 'attorney', 'post' ) ) && has_post_thumbnail() ) {
        $img_id  = get_post_thumbnail_id();
        $img_src = wp_get_attachment_image_url( $img_id, 'large' );
        if ( $img_src ) {
            echo '<link rel="preload" as="image" href="' . esc_url( $img_src ) . '">' . "\n";
        }
    }
}

// Preconnect to Google Fonts domains
add_action( 'wp_head', 'roden_preconnect_hints', 1 );
function roden_preconnect_hints() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}

// Google Fonts: use media="print" swap to load non-render-blocking without inline JS.
// The &display=swap in the URL handles FOUT; this avoids CSP issues from onload handlers.
add_filter( 'style_loader_tag', 'roden_async_google_fonts', 10, 4 );
function roden_async_google_fonts( $html, $handle, $href, $media ) {
    if ( 'roden-google-fonts' === $handle ) {
        $html  = '<link rel="stylesheet" href="' . esc_url( $href ) . '" media="print" onload="this.media=\'all\'" crossorigin>' . "\n";
        $html .= '<noscript><link rel="stylesheet" href="' . esc_url( $href ) . '"></noscript>' . "\n";
    }
    return $html;
}

/* ==========================================================================
   CRITICAL CSS — Inline above-the-fold styles to reduce LCP
   ========================================================================== */

add_action( 'wp_head', 'roden_critical_css', 2 );
function roden_critical_css() {
    ?>
    <style id="roden-critical-css">
    :root{--navy:#013046;--navy-dark:#001a2e;--orange:#FCB415;--orange-dark:#D49B00;--orange-text:#B8860B;--light:#F8F6F2;--white:#fff;--gray-200:#e0e0e0;--gray-500:#717171;--text-primary:#333;--text-light:#aab4c8;--font-serif:'Merriweather',Georgia,serif;--font-sans:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;--radius:8px;--shadow:0 2px 16px rgba(0,0,0,.08);--container:960px;--container-lg:1140px;--transition:all .2s ease}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    html{font-size:16px;scroll-padding-top:140px}
    body{font-family:var(--font-sans);color:var(--text-primary);line-height:1.7;background:var(--white)}
    img{max-width:100%;height:auto;display:block}
    h1,h2,h3{font-family:var(--font-serif);font-weight:800;line-height:1.25;color:var(--navy)}
    .container{max-width:var(--container);margin:0 auto;padding:0 24px}
    .screen-reader-text{clip:rect(1px,1px,1px,1px);position:absolute;height:1px;width:1px;overflow:hidden}
    .top-bar{background:var(--navy-dark);color:var(--text-light);font-size:12px;border-bottom:1px solid rgba(255,255,255,.1);transition:transform .3s ease,opacity .2s ease}
    .top-bar-inner{display:flex;justify-content:space-between;align-items:center;padding:8px 24px;max-width:var(--container-lg);margin:0 auto}
    .top-bar-hidden{transform:translateY(-100%);opacity:0;pointer-events:none}
    .site-header{background:var(--white);border-bottom:3px solid var(--orange);position:sticky;top:0;z-index:50;box-shadow:var(--shadow);transition:box-shadow .3s ease}
    .header-inner{display:flex;align-items:center;justify-content:space-between;padding:0 24px;height:72px;max-width:var(--container-lg);margin:0 auto}
    .site-brand{display:flex;align-items:center;gap:10px;flex-shrink:0}
    .site-brand a{text-decoration:none;display:flex;align-items:center;gap:10px}
    .site-brand img,.custom-logo-link img,.custom-logo{max-height:48px;width:auto;display:block;height:auto}
    .brand-name{font-weight:800;font-size:18px;color:var(--navy);letter-spacing:-.3px;font-family:var(--font-serif);display:block;line-height:1.2}
    .nav-menu{list-style:none;display:flex;gap:6px;margin:0;padding:0}
    .nav-menu li a{display:block;padding:8px 14px;font-size:13px;font-weight:600;color:var(--navy);border-bottom:2px solid transparent;transition:var(--transition)}
    .hero{background:var(--navy);color:var(--white);padding:64px 0 56px;position:relative;overflow:hidden}
    .hero-title{font-size:clamp(28px,4vw,44px);font-weight:900;margin-bottom:16px;color:var(--white)}
    .hero p{font-size:17px;line-height:1.7;color:rgba(255,255,255,.85);max-width:620px}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:12px 24px;border-radius:6px;font-weight:700;font-size:14px;cursor:pointer;transition:var(--transition);border:2px solid transparent;text-decoration:none;line-height:1.2}
    .btn-primary{background:var(--orange);color:var(--navy);border-color:var(--orange);font-weight:800}
    .btn-dark{background:var(--navy);color:var(--white);border-color:var(--navy)}
    .breadcrumb{font-size:13px;margin-bottom:16px;color:rgba(255,255,255,.6)}
    .breadcrumb a{color:rgba(255,255,255,.7);text-decoration:none}
    </style>
    <?php
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
