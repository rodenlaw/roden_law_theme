<?php
/**
 * Seeder: 8 Pedestrian Accident Sub-Type Pages
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-pedestrian-accident-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: pedestrian-accident-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'pedestrian-accident-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'pedestrian-accident-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "pedestrian-accident-lawyers" not found.' );
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

$cat_term = term_exists( 'pedestrian-accidents', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Pedestrian Accidents', 'practice_category', array( 'slug' => 'pedestrian-accidents' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Crosswalk Accidents
       ============================================================ */
    array(
        'title'   => 'Crosswalk Accident Lawyers',
        'slug'    => 'crosswalk-accident',
        'excerpt' => 'Struck by a vehicle in a crosswalk? Drivers have a legal duty to yield to pedestrians in crosswalks. Our attorneys fight for maximum compensation when negligent drivers injure pedestrians at marked and unmarked crossings.',
        'content' => <<<'HTML'
<h2>Crosswalk Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Crosswalks are supposed to be the safest place for a pedestrian to cross the street — yet thousands of pedestrians are injured or killed in crosswalks every year. When a driver fails to yield to a pedestrian in a crosswalk, the consequences are devastating. The <a href="https://www.nhtsa.gov/road-safety/pedestrian-safety" target="_blank" rel="noopener">NHTSA</a> reports that over 7,500 pedestrians were killed in traffic crashes in a recent year, with a significant portion of those fatalities occurring at or near crosswalks and intersections.</p>
<p>At Roden Law, our crosswalk accident lawyers represent injured pedestrians throughout Georgia and South Carolina. We understand the specific traffic laws that protect pedestrians at crossings and hold negligent drivers fully accountable for the harm they cause.</p>

<h2>Pedestrian Right-of-Way Laws at Crosswalks</h2>
<p>Both Georgia and South Carolina have clear laws requiring drivers to yield to pedestrians in crosswalks:</p>
<ul>
<li><strong>Georgia:</strong> Under <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-5/section-40-6-91/" target="_blank" rel="noopener">O.C.G.A. § 40-6-91</a>, drivers must stop and remain stopped to allow a pedestrian to cross when the pedestrian is in the driver's half of the roadway or close enough to be in danger. This applies to both marked and unmarked crosswalks.</li>
<li><strong>South Carolina:</strong> <a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-3130</a> requires drivers to yield the right of way to pedestrians within any marked crosswalk or unmarked crosswalk at an intersection.</li>
</ul>
<p>Importantly, both states recognize <strong>unmarked crosswalks</strong> — the implied extensions of sidewalks across intersections, even when there are no painted lines. Drivers must yield to pedestrians at these unmarked crossings as well.</p>

<h2>Common Causes of Crosswalk Accidents</h2>
<p>Our investigation of crosswalk accidents consistently reveals driver negligence:</p>
<ul>
<li><strong>Failure to yield:</strong> The most common cause — drivers who do not stop for pedestrians in the crosswalk, often because they are in a hurry or simply not paying attention</li>
<li><strong>Right-turn-on-red violations:</strong> Drivers making a right turn on red who focus on oncoming traffic and fail to check the crosswalk for pedestrians</li>
<li><strong>Left-turn inattention:</strong> Drivers completing left turns who are focused on gaps in traffic and overlook pedestrians in the crosswalk</li>
<li><strong>Distracted driving:</strong> Texting or phone use that prevents drivers from seeing pedestrians entering the crosswalk</li>
<li><strong>Speeding through yellow lights:</strong> Drivers who accelerate through yellow or early-red signals while pedestrians are beginning to cross</li>
<li><strong>Poor visibility:</strong> Inadequate lighting at crosswalks, especially at night, combined with driver failure to reduce speed in low-visibility conditions</li>
</ul>

<h2>Injuries in Crosswalk Accidents</h2>
<p>Pedestrians have no protection when struck by a vehicle, making crosswalk accidents especially injurious. Common injuries include traumatic brain injuries, spinal cord injuries, multiple bone fractures (pelvis, legs, arms), internal organ damage, severe road rash and lacerations, and wrongful death. The severity of injuries increases dramatically with vehicle speed — a pedestrian struck at 40 mph has an approximately 85% chance of death, compared to 10% at 20 mph.</p>

<h2>Pursuing Maximum Compensation</h2>
<p>Crosswalk accident cases typically present strong liability because drivers have a clear legal duty to yield. Our attorneys document the crosswalk conditions, traffic signals, driver behavior, and all injuries to build comprehensive claims. We pursue all available damages under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/" target="_blank" rel="noopener">O.C.G.A. Title 51</a>) and South Carolina law, including medical expenses, lost wages, pain and suffering, permanent disability, and wrongful death claims for surviving family members.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Do drivers have to stop for pedestrians in crosswalks in Georgia?',
                'answer'   => 'Yes. Georgia law (O.C.G.A. § 40-6-91) requires drivers to stop and remain stopped for pedestrians in their half of the roadway or close enough to be in danger. This applies to both marked crosswalks (painted lines) and unmarked crosswalks (the implied crossing at intersections).',
            ),
            array(
                'question' => 'What is an unmarked crosswalk?',
                'answer'   => 'An unmarked crosswalk is the implied extension of a sidewalk across an intersection, even when there are no painted crosswalk lines. Both Georgia and South Carolina law recognize unmarked crosswalks and require drivers to yield to pedestrians within them.',
            ),
            array(
                'question' => 'What if I was jaywalking — can I still recover damages?',
                'answer'   => 'Potentially, yes. Both Georgia and South Carolina use comparative fault rules. Even if you were crossing outside a crosswalk, you may recover damages if the driver was also negligent (speeding, distracted, etc.) and your fault was less than 50% (GA) or 51% (SC).',
            ),
            array(
                'question' => 'What compensation can I recover after a crosswalk accident?',
                'answer'   => 'Victims can recover medical expenses, lost wages, pain and suffering, permanent disability, disfigurement, loss of enjoyment of life, and property damage. Wrongful death claims allow surviving family members to recover funeral expenses, lost financial support, and loss of companionship.',
            ),
            array(
                'question' => 'How long do I have to file a crosswalk accident claim?',
                'answer'   => 'Georgia has a 2-year statute of limitations (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). However, acting quickly preserves critical evidence like surveillance footage, which is often overwritten within days or weeks.',
            ),
        ),
    ),

    /* ============================================================
       2. Intersection Pedestrian Accidents
       ============================================================ */
    array(
        'title'   => 'Intersection Pedestrian Accident Lawyers',
        'slug'    => 'intersection-pedestrian-accident',
        'excerpt' => 'Injured as a pedestrian at an intersection? Right-of-way violations, turning vehicles, and red-light runners cause devastating pedestrian injuries. Our attorneys pursue full compensation from negligent drivers.',
        'content' => <<<'HTML'
<h2>Intersection Pedestrian Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Intersections are the most dangerous locations for pedestrians. The complex interaction of turning vehicles, through-traffic, traffic signals, and pedestrian crossings creates numerous conflict points where a momentary lapse in attention can have catastrophic consequences. According to the <a href="https://www.nhtsa.gov/road-safety/pedestrian-safety" target="_blank" rel="noopener">NHTSA</a>, a significant percentage of pedestrian fatalities occur at or near intersections, where turning vehicles and right-of-way confusion pose the greatest risks.</p>
<p>At Roden Law, our pedestrian accident lawyers handle intersection crash cases throughout Georgia and South Carolina. We investigate the specific circumstances of each collision — signal timing, turning movements, sight lines, and driver behavior — to establish clear liability and pursue maximum compensation.</p>

<h2>How Intersection Pedestrian Accidents Happen</h2>
<p>Intersection pedestrian crashes occur in several common patterns:</p>
<ul>
<li><strong>Left-turning vehicles:</strong> Drivers focused on finding gaps in oncoming traffic often fail to check the crosswalk for pedestrians before completing their turn. This is the leading cause of intersection pedestrian crashes.</li>
<li><strong>Right-turning vehicles:</strong> Drivers turning right on green or right on red frequently look left for oncoming traffic and fail to look right where pedestrians are crossing</li>
<li><strong>Red-light runners:</strong> Drivers who enter the intersection after the signal has changed, striking pedestrians who have begun crossing on their walk signal</li>
<li><strong>Permissive left turns:</strong> At intersections without a protected left-turn signal, drivers turning left may not see a pedestrian entering the crosswalk</li>
<li><strong>Multiple-threat scenarios:</strong> A vehicle in one lane stops for a pedestrian, but a vehicle in the adjacent lane passes and strikes the pedestrian they cannot see</li>
<li><strong>Channelized right turns:</strong> High-speed right-turn lanes that encourage drivers to focus on merging rather than watching for pedestrians</li>
</ul>

<h2>Intersection Design and Government Liability</h2>
<p>Poor intersection design can significantly increase pedestrian crash risk. Factors include inadequate pedestrian signal timing (not enough time to cross), missing or faded crosswalk markings, lack of pedestrian refuge islands on wide roads, absence of leading pedestrian intervals (giving walkers a head start before vehicles get a green), and poor sight lines due to vegetation, signage, or parked vehicles.</p>
<p>When deficient intersection design contributes to a pedestrian crash, the government entity responsible for the intersection may share liability. Georgia's Tort Claims Act (<a href="https://law.justia.com/codes/georgia/title-50/chapter-21/" target="_blank" rel="noopener">O.C.G.A. § 50-21-20 et seq.</a>) and South Carolina's Tort Claims Act (<a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">S.C. Code § 15-78-10 et seq.</a>) allow negligence claims against government entities for dangerous road conditions, subject to specific notice requirements.</p>

<h2>Proving Liability at Intersections</h2>
<p>Our attorneys use every available tool to establish fault in intersection pedestrian cases:</p>
<ul>
<li><strong>Traffic camera footage:</strong> Many Georgia and South Carolina intersections have cameras that capture signal timing and vehicle movements</li>
<li><strong>Pedestrian signal data:</strong> Records showing whether the walk signal was active when the pedestrian entered the crosswalk</li>
<li><strong>Witness testimony:</strong> Other drivers, passengers, and pedestrians who observed the crash</li>
<li><strong>Accident reconstruction:</strong> Expert analysis of vehicle speed, pedestrian position, and driver sight lines</li>
</ul>
<p>Both Georgia (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-5/section-40-6-91/" target="_blank" rel="noopener">O.C.G.A. § 40-6-91</a>) and South Carolina law require drivers to yield to pedestrians in crosswalks. Violating these statutes creates a strong presumption of negligence in the driver.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What types of intersection crashes are most dangerous for pedestrians?',
                'answer'   => 'Left-turning vehicles are the most common cause of intersection pedestrian crashes — drivers focus on gaps in oncoming traffic and fail to see pedestrians in the crosswalk. Right-turn-on-red crashes and red-light runners are also leading causes of serious pedestrian injuries at intersections.',
            ),
            array(
                'question' => 'Can poor intersection design contribute to pedestrian accidents?',
                'answer'   => 'Yes. Inadequate crossing time, missing crosswalk markings, lack of pedestrian signals, poor sight lines, and high-speed turning lanes all increase pedestrian crash risk. The government entity responsible for intersection design may share liability under state tort claims acts.',
            ),
            array(
                'question' => 'Who has the right of way at an intersection — the pedestrian or the car?',
                'answer'   => 'Pedestrians in a crosswalk (marked or unmarked) generally have the right of way, and drivers must yield. However, pedestrians must also obey traffic signals and not suddenly enter the roadway when a vehicle cannot stop. Both parties have duties, but the driver of a 4,000-pound vehicle bears greater responsibility.',
            ),
            array(
                'question' => 'What is a "multiple-threat" pedestrian crash?',
                'answer'   => 'A multiple-threat crash occurs when one vehicle stops for a pedestrian, but a vehicle in an adjacent lane passes the stopped car and strikes the pedestrian it cannot see. These crashes are common on multi-lane roads and are a major argument for better intersection design.',
            ),
            array(
                'question' => 'What should I do after being hit by a car at an intersection?',
                'answer'   => 'Call 911, seek immediate medical attention, and do not refuse an ambulance. If possible, note the walk signal status, photograph the scene, and get witness contact information. Do not give recorded statements to the driver\'s insurance company before consulting an attorney.',
            ),
        ),
    ),

    /* ============================================================
       3. Hit & Run Pedestrian Accidents
       ============================================================ */
    array(
        'title'   => 'Hit &amp; Run Pedestrian Accident Lawyers',
        'slug'    => 'hit-and-run-pedestrian-accident',
        'excerpt' => 'Victim of a pedestrian hit and run? Even when the driver flees, you may have options for compensation. Our attorneys pursue every avenue of recovery for hit-and-run pedestrian victims.',
        'content' => <<<'HTML'
<h2>Hit &amp; Run Pedestrian Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Being struck by a vehicle as a pedestrian is terrifying — but when the driver flees the scene, leaving you injured and stranded, the trauma is compounded by helplessness and injustice. Hit-and-run pedestrian crashes are tragically common and disproportionately deadly. The <a href="https://www.aaafoundation.org/" target="_blank" rel="noopener">AAA Foundation for Traffic Safety</a> reports that hit-and-run crashes account for approximately 24% of all pedestrian fatalities — nearly one in four. Drivers flee for many reasons, including intoxication, lack of insurance, outstanding warrants, or simple panic.</p>
<p>At Roden Law, our hit-and-run pedestrian accident lawyers help victims and families identify every possible source of compensation and work with law enforcement to track down fleeing drivers. Even when the driver is never found, we pursue all available insurance coverage and legal options.</p>

<h2>Hit-and-Run Criminal Penalties in Georgia and South Carolina</h2>
<p>Both states treat hit-and-run involving pedestrian injuries as a serious criminal offense:</p>
<ul>
<li><strong>Georgia:</strong> <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/section-40-6-270/" target="_blank" rel="noopener">O.C.G.A. § 40-6-270</a> makes leaving the scene of an accident involving injury or death a felony punishable by 1-5 years in prison. The driver must stop, provide information, and render reasonable assistance to any injured person.</li>
<li><strong>South Carolina:</strong> <a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-1210</a> imposes up to 10 years for hit-and-run involving injury and up to 25 years for fatality. Fines up to $10,000 also apply.</li>
</ul>

<h2>Sources of Compensation for Hit-and-Run Pedestrian Victims</h2>
<p>Even when the at-fault driver is unknown, pedestrian victims have several potential sources of recovery:</p>
<ul>
<li><strong>Uninsured Motorist (UM) coverage:</strong> If you or a household family member has an auto insurance policy with UM coverage, it can cover a hit-and-run pedestrian crash. South Carolina requires UM coverage in all policies unless rejected in writing. Georgia requires insurers to offer it.</li>
<li><strong>Household auto policies:</strong> You may be covered as a pedestrian under a spouse's, parent's, or household member's auto policy UM coverage</li>
<li><strong>Medical Payments (MedPay) coverage:</strong> Covers medical expenses regardless of fault under your own auto policy</li>
<li><strong>Health insurance:</strong> Your personal health plan covers treatment, subject to subrogation</li>
<li><strong>Georgia Crime Victims Compensation:</strong> The <a href="https://cjcc.georgia.gov/victims/crime-victims-compensation" target="_blank" rel="noopener">Georgia Criminal Justice Coordinating Council</a> offers compensation for crime victims, including hit-and-run victims</li>
<li><strong>South Carolina Crime Victims' Fund:</strong> South Carolina's State Office of Victim Assistance provides similar compensation for qualifying victims</li>
</ul>

<h2>Finding the Driver</h2>
<p>Our attorneys work to identify the fleeing driver through surveillance camera footage from nearby businesses and traffic cameras, vehicle debris and paint transfer analysis, witness canvassing, community tips and social media, and body shop and repair records for vehicles matching the description. When the driver is found, we pursue direct claims against them and their liability insurance, in addition to any UM claims already underway.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I recover compensation as a pedestrian hit-and-run victim if the driver is never found?',
                'answer'   => 'Yes. If you or a household family member has auto insurance with Uninsured Motorist (UM) coverage, it can cover hit-and-run pedestrian injuries even when the driver is never identified. South Carolina requires UM coverage in all policies. Both states also have crime victim compensation programs.',
            ),
            array(
                'question' => 'Does auto insurance cover me as a pedestrian?',
                'answer'   => 'Yes. Your auto policy\'s Uninsured Motorist (UM) and Medical Payments (MedPay) coverages can protect you even when you are a pedestrian, not driving. You may also be covered under a household family member\'s policy. Check your policy or ask your insurance agent.',
            ),
            array(
                'question' => 'What percentage of pedestrian deaths involve hit-and-run drivers?',
                'answer'   => 'Approximately 24% of pedestrian fatalities involve hit-and-run drivers — nearly one in four, according to the AAA Foundation for Traffic Safety. Hit-and-run pedestrian crashes are disproportionately deadly because victims may not receive timely medical attention.',
            ),
            array(
                'question' => 'What should I do immediately after a pedestrian hit-and-run?',
                'answer'   => 'Call 911 immediately. Try to remember any details about the vehicle — make, model, color, license plate, direction of travel. Ask bystanders if they saw anything or got the plate. Look for nearby security cameras. Seek medical attention even if injuries seem minor, and contact an attorney promptly.',
            ),
            array(
                'question' => 'Is leaving the scene after hitting a pedestrian a felony?',
                'answer'   => 'Yes, in both states. Georgia makes it a felony punishable by 1-5 years (O.C.G.A. § 40-6-270). South Carolina imposes up to 10 years for injury and up to 25 years if the pedestrian dies (S.C. Code § 56-5-1210).',
            ),
        ),
    ),

    /* ============================================================
       4. Distracted Driver Pedestrian Accidents
       ============================================================ */
    array(
        'title'   => 'Distracted Driver Pedestrian Accident Lawyers',
        'slug'    => 'distracted-driver-pedestrian-accident',
        'excerpt' => 'Struck by a distracted driver while walking? Texting, phone use, and other distractions are a leading cause of pedestrian crashes. Our attorneys hold distracted drivers accountable for the injuries they cause.',
        'content' => <<<'HTML'
<h2>Distracted Driver Pedestrian Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Distracted driving has become one of the leading causes of pedestrian injuries and deaths in the United States. When a driver is looking at a phone, texting, adjusting a GPS, or otherwise distracted, they are far less likely to see a pedestrian — and far less able to stop in time. The <a href="https://www.nhtsa.gov/risky-driving/distracted-driving" target="_blank" rel="noopener">NHTSA</a> reports that distracted driving killed 3,308 people in a recent year, with pedestrians representing a substantial and growing share of those deaths.</p>
<p>At Roden Law, our pedestrian accident lawyers aggressively pursue distracted driver cases. Cell phone records, vehicle infotainment data, and dashcam footage can prove a driver was distracted — and we know how to obtain and present this evidence to maximize compensation for our clients.</p>

<h2>Distracted Driving Laws in Georgia and South Carolina</h2>
<p>Both states have enacted laws specifically targeting distracted driving:</p>
<ul>
<li><strong>Georgia Hands-Free Law:</strong> Since July 2018, Georgia's Hands-Free Act (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-11/section-40-6-241-2/" target="_blank" rel="noopener">O.C.G.A. § 40-6-241.2</a>) prohibits drivers from holding or supporting a phone with any part of their body while driving. Drivers may not write, read, or send texts, watch videos, or record video while driving.</li>
<li><strong>South Carolina Texting Ban:</strong> South Carolina law (<a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-3890</a>) prohibits texting while driving. South Carolina has been considering broader hands-free legislation.</li>
</ul>
<p>Violating these statutes while striking a pedestrian creates strong evidence of negligence — the driver was breaking the law at the moment of the crash.</p>

<h2>Types of Driver Distraction That Cause Pedestrian Crashes</h2>
<p>Distraction comes in three forms, and phone use involves all three simultaneously:</p>
<ul>
<li><strong>Visual distraction:</strong> Eyes off the road — looking at a phone screen, GPS, or infotainment display instead of scanning for pedestrians</li>
<li><strong>Manual distraction:</strong> Hands off the wheel — holding, swiping, or typing on a device instead of maintaining vehicle control</li>
<li><strong>Cognitive distraction:</strong> Mind off driving — focusing on a conversation, message, or content rather than the driving environment</li>
</ul>
<p>A driver looking at a phone for just 5 seconds at 30 mph travels 220 feet — more than half a city block — effectively blind. In that distance, a pedestrian can step off the curb, enter a crosswalk, and be struck before the driver ever looks up.</p>

<h2>Proving Distraction in Pedestrian Crash Cases</h2>
<p>Our attorneys use multiple sources of evidence to establish that a driver was distracted:</p>
<ul>
<li><strong>Cell phone records:</strong> Call logs, text message timestamps, and app usage data showing activity at the time of the crash</li>
<li><strong>Infotainment system data:</strong> Modern vehicles log touchscreen interactions, Bluetooth connections, and navigation inputs</li>
<li><strong>Dashcam and traffic camera footage:</strong> Video showing the driver looking down or not reacting to the pedestrian</li>
<li><strong>Witness testimony:</strong> Observers who saw the driver on a phone or looking away from the road</li>
<li><strong>Crash dynamics:</strong> No evidence of braking or evasive action before impact — a hallmark of distracted driving</li>
</ul>
<p>When a distracted driving statute violation is proven, it constitutes negligence per se in many jurisdictions, meaning the driver is presumptively negligent. Combined with the devastating injuries pedestrians suffer, these cases often result in substantial compensation including the potential for punitive damages under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-5-1/" target="_blank" rel="noopener">O.C.G.A. § 51-12-5.1</a>) when the conduct is particularly egregious.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Is texting while driving illegal in Georgia and South Carolina?',
                'answer'   => 'Yes. Georgia\'s Hands-Free Act (O.C.G.A. § 40-6-241.2) prohibits holding a phone while driving and bans texting, emailing, and video use. South Carolina law (S.C. Code § 56-5-3890) specifically prohibits texting while driving. Violations while striking a pedestrian create strong evidence of negligence.',
            ),
            array(
                'question' => 'How can you prove a driver was distracted when they hit me?',
                'answer'   => 'Evidence includes cell phone records showing calls, texts, or app use at the time of the crash; vehicle infotainment system logs; dashcam or traffic camera footage; witness testimony; and crash dynamics showing no braking or evasive action before impact.',
            ),
            array(
                'question' => 'Can I get punitive damages from a distracted driver?',
                'answer'   => 'Potentially, yes. If the distraction was particularly egregious — such as watching a video, using social media, or repeated phone use despite known risks — punitive damages may be available under Georgia law (O.C.G.A. § 51-12-5.1) for willful misconduct or conscious disregard for safety.',
            ),
            array(
                'question' => 'How far does a car travel in 5 seconds of distraction?',
                'answer'   => 'At 30 mph, a car travels 220 feet in 5 seconds — more than half a city block. At 45 mph, it\'s 330 feet. At 60 mph, it\'s 440 feet — nearly one and a half football fields. That\'s how far a distracted driver travels completely blind to pedestrians.',
            ),
            array(
                'question' => 'What types of distraction cause the most pedestrian accidents?',
                'answer'   => 'Smartphone use is the leading cause because it involves all three types of distraction simultaneously — visual (eyes on screen), manual (hands on phone), and cognitive (mind on content). Other causes include GPS/infotainment use, eating, grooming, and passenger conversations.',
            ),
        ),
    ),

    /* ============================================================
       5. Drunk Driver Pedestrian Accidents
       ============================================================ */
    array(
        'title'   => 'Drunk Driver Pedestrian Accident Lawyers',
        'slug'    => 'drunk-driver-pedestrian-accident',
        'excerpt' => 'Struck by a drunk driver while walking? Impaired drivers are a leading cause of pedestrian fatalities. Our attorneys pursue maximum compensation including punitive damages and dram shop claims.',
        'content' => <<<'HTML'
<h2>Drunk Driver Pedestrian Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Alcohol-impaired drivers are one of the greatest threats to pedestrian safety. A drunk driver's impaired vision, delayed reactions, and poor judgment make them far more likely to fail to see a pedestrian, run a red light, or lose control — with devastating consequences for anyone on foot. The <a href="https://www.nhtsa.gov/risky-driving/drunk-driving" target="_blank" rel="noopener">NHTSA</a> reports that alcohol impairment is a factor in approximately 47% of all traffic crashes that result in pedestrian deaths — nearly half of all pedestrian fatalities involve a drunk driver or a drunk pedestrian.</p>
<p>At Roden Law, our pedestrian accident lawyers pursue the most aggressive legal strategies available against drunk drivers, including punitive damages and dram shop liability claims against establishments that over-served the impaired driver.</p>

<h2>DUI and Pedestrian Safety Laws</h2>
<p>Both Georgia and South Carolina impose serious criminal and civil consequences for impaired driving that injures pedestrians:</p>
<ul>
<li><strong>Georgia:</strong> <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-15/section-40-6-391/" target="_blank" rel="noopener">O.C.G.A. § 40-6-391</a> prohibits driving with a BAC of 0.08% or higher. Serious injury by vehicle while DUI is a felony carrying 1-15 years. First-degree vehicular homicide while DUI carries 3-15 years.</li>
<li><strong>South Carolina:</strong> <a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-2930</a> prohibits driving with a BAC of 0.08% or higher. Felony DUI resulting in great bodily injury carries up to 15 years. DUI resulting in death carries up to 25 years.</li>
</ul>

<h2>Punitive Damages and Dram Shop Liability</h2>
<p>Drunk driver pedestrian cases often support two powerful additional claims:</p>
<ul>
<li><strong>Punitive damages:</strong> Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-5-1/" target="_blank" rel="noopener">O.C.G.A. § 51-12-5.1</a>) and South Carolina law allow punitive damages for willful misconduct or conscious disregard for safety. Choosing to drive drunk is strong evidence of exactly that kind of reckless behavior. These damages punish the wrongdoer beyond compensatory damages.</li>
<li><strong>Dram shop claims:</strong> Georgia's dram shop law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-4/" target="_blank" rel="noopener">O.C.G.A. § 51-1-40</a>) and South Carolina's statute (<a href="https://www.scstatehouse.gov/code/t61c004.php" target="_blank" rel="noopener">S.C. Code § 61-4-580</a>) allow claims against bars, restaurants, and other establishments that served alcohol to a visibly intoxicated person who then caused injury. These claims add a second liable party with commercial insurance coverage.</li>
</ul>

<h2>Why Drunk Drivers Are Especially Dangerous to Pedestrians</h2>
<p>Alcohol impairment creates a perfect storm of risk for pedestrians:</p>
<ul>
<li><strong>Reduced peripheral vision:</strong> Alcohol narrows a driver's field of vision, making them less likely to detect pedestrians at the edges of the road or entering crosswalks</li>
<li><strong>Delayed reaction time:</strong> Even moderate impairment significantly increases the time needed to perceive a hazard and apply the brakes</li>
<li><strong>Night driving impairment:</strong> Most drunk driving occurs at night, when pedestrian visibility is already reduced. Alcohol further impairs night vision and glare recovery</li>
<li><strong>Lane drift and loss of control:</strong> Impaired drivers weave across lanes and onto shoulders and sidewalks</li>
<li><strong>Speed misjudgment:</strong> Drunk drivers often drive faster than they realize, reducing their ability to stop for pedestrians</li>
</ul>
<p>Our attorneys pursue every available dollar of compensation — from the drunk driver's liability insurance, from punitive damages, from dram shop claims, and from any other applicable coverage — to ensure pedestrian victims and their families receive full justice.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What percentage of pedestrian deaths involve drunk drivers?',
                'answer'   => 'Approximately 47% of all traffic crashes resulting in pedestrian deaths involve alcohol impairment — either an impaired driver or an impaired pedestrian. Drunk driving is one of the single largest factors in pedestrian fatalities nationwide.',
            ),
            array(
                'question' => 'Can I sue the bar that served the drunk driver who hit me?',
                'answer'   => 'Yes, potentially. Georgia\'s dram shop law (O.C.G.A. § 51-1-40) and South Carolina\'s (S.C. Code § 61-4-580) allow claims against establishments that served a visibly intoxicated person who then caused injury. The establishment\'s commercial liability insurance provides an additional source of recovery.',
            ),
            array(
                'question' => 'What are punitive damages and can I get them in a drunk driving case?',
                'answer'   => 'Punitive damages are additional damages beyond your actual losses, designed to punish the wrongdoer and deter similar conduct. Both Georgia and South Carolina allow punitive damages when the defendant acted with willful misconduct or conscious disregard for safety — driving drunk clearly qualifies.',
            ),
            array(
                'question' => 'Does a DUI conviction help my pedestrian injury case?',
                'answer'   => 'Yes. A DUI conviction or guilty plea is strong evidence of negligence in your civil case. While criminal and civil cases are separate, the conviction establishes that the driver was impaired at the time of the crash and supports claims for punitive damages.',
            ),
            array(
                'question' => 'What if the drunk driver who hit me had no insurance?',
                'answer'   => 'You may have coverage through your own auto insurance policy\'s Uninsured Motorist (UM) coverage, even though you were a pedestrian. Additionally, dram shop claims against bars or restaurants provide another source of recovery with commercial insurance. Crime victim compensation programs may also help.',
            ),
        ),
    ),

    /* ============================================================
       6. Backing-Up / Parking Lot Accidents
       ============================================================ */
    array(
        'title'   => 'Backing-Up / Parking Lot Pedestrian Accident Lawyers',
        'slug'    => 'backing-up-parking-lot-accident',
        'excerpt' => 'Hit by a vehicle backing up or in a parking lot? These low-speed crashes cause serious injuries, especially to children and elderly pedestrians. Our attorneys pursue full compensation from negligent drivers.',
        'content' => <<<'HTML'
<h2>Backing-Up &amp; Parking Lot Pedestrian Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Not all pedestrian accidents happen on busy roads or at intersections. A significant number of serious pedestrian injuries occur in parking lots, driveways, and other low-speed environments where vehicles are backing up or maneuvering. While these crashes may seem minor because of the low speeds involved, the reality is that pedestrians — especially young children and elderly individuals — suffer serious and sometimes fatal injuries. The non-profit <a href="https://www.kidsandcars.org/" target="_blank" rel="noopener">Kids and Cars</a> organization reports that at least 50 children are backed over by vehicles every week in the United States.</p>
<p>At Roden Law, our pedestrian accident lawyers represent individuals and families injured in parking lot and backing-up crashes throughout Georgia and South Carolina. We understand the liability complexities of these cases and pursue full compensation from negligent drivers and, where applicable, property owners.</p>

<h2>Common Backing-Up and Parking Lot Crash Scenarios</h2>
<p>Our attorneys handle a wide range of parking lot and backing-up pedestrian cases:</p>
<ul>
<li><strong>Backover accidents:</strong> A driver reverses out of a parking space or driveway without checking behind the vehicle, striking a pedestrian — particularly children who fall below the rear sight line</li>
<li><strong>Parking lot crossings:</strong> Pedestrians walking through parking lot travel lanes struck by vehicles looking for spaces or exiting quickly</li>
<li><strong>Drive-aisle crashes:</strong> Vehicles speeding through parking lot aisles where pedestrians are loading groceries or walking to stores</li>
<li><strong>Delivery and loading zones:</strong> Commercial vehicles backing up to loading docks without spotters, striking pedestrians in the area</li>
<li><strong>Drive-through lanes:</strong> Pedestrians struck in or near restaurant or business drive-through lanes</li>
<li><strong>Parking garage incidents:</strong> Low visibility, tight turns, and steep ramps in parking structures create dangerous pedestrian conditions</li>
</ul>

<h2>Liability in Parking Lot Pedestrian Cases</h2>
<p>Parking lot accidents may involve multiple liable parties:</p>
<ul>
<li><strong>The driver:</strong> Every driver has a duty to check mirrors, use backup cameras, and physically look behind them before reversing. Failure to do so is negligence.</li>
<li><strong>The property owner:</strong> Shopping centers, businesses, and parking lot owners have a duty to maintain safe premises, including adequate lighting, clear sight lines, speed bumps, pedestrian walkways, and proper signage</li>
<li><strong>The vehicle manufacturer:</strong> If a backup camera, rear cross-traffic alert, or automatic emergency braking system failed or was not included when required by federal regulation</li>
<li><strong>Employers:</strong> For commercial vehicles, the driver's employer may be vicariously liable, and employers who fail to provide spotters for backing maneuvers may be directly negligent</li>
</ul>
<p>Georgia premises liability law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>) and South Carolina law hold property owners to a duty of ordinary care to protect invitees from foreseeable hazards. A parking lot with known pedestrian traffic and no safety measures may be liable for resulting injuries.</p>

