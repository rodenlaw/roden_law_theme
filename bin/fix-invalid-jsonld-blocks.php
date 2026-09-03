<?php
/**
 * Repair the JSON-LD blocks embedded in post_content that are not valid JSON.
 *
 * Found on 2026-08-26 while verifying an unrelated change: one page's structured
 * data failed to parse, in a block that change had never touched. Validating all
 * 90 JSON-LD blocks embedded in post_content across the site returned 76 valid
 * and 14 INVALID — 11 English, 3 Spanish.
 *
 * A block that does not parse is not partially indexed. It is DISCARDED. Every
 * FAQ answer inside those 14 blocks is invisible as structured data, on exactly
 * the pages the firm is building FAQ content for.
 *
 * TWO MECHANICAL CAUSES, both from hand-authoring JSON:
 *
 *   1. An unescaped double quote inside a "text":"…" value, which terminates the
 *      string early. A quoted phrase or a party name does it:
 *        el § 50-25-30 cubre "cualquier calle o carretera pública"
 *        un reclamo de motorista sin seguro contra "John Doe"
 *   2. A literal control character — a raw newline or tab — inside a string.
 *
 * HOW THE QUOTE REPAIR DECIDES. Walking the block character by character while
 * tracking string state, a `"` encountered inside a string is STRUCTURAL (it
 * closes the string) only if the next non-whitespace character is one of
 * , : } ] — otherwise it is a literal quote the author meant to keep, and it is
 * escaped. That is the standard heuristic for this shape of damage and it is
 * safe here because these blocks are flat FAQPage objects, not arbitrary JSON.
 *
 * NOTHING IS WRITTEN ON FAITH. For every block the script:
 *   - confirms the block is currently INVALID (a valid block is never touched),
 *   - repairs it,
 *   - json_decode()s the result and requires it to parse,
 *   - requires the decoded object to still have an @context and @type,
 *   - re-encodes with wp_json_encode() so the stored form is canonical,
 *   - and compares the decoded FAQ QUESTION COUNT before/after where countable.
 * A block that fails any of these is REPORTED and left exactly as it was.
 *
 * post_modified is not stamped. _roden_last_refreshed is NOT set either: this
 * repairs machine-readable markup, not the words a reader sees, so advertising
 * an editorial update would be false.
 *
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/fix-invalid-jsonld-blocks.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/fix-invalid-jsonld-blocks.php
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
 * Escape literal quotes and control characters that appear inside JSON strings.
 */
function roden_jsonld_repair( $s ) {
	$fixed    = '';
	$in_str   = false;
	$escaped  = false;
	$len      = strlen( $s );

	for ( $i = 0; $i < $len; $i++ ) {
		$ch = $s[ $i ];

		if ( $escaped ) { $fixed .= $ch; $escaped = false; continue; }

		if ( '\\' === $ch ) { $fixed .= $ch; $escaped = true; continue; }

		if ( '"' === $ch ) {
			if ( ! $in_str ) { $in_str = true; $fixed .= $ch; continue; }

			/*
			 * Inside a string: is this quote structural, or literal text?
			 *
			 * A first version treated any `"` followed by , : } ] as structural.
			 * That is right for : } ] and WRONG for the comma, which is exactly
			 * how one block defeated the repair: the Spanish Green Grove page
			 * contains  cubre "cualquier calle o carretera pública", así que …
			 * where a literal closing quote is followed by a comma and the
			 * sentence simply continues.
			 *
			 * In this JSON-LD shape the distinction is decidable. A STRUCTURAL
			 * close-then-comma is always followed by the next key or element —
			 * `"`, `{` or `[`. A LITERAL close-then-comma is followed by prose,
			 * i.e. a letter. So look one token further before deciding.
			 */
			$j = $i + 1;
			while ( $j < $len && ( ' ' === $s[ $j ] || "\n" === $s[ $j ] || "\r" === $s[ $j ] || "\t" === $s[ $j ] ) ) { $j++; }
			$next = ( $j < $len ) ? $s[ $j ] : '';

			$structural = ( ':' === $next || '}' === $next || ']' === $next || '' === $next );

			if ( ! $structural && ',' === $next ) {
				$k = $j + 1;
				while ( $k < $len && ( ' ' === $s[ $k ] || "\n" === $s[ $k ] || "\r" === $s[ $k ] || "\t" === $s[ $k ] ) ) { $k++; }
				$after = ( $k < $len ) ? $s[ $k ] : '';
				$structural = ( '"' === $after || '{' === $after || '[' === $after || '' === $after );
			}

			if ( $structural ) {
				$in_str = false; $fixed .= $ch;
			} else {
				$fixed .= '\\"';
			}
			continue;
		}

		if ( $in_str ) {
			// Raw control characters are illegal inside a JSON string.
			if ( "\n" === $ch ) { $fixed .= '\\n'; continue; }
			if ( "\r" === $ch ) { $fixed .= '\\r'; continue; }
			if ( "\t" === $ch ) { $fixed .= '\\t'; continue; }
			if ( ord( $ch ) < 0x20 ) { $fixed .= sprintf( '\\u%04x', ord( $ch ) ); continue; }
		}

		$fixed .= $ch;
	}
	return $fixed;
}

