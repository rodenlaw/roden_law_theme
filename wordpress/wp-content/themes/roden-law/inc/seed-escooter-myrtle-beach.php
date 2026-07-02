<?php
/**
 * Seeder: electric-scooter-accident-lawyers × Myrtle Beach, SC intersection page (ENRICH)
 *
 * UPDATES the existing templated stub /electric-scooter-accident-lawyers/myrtle-beach-sc/ in
 * place with rich, practice-specific, hyperlocal body content + FAQPage meta + attorney
 * attribution. Part of P2 row-9 BATCH 7 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS only what the template lacks.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-escooter-myrtle-beach.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching electric-scooter-accident-lawyers × Myrtle Beach, SC...' );

$pillar = get_page_by_path( 'electric-scooter-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "electric-scooter-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents electric-scooter riders injured across Myrtle Beach and the Grand Strand</strong> — Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and Georgetown. Whether you were struck by a car while riding, thrown by a defective scooter, or hurt by a road or sidewalk hazard, a rider has far less protection and insurance than a driver. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Grand Strand E-Scooter Claim</h2>
<p>E-scooter injury law is relatively new and still evolving, and insurers exploit that uncertainty — blaming the rider, questioning whether a scooter belongs on the road or the sidewalk, and disputing which policy applies. What separates Roden Law is the investigation needed to pin down the at-fault party and every source of coverage. Grand Strand cases are handled through the Horry County court in Conway, and we also serve clients in neighboring Georgetown County.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We find the coverage</strong> — a negligent driver's auto policy, the scooter maker (in a defect case), or your own UM/UIM coverage may all apply.</li>
<li><strong>Full-value focus</strong> — scooter crashes often cause head, facial, and orthopedic injuries, and we account for all of it before any settlement.</li>
</ul>

<h2>Tourist Scooter Rentals and Grand Strand Hazards</h2>
<p>The Grand Strand's tourism economy means a heavy flow of rented scooters ridden by out-of-town visitors unfamiliar with local streets — along Ocean Boulevard, near the boardwalk, and through resort and entertainment districts. Vacationers sharing crowded seasonal traffic with cars, bicycles, and pedestrians, combined with defective or poorly maintained rental units, drives a distinct pattern of scooter crashes. When a car strikes a rider or a rental scooter fails, identifying the at-fault party and applicable coverage is the first priority.</p>

<h2>South Carolina E-Scooter Law You Should Know</h2>
<p>When a defective scooter causes a crash — brakes, steering, or battery failure — the claim can sound in <strong>product liability</strong>, and South Carolina recognizes <strong>strict liability for defective products under S.C. Code § 15-73-10</strong>. When a negligent driver strikes a rider, the driver's auto insurance is the usual source of recovery, and your own <strong>uninsured/underinsured motorist (UM/UIM)</strong> coverage may apply if that driver is uninsured or flees. The general deadline to file is <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, South Carolina follows <strong>modified comparative negligence</strong> (you can recover as long as you are 50% or less at fault), and there is <strong>no cap on compensatory damages</strong> in ordinary injury cases. Learn more on our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a> guide.</p>
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
	'post_title'   => 'Electric Scooter Accident Lawyers in Myrtle Beach, SC',
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
		'question' => 'Who are the best electric scooter accident lawyers in Myrtle Beach, SC?',
		'answer'   => 'Roden Law is a leading personal-injury firm serving Myrtle Beach and the Grand Strand, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every case on a contingency fee basis — no fee unless we win. Call (843) 612-1980 for a free consultation.',
	),
	array(
		'question' => 'I was hurt on a rented scooter as a Myrtle Beach tourist — can I still file a claim?',
		'answer'   => 'Yes. Being a visitor does not change your right to recover for injuries caused by a negligent driver, a defective rental scooter, or a dangerous road condition on the Grand Strand. Roden Law handles claims for out-of-town clients and can pursue the case in the Horry County court while you are back home.',
	),
	array(
		'question' => 'Who pays if a car hits me while I am on a scooter in Myrtle Beach?',
		'answer'   => 'If a negligent driver strikes you, that driver\'s auto liability insurance is usually the primary source of recovery. If the driver is uninsured or flees the scene, your own uninsured/underinsured motorist (UM/UIM) coverage may apply. Roden Law identifies every policy that could cover your injuries.',
	),
	array(
		'question' => 'Can I sue if a rental scooter was defective?',
		'answer'   => 'Possibly. If a brake, throttle, steering, or battery defect caused your crash, the claim can sound in product liability. South Carolina recognizes strict liability for defective products under S.C. Code § 15-73-10, so the manufacturer or rental company may be responsible without proof of ordinary negligence.',
	),
	array(
		'question' => 'What if I was partly at fault for my scooter crash?',
		'answer'   => 'South Carolina follows modified comparative negligence, so you can still recover as long as you were 50% or less at fault; your award is reduced by your share of fault. Insurers often overstate a rider\'s fault, which is one reason it helps to have your own attorney.',
	),
	array(
		'question' => 'How long do I have to file an e-scooter injury claim in South Carolina?',
		'answer'   => 'The general deadline is three years from the date of injury under S.C. Code § 15-3-530. It is best to have your case reviewed as soon as possible so the scooter, road conditions, and any driver or rental-company information can be preserved.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /electric-scooter-accident-lawyers/myrtle-beach-sc/ — post ID {$post_id}" );
