<?php
/**
 * Seeder: 8 Boating Accident Sub-Type Pages
 *
 * Creates 8 child posts under the boating-accident-lawyers pillar, each covering
 * a specific type of boating accident.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-boating-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: boating-accident-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'boating-accident-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'boating-accident-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "boating-accident-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'boating-accidents', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Boating Accidents', 'practice_category', array( 'slug' => 'boating-accidents' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Jet Ski and Personal Watercraft Accident
       ============================================================ */
    array(
        'title'   => 'Jet Ski and Personal Watercraft Accident Lawyers',
        'slug'    => 'jet-ski-personal-watercraft',
        'excerpt' => 'Injured in a jet ski or personal watercraft accident in Georgia or South Carolina? Our attorneys pursue maximum compensation for victims of reckless PWC operation, rental company negligence, and manufacturer defects.',
        'content' => <<<'HTML'
<h2>Jet Ski &amp; Personal Watercraft Accident Claims</h2>
<p>Personal watercraft (PWC) — including Jet Skis, WaveRunners, and Sea-Doos — are among the most dangerous recreational vessels on the water. The <a href="https://www.uscgboating.org/" target="_blank" rel="noopener">U.S. Coast Guard</a> reports that personal watercraft are involved in a disproportionately high number of boating accidents relative to their share of registered vessels. The combination of high speeds, lack of protective barriers, and often-inexperienced operators creates serious injury risks on the waterways of Georgia and South Carolina.</p>
<p>At Roden Law, our jet ski accident lawyers represent victims throughout the coastal and inland waterways of both states. Whether your accident occurred on the Savannah River, the Intracoastal Waterway, Lake Hartwell, or the Charleston Harbor, we have the legal expertise and local knowledge to pursue full compensation for your injuries.</p>

<h2>Georgia &amp; South Carolina PWC Regulations</h2>
<p>Both states regulate personal watercraft operation under their boating safety statutes. Georgia's Boat Safety Act (<a href="https://law.justia.com/codes/georgia/title-52/chapter-7/" target="_blank" rel="noopener">O.C.G.A. § 52-7-1 et seq.</a>) establishes minimum age requirements, mandatory boater education, and operational rules for PWC. South Carolina's boating laws (<a href="https://www.scstatehouse.gov/code/t50c021.php" target="_blank" rel="noopener">S.C. Code § 50-21-10 et seq.</a>) impose similar requirements, including restrictions on PWC operation after sunset and near swimming areas.</p>
<p>Key regulations governing PWC operation in both states include:</p>
<ul>
<li><strong>Minimum age requirements:</strong> Georgia requires PWC operators to be at least 16 years old; South Carolina requires operators to be at least 16 unless supervised by an adult</li>
<li><strong>Boater education:</strong> Both states require boater safety certification for PWC operators under certain ages</li>
<li><strong>Life jacket requirements:</strong> All PWC occupants must wear U.S. Coast Guard-approved personal flotation devices</li>
<li><strong>Speed and distance restrictions:</strong> PWCs must maintain safe speeds and distances from other vessels, docks, and swimmers</li>
<li><strong>No-wake zones:</strong> Both states enforce no-wake zones near marinas, boat ramps, and shorelines</li>
</ul>

<h2>Common Causes of PWC Accidents</h2>
<p>Personal watercraft accidents frequently result from operator inexperience, excessive speed, reckless maneuvering, and operating under the influence of alcohol. Rental operations are a particular source of risk, as companies often provide minimal instruction before sending inexperienced tourists onto busy waterways. Other common causes include mechanical failure, collisions with fixed objects or submerged hazards, and wake jumping near other vessels.</p>
<p>Victims of PWC accidents may suffer traumatic brain injuries, spinal cord injuries, broken bones, internal organ damage, lacerations from the jet intake, and near-drowning injuries. Many of these injuries are catastrophic, requiring extensive medical treatment and long-term rehabilitation. If your injuries were caused by <a href="/boating-accident-lawyers/boating-under-influence/">an impaired operator</a>, additional legal remedies may be available.</p>

<h2>Liability in Jet Ski Accident Cases</h2>
<p>Multiple parties may bear responsibility for a PWC accident, including the operator who caused the collision, rental companies that failed to provide adequate instruction or maintained defective equipment, boat manufacturers responsible for <a href="/product-liability-lawyers/">defective products</a>, and property owners who failed to maintain safe waterway conditions. Georgia's comparative fault rule (O.C.G.A. § 51-12-33) allows recovery if you are less than 50% at fault, while South Carolina permits recovery if you are less than 51% at fault.</p>

<h2>Pursuing Compensation After a PWC Accident</h2>
<p>Victims of personal watercraft accidents may recover compensation for emergency medical care, surgeries, and hospitalization, ongoing physical therapy and rehabilitation, lost wages and reduced earning capacity, pain and suffering, disability and disfigurement, and emotional distress. Our attorneys investigate each case thoroughly, working with maritime safety experts and accident reconstructionists to establish liability and maximize recovery. Contact Roden Law today for a free consultation — there is no fee unless we win your case.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who is liable if I was injured on a rented jet ski?',
                'answer'   => 'Rental companies may be liable if they failed to provide adequate safety instructions, rented to an underage or inexperienced operator, or failed to properly maintain the watercraft. The operator who caused the accident may also be liable.',
            ),
            array(
                'question' => 'What is the minimum age to operate a jet ski in Georgia and South Carolina?',
                'answer'   => 'In Georgia, you must be at least 16 years old to operate a PWC (O.C.G.A. § 52-7-8.2). South Carolina also requires operators to be at least 16 unless accompanied by a supervising adult (S.C. Code § 50-21-870).',
            ),
            array(
                'question' => 'Can I sue for a jet ski accident caused by a mechanical defect?',
                'answer'   => 'Yes. If the PWC had a manufacturing defect, design defect, or failure to warn, the manufacturer may be liable under product liability law. Common defects include throttle malfunctions, steering failures, and jet intake guard inadequacies.',
            ),
            array(
                'question' => 'What is the statute of limitations for a boating accident claim in Georgia and South Carolina?',
                'answer'   => 'In Georgia, you have 2 years from the date of the accident to file a personal injury lawsuit (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530).',
            ),
            array(
                'question' => 'Do I have to wear a life jacket on a jet ski?',
                'answer'   => 'Yes. Both Georgia and South Carolina require all PWC occupants to wear a U.S. Coast Guard-approved personal flotation device at all times while on the watercraft.',
            ),
        ),
    ),

    /* ============================================================
       2. Speedboat and Powerboat Collision
       ============================================================ */
    array(
        'title'   => 'Speedboat and Powerboat Collision Lawyers',
        'slug'    => 'speedboat-powerboat-collision',
        'excerpt' => 'Hurt in a speedboat or powerboat collision in Georgia or South Carolina? Our boating accident attorneys hold reckless operators and negligent boat owners accountable for injuries on the water.',
        'content' => <<<'HTML'
<h2>Speedboat &amp; Powerboat Collision Claims</h2>
<p>Speedboats and powerboats are involved in some of the most devastating boating accidents on Georgia and South Carolina waterways. The <a href="https://www.uscgboating.org/" target="_blank" rel="noopener">U.S. Coast Guard's Recreational Boating Statistics</a> report shows that operator inattention, improper lookout, and excessive speed are the leading contributing factors in fatal boating collisions nationwide. The high velocity capabilities of modern powerboats amplify the severity of these crashes exponentially.</p>
<p>At Roden Law, our speedboat collision attorneys represent victims throughout the inland lakes, rivers, and coastal waterways of Georgia and South Carolina. We understand the complex interplay of state boating laws, federal maritime regulations, and insurance coverage that governs these claims.</p>

<h2>Georgia &amp; South Carolina Boating Laws Governing Speed</h2>
<p>Georgia's Boat Safety Act (<a href="https://law.justia.com/codes/georgia/title-52/chapter-7/" target="_blank" rel="noopener">O.C.G.A. § 52-7-1 et seq.</a>) requires all vessel operators to maintain a "reasonable and prudent" speed based on water conditions, visibility, traffic density, and proximity to shorelines and other vessels. South Carolina's boating statutes (<a href="https://www.scstatehouse.gov/code/t50c021.php" target="_blank" rel="noopener">S.C. Code § 50-21-10 et seq.</a>) impose similar requirements, mandating that operators maintain proper lookout and reduce speed in congested areas, near docks, and in marked no-wake zones.</p>
<p>Both states enforce strict rules regarding navigation lights, right-of-way protocols, and minimum safe distances from other vessels. Violations of these regulations constitute negligence per se — meaning the violator is automatically considered negligent if their violation caused the accident.</p>

<h2>Common Causes of Powerboat Collisions</h2>
<p>Speedboat and powerboat collisions frequently result from:</p>
<ul>
<li><strong>Excessive speed:</strong> Operating at unsafe speeds for conditions, reducing reaction time</li>
<li><strong>Operator inattention:</strong> Distracted boating, including phone use and socializing</li>
<li><strong>Failure to maintain proper lookout:</strong> Not watching for other vessels, swimmers, or obstacles</li>
<li><strong>Operating under the influence:</strong> <a href="/boating-accident-lawyers/boating-under-influence/">Boating under the influence (BUI)</a> significantly impairs judgment and coordination</li>
<li><strong>Inadequate navigation lights:</strong> Operating at night without required lighting</li>
<li><strong>Inexperienced operators:</strong> Lack of training in vessel handling and navigation rules</li>
</ul>

<h2>Catastrophic Injuries in Powerboat Accidents</h2>
<p>The forces involved in powerboat collisions often produce catastrophic or fatal injuries. Occupants may be thrown from the vessel, struck by propellers, or trapped underwater. Common injuries include <a href="/brain-injury-lawyers/">traumatic brain injuries</a>, <a href="/spinal-cord-injury-lawyers/">spinal cord injuries</a> and paralysis, propeller strike lacerations and amputations, broken bones and crush injuries, drowning and near-drowning injuries, and internal organ damage from blunt force trauma.</p>

<h2>Pursuing a Powerboat Collision Claim</h2>
<p>Powerboat collision claims may involve multiple liable parties, including the operator at fault, the vessel owner (if different from the operator), boat manufacturers responsible for defective equipment, and operators of marinas or rental companies. Our attorneys work with maritime experts and accident reconstructionists to determine fault, quantify damages, and pursue every source of compensation. Under Georgia law (O.C.G.A. § 51-12-33), you may recover damages if you are less than 50% at fault. South Carolina allows recovery if you are less than 51% responsible. Contact Roden Law today for a free case evaluation — we charge no fees unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What should I do immediately after a powerboat collision?',
                'answer'   => 'Ensure everyone\'s safety, call 911 and the local marine patrol, render aid to injured persons, document the scene with photos, exchange information with other boat operators, and report the accident to the appropriate state agency. Seek medical attention promptly.',
            ),
            array(
                'question' => 'Can I sue the boat owner if someone else was driving?',
                'answer'   => 'Yes. Boat owners can be held vicariously liable for accidents caused by operators they permitted to use their vessel. This is particularly important when the at-fault operator lacks adequate insurance coverage.',
            ),
            array(
                'question' => 'Is excessive speed on the water illegal in Georgia?',
                'answer'   => 'Georgia law (O.C.G.A. § 52-7-17) requires operators to maintain a reasonable and prudent speed. Operating at excessive speed for conditions — even if there is no posted speed limit — constitutes negligence and may violate the Boat Safety Act.',
            ),
            array(
                'question' => 'How is fault determined in a boating collision?',
                'answer'   => 'Fault is determined by examining navigation rules, operator conduct, witness statements, Coast Guard reports, and physical evidence. Both states use modified comparative fault, reducing your damages by your percentage of responsibility.',
            ),
            array(
                'question' => 'What damages can I recover after a speedboat accident?',
                'answer'   => 'You may recover medical expenses, lost wages, pain and suffering, disability, emotional distress, and property damage. In cases involving reckless or intoxicated operation, punitive damages may also be available.',
            ),
        ),
    ),

    /* ============================================================
       3. Pontoon Boat Accident
       ============================================================ */
    array(
        'title'   => 'Pontoon Boat Accident Lawyers',
        'slug'    => 'pontoon-boat-accident',
        'excerpt' => 'Injured in a pontoon boat accident on Georgia or South Carolina waters? Our lawyers handle claims involving pontoon capsizing, collisions, falls overboard, and negligent operators.',
        'content' => <<<'HTML'
<h2>Pontoon Boat Accident Claims in Georgia &amp; South Carolina</h2>
<p>Pontoon boats are among the most popular recreational watercraft on the lakes, rivers, and coastal waterways of Georgia and South Carolina. Their wide, flat decks and stable platforms make them ideal for family outings, fishing, and entertaining. However, their popularity also contributes to a significant number of boating accidents each year. The <a href="https://www.uscgboating.org/" target="_blank" rel="noopener">U.S. Coast Guard</a> notes that open motorboats, which include pontoons, are consistently among the vessel types most frequently involved in reported boating accidents.</p>
<p>At Roden Law, our pontoon boat accident attorneys understand the unique characteristics of these vessels and the specific hazards they present. Whether your accident occurred on Lake Lanier, Lake Hartwell, Lake Murray, or the Intracoastal Waterway, we pursue full compensation for victims of pontoon boat negligence.</p>

<h2>Common Causes of Pontoon Boat Accidents</h2>
<p>Pontoon boats present distinct safety challenges that differ from traditional powerboats. Common causes of pontoon boat accidents include:</p>
<ul>
<li><strong>Overloading:</strong> Exceeding the vessel's maximum capacity with passengers or gear, compromising stability</li>
<li><strong>Operator inexperience:</strong> Pontoons handle differently than other boats; inexperienced operators may misjudge turning radius and stopping distance</li>
<li><strong>Lack of railings or barriers:</strong> Open deck designs increase the risk of passengers falling overboard</li>
<li><strong>Alcohol use:</strong> <a href="/boating-accident-lawyers/boating-under-influence/">Boating under the influence</a> impairs judgment and balance, especially on open-deck vessels</li>
<li><strong>Wake damage:</strong> Pontoons are particularly vulnerable to swamping or capsizing from the wake of <a href="/boating-accident-lawyers/speedboat-powerboat-collision/">passing speedboats</a></li>
<li><strong>Mechanical failures:</strong> Engine, steering, or structural failures in the pontoons themselves</li>
</ul>

<h2>Safety Regulations for Pontoon Boats</h2>
<p>Georgia law (<a href="https://law.justia.com/codes/georgia/title-52/chapter-7/" target="_blank" rel="noopener">O.C.G.A. § 52-7-1 et seq.</a>) and South Carolina law (<a href="https://www.scstatehouse.gov/code/t50c021.php" target="_blank" rel="noopener">S.C. Code § 50-21-10 et seq.</a>) require pontoon operators to carry approved life jackets for every passenger, operate at safe speeds, maintain a proper lookout, and comply with all navigation rules. Children under 13 must wear life jackets at all times while on the vessel. Operators are also required to file accident reports with the state Department of Natural Resources within specified timeframes.</p>

<h2>Injuries from Pontoon Boat Accidents</h2>
<p>Despite their reputation as slow, safe vessels, pontoon boats can cause serious injuries. Passengers falling overboard may suffer drowning or near-drowning injuries, while those struck by propellers can sustain severe lacerations, amputations, or fatal injuries. Other common injuries include <a href="/brain-injury-lawyers/">traumatic brain injuries</a> from striking the deck or dock structures, <a href="/spinal-cord-injury-lawyers/">spinal cord injuries</a>, broken bones, and hypothermia from prolonged water immersion.</p>

<h2>Liability in Pontoon Boat Cases</h2>
<p>Depending on the circumstances, multiple parties may be liable for a pontoon boat accident: the operator who acted negligently, the boat owner who entrusted the vessel to an unqualified operator, rental companies that failed to provide safety instructions, manufacturers responsible for defective pontoon designs, and marina operators who allowed overloaded vessels to depart. Georgia's comparative fault statute (O.C.G.A. § 51-12-33) and South Carolina's comparative negligence rules allow injured parties to recover damages even if they share some fault, provided their responsibility does not exceed the threshold. Our attorneys pursue every available avenue of recovery to maximize compensation for pontoon boat accident victims.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Are pontoon boats more dangerous than other boats?',
                'answer'   => 'Pontoon boats present unique risks due to their open deck design, which increases fall-overboard risk. They are also more susceptible to swamping from large wakes and may become unstable when overloaded. However, accidents are most often caused by operator negligence rather than vessel design.',
            ),
            array(
                'question' => 'What happens if the pontoon boat was overloaded with passengers?',
                'answer'   => 'Overloading a pontoon boat beyond its rated capacity is a violation of federal and state boating safety regulations. If overloading contributed to your accident, both the operator and the owner may be held liable for negligently exceeding safe capacity limits.',
            ),
            array(
                'question' => 'Can I file a claim if I fell off a pontoon boat?',
                'answer'   => 'Yes. If you fell overboard due to the operator\'s negligent maneuvering, excessive speed, lack of safety features, or another party\'s recklessness, you may have a valid personal injury claim. Prompt reporting and medical documentation are important.',
            ),
            array(
                'question' => 'Who do I report a pontoon boat accident to in Georgia or South Carolina?',
                'answer'   => 'In Georgia, boating accidents must be reported to the Georgia Department of Natural Resources. In South Carolina, reports go to the South Carolina Department of Natural Resources. Accidents involving death, disappearance, or injuries requiring medical treatment beyond first aid must be reported promptly.',
            ),
            array(
                'question' => 'What is the statute of limitations for a pontoon boat accident claim?',
                'answer'   => 'Georgia allows 2 years from the accident date to file a personal injury lawsuit (O.C.G.A. § 9-3-33). South Carolina allows 3 years (S.C. Code § 15-3-530). Wrongful death claims may have different deadlines.',
            ),
        ),
    ),

    /* ============================================================
       4. Sailboat Accident
       ============================================================ */
    array(
        'title'   => 'Sailboat Accident Lawyers',
        'slug'    => 'sailboat-accident',
        'excerpt' => 'Injured in a sailboat accident in Georgia or South Carolina? Our attorneys handle claims involving sailboat collisions, rigging failures, boom strikes, and capsizing incidents.',
        'content' => <<<'HTML'
<h2>Sailboat Accident Claims in Georgia &amp; South Carolina</h2>
<p>Sailboat accidents present a unique category of boating injury claims that involve distinct equipment hazards, right-of-way rules, and liability considerations. While sailing is often perceived as a low-risk activity, the <a href="https://www.uscgboating.org/" target="_blank" rel="noopener">U.S. Coast Guard</a> regularly reports sailboat involvement in collisions, capsizings, and man-overboard incidents on waterways nationwide. Georgia and South Carolina's extensive coastlines, rivers, and reservoirs attract thousands of sailors each year, and accidents on these waters can result in catastrophic injuries.</p>
<p>At Roden Law, our sailboat accident attorneys handle the full spectrum of sailing injury claims — from recreational day-sailing mishaps to competitive racing incidents and chartered sailing excursions. We understand the navigation rules, equipment standards, and liability principles that apply to these cases.</p>

<h2>Common Causes of Sailboat Accidents</h2>
<p>Sailboat accidents can result from a variety of hazards unique to sailing vessels:</p>
<ul>
<li><strong>Boom strikes:</strong> The boom swinging unexpectedly during a tack or jibe can strike crew members with tremendous force</li>
<li><strong>Capsizing and heeling:</strong> Sudden gusts, improper sail trim, or shifting ballast can cause a sailboat to capsize or heel dangerously</li>
<li><strong>Rigging failures:</strong> Broken stays, shrouds, or halyards can send masts and sails crashing down on crew</li>
<li><strong>Collisions with other vessels:</strong> Failure to follow sailing right-of-way rules under the <a href="https://www.navcen.uscg.gov/navigation-rules" target="_blank" rel="noopener">COLREGS navigation rules</a></li>
<li><strong>Man-overboard incidents:</strong> Falls from the deck during heavy weather, line handling, or sail changes</li>
<li><strong>Grounding:</strong> Striking submerged obstacles or running aground due to navigational errors</li>
</ul>

<h2>Sailing Regulations in Georgia &amp; South Carolina</h2>
<p>Sailboats are subject to the same boating safety statutes as powerboats under Georgia law (<a href="https://law.justia.com/codes/georgia/title-52/chapter-7/" target="_blank" rel="noopener">O.C.G.A. § 52-7-1 et seq.</a>) and South Carolina law (<a href="https://www.scstatehouse.gov/code/t50c021.php" target="_blank" rel="noopener">S.C. Code § 50-21-10 et seq.</a>). Additionally, sailboats must carry required safety equipment including life jackets, visual distress signals, navigation lights, and sound-producing devices. Operators of sailboats with auxiliary engines must also comply with engine-related regulations.</p>
<p>International and inland navigation rules establish specific right-of-way protocols between sailing vessels based on wind position (windward vs. leeward, starboard tack vs. port tack), as well as between sailing vessels and power-driven vessels.</p>

<h2>Injuries in Sailboat Accidents</h2>
<p>Sailboat accidents can produce severe injuries including <a href="/brain-injury-lawyers/">traumatic brain injuries</a> from boom strikes and falls, <a href="/spinal-cord-injury-lawyers/">spinal cord injuries</a>, broken bones and crush injuries from rigging collapse, hand and finger amputations from line-handling incidents, drowning and near-drowning from man-overboard situations, and hypothermia from cold-water immersion.</p>

<h2>Liability and Compensation</h2>
<p>Depending on the circumstances of the accident, liable parties may include the skipper or captain who operated negligently, boat owners who failed to maintain the vessel and its rigging, charter companies that provided unseaworthy vessels, race organizers who failed to implement adequate safety protocols, and manufacturers of defective sailing equipment. Under Georgia's comparative fault statute (O.C.G.A. § 51-12-33), you can recover if less than 50% at fault. South Carolina allows recovery if less than 51% at fault. In cases involving <a href="/boating-accident-lawyers/commercial-vessel-accident/">commercial sailing operations</a>, federal maritime law may provide additional remedies. Contact our attorneys for a free evaluation of your sailboat accident claim.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who is responsible for safety on a sailboat?',
                'answer'   => 'The skipper or captain is primarily responsible for the safety of all persons aboard. However, boat owners, charter companies, race organizers, and equipment manufacturers may also share liability depending on the circumstances of the accident.',
            ),
            array(
                'question' => 'Can I sue for a boom strike injury on a sailboat?',
                'answer'   => 'Yes. If a boom strike occurred due to the skipper\'s failure to warn, improper sail handling, lack of a boom preventer, or other negligence, you may have a valid claim for your injuries.',
            ),
            array(
                'question' => 'Are sailboat charter companies liable for accidents?',
                'answer'   => 'Charter companies may be liable if they provided an unseaworthy vessel, failed to inspect and maintain safety equipment, or rented to unqualified operators without proper training or certification requirements.',
            ),
            array(
                'question' => 'Does maritime law apply to sailboat accidents in Georgia and South Carolina?',
                'answer'   => 'It depends on the location. Accidents on navigable waters (oceans, sounds, major rivers) may be governed by federal maritime law, which can provide different remedies. Accidents on inland lakes may be governed by state law. An experienced maritime attorney can determine which law applies.',
            ),
            array(
                'question' => 'What compensation is available for sailboat accident injuries?',
                'answer'   => 'Victims may recover medical expenses, lost wages, pain and suffering, disability, and emotional distress. In cases involving gross negligence or intoxication, punitive damages may also be available under Georgia or South Carolina law.',
            ),
        ),
    ),

    /* ============================================================
       5. Kayak and Canoe Accident
       ============================================================ */
    array(
        'title'   => 'Kayak and Canoe Accident Lawyers',
        'slug'    => 'kayak-canoe-accident',
        'excerpt' => 'Injured in a kayak or canoe accident in Georgia or South Carolina? Our attorneys pursue claims against negligent outfitters, reckless boaters, and property owners for paddling accidents.',
        'content' => <<<'HTML'
<h2>Kayak &amp; Canoe Accident Claims</h2>
<p>Kayaking and canoeing have surged in popularity across Georgia and South Carolina, with paddlers exploring the Savannah River, Edisto River, Congaree River, and the coastal marshes of the Lowcountry and Golden Isles. While paddling sports are generally low-speed activities, they carry significant risks — particularly when motorized vessels share the same waterways. The <a href="https://www.uscgboating.org/" target="_blank" rel="noopener">U.S. Coast Guard</a> reports that canoes and kayaks are consistently among the vessel types with the highest fatality rates, primarily due to capsizing and drowning.</p>
<p>At Roden Law, our kayak and canoe accident lawyers represent paddlers who are injured through the negligence of motorboat operators, outfitter companies, tour guides, and property owners throughout Georgia and South Carolina.</p>

<h2>Common Causes of Kayak &amp; Canoe Accidents</h2>
<p>Paddling accidents occur in a variety of scenarios, each presenting different liability questions:</p>
<ul>
<li><strong>Collisions with motorized vessels:</strong> <a href="/boating-accident-lawyers/speedboat-powerboat-collision/">Speedboats and powerboats</a> failing to maintain proper lookout or yield right-of-way to paddle craft</li>
<li><strong>Wake damage:</strong> Excessive wakes from passing motorboats swamping or capsizing kayaks and canoes</li>
<li><strong>Outfitter negligence:</strong> Tour companies providing defective equipment, inadequate safety briefings, or unqualified guides</li>
<li><strong>Strainers and hazards:</strong> Fallen trees, low-head dams, and underwater obstacles creating entrapment dangers</li>
<li><strong>Capsizing:</strong> Sudden weather changes, strong currents, or improper loading causing vessel instability</li>
<li><strong>Inadequate safety equipment:</strong> Failure to provide or require properly fitting life jackets</li>
</ul>

<h2>Georgia &amp; South Carolina Paddling Regulations</h2>
<p>Georgia's boating safety laws (<a href="https://law.justia.com/codes/georgia/title-52/chapter-7/" target="_blank" rel="noopener">O.C.G.A. § 52-7-1 et seq.</a>) require kayaks and canoes to carry at least one U.S. Coast Guard-approved personal flotation device for each occupant. South Carolina (<a href="https://www.scstatehouse.gov/code/t50c021.php" target="_blank" rel="noopener">S.C. Code § 50-21-10 et seq.</a>) has similar PFD requirements and mandates that children under 12 wear a life jacket at all times on any vessel, including kayaks and canoes. Both states require non-motorized vessels to display navigation lights if operated between sunset and sunrise.</p>
<p>Additionally, both Georgia and South Carolina require outfitter and livery operations to comply with safety standards, including providing Coast Guard-approved equipment and conducting safety orientations for rental customers.</p>

<h2>Injuries in Paddling Accidents</h2>
<p>Kayak and canoe accidents frequently result in drowning and near-drowning injuries, hypothermia from cold-water immersion, <a href="/brain-injury-lawyers/">traumatic brain injuries</a> from collisions with rocks or vessels, shoulder dislocations and rotator cuff tears, <a href="/spinal-cord-injury-lawyers/">spinal cord injuries</a>, and lacerations from propeller strikes. The lack of protective structure around paddlers makes them extremely vulnerable in collisions with motorized vessels.</p>

<h2>Pursuing a Paddling Accident Claim</h2>
<p>Liability in kayak and canoe accidents may rest with negligent motorboat operators who failed to yield or maintain safe distance, tour outfitters who provided unsafe equipment or guides, property owners who failed to warn of known waterway hazards, government entities responsible for maintaining safe waterway conditions, and <a href="/product-liability-lawyers/">manufacturers of defective kayaks, canoes, or safety equipment</a>. Georgia's comparative fault statute (O.C.G.A. § 51-12-33) allows you to recover damages if your fault is less than 50%. South Carolina permits recovery if your fault is less than 51%. Our attorneys fight to maximize compensation for kayak and canoe accident victims — contact Roden Law for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue if a motorboat hit my kayak?',
                'answer'   => 'Yes. Motorboat operators have a duty to maintain a proper lookout, yield right-of-way to non-motorized vessels when required, and avoid creating dangerous wakes near paddle craft. If a motorboat operator\'s negligence caused your accident, you can pursue a personal injury claim.',
            ),
            array(
                'question' => 'Is a kayak tour company liable if I get hurt during a guided trip?',
                'answer'   => 'Tour companies and outfitters may be liable if they provided defective equipment, failed to conduct adequate safety briefings, employed unqualified guides, or took participants into unsafe conditions. Signed waivers do not always bar claims, especially involving gross negligence.',
            ),
            array(
                'question' => 'Do I have to wear a life jacket in a kayak in Georgia?',
                'answer'   => 'Georgia law requires kayaks to carry one Coast Guard-approved PFD per occupant, but adult paddlers are not required to wear them at all times. However, children under 13 must wear a PFD. South Carolina has similar requirements with mandatory wear for children under 12.',
            ),
            array(
                'question' => 'What should I do after a kayak or canoe accident?',
                'answer'   => 'Get to safety, call 911, seek medical attention, document the scene with photos if possible, report the incident to the state Department of Natural Resources, preserve your equipment, and contact an attorney before speaking with insurance companies.',
            ),
            array(
                'question' => 'How long do I have to file a kayak accident claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years (O.C.G.A. § 9-3-33). In South Carolina, you have 3 years (S.C. Code § 15-3-530). Acting quickly preserves critical evidence.',
            ),
        ),
    ),

    /* ============================================================
       6. Boating Under the Influence (BUI)
       ============================================================ */
    array(
        'title'   => 'Boating Under the Influence (BUI) Lawyers',
        'slug'    => 'boating-under-influence',
        'excerpt' => 'Injured by a boater operating under the influence in Georgia or South Carolina? Our attorneys pursue maximum compensation and punitive damages against impaired boaters and enabling parties.',
        'content' => <<<'HTML'
<h2>Boating Under the Influence Accident Claims</h2>
<p>Boating under the influence (BUI) is a leading cause of fatal boating accidents in the United States. The <a href="https://www.uscgboating.org/" target="_blank" rel="noopener">U.S. Coast Guard</a> reports that alcohol is the leading known contributing factor in fatal boating accidents, involved in nearly one-fifth of all boating deaths annually. The effects of alcohol are amplified on the water due to sun exposure, wind, wave motion, and fatigue — a phenomenon known as "boater's hypnosis" that accelerates impairment compared to driving on land.</p>
<p>At Roden Law, our BUI accident lawyers represent victims of impaired boating throughout the waterways of Georgia and South Carolina. Similar to <a href="/car-accident-lawyers/drunk-driver-accident/">drunk driving accident claims</a>, BUI cases allow victims to pursue enhanced damages, including punitive damages, against impaired operators.</p>

<h2>Georgia &amp; South Carolina BUI Laws</h2>
<p>Both Georgia and South Carolina prohibit operating any vessel with a blood alcohol concentration (BAC) of 0.08% or higher, mirroring DUI thresholds for motor vehicles:</p>
<ul>
<li><strong>Georgia BUI law</strong> (<a href="https://law.justia.com/codes/georgia/title-52/chapter-7/article-3/" target="_blank" rel="noopener">O.C.G.A. § 52-7-12</a>) prohibits operating any vessel while under the influence of alcohol or drugs. Penalties include fines, jail time, and mandatory boater safety courses.</li>
<li><strong>South Carolina BUI law</strong> (<a href="https://www.scstatehouse.gov/code/t50c021.php" target="_blank" rel="noopener">S.C. Code § 50-21-112 et seq.</a>) similarly criminalizes boating under the influence with escalating penalties for repeat offenses.</li>
</ul>
<p>Both states authorize law enforcement officers to conduct field sobriety testing and chemical testing on boat operators suspected of BUI. Refusal to submit to testing can result in license suspensions and adverse inferences in civil proceedings.</p>

<h2>Why BUI Is More Dangerous Than DUI</h2>
<p>The boating environment amplifies the effects of alcohol in several critical ways:</p>
<ul>
<li><strong>Sun and heat exposure:</strong> Accelerate alcohol absorption and dehydration</li>
<li><strong>Wave motion and vibration:</strong> Impair balance and coordination beyond alcohol's direct effects</li>
<li><strong>Glare and wind:</strong> Reduce visibility and situational awareness</li>
<li><strong>No lanes, signals, or signs:</strong> Waterways lack the traffic control infrastructure that helps impaired drivers on roads</li>
<li><strong>Limited safety equipment:</strong> Boats lack seatbelts, airbags, and crumple zones found in automobiles</li>
</ul>
<p>Research from the <a href="https://www.cdc.gov/drowning/" target="_blank" rel="noopener">Centers for Disease Control and Prevention (CDC)</a> confirms that alcohol use increases the risk of drowning and boating fatalities by impairing judgment, balance, and the body's ability to respond to cold-water immersion.</p>

<h2>Punitive Damages in BUI Cases</h2>
<p>Both Georgia and South Carolina allow courts to award punitive damages in BUI cases to punish the impaired boater's reckless disregard for the safety of others on the water. Georgia generally caps punitive damages at $250,000 (O.C.G.A. § 51-12-5.1), though exceptions exist for cases involving impaired operation. South Carolina does not impose a statutory cap but requires clear and convincing evidence of willful, wanton, or reckless conduct — a standard readily met in BUI cases.</p>

<h2>Holding All Responsible Parties Accountable</h2>
<p>Beyond the impaired operator, additional parties may share liability in BUI accident cases: marina restaurants and bars that served visibly intoxicated boaters, boat rental companies that rented to obviously impaired customers, boat owners who knowingly allowed an intoxicated person to operate their vessel, and employers whose employees were operating commercial vessels under the influence. Our attorneys investigate every potential source of liability and insurance coverage to maximize recovery for BUI accident victims.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the legal BAC limit for boating in Georgia and South Carolina?',
                'answer'   => 'Both states set the legal limit at 0.08% BAC for boaters 21 and older, the same threshold as driving. Georgia law (O.C.G.A. § 52-7-12) and South Carolina law (S.C. Code § 50-21-112) criminalize operating any vessel at or above this level.',
            ),
            array(
                'question' => 'Can I get punitive damages if a drunk boater injured me?',
                'answer'   => 'Yes. Both Georgia and South Carolina allow punitive damages in BUI cases. Georgia caps most punitive awards at $250,000 with exceptions for impaired operation cases. South Carolina has no statutory cap but requires clear and convincing evidence of reckless conduct.',
            ),
            array(
                'question' => 'Can I sue a marina bar that served the drunk boater?',
                'answer'   => 'Potentially. Under Georgia\'s dram shop law (O.C.G.A. § 51-1-40) and South Carolina\'s statute (S.C. Code § 61-4-580), establishments that serve visibly intoxicated persons who then cause injuries may be held liable.',
            ),
            array(
                'question' => 'Is BUI a criminal offense in Georgia?',
                'answer'   => 'Yes. Georgia BUI (O.C.G.A. § 52-7-12) is a misdemeanor with penalties including fines up to $1,000, up to 12 months in jail, and mandatory completion of a boater safety course. Repeat offenses carry enhanced penalties.',
            ),
            array(
                'question' => 'How does a criminal BUI case affect my civil injury claim?',
                'answer'   => 'The criminal case and civil case are separate proceedings. A BUI conviction provides strong evidence of negligence in your civil claim, but you can pursue civil damages regardless of the criminal outcome, using a lower burden of proof.',
            ),
        ),
    ),

    /* ============================================================
       7. Commercial Vessel Accident
       ============================================================ */
    array(
        'title'   => 'Commercial Vessel Accident Lawyers',
        'slug'    => 'commercial-vessel-accident',
        'excerpt' => 'Injured in a commercial vessel accident in Georgia or South Carolina? Our attorneys handle claims involving ferries, charter boats, fishing vessels, and commercial shipping operations under state and federal maritime law.',
        'content' => <<<'HTML'
<h2>Commercial Vessel Accident Claims</h2>
<p>Commercial vessel accidents on the waterways of Georgia and South Carolina present complex legal claims that often involve overlapping federal maritime law and state negligence statutes. Commercial vessels — including charter fishing boats, tour boats, ferries, shrimping vessels, cargo ships, and tugboats — are subject to heightened safety standards and regulatory requirements from the <a href="https://www.uscg.mil/" target="_blank" rel="noopener">U.S. Coast Guard</a> and federal maritime agencies.</p>
<p>At Roden Law, our <a href="/maritime-injury-lawyers/">maritime injury attorneys</a> have extensive experience representing workers and passengers injured in commercial vessel accidents. The ports of Savannah and Charleston are among the busiest on the East Coast, and the surrounding waterways see heavy commercial traffic daily, increasing the risk of serious maritime accidents.</p>

<h2>Federal Maritime Law &amp; State Regulations</h2>
<p>Commercial vessel accidents may be governed by a combination of federal maritime law and state statutes:</p>
<ul>
<li><strong>Jones Act (46 U.S.C. § 30104):</strong> Provides seamen injured in the course of employment a cause of action against their employer for negligence</li>
<li><strong>Longshore and Harbor Workers' Compensation Act (LHWCA):</strong> Covers maritime workers not classified as seamen, including dock workers and harbor construction workers</li>
<li><strong>General maritime law:</strong> Provides additional remedies including maintenance and cure (medical expenses and living costs during recovery) and unseaworthiness claims</li>
<li><strong>Georgia Boat Safety Act</strong> (<a href="https://law.justia.com/codes/georgia/title-52/chapter-7/" target="_blank" rel="noopener">O.C.G.A. § 52-7-1 et seq.</a>): Applies to commercial vessel operations in Georgia waters</li>
<li><strong>South Carolina boating laws</strong> (<a href="https://www.scstatehouse.gov/code/t50c021.php" target="_blank" rel="noopener">S.C. Code § 50-21-10 et seq.</a>): Governs commercial vessel operations in South Carolina waters</li>
</ul>

<h2>Types of Commercial Vessel Accidents</h2>
<p>Our attorneys handle claims arising from all types of commercial vessel incidents:</p>
<ul>
<li>Charter fishing boat accidents and passenger injuries</li>
<li>Tour boat capsizings and collisions</li>
<li>Ferry accidents injuring passengers and crew</li>
<li>Commercial fishing vessel collisions and equipment failures</li>
<li>Tugboat and barge accidents on rivers and in port</li>
<li>Cargo ship accidents injuring dock workers and longshoremen</li>
</ul>

<h2>Crew Member vs. Passenger Claims</h2>
<p>The legal framework differs significantly depending on whether the injured person is a crew member or a passenger. Crew members classified as "seamen" may pursue Jones Act claims against their employer for negligence, unseaworthiness claims against the vessel owner, and maintenance and cure benefits regardless of fault. Passengers and third parties injured by commercial vessels typically pursue negligence claims under general maritime law or state personal injury statutes. Our <a href="/maritime-injury-lawyers/">maritime injury lawyers</a> determine the optimal legal framework for each client's situation.</p>

<h2>Why Commercial Vessel Cases Require Specialized Attorneys</h2>
<p>Commercial vessel accident cases involve unique legal doctrines including limitation of liability, choice of law between federal maritime and state statutes, U.S. Coast Guard investigation procedures, and complex insurance coverage issues. Additionally, evidence preservation is critical — vessel logs, inspection records, crew certifications, and electronic navigation data must be secured before they are lost or destroyed. Our attorneys act quickly to preserve evidence and build strong cases for maximum compensation. Contact Roden Law for a free maritime accident consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Does maritime law or state law apply to my commercial vessel accident?',
                'answer'   => 'It depends on the location of the accident, the type of vessel, and whether you were a crew member or passenger. Accidents on navigable waters are often governed by federal maritime law, which may provide different remedies than state law. An experienced maritime attorney can determine which laws apply.',
            ),
            array(
                'question' => 'What is a Jones Act claim?',
                'answer'   => 'The Jones Act (46 U.S.C. § 30104) allows seamen injured during employment to sue their employer for negligence. Unlike workers\' compensation, Jones Act claims allow recovery for pain and suffering and are tried before a jury.',
            ),
            array(
                'question' => 'Can passengers sue charter boat operators for injuries?',
                'answer'   => 'Yes. Charter boat operators owe passengers a duty of reasonable care. If the operator was negligent — through reckless operation, failure to maintain the vessel, inadequate safety equipment, or BUI — passengers can pursue injury claims.',
            ),
            array(
                'question' => 'What is maintenance and cure in maritime law?',
                'answer'   => 'Maintenance and cure is a maritime remedy requiring vessel owners to pay injured seamen\'s living expenses (maintenance) and medical costs (cure) during recovery, regardless of fault. This obligation continues until the seaman reaches maximum medical improvement.',
            ),
            array(
                'question' => 'How long do I have to file a maritime injury claim?',
                'answer'   => 'The statute of limitations varies by claim type. Jones Act claims must be filed within 3 years. General maritime negligence claims have a 3-year deadline. LHWCA claims must be filed within 1 year. State law claims follow the 2-year (Georgia) or 3-year (South Carolina) deadlines.',
            ),
        ),
    ),

    /* ============================================================
       8. Dock and Marina Injury
       ============================================================ */
    array(
        'title'   => 'Dock and Marina Injury Lawyers',
        'slug'    => 'dock-marina-injury',
        'excerpt' => 'Injured at a dock, marina, or boat ramp in Georgia or South Carolina? Our attorneys hold property owners and marina operators accountable for unsafe conditions that cause slips, falls, and other injuries.',
        'content' => <<<'HTML'
<h2>Dock &amp; Marina Injury Claims in Georgia &amp; South Carolina</h2>
<p>Docks, marinas, boat ramps, and waterfront facilities present a variety of hazards that can cause serious injuries to boaters, marina workers, and visitors. Wet and slippery surfaces, poorly maintained walkways, unsecured dock sections, inadequate lighting, and defective equipment create conditions for devastating accidents. Georgia and South Carolina's extensive coastlines, rivers, and lake communities support hundreds of marinas and public boat ramps where injuries regularly occur.</p>
<p>At Roden Law, our dock and marina injury lawyers understand the intersection of <a href="/premises-liability-lawyers/">premises liability law</a> and boating regulations that govern these claims. Whether you were injured at a private marina, public boat ramp, or commercial waterfront facility, we pursue full compensation from negligent property owners and operators.</p>

<h2>Common Dock &amp; Marina Hazards</h2>
<p>Marina and dock injuries frequently result from hazardous conditions that property owners fail to address:</p>
<ul>
<li><strong>Slippery surfaces:</strong> Wet docks, algae-covered walkways, and unfinished decking cause <a href="/slip-and-fall-lawyers/">slip and fall accidents</a></li>
<li><strong>Structural failures:</strong> Rotting dock boards, loose railings, and collapsing pilings</li>
<li><strong>Inadequate lighting:</strong> Poorly lit docks and walkways creating trip and fall hazards at night</li>
<li><strong>Electrical hazards:</strong> Faulty wiring and improper grounding causing <a href="/burn-injury-lawyers/electrical-burn-injury/">electric shock and electrocution</a>, including electric shock drowning in the water around docks</li>
<li><strong>Unsecured floating docks:</strong> Dock sections that shift or detach, causing falls into the water</li>
<li><strong>Fueling hazards:</strong> Fuel spills, vapor ignition, and inadequate ventilation at marina fuel stations</li>
<li><strong>Boat lift and hoist failures:</strong> Mechanical failures during boat launching and retrieval operations</li>
</ul>

<h2>Premises Liability at Marinas</h2>
<p>Marina and dock injury claims are primarily governed by premises liability law. Under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>), property owners owe a duty of ordinary care to invitees — people lawfully on the property for the owner's benefit, such as paying slip renters and fuel customers. South Carolina imposes a similar duty of care, requiring property owners to maintain their premises in a reasonably safe condition and warn of known hazards.</p>
<p>Marina operators have specific obligations to inspect and maintain docks and walkways, provide adequate lighting and non-slip surfaces, ensure electrical systems meet safety codes, post warnings about known hazards, maintain proper safety equipment including life rings and ladders at dock edges, and comply with applicable building codes and marina industry standards.</p>

