<?php
/**
 * Seeder: slip-and-fall-lawyers × Myrtle Beach, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub at /slip-and-fall-lawyers/
 * myrtle-beach-sc/ in place with rich, practice-specific, hyperlocal body content
 * + FAQPage meta + attorney attribution. Part of P2 row-9 enrichment (2026-06).
 * Office is physically in Murrells Inlet but markets the Grand Strand.
 *
 * The intersection template auto-generates the SC state-law box, "what to do"
 * steps, negligence/elements, compensation block, Key Takeaways, attorneys, case
 * results, and FAQ accordion. post_content ADDS what the template lacks: answer-
 * first intro, "why Roden Law", local venues/hazards (resort hotels, pools, water
 * parks), and premises SC nuances (notice + Tort Claims Act caps).
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-slip-myrtle-beach.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching slip-and-fall-lawyers × Myrtle Beach, SC...' );

$pillar = get_page_by_path( 'slip-and-fall-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "slip-and-fall-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people hurt in slip, trip, and fall accidents across the Grand Strand</strong> — Myrtle Beach, North Myrtle Beach, Murrells Inlet, Surfside Beach, Conway, and Pawleys Island. A slip-and-fall is a <strong>premises liability</strong> claim, and the central question is <strong>notice</strong>: whether the property owner knew, or should have known, about the hazard and failed to fix or warn of it. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Our office is in Murrells Inlet, just off US-17. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Grand Strand Slip-and-Fall Claim</h2>
<p>The Grand Strand's resorts, hotels, and water parks host millions of visitors a year, and their operators — often national hospitality chains — carry aggressive insurers who deny notice and blame the guest, betting the visitor will go home and drop the claim. Slip-and-fall cases turn on evidence that vanishes fast: surveillance video that overwrites in days, incident reports the property never volunteers, and maintenance logs. What separates Roden Law is direct attorney involvement — you work with your attorney, not a rotating desk of case managers — and we move immediately to preserve that proof, whether you live here or were visiting.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to start your claim.</li>
<li><strong>We move fast on evidence</strong> — preservation letters go out immediately to stop video and logs from being erased.</li>
<li><strong>We handle visitor claims start to finish</strong> — you do not have to return to South Carolina for us to build your case.</li>
</ul>

<h2>Where Grand Strand Slip-and-Fall Injuries Happen</h2>
<p>The Grand Strand falls our attorneys handle most often occur at:</p>
<ul>
<li><strong>Resort hotels and condos</strong> along Kings Highway and Ocean Boulevard — wet lobby floors, slick pool decks, and poorly lit stairwells and balconies.</li>
<li><strong>Water parks and amusement venues</strong> — slippery walkways and inadequately maintained wet surfaces.</li>
<li><strong>Restaurants and beachfront retail</strong> — wet entryways, spills, and cluttered floors, especially during peak season.</li>
<li><strong>Parking lots, garages, and boardwalks</strong> — potholes, unmarked curbs, warped boards, and poor lighting.</li>
</ul>

<h2>South Carolina Premises Liability Law: What Grand Strand Victims Should Know</h2>
<h3>The Owner Must Have Had "Notice" of the Hazard</h3>
<p>To recover, you generally must show the property owner <strong>knew or should have known</strong> about the dangerous condition and failed to fix it or warn you. Proving how long a pool deck was slick or how long a spill sat is the heart of a South Carolina premises case — and why fast evidence preservation matters, especially before you leave town.</p>
<h3>3-Year Deadline and the 51% Bar</h3>
<p>The statute of limitations is <strong>three years under S.C. Code § 15-3-530</strong>, and it runs from the date of the South Carolina fall even if you live out of state. South Carolina's <strong>51% modified comparative fault</strong> rule lets you recover as long as you are not more than 50% responsible, and there is <strong>no cap on compensatory damages</strong> in a standard premises case.</p>
<h3>If a Government Property Is Involved, Different Rules Apply</h3>
<p>If you fell on property owned by a city, Horry or Georgetown County, SCDOT, or public housing, your claim falls under the <strong>South Carolina Tort Claims Act</strong>, which caps damages (generally $300,000 per person / $600,000 per occurrence), bars punitive damages, and imposes shorter notice requirements. Identifying a government defendant early is critical.</p>

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
	'name'           => 'myrtle-beach-sc',
	'posts_per_page' => 1,
) );

$postarr = array(
	'post_type'    => 'practice_area',
	'post_status'  => 'publish',
	'post_title'   => 'Slip and Fall Lawyers in Myrtle Beach, SC',
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

update_post_meta( $post_id, '_roden_pa_office_key', 'myrtle-beach' );
update_post_meta( $post_id, '_roden_office_key', 'myrtle-beach' );
update_post_meta( $post_id, '_roden_jurisdiction', 'south-carolina' );
if ( $attorney_id ) {
	update_post_meta( $post_id, '_roden_author_attorney', $attorney_id );
}

$faqs = array(
	array(
		'question' => 'Who are the best slip-and-fall lawyers in Myrtle Beach, SC?',
		'answer'   => 'Roden Law is a leading premises liability firm serving Myrtle Beach and the Grand Strand, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Murrells Inlet office handles every case on a contingency fee basis — no fee unless we win — and you work directly with your attorney. Call (843) 612-1980 for a free consultation.',
	),
	array(
		'question' => 'I slipped at a Myrtle Beach hotel or resort while on vacation. Can I still file a claim?',
		'answer'   => 'Yes. South Carolina law governs a fall that happens in South Carolina regardless of where you live, and the three-year deadline runs from the date of the fall. You do not have to return to South Carolina for us to build your case — a South Carolina attorney, not your hometown lawyer, is your best resource. Call (843) 612-1980 for a free review.',
	),
	array(
		'question' => 'How long do I have to file a slip-and-fall claim in South Carolina?',
		'answer'   => 'You generally have three years from the date of the fall under S.C. Code § 15-3-530. If you fell on government property (a city, Horry or Georgetown County, or SCDOT), the Tort Claims Act imposes shorter notice deadlines, so talk to an attorney quickly.',
	),
	array(
		'question' => 'What do I have to prove to win a slip-and-fall case on the Grand Strand?',
		'answer'   => 'You generally must show the property owner knew or should have known about the dangerous condition — the "notice" element — and failed to fix it or warn you, and that this caused your injury. Surveillance video, incident reports, and maintenance logs are critical and disappear quickly, so acting fast (ideally before you leave town) matters.',
	),
	array(
		'question' => 'Can I still recover if I was partly at fault for my fall?',
		'answer'   => 'Yes, as long as you were not more than 50% at fault. South Carolina uses 51% modified comparative fault, so your recovery is reduced by your share of fault but not eliminated unless your fault reaches 51%.',
	),
	array(
		'question' => 'Is there a limit on how much I can recover in a South Carolina slip-and-fall case?',
		'answer'   => 'In a standard premises case against a private hotel, resort, or business, South Carolina places no cap on compensatory damages. If the property owner is a government entity, the Tort Claims Act caps damages (generally $300,000 per person / $600,000 per occurrence) and bars punitive damages.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /slip-and-fall-lawyers/myrtle-beach-sc/ — post ID {$post_id}" );
