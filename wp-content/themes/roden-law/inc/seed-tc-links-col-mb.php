<?php
/**
 * Seeder: Inject internal links into Columbia + Myrtle Beach truck corridor resources.
 *
 * Usage: wp eval-file wp-content/themes/roden-law/inc/seed-tc-links-col-mb.php
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
$st_cargo = '/practice-areas/truck-accident-lawyers/overloaded-improperly-loaded-cargo/';
$st_brake = '/practice-areas/truck-accident-lawyers/brake-failure-accident/';
$st_under = '/practice-areas/truck-accident-lawyers/underride-override-accident/';
$st_deliv = '/practice-areas/truck-accident-lawyers/commercial-van-delivery-truck-accident/';
$st_haz   = '/practice-areas/truck-accident-lawyers/hazardous-materials-accident/';
$st_jack  = '/practice-areas/truck-accident-lawyers/jackknife-accident/';

// Cross-market: I-26 connects Columbia ↔ Charleston
$i26_summ = '/resources/summerville-truck-accidents-i-26-corridor/';
$i26_ash  = '/resources/ashley-phosphate-i-26-truck-accidents/';

// Construction zone cross-links
$cz_i526  = '/resources/i-526-construction-zone-truck-accidents-charleston/';
$cz_i16   = '/resources/i-16-i-95-construction-zone-truck-accidents/';

$resources = array(
    // ── COLUMBIA MARKET ──
    'i-20-truck-accidents-columbia' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_fat,   'text' => 'Fatigued Trucker Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_jack,  'text' => 'Jackknife Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'i-77-truck-accidents-columbia-rock-hill' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_fat,   'text' => 'Fatigued Trucker Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_under, 'text' => 'Underride & Override Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'columbia-i-26-i-20-i-77-interchange-truck-accidents' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_jack,  'text' => 'Jackknife Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $i26_summ, 'text' => 'Summerville Truck Accidents on I-26 Corridor' ),
        array( 'url' => $i26_ash,  'text' => 'Ashley Phosphate & I-26 Truck Accidents' ),
    ),
    'lexington-county-truck-accidents-distribution-corridor' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'broad-river-road-truck-accidents-columbia' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'two-notch-road-truck-accidents-columbia' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $ped,      'text' => 'Pedestrian Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'bush-river-road-i-26-truck-accidents-columbia' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_fat,   'text' => 'Fatigued Trucker Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $i26_summ, 'text' => 'Summerville Truck Accidents on I-26 Corridor' ),
    ),
    'carolina-crossroads-construction-zone-truck-accidents' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_brake, 'text' => 'Brake Failure Accident Lawyers' ),
        array( 'url' => $constr,   'text' => 'Construction Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
        array( 'url' => $spinal,   'text' => 'Spinal Cord Injury Lawyers' ),
        array( 'url' => $cz_i526,  'text' => 'I-526 Construction Zone Truck Accidents' ),
        array( 'url' => $cz_i16,   'text' => 'I-16/I-95 Construction Zone Truck Accidents' ),
    ),
    'blythewood-i-77-truck-accidents' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_fat,   'text' => 'Fatigued Trucker Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    // ── MYRTLE BEACH MARKET ──
    'highway-501-truck-accidents-conway-myrtle-beach' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_fat,   'text' => 'Fatigued Trucker Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'us-17-truck-accidents-grand-strand' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $ped,      'text' => 'Pedestrian Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'seasonal-truck-accidents-myrtle-beach' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_fat,   'text' => 'Fatigued Trucker Accident Lawyers' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $ped,      'text' => 'Pedestrian Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'highway-22-truck-accidents-conway-bypass' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_fat,   'text' => 'Fatigued Trucker Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'us-17-sc-544-truck-accidents-surfside-beach' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_deliv, 'text' => 'Commercial Van & Delivery Truck Accident Lawyers' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $ped,      'text' => 'Pedestrian Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'us-52-truck-train-accidents-goose-creek' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_haz,   'text' => 'Hazardous Materials Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
    ),
    'georgetown-county-us-17-truck-accidents' => array(
        array( 'url' => $pillar,   'text' => 'Truck Accident Lawyers — Georgia & South Carolina' ),
        array( 'url' => $st_18w,   'text' => '18-Wheeler & Semi-Truck Accident Lawyers' ),
        array( 'url' => $st_cargo, 'text' => 'Overloaded & Improperly Loaded Cargo Accident Lawyers' ),
        array( 'url' => $wd,       'text' => 'Wrongful Death Lawyers' ),
        array( 'url' => $brain,    'text' => 'Brain Injury Lawyers' ),
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
WP_CLI::success( "Done! Updated {$updated} Columbia + Myrtle Beach resources." );
