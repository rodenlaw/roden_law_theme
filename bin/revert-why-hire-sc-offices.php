<?php
/**
 * Revert the _roden_why_hire backfill on the 91 SC office intersection pages.
 *
 * The backfill (PR #43) was built on a wrong premise. templates/template-intersection.php
 * resolves the Why Hire section in this order:
 *
 *     own _roden_why_hire   >   post_content   >   parent pillar's _roden_why_hire
 *
 * I read that as "these pages inherit generic two-state pillar copy". They did
 * not. All 91 have their own post_content — a median of 3,793 characters of
 * hand-written, locally specific prose — and that is what was rendering. The
 * pillar fallback was never reached.
 *
 * Setting _roden_why_hire made the first branch win, so a ~500-character block
 * now renders in place of the page's real body. Across the 91 pages that hid
 * 375,878 characters of published content.
 *
 * Deleting the meta restores the previous rendering exactly: with no own
 * why_hire, the template falls through to post_content, which is untouched.
 * Nothing was overwritten by the backfill — it only added a meta key — so the
 * revert is complete and lossless.
 *
 * The 35 NEW town pages are deliberately NOT reverted. They have no
 * post_content, so their own why_hire is the only thing standing between them
 * and the generic pillar fallback. There the original reasoning holds.
 *
 * The copy itself is not lost: it stays in
 * data/why-hire-sc-offices-2026-08-19.json. Whether any of it is worth merging
 * into the existing bodies is a content decision, not a revert.
 *
 * Run from the repo over stdin:
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/revert-why-hire-sc-offices.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/revert-why-hire-sc-offices.php
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
	 WHERE p.post_type = 'practice_area'
	   AND p.post_status = 'publish'
	   AND m.meta_value IN ('charleston','north-charleston','columbia','myrtle-beach')
	 ORDER BY p.ID"
);

printf( "%s\n\n", $apply ? 'APPLY' : 'DRY RUN' );

$reverted = 0;
$kept     = 0;
$restored = 0;

foreach ( $rows as $r ) {
	if ( get_post_meta( $r->ID, '_roden_locale', true ) ) {
		continue; // Spanish pages were never touched by the backfill
	}
	$wh = (string) get_post_meta( $r->ID, '_roden_why_hire', true );
	if ( '' === $wh ) {
		continue;
	}

	$body_len = strlen( trim( $r->post_content ) );

	// Only revert where a real body exists to fall back to. A page with no
	// body would drop to the generic pillar copy, which is worse than what it
	// has now — so it keeps its block.
	if ( $body_len <= 200 ) {
		printf( "  KEEP     #%-6d %-46s no body to fall back to\n", $r->ID, mb_substr( $r->post_title, 0, 44 ) );
		$kept++;
		continue;
	}

	if ( ! $apply ) {
		printf( "  revert   #%-6d %-46s restores %s chars of body\n",
			$r->ID, mb_substr( $r->post_title, 0, 44 ), number_format( $body_len ) );
		$reverted++;
		$restored += $body_len;
		continue;
	}

	delete_post_meta( $r->ID, '_roden_why_hire' );
	if ( '' !== (string) get_post_meta( $r->ID, '_roden_why_hire', true ) ) {
		printf( "  ERROR    #%-6d meta did not clear\n", $r->ID );
		continue;
	}
	// Confirm the body is still intact — the backfill never touched it, but verify.
	$after = get_post( $r->ID );
	if ( strlen( trim( $after->post_content ) ) !== $body_len ) {
		printf( "  ERROR    #%-6d body length changed (%d -> %d)\n", $r->ID, $body_len, strlen( trim( $after->post_content ) ) );
		continue;
	}
	printf( "  reverted #%-6d %-46s %s chars restored\n",
		$r->ID, mb_substr( $r->post_title, 0, 44 ), number_format( $body_len ) );
	$reverted++;
	$restored += $body_len;
}

printf( "\n%s\n", str_repeat( '-', 76 ) );
printf( "%s : %d pages\n", $apply ? 'reverted' : 'to revert', $reverted );
printf( "body content %s : %s characters\n", $apply ? 'restored' : 'to restore', number_format( $restored ) );
printf( "kept (no body to fall back to) : %d\n", $kept );

if ( $apply ) {
	printf( "\nNext: wp cache flush && wp page-cache flush.\n" );
	printf( "_roden_why_hire is not in the export whitelist, so content/meta.json is unaffected.\n" );
} else {
	printf( "\nDry run. Re-run with `apply` to write.\n" );
}
