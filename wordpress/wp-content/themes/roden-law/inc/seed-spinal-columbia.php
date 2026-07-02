<?php
/**
 * Seeder: spinal-cord-injury-lawyers × Columbia, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /spinal-cord-injury-lawyers/columbia-sc/
 * page in place with rich, practice-specific, hyperlocal body content + FAQPage meta
 * + attorney attribution. Part of P2 row-9 BATCH 4 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS what the template lacks: answer-first intro,
 * "why Roden Law", local hazards/venues, and spinal-cord-specific SC nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-spinal-columbia.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching spinal-cord-injury-lawyers × Columbia, SC...' );

$pillar = get_page_by_path( 'spinal-cord-injury-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "spinal-cord-injury-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people with catastrophic spinal cord injuries in Columbia, South Carolina</strong> and throughout the Midlands — Lexington, Irmo, West Columbia, Cayce, and Forest Acres. A spinal cord injury is often permanent, and the lifetime cost of paraplegia or quadriplegia can reach into the millions, so getting the value right is everything. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Columbia Spinal Cord Injury Claim</h2>
<p>Spinal cord cases are decided by the numbers behind the injury — the life-care plan, the future medical and attendant-care costs, and the lost earning capacity — and insurers work hard to undervalue every line of it. What separates Roden Law is direct attorney involvement paired with the medical and economic experts needed to prove a lifetime of need. Our office at 1545 Sumter Street, Suite B sits in the downtown corridor minutes from the Richland County Circuit Court and Columbia's major trauma and rehabilitation centers.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to build your claim.</li>
<li><strong>Life-care planning</strong> — we retain physicians, life-care planners, and economists so no future cost is left off the table.</li>
<li><strong>Full-value focus</strong> — future medical care, 24/7 attendant care, home and vehicle modifications, and lost earning capacity are all accounted for before any settlement.</li>
</ul>

<h2>How Columbia Spinal Cord Injuries Happen</h2>
<p>The Midlands' converging interstates and worksites drive the catastrophic-injury cases our attorneys see most:</p>
<ul>
<li><strong>Highway crashes</strong> at "Malfunction Junction" (the I-20 / I-26 / I-126 interchange) and along I-77, where high-speed and truck impacts cause the most severe spinal trauma.</li>
<li><strong>Falls</strong> — from heights on construction sites, in apartment complexes, and on unsafe property.</li>
<li><strong>Workplace injuries</strong> at Midlands distribution centers, plants, and warehouses.</li>
<li><strong>Diving and recreational injuries</strong> at area lakes and rivers.</li>
</ul>
<p>Severe crash victims are often stabilized at Prisma Health Richland, a Midlands trauma center, before beginning long-term rehabilitation.</p>

<h2>South Carolina Spinal Cord Injury Law You Should Know</h2>
<p>South Carolina places <strong>no cap on compensatory damages</strong> in ordinary injury cases, which matters enormously for a spinal cord injury where the economic losses alone can be enormous. The deadline to file is generally <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, and South Carolina's <strong>51% modified comparative-fault</strong> rule lets you recover as long as you are not more than 50% at fault. If the injury happened at work, South Carolina workers' compensation provides <strong>lifetime benefits</strong> for paraplegia, quadriplegia, or physical brain damage — an important exception to the usual 500-week cap. Prompt medical documentation is critical to proving the full extent of the injury. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>, and if a spinal injury proves fatal, our <a href="/south-carolina-wrongful-death-lawyer/">South Carolina wrongful death lawyers</a> can help.</p>
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
	'post_title'   => 'Spinal Cord Injury Lawyers in Columbia, SC',
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
		'question' => 'Who are the best spinal cord injury lawyers in Columbia, SC?',
		'answer'   => 'Roden Law is a leading catastrophic-injury firm serving Columbia and the Midlands, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles every case on a contingency fee basis — no fee unless we win — and retains life-care planners and economists to prove full value. Call (803) 219-2816 for a free consultation.',
	),
	array(
		'question' => 'How much is a Columbia spinal cord injury case worth?',
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
		'question' => 'What if my spinal cord injury happened at work in Columbia?',
		'answer'   => 'South Carolina workers\' compensation provides lifetime benefits for paraplegia, quadriplegia, or physical brain damage — an exception to the usual 500-week limit. Depending on the facts, you may also have a third-party claim against someone other than your employer. Roden Law can evaluate both paths.',
	),
	array(
		'question' => 'How much does a Columbia spinal cord injury lawyer cost?',
		'answer'   => 'Roden Law handles Columbia spinal cord injury cases on a contingency fee basis. You pay no attorney fees and no upfront costs — including the cost of the medical and life-care experts needed to build your case — and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /spinal-cord-injury-lawyers/columbia-sc/ — post ID {$post_id}" );
