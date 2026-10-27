<?php
/**
 * Post 4367 (/blog/south-carolina-comparative-fault-partially-at-fault/),
 * post_content: joint and several liability stated as reaching a defendant
 * "more than 50% at fault ... for economic damages". S.C. Code § 15-38-15
 * applies it to a defendant 50% or more at fault (SC pack `SC 15-38-15`,
 * verified by Graeham C. Gillin 2026-09-08). Gillin approved the proposed
 * sentence, which drops "for economic damages", on the October attorney
 * review (item sc-4367, 2026-10-26). Owner, 2026-10-27: "apply".
 *
 * Fix 2 (the key takeaway) shipped 2026-10-24: bin/fix-sc-jsl-takeaway-4367.php.
 *
 * Exact match, once, or abort before writing. wp_slash; read back. Sets
 * _roden_content_modified, not _roden_last_reviewed.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-sc-jsl-body-4367.php > docs/backups/4367-body-2026-10-27.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$post  = 4367;
$from  = 'A defendant found to be more than 50% at fault may be held jointly and severally liable for economic damages, meaning';
$to    = 'A defendant found to be 50% or more at fault may be held jointly and severally liable, meaning';

$p = get_post( $post );
if ( ! $p || 'publish' !== $p->post_status ) {
	fwrite( STDERR, "ABORT: $post missing or not published\n" );
	exit( 1 );
}
$before = $p->post_content;
$n      = substr_count( $before, $from );
if ( 1 !== $n ) {
	fwrite( STDERR, "ABORT: needle matched $n times (expected 1)\n" );
	exit( 1 );
}
$after = str_replace( $from, $to, $before );

$out = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'post' => $post, 'field' => 'post_content', 'from' => $from, 'to' => $to, 'before' => $before, 'after' => $after );
fwrite( STDERR, ( $apply ? 'fixing' : 'would fix' ) . " $post post_content\n  - $from\n  + $to\n" );
if ( $apply ) {
	$r = wp_update_post( wp_slash( array( 'ID' => $post, 'post_content' => $after ) ), true );
	if ( is_wp_error( $r ) ) {
		fwrite( STDERR, 'FAILED write: ' . $r->get_error_message() . "\n" );
		exit( 1 );
	}
	update_post_meta( $post, '_roden_content_modified', wp_slash( gmdate( 'Y-m-d H:i:s' ) ) );
	clean_post_cache( $post );
	global $wpdb;
	$db = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $post ) );
	if ( $db !== $after ) {
		fwrite( STDERR, "FAILED read-back $post post_content\n" );
		exit( 1 );
	}
	fwrite( STDERR, "read-back OK\n" );
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
