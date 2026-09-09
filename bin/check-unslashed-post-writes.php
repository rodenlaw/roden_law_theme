<?php
/**
 * Guard: no script in bin/ may call wp_update_post() or wp_insert_post() with
 * unslashed data, and every embedded JSON-LD block on the site must parse.
 *
 * Both halves of the same bug. wp_update_post() and wp_insert_post() call
 * wp_unslash() on what you hand them, so passing content straight back from the
 * database silently eats every backslash in it. On 2026-09-08 that stripped the
 * \" escapes out of four inline JSON-LD FAQPage blocks and dropped 24 questions
 * out of the structured data, with nothing visible in the dry run — the string
 * being inspected was correct, and WordPress damaged it afterwards.
 *
 * It only bites on content that happens to contain a backslash, so a script can
 * run clean against three hundred posts and corrupt four. That is exactly the
 * shape of bug a standing check is for.
 *
 * Run it two ways:
 *
 *   php bin/check-unslashed-post-writes.php            # static scan, no WordPress
 *   ssh $H "wp --path=... eval-file -" < bin/check-unslashed-post-writes.php
 *                                                     # also validates live JSON-LD
 *
 * Exit status is 1 if either check fails, so it can gate a deploy.
 */

$root = dirname( __DIR__ );
$dir  = $root . '/bin';
$fail = 0;

/* ---------- 1. static scan of bin/ ---------- */

$files = glob( $dir . '/*.php' );
$sites = 0;
$bad   = array();

/*
 * A scan that cannot see the files reports zero, not "unknown". Piped over stdin
 * with `wp eval-file -` the script is not on disk, __DIR__ points at WP-CLI's
 * temp path, and glob() returns nothing — which printed "call sites: 0 ... PASS"
 * and looked like a clean bill of health. Say so instead.
 */
if ( ! $files ) {
	echo "STATIC SCAN SKIPPED — no PHP files found under $dir\n";
	echo "  (running over stdin? run `php bin/check-unslashed-post-writes.php`\n";
	echo "   from a checkout for the static half.)\n";
}

foreach ( $files as $f ) {
	$src = file_get_contents( $f );

	/*
	 * Blank out comments so prose about the bug is not mistaken for the bug —
	 * REPLACING EACH WITH SPACES OF THE SAME LENGTH, not deleting them. Deleting
	 * shifts every later byte offset, and the offsets found in the masked copy
	 * are then used to slice the ORIGINAL. The first version of this check did
	 * exactly that and reported all 40 patched call sites as still unslashed.
	 */
	$blank  = function ( $m ) { return str_repeat( ' ', strlen( $m[0] ) ); };
	$masked = preg_replace_callback( '#/\*.*?\*/#s', $blank, $src );
	$masked = preg_replace_callback( '#^\s*//.*$#m', $blank, $masked );

	if ( ! preg_match_all( '/\bwp_(?:update|insert)_post\s*\(/', $masked, $m, PREG_OFFSET_CAPTURE ) ) {
		continue;
	}

	foreach ( $m[0] as $hit ) {
		$open = $hit[1] + strlen( $hit[0] ) - 1;

		// Span of the first argument, respecting nested parentheses.
		$depth = 0; $end = null;
		for ( $i = $open, $n = strlen( $src ); $i < $n; $i++ ) {
			$c = $src[ $i ];
			if ( '(' === $c ) { $depth++; }
			elseif ( ')' === $c ) { $depth--; if ( 0 === $depth ) { $end = $i; break; } }
			elseif ( ',' === $c && 1 === $depth ) { $end = $i; break; }
		}
		if ( null === $end ) { continue; }

		$sites++;
		if ( false === strpos( substr( $src, $open, $end - $open ), 'wp_slash' ) ) {
			$line = substr_count( substr( $src, 0, $open ), "\n" ) + 1;
			$bad[] = basename( $f ) . ':' . $line;
		}
	}
}

if ( $files ) {
	printf( "call sites: %d   unslashed: %d\n", $sites, count( $bad ) );
}
foreach ( $bad as $b ) { echo "  UNSLASHED  $b\n"; }
if ( $bad ) { $fail = 1; }

/* ---------- 2. live JSON-LD validity, when WordPress is loaded ---------- */

if ( function_exists( 'get_post_field' ) ) {
	global $wpdb;
	$ids = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_content LIKE '%application/ld+json%'" );
	$tot = 0; $inv = 0;
	foreach ( $ids as $id ) {
		$c = get_post_field( 'post_content', $id );
		if ( ! preg_match_all( '#<script type="application/ld\+json">(.*?)</script>#is', $c, $mm ) ) { continue; }
		foreach ( $mm[1] as $blk ) {
			$tot++;
			json_decode( trim( $blk ), true );
			if ( JSON_ERROR_NONE !== json_last_error() ) {
				$inv++;
				printf( "  INVALID JSON-LD  %d  %s\n", $id, wp_make_link_relative( get_permalink( $id ) ) );
			}
		}
	}
	printf( "embedded JSON-LD blocks: %d   invalid: %d\n", $tot, $inv );
	if ( $inv ) { $fail = 1; }
} else {
	echo "(WordPress not loaded — static scan only)\n";
}

echo $fail ? "\nFAIL\n" : "\nPASS\n";
exit( $fail );
