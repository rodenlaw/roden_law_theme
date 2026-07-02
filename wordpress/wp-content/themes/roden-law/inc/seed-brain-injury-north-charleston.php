<?php
/**
 * Seeder: brain-injury-lawyers × North Charleston, SC intersection (ENRICH)
 *
 * UPDATES the existing /brain-injury-lawyers/north-charleston-sc/ page in place
 * with rich, practice-specific, hyperlocal content + FAQPage meta + attorney
 * attribution. Part of P2 row-9 BATCH 3.
 *
 * Template auto-generates SC state-law box, "what to do" steps, negligence
 * elements, compensation block, Key Takeaways, attorneys, case results, and FAQ
 * accordion. post_content ADDS: answer-first intro, "why Roden Law", local
 * context, and TBI-specific SC nuances — no duplication.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-brain-injury-north-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching brain-injury-lawyers × North Charleston, SC...' );

$pillar = get_page_by_path( 'brain-injury-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "brain-injury-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people who have suffered a traumatic brain injury in North Charleston, South Carolina and throughout the Lowcountry</strong> — Hanahan, Goose Creek, Ladson, and Summerville. Brain injuries are often catastrophic and permanent, and we handle every claim on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436126561">(843) 612-6561</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a North Charleston Brain Injury Claim</h2>
<p>A traumatic brain injury (TBI) can permanently change a person's ability to work, think, and care for themselves — and full-value cases require medical experts, life-care planners, and vocational economists, not just a demand letter. What separates Roden Law is direct attorney involvement and the resources to build that proof. We serve North Charleston, Boeing, and the surrounding Charleston County communities, and cases here are filed in the Charleston County Circuit Court — so investigation, records, and filings happen without delay.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to investigate your claim.</li>
<li><strong>Life-care planning</strong> — we quantify future medical care, therapy, and 24/7 attendant needs so nothing is left off the table.</li>
<li><strong>Trial-ready</strong> — we prepare every claim for the Charleston County Circuit Court, which is what moves insurers to pay full value.</li>
</ul>

<h2>How North Charleston Brain Injuries Happen</h2>
<p>The TBI cases our attorneys handle most often in and around North Charleston arise from:</p>
<ul>
<li><strong>Car and truck crashes</strong> on I-26 and I-526 and the heavy port and industrial corridors — the leading cause of serious head trauma.</li>
<li><strong>Workplace and industrial incidents</strong>, including manufacturing, distribution, and port injuries.</li>
<li><strong>Falls</strong> — from heights, on stairs, and on unsafe premises.</li>
<li><strong>Pedestrian and bicycle collisions</strong> on busy commercial corridors.</li>
<li><strong>Medical negligence</strong>, including oxygen-deprivation and surgical injuries.</li>
</ul>

<h2>South Carolina Brain Injury Law: What North Charleston Victims Need to Know</h2>
<h3>Symptoms Can Be Delayed — Document Everything Early</h3>
<p>TBI symptoms — memory loss, confusion, mood and behavioral changes, headaches — often do not appear until hours or days after the injury. Prompt medical evaluation and consistent documentation are critical, both to your health and to proving the injury later.</p>
<h3>Economic Damages Drive the Value — and SC Does Not Cap Them</h3>
<p>In a serious brain injury, the <strong>economic damages — a lifetime of future medical care, lost earning capacity, and around-the-clock care — often dwarf everything else</strong>. South Carolina places <strong>no cap on compensatory damages in ordinary injury cases</strong> (the medical-malpractice cap is the narrow exception), so a properly built life-care plan is frequently the difference between a lowball offer and full compensation.</p>
<h3>The Deadline: 3 Years, and the 51% Fault Bar</h3>
<p>The statute of limitations is <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>. South Carolina's <strong>modified comparative fault</strong> rule lets you recover as long as you are <strong>50% or less at fault</strong>, with your award reduced by your share — insurers often try to shift blame to cut a large TBI payout, and we anticipate that tactic.</p>

<h2>Learn More About South Carolina Injury Law</h2>
<ul>
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
	'post_title'   => 'Brain Injury Lawyers in North Charleston, SC',
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
		'question' => 'Who are the best brain injury lawyers in North Charleston, SC?',
		'answer'   => 'Roden Law is a leading brain injury firm serving North Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every case on a contingency fee basis — no fee unless we win — and work with life-care planners and medical experts. Call (843) 612-6561 for a free consultation.',
	),
	array(
		'question' => 'How long do I have to file a brain injury claim in South Carolina?',
		'answer'   => 'Generally three years from the date of injury (S.C. Code § 15-3-530). Because TBI symptoms and the full extent of the injury may not be apparent right away, it is important to have your case reviewed as soon as possible so evidence is preserved.',
	),
	array(
		'question' => 'Is there a cap on brain injury damages in South Carolina?',
		'answer'   => 'No. In ordinary injury cases, South Carolina does not cap compensatory damages, so there is no ceiling on the future medical care, lost earning capacity, and long-term care a serious brain injury requires. (The narrow exception is the statutory cap that applies only to medical-malpractice non-economic damages.)',
	),
	array(
		'question' => 'What are the symptoms of a traumatic brain injury after a North Charleston accident?',
		'answer'   => 'Symptoms can include headaches, memory loss, confusion, dizziness, sensitivity to light or noise, mood changes, and difficulty concentrating — and they often appear hours or days after the accident, not immediately. Prompt medical evaluation is essential both for your health and for documenting the injury.',
	),
	array(
		'question' => 'How much is a North Charleston brain injury case worth?',
		'answer'   => 'Every case is different, but serious brain injuries are among the highest-value personal injury claims because the economic damages — future medical care, lost earning capacity, and 24/7 care — can be enormous. Roden Law works with life-care planners and economists to document the full lifetime cost of the injury.',
	),
	array(
		'question' => 'How much does a North Charleston brain injury lawyer cost?',
		'answer'   => 'Roden Law handles North Charleston brain injury cases on a contingency fee basis. You pay no attorney fees and no upfront costs — we advance the cost of the experts and life-care planning needed to build your case — and we are only paid a percentage of the recovery if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /brain-injury-lawyers/north-charleston-sc/ — post ID {$post_id}" );
