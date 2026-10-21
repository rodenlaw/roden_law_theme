<?php
/**
 * Floor-cull merge carry-over, 2026-10-21 — Folly Road (4344), Ashley Phosphate (4337),
 * Savannah highways (4538). Plan: docs/floor-cull-carryover-2026-10-21.md. Owner: "do 1 and 3 now".
 *
 * Carries the few facts the merged-away pages had that their targets lack. None of the inserted
 * text states law. The Ravenel guide (3499) is NOT touched here: its passages state SC law and
 * wait for Gillin's review.
 *
 * Every edit is an exact-anchor insertion: the anchor must occur exactly once in the current
 * post_content, or the script refuses that post. All edits for a post are applied to one working
 * copy and written once (the backfill-helmet-citations pattern), with wp_slash().
 * `_roden_content_modified` is set because what the page says changes; `_roden_last_reviewed`
 * is NOT touched.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/apply-floor-cull-carryover.php > docs/backups/floor-cull-carryover-2026-10-21.json
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/apply-floor-cull-carryover.php > docs/backups/floor-cull-carryover-2026-10-21.json
 *
 * STDOUT is a JSON backup (before/after post_content per post). Restore by writing "before" back.
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — floor-cull carry-over, 3 posts\n\n", $apply ? 'APPLY' : 'DRY RUN' );

$edits = array(

	// ── Folly Road / James Island ────────────────────────────────────────────
	4344 => array(
		array(
			'id'     => 'F1 report agency',
			'anchor' => '<li><strong>Call 911</strong> — request police and medical assistance; a police report is critical evidence</li>',
			'with'   => '<li><strong>Call 911</strong> — request police and medical assistance; a police report is critical evidence. Depending on where along Folly Road the crash happens, the report may come from the <a href="https://charleston-sc.gov/313/Patrol-Division" target="_blank" rel="noopener">Charleston Police Department</a>, the Charleston County Sheriff\'s Office (which also patrols the <a href="https://www.jamesislandsc.us/node/56" target="_blank" rel="noopener">Town of James Island</a> under contract), the <a href="https://cityoffollybeach.com/departments/public_safey/police/index.php" target="_blank" rel="noopener">Folly Beach Police Department</a> or the South Carolina Highway Patrol; note the agency and the report number before you leave</li>',
		),
	),

	// ── Ashley Phosphate Road / I-26 ─────────────────────────────────────────
	4337 => array(
		array(
			'id'     => 'A3 Live 5 deadliest roads',
			'anchor' => 'This constant churn of turning movements creates unpredictable conflicts that even attentive drivers struggle to anticipate.</p>',
			'with'   => 'This constant churn of turning movements creates unpredictable conflicts that even attentive drivers struggle to anticipate. Citing South Carolina Department of Transportation traffic data, <a href="https://www.live5news.com/2026/07/31/last-chance-weigh-your-commute-helps-shape-north-charlestons-next-road-safety-projects/" target="_blank" rel="noopener">Live 5 News reported in July 2026</a> that four of Charleston County\'s five deadliest roads are in North Charleston: Rivers Avenue, Dorchester Road, Ashley Phosphate Road and Remount Road.</p>',
		),
		array(
			'id'     => 'A1 trailer-sweep row',
			'anchor' => '<td>Fractures, <a href="/practice-areas/brain-injury-lawyers/">traumatic brain injury</a>, <a href="/practice-areas/wrongful-death-lawyers/">fatality</a></td></tr>' . "\n" . '</tbody>',
			'with'   => '<td>Fractures, <a href="/practice-areas/brain-injury-lawyers/">traumatic brain injury</a>, <a href="/practice-areas/wrongful-death-lawyers/">fatality</a></td></tr>' . "\n" . '<tr><td><a href="/practice-areas/truck-accident-lawyers/">Right-turn trailer sweep</a></td><td>A truck\'s trailer cuts the corner or swings into the next lane on a right turn, catching a car, motorcycle or a pedestrian in the crosswalk</td><td>Crush injuries, fractures, traumatic brain injury</td></tr>' . "\n" . '</tbody>',
		),
		array(
			'id'     => 'A2 document the truck',
			'anchor' => '<li><strong>Photograph everything</strong> — Signal positions, vehicle damage, intersection layout, your injuries</li>',
			'with'   => '<li><strong>Photograph everything</strong> — Signal positions, vehicle damage, intersection layout, your injuries</li>' . "\n" . '<li><strong>Document the truck</strong> — If a truck was involved, photograph the company name, the USDOT number on the cab door and the trailer number, and ask a lawyer to send a preservation letter for the truck\'s electronic logging device (ELD) and event data recorder before the data is overwritten</li>',
		),
	),

	// ── Savannah highways ────────────────────────────────────────────────────
	4538 => array(
		array(
			'id'     => 'S1 port truck moves',
			'anchor' => 'the size and weight of these vehicles make crashes far more likely to produce catastrophic injuries or death.</p>',
			'with'   => 'the size and weight of these vehicles make crashes far more likely to produce catastrophic injuries or death. The port handles 14,000 to 16,000 truck moves a day, Monday through Friday (<a href="https://gaports.com/press-releases/port-of-savannah-achieves-second-busiest-year-ever/" target="_blank" rel="noopener">Georgia Ports Authority</a>), and much of that traffic reaches I-16 at Dean Forest Road and by I-516.</p>',
		),
		array(
			'id'     => 'S2 Georgia large-truck deaths',
			'anchor' => 'you may have claims against both the driver and the trucking company.</p>',
			'with'   => 'you may have claims against both the driver and the trucking company. Statewide, 197 people died in Georgia crashes involving large trucks in 2024, and 173 of them were in other vehicles or outside a vehicle, such as pedestrians and cyclists (<a href="https://crashstats.nhtsa.dot.gov/Api/Public/ViewPublication/813816" target="_blank" rel="noopener">NHTSA, Traffic Safety Facts: Large Trucks, 2024 Data</a>).</p>',
		),
		array(
			'id'     => 'S3 document the truck',
			'anchor' => 'Highway crashes often require specialized response including fire rescue and traffic control.</li>',
			'with'   => 'Highway crashes often require specialized response including fire rescue and traffic control.</li>' . "\n" . '<li><strong>Document the truck</strong> if one was involved: photograph its company name, the USDOT number on the cab door, the trailer number and the cargo type. They identify the carrier and its insurer.</li>',
		),
		array(
			'id'     => 'S4 Level I trauma center',
			'anchor' => 'Adrenaline can mask pain from serious injuries like <a href="/practice-areas/brain-injury-lawyers/">concussions</a>, internal bleeding, and soft tissue damage.</li>',
			'with'   => 'Adrenaline can mask pain from serious injuries like <a href="/practice-areas/brain-injury-lawyers/">concussions</a>, internal bleeding, and soft tissue damage. Memorial Health University Medical Center in Savannah is the region\'s Level I trauma center (<a href="https://dph.georgia.gov/document/document/ga-tc-list-04-01-2025pdf/download" target="_blank" rel="noopener">Georgia Department of Public Health</a>).</li>',
		),
	),
);

$out = array(
	'generated' => gmdate( 'c' ),
	'batch'     => 'floor-cull-carryover',
	'mode'      => $apply ? 'apply' : 'dry-run',
	'note'      => 'post_content before/after per post. Restore by writing "before" back with wp_slash().',
	'posts'     => array(),
);
$failed = 0;

foreach ( $edits as $post_id => $list ) {
	$post = get_post( $post_id );
	if ( ! $post || 'publish' !== $post->post_status ) {
		fprintf( $err, "  REFUSE %d: not a published post\n", $post_id );
		$failed++;
		continue;
	}
	$before = $post->post_content;
	$work   = $before;
	$ok     = true;
	foreach ( $list as $e ) {
		$n = substr_count( $work, $e['anchor'] );
		if ( 1 !== $n ) {
			fprintf( $err, "  REFUSE %d %s: anchor found %d times\n", $post_id, $e['id'], $n );
			$ok = false;
			break;
		}
		$work = str_replace( $e['anchor'], $e['with'], $work );
		fprintf( $err, "  ok     %d %s\n", $post_id, $e['id'] );
	}
	if ( ! $ok ) {
		$failed++;
		continue;
	}
	$added = str_word_count( wp_strip_all_tags( $work ) ) - str_word_count( wp_strip_all_tags( $before ) );
	fprintf( $err, "  %s %d: %d edits, +%d words\n\n", $apply ? 'WRITE ' : 'would ', $post_id, count( $list ), $added );

	$row = array( 'ID' => $post_id, 'permalink' => get_permalink( $post_id ), 'edits' => wp_list_pluck( $list, 'id' ), 'words_added' => $added, 'before' => $before, 'after' => $work );

	if ( $apply ) {
		$res = wp_update_post( wp_slash( array( 'ID' => $post_id, 'post_content' => $work ) ), true );
		if ( is_wp_error( $res ) ) {
			fprintf( $err, "  FAIL %d: %s\n", $post_id, $res->get_error_message() );
			$failed++;
			continue;
		}
		update_post_meta( $post_id, '_roden_content_modified', wp_slash( gmdate( 'Y-m-d H:i:s' ) ) );
		clean_post_cache( $post_id );
		global $wpdb;
		$stored = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $post_id ) );
		$row['verified'] = ( $stored === $work );
		fprintf( $err, "  read-back %d: %s\n", $post_id, $row['verified'] ? 'MATCH' : 'MISMATCH' );
		if ( ! $row['verified'] ) {
			$failed++;
		}
	}
	$out['posts'][] = $row;
}

fprintf( $err, "%s: %d post(s), %d failed\n", $apply ? 'Applied' : 'Dry run', count( $out['posts'] ), $failed );
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
