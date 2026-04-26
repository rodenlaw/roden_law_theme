<?php
/**
 * Seeder: 8 Motorcycle Accident Sub-Type Pages
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-motorcycle-accident-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: motorcycle-accident-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'motorcycle-accident-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'motorcycle-accident-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "motorcycle-accident-lawyers" not found.' );
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

$cat_term = term_exists( 'motorcycle-accidents', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Motorcycle Accidents', 'practice_category', array( 'slug' => 'motorcycle-accidents' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Head-On Motorcycle Collisions
       ============================================================ */
    array(
        'title'   => 'Head-On Motorcycle Collision Lawyers',
        'slug'    => 'head-on-motorcycle-collision',
        'excerpt' => 'Head-on motorcycle collisions are among the most fatal crashes on the road. Our attorneys fight for maximum compensation when negligent drivers cross the centerline and cause devastating frontal-impact crashes.',
        'content' => <<<'HTML'
<h2>Head-On Motorcycle Collision Lawyers in Georgia &amp; South Carolina</h2>
<p>Head-on collisions are the most deadly type of motorcycle accident. When a car, truck, or SUV crosses the centerline and strikes a motorcyclist head-on, the rider absorbs the combined force of both vehicles' speeds with virtually no structural protection. The <a href="https://www.nhtsa.gov/road-safety/motorcycles" target="_blank" rel="noopener">National Highway Traffic Safety Administration (NHTSA)</a> reports that head-on crashes account for a disproportionate share of motorcycle fatalities — riders are approximately 29 times more likely to die in a crash than passenger vehicle occupants per mile traveled.</p>
<p>At Roden Law, our motorcycle accident lawyers understand the catastrophic nature of head-on collisions and the aggressive legal strategies needed to secure full compensation for riders and their families throughout Georgia and South Carolina.</p>

<h2>Common Causes of Head-On Motorcycle Crashes</h2>
<p>Head-on collisions with motorcycles most frequently occur when another driver crosses into oncoming traffic. Contributing factors include:</p>
<ul>
<li><strong>Distracted driving:</strong> A driver looking at a phone, adjusting GPS, or otherwise distracted drifts across the centerline into oncoming traffic</li>
<li><strong>Impaired driving:</strong> Alcohol and drug impairment impair a driver's ability to maintain their lane, especially on two-lane roads and curves</li>
<li><strong>Improper passing:</strong> Drivers who attempt to pass slower vehicles on two-lane roads without adequate visibility or clearance</li>
<li><strong>Drowsy driving:</strong> Fatigued drivers who drift across lane markings, particularly during early morning or late-night hours</li>
<li><strong>Curves and hills:</strong> Drivers who cut corners or drift wide on curves, especially on rural roads common throughout Georgia and South Carolina</li>
</ul>

<h2>Catastrophic Injuries in Head-On Motorcycle Crashes</h2>
<p>The physics of a head-on collision make these crashes uniquely devastating for motorcyclists. With no surrounding vehicle structure, airbags, or crumple zones, riders absorb the full force of impact. Common injuries include:</p>
<ul>
<li><strong>Traumatic brain injuries:</strong> Even with a helmet, the extreme deceleration forces can cause severe TBI, including diffuse axonal injury</li>
<li><strong>Spinal cord injuries and paralysis:</strong> The violent impact frequently causes vertebral fractures and spinal cord damage</li>
<li><strong>Multiple fractures:</strong> Legs, pelvis, arms, ribs, and facial bones are all extremely vulnerable</li>
<li><strong>Internal organ damage:</strong> Blunt force trauma to the chest and abdomen can rupture organs and cause life-threatening internal bleeding</li>
<li><strong>Amputation:</strong> Crushing forces at the point of impact can result in traumatic amputation of limbs</li>
<li><strong>Wrongful death:</strong> Head-on motorcycle crashes have an extremely high fatality rate</li>
</ul>

<h2>Proving Liability and Pursuing Maximum Compensation</h2>
<p>In head-on motorcycle crashes, liability is often clear — the driver who crossed the centerline is at fault. However, insurance companies frequently try to shift blame to the motorcyclist, alleging excessive speed or failure to take evasive action. Our attorneys counter these tactics with accident reconstruction experts, witness testimony, physical evidence analysis, and crash scene documentation.</p>
<p>Georgia follows a modified comparative fault rule under <a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>, allowing recovery if the rider is less than 50% at fault. South Carolina applies a similar standard barring recovery only at 51% or greater fault. Given the severity of injuries, we pursue all available damages including medical expenses, lost wages, pain and suffering, permanent disability, and punitive damages when the at-fault driver was impaired or engaged in egregious conduct.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Why are head-on motorcycle accidents so deadly?',
                'answer'   => 'Head-on crashes combine the speeds of both vehicles into a single impact force, and motorcyclists have no surrounding structure, airbags, or crumple zones for protection. The rider absorbs the full force of the collision, making these crashes far more likely to cause fatal or catastrophic injuries than any other crash type.',
            ),
            array(
                'question' => 'Who is at fault in a head-on motorcycle collision?',
                'answer'   => 'The driver who crossed the centerline into oncoming traffic is typically at fault. Common causes include distracted driving, impairment, improper passing, and drowsy driving. Insurance companies may try to blame the motorcyclist, but an experienced attorney can counter these tactics with evidence.',
            ),
            array(
                'question' => 'What compensation is available for head-on motorcycle crash victims?',
                'answer'   => 'Victims may recover medical expenses (current and future), lost wages and earning capacity, pain and suffering, permanent disability, disfigurement, loss of enjoyment of life, and property damage. Punitive damages may be available if the at-fault driver was drunk or grossly negligent.',
            ),
            array(
                'question' => 'Does wearing a helmet affect my claim in Georgia or South Carolina?',
                'answer'   => 'Georgia requires helmets for all riders (O.C.G.A. § 40-6-315). South Carolina requires helmets only for riders under 21. Not wearing a helmet when required could be used to argue comparative fault for head injuries, but it does not bar your claim entirely.',
            ),
            array(
                'question' => 'How long do I have to file a head-on motorcycle accident claim?',
                'answer'   => 'Georgia has a 2-year statute of limitations (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). However, acting quickly is critical to preserve evidence from the crash scene before it is lost or destroyed.',
            ),
        ),
    ),

    /* ============================================================
       2. Left-Turn Accidents
       ============================================================ */
    array(
        'title'   => 'Left-Turn Motorcycle Accident Lawyers',
        'slug'    => 'left-turn-accident',
        'excerpt' => 'Left-turn accidents are the most common type of motorcycle crash. When a driver turns left in front of an oncoming motorcycle, the results are devastating. Our lawyers pursue full compensation.',
        'content' => <<<'HTML'
<h2>Left-Turn Motorcycle Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Left-turn accidents are the single most common type of motorcycle crash. These collisions occur when a car, truck, or SUV turns left at an intersection or driveway directly into the path of an oncoming motorcycle. The <a href="https://www.nhtsa.gov/road-safety/motorcycles" target="_blank" rel="noopener">NHTSA</a> reports that left-turn scenarios account for approximately 42% of all fatal crashes between motorcycles and other vehicles — making this the leading collision pattern for motorcycle fatalities nationwide.</p>
<p>At Roden Law, our motorcycle accident lawyers handle left-turn collision cases throughout Georgia and South Carolina. We understand why these crashes happen, how insurance companies try to blame riders, and what it takes to secure full compensation for our clients.</p>

<h2>Why Left-Turn Accidents Happen to Motorcyclists</h2>
<p>Left-turn crashes are overwhelmingly caused by the turning driver's failure to see or yield to the oncoming motorcycle. Contributing factors include:</p>
<ul>
<li><strong>"Looked but didn't see" phenomenon:</strong> Drivers often look for cars and trucks but fail to register motorcycles because they are smaller and less expected. This perceptual blindness — called inattentional blindness — is the primary cause of left-turn motorcycle crashes</li>
<li><strong>Speed misjudgment:</strong> Drivers frequently misjudge a motorcycle's closing speed because of its narrow profile, believing they have time to complete the turn</li>
<li><strong>Visual obstruction:</strong> Other vehicles, road features, or A-pillar blind spots can hide an approaching motorcycle from the turning driver's view</li>
<li><strong>Distraction:</strong> Drivers checking phones, adjusting controls, or focused on other traffic may not see the motorcycle until it's too late</li>
<li><strong>Failure to yield:</strong> Drivers who turn left on a yellow light or misjudge a gap in traffic</li>
</ul>

<h2>Injuries in Left-Turn Motorcycle Crashes</h2>
<p>Left-turn collisions typically strike the motorcycle at a perpendicular angle, giving the rider almost no time to brake or swerve. The motorcycle often impacts the side of the turning vehicle, or the vehicle strikes the motorcycle broadside. Common injuries include traumatic brain injuries, broken legs and pelvis (from the motorcycle being struck or the rider being thrown), road rash and skin abrasion injuries, shoulder and collarbone fractures, spinal injuries, and internal organ damage.</p>

<h2>Liability in Left-Turn Motorcycle Accidents</h2>
<p>In most left-turn accidents, the turning driver is at fault for failing to yield the right of way to oncoming traffic. Georgia law (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-5/section-40-6-71/" target="_blank" rel="noopener">O.C.G.A. § 40-6-71</a>) requires drivers turning left to yield to oncoming vehicles that are close enough to constitute an immediate hazard. South Carolina has a similar right-of-way statute.</p>
<p>Despite clear liability, insurance companies routinely argue that the motorcyclist was speeding, was not visible, or failed to take evasive action. Our attorneys counter these defenses with accident reconstruction analysis, witness testimony, traffic camera footage, and physical evidence including skid marks and vehicle damage patterns. Under both states' modified comparative fault rules, even if the rider bore some fault, they can still recover damages as long as they are less than 50% (Georgia) or 51% (South Carolina) at fault.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Why are left-turn accidents the most common motorcycle crash?',
                'answer'   => 'Left-turn accidents account for about 42% of fatal motorcycle-vehicle crashes because turning drivers frequently fail to see motorcycles. The motorcycle\'s smaller profile makes it harder to detect, and drivers often misjudge a motorcycle\'s speed when deciding whether to turn.',
            ),
            array(
                'question' => 'Is the turning driver always at fault in a left-turn motorcycle accident?',
                'answer'   => 'The turning driver is at fault in the vast majority of these crashes for failing to yield the right of way. However, insurance companies may argue the motorcyclist was speeding or could have avoided the crash. An experienced attorney can counter these arguments with evidence.',
            ),
            array(
                'question' => 'What is "inattentional blindness" and how does it cause motorcycle crashes?',
                'answer'   => 'Inattentional blindness is a psychological phenomenon where drivers look at the road but fail to "see" a motorcycle because their brain is scanning for larger vehicles like cars and trucks. The motorcycle doesn\'t register even though the driver technically looked in that direction.',
            ),
            array(
                'question' => 'What should I do after a left-turn motorcycle accident?',
                'answer'   => 'Call 911 and get medical attention immediately. Document the scene with photos, including the intersection, traffic signals, and vehicle damage. Get witness contact information. Do not admit fault or give recorded statements to the other driver\'s insurance company before consulting an attorney.',
            ),
            array(
                'question' => 'Can I recover damages if I was partially at fault?',
                'answer'   => 'Yes. Georgia and South Carolina both use modified comparative fault rules. You can recover damages as long as you are less than 50% at fault in Georgia (O.C.G.A. § 51-12-33) or less than 51% at fault in South Carolina. Your recovery is reduced by your percentage of fault.',
            ),
        ),
    ),

    /* ============================================================
       3. Lane-Splitting Accidents
       ============================================================ */
    array(
        'title'   => 'Lane-Splitting Accident Lawyers',
        'slug'    => 'lane-splitting-accident',
        'excerpt' => 'Lane-splitting and lane-filtering accidents raise complex liability questions in Georgia and South Carolina. Our attorneys help injured motorcyclists navigate these claims and fight for fair compensation.',
        'content' => <<<'HTML'
<h2>Lane-Splitting Motorcycle Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Lane splitting — riding a motorcycle between lanes of slow-moving or stopped traffic — is one of the most debated practices in motorcycle safety. While some studies suggest that lane splitting at low speeds may actually reduce certain types of crashes, it remains illegal in both Georgia and South Carolina. When a lane-splitting accident occurs, the legal landscape becomes complex, and injured riders need experienced legal representation to protect their rights.</p>
<p>At Roden Law, our motorcycle accident lawyers handle lane-splitting cases throughout Georgia and South Carolina. Whether you were the rider splitting lanes or a motorist struck by a lane-splitting motorcycle, we help you understand your rights and pursue fair compensation.</p>

<h2>Lane-Splitting Laws in Georgia and South Carolina</h2>
<p>Both states where Roden Law operates prohibit lane splitting:</p>
<ul>
<li><strong>Georgia:</strong> <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-12/section-40-6-312/" target="_blank" rel="noopener">O.C.G.A. § 40-6-312</a> prohibits operating a motorcycle between lanes of traffic or between adjacent lines or rows of vehicles. Georgia law does allow two motorcycles to ride side-by-side (abreast) in a single lane.</li>
<li><strong>South Carolina:</strong> South Carolina law similarly prohibits motorcycles from passing between lanes of traffic moving in the same direction. Riders must follow the same lane-use rules as other vehicles.</li>
</ul>
<p>It is important to distinguish lane splitting from <strong>lane filtering</strong> — moving between stopped vehicles at a red light — which some states have legalized. Neither Georgia nor South Carolina currently permits lane filtering.</p>

<h2>Liability in Lane-Splitting Accidents</h2>
<p>Because lane splitting is illegal in both states, a rider who was splitting lanes at the time of a crash will likely be assigned some degree of fault. However, this does <strong>not</strong> automatically bar the rider from recovery:</p>
<ul>
<li><strong>Comparative fault applies:</strong> Under Georgia's modified comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>), a rider can still recover damages if they are less than 50% at fault. South Carolina's standard bars recovery only at 51% or more fault.</li>
<li><strong>The other driver may still be primarily at fault:</strong> If a driver changed lanes without signaling, opened a door into traffic, or made a sudden move without checking mirrors, they may bear the majority of fault regardless of the rider's lane-splitting</li>
<li><strong>Circumstances matter:</strong> The speed differential, traffic conditions, and the specific actions of all parties determine fault allocation</li>
</ul>

<h2>Common Lane-Splitting Accident Scenarios</h2>
<p>Lane-splitting crashes typically involve one of these patterns:</p>
<ul>
<li><strong>Lane-change collisions:</strong> A driver changes lanes without checking blind spots or signaling, striking a motorcycle passing between lanes</li>
<li><strong>Door-opening incidents:</strong> In stopped traffic, a vehicle occupant opens a door into the path of a lane-splitting motorcycle</li>
<li><strong>Sudden stops:</strong> A vehicle ahead makes an unexpected stop or move, leaving insufficient reaction time for the rider</li>
<li><strong>Mirror clips:</strong> The motorcycle's handlebars or the rider's body contacts a vehicle's side mirror in tight spaces</li>
</ul>

<h2>Building a Strong Case After a Lane-Splitting Accident</h2>
<p>Our attorneys work to minimize the fault attributed to our motorcycle clients and maximize their recovery. We gather traffic camera footage and dashcam video, document the other driver's actions (lane changes without signaling, distraction), establish the speed differential and traffic conditions, and retain accident reconstruction experts when needed. Even in lane-splitting cases, a skilled attorney can often demonstrate that the other driver's negligence was the primary cause of the crash.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Is lane splitting legal in Georgia or South Carolina?',
                'answer'   => 'No. Lane splitting is illegal in both states. Georgia law (O.C.G.A. § 40-6-312) specifically prohibits operating a motorcycle between lanes of traffic. South Carolina has similar prohibitions. Only California explicitly permits lane splitting by statute.',
            ),
            array(
                'question' => 'Can I still recover damages if I was lane splitting when I was hit?',
                'answer'   => 'Yes, potentially. Both Georgia and South Carolina use modified comparative fault rules. Even if you bear some fault for lane splitting, you can recover damages if the other driver was primarily responsible — for example, by changing lanes without looking or signaling.',
            ),
            array(
                'question' => 'What is the difference between lane splitting and lane filtering?',
                'answer'   => 'Lane splitting refers to riding between lanes of moving traffic. Lane filtering refers to moving between stopped vehicles, typically at a red light. Some states have legalized lane filtering at low speeds, but neither Georgia nor South Carolina currently permits either practice.',
            ),
            array(
                'question' => 'What if a driver changed lanes into me while I was lane splitting?',
                'answer'   => 'The driver who changed lanes without checking mirrors or signaling may bear significant fault, even though you were lane splitting. Comparative fault means both parties\' actions are evaluated. An attorney can help demonstrate that the driver\'s negligence was the primary cause of the crash.',
            ),
            array(
                'question' => 'How is fault divided in a lane-splitting accident?',
                'answer'   => 'Fault is determined by the specific circumstances — speed differential, traffic conditions, whether the other driver signaled, and the actions of all parties. A jury or insurance adjuster assigns a percentage of fault to each party. You can recover damages as long as your fault is below 50% (GA) or 51% (SC).',
            ),
        ),
    ),

    /* ============================================================
       4. Rear-End Motorcycle Accidents
       ============================================================ */
    array(
        'title'   => 'Rear-End Motorcycle Accident Lawyers',
        'slug'    => 'rear-end-motorcycle-accident',
        'excerpt' => 'Rear-ended on your motorcycle? Even low-speed rear-end collisions can throw a rider from the bike and cause catastrophic injuries. Our attorneys pursue maximum compensation from negligent drivers.',
        'content' => <<<'HTML'
<h2>Rear-End Motorcycle Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Rear-end collisions are among the most common types of car accidents on the road, but when a car or truck rear-ends a motorcycle, the consequences are far more severe. Unlike the occupants of a passenger vehicle who are protected by a trunk, crumple zone, headrest, and seatbelt, a motorcyclist hit from behind can be thrown from the bike, crushed between vehicles, or run over. Even a relatively low-speed rear-end impact that would cause a minor fender-bender between two cars can inflict catastrophic injuries on a motorcyclist.</p>
<p>At Roden Law, our motorcycle accident attorneys represent riders throughout Georgia and South Carolina who have been rear-ended by negligent, distracted, or impaired drivers. We fight to ensure that our clients receive full compensation for injuries that drivers' insurance companies often try to minimize.</p>

<h2>Why Rear-End Motorcycle Crashes Are So Dangerous</h2>
<p>Several factors make rear-end impacts uniquely dangerous for motorcyclists:</p>
<ul>
<li><strong>No rear crumple zone:</strong> A motorcycle offers zero rear-impact protection — the rider's body absorbs the collision force directly</li>
<li><strong>Ejection:</strong> The impact can launch the rider forward off the motorcycle and into traffic, other vehicles, or roadside obstacles</li>
<li><strong>Crushing risk:</strong> At intersections, the rider may be pushed into the vehicle ahead and crushed between two vehicles</li>
<li><strong>Secondary impacts:</strong> After being thrown from the motorcycle, the rider may be struck by other vehicles</li>
<li><strong>Whiplash-plus:</strong> Without a headrest, rear impacts cause severe hyperextension of the neck and spine</li>
</ul>

<h2>Common Causes of Rear-End Motorcycle Crashes</h2>
<p>Rear-end motorcycle accidents are overwhelmingly caused by the following driver:</p>
<ul>
<li><strong>Distracted driving:</strong> Texting, phone use, and other distractions are the leading cause of rear-end crashes. A driver looking at a phone for just 5 seconds at 55 mph covers the length of a football field</li>
<li><strong>Tailgating:</strong> Following a motorcycle too closely, without adequate stopping distance</li>
<li><strong>Failure to notice stopped traffic:</strong> Drivers who don't realize traffic ahead has stopped, particularly at intersections and in stop-and-go conditions</li>
<li><strong>Impaired driving:</strong> Alcohol and drugs impair reaction time and judgment</li>
<li><strong>Sun glare and poor visibility:</strong> Drivers blinded by low sun, rain, or fog who fail to see a motorcycle's brake light</li>
</ul>

<h2>Liability and Compensation</h2>
<p>In rear-end collisions, the following driver is almost always at fault. Drivers have a legal duty to maintain a safe following distance and remain attentive to traffic conditions ahead. This makes rear-end motorcycle cases strong from a liability standpoint.</p>
<p>Insurance companies may try to argue that the motorcycle's brake light was out, the rider stopped suddenly without reason, or the motorcycle was difficult to see. Our attorneys gather evidence — including witness statements, traffic camera footage, and vehicle damage analysis — to refute these defenses. We pursue full compensation for all medical expenses, lost income, pain and suffering, permanent disability, and wrongful death under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/" target="_blank" rel="noopener">O.C.G.A. Title 51</a>) and South Carolina law.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Is the driver who rear-ends a motorcycle always at fault?',
                'answer'   => 'In the vast majority of cases, yes. Drivers have a legal duty to maintain a safe following distance and stay attentive to traffic ahead. There are rare exceptions — such as if the motorcycle had no working brake lights — but the rear driver bears the burden of proving these defenses.',
            ),
            array(
                'question' => 'Why are rear-end crashes more dangerous for motorcyclists than car drivers?',
                'answer'   => 'Motorcycles have no rear crumple zone, trunk, headrest, or seatbelt to absorb and distribute impact forces. A rear-end hit can eject the rider from the bike, crush them between vehicles at intersections, or cause severe spinal hyperextension without a headrest to limit neck movement.',
            ),
            array(
                'question' => 'What injuries are common in rear-end motorcycle accidents?',
                'answer'   => 'Common injuries include spinal cord injuries, traumatic brain injuries from being ejected, broken vertebrae and neck injuries, pelvic fractures, road rash from sliding on pavement, and crush injuries when pinned between vehicles. These injuries are often far more severe than in car-on-car rear-end crashes.',
            ),
            array(
                'question' => 'What if I was rear-ended at a red light on my motorcycle?',
                'answer'   => 'Being rear-ended while lawfully stopped at a red light or stop sign is one of the clearest liability scenarios. The rear driver was not paying attention or following too closely. You should document the scene, get witness information, seek medical attention, and contact an attorney.',
            ),
            array(
                'question' => 'Can I recover damages if the driver says they didn\'t see my motorcycle?',
                'answer'   => 'Absolutely. "I didn\'t see the motorcycle" is not a legal defense — it\'s an admission of negligent driving. Drivers have a duty to watch for all vehicles on the road, including motorcycles. Failure to see what a reasonable driver would have seen is negligence.',
            ),
        ),
    ),

    /* ============================================================
       5. Hit & Run Motorcycle Accidents
       ============================================================ */
    array(
        'title'   => 'Hit &amp; Run Motorcycle Accident Lawyers',
        'slug'    => 'hit-and-run-motorcycle-accident',
        'excerpt' => 'Victim of a motorcycle hit and run? Even when the at-fault driver flees, you may have options for compensation. Our attorneys pursue every avenue of recovery for hit-and-run motorcycle crash victims.',
        'content' => <<<'HTML'
<h2>Hit &amp; Run Motorcycle Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Being involved in a motorcycle accident is traumatic enough — but when the driver who caused the crash flees the scene, victims face an additional layer of fear, frustration, and uncertainty. Hit-and-run crashes are a serious and growing problem, and motorcyclists are particularly vulnerable because these crashes often leave them injured and unable to pursue the fleeing vehicle. The <a href="https://www.aaafoundation.org/" target="_blank" rel="noopener">AAA Foundation for Traffic Safety</a> reports that hit-and-run crashes kill more than 2,000 people annually and injure hundreds of thousands more.</p>
<p>At Roden Law, our motorcycle accident lawyers help hit-and-run victims identify every possible source of compensation — even when the at-fault driver is never found. We pursue insurance claims, assist with police investigations, and explore all legal options available under Georgia and South Carolina law.</p>

<h2>Hit-and-Run Laws in Georgia and South Carolina</h2>
<p>Both states impose serious criminal penalties on drivers who flee the scene of an accident involving injuries:</p>
<ul>
<li><strong>Georgia:</strong> Under <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/section-40-6-270/" target="_blank" rel="noopener">O.C.G.A. § 40-6-270</a>, leaving the scene of an accident involving injury or death is a felony, punishable by up to 5 years in prison and fines. Drivers must stop, provide identification, and render reasonable assistance.</li>
<li><strong>South Carolina:</strong> Under <a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-1210</a>, leaving the scene of an accident involving injury is a felony carrying up to 10 years in prison and fines up to $10,000. Fatality hit-and-runs carry up to 25 years.</li>
</ul>

<h2>Recovering Compensation After a Hit-and-Run</h2>
<p>Even when the at-fault driver cannot be identified, hit-and-run motorcycle victims have several potential sources of compensation:</p>
<ul>
<li><strong>Uninsured Motorist (UM) coverage:</strong> This is the most important coverage for hit-and-run victims. Georgia requires insurers to offer UM coverage, and South Carolina requires it to be included in all auto policies unless rejected in writing. UM coverage steps in when the at-fault driver is unidentified or uninsured.</li>
<li><strong>Underinsured Motorist (UIM) coverage:</strong> If the driver is later found but has minimal insurance, UIM coverage makes up the difference</li>
<li><strong>Medical payments (MedPay) coverage:</strong> Available under your own auto policy regardless of fault, covering medical expenses up to policy limits</li>
<li><strong>Health insurance:</strong> Your personal health insurance can cover medical bills, subject to subrogation rights</li>
<li><strong>Crime victim compensation:</strong> Both Georgia and South Carolina have crime victim compensation programs that may help with certain expenses</li>
</ul>

<h2>Finding the At-Fault Driver</h2>
<p>Our attorneys work alongside law enforcement to identify hit-and-run drivers through traffic camera and surveillance footage, nearby business security cameras, vehicle debris and paint transfer analysis, witness canvassing, and social media and community tips. When the driver is found, we pursue direct claims against their liability insurance in addition to any UM/UIM claims already filed.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I get compensation if the hit-and-run driver is never found?',
                'answer'   => 'Yes. If you have Uninsured Motorist (UM) coverage on your own auto or motorcycle insurance policy, it covers hit-and-run crashes where the at-fault driver is unidentified. South Carolina requires UM coverage in all policies unless specifically rejected in writing. Georgia requires insurers to offer it.',
            ),
            array(
                'question' => 'What should I do immediately after a motorcycle hit-and-run?',
                'answer'   => 'Try to note any details about the fleeing vehicle — make, model, color, license plate, direction of travel. Call 911 immediately. Ask witnesses for their contact information and whether they got the plate number. Check for nearby security cameras. Seek medical attention and contact an attorney promptly.',
            ),
            array(
                'question' => 'Is a hit-and-run a felony in Georgia and South Carolina?',
                'answer'   => 'Yes. In Georgia, leaving the scene of an accident involving injury or death is a felony (O.C.G.A. § 40-6-270) punishable by up to 5 years in prison. In South Carolina, it carries up to 10 years for injury and up to 25 years for fatality (S.C. Code § 56-5-1210).',
            ),
            array(
                'question' => 'What is Uninsured Motorist coverage and do I have it?',
                'answer'   => 'Uninsured Motorist (UM) coverage is a type of auto insurance that protects you when the at-fault driver has no insurance or cannot be identified (hit-and-run). South Carolina requires it in all policies. Georgia requires insurers to offer it. Check your policy or ask your insurance agent.',
            ),
            array(
                'question' => 'How long do I have to report a hit-and-run motorcycle accident?',
                'answer'   => 'Report it to police immediately. For insurance claims, most policies require prompt notice — typically within days, not weeks. The statute of limitations for filing a civil claim is 2 years in Georgia and 3 years in South Carolina, but don\'t wait — early action preserves evidence and strengthens your case.',
            ),
        ),
    ),

    /* ============================================================
       6. Drunk Driver vs. Motorcycle Accidents
       ============================================================ */
    array(
        'title'   => 'Drunk Driver vs. Motorcycle Accident Lawyers',
        'slug'    => 'drunk-driver-motorcycle-accident',
        'excerpt' => 'Struck by a drunk driver while on your motorcycle? Impaired drivers cause devastating motorcycle crashes. Our attorneys pursue maximum compensation including punitive damages from drunk drivers.',
        'content' => <<<'HTML'
<h2>Drunk Driver vs. Motorcycle Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>When an impaired driver strikes a motorcyclist, the results are almost always catastrophic. Motorcyclists have no surrounding vehicle structure, seatbelts, or airbags to protect them — making them extremely vulnerable to the reckless behavior of drunk drivers. The <a href="https://www.nhtsa.gov/risky-driving/drunk-driving" target="_blank" rel="noopener">NHTSA</a> reports that approximately 27% of motorcyclists killed in crashes had a BAC above 0.08%, but many more motorcycle fatalities are caused by <em>other</em> impaired drivers who strike riders.</p>
<p>At Roden Law, our motorcycle accident lawyers aggressively pursue drunk driver cases because they represent some of the most preventable and egregious crashes on the road. We seek maximum compensation — including punitive damages — to hold impaired drivers fully accountable for the devastation they cause.</p>

<h2>DUI Laws in Georgia and South Carolina</h2>
<p>Both states set the legal blood alcohol concentration (BAC) limit at 0.08% for drivers 21 and older:</p>
<ul>
<li><strong>Georgia DUI law:</strong> <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-15/section-40-6-391/" target="_blank" rel="noopener">O.C.G.A. § 40-6-391</a> prohibits driving with a BAC of 0.08% or higher, or while under the influence of any substance that impairs driving ability. Serious injury by vehicle while DUI is a felony carrying 1-15 years in prison.</li>
<li><strong>South Carolina DUI law:</strong> <a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-2930</a> prohibits driving with a BAC of 0.08% or higher. Felony DUI resulting in great bodily injury carries up to 15 years in prison.</li>
</ul>

<h2>Why Drunk Drivers Are Especially Dangerous to Motorcyclists</h2>
<p>Alcohol impairment affects every skill needed to safely share the road with motorcycles:</p>
<ul>
<li><strong>Impaired visual scanning:</strong> Drunk drivers are less likely to scan for smaller vehicles like motorcycles at intersections and lane changes</li>
<li><strong>Delayed reaction time:</strong> Even moderate impairment significantly increases reaction time, making it impossible to avoid a motorcycle that the driver notices late</li>
<li><strong>Lane drift:</strong> Impaired drivers frequently weave and drift across lane markings, putting motorcyclists in adjacent lanes at risk</li>
<li><strong>Speed misjudgment:</strong> Alcohol impairs the ability to judge the speed and distance of oncoming motorcycles, especially at intersections</li>
<li><strong>Aggressive driving:</strong> Some impaired drivers exhibit aggressive behavior including tailgating, speeding, and improper passing</li>
</ul>

<h2>Punitive Damages in Drunk Driving Motorcycle Crashes</h2>
<p>Drunk driving motorcycle crashes often support claims for <strong>punitive damages</strong> — additional damages designed to punish the wrongdoer and deter similar conduct:</p>
<ul>
<li><strong>Georgia:</strong> <a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-5-1/" target="_blank" rel="noopener">O.C.G.A. § 51-12-5.1</a> allows punitive damages for willful misconduct, fraud, or wanton disregard for the rights and safety of others. Driving drunk is strong evidence of conscious indifference. Georgia caps punitive damages at $250,000 in most cases, with exceptions.</li>
<li><strong>South Carolina:</strong> Punitive damages are available for reckless, willful, or grossly negligent conduct. A DUI conviction provides compelling evidence supporting punitive damages.</li>
</ul>
<p>In addition to punitive damages, our attorneys also investigate potential <strong>dram shop liability</strong> claims against bars, restaurants, and other establishments that illegally served alcohol to the visibly intoxicated driver. Georgia's dram shop law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-4/" target="_blank" rel="noopener">O.C.G.A. § 51-1-40</a>) and South Carolina's statute (<a href="https://www.scstatehouse.gov/code/t61c004.php" target="_blank" rel="noopener">S.C. Code § 61-4-580</a>) allow claims against establishments that served a visibly intoxicated person who then caused injury.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I get punitive damages if a drunk driver hit me on my motorcycle?',
                'answer'   => 'Yes. Both Georgia and South Carolina allow punitive damages in drunk driving cases. Georgia law (O.C.G.A. § 51-12-5.1) permits punitive damages for willful misconduct or conscious disregard for safety, which driving drunk clearly demonstrates. These damages are in addition to compensatory damages for your injuries.',
            ),
            array(
                'question' => 'Can I sue the bar that served the drunk driver?',
                'answer'   => 'Potentially, yes. Georgia\'s dram shop law (O.C.G.A. § 51-1-40) and South Carolina\'s statute (S.C. Code § 61-4-580) allow claims against establishments that served alcohol to a visibly intoxicated person who then caused injury. These claims require evidence that the patron was noticeably intoxicated when served.',
            ),
            array(
                'question' => 'Does a DUI conviction help my civil injury case?',
                'answer'   => 'A DUI conviction or guilty plea is strong evidence of negligence in your civil case. While a criminal case and civil case are separate proceedings, the conviction can be used to establish that the driver was impaired and acting recklessly at the time of the crash.',
            ),
            array(
                'question' => 'What if the drunk driver had no insurance?',
                'answer'   => 'Your own Uninsured/Underinsured Motorist (UM/UIM) coverage can provide compensation when the at-fault driver lacks adequate insurance. Additionally, if a bar or restaurant over-served the driver, their commercial liability insurance may provide another source of recovery through a dram shop claim.',
            ),
            array(
                'question' => 'How much compensation can I recover from a drunk driving motorcycle crash?',
                'answer'   => 'Compensation depends on injury severity but can be substantial — including medical expenses, lost wages, pain and suffering, permanent disability, and punitive damages. Drunk driving cases often result in higher settlements and verdicts due to the egregious nature of the conduct and the availability of punitive damages.',
            ),
        ),
    ),

    /* ============================================================
       7. Intersection Motorcycle Accidents
       ============================================================ */
    array(
        'title'   => 'Intersection Motorcycle Accident Lawyers',
        'slug'    => 'intersection-motorcycle-accident',
        'excerpt' => 'Intersections are the most dangerous places for motorcyclists. From red-light runners to drivers who fail to yield, our attorneys fight for riders injured at intersections across Georgia and South Carolina.',
        'content' => <<<'HTML'
<h2>Intersection Motorcycle Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Intersections are the most dangerous locations for motorcyclists. The convergence of multiple traffic streams, turning movements, traffic signals, and competing right-of-way creates an environment where motorcycle crashes occur with alarming frequency. The <a href="https://www.nhtsa.gov/road-safety/motorcycles" target="_blank" rel="noopener">NHTSA</a> data shows that a significant majority of motorcycle-vehicle crashes occur at or near intersections, with the most common scenario being another vehicle violating the motorcycle's right of way.</p>
<p>At Roden Law, our motorcycle accident lawyers handle intersection crash cases throughout Georgia and South Carolina. We understand the complex liability issues these cases present and fight to ensure that negligent drivers are held accountable for the injuries they cause.</p>

<h2>Why Intersections Are So Dangerous for Motorcyclists</h2>
<p>Several factors combine to make intersections uniquely hazardous for motorcycle riders:</p>
<ul>
<li><strong>Visibility challenges:</strong> Motorcycles are smaller and harder to see, especially among larger vehicles at busy intersections. A-pillar blind spots in cars can completely hide a motorcycle from the other driver's view.</li>
<li><strong>Multiple conflict points:</strong> At a typical four-way intersection, there are 32 potential conflict points where vehicles can collide — and motorcycles are at risk at every one</li>
<li><strong>Right-of-way violations:</strong> Drivers who run red lights, roll through stop signs, or fail to yield when turning create immediate life-threatening hazards for approaching motorcycles</li>
<li><strong>Complex traffic patterns:</strong> Multi-lane intersections, turn lanes, and simultaneous signal phases create confusion that leads to crashes</li>
</ul>

<h2>Common Intersection Crash Scenarios</h2>
<p>Our attorneys handle all types of intersection motorcycle accidents:</p>
<ul>
<li><strong><a href="/motorcycle-accident-lawyers/left-turn-accident/">Left-turn collisions:</a></strong> The most common pattern — a driver turns left in front of an oncoming motorcycle. See our dedicated page on <a href="/motorcycle-accident-lawyers/left-turn-accident/">left-turn motorcycle accidents</a>.</li>
<li><strong>Red-light and stop-sign violations:</strong> Drivers who blow through red lights or roll through stop signs, striking a motorcyclist who had the green light or right of way</li>
<li><strong>Right-turn-on-red crashes:</strong> Drivers making a right turn on red who fail to see an approaching motorcycle in the cross-traffic lane</li>
<li><strong>T-bone collisions:</strong> A vehicle strikes the side of a motorcycle — or vice versa — when one party fails to yield at an intersection</li>
<li><strong><a href="/motorcycle-accident-lawyers/rear-end-motorcycle-accident/">Rear-end crashes at red lights:</a></strong> A distracted driver fails to stop and strikes a motorcycle waiting at a red light. Learn more about <a href="/motorcycle-accident-lawyers/rear-end-motorcycle-accident/">rear-end motorcycle accidents</a>.</li>
</ul>

<h2>Proving Fault in Intersection Motorcycle Crashes</h2>
<p>Determining fault at intersections often comes down to which party had the right of way. Critical evidence includes:</p>
<ul>
<li><strong>Traffic camera footage:</strong> Many Georgia and South Carolina intersections have traffic cameras that capture signal timing and vehicle movements</li>
<li><strong>Red-light camera data:</strong> Where available, this directly proves whether a driver ran a red light</li>
<li><strong>Witness testimony:</strong> Other drivers, passengers, and pedestrians who observed the crash</li>
<li><strong>Signal timing records:</strong> Traffic engineering data showing exact signal phase timing</li>
<li><strong>Vehicle damage patterns:</strong> The location and angle of damage can confirm the direction of travel and who entered the intersection first</li>
</ul>
<p>Georgia traffic law (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/" target="_blank" rel="noopener">O.C.G.A. Title 40, Chapter 6</a>) establishes clear right-of-way rules at intersections. Violating these rules creates a presumption of negligence. Our attorneys use this statutory framework, combined with physical and testimonial evidence, to build strong liability cases for our motorcycle clients.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Why do so many motorcycle accidents happen at intersections?',
                'answer'   => 'Intersections have multiple conflict points where vehicles cross paths, and motorcycles\' smaller profile makes them harder to see among larger vehicles. The most common crash pattern is another driver turning left in front of an oncoming motorcycle — accounting for about 42% of motorcycle-vehicle fatalities.',
            ),
            array(
                'question' => 'What should I do after a motorcycle crash at an intersection?',
                'answer'   => 'Call 911, get medical attention, and document the scene thoroughly — photograph traffic signals, lane markings, vehicle positions, and damage. Get witness contact information. Note whether there are traffic cameras at the intersection. Do not admit fault, and contact an attorney before giving statements to insurers.',
            ),
            array(
                'question' => 'How do you prove who had the right of way at an intersection?',
                'answer'   => 'Evidence includes traffic camera footage, red-light camera data, witness testimony, signal timing records, vehicle damage patterns, skid marks, and debris location. Georgia and South Carolina traffic laws clearly define right-of-way rules, and violating them creates a presumption of negligence.',
            ),
            array(
                'question' => 'Can intersection design contribute to motorcycle crashes?',
                'answer'   => 'Yes. Poorly designed intersections — with inadequate sight lines, confusing lane markings, short yellow-light timing, or lack of dedicated turn signals — can contribute to crashes. In some cases, the government entity responsible for the intersection may share liability.',
            ),
            array(
                'question' => 'What if a driver ran a red light and hit my motorcycle?',
                'answer'   => 'Running a red light is a clear traffic violation that establishes negligence. If traffic cameras or witnesses confirm the violation, the at-fault driver bears virtually all liability. Our attorneys obtain camera footage and signal timing data to prove these cases definitively.',
            ),
        ),
    ),

    /* ============================================================
       8. Single-Vehicle Motorcycle Crashes
       ============================================================ */
    array(
        'title'   => 'Single-Vehicle Motorcycle Crash Lawyers',
        'slug'    => 'single-vehicle-motorcycle-crash',
        'excerpt' => 'Injured in a single-vehicle motorcycle crash? Road defects, debris, mechanical failures, and hazardous conditions may mean another party is liable. Our attorneys investigate and pursue all responsible parties.',
        'content' => <<<'HTML'
<h2>Single-Vehicle Motorcycle Crash Lawyers in Georgia &amp; South Carolina</h2>
<p>Not every motorcycle accident involves a collision with another vehicle. Single-vehicle motorcycle crashes — where a rider goes down without being struck by another motorist — account for a significant portion of motorcycle injuries and fatalities. While these crashes are often assumed to be entirely the rider's fault, the reality is frequently more complex. Road defects, debris, vehicle mechanical failures, and hazardous conditions created by government agencies or other parties may be the true cause.</p>
<p>At Roden Law, our motorcycle accident lawyers investigate single-vehicle crashes to identify all potentially liable parties. If a road defect, defective motorcycle part, or another party's negligence caused or contributed to your crash, you may be entitled to significant compensation.</p>

<h2>Common Causes of Single-Vehicle Motorcycle Crashes</h2>
<p>Our investigation of single-vehicle motorcycle crashes frequently reveals third-party liability:</p>
<ul>
<li><strong>Road defects and hazards:</strong> Potholes, uneven pavement, broken road surfaces, missing manhole covers, and expansion joint gaps are particularly dangerous for two-wheeled vehicles. Motorcycles are far more sensitive to road surface defects than cars.</li>
<li><strong>Gravel, sand, and debris:</strong> Loose gravel on curves, sand washed across the road, oil spills, and debris from other vehicles can cause a motorcycle to lose traction instantly</li>
<li><strong>Inadequate road maintenance:</strong> Faded lane markings, missing guardrails, uncleared vegetation obscuring sight lines, and unrepaired road damage</li>
<li><strong>Dangerous road design:</strong> Improperly banked curves, abrupt lane narrowing, inadequate shoulder width, and poorly marked construction zones</li>
<li><strong>Motorcycle mechanical failure:</strong> Defective tires, brake failure, throttle malfunctions, steering defects, and other product defects that cause the rider to lose control</li>
<li><strong>Animals on the road:</strong> Deer, dogs, and other animals that cause a rider to crash while swerving or braking suddenly</li>
<li><strong>Phantom vehicles:</strong> A vehicle that causes the crash through its actions — cutting off the rider, dropping debris, or forcing evasive action — but is not directly struck</li>
</ul>

<h2>Government Liability for Road Defects</h2>
<p>When road defects or inadequate maintenance cause a motorcycle crash, the government entity responsible for that road may be liable. However, claims against government entities have specific procedural requirements:</p>
<ul>
<li><strong>Georgia:</strong> The Georgia Tort Claims Act (<a href="https://law.justia.com/codes/georgia/title-50/chapter-21/" target="_blank" rel="noopener">O.C.G.A. § 50-21-20 et seq.</a>) waives sovereign immunity for certain negligence claims against the state. An ante-litem notice must be filed within 12 months of the incident.</li>
<li><strong>South Carolina:</strong> The South Carolina Tort Claims Act (<a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">S.C. Code § 15-78-10 et seq.</a>) similarly allows negligence claims against government entities, with specific notice and filing requirements.</li>
</ul>
<p>Our attorneys must prove that the government entity knew or should have known about the dangerous condition and failed to repair it or warn motorists within a reasonable time.</p>

<h2>Product Liability in Motorcycle Defect Cases</h2>
<p>When a motorcycle component fails and causes a crash, the manufacturer may be liable under product liability law. Common defects include tire blowouts, brake system failures, throttle sticking, handlebar or steering defects, and fuel system leaks that cause fires. Both Georgia and South Carolina recognize claims for design defects, manufacturing defects, and failure to warn. Our attorneys work with motorcycle engineering experts to analyze the failed component and establish the manufacturer's liability.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I file a claim if my motorcycle crash didn\'t involve another vehicle?',
                'answer'   => 'Yes. If your crash was caused by a road defect, debris, defective motorcycle part, or another party\'s actions (like a driver who forced you to swerve), you may have a claim against the responsible party — even though no other vehicle was directly involved in the collision.',
            ),
            array(
                'question' => 'Who is responsible for road defects that cause motorcycle crashes?',
                'answer'   => 'The government entity responsible for maintaining the road — whether the Georgia DOT, SCDOT, county, or municipality — may be liable if they knew or should have known about a dangerous road condition and failed to repair it or warn motorists. Claims against the government have specific notice deadlines.',
            ),
            array(
                'question' => 'What is a "phantom vehicle" crash?',
                'answer'   => 'A phantom vehicle crash occurs when another vehicle causes you to crash — by cutting you off, dropping debris, or forcing evasive action — but is not directly struck and may leave the scene. These cases may be covered by your Uninsured Motorist coverage, similar to hit-and-run claims.',
            ),
            array(
                'question' => 'How do you prove a road defect caused my motorcycle crash?',
                'answer'   => 'Evidence includes photos and measurements of the road defect, government maintenance records, prior complaints about the same location, expert analysis of the crash dynamics, and sometimes testimony from other motorists who experienced the same hazard. Acting quickly to document the scene is critical.',
            ),
            array(
                'question' => 'Can I sue a motorcycle manufacturer for a defective part?',
                'answer'   => 'Yes. Both Georgia and South Carolina recognize product liability claims for design defects, manufacturing defects, and failure to warn. If a defective tire, brake, throttle, or other component caused your crash, the manufacturer can be held liable. An engineering expert can analyze the failed part.',
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
