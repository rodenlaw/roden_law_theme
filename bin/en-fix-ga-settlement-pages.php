<?php
/**
 * Fix four content issues on the two English Georgia settlement-value pages.
 *
 * Reviewed in docs/en-settlement-value-content-review-2026-08-03.md. All four
 * surfaced while adapting these pages into Spanish — restating every claim line
 * by line is an audit of it.
 *
 *   1. GA car misstates Nestlehutt. The case struck O.C.G.A. § 51-13-1, the
 *      MEDICAL MALPRACTICE noneconomic cap; Georgia never had a general one.
 *      The page's conclusion is right, its stated reason was not — and the GA
 *      truck page already says it correctly, so the pair contradicted itself.
 *      (body + FAQ 4)
 *   2. GA car states "$15,000 and $75,000 for moderate injuries" twice while
 *      its own severity table says Moderate is $25,000-$100,000. Aligned to the
 *      table. (key takeaways + body)
 *   3. GA truck prices Moderate at "low-to-mid six figures" for a description
 *      milder than its siblings' — which omit nothing and charge 2-10x less.
 *      Aligned the description and the band to the sibling pages.
 *   4. GA truck attributes its own statistics as though a third party had
 *      reported them.
 *
 * Every replacement matches an exact expected string (apostrophes allowed to be
 * straight or curly, since wptexturize converts at render time) and requires
 * exactly ONE match. Anything else aborts without writing — if the copy has been
 * edited since the review, a human should look at it rather than a script
 * guessing.
 *
 * ⚠ ALREADY APPLIED 2026-08-03, and it shipped a bug worth not repeating.
 *
 * Two of the replacements below contained literal dollar amounts. PHP reads
 * "$25" and "$100" in a preg_replace REPLACEMENT as backreferences (two digits
 * max), not literals, so "$25,000 and $100,000" was written to the live page as
 * ",000 and 0,000". A third used "$1" against an apostrophe class that was never
 * parenthesised, turning "the firm's" into "the firms". Both were caught by
 * post-apply verification and repaired by bin/en-fix-ga-settlement-repair.php.
 *
 * The strings below are the CORRECTED intent, kept as the record of what was
 * changed and why. Re-running is safe — the "from" patterns no longer match, so
 * it aborts without writing.
 *
 * RULE: never put a "$" in a preg_replace replacement. Use str_replace for
 * literal swaps, or preg_replace_callback and return the string yourself.
 *
 * Usage:
 *   ssh <prod> "wp --path=<site> eval-file -"       < bin/en-fix-ga-settlement-pages.php
 *   ssh <prod> "wp --path=<site> eval-file - apply" < bin/en-fix-ga-settlement-pages.php
 *
 * The database is not in this repo and has no undo. A backup of both pages is in
 * data/es-relink-backups/2026-08-03-en-settlement-pages-before.json.
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}

$mode = isset( $args[0] ) ? $args[0] : 'dry-run';
if ( ! in_array( $mode, array( 'dry-run', 'apply' ), true ) ) {
	fwrite( STDERR, "Unknown mode '$mode'. Use dry-run | apply.\n" );
	exit( 1 );
}

/** Apostrophe class: the DB may hold either form. */
const AP = '[\'\x{2019}]';

$car_id   = url_to_postid( home_url( '/resources/georgia-car-accident-settlement-value/' ) );
$truck_id = url_to_postid( home_url( '/resources/georgia-truck-accident-settlement-value/' ) );
if ( ! $car_id || ! $truck_id ) {
	fwrite( STDERR, "Could not resolve one of the pages.\n" );
	exit( 1 );
}

$edits  = array();
$failed = 0;

/**
 * Register one replacement. $pattern must match exactly once.
 */
$edit = function ( $label, $id, $field, $pattern, $replacement ) use ( &$edits, &$failed ) {
	$edits[] = compact( 'label', 'id', 'field', 'pattern', 'replacement' );
};

/* ── 1. Nestlehutt, GA car ─────────────────────────────────────────────── */

$edit(
	'1a  GA car body — Nestlehutt scope',
	$car_id,
	'post_content',
	'/Georgia places <strong>no cap on compensatory damages<\/strong> in car accident cases — the Georgia Supreme Court struck down the state' . AP . 's noneconomic damages cap in <em>Atlanta Oculoplastic Surgery, P\.C\. v\. Nestlehutt<\/em> \(2010\), so a jury is free to award the full measure of a victim(' . AP . ')s pain and loss\./u',
	'Georgia places <strong>no cap on compensatory damages</strong> in car accident cases, so a jury is free to award the full measure of a victim$1s pain and loss. The only statutory cap on noneconomic damages Georgia enacted applied to medical malpractice claims, and the Georgia Supreme Court struck it down in <em>Atlanta Oculoplastic Surgery, P.C. v. Nestlehutt</em> (2010).'
);

