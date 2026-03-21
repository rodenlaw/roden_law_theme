<?php
/**
 * Seeder: FAQs for personal-injury-lawyers × 5 City Intersection Pages
 *
 * Run via WP-CLI on WP Engine dev or production:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-personal-injury-faqs.php
 *
 * Idempotent — skips pages that already have FAQs.
 * Remove this file after execution.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ------------------------------------------------------------------
   Office data
   ------------------------------------------------------------------ */

$offices = array(
	'savannah-ga'     => array(
		'city'       => 'Savannah',
		'state'      => 'GA',
		'state_full' => 'Georgia',
		'phone'      => '(912) 303-5850',
		'court'      => 'Chatham County Superior Court',
	),
	'darien-ga'       => array(
		'city'       => 'Darien',
		'state'      => 'GA',
		'state_full' => 'Georgia',
		'phone'      => '(912) 303-5850',
		'court'      => 'McIntosh County Superior Court',
	),
	'charleston-sc'   => array(
		'city'       => 'Charleston',
		'state'      => 'SC',
		'state_full' => 'South Carolina',
		'phone'      => '(843) 790-8999',
		'court'      => 'Charleston County Circuit Court',
	),
	'columbia-sc'     => array(
		'city'       => 'Columbia',
		'state'      => 'SC',
		'state_full' => 'South Carolina',
		'phone'      => '(803) 219-2816',
		'court'      => 'Richland County Circuit Court',
	),
	'myrtle-beach-sc' => array(
		'city'       => 'Myrtle Beach',
		'state'      => 'SC',
		'state_full' => 'South Carolina',
		'phone'      => '(843) 612-1980',
		'court'      => 'Horry County Circuit Court',
	),
);

/* ------------------------------------------------------------------
   Jurisdiction replacement values
   ------------------------------------------------------------------ */

$jurisdiction = array(
	'GA' => array(
		'sol'        => '2 years',
		'sol_cite'   => 'O.C.G.A. § 9-3-33',
		'fault_pct'  => '50',
		'fault_cite' => 'O.C.G.A. § 51-12-33',
	),
	'SC' => array(
		'sol'        => '3 years',
		'sol_cite'   => 'S.C. Code § 15-3-530',
		'fault_pct'  => '51',
		'fault_cite' => 'S.C. Code § 15-38-15',
	),
);

/* ------------------------------------------------------------------
   FAQ templates
   {city}, {state}, {state_full}, {phone}, {court},
   {sol}, {sol_cite}, {fault_pct}, {fault_cite}
   ------------------------------------------------------------------ */

$faq_templates = array(
	array(
		'question' => 'How long do I have to file a personal injury lawsuit in {state_full}?',
		'answer'   => 'In {state_full}, the statute of limitations for most personal injury claims is {sol} from the date of the injury ({sol_cite}). Missing this deadline will almost certainly bar you from recovering any compensation — courts routinely dismiss claims filed after the deadline regardless of how strong the case is. While {sol} may seem like plenty of time, evidence disappears, witnesses become harder to locate, and insurance companies use delay against you. If your injury involved a government entity, a much shorter notice period may apply. We recommend speaking with a {city} personal injury attorney as soon as possible after your accident. Call Roden Law at {phone} for a free consultation.',
	),
	array(
		'question' => 'What is modified comparative fault and how does it affect my {state_full} personal injury case?',
		'answer'   => '{state_full} follows a modified comparative fault rule ({fault_cite}). This means that as long as you are less than {fault_pct}% responsible for the accident, you can still recover compensation — but your award will be reduced by your percentage of fault. For example, if you are found 20% at fault and your total damages are $100,000, you would recover $80,000. If you are {fault_pct}% or more at fault, you recover nothing. Insurance companies routinely try to inflate your percentage of fault to reduce or eliminate your payout. An experienced {city} personal injury attorney can counter these arguments and fight to keep your fault percentage as low as the facts support. Call Roden Law at {phone}.',
	),
	array(
		'question' => 'What compensation can I recover in a personal injury case in {city}?',
		'answer'   => 'Personal injury victims in {city} may be entitled to two categories of damages. Economic damages cover your measurable financial losses: medical bills (emergency care, surgery, hospitalization, physical therapy, future medical needs), lost wages, reduced earning capacity, and property damage. Non-economic damages compensate for losses that do not have a fixed dollar value: pain and suffering, emotional distress, loss of enjoyment of life, and scarring or disfigurement. In cases involving particularly egregious conduct, {state_full} may also allow punitive damages designed to punish the at-fault party. The total value of your case depends on the severity and permanence of your injuries, the impact on your daily life, and the strength of the evidence. At Roden Law, we have recovered over $250 million for injured clients across {state_full}. Call {phone} for a free case evaluation.',
	),
	array(
		'question' => 'How much does a personal injury lawyer cost in {city}?',
		'answer'   => 'At Roden Law, we handle personal injury cases on a contingency fee basis — you pay zero attorney fees upfront and owe nothing unless we win your case. Our fee is a percentage of the settlement or verdict we recover for you. If we do not win, you do not pay. This means anyone injured in {city} can access experienced legal representation regardless of their financial situation. During your free consultation, we will explain the fee structure in detail so there are no surprises. Call our {city} office at {phone} to get started.',
	),
	array(
		'question' => 'Do I need a lawyer for a personal injury claim in {city}?',
		'answer'   => 'You are not legally required to hire a personal injury attorney, but studies consistently show that represented claimants receive significantly higher settlements than those who negotiate alone — often 3 to 4 times more, even after attorney fees. Insurance companies have experienced adjusters and defense attorneys whose job is to pay you as little as possible. A personal injury lawyer levels the playing field. An attorney can investigate your accident, preserve evidence, identify all liable parties, calculate the true value of your damages (including future medical costs most injured people underestimate), handle all communications with insurers, and negotiate aggressively or take your case to trial if necessary. At Roden Law, our {city} attorneys handle cases on a contingency basis so you pay nothing unless we win. Call {phone} for a free consultation.',
	),
	array(
		'question' => 'What should I do immediately after an accident in {city}?',
		'answer'   => 'The steps you take in the hours and days after an accident in {city} can significantly affect the value of your personal injury claim. First, seek medical attention immediately — even if you feel fine, many serious injuries (concussions, internal bleeding, soft tissue damage) do not show symptoms right away, and a gap in treatment gives insurers grounds to dispute your injuries. Call 911 and file a police report. Document the scene thoroughly with photos and video. Collect contact information from any witnesses. Do not give a recorded statement to any insurance company before speaking with an attorney — adjusters are trained to use your words against you. Preserve all evidence including damaged property, medical records, and bills. Contact Roden Law at {phone} as soon as possible — the sooner we can begin an investigation, the stronger your case will be.',
	),
);

