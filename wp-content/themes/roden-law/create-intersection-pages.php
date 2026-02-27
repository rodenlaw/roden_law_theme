<?php
/**
 * WP-CLI Script: Create 18 Pillar + 90 Intersection Pages
 *
 * Run via SSH:
 *   wp eval-file wp-content/themes/roden-law/create-intersection-pages.php
 *
 * Idempotent — skips any post that already exists with the correct slug.
 *
 * Phase A: Creates 18 pillar parent posts (practice_area CPT, post_parent = 0)
 * Phase B: Creates 90 intersection child posts (18 pillars x 5 offices)
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Run this script with: wp eval-file <path>' );
}

// Ensure firm data is available.
if ( ! function_exists( 'roden_firm_data' ) ) {
    require_once get_template_directory() . '/inc/firm-data.php';
}

$firm = roden_firm_data();

/* ==========================================================================
   PRACTICE AREA DEFINITIONS — slug => human label
   ========================================================================== */

$pa_labels = array(
    'car-accident-lawyers'         => 'Car Accident Lawyers',
    'truck-accident-lawyers'        => 'Truck Accident Lawyers',
    'slip-and-fall-lawyers'         => 'Slip & Fall Lawyers',
    'motorcycle-accident-lawyers'   => 'Motorcycle Accident Lawyers',
    'medical-malpractice-lawyers'   => 'Medical Malpractice Lawyers',
    'wrongful-death-lawyers'        => 'Wrongful Death Lawyers',
    'workers-compensation-lawyers'  => 'Workers\' Compensation Lawyers',
    'dog-bite-lawyers'              => 'Dog Bite Lawyers',
    'brain-injury-lawyers'          => 'Brain Injury Lawyers',
    'spinal-cord-injury-lawyers'    => 'Spinal Cord Injury Lawyers',
    'maritime-injury-lawyers'       => 'Maritime Injury Lawyers',
    'product-liability-lawyers'     => 'Product Liability Lawyers',
    'boating-accident-lawyers'      => 'Boating Accident Lawyers',
    'burn-injury-lawyers'           => 'Burn Injury Lawyers',
    'construction-accident-lawyers' => 'Construction Accident Lawyers',
    'nursing-home-abuse-lawyers'    => 'Nursing Home Abuse Lawyers',
    'premises-liability-lawyers'    => 'Premises Liability Lawyers',
    'pedestrian-accident-lawyers'   => 'Pedestrian Accident Lawyers',
);

/* ==========================================================================
   HELPER: Find existing post by slug + parent
   ========================================================================== */

function roden_find_post( $slug, $parent = 0 ) {
    global $wpdb;
    return $wpdb->get_var( $wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts}
         WHERE post_name = %s AND post_parent = %d AND post_type = 'practice_area' AND post_status = 'publish'
         LIMIT 1",
        $slug,
        $parent
    ) );
}

/* ==========================================================================
   PHASE A — Create 18 Pillar Parent Posts
   ========================================================================== */

WP_CLI::log( '' );
WP_CLI::log( '=== PHASE A: Creating 18 Pillar Parent Posts ===' );

$pillar_ids = array(); // slug => post ID
$created_pillars = 0;
$skipped_pillars = 0;

foreach ( $pa_labels as $slug => $label ) {
    $existing_id = roden_find_post( $slug, 0 );

    if ( $existing_id ) {
        $pillar_ids[ $slug ] = (int) $existing_id;
        $skipped_pillars++;
        WP_CLI::log( "  SKIP: {$label} (ID {$existing_id})" );
        continue;
    }

    // Build pillar content.
    $content  = "<p>Roden Law's {$label} represent injury victims across Georgia and South Carolina. ";
    $content .= "With over \$250 million recovered and 5,000+ cases handled, our team has the experience to fight for the compensation you deserve.</p>\n\n";
    $content .= "<p>We handle {$label} cases on a contingency fee basis — you pay nothing unless we win. ";
    $content .= "Contact our team for a free, no-obligation case review available 24/7.</p>";

    $post_id = wp_insert_post( array(
        'post_type'    => 'practice_area',
        'post_status'  => 'publish',
        'post_title'   => $label,
        'post_name'    => $slug,
        'post_content' => $content,
        'post_parent'  => 0,
        'menu_order'   => $created_pillars + $skipped_pillars,
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "  FAIL: {$label} — " . $post_id->get_error_message() );
        continue;
    }

    // Set meta: jurisdiction = both, SOL for GA and SC.
    update_post_meta( $post_id, '_roden_jurisdiction', 'both' );
    update_post_meta( $post_id, '_roden_sol_ga', '2 years (O.C.G.A. § 9-3-33)' );
    update_post_meta( $post_id, '_roden_sol_sc', '3 years (S.C. Code § 15-3-530)' );

    $pillar_ids[ $slug ] = (int) $post_id;
    $created_pillars++;
    WP_CLI::success( "  Created: {$label} (ID {$post_id})" );
}

WP_CLI::log( "Pillars: {$created_pillars} created, {$skipped_pillars} skipped." );

/* ==========================================================================
   PHASE B — Create 90 Intersection Child Posts (18 x 5)
   ========================================================================== */

