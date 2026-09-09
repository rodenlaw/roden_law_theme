<?php
/**
 * Migrate an in-body FAQ section into _roden_faqs meta.
 *
 * Payload: { "<permalink path>": { "faqs": [ {question, answer}, ... ],
 *                                  "block": "<exact post_content substring to remove>" } }
 * injected as RODEN_SEED_JSON by bin/build-faq-migration.sh.
 *
 * WHY THIS EXISTS
 * ---------------
 * 30 published blog posts render a visible FAQ section written directly into
 * post_content and emit NO FAQPage JSON-LD, because roden_schema_faq_page()
 * reads _roden_faqs and that field is empty (audit 2026-09-09). The Q&A is
 * already written and already reviewed; it is simply in the wrong place.
 *
 * Writing the meta alone would render the FAQ TWICE - once as body prose and
 * again through roden_faq_section() - so this also removes the body block. The
 * content is relocated, not rewritten: the answers written into meta are the
 * answers already on the page.
 *
 * A SEPARATE 90 POSTS ARE DELIBERATELY NOT TOUCHED. They carry a complete
 * FAQPage JSON-LD block embedded in post_content and already emit valid schema.
 * Adding meta there would produce a second FAQPage node and a duplicated visible
 * section. Migrating them is a different job with a different risk profile.
 *
 * GUARDS. The write is refused unless _roden_faqs is empty AND the exact block
 * still appears in post_content AND removing it shortens the content by exactly
 * the block's length. A post edited since the payload was built therefore fails
 * closed rather than being clobbered.
 *
 * Uses wp_slash() on BOTH writes. wp_update_post() and update_post_meta() each
 * call wp_unslash() on what they are handed, so an unslashed write silently eats
 * backslashes - the 2026-09-09 incident that broke four FAQPage blocks. See the
 * Gotchas section of CLAUDE.md and bin/check-unslashed-post-writes.php.
 *
 *   ssh $H "wp --path=$P eval-file -"       < built.php   # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < built.php   # write
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}
if ( ! defined( 'RODEN_SEED_JSON' ) ) {
	fwrite( STDERR, "RODEN_SEED_JSON is not defined - run through bin/build-faq-migration.sh.\n" );
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

foreach ( $payload as $path => $spec ) {

	$faqs  = isset( $spec['faqs'] ) ? $spec['faqs'] : null;
	$block = isset( $spec['block'] ) ? $spec['block'] : null;

	if ( ! is_array( $faqs ) || count( $faqs ) < 4 || count( $faqs ) > 8 || ! $block ) {
		printf( "FAIL  %s\n      malformed entry (%d faqs, block %s)\n",
			$path, is_array( $faqs ) ? count( $faqs ) : 0, $block ? 'present' : 'MISSING' );
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

	$existing = get_post_meta( $post_id, '_roden_faqs', true );
	if ( is_array( $existing ) && ! empty( $existing ) ) {
		printf( "SKIP  %s\n      already has %d FAQs in meta - not overwriting\n", $path, count( $existing ) );
		$skipped++;
		continue;
	}

	$content = $post->post_content;
	$pos     = strpos( $content, $block );
	if ( false === $pos ) {
		printf( "SKIP  %s\n      body FAQ block no longer matches (post edited since payload was built)\n", $path );
		$skipped++;
		continue;
	}
	if ( strpos( $content, $block, $pos + 1 ) !== false ) {
		printf( "FAIL  %s\n      block appears more than once - refusing to guess\n", $path );
		$failed++;
		continue;
	}

	$new_content = substr_replace( $content, '', $pos, strlen( $block ) );
	if ( strlen( $content ) - strlen( $new_content ) !== strlen( $block ) ) {
		printf( "FAIL  %s\n      removal length mismatch\n", $path );
		$failed++;
		continue;
	}

	$clean = array();
	foreach ( $faqs as $f ) {
		if ( empty( $f['question'] ) || empty( $f['answer'] ) ) {
			printf( "FAIL  %s\n      empty question or answer\n", $path );
			$failed++;
			continue 2;
		}
		$clean[] = array( 'question' => (string) $f['question'], 'answer' => (string) $f['answer'] );
	}

	printf( "%s  %s\n      post %d, %d FAQs -> meta, removing %d chars from body (%d -> %d)\n",
		'apply' === $mode ? 'WRITE' : 'WOULD', $path, $post_id,
		count( $clean ), strlen( $block ), strlen( $content ), strlen( $new_content ) );

	if ( 'apply' === $mode ) {
		$backup[ $path ] = array( 'id' => $post_id, 'post_content' => $content );

		update_post_meta( $post_id, '_roden_faqs', wp_slash( $clean ) );
		$r = wp_update_post( wp_slash( array( 'ID' => $post_id, 'post_content' => $new_content ) ), true );
		if ( is_wp_error( $r ) ) {
			printf( "      !! wp_update_post failed: %s\n", $r->get_error_message() );
			$failed++;
			continue;
		}

		clean_post_cache( $post_id );
		$rb_meta = get_post_meta( $post_id, '_roden_faqs', true );
		$rb_body = get_post_field( 'post_content', $post_id );
		if ( ! is_array( $rb_meta ) || count( $rb_meta ) !== count( $clean ) || strpos( $rb_body, $block ) !== false ) {
			printf( "      !! READBACK MISMATCH - meta=%d expected=%d, block still present=%s\n",
				is_array( $rb_meta ) ? count( $rb_meta ) : 0, count( $clean ),
				strpos( $rb_body, $block ) !== false ? 'YES' : 'no' );
			$failed++;
			continue;
		}
	}
	$applied++;
}

echo str_repeat( '=', 72 ), "\n";
printf( "%s: %d   skipped: %d   failed: %d\n",
	'apply' === $mode ? 'migrated' : 'would migrate', $applied, $skipped, $failed );

if ( 'apply' === $mode && $backup ) {
	echo "\n--- BACKUP (original post_content, for rollback) ---\n";
	echo wp_json_encode( $backup, JSON_UNESCAPED_SLASHES ), "\n";
}

if ( $failed ) {
	exit( 1 );
}
