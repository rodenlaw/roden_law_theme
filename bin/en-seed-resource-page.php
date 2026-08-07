<?php
/**
 * Seed or update an English `resource` page from a JSON payload.
 *
 * Generalised from bin/en-seed-truck-settlement-process.php, which was written
 * for a single page. Two changes:
 *
 *  1. The expected attorney name comes from the payload rather than being
 *     hard-coded, so this works for any resource page.
 *  2. The attachment lookup keys on the `_wp_attached_file` meta instead of the
 *     attachment slug. The old lookup was broken: the resource post claims the
 *     slug first, so WordPress uniquifies the attachment to `-2`, the name
 *     lookup missed, and a second run sideloaded a duplicate pointing at the
 *     same file on disk. That happened on the truck page (5221 and 5222).
 *
 * WHAT IT WILL NOT LET YOU GET WRONG
 * ----------------------------------
 * Three things on this site fail silently rather than loudly:
 *
 *  1. `_roden_author_attorney` is an attorney POST ID, not a name.
 *     schema-helpers.php falls back to Eric Roden when it is unset or invalid.
 *     On a South-Carolina-stamped page that silent fallback is the exact
 *     attribution error the 2026-07-21 correction exists to prevent. The script
 *     refuses to run unless the ID resolves to a published attorney post whose
 *     title matches the payload's `expected_attorney`.
 *
 *  2. Key Takeaways and FAQs are META, not body copy. single-resource.php
 *     renders the takeaways box from `_roden_key_takeaways` and the FAQ
 *     accordion from `_roden_faqs`. No published resource carries either
 *     heading in post_content; shipping them in the body renders each block
 *     twice. The script rejects a payload whose content contains either.
 *
 *  3. The jurisdiction gate is one-way. A `georgia-only` page containing a
 *     South Carolina citation (or the reverse) is wrong law on the page, and
 *     nothing in WordPress will complain. Asserted here instead.
 *
 * PAYLOAD
 * -------
 * Expects RODEN_SEED_JSON, and optionally RODEN_SEED_IMAGE_B64 for a featured
 * image. Both travel inside the script because nothing outside the site
 * directory persists on WP Engine between SSH sessions and scp/sftp are
 * refused. See bin/es-build-seed.sh for the original of that pattern.
 *
 *   ssh <prod> "wp --path=<site> eval-file -" < /tmp/seed.php            # dry run
 *   ssh <prod> "wp --path=<site> eval-file - apply" < /tmp/seed.php      # create as draft
 *   ssh <prod> "wp --path=<site> eval-file - apply publish" < /tmp/seed.php
 *
 * Idempotent: re-running updates in place, never demotes a published page back
 * to draft, and reuses an existing attachment rather than duplicating it.
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}
if ( ! defined( 'RODEN_SEED_JSON' ) ) {
	fwrite( STDERR, "RODEN_SEED_JSON is not defined — see the header.\n" );
	exit( 1 );
}

$mode   = isset( $args[0] ) ? $args[0] : 'dry-run';
$do_pub = isset( $args[1] ) && 'publish' === $args[1];
if ( ! in_array( $mode, array( 'dry-run', 'apply' ), true ) ) {
	fwrite( STDERR, "Unknown mode '$mode'. Use dry-run | apply [publish].\n" );
	exit( 1 );
}

$p = json_decode( RODEN_SEED_JSON, true );
if ( ! is_array( $p ) ) {
	fwrite( STDERR, 'Payload is not valid JSON: ' . json_last_error_msg() . "\n" );
	exit( 1 );
}

$slug = $p['slug'];
$meta = $p['meta'];

echo "mode: $mode" . ( $do_pub ? ' publish' : '' ) . "\n";
echo str_repeat( '-', 62 ) . "\n";

/* -- Guard 1: attorney ------------------------------------------------------ */
$atty_id = (int) $meta['_roden_author_attorney'];
$atty    = $atty_id ? get_post( $atty_id ) : null;
if ( ! $atty || 'attorney' !== $atty->post_type || 'publish' !== $atty->post_status ) {
	fwrite( STDERR, "FATAL: _roden_author_attorney $atty_id is not a published attorney post.\n" );
	exit( 1 );
}
if ( $atty->post_title !== $p['expected_attorney'] ) {
	fwrite( STDERR, "FATAL: attorney $atty_id is '{$atty->post_title}', expected '{$p['expected_attorney']}'.\n" );
	exit( 1 );
}
echo "attorney:      OK — $atty_id = {$atty->post_title}\n";

/* -- Guard 2: meta-rendered blocks must not also be in the body ------------- */
foreach ( array( 'Key Takeaways', 'Frequently Asked' ) as $needle ) {
	if ( false !== stripos( $p['content'], $needle ) ) {
		fwrite( STDERR, "FATAL: post_content contains '$needle' — it is rendered from meta.\n" );
		exit( 1 );
	}
}
echo "body/meta:     OK — no duplicated takeaways or FAQ block\n";

