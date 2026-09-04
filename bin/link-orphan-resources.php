<?php
/**
 * Gives every orphaned resource page an editorial inbound link.
 *
 * Resource pages convert roughly 75x better per impression than city×practice
 * pages (KNOWLEDGE-BASE-PLAN §2), and 21 of the 62 English resource pages had
 * ZERO inbound editorial links — nothing in any page body, FAQ or takeaway
 * pointed at them. That includes both research studies and both settlement
 * calculators.
 *
 * WHAT THIS IS NOT. They were never unreachable: /resources/ is in the site nav
 * (inc/nav-menus.php injects it), the archive paginates at 11/page across all 62,
 * and each resource renders 10-13 template links to siblings. This is about
 * contextual links from related content — the ones a reader in flow actually
 * follows and the ones that carry topical signal — not about crawlability.
 *
 * HOSTS ARE CHOSEN, NOT MATCHED. An automated token match produced region errors
 * (Conway routed to North Charleston, Columbia pages to Charleston) and, worse,
 * picked hosts that were themselves orphans — wiring orphans to each other
 * solves nothing. Every host below is in the same metro as its orphan AND has at
 * least one inbound link of its own, so the new link inherits real connectivity.
 *
 * House pattern, copied from the 22 pages that already use it:
 *   <p>Related resources: <a href="...">Title</a> | <a href="...">Title</a></p>
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/link-orphan-resources.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

// host slug => array( orphan path => anchor text )
$PLAN = array(

	// ── Savannah ───────────────────────────────────────────────────────────
	'port-of-savannah-truck-routes' => array(
		'/resources/jimmy-deloach-connector-truck-accidents-savannah/' => 'Jimmy DeLoach Connector Truck Accidents',
		'/resources/bay-street-truck-accidents-savannah-historic-district/' => 'Bay Street Truck Traffic in the Historic District',
	),
	'i-16-truck-accidents-savannah' => array(
		'/resources/i-16-i-95-construction-zone-truck-accidents/' => 'I-16 / I-95 Construction Zone Truck Accidents',
	),
	'i-95-truck-accidents-savannah-brunswick' => array(
		'/resources/i-95-widening-construction-zone-ga-sc/' => 'I-95 Widening Construction Zone: GA–SC Border',
		'/resources/i-26-i-95-corridor-report/' => 'The I-26 / I-95 Corridor Report',
	),

	// ── North Charleston ───────────────────────────────────────────────────
	'rivers-avenue-truck-accidents-north-charleston' => array(
		'/resources/dangerous-roads-north-charleston/' => 'Most Dangerous Roads & Intersections in North Charleston',
		'/resources/dorchester-road-truck-accidents-north-charleston/' => 'Dorchester Road Truck Accidents',
	),
	'ashley-phosphate-i-26-truck-accidents' => array(
		'/resources/aviation-avenue-i-26-truck-accidents/' => 'Aviation Avenue & I-26 Truck Accidents',
		'/resources/pedestrian-bicycle-safety-north-charleston/' => 'North Charleston Pedestrian & Bicycle Safety',
	),
	'spruill-avenue-port-trucks-north-charleston' => array(
		'/resources/port-access-road-truck-accidents-leatherman-terminal/' => 'Port Access Road Truck Accidents Near Leatherman Terminal',
		'/resources/us-52-truck-train-accidents-goose-creek/' => 'US-52 Truck & Train Accidents in Goose Creek',
	),

	// ── Charleston ─────────────────────────────────────────────────────────
	'i-526-truck-accidents-charleston' => array(
		'/resources/i-526-construction-zone-truck-accidents-charleston/' => 'I-526 Lowcountry Corridor Construction Zone',
	),
	'summerville-truck-accidents-i-26-corridor' => array(
		'/resources/personal-injury-claim-charleston-county-court/' => 'Filing a Personal Injury Claim in Charleston County Circuit Court',
	),

	// ── Columbia ───────────────────────────────────────────────────────────
	'columbia-i-26-i-20-i-77-interchange-truck-accidents' => array(
		'/resources/blythewood-i-77-truck-accidents/' => 'Blythewood & I-77 Truck Accidents',
		'/resources/carolina-crossroads-construction-zone-truck-accidents/' => 'Carolina Crossroads Construction Zone Truck Accidents',
	),
	'broad-river-road-truck-accidents-columbia' => array(
		'/resources/two-notch-road-truck-accidents-columbia/' => 'Two Notch Road Truck Accidents',
	),

	// ── Grand Strand ───────────────────────────────────────────────────────
	// The only Grand Strand resource with an inbound link is Study #2, and it is
	// the right topical parent for road-danger pages in Horry County.
	'myrtle-beach-fatal-crashes' => array(
		'/resources/highway-22-truck-accidents-conway-bypass/' => 'Highway 22 Truck Accidents: Conway Bypass',
		'/resources/us-17-sc-544-truck-accidents-surfside-beach/' => 'US-17 & SC-544 Truck Accidents in Surfside Beach',
		'/resources/georgetown-county-us-17-truck-accidents/' => 'Georgetown County US-17 Truck Accidents',
	),

	// ── Settlement-value siblings ──────────────────────────────────────────
	'georgia-truck-accident-settlement-value' => array(
		'/resources/georgia-car-accident-settlement-value/' => 'How Much Is a Georgia Car Accident Case Worth?',
	),
	'south-carolina-slip-and-fall-settlement-value' => array(
		'/resources/south-carolina-motorcycle-accident-settlement-value/' => 'How Much Is a South Carolina Motorcycle Accident Case Worth?',
	),
);

// Every destination must resolve, and no orphan may be linked twice.
echo "--- preflight ---\n";
$bad = 0; $seen = array();
foreach ( $PLAN as $hslug => $adds ) {
	$h = get_page_by_path( $hslug, OBJECT, 'resource' );
	if ( ! $h || 'publish' !== $h->post_status ) { echo "HOST MISSING: $hslug\n"; $bad++; continue; }
	foreach ( $adds as $path => $text ) {
		if ( ! url_to_postid( home_url( $path ) ) ) { echo "ORPHAN DOES NOT RESOLVE: $path\n"; $bad++; }
		if ( isset( $seen[ $path ] ) ) { echo "DUPLICATE ORPHAN: $path\n"; $bad++; }
		$seen[ $path ] = true;
	}
}
if ( $bad ) { echo "ABORTING — $bad problem(s)\n"; return; }
printf( "%d hosts, %d orphans, all resolve\n\n", count( $PLAN ), count( $seen ) );

$backup = array(); $added = 0; $newblocks = 0;

foreach ( $PLAN as $hslug => $adds ) {
	$h = get_page_by_path( $hslug, OBJECT, 'resource' );
	$c = $h->post_content;

	$links = array();
	foreach ( $adds as $path => $text ) {
		if ( false !== strpos( $c, 'href="' . $path . '"' ) ) {
			echo "SKIP  {$hslug} already links {$path}\n";
			continue;
		}
		$links[] = '<a href="' . $path . '">' . $text . '</a>';
	}
	if ( ! $links ) { continue; }

	$backup[] = array( 'id' => $h->ID, 'surface' => 'post_content', 'before' => $c );

	if ( preg_match( '#(<p>Related resources:.*?)(</p>)#s', $c ) ) {
		// Append inside the existing block, keeping the " | " separator.
		$new = preg_replace_callback( '#(<p>Related resources:.*?)(</p>)#s',
			function ( $m ) use ( $links ) { return $m[1] . ' | ' . implode( ' | ', $links ) . $m[2]; },
			$c, 1 );
	} else {
		$new = rtrim( $c ) . "\n<p>Related resources: " . implode( ' | ', $links ) . '</p>';
		$newblocks++;
	}

	$added += count( $links );
	printf( "%-52s +%d link(s)%s\n", $hslug, count( $links ),
		( $new === $c ) ? '  (NO CHANGE)' : '' );

	if ( $APPLY ) {
		$res = wp_update_post( array( 'ID' => $h->ID, 'post_content' => $new ), true );
		if ( is_wp_error( $res ) ) { echo "   ERROR " . $res->get_error_message() . "\n"; }
	}
}

echo "\n" . wp_json_encode( array( 'applied' => $APPLY, 'links_added' => $added,
	'hosts' => count( $backup ), 'new_blocks' => $newblocks ) ) . "\n";

if ( $APPLY ) {
	echo "\n--- verify ---\n";
	$fail = 0;
	foreach ( $PLAN as $hslug => $adds ) {
		$h = get_page_by_path( $hslug, OBJECT, 'resource' );
		foreach ( $adds as $path => $text ) {
			if ( false === strpos( $h->post_content, 'href="' . $path . '"' ) ) {
				echo "FAIL $hslug -> $path\n"; $fail++;
			}
		}
	}
	echo ( 0 === $fail ) ? "all links present\n" : "$fail missing\n";
} else {
	echo "\n--- backup payload ---\n";
	$j = wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? 'ENCODE FAILED' : $j;
	echo "\n";
}
