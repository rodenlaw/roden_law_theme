<?php
/**
 * Correct the published recovery total from $250M to $300M.
 *
 * The 2026-08-26 legal accuracy audit found the site publishing TWO different
 * recovery totals. `firm-data.php` carries the canonical value —
 * trust_stats['recovered'] => '$300M+' — and it renders on roughly 120 pages
 * through the template. Thirty blog posts instead hard-code the figure into
 * prose, where no derivation can reach it, and they say $250M.
 *
 * Both cannot be true. A verifiable claim about case results, published two
 * ways, engages GA Rule 7.1 and SC Rule 7.1. The firm confirmed on 2026-08-26
 * that $300M is the correct number, so the prose is what moves.
 *
 * TWO SPELLINGS, and the second was nearly missed. The audit's first sweep
 * required the word "million" and found 16 instances on 13 pages. A second pass
 * for "$250M" found 24 more on 19 pages — including NINE Spanish twins that the
 * first regex could not see, because they read "más de $250M recuperados".
 * Same lesson as the four-surface sweep: a pattern that cannot match a spelling
 * does not report "unknown", it reports zero.
 *
 * NEVER preg_replace HERE. The replacement contains "$300", and PHP reads "$3"
 * in a preg_replace replacement as backreference 3 — the exact bug that wrote
 * ",000 and 0,000" onto a live settlement page on 2026-08-03. Every replacement
 * below is str_replace on a literal.
 *
 * One instance lives INSIDE a <script type="application/ld+json"> block in
 * post_content (the FAQPage schema on the Boys Estate post). A plain text swap
 * of one dollar figure for another is safe there — it changes a JSON string
 * value, not the structure — but nothing here may ever insert markup.
 *
 * post_modified is deliberately NOT stamped: this is a factual correction, not
 * a refresh, and advertising thirty posts as freshly updated would be a false
 * freshness signal. Hence the direct $wpdb->update() rather than wp_update_post().
 *
 * WHAT IS NOT CHANGED. The same posts hard-code "62 years of combined
 * experience", "5,000+ cases" and "4.9-star". Those MATCH firm-data.php
 * (experience 62, cases 5,000+, rating 4.9) and are left alone. The
 * "500+ reviews" claim does not match — trust_stats['reviews'] is derived from
 * the live per-office GBP sum precisely so it cannot be hand-kept — but the firm
 * has not confirmed a figure, so it is REPORTED here and corrected by nobody's
 * guess. See bin/fix-hundreds-of-reviews-claim.php for that class.
 *
 * Run from the repo over stdin — never added to the theme:
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/fix-recovery-total-250-to-300.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/fix-recovery-total-250-to-300.php
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

global $wpdb;
$apply = isset( $args[0] ) && 'apply' === $args[0];
$out   = fopen( 'php://stdout', 'w' );

/**
 * Literal swaps, longest first so "$250 million" is consumed before "$250M"
 * could ever be considered. They cannot actually collide — "$250M" is capital-M
 * with no space — but ordering it explicitly means a future edit to this list
 * cannot introduce the overlap by accident.
 */
$swaps = array(
	'$250 million' => '$300 million',
	'$250M'        => '$300M',
);

$rows = $wpdb->get_results(
	"SELECT ID, post_title, post_name, post_content
	   FROM {$wpdb->posts}
	  WHERE post_status = 'publish'
	    AND post_content LIKE '%\$250%'
	  ORDER BY ID ASC"
);

fprintf( $out, "%s\n", $apply ? '=== APPLY ===' : '=== DRY RUN (pass "apply" to write) ===' );
fprintf( $out, "candidate posts containing \"\$250\": %d\n\n", count( $rows ) );

$backup   = array();
$touched  = 0;
$total    = 0;
$residual = array();

foreach ( $rows as $r ) {
	$before = $r->post_content;
	$after  = $before;
	$counts = array();

	foreach ( $swaps as $from => $to ) {
		$n = substr_count( $after, $from );
		if ( $n > 0 ) {
			$after       = str_replace( $from, $to, $after );
			$counts[ $from ] = $n;
			$total      += $n;
		}
	}

	if ( $before === $after ) {
		// Matched the LIKE but none of the known spellings. Report, never guess.
		if ( false !== strpos( $before, '$250' ) ) {
			$residual[] = sprintf( '%d %s (unrecognised $250 spelling)', $r->ID, $r->post_name );
		}
		continue;
	}

	$touched++;
	$backup[] = array( 'ID' => $r->ID, 'post_name' => $r->post_name, 'post_content' => $before );

	$parts = array();
	foreach ( $counts as $from => $n ) {
		$parts[] = sprintf( '%s x%d', $from, $n );
	}
	fprintf( $out, "[%d] %s\n      %s\n", $r->ID, $r->post_name, implode( ' · ', $parts ) );

	if ( ! $apply ) {
		continue;
	}

	// Direct column update: wp_update_post() would stamp post_modified.
	$ok = $wpdb->update(
		$wpdb->posts,
		array( 'post_content' => $after ),
		array( 'ID' => $r->ID ),
		array( '%s' ),
		array( '%d' )
	);

	if ( false === $ok ) {
		fprintf( $out, "      !! DB UPDATE FAILED\n" );
		continue;
	}

	// Read back from the database, not from our own variable.
	$check = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $r->ID ) );
	$stale = substr_count( $check, '$250 million' ) + substr_count( $check, '$250M' );
	$fresh = substr_count( $check, '$300 million' ) + substr_count( $check, '$300M' );
	fprintf( $out, "      read-back: \$300 x%d, \$250 remaining x%d %s\n", $fresh, $stale, $stale ? '!! ' : 'OK' );
}

fprintf( $out, "\nposts touched: %d    replacements: %d\n", $touched, $total );

if ( $residual ) {
	fprintf( $out, "\nREPORTED, NOT CHANGED — \$250 in a shape this script does not recognise:\n" );
	foreach ( $residual as $x ) {
		fprintf( $out, "  %s\n", $x );
	}
}

if ( $apply && $backup ) {
	$file = sprintf( '/tmp/roden-recovery-total-backup-%s.json', gmdate( 'Ymd-His' ) );
	file_put_contents( $file, wp_json_encode( $backup, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
	fprintf( $out, "\nbackup of %d posts written to %s\n", count( $backup ), $file );
}

// Unconfirmed sibling claim on the same posts — surfaced, never guessed at.
$rev = $wpdb->get_col( "SELECT post_name FROM {$wpdb->posts} WHERE post_status='publish' AND post_content LIKE '%500+ reviews%'" );
$rev2 = $wpdb->get_col( "SELECT post_name FROM {$wpdb->posts} WHERE post_status='publish' AND post_content LIKE '%500-plus%review%'" );
$rev = array_unique( array_merge( $rev, $rev2 ) );
if ( $rev ) {
	fprintf( $out, "\nNOT TOUCHED — hand-kept review counts (firm has not confirmed a figure): %d posts\n", count( $rev ) );
}
