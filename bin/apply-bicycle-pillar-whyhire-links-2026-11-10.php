<?php
/**
 * Bicycle pillar (4087) why-hire links, 2026-11-10 (follow-up to #326/#327).
 *
 * Why: the pillar template renders post_content only when _roden_why_hire is empty
 * (templates/template-practice-area.php:202-206), so the five body links that
 * bin/apply-bicycle-pillar-links-2026-11-10.php wrote into 4087 post_content never
 * reached the page. _roden_why_hire is the only rendered free-HTML field on the
 * pillar (causes and injuries are esc_html; FAQ answers also feed FAQPage JSON-LD).
 *
 * Changes (owner-approved, 2026-11-10), _roden_why_hire only:
 *   - paragraph 1: "a helmet" -> /resources/georgia-helmet-laws/
 *   - paragraph 3: adds "e-bike crashes" to the case list -> e-bike pillar, and one
 *     sentence linking UM/UIM -> the UM/UIM post and wrongful death -> the cyclist
 *     fatality page. Both claims are already on the page (the hero opener states
 *     UM/UIM; the injuries list states the wrongful-death claim). No statute cited.
 *
 * Exact-match-once, idempotent, prior value backed up before the write, wp_slash.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/apply-bicycle-pillar-whyhire-links-2026-11-10.php
 *   ssh $H "wp --path=$P eval-file - apply" < bin/apply-bicycle-pillar-whyhire-links-2026-11-10.php
 * then: wp cache flush && wp page-cache flush; re-export content/meta.json.
 */
if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run through wp eval-file.\n" ); exit( 1 ); }
$mode = isset( $args[0] ) ? $args[0] : 'dry-run';

$id    = 4087;
$key   = '_roden_why_hire';
$pairs = array(
	array( "weren't wearing a helmet, or were riding",
	       "weren't wearing <a href=\"/resources/georgia-helmet-laws/\">a helmet</a>, or were riding" ),
	array( 'intersection collisions, and road hazard crashes.',
	       'intersection collisions, road hazard crashes, and <a href="/practice-areas/e-bike-accident-lawyers/">e-bike crashes</a>. When the driver is uninsured, your own <a href="/blog/using-uninsured-underinsured-motorist-coverage-in-georgia/">uninsured-motorist coverage</a> may pay; when a crash is fatal, families can bring a <a href="/wrongful-death-lawyers/pedestrian-cyclist-fatality/">wrongful death claim</a>.' ),
);

$p = get_post( $id );
if ( ! $p || 'bicycle-accident-lawyers' !== $p->post_name || 'publish' !== $p->post_status ) {
	echo "FAIL $id: missing, slug mismatch or not published\n"; exit( 1 );
}
$fail = 0;
$orig = (string) get_post_meta( $id, $key, true );
$new  = $orig;
foreach ( $pairs as $pair ) {
	list( $find, $repl ) = $pair;
	$n = substr_count( $new, $find );
	if ( 0 === $n && false !== strpos( $new, $repl ) ) { echo "OK   $id $key already applied: " . wp_strip_all_tags( $repl ) . "\n"; continue; }
	if ( 1 !== $n ) { echo "FAIL $id $key: anchor found $n times, skipped: $find\n"; $fail++; continue; }
	$new = str_replace( $find, $repl, $new );
	echo ( 'apply' === $mode ? 'EDIT ' : 'WOULD' ) . " $id $key\n      -  $find\n      +  $repl\n";
}
if ( 'apply' === $mode && $new !== $orig && ! $fail ) {
	$dir = WP_CONTENT_DIR . '/uploads/roden-backups/bicycle-pillar-whyhire-links-2026-11-10';
	$f   = "$dir/$id-roden_why_hire.txt";
	if ( ( ! is_dir( $dir ) && ! wp_mkdir_p( $dir ) ) || ( ! file_exists( $f ) && false === file_put_contents( $f, $orig ) ) ) {
		echo "FAIL backup\n"; exit( 1 );
	}
	update_post_meta( $id, $key, wp_slash( $new ) );
	if ( (string) get_post_meta( $id, $key, true ) !== $new ) { echo "FAIL $id $key read-back\n"; $fail++; }
	clean_post_cache( $id );
	echo "backup: $f\n";
}
echo ( $fail ? "DONE with $fail failure(s)\n" : "DONE clean\n" );
exit( $fail ? 1 : 0 );
