<?php
/**
 * Custom Post Types (6) and Taxonomies (2)
 *
 * Registers all content types for the Roden Law theme:
 * - practice_area (hierarchical — pillar/intersection/sub-type)
 * - location (hierarchical — state/city)
 * - attorney
 * - case_result
 * - testimonial
 * - resource
 *
 * Taxonomies:
 * - practice_category (applied to: practice_area, case_result, resource)
 * - location_served (applied to: practice_area, case_result, attorney)
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'roden_register_post_types' );

/**
 * Register all 6 custom post types.
 */
function roden_register_post_types() {

    // ── Practice Areas ──────────────────────────────────────────────────
    // Hierarchical for parent/child: pillar → intersection & sub-type pages
    register_post_type( 'practice_area', array(
        'labels' => array(
            'name'               => __( 'Practice Areas', 'roden-law' ),
            'singular_name'      => __( 'Practice Area', 'roden-law' ),
            'add_new'            => __( 'Add New', 'roden-law' ),
            'add_new_item'       => __( 'Add New Practice Area', 'roden-law' ),
            'edit_item'          => __( 'Edit Practice Area', 'roden-law' ),
            'new_item'           => __( 'New Practice Area', 'roden-law' ),
            'view_item'          => __( 'View Practice Area', 'roden-law' ),
            'search_items'       => __( 'Search Practice Areas', 'roden-law' ),
            'not_found'          => __( 'No practice areas found', 'roden-law' ),
            'not_found_in_trash' => __( 'No practice areas found in trash', 'roden-law' ),
            'parent_item_colon'  => __( 'Parent Practice Area:', 'roden-law' ),
            'all_items'          => __( 'All Practice Areas', 'roden-law' ),
            'menu_name'          => __( 'Practice Areas', 'roden-law' ),
        ),
        'public'             => true,
        'has_archive'        => true,
        'hierarchical'       => true,
        'rewrite'            => array( 'slug' => 'practice-areas', 'with_front' => false ),
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields' ),
        'menu_icon'          => 'dashicons-shield',
        'menu_position'      => 5,
        'show_in_rest'       => true,
    ) );

    // ── Locations ────────────────────────────────────────────────────────
    // Hierarchical for state/city nesting (e.g., /locations/georgia/savannah/)
    register_post_type( 'location', array(
        'labels' => array(
            'name'               => __( 'Locations', 'roden-law' ),
            'singular_name'      => __( 'Location', 'roden-law' ),
            'add_new'            => __( 'Add New', 'roden-law' ),
            'add_new_item'       => __( 'Add New Location', 'roden-law' ),
            'edit_item'          => __( 'Edit Location', 'roden-law' ),
            'new_item'           => __( 'New Location', 'roden-law' ),
            'view_item'          => __( 'View Location', 'roden-law' ),
            'search_items'       => __( 'Search Locations', 'roden-law' ),
            'not_found'          => __( 'No locations found', 'roden-law' ),
            'not_found_in_trash' => __( 'No locations found in trash', 'roden-law' ),
            'parent_item_colon'  => __( 'Parent Location:', 'roden-law' ),
            'all_items'          => __( 'All Locations', 'roden-law' ),
            'menu_name'          => __( 'Locations', 'roden-law' ),
        ),
        'public'             => true,
        'has_archive'        => true,
        'hierarchical'       => true,
        'rewrite'            => array( 'slug' => 'locations', 'with_front' => false ),
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields' ),
        'menu_icon'          => 'dashicons-location',
        'menu_position'      => 6,
        'show_in_rest'       => true,
    ) );

    // ── Attorneys ─────────────────────────────────────────────────────────
    register_post_type( 'attorney', array(
        'labels' => array(
            'name'               => __( 'Attorneys', 'roden-law' ),
            'singular_name'      => __( 'Attorney', 'roden-law' ),
            'add_new'            => __( 'Add New', 'roden-law' ),
            'add_new_item'       => __( 'Add New Attorney', 'roden-law' ),
            'edit_item'          => __( 'Edit Attorney', 'roden-law' ),
            'new_item'           => __( 'New Attorney', 'roden-law' ),
            'view_item'          => __( 'View Attorney', 'roden-law' ),
            'search_items'       => __( 'Search Attorneys', 'roden-law' ),
            'not_found'          => __( 'No attorneys found', 'roden-law' ),
            'not_found_in_trash' => __( 'No attorneys found in trash', 'roden-law' ),
            'all_items'          => __( 'All Attorneys', 'roden-law' ),
            'menu_name'          => __( 'Attorneys', 'roden-law' ),
        ),
        'public'             => true,
        'has_archive'        => true,
        'hierarchical'       => false,
        'rewrite'            => array( 'slug' => 'attorneys', 'with_front' => false ),
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'menu_icon'          => 'dashicons-businessman',
        'menu_position'      => 7,
        'show_in_rest'       => true,
    ) );

    // ── Case Results ──────────────────────────────────────────────────────
    register_post_type( 'case_result', array(
        'labels' => array(
            'name'               => __( 'Case Results', 'roden-law' ),
            'singular_name'      => __( 'Case Result', 'roden-law' ),
            'add_new'            => __( 'Add New', 'roden-law' ),
            'add_new_item'       => __( 'Add New Case Result', 'roden-law' ),
            'edit_item'          => __( 'Edit Case Result', 'roden-law' ),
            'new_item'           => __( 'New Case Result', 'roden-law' ),
            'view_item'          => __( 'View Case Result', 'roden-law' ),
            'search_items'       => __( 'Search Case Results', 'roden-law' ),
            'not_found'          => __( 'No case results found', 'roden-law' ),
            'not_found_in_trash' => __( 'No case results found in trash', 'roden-law' ),
            'all_items'          => __( 'All Case Results', 'roden-law' ),
            'menu_name'          => __( 'Case Results', 'roden-law' ),
        ),
        'public'             => true,
        'has_archive'        => true,
        'hierarchical'       => false,
        'rewrite'            => array( 'slug' => 'case-results', 'with_front' => false ),
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'menu_icon'          => 'dashicons-awards',
        'menu_position'      => 8,
        'show_in_rest'       => true,
    ) );

    // ── Testimonials ──────────────────────────────────────────────────────
    register_post_type( 'testimonial', array(
        'labels' => array(
            'name'               => __( 'Testimonials', 'roden-law' ),
            'singular_name'      => __( 'Testimonial', 'roden-law' ),
            'add_new'            => __( 'Add New', 'roden-law' ),
            'add_new_item'       => __( 'Add New Testimonial', 'roden-law' ),
            'edit_item'          => __( 'Edit Testimonial', 'roden-law' ),
            'new_item'           => __( 'New Testimonial', 'roden-law' ),
            'view_item'          => __( 'View Testimonial', 'roden-law' ),
            'search_items'       => __( 'Search Testimonials', 'roden-law' ),
            'not_found'          => __( 'No testimonials found', 'roden-law' ),
            'not_found_in_trash' => __( 'No testimonials found in trash', 'roden-law' ),
            'all_items'          => __( 'All Testimonials', 'roden-law' ),
            'menu_name'          => __( 'Testimonials', 'roden-law' ),
        ),
        'public'             => true,
        'has_archive'        => true,
        'hierarchical'       => false,
        'rewrite'            => array( 'slug' => 'testimonials', 'with_front' => false ),
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'menu_icon'          => 'dashicons-format-quote',
        'menu_position'      => 9,
        'show_in_rest'       => true,
    ) );

    // ── Resources ─────────────────────────────────────────────────────────
    // Legal guides, FAQ pages, how-to content, state law pages
    register_post_type( 'resource', array(
        'labels' => array(
            'name'               => __( 'Resources', 'roden-law' ),
            'singular_name'      => __( 'Resource', 'roden-law' ),
            'add_new'            => __( 'Add New', 'roden-law' ),
            'add_new_item'       => __( 'Add New Resource', 'roden-law' ),
            'edit_item'          => __( 'Edit Resource', 'roden-law' ),
            'new_item'           => __( 'New Resource', 'roden-law' ),
            'view_item'          => __( 'View Resource', 'roden-law' ),
            'search_items'       => __( 'Search Resources', 'roden-law' ),
            'not_found'          => __( 'No resources found', 'roden-law' ),
            'not_found_in_trash' => __( 'No resources found in trash', 'roden-law' ),
            'all_items'          => __( 'All Resources', 'roden-law' ),
            'menu_name'          => __( 'Resources', 'roden-law' ),
        ),
        'public'             => true,
        'has_archive'        => true,
        'hierarchical'       => false,
        'rewrite'            => array( 'slug' => 'resources', 'with_front' => false ),
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'menu_icon'          => 'dashicons-book-alt',
        'menu_position'      => 10,
        'show_in_rest'       => true,
    ) );
}

