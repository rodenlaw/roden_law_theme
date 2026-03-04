<?php
/**
 * Roden Law Theme Functions
 *
 * Core engine: loads modular inc/ files, handles theme setup
 * and widget areas. Enqueue, meta boxes, nav menus, and schema
 * markup live in their own inc/ modules.
 *
 * @package Roden_Law
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   1. LOAD INC/ MODULES
   ========================================================================== */

require_once get_template_directory() . '/inc/firm-data.php';
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/rewrite-rules.php';
require_once get_template_directory() . '/inc/schema-helpers.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/nav-menus.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/meta-boxes.php';
require_once get_template_directory() . '/inc/legacy-redirects.php';

// Belt-and-suspenders: verify template-tags loaded (require retries if require_once cached a failure)
if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require get_template_directory() . '/inc/template-tags.php';
}

/* ==========================================================================
   2. THEME SETUP
   ========================================================================== */

add_action( 'after_setup_theme', 'roden_theme_setup' );
function roden_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    add_image_size( 'attorney-headshot', 400, 533, true );
    add_image_size( 'attorney-portrait', 600, 800, true );
    add_image_size( 'card-thumb', 600, 400, true );
    add_image_size( 'hero-bg', 1920, 800, true );
}

/* ==========================================================================
   3. REDIRECTS — Old Rank Math Location URLs → New Hierarchical URLs
   ========================================================================== */

add_action( 'template_redirect', 'roden_legacy_location_redirects' );
function roden_legacy_location_redirects() {
    if ( ! is_singular( 'rank_math_locations' ) ) {
        return;
    }

    $redirects = array(
        'savannah-georgia'                    => '/locations/georgia/savannah/',
        'charleston-south-carolina-location'  => '/locations/south-carolina/charleston/',
    );

    $slug = get_post_field( 'post_name', get_the_ID() );

    if ( isset( $redirects[ $slug ] ) ) {
        wp_redirect( home_url( $redirects[ $slug ] ), 301 );
        exit;
    }
}

/* ==========================================================================
   3b. STAFF — Redirect single pages & exclude from sitemap
   ========================================================================== */

add_filter( 'wp_sitemaps_posts_query_args', 'roden_exclude_staff_from_sitemap', 10, 2 );
function roden_exclude_staff_from_sitemap( $args, $post_type ) {
    if ( 'attorney' === $post_type ) {
        $args['meta_query'] = array(
            'relation' => 'OR',
            array( 'key' => '_roden_team_role', 'value' => 'attorney' ),
            array( 'key' => '_roden_team_role', 'compare' => 'NOT EXISTS' ),
        );
    }
    return $args;
}

add_action( 'template_redirect', 'roden_staff_redirect' );
function roden_staff_redirect() {
    if ( ! is_singular( 'attorney' ) ) {
        return;
    }
    $role = get_post_meta( get_the_ID(), '_roden_team_role', true );
    if ( 'staff' === $role ) {
        wp_redirect( home_url( '/attorneys/' ), 301 );
        exit;
    }
}

/* ==========================================================================
   4. TEMPLATE ROUTING — Bridge ACF CPT names to theme templates
   ========================================================================== */

add_filter( 'template_include', 'roden_bridge_cpt_templates', 1001 );
/**
 * Route posts from ACF-registered CPTs (hyphen names) to our theme templates
 * (underscore names). ACF registers 'practice-area'; our template file is
 * single-practice_area.php.
 *
 * Uses template_include at priority 1001 to override ACF Extended's
 * front_template filter (priority 999).
 */
function roden_bridge_cpt_templates( $template ) {
    // Archive templates: bridge both CPT slugs to our underscore-named file.
    if ( is_post_type_archive( 'practice-area' ) || is_post_type_archive( 'practice_area' ) ) {
        $custom = get_template_directory() . '/archive-practice_area.php';
        if ( file_exists( $custom ) ) {
            return $custom;
        }
    }

    if ( ! is_singular() ) {
        return $template;
    }

    $map = [
        'practice-area' => '/single-practice_area.php',
    ];

    $post_type = get_post_type();
    if ( isset( $map[ $post_type ] ) ) {
        $custom = get_template_directory() . $map[ $post_type ];
        if ( file_exists( $custom ) ) {
            return $custom;
        }
    }

    return $template;
}

/* ==========================================================================
   5. PAGE TEMPLATES — Register templates in templates/ subdirectory
   ========================================================================== */

add_filter( 'theme_page_templates', 'roden_register_page_templates' );
function roden_register_page_templates( $templates ) {
    $templates['templates/template-landing-page.php'] = 'Landing Page';
    return $templates;
}

/* ==========================================================================
   6. WIDGET AREAS
   ========================================================================== */

