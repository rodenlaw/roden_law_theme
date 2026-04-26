<?php
/**
 * Seeder: I-95 Widening Construction Zone: Georgia-South Carolina Border
 *
 * Run: wp eval-file wp-content/themes/roden-law/inc/seed-tc-i95-widening-gasc.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

WP_CLI::log( 'Creating i-95-widening-construction-zone-ga-sc...' );

$eric = get_page_by_path( 'eric-roden', OBJECT, 'attorney' );
$author_id = $eric ? $eric->ID : 0;

$t = term_exists( 'truck-accidents', 'practice_category' );
if ( ! $t ) {
    $t = wp_insert_term( 'Truck Accidents', 'practice_category', array( 'slug' => 'truck-accidents' ) );
}
$truck_term_id = is_array( $t ) ? (int) $t['term_id'] : (int) $t;

$existing = get_page_by_path( 'i-95-widening-construction-zone-ga-sc', OBJECT, 'resource' );
if ( $existing ) {
    WP_CLI::log( "SKIP: already exists (ID {$existing->ID})" );
    return;
}

$content = '';
$content .= '<h2>Nearly $1 Billion in I-95 Construction Spanning Two States</h2>';
$content .= '<p>Two massive highway projects are converging on the same corridor: GDOT is widening I-95 in <strong>Glynn County, Georgia</strong>, and SCDOT is widening I-95 in <strong>Jasper County, South Carolina</strong>. Together, these projects represent <strong>nearly $1 billion in construction on a single interstate corridor spanning the Georgia-South Carolina border</strong>.</p>';
$content .= '<p>The <strong>GDOT project</strong> covers <strong>22 miles in Glynn County</strong>, widening I-95 from six to eight lanes at a cost of <strong>$101 million</strong>. Construction is expected to begin in <strong>2026</strong> with an approximately 2-year build timeline. The <strong>SCDOT project</strong> in Jasper County is far larger: an <strong>$825 million contract</strong> &mdash; <strong>SCDOT\'s largest ever</strong> &mdash; awarded to Ferrovial. It includes widening I-95 and constructing a <strong>new Savannah River bridge</strong>. SCDOT held its groundbreaking on <strong>August 14, 2025</strong>, with a target completion of <strong>2030</strong>.</p>';
$content .= '<p>For the thousands of trucks that travel I-95 between Savannah and the South Carolina border daily, these overlapping construction zones will create years of narrowed lanes, lane shifts, reduced speeds, and active construction on both sides of the state line.</p>';

$content .= '<h2>Recent Fatal and Serious Crashes on the I-95 Corridor</h2>';

$content .= '<h3>February 2026: Fatal U-Haul Overturn at Exit 36 in Glynn County</h3>';
$content .= '<p>In <strong>February 2026</strong>, a <strong>fully loaded U-Haul overturned while exiting I-95 onto US 341 at Exit 36</strong> in Glynn County. A <strong>South Carolina woman was killed</strong> in the crash. Exit ramps are particularly dangerous during construction because ramp geometries, merge angles, and speed transitions may be altered by the widening work. Trucks and large rental vehicles like fully loaded U-Hauls have a higher center of gravity and are more susceptible to rollover when navigating construction-modified exit curves at excessive speed.</p>';

$content .= '<h3>September 2025: Major I-95 Northbound Backups Near Brunswick</h3>';
$content .= '<p>In <strong>September 2025</strong>, a crash on <strong>I-95 northbound near Brunswick</strong> caused major traffic backups throughout the Glynn County stretch of the interstate. Even before the widening construction begins, this section of I-95 is congested and crash-prone. GDOT data shows that <strong>42% of crashes on the Glynn County stretch of I-95 are rear-end collisions</strong> &mdash; the crash type most exacerbated by construction zone congestion, lane closures, and sudden speed reductions.</p>';

$content .= '<h3>The Savannah River Bridge: A Critical Chokepoint</h3>';
$content .= '<p>The current I-95 bridge over the Savannah River is the single connection point between the Georgia and South Carolina segments of the corridor. SCDOT\'s Jasper County project includes construction of a <strong>new Savannah River bridge</strong>, which will require years of work adjacent to the existing bridge. During construction, traffic will continue to flow on the existing bridge while construction crews work nearby &mdash; creating a prolonged chokepoint where any crash or breakdown can shut down the only I-95 river crossing for miles.</p>';

$content .= '<h2>Why This Corridor Is Uniquely Dangerous</h2>';

$content .= '<h3>Two States, Two Construction Projects, One Corridor</h3>';
$content .= '<p>A truck driver traveling I-95 between Jacksonville and Charleston will pass through <strong>two separate construction zones managed by two different state DOTs</strong>, each with their own contractors, signage standards, lane configurations, and speed limits. The transition from one state\'s construction zone to another\'s &mdash; with different lane widths, barrier placements, and speed reductions &mdash; creates confusion and increases the risk of driver error, particularly for truckers who may not realize they have entered a second construction zone with different rules.</p>';

$content .= '<h3>42% Rear-End Collision Rate</h3>';
$content .= '<p>GDOT data shows that <strong>42% of crashes on the Glynn County stretch of I-95 are rear-end collisions</strong>. Rear-end crashes are the signature hazard of construction zones: reduced speeds, sudden stops, lane closures, and compressed traffic create conditions where vehicles &mdash; especially heavy trucks with longer stopping distances &mdash; run into the vehicle ahead. An 80,000-pound tractor-trailer traveling at 55 mph needs approximately <strong>525 feet to stop</strong>. In a construction zone with concrete barriers and no shoulders, there is no escape path when traffic ahead stops suddenly.</p>';

$content .= '<h3>Years of Overlapping Construction</h3>';
$content .= '<p>The GDOT Glynn County project is expected to begin in 2026 with a 2-year build. The SCDOT Jasper County project broke ground in August 2025 with a 2030 target completion. This means that for several years, <strong>both sides of the state border will have active construction simultaneously</strong>. Truck drivers will navigate continuous construction from Glynn County, Georgia, through the Savannah River crossing, and into Jasper County, South Carolina &mdash; with no break from construction zone conditions.</p>';

$content .= '<h2>Which State\'s Law Applies?</h2>';
$content .= '<p>Because this construction corridor spans the Georgia-South Carolina border, <strong>which state\'s law applies depends on which side of the Savannah River the crash occurred</strong>. The two states have different statutes of limitations, different comparative fault thresholds, and different rules for government liability claims.</p>';
$content .= '<table><thead><tr><th>Legal Issue</th><th>Georgia</th><th>South Carolina</th></tr></thead><tbody>';
$content .= '<tr><td>Statute of limitations</td><td><strong>2 years</strong> (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. &sect; 9-3-33</a>)</td><td><strong>3 years</strong> (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code &sect; 15-3-530</a>)</td></tr>';
$content .= '<tr><td>Comparative fault threshold</td><td>Less than <strong>50%</strong> at fault to recover (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. &sect; 51-12-33</a>)</td><td>Less than <strong>51%</strong> at fault to recover</td></tr>';
$content .= '<tr><td>Government liability</td><td>Georgia sovereign immunity rules; ante-litem notice requirements</td><td><a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">SC Tort Claims Act (S.C. Code &sect; 15-78-80)</a>; damage caps and procedural requirements</td></tr>';
$content .= '</tbody></table>';
$content .= '<p>If the crash occurs on the Savannah River bridge itself, determining which state has jurisdiction may require analysis of the exact location on the bridge. An attorney licensed in both Georgia and South Carolina is essential for crashes in this border corridor.</p>';

$content .= '<h2>Liable Parties in I-95 Widening Zone Crashes</h2>';
$content .= '<table><thead><tr><th>Potentially Liable Party</th><th>Basis for Liability</th></tr></thead><tbody>';
$content .= '<tr><td>Truck driver</td><td>Speeding in work zone, fatigued driving, failure to adjust for construction conditions and reduced speed limits</td></tr>';
$content .= '<tr><td>Trucking company</td><td>HOS violations, pressure driving, failure to plan routes accounting for dual construction zones</td></tr>';
$content .= '<tr><td>GDOT or SCDOT</td><td>Inadequate signage, improper lane transition design, failure to coordinate cross-border construction zone warnings (subject to each state\'s sovereign immunity rules)</td></tr>';
$content .= '<tr><td>Construction contractor (Ferrovial or GDOT contractor)</td><td>Improperly placed barriers, equipment in travel lanes, inadequate lighting, failure to follow MUTCD standards</td></tr>';
$content .= '<tr><td>Rental truck company</td><td>Failure to warn renters about construction zone hazards, vehicle maintenance issues affecting handling on construction-modified ramps</td></tr>';
$content .= '</tbody></table>';

$content .= '<h2>What to Do After a Truck Crash on I-95 Near the GA/SC Border</h2>';
$content .= '<ol>';
$content .= '<li><strong>Call 911 immediately</strong> &mdash; Georgia State Patrol responds to crashes on the Georgia side; South Carolina Highway Patrol responds on the South Carolina side. Note which state you are in when you call.</li>';
$content .= '<li><strong>Document the work zone:</strong> Photograph construction signage, speed limit signs, barrier placement, and any construction equipment. Note which state\'s DOT signage is posted &mdash; this helps determine jurisdiction.</li>';
$content .= '<li><strong>Record the truck:</strong> Company name, USDOT number, trailer number, cargo type, and license plate state.</li>';
$content .= '<li><strong>Get medical treatment:</strong> Southeast Georgia Health System in Brunswick is the nearest major hospital on the Georgia side. Beaufort Memorial Hospital serves the South Carolina side. Get evaluated even if you feel fine.</li>';
$content .= '<li><strong>Contact a truck accident attorney licensed in both states</strong> &mdash; Roden Law attorneys are licensed in both Georgia and South Carolina. Call <a href="tel:+19123035850">(912) 303-5850</a> within 24&ndash;48 hours to preserve ELD data, dash cam footage, and construction zone traffic control plans.</li>';
$content .= '</ol>';

$content .= '<h2>Free Consultation &mdash; Roden Law</h2>';
$content .= '<p>Roden Law\'s <a href="/locations/georgia/savannah/">Savannah</a> and <a href="/locations/georgia/darien/">Darien</a> offices serve clients injured on the Georgia side of I-95, and our South Carolina offices handle crashes on the SC side. Our attorneys are licensed in both Georgia and South Carolina, which is essential for crashes in this cross-border corridor. Call <a href="tel:+19123035850">(912) 303-5850</a> for a free consultation &mdash; no fees unless we win.</p>';
$content .= '<p>Related resources: <a href="/resources/i-95-truck-accidents-savannah-brunswick/">I-95 Truck Accidents: Savannah to Brunswick</a></p>';

$takeaway = '<strong>Two massive I-95 widening projects</strong> totaling nearly <strong>$1 billion</strong> are converging on the Georgia-South Carolina border: GDOT\'s <strong>$101 million</strong> Glynn County widening (22 miles, 6 to 8 lanes, construction starting 2026) and SCDOT\'s <strong>$825 million</strong> Jasper County project (<strong>SCDOT\'s largest ever contract</strong>, awarded to Ferrovial, including a new Savannah River bridge, groundbreaking August 2025). <strong>42% of crashes</strong> on the Glynn County stretch are rear-end collisions. In <strong>February 2026</strong>, a fully loaded U-Haul overturned at Exit 36 &mdash; a <strong>South Carolina woman was killed</strong>. Which state\'s law applies depends on which side of the Savannah River the crash occurred: Georgia allows <strong>2 years to file</strong> (<strong>O.C.G.A. &sect; 9-3-33</strong>), South Carolina allows <strong>3 years</strong> (<strong>S.C. Code &sect; 15-3-530</strong>). Call <strong>(912) 303-5850</strong>.';

$post_id = wp_insert_post( array(
    'post_type'    => 'resource',
    'post_title'   => 'I-95 Widening Construction Zone: Georgia-South Carolina Border',
    'post_name'    => 'i-95-widening-construction-zone-ga-sc',
    'post_status'  => 'publish',
    'post_content' => $content,
    'post_excerpt' => 'Nearly $1 billion in I-95 widening construction spans the Georgia-South Carolina border, with GDOT and SCDOT projects creating years of overlapping construction zones. Learn about crash risks, which state\'s law applies, and your legal rights.',
), true );

if ( is_wp_error( $post_id ) ) {
    WP_CLI::warning( 'FAILED: ' . $post_id->get_error_message() );
    return;
}

update_post_meta( $post_id, '_roden_author_attorney', $author_id );
update_post_meta( $post_id, '_roden_jurisdiction', 'ga' );
update_post_meta( $post_id, '_roden_key_takeaways', wp_kses_post( $takeaway ) );
update_post_meta( $post_id, '_roden_faqs', array(
    array(
        'question' => 'What I-95 widening projects are happening near the Georgia-South Carolina border?',
        'answer'   => 'Two projects are converging on the same corridor. GDOT is widening I-95 in Glynn County, Georgia, from six to eight lanes across 22 miles at a cost of $101 million, with construction expected to begin in 2026. SCDOT is widening I-95 in Jasper County, South Carolina, under an $825 million contract (SCDOT\'s largest ever) awarded to Ferrovial, which includes a new Savannah River bridge. SCDOT broke ground on August 14, 2025, with a target completion of 2030.',
    ),
    array(
        'question' => 'Which state\'s law applies if I am injured in a truck crash on I-95 near the border?',
        'answer'   => 'The state where the crash physically occurred determines which law applies. Georgia gives you 2 years to file a lawsuit (O.C.G.A. Section 9-3-33) and allows recovery if less than 50% at fault. South Carolina gives 3 years (S.C. Code Section 15-3-530) and allows recovery if less than 51% at fault. For crashes on the Savannah River bridge, the exact location on the bridge may determine jurisdiction. An attorney licensed in both states is essential.',
    ),
    array(
        'question' => 'Why are rear-end collisions so common on this stretch of I-95?',
        'answer'   => 'GDOT data shows that 42% of crashes on the Glynn County stretch of I-95 are rear-end collisions. Construction zones intensify this pattern through reduced speeds, sudden stops, lane closures, and compressed traffic. An 80,000-pound truck needs approximately 525 feet to stop from 55 mph, and construction barriers eliminate shoulders and escape paths. When traffic stops suddenly in a construction zone, trucks cannot stop in time.',
    ),
    array(
        'question' => 'What happened in the February 2026 fatal crash at Exit 36?',
        'answer'   => 'In February 2026, a fully loaded U-Haul overturned while exiting I-95 onto US 341 at Exit 36 in Glynn County. A South Carolina woman was killed. Exit ramps are particularly dangerous during construction because ramp geometries and speed transitions may be altered by the widening work. Large vehicles like fully loaded U-Hauls have a higher center of gravity and are more susceptible to rollover on construction-modified exit curves.',
    ),
    array(
        'question' => 'Can GDOT or SCDOT be held liable for construction zone crashes on I-95?',
        'answer'   => 'Both GDOT and SCDOT can potentially be held liable for inadequate signage, improper lane transition design, and failure to coordinate cross-border construction zone warnings. In Georgia, sovereign immunity rules and ante-litem notice requirements apply. In South Carolina, the SC Tort Claims Act (S.C. Code Section 15-78-80) imposes damage caps and procedural requirements. Each state has different rules, so the location of the crash determines which government liability framework applies.',
    ),
) );
wp_set_object_terms( $post_id, array( $truck_term_id ), 'practice_category' );

WP_CLI::success( "CREATED: I-95 Widening Construction Zone: Georgia-South Carolina Border (ID {$post_id})" );
