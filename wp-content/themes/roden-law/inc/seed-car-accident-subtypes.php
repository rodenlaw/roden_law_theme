<?php
/**
 * Seeder: 8 Car Accident Sub-Type Pages
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-car-accident-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: car-accident-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'car-accident-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    // Try the ACF-registered slug variant.
    $pillar = get_page_by_path( 'car-accident-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "car-accident-lawyers" not found. Create it first.' );
    return;
}

$pillar_id   = $pillar->ID;
$pillar_type = $pillar->post_type;

WP_CLI::log( "Parent pillar: \"{$pillar->post_title}\" (ID {$pillar_id}, type {$pillar_type})" );

/* ------------------------------------------------------------------
   Look up Eric Roden's attorney post ID for author attribution
   ------------------------------------------------------------------ */

$eric = get_page_by_path( 'eric-roden', OBJECT, 'attorney' );
$author_attorney_id = $eric ? $eric->ID : 0;
if ( $author_attorney_id ) {
    WP_CLI::log( "Author attorney: Eric Roden (ID {$author_attorney_id})" );
} else {
    WP_CLI::warning( 'Attorney "eric-roden" not found — _roden_author_attorney will be empty.' );
}

/* ------------------------------------------------------------------
   Ensure practice_category term exists
   ------------------------------------------------------------------ */

