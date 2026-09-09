<?php
/**
 * Removes the last claim that the SC Tort Claims Act imposes a mandatory
 * pre-suit notice. It does not.
 *
 * § 15-78-110  the action is barred unless commenced within TWO YEARS of the
 *              date the loss was or should have been discovered.
 * § 15-78-80   IF a verified claim is filed, it must be received within ONE
 *              year. Filing is OPTIONAL and extends the deadline to three years.
 *
 * There is no notice a claimant must serve before suing. Two pages said
 * otherwise, in the two shapes that survive a phrase sweep:
 *
 *   /blog/carriage-tour-accidents-downtown-charleston-liability/
 *     "You must file a written notice with the governmental entity before
 *      bringing suit. Failing to comply with these notice requirements can bar
 *      your claim entirely." — flatly false, and it tells a reader with a live
 *      claim that they have already lost it.
 *
 *   /blog/ben-sawyer-boulevard-bridge-accidents-sullivans-island/
 *     "require filing within two years and compliance with specific notice
 *      procedures (S.C. Code § 15-78-80)" — the two years is right and belongs to
 *      § 15-78-110; attaching "notice procedures" to § 15-78-80 turns the
 *      optional verified claim into a requirement.
 *
 * PR #95 (2026-08-26) closed this class across 44 pages and was never merged, so
 * its scripts never entered the repo. These two are what it did not reach. The
 * same PR also recorded the § 15-78-50 miscitation that stayed live until #117 —
 * a finding written down in an unmerged pull request is a finding nobody has.
 *
 * Uses wp_slash(); see the Gotchas section of CLAUDE.md for why.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/fix-sctca-mandatory-notice.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

$EDITS = array(
	array( 'carriage-tour-accidents-downtown-charleston-liability',
		'Claims against the <strong>City of Charleston</strong> under the South Carolina Tort Claims Act have additional requirements. You must file a written notice with the governmental entity before bringing suit. Failing to comply with these notice requirements can bar your claim entirely, regardless of how strong the underlying case may be.',
		'Claims against the <strong>City of Charleston</strong> under the South Carolina Tort Claims Act run on a shorter clock. The action must be commenced within <strong>two years</strong> of the date the loss was or should have been discovered (S.C. Code § 15-78-110) rather than the usual three. Filing a verified claim with the entity within one year (S.C. Code § 15-78-80) is optional and extends the deadline back to three years. Missing the two-year deadline can bar your claim entirely, regardless of how strong the underlying case may be.' ),

	array( 'ben-sawyer-boulevard-bridge-accidents-sullivans-island',
		'claims against SCDOT or municipal governments under the South Carolina Tort Claims Act require filing within <strong>two years</strong> and compliance with specific notice procedures (S.C. Code § 15-78-80)',
		'claims against SCDOT or municipal governments under the South Carolina Tort Claims Act must be brought within <strong>two years</strong> of discovery (S.C. Code § 15-78-110); filing a verified claim within one year (S.C. Code § 15-78-80) is optional and extends that to three' ),

	array( 'ben-sawyer-boulevard-bridge-accidents-sullivans-island',
		'Because government liability claims have shorter notice requirements and more complex procedures,',
		'Because government liability claims run on a shorter deadline and more complex procedures,' ),
);

$backup = array(); $ok = true; $seen = array(); $n = 0;

foreach ( $EDITS as $i => $e ) {
	list( $slug, $old, $new ) = $e;
	$p = get_page_by_path( $slug, OBJECT, array( 'post', 'page', 'resource', 'practice_area' ) );
	if ( ! $p ) { echo "MISSING $slug\n"; $ok = false; continue; }

	$c = get_post_field( 'post_content', $p->ID );
	$hits = substr_count( $c, $old );
	if ( 1 !== $hits ) {
		if ( false !== strpos( $c, $new ) ) { echo "SKIP  #$i — already applied\n"; continue; }
		echo "REFUSE #$i $slug — expected 1, found $hits\n"; $ok = false; continue;
	}

	if ( ! isset( $seen[ $p->ID ] ) ) { $backup[] = array( 'id' => $p->ID, 'surface' => 'post_content', 'before' => $c ); $seen[ $p->ID ] = true; }
	$n++;
	printf( "%s #%d  %s\n", $APPLY ? 'APPLY ' : 'DRYRUN', $i, $slug );

	if ( ! $APPLY ) { continue; }
	$r = wp_update_post( wp_slash( array( 'ID' => $p->ID, 'post_content' => str_replace( $old, $new, $c ) ) ), true );
	if ( is_wp_error( $r ) ) { echo "   ERROR " . $r->get_error_message() . "\n"; $ok = false; }
}

if ( $APPLY ) {
	echo "\n--- verify ---\n";
	$left = 0;
	foreach ( $EDITS as $e ) {
		$p = get_page_by_path( $e[0], OBJECT, array( 'post', 'page', 'resource', 'practice_area' ) );
		if ( $p && false !== strpos( $p->post_content, $e[1] ) ) { echo "STILL PRESENT: {$e[0]}\n"; $left++; $ok = false; }
	}
	echo ( 0 === $left ) ? "all edits verified\n" : "$left remaining\n";

	// Writing with wp_slash() must not have disturbed any JSON-LD on these pages.
	foreach ( array_keys( $seen ) as $pid ) {
		$c = get_post_field( 'post_content', $pid );
		if ( ! preg_match_all( '#<script type="application/ld\+json">(.*?)</script>#is', $c, $m ) ) { continue; }
		foreach ( $m[1] as $blk ) {
			json_decode( trim( $blk ), true );
			printf( "  post %d JSON-LD: %s\n", $pid, ( JSON_ERROR_NONE === json_last_error() ) ? 'valid' : 'INVALID' );
			if ( JSON_ERROR_NONE !== json_last_error() ) { $ok = false; }
		}
	}
}

echo "\n" . wp_json_encode( array( 'applied' => $APPLY, 'edits' => $n, 'pages' => count( $backup ), 'ok' => $ok ) ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload ---\n";
	$j = wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? 'ENCODE FAILED' : $j;
	echo "\n";
}
