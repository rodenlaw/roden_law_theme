<?php
/**
 * Backfill jurisdiction, statute and authorship meta on `location` posts.
 *
 * The 2026-08-19 GEO audit (F6) found location pages carry no attribution at
 * all: 0% `_roden_author_attorney`, 0% `_roden_jurisdiction`, 0% SOL meta,
 * against 100% authorship on practice_area and resource. 211 published pages —
 * the largest single block of unattributed content on the site.
 *
 * What this writes, and why each one is a claim the firm can stand behind:
 *
 *   _roden_jurisdiction   'GA' | 'SC' — derived from the page's own office
 *                         chain, not guessed from the URL.
 *   _roden_sol_ga/_sc     The controlling statute for that jurisdiction.
 *   _roden_author_attorney  The bar-admitted attorney responsible for that
 *                         state's content. Matches existing firm practice:
 *                         Gillin is already the byline on 202 SC practice-area
 *                         pages, Roden on the Georgia side.
 *
 * What this deliberately does NOT write:
 *
 *   _roden_last_reviewed  The audit plan called for setting this to the run
 *                         date. It must not be. That field means "an attorney
 *                         last checked this page on this date", and it is what
 *                         licenses `reviewedBy` in schema
 *                         (inc/schema-helpers.php, roden_schema_review_fields).
 *                         Stamping today across 200+ pages nobody read would
 *                         publish a professional review that did not happen —
 *                         the exact trust signal that function's docblock
 *                         refuses to manufacture. It stays empty until someone
 *                         actually reviews the page.
 *
 * Never overwrites a non-empty existing value: it reports and skips, so a
 * hand-set attribution always wins over this script.
 *
 * Run from the repo over stdin — never added to the theme:
 *   ssh $H "wp --path=$P eval-file -"        < bin/backfill-location-attribution.php
 *   ssh $H "wp --path=$P eval-file - apply"  < bin/backfill-location-attribution.php
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ── Expected attribution, verified before anything is written ───────────── */

$expect = array(
	'SC' => array(
		'name' => 'Graeham C. Gillin',
		'sol'  => array( '_roden_sol_sc' => 'S.C. Code § 15-3-530' ),
	),
	'GA' => array(
		'name' => 'Eric Roden',
		'sol'  => array( '_roden_sol_ga' => 'O.C.G.A. § 9-3-33' ),
	),
);

foreach ( $expect as $state => $spec ) {
	$found = get_posts(
		array(
			'post_type'      => 'attorney',
			'post_status'    => 'publish',
			'title'          => $spec['name'],
			'numberposts'    => 1,
			'suppress_filters' => false,
		)
	);
	if ( ! $found ) {
		printf( "ABORT  no published attorney post titled \"%s\" for %s\n", $spec['name'], $state );
		exit( 1 );
	}
	$expect[ $state ]['id'] = (int) $found[0]->ID;
	printf( "attribution  %s -> #%d %s\n", $state, $expect[ $state ]['id'], $found[0]->post_title );
}

/* ── Resolve each location post's state from its own office chain ───────── */

$firm = roden_firm_data();

/**
 * Walk a location post up to whichever ancestor carries an office key.
 * Mirrors the ancestor walk in templates/single-location-neighborhood.php.
 */
function roden_bf_state_for( $post_id, $firm ) {
	// The two state landing pages carry no office key by design — they are the
	// whole state, not one market. single-location.php renders them from an
	// inline branch keyed on post_name. Resolve them explicitly so they are
	// attributed like every other page rather than silently skipped.
	$name = get_post_field( 'post_name', $post_id );
	$name = preg_replace( '/^es-/', '', (string) $name );
	if ( 'georgia' === $name ) {
		return array( 'GA', '', 'state landing' );
	}
	if ( 'south-carolina' === $name ) {
		return array( 'SC', '', 'state landing' );
	}

	$id = $post_id;
	for ( $i = 0; $i < 6 && $id; $i++ ) {
		foreach ( array( '_roden_parent_office_key', '_roden_office_key' ) as $key ) {
			$ok = get_post_meta( $id, $key, true );
			if ( $ok && isset( $firm['offices'][ $ok ] ) ) {
				return array( $firm['offices'][ $ok ]['state'], $ok, $key );
			}
		}
		$id = wp_get_post_parent_id( $id );
	}
	return array( '', '', '' );
}

$locations = get_posts(
	array(
		'post_type'        => 'location',
		'post_status'      => array( 'publish', 'draft' ),
		'numberposts'      => -1,
		'suppress_filters' => false,
	)
);

printf( "\n%s  %d location posts\n\n", $apply ? 'APPLY' : 'DRY RUN', count( $locations ) );

$counts  = array( 'written' => 0, 'already' => 0, 'skipped' => 0, 'conflict' => 0 );
$per_state = array();
$unresolved = array();

foreach ( $locations as $loc ) {
	list( $state, $office_key, $via ) = roden_bf_state_for( $loc->ID, $firm );

	if ( ! $state || ! isset( $expect[ $state ] ) ) {
		$unresolved[] = sprintf( '#%d %s (%s)', $loc->ID, $loc->post_name, $loc->post_status );
		$counts['skipped']++;
		continue;
	}

	$per_state[ $state ] = ( $per_state[ $state ] ?? 0 ) + 1;

	$writes = array( '_roden_jurisdiction' => $state, '_roden_author_attorney' => $expect[ $state ]['id'] );
	foreach ( $expect[ $state ]['sol'] as $k => $v ) {
		$writes[ $k ] = $v;
	}

	$did = array();
	foreach ( $writes as $key => $value ) {
		$current = get_post_meta( $loc->ID, $key, true );

		if ( '' !== $current && null !== $current ) {
			// Never clobber a hand-set value.
			if ( (string) $current !== (string) $value ) {
				printf( "  CONFLICT #%d %s: %s is \"%s\", would be \"%s\" — left alone\n",
					$loc->ID, $loc->post_name, $key, $current, $value );
				$counts['conflict']++;
			} else {
				$counts['already']++;
			}
			continue;
		}

		if ( $apply ) {
			update_post_meta( $loc->ID, $key, $value );
			$check = get_post_meta( $loc->ID, $key, true );
			if ( (string) $check !== (string) $value ) {
				printf( "  ERROR   #%d %s: %s did not persist\n", $loc->ID, $loc->post_name, $key );
				continue;
			}
		}
		$did[] = $key;
		$counts['written']++;
	}

	if ( $did && ! $apply ) {
		printf( "  would set #%-5d %-52s [%s via %s] %s\n",
			$loc->ID, $loc->post_name, $state, $via, implode( ', ', $did ) );
	}
}

printf( "\n%s\n", str_repeat( '-', 72 ) );
printf( "meta values %s : %d\n", $apply ? 'written' : 'to write', $counts['written'] );
printf( "already correct     : %d\n", $counts['already'] );
printf( "conflicts left alone: %d\n", $counts['conflict'] );
printf( "posts skipped       : %d\n", $counts['skipped'] );
foreach ( $per_state as $s => $n ) {
	printf( "  %s pages: %d\n", $s, $n );
}
if ( $unresolved ) {
	printf( "\nunresolved (no office key in the ancestor chain):\n" );
	foreach ( $unresolved as $u ) {
		printf( "  %s\n", $u );
	}
}
printf( "\n_roden_last_reviewed: intentionally NOT set — see the header of this file.\n" );
if ( ! $apply ) {
	printf( "\nDry run. Re-run with `apply` to write.\n" );
}
