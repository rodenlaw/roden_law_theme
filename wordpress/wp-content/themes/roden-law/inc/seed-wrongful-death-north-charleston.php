<?php
/**
 * Seeder: wrongful-death-lawyers × North Charleston, SC intersection (ENRICH)
 *
 * UPDATES the existing /wrongful-death-lawyers/north-charleston-sc/ page in place
 * with rich, practice-specific, hyperlocal content + FAQPage meta + attorney
 * attribution. Part of P2 row-9 BATCH 3.
 *
 * Template auto-generates SC state-law box, "what to do" steps, negligence
 * elements, compensation block, Key Takeaways, attorneys, case results, and FAQ
 * accordion. post_content ADDS: answer-first intro, "why Roden Law", local
 * context, and wrongful-death SC nuances — no duplication.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-wrongful-death-north-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching wrongful-death-lawyers × North Charleston, SC...' );

$pillar = get_page_by_path( 'wrongful-death-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "wrongful-death-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents families who have lost a loved one to another's negligence in North Charleston, South Carolina and throughout the Lowcountry</strong> — Hanahan, Goose Creek, Ladson, and Summerville. We handle every wrongful death claim on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients and grieving families across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436126561">(843) 612-6561</a> for a free, confidential and compassionate case review.</p>

<h2>Why Choose Roden Law for a North Charleston Wrongful Death Claim</h2>
<p>Losing a family member to a preventable death is devastating, and the last thing you should have to fight is an insurance company. What separates Roden Law is direct attorney involvement and the resources to fully investigate how and why your loved one died — from crash reconstruction to workplace and hospital records. We serve North Charleston, Boeing, and the surrounding Charleston County communities, and the estate's claim is filed in the Charleston County Circuit Court and handled locally without delay.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue the claim.</li>
<li><strong>We handle the estate paperwork</strong> — we help the personal representative bring the claim so the family can grieve.</li>
<li><strong>Trial-ready</strong> — we prepare every claim for the Charleston County Circuit Court, which is what moves insurers to pay full value.</li>
</ul>

<h2>North Charleston Wrongful Death Cases We Handle</h2>
<p>Fatal-injury claims in and around North Charleston most often arise from:</p>
<ul>
<li><strong>Fatal traffic and truck crashes</strong> on I-26, I-526, and the heavy port and industrial corridors.</li>
<li><strong>Workplace and industrial fatalities</strong>, including manufacturing, distribution, and port incidents.</li>
<li><strong>Pedestrian and bicycle fatalities</strong> on busy commercial corridors.</li>
<li><strong>Medical negligence deaths</strong> at Trident Medical Center and area hospitals.</li>
<li><strong>Premises-related deaths</strong> caused by unsafe property conditions.</li>
</ul>

<h2>South Carolina Wrongful Death Law: What North Charleston Families Need to Know</h2>
<h3>The Personal Representative Brings the Claim</h3>
<p>In South Carolina, a wrongful death action is brought by the estate's <strong>personal representative under S.C. Code § 15-51-20</strong> for the benefit of the statutory beneficiaries, in order: <strong>the spouse and children first, then the parents, then the other heirs</strong>. Recovery includes lost financial support, the loss of the deceased's companionship and society, the survivors' mental anguish and grief, and funeral and burial expenses.</p>
<h3>The Survival Action Is Separate</h3>
<p>A distinct <strong>survival action under S.C. Code § 15-5-90</strong> lets the estate recover for what your loved one personally endured before death — their conscious pain and suffering and their pre-death medical bills. The two claims are usually pursued together.</p>
<h3>Deadline and Damages</h3>
<p>The wrongful death statute of limitations is <strong>three years from the date of death under S.C. Code § 15-3-530</strong>. South Carolina places <strong>no cap</strong> on wrongful death damages in ordinary cases — with two exceptions: a government defendant is limited under the South Carolina Tort Claims Act ($300,000 per person / $600,000 per occurrence), and a death caused by medical malpractice is subject to the § 15-32-220 non-economic cap. <strong>Punitive damages</strong> are available where the conduct was reckless or willful.</p>

<h2>Learn More About South Carolina Wrongful Death Claims</h2>
<ul>
<li><a href="/south-carolina-wrongful-death-lawyer/">South Carolina wrongful death lawyer — statewide overview</a></li>
<li><a href="/resources/south-carolina-wrongful-death-settlement-value/">What is a South Carolina wrongful death settlement worth?</a></li>
<li><a href="/resources/south-carolina-comparative-negligence/">How South Carolina's comparative negligence rule affects your recovery</a></li>
</ul>
HTML;

$existing = get_posts( array(
	'post_type'      => 'practice_area',
	'post_status'    => array( 'publish', 'draft' ),
	'post_parent'    => $pillar_id,
	'name'           => 'north-charleston-sc',
	'posts_per_page' => 1,
) );

$postarr = array(
	'post_type'    => 'practice_area',
	'post_status'  => 'publish',
	'post_title'   => 'Wrongful Death Lawyers in North Charleston, SC',
	'post_name'    => 'north-charleston-sc',
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

update_post_meta( $post_id, '_roden_pa_office_key', 'north-charleston' );
update_post_meta( $post_id, '_roden_office_key', 'north-charleston' );
update_post_meta( $post_id, '_roden_jurisdiction', 'south-carolina' );
if ( $attorney_id ) {
	update_post_meta( $post_id, '_roden_author_attorney', $attorney_id );
}

$faqs = array(
	array(
		'question' => 'Who are the best wrongful death lawyers in North Charleston, SC?',
		'answer'   => 'Roden Law is a leading wrongful death firm serving North Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients and grieving families across Georgia and South Carolina. We handle every case on a contingency fee basis — no fee unless we win. Call (843) 612-6561 for a free, compassionate consultation.',
	),
	array(
		'question' => 'Who can file a wrongful death claim in South Carolina?',
		'answer'   => 'Only the personal representative of the deceased person\'s estate can bring the claim (S.C. Code § 15-51-20). Any recovery is distributed to the statutory beneficiaries in order: the spouse and children first, then the parents, then the other heirs. Roden Law helps families with the estate steps needed to open the claim.',
	),
	array(
		'question' => 'How long do I have to file a wrongful death claim in South Carolina?',
		'answer'   => 'Generally three years from the date of death (S.C. Code § 15-3-530). Claims against a government entity have shorter notice requirements under the South Carolina Tort Claims Act, so it is important to speak with an attorney promptly.',
	),
	array(
		'question' => 'What is the difference between a wrongful death and a survival action?',
		'answer'   => 'A wrongful death claim compensates the surviving family for their losses — lost support, companionship, grief, and funeral costs. A separate survival action (S.C. Code § 15-5-90) compensates the estate for what the deceased personally endured before death, including conscious pain and suffering and pre-death medical bills. The two are usually pursued together.',
	),
	array(
		'question' => 'Is there a cap on wrongful death damages in South Carolina?',
		'answer'   => 'In ordinary cases, no — South Carolina does not cap wrongful death damages. Two exceptions apply: claims against a government defendant are limited under the South Carolina Tort Claims Act ($300,000 per person / $600,000 per occurrence), and a death caused by medical malpractice is subject to the § 15-32-220 non-economic damages cap.',
	),
	array(
		'question' => 'How much does a North Charleston wrongful death lawyer cost?',
		'answer'   => 'Roden Law handles North Charleston wrongful death cases on a contingency fee basis. You pay no attorney fees and no upfront costs — we advance the cost of investigation and are only paid a percentage of the recovery if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /wrongful-death-lawyers/north-charleston-sc/ — post ID {$post_id}" );
