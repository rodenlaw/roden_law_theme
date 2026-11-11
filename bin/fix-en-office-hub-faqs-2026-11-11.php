<?php
/**
 * Live English office hubs 3598 (/locations/georgia/darien/) and 3763
 * (/locations/south-carolina/north-charleston/): four sentence replacements
 * found while reviewing their retired Spanish twins. Plan:
 * data/facts/remediation-2026-11-11-es-location-drafts.md, items E1-E4.
 * The 2026-11-10 sweep reported 0 findings on both pages (engine phrasing gaps).
 *
 *   E1 3598 _roden_faqs[3]  GA med-mal "discovery rule" (ga-medmal-discovery-rule
 *                           class). Interim wording: removes the false claim and
 *                           adds no GA claim (GA pack unsigned for Roden).
 *   E2 3763 _roden_faqs[2]  SC government claims as "notice periods"
 *                           (sctca-mandatory-notice class). Authority SC 15-78-110,
 *                           signed (Gillin).
 *   E3 3763 _roden_faqs[3]  "less than 51%" / "51% or more" -> Nelson house
 *                           wording. Authority Nelson v. Concrete Supply Co., signed.
 *   E4 3763 post_content    Charleston office phone on the North Charleston hub.
 *
 * NOT APPLIED. Owner approval required before running with `apply`.
 * Each needle must match exactly once, in the named surface only, or the
 * script aborts before writing anything. Exact-match str_replace, wp_slash on
 * every write, read-back. Sets _roden_content_modified, not _roden_last_reviewed.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-en-office-hub-faqs-2026-11-11.php > docs/backups/en-office-hub-faqs-2026-11-11.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];

$edits = array(
	array( 'id' => 'E1', 'post' => 3598, 'faq' => 3,
		'from' => 'Medical malpractice cases follow a discovery rule but have a 5-year outer limit.',
		'to'   => 'Medical malpractice cases have their own, different deadlines.' ),
	array( 'id' => 'E2', 'post' => 3763, 'faq' => 2,
		'from' => 'Shorter notice periods apply if a government entity is involved (a city, county, or state agency).',
		'to'   => 'A claim against a government entity (a city, county, or state agency) has a shorter deadline, generally two years under the South Carolina Tort Claims Act (S.C. Code § 15-78-110).' ),
	array( 'id' => 'E3a', 'post' => 3763, 'faq' => 3,
		'from' => 'If you are less than 51% at fault for the accident, you can still recover compensation',
		'to'   => 'If you are 50% or less at fault for the accident, you can still recover compensation' ),
	array( 'id' => 'E3b', 'post' => 3763, 'faq' => 3,
		'from' => 'If you are 51% or more at fault, you recover nothing.',
		'to'   => 'If you are more than 50% at fault, you recover nothing.' ),
	array( 'id' => 'E4', 'post' => 3763, 'faq' => null,
		'from' => 'Contact us at (843) 790-8999 for a free case review.',
		'to'   => 'Contact us at (843) 612-6561 for a free case review.' ),
);

$faqs    = array();
$content = array();
foreach ( $edits as $e ) {
	$p = $e['post'];
	if ( ! isset( $faqs[ $p ] ) ) {
		$faqs[ $p ]    = get_post_meta( $p, '_roden_faqs', true );
		$content[ $p ] = get_post_field( 'post_content', $p, 'raw' );
		if ( ! is_array( $faqs[ $p ] ) ) {
			fwrite( STDERR, "ABORT: $p has no _roden_faqs array\n" );
			exit( 1 );
		}
	}
}
$before_faqs    = $faqs;
$before_content = $content;

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
	$nc = substr_count( (string) $before_content[ $p ], $e['from'] );
	if ( $nc ) {
		$hits['content'] = $nc;
	}
	$want = null === $e['faq'] ? array( 'content' => 1 ) : array( 'faq' . $e['faq'] => 1 );
	if ( $want !== $hits ) {
		fwrite( STDERR, "ABORT {$e['id']}: needle matched " . wp_json_encode( $hits ) . ' (expected ' . wp_json_encode( $want ) . ")\n" );
		exit( 1 );
	}
}

foreach ( $edits as $e ) {
	$p = $e['post'];
	if ( null === $e['faq'] ) {
		$content[ $p ] = str_replace( $e['from'], $e['to'], $content[ $p ] );
	} else {
		$faqs[ $p ][ $e['faq'] ]['answer'] = str_replace( $e['from'], $e['to'], $faqs[ $p ][ $e['faq'] ]['answer'] );
	}
	fwrite( STDERR, ( $apply ? 'fixing ' : 'would fix ' ) . "{$e['id']} $p " . ( null === $e['faq'] ? 'post_content' : "_roden_faqs[{$e['faq']}]" ) . "\n  - {$e['from']}\n  + {$e['to']}\n" );
}

$out = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'before' => array(), 'after' => array() );
foreach ( array_keys( $faqs ) as $p ) {
	$out['before'][ $p ] = array( '_roden_faqs' => $before_faqs[ $p ], 'post_content' => $before_content[ $p ] );
	$out['after'][ $p ]  = array( '_roden_faqs' => $faqs[ $p ], 'post_content' => $content[ $p ] );
}

if ( $apply ) {
	foreach ( array_keys( $faqs ) as $p ) {
		if ( $faqs[ $p ] !== $before_faqs[ $p ] ) {
			update_post_meta( $p, '_roden_faqs', wp_slash( $faqs[ $p ] ) );
		}
		if ( $content[ $p ] !== $before_content[ $p ] ) {
			$r = wp_update_post( wp_slash( array( 'ID' => $p, 'post_content' => $content[ $p ] ) ), true );
			if ( is_wp_error( $r ) ) {
				fwrite( STDERR, "FAILED wp_update_post $p: " . $r->get_error_message() . "\n" );
				exit( 1 );
			}
		}
		update_post_meta( $p, '_roden_content_modified', wp_slash( gmdate( 'Y-m-d H:i:s' ) ) );
		wp_cache_delete( $p, 'post_meta' );
		clean_post_cache( $p );
		if ( get_post_meta( $p, '_roden_faqs', true ) !== $faqs[ $p ] || get_post_field( 'post_content', $p, 'raw' ) !== $content[ $p ] ) {
			fwrite( STDERR, "FAILED read-back $p\n" );
			exit( 1 );
		}
		fwrite( STDERR, "read-back OK $p\n" );
	}
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
