<?php
/**
 * Retire post 1874 (/blog/georgia-car-seat-law-overview/) to draft after #204
 * redirected it to /resources/georgia-car-seat-laws/. Marked the same way as the
 * earlier retirements (_roden_retired = "<date> <reason>"). Owner, 2026-09-30: "do 1-2 now".
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/retire-ga-car-seat-post.php
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
global $wpdb;
$id = 1874;
$p  = get_post( $id );
if ( ! $p || 'georgia-car-seat-law-overview' !== $p->post_name ) { fwrite( STDERR, "ABORT: 1874 is not the car-seat post\n" ); exit( 1 ); }
$guide = get_page_by_path( 'georgia-car-seat-laws', OBJECT, 'resource' );
if ( ! $guide || 'publish' !== $guide->post_status ) { fwrite( STDERR, "ABORT: the replacement guide is not published\n" ); exit( 1 ); }
echo "1874 is {$p->post_status}; guide {$guide->ID} is {$guide->post_status}\n";
if ( ! $apply ) { echo "DRY RUN\n"; exit( 0 ); }
$wpdb->update( $wpdb->posts, array( 'post_status' => 'draft' ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
update_post_meta( $id, '_roden_retired', wp_slash( '2026-09-30 consolidated into /resources/georgia-car-seat-laws/' ) );
clean_post_cache( $id );
echo 'now ' . get_post_status( $id ) . "\n";
