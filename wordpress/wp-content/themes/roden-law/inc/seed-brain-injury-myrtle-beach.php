<?php
/**
 * Seeder: brain-injury-lawyers × Myrtle Beach, SC intersection page (ENRICH)
 *
 * UPDATES the existing /brain-injury-lawyers/myrtle-beach-sc/ page in place with
 * rich, practice-specific, hyperlocal content + FAQPage meta + attorney
 * attribution. Part of P2 row-9 BATCH 3.
 *
 * Template auto-generates SC state-law box, "what to do" steps, negligence
 * elements, compensation block, Key Takeaways, attorneys, case results, and FAQ
 * accordion. post_content ADDS: answer-first intro, "why Roden Law", local
 * context, and TBI-specific SC nuances — no duplication.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-brain-injury-myrtle-beach.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching brain-injury-lawyers × Myrtle Beach, SC...' );

$pillar = get_page_by_path( 'brain-injury-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "brain-injury-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people who have suffered a traumatic brain injury in Myrtle Beach, South Carolina and throughout the Grand Strand</strong> — Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and Georgetown. Brain injuries are often catastrophic and permanent, and we handle every claim on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Myrtle Beach Brain Injury Claim</h2>
<p>A traumatic brain injury (TBI) can permanently change a person's ability to work, think, and care for themselves — and full-value cases require medical experts, life-care planners, and vocational economists, not just a demand letter. What separates Roden Law is direct attorney involvement and the resources to build that proof. We serve the Grand Strand from Murrells Inlet through Georgetown, and Horry County cases are filed at the courthouse in Conway — so investigation, records, and filings happen without delay.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to investigate your claim.</li>
<li><strong>Life-care planning</strong> — we quantify future medical care, therapy, and 24/7 attendant needs so nothing is left off the table.</li>
<li><strong>Trial-ready</strong> — we prepare every claim for the Horry County courts in Conway, which is what moves insurers to pay full value.</li>
</ul>

<h2>How Grand Strand Brain Injuries Happen</h2>
<p>The TBI cases our attorneys handle most often along the Grand Strand arise from:</p>
<ul>
<li><strong>Car and truck crashes</strong> on US-17 (Kings Highway and the Bypass) and SC-31 (Carolina Bays Parkway) — the leading cause of serious head trauma, and worse during peak tourist traffic.</li>
<li><strong>Pedestrian and bicycle collisions</strong>, a heightened risk in a walkable tourism corridor.</li>
<li><strong>Falls and premises incidents</strong> at hotels, resorts, pools, and attractions.</li>
<li><strong>Boating, watercraft, and recreational injuries</strong> along the coast.</li>
<li><strong>Medical negligence</strong>, including oxygen-deprivation and surgical injuries.</li>
</ul>

<h2>South Carolina Brain Injury Law: What Grand Strand Victims Need to Know</h2>
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
	'name'           => 'myrtle-beach-sc',
	'posts_per_page' => 1,
) );

$postarr = array(
	'post_type'    => 'practice_area',
	'post_status'  => 'publish',
	'post_title'   => 'Brain Injury Lawyers in Myrtle Beach, SC',
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
		'question' => 'Who are the best brain injury lawyers in Myrtle Beach, SC?',
		'answer'   => 'Roden Law is a leading brain injury firm serving Myrtle Beach and the Grand Strand, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every case on a contingency fee basis — no fee unless we win — and work with life-care planners and medical experts. Call (843) 612-1980 for a free consultation.',
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
		'question' => 'What are the symptoms of a traumatic brain injury after a Myrtle Beach accident?',
		'answer'   => 'Symptoms can include headaches, memory loss, confusion, dizziness, sensitivity to light or noise, mood changes, and difficulty concentrating — and they often appear hours or days after the accident, not immediately. Prompt medical evaluation is essential both for your health and for documenting the injury.',
	),
	array(
		'question' => 'How much is a Myrtle Beach brain injury case worth?',
		'answer'   => 'Every case is different, but serious brain injuries are among the highest-value personal injury claims because the economic damages — future medical care, lost earning capacity, and 24/7 care — can be enormous. Roden Law works with life-care planners and economists to document the full lifetime cost of the injury.',
	),
	array(
		'question' => 'How much does a Myrtle Beach brain injury lawyer cost?',
		'answer'   => 'Roden Law handles Grand Strand brain injury cases on a contingency fee basis. You pay no attorney fees and no upfront costs — we advance the cost of the experts and life-care planning needed to build your case — and we are only paid a percentage of the recovery if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /brain-injury-lawyers/myrtle-beach-sc/ — post ID {$post_id}" );
