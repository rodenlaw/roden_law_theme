<?php
/**
 * Template Part: Case Results Grid
 *
 * Thin wrapper around roden_case_results_grid() from template-tags.php.
 *
 * Accepts optional variables:
 *   $cr_count, $cr_columns, $cr_practice_category, $cr_location_served
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$cr_args = array(
    'count'             => isset( $cr_count ) ? $cr_count : 4,
    'columns'           => isset( $cr_columns ) ? $cr_columns : 4,
    'practice_category' => isset( $cr_practice_category ) ? $cr_practice_category : '',
    'location_served'   => isset( $cr_location_served ) ? $cr_location_served : '',
);

roden_case_results_grid( $cr_args );
