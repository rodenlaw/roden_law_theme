<?php
/**
 * 4087 (bicycle pillar), stored _roden_pillar_negligence_intro: drop the SC three-foot passing rule.
 * Found by the widened claims sweep (internal-ai-scripts #126, rule sc-three-foot-passing) and listed
 * as dormant in data/facts/statute-pass-3-2026-10-26.md. The theme does not render this field today.
 * Owner, 2026-10-26: "fix 4087". Same rule as G9: S.C. Code § 56-5-3435 requires a safe operating
 * distance and names no figure; O.C.G.A. § 40-6-56 is Georgia's three-foot minimum.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-4087-pillar-intro-three-foot.php > docs/backups/4087-pillar-intro-three-foot-2026-10-26.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];

// array( id, post, field, from, to ). field: content | faqs | kt | causes | pnintro
$edits = array(
	array( '4087-intro', 4087, 'pnintro', 'A **3-foot passing rule** applies to motorists overtaking cyclists ({{GA}}O.C.G.A. § 40-6-56{{/GA}}{{SC}}S.C. Code § 56-5-3435{{/SC}}), violation of which supports negligence per se.', 'Motorists overtaking cyclists must keep {{GA}}at least **3 feet** of clearance (O.C.G.A. § 40-6-56){{/GA}}{{SC}}a **safe operating distance** (S.C. Code § 56-5-3435){{/SC}}, violation of which supports negligence per se.' ),
);

$keys = array( 'faqs' => '_roden_faqs', 'kt' => '_roden_key_takeaways', 'causes' => '_roden_common_causes', 'pnintro' => '_roden_pillar_negligence_intro' );
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
