<?php
/**
 * Seeder: FAQs for the 6 city office Location pages
 *
 * Targets: /locations/{state-slug}/{office-slug}/
 *   savannah, darien, charleston, north-charleston, columbia, myrtle-beach
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-location-city-faqs.php
 *
 * Idempotent — skips any office page that already has a non-empty _roden_faqs.
 *
 * Background: F3 from the 2026-05-05 landing page audit. The location template
 * (templates/template-location.php) only renders the FAQ accordion + FAQPage
 * schema when _roden_faqs is non-empty. City office pages were created manually
 * and never received FAQs, so the schema disappears entirely. This seeder fills
 * each with 6 office-specific Q&As keyed off firm-data.
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WP_CLI' ) ) {
	echo "Run via WP-CLI: wp eval-file wp-content/themes/roden-law/inc/seed-location-city-faqs.php\n";
	exit( 1 );
}

if ( ! function_exists( 'roden_firm_data' ) ) {
	require_once get_template_directory() . '/inc/firm-data.php';
}

$firm = roden_firm_data();

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

/* FAQ templates — 6 Q&As per office. Tokens:
   {city} = market_name (e.g., "Myrtle Beach"); {full_address} = full mailing address.
   {state} {state_full} {phone} {court} {service_area}
   {sol} {sol_cite} {fault_pct} {fault_cite} */
$faq_templates = array(
	array(
		'question' => 'Does Roden Law have a personal injury office in {city}?',
		'answer'   => 'Yes. Roden Law operates a {city} office at {full_address}. Our {city} personal injury attorneys handle car, truck, motorcycle, and serious injury cases throughout {service_area} You can reach the office directly at {phone}. We offer free consultations and handle every case on a contingency fee basis — no fees unless we win.',
	),
	array(
		'question' => 'What types of personal injury cases does the {city} office handle?',
		'answer'   => 'Our {city} attorneys handle the full range of personal injury matters: car and SUV accidents, commercial truck and 18-wheeler crashes, motorcycle and bicycle accidents, pedestrian injuries, slip-and-fall and other premises liability cases, dog bites, medical malpractice, nursing home abuse, workers\' compensation claims, wrongful death, and catastrophic injury cases involving brain injury, spinal cord injury, or severe burns. If you were injured because of someone else\'s negligence in or around {city}, call {phone} for a free case review.',
	),
	array(
		'question' => 'How long do I have to file a personal injury lawsuit in {state_full}?',
		'answer'   => '{state_full} sets a {sol} statute of limitations for most personal injury claims ({sol_cite}). The clock generally starts on the date of the injury, and missing the deadline almost always bars recovery — courts dismiss late filings regardless of how strong the case is on the merits. Shorter notice periods apply if a government entity is involved (a city, county, or state agency). Because evidence and witness memories degrade quickly, our {city} office recommends contacting an attorney as soon as possible after an accident. Call {phone}.',
	),
	array(
		'question' => 'How does {state_full}\'s comparative fault rule affect my case?',
		'answer'   => '{state_full} applies a modified comparative fault rule ({fault_cite}). If you are less than {fault_pct}% at fault for the accident, you can still recover compensation, but your award is reduced by your percentage of fault — for example, a $100,000 award reduced 20% for partial fault pays $80,000. If you are {fault_pct}% or more at fault, you recover nothing. Insurers routinely try to inflate the injured person\'s share of fault to reduce or eliminate the payout, which is why having a {city} personal injury attorney challenge those arguments matters so much.',
	),
	array(
		'question' => 'What does it cost to hire the {city} office?',
		'answer'   => 'Nothing up front. Roden Law\'s {city} attorneys handle personal injury cases on a contingency fee — our fee is a percentage of what we recover for you, and if we do not win, you owe no attorney fee. The initial case review is always free. This structure is designed so that anyone injured in or around {city} can access experienced legal representation regardless of their financial situation. Call {phone} and we will explain the full fee structure during your free consultation.',
	),
	array(
		'question' => 'Which communities around {city} does the office serve?',
		'answer'   => 'From our {city} location, we represent injury victims throughout {service_area} All cases are filed in the appropriate venue — for matters arising in our primary service area, that is typically {court}, where our attorneys appear regularly. If you are not sure whether your accident location falls within our service area, call {phone} and our intake team can confirm immediately.',
	),
);

/* ------------------------------------------------------------------
   Process each office
   ------------------------------------------------------------------ */

$total_updated = 0;
$total_skipped = 0;
$total_missing = 0;

foreach ( $firm['offices'] as $office_key => $office ) {

	$state_slug  = $office['state_slug'];
	$office_slug = $office['slug'];
	if ( strpos( $office_slug, '-' ) !== false ) {
		// firm-data 'slug' is "savannah-ga"; the post slug is just "savannah".
		$office_slug = preg_replace( '/-(ga|sc)$/', '', $office_slug );
	}
	$path = $state_slug . '/' . $office_slug;

	$page = get_page_by_path( $path, OBJECT, 'location' );
	if ( ! $page ) {
		WP_CLI::warning( "MISSING: location post not found at path '{$path}' (office '{$office_key}')." );
		$total_missing++;
		continue;
	}

	$existing = get_post_meta( $page->ID, '_roden_faqs', true );
	if ( is_array( $existing ) && count( $existing ) > 0 ) {
		WP_CLI::log( "SKIP {$path} (ID {$page->ID}) — already has " . count( $existing ) . ' FAQs.' );
		$total_skipped++;
		continue;
	}

	$state_key = $office['state'];
	if ( ! isset( $jurisdiction[ $state_key ] ) ) {
		WP_CLI::warning( "Unknown state '{$state_key}' for office '{$office_key}', skipping." );
		continue;
	}
	$j = $jurisdiction[ $state_key ];

	$market = ! empty( $office['market_name'] ) ? $office['market_name'] : $office['city'];
	$full_address = $office['street'] . ', ' . $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'];

	$vars = array(
		'{city}'          => $market,
		'{full_address}'  => $full_address,
		'{state}'         => $office['state'],
		'{state_full}'    => $office['state_full'],
		'{phone}'         => $office['phone'],
		'{court}'         => $office['court'],
		'{service_area}'  => $office['service_area'],
		'{sol}'           => $j['sol'],
		'{sol_cite}'      => $j['sol_cite'],
		'{fault_pct}'     => $j['fault_pct'],
		'{fault_cite}'    => $j['fault_cite'],
	);

	$faqs = array();
	foreach ( $faq_templates as $tpl ) {
		$faqs[] = array(
			'question' => str_replace( array_keys( $vars ), array_values( $vars ), $tpl['question'] ),
			'answer'   => str_replace( array_keys( $vars ), array_values( $vars ), $tpl['answer'] ),
		);
	}

	update_post_meta( $page->ID, '_roden_faqs', $faqs );
	WP_CLI::success( "{$path} (ID {$page->ID}) — " . count( $faqs ) . ' FAQs added.' );
	$total_updated++;
}

WP_CLI::log( "\n--- SUMMARY ---" );
WP_CLI::log( "Updated : {$total_updated}" );
WP_CLI::log( "Skipped : {$total_skipped} (already had FAQs)" );
WP_CLI::log( "Missing : {$total_missing} (location post not found)" );
WP_CLI::log( 'Done.' );
