<?php
/**
 * Correct how Nestlehutt is described on the ES Georgia car-accident page.
 *
 * Atlanta Oculoplastic Surgery, P.C. v. Nestlehutt (2010) struck O.C.G.A.
 * § 51-13-1 — the $350,000 cap on noneconomic damages in MEDICAL MALPRACTICE
 * actions. Georgia never had a general noneconomic cap covering car accidents.
 * The page's conclusion (no cap in car cases) is right; the reason it gave was
 * not. Adapted from the EN twin, which has the same error.
 */
$mode = isset($args[0]) ? $args[0] : 'dry-run';
$p = get_page_by_path('es-georgia-car-accident-settlement-value', OBJECT, 'resource');
if ( ! $p ) { echo "post not found\n"; exit(1); }

$body_from = 'Georgia <strong>no impone ningún tope a los daños compensatorios</strong> en casos de auto — la Corte Suprema de Georgia anuló el tope estatal a los daños no económicos en <em>Atlanta Oculoplastic Surgery, P.C. v. Nestlehutt</em> (2010), así que el jurado puede otorgar la medida completa del dolor y la pérdida de la víctima.';
$body_to   = 'Georgia <strong>no impone ningún tope a los daños compensatorios</strong> en casos de auto, así que el jurado puede otorgar la medida completa del dolor y la pérdida de la víctima. El único tope estatal a los daños no económicos que llegó a existir aplicaba a los casos de negligencia médica, y la Corte Suprema de Georgia lo anuló en <em>Atlanta Oculoplastic Surgery, P.C. v. Nestlehutt</em> (2010).';

$faq_from = 'No. Georgia no impone ningún tope a los daños compensatorios en casos de accidentes de auto — la Corte Suprema de Georgia anuló el tope a los daños no económicos en Atlanta Oculoplastic Surgery v. Nestlehutt (2010).';
$faq_to   = 'No. Georgia no impone ningún tope a los daños compensatorios en casos de accidentes de auto. El único tope estatal a los daños no económicos aplicaba a los casos de negligencia médica, y la Corte Suprema de Georgia lo anuló en Atlanta Oculoplastic Surgery v. Nestlehutt (2010).';

$c = $p->post_content;
$hit_body = ( false !== strpos($c, $body_from) );
$faqs = get_post_meta($p->ID,'_roden_faqs',true); $faqs = is_array($faqs)?$faqs:array();
$hit_faq = -1;
foreach ($faqs as $i=>$q) if ( false !== strpos($q['answer'], $faq_from) ) { $hit_faq = $i; break; }

printf("body match: %s\nfaq match : %s\n", $hit_body?'yes':'NO', $hit_faq>=0?('faq '.($hit_faq+1)):'NO');
if ( ! $hit_body || $hit_faq < 0 ) { echo "\nAborting — text did not match exactly; nothing changed.\n"; exit(1); }

if ( 'apply' === $mode ) {
    $res = wp_update_post(array('ID'=>$p->ID,'post_content'=>str_replace($body_from,$body_to,$c)), true);
    if ( is_wp_error($res) ) { echo "FAILED: ".$res->get_error_message()."\n"; exit(1); }
    $faqs[$hit_faq]['answer'] = str_replace($faq_from,$faq_to,$faqs[$hit_faq]['answer']);
    update_post_meta($p->ID,'_roden_faqs',$faqs);
    update_post_meta($p->ID,'_roden_last_reviewed', gmdate('Y-m-d'));
    echo "\nApplied to post {$p->ID}.\n";
} else {
    echo "\nDry run — nothing written. Re-run with 'apply'.\n";
}
