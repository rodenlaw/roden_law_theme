<?php
$t = 'I-16 Truck Accidents in Savannah: Port Freight, Construction Zones and Your Rights';
$r = wp_update_post( wp_slash( array( 'ID' => 4649, 'post_title' => $t ) ), true );
if ( is_wp_error( $r ) ) { fwrite( STDERR, $r->get_error_message() . "\n" ); exit( 1 ); }
clean_post_cache( 4649 ); $p = get_post( 4649 );
echo ( $p->post_title === $t ? 'OK ' : 'FAIL ' ) . "{$p->post_title} | {$p->post_name} | {$p->post_modified}\n";
