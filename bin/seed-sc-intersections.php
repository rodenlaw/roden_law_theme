<?php
/**
 * Seed practice-area × town intersection pages for South Carolina.
 *
 * Phase 2 of the 2026-08-19 GEO/SC audit. PR #37 added a `service_areas` tier to
 * firm-data.php so an intersection page can exist for a town the firm serves but
 * does not have an office in; this creates those pages.
 *
 * The page set is driven by phrase-verified Semrush volume at KD 0–15, not by
 * matching a competitor's page count. Steinberg runs ~50 SC city pages and
 * cannibalises itself — four of their URLs compete for "goose creek car accident
 * lawyer". One page per intent is the point.
 *
 * WHAT A SEEDED PAGE INHERITS. Very little is written here, by design. The
 * intersection template resolves the market through roden_market() and renders
 * the office/service-area `local_context` essay, the jurisdiction box, the
 * what-to-do steps, the sub-type grid, attorneys, case results and resources on
 * its own. `_roden_why_hire`, `_roden_expert_quote` and the pillar negligence /
 * compensation intros all fall back to the parent pillar. So a page needs its
 * market key, its jurisdiction, its statute, its author and its own FAQs — and
 * that is what this writes.
 *
 * `_roden_sol_*` is inherited FROM THE PILLAR rather than hardcoded. That is not
 * a shortcut: workers' compensation runs on S.C. Code § 42-15-40 and medical
 * malpractice on § 15-3-545, so stamping the tort statute § 15-3-530 across
 * every page would publish the wrong deadline on exactly the pages where the
 * deadline is shortest. Same class of error as the workers'-comp SOL bug
 * CLAUDE.md records.
 *
 * Everything is created as a DRAFT. `publish` is a separate, explicit step and
 * refuses any page that has no FAQs, so a thin page cannot go live by accident.
 *
 * Run from the repo over stdin — never added to the theme:
 *   ssh rodenlawprod "wp --path=$P eval-file -"                 < bin/seed-sc-intersections.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply"           < bin/seed-sc-intersections.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply publish"   < bin/seed-sc-intersections.php
 *
 * The JSON payload is prepended by bin/build-sc-intersection-seed.sh, matching
 * the transport used by bin/es-seed-pages.php — nothing outside the site
 * directory persists on WP Engine between SSH sessions, and scp/sftp are refused.
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}
if ( ! defined( 'RODEN_SEED_JSON' ) ) {
	fwrite( STDERR, "RODEN_SEED_JSON not defined — build with bin/build-sc-intersection-seed.sh.\n" );
	exit( 1 );
}

$apply   = in_array( 'apply', (array) $args, true );
$publish = in_array( 'publish', (array) $args, true );

$payload = json_decode( RODEN_SEED_JSON, true );
if ( ! is_array( $payload ) || empty( $payload['pages'] ) ) {
	printf( "ABORT  payload did not parse, or has no pages\n" );
	exit( 1 );
}

global $wpdb;

$firm = roden_firm_data();

/* ── Pre-flight 1: the author must resolve to a published attorney ───────── */

$expected_author = $payload['_author'] ?? '';
$author_posts    = $expected_author
	? get_posts( array( 'post_type' => 'attorney', 'post_status' => 'publish', 'title' => $expected_author, 'numberposts' => 1, 'suppress_filters' => false ) )
	: array();
if ( ! $author_posts ) {
	printf( "ABORT  no published attorney post titled \"%s\"\n", $expected_author );
	exit( 1 );
}
$author_id = (int) $author_posts[0]->ID;
printf( "author        #%d %s\n", $author_id, $author_posts[0]->post_title );

/* ── Pre-flight 2: every market and pillar must exist ────────────────────── */

$fatal = 0;
foreach ( $payload['pages'] as $i => $p ) {
	$market = roden_market( $p['market'] ?? '' );
	if ( ! $market ) {
		printf( "ABORT  page %d: market \"%s\" resolves to neither an office nor a service area\n", $i, $p['market'] ?? '' );
		$fatal++;
		continue;
	}
	if ( 'SC' !== $market['state'] ) {
		printf( "ABORT  page %d: market \"%s\" is not in South Carolina (%s)\n", $i, $p['market'], $market['state'] );
		$fatal++;
	}
	$pillar = get_page_by_path( $p['pillar'] ?? '', OBJECT, 'practice_area' );
	if ( ! $pillar || $pillar->post_parent ) {
		printf( "ABORT  page %d: \"%s\" is not a top-level practice_area pillar\n", $i, $p['pillar'] ?? '' );
		$fatal++;
	}
}
if ( $fatal ) {
	printf( "\n%d pre-flight failure(s) — nothing written.\n", $fatal );
	exit( 1 );
}

