<?php
/**
 * Restore the publish date on the 6 redated posts whose original date survives
 * nowhere in the database, using the date the live site itself displayed at the time.
 *
 *   ssh $H "wp --path=... eval-file -"       < bin/restore-publish-dates-from-archive.php
 *   ssh $H "wp --path=... eval-file - apply" < bin/restore-publish-dates-from-archive.php
 *
 * Companion to bin/restore-original-publish-dates.php (88 posts, 2026-10-22).
 * These six had BOTH date columns moved to 2026-03-23 and no `_wp_old_date`,
 * so that script correctly left them alone.
 *
 * EVIDENCE. Each date is the one rodenlaw.com published for the post at the
 * time, read from the Internet Archive. The source is either the post's own
 * byline ("Posted on behalf of Roden Law Firm on <date>") or the dated entry
 * on a blog listing page. Each was cross-checked against two independent
 * bounds:
 *   - creation order: post IDs here are sequential, and the restored dates of
 *     the neighbouring IDs bracket each post to a window of a few weeks;
 *   - the archived sitemap.xml `lastmod`, a time the post verifiably existed.
 * Every date below falls inside both. Only the day is known, so the time is
 * set to 09:00:00, which is the site's convention and earlier than every lastmod.
 *
 * Writes post_date and post_date_gmt only, via $wpdb->update. That means no
 * hooks, no post_modified bump and no revision. The site offset is 0.
 * Owner: Brian, 2026-10-22.
 */

global $wpdb;

$apply = isset( $args[0] ) && 'apply' === $args[0];
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (pass 'apply' to write) ===\n\n";

if ( 0.0 !== (float) get_option( 'gmt_offset' ) || '' !== (string) get_option( 'timezone_string' ) ) {
	echo "Site timezone is not UTC. Refusing to run.\n";
	return;
}

// id => array( date, slug guard, evidence )
$map = array(
	1683 => array( '2022-06-23', 'what-is-the-role-of-a-personal-injury-lawyer-in-a-case', 'byline "June 23, 2022" (web.archive.org 20240518002546); IDs 1684/1682 = 2022-06-03/08-12; lastmod 2022-06-23T12:32' ),
	1714 => array( '2021-08-13', 'accident-claims-with-an-expired-license', '/blog/category/car-accident/ "August 13, 2021" (20211028045702); IDs 1715/1713 = 2021-08-06/08-25; lastmod 2021-08-17' ),
	1740 => array( '2020-05-21', 'traffic-tickets-and-car-accident-claims', 'byline "May 21, 2020" (20200923055435) and car-accident listing p.2 (20210918173310); IDs 1741/1739 = 2020-04-28/05-28' ),
	1758 => array( '2019-12-27', 'qualifications-for-car-accident-witnesses', 'car-accident listing p.3 "December 27, 2019" (20210918154535); IDs 1759/1757 = 2019-12-09/2020-01-03; lastmod 2019-12-31' ),
	1767 => array( '2019-10-14', 'drunk-pedestrian-injury-claims', 'car-accident listing p.3 "October 14, 2019" (20210918154535); IDs 1768/1766 = 2019-10-07/10-21; lastmod 2019-11-06' ),
	1813 => array( '2018-09-13', 'how-do-i-know-if-i-have-a-medical-malpractice-case', 'medical-malpractice listing "September 13, 2018" (20190716050536); IDs 1814/1812 = 2018-09-06/09-19; lastmod 2018-09-27' ),
);

$todo = array();
foreach ( $map as $id => $m ) {
	list( $day, $slug, $evidence ) = $m;
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT post_name, post_status, post_date, post_date_gmt FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	if ( ! $row || $row->post_name !== $slug ) {
		printf( "  [%d] SKIP: slug is %s, expected %s\n", $id, $row ? $row->post_name : '(missing)', $slug );
		continue;
	}
	$target = $day . ' 09:00:00';
	if ( $row->post_date === $target && $row->post_date_gmt === $target ) {
		printf( "  [%d] already %s\n", $id, $target );
		continue;
	}
	$todo[ $id ] = array( 'from' => $row->post_date, 'from_gmt' => $row->post_date_gmt, 'to' => $target );
	printf( "  [%d] %s -> %s  /blog/%s/\n       evidence: %s\n", $id, $row->post_date, $target, $slug, $evidence );
}

if ( ! $todo ) {
	echo "\nNothing to do.\n";
	return;
}
if ( ! $apply ) {
	echo "\nDry run. Re-run with 'apply' to write.\n";
	return;
}

$backups = array();
foreach ( $todo as $id => $t ) {
	$backups[ $id ] = array( 'post_date' => $t['from'], 'post_date_gmt' => $t['from_gmt'] );
	$wpdb->update( $wpdb->posts, array( 'post_date' => $t['to'], 'post_date_gmt' => $t['to'] ), array( 'ID' => $id ), array( '%s', '%s' ), array( '%d' ) );
	clean_post_cache( $id );
}
echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\n\n--- VERIFY (from the table) ---\n";
$bad = 0;
foreach ( $todo as $id => $t ) {
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT post_date, post_date_gmt FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	$ok  = ( $row->post_date === $t['to'] && $row->post_date_gmt === $t['to'] );
	$bad += $ok ? 0 : 1;
	printf( "  [%d] %s %s\n", $id, $row->post_date, $ok ? 'ok' : 'WRONG' );
}
printf( "%d of %d restored.\nDone.\n", count( $todo ) - $bad, count( $todo ) );
