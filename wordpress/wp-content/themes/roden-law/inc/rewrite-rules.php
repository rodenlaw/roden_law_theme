<?php
/**
 * Custom Rewrite Rules — Three-Tier URL Architecture
 *
 * Handles the intersection and sub-type URL patterns:
 *   Pillar:       /practice-areas/car-accident-lawyers/          (default WP CPT)
 *   Intersection:  /car-accident-lawyers/savannah-ga/             (custom rewrite)
 *   Sub-Type:      /car-accident-lawyers/drunk-driver-accident/   (custom rewrite)
 *
 * Both intersection and sub-type URLs resolve to the practice_area CPT
 * using parent/child (hierarchical) post relationships. The template
 * router (single-practice_area.php) detects the page type and loads
 * the correct template.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   REWRITE RULES
   ========================================================================== */

add_action( 'init', 'roden_rewrite_rules' );

/**
 * Register custom rewrite rules for intersection and sub-type pages.
 *
 * For each of the 18 pillar practice area slugs, adds a rule that maps
 * /[pillar-slug]/[child-slug]/ → practice_area CPT with hierarchical slug.
 */
function roden_rewrite_rules() {
    $practice_areas = roden_get_practice_area_slugs();

    foreach ( $practice_areas as $slug ) {
        // Matches: /car-accident-lawyers/savannah-ga/
        // Matches: /car-accident-lawyers/drunk-driver-accident/
        // Routes to: practice_area CPT with slug "car-accident-lawyers/savannah-ga"
        add_rewrite_rule(
            '^' . preg_quote( $slug, '/' ) . '/([^/]+)/?$',
            'index.php?post_type=practice_area&practice_area=' . $slug . '/$matches[1]',
            'top'
        );
    }
}

/* ==========================================================================
   FLUSH REWRITE RULES ON THEME ACTIVATION
   ========================================================================== */

add_action( 'after_switch_theme', 'roden_flush_rewrites' );

/**
 * Flush rewrite rules when the theme is activated.
 * Ensures CPTs, taxonomies, and custom rules are all registered first.
 */
function roden_flush_rewrites() {
    roden_register_post_types();
    roden_register_taxonomies();
    roden_rewrite_rules();
    flush_rewrite_rules();
}

/* ==========================================================================
   PAGE TYPE DETECTION
   ========================================================================== */

/**
 * Detect the practice_area page type: 'pillar', 'intersection', or 'subtype'.
 *
 * Logic:
 * 1. No parent → pillar page
 * 2. Has parent AND slug matches a known office city-state slug → intersection
 * 3. Has parent AND slug does NOT match an office slug → sub-type
 *
 * @param int|null $post_id Post ID (defaults to current post).
 * @return string 'pillar', 'intersection', or 'subtype'.
 */
function roden_practice_area_type( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $post = get_post( $post_id );
    if ( ! $post || ! in_array( $post->post_type, [ 'practice_area', 'practice-area' ], true ) ) {
        return 'pillar';
    }

    // Top-level post = pillar
    if ( ! $post->post_parent ) {
        return 'pillar';
    }

    // Child post — check if it's an intersection or sub-type
    if ( roden_is_intersection_page( $post_id ) ) {
        return 'intersection';
    }

    return 'subtype';
}

/**
 * Detect whether a practice_area post is an intersection page.
 * Intersection pages are child posts whose slug matches a known office city-state slug.
 *
 * @param int|null $post_id Post ID (defaults to current post).
 * @return bool True if this is an intersection page.
 */
function roden_is_intersection_page( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $post = get_post( $post_id );
    if ( ! $post || ! $post->post_parent || ! in_array( $post->post_type, [ 'practice_area', 'practice-area' ], true ) ) {
        return false;
    }

    $office_slugs = roden_get_office_slugs();
    return in_array( $post->post_name, $office_slugs, true );
}

/**
 * Detect whether a practice_area post is a sub-type page.
 * Sub-type pages are child posts that are NOT intersection pages.
 *
 * @param int|null $post_id Post ID (defaults to current post).
 * @return bool True if this is a sub-type page.
 */
function roden_is_subtype_page( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $post = get_post( $post_id );
    if ( ! $post || ! $post->post_parent || ! in_array( $post->post_type, [ 'practice_area', 'practice-area' ], true ) ) {
        return false;
    }

    return ! roden_is_intersection_page( $post_id );
}

/**
 * Get the office data for the current intersection page.
 * Returns null if the current page is not an intersection page.
 *
 * @param int|null $post_id Post ID (defaults to current post).
 * @return array|null Office data array from roden_firm_data(), or null.
 */
function roden_get_intersection_office( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    if ( ! roden_is_intersection_page( $post_id ) ) {
        return null;
    }

    $post = get_post( $post_id );
    if ( ! $post ) {
        return null;
    }
    $office_key = roden_office_key_from_slug( $post->post_name );

    if ( ! $office_key ) {
        return null;
    }

    return roden_get_office( $office_key );
}

/**
 * Get the parent pillar post for an intersection or sub-type page.
 *
 * @param int|null $post_id Post ID (defaults to current post).
 * @return WP_Post|null Parent post object, or null if already a pillar.
 */
function roden_get_pillar_parent( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $post = get_post( $post_id );
    if ( ! $post || ! $post->post_parent ) {
        return null;
    }

    return get_post( $post->post_parent );
}
