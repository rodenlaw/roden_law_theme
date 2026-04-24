<?php
/**
 * Seeder: US-17 Truck Accidents in the Grand Strand
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

WP_CLI::log( 'Creating us-17-truck-accidents-grand-strand...' );

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $graeham ? $graeham->ID : 0;

$t = term_exists( 'truck-accidents', 'practice_category' );
if ( ! $t ) {
    $t = wp_insert_term( 'Truck Accidents', 'practice_category', array( 'slug' => 'truck-accidents' ) );
}
$truck_term_id = is_array( $t ) ? (int) $t['term_id'] : (int) $t;

$existing = get_page_by_path( 'us-17-truck-accidents-grand-strand', OBJECT, 'resource' );
if ( $existing ) {
    WP_CLI::log( "SKIP: already exists (ID {$existing->ID})" );
    return;
}

$content = '<h2>US-17 Through the Grand Strand: Where Commercial Trucks Meet Tourist Traffic</h2>';
$content .= '<p>US-17 runs the entire length of the Grand Strand coast from Murrells Inlet through Myrtle Beach to North Myrtle Beach. Unlike inland highways where commercial trucks are separated from pedestrian areas, <strong>trucks in Myrtle Beach travel down Main Street and side streets</strong>, mixing directly with tourist pedestrians, cyclists, and unfamiliar drivers.</p>';
$content .= '<p>South Carolina recorded <strong>3,167 large truck crashes in 2024</strong> with a <strong>23% increase in fatal truck accidents</strong>. The US-17 corridor through the Grand Strand accounts for a significant share of those crashes.</p>';
$content .= '<h2>US-17 Truck Accident Statistics</h2>';
$content .= '<ul>';
$content .= '<li>A <strong>pedestrian was killed by a tractor-trailer on US-17 north of River Road</strong> in January 2026</li>';
$content .= '<li>US-17 Bypass from Murrells Inlet to North Myrtle Beach experiences <strong>frequent bumper-to-bumper backups</strong></li>';
$content .= '<li>The US-17 segment from Gardens Corner to Jacksonboro was featured on <strong>NBC Dateline\'s "America\'s Most Dangerous Roads"</strong></li>';
$content .= '<li>Unlike most SC markets, Myrtle Beach trucks travel on <strong>Main Street, Kings Highway, and Ocean Boulevard</strong></li>';
$content .= '</ul>';
$content .= '<h2>Dangerous Segments</h2>';
$content .= '<h3>US-17 Bypass: Murrells Inlet to North Myrtle Beach</h3>';
$content .= '<p>Frequent bumper-to-bumper backups, especially during tourist season, create ideal conditions for rear-end truck collisions. A loaded commercial truck needs <strong>500+ feet to stop</strong> at highway speed.</p>';
$content .= '<h3>Kings Highway</h3>';
$content .= '<p>The Grand Strand\'s primary north-south commercial corridor combines heavy commercial truck traffic, tourist pedestrians, frequent traffic signals, and turning trucks accessing loading zones.</p>';
$content .= '<h3>Ocean Boulevard</h3>';
$content .= '<p>Ocean Boulevard carries delivery trucks serving oceanfront hotels and restaurants alongside slow-moving tourist vehicles, jaywalking pedestrians, cyclists, and golf carts.</p>';
$content .= '<h3>US-17 North of River Road</h3>';
$content .= '<p>In January 2026, a pedestrian was killed by a tractor-trailer at this location. Inadequate crosswalks, minimal lighting, and high truck speed create a fatal combination.</p>';
$content .= '<h2>South Carolina Truck Accident Law</h2>';
$content .= '<ul>';
$content .= '<li><strong>Statute of limitations:</strong> 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code 15-3-530</a>)</li>';
$content .= '<li><strong>Comparative fault:</strong> Recovery if less than 51% at fault</li>';
$content .= '<li><strong>Wrongful death:</strong> S.C. Code 15-51-10 allows surviving family members to bring a claim</li>';
$content .= '<li><strong>Multiple liable parties:</strong> Truck driver, trucking company, cargo shipper, delivery client, vehicle manufacturer</li>';
$content .= '</ul>';
$content .= '<h2>What to Do After a US-17 Truck Crash</h2>';
$content .= '<ol>';
$content .= '<li><strong>Move to safety</strong></li>';
$content .= '<li><strong>Call 911</strong></li>';
$content .= '<li><strong>Document the truck:</strong> Company name, USDOT number, cargo type, whether making a delivery</li>';
$content .= '<li><strong>Photograph the scene</strong></li>';
$content .= '<li><strong>Get witness information</strong></li>';
$content .= '<li><strong>Seek medical attention</strong> at Grand Strand Medical Center</li>';
$content .= '<li><strong>Contact a truck accident attorney within 24-48 hours</strong></li>';
$content .= '</ol>';
$content .= '<h2>Free Consultation</h2>';
$content .= '<p>Roden Law\'s <a href="/locations/south-carolina/myrtle-beach/">Myrtle Beach office</a> handles US-17 truck accident cases across the entire Grand Strand. Contingency fee: <strong>no fees unless we recover compensation</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free consultation.</p>';

$post_id = wp_insert_post( array(
    'post_type'    => 'resource',
    'post_title'   => 'US-17 Truck Accidents in the Grand Strand',
    'post_name'    => 'us-17-truck-accidents-grand-strand',
    'post_status'  => 'publish',
    'post_content' => $content,
    'post_excerpt' => 'Guide to truck accidents on US-17 from Murrells Inlet to North Myrtle Beach, South Carolina. Covers the US-17 Bypass, Kings Highway, Ocean Boulevard, and pedestrian fatalities.',
), true );

if ( is_wp_error( $post_id ) ) {
    WP_CLI::warning( 'FAILED: ' . $post_id->get_error_message() );
    return;
}

update_post_meta( $post_id, '_roden_author_attorney', $author_id );
update_post_meta( $post_id, '_roden_jurisdiction', 'sc' );
update_post_meta( $post_id, '_roden_faqs', array(
    array(
        'question' => 'Why do commercial trucks drive on Myrtle Beach side streets and Main Street?',
        'answer'   => 'Myrtle Beach has a dense strip of hotels, restaurants, and attractions along the coast that require constant commercial deliveries. Delivery trucks, fuel tankers, construction vehicles, and waste haulers must use Kings Highway, Ocean Boulevard, and Main Street to reach these businesses.',
    ),
    array(
        'question' => 'How dangerous is the US-17 Bypass for truck accidents?',
        'answer'   => 'The US-17 Bypass from Murrells Inlet to North Myrtle Beach experiences frequent bumper-to-bumper traffic backups, especially during tourist season. These backups are particularly dangerous because loaded commercial trucks need 500+ feet to stop at highway speed.',
    ),
    array(
        'question' => 'Was someone killed by a truck on US-17 in the Grand Strand recently?',
        'answer'   => 'Yes. In January 2026, a pedestrian was killed by a tractor-trailer on US-17 north of River Road. This crash highlights the lethal danger when pedestrians encounter commercial trucks on a highway corridor with inadequate crosswalks and minimal lighting.',
    ),
    array(
        'question' => 'What makes Kings Highway dangerous for truck accidents?',
        'answer'   => 'Kings Highway is the Grand Strand\'s primary north-south commercial corridor running through the heart of Myrtle Beach. It combines heavy commercial truck traffic, tourist pedestrians crossing between hotels and attractions, frequent traffic signals, and turning trucks accessing loading zones.',
    ),
    array(
        'question' => 'How long do I have to file a truck accident claim in South Carolina?',
        'answer'   => 'South Carolina has a 3-year statute of limitations for personal injury claims (S.C. Code 15-3-530). Contact an attorney within 24-48 hours because ELD data, dash cam footage, and drug test results can be lost within days.',
    ),
) );
wp_set_object_terms( $post_id, array( $truck_term_id ), 'practice_category' );

WP_CLI::success( "CREATED: US-17 Truck Accidents in the Grand Strand (ID {$post_id})" );
