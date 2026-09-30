<?php
/**
 * Replace the generated Key Takeaways on the 24 English practice pillars with
 * hand-written ones (P3 step 2, docs/site-architecture). Owner, 2026-09-29: "do
 * the key takeaways now". The generated paragraph (roden_pa_key_takeaways_text)
 * was ~90% identical across pillars and wrong in places ("injured in a wrongful
 * death"; the tort deadline on the med-mal pillar). Text:
 * data/practice-area-drafts/2026-09/pillar-takeaways/takeaways.json (signed SC
 * and GA pack authorities only), embedded by bin/build-pillar-takeaways.py.
 *
 * Writes _roden_key_takeaways only where it is still empty, so a hand edit is
 * never overwritten. update_post_meta( wp_slash() ); read back.
 *
 *   python3 bin/build-pillar-takeaways.py > run.php
 *   ssh $H "wp --path=$P eval-file - [apply]" < run.php > docs/backups/pillar-takeaways-2026-09-29.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$data  = json_decode( base64_decode( '__DATA__' ), true );
if ( ! is_array( $data ) || count( $data ) < 20 ) { fwrite( STDERR, "ABORT: takeaways not embedded\n" ); exit( 1 ); }
$out = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'posts' => array() );
foreach ( $data as $slug => $row ) {
	$p = get_page_by_path( $slug . '-lawyers', OBJECT, 'practice_area' );
	if ( ! $p || 'publish' !== $p->post_status || $p->post_parent ) { fwrite( STDERR, "ABORT: no published pillar for $slug\n" ); exit( 1 ); }
	$cur = (string) get_post_meta( $p->ID, '_roden_key_takeaways', true );
	if ( '' !== $cur ) { fwrite( STDERR, "  skip {$p->ID} $slug: already has written takeaways\n" ); continue; }
	$out['posts'][] = array( 'ID' => $p->ID, 'slug' => $slug, 'before' => $cur, 'after' => $row['text'] );
	fwrite( STDERR, sprintf( "  %s %d %s (%d words)\n", $apply ? 'set' : 'would set', $p->ID, $slug, str_word_count( $row['text'] ) ) );
	if ( ! $apply ) { continue; }
	update_post_meta( $p->ID, '_roden_key_takeaways', wp_slash( $row['text'] ) );
	wp_cache_delete( $p->ID, 'post_meta' );
	clean_post_cache( $p->ID );
	if ( get_post_meta( $p->ID, '_roden_key_takeaways', true ) !== $row['text'] ) { fwrite( STDERR, "FAILED read-back {$p->ID}\n" ); exit( 1 ); }
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
