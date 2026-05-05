<?php
/**
 * Seed pillar negligence + compensation intros — chunk 2 of 3 (PAs 8-15).
 *
 * Run on WP Engine via:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-pillar-intros-2.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$pillar_intros = array(

    'dog-bite-lawyers' => array(
        'negligence' => <<<'EOT'
**Georgia and South Carolina take sharply different approaches to dog-bite liability.** **South Carolina is a strict-liability state** under **S.C. Code § 47-3-110** — a dog owner is liable for injuries to a person lawfully on public or private property regardless of the dog's prior viciousness. No "first bite" required. **Georgia is a modified one-bite state** under **O.C.G.A. § 51-2-7**: the owner is liable only if the dog was vicious or dangerous *and* the owner knew it. The Georgia Supreme Court in *Steagald v. Eason*, 300 Ga. 717 (2017), confirmed that violation of a local **leash ordinance** can substitute for the scienter element. Whichever state your case is in, you have {sol_years} years to file under {sol_cite}.
EOT
,
        'compensation' => <<<'EOT'
Standard tort damages apply — past and future medical expenses, lost wages, scarring and disfigurement, and pain and suffering. **Scarring claims are particularly powerful with child plaintiffs** and frequently support seven-figure recoveries when the bite is to the face or hands. There are no special damage caps in either {state_full} or its neighboring state for ordinary dog-bite cases. **Homeowners' insurance is the typical funding source**, but many policies exclude specific breeds or impose dog-bite sub-limits — coverage analysis is critical and often uncovers landlord, daycare, or commercial-property defendants beyond the dog's owner.
EOT
,
    ),

    'brain-injury-lawyers' => array(
        'negligence' => <<<'EOT'
Traumatic brain injury (TBI) is not its own cause of action — it rides on the underlying tort: a vehicle crash, a fall, an assault, a defective product, or a medical procedure. The negligence framing follows whichever underlying claim applies, and standard {state_full} negligence elements (duty, breach, causation, damages) must be proven. TBI cases are distinct in **proof of injury**: mild TBI / concussion plaintiffs face heavy defense pushback because conventional CT and MRI imaging is often normal. Building proof requires neuropsychological testing, diffusion tensor imaging (DTI), and life-care planning expert testimony. Filing deadline: {sol_years} years under {sol_cite}.
EOT
,
        'compensation' => <<<'EOT'
**Future medical care, lost earning capacity, and noneconomic damages dominate** TBI recoveries. Lifetime cognitive rehab, attendant care, vocational retraining, and assistive technology routinely push economic damages into seven figures even in moderate-injury cases. {state_full} imposes no statutory cap on noneconomic damages outside the medical-malpractice context — so most TBI cases (auto, premises, products) are uncapped on pain and suffering. Defense vocational experts and life-care planners frequently spar with plaintiff experts over future-care assumptions, present-value reductions, and earning-capacity baselines.
EOT
,
    ),

    'spinal-cord-injury-lawyers' => array(
        'negligence' => <<<'EOT'
Spinal cord injury (SCI), like TBI, is an injury type rather than a stand-alone cause of action — the negligence theory tracks the underlying event (vehicle collision, fall, defective product, medical procedure). Standard {state_full} negligence elements apply, with causation often turning on **biomechanical experts** who connect crash forces to specific cord-level damage (cervical, thoracic, lumbar) and to whether injury was preventable with proper safety equipment, restraint, or surgical intervention. The {sol_years}-year statute of limitations under {sol_cite} runs from the injury (or, in medical-care contexts, from discovery in many circumstances).
EOT
,
        'compensation' => <<<'EOT'
**Lifetime care costs drive the case.** Plaintiffs typically present a **life-care plan** quantifying attendant care, durable medical equipment, home modifications, recurring surgeries, mobility devices, and bowel/bladder management — frequently valued at $5 million to $15 million or more for severe complete injuries. {state_full} permits full economic recovery; noneconomic damages are uncapped outside the medical-malpractice context. Future medical damages must be **reduced to present value** under O.C.G.A. § 51-12-13 (Georgia) or *Haltiwanger v. Barr*, 258 S.C. 27 (1972) (South Carolina). Plaintiff economists and vocational experts are essential.
EOT
,
    ),

    'maritime-injury-lawyers' => array(
        'negligence' => <<<'EOT'
Maritime injuries are governed primarily by **federal admiralty law**, which preempts most state tort doctrines. The applicable framework depends on the worker's status: **seamen** (members of a vessel's crew) sue under the **Jones Act, 46 U.S.C. § 30104**, which incorporates FELA's "featherweight" causation standard plus general maritime claims for unseaworthiness and **maintenance and cure**. **Longshore and harbor workers** are covered by the **Longshore and Harbor Workers' Compensation Act (LHWCA), 33 U.S.C. § 901 et seq.**, with § 905(b) third-party negligence claims against vessel owners. Recreational and passenger claims fall under general maritime negligence. Coastal {state_full} ports — Savannah, Brunswick, Charleston, Georgetown — generate substantial maritime caseloads.
EOT
,
        'compensation' => <<<'EOT'
Jones Act seamen recover lost wages, past and future medical care, pain and suffering, and (in death cases under DOHSA, 46 U.S.C. § 30301) pecuniary losses to dependents. **DOHSA bars recovery for loss of society** in death cases per *Mobil Oil Corp. v. Higginbotham*, 436 U.S. 618 (1978) — a major trap that often makes plaintiffs prefer state-court wrongful-death claims when jurisdiction permits. **LHWCA benefits are scheduled compensation** similar to state workers' comp. **Maintenance and cure** is a no-fault daily stipend plus medical treatment continuing until the seaman reaches maximum medical improvement (MMI), regardless of fault for the injury.
EOT
,
    ),

    'product-liability-lawyers' => array(
        'negligence' => <<<'EOT'
Product liability recognizes **three defect theories**: (1) manufacturing defect, (2) design defect, and (3) warning/instruction defect. **Georgia codified strict products liability at O.C.G.A. § 51-1-11(b)(1)** for manufacturers — but the doctrine does *not* extend to non-manufacturer sellers (retailers, distributors), who can only be sued in negligence. **South Carolina recognizes strict liability under S.C. Code § 15-73-10** (adopting Restatement (Second) § 402A) and applies a **risk-utility test** for design defects per *Branham v. Ford Motor Co.*, 390 S.C. 203 (2010). Federal preemption (FDA, NHTSA, FIFRA) routinely narrows recoverable theories for drugs, vehicles, and pesticides. Filing deadline: {sol_years} years from injury under {sol_cite}.
EOT
,
        'compensation' => <<<'EOT'
Standard tort damages apply, with **enhanced punitive exposure**: **Georgia's $250,000 punitive cap does NOT apply to product-liability cases** under O.C.G.A. § 51-12-5.1(e)(1) — punitive damages are uncapped, but the State of Georgia takes 75% of the punitive award after attorneys' fees and costs. South Carolina's 3:1 ratio / $500,000 punitive cap (S.C. Code § 15-32-530) applies with felony and intoxication exceptions. Federal preemption (e.g., *Riegel v. Medtronic, Inc.*, 552 U.S. 312 (2008) for PMA medical devices) can bar entire categories of claims, so coverage analysis is critical in any drug or device case.
EOT
,
    ),

    'boating-accident-lawyers' => array(
        'negligence' => <<<'EOT'
Boating cases sit at the intersection of state recreational-watercraft statutes and **federal admiralty jurisdiction** (when on navigable waters). Operator negligence is commonly built on BUI laws — Georgia: **O.C.G.A. § 52-7-12** (.08 BAC) plus the 2013 **Kile Glover Boat Safety Act** raising age and education requirements; South Carolina: **S.C. Code § 50-21-112 to -114**. On navigable waters, the **Limitation of Liability Act, 46 U.S.C. § 30501**, lets a vessel owner cap liability to the post-casualty value of the vessel — a frequent defense in fatal recreational-boat cases. Choosing between admiralty and state-court forums materially affects recovery.
EOT
,
        'compensation' => <<<'EOT'
On navigable waters in death cases, **DOHSA limits recovery to pecuniary losses** for non-seamen passengers — **barring noneconomic loss-of-society claims** entirely (a major trap for the unwary). State-water cases follow ordinary tort damages with full noneconomic recovery available, including pain and suffering, loss of enjoyment, and disfigurement. In a Georgia state-water boating death, the **"full value of life" measure (O.C.G.A. § 51-4-1)** can dramatically increase the recovery vs. an admiralty claim. Coverage analysis frequently involves the boat's policy, the operator's homeowners' policy (often excluding watercraft over a length threshold), and any commercial liability policy.
EOT
,
    ),

    'burn-injury-lawyers' => array(
        'negligence' => <<<'EOT'
Burn cases are not their own theory — liability rides on the underlying claim: **premises liability** (defective heaters, scalding water), **product liability** (flammable garments, defective lithium batteries, fuel-fed post-collision fires), motor vehicle, or workplace exposure. **Cause-and-origin experts** are central — fire investigators must rule out alternative ignition sources to support a defect or negligence theory. {state_full}'s standard four-element negligence framework applies, with negligence per se available where building codes, OSHA standards, or fire-safety regulations were violated. Filing deadline: {sol_years} years under {sol_cite}.
EOT
,
        'compensation' => <<<'EOT'
Burn damages skew toward extreme noneconomic values: **scarring, disfigurement, multiple skin grafts, contracture-release surgeries, and lifelong cosmetic and psychological consequences**. Both Georgia and South Carolina permit disfigurement damages as a separate jury consideration; in workers' compensation, statutory disfigurement awards apply (GA: O.C.G.A. § 34-9-263; SC: S.C. Code § 42-9-30(20)). Severe burn cases routinely include burn-unit ICU costs of $1 million+, multi-year reconstructive surgery, and lifelong pressure-garment and psychological care.
EOT
,
    ),

    'construction-accident-lawyers' => array(
        'negligence' => <<<'EOT'
Construction injuries usually involve a layered defendant pool: **employer** (workers' compensation exclusive remedy), **general contractor**, **subcontractors**, **property owner**, and **equipment manufacturers**. **OSHA regulations (29 C.F.R. Part 1926)** support negligence-per-se theories against non-employer third parties — but **OSHA itself creates no private right of action**. The **statutory employer doctrine** (GA: O.C.G.A. § 34-9-8; SC: S.C. Code § 42-1-400) can extend workers'-comp immunity *up* the contractor chain, eliminating tort recovery against general contractors in many cases. {market_name} job-site investigations require fast preservation of scene photos, OSHA reports, and equipment.
EOT
,
        'compensation' => <<<'EOT'
Workers' compensation covers the worker against the employer (medical, TTD, PPD, death benefits — but **no pain and suffering**). **Tort recovery against third parties** (general contractor, equipment manufacturer, property owner) is the path to noneconomic damages, full future earning capacity, and medicals beyond the WC schedule. Subrogation by the WC carrier under O.C.G.A. § 34-9-11.1 (GA) and S.C. Code § 42-1-560 (SC) reduces net recovery, but skilled negotiation can substantially limit the carrier's lien. Multi-defendant apportionment under {state_full}'s comparative-fault statute is the central strategic question.
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
    WP_CLI::success( "Pillar intros chunk 2: updated {$updated} pillars" );
    if ( $missing ) {
        WP_CLI::warning( "Missing pillar slugs: " . implode( ', ', $missing ) );
    }
}
