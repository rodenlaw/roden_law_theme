<?php
/**
 * Seeder: Sync neighborhood FAQs from JSON sources to _roden_faqs meta
 *
 * Walks every entry across inc/data/*-neighborhoods.json and writes its
 * `faqs` array to the matching neighborhood post — but only when the post's
 * existing _roden_faqs is empty. Idempotent and safe to re-run.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-neighborhood-faqs-sync.php
 *
 * Background: F3 from the 2026-05-05 landing page audit. The neighborhood
 * batch creators (inc/batch-create-*.php) write _roden_faqs only at post-create
 * time. Any neighborhood whose JSON FAQs were added or edited after the post
 * was created — or whose post pre-dates the FAQs in the JSON — has empty meta
 * and the FAQ schema disappears entirely from the page. This sync corrects
 * that drift without touching pages a human has already populated.
 *
 * Match strategy: post slug + _roden_parent_office_key. Avoids brittle
 * parent-path assumptions (the North Charleston post path has shifted
 * historically across batch creators).
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WP_CLI' ) ) {
	echo "Run via WP-CLI: wp eval-file wp-content/themes/roden-law/inc/seed-neighborhood-faqs-sync.php\n";
	exit( 1 );
}

/* ------------------------------------------------------------------
   Map each JSON file to the parent_office_key its entries belong to.
   Sub-neighborhood JSONs (nested) carry parent_slug per block from
   which we derive the office_key.
   ------------------------------------------------------------------ */
$flat_office_map = array(
	'savannah-neighborhoods.json'                  => 'savannah',
	'darien-neighborhoods.json'                    => 'darien',
	'effingham-county-neighborhoods.json'          => 'savannah',
	'charleston-neighborhoods.json'                => 'charleston',
	'downtown-charleston-neighborhoods.json'       => 'charleston',
	'mount-pleasant-neighborhoods.json'            => 'charleston',
	'west-ashley-neighborhoods.json'               => 'charleston',
	'summerville-neighborhoods.json'               => 'north-charleston',
	'goose-creek-neighborhoods.json'               => 'north-charleston',
	'north-charleston-neighborhoods.json'          => 'north-charleston',
	'north-charleston-expanded-neighborhoods.json' => 'north-charleston',
	'columbia-neighborhoods.json'                  => 'columbia',
	'myrtle-beach-neighborhoods.json'              => 'myrtle-beach',
);

$nested_files = array(
	'savannah-sub-neighborhoods.json'      => 'savannah',
	'myrtle-beach-sub-neighborhoods.json'  => 'myrtle-beach',
);

$data_dir = get_template_directory() . '/inc/data';
if ( ! is_dir( $data_dir ) ) {
	WP_CLI::error( "Data directory not found: {$data_dir}" );
	return;
}

/* ------------------------------------------------------------------
   Build (office_key, slug) -> faqs map AND a slug -> [office_keys]
   index for fallback matching.
   ------------------------------------------------------------------ */
$json_index    = array(); // "office|slug" => faqs
$slug_to_keys  = array(); // slug => [office_key, ...]

$add_entry = function ( $office_key, $n ) use ( &$json_index, &$slug_to_keys ) {
	if ( empty( $n['slug'] ) || empty( $n['faqs'] ) || ! is_array( $n['faqs'] ) ) {
		return;
	}
	$json_index[ $office_key . '|' . $n['slug'] ] = $n['faqs'];
	$slug_to_keys[ $n['slug'] ][] = $office_key;
};

foreach ( $flat_office_map as $filename => $office_key ) {
	$path = $data_dir . '/' . $filename;
	if ( ! file_exists( $path ) ) { WP_CLI::warning( "Data file missing: {$filename}" ); continue; }
	$data = json_decode( file_get_contents( $path ), true );
	if ( ! is_array( $data ) ) { WP_CLI::warning( "Failed to parse JSON: {$filename}" ); continue; }
	foreach ( $data as $n ) { $add_entry( $office_key, $n ); }
}

