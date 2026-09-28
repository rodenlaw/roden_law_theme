<?php
/**
 * Restore the internal links to /car-accident-lawyers/columbia-sc/ that the
 * 2026-09-18 zero-click relink and the 2026-09-19 earning-intersections relink
 * repointed to the two-state pillar, now that the page is rebuilt (wave 1, #8 of
 * docs/site-architecture/README.md). Spanish anchors are left out: the Spanish
 * twin stays retired.
 *
 * The pairs are exact anchors from docs/backups/zero-click-relink-2026-09-18.json
 * and earning-intersections-relink-2026-09-19.json: each anchor as it was
 * ("restore") and as the relink left it ("current"). Retired posts are skipped at
 * run time. An anchor is restored only if it appears in the post exactly as the
 * relink left it and no more often than the pairs expect; anything edited since
 * is skipped and reported. Direct column write: href only, post_modified untouched.
 *
 * Run AFTER post 3625 is published and its redirect is removed.
 *   Dry run: ssh $H "wp --path=$P eval-file -" < bin/restore-columbia-car-links.php > docs/backups/columbia-car-links-restore-$(date +%Y-%m-%d).json
 *   Apply:   ssh $H "wp --path=$P eval-file - apply" < bin/restore-columbia-car-links.php > …
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$pairs = json_decode( base64_decode( 'W3siaWQiOiAxNzE0LCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL2Nhci1hY2NpZGVudC1sYXd5ZXJzL1wiPkNvbHVtYmlhPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCIvY2FyLWFjY2lkZW50LWxhd3llcnMvY29sdW1iaWEtc2MvXCI+Q29sdW1iaWE8L2E+In0sIHsiaWQiOiAxNzQwLCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL2Nhci1hY2NpZGVudC1sYXd5ZXJzL1wiPkNvbHVtYmlhIGNhciBhY2NpZGVudCBsYXd5ZXJzPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCIvY2FyLWFjY2lkZW50LWxhd3llcnMvY29sdW1iaWEtc2MvXCI+Q29sdW1iaWEgY2FyIGFjY2lkZW50IGxhd3llcnM8L2E+In0sIHsiaWQiOiAzNTUzLCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL2Nhci1hY2NpZGVudC1sYXd5ZXJzL1wiPkNvbHVtYmlhIGNhciBhY2NpZGVudCBsYXd5ZXI8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cIi9jYXItYWNjaWRlbnQtbGF3eWVycy9jb2x1bWJpYS1zYy9cIj5Db2x1bWJpYSBjYXIgYWNjaWRlbnQgbGF3eWVyPC9hPiJ9LCB7ImlkIjogMzU1MywgImN1cnJlbnQiOiAiPGEgaHJlZj1cIi9wcmFjdGljZS1hcmVhcy9jYXItYWNjaWRlbnQtbGF3eWVycy9cIj5Db2x1bWJpYSBjYXIgYWNjaWRlbnQgbGF3eWVyPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCIvY2FyLWFjY2lkZW50LWxhd3llcnMvY29sdW1iaWEtc2MvXCI+Q29sdW1iaWEgY2FyIGFjY2lkZW50IGxhd3llcjwvYT4ifSwgeyJpZCI6IDQ3MTEsICJjdXJyZW50IjogIjxhIGhyZWY9XCIvcHJhY3RpY2UtYXJlYXMvY2FyLWFjY2lkZW50LWxhd3llcnMvXCI+Q29sdW1iaWEgY2FyIGFjY2lkZW50IGxhd3llcnM8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cIi9jYXItYWNjaWRlbnQtbGF3eWVycy9jb2x1bWJpYS1zYy9cIj5Db2x1bWJpYSBjYXIgYWNjaWRlbnQgbGF3eWVyczwvYT4ifSwgeyJpZCI6IDQ3MjcsICJjdXJyZW50IjogIjxhIGhyZWY9XCIvcHJhY3RpY2UtYXJlYXMvY2FyLWFjY2lkZW50LWxhd3llcnMvXCI+Q29sdW1iaWEsIFNDIGNhciBhY2NpZGVudCBsYXd5ZXJzPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCIvY2FyLWFjY2lkZW50LWxhd3llcnMvY29sdW1iaWEtc2MvXCI+Q29sdW1iaWEsIFNDIGNhciBhY2NpZGVudCBsYXd5ZXJzPC9hPiJ9LCB7ImlkIjogNDgwMiwgImN1cnJlbnQiOiAiPGEgaHJlZj1cIi9wcmFjdGljZS1hcmVhcy9jYXItYWNjaWRlbnQtbGF3eWVycy9cIj5Db2x1bWJpYSwgU0MgY2FyIGFjY2lkZW50IGxhd3llcnM8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cIi9jYXItYWNjaWRlbnQtbGF3eWVycy9jb2x1bWJpYS1zYy9cIj5Db2x1bWJpYSwgU0MgY2FyIGFjY2lkZW50IGxhd3llcnM8L2E+In0sIHsiaWQiOiA1MDI1LCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL2Nhci1hY2NpZGVudC1sYXd5ZXJzL1wiPkNvbHVtYmlhIGNhciBhY2NpZGVudCBsYXd5ZXJzPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCIvY2FyLWFjY2lkZW50LWxhd3llcnMvY29sdW1iaWEtc2MvXCI+Q29sdW1iaWEgY2FyIGFjY2lkZW50IGxhd3llcnM8L2E+In1d' ), true );
if ( 'publish' !== get_post_status( 3625 ) ) {
    fprintf( $err, "ABORT: post 3625 is not published yet.\n" );
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