$edit(
	'1b  GA car FAQ 4 — Nestlehutt scope',
	$car_id,
	'_roden_faqs',
	'/No\. Georgia places no cap on compensatory damages in car accident cases — the Georgia Supreme Court struck down the noneconomic damages cap in Atlanta Oculoplastic Surgery v\. Nestlehutt \(2010\)\./u',
	'No. Georgia places no cap on compensatory damages in car accident cases. The only statutory cap on noneconomic damages Georgia enacted applied to medical malpractice claims, and the Georgia Supreme Court struck it down in Atlanta Oculoplastic Surgery v. Nestlehutt (2010).'
);

/* ── 2. GA car settlement band vs its own table ────────────────────────── */

$edit(
	'2a  GA car takeaways — band matches table',
	$car_id,
	'_roden_key_takeaways',
	'/Most Georgia car accident settlements fall between roughly \$15,000 and \$75,000 for moderate injuries/u',
	'Most Georgia car accident settlements fall between roughly $25,000 and $100,000 for moderate injuries'
);

$edit(
	'2b  GA car body — band matches table',
	$car_id,
	'post_content',
	'/Most Georgia car accident settlements fall between roughly <strong>\$15,000 and \$75,000<\/strong> for moderate injuries/u',
	'Most Georgia car accident settlements fall between roughly <strong>$25,000 and $100,000</strong> for moderate injuries'
);

/* ── 3. GA truck Moderate tier ─────────────────────────────────────────── */

$edit(
	'3   GA truck table — Moderate tier',
	$truck_id,
	'post_content',
	'/<tr><td>Moderate<\/td><td>Broken bones, longer treatment, some time off work<\/td><td>Low-to-mid six figures<\/td><\/tr>/u',
	'<tr><td>Moderate</td><td>Broken bones, herniated discs, surgery with recovery</td><td>High five to low six figures</td></tr>'
);

/* ── 4. GA truck self-citation ─────────────────────────────────────────── */

$edit(
	'4   GA truck — self-citation',
	$truck_id,
	'post_content',
	'/According to those publicly reported firm figures, Roden Law' . AP . 's track record reflects substantial experience in serious injury and trucking litigation\./u',
	'These are the firm$1s own reported figures. They reflect substantial experience in serious injury and trucking litigation.'
);

/* ── Run ───────────────────────────────────────────────────────────────── */

// Group by (id, field) so multiple edits to the same field compose.
$buffers = array();
$get = function ( $id, $field ) {
	if ( 'post_content' === $field ) {
		return get_post( $id )->post_content;
	}
	return get_post_meta( $id, $field, true );
};

foreach ( $edits as $e ) {
	$key = $e['id'] . '|' . $e['field'];
	if ( ! isset( $buffers[ $key ] ) ) {
		$buffers[ $key ] = array( 'id' => $e['id'], 'field' => $e['field'], 'value' => $get( $e['id'], $e['field'] ) );
	}

	// FAQs are an array of {question, answer}; operate on the answers.
	if ( '_roden_faqs' === $e['field'] ) {
		$hits = 0;
		foreach ( $buffers[ $key ]['value'] as $i => $f ) {
			$n   = 0;
			$new = preg_replace( $e['pattern'], $e['replacement'], $f['answer'], -1, $n );
			if ( $n ) {
				$buffers[ $key ]['value'][ $i ]['answer'] = $new;
				$hits += $n;
			}
		}
	} else {
		$hits                     = 0;
		$buffers[ $key ]['value'] = preg_replace( $e['pattern'], $e['replacement'], $buffers[ $key ]['value'], -1, $hits );
	}

	if ( 1 !== $hits ) {
		printf( "ABORT  %-42s expected exactly 1 match, found %d\n", $e['label'], $hits );
		$failed++;
	} else {
		printf( "OK     %-42s 1 match\n", $e['label'] );
	}
}

if ( $failed ) {
	printf( "\n%d replacement(s) did not match cleanly. NOTHING WRITTEN.\n", $failed );
	printf( "The copy has changed since the review — re-read it before scripting anything.\n" );
	exit( 1 );
}

if ( 'dry-run' === $mode ) {
	printf( "\nAll %d replacements matched exactly once. Dry run — nothing written.\n", count( $edits ) );
	exit( 0 );
}

foreach ( $buffers as $b ) {
	if ( 'post_content' === $b['field'] ) {
		$res = wp_update_post( array( 'ID' => $b['id'], 'post_content' => $b['value'] ), true );
		if ( is_wp_error( $res ) ) {
			printf( "FAILED post %d: %s\n", $b['id'], $res->get_error_message() );
			exit( 1 );
		}
	} else {
		update_post_meta( $b['id'], $b['field'], $b['value'] );
	}
	printf( "wrote  post %d  %s\n", $b['id'], $b['field'] );
}
update_post_meta( $car_id, '_roden_last_reviewed', gmdate( 'Y-m-d' ) );
update_post_meta( $truck_id, '_roden_last_reviewed', gmdate( 'Y-m-d' ) );

printf( "\nApplied %d replacements across 2 posts.\n", count( $edits ) );
echo "Then: wp cache flush && wp page-cache flush, and regenerate content/meta.json.\n";
