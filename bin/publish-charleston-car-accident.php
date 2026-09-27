<?php
/**
 * Publish the rebuilt Charleston car accident page (post 3624).
 *
 * Preconditions, all checked:
 * - the page is allowlisted in roden_office_practice_allowlist() (#162);
 * - the content from bin/rebuild-charleston-car-accident.php is on the draft.
 *
 * Reviewed by Graeham C. Gillin (SC Bar); the owner confirmed his review on
 * 2026-09-26, and that date is recorded as _roden_last_reviewed.
 *
 * Run while /car-accident-lawyers/charleston-sc/ still 301s (the #143 map runs
 * at priority 0), so the page is never public half-built. Then deploy the
 * change that removes the redirect.
 *
 *   ssh $H "wp --path=$P eval-file - apply" < bin/publish-charleston-car-accident.php
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3624;
global $wpdb;

if ( ! function_exists( 'roden_office_practice_allowlist' ) || ! in_array( 'car-accident-lawyers/charleston-sc', roden_office_practice_allowlist(), true ) ) {
    fprintf( $err, "ABORT: the allowlist (#162) is not deployed.\n" );
    exit( 1 );
}
$p = get_post( $id );
if ( ! $p || 'draft' !== $p->post_status || 'Charleston Car Accident Lawyers' !== $p->post_title || false === strpos( $p->post_content, 'Where Car Accidents Happen in Charleston' ) ) {
    fprintf( $err, "ABORT: post %d is not the rebuilt draft.\n", $id );
    exit( 1 );
}
fprintf( $err, "%s — publish post %d %s\n", $apply ? 'APPLY' : 'DRY RUN', $id, get_permalink( $id ) );
if ( ! $apply ) {
    exit( 0 );
}

$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_status' => 'publish' ) ), true );
if ( is_wp_error( $r ) ) {
    fprintf( $err, "FAILED: %s\n", $r->get_error_message() );
    exit( 1 );
}
delete_post_meta( $id, '_roden_retired' );
update_post_meta( $id, '_roden_last_reviewed', '2026-09-26' );
clean_post_cache( $id );

$status  = $wpdb->get_var( $wpdb->prepare( "SELECT post_status FROM {$wpdb->posts} WHERE ID = %d", $id ) );
$retired = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = '_roden_retired'", $id ) );
fprintf( $err, "%s: status=%s, _roden_retired rows=%d\n", ( 'publish' === $status && ! $retired ) ? 'PUBLISHED' : 'CHECK', $status, $retired );
exit( 'publish' === $status && ! $retired ? 0 : 1 );
