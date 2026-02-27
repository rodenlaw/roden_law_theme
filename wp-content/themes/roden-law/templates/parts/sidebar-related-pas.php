<?php
/**
 * Template Part: Related Practice Areas Sidebar
 *
 * Thin wrapper around roden_related_practice_areas() from template-tags.php.
 * Shows sibling pages for child posts, or other pillars for pillar pages.
 *
 * Accepts optional $rpa_count for number of items.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$rpa_count = isset( $rpa_count ) ? $rpa_count : 6;

roden_related_practice_areas( $rpa_count );