/* -- Guard 3: jurisdiction --------------------------------------------------- */
$has_ga = (bool) preg_match( '/O\.C\.G\.A\. §/u', $p['content'] );
$has_sc = (bool) preg_match( '/S\.C\. Code §/u', $p['content'] );
$juris  = $meta['_roden_jurisdiction'];
$ok     = true;
if ( 'georgia-only' === $juris || 'ga' === $juris ) {
	$ok = $has_ga && ! $has_sc;
} elseif ( 'south-carolina-only' === $juris || 'sc' === $juris ) {
	$ok = $has_sc && ! $has_ga;
} elseif ( 'both' === $juris ) {
	$ok = $has_ga && $has_sc;
}
if ( ! $ok ) {
	fwrite( STDERR, "FATAL: jurisdiction '$juris' but body has GA=$has_ga SC=$has_sc.\n" );
	exit( 1 );
}
echo "jurisdiction:  OK — $juris (GA=" . (int) $has_ga . " SC=" . (int) $has_sc . ")\n";

/* -- Locate the post -------------------------------------------------------- */
$existing = get_posts( array(
	'post_type'        => 'resource',
	'name'             => $slug,
	'post_status'      => array( 'publish', 'draft', 'pending', 'private' ),
	'numberposts'      => 1,
	'suppress_filters' => false,
) );
$post_id = $existing ? $existing[0]->ID : 0;
echo $post_id
	? "post:          UPDATE existing #$post_id ({$existing[0]->post_status})\n"
	: "post:          CREATE new /resources/$slug/\n";

echo "title:         {$p['title']}\n";
echo "content:       " . strlen( $p['content'] ) . " bytes, "
	. substr_count( $p['content'], '<h2>' ) . " h2, "
	. substr_count( $p['content'], '<table>' ) . " tables\n";
echo "faqs:          " . count( $meta['_roden_faqs'] ) . "\n";
echo "takeaways:     " . strlen( $meta['_roden_key_takeaways'] ) . " chars (prose)\n";
echo "see_also:      " . count( $meta['_roden_see_also'] ) . "\n";
echo "last_reviewed: {$meta['_roden_last_reviewed']}\n";

/* -- Featured image: find by attached file, not by slug --------------------- */
$thumb_id = 0;
$img_name = isset( $p['image']['file'] ) ? $p['image']['file'] : '';
if ( $img_name ) {
	$found = get_posts( array(
		'post_type'   => 'attachment',
		'post_status' => 'inherit',
		'numberposts' => 1,
		'meta_query'  => array( array(
			'key'     => '_wp_attached_file',
			'value'   => '/' . $img_name,
			'compare' => 'LIKE',
		) ),
	) );
	if ( $found ) {
		$thumb_id = $found[0]->ID;
		echo "image:         REUSE attachment #$thumb_id ($img_name)\n";
	} else {
		echo "image:         SIDELOAD $img_name ("
			. ( defined( 'RODEN_SEED_IMAGE_B64' ) ? strlen( RODEN_SEED_IMAGE_B64 ) : 0 )
			. " b64 bytes)\n";
	}
}

if ( 'dry-run' === $mode ) {
	echo str_repeat( '-', 62 ) . "\nDRY RUN — nothing written. Re-run with: apply [publish]\n";
	exit( 0 );
}

/* -- Apply ------------------------------------------------------------------ */
$postarr = array(
	'post_type'    => 'resource',
	'post_name'    => $slug,
	'post_title'   => $p['title'],
	'post_content' => $p['content'],
	'post_excerpt' => $p['excerpt'],
	'post_status'  => $do_pub ? 'publish' : 'draft',
);
if ( $post_id ) {
	$postarr['ID'] = $post_id;
	if ( ! $do_pub && 'publish' === $existing[0]->post_status ) {
		unset( $postarr['post_status'] ); // never silently demote a live page
	}
	$res = wp_update_post( $postarr, true );
} else {
	$res = wp_insert_post( $postarr, true );
}
if ( is_wp_error( $res ) ) {
	fwrite( STDERR, 'FATAL: ' . $res->get_error_message() . "\n" );
	exit( 1 );
}
$post_id = (int) $res;
echo "wrote post #$post_id\n";

foreach ( $meta as $k => $v ) {
	update_post_meta( $post_id, $k, $v );
}
echo 'wrote ' . count( $meta ) . " meta fields\n";

if ( $img_name && ! $thumb_id && defined( 'RODEN_SEED_IMAGE_B64' ) ) {
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$up  = wp_upload_dir();
	$dst = trailingslashit( $up['path'] ) . $img_name;
	file_put_contents( $dst, base64_decode( RODEN_SEED_IMAGE_B64 ) );
	$thumb_id = wp_insert_attachment( array(
		'post_mime_type' => 'image/jpeg',
		'post_title'     => pathinfo( $img_name, PATHINFO_FILENAME ),
		'post_status'    => 'inherit',
	), $dst, $post_id );
	wp_update_attachment_metadata( $thumb_id, wp_generate_attachment_metadata( $thumb_id, $dst ) );
	update_post_meta( $thumb_id, '_wp_attachment_image_alt', $p['image']['alt'] );
	echo "sideloaded attachment #$thumb_id\n";
}
if ( $thumb_id ) {
	set_post_thumbnail( $post_id, $thumb_id );
	echo "set featured image #$thumb_id\n";
}

echo str_repeat( '-', 62 ) . "\n";
echo 'status: ' . get_post_status( $post_id ) . "\n";
echo 'url:    ' . get_permalink( $post_id ) . "\n";
