<?php
/**
 * Post 4367 (/blog/south-carolina-comparative-fault-partially-at-fault/),
 * _roden_key_takeaways: joint and several liability stated as reaching "any
 * at-fault defendant". S.C. Code § 15-38-15 applies it only to a defendant 50%
 * or more at fault (SC pack `SC 15-38-15`, verified by Graeham C. Gillin
 * 2026-09-08). Owner, 2026-10-24: "ship fix 2 now, hold fix 1 for Gillin".
 *
 * Fix 1 (the body sentence "more than 50% at fault ... for economic damages")
 * is deliberately NOT here: it waits on Gillin.
 *
 * Exact match, once, or abort before writing. wp_slash; read back. Sets
 * _roden_content_modified, not _roden_last_reviewed.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-sc-jsl-takeaway-4367.php > docs/backups/4367-key-takeaways-2026-10-24.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$post  = 4367;
$key   = '_roden_key_takeaways';
$from  = 'South Carolina also applies joint and several liability, allowing plaintiffs to collect full damages from any at-fault defendant.';
$to    = 'South Carolina also applies joint and several liability to a defendant 50% or more at fault, allowing plaintiffs to collect full damages from that defendant.';

$before = get_post_meta( $post, $key, true );
if ( ! is_string( $before ) || '' === $before ) {
	fwrite( STDERR, "ABORT: $post has no string $key\n" );
	exit( 1 );
}
$n = substr_count( $before, $from );
if ( 1 !== $n ) {
	fwrite( STDERR, "ABORT: needle matched $n times (expected 1)\n" );
	exit( 1 );
}
$after = str_replace( $from, $to, $before );

$out = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'post' => $post, 'key' => $key, 'before' => $before, 'after' => $after );
fwrite( STDERR, ( $apply ? 'fixing' : 'would fix' ) . " $post $key\n  - $from\n  + $to\n" );
if ( $apply ) {
	update_post_meta( $post, $key, wp_slash( $after ) );
	update_post_meta( $post, '_roden_content_modified', wp_slash( gmdate( 'Y-m-d H:i:s' ) ) );
	wp_cache_delete( $post, 'post_meta' );
	clean_post_cache( $post );
	if ( get_post_meta( $post, $key, true ) !== $after ) {
		fwrite( STDERR, "FAILED read-back $post $key\n" );
		exit( 1 );
	}
	fwrite( STDERR, "read-back OK\n" );
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
