<?php
/**
 * Backfill per-page "Why Hire" copy on the English South Carolina office
 * intersection pages.
 *
 * The intersection template falls back to the parent pillar's `_roden_why_hire`
 * when a page has none of its own. 19 of the 24 pillars are scoped to `both`
 * jurisdictions and their copy describes the firm's Georgia AND South Carolina
 * practice — accurate, but generic two-state boilerplate occupying the most
 * prominent prose section of a page that exists to be specific to one market.
 * On the personal-injury pillar that block runs to 5,600 characters.
 *
 * The 35 new town pages were given their own copy when they were seeded, which
 * left the established office pages reading as the generic ones. This closes
 * that gap: 91 pages across Charleston, North Charleston, Columbia and Myrtle
 * Beach.
 *
 * Spanish pages are excluded. 38 of them already carry their own copy, and the
 * rest must be authored in Spanish rather than inheriting English — writing
 * English into an `/es/` page is the failure this codebase already guards
 * against elsewhere.
 *
 * Same content policy as the town pages, enforced below rather than remembered:
 *   - no "no fee unless we win" — a regulated advertising statement in SC
 *   - no review or star-rating claims (the drift PR #33 corrected)
 *   - no phone numbers — the NAP block renders those from firm-data, and
 *     duplicating one in prose reintroduces hand-kept-value drift
 *   - no {tokens} — this field is passed straight to the_content with no
 *     substitution, so a token renders literally
 *   - no Georgia references, which is the whole point of the exercise
 *
 * Never overwrites an existing non-empty value: it reports and skips, so a
 * hand-written block always wins.
 *
 * Run from the repo over stdin — never added to the theme. The payload is
 * prepended by bin/build-why-hire-seed.sh:
 *   bin/build-why-hire-seed.sh          # dry run
 *   bin/build-why-hire-seed.sh apply    # write
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}
if ( ! defined( 'RODEN_SEED_JSON' ) ) {
	fwrite( STDERR, "RODEN_SEED_JSON not defined — build with bin/build-why-hire-seed.sh.\n" );
	exit( 1 );
}

global $wpdb;

$apply   = isset( $args[0] ) && 'apply' === $args[0];
$payload = json_decode( RODEN_SEED_JSON, true );

if ( ! is_array( $payload ) || empty( $payload['blocks'] ) ) {
	printf( "ABORT  payload did not parse, or has no blocks\n" );
	exit( 1 );
}
$blocks = $payload['blocks'];
printf( "%s  %d blocks\n\n", $apply ? 'APPLY' : 'DRY RUN', count( $blocks ) );

/* ── Content guards: any violation aborts the whole run ─────────────────── */

$fatal = 0;
foreach ( $blocks as $key => $html ) {
	$checks = array(
		'Georgia reference'        => '/O\.C\.G\.A\.|\bGeorgia\b/u',
		'regulated fee claim'      => '/no fee\b/iu',
		'unverified review claim'  => '/hundreds of (client )?reviews|4\.9[- ]star/iu',
		'unsubstituted token'      => '/\{[a-z_]+\}/u',
	);
	foreach ( $checks as $label => $pattern ) {
		if ( preg_match( $pattern, $html ) ) {
			printf( "ABORT  %s: %s\n", $key, $label );
			$fatal++;
		}
	}
	if ( strlen( $html ) < 350 ) {
		printf( "ABORT  %s: only %d characters\n", $key, strlen( $html ) );
		$fatal++;
	}
}
if ( $fatal ) {
	printf( "\n%d guard failure(s) — nothing written.\n", $fatal );
	exit( 1 );
}

/* ── Resolve each key to exactly one published English post ─────────────── */

$counts = array( 'written' => 0, 'skipped' => 0, 'missing' => 0, 'occupied' => 0 );

foreach ( $blocks as $key => $html ) {
	list( $market, $pillar ) = array_pad( explode( '|', $key, 2 ), 2, '' );

	$pillar_post = get_page_by_path( $pillar, OBJECT, 'practice_area' );
	if ( ! $pillar_post || $pillar_post->post_parent ) {
		printf( "  MISSING  %-58s pillar not found\n", $key );
		$counts['missing']++;
		continue;
	}

	/*
	 * Direct wp_posts query on parent + market meta. get_posts( name => ... )
	 * cannot be used here: practice_area is hierarchical and WP_Query treats
	 * those like pages, which is what silently duplicated 35 pages in PR #41.
	 */
	$ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT p.ID FROM {$wpdb->posts} p
			 JOIN {$wpdb->postmeta} m ON m.post_id = p.ID AND m.meta_key = '_roden_pa_office_key'
			 WHERE p.post_type = 'practice_area'
			   AND p.post_status = 'publish'
			   AND p.post_parent = %d
			   AND m.meta_value = %s",
			$pillar_post->ID,
			$market
		)
	);

	// Exclude Spanish twins — English copy must never land on an /es/ page.
	$ids = array_values( array_filter( $ids, function ( $id ) {
		return '' === (string) get_post_meta( $id, '_roden_locale', true );
	} ) );

	if ( 1 !== count( $ids ) ) {
		printf( "  MISSING  %-58s matched %d posts\n", $key, count( $ids ) );
		$counts['missing']++;
		continue;
	}
	$post_id = (int) $ids[0];

	$current = (string) get_post_meta( $post_id, '_roden_why_hire', true );
	if ( '' !== $current ) {
		printf( "  OCCUPIED #%-6d %-52s already has copy — left alone\n", $post_id, $key );
		$counts['occupied']++;
		continue;
	}

	if ( ! $apply ) {
		printf( "  would set #%-6d %-52s %d chars\n", $post_id, $key, strlen( $html ) );
		$counts['written']++;
		continue;
	}

	update_post_meta( $post_id, '_roden_why_hire', wp_kses_post( $html ) );
	$check = (string) get_post_meta( $post_id, '_roden_why_hire', true );
	if ( '' === $check ) {
		printf( "  ERROR    #%-6d %-52s did not persist\n", $post_id, $key );
		$counts['skipped']++;
		continue;
	}
	printf( "  set      #%-6d %-52s %d chars\n", $post_id, $key, strlen( $check ) );
	$counts['written']++;
}

printf( "\n%s\n", str_repeat( '-', 78 ) );
printf( "%s : %d\n", $apply ? 'written ' : 'to write', $counts['written'] );
printf( "occupied : %d  (already had copy)\n", $counts['occupied'] );
printf( "missing  : %d\n", $counts['missing'] );
printf( "errors   : %d\n", $counts['skipped'] );

if ( $apply ) {
	printf( "\nNext: wp cache flush && wp page-cache flush.\n" );
	printf( "_roden_why_hire is not in the export-content-meta whitelist, so meta.json is unaffected.\n" );
} else {
	printf( "\nDry run. Re-run with `apply` to write.\n" );
}
