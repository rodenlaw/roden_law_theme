<?php
/**
 * Restore the original publish date on posts that were redated in place.
 *
 *   ssh $H "wp --path=... eval-file -"       < bin/restore-original-publish-dates.php
 *   ssh $H "wp --path=... eval-file - apply" < bin/restore-original-publish-dates.php
 *
 * WHAT HAPPENED. Between 2026-03-17 and 2026-04-09, 81 published blog posts
 * written 2018–2023 had their local `post_date` moved to a spring-2026 date.
 * `post_date_gmt` was left alone, and so was `_wp_old_date`, which WordPress
 * writes when a date changes. This site's timezone offset is 0, so the two
 * columns should be identical. No revision predates September 2026, no plugin
 * or repo script does it, so it was a direct database write.
 *
 * WHY IT MATTERS. `get_the_date()` reads the local column, so the visible
 * byline, `datePublished` and `article:published_time` said a 2020 post was
 * first published in March 2026. The theme's `dateModified` falls back to the
 * GMT column (roden_content_modified_ts), so on the 18 posts with no editorial
 * date it published a dateModified EARLIER than datePublished, which is how the
 * 2026-10 schema review found it. The other 63 make the same false
 * first-published claim. A later review or refresh date only hides it.
 *
 * WHICH POSTS. Only those whose `post_date` differs from `post_date_gmt`. At
 * offset 0 that never happens through WordPress, so it is the signature of the
 * write. `_wp_old_date` is NOT a signal by itself: editors legitimately
 * reschedule drafts by a day or two (post 2388: 2024-01-31 -> 2024-02-02), and
 * WordPress records that too.
 *
 * WHAT IT SETS. `post_date_gmt`, which is the original. The one exception is a
 * post whose GMT column was moved into the redate window as well (2026-03-17 to
 * 2026-04-09). There the oldest `_wp_old_date` before the window is used: post
 * 1653's GMT reads 2026-03-17, but `_wp_old_date` kept 2023-06-14. The time of
 * day comes from `post_date_gmt`. Both columns get the same value, because the
 * offset is 0. A post split by hours on its real publish day (4534, 4581) just
 * gets its columns made consistent.
 *
 * Updates since then are not lost. They publish through dateModified from
 * `_roden_last_reviewed`, `_roden_last_refreshed` and `_roden_content_modified`.
 *
 * HOW IT WRITES. `$wpdb->update` on post_date and post_date_gmt only. It does
 * not run wp_update_post, so it fires no save hooks, leaves post_modified alone,
 * writes no `_wp_old_date` and creates no revision. `$wpdb->update` does not
 * unslash, so the CLAUDE.md wp_slash gotcha cannot apply. Permalinks are
 * /blog/%postname%/, so no URL changes. Every before value is printed as
 * BACKUP-JSON.
 *
 * Owner decision: Brian, 2026-10-22 (restore, don't re-stamp).
 */

global $wpdb;

$apply = isset( $args[0] ) && 'apply' === $args[0];
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (pass 'apply' to write) ===\n\n";

$offset = (float) get_option( 'gmt_offset' );
$tz     = (string) get_option( 'timezone_string' );
if ( 0.0 !== $offset || '' !== $tz ) {
	// The single-value write below assumes local == GMT. Refuse otherwise.
	printf( "Site timezone is '%s' / offset %s, not UTC. Refusing to run.\n", $tz, $offset );
	return;
}

$rows = $wpdb->get_results(
	"SELECT ID, post_type, post_name, post_date, post_date_gmt FROM {$wpdb->posts}
	 WHERE post_status = 'publish'
	   AND post_type IN ('post','page','resource','practice_area','location')
	   AND post_date_gmt <> '0000-00-00 00:00:00'"
);

$fix = array();
foreach ( $rows as $r ) {
	$id  = (int) $r->ID;
	$gmt = $r->post_date_gmt;
	if ( $r->post_date === $gmt ) {
		continue; // consistent: not touched by the write
	}
	$earliest = $gmt;
	$gmt_day  = substr( $gmt, 0, 10 );
	if ( $gmt_day >= '2026-03-17' && $gmt_day <= '2026-04-09' ) {
		foreach ( get_post_meta( $id, '_wp_old_date' ) as $old ) {
			$old = substr( trim( (string) $old ), 0, 10 );
			if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $old ) && $old < '2026-03-17' && $old < substr( $earliest, 0, 10 ) ) {
				$earliest = $old . substr( $gmt, 10 ); // keep the GMT time of day
			}
		}
	}
	if ( $earliest > $r->post_date ) {
		// The shown date is the earlier one. Not this pattern; report, don't touch.
		printf( "  skip [%d] shown %s is earlier than recorded %s\n", $id, $r->post_date, $earliest );
		continue;
	}
	$shown_mod = roden_content_modified_iso( $id );
	$fix[ $id ] = array(
		'type'          => $r->post_type,
		'url'           => get_permalink( $id ),
		'post_date'     => $r->post_date,
		'post_date_gmt' => $gmt,
		'target'        => $earliest,
		'flagged'       => ( $shown_mod && strtotime( $shown_mod ) < strtotime( $r->post_date . ' UTC' ) ),
	);
}

$flagged = count( array_filter( wp_list_pluck( $fix, 'flagged' ) ) );
printf( "published rows scanned                   : %d\n", count( $rows ) );
printf( "post_date differs from post_date_gmt     : %d\n", count( $fix ) );
printf( "  of which dateModified < datePublished  : %d (the schema-review finding)\n\n", $flagged );

foreach ( $fix as $id => $f ) {
	printf(
		"  [%d] %-8s %s -> %s%s  %s\n",
		$id,
		$f['type'],
		$f['post_date'],
		$f['target'],
		$f['flagged'] ? ' *' : '  ',
		wp_make_link_relative( $f['url'] )
	);
}
echo "\n  * = currently publishes dateModified earlier than datePublished\n";

if ( ! $fix ) {
	echo "\nNothing to restore.\n";
	return;
}
if ( ! $apply ) {
	echo "\nDry run. Re-run with 'apply' to restore.\n";
	return;
}

$backups = array();
foreach ( $fix as $id => $f ) {
	$backups[ $id ] = array( 'post_date' => $f['post_date'], 'post_date_gmt' => $f['post_date_gmt'] );
	$ok = $wpdb->update(
		$wpdb->posts,
		array( 'post_date' => $f['target'], 'post_date_gmt' => $f['target'] ),
		array( 'ID' => $id ),
		array( '%s', '%s' ),
		array( '%d' )
	);
	clean_post_cache( $id );
	printf( "  set %d: %s -> %s %s\n", $id, $f['post_date'], $f['target'], false === $ok ? 'FAILED' : 'ok' );
}

echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\n";

echo "\n--- VERIFY (read back from the table, not the object cache) ---\n";
$bad = 0;
foreach ( $fix as $id => $f ) {
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT post_date, post_date_gmt FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	$good = ( $row->post_date === $f['target'] && $row->post_date_gmt === $f['target'] );
	if ( ! $good ) {
		$bad++;
		printf( "  [%d] STILL WRONG: %s / %s\n", $id, $row->post_date, $row->post_date_gmt );
	}
}
printf( "%d of %d restored; %d wrong.\nDone.\n", count( $fix ) - $bad, count( $fix ), $bad );
