<?php
/**
 * Correct seat-belt-defense claims in _roden_faqs meta.
 *
 * Companion to bin/en-fix-seatbelt-defense-sb68.php, which fixed post_content.
 * That script's rendered-page verification revealed the same claims surviving in
 * FAQ meta — a reminder that on this site prose lives in two places, and the FAQ
 * copy also feeds FAQPage JSON-LD, so wrong law there is served to AI engines as
 * structured data.
 *
 * A sweep of all 894 published posts carrying _roden_faqs found 11 seat-belt FAQs
 * making a jurisdictional claim. Eight are golf-cart/ATV/car-seat content stating
 * that those vehicles lack belts — factual and untouched. Three assert the
 * seat-belt defense rule, and all three are wrong:
 *
 *   #2647 "…In Georgia…can reduce your recovery by up to 5%…In South Carolina,
 *          seatbelt non-use can also be considered but is generally limited…"
 *   #4367 "SC law limits the admissibility…cannot be used to reduce your recovery
 *          by more than a certain percentage under SC case law…"
 *   #4814 "South Carolina law limits how much a failure to wear a seatbelt can be
 *          used against you…"
 *
 * VERIFIED LAW
 *   Georgia — SB 68, approved 2025-04-21, revised O.C.G.A. § 40-8-76.1(d): non-use
 *   may now be admitted on negligence, comparative negligence, causation,
 *   assumption of risk and apportionment, and may diminish recovery, subject to
 *   O.C.G.A. § 24-4-403. No percentage cap appears anywhere in the Act.
 *
 *   South Carolina — S.C. Code § 56-5-6540(C) (2025 Code): a violation "is not
 *   negligence per se or contributory negligence, and is not admissible as
 *   evidence in a civil action." Not "limited" — inadmissible. There is no
 *   percentage.
 *
 * MATCHING STRATEGY
 * Keys on the FAQ index, asserts the question text still matches exactly, and
 * asserts the current answer still contains the expected stale token. All three
 * must hold or the entry is skipped — so a reworded FAQ is never silently
 * overwritten. Replaces the whole answer rather than splicing, since these
 * answers are wrong end to end.
 *
 * Idempotent via the guard: an answer already citing 56-5-6540 is left alone.
 *
 *   ssh <prod> "wp --path=<site> eval-file -" < /tmp/faqfix.php          # dry run
 *   ssh <prod> "wp --path=<site> eval-file - apply" < /tmp/faqfix.php    # apply
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
$applied = $skipped = $failed = 0;

foreach ( $payload['edits'] as $e ) {
	$id  = (int) $e['post_id'];
	$idx = (int) $e['index'];
	echo "\n#### #$id  FAQ index $idx\n";

	$post = get_post( $id );
	if ( ! $post ) {
		echo "  FAIL   post not found\n";
		$failed++;
		continue;
	}
	echo "  url:    " . get_permalink( $id ) . "\n";

	$faqs = get_post_meta( $id, '_roden_faqs', true );
	if ( ! is_array( $faqs ) || ! isset( $faqs[ $idx ] ) ) {
		echo "  FAIL   no _roden_faqs entry at index $idx\n";
		$failed++;
		continue;
	}
	$cur = $faqs[ $idx ];

	if ( false !== strpos( $cur['answer'], $guard ) ) {
		echo "  SKIP   already cites $guard — corrected previously\n";
		$skipped++;
		continue;
	}
	if ( trim( $cur['question'] ) !== trim( $e['expect_question'] ) ) {
		echo "  FAIL   question drifted\n";
		echo "         have: {$cur['question']}\n";
		echo "         want: {$e['expect_question']}\n";
		$failed++;
		continue;
	}
	if ( false === strpos( $cur['answer'], $e['expect_token'] ) ) {
		echo "  FAIL   answer no longer contains the stale token '{$e['expect_token']}'\n";
		$failed++;
		continue;
	}

	echo "  Q:      {$cur['question']}\n";
	echo "  REMOVING: " . substr( $cur['answer'], 0, 165 ) . "…\n";
	echo "  ADDING:   " . substr( $e['answer'], 0, 165 ) . "…\n";

	if ( 'dry-run' === $mode ) {
		continue;
	}

	$faqs[ $idx ]['answer'] = $e['answer'];
	update_post_meta( $id, '_roden_faqs', $faqs );

	$after = get_post_meta( $id, '_roden_faqs', true );
	$ok    = is_array( $after )
		&& isset( $after[ $idx ]['answer'] )
		&& $after[ $idx ]['answer'] === $e['answer']
		&& count( $after ) === count( $faqs )
		&& $after[ $idx ]['question'] === $cur['question'];
	if ( ! $ok ) {
		echo "  FAIL   post-write verification failed — inspect #$id by hand\n";
		$failed++;
		continue;
	}
	echo "  OK     answer replaced; question and FAQ count unchanged (" . count( $after ) . ")\n";
	$applied++;
}

echo "\n" . str_repeat( '=', 66 ) . "\n";
echo "applied: $applied   skipped: $skipped   failed: $failed\n";
if ( 'dry-run' === $mode ) {
	echo "DRY RUN — nothing written. Re-run with: apply\n";
}
exit( $failed > 0 ? 1 : 0 );
