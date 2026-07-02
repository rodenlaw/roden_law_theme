<?php
/**
 * Seeder: maritime-injury-lawyers × Charleston, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /maritime-injury-lawyers/charleston-sc/
 * in place with rich, practice-specific, hyperlocal body content + FAQPage meta +
 * attorney attribution. Part of P2 row-9 BATCH 6 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * elements, compensation block, Key Takeaways, attorneys, case results, and the FAQ
 * accordion. post_content here ADDS what the template lacks: answer-first intro,
 * "why Roden Law", local port/venue context, and federal maritime-law nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-maritime-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching maritime-injury-lawyers × Charleston, SC...' );

$pillar = get_page_by_path( 'maritime-injury-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "maritime-injury-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents injured maritime workers in Charleston, South Carolina</strong> and throughout the Lowcountry — Mount Pleasant, Summerville, Goose Creek, and North Charleston. Maritime injuries are governed by <strong>federal law, not South Carolina's ordinary injury statutes</strong>, so the rules, remedies, and deadlines are different from a typical car or slip-and-fall case. We handle every claim on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18437908999">(843) 790-8999</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Charleston Maritime Injury Claim</h2>
<p>The Port of Charleston is one of the busiest container ports in the United States, and maritime injury law is a specialized federal field that most personal-injury firms do not handle. What separates Roden Law is knowing which law applies to your job — the Jones Act, the Longshore and Harbor Workers' Compensation Act, or general maritime law — because that choice controls what you can recover. Our office at 127 King Street sits in downtown Charleston, minutes from the waterfront terminals where many of these injuries happen.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We identify the right federal remedy</strong> — Jones Act, LHWCA, or general maritime law, so no source of recovery is missed.</li>
<li><strong>Direct attorney involvement</strong> — you work with your attorney, not a rotating desk of case managers.</li>
</ul>

<h2>Maritime Injuries Around the Port of Charleston</h2>
<p>Work on and around the water carries hazards that ordinary jobsites do not. The cases our attorneys handle in the Charleston harbor and along the I-526 corridor include:</p>
<ul>
<li><strong>Longshore and dockworker injuries</strong> — crush injuries, falls, and equipment incidents loading and unloading vessels at the container terminals.</li>
<li><strong>Crew and vessel-worker injuries</strong> — seamen hurt aboard tugs, barges, and commercial vessels operating in the harbor and coastal waters.</li>
<li><strong>Slip, trip, and fall injuries</strong> on wet decks, gangways, and terminal surfaces.</li>
<li><strong>Cargo-handling and machinery injuries</strong> involving cranes, forklifts, and rigging.</li>
</ul>

<h2>Federal Maritime Law You Should Know</h2>
<p>Maritime injuries are not governed by South Carolina's three-year injury statute. Instead, several federal frameworks may apply. The <strong>Jones Act</strong> protects injured seamen — crew members of a vessel — and lets them sue their employer for negligence. The <strong>Longshore and Harbor Workers' Compensation Act (LHWCA)</strong> is a federal workers'-compensation system covering longshoremen, dockworkers, and harbor workers who load, unload, build, or repair vessels. General maritime law adds remedies such as <strong>maintenance and cure</strong> (medical care and living expenses while you recover) and <strong>unseaworthiness</strong> (a vessel owner's duty to provide a reasonably safe ship). Each of these has its <strong>own filing deadline that differs from ordinary state-law cases</strong>, and those deadlines can be short — so it is important to call promptly rather than assume you have three years. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>.</p>
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
	'post_title'   => 'Maritime Injury Lawyers in Charleston, SC',
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
		'question' => 'Who are the best maritime injury lawyers in Charleston, SC?',
		'answer'   => 'Roden Law represents injured maritime workers in Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Charleston office at 127 King Street handles every claim on a contingency fee basis — no fee unless we win. Call (843) 790-8999 for a free consultation.',
	),
	array(
		'question' => 'Is a maritime injury claim different from an ordinary injury case in South Carolina?',
		'answer'   => 'Yes. Maritime injuries are governed by federal law rather than South Carolina\'s ordinary injury statutes. Depending on your job, the Jones Act, the Longshore and Harbor Workers\' Compensation Act, or general maritime law may apply — each with its own remedies and deadlines that differ from a typical state-law case.',
	),
	array(
		'question' => 'What is the Jones Act?',
		'answer'   => 'The Jones Act is a federal law that protects seamen — crew members of a vessel — who are injured on the job. It allows an injured seaman to bring a claim against the employer for negligence, which is different from the no-fault workers\' compensation that covers most land-based workers.',
	),
	array(
		'question' => 'What is the Longshore and Harbor Workers\' Compensation Act?',
		'answer'   => 'The LHWCA is a federal workers\'-compensation system that covers longshoremen, dockworkers, harbor workers, and others who load, unload, build, or repair vessels — including many workers at the Port of Charleston terminals. It provides medical care and wage benefits, and it is separate from state workers\' compensation.',
	),
	array(
		'question' => 'How long do I have to file a maritime injury claim?',
		'answer'   => 'Maritime deadlines are set by federal law and differ from South Carolina\'s three-year injury deadline — and some can be short. Because the applicable time limit depends on which law governs your job, it is important to have your case reviewed promptly rather than assume you have three years.',
	),
	array(
		'question' => 'How much does a Charleston maritime injury lawyer cost?',
		'answer'   => 'Roden Law handles Charleston maritime injury cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /maritime-injury-lawyers/charleston-sc/ — post ID {$post_id}" );
