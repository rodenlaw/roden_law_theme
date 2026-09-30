<?php
/**
 * The apply-class pillar meta-field fixes from the Spanish pillar sweep
 * (M-ES-WD1, M-ES-PI1, M-ES-PI2, M-EN-WD1; data/facts/remediation-2026-09-30-es-pillars.md),
 * which bin/apply-linked-pages-batch.php cannot write. Owner, 2026-09-30: "apply them".
 * Held: M-ES-PI3 / M-EN-PI1 (GA branch is Eric Roden's; the ES intro renderer's
 * {{GA}}/{{SC}} support is unconfirmed) and M-ES-PI4 (punitive conduct standard, attorney).
 *
 * Every edit is checked (exact match, once) before any write; wp_slash; read back.
 * An edit with a sub-key targets that field of an array meta's element.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-pillar-meta-2026-09-30.php > docs/backups/pillar-meta-2026-09-30.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$edits = array(
	array( 'M-ES-WD1', 4882, '_roden_why_hire', null, 'calculamos el valor completo de la vida de su ser querido — ingresos futuros, cuidado de los hijos, compañía —', 'calculamos todo lo que la ley permite reclamar por la pérdida de su ser querido — ingresos futuros, cuidado de los hijos, compañía y, en Georgia, el valor completo de su vida —' ), // GA 51-4-1, SC 15-51-40
	array( 'M-ES-PI1', 5200, '_roden_pillar_negligence_intro', null, 'y la negligencia médica exige una declaración jurada de un experto presentada junto con la demanda', 'y la negligencia médica exige desde el inicio la declaración jurada de un experto calificado' ), // SC 15-36-100, 15-79-125
	array( 'M-ES-PI2', 5200, '_roden_pillar_negligence_intro', null, 'y en Carolina del Sur si tuvo 51% o más', 'y en Carolina del Sur si tuvo más del 50%' ), // Nelson
	array( 'M-EN-WD1', 3609, '_roden_common_injuries', array( 0, 'description' ), '(O.C.G.A. § 51-4-2)', '(O.C.G.A. § 51-4-1)' ), // GA 51-4-1
);

// Pass 1: plan every edit; abort before writing anything on a miss.
$plan = array();
foreach ( $edits as $e ) {
	list( $id, $post, $key, $sub, $from, $to ) = $e;
	$ck = "$post|$key";
	if ( ! isset( $plan[ $ck ] ) ) {
		$v = get_post_meta( $post, $key, true );
		$plan[ $ck ] = array( 'post' => $post, 'key' => $key, 'before' => $v, 'after' => $v, 'ids' => array() );
	}
	$val  = $plan[ $ck ]['after'];
	$text = $sub ? ( isset( $val[ $sub[0] ][ $sub[1] ] ) ? (string) $val[ $sub[0] ][ $sub[1] ] : '' ) : (string) $val;
	$n    = substr_count( $text, $from );
	if ( 1 !== $n ) {
		fwrite( STDERR, "ABORT: $id ($post $key) found $n times\n" );
		exit( 1 );
	}
	$text = str_replace( $from, $to, $text );
	if ( $sub ) {
		$val[ $sub[0] ][ $sub[1] ] = $text;
	} else {
		$val = $text;
	}
	$plan[ $ck ]['after'] = $val;
	$plan[ $ck ]['ids'][] = $id;
}

$out = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'fields' => array() );
foreach ( $plan as $p ) {
	$out['fields'][] = $p;
	fwrite( STDERR, '  ' . ( $apply ? 'fixed' : 'would fix' ) . ' ' . implode( ', ', $p['ids'] ) . " ({$p['post']} {$p['key']})\n" );
	if ( ! $apply ) {
		continue;
	}
	update_post_meta( $p['post'], $p['key'], wp_slash( $p['after'] ) );
	wp_cache_delete( $p['post'], 'post_meta' );
	clean_post_cache( $p['post'] );
	if ( get_post_meta( $p['post'], $p['key'], true ) !== $p['after'] ) {
		fwrite( STDERR, "FAILED read-back {$p['post']} {$p['key']}\n" );
		exit( 1 );
	}
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fwrite( STDERR, sprintf( "\n%s: %d edits in %d fields\n", $apply ? 'Fixed' : 'Would fix', count( $edits ), count( $plan ) ) );
