<?php
/**
 * Seeder: golf-cart-accident-lawyers × Columbia, SC intersection page (ENRICH)
 *
 * UPDATES the existing templated stub /golf-cart-accident-lawyers/columbia-sc/ in place with
 * rich, practice-specific, hyperlocal body content + FAQPage meta + attorney attribution.
 * Part of P2 row-9 BATCH 7 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS only what the template lacks.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-golfcart-columbia.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching golf-cart-accident-lawyers × Columbia, SC...' );

$pillar = get_page_by_path( 'golf-cart-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "golf-cart-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents golf-cart crash victims across Columbia, South Carolina</strong> and the Midlands — Lexington, Irmo, West Columbia, Cayce, and Forest Acres. Golf carts have no seatbelts, doors, or airbags, so ejections and passenger injuries — including to children — are common, and crashes with cars are often severe. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Columbia Golf-Cart Claim</h2>
<p>Golf-cart cases raise coverage questions that ordinary car crashes do not — a cart may not be covered by standard auto insurance, and homeowner's or a driver's auto policy may come into play depending on how and where the crash happened. What separates Roden Law is the investigation needed to find every source of coverage. Our Columbia office at 1545 Sumter Street, Suite B sits in the downtown corridor minutes from the Richland County Circuit Court.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We find the coverage</strong> — auto, homeowner's, and a cart owner's policies can each apply, and we identify all of them.</li>
<li><strong>Full-value focus</strong> — golf-cart ejections often cause head and orthopedic injuries, and we account for all of it before any settlement.</li>
</ul>

<h2>Golf Carts in the Columbia Area</h2>
<p>Golf carts are used across the Midlands' lake communities around Lake Murray, in gated subdivisions and retirement neighborhoods, and on private property and event grounds. On neighborhood streets, carts share the road with cars and pedestrians, and a collision with a vehicle, a sharp turn, or an inattentive driver can eject an unbelted passenger. Children riding on the sides or standing are especially vulnerable in a crash. When a cart is driven onto faster roads outside the conditions the law allows, the risk of a serious car-versus-cart collision rises sharply.</p>

<h2>South Carolina Golf-Cart Law You Should Know</h2>
<p>South Carolina's <strong>permitted-golf-cart law (S.C. Code § 56-2-100)</strong> allows registered and permitted carts to operate only under limited conditions — generally on roads with a posted speed limit at or below a set threshold, during daylight hours, and within a set distance of the owner's address. Operating a cart outside those limits can be relevant to fault. When a defect in the cart contributes to a crash, the claim can also sound in <strong>product liability</strong> under South Carolina's <strong>strict-liability rule, S.C. Code § 15-73-10</strong>. The general deadline to file is <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, South Carolina follows <strong>modified comparative negligence</strong> (you can recover as long as you are 50% or less at fault), and there is <strong>no cap on compensatory damages</strong> in ordinary injury cases. Learn more on our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a> guide.</p>
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
	'post_title'   => 'Golf Cart Accident Lawyers in Columbia, SC',
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
		'question' => 'Who are the best golf cart accident lawyers in Columbia, SC?',
		'answer'   => 'Roden Law is a leading personal-injury firm serving Columbia and the Midlands, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles every case on a contingency fee basis — no fee unless we win. Call (803) 219-2816 for a free consultation.',
	),
	array(
		'question' => 'What insurance covers a golf-cart accident in South Carolina?',
		'answer'   => 'It varies. A golf cart may not be covered by a standard auto policy, so a homeowner\'s policy, a cart owner\'s coverage, or an at-fault driver\'s auto insurance may each apply depending on how and where the crash happened. Roden Law investigates to identify every source of coverage.',
	),
	array(
		'question' => 'Are golf carts legal on Columbia-area and Lake Murray streets?',
		'answer'   => 'Under S.C. Code § 56-2-100, a registered and permitted golf cart may operate only under limited conditions — generally on roads at or below a set speed limit, during daylight, and within a set distance of the owner\'s address. Operating outside those limits can affect fault, but it does not automatically bar an injured passenger or bystander from recovering.',
	),
	array(
		'question' => 'Can I recover if I was a passenger ejected from a golf cart?',
		'answer'   => 'Yes. Golf carts have no seatbelts, doors, or airbags, and ejected passengers — including children — often suffer serious head and orthopedic injuries. As an injured passenger you can generally pursue a claim against whoever was at fault, and South Carolina places no cap on compensatory damages in ordinary injury cases.',
	),
	array(
		'question' => 'What if a defect in the golf cart caused the crash?',
		'answer'   => 'If a brake, steering, or other defect contributed to the crash, the claim can sound in product liability. South Carolina recognizes strict liability for defective products under S.C. Code § 15-73-10, so the manufacturer may be responsible without proof of ordinary negligence.',
	),
	array(
		'question' => 'How long do I have to file a golf-cart injury claim in South Carolina?',
		'answer'   => 'The general deadline is three years from the date of injury under S.C. Code § 15-3-530. It is best to have your case reviewed as soon as possible so the cart, the scene, and insurance information can be preserved.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /golf-cart-accident-lawyers/columbia-sc/ — post ID {$post_id}" );