$cat_term = term_exists( 'car-accidents', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Car Accidents', 'practice_category', array( 'slug' => 'car-accidents' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Drunk Driver Accident
       ============================================================ */
    array(
        'title'   => 'Drunk Driver Accident Lawyers',
        'slug'    => 'drunk-driver-accident',
        'excerpt' => 'Injured by a drunk driver in Georgia or South Carolina? Our attorneys pursue maximum compensation from impaired drivers and establishments that over-served them.',
        'content' => <<<'HTML'
<h2>Fighting for Victims of Drunk Driving Accidents</h2>
<p>Drunk driving remains one of the most preventable causes of catastrophic car accidents in the United States. According to the <a href="https://www.nhtsa.gov/risky-driving/drunk-driving" target="_blank" rel="noopener">National Highway Traffic Safety Administration (NHTSA)</a>, approximately 37 people die every day in drunk-driving crashes across the country — one death every 39 minutes. Despite decades of enforcement and public awareness campaigns, alcohol-impaired driving continues to devastate families throughout Georgia and South Carolina.</p>
<p>At Roden Law, our drunk driving accident lawyers understand the unique legal complexities of these cases. Beyond a standard negligence claim against the impaired driver, victims may have additional legal avenues for recovery, including dram shop liability claims against bars, restaurants, or social hosts who illegally served alcohol to visibly intoxicated individuals.</p>

<h2>Georgia &amp; South Carolina Drunk Driving Laws</h2>
<p>Both Georgia and South Carolina set the legal blood alcohol concentration (BAC) limit at 0.08% for drivers 21 and older, and 0.02% for drivers under 21. Commercial vehicle operators face a lower threshold of 0.04%.</p>
<p>Georgia's dram shop law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-4/" target="_blank" rel="noopener">O.C.G.A. § 51-1-40</a>) allows injured parties to sue establishments that knowingly served alcohol to a noticeably intoxicated person or to a minor, when that service was the proximate cause of the injuries. South Carolina's dram shop statute (<a href="https://www.scstatehouse.gov/code/t61c004.php" target="_blank" rel="noopener">S.C. Code § 61-4-580</a>) similarly holds liquor licensees liable when they serve a visibly intoxicated person who then causes injury to a third party.</p>
<p>Data from the <a href="https://www.cdc.gov/transportationsafety/impaired-driving/index.html" target="_blank" rel="noopener">Centers for Disease Control and Prevention (CDC)</a> shows that alcohol-impaired driving costs the United States more than $68.9 billion annually in economic damages, including medical expenses, lost productivity, and property damage.</p>

<h2>Proving a Drunk Driving Accident Claim</h2>
<p>A drunk driving accident claim requires establishing that the at-fault driver was impaired and that their impairment caused the accident and your injuries. Critical evidence includes:</p>
<ul>
<li>Police reports documenting BAC test results and field sobriety test observations</li>
<li>Toxicology and blood test records from the hospital</li>
<li>Surveillance footage from bars, restaurants, or convenience stores</li>
<li>Witness testimony regarding the driver's behavior and alcohol consumption</li>
<li>Criminal case records, including DUI arrest reports and plea agreements</li>
</ul>
<p>A criminal DUI conviction is powerful evidence in a civil injury case, but it is not required. Even if criminal charges are reduced or dismissed, you can still pursue a civil claim for damages based on the lower "preponderance of the evidence" standard.</p>

<h2>Damages in Drunk Driving Cases</h2>
<p>Victims of drunk driving accidents may be entitled to compensatory damages for medical bills, lost wages, pain and suffering, and diminished quality of life. In both Georgia and South Carolina, courts may also award <strong>punitive damages</strong> in drunk driving cases to punish the defendant's reckless disregard for public safety. Georgia caps punitive damages at $250,000 in most cases (O.C.G.A. § 51-12-5.1), with exceptions for cases involving specific intent to harm or impaired driving under the influence of drugs or alcohol. South Carolina does not impose a statutory cap on punitive damages but requires clear and convincing evidence of willful, wanton, or reckless conduct.</p>

<h2>Why Choose Roden Law for Your Drunk Driving Case</h2>
<p>Our attorneys have recovered millions for victims of impaired driving crashes across Georgia and South Carolina. We conduct thorough independent investigations, work with accident reconstruction experts, and pursue every available source of compensation — from the drunk driver's auto insurance to dram shop liability claims against negligent alcohol vendors. There is no fee unless we win your case.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue a bar or restaurant that served the drunk driver?',
                'answer'   => 'Yes. Under Georgia\'s dram shop law (O.C.G.A. § 51-1-40) and South Carolina\'s statute (S.C. Code § 61-4-580), establishments that knowingly serve alcohol to visibly intoxicated patrons can be held liable for injuries caused by those patrons.',
            ),
            array(
                'question' => 'What if the drunk driver was not convicted of DUI?',
                'answer'   => 'A criminal conviction is not required to file a civil injury claim. Civil cases use a lower burden of proof (preponderance of evidence vs. beyond a reasonable doubt), so you may still recover damages even if criminal charges are dismissed.',
            ),
            array(
                'question' => 'Are punitive damages available in drunk driving cases?',
                'answer'   => 'Yes. Both Georgia and South Carolina allow punitive damages in drunk driving cases to punish especially reckless behavior. Georgia generally caps punitive damages at $250,000, with exceptions for DUI cases. South Carolina has no statutory cap but requires clear and convincing evidence.',
            ),
            array(
                'question' => 'What is the statute of limitations for a drunk driving accident claim?',
                'answer'   => 'In Georgia, you have 2 years from the date of the accident to file a personal injury lawsuit (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530).',
            ),
            array(
                'question' => 'What compensation can I recover after a drunk driving accident?',
                'answer'   => 'You may recover medical expenses, lost wages, pain and suffering, emotional distress, property damage, and potentially punitive damages. Wrongful death claims may also be available if a loved one was killed by an impaired driver.',
            ),
            array(
                'question' => 'How does a criminal DUI case affect my civil claim?',
                'answer'   => 'The two cases are separate proceedings. A DUI conviction can serve as strong evidence of negligence in your civil case, but the civil case proceeds independently regardless of the criminal outcome.',
            ),
        ),
    ),

    /* ============================================================
       2. Rideshare & Uber Accident
       ============================================================ */
    array(
        'title'   => 'Rideshare &amp; Uber Accident Lawyers',
        'slug'    => 'rideshare-uber-accident',
        'excerpt' => 'Hurt in a rideshare accident involving Uber or Lyft? Our attorneys navigate complex insurance layers to secure full compensation for passengers, drivers, and bystanders.',
        'content' => <<<'HTML'
<h2>Rideshare Accident Claims in Georgia &amp; South Carolina</h2>
<p>The growth of rideshare services like Uber and Lyft has transformed transportation across Georgia and South Carolina — but it has also introduced complex liability questions when accidents occur. According to <a href="https://www.nhtsa.gov/technology-innovation/vehicle-safety-communications" target="_blank" rel="noopener">NHTSA data</a>, the proliferation of for-hire vehicles has contributed to increased urban traffic congestion and associated crash risks. Whether you are a rideshare passenger, another motorist, a cyclist, or a pedestrian, our attorneys can help you navigate the unique insurance and liability issues that rideshare accidents present.</p>

<h2>How Rideshare Insurance Works</h2>
<p>Rideshare companies maintain tiered insurance coverage that depends on the driver's status at the time of the crash:</p>
<ul>
<li><strong>App off:</strong> Only the driver's personal auto insurance applies.</li>
<li><strong>App on, waiting for a ride request:</strong> The rideshare company provides limited liability coverage — typically $50,000 per person/$100,000 per accident for bodily injury and $25,000 for property damage.</li>
<li><strong>En route to pick up or during a trip:</strong> The rideshare company's full commercial policy applies — up to $1 million in liability coverage, plus uninsured/underinsured motorist coverage.</li>
</ul>
<p>Understanding which coverage tier applies at the moment of the crash is critical to maximizing your recovery.</p>

<h2>South Carolina Transportation Network Company Act</h2>
<p>South Carolina regulates rideshare operations under the Transportation Network Company (TNC) Act (<a href="https://www.scstatehouse.gov/code/t58c023.php" target="_blank" rel="noopener">S.C. Code § 58-23-1610 et seq.</a>), which requires TNCs to maintain the tiered insurance coverage described above. Georgia similarly requires rideshare companies to carry minimum insurance coverage that varies based on the driver's operational status. These state regulations establish the minimum coverage floors that protect injured parties.</p>

<h2>Common Rideshare Accident Injuries</h2>
<p>Rideshare passengers face particular injury risks because many riders do not wear seatbelts in the back seat and rideshare vehicles frequently stop and start in high-traffic areas. Common injuries include:</p>
<ul>
<li>Whiplash and cervical spine injuries from rear-end collisions</li>
<li>Traumatic brain injuries from side-impact crashes</li>
<li>Broken bones and soft tissue damage</li>
<li>Spinal cord injuries in severe crashes</li>
<li>Psychological trauma and anxiety disorders</li>
</ul>

<h2>Determining Liability in Rideshare Accidents</h2>
<p>Rideshare accident cases frequently involve multiple potentially liable parties: the rideshare driver, the rideshare company, other motorists, vehicle manufacturers (in cases involving defective parts), and even government entities responsible for road maintenance. Our attorneys investigate each accident thoroughly, working with accident reconstruction specialists to identify every source of liability and insurance coverage available to compensate your injuries.</p>

<h2>What to Do After a Rideshare Accident</h2>
<p>If you are involved in a rideshare accident, take a screenshot of the ride details in the Uber or Lyft app, document the scene with photos, obtain the driver's information and insurance details, seek immediate medical attention, and contact an attorney before speaking with insurance adjusters. Rideshare companies have teams of lawyers working to minimize their exposure — you deserve an advocate fighting for your interests.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who is liable if my Uber or Lyft driver causes an accident?',
                'answer'   => 'Both the driver and the rideshare company may be liable. If the driver was on an active trip or en route to pick up a passenger, the rideshare company\'s $1 million commercial insurance policy typically applies.',
            ),
            array(
                'question' => 'What insurance coverage applies during a rideshare trip?',
                'answer'   => 'When a rideshare driver has accepted a ride or is transporting a passenger, the company provides up to $1 million in liability coverage plus uninsured/underinsured motorist coverage. Coverage is lower when the app is on but no ride has been accepted.',
            ),
            array(
                'question' => 'Can I sue Uber or Lyft directly after an accident?',
                'answer'   => 'While rideshare companies classify drivers as independent contractors, you can file a claim against the company\'s insurance policy. In some circumstances, direct claims against the company may be possible. An experienced attorney can evaluate all available avenues.',
            ),
            array(
                'question' => 'What should I do immediately after a rideshare accident?',
                'answer'   => 'Screenshot your ride details in the app, call 911, document the scene with photos, get the driver\'s information, seek medical attention immediately, and contact an attorney before giving recorded statements to any insurance company.',
            ),
            array(
                'question' => 'Does South Carolina have specific rideshare insurance requirements?',
                'answer'   => 'Yes. The South Carolina TNC Act (S.C. Code § 58-23-1610) requires rideshare companies to maintain tiered insurance coverage based on the driver\'s operational status, including $1 million in coverage during active trips.',
            ),
        ),
    ),

    /* ============================================================
       3. Rear-End Collision
       ============================================================ */
    array(
        'title'   => 'Rear-End Collision Lawyers',
        'slug'    => 'rear-end-collision',
        'excerpt' => 'Rear-ended in Georgia or South Carolina? Our lawyers hold negligent tailgating and distracted drivers accountable while fighting for full compensation for your injuries.',
        'content' => <<<'HTML'
<h2>Rear-End Collision Accidents in Georgia &amp; South Carolina</h2>
<p>Rear-end collisions are among the most common types of car accidents in the United States. The <a href="https://www.nhtsa.gov/risky-driving/distracted-driving" target="_blank" rel="noopener">National Highway Traffic Safety Administration (NHTSA)</a> reports that rear-end crashes account for approximately 29% of all traffic accidents, resulting in tens of thousands of injuries and fatalities annually. Distracted driving — particularly smartphone use — is a leading contributor to these preventable collisions.</p>
<p>At Roden Law, our rear-end collision lawyers represent victims across Georgia and South Carolina who suffer injuries ranging from whiplash to traumatic brain injuries. Even seemingly minor rear-end accidents can cause serious, long-lasting injuries that require extensive medical treatment.</p>

<h2>Common Causes of Rear-End Collisions</h2>
<p>Rear-end crashes typically result from one or more forms of driver negligence:</p>
<ul>
<li><strong>Distracted driving:</strong> Texting, phone calls, eating, or adjusting GPS while driving</li>
<li><strong>Tailgating:</strong> Following too closely to stop safely when traffic slows</li>
<li><strong>Speeding:</strong> Excessive speed reduces reaction time and increases stopping distance</li>
<li><strong>Impaired driving:</strong> Alcohol and drugs impair judgment and reaction time</li>
<li><strong>Fatigued driving:</strong> Drowsy drivers have delayed reactions and impaired awareness</li>
<li><strong>Poor weather conditions:</strong> Rain, fog, and ice reduce visibility and tire traction</li>
</ul>
<p>NHTSA data shows that distracted driving alone was responsible for 3,308 deaths in a single recent year, with rear-end collisions being one of the most common crash types associated with driver inattention.</p>

<h2>Is the Rear Driver Always at Fault?</h2>
<p>While the rear driver is presumed to be at fault in most rear-end collisions — because all drivers have a duty to maintain a safe following distance — this presumption can be rebutted. The lead driver may share liability if they:</p>
<ul>
<li>Suddenly reversed without warning</li>
<li>Had non-functioning brake lights</li>
<li>Brake-checked or intentionally slowed to cause a collision</li>
<li>Merged unsafely into traffic without adequate space</li>
</ul>
<p>Under Georgia's modified comparative fault rule (O.C.G.A. § 51-12-33), you can recover damages as long as you are less than 50% at fault. South Carolina's rule permits recovery if you are less than 51% at fault. Our attorneys investigate every angle to minimize any allegation of shared fault.</p>

<h2>Injuries from Rear-End Collisions</h2>
<p>The sudden force of a rear-end impact often causes the occupant's body to jerk forward and backward violently, leading to injuries including whiplash and cervical strain, herniated or bulging discs, concussions and traumatic brain injuries, shoulder and back injuries, and temporomandibular joint (TMJ) disorders. Many of these injuries have delayed onset — symptoms may not appear for hours or even days after the collision. That is why it is critical to seek medical attention immediately, even if you feel fine at the scene.</p>

<h2>Damages Available in Rear-End Collision Cases</h2>
<p>Victims of rear-end collisions may recover compensation for all economic and non-economic losses, including emergency medical care and ongoing treatment, physical therapy and rehabilitation, lost wages and reduced earning capacity, pain and suffering, vehicle repair or replacement costs, and diminished value of your vehicle after repairs.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Is the rear driver always at fault in a rear-end collision?',
                'answer'   => 'While there is a strong presumption that the rear driver is at fault, this can be rebutted if the lead driver acted negligently — for example, by suddenly reversing, having broken brake lights, or brake-checking.',
            ),
            array(
                'question' => 'What should I do after being rear-ended?',
                'answer'   => 'Call 911 to report the accident, seek medical attention even if you feel fine (symptoms can be delayed), document the scene with photos, exchange insurance information, and contact an attorney before giving statements to insurance companies.',
            ),
            array(
                'question' => 'Can I recover damages if I was partially at fault?',
                'answer'   => 'Yes. Georgia allows recovery if you are less than 50% at fault (O.C.G.A. § 51-12-33), and South Carolina allows recovery if you are less than 51% at fault. Your compensation is reduced by your percentage of fault.',
            ),
            array(
                'question' => 'How long do I have to file a rear-end collision claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years from the date of the accident (O.C.G.A. § 9-3-33). In South Carolina, it is 3 years (S.C. Code § 15-3-530). Missing these deadlines typically bars your claim.',
            ),
            array(
                'question' => 'What if my symptoms did not appear until days after the accident?',
                'answer'   => 'Delayed symptoms are common in rear-end collisions, especially for whiplash, concussions, and soft tissue injuries. Seeking prompt medical attention creates documentation linking your injuries to the accident, which is critical for your claim.',
            ),
            array(
                'question' => 'How much is my rear-end collision case worth?',
                'answer'   => 'Case value depends on the severity of injuries, medical costs, lost wages, pain and suffering, and the available insurance coverage. Our attorneys evaluate every case individually to pursue maximum compensation.',
            ),
        ),
    ),

    /* ============================================================
       4. Hit & Run Accident
       ============================================================ */
    array(
        'title'   => 'Hit &amp; Run Accident Lawyers',
        'slug'    => 'hit-and-run-accident',
        'excerpt' => 'Victim of a hit and run in Georgia or South Carolina? Our attorneys help you recover compensation through uninsured motorist coverage and investigative resources.',
        'content' => <<<'HTML'
<h2>Hit &amp; Run Accident Claims in Georgia &amp; South Carolina</h2>
<p>Being the victim of a hit and run accident is a frightening and frustrating experience. The at-fault driver has fled the scene, leaving you injured, confused, and uncertain about how to pay for your medical bills and vehicle damage. According to the <a href="https://aaafoundation.org/hit-and-run-crashes-prevalence-contributing-factors-and-countermeasures/" target="_blank" rel="noopener">AAA Foundation for Traffic Safety</a>, hit and run crashes account for approximately 24% of all pedestrian fatalities and have been increasing steadily over the past decade.</p>
<p>At Roden Law, our hit and run accident lawyers help victims across Georgia and South Carolina recover compensation — even when the at-fault driver is never identified. Through uninsured motorist coverage, thorough investigation, and aggressive legal advocacy, we work to ensure that hit and run victims are not left bearing the financial burden of someone else's reckless and criminal behavior.</p>

<h2>Hit &amp; Run Laws in Georgia and South Carolina</h2>
<p>Leaving the scene of an accident is a crime in both states. Georgia law (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/section-40-6-270/" target="_blank" rel="noopener">O.C.G.A. § 40-6-270</a>) requires drivers involved in accidents resulting in injury or death to stop, render aid, and provide identification. Violations carry criminal penalties including fines and imprisonment. South Carolina law (<a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-1210</a>) similarly requires drivers to stop, provide information, and render reasonable assistance. Leaving the scene of an accident resulting in death is a felony in both states.</p>

<h2>Recovering Compensation After a Hit &amp; Run</h2>
<p>When the at-fault driver flees, your own insurance policy becomes the primary source of recovery. The key coverage types include:</p>
<ul>
<li><strong>Uninsured Motorist (UM) Coverage:</strong> This covers your injuries when the at-fault driver is unidentified. Georgia requires insurers to offer UM coverage, while South Carolina requires it by default (you must affirmatively reject it in writing).</li>
<li><strong>Medical Payments (MedPay) Coverage:</strong> Pays your medical bills regardless of fault, up to the policy limit.</li>
<li><strong>Collision Coverage:</strong> Covers damage to your vehicle after the deductible.</li>
</ul>
<p>In cases where the hit and run driver is later identified, you can also pursue a claim directly against the driver and their insurance.</p>

<h2>How We Investigate Hit &amp; Run Cases</h2>
<p>Our attorneys work alongside law enforcement and private investigators to identify hit and run drivers. Our investigative tools include reviewing traffic and surveillance cameras in the area, analyzing debris and paint transfer evidence, canvassing for witnesses, working with law enforcement to obtain dispatch records, and examining nearby businesses' security camera footage. Even partial information — a vehicle description, license plate fragment, or witness sighting — can lead to identification of the at-fault driver.</p>

<h2>Steps to Take After a Hit &amp; Run</h2>
<p>If you are the victim of a hit and run, take these steps immediately: call 911 and report the accident, note any details about the fleeing vehicle (color, make, model, license plate, direction of travel), look for witnesses and ask for their contact information, photograph the scene including damage to your vehicle and any debris left by the fleeing driver, seek medical attention immediately, and contact a hit and run attorney before filing an insurance claim.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I recover compensation if the hit and run driver is never found?',
                'answer'   => 'Yes. If you carry uninsured motorist (UM) coverage on your auto insurance policy, you can file a UM claim to cover your medical bills, lost wages, and pain and suffering — even if the at-fault driver is never identified.',
            ),
            array(
                'question' => 'Is uninsured motorist coverage required in Georgia and South Carolina?',
                'answer'   => 'Georgia requires insurers to offer UM coverage, and it is included unless you explicitly reject it. South Carolina includes UM coverage by default — you must sign a written rejection to opt out.',
            ),
            array(
                'question' => 'What are the criminal penalties for a hit and run in Georgia?',
                'answer'   => 'Under O.C.G.A. § 40-6-270, leaving the scene of an accident with injuries is a felony in Georgia, punishable by 1 to 5 years in prison. If the accident results in death, penalties increase to 3 to 15 years.',
            ),
            array(
                'question' => 'What if I only got a partial license plate number?',
                'answer'   => 'Even partial information can be valuable. Our attorneys work with law enforcement and investigators to cross-reference partial plates, vehicle descriptions, surveillance footage, and debris evidence to identify hit and run drivers.',
            ),
            array(
                'question' => 'How long do I have to file a hit and run accident claim?',
                'answer'   => 'The personal injury statute of limitations is 2 years in Georgia (O.C.G.A. § 9-3-33) and 3 years in South Carolina (S.C. Code § 15-3-530). However, you should report the incident to police and your insurance company immediately.',
            ),
            array(
                'question' => 'Will my insurance rates go up if I file a UM claim after a hit and run?',
                'answer'   => 'Because you are not at fault in a hit and run, filing a UM claim should not increase your premiums. UM coverage exists specifically for situations like these. Your attorney can help you navigate the claims process.',
            ),
        ),
    ),

    /* ============================================================
       5. Distracted Driving Accident
       ============================================================ */
    array(
        'title'   => 'Distracted Driving Accident Lawyers',
        'slug'    => 'distracted-driving-accident',
        'excerpt' => 'Injured by a distracted driver in Georgia or South Carolina? Our attorneys prove phone use and other distractions to hold negligent drivers fully accountable.',
        'content' => <<<'HTML'
<h2>Distracted Driving Accidents in Georgia &amp; South Carolina</h2>
<p>Distracted driving has become one of the leading causes of traffic injuries and deaths across the United States. The <a href="https://www.nhtsa.gov/risky-driving/distracted-driving" target="_blank" rel="noopener">National Highway Traffic Safety Administration (NHTSA)</a> reports that distracted driving claimed 3,308 lives in a single recent year, with an estimated 424,000 people injured in crashes involving a distracted driver. The <a href="https://www.cdc.gov/transportationsafety/distracted-driving/index.html" target="_blank" rel="noopener">Centers for Disease Control and Prevention (CDC)</a> identifies three main types of distraction: visual (taking eyes off the road), manual (taking hands off the wheel), and cognitive (taking your mind off driving). Texting involves all three, making it the most dangerous form of distracted driving.</p>

<h2>Georgia and South Carolina Distracted Driving Laws</h2>
<p>Georgia's Hands-Free Act (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-11/section-40-6-241-2/" target="_blank" rel="noopener">O.C.G.A. § 40-6-241.2</a>), effective July 1, 2018, prohibits drivers from holding or supporting a phone or electronic device while operating a motor vehicle. Drivers may use hands-free technology (Bluetooth, dash-mounted devices), but cannot have any physical contact with the phone while driving. Violations result in fines and points on the driver's license.</p>
<p>South Carolina's distracted driving law (<a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-3890</a>) prohibits texting while driving but is less comprehensive than Georgia's hands-free law. Drivers may still hold their phones for calls, but composing, sending, or reading text messages while driving is illegal. Efforts to pass a broader hands-free law in South Carolina have been ongoing.</p>

<h2>Proving Distracted Driving</h2>
<p>Proving that the at-fault driver was distracted at the moment of the crash is critical to strengthening your case. Our attorneys use multiple evidence sources:</p>
<ul>
<li><strong>Cell phone records:</strong> Subpoenaing the driver's phone records to show calls, texts, or app usage at the time of the crash</li>
<li><strong>Infotainment and vehicle data:</strong> Modern vehicles record data that can show whether a driver was interacting with the touchscreen</li>
<li><strong>Witness testimony:</strong> Other drivers, passengers, or bystanders who observed the driver looking at their phone</li>
<li><strong>Police reports:</strong> Officers often note suspected distracted driving and may cite the driver</li>
<li><strong>Surveillance and dashcam footage:</strong> Cameras may capture the driver's actions before the crash</li>
</ul>

<h2>Injuries Caused by Distracted Driving</h2>
<p>Distracted driving crashes often occur at full speed because the distracted driver fails to brake or take evasive action before impact. This leads to particularly severe injuries including traumatic brain injuries and concussions, spinal cord injuries and paralysis, multiple fractures, internal organ damage, severe lacerations, and wrongful death. NHTSA data shows that sending or reading a text takes your eyes off the road for approximately 5 seconds — at 55 mph, that is the equivalent of driving the length of a football field blindfolded.</p>

<h2>Compensation for Distracted Driving Victims</h2>
<p>Victims of distracted driving accidents are entitled to full compensation for all losses, including current and future medical expenses, rehabilitation and therapy, lost income and diminished earning capacity, pain, suffering, and emotional distress, and loss of enjoyment of life. When a driver's distraction is proven, it strengthens the case for significant non-economic damages and may support punitive damage claims in cases of particularly egregious conduct.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'How do you prove the other driver was distracted?',
                'answer'   => 'We subpoena cell phone records, obtain vehicle infotainment data, review surveillance and dashcam footage, take witness statements, and analyze police reports. Modern smartphones and vehicles generate extensive digital evidence that can prove distraction.',
            ),
            array(
                'question' => 'Is holding a phone while driving illegal in Georgia?',
                'answer'   => 'Yes. Georgia\'s Hands-Free Act (O.C.G.A. § 40-6-241.2) prohibits drivers from holding or physically touching a phone while operating a vehicle. Hands-free devices (Bluetooth, dash mounts) are permitted.',
            ),
            array(
                'question' => 'What about South Carolina\'s distracted driving law?',
                'answer'   => 'South Carolina law (S.C. Code § 56-5-3890) prohibits texting while driving but still allows drivers to hold their phone for calls. The law is narrower than Georgia\'s hands-free law.',
            ),
            array(
                'question' => 'Can I recover punitive damages from a distracted driver?',
                'answer'   => 'Possibly. If the driver\'s conduct was particularly egregious — such as watching a video or actively texting at high speed — a court may award punitive damages to punish the reckless behavior.',
            ),
            array(
                'question' => 'What if the distracted driver was using a work phone or driving for their employer?',
                'answer'   => 'If the driver was distracted while performing work duties, their employer may also be liable under respondeat superior. This can significantly increase the available insurance coverage and compensation.',
            ),
            array(
                'question' => 'How common are distracted driving accidents?',
                'answer'   => 'NHTSA reports that approximately 424,000 people are injured and over 3,000 are killed annually in distracted driving crashes. The CDC identifies texting as the most dangerous form of distraction.',
            ),
        ),
    ),

    /* ============================================================
       6. Wrong-Way Driver Accident
       ============================================================ */
    array(
        'title'   => 'Wrong-Way Driver Accident Lawyers',
        'slug'    => 'wrong-way-driver-accident',
        'excerpt' => 'Injured in a wrong-way driver crash? These devastating head-on collisions cause catastrophic injuries. Our attorneys pursue maximum compensation from all liable parties.',
        'content' => <<<'HTML'
<h2>Wrong-Way Driver Accidents: Catastrophic Collisions</h2>
<p>Wrong-way driving accidents are among the most dangerous crashes on the road. When a vehicle travels in the wrong direction on a highway, divided road, or one-way street, the resulting head-on collision occurs at combined speeds that frequently exceed 100 mph. The <a href="https://www.fhwa.dot.gov/research/" target="_blank" rel="noopener">Federal Highway Administration (FHWA)</a> reports that wrong-way crashes account for approximately 3% of all highway fatalities but are disproportionately deadly — nearly 60% of wrong-way crashes result in fatalities, compared to about 1% of all crashes overall.</p>
<p>The <a href="https://www.ntsb.gov/" target="_blank" rel="noopener">National Transportation Safety Board (NTSB)</a> has studied wrong-way driving extensively and identified alcohol impairment as a factor in approximately 60% of wrong-way fatal crashes. Our attorneys at Roden Law have the experience and resources to investigate these complex, high-stakes cases and pursue maximum compensation for victims and their families.</p>

<h2>Common Causes of Wrong-Way Driving</h2>
<p>Wrong-way crashes typically involve one or more of the following factors:</p>
<ul>
<li><strong>Alcohol or drug impairment:</strong> The single largest contributing factor, present in roughly 60% of fatal wrong-way crashes</li>
<li><strong>Confused or elderly drivers:</strong> Poor visibility, unfamiliar roads, and cognitive impairment contribute to wrong-way entries</li>
<li><strong>Inadequate signage:</strong> Missing, damaged, or poorly visible "Wrong Way" and "Do Not Enter" signs, inconsistent with <a href="https://mutcd.fhwa.dot.gov/" target="_blank" rel="noopener">MUTCD standards</a></li>
<li><strong>Confusing road design:</strong> Complex interchanges, poorly lit ramps, and missing pavement markings</li>
<li><strong>Distracted or fatigued driving:</strong> Drivers who miss directional signs while impaired by fatigue or electronic distractions</li>
</ul>

<h2>Government Liability in Wrong-Way Accidents</h2>
<p>When wrong-way accidents result from inadequate signage, confusing road design, or missing safety countermeasures, government entities responsible for road maintenance may bear liability. The Federal Highway Administration's Manual on Uniform Traffic Control Devices (MUTCD) establishes minimum standards for "Wrong Way" and "Do Not Enter" signs, including size, reflectivity, and placement requirements. When state or local transportation departments fail to install or maintain these signs in compliance with federal standards, they may be liable for resulting crashes.</p>
<p>Georgia and South Carolina Departments of Transportation (GA DOT and SCDOT) are responsible for maintaining state highways and interstates. Both states have tort claims procedures that allow injury victims to file claims against the government, subject to specific notice requirements and damage limitations.</p>

<h2>Injuries in Wrong-Way Collisions</h2>
<p>The extreme forces involved in head-on wrong-way collisions produce catastrophic injuries. Victims commonly suffer traumatic brain injuries, spinal cord injuries and paralysis, multiple bone fractures, crushing injuries to the chest and abdomen, severe burns from post-crash fires, and wrongful death. Survivors of wrong-way crashes frequently face lifetime medical needs, permanent disabilities, and the inability to return to work.</p>

<h2>Pursuing Maximum Compensation</h2>
<p>Wrong-way driver cases often involve multiple liable parties and substantial damages. Our attorneys pursue claims against the wrong-way driver and their insurer, dram shops or establishments that served alcohol, government entities responsible for road safety, and vehicle manufacturers if mechanical failure contributed. We work with accident reconstruction experts, medical specialists, and life care planners to document the full extent of current and future damages. Given the catastrophic nature of these injuries, case values can be substantial.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Why are wrong-way accidents so deadly?',
                'answer'   => 'Wrong-way crashes typically involve head-on collisions at combined highway speeds often exceeding 100 mph. FHWA data shows nearly 60% of wrong-way crashes result in fatalities, compared to about 1% for all crashes overall.',
            ),
            array(
                'question' => 'Can I sue the government if poor signage caused a wrong-way crash?',
                'answer'   => 'Yes. If a government entity failed to maintain proper "Wrong Way" or "Do Not Enter" signage in compliance with MUTCD standards, they may be liable. Both Georgia and South Carolina have tort claims procedures for suing government entities.',
            ),
            array(
                'question' => 'What causes most wrong-way driving accidents?',
                'answer'   => 'Alcohol or drug impairment is the leading cause, present in approximately 60% of fatal wrong-way crashes according to the NTSB. Other causes include confused or elderly drivers, inadequate signage, and confusing road design.',
            ),
            array(
                'question' => 'What types of compensation are available in wrong-way crash cases?',
                'answer'   => 'Victims may recover medical expenses, lost wages, pain and suffering, disability and disfigurement damages, loss of enjoyment of life, and potentially punitive damages. Wrongful death claims are also available for surviving family members.',
            ),
            array(
                'question' => 'How do you investigate a wrong-way accident case?',
                'answer'   => 'We retain accident reconstruction experts, obtain toxicology results, review road design and signage compliance with MUTCD standards, analyze surveillance footage, and examine vehicle data recorders to establish all sources of liability.',
            ),
        ),
    ),

    /* ============================================================
       7. Commercial Vehicle Accident
       ============================================================ */
    array(
        'title'   => 'Commercial Vehicle Accident Lawyers',
        'slug'    => 'commercial-vehicle-accident',
        'excerpt' => 'Injured in a crash with a commercial vehicle? Our attorneys handle claims involving delivery trucks, company cars, fleet vehicles, and employer liability.',
        'content' => <<<'HTML'
<h2>Commercial Vehicle Accident Claims</h2>
<p>Commercial vehicle accidents encompass a broad category of crashes involving vehicles operated for business purposes — including delivery vans, company cars, service trucks, government vehicles, and other fleet vehicles. While these cases share some similarities with standard car accident claims, they involve additional layers of liability, insurance coverage, and regulatory compliance that require experienced legal representation.</p>
<p>The <a href="https://www.fmcsa.dot.gov/" target="_blank" rel="noopener">Federal Motor Carrier Safety Administration (FMCSA)</a> regulates vehicles exceeding 10,001 pounds gross vehicle weight rating, but many commercial vehicles fall below this threshold and are governed primarily by state traffic laws and employer liability principles. Regardless of vehicle size, when a driver causes an accident while performing work duties, their employer may be vicariously liable for the resulting injuries.</p>

<h2>Types of Commercial Vehicle Accidents</h2>
<p>Our attorneys handle the full spectrum of commercial vehicle crash claims:</p>
<ul>
<li><strong>Delivery vehicle accidents:</strong> Amazon, FedEx, UPS, USPS, and food delivery drivers operating on tight schedules</li>
<li><strong>Company car accidents:</strong> Employees driving company-owned or leased vehicles during work duties</li>
<li><strong>Service and utility vehicle crashes:</strong> Plumbers, electricians, landscapers, and other service providers</li>
<li><strong>Government vehicle accidents:</strong> Federal, state, and local government employees driving official vehicles</li>
<li><strong>Construction vehicle accidents:</strong> Dump trucks, cement mixers, and other construction equipment on public roads</li>
<li><strong>Bus accidents:</strong> Private shuttle buses, charter buses, and hotel courtesy vehicles</li>
</ul>

<h2>Employer Liability: Respondeat Superior</h2>
<p>Under the legal doctrine of respondeat superior, employers are vicariously liable for the negligent acts of their employees committed within the scope of employment. This means that when a delivery driver, sales representative, or service technician causes an accident while performing work duties, the employer — and its commercial insurance policy — can be held liable for the victim's injuries.</p>
<p>Employer liability may also extend to claims of negligent hiring, negligent training, negligent supervision, and negligent entrustment. If the employer knew or should have known that the driver had a poor driving record, history of violations, or was unqualified to operate the vehicle, the employer may be directly liable for placing a dangerous driver on the road.</p>

<h2>FMCSA &amp; OSHA Regulations</h2>
<p>Commercial vehicles exceeding 10,001 pounds or transporting hazardous materials must comply with FMCSA regulations, including hours of service limits, vehicle maintenance requirements, and driver qualification standards. The <a href="https://www.osha.gov/" target="_blank" rel="noopener">Occupational Safety and Health Administration (OSHA)</a> also establishes workplace safety standards that may apply to employer vehicle operation policies. Violations of these federal regulations are powerful evidence of negligence in commercial vehicle accident cases.</p>

<h2>Insurance Coverage in Commercial Vehicle Cases</h2>
<p>Commercial vehicles typically carry significantly higher insurance limits than personal vehicles. Federal minimum requirements for motor carriers range from $750,000 to $5 million depending on cargo type. Even commercial vehicles not subject to federal minimums often carry substantial commercial auto insurance policies. Our attorneys identify all available coverage sources — including the driver's personal policy, the employer's commercial policy, umbrella or excess policies, and any third-party liability coverage — to maximize your recovery.</p>

<h2>Building a Strong Commercial Vehicle Accident Case</h2>
<p>Our investigation into commercial vehicle accidents includes obtaining the driver's employment records and driving history, reviewing the employer's hiring, training, and supervision practices, examining vehicle maintenance logs and inspection reports, analyzing GPS and telematics data from the commercial vehicle, reviewing hours of service logs for fatigue-related factors, and consulting with industry and safety experts to establish regulatory violations.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue the employer if their employee caused my accident?',
                'answer'   => 'Yes. Under the doctrine of respondeat superior, employers are vicariously liable for accidents caused by employees acting within the scope of their employment. The employer\'s commercial insurance policy typically provides substantially higher coverage limits.',
            ),
            array(
                'question' => 'What is the difference between a commercial vehicle and a semi-truck case?',
                'answer'   => 'Semi-truck cases involve tractor-trailers exceeding 10,001 pounds and subject to extensive FMCSA regulations. Commercial vehicle cases cover a broader category including delivery vans, company cars, and service vehicles that may not fall under federal motor carrier regulations.',
            ),
            array(
                'question' => 'What if the commercial driver was an independent contractor, not an employee?',
                'answer'   => 'Even when companies classify drivers as independent contractors, courts examine the actual level of control the company exercises. If the company controls the manner of work (routes, schedules, equipment), the driver may be deemed an employee for liability purposes.',
            ),
            array(
                'question' => 'How much insurance do commercial vehicles carry?',
                'answer'   => 'Commercial vehicles often carry substantially higher insurance limits than personal vehicles. Federally regulated carriers must maintain $750,000 to $5 million in coverage depending on cargo type. Many commercial policies carry $1 million or more.',
            ),
            array(
                'question' => 'What if a government vehicle caused my accident?',
                'answer'   => 'You may file a claim against the government entity, but strict notice requirements and shorter filing deadlines apply. In Georgia, you must provide ante litem notice before suing. South Carolina has its own tort claims act with specific procedures.',
            ),
            array(
                'question' => 'Does my claim change if the driver was using a personal vehicle for work?',
                'answer'   => 'The employer can still be liable if the driver was performing work duties. Both the driver\'s personal insurance and the employer\'s coverage may apply. This is common with employees using personal vehicles for deliveries, sales calls, or work errands.',
            ),
        ),
    ),

    /* ============================================================
       8. Multi-Vehicle Pileup
       ============================================================ */
    array(
        'title'   => 'Multi-Vehicle Pileup Lawyers',
        'slug'    => 'multi-vehicle-pileup',
        'excerpt' => 'Injured in a multi-vehicle pileup on a Georgia or South Carolina highway? Our attorneys untangle complex liability and pursue every available source of compensation.',
        'content' => <<<'HTML'
<h2>Multi-Vehicle Pileup Accidents in Georgia &amp; South Carolina</h2>
<p>Multi-vehicle pileup accidents — also called chain-reaction crashes — are among the most complex and devastating types of car accidents. These crashes frequently occur on interstates like I-95, I-16, I-26, and I-77 in Georgia and South Carolina, often during adverse weather conditions. According to the <a href="https://www.nhtsa.gov/" target="_blank" rel="noopener">National Highway Traffic Safety Administration (NHTSA)</a>, multi-vehicle crashes involve three or more vehicles and frequently result in severe injuries, fatalities, and massive property damage.</p>
<p>The <a href="https://www.fhwa.dot.gov/research/topics/weather/" target="_blank" rel="noopener">Federal Highway Administration (FHWA)</a> reports that weather-related crashes cause approximately 5,000 deaths and 418,000 injuries annually. Fog, rain, ice, and smoke from agricultural burns are common triggers for multi-vehicle pileups in the Southeast. Georgia DOT and SCDOT both maintain weather monitoring and advisory systems, but dangerous conditions can develop rapidly.</p>

<h2>What Causes Multi-Vehicle Pileups?</h2>
<p>Multi-vehicle pileups typically begin with an initial collision that triggers a chain reaction as following vehicles cannot stop in time. Contributing factors include:</p>
<ul>
<li><strong>Dense fog and low visibility:</strong> Particularly dangerous along coastal Georgia and Lowcountry South Carolina roads</li>
<li><strong>Heavy rain and hydroplaning:</strong> Water accumulation on roadways reduces tire traction</li>
<li><strong>Ice and black ice:</strong> Bridges and overpasses freeze before roadways, catching drivers off guard</li>
<li><strong>Smoke from brush fires or agricultural burns:</strong> Sudden visibility reduction on rural highways</li>
<li><strong>Tailgating and speeding:</strong> Insufficient following distance makes it impossible to stop when traffic slows</li>
<li><strong>Distracted driving:</strong> Drivers not paying attention fail to notice stopped traffic ahead</li>
</ul>

<h2>Determining Liability in Multi-Vehicle Crashes</h2>
<p>Liability in multi-vehicle pileup cases is inherently complex. Multiple drivers may share fault, and determining the sequence of impacts — which collisions were primary and which were secondary — is critical. Our attorneys work with accident reconstruction experts who analyze physical evidence, vehicle damage patterns, event data recorder (black box) data, skid marks, and witness statements to establish the chain of causation.</p>
<p>Under Georgia's comparative fault rule (O.C.G.A. § 51-12-33), each party's liability is apportioned based on their percentage of fault. You can recover damages as long as your fault is less than 50%. South Carolina applies a similar rule, allowing recovery if your fault is less than 51%. In pileup cases, fault may be distributed among many drivers, which can actually benefit victims — even if one driver has minimal insurance, other at-fault drivers and their insurers may be liable for additional compensation.</p>

<h2>Multiple Insurance Policies and Stacking</h2>
<p>One advantage in multi-vehicle pileup cases is the availability of multiple insurance policies. When several at-fault drivers are identified, each driver's liability insurance may contribute to the victim's recovery. Additionally, if the at-fault drivers' coverage is insufficient, your own uninsured/underinsured motorist (UM/UIM) coverage may supplement the recovery. Our attorneys identify and pursue every available insurance policy to maximize total compensation.</p>

<h2>Government Liability in Pileup Cases</h2>
<p>Government entities may bear liability when pileups result from hazardous road conditions that could have been mitigated. <a href="https://www.dot.ga.gov/" target="_blank" rel="noopener">Georgia DOT</a> and <a href="https://www.scdot.org/" target="_blank" rel="noopener">SCDOT</a> have duties to maintain safe roadways, install adequate warning systems, and respond to weather emergencies. Failure to post fog warnings, clear debris, treat icy bridges, or close roads during dangerous conditions may establish government liability.</p>

<h2>Serious Injuries in Pileup Crashes</h2>
<p>Pileup victims often suffer multiple impacts from different directions, compounding the severity of injuries. Common injuries include traumatic brain injuries from multiple impact forces, spinal cord injuries, crush injuries to limbs and torso, severe burns from vehicle fires, internal organ damage, and psychological trauma including PTSD. Victims caught in the middle of a pileup may be struck from the front, rear, and sides simultaneously, leading to complex, multi-system injuries that require extensive medical care.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'How is fault determined in a multi-vehicle pileup?',
                'answer'   => 'Accident reconstruction experts analyze vehicle damage patterns, event data recorders, skid marks, and witness statements to establish the sequence of impacts and each driver\'s degree of fault. Multiple drivers often share liability.',
            ),
            array(
                'question' => 'Can I recover damages if I am partially at fault in a pileup?',
                'answer'   => 'Yes. Georgia allows recovery if you are less than 50% at fault (O.C.G.A. § 51-12-33), and South Carolina allows recovery if less than 51% at fault. Your compensation is reduced by your percentage of fault.',
            ),
            array(
                'question' => 'What if multiple drivers caused the pileup?',
                'answer'   => 'You can pursue claims against all at-fault drivers simultaneously. Multiple insurance policies may apply, which can increase the total compensation available for your injuries.',
            ),
            array(
                'question' => 'Can the government be liable for a pileup caused by road conditions?',
                'answer'   => 'Yes. If Georgia DOT or SCDOT failed to maintain safe conditions — such as not posting fog warnings, treating icy bridges, or clearing debris — they may be liable. Government claims have strict notice and filing requirements.',
            ),
            array(
                'question' => 'What evidence is important in a pileup case?',
                'answer'   => 'Critical evidence includes police reports, photos and videos from the scene, event data recorder (black box) information, weather data, witness statements, and accident reconstruction analysis. Preserving evidence quickly is essential.',
            ),
            array(
                'question' => 'How long do multi-vehicle pileup cases take to resolve?',
                'answer'   => 'Pileup cases are complex due to multiple parties and insurers involved. They typically take longer than standard car accident cases. Our attorneys work to resolve cases as efficiently as possible while ensuring you receive full compensation.',
            ),
            array(
                'question' => 'What if I was stopped in traffic when I was hit from behind in a pileup?',
                'answer'   => 'If you were lawfully stopped or moving with traffic when rear-ended, you likely bear no fault. The driver who struck you — and potentially other following drivers — would be liable for your injuries.',
            ),
        ),
    ),

); // end $subtypes array

