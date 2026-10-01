<?php
/**
 * Attach generated featured images to resource pages that have none. Owner,
 * 2026-10-01: "use the resource title to set the image prompt and alt text".
 *
 * Items are embedded (base64 JSON) by bin/build-resource-image-attach.py, because
 * this script is piped to `wp eval-file -` and scp/sftp are refused on this host.
 * Each item is either:
 *   { post, slug, alt, file, b64 }        a new JPG: written to uploads, attached
 *   { post, slug, alt, reuse_slug }       a Spanish twin: a second attachment that
 *                                         points at the English twin's file, so the
 *                                         Spanish page gets a Spanish alt
 * Items run in order, so an English item precedes its Spanish twin in the same run.
 *
 * Refuses a post that is not a published resource, or that already has a featured
 * image. Alt text goes through update_post_meta( wp_slash() ). Read back.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < run.php
 */
if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run under wp-cli.\n" ); exit( 1 ); }
require_once ABSPATH . 'wp-admin/includes/image.php';
$apply = isset( $args[0] ) && 'apply' === $args[0];
$items = json_decode( base64_decode( '__ITEMS__' ), true );
if ( ! is_array( $items ) || ! $items ) { fwrite( STDERR, "ABORT: no items embedded.\n" ); exit( 1 ); }

// Pass 1: check everything before writing anything.
foreach ( $items as $it ) {
	$p = get_post( (int) $it['post'] );
	if ( ! $p || 'resource' !== $p->post_type || 'publish' !== $p->post_status || $p->post_name !== $it['slug'] ) {
		fwrite( STDERR, "ABORT: {$it['post']} is not the published resource {$it['slug']}\n" ); exit( 1 );
	}
	if ( has_post_thumbnail( $p->ID ) ) { fwrite( STDERR, "ABORT: {$it['slug']} already has a featured image\n" ); exit( 1 ); }
	if ( isset( $it['b64'] ) && strlen( $it['b64'] ) < 10000 ) { fwrite( STDERR, "ABORT: {$it['slug']} image payload is empty\n" ); exit( 1 ); }
}

$attached = array(); // slug => attachment ID, for Spanish twins in the same run
foreach ( $items as $it ) {
	$post_id = (int) $it['post'];
	if ( isset( $it['reuse_slug'] ) ) {
		$src_id = isset( $attached[ $it['reuse_slug'] ] ) ? $attached[ $it['reuse_slug'] ] : 0;
		if ( ! $src_id ) {
			$src_post = get_page_by_path( $it['reuse_slug'], OBJECT, 'resource' );
			$src_id   = $src_post ? (int) get_post_thumbnail_id( $src_post->ID ) : 0;
		}
		if ( ! $src_id && $apply ) { fwrite( STDERR, "SKIP {$it['slug']}: twin {$it['reuse_slug']} has no image yet\n" ); continue; }
		fwrite( STDERR, '  ' . ( $apply ? 'reused' : 'would reuse' ) . " {$it['reuse_slug']} image for {$it['slug']}\n" );
		if ( ! $apply ) { continue; }
		$file   = get_attached_file( $src_id );
		$att_id = wp_insert_attachment( array( 'post_mime_type' => 'image/jpeg', 'post_title' => $it['alt'], 'post_status' => 'inherit' ), $file, $post_id );
		wp_update_attachment_metadata( $att_id, wp_get_attachment_metadata( $src_id ) );
	} else {
		fwrite( STDERR, '  ' . ( $apply ? 'attached' : 'would attach' ) . " {$it['file']} to {$it['slug']} (" . round( strlen( $it['b64'] ) * 0.75 / 1024 ) . " KB)\n" );
		if ( ! $apply ) { continue; }
		$up  = wp_upload_dir();
		$dst = trailingslashit( $up['path'] ) . wp_unique_filename( $up['path'], $it['file'] );
		file_put_contents( $dst, base64_decode( $it['b64'] ) );
		$att_id = wp_insert_attachment( array( 'post_mime_type' => 'image/jpeg', 'post_title' => $it['alt'], 'post_status' => 'inherit' ), $dst, $post_id );
		wp_update_attachment_metadata( $att_id, wp_generate_attachment_metadata( $att_id, $dst ) );
	}
	if ( is_wp_error( $att_id ) || ! $att_id ) { fwrite( STDERR, "FAILED: attachment for {$it['slug']}\n" ); exit( 1 ); }
	update_post_meta( $att_id, '_wp_attachment_image_alt', wp_slash( $it['alt'] ) );
	set_post_thumbnail( $post_id, $att_id );
	clean_post_cache( $post_id );
	if ( (int) get_post_thumbnail_id( $post_id ) !== (int) $att_id || get_post_meta( $att_id, '_wp_attachment_image_alt', true ) !== $it['alt'] ) {
		fwrite( STDERR, "FAILED read-back on {$it['slug']}\n" ); exit( 1 );
	}
	$attached[ $it['slug'] ] = $att_id;
}
fwrite( STDERR, sprintf( "%s: %d items\n", $apply ? 'Done' : 'Would do', count( $items ) ) );
