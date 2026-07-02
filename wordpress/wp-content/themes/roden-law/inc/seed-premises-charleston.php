<?php
/**
 * Seeder: premises-liability-lawyers × Charleston, SC intersection page (ENRICH)
 *
 * UPDATES the existing templated stub /premises-liability-lawyers/charleston-sc/
 * page in place with rich, practice-specific, hyperlocal body content + FAQPage meta
 * + attorney attribution. Part of P2 row-9 BATCH 2 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, jurisdiction-aware pillar
 * intro, attorneys, case results, and the FAQ accordion. post_content here ADDS what
 * the template lacks: answer-first intro, "why Roden Law", local hazards/venues, and
 * premises-specific SC nuances (entrant status, notice, negligent security, Tort Claims Act).
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-premises-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching premises-liability-lawyers × Charleston, SC...' );

$pillar = get_page_by_path( 'premises-liability-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "premises-liability-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people injured on unsafe property in Charleston, South Carolina and throughout the Lowcountry</strong> — Mount Pleasant, Summerville, Goose Creek, and West Ashley. Premises liability is far broader than a slip-and-fall: it covers negligent security and assaults, poorly maintained stairwells and parking garages, pool and apartment hazards, and more. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18437908999">(843) 790-8999</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Charleston Premises Liability Claim</h2>
<p>Property owners and their insurers fight these cases hard, usually by arguing they had no notice of the hazard or that you were careless. What separates Roden Law is direct attorney involvement — you work with your attorney, not a rotating desk of case managers — and the investigation needed to prove the owner knew or should have known about the danger. Our office at 127 King Street sits on the peninsula minutes from the Charleston County Circuit Court.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to start your claim.</li>
<li><strong>We prove notice</strong> — maintenance records, prior-incident reports, and security history that show the owner should have acted.</li>
<li><strong>Full range of premises claims</strong> — slip-and-falls, negligent security, stairwell and garage hazards, and pool injuries.</li>
</ul>

<h2>Charleston Premises Hazards We Handle</h2>
<p>Charleston's dense mix of tourism, hospitality, and historic properties creates recurring dangers our attorneys see across the Lowcountry:</p>
<ul>
<li><strong>Hotel, restaurant, and King Street retail falls</strong> from wet floors, uneven historic walkways, and poor lighting.</li>
<li><strong>Negligent security</strong> — assaults in hotels, bars, parking garages, and apartment complexes where the owner ignored known risks.</li>
<li><strong>Parking-garage and stairwell injuries</strong> from broken railings, poor lighting, and unrepaired surfaces.</li>
<li><strong>Pool and short-term-rental hazards</strong> at resorts and vacation properties.</li>
<li><strong>Store and grocery falls</strong> from spills and merchandise left in aisles.</li>
</ul>

<h2>South Carolina Premises Liability Law You Should Know</h2>
<p>Two questions decide most South Carolina premises cases. The first is your <strong>status on the property</strong>: an invitee (such as a customer) is owed ordinary care, while a licensee and a trespasser are owed less — the framework comes from <em>Sims v. Giles</em>. The second is <strong>notice</strong>: you generally must show the owner knew, or should have known, about the hazard and failed to fix it. For <strong>negligent security</strong> claims, South Carolina applies the balancing test from <em>Bass v. Gopal</em> to decide whether a crime was foreseeable. One critical wrinkle: if the property owner is a <strong>government entity</strong> — a city, county, SCDOT, or public housing — the South Carolina Tort Claims Act caps damages ($300,000 per person / $600,000 per occurrence) and bars punitive damages. Against a private owner there is <strong>no cap on compensatory damages</strong>, the injury statute of limitations is <strong>three years (S.C. Code § 15-3-530)</strong>, and the <strong>51% comparative-fault</strong> rule applies. Learn more from our <a href="/practice-areas/premises-liability-lawyers/">premises liability overview</a>, our <a href="/resources/south-carolina-premises-liability-settlement-value/">SC premises liability settlement value</a> guide, and our <a href="/resources/south-carolina-slip-and-fall-settlement-value/">SC slip-and-fall settlement value</a> guide.</p>
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
	'post_title'   => 'Premises Liability Lawyers in Charleston, SC',
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
		'question' => 'Who are the best premises liability lawyers in Charleston, SC?',
		'answer'   => 'Roden Law is a leading premises liability firm serving Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Charleston office at 127 King Street handles every case on a contingency fee basis — no fee unless we win. Call (843) 790-8999 for a free consultation.',
	),
	array(
		'question' => 'What counts as premises liability besides a slip-and-fall?',
		'answer'   => 'Premises liability covers any injury caused by an unsafe condition on someone\'s property — negligent security and assaults, broken stairwells and railings, poorly lit or maintained parking garages, pool hazards, and apartment-complex dangers, in addition to slip-and-falls.',
	),
	array(
		'question' => 'Do I have to prove the property owner knew about the hazard?',
		'answer'   => 'Usually yes. In South Carolina you generally must show the owner knew, or should have known, about the dangerous condition and failed to fix it or warn you. Your legal status on the property — invitee, licensee, or trespasser — also affects the duty of care owed to you under Sims v. Giles.',
	),
	array(
		'question' => 'What is a negligent security claim?',
		'answer'   => 'A negligent security claim arises when a property owner — a hotel, bar, apartment complex, or parking operator — fails to take reasonable measures against foreseeable crime and a guest or tenant is assaulted as a result. South Carolina courts use the balancing test from Bass v. Gopal to decide whether the crime was foreseeable.',
	),
	array(
		'question' => 'How long do I have to file a Charleston premises liability claim?',
		'answer'   => 'The general deadline is three years from the date of injury under S.C. Code § 15-3-530. If the property owner is a government entity, shorter notice requirements and the South Carolina Tort Claims Act damage caps may apply, so it is important to speak with an attorney quickly.',
	),
	array(
		'question' => 'How much does a Charleston premises liability lawyer cost?',
		'answer'   => 'Roden Law handles Charleston premises liability cases on a contingency fee basis. You pay no attorney fees and no upfront costs — we are only paid a percentage of the recovery if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /premises-liability-lawyers/charleston-sc/ — post ID {$post_id}" );
