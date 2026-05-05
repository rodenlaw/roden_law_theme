<?php
/**
 * Template Part: FAQ Accordion (HTML only — FAQPage schema is JSON-LD via schema-helpers.php)
 *
 * Thin wrapper around roden_faq_section() from template-tags.php.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$faq_post_id = isset( $faq_post_id ) ? $faq_post_id : get_the_ID();

roden_faq_section( $faq_post_id );
