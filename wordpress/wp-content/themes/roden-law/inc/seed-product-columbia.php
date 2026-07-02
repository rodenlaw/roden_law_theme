<?php
/**
 * Seeder: product-liability-lawyers × Columbia, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /product-liability-lawyers/columbia-sc/
 * page in place with rich, practice-specific, hyperlocal body content + FAQPage meta
 * + attorney attribution. Part of P2 row-9 BATCH 4 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS what the template lacks: answer-first intro,
 * "why Roden Law", local context, and product-liability-specific SC nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-product-columbia.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching product-liability-lawyers × Columbia, SC...' );

$pillar = get_page_by_path( 'product-liability-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "product-liability-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents people injured by dangerous and defective products in Columbia, South Carolina</strong> and throughout the Midlands — Lexington, Irmo, West Columbia, Cayce, and Forest Acres. When a product fails, the manufacturer, distributor, and retailer can all be held responsible, and South Carolina lets you pursue them under strict liability, negligence, and warranty theories. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Columbia Product Liability Claim</h2>
<p>Product cases are among the most technical injury claims — they require engineering analysis, preservation of the defective product, and manufacturers with deep-pocketed national defense counsel. What separates Roden Law is direct attorney involvement paired with the engineering and safety experts needed to prove the defect. Our office at 1545 Sumter Street, Suite B sits in the downtown corridor minutes from the Richland County Circuit Court, so investigation and filings happen without the delay of running a Midlands case from a distant office.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to investigate your claim.</li>
<li><strong>Preserve the evidence</strong> — we move quickly to secure the product itself, which is often the single most important piece of proof.</li>
<li><strong>Experts on defect and causation</strong> — engineers and safety specialists to establish a manufacturing, design, or warning defect.</li>
</ul>

<h2>Columbia Product Liability Cases We Handle</h2>
<p>Defective-product injuries in the Midlands span consumer goods, vehicles, and industrial equipment:</p>
<ul>
<li><strong>Auto and tire defects</strong> — defective airbags, tire failures, and vehicle component defects tied to crashes at "Malfunction Junction" and along I-20, I-26, and I-77.</li>
<li><strong>Consumer product injuries</strong> — appliances, tools, children's products, and household goods that fail dangerously.</li>
<li><strong>Industrial and machinery defects</strong> — equipment failures at Midlands distribution centers, plants, and warehouses.</li>
<li><strong>Recreational product injuries</strong> — defective equipment used at area lakes, rivers, and recreation sites.</li>
</ul>

<h2>South Carolina Product Liability Law You Should Know</h2>
<p>South Carolina recognizes <strong>strict liability under S.C. Code § 15-73-10</strong>, in addition to negligence and breach-of-warranty theories, so an injured person does not always have to prove the manufacturer was careless — only that the product was defective and unreasonably dangerous. Claims fall into three categories: <strong>manufacturing defects, design defects, and warning or marketing defects</strong>. For design-defect claims, South Carolina applies the <strong>risk-utility test</strong> adopted in <em>Branham v. Ford Motor Co.</em>, 390 S.C. 203 (2010). The deadline is generally <strong>three years (S.C. Code § 15-3-530)</strong>, there is <strong>no cap on compensatory damages</strong>, and <strong>punitive damages</strong> may be available (generally the greater of three times compensatory damages or about $739,000 as of 2026, indexed for inflation, with that cap removed for felony or intentional conduct). Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>.</p>
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
	'post_title'   => 'Product Liability Lawyers in Columbia, SC',
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
		'question' => 'Who are the best product liability lawyers in Columbia, SC?',
		'answer'   => 'Roden Law is a leading product liability firm serving Columbia and the Midlands, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles every case on a contingency fee basis — no fee unless we win — and retains the engineering experts needed to prove a defect. Call (803) 219-2816 for a free consultation.',
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
		'question' => 'Is there a cap on product liability damages in South Carolina?',
		'answer'   => 'There is no cap on compensatory damages in an ordinary South Carolina product case. Punitive damages are separately capped at generally the greater of three times compensatory damages or about $739,000 as of 2026 (indexed for inflation), and that cap is removed where the conduct was a felony or intended to harm.',
	),
	array(
		'question' => 'How long do I have to file a product liability claim in South Carolina?',
		'answer'   => 'The general deadline is three years from the date of injury under S.C. Code § 15-3-530. Because the defective product itself is critical evidence and needs to be preserved before it is repaired or discarded, it is important to contact an attorney quickly.',
	),
	array(
		'question' => 'How much does a Columbia product liability lawyer cost?',
		'answer'   => 'Roden Law handles Columbia product liability cases on a contingency fee basis. You pay no attorney fees and no upfront costs — including the cost of the engineering experts needed to build your case — and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /product-liability-lawyers/columbia-sc/ — post ID {$post_id}" );
