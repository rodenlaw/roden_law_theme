<?php
/**
 * Seeder: Truck Corridor Resource Pages - Myrtle Beach Market
 *
 * Creates 3 resource posts:
 *   1. Highway 501 Truck Accidents: Conway to Myrtle Beach
 *   2. US-17 Truck Accidents in the Grand Strand
 *   3. Seasonal Truck Accident Dangers in Myrtle Beach
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-truck-corridor-myrtle-beach.php
 *
 * Idempotent - skips any post whose slug already exists.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Author attribution
   ------------------------------------------------------------------ */

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $graeham ? $graeham->ID : 0;
WP_CLI::log( $author_id ? "Author: Graeham C. Gillin (ID {$author_id})" : 'WARNING: Attorney not found.' );

/* ------------------------------------------------------------------
   Taxonomy terms
   ------------------------------------------------------------------ */

$terms = array();
$t = term_exists( 'truck-accidents', 'practice_category' );
if ( ! $t ) {
    $t = wp_insert_term( 'Truck Accidents', 'practice_category', array( 'slug' => 'truck-accidents' ) );
}
$terms['truck-accidents'] = is_array( $t ) ? (int) $t['term_id'] : (int) $t;

/* ------------------------------------------------------------------
   Resource definitions
   ------------------------------------------------------------------ */

