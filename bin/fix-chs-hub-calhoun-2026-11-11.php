<?php
/**
 * Charleston office hubs: the office location sentence.
 *
 * /locations/south-carolina/charleston/ _roden_faqs[1] and
 * /es/locations/south-carolina/charleston/ _roden_faqs[5] put 127 King Street
 * "near the intersection of King and Calhoun streets". King and Calhoun is
 * about a mile north. The office sits between Broad and Queen streets: that is
 * the GBP pin (ChIJkx4ENNF7_ogRd1O08AhaJSw, 32.7771,-79.9330) and the wording
 * the English hub's own directions already use. Found in the 2026-11-11 GBP
 * audit of the Charleston profile. Not a legal claim; no pack authority needed.
 *
 *   C1 EN _roden_faqs[1]  "...near the intersection of King and Calhoun streets."
 *   C2 ES _roden_faqs[5]  "...cerca del cruce de las calles King y Calhoun."
 *
 * NOT APPLIED. Owner approval required before running with `apply`.
 * Each needle must match exactly once, in the named FAQ only, or the script
 * aborts before writing anything. Posts are resolved by path and the resolved
 * ID's permalink path is checked. Exact-match str_replace, wp_slash on every
 * write, read-back. Sets _roden_content_modified, not _roden_last_reviewed.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-chs-hub-calhoun-2026-11-11.php > docs/backups/chs-hub-calhoun-2026-11-11.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];

$edits = array(
	array( 'id' => 'C1', 'path' => '/locations/south-carolina/charleston/', 'faq' => 1,
		'from' => 'in the heart of downtown near the intersection of King and Calhoun streets.',
		'to'   => 'in the heart of downtown, between Broad and Queen streets.' ),
	array( 'id' => 'C2', 'path' => '/es/locations/south-carolina/charleston/', 'faq' => 5,
		'from' => 'en pleno centro, cerca del cruce de las calles King y Calhoun.',
		'to'   => 'en pleno centro, entre las calles Broad y Queen.' ),
);

$faqs = array();
foreach ( $edits as $k => $e ) {
	$p = url_to_postid( home_url( $e['path'] ) );
	if ( ! $p || wp_parse_url( get_permalink( $p ), PHP_URL_PATH ) !== $e['path'] ) {
		fwrite( STDERR, "ABORT {$e['id']}: {$e['path']} did not resolve to a post with that permalink (got " . (int) $p . ")\n" );
		exit( 1 );
	}
	$edits[ $k ]['post'] = $p;
	if ( ! isset( $faqs[ $p ] ) ) {
		$faqs[ $p ] = get_post_meta( $p, '_roden_faqs', true );
		if ( ! is_array( $faqs[ $p ] ) ) {
			fwrite( STDERR, "ABORT: $p has no _roden_faqs array\n" );
			exit( 1 );
		}
	}
}
$before_faqs = $faqs;

// Validate every needle against the untouched data before changing anything.
foreach ( $edits as $e ) {
	$p    = $e['post'];
	$hits = array();
	foreach ( $before_faqs[ $p ] as $i => $f ) {
		$n = substr_count( (string) $f['answer'], $e['from'] ) + substr_count( (string) $f['question'], $e['from'] );
		if ( $n ) {
			$hits[ 'faq' . $i ] = $n;
		}
	}
	$nc = substr_count( (string) get_post_field( 'post_content', $p, 'raw' ), $e['from'] );
	if ( $nc ) {
		$hits['content'] = $nc;
	}
	$want = array( 'faq' . $e['faq'] => 1 );
	if ( $want !== $hits ) {
		fwrite( STDERR, "ABORT {$e['id']}: needle matched " . wp_json_encode( $hits ) . ' (expected ' . wp_json_encode( $want ) . ")\n" );
		exit( 1 );
	}
}

foreach ( $edits as $e ) {
	$p = $e['post'];
	$faqs[ $p ][ $e['faq'] ]['answer'] = str_replace( $e['from'], $e['to'], $faqs[ $p ][ $e['faq'] ]['answer'] );
	fwrite( STDERR, ( $apply ? 'fixing ' : 'would fix ' ) . "{$e['id']} $p _roden_faqs[{$e['faq']}]\n  - {$e['from']}\n  + {$e['to']}\n" );
}

$out = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'before' => array(), 'after' => array() );
foreach ( array_keys( $faqs ) as $p ) {
	$out['before'][ $p ] = array( '_roden_faqs' => $before_faqs[ $p ] );
	$out['after'][ $p ]  = array( '_roden_faqs' => $faqs[ $p ] );
}

if ( $apply ) {
	foreach ( array_keys( $faqs ) as $p ) {
		update_post_meta( $p, '_roden_faqs', wp_slash( $faqs[ $p ] ) );
		update_post_meta( $p, '_roden_content_modified', wp_slash( gmdate( 'Y-m-d H:i:s' ) ) );
		wp_cache_delete( $p, 'post_meta' );
		clean_post_cache( $p );
		if ( get_post_meta( $p, '_roden_faqs', true ) !== $faqs[ $p ] ) {
			fwrite( STDERR, "FAILED read-back $p\n" );
			exit( 1 );
		}
		fwrite( STDERR, "read-back OK $p\n" );
	}
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
