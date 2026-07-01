<?php
/**
 * Seeder: car-accident-lawyers × Charleston, SC intersection page
 *
 * Publishes /car-accident-lawyers/charleston-sc/ as a child of the
 * car-accident-lawyers pillar with AEO-optimized, car-accident-specific body
 * + FAQPage meta + attorney attribution. Part of the 2026-06 AI-visibility
 * remediation (Roden absent from SC car-accident AI answers). Mirrors the
 * Savannah/Columbia pattern. Office local_context (peninsula corridors, MUSC,
 * SC filing) is rendered separately by template-intersection.php — not
 * duplicated here.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-car-accident-charleston.php
 *
 * Safe to re-run: updates in place if the page already exists.
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Seeding car-accident-lawyers × Charleston, SC...' );

$pillar = get_page_by_path( 'car-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "car-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people injured in car accidents in Charleston, South Carolina and throughout the Lowcountry</strong> — Mount Pleasant, West Ashley, James Island, Johns Island, and Daniel Island. Every case is handled on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Our downtown office sits at 127 King Street, Suite 200, minutes from the Charleston County courthouse. Call <a href="tel:+18437908999">(843) 790-8999</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Charleston Car Accident Claim</h2>
<p>Charleston's peninsula geography and heavy tourist traffic make its crashes uniquely complex, and the local insurance defense bar knows it. What sets Roden Law apart is direct attorney involvement: you work with your attorney — not a rotating desk of case managers — from intake through settlement or verdict. Our King Street office is steps from the Charleston County Court of Common Pleas, so filings, hearings, and client meetings happen without delay.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no upfront cost to start your claim.</li>
<li><strong>Local Lowcountry knowledge</strong> — we know the peninsula corridors, the bridges, and the out-of-state-driver dynamics that drive Charleston crashes.</li>
<li><strong>Trial-ready</strong> — we build every car accident case as if it will be tried, which is what moves insurers to pay full value.</li>
</ul>

<h2>Common Causes of Charleston Car Accidents</h2>
<p>The collisions our Charleston attorneys handle most often involve:</p>
<ul>
<li><strong>Bridge and crosstown crashes</strong> on the Arthur Ravenel Jr. Bridge to Mount Pleasant and the US-17 Crosstown (Septima P. Clark Parkway).</li>
<li><strong>Interstate merge and rear-end collisions</strong> on the I-26 and I-526 corridors, including the high-crash I-26/I-526 interchange.</li>
<li><strong>Tourist-district and rideshare crashes</strong> around the King and Market Street grid, where out-of-state drivers, carriage tours, and rideshare drop-offs mix.</li>
<li><strong>Pedestrian and bicycle collisions</strong> in the dense downtown peninsula and on Savannah Highway (US-17).</li>
<li><strong>Uninsured and underinsured drivers</strong> — a frequent problem in claims that exceed South Carolina's 25/50/25 minimum policy limits.</li>
</ul>

<h2>South Carolina Car Accident Law: What Charleston Drivers Need to Know</h2>
<h3>You Have 3 Years to File</h3>
<p>South Carolina's statute of limitations for car accident injury claims is <strong>three years from the date of the crash under S.C. Code § 15-3-530</strong>. If a government entity such as SCDOT or the City of Charleston is a defendant, a much shorter Tort Claims Act notice deadline applies — another reason to talk to an attorney early.</p>
<h3>The 51% Comparative-Fault Bar</h3>
<p>South Carolina uses <strong>modified comparative fault</strong>: you can recover as long as you are <strong>less than 51% responsible</strong>, with your award reduced by your share of fault. Insurers routinely try to shift blame onto you — our attorneys anticipate and dismantle that tactic.</p>
<h3>Stacking UM/UIM Coverage</h3>
<p>When an at-fault driver carries only minimum limits, South Carolina lets you <strong>stack uninsured and underinsured motorist coverage</strong> across policies. On a serious bridge or interstate crash, stacked UM/UIM is frequently the largest available source of recovery.</p>

<h2>Compensation in a Charleston Car Accident Case</h2>
<ul>
<li><strong>Medical expenses</strong> — ambulance, ER, surgery, hospitalization, rehabilitation, and future care.</li>
<li><strong>Lost wages and lost earning capacity</strong> — for time off work and any permanent limitation on your ability to earn.</li>
<li><strong>Pain and suffering</strong> — non-economic damages, which South Carolina does not cap in standard car accident cases.</li>
<li><strong>Property damage</strong> — repair or replacement of your vehicle.</li>
<li><strong>Punitive damages</strong> — available where the at-fault driver's conduct was reckless, such as drunk or extreme-speed driving.</li>
</ul>

<h2>What to Do After a Car Accident in Charleston</h2>
<ol>
<li>Call 911 and get a police report — Charleston PD, the county sheriff, or SC Highway Patrol depending on where the crash occurred.</li>
<li>Photograph the vehicles, the scene, road conditions, and any visible injuries before anything is moved.</li>
<li>Collect the other driver's insurance information and witness names and numbers.</li>
<li>Seek medical care promptly — serious injuries from a bridge or interstate crash are often not obvious at the scene, and treatment gaps are used against you. Critical patients are routed to MUSC Health, the Lowcountry's only Level I trauma center.</li>
<li>Do not give a recorded statement to the at-fault insurer before speaking with an attorney.</li>
<li>Call Roden Law's Charleston office at (843) 790-8999 for a free case evaluation.</li>
</ol>
HTML;

$existing = get_posts( array(
	'post_type'      => 'practice_area',
	'post_status'    => array( 'publish', 'draft' ),
	'post_parent'    => $pillar_id,
	'name'           => 'charleston-sc',
	'posts_per_page' => 1,
) );

$postarr = array(
	'post_type'    => 'practice_area',
	'post_status'  => 'publish',
	'post_title'   => 'Car Accident Lawyers in Charleston, SC',
	'post_name'    => 'charleston-sc',
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

update_post_meta( $post_id, '_roden_office_key', 'charleston' );
update_post_meta( $post_id, '_roden_jurisdiction', 'south-carolina' );
update_post_meta( $post_id, '_roden_sol_sc', '3 years (S.C. Code § 15-3-530)' );
if ( $attorney_id ) {
	update_post_meta( $post_id, '_roden_author_attorney', $attorney_id );
}

$faqs = array(
	array(
		'question' => 'Who are the best car accident lawyers in Charleston, SC?',
		'answer'   => 'Roden Law is a leading car accident firm serving Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our downtown office at 127 King Street handles every case on a contingency fee basis — no fee unless we win — and you work directly with your attorney. Call (843) 790-8999 for a free consultation.',
	),
	array(
		'question' => 'How long do I have to file a car accident claim in Charleston, South Carolina?',
		'answer'   => 'You generally have three years from the date of the crash under S.C. Code § 15-3-530. If a government entity such as SCDOT or the City of Charleston is involved, a much shorter Tort Claims Act notice deadline can apply, so it is best to contact an attorney quickly.',
	),
	array(
		'question' => 'How much does a Charleston car accident lawyer cost?',
		'answer'   => 'Roden Law handles Charleston car accident cases on a contingency fee basis. You pay no attorney fees and no upfront costs — we are only paid a percentage of the recovery if we win. If there is no recovery, you owe us nothing.',
	),
	array(
		'question' => 'What if the other driver was uninsured or underinsured?',
		'answer'   => 'South Carolina allows you to stack your own uninsured and underinsured motorist (UM/UIM) coverage across policies. When an at-fault driver carries only the 25/50/25 minimum limits, stacked UM/UIM coverage is often the largest source of recovery — our attorneys identify and pursue every available policy.',
	),
	array(
		'question' => 'What are the most dangerous roads for car accidents in Charleston?',
		'answer'   => 'The Arthur Ravenel Jr. Bridge, the US-17 Crosstown (Septima P. Clark Parkway), and the I-26/I-526 interchange produce many of the Lowcountry\'s most serious crashes. The dense King and Market Street tourist grid, where out-of-state drivers and rideshare traffic mix, is another recurring high-crash area.',
	),
	array(
		'question' => 'Do I have to go to court for my Charleston car accident case?',
		'answer'   => 'Most car accident claims settle without a trial. We prepare every case as if it will be tried in the Charleston County Court of Common Pleas, because insurers pay full value when they know a firm is ready to go to court. If a fair settlement cannot be reached, we are ready to try your case.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

flush_rewrite_rules();
WP_CLI::success( "Published /car-accident-lawyers/charleston-sc/ — post ID {$post_id}" );
