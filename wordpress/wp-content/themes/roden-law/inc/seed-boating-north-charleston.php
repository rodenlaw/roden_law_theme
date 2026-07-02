<?php
/**
 * Seeder: boating-accident-lawyers × North Charleston, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /boating-accident-lawyers/north-charleston-sc/
 * in place with rich, practice-specific, hyperlocal body content + FAQPage meta +
 * attorney attribution. Part of P2 row-9 BATCH 6 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * elements, compensation block, Key Takeaways, attorneys, case results, and the FAQ
 * accordion. post_content here ADDS the answer-first intro, "why Roden Law", local
 * river/harbor context, and SC boating-law nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-boating-north-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching boating-accident-lawyers × North Charleston, SC...' );

$pillar = get_page_by_path( 'boating-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "boating-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people injured in boating accidents in North Charleston, South Carolina</strong> and across the surrounding Lowcountry. The Cooper River, Charleston Harbor, and the region's coastal waters carry heavy recreational and commercial traffic, and a boating crash can cause serious injuries far from immediate help. We handle every claim on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436126561">(843) 612-6561</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a North Charleston Boating Accident Claim</h2>
<p>Boating cases are different from car crashes: there are no lane markings, no traffic cameras, and often no independent witnesses, so proving how the crash happened takes fast investigation. What separates Roden Law is moving quickly to secure the S.C. Department of Natural Resources incident report, locate witnesses, and preserve evidence before it disappears. We serve boaters and passengers throughout North Charleston, Hanahan, and the Cooper River corridor, with cases heard in the Charleston County Circuit Court.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>Fast investigation</strong> — we secure the DNR report and witness statements before evidence is lost.</li>
<li><strong>Direct attorney involvement</strong> — you work with your attorney, not a rotating desk of case managers.</li>
</ul>

<h2>How North Charleston Boating Accidents Happen</h2>
<p>South Carolina consistently ranks among the states with the most boating incidents, and the cases our attorneys handle most involve:</p>
<ul>
<li><strong>Operator inattention and inexperience</strong> — the most common causes of recreational boat crashes.</li>
<li><strong>Excessive speed</strong> in crowded river and harbor areas.</li>
<li><strong>Boating under the influence (BUI)</strong> — alcohol remains a major factor on the water.</li>
<li><strong>Wakes and near-terminal traffic</strong> where recreational boats share water with larger commercial vessels.</li>
</ul>

<h2>South Carolina Boating Law You Should Know</h2>
<p>Recreational boating in South Carolina is regulated by the <strong>S.C. Department of Natural Resources under S.C. Code Title 50, Chapter 21</strong>, and <strong>boating under the influence is illegal</strong>. Most in-state recreational boating injury claims follow ordinary South Carolina negligence rules: the deadline to file is generally <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, South Carolina's <strong>51% modified comparative-fault</strong> rule lets you recover as long as you are not more than 50% at fault, and there is <strong>no cap on compensatory damages</strong> in ordinary injury cases. If a crash happens on navigable coastal waters or involves a commercial vessel, federal maritime law can apply instead, with different deadlines — so it is worth having the facts reviewed promptly. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>.</p>
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
	'post_title'   => 'Boating Accident Lawyers in North Charleston, SC',
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
		'question' => 'Who are the best boating accident lawyers in North Charleston, SC?',
		'answer'   => 'Roden Law represents people injured in boating accidents in North Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every claim on a contingency fee basis — no fee unless we win. Call (843) 612-6561 for a free consultation.',
	),
	array(
		'question' => 'How long do I have to file a boating accident claim in South Carolina?',
		'answer'   => 'For ordinary recreational boating negligence in South Carolina, the deadline is generally three years from the date of injury under S.C. Code § 15-3-530. If federal maritime law applies — for example, a crash on navigable coastal waters or involving a commercial vessel — the deadline may be different, so have your case reviewed promptly.',
	),
	array(
		'question' => 'Who investigates boating accidents in South Carolina?',
		'answer'   => 'The S.C. Department of Natural Resources regulates boating under S.C. Code Title 50, Chapter 21 and investigates serious boating accidents. The DNR incident report is often key evidence in a boating injury claim, which is why it is important to secure it early.',
	),
	array(
		'question' => 'Is it illegal to drink and drive a boat in South Carolina?',
		'answer'   => 'Yes. Boating under the influence (BUI) of alcohol or drugs is illegal in South Carolina and is a common factor in serious crashes. Evidence that the other operator was impaired can strongly support your injury claim.',
	),
	array(
		'question' => 'Can I recover if I was partly at fault for a boating crash?',
		'answer'   => 'Often yes. South Carolina uses a 51% modified comparative-fault rule, so you can recover as long as you were not more than 50% at fault, though your recovery is reduced by your share of fault. An attorney can help establish the other operator\'s responsibility.',
	),
	array(
		'question' => 'How much does a North Charleston boating accident lawyer cost?',
		'answer'   => 'Roden Law handles North Charleston boating accident cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /boating-accident-lawyers/north-charleston-sc/ — post ID {$post_id}" );
