<?php
/**
 * Template Part: Location Matrix — 5-office grid with intersection links
 *
 * Thin wrapper around roden_location_matrix() from template-tags.php.
 *
 * Accepts optional $pillar_id to specify which practice area the links target.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$pillar_id = isset( $pillar_id ) ? $pillar_id : null;

roden_location_matrix( $pillar_id );
