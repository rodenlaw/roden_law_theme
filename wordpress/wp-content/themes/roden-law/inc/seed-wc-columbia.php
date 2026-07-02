<?php
/**
 * Seeder: workers-compensation-lawyers × Columbia, SC intersection page (ENRICH)
 *
 * UPDATES the existing (thin ~1.5KB templated stub) /workers-compensation-lawyers/
 * columbia-sc/ page in place with rich, practice-specific, hyperlocal body content
 * + FAQPage meta + attorney attribution. Part of P2 row-9 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do"
 * steps, negligence/elements, compensation block, Key Takeaways, attorneys, case
 * results, and the FAQ accordion. post_content here ADDS what the template lacks:
 * answer-first intro, "why Roden Law", local industry/claim drivers, and WC-specific
 * SC nuances (WC deadlines differ from the 3-yr tort SOL) — no duplication.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-wc-columbia.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching workers-compensation-lawyers × Columbia, SC...' );

$pillar = get_page_by_path( 'workers-compensation-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "workers-compensation-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents injured workers across Columbia and the Midlands</strong> — Lexington, Irmo, West Columbia, Cayce, Forest Acres, and Blythewood — in South Carolina workers' compensation claims. Workers' comp is a <strong>no-fault</strong> system, so you do not have to prove your employer did anything wrong to receive benefits. We handle every claim on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free, confidential claim review.</p>

<h2>Why Choose Roden Law for a Columbia Workers' Comp Claim</h2>
<p>Workers' compensation looks straightforward until the insurance carrier cuts off your medical care, disputes your average weekly wage, or pressures you to return before you are ready. What separates Roden Law is direct attorney involvement — you work with your attorney, not a rotating desk of case managers — from the first report of injury through your impairment rating and settlement. Our office at 1545 Sumter Street, Suite B sits in the downtown corridor minutes from the state offices where Midlands claims are administered, and we know the adjusters and defense firms that handle them.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We fight benefit cutoffs</strong> — when the carrier stops your checks or denies surgery, we take it to the Commission.</li>
<li><strong>Full-value settlements</strong> — we make sure your impairment rating, future medical needs, and lost earning capacity are all accounted for before you sign.</li>
</ul>

<h2>Common Midlands Workplace Injuries We Handle</h2>
<p>Columbia's economy is anchored by distribution and logistics, state government employment, healthcare, and construction, and each drives a distinct pattern of on-the-job injury:</p>
<ul>
<li><strong>Warehouse and distribution injuries</strong> — the I-77, I-20, and I-26 logistics corridors mean lifting injuries, forklift incidents, and repetitive-motion claims are among the most common in the Midlands.</li>
<li><strong>Healthcare-worker injuries</strong> — back and lifting injuries and needlesticks among staff at Prisma Health Richland and other large Midlands hospitals.</li>
<li><strong>Construction and roadwork injuries</strong> — falls, struck-by, and equipment injuries on Carolina Crossroads and other active Midlands projects.</li>
<li><strong>Public-employee and manufacturing injuries</strong> — claims involving state agencies, USC facilities, and area plants.</li>
</ul>

<h2>South Carolina Workers' Comp Deadlines Are Different — Don't Miss Them</h2>
<h3>Report to Your Employer Within 90 Days</h3>
<p>You must notify your employer of a work injury <strong>within 90 days under S.C. Code § 42-15-20</strong>. Do it in writing and keep a copy — verbal-only reports are a favorite ground for carriers to dispute a claim.</p>
<h3>File With the Commission Within 2 Years</h3>
<p>A workers' comp claim is filed with the <strong>South Carolina Workers' Compensation Commission within two years under S.C. Code § 42-15-40</strong> — this is <strong>not</strong> the three-year tort statute of limitations that applies to car-accident and other injury cases. Missing the two-year WC deadline can bar your benefits entirely.</p>
<h3>What Your Benefits Are Worth</h3>
<p>Temporary total disability pays <strong>66⅔% of your average weekly wage</strong>, subject to a statewide maximum that South Carolina resets each year (the current cap is set annually by the Commission). Permanent injuries are valued under the <strong>body-part schedule in S.C. Code § 42-9-30</strong>, based on the impairment rating you receive at maximum medical improvement (MMI). Because your employer's insurer generally directs your medical care, the choice of physician — and the rating that doctor assigns — heavily influences your recovery, which is exactly where having your own attorney matters most.</p>

<h2>Learn More About South Carolina Workers' Comp</h2>
<ul>
<li><a href="/resources/how-much-does-south-carolina-workers-comp-pay/">How much does South Carolina workers' comp pay?</a></li>
<li><a href="/resources/south-carolina-workers-comp-claim-denied/">What to do if your South Carolina workers' comp claim is denied</a></li>
<li><a href="/south-carolina-workers-compensation-lawyer/">South Carolina workers' compensation lawyer — statewide overview</a></li>
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
	'post_title'   => "Workers' Compensation Lawyers in Columbia, SC",
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
		'question' => "Who are the best workers' comp lawyers in Columbia, SC?",
		'answer'   => "Roden Law is a leading workers' compensation firm serving Columbia and the Midlands, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles every claim on a contingency fee basis — no fee unless we win — and you work directly with your attorney. Call (803) 219-2816 for a free consultation.",
	),
	array(
		'question' => "How long do I have to file a workers' comp claim in South Carolina?",
		'answer'   => 'You must report the injury to your employer within 90 days (S.C. Code § 42-15-20) and file your claim with the South Carolina Workers\' Compensation Commission within two years (S.C. Code § 42-15-40). This two-year deadline is different from the three-year deadline for car-accident and other injury cases, so do not assume you have three years.',
	),
	array(
		'question' => "Do I have to prove my employer was at fault to get workers' comp?",
		'answer'   => 'No. South Carolina workers\' compensation is a no-fault system. As long as you were injured in the course and scope of your job, you are generally entitled to benefits regardless of who was at fault — including cases where the injury was partly your own doing.',
	),
	array(
		'question' => 'How much does workers\' comp pay in South Carolina?',
		'answer'   => 'Temporary total disability pays two-thirds (66⅔%) of your average weekly wage, up to a statewide maximum that South Carolina sets each year. Permanent injuries are valued under the body-part schedule in S.C. Code § 42-9-30 based on your impairment rating at maximum medical improvement.',
	),
	array(
		'question' => 'Can I pick my own doctor for a Columbia workers\' comp injury?',
		'answer'   => 'Generally no — in South Carolina the employer or its insurer directs your medical care and chooses the treating physician. Because that doctor also assigns the impairment rating that drives your settlement, it is important to have an attorney who can challenge inadequate care or a lowball rating.',
	),
	array(
		'question' => 'What if my Columbia workers\' comp claim is denied or my checks stop?',
		'answer'   => 'A denial or a benefit cutoff is not the end — you can request a hearing before the South Carolina Workers\' Compensation Commission. Roden Law regularly takes disputed claims to the Commission to restore medical care and wage benefits. Call (803) 219-2816 for a free review of your denial.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /workers-compensation-lawyers/columbia-sc/ — post ID {$post_id}" );