$resources = array(

    array(
        'title'      => 'Highway 501 Truck Accidents: Conway to Myrtle Beach',
        'slug'       => 'highway-501-truck-accidents-conway-myrtle-beach',
        'excerpt'    => 'Data-driven guide to truck accidents on Highway 501 between Conway and Myrtle Beach, South Carolina. Covers SCDOT-ranked crash hotspots, the 501 widening project, FMCSA regulations, and your legal rights.',
        'categories' => array( 'truck-accidents' ),
        'content'    => '<h2>Highway 501: The Grand Strand\'s Most Dangerous Truck Corridor</h2>
<p>Highway 501 is the primary commercial artery connecting Conway to Myrtle Beach and it is one of the most dangerous roads in Horry County for truck accidents. Every delivery truck, fuel tanker, and construction vehicle serving the Grand Strand\'s tourism economy travels this corridor, sharing lanes with millions of tourists who are unfamiliar with local traffic patterns.</p>
<p>South Carolina recorded <strong>3,167 large truck crashes statewide in 2024</strong>, with a <strong>23% increase in fatal truck accidents</strong> over the prior year. Highway 501 and its major intersections account for a disproportionate share of those crashes in the Myrtle Beach market.</p>

<h2>Highway 501 Crash Hotspots</h2>

<h3>Highway 501 &amp; Four Mile Road (Conway)</h3>
<p>This intersection was ranked the <strong>highest priority for safety improvements</strong> by the SCDOT Highway Improvement Safety Program. With <strong>42 documented accidents since 2008, including 2 fatal crashes</strong>, this is ground zero for truck collisions on the 501 corridor.</p>

<h3>Highway 501 &amp; US-17 Bypass</h3>
<p>Where Highway 501 meets the US-17 Bypass, high-volume tourist traffic merges with commercial truck traffic heading to and from the Grand Strand\'s commercial districts. During peak season, severe congestion produces rear-end collisions.</p>

<h3>Carolina Forest Blvd &amp; Highway 501</h3>
<p>The Carolina Forest community is one of the fastest-growing residential areas in Horry County. The intersection handles a volatile mix of residential commuter traffic, school buses, commercial deliveries, and through-truck traffic.</p>

<h3>US 501 &amp; Seaboard Street</h3>
<p>This intersection is among the deadliest on the entire corridor, with <strong>2 fatalities</strong> recorded.</p>

<h2>Highway 501 Widening Project Dangers</h2>
<p>SCDOT\'s active Highway 501 widening project creates immediate hazards: narrowed lanes, lane shifts, construction equipment adjacent to live traffic, speed differentials, and uneven road surfaces. Construction zone truck crashes are among the most severe because concrete barriers eliminate escape routes.</p>

<h2>FMCSA Regulations</h2>
<p>Federal regulations govern every commercial truck on Highway 501. Violations constitute evidence of negligence in South Carolina courts:</p>
<ul>
<li><strong>Hours of Service:</strong> Maximum 11 hours driving in a 14-hour window after 10 hours off-duty</li>
<li><strong>Electronic Logging Devices:</strong> Required digital recording of driving hours</li>
<li><strong>Vehicle maintenance:</strong> Pre-trip and post-trip inspections mandatory</li>
<li><strong>Cargo securement:</strong> 49 CFR Part 393, Subpart I requirements</li>
<li><strong>Driver qualification:</strong> CDL requirements, drug and alcohol testing</li>
</ul>

<h2>Your Legal Rights</h2>
<ul>
<li><strong>Statute of limitations:</strong> 3 years from the date of injury (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code 15-3-530</a>)</li>
<li><strong>Modified comparative fault:</strong> Recovery if <strong>less than 51% at fault</strong></li>
<li><strong>Multiple liable parties:</strong> Truck driver, trucking company, cargo shipper, vehicle manufacturer, maintenance provider, construction contractor, or SCDOT</li>
<li><strong>Punitive damages:</strong> Available for willful, wanton, or reckless conduct</li>
</ul>

<h2>What to Do After a Truck Crash on Highway 501</h2>
<ol>
<li><strong>Move to safety if possible</strong></li>
<li><strong>Call 911</strong></li>
<li><strong>Document the truck:</strong> Company name, USDOT number, trailer number, cargo type</li>
<li><strong>Photograph everything</strong></li>
<li><strong>Get medical attention</strong> at Grand Strand Medical Center or Conway Medical Center</li>
<li><strong>Contact a truck accident attorney within 24-48 hours</strong></li>
</ol>

<h2>Free Consultation</h2>
<p>Roden Law\'s <a href="/locations/south-carolina/myrtle-beach/">Myrtle Beach office</a> at 631 Bellamy Ave., Suite C-B in Murrells Inlet serves the entire Grand Strand. We handle Highway 501 truck accident cases on contingency: <strong>no fees unless we recover compensation</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free consultation.</p>',
        'faqs' => array(
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
        ),
    ),

    array(
        'title'      => 'US-17 Truck Accidents in the Grand Strand',
        'slug'       => 'us-17-truck-accidents-grand-strand',
        'excerpt'    => 'Guide to truck accidents on US-17 from Murrells Inlet to North Myrtle Beach, South Carolina. Covers the US-17 Bypass, Kings Highway, Ocean Boulevard, and pedestrian fatalities.',
        'categories' => array( 'truck-accidents' ),
        'content'    => '<h2>US-17 Through the Grand Strand: Where Commercial Trucks Meet Tourist Traffic</h2>
<p>US-17 runs the entire length of the Grand Strand coast from Murrells Inlet through Myrtle Beach to North Myrtle Beach. Unlike inland highways where commercial trucks are separated from pedestrian areas, <strong>trucks in Myrtle Beach travel down Main Street and side streets</strong>, mixing directly with tourist pedestrians, cyclists, and unfamiliar drivers.</p>
<p>South Carolina recorded <strong>3,167 large truck crashes in 2024</strong> with a <strong>23% increase in fatal truck accidents</strong>. The US-17 corridor through the Grand Strand accounts for a significant share of those crashes.</p>

<h2>US-17 Truck Accident Statistics</h2>
<ul>
<li>A <strong>pedestrian was killed by a tractor-trailer on US-17 north of River Road</strong> in January 2026</li>
<li>US-17 Bypass from Murrells Inlet to North Myrtle Beach experiences <strong>frequent bumper-to-bumper backups</strong></li>
<li>The US-17 segment from Gardens Corner to Jacksonboro was featured on <strong>NBC Dateline\'s "America\'s Most Dangerous Roads"</strong></li>
<li>Unlike most SC markets, Myrtle Beach trucks travel on <strong>Main Street, Kings Highway, and Ocean Boulevard</strong></li>
</ul>

<h2>Dangerous Segments</h2>

<h3>US-17 Bypass: Murrells Inlet to North Myrtle Beach</h3>
<p>Frequent bumper-to-bumper backups, especially during tourist season, create ideal conditions for rear-end truck collisions. A loaded commercial truck needs <strong>500+ feet to stop</strong> at highway speed.</p>

<h3>Kings Highway</h3>
<p>The Grand Strand\'s primary north-south commercial corridor combines heavy commercial truck traffic, tourist pedestrians, frequent traffic signals, and turning trucks accessing loading zones.</p>

<h3>Ocean Boulevard</h3>
<p>Ocean Boulevard carries delivery trucks serving oceanfront hotels and restaurants alongside slow-moving tourist vehicles, jaywalking pedestrians, cyclists, and golf carts.</p>

<h3>US-17 North of River Road</h3>
<p>In January 2026, a pedestrian was killed by a tractor-trailer at this location. Inadequate crosswalks, minimal lighting, and high truck speed create a fatal combination.</p>

<h2>South Carolina Truck Accident Law</h2>
<ul>
<li><strong>Statute of limitations:</strong> 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code 15-3-530</a>)</li>
<li><strong>Comparative fault:</strong> Recovery if less than 51% at fault</li>
<li><strong>Wrongful death:</strong> S.C. Code 15-51-10 allows surviving family members to bring a claim</li>
<li><strong>Multiple liable parties:</strong> Truck driver, trucking company, cargo shipper, delivery client, vehicle manufacturer</li>
</ul>

<h2>What to Do After a US-17 Truck Crash</h2>
<ol>
<li><strong>Move to safety</strong></li>
<li><strong>Call 911</strong></li>
<li><strong>Document the truck:</strong> Company name, USDOT number, cargo type, whether making a delivery</li>
<li><strong>Photograph the scene</strong></li>
<li><strong>Get witness information</strong></li>
<li><strong>Seek medical attention</strong> at Grand Strand Medical Center</li>
<li><strong>Contact a truck accident attorney within 24-48 hours</strong></li>
</ol>

<h2>Free Consultation</h2>
<p>Roden Law\'s <a href="/locations/south-carolina/myrtle-beach/">Myrtle Beach office</a> handles US-17 truck accident cases across the entire Grand Strand. Contingency fee: <strong>no fees unless we recover compensation</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free consultation.</p>',
        'faqs' => array(
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
        ),
    ),

    array(
        'title'      => 'Seasonal Truck Accident Dangers in Myrtle Beach',
        'slug'       => 'seasonal-truck-accidents-myrtle-beach',
        'excerpt'    => 'Guide to seasonal truck accident dangers in Myrtle Beach, SC. Population triples in summer, increasing delivery trucks, construction vehicles, fuel tankers, and moving trucks on roads shared with tourists.',
        'categories' => array( 'truck-accidents' ),
        'content'    => '<h2>Why Myrtle Beach Has a Seasonal Truck Accident Problem</h2>
<p>Myrtle Beach\'s population <strong>roughly triples during the summer tourist season</strong>. The tourist season triggers a <strong>massive surge in commercial truck traffic</strong> on roads already overwhelmed by visitors.</p>
<p>South Carolina recorded <strong>3,167 large truck crashes in 2024</strong> with a <strong>23% increase in fatal truck accidents</strong>. The Myrtle Beach market\'s seasonal dynamics make it uniquely vulnerable: more trucks, more tourists, more pedestrians, and more chaos on roads like <a href="/resources/us-17-truck-accidents-grand-strand/">US-17</a>, <a href="/resources/highway-501-truck-accidents-conway-myrtle-beach/">Highway 501</a>, Kings Highway, and Ocean Boulevard.</p>

<h2>How Tourist Season Creates Truck Danger</h2>

<h3>Delivery Trucks</h3>
<p>Every restaurant, hotel, grocery store, and attraction increases orders during tourist season. Food distribution trucks, beverage trucks, linen and laundry trucks, package delivery trucks, and grocery supply trucks all increase frequency. Each stops, backs up, double-parks, and makes deliveries in areas crowded with pedestrians.</p>

<h3>Construction Vehicles</h3>
<p>Spring months before tourist season bring renovation and construction. Hotels, restaurants, and attractions rush upgrades before summer. Concrete trucks, dump trucks, flatbed trucks, and crane trucks crowd roadways designed for passenger vehicles.</p>

<h3>Fuel Tankers</h3>
<p>Tourist season dramatically increases fuel demand. Gas station tankers make more frequent deliveries. Fuel tankers are among the most dangerous trucks on the road; a tanker crash can produce fires, explosions, and hazardous material spills.</p>

<h3>Moving Trucks</h3>
<p>Thousands of vacation rental turnovers each week put rental trucks (U-Haul, Penske, Budget) on the road driven by vacationers with no CDL or commercial driving experience. They are driving unfamiliar vehicles on unfamiliar roads in heavy traffic.</p>

<h2>Peak Danger Months</h2>
<table>
<thead>
<tr><th>Month</th><th>Primary Truck Danger</th><th>Why</th></tr>
</thead>
<tbody>
<tr><td>March-April</td><td>Construction vehicles</td><td>Hotels rush renovations before summer</td></tr>
<tr><td>May</td><td>Construction + delivery surge</td><td>Renovation overlaps with increasing tourist traffic</td></tr>
<tr><td>June-August</td><td>All truck types peak</td><td>Population triples; all trucks at maximum volume</td></tr>
<tr><td>September</td><td>Delivery + moving trucks</td><td>End-of-season turnover and restocking</td></tr>
<tr><td>October-November</td><td>Construction vehicles return</td><td>Post-season renovation window</td></tr>
</tbody>
</table>

<h2>The Tourist Driver Factor</h2>
<ul>
<li><strong>Sudden stops:</strong> Tourists brake abruptly for attractions and missed turns</li>
<li><strong>Wrong turns and U-turns:</strong> Unfamiliar drivers make unexpected maneuvers in front of trucks</li>
<li><strong>Distracted driving:</strong> Vacationers sightseeing and checking GPS</li>
<li><strong>Pedestrian behavior:</strong> Tourists jaywalk at far higher rates than local residents</li>
<li><strong>Cyclist exposure:</strong> Rental bicycles, e-bikes, and scooters surge during tourist season</li>
</ul>

<h2>South Carolina Truck Accident Law</h2>
<ul>
<li><strong>Statute of limitations:</strong> 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code 15-3-530</a>)</li>
<li><strong>Modified comparative fault:</strong> Recovery if less than 51% at fault</li>
<li><strong>Multiple liable parties:</strong> Truck driver, trucking company, the business that ordered the delivery, rental truck company, and vehicle manufacturers</li>
<li><strong>Punitive damages:</strong> Available for willful, wanton, or reckless conduct</li>
</ul>

