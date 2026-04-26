<?php
/**
 * Template Part: Attorneys Grid
 *
 * Thin wrapper around roden_attorneys_grid() from template-tags.php.
 *
 * Accepts optional variables:
 *   $ag_count, $ag_columns, $ag_office_key
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$ag_args = array(
    'count'      => isset( $ag_count ) ? $ag_count : -1,
    'columns'    => isset( $ag_columns ) ? $ag_columns : 4,
    'office_key' => isset( $ag_office_key ) ? $ag_office_key : '',
);

roden_attorneys_grid( $ag_args );
