<?php
/**
 * Seed Spanish practice-area pages (pillars and PA × city intersections).
 *
 * WHY THIS EXISTS
 * ---------------
 * The original Phase-1 seeders lived in the theme's inc/es/ and were deleted
 * with the other 286 spent one-shots (bbae8f1) — correctly, because a spent
 * seeder sitting in inc/ reads as authoritative and isn't. This is their
 * replacement, living in the repo's bin/ where it is piped to prod over stdin
 * and never deployed.
 *
 * THE INVARIANT IT PROTECTS
 * -------------------------
 * Spanish twins keep drifting from their English originals in ways nobody sees
 * until months later — workers' comp pages carried the TORT statute of
 * limitations on the ES side for three weeks after the EN side was fixed. So
 * this script does NOT let the writer supply legal or structural facts.
 * Everything load-bearing is copied from the English twin:
 *
 *   _roden_office_key, _roden_pa_office_key, _roden_jurisdiction,
 *   _roden_author_attorney, _roden_state_scope, and the SOL fields.
 *
 * The statute strings are localised by translating ONLY the English word for
 * the unit of time; the citation itself is copied byte-for-byte and can never
 * be retyped, reordered or hallucinated. "3 years (S.C. Code § 15-3-530)"
 * becomes "3 años (S.C. Code § 15-3-530)".
 *
 * The draft supplies prose only: title, body, meta description, hero intro,
 * why-hire, key takeaways, accident phrase, FAQs.
 *
 * PAYLOAD
 * -------
 * Expects the constant RODEN_SEED_JSON to hold the draft JSON. Do not hand-roll
 * that header — use the builder, which prepends the payload and leaves PHP mode
 * open so this file's body still parses as code:
 *
 *   bin/es-build-seed.sh drafts.json > /tmp/seed.php
 *   ssh <prod> "wp --path=<site> eval-file - apply" < /tmp/seed.php
 *
 * (Keep literal PHP open tags out of this comment. The payload header is
 * concatenated ahead of it, so an open tag inside a comment would re-enter PHP
 * mode mid-docblock and fail to parse.)
 *
 * Modes: dry-run (default) | apply. Idempotent — a page whose EN twin already
 * has a published _roden_translation_es is skipped, so re-running is safe.
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}
if ( ! defined( 'RODEN_SEED_JSON' ) ) {
	fwrite( STDERR, "RODEN_SEED_JSON is not defined — see the header for how to build the payload.\n" );
	exit( 1 );
}

$mode = isset( $args[0] ) ? $args[0] : 'dry-run';
if ( ! in_array( $mode, array( 'dry-run', 'apply' ), true ) ) {
	fwrite( STDERR, "Unknown mode '$mode'. Use dry-run | apply.\n" );
	exit( 1 );
}

$payload = json_decode( RODEN_SEED_JSON, true );
if ( ! is_array( $payload ) ) {
	fwrite( STDERR, 'Payload is not valid JSON: ' . json_last_error_msg() . "\n" );
	exit( 1 );
}

/** Meta copied verbatim from the English twin — never authored in Spanish. */
$inherit = array(
	'_roden_office_key',
	'_roden_pa_office_key',
	'_roden_jurisdiction',
	'_roden_author_attorney',
	'_roden_state_scope',
);

/** Prose fields the draft may supply, mapped to their meta keys. */
$authored = array(
	'meta_description'          => '_roden_meta_description',
	'hero_intro'                => '_roden_hero_intro',
	'why_hire'                  => '_roden_why_hire',
	'key_takeaways'             => '_roden_key_takeaways',
	'accident_phrase'           => '_roden_accident_phrase',
	'common_causes'             => '_roden_common_causes',
	'common_injuries'           => '_roden_common_injuries',
	'pillar_negligence_intro'   => '_roden_pillar_negligence_intro',
	'pillar_compensation_intro' => '_roden_pillar_compensation_intro',
	'faqs'                      => '_roden_faqs',
);

/**
 * Localise a statute string without touching the citation.
 *
 * Only the English unit word is replaced. Everything else — the number, the
 * section symbol, the code name, the parentheses — survives byte-for-byte.
 */
$es_statute = function ( $en ) {
	$en = (string) $en;
	if ( '' === $en ) {
		return '';
	}
	return preg_replace_callback(
		'/\b(\d+)\s+(years?)\b/i',
		function ( $m ) {
			return $m[1] . ' ' . ( 1 === (int) $m[1] ? 'año' : 'años' );
		},
		$en
	);
};

