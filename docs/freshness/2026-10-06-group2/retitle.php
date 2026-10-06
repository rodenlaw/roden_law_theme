<?php
$t = array( 4537 => "Myrtle Beach's Highest-Crash Roads and Intersections: What the State Data Shows",
            4344 => "Folly Road Car Accidents: What Charleston Drivers Need to Know About James Island's Main Corridor" );
foreach ( $t as $id => $title ) {
  $r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_title' => $title ) ), true );
  if ( is_wp_error( $r ) ) { echo "ERR $id " . $r->get_error_message() . "\n"; continue; }
  clean_post_cache( $id ); $p = get_post( $id );
  echo ( $p->post_title === $title ? 'OK ' : 'FAIL ' ) . "$id {$p->post_title} | {$p->post_name}\n";
}
