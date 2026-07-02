<?php
/**
 * Seeder: pedestrian-accident-lawyers × Columbia, SC intersection page (ENRICH)
 *
 * UPDATES the existing templated stub /pedestrian-accident-lawyers/columbia-sc/ in place
 * with rich, practice-specific, hyperlocal body content + FAQPage meta + attorney
 * attribution. Part of P2 row-9 BATCH 5 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS only what the template lacks.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-pedestrian-columbia.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching pedestrian-accident-lawyers × Columbia, SC...' );

$pillar = get_page_by_path( 'pedestrian-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "pedestrian-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents pedestrians hurt in traffic across Columbia, South Carolina</strong> and the Midlands — Lexington, Irmo, West Columbia, Cayce, and Forest Acres. Drivers owe pedestrians a high duty of care, and because a person on foot has no physical protection, these crashes cause some of the most severe and fatal injuries we see. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Columbia Pedestrian Accident Claim</h2>
<p>When a driver hits a pedestrian, the insurer almost always argues the person on foot was partly to blame. What separates Roden Law is direct attorney involvement and the accident-reconstruction work needed to counter those defenses. Our office at 1545 Sumter Street, Suite B sits in the downtown corridor minutes from the Richland County Circuit Court and the USC campus, where pedestrian traffic is heaviest.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We fight comparative-fault defenses</strong> — crossing outside a crosswalk rarely bars recovery under South Carolina's 51% rule.</li>
<li><strong>Full-value focus</strong> — surgeries, rehabilitation, and lost income are all accounted for before any settlement.</li>
</ul>

<h2>Where Columbia Pedestrian Crashes Happen</h2>
<p>The Midlands' dense student and downtown foot traffic creates constant pedestrian-vehicle conflict:</p>
<ul>
<li><strong>USC campus and Five Points</strong> — heavy student pedestrian traffic, nightlife crowds, and drivers turning across crosswalks.</li>
<li><strong>Gervais Street and Assembly Street</strong> — busy downtown arterials where turning and distracted drivers strike pedestrians near crosswalks.</li>
<li><strong>Two Notch Road and other commercial corridors</strong> — wide, higher-speed roads where a pedestrian strike is far more likely to be catastrophic.</li>
<li><strong>Hit-and-run and uninsured-driver strikes</strong> — making uninsured/underinsured motorist coverage a key source of recovery.</li>
</ul>

<h2>South Carolina Pedestrian Law You Should Know</h2>
<p>South Carolina's pedestrian right-of-way and crosswalk rules are set out in <strong>S.C. Code §§ 56-5-3110 through 56-5-3230</strong>. A driver's violation of those rules — such as failing to yield in a crosswalk — is strong evidence of negligence. Even if you were crossing outside a crosswalk or against a signal, South Carolina's <strong>51% modified comparative-fault</strong> rule lets you recover as long as you are not more than 50% at fault. The deadline to file is generally <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, and South Carolina places <strong>no cap on compensatory damages</strong> in ordinary injury cases. In hit-and-run and uninsured-driver cases, <strong>stacking your uninsured/underinsured (UM/UIM) coverage</strong> is often the difference-maker — and if a drunk driver caused the crash, punitive damages may be available. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>.</p>
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
	'post_title'   => 'Pedestrian Accident Lawyers in Columbia, SC',
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
		'question' => 'Who are the best pedestrian accident lawyers in Columbia, SC?',
		'answer'   => 'Roden Law is a leading personal-injury firm serving Columbia and the Midlands, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles every case on a contingency fee basis — no fee unless we win. Call (803) 219-2816 for a free consultation.',
	),
	array(
		'question' => 'Does the driver always have the right of way over a pedestrian in South Carolina?',
		'answer'   => 'No. South Carolina law (S.C. Code §§ 56-5-3110 through 56-5-3230) gives pedestrians the right of way in marked and unmarked crosswalks and requires drivers to exercise a high degree of care around people on foot. A driver who fails to yield is generally negligent.',
	),
	array(
		'question' => 'Are pedestrian crashes common near USC and Five Points?',
		'answer'   => 'Yes. Columbia\'s USC campus and the Five Points district have some of the heaviest pedestrian traffic in the Midlands, with students and nightlife crowds crossing busy streets. Turning and distracted drivers striking pedestrians near crosswalks are a frequent cause of these crashes.',
	),
	array(
		'question' => 'What if the driver who hit me fled or had no insurance?',
		'answer'   => 'Hit-and-run and uninsured-driver pedestrian strikes are common. In those cases your own uninsured/underinsured motorist (UM/UIM) coverage typically becomes the source of recovery, and South Carolina allows stacking of that coverage. Roden Law can identify every policy that may apply.',
	),
	array(
		'question' => 'How long do I have to file a pedestrian accident claim in South Carolina?',
		'answer'   => 'The general deadline is three years from the date of injury under S.C. Code § 15-3-530. Pedestrian injuries are often severe, so it is best to have your case reviewed as soon as possible.',
	),
	array(
		'question' => 'How much does a Columbia pedestrian accident lawyer cost?',
		'answer'   => 'Roden Law handles Columbia pedestrian accident cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /pedestrian-accident-lawyers/columbia-sc/ — post ID {$post_id}" );
