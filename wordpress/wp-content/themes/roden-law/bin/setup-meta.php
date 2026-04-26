<?php
/**
 * Set attorney meta fields, office keys, and taxonomy assignments.
 *
 * Usage:  wp eval-file wp-content/themes/roden-law/bin/setup-meta.php
 *
 * - Matches existing attorney posts by slug
 * - Sets all profile meta, education, awards, and URLs
 * - Creates location_served taxonomy terms and assigns them
 * - Idempotent: safe to run multiple times
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
    echo "This script must be run via WP-CLI: wp eval-file wp-content/themes/roden-law/bin/setup-meta.php\n";
    exit( 1 );
}

// ── Load firm data ────────────────────────────────────────────────────────
if ( ! function_exists( 'roden_firm_data' ) ) {
    require_once get_template_directory() . '/inc/firm-data.php';
}

$firm    = roden_firm_data();
$offices = $firm['offices'];

echo "\n=== Attorney Meta Setup ===\n\n";

// ── Attorney data ─────────────────────────────────────────────────────────
// Each key = expected post slug. All meta fields populated here.

$attorneys = array(
    // Actual slugs from WP database (old theme migration slugs).
    'who-we-are-attorneys-eric-roden' => array(
        'title'          => 'Founding Partner, CEO',
        'office_key'     => 'savannah',
        'bar_admissions' => "Georgia Bar — 2012\nSouth Carolina Bar — 2018",
        'education'      => array(
            array( 'degree' => 'J.D.',  'institution' => 'University of Georgia School of Law' ),
            array( 'degree' => 'B.B.A.', 'institution' => 'University of Georgia' ),
        ),
        'awards'         => array(
            array( 'award' => 'Super Lawyers Rising Star', 'year' => '2023' ),
            array( 'award' => 'Super Lawyers Rising Star', 'year' => '2024' ),
            array( 'award' => 'Top 40 Under 40 Trial Lawyers', 'year' => '2023' ),
        ),
        'avvo_url'       => '',
        'linkedin_url'   => 'https://www.linkedin.com/in/ericroden/',
        'locations'      => array( 'Savannah, GA', 'Darien, GA' ),
    ),
    'who-we-are-attorneys-tyler-love' => array(
        'title'          => 'Founding Partner, CTO',
        'office_key'     => 'savannah',
        'bar_admissions' => "Georgia Bar — 2012",
        'education'      => array(
            array( 'degree' => 'J.D.',  'institution' => 'University of Georgia School of Law' ),
            array( 'degree' => 'B.S.',  'institution' => 'Georgia Institute of Technology' ),
        ),
        'awards'         => array(
            array( 'award' => 'Super Lawyers Rising Star', 'year' => '2024' ),
        ),
        'avvo_url'       => '',
        'linkedin_url'   => 'https://www.linkedin.com/in/tyler-love-esq/',
        'locations'      => array( 'Savannah, GA' ),
    ),
    'who-we-are-attorneys-joshua-dorminy' => array(
        'title'          => 'Partner',
        'office_key'     => 'darien',
        'bar_admissions' => "Georgia Bar — 2016\nSouth Carolina Bar — 2020",
        'education'      => array(
            array( 'degree' => 'J.D.',  'institution' => 'Mercer University School of Law' ),
            array( 'degree' => 'B.A.',  'institution' => 'University of Georgia' ),
        ),
        'awards'         => array(
            array( 'award' => 'Super Lawyers Rising Star', 'year' => '2024' ),
        ),
        'avvo_url'       => '',
        'linkedin_url'   => 'https://www.linkedin.com/in/joshua-dorminy/',
        'locations'      => array( 'Darien, GA', 'Savannah, GA' ),
    ),
    'graeham-c-gillin' => array(
        'title'          => 'Partner, COO',
        'office_key'     => 'charleston',
        'bar_admissions' => "South Carolina Bar — 2017",
        'education'      => array(
            array( 'degree' => 'J.D.',  'institution' => 'Charleston School of Law' ),
            array( 'degree' => 'B.A.',  'institution' => 'College of Charleston' ),
        ),
        'awards'         => array(
            array( 'award' => 'Super Lawyers Rising Star', 'year' => '2024' ),
        ),
        'avvo_url'       => '',
        'linkedin_url'   => 'https://www.linkedin.com/in/graeham-gillin/',
        'locations'      => array( 'Charleston, SC', 'Columbia, SC', 'Murrells Inlet, SC' ),
    ),
    'kiley-reidy' => array(
        'title'          => 'Associate',
        'office_key'     => 'charleston',
        'bar_admissions' => "South Carolina Bar — 2021",
        'education'      => array(
            array( 'degree' => 'J.D.',  'institution' => 'Charleston School of Law' ),
            array( 'degree' => 'B.A.',  'institution' => 'University of South Carolina' ),
        ),
        'awards'         => array(),
        'avvo_url'       => '',
        'linkedin_url'   => 'https://www.linkedin.com/in/kiley-reidy/',
        'locations'      => array( 'Charleston, SC', 'Columbia, SC' ),
    ),
    'zach-stohr' => array(
        'title'          => 'Associate',
        'office_key'     => 'charleston',
        'bar_admissions' => "South Carolina Bar — 2022",
        'education'      => array(
            array( 'degree' => 'J.D.',  'institution' => 'Charleston School of Law' ),
            array( 'degree' => 'B.S.',  'institution' => 'Clemson University' ),
        ),
        'awards'         => array(),
        'avvo_url'       => '',
        'linkedin_url'   => 'https://www.linkedin.com/in/zach-stohr/',
        'locations'      => array( 'Charleston, SC' ),
    ),
    'ivy' => array(
        'title'          => 'Associate',
        'office_key'     => 'myrtle-beach',
        'bar_admissions' => "South Carolina Bar — 2022",
        'education'      => array(
            array( 'degree' => 'J.D.',  'institution' => 'University of South Carolina School of Law' ),
            array( 'degree' => 'B.A.',  'institution' => 'Coastal Carolina University' ),
        ),
        'awards'         => array(),
        'avvo_url'       => '',
        'linkedin_url'   => 'https://www.linkedin.com/in/ivy-montano/',
        'locations'      => array( 'Murrells Inlet, SC' ),
    ),
);

// ── Ensure location_served taxonomy terms exist ───────────────────────────
// Build terms from office data: "City, ST" format.

$location_terms = array();
foreach ( $offices as $key => $office ) {
    $term_name = $office['city'] . ', ' . $office['state'];
    $existing  = term_exists( $term_name, 'location_served' );

    if ( $existing ) {
        $location_terms[ $term_name ] = (int) $existing['term_id'];
        echo "[TERM EXISTS] {$term_name} (ID {$existing['term_id']})\n";
    } else {
        $result = wp_insert_term( $term_name, 'location_served', array(
            'slug' => $office['slug'],
        ) );
        if ( is_wp_error( $result ) ) {
            echo "[TERM ERROR]  {$term_name}: {$result->get_error_message()}\n";
        } else {
            $location_terms[ $term_name ] = (int) $result['term_id'];
            echo "[TERM CREATED] {$term_name} (ID {$result['term_id']})\n";
        }
    }
}

echo "\n";

// ── Set meta on each attorney post ────────────────────────────────────────

$updated = 0;
$skipped = 0;

foreach ( $attorneys as $slug => $data ) {

    // Find attorney post by slug.
    $posts = get_posts( array(
        'post_type'      => 'attorney',
        'name'           => $slug,
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ) );

    if ( empty( $posts ) ) {
        echo "[SKIP] No attorney post found with slug: {$slug}\n";
        $skipped++;
        continue;
    }

    $post_id = $posts[0]->ID;
    $name    = $posts[0]->post_title;

    // Profile meta.
    update_post_meta( $post_id, '_roden_atty_title',      $data['title'] );
    update_post_meta( $post_id, '_roden_atty_office_key',  $data['office_key'] );
    update_post_meta( $post_id, '_roden_bar_admissions',   $data['bar_admissions'] );

    // Education (repeater array).
    update_post_meta( $post_id, '_roden_education', $data['education'] );

    // Awards (repeater array).
    update_post_meta( $post_id, '_roden_awards', $data['awards'] );

    // URLs.
    update_post_meta( $post_id, '_roden_avvo_url',     $data['avvo_url'] );
    update_post_meta( $post_id, '_roden_linkedin_url', $data['linkedin_url'] );

    // Taxonomy: location_served.
    $term_ids = array();
    foreach ( $data['locations'] as $loc_name ) {
        if ( isset( $location_terms[ $loc_name ] ) ) {
            $term_ids[] = $location_terms[ $loc_name ];
        }
    }
    if ( ! empty( $term_ids ) ) {
        wp_set_object_terms( $post_id, $term_ids, 'location_served' );
    }

    echo "[UPDATED] {$name} (ID {$post_id}) — office: {$data['office_key']}, locations: " . implode( ', ', $data['locations'] ) . "\n";
    $updated++;
}

echo "\n=== Done ===\n";
echo "Updated: {$updated}\n";
echo "Skipped: {$skipped}\n\n";

// Flush rewrite rules to pick up any taxonomy changes.
flush_rewrite_rules();
echo "Rewrite rules flushed.\n";
