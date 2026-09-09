<?php
/**
 * Corrects the South Carolina Tort Claims Act deadline, cited to a section that
 * contains no deadline at all.
 *
 * WHAT THE STATUTE ACTUALLY SAYS, read against scstatehouse.gov/code/t15c078.php
 * on 2026-09-09:
 *
 *   § 15-78-50   "Right of injured person to file claim." Establishes the RIGHT
 *                to file. Contains no deadline and no notice requirement.
 *   § 15-78-80   If a verified claim is filed, it "must be received within one
 *                year after the loss was or should have been discovered."
 *                Filing is OPTIONAL; it extends the limitation period.
 *   § 15-78-110  The action is "forever barred unless commenced within two years
 *                after the date the loss was or should have been discovered" —
 *                three years where a verified claim was filed.
 *
 * /blog/rideshare-accident-i-26-tenmile-north-charleston/ said, three times, that
 * "§ 15-78-50 requires written verified notice within two years". That is wrong in
 * three separate ways at once:
 *
 *   1. WRONG SECTION. § 15-78-50 is the right to file, not a deadline.
 *   2. WRONG PERIOD. The verified claim is ONE year, not two. Two years is the
 *      deadline to commence the ACTION.
 *   3. WRONG CHARACTER. The verified claim is OPTIONAL. Presenting it as a
 *      mandatory notice tells a reader their claim is dead when it is not, and
 *      buries the fact that filing one BUYS a third year.
 *
 * The page's own FAQ structured data, in the same post_content, already said
 * "§ 15-78-110 imposes a 2-year filing deadline". The visible prose and the JSON-LD
 * were citing different sections for the same rule. Only the prose was wrong.
 *
 * /blog/litchfield-beach-pawleys-island-us-17-car-accident-georgetown-county/
 * carried the same substantive error without the miscitation: the Act "requires a
 * verified claim filing", and "Missing the SCTCA notice ... ends the claim". It
 * does not require one, and missing it does not end anything — it leaves the
 * claimant with two years instead of three.
 *
 * FOUND while re-reading a page touched by the anchor-text pass, not by a sweep.
 * A sweep for §§ 15-78-40/-50/-100 returned these three; a separate sweep for the
 * verified claim described as mandatory returned three more, of which TWO WERE
 * CORRECT — both attach "must" to the suit deadline and then say "if a verified
 * claim was filed", which is exactly right.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/fix-tca-notice-citation.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

$EDITS = array(
	array( 'rideshare-accident-i-26-tenmile-north-charleston',
		'If a government entity (e.g., SCDOT) is a defendant, written notice is required within 2 years under <strong>S.C. Code § 15-78-50</strong>.',
		'If a government entity (e.g., SCDOT) is a defendant, the Tort Claims Act cuts the deadline to <strong>2 years</strong> (<strong>S.C. Code § 15-78-110</strong>) — or 3 years if a verified claim is filed with the agency within one year of discovery (<strong>S.C. Code § 15-78-80</strong>).' ),

	array( 'rideshare-accident-i-26-tenmile-north-charleston',
		'the <strong>Tort Claims Act</strong> under <strong>S.C. Code § 15-78-50</strong> requires written verified notice within two years — miss it and the governmental claim is extinguished.',
		'the <strong>Tort Claims Act</strong> requires the action to be commenced within <strong>two years</strong> of discovery (<strong>S.C. Code § 15-78-110</strong>) rather than three. Filing a verified claim with the agency within one year (<strong>S.C. Code § 15-78-80</strong>) is optional and extends that to three years — miss the two-year deadline and the governmental claim is extinguished.' ),

	array( 'rideshare-accident-i-26-tenmile-north-charleston',
		'If a government entity is a defendant, § 15-78-50 imposes a <strong>2-year written-notice</strong> requirement — miss it and the claim against that defendant is gone.',
		'If a government entity is a defendant, § 15-78-110 imposes a <strong>2-year</strong> deadline to commence the action, extended to three only if a verified claim is filed within one year of discovery (§ 15-78-80) — miss it and the claim against that defendant is gone.' ),

	array( 'litchfield-beach-pawleys-island-us-17-car-accident-georgetown-county',
		'That statute caps damages and requires a verified claim filing with a far tighter notice window than the general three-year personal-injury rule. Missing the SCTCA notice on a US-17 design-defect theory ends the claim before discovery starts.',
		'That statute caps damages and cuts the deadline to two years from discovery (S.C. Code § 15-78-110), against the general three-year personal-injury rule. Filing a verified claim with the agency within one year (S.C. Code § 15-78-80) is optional and restores the third year. Missing the two-year deadline on a US-17 design-defect theory ends the claim before discovery starts.' ),
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
	$r = wp_update_post( array( 'ID' => $p->ID, 'post_content' => str_replace( $old, $new, $c ) ), true );
	if ( is_wp_error( $r ) ) { echo "   ERROR " . $r->get_error_message() . "\n"; $ok = false; }
}

if ( $APPLY ) {
	echo "\n--- verify ---\n";
	$left = 0;
	foreach ( $EDITS as $e ) {
		$p = get_page_by_path( $e[0], OBJECT, array( 'post', 'page', 'resource', 'practice_area' ) );
		if ( $p && false !== strpos( $p->post_content, $e[1] ) ) { echo "STILL PRESENT: {$e[0]}\n"; $left++; $ok = false; }
	}
	// § 15-78-50 must be gone from the site entirely.
	global $wpdb;
	$rem = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status='publish' AND post_content LIKE '%15-78-50%'" );
	printf( "pages still citing § 15-78-50: %d (expected 0)\n", $rem );
	echo ( 0 === $left ) ? "all edits verified\n" : "$left remaining\n";
	if ( $rem ) { $ok = false; }
}

echo "\n" . wp_json_encode( array( 'applied' => $APPLY, 'edits' => $n, 'pages' => count( $backup ), 'ok' => $ok ) ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload ---\n";
	$j = wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? 'ENCODE FAILED' : $j;
	echo "\n";
}