/* ------------------------------------------------------------------
   INSERT POSTS
   ------------------------------------------------------------------ */

$created = 0;
$skipped = 0;

foreach ( $subtypes as $sub ) {
    // Check if slug already exists under this parent.
    $existing = get_posts( array(
        'post_type'   => $pillar_type,
        'name'        => $sub['slug'],
        'post_parent' => $pillar_id,
        'post_status' => array( 'publish', 'draft', 'pending', 'private', 'trash' ),
        'numberposts' => 1,
    ) );

    if ( ! empty( $existing ) ) {
        WP_CLI::log( "  SKIP: \"{$sub['title']}\" already exists (ID {$existing[0]->ID})" );
        $skipped++;
        continue;
    }

    $post_id = wp_insert_post( array(
        'post_type'    => $pillar_type,
        'post_title'   => wp_strip_all_tags( html_entity_decode( $sub['title'], ENT_QUOTES, 'UTF-8' ) ),
        'post_name'    => $sub['slug'],
        'post_content' => $sub['content'],
        'post_excerpt' => $sub['excerpt'],
        'post_status'  => 'publish',
        'post_parent'  => $pillar_id,
        'post_author'  => 1,
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "  FAIL: \"{$sub['title']}\" — " . $post_id->get_error_message() );
        continue;
    }

    // Meta fields.
    update_post_meta( $post_id, '_roden_jurisdiction', 'both' );
    update_post_meta( $post_id, '_roden_sol_ga', 'O.C.G.A. § 9-3-33' );
    update_post_meta( $post_id, '_roden_sol_sc', 'S.C. Code § 15-3-530' );
    update_post_meta( $post_id, '_roden_faqs', $sub['faqs'] );

    if ( $author_attorney_id ) {
        update_post_meta( $post_id, '_roden_author_attorney', $author_attorney_id );
    }

    // Taxonomy.
    if ( $cat_term_id ) {
        wp_set_object_terms( $post_id, (int) $cat_term_id, 'practice_category' );
    }

    WP_CLI::success( "  CREATED: \"{$sub['title']}\" (ID {$post_id})" );
    $created++;
}

WP_CLI::log( '' );
WP_CLI::success( "Done. Created: {$created}, Skipped: {$skipped}" );
WP_CLI::log( 'Run: wp rewrite flush' );
