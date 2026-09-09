<?php
/**
 * Repairs anchors that name a page the site has never had.
 *
 * From docs/internal-link-audit-2026-09-08.md §3b. These read like the title of a
 * specific guide -- "Port of Charleston Truck Routes", "US-17 Truck Accidents on
 * the Grand Strand" -- and point at a practice-area pillar, because the guide was
 * planned as part of a corridor-resource cluster and never written. Most sit in
 * "Related resources:" lines: placeholders that shipped.
 *
 * BOTH THE HREF AND THE ANCHOR TEXT CHANGE. Repointing alone would only relocate
 * the mismatch: the reader would still be promised "Port of Charleston Truck
 * Routes" and still not get it. Each anchor is rewritten to name the page it
 * actually reaches.
 *
 * WHY NOT WRITE THE MISSING PAGES. Zero search demand. Across the 13-month export
 * there is no impression for Port of Charleston truck routes, US-17 Grand Strand
 * truck accidents, Highway 501, Lexington County truck accidents, or road rash.
 * Writing six pages to satisfy six links is backwards, and the knowledge-base
 * plan's §2 evidence is that resource pages earn their place on demand rather
 * than on completeness. The one anchor in this class that DID have demand --
 * "Savannah personal injury attorneys", 6,110 impressions -- got its page instead.
 *
 * DELIBERATELY OUT OF SCOPE: roughly eighteen anchors of the form "I-26 car
 * accident lawyers" / "I-526 car accident lawyers" that the local-SEO pipeline
 * emits, pointing at the car or truck pillar. Those are descriptive rather than
 * title-shaped -- the firm does handle I-26 crashes and the pillar is the
 * practice page -- and rewriting a pipeline's standard cross-link pattern is an
 * editorial decision about the pipeline, not a link repair.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/fix-phantom-page-anchors.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

$PORT   = '/blog/port-truck-accidents-charleston-liability/';
$PORTTX = 'Port truck accidents in Charleston';
$GEO    = '/resources/georgetown-county-us-17-truck-accidents/';
$GEOTX  = 'Georgetown County US-17 Truck Accidents';
$SURF   = '/resources/us-17-sc-544-truck-accidents-surfside-beach/';
$SURFTX = 'US-17 &amp; SC-544 Truck Accidents in Surfside Beach';
$H22    = '/resources/highway-22-truck-accidents-conway-bypass/';
$H22TX  = 'Highway 22 Truck Accidents: Conway Bypass';
$LEX    = '/blog/columbia-airport-expressway-us-378-truck-accident-springdale-lexington-county/';
$LEXTX  = 'Columbia Airport Expressway truck accidents in Lexington County';

// slug => list of [ old anchor html, new anchor html ]
$EDITS = array();

// ── "Port of Charleston Truck Routes" — the guide that was never written ──
foreach ( array( 'aviation-avenue-i-26-truck-accidents', 'spruill-avenue-port-trucks-north-charleston',
	'summerville-truck-accidents-i-26-corridor', 'i-526-truck-accidents-charleston',
	'port-access-road-truck-accidents-leatherman-terminal' ) as $slug ) {
	$EDITS[ $slug ][] = array(
		'<a href="/practice-areas/truck-accident-lawyers/">Port of Charleston Truck Routes</a>',
		'<a href="' . $PORT . '">' . $PORTTX . '</a>', 0 ); // 0 = replace every occurrence
}
$EDITS['rivers-avenue-truck-accidents-north-charleston'][] = array(
	'<a href="/practice-areas/truck-accident-lawyers/">Port of Charleston</a>',
	'<a href="' . $PORT . '">Port of Charleston</a>', 1 );

// ── Grand Strand US-17 — each page points at the OTHER real corridor guide ──
$EDITS['georgetown-county-us-17-truck-accidents'][] = array(
	'<a href="/practice-areas/truck-accident-lawyers/">US-17 Truck Accidents on the Grand Strand</a>',
	'<a href="' . $SURF . '">' . $SURFTX . '</a>', 1 );
foreach ( array( 'us-17-sc-544-truck-accidents-surfside-beach', 'highway-22-truck-accidents-conway-bypass' ) as $slug ) {
	$EDITS[ $slug ][] = array(
		'<a href="/practice-areas/truck-accident-lawyers/">US-17 Truck Accidents on the Grand Strand</a>',
		'<a href="' . $GEO . '">' . $GEOTX . '</a>', 1 );
}

// ── Highway 501 — no such guide; Highway 22 is the real Conway-bypass one ──
$EDITS['us-17-sc-544-truck-accidents-surfside-beach'][] = array(
	'<a href="/practice-areas/truck-accident-lawyers/">Highway 501 Truck Accidents</a>',
	'<a href="' . $H22 . '">' . $H22TX . '</a>', 1 );
$EDITS['highway-22-truck-accidents-conway-bypass'][] = array(
	'<a href="/practice-areas/truck-accident-lawyers/">Highway 501 Truck Accidents: Conway to Myrtle Beach</a>',
	'<a href="' . $GEO . '">' . $GEOTX . '</a>', 1 );

// ── Lexington County ──
$EDITS['bush-river-road-i-26-truck-accidents-columbia'][] = array(
	'<a href="/practice-areas/truck-accident-lawyers/">Lexington County Truck Accidents</a>',
	'<a href="' . $LEX . '">' . $LEXTX . '</a>', 1 );
$EDITS['i-20-truck-accidents-columbia'][] = array(
	'<a href="/practice-areas/truck-accident-lawyers/">Lexington County distribution corridor truck accidents</a>',
	'<a href="' . $LEX . '">' . $LEXTX . '</a>', 1 );
// A bare place name pointing at the truck pillar, in a sentence about logistics
// growth "particularly in Lexington County". Same destination as its sibling.
$EDITS['i-20-truck-accidents-columbia'][] = array(
	'<a href="/practice-areas/truck-accident-lawyers/">Lexington County</a>',
	'<a href="' . $LEX . '">Lexington County</a>', 1 );

// ── Mount Pleasant / Wando Welch — no such guide; the I-526 Wando one is real ──
$EDITS['i-526-truck-accidents-charleston'][] = array(
	'<a href="/practice-areas/truck-accident-lawyers/">Mount Pleasant Truck Accidents Near Wando Welch</a>',
	'<a href="/blog/i-526-mount-pleasant-wando-bridge-accident/">I-526 through Mount Pleasant and the Wando Bridge</a>', 1 );

// ── The remaining three, each with its own reason ──
// Already links North Charleston car accident lawyers in the same sentence, so
// pointing this at the same page would duplicate it. The dangerous-roads resource
// is the I-26 page that actually exists.
$EDITS['rideshare-accident-i-26-tenmile-north-charleston'][] = array(
	'<a href="/practice-areas/car-accident-lawyers/">I-26 car accident attorneys</a>',
	'<a href="/resources/dangerous-roads-north-charleston/">the most dangerous roads in North Charleston</a>', 1 );

// Road rash is not a burn. Its list siblings are unlinked bold text, so removing
// the link makes the item consistent rather than leaving a wrong destination.
$EDITS['pedestrian-safety-georgia'][] = array(
	'<a href="/practice-areas/burn-injury-lawyers/">Road rash and abrasion injuries</a>',
	'Road rash and abrasion injuries', 1 );

$EDITS['kemira-plant-drive-savannah-fatal-truck-accident-lawyer'][] = array(
	'<a href="/practice-areas/workers-compensation-lawyers/">Savannah port and industrial worker injury claims</a>',
	'<a href="/workers-compensation-lawyers/port-worker-injury/">port worker injury claims</a>', 1 );

// Preflight: every destination must resolve.
echo "--- destination check ---\n";
$bad = 0;
foreach ( $EDITS as $slug => $list ) {
	foreach ( $list as $e ) {
		if ( preg_match( '#href="([^"]+)"#', $e[1], $m ) && ! url_to_postid( home_url( $m[1] ) ) ) {
			echo "DOES NOT RESOLVE: {$m[1]}\n"; $bad++;
		}
	}
}
if ( $bad ) { echo "ABORTING — $bad bad destination(s)\n"; return; }
echo "all destinations resolve\n\n";

$backup = array(); $ok = true; $total = 0;

foreach ( $EDITS as $slug => $list ) {
	$p = get_page_by_path( $slug, OBJECT, array( 'post', 'page', 'resource', 'practice_area' ) );
	if ( ! $p ) { echo "MISSING PAGE: $slug\n"; $ok = false; continue; }

	$c = $p->post_content; $orig = $c; $n = 0;
	foreach ( $list as $e ) {
		list( $old, $new, $expect ) = $e;
		$hits = substr_count( $c, $old );
		if ( 0 === $hits ) { echo "REFUSE $slug — anchor not found: " . substr( $old, 0, 70 ) . "\n"; $ok = false; continue; }
		if ( $expect && $expect !== $hits ) { echo "REFUSE $slug — expected $expect, found $hits\n"; $ok = false; continue; }
		$c = str_replace( $old, $new, $c );
		$n += $hits;
	}
	if ( $c === $orig ) { continue; }

	$backup[] = array( 'id' => $p->ID, 'surface' => 'post_content', 'before' => $orig );
	$total   += $n;
	printf( "%s %-52s +%d\n", $APPLY ? 'APPLY ' : 'DRYRUN', $slug, $n );

	if ( ! $APPLY ) { continue; }
	$r = wp_update_post( wp_slash( array( 'ID' => $p->ID, 'post_content' => $c ) ), true );
	if ( is_wp_error( $r ) ) { echo "   ERROR " . $r->get_error_message() . "\n"; $ok = false; }
}

if ( $APPLY ) {
	echo "\n--- verify ---\n";
	$left = 0;
	foreach ( $EDITS as $slug => $list ) {
		$p = get_page_by_path( $slug, OBJECT, array( 'post', 'page', 'resource', 'practice_area' ) );
		foreach ( $list as $e ) {
			if ( $p && false !== strpos( $p->post_content, $e[0] ) ) { echo "STILL PRESENT: $slug\n"; $left++; $ok = false; }
		}
	}
	echo ( 0 === $left ) ? "all anchors rewritten\n" : "$left remaining\n";
}

echo "\n" . wp_json_encode( array( 'applied' => $APPLY, 'anchors' => $total, 'pages' => count( $backup ), 'ok' => $ok ) ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload ---\n";
	$j = wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? 'ENCODE FAILED' : $j;
	echo "\n";
}
