<?php
/**
 * Seed pillar negligence + compensation intros — chunk 1 of 3 (PAs 1-7).
 *
 * Run on WP Engine via:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-pillar-intros-1.php
 *
 * Populates _roden_pillar_negligence_intro and _roden_pillar_compensation_intro
 * on practice_area pillar posts. Content uses {token} placeholders that get
 * replaced per-intersection by roden_replace_local_tokens() in template-tags.php.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$pillar_intros = array(

    'car-accident-lawyers' => array(
        'negligence' => <<<'EOT'
Most {state_full} car-accident cases are governed by ordinary negligence: you must prove the other driver owed a duty of care, breached it, caused your injuries, and that you suffered actual damages. Violating a Rule of the Road ({state_short}-specific traffic statutes) supports a *negligence per se* theory and can be powerful evidence at trial. {state_full}'s comparative-fault rule bars recovery if you are {comp_fault_threshold} or more at fault, so insurers in {market_name} routinely contest fault percentages. You have **{sol_years} years from the crash date** to file ({sol_cite}) — missing the deadline forfeits your right to recover regardless of how strong the case is.
EOT
,
        'compensation' => <<<'EOT'
Neither {state_full} nor any neighboring state operates a no-fault auto system — recovery flows through the at-fault driver's liability policy, with **uninsured/underinsured motorist (UM/UIM) stacking** as a critical secondary source when injuries exceed the at-fault driver's minimum 25/50/25 limits. There is **no statutory cap on noneconomic damages** in ordinary auto cases in {state_full}, so pain-and-suffering, loss of enjoyment, and disfigurement recoveries are limited only by the evidence and the comparative-fault bar. Economic damages typically include past and future medicals, lost wages, loss of earning capacity, and property damage.
EOT
,
    ),

    'truck-accident-lawyers' => array(
        'negligence' => <<<'EOT'
Commercial-trucking liability layers federal regulation onto state negligence: violations of the **Federal Motor Carrier Safety Regulations (49 C.F.R. Parts 350-399)** — hours-of-service, driver qualification, vehicle maintenance, drug/alcohol testing, ELD recordkeeping — routinely support *negligence per se* claims against both driver and motor carrier. Defendants typically include the driver, the motor carrier, the broker, the shipper, and the insurer. In Georgia, **O.C.G.A. § 40-1-112** historically permitted direct action against the carrier's liability insurer (procedural rules amended in recent legislation; verify current posture before filing). South Carolina motor carriers are regulated under **S.C. Code § 58-23-10 et seq.** Both states impose a {sol_years}-year statute of limitations under {sol_cite}.
EOT
,
        'compensation' => <<<'EOT'
Catastrophic medicals, future life-care plans, and substantial lost-earning-capacity claims dominate commercial-truck cases, often justifying multi-policy pursuit (primary + excess + the **MCS-90 endorsement** required for interstate carriers). Both {state_full} and neighboring states allow **full noneconomic recovery** with no cap on ordinary commercial-trucking claims; Georgia's $250,000 punitive cap is removed in DUI and intoxication cases under O.C.G.A. § 51-12-5.1(f). Falsified logs, hours-of-service violations, and gross safety-management failures often justify punitive exposure independent of the underlying compensatory claim.
EOT
,
    ),

    'slip-and-fall-lawyers' => array(
        'negligence' => <<<'EOT'
Slip-and-fall is governed by **premises liability** doctrine, which keys liability to the visitor's status — invitee (highest duty), licensee (limited duty), or trespasser (minimal duty). In Georgia, an invitee must prove the owner had **actual or constructive knowledge** of the hazard and that the plaintiff lacked equal knowledge — the controlling test from *Robinson v. Kroger Co.*, 268 Ga. 735 (1997). South Carolina applies a similar framework under *Wintersteen v. Food Lion, Inc.*, 344 S.C. 32 (2001). Hazard documentation (incident reports, surveillance video, prior cleaning logs) is decisive evidence in {market_name}-area cases.
EOT
,
        'compensation' => <<<'EOT'
No special statutory caps apply to slip-and-fall recoveries in {state_full}; damages follow the ordinary tort model — past and future medicals, lost wages, loss of earning capacity, pain and suffering, and disfigurement. {state_full}'s comparative-fault analysis (recovery barred at {comp_fault_threshold} fault under {sol_cite}'s sister apportionment statute) frequently turns on the open-and-obvious nature of the hazard, the plaintiff's footwear, and distraction. Defendants commonly include the property owner, the property manager, the cleaning contractor, and any tenant in control of the affected area.
EOT
,
    ),

    'motorcycle-accident-lawyers' => array(
        'negligence' => <<<'EOT'
Motorcycle cases follow the same four-element negligence framework as auto cases, but defenses are heavily flavored by jury bias against riders. Georgia requires **universal helmet use** under O.C.G.A. § 40-6-315; South Carolina requires helmets only for riders under 21 under S.C. Code § 56-5-3660. Whether a non-helmeted rider's injuries can be reduced under comparative-fault analysis is hotly litigated — most courts disallow the so-called "helmet defense" as to the *cause* of the crash, but injury-enhancement arguments persist. Lane-splitting is illegal in both states. {state_full}'s {comp_fault_threshold} comparative-fault bar applies, with {sol_years} years to file under {sol_cite}.
EOT
,
        'compensation' => <<<'EOT'
Damages in motorcycle cases skew catastrophic — traumatic brain injury, road rash, orthopedic trauma, and limb loss are common — so noneconomic damages and future-care life-care plans carry the case. Both {state_full} and neighboring states allow **UM/UIM stacking**, which becomes critical because at-fault drivers in motorcycle cases are frequently underinsured relative to injury severity. Motorcycle-specific damages can also include the value of the bike, riding gear, and aftermarket modifications. Recovery in {market_name} cases often requires layering the at-fault policy, the rider's UM/UIM, and any household resident-relative coverage.
EOT
,
    ),

    'medical-malpractice-lawyers' => array(
        'negligence' => <<<'EOT'
Medical malpractice replaces "ordinary care" with the **standard of care** of a reasonably prudent practitioner in the same specialty. **Georgia requires a contemporaneous expert affidavit** with the complaint setting forth at least one negligent act under O.C.G.A. § 9-11-9.1 — failure is grounds for dismissal. **South Carolina requires a Notice of Intent to File Suit and an expert affidavit** under S.C. Code § 15-79-125, plus a mandatory pre-suit mediation period before suit can proceed. Statutes of limitations: GA = 2 years from injury with a 5-year statute of repose (O.C.G.A. § 9-3-71); SC = 3 years from discovery with a 6-year repose (S.C. Code § 15-3-545). In {market_name}, claims commonly arise out of {office_court}'s jurisdictional area.
EOT
,
        'compensation' => <<<'EOT'
**Georgia has no statutory cap on noneconomic damages** in medical malpractice cases since *Atlanta Oculoplastic Surgery, P.C. v. Nestlehutt*, 286 Ga. 731 (2010), which struck down O.C.G.A. § 51-13-1 as a violation of the right to jury trial. **South Carolina caps noneconomic damages at $350,000 per defendant / $1.05 million aggregate** under S.C. Code § 15-32-220, adjusted annually for inflation. Economic damages — past and future medicals, lost wages, lost earning capacity, attendant care — are uncapped in both states. Punitive damages are available for gross negligence with separate statutory caps.
EOT
,
    ),

    'wrongful-death-lawyers' => array(
        'negligence' => <<<'EOT'
Both Georgia and South Carolina permit a **wrongful-death action** plus a separate **survival action** for the decedent's pre-death pain, suffering, and medical expenses. Standing differs sharply: in **Georgia**, the surviving spouse holds the wrongful-death claim, with children sharing under O.C.G.A. § 51-4-2; in **South Carolina**, the **personal representative** brings the action for the benefit of statutory beneficiaries (S.C. Code § 15-51-10 to -60). Filing deadlines: GA = 2 years from death (O.C.G.A. § 9-3-33); SC = 3 years from death (S.C. Code § 15-3-530). The underlying tort — auto crash, medical negligence, defective product — must be independently provable.
EOT
,
        'compensation' => <<<'EOT'
**Georgia's "full value of the life of the decedent" measure (O.C.G.A. § 51-4-1(1)) is among the broadest wrongful-death recoveries in the United States** — it captures both the economic *and* intangible value of the life as the decedent would have lived it, with **no offset for the decedent's living expenses**. South Carolina's measure is more conventional: pecuniary loss to beneficiaries plus mental anguish and loss of companionship, society, and consortium under S.C. Code § 15-51-40. Survival claims (GA: O.C.G.A. § 9-2-41; SC: S.C. Code § 15-5-90) recover pre-death pain, suffering, and funeral and medical expenses.
EOT
,
    ),

    'workers-compensation-lawyers' => array(
        'negligence' => <<<'EOT'
Workers' compensation is a **no-fault statutory scheme** that *replaces* common-law negligence: the injured worker need not prove fault, but in exchange gives up the right to sue the employer for tort damages (the "exclusive remedy" bar). To qualify, the injury must "arise out of and in the course of" employment. Georgia: O.C.G.A. § 34-9-1 et seq.; South Carolina: S.C. Code § 42-1-10 et seq. **Third-party tort claims against non-employer tortfeasors remain available** (e.g., a defective machine manufacturer, a negligent driver who hits you at work, a property owner where you were injured) and can be pursued in parallel with the workers' comp claim.
EOT
,
        'compensation' => <<<'EOT'
**There is no recovery for pain and suffering in workers' compensation** — only statutory benefits: medical (uncapped, related), temporary total disability (TTD) at 2/3 of average weekly wage subject to a state maximum, permanent partial disability per the body-part schedule, and (for fatalities) death benefits to surviving dependents. **Georgia's TTD maximum is set by statute and adjusted periodically** (O.C.G.A. § 34-9-261, § 34-9-265). **South Carolina TTD tracks the statewide average weekly wage** with permanent partial disability scheduled by body part under S.C. Code § 42-9-30. Third-party tort recoveries fund the noneconomic damages workers' comp does not cover.
EOT
,
    ),

);

$updated = 0;
$missing = array();
foreach ( $pillar_intros as $slug => $content ) {
    $post = get_page_by_path( $slug, OBJECT, 'practice_area' );
    if ( ! $post ) {
        $missing[] = $slug;
        continue;
    }
    update_post_meta( $post->ID, '_roden_pillar_negligence_intro', $content['negligence'] );
    update_post_meta( $post->ID, '_roden_pillar_compensation_intro', $content['compensation'] );
    $updated++;
    if ( defined( 'WP_CLI' ) && WP_CLI ) {
        WP_CLI::log( "  ✓ {$slug} (ID {$post->ID})" );
    }
}
if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::success( "Pillar intros chunk 1: updated {$updated} pillars" );
    if ( $missing ) {
        WP_CLI::warning( "Missing pillar slugs: " . implode( ', ', $missing ) );
    }
}