WP_CLI::log( '' );
WP_CLI::log( '=== PHASE B: Creating 90 Intersection Child Posts ===' );

$created_children = 0;
$skipped_children = 0;

foreach ( $pa_labels as $pa_slug => $pa_label ) {
    $parent_id = isset( $pillar_ids[ $pa_slug ] ) ? $pillar_ids[ $pa_slug ] : 0;

    if ( ! $parent_id ) {
        WP_CLI::warning( "  No parent ID for {$pa_slug} — skipping all children." );
        continue;
    }

    foreach ( $firm['offices'] as $office_key => $office ) {
        $child_slug = $office['slug']; // e.g. 'savannah-ga'
        $city       = $office['city'];
        $state      = $office['state'];
        $state_full = $office['state_full'];
        $court      = $office['court'];
        $phone      = $office['phone'];
        $service    = $office['service_area'];

        // Check if already exists.
        $existing_id = roden_find_post( $child_slug, $parent_id );
        if ( $existing_id ) {
            $skipped_children++;
            WP_CLI::log( "  SKIP: {$pa_label} in {$city}, {$state} (ID {$existing_id})" );
            continue;
        }

        // Build title: "Car Accident Lawyers in Savannah, GA"
        $title = "{$pa_label} in {$city}, {$state}";

        // Build placeholder content (~250 words).
        $singular_label = rtrim( $pa_label, 's' ); // rough singular
        $content = "<p>If you've been injured in a {$city}, {$state} accident, Roden Law's {$pa_label} are here to help. "
                 . "Our {$city} office serves victims throughout {$service}</p>\n\n";

        $content .= "<h2>Why Choose Roden Law for Your {$city} {$singular_label} Case?</h2>\n"
                  . "<p>Our attorneys have recovered over \$250 million for personal injury victims across {$state_full}. "
                  . "We handle every case on a contingency fee basis — you pay nothing unless we win your case. "
                  . "Our {$city} team regularly appears before the {$court} and understands local procedures and filing requirements.</p>\n\n";

        $content .= "<h2>{$state_full} Personal Injury Law</h2>\n"
                  . "<p>Under {$state_full} law, injured parties have a limited time to file a personal injury claim. ";

        if ( 'GA' === $state ) {
            $content .= "In Georgia, the statute of limitations for most personal injury cases is 2 years from the date of injury (O.C.G.A. § 9-3-33). "
                      . "Georgia follows a modified comparative fault rule — you can recover damages as long as you are less than 50% at fault (O.C.G.A. § 51-12-33).</p>\n\n";
        } else {
            $content .= "In South Carolina, the statute of limitations for most personal injury cases is 3 years from the date of injury (S.C. Code § 15-3-530). "
                      . "South Carolina follows a modified comparative fault rule — you can recover damages as long as you are less than 51% at fault.</p>\n\n";
        }

        $content .= "<h2>Contact Our {$city} Office</h2>\n"
                  . "<p>Don't wait to get the legal help you need. Call our {$city} office at <a href=\"tel:{$office['phone_raw']}\">{$phone}</a> "
                  . "for a free, no-obligation case review. We're available 24/7 and there are no fees unless we win your case.</p>\n\n";

        $content .= "<p>Roden Law's {$city} {$pa_label} proudly serve {$service}</p>";

        $post_id = wp_insert_post( array(
            'post_type'    => 'practice_area',
            'post_status'  => 'publish',
            'post_title'   => $title,
            'post_name'    => $child_slug,
            'post_content' => $content,
            'post_parent'  => $parent_id,
        ), true );

        if ( is_wp_error( $post_id ) ) {
            WP_CLI::warning( "  FAIL: {$title} — " . $post_id->get_error_message() );
            continue;
        }

        // Set meta.
        update_post_meta( $post_id, '_roden_pa_office_key', $office_key );
        update_post_meta( $post_id, '_roden_jurisdiction', $state );

        if ( 'GA' === $state ) {
            update_post_meta( $post_id, '_roden_sol_ga', '2 years (O.C.G.A. § 9-3-33)' );
        } else {
            update_post_meta( $post_id, '_roden_sol_sc', '3 years (S.C. Code § 15-3-530)' );
        }

        $created_children++;
        WP_CLI::success( "  Created: {$title} (ID {$post_id})" );
    }
}

WP_CLI::log( "Intersections: {$created_children} created, {$skipped_children} skipped." );

/* ==========================================================================
   FLUSH REWRITE RULES
   ========================================================================== */

WP_CLI::log( '' );
WP_CLI::log( 'Flushing rewrite rules...' );
flush_rewrite_rules();
WP_CLI::success( 'Rewrite rules flushed.' );

/* ==========================================================================
   SUMMARY
   ========================================================================== */

WP_CLI::log( '' );
WP_CLI::log( '=== SUMMARY ===' );
WP_CLI::log( "Pillars:       {$created_pillars} created, {$skipped_pillars} skipped" );
WP_CLI::log( "Intersections: {$created_children} created, {$skipped_children} skipped" );

$total = $created_pillars + $skipped_pillars + $created_children + $skipped_children;
WP_CLI::success( "Done. {$total} total posts processed (18 pillars + 90 intersections)." );
