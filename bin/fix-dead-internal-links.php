<?php
/**
 * Repoints every internal link that 404s.
 *
 * Found by extracting all 4,818 internal links from post_content, _roden_faqs
 * and _roden_key_takeaways across 1,258 published pages and resolving each of
 * the 802 distinct targets against production: 596 → 200, 183 → 301, 23 → 404.
 *
 * THE LOCATION LINKS ARE NOT CULL CASUALTIES. The pages were RE-PARENTED, not
 * removed. North Charleston moved from a child of Charleston to a top-level
 * office city, and Goose Creek, Ladson and Summerville moved with it:
 *
 *   /locations/south-carolina/charleston/north-charleston/  →  .../north-charleston/
 *   /locations/south-carolina/charleston/goose-creek/       →  .../north-charleston/goose-creek/
 *
 * All four destinations are live and published. Only Hanahan and Park Circle are
 * genuinely gone; both are North Charleston areas (Park Circle is a North
 * Charleston neighbourhood outright), so both point at the North Charleston page
 * rather than at a hub — a topical destination, not a soft 404.
 *
 * THE LARGEST CLASS IS NOT LOCATIONS AT ALL. 75 of the 115 dead link instances
 * are practice-area pillars linked WITHOUT the /practice-areas/ prefix —
 * /brain-injury-lawyers/ instead of /practice-areas/brain-injury-lawyers/. Every
 * one of those pillars is live at the prefixed URL. This is a link-writing
 * pattern, not a content problem, and it is worth a guard later.
 *
 * Every destination below was verified live and published before being written.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/fix-dead-internal-links.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

$MAP = array(
	// ── Practice-area pillars missing the /practice-areas/ prefix ──────────
	'/brain-injury-lawyers/'         => '/practice-areas/brain-injury-lawyers/',
	'/car-accident-lawyers/'         => '/practice-areas/car-accident-lawyers/',
	'/spinal-cord-injury-lawyers/'   => '/practice-areas/spinal-cord-injury-lawyers/',
	'/premises-liability-lawyers/'   => '/practice-areas/premises-liability-lawyers/',
	'/motorcycle-accident-lawyers/'  => '/practice-areas/motorcycle-accident-lawyers/',
	'/truck-accident-lawyers/'       => '/practice-areas/truck-accident-lawyers/',
	'/medical-malpractice-lawyers/'  => '/practice-areas/medical-malpractice-lawyers/',
	'/pedestrian-accident-lawyers/'  => '/practice-areas/pedestrian-accident-lawyers/',
	'/nursing-home-abuse-lawyers/'   => '/practice-areas/nursing-home-abuse-lawyers/',
	'/bicycle-accident-lawyers/'     => '/practice-areas/bicycle-accident-lawyers/',
	'/maritime-injury-lawyers/'      => '/practice-areas/maritime-injury-lawyers/',

	// ── Re-parented location pages ─────────────────────────────────────────
	'/locations/south-carolina/charleston/north-charleston/' => '/locations/south-carolina/north-charleston/',
	'/locations/south-carolina/charleston/goose-creek/'      => '/locations/south-carolina/north-charleston/goose-creek/',
	'/locations/south-carolina/charleston/ladson/'           => '/locations/south-carolina/north-charleston/ladson/',
	'/locations/south-carolina/charleston/summerville/'      => '/locations/south-carolina/north-charleston/summerville/',

	// Genuinely removed; both are North Charleston areas.
	'/locations/south-carolina/charleston/hanahan/'          => '/locations/south-carolina/north-charleston/',
	'/locations/south-carolina/charleston/park-circle/'      => '/locations/south-carolina/north-charleston/',

	// ── Wrong slug or wrong pillar ─────────────────────────────────────────
	'/car-accident-lawyers/hit-and-run/'            => '/car-accident-lawyers/hit-and-run-accident/',
	'/truck-accident-lawyers/drunk-driver-accident/' => '/car-accident-lawyers/drunk-driver-accident/',
	// No head-on sub-type exists under car accidents; the pillar is the honest
	// destination rather than the motorcycle head-on page, which is a different
	// crash type.
	'/car-accident-lawyers/head-on-collision/'      => '/practice-areas/car-accident-lawyers/',

	// ── Renamed / replaced content ─────────────────────────────────────────
	'/resources/dean-forest-road-truck-accidents-savannah/' => '/resources/dean-forest-road-truck-accidents-pooler/',
	'/blog/can-you-recover-damages-if-you-have-a-pre-existing-injury/' => '/blog/recovering-damages-with-pre-existing-injuries/',
	'/blog/can-a-car-accident-lawyer-help-with-claiming-insurance-benefits/' => '/blog/personal-injury-lawsuit-vs-insurance-claim/',
);

// Refuse to point anything at a URL that does not resolve.
echo "--- destination check ---\n";
$bad = 0;
foreach ( array_unique( array_values( $MAP ) ) as $dest ) {
	if ( ! url_to_postid( home_url( $dest ) ) ) {
		echo "DESTINATION DOES NOT RESOLVE: $dest\n";
		$bad++;
	}
}
if ( $bad ) { echo "ABORTING — $bad bad destination(s)\n"; return; }
echo "all " . count( array_unique( array_values( $MAP ) ) ) . " destinations resolve\n\n";

$ids = get_posts( array(
	'post_type'   => array( 'post', 'page', 'resource', 'practice_area', 'location', 'attorney', 'case_result' ),
	'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids',
) );

$backup = array();
$counts = array();
$touched = 0;

foreach ( $ids as $id ) {
	$post = get_post( $id );
	$kt   = get_post_meta( $id, '_roden_key_takeaways', true );
	$fq   = get_post_meta( $id, '_roden_faqs', true );

	$surfaces = array(
		'post_content'         => $post->post_content,
		'_roden_key_takeaways' => $kt,
		'_roden_faqs'          => $fq,
	);

	foreach ( $surfaces as $sn => $orig ) {
		$is_array = is_array( $orig );
		$hay      = $is_array ? wp_json_encode( $orig, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : (string) $orig;
		if ( '' === $hay ) { continue; }

		$new = $hay;
		foreach ( $MAP as $old => $dest ) {
			// Both href forms, and only as a complete href value: a bare
			// str_replace on '/car-accident-lawyers/' would also rewrite every
			// sub-type URL that begins with it.
			foreach ( array( 'href="', "href='" ) as $q ) {
				$term = substr( $q, -1 );
				foreach ( array( $old, 'https://rodenlaw.com' . $old, 'http://rodenlaw.com' . $old ) as $form ) {
					$needle = $q . $form . $term;
					$repl   = $q . ( 0 === strpos( $form, 'http' ) ? 'https://rodenlaw.com' . $dest : $dest ) . $term;
					$n = substr_count( $new, $needle );
					if ( $n ) {
						$new = str_replace( $needle, $repl, $new );
						$counts[ $old ] = ( $counts[ $old ] ?? 0 ) + $n;
					}
				}
			}
			// JSON-escaped form inside meta: href=\"...\"
			foreach ( array( $old, 'https://rodenlaw.com' . $old ) as $form ) {
				$needle = 'href=\\"' . $form . '\\"';
				$repl   = 'href=\\"' . ( 0 === strpos( $form, 'http' ) ? 'https://rodenlaw.com' . $dest : $dest ) . '\\"';
				$n = substr_count( $new, $needle );
				if ( $n ) {
					$new = str_replace( $needle, $repl, $new );
					$counts[ $old ] = ( $counts[ $old ] ?? 0 ) + $n;
				}
			}
		}

		if ( $new === $hay ) { continue; }

		$backup[] = array( 'id' => $id, 'surface' => $sn, 'before' => $hay );
		$touched++;

		if ( ! $APPLY ) { continue; }

		if ( 'post_content' === $sn ) {
			$res = wp_update_post( array( 'ID' => $id, 'post_content' => $new ), true );
			if ( is_wp_error( $res ) ) { echo "ERROR $id: " . $res->get_error_message() . "\n"; }
		} elseif ( $is_array ) {
			$dec = json_decode( $new, true );
			if ( ! is_array( $dec ) ) { echo "ERROR $id/$sn: re-decode failed, skipped\n"; continue; }
			update_post_meta( $id, $sn, $dec );
		} else {
			update_post_meta( $id, $sn, $new );
		}
	}
	unset( $post );
}

arsort( $counts );
echo ( $APPLY ? '--- applied ---' : '--- dry run ---' ) . "\n";
foreach ( $counts as $old => $n ) { printf( "%4d  %s\n", $n, $old ); }
echo "\nsurfaces touched: $touched   total link rewrites: " . array_sum( $counts ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload ---\n";
	$j = wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? 'ENCODE FAILED' : $j;
	echo "\n";
}
