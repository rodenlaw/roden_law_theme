<?php
/**
 * Seeder: maritime-injury-lawyers × North Charleston, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /maritime-injury-lawyers/north-charleston-sc/
 * in place with rich, practice-specific, hyperlocal body content + FAQPage meta +
 * attorney attribution. Part of P2 row-9 BATCH 6 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * elements, compensation block, Key Takeaways, attorneys, case results, and the FAQ
 * accordion. post_content here ADDS what the template lacks: answer-first intro,
 * "why Roden Law", local port/terminal context, and federal maritime-law nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-maritime-north-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching maritime-injury-lawyers × North Charleston, SC...' );

$pillar = get_page_by_path( 'maritime-injury-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "maritime-injury-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents injured maritime workers in North Charleston, South Carolina</strong> and across the surrounding Lowcountry. North Charleston is home to major port terminals and heavy commercial activity along the Cooper River, and maritime injuries here are governed by <strong>federal law, not South Carolina's ordinary injury statutes</strong> — so the rules, remedies, and deadlines are different from a typical injury case. We handle every claim on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436126561">(843) 612-6561</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a North Charleston Maritime Injury Claim</h2>
<p>North Charleston's container terminals make it one of the busiest cargo-handling areas on the East Coast, and maritime injury law is a specialized federal field most personal-injury firms do not handle. What separates Roden Law is knowing which law applies to your job — the Jones Act, the Longshore and Harbor Workers' Compensation Act, or general maritime law — because that choice controls what you can recover. We serve dockworkers, terminal employees, and vessel crews throughout the North Charleston waterfront and the Palmetto Commerce Parkway industrial corridor.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We identify the right federal remedy</strong> — Jones Act, LHWCA, or general maritime law, so no source of recovery is missed.</li>
<li><strong>Direct attorney involvement</strong> — you work with your attorney, not a rotating desk of case managers.</li>
</ul>

<h2>Maritime Injuries at North Charleston Terminals</h2>
<p>Work on and around the port and river carries hazards ordinary jobsites do not. The cases our attorneys handle in North Charleston include:</p>
<ul>
<li><strong>Longshore and dockworker injuries</strong> — crush injuries, falls, and equipment incidents loading and unloading vessels at the terminals.</li>
<li><strong>Crew and vessel-worker injuries</strong> — seamen hurt aboard tugs, barges, and commercial vessels on the Cooper River and in the harbor.</li>
<li><strong>Slip, trip, and fall injuries</strong> on wet decks, gangways, and terminal surfaces.</li>
<li><strong>Cargo-handling and machinery injuries</strong> involving cranes, forklifts, and rigging.</li>
</ul>

<h2>Federal Maritime Law You Should Know</h2>
<p>Maritime injuries are not governed by South Carolina's three-year injury statute. Instead, several federal frameworks may apply. The <strong>Jones Act</strong> protects injured seamen — crew members of a vessel — and lets them sue their employer for negligence. The <strong>Longshore and Harbor Workers' Compensation Act (LHWCA)</strong> is a federal workers'-compensation system covering longshoremen, dockworkers, and harbor workers who load, unload, build, or repair vessels — a large share of the North Charleston port workforce. General maritime law adds remedies such as <strong>maintenance and cure</strong> (medical care and living expenses while you recover) and <strong>unseaworthiness</strong> (a vessel owner's duty to provide a reasonably safe ship). Each has its <strong>own filing deadline that differs from ordinary state-law cases</strong>, and those deadlines can be short — so call promptly rather than assume you have three years. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>.</p>
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
	'post_title'   => 'Maritime Injury Lawyers in North Charleston, SC',
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
		'question' => 'Who are the best maritime injury lawyers in North Charleston, SC?',
		'answer'   => 'Roden Law represents injured maritime workers in North Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every claim on a contingency fee basis — no fee unless we win. Call (843) 612-6561 for a free consultation.',
	),
	array(
		'question' => 'Is a maritime injury claim different from an ordinary injury case in South Carolina?',
		'answer'   => 'Yes. Maritime injuries are governed by federal law rather than South Carolina\'s ordinary injury statutes. Depending on your job, the Jones Act, the Longshore and Harbor Workers\' Compensation Act, or general maritime law may apply — each with its own remedies and deadlines that differ from a typical state-law case.',
	),
	array(
		'question' => 'Are North Charleston port workers covered by the Longshore Act?',
		'answer'   => 'Many are. The Longshore and Harbor Workers\' Compensation Act is a federal workers\'-compensation system covering longshoremen, dockworkers, and harbor workers who load, unload, build, or repair vessels — which describes much of the North Charleston terminal workforce. It provides medical and wage benefits separate from state workers\' compensation.',
	),
	array(
		'question' => 'What is the Jones Act?',
		'answer'   => 'The Jones Act is a federal law that protects seamen — crew members of a vessel — who are injured on the job. It allows an injured seaman to bring a claim against the employer for negligence, which is different from the no-fault benefits that cover most land-based workers.',
	),
	array(
		'question' => 'How long do I have to file a maritime injury claim?',
		'answer'   => 'Maritime deadlines are set by federal law and differ from South Carolina\'s three-year injury deadline — and some can be short. Because the applicable time limit depends on which law governs your job, it is important to have your case reviewed promptly rather than assume you have three years.',
	),
	array(
		'question' => 'How much does a North Charleston maritime injury lawyer cost?',
		'answer'   => 'Roden Law handles North Charleston maritime injury cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /maritime-injury-lawyers/north-charleston-sc/ — post ID {$post_id}" );
