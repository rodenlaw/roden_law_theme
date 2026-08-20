<?php
/**
 * Clear _roden_why_hire on the Spanish intersection pages so their own bodies render.
 *
 * templates/template-intersection.php resolves that section as:
 *
 *     own _roden_why_hire   >   post_content   >   parent pillar's _roden_why_hire
 *
 * All 38 published Spanish intersection pages were seeded on 2026-07-06 with
 * BOTH a body and a why_hire, so the body has never rendered. This is not a
 * regression — nothing changed for visitors — but the hidden half is the better
 * half, and it is better on exactly the axis these pages compete on.
 *
 * On /es/car-accident-lawyers/charleston-sc/:
 *
 *   hidden body (1,191 chars)  I-26 and I-526, the Crosstown, the Ravenel
 *                              bridge, King and Market Street with rideshare
 *                              and horse carriages sharing narrow lanes, the
 *                              King Street office, S.C. Code § 15-3-530, and a
 *                              warning that camera footage disappears in weeks
 *
 *   visible why_hire (637)     a general "insurers know who is represented"
 *                              pitch, the "no cobramos honorarios a menos que
 *                              ganemos" fee claim, and a hardcoded phone number
 *
 * Clearing the meta makes the body render, which also matches how every English
 * intersection page behaves — those show their bodies. The inconsistency was
 * costing the Spanish pages their most locally specific content against a
 * competitor whose Spanish mirror is machine-translated.
 *
 * Two incidental improvements: it removes 38 instances of a regulated fee claim
 * that was added without a disclaimer, and 38 hardcoded phone numbers, both of
 * which are already rendered correctly elsewhere on the page from firm-data.
 * Every one of the 38 bodies carries its own phone or CTA — verified before
 * writing this — so no call to action is lost.
 *
 * The copy is preserved in data/es-why-hire-before-clear-2026-08-20.json, keyed
 * by post ID and URL, so any of it can be merged into the bodies later.
 *
 * Refuses to clear a page with no substantial body, which would drop it to the
 * generic pillar fallback. 0 pages hit that guard at time of writing.
 *
 * Run from the repo over stdin:
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/clear-es-why-hire.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/clear-es-why-hire.php
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
	"SELECT p.ID, p.post_title, p.post_content, m.meta_value AS mk
	 FROM {$wpdb->posts} p
	 JOIN {$wpdb->postmeta} m ON m.post_id = p.ID AND m.meta_key = '_roden_pa_office_key'
	 JOIN {$wpdb->postmeta} l ON l.post_id = p.ID AND l.meta_key = '_roden_locale' AND l.meta_value = 'es'
	 WHERE p.post_type = 'practice_area' AND p.post_status = 'publish'
	 ORDER BY p.ID"
);

printf( "%s  %d published Spanish intersection pages\n\n", $apply ? 'APPLY' : 'DRY RUN', count( $rows ) );

$cleared  = 0;
$refused  = 0;
$restored = 0;

foreach ( $rows as $r ) {
	$wh = (string) get_post_meta( $r->ID, '_roden_why_hire', true );
	if ( '' === $wh ) {
		continue;
	}

	$body_len = strlen( trim( $r->post_content ) );

	// Never drop a page to the generic pillar fallback.
	if ( $body_len <= 200 ) {
		printf( "  REFUSED  #%-6d %-46s no body to fall back to\n", $r->ID, mb_substr( $r->post_title, 0, 44 ) );
		$refused++;
		continue;
	}

	// A body with no route to contact would be a regression of its own.
	if ( ! preg_match( '/\(\d{3}\)\s?\d{3}-\d{4}|Llame/iu', $r->post_content ) ) {
		printf( "  REFUSED  #%-6d %-46s body has no phone or CTA\n", $r->ID, mb_substr( $r->post_title, 0, 44 ) );
		$refused++;
		continue;
	}

	if ( ! $apply ) {
		printf( "  would clear #%-6d %-44s reveals %s chars of body\n",
			$r->ID, mb_substr( $r->post_title, 0, 42 ), number_format( $body_len ) );
		$cleared++;
		$restored += $body_len;
		continue;
	}

	delete_post_meta( $r->ID, '_roden_why_hire' );

	if ( '' !== (string) get_post_meta( $r->ID, '_roden_why_hire', true ) ) {
		printf( "  ERROR    #%-6d meta did not clear\n", $r->ID );
		continue;
	}
	$after = get_post( $r->ID );
	if ( strlen( trim( $after->post_content ) ) !== $body_len ) {
		printf( "  ERROR    #%-6d body length changed (%d -> %d)\n", $r->ID, $body_len, strlen( trim( $after->post_content ) ) );
		continue;
	}
	printf( "  cleared  #%-6d %-44s %s chars now render\n",
		$r->ID, mb_substr( $r->post_title, 0, 42 ), number_format( $body_len ) );
	$cleared++;
	$restored += $body_len;
}

printf( "\n%s\n", str_repeat( '-', 78 ) );
printf( "%s : %d pages\n", $apply ? 'cleared' : 'to clear', $cleared );
printf( "body content %s : %s characters\n", $apply ? 'now rendering' : 'to reveal', number_format( $restored ) );
printf( "refused : %d\n", $refused );

if ( $apply ) {
	printf( "\nNext: wp cache flush && wp page-cache flush.\n" );
	printf( "_roden_why_hire is not in the export whitelist, so content/meta.json is unaffected.\n" );
} else {
	printf( "\nDry run. Re-run with `apply` to write.\n" );
}
