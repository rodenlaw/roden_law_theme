<?php
/**
 * SC helmet guide (6313) into practice_category bicycle-accidents, 2026-11-11.
 *
 * Why: the bicycle pillar's "Related Guides & Legal Resources" box and the
 * bicycle subtype pages list resources by practice_category. Only 4639 carried
 * bicycle-accidents; the SC helmet guide (which covers bicycle helmet rules) was
 * tagged motorcycle-accidents only. Owner-approved 2026-11-11 ("tag it").
 *
 * Appends the term; motorcycle-accidents stays. Idempotent; prior terms backed up.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/apply-sc-helmet-guide-bicycle-tag-2026-11-11.php
 *   ssh $H "wp --path=$P eval-file - apply" < bin/apply-sc-helmet-guide-bicycle-tag-2026-11-11.php
 * then: wp cache flush && wp page-cache flush.
 */
if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run through wp eval-file.\n" ); exit( 1 ); }
$mode = isset( $args[0] ) ? $args[0] : 'dry-run';
$id   = 6313;
$tax  = 'practice_category';
$term = 'bicycle-accidents';

$p = get_post( $id );
if ( ! $p || 'resource' !== $p->post_type || 'south-carolina-helmet-laws' !== $p->post_name || 'publish' !== $p->post_status ) {
	echo "FAIL $id: missing, wrong type/slug or not published\n"; exit( 1 );
}
if ( ! get_term_by( 'slug', $term, $tax ) ) { echo "FAIL term $term missing\n"; exit( 1 ); }
$before = wp_get_object_terms( $id, $tax, array( 'fields' => 'slugs' ) );
echo "$id $tax before: " . implode( ',', $before ) . "\n";
if ( in_array( $term, $before, true ) ) { echo "OK   already tagged\nDONE clean\n"; exit( 0 ); }
if ( 'apply' !== $mode ) { echo "WOULD add $term\nDONE clean\n"; exit( 0 ); }

$dir = WP_CONTENT_DIR . '/uploads/roden-backups/sc-helmet-guide-bicycle-tag-2026-11-11';
$f   = "$dir/$id-practice_category.json";
if ( ( ! is_dir( $dir ) && ! wp_mkdir_p( $dir ) ) || ( ! file_exists( $f ) && false === file_put_contents( $f, wp_json_encode( $before ) ) ) ) {
	echo "FAIL backup\n"; exit( 1 );
}
$r = wp_set_object_terms( $id, $term, $tax, true );
if ( is_wp_error( $r ) ) { echo 'FAIL ' . $r->get_error_message() . "\n"; exit( 1 ); }
clean_post_cache( $id );
$after = wp_get_object_terms( $id, $tax, array( 'fields' => 'slugs' ) );
echo "$id $tax after:  " . implode( ',', $after ) . "\nbackup: $f\n";
$ok = in_array( $term, $after, true ) && ! array_diff( $before, $after );
echo $ok ? "DONE clean\n" : "DONE with failure\n";
exit( $ok ? 0 : 1 );