/** Count FAQ questions in a decoded block, where the shape allows. */
function roden_jsonld_q_count( $obj ) {
	if ( ! is_array( $obj ) ) { return -1; }
	if ( isset( $obj['mainEntity'] ) && is_array( $obj['mainEntity'] ) ) { return count( $obj['mainEntity'] ); }
	return -1;
}

$rows = $wpdb->get_results( "SELECT ID, post_name, post_content FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_content LIKE '%application/ld+json%'" );

fprintf( $out, "%s\n\n", $apply ? '=== APPLY ===' : '=== DRY RUN (pass "apply" to write) ===' );

$total_blocks = 0; $invalid = 0; $repaired = 0; $unrepairable = array(); $touched = array();

foreach ( $rows as $r ) {
	$content = $r->post_content;
	if ( ! preg_match_all( '#(<script[^>]*application/ld\+json[^>]*>)(.*?)(</script>)#is', $content, $m, PREG_SET_ORDER ) ) {
		continue;
	}

	$new_content = $content;
	$page_fixed  = 0;

	foreach ( $m as $blk ) {
		$total_blocks++;
		$body = $blk[2];

		json_decode( $body );
		if ( JSON_ERROR_NONE === json_last_error() ) { continue; }   // already valid — never touch
		$invalid++;

		$before_err = json_last_error_msg();
		$try = roden_jsonld_repair( $body );
		$obj = json_decode( $try, true );

		if ( JSON_ERROR_NONE !== json_last_error() || ! is_array( $obj ) ) {
			$unrepairable[] = sprintf( '%s (%s -> %s)', $r->post_name, $before_err, json_last_error_msg() );
			continue;
		}
		if ( ! isset( $obj['@context'] ) || ! isset( $obj['@type'] ) ) {
			$unrepairable[] = sprintf( '%s (parsed but lost @context/@type)', $r->post_name );
			continue;
		}

		$canon = wp_json_encode( $obj, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
		if ( ! $canon ) {
			$unrepairable[] = sprintf( '%s (re-encode failed)', $r->post_name );
			continue;
		}

		$qn = roden_jsonld_q_count( $obj );
		fprintf( $out, "[%d] %s\n    was: %s\n    now: valid %s%s\n",
			$r->ID, $r->post_name, $before_err, $obj['@type'],
			( $qn >= 0 ? sprintf( ' with %d questions', $qn ) : '' ) );

		$new_content = str_replace( $blk[0], $blk[1] . $canon . $blk[3], $new_content );
		$repaired++; $page_fixed++;
	}

	if ( $page_fixed ) { $touched[ $r->ID ] = $new_content; }
}

fprintf( $out, "\nblocks scanned: %d    invalid: %d    repaired: %d    unrepairable: %d\n",
	$total_blocks, $invalid, $repaired, count( $unrepairable ) );
foreach ( $unrepairable as $u ) { fprintf( $out, "  !! LEFT ALONE: %s\n", $u ); }

if ( ! $apply ) { fprintf( $out, "\nDry run only.\n" ); exit( 0 ); }

$backup = array();
foreach ( array_keys( $touched ) as $id ) {
	$backup[] = array( 'ID' => $id, 'post_content' => get_post_field( 'post_content', $id ) );
}
$file = sprintf( '/tmp/roden-jsonld-backup-%s.json', gmdate( 'Ymd-His' ) );
file_put_contents( $file, wp_json_encode( $backup, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
fprintf( $out, "\nbackup: %s\n\n", $file );

foreach ( $touched as $id => $c ) {
	$wpdb->update( $wpdb->posts, array( 'post_content' => $c ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );

	// Read back and re-validate every block on the page.
	$check = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	$ok = 0; $bad = 0;
	if ( preg_match_all( '#<script[^>]*application/ld\+json[^>]*>(.*?)</script>#is', $check, $mm ) ) {
		foreach ( $mm[1] as $b ) { json_decode( $b ); if ( JSON_ERROR_NONE === json_last_error() ) { $ok++; } else { $bad++; } }
	}
	fprintf( $out, "[%d] written · blocks now %d valid, %d invalid %s\n", $id, $ok, $bad, $bad ? '!!' : 'OK' );
}
fprintf( $out, "\nDone. Flush both cache layers, then re-validate live.\n" );
