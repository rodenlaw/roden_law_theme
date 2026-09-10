<?php
/**
 * Set _roden_meta_title on posts whose rendered <title> buries the keyword.
 *
 * Payload: { "<permalink path>": "<complete SEO title>" }
 * injected as RODEN_SEED_JSON by bin/build-seo-title-overrides.sh.
 *
 * WHY THESE POSTS
 * ---------------
 * All 1,230 indexed titles were measured by RENDER WIDTH, not character count,
 * against the ~580px Google gives a desktop title. 751 truncate. Almost all of
 * that is harmless:
 *
 *   484  lose only the " – Roden Law" suffix
 *   134  keyword survives, only a trailing qualifier is cut
 *    97  informational posts with no practice keyword either side
 *    36  THE PRACTICE KEYWORD AND CITY FALL PAST THE CUT
 *
 * Only the last group is a defect. Those are the local-SEO long-tail posts
 * titled as questions — "Hurt in a Boat Crash at Bucksport Marina? A Bucksport
 * Boating Accident Lawyer's Guide to the Waccamaw River…" — where the snippet
 * Google renders stops before anything indicates a law firm.
 *
 * "56% of titles exceed 60 characters", the figure this started from, is true
 * and nearly useless: it counts pages whose only loss is the brand suffix
 * alongside pages that lose the keyword. Width, and what survives the cut, is
 * the measure that separates them.
 *
 * THE H1 IS NOT TOUCHED. post_title stays as written; only the <title> changes.
 * Rewriting the headline would fix the snippet and throw away the hook that
 * earns the long-tail query. Same division of labour as _roden_meta_description.
 *
 * Every title in the payload was checked to render under 580px, to contain the
 * practice keyword and the place, and to be unique across the set.
 *
 * Idempotent: a post already carrying the exact value is reported OK.
 * update_post_meta() unslashes, so wp_slash() is required — see CLAUDE.md.
 *
 *   ssh $H "wp --path=$P eval-file -"       < built.php   # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < built.php   # write
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}
if ( ! defined( 'RODEN_SEED_JSON' ) ) {
	fwrite( STDERR, "RODEN_SEED_JSON is not defined - run through bin/build-seo-title-overrides.sh.\n" );
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

echo "mode: $mode\n", str_repeat( '=', 74 ), "\n";

$applied = $already = $failed = 0;
$backup  = array();
$seen    = array();

foreach ( $payload as $path => $title ) {
	$title = trim( (string) $title );

	if ( '' === $title || mb_strlen( $title ) > 70 ) {
		printf( "FAIL  %s\n      title is empty or over 70 characters (%d)\n", $path, mb_strlen( $title ) );
		$failed++;
		continue;
	}
	if ( isset( $seen[ $title ] ) ) {
		printf( "FAIL  %s\n      duplicate title, already used by %s\n", $path, $seen[ $title ] );
		$failed++;
		continue;
	}
	$seen[ $title ] = $path;

	// The whole point is that the keyword is visible; refuse a title without one.
	if ( ! preg_match( '/\b(lawyer|lawyers|attorney|attorneys|abogado|abogados)\b/iu', $title ) ) {
		printf( "FAIL  %s\n      title carries no practice keyword: \"%s\"\n", $path, $title );
		$failed++;
		continue;
	}

	$post_id = url_to_postid( home_url( $path ) );
	if ( ! $post_id ) {
		printf( "FAIL  %s\n      path does not resolve to a post\n", $path );
		$failed++;
		continue;
	}
	$post = get_post( $post_id );
	if ( ! $post || 'publish' !== $post->post_status ) {
		printf( "FAIL  %s\n      post %d is not published\n", $path, $post_id );
		$failed++;
		continue;
	}
	// Spanish posts carry an `es-` slug prefix the permalink path drops.
	$want     = basename( untrailingslashit( $path ) );
	$ok_slugs = array( $want, 'es-' . $want );
	if ( ! in_array( $post->post_name, $ok_slugs, true ) ) {
		printf( "FAIL  %s\n      resolved post %d has slug '%s', expected '%s'\n",
			$path, $post_id, $post->post_name, implode( "' or '", $ok_slugs ) );
		$failed++;
		continue;
	}

	$current = trim( (string) get_post_meta( $post_id, '_roden_meta_title', true ) );
	if ( $current === $title ) {
		printf( "OK    %s\n      already set\n", $path );
		$already++;
		continue;
	}

	printf( "%s  %s\n      post %d  %d chars\n      + %s\n",
		'apply' === $mode ? 'WRITE' : 'WOULD', $path, $post_id, mb_strlen( $title ), $title );
	if ( '' !== $current ) {
		printf( "      - %s   (replacing)\n", $current );
	}

	if ( 'apply' === $mode ) {
		$backup[ $path ] = array( 'id' => $post_id, 'previous' => $current, 'post_title' => $post->post_title );
		update_post_meta( $post_id, '_roden_meta_title', wp_slash( $title ) );

		if ( trim( (string) get_post_meta( $post_id, '_roden_meta_title', true ) ) !== $title ) {
			printf( "      !! READBACK MISMATCH\n" );
			$failed++;
			continue;
		}
	}
	$applied++;
}

echo str_repeat( '=', 74 ), "\n";
printf( "%s: %d   already correct: %d   failed: %d\n",
	'apply' === $mode ? 'written' : 'would write', $applied, $already, $failed );

if ( 'apply' === $mode && $backup ) {
	echo "\n--- BACKUP (previous override + post_title, for rollback) ---\n";
	echo wp_json_encode( $backup, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), "\n";
}

if ( $failed ) {
	exit( 1 );
}
