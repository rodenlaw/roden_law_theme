<?php
/**
 * Retire the 13 mass-tort child pages under /class-action-lawyers/ to draft, AFTER
 * the deploy that ships roden_mass_tort_retire_urls() (their 301s). Marked the
 * same way as earlier retirements: _roden_retired = "<date> <reason>".
 *
 * Owner's call 2026-09-10 (mass torts are out), redirect PR approved 2026-10-23.
 *
 * NOT retired:
 *   - troubled-teen-industry-abuse (kept: the one page in the cluster that earns).
 *   - the hub /class-action-lawyers/ itself: it stays published so the kept child's
 *     permalink and path resolution are untouched. It is 301'd and out of the sitemap.
 *
 * Guards: the redirect batch must be live (the function exists in the deployed
 * theme), the hub must exist, and each page must be a published child of the hub
 * with a slug on the list. Anything else is skipped and reported, not written.
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/retire-mass-tort-pages.php           # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/retire-mass-tort-pages.php     # write
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
global $wpdb;

if ( ! function_exists( 'roden_mass_tort_retire_urls' ) ) {
	fwrite( STDERR, "ABORT: roden_mass_tort_retire_urls() is not in the deployed theme; deploy first\n" );
	exit( 1 );
}
$hub = get_page_by_path( 'class-action-lawyers' );
if ( ! $hub || 'page' !== $hub->post_type || $hub->post_parent ) {
	fwrite( STDERR, "ABORT: hub /class-action-lawyers/ not found\n" );
	exit( 1 );
}

$slugs = array(
	'afff-firefighting-foam-lawsuits',
	'camp-lejeune-lawsuits',
	'hair-relaxer-cancer-lawsuits',
	'invokana',
	'ivc-filter',
	'onglyza',
	'ozempic-lawsuits',
	'paraquat-lawsuit',
	'roundup',
	'stryker-hip-replacement',
	'talcum-powder',
	'truvada',
	'uloric',
);
$map    = roden_mass_tort_retire_urls();
$reason = '2026-10-23 mass torts retired (owner); 301 to /practice-areas/';
$done   = 0;

foreach ( $slugs as $slug ) {
	$p = get_page_by_path( 'class-action-lawyers/' . $slug );
	if ( ! $p || (int) $p->post_parent !== (int) $hub->ID ) {
		echo "SKIP $slug: not a child of the hub\n";
		continue;
	}
	if ( ! isset( $map[ '/class-action-lawyers/' . $slug . '/' ] ) ) {
		echo "SKIP $slug: no redirect in the deployed map\n";
		continue;
	}
	if ( 'publish' !== $p->post_status ) {
		echo "SKIP $slug ({$p->ID}): already {$p->post_status}\n";
		continue;
	}
	echo "{$p->ID} $slug: publish -> draft\n";
	if ( ! $apply ) {
		continue;
	}
	// Direct update, as the earlier retirements did: wp_update_post() would move
	// post_modified and fire save hooks. update_post_meta() unslashes, so slash.
	$wpdb->update( $wpdb->posts, array( 'post_status' => 'draft' ), array( 'ID' => $p->ID ), array( '%s' ), array( '%d' ) );
	update_post_meta( $p->ID, '_roden_retired', wp_slash( $reason ) );
	clean_post_cache( $p->ID );
	$done++;
}

$tt = get_page_by_path( 'class-action-lawyers/troubled-teen-industry-abuse' );
echo 'kept troubled-teen: ' . ( $tt ? get_post_status( $tt ) : 'NOT FOUND' ) . '; hub: ' . get_post_status( $hub ) . "\n";
echo $apply ? "retired $done\n" : "DRY RUN\n";
