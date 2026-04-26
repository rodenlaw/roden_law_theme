<?php
/**
 * Seeder: Key Takeaways for Columbia + Myrtle Beach Truck Corridor Pages (7 pages)
 *
 * wp eval-file wp-content/themes/roden-law/inc/seed-tc-takeaways-columbia-mb.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$takeaways = array(

    /* Columbia (4) */

    'i-20-truck-accidents-columbia' => 'I-20 is the primary east-west freight artery through the South Carolina Midlands, carrying thousands of tractor-trailers daily through Lexington and Richland counties. South Carolina recorded <strong>3,167 large truck crashes in 2024</strong> with a <strong>23% increase in fatal truck accidents</strong>. Explosive growth in distribution and logistics along the I-20 corridor in <strong>Lexington County</strong> is driving more truck volume onto roads shared with commuters. South Carolina gives victims <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.',

    'i-77-truck-accidents-columbia-rock-hill' => 'I-77 connects Columbia to Rock Hill and Charlotte, serving as a major <strong>freight pipeline between the Charlotte logistics hub and South Carolina</strong>. The corridor passes near Fort Jackson and through rapidly growing communities including Blythewood and Forest Acres. Richland County consistently reports one of the <strong>highest crash rates in South Carolina</strong>. Fatigue-related crashes peak on rural stretches through Fairfield County. South Carolina gives victims <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.',

    'columbia-i-26-i-20-i-77-interchange-truck-accidents' => 'Columbia is the only city in South Carolina where <strong>three major interstates (I-26, I-20, I-77) converge</strong>, creating one of the state\'s most complex and dangerous truck corridors. The interchange complex requires rapid lane changes, weaving movements, and navigation of merge zones at highway speed. Richland County reports one of the <strong>highest crash rates in South Carolina</strong>. Multiple liable parties may include truck drivers, carriers, and potentially <strong>SCDOT for interchange design deficiencies</strong>. You have <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>).',

    'lexington-county-truck-accidents-distribution-corridor' => 'Lexington County is a rapidly growing <strong>logistics and distribution hub</strong> along the I-20 corridor, anchored by facilities like Southern Glazer\'s <strong>$80 million distribution center</strong>. Heavy truck traffic from warehouses mixes with suburban residential traffic in Lexington, Irmo, West Columbia, and Cayce. Warehouse operators, trucking companies, and cargo shippers may all share liability. Unique evidence includes <strong>loading dock records, delivery manifests, and weight tickets</strong>. South Carolina provides <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>).',

    /* Myrtle Beach (3) */

    'highway-501-truck-accidents-conway-myrtle-beach' => 'Highway 501 is the <strong>most dangerous truck corridor in the Grand Strand</strong>. The SCDOT ranked the <strong>Highway 501 &amp; Four Mile Road intersection</strong> in Conway as its <strong>highest priority for safety improvements</strong>, with <strong>42 accidents since 2008 including 2 fatal crashes</strong>. An active SCDOT widening project adds construction zone hazards. Every restaurant, hotel, and retail store on the Grand Strand receives truck deliveries via 501. South Carolina gives victims <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.',

    'us-17-truck-accidents-grand-strand' => 'Unlike most South Carolina markets, <strong>trucks in Myrtle Beach travel down Main Street and side streets</strong>, mixing directly with tourist pedestrians and cyclists. A <strong>pedestrian was killed by a tractor-trailer on US-17 north of River Road</strong> in January 2026. The US-17 Bypass from Murrells Inlet to North Myrtle Beach experiences frequent bumper-to-bumper backups that produce rear-end truck collisions. Kings Highway and Ocean Boulevard are high-risk corridors combining truck deliveries with heavy foot traffic. You have <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>).',

    'seasonal-truck-accidents-myrtle-beach' => 'Myrtle Beach\'s population <strong>roughly triples during summer tourist season</strong>, triggering a massive surge in <strong>delivery trucks, fuel tankers, construction vehicles, and moving trucks</strong> on roads already overwhelmed by visitors. No other law firm covers this unique seasonal danger. Peak months are <strong>June through August</strong> when all truck types operate at maximum volume simultaneously. Rental moving trucks driven by vacationers with no CDL create additional hazards. South Carolina gives victims <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.',
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
