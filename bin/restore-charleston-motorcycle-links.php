<?php
/**
 * Restore the internal links to /motorcycle-accident-lawyers/charleston-sc/ that #142
 * repointed to the two-state pillar on 2026-09-18, now that the page is rebuilt
 * (wave 1, #7 of docs/site-architecture/README.md).
 *
 * The pairs are exact anchors taken from docs/backups/zero-click-relink-
 * 2026-09-18.json: each anchor as it was before #143 ("restore") and as
 * #143 left it ("current"). Retired posts are skipped at run time. An anchor is restored only if it appears in the post
 * exactly as #143 left it and no more often than the pairs expect; anything
 * edited since is skipped and reported. The Spanish pair (post 4927 ->
 * /es/motorcycle-accident-lawyers/charleston-sc/) is left out: that twin stays
 * retired. Post 4798 is retired and is skipped at run time. Direct column write, as in the relink
 * scripts: href only, post_modified untouched.
 *
 * Run AFTER post 3639 is published and its redirect is removed, or the links
 * point at a 301.
 *   Dry run: ssh $H "wp --path=$P eval-file -" < bin/restore-charleston-motorcycle-links.php > docs/backups/charleston-motorcycle-links-restore-$(date +%Y-%m-%d).json
 *   Apply:   ssh $H "wp --path=$P eval-file - apply" < bin/restore-charleston-motorcycle-links.php > …
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$pairs = json_decode( base64_decode( 'W3siaWQiOiA0Nzk4LCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL21vdG9yY3ljbGUtYWNjaWRlbnQtbGF3eWVycy9cIj5DaGFybGVzdG9uIG1vdG9yY3ljbGUgYWNjaWRlbnQgbGF3eWVyczwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiL21vdG9yY3ljbGUtYWNjaWRlbnQtbGF3eWVycy9jaGFybGVzdG9uLXNjL1wiPkNoYXJsZXN0b24gbW90b3JjeWNsZSBhY2NpZGVudCBsYXd5ZXJzPC9hPiJ9LCB7ImlkIjogNTA1MiwgImN1cnJlbnQiOiAiPGEgaHJlZj1cIi9wcmFjdGljZS1hcmVhcy9tb3RvcmN5Y2xlLWFjY2lkZW50LWxhd3llcnMvXCI+TW90b3JjeWNsZSBhY2NpZGVudHM8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cIi9tb3RvcmN5Y2xlLWFjY2lkZW50LWxhd3llcnMvY2hhcmxlc3Rvbi1zYy9cIj5Nb3RvcmN5Y2xlIGFjY2lkZW50czwvYT4ifV0=' ), true );
if ( 'publish' !== get_post_status( 3639 ) ) {
    fprintf( $err, "ABORT: post 3639 is not published yet.\n" );
    exit( 1 );
}
global $wpdb;
$by = array();
foreach ( $pairs as $pr ) { $by[ $pr['id'] ][] = $pr; }
$done = 0; $skip = 0; $backup = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'posts' => array() );
foreach ( $by as $id => $list ) {
    $row = $wpdb->get_row( $wpdb->prepare( "SELECT post_status, post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
    if ( ! $row || 'publish' !== $row->post_status ) { fprintf( $err, "  skip %d: not published\n", $id ); $skip += count( $list ); continue; }
    $before = $row->post_content; $after = $before; $need = array();
    foreach ( $list as $pr ) { $need[ $pr['current'] ] = ( $need[ $pr['current'] ] ?? 0 ) + 1; }
    foreach ( $list as $pr ) {
        $have = substr_count( $after, $pr['current'] );
        if ( $have < 1 || $have > $need[ $pr['current'] ] ) { fprintf( $err, "  skip %d: anchor found %d times\n", $id, $have ); $skip++; continue; }
        $pos = strpos( $after, $pr['current'] );
        $after = substr_replace( $after, $pr['restore'], $pos, strlen( $pr['current'] ) );
        $need[ $pr['current'] ]--; $done++;
    }
    if ( $after === $before ) { continue; }
    $backup['posts'][] = array( 'ID' => $id, 'before' => $before, 'after' => $after );
    fprintf( $err, "  %-5d %s\n", $id, get_permalink( $id ) );
    if ( $apply ) {
        if ( false === $wpdb->update( $wpdb->posts, array( 'post_content' => $after ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) ) ) { fprintf( $err, "FAILED write %d\n", $id ); exit( 1 ); }
        clean_post_cache( $id );
    }
}
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fprintf( $err, "\n%s: %d anchors restored, %d skipped, %d posts\n", $apply ? 'Restored' : 'Would restore', $done, $skip, count( $backup['posts'] ) );
