<?php
/**
 * Seeder: Bush River Road & I-26 Truck Accidents: Columbia's Malfunction Junction
 *
 * Run: wp eval-file wp-content/themes/roden-law/inc/seed-tc-col-bushriver.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

WP_CLI::log( 'Creating bush-river-road-i-26-truck-accidents-columbia...' );

$atty = get_page_by_path( 'ivy-s-montano', OBJECT, 'attorney' );
$author_id = $atty ? $atty->ID : 0;

$t = term_exists( 'truck-accidents', 'practice_category' );
if ( ! $t ) {
    $t = wp_insert_term( 'Truck Accidents', 'practice_category', array( 'slug' => 'truck-accidents' ) );
}
$truck_term_id = is_array( $t ) ? (int) $t['term_id'] : (int) $t;

$existing = get_page_by_path( 'bush-river-road-i-26-truck-accidents-columbia', OBJECT, 'resource' );
if ( $existing ) {
    WP_CLI::log( "SKIP: already exists (ID {$existing->ID})" );
    return;
}

$content = '<h2>Bush River Road &amp; I-26: Lexington County\'s Most Dangerous Truck Intersection</h2>';
$content .= '<p>The intersection of <strong>Bush River Road and I-26</strong> is the <strong>most dangerous intersection in Lexington County</strong>. This interchange sits at the western edge of Columbia\'s notorious <strong>"Malfunction Junction"</strong> — the I-20/I-26 interchange complex that is one of the most dangerous highway convergences in South Carolina. When heavy commercial truck traffic from I-26, I-20, and Bush River Road\'s commercial corridor converges at this location, the result is a sustained pattern of severe and fatal crashes.</p>';
$content .= '<p>Lexington County recorded <strong>8,162 total collisions and 46 fatal crashes in 2023</strong>. The Bush River Road/I-26 interchange and the adjacent Malfunction Junction account for a disproportionate share of those crashes.</p>';

$content .= '<h2>SCDOT Permanently Closes I-26 Off-Ramp to Bush River Road</h2>';
$content .= '<p>In <strong>November 2024, SCDOT permanently closed the westbound I-26 off-ramp to Bush River Road</strong> as part of the <strong>Carolina Crossroads improvement project</strong>. This closure was a direct acknowledgment that the interchange design was fundamentally unsafe. However, the closure itself creates new hazards: trucks that previously exited at Bush River Road must now use alternative exits and navigate unfamiliar surface roads to reach their destinations. Drivers unfamiliar with the new traffic patterns make unexpected lane changes and turns, and increased volume at adjacent interchanges creates secondary crash hotspots.</p>';

$content .= '<h2>Malfunction Junction: I-20/I-26 Interchange</h2>';
$content .= '<p>The I-20/I-26 interchange — known locally as <strong>"Malfunction Junction"</strong> — is the hub of Columbia\'s interstate system and one of the most dangerous highway interchanges in the Southeast. Crash data documents <strong>91 collisions at this interchange, including 2 fatal crashes and 22 people injured</strong>. Trucks navigating this interchange must execute complex merging and weaving maneuvers at highway speed while contending with passenger vehicles, construction zones, and confusing signage.</p>';
$content .= '<p>The adjacent <strong>I-20 at US-176 interchange</strong> recorded <strong>199 total collisions, 1 fatality, and 67 injuries</strong> — further evidence that the entire corridor surrounding Bush River Road and Malfunction Junction is systemically dangerous.</p>';

$content .= '<h2>Pedestrian Fatality Near Bush River Road</h2>';
$content .= '<p>The danger extends beyond vehicle-to-vehicle crashes. A <strong>pedestrian was killed behind a garbage truck on Wescott Road near Bush River Road</strong>, highlighting the risk to vulnerable road users in a corridor dominated by heavy vehicles. Workers, pedestrians, and cyclists sharing space with trucks on Bush River Road\'s commercial strip face extreme danger from vehicles with large blind spots, long stopping distances, and wide turning radii.</p>';

$content .= '<h2>Why This Corridor Is So Dangerous</h2>';

$content .= '<h3>Interstate Convergence</h3>';
$content .= '<p>Bush River Road sits at the junction of two major interstates carrying freight traffic from across the Southeast. I-26 connects Columbia to Charleston and the port system. I-20 connects Columbia to Atlanta and Florence. Trucks transitioning between these interstates must navigate through Malfunction Junction — a maze of ramps, merges, and lane changes that requires split-second decisions at 65+ mph. One missed exit or miscalculated merge puts an 80,000-pound truck across multiple lanes of traffic.</p>';

$content .= '<h3>Carolina Crossroads Construction</h3>';
$content .= '<p>The Carolina Crossroads improvement project is SCDOT\'s massive effort to rebuild the I-20/I-26/I-126 interchange. During construction, traffic patterns shift regularly, temporary lanes replace permanent ones, barriers narrow the roadway, and construction equipment operates adjacent to live traffic. Trucks navigating construction zones face reduced sight lines, uneven pavement, abrupt lane shifts, and speed differentials — all factors that increase crash risk. Construction zone truck crashes tend to be especially severe because concrete barriers eliminate escape routes.</p>';

$content .= '<h3>Bush River Road Commercial Traffic</h3>';
$content .= '<p>Bush River Road itself is a commercial corridor with auto dealerships, retail centers, restaurants, and industrial businesses. Delivery trucks, fuel tankers, and tractor-trailers service these businesses while competing for space with I-26 interchange traffic. Trucks making left turns into business driveways block travel lanes and create sight-line obstructions. The mix of high-speed interchange traffic and low-speed commercial turning movements is inherently dangerous.</p>';

$content .= '<h2>Common Truck Crash Types at Bush River Road &amp; I-26</h2>';

$content .= '<h3>Merge and Weave Crashes</h3>';
$content .= '<p>The most characteristic crash type at this location. Trucks merging from I-26 onto I-20 — or vice versa — must cross multiple lanes of traffic in a short distance. Failed lane changes and misjudged gaps result in sideswipe collisions and forced-off-road crashes. When a truck forces a passenger vehicle off the road at highway speed, the consequences are catastrophic.</p>';

$content .= '<h3>Rear-End Collisions</h3>';
$content .= '<p>Traffic backing up from the Bush River Road interchange extends onto I-26 mainline lanes during peak hours. Trucks approaching at highway speed encounter stopped or slow-moving traffic with insufficient warning. The speed differential between a truck traveling at 65 mph and stopped traffic produces massive collision forces.</p>';

$content .= '<h3>Wrong-Exit and Confusion Crashes</h3>';
$content .= '<p>The ramp closure and ongoing construction create confusion for truck drivers, especially those unfamiliar with current traffic patterns. Trucks that miss their exit attempt last-second lane changes or even reverse on ramps. GPS systems may not reflect current closures, directing trucks onto closed ramps or into construction zones.</p>';

$content .= '<h2>Liable Parties</h2>';
$content .= '<table><thead><tr><th>Potentially Liable Party</th><th>Basis for Liability</th></tr></thead><tbody>';
$content .= '<tr><td>Truck driver</td><td>Unsafe lane changes, failure to adjust for construction zones, speeding, distraction, fatigue</td></tr>';
$content .= '<tr><td>Trucking company</td><td>Failure to route trucks around known dangerous interchanges, HOS pressure, inadequate driver training</td></tr>';
$content .= '<tr><td>Construction contractor</td><td>Defective work zone design, inadequate signage, insufficient lane markings, debris in travel lanes</td></tr>';
$content .= '<tr><td>SCDOT</td><td>Interchange design defects, inadequate construction zone management, failure to provide adequate detour signage (subject to <a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">SC Tort Claims Act, S.C. Code &sect; 15-78-80</a>)</td></tr>';
$content .= '<tr><td>Vehicle/cargo company</td><td>Brake defects, overloaded cargo affecting stability during emergency maneuvers in merge zones</td></tr>';
$content .= '</tbody></table>';

$content .= '<h2>What to Do After a Truck Accident at Bush River Road &amp; I-26</h2>';
$content .= '<ol>';
$content .= '<li><strong>Call 911 immediately</strong> — This area may involve Lexington County Sheriff, Columbia Police, or South Carolina Highway Patrol depending on whether the crash occurs on the interstate, ramps, or surface road.</li>';
$content .= '<li><strong>Move to safety if possible</strong> — Interstate and interchange crashes create extreme secondary collision risk from approaching traffic.</li>';
$content .= '<li><strong>Document the truck:</strong> Company name, USDOT number, trailer number, cargo type, and which ramp or lane the truck was using.</li>';
$content .= '<li><strong>Note construction zone details:</strong> Which lanes were closed, what signage was posted, where barriers were placed, and whether construction workers were present.</li>';
$content .= '<li><strong>Get medical treatment:</strong> Lexington Medical Center and Prisma Health Richland are both accessible from this corridor.</li>';
$content .= '<li><strong>Contact a truck accident attorney</strong> — Construction zone evidence, ELD data, and the truck\'s event data recorder must be preserved immediately.</li>';
$content .= '</ol>';

$content .= '<h2>South Carolina Law</h2>';
$content .= '<ul>';
$content .= '<li><strong>Statute of limitations:</strong> 3 years from the date of injury (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code &sect; 15-3-530</a>)</li>';
$content .= '<li><strong>Comparative fault:</strong> South Carolina allows recovery if you are less than 51% at fault. Your compensation is reduced by your percentage of fault.</li>';
$content .= '<li><strong>Government liability:</strong> Claims against SCDOT for interchange design or construction zone defects are subject to the SC Tort Claims Act with notice requirements and damage caps</li>';
$content .= '<li><strong>Punitive damages:</strong> Available when trucking companies or drivers demonstrated willful disregard for safety</li>';
$content .= '</ul>';

$content .= '<h2>Free Consultation — Roden Law Columbia</h2>';
$content .= '<p>Roden Law\'s <a href="/locations/south-carolina/columbia/">Columbia office</a> handles truck accident cases at Bush River Road, Malfunction Junction, and throughout the Midlands. We understand the Carolina Crossroads construction impacts, preserve critical evidence, and fight for full compensation. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free consultation — no fees unless we win.</p>';
$content .= '<p>Related resources: <a href="/resources/columbia-i-26-i-20-i-77-interchange-truck-accidents/">Columbia Interstate Interchange Truck Accidents</a> | <a href="/resources/lexington-county-truck-accidents-distribution-corridor/">Lexington County Truck Accidents</a></p>';

$takeaway = 'I-26 at Bush River Road is <strong>Lexington County\'s most dangerous intersection</strong>, and SCDOT <strong>permanently closed the westbound I-26 off-ramp</strong> in November 2024 as part of the Carolina Crossroads project. The adjacent I-20/I-26 <strong>"Malfunction Junction"</strong> recorded <strong>91 collisions including 2 fatal crashes and 22 injuries</strong>. I-20 at US-176 saw <strong>199 collisions, 1 fatality, and 67 injuries</strong>. A pedestrian was killed behind a garbage truck on Wescott Road near Bush River Rd. Lexington County recorded <strong>8,162 collisions and 46 fatal crashes</strong> in 2023. South Carolina gives victims <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.';

$post_id = wp_insert_post( array(
    'post_type'    => 'resource',
    'post_title'   => 'Bush River Road &amp; I-26 Truck Accidents: Columbia\'s Malfunction Junction',
    'post_name'    => 'bush-river-road-i-26-truck-accidents-columbia',
    'post_status'  => 'publish',
    'post_content' => $content,
    'post_excerpt' => 'Data-driven guide to truck accidents at Bush River Road and I-26 in Columbia, SC. Covers Malfunction Junction crash data, the SCDOT ramp closure, Carolina Crossroads construction hazards, and your legal rights under South Carolina law.',
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
        'question' => 'Why did SCDOT close the I-26 off-ramp to Bush River Road?',
        'answer'   => 'SCDOT permanently closed the westbound I-26 off-ramp to Bush River Road in November 2024 as part of the Carolina Crossroads improvement project. The closure was a direct acknowledgment that the interchange design was fundamentally unsafe. However, the closure creates new hazards as trucks must use alternative exits and navigate unfamiliar surface roads.',
    ),
    array(
        'question' => 'What is Malfunction Junction and why is it dangerous?',
        'answer'   => 'Malfunction Junction is the local name for the I-20/I-26 interchange in Columbia — where two major interstates converge near Bush River Road. Crash data shows 91 collisions at this interchange, including 2 fatal crashes and 22 people injured. Trucks must execute complex merging and weaving maneuvers at highway speed through confusing ramp configurations.',
    ),
    array(
        'question' => 'How does the Carolina Crossroads construction affect truck accident risk?',
        'answer'   => 'The Carolina Crossroads project involves ongoing construction that shifts traffic patterns, narrows lanes with barriers, creates uneven pavement, and places construction equipment adjacent to live traffic. Truck drivers unfamiliar with changing configurations make dangerous last-second maneuvers. Construction zone crashes tend to be more severe because concrete barriers eliminate escape routes.',
    ),
    array(
        'question' => 'How long do I have to file a truck accident lawsuit in South Carolina?',
        'answer'   => 'South Carolina has a 3-year statute of limitations for personal injury claims (S.C. Code 15-3-530). If your crash involved a government entity like SCDOT — for example, due to construction zone defects or interchange design — the SC Tort Claims Act imposes additional notice requirements. Contact an attorney immediately to preserve evidence and meet all deadlines.',
    ),
    array(
        'question' => 'Who is liable for a truck crash in the Malfunction Junction construction zone?',
        'answer'   => 'Multiple parties may share liability: the truck driver for unsafe lane changes or speeding, the trucking company for routing trucks through a known dangerous interchange, the construction contractor for defective work zone design or inadequate signage, SCDOT for interchange design defects or construction management failures, and cargo companies for overloading that affects stability during emergency maneuvers.',
    ),
) );
wp_set_object_terms( $post_id, array( $truck_term_id ), 'practice_category' );

WP_CLI::success( "CREATED: Bush River Road & I-26 Truck Accidents: Columbia's Malfunction Junction (ID {$post_id})" );
