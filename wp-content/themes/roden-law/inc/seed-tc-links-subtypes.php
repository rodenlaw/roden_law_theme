<?php
/**
 * Seeder: Phase 3 — Add reverse links from truck sub-type pages to
 * corridor resources and related practice areas.
 *
 * Sets _roden_see_also meta on truck sub-type practice_area posts.
 *
 * Usage: wp eval-file wp-content/themes/roden-law/inc/seed-tc-links-subtypes.php
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WP_CLI' ) ) {
    return;
}

// Related practice areas (reverse links — these PAs link TO trucks, now trucks link BACK)
$wd     = '/practice-areas/wrongful-death-lawyers/';
$brain  = '/practice-areas/brain-injury-lawyers/';
$spinal = '/practice-areas/spinal-cord-injury-lawyers/';

$subtypes = array(
    '18-wheeler-semi-truck-accident' => array(
        array( 'url' => '/resources/i-95-truck-accidents-savannah-brunswick/', 'text' => 'I-95 Truck Accidents: Savannah to Brunswick' ),
        array( 'url' => '/resources/i-16-truck-accidents-savannah/',           'text' => 'I-16 Truck Accidents in Savannah' ),
        array( 'url' => '/resources/i-526-truck-accidents-charleston/',        'text' => 'I-526 Truck Accidents in Charleston' ),
        array( 'url' => '/resources/i-20-truck-accidents-columbia/',           'text' => 'I-20 Truck Accidents in Columbia' ),
        array( 'url' => '/resources/highway-501-truck-accidents-conway-myrtle-beach/', 'text' => 'Highway 501 Truck Accidents' ),
        array( 'url' => $wd,     'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,  'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $spinal, 'text' => 'Spinal Cord Injury Lawyers' ),
    ),
    'fatigued-trucker-accident' => array(
        array( 'url' => '/resources/i-16-truck-accidents-savannah/',           'text' => 'I-16: Savannah\'s Deadliest Freight Corridor' ),
        array( 'url' => '/resources/i-95-truck-accidents-savannah-brunswick/', 'text' => 'I-95: Savannah to Brunswick Corridor' ),
        array( 'url' => '/resources/i-77-truck-accidents-columbia-rock-hill/', 'text' => 'I-77: Columbia to Rock Hill Corridor' ),
        array( 'url' => '/resources/summerville-truck-accidents-i-26-corridor/', 'text' => 'Summerville Truck Accidents on I-26' ),
        array( 'url' => '/resources/seasonal-truck-accidents-myrtle-beach/',   'text' => 'Seasonal Truck Dangers in Myrtle Beach' ),
        array( 'url' => $wd,     'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,  'text' => 'Brain Injury Lawyers' ),
    ),
    'overloaded-improperly-loaded-cargo' => array(
        array( 'url' => '/resources/port-of-savannah-truck-routes/',           'text' => 'Port of Savannah Truck Routes' ),
        array( 'url' => '/resources/port-of-charleston-truck-routes/',         'text' => 'Port of Charleston Truck Routes' ),
        array( 'url' => '/resources/pooler-warehouse-district-truck-accidents/', 'text' => 'Pooler Warehouse District Truck Accidents' ),
        array( 'url' => '/resources/lexington-county-truck-accidents-distribution-corridor/', 'text' => 'Lexington County Distribution Corridor' ),
        array( 'url' => '/resources/logging-truck-accidents-us-17-mcintosh-glynn/', 'text' => 'Logging Truck Accidents on US-17' ),
        array( 'url' => $wd,     'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,  'text' => 'Brain Injury Lawyers' ),
    ),
    'brake-failure-accident' => array(
        array( 'url' => '/resources/i-526-construction-zone-truck-accidents-charleston/', 'text' => 'I-526 Construction Zone Truck Accidents' ),
        array( 'url' => '/resources/i-16-i-95-construction-zone-truck-accidents/',       'text' => 'I-16/I-95 Construction Zone Truck Accidents' ),
        array( 'url' => '/resources/carolina-crossroads-construction-zone-truck-accidents/', 'text' => 'Carolina Crossroads Construction Zone' ),
        array( 'url' => '/resources/i-95-truck-accidents-savannah-brunswick/', 'text' => 'I-95 Truck Accidents: Savannah to Brunswick' ),
        array( 'url' => $wd,     'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,  'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $spinal, 'text' => 'Spinal Cord Injury Lawyers' ),
    ),
    'underride-override-accident' => array(
        array( 'url' => '/resources/i-95-truck-accidents-savannah-brunswick/', 'text' => 'I-95 Truck Accidents: Savannah to Brunswick' ),
        array( 'url' => '/resources/i-77-truck-accidents-columbia-rock-hill/', 'text' => 'I-77 Truck Accidents: Columbia to Rock Hill' ),
        array( 'url' => '/resources/i-526-truck-accidents-charleston/',        'text' => 'I-526 Truck Accidents in Charleston' ),
        array( 'url' => $wd,     'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,  'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $spinal, 'text' => 'Spinal Cord Injury Lawyers' ),
    ),
    'commercial-van-delivery-truck-accident' => array(
        array( 'url' => '/resources/pooler-warehouse-district-truck-accidents/', 'text' => 'Pooler Warehouse District Truck Accidents' ),
        array( 'url' => '/resources/lexington-county-truck-accidents-distribution-corridor/', 'text' => 'Lexington County Distribution Corridor' ),
        array( 'url' => '/resources/rivers-avenue-truck-accidents-north-charleston/', 'text' => 'Rivers Avenue Truck Accidents' ),
        array( 'url' => '/resources/abercorn-street-truck-accidents-savannah/', 'text' => 'Abercorn Street Truck Accidents in Savannah' ),
        array( 'url' => '/resources/us-17-truck-accidents-grand-strand/',      'text' => 'US-17 Truck Accidents in the Grand Strand' ),
        array( 'url' => $wd,     'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,  'text' => 'Brain Injury Lawyers' ),
    ),
    'hazardous-materials-accident' => array(
        array( 'url' => '/resources/port-of-savannah-truck-routes/',   'text' => 'Port of Savannah Truck Routes' ),
        array( 'url' => '/resources/port-of-charleston-truck-routes/', 'text' => 'Port of Charleston Truck Routes' ),
        array( 'url' => '/resources/port-access-road-truck-accidents-leatherman-terminal/', 'text' => 'Port Access Road: Leatherman Terminal' ),
        array( 'url' => '/resources/us-52-truck-train-accidents-goose-creek/', 'text' => 'US-52 Truck Accidents in Goose Creek' ),
        array( 'url' => $wd,     'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,  'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $spinal, 'text' => 'Spinal Cord Injury Lawyers' ),
    ),
    'jackknife-accident' => array(
        array( 'url' => '/resources/i-16-truck-accidents-savannah/',   'text' => 'I-16 Truck Accidents in Savannah' ),
        array( 'url' => '/resources/i-20-truck-accidents-columbia/',   'text' => 'I-20 Truck Accidents in Columbia' ),
        array( 'url' => '/resources/columbia-i-26-i-20-i-77-interchange-truck-accidents/', 'text' => 'Columbia\'s I-26/I-20/I-77 Interchange' ),
        array( 'url' => '/resources/ashley-phosphate-i-26-truck-accidents/', 'text' => 'Ashley Phosphate & I-26 Truck Accidents' ),
        array( 'url' => $wd,     'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,  'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $spinal, 'text' => 'Spinal Cord Injury Lawyers' ),
    ),
);

// Find the truck-accident-lawyers pillar post
$pillar_posts = get_posts( array(
    'post_type'   => 'practice_area',
    'name'        => 'truck-accident-lawyers',
    'post_parent' => 0,
    'post_status' => 'any',
    'numberposts' => 1,
) );

if ( empty( $pillar_posts ) ) {
    WP_CLI::error( 'Truck accident pillar page not found.' );
}
$pillar_id = $pillar_posts[0]->ID;

$updated = 0;
foreach ( $subtypes as $slug => $links ) {
    $posts = get_posts( array(
        'post_type'   => 'practice_area',
        'name'        => $slug,
        'post_parent' => $pillar_id,
        'post_status' => 'any',
        'numberposts' => 1,
    ) );
    if ( empty( $posts ) ) {
        WP_CLI::warning( "NOT FOUND: {$slug}" );
        continue;
    }
    update_post_meta( $posts[0]->ID, '_roden_see_also', $links );
    WP_CLI::success( "LINKED: {$slug} (" . count( $links ) . " links)" );
    $updated++;
}
WP_CLI::success( "Done! Updated {$updated} truck sub-type pages with reverse links." );
