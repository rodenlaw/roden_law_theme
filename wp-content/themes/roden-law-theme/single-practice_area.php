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
$pa_office_key   = get_post_meta( $post_id, '_roden_pa_office_key', true );
$is_intersection = ! empty( $pa_office_key ) && isset( $firm['offices'][ $pa_office_key ] );
$is_subtype      = ( $post->post_parent > 0 ) && ! $is_intersection;
$is_pillar       = ! $is_intersection && ! $is_subtype;

// ── Shared data ─────────────────────────────────────────────────────────
$jurisdiction  = get_post_meta( $post_id, '_roden_jurisdiction', true ) ?: 'both';
$sol_ga        = get_post_meta( $post_id, '_roden_sol_ga', true );
$sol_sc        = get_post_meta( $post_id, '_roden_sol_sc', true );
$sub_types_raw = get_post_meta( $post_id, '_roden_sub_types', true );
$author_id     = get_post_meta( $post_id, '_roden_author_attorney', true );
$sub_types     = $sub_types_raw ? array_filter( array_map( 'trim', explode( "\n", $sub_types_raw ) ) ) : [];

$jurisdiction_label = 'Georgia & South Carolina';
if ( $jurisdiction === 'ga' ) $jurisdiction_label = 'Georgia';
elseif ( $jurisdiction === 'sc' ) $jurisdiction_label = 'South Carolina';

// Parent pillar data (for intersection + subtype)
$parent_post = $post->post_parent ? get_post( $post->post_parent ) : null;

// ── Route to template ───────────────────────────────────────────────────
if ( $is_intersection ) :
    get_template_part( 'templates/template-intersection' );

elseif ( $is_subtype ) :
    $parent_title = $parent_post ? $parent_post->post_title : '';
    $parent_url   = $parent_post ? get_permalink( $parent_post ) : '';

    // Get sibling sub-types (other children of same parent, excluding intersection pages)
    $siblings = get_posts([
        'post_type'      => 'practice_area',
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

    get_template_part( 'templates/template-subtype' );

else :
    // Get child sub-type pages (exclude intersection pages)
    $child_subtypes = get_posts([
        'post_type'      => 'practice_area',
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
        'post_type'      => 'practice_area',
        'post_parent'    => $post_id,
        'posts_per_page' => 10,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'meta_query'     => [
            [ 'key' => '_roden_pa_office_key', 'compare' => 'EXISTS' ],
            [ 'key' => '_roden_pa_office_key', 'value' => '', 'compare' => '!=' ],
        ],
    ]);

    get_template_part( 'templates/template-practice-area' );

endif;

get_footer();
