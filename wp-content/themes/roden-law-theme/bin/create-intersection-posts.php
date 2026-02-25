<?php
/**
 * Bulk-create 90 intersection posts (18 practice areas x 5 offices).
 *
 * Usage:  wp eval-file bin/create-intersection-posts.php
 *
 * - Creates child practice_area posts as drafts
 * - Idempotent: skips posts that already exist
 * - Sets all required meta fields for the intersection template
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
    echo "This script must be run via WP-CLI: wp eval-file bin/create-intersection-posts.php\n";
    exit( 1 );
}

// ── Load firm data ────────────────────────────────────────────────────────
if ( ! function_exists( 'roden_firm_data' ) ) {
    require_once get_template_directory() . '/inc/firm-data.php';
}

$firm            = roden_firm_data();
$offices         = $firm['offices'];
$pa_slugs        = $firm['practice_areas'];
$created_count   = 0;
$skipped_count   = 0;
$error_count     = 0;

echo "\n=== Creating Intersection Posts ===\n";
echo "Practice areas: " . count( $pa_slugs ) . "\n";
echo "Offices: " . count( $offices ) . "\n";
echo "Expected total: " . ( count( $pa_slugs ) * count( $offices ) ) . "\n\n";

// ── Map state abbreviation to jurisdiction meta value ──────────────────────
$state_to_jurisdiction = array(
    'GA' => 'ga',
    'SC' => 'sc',
);

foreach ( $pa_slugs as $pa_slug ) {

    // Find the pillar post by slug.
    $pillar = get_page_by_path( $pa_slug, OBJECT, 'practice_area' );

    if ( ! $pillar ) {
        echo "[ERROR] Pillar post not found for slug: {$pa_slug} — skipping all offices.\n";
        $error_count += count( $offices );
        continue;
    }

    $pillar_id    = $pillar->ID;
    $pillar_title = $pillar->post_title;

    // Inherit meta from pillar.
    $parent_sol_ga  = get_post_meta( $pillar_id, '_roden_sol_ga', true );
    $parent_sol_sc  = get_post_meta( $pillar_id, '_roden_sol_sc', true );
    $parent_author  = get_post_meta( $pillar_id, '_roden_author_attorney', true );

    foreach ( $offices as $office_key => $office ) {

        $office_slug = $office['slug'];  // e.g. 'savannah-ga'
        $city        = $office['city'];
        $state       = $office['state']; // e.g. 'GA'

        // ── Idempotency check ─────────────────────────────────────────────
        $existing = get_posts( array(
            'post_type'      => 'practice_area',
            'post_parent'    => $pillar_id,
            'name'           => $office_slug,
            'post_status'    => 'any',
            'posts_per_page' => 1,
        ) );

        if ( ! empty( $existing ) ) {
            echo "[SKIP]  {$pillar_title} / {$office_slug} — already exists (ID {$existing[0]->ID})\n";
            $skipped_count++;
            continue;
        }

        // ── Build post title ──────────────────────────────────────────────
        $post_title = "{$pillar_title} in {$city}, {$state}";

        // ── Placeholder content ───────────────────────────────────────────
        $post_content = sprintf(
            '<p>If you need experienced %s, our %s office is ready to help. '
            . 'Roden Law serves %s and surrounding communities with dedicated legal representation. '
            . 'Contact us today for a free consultation.</p>',
            strtolower( $pillar_title ),
            $city,
            $office['service_area']
        );

        // ── Create the post ───────────────────────────────────────────────
        $new_post_id = wp_insert_post( array(
            'post_type'    => 'practice_area',
            'post_title'   => $post_title,
            'post_name'    => $office_slug,
            'post_parent'  => $pillar_id,
            'post_status'  => 'draft',
            'post_content' => $post_content,
        ), true );

        if ( is_wp_error( $new_post_id ) ) {
            echo "[ERROR] {$pillar_title} / {$office_slug} — {$new_post_id->get_error_message()}\n";
            $error_count++;
            continue;
        }

        // ── Set meta fields ───────────────────────────────────────────────
        $jurisdiction = isset( $state_to_jurisdiction[ $state ] )
            ? $state_to_jurisdiction[ $state ]
            : '';

        update_post_meta( $new_post_id, '_roden_pa_office_key', $office_key );
        update_post_meta( $new_post_id, '_roden_jurisdiction', $jurisdiction );

        if ( $parent_sol_ga ) {
            update_post_meta( $new_post_id, '_roden_sol_ga', $parent_sol_ga );
        }
        if ( $parent_sol_sc ) {
            update_post_meta( $new_post_id, '_roden_sol_sc', $parent_sol_sc );
        }
        if ( $parent_author ) {
            update_post_meta( $new_post_id, '_roden_author_attorney', $parent_author );
        }

        echo "[CREATED] {$post_title} (ID {$new_post_id})\n";
        $created_count++;
    }
}

// ── Flush rewrite rules ───────────────────────────────────────────────────
flush_rewrite_rules();

// ── Summary ───────────────────────────────────────────────────────────────
echo "\n=== Done ===\n";
echo "Created: {$created_count}\n";
echo "Skipped: {$skipped_count}\n";
echo "Errors:  {$error_count}\n";
echo "Total:   " . ( $created_count + $skipped_count + $error_count ) . "\n";
