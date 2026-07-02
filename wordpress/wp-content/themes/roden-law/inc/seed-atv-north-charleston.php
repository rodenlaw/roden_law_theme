<?php
/**
 * Seeder: atv-side-by-side-accident-lawyers × North Charleston, SC intersection page (ENRICH)
 *
 * UPDATES the existing templated stub /atv-side-by-side-accident-lawyers/north-charleston-sc/
 * in place with rich, practice-specific, hyperlocal body content + FAQPage meta + attorney
 * attribution. Part of P2 row-9 BATCH 7 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS only what the template lacks.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-atv-north-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching atv-side-by-side-accident-lawyers × North Charleston, SC...' );

$pillar = get_page_by_path( 'atv-side-by-side-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "atv-side-by-side-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents ATV and side-by-side (UTV) crash victims across North Charleston, South Carolina</strong> and the surrounding Lowcountry — Hanahan, Goose Creek, Ladson, and Summerville. Rollovers, ejections, and passenger injuries — often to children — make off-road vehicle crashes uniquely dangerous. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436126561">(843) 612-6561</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a North Charleston ATV or UTV Claim</h2>
<p>Off-road vehicle cases turn on how the crash happened — a rollover caused by a defect, an operator's negligence, or a hazard on someone's land — and insurers push to blame the rider. What separates Roden Law is the investigation and expert work needed to determine whether the vehicle, the operator, or a property owner is responsible.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We determine the cause</strong> — a defective vehicle, a negligent operator, and an unsafe property each point to a different responsible party and policy.</li>
<li><strong>Full-value focus</strong> — ATV and UTV crashes often cause head, spinal, and crush injuries, and we account for all of it before any settlement.</li>
</ul>

<h2>Off-Road Crash Risks in the North Charleston Area</h2>
<p>ATVs and side-by-sides are ridden across the rural and semi-rural land surrounding North Charleston — on farmland, hunting tracts, wooded trails, and large lots in the outer communities. Utility side-by-sides are also common on worksites and industrial properties in the area. Rollovers on uneven terrain, ejections when riders are not secured, and passenger injuries (especially to children carried on machines not designed for them) are the most serious patterns we see. Because these vehicles lack the crash protection of a car, even a low-speed tip-over can cause catastrophic injuries.</p>

<h2>South Carolina ATV and Side-by-Side Law You Should Know</h2>
<p>When a rollover or crash results from a design or manufacturing defect — an unstable frame, a failed restraint, or a defective braking or steering system — the claim can sound in <strong>product liability</strong>, and South Carolina recognizes <strong>strict liability for defective products under S.C. Code § 15-73-10</strong>. South Carolina also regulates all-terrain vehicles under <strong>S.C. Code Title 50, Chapter 26</strong>, which includes safety requirements such as helmet and eye-protection and age-related rules for minor operators. The general deadline to file is <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, South Carolina follows <strong>modified comparative negligence</strong> (you can recover as long as you are 50% or less at fault), and there is <strong>no cap on compensatory damages</strong> in ordinary injury cases. Learn more on our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a> guide.</p>
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
	'post_title'   => 'ATV & Side-by-Side Accident Lawyers in North Charleston, SC',
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
		'question' => 'Who are the best ATV accident lawyers in North Charleston, SC?',
		'answer'   => 'Roden Law is a leading personal-injury firm serving North Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every case on a contingency fee basis — no fee unless we win. Call (843) 612-6561 for a free consultation.',
	),
	array(
		'question' => 'Who is responsible for an ATV or side-by-side crash in South Carolina?',
		'answer'   => 'It depends on the cause. A defective vehicle can support a product-liability claim against the manufacturer; a negligent operator can be liable for how the machine was driven; and an unsafe condition on land can support a premises-liability claim. Roden Law investigates the crash to identify every responsible party and applicable policy.',
	),
	array(
		'question' => 'What if I was hurt on a utility side-by-side at work?',
		'answer'   => 'A work-related off-road vehicle injury is generally covered by South Carolina workers\' compensation. If a defective machine or a third party (not your employer) caused the crash, you may also have a separate injury claim. Roden Law reviews both paths at no cost.',
	),
	array(
		'question' => 'Can I sue if a defect caused my ATV to roll over?',
		'answer'   => 'Possibly. If an unstable design, a failed restraint, or a defective brake or steering system contributed to the rollover, the claim can sound in product liability. South Carolina recognizes strict liability for defective products under S.C. Code § 15-73-10, so the manufacturer may be responsible without proof of ordinary negligence.',
	),
	array(
		'question' => 'What are the ATV rules for minors in South Carolina?',
		'answer'   => 'South Carolina regulates all-terrain vehicles under S.C. Code Title 50, Chapter 26, which includes safety requirements such as helmet and eye protection and age-related restrictions on minor operators. A violation of these safety rules can be relevant evidence in an injury case.',
	),
	array(
		'question' => 'How long do I have to file an ATV injury claim in South Carolina?',
		'answer'   => 'The general deadline is three years from the date of injury under S.C. Code § 15-3-530. It is best to have your case reviewed as soon as possible so the vehicle and the crash scene can be preserved and examined.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /atv-side-by-side-accident-lawyers/north-charleston-sc/ — post ID {$post_id}" );
