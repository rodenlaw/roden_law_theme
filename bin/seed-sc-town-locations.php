<?php
/**
 * Seed location pages for the 8 service-area towns that had none.
 *
 * Those towns already have practice-area intersection pages but no location
 * page beneath them. The location tier is the one with demonstrated returns —
 * West Ashley ranks #4, Little River #7, Kingsland #3, St Simons Island #2, all
 * at KD 0-6 — whereas the neighbourhood tier below it shows no measurable
 * traffic and, where it ranks at all, ranks on the wrong intent (a Savannah
 * neighbourhood page ranks for "criminal defense attorney"; a Summerville one
 * for tourist queries). So this fills the working tier and does not replicate
 * the one below it.
 *
 * PLACEMENT. These sit directly under /locations/south-carolina/, as siblings
 * of the four office cities, rather than beneath the nearest office. Filing
 * Spartanburg under Columbia would call a city 95 miles away a Columbia suburb —
 * the same error as Goose Creek, a Berkeley County city, sitting under the
 * North Charleston office. `single-location.php` routes on `_roden_is_neighborhood`
 * before it checks the state-landing slugs, so a depth-3 page with that flag
 * renders through single-location-neighborhood.php correctly.
 *
 * DISCLOSURE. single-location-neighborhood.php renders the PARENT office's full
 * street address in a NAP bar. It now carries the same serving-office line the
 * intersection pages use, resolved from the post slug via roden_market(), so a
 * page headed "Personal Injury Lawyer Serving Spartanburg" cannot read as a
 * local office. That template change ships with this and must be deployed
 * BEFORE any of these pages is published.
 *
 * Population is deliberately not set on any of these. The field is optional and
 * an unverified figure is worse than an absent one — the same reasoning that
 * kept an untraceable "top 20 most dangerous cities" claim off the new town
 * pages.
 *
 * Everything is created as a DRAFT. `publish` is a separate explicit step that
 * refuses any town missing roads, hospitals or FAQs.
 *
 * Run via bin/build-town-location-seed.sh.
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}
if ( ! defined( 'RODEN_SEED_JSON' ) ) {
	fwrite( STDERR, "RODEN_SEED_JSON not defined — build with bin/build-town-location-seed.sh.\n" );
	exit( 1 );
}

global $wpdb;

$apply   = in_array( 'apply', (array) $args, true );
$publish = in_array( 'publish', (array) $args, true );

$payload = json_decode( RODEN_SEED_JSON, true );
if ( ! is_array( $payload ) || empty( $payload['towns'] ) ) {
	printf( "ABORT  payload did not parse, or has no towns\n" );
	exit( 1 );
}

$firm = roden_firm_data();

/* ── Pre-flight 1: author resolves ──────────────────────────────────────── */

$author_posts = get_posts( array(
	'post_type' => 'attorney', 'post_status' => 'publish',
	'title' => $payload['_author'] ?? '', 'numberposts' => 1, 'suppress_filters' => false,
) );
if ( ! $author_posts ) {
	printf( "ABORT  no published attorney titled \"%s\"\n", $payload['_author'] ?? '' );
	exit( 1 );
}
$author_id = (int) $author_posts[0]->ID;
printf( "author        #%d %s\n", $author_id, $author_posts[0]->post_title );

/* ── Pre-flight 2: parent state page exists ─────────────────────────────── */

$parent = get_page_by_path( $payload['_parent_slug'] ?? 'south-carolina', OBJECT, 'location' );
if ( ! $parent ) {
	printf( "ABORT  parent location page '%s' not found\n", $payload['_parent_slug'] ?? '' );
	exit( 1 );
}
printf( "parent        #%d %s (%s)\n", $parent->ID, $parent->post_title, $parent->post_name );

/* ── Pre-flight 3: every town is a known service area, and the disclosure
 *    will actually resolve for it ────────────────────────────────────────── */

