<?php
/**
 * Second pass on the South Carolina punitive-damages claims. Two classes, found
 * because the first pass on each was scoped too narrowly.
 *
 * CLASS 1 — the cap, again. bin/fix-sc-punitive-cap-claim.php (2026-09-03,
 * earlier the same day) swept for fixed needles: "no statutory cap", "does not
 * cap", "uncapped" and a dozen more. It missed "does not IMPOSE A statutory
 * cap", which is how three further pages phrase it, and it missed two bad-faith
 * comparison tables that write "no fixed cap". A regex over negation-near-cap
 * finds all of them; a needle list finds the ones you thought of.
 *
 * One of the three is /boating-accident-lawyers/boating-under-influence/, whose
 * _roden_faqs was corrected in that earlier pass while its post_content was
 * left asserting the opposite. That is the four-surfaces rule in CLAUDE.md
 * catching the very script written to honour it.
 *
 * The bad-faith tables are not an exception: S.C. Code § 15-32-540 excludes only
 * the Tort Claims Act and the Solicitation of Charitable Funds Act from the
 * punitive article. A bad-faith action against an insurer is not excluded, so
 * § 15-32-530 caps punitive damages there too.
 *
 * CLASS 2 — the authority. #97 corrected two pages citing § 15-33-135 for the
 * CAP. The statute is one sentence, headed "Punitive damages: burden of proof":
 *
 *   "In any civil action where punitive damages are claimed, the plaintiff has
 *    the burden of proving such damages by clear and convincing evidence."
 *
 * It says nothing about willful, wanton or reckless conduct. That is
 * § 15-32-520(D): "Punitive damages may be awarded only if the plaintiff proves
 * by clear and convincing evidence that his harm was the result of the
 * defendant's wilful, wanton, or reckless conduct."
 *
 * Nine citations of § 15-33-135 survive on seven pages. Four are correct and are
 * left alone — they cite it for the burden, which is exactly what it holds.
 * Three attribute the CONDUCT standard to it and are re-pointed. Two more sit
 * after a compound clause where only half is supported; those gain § 15-32-520
 * alongside rather than losing § 15-33-135, because the burden half really is
 * § 15-33-135.
 *
 * All statutory text read against scstatehouse.gov/code/t15c032.php and
 * /t15c033.php on 2026-09-03.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/fix-sc-punitive-authority-and-cap.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

$edits = array(

	// ── CLASS 1: the cap stated as absent ────────────────────────────────
	array( 4534, 'post_content',
		'South Carolina does <em>not</em> impose a statutory cap on punitive damages, although courts may review awards for reasonableness under constitutional due process standards.',
		'South Carolina caps punitive damages at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530), and courts may review awards for reasonableness under constitutional due process standards on top of that limit. The cap does not apply where the defendant intended to harm the claimant, was convicted of a felony arising from the same conduct, or acted under the influence (§ 15-32-530(C)).' ),

	array( 3440, 'post_content',
		'South Carolina does <strong>not impose a statutory cap on punitive damages</strong>, but the South Carolina Supreme Court has held',
		'South Carolina <strong>caps punitive damages at the greater of three times compensatory damages or $500,000</strong> (S.C. Code § 15-32-530), and the South Carolina Supreme Court has separately held' ),

	array( 4144, 'post_content',
		'South Carolina does not impose a statutory cap but requires clear and convincing evidence of willful, wanton, or reckless conduct — a standard readily met in BUI cases.',
		'South Carolina caps punitive damages at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530) and requires clear and convincing evidence of willful, wanton, or reckless conduct — a standard readily met in BUI cases. Where the operator was under the influence to a degree that substantially impaired judgment, § 15-32-530(C) removes the cap.' ),

	array( 1719, 'post_content',
		'<td>Available; can be substantial (no fixed statutory cap)</td>',
		'<td>Available; capped at the greater of 3x compensatory damages or $500,000 (S.C. Code § 15-32-530)</td>' ),

	array( 1720, 'post_content',
		'<td>Compensatory, consequential, and punitive damages (no fixed cap)</td>',
		'<td>Compensatory and consequential damages (uncapped); punitive damages capped by S.C. Code § 15-32-530</td>' ),

	// ── CLASS 2a: § 15-33-135 cited for the conduct standard ─────────────
	array( 1756, 'post_content',
		'Under <strong>S.C. Code § 15-33-135</strong>, South Carolina allows punitive damages when the defendant\'s conduct was "willful, wanton, or in reckless disregard of the plaintiff\'s rights." The burden of proof is <strong>clear and convincing evidence</strong>.',
		'Under <strong>S.C. Code § 15-32-520(D)</strong>, South Carolina allows punitive damages only where the plaintiff proves that the harm was the result of the defendant\'s "wilful, wanton, or reckless conduct." The burden of proof is <strong>clear and convincing evidence</strong> (S.C. Code § 15-33-135).' ),

	array( 4534, 'post_content',
		'Under S.C. Code § 15-33-135, punitive damages may be awarded only when the defendant\'s conduct was willful, wanton, or reckless',
		'Under S.C. Code § 15-32-520(D), punitive damages may be awarded only if the plaintiff proves by clear and convincing evidence that the harm resulted from the defendant\'s willful, wanton, or reckless conduct' ),

	array( 4478, 'post_content',
		'<li><strong>Punitive damages</strong> — available in cases involving drunk driving, reckless conduct, or willful misconduct (S.C. Code § 15-33-135)</li>',
		'<li><strong>Punitive damages</strong> — available for willful, wanton, or reckless conduct such as drunk driving, on clear and convincing evidence (S.C. Code § 15-32-520(D))</li>' ),

	// ── CLASS 2b: compound cites completed, not replaced ─────────────────
	array( 1810, 'post_content',
		'proven by clear and convincing evidence (S.C. Code § 15-33-135).',
		'proven by clear and convincing evidence (S.C. Code §§ 15-32-520(D), 15-33-135).' ),

	array( 4189, 'post_content',
		'willful, wanton, or reckless conduct by clear and convincing evidence (S.C. Code § 15-33-135).',
		'willful, wanton, or reckless conduct by clear and convincing evidence (S.C. Code §§ 15-32-520(D), 15-33-135).' ),
);

$backup = array();
$ok     = true;
$seen   = array();

foreach ( $edits as $n => $e ) {
	list( $id, $surface, $old, $new ) = $e;

	$post = get_post( $id );
	if ( ! $post ) {
		echo "MISSING post $id\n";
		$ok = false;
		continue;
	}

	// Two edits touch post 4534. Read the CURRENT value each time so the second
	// sees the first one's write rather than a stale copy.
	$current = get_post_field( 'post_content', $id );

	$hits = substr_count( $current, $old );
	if ( 1 !== $hits ) {
		echo "REFUSE #$n $id/$surface — expected 1 occurrence, found $hits\n";
		$ok = false;
		continue;
	}
	if ( false !== strpos( $current, $new ) ) {
		echo "SKIP #$n $id/$surface — replacement already present\n";
		continue;
	}

	if ( ! isset( $seen[ $id ] ) ) {
		$backup[]     = array( 'id' => $id, 'surface' => $surface, 'before' => $current );
		$seen[ $id ]  = true;
	}

	echo ( $APPLY ? 'APPLY ' : 'DRYRUN' ) . " #$n  $id\n";
	echo "   -  " . substr( $old, 0, 150 ) . "\n";
	echo "   +  " . substr( $new, 0, 150 ) . "\n";

	if ( ! $APPLY ) {
		continue;
	}

	$res = wp_update_post( array( 'ID' => $id, 'post_content' => str_replace( $old, $new, $current ) ), true );
	if ( is_wp_error( $res ) ) {
		echo "   ERROR " . $res->get_error_message() . "\n";
		$ok = false;
	}
}

if ( $APPLY ) {
	echo "\n--- verify ---\n";
	foreach ( $edits as $n => $e ) {
		list( $id, $surface, $old, $new ) = $e;
		$now     = get_post_field( 'post_content', $id );
		$gone    = false === strpos( $now, $old );
		$present = false !== strpos( $now, $new );
		printf( "%s #%-2d %d  old_gone=%s new_present=%s\n",
			( $gone && $present ) ? 'OK  ' : 'FAIL', $n, $id,
			$gone ? 'yes' : 'NO', $present ? 'yes' : 'NO' );
		if ( ! $gone || ! $present ) {
			$ok = false;
		}
	}
}

echo "\n" . json_encode( array( 'applied' => $APPLY, 'edits' => count( $edits ), 'posts' => count( $seen ), 'ok' => $ok ) ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload ---\n";
	$j = json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? ( 'ENCODE FAILED: ' . json_last_error_msg() ) : $j;
	echo "\n";
}
