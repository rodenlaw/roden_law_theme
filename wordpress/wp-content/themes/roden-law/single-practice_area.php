<?php
/**
 * Single Practice Area — Router
 *
 * Detects page type and delegates to the correct template:
 *   - Intersection → templates/template-intersection.php
 *   - Sub-type     → templates/template-subtype.php
 *   - Pillar       → templates/template-practice-area.php
 *
 * @package RodenLaw
 */

get_header();
if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}
$firm    = roden_firm_data();
$post_id = get_the_ID();
$post    = get_post( $post_id );

// ── Detect page type ────────────────────────────────────────────────────
// _roden_pa_office_key holds a MARKET key: one of the 6 offices, or one of the
// service-area towns served from them. Resolve through roden_market() rather
// than indexing $firm['offices'] — that lookup cannot see service areas, so a
// town page would fall through to $is_subtype and render with the wrong
// template while schema-helpers.php (which detects by slug) still treated it as
// an intersection. The two detection paths must agree.
$pa_office_key   = get_post_meta( $post_id, '_roden_pa_office_key', true );
$pa_market       = $pa_office_key ? roden_market( $pa_office_key ) : null;
$is_intersection = ( null !== $pa_market );
$is_subtype      = ( $post->post_parent > 0 ) && ! $is_intersection;
$is_pillar       = ! $is_intersection && ! $is_subtype;

// ── Shared data ─────────────────────────────────────────────────────────
$jurisdiction_raw = get_post_meta( $post_id, '_roden_jurisdiction', true ) ?: 'both';
$jurisdiction     = strtolower( $jurisdiction_raw ); // Normalize: meta stores 'GA'/'SC', templates expect 'ga'/'sc'.
$sol_ga           = get_post_meta( $post_id, '_roden_sol_ga', true );
$sol_sc           = get_post_meta( $post_id, '_roden_sol_sc', true );
$sub_types_raw     = get_post_meta( $post_id, '_roden_sub_types', true );
$author_id         = get_post_meta( $post_id, '_roden_author_attorney', true );
$sub_types         = $sub_types_raw ? array_filter( array_map( 'trim', explode( "\n", $sub_types_raw ) ) ) : [];
$hero_intro        = get_post_meta( $post_id, '_roden_hero_intro', true );
$why_hire          = get_post_meta( $post_id, '_roden_why_hire', true );
$common_causes     = get_post_meta( $post_id, '_roden_common_causes', true );
$common_injuries   = get_post_meta( $post_id, '_roden_common_injuries', true );
if ( ! is_array( $common_causes ) )  $common_causes  = array();
if ( ! is_array( $common_injuries ) ) $common_injuries = array();

$jurisdiction_label = __( 'Georgia & South Carolina', 'roden-law' );
if ( $jurisdiction === 'ga' ) $jurisdiction_label = __( 'Georgia', 'roden-law' );
elseif ( $jurisdiction === 'sc' ) $jurisdiction_label = __( 'South Carolina', 'roden-law' );

// Parent pillar data (for intersection + subtype)
$parent_post = $post->post_parent ? get_post( $post->post_parent ) : null;

// ── Detect post type (support both ACF 'practice-area' and theme 'practice_area') ──
$pa_post_type = get_post_type( $post_id );

// ── Route to template ───────────────────────────────────────────────────
// Using include (not get_template_part) so router variables stay in scope.
if ( $is_intersection ) :
    include get_template_directory() . '/templates/template-intersection.php';

elseif ( $is_subtype ) :
    $parent_title = $parent_post ? $parent_post->post_title : '';
    $parent_url   = $parent_post ? get_permalink( $parent_post ) : '';

    // Get sibling sub-types (other children of same parent, excluding intersection pages)
    $siblings = get_posts([
        'post_type'      => $pa_post_type,
        'post_parent'    => $post->post_parent,
        'posts_per_page' => 20,
        'exclude'        => [ $post_id ],
        'orderby'        => 'title',
        'order'          => 'ASC',
        'meta_query'     => [
            'relation' => 'OR',
            [ 'key' => '_roden_pa_office_key', 'compare' => 'NOT EXISTS' ],
            [ 'key' => '_roden_pa_office_key', 'value' => '', 'compare' => '=' ],
        ],
    ]);

    // Get intersection pages (same parent, with office keys) for location cross-links.
    $sibling_intersections = get_posts([
        'post_type'      => $pa_post_type,
        'post_parent'    => $post->post_parent,
        'posts_per_page' => 10,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'meta_query'     => [
            [ 'key' => '_roden_pa_office_key', 'compare' => 'EXISTS' ],
            [ 'key' => '_roden_pa_office_key', 'value' => '', 'compare' => '!=' ],
        ],
    ]);

    include get_template_directory() . '/templates/template-subtype.php';

else :
    // Get child sub-type pages (exclude intersection pages and nested sub-types)
    $child_subtypes = get_posts([
        'post_type'      => $pa_post_type,
        'post_parent'    => $post_id,
        'posts_per_page' => 20,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'meta_query'     => [
            'relation' => 'OR',
            [ 'key' => '_roden_pa_office_key', 'compare' => 'NOT EXISTS' ],
            [ 'key' => '_roden_pa_office_key', 'value' => '', 'compare' => '=' ],
        ],
    ]);

    // Get intersection pages (children with office keys)
    $child_intersections = get_posts([
        'post_type'      => $pa_post_type,
        'post_parent'    => $post_id,
        'posts_per_page' => 10,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'meta_query'     => [
            [ 'key' => '_roden_pa_office_key', 'compare' => 'EXISTS' ],
            [ 'key' => '_roden_pa_office_key', 'value' => '', 'compare' => '!=' ],
        ],
    ]);

    include get_template_directory() . '/templates/template-practice-area.php';

endif;

get_footer();
