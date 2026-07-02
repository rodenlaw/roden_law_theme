<?php
/**
 * Seeder: burn-injury-lawyers × Charleston, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /burn-injury-lawyers/charleston-sc/ in place
 * with rich, practice-specific, hyperlocal body content + FAQPage meta + attorney
 * attribution. Part of P2 row-9 BATCH 7 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS only what the template lacks.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-burn-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching burn-injury-lawyers × Charleston, SC...' );

$pillar = get_page_by_path( 'burn-injury-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "burn-injury-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents burn-injury victims across Charleston, South Carolina</strong> and the Lowcountry — Mount Pleasant, Summerville, Goose Creek, and the peninsula. Burn injuries are among the most catastrophic and painful injuries a person can suffer, often requiring skin grafts, multiple surgeries, and lifelong care for scarring and disfigurement. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18437908999">(843) 790-8999</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Charleston Burn Injury Claim</h2>
<p>Serious burn cases are expensive to prove and expensive to treat, and insurers know it — they routinely dispute how a fire or explosion started and push to settle before the full cost of future skin-graft revisions and scar-management care is known. What separates Roden Law is the investigation and expert work needed to trace the cause and document lifetime needs. Our Charleston office at 127 King Street, Suite 200 sits on the peninsula minutes from the Charleston County Circuit Court.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We trace the cause</strong> — defective products, unsafe premises, and workplace hazards each point to a different responsible party and a different insurance policy.</li>
<li><strong>Full lifetime value</strong> — disfigurement, future surgeries, and long-term care often drive the value of a burn case, and we account for all of it before any settlement.</li>
</ul>

<h2>Common Causes of Burn Injuries in the Charleston Area</h2>
<p>Burn injuries in the Lowcountry arise from fires and explosions, scalding liquids and steam, chemical exposure, electrical contact, and defective consumer products such as water heaters, space heaters, and lithium-ion batteries. Restaurant and hospitality workers along the peninsula tourism corridor face scald and grease-fire risks, and residential fires in older Charleston housing stock can involve faulty wiring or appliances. Identifying whether a burn stems from a defective product, an unsafe premises, or a workplace hazard is the first and most important step in a Charleston burn case.</p>

<h2>South Carolina Burn Injury Law You Should Know</h2>
<p>Many burn cases sound in <strong>product liability</strong> — South Carolina recognizes <strong>strict liability for defective products under S.C. Code § 15-73-10</strong>, so a manufacturer can be liable for a dangerously defective product without proof of negligence. Other burn claims arise from <strong>premises liability</strong> (an unsafe condition on someone's property) or, when the injury happened at work, from <strong>workers' compensation</strong>, which in South Carolina can include a scheduled component for serious bodily disfigurement. The general deadline to file a personal-injury lawsuit is <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, South Carolina follows <strong>modified comparative negligence</strong> (you can recover as long as you are 50% or less at fault), and there is <strong>no cap on compensatory damages</strong> in ordinary injury cases. Learn more on our <a href="/practice-areas/product-liability-lawyers/">South Carolina product liability lawyers</a> page and our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a> guide.</p>
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
	'post_title'   => 'Burn Injury Lawyers in Charleston, SC',
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
		'question' => 'Who are the best burn injury lawyers in Charleston, SC?',
		'answer'   => 'Roden Law is a leading personal-injury firm serving Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Charleston office at 127 King Street handles every case on a contingency fee basis — no fee unless we win. Call (843) 790-8999 for a free consultation.',
	),
	array(
		'question' => 'Who can be held responsible for a burn injury in South Carolina?',
		'answer'   => 'It depends on the cause. A defective product (a water heater, space heater, or lithium-ion battery, for example) can support a product-liability claim against the manufacturer; an unsafe condition on someone\'s property can support a premises-liability claim; and a work-related burn may be covered by workers\' compensation. Roden Law investigates the cause to identify every responsible party and applicable policy.',
	),
	array(
		'question' => 'Is a defective-product burn a strict-liability case in South Carolina?',
		'answer'   => 'It can be. South Carolina recognizes strict liability for defective products under S.C. Code § 15-73-10, which means a manufacturer can be liable for a dangerously defective product without proof of negligence. Many burn injuries caused by defective appliances, batteries, or equipment are pursued on this basis.',
	),
	array(
		'question' => 'How is a burn injury case valued?',
		'answer'   => 'Burn cases are often driven by disfigurement, scarring, and the cost of future care — skin-graft revisions, scar management, and reconstructive surgery can continue for years. South Carolina places no cap on compensatory damages in ordinary injury cases, so long-term needs and permanent disfigurement can be pursued in full.',
	),
	array(
		'question' => 'What if my burn happened at work in Charleston?',
		'answer'   => 'A work-related burn is generally covered by South Carolina workers\' compensation, which is a no-fault system and can include a component for serious bodily disfigurement. If a defective product or a third party (not your employer) caused the burn, you may also have a separate injury claim. Roden Law reviews both paths at no cost.',
	),
	array(
		'question' => 'How long do I have to file a burn injury claim in South Carolina?',
		'answer'   => 'The general deadline is three years from the date of injury under S.C. Code § 15-3-530. Work-related claims can involve different, shorter workers\' comp deadlines, so it is best to have your case reviewed as soon as possible to preserve evidence about how the burn occurred.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /burn-injury-lawyers/charleston-sc/ — post ID {$post_id}" );
