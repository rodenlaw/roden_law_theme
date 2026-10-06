<?php global $wpdb;
$pats = array( 'expenses' => '/(advance[sd]? (all|every|any)[^.]{0,40}(cost|expense)|(cover|pay)[sd]? (all|every) (case )?(costs|expenses)|all case (costs|expenses))/i',
               'counts'   => '/(dozens|hundreds|thousands) of (cases|clients|claims)|handled (dozens|hundreds|many|countless) /i',
               'county'   => '/(Murrells Inlet|Bellamy)[^.]{0,120}(Horry|Georgetown)|(Horry|Georgetown)[^.]{0,60}(office|Bellamy)/i' );
$rows = $wpdb->get_results( "SELECT ID,post_type,post_name FROM {$wpdb->posts} WHERE post_status='publish' AND post_type IN ('post','page','resource','location','practice_area')" );
foreach ( $rows as $r ) {
  $f = maybe_unserialize( get_post_meta( $r->ID, '_roden_faqs', true ) );
  $surf = array( 'content' => get_post( $r->ID )->post_content, 'excerpt' => get_post( $r->ID )->post_excerpt,
    'kt' => (string) get_post_meta( $r->ID, '_roden_key_takeaways', true ), 'local' => (string) get_post_meta( $r->ID, '_roden_local_content', true ),
    'faqs' => is_array( $f ) ? wp_json_encode( $f, JSON_UNESCAPED_UNICODE ) : '' );
  foreach ( $surf as $sn => $t ) { $t = wp_strip_all_tags( $t );
    foreach ( $pats as $k => $p ) if ( preg_match_all( $p, $t, $m, PREG_OFFSET_CAPTURE ) ) foreach ( $m[0] as $hit )
      echo "$k\t{$r->ID}\t{$r->post_type}\t{$r->post_name}\t$sn\t" . preg_replace( '/\s+/', ' ', substr( $t, max( 0, $hit[1] - 110 ), 260 ) ) . "\n"; }
}