<h2>What to Do After a Seasonal Truck Crash</h2>
<ol>
<li><strong>Get to safety</strong></li>
<li><strong>Call 911</strong></li>
<li><strong>Identify the truck:</strong> Company name, USDOT number, what it was delivering, and where</li>
<li><strong>Photograph the scene</strong></li>
<li><strong>Get witnesses</strong> (tourist areas have abundant witnesses)</li>
<li><strong>Seek medical attention</strong> at Grand Strand Medical Center</li>
<li><strong>Contact a truck accident attorney</strong></li>
</ol>

<h2>Free Consultation</h2>
<p>Roden Law\'s <a href="/locations/south-carolina/myrtle-beach/">Myrtle Beach office</a> at 631 Bellamy Ave., Suite C-B in Murrells Inlet understands the Grand Strand\'s seasonal truck dangers. We handle truck accident cases on contingency: <strong>no fees unless we recover compensation</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free consultation.</p>
<p>All truck accident cases are filed in <strong>Horry County Circuit Court</strong> in Conway.</p>',
        'faqs' => array(
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
        ),
    ),
);

/* ------------------------------------------------------------------
   Create posts
   ------------------------------------------------------------------ */

$created = 0;
$skipped = 0;

foreach ( $resources as $r ) {
    $existing = get_page_by_path( $r['slug'], OBJECT, 'resource' );
    if ( $existing ) {
        WP_CLI::log( "SKIP: \"{$r['title']}\" already exists (ID {$existing->ID})" );
        $skipped++;
        continue;
    }

    $post_id = wp_insert_post( array(
        'post_type'    => 'resource',
        'post_title'   => $r['title'],
        'post_name'    => $r['slug'],
        'post_status'  => 'publish',
        'post_content' => $r['content'],
        'post_excerpt' => $r['excerpt'],
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "FAILED: \"{$r['title']}\" -- " . $post_id->get_error_message() );
        continue;
    }

    update_post_meta( $post_id, '_roden_author_attorney', $author_id );
    update_post_meta( $post_id, '_roden_jurisdiction', 'sc' );

    if ( ! empty( $r['faqs'] ) ) {
        update_post_meta( $post_id, '_roden_faqs', $r['faqs'] );
    }

    if ( ! empty( $r['categories'] ) ) {
        $term_ids = array_map( function( $slug ) use ( $terms ) {
            return $terms[ $slug ] ?? 0;
        }, $r['categories'] );
        $term_ids = array_filter( $term_ids );
        if ( $term_ids ) {
            wp_set_object_terms( $post_id, $term_ids, 'practice_category' );
        }
    }

    WP_CLI::success( "CREATED: \"{$r['title']}\" (ID {$post_id}) -- /resources/{$r['slug']}/" );
    $created++;
}

WP_CLI::log( '' );
WP_CLI::log( "Done. Created: {$created} | Skipped: {$skipped}" );
