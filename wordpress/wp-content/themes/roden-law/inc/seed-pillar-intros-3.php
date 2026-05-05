<?php
/**
 * Seed pillar negligence + compensation intros — chunk 3 of 3 (PAs 16-22).
 *
 * Run on WP Engine via:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-pillar-intros-3.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$pillar_intros = array(

    'nursing-home-abuse-lawyers' => array(
        'negligence' => <<<'EOT'
Nursing home claims sound in **professional negligence** (sometimes med-mal-adjacent), ordinary negligence, statutory violations, and — for intentional misconduct — battery and elder-abuse torts. The federal **Nursing Home Reform Act, 42 U.S.C. § 1395i-3 / § 1396r**, and CMS regulations at **42 C.F.R. Part 483** establish baseline standards of care that support negligence-per-se theories. **Pre-dispute arbitration agreements** are routine and heavily contested under *Marmet Health Care Center v. Brown*, 565 U.S. 530 (2012). Georgia treats most nursing-home claims as professional negligence requiring an expert affidavit under O.C.G.A. § 9-11-9.1; ordinary-negligence theories (e.g., understaffing, falls without medical judgment) sometimes escape that requirement.
EOT
,
        'compensation' => <<<'EOT'
Damages include past and future medical care, pain and suffering, and — critically — **elder-abuse statutory damages and punitives**. South Carolina's **Omnibus Adult Protection Act (S.C. Code § 43-35-5 et seq.)** and Georgia's **Disabled Adults and Elder Persons Protection Act (O.C.G.A. § 30-5-1 et seq.)** inform the standard of care. South Carolina's $350,000 / $1.05M noneconomic cap (S.C. Code § 15-32-220) applies if the claim is characterized as medical malpractice; **ordinary-negligence and intentional-tort theories escape the cap**, which is a key strategic decision in pleading. Wrongful-death claims under {state_full} law often substantially exceed the underlying nursing-home claim value.
EOT
,
    ),

    'premises-liability-lawyers' => array(
        'negligence' => <<<'EOT'
The duty owed by a property owner turns on the **entrant's legal status**: invitee (ordinary care), licensee (avoid willful/wanton injury), trespasser (no willful/wanton injury). Georgia codifies these duties at **O.C.G.A. §§ 51-3-1 through 51-3-3**; South Carolina follows common-law classifications refined in *Sims v. Giles*, 343 S.C. 708 (2000). **Negligent security** (third-party criminal acts) is a major sub-area: in Georgia, *CVS Pharmacy, Inc. v. Carmichael*, 316 Ga. 718 (2023), confirmed the totality-of-the-circumstances test for foreseeability; South Carolina applies a balancing test from *Bass v. Gopal, Inc.*, 395 S.C. 129 (2011). Filing deadline: {sol_years} years under {sol_cite}.
EOT
,
        'compensation' => <<<'EOT'
Standard tort damages apply with no special caps in either {state_full} or its neighboring state. {state_full}'s **apportionment statute** is decisive in **negligent-security cases** because the assailant — though typically a non-party (often unknown or judgment-proof) — must be included on the verdict form. Defense attorneys aggressively shift fault to the assailant, frequently driving the property owner's apportioned share below the {comp_fault_threshold} bar. Plaintiffs respond by emphasizing prior similar incidents, foreseeability, and the security measures that should have been in place but weren't.
EOT
,
    ),

    'pedestrian-accident-lawyers' => array(
        'negligence' => <<<'EOT'
Pedestrian cases follow ordinary negligence against the at-fault driver, with **negligence per se** built on Rules of the Road governing right-of-way at crosswalks and intersections (Georgia: O.C.G.A. § 40-6-91 to -96; South Carolina: S.C. Code § 56-5-3110 to -3230). Comparative-fault analysis often turns on whether the pedestrian was in a marked or unmarked crosswalk, whether the pedestrian was jaywalking, lighting conditions, and visible clothing — and {state_full}'s {comp_fault_threshold} comparative bar routinely defeats marginal claims. Filing deadline: {sol_years} years under {sol_cite}.
EOT
,
        'compensation' => <<<'EOT'
**Pedestrian injuries skew catastrophic** relative to vehicular collisions because of the unprotected impact — TBI, multi-system trauma, and crush injuries dominate. Future-care damages and noneconomic recoveries are correspondingly large. {state_full} permits full recovery with no statutory cap on noneconomic damages outside the medical-malpractice context. Critical insurance source: **UM/UIM coverage on the pedestrian's own auto policy can apply** under "occupying" or "non-occupying insured" provisions even though the pedestrian was on foot — a frequently overlooked recovery channel when the at-fault driver is uninsured or carries minimum 25/50 limits.
EOT
,
    ),

    'bicycle-accident-lawyers' => array(
        'negligence' => <<<'EOT'
Cyclists have the **same rights and duties as motor-vehicle operators** under Georgia: O.C.G.A. § 40-6-290 to -298 and South Carolina: S.C. Code § 56-5-3410 to -3450. **Both states impose a 3-foot passing rule** on motorists overtaking cyclists (GA: § 40-6-56; SC: § 56-5-3435), violation of which supports negligence per se. Helmet laws are limited — Georgia requires helmets only for riders under 16 (§ 40-6-296); South Carolina has no statewide helmet requirement. Door-zone collisions, right-hook turns, and intersection failure-to-yield are the most common claim patterns. Filing deadline: {sol_years} years under {sol_cite}.
EOT
,
        'compensation' => <<<'EOT'
Bicycle cases share the **catastrophic-skew of pedestrian cases** — TBI, fractures, road rash, and spinal trauma dominate. Both states permit full noneconomic recovery with no special caps outside the medical-malpractice context. **UM/UIM coverage on the cyclist's own auto policy typically applies** under standard "non-occupying insured" provisions, providing a recovery source when the at-fault motorist is uninsured or underinsured. Bicycle-specific damages can also include the value of the bike, cycling equipment, and aftermarket components — often substantial for serious cyclists.
EOT
,
    ),

    'electric-scooter-accident-lawyers' => array(
        'negligence' => <<<'EOT'
**E-scooter law is thin in both Georgia and South Carolina.** Shared-mobility scooters (Lime, Bird, Spin) typically fall outside the statutory definition of "motor vehicle" but are regulated by **local ordinance** — Atlanta, Savannah, Charleston, and Columbia each have municipal scooter codes that differ on speed limits, geofencing, sidewalk use, and helmet requirements. Liability theories include rider negligence (against pedestrians struck), product liability (defective braking/throttle), premises liability (defective sidewalks/curbs), and **direct-negligence claims against the scooter operator-companies** (negligent maintenance, geofencing failures, inadequate rider screening). Filing deadline: {sol_years} years under {sol_cite}.
EOT
,
        'compensation' => <<<'EOT'
Standard tort damages apply, but **insurance coverage is the central practical problem**. Most personal auto policies *exclude* e-scooter operation, and homeowners' policies often exclude motorized vehicles. Riders may be limited to suing the **scooter company directly** (which typically requires arbitration under the user agreement and waives jury trial rights) or pursuing the **at-fault motorist's liability and UM/UIM coverage** when the scooter rider is the victim. Pedestrians struck by e-scooter riders face similar coverage gaps when pursuing the rider — the scooter company's commercial liability policy may be the only realistic source.
EOT
,
    ),

    'atv-side-by-side-accident-lawyers' => array(
        'negligence' => <<<'EOT'
ATVs and side-by-sides (UTVs) are generally **not legal on public roads** in either state except in limited circumstances. **Georgia: O.C.G.A. § 40-7-1 et seq.** governs off-road vehicles; **South Carolina: S.C. Code § 50-26-10 et seq.** is the **2011 Chandler Saylor Law**, which requires safety certificates for riders under 16 and prohibits passengers on single-rider ATVs. Liability theories include operator negligence, **product liability** (rollover defects, lack of doors/nets — see CPSC ROV recalls), premises liability against landowners (recreational-use immunity often applies), and parental-supervision claims for minor operators. Filing deadline: {sol_years} years under {sol_cite}.
EOT
,
        'compensation' => <<<'EOT'
**Catastrophic-injury patterns dominate** ATV cases — rollover crush, ejection TBI, and limb amputation are common. **Recreational-use statutes sharply limit landowner liability**: Georgia's **Recreational Property Act (O.C.G.A. § 51-3-20 to -26)** and South Carolina's equivalent (S.C. Code § 27-3-10 et seq.) bar most claims against landowners who allow free recreational use of their property. **Product-liability theories against manufacturers** (Polaris, Yamaha, Honda, Can-Am) often offer the strongest recovery path — manufacturer liability is governed by O.C.G.A. § 51-1-11 (GA) and S.C. Code § 15-73-10 (SC), with CPSC ROV standards (16 C.F.R. Part 1420) supporting negligence per se.
EOT
,
    ),

    'golf-cart-accident-lawyers' => array(
        'negligence' => <<<'EOT'
Georgia regulates "personal transportation vehicles" (PTVs) under **O.C.G.A. § 40-6-330 to -334** — golf carts may operate on roads with speed limits ≤35 mph in jurisdictions that have authorized them by ordinance. South Carolina treats golf carts as "permitted vehicles" under **S.C. Code § 56-2-100 to -130**, allowing on-road use **within four miles of registered address, during daylight only, on roads ≤35 mph, by a licensed driver.** A cart driven outside these limits is **operating illegally** in {state_full}, which can support a negligence-per-se argument against the operator. Defendants commonly include the operator, the cart owner, the host community/HOA, the resort, and the manufacturer. Filing deadline: {sol_years} years under {sol_cite}.
EOT
,
        'compensation' => <<<'EOT'
Common golf-cart injuries are **ejection-related** — TBI from falls, fractures from rollovers — because golf carts lack seatbelts, doors, and meaningful crash protection. **Insurance coverage is a frequent gap**: standard auto policies often exclude golf carts, while homeowners' policies cover golf-cart use only in limited circumstances (typically on the insured's premises or on a golf course). South Carolina requires **liability insurance on a permitted golf cart**, but compliance is uneven. Plaintiffs frequently rely on **host-resort, HOA, or short-term-rental property general-liability policies**, especially in Grand Strand and beach-community cases involving rented carts provided to guests.
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
    WP_CLI::success( "Pillar intros chunk 3: updated {$updated} pillars" );
    if ( $missing ) {
        WP_CLI::warning( "Missing pillar slugs: " . implode( ', ', $missing ) );
    }
}
