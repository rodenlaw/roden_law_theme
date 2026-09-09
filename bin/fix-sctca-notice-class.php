<?php
/**
 * Finishes the class PR #95 opened: the SC Tort Claims Act does not impose a
 * pre-suit notice, and ten published statements said or implied it does.
 *
 * § 15-78-110  the action is barred unless commenced within TWO YEARS of the
 *              date the loss was or should have been discovered.
 * § 15-78-80   IF a verified claim is filed it must be received within ONE year.
 *              Filing is OPTIONAL and extends the deadline to three years.
 *
 * There is no notice to serve, nothing that is fatal to miss, and no "notice
 * deadline" for a reader to look for. What the Act actually does is SHORTEN the
 * limitation period from three years to two, with an optional filing that buys
 * the third year back. Every replacement below says that.
 *
 * WHY THIS CLASS SURVIVED. #95 fixed 72 instances across 44 pages on 2026-08-26
 * and was never merged, so its scripts never entered the repo and nobody could
 * re-run them. These are the phrasings it did not reach — and its PR body also
 * recorded the § 15-78-50 miscitation that then stayed live until #117. A finding
 * written down only in an unmerged pull request is a finding nobody has.
 *
 * THE ASSERTIVENESS VARIES AND ALL OF IT IS WRONG:
 *
 *   4635  a bulleted "Key requirements" list beginning "Written notice to the
 *         government entity" — the most assertive form, and cited to § 15-78-80
 *   4617  "notice requirements are strict — you must notify the government
 *         within a specific timeframe"
 *   1716  "specific notice requirements that vary depending on whether you are
 *         suing a state agency or a local government" — invents a distinction
 *   3624  "a much shorter Tort Claims Act notice deadline applies", on
 *         /car-accident-lawyers/charleston-sc/
 *   4226  "Both states impose shorter notice deadlines" — true of Georgia's ante
 *         litem, false of South Carolina, and the sentence covers both
 *
 * NOT CHANGED: Georgia's ante litem notice (O.C.G.A. §§ 36-33-5, 36-11-1,
 * 50-21-26), the federal FTCA administrative claim, and the § 15-79-125 medical
 * malpractice Notice of Intent. All three are real, mandatory notices and several
 * pages state them correctly, sometimes in the same sentence as the SCTCA. Every
 * anchor below is scoped tightly enough to leave them alone.
 *
 * Uses wp_slash(); see the Gotchas section of CLAUDE.md.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/fix-sctca-notice-class.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

$TWO = 'the action must be brought within two years of discovery (S.C. Code § 15-78-110), with an optional verified claim filed within one year extending that to three (S.C. Code § 15-78-80)';

$EDITS = array(
	array( 4358, 'post_content',
		'which imposes a $600,000 cap on damages per occurrence and requires specific notice procedures.',
		'which imposes a $600,000 cap on damages per occurrence and cuts the filing deadline to two years (S.C. Code § 15-78-110), with an optional verified claim filed within one year extending it to three (S.C. Code § 15-78-80).' ),

	array( 4370, 'post_content',
		'These claims have a two-year filing deadline and require specific notice procedures, so consulting an attorney quickly is important.',
		'These claims have a two-year filing deadline (S.C. Code § 15-78-110) rather than the usual three; filing a verified claim within one year (S.C. Code § 15-78-80) is optional and restores the third year. Consulting an attorney quickly is important.' ),

	array( 1716, 'post_content',
		'You must file your claim within two years, and there are specific notice requirements that vary depending on whether you are suing a state agency or a local government.',
		'You must bring the action within two years of the date the loss was or should have been discovered (S.C. Code &sect; 15-78-110). Filing a verified claim with the entity within one year (S.C. Code &sect; 15-78-80) is optional and extends the deadline to three years.' ),

	array( 4617, '_roden_faqs',
		'However, notice requirements are strict — you must notify the government within a specific timeframe, making prompt legal consultation essential.',
		'However, the deadline is shorter: the action must be brought within two years of discovery (S.C. Code § 15-78-110) rather than the usual three, and only an optional verified claim filed within one year (S.C. Code § 15-78-80) restores the third year.' ),

	array( 4226, 'post_content',
		'Both states impose shorter notice deadlines than standard personal injury claims, making prompt legal action essential.',
		'Georgia requires ante litem notice; South Carolina imposes no notice at all but shortens the filing deadline to two years, so both states demand prompt legal action.' ),

	array( 4353, 'post_content',
		'These claims have strict procedural requirements and shorter notice deadlines, so early legal consultation is essential.',
		'These claims run on a shorter clock — two years from discovery rather than three (S.C. Code § 15-78-110) — so early legal consultation is essential.' ),

	array( 3624, 'post_content',
		'a much shorter Tort Claims Act notice deadline applies',
		'a much shorter Tort Claims Act deadline applies — two years from discovery (S.C. Code § 15-78-110)' ),

	array( 5049, 'post_content',
		'Shorter notice deadlines, damage caps',
		'Two-year deadline, damage caps' ),

	array( 4085, '_roden_faqs',
		'Claims against public schools are subject to state tort claims act requirements and notice deadlines.',
		'Claims against public schools are subject to state tort claims act requirements and shorter filing deadlines.' ),

	// Second pass. The first fixed 3624's BODY and left its FAQ saying the same
	// thing — the four-surfaces rule in CLAUDE.md, missed inside the very script
	// written to close this class. 4750 and 4617 carried additional sentences the
	// first anchor set did not reach.
	array( 3624, '_roden_faqs',
		'a much shorter Tort Claims Act notice deadline can apply, so it is best to contact an attorney quickly.',
		'a much shorter Tort Claims Act deadline applies — two years from discovery (S.C. Code § 15-78-110) rather than three — so it is best to contact an attorney quickly.' ),

	array( 4750, 'post_content',
		'but Tort Claims Act notice deadlines can be far shorter.',
		'but the Tort Claims Act cuts that to two years (S.C. Code Ann. § 15-78-110).' ),

	array( 4750, 'post_content',
		'claims under the South Carolina Tort Claims Act can carry shorter notice and filing deadlines, so you should confirm the specific deadline that applies to your crash.',
		'claims under the South Carolina Tort Claims Act must be brought within two years of discovery (S.C. Code Ann. § 15-78-110) rather than three, so you should confirm the specific deadline that applies to your crash.' ),

	array( 4750, 'post_content',
		'the South Carolina Tort Claims Act can impose shorter notice and filing deadlines, so confirm the specific deadline that applies to your International Boulevard crash',
		'the South Carolina Tort Claims Act cuts the filing deadline to two years from discovery (S.C. Code Ann. § 15-78-110), so confirm the specific deadline that applies to your International Boulevard crash' ),

	array( 4617, 'post_content',
		'but these require a <strong>shorter notice period</strong> under the South Carolina Tort Claims Act',
		'but these run on a <strong>shorter deadline</strong> — two years from discovery rather than three — under the South Carolina Tort Claims Act' ),

	array( 4635, 'post_content',
		"<li>Written notice to the government entity</li>\n<li>Strict compliance with notice procedures</li>",
		"<li>A two-year deadline to bring the action, rather than the usual three (S.C. Code § 15-78-110)</li>\n<li>An optional verified claim, filed within one year, that extends the deadline to three years (S.C. Code § 15-78-80)</li>" ),
);

$backup = array(); $ok = true; $seen = array(); $n = 0;

foreach ( $EDITS as $i => $e ) {
	list( $id, $sn, $old, $new ) = $e;

	if ( 'post_content' === $sn ) {
		$cur = get_post_field( 'post_content', $id );
		$is_array = false;
	} else {
		$cur = get_post_meta( $id, $sn, true );
		$is_array = is_array( $cur );
		$cur = $is_array ? wp_json_encode( $cur, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : (string) $cur;
	}

	$hits = substr_count( $cur, $old );
	if ( 1 !== $hits ) {
		if ( false !== strpos( $cur, $new ) ) { echo "SKIP  #$i $id — already applied\n"; continue; }
		echo "REFUSE #$i $id/$sn — expected 1, found $hits\n"; $ok = false; continue;
	}

	$key = $id . '/' . $sn;
	if ( ! isset( $seen[ $key ] ) ) { $backup[] = array( 'id' => $id, 'surface' => $sn, 'before' => $cur ); $seen[ $key ] = true; }
	$n++;
	printf( "%s #%-2d %-6d %s\n", $APPLY ? 'APPLY ' : 'DRYRUN', $i, $id, wp_make_link_relative( get_permalink( $id ) ) );

	if ( ! $APPLY ) { continue; }

	$upd = str_replace( $old, $new, $cur );
	if ( 'post_content' === $sn ) {
		$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $upd ) ), true );
		if ( is_wp_error( $r ) ) { echo "   ERROR " . $r->get_error_message() . "\n"; $ok = false; }
	} elseif ( $is_array ) {
		$dec = json_decode( $upd, true );
		if ( ! is_array( $dec ) ) { echo "   ERROR re-decode failed\n"; $ok = false; continue; }
		update_post_meta( $id, $sn, $dec );
	} else {
		update_post_meta( $id, $sn, $upd );
	}
}

if ( $APPLY ) {
	echo "\n--- verify ---\n";
	$left = 0;
	foreach ( $EDITS as $e ) {
		list( $id, $sn, $old ) = $e;
		$v = ( 'post_content' === $sn ) ? get_post_field( 'post_content', $id ) : get_post_meta( $id, $sn, true );
		$v = is_array( $v ) ? wp_json_encode( $v, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : (string) $v;
		if ( false !== strpos( $v, $old ) ) { printf( "STILL PRESENT: %d/%s\n", $id, $sn ); $left++; $ok = false; }
	}
	echo ( 0 === $left ) ? "all edits verified\n" : "$left remaining\n";

	// The writes must not have disturbed any embedded JSON-LD.
	global $wpdb;
	$tot = 0; $bad = 0;
	foreach ( $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_content LIKE '%application/ld+json%'" ) as $pid ) {
		$c = get_post_field( 'post_content', $pid );
		if ( ! preg_match_all( '#<script type="application/ld\+json">(.*?)</script>#is', $c, $m ) ) { continue; }
		foreach ( $m[1] as $b ) { $tot++; json_decode( trim( $b ), true ); if ( JSON_ERROR_NONE !== json_last_error() ) { $bad++; } }
	}
	printf( "embedded JSON-LD: %d blocks, %d invalid\n", $tot, $bad );
	if ( $bad ) { $ok = false; }
}

echo "\n" . wp_json_encode( array( 'applied' => $APPLY, 'edits' => $n, 'surfaces' => count( $seen ), 'ok' => $ok ) ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload ---\n";
	$j = wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? 'ENCODE FAILED' : $j;
	echo "\n";
}
