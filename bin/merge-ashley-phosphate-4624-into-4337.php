<?php
/**
 * Merge the two Ashley Phosphate & I-26 posts onto the stronger URL. Owner, 2026-10-02:
 * "merge this and do the 301", then "Keep 4337's URL" once Search Console showed 4337
 * carried 28 clicks / 4,339 impressions over 16 months against 4624's 20 / 1,610, and
 * ranked for 93 queries 4624 never appeared for.
 *
 * 4624 (/blog/ashley-phosphate-i-26-south-carolinas-deadliest-intersection/) was refreshed
 * and retitled the same day; 4337 (/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/)
 * never was. This copies 4624's verified surfaces onto 4337 — title, body, excerpt, Key
 * Takeaways, FAQs, meta description, jurisdiction, review stamp — and leaves 4337's slug,
 * publish date and author untouched. The 301 from 4624 ships in the theme
 * (roden_ashley_phosphate_fold_urls()); 4624 is retired to draft after that deploys:
 *
 *   ssh $H "wp --path=$P eval-file - merge [apply]"  < bin/merge-ashley-phosphate-4624-into-4337.php
 *   ssh $H "wp --path=$P eval-file - retire [apply]" < bin/merge-ashley-phosphate-4624-into-4337.php
 *
 * Dry run by default. Writes go through wp_update_post( wp_slash() ) and
 * update_post_meta( wp_slash() ) — see CLAUDE.md on unslashed writes.
 */
global $wpdb;
$step  = isset( $args[0] ) ? $args[0] : '';
$apply = isset( $args[1] ) && 'apply' === $args[1];
$from  = get_post( 4624 );
$to    = get_post( 4337 );
if ( ! $from || 'ashley-phosphate-i-26-south-carolinas-deadliest-intersection' !== $from->post_name ) { fwrite( STDERR, "ABORT: 4624 is not the expected post\n" ); exit( 1 ); }
if ( ! $to || 'ashley-phosphate-road-i-26-dangerous-intersection-charleston' !== $to->post_name || 'publish' !== $to->post_status ) { fwrite( STDERR, "ABORT: 4337 is not the expected published post\n" ); exit( 1 ); }

$keys = array( '_roden_faqs', '_roden_key_takeaways', '_roden_meta_description', '_roden_jurisdiction', '_roden_last_reviewed', '_roden_author_attorney' );

if ( 'merge' === $step ) {
	echo "4337 title: {$to->post_title}\n    -> {$from->post_title}\n";
	echo '4337 body ' . strlen( $to->post_content ) . ' -> ' . strlen( $from->post_content ) . " bytes\n";
	foreach ( $keys as $k ) { echo "  $k: " . ( metadata_exists( 'post', 4337, $k ) ? 'replace' : 'add' ) . "\n"; }
	if ( ! $apply ) { echo "DRY RUN\n"; exit( 0 ); }
	$r = wp_update_post( wp_slash( array(
		'ID'           => 4337,
		'post_title'   => $from->post_title,
		'post_content' => $from->post_content,
		'post_excerpt' => $from->post_excerpt,
	) ), true );
	if ( is_wp_error( $r ) ) { fwrite( STDERR, 'ERR ' . $r->get_error_message() . "\n" ); exit( 1 ); }
	foreach ( $keys as $k ) { update_post_meta( 4337, $k, wp_slash( get_post_meta( 4624, $k, true ) ) ); }
	clean_post_cache( 4337 );
	$back = get_post( 4337 );
	$ok   = $back->post_content === $from->post_content && $back->post_title === $from->post_title && $back->post_excerpt === $from->post_excerpt;
	foreach ( $keys as $k ) { $ok = $ok && get_post_meta( 4337, $k, true ) === get_post_meta( 4624, $k, true ); }
	echo $ok ? "MERGED: 4337 matches 4624 on every copied field\n" : "FAIL: read-back mismatch\n";
	exit( $ok ? 0 : 1 );
}

if ( 'retire' === $step ) {
	echo "4624 is {$from->post_status}\n";
	if ( ! $apply ) { echo "DRY RUN\n"; exit( 0 ); }
	$wpdb->update( $wpdb->posts, array( 'post_status' => 'draft' ), array( 'ID' => 4624 ), array( '%s' ), array( '%d' ) );
	update_post_meta( 4624, '_roden_retired', wp_slash( '2026-10-02 merged into /blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/' ) );
	clean_post_cache( 4624 );
	echo 'now ' . $wpdb->get_var( "SELECT post_status FROM {$wpdb->posts} WHERE ID = 4624" ) . "\n";
	exit( 0 );
}

fwrite( STDERR, "usage: eval-file - merge|retire [apply]\n" );
exit( 1 );
