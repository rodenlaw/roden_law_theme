<?php
/**
 * Seeder: Inject internal links into Savannah-market truck corridor resources.
 *
 * Sets _roden_see_also meta with structured link arrays for:
 * - Truck accident pillar page
 * - Relevant sub-type pages
 * - Related injury practice areas (wrongful death, brain injury, spinal cord)
 * - Cross-market corridor links (I-95 connects to Charleston)
 *
 * Usage: wp eval-file wp-content/themes/roden-law/inc/seed-tc-links-savannah.php
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WP_CLI' ) ) {
    return;
}

$pillar  = '/practice-areas/truck-accident-lawyers/';
$wd      = '/practice-areas/wrongful-death-lawyers/';
$brain   = '/practice-areas/brain-injury-lawyers/';
$spinal  = '/practice-areas/spinal-cord-injury-lawyers/';
$ped     = '/practice-areas/pedestrian-accident-lawyers/';
$constr  = '/practice-areas/construction-accident-lawyers/';

// Truck sub-type URLs
$st_18w   = '/practice-areas/truck-accident-lawyers/18-wheeler-semi-truck-accident/';
$st_fat   = '/practice-areas/truck-accident-lawyers/fatigued-trucker-accident/';
$st_cargo = '/practice-areas/truck-accident-lawyers/overloaded-improperly-loaded-cargo/';
$st_brake = '/practice-areas/truck-accident-lawyers/brake-failure-accident/';
$st_under = '/practice-areas/truck-accident-lawyers/underride-override-accident/';
$st_deliv = '/practice-areas/truck-accident-lawyers/commercial-van-delivery-truck-accident/';
$st_haz   = '/practice-areas/truck-accident-lawyers/hazardous-materials-accident/';
$st_jack  = '/practice-areas/truck-accident-lawyers/jackknife-accident/';

// Cross-market corridor links
$i95_chs = '/resources/i-526-truck-accidents-charleston/';
$i95_wid = '/resources/i-95-widening-construction-zone-ga-sc/';

// Construction zone cross-links
$cz_i526 = '/resources/i-526-construction-zone-truck-accidents-charleston/';
$cz_caro = '/resources/carolina-crossroads-construction-zone-truck-accidents/';

$resources = array(
    'i-95-truck-accidents-savannah-brunswick' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_fat,   'text' => 'Fatigued Trucker Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_under, 'text' => 'Underride & Override Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $i95_wid,  'text' => 'I-95 Widening Project Truck Accidents' ),
    ),
    'i-16-truck-accidents-savannah' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_fat,   'text' => 'Fatigued Trucker Accident Lawyers' ),
        array( 'url' => $st_jack,  'text' => 'Jackknife Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'i-516-truck-accidents-port-savannah' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'port-of-savannah-truck-routes' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $st_haz,   'text' => 'Hazardous Materials Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'pooler-warehouse-district-truck-accidents' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'logging-truck-accidents-us-17-mcintosh-glynn' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $st_brake, 'text' => 'Brake Failure Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $spinal,   'text' => 'Spinal Cord Injury Lawyers' ),
    ),
    'abercorn-street-truck-accidents-savannah' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $ped,      'text' => 'Pedestrian Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'bay-street-truck-accidents-savannah-historic-district' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $ped,      'text' => 'Pedestrian Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'dean-forest-road-truck-accidents-pooler' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'jimmy-deloach-connector-truck-accidents-savannah' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'ogeechee-road-truck-accidents-savannah' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'i-16-i-95-construction-zone-truck-accidents' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_brake, 'text' => 'Brake Failure Accident Lawyers' ),
        array( 'url' => $constr,   'text' => 'Construction Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $cz_i526,  'text' => 'I-526 Construction Zone Truck Accidents' ),
        array( 'url' => $cz_caro,  'text' => 'Carolina Crossroads Construction Zone Truck Accidents' ),
    ),
    'i-95-widening-construction-zone-ga-sc' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_brake, 'text' => 'Brake Failure Accident Lawyers' ),
        array( 'url' => $constr,   'text' => 'Construction Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $cz_i526,  'text' => 'I-526 Construction Zone Truck Accidents' ),
        array( 'url' => $cz_caro,  'text' => 'Carolina Crossroads Construction Zone Truck Accidents' ),
    ),
);

$updated = 0;
foreach ( $resources as $slug => $links ) {
    $posts = get_posts( array(
        'post_type'   => 'resource',
        'name'        => $slug,
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
WP_CLI::success( "Done! Updated {$updated} Savannah-market resources." );
