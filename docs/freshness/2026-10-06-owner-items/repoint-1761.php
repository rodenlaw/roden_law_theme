<?php
/* Owner, 2026-10-06: "repoint and rename". Repoint the carpal-tunnel post's "medical experts" link from the
 * medical-malpractice page to the independent-medical-exams post. A deliberate exception to the patch builder's
 * link guard (it refuses to drop a post's only link to a page); written here with an exact-match replace. */
$id = 1761; $p = get_post( $id );
$old = '<a href="/practice-areas/medical-malpractice-lawyers/">medical experts</a>';
$new = '<a href="/blog/independent-medical-exams/">medical experts</a>';
if ( 1 !== substr_count( $p->post_content, $old ) ) { fwrite( STDERR, "ABORT: expected exactly one match\n" ); exit( 1 ); }
$apply = isset( $args[0] ) && 'apply' === $args[0];
if ( ! $apply ) { echo "DRY RUN: 1 replacement\n"; exit( 0 ); }
$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => str_replace( $old, $new, $p->post_content ) ) ), true );
if ( is_wp_error( $r ) ) { fwrite( STDERR, $r->get_error_message() . "\n" ); exit( 1 ); }
clean_post_cache( $id );
echo ( false !== strpos( get_post( $id )->post_content, $new ) && false === strpos( get_post( $id )->post_content, $old ) ) ? "OK repointed\n" : "FAIL\n";
