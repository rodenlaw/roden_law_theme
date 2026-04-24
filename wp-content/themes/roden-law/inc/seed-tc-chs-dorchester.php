<?php
/**
 * Seeder: Dorchester Road Truck Accidents in North Charleston
 *
 * Run: wp eval-file wp-content/themes/roden-law/inc/seed-tc-chs-dorchester.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

WP_CLI::log( 'Creating dorchester-road-truck-accidents-north-charleston...' );

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $graeham ? $graeham->ID : 0;

$t = term_exists( 'truck-accidents', 'practice_category' );
if ( ! $t ) {
    $t = wp_insert_term( 'Truck Accidents', 'practice_category', array( 'slug' => 'truck-accidents' ) );
}
$truck_term_id = is_array( $t ) ? (int) $t['term_id'] : (int) $t;

$existing = get_page_by_path( 'dorchester-road-truck-accidents-north-charleston', OBJECT, 'resource' );
if ( $existing ) {
    WP_CLI::log( "SKIP: already exists (ID {$existing->ID})" );
    return;
}

$content = '<h2>Dorchester Road: One of Charleston County\'s Deadliest Corridors for Truck Accidents</h2>';
$content .= '<p><strong>Dorchester Road</strong> is one of the <strong>four deadliest roads in Charleston County</strong>, alongside Rivers Avenue, Ashley Phosphate Road, and Remount Road. Stretching through the heart of North Charleston, Dorchester Road carries a volatile mix of heavy commuter traffic from Ladson and Summerville, commercial trucks serving industrial facilities, and local traffic navigating residential and retail zones with limited infrastructure.</p>';
$content .= '<p>The corridor\'s combination of aging road surfaces, limited shoulders, no dedicated turn lanes at many intersections, and a blend of residential, commercial, and industrial land uses makes it one of the most hazardous stretches in the region for truck-involved crashes. Recent fatal and catastrophic incidents underscore just how dangerous this road has become.</p>';

$content .= '<h2>Recent Major Truck Crashes on Dorchester Road</h2>';

$content .= '<h3>Motorcycle vs. Heavy-Duty Truck — Dorchester &amp; Forest Hills Drive (March 2026)</h3>';
$content .= '<p>In March 2026, a motorcyclist was killed in a collision with a heavy-duty truck at the intersection of <strong>Dorchester Road and Forest Hills Drive</strong>. The crash highlights the extreme vulnerability of motorcyclists when sharing road space with large commercial vehicles at intersections that lack dedicated turn lanes and adequate sight lines. This intersection sits in a zone where residential neighborhoods meet commercial traffic, creating constant left-turn conflicts.</p>';

$content .= '<h3>U-Haul Box Truck Pursuit — Dorchester &amp; Meeting Street (April 2025)</h3>';
$content .= '<p>In April 2025, a pursuit involving a stolen U-Haul box truck began at the intersection of <strong>Dorchester Road and Meeting Street</strong>. The truck fled through North Charleston streets before striking and killing a motorcyclist and injuring seven other people. The incident demonstrates how even non-commercial trucks of significant size can cause catastrophic harm — and how Dorchester Road\'s high-traffic intersections serve as flashpoints for collisions involving large vehicles.</p>';

$content .= '<h3>Concrete Truck Off I-26 Overpass Near Dorchester Road</h3>';
$content .= '<p>A concrete mixer truck drove off the I-26 overpass in the vicinity of Dorchester Road, falling from the elevated highway to the surface street below. Concrete trucks are among the heaviest vehicles on the road — often exceeding 60,000 pounds when loaded. This crash illustrates the danger posed by the I-26/Dorchester Road interchange, where elevated highway traffic and surface street traffic converge in close proximity.</p>';

$content .= '<h2>Why Dorchester Road Is So Dangerous for Truck Traffic</h2>';

$content .= '<h3>Mix of Land Uses</h3>';
$content .= '<p>Dorchester Road passes through residential neighborhoods, strip malls, gas stations, auto repair shops, and industrial facilities — often within the same mile. Trucks serving commercial and industrial destinations must navigate driveways and parking lots while sharing the road with school buses, pedestrians, and neighborhood traffic. The constant turning movements across traffic create a high frequency of conflict points.</p>';

$content .= '<h3>Limited Road Infrastructure</h3>';
$content .= '<p>Many sections of Dorchester Road lack basic safety features: <strong>no dedicated left-turn lanes</strong>, <strong>narrow or nonexistent shoulders</strong>, and <strong>aging pavement</strong> with poor drainage. When a truck needs to make a left turn at an intersection without a turn lane, it stops in the travel lane — forcing following traffic to brake suddenly or swerve. The absence of shoulders means disabled vehicles and minor crashes block the travel lane, creating secondary crash risks.</p>';

$content .= '<h3>Heavy Commuter Traffic from Ladson and Summerville</h3>';
$content .= '<p>Dorchester Road is a primary commuter route connecting the rapidly growing communities of <strong>Ladson and Summerville</strong> to North Charleston employment centers. During morning and evening rush hours, bumper-to-bumper passenger vehicle traffic shares the road with commercial trucks making deliveries to the corridor\'s businesses. The speed differential between trucks accelerating from stops and impatient commuters creates constant rear-end and sideswipe crash risks.</p>';

$content .= '<h3>I-26 Interchange Proximity</h3>';
$content .= '<p>Dorchester Road intersects with I-26, creating a convergence of highway-speed truck traffic exiting onto a surface street not designed for that volume. Trucks exiting I-26 must rapidly decelerate from highway speeds while navigating tight ramp geometry. The concrete truck overpass crash is a stark example of what happens when truck drivers lose control in this transition zone.</p>';

$content .= '<h2>Common Truck Crash Patterns on Dorchester Road</h2>';
$content .= '<ul>';
$content .= '<li><strong>Left-turn collisions:</strong> Trucks turning left across oncoming traffic at intersections without dedicated turn signals or protected phases</li>';
$content .= '<li><strong>Rear-end crashes:</strong> Trucks unable to stop in time when traffic backs up at intersections or from the I-26 interchange</li>';
$content .= '<li><strong>Sideswipe crashes:</strong> Trucks drifting into adjacent lanes on narrow road sections, or passenger vehicles attempting to pass stopped trucks</li>';
$content .= '<li><strong>Pedestrian strikes:</strong> Trucks turning at intersections near commercial areas where pedestrians cross without signalized crosswalks</li>';
$content .= '<li><strong>Driveway access crashes:</strong> Trucks entering or exiting commercial driveways across travel lanes with poor sight lines</li>';
$content .= '</ul>';

$content .= '<h2>Liable Parties in Dorchester Road Truck Accidents</h2>';
$content .= '<table><thead><tr><th>Potentially Liable Party</th><th>Basis for Liability</th></tr></thead><tbody>';
$content .= '<tr><td>Truck driver</td><td>Failure to yield on left turn, speeding, distracted driving, running red lights</td></tr>';
$content .= '<tr><td>Trucking company</td><td>Negligent hiring, inadequate training for urban corridor driving, hours-of-service pressure</td></tr>';
$content .= '<tr><td>Vehicle manufacturer</td><td>Defective brakes, inadequate mirrors or blind-spot technology</td></tr>';
$content .= '<tr><td>Government entity (SCDOT / City of North Charleston)</td><td>Failure to install turn lanes, inadequate signal timing, poor road maintenance (subject to <a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">SC Tort Claims Act</a>)</td></tr>';
$content .= '<tr><td>Property owners</td><td>Poorly designed commercial driveways creating sight-line obstructions</td></tr>';
$content .= '</tbody></table>';

$content .= '<h2>What to Do After a Truck Accident on Dorchester Road</h2>';
$content .= '<ol>';
$content .= '<li><strong>Call 911 immediately</strong> — Dorchester Road crashes fall under North Charleston Police or Charleston County Sheriff jurisdiction depending on the exact location.</li>';
$content .= '<li><strong>Stay in your vehicle if possible</strong> — Dorchester Road has limited shoulders. Exiting your vehicle into a travel lane creates extreme danger from passing traffic.</li>';
$content .= '<li><strong>Document the truck:</strong> Company name, USDOT number, trailer number, cargo type, and direction of travel. Note whether the truck was turning, entering a driveway, or traveling through.</li>';
$content .= '<li><strong>Photograph road conditions:</strong> Missing turn lane markings, pavement defects, sight-line obstructions, and signal timing can all be relevant.</li>';
$content .= '<li><strong>Get medical treatment:</strong> Trident Medical Center and MUSC Health are both accessible from Dorchester Road. Seek evaluation even for seemingly minor injuries.</li>';
$content .= '<li><strong>Contact a truck accident attorney</strong> — Evidence from the truck\'s ELD, event data recorder, and any nearby surveillance cameras must be preserved immediately.</li>';
$content .= '</ol>';

$content .= '<h2>South Carolina Law</h2>';
$content .= '<ul>';
$content .= '<li><strong>Statute of limitations:</strong> 3 years from the date of injury (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code &sect; 15-3-530</a>)</li>';
$content .= '<li><strong>Comparative fault:</strong> South Carolina allows recovery if you are less than 51% at fault. Your compensation is reduced by your percentage of fault.</li>';
$content .= '<li><strong>Government liability:</strong> If road design defects or failure to install turn lanes contributed to the crash, claims against SCDOT or North Charleston are subject to the SC Tort Claims Act with notice requirements and damage caps.</li>';
$content .= '<li><strong>Punitive damages:</strong> Available when trucking companies demonstrate willful disregard for safety, such as falsifying driver logs or ignoring known vehicle defects.</li>';
$content .= '</ul>';

$content .= '<h2>Free Consultation — Roden Law Charleston</h2>';
$content .= '<p>Roden Law\'s <a href="/locations/south-carolina/charleston/">Charleston office</a> handles truck accident cases on Dorchester Road and throughout North Charleston. We understand the corridor\'s crash history, work with accident reconstruction experts, and pursue every liable party. Call <a href="tel:+18437908999">(843) 790-8999</a> for a free consultation — no fees unless we win.</p>';
$content .= '<p>Related resources: <a href="/resources/ashley-phosphate-i-26-truck-accidents/">Ashley Phosphate &amp; I-26 Truck Accidents</a> | <a href="/resources/rivers-avenue-truck-accidents-north-charleston/">Rivers Avenue Truck Accidents</a> | <a href="/resources/summerville-truck-accidents-i-26-corridor/">Summerville Truck Accidents on I-26</a></p>';

$takeaway = 'Dorchester Road is one of the <strong>four deadliest roads in Charleston County</strong>, carrying a dangerous mix of heavy commuter traffic from Ladson and Summerville, commercial trucks, and residential neighborhood traffic. Recent crashes include a <strong>fatal motorcycle-vs-truck collision at Forest Hills Drive</strong> (March 2026), a <strong>U-Haul pursuit from Dorchester &amp; Meeting Street</strong> that killed a motorcyclist and injured 7 (April 2025), and a <strong>concrete truck that drove off the I-26 overpass</strong>. Limited shoulders, no dedicated turn lanes, and aging road surfaces compound the danger. South Carolina gives victims <strong>3 years to file</strong> (<strong>S.C. Code &sect; 15-3-530</strong>) with recovery if less than <strong>51% at fault</strong>.';

$post_id = wp_insert_post( array(
    'post_type'    => 'resource',
    'post_title'   => 'Dorchester Road Truck Accidents in North Charleston',
    'post_name'    => 'dorchester-road-truck-accidents-north-charleston',
    'post_status'  => 'publish',
    'post_content' => $content,
    'post_excerpt' => 'Dorchester Road is one of the four deadliest roads in Charleston County. Learn about recent fatal truck crashes, why the corridor is so dangerous, and your legal options after a truck accident.',
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
        'question' => 'Why is Dorchester Road so dangerous for truck accidents?',
        'answer'   => 'Dorchester Road is one of the four deadliest roads in Charleston County due to its mix of residential, commercial, and industrial zones combined with limited road infrastructure. Many intersections lack dedicated turn lanes, shoulders are narrow or nonexistent, and heavy commuter traffic from Ladson and Summerville shares the road with commercial trucks making deliveries throughout the corridor.',
    ),
    array(
        'question' => 'What recent truck crashes have occurred on Dorchester Road?',
        'answer'   => 'Recent major incidents include a fatal motorcycle-versus-heavy-duty-truck collision at Dorchester Road and Forest Hills Drive in March 2026, a U-Haul box truck pursuit that began at Dorchester and Meeting Street in April 2025 (killing a motorcyclist and injuring seven), and a concrete mixer truck that drove off the I-26 overpass near Dorchester Road.',
    ),
    array(
        'question' => 'Who can be held liable for a truck accident on Dorchester Road?',
        'answer'   => 'Potentially liable parties include the truck driver (for speeding, distracted driving, or failure to yield), the trucking company (for negligent hiring or hours-of-service pressure), the vehicle manufacturer (for brake or visibility defects), government entities like SCDOT or North Charleston (for failure to install turn lanes or maintain roads), and commercial property owners (for poorly designed driveways creating sight-line obstructions).',
    ),
    array(
        'question' => 'How long do I have to file a truck accident claim on Dorchester Road?',
        'answer'   => 'South Carolina law provides 3 years from the date of injury to file a personal injury claim (S.C. Code Section 15-3-530). However, if a government entity such as SCDOT or the City of North Charleston is involved due to road design defects, the SC Tort Claims Act imposes shorter notice deadlines. Contact an attorney as soon as possible to preserve your rights.',
    ),
    array(
        'question' => 'What should I do after a truck accident on Dorchester Road?',
        'answer'   => 'Call 911, stay in your vehicle if the shoulder is too narrow to safely exit, document the truck (company name, USDOT number, cargo type), photograph road conditions including missing turn lane markings or pavement defects, seek medical treatment at Trident Medical Center or MUSC Health, and contact a truck accident attorney immediately to preserve ELD data and surveillance footage.',
    ),
) );
wp_set_object_terms( $post_id, array( $truck_term_id ), 'practice_category' );

WP_CLI::success( "CREATED: Dorchester Road Truck Accidents in North Charleston (ID {$post_id})" );
