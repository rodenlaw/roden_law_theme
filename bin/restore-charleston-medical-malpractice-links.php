<?php
/**
 * Restore the internal links to /medical-malpractice-lawyers/charleston-sc/ that the
 * September 2026 relinks repointed to the two-state pillar, now that the page is rebuilt (wave 1, #11 of
 * docs/site-architecture/README.md). Spanish anchors are left out: the Spanish
 * twin stays retired.
 *
 * The pairs are exact anchors from earning-intersections-relink-2026-09-19.json: each anchor as it was
 * ("restore") and as the relink left it ("current"). Retired posts are skipped at
 * run time. An anchor is restored only if it appears in the post exactly as the
 * relink left it and no more often than the pairs expect; anything edited since
 * is skipped and reported. Direct column write: href only, post_modified untouched.
 *
 * Run AFTER post 3644 is published and its redirect is removed.
 *   Dry run: ssh $H "wp --path=$P eval-file -" < bin/restore-charleston-medical-malpractice-links.php > docs/backups/charleston-medical-malpractice-links-restore-$(date +%Y-%m-%d).json
 *   Apply:   ssh $H "wp --path=$P eval-file - apply" < bin/restore-charleston-medical-malpractice-links.php > …
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$pairs = json_decode( base64_decode( 'W3siaWQiOiA0MzQ5LCAiY3VycmVudCI6ICI8YSBocmVmPVwiL3ByYWN0aWNlLWFyZWFzL21lZGljYWwtbWFscHJhY3RpY2UtbGF3eWVycy9cIj5DaGFybGVzdG9uIG1lZGljYWwgbWFscHJhY3RpY2UgbGF3eWVyPC9hPiIsICJyZXN0b3JlIjogIjxhIGhyZWY9XCIvbWVkaWNhbC1tYWxwcmFjdGljZS1sYXd5ZXJzL2NoYXJsZXN0b24tc2MvXCI+Q2hhcmxlc3RvbiBtZWRpY2FsIG1hbHByYWN0aWNlIGxhd3llcjwvYT4ifSwgeyJpZCI6IDQzNjMsICJjdXJyZW50IjogIjxhIGhyZWY9XCIvcHJhY3RpY2UtYXJlYXMvbWVkaWNhbC1tYWxwcmFjdGljZS1sYXd5ZXJzL1wiPm1lZGljYWwgbWFscHJhY3RpY2UgY2xhaW0gaW4gQ2hhcmxlc3RvbjwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiL21lZGljYWwtbWFscHJhY3RpY2UtbGF3eWVycy9jaGFybGVzdG9uLXNjL1wiPm1lZGljYWwgbWFscHJhY3RpY2UgY2xhaW0gaW4gQ2hhcmxlc3RvbjwvYT4ifSwgeyJpZCI6IDQzNjMsICJjdXJyZW50IjogIjxhIGhyZWY9XCIvcHJhY3RpY2UtYXJlYXMvbWVkaWNhbC1tYWxwcmFjdGljZS1sYXd5ZXJzL1wiPkNoYXJsZXN0b24gbWVkaWNhbCBtYWxwcmFjdGljZSBhdHRvcm5leTwvYT4iLCAicmVzdG9yZSI6ICI8YSBocmVmPVwiL21lZGljYWwtbWFscHJhY3RpY2UtbGF3eWVycy9jaGFybGVzdG9uLXNjL1wiPkNoYXJsZXN0b24gbWVkaWNhbCBtYWxwcmFjdGljZSBhdHRvcm5leTwvYT4ifV0=' ), true );
if ( 'publish' !== get_post_status( 3644 ) ) {
    fprintf( $err, "ABORT: post 3644 is not published yet.\n" );
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
