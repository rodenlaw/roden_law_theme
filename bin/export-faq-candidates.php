<?php
/**
 * Export published posts that carry NO _roden_faqs, with the body prose needed
 * to write grounded FAQ answers.
 *
 * WHY THIS EXISTS
 * ---------------
 * FAQ coverage is near-total on the page types that were seeded with it
 * (practice_area 99%, location 100%, resource 97%) and weak exactly where the
 * long-tail traffic lives: 339 of 486 published blog posts carry no FAQ block
 * at all (audit 2026-09-09). Those posts are the hyperlocal pages built to be
 * found by the same conversational queries AI answer engines field, and an
 * FAQ block is the format those engines quote most directly.
 *
 * A FAQ answer is published twice — visibly through roden_faq_section() and
 * again as FAQPage JSON-LD through roden_schema_faq_page() — so an invented
 * legal claim here is served to AI engines as structured data. That is why
 * this exports post_content: answers are to be written FROM the body prose
 * that already cleared review, never from recall. content/meta.json
 * deliberately omits bodies, so they have to come from here.
 *
 * Read-only. Writes nothing.
 *
 * Run:  ssh <prod> "wp --path=<site> eval-file - [type] [locale]" \
 *         < bin/export-faq-candidates.php > candidates.json
 *
 *   type    post type to scan   (default: post)
 *   locale  en | es | all       (default: en)
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}

$type   = isset( $args[0] ) ? $args[0] : 'post';
$locale = isset( $args[1] ) ? $args[1] : 'en';
if ( ! in_array( $locale, array( 'en', 'es', 'all' ), true ) ) {
	fwrite( STDERR, "Unknown locale '$locale'. Use en | es | all.\n" );
	exit( 1 );
}

$ids = get_posts( array(
	'post_type'        => $type,
	'post_status'      => 'publish',
	'posts_per_page'   => -1,
	'fields'           => 'ids',
	'orderby'          => 'ID',
	'order'            => 'ASC',
	'suppress_filters' => true,
) );

$out     = array();
$skipped = array( 'has_faqs' => 0, 'locale' => 0 );

foreach ( $ids as $id ) {
	$faqs = get_post_meta( $id, '_roden_faqs', true );
	if ( is_array( $faqs ) && ! empty( $faqs ) ) {
		$skipped['has_faqs']++;
		continue;
	}

	$post_locale = get_post_meta( $id, '_roden_locale', true ) === 'es' ? 'es' : 'en';
	if ( 'all' !== $locale && $post_locale !== $locale ) {
		$skipped['locale']++;
		continue;
	}

	$post = get_post( $id );
	$path = wp_parse_url( get_permalink( $id ), PHP_URL_PATH );

	// Headings give the drafter the post's own question surface without
	// having to re-derive structure from the raw HTML.
	preg_match_all( '#<h([23])[^>]*>(.*?)</h\1>#is', $post->post_content, $m );
	$headings = array_values( array_filter( array_map(
		static function ( $h ) {
			return trim( html_entity_decode( wp_strip_all_tags( $h ), ENT_QUOTES, 'UTF-8' ) );
		},
		$m[2]
	) ) );

	$out[ $path ] = array(
		'id'             => $id,
		'slug'           => $post->post_name,
		'locale'         => $post_locale,
		'title'          => $post->post_title,
		'excerpt'        => $post->post_excerpt,
		'modified'       => $post->post_modified_gmt,
		'jurisdiction'   => (string) get_post_meta( $id, '_roden_jurisdiction', true ),
		'sol_ga'         => (string) get_post_meta( $id, '_roden_sol_ga', true ),
		'sol_sc'         => (string) get_post_meta( $id, '_roden_sol_sc', true ),
		'author_attorney'=> (string) get_post_meta( $id, '_roden_author_attorney', true ),
		'last_reviewed'  => (string) get_post_meta( $id, '_roden_last_reviewed', true ),
		'key_takeaways'  => get_post_meta( $id, '_roden_key_takeaways', true ) ?: null,
		'categories'     => wp_get_post_terms( $id, 'category', array( 'fields' => 'names' ) ),
		'tags'           => wp_get_post_terms( $id, 'post_tag', array( 'fields' => 'names' ) ),
		'headings'       => $headings,
		'word_count'     => str_word_count( wp_strip_all_tags( $post->post_content ) ),
		'content'        => $post->post_content,
	);
}

ksort( $out );

fwrite( STDERR, sprintf(
	"type=%s locale=%s scanned=%d candidates=%d skipped_has_faqs=%d skipped_locale=%d\n",
	$type, $locale, count( $ids ), count( $out ), $skipped['has_faqs'], $skipped['locale']
) );

echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), "\n";
