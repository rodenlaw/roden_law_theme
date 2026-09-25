<?php
/**
 * Move every trashed post back to draft, so the 30-day trash purge cannot
 * delete it.
 *
 * WordPress empties the trash after EMPTY_TRASH_DAYS (30 on this host). The
 * doorway-cull batches trashed their pages expecting them to stay recoverable
 * by ID; they do not. The 08-21 and 08-25 batches were already purged by
 * 2026-09-25 and survive only as JSON in docs/backups/. This rescues whatever
 * is still in the trash.
 *
 * Drafts are not public, not in the sitemap, and never purged. The retirement
 * redirects are keyed on the request path (roden_phase1_removal_redirects()),
 * not on post status, so they keep firing. To bring a page back: remove its
 * line from the redirect map, check the doorway ratio, then publish.
 *
 * Written straight to the columns rather than through wp_untrash_post():
 * that goes through wp_insert_post, which runs the wp_insert_post_data
 * guardrails (roden_guard_pillar_links rewrites post_content). Only
 * post_status and post_name change here, and content is never touched.
 *
 * Slug: trashing appends "__trashed" and stores the original in
 * _wp_desired_post_slug. The original is restored unless a PUBLISHED post of
 * the same type and parent already holds it; then the __trashed slug is kept
 * and the post is reported.
 *
 * Run from the repo over stdin, never added to the theme:
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/restore-trash-to-draft.php   # dry run; prints the backup JSON
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/restore-trash-to-draft.php
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

global $wpdb;
$apply = isset( $args[0] ) && 'apply' === $args[0];

// Only posts carrying a trash timestamp: that is what wp_scheduled_delete purges
// by, and it is what every batch removal left. Four older trashed items have no
// timestamp (a media-plugin folder, an old "Who We Are" page, a -2 duplicate
// post, a Park Circle location). The purge never touches them, and restoring
// their slugs could collide with live routes such as /attorneys/, so they are
// left as they are.
$ids = $wpdb->get_col(
	"SELECT p.ID FROM {$wpdb->posts} p
	 JOIN {$wpdb->postmeta} m ON m.post_id = p.ID AND m.meta_key = '_wp_trash_meta_time'
	 WHERE p.post_status = 'trash' AND p.post_type NOT IN ('revision','attachment','nav_menu_item')
	 ORDER BY p.ID"
);

$records   = array();
$collision = array();

foreach ( $ids as $id ) {
	$p       = get_post( $id );
	$desired = (string) get_post_meta( $id, '_wp_desired_post_slug', true );
	$slug    = $p->post_name;

	if ( '' !== $desired && $desired !== $slug ) {
		$taken = (int) $wpdb->get_var( $wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_type = %s AND post_parent = %d AND post_status = 'publish' AND ID <> %d LIMIT 1",
			$desired, $p->post_type, $p->post_parent, $id
		) );
		if ( $taken ) {
			$collision[] = "{$id} {$p->post_type} '{$desired}' held by published {$taken}";
		} else {
			$slug = $desired;
		}
	}

	$records[] = array(
		'ID'                   => (int) $id,
		'post_type'            => $p->post_type,
		'post_title'           => $p->post_title,
		'post_parent'          => (int) $p->post_parent,
		'post_name_before'     => $p->post_name,
		'post_name_after'      => $slug,
		'trash_meta_status'    => get_post_meta( $id, '_wp_trash_meta_status', true ),
		'trash_meta_time'      => (int) get_post_meta( $id, '_wp_trash_meta_time', true ),
		'desired_slug'         => $desired,
	);

	if ( $apply ) {
		$wpdb->update(
			$wpdb->posts,
			array( 'post_status' => 'draft', 'post_name' => $slug ),
			array( 'ID' => $id ),
			array( '%s', '%s' ),
			array( '%d' )
		);
		delete_post_meta( $id, '_wp_trash_meta_status' );
		delete_post_meta( $id, '_wp_trash_meta_time' );
		delete_post_meta( $id, '_wp_desired_post_slug' );
		clean_post_cache( $id );
	}
}

$by_type = array();
foreach ( $records as $r ) {
	$by_type[ $r['post_type'] ] = ( $by_type[ $r['post_type'] ] ?? 0 ) + 1;
}

fwrite( STDERR, ( $apply ? 'APPLIED' : 'DRY RUN' ) . ': ' . count( $records ) . ' trashed posts -> draft ' . wp_json_encode( $by_type ) . "\n" );
fwrite( STDERR, 'slug collisions (kept __trashed): ' . count( $collision ) . "\n" );
foreach ( $collision as $c ) {
	fwrite( STDERR, "  {$c}\n" );
}

if ( $apply ) {
	$left = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} p JOIN {$wpdb->postmeta} m ON m.post_id = p.ID AND m.meta_key = '_wp_trash_meta_time' WHERE p.post_status = 'trash'" );
	fwrite( STDERR, "still in trash after apply: {$left}\n" );
}

echo wp_json_encode( $records, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "\n";