foreach ( $nested_files as $filename => $office_key ) {
	$path = $data_dir . '/' . $filename;
	if ( ! file_exists( $path ) ) { WP_CLI::warning( "Data file missing: {$filename}" ); continue; }
	$data = json_decode( file_get_contents( $path ), true );
	if ( ! is_array( $data ) ) { WP_CLI::warning( "Failed to parse JSON: {$filename}" ); continue; }
	foreach ( $data as $block ) {
		if ( empty( $block['neighborhoods'] ) || ! is_array( $block['neighborhoods'] ) ) { continue; }
		foreach ( $block['neighborhoods'] as $n ) { $add_entry( $office_key, $n ); }
	}
}

WP_CLI::log( sprintf( 'Loaded %d neighborhood FAQ sets from JSON.', count( $json_index ) ) );

/* ------------------------------------------------------------------
   Find every neighborhood post and try to fill empty FAQs
   ------------------------------------------------------------------ */
$posts = get_posts( array(
	'post_type'      => 'location',
	'posts_per_page' => -1,
	'post_status'    => array( 'publish', 'draft', 'private', 'pending' ),
	'meta_query'     => array(
		array(
			'key'     => '_roden_is_neighborhood',
			'compare' => 'EXISTS',
		),
	),
) );

WP_CLI::log( sprintf( 'Found %d neighborhood posts in WP.', count( $posts ) ) );

$updated   = 0;
$skipped   = 0;
$no_match  = 0;
$no_office = 0;

foreach ( $posts as $page ) {
	$is_neigh = get_post_meta( $page->ID, '_roden_is_neighborhood', true );
	if ( empty( $is_neigh ) ) {
		continue;
	}

	$existing = get_post_meta( $page->ID, '_roden_faqs', true );
	if ( is_array( $existing ) && count( $existing ) > 0 ) {
		$skipped++;
		continue;
	}

	$office_key = get_post_meta( $page->ID, '_roden_parent_office_key', true );
	if ( ! $office_key ) {
		WP_CLI::log( "NO-OFFICE {$page->post_name} (ID {$page->ID}) — _roden_parent_office_key missing." );
		$no_office++;
		continue;
	}

	$key = $office_key . '|' . $page->post_name;
	$faqs_src = null;
	if ( isset( $json_index[ $key ] ) ) {
		$faqs_src = $json_index[ $key ];
	} elseif ( isset( $slug_to_keys[ $page->post_name ] ) && count( array_unique( $slug_to_keys[ $page->post_name ] ) ) === 1 ) {
		// Slug appears under exactly one office in JSON — safe to use even if
		// post's _roden_parent_office_key disagrees (e.g., fix-neighborhood-
		// office-keys.php hasn't run yet). Skip ambiguous slugs.
		$alt_key = $slug_to_keys[ $page->post_name ][0] . '|' . $page->post_name;
		$faqs_src = $json_index[ $alt_key ];
		WP_CLI::log( "FALLBACK {$office_key}/{$page->post_name} → matched via {$slug_to_keys[ $page->post_name ][0]}" );
	}

	if ( ! $faqs_src ) {
		WP_CLI::log( "NO-MATCH {$office_key}/{$page->post_name} (ID {$page->ID}) — no JSON entry." );
		$no_match++;
		continue;
	}

	$clean = array();
	foreach ( $faqs_src as $faq ) {
		if ( ! empty( $faq['question'] ) && ! empty( $faq['answer'] ) ) {
			$clean[] = array(
				'question' => (string) $faq['question'],
				'answer'   => (string) $faq['answer'],
			);
		}
	}

	if ( empty( $clean ) ) {
		$no_match++;
		continue;
	}

	update_post_meta( $page->ID, '_roden_faqs', $clean );
	WP_CLI::success( "{$office_key}/{$page->post_name} (ID {$page->ID}) — " . count( $clean ) . ' FAQs added.' );
	$updated++;
}

WP_CLI::log( "\n--- SUMMARY ---" );
WP_CLI::log( "Updated     : {$updated}" );
WP_CLI::log( "Skipped     : {$skipped} (already had FAQs)" );
WP_CLI::log( "No JSON     : {$no_match}" );
WP_CLI::log( "No office   : {$no_office} (post missing _roden_parent_office_key)" );
WP_CLI::log( 'Done.' );
