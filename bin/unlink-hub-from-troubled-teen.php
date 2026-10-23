<?php
/**
 * Unlink the retired class-action hub from the kept troubled-teen page (post 4574,
 * /class-action-lawyers/troubled-teen-industry-abuse/). Since #267 the hub 301s to
 * /practice-areas/, so this body link is an internal redirect (site-health crawl,
 * 2026-10-23). The anchor text stays; only the <a> wrapper goes.
 *
 * Owner, 2026-10-23: "yes, do both and open the PR".
 *
 * Exact-match guard: the post must be 4574 with that slug, and the old link must
 * appear exactly once. Writes with wp_update_post( wp_slash() ), per CLAUDE.md,
 * which also leaves a revision as the undo.
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/unlink-hub-from-troubled-teen.php          # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/unlink-hub-from-troubled-teen.php    # write
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$id    = 4574;
$old   = '<a href="https://rodenlaw.com/class-action-lawyers/" rel="">class action attorney</a>';
$new   = 'class action attorney';

$p = get_post( $id );
if ( ! $p || 'troubled-teen-industry-abuse' !== $p->post_name || 'publish' !== $p->post_status ) {
	fwrite( STDERR, "ABORT: $id is not the published troubled-teen page\n" );
	exit( 1 );
}
$n = substr_count( $p->post_content, $old );
if ( 1 !== $n ) {
	fwrite( STDERR, "ABORT: expected the hub link exactly once, found $n\n" );
	exit( 1 );
}
$content = str_replace( $old, $new, $p->post_content );
echo "$id: content " . md5( $p->post_content ) . ' -> ' . md5( $content ) . ', ' . strlen( $p->post_content ) . ' -> ' . strlen( $content ) . " bytes\n";
if ( ! $apply ) {
	echo "DRY RUN\n";
	exit( 0 );
}

$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $content ) ), true );
if ( is_wp_error( $r ) ) {
	fwrite( STDERR, 'FAIL: ' . $r->get_error_message() . "\n" );
	exit( 1 );
}
clean_post_cache( $id );
$after = get_post( $id )->post_content;
$ok    = ( $after === $content ) && 0 === substr_count( $after, 'class-action-lawyers/"' );
echo ( $ok ? 'OK' : 'MISMATCH' ) . ': stored ' . md5( $after ) . "\n";
exit( $ok ? 0 : 1 );