$fatal = 0;
foreach ( $payload['towns'] as $i => $t ) {
	$market = roden_market( $t['slug'] ?? '' );
	if ( ! $market ) {
		printf( "ABORT  town %d: '%s' is not a known market\n", $i, $t['slug'] ?? '' );
		$fatal++;
		continue;
	}
	if ( empty( $market['is_service_area'] ) ) {
		printf( "ABORT  town %d: '%s' is an OFFICE, not a service area — it needs template-location.php, not this\n", $i, $t['slug'] );
		$fatal++;
	}
	if ( empty( $market['parent_office_key'] ) || ! isset( $firm['offices'][ $market['parent_office_key'] ] ) ) {
		printf( "ABORT  town %d: '%s' has no resolvable parent office\n", $i, $t['slug'] );
		$fatal++;
	}
	// Content guards — the same standard the intersection pages are held to.
	$blob = wp_json_encode( $t );
	if ( preg_match( '/O\.C\.G\.A\./u', $blob ) ) {
		printf( "ABORT  town %d (%s): Georgia statute on a South Carolina page\n", $i, $t['slug'] );
		$fatal++;
	}
	if ( preg_match( '/hundreds of (client )?reviews|4\.9[- ]star/iu', $blob ) ) {
		printf( "ABORT  town %d (%s): unverified review claim\n", $i, $t['slug'] );
		$fatal++;
	}
	if ( preg_match( '/no fee\b/iu', $blob ) ) {
		printf( "ABORT  town %d (%s): regulated fee claim\n", $i, $t['slug'] );
		$fatal++;
	}
}
if ( $fatal ) {
	printf( "\n%d pre-flight failure(s) — nothing written.\n", $fatal );
	exit( 1 );
}

printf( "\n%s  %d towns\n\n", $publish ? 'APPLY + PUBLISH' : ( $apply ? 'APPLY (draft)' : 'DRY RUN' ), count( $payload['towns'] ) );

/* ── Seed ───────────────────────────────────────────────────────────────── */

$counts = array( 'created' => 0, 'updated' => 0, 'published' => 0, 'blocked' => 0, 'errors' => 0 );

