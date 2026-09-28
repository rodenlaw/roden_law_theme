<?php
/**
 * Refresh _roden_last_reviewed to 2026-09-28 on the linked-page batch posts that
 * already carry a review date. Owner, 2026-09-28: "consider all to have been
 * reviewed this afternoon". Posts with no stamp are left alone: the stamp renders
 * as "Reviewed by <author attorney>", and adding one where none existed could
 * credit an attorney who was not the reviewer.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/restamp-linked-pages-reviewed.php
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$ids   = array( 3553, 4099, 4101, 4102, 4104, 4105, 4106, 4195, 4337, 4339, 4346, 4349, 4363, 4562, 4617, 4645, 4678, 4679, 4809, 4861 );
foreach ( $ids as $id ) {
	$cur = (string) get_post_meta( $id, '_roden_last_reviewed', true );
	if ( '' === $cur ) { fwrite( STDERR, "  $id no stamp, left alone\n" ); continue; }
	fwrite( STDERR, "  $id $cur -> 2026-09-28" . ( $apply ? '' : ' (dry run)' ) . "\n" );
	if ( $apply ) { update_post_meta( $id, '_roden_last_reviewed', '2026-09-28' ); clean_post_cache( $id ); }
}
