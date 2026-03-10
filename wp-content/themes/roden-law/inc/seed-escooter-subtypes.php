<?php
/**
 * Seeder: 6 Electric Scooter Accident Sub-Type Pages
 *
 * Creates 6 child posts under the electric-scooter-accident-lawyers pillar,
 * each covering a specific type of e-scooter accident.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-escooter-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: electric-scooter-accident-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'electric-scooter-accident-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'electric-scooter-accident-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "electric-scooter-accident-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'electric-scooter-accidents', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Electric Scooter Accidents', 'practice_category', array( 'slug' => 'electric-scooter-accidents' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. E-Scooter vs. Vehicle Collision
       ============================================================ */
    array(
        'title'   => 'E-Scooter vs. Vehicle Collision Lawyers',
        'slug'    => 'escooter-vehicle-collision',
        'excerpt' => 'Hit by a car while riding an electric scooter in Georgia or South Carolina? Our attorneys fight for e-scooter riders injured in collisions with motor vehicles.',
        'content' => <<<'HTML'
<h2>Legal Help After an E-Scooter vs. Vehicle Collision</h2>
<p>Electric scooter riders face extreme vulnerability when sharing the road with cars, trucks, and SUVs. Unlike motor vehicle occupants who are protected by airbags, crumple zones, and seatbelts, e-scooter riders have virtually no barrier between their bodies and a multi-ton vehicle traveling at speed. According to the <a href="https://www.cpsc.gov/Newsroom/News-Releases/2023/CPSC-Report-Shows-Deaths-and-Injuries-Related-to-E-Scooters-and-E-Bikes-Are-Increasing" target="_blank" rel="noopener">Consumer Product Safety Commission (CPSC)</a>, injuries related to e-scooters have surged dramatically in recent years, with vehicle collisions accounting for the most severe outcomes including traumatic brain injuries, spinal cord damage, and fatalities.</p>
<p>At Roden Law, our e-scooter accident attorneys represent riders struck by negligent motorists throughout Georgia and South Carolina. These cases often involve distracted drivers who fail to check for smaller vehicles in traffic, at intersections, and in bike lanes — and our job is to hold them accountable for the devastating injuries they cause.</p>

<h2>Georgia &amp; South Carolina E-Scooter Traffic Laws</h2>
<p>Georgia law classifies electric scooters as "personal transportation vehicles" under <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-17/" target="_blank" rel="noopener">O.C.G.A. § 40-6-320 et seq.</a>, which grants e-scooter riders many of the same rights and responsibilities as bicyclists on public roadways. Riders may use bike lanes, multi-use paths, and roadways with speed limits of 35 mph or less. Motorists owe e-scooter riders a duty of care and must maintain a safe passing distance — at least three feet when overtaking, similar to the bicycle passing law.</p>
<p>South Carolina does not yet have a comprehensive statewide e-scooter statute, meaning regulation often falls to local municipal ordinances in cities like <a href="/electric-scooter-accident-lawyers/charleston-sc/">Charleston</a>, <a href="/electric-scooter-accident-lawyers/columbia-sc/">Columbia</a>, and <a href="/electric-scooter-accident-lawyers/myrtle-beach-sc/">Myrtle Beach</a>. However, general negligence principles under South Carolina tort law still protect e-scooter riders who are injured by careless motorists. Drivers who fail to yield, run red lights, or operate while distracted can be held fully liable for injuries they cause to vulnerable road users.</p>
<p>Similar to <a href="/bicycle-accident-lawyers/">bicycle accident cases</a>, e-scooter riders injured by negligent motorists can pursue claims for the full extent of their damages, including catastrophic injuries that may require lifelong medical care.</p>

<h2>Common Causes of E-Scooter vs. Vehicle Collisions</h2>
<p>Our attorneys have handled e-scooter collision cases arising from a wide range of driver negligence, including:</p>
<ul>
<li>Distracted driving — texting, phone use, or adjusting GPS while failing to notice a scooter rider</li>
<li>Failure to yield at intersections, driveways, and parking lot exits (see also <a href="/electric-scooter-accident-lawyers/escooter-intersection-crash/">e-scooter intersection crashes</a>)</li>
<li>Unsafe lane changes and merging without checking blind spots</li>
<li>"Dooring" — a parked vehicle occupant opening their door into the path of an approaching scooter</li>
<li>Right-hook and left-turn collisions at intersections</li>
<li>Speeding in areas where e-scooter traffic is common, especially near downtown corridors</li>
<li>Driving under the influence of alcohol or drugs</li>
</ul>

<h2>Injuries in E-Scooter vs. Vehicle Accidents</h2>
<p>Because e-scooter riders lack physical protection, collisions with motor vehicles routinely produce severe injuries. The most common injuries our clients sustain include traumatic brain injuries (even with helmet use), facial fractures and dental injuries, broken collarbones and wrists from impact, spinal cord injuries and herniated discs, road rash requiring skin grafts, and internal organ damage. Many of these injuries require emergency surgery, extended hospitalization, and months or years of rehabilitation — resulting in medical bills that can reach hundreds of thousands of dollars.</p>

<h2>Proving Fault in an E-Scooter vs. Vehicle Case</h2>
<p>Georgia follows a modified comparative fault rule under <a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>, meaning you can recover damages as long as you are less than 50% at fault. South Carolina applies a similar modified comparative negligence standard, barring recovery only if you are 51% or more responsible. Insurance companies frequently try to shift blame to the scooter rider — claiming they were riding recklessly or ignoring traffic signals — which is why thorough evidence preservation and skilled legal representation are essential.</p>

<h2>Why Choose Roden Law for Your E-Scooter Collision Case</h2>
<p>Our team has recovered over $250 million for injured clients across Georgia and South Carolina. We understand the emerging legal landscape surrounding electric scooters, and we bring the same aggressive representation to e-scooter cases that we apply to all motor vehicle accident claims. We work on a contingency fee basis — you pay nothing unless we win your case.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Do e-scooter riders have the same rights as cars on Georgia roads?',
                'answer'   => 'Under O.C.G.A. § 40-6-320, electric scooter riders have many of the same rights and responsibilities as bicyclists, including the right to use bike lanes and roadways with speed limits of 35 mph or less. Motorists must give them at least three feet of clearance when passing.',
            ),
            array(
                'question' => 'What should I do if a car hits me while I am riding an e-scooter?',
                'answer'   => 'Call 911 immediately, do not move if you suspect a spinal injury, document the scene with photos and video, get the driver\'s insurance information, obtain witness contact details, seek medical attention even if injuries seem minor, and contact an e-scooter accident attorney before speaking with insurance adjusters.',
            ),
            array(
                'question' => 'Can I still recover compensation if I was partially at fault for the e-scooter accident?',
                'answer'   => 'Yes. Georgia allows recovery if you are less than 50% at fault (O.C.G.A. § 51-12-33), and South Carolina allows recovery if you are less than 51% at fault. Your compensation is reduced by your percentage of fault.',
            ),
            array(
                'question' => 'What is the statute of limitations for an e-scooter accident claim?',
                'answer'   => 'In Georgia, you have 2 years from the date of the accident to file a personal injury lawsuit (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530). Missing these deadlines typically bars your claim entirely.',
            ),
            array(
                'question' => 'What damages can I recover after being hit by a car on my e-scooter?',
                'answer'   => 'You may recover medical expenses (past and future), lost wages and lost earning capacity, pain and suffering, emotional distress, property damage to your scooter and personal items, and in cases of gross negligence, punitive damages.',
            ),
        ),
    ),

    /* ============================================================
       2. Scooter Malfunction and Defect
       ============================================================ */
    array(
        'title'   => 'Scooter Malfunction and Defect Lawyers',
        'slug'    => 'scooter-malfunction-defect',
        'excerpt' => 'Injured due to a defective electric scooter in Georgia or South Carolina? Our product liability attorneys hold manufacturers and rental companies accountable for dangerous e-scooter defects.',
        'content' => <<<'HTML'
<h2>E-Scooter Product Liability: Defects and Malfunctions</h2>
<p>Not every e-scooter accident is caused by another driver or rider error. In many cases, the scooter itself is to blame — whether due to a manufacturing defect, a design flaw, or the rental company's failure to properly inspect and maintain its fleet. The <a href="https://www.cpsc.gov/Newsroom/News-Releases/2023/CPSC-Report-Shows-Deaths-and-Injuries-Related-to-E-Scooters-and-E-Bikes-Are-Increasing" target="_blank" rel="noopener">CPSC</a> has tracked a growing number of e-scooter fires, brake failures, and sudden acceleration incidents linked to battery defects and component failures. When a defective scooter causes you harm, you may have a <a href="/product-liability-lawyers/">product liability claim</a> against the manufacturer, distributor, or rental company.</p>
<p>At Roden Law, our product liability and e-scooter accident attorneys investigate every mechanical and electrical aspect of the scooter involved in your crash. We retain engineering experts to analyze failed components and determine whether a defect caused or contributed to your injuries.</p>

<h2>Common E-Scooter Defects and Malfunctions</h2>
<p>Electric scooters contain complex electrical systems and lithium-ion batteries that, when improperly designed or manufactured, can create serious safety hazards. The most common defects we encounter include:</p>
<ul>
<li><strong>Brake failure:</strong> Worn brake pads, faulty electronic braking systems, or improperly calibrated regenerative braking that fails to stop the scooter in time</li>
<li><strong>Battery fires and explosions:</strong> Lithium-ion battery cells that overheat, swell, or ignite during charging or use — causing severe burns</li>
<li><strong>Sudden acceleration or loss of throttle control:</strong> Software glitches or wiring defects that cause the scooter to accelerate without rider input</li>
<li><strong>Steering column collapse:</strong> Folding mechanisms that fail during riding, causing the rider to lose control and crash</li>
<li><strong>Wheel and tire defects:</strong> Small solid tires that crack, detach, or lose grip unexpectedly — particularly on wet surfaces</li>
<li><strong>Electrical system failures:</strong> Headlights, taillights, or turn signals that malfunction, reducing visibility at night</li>
</ul>

<h2>Product Liability Law in Georgia &amp; South Carolina</h2>
<p>Georgia product liability claims are governed by <a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-3/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a> and the Georgia Products Liability Act. Injured plaintiffs can pursue claims based on strict liability, negligence, or breach of warranty. The manufacturer, designer, distributor, and retailer in the chain of commerce may all bear liability for a defective product.</p>
<p>South Carolina follows the South Carolina Products Liability Act and recognizes strict liability for defective products under <a href="https://www.scstatehouse.gov/code/t15c073.php" target="_blank" rel="noopener">S.C. Code § 15-73-10 et seq.</a>. Both states allow claims based on manufacturing defects, design defects, and failure to warn of known hazards. For <a href="/electric-scooter-accident-lawyers/ride-share-scooter-accident/">ride-share scooter accidents</a> involving Lime or Bird fleets, the rental company's maintenance obligations add an additional layer of potential liability.</p>

<h2>Rental Company Liability for Maintenance Failures</h2>
<p>Companies like Lime, Bird, and Spin deploy thousands of shared scooters across Georgia and South Carolina cities. These scooters endure heavy daily use, exposure to weather, and rough treatment by riders. When rental companies fail to maintain their fleets — neglecting brake inspections, ignoring reported defects, or deploying scooters with known safety issues — they can be held liable for injuries that result. Our attorneys subpoena maintenance records, inspection logs, and user complaint databases to build a complete picture of corporate negligence.</p>

<h2>Preserving Evidence in Defect Cases</h2>
<p>If you suspect a scooter malfunction caused your accident, preserving the scooter itself is critical. Do not return a rental scooter to the company — photograph it, note the scooter ID number, and inform your attorney immediately so we can issue a spoliation letter requiring the company to preserve the scooter and its data. Modern e-scooters contain onboard computers that log speed, braking, battery temperature, and error codes — all of which can be vital evidence in your case.</p>

<h2>Why Choose Roden Law for E-Scooter Defect Claims</h2>
<p>Our firm has extensive experience in <a href="/product-liability-lawyers/">product liability litigation</a> and understands the technical complexities involved in proving a defect caused your injuries. We work with mechanical engineers, electrical engineers, and accident reconstruction specialists to build compelling cases against manufacturers and rental companies. There is no fee unless we recover compensation for you.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue the e-scooter manufacturer if the scooter malfunctioned?',
                'answer'   => 'Yes. Under Georgia law (O.C.G.A. § 51-1-11) and South Carolina law (S.C. Code § 15-73-10), manufacturers are strictly liable for injuries caused by defective products. You can pursue claims for manufacturing defects, design defects, or failure to warn.',
            ),
            array(
                'question' => 'Is Lime or Bird liable if their rental scooter was defective?',
                'answer'   => 'Yes. Rental scooter companies have a duty to maintain their fleets and remove defective scooters from circulation. If they deploy a scooter with known brake, battery, or steering issues, they can be held liable for resulting injuries.',
            ),
            array(
                'question' => 'What should I do if my e-scooter malfunctioned and caused a crash?',
                'answer'   => 'Do not return the scooter. Photograph it from multiple angles, note the scooter ID number, seek medical attention, and contact an attorney immediately. Preserving the scooter and its electronic data is critical to proving a defect claim.',
            ),
            array(
                'question' => 'What types of compensation are available in an e-scooter defect case?',
                'answer'   => 'You may recover medical expenses, lost wages, pain and suffering, and property damage. In cases involving grossly defective products or corporate cover-ups, punitive damages may also be available to punish the manufacturer.',
            ),
            array(
                'question' => 'How long do I have to file an e-scooter product liability claim?',
                'answer'   => 'Georgia has a 2-year statute of limitations for personal injury (O.C.G.A. § 9-3-33) and a 10-year statute of repose for product liability. South Carolina allows 3 years for personal injury (S.C. Code § 15-3-530). Contact an attorney promptly to preserve your rights.',
            ),
        ),
    ),

    /* ============================================================
       3. Road Hazard E-Scooter Crash
       ============================================================ */
    array(
        'title'   => 'Road Hazard E-Scooter Crash Lawyers',
        'slug'    => 'road-hazard-escooter-crash',
        'excerpt' => 'Crashed your e-scooter due to a pothole, cracked pavement, or missing signage in Georgia or South Carolina? Our attorneys pursue claims against negligent property owners and municipalities.',
        'content' => <<<'HTML'
<h2>E-Scooter Crashes Caused by Road Hazards</h2>
<p>Electric scooters are uniquely vulnerable to road surface conditions. With small wheels — typically 8 to 10 inches in diameter — and limited suspension, e-scooters can become uncontrollable when encountering potholes, cracked pavement, uneven surfaces, gravel, railroad tracks, or debris in the roadway. Hazards that a car would roll over without incident can launch an e-scooter rider into traffic or onto the pavement, resulting in devastating injuries. According to a <a href="https://www.cdc.gov/mmwr/volumes/69/wr/mm6903a2.htm" target="_blank" rel="noopener">CDC study</a> on e-scooter injuries, surface conditions and road hazards are a leading contributing factor in e-scooter crashes — second only to motor vehicle collisions.</p>
<p>At Roden Law, our e-scooter accident attorneys investigate the road conditions at the crash site to determine whether a municipality, property owner, construction company, or other party bears responsibility for the hazard that caused your injuries.</p>

<h2>Common Road Hazards That Cause E-Scooter Crashes</h2>
<p>Our attorneys have represented e-scooter riders injured by a wide range of road surface defects and hazards, including:</p>
<ul>
<li><strong>Potholes and pavement cracks:</strong> Even moderate potholes can catch a scooter's small front wheel, stopping it abruptly and throwing the rider forward</li>
<li><strong>Uneven pavement transitions:</strong> Raised or sunken utility covers, expansion joints, and curb transitions that create drop-offs</li>
<li><strong>Gravel, sand, and loose debris:</strong> Loose material that eliminates tire traction, especially on turns</li>
<li><strong>Construction zones:</strong> Unmarked steel plates, trenches, loose gravel, and missing signage in active work zones</li>
<li><strong>Railroad and trolley tracks:</strong> Metal rails that trap narrow scooter wheels and cause loss of control</li>
<li><strong>Poorly maintained bike lanes:</strong> Bike lanes filled with debris, broken glass, or standing water</li>
<li><strong>Missing or inadequate signage:</strong> Failure to warn of upcoming hazards, grade changes, or road closures</li>
</ul>

<h2>Government Liability for Dangerous Roads in Georgia &amp; South Carolina</h2>
<p>When a road hazard is caused by government negligence — such as failing to repair known potholes or maintain safe bike lanes — the municipality or state agency responsible for the road may be liable for your injuries. Georgia's ante-litem notice requirement under <a href="https://law.justia.com/codes/georgia/title-36/chapter-33/" target="_blank" rel="noopener">O.C.G.A. § 36-33-5</a> requires written notice to the city or county within six months of the injury before filing suit. For state-level claims, <a href="https://law.justia.com/codes/georgia/title-50/chapter-21/" target="_blank" rel="noopener">O.C.G.A. § 50-21-26</a> (the Georgia Tort Claims Act) imposes a 12-month ante-litem notice period.</p>
<p>South Carolina waives sovereign immunity for certain government torts under the <a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">South Carolina Tort Claims Act (S.C. Code § 15-78-10 et seq.)</a>, but caps damages at $300,000 per claimant and requires filing within two years. Both states impose shorter notice deadlines than standard personal injury claims, making prompt legal action essential.</p>

<h2>Property Owner Liability for Hazardous Conditions</h2>
<p>Not all road hazards involve public roads. Private property owners — including shopping centers, apartment complexes, office parks, and parking garages — have a duty to maintain safe surfaces on their premises. If you crashed your e-scooter due to a hazard on private property, you may have a <a href="/premises-liability-lawyers/">premises liability claim</a> against the property owner. Similarly, construction companies that create hazardous conditions without adequate warnings can be held liable under general negligence principles.</p>

<h2>Proving a Road Hazard E-Scooter Case</h2>
<p>Success in a road hazard case requires documenting the specific condition that caused the crash and proving that the responsible party knew or should have known about the hazard. Critical evidence includes photographs of the hazard taken immediately after the crash, measurements of potholes or pavement defects, city maintenance request records showing prior complaints, weather and lighting conditions at the time, and the scooter's GPS data showing exact location and speed. Our attorneys work with civil engineering experts who evaluate whether road conditions met applicable safety standards.</p>

<h2>Why Choose Roden Law for Road Hazard E-Scooter Claims</h2>
<p>Claims against municipalities and government agencies involve strict procedural requirements and short notice deadlines that can bar your claim if missed. Our attorneys have extensive experience navigating government liability claims in both Georgia and South Carolina, and we act quickly to preserve evidence and comply with all ante-litem notice requirements. Contact us immediately after a road hazard e-scooter crash — delays can be fatal to your case.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue the city if a pothole caused my e-scooter crash?',
                'answer'   => 'Yes, but strict procedures apply. In Georgia, you must provide ante-litem notice to the municipality within 6 months (O.C.G.A. § 36-33-5). South Carolina\'s Tort Claims Act (S.C. Code § 15-78-10) requires filing within 2 years but caps damages at $300,000 per claimant. Prompt action is essential.',
            ),
            array(
                'question' => 'What road conditions are most dangerous for e-scooter riders?',
                'answer'   => 'Potholes, cracked pavement, loose gravel, railroad tracks, uneven surfaces, construction zones, and debris in bike lanes are the most common hazards. E-scooters\' small wheels make them far more susceptible to these conditions than bicycles or cars.',
            ),
            array(
                'question' => 'Who is responsible for maintaining roads and bike lanes?',
                'answer'   => 'Depending on the location, responsibility may fall on the city, county, state DOT, or a private property owner. Our attorneys investigate maintenance records and prior complaints to determine which party failed in their duty to maintain safe conditions.',
            ),
            array(
                'question' => 'What evidence should I gather after an e-scooter crash caused by a road hazard?',
                'answer'   => 'Photograph the hazard from multiple angles, measure it if possible, note the exact location, save your scooter\'s GPS data, get witness contact information, and report the incident to both police and the responsible municipality. Contact an attorney before the hazard is repaired.',
            ),
            array(
                'question' => 'Is there a shorter deadline for claims against the government?',
                'answer'   => 'Yes. Georgia requires ante-litem notice within 6 months for city/county claims and 12 months for state claims. These deadlines are much shorter than the standard 2-year statute of limitations, so contacting an attorney immediately is critical.',
            ),
        ),
    ),

    /* ============================================================
       4. E-Scooter Pedestrian Accident
       ============================================================ */
    array(
        'title'   => 'E-Scooter Pedestrian Accident Lawyers',
        'slug'    => 'escooter-pedestrian-accident',
        'excerpt' => 'Struck by an electric scooter while walking in Georgia or South Carolina? Our attorneys represent pedestrians injured by reckless e-scooter riders and negligent scooter companies.',
        'content' => <<<'HTML'
<h2>Pedestrian Injuries Caused by Electric Scooters</h2>
<p>The rapid expansion of electric scooter programs across Georgia and South Carolina cities has created a growing safety conflict between e-scooter riders and pedestrians. E-scooters can travel at speeds up to 15–20 mph, and when ridden on sidewalks, through crosswalks, or in crowded pedestrian areas, they pose a serious risk to walkers — particularly elderly individuals, children, and people with disabilities. The <a href="https://www.cpsc.gov/Newsroom/News-Releases/2023/CPSC-Report-Shows-Deaths-and-Injuries-Related-to-E-Scooters-and-E-Bikes-Are-Increasing" target="_blank" rel="noopener">CPSC</a> reports that pedestrians struck by e-scooters frequently suffer broken bones, head injuries, and soft tissue damage that requires extensive medical treatment.</p>
<p>At Roden Law, our <a href="/pedestrian-accident-lawyers/">pedestrian accident attorneys</a> represent individuals injured by negligent e-scooter riders throughout Georgia and South Carolina. Whether you were walking on a sidewalk, crossing at a crosswalk, or standing at a bus stop when an e-scooter struck you, we fight to secure full compensation for your injuries.</p>

<h2>E-Scooter Sidewalk Laws in Georgia &amp; South Carolina</h2>
<p>Georgia law under <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-17/" target="_blank" rel="noopener">O.C.G.A. § 40-6-320 et seq.</a> generally prohibits e-scooter operation on sidewalks unless permitted by local ordinance. Many Georgia municipalities, including Savannah, have implemented their own regulations restricting or banning sidewalk riding in downtown areas and high-pedestrian zones. When a rider violates these ordinances and injures a pedestrian, the violation can serve as evidence of negligence per se — meaning the rider is presumed to have been negligent.</p>
<p>South Carolina municipalities similarly regulate e-scooter use through local ordinances. Charleston, Columbia, and Myrtle Beach have each enacted rules governing where e-scooters may be ridden and at what speeds. Riders who violate these rules and cause pedestrian injuries face civil liability under standard negligence principles, with the ordinance violation strengthening the injured pedestrian's case.</p>

<h2>Common E-Scooter Pedestrian Accident Scenarios</h2>
<p>Our attorneys have represented pedestrians injured in a wide range of e-scooter collision scenarios, including:</p>
<ul>
<li><strong>Sidewalk collisions:</strong> Riders operating at full speed on busy sidewalks, striking pedestrians from behind or around corners</li>
<li><strong>Crosswalk crashes:</strong> Riders running red lights or failing to yield to pedestrians in marked crosswalks</li>
<li><strong>Tripping hazards from parked scooters:</strong> Improperly parked rental scooters blocking sidewalks, creating obstacles for visually impaired individuals and wheelchair users</li>
<li><strong>Multi-use path collisions:</strong> Riders traveling at unsafe speeds on shared pedestrian-bike paths without warning</li>
<li><strong>Tourist district accidents:</strong> High-density pedestrian areas in downtown Savannah, Charleston, and Myrtle Beach where scooter traffic is heavy</li>
</ul>

<h2>Scooter Company Liability for Pedestrian Injuries</h2>
<p>Rental scooter companies like Lime and Bird may share liability for pedestrian injuries when their deployment practices contribute to dangerous conditions. Companies that flood sidewalks with parked scooters, fail to enforce geofencing speed restrictions in pedestrian zones, or inadequately screen riders may be held liable under negligence theories. Our attorneys examine company deployment data, geofencing records, and rider verification practices to identify all responsible parties.</p>

<h2>Damages for Pedestrians Injured by E-Scooters</h2>
<p>Pedestrians struck by e-scooters may recover compensation for all injury-related damages, including emergency room visits and hospitalization, orthopedic surgery for broken bones, physical therapy and rehabilitation, lost wages during recovery, pain and suffering, and diminished mobility or permanent disability. Georgia's statute of limitations is 2 years (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>), and South Carolina allows 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). For comparison, see our <a href="/pedestrian-accident-lawyers/">dedicated pedestrian accident page</a> for additional information about pedestrian injury claims in general.</p>

<h2>Why Choose Roden Law for E-Scooter Pedestrian Claims</h2>
<p>Our firm understands the unique challenges pedestrian victims face after an e-scooter collision. Identifying the rider, determining available insurance coverage, and proving the scooter company's role all require experienced legal guidance. We handle every aspect of your claim on a contingency fee basis — no fees unless we win — so you can focus on your recovery while we pursue the compensation you deserve.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue if an e-scooter hit me while I was walking on the sidewalk?',
                'answer'   => 'Yes. E-scooter riders who operate on sidewalks in violation of Georgia law (O.C.G.A. § 40-6-320) or local ordinances can be held liable for negligence. The ordinance violation itself may establish negligence per se, strengthening your case significantly.',
            ),
            array(
                'question' => 'Is the scooter rental company liable if one of their riders hits a pedestrian?',
                'answer'   => 'Potentially yes. If the company failed to enforce speed limits in pedestrian zones, deployed scooters without proper geofencing, or contributed to dangerous sidewalk conditions through improper parking practices, they may share liability for your injuries.',
            ),
            array(
                'question' => 'What if I tripped over a parked e-scooter blocking the sidewalk?',
                'answer'   => 'Rental scooter companies have a responsibility to ensure their scooters are not parked in ways that block pedestrian access. If an improperly parked scooter caused you to trip and fall, both the rider who parked it and the company may be liable.',
            ),
            array(
                'question' => 'How do I identify the e-scooter rider who hit me?',
                'answer'   => 'Rental scooter companies maintain records of which user rented each scooter at any given time. Through legal discovery, your attorney can subpoena these records to identify the rider. Security camera footage and witness statements can also help.',
            ),
            array(
                'question' => 'What compensation is available if an e-scooter injured me as a pedestrian?',
                'answer'   => 'You may recover medical expenses, lost wages, pain and suffering, emotional distress, and any costs related to permanent disability or diminished quality of life. An experienced attorney can evaluate the full extent of your damages.',
            ),
        ),
    ),

    /* ============================================================
       5. Ride-Share Scooter (Lime, Bird) Accident
       ============================================================ */
    array(
        'title'   => 'Ride-Share Scooter (Lime, Bird) Accident Lawyers',
        'slug'    => 'ride-share-scooter-accident',
        'excerpt' => 'Injured on a Lime, Bird, or other rental e-scooter in Georgia or South Carolina? Our attorneys navigate the complex liability issues involving shared scooter companies.',
        'content' => <<<'HTML'
<h2>Lime, Bird &amp; Rental E-Scooter Accident Claims</h2>
<p>Shared electric scooter services from companies like Lime, Bird, Spin, and Veo have become a common sight in Georgia and South Carolina cities — particularly in tourist-heavy areas like downtown Savannah, Charleston's King Street corridor, and Myrtle Beach's boardwalk district. While these services offer affordable short-distance transportation, they also create significant safety risks. Riders often have minimal experience, receive no safety training before their first ride, and operate scooters without helmets in mixed traffic. According to a <a href="https://www.cdc.gov/mmwr/volumes/69/wr/mm6903a2.htm" target="_blank" rel="noopener">CDC study</a>, nearly half of all e-scooter injury victims were on their first ride or had used a scooter fewer than ten times.</p>
<p>At Roden Law, our e-scooter accident attorneys handle the full spectrum of rental scooter injury claims — from rider injuries caused by <a href="/electric-scooter-accident-lawyers/scooter-malfunction-defect/">scooter defects and malfunctions</a> to <a href="/electric-scooter-accident-lawyers/escooter-pedestrian-accident/">pedestrian injuries</a> caused by reckless riders, and <a href="/electric-scooter-accident-lawyers/escooter-vehicle-collision/">vehicle collisions</a> involving shared scooters.</p>

<h2>How Ride-Share Scooter Companies Operate</h2>
<p>Rental e-scooter companies use a "dockless" model — scooters are distributed throughout a city and users rent them via a smartphone app. Users agree to lengthy terms of service that typically include liability waivers and mandatory arbitration clauses. These contractual provisions can complicate injury claims, but they are not always enforceable. Georgia courts have invalidated unconscionable arbitration clauses and overbroad liability waivers, particularly when the injured party had no meaningful opportunity to negotiate the terms.</p>
<p>South Carolina similarly scrutinizes adhesion contracts under the <a href="https://www.scstatehouse.gov/code/t15c048.php" target="_blank" rel="noopener">South Carolina Uniform Arbitration Act</a> and common law principles of unconscionability. Our attorneys aggressively challenge these waivers when they stand between our clients and fair compensation.</p>

<h2>Liability in Ride-Share Scooter Accidents</h2>
<p>Determining liability in a rental scooter accident involves analyzing multiple potential responsible parties:</p>
<ul>
<li><strong>The scooter company:</strong> For fleet maintenance failures, defective scooters, inadequate safety warnings, negligent deployment in dangerous areas, and failure to enforce speed restrictions</li>
<li><strong>The scooter manufacturer:</strong> For design defects, manufacturing defects, and <a href="/product-liability-lawyers/">product liability</a> claims when the scooter itself fails</li>
<li><strong>Other motorists:</strong> For negligent driving that causes or contributes to the accident</li>
<li><strong>Municipalities:</strong> For dangerous road conditions, inadequate infrastructure for micro-mobility devices, and failure to regulate scooter deployment</li>
<li><strong>The rider (if injured party is a third party):</strong> For reckless operation, sidewalk riding, or riding while intoxicated</li>
</ul>

<h2>Common Ride-Share Scooter Accident Causes</h2>
<p>Rental scooter accidents frequently result from a combination of inexperienced riders and conditions unique to the shared scooter model:</p>
<ul>
<li>First-time riders unfamiliar with scooter handling, braking distances, and stability characteristics</li>
<li>Scooter maintenance failures — worn brakes, underinflated tires, loose handlebars, and battery issues</li>
<li>Riding on sidewalks or in pedestrian zones in violation of local regulations</li>
<li>Operating scooters while impaired by alcohol, a particular concern in nightlife districts</li>
<li>Collisions with vehicles at intersections (see <a href="/electric-scooter-accident-lawyers/escooter-intersection-crash/">e-scooter intersection crashes</a>)</li>
<li>Road hazards including potholes, trolley tracks, and debris (see <a href="/electric-scooter-accident-lawyers/road-hazard-escooter-crash/">road hazard e-scooter crashes</a>)</li>
</ul>

<h2>Insurance and Compensation for Rental Scooter Injuries</h2>
<p>Unlike car accidents where auto insurance provides a clear source of compensation, rental scooter accidents often involve less obvious insurance coverage. The scooter company's commercial general liability policy is typically the primary source, but coverage limits and exclusions vary. Your own health insurance, uninsured motorist coverage, and any applicable umbrella policies may also come into play. Under Georgia law, the statute of limitations for personal injury is 2 years (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>), while South Carolina provides 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>).</p>

<h2>Why Choose Roden Law for Rental Scooter Accident Claims</h2>
<p>Ride-share scooter cases involve a unique intersection of product liability, premises liability, and personal injury law. Our attorneys have the resources and experience to take on well-funded scooter companies and their insurance teams. We understand how to challenge arbitration clauses, identify all insurance coverage, and build cases that maximize your recovery. Contact us for a free consultation — we handle all e-scooter cases on a contingency fee basis.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Does the liability waiver I agreed to on the Lime or Bird app prevent me from suing?',
                'answer'   => 'Not necessarily. Courts in Georgia and South Carolina have invalidated overly broad or unconscionable liability waivers, particularly in adhesion contracts that consumers had no ability to negotiate. An attorney can evaluate whether the waiver is enforceable in your specific case.',
            ),
            array(
                'question' => 'Who is liable if I am injured on a rental e-scooter?',
                'answer'   => 'Multiple parties may be liable depending on the cause: the scooter company for maintenance failures, the manufacturer for defects, other drivers for negligence, or the municipality for dangerous road conditions. Our attorneys investigate all potential sources of liability.',
            ),
            array(
                'question' => 'What insurance covers rental e-scooter accidents?',
                'answer'   => 'The scooter company\'s commercial liability policy is typically the primary source. Your own health insurance, auto policy uninsured motorist coverage, and umbrella policies may also apply. An attorney can identify all available coverage.',
            ),
            array(
                'question' => 'Can I file a claim if I was a first-time scooter rider and crashed?',
                'answer'   => 'Yes. Scooter companies may be negligent in failing to provide adequate safety training, warnings, or beginner speed limits. If a defect or road hazard contributed to the crash, additional claims may be available regardless of your experience level.',
            ),
            array(
                'question' => 'What should I do after a rental e-scooter accident?',
                'answer'   => 'Screenshot your ride details in the app, photograph the scooter (note its ID number), document the scene, seek medical attention, save any clothing or gear damaged in the crash, and contact an attorney before reporting the incident to the scooter company.',
            ),
        ),
    ),

    /* ============================================================
       6. E-Scooter Intersection Crash
       ============================================================ */
    array(
        'title'   => 'E-Scooter Intersection Crash Lawyers',
        'slug'    => 'escooter-intersection-crash',
        'excerpt' => 'Injured in an e-scooter crash at an intersection in Georgia or South Carolina? Our attorneys hold negligent drivers and municipalities accountable for dangerous intersection conditions.',
        'content' => <<<'HTML'
<h2>E-Scooter Intersection Accidents in Georgia &amp; South Carolina</h2>
<p>Intersections are the most dangerous locations for electric scooter riders. The combination of turning vehicles, limited sight lines, and the scooter rider's small profile creates a high-risk environment that accounts for a disproportionate share of severe e-scooter injuries. Research from the <a href="https://www.nhtsa.gov/" target="_blank" rel="noopener">National Highway Traffic Safety Administration (NHTSA)</a> confirms that intersection collisions involving vulnerable road users — including e-scooter riders, cyclists, and pedestrians — result in some of the most serious injuries because of the speed differentials and angle of impact involved.</p>
<p>At Roden Law, our e-scooter accident attorneys focus on the unique dangers that intersections pose for scooter riders. We investigate every aspect of the crash — from driver behavior and traffic signal timing to intersection design and sight-line obstructions — to build the strongest possible case for our clients.</p>

<h2>How Intersection Crashes Happen for E-Scooter Riders</h2>
<p>E-scooter riders face specific hazards at intersections that drivers of larger vehicles do not. The most common intersection crash scenarios include:</p>
<ul>
<li><strong>Left-turn collisions:</strong> A vehicle turning left fails to see an oncoming e-scooter traveling straight through the intersection — one of the most common and deadly collision patterns</li>
<li><strong>Right-hook crashes:</strong> A vehicle turns right across the path of an e-scooter traveling in a bike lane or along the road's right edge</li>
<li><strong>Red-light and stop-sign violations:</strong> A driver runs a red light or rolls through a stop sign, striking a scooter rider who has the right of way</li>
<li><strong>Failure to yield when turning:</strong> Drivers making turns who fail to check for e-scooters approaching from the side, especially at uncontrolled intersections</li>
<li><strong>Blind-spot collisions:</strong> Large vehicles — trucks, SUVs, and delivery vans — that cannot see a small scooter rider in their blind spots during turns</li>
<li><strong>Obstructed sight lines:</strong> Parked cars, vegetation, signage, or construction barriers that prevent drivers and scooter riders from seeing each other</li>
</ul>

<h2>Georgia &amp; South Carolina Right-of-Way Laws</h2>
<p>Georgia's traffic code under <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-5/" target="_blank" rel="noopener">O.C.G.A. § 40-6-70 et seq.</a> establishes right-of-way rules at intersections that apply equally to e-scooter riders under the state's e-scooter statute (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-17/" target="_blank" rel="noopener">O.C.G.A. § 40-6-320</a>). Drivers who fail to yield the right of way to an e-scooter rider proceeding lawfully through an intersection are negligent per se — meaning their violation of the traffic law establishes fault as a matter of law.</p>
<p>South Carolina's right-of-way statutes similarly require motorists to yield to all lawful road users at intersections. A driver's failure to yield is a traffic violation that serves as strong evidence of negligence in a civil injury claim. Both states apply modified comparative fault rules, meaning the injured scooter rider can recover damages as long as they were not primarily at fault — less than 50% in Georgia (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>) and less than 51% in South Carolina.</p>

<h2>Municipal Liability for Dangerous Intersections</h2>
<p>In some cases, the intersection itself is unreasonably dangerous due to poor design, inadequate signage, malfunctioning traffic signals, or obstructed sight lines. When a municipality fails to address known intersection hazards, it may bear partial or full liability for resulting crashes. Georgia requires ante-litem notice for municipal claims under <a href="https://law.justia.com/codes/georgia/title-36/chapter-33/" target="_blank" rel="noopener">O.C.G.A. § 36-33-5</a>, and South Carolina's Tort Claims Act (<a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">S.C. Code § 15-78-10 et seq.</a>) governs claims against government entities.</p>
<p>Our attorneys review traffic engineering studies, crash history data, and prior complaints about specific intersections to establish that the municipality knew or should have known about the dangerous condition. This is similar to the analysis in <a href="/electric-scooter-accident-lawyers/road-hazard-escooter-crash/">road hazard e-scooter cases</a>, but focused specifically on intersection geometry, signal timing, and sight-line adequacy.</p>

<h2>Evidence in E-Scooter Intersection Cases</h2>
<p>Building a strong intersection crash case requires comprehensive evidence collection. Critical evidence includes traffic camera and surveillance footage from nearby businesses, the e-scooter's onboard GPS and speed data, police reports documenting driver citations, witness statements from other motorists and pedestrians, intersection design documents and traffic studies, and accident reconstruction analysis. Our attorneys act quickly to preserve this evidence before it is lost — surveillance footage is often overwritten within days, and scooter data may be deleted by the rental company.</p>

<h2>Injuries From E-Scooter Intersection Collisions</h2>
<p>Intersection collisions tend to produce the most severe e-scooter injuries because they often involve a direct impact from a turning or cross-traffic vehicle. Common injuries include traumatic brain injuries, spinal cord injuries, multiple fractures, internal organ damage, and in the worst cases, fatal injuries. These catastrophic outcomes underscore why aggressive legal representation is essential — the stakes in an intersection crash case are often life-changing. For cases involving fatal injuries, families may pursue a <a href="/wrongful-death-lawyers/">wrongful death claim</a>.</p>

<h2>Why Choose Roden Law for E-Scooter Intersection Claims</h2>
<p>Intersection crash cases require a thorough understanding of traffic engineering, right-of-way law, and accident reconstruction. Our attorneys combine legal expertise with technical resources — including accident reconstruction specialists and traffic engineers — to prove exactly how the crash occurred and who was at fault. We handle all e-scooter intersection cases on a contingency fee basis with no upfront costs.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who is usually at fault in an e-scooter intersection crash?',
                'answer'   => 'In most cases, the motor vehicle driver is at fault for failing to yield the right of way, running a red light, or making a turn without checking for e-scooter riders. Under Georgia and South Carolina law, traffic violations by the driver can establish negligence per se.',
            ),
            array(
                'question' => 'Do e-scooter riders have the right of way at intersections?',
                'answer'   => 'Yes. Under Georgia law (O.C.G.A. § 40-6-320), e-scooter riders have the same right-of-way protections as bicyclists. They must obey traffic signals but are entitled to the same yielding obligations from motorists as any other lawful road user.',
            ),
            array(
                'question' => 'Can I sue the city if the intersection was poorly designed?',
                'answer'   => 'Yes, but special procedures apply. Georgia requires ante-litem notice within 6 months (O.C.G.A. § 36-33-5), and South Carolina\'s Tort Claims Act caps government liability. Our attorneys handle these procedural requirements to protect your claim.',
            ),
            array(
                'question' => 'What if the driver says they did not see me on my scooter?',
                'answer'   => 'Failing to see a lawful road user is not a defense — it is evidence of negligence. Drivers have a duty to scan for all road users, including e-scooter riders, before making turns or entering intersections. "I didn\'t see them" typically strengthens your case.',
            ),
            array(
                'question' => 'How long do I have to file an e-scooter intersection crash claim?',
                'answer'   => 'Georgia allows 2 years from the date of the accident (O.C.G.A. § 9-3-33), and South Carolina allows 3 years (S.C. Code § 15-3-530). However, if a government entity is involved, notice deadlines can be as short as 6 months. Contact an attorney immediately.',
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
