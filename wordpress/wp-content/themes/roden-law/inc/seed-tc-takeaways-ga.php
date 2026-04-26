<?php
/**
 * Seeder: Key Takeaways for GA Truck Corridor Pages (6 pages)
 *
 * wp eval-file wp-content/themes/roden-law/inc/seed-tc-takeaways-ga.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$takeaways = array(

    'i-95-truck-accidents-savannah-brunswick' => 'I-95 between Savannah and Brunswick is one of the <strong>most dangerous truck corridors in America</strong>, carrying heavy Port of Savannah freight through rural stretches with longer emergency response times. Georgia recorded <strong>257 truck fatalities in 2023</strong>, an 81% increase since 2013. Active GDOT construction at the I-16/I-95 interchange and I-95 widening in Glynn County add construction zone hazards. Georgia gives injury victims <strong>2 years to file a lawsuit</strong> (<strong>O.C.G.A. &sect; 9-3-33</strong>) and allows recovery if less than <strong>50% at fault</strong>. Contact an attorney within 24&ndash;48 hours to preserve critical ELD and dash cam evidence.',

    'i-16-truck-accidents-savannah' => 'I-16 is ranked the <strong>3rd deadliest highway in Georgia</strong> and carries the bulk of Port of Savannah freight, with roughly <strong>30,000 truck trips daily</strong> through Chatham County. Known as "The Devil\'s Highway," the corridor features active GDOT construction zones, two-lane rural stretches, and relentless tractor-trailer volume. Georgia\'s truck fatalities rose <strong>81% from 2013 to 2023</strong> (142 to 257). You have <strong>2 years to file an injury claim</strong> (<strong>O.C.G.A. &sect; 9-3-33</strong>) and can recover damages if less than <strong>50% at fault</strong>.',

    'i-516-truck-accidents-port-savannah' => 'I-516 (W.F. Lynes Parkway) is a <strong>6.49-mile auxiliary interstate</strong> connecting southern Savannah to the Port of Savannah and I-16. It carries a significant share of the <strong>30,000 daily truck trips</strong> through Chatham County on compact interchanges with short merge zones and close residential proximity. Merge collisions, rear-end crashes in commuter congestion, and cargo spills are common crash types. Georgia law provides <strong>2 years to file</strong> (<strong>O.C.G.A. &sect; 9-3-33</strong>) and recovery if less than <strong>50% at fault</strong>.',

    'port-of-savannah-truck-routes' => 'The Port of Savannah generates <strong>14,000&ndash;16,000 truck moves per day</strong> on local roads including Bay Street (through the Historic District), DeRenne Avenue, Abercorn Street, and Dean Forest Road. Port truck crashes involve complex liability chains: <strong>truck driver, trucking company, chassis leasing company, cargo shipper, and terminal operator</strong> may all be responsible. The port\'s <strong>$1.9 billion expansion</strong> will increase truck volumes further. Georgia gives victims <strong>2 years to file</strong> (<strong>O.C.G.A. &sect; 9-3-33</strong>) with recovery if less than <strong>50% at fault</strong>.',

    'pooler-warehouse-district-truck-accidents' => 'Pooler sits at the <strong>I-95/I-16 intersection</strong> with nearly <strong>3 million square feet of warehouse space</strong>, generating enormous truck traffic on roads shared with a rapidly growing residential population. Dean Forest Road, Pooler Parkway, and the I-95/I-16 interchange are the most dangerous corridors. Warehouse operators, trucking companies, and cargo shippers may all share liability. Georgia law provides <strong>2 years to file an injury claim</strong> (<strong>O.C.G.A. &sect; 9-3-33</strong>) and recovery if less than <strong>50% at fault</strong>.',

    'logging-truck-accidents-us-17-mcintosh-glynn' => 'Logging trucks on US-17 and rural roads in McIntosh and Glynn counties create unique hazards: <strong>unsecured heavy timber on open trailers</strong>, slow operating speeds creating dangerous speed differentials, and debris shedding onto the roadway. FMCSA cargo securement regulations (<strong>49 CFR &sect; 393.116</strong>) set specific tie-down requirements for logs. Multiple parties may be liable including the truck driver, trucking company, loading crew, and timber harvesting company. Georgia provides <strong>2 years to file</strong> (<strong>O.C.G.A. &sect; 9-3-33</strong>) with recovery if less than <strong>50% at fault</strong>.',
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
