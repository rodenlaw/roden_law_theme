<?php
/**
 * Follow-ups to the SC comparative-fault batches (#345, #349), 2026-11-11.
 *
 * Owner, 2026-11-11: "do the three follow-ups".
 *   A. Featured-image alt text and attachment title on 6344 (5352), 6363 (4811) and
 *      6364 (4930) still carried the pre-retitle post titles ("51% Bar"). Set both to
 *      the posts' current titles.
 *   B. Draft 4366: Georgia's comparative-fault rule cited to "O.C.G.A. 9-3-33" (the
 *      limitations statute) -> "O.C.G.A. § 51-12-33". The page's second 9-3-33 cite
 *      (the 2-year SOL) is correct and untouched. Status stays draft.
 * Exact-match once, idempotent, backups, wp_slash, read-back.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-sc51-followups-2026-11-11.php
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-sc51-followups-2026-11-11.php
 */
if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run through wp eval-file.\n" ); exit( 1 ); }
$apply = isset( $args[0] ) && 'apply' === $args[0];
$fail  = 0;
$plan  = array();

foreach ( array( 6344 => 5352, 6363 => 4811, 6364 => 4930 ) as $att => $parent ) {
	$a = get_post( $att );
	if ( ! $a || 'attachment' !== $a->post_type || (int) get_post_thumbnail_id( $parent ) !== $att ) { echo "FAIL $att: not the featured image of $parent\n"; $fail++; continue; }
	$want = get_post_field( 'post_title', $parent );
	if ( false !== strpos( $want, '51%' ) ) { echo "FAIL $parent title still says 51%\n"; $fail++; continue; }
	$alt = (string) get_post_meta( $att, '_wp_attachment_image_alt', true );
	if ( $alt === $want && $a->post_title === $want ) { echo "OK    $att already applied\n"; continue; }
	if ( false === strpos( $alt . $a->post_title, '51%' ) ) { echo "FAIL $att: alt/title changed since review, skipped\n"; $fail++; continue; }
	echo "WOULD $att alt+title\n      -  $alt\n      +  $want\n";
	$plan[] = array( 'att', $att, $want, array( 'alt' => $alt, 'title' => $a->post_title ) );
}

$find = 'Under O.C.G.A. 9-3-33, an injured person can recover only if their fault is <strong>less than 50%';
$repl = 'Under O.C.G.A. § 51-12-33, an injured person can recover only if their fault is <strong>less than 50%';
$p = get_post( 4366 );
if ( ! $p || 'draft' !== $p->post_status ) { echo "FAIL 4366 missing or not a draft\n"; $fail++; }
else {
	$n = substr_count( $p->post_content, $find );
	if ( 0 === $n && false !== strpos( $p->post_content, $repl ) ) echo "OK    4366 already applied\n";
	elseif ( 1 !== $n ) { echo "FAIL 4366 anchor x$n\n"; $fail++; }
	else { echo "WOULD 4366 [draft] content\n      -  $find\n      +  $repl\n"; $plan[] = array( 'post', 4366, str_replace( $find, $repl, $p->post_content ), $p->post_content ); }
}

if ( $fail ) { echo "DONE with $fail failure(s); nothing written\n"; exit( 1 ); }
if ( ! $apply || ! $plan ) { echo 'DONE clean' . ( $apply ? '' : ' (dry run)' ) . "\n"; exit( 0 ); }

$dir = WP_CONTENT_DIR . '/uploads/roden-backups/sc51-followups-2026-11-11';
if ( ! is_dir( $dir ) && ! wp_mkdir_p( $dir ) ) { echo "FAIL backup dir\n"; exit( 1 ); }
if ( ! file_exists( "$dir/before.json" ) && false === file_put_contents( "$dir/before.json", wp_json_encode( $plan, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) ) ) { echo "FAIL backup\n"; exit( 1 ); }
foreach ( $plan as $s ) {
	if ( 'att' === $s[0] ) {
		update_post_meta( $s[1], '_wp_attachment_image_alt', wp_slash( $s[2] ) );
		$r = wp_update_post( wp_slash( array( 'ID' => $s[1], 'post_title' => $s[2] ) ), true );
		$ok = ! is_wp_error( $r ) && get_post_meta( $s[1], '_wp_attachment_image_alt', true ) === $s[2] && get_post_field( 'post_title', $s[1] ) === $s[2];
	} else {
		$r = wp_update_post( wp_slash( array( 'ID' => $s[1], 'post_content' => $s[2], 'post_status' => 'draft' ) ), true );
		$ok = ! is_wp_error( $r ) && get_post_field( 'post_content', $s[1] ) === $s[2] && 'draft' === get_post_status( $s[1] );
	}
	clean_post_cache( $s[1] );
	echo ( $ok ? 'OK   ' : 'FAIL ' ) . "read-back {$s[1]}\n"; if ( ! $ok ) $fail++;
}
echo "backup: $dir/before.json\n" . ( $fail ? "DONE with $fail failure(s)\n" : "DONE clean\n" );
exit( $fail ? 1 : 0 );
