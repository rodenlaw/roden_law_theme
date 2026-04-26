<?php
/**
 * Seeder: Seasonal Truck Accident Dangers in Myrtle Beach
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

WP_CLI::log( 'Creating seasonal-truck-accidents-myrtle-beach...' );

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $graeham ? $graeham->ID : 0;

$t = term_exists( 'truck-accidents', 'practice_category' );
if ( ! $t ) {
    $t = wp_insert_term( 'Truck Accidents', 'practice_category', array( 'slug' => 'truck-accidents' ) );
}
$truck_term_id = is_array( $t ) ? (int) $t['term_id'] : (int) $t;

$existing = get_page_by_path( 'seasonal-truck-accidents-myrtle-beach', OBJECT, 'resource' );
if ( $existing ) {
    WP_CLI::log( "SKIP: already exists (ID {$existing->ID})" );
    return;
}

$content = '<h2>Why Myrtle Beach Has a Seasonal Truck Accident Problem</h2>';
$content .= '<p>Myrtle Beach\'s population <strong>roughly triples during the summer tourist season</strong>. The tourist season triggers a <strong>massive surge in commercial truck traffic</strong> on roads already overwhelmed by visitors.</p>';
$content .= '<p>South Carolina recorded <strong>3,167 large truck crashes in 2024</strong> with a <strong>23% increase in fatal truck accidents</strong>. The Myrtle Beach market\'s seasonal dynamics make it uniquely vulnerable: more trucks, more tourists, more pedestrians, and more chaos on roads like <a href="/resources/us-17-truck-accidents-grand-strand/">US-17</a>, <a href="/resources/highway-501-truck-accidents-conway-myrtle-beach/">Highway 501</a>, Kings Highway, and Ocean Boulevard.</p>';
$content .= '<h2>How Tourist Season Creates Truck Danger</h2>';
$content .= '<h3>Delivery Trucks</h3>';
$content .= '<p>Every restaurant, hotel, grocery store, and attraction increases orders during tourist season. Food distribution trucks, beverage trucks, linen and laundry trucks, package delivery trucks, and grocery supply trucks all increase frequency. Each stops, backs up, double-parks, and makes deliveries in areas crowded with pedestrians.</p>';
$content .= '<h3>Construction Vehicles</h3>';
$content .= '<p>Spring months before tourist season bring renovation and construction. Hotels, restaurants, and attractions rush upgrades before summer. Concrete trucks, dump trucks, flatbed trucks, and crane trucks crowd roadways designed for passenger vehicles.</p>';
$content .= '<h3>Fuel Tankers</h3>';
$content .= '<p>Tourist season dramatically increases fuel demand. Gas station tankers make more frequent deliveries. Fuel tankers are among the most dangerous trucks on the road; a tanker crash can produce fires, explosions, and hazardous material spills.</p>';
$content .= '<h3>Moving Trucks</h3>';
$content .= '<p>Thousands of vacation rental turnovers each week put rental trucks (U-Haul, Penske, Budget) on the road driven by vacationers with no CDL or commercial driving experience. They are driving unfamiliar vehicles on unfamiliar roads in heavy traffic.</p>';
$content .= '<h2>Peak Danger Months</h2>';
$content .= '<table>';
$content .= '<thead>';
$content .= '<tr><th>Month</th><th>Primary Truck Danger</th><th>Why</th></tr>';
$content .= '</thead>';
$content .= '<tbody>';
$content .= '<tr><td>March-April</td><td>Construction vehicles</td><td>Hotels rush renovations before summer</td></tr>';
$content .= '<tr><td>May</td><td>Construction + delivery surge</td><td>Renovation overlaps with increasing tourist traffic</td></tr>';
$content .= '<tr><td>June-August</td><td>All truck types peak</td><td>Population triples; all trucks at maximum volume</td></tr>';
$content .= '<tr><td>September</td><td>Delivery + moving trucks</td><td>End-of-season turnover and restocking</td></tr>';
$content .= '<tr><td>October-November</td><td>Construction vehicles return</td><td>Post-season renovation window</td></tr>';
$content .= '</tbody>';
$content .= '</table>';
$content .= '<h2>The Tourist Driver Factor</h2>';
$content .= '<ul>';
$content .= '<li><strong>Sudden stops:</strong> Tourists brake abruptly for attractions and missed turns</li>';
$content .= '<li><strong>Wrong turns and U-turns:</strong> Unfamiliar drivers make unexpected maneuvers in front of trucks</li>';
$content .= '<li><strong>Distracted driving:</strong> Vacationers sightseeing and checking GPS</li>';
$content .= '<li><strong>Pedestrian behavior:</strong> Tourists jaywalk at far higher rates than local residents</li>';
$content .= '<li><strong>Cyclist exposure:</strong> Rental bicycles, e-bikes, and scooters surge during tourist season</li>';
$content .= '</ul>';
$content .= '<h2>South Carolina Truck Accident Law</h2>';
$content .= '<ul>';
$content .= '<li><strong>Statute of limitations:</strong> 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code 15-3-530</a>)</li>';
$content .= '<li><strong>Modified comparative fault:</strong> Recovery if less than 51% at fault</li>';
$content .= '<li><strong>Multiple liable parties:</strong> Truck driver, trucking company, the business that ordered the delivery, rental truck company, and vehicle manufacturers</li>';
$content .= '<li><strong>Punitive damages:</strong> Available for willful, wanton, or reckless conduct</li>';
$content .= '</ul>';
$content .= '<h2>What to Do After a Seasonal Truck Crash</h2>';
$content .= '<ol>';
$content .= '<li><strong>Get to safety</strong></li>';
$content .= '<li><strong>Call 911</strong></li>';
$content .= '<li><strong>Identify the truck:</strong> Company name, USDOT number, what it was delivering, and where</li>';
$content .= '<li><strong>Photograph the scene</strong></li>';
$content .= '<li><strong>Get witnesses</strong> (tourist areas have abundant witnesses)</li>';
$content .= '<li><strong>Seek medical attention</strong> at Grand Strand Medical Center</li>';
$content .= '<li><strong>Contact a truck accident attorney</strong></li>';
$content .= '</ol>';
$content .= '<h2>Free Consultation</h2>';
$content .= '<p>Roden Law\'s <a href="/locations/south-carolina/myrtle-beach/">Myrtle Beach office</a> at 631 Bellamy Ave., Suite C-B in Murrells Inlet understands the Grand Strand\'s seasonal truck dangers. We handle truck accident cases on contingency: <strong>no fees unless we recover compensation</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free consultation.</p>';
$content .= '<p>All truck accident cases are filed in <strong>Horry County Circuit Court</strong> in Conway.</p>';

$post_id = wp_insert_post( array(
    'post_type'    => 'resource',
    'post_title'   => 'Seasonal Truck Accident Dangers in Myrtle Beach',
    'post_name'    => 'seasonal-truck-accidents-myrtle-beach',
    'post_status'  => 'publish',
    'post_content' => $content,
    'post_excerpt' => 'Guide to seasonal truck accident dangers in Myrtle Beach, SC. Population triples in summer, increasing delivery trucks, construction vehicles, fuel tankers, and moving trucks on roads shared with tourists.',
), true );

if ( is_wp_error( $post_id ) ) {
    WP_CLI::warning( 'FAILED: ' . $post_id->get_error_message() );
    return;
}

update_post_meta( $post_id, '_roden_author_attorney', $author_id );
update_post_meta( $post_id, '_roden_jurisdiction', 'sc' );
update_post_meta( $post_id, '_roden_faqs', array(
    array(
        'question' => 'Why are truck accidents more common in Myrtle Beach during tourist season?',
        'answer'   => 'Myrtle Beach\'s population roughly triples during summer, driving a massive increase in commercial truck traffic: more delivery trucks, more fuel tankers, more construction vehicles, and more moving trucks. All share roads with millions of tourists unfamiliar with local traffic patterns.',
    ),
    array(
        'question' => 'What types of trucks increase during Myrtle Beach tourist season?',
        'answer'   => 'Every category increases: food and beverage delivery trucks, linen service trucks, fuel tankers, package delivery trucks, construction vehicles, and moving trucks for vacation rental turnovers. June through August sees all truck types at maximum volume simultaneously.',
    ),
    array(
        'question' => 'Are rental moving trucks dangerous during tourist season?',
        'answer'   => 'Yes. Thousands of vacation rental turnovers each week put rental trucks on the road driven by vacationers with no CDL or commercial driving experience. These drivers are unfamiliar with blind spots, wide turns, stopping distances, and height clearances.',
    ),
    array(
        'question' => 'When are the most dangerous months for truck accidents in Myrtle Beach?',
        'answer'   => 'June through August is the peak danger period when all truck types operate at maximum volume alongside peak tourist traffic. March through May is also dangerous as construction vehicles crowd roads for pre-season renovations.',
    ),
    array(
        'question' => 'Can a business be held liable if their delivery truck causes a crash?',
        'answer'   => 'Yes. If a business required delivery practices that created dangerous conditions, such as mandating early-morning deliveries to pedestrian areas or requiring double-parking on busy streets, the business may share liability with the truck driver and trucking company.',
    ),
) );
wp_set_object_terms( $post_id, array( $truck_term_id ), 'practice_category' );

WP_CLI::success( "CREATED: Seasonal Truck Accident Dangers in Myrtle Beach (ID {$post_id})" );