$created = 0;
$skipped = 0;
$errors  = 0;

foreach ( $payload as $en_path => $d ) {
	$en_id = url_to_postid( home_url( $en_path ) );
	if ( ! $en_id ) {
		printf( "ERROR  %-52s English twin not found\n", $en_path );
		$errors++;
		continue;
	}

	$existing = (int) get_post_meta( $en_id, '_roden_translation_es', true );
	if ( $existing && in_array( get_post_status( $existing ), array( 'publish', 'draft' ), true ) ) {
		printf( "SKIP   %-52s already has ES twin #%d\n", $en_path, $existing );
		$skipped++;
		continue;
	}

	$en_post = get_post( $en_id );

	// Parent + slug. Intersections hang off the ES pillar and keep the plain
	// city slug (uniqueness is per parent); top-level pillars take the 'es-'
	// prefix, which the permalink filter strips for the public URL.
	if ( $en_post->post_parent ) {
		$en_parent_slug = get_post_field( 'post_name', $en_post->post_parent );
		$es_parent      = get_page_by_path( 'es-' . $en_parent_slug, OBJECT, $en_post->post_type );
		if ( ! $es_parent || 'publish' !== $es_parent->post_status ) {
			printf( "ERROR  %-52s no published ES parent (es-%s)\n", $en_path, $en_parent_slug );
			$errors++;
			continue;
		}
		$parent_id = $es_parent->ID;
		$slug      = $en_post->post_name;
	} else {
		$parent_id = 0;
		$slug      = 'es-' . $en_post->post_name;
	}

	$postarr = array(
		'post_type'    => $en_post->post_type,
		'post_status'  => 'publish',
		'post_title'   => $d['title'],
		'post_name'    => $slug,
		'post_content' => isset( $d['content'] ) ? $d['content'] : '',
		'post_parent'  => $parent_id,
		'post_author'  => $en_post->post_author,
		'menu_order'   => $en_post->menu_order,
	);

	printf(
		"%s %-52s -> parent %d, slug '%s', %d chars, %d FAQs\n",
		( 'apply' === $mode ? 'CREATE' : 'WOULD ' ),
		$en_path,
		$parent_id,
		$slug,
		strlen( $postarr['post_content'] ),
		isset( $d['faqs'] ) ? count( $d['faqs'] ) : 0
	);

	if ( 'dry-run' === $mode ) {
		$created++;
		continue;
	}

	$es_id = wp_insert_post( $postarr, true );
	if ( is_wp_error( $es_id ) ) {
		printf( "ERROR  %-52s %s\n", $en_path, $es_id->get_error_message() );
		$errors++;
		continue;
	}

	// Structural + legal meta: inherited, never authored.
	foreach ( $inherit as $k ) {
		$v = get_post_meta( $en_id, $k, true );
		if ( '' !== $v && array() !== $v ) {
			update_post_meta( $es_id, $k, $v );
		}
	}
	foreach ( array( '_roden_sol_ga', '_roden_sol_sc' ) as $k ) {
		$v = get_post_meta( $en_id, $k, true );
		if ( '' !== $v ) {
			update_post_meta( $es_id, $k, $es_statute( $v ) );
		}
	}

	// Prose: authored.
	foreach ( $authored as $field => $key ) {
		if ( isset( $d[ $field ] ) && '' !== $d[ $field ] && array() !== $d[ $field ] ) {
			update_post_meta( $es_id, $key, $d[ $field ] );
		}
	}

	// Locale + reciprocal translation link. hreflang only emits when BOTH
	// sides point at each other and the counterpart is published.
	update_post_meta( $es_id, '_roden_locale', 'es' );
	update_post_meta( $es_id, '_roden_translation_of', $en_id );
	update_post_meta( $es_id, '_roden_last_reviewed', gmdate( 'Y-m-d' ) );
	update_post_meta( $en_id, '_roden_translation_es', $es_id );

	printf( "       created #%d  %s\n", $es_id, wp_make_link_relative( roden_get_canonical_url( $es_id ) ) );
	$created++;
}

printf(
	"\nmode=%s  %s=%d  skipped=%d  errors=%d\n",
	$mode,
	( 'apply' === $mode ? 'created' : 'would create' ),
	$created,
	$skipped,
	$errors
);
if ( 'apply' === $mode && $created ) {
	echo "Remember: wp rewrite flush, then wp cache flush && wp page-cache flush.\n";
	echo "Then re-run bin/es-relink-body-links.php — new twins make more body links resolvable.\n";
}
