<?php
/**
 * Seeder: nursing-home-abuse-lawyers × Columbia, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /nursing-home-abuse-lawyers/columbia-sc/
 * page in place with rich, practice-specific, hyperlocal body content + FAQPage meta
 * + attorney attribution. Part of P2 row-9 BATCH 4 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS what the template lacks: answer-first intro,
 * "why Roden Law", local context, and nursing-home-specific SC nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-nursinghome-columbia.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching nursing-home-abuse-lawyers × Columbia, SC...' );

$pillar = get_page_by_path( 'nursing-home-abuse-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "nursing-home-abuse-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents nursing home residents and their families in Columbia, South Carolina</strong> and throughout the Midlands — Lexington, Irmo, West Columbia, Cayce, and Forest Acres. When a facility's neglect or abuse harms a loved one, families deserve answers and accountability, and how the claim is framed can determine whether damage caps apply at all. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Columbia Nursing Home Abuse Claim</h2>
<p>Facilities and their insurers move quickly to protect themselves — often invoking arbitration clauses buried in admission paperwork and characterizing every claim as medical malpractice to trigger the damage cap. What separates Roden Law is direct attorney involvement and careful pleading that preserves the theories which escape the cap. Our office at 1545 Sumter Street, Suite B sits in the downtown corridor minutes from the Richland County Circuit Court.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to investigate.</li>
<li><strong>We contest arbitration clauses</strong> — pre-dispute arbitration agreements in admission packets are routinely challenged.</li>
<li><strong>Cap-aware pleading</strong> — ordinary-negligence and intentional-tort theories can keep your case out from under the medical-malpractice cap.</li>
</ul>

<h2>Columbia Nursing Home Harms We Handle</h2>
<p>The Midlands' large senior population fills numerous long-term-care and assisted-living facilities across Columbia and Lexington and Richland counties, and the harms our attorneys see most include:</p>
<ul>
<li><strong>Falls and fractures</strong> from inadequate supervision and unsafe conditions.</li>
<li><strong>Pressure ulcers (bedsores)</strong> caused by immobility and neglect.</li>
<li><strong>Malnutrition and dehydration</strong> from understaffing and inattention.</li>
<li><strong>Medication errors</strong> — wrong drug, wrong dose, or missed doses.</li>
<li><strong>Wandering and elopement</strong> when residents leave unsupervised.</li>
<li><strong>Physical, sexual, and emotional abuse</strong> by staff or other residents.</li>
</ul>

<h2>South Carolina Nursing Home Law You Should Know</h2>
<p>A nursing home claim can be built on several theories: <strong>ordinary negligence, professional (medical) negligence, statutory violations, and intentional torts such as battery or elder abuse</strong>. South Carolina's <strong>Omnibus Adult Protection Act (S.C. Code § 43-35-5 et seq.)</strong> informs the standard of care owed to vulnerable adults. The framing matters: if a claim is characterized as <strong>medical malpractice</strong>, the <strong>non-economic damages cap under S.C. Code § 15-32-220</strong> — roughly $596,001 per provider or institution and about $1,788,003 in aggregate as of 2026, adjusted annually — may apply. But <strong>ordinary-negligence and intentional-tort theories generally escape that cap</strong>, which is why the pleading decision is so important. The deadline is generally <strong>three years (S.C. Code § 15-3-530)</strong>, and if a resident dies, <strong>wrongful-death and survival claims</strong> may arise. Learn more from our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence guide</a>, and if a loved one has died, our <a href="/south-carolina-wrongful-death-lawyer/">South Carolina wrongful death lawyers</a> can help.</p>
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
	'post_title'   => 'Nursing Home Abuse Lawyers in Columbia, SC',
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
		'question' => 'Who are the best nursing home abuse lawyers in Columbia, SC?',
		'answer'   => 'Roden Law is a leading nursing home abuse and neglect firm serving Columbia and the Midlands, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles every case on a contingency fee basis — no fee unless we win. Call (803) 219-2816 for a free consultation.',
	),
	array(
		'question' => 'What are the signs of nursing home abuse or neglect?',
		'answer'   => 'Common warning signs include unexplained falls or fractures, pressure ulcers (bedsores), sudden weight loss from malnutrition or dehydration, medication errors, poor hygiene, unexplained bruises or injuries, fearfulness around staff, and a resident wandering or leaving the facility unsupervised.',
	),
	array(
		'question' => 'Does the medical malpractice cap apply to a nursing home case?',
		'answer'   => 'It depends on how the claim is framed. If the harm is characterized as medical malpractice, the S.C. Code § 15-32-220 non-economic cap (roughly $596,001 per defendant and about $1,788,003 in aggregate as of 2026) may apply. But claims built on ordinary negligence or intentional torts such as battery or elder abuse generally escape that cap, which is why the pleading decision matters so much.',
	),
	array(
		'question' => 'Is the arbitration agreement I signed at admission enforceable?',
		'answer'   => 'Not always. Pre-dispute arbitration agreements buried in nursing home admission paperwork are routinely contested, and courts examine how they were presented and who signed them. Roden Law challenges these clauses where the facts support it so families can have their case heard.',
	),
	array(
		'question' => 'How long do I have to file a nursing home claim in South Carolina?',
		'answer'   => 'The general deadline is three years from the date of injury under S.C. Code § 15-3-530. If a resident has died, wrongful-death and survival claims have their own timing rules, so it is best to speak with an attorney promptly.',
	),
	array(
		'question' => 'How much does a Columbia nursing home abuse lawyer cost?',
		'answer'   => 'Roden Law handles Columbia nursing home abuse and neglect cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /nursing-home-abuse-lawyers/columbia-sc/ — post ID {$post_id}" );