/* ==========================================================================
   TAXONOMIES
   ========================================================================== */

add_action( 'init', 'roden_register_taxonomies' );

/**
 * Register both custom taxonomies.
 */
function roden_register_taxonomies() {

    // ── Practice Category ─────────────────────────────────────────────────
    // Groups content by practice area type (e.g., "Car Accidents", "Truck Accidents")
    register_taxonomy( 'practice_category', array( 'practice_area', 'case_result', 'resource' ), array(
        'labels' => array(
            'name'              => __( 'Practice Categories', 'roden-law' ),
            'singular_name'     => __( 'Practice Category', 'roden-law' ),
            'search_items'      => __( 'Search Practice Categories', 'roden-law' ),
            'all_items'         => __( 'All Practice Categories', 'roden-law' ),
            'edit_item'         => __( 'Edit Practice Category', 'roden-law' ),
            'update_item'       => __( 'Update Practice Category', 'roden-law' ),
            'add_new_item'      => __( 'Add New Practice Category', 'roden-law' ),
            'new_item_name'     => __( 'New Practice Category Name', 'roden-law' ),
            'parent_item'       => __( 'Parent Practice Category', 'roden-law' ),
            'parent_item_colon' => __( 'Parent Practice Category:', 'roden-law' ),
            'menu_name'         => __( 'Practice Categories', 'roden-law' ),
        ),
        'hierarchical'      => true,
        'show_admin_column'  => true,
        'rewrite'            => array( 'slug' => 'practice-category', 'with_front' => false ),
        'show_in_rest'       => true,
    ) );

    // ── Location Served ───────────────────────────────────────────────────
    // Connects content to geographic locations for filtering and internal linking
    register_taxonomy( 'location_served', array( 'practice_area', 'case_result', 'attorney' ), array(
        'labels' => array(
            'name'              => __( 'Locations Served', 'roden-law' ),
            'singular_name'     => __( 'Location Served', 'roden-law' ),
            'search_items'      => __( 'Search Locations Served', 'roden-law' ),
            'all_items'         => __( 'All Locations Served', 'roden-law' ),
            'edit_item'         => __( 'Edit Location Served', 'roden-law' ),
            'update_item'       => __( 'Update Location Served', 'roden-law' ),
            'add_new_item'      => __( 'Add New Location Served', 'roden-law' ),
            'new_item_name'     => __( 'New Location Served Name', 'roden-law' ),
            'menu_name'         => __( 'Locations Served', 'roden-law' ),
        ),
        'hierarchical'      => true,
        'show_admin_column'  => true,
        'rewrite'            => array( 'slug' => 'location-served', 'with_front' => false ),
        'show_in_rest'       => true,
    ) );
}
