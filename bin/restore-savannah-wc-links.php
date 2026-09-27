<?php
/**
 * Restore the internal links to /workers-compensation-lawyers/savannah-ga/ that #143
 * repointed to the two-state pillar on 2026-09-19, now that the page is rebuilt
 * (wave 1, #6 of docs/site-architecture/README.md).
 *
 * The pairs are exact anchors taken from docs/backups/earning-intersections-
 * relink-2026-09-19.json: each anchor as it was before #143 ("restore") and as
 * #143 left it ("current"). Retired posts are skipped at run time. An anchor is restored only if it appears in the post
 * exactly as #143 left it and no more often than the pairs expect; anything
 * edited since is skipped and reported. Direct column write, as in the relink
 * scripts: href only, post_modified untouched.
 *
 * Run AFTER post 3652 is published and its redirect is removed, or the links
 * point at a 301.
 *   Dry run: ssh $H "wp --path=$P eval-file -" < bin/restore-savannah-wc-links.php > docs/backups/savannah-wc-links-restore-$(date +%Y-%m-%d).json
 *   Apply:   ssh $H "wp --path=$P eval-file - apply" < bin/restore-savannah-wc-links.php > …
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$pairs = json_decode( base64_decode( 'W3siaWQiOiAxODU1LCAiY3VycmVudCI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vcHJhY3RpY2UtYXJlYXMvd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9cIj5TYXZhbm5haCwgR0Egd29ya2Vyc+KAmSBjb21wZW5zYXRpb24gbGF3eWVyPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPlNhdmFubmFoLCBHQSB3b3JrZXJz4oCZIGNvbXBlbnNhdGlvbiBsYXd5ZXI8L2E+In0sIHsiaWQiOiAxODc2LCAiY3VycmVudCI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vcHJhY3RpY2UtYXJlYXMvd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9cIj5TYXZhbm5haCwgR0Egd29ya2VycyBjb21wZW5zYXRpb24gbGF3eWVyPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPlNhdmFubmFoLCBHQSB3b3JrZXJzIGNvbXBlbnNhdGlvbiBsYXd5ZXI8L2E+In0sIHsiaWQiOiAxODc4LCAiY3VycmVudCI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vcHJhY3RpY2UtYXJlYXMvd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9cIj5TYXZhbm5haCB3b3JrZXJz4oCZIGNvbXBlbnNhdGlvbiBhdHRvcm5leTwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9zYXZhbm5haC1nYS9cIj5TYXZhbm5haCB3b3JrZXJz4oCZIGNvbXBlbnNhdGlvbiBhdHRvcm5leTwvYT4ifSwgeyJpZCI6IDE4NDgsICJjdXJyZW50IjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS9wcmFjdGljZS1hcmVhcy93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL1wiPndvcmtlcuKAmXMgY29tcGVuc2F0aW9uPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPndvcmtlcuKAmXMgY29tcGVuc2F0aW9uPC9hPiJ9LCB7ImlkIjogMTg0NiwgImN1cnJlbnQiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3ByYWN0aWNlLWFyZWFzL3dvcmtlcnMtY29tcGVuc2F0aW9uLWxhd3llcnMvXCI+d29ya2Vyc+KAmSBjb21wZW5zYXRpb24gY2FzZXMgaW4gR2VvcmdpYTwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9zYXZhbm5haC1nYS9cIj53b3JrZXJz4oCZIGNvbXBlbnNhdGlvbiBjYXNlcyBpbiBHZW9yZ2lhPC9hPiJ9LCB7ImlkIjogMTg0MiwgImN1cnJlbnQiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3ByYWN0aWNlLWFyZWFzL3dvcmtlcnMtY29tcGVuc2F0aW9uLWxhd3llcnMvXCI+U2F2YW5uYWggd29ya2Vyc+KAmSBjb21wZW5zYXRpb24gYXR0b3JuZXlzPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPlNhdmFubmFoIHdvcmtlcnPigJkgY29tcGVuc2F0aW9uIGF0dG9ybmV5czwvYT4ifSwgeyJpZCI6IDE4NDEsICJjdXJyZW50IjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS9wcmFjdGljZS1hcmVhcy93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL1wiPmNvbnNpZGVyIGhpcmluZyBhIHdvcmtlcnMnIGNvbXBlbnNhdGlvbiBsYXd5ZXI8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3dvcmtlcnMtY29tcGVuc2F0aW9uLWxhd3llcnMvc2F2YW5uYWgtZ2EvXCI+Y29uc2lkZXIgaGlyaW5nIGEgd29ya2VycycgY29tcGVuc2F0aW9uIGxhd3llcjwvYT4ifSwgeyJpZCI6IDE4MzQsICJjdXJyZW50IjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS9wcmFjdGljZS1hcmVhcy93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL1wiPlNhdmFubmFoIHdvcmtlcnPigJkgY29tcGVuc2F0aW9uIGxhd3llcjwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9zYXZhbm5haC1nYS9cIj5TYXZhbm5haCB3b3JrZXJz4oCZIGNvbXBlbnNhdGlvbiBsYXd5ZXI8L2E+In0sIHsiaWQiOiAxODA5LCAiY3VycmVudCI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vcHJhY3RpY2UtYXJlYXMvd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9cIj5TYXZhbm5haCB3b3JrZXJz4oCZIGNvbXBlbnNhdGlvbiBhdHRvcm5leXM8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3dvcmtlcnMtY29tcGVuc2F0aW9uLWxhd3llcnMvc2F2YW5uYWgtZ2EvXCI+U2F2YW5uYWggd29ya2Vyc+KAmSBjb21wZW5zYXRpb24gYXR0b3JuZXlzPC9hPiJ9LCB7ImlkIjogMTc4NSwgImN1cnJlbnQiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3ByYWN0aWNlLWFyZWFzL3dvcmtlcnMtY29tcGVuc2F0aW9uLWxhd3llcnMvXCI+U2F2YW5uYWggd29ya2Vyc+KAmSBjb21wZW5zYXRpb24gbGF3eWVyPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPlNhdmFubmFoIHdvcmtlcnPigJkgY29tcGVuc2F0aW9uIGxhd3llcjwvYT4ifSwgeyJpZCI6IDE3ODQsICJjdXJyZW50IjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS9wcmFjdGljZS1hcmVhcy93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL1wiPlNhdmFubmFoIHdvcmtlcnPigJkgY29tcGVuc2F0aW9uIGF0dG9ybmV5czwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9zYXZhbm5haC1nYS9cIj5TYXZhbm5haCB3b3JrZXJz4oCZIGNvbXBlbnNhdGlvbiBhdHRvcm5leXM8L2E+In0sIHsiaWQiOiAxNzgyLCAiY3VycmVudCI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vcHJhY3RpY2UtYXJlYXMvd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9cIj5TYXZhbm5haCB3b3JrZXJz4oCZIGNvbXBlbnNhdGlvbiBsYXd5ZXJzPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPlNhdmFubmFoIHdvcmtlcnPigJkgY29tcGVuc2F0aW9uIGxhd3llcnM8L2E+In0sIHsiaWQiOiAxNzc4LCAiY3VycmVudCI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vcHJhY3RpY2UtYXJlYXMvd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9cIj5TYXZhbm5haCB3b3JrZXJz4oCZIGNvbXBlbnNhdGlvbiBsYXd5ZXJzPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPlNhdmFubmFoIHdvcmtlcnPigJkgY29tcGVuc2F0aW9uIGxhd3llcnM8L2E+In0sIHsiaWQiOiAxNzc0LCAiY3VycmVudCI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vcHJhY3RpY2UtYXJlYXMvd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9cIj5TYXZhbm5haCB3b3JrZXJz4oCZIGNvbXBlbnNhdGlvbiBhdHRvcm5leXM8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3dvcmtlcnMtY29tcGVuc2F0aW9uLWxhd3llcnMvc2F2YW5uYWgtZ2EvXCI+U2F2YW5uYWggd29ya2Vyc+KAmSBjb21wZW5zYXRpb24gYXR0b3JuZXlzPC9hPiJ9LCB7ImlkIjogMTc3MSwgImN1cnJlbnQiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3ByYWN0aWNlLWFyZWFzL3dvcmtlcnMtY29tcGVuc2F0aW9uLWxhd3llcnMvXCI+U2F2YW5uYWggd29ya2Vyc+KAmSBjb21wZW5zYXRpb24gbGF3eWVyczwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiaHR0cHM6Ly9yb2Rlbmxhdy5jb20vd29ya2Vycy1jb21wZW5zYXRpb24tbGF3eWVycy9zYXZhbm5haC1nYS9cIj5TYXZhbm5haCB3b3JrZXJz4oCZIGNvbXBlbnNhdGlvbiBsYXd5ZXJzPC9hPiJ9LCB7ImlkIjogMTc2NSwgImN1cnJlbnQiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3ByYWN0aWNlLWFyZWFzL3dvcmtlcnMtY29tcGVuc2F0aW9uLWxhd3llcnMvXCI+U2F2YW5uYWggd29ya2Vyc+KAmSBjb21wZW5zYXRpb24gbGF3eWVyPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL3NhdmFubmFoLWdhL1wiPlNhdmFubmFoIHdvcmtlcnPigJkgY29tcGVuc2F0aW9uIGxhd3llcjwvYT4ifSwgeyJpZCI6IDE3NjQsICJjdXJyZW50IjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS9wcmFjdGljZS1hcmVhcy93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL1wiPlNhdmFubmFoIHdvcmtlcnPigJkgY29tcGVuc2F0aW9uIGxhd3llcnM8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3dvcmtlcnMtY29tcGVuc2F0aW9uLWxhd3llcnMvc2F2YW5uYWgtZ2EvXCI+U2F2YW5uYWggd29ya2Vyc+KAmSBjb21wZW5zYXRpb24gbGF3eWVyczwvYT4ifSwgeyJpZCI6IDE3NjAsICJjdXJyZW50IjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS9wcmFjdGljZS1hcmVhcy93b3JrZXJzLWNvbXBlbnNhdGlvbi1sYXd5ZXJzL1wiPndvcmtlcnPigJkgY29tcCBsYXd5ZXI8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cImh0dHBzOi8vcm9kZW5sYXcuY29tL3dvcmtlcnMtY29tcGVuc2F0aW9uLWxhd3llcnMvc2F2YW5uYWgtZ2EvXCI+d29ya2Vyc+KAmSBjb21wIGxhd3llcjwvYT4ifV0=' ), true );
if ( 'publish' !== get_post_status( 3652 ) ) {
    fprintf( $err, "ABORT: post 3652 is not published yet.\n" );
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
