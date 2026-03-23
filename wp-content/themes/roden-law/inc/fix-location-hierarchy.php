<?php
/**
 * Fix location post hierarchy for North Charleston office split.
 *
 * North Charleston is its own city/office, not a Charleston neighborhood.
 * This script:
 * 1. Moves North Charleston to be a sibling of Charleston (child of south-carolina)
 * 2. Moves Goose Creek, Summerville, Hanahan, Ladson, Moncks Corner from
 *    Charleston → North Charleston
 * 3. Removes duplicate Park Circle (3779) under Charleston since 4254 exists
 *    under North Charleston
 *
 * Result:
 *   /locations/south-carolina/charleston/         (peninsula, beaches, islands)
 *   /locations/south-carolina/north-charleston/   (I-26 corridor, tri-county)
 *
 * Usage:
 *   cd sites/rodenlawdev1
 *   wp eval-file wp-content/themes/roden-law/inc/fix-location-hierarchy.php
 *
 * Safe to re-run.
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Fixing location hierarchy for North Charleston office split...' );

// Known post IDs from dev site
$south_carolina_id   = 3596;  // /locations/south-carolina/
$charleston_id       = 3599;  // /locations/south-carolina/charleston/
$north_charleston_id = 3763;  // Currently under charleston, needs to move up

// ── Step 1: Move North Charleston to be a sibling of Charleston ──────────
$nc_post = get_post( $north_charleston_id );
if ( $nc_post && (int) $nc_post->post_parent === $charleston_id ) {
    wp_update_post( array(
        'ID'          => $north_charleston_id,
        'post_parent' => $south_carolina_id,
    ) );
    WP_CLI::log( "  [MOVED] North Charleston (ID {$north_charleston_id}): charleston → south-carolina" );
} else {
    WP_CLI::log( "  [SKIP] North Charleston (ID {$north_charleston_id}): parent is already " . ( $nc_post ? $nc_post->post_parent : 'NOT FOUND' ) );
}

// ── Step 2: Move tri-county cities from Charleston → North Charleston ────
$move_to_nc = array(
    3764 => 'Summerville',
    3766 => 'Goose Creek',
    3771 => 'Hanahan',
    3770 => 'Ladson',
    3776 => 'Moncks Corner',
);

foreach ( $move_to_nc as $post_id => $name ) {
    $post = get_post( $post_id );
    if ( ! $post ) {
        WP_CLI::warning( "  [NOT FOUND] {$name} (ID {$post_id})" );
        continue;
    }
    if ( (int) $post->post_parent === $north_charleston_id ) {
        WP_CLI::log( "  [SKIP] {$name} (ID {$post_id}): already under North Charleston" );
        continue;
    }
    wp_update_post( array(
        'ID'          => $post_id,
        'post_parent' => $north_charleston_id,
    ) );
    WP_CLI::log( "  [MOVED] {$name} (ID {$post_id}): charleston → north-charleston" );
}

// ── Step 3: Remove duplicate Park Circle under Charleston ────────────────
// 3779 = Park Circle under Charleston (duplicate)
// 4254 = Park Circle under North Charleston (correct)
$dup_park_circle = get_post( 3779 );
if ( $dup_park_circle && 'park-circle' === $dup_park_circle->post_name && (int) $dup_park_circle->post_parent === $charleston_id ) {
    wp_update_post( array(
        'ID'          => 3779,
        'post_status' => 'trash',
    ) );
    WP_CLI::log( "  [TRASHED] Duplicate Park Circle (ID 3779) under Charleston" );
} elseif ( $dup_park_circle && 'park-circle' === $dup_park_circle->post_name ) {
    WP_CLI::log( "  [SKIP] Park Circle (ID 3779): parent is {$dup_park_circle->post_parent}, not Charleston" );
} else {
    WP_CLI::log( "  [SKIP] Park Circle (ID 3779): not found or different slug" );
}

// ── Step 4: Flush rewrite rules ─────────────────────────────────────────
flush_rewrite_rules();

WP_CLI::success( 'Location hierarchy fixed. URLs should now be:' );
WP_CLI::log( '  /locations/south-carolina/charleston/          (peninsula, beaches, islands)' );
WP_CLI::log( '  /locations/south-carolina/north-charleston/    (I-26 corridor, tri-county)' );
WP_CLI::log( '  /locations/south-carolina/north-charleston/goose-creek/' );
WP_CLI::log( '  /locations/south-carolina/north-charleston/summerville/' );
WP_CLI::log( '  /locations/south-carolina/north-charleston/hanahan/' );
