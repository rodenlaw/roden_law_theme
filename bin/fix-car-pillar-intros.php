<?php
/**
 * Correct the car-accident pillar's two intro fields (post 3604), which render
 * with state tokens on every car-accident office practice page. Findings W4–W6
 * of data/facts/remediation-2026-09-26-charleston-car.md (legal sweep of the
 * Charleston rebuild, 2026-09-26):
 *
 * - negligence intro: negligence per se stated with no SC evidence carve-outs
 *   (S.C. Code §§ 56-5-6540, 56-5-6460); '*negligence per se*' rendered with
 *   literal asterisks; the deadline stated as absolute.
 * - compensation intro: a claim about "any neighboring state" on a single-state
 *   page; "UM/UIM stacking" (no pack authority); "limited only by the evidence",
 *   which contradicts the SC Tort Claims Act caps (§ 15-78-120).
 *
 * SC wording is inside {{SC}}…{{/SC}}, so no SC citation reaches a Georgia page;
 * the Georgia branch states only that Georgia is an at-fault state with UM/UIM as
 * a second source. Exact-match: refuses if the stored text is not what the sweep
 * read. Writes through update_post_meta( wp_slash() ); reads back.
 *
 *   Dry run: ssh $H "wp --path=$P eval-file -" < bin/fix-car-pillar-intros.php > docs/backups/car-pillar-intros-2026-09-26.json
 *   Apply:   ssh $H "wp --path=$P eval-file - apply" < bin/fix-car-pillar-intros.php > docs/backups/car-pillar-intros-2026-09-26.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3604;

$fix = array(
    '_roden_pillar_negligence_intro' => array(
        'old' => "Most {state_full} car-accident cases are governed by ordinary negligence: you must prove the other driver owed a duty of care, breached it, caused your injuries, and that you suffered actual damages. Violating a Rule of the Road ({state_short}-specific traffic statutes) supports a *negligence per se* theory and can be powerful evidence at trial. {state_full}'s comparative-fault rule bars recovery if you are {comp_fault_threshold} or more at fault, so insurers in {market_name} routinely contest fault percentages. You have **{sol_years} years from the crash date** to file ({sol_cite}) — missing the deadline forfeits your right to recover regardless of how strong the case is.",
        'new' => "Most {state_full} car-accident cases are governed by ordinary negligence: you must prove the other driver owed a duty of care, breached it, caused your injuries, and that you suffered actual damages. Violating a traffic statute can support a negligence per se theory and can be powerful evidence at trial{{SC}}, although South Carolina bars some violations from evidence entirely, such as not wearing a seat belt (S.C. Code § 56-5-6540) or a child-restraint violation (S.C. Code § 56-5-6460){{/SC}}. {state_full}'s comparative-fault rule bars recovery if you are {comp_fault_threshold} or more at fault, so insurers in {market_name} routinely contest fault percentages. You generally have **{sol_years} years from the crash date** to file ({sol_cite}). Missing the deadline usually ends your right to recover, however strong the case.",
    ),
    '_roden_pillar_compensation_intro' => array(
        'old' => "Neither {state_full} nor any neighboring state operates a no-fault auto system — recovery flows through the at-fault driver's liability policy, with **uninsured/underinsured motorist (UM/UIM) stacking** as a critical secondary source when injuries exceed the at-fault driver's minimum 25/50/25 limits. There is **no statutory cap on noneconomic damages** in ordinary auto cases in {state_full}, so pain-and-suffering, loss of enjoyment, and disfigurement recoveries are limited only by the evidence and the comparative-fault bar. Economic damages typically include past and future medicals, lost wages, loss of earning capacity, and property damage.",
        'new' => "{{SC}}South Carolina is an at-fault state: recovery flows through the at-fault driver's liability policy, which need only carry $25,000 per person and $50,000 per accident (S.C. Code § 38-77-140), with your own **uninsured and underinsured motorist (UM/UIM) coverage** as a critical second source (S.C. Code §§ 38-77-150, 38-77-160). South Carolina sets no general cap on noneconomic damages in a claim against a private driver, so pain and suffering, loss of enjoyment and disfigurement are limited by the evidence and the comparative-fault bar. Claims against a government entity are the exception: recovery is capped at $300,000 per person and $600,000 per occurrence (S.C. Code § 15-78-120).{{/SC}}{{GA}}Georgia is an at-fault state: recovery flows through the at-fault driver's liability policy, with your own **uninsured/underinsured motorist (UM/UIM) coverage** as a critical second source when injuries exceed that policy's limits.{{/GA}} Economic damages typically include past and future medicals, lost wages, loss of earning capacity, and property damage.",
    ),
);

$backup = array( 'generated' => gmdate( 'c' ), 'post' => $id, 'mode' => $apply ? 'apply' : 'dry-run', 'before' => array() );
foreach ( $fix as $k => $f ) {
    $cur = (string) get_post_meta( $id, $k, true );
    $backup['before'][ $k ] = $cur;
    if ( $cur === $f['new'] ) { fprintf( $err, "  %s already corrected\n", $k ); continue; }
    if ( $cur !== $f['old'] ) { fprintf( $err, "ABORT: %s is not the text the sweep read.\n", $k ); exit( 1 ); }
    fprintf( $err, "  %s: would replace (%d -> %d chars)\n", $k, strlen( $cur ), strlen( $f['new'] ) );
}
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
if ( ! $apply ) { exit( 0 ); }
global $wpdb; $ok = true;
foreach ( $fix as $k => $f ) {
    update_post_meta( $id, $k, wp_slash( $f['new'] ) );
    $back = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s", $id, $k ) );
    $ok   = $ok && $back === $f['new'];
    fprintf( $err, "  %s: %s\n", $k, $back === $f['new'] ? 'written, read back exact' : 'MISMATCH' );
}
clean_post_cache( $id );
exit( $ok ? 0 : 1 );
