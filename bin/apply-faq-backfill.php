<?php
/**
 * Backfill _roden_faqs on posts that have none.
 *
 * Payload: { "<permalink path>": [ { "question": ..., "answer": ... }, ... ] }
 * injected as RODEN_SEED_JSON by bin/build-faq-backfill.sh.
 *
 * WHY THIS EXISTS
 * ---------------
 * 339 of 486 published blog posts carry no FAQ block, against 99% coverage on
 * practice areas and 97% on resources (audit 2026-09-09). Those posts are the
 * hyperlocal long-tail pages built for the same conversational queries AI
 * answer engines field, and an FAQ block is what those engines quote.
 *
 * ONLY EVER ADDS. The write is guarded on _roden_faqs being empty, so this can
 * never overwrite an existing, reviewed FAQ block - including one an editor
 * wrote between the export and the run. Re-running is a no-op on anything
 * already populated, which is what makes batching safe.
 *
 * Identity is the PERMALINK PATH, not the post ID, matching
 * bin/export-content-meta.php: IDs are unstable across environments, and this
 * payload is built from a local export. The resolved post's slug is asserted
 * against the path's last segment before anything is written.
 *
 * Drafts must pass bin/verify-faq-drafts.py against data/faq-fact-registry.json
 * before they get here. That gate is what keeps a recalled statute out of
 * FAQPage JSON-LD; this script does not re-check legal content.
 *
 * Uses wp_slash() - update_post_meta() unslashes what you hand it, so an
 * unslashed write silently eats backslashes. See the Gotchas section of
 * CLAUDE.md, and bin/check-unslashed-post-writes.php which enforces it.
 *
 *   ssh $H "wp --path=$P eval-file -"       < built.php   # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < built.php   # write
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}
if ( ! defined( 'RODEN_SEED_JSON' ) ) {
	fwrite( STDERR, "RODEN_SEED_JSON is not defined - run through bin/build-faq-backfill.sh.\n" );
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

echo "mode: $mode\n", str_repeat( '=', 72 ), "\n";

$applied = $skipped = $failed = 0;
$backup  = array();

foreach ( $payload as $path => $faqs ) {

	if ( ! is_array( $faqs ) || count( $faqs ) < 4 || count( $faqs ) > 6 ) {
		printf( "FAIL  %s\n      expected 4-6 FAQs, got %d\n", $path, is_array( $faqs ) ? count( $faqs ) : 0 );
		$failed++;
		continue;
	}

	foreach ( $faqs as $i => $f ) {
		if ( empty( $f['question'] ) || empty( $f['answer'] ) ) {
			printf( "FAIL  %s\n      entry #%d missing question or answer\n", $path, $i + 1 );
			$failed++;
			continue 2;
		}
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

	// Identity assertion: the resolved post's slug must match the path.
	// Spanish posts are stored with an `es-` slug prefix that the permalink path
	// drops: /es/blog/foo/ is post_name `es-foo`. Accept either form, but keep the
	// assertion - it is what caught this mismatch instead of writing blind.
	$want_slug = basename( untrailingslashit( $path ) );
	$ok_slugs  = array( $want_slug, 'es-' . $want_slug );
	if ( ! in_array( $post->post_name, $ok_slugs, true ) ) {
		printf( "FAIL  %s\n      resolved post %d has slug '%s', expected '%s'\n",
			$path, $post_id, $post->post_name, implode( "' or '", $ok_slugs ) );
		$failed++;
		continue;
	}

	// THE GUARD. Never overwrite an existing FAQ block.
	$existing = get_post_meta( $post_id, '_roden_faqs', true );
	if ( is_array( $existing ) && ! empty( $existing ) ) {
		printf( "SKIP  %s\n      already has %d FAQs - not overwriting\n", $path, count( $existing ) );
		$skipped++;
		continue;
	}

	$clean = array();
	foreach ( $faqs as $f ) {
		$clean[] = array(
			'question' => (string) $f['question'],
			'answer'   => (string) $f['answer'],
		);
	}

	printf( "%s  %s\n      post %d, %d FAQs\n",
		'apply' === $mode ? 'WRITE' : 'WOULD', $path, $post_id, count( $clean ) );

	if ( 'apply' === $mode ) {
		$backup[ $path ] = array( 'id' => $post_id, 'previous' => $existing );
		// wp_slash(): update_post_meta() unslashes, so an unslashed write eats
		// backslashes. Silent, and only on values that happen to contain one.
		update_post_meta( $post_id, '_roden_faqs', wp_slash( $clean ) );

		$readback = get_post_meta( $post_id, '_roden_faqs', true );
		if ( ! is_array( $readback ) || count( $readback ) !== count( $clean ) ) {
			printf( "      !! READBACK MISMATCH - wrote %d, read %d\n",
				count( $clean ), is_array( $readback ) ? count( $readback ) : 0 );
			$failed++;
			continue;
		}
	}
	$applied++;
}

echo str_repeat( '=', 72 ), "\n";
printf( "%s: %d   skipped: %d   failed: %d\n",
	'apply' === $mode ? 'written' : 'would write', $applied, $skipped, $failed );

if ( 'apply' === $mode && $backup ) {
	echo "\n--- BACKUP (previous values, for rollback) ---\n";
	echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ), "\n";
}

if ( $failed ) {
	exit( 1 );
}
