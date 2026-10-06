<?php
$a = (int) get_post_thumbnail_id( 4649 ); $old = get_post_meta( $a, '_wp_attachment_image_alt', true );
$new = 'I-16 Truck Accidents in Savannah: Port Freight, Construction Zones and Your Rights';
echo "attachment $a | title: " . get_the_title( $a ) . " | alt: $old\n";
if ( false === strpos( $old, 'Deadliest' ) ) { echo "no change\n"; exit( 0 ); }
update_post_meta( $a, '_wp_attachment_image_alt', wp_slash( $new ) ); clean_post_cache( $a );
echo 'now: ' . get_post_meta( $a, '_wp_attachment_image_alt', true ) . "\n";