<h2>Electric Shock Drowning</h2>
<p>One of the most insidious dangers at marinas is electric shock drowning (ESD), which occurs when faulty electrical systems send alternating current into the water around docks. Swimmers and people who fall into the water near energized docks can be paralyzed by the electrical current, leading to drowning. ESD is often undetectable until it is too late. Marina operators have a duty to properly ground and maintain their electrical systems, install ground fault protection, and post warnings prohibiting swimming near docks with electrical service.</p>

<h2>Pursuing a Dock or Marina Injury Claim</h2>
<p>Potentially liable parties in dock and marina injury cases include marina owners and operators who failed to maintain safe premises, dock construction companies that performed substandard work, electrical contractors responsible for faulty wiring, equipment manufacturers whose products failed, and government entities that maintain public boat ramps and waterfront facilities. Georgia's comparative fault rule (O.C.G.A. § 51-12-33) allows recovery if you are less than 50% at fault, while South Carolina permits recovery if less than 51% at fault. Our attorneys conduct thorough investigations of dock and marina conditions to build strong cases for maximum compensation. Contact Roden Law today for a free consultation — there is no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who is liable if I slip and fall on a wet dock?',
                'answer'   => 'The marina or dock owner may be liable if they failed to maintain non-slip surfaces, provide adequate drainage, post warning signs, or take reasonable steps to keep walkways safe. Premises liability law requires property owners to exercise ordinary care for invitees.',
            ),
            array(
                'question' => 'What is electric shock drowning?',
                'answer'   => 'Electric shock drowning occurs when faulty electrical systems at docks or marinas leak alternating current into the surrounding water. Swimmers can be paralyzed by the current and drown. Marina operators have a duty to maintain properly grounded electrical systems and install ground fault protection.',
            ),
            array(
                'question' => 'Can I sue a public boat ramp owner for my injuries?',
                'answer'   => 'Government entities that operate public boat ramps may be liable for injuries caused by dangerous conditions, though sovereign immunity rules in Georgia and South Carolina may limit claims. An attorney can evaluate whether exceptions to immunity apply in your case.',
            ),
            array(
                'question' => 'What evidence should I gather after a marina injury?',
                'answer'   => 'Photograph the hazardous condition that caused your injury, document wet surfaces or broken structures, get names and contact information of witnesses, report the incident to marina management, seek immediate medical attention, and preserve all clothing and footwear worn during the incident.',
            ),
            array(
                'question' => 'How long do I have to file a dock injury claim?',
                'answer'   => 'In Georgia, the statute of limitations for premises liability claims is 2 years (O.C.G.A. § 9-3-33). In South Carolina, it is 3 years (S.C. Code § 15-3-530). Claims against government entities may have shorter notice requirements.',
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