/* ------------------------------------------------------------------
   Process pillar slug × each city
   ------------------------------------------------------------------ */

$pillar_slug   = 'personal-injury-lawyers';
$total_updated = 0;
$total_skipped = 0;

$pillar = get_page_by_path( $pillar_slug, OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( "Pillar post \"{$pillar_slug}\" not found. Create it first, then re-run this seeder." );
	exit;
}

WP_CLI::log( "Found pillar: {$pillar->post_title} (ID {$pillar->ID})" );

foreach ( $offices as $city_slug => $office ) {

	$children = get_posts( array(
		'post_type'      => 'practice_area',
		'post_parent'    => $pillar->ID,
		'name'           => $city_slug,
		'posts_per_page' => 1,
		'post_status'    => 'publish',
	) );

	if ( empty( $children ) ) {
		WP_CLI::warning( "{$pillar_slug}/{$city_slug} — intersection post not found. Create it first." );
		continue;
	}

	$page = $children[0];

	$existing = get_post_meta( $page->ID, '_roden_faqs', true );
	if ( is_array( $existing ) && count( $existing ) > 0 ) {
		WP_CLI::log( "SKIP {$pillar_slug}/{$city_slug} (ID {$page->ID}) — already has " . count( $existing ) . ' FAQs.' );
		$total_skipped++;
		continue;
	}

	$j    = $jurisdiction[ $office['state'] ];
	$vars = array(
		'{city}'       => $office['city'],
		'{state}'      => $office['state'],
		'{state_full}' => $office['state_full'],
		'{phone}'      => $office['phone'],
		'{court}'      => $office['court'],
		'{sol}'        => $j['sol'],
		'{sol_cite}'   => $j['sol_cite'],
		'{fault_pct}'  => $j['fault_pct'],
		'{fault_cite}' => $j['fault_cite'],
	);

	$faqs = array();
	foreach ( $faq_templates as $tpl ) {
		$faqs[] = array(
			'question' => str_replace( array_keys( $vars ), array_values( $vars ), $tpl['question'] ),
			'answer'   => str_replace( array_keys( $vars ), array_values( $vars ), $tpl['answer'] ),
		);
	}

	update_post_meta( $page->ID, '_roden_faqs', $faqs );
	WP_CLI::success( "{$pillar_slug}/{$city_slug} (ID {$page->ID}) — " . count( $faqs ) . ' FAQs added.' );
	$total_updated++;
}

WP_CLI::log( "\n--- SUMMARY ---" );
WP_CLI::log( "Updated : {$total_updated}" );
WP_CLI::log( "Skipped : {$total_skipped}" );
WP_CLI::log( 'Done.' );
