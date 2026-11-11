<?php
/**
 * Un-retire the Spanish North Charleston office hub (4883), 2026-11-11.
 *
 * Owner, 2026-11-11: "publish the spanish pages". Legal review:
 * data/facts/remediation-2026-11-11-es-location-drafts.md (4883: publishable after
 * N1, N2 and the N3 interim wording; N4 cut). 4869 es-darien is NOT in this script
 * (blocked on GA sign-off for Roden).
 *
 * Steps, all or nothing per run:
 *   1. 4883 text fixes, exact-match once: N1 (FAQ[2] SCTCA deadline, not notice),
 *      N2 (FAQ[5] "50% o menos", Nelson), N3 interim (body + FAQ[1]: no legal claim
 *      about immigration status; FAQ[1] question reworded to match), N4 (local
 *      content: no "Park Circle").
 *   2. delete _roden_retired; post_status draft -> publish. _roden_last_reviewed is
 *      left at 2026-08-03 on purpose (attorney items open; plan step 4).
 *   3. reverse the 2026-09-26 relink for North Charleston only: 4862 (/es/) and
 *      4864 (/es/locations/), href only, direct column write as the original
 *      (docs/backups/dead-es-hub-relink-2026-09-26.json).
 * Apply refuses while roden_dead_es_hub_urls() still maps the ES North Charleston
 * URL: deploy the theme PR that removes it first, or the page stays unreachable.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/unretire-es-north-charleston-2026-11-11.php
 *   ssh $H "wp --path=$P eval-file - apply" < bin/unretire-es-north-charleston-2026-11-11.php
 * then: wp cache flush && wp page-cache flush; re-export content/meta.json.
 */
if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run through wp eval-file.\n" ); exit( 1 ); }
$apply  = isset( $args[0] ) && 'apply' === $args[0];
$id     = 4883;
$es_url = '/es/locations/south-carolina/north-charleston/';
$fail   = 0;

$p = get_post( $id );
if ( ! $p || 'es-north-charleston' !== $p->post_name || 'north-charleston' !== get_post_meta( $id, '_roden_office_key', true ) ) {
	echo "FAIL $id: not the ES North Charleston hub\n"; exit( 1 );
}
$redirect_live = function_exists( 'roden_dead_es_hub_urls' ) && isset( roden_dead_es_hub_urls()[ $es_url ] );
echo "status={$p->post_status} retired=" . get_post_meta( $id, '_roden_retired', true ) . ' redirect=' . ( $redirect_live ? 'LIVE' : 'removed' ) . "\n";

function roden_unretire_swap( $text, $find, $repl, $label, &$fail ) {
	$n = substr_count( $text, $find );
	if ( 0 === $n && false !== strpos( $text, $repl ) ) { echo "OK    $label already applied\n"; return $text; }
	if ( 1 !== $n ) { echo "FAIL  $label: anchor found $n times\n"; $fail++; return $text; }
	echo "WOULD $label\n      -  $find\n      +  $repl\n";
	return str_replace( $find, $repl, $text );
}

// 1. text fixes
$content = roden_unretire_swap( $p->post_content,
	'y su estatus migratorio no le impide reclamar una compensación por sus lesiones — su consulta es siempre confidencial.',
	'y atendemos a todas las personas sin importar su estatus migratorio: su consulta es siempre confidencial.',
	'N3 body', $fail );
$local_orig = (string) get_post_meta( $id, '_roden_local_content', true );
$local = roden_unretire_swap( $local_orig,
	'Nuestra oficina está en Spruill Avenue, en la zona de Park Circle, con estacionamiento',
	'Nuestra oficina está en 2703 Spruill Avenue, con estacionamiento',
	'N4 local', $fail );
$faqs_orig = get_post_meta( $id, '_roden_faqs', true );
$faqs      = $faqs_orig;
if ( ! is_array( $faqs ) || count( $faqs ) !== 6 ) { echo "FAIL faqs shape\n"; exit( 1 ); }
$faqs[1]['question'] = roden_unretire_swap( $faqs[1]['question'],
	'¿Puedo reclamar compensación si no tengo papeles?',
	'¿Puedo consultarles si no tengo papeles?',
	'N3 FAQ[1] question', $fail );
$faqs[1]['answer'] = roden_unretire_swap( $faqs[1]['answer'],
	'Sí. Su estatus migratorio no le impide reclamar una compensación por un accidente o una lesión en el trabajo en Carolina del Sur. Su información se mantiene confidencial.',
	'Sí, puede consultarnos. Atendemos a todas las personas sin importar su estatus migratorio, y lo que nos cuente es confidencial.',
	'N3 FAQ[1] answer', $fail );
