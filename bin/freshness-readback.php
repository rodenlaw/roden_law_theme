<?php
/**
 * Read every refresh surface of the given posts back from the database.
 *
 *   ssh <host> "wp --path=<site> eval-file - 1651,1650,1824" < bin/freshness-readback.php > readback.json
 *
 * Compare content/excerpt/keyTakeaways/metaDescription/faqs against the run directory files after
 * an apply (normalize CRLF); never trust the patcher's own "wrote" line.
 */
$out = [];
foreach ([1746,1719,4590] as $id) { $p = get_post($id);
  $out[$id] = ['content'=>$p->post_content,'excerpt'=>$p->post_excerpt,'keyTakeaways'=>(string)get_post_meta($id,'_roden_key_takeaways',true),'faqs'=>maybe_unserialize(get_post_meta($id,'_roden_faqs',true)),'metaDescription'=>(string)get_post_meta($id,'_roden_meta_description',true),'reviewed'=>get_post_meta($id,'_roden_last_reviewed',true),'attorney'=>get_post_meta($id,'_roden_author_attorney',true),'refreshed'=>get_post_meta($id,'_roden_last_refreshed',true),'url'=>get_permalink($id)]; }
echo json_encode($out, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
