<?php
/**
 * Spanish Myrtle Beach office hub (4872): interim immigration wording, 2026-11-11.
 *
 * Owner, 2026-11-11: "apply the interim changes to Myrtle Beach spanish pages".
 * Same finding as N3 on 4883 (data/facts/remediation-2026-11-11-es-location-drafts.md):
 * "su estatus migratorio no le impide reclamar una compensación ... o una lesión en el
 * trabajo" has no pack authority (Gillin's question N3 is open) and the English twin
 * makes no such claim. Interim wording makes no legal claim. Only the published hub
 * is touched; the seven ES Myrtle Beach practice pages carrying similar lines are
 * retired drafts (2026-09-18) and do not render.
 * The SC comparative-fault "51%" FAQ on this page is handled by the separate 51% batch.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-es-myrtle-beach-hub-immigration-2026-11-11.php
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-es-myrtle-beach-hub-immigration-2026-11-11.php
 * then: wp cache flush && wp page-cache flush.
 */
if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run through wp eval-file.\n" ); exit( 1 ); }
$apply = isset( $args[0] ) && 'apply' === $args[0];
$id    = 4872;
$fail  = 0;
$p = get_post( $id );
if ( ! $p || 'es-myrtle-beach' !== $p->post_name || 'publish' !== $p->post_status ) { echo "FAIL $id: not the published ES Myrtle Beach hub\n"; exit( 1 ); }

function roden_mb_swap( $text, $find, $repl, $label, &$fail ) {
	$n = substr_count( $text, $find );
	if ( 0 === $n && false !== strpos( $text, $repl ) ) { echo "OK    $label already applied\n"; return $text; }
	if ( 1 !== $n ) { echo "FAIL  $label: anchor found $n times\n"; $fail++; return $text; }
	echo "SWAP  $label\n      -  $find\n      +  $repl\n";
	return str_replace( $find, $repl, $text );
}
$content = roden_mb_swap( $p->post_content,
	'y su estatus migratorio no le impide reclamar una compensación por sus lesiones — su consulta es siempre confidencial.',
	'y atendemos a todas las personas sin importar su estatus migratorio: su consulta es siempre confidencial.',
	'body', $fail );
$faqs_orig = get_post_meta( $id, '_roden_faqs', true );
$faqs      = $faqs_orig;
if ( ! is_array( $faqs ) || ! isset( $faqs[1] ) ) { echo "FAIL faqs shape\n"; exit( 1 ); }
$faqs[1]['question'] = roden_mb_swap( $faqs[1]['question'],
	'¿Puedo reclamar compensación si no tengo papeles?',
	'¿Puedo consultarles si no tengo papeles?',
	'FAQ[1] question', $fail );
$faqs[1]['answer'] = roden_mb_swap( $faqs[1]['answer'],
	'Sí. Su estatus migratorio no le impide reclamar una compensación por un accidente o una lesión en el trabajo en Carolina del Sur. Su información se mantiene confidencial.',
	'Sí, puede consultarnos. Atendemos a todas las personas sin importar su estatus migratorio, y lo que nos cuente es confidencial.',
	'FAQ[1] answer', $fail );

if ( $fail ) { echo "DONE with $fail failure(s); nothing written\n"; exit( 1 ); }
if ( ! $apply ) { echo "DONE clean (dry run)\n"; exit( 0 ); }
if ( $content === $p->post_content && $faqs === $faqs_orig ) { echo "DONE clean (nothing to do)\n"; exit( 0 ); }

$dir = WP_CONTENT_DIR . '/uploads/roden-backups/es-mb-hub-immigration-2026-11-11';
$bk  = "$dir/$id-before.json";
if ( ( ! is_dir( $dir ) && ! wp_mkdir_p( $dir ) ) || ( ! file_exists( $bk ) && false === file_put_contents( $bk, wp_json_encode( array( 'post_content' => $p->post_content, '_roden_faqs' => $faqs_orig ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) ) ) ) {
	echo "FAIL backup\n"; exit( 1 );
}
update_post_meta( $id, '_roden_faqs', wp_slash( $faqs ) );
$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $content ) ), true );
if ( is_wp_error( $r ) ) { echo 'FAIL wp_update_post: ' . $r->get_error_message() . "\n"; exit( 1 ); }
clean_post_cache( $id );
$ok = get_post_field( 'post_content', $id ) === $content && get_post_meta( $id, '_roden_faqs', true ) === $faqs;
echo ( $ok ? 'OK   read-back' : 'FAIL read-back' ) . "\nbackup: $bk\n" . ( $ok ? "DONE clean\n" : "DONE with failure\n" );
exit( $ok ? 0 : 1 );
