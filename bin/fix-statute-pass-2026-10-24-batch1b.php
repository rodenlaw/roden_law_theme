<?php
/**
 * Statute pass 2026-10-24, batch 1b: the same § 40-6-294 -> § 40-6-291 swap
 * (cyclists' rights and duties) in _roden_why_hire on 4087, found on the live
 * page after batch 1. The field is not in the sweep's export, so the pass could
 * not see it. Same owner approval as batch 1 ("yes to 1, 2 and 3").
 * The link also pointed at article-12; § 40-6-291 is in article 13, part 1.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/fix-statute-pass-2026-10-24-batch1b.php > docs/backups/statute-pass-2026-10-24-batch1b.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$post  = 4087;
$key   = '_roden_why_hire';
$edits = array(
	array( 'https://law.justia.com/codes/georgia/title-40/chapter-6/article-12/section-40-6-294/', 'https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/part-1/section-40-6-291/' ),
	array( 'O.C.G.A. § 40-6-294</a>) grants bicyclists the same rights and duties', 'O.C.G.A. § 40-6-291</a>) grants bicyclists the same rights and duties' ),
);
$before = get_post_meta( $post, $key, true );
if ( ! is_string( $before ) || '' === $before ) {
	fwrite( STDERR, "ABORT: no string $key on $post\n" );
	exit( 1 );
}
$after = $before;
foreach ( $edits as $e ) {
	$n = substr_count( $after, $e[0] );
	if ( 1 !== $n ) {
		fwrite( STDERR, "ABORT: needle matched $n times: {$e[0]}\n" );
		exit( 1 );
	}
	$after = str_replace( $e[0], $e[1], $after );
}
fwrite( STDERR, ( $apply ? 'fixing' : 'would fix' ) . " $post $key: 2 edits\n" );
if ( $apply ) {
	update_post_meta( $post, $key, wp_slash( $after ) );
	update_post_meta( $post, '_roden_content_modified', wp_slash( gmdate( 'Y-m-d H:i:s' ) ) );
	wp_cache_delete( $post, 'post_meta' );
	if ( get_post_meta( $post, $key, true ) !== $after ) {
		fwrite( STDERR, "FAILED read-back\n" );
		exit( 1 );
	}
	fwrite( STDERR, "read-back OK\n" );
}
echo wp_json_encode( array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'post' => $post, 'key' => $key, 'before' => $before, 'after' => $after ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
