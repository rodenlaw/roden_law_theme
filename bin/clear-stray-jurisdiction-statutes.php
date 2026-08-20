<?php
/**
 * Clear the opposite state's statute-of-limitations meta from intersection pages.
 *
 * Five pillars are scoped to `both` and carry BOTH _roden_sol_ga and
 * _roden_sol_sc: bicycle, electric-scooter, ATV/side-by-side, golf-cart, and
 * the Spanish bicycle pillar. When their intersection pages were created, both
 * keys were copied down — so a Savannah page carries S.C. Code § 15-3-530 and a
 * Charleston page carries O.C.G.A. § 9-3-33, each alongside its correct one.
 *
 * 25 pages: GA/en 8, GA/es 2, SC/en 12, SC/es 3.
 *
 * This does not currently render. Templates resolve the filing deadline from
 * the page's jurisdiction, so the wrong statute sits unused in the meta —
 * verified on /car-accident-lawyers/savannah-ga/ and
 * /golf-cart-accident-lawyers/darien-ga/, neither of which shows S.C. Code
 * anywhere in the output.
 *
 * It is cleared anyway because this is the exact fuel for the bug CLAUDE.md
 * records as having recurred five times: four templates share the practice-area
 * rendering, and any one of them reading the wrong key — or a future template
 * doing so — publishes a Georgia deadline on a South Carolina page. The meta
 * should not contain a statute the page can never correctly use.
 *
 * bin/seed-sc-intersections.php was already fixed to inherit only the matching
 * statute (PR #41), so newly seeded pages do not reproduce this. This cleans up
 * the pages that predate that fix.
 *
 * The five PILLARS are deliberately untouched. They are genuinely two-state
 * pages and both statutes belong on them. Only pages carrying a
 * _roden_pa_office_key — which pins them to one market, and therefore one
 * state — are eligible.
 *
 * Refuses to clear a page whose own statute is missing, rather than leaving it
 * with no deadline at all.
 *
 * Run from the repo over stdin:
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/clear-stray-jurisdiction-statutes.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/clear-stray-jurisdiction-statutes.php
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

global $wpdb;
$apply = isset( $args[0] ) && 'apply' === $args[0];

$rows = $wpdb->get_results(
	"SELECT p.ID, p.post_title, par.post_name AS pillar, m.meta_value AS mk
	 FROM {$wpdb->posts} p
	 JOIN {$wpdb->postmeta} m ON m.post_id = p.ID AND m.meta_key = '_roden_pa_office_key'
	 JOIN {$wpdb->posts} par ON par.ID = p.post_parent
	 WHERE p.post_type = 'practice_area' AND p.post_status = 'publish'
	 ORDER BY p.ID"
);

printf( "%s  %d published intersection pages\n\n", $apply ? 'APPLY' : 'DRY RUN', count( $rows ) );

$cleared = 0;
$refused = 0;
$groups  = array();

foreach ( $rows as $r ) {
	$market = roden_market( $r->mk );
	if ( ! $market ) {
		printf( "  SKIP     #%-6d market '%s' does not resolve\n", $r->ID, $r->mk );
		continue;
	}
	$state = $market['state'];
	$lang  = get_post_meta( $r->ID, '_roden_locale', true ) ? 'es' : 'en';

	$wrong_key = ( 'GA' === $state ) ? '_roden_sol_sc' : '_roden_sol_ga';
	$right_key = ( 'GA' === $state ) ? '_roden_sol_ga' : '_roden_sol_sc';

	$wrong = (string) get_post_meta( $r->ID, $wrong_key, true );
	$right = (string) get_post_meta( $r->ID, $right_key, true );

	if ( '' === $wrong ) {
		continue;
	}

	// Never leave a page with no deadline.
	if ( '' === $right ) {
		printf( "  REFUSED  #%-6d %-44s has only %s — clearing would leave no deadline\n",
			$r->ID, mb_substr( $r->post_title, 0, 42 ), $wrong_key );
		$refused++;
		continue;
	}

	$groups[ "$state/$lang" ] = ( $groups[ "$state/$lang" ] ?? 0 ) + 1;

	if ( ! $apply ) {
		printf( "  would clear #%-6d %-42s %s (%s)  keeps %s\n",
			$r->ID, mb_substr( $r->post_title, 0, 40 ), $wrong_key, $wrong, $right );
		$cleared++;
		continue;
	}

	delete_post_meta( $r->ID, $wrong_key );

	$after_wrong = (string) get_post_meta( $r->ID, $wrong_key, true );
	$after_right = (string) get_post_meta( $r->ID, $right_key, true );
	if ( '' !== $after_wrong ) {
		printf( "  ERROR    #%-6d %s did not clear\n", $r->ID, $wrong_key );
		continue;
	}
	if ( $after_right !== $right ) {
		printf( "  ERROR    #%-6d %s changed unexpectedly (%s -> %s)\n", $r->ID, $right_key, $right, $after_right );
		continue;
	}
	printf( "  cleared  #%-6d %-42s %s  keeps %s\n",
		$r->ID, mb_substr( $r->post_title, 0, 40 ), $wrong_key, $after_right );
	$cleared++;
}

printf( "\n%s\n", str_repeat( '-', 78 ) );
printf( "%s : %d\n", $apply ? 'cleared' : 'to clear', $cleared );
printf( "refused (would leave no deadline) : %d\n", $refused );
foreach ( $groups as $g => $n ) {
	printf( "  %-8s %d\n", $g, $n );
}

if ( $apply ) {
	// Independent re-scan.
	$left = 0;
	foreach ( $rows as $r ) {
		$market = roden_market( $r->mk );
		if ( ! $market ) { continue; }
		$wrong_key = ( 'GA' === $market['state'] ) ? '_roden_sol_sc' : '_roden_sol_ga';
		if ( '' !== (string) get_post_meta( $r->ID, $wrong_key, true ) ) { $left++; }
	}
	printf( "\nre-scan: intersection pages still carrying the wrong state's statute: %d\n", $left );
	printf( "\nNext: regenerate content/meta.json — _roden_sol_ga and _roden_sol_sc are both\n" );
	printf( "in the export whitelist, so the snapshot will have drifted.\n" );
} else {
	printf( "\nDry run. Re-run with `apply` to write.\n" );
}
