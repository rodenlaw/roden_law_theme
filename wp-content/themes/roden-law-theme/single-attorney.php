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
$bar_raw     = get_post_meta( $post_id, '_roden_atty_bar_admissions', true );
$edu_raw     = get_post_meta( $post_id, '_roden_atty_education', true );
$awards_raw  = get_post_meta( $post_id, '_roden_atty_awards', true );
$avvo_url    = get_post_meta( $post_id, '_roden_atty_avvo_url', true );
$linkedin    = get_post_meta( $post_id, '_roden_atty_linkedin', true );

$office = ( $office_key && isset($firm['offices'][$office_key]) ) ? $firm['offices'][$office_key] : null;
$bar_items   = $bar_raw   ? array_filter( array_map('trim', explode("\n", $bar_raw)) ) : [];
$edu_items   = $edu_raw   ? array_filter( array_map('trim', explode("\n", $edu_raw)) ) : [];
$award_items = $awards_raw ? array_filter( array_map('trim', explode("\n", $awards_raw)) ) : [];

get_template_part( 'templates/template-attorney' );

get_footer();
