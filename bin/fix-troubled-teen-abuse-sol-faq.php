<?php
/**
 * Troubled-teen FAQ 5 (post 4574, _roden_faqs[4]): remove the claim that
 * limitation rules "for abuse survivors" extend the deadline. Sweep 2026-10-24,
 * rule abuse-sol-extension-overbroad (GA's § 9-3-33.1 and SC's § 15-3-555 cover
 * sexual abuse only). Plan: data/facts/remediation-2026-10-24-troubled-teen.md,
 * correction A. Owner, 2026-10-24: "apply fix A".
 *
 * Replaces the first two sentences only; names no period, statute or
 * extension. Exact match, once, at index 4, or abort before writing. wp_slash;
 * read back. Sets _roden_content_modified (what the page says changes), not
 * _roden_last_reviewed.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-troubled-teen-abuse-sol-faq.php > docs/backups/4574-faqs-2026-10-24.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$post  = 4574;
$index = 4;
$from  = 'It may not be too late. <strong>Statute-of-limitations rules for abuse survivors often extend the window to come forward</strong>, and these rules vary by state and circumstances.';
$to    = 'It may not be too late, but some claims may already have expired. <strong>Filing deadlines depend on the kind of claim and the state where it is filed</strong>, and they are strict.';

$before = get_post_meta( $post, '_roden_faqs', true );
if ( ! is_array( $before ) || ! isset( $before[ $index ]['answer'] ) ) {
	fwrite( STDERR, "ABORT: $post has no _roden_faqs[$index]\n" );
	exit( 1 );
}
$hits = array();
foreach ( $before as $i => $f ) {
	$n = substr_count( (string) $f['answer'], $from );
	if ( $n ) {
		$hits[ $i ] = $n;
	}
}
if ( array( $index => 1 ) !== $hits ) {
	fwrite( STDERR, 'ABORT: needle matched ' . wp_json_encode( $hits ) . " (expected once at $index)\n" );
	exit( 1 );
}
$after = $before;
$after[ $index ]['answer'] = str_replace( $from, $to, $after[ $index ]['answer'] );

$out = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'post' => $post, 'key' => '_roden_faqs', 'before' => $before, 'after' => $after );
fwrite( STDERR, ( $apply ? 'fixing' : 'would fix' ) . " $post _roden_faqs[$index]\n  - " . $before[ $index ]['answer'] . "\n  + " . $after[ $index ]['answer'] . "\n" );
if ( $apply ) {
	update_post_meta( $post, '_roden_faqs', wp_slash( $after ) );
	update_post_meta( $post, '_roden_content_modified', wp_slash( gmdate( 'Y-m-d H:i:s' ) ) );
	wp_cache_delete( $post, 'post_meta' );
	clean_post_cache( $post );
	if ( get_post_meta( $post, '_roden_faqs', true ) !== $after ) {
		fwrite( STDERR, "FAILED read-back $post _roden_faqs\n" );
		exit( 1 );
	}
	fwrite( STDERR, "read-back OK\n" );
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
