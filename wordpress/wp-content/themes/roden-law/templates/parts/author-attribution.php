<?php
/**
 * Template Part: Author Attribution — E-E-A-T author box
 *
 * Thin wrapper around roden_author_attribution() from template-tags.php.
 * Renders "About the Author" section with attorney photo, title, bar admissions.
 *
 * Accepts optional $attribution_post_id to specify which post's author to show.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$attribution_post_id = isset( $attribution_post_id ) ? $attribution_post_id : null;

roden_author_attribution( $attribution_post_id );
