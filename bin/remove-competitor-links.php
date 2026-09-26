<?php
/**
 * Remove the links from two Roden posts to a competing firm's site (2026-09-26).
 *
 * Post 3531 (published) sent readers to a competitor's contact page ("broader
 * resources like the team at …") before offering Roden's own. Post 3528 (a
 * retired draft) linked "contacting a personal injury attorney" to the same
 * competitor page. A sweep of every post body, meta value, excerpt and option
 * on 2026-09-26 found no other link or mention.
 *
 * 3531: the clause naming the competitor is removed and the sentence keeps
 * Roden's contact link. 3528: the link is unwrapped and its anchor text kept.
 *
 * Exact-match fragments, each must match once or the script stops. Direct
 * column write (no wp_update_post(): no wp_unslash() pass, no post_modified
 * stamp), with the result read back from the table.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/remove-competitor-links.php > docs/backups/competitor-links-2026-09-26.json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/remove-competitor-links.php > docs/backups/competitor-links-2026-09-26.json
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
	3531 => array(
		'While some may seek information from broader resources like the team at <a href="https://georgiaautolaw.com/help-center/contact-us/" rel="noopener noreferrer" target="_blank">Georgia Auto Law</a> to understand their options, those ready to take the next step locally can <a href="https://rodenlaw.com/contact/">contact us</a> for a direct consultation.',
		'When you are ready to take the next step, <a href="https://rodenlaw.com/contact/">contact us</a> for a direct consultation.',
	),
	3528 => array(
		'<a href="https://georgiaautolaw.com/help-center/contact-us/" rel="noopener" target="_blank">contacting a personal injury attorney</a>',
		'contacting a personal injury attorney',
	),
);

$backup = array(
	'generated' => gmdate( 'c' ),
	'batch'     => 'competitor-links',
	'mode'      => $apply ? 'apply' : 'dry-run',
	'note'      => 'post_content before/after per post. Restore by writing "before" back to wp_posts.post_content.',
	'posts'     => array(),
);

foreach ( $fixes as $id => $pair ) {
	list( $from, $to ) = $pair;
	$before = (string) $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	$n      = substr_count( $before, $from );
	if ( 1 !== $n ) {
		fwrite( STDERR, "ABORT: post {$id} contains the fragment {$n} times, expected 1.\n" );
		exit( 1 );
	}
	$after = str_replace( $from, $to, $before );
	if ( false !== stripos( $after, 'georgiaautolaw' ) ) {
		fwrite( STDERR, "ABORT: post {$id} would still contain the competitor's domain.\n" );
		exit( 1 );
	}
	$backup['posts'][] = array( 'ID' => $id, 'status' => get_post_status( $id ), 'from' => $from, 'to' => $to, 'before' => $before, 'after' => $after );
	fwrite( STDERR, sprintf( "  %s %d (%s)\n", $apply ? 'fixed' : 'would fix', $id, get_post_status( $id ) ) );

	if ( $apply ) {
		$ok  = $wpdb->update( $wpdb->posts, array( 'post_content' => $after ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
		clean_post_cache( $id );
		$now = (string) $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
		if ( false === $ok || $now !== $after ) {
			fwrite( STDERR, "FAILED: read-back mismatch on {$id}\n" );
			exit( 1 );
		}
	}
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fwrite( STDERR, ( $apply ? 'Applied' : 'Dry run' ) . ': ' . count( $fixes ) . " posts\n" );
