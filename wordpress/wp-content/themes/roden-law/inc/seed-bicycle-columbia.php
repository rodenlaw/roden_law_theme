<?php
/**
 * Seeder: bicycle-accident-lawyers × Columbia, SC intersection page (ENRICH)
 *
 * UPDATES the existing templated stub /bicycle-accident-lawyers/columbia-sc/ in place
 * with rich, practice-specific, hyperlocal body content + FAQPage meta + attorney
 * attribution. Part of P2 row-9 BATCH 5 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS only what the template lacks.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-bicycle-columbia.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching bicycle-accident-lawyers × Columbia, SC...' );

$pillar = get_page_by_path( 'bicycle-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "bicycle-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents cyclists injured by drivers across Columbia, South Carolina</strong> and the Midlands — Lexington, Irmo, West Columbia, Cayce, and Forest Acres. In South Carolina a cyclist has the <strong>same rights and duties on the road as the driver of a car</strong>, and motorists must give at least three feet when passing. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Columbia Bicycle Accident Claim</h2>
<p>Insurers often argue the cyclist "came out of nowhere" or should not have been on the road — arguments that ignore a cyclist's equal right to the roadway. What separates Roden Law is direct attorney involvement and the accident-reconstruction work needed to prove the driver's fault. Our office at 1545 Sumter Street, Suite B sits in the downtown corridor minutes from the Richland County Circuit Court and the bike-heavy USC campus and Five Points area.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We prove the driver's violation</strong> — unsafe passing, failure to yield, and dooring are all breaches of a driver's duty to share the road.</li>
<li><strong>Full-value focus</strong> — cyclists suffer severe injuries, and we account for surgeries, rehabilitation, and lost income before any settlement.</li>
</ul>

<h2>How Columbia Bicycle Crashes Happen</h2>
<p>The Midlands' student cycling and downtown traffic create constant conflict with vehicles:</p>
<ul>
<li><strong>USC campus and Five Points</strong> — heavy student cycling mixing with turning and distracted drivers.</li>
<li><strong>Gervais Street and Assembly Street</strong> — busy downtown arterials where right-hook and failure-to-yield crashes occur.</li>
<li><strong>Two Notch Road and other commercial corridors</strong> — wide, higher-speed roads where unsafe passing is common.</li>
<li><strong>Dooring</strong> — parked-car occupants opening doors into a cyclist's path on downtown streets.</li>
</ul>

<h2>South Carolina Bicycle Law You Should Know</h2>
<p>Under <strong>S.C. Code § 56-5-3410 and following</strong>, a person riding a bicycle on a South Carolina road has the <strong>same rights and duties as the driver of a vehicle</strong>. South Carolina's <strong>safe-passing law (S.C. Code § 56-5-3435) requires motorists to leave at least three feet</strong> when passing a bicycle, and violating it is powerful evidence of negligence. South Carolina has <strong>no statewide adult bicycle-helmet mandate</strong> (though some local ordinances apply), so not wearing a helmet is a contested injury-enhancement argument — not an automatic bar to recovery. The deadline to file is generally <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>; South Carolina uses a <strong>51% modified comparative-fault</strong> rule and places <strong>no cap on compensatory damages</strong> in ordinary injury cases. Your own uninsured/underinsured (UM/UIM) coverage often applies when a cyclist is struck by an uninsured or hit-and-run driver. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>.</p>
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
	'post_title'   => 'Bicycle Accident Lawyers in Columbia, SC',
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
		'question' => 'Who are the best bicycle accident lawyers in Columbia, SC?',
		'answer'   => 'Roden Law is a leading personal-injury firm serving Columbia and the Midlands, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles every case on a contingency fee basis — no fee unless we win. Call (803) 219-2816 for a free consultation.',
	),
	array(
		'question' => 'Do cyclists have the same rights as cars on South Carolina roads?',
		'answer'   => 'Yes. Under S.C. Code § 56-5-3410 and following, a person riding a bicycle on a South Carolina road generally has the same rights and duties as the driver of a vehicle. A cyclist is entitled to use the road, and drivers must share it.',
	),
	array(
		'question' => 'How much room must a driver give when passing a cyclist in South Carolina?',
		'answer'   => 'South Carolina\'s safe-passing law, S.C. Code § 56-5-3435, requires a motorist to leave at least three feet of clearance when passing a bicycle. A driver who passes too closely and causes a crash has violated the law, which is strong evidence of negligence.',
	),
	array(
		'question' => 'Are bicycle crashes common near USC and Five Points?',
		'answer'   => 'Yes. Columbia\'s USC campus and the Five Points district have heavy student cycling that mixes with busy vehicle traffic. Right-hook turns, failure to yield, and dooring near these areas are frequent causes of crashes.',
	),
	array(
		'question' => 'Does not wearing a helmet hurt my bicycle accident claim?',
		'answer'   => 'Not automatically. South Carolina has no statewide adult bicycle-helmet mandate, though some local ordinances apply. Helmet non-use may be raised to reduce damages, but it does not bar recovery and does not excuse the driver\'s negligence.',
	),
	array(
		'question' => 'How much does a Columbia bicycle accident lawyer cost?',
		'answer'   => 'Roden Law handles Columbia bicycle accident cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /bicycle-accident-lawyers/columbia-sc/ — post ID {$post_id}" );
