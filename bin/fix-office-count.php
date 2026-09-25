<?php
/**
 * Correct "five offices" to six in four blog posts (2026-09-25).
 *
 * The firm has six offices: Savannah, Darien, Charleston, North Charleston,
 * Columbia and Myrtle Beach (inc/firm-data.php; confirmed by the owner
 * 2026-09-25). Four post bodies said five, and post 1712 listed the five it
 * meant and left out North Charleston. A sweep of every published post body,
 * post meta value, excerpt and option on 2026-09-25 found no other instance.
 * The theme strings that said 5 were fixed in the same change.
 *
 * Each replacement is an exact sentence fragment and must match exactly once,
 * or the script stops. Written straight to the column, the same as the relink
 * scripts: no wp_update_post(), so no wp_unslash() pass and no post_modified
 * stamp for a one-word correction.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-office-count.php > docs/backups/office-count-2026-09-25.json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-office-count.php > docs/backups/office-count-2026-09-25.json
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

global $wpdb;
$apply = isset( $args[0] ) && 'apply' === $args[0];

$fixes = array(
	1816 => array( 'serve clients from five offices across Georgia', 'serve clients from six offices across Georgia' ),
	1703 => array( 'any of our five offices across Georgia', 'any of our six offices across Georgia' ),
	1712 => array( 'any of our five offices in Savannah, Darien, Charleston, Columbia, and Myrtle Beach', 'any of our six offices in Savannah, Darien, Charleston, North Charleston, Columbia, and Myrtle Beach' ),
	1715 => array( 'across five offices in Georgia', 'across six offices in Georgia' ),
);

$backup = array(
	'generated' => gmdate( 'c' ),
	'batch'     => 'office-count',
	'mode'      => $apply ? 'apply' : 'dry-run',
	'note'      => 'post_content before/after per post. Restore by writing "before" back to wp_posts.post_content.',
	'posts'     => array(),
);

foreach ( $fixes as $id => $pair ) {
	list( $from, $to ) = $pair;
	$before = (string) get_post_field( 'post_content', $id );
	$n      = substr_count( $before, $from );
	if ( 1 !== $n ) {
		fwrite( STDERR, "ABORT: post {$id} contains the fragment {$n} times, expected 1.\n" );
		exit( 1 );
	}
	$after                = str_replace( $from, $to, $before );
	$backup['posts'][]    = array( 'ID' => $id, 'permalink' => get_permalink( $id ), 'from' => $from, 'to' => $to, 'before' => $before, 'after' => $after );
	fwrite( STDERR, sprintf( "  %s %-5d %s\n", $apply ? 'fixed' : 'would fix', $id, get_permalink( $id ) ) );

	if ( $apply ) {
		$ok = $wpdb->update( $wpdb->posts, array( 'post_content' => $after ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
		clean_post_cache( $id );
		$now = (string) $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
		if ( false === $ok || $now !== $after ) {
			fwrite( STDERR, "FAILED: read-back mismatch on {$id}\n" );
			exit( 1 );
		}
	}
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fwrite( STDERR, ( $apply ? 'Applied' : 'Dry run' ) . ": 4 posts\n" );
