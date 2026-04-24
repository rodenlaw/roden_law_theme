<?php
/**
 * Seeder: Highway 22 Truck Accidents: Conway Bypass
 *
 * Run: wp eval-file wp-content/themes/roden-law/inc/seed-tc-mb-hwy22.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

WP_CLI::log( 'Creating highway-22-truck-accidents-conway-bypass...' );

$atty = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $atty ? $atty->ID : 0;

$t = term_exists( 'truck-accidents', 'practice_category' );
if ( ! $t ) {
    $t = wp_insert_term( 'Truck Accidents', 'practice_category', array( 'slug' => 'truck-accidents' ) );
}
$truck_term_id = is_array( $t ) ? (int) $t['term_id'] : (int) $t;

$existing = get_page_by_path( 'highway-22-truck-accidents-conway-bypass', OBJECT, 'resource' );
if ( $existing ) {
    WP_CLI::log( "SKIP: already exists (ID {$existing->ID})" );
    return;
}

$content = '<h2>Highway 22 (Conway Bypass): A Deadly Truck Corridor to the Grand Strand</h2>';
$content .= '<p><strong>Highway 22</strong>, known as the <strong>Conway Bypass</strong>, connects I-95 to the Grand Strand and serves as one of the primary routes for freight traffic entering the Myrtle Beach market. Every delivery truck, dump truck, construction vehicle, and through-freight rig serving the coastal tourism economy travels this corridor. The road\'s high speeds, bridge sections, and heavy truck traffic create conditions for catastrophic crashes.</p>';
$content .= '<p>Horry County records over <strong>11,000 crashes per year</strong>, and Highway 22 is emerging as one of the most dangerous corridors in the county for truck-involved collisions — with multiple fatal crashes in recent years demonstrating the escalating severity of the problem.</p>';

$content .= '<h2>Fatal Truck Crashes on Highway 22</h2>';

$content .= '<h3>Waccamaw River Bridge Disaster — August 2025</h3>';
$content .= '<p>In <strong>August 2025, a dump truck rear-ended stopped traffic near the Waccamaw River bridge</strong> on Highway 22. The impact pushed a Jeep over the bridge railing and into the river below. <strong>Two people were killed: Flora Beltran-Gomez, 35, and Earl Burnette, 49.</strong> A third person was hospitalized with serious injuries. This crash illustrates the unique danger of truck accidents on bridge sections — there is nowhere to go when an 80,000-pound vehicle strikes from behind. Bridge railings designed to contain passenger vehicles cannot absorb the force of a truck pushing another vehicle against them.</p>';

$content .= '<h3>Multi-Vehicle Fatal Crash — February 2026</h3>';
$content .= '<p>In <strong>February 2026, a multi-vehicle fatal crash on Highway 22 killed 1 person</strong>. Details of the crash underscore the corridor\'s pattern: high-speed traffic, heavy vehicles, and limited escape routes combine to turn collisions into fatalities. Multi-vehicle crashes on Highway 22 often begin with a single truck impact that cascades into a chain reaction, as following vehicles cannot stop or maneuver in time to avoid the initial collision scene.</p>';

$content .= '<h2>Why Highway 22 Is Dangerous for Truck Accidents</h2>';

$content .= '<h3>Bridge Sections Create Kill Zones</h3>';
$content .= '<p>Highway 22 crosses the Waccamaw River and its surrounding wetlands on elevated bridge sections that create confined corridors with concrete barriers on both sides. When a truck crash occurs on a bridge section, vehicles cannot leave the roadway to avoid the collision. The August 2025 crash proved that bridge railings provide no protection when a truck pushes a vehicle sideways — the Jeep went over the railing and fell into the river. These bridge sections transform what might be a survivable shoulder collision on open road into a fatal plunge.</p>';

$content .= '<h3>High-Speed Design</h3>';
$content .= '<p>Highway 22 was designed as a limited-access bypass with highway-speed traffic. Posted speeds of 65 mph mean that all vehicles — including loaded trucks — travel at speeds where stopping distances are measured in hundreds of feet. A fully loaded truck at 65 mph needs approximately 525 feet to stop. When traffic slows or stops ahead — due to a crash, construction, or congestion near the Highway 31 interchange — following trucks may not have sufficient distance to stop safely.</p>';

$content .= '<h3>Heavy Truck Traffic Mix</h3>';
$content .= '<p>Highway 22 carries a diverse and dangerous mix of heavy vehicles: <strong>dump trucks</strong> serving the Grand Strand\'s constant construction activity, <strong>construction equipment haulers</strong> with oversized loads, <strong>tractor-trailers</strong> delivering goods to Myrtle Beach\'s tourism infrastructure, and <strong>through-freight</strong> using the bypass to avoid Conway\'s congested surface roads. Dump trucks are particularly dangerous because they are often overloaded, have poor rear visibility, and scatter debris that creates secondary hazards for following vehicles.</p>';

$content .= '<h3>I-95 Connection Traffic</h3>';
$content .= '<p>Highway 22\'s western terminus connects to I-95, the East Coast\'s primary freight artery. Trucks exiting I-95 onto Highway 22 transition from a multi-lane interstate to a two-lane-per-direction bypass. Drivers fatigued from long I-95 hauls may be less alert as they approach their final destination. The I-95/Highway 22 interchange produces merge conflicts between interstate through-traffic and trucks entering the bypass.</p>';

$content .= '<h2>Common Truck Crash Types on Highway 22</h2>';

$content .= '<h3>Rear-End Collisions</h3>';
$content .= '<p>The most frequent and most deadly crash type on Highway 22. Trucks traveling at highway speed strike stopped or slow-moving traffic. On bridge sections, the struck vehicle has nowhere to go — it is pushed into the vehicle ahead, into the barrier, or over the railing. The August 2025 Waccamaw River bridge crash is the textbook example: a dump truck rear-ended stopped traffic, killing two people.</p>';

$content .= '<h3>Multi-Vehicle Chain Reactions</h3>';
$content .= '<p>High-speed rear-end impacts by trucks create chain-reaction crashes involving multiple vehicles. The initial truck impact propels the struck vehicle into the next vehicle ahead, which strikes the next, and so on. On bridge sections with barriers, vehicles cannot escape the chain. The February 2026 multi-vehicle fatal crash followed this pattern.</p>';

$content .= '<h3>Debris and Cargo Spill Crashes</h3>';
$content .= '<p>Dump trucks and construction haulers traveling Highway 22 shed gravel, sand, construction materials, and equipment from unsecured loads. Following vehicles strike debris at highway speed, causing tire blowouts, windshield strikes, and loss-of-control crashes. On bridge sections, debris cannot be avoided by swerving because barriers confine the roadway.</p>';

$content .= '<h3>Merge and Lane-Change Crashes</h3>';
$content .= '<p>At the Highway 31 interchange and the I-95 connection, merging truck traffic creates sideswipe and forced-off-road crashes. Trucks attempting to merge into traffic or change lanes misjudge gaps or fail to check blind spots, striking adjacent vehicles.</p>';

$content .= '<h2>Liable Parties</h2>';
$content .= '<table><thead><tr><th>Potentially Liable Party</th><th>Basis for Liability</th></tr></thead><tbody>';
$content .= '<tr><td>Truck/dump truck driver</td><td>Following too closely, distracted driving, fatigue from I-95 haul, failure to slow for traffic conditions</td></tr>';
$content .= '<tr><td>Trucking company</td><td>HOS violations, failure to maintain brakes, negligent hiring, pressure to meet delivery schedules</td></tr>';
$content .= '<tr><td>Construction company</td><td>Overloaded dump trucks, unsecured cargo, failure to cover loads, using unqualified drivers</td></tr>';
$content .= '<tr><td>Government entity (SCDOT)</td><td>Inadequate bridge railing design, failure to install truck-rated barriers, insufficient warning signage for stopped traffic (subject to <a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">SC Tort Claims Act, S.C. Code &sect; 15-78-80</a>)</td></tr>';
$content .= '<tr><td>Vehicle manufacturer</td><td>Brake system defects, defective or missing collision avoidance systems</td></tr>';
$content .= '</tbody></table>';

$content .= '<h2>What to Do After a Truck Accident on Highway 22</h2>';
$content .= '<ol>';
$content .= '<li><strong>Call 911 immediately</strong> — Highway 22 crashes are handled by South Carolina Highway Patrol and Horry County emergency services.</li>';
$content .= '<li><strong>Move to safety if possible</strong> — On bridge sections, stay inside your vehicle if you cannot safely exit. Secondary collisions are a major risk on high-speed corridors.</li>';
$content .= '<li><strong>Document the truck:</strong> Company name, USDOT number, trailer/dump truck number, cargo type, and whether the truck was loaded or empty.</li>';
$content .= '<li><strong>Photograph everything:</strong> Bridge railing damage, skid marks, debris fields, vehicle positions, and any cargo spilled from the truck.</li>';
$content .= '<li><strong>Get medical treatment:</strong> Grand Strand Medical Center or Conway Medical Center are the closest facilities.</li>';
$content .= '<li><strong>Contact a truck accident attorney within 24-48 hours</strong> — ELD data, dash cam footage, and dump truck weight tickets must be preserved before they are destroyed.</li>';
$content .= '</ol>';

$content .= '<h2>South Carolina Law</h2>';
$content .= '<ul>';
$content .= '<li><strong>Statute of limitations:</strong> 3 years from the date of injury (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code &sect; 15-3-530</a>)</li>';
$content .= '<li><strong>Comparative fault:</strong> South Carolina allows recovery if you are less than 51% at fault. Your compensation is reduced by your percentage of fault.</li>';
$content .= '<li><strong>Wrongful death:</strong> Families of those killed in Highway 22 truck crashes may file wrongful death claims for medical expenses, funeral costs, lost income, and loss of companionship</li>';
$content .= '<li><strong>Punitive damages:</strong> Available when truck drivers or companies demonstrated willful disregard for safety, such as overloading dump trucks or falsifying driving logs</li>';
$content .= '</ul>';

$content .= '<h2>Free Consultation — Roden Law Myrtle Beach</h2>';
$content .= '<p>Roden Law\'s <a href="/locations/south-carolina/myrtle-beach/">Myrtle Beach office</a> at 631 Bellamy Ave., Suite C-B in Murrells Inlet handles truck accident cases on Highway 22 and throughout the Grand Strand. We investigate dump truck and commercial truck crashes aggressively, preserve critical evidence, and fight for full compensation. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free consultation — no fees unless we win.</p>';
$content .= '<p>Related resources: <a href="/resources/highway-501-truck-accidents-conway-myrtle-beach/">Highway 501 Truck Accidents: Conway to Myrtle Beach</a> | <a href="/resources/us-17-truck-accidents-grand-strand/">US-17 Truck Accidents on the Grand Strand</a></p>';

$takeaway = 'Highway 22 (Conway Bypass) is a deadly truck corridor connecting I-95 to the Grand Strand. In <strong>August 2025, a dump truck rear-ended stopped traffic near the Waccamaw River bridge</strong>, pushing a Jeep over the railing into the river and <strong>killing Flora Beltran-Gomez, 35, and Earl Burnette, 49</strong>. A <strong>multi-vehicle fatal crash in February 2026 killed 1 more person</strong>. Bridge sections create confined kill zones where vehicles cannot escape truck impacts. Horry County records over <strong>11,000 crashes per year</strong>. South Carolina gives victims <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.';

$post_id = wp_insert_post( array(
    'post_type'    => 'resource',
    'post_title'   => 'Highway 22 Truck Accidents: Conway Bypass',
    'post_name'    => 'highway-22-truck-accidents-conway-bypass',
    'post_status'  => 'publish',
    'post_content' => $content,
    'post_excerpt' => 'Data-driven guide to truck accidents on Highway 22 (Conway Bypass) in Horry County, SC. Covers the fatal Waccamaw River bridge dump truck crash, bridge section dangers, and your legal rights under South Carolina law.',
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
        'question' => 'What happened in the Highway 22 bridge crash in August 2025?',
        'answer'   => 'A dump truck rear-ended stopped traffic near the Waccamaw River bridge on Highway 22. The impact pushed a Jeep over the bridge railing and into the river below, killing Flora Beltran-Gomez, 35, and Earl Burnette, 49. A third person was hospitalized with serious injuries. The crash demonstrates the extreme danger of truck collisions on bridge sections where vehicles cannot escape the impact.',
    ),
    array(
        'question' => 'Why are bridge sections on Highway 22 so dangerous?',
        'answer'   => 'Bridge sections create confined corridors with concrete barriers on both sides. When a truck rear-ends traffic on a bridge, the struck vehicle has nowhere to go — it is pushed into the vehicle ahead, into the barrier, or over the railing. Bridge railings designed for passenger vehicles cannot contain the force of a truck pushing another vehicle against them.',
    ),
    array(
        'question' => 'What types of trucks cause crashes on Highway 22?',
        'answer'   => 'Highway 22 carries a dangerous mix of dump trucks serving Grand Strand construction, construction equipment haulers with oversized loads, tractor-trailers delivering goods to tourism businesses, and through-freight from I-95. Dump trucks are particularly dangerous because they are often overloaded, have poor rear visibility, and scatter debris that creates secondary hazards.',
    ),
    array(
        'question' => 'How long do I have to file a truck accident lawsuit in South Carolina?',
        'answer'   => 'South Carolina has a 3-year statute of limitations for personal injury claims (S.C. Code 15-3-530). For wrongful death claims, the statute also runs 3 years from the date of death. Contact an attorney within 24-48 hours to preserve critical evidence like ELD data, dash cam footage, and dump truck weight tickets.',
    ),
    array(
        'question' => 'Can I sue if a dump truck caused the crash on Highway 22?',
        'answer'   => 'Yes. Multiple parties may be liable: the dump truck driver for following too closely or distracted driving, the construction company that owns the truck for overloading or failing to maintain brakes, and potentially SCDOT for inadequate bridge railing design or insufficient warning signage for stopped traffic. South Carolina allows recovery if you are less than 51% at fault.',
    ),
) );
wp_set_object_terms( $post_id, array( $truck_term_id ), 'practice_category' );

WP_CLI::success( "CREATED: Highway 22 Truck Accidents: Conway Bypass (ID {$post_id})" );
