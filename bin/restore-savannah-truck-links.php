<?php
/**
 * Restore the internal links to /truck-accident-lawyers/savannah-ga/ that #143
 * repointed to the two-state pillar on 2026-09-19, now that the page is rebuilt
 * (wave 1, #4 of docs/site-architecture/README.md).
 *
 * The pairs are exact anchors taken from docs/backups/earning-intersections-
 * relink-2026-09-19.json: each anchor as it was before #143 ("restore") and as
 * #143 left it ("current"). Retired posts are skipped at run time. An anchor is restored only if it appears in the post
 * exactly as #143 left it and no more often than the pairs expect; anything
 * edited since is skipped and reported. Direct column write, as in the relink
 * scripts: href only, post_modified untouched.
 *
 * Run AFTER post 3627 is published and its redirect is removed, or the links
 * point at a 301.
 *   Dry run: ssh $H "wp --path=$P eval-file -" < bin/restore-savannah-truck-links.php > docs/backups/savannah-truck-links-restore-$(date +%Y-%m-%d).json
 *   Apply:   ssh $H "wp --path=$P eval-file - apply" < bin/restore-savannah-truck-links.php > …
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$pairs = json_decode( base64_decode( 'W3siaWQiOiAxODYxLCAiY3VycmVudCI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vcHJhY3RpY2UtYXJlYXMvdHJ1Y2stYWNjaWRlbnQtbGF3eWVycy9cIj50cnVjayBhY2NpZGVudHM8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3RydWNrLWFjY2lkZW50LWxhd3llcnMvc2F2YW5uYWgtZ2EvXCI+dHJ1Y2sgYWNjaWRlbnRzPC9hPiJ9LCB7ImlkIjogNDcxOSwgImN1cnJlbnQiOiAiPGEgaHJlZj1cIi9wcmFjdGljZS1hcmVhcy90cnVjay1hY2NpZGVudC1sYXd5ZXJzL1wiPlNhdmFubmFoIHRydWNrIGFjY2lkZW50IGxhd3llcnM8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cIi90cnVjay1hY2NpZGVudC1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPlNhdmFubmFoIHRydWNrIGFjY2lkZW50IGxhd3llcnM8L2E+In0sIHsiaWQiOiA0NzU2LCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL3RydWNrLWFjY2lkZW50LWxhd3llcnMvXCI+U2F2YW5uYWggdHJ1Y2sgYWNjaWRlbnQgbGF3eWVyczwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiL3RydWNrLWFjY2lkZW50LWxhd3llcnMvc2F2YW5uYWgtZ2EvXCI+U2F2YW5uYWggdHJ1Y2sgYWNjaWRlbnQgbGF3eWVyczwvYT4ifSwgeyJpZCI6IDQ3NjgsICJjdXJyZW50IjogIjxhIGhyZWY9XCIvcHJhY3RpY2UtYXJlYXMvdHJ1Y2stYWNjaWRlbnQtbGF3eWVycy9cIj5TYXZhbm5haCB0cnVjayBhY2NpZGVudCBsYXd5ZXJzPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCIvdHJ1Y2stYWNjaWRlbnQtbGF3eWVycy9zYXZhbm5haC1nYS9cIj5TYXZhbm5haCB0cnVjayBhY2NpZGVudCBsYXd5ZXJzPC9hPiJ9LCB7ImlkIjogMTgzMCwgImN1cnJlbnQiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3ByYWN0aWNlLWFyZWFzL3RydWNrLWFjY2lkZW50LWxhd3llcnMvXCI+U2F2YW5uYWggdHJ1Y2sgYWNjaWRlbnQgbGF3eWVyPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS90cnVjay1hY2NpZGVudC1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPlNhdmFubmFoIHRydWNrIGFjY2lkZW50IGxhd3llcjwvYT4ifSwgeyJpZCI6IDE2NjEsICJjdXJyZW50IjogIjxhIGhyZWY9XCIvcHJhY3RpY2UtYXJlYXMvdHJ1Y2stYWNjaWRlbnQtbGF3eWVycy9cIj5TYXZhbm5haDwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiL3RydWNrLWFjY2lkZW50LWxhd3llcnMvc2F2YW5uYWgtZ2EvXCI+U2F2YW5uYWg8L2E+In0sIHsiaWQiOiAxNjYxLCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL3RydWNrLWFjY2lkZW50LWxhd3llcnMvXCI+U2F2YW5uYWg8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cIi90cnVjay1hY2NpZGVudC1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPlNhdmFubmFoPC9hPiJ9LCB7ImlkIjogMTg2NSwgImN1cnJlbnQiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3ByYWN0aWNlLWFyZWFzL3RydWNrLWFjY2lkZW50LWxhd3llcnMvXCI+dHJ1Y2sgYWNjaWRlbnRzPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS90cnVjay1hY2NpZGVudC1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPnRydWNrIGFjY2lkZW50czwvYT4ifSwgeyJpZCI6IDE3ODYsICJjdXJyZW50IjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS9wcmFjdGljZS1hcmVhcy90cnVjay1hY2NpZGVudC1sYXd5ZXJzL1wiPlNhdmFubmFoIHRydWNrIGFjY2lkZW50IGF0dG9ybmV5czwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vdHJ1Y2stYWNjaWRlbnQtbGF3eWVycy9zYXZhbm5haC1nYS9cIj5TYXZhbm5haCB0cnVjayBhY2NpZGVudCBhdHRvcm5leXM8L2E+In0sIHsiaWQiOiAxNzgxLCAiY3VycmVudCI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vcHJhY3RpY2UtYXJlYXMvdHJ1Y2stYWNjaWRlbnQtbGF3eWVycy9cIj5TYXZhbm5haCB0cnVjayBhY2NpZGVudCBhdHRvcm5leXM8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3RydWNrLWFjY2lkZW50LWxhd3llcnMvc2F2YW5uYWgtZ2EvXCI+U2F2YW5uYWggdHJ1Y2sgYWNjaWRlbnQgYXR0b3JuZXlzPC9hPiJ9LCB7ImlkIjogMjQxNywgImN1cnJlbnQiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3ByYWN0aWNlLWFyZWFzL3RydWNrLWFjY2lkZW50LWxhd3llcnMvXCI+dHJ1Y2sgYWNjaWRlbnQgbGF3eWVycyBpbiBTYXZhbm5haDwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vdHJ1Y2stYWNjaWRlbnQtbGF3eWVycy9zYXZhbm5haC1nYS9cIj50cnVjayBhY2NpZGVudCBsYXd5ZXJzIGluIFNhdmFubmFoPC9hPiJ9LCB7ImlkIjogNTE2MCwgImN1cnJlbnQiOiAiPGEgaHJlZj1cIi9wcmFjdGljZS1hcmVhcy90cnVjay1hY2NpZGVudC1sYXd5ZXJzL1wiPlNhdmFubmFoIHRydWNrIGFjY2lkZW50IGxhd3llcnM8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cIi90cnVjay1hY2NpZGVudC1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPlNhdmFubmFoIHRydWNrIGFjY2lkZW50IGxhd3llcnM8L2E+In0sIHsiaWQiOiA1MjI4LCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL3RydWNrLWFjY2lkZW50LWxhd3llcnMvXCI+YWJvZ2Fkb3MgZGUgYWNjaWRlbnRlcyBkZSBjYW1pw7NuIGVuIFNhdmFubmFoPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCIvdHJ1Y2stYWNjaWRlbnQtbGF3eWVycy9zYXZhbm5haC1nYS9cIj5hYm9nYWRvcyBkZSBhY2NpZGVudGVzIGRlIGNhbWnDs24gZW4gU2F2YW5uYWg8L2E+In0sIHsiaWQiOiA1MjIwLCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL3RydWNrLWFjY2lkZW50LWxhd3llcnMvXCI+U2F2YW5uYWggdHJ1Y2sgYWNjaWRlbnQgbGF3eWVyczwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiL3RydWNrLWFjY2lkZW50LWxhd3llcnMvc2F2YW5uYWgtZ2EvXCI+U2F2YW5uYWggdHJ1Y2sgYWNjaWRlbnQgbGF3eWVyczwvYT4ifV0=' ), true );
if ( 'publish' !== get_post_status( 3627 ) ) {
    fprintf( $err, "ABORT: post 3627 is not published yet.\n" );
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
