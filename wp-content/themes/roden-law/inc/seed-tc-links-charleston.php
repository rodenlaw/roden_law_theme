<?php
/**
 * Seeder: Inject internal links into Charleston-market truck corridor resources.
 *
 * Usage: wp eval-file wp-content/themes/roden-law/inc/seed-tc-links-charleston.php
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

$st_18w   = '/practice-areas/truck-accident-lawyers/18-wheeler-semi-truck-accident/';
$st_fat   = '/practice-areas/truck-accident-lawyers/fatigued-trucker-accident/';
$st_cargo = '/practice-areas/truck-accident-lawyers/overloaded-cargo-accident/';
$st_brake = '/practice-areas/truck-accident-lawyers/brake-failure-accident/';
$st_under = '/practice-areas/truck-accident-lawyers/underride-override-accident/';
$st_deliv = '/practice-areas/truck-accident-lawyers/commercial-van-delivery-truck-accident/';
$st_haz   = '/practice-areas/truck-accident-lawyers/hazardous-materials-accident/';
$st_jack  = '/practice-areas/truck-accident-lawyers/jackknife-accident/';

// Cross-market: I-26 connects Charleston ↔ Columbia
$i26_col  = '/resources/columbia-i-26-i-20-i-77-interchange-truck-accidents/';
$summ_i26 = '/resources/summerville-truck-accidents-i-26-corridor/';

// Construction zone cross-links
$cz_i16   = '/resources/i-16-i-95-construction-zone-truck-accidents/';
$cz_caro  = '/resources/carolina-crossroads-construction-zone-truck-accidents/';
$cz_i95w  = '/resources/i-95-widening-construction-zone-ga-sc/';

$resources = array(
    'i-526-truck-accidents-charleston' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $st_under, 'text' => 'Underride & Override Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'port-of-charleston-truck-routes' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $st_haz,   'text' => 'Hazardous Materials Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'rivers-avenue-truck-accidents-north-charleston' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $ped,      'text' => 'Pedestrian Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'ashley-phosphate-i-26-truck-accidents' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_jack,  'text' => 'Jackknife Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $i26_col,  'text' => 'Columbia I-26/I-20/I-77 Interchange Truck Accidents' ),
    ),
    'summerville-truck-accidents-i-26-corridor' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_fat,   'text' => 'Fatigued Trucker Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $i26_col,  'text' => 'Columbia I-26/I-20/I-77 Interchange Truck Accidents' ),
    ),
    'mount-pleasant-truck-accidents-wando-welch' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'dorchester-road-truck-accidents-north-charleston' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $ped,      'text' => 'Pedestrian Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'spruill-avenue-port-trucks-north-charleston' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'port-access-road-truck-accidents-leatherman-terminal' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $st_haz,   'text' => 'Hazardous Materials Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'aviation-avenue-i-26-truck-accidents' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_fat,   'text' => 'Fatigued Trucker Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $i26_col,  'text' => 'Columbia I-26/I-20/I-77 Interchange Truck Accidents' ),
    ),
    'i-526-construction-zone-truck-accidents-charleston' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_brake, 'text' => 'Brake Failure Accident Lawyers' ),
        array( 'url' => $constr,   'text' => 'Construction Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $spinal,   'text' => 'Spinal Cord Injury Lawyers' ),
        array( 'url' => $cz_i16,   'text' => 'I-16/I-95 Construction Zone Truck Accidents' ),
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
WP_CLI::success( "Done! Updated {$updated} Charleston-market resources." );
