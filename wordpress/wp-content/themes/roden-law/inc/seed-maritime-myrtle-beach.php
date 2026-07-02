<?php
/**
 * Seeder: maritime-injury-lawyers × Myrtle Beach, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /maritime-injury-lawyers/myrtle-beach-sc/
 * in place with rich, practice-specific, hyperlocal body content + FAQPage meta +
 * attorney attribution. Part of P2 row-9 BATCH 6 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * elements, compensation block, Key Takeaways, attorneys, case results, and the FAQ
 * accordion. post_content here ADDS the answer-first intro, "why Roden Law", local
 * Intracoastal/coastal context, and the maritime/boating-law nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-maritime-myrtle-beach.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching maritime-injury-lawyers × Myrtle Beach, SC...' );

$pillar = get_page_by_path( 'maritime-injury-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "maritime-injury-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people injured on the water along the Grand Strand</strong> — Myrtle Beach, Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and Georgetown. The coast and the Intracoastal Waterway see heavy recreational boating, and on-the-water injuries can fall under <strong>ordinary South Carolina negligence law or federal maritime law</strong> depending on the vessel and the water — and the two carry different rules and deadlines. We handle every claim on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Grand Strand On-the-Water Injury Claim</h2>
<p>On-the-water injury cases turn on which body of law applies — ordinary South Carolina negligence for most recreational boating, or federal maritime law for commercial vessels and crew — and that choice controls the deadline and what you can recover. What separates Roden Law is sorting that out early and building the claim the right way. We serve boaters, passengers, and crew throughout Horry and Georgetown counties, with Grand Strand cases heard in the Horry County court in Conway.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We apply the right law</strong> — South Carolina boating negligence or federal maritime law, whichever fits the facts.</li>
<li><strong>Direct attorney involvement</strong> — you work with your attorney, not a rotating desk of case managers.</li>
</ul>

<h2>Where Grand Strand Water Injuries Happen</h2>
<p>The Intracoastal Waterway, coastal inlets, and offshore waters draw heavy traffic year-round, and the cases our attorneys handle most include:</p>
<ul>
<li><strong>Intracoastal Waterway collisions</strong> — crashes between powerboats, personal watercraft, and larger vessels in a busy, narrow channel.</li>
<li><strong>Charter, tour, and passenger-vessel injuries</strong> — falls and crashes aboard dolphin cruises, fishing charters, and sightseeing boats.</li>
<li><strong>Boating-under-the-influence (BUI) crashes</strong> — alcohol remains a major factor on the water.</li>
<li><strong>Inlet and coastal-water injuries</strong> around Murrells Inlet and Georgetown.</li>
</ul>

<h2>The Law That Applies to Your Grand Strand Water Injury</h2>
<p>Many recreational boating injuries on Grand Strand waters are handled under <strong>ordinary South Carolina negligence law</strong>: the deadline to file is generally <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, South Carolina's <strong>51% modified comparative-fault</strong> rule lets you recover as long as you are not more than 50% at fault, and there is <strong>no cap on compensatory damages</strong> in ordinary injury cases. Boating on South Carolina waters is regulated by the S.C. Department of Natural Resources, and <strong>boating under the influence is illegal</strong>. But because Grand Strand injuries can happen on navigable coastal waters or aboard commercial vessels, <strong>federal maritime law may apply instead</strong> — the Jones Act for crew, the Longshore and Harbor Workers' Compensation Act for harbor workers, or general maritime remedies like maintenance and cure — each with <strong>different deadlines</strong>, so it is important to call promptly. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>.</p>
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
	'post_title'   => 'Maritime Injury Lawyers in Myrtle Beach, SC',
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
		'question' => 'Who are the best maritime and boating injury lawyers in Myrtle Beach, SC?',
		'answer'   => 'Roden Law represents people injured on the water across the Grand Strand, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every claim on a contingency fee basis — no fee unless we win. Call (843) 612-1980 for a free consultation.',
	),
	array(
		'question' => 'Does maritime law apply to a Grand Strand boating accident?',
		'answer'   => 'It can. Injuries on navigable coastal waters or aboard commercial vessels may fall under federal maritime law, while many ordinary recreational-boating injuries are handled under South Carolina negligence law. Because the applicable law controls your deadline and remedies, it is important to have the facts reviewed early.',
	),
	array(
		'question' => 'How long do I have to file a boating injury claim in South Carolina?',
		'answer'   => 'For ordinary recreational boating negligence in South Carolina, the deadline is generally three years from the date of injury under S.C. Code § 15-3-530. If federal maritime law applies instead, the deadline may be different — and some maritime deadlines are shorter — so it is best to have your case reviewed promptly.',
	),
	array(
		'question' => 'What if I was hurt on a charter boat or tour vessel?',
		'answer'   => 'Passengers injured on charter fishing boats, dolphin cruises, and tour vessels may have a claim against the vessel operator. Depending on where the injury occurred and the type of vessel, federal maritime law may govern, which is why it is important to have a lawyer evaluate the specifics.',
	),
	array(
		'question' => 'Is boating under the influence illegal in South Carolina?',
		'answer'   => 'Yes. Operating a boat while under the influence of alcohol or drugs is illegal in South Carolina, and BUI is a common factor in serious Grand Strand boating crashes. Evidence of impairment can strongly support an injury claim against the at-fault operator.',
	),
	array(
		'question' => 'How much does a Myrtle Beach on-the-water injury lawyer cost?',
		'answer'   => 'Roden Law handles Grand Strand boating and maritime injury cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /maritime-injury-lawyers/myrtle-beach-sc/ — post ID {$post_id}" );
