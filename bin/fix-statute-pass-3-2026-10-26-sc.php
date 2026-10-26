<?php
/**
 * Statute pass 3 (2026-10-26), SC mechanical fixes G1, G2, G6, G9.
 * Source: data/facts/statute-pass-3-2026-10-26.md. Owner, 2026-10-26: "apply G1 G2 G6 G9".
 *
 * SC text checked against scstatehouse.gov on 2026-10-26: § 50-21-870 (t50c021), § 44-7-110
 * as amended by 2023 Act No. 20 (t44c007), § 56-5-3435 (t56c005). GA § 40-6-56 verified
 * 2026-09-03 (pass 3 of the tracker, #109).
 *
 *   G1  3616 FAQ     § 50-21-145 (former no-wake-zone section) -> § 50-21-870 (FAQPage schema)
 *   G2  4895 FAQ     same, Spanish twin
 *   G6  4164 body    Act name -> "State Health Facility Licensure Act" (2023 Act No. 20)
 *   G9  4087 causes  "violating 3-foot law" -> GA 3-foot minimum / SC safe operating distance
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-statute-pass-3-2026-10-26-sc.php > docs/backups/statute-pass-3-2026-10-26-sc.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];

// array( id, post, field, from, to ). field: content | faqs | kt | causes
$edits = array(
	array( 'G1', 3616, 'faqs', 'South Carolina has similar restrictions (S.C. Code § 50-21-145).', 'South Carolina has similar restrictions (S.C. Code § 50-21-870).' ),
	array( 'G2', 4895, 'faqs', 'Carolina del Sur tiene restricciones similares (S.C. Code § 50-21-145).', 'Carolina del Sur tiene restricciones similares (S.C. Code § 50-21-870).' ),
	array( 'G6', 4164, 'content', '(State Certification of Need and Health Facility Licensure Act)', '(State Health Facility Licensure Act)' ),
	array( 'G9', 4087, 'causes', 'Drivers passing too closely (violating 3-foot law)', "Drivers passing too closely (inside Georgia's 3-foot minimum, or without a safe operating distance in South Carolina)" ),
);

$keys = array( 'faqs' => '_roden_faqs', 'kt' => '_roden_key_takeaways', 'causes' => '_roden_common_causes' );
$plan = array();
foreach ( $edits as $e ) {
	list( $id, $post, $field, $from, $to ) = $e;
	$k = "$post:$field";
	if ( ! isset( $plan[ $k ] ) ) {
		if ( 'content' === $field ) {
			$p = get_post( $post );
			$v = $p ? $p->post_content : null;
		} else {
			$v = get_post_meta( $post, $keys[ $field ], true );
		}
		if ( null === $v || '' === $v || false === $v ) {
			fwrite( STDERR, "ABORT: $id $post has no $field\n" );
			exit( 1 );
		}
		$plan[ $k ] = array( 'post' => $post, 'field' => $field, 'before' => $v, 'after' => $v, 'ids' => array() );
	}
	$cur = &$plan[ $k ]['after'];
	if ( 'faqs' === $field ) {
		$hits = array();
		foreach ( $cur as $i => $f ) {
			$n = substr_count( (string) $f['answer'], $from );
			if ( $n ) {
				$hits[ $i ] = $n;
			}
		}
		if ( array( 1 ) !== array_values( $hits ) ) {
			fwrite( STDERR, "ABORT: $id ($post faqs) matched " . wp_json_encode( $hits ) . "\n" );
			exit( 1 );
		}
		$i = key( $hits );
		$cur[ $i ]['answer'] = str_replace( $from, $to, $cur[ $i ]['answer'] );
	} elseif ( 'causes' === $field ) {
		$hits = array_keys( $cur, $from, true );
		if ( 1 !== count( $hits ) ) {
			fwrite( STDERR, "ABORT: $id ($post causes) matched " . count( $hits ) . " items\n" );
			exit( 1 );
		}
		$cur[ $hits[0] ] = $to;
	} else {
		$n = substr_count( $cur, $from );
		if ( 1 !== $n ) {
			fwrite( STDERR, "ABORT: $id ($post $field) matched $n times\n" );
			exit( 1 );
		}
		$cur = str_replace( $from, $to, $cur );
	}
	unset( $cur );
	$plan[ $k ]['ids'][] = $id;
}

$out   = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'fields' => array_values( $plan ) );
$posts = array();
foreach ( $plan as $p ) {
	fwrite( STDERR, sprintf( "  %s %d %s: %s\n", $apply ? 'fixing' : 'would fix', $p['post'], $p['field'], implode( ', ', $p['ids'] ) ) );
	if ( ! $apply ) {
		continue;
	}
	if ( 'content' === $p['field'] ) {
		$r = wp_update_post( wp_slash( array( 'ID' => $p['post'], 'post_content' => $p['after'] ) ), true );
		if ( is_wp_error( $r ) ) {
			fwrite( STDERR, "FAILED write {$p['post']} content: " . $r->get_error_message() . "\n" );
			exit( 1 );
		}
		clean_post_cache( $p['post'] );
		$back = get_post( $p['post'] )->post_content;
	} else {
		update_post_meta( $p['post'], $keys[ $p['field'] ], wp_slash( $p['after'] ) );
		wp_cache_delete( $p['post'], 'post_meta' );
		$back = get_post_meta( $p['post'], $keys[ $p['field'] ], true );
	}
	if ( $back !== $p['after'] ) {
		fwrite( STDERR, "FAILED read-back {$p['post']} {$p['field']}\n" );
		exit( 1 );
	}
	$posts[ $p['post'] ] = true;
}
if ( $apply ) {
	foreach ( array_keys( $posts ) as $post ) {
		update_post_meta( $post, '_roden_content_modified', wp_slash( gmdate( 'Y-m-d H:i:s' ) ) );
	}
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fwrite( STDERR, sprintf( "\n%s: %d edits in %d fields on %d posts\n", $apply ? 'Fixed' : 'Would fix', count( $edits ), count( $plan ), count( array_unique( array_column( $plan, 'post' ) ) ) ) );
