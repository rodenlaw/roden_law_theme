<?php
/**
 * Correct the motorcycle-accident pillar's two intro fields (post 3607), which
 * render with state tokens on every motorcycle office practice page — first the
 * Charleston rebuild (wave 1, #7 of docs/site-architecture/README.md). Read
 * before the page was drafted, 2026-09-28; the same claim classes the car and
 * truck pillars carried:
 *
 * - "most courts disallow the so-called 'helmet defense' … injury-enhancement
 *   arguments persist" — an unsourced survey of case law, in no pack.
 * - "Lane-splitting is illegal in both states" — uncited, and two-state text on a
 *   single-state page.
 * - "Both {state_full} and neighboring states allow UM/UIM stacking" — other
 *   states' law on a single-state page, and not what the SC pack holds; and the
 *   "household resident-relative coverage" layering claim with it.
 *
 * Removals only, plus the UM/UIM wording the signed SC pack (§§ 38-77-150,
 * 38-77-160) and the Gillin-reviewed Charleston truck page already carry. The
 * SC helmet sentence (§ 56-5-3660) was already live and is kept as it was; the
 * Georgia helmet sentence is left for the GA reviewer.
 *
 *   Dry run: ssh $H "wp --path=$P eval-file -" < bin/fix-motorcycle-pillar-intros.php > docs/backups/motorcycle-pillar-intros-2026-09-28.json
 *   Apply:   ssh $H "wp --path=$P eval-file - apply" < bin/fix-motorcycle-pillar-intros.php > docs/backups/motorcycle-pillar-intros-2026-09-28.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3607;
$fix   = array(
    '_roden_pillar_negligence_intro' => array(
        'old' => "Motorcycle cases follow the same four-element negligence framework as auto cases, but defenses are heavily flavored by jury bias against riders. {{GA}}Georgia requires **universal helmet use** under O.C.G.A. § 40-6-315. {{/GA}}{{SC}}South Carolina requires helmets only for riders under 21 under S.C. Code § 56-5-3660. {{/SC}}Whether a non-helmeted rider's injuries can be reduced under comparative-fault analysis is hotly litigated — most courts disallow the so-called \"helmet defense\" as to the *cause* of the crash, but injury-enhancement arguments persist. Lane-splitting is illegal in both states. {state_full}'s {comp_fault_threshold} comparative-fault bar applies, with {sol_years} years to file under {sol_cite}.",
        'new' => "Motorcycle cases follow the same negligence rules as car cases, but riders often have to overcome an insurer's assumption that the rider was to blame. {{GA}}Georgia requires **universal helmet use** under O.C.G.A. § 40-6-315. {{/GA}}{{SC}}South Carolina requires helmets only for riders under 21 under S.C. Code § 56-5-3660. {{/SC}}{state_full}'s {comp_fault_threshold} comparative-fault bar applies, with {sol_years} years to file under {sol_cite}.",
    ),
    '_roden_pillar_compensation_intro' => array(
        'old' => "Damages in motorcycle cases skew catastrophic — traumatic brain injury, road rash, orthopedic trauma, and limb loss are common — so noneconomic damages and future-care life-care plans carry the case. Both {state_full} and neighboring states allow **UM/UIM stacking**, which becomes critical because at-fault drivers in motorcycle cases are frequently underinsured relative to injury severity. Motorcycle-specific damages can also include the value of the bike, riding gear, and aftermarket modifications. Recovery in {market_name} cases often requires layering the at-fault policy, the rider's UM/UIM, and any household resident-relative coverage.",
        'new' => "Injuries in motorcycle crashes are often severe — traumatic brain injury, road rash, fractures, and limb loss — so pain and suffering and the cost of future care often carry the case. An at-fault driver's policy may not cover injuries this serious, which makes your own coverage matter.{{SC}} Every South Carolina auto policy must include uninsured motorist coverage (S.C. Code § 38-77-150), and insurers must offer underinsured motorist coverage (S.C. Code § 38-77-160).{{/SC}} Motorcycle-specific damages can also include the value of the bike, riding gear, and aftermarket modifications.",
    ),
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
