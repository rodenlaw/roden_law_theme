<?php
/**
 * Stamp `_roden_last_reviewed` after an attorney has actually reviewed a page.
 *
 * This exists so the field is easy to set correctly, and hard to set wrongly.
 * It is NOT a backfill tool. Setting the field asserts an attorney checked the
 * page, and licenses `reviewedBy` in schema; schema-helpers.php is explicit that
 * "asserting a review that may not have happened is not a trust signal worth
 * manufacturing." Pass only pages a lawyer has genuinely worked through.
 *
 * GUARDS
 *   - The date must be ISO Y-m-d and must not be in the future.
 *   - Every post must exist and be published.
 *   - Every post must carry `_roden_author_attorney` resolving to a published
 *     attorney, because the review date is what turns that attribution into a
 *     `reviewedBy` claim. No attorney, no stamp.
 *   - BAR CHECK: if the page's `_roden_jurisdiction` is South Carolina and the
 *     bylined attorney is not admitted there (or vice versa), the entry is
 *     refused. This is the failure the 2026-07-21 correction exists for, and it
 *     is worse once a review date makes it a formal reviewedBy assertion.
 *
 * PAYLOAD  { "date": "2026-08-07", "post_ids": [123, 456] }
 *
 *   SEEDER=set-last-reviewed.php bin/es-build-seed.sh ids.json > /tmp/rev.php
 *   ssh <prod> "wp --path=<site> eval-file -" < /tmp/rev.php          # dry run
 *   ssh <prod> "wp --path=<site> eval-file - apply" < /tmp/rev.php
 *
 * Idempotent: a post already carrying the same date is skipped.
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

$p = json_decode( RODEN_SEED_JSON, true );
if ( ! is_array( $p ) || empty( $p['post_ids'] ) || empty( $p['date'] ) ) {
	fwrite( STDERR, "Payload needs {date, post_ids[]}.\n" );
	exit( 1 );
}

$date = trim( $p['date'] );
if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ) {
	fwrite( STDERR, "FATAL: date '$date' is not ISO Y-m-d. The QA gate and the template both require that form.\n" );
	exit( 1 );
}
if ( strtotime( $date ) > time() ) {
	fwrite( STDERR, "FATAL: date '$date' is in the future.\n" );
	exit( 1 );
}

/** Which state(s) an attorney post is admitted in, from firm-data. */
function roden_rev_bar_states( $atty_name ) {
	$firm = function_exists( 'roden_firm_data' ) ? roden_firm_data() : array();
	foreach ( (array) ( $firm['attorneys'] ?? array() ) as $a ) {
		if ( ( $a['name'] ?? '' ) === $atty_name ) {
			return (array) ( $a['bar_admissions'] ?? array() );
		}
	}
	return array();
}

echo "mode: $mode   date: $date\n" . str_repeat( '=', 70 ) . "\n";
$ok = $skip = $fail = 0;

foreach ( $p['post_ids'] as $raw ) {
	$id   = (int) $raw;
	$post = get_post( $id );
	echo "\n#### #$id\n";

	if ( ! $post || 'publish' !== $post->post_status ) {
		echo "  FAIL   not a published post\n";
		$fail++;
		continue;
	}
	echo "  url:    " . wp_make_link_relative( get_permalink( $id ) ) . "\n";

	$cur = trim( (string) get_post_meta( $id, '_roden_last_reviewed', true ) );
	if ( $cur === $date ) {
		echo "  SKIP   already stamped $date\n";
		$skip++;
		continue;
	}

	$atty_id = (int) get_post_meta( $id, '_roden_author_attorney', true );
	$atty    = $atty_id ? get_post( $atty_id ) : null;
	if ( ! $atty || 'attorney' !== $atty->post_type || 'publish' !== $atty->post_status ) {
		echo "  FAIL   no published attorney in _roden_author_attorney — a review date\n";
		echo "         would assert reviewedBy with nobody to attribute it to\n";
		$fail++;
		continue;
	}

	// Bar check against the page's jurisdiction.
	$juris = strtolower( (string) get_post_meta( $id, '_roden_jurisdiction', true ) );
	$bars  = roden_rev_bar_states( $atty->post_title );
	$needs = '';
	if ( false !== strpos( $juris, 'south-carolina' ) || 'sc' === $juris ) {
		$needs = 'South Carolina';
	} elseif ( false !== strpos( $juris, 'georgia' ) || 'ga' === $juris ) {
		$needs = 'Georgia';
	}
	if ( $needs && $bars && ! in_array( $needs, $bars, true ) ) {
		echo "  FAIL   {$atty->post_title} is not admitted in $needs (page jurisdiction: $juris)\n";
		echo "         refusing to assert reviewedBy across a bar line\n";
		$fail++;
		continue;
	}

	printf( "  attorney: %s%s\n", $atty->post_title, $bars ? ' [' . implode( ', ', $bars ) . ']' : '' );
	printf( "  %s -> %s\n", $cur ?: '(unset)', $date );

	if ( 'dry-run' === $mode ) {
		continue;
	}

	update_post_meta( $id, '_roden_last_reviewed', $date );
	if ( trim( (string) get_post_meta( $id, '_roden_last_reviewed', true ) ) !== $date ) {
		echo "  FAIL   write-back verification failed\n";
		$fail++;
		continue;
	}
	echo "  OK     stamped\n";
	$ok++;
}

echo "\n" . str_repeat( '=', 70 ) . "\n";
echo "stamped: $ok   skipped: $skip   failed: $fail\n";
if ( 'dry-run' === $mode ) {
	echo "DRY RUN — nothing written. Re-run with: apply\n";
}
exit( $fail > 0 ? 1 : 0 );
