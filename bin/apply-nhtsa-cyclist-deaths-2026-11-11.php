<?php
/**
 * NHTSA cyclist / pedestrian death figures, 2026-11-11.
 *
 * Source: NHTSA FARS Encyclopedia, National Statistics
 * (https://www-fars.nhtsa.dot.gov/Main/index.aspx, read 2026-11-11):
 *   Pedalcyclists 2021 976 · 2022 1,117 · 2023 1,173 · 2024 1,103
 *   Pedestrians   2022 7,593 · 2023 7,367 · 2024 7,080
 * Registry: data/statistics.json us-pedalcyclist-deaths-2024, us-pedestrian-deaths-2024.
 *
 * Replaces three stale claims (one year with its vintage, no trend claim; FARS
 * reclassified motorized bicycles in 2022):
 *   4087 _roden_common_injuries, "Wrongful Death" description (rendered, esc_html):
 *        "The NHTSA reports nearly 1,000 cyclist fatalities annually."
 *   4087 post_content (stored, NOT rendered on the pillar while _roden_why_hire is set):
 *        "nearly 1,000 bicyclists ... annually, and tens of thousands more are seriously
 *        injured" — the injury clause had no source and is dropped.
 *   4106 post_content (rendered): "over 7,500 pedestrians and nearly 1,000 cyclists ...
 *        each year ..., and these numbers have been rising steadily" — both counts fell
 *        in 2023 and 2024, so "rising steadily" is dropped.
 * The source link moves to the FARS page the figures come from.
 *
 * Exact-match-once, idempotent, prior value backed up before each write, wp_slash.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/apply-nhtsa-cyclist-deaths-2026-11-11.php
 *   ssh $H "wp --path=$P eval-file - apply" < bin/apply-nhtsa-cyclist-deaths-2026-11-11.php
 * then: wp cache flush && wp page-cache flush; re-export content/meta.json.
 */
if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run through wp eval-file.\n" ); exit( 1 ); }
$mode = isset( $args[0] ) ? $args[0] : 'dry-run';

$fars = '<a href="https://www-fars.nhtsa.dot.gov/Main/index.aspx" target="_blank" rel="noopener">NHTSA\'s Fatality Analysis Reporting System</a>';

$content_edits = array(
	4087 => array( 'bicycle-accident-lawyers',
		'The <a href="https://www.nhtsa.gov/road-safety/bicycle-safety" target="_blank" rel="noopener">NHTSA</a> reports that nearly 1,000 bicyclists are killed in traffic crashes annually, and tens of thousands more are seriously injured.',
		$fars . ' counted 1,103 cyclists killed in US traffic crashes in 2024.' ),
	4106 => array( 'pedestrian-cyclist-fatality',
		'The <a href="https://www.nhtsa.gov/road-safety/pedestrian-safety" target="_blank" rel="noopener">NHTSA</a> reports that over 7,500 pedestrians and nearly 1,000 cyclists are killed in traffic crashes each year in the United States, and these numbers have been rising steadily.',
		'In 2024, ' . $fars . ' counted 7,080 pedestrians and 1,103 cyclists killed in US traffic crashes.' ),
);
$inj_find = 'The NHTSA reports nearly 1,000 cyclist fatalities annually.';
$inj_repl = "NHTSA's Fatality Analysis Reporting System counted 1,103 cyclists killed in US traffic crashes in 2024.";

$dir  = WP_CONTENT_DIR . '/uploads/roden-backups/nhtsa-cyclist-deaths-2026-11-11';
$fail = 0;
$backup = function ( $name, $value ) use ( $dir ) {
	if ( ! is_dir( $dir ) && ! wp_mkdir_p( $dir ) ) { return false; }
	$f = "$dir/$name";
	return file_exists( $f ) || false !== file_put_contents( $f, is_string( $value ) ? $value : wp_json_encode( $value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) );
};

foreach ( $content_edits as $id => $e ) {
	list( $slug, $find, $repl ) = $e;
	$p = get_post( $id );
	if ( ! $p || $p->post_name !== $slug || 'publish' !== $p->post_status ) { echo "FAIL $id: missing, slug mismatch or not published\n"; $fail++; continue; }
	$n = substr_count( $p->post_content, $find );
	if ( 0 === $n && false !== strpos( $p->post_content, $repl ) ) { echo "OK   $id content already updated\n"; continue; }
	if ( 1 !== $n ) { echo "FAIL $id content: found $n times\n"; $fail++; continue; }
	echo ( 'apply' === $mode ? 'EDIT ' : 'WOULD' ) . " $id content\n      -  " . wp_strip_all_tags( $find ) . "\n      +  " . wp_strip_all_tags( $repl ) . "\n";
	if ( 'apply' !== $mode ) { continue; }
	$new = str_replace( $find, $repl, $p->post_content );
	if ( ! $backup( "$id-content.txt", $p->post_content ) ) { echo "FAIL backup $id\n"; $fail++; continue; }
	$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $new ) ), true );
	if ( is_wp_error( $r ) || get_post( $id )->post_content !== $new ) { echo "FAIL $id content write/read-back\n"; $fail++; }
	clean_post_cache( $id );
}

// 4087 _roden_common_injuries: an array of { name, description }.
$inj = get_post_meta( 4087, '_roden_common_injuries', true );
if ( ! is_array( $inj ) ) {
	echo 'FAIL 4087 _roden_common_injuries: expected an array, got ' . gettype( $inj ) . "\n"; $fail++;
} else {
	$hits = 0; $done = 0; $new = $inj;
	foreach ( $new as $i => $row ) {
		$desc = isset( $row['description'] ) ? (string) $row['description'] : '';
		$hits += substr_count( $desc, $inj_find );
		if ( false !== strpos( $desc, $inj_repl ) ) { $done++; }
		$new[ $i ]['description'] = str_replace( $inj_find, $inj_repl, $desc );
	}
	if ( 0 === $hits && $done ) {
		echo "OK   4087 _roden_common_injuries already updated\n";
	} elseif ( 1 !== $hits ) {
		echo "FAIL 4087 _roden_common_injuries: found $hits times\n"; $fail++;
	} else {
		echo ( 'apply' === $mode ? 'EDIT ' : 'WOULD' ) . " 4087 _roden_common_injuries (Wrongful Death)\n      -  $inj_find\n      +  $inj_repl\n";
		if ( 'apply' === $mode ) {
			if ( ! $backup( '4087-roden_common_injuries.json', $inj ) ) { echo "FAIL backup 4087 injuries\n"; $fail++; }
			else {
				update_post_meta( 4087, '_roden_common_injuries', wp_slash( $new ) );
				if ( get_post_meta( 4087, '_roden_common_injuries', true ) !== $new ) { echo "FAIL 4087 injuries read-back\n"; $fail++; }
				clean_post_cache( 4087 );
			}
		}
	}
}
if ( 'apply' === $mode ) { echo "backups: $dir\n"; }
echo ( $fail ? "DONE with $fail failure(s)\n" : "DONE clean\n" );
exit( $fail ? 1 : 0 );
