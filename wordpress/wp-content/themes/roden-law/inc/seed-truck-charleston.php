<?php
/**
 * Seeder: truck-accident-lawyers × Charleston, SC intersection page (ENRICH)
 *
 * UPDATES the existing (thin templated stub) /truck-accident-lawyers/charleston-sc/
 * page in place with rich, practice-specific, hyperlocal body content + FAQPage meta
 * + attorney attribution. Part of P2 row-9 BATCH 2 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, jurisdiction-aware pillar
 * intro, attorneys, case results, and the FAQ accordion. post_content here ADDS what
 * the template lacks: answer-first intro, "why Roden Law", local truck-crash drivers,
 * and truck-specific SC nuances (evidence-preservation, multiple liable parties).
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-truck-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching truck-accident-lawyers × Charleston, SC...' );

$pillar = get_page_by_path( 'truck-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "truck-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people injured in truck and 18-wheeler crashes in Charleston, South Carolina and throughout the Lowcountry</strong> — Mount Pleasant, Summerville, Goose Creek, and West Ashley. Truck cases are not big car-accident cases: they are governed by federal FMCSA safety rules and often involve <strong>several liable parties</strong>. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18437908999">(843) 790-8999</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Charleston Truck Accident Claim</h2>
<p>Charleston is one of the busiest container-freight markets on the East Coast, and the port drives an enormous volume of heavy commercial-truck traffic through the Lowcountry. That volume is exactly why trucking companies and their insurers move fast to control the evidence after a crash. What separates Roden Law is direct attorney involvement — you work with your attorney, not a rotating desk of case managers — and an early, aggressive push to preserve the electronic and paper trail before it disappears. Our office at 127 King Street sits on the peninsula minutes from the Charleston County Circuit Court.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to start your claim.</li>
<li><strong>Early evidence preservation</strong> — we send a legal-hold letter before the carrier can lawfully purge logs and black-box data.</li>
<li><strong>We find every defendant</strong> — driver, motor carrier, broker, shipper, and maintenance contractor are all potential sources of recovery.</li>
</ul>

<h2>Why Charleston Truck Crashes Happen</h2>
<p>Port and interstate traffic put fully loaded rigs on roads that were not built for them, and the resulting crashes our Charleston attorneys handle most often involve:</p>
<ul>
<li><strong>Container and port-terminal truck traffic</strong> feeding the Wando Welch and North Charleston terminals onto I-526 and I-26.</li>
<li><strong>Interstate merging and rear-end collisions</strong> on I-26, I-526, and the Ravenel Bridge approaches.</li>
<li><strong>Downtown peninsula conflicts</strong> where delivery trucks share tight King Street and Meeting Street corridors with cars and pedestrians.</li>
<li><strong>Fatigue and hours-of-service violations</strong> on long port-to-warehouse hauls.</li>
<li><strong>Overloaded or poorly maintained trailers</strong> that jackknife or shed cargo.</li>
</ul>

<h2>Truck-Accident Evidence Disappears — Fast</h2>
<p>The single most important step after a Lowcountry truck crash is preserving the trucking company's records before they are legally destroyed. Under federal FMCSA rules, carriers keep <strong>hours-of-service logs for only six months</strong>, <strong>driver vehicle inspection reports for about three months</strong>, and the ECM "black box" data on the truck has <strong>no required retention period at all</strong> — it can be overwritten or lost the moment the truck is repaired or returned to service. Roden Law sends a <strong>preservation (legal-hold) letter</strong> immediately so this evidence is not gone before your claim is even filed. South Carolina does not allow a separate lawsuit for destroyed evidence, but if a carrier destroys records it was told to keep, a court can instruct the jury to assume that evidence would have been unfavorable to the trucking company.</p>

<h2>South Carolina Truck-Accident Law You Should Know</h2>
<p>South Carolina gives you <strong>three years to file an injury claim (S.C. Code § 15-3-530)</strong>, and its <strong>51% modified comparative-fault</strong> rule lets you recover as long as you are not more than half at fault, with your award reduced by your share. There is <strong>no cap on compensatory damages</strong> against a private trucking company. When the driver was a smaller company or under-insured, South Carolina also lets you <strong>stack your own uninsured/underinsured motorist coverage</strong> — often a decisive source of recovery in a catastrophic-injury truck case. Learn more from our <a href="/south-carolina-truck-accident-lawyers/">South Carolina truck accident lawyers</a> overview, our guide to <a href="/truck-accident-lawyers/18-wheeler-semi-truck-accident/">18-wheeler and semi-truck accidents</a>, and our explainer on <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a>.</p>
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
	'post_title'   => 'Truck Accident Lawyers in Charleston, SC',
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

update_post_meta( $post_id, '_roden_pa_office_key', 'charleston' );
update_post_meta( $post_id, '_roden_office_key', 'charleston' );
update_post_meta( $post_id, '_roden_jurisdiction', 'south-carolina' );
if ( $attorney_id ) {
	update_post_meta( $post_id, '_roden_author_attorney', $attorney_id );
}

$faqs = array(
	array(
		'question' => 'Who are the best truck accident lawyers in Charleston, SC?',
		'answer'   => 'Roden Law is a leading truck accident firm serving Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Charleston office at 127 King Street handles every case on a contingency fee basis — no fee unless we win — and you work directly with your attorney. Call (843) 790-8999 for a free consultation.',
	),
	array(
		'question' => 'Why do I need a special lawyer for a truck accident instead of a car accident?',
		'answer'   => 'Truck crashes are governed by federal FMCSA safety regulations and usually involve multiple potential defendants — the driver, the motor carrier, the freight broker, the shipper, and maintenance contractors. Sorting out who is liable, and preserving the trucking company\'s records before they are destroyed, takes experience that a routine car-accident claim does not.',
	),
	array(
		'question' => 'How long do I have to file a Charleston truck accident claim?',
		'answer'   => 'South Carolina generally gives you three years from the date of the crash under S.C. Code § 15-3-530. But you should not wait — critical trucking records can be legally destroyed within months, so an attorney needs to act quickly to preserve them.',
	),
	array(
		'question' => 'What evidence disappears after a truck accident?',
		'answer'   => 'Under federal rules, carriers keep hours-of-service logs for only about six months and driver vehicle inspection reports for about three months, and the on-board ECM "black box" data has no required retention period at all. That is why Roden Law sends a preservation letter immediately to stop the trucking company from purging this evidence.',
	),
	array(
		'question' => 'Who can be held liable in a Charleston truck accident?',
		'answer'   => 'Liability often extends beyond the driver to the motor carrier, the broker who arranged the load, the shipper, and any company responsible for maintaining the truck. Charleston\'s heavy port and container-truck traffic frequently involves large national carriers with substantial insurance, which is why identifying every responsible party matters.',
	),
	array(
		'question' => 'How much does a Charleston truck accident lawyer cost?',
		'answer'   => 'Roden Law handles Charleston truck accident cases on a contingency fee basis. You pay no attorney fees and no upfront costs — we are only paid a percentage of the recovery if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /truck-accident-lawyers/charleston-sc/ — post ID {$post_id}" );