/* ── Pre-flight 3: jurisdiction ↔ citation, on every FAQ answer ──────────
 * An SC page must not cite Georgia law. This is the guard against the
 * shared-template jurisdiction bug that has recurred five times on this site.
 */

foreach ( $payload['pages'] as $i => $p ) {
	$guarded = array();
	foreach ( (array) ( $p['faqs'] ?? array() ) as $faq ) {
		$guarded[] = array( 'question' => $faq['question'] ?? '', 'answer' => $faq['answer'] ?? '' );
	}
	// Why Hire copy is published prose too — hold it to the same standard.
	if ( ! empty( $p['why_hire'] ) ) {
		$guarded[] = array( 'question' => '', 'answer' => $p['why_hire'] );
	}
	foreach ( $guarded as $faq ) {
		$text = ( $faq['question'] ?? '' ) . ' ' . ( $faq['answer'] ?? '' );
		if ( preg_match( '/O\.C\.G\.A\./u', $text ) ) {
			printf( "ABORT  page %d (%s/%s): Georgia statute cited on a South Carolina page\n", $i, $p['pillar'], $p['market'] );
			$fatal++;
		}
		/*
		 * The review claim PR #33 corrected. Existing intersection FAQs still
		 * assert "4.9 stars from hundreds of client reviews" against a real
		 * total of 170 across six offices; do not seed more of it.
		 */
		if ( preg_match( '/hundreds of (client )?reviews|4\.9[- ]star/iu', $text ) ) {
			printf( "ABORT  page %d (%s/%s): FAQ repeats an unverified review claim\n", $i, $p['pillar'], $p['market'] );
			$fatal++;
		}
	}
}
if ( $fatal ) {
	printf( "\n%d content guard failure(s) — nothing written.\n", $fatal );
	exit( 1 );
}

printf( "\n%s  %d pages\n\n", $publish ? 'APPLY + PUBLISH' : ( $apply ? 'APPLY (draft)' : 'DRY RUN' ), count( $payload['pages'] ) );

/* ── Seed ───────────────────────────────────────────────────────────────── */

$counts = array( 'created' => 0, 'updated' => 0, 'published' => 0, 'skipped' => 0, 'blocked' => 0 );

