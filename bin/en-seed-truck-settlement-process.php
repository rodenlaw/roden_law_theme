<?php
/**
 * Seed the truck-accident settlement-process resource page.
 *
 * WHY THIS EXISTS
 * ---------------
 * rodenlaw.com had no page describing how a truck settlement actually starts,
 * and nothing anywhere on the site listing what a client must bring to the
 * first meeting. This seeds that page as a `resource`, the same CPT the
 * settlement-value family already uses.
 *
 * WHAT IT WILL NOT LET YOU GET WRONG
 * ----------------------------------
 * Two things on this site fail silently rather than loudly, so both are
 * asserted here instead of trusted:
 *
 *  1. `_roden_author_attorney` is an attorney POST ID, not a name.
 *     schema-helpers.php falls back to Eric Roden when it is unset or invalid.
 *     Eric Roden is Georgia-only, and this page carries South Carolina law, so
 *     a silent fallback would produce exactly the attribution error the
 *     2026-07-21 correction exists to prevent. The script verifies the ID
 *     resolves to a published attorney post titled "Joshua Dorminy" and
 *     refuses to run if it does not.
 *
 *  2. Key Takeaways and FAQs are META, not body copy. single-resource.php
 *     renders the takeaways box from `_roden_key_takeaways` and the FAQ
 *     accordion from `_roden_faqs`. 0 of 76 published resources carry either
 *     heading in post_content. Shipping them in the body would render both
 *     twice. The script rejects a payload whose content contains either.
 *
 * PAYLOAD
 * -------
 * Expects RODEN_SEED_JSON. Build with the existing builder:
 *
 *   SEEDER=en-seed-truck-settlement-process.php \
 *     bin/es-build-seed.sh payload.json > /tmp/seed.php
 *   ssh <prod> "wp --path=<site> eval-file -" < /tmp/seed.php            # dry run
 *   ssh <prod> "wp --path=<site> eval-file - apply" < /tmp/seed.php      # create as draft
 *   ssh <prod> "wp --path=<site> eval-file - apply publish" < /tmp/seed.php
 *
 * Idempotent: re-running updates the existing post in place rather than
 * creating a second one, and re-uses an already-sideloaded attachment instead
 * of duplicating it in the media library.
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}
if ( ! defined( 'RODEN_SEED_JSON' ) ) {
	fwrite( STDERR, "RODEN_SEED_JSON is not defined — see the header.\n" );
	exit( 1 );
}

$mode    = isset( $args[0] ) ? $args[0] : 'dry-run';
$do_pub  = isset( $args[1] ) && 'publish' === $args[1];
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

/* -- Guard 1: the attorney ID must resolve, or the byline silently becomes
      Eric Roden on a page that carries South Carolina law. ----------------- */
$atty_id = (int) $meta['_roden_author_attorney'];
$atty    = $atty_id ? get_post( $atty_id ) : null;
if ( ! $atty || 'attorney' !== $atty->post_type || 'publish' !== $atty->post_status ) {
	fwrite( STDERR, "FATAL: _roden_author_attorney $atty_id is not a published attorney post.\n" );
	exit( 1 );
}
if ( 'Joshua Dorminy' !== $atty->post_title ) {
	fwrite( STDERR, "FATAL: attorney $atty_id is '{$atty->post_title}', expected 'Joshua Dorminy'.\n" );
	exit( 1 );
}
echo "attorney:      OK — $atty_id = {$atty->post_title}\n";

/* -- Guard 2: takeaways and FAQs are meta-rendered; they must not also be in
      the body or the page shows each block twice. ------------------------- */
foreach ( array( 'Key Takeaways', 'Frequently Asked' ) as $needle ) {
	if ( false !== stripos( $p['content'], $needle ) ) {
		fwrite( STDERR, "FATAL: post_content contains '$needle' — it is rendered from meta.\n" );
		exit( 1 );
	}
}
echo "body/meta:     OK — no duplicated takeaways or FAQ block\n";

/* -- Guard 3: jurisdiction 'both' must actually carry both states' law. ---- */
$has_ga = (bool) preg_match( '/O\.C\.G\.A\. §/u', $p['content'] );
$has_sc = (bool) preg_match( '/S\.C\. Code §/u', $p['content'] );
if ( 'both' === $meta['_roden_jurisdiction'] && ! ( $has_ga && $has_sc ) ) {
	fwrite( STDERR, "FATAL: jurisdiction 'both' but GA=$has_ga SC=$has_sc in body.\n" );
	exit( 1 );
}
echo "jurisdiction:  OK — both, GA and SC citations present\n";

/* -- Locate or plan the post ---------------------------------------------- */
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
echo "is_howto:      {$meta['_roden_is_howto']} (emits HowTo instead of Article)\n";
echo "last_reviewed: {$meta['_roden_last_reviewed']}\n";

/* -- Featured image: sideload from the payload's base64, once. ------------- */
$img_name = $p['image']['file'];
$thumb_id = 0;
$existing_att = get_posts( array(
	'post_type'   => 'attachment',
	'name'        => sanitize_title( pathinfo( $img_name, PATHINFO_FILENAME ) ),
	'numberposts' => 1,
	'post_status' => 'inherit',
) );
if ( $existing_att ) {
	$thumb_id = $existing_att[0]->ID;
	echo "image:         REUSE attachment #$thumb_id\n";
} else {
	echo "image:         SIDELOAD $img_name (" . ( defined( 'RODEN_SEED_IMAGE_B64' ) ? strlen( RODEN_SEED_IMAGE_B64 ) : 0 ) . " b64 bytes)\n";
}

if ( 'dry-run' === $mode ) {
	echo str_repeat( '-', 62 ) . "\nDRY RUN — nothing written. Re-run with: apply [publish]\n";
	exit( 0 );
}

/* -- Apply ---------------------------------------------------------------- */
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
	// Don't silently demote a live page back to draft on a re-run.
	if ( ! $do_pub && 'publish' === $existing[0]->post_status ) {
		unset( $postarr['post_status'] );
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

if ( ! $thumb_id && defined( 'RODEN_SEED_IMAGE_B64' ) ) {
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
