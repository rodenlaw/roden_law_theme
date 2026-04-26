<?php
/**
 * Fix _roden_parent_office_key for North Charleston, Goose Creek, and Summerville neighborhoods.
 *
 * Updates neighborhood posts that currently have _roden_parent_office_key = 'charleston'
 * but should point to 'north-charleston' based on the geographic service area split.
 *
 * Usage:
 *   cd sites/rodenlawdev1
 *   wp eval-file wp-content/themes/roden-law/inc/fix-neighborhood-office-keys.php
 *
 * Safe to re-run: only updates posts matching the criteria.
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Starting neighborhood office key reassignment...' );

// Neighborhood slugs that should be reassigned from charleston → north-charleston.
// These are post_name values for neighborhood posts.
$reassign_slugs = array(
    // North Charleston neighborhoods (10)
    'park-circle',
    'olde-north-charleston',
    'dorchester-terrace-waylyn',
    'liberty-hill',
    'ferndale',
    'oak-terrace-preserve',
    'charleston-heights',
    'chicora-cherokee',
    'wescott-plantation',
    'northwoods',
    // Goose Creek neighborhoods (8)
    'crowfield-plantation',
    'liberty-hall-plantation',
    'carnes-crossroads',
    'boulder-bluff',
    'howe-hall',
    'devon-forest',
    'brickhope-plantation',
    'westchester',
    // Summerville neighborhoods (8)
    'historic-district',
    'cane-bay',
    'nexton',
    'knightsville',
    'sangaree',
    'summers-corner',
    'wescott',
    'pine-forest-inn',
);

// Also reassign the parent-level "north-charleston" neighborhood if it exists
// under the charleston-neighborhoods JSON (it's listed in charleston-neighborhoods.json)
$reassign_slugs[] = 'north-charleston';
// Goose Creek parent and Summerville parent
$reassign_slugs[] = 'goose-creek';
$reassign_slugs[] = 'summerville';

$updated = 0;
$skipped = 0;
$not_found = 0;

foreach ( $reassign_slugs as $slug ) {
    // Find the neighborhood post by slug
    $posts = get_posts( array(
        'post_type'      => 'neighborhood',
        'post_status'    => array( 'publish', 'draft', 'pending' ),
        'name'           => $slug,
        'posts_per_page' => 1,
    ) );

    if ( empty( $posts ) ) {
        // Also try as a location post
        $posts = get_posts( array(
            'post_type'      => 'location',
            'post_status'    => array( 'publish', 'draft', 'pending' ),
            'name'           => $slug,
            'posts_per_page' => 1,
        ) );
    }

    if ( empty( $posts ) ) {
        WP_CLI::log( "  [NOT FOUND] {$slug}" );
        $not_found++;
        continue;
    }

    $post = $posts[0];
    $current_key = get_post_meta( $post->ID, '_roden_parent_office_key', true );

    if ( 'north-charleston' === $current_key ) {
        WP_CLI::log( "  [SKIP] {$slug} (ID {$post->ID}) — already north-charleston" );
        $skipped++;
        continue;
    }

    update_post_meta( $post->ID, '_roden_parent_office_key', 'north-charleston' );
    WP_CLI::log( "  [UPDATED] {$slug} (ID {$post->ID}) — {$current_key} → north-charleston" );
    $updated++;
}

WP_CLI::success( "Done. Updated: {$updated}, Skipped: {$skipped}, Not found: {$not_found}" );
