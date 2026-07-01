<?php
/**
 * Seeder: car-accident-lawyers × Myrtle Beach, SC intersection page
 *
 * Publishes /car-accident-lawyers/myrtle-beach-sc/ as a child of the
 * car-accident-lawyers pillar with AEO-optimized, car-accident-specific body
 * + FAQPage meta + attorney attribution. Part of the 2026-06 AI-visibility
 * remediation. Office is physically in Murrells Inlet but markets as the
 * Myrtle Beach / Grand Strand area. Office local_context (Horry County filing,
 * golf-cart statute, trauma routing) renders separately via
 * template-intersection.php — not duplicated here.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-car-accident-myrtle-beach.php
 *
 * Safe to re-run: updates in place if the page already exists.
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Seeding car-accident-lawyers × Myrtle Beach, SC...' );

$pillar = get_page_by_path( 'car-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "car-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people injured in car accidents across the Myrtle Beach area and the Grand Strand</strong> — Myrtle Beach, North Myrtle Beach, Murrells Inlet, Surfside Beach, Conway, and Pawleys Island. Every case is handled on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Our office is in Murrells Inlet at 631 Bellamy Avenue, Suite C-B, just off US-17. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Myrtle Beach Car Accident Claim</h2>
<p>The Grand Strand draws roughly 17–20 million visitors a year, and that seasonal surge reshapes the local crash picture — out-of-state drivers unfamiliar with the roads, congested resort corridors, and a defense bar experienced at minimizing tourist claims. What sets Roden Law apart is direct attorney involvement: you work with your attorney, not a rotating desk of case managers, from intake through settlement or verdict.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no upfront cost to start your claim.</li>
<li><strong>Local Grand Strand knowledge</strong> — we know US-17, US-501, and the SC-31 bypass, and the seasonal traffic patterns that drive Horry County crashes.</li>
<li><strong>Trial-ready</strong> — we build every car accident case as if it will be tried, which is what moves insurers to pay full value.</li>
</ul>

<h2>Common Causes of Myrtle Beach Car Accidents</h2>
<p>The collisions our Grand Strand attorneys handle most often involve:</p>
<ul>
<li><strong>Tourist-corridor crashes</strong> on US-17 Business (Kings Highway) and Ocean Boulevard, where heavy pedestrian and stop-and-go traffic meets distracted out-of-state drivers.</li>
<li><strong>High-severity highway crashes</strong> on the SC-31 Carolina Bays Parkway and at its merge zones, and on US-501 between Conway and the beach.</li>
<li><strong>Seasonal and event surges</strong> — spring break, summer peak, and Bike Week sharply raise crash volume.</li>
<li><strong>Golf cart and low-speed-vehicle collisions</strong> on resort properties and public streets, which can trigger both traffic-law and premises-liability claims under S.C. Code § 56-2-100.</li>
<li><strong>Uninsured and underinsured drivers</strong> — common in claims that exceed South Carolina's 25/50/25 minimum policy limits, especially out-of-state minimum-limits drivers.</li>
</ul>

<h2>South Carolina Car Accident Law: What Grand Strand Drivers Need to Know</h2>
<h3>You Have 3 Years to File</h3>
<p>South Carolina's statute of limitations for car accident injury claims is <strong>three years from the date of the crash under S.C. Code § 15-3-530</strong>. If you were a visitor and returned home after your trip, this deadline still runs from the date of the South Carolina crash — your home-state law does not control.</p>
<h3>The 51% Comparative-Fault Bar</h3>
<p>South Carolina uses <strong>modified comparative fault</strong>: you can recover as long as you are <strong>less than 51% responsible</strong>, with your award reduced by your share of fault. Insurers routinely try to shift blame onto out-of-state drivers — our attorneys anticipate and dismantle that tactic.</p>
<h3>Stacking UM/UIM Coverage</h3>
<p>When an at-fault driver carries only minimum limits, South Carolina lets you <strong>stack uninsured and underinsured motorist coverage</strong> across policies — frequently the largest recovery source when a tourist is hit by a minimum-limits driver.</p>

<h2>Compensation in a Myrtle Beach Car Accident Case</h2>
<ul>
<li><strong>Medical expenses</strong> — including treatment received during your visit and ongoing care after you return home.</li>
<li><strong>Lost wages and lost earning capacity</strong> — for time off work and any permanent limitation on your ability to earn.</li>
<li><strong>Pain and suffering</strong> — non-economic damages, which South Carolina does not cap in standard car accident cases.</li>
<li><strong>Travel and accommodation costs</strong> — related to returning for treatment or legal proceedings.</li>
<li><strong>Punitive damages</strong> — available where the at-fault driver's conduct was reckless, such as drunk or extreme-speed driving.</li>
</ul>

<h2>What to Do After a Car Accident in Myrtle Beach</h2>
<ol>
<li>Call 911 and get a police report — Myrtle Beach PD, Horry County police, or SC Highway Patrol depending on where the crash occurred.</li>
<li>Photograph the vehicles, the scene, road conditions, and any visible injuries before anything is moved.</li>
<li>Collect the other driver's insurance information and witness names and numbers.</li>
<li>Get medical care before leaving the area if possible — records created close in time to the crash are the strongest evidence. Serious-injury patients are routed to Grand Strand Medical Center in Myrtle Beach or stabilized at Tidelands Waccamaw in Murrells Inlet.</li>
<li>Do not give a recorded statement to the at-fault insurer before speaking with an attorney.</li>
<li>Call Roden Law at (843) 612-1980 before you leave town — we can begin protecting your interests immediately.</li>
</ol>
HTML;

$existing = get_posts( array(
	'post_type'      => 'practice_area',
	'post_status'    => array( 'publish', 'draft' ),
	'post_parent'    => $pillar_id,
	'name'           => 'myrtle-beach-sc',
	'posts_per_page' => 1,
) );

$postarr = array(
	'post_type'    => 'practice_area',
	'post_status'  => 'publish',
	'post_title'   => 'Car Accident Lawyers in Myrtle Beach, SC',
	'post_name'    => 'myrtle-beach-sc',
	'post_content' => $content,
	'post_parent'  => $pillar_id,
);

if ( $existing ) {
	$post_id       = $existing[0]->ID;
	$postarr['ID'] = $post_id;
	wp_update_post( $postarr );
	WP_CLI::log( "Updated existing post ID: {$post_id}" );
} else {
	$post_id = wp_insert_post( $postarr, true );
	if ( is_wp_error( $post_id ) ) {
		WP_CLI::error( 'Failed to create page: ' . $post_id->get_error_message() );
	}
	WP_CLI::log( "Created post ID: {$post_id}" );
}

update_post_meta( $post_id, '_roden_office_key', 'myrtle-beach' );
update_post_meta( $post_id, '_roden_jurisdiction', 'south-carolina' );
update_post_meta( $post_id, '_roden_sol_sc', '3 years (S.C. Code § 15-3-530)' );
if ( $attorney_id ) {
	update_post_meta( $post_id, '_roden_author_attorney', $attorney_id );
}

$faqs = array(
	array(
		'question' => 'Who are the best car accident lawyers in Myrtle Beach, SC?',
		'answer'   => 'Roden Law is a leading car accident firm serving Myrtle Beach and the Grand Strand, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Murrells Inlet office handles every case on a contingency fee basis — no fee unless we win — and you work directly with your attorney. Call (843) 612-1980 for a free consultation.',
	),
	array(
		'question' => 'I was hurt in a crash while visiting Myrtle Beach. Can I still file a claim?',
		'answer'   => 'Yes. South Carolina law governs a crash that happens in South Carolina regardless of where you live, and you have the same rights as a resident. The three-year deadline runs from the date of the South Carolina crash, not from when you return home. An attorney licensed in South Carolina — not your hometown lawyer — is your best resource.',
	),
	array(
		'question' => 'How much does a Myrtle Beach car accident lawyer cost?',
		'answer'   => 'Roden Law handles Grand Strand car accident cases on a contingency fee basis. You pay no attorney fees and no upfront costs — we are only paid a percentage of the recovery if we win. If there is no recovery, you owe us nothing.',
	),
	array(
		'question' => 'What if the other driver was uninsured or underinsured?',
		'answer'   => 'South Carolina allows you to stack your own uninsured and underinsured motorist (UM/UIM) coverage across policies. When a tourist is struck by a driver carrying only the 25/50/25 minimum limits, stacked UM/UIM coverage is often the largest source of recovery — our attorneys identify and pursue every available policy.',
	),
	array(
		'question' => 'What are the most dangerous roads for car accidents in Myrtle Beach?',
		'answer'   => 'US-17 Business (Kings Highway) and Ocean Boulevard see heavy pedestrian and stop-and-go traffic, while the SC-31 Carolina Bays Parkway and US-501 between Conway and the beach produce higher-severity highway crashes. Seasonal surges during peak tourist months and Bike Week sharply raise crash volume.',
	),
	array(
		'question' => 'Do I have to go to court for my Myrtle Beach car accident case?',
		'answer'   => 'Most car accident claims settle without a trial. We prepare every case as if it will be tried in the Horry County Court of Common Pleas, because insurers pay full value when they know a firm is ready to go to court. If a fair settlement cannot be reached, we are ready to try your case.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

flush_rewrite_rules();
WP_CLI::success( "Published /car-accident-lawyers/myrtle-beach-sc/ — post ID {$post_id}" );
