<?php
/**
 * Seeder: Highway 501 Truck Accidents: Conway to Myrtle Beach
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

WP_CLI::log( 'Creating highway-501-truck-accidents-conway-myrtle-beach...' );

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $graeham ? $graeham->ID : 0;

$t = term_exists( 'truck-accidents', 'practice_category' );
if ( ! $t ) {
    $t = wp_insert_term( 'Truck Accidents', 'practice_category', array( 'slug' => 'truck-accidents' ) );
}
$truck_term_id = is_array( $t ) ? (int) $t['term_id'] : (int) $t;

$existing = get_page_by_path( 'highway-501-truck-accidents-conway-myrtle-beach', OBJECT, 'resource' );
if ( $existing ) {
    WP_CLI::log( "SKIP: already exists (ID {$existing->ID})" );
    return;
}

$content = '<h2>Highway 501: The Grand Strand\'s Most Dangerous Truck Corridor</h2>';
$content .= '<p>Highway 501 is the primary commercial artery connecting Conway to Myrtle Beach and it is one of the most dangerous roads in Horry County for truck accidents. Every delivery truck, fuel tanker, and construction vehicle serving the Grand Strand\'s tourism economy travels this corridor, sharing lanes with millions of tourists who are unfamiliar with local traffic patterns.</p>';
$content .= '<p>South Carolina recorded <strong>3,167 large truck crashes statewide in 2024</strong>, with a <strong>23% increase in fatal truck accidents</strong> over the prior year. Highway 501 and its major intersections account for a disproportionate share of those crashes in the Myrtle Beach market.</p>';
$content .= '<h2>Highway 501 Crash Hotspots</h2>';
$content .= '<h3>Highway 501 &amp; Four Mile Road (Conway)</h3>';
$content .= '<p>This intersection was ranked the <strong>highest priority for safety improvements</strong> by the SCDOT Highway Improvement Safety Program. With <strong>42 documented accidents since 2008, including 2 fatal crashes</strong>, this is ground zero for truck collisions on the 501 corridor.</p>';
$content .= '<h3>Highway 501 &amp; US-17 Bypass</h3>';
$content .= '<p>Where Highway 501 meets the US-17 Bypass, high-volume tourist traffic merges with commercial truck traffic heading to and from the Grand Strand\'s commercial districts. During peak season, severe congestion produces rear-end collisions.</p>';
$content .= '<h3>Carolina Forest Blvd &amp; Highway 501</h3>';
$content .= '<p>The Carolina Forest community is one of the fastest-growing residential areas in Horry County. The intersection handles a volatile mix of residential commuter traffic, school buses, commercial deliveries, and through-truck traffic.</p>';
$content .= '<h3>US 501 &amp; Seaboard Street</h3>';
$content .= '<p>This intersection is among the deadliest on the entire corridor, with <strong>2 fatalities</strong> recorded.</p>';
$content .= '<h2>Highway 501 Widening Project Dangers</h2>';
$content .= '<p>SCDOT\'s active Highway 501 widening project creates immediate hazards: narrowed lanes, lane shifts, construction equipment adjacent to live traffic, speed differentials, and uneven road surfaces. Construction zone truck crashes are among the most severe because concrete barriers eliminate escape routes.</p>';
$content .= '<h2>FMCSA Regulations</h2>';
$content .= '<p>Federal regulations govern every commercial truck on Highway 501. Violations constitute evidence of negligence in South Carolina courts:</p>';
$content .= '<ul>';
$content .= '<li><strong>Hours of Service:</strong> Maximum 11 hours driving in a 14-hour window after 10 hours off-duty</li>';
$content .= '<li><strong>Electronic Logging Devices:</strong> Required digital recording of driving hours</li>';
$content .= '<li><strong>Vehicle maintenance:</strong> Pre-trip and post-trip inspections mandatory</li>';
$content .= '<li><strong>Cargo securement:</strong> 49 CFR Part 393, Subpart I requirements</li>';
$content .= '<li><strong>Driver qualification:</strong> CDL requirements, drug and alcohol testing</li>';
$content .= '</ul>';
$content .= '<h2>Your Legal Rights</h2>';
$content .= '<ul>';
$content .= '<li><strong>Statute of limitations:</strong> 3 years from the date of injury (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code 15-3-530</a>)</li>';
$content .= '<li><strong>Modified comparative fault:</strong> Recovery if <strong>less than 51% at fault</strong></li>';
$content .= '<li><strong>Multiple liable parties:</strong> Truck driver, trucking company, cargo shipper, vehicle manufacturer, maintenance provider, construction contractor, or SCDOT</li>';
$content .= '<li><strong>Punitive damages:</strong> Available for willful, wanton, or reckless conduct</li>';
$content .= '</ul>';
$content .= '<h2>What to Do After a Truck Crash on Highway 501</h2>';
$content .= '<ol>';
$content .= '<li><strong>Move to safety if possible</strong></li>';
$content .= '<li><strong>Call 911</strong></li>';
$content .= '<li><strong>Document the truck:</strong> Company name, USDOT number, trailer number, cargo type</li>';
$content .= '<li><strong>Photograph everything</strong></li>';
$content .= '<li><strong>Get medical attention</strong> at Grand Strand Medical Center or Conway Medical Center</li>';
$content .= '<li><strong>Contact a truck accident attorney within 24-48 hours</strong></li>';
$content .= '</ol>';
$content .= '<h2>Free Consultation</h2>';
$content .= '<p>Roden Law\'s <a href="/locations/south-carolina/myrtle-beach/">Myrtle Beach office</a> at 631 Bellamy Ave., Suite C-B in Murrells Inlet serves the entire Grand Strand. We handle Highway 501 truck accident cases on contingency: <strong>no fees unless we recover compensation</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free consultation.</p>';

$post_id = wp_insert_post( array(
    'post_type'    => 'resource',
    'post_title'   => 'Highway 501 Truck Accidents: Conway to Myrtle Beach',
    'post_name'    => 'highway-501-truck-accidents-conway-myrtle-beach',
    'post_status'  => 'publish',
    'post_content' => $content,
    'post_excerpt' => 'Data-driven guide to truck accidents on Highway 501 between Conway and Myrtle Beach, South Carolina. Covers SCDOT-ranked crash hotspots, the 501 widening project, FMCSA regulations, and your legal rights.',
), true );

if ( is_wp_error( $post_id ) ) {
    WP_CLI::warning( 'FAILED: ' . $post_id->get_error_message() );
    return;
}

update_post_meta( $post_id, '_roden_author_attorney', $author_id );
update_post_meta( $post_id, '_roden_jurisdiction', 'sc' );
update_post_meta( $post_id, '_roden_faqs', array(
    array(
        'question' => 'What are the most dangerous intersections on Highway 501 for truck accidents?',
        'answer'   => 'The SCDOT Highway Improvement Safety Program ranked Highway 501 and Four Mile Road in Conway as the highest priority for safety improvements, with 42 accidents since 2008 including 2 fatal crashes. Other high-danger intersections include Highway 501 and US-17 Bypass, Carolina Forest Blvd and Highway 501, and US 501 and Seaboard Street.',
    ),
    array(
        'question' => 'How does the Highway 501 widening project affect truck accident risk?',
        'answer'   => 'The active SCDOT widening project creates construction zone hazards including narrowed lanes, lane shifts, temporary routes, and construction equipment operating adjacent to live traffic. Construction zone truck crashes tend to be more severe because concrete barriers trap vehicles in the impact zone.',
    ),
    array(
        'question' => 'How long do I have to file a truck accident lawsuit in South Carolina?',
        'answer'   => 'South Carolina has a 3-year statute of limitations for personal injury claims (S.C. Code 15-3-530). However, you should contact an attorney within 24-48 hours because critical evidence like ELD data and dash cam footage can be destroyed within days.',
    ),
    array(
        'question' => 'Who is liable for a truck crash in a construction zone on Highway 501?',
        'answer'   => 'Construction zone crashes may involve multiple liable parties: the truck driver, the trucking company, the construction contractor responsible for work zone design and signage, SCDOT if the construction plan was defective, and traffic control subcontractors.',
    ),
    array(
        'question' => 'What should I document at a Highway 501 truck accident scene?',
        'answer'   => 'Photograph the truck company name and USDOT number on the cab door, trailer number, cargo type, all vehicle damage, construction zone signage, mile markers, intersection signals, and road conditions.',
    ),
) );
wp_set_object_terms( $post_id, array( $truck_term_id ), 'practice_category' );

WP_CLI::success( "CREATED: Highway 501 Truck Accidents: Conway to Myrtle Beach (ID {$post_id})" );
