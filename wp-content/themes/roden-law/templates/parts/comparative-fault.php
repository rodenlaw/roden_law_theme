<?php
/**
 * Template Part: Comparative Fault Display — GA vs SC rules
 *
 * Thin wrapper around roden_comparative_fault_display() from template-tags.php.
 * Shows both states side-by-side on pillar pages, single state on intersection/location.
 *
 * Accepts optional $cf_jurisdiction: 'GA', 'SC', or 'both'.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$cf_jurisdiction = isset( $cf_jurisdiction ) ? $cf_jurisdiction : '';

roden_comparative_fault_display( $cf_jurisdiction );