foreach ( $payload['pages'] as $p ) {
	$market      = roden_market( $p['market'] );
	$pillar      = get_page_by_path( $p['pillar'], OBJECT, 'practice_area' );
	$slug        = $market['slug'];                    // e.g. 'summerville-sc'
	$market_name = $market['market_name'];
	$faqs        = (array) ( $p['faqs'] ?? array() );

	// Title convention matches the existing 132 intersections:
	// "{Pillar Title} in {Market}, {ST}".
	$title = sprintf( '%s in %s, %s', $pillar->post_title, $market_name, $market['state'] );

	/*
	 * Idempotency: one child of this pillar with this slug.
	 *
	 * Queried directly against wp_posts rather than through get_posts( name => ... ).
	 * `practice_area` is a HIERARCHICAL post type, and WP_Query treats those like
	 * pages — `name` does not reliably match, so the lookup silently returned
	 * nothing and a second run created a complete duplicate set of all 35 pages
	 * (2026-08-19; the duplicates were trashed). A direct parent+slug query is
	 * exact and cannot be defeated by post-type hierarchy or status filtering.
	 *
	 * 'trash' is excluded so a trashed duplicate is never resurrected, but every
	 * other status is matched so a hand-published page is found and updated
	 * rather than duplicated.
	 */
	$post_id = (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts}
			 WHERE post_type = 'practice_area'
			   AND post_parent = %d
			   AND post_name = %s
			   AND post_status != 'trash'
			 ORDER BY ID ASC LIMIT 1",
			$pillar->ID,
			$slug
		)
	);
	$existing = $post_id ? array( get_post( $post_id ) ) : array();

	// A page with no FAQs may be drafted but never published — it would ship
	// with no FAQPage schema and nothing town-specific in the body.
	if ( $publish && ! $faqs ) {
		printf( "  BLOCKED  %-34s %-22s no FAQs — refusing to publish\n", $p['pillar'], $slug );
		$counts['blocked']++;
		continue;
	}

	$target_status = $publish ? 'publish' : 'draft';

	if ( ! $apply ) {
		printf( "  would %-7s %-34s %-22s %d FAQs%s\n",
			$post_id ? 'update' : 'create', $p['pillar'], $slug, count( $faqs ),
			empty( $p['why_hire'] ) ? '  (no why_hire — will inherit pillar copy)' : ' + why_hire' );
		$counts[ $post_id ? 'updated' : 'created' ]++;
		continue;
	}

	$postarr = array(
		'post_type'   => 'practice_area',
		'post_title'  => $title,
		'post_name'   => $slug,
		'post_parent' => $pillar->ID,
		'post_status' => $target_status,
	);
	if ( $post_id ) {
		$postarr['ID'] = $post_id;
		// Never demote a page someone has already published by hand.
		if ( ! $publish && 'publish' === $existing[0]->post_status ) {
			unset( $postarr['post_status'] );
		}
		$res = wp_update_post( $postarr, true );
	} else {
		$res = wp_insert_post( $postarr, true );
	}

	if ( is_wp_error( $res ) ) {
		printf( "  ERROR    %-34s %-22s %s\n", $p['pillar'], $slug, $res->get_error_message() );
		$counts['skipped']++;
		continue;
	}
	$was_new = ! $post_id;
	$post_id = (int) ( $post_id ?: $res );

	// Meta. SOL comes from the pillar so statutory schemes keep their own
	// deadline; jurisdiction, market key and author are ours.
	$meta = array(
		'_roden_pa_office_key'   => $p['market'],
		'_roden_jurisdiction'    => $payload['_jurisdiction'] ?? 'SC',
		'_roden_author_attorney' => $author_id,
	);
	// Inherit ONLY the statute for this page's jurisdiction. Pillars scoped to
	// `both` carry _roden_sol_ga as well, and copying it onto a South Carolina
	// page leaves a Georgia deadline sitting in the meta of an SC page — latent
	// fuel for the shared-template jurisdiction bug that has recurred five times
	// here. The established convention on the existing SC intersections is to
	// carry the SC statute alone.
	$jurisdiction = $payload['_jurisdiction'] ?? 'SC';
	$sol_key      = ( 'GA' === $jurisdiction ) ? '_roden_sol_ga' : '_roden_sol_sc';
	$drop_key     = ( 'GA' === $jurisdiction ) ? '_roden_sol_sc' : '_roden_sol_ga';
	$inherited    = get_post_meta( $pillar->ID, $sol_key, true );
	if ( '' !== $inherited ) {
		$meta[ $sol_key ] = $inherited;
	}
	if ( $faqs ) {
		$meta['_roden_faqs'] = $faqs;
	}
	/*
	 * Per-page "Why Hire" copy. Without it the intersection template falls back
	 * to the parent pillar's block, which on `both`-scoped pillars describes the
	 * firm's Georgia AND South Carolina practice — accurate, but generic
	 * two-state boilerplate in the most prominent prose section of a page whose
	 * whole purpose is to be specific to one town.
	 */
	if ( ! empty( $p['why_hire'] ) ) {
		$meta['_roden_why_hire'] = wp_kses_post( $p['why_hire'] );
	}

	foreach ( $meta as $k => $v ) {
		update_post_meta( $post_id, $k, $v );
	}
	// Clear the other jurisdiction's statute if an earlier run left one behind.
	if ( '' !== (string) get_post_meta( $post_id, $drop_key, true ) ) {
		delete_post_meta( $post_id, $drop_key );
	}

	// Verify the load-bearing ones actually persisted.
	$bad = array();
	if ( (string) get_post_meta( $post_id, '_roden_pa_office_key', true ) !== (string) $p['market'] ) {
		$bad[] = '_roden_pa_office_key';
	}
	if ( (int) get_post_meta( $post_id, '_roden_author_attorney', true ) !== $author_id ) {
		$bad[] = '_roden_author_attorney';
	}
	if ( $faqs && count( (array) get_post_meta( $post_id, '_roden_faqs', true ) ) !== count( $faqs ) ) {
		$bad[] = '_roden_faqs';
	}
	if ( $bad ) {
		printf( "  ERROR    #%d %s did not persist: %s\n", $post_id, $slug, implode( ', ', $bad ) );
		$counts['skipped']++;
		continue;
	}

	$counts[ $was_new ? 'created' : 'updated' ]++;
	if ( $publish ) {
		$counts['published']++;
	}
	printf( "  %-8s #%-6d %-34s %-22s %d FAQs%s\n",
		$was_new ? 'created' : 'updated', $post_id, $p['pillar'], $slug, count( $faqs ),
		empty( $p['why_hire'] ) ? '  (inherits pillar copy)' : ' + why_hire' );
}

printf( "\n%s\n", str_repeat( '-', 78 ) );
printf( "created   : %d\n", $counts['created'] );
printf( "updated   : %d\n", $counts['updated'] );
printf( "published : %d\n", $counts['published'] );
printf( "blocked   : %d  (no FAQs)\n", $counts['blocked'] );
printf( "errors    : %d\n", $counts['skipped'] );

if ( $apply ) {
	printf( "\nNext: wp rewrite flush, then wp cache flush && wp page-cache flush.\n" );
	printf( "Then regenerate content/meta.json (bin/export-content-meta.php) and commit it.\n" );
} else {
	printf( "\nDry run. Re-run with `apply` to create drafts, `apply publish` to publish.\n" );
}
