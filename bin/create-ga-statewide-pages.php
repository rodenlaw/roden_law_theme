<?php
/**
 * Create (or refresh) the six Georgia statewide pillar pages as DRAFTS on
 * templates/template-pillar-ga-statewide.php. P2 (docs/site-architecture);
 * owner, 2026-09-29: "start the Georgia statewide pages. Those are cleared by
 * Eric Roden." Content: data/practice-area-drafts/2026-09/ga-statewide/*.json
 * (signed GA pack only), embedded by bin/build-ga-statewide-pages.py because this
 * script is piped to `wp eval-file -`.
 *
 * Never publishes. A page that already exists is updated only if it is still a
 * draft; a published or trashed page with the slug aborts the run.
 * wp_insert_post / update_post_meta get wp_slash()ed data (CLAUDE.md).
 *
 *   python3 bin/build-ga-statewide-pages.py > run.php
 *   ssh $H "wp --path=$P eval-file - [apply]" < run.php > docs/backups/ga-statewide-create-2026-09-29.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$pages = json_decode( base64_decode( '__PAGES__' ), true );
if ( ! is_array( $pages ) || 6 !== count( $pages ) ) { fwrite( STDERR, "ABORT: expected 6 pages\n" ); exit( 1 ); }
$out = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'pages' => array() );
foreach ( $pages as $d ) {
	$existing = get_page_by_path( $d['slug'], OBJECT, 'page' );
	if ( $existing && 'draft' !== $existing->post_status ) { fwrite( STDERR, "ABORT: /{$d['slug']}/ exists as {$existing->post_status}\n" ); exit( 1 ); }
	$fields = array(
		'post_type'    => 'page',
		'post_status'  => 'draft',
		'post_name'    => $d['slug'],
		'post_title'   => $d['title'],
		'post_content' => $d['body_html'],
		'post_excerpt' => $d['meta_description'],
	);
	if ( $existing ) { $fields['ID'] = $existing->ID; }
	$meta = array(
		'_wp_page_template'         => 'templates/template-pillar-ga-statewide.php',
		'_roden_pillar_practice'    => $d['practice_label'],
		'_roden_pillar_practice_l'  => $d['practice_label_l'],
		'_roden_jurisdiction'       => 'GA',
		'_roden_key_takeaways'      => $d['key_takeaways'],
		'_roden_meta_title'         => $d['meta_title'],
		'_roden_meta_description'   => $d['meta_description'],
		'_roden_faqs'               => $d['faqs'],
		'_roden_author_attorney'    => (string) $d['author_attorney'],
	);
	fwrite( STDERR, sprintf( "  %s /%s/ (%s, %d words, %d FAQs)\n", $apply ? ( $existing ? 'update draft' : 'create draft' ) : 'would write', $d['slug'], $existing ? 'ID ' . $existing->ID : 'new', str_word_count( wp_strip_all_tags( $d['body_html'] ) ), count( $d['faqs'] ) ) );
	if ( ! $apply ) { continue; }
	$id = $existing ? wp_update_post( wp_slash( $fields ), true ) : wp_insert_post( wp_slash( $fields ), true );
	if ( is_wp_error( $id ) ) { fwrite( STDERR, 'FAILED: ' . $id->get_error_message() . "\n" ); exit( 1 ); }
	foreach ( $meta as $k => $v ) { update_post_meta( $id, $k, wp_slash( $v ) ); }
	clean_post_cache( $id );
	global $wpdb;
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT post_status, post_name, post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	$ok  = 'draft' === $row->post_status && $row->post_content === $d['body_html'] && get_post_meta( $id, '_roden_faqs', true ) === $d['faqs'];
	fwrite( STDERR, sprintf( "    ID %d %s\n", $id, $ok ? 'VERIFIED' : 'MISMATCH' ) );
	if ( ! $ok ) { exit( 1 ); }
	$out['pages'][] = array( 'ID' => $id, 'slug' => $d['slug'] );
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
