<?php
/**
 * Seeder: workers-compensation-lawyers × Charleston, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub at /workers-compensation-lawyers/
 * charleston-sc/ in place with rich, practice-specific, hyperlocal body content
 * + FAQPage meta + attorney attribution. Part of P2 row-9 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do"
 * steps, negligence/elements, compensation block, Key Takeaways, attorneys, case
 * results, and FAQ accordion. post_content ADDS what the template lacks: answer-
 * first intro, "why Roden Law", local industry/claim drivers (port/hospitality),
 * and WC-specific SC deadline nuances — no duplication.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-wc-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching workers-compensation-lawyers × Charleston, SC...' );

$pillar = get_page_by_path( 'workers-compensation-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "workers-compensation-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents injured workers across Charleston and the Lowcountry</strong> — Mount Pleasant, West Ashley, James Island, Johns Island, and Daniel Island — in South Carolina workers' compensation claims. Workers' comp is a <strong>no-fault</strong> system, so you do not have to prove your employer was negligent to receive benefits. We handle every claim on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Our downtown office is at 127 King Street, Suite 200. Call <a href="tel:+18437908999">(843) 790-8999</a> for a free, confidential claim review.</p>

<h2>Why Choose Roden Law for a Charleston Workers' Comp Claim</h2>
<p>Charleston's biggest employers — the port, aerospace, hospitality, and healthcare — carry sophisticated insurance programs and defense counsel who dispute average weekly wage, cut off medical care, and push injured workers back to the job too soon. What separates Roden Law is direct attorney involvement — you work with your attorney, not a rotating desk of case managers — from the first injury report through your impairment rating and settlement. Our King Street office is steps from the Charleston County courthouse and the adjusters and defense firms who handle Lowcountry claims.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We fight benefit cutoffs</strong> — when the carrier stops your checks or denies surgery, we take it to the Commission.</li>
<li><strong>Full-value settlements</strong> — we account for your impairment rating, future medical needs, and lost earning capacity before you sign anything.</li>
</ul>

<h2>Common Lowcountry Workplace Injuries We Handle</h2>
<p>Charleston's economy concentrates several high-injury industries, each with its own claim pattern:</p>
<ul>
<li><strong>Port and maritime-adjacent injuries</strong> — crush, struck-by, and lifting injuries among longshore, warehouse, and drayage workers around the Charleston terminals and the container yards off I-526.</li>
<li><strong>Aerospace and manufacturing injuries</strong> — repetitive-motion, machinery, and fall injuries at large-plant and supplier operations.</li>
<li><strong>Hospitality and tourism injuries</strong> — burns, slips, and lifting injuries among hotel, restaurant, and event-venue staff across the peninsula.</li>
<li><strong>Healthcare-worker injuries</strong> — back, lifting, and needlestick injuries among staff at MUSC and other Lowcountry hospitals.</li>
</ul>

<h2>South Carolina Workers' Comp Deadlines Are Different — Don't Miss Them</h2>
<h3>Report to Your Employer Within 90 Days</h3>
<p>You must notify your employer of a work injury <strong>within 90 days under S.C. Code § 42-15-20</strong>. Report it in writing and keep a copy — verbal-only reports are a common ground for carriers to dispute a claim.</p>
<h3>File With the Commission Within 2 Years</h3>
<p>A workers' comp claim is filed with the <strong>South Carolina Workers' Compensation Commission within two years under S.C. Code § 42-15-40</strong> — <strong>not</strong> the three-year tort statute of limitations that applies to car-accident and other injury cases. Missing the two-year deadline can bar your benefits entirely.</p>
<h3>What Your Benefits Are Worth</h3>
<p>Temporary total disability pays <strong>66⅔% of your average weekly wage</strong>, subject to a statewide maximum that South Carolina resets each year. Permanent injuries are valued under the <strong>body-part schedule in S.C. Code § 42-9-30</strong> based on the impairment rating you receive at maximum medical improvement (MMI). Because your employer's insurer generally directs your medical care and chooses your physician, the rating that doctor assigns heavily influences your recovery — which is exactly where your own attorney matters most.</p>

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
	'name'           => 'charleston-sc',
	'posts_per_page' => 1,
) );

$postarr = array(
	'post_type'    => 'practice_area',
	'post_status'  => 'publish',
	'post_title'   => "Workers' Compensation Lawyers in Charleston, SC",
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
		'question' => "Who are the best workers' comp lawyers in Charleston, SC?",
		'answer'   => "Roden Law is a leading workers' compensation firm serving Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our downtown office at 127 King Street handles every claim on a contingency fee basis — no fee unless we win — and you work directly with your attorney. Call (843) 790-8999 for a free consultation.",
	),
	array(
		'question' => "How long do I have to file a workers' comp claim in South Carolina?",
		'answer'   => 'You must report the injury to your employer within 90 days (S.C. Code § 42-15-20) and file your claim with the South Carolina Workers\' Compensation Commission within two years (S.C. Code § 42-15-40). This two-year deadline is different from the three-year deadline for car-accident and other injury cases.',
	),
	array(
		'question' => 'I was hurt working at the port or a Charleston warehouse — is that workers\' comp or something else?',
		'answer'   => 'It depends on your job and employer. Many warehouse, drayage, and dockside jobs are covered by South Carolina workers\' compensation, but certain maritime and longshore workers fall under federal law instead. Roden Law can review your situation and make sure your claim is filed under the right system. Call (843) 790-8999 for a free review.',
	),
	array(
		'question' => 'How much does workers\' comp pay in South Carolina?',
		'answer'   => 'Temporary total disability pays two-thirds (66⅔%) of your average weekly wage, up to a statewide maximum that South Carolina sets each year. Permanent injuries are valued under the body-part schedule in S.C. Code § 42-9-30 based on your impairment rating at maximum medical improvement.',
	),
	array(
		'question' => 'Can I pick my own doctor for a Charleston workers\' comp injury?',
		'answer'   => 'Generally no — in South Carolina the employer or its insurer directs your medical care and chooses the treating physician. Because that doctor also assigns the impairment rating that drives your settlement, it is important to have an attorney who can challenge inadequate care or a lowball rating.',
	),
	array(
		'question' => 'What if my Charleston workers\' comp claim is denied or my checks stop?',
		'answer'   => 'A denial or benefit cutoff is not the end — you can request a hearing before the South Carolina Workers\' Compensation Commission. Roden Law regularly takes disputed claims to the Commission to restore medical care and wage benefits. Call (843) 790-8999 for a free review.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /workers-compensation-lawyers/charleston-sc/ — post ID {$post_id}" );
