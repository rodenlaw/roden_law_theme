<?php
/**
 * Fee FAQs on the car and truck accident pages (Local Dominator AI-visibility
 * finding "Clarify your contingency fee policy", 2026-10-02). Owner, 2026-10-02:
 * "do 1 now, then 2 and 3".
 *
 *  F-ADD-EN / F-ADD-ES  The truck pillars (3605, 4874) had no cost FAQ; the car
 *                       pillars do. Inserted after the case-value question.
 *  F-COST-*             The cost answers said "no fee unless we win" but not
 *                       costs, which is what "no upfront costs" prompts ask.
 *                       The added sentence is the footer disclosure's claim
 *                       ("Fees and costs apply only upon successful recovery.
 *                       No fees or costs with no recovery." / es_ES.po), not a
 *                       new one.
 *
 * Every edit is checked (exact match, once; insert anchor at the expected
 * index) before any write; wp_slash; read back.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-fee-faqs-2026-10-02.php > docs/backups/fee-faqs-2026-10-02.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];

$en_cost = ' Fees and costs are paid only from a recovery: if there is no recovery, you owe no fees and no costs.';
$office  = 'The consultation is free, and there is no fee unless we win your case.';

// array( id, post, from, to ) — exact replacement inside one FAQ answer.
$edits = array(
	array( 'F-COST-3604', 3604, 'Our fee is a percentage of the recovery we obtain for you.', 'Our fee is a percentage of the recovery we obtain for you.' . $en_cost ),
	array( 'F-COST-3624', 3624, $office, $office . $en_cost ),
	array( 'F-COST-3625', 3625, $office, $office . $en_cost ),
	array( 'F-COST-4540', 4540, $office, $office . $en_cost ),
	array( 'F-COST-3622', 3622, $office, $office . $en_cost ),
	array( 'F-COST-3629', 3629, $office, $office . $en_cost ),
	array( 'F-COST-3627', 3627, $office, $office . $en_cost ),
	array( 'F-COST-4873', 4873, 'Si no ganamos, no nos debe honorarios.', 'Sin recuperación, no nos debe honorarios ni costos.' ),
);

// array( id, post, anchor question (the FAQ to insert after), its index, new FAQ ).
$inserts = array(
	array( 'F-ADD-EN', 3605, 'How much is my truck accident case worth?', 5, array(
		'question' => 'How much does a truck accident lawyer cost?',
		'answer'   => 'Nothing up front. Roden Law handles truck accident cases on a contingency fee: our fee is a percentage of the recovery we obtain for you. The consultation is free, and fees and costs are paid only from a recovery: if there is no recovery, you owe no fees and no costs.',
	) ),
	array( 'F-ADD-ES', 4874, '¿Cuánto vale mi caso de accidente de camión?', 6, array(
		'question' => '¿Cuánto cuesta un abogado de accidentes de camión?',
		'answer'   => 'Nada por adelantado. Roden Law maneja los casos de accidentes de camión con honorarios de contingencia: nuestros honorarios son un porcentaje de lo que recuperemos para usted. La consulta es gratuita, y los honorarios y costos se pagan solo si hay una recuperación. Sin recuperación, no nos debe honorarios ni costos.',
	) ),
);

// Pass 1: plan every edit; abort before writing anything on a miss.
$plan = array();
$load = function ( $post ) use ( &$plan ) {
	if ( ! isset( $plan[ $post ] ) ) {
		$v = get_post_meta( $post, '_roden_faqs', true );
		if ( ! is_array( $v ) || ! $v ) {
			fwrite( STDERR, "ABORT: $post has no _roden_faqs array\n" );
			exit( 1 );
		}
		$plan[ $post ] = array( 'post' => $post, 'key' => '_roden_faqs', 'before' => $v, 'after' => $v, 'ids' => array() );
	}
};

foreach ( $edits as $e ) {
	list( $id, $post, $from, $to ) = $e;
	$load( $post );
	$hits = array();
	foreach ( $plan[ $post ]['after'] as $i => $f ) {
		$n = substr_count( (string) $f['answer'], $from );
		if ( $n ) {
			$hits[ $i ] = $n;
		}
	}
	if ( array( 1 ) !== array_values( $hits ) ) {
		fwrite( STDERR, "ABORT: $id ($post) matched " . wp_json_encode( $hits ) . "\n" );
		exit( 1 );
	}
	$i = key( $hits );
	$plan[ $post ]['after'][ $i ]['answer'] = str_replace( $from, $to, $plan[ $post ]['after'][ $i ]['answer'] );
	$plan[ $post ]['ids'][] = $id;
}

foreach ( $inserts as $e ) {
	list( $id, $post, $anchor, $at, $faq ) = $e;
	$load( $post );
	$faqs = $plan[ $post ]['after'];
	if ( ! isset( $faqs[ $at ] ) || $faqs[ $at ]['question'] !== $anchor ) {
		fwrite( STDERR, "ABORT: $id ($post) anchor not at index $at\n" );
		exit( 1 );
	}
	foreach ( $faqs as $f ) {
		if ( preg_match( '/cost|cuesta|honorario|contingen/iu', $f['question'] ) ) {
			fwrite( STDERR, "ABORT: $id ($post) already has a cost FAQ: {$f['question']}\n" );
			exit( 1 );
		}
	}
	array_splice( $faqs, $at + 1, 0, array( $faq ) );
	$plan[ $post ]['after'] = $faqs;
	$plan[ $post ]['ids'][] = $id;
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
fwrite( STDERR, sprintf( "\n%s: %d edits + %d inserts in %d fields\n", $apply ? 'Fixed' : 'Would fix', count( $edits ), count( $inserts ), count( $plan ) ) );
