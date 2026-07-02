<?php
/**
 * Seeder: electric-scooter-accident-lawyers × North Charleston, SC intersection page (ENRICH)
 *
 * UPDATES the existing templated stub /electric-scooter-accident-lawyers/north-charleston-sc/
 * in place with rich, practice-specific, hyperlocal body content + FAQPage meta + attorney
 * attribution. Part of P2 row-9 BATCH 7 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS only what the template lacks.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-escooter-north-charleston.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching electric-scooter-accident-lawyers × North Charleston, SC...' );

$pillar = get_page_by_path( 'electric-scooter-accident-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "electric-scooter-accident-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents electric-scooter riders injured across North Charleston, South Carolina</strong> and the surrounding Lowcountry — Hanahan, Goose Creek, Ladson, and Summerville. Whether you were struck by a car while riding, thrown by a defective scooter, or hurt by a road or sidewalk hazard, a rider has far less protection and insurance than a driver. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436126561">(843) 612-6561</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a North Charleston E-Scooter Claim</h2>
<p>E-scooter injury law is relatively new and still evolving, and insurers exploit that uncertainty — blaming the rider, questioning whether a scooter belongs on the road or the sidewalk, and disputing which policy applies. What separates Roden Law is the investigation needed to pin down the at-fault party and every source of coverage.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We find the coverage</strong> — a negligent driver's auto policy, the scooter maker (in a defect case), or your own UM/UIM coverage may all apply.</li>
<li><strong>Full-value focus</strong> — scooter crashes often cause head, facial, and orthopedic injuries, and we account for all of it before any settlement.</li>
</ul>

<h2>E-Scooter Hazards in the North Charleston Area</h2>
<p>North Charleston's dense commercial corridors, shopping districts around Tanger Outlets and Rivers Avenue, and mixed-use areas near the airport and Boeing campus put scooter riders alongside heavy vehicle traffic. Wide, fast arterial roads, busy driveway and parking-lot entrances, and uneven sidewalks are common settings for scooter crashes and falls. When a car strikes a rider on these high-traffic routes, injuries are often severe, and identifying the at-fault driver's coverage is the first priority.</p>

<h2>South Carolina E-Scooter Law You Should Know</h2>
<p>When a defective scooter causes a crash — brakes, steering, or battery failure — the claim can sound in <strong>product liability</strong>, and South Carolina recognizes <strong>strict liability for defective products under S.C. Code § 15-73-10</strong>. When a negligent driver strikes a rider, the driver's auto insurance is the usual source of recovery, and your own <strong>uninsured/underinsured motorist (UM/UIM)</strong> coverage may apply if that driver is uninsured or flees. The general deadline to file is <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, South Carolina follows <strong>modified comparative negligence</strong> (you can recover as long as you are 50% or less at fault), and there is <strong>no cap on compensatory damages</strong> in ordinary injury cases. Learn more on our <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a> guide.</p>
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
	'post_title'   => 'Electric Scooter Accident Lawyers in North Charleston, SC',
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
		'question' => 'Who are the best electric scooter accident lawyers in North Charleston, SC?',
		'answer'   => 'Roden Law is a leading personal-injury firm serving North Charleston and the Lowcountry, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every case on a contingency fee basis — no fee unless we win. Call (843) 612-6561 for a free consultation.',
	),
	array(
		'question' => 'Who pays if a car hits me while I am on a scooter in North Charleston?',
		'answer'   => 'If a negligent driver strikes you, that driver\'s auto liability insurance is usually the primary source of recovery. If the driver is uninsured or flees the scene, your own uninsured/underinsured motorist (UM/UIM) coverage may apply. Roden Law identifies every policy that could cover your injuries.',
	),
	array(
		'question' => 'Can I sue if a rental scooter was defective?',
		'answer'   => 'Possibly. If a brake, throttle, steering, or battery defect caused your crash, the claim can sound in product liability. South Carolina recognizes strict liability for defective products under S.C. Code § 15-73-10, so the manufacturer or company that maintained the scooter may be responsible without proof of ordinary negligence.',
	),
	array(
		'question' => 'What if I was partly at fault for my scooter crash?',
		'answer'   => 'South Carolina follows modified comparative negligence, so you can still recover as long as you were 50% or less at fault; your award is reduced by your share of fault. Insurers often overstate a rider\'s fault, which is one reason it helps to have your own attorney.',
	),
	array(
		'question' => 'Are electric scooters legal on North Charleston streets and sidewalks?',
		'answer'   => 'Local governments have municipal rules governing where scooters may operate, and those rules continue to evolve. Where you were riding can affect a claim, but it does not automatically bar recovery — the key questions are who was negligent and what caused the crash. Roden Law can review the specific rules that applied to your ride.',
	),
	array(
		'question' => 'How long do I have to file an e-scooter injury claim in South Carolina?',
		'answer'   => 'The general deadline is three years from the date of injury under S.C. Code § 15-3-530. It is best to have your case reviewed as soon as possible so the scooter, road conditions, and any driver information can be preserved.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /electric-scooter-accident-lawyers/north-charleston-sc/ — post ID {$post_id}" );
