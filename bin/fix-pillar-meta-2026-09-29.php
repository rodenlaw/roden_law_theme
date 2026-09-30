<?php
/**
 * Three pillar meta-field fixes from the pillar takeaways sweep (M-WC1, M-WC2,
 * M-MM1; data/facts/remediation-2026-09-29-pillar-takeaways.md). Owner,
 * 2026-09-29: "do the key takeaways now". Signed authorities only; the GA-reviewer
 * items (M-MM2, M-PED1, M-WD1) are not touched. Exact-match once; wp_slash; read back.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-pillar-meta-2026-09-29.php > docs/backups/pillar-meta-2026-09-29.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$edits = array(
	array( 'M-WC1', 3610, '_roden_why_hire', 'comparative-fault rules specific to South Carolina', 'benefit rules specific to South Carolina' ), // SC 42-9-60
	array( 'M-WC2', 3610, '_roden_meta_description', 'Georgia allows 1 year to file, South Carolina 2.', 'Georgia generally allows 1 year to file, South Carolina 2.' ), // GA 34-9-82
	array( 'M-MM1', 3608, '_roden_why_hire', 'South Carolina has similar expert requirements under S.C. Code § 15-79-125.', "South Carolina requires a qualified expert's affidavit, filed with a Notice of Intent to File Suit (S.C. Code §§ 15-36-100, 15-79-125)." ), // SC 15-36-100, 15-79-125
);
$out = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'edits' => array() );
foreach ( $edits as $e ) {
	list( $id, $post, $key, $from, $to ) = $e;
	$cur = (string) get_post_meta( $post, $key, true );
	if ( 1 !== substr_count( $cur, $from ) ) { fwrite( STDERR, "ABORT: $id ($post $key) found " . substr_count( $cur, $from ) . " times\n" ); exit( 1 ); }
	$new = str_replace( $from, $to, $cur );
	$out['edits'][] = array( 'id' => $id, 'post' => $post, 'key' => $key, 'before' => $cur, 'after' => $new );
	fwrite( STDERR, "  " . ( $apply ? 'fixed' : 'would fix' ) . " $id ($post $key)\n" );
	if ( $apply ) {
		update_post_meta( $post, $key, wp_slash( $new ) );
		wp_cache_delete( $post, 'post_meta' ); clean_post_cache( $post );
		if ( get_post_meta( $post, $key, true ) !== $new ) { fwrite( STDERR, "FAILED read-back $id\n" ); exit( 1 ); }
	}
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
