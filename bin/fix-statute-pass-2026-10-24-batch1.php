<?php
/**
 * Statute pass 2026-10-24, batch 1: citation corrections and removals only.
 * Source: data/facts/statute-pass-2026-10-24.md. Owner, 2026-10-24: "yes to 1, 2 and 3".
 *
 * Only edits that move a citation to the right section, or remove an
 * unsupported specific, are here. Anything that rewrites what a rule says
 * (E1-E31, E34-E37, E39, E45, E47-E49, E51-E56, E57a) is in the attorney packet.
 *
 *   E32  4360 body   wrongful-death deadline cited to § 51-4-5 -> § 9-3-33
 *   E33  1823 body   wrongful-death deadline cited to § 9-3-71 -> § 9-3-33
 *   E38  1718 KT     "requires expert testimony" -> tests expert testimony for reliability (§ 24-7-702(b))
 *   E40  4087 FAQ    § 40-6-294 -> § 40-6-291 (cyclists' rights and duties)
 *   E41  4171 body   same, link and text
 *   E42  4172 body   same, link and text
 *   E43  4172 FAQ    same (the SC cite is left for Gillin)
 *   E44  4173 body   same, link and text
 *   E46  4178 body   same, link and text
 *   E50  4170 body   § 31-8-1 (indigent hospital care) -> § 31-7-1 (institutions), link and text
 *   E57b 4120 body   § 4-8-20 -> § 4-8-21 (classification)
 *   E58  1722 body   "SB 83, effective July 1, 2024" -> the history line: offers on or after April 22, 2024
 *
 * Pass 1 plans every edit on a working copy per (post, field) and aborts before
 * any write if a needle does not match exactly once. Pass 2 writes each field
 * once: post_content via wp_update_post( wp_slash() ), meta via
 * update_post_meta( wp_slash() ), then reads back. _roden_content_modified is
 * set on each changed post; _roden_last_reviewed is not.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-statute-pass-2026-10-24-batch1.php > docs/backups/statute-pass-2026-10-24-batch1.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];

$j291 = 'https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/part-1/section-40-6-291/';
$j294 = 'https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/part-1/section-40-6-294/';

// array( id, post, field, from, to ). field: content | faqs | kt
$edits = array(
	array( 'E32', 4360, 'content', ' and 2 years for wrongful death claims (O.C.G.A. § 51-4-5)', ' and 2 years from the date of death for wrongful death claims (O.C.G.A. § 9-3-33)' ),
	array( 'E33', 1823, 'content', 'the deadline is also 2 years from the date of death (O.C.G.A. § 9-3-71).', 'the deadline is also 2 years from the date of death (O.C.G.A. § 9-3-33).' ),
	array( 'E38', 1718, 'kt', 'Georgia requires expert testimony under O.C.G.A. § 24-7-702.', 'Georgia tests expert testimony for reliability under O.C.G.A. § 24-7-702.' ),
	array( 'E40', 4087, 'faqs', 'Georgia law (O.C.G.A. § 40-6-294)', 'Georgia law (O.C.G.A. § 40-6-291)' ),
	array( 'E41a', 4171, 'content', $j294, $j291 ),
	array( 'E41b', 4171, 'content', 'O.C.G.A. § 40-6-294</a>', 'O.C.G.A. § 40-6-291</a>' ),
	array( 'E42a', 4172, 'content', $j294, $j291 ),
	array( 'E42b', 4172, 'content', 'O.C.G.A. § 40-6-294</a>', 'O.C.G.A. § 40-6-291</a>' ),
	array( 'E43', 4172, 'faqs', 'Georgia (O.C.G.A. § 40-6-294)', 'Georgia (O.C.G.A. § 40-6-291)' ),
	array( 'E44a', 4173, 'content', $j294, $j291 ),
	array( 'E44b', 4173, 'content', 'O.C.G.A. § 40-6-294</a>', 'O.C.G.A. § 40-6-291</a>' ),
	array( 'E46a', 4178, 'content', $j294, $j291 ),
	array( 'E46b', 4178, 'content', 'O.C.G.A. § 40-6-294</a>', 'O.C.G.A. § 40-6-291</a>' ),
	array( 'E50a', 4170, 'content', 'https://law.justia.com/codes/georgia/title-31/chapter-8/"', 'https://law.justia.com/codes/georgia/title-31/chapter-7/"' ),
	array( 'E50b', 4170, 'content', 'O.C.G.A. § 31-8-1 et seq.</a>', 'O.C.G.A. § 31-7-1 et seq.</a>' ),
	array( 'E57b', 4120, 'content', 'classified as dangerous under O.C.G.A. § 4-8-20 or local ordinances', 'classified as dangerous under O.C.G.A. § 4-8-21 or local ordinances' ),
	array( 'E58', 1722, 'content', '(as amended by SB 83, effective July 1, 2024)', '(as amended in 2024, for offers made on or after April 22, 2024)' ),
);

$keys = array( 'faqs' => '_roden_faqs', 'kt' => '_roden_key_takeaways' );
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
