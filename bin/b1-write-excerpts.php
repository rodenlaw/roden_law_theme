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
    // ---- chunk 1 of the tail, added 2026-09-02 ----
    'liability-in-a-driverless-car-crash' => 'Who is at fault when an autonomous vehicle crashes — the driver, the manufacturer, or the software maker? How liability is assessed.',
    'steps-after-work-injury' => 'Five steps to protect a workers\' compensation claim after a workplace injury in Georgia or South Carolina, starting with how fast you must report it.',
    'steps-of-a-burn-injury-case' => 'How to document a burn injury after an accident, the evidence a claim depends on, and what compensation may be available.',
    'major-injuries-from-minor-car-accidents' => 'A low-speed fender bender can still cause serious harm. The injuries that commonly follow a "minor" crash, and why they get missed.',
    'options-for-recovering-more-than-policy-limits' => 'When the at-fault driver\'s policy is not enough: UM/UIM coverage, additional defendants, and the other routes to full compensation.',
    'longshoreman-injury-claims' => 'Injured on the Savannah docks? How longshoreman and maritime injury claims work, and why they are not ordinary workers\' compensation.',
    'steps-take-slip-fall-accident-georgia' => 'What to do after a slip and fall in Georgia — the evidence that disappears fastest, and what a property owner must have done wrong.',
    'liens-and-your-personal-injury-claims' => 'Hospitals, health insurers, Medicare and attorneys can all claim part of your settlement. Which liens apply, and how they are negotiated.',
    'workers-comp-for-carpal-tunnel-syndrome' => 'Carpal tunnel can qualify as an occupational disease in Georgia and South Carolina. How to prove it is work-related, and when to report it.',
    'how-to-handle-calls-from-insurance-companies' => 'What an adjuster is really doing when they call after an accident, what you are obliged to say, and where claims get damaged.',
    'filing-a-claim-for-an-injured-minor' => 'How a parent or guardian files an injury claim for a child in Georgia or South Carolina, and how the deadline differs from an adult\'s.',
    '2017-safest-college-campuses-in-georgia' => 'Campus safety across Georgia colleges — the data behind the rankings, and what students and parents should look at.',
    'nerve-damage-after-charleston-car-crash' => 'Nerve damage after a Charleston crash can be permanent and is often missed at first. The symptoms to watch for, and what a claim must prove.',
    'when-to-call-charleston-personal-injury-lawyer' => 'Is it ever too late to call a lawyer after a Charleston accident? How waiting affects evidence, treatment records and your claim.',
    'what-to-do-after-car-accident-south-carolina' => 'A complete guide to the hours and days after a South Carolina crash: the scene, the report, the insurer, and the deadlines that follow.',
    'advantages-of-a-medical-malpractice-attorney' => 'Why medical malpractice claims are harder than ordinary injury cases, and what an attorney does that changes the outcome.',
    'traffic-tickets-and-car-accident-claims' => 'A traffic ticket is strong evidence of fault but does not settle it. How citations are used, and when negligence per se applies.',
    'rear-end-accident-injuries' => 'The injuries rear-end collisions cause most often, why symptoms can take days to appear, and what that delay does to a claim.',
    'truck-accident-reconstruction' => 'How accident reconstruction proves fault in a truck crash, the electronic data involved, and why it has to be preserved quickly.',
    'hearing-loss-after-charleston-car-accident' => 'Hearing loss after a Charleston crash is easy to overlook and hard to reverse. When it is compensable, and what evidence it takes.',
    'south-carolina-statute-of-limitations-personal-injury' => 'How long you have to file a personal injury lawsuit in South Carolina, and the exceptions that shorten or extend that window.',
    'georgia-pedestrian-right-of-way-laws' => 'When Georgia drivers must yield to pedestrians, what pedestrians must do in return, and how that shapes fault after a collision.',
    'blind-spot-accidents' => 'Why blind spot collisions happen, who they injure most, and how fault is decided in Georgia and South Carolina.',
    'the-role-of-vocational-rehabilitation-in-workers-compensation-cases' => 'Vocational rehabilitation for injured workers who cannot return to their old job — how it works in Georgia and South Carolina.',
    'when-do-injury-claims-go-to-court' => 'Most injury claims settle without a trial. What makes a case the exception, and what going to court actually involves.',
    'qualifications-for-car-accident-witnesses' => 'What makes a crash witness credible, why independent witnesses matter most, and how their accounts get tested.',
    'south-carolina-pedestrian-right-of-way-laws' => 'When South Carolina drivers must yield to pedestrians, what pedestrians must do in return, and how that shapes fault after a collision.',
    'pedestrian-liability-for-car-accidents' => 'A pedestrian can share fault for a collision. When that happens, how it is assessed, and what it does to a claim.',
    'benefits-of-hiring-personal-injury-lawyer' => 'What a personal injury lawyer does that changes outcomes in Georgia and South Carolina, from valuing damages to handling adjusters.',
    'knee-injuries-after-georgia-car-crash' => 'Knee pain after a Georgia crash can signal ligament or cartilage damage. The steps to take, and why delay costs you twice.',
    'first-steps-in-a-medical-malpractice-case' => 'How a medical malpractice claim begins in Georgia and South Carolina, the expert requirements, and what the first steps look like.',
    'taxes-on-car-crash-settlement-in-georgia' => 'Which parts of a personal injury settlement are taxable and which are not, and where the line falls for lost wages and punitive damages.',
    'dealing-with-uber-lyft-accident' => 'Injured as an Uber or Lyft passenger? Whose insurance applies, how rideshare coverage tiers work, and what to do first.',
    'can-someone-sue-me-for-a-car-accident' => 'Yes — Georgia and South Carolina are both at-fault states. What your liability coverage does, and what happens if damages exceed it.',
    'personal-injury-calculating-loss-of-earning-capacity' => 'Loss of earning capacity is about the future, not just missed paychecks. How it is calculated, and what evidence proves it.',
    'duty-of-care-personal-injury-claim' => 'Duty of care is the first element of any injury claim. What it means, how it is established, and how a breach is proven.',
    'passenger-car-accident-claim' => 'As a passenger you are rarely at fault, and you may have claims against more than one driver. How passenger claims work.',
    'how-loud-music-increases-crash-risk-charleston' => 'Loud music measurably slows reaction time. How it contributes to Charleston crashes, and what it means for fault.',
    'mistakes-charleston-slip-and-fall-victims-make' => 'The mistakes that sink Charleston slip-and-fall claims — delayed reporting, missing photographs, casual statements — and how to avoid them.',
    'continuing-post-accident-medical-treatment' => 'Gaps in treatment are the argument insurers reach for first. Why consistent medical care protects both your recovery and your claim.',
    'compensation-for-chronic-pain-after-a-car-crash-in-charleston' => 'Chronic pain after a Charleston crash is compensable but hard to prove. What documentation a claim for it depends on.',
    'legal-rights-after-memory-loss-savannah-crash' => 'Memory loss after a Savannah crash can signal a brain injury. What to do medically and legally, and how it affects a claim.',
    'car-insurance-claim-denial-tactics' => 'The tactics insurers use to deny or devalue an injury claim — recorded statements, biased exams, delay — and how to answer them.',
    'how-long-can-a-person-stay-on-workers-compensation' => 'How long workers\' compensation benefits last in Georgia and South Carolina, and what determines when they stop.',
    'after-boat-accident-guide' => 'What to do after a boat accident: reporting requirements, the evidence that matters, and how these claims differ from car crashes.',
    'hip-pain-after-car-accident-in-savannah' => 'Hip pain after a Savannah crash can mean a fracture or dislocation. The symptoms to take seriously, and the steps that protect a claim.',
    'liability-for-crashes-caused-by-teen-drivers' => 'When a teen driver causes a crash, who pays — the teen, the parents, or the policy? How liability is assigned.',
    'settle-workers-comp-case' => 'When it makes sense to settle a workers\' compensation case, what you give up by settling, and the timing that matters most.',
    'discovery-process-in-personal-injury-cases' => 'What discovery involves in an injury case — documents, interrogatories, depositions — and how long it usually takes.',
    'value-of-car-crash-claim-if-permanent-injuries' => 'How permanent injuries change what a Charleston crash claim is worth, and the future costs a settlement has to cover.',
    'financial-abuse-at-nursing-homes' => 'Elder financial abuse in nursing homes: the warning signs, who can be held responsible, and the protections each state provides.',
    'proving-back-pain-after-savannah-car-crash' => 'Back pain is the hardest crash injury to prove and the easiest for insurers to dispute. How to link it to a Savannah collision.',
    'deposition-in-a-personal-injury-claim' => 'What a deposition is, what you will be asked, and how to prepare for one in a personal injury case.',
    'refusing-opioid-prescription-in-workers-comp-claim' => 'Can a workers\' comp claim be denied for refusing opioids? What treatment you can decline, and where the risk lies.',
    'third-party-fault-for-work-injuries' => 'When someone other than your employer caused a work injury, you may have a claim beyond workers\' compensation. How the two fit together.',
    'driving-record-and-injury-claim' => 'A prior driving record does not bar an injury claim in Georgia or South Carolina. When it becomes admissible, and how insurers use it.',
    'liability-for-school-bus-crash' => 'When a child is hurt on a school bus, who is liable — the district, the driver, or another motorist — and what deadlines apply.',
    'what-happens-to-workers-comp-if-employer-bankrupts' => 'Employer bankruptcy does not automatically stop workers\' compensation benefits. What actually happens, and who pays.',
    'determining-fault-in-multi-vehicle-accidents' => 'Fault in a pile-up rarely sits with one driver. How it is apportioned in Georgia and South Carolina, and what evidence decides it.',
    'safe-driving-in-construction-zones' => 'Why construction zones are disproportionately dangerous, how to drive them safely, and who is liable when a work-zone crash happens.',
    'what-if-i-suspect-medical-malpractice' => 'What to do first if you suspect medical malpractice in Georgia or South Carolina — records, independent care, and what not to say.',
    'legal-rights-if-hit-by-driver-in-company-car-charleston' => 'Hit by someone driving a company vehicle in Charleston? Why there may be more than one insurer, and who can be held responsible.',
    'valid-premises-liability-claim-georgia' => 'What makes a Georgia premises liability claim valid — the hazard, the owner\'s knowledge of it, and your status on the property.',
    'drunk-pedestrian-injury-claims' => 'An intoxicated pedestrian can still recover in Georgia and South Carolina. How shared fault is assessed, and what it costs a claim.',
    'college-campus-safety-tips-every-student-should-know' => 'Practical campus safety for students starting somewhere new — the risks that actually occur, and how to reduce them.',
    'reasons-for-workers-comp-claim-denial' => 'The most common reasons a workers\' compensation claim is denied, which of them are fixable, and what to do when the letter arrives.',
    'ptsd-after-car-accident-compensation' => 'PTSD after a crash is compensable in Georgia and South Carolina. The symptoms that qualify, and the evidence a claim requires.',
    'benefit-of-a-personal-injury-pain-diary' => 'A daily pain diary captures what medical records cannot. What to write, how often, and how it strengthens an injury claim.',
    'how-much-is-my-car-accident-claim-worth' => 'What actually determines a car accident claim\'s value — economic losses, non-economic damages, and the strength of liability.',
    '5-most-common-types-of-medical-malpractice-in-2023' => 'The five most common forms of medical malpractice, how each is proven, and what makes these claims different from ordinary injury cases.',
    // ---- chunk 2 of the tail ----
    'charleston-parking-lot-car-accident-liability' => 'Who is at fault in a Charleston parking lot collision? Why private property changes the analysis, and how these claims are proven.',
    'hospital-liability-for-medical-malpractice' => 'When a hospital itself can be sued for malpractice, not just the doctor — and how employment status changes who is liable.',
    'changing-workers-comp-doctors-in-georgia' => 'Can you change your treating doctor on a Georgia workers\' comp claim? How the panel of physicians works, and when a switch is allowed.',
    'dog-bite-prevention-tips' => 'Practical steps that prevent dog bites, the situations where most attacks happen, and what to do if one occurs.',
    'beginning-motorcycle-biker-risks' => 'The risks new motorcycle riders underestimate, why the first year is the most dangerous, and how to reduce the odds.',
    'charleston-car-crash-brain-injuries' => 'The types of traumatic brain injury a Charleston crash can cause, why symptoms are missed at first, and what recovery involves.',
    'do-you-need-a-workers-compensation-lawyer' => 'When a workers\' compensation claim needs a lawyer and when it does not — the disputes that most often require one.',
    'choking-at-nursing-homes' => 'Choking is a preventable nursing home risk. The precautions facilities owe residents, and when an incident becomes negligence.',
    'dangerous-savannah-intersections' => 'Savannah\'s most crash-prone intersections and roads, what makes each dangerous, and your options if you are injured on one.',
    'accepting-a-cash-offer-after-savannah-car-crash' => 'Why taking cash at the scene of a Savannah crash usually costs you, and what you give up by settling before you know your injuries.',
    'car-accidents-and-daylight-savings-time' => 'Crash rates measurably shift after the clocks change. Why the time change raises risk, and how to compensate for it.',
    'using-dashcams-as-evidence-of-fault-in-a-car-accident' => 'How dashcam footage is used to prove fault, when it is admissible, and how to preserve it before it is overwritten.',
    'common-driver-distractions' => 'The distractions that cause the most crashes, why some are worse than phones, and how they affect fault after a collision.',
    'shem-creek-boating-dock-injuries-mount-pleasant' => 'Boating and dock injuries at Shem Creek: the hazards specific to this waterfront, and who may answer when someone is hurt.',
    'georgia-wrongful-death-lawsuit' => 'How a Georgia wrongful death claim works — who may bring it, what it recovers, and how it differs from the estate\'s own claim.',
    'charleston-medical-malpractice-hospital-claim-south-carolina' => 'Filing a malpractice claim against a South Carolina hospital: the pre-suit notice, the expert affidavit, and what comes first.',
    'compensation-while-not-wearing-seat-belt' => 'Can you recover if you were not wearing a seat belt? How Georgia and South Carolina treat belt use as evidence, and what changed.',
    'documents-for-personal-injury-claim' => 'The documents an injury claim actually turns on — records, bills, wage proof, photographs — and when to start collecting them.',
    'how-spinal-cord-injuries-affect-you' => 'How a spinal cord injury changes daily life, the levels of severity, and the lifetime costs a claim has to account for.',
    'darien-brunswick-dangerous-roads-i95-us17' => 'Why the I-95 and US-17 corridor through Darien and Brunswick is among southeast Georgia\'s most dangerous, and what to do after a crash.',
    'ashley-phosphate-road-i-26-dangerous-intersection-charleston' => 'What makes the Ashley Phosphate Road and I-26 interchange so crash-prone, and your options if you are injured there.',
    'importance-of-eyewitness-testimony' => 'Independent eyewitnesses often decide a disputed liability case. What makes their testimony credible, and how it is used.',
    'summer-driving-safety-tips' => 'The seasonal risks that make summer driving more dangerous, and practical steps to take before a long trip.',
    'roadway-hazard-auto-accident' => 'When poor road conditions cause a crash, a government agency may share liability. How those claims work and why they move fast.',
    'why-injury-claims-may-be-delayed' => 'The reasons an injury claim stalls — some ordinary, some tactical — and what actually moves a delayed claim forward.',
    'tactics-insurers-use-to-deny-crash-claims-charleston' => 'Why a Charleston crash claim gets disputed or denied, the grounds insurers rely on, and how each one is answered.',
    'why-car-crashes-happen-close-to-home-charleston' => 'Most Charleston crashes happen close to home, not on the highway. Why familiarity raises risk rather than lowering it.',
    'follow-doctors-orders-after-accident' => 'Why following your doctor\'s instructions after an accident matters as much legally as medically, and what non-compliance costs.',
    'liability-for-roundabout-crashes-in-charleston' => 'Roundabout crashes in Charleston turn on yield rules many drivers misunderstand. How fault is decided in these collisions.',
    'workers-comp-for-skin-cancer' => 'Can outdoor workers claim workers\' compensation for skin cancer? What makes it an occupational disease, and how it is proven.',
    'charleston-parking-lot-parking-garage-accident' => 'What to do after a Charleston parking lot or garage accident, and why private property complicates the liability question.',
    'how-to-spot-distracted-drivers-ten-signs-savannah-ga' => 'Ten signs the driver near you is distracted, how to give them room, and what to document if they cause a crash.',
    'returning-to-work-too-soon-charleston-crash' => 'Going back to work too soon after a Charleston crash can undercut your claim as well as your recovery. What to weigh first.',
    'common-workplace-injuries-georgia' => 'The injuries that most often lead to Georgia workers\' compensation claims, and the reporting steps each one requires.',
    'fmcsa-violations-truck-accident-claims' => 'Federal trucking rules govern hours, maintenance and driver qualification. How a violation becomes evidence of negligence.',
    'signs-of-concussion-from-car-crash' => 'Concussion symptoms after a crash can appear days later. What to watch for in Georgia and South Carolina, and when to seek care.',
    'atm-attack-liability' => 'When a bank or property owner may be liable for an assault at an ATM in Georgia, and what negligent security requires.',
    'workers-compensation-claim-process-georgia' => 'What to do after a Georgia workplace injury, in order — reporting, medical care, and the steps that protect your benefits.',
    'charleston-lyft-driver-ran-red-light-and-hit-my-car' => 'Hit by a Charleston Lyft driver who ran a red light? Whose insurance applies, and how rideshare coverage tiers change the claim.',
    'dog-bite-laws-south-carolina-charleston' => 'South Carolina holds dog owners strictly liable. What that means for a Charleston bite claim, and when a landlord may also answer.',
    'avoiding-motorcycle-crash-injuries' => 'The gear and riding habits that most reduce motorcycle injury severity, and what the research actually supports.',
    'slip-and-fall-negligence-elements' => 'What a slip and fall claim must prove — the hazard, the owner\'s knowledge, and the failure to fix it — and how each is shown.',
    '18-wheeler-wrecks-on-the-arthur-ravenel-jr-bridge-us-17' => 'Truck wrecks on the Ravenel Bridge and US-17: the risks specific to this corridor, and who is responsible when one happens.',
    'liability-for-crashes-in-heavy-rainfall' => 'Rain does not excuse a crash. What drivers must do in wet conditions, and how liability is assessed when they do not.',
    'commercial-truck-accidents-who-is-at-fault' => 'A truck crash often has several liable parties — driver, carrier, loader, maintenance provider. How fault gets sorted out.',
    'accident-my-fault-can-i-receive-workers-comp' => 'Workers\' compensation is no-fault, so your own mistake rarely bars benefits. The narrow exceptions that actually do.',
    'road-hazard-car-accident-liability' => 'When a pothole, debris or missing sign causes a crash, who answers for it — and why claims against road authorities move fast.',
    'savannah-dangerous-highways-i16-i95-abercorn' => 'Why I-16, I-95, Abercorn and DeRenne carry so many Savannah crashes, and what to do if you are injured on one.',
    'overview-georgia-distracted-driving-laws' => 'What Georgia\'s distracted driving law actually prohibits, how it is enforced, and how a violation affects a crash claim.',
    'charleston-reckless-driving-crash' => 'How reckless driving causes Charleston crashes, what separates it from ordinary negligence, and why it can raise a claim\'s value.',
    'police-report-as-proof-of-liability' => 'A police report helps but does not decide liability. What it contains, how insurers treat it, and its limits as evidence.',
    'workers-comp-medical-coverage' => 'What medical treatment workers\' compensation covers in Georgia and South Carolina, and what to do when care is refused.',
    'lower-king-street-pedestrian-safety' => 'Why Lower King Street is one of Charleston\'s riskiest stretches for pedestrians, and who answers when someone is struck.',
    'folly-road-car-accidents-james-island-charleston' => 'What makes Folly Road one of Charleston\'s most crash-prone corridors, and your options after a collision on James Island.',
    'child-passenger-automobile-safety-georgia' => 'Georgia\'s child passenger safety rules, the seat stages by age and size, and what safest practice adds beyond the legal minimum.',
    'paying-medical-bills-during-a-claim' => 'How to pay medical bills while an injury claim is still open — health insurance, med-pay, and letters of protection.',
    'third-party-liability-for-work-injury' => 'When someone other than your employer caused a workplace injury, a third-party claim can recover what workers\' comp cannot.',
    'lawsuit-for-work-injury' => 'When you can sue over a workplace injury rather than only claim workers\' compensation, and what the exclusive remedy rule bars.',
    'what-to-do-if-your-workers-compensation-claim-is-denied' => 'A denied workers\' comp claim is not final. How the appeal works in Georgia and South Carolina, and what to do first.',
    'why-wont-a-personal-lawyer-take-my-case' => 'Why a personal injury lawyer might decline your case — liability, damages, deadlines — and what to do if one does.',
    'personal-injury-lawsuit-steps' => 'The stages of a personal injury lawsuit from filing through trial, and roughly how long each one takes.',
    'liability-for-brake-checking-crashes-charleston' => 'Brake checking can shift fault away from the following driver. How Charleston crashes caused by it are investigated.',
    'brain-injury-claim' => 'How a traumatic brain injury claim is built — the medical evidence, the long-term costs, and why these cases take longer.',
    'personal-injury-claim-charleston-berkeley-dorchester-county' => 'Charleston, Berkeley and Dorchester counties handle injury claims differently. Why venue matters, and how it is chosen.',
    'safe-bike-riding-georgias-roadways' => 'Georgia\'s rules for cyclists, the road positioning that reduces risk, and what to do after a collision with a vehicle.',
    'why-get-black-box-data-after-truck-crash-savannah' => 'A truck\'s black box records speed, braking and hours before a crash. Why it must be preserved immediately after a Savannah wreck.',
    'why-driving-while-hungover-is-a-dangerous-savannah-crash-risk' => 'A hangover impairs driving after the alcohol has cleared. Why that raises Savannah crash risk, and how it affects liability.',
    'georgia-law-on-tailgating-accident-liability' => 'Following too closely can establish negligence per se. How that works in a Georgia tailgating claim, and what it proves.',
    'turkey-fryer-injury-claims' => 'Turkey fryer burns and fires are a recurring holiday injury. When a manufacturer or host may be liable, and what a claim needs.',
    'work-zone-car-accident-liability' => 'Work zone crashes involve contractors, agencies and drivers at once. Why liability is complicated, and how it is untangled.',
    // ---- chunk 3 of the tail — completes the >=500-impression pool ----
    'safety-tips-driving-work-zones-georgia' => 'How to drive safely through Georgia work zones, why they are disproportionately dangerous, and who is liable when a crash happens.',
    'dangerous-rural-crashes-in-charleston' => 'Rural roads around Charleston carry hazards highways do not — no lighting, no shoulders, slow emergency response. What raises the risk.',
    'drowsy-driving-epidemic-georgia' => 'Drowsy driving impairs reaction time much like alcohol. How common it is on Georgia roads, and what it means for fault.',
    'military-base-accidents-joint-base-charleston-rights' => 'Injured near Joint Base Charleston? How the Feres Doctrine limits active-duty claims, and what options civilians and off-duty personnel have.',
    'north-charleston-crime-rate-hit-and-run' => 'Why North Charleston sees a disproportionate share of hit-and-run crashes, and what coverage pays when the driver is never found.',
    'teenagers-and-driving-distracted' => 'Why distraction is the leading factor in teen crashes, what the data shows, and how parents can reduce the risk.',
    'how-long-personal-injury-case-charleston-sc' => 'How long a Charleston personal injury case usually takes, what lengthens it, and when litigation becomes necessary.',
    'workers-compensation-car-accident' => 'Crashed while driving for work? When a car accident is covered by workers\' compensation, and when you also have a third-party claim.',
    'fault-for-car-accident' => 'How fault is determined after a Georgia car accident — the evidence that matters most, and how shared blame is apportioned.',
    'carriage-tour-accidents-downtown-charleston-liability' => 'Who is liable when a Charleston carriage tour causes injury — the operator, the driver, or the city? How these claims work.',
    'valuing-compensation-for-a-personal-injury' => 'Why two similar injuries settle for very different amounts, and the factors that actually drive what a claim is worth.',
    'ben-sawyer-boulevard-bridge-accidents-sullivans-island' => 'Ben Sawyer Boulevard is the only road to Sullivan\'s Island. Why its swing bridge and two lanes produce crashes, and who answers.',
    'aggressive-driving-in-georgia' => 'Georgia ranks among the worst states for aggressive driving. What the behaviour includes, and how it affects liability after a crash.',
    'jones-act-claims-south-carolina-maritime-worker-rights' => 'The Jones Act lets injured seamen sue their employer for full damages, unlike workers\' compensation. Who qualifies, and what it recovers.',
    'how-do-i-know-if-i-have-a-medical-malpractice-case' => 'The four elements a medical malpractice claim must prove, and the expert requirements Georgia and South Carolina impose before filing.',
    'punitive-damages-in-drunk-driving-accident' => 'When a drunk driving crash supports punitive damages, what conduct is required, and how the standard differs by state.',
    'benefits-of-an-accident-reconstruction-expert' => 'What an accident reconstructionist does, the data they rely on, and when their analysis decides a disputed crash claim.',
    'what-is-the-role-of-a-personal-injury-lawyer-in-a-case' => 'What a personal injury lawyer actually does across a case — investigation, valuation, negotiation, and litigation when needed.',
    'the-most-common-causes-of-truck-accidents' => 'The causes behind most Georgia and South Carolina truck crashes, and how each one points to a different liable party.',
    'who-pays-for-damages-from-t-bone-crashes-in-savannah' => 'T-bone crashes cause severe injuries and contested fault. How liability is decided after a Savannah side-impact collision.',
    'south-carolina-comparative-fault-partially-at-fault' => 'How being partly at fault affects a Charleston accident claim, where South Carolina\'s recovery bar sits, and how insurers use it.',
    'pedestrian-bicycle-safety-north-charleston' => 'Pedestrian and cyclist rights in North Charleston, the duties drivers owe them, and what to do after being struck.',
    'am-i-eligible-for-workers-compensation' => 'What makes you eligible for workers\' compensation in Georgia or South Carolina, and the reporting steps that protect eligibility.',
    'jet-ski-personal-watercraft-accidents-charleston' => 'Jet ski and personal watercraft crashes on Charleston\'s waterways: common causes, who may be liable, and how these claims differ.',
    'nursing-home-liability' => 'When the nursing home itself is liable for abuse or neglect, not just the individual staff member, and what that requires.',
    'nursing-home-abuse-warning-signs' => 'The warning signs of nursing home abuse in Georgia, the risks that make it more likely, and what families should do.',
    'how-do-i-know-if-i-have-a-personal-injury-case' => 'The four elements a personal injury case requires, and how shared fault affects recovery in Georgia and South Carolina.',
    'when-to-consider-settling-a-claim' => 'What to weigh before accepting a settlement — treatment status, future costs, and why the first offer arrives so quickly.',
    'emergency-room-errors-charleston-misdiagnosis-malpractice' => 'Emergency room misdiagnosis is the most common malpractice claim. When a missed diagnosis in Charleston becomes actionable.',
    'charleston-historic-sidewalk-slip-fall-city-liable' => 'Charleston\'s historic sidewalks create real hazards. When the city is liable, when the property owner is, and the deadlines involved.',
    'steps-after-dog-bite' => 'What to do immediately after a dog attack — medical care, reporting, identifying the owner — and what a claim later depends on.',
    'liability-in-head-on-collisions-savannah-ga' => 'Head-on collisions cause the most severe injuries. How fault is established after a Savannah head-on crash, and who may answer.',
    'dui-accidents' => 'Injured by a drunk driver in Savannah? How DUI crash claims differ from ordinary collisions, and what damages may be available.',
    'understanding-eye-injuries-after-a-savannah-car-accident' => 'How car crashes cause eye injuries, why some are not obvious at the scene, and what a claim for vision loss involves.',
    'maybank-highway-car-accidents-johns-island' => 'Maybank Highway is Johns Island\'s only way in and out. Why that bottleneck produces crashes, and what to do after one.',
    'appealing-a-denied-workers-compensation-claim' => 'How to appeal a denied workers\' compensation claim, the deadlines that apply, and what evidence changes the outcome.',
    'charleston-rideshare-brake-failure-accident' => 'When a rideshare driver\'s brakes fail in Charleston, liability may reach the driver, the company, or a maintenance provider.',
    'choosing-your-personal-injury-lawyer' => 'What actually distinguishes personal injury lawyers — trial record, case experience, communication — and what to ask before signing.',
    'risk-of-refusing-medical-care-after-car-crash-charleston' => 'Refusing treatment after a Charleston crash is your right, but it gives insurers their strongest argument. What the refusal costs.',
    'safest-hospitals-georgia' => 'How Georgia hospitals compare on safety, what the ratings actually measure, and what to weigh when choosing where to be treated.',
    'port-of-charleston-injury-claims-longshoremen-dock-workers' => 'Dock workers at the Port of Charleston are usually covered by federal law, not state workers\' compensation. What that changes.',
    'how-to-maximize-your-car-accident-compensation-in-south-carolina' => 'What actually increases a South Carolina crash recovery — documentation, treatment consistency, and the damages often left out.',
    'truck-accident-liability' => 'Truck crash liability can reach the driver, carrier, loader, mechanic or manufacturer. How federal rules help establish it.',
    'tips-for-choosing-a-motor-vehicle-accident-attorney' => 'What to look for in a car accident lawyer in Georgia or South Carolina, and the questions worth asking before you sign.',
    'liability-for-charleston-underride-truck-crashes' => 'Underride crashes are among the deadliest truck collisions. Who may be liable in Charleston, and what guard standards require.',
    'car-totaled-in-accident-what-to-do' => 'What happens when your car is declared a total loss, how actual cash value is set, and how to dispute a lowball offer.',
    'car-accidents-ladson-i-26-exit-203-danger-zone' => 'Why the I-26 Exit 203 interchange at Ladson produces so many crashes, and which county your claim belongs in.',
    'steps-to-take-if-you-are-involved-in-a-bicycle-hit-and-run' => 'What to do after a bicycle hit and run in Georgia or South Carolina, and which coverage pays when the driver is never identified.',
    'second-opinion-for-charleston-car-crash-injuries' => 'When a second medical opinion is worth getting after a Charleston crash, and how it affects both treatment and your claim.',
    'the-importance-of-gathering-evidence-after-a-motorcycle-accident' => 'The evidence a motorcycle claim depends on, why rider bias makes it matter more, and what disappears within days.',
    'pedestrian-safety-park-circle-north-charleston' => 'Why pedestrian crashes are rising in Park Circle as nightlife outpaces the road design, and what walkers should know.',
    'georgia-worker-injury-statistics-prevention' => 'Which Georgia industries produce the most workplace injuries, what the data shows, and the prevention that actually works.',
    'boating-accidents-charleston-harbor-legal-rights' => 'Boating accidents in Charleston Harbor raise jurisdiction questions — federal maritime law, state law, or both. What that means.',
    'protect-child-dog-bite-injury' => 'How to reduce a child\'s risk of a dog bite, the situations where most attacks happen, and what to do if one occurs.',
    'savannah-highway-truck-accidents-west-ashley-us-17' => 'Why US-17 through West Ashley is one of Charleston\'s most dangerous truck corridors, and what to do after a collision.',
    'nursing-home-abuse-charleston-signs-families' => 'The warning signs of nursing home abuse Charleston families should watch for, and the steps to take when you see them.',
    'motorcycle-accidents-dorchester-road-data' => 'What crash data shows about motorcycle collisions on Dorchester Road, the manoeuvres behind them, and who is usually at fault.',
    'protecting-child-burn-injuries-home' => 'The household hazards behind most childhood burns, how to reduce them, and when a product defect makes someone else liable.',
    'charleston-delivery-truck-pedestrian-cyclist-accidents' => 'Hit by a delivery van or box truck downtown? How liability works for pedestrians and cyclists on King, Meeting and Market.',
    'golf-cart-accidents-charleston-island-resort-communities' => 'Golf cart crashes in Charleston\'s island and resort communities: where carts may legally operate, and who is liable when one crashes.',
    'liability-and-causes-for-backing-up-crashes-in-charleston' => 'Backing-up collisions are common in Charleston parking lots and rarely straightforward. How fault is assigned in these crashes.',
    'proving-negligence-personal-injury' => 'How to prove another party is liable for your injury — duty, breach, causation and damages, and the evidence each element needs.',
    'construction-worker-injuries-charleston-sc-rights' => 'Charleston\'s building boom has raised construction injuries. Your rights on site, and when a claim goes beyond workers\' compensation.',
    'workers-compensation-benefit-types' => 'The benefits workers\' compensation actually provides — medical care, wage replacement, disability ratings — and how each is calculated.',
    'steps-after-truck-accident' => 'What to do after a collision with a commercial truck, the evidence that vanishes fastest, and why these claims move differently.',
    'compensation-for-car-crash-facial-injuries-charleston' => 'Facial injuries and scarring after a Charleston crash carry costs beyond medical bills. How disfigurement is valued in a claim.',
    'boeing-north-charleston-workplace-injuries-workers-comp' => 'Injuries at Boeing\'s North Charleston plant: what workers\' compensation covers, and when a third-party claim is also available.',
    'rivers-avenue-pedestrian-deaths-north-charleston' => 'Why Rivers Avenue is one of South Carolina\'s deadliest corridors for pedestrians, and what a claim involves after a fatal crash.',
);

$backups = array();
$ok = $skip = $fail = 0;

foreach ( $EXCERPTS as $slug => $excerpt ) {
    // The pool spans both post types. Looking up only 'post' silently failed on
    // /resources/pedestrian-bicycle-safety-north-charleston/, which is a resource.
    $post = get_page_by_path( $slug, OBJECT, 'post' );
    if ( ! $post ) {
        $post = get_page_by_path( $slug, OBJECT, 'resource' );
    }
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
