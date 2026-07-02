<?php
/**
 * Seeder: boating-accident-lawyers × Myrtle Beach, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /boating-accident-lawyers/myrtle-beach-sc/
 * in place with rich, practice-specific, hyperlocal body content + FAQPage meta +
 * attorney attribution. Part of P2 row-9 BATCH 6 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * elements, compensation block, Key Takeaways, attorneys, case results, and the FAQ
 * accordion. post_content here ADDS the answer-first intro, "why Roden Law", local
 * Intracoastal / coastal context, and SC boating-law nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-boating-myrtle-beach.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching boating-accident-lawyers × Myrtle Beach, SC...' );

$pillar = get_page_by_path( 'boating-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "boating-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people injured in boating accidents along the Grand Strand</strong> — Myrtle Beach, Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and Georgetown. The <strong>Intracoastal Waterway</strong>, coastal inlets, and the Waccamaw River see some of the heaviest recreational boating traffic in South Carolina, and a crash in a busy, narrow channel can cause serious injuries. We take every claim on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Grand Strand Boating Accident Claim</h2>
<p>Boating cases are different from car crashes: there are no lane markings, no traffic cameras, and often no independent witnesses, so proving how the crash happened takes fast investigation. What separates Roden Law is moving quickly to secure the S.C. Department of Natural Resources incident report, locate witnesses, and preserve evidence before it disappears. We serve boaters and passengers throughout Horry and Georgetown counties, with Grand Strand cases heard in the Horry County court in Conway.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>Fast investigation</strong> — we secure the DNR report and witness statements before evidence is lost.</li>
<li><strong>Direct attorney involvement</strong> — you work with your attorney, not a rotating desk of case managers.</li>
</ul>

<h2>How Grand Strand Boating Accidents Happen</h2>
<p>South Carolina consistently ranks among the states with the most boating incidents, and the Grand Strand cases our attorneys handle most involve:</p>
<ul>
<li><strong>Intracoastal Waterway collisions</strong> — crashes in a busy, narrow channel shared by powerboats, personal watercraft, and larger vessels.</li>
<li><strong>Operator inattention and inexperience</strong> — the most common causes of recreational boat crashes.</li>
<li><strong>Boating under the influence (BUI)</strong> — alcohol remains a major factor on the water.</li>
<li><strong>Charter, tour, and passenger-vessel injuries</strong> aboard fishing charters and sightseeing boats.</li>
</ul>

<h2>South Carolina Boating Law You Should Know</h2>
<p>Recreational boating in South Carolina is regulated by the <strong>S.C. Department of Natural Resources under S.C. Code Title 50, Chapter 21</strong>, and <strong>boating under the influence is illegal</strong>. Most in-state recreational boating injury claims follow ordinary South Carolina negligence rules: the deadline to file is generally <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, South Carolina's <strong>51% modified comparative-fault</strong> rule lets you recover as long as you are not more than 50% at fault, and there is <strong>no cap on compensatory damages</strong> in ordinary injury cases. Because Grand Strand crashes can happen on navigable coastal waters or involve commercial vessels, federal maritime law can apply instead, with different deadlines — so it is worth having the facts reviewed promptly. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>.</p>
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
	'post_title'   => 'Boating Accident Lawyers in Myrtle Beach, SC',
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
		'question' => 'Who are the best boating accident lawyers in Myrtle Beach, SC?',
		'answer'   => 'Roden Law represents people injured in boating accidents across the Grand Strand, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every claim on a contingency fee basis — no fee unless we win. Call (843) 612-1980 for a free consultation.',
	),
	array(
		'question' => 'How long do I have to file a boating accident claim in South Carolina?',
		'answer'   => 'For ordinary recreational boating negligence in South Carolina, the deadline is generally three years from the date of injury under S.C. Code § 15-3-530. If federal maritime law applies — for example, a crash on navigable coastal waters or involving a commercial vessel — the deadline may be different, so have your case reviewed promptly.',
	),
	array(
		'question' => 'Who investigates boating accidents on the Grand Strand?',
		'answer'   => 'The S.C. Department of Natural Resources regulates boating under S.C. Code Title 50, Chapter 21 and investigates serious boating accidents on the Intracoastal Waterway and coastal waters. The DNR incident report is often key evidence in a boating injury claim, which is why it is important to secure it early.',
	),
	array(
		'question' => 'Is it illegal to drink and drive a boat in South Carolina?',
		'answer'   => 'Yes. Boating under the influence (BUI) of alcohol or drugs is illegal in South Carolina and is a common factor in serious Grand Strand crashes. Evidence that the other operator was impaired can strongly support your injury claim.',
	),
	array(
		'question' => 'What if I was hurt on a charter or tour boat?',
		'answer'   => 'Passengers injured on charter fishing boats, dolphin cruises, and tour vessels may have a claim against the operator. Depending on where the injury occurred and the type of vessel, federal maritime law may govern, so it is important to have a lawyer evaluate the specifics.',
	),
	array(
		'question' => 'How much does a Myrtle Beach boating accident lawyer cost?',
		'answer'   => 'Roden Law handles Grand Strand boating accident cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /boating-accident-lawyers/myrtle-beach-sc/ — post ID {$post_id}" );