foreach ( $payload['towns'] as $t ) {
	$slug   = $t['slug'];
	$market = roden_market( $slug );

	// A page with nothing local to say must not go live.
	$thin = empty( $t['roads'] ) || empty( $t['hospitals'] ) || count( (array) ( $t['faqs'] ?? array() ) ) < 3;
	if ( $publish && $thin ) {
		printf( "  BLOCKED  %-16s missing roads, hospitals or FAQs — refusing to publish\n", $slug );
		$counts['blocked']++;
		continue;
	}

	/*
	 * Idempotency against wp_posts directly. get_posts( name => ... ) is
	 * unreliable on hierarchical post types and silently duplicated 35 pages
	 * when it was used for the intersection seeder (PR #41).
	 */
	$post_id = (int) $wpdb->get_var( $wpdb->prepare(
		"SELECT ID FROM {$wpdb->posts}
		 WHERE post_type = 'location' AND post_parent = %d AND post_name = %s
		   AND post_status != 'trash' ORDER BY ID ASC LIMIT 1",
		$parent->ID, $slug
	) );
	// Also refuse if the slug exists ANYWHERE in the location tree — two
	// /locations/ pages for the same town would compete with each other.
	$elsewhere = (int) $wpdb->get_var( $wpdb->prepare(
		"SELECT ID FROM {$wpdb->posts}
		 WHERE post_type = 'location' AND post_name = %s AND post_status != 'trash'
		   AND post_parent != %d LIMIT 1",
		$slug, $parent->ID
	) );
	if ( $elsewhere ) {
		printf( "  BLOCKED  %-16s a location page for this town already exists (#%d) — would compete\n", $slug, $elsewhere );
		$counts['blocked']++;
		continue;
	}

	if ( ! $apply ) {
		printf( "  would %-7s %-16s /locations/%s/%s/  (%d FAQs, %d chars body)\n",
			$post_id ? 'update' : 'create', $slug, $parent->post_name, $slug,
			count( (array) $t['faqs'] ), strlen( $t['content'] ?? '' ) );
		$counts[ $post_id ? 'updated' : 'created' ]++;
		continue;
	}

	$postarr = array(
		'post_type'    => 'location',
		'post_title'   => $t['title'],
		'post_name'    => $slug,
		'post_parent'  => $parent->ID,
		'post_content' => $t['content'] ?? '',
		'post_status'  => $publish ? 'publish' : 'draft',
	);
	if ( $post_id ) {
		$postarr['ID'] = $post_id;
		$existing = get_post( $post_id );
		if ( ! $publish && 'publish' === $existing->post_status ) {
			unset( $postarr['post_status'] ); // never demote
		}
		$res = wp_update_post( $postarr, true );
	} else {
		$res = wp_insert_post( $postarr, true );
	}
	if ( is_wp_error( $res ) ) {
		printf( "  ERROR    %-16s %s\n", $slug, $res->get_error_message() );
		$counts['errors']++;
		continue;
	}
	$was_new = ! $post_id;
	$post_id = (int) ( $post_id ?: $res );

	$meta = array(
		'_roden_is_neighborhood'          => '1',
		'_roden_parent_office_key'        => $market['parent_office_key'],
		'_roden_neighborhood_h1'          => $t['h1'],
		'_roden_neighborhood_court'       => $t['court'],
		'_roden_neighborhood_roads'       => $t['roads'],
		'_roden_neighborhood_hospitals'   => $t['hospitals'],
		'_roden_neighborhood_landmarks'   => $t['landmarks'],
		'_roden_neighborhood_service_area'=> $t['service_area'],
		'_roden_faqs'                     => $t['faqs'],
		'_roden_author_attorney'          => $author_id,
		'_roden_jurisdiction'             => $payload['_jurisdiction'],
		'_roden_sol_sc'                   => $payload['_sol'],
	);
	foreach ( $meta as $k => $v ) {
		update_post_meta( $post_id, $k, $v );
	}

	// Verify the load-bearing ones.
	$bad = array();
	if ( '1' !== (string) get_post_meta( $post_id, '_roden_is_neighborhood', true ) ) { $bad[] = 'is_neighborhood'; }
	if ( (string) get_post_meta( $post_id, '_roden_parent_office_key', true ) !== (string) $market['parent_office_key'] ) { $bad[] = 'parent_office_key'; }
	if ( count( (array) get_post_meta( $post_id, '_roden_faqs', true ) ) !== count( (array) $t['faqs'] ) ) { $bad[] = 'faqs'; }
	if ( $bad ) {
		printf( "  ERROR    #%d %s did not persist: %s\n", $post_id, $slug, implode( ', ', $bad ) );
		$counts['errors']++;
		continue;
	}

	$counts[ $was_new ? 'created' : 'updated' ]++;
	if ( $publish ) { $counts['published']++; }
	printf( "  %-8s #%-6d %-16s serves from %s\n",
		$was_new ? 'created' : 'updated', $post_id, $slug, $market['parent_office_name'] );
}

printf( "\n%s\n", str_repeat( '-', 74 ) );
printf( "created   : %d\n", $counts['created'] );
printf( "updated   : %d\n", $counts['updated'] );
printf( "published : %d\n", $counts['published'] );
printf( "blocked   : %d\n", $counts['blocked'] );
printf( "errors    : %d\n", $counts['errors'] );

if ( $apply ) {
	printf( "\nNext: wp rewrite flush, then wp cache flush && wp page-cache flush.\n" );
	printf( "Then regenerate content/meta.json — _roden_faqs, _roden_jurisdiction, _roden_sol_sc\n" );
	printf( "and _roden_author_attorney are all in the export whitelist.\n" );
} else {
	printf( "\nDry run. Re-run with `apply` for drafts, `apply publish` to publish.\n" );
}
