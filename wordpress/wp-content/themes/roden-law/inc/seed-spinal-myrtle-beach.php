<?php
/**
 * Seeder: spinal-cord-injury-lawyers × Myrtle Beach, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /spinal-cord-injury-lawyers/myrtle-beach-sc/
 * page in place with rich, practice-specific, hyperlocal body content + FAQPage meta
 * + attorney attribution. Part of P2 row-9 BATCH 4 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS what the template lacks: answer-first intro,
 * "why Roden Law", local hazards/venues, and spinal-cord-specific SC nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-spinal-myrtle-beach.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching spinal-cord-injury-lawyers × Myrtle Beach, SC...' );

$pillar = get_page_by_path( 'spinal-cord-injury-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "spinal-cord-injury-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people with catastrophic spinal cord injuries in Myrtle Beach and across the Grand Strand</strong> — Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and Georgetown. A spinal cord injury is often permanent, and the lifetime cost of paraplegia or quadriplegia can reach into the millions, so getting the value right is everything. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Grand Strand Spinal Cord Injury Claim</h2>
<p>Spinal cord cases are decided by the numbers behind the injury — the life-care plan, the future medical and attendant-care costs, and the lost earning capacity — and insurers work hard to undervalue every line of it. What separates Roden Law is direct attorney involvement paired with the medical and economic experts needed to prove a lifetime of need. We prepare Horry County cases for the courthouse in Conway and handle Georgetown County matters as well.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to build your claim.</li>
<li><strong>Life-care planning</strong> — we retain physicians, life-care planners, and economists so no future cost is left off the table.</li>
<li><strong>Full-value focus</strong> — future medical care, 24/7 attendant care, home and vehicle modifications, and lost earning capacity are all accounted for before any settlement.</li>
</ul>

<h2>How Grand Strand Spinal Cord Injuries Happen</h2>
<p>The Grand Strand's tourist traffic, highways, and water recreation drive the catastrophic-injury cases our attorneys see most:</p>
<ul>
<li><strong>Highway crashes</strong> on US-17 (Kings Highway / the Bypass) and SC-31 (Carolina Bays Parkway), where heavy seasonal and truck traffic causes the most severe spinal trauma.</li>
<li><strong>Boating, diving, and watercraft injuries</strong> in the Atlantic, the Intracoastal Waterway, and area inlets.</li>
<li><strong>Falls</strong> — from heights on construction sites, at hotels and resorts, and on unsafe property.</li>
<li><strong>Tourism and recreation injuries</strong> tied to the area's heavy seasonal visitor population.</li>
</ul>

<h2>South Carolina Spinal Cord Injury Law You Should Know</h2>
<p>South Carolina places <strong>no cap on compensatory damages</strong> in ordinary injury cases, which matters enormously for a spinal cord injury where the economic losses alone can be enormous. The deadline to file is generally <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, and South Carolina's <strong>51% modified comparative-fault</strong> rule lets you recover as long as you are not more than 50% at fault. If the injury happened at work, South Carolina workers' compensation provides <strong>lifetime benefits</strong> for paraplegia, quadriplegia, or physical brain damage — an important exception to the usual 500-week cap. Prompt medical documentation is critical to proving the full extent of the injury. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>, and if a spinal injury proves fatal, our <a href="/south-carolina-wrongful-death-lawyer/">South Carolina wrongful death lawyers</a> can help.</p>
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
	'post_title'   => 'Spinal Cord Injury Lawyers in Myrtle Beach, SC',
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
		'question' => 'Who are the best spinal cord injury lawyers in Myrtle Beach, SC?',
		'answer'   => 'Roden Law is a leading catastrophic-injury firm serving Myrtle Beach and the Grand Strand, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every case on a contingency fee basis — no fee unless we win — and retain life-care planners and economists to prove full value. Call (843) 612-1980 for a free consultation.',
	),
	array(
		'question' => 'How much is a Myrtle Beach spinal cord injury case worth?',
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
		'question' => 'What if my spinal cord injury happened at work near Myrtle Beach?',
		'answer'   => 'South Carolina workers\' compensation provides lifetime benefits for paraplegia, quadriplegia, or physical brain damage — an exception to the usual 500-week limit. Depending on the facts, you may also have a third-party claim against someone other than your employer. Roden Law can evaluate both paths.',
	),
	array(
		'question' => 'How much does a Myrtle Beach spinal cord injury lawyer cost?',
		'answer'   => 'Roden Law handles Grand Strand spinal cord injury cases on a contingency fee basis. You pay no attorney fees and no upfront costs — including the cost of the medical and life-care experts needed to build your case — and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /spinal-cord-injury-lawyers/myrtle-beach-sc/ — post ID {$post_id}" );
