<?php
/**
 * Track B1: give the highest-impression informational pages a real excerpt.
 *
 *   ssh $H "wp --path=... eval-file -"       < bin/b1-write-excerpts.php
 *   ssh $H "wp --path=... eval-file - apply" < bin/b1-write-excerpts.php
 *
 * WHY EXCERPTS, and why this is not the Track A mistake repeated.
 *
 * Track A was abandoned because page substance predicts neither position nor CTR
 * on the city x practice pages. The same test was run on the informational cohort
 * BEFORE starting here, and it comes back the other way. Across 346 EN blog and
 * resource pages with >=500 impressions:
 *
 *     predictor        vs position   vs CTR
 *     word count         -0.288      +0.137
 *     h2 count           -0.300      +0.113
 *     key takeaways      -0.321      +0.072
 *     statute cites      -0.252      +0.185
 *     EXCERPT            -0.302      +0.412   <- strongest signal in the table
 *     two-state title    +0.017      -0.036   <- still not a lever
 *
 * Excerpt is singled out because it is the only one with a DIRECT mechanism
 * rather than a plausible confound. post_excerpt IS the meta description
 * (roden_seo_get_description) and IS the Article schema description
 * (roden_schema_article). It is literally the snippet a searcher reads before
 * deciding to click. Word count cannot act on CTR that way; an excerpt can.
 *
 * The honest caveat: +0.412 is a correlation, and pages carrying excerpts also
 * tend to be newer and better maintained, so some of it is "this page was looked
 * after". The mechanism is what justifies acting, not the coefficient.
 *
 * SCALE. 284 EN informational pages with >=500 impressions have no excerpt,
 * carrying 3,366,778 impressions at 0.471% CTR. The 62 that have one run 0.609%.
 * This script does the top 12 by impressions — 1,461,000 impressions between them.
 *
 * Every excerpt below was written from that page's own opening and its
 * _roden_key_takeaways where present, both of which have already been through the
 * accuracy passes. No excerpt asserts a statute, a number or a deadline: a
 * description is not the place to introduce a legal claim that then has to be
 * maintained on a fifth surface.
 *
 * Idempotent, and refuses to overwrite: a page that already has an excerpt is
 * skipped, because a human-written one is not improved by a generated one.
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (pass 'apply' to write) ===\n\n";

$EXCERPTS = array(
    'compensatory-damages-vs-punitive-damages'           => 'Compensatory damages repay your losses; punitive damages punish extreme misconduct. How each works in Georgia and South Carolina injury claims.',
    'can-an-insurance-company-go-against-a-police-report' => 'Yes — insurers in Georgia and South Carolina routinely dispute a police report\'s fault finding. What that means for your claim, and how to respond.',
    'fault-vs-no-fault-car-insurance'                     => 'Georgia and South Carolina are both at-fault states, not no-fault. What that means for who pays after a crash, and how shared fault affects recovery.',
    'rollover-crashes-and-what-they-do-to-your-body'      => 'Why rollovers happen, the injuries they cause, and who may be liable — other drivers, vehicle makers, or road authorities — in Georgia and South Carolina.',
    'value-of-pain-and-suffering'                         => 'How pain and suffering is valued in Georgia and South Carolina injury claims, including the multiplier and per diem methods insurers actually use.',
    'calculating-compensation-for-whiplash-injuries'      => 'How whiplash compensation is calculated in Georgia and South Carolina — injury grades, medical bills, lost wages, and what shared fault does to a claim.',
    'supporting-a-whiplash-claim'                         => 'Five steps to document and support a whiplash claim after a Charleston car accident, from medical records to the evidence insurers look for.',
    'claims-against-at-fault-drivers-who-died'            => 'Your claim survives the at-fault driver\'s death. How to pursue it in Georgia or South Carolina through insurance, the estate, or your own coverage.',
    'liability-for-epilepsy-related-car-accidents'        => 'When a seizure causes a crash, who is liable? How fault is assessed in seizure-related accidents, and what it means for the people injured.',
    'insurance-company-ignoring-demand-letter'            => 'Why insurers ignore or delay a demand letter after a personal injury claim, what the silence usually means, and the steps that get a response.',
    'diminished-value-claims-after-car-accident'          => 'A repaired car is worth less than it was. How diminished value claims work in Georgia and South Carolina, and why an appraisal beats the 17c formula.',
    'are-red-light-runners-always-liable-if-they-crash'   => 'Not automatically. How fault is actually decided in Georgia and South Carolina red light crashes, and when the other driver shares the blame.',

    // ---- batch 2, added 2026-09-01: the next 16 by impressions ----
    'when-does-a-sprained-ankle-become-a-work-injury'     => 'When a sprained ankle at work qualifies for workers\' compensation, how to document it, and why insurers treat soft-tissue injuries with suspicion.',
    'using-uninsured-underinsured-motorist-coverage-in-georgia' => 'How uninsured and underinsured motorist coverage works in Georgia and South Carolina when the at-fault driver has no insurance or too little.',
    'impaired-driving-caused-by-prescription-medications' => 'Prescription drugs can impair driving as much as alcohol. Which medications carry the risk, and what it means for fault after a crash.',
    'gym-injury-liability'                               => 'Who is liable when you are hurt at a gym — the facility, a trainer, or an equipment maker — and what a signed waiver does and does not cover.',
    'contingency-fee-system'                             => 'How contingency fees work in Georgia and South Carolina injury claims: no upfront cost, the lawyer paid from the recovery, and what the agreement must say.',
    'georgia-statute-of-limitations'                     => 'How long you have to file a personal injury lawsuit in Georgia and South Carolina, plus the exceptions that shorten or extend the deadline.',
    'answering-insurance-questions-after-crash'          => 'What to say — and what not to say — when an insurance adjuster calls after a crash in Georgia or South Carolina, and why recorded statements are risky.',
    'how-car-insurers-use-private-investigators'         => 'Insurers hire private investigators to watch injury claimants. What surveillance is legal in Georgia and South Carolina, and how to protect your claim.',
    'independent-medical-exams'                          => 'An independent medical exam is arranged by the insurer, not your doctor. What an IME is for, what to expect, and how its report can be challenged.',
    'what-happens-if-i-resign-while-on-workers-compensation' => 'Resigning does not automatically end workers\' comp benefits in Georgia or South Carolina — but it puts wage replacement at risk. What actually changes.',
    'burn-injury-workers-compensation'                   => 'How workers\' compensation covers burn injuries — treatment, wage replacement, and permanent scarring — and what makes these claims harder to settle.',
    'impact-of-surgery-recommendation'                   => 'How a surgery recommendation changes a personal injury claim: what it does to case value, and why insurers scrutinise the decision so closely.',
    'determining-liability-for-crash-at-four-way-stop-sign' => 'Who is at fault in a four-way stop crash in Savannah? How right of way is decided, and what evidence settles a disputed intersection claim.',
    'negligence-vs-gross-negligence'                     => 'Ordinary negligence is carelessness; gross negligence is conscious disregard. How that difference changes a car accident claim in Georgia and South Carolina.',
    'does-workers-compensation-cover-prescriptions'      => 'Workers\' compensation covers prescription medication for a work injury in Georgia and South Carolina. What is covered, and what to do when the insurer refuses.',
    'claims-for-lost-wages'                              => 'Lost wages and lost earning capacity are different claims. How to prove each after an injury in Georgia or South Carolina, and what documentation you need.',
    // ---- batches 3-5, added 2026-09-01 ----
    'four-common-construction-accidents' => 'The four accident types that injure and kill the most construction workers, why they happen, and what an injured worker can claim.',
    'blunt-force-trauma-from-a-crash-what-you-need-to-know' => 'Blunt force trauma can be severe with no symptoms at first. The warning signs after a crash, and why delayed treatment hurts both health and a claim.',
    'what-to-do-when-you-are-in-a-car-accident' => 'A step-by-step checklist for the hours after a crash in Georgia or South Carolina, from the scene and the police report to seeing a doctor.',
    'demand-letters-in-personal-injury-cases' => 'What a personal injury demand letter contains, when your attorney sends one, and how insurers typically respond to it.',
    'dangers-of-emotional-driving-in-savannah-ga' => 'Driving angry or upset measurably raises crash risk. How emotional driving contributes to Savannah collisions, and what it means for fault.',
    'switching-lawyers-during-a-case' => 'You can change personal injury lawyers at almost any stage in Georgia or South Carolina. How the switch works, and what it costs you.',
    'liability-for-sudden-emergency-accidents' => 'When a driver has a heart attack or seizure at the wheel, the sudden medical emergency defence may block liability. When it applies, and when it fails.',
    'georgia-law-on-steps-after-car-accident' => 'What Georgia law actually requires of drivers after a crash — stopping, reporting, exchanging information — and what happens if you do not.',
    'car-insurance-add-ons' => 'The optional auto coverages that change what you can recover after a crash in Georgia or South Carolina, and why minimum limits rarely go far enough.',
    'myrtle-beach-dangerous-roads-intersections' => 'The roads behind the Grand Strand\'s worst crashes, what federal crash data actually shows about seasonal risk, and your rights after a wreck.',
    'georgia-comparative-negligence-law' => 'How shared fault affects an injury claim in Georgia and South Carolina, where the recovery bar sits in each state, and how insurers use it against you.',
    'much-worth-ga-worker-compared-states' => 'Workers\' compensation is not the same in every state. How Georgia\'s benefits compare, and what that means for an injured Georgia worker.',
    'uturn-crash-liability-in-charleston' => 'Who is at fault in a Charleston U-turn crash? How liability is decided when a turning driver and oncoming traffic collide.',
    'liability-for-crash-due-to-tire-blowout-in-savannah' => 'A tire blowout does not automatically excuse a crash. When a driver, a tire maker, or a repair shop can be held liable in Savannah.',
    'wearing-headphones-while-driving-in-charleston' => 'Is it legal to drive wearing headphones or AirPods in Charleston? What South Carolina law says, and how it affects fault after a crash.',
    'leg-pain-and-leg-injuries-from-crash' => 'Leg pain after a Savannah crash can signal a serious injury. The injuries that cause it, and why prompt treatment matters for your claim.',
    'liability-for-accidents-with-borrowed-vehicles' => 'When someone crashes a borrowed car, whose insurance pays? How liability and coverage work when the driver is not the owner.',
    'damage-coverage-for-stolen-car' => 'If your stolen car is damaged in a crash, which policy pays? How coverage works when a thief causes the accident.',
    'driving-tips-around-trucks' => 'Large trucks have huge blind spots and need hundreds of feet to stop. How to share the road safely in Georgia and South Carolina.',
    'releasing-medical-records' => 'Insurers ask for broad medical records access after an injury. What you must disclose in a Charleston claim, and what you can refuse.',
    'liability-waivers-and-injury-lawsuits' => 'Signing a liability waiver does not always end your right to sue. When waivers hold up after an injury, and when courts set them aside.',
    'letters-of-protection-for-injury-victims' => 'A letter of protection lets you get medical treatment now and pay from your settlement later. How they work in Georgia and South Carolina.',
    'rear-end-collision-liability' => 'Rear-end fault is not automatic. When the lead driver shares blame, and what evidence decides a disputed rear-end claim.',
    'benefits-for-workplace-violence' => 'When an assault at work is covered by workers\' compensation in Georgia and South Carolina, and the connection to employment that decides it.',
    'dangerous-tools-garage' => 'The household and garage tools that send the most people to the emergency room, and when a defective tool becomes a product liability claim.',
    'average-personal-injury-settlement-amounts' => 'What personal injury settlements realistically range by case type, why averages mislead, and the factors that actually drive case value.',
    'does-worker-compensation-cover-employee-negligence' => 'Workers\' compensation is a no-fault system in Georgia and South Carolina — your own carelessness rarely bars benefits. The narrow exceptions that do.',
    'animal-accident-insurance-coverage' => 'Hitting a deer and swerving to avoid one are covered by different policies. How animal collisions work in Georgia and South Carolina.',
    'truck-accident-injuries' => 'The injuries that make truck collisions so much more severe than car crashes, and what they mean for treatment and compensation.',
    'accident-claims-with-an-expired-license' => 'An expired licence does not bar an injury claim in Georgia or South Carolina. How courts separate a paperwork lapse from crash causation.',
    'resolving-claims-through-arbitration' => 'Arbitration decides an injury dispute without a trial. How it works in Georgia and South Carolina, and what you give up by choosing it.',
    'maximum-medical-improvement-in-an-injury-claim' => 'Maximum medical improvement means your condition has stabilised, not that you are healed. Why MMI is the turning point in an injury claim.',
    'informed-consent' => 'Doctors must disclose risks and alternatives before treating you. How informed consent works in Georgia and South Carolina, and when a failure is malpractice.',
    'understanding-vicarious-liability' => 'Vicarious liability can make an employer or vehicle owner responsible for someone else\'s negligence. When it applies to an injury claim.',
    'options-for-denied-injury-claims' => 'A denied injury claim is not the end. How to read the denial letter, what to gather, and the appeal and bad faith routes available.',
    'why-mitigate-damages-after-a-car-crash' => 'After a crash you have a duty to limit your own losses. What mitigating damages means in practice, and how insurers use it against you.',
    'what-to-do-after-car-accident-georgia' => 'A complete guide to the hours and days after a Georgia crash: the scene, the police report, the insurer, and the deadlines that follow.',
    'certification-of-permanent-injury' => 'Certifying an injury as permanent unlocks future medical costs and lost earning capacity. How it strengthens a Georgia or South Carolina claim.',
    'what-to-do-if-your-georgia-police-report-is-wrong-or-has-mistakes' => 'A wrong police report can sink a claim. How to get a Georgia crash report corrected, and what to do when the officer will not amend it.',
    'is-workers-compensation-an-employee-benefit' => 'Workers\' compensation is a legally required insurance programme, not an optional perk. What Georgia and South Carolina employers must provide.',
    'liability-for-crashes-caused-by-not-using-turn-signal' => 'Failing to signal is a traffic violation, but it does not settle fault by itself. How liability is decided in a lane-change or turning crash.',
    'steps-after-hit-and-run-accident' => 'Seven steps to take after a hit-and-run, from the scene and the police report to the coverage that pays when the driver is never found.',
    'feeling-fatigued-after-charleston-car-accident' => 'Exhaustion after a Charleston crash can signal concussion, whiplash or internal injury. Why fatigue matters medically and to your claim.',
    'workers-comp-benefits-georgia-taxable' => 'Are Georgia workers\' compensation benefits taxable? How wage replacement and settlements are treated at tax time.',
    'medical-malpractice-limits-south-carolina' => 'What limits apply to a South Carolina medical malpractice claim, how damages are treated, and the deadlines that govern filing.',
    'recovering-damages-with-pre-existing-injuries' => 'A pre-existing condition does not bar recovery. How the eggshell plaintiff rule works in Georgia and South Carolina when an injury is made worse.',
    'filing-medication-error-lawsuit' => 'When a medication error becomes malpractice, who can be held responsible — prescriber, pharmacist or hospital — and how these claims are proven.',
    'medical-malpractice-limits-georgia' => 'What limits apply to a Georgia medical malpractice claim, how damages are treated, and the deadlines that govern filing.',
);

$backups = array();
$ok = $skip = $fail = 0;

foreach ( $EXCERPTS as $slug => $excerpt ) {
    $post = get_page_by_path( $slug, OBJECT, 'post' );
    if ( ! $post ) {
        printf( "  FAIL (not found): %s\n", $slug );
        $fail++;
        continue;
    }

    $len = mb_strlen( $excerpt );
    if ( $len > 160 ) {
        printf( "  FAIL (%d chars > 160): %s\n", $len, $slug );
        $fail++;
        continue;
    }

    // Never overwrite a hand-written excerpt.
    if ( '' !== trim( (string) $post->post_excerpt ) ) {
        printf( "  SKIP (already has one): %s\n", $slug );
        $skip++;
        continue;
    }

    printf( "  ok  [%3d chars] %-52s\n", $len, $slug );
    $ok++;

    if ( ! $apply ) {
        continue;
    }

    $backups[ $post->ID ] = array( 'url' => get_permalink( $post->ID ), 'post_excerpt' => $post->post_excerpt );
    wp_update_post( array( 'ID' => $post->ID, 'post_excerpt' => $excerpt ), true );
    clean_post_cache( $post->ID );
}

printf( "\n%d written, %d skipped, %d failed\n", $ok, $skip, $fail );

if ( ! $apply ) {
    echo "\nDry run. Nothing written.\n";
    return;
}
if ( $backups ) {
    echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\n";
}

echo "\n--- VERIFY (what each page now publishes as its description) ---\n";
foreach ( array_keys( $EXCERPTS ) as $slug ) {
    $post = get_page_by_path( $slug, OBJECT, 'post' );
    if ( ! $post ) { continue; }
    $desc = trim( wp_strip_all_tags( get_the_excerpt( $post->ID ) ) );
    printf( "  %-52s %s\n", $slug, substr( $desc, 0, 78 ) );
}
echo "\nDone.\n";
