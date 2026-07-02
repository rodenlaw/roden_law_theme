<?php
/**
 * Seeder: slip-and-fall-lawyers × Columbia, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub at /slip-and-fall-lawyers/columbia-sc/
 * in place with rich, practice-specific, hyperlocal body content + FAQPage meta +
 * attorney attribution. Part of P2 row-9 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do"
 * steps, negligence/elements, compensation block, Key Takeaways, attorneys, case
 * results, and FAQ accordion. post_content ADDS what the template lacks: answer-
 * first intro, "why Roden Law", local venues/hazards, and premises-liability SC
 * nuances (the notice element + government-defendant Tort Claims Act caps).
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-slip-columbia.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching slip-and-fall-lawyers × Columbia, SC...' );

$pillar = get_page_by_path( 'slip-and-fall-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "slip-and-fall-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people hurt in slip, trip, and fall accidents across Columbia and the Midlands</strong> — Lexington, Irmo, West Columbia, Cayce, Forest Acres, and Blythewood. A slip-and-fall is a <strong>premises liability</strong> claim, and the central question is <strong>notice</strong>: whether the property owner knew, or should have known, about the hazard and failed to fix or warn of it. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Columbia Slip-and-Fall Claim</h2>
<p>Slip-and-fall cases are won or lost on evidence that disappears fast — surveillance video that overwrites in days, incident reports the property never volunteers, and cleaning logs that show whether a hazard was ignored. What separates Roden Law is direct attorney involvement — you work with your attorney, not a rotating desk of case managers — and we move immediately to preserve that proof. Our office at 1545 Sumter Street, Suite B is minutes from the Richland County Court of Common Pleas.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to start your claim.</li>
<li><strong>We move fast on evidence</strong> — preservation letters go out immediately to stop video and logs from being erased.</li>
<li><strong>We prove notice</strong> — the hardest part of a premises case, and the part insurers fight hardest.</li>
</ul>

<h2>Where Columbia Slip-and-Fall Injuries Happen</h2>
<p>The Midlands falls our attorneys handle most often occur at:</p>
<ul>
<li><strong>Retail stores and grocery chains</strong> along Two Notch Road, Garners Ferry Road, and Harbison — spills, freshly mopped floors without warning signs, and produce-aisle hazards.</li>
<li><strong>Parking lots and garages</strong> downtown and around Five Points and the Vista — potholes, unmarked curbs, and poor lighting.</li>
<li><strong>Apartment complexes and rental housing</strong> near USC and across the Midlands — broken stair treads, loose railings, and unlit walkways.</li>
<li><strong>Restaurants and bars</strong> in Five Points and the Vista — wet entryways and cluttered floors, especially on busy weekends.</li>
</ul>

<h2>South Carolina Premises Liability Law: What Columbia Victims Should Know</h2>
<h3>The Owner Must Have Had "Notice" of the Hazard</h3>
<p>To recover, you generally must show the property owner <strong>knew or should have known</strong> about the dangerous condition and failed to fix it or warn you. Proving how long a spill sat on the floor or how long a railing had been broken is the heart of a South Carolina premises case — and why fast evidence preservation matters.</p>
<h3>3-Year Deadline and the 51% Bar</h3>
<p>The statute of limitations is <strong>three years under S.C. Code § 15-3-530</strong>, and South Carolina's <strong>51% modified comparative fault</strong> rule lets you recover as long as you are not more than 50% responsible. South Carolina places <strong>no cap on compensatory damages</strong> in a standard premises case.</p>
<h3>If a Government Property Is Involved, Different Rules Apply</h3>
<p>If you fell on property owned by a city, county, SCDOT, a public university, or public housing, your claim falls under the <strong>South Carolina Tort Claims Act</strong>, which caps damages (generally $300,000 per person / $600,000 per occurrence), bars punitive damages, and imposes shorter notice requirements. Identifying a government defendant early is critical — call us before those deadlines run.</p>

<h2>Learn More About South Carolina Premises Claims</h2>
<ul>
<li><a href="/practice-areas/premises-liability-lawyers/">Premises liability lawyers — practice overview</a></li>
<li><a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence explained</a></li>
</ul>
HTML;

$existing = get_posts( array(
	'post_type'      => 'practice_area',
	'post_status'    => array( 'publish', 'draft' ),
	'post_parent'    => $pillar_id,
	'name'           => 'columbia-sc',
	'posts_per_page' => 1,
) );

$postarr = array(
	'post_type'    => 'practice_area',
	'post_status'  => 'publish',
	'post_title'   => 'Slip and Fall Lawyers in Columbia, SC',
	'post_name'    => 'columbia-sc',
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

update_post_meta( $post_id, '_roden_pa_office_key', 'columbia' );
update_post_meta( $post_id, '_roden_office_key', 'columbia' );
update_post_meta( $post_id, '_roden_jurisdiction', 'south-carolina' );
if ( $attorney_id ) {
	update_post_meta( $post_id, '_roden_author_attorney', $attorney_id );
}

$faqs = array(
	array(
		'question' => 'Who are the best slip-and-fall lawyers in Columbia, SC?',
		'answer'   => 'Roden Law is a leading premises liability firm serving Columbia and the Midlands, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles every case on a contingency fee basis — no fee unless we win — and you work directly with your attorney. Call (803) 219-2816 for a free consultation.',
	),
	array(
		'question' => 'How long do I have to file a slip-and-fall claim in South Carolina?',
		'answer'   => 'You generally have three years from the date of the fall under S.C. Code § 15-3-530. But if you fell on government property (a city, county, SCDOT, or public university), the South Carolina Tort Claims Act imposes shorter notice deadlines, so it is important to talk to an attorney quickly.',
	),
	array(
		'question' => 'What do I have to prove to win a slip-and-fall case in Columbia?',
		'answer'   => 'You generally must show the property owner knew or should have known about the dangerous condition — the "notice" element — and failed to fix it or warn you, and that this caused your injury. Evidence like surveillance video, incident reports, and cleaning logs is critical, and it disappears quickly, so acting fast matters.',
	),
	array(
		'question' => 'Can I still recover if I was partly at fault for my fall?',
		'answer'   => 'Yes, as long as you were not more than 50% at fault. South Carolina uses 51% modified comparative fault, so your recovery is reduced by your share of fault but not eliminated unless your fault reaches 51%. Insurers often exaggerate your blame — we push back on that.',
	),
	array(
		'question' => 'I fell at a store or apartment in Columbia. Who is responsible?',
		'answer'   => 'It depends on who controlled the property and the hazard — a store operator, a landlord, a property management company, or a maintenance contractor can all be responsible. Roden Law identifies every liable party and every applicable insurance policy so nothing is left on the table.',
	),
	array(
		'question' => 'Is there a limit on how much I can recover in a South Carolina slip-and-fall case?',
		'answer'   => 'In a standard premises case against a private business or landlord, South Carolina places no cap on compensatory damages. If the property owner is a government entity, the Tort Claims Act caps damages (generally $300,000 per person / $600,000 per occurrence) and bars punitive damages.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /slip-and-fall-lawyers/columbia-sc/ — post ID {$post_id}" );
