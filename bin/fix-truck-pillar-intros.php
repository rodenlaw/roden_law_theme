<?php
/**
 * Correct the truck-accident pillar's two intro fields (post 3605), which render
 * with state tokens on every truck-accident office practice page — first the
 * Charleston rebuild (wave 1, #2). Same claim classes the 2026-09-26 legal sweep
 * found on the car pillar (data/facts/remediation-2026-09-26-charleston-car.md,
 * W4–W6), plus two authorities the signed SC pack does not hold:
 *
 * - "Both {state_full} and neighboring states allow full noneconomic recovery
 *   with no cap" — other states' law on a single-state page, and overstated
 *   (government claims are capped, S.C. Code § 15-78-120).
 * - "S.C. Code § 58-23-10 et seq." and the MCS-90 endorsement: not in the pack.
 * - "*negligence per se*" rendered with literal asterisks; "routinely support".
 *
 * The SC wording uses only statements the signed SC pack and the Gillin-reviewed
 * Charleston car page already carry. The Georgia branches are left as they were:
 * no Georgia office practice page is live, and they are for the GA reviewer.
 *
 *   Dry run: ssh $H "wp --path=$P eval-file -" < bin/fix-truck-pillar-intros.php > docs/backups/truck-pillar-intros-2026-09-26.json
 *   Apply:   ssh $H "wp --path=$P eval-file - apply" < bin/fix-truck-pillar-intros.php > docs/backups/truck-pillar-intros-2026-09-26.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3605;
$fix   = array(
    '_roden_pillar_negligence_intro'   => array( 'old' => "Commercial-trucking liability layers federal regulation onto state negligence: violations of the **Federal Motor Carrier Safety Regulations (49 C.F.R. Parts 350-399)** — hours-of-service, driver qualification, vehicle maintenance, drug/alcohol testing, ELD recordkeeping — routinely support *negligence per se* claims against both driver and motor carrier. Defendants typically include the driver, the motor carrier, the broker, the shipper, and the insurer. {{GA}}In Georgia, **O.C.G.A. § 40-1-112** historically permitted direct action against the carrier's liability insurer (procedural rules amended in recent legislation; verify current posture before filing).{{/GA}}{{SC}}South Carolina motor carriers are regulated under **S.C. Code § 58-23-10 et seq.**{{/SC}} A {sol_years}-year statute of limitations applies under {sol_cite}.", 'new' => "Commercial-trucking cases layer federal safety rules onto ordinary negligence: the **Federal Motor Carrier Safety Regulations** govern hours of service, driver qualification, vehicle maintenance, and drug and alcohol testing, and a violation can be strong evidence that the driver or the carrier was careless. Defendants can include the driver, the motor carrier, a broker, a shipper, and the companies that loaded or maintained the truck. {{GA}}In Georgia, **O.C.G.A. § 40-1-112** historically permitted direct action against the carrier's liability insurer (procedural rules amended in recent legislation; verify current posture before filing).{{/GA}} You generally have {sol_years} years to file ({sol_cite})." ),
    '_roden_pillar_compensation_intro' => array( 'old' => "Catastrophic medicals, future life-care plans, and substantial lost-earning-capacity claims dominate commercial-truck cases, often justifying multi-policy pursuit (primary + excess + the **MCS-90 endorsement** required for interstate carriers). Both {state_full} and neighboring states allow **full noneconomic recovery** with no cap on ordinary commercial-trucking claims. {{GA}}Georgia's \$250,000 punitive cap is removed in DUI and intoxication cases under O.C.G.A. § 51-12-5.1(f). {{/GA}}Falsified logs, hours-of-service violations, and gross safety-management failures often justify punitive exposure independent of the underlying compensatory claim.", 'new' => "Catastrophic medical costs, future care, and lost earning capacity often dominate commercial-truck cases, and more than one insurance policy can apply. {{SC}}Noneconomic damages such as pain and suffering are recoverable, and any award is reduced by your share of fault. Claims against a government entity are capped at \$300,000 per person and \$600,000 per occurrence (S.C. Code § 15-78-120).{{/SC}}{{GA}}Georgia's \$250,000 punitive cap is removed in DUI and intoxication cases under O.C.G.A. § 51-12-5.1(f). {{/GA}} Falsified logs, hours-of-service violations, and gross safety-management failures can support a claim for punitive damages." ),
);
$backup = array( 'generated' => gmdate( 'c' ), 'post' => $id, 'mode' => $apply ? 'apply' : 'dry-run', 'before' => array() );
foreach ( $fix as $k => $f ) {
    $cur = (string) get_post_meta( $id, $k, true );
    $backup['before'][ $k ] = $cur;
    if ( $cur === $f['new'] ) { fprintf( $err, "  %s already corrected\n", $k ); continue; }
    if ( $cur !== $f['old'] && ! in_array( $cur, $f['prior'] ?? array(), true ) ) { fprintf( $err, "ABORT: %s is not the text the sweep read.\n", $k ); exit( 1 ); }
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
