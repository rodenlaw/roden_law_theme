<?php
/**
 * Tier-1 batch 4 — three instances the first three batches missed, found by a
 * full residual re-sweep of production rather than by re-reading the audit.
 *
 * WHY THEY WERE MISSED. All three were on pages the audit had not listed,
 * phrased differently from the instances it did list:
 *
 *   4048 drunk-driver-accident — the audit's §1.2 detector looked for
 *        "no statutory cap on punitive". This page says "does not impose a
 *        statutory cap on punitive damages" in the body and, in a FAQ answer,
 *        drops the noun entirely: "South Carolina has no statutory cap but
 *        requires clear and convincing evidence." No string search for the
 *        original phrasing could have found the second one.
 *
 *   4337 ashley-phosphate-road-i-26-dangerous-intersection-charleston — a
 *        near-twin slug of ashley-phosphate-i-26-south-carolinas-deadliest-
 *        intersection, which batch 2 did fix. Two pages, one corridor, one
 *        error, and only one of them was on the list.
 *
 * The clear-and-convincing point on 4048 is TRUE and is kept — S.C. Code
 * § 15-33-135 does require that standard. Only the "no cap" half is false:
 * § 15-32-530 caps punitive damages at the greater of 3x compensatory or
 * $500,000. Removing a true statement alongside a false one would be its own
 * kind of sloppiness.
 *
 * Two residual-sweep hits were checked and deliberately NOT changed:
 *   - negligence-vs-gross-negligence cites "a BAC of 0.15 or higher (nearly
 *     double the legal limit)" as an EXAMPLE OF GROSS NEGLIGENCE, not as a
 *     punitive-cap threshold. That is accurate and stays.
 *   - Nine pages saying South Carolina does not cap compensatory damages are
 *     all correctly qualified ("in ordinary injury cases", "the medical-
 *     malpractice cap is the narrow exception"). Also accurate, also stays.
 *
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/fix-tier1-batch4-stragglers.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/fix-tier1-batch4-stragglers.php
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

global $wpdb;
$apply = isset( $args[0] ) && 'apply' === $args[0];
$out   = fopen( 'php://stdout', 'w' );
$today = '2026-08-26';

$edits = array(
array( 'id' => 4048, 'surface' => 'content', 'expect' => 1,
 'from' => 'South Carolina does not impose a statutory cap on punitive damages but requires clear and convincing evidence of willful, wanton, or reckless conduct.',
 'to'   => 'South Carolina caps punitive damages at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530), and requires clear and convincing evidence of willful, wanton, or reckless conduct.' ),
array( 'id' => 4048, 'surface' => 'faq:2:answer', 'expect' => 1,
 'from' => 'South Carolina has no statutory cap but requires clear and convincing evidence.',
 'to'   => 'South Carolina caps them at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530) and requires clear and convincing evidence.' ),
array( 'id' => 4337, 'surface' => 'content', 'expect' => 1,
 'from' => 'the South Carolina Tort Claims Act imposes additional procedural requirements that must be met well before the three-year deadline.',
 'to'   => 'the South Carolina Tort Claims Act shortens the filing deadline to two years rather than three (S.C. Code § 15-78-110), unless a verified claim is filed with the agency within one year.' ),
);

fprintf( $out, "%s\n\n", $apply ? '=== APPLY ===' : '=== DRY RUN ===' );
$backup=array(); $ok=0; $skipped=0; $dc=array(); $df=array(); $touched=array();
foreach ( $edits as $e ) {
	$id=(int)$e['id']; $expect=(int)$e['expect'];
	if ( ! isset($backup[$id]) ) {
		$row=$wpdb->get_row($wpdb->prepare("SELECT ID,post_name,post_content FROM {$wpdb->posts} WHERE ID=%d",$id));
		if(!$row){fprintf($out,"!! %d not found\n",$id);$skipped++;continue;}
		$backup[$id]=array('ID'=>$id,'post_name'=>$row->post_name,'post_content'=>$row->post_content,'faqs'=>get_post_meta($id,'_roden_faqs',true));
	}
	if ( 'content'===$e['surface'] ) {
		$cur=isset($dc[$id])?$dc[$id]:$backup[$id]['post_content'];
		$n=substr_count($cur,$e['from']);
		if($n!==$expect){fprintf($out,"!! SKIP [%d] content matched %d expected %d\n",$id,$n,$expect);$skipped++;continue;}
		$dc[$id]=str_replace($e['from'],$e['to'],$cur); $touched[$id]=true; $ok++;
		fprintf($out,"OK   [%d] content\n     - %s…\n     + %s…\n",$id,substr($e['from'],0,86),substr($e['to'],0,86));
		continue;
	}
	list(,$idx,)=explode(':',$e['surface']); $idx=(int)$idx;
	$faqs=isset($df[$id])?$df[$id]:$backup[$id]['faqs'];
	if(!is_array($faqs)||!isset($faqs[$idx]['answer'])){fprintf($out,"!! SKIP [%d] faq[%d]\n",$id,$idx);$skipped++;continue;}
	$n=substr_count($faqs[$idx]['answer'],$e['from']);
	if($n!==$expect){fprintf($out,"!! SKIP [%d] faq[%d] matched %d expected %d\n",$id,$idx,$n,$expect);$skipped++;continue;}
	$faqs[$idx]['answer']=str_replace($e['from'],$e['to'],$faqs[$idx]['answer']);
	$df[$id]=$faqs; $touched[$id]=true; $ok++;
	fprintf($out,"OK   [%d] faq[%d]\n     - %s…\n     + %s…\n",$id,$idx,substr($e['from'],0,86),substr($e['to'],0,86));
}
fprintf($out,"\nedits: %d ok, %d skipped, %d posts\n",$ok,$skipped,count($touched));
if($skipped>0){fprintf($out,"\nABORTING — nothing written.\n");exit(1);}
if(!$apply){fprintf($out,"\nDry run only.\n");exit(0);}
$file=sprintf('/tmp/roden-tier1-batch4-backup-%s.json',gmdate('Ymd-His'));
file_put_contents($file,wp_json_encode(array_values($backup),JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
fprintf($out,"\nbackup: %s\n\n",$file);
foreach(array_keys($touched) as $id){
	if(isset($dc[$id])) $wpdb->update($wpdb->posts,array('post_content'=>$dc[$id]),array('ID'=>$id),array('%s'),array('%d'));
	if(isset($df[$id])) update_post_meta($id,'_roden_faqs',$df[$id]);
	update_post_meta($id,'_roden_last_refreshed',$today);
	$c=$wpdb->get_var($wpdb->prepare("SELECT post_content FROM {$wpdb->posts} WHERE ID=%d",$id));
	$f=get_post_meta($id,'_roden_faqs',true);
	$blob=$c.(is_array($f)?wp_json_encode($f):'');
	$stale=0; foreach($edits as $e){ if((int)$e['id']===$id) $stale+=substr_count($blob,$e['from']); }
	fprintf($out,"[%d] written · stale: %d %s\n",$id,$stale,$stale?'!!':'OK');
}
fprintf($out,"\nDone.\n");
