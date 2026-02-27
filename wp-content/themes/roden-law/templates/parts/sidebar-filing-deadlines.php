<?php
/**
 * Template Part: Filing Deadlines Sidebar
 *
 * Thin wrapper around roden_filing_deadlines_sidebar() from template-tags.php.
 * Displays statute of limitations + comparative fault by jurisdiction.
 *
 * Accepts optional $sidebar_jurisdiction: 'GA', 'SC', or 'both'.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$sidebar_jurisdiction = isset( $sidebar_jurisdiction ) ? $sidebar_jurisdiction : '';

roden_filing_deadlines_sidebar( $sidebar_jurisdiction );
