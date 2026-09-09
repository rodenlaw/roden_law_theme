<?php
/**
 * Repoints links whose anchor text promises one page and delivers another.
 *
 * From the anchor-text audit in docs/internal-link-audit-2026-09-08.md. 1,798
 * internal links point at the 24 practice-area pillars; an automated matcher
 * flagged 68 and MOST WERE FALSE POSITIVES. "slip and fall injuries" pointing at
 * the slip-and-fall pillar is correct — generic descriptive anchor text on a
 * pillar is exactly what a pillar is for. Reading all 68 by hand left these nine.
 *
 * Each one below promises a specific page in its anchor text and lands somewhere
 * more general or, in two cases, somewhere unrelated:
 *
 *   "spinal cord injury"        -> the BRAIN INJURY pillar. Different pillar,
 *                                  different body system. The same anchor text
 *                                  correctly points at the spinal-cord pillar on
 *                                  eighteen other pages; this is the one that
 *                                  slipped.
 *   "statute of limitations..." -> the CAR ACCIDENT pillar. The page is a
 *                                  two-state truck article, so the two-state
 *                                  filing-deadlines resource is the honest target
 *                                  rather than either single-state one.
 *
 * NOT INCLUDED: anchors naming a page that does not exist -- "Port of Charleston
 * Truck Routes" on five pages, "US-17 Truck Accidents on the Grand Strand" on
 * three, and five others. Repointing those at a pillar would keep the promise
 * broken. They are content gaps and are listed in the audit for an editorial
 * decision, not silently patched here.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/fix-mistargeted-anchors.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

// post id => array( old href, anchor text, new href )
$EDITS = array(
	array( 4586, '/practice-areas/brain-injury-lawyers/', 'spinal cord injury',
	              '/practice-areas/spinal-cord-injury-lawyers/' ),
	array( 1665, '/practice-areas/car-accident-lawyers/', 'statute of limitations for personal injury claims',
	              '/resources/georgia-vs-south-carolina-filing-deadlines/' ),
	// Twice on this page -- once in prose, once in a related-links list. Both are
	// the same mis-target, so both move; the count is stated so the guard still
	// refuses if a third appears.
	array( 3652, '/practice-areas/workers-compensation-lawyers/', 'Savannah port worker injury lawyers',
	              '/workers-compensation-lawyers/port-worker-injury/', 2 ),
	array( 4639, '/practice-areas/car-accident-lawyers/', 'Ashley Phosphate Road',
	              '/resources/ashley-phosphate-i-26-truck-accidents/' ),
	array( 5019, '/practice-areas/pedestrian-accident-lawyers/', 'Rivers Avenue pedestrian accidents',
	              '/blog/rivers-avenue-pedestrian-deaths-north-charleston/' ),
	array( 1664, '/practice-areas/premises-liability-lawyers/', 'Road hazard accidents',
	              '/blog/road-hazard-car-accident-liability/' ),
	array( 3404, 'https://rodenlaw.com/practice-areas/car-accident-lawyers/', 'Charleston car accident attorneys',
	              '/car-accident-lawyers/charleston-sc/' ),
	array( 2777, 'https://rodenlaw.com/practice-areas/car-accident-lawyers/', 'Charleston car accident attorneys',
	              '/car-accident-lawyers/charleston-sc/' ),
	array( 2792, 'https://rodenlaw.com/practice-areas/personal-injury-lawyers/', 'Charleston personal injury attorneys',
	              '/personal-injury-lawyers/charleston-sc/' ),
);

echo "--- destination check ---\n";
$bad = 0;
foreach ( array_unique( array_column( $EDITS, 3 ) ) as $d ) {
	if ( ! url_to_postid( home_url( $d ) ) ) { echo "DOES NOT RESOLVE: $d\n"; $bad++; }
}
if ( $bad ) { echo "ABORTING\n"; return; }
echo "all destinations resolve\n\n";

$backup = array(); $ok = true; $seen = array();

foreach ( $EDITS as $n => $e ) {
	list( $id, $old_href, $text, $new_href ) = $e;
	$expect = isset( $e[4] ) ? (int) $e[4] : 1;
	$p = get_post( $id );
	if ( ! $p ) { echo "MISSING post $id\n"; $ok = false; continue; }

	$c = $p->post_content;

	// Match the whole anchor, so only THIS link moves — the same href appears
	// elsewhere on several of these pages with different, correct anchor text.
	$pattern = '#<a href="' . preg_quote( $old_href, '#' ) . '"([^>]*)>' . preg_quote( $text, '#' ) . '</a>#';
	$hits = preg_match_all( $pattern, $c );

	if ( $expect !== $hits ) {
		echo "REFUSE #$n post $id — expected $expect matching anchor(s), found $hits\n";
		$ok = false;
		continue;
	}

	$new = preg_replace( $pattern, '<a href="' . $new_href . '"$1>' . $text . '</a>', $c, $expect );

	if ( ! isset( $seen[ $id ] ) ) { $backup[] = array( 'id' => $id, 'surface' => 'post_content', 'before' => $c ); $seen[ $id ] = true; }

	printf( "%s #%d  post %-5d \"%s\"\n", $APPLY ? 'APPLY ' : 'DRYRUN', $n, $id, $text );
	printf( "         %s  ->  %s\n", $old_href, $new_href );

	if ( ! $APPLY ) { continue; }

	$res = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $new ) ), true );
	if ( is_wp_error( $res ) ) { echo "   ERROR " . $res->get_error_message() . "\n"; $ok = false; }
}

if ( $APPLY ) {
	echo "\n--- verify ---\n";
	$fail = 0;
	foreach ( $EDITS as $n => $e ) {
		list( $id, $old_href, $text, $new_href ) = $e;
		$c = get_post_field( 'post_content', $id );
		if ( false === strpos( $c, '<a href="' . $new_href . '"' ) ) { printf( "FAIL post %d\n", $id ); $fail++; $ok = false; }
	}
	echo ( 0 === $fail ) ? "all " . count( $EDITS ) . " anchors repointed\n" : "$fail failed\n";
}

echo "\n" . wp_json_encode( array( 'applied' => $APPLY, 'edits' => count( $EDITS ), 'ok' => $ok ) ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload ---\n";
	$j = wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? 'ENCODE FAILED' : $j;
	echo "\n";
}
