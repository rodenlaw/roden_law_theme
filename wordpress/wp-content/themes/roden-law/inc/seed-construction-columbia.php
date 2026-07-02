<?php
/**
 * Seeder: construction-accident-lawyers × Columbia, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /construction-accident-lawyers/columbia-sc/
 * in place with rich, practice-specific, hyperlocal body content + FAQPage meta +
 * attorney attribution. Part of P2 row-9 BATCH 6 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * elements, compensation block, Key Takeaways, attorneys, case results, and the FAQ
 * accordion. post_content here ADDS the answer-first intro, "why Roden Law", local
 * industry/roadwork context, and the comp-vs-third-party construction-injury nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-construction-columbia.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching construction-accident-lawyers × Columbia, SC...' );

$pillar = get_page_by_path( 'construction-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "construction-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents injured construction workers in Columbia, South Carolina</strong> and throughout the Midlands — Lexington, Irmo, West Columbia, Cayce, and Forest Acres. A construction injury often gives you <strong>two separate claims</strong>: a no-fault workers' compensation claim against your employer, and a third-party lawsuit against another company whose negligence caused the injury. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Columbia Construction Accident Claim</h2>
<p>The single most valuable thing a construction-injury lawyer does is look past the workers' comp claim to find a third-party case — because that is where pain-and-suffering and full lost wages come from, which comp does not pay. What separates Roden Law is investigating every party on the jobsite: subcontractors, the general contractor, the property owner, and equipment or product manufacturers. Our office at 1545 Sumter Street, Suite B sits in downtown Columbia, minutes from the Richland County Circuit Court and the Midlands' busiest roadwork and building projects.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We find the third-party case</strong> — recovering the pain-and-suffering and full lost wages comp does not pay.</li>
<li><strong>Direct attorney involvement</strong> — you work with your attorney, not a rotating desk of case managers.</li>
</ul>

<h2>Columbia Construction and Roadwork Hazards We Handle</h2>
<p>Major highway projects like the Carolina Crossroads reconstruction at "Malfunction Junction," plus commercial and residential building across the Midlands, drive the "fatal four" hazards our attorneys see most:</p>
<ul>
<li><strong>Falls</strong> from scaffolding, ladders, and roofs — the leading cause of construction deaths.</li>
<li><strong>Struck-by</strong> injuries from falling materials, passing traffic in work zones, and moving equipment.</li>
<li><strong>Caught-in/between</strong> injuries involving machinery, trenches, and collapsing structures.</li>
<li><strong>Electrocutions</strong> from contact with live wires and unsafe temporary power.</li>
</ul>

<h2>South Carolina Construction Injury Law You Should Know</h2>
<p>An injured construction worker in South Carolina usually has a <strong>workers' compensation claim</strong> — a no-fault benefit against the employer that is the "exclusive remedy" against that employer — and, in many cases, a separate <strong>third-party liability claim</strong> against a non-employer whose negligence contributed to the injury. The third-party claim can recover pain and suffering and full lost wages that comp does not. Be aware of South Carolina's <strong>"statutory employer" doctrine (S.C. Code § 42-1-400)</strong>, which can extend comp immunity up the contractor chain and affect who can be sued. <strong>OSHA violations</strong> are strong evidence of negligence. Comp deadlines are strict — report the injury within 90 days (S.C. Code § 42-15-20) and file within two years (S.C. Code § 42-15-40) — while the third-party lawsuit generally follows the <strong>three-year deadline under S.C. Code § 15-3-530</strong>. Learn more from our <a href="/south-carolina-workers-compensation-lawyer/">South Carolina workers' compensation overview</a>, <a href="/resources/how-much-does-south-carolina-workers-comp-pay/">how much South Carolina workers' comp pays</a>, and our <a href="/resources/south-carolina-comparative-negligence/">comparative negligence guide</a>.</p>
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
	'post_title'   => 'Construction Accident Lawyers in Columbia, SC',
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
		'question' => 'Who are the best construction accident lawyers in Columbia, SC?',
		'answer'   => 'Roden Law represents injured construction workers in Columbia and the Midlands, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles every case on a contingency fee basis — no fee unless we win. Call (803) 219-2816 for a free consultation.',
	),
	array(
		'question' => 'Can I sue if I was hurt on a Columbia construction site?',
		'answer'   => 'Often yes. Beyond your no-fault workers\' compensation claim against your employer, you may have a third-party lawsuit against a non-employer — such as a subcontractor, general contractor, property owner, or equipment manufacturer — whose negligence caused the injury. That third-party claim can recover pain and suffering and full lost wages that workers\' comp does not.',
	),
	array(
		'question' => 'What if I was hurt in a Midlands highway work zone?',
		'answer'   => 'Work-zone injuries on projects like Carolina Crossroads can involve multiple companies and passing traffic. In addition to your workers\' comp claim, you may have a third-party claim against a contractor, a subcontractor, or a negligent driver. Roden Law investigates every party to identify the full recovery available.',
	),
	array(
		'question' => 'What is the "statutory employer" rule in South Carolina?',
		'answer'   => 'Under S.C. Code § 42-1-400, the workers\'-compensation "statutory employer" doctrine can extend an employer\'s comp immunity up the contractor chain, which affects which companies can be sued in a third-party claim. Sorting out who is a statutory employer is an important part of building a construction case, and it is best handled by an attorney.',
	),
	array(
		'question' => 'How long do I have to file a construction injury claim in South Carolina?',
		'answer'   => 'Workers\' comp has strict deadlines — report the injury to your employer within 90 days (S.C. Code § 42-15-20) and file within two years (S.C. Code § 42-15-40). A third-party lawsuit generally follows the three-year deadline under S.C. Code § 15-3-530. Because these run separately, it is important to act quickly.',
	),
	array(
		'question' => 'How much does a Columbia construction accident lawyer cost?',
		'answer'   => 'Roden Law handles Columbia construction accident cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /construction-accident-lawyers/columbia-sc/ — post ID {$post_id}" );
