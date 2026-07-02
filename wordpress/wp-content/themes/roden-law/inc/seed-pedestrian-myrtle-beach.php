<?php
/**
 * Seeder: pedestrian-accident-lawyers × Myrtle Beach, SC intersection page (ENRICH)
 *
 * UPDATES the existing templated stub /pedestrian-accident-lawyers/myrtle-beach-sc/ in
 * place with rich, practice-specific, hyperlocal body content + FAQPage meta + attorney
 * attribution. Part of P2 row-9 BATCH 5 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS only what the template lacks.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-pedestrian-myrtle-beach.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching pedestrian-accident-lawyers × Myrtle Beach, SC...' );

$pillar = get_page_by_path( 'pedestrian-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "pedestrian-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents pedestrians hurt in traffic across Myrtle Beach and the Grand Strand</strong> — Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and Georgetown. Drivers owe pedestrians a high duty of care, and because a person on foot has no physical protection, these crashes cause some of the most severe and fatal injuries we handle. We take every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Grand Strand Pedestrian Accident Claim</h2>
<p>Insurers routinely blame the pedestrian in these cases, especially when a tourist unfamiliar with local streets is involved. What separates Roden Law is direct attorney involvement and the accident-reconstruction work needed to counter those defenses. Horry County cases are heard in Conway, and our attorneys handle claims across the entire Grand Strand, including neighboring Georgetown County.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We fight comparative-fault defenses</strong> — being outside a crosswalk rarely bars recovery under South Carolina's 51% rule.</li>
<li><strong>Full-value focus</strong> — surgeries, rehabilitation, and lost income are all accounted for before any settlement.</li>
</ul>

<h2>Where Grand Strand Pedestrian Crashes Happen</h2>
<p>Heavy seasonal tourist foot traffic makes the Grand Strand especially dangerous for pedestrians:</p>
<ul>
<li><strong>Ocean Boulevard</strong> — dense tourist foot traffic crossing between hotels, attractions, and the beach, often at night.</li>
<li><strong>US-17 (Kings Highway / Bypass)</strong> — a wide, high-traffic corridor where higher speeds make pedestrian strikes far more severe.</li>
<li><strong>Seasonal surges</strong> — summer and event weekends bring huge crowds of out-of-town pedestrians unfamiliar with local traffic patterns.</li>
<li><strong>Hit-and-run and uninsured-driver strikes</strong> — making uninsured/underinsured motorist coverage a key source of recovery.</li>
</ul>

<h2>South Carolina Pedestrian Law You Should Know</h2>
<p>South Carolina's pedestrian right-of-way and crosswalk rules are set out in <strong>S.C. Code §§ 56-5-3110 through 56-5-3230</strong>. A driver's violation of those rules is strong evidence of negligence. Even if you were crossing outside a crosswalk or against a signal, South Carolina's <strong>51% modified comparative-fault</strong> rule lets you recover as long as you are not more than 50% at fault. The deadline to file is generally <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, and South Carolina places <strong>no cap on compensatory damages</strong> in ordinary injury cases. In hit-and-run and uninsured-driver cases, <strong>stacking your uninsured/underinsured (UM/UIM) coverage</strong> is often the difference-maker — and if a drunk driver caused the crash, punitive damages may be available. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>.</p>
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
	'post_title'   => 'Pedestrian Accident Lawyers in Myrtle Beach, SC',
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
		'question' => 'Who are the best pedestrian accident lawyers in Myrtle Beach, SC?',
		'answer'   => 'Roden Law is a leading personal-injury firm serving Myrtle Beach and the Grand Strand, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every case on a contingency fee basis — no fee unless we win. Call (843) 612-1980 for a free consultation.',
	),
	array(
		'question' => 'Why are pedestrian crashes so common in Myrtle Beach?',
		'answer'   => 'The Grand Strand draws heavy seasonal tourist foot traffic, especially along Ocean Boulevard and US-17. Visitors unfamiliar with local streets, nighttime crossings, and crowded event weekends all increase the risk of a driver striking a pedestrian.',
	),
	array(
		'question' => 'Can I still recover if I was crossing outside a crosswalk?',
		'answer'   => 'Often yes. South Carolina uses a 51% modified comparative-fault rule, so you can recover as long as you were not more than 50% at fault. Crossing mid-block may reduce recovery, but it rarely bars a claim outright — and the driver may still have failed to keep a proper lookout.',
	),
	array(
		'question' => 'What if the driver who hit me fled or had no insurance?',
		'answer'   => 'Hit-and-run and uninsured-driver strikes are common on busy Grand Strand roads. In those cases your own uninsured/underinsured motorist (UM/UIM) coverage typically becomes the source of recovery, and South Carolina allows stacking of that coverage.',
	),
	array(
		'question' => 'Where is a Myrtle Beach pedestrian accident case handled?',
		'answer'   => 'Personal-injury cases arising in Myrtle Beach and most of the Grand Strand are handled in Horry County, with court in Conway; cases in neighboring Georgetown County are handled there. The general deadline to file is three years from the date of injury under S.C. Code § 15-3-530.',
	),
	array(
		'question' => 'How much does a Myrtle Beach pedestrian accident lawyer cost?',
		'answer'   => 'Roden Law handles Grand Strand pedestrian accident cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /pedestrian-accident-lawyers/myrtle-beach-sc/ — post ID {$post_id}" );
