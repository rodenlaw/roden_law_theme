<?php
/**
 * Set a refreshed post's last-modified date to the day it was refreshed.
 *
 *   ssh <host> "wp --path=<site> eval-file - 3239:2026-10-02,4368:2026-10-02 [apply]" < bin/freshness-stamp-modified.php
 *
 * The freshness patcher writes post content without touching post_modified, so the Article
 * schema's dateModified (get_the_modified_date) and the sitemap lastmod kept reporting the
 * pre-refresh date. Run this after every Tier B apply, in the same step as the
 * _roden_last_reviewed stamp. Dry run by default; pass a second argument `apply` to write (WP-CLI rejects an unknown --apply flag).
 *
 * A date of today stamps the current site-local time; an earlier date (a backfill) stamps
 * 12:00 site-local on that day. A post whose post_modified is already later than the target
 * is left alone — something edited it after the refresh, and that date is the truer one.
 */
global $wpdb;
$apply = in_array( 'apply', $args, true );
$pairs = array_filter( explode( ',', isset( $args[0] ) ? $args[0] : '' ) );
$today = current_time( 'Y-m-d' );
$fail  = 0;
foreach ( $pairs as $pair ) {
	list( $id, $date ) = array_pad( explode( ':', $pair ), 2, '' );
	$id = (int) $id;
	$p  = get_post( $id );
	if ( ! $p || ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) || $date > $today ) {
		echo "SKIP  $pair (bad id or date)\n"; $fail++; continue;
	}
	$local = ( $date === $today ) ? current_time( 'mysql' ) : "$date 12:00:00";
	if ( $p->post_modified >= $local ) {
		echo "KEEP  $id {$p->post_modified} (already at or after $local)\n"; continue;
	}
	if ( $apply ) {
		$wpdb->update( $wpdb->posts, [ 'post_modified' => $local, 'post_modified_gmt' => get_gmt_from_date( $local ) ], [ 'ID' => $id ] );
		clean_post_cache( $id );
		$back = $wpdb->get_var( $wpdb->prepare( "SELECT post_modified FROM {$wpdb->posts} WHERE ID = %d", $id ) );
		echo ( $back === $local ? 'SET   ' : 'FAIL  ' ) . "$id {$p->post_modified} -> $back\n";
		if ( $back !== $local ) { $fail++; }
	} else {
		echo "WOULD $id {$p->post_modified} -> $local\n";
	}
}
if ( $fail ) { exit( 1 ); }
