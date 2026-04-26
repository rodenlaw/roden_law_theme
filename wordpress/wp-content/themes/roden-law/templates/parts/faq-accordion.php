<?php
/**
 * Template Part: FAQ Accordion with FAQPage schema
 *
 * Thin wrapper around roden_faq_section() from template-tags.php.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$faq_post_id = isset( $faq_post_id ) ? $faq_post_id : get_the_ID();

roden_faq_section( $faq_post_id );
