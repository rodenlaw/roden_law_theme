<?php
/**
 * Correct two live blog posts that state Georgia seat-belt law wrongly.
 *
 * WHAT WAS WRONG
 * --------------
 * Georgia's SB 68, approved 2025-04-21, revised O.C.G.A. § 40-8-76.1(d). The
 * signed bill strikes "shall not be considered evidence of negligence ... and
 * shall not be evidence used to diminish any recovery" and replaces it with
 * language making seat-belt non-use admissible on negligence, comparative
 * negligence, causation, assumption of risk and apportionment, and usable to
 * diminish recovery — subject to O.C.G.A. § 24-4-403. Per Section 9 of the Act
 * this reaches causes of action pending on the effective date, not just crashes
 * after it.
 *
 *   #1759 /blog/compensation-while-not-wearing-seat-belt/
 *     Said "Georgia law does not allow for the seat belt defense" and quoted the
 *     struck statutory language as current. Affirmatively wrong. Last modified
 *     2025-05-08 — 17 days after the bill was signed.
 *
 *   #2647 /blog/rollover-crashes-and-what-they-do-to-your-body/
 *     Two errors. It said Georgia evidence "can reduce your recovery by up to
 *     5%" — no percentage cap appears anywhere in SB 68, and prior law barred
 *     the evidence entirely, so the figure had no basis before or after. And it
 *     said South Carolina non-use "can also be considered but is generally
 *     limited," when S.C. Code § 56-5-6540(C) (2025) provides that a violation
 *     "is not negligence per se or contributory negligence, and is not
 *     admissible as evidence in a civil action."
 *
 * The site was telling visitors both that Georgia bars the seat belt defense and
 * that it allows it with a 5% cap. Both statements were live simultaneously.
 *
 * HOW IT EDITS
 * ------------
 * Exact-match str_replace, never preg_replace. The replacement text contains
 * "§" and could easily contain "$"; a "$" in a preg_replace replacement has
 * silently eaten content on this site before, so the whole class is avoided.
 *
 * Each edit asserts the search string occurs EXACTLY once before replacing, and
 * verifies afterwards that the new text is present, the old text is gone, and
 * the post length changed by the expected delta. Any failure aborts that edit
 * without touching the others.
 *
 * Idempotent: a post whose content already contains the guard string is skipped.
 *
 *   ssh <prod> "wp --path=<site> eval-file -" < /tmp/fix.php          # dry run
 *   ssh <prod> "wp --path=<site> eval-file - apply" < /tmp/fix.php    # apply
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}
if ( ! defined( 'RODEN_SEED_JSON' ) ) {
	fwrite( STDERR, "RODEN_SEED_JSON is not defined.\n" );
	exit( 1 );
}

$mode = isset( $args[0] ) ? $args[0] : 'dry-run';
if ( ! in_array( $mode, array( 'dry-run', 'apply' ), true ) ) {
	fwrite( STDERR, "Unknown mode '$mode'. Use dry-run | apply.\n" );
	exit( 1 );
}

$payload = json_decode( RODEN_SEED_JSON, true );
if ( ! is_array( $payload ) ) {
	fwrite( STDERR, 'Payload is not valid JSON: ' . json_last_error_msg() . "\n" );
	exit( 1 );
}
$guard = $payload['guard'];

echo "mode: $mode\n" . str_repeat( '=', 66 ) . "\n";

$applied = 0;
$skipped = 0;
$failed  = 0;

foreach ( $payload['edits'] as $e ) {
	$id   = (int) $e['post_id'];
	$post = get_post( $id );

	echo "\n#### #$id — {$e['label']}\n";

	if ( ! $post ) {
		echo "  FAIL   post not found\n";
		$failed++;
		continue;
	}
	echo "  url:     " . get_permalink( $id ) . "\n";
	echo "  status:  {$post->post_status}\n";

	$content = $post->post_content;

	if ( false !== strpos( $content, $guard ) ) {
		echo "  SKIP   already contains the guard string ('$guard') — corrected previously\n";
		$skipped++;
		continue;
	}

	$hits = substr_count( $content, $e['find'] );
	if ( 1 !== $hits ) {
		echo "  FAIL   expected exactly 1 match for the search string, found $hits\n";
		echo "         (content drifted — re-derive the search string before retrying)\n";
		$failed++;
		continue;
	}
	echo "  match:   1 occurrence, " . strlen( $e['find'] ) . " chars\n";

	$new      = str_replace( $e['find'], $e['replace'], $content );
	$expected = strlen( $content ) - strlen( $e['find'] ) + strlen( $e['replace'] );
	echo "  length:  " . strlen( $content ) . " -> " . strlen( $new )
		. " (expected $expected)\n";

	echo "  REMOVING: " . substr( wp_strip_all_tags( $e['find'] ), 0, 150 ) . "…\n";
	echo "  ADDING:   " . substr( wp_strip_all_tags( $e['replace'] ), 0, 150 ) . "…\n";

	if ( 'dry-run' === $mode ) {
		continue;
	}

	$res = wp_update_post( array( 'ID' => $id, 'post_content' => $new ), true );
	if ( is_wp_error( $res ) ) {
		echo '  FAIL   ' . $res->get_error_message() . "\n";
		$failed++;
		continue;
	}

	// Verify against what actually landed, not against what we sent.
	$after = get_post( $id )->post_content;
	$ok    = ( false !== strpos( $after, $e['replace'] ) )
		&& ( false === strpos( $after, $e['find'] ) )
		&& ( strlen( $after ) === $expected );
	if ( ! $ok ) {
		echo "  FAIL   post-write verification failed — inspect #$id by hand\n";
		$failed++;
		continue;
	}
	echo "  OK     replacement present, old text gone, length matches\n";
	$applied++;
}

echo "\n" . str_repeat( '=', 66 ) . "\n";
echo "applied: $applied   skipped: $skipped   failed: $failed\n";
if ( 'dry-run' === $mode ) {
	echo "DRY RUN — nothing written. Re-run with: apply\n";
}
exit( $failed > 0 ? 1 : 0 );
