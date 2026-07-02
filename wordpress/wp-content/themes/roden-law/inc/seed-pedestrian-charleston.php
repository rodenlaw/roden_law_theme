<?php
/**
 * Seeder: pedestrian-accident-lawyers × Charleston, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /pedestrian-accident-lawyers/charleston-sc/
 * page in place with rich, practice-specific, hyperlocal body content + FAQPage meta
 * + attorney attribution. Part of P2 row-9 BATCH 5 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS only what the template lacks: answer-first
 * intro, "why Roden Law", local hazards/venues, and pedestrian-specific SC nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-pedestrian-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching pedestrian-accident-lawyers × Charleston, SC...' );

$pillar = get_page_by_path( 'pedestrian-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "pedestrian-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents pedestrians hurt in traffic across Charleston, South Carolina</strong> and the Lowcountry — Mount Pleasant, Summerville, and Goose Creek. Drivers owe pedestrians a high duty of care, and because a person on foot has no physical protection, these crashes cause some of the most severe and fatal injuries we see. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18437908999">(843) 790-8999</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Charleston Pedestrian Accident Claim</h2>
<p>When a driver hits a pedestrian, the insurer almost always argues the person on foot was partly to blame — that they crossed outside a crosswalk or stepped out too fast. What separates Roden Law is direct attorney involvement and the accident-reconstruction work needed to counter those defenses. Our office at 127 King Street, Suite 200 sits on the peninsula, minutes from the Charleston County Circuit Court and the busy downtown corridors where many of these crashes happen.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We fight comparative-fault defenses</strong> — crossing outside a crosswalk rarely bars recovery under South Carolina's 51% rule, and we make sure fault is placed where it belongs.</li>
<li><strong>Full-value focus</strong> — severe pedestrian injuries mean surgeries, rehabilitation, and lost income, and we account for all of it before any settlement.</li>
</ul>

<h2>Where Charleston Pedestrian Crashes Happen</h2>
<p>The peninsula's heavy foot traffic and tourist crowds create constant pedestrian-vehicle conflict:</p>
<ul>
<li><strong>King Street and Meeting Street</strong> — dense shopping, dining, and nightlife foot traffic where turning vehicles and distracted drivers strike pedestrians in and near crosswalks.</li>
<li><strong>Tourist districts</strong> — visitors unfamiliar with local streets crossing near the Market, the Battery, and the waterfront.</li>
<li><strong>I-526 and arterial corridors</strong> — higher-speed roads where a pedestrian strike is far more likely to be catastrophic or fatal.</li>
<li><strong>Hit-and-run and uninsured-driver strikes</strong> — a common problem downtown, where uninsured/underinsured motorist coverage becomes the key source of recovery.</li>
</ul>

<h2>South Carolina Pedestrian Law You Should Know</h2>
<p>South Carolina's pedestrian right-of-way and crosswalk rules are set out in <strong>S.C. Code §§ 56-5-3110 through 56-5-3230</strong>. A driver's violation of those rules — failing to yield in a crosswalk, for example — is strong evidence of negligence. Even if you were crossing outside a crosswalk or against a signal, South Carolina's <strong>51% modified comparative-fault</strong> rule lets you recover as long as you are not more than 50% at fault, so a partial-fault argument rarely ends a claim. The deadline to file is generally <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, and South Carolina places <strong>no cap on compensatory damages</strong> in ordinary injury cases. In hit-and-run and uninsured-driver cases, <strong>stacking your uninsured/underinsured (UM/UIM) coverage</strong> is often the difference-maker — and if a drunk driver caused the crash, punitive damages may be available. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>.</p>
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
	'post_title'   => 'Pedestrian Accident Lawyers in Charleston, SC',
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
		'question' => 'Who are the best pedestrian accident lawyers in Charleston, SC?',
		'answer'   => 'Roden Law is a leading personal-injury firm serving Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Charleston office at 127 King Street handles every case on a contingency fee basis — no fee unless we win. Call (843) 790-8999 for a free consultation.',
	),
	array(
		'question' => 'Does the driver always have the right of way over a pedestrian in South Carolina?',
		'answer'   => 'No. South Carolina law (S.C. Code §§ 56-5-3110 through 56-5-3230) gives pedestrians the right of way in marked and unmarked crosswalks and requires drivers to exercise a high degree of care around people on foot. A driver who fails to yield is generally negligent.',
	),
	array(
		'question' => 'Can I still recover if I was crossing outside a crosswalk?',
		'answer'   => 'Often yes. South Carolina uses a 51% modified comparative-fault rule, so you can recover as long as you were not more than 50% at fault. Crossing mid-block may reduce your recovery, but it rarely bars a claim outright — and the driver may still have failed to keep a proper lookout.',
	),
	array(
		'question' => 'What if the driver who hit me fled or had no insurance?',
		'answer'   => 'Hit-and-run and uninsured-driver pedestrian strikes are common in Charleston. In those cases your own uninsured/underinsured motorist (UM/UIM) coverage typically becomes the source of recovery, and South Carolina allows stacking of that coverage. Roden Law can identify every policy that may apply.',
	),
	array(
		'question' => 'How long do I have to file a pedestrian accident claim in South Carolina?',
		'answer'   => 'The general deadline is three years from the date of injury under S.C. Code § 15-3-530. Pedestrian injuries are often severe, so it is best to have your case reviewed as soon as possible while evidence and witnesses are still available.',
	),
	array(
		'question' => 'How much does a Charleston pedestrian accident lawyer cost?',
		'answer'   => 'Roden Law handles Charleston pedestrian accident cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /pedestrian-accident-lawyers/charleston-sc/ — post ID {$post_id}" );
