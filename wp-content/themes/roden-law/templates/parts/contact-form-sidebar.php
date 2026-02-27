<?php
/**
 * Template Part: Contact Form Sidebar CTA
 *
 * Thin wrapper around roden_contact_form_sidebar() from template-tags.php.
 *
 * Accepts optional $local_phone for location-specific phone display.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$local_phone = isset( $local_phone ) ? $local_phone : '';

roden_contact_form_sidebar( $local_phone );
