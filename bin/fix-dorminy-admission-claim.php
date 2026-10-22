<?php
/**
 * Remove a false bar-admission claim from post 5220's body.
 *
 *   ssh $H "wp --path=... eval-file -"       < bin/fix-dorminy-admission-claim.php
 *   ssh $H "wp --path=... eval-file - apply" < bin/fix-dorminy-admission-claim.php
 *
 * /resources/truck-accident-settlement-process/ says Joshua Dorminy "is admitted
 * in both Georgia and South Carolina". He is admitted in Georgia only (Brian,
 * 2026-10-22). A sweep of post_content, post_excerpt, _roden_faqs,
 * _roden_key_takeaways and _roden_why_hire for Dorminy and Montano admission
 * claims found this one sentence only.
 *
 * Exact-string replace: if the sentence is not found verbatim, nothing is
 * written. Writes with wp_update_post( wp_slash() ) (CLAUDE.md) and records
 * _roden_content_modified, since this changes what the page says.
 * Owner: Brian, 2026-10-22.
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (pass 'apply' to write) ===\n\n";

$id   = 5220;
$old  = "the Roden Law partner who leads the firm's trucking litigation and is admitted in both Georgia and South Carolina, points out";
$new  = "the Roden Law partner who leads the firm's trucking litigation, points out";
$post = get_post( $id );
if ( ! $post || 'truck-accident-settlement-process' !== $post->post_name ) {
	echo "Post $id is not truck-accident-settlement-process. Stopping.\n";
	return;
}

// The body may store the apostrophe straight or curly; match whichever is there.
$apostrophes = array( "'", '&#8217;', "\u{2019}" );
$found = null;
$replacement = null;
foreach ( $apostrophes as $ap ) {
	$v = str_replace( "'", $ap, $old );
	if ( 1 === substr_count( $post->post_content, $v ) ) {
		$found       = $v;
		$replacement = str_replace( "'", $ap, $new ); // keep the body's apostrophe form
		break;
	}
}
if ( null === $found ) {
	echo "Sentence not found exactly once in post $id. Nothing written.\n";
	return;
}

printf( "  [%d] %s\n  - %s\n  + %s\n", $id, wp_make_link_relative( get_permalink( $id ) ), $found, $replacement );
if ( ! $apply ) {
	echo "\nDry run. Re-run with 'apply' to write.\n";
	return;
}

$before = $post->post_content;
$after  = str_replace( $found, $replacement, $before );
$res    = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $after ) ), true );
if ( is_wp_error( $res ) ) {
	echo 'FAILED: ' . $res->get_error_message() . "\n";
	return;
}
update_post_meta( $id, '_roden_content_modified', wp_slash( gmdate( 'Y-m-d H:i:s' ) ) );
clean_post_cache( $id );

$now = get_post_field( 'post_content', $id );
printf( "\nBACKUP-SHA1 before: %s\nverify: claim gone %s, replacement present %s, length %d -> %d\nDone.\n",
	sha1( $before ),
	false === strpos( $now, 'admitted in both Georgia and South Carolina' ) ? 'yes' : 'NO',
	false !== strpos( $now, $replacement ) ? 'yes' : 'NO',
	strlen( $before ), strlen( $now ) );
