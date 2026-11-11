<?php
/**
 * Un-retire the Spanish Darien office hub (4869), 2026-11-11.
 *
 * Owner, 2026-11-11: "override for Darien". The legal review
 * (data/facts/remediation-2026-11-11-es-location-drafts.md) held 4869 on D1/D2: its
 * 2-year SOL (O.C.G.A. § 9-3-33) and 50% bar (O.C.G.A. § 51-12-33) are correct
 * but rest on GA authority unsigned for Roden (law-signoff.json, Love's packet
 * items A1/A3). The owner overrode that hold for this page; the same two claims
 * are live on the English twin (3598). Love's sign-off stays open.
 *
 * Steps, all or nothing per run:
 *   1. 4869 text fixes, exact-match once: D3 interim (body + FAQ[1]: no legal claim
 *      about immigration status; FAQ[1] question reworded to match), D4 ("bien
 *      ubicada", geography not competence), D5 (cut the Spanish-only insurer line).
 *   2. delete _roden_retired; post_status draft -> publish. _roden_last_reviewed is
 *      left at 2026-08-03 on purpose (attorney items open; plan step 4).
 *   3. reverse the 2026-09-26 relink for Darien only: 4862 (/es/) and 4864
 *      (/es/locations/), href only, direct column write as the original.
 * Apply refuses while roden_dead_es_hub_urls() still maps the ES Darien URL.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/unretire-es-darien-2026-11-11.php
 *   ssh $H "wp --path=$P eval-file - apply" < bin/unretire-es-darien-2026-11-11.php
 * then: wp cache flush && wp page-cache flush; re-export content/meta.json.
 */
if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run through wp eval-file.\n" ); exit( 1 ); }
$apply  = isset( $args[0] ) && 'apply' === $args[0];
// Location freeze (inc/content-guardrails.php) demotes a new location publish to
// draft. Owner, 2026-11-11 ("do 1."): lift it for this one WP-CLI process only, in
// apply mode; RODEN_LOCATION_FREEZE in wp-config.php is never set. See RECOVERY-LOG.
if ( $apply ) { add_filter( 'roden_location_freeze_active', '__return_false' ); }
$id     = 4869;
$es_url = '/es/locations/georgia/darien/';
$fail   = 0;

$p = get_post( $id );
if ( ! $p || 'es-darien' !== $p->post_name || 'darien' !== get_post_meta( $id, '_roden_office_key', true ) ) {
	echo "FAIL $id: not the ES Darien hub\n"; exit( 1 );
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
	'y su estatus migratorio no le impide reclamar una compensación: su consulta es siempre confidencial.',
	'y atendemos a todas las personas sin importar su estatus migratorio: su consulta es siempre confidencial.',
	'D3 body', $fail );
$content = roden_unretire_swap( $content,
	'Con más de $300 millones recuperados para nuestros clientes, sabemos cómo hacer que las aseguradoras respondan.',
	'Hemos recuperado más de $300 millones para nuestros clientes.',
	'D5 body', $fail );
$local_orig = (string) get_post_meta( $id, '_roden_local_content', true );
$local      = $local_orig;
$faqs_orig = get_post_meta( $id, '_roden_faqs', true );
$faqs      = $faqs_orig;
if ( ! is_array( $faqs ) || count( $faqs ) !== 8 ) { echo "FAIL faqs shape\n"; exit( 1 ); }
$faqs[1]['question'] = roden_unretire_swap( $faqs[1]['question'],
	'¿Puedo reclamar compensación si no tengo papeles?',
	'¿Puedo consultarles si no tengo papeles?',
	'D3 FAQ[1] question', $fail );
$faqs[1]['answer'] = roden_unretire_swap( $faqs[1]['answer'],
	'Sí. Su estatus migratorio no le impide reclamar una compensación por lesiones en Georgia. Su información se mantiene confidencial durante todo el proceso.',
	'Sí, puede consultarnos. Atendemos a todas las personas sin importar su estatus migratorio, y lo que nos cuente está protegido por el secreto profesional entre abogado y cliente.',
	'D3 FAQ[1] answer', $fail );
$faqs[4]['answer'] = roden_unretire_swap( $faqs[4]['answer'],
	'la oficina de Darien está especialmente preparada para atender',
	'la oficina de Darien está bien ubicada para atender',
	'D4 FAQ[4]', $fail );

// 3. relink reversal
$en_a = '<a href="/locations/georgia/darien/">Darien</a>';
$es_a = '<a href="' . $es_url . '">Darien</a>';
$relink = array();
foreach ( array( 4862, 4864 ) as $rid ) {
	$c = get_post_field( 'post_content', $rid );
	$relink[ $rid ] = array( $c, roden_unretire_swap( $c, $en_a, $es_a, "relink $rid", $fail ) );
}

if ( $fail ) { echo "DONE with $fail failure(s); nothing written\n"; exit( 1 ); }
if ( ! $apply ) { echo "WOULD publish $id and delete _roden_retired\nDONE clean (dry run)\n"; exit( 0 ); }
if ( $redirect_live ) { echo "ABORT: $es_url is still in roden_dead_es_hub_urls(); deploy the theme change first. Nothing written.\n"; exit( 1 ); }

// backups
$dir = WP_CONTENT_DIR . '/uploads/roden-backups/unretire-es-darien-2026-11-11';
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
