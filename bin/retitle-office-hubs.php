<?php
/**
 * P2 step 1 (docs/site-architecture): retitle the six English office hubs to the
 * head term, "[City] Personal Injury Lawyer | Roden Law". Owner, 2026-09-29:
 * "start P2". The auto-built titles led with the place ("Charleston, SC – South
 * Carolina Personal Injury Lawyers – Roden Law"). Evidence (query-clusters.csv,
 * generic_pi): Charleston 264,949 impressions / 31 clicks in 16 months, split
 * between the homepage (44%) and the hub (40%); Savannah 199,570 / 8 at 24.5.
 *
 * Uses _roden_meta_title, which roden_seo_title_optimization() treats as the
 * complete <title>; post_title (and so the H1 and breadcrumbs) is untouched.
 * Columbia carries ", SC" to separate it from other Columbias; Darien stays
 * Darien pending the P2 "one Darien-area landing" decision.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/retitle-office-hubs.php > docs/backups/office-hub-titles-2026-09-29.json
 */
$apply  = isset( $args[0] ) && 'apply' === $args[0];
$titles = array(
	3599 => 'Charleston Personal Injury Lawyer | Roden Law',
	3597 => 'Savannah Personal Injury Lawyer | Roden Law',
	3600 => 'Columbia, SC Personal Injury Lawyer | Roden Law',
	3763 => 'North Charleston Personal Injury Lawyer | Roden Law',
	3598 => 'Darien, GA Personal Injury Lawyer | Roden Law',
	3601 => 'Myrtle Beach Personal Injury Lawyer | Roden Law',
);
$backup = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'before' => array() );
foreach ( $titles as $id => $t ) {
	if ( 'location' !== get_post_type( $id ) || 'publish' !== get_post_status( $id ) ) { fwrite( STDERR, "ABORT: $id is not a published location\n" ); exit( 1 ); }
	$cur = (string) get_post_meta( $id, '_roden_meta_title', true );
	$backup['before'][ $id ] = $cur;
	fwrite( STDERR, sprintf( "  %d %-45s '%s' -> '%s'\n", $id, wp_make_link_relative( get_permalink( $id ) ), $cur, $t ) );
	if ( $apply ) {
		update_post_meta( $id, '_roden_meta_title', wp_slash( $t ) );
		clean_post_cache( $id );
		if ( get_post_meta( $id, '_roden_meta_title', true ) !== $t ) { fwrite( STDERR, "FAILED read-back $id\n" ); exit( 1 ); }
	}
}
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
