<?php
/**
 * Tests for inc/content-guardrails.php — runs standalone, no WordPress needed.
 *
 *   php bin/test-content-guardrails.php
 *
 * Committed because the guard's whole value is in the cases it must NOT block.
 * A rule that stops new sub-city pages is easy; one that stops them while leaving
 * 63 published location pages editable is the thing worth proving, and it is not
 * obvious from reading the code.
 *
 * Two of these cases already caught real bugs during development: the duplicate-
 * slug check originally sat in an else branch, so the freeze swallowed it and
 * reported the wrong reason; and the sub-city ban has to survive the freeze being
 * lifted, which it did not until the test said so.
 */
define('ABSPATH', '/tmp/');
class WP_Post { public $ID; public $post_parent; public $post_name; public $post_status;
  function __construct($i,$p,$n,$s){ $this->ID=$i; $this->post_parent=$p; $this->post_name=$n; $this->post_status=$s; } }
$GLOBALS['posts'] = array(
  10 => new WP_Post(10,0,'georgia','publish'),
  20 => new WP_Post(20,10,'savannah','publish'),
  30 => new WP_Post(30,20,'pooler','publish'),
);
function get_post($id){ return $GLOBALS['posts'][(int)$id] ?? null; }
function get_post_status($id){ $p=get_post($id); return $p? $p->post_status : false; }
function get_current_user_id(){ return 1; }
function set_transient($k,$v,$t){ $GLOBALS['notice']=$v; }
function get_transient($k){ return $GLOBALS['notice'] ?? false; }
function delete_transient($k){ unset($GLOBALS['notice']); }
function apply_filters($t,$v){ return $v; }
function add_filter(){} function add_action(){}
function __($s,$d=''){ return $s; } function esc_html($s){ return $s; } function esc_html__($s,$d=''){ return $s; }
require __DIR__ . '/../wordpress/wp-content/themes/roden-law/inc/content-guardrails.php';

function try_publish($label,$data,$postarr,$expect){
  unset($GLOBALS['notice']);
  $out = roden_guard_location_publish($data,$postarr);
  $got = $out['post_status'];
  $ok  = ($got === $expect);
  printf("%s %-52s -> %-7s %s\n", $ok?'ok  ':'FAIL', $label, $got, $ok?'':"(expected $expect)");
  if(!empty($GLOBALS['notice'])) printf("       reason: %s\n", substr($GLOBALS['notice'],0,72));
  return $ok;
}
$f=0;
// 1. editing an ALREADY PUBLISHED city page — must pass untouched
$f += !try_publish('edit published city hub (savannah)', array('post_type'=>'location','post_status'=>'publish','post_parent'=>10,'post_name'=>'savannah'), array('ID'=>20), 'publish');
// 2. editing an already published tier-3 survivor
$f += !try_publish('edit published tier-3 survivor (pooler)', array('post_type'=>'location','post_status'=>'publish','post_parent'=>20,'post_name'=>'pooler'), array('ID'=>30), 'publish');
// 3. NEW sub-city page (tier 3) — permanent ban
$f += !try_publish('NEW sub-city under savannah', array('post_type'=>'location','post_status'=>'publish','post_parent'=>20,'post_name'=>'ardsley-park'), array('ID'=>0), 'draft');
// 4. NEW tier-4
$f += !try_publish('NEW sub-sub-city under pooler', array('post_type'=>'location','post_status'=>'publish','post_parent'=>30,'post_name'=>'godley-station'), array('ID'=>0), 'draft');
// 5. duplicate slug = parent
$f += !try_publish('NEW page whose slug equals its parent', array('post_type'=>'location','post_status'=>'publish','post_parent'=>20,'post_name'=>'savannah'), array('ID'=>0), 'draft');
// 6. NEW city-tier under a state — frozen
$f += !try_publish('NEW city under georgia (freeze on)', array('post_type'=>'location','post_status'=>'publish','post_parent'=>10,'post_name'=>'brunswick'), array('ID'=>0), 'draft');
// 7. same, freeze lifted
define('RODEN_LOCATION_FREEZE', false);
$f += !try_publish('NEW city under georgia (freeze LIFTED)', array('post_type'=>'location','post_status'=>'publish','post_parent'=>10,'post_name'=>'brunswick'), array('ID'=>0), 'publish');
// 8. sub-city must STILL be blocked with freeze lifted
$f += !try_publish('NEW sub-city (freeze LIFTED) still banned', array('post_type'=>'location','post_status'=>'publish','post_parent'=>20,'post_name'=>'west-ashley'), array('ID'=>0), 'draft');
// 9. non-location post types untouched
$f += !try_publish('blog post is not a location', array('post_type'=>'post','post_status'=>'publish','post_parent'=>0,'post_name'=>'x'), array('ID'=>0), 'publish');
// 10. saving a location as draft is untouched
$f += !try_publish('saving a location as draft', array('post_type'=>'location','post_status'=>'draft','post_parent'=>20,'post_name'=>'y'), array('ID'=>0), 'draft');
printf("\n%d failures\n",$f);
exit($f?1:0);
