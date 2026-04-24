<?php
/**
 * Seeder: Spruill Avenue & North Rhett Port Trucks
 *
 * Run: wp eval-file wp-content/themes/roden-law/inc/seed-tc-chs-spruill.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

WP_CLI::log( 'Creating spruill-avenue-port-trucks-north-charleston...' );

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $graeham ? $graeham->ID : 0;

$t = term_exists( 'truck-accidents', 'practice_category' );
if ( ! $t ) {
    $t = wp_insert_term( 'Truck Accidents', 'practice_category', array( 'slug' => 'truck-accidents' ) );
}
$truck_term_id = is_array( $t ) ? (int) $t['term_id'] : (int) $t;

$existing = get_page_by_path( 'spruill-avenue-port-trucks-north-charleston', OBJECT, 'resource' );
if ( $existing ) {
    WP_CLI::log( "SKIP: already exists (ID {$existing->ID})" );
    return;
}

$content = '<h2>Port Trucks on Neighborhood Streets: The Spruill Avenue &amp; North Rhett Problem</h2>';
$content .= '<p>North Charleston residents in the <strong>Park Circle</strong> and <strong>Chicora-Cherokee</strong> neighborhoods live with a daily hazard most suburban communities never face: <strong>port trucks traveling through residential streets</strong> to access I-526. Tractor-trailers carrying shipping containers from the North Charleston Terminal and other port facilities use <strong>Spruill Avenue</strong> heading north, then cut through <strong>North Rhett Avenue</strong> — a residential street — to reach the I-526 interchange.</p>';
$content .= '<p>These trucks have been clocked at <strong>50 mph through residential areas</strong>, passing <strong>every 5 to 10 minutes</strong> during peak hours. The result is a sustained safety crisis for families, pedestrians, and cyclists in neighborhoods that were never designed for 80,000-pound commercial vehicles.</p>';

$content .= '<h2>The Truck Route Problem</h2>';

$content .= '<h3>How Port Trucks Reach I-526</h3>';
$content .= '<p>Trucks leaving the North Charleston Terminal and port-adjacent warehouses travel north on Spruill Avenue, a four-lane road that passes through mixed commercial and residential areas. To access I-526, many trucks turn onto North Rhett Avenue — a two-lane residential street with homes, parked cars, and neighborhood foot traffic on both sides. The trucks then merge onto I-526 heading toward I-26 or the Wando Welch Terminal in Mount Pleasant.</p>';
$content .= '<p>This routing puts <strong>fully loaded container trucks on streets designed for neighborhood traffic</strong>. The weight, speed, and frequency of these trucks create noise, vibration, road damage, and — most critically — constant collision risk for residents.</p>';

$content .= '<h3>City Efforts to Reclaim Spruill Avenue</h3>';
$content .= '<p>The City of North Charleston has been working to <strong>obtain ownership of Spruill Avenue</strong> from SCDOT, with plans to <strong>reduce the road from four lanes to two</strong>, add bike lanes, and implement traffic calming measures. The goal is to transform Spruill Avenue from a truck throughway into a neighborhood-scale street. However, until those changes are implemented, port trucks continue to use the corridor at dangerous speeds and volumes.</p>';

$content .= '<h2>Recent Truck Incidents in the Area</h2>';

$content .= '<h3>Truck Strikes Railroad Overpass on Buist Avenue (May 2024)</h3>';
$content .= '<p>In May 2024, a truck struck a <strong>railroad overpass on Buist Avenue near Park Circle</strong>, damaging the bridge structure and blocking traffic. Buist Avenue connects directly to the Spruill Avenue corridor, and trucks navigating this area frequently misjudge clearance heights on older railroad bridges. An overheight strike can collapse bridge infrastructure onto vehicles below and shut down the road for extended periods.</p>';

$content .= '<h3>Reynolds Avenue Community Benefits Agreement (2019)</h3>';
$content .= '<p>The truck routing problem is not new. In 2019, the <strong>Chicora-Cherokee neighborhood</strong> negotiated a <strong>community benefits agreement with Frontier Logistics</strong> to keep tractor-trailers off Reynolds Avenue. That agreement acknowledged what residents had long known: port-related truck traffic on residential streets creates unacceptable safety risks. However, while Reynolds Avenue gained some protection, the truck traffic shifted to parallel routes including Spruill Avenue and North Rhett.</p>';

$content .= '<h2>Why Residential Street Truck Traffic Is So Dangerous</h2>';

$content .= '<h3>Speed and Stopping Distance</h3>';
$content .= '<p>Trucks traveling at <strong>50 mph on residential streets</strong> need approximately <strong>400 feet to stop</strong> — nearly one and a half football fields. Residential intersections, driveways, and crosswalks are spaced far closer than that. A child entering the street, a car backing out of a driveway, or a cyclist crossing an intersection has almost no margin of safety when a loaded container truck passes at speed.</p>';

$content .= '<h3>Road Design Mismatch</h3>';
$content .= '<p>North Rhett Avenue and surrounding residential streets were built for passenger vehicles. The lanes are narrow, there are no truck-rated shoulders, curb radii at intersections are tight, and utility poles sit close to the roadway. When a tractor-trailer navigates these streets, it must swing wide on turns, cross centerlines, and come within feet of parked cars and pedestrians. The road infrastructure simply cannot safely accommodate the volume and size of port truck traffic.</p>';

$content .= '<h3>Park Circle: Walkable Neighborhood Meets Industrial Traffic</h3>';
$content .= '<p><strong>Park Circle</strong> is one of North Charleston\'s most walkable neighborhoods, with restaurants, shops, a public park, and residential streets designed for foot traffic. Yet industrial truck traffic on adjacent streets — Spruill Avenue, North Rhett, and connecting roads — puts pedestrians and cyclists at constant risk. The contrast between the neighborhood\'s walkable character and the industrial truck volume on its borders creates a dangerous edge condition.</p>';

$content .= '<h3>Vibration and Road Damage</h3>';
$content .= '<p>Repeated passage of 80,000-pound trucks degrades residential road surfaces rapidly, creating potholes, cracked pavement, and uneven surfaces that make crashes more likely. The vibration from heavy trucks also damages homes and utilities along the route — a secondary harm that compounds the direct safety risk.</p>';

$content .= '<h2>Liable Parties When Port Trucks Crash in Neighborhoods</h2>';
$content .= '<table><thead><tr><th>Potentially Liable Party</th><th>Basis for Liability</th></tr></thead><tbody>';
$content .= '<tr><td>Truck driver</td><td>Speeding in residential zone, failure to yield to pedestrians, failure to observe posted truck restrictions</td></tr>';
$content .= '<tr><td>Motor carrier / trucking company</td><td>Routing drivers through residential streets, failure to train on local restrictions, HOS violations</td></tr>';
$content .= '<tr><td>Port terminal operator</td><td>Failing to direct outbound trucks to designated freight routes</td></tr>';
$content .= '<tr><td>Chassis leasing company</td><td>Defective brakes, tires, or lights on pooled intermodal chassis</td></tr>';
$content .= '<tr><td>Government entity</td><td>Failure to enforce truck restrictions, inadequate signage, failure to implement safety improvements (subject to <a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">SC Tort Claims Act</a>)</td></tr>';
$content .= '</tbody></table>';

$content .= '<h2>What to Do After a Truck Accident on Spruill Avenue or North Rhett</h2>';
$content .= '<ol>';
$content .= '<li><strong>Call 911 immediately</strong> — These crashes fall under North Charleston Police jurisdiction.</li>';
$content .= '<li><strong>Document the truck:</strong> Company name, USDOT number, container number, chassis markings, and the direction the truck was heading (toward I-526 or from the port terminal).</li>';
$content .= '<li><strong>Note the truck\'s speed:</strong> If the truck was traveling significantly faster than the residential speed limit, note your estimate and ask witnesses to confirm.</li>';
$content .= '<li><strong>Check for residential surveillance:</strong> Many Park Circle and Chicora-Cherokee homes have doorbell cameras and security systems that may have captured the crash or the truck\'s speed before the collision.</li>';
$content .= '<li><strong>Get medical treatment:</strong> MUSC Health and Trident Medical Center are both accessible from the area.</li>';
$content .= '<li><strong>Contact a truck accident attorney</strong> — Port truck evidence including terminal gate logs, ELD data, and chassis inspection records must be preserved immediately.</li>';
$content .= '</ol>';

$content .= '<h2>South Carolina Law</h2>';
$content .= '<ul>';
$content .= '<li><strong>Statute of limitations:</strong> 3 years from the date of injury (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code &sect; 15-3-530</a>)</li>';
$content .= '<li><strong>Comparative fault:</strong> South Carolina allows recovery if you are less than 51% at fault. Compensation is reduced by your percentage of fault.</li>';
$content .= '<li><strong>Punitive damages:</strong> Available when trucking companies knowingly route trucks through residential areas at unsafe speeds or ignore community agreements restricting truck traffic.</li>';
$content .= '</ul>';

$content .= '<h2>Free Consultation — Roden Law Charleston</h2>';
$content .= '<p>Roden Law\'s <a href="/locations/south-carolina/charleston/">Charleston office</a> represents residents injured by port truck traffic in Park Circle, Chicora-Cherokee, and throughout North Charleston. We understand port routing, intermodal liability, and the community impact of industrial truck traffic on residential streets. Call <a href="tel:+18437908999">(843) 790-8999</a> for a free consultation — no fees unless we win.</p>';
$content .= '<p>Related resources: <a href="/resources/port-of-charleston-truck-routes/">Port of Charleston Truck Routes</a> | <a href="/resources/rivers-avenue-truck-accidents-north-charleston/">Rivers Avenue Truck Accidents</a> | <a href="/resources/i-526-truck-accidents-charleston/">I-526 Truck Accidents</a></p>';

$takeaway = '<strong>Spruill Avenue</strong> and <strong>North Rhett Avenue</strong> carry port trucks through North Charleston\'s Park Circle and Chicora-Cherokee residential neighborhoods. Trucks are clocked at <strong>50 mph through residential areas</strong>, passing <strong>every 5&ndash;10 minutes</strong>. A truck struck a <strong>railroad overpass on Buist Avenue near Park Circle</strong> in May 2024. A 2019 community benefits agreement with Frontier Logistics banned tractor-trailers from Reynolds Avenue, but traffic shifted to parallel routes. The city is working to reduce Spruill Avenue from <strong>4 lanes to 2</strong>. South Carolina gives victims <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.';

$post_id = wp_insert_post( array(
    'post_type'    => 'resource',
    'post_title'   => 'Spruill Avenue &amp; North Rhett: Port Trucks Through North Charleston Neighborhoods',
    'post_name'    => 'spruill-avenue-port-trucks-north-charleston',
    'post_status'  => 'publish',
    'post_content' => $content,
    'post_excerpt' => 'Port trucks travel through North Charleston\'s Park Circle and Chicora-Cherokee neighborhoods on Spruill Avenue and North Rhett at 50 mph. Learn about the safety risks, recent incidents, and your legal rights.',
), true );

if ( is_wp_error( $post_id ) ) {
    WP_CLI::warning( 'FAILED: ' . $post_id->get_error_message() );
    return;
}

update_post_meta( $post_id, '_roden_author_attorney', $author_id );
update_post_meta( $post_id, '_roden_jurisdiction', 'sc' );
update_post_meta( $post_id, '_roden_key_takeaways', wp_kses_post( $takeaway ) );
update_post_meta( $post_id, '_roden_faqs', array(
    array(
        'question' => 'Why are port trucks driving through North Charleston residential neighborhoods?',
        'answer'   => 'Trucks leaving the North Charleston Terminal and port-adjacent warehouses travel north on Spruill Avenue, then use North Rhett Avenue — a residential street — to access I-526. This routing puts fully loaded container trucks on streets designed for neighborhood traffic. Trucks pass every 5 to 10 minutes during peak hours at speeds up to 50 mph.',
    ),
    array(
        'question' => 'What is the city doing about truck traffic on Spruill Avenue?',
        'answer'   => 'The City of North Charleston is working to obtain ownership of Spruill Avenue from SCDOT, with plans to reduce the road from four lanes to two, add bike lanes, and implement traffic calming measures. A 2019 community benefits agreement with Frontier Logistics already banned tractor-trailers from Reynolds Avenue, but truck traffic shifted to parallel routes. Until the Spruill Avenue changes are implemented, port trucks continue using the corridor.',
    ),
    array(
        'question' => 'Who is liable when a port truck crashes in a residential neighborhood?',
        'answer'   => 'Multiple parties may share liability: the truck driver (for speeding in a residential zone), the motor carrier (for routing drivers through neighborhoods), the port terminal operator (for failing to direct trucks to designated freight routes), the chassis leasing company (for equipment defects), and government entities (for failing to enforce truck restrictions or install safety improvements).',
    ),
    array(
        'question' => 'Can I sue if a port truck damaged my home or property from vibration or a crash?',
        'answer'   => 'Yes. If a port truck caused a collision that damaged your property, or if ongoing heavy truck traffic has caused structural damage to your home through vibration, you may have claims against the trucking company, motor carrier, and potentially the port authority or government entity responsible for routing. South Carolina provides 3 years to file (S.C. Code Section 15-3-530).',
    ),
    array(
        'question' => 'What evidence should I collect after a truck crash on Spruill Avenue or North Rhett?',
        'answer'   => 'Document the truck\'s company name, USDOT number, container number, and chassis pool markings. Note the truck\'s estimated speed and direction of travel. Check for doorbell cameras and home security footage from nearby residences — Park Circle and Chicora-Cherokee homes often have surveillance that captures truck traffic. Contact an attorney immediately to preserve terminal gate logs and ELD data.',
    ),
) );
wp_set_object_terms( $post_id, array( $truck_term_id ), 'practice_category' );

WP_CLI::success( "CREATED: Spruill Avenue & North Rhett Port Trucks (ID {$post_id})" );
