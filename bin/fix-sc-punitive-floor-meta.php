<?php
/**
 * The two unindexed SC punitive-floor statements bin/fix-sc-punitive-floor.php
 * could not reach, because the sweep never reported them (2026-09-26):
 *
 * - Pillar 3608 (medical malpractice), FAQ 5. The sweep's `unless` matched
 *   "adjusted annually for inflation" elsewhere in the same answer (said of the
 *   § 15-32-220 med-mal cap), so it treated the punitive sentence as indexed.
 * - Post 1663, glossary term "Punitive damages" (_roden_glossary_terms, also
 *   published as DefinedTerm structured data). Its Georgia half gains "in most
 *   cases", the approved Georgia wording, since § 51-12-5.1(e)–(f) lift the cap.
 *
 * Same approved correction as the batch: "$739,245, the 2026 inflation-indexed
 * figure". Exact-match, once each, update_post_meta( wp_slash() ), read back.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-sc-punitive-floor-meta.php > docs/backups/sc-punitive-floor-meta-2026-09-26.json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-sc-punitive-floor-meta.php > docs/backups/sc-punitive-floor-meta-2026-09-26.json
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply = isset( $args[0] ) && 'apply' === $args[0];

$fixes = array(
	array( 3608, '_roden_faqs', 5, 'answer',
		'limited to the greater of $500,000 or three times compensatory damages (S.C. Code § 15-32-530).',
		'limited to the greater of $739,245, the 2026 inflation-indexed figure, or three times compensatory damages (S.C. Code § 15-32-530).' ),
	array( 1663, '_roden_glossary_terms', 1, 'definition',
		'Georgia caps punitive damages at $250,000 (O.C.G.A. § 51-12-5.1); South Carolina at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530).',
		'Georgia caps punitive damages at $250,000 in most cases (O.C.G.A. § 51-12-5.1); South Carolina at the greater of three times compensatory damages or $739,245, the 2026 inflation-indexed figure (S.C. Code § 15-32-530).' ),
);

$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'sc-punitive-floor-meta', 'mode' => $apply ? 'apply' : 'dry-run', 'items' => array() );

foreach ( $fixes as $f ) {
	list( $id, $key, $idx, $field, $from, $to ) = $f;
	$before = get_post_meta( $id, $key, true );
	if ( ! is_array( $before ) || ! isset( $before[ $idx ][ $field ] ) ) {
		fwrite( STDERR, "ABORT: {$id} {$key}[{$idx}][{$field}] not found.\n" );
		exit( 1 );
	}
	$n = substr_count( $before[ $idx ][ $field ], $from );
	if ( 1 !== $n ) {
		fwrite( STDERR, "ABORT: {$id} {$key}[{$idx}] contains the fragment {$n} times, expected 1.\n" );
		exit( 1 );
	}
	$after                    = $before;
	$after[ $idx ][ $field ]  = str_replace( $from, $to, $before[ $idx ][ $field ] );
	$backup['items'][]        = array( 'post_id' => $id, 'meta_key' => $key, 'before' => $before, 'after' => $after );
	fwrite( STDERR, sprintf( "  %s %d %s[%d]\n", $apply ? 'fixed' : 'would fix', $id, $key, $idx ) );
	if ( $apply ) {
		update_post_meta( $id, $key, wp_slash( $after ) );
		wp_cache_delete( $id, 'post_meta' );
		if ( get_post_meta( $id, $key, true ) !== $after ) {
			fwrite( STDERR, "FAILED: read-back mismatch on {$id} {$key}\n" );
			exit( 1 );
		}
		clean_post_cache( $id );
	}
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