<h2>Backup Camera Regulations</h2>
<p>Since May 2018, federal regulation (<a href="https://www.ecfr.gov/current/title-49/subtitle-B/chapter-V/part-571/subpart-B/section-571.111" target="_blank" rel="noopener">FMVSS 111</a>) requires all new vehicles under 10,000 pounds to have rear visibility technology (backup cameras). If a vehicle equipped with this technology had a malfunctioning camera that contributed to a backover crash, a product liability claim against the manufacturer may apply.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who is liable if I\'m hit by a car backing up in a parking lot?',
                'answer'   => 'The driver who backed up without properly checking is typically liable. The parking lot or property owner may also share liability if poor lighting, sight line obstructions, or lack of pedestrian safety measures contributed to the crash. In commercial vehicle cases, the driver\'s employer may be liable as well.',
            ),
            array(
                'question' => 'Are parking lot accidents covered by auto insurance?',
                'answer'   => 'Yes. Parking lot accidents are covered by the at-fault driver\'s liability insurance just like any other vehicle crash. Your own UM/UIM and MedPay coverages may also apply. The parking lot owner\'s premises liability insurance may provide additional coverage if their negligence contributed.',
            ),
            array(
                'question' => 'Why are children especially at risk for backover accidents?',
                'answer'   => 'Young children are small enough to be completely hidden in a vehicle\'s rear blind spot. They are also unpredictable, may not understand the danger of a reversing vehicle, and cannot move out of the way quickly. Kids and Cars reports at least 50 children are backed over weekly in the U.S.',
            ),
            array(
                'question' => 'Can I sue the property owner for a dangerous parking lot?',
                'answer'   => 'Yes. Property owners owe a duty of care to visitors, including adequate lighting, clear sight lines, speed control measures, and pedestrian walkways. If a known dangerous condition contributed to your injury, the property owner may be liable under Georgia or South Carolina premises liability law.',
            ),
            array(
                'question' => 'Are backup cameras required in all new vehicles?',
                'answer'   => 'Since May 2018, federal regulation FMVSS 111 requires all new passenger vehicles under 10,000 pounds to include rear visibility technology (backup cameras). If a backup camera malfunctioned and contributed to a pedestrian crash, the vehicle manufacturer may have product liability.',
            ),
        ),
    ),

    /* ============================================================
       7. School Zone Pedestrian Accidents
       ============================================================ */
    array(
        'title'   => 'School Zone Pedestrian Accident Lawyers',
        'slug'    => 'school-zone-pedestrian-accident',
        'excerpt' => 'Child injured in a school zone? Drivers who speed, ignore crossing guards, or drive distracted in school zones put children\'s lives at risk. Our attorneys fight for injured children and their families.',
        'content' => <<<'HTML'
<h2>School Zone Pedestrian Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>School zones exist to protect children — our most vulnerable pedestrians — during the hours they walk to and from school. When a driver speeds through a school zone, ignores a crossing guard, or drives distracted near a school, the consequences can be devastating. Children are smaller, harder to see, less predictable in their movements, and less able to judge the speed and distance of approaching vehicles. Every school zone crash is a preventable tragedy.</p>
<p>At Roden Law, our pedestrian accident lawyers represent children and families injured in school zone crashes throughout Georgia and South Carolina. We aggressively pursue claims against negligent drivers — and, when applicable, against schools and government entities that failed to provide adequate safety measures.</p>

<h2>School Zone Speed Limits and Traffic Laws</h2>
<p>Both states impose reduced speed limits and enhanced penalties in school zones:</p>
<ul>
<li><strong>Georgia:</strong> <a href="https://law.justia.com/codes/georgia/title-40/chapter-14/article-3/section-40-14-8/" target="_blank" rel="noopener">O.C.G.A. § 40-14-8</a> and related statutes establish school zone speed limits, typically 25 mph during posted hours. Fines for speeding in a school zone are doubled, and points assessed against a license are increased.</li>
<li><strong>South Carolina:</strong> School zone speed limits are typically 15-25 mph during posted hours. Enhanced penalties apply for violations in school zones, and crossing guard signals have the force of law.</li>
</ul>
<p>Violating school zone speed limits or traffic controls while striking a child creates powerful evidence of negligence — the driver was breaking a law specifically designed to protect children.</p>

<h2>Common Causes of School Zone Pedestrian Accidents</h2>
<ul>
<li><strong>Speeding:</strong> Drivers who fail to reduce speed in school zones or ignore flashing school zone signs</li>
<li><strong>Distracted driving:</strong> Phone use and other distractions are especially dangerous where children are present because kids can dart into the road with little warning</li>
<li><strong>Ignoring crossing guards:</strong> Drivers who fail to stop when directed by school crossing guards</li>
<li><strong>Illegal passing of school buses:</strong> Georgia (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-9/section-40-6-163/" target="_blank" rel="noopener">O.C.G.A. § 40-6-163</a>) and South Carolina law require all traffic to stop when a school bus displays its stop sign. Passing a stopped school bus is a serious offense.</li>
<li><strong>Drop-off zone chaos:</strong> Congested school drop-off and pick-up areas where vehicles, buses, and pedestrians converge</li>
<li><strong>Inadequate infrastructure:</strong> Missing sidewalks, crosswalks, or crossing guards that force children to navigate dangerous conditions</li>
</ul>

<h2>Liability Beyond the Driver</h2>
<p>School zone crashes may involve additional liable parties:</p>
<ul>
<li><strong>School districts:</strong> For failure to provide adequate crossing guards, safe drop-off procedures, or proper traffic management during school hours</li>
<li><strong>Government entities:</strong> For failure to install or maintain school zone signage, flashing lights, speed reduction measures, crosswalks, and sidewalks. Claims against government entities must comply with Georgia's Tort Claims Act (<a href="https://law.justia.com/codes/georgia/title-50/chapter-21/" target="_blank" rel="noopener">O.C.G.A. § 50-21-20 et seq.</a>) or South Carolina's Tort Claims Act (<a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">S.C. Code § 15-78-10 et seq.</a>).</li>
</ul>
<p>Our attorneys investigate whether the school and local government met their duty to provide a safe environment for students, and pursue all responsible parties to ensure injured children and their families receive full compensation for medical care, rehabilitation, pain and suffering, and long-term impacts on the child's development.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the speed limit in a school zone in Georgia and South Carolina?',
                'answer'   => 'Georgia school zones are typically 25 mph during posted hours, with doubled fines for violations. South Carolina school zones are typically 15-25 mph during school hours. Speed limits are posted with school zone signs and often accompanied by flashing warning lights.',
            ),
            array(
                'question' => 'Can I sue the school if my child was hit near the school?',
                'answer'   => 'Potentially, yes. If the school failed to provide adequate crossing guards, safe drop-off/pick-up procedures, or proper traffic management during school hours, the school district may share liability. Claims against public schools are subject to state tort claims act requirements and notice deadlines.',
            ),
            array(
                'question' => 'What are the penalties for passing a stopped school bus?',
                'answer'   => 'In Georgia (O.C.G.A. § 40-6-163), passing a stopped school bus is a misdemeanor with fines up to $1,000, 6 points on your license, and potential jail time for repeat offenses. South Carolina imposes similar penalties. If a child is struck, criminal charges escalate significantly.',
            ),
            array(
                'question' => 'Why are children more vulnerable as pedestrians?',
                'answer'   => 'Children are smaller (harder to see), less predictable in their movements, less able to judge vehicle speed and distance, and may dart into the road unexpectedly. They also have a smaller field of vision and less developed peripheral vision than adults.',
            ),
            array(
                'question' => 'What compensation is available when a child is hit in a school zone?',
                'answer'   => 'Parents can recover medical expenses (current and future), rehabilitation costs, pain and suffering, emotional trauma, and impacts on the child\'s development and quality of life. In Georgia, parents can also recover for their own loss of the child\'s companionship. Wrongful death claims apply if the child dies.',
            ),
        ),
    ),

    /* ============================================================
       8. Jogger and Runner Accidents
       ============================================================ */
    array(
        'title'   => 'Jogger and Runner Accident Lawyers',
        'slug'    => 'jogger-runner-accident',
        'excerpt' => 'Struck by a vehicle while jogging or running? Runners face unique risks from inattentive drivers on roads and shoulders. Our attorneys pursue maximum compensation for injured joggers and their families.',
        'content' => <<<'HTML'
<h2>Jogger &amp; Runner Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Joggers and runners share the road with vehicles every day, often on shoulders, bike lanes, and roadside paths where they are vulnerable to inattentive, distracted, or impaired drivers. Unlike pedestrians who cross the road briefly, runners spend extended periods alongside traffic — increasing their exposure to negligent drivers. When a vehicle strikes a runner, the injuries are almost always serious because the runner is moving forward and typically struck from behind or the side without warning.</p>
<p>At Roden Law, our pedestrian accident lawyers represent joggers and runners injured by negligent drivers throughout Georgia and South Carolina. We understand the unique circumstances of these crashes and fight for full compensation for our running community.</p>

<h2>Common Causes of Jogger and Runner Accidents</h2>
<p>Our investigation of runner-vehicle crashes reveals recurring patterns of driver negligence:</p>
<ul>
<li><strong>Distracted driving:</strong> Drivers on phones, adjusting music, or otherwise distracted who drift onto shoulders or fail to see a runner on the road</li>
<li><strong>Failure to share the road:</strong> Drivers who fail to move over or slow down when passing a runner, especially on narrow roads without sidewalks</li>
<li><strong>Impaired driving:</strong> Drunk or drugged drivers who drift off the road and onto shoulders where runners are traveling</li>
<li><strong>Drowsy driving:</strong> Particularly dangerous during early morning and evening hours when many runners are on the road and lighting is poor</li>
<li><strong>Right-turning vehicles:</strong> Drivers turning right who check left for traffic but fail to look right where a runner may be approaching on the shoulder or crosswalk</li>
<li><strong>Sun glare:</strong> Low morning or evening sun that blinds drivers, especially during popular running hours at dawn and dusk</li>
<li><strong>Road design deficiencies:</strong> Lack of sidewalks, shoulders, or running paths that forces runners to share travel lanes with vehicles</li>
</ul>

<h2>Runner Rights and Pedestrian Laws</h2>
<p>Joggers and runners have the same legal rights as other pedestrians:</p>
<ul>
<li><strong>Georgia:</strong> Under <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-5/section-40-6-96/" target="_blank" rel="noopener">O.C.G.A. § 40-6-96</a>, where sidewalks are not available, pedestrians (including runners) should walk or run facing traffic on the left side of the road or shoulder. Drivers must exercise due care to avoid colliding with any pedestrian.</li>
<li><strong>South Carolina:</strong> South Carolina law similarly requires drivers to exercise due care around pedestrians and provides that pedestrians on the roadway where sidewalks are unavailable should keep to the left, facing traffic.</li>
</ul>
<p>Even if a runner was on the right side of the road (with traffic) rather than facing traffic, this does not bar a claim. Comparative fault may reduce the recovery, but the driver's duty to exercise due care and avoid colliding with pedestrians remains.</p>

<h2>Unique Challenges in Runner Accident Cases</h2>
<p>Jogger cases present some unique factors:</p>
<ul>
<li><strong>Earbuds and headphones:</strong> Insurance companies often argue that runners wearing headphones couldn't hear an approaching vehicle. While situational awareness matters, a driver's duty to see and avoid a pedestrian is paramount — a visible runner in reflective gear should never be struck regardless of headphone use.</li>
<li><strong>Clothing and visibility:</strong> Wearing dark clothing at dawn or dusk may be raised as comparative fault, but the driver's obligation to watch for pedestrians is not diminished.</li>
<li><strong>Running groups:</strong> Crashes involving running groups may have multiple injured victims and witnesses who can corroborate negligent driving.</li>
</ul>
<p>Our attorneys counter victim-blaming tactics aggressively. Under both Georgia and South Carolina comparative fault rules, a runner can recover damages as long as the driver bore the majority of fault. We pursue full compensation for all medical expenses, lost wages, pain and suffering, permanent disability, and wrongful death.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What are my legal rights as a runner sharing the road with cars?',
                'answer'   => 'Runners have the same rights as pedestrians. Where sidewalks are unavailable, Georgia law (O.C.G.A. § 40-6-96) recommends running on the left side facing traffic. Drivers must exercise due care to avoid hitting any pedestrian. Running on the road is legal when no sidewalk is available.',
            ),
            array(
                'question' => 'Does wearing headphones while running affect my injury claim?',
                'answer'   => 'Insurance companies may argue headphones reduced your awareness, but this rarely defeats a claim. A driver\'s duty to see and avoid a visible pedestrian is paramount. A runner in the road or on a shoulder, especially in reflective gear, should never be struck regardless of whether they are wearing earbuds.',
            ),
            array(
                'question' => 'What if I was running with traffic instead of against traffic?',
                'answer'   => 'Running with traffic instead of facing it may be raised as comparative fault, but it does not bar your claim. Both Georgia and South Carolina use comparative fault rules — you can still recover as long as you are less than 50% (GA) or 51% (SC) at fault. The driver\'s negligence remains the primary factor.',
            ),
            array(
                'question' => 'When are runners most at risk of being hit by a car?',
                'answer'   => 'Dawn and dusk are the most dangerous times — low light conditions combined with sun glare make runners harder to see. Early morning darkness before sunrise and evening twilight are also high-risk periods. Wearing reflective gear and bright colors significantly improves visibility.',
            ),
            array(
                'question' => 'Can I sue the city if there are no sidewalks where I was running?',
                'answer'   => 'Potentially, yes. If a government entity failed to provide sidewalks, shoulders, or safe pedestrian infrastructure in an area with known pedestrian traffic, they may share liability. Claims against government entities must follow Georgia\'s or South Carolina\'s Tort Claims Act procedures and notice requirements.',
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
