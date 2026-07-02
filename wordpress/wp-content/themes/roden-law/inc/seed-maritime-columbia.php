<?php
/**
 * Seeder: maritime-injury-lawyers × Columbia, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /maritime-injury-lawyers/columbia-sc/
 * in place with rich, practice-specific, hyperlocal body content + FAQPage meta +
 * attorney attribution. Part of P2 row-9 BATCH 6 enrichment (2026-06).
 *
 * Columbia is inland, so this page is framed around recreational boating on Lake
 * Murray and the Midlands rivers rather than commercial port/longshore maritime.
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * elements, compensation block, Key Takeaways, attorneys, case results, and the FAQ
 * accordion. post_content here ADDS the answer-first intro, "why Roden Law", local
 * water context, and the maritime/boating-law nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-maritime-columbia.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching maritime-injury-lawyers × Columbia, SC...' );

$pillar = get_page_by_path( 'maritime-injury-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "maritime-injury-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people injured on the water in Columbia, South Carolina</strong> and throughout the Midlands — Lexington, Irmo, Chapin, West Columbia, and Cayce. Columbia is inland, so most on-the-water injuries here involve <strong>recreational boating on Lake Murray and the Congaree and Broad rivers</strong> rather than commercial port work — but when a commercial-vessel or crew injury does arise, it is governed by <strong>federal maritime law</strong> with its own rules and deadlines. We handle every claim on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Columbia On-the-Water Injury Claim</h2>
<p>On-the-water injury cases turn on which body of law applies — ordinary South Carolina negligence for most recreational boating on Lake Murray, or federal maritime law when a crew member or commercial vessel is involved. What separates Roden Law is sorting that out early, because it controls the deadline and what you can recover. Our office at 1545 Sumter Street, Suite B sits in downtown Columbia, minutes from the Richland County Circuit Court and a short drive from Lake Murray's busiest boat landings.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We apply the right law</strong> — South Carolina boating negligence or federal maritime law, whichever fits the facts.</li>
<li><strong>Direct attorney involvement</strong> — you work with your attorney, not a rotating desk of case managers.</li>
</ul>

<h2>Where Midlands Water Injuries Happen</h2>
<p>The Midlands' lakes and rivers draw heavy recreational traffic, and the cases our attorneys handle most include:</p>
<ul>
<li><strong>Lake Murray boating collisions</strong> — crashes between powerboats, personal watercraft, and pontoons on one of the state's most popular recreational lakes.</li>
<li><strong>Operator inattention and speed</strong> — the leading causes of recreational boat crashes.</li>
<li><strong>Boating-under-the-influence (BUI) crashes</strong> — alcohol remains a major factor on the water.</li>
<li><strong>River and dock injuries</strong> along the Congaree and Broad rivers.</li>
</ul>

<h2>The Law That Applies to Your Midlands Water Injury</h2>
<p>Most recreational boating injuries on Lake Murray and the Midlands rivers are handled under <strong>ordinary South Carolina negligence law</strong>: the deadline to file is generally <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, South Carolina's <strong>51% modified comparative-fault</strong> rule lets you recover as long as you are not more than 50% at fault, and there is <strong>no cap on compensatory damages</strong> in ordinary injury cases. Boating on South Carolina waters is regulated by the S.C. Department of Natural Resources, and <strong>boating under the influence is illegal</strong>. If your injury instead involves a commercial vessel or crew, federal maritime law — the Jones Act, the Longshore and Harbor Workers' Compensation Act, or general maritime remedies like maintenance and cure — may govern instead, with <strong>different deadlines</strong>, so it is important to call promptly. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>.</p>
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
	'post_title'   => 'Maritime Injury Lawyers in Columbia, SC',
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
		'question' => 'Who are the best maritime and boating injury lawyers in Columbia, SC?',
		'answer'   => 'Roden Law represents people injured on the water in Columbia and the Midlands, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles every claim on a contingency fee basis — no fee unless we win. Call (803) 219-2816 for a free consultation.',
	),
	array(
		'question' => 'Is a Lake Murray boating injury governed by maritime law?',
		'answer'   => 'Usually no. Most recreational boating injuries on Lake Murray and the Midlands rivers are handled under ordinary South Carolina negligence law, with a three-year deadline. Federal maritime law generally applies to commercial vessels and crew members, not to typical recreational boating on an inland lake.',
	),
	array(
		'question' => 'How long do I have to file a boating injury claim in South Carolina?',
		'answer'   => 'For ordinary recreational boating negligence in South Carolina, the deadline is generally three years from the date of injury under S.C. Code § 15-3-530. If federal maritime law applies instead — for example, a crew member on a commercial vessel — the deadline may be different, so it is best to have your case reviewed promptly.',
	),
	array(
		'question' => 'Can I still recover if I was partly at fault for a boating crash?',
		'answer'   => 'Often yes. South Carolina uses a 51% modified comparative-fault rule, so you can recover as long as you were not more than 50% at fault, though your recovery is reduced by your share of fault. An attorney can help establish the other operator\'s responsibility.',
	),
	array(
		'question' => 'Is boating under the influence illegal in South Carolina?',
		'answer'   => 'Yes. Operating a boat while under the influence of alcohol or drugs is illegal in South Carolina, and BUI is a common factor in serious recreational-boating crashes. Evidence of impairment can strongly support an injury claim against the at-fault operator.',
	),
	array(
		'question' => 'How much does a Columbia on-the-water injury lawyer cost?',
		'answer'   => 'Roden Law handles Columbia boating and maritime injury cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /maritime-injury-lawyers/columbia-sc/ — post ID {$post_id}" );
