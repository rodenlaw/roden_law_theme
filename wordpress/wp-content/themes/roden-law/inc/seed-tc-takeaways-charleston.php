<?php
/**
 * Seeder: Key Takeaways for Charleston Truck Corridor Pages (6 pages)
 *
 * wp eval-file wp-content/themes/roden-law/inc/seed-tc-takeaways-charleston.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$takeaways = array(

    'i-526-truck-accidents-charleston' => 'I-526 (Mark Clark Expressway) connects the Port of Charleston\'s two major terminals and carries some of the heaviest commercial truck traffic in South Carolina. The <strong>I-26/I-526 interchange recorded 354 collisions over 5 years</strong>. Charleston County recorded more than <strong>2,500 truck-related accidents in 2023</strong>. Port truck crashes involve multiple liable parties: driver, carrier, <strong>chassis leasing company</strong>, terminal operator, and cargo shipper. South Carolina gives victims <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.',

    'port-of-charleston-truck-routes' => 'The Port of Charleston is the <strong>9th largest port in the United States</strong> with the deepest water in the Southeast, generating thousands of truck trips daily through Charleston\'s highway network. Key freight corridors include <strong>I-26, I-526, Port Access Road, and Rivers Avenue</strong>. Port truck liability is complex: up to <strong>5&ndash;6 defendants</strong> including the driver, motor carrier, chassis lessor, container shipper, and terminal operator. South Carolina provides <strong>3 years to file an injury claim</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.',

    'rivers-avenue-truck-accidents-north-charleston' => 'Rivers Avenue (US-52) is one of the <strong>four deadliest roads in Charleston County</strong> and North Charleston\'s primary commercial corridor. The <strong>Rivers Avenue/I-526 interchange produced 62 injuries over a 5-year study period</strong>. Heavy truck traffic from port and industrial facilities, Boeing South Carolina, and commercial development create constant hazards. Recent crashes include a <strong>cement truck rollover</strong> and a tractor-trailer striking the I-526 overhead sign. South Carolina gives victims <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.',

    'ashley-phosphate-i-26-truck-accidents' => 'The intersection of <strong>Ashley Phosphate Road and I-26</strong> is the <strong>most dangerous intersection in all of South Carolina</strong>, averaging <strong>a crash once every three days</strong>. High-speed I-26 off-ramp traffic, complex left turns, and heavy commercial truck volume are the primary factors. Common crash types include left-turn collisions, rear-end crashes from sudden stops, T-bone accidents from red-light runners, and pedestrian strikes. South Carolina provides <strong>3 years to file an injury claim</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.',

    'summerville-truck-accidents-i-26-corridor' => 'Summerville ranks among the <strong>top 20 most dangerous cities nationally for car accidents</strong>, and the I-26 corridor through the area carries heavy commercial truck traffic between Charleston and Columbia. Five roads account for half of serious-injury crashes: <strong>US-17A, Berlin G. Myers Parkway, Old Trolley Road, Dorchester Road, and Central Avenue</strong>. Rapid population growth has outpaced road infrastructure. South Carolina gives victims <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.',

    'mount-pleasant-truck-accidents-wando-welch' => 'The <strong>Wando Welch Terminal</strong> in Mount Pleasant is a major Port of Charleston container terminal generating heavy truck traffic on <strong>Long Point Road and I-526</strong>. Mount Pleasant is primarily residential and suburban, creating a dangerous mix when <strong>80,000-pound trucks share roads with shoppers at Towne Centre</strong> and neighborhood commuters. Chassis defects from intermodal leasing companies are a common liability factor. South Carolina provides <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.',
);

$updated = 0;
$skipped = 0;

foreach ( $takeaways as $slug => $text ) {
    $post = get_page_by_path( $slug, OBJECT, 'resource' );
    if ( ! $post ) {
        WP_CLI::warning( "NOT FOUND: \"{$slug}\"" );
        continue;
    }
    $existing = get_post_meta( $post->ID, '_roden_key_takeaways', true );
    if ( $existing ) {
        WP_CLI::log( "SKIP: \"{$post->post_title}\" (ID {$post->ID})" );
        $skipped++;
        continue;
    }
    update_post_meta( $post->ID, '_roden_key_takeaways', wp_kses_post( $text ) );
    WP_CLI::success( "UPDATED: \"{$post->post_title}\" (ID {$post->ID})" );
    $updated++;
}

WP_CLI::log( "Done. Updated: {$updated} | Skipped: {$skipped}" );