add_action( 'widgets_init', 'roden_register_sidebars' );
function roden_register_sidebars() {
    register_sidebar( array(
        'name'          => __( 'Practice Area Sidebar', 'roden-law' ),
        'id'            => 'sidebar-practice-area',
        'description'   => __( 'Sidebar for practice area pages', 'roden-law' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Location Sidebar', 'roden-law' ),
        'id'            => 'sidebar-location',
        'description'   => __( 'Sidebar for location pages', 'roden-law' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Blog Sidebar', 'roden-law' ),
        'id'            => 'sidebar-blog',
        'description'   => __( 'Sidebar for blog and resource pages', 'roden-law' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Widgets', 'roden-law' ),
        'id'            => 'sidebar-footer',
        'description'   => __( 'Footer widget area', 'roden-law' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}

/* ==========================================================================
   7. THANK-YOU PAGE — Noindex + Conversion Tracking
   ========================================================================== */

add_filter( 'wp_robots', 'roden_thankyou_noindex' );
function roden_thankyou_noindex( $robots ) {
    if ( is_page( 1940 ) ) {
        $robots['noindex'] = true;
        $robots['nofollow'] = true;
    }
    return $robots;
}

add_action( 'wp_head', 'roden_thankyou_conversion_tracking' );
function roden_thankyou_conversion_tracking() {
    if ( ! is_page( 1940 ) ) {
        return;
    }
    ?>
    <script>
    window.addEventListener('load', function () {
        /* Google Analytics / GA4 generate_lead event */
        if (typeof gtag === 'function') {
            gtag('event', 'generate_lead', {
                event_category: 'contact',
                event_label: 'form_submission',
                value: 1
            });
        }
    });
    </script>
    <?php
}

/* ==========================================================================
   8. GRAVITY FORMS — Force submit button inline styles
   ========================================================================== */

add_filter( 'gform_submit_button', 'roden_gf_submit_button_style', 10, 2 );
function roden_gf_submit_button_style( $button, $form ) {
    if ( (int) $form['id'] !== 1 ) {
        return $button;
    }
    $style = 'display:block!important;visibility:visible!important;width:100%!important;'
           . 'background:#FCB415!important;color:#013046!important;padding:16px 20px!important;'
           . 'border:none!important;border-radius:8px!important;font-size:18px!important;'
           . 'font-weight:800!important;cursor:pointer!important;min-height:50px!important;'
           . 'font-family:Merriweather Sans,sans-serif!important;letter-spacing:0.3px;'
           . 'margin:0!important;opacity:1!important;position:relative!important;z-index:10!important;';
    $button = str_replace( "class='gform_button", "style='{$style}' class='gform_button", $button );
    return $button;
}

/**
 * Force GF submit buttons to stay visible after JS hides them.
 * GF's JS hides buttons on duplicate form instances — this fights back.
 */
add_action( 'wp_footer', 'roden_gf_force_submit_visible', 999 );
function roden_gf_force_submit_visible() {
    ?>
    <script>
    (function(){
        var style = 'display:block!important;visibility:visible!important;width:100%!important;'
            + 'background:#FCB415!important;color:#013046!important;padding:16px 20px!important;'
            + 'border:none!important;border-radius:8px!important;font-size:18px!important;'
            + 'font-weight:800!important;cursor:pointer!important;min-height:50px!important;'
            + 'opacity:1!important;position:relative!important;z-index:10!important;margin:0!important;';

        function forceButtons() {
            var containers = document.querySelectorAll('.sidebar-contact-form, .footer-mini-form');
            containers.forEach(function(container) {
                /* Force wrapper visible */
                var wrapper = container.querySelector('.gform_wrapper');
                if (wrapper) wrapper.style.cssText += 'display:block!important;';

                /* Force footer visible */
                var footers = container.querySelectorAll('.gform_footer, .gform-footer');
                footers.forEach(function(f) {
                    f.style.cssText += 'display:block!important;visibility:visible!important;'
                        + 'height:auto!important;overflow:visible!important;opacity:1!important;';
                });

                /* Force submit button visible */
                var btns = container.querySelectorAll('input[type="submit"], .gform_button');
                btns.forEach(function(btn) {
                    btn.style.cssText = style;
                });
            });
        }

        /* Run immediately, on DOMContentLoaded, on load, and periodically for 10s */
        forceButtons();
        document.addEventListener('DOMContentLoaded', forceButtons);
        window.addEventListener('load', forceButtons);

        /* Re-check every 500ms for 10 seconds to catch late JS changes */
        var count = 0;
        var interval = setInterval(function() {
            forceButtons();
            count++;
            if (count >= 20) clearInterval(interval);
        }, 500);

        /* Listen for GF post-render event */
        document.addEventListener('gform/postRender', forceButtons);
    })();
    </script>
    <?php
}
