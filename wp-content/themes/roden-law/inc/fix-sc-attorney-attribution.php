<?php
/**
 * Fix: Update _roden_author_attorney on all SC intersection pages to Graeham C. Gillin
 *
 * ROD-76: Eric Roden was incorrectly set (or left unset) on SC intersection pages.
 * Graeham C. Gillin (graeham-c-gillin) is the lead SC attorney.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/fix-sc-attorney-attribution.php
 *
 * Safe to re-run: idempotent.
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Starting SC attorney attribution fix (ROD-76)...' );

// Find Graeham by slug.
$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
if ( ! $graeham ) {
	WP_CLI::error( 'Could not find attorney post: graeham-c-gillin — aborting.' );
	return;
}
$graeham_id = $graeham->ID;
WP_CLI::log( "Graeham C. Gillin attorney ID: {$graeham_id}" );

// SC office slugs.
$sc_slugs = [ 'charleston-sc', 'columbia-sc', 'myrtle-beach-sc' ];

$updated = 0;
$skipped = 0;

foreach ( $sc_slugs as $slug ) {
	// Find all practice_area posts with this post_name.
	$posts = get_posts( [
		'post_type'      => 'practice_area',
		'post_name__in'  => [ $slug ],
		'posts_per_page' => -1,
		'post_status'    => [ 'publish', 'draft' ],
	] );

	if ( empty( $posts ) ) {
		WP_CLI::warning( "  No posts found with post_name '{$slug}'" );
		continue;
	}

	foreach ( $posts as $post ) {
		$current = get_post_meta( $post->ID, '_roden_author_attorney', true );
		if ( (int) $current === $graeham_id ) {
			WP_CLI::log( "  Skipped (already set): {$post->post_title} (ID {$post->ID})" );
			$skipped++;
			continue;
		}
		update_post_meta( $post->ID, '_roden_author_attorney', $graeham_id );
		WP_CLI::success( "  Updated: {$post->post_title} (ID {$post->ID}) — set to Graeham #{$graeham_id} (was: " . ( $current ?: 'empty' ) . ")" );
		$updated++;
	}
}

WP_CLI::log( '' );
WP_CLI::log( "--- SUMMARY ---" );
WP_CLI::log( "Updated : {$updated}" );
WP_CLI::log( "Skipped : {$skipped}" );
WP_CLI::success( 'SC attorney attribution fix complete.' );
