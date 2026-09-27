<?php
/**
 * Restore the internal links to /workers-compensation-lawyers/charleston-sc/ that #143
 * repointed to the two-state pillar on 2026-09-19, now that the page is rebuilt
 * (wave 1, #5 of docs/site-architecture/README.md).
 *
 * The pairs are exact anchors taken from docs/backups/earning-intersections-
 * relink-2026-09-19.json: each anchor as it was before #143 ("restore") and as
 * #143 left it ("current"). Retired posts are skipped at run time. An anchor is restored only if it appears in the post
 * exactly as #143 left it and no more often than the pairs expect; anything
 * edited since is skipped and reported. Direct column write, as in the relink
 * scripts: href only, post_modified untouched.
 *
 * Run AFTER post 3654 is published and its redirect is removed, or the links
 * point at a 301.
 *   Dry run: ssh $H "wp --path=$P eval-file -" < bin/restore-charleston-wc-links.php > docs/backups/charleston-wc-links-restore-$(date +%Y-%m-%d).json
 *   Apply:   ssh $H "wp --path=$P eval-file - apply" < bin/restore-charleston-wc-links.php > …
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$pairs = json_decode( base64_decode( 'W3siaWQiOiAxNzQxLCAiY3VycmVudCI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vcHJhY3RpY2UtYXJlYXMvd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9cIj5DaGFybGVzdG9uIHdvcmtlcnPigJkgY29tcGVuc2F0aW9uIGF0dG9ybmV5czwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9jaGFybGVzdG9uLXNjL1wiPkNoYXJsZXN0b24gd29ya2Vyc+KAmSBjb21wZW5zYXRpb24gYXR0b3JuZXlzPC9hPiJ9LCB7ImlkIjogMTY4NCwgImN1cnJlbnQiOiAiPGEgaHJlZj1cIi9wcmFjdGljZS1hcmVhcy93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL1wiPkNoYXJsZXN0b24gd29ya2Vyc+KAmSBjb21wZW5zYXRpb24gbGF3eWVyczwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiL3dvcmtlcnMtY29tcGVuc2F0aW9uLWxhd3llcnMvY2hhcmxlc3Rvbi1zYy9cIj5DaGFybGVzdG9uIHdvcmtlcnPigJkgY29tcGVuc2F0aW9uIGxhd3llcnM8L2E+In1d' ), true );
if ( 'publish' !== get_post_status( 3654 ) ) {
    fprintf( $err, "ABORT: post 3654 is not published yet.\n" );
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
