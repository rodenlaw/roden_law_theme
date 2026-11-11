<?php
/**
 * 2738 /blog/liability-in-head-on-collisions-savannah-ga/: Georgia fault sentence, 2026-11-11.
 *
 * Owner, 2026-11-11: "fix 2738". The body says recovery is allowed below 50% and then
 * that drivers "assessed with 51 percent of the fault – or higher" cannot recover,
 * which leaves exactly 50% unaddressed and contradicts O.C.G.A. § 51-12-33(g): a
 * plaintiff 50% or more responsible recovers nothing. Found during the SC 51% batch
 * (#345). The corrected sentence restates the page's own preceding sentence and its
 * FAQ[2]; it adds no new GA claim (GA pack still unsigned for Roden).
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-2738-ga-fault-sentence-2026-11-11.php
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-2738-ga-fault-sentence-2026-11-11.php
 */
if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run through wp eval-file.\n" ); exit( 1 ); }
$apply = isset( $args[0] ) && 'apply' === $args[0];
$id    = 2738;
$find  = 'Drivers assessed with 51 percent of the fault – or higher – cannot recover any compensation.';
$repl  = 'Drivers assessed with 50 percent of the fault or more cannot recover any compensation.';
$p = get_post( $id );
if ( ! $p || 'liability-in-head-on-collisions-savannah-ga' !== $p->post_name ) { echo "FAIL $id: wrong post\n"; exit( 1 ); }
$n = substr_count( $p->post_content, $find );
if ( 0 === $n && false !== strpos( $p->post_content, $repl ) ) { echo "OK   already applied\nDONE clean\n"; exit( 0 ); }
if ( 1 !== $n ) { echo "FAIL anchor found $n times\n"; exit( 1 ); }
echo ( $apply ? 'EDIT ' : 'WOULD' ) . " $id post_content\n  -  $find\n  +  $repl\n";
if ( ! $apply ) { echo "DONE clean (dry run)\n"; exit( 0 ); }
$dir = WP_CONTENT_DIR . '/uploads/roden-backups/2738-ga-fault-sentence-2026-11-11';
$f   = "$dir/$id-post_content.html";
if ( ( ! is_dir( $dir ) && ! wp_mkdir_p( $dir ) ) || ( ! file_exists( $f ) && false === file_put_contents( $f, $p->post_content ) ) ) { echo "FAIL backup\n"; exit( 1 ); }
$new = str_replace( $find, $repl, $p->post_content );
$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $new ) ), true );
if ( is_wp_error( $r ) ) { echo 'FAIL ' . $r->get_error_message() . "\n"; exit( 1 ); }
update_post_meta( $id, '_roden_content_modified', wp_slash( gmdate( 'Y-m-d H:i:s' ) ) );
clean_post_cache( $id );
$ok = get_post_field( 'post_content', $id ) === $new;
echo ( $ok ? "OK   read-back\n" : "FAIL read-back\n" ) . "backup: $f\n" . ( $ok ? "DONE clean\n" : "DONE with failure\n" );
exit( $ok ? 0 : 1 );