$faqs[2]['answer'] = roden_unretire_swap( $faqs[2]['answer'],
	'En casos contra entidades del gobierno los plazos de notificación son más cortos, así que no espere para llamar.',
	'Los reclamos contra entidades del gobierno tienen un plazo más corto, por lo general 2 años (S.C. Code § 15-78-110), así que no espere para llamar.',
	'N1 FAQ[2]', $fail );
$faqs[5]['answer'] = roden_unretire_swap( $faqs[5]['answer'],
	'Si usted tiene menos del 51% de la culpa del accidente, todavía puede recibir una compensación',
	'Si su culpa en el accidente es del 50% o menos, todavía puede recibir una compensación',
	'N2a FAQ[5]', $fail );
$faqs[5]['answer'] = roden_unretire_swap( $faqs[5]['answer'],
	'Si su culpa es del 51% o más, no recupera nada.',
	'Si su culpa es de más del 50%, no recupera nada.',
	'N2b FAQ[5]', $fail );

// 3. relink reversal
$en_a = '<a href="/locations/south-carolina/north-charleston/">North Charleston</a>';
$es_a = '<a href="' . $es_url . '">North Charleston</a>';
$relink = array();
foreach ( array( 4862, 4864 ) as $rid ) {
	$c = get_post_field( 'post_content', $rid );
	$relink[ $rid ] = array( $c, roden_unretire_swap( $c, $en_a, $es_a, "relink $rid", $fail ) );
}

if ( $fail ) { echo "DONE with $fail failure(s); nothing written\n"; exit( 1 ); }
if ( ! $apply ) { echo "WOULD publish $id and delete _roden_retired\nDONE clean (dry run)\n"; exit( 0 ); }
if ( $redirect_live ) { echo "ABORT: $es_url is still in roden_dead_es_hub_urls(); deploy the theme change first. Nothing written.\n"; exit( 1 ); }

// backups
$dir = WP_CONTENT_DIR . '/uploads/roden-backups/unretire-es-north-charleston-2026-11-11';
if ( ! is_dir( $dir ) && ! wp_mkdir_p( $dir ) ) { echo "FAIL backup dir\n"; exit( 1 ); }
$bk = "$dir/before.json";
if ( ! file_exists( $bk ) ) {
	$ok = file_put_contents( $bk, wp_json_encode( array(
		'4883' => array( 'post_status' => $p->post_status, 'post_content' => $p->post_content, '_roden_local_content' => $local_orig, '_roden_faqs' => $faqs_orig, '_roden_retired' => get_post_meta( $id, '_roden_retired', true ) ),
		'4862' => $relink[4862][0], '4864' => $relink[4864][0],
	), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) );
	if ( false === $ok ) { echo "FAIL backup write\n"; exit( 1 ); }
}

// write
update_post_meta( $id, '_roden_faqs', wp_slash( $faqs ) );
update_post_meta( $id, '_roden_local_content', wp_slash( $local ) );
delete_post_meta( $id, '_roden_retired' );
$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $content, 'post_status' => 'publish' ) ), true );
if ( is_wp_error( $r ) ) { echo 'FAIL wp_update_post: ' . $r->get_error_message() . "\n"; exit( 1 ); }
global $wpdb;
foreach ( $relink as $rid => $pair ) {
	if ( $pair[0] !== $pair[1] ) { $wpdb->update( $wpdb->posts, array( 'post_content' => $pair[1] ), array( 'ID' => $rid ) ); clean_post_cache( $rid ); }
}
clean_post_cache( $id );

// read-back
$q = get_post( $id );
$chk = array(
	'published'   => 'publish' === $q->post_status,
	'unretired'   => '' === get_post_meta( $id, '_roden_retired', true ),
	'content'     => $q->post_content === $content,
	'local'       => get_post_meta( $id, '_roden_local_content', true ) === $local,
	'faqs'        => get_post_meta( $id, '_roden_faqs', true ) === $faqs,
	'relink 4862' => 1 === substr_count( get_post_field( 'post_content', 4862 ), $es_a ),
	'relink 4864' => 1 === substr_count( get_post_field( 'post_content', 4864 ), $es_a ),
);
foreach ( $chk as $k => $v ) { echo ( $v ? 'OK   ' : 'FAIL ' ) . "read-back $k\n"; if ( ! $v ) $fail++; }
echo 'permalink: ' . get_permalink( $id ) . "\nbackup: $bk\n";
echo $fail ? "DONE with $fail failure(s)\n" : "DONE clean\n";
exit( $fail ? 1 : 0 );
