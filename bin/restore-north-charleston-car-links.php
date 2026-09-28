<?php
/**
 * Restore the internal links to /car-accident-lawyers/north-charleston-sc/ that the
 * 2026-09-18 zero-click relink repointed to the two-state pillar, now that the page is rebuilt (wave 1, #9 of
 * docs/site-architecture/README.md). Spanish anchors are left out: the Spanish
 * twin stays retired.
 *
 * The pairs are exact anchors from docs/backups/zero-click-relink-2026-09-18.json: each anchor as it was
 * ("restore") and as the relink left it ("current"). Retired posts are skipped at
 * run time. An anchor is restored only if it appears in the post exactly as the
 * relink left it and no more often than the pairs expect; anything edited since
 * is skipped and reported. Direct column write: href only, post_modified untouched.
 *
 * Run AFTER post 4540 is published and its redirect is removed.
 *   Dry run: ssh $H "wp --path=$P eval-file -" < bin/restore-north-charleston-car-links.php > docs/backups/north-charleston-car-links-restore-$(date +%Y-%m-%d).json
 *   Apply:   ssh $H "wp --path=$P eval-file - apply" < bin/restore-north-charleston-car-links.php > …
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$pairs = json_decode( base64_decode( 'W3siaWQiOiA0NzA0LCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL2Nhci1hY2NpZGVudC1sYXd5ZXJzL1wiPk5vcnRoIENoYXJsZXN0b24gY2FyIGFjY2lkZW50IGxhd3llcnM8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cIi9jYXItYWNjaWRlbnQtbGF3eWVycy9ub3J0aC1jaGFybGVzdG9uLXNjL1wiPk5vcnRoIENoYXJsZXN0b24gY2FyIGFjY2lkZW50IGxhd3llcnM8L2E+In0sIHsiaWQiOiAzNDM1LCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL2Nhci1hY2NpZGVudC1sYXd5ZXJzL1wiPm91ciBleHBlcmllbmNlZCBOb3J0aCBDaGFybGVzdG9uIGNhciBhY2NpZGVudCBsYXd5ZXJzPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCIvY2FyLWFjY2lkZW50LWxhd3llcnMvbm9ydGgtY2hhcmxlc3Rvbi1zYy9cIj5vdXIgZXhwZXJpZW5jZWQgTm9ydGggQ2hhcmxlc3RvbiBjYXIgYWNjaWRlbnQgbGF3eWVyczwvYT4ifSwgeyJpZCI6IDQ3MjUsICJjdXJyZW50IjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS9wcmFjdGljZS1hcmVhcy9jYXItYWNjaWRlbnQtbGF3eWVycy9cIj5Ob3J0aCBDaGFybGVzdG9uIGNhciBhY2NpZGVudCBsYXd5ZXJzPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCJodHRwczovL3JvZGVubGF3LmNvbS9jYXItYWNjaWRlbnQtbGF3eWVycy9ub3J0aC1jaGFybGVzdG9uLXNjL1wiPk5vcnRoIENoYXJsZXN0b24gY2FyIGFjY2lkZW50IGxhd3llcnM8L2E+In0sIHsiaWQiOiA0NzMzLCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL2Nhci1hY2NpZGVudC1sYXd5ZXJzL1wiPk5vcnRoIENoYXJsZXN0b24gY2FyIGFjY2lkZW50IGxhd3llcnM8L2E+IiwgInJlc3RvcmUiOiAiPGEgaHJlZj1cIi9jYXItYWNjaWRlbnQtbGF3eWVycy9ub3J0aC1jaGFybGVzdG9uLXNjL1wiPk5vcnRoIENoYXJsZXN0b24gY2FyIGFjY2lkZW50IGxhd3llcnM8L2E+In0sIHsiaWQiOiA0NzUwLCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL2Nhci1hY2NpZGVudC1sYXd5ZXJzL1wiPmNhciBhY2NpZGVudCBsYXd5ZXJzIGluIE5vcnRoIENoYXJsZXN0b24sIFNDPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCIvY2FyLWFjY2lkZW50LWxhd3llcnMvbm9ydGgtY2hhcmxlc3Rvbi1zYy9cIj5jYXIgYWNjaWRlbnQgbGF3eWVycyBpbiBOb3J0aCBDaGFybGVzdG9uLCBTQzwvYT4ifV0=' ), true );
if ( 'publish' !== get_post_status( 4540 ) ) {
    fprintf( $err, "ABORT: post 4540 is not published yet.\n" );
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
