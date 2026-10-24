<?php
/**
 * Statute pass 2 (2026-10-24), batch 2: mechanical citation and verbatim-quote fixes.
 * Source: data/facts/statute-pass-2-2026-10-24.md. Owner, 2026-10-24: "yes to 1, 2 and 3".
 *
 * SC text checked against scstatehouse.gov (t56c005) on 2026-10-24: §§ 56-5-500, -3130,
 * -3140, -3150, -3160, -3190, -3230. Rule rewrites are in the attorney packet, not here.
 *
 *   F4a-c 4478 body  § 56-5-3150 "due care" heading/quotes -> § 56-5-3230, verbatim text
 *   F5-F8 4478 body  driver-duty bullets and sentence -> § 56-5-3230 (F6/F7 to the statute's words)
 *   F9-10 4478 FAQ   same (FAQPage schema)
 *   F11   4478 body  "§ 56-5-3140 — Crossing at Other Than Crosswalks" -> § 56-5-3150
 *   F12   4478 body  two pedestrian bullets -> § 56-5-3150(c) / (a); "in a marked crosswalk"
 *   F13   4478 body  § 56-5-3130(a) quote -> verbatim; "explicitly applies to" -> § 56-5-500 definition
 *   F14   4478 body  § 56-5-3130(b) quote -> verbatim
 *   F15   1856 body  § 56-5-3150 -> § 56-5-3130(b)
 *   F16   1856 body  § 56-5-3190 (white cane) -> § 56-5-3160 (citation only; wording to Gillin)
 *   F30   4227 FAQ   drop § 40-6-320 (EPAMDs, not scooters)
 *   F31   4229 body  drop the § 40-6-320 "e-scooter statute" clause
 *   F38   4190 body  drop § 40-6-330 as the source of the rules-of-the-road duty (no new GA cite; Love)
 *   F39   4190 FAQ   drop § 40-6-330
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-statute-pass-2-2026-10-24-batch2.php > docs/backups/statute-pass-2-2026-10-24-batch2.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];

$j320 = '(<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/part-2a/" target="_blank" rel="noopener">O.C.G.A. § 40-6-320</a>)';
$j330 = '(<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/" target="_blank" rel="noopener">O.C.G.A. § 40-6-330</a>)';

// array( id, post, field, from, to ). field: content | faqs | kt
$edits = array(
	array( 'F4a', 4478, 'content', '<h3>S.C. Code § 56-5-3150 — Drivers to Exercise Due Care</h3>', '<h3>S.C. Code § 56-5-3230 — Driver to Exercise Due Care</h3>' ),
	array( 'F4b', 4478, 'content', '"Notwithstanding the foregoing provisions of this article, every driver of a vehicle shall exercise due care to avoid colliding with any pedestrian upon any roadway."', '"Notwithstanding other provisions of any local ordinance, every driver of a vehicle shall exercise due care to avoid colliding with any pedestrian or any person propelling a human-powered vehicle and shall give an audible signal when necessary and shall exercise proper precaution upon observing any child or any obviously confused, incapacitated or intoxicated person."' ),
	array( 'F4c', 4478, 'content', 'give <strong>"warning by sounding the horn when necessary"</strong> and to <strong>"exercise proper precaution upon observing any child or any confused or incapacitated person upon a roadway."</strong>', 'give <strong>"an audible signal when necessary"</strong> and to <strong>"exercise proper precaution upon observing any child or any obviously confused, incapacitated or intoxicated person."</strong>' ),
	array( 'F5', 4478, 'content', 'regardless of who has the right of way (S.C. Code § 56-5-3150)</li>', 'regardless of who has the right of way (S.C. Code § 56-5-3230)</li>' ),
	array( 'F6', 4478, 'content', '<li><strong>Sound the horn</strong> when necessary to warn pedestrians of danger (S.C. Code § 56-5-3150)</li>', '<li><strong>Give an audible signal</strong> when necessary (S.C. Code § 56-5-3230)</li>' ),
	array( 'F7', 4478, 'content', '<li><strong>Exercise extra precaution</strong> when observing children or confused or incapacitated persons on the roadway (S.C. Code § 56-5-3150)</li>', '<li><strong>Exercise proper precaution</strong> upon observing any child or any obviously confused, incapacitated or intoxicated person (S.C. Code § 56-5-3230)</li>' ),
	array( 'F8', 4478, 'content', "the driver's duty to exercise due care under S.C. Code § 56-5-3150 remains in effect", "the driver's duty to exercise due care under S.C. Code § 56-5-3230 remains in effect" ),
	array( 'F9', 4478, 'faqs', 'Under S.C. Code § 56-5-3150, drivers must exercise due care to avoid colliding with any pedestrian on any roadway, regardless', 'Under S.C. Code § 56-5-3230, drivers must exercise due care to avoid colliding with any pedestrian, regardless' ),
	array( 'F10', 4478, 'faqs', 'S.C. Code § 56-5-3150 requires drivers to exercise proper precaution upon observing any child or any confused or incapacitated person on a roadway.', 'S.C. Code § 56-5-3230 requires drivers to exercise proper precaution upon observing any child or any obviously confused, incapacitated or intoxicated person.' ),
	array( 'F11', 4478, 'content', '<h3>S.C. Code § 56-5-3140 — Crossing at Other Than Crosswalks</h3>', '<h3>S.C. Code § 56-5-3150 — Crossing at Other Than Crosswalks</h3>' ),
	array( 'F12a', 4478, 'content', 'pedestrians must cross at a crosswalk (S.C. Code § 56-5-3140)</li>', 'pedestrians must cross in a marked crosswalk (S.C. Code § 56-5-3150(c))</li>' ),
	array( 'F12b', 4478, 'content', 'must yield the right of way to traffic (S.C. Code § 56-5-3140)</li>', 'must yield the right of way to traffic (S.C. Code § 56-5-3150(a))</li>' ),
	array( 'F13a', 4478, 'content', '<strong>"the driver of a vehicle shall yield the right of way, slowing down or stopping if need be to so yield, to a pedestrian crossing the roadway within any marked crosswalk or within any unmarked crosswalk at an intersection."</strong>', '<strong>"When traffic-control signals are not in place or not in operation the driver of a vehicle shall yield the right-of-way, slowing down or stopping if need be to yield to a pedestrian crossing the roadway within a crosswalk when the pedestrian is upon the half of the roadway upon which the vehicle is traveling or when the pedestrian is approaching so closely from the opposite half of the roadway as to be in danger."</strong>' ),
	array( 'F13b', 4478, 'content', 'S.C. Code § 56-5-3130 explicitly applies to "any unmarked crosswalk at an intersection," giving', 'S.C. Code § 56-5-3130 applies within a crosswalk, and South Carolina defines a crosswalk to include the unmarked one at an intersection (S.C. Code § 56-5-500), giving' ),
	array( 'F14', 4478, 'content', 'which is so close that it is impossible for the driver to yield."', 'which is so close as to constitute an immediate hazard."' ),
	array( 'F15', 1856, 'content', 'Pedestrian responsibilities (S.C. Code § 56-5-3150):', 'Pedestrian responsibilities (S.C. Code § 56-5-3130(b)):' ),
	array( 'F16', 1856, 'content', 'Walking on highways (S.C. Code § 56-5-3190):', 'Walking on highways (S.C. Code § 56-5-3160):' ),
	array( 'F30', 4227, 'faqs', 'in violation of Georgia law (O.C.G.A. § 40-6-320) or local ordinances can be held liable', 'in violation of local ordinances, or carelessly, can be held liable' ),
	array( 'F31', 4229, 'content', " that apply equally to e-scooter riders under the state's e-scooter statute $j320", '' ),
	array( 'F38', 4190, 'content', "Georgia's golf cart statute $j330 subjects golf cart operators to the same traffic laws", 'Golf cart operators on Georgia streets are subject to the same traffic laws' ),
	array( 'F39', 4190, 'faqs', 'under Georgia (O.C.G.A. § 40-6-330) and South Carolina law', 'under Georgia and South Carolina law' ),
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
