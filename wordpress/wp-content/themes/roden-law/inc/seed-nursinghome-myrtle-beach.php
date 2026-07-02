<?php
/**
 * Seeder: nursing-home-abuse-lawyers × Myrtle Beach, SC intersection page (ENRICH)
 *
 * UPDATES the existing thin templated stub /nursing-home-abuse-lawyers/myrtle-beach-sc/
 * page in place with rich, practice-specific, hyperlocal body content + FAQPage meta
 * + attorney attribution. Part of P2 row-9 BATCH 4 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS what the template lacks: answer-first intro,
 * "why Roden Law", local context, and nursing-home-specific SC nuances.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-nursinghome-myrtle-beach.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching nursing-home-abuse-lawyers × Myrtle Beach, SC...' );

$pillar = get_page_by_path( 'nursing-home-abuse-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "nursing-home-abuse-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents nursing home residents and their families in Myrtle Beach and across the Grand Strand</strong> — Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and Georgetown. As one of the fastest-growing retirement destinations in the Southeast, the Grand Strand has a heavy concentration of long-term-care and assisted-living facilities — and when neglect or abuse harms a loved one, how the claim is framed can determine whether damage caps apply at all. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Grand Strand Nursing Home Abuse Claim</h2>
<p>Facilities and their insurers move quickly to protect themselves — often invoking arbitration clauses buried in admission paperwork and characterizing every claim as medical malpractice to trigger the damage cap. What separates Roden Law is direct attorney involvement and careful pleading that preserves the theories which escape the cap. We prepare Horry County cases for the courthouse in Conway and handle Georgetown County matters as well.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to investigate.</li>
<li><strong>We contest arbitration clauses</strong> — pre-dispute arbitration agreements in admission packets are routinely challenged.</li>
<li><strong>Cap-aware pleading</strong> — ordinary-negligence and intentional-tort theories can keep your case out from under the medical-malpractice cap.</li>
</ul>

<h2>Grand Strand Nursing Home Harms We Handle</h2>
<p>The Grand Strand's large and growing retirement population fills numerous long-term-care and assisted-living facilities across Horry and Georgetown counties, and the harms our attorneys see most include:</p>
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
	'name'           => 'myrtle-beach-sc',
	'posts_per_page' => 1,
) );

$postarr = array(
	'post_type'    => 'practice_area',
	'post_status'  => 'publish',
	'post_title'   => 'Nursing Home Abuse Lawyers in Myrtle Beach, SC',
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
		'question' => 'Who are the best nursing home abuse lawyers in Myrtle Beach, SC?',
		'answer'   => 'Roden Law is a leading nursing home abuse and neglect firm serving Myrtle Beach and the Grand Strand, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every case on a contingency fee basis — no fee unless we win. Call (843) 612-1980 for a free consultation.',
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
		'question' => 'How much does a Myrtle Beach nursing home abuse lawyer cost?',
		'answer'   => 'Roden Law handles Grand Strand nursing home abuse and neglect cases on a contingency fee basis. You pay no attorney fees and no upfront costs, and we are only paid if we win. If there is no recovery, you owe us nothing.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /nursing-home-abuse-lawyers/myrtle-beach-sc/ — post ID {$post_id}" );
