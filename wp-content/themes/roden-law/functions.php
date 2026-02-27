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
   4. TEMPLATE ROUTING — Bridge ACF CPT names to theme templates
   ========================================================================== */

add_filter( 'single_template', 'roden_bridge_cpt_templates' );
/**
 * Route posts from ACF-registered CPTs (hyphen names) to our theme templates
 * (underscore names). ACF registers 'practice-area'; our template file is
 * single-practice_area.php.
 */
function roden_bridge_cpt_templates( $template ) {
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
   5. WIDGET AREAS
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
