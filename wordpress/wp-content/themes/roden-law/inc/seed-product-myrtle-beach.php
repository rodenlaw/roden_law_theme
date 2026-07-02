<?php
/**
 * Seeder: product-liability-lawyers × Myrtle Beach, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /product-liability-lawyers/myrtle-beach-sc/
 * page in place with rich, practice-specific, hyperlocal body content + FAQPage meta
 * + attorney attribution. Part of P2 row-9 BATCH 4 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS what the template lacks: answer-first intro,
 * "why Roden Law", local context, and product-liability-specific SC nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-product-myrtle-beach.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching product-liability-lawyers × Myrtle Beach, SC...' );

$pillar = get_page_by_path( 'product-liability-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "product-liability-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people injured by dangerous and defective products in Myrtle Beach and across the Grand Strand</strong> — Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and Georgetown. When a product fails, the manufacturer, distributor, and retailer can all be held responsible, and South Carolina lets you pursue them under strict liability, negligence, and warranty theories. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Grand Strand Product Liability Claim</h2>
<p>Product cases are among the most technical injury claims — they require engineering analysis, preservation of the defective product, and manufacturers with deep-pocketed national defense counsel. What separates Roden Law is direct attorney involvement paired with the engineering and safety experts needed to prove the defect. We prepare Horry County cases for the courthouse in Conway and handle Georgetown County matters as well.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to investigate your claim.</li>
<li><strong>Preserve the evidence</strong> — we move quickly to secure the product itself, which is often the single most important piece of proof.</li>
<li><strong>Experts on defect and causation</strong> — engineers and safety specialists to establish a manufacturing, design, or warning defect.</li>
</ul>

<h2>Grand Strand Product Liability Cases We Handle</h2>
<p>The Grand Strand's tourism and water recreation shape the defective-product cases our attorneys see most:</p>
<ul>
<li><strong>Recreational and boating products</strong> — defective watercraft, personal watercraft, and marine equipment used in the Atlantic, the Intracoastal Waterway, and area inlets.</li>
<li><strong>Auto and tire defects</strong> — defective airbags, tire failures, and vehicle component defects tied to crashes on US-17 and SC-31.</li>
<li><strong>Consumer product injuries</strong> — appliances, tools, children's products, and household goods that fail dangerously.</li>
<li><strong>Hospitality and amusement equipment</strong> — defective equipment at hotels, resorts, and attractions serving the area's visitors.</li>
</ul>

<h2>South Carolina Product Liability Law You Should Know</h2>
<p>South Carolina recognizes <strong>strict liability under S.C. Code § 15-73-10</strong>, in addition to negligence and breach-of-warranty theories, so an injured person does not always have to prove the manufacturer was careless — only that the product was defective and unreasonably dangerous. Claims fall into three categories: <strong>manufacturing defects, design defects, and warning or marketing defects</strong>. For design-defect claims, South Carolina applies the <strong>risk-utility test</strong> adopted in <em>Branham v. Ford Motor Co.</em>, 390 S.C. 203 (2010). The deadline is generally <strong>three years (S.C. Code § 15-3-530)</strong>, there is <strong>no cap on compensatory damages</strong>, and <strong>punitive damages</strong> may be available (generally the greater of three times compensatory damages or about $739,000 as of 2026, indexed for inflation, with that cap removed for felony or intentional conduct). Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>.</p>
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
	'post_title'   => 'Product Liability Lawyers in Myrtle Beach, SC',
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
		'question' => 'Who are the best product liability lawyers in Myrtle Beach, SC?',
		'answer'   => 'Roden Law is a leading product liability firm serving Myrtle Beach and the Grand Strand, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every case on a contingency fee basis — no fee unless we win — and retain the engineering experts needed to prove a defect. Call (843) 612-1980 for a free consultation.',
	),
	array(
		'question' => 'What do I have to prove in a South Carolina product liability case?',
		'answer'   => 'South Carolina recognizes strict liability under S.C. Code § 15-73-10, so you generally must show the product was defective and unreasonably dangerous, that the defect existed when it left the defendant\'s control, and that it caused your injury. Claims fall into three types — manufacturing, design, and warning or marketing defects — and you can also proceed on negligence and warranty theories.',
	),
	array(
		'question' => 'Who can be held responsible for a defective product?',
		'answer'   => 'Under South Carolina strict liability, everyone in the chain of distribution can be liable — the manufacturer, any distributor, and the retailer that sold the product. That is important because it gives an injured person more than one solvent, insured defendant to pursue.',
	),
	array(
		'question' => 'Can I sue for a defective boat or watercraft on the Grand Strand?',
		'answer'   => 'Yes. If a personal watercraft, boat, or marine component was defectively designed or manufactured and caused injury, you can bring a South Carolina product liability claim against the manufacturer, distributor, and seller. These cases are common along the Grand Strand given the area\'s heavy recreational-water use.',
	),
	array(
		'question' => 'Is there a cap on product liability damages in South Carolina?',
		'answer'   => 'There is no cap on compensatory damages in an ordinary South Carolina product case. Punitive damages are separately capped at generally the greater of three times compensatory damages or about $739,000 as of 2026 (indexed for inflation), and that cap is removed where the conduct was a felony or intended to harm.',
	),
	array(
		'question' => 'How much does a Myrtle Beach product liability lawyer cost?',
		'answer'   => 'Roden Law handles Grand Strand product liability cases on a contingency fee basis. You pay no attorney fees and no upfront costs — including the cost of the engineering experts needed to build your case — and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /product-liability-lawyers/myrtle-beach-sc/ — post ID {$post_id}" );
