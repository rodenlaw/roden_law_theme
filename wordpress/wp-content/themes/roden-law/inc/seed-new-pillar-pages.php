<?php
/**
 * Seeder: 4 New Pillar Practice Area Pages
 *
 * Creates: Bicycle Accident, Electric Scooter Accident, ATV/Side-by-Side Accident,
 *          Golf Cart Accident Lawyers
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-new-pillar-pages.php
 *
 * Idempotent — skips any post whose slug already exists.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

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
   Determine the practice_area post type slug
   ------------------------------------------------------------------ */

$pa_post_type = 'practice_area';
if ( ! post_type_exists( $pa_post_type ) ) {
    $pa_post_type = 'practice-area';
}
if ( ! post_type_exists( $pa_post_type ) ) {
    WP_CLI::error( 'Practice area post type not found.' );
    return;
}

/* ------------------------------------------------------------------
   Pillar definitions
   ------------------------------------------------------------------ */

$pillars = array(

    /* ============================================================
       1. Bicycle Accident Lawyers
       ============================================================ */
    array(
        'title'   => 'Bicycle Accident Lawyers',
        'slug'    => 'bicycle-accident-lawyers',
        'excerpt' => 'Injured in a bicycle accident in Georgia or South Carolina? Our attorneys fight for cyclists struck by negligent drivers, pursuing maximum compensation for medical bills, lost wages, and pain and suffering.',
        'hero_intro' => 'Cyclists are among the most vulnerable road users — fully exposed to the impact of multi-ton vehicles with no surrounding protection. When a negligent driver strikes a cyclist, the injuries are almost always severe. Our bicycle accident lawyers fight aggressively for riders throughout Georgia and South Carolina.',
        'why_hire' => '<p>Bicycle accident cases present unique challenges. Insurance companies routinely blame cyclists — claiming they weren\'t in a bike lane, ran a stop sign, weren\'t wearing a helmet, or were riding on the wrong side of the road. An experienced bicycle accident attorney knows how to dismantle these defenses and establish the driver\'s primary liability.</p><p>Georgia law (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-12/section-40-6-294/" target="_blank" rel="noopener">O.C.G.A. § 40-6-294</a>) grants bicyclists the same rights and duties as drivers of vehicles. The Georgia Safe Passing Law requires drivers to leave at least 3 feet of clearance when passing a bicycle. South Carolina law (<a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-3435</a>) similarly requires safe passing distance and grants cyclists full road rights.</p><p>Our attorneys handle cases involving distracted drivers, dooring incidents, right-hook turns, intersection collisions, and road hazard crashes. We investigate every angle — including whether defective road design, inadequate bike infrastructure, or vehicle defects contributed to the accident.</p>',
        'content' => <<<'HTML'
<h2>Bicycle Accident Lawyers Serving Georgia &amp; South Carolina</h2>
<p>Bicyclists face serious dangers on Georgia and South Carolina roads every day. Despite growing investment in cycling infrastructure, most roads in our region lack dedicated bike lanes, forcing cyclists to share space with distracted, speeding, and inattentive drivers. The <a href="https://www.nhtsa.gov/road-safety/bicycle-safety" target="_blank" rel="noopener">NHTSA</a> reports that nearly 1,000 bicyclists are killed in traffic crashes annually, and tens of thousands more are seriously injured.</p>
<p>At Roden Law, our bicycle accident lawyers represent injured cyclists throughout Georgia and South Carolina. We understand the specific traffic laws protecting cyclists, the common insurance company tactics used to deny bicycle claims, and the devastating injuries these crashes cause. If you or a loved one has been injured in a bicycle accident, we fight for full compensation — on a contingency fee basis with no upfront costs.</p>

<h2>Georgia &amp; South Carolina Bicycle Safety Laws</h2>
<p>Both states grant bicyclists the same rights and responsibilities as motor vehicle operators:</p>
<ul>
<li><strong>Georgia Safe Passing Law:</strong> <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-12/section-40-6-56/" target="_blank" rel="noopener">O.C.G.A. § 40-6-56</a> requires drivers to maintain a safe distance when passing a bicycle — generally interpreted as at least 3 feet of clearance</li>
<li><strong>Full lane use:</strong> Georgia law (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-12/section-40-6-294/" target="_blank" rel="noopener">O.C.G.A. § 40-6-294</a>) allows cyclists to use the full lane when necessary for safety, such as when the lane is too narrow to share</li>
<li><strong>South Carolina:</strong> <a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-3435</a> requires drivers to pass bicycles at a safe distance and grants cyclists all rights applicable to vehicle operators</li>
<li><strong>Helmet laws:</strong> Georgia requires helmets for riders under 16. South Carolina has no statewide bicycle helmet law. Not wearing a helmet does not bar an adult's claim.</li>
</ul>

<h2>Common Types of Bicycle Accidents</h2>
<p>Our attorneys handle the full range of bicycle-vehicle collisions:</p>
<ul>
<li><strong>Right-hook crashes:</strong> A driver turns right directly into the path of a cyclist traveling straight in a bike lane or on the shoulder</li>
<li><strong>Left-cross collisions:</strong> A driver turns left in front of an oncoming cyclist, failing to yield right of way</li>
<li><strong>Dooring accidents:</strong> A parked vehicle occupant opens their door into the path of an approaching cyclist</li>
<li><strong>Rear-end strikes:</strong> A driver strikes a cyclist from behind, often due to distraction, speeding, or failure to see the rider</li>
<li><strong>Intersection crashes:</strong> Drivers who run red lights, stop signs, or fail to yield to cyclists at intersections</li>
<li><strong>Road hazard crashes:</strong> Potholes, debris, drainage grates, and uneven pavement that cause a cyclist to crash — potentially involving government liability for road defects</li>
</ul>

<h2>Bicycle Accident Injuries</h2>
<p>Cyclists have no surrounding vehicle structure, seatbelt, or airbags for protection. Common injuries include traumatic brain injuries (even with a helmet), broken collarbones, wrists, and pelvis, road rash and severe skin abrasions, spinal cord injuries, internal organ damage, facial fractures and dental injuries, and wrongful death.</p>

<h2>Pursuing Maximum Compensation</h2>
<p>Our attorneys pursue claims against negligent drivers, their insurers, and any other liable parties — including government entities responsible for dangerous road conditions and manufacturers of defective bicycle or vehicle components. We recover compensation for all medical expenses, lost income, pain and suffering, permanent disability, and wrongful death under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/" target="_blank" rel="noopener">O.C.G.A. Title 51</a>) and South Carolina law.</p>
HTML,
        'category_name' => 'Bicycle Accidents',
        'category_slug' => 'bicycle-accidents',
        'sub_types' => array(
            'Dooring Accident',
            'Right-Hook & Left-Cross Collisions',
            'Intersection Bicycle Accidents',
            'Hit & Run Bicycle Accidents',
            'Road Hazard Bicycle Crashes',
            'Distracted Driver Bicycle Accidents',
            'Drunk Driver Bicycle Accidents',
            'Bicycle vs. Truck Accidents',
        ),
        'common_causes' => array(
            'Distracted driving (texting, phone use)',
            'Failure to check mirrors before turning right',
            'Drivers passing too closely (violating 3-foot law)',
            'Dooring — opening car doors into bike lanes',
            'Running red lights or stop signs at intersections',
            'Drunk or impaired driving',
            'Right-hook turns across bike lanes',
            'Left turns in front of oncoming cyclists',
            'Failure to see cyclists in blind spots',
            'Road hazards (potholes, debris, drainage grates)',
            'Speeding in areas with bicycle traffic',
            'Aggressive driving and road rage toward cyclists',
        ),
        'common_injuries' => array(
            array( 'name' => 'Traumatic Brain Injuries (TBI)', 'description' => 'Even with a helmet, the impact of a vehicle collision can cause severe concussions, skull fractures, and brain bleeding. Without a helmet, TBI risk increases dramatically. Brain injuries can result in permanent cognitive, behavioral, and motor impairments.' ),
            array( 'name' => 'Broken Collarbones and Shoulder Injuries', 'description' => 'Clavicle fractures are the most common cycling injury. The impact of hitting the ground or a vehicle concentrates force on the shoulder, frequently breaking the collarbone and damaging the rotator cuff.' ),
            array( 'name' => 'Spinal Cord Injuries', 'description' => 'Being thrown from a bicycle onto a vehicle or pavement can cause vertebral fractures, herniated discs, and spinal cord damage resulting in partial or complete paralysis.' ),
            array( 'name' => 'Road Rash and Skin Injuries', 'description' => 'Sliding across pavement causes severe abrasion injuries that can penetrate through skin and muscle. Severe road rash often requires skin grafts and leaves permanent scarring.' ),
            array( 'name' => 'Fractures (Wrist, Pelvis, Leg)', 'description' => 'Impact with a vehicle or the ground commonly fractures wrists (from bracing for impact), pelvic bones, femurs, and tibias. Many require surgical repair with plates, screws, or rods.' ),
            array( 'name' => 'Facial and Dental Injuries', 'description' => 'Cyclists often strike the ground or vehicle face-first, causing jaw fractures, broken teeth, orbital fractures, and facial lacerations that require reconstructive surgery.' ),
            array( 'name' => 'Internal Organ Damage', 'description' => 'Blunt force impact to the torso can rupture the spleen, lacerate the liver, or damage kidneys. Internal injuries may not be immediately apparent and require emergency surgical intervention.' ),
            array( 'name' => 'Wrongful Death', 'description' => 'Bicycle accidents are disproportionately fatal due to the lack of protection. The NHTSA reports nearly 1,000 cyclist fatalities annually. Surviving families may pursue wrongful death claims for their loss.' ),
        ),
        'faqs' => array(
            array( 'question' => 'Do bicyclists have the same rights as cars on the road?', 'answer' => 'Yes. Georgia law (O.C.G.A. § 40-6-294) and South Carolina law grant bicyclists the same rights and duties as motor vehicle operators. Cyclists may use the full lane when necessary for safety and are entitled to right of way at intersections just like any other vehicle.' ),
            array( 'question' => 'What is the safe passing law for bicycles?', 'answer' => 'Georgia requires drivers to pass bicycles at a safe distance, generally interpreted as at least 3 feet. South Carolina (S.C. Code § 56-5-3435) similarly requires a safe passing distance. Violating these laws while causing a crash is strong evidence of negligence.' ),
            array( 'question' => 'Does not wearing a helmet bar my bicycle accident claim?', 'answer' => 'No. Georgia only requires helmets for riders under 16, and South Carolina has no statewide helmet law. Not wearing a helmet does not bar an adult\'s claim, though it may be raised as comparative fault for head injuries. You can still recover damages.' ),
            array( 'question' => 'What is a dooring accident?', 'answer' => 'A dooring accident occurs when someone in a parked car opens their door into the path of an approaching cyclist. The cyclist may strike the door directly or swerve into traffic to avoid it. The person who opened the door is liable for failing to check for approaching traffic.' ),
            array( 'question' => 'Can I sue the city for a road hazard that caused my bicycle crash?', 'answer' => 'Yes. If a pothole, drainage grate, uneven pavement, or debris caused your crash, the government entity responsible for road maintenance may be liable. Claims must follow Georgia\'s or South Carolina\'s Tort Claims Act procedures with specific notice deadlines.' ),
            array( 'question' => 'How long do I have to file a bicycle accident claim?', 'answer' => 'Georgia has a 2-year statute of limitations (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Act quickly to preserve evidence — surveillance footage is often overwritten within days.' ),
            array( 'question' => 'What should I do after being hit while riding my bicycle?', 'answer' => 'Call 911 and get medical attention immediately. Document the scene with photos of your injuries, bicycle damage, the vehicle, and the road conditions. Get the driver\'s insurance information and witness contact details. Do not admit fault or give recorded statements to the driver\'s insurer before consulting an attorney.' ),
            array( 'question' => 'What compensation can I recover after a bicycle accident?', 'answer' => 'Victims may recover medical expenses, lost wages, pain and suffering, permanent disability, bicycle replacement and property damage, disfigurement, and loss of enjoyment of life. Wrongful death claims are available for surviving families. Punitive damages may apply in drunk driving or egregious negligence cases.' ),
        ),
    ),

    /* ============================================================
       2. Electric Scooter Accident Lawyers
       ============================================================ */
    array(
        'title'   => 'Electric Scooter Accident Lawyers',
        'slug'    => 'electric-scooter-accident-lawyers',
        'excerpt' => 'Injured in an electric scooter accident in Georgia or South Carolina? Whether you were riding a scooter or struck by one, our attorneys handle e-scooter crash claims against negligent drivers, scooter companies, and municipalities.',
        'hero_intro' => 'Electric scooters have rapidly expanded across Georgia and South Carolina, but safety infrastructure and regulations have not kept pace. E-scooter riders face the same hazards as cyclists — with even less protection and stability. When negligent drivers, defective scooters, or dangerous road conditions cause crashes, our attorneys fight for full compensation.',
        'why_hire' => '<p>Electric scooter accident cases involve unique legal complexities. Liability may fall on the negligent driver who struck the rider, the scooter rental company (Lime, Bird, Spin) for equipment defects or inadequate maintenance, the municipality for dangerous road conditions, or the rider\'s own insurance for UM/UIM coverage.</p><p>Georgia classifies electric scooters as "electric personal transporters" under <a href="https://law.justia.com/codes/georgia/title-40/chapter-1/section-40-1-1/" target="_blank" rel="noopener">O.C.G.A. § 40-1-1(15.4)</a> and regulates their use under <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-12/section-40-6-320/" target="_blank" rel="noopener">O.C.G.A. § 40-6-320 et seq.</a>, limiting riders to 20 mph and requiring use on streets (not sidewalks in many municipalities). South Carolina has addressed e-scooters through local ordinances in cities like Charleston and Columbia.</p><p>Our attorneys understand the intersection of traffic law, product liability, premises liability, and municipal regulation that these cases require. We identify every liable party and every source of insurance coverage to maximize your recovery.</p>',
        'content' => <<<'HTML'
<h2>Electric Scooter Accident Lawyers Serving Georgia &amp; South Carolina</h2>
<p>Electric scooters from companies like Lime, Bird, and Spin have become a common sight in cities across Georgia and South Carolina — including Savannah, Charleston, Columbia, and Myrtle Beach. While e-scooters offer convenient short-distance transportation, they also create significant safety risks. Riders stand on a small platform with tiny wheels, no seatbelt, no surrounding structure, and limited stability — sharing the road with multi-ton vehicles traveling at much higher speeds.</p>
<p>The <a href="https://www.cdc.gov/mmwr/volumes/69/wr/mm6908a1.htm" target="_blank" rel="noopener">CDC</a> and the <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">Consumer Product Safety Commission (CPSC)</a> have documented a surge in e-scooter injuries since rental scooters became widespread. Head injuries, fractures, and road rash are the most common injuries, with many crashes involving motor vehicles.</p>

<h2>Georgia &amp; South Carolina E-Scooter Laws</h2>
<ul>
<li><strong>Georgia:</strong> Electric scooters are regulated under <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-12/section-40-6-320/" target="_blank" rel="noopener">O.C.G.A. § 40-6-320 et seq.</a>. Riders must be at least 15 years old (or 16 for rental scooters). Maximum speed is 20 mph. Scooters are prohibited on sidewalks in cities that have adopted ordinances restricting sidewalk use. Helmets are not required for adults but are recommended.</li>
<li><strong>South Carolina:</strong> E-scooter regulation varies by municipality. Charleston, Columbia, and other cities have adopted local ordinances governing speed limits, parking, riding areas, and helmet requirements. State law treats e-scooters similarly to bicycles in many contexts.</li>
</ul>

<h2>Who Is Liable in an E-Scooter Accident?</h2>
<p>E-scooter accident liability can be complex, potentially involving multiple parties:</p>
<ul>
<li><strong>Negligent drivers:</strong> Cars, trucks, and buses that strike scooter riders through distraction, failure to yield, or aggressive driving</li>
<li><strong>Scooter rental companies:</strong> Lime, Bird, Spin, and other operators may be liable for defective equipment, inadequate maintenance, or failure to warn riders of known hazards. Their rental agreements contain arbitration clauses that an attorney can challenge.</li>
<li><strong>Municipalities:</strong> Cities that authorized scooter programs without adequate infrastructure (bike lanes, designated riding zones) or that maintain dangerous road conditions may share liability</li>
<li><strong>Product manufacturers:</strong> Defective brakes, throttle malfunctions, battery fires, and structural failures are product liability claims against the scooter manufacturer</li>
<li><strong>Pedestrians:</strong> When a scooter rider injures a pedestrian on a sidewalk or shared path, the rider may be liable</li>
</ul>

<h2>Common E-Scooter Injuries</h2>
<p>E-scooter crashes produce injuries similar to bicycle accidents, but the small wheel size makes scooters especially susceptible to road surface hazards. Common injuries include traumatic brain injuries, broken wrists and arms (from bracing falls), facial injuries, ankle and knee fractures, road rash, and spinal injuries. When a motor vehicle is involved, the severity increases dramatically.</p>

<h2>Compensation for E-Scooter Accident Victims</h2>
<p>Our attorneys pursue all available sources of compensation — the at-fault driver's liability insurance, the scooter company's commercial policy, the rider's own UM/UIM coverage, and government entity liability where applicable. We recover damages for medical expenses, lost wages, pain and suffering, permanent disability, and disfigurement under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/" target="_blank" rel="noopener">O.C.G.A. Title 51</a>) and South Carolina law.</p>
HTML,
        'category_name' => 'Electric Scooter Accidents',
        'category_slug' => 'electric-scooter-accidents',
        'sub_types' => array(
            'E-Scooter vs. Vehicle Collisions',
            'Scooter Malfunction & Defect Accidents',
            'Road Hazard E-Scooter Crashes',
            'E-Scooter Pedestrian Accidents',
            'Ride-Share Scooter (Lime, Bird) Accidents',
            'E-Scooter Intersection Crashes',
        ),
        'common_causes' => array(
            'Distracted drivers striking scooter riders',
            'Drivers failing to yield to scooters at intersections',
            'Dooring — opening car doors into scooter path',
            'Road hazards (potholes, uneven pavement, grates)',
            'Defective scooter brakes or throttle malfunctions',
            'Impaired or drunk drivers',
            'Scooter mechanical failure or battery defects',
            'Inadequate cycling/scooter infrastructure',
            'Rider inexperience combined with traffic exposure',
            'Speeding in areas with scooter traffic',
        ),
        'common_injuries' => array(
            array( 'name' => 'Traumatic Brain Injuries (TBI)', 'description' => 'Head injuries are the most common serious e-scooter injury. Most rental scooters do not provide helmets, and many riders do not wear them. Even low-speed falls can cause concussions, skull fractures, and severe brain damage.' ),
            array( 'name' => 'Broken Wrists and Arms', 'description' => 'The instinctive reaction to a fall is to brace with the hands. This concentrates the impact force on the wrists and forearms, causing fractures that frequently require surgical repair with plates and screws.' ),
            array( 'name' => 'Facial Injuries and Dental Damage', 'description' => 'Scooter riders falling forward over the handlebars often strike the ground face-first, causing jaw fractures, broken teeth, orbital fractures, and facial lacerations requiring reconstructive surgery.' ),
            array( 'name' => 'Road Rash and Skin Injuries', 'description' => 'Sliding on pavement after an e-scooter crash causes severe abrasion injuries. Scooter riders typically wear minimal protective clothing, making deep road rash common even at low speeds.' ),
            array( 'name' => 'Ankle and Knee Fractures', 'description' => 'The scooter platform is close to the ground, and riders\' feet and ankles are exposed. Impacts with vehicles, curbs, or the ground frequently fracture ankles, knees, and lower legs.' ),
            array( 'name' => 'Spinal Cord Injuries', 'description' => 'Being thrown from a scooter by a vehicle impact or sudden stop can cause vertebral fractures and spinal cord damage, potentially resulting in paralysis and lifelong disability.' ),
        ),
        'faqs' => array(
            array( 'question' => 'Are electric scooters legal in Georgia?', 'answer' => 'Yes. Georgia regulates e-scooters under O.C.G.A. § 40-6-320 et seq. Riders must be at least 15 (16 for rentals). Maximum speed is 20 mph. Many cities, including Savannah, have additional local ordinances governing where scooters can operate.' ),
            array( 'question' => 'Can I sue the scooter company (Lime, Bird) if the scooter malfunctioned?', 'answer' => 'Yes. If a brake failure, throttle malfunction, structural defect, or battery issue caused your crash, the scooter company and/or manufacturer may be liable under product liability law. Their rental agreements contain arbitration clauses, but an attorney can often challenge these provisions.' ),
            array( 'question' => 'What if a car hit me while I was riding an e-scooter?', 'answer' => 'The driver is liable if they were negligent — distracted, failed to yield, turned into your path, or otherwise violated traffic laws. E-scooter riders generally have the same road rights as bicyclists. Your claim would be against the driver\'s auto liability insurance.' ),
            array( 'question' => 'Does my auto insurance cover an e-scooter accident?', 'answer' => 'Your auto policy\'s Uninsured/Underinsured Motorist (UM/UIM) coverage and Medical Payments (MedPay) may cover you as an e-scooter rider, similar to coverage for pedestrians and cyclists. Check your policy or ask your insurance agent.' ),
            array( 'question' => 'Do I have to wear a helmet on an electric scooter?', 'answer' => 'Georgia does not require helmets for adult e-scooter riders, but strongly recommends them. Some South Carolina municipalities require helmets for scooter riders. Not wearing a helmet does not bar your claim, but may be raised as comparative fault for head injuries.' ),
            array( 'question' => 'How long do I have to file an e-scooter accident claim?', 'answer' => 'Georgia has a 2-year statute of limitations (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). If a government entity is involved, shorter notice deadlines may apply under the state tort claims acts.' ),
        ),
    ),

    /* ============================================================
       3. ATV & Side-by-Side Accident Lawyers
       ============================================================ */
    array(
        'title'   => 'ATV &amp; Side-by-Side Accident Lawyers',
        'slug'    => 'atv-side-by-side-accident-lawyers',
        'excerpt' => 'Injured in an ATV or side-by-side (UTV) accident in Georgia or South Carolina? Whether caused by a defective vehicle, negligent driver, or dangerous property, our attorneys pursue maximum compensation.',
        'hero_intro' => 'ATVs and side-by-sides (UTVs) are popular across Georgia and South Carolina for recreation, farming, and off-road work — but they cause thousands of serious injuries every year. Rollovers, collisions, ejections, and product defects make these vehicles uniquely dangerous. Our attorneys fight for ATV and UTV crash victims throughout both states.',
        'why_hire' => '<p>ATV and side-by-side accident cases involve a distinct set of legal issues. Unlike car accidents, ATV crashes may occur on private property, off-road trails, or rural roads without traditional traffic laws. Liability may involve product defects, property owner negligence, or the actions of other riders.</p><p>The <a href="https://www.cpsc.gov/Safety-Education/Safety-Guides/Sports-Fitness-and-Recreation/ATVs" target="_blank" rel="noopener">Consumer Product Safety Commission (CPSC)</a> tracks ATV injuries and fatalities closely, reporting approximately 100,000 ATV-related emergency room visits and hundreds of deaths annually. Children under 16 account for a disproportionate share of ATV fatalities.</p><p>Our attorneys handle ATV cases involving manufacturer defects (rollovers, steering failures, throttle malfunctions), negligent property owners, rental operators who provide inadequate safety equipment or instruction, and collisions with motor vehicles on public roads. We pursue every liable party to maximize compensation.</p>',
        'content' => <<<'HTML'
<h2>ATV &amp; Side-by-Side Accident Lawyers Serving Georgia &amp; South Carolina</h2>
<p>All-terrain vehicles (ATVs) and side-by-side utility vehicles (UTVs/SxS) are a way of life throughout rural Georgia and South Carolina — used for recreation, hunting, farming, and property maintenance. But these powerful off-road vehicles cause devastating injuries when things go wrong. The <a href="https://www.cpsc.gov/Safety-Education/Safety-Guides/Sports-Fitness-and-Recreation/ATVs" target="_blank" rel="noopener">CPSC</a> reports approximately 100,000 ATV-related emergency department visits annually, with hundreds of deaths each year.</p>
<p>At Roden Law, our ATV accident lawyers represent victims injured by defective vehicles, negligent property owners, reckless operators, and rental companies that fail to provide adequate safety equipment throughout Georgia and South Carolina.</p>

<h2>Georgia &amp; South Carolina ATV Laws</h2>
<ul>
<li><strong>Georgia:</strong> <a href="https://law.justia.com/codes/georgia/title-40/chapter-7/article-5/" target="_blank" rel="noopener">O.C.G.A. § 40-7-120 et seq.</a> restricts ATV use on public roads to specific circumstances (agricultural use, certain crossings). Children under 16 may not operate ATVs on public property without supervision. ATVs are not street-legal in Georgia without specific modifications and registration.</li>
<li><strong>South Carolina:</strong> South Carolina law restricts ATV operation on public roads and highways. Children under certain ages must be supervised and may only operate age-appropriate ATVs. Local jurisdictions may have additional restrictions.</li>
</ul>

<h2>Common Types of ATV &amp; Side-by-Side Accidents</h2>
<ul>
<li><strong>Rollovers:</strong> The most common cause of serious ATV injuries. ATVs have a high center of gravity and narrow wheelbase, making them prone to rolling over on slopes, uneven terrain, and during sharp turns. Side-by-sides offer more stability but can still roll on steep terrain.</li>
<li><strong>Ejections:</strong> ATVs lack seatbelts and restraint systems, and riders are frequently ejected during crashes. Side-by-sides have seatbelts, but riders who fail to use them — or whose belts malfunction — are at severe risk.</li>
<li><strong>Collisions with motor vehicles:</strong> ATVs operated on or crossing public roads are at risk of collisions with cars and trucks, especially at dusk and on rural roads with limited visibility</li>
<li><strong>Collisions with fixed objects:</strong> Trees, fences, rocks, and ditches cause serious injuries when riders lose control or cannot stop</li>
<li><strong>Mechanical failure:</strong> Defective throttles, steering systems, brakes, and suspension components that cause loss of control</li>
<li><strong>Passenger injuries:</strong> ATVs designed for one rider are frequently overloaded with passengers, dramatically increasing crash risk</li>
<li><strong>Child injuries:</strong> Children operating adult-sized ATVs, riding without helmets, or riding unsupervised account for a disproportionate share of fatalities</li>
</ul>

<h2>Product Liability in ATV Cases</h2>
<p>Many ATV crashes are caused or worsened by design and manufacturing defects. The CPSC has issued numerous safety warnings and recalls for ATV models with defective throttle mechanisms, steering failures, and inadequate rollover protection. Both Georgia and South Carolina recognize product liability claims for design defects, manufacturing defects, and failure to warn. Our attorneys work with engineering experts to identify defective components and pursue claims against manufacturers including Polaris, Honda, Yamaha, Can-Am, and others.</p>

<h2>Property Owner and Rental Operator Liability</h2>
<p>Property owners who allow ATV use on their land may be liable if they fail to warn of known hazards (ditches, drop-offs, barbed wire). ATV rental and tour operators have a duty to provide properly maintained equipment, helmets and safety gear, adequate safety instruction, and age-appropriate vehicles. When they fail in these duties, they are liable for resulting injuries.</p>

<h2>Pursuing Compensation</h2>
<p>Our attorneys pursue claims against all liable parties — manufacturers, property owners, rental operators, and negligent riders — to recover full compensation under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/" target="_blank" rel="noopener">O.C.G.A. Title 51</a>) and South Carolina law, including medical expenses, lost wages, pain and suffering, permanent disability, and wrongful death.</p>
HTML,
        'category_name' => 'ATV & Side-by-Side Accidents',
        'category_slug' => 'atv-accidents',
        'sub_types' => array(
            'ATV Rollover Accidents',
            'Side-by-Side (UTV) Accidents',
            'ATV Product Defect Claims',
            'Child ATV Injuries',
            'ATV Rental & Tour Accidents',
            'ATV Road Collision Accidents',
        ),
        'common_causes' => array(
            'Rollover on slopes or uneven terrain',
            'Excessive speed on curves or hills',
            'Defective throttle, steering, or brakes',
            'Riding adult-sized ATVs with child passengers',
            'Operating ATVs on public roads',
            'Failure to wear helmets or seatbelts (UTVs)',
            'Inexperienced or untrained operators',
            'Overloaded passengers on single-rider ATVs',
            'Alcohol or drug impairment while riding',
            'Hidden property hazards (ditches, wire, holes)',
            'Mechanical failure from inadequate maintenance',
            'Rental operators providing no safety instruction',
        ),
        'common_injuries' => array(
            array( 'name' => 'Traumatic Brain Injuries (TBI)', 'description' => 'ATV riders frequently do not wear helmets, and ejections and rollovers cause severe head impacts with the ground, trees, or other objects. TBI is the leading cause of death in ATV crashes.' ),
            array( 'name' => 'Spinal Cord Injuries and Paralysis', 'description' => 'Rollovers and ejections cause extreme forces on the spine. Vertebral fractures and spinal cord damage can result in permanent paralysis, requiring lifelong medical care and assistance.' ),
            array( 'name' => 'Crush Injuries', 'description' => 'ATVs weigh 400-1,000+ pounds and UTVs can exceed 2,000 pounds. Rollovers can pin and crush riders beneath the vehicle, causing catastrophic injuries to the chest, pelvis, and extremities.' ),
            array( 'name' => 'Broken Bones and Fractures', 'description' => 'Arm, leg, pelvis, and rib fractures are extremely common in ATV crashes. Many require surgical repair with hardware and result in lengthy recovery periods.' ),
            array( 'name' => 'Internal Organ Damage', 'description' => 'Being pinned under or thrown from an ATV can cause ruptured organs, internal bleeding, and life-threatening abdominal injuries requiring emergency surgery.' ),
            array( 'name' => 'Burns', 'description' => 'Contact with hot engines, exhaust systems, and post-crash fuel fires causes severe burns. ATV fuel tanks are vulnerable to rupture in rollover crashes.' ),
            array( 'name' => 'Wrongful Death', 'description' => 'The CPSC reports hundreds of ATV fatalities annually, with children disproportionately represented. Surviving families may pursue wrongful death claims against manufacturers, property owners, and rental operators.' ),
        ),
        'faqs' => array(
            array( 'question' => 'Can I ride an ATV on public roads in Georgia?', 'answer' => 'Generally no. Georgia law (O.C.G.A. § 40-7-120 et seq.) restricts ATV operation on public roads to limited circumstances, such as agricultural use and supervised road crossings. ATVs are not street-legal without specific modifications. Operating an ATV illegally on a road may affect comparative fault but does not bar a claim if another party was also negligent.' ),
            array( 'question' => 'Can I sue the ATV manufacturer if a defect caused my crash?', 'answer' => 'Yes. If a defective throttle, steering system, brake, suspension, or other component caused your crash, the manufacturer is liable under product liability law. Both Georgia and South Carolina recognize claims for design defects, manufacturing defects, and failure to warn.' ),
            array( 'question' => 'Who is liable for a child injured on an ATV?', 'answer' => 'Potentially the adult who allowed the child to ride, the property owner, the ATV rental operator, and/or the manufacturer. The CPSC recommends no children under 6 ride ATVs and that children under 16 only use age-appropriate models. Providing a child with an adult-sized ATV is strong evidence of negligence.' ),
            array( 'question' => 'Can I sue an ATV rental company for my injuries?', 'answer' => 'Yes. Rental operators must provide maintained equipment, helmets, safety instruction, and age-appropriate vehicles. If they failed in any of these duties, they may be liable. Signed waivers do not protect against claims of gross negligence or equipment defects in either Georgia or South Carolina.' ),
            array( 'question' => 'Are side-by-sides (UTVs) safer than ATVs?', 'answer' => 'Side-by-sides generally offer more stability, seatbelts, and roll cages compared to ATVs. However, they can still roll on steep terrain, and rollovers remain the leading cause of serious UTV injuries. Failure to use seatbelts in a UTV negates much of the safety advantage.' ),
            array( 'question' => 'How long do I have to file an ATV accident claim?', 'answer' => 'Georgia has a 2-year statute of limitations (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Product liability claims may have different considerations. Contact an attorney promptly to preserve evidence and meet all applicable deadlines.' ),
        ),
    ),

    /* ============================================================
       4. Golf Cart Accident Lawyers
       ============================================================ */
    array(
        'title'   => 'Golf Cart Accident Lawyers',
        'slug'    => 'golf-cart-accident-lawyers',
        'excerpt' => 'Injured in a golf cart accident in Georgia or South Carolina? Golf cart crashes cause serious injuries in communities, resorts, and on public roads. Our attorneys pursue full compensation from negligent operators and property owners.',
        'hero_intro' => 'Golf carts are everywhere in Georgia and South Carolina — from retirement communities and beach resorts to downtown streets and college campuses. But their open design, lack of safety features, and low visibility make them surprisingly dangerous. When negligent operators, defective carts, or dangerous road conditions cause crashes, our attorneys fight for injured victims.',
        'why_hire' => '<p>Golf cart accident cases involve a unique intersection of traffic law, premises liability, and product liability. Many people don\'t realize that golf cart crashes can produce devastating injuries — ejections, rollovers, collisions with vehicles, and pedestrian strikes all cause traumatic brain injuries, fractures, and spinal cord damage.</p><p>Georgia law (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-12/section-40-6-330/" target="_blank" rel="noopener">O.C.G.A. § 40-6-330 et seq.</a>) specifically regulates golf cart operation on public roads, limiting their use to designated streets and communities with speed limits of 25 mph or less. South Carolina has similar regulations that vary by municipality, with communities like Hilton Head Island, Kiawah Island, and Myrtle Beach having specific golf cart ordinances.</p><p>Our attorneys handle golf cart cases involving negligent operators, resort and community property owners, golf courses, rental companies, and golf cart manufacturers. We identify all liable parties and insurance sources to maximize recovery.</p>',
        'content' => <<<'HTML'
<h2>Golf Cart Accident Lawyers Serving Georgia &amp; South Carolina</h2>
<p>Golf carts have become a primary mode of transportation in many Georgia and South Carolina communities — from Hilton Head Island and Kiawah Island to Peachtree City, The Villages-style communities, and beach towns along the Grand Strand. With this expanded use comes a growing number of serious accidents. Golf carts lack seatbelts, airbags, doors, windshields, and crash protection — they are essentially open platforms on wheels. When a golf cart tips over, is struck by a vehicle, or ejects a passenger, the injuries are often severe.</p>
<p>At Roden Law, our golf cart accident lawyers represent victims injured in golf cart crashes throughout Georgia and South Carolina. We handle cases involving negligent drivers, resort operators, golf courses, rental companies, and defective golf cart equipment.</p>

<h2>Georgia &amp; South Carolina Golf Cart Laws</h2>
<ul>
<li><strong>Georgia:</strong> <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-12/section-40-6-330/" target="_blank" rel="noopener">O.C.G.A. § 40-6-330 et seq.</a> permits golf cart operation on public roads with speed limits of 25 mph or less, during daylight hours, and only on roads specifically designated for golf cart use. Operators must be at least 16 and hold a valid driver's license or learner's permit. Golf carts must have functioning headlights, taillights, and reflectors for street use.</li>
<li><strong>South Carolina:</strong> Golf cart regulation varies by municipality. Many coastal communities and resort areas permit golf cart use on designated streets. Some require registration, insurance, and specific safety equipment. Charleston, Myrtle Beach, and Hilton Head have their own golf cart ordinances.</li>
</ul>

<h2>Common Types of Golf Cart Accidents</h2>
<ul>
<li><strong>Tip-overs and rollovers:</strong> Golf carts have a narrow wheelbase and high center of gravity. Sharp turns, slopes, uneven terrain, and overcrowding cause rollovers that eject passengers</li>
<li><strong>Collisions with motor vehicles:</strong> Golf carts on public roads are struck by cars and trucks — often at speeds the cart cannot withstand. Their low profile and lack of lighting make them hard to see.</li>
<li><strong>Passenger ejections:</strong> Without seatbelts or doors, passengers — especially children seated on laps or standing on the back — are thrown from the cart during turns, sudden stops, or impacts</li>
<li><strong>Pedestrian strikes:</strong> Golf carts striking pedestrians on paths, sidewalks, and in communities</li>
<li><strong>Golf course accidents:</strong> Crashes on cart paths, collisions with other carts, and tips on hilly course terrain</li>
<li><strong>DUI golf cart crashes:</strong> Alcohol use is common on golf courses and at resorts. DUI laws apply to golf carts on public roads in both states.</li>
<li><strong>Defective equipment:</strong> Brake failures, steering malfunctions, accelerator sticking, and structural defects</li>
</ul>

<h2>Liability in Golf Cart Accident Cases</h2>
<p>Golf cart accident liability may involve multiple parties:</p>
<ul>
<li><strong>The golf cart operator:</strong> For reckless driving, speeding, intoxication, or negligent operation</li>
<li><strong>Property owners and HOAs:</strong> Communities that allow golf cart use have a duty to maintain safe paths, adequate signage, and proper road crossings</li>
<li><strong>Golf courses and resorts:</strong> For poorly maintained cart paths, inadequate course design, failure to enforce safety rules, and serving alcohol to already-intoxicated patrons</li>
<li><strong>Rental companies:</strong> For providing carts with defective brakes, steering, or other safety issues, and for failing to provide adequate instruction</li>
<li><strong>Golf cart manufacturers:</strong> For design defects, including inadequate stability, missing safety features, and component failures. Both Georgia and South Carolina recognize product liability claims.</li>
<li><strong>Motor vehicle drivers:</strong> When a car or truck strikes a golf cart on or near a roadway</li>
</ul>

<h2>Pursuing Maximum Compensation</h2>
<p>Our attorneys investigate every golf cart crash to identify all liable parties and insurance sources. We pursue compensation for medical expenses, lost wages, pain and suffering, permanent disability, disfigurement, and wrongful death under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/" target="_blank" rel="noopener">O.C.G.A. Title 51</a>) and South Carolina law. In cases involving DUI or egregious negligence, punitive damages may also be available.</p>
HTML,
        'category_name' => 'Golf Cart Accidents',
        'category_slug' => 'golf-cart-accidents',
        'sub_types' => array(
            'Golf Cart Rollover Accidents',
            'Golf Cart vs. Vehicle Collisions',
            'Golf Cart Passenger Ejection Injuries',
            'Golf Course Cart Accidents',
            'Golf Cart DUI Accidents',
            'Golf Cart Pedestrian Accidents',
        ),
        'common_causes' => array(
            'Tip-overs on slopes, curves, and uneven terrain',
            'Overcrowding the cart beyond seating capacity',
            'Operating on public roads with faster traffic',
            'Alcohol impairment (DUI on golf courses and roads)',
            'Children operating golf carts unsupervised',
            'Defective brakes, steering, or accelerator',
            'Sharp turns at excessive speed',
            'Poorly maintained cart paths and course terrain',
            'Lack of seatbelts, doors, and safety restraints',
            'Inadequate lighting on carts used at dusk or night',
            'Distracted driving on cart paths and roads',
            'Rental operators failing to provide safety instruction',
        ),
        'common_injuries' => array(
            array( 'name' => 'Traumatic Brain Injuries (TBI)', 'description' => 'Passengers ejected from golf carts often strike the ground head-first. Without helmets (which are almost never worn in golf carts), severe concussions, skull fractures, and brain injuries are common — especially among children and elderly passengers.' ),
            array( 'name' => 'Broken Bones and Fractures', 'description' => 'Ejections and rollovers cause broken arms, wrists, legs, hips, and ribs. Elderly passengers are especially vulnerable to fractures, including hip fractures that can be life-threatening.' ),
            array( 'name' => 'Spinal Cord Injuries', 'description' => 'Being thrown from a golf cart onto hard surfaces can cause vertebral fractures and spinal cord damage. Rollovers that pin passengers can also cause devastating spinal injuries.' ),
            array( 'name' => 'Facial Injuries and Lacerations', 'description' => 'Without a windshield or enclosed cabin, golf cart occupants are exposed to direct impacts with the ground, trees, and other objects during crashes, causing severe facial injuries.' ),
            array( 'name' => 'Crush Injuries', 'description' => 'Golf carts weigh 500-1,100+ pounds. Rollovers can trap and crush passengers underneath, causing severe chest, pelvis, and extremity injuries.' ),
            array( 'name' => 'Wrongful Death', 'description' => 'Golf cart accidents can be fatal, particularly rollovers that eject passengers, collisions with motor vehicles, and crashes involving children or elderly individuals. Surviving families may file wrongful death claims.' ),
        ),
        'faqs' => array(
            array( 'question' => 'Can I drive a golf cart on public roads in Georgia?', 'answer' => 'Only on roads specifically designated for golf cart use with speed limits of 25 mph or less, during daylight hours. Operators must be at least 16 with a valid license. The cart must have headlights, taillights, and reflectors. Georgia law (O.C.G.A. § 40-6-330) governs golf cart road use.' ),
            array( 'question' => 'Can I get a DUI on a golf cart?', 'answer' => 'Yes. DUI laws apply to golf carts operated on public roads in both Georgia and South Carolina. If you are operating a golf cart on a public road while intoxicated, you can be charged with DUI and held civilly liable for any injuries you cause.' ),
            array( 'question' => 'Who is liable if I\'m injured on a golf course cart?', 'answer' => 'Potentially the golf course (for dangerous cart paths, serving alcohol), the cart operator, the golf cart rental company, and/or the cart manufacturer if a defect contributed. Golf courses have a duty to maintain safe conditions and properly maintain their cart fleet.' ),
            array( 'question' => 'Can I sue a resort or community for a golf cart accident?', 'answer' => 'Yes. Resorts, HOAs, and communities that allow golf cart use have a duty to maintain safe paths, proper signage, adequate lighting, and safe road crossings. If negligent conditions contributed to your crash, the property owner may be liable under premises liability law.' ),
            array( 'question' => 'Are golf carts required to have seatbelts?', 'answer' => 'Most standard golf carts do not have seatbelts, and neither Georgia nor South Carolina currently requires them for traditional golf carts. However, Low-Speed Vehicles (LSVs) — which look similar but meet higher safety standards — are required to have seatbelts. The absence of safety features is relevant in product liability claims.' ),
            array( 'question' => 'How long do I have to file a golf cart accident claim?', 'answer' => 'Georgia has a 2-year statute of limitations (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). If a government entity or public property is involved, shorter notice deadlines may apply. Contact an attorney promptly.' ),
        ),
    ),

); // end $pillars array

/* ------------------------------------------------------------------
   INSERT POSTS
   ------------------------------------------------------------------ */

$created = 0;
$skipped = 0;

foreach ( $pillars as $p ) {
    // Check if slug already exists.
    $existing = get_posts( array(
        'post_type'   => $pa_post_type,
        'name'        => $p['slug'],
        'post_parent' => 0,
        'post_status' => array( 'publish', 'draft', 'pending', 'private', 'trash' ),
        'numberposts' => 1,
    ) );

    if ( ! empty( $existing ) ) {
        WP_CLI::log( "  SKIP: \"{$p['title']}\" already exists (ID {$existing[0]->ID})" );
        $skipped++;
        continue;
    }

    $post_id = wp_insert_post( array(
        'post_type'    => $pa_post_type,
        'post_title'   => wp_strip_all_tags( html_entity_decode( $p['title'], ENT_QUOTES, 'UTF-8' ) ),
        'post_name'    => $p['slug'],
        'post_content' => $p['content'],
        'post_excerpt' => $p['excerpt'],
        'post_status'  => 'publish',
        'post_parent'  => 0,
        'post_author'  => 1,
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "  FAIL: \"{$p['title']}\" — " . $post_id->get_error_message() );
        continue;
    }

    // Meta fields.
    update_post_meta( $post_id, '_roden_jurisdiction', 'both' );
    update_post_meta( $post_id, '_roden_sol_ga', 'O.C.G.A. § 9-3-33' );
    update_post_meta( $post_id, '_roden_sol_sc', 'S.C. Code § 15-3-530' );
    update_post_meta( $post_id, '_roden_hero_intro', $p['hero_intro'] );
    update_post_meta( $post_id, '_roden_why_hire', $p['why_hire'] );
    update_post_meta( $post_id, '_roden_faqs', $p['faqs'] );
    update_post_meta( $post_id, '_roden_common_causes', $p['common_causes'] );
    update_post_meta( $post_id, '_roden_common_injuries', $p['common_injuries'] );
    update_post_meta( $post_id, '_roden_sub_types', implode( "\n", $p['sub_types'] ) );

    if ( $author_attorney_id ) {
        update_post_meta( $post_id, '_roden_author_attorney', $author_attorney_id );
    }

    // Taxonomy.
    $cat_term = term_exists( $p['category_slug'], 'practice_category' );
    if ( ! $cat_term ) {
        $cat_term = wp_insert_term( $p['category_name'], 'practice_category', array( 'slug' => $p['category_slug'] ) );
    }
    $cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;
    if ( $cat_term_id ) {
        wp_set_object_terms( $post_id, (int) $cat_term_id, 'practice_category' );
    }

    WP_CLI::success( "  CREATED: \"{$p['title']}\" (ID {$post_id}) at /practice-areas/{$p['slug']}/" );
    $created++;
}

WP_CLI::log( '' );
WP_CLI::success( "Done. Created: {$created}, Skipped: {$skipped}" );
WP_CLI::log( 'Run: wp rewrite flush' );
