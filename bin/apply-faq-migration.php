<?php
/**
 * Migrate an in-body FAQ section into _roden_faqs meta.
 *
 * Payload: { "<permalink path>": { "faqs":   [ {question, answer}, ... ],
 *                                  "blocks": [ "<exact post_content substring to remove>", ... ] } }
 *
 * `blocks` is a LIST because the removals are not contiguous. On the
 * embedded-schema posts the visible FAQ section and the inline JSON-LD script
 * sit at opposite ends of an "About the Author" block — 82 of 90 carry one —
 * and that attribution is load-bearing E-E-A-T content that has to survive.
 * A single start..end range would have deleted it. Legacy single-string
 * "block" is still accepted.
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

	$faqs   = isset( $spec['faqs'] ) ? $spec['faqs'] : null;
	$blocks = isset( $spec['blocks'] ) ? $spec['blocks'] : ( isset( $spec['block'] ) ? array( $spec['block'] ) : null );

	if ( ! is_array( $faqs ) || count( $faqs ) < 4 || count( $faqs ) > 8 || ! is_array( $blocks ) || ! $blocks ) {
		printf( "FAIL  %s\n      malformed entry (%d faqs, %d blocks)\n",
			$path, is_array( $faqs ) ? count( $faqs ) : 0, is_array( $blocks ) ? count( $blocks ) : 0 );
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

	$content     = $post->post_content;
	$new_content = $content;
	$removed     = 0;
	$bad         = false;

	foreach ( $blocks as $block ) {
		$pos = strpos( $new_content, $block );
		if ( false === $pos ) {
			printf( "SKIP  %s\n      a block no longer matches (post edited since payload was built)\n", $path );
			$skipped++;
			$bad = true;
			break;
		}
		if ( strpos( $new_content, $block, $pos + 1 ) !== false ) {
			printf( "FAIL  %s\n      a block appears more than once - refusing to guess\n", $path );
			$failed++;
			$bad = true;
			break;
		}
		$new_content = substr_replace( $new_content, '', $pos, strlen( $block ) );
		$removed    += strlen( $block );
	}
	if ( $bad ) {
		continue;
	}

	if ( strlen( $content ) - strlen( $new_content ) !== $removed ) {
		printf( "FAIL  %s\n      removal length mismatch\n", $path );
		$failed++;
		continue;
	}

	// Attribution must survive. 82 of these posts carry an author block between
	// the two removals; losing it would strip the page's E-E-A-T signal silently.
	foreach ( array( 'About the Author', 'Sobre el Autor', 'Acerca del Autor' ) as $marker ) {
		if ( false !== strpos( $content, $marker ) && false === strpos( $new_content, $marker ) ) {
			printf( "FAIL  %s\n      removal would delete the \"%s\" block\n", $path, $marker );
			$failed++;
			$bad = true;
			break;
		}
	}
	if ( $bad ) {
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

	printf( "%s  %s\n      post %d, %d FAQs -> meta, %d block(s) removing %d chars (%d -> %d)\n",
		'apply' === $mode ? 'WRITE' : 'WOULD', $path, $post_id,
		count( $clean ), count( $blocks ), $removed, strlen( $content ), strlen( $new_content ) );

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
		$rb_body  = get_post_field( 'post_content', $post_id );
		$leftover = 0;
		foreach ( $blocks as $block ) {
			if ( false !== strpos( $rb_body, $block ) ) {
				$leftover++;
			}
		}
		if ( ! is_array( $rb_meta ) || count( $rb_meta ) !== count( $clean ) || $leftover ) {
			printf( "      !! READBACK MISMATCH - meta=%d expected=%d, blocks still present=%d\n",
				is_array( $rb_meta ) ? count( $rb_meta ) : 0, count( $clean ), $leftover );
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
