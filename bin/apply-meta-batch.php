<?php
/**
 * Apply exact-match edits to post META fields: the keys bin/apply-linked-pages-batch.php
 * cannot write (e.g. _roden_meta_description, _roden_sol_sc, pillar intros, array elements).
 * Edits are embedded (base64 JSON: [{id, post, key, sub, from, to}]) by bin/build-meta-batch.py,
 * because this script is piped to `wp eval-file -`. `sub` is null or [index, field] for an
 * array meta's element. Generalised 2026-09-30 from bin/fix-pillar-meta-2026-09-30.php.
 *
 * Every edit is checked (exact match, once) before any write; wp_slash; read back.
 *
 *   python3 bin/build-meta-batch.py data/facts/<batch>.json > run.php
 *   ssh $H "wp --path=$P eval-file - [apply]" < run.php > docs/backups/<batch>.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$edits = array();
foreach ( json_decode( base64_decode( '__EDITS__' ), true ) as $e ) {
	$edits[] = array( $e['id'], (int) $e['post'], $e['key'], $e['sub'], $e['from'], $e['to'] );
}
if ( ! $edits ) { fwrite( STDERR, "ABORT: no edits embedded.\n" ); exit( 1 ); }

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
