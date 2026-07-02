<?php
/**
 * Seeder: spinal-cord-injury-lawyers × North Charleston, SC intersection page (ENRICH)
 *
 * UPDATES the existing templated stub /spinal-cord-injury-lawyers/north-charleston-sc/
 * page in place with rich, practice-specific, hyperlocal body content + FAQPage meta
 * + attorney attribution. Part of P2 row-9 BATCH 4 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS what the template lacks: answer-first intro,
 * "why Roden Law", local hazards/venues, and spinal-cord-specific SC nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-spinal-north-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching spinal-cord-injury-lawyers × North Charleston, SC...' );

$pillar = get_page_by_path( 'spinal-cord-injury-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "spinal-cord-injury-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people with catastrophic spinal cord injuries in North Charleston, South Carolina</strong> and across the Lowcountry. With its interstate junctions, Boeing and aerospace manufacturing, the port, and heavy industrial traffic, North Charleston sees some of the region's most severe spinal trauma — and a paraplegia or quadriplegia diagnosis often means a lifetime of medical need measured in the millions. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436126561">(843) 612-6561</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a North Charleston Spinal Cord Injury Claim</h2>
<p>Spinal cord cases are won on the numbers behind the injury — the life-care plan, future medical and attendant-care costs, and lost earning capacity — and insurers work hard to undervalue each one. What separates Roden Law is direct attorney involvement paired with the medical and economic experts needed to prove a lifetime of need. We prepare every claim for the Charleston County Circuit Court, which is what moves insurers to pay full value.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to build your claim.</li>
<li><strong>Life-care planning</strong> — physicians, life-care planners, and economists document every future cost.</li>
<li><strong>Full-value focus</strong> — future medical care, 24/7 attendant care, home and vehicle modifications, and lost earning capacity are all accounted for before any settlement.</li>
</ul>

<h2>How North Charleston Spinal Cord Injuries Happen</h2>
<p>North Charleston's highways, industry, and port drive the catastrophic-injury cases our attorneys see most:</p>
<ul>
<li><strong>Interstate crashes</strong> at the I-26 / I-526 junction and along the Palmetto Commerce Parkway freight corridor, where truck and high-speed impacts cause the most severe spinal trauma.</li>
<li><strong>Industrial and manufacturing injuries</strong> at Boeing, aerospace suppliers, and warehouse and distribution sites.</li>
<li><strong>Port and dock injuries</strong> involving heavy equipment, containers, and falls from height.</li>
<li><strong>Falls</strong> from heights on construction sites and in apartment complexes and commercial properties.</li>
</ul>
<p>Severe crash victims are often stabilized at the Medical University of South Carolina (MUSC), the Lowcountry's Level I trauma center, before beginning long-term rehabilitation.</p>

<h2>South Carolina Spinal Cord Injury Law You Should Know</h2>
<p>South Carolina places <strong>no cap on compensatory damages</strong> in ordinary injury cases, which matters enormously for a spinal cord injury where the economic losses alone can be enormous. The deadline to file is generally <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, and South Carolina's <strong>51% modified comparative-fault</strong> rule lets you recover as long as you are not more than 50% at fault. If the injury happened at work, South Carolina workers' compensation provides <strong>lifetime benefits</strong> for paraplegia, quadriplegia, or physical brain damage — an important exception to the usual 500-week cap. Prompt medical documentation is critical to proving the full extent of the injury. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>, and if a spinal injury proves fatal, our <a href="/south-carolina-wrongful-death-lawyer/">South Carolina wrongful death lawyers</a> can help.</p>
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
	'post_title'   => 'Spinal Cord Injury Lawyers in North Charleston, SC',
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
		'question' => 'Who are the best spinal cord injury lawyers in North Charleston, SC?',
		'answer'   => 'Roden Law is a leading catastrophic-injury firm serving North Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every case on a contingency fee basis — no fee unless we win — and retain life-care planners and economists to prove full value. Call (843) 612-6561 for a free consultation.',
	),
	array(
		'question' => 'How much is a North Charleston spinal cord injury case worth?',
		'answer'   => 'It depends on the severity of the injury, but spinal cord cases are among the highest-value injury claims because the lifetime costs — future medical care, 24/7 attendant care, home and vehicle modifications, and lost earning capacity — can reach into the millions. South Carolina places no cap on compensatory damages in ordinary injury cases, so a proper life-care plan is essential to recovering full value.',
	),
	array(
		'question' => 'Is there a cap on spinal cord injury damages in South Carolina?',
		'answer'   => 'No. In ordinary personal-injury cases South Carolina does not cap compensatory damages, so there is no ceiling on the economic and non-economic losses a spinal cord injury victim can recover. (Different rules apply to medical malpractice and to claims against government entities.)',
	),
	array(
		'question' => 'How long do I have to file a spinal cord injury claim in South Carolina?',
		'answer'   => 'The general deadline is three years from the date of injury under S.C. Code § 15-3-530. Because proving a lifetime of future medical need takes time to develop, it is best to have your case reviewed as soon as possible.',
	),
	array(
		'question' => 'What if my spinal cord injury happened at work in North Charleston?',
		'answer'   => 'South Carolina workers\' compensation provides lifetime benefits for paraplegia, quadriplegia, or physical brain damage — an exception to the usual 500-week limit. With North Charleston\'s manufacturing, port, and warehouse work, you may also have a third-party claim against someone other than your employer. Roden Law can evaluate both paths.',
	),
	array(
		'question' => 'How much does a North Charleston spinal cord injury lawyer cost?',
		'answer'   => 'Roden Law handles North Charleston spinal cord injury cases on a contingency fee basis. You pay no attorney fees and no upfront costs — including the cost of the medical and life-care experts needed to build your case — and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /spinal-cord-injury-lawyers/north-charleston-sc/ — post ID {$post_id}" );
