<?php
/**
 * Publish the six Georgia statewide pillar drafts (IDs 6317-6322), created by
 * bin/create-ga-statewide-pages.php. Owner, 2026-09-29: "start the Georgia
 * statewide pages. Those are cleared by Eric Roden." Run only after the legal
 * sweep (data/facts/remediation-2026-09-29-ga-statewide.md) clears and its fixes
 * are applied. Stamps _roden_last_reviewed with the owner-confirmed review date.
 * The URLs are new, so no redirect is involved.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/publish-ga-statewide-pages.php
 */
$apply    = isset( $args[0] ) && 'apply' === $args[0];
$reviewed = '2026-09-29'; // Eric Roden, per the owner (2026-09-29)
$ids      = array( 6317, 6318, 6319, 6320, 6321, 6322 );
global $wpdb;
foreach ( $ids as $id ) {
	$p = get_post( $id );
	if ( ! $p || 'page' !== $p->post_type || 'templates/template-pillar-ga-statewide.php' !== get_post_meta( $id, '_wp_page_template', true ) || 0 !== strpos( $p->post_name, 'georgia-' ) ) {
		fwrite( STDERR, "ABORT: $id is not a Georgia statewide draft\n" ); exit( 1 );
	}
	fwrite( STDERR, sprintf( "  %s %d /%s/ (%s)\n", $apply ? 'publish' : 'would publish', $id, $p->post_name, $p->post_status ) );
	if ( ! $apply || 'publish' === $p->post_status ) { continue; }
	$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_status' => 'publish' ) ), true );
	if ( is_wp_error( $r ) ) { fwrite( STDERR, 'FAILED: ' . $r->get_error_message() . "\n" ); exit( 1 ); }
	update_post_meta( $id, '_roden_last_reviewed', $reviewed );
	clean_post_cache( $id );
	if ( 'publish' !== $wpdb->get_var( $wpdb->prepare( "SELECT post_status FROM {$wpdb->posts} WHERE ID = %d", $id ) ) ) { fwrite( STDERR, "FAILED status $id\n" ); exit( 1 ); }
}
