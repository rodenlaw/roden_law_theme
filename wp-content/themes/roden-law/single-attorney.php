<?php
/**
 * Single Attorney — Router
 *
 * Sets up variables and delegates to templates/template-attorney.php.
 *
 * @package RodenLaw
 */

get_header();
if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}
$firm    = roden_firm_data();
$post_id = get_the_ID();

$title       = get_post_meta( $post_id, '_roden_atty_title', true );
$office_key  = get_post_meta( $post_id, '_roden_atty_office_key', true );
$bar_raw     = get_post_meta( $post_id, '_roden_bar_admissions', true );
$edu_raw     = get_post_meta( $post_id, '_roden_education', true );
$awards_raw  = get_post_meta( $post_id, '_roden_awards', true );
$avvo_url    = get_post_meta( $post_id, '_roden_avvo_url', true );
$linkedin    = get_post_meta( $post_id, '_roden_linkedin_url', true );

$office = ( $office_key && isset($firm['offices'][$office_key]) ) ? $firm['offices'][$office_key] : null;

// Bar admissions = textarea (newline-separated strings)
$bar_items = $bar_raw ? array_filter( array_map( 'trim', explode( "\n", $bar_raw ) ) ) : [];

// Education = repeater array of ['degree'=>..., 'institution'=>...]
$edu_items = [];
if ( is_array( $edu_raw ) ) {
    foreach ( $edu_raw as $edu ) {
        $parts = array_filter( [ $edu['degree'] ?? '', $edu['institution'] ?? '' ] );
        if ( $parts ) {
            $edu_items[] = implode( ' — ', $parts );
        }
    }
} elseif ( $edu_raw ) {
    $edu_items = array_filter( array_map( 'trim', explode( "\n", $edu_raw ) ) );
}

// Awards = repeater array of ['award'=>..., 'year'=>...]
$award_items = [];
if ( is_array( $awards_raw ) ) {
    foreach ( $awards_raw as $aw ) {
        $name = $aw['award'] ?? '';
        $year = $aw['year'] ?? '';
        if ( $name ) {
            $award_items[] = $year ? $name . ' (' . $year . ')' : $name;
        }
    }
} elseif ( $awards_raw ) {
    $award_items = array_filter( array_map( 'trim', explode( "\n", $awards_raw ) ) );
}

get_template_part( 'templates/template-attorney' );

get_footer();
