<?php
/**
 * Seeder: motorcycle-accident-lawyers × Columbia, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub at /motorcycle-accident-lawyers/
 * columbia-sc/ in place with rich, practice-specific, hyperlocal body content +
 * FAQPage meta + attorney attribution. Part of P2 row-9 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do"
 * steps, negligence/elements, compensation block, Key Takeaways, attorneys, case
 * results, and FAQ accordion. post_content ADDS what the template lacks: answer-
 * first intro, "why Roden Law", local risk roads, and motorcycle-specific SC
 * nuances (helmet law, rider bias, UM/UIM stacking).
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-moto-columbia.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching motorcycle-accident-lawyers × Columbia, SC...' );

$pillar = get_page_by_path( 'motorcycle-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "motorcycle-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents motorcyclists injured in crashes across Columbia and the Midlands</strong> — Lexington, Irmo, West Columbia, Cayce, Forest Acres, and Blythewood. Riders face devastating injuries and an uphill fight against insurers and jurors who are biased against motorcyclists — a bias our attorneys are built to overcome. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Columbia Motorcycle Accident Claim</h2>
<p>The single biggest obstacle in a motorcycle case is not the law — it is the assumption that the rider was reckless. Insurers exploit it from the first phone call, and defense lawyers plant it with jurors. What separates Roden Law is direct attorney involvement — you work with your attorney, not a rotating desk of case managers — and a case built from the start to dismantle rider bias with hard evidence: scene reconstruction, the at-fault driver's own conduct, and the physics of the crash. Our office at 1545 Sumter Street, Suite B is minutes from the Richland County Court of Common Pleas.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to start your claim.</li>
<li><strong>We fight rider bias</strong> — we frame the at-fault driver's negligence, not the fact that you were on a bike.</li>
<li><strong>We find every dollar of coverage</strong> — motorcycle injuries routinely exceed a minimum-limits policy, so UM/UIM stacking is often decisive.</li>
</ul>

<h2>Where Columbia Motorcycle Crashes Happen</h2>
<p>The Midlands crashes our attorneys handle most often involve:</p>
<ul>
<li><strong>Left-turn collisions</strong> — a car turning across a rider's path is the most common and most catastrophic motorcycle crash, and Two Notch Road (US-1), Garners Ferry Road, Forest Drive, and Broad River Road see them constantly.</li>
<li><strong>Interstate and merge crashes</strong> on the I-20/I-26/I-77 "Malfunction Junction" and its Carolina Crossroads work zones, where lane changes and debris are especially dangerous to riders.</li>
<li><strong>Intersection and lane-change crashes</strong> where drivers fail to see or yield to a motorcycle.</li>
<li><strong>Impaired-driver crashes</strong> near USC and Five Points, especially at night and on weekends.</li>
</ul>

<h2>South Carolina Motorcycle Law: What Columbia Riders Should Know</h2>
<h3>Helmets Are Required Only Under 21</h3>
<p>South Carolina requires helmets <strong>only for riders under 21 under S.C. Code § 56-5-3660</strong>. If you are 21 or older, riding without a helmet is legal, and there is no statute making non-use an automatic bar to your claim. Insurers still try to use it against you — we shut that argument down.</p>
<h3>3-Year Deadline and the 51% Bar</h3>
<p>The statute of limitations is <strong>three years under S.C. Code § 15-3-530</strong>, and South Carolina's <strong>51% modified comparative fault</strong> rule lets you recover as long as you are not more than 50% at fault. There is <strong>no cap on compensatory damages</strong> in a standard case.</p>
<h3>UM/UIM Stacking Is Often the Key</h3>
<p>Motorcycle injuries are severe and quickly outstrip an at-fault driver's coverage — and many drivers carry only South Carolina's 25/50/25 minimum. South Carolina lets you <strong>stack your own uninsured and underinsured motorist coverage</strong> across policies, which is frequently the largest source of recovery. And if the at-fault driver was <strong>DUI, the cap on punitive damages is removed</strong>.</p>

<h2>Learn More About South Carolina Motorcycle Claims</h2>
<ul>
<li><a href="/south-carolina-motorcycle-accident-lawyer/">South Carolina motorcycle accident lawyer — statewide overview</a></li>
<li><a href="/resources/south-carolina-um-uim-stacking/">South Carolina UM/UIM stacking explained</a></li>
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
	'post_title'   => 'Motorcycle Accident Lawyers in Columbia, SC',
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
		'question' => 'Who are the best motorcycle accident lawyers in Columbia, SC?',
		'answer'   => 'Roden Law is a leading motorcycle accident firm serving Columbia and the Midlands, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles every case on a contingency fee basis — no fee unless we win — and you work directly with your attorney. Call (803) 219-2816 for a free consultation.',
	),
	array(
		'question' => 'Do I lose my claim if I wasn\'t wearing a helmet in South Carolina?',
		'answer'   => 'No. South Carolina only requires helmets for riders under 21 (S.C. Code § 56-5-3660), and there is no law making non-use an automatic bar to recovery. Insurers may try to blame you for not wearing one, but we shut that argument down and keep the focus on the at-fault driver.',
	),
	array(
		'question' => 'How long do I have to file a motorcycle accident claim in South Carolina?',
		'answer'   => 'You generally have three years from the date of the crash under S.C. Code § 15-3-530. Waiting is costly because scene evidence and witness memories fade quickly, so it is best to contact an attorney early.',
	),
	array(
		'question' => 'The driver who hit me only had minimum insurance. What can I do?',
		'answer'   => 'Motorcycle injuries often exceed South Carolina\'s 25/50/25 minimum limits. South Carolina lets you stack your own uninsured and underinsured motorist (UM/UIM) coverage across policies, which is frequently the largest source of recovery. Our attorneys identify and pursue every available policy.',
	),
	array(
		'question' => 'What are the most dangerous roads for motorcyclists in Columbia?',
		'answer'   => 'Left-turn crashes on Two Notch Road (US-1), Garners Ferry Road, Forest Drive, and Broad River Road are the most common and most severe. The I-20/I-26/I-77 "Malfunction Junction" interchange and its Carolina Crossroads work zones are also especially hazardous for riders due to lane changes and debris.',
	),
	array(
		'question' => 'Can I recover if I was partly at fault for the motorcycle crash?',
		'answer'   => 'Yes, as long as you were not more than 50% at fault. South Carolina uses 51% modified comparative fault, so your recovery is reduced by your share of fault but not eliminated unless it reaches 51%. If the at-fault driver was DUI, the cap on punitive damages is also removed.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /motorcycle-accident-lawyers/columbia-sc/ — post ID {$post_id}" );
