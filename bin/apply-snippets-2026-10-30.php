<?php
/**
 * Snippet batch 2026-10-30: <title> and meta description on three free-to-judge
 * pages that rank ~5-11 for a high-impression query but earn ~0 clicks
 * (data/gsc/latest.json, 2026-09-26..10-23; data/seo/ledger.json status free,
 * --check clear on all three).
 *
 *   3621 /practice-areas/pedestrian-accident-lawyers/   "pedestrian accident lawyer" @9.9, 3,899 impr, 1 click
 *   4878 /es/practice-areas/pedestrian-accident-lawyers/ "abogado de accidente de peatón" @10.7, 823 impr
 *   3597 /locations/georgia/savannah/                    17 clicks / 8,822 impr; meta description empty
 *   4054 /car-accident-lawyers/commercial-vehicle-accident/ "commercial vehicle accident lawyers" @10.5, 610 impr, 0 clicks
 *
 * Titles were measured at 20px Arial against Google's ~580px: the old pillar
 * pattern ("... in Georgia & South Carolina – Roden Law") renders 636-732px and
 * truncates. Savannah's title (417px) is kept: the office page already outranks
 * /car-accident-lawyers/savannah-ga/ for "savannah car accident lawyer", and
 * putting the car keyword in the office title would deepen that.
 *
 * Descriptions state scope and contact only: no statute, deadline, statistic or
 * outcome claim. H1 / post_title untouched. Body untouched.
 *
 * Every field is checked against its expected CURRENT value before anything is
 * written; one mismatch aborts the batch. wp_slash on write; read back.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/apply-snippets-2026-10-30.php   # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/apply-snippets-2026-10-30.php   # write
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

$edits = array(
	array( 3621, '_roden_meta_title', '', 'Pedestrian Accident Lawyers in GA & SC | Free Case Review' ),
	array( 3621, '_roden_meta_description',
		'Pedestrian accident claims in Georgia and South Carolina for people struck by drivers who failed to yield or were distracted, impaired, or speeding.',
		'Hit by a car while walking in Georgia or South Carolina? We pursue drivers who failed to yield or were distracted, impaired or speeding. Free case review.' ),
	array( 4878, '_roden_meta_title', '', 'Abogado de Accidentes de Peatones en GA y SC | Roden Law' ),
	array( 3597, '_roden_meta_description', '',
		'Savannah personal injury lawyers at 333 Commercial Dr. Car, truck and workplace injury claims across Chatham, Bryan and Effingham counties. Call (912) 303-5850.' ),
	array( 4054, '_roden_meta_title', '', 'Commercial Vehicle Accident Lawyers in GA & SC | Roden Law' ),
	array( 4054, '_roden_meta_description', '',
		'Hit by a delivery van, company car or fleet vehicle in GA or SC? We pursue the driver and, where liable, the employer behind them. Free case review.' ),
);

$expect_slug = array(
	3621 => 'pedestrian-accident-lawyers',
	4878 => 'es-pedestrian-accident-lawyers',
	3597 => 'savannah',
	4054 => 'commercial-vehicle-accident',
);

// Pass 1: verify everything before writing anything.
foreach ( $edits as $e ) {
	list( $id, $key, $from, $to ) = $e;
	$p = get_post( $id );
	if ( ! $p || 'publish' !== $p->post_status || $expect_slug[ $id ] !== $p->post_name ) {
		fwrite( STDERR, "ABORT: post $id is not the published '{$expect_slug[ $id ]}'\n" );
		exit( 1 );
	}
	$cur = (string) get_post_meta( $id, $key, true );
	if ( $cur === $to ) {
		continue;
	}
	if ( $cur !== $from ) {
		fwrite( STDERR, "ABORT: $id $key current value is not the expected one: \"$cur\"\n" );
		exit( 1 );
	}
	$max = ( '_roden_meta_title' === $key ) ? 70 : 160;
	if ( mb_strlen( $to ) > $max ) {
		fwrite( STDERR, "ABORT: $id $key new value over $max chars\n" );
		exit( 1 );
	}
}

$backup = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'fields' => array() );
foreach ( $edits as $e ) {
	list( $id, $key, $from, $to ) = $e;
	$cur = (string) get_post_meta( $id, $key, true );
	$backup['fields'][] = array( 'post' => $id, 'key' => $key, 'before' => $cur, 'after' => $to );
	if ( $cur === $to ) {
		fwrite( STDERR, "  OK      $id $key already set\n" );
		continue;
	}
	fwrite( STDERR, '  ' . ( $apply ? 'SET    ' : 'WOULD  ' ) . " $id $key\n" );
	if ( ! $apply ) {
		continue;
	}
	update_post_meta( $id, $key, wp_slash( $to ) );
	wp_cache_delete( $id, 'post_meta' );
	clean_post_cache( $id );
	if ( (string) get_post_meta( $id, $key, true ) !== $to ) {
		fwrite( STDERR, "FAILED read-back $id $key\n" );
		exit( 1 );
	}
}
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ), "\n";
