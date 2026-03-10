<?php
/**
 * Seeder: 6 Golf Cart Accident Sub-Type Pages
 *
 * Creates 6 child posts under the golf-cart-accident-lawyers pillar,
 * each covering a specific type of golf cart accident.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-golf-cart-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: golf-cart-accident-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'golf-cart-accident-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'golf-cart-accident-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "golf-cart-accident-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'golf-cart-accidents', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Golf Cart Accidents', 'practice_category', array( 'slug' => 'golf-cart-accidents' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Golf Cart Rollover Accident
       ============================================================ */
    array(
        'title'   => 'Golf Cart Rollover Accident Lawyers',
        'slug'    => 'golf-cart-rollover',
        'excerpt' => 'Injured in a golf cart rollover in Georgia or South Carolina? Our attorneys pursue claims against negligent operators, golf courses, and manufacturers when golf cart rollovers cause serious injuries.',
        'content' => <<<'HTML'
<h2>Golf Cart Rollover Accidents in Georgia &amp; South Carolina</h2>
<p>Golf carts are lightweight, open-sided vehicles with a high center of gravity relative to their narrow wheelbase — a combination that makes them susceptible to tipping and rolling over, especially during sharp turns, on slopes, and at speeds above their design limits. According to the <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">Consumer Product Safety Commission (CPSC)</a>, golf cart-related injuries send approximately 18,000 people to emergency rooms annually in the United States, with rollovers accounting for a significant portion of the most serious injuries including traumatic brain injuries, spinal cord damage, and crush injuries.</p>
<p>At Roden Law, our golf cart accident attorneys represent rollover victims throughout Georgia and South Carolina — from golf courses in Savannah and Hilton Head to retirement communities in Myrtle Beach and Sun City. We investigate the cause of every rollover to determine whether negligence by the operator, property owner, or manufacturer contributed to your injuries.</p>

<h2>What Causes Golf Cart Rollovers</h2>
<p>Golf cart rollovers typically result from one or more contributing factors:</p>
<ul>
<li><strong>Sharp turns at excessive speed:</strong> Golf carts lack the suspension, tire grip, and low center of gravity needed to handle aggressive turning — even at modest speeds of 12–15 mph</li>
<li><strong>Steep or uneven terrain:</strong> Hillsides, drainage ditches, cart path edges, and sudden grade changes that exceed the cart's stability limits</li>
<li><strong>Overloading:</strong> Carrying too many passengers or heavy equipment that raises the center of gravity and alters handling characteristics</li>
<li><strong>Cart path hazards:</strong> Crumbling cart path edges, tree roots lifting pavement, wet or muddy surfaces, and missing guardrails at elevated sections</li>
<li><strong>Mechanical failures:</strong> Steering defects, brake failures, and tire blowouts that cause the operator to lose control</li>
<li><strong>Passengers leaning or shifting weight:</strong> Sudden weight shifts by passengers, especially when standing or reaching for items during a turn</li>
</ul>
<p>Golf cart rollovers and <a href="/golf-cart-accident-lawyers/golf-cart-passenger-ejection/">passenger ejections</a> frequently occur together — the open-sided design of most golf carts means that occupants are thrown from the vehicle during a rollover, often suffering injuries worse than if they had remained inside the cart.</p>

<h2>Georgia &amp; South Carolina Golf Cart Laws</h2>
<p>Georgia regulates golf carts under <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/" target="_blank" rel="noopener">O.C.G.A. § 40-6-330 et seq.</a>, which governs golf cart operation on public roads, residential streets, and designated golf cart paths. Georgia law permits golf cart operation on roads with speed limits of 25 mph or less (or 35 mph in certain designated areas) and requires basic safety equipment including headlights, taillights, and reflectors for road use.</p>
<p>South Carolina does not have a comprehensive statewide golf cart statute, so regulation falls largely to local ordinances. Communities like Hilton Head Island, Kiawah Island, Sun City, and many Myrtle Beach-area developments have adopted specific golf cart regulations governing speed limits, road access, and equipment requirements. In both states, golf cart operators and property owners owe a duty of care to passengers and bystanders, and rollover accidents caused by negligence give rise to personal injury claims.</p>

<h2>Liability for Golf Cart Rollovers</h2>
<p>Multiple parties may bear responsibility for a golf cart rollover:</p>
<ul>
<li><strong>The operator:</strong> Drivers who speed, make reckless turns, overload the cart, or operate while impaired</li>
<li><strong>Golf courses and resorts:</strong> Property owners who fail to maintain safe cart paths, warn of steep terrain, or enforce speed limits</li>
<li><strong>Golf cart manufacturers:</strong> Companies that produce carts with defective steering, inadequate stability margins, or insufficient rollover warnings</li>
<li><strong>HOAs and community associations:</strong> Residential communities that permit golf cart use without adequate infrastructure or safety regulations</li>
</ul>

<h2>Damages in Golf Cart Rollover Cases</h2>
<p>Golf cart rollover injuries are often severe because occupants are unrestrained and exposed. Common injuries include traumatic brain injuries from impact with the ground, spinal cord injuries and paralysis, crush injuries from the cart landing on the occupant, broken bones and dislocations, and road rash and lacerations. Recoverable damages include medical expenses, lost wages, pain and suffering, permanent disability, and disfigurement. Georgia's statute of limitations is 2 years (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>), while South Carolina allows 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>).</p>

<h2>Why Choose Roden Law for Golf Cart Rollover Claims</h2>
<p>Our attorneys have extensive experience with golf cart accident claims across coastal Georgia and South Carolina — communities where golf carts are a primary mode of transportation. We understand the unique liability questions these cases present and have the resources to pursue claims against golf courses, resorts, manufacturers, and community associations. We work on a contingency fee basis — you pay nothing unless we recover compensation for you.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What makes golf carts prone to rollovers?',
                'answer'   => 'Golf carts have a high center of gravity, narrow wheelbase, small wheels, and limited suspension — making them inherently unstable during turns, on slopes, and at speeds above 10-12 mph. Their open-sided design also means occupants are unprotected during a rollover.',
            ),
            array(
                'question' => 'Can I sue the golf course if my cart rolled over on their property?',
                'answer'   => 'Yes. Golf courses have a duty to maintain safe cart paths, warn of hazards like steep slopes or sharp curves, and ensure their carts are in proper working condition. A golf course that fails in these duties can be held liable under Georgia or South Carolina premises liability law.',
            ),
            array(
                'question' => 'Is the golf cart manufacturer liable for a rollover?',
                'answer'   => 'Potentially yes. If the cart had a design defect — such as an excessively high center of gravity, defective steering, or brake failure — the manufacturer can be held strictly liable under Georgia (O.C.G.A. § 51-1-11) and South Carolina (S.C. Code § 15-73-10) product liability law.',
            ),
            array(
                'question' => 'What should I do after a golf cart rollover accident?',
                'answer'   => 'Call 911, seek medical attention immediately, photograph the scene including the cart and terrain, note the cart\'s make, model, and any visible damage, get witness information, report the incident to the property owner, and contact a golf cart accident attorney.',
            ),
            array(
                'question' => 'What is the statute of limitations for a golf cart rollover claim?',
                'answer'   => 'In Georgia, you have 2 years from the date of injury to file a lawsuit (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530). Contact an attorney promptly to preserve evidence and protect your rights.',
            ),
        ),
    ),

    /* ============================================================
       2. Golf Cart vs. Vehicle Collision
       ============================================================ */
    array(
        'title'   => 'Golf Cart vs. Vehicle Collision Lawyers',
        'slug'    => 'golf-cart-vehicle-collision',
        'excerpt' => 'Hit by a car while in a golf cart in Georgia or South Carolina? Our attorneys fight for golf cart occupants injured in collisions with motor vehicles on roads and in communities.',
        'content' => <<<'HTML'
<h2>Golf Cart vs. Vehicle Collision Claims</h2>
<p>As golf cart use expands beyond golf courses and into residential communities, retail areas, and public roadways, collisions between golf carts and motor vehicles have become increasingly common — and increasingly devastating. Golf carts typically weigh 500-1,000 pounds and travel at 15-25 mph, while even a midsize sedan weighs over 3,000 pounds. This massive disparity in size, weight, and speed means that golf cart occupants bear the overwhelming brunt of injury in any collision with a motor vehicle. The lack of airbags, seatbelts, doors, and crumple zones on standard golf carts leaves occupants completely exposed to impact forces.</p>
<p>At Roden Law, our golf cart accident attorneys represent golf cart occupants injured in collisions with cars, trucks, and SUVs throughout Georgia and South Carolina. We understand the unique liability issues these cases present and aggressively pursue compensation from negligent motorists and their insurance companies.</p>

<h2>Where Golf Cart vs. Vehicle Collisions Occur</h2>
<p>Golf cart-vehicle collisions happen in several common settings:</p>
<ul>
<li><strong>Residential community roads:</strong> Golf cart communities like those on Hilton Head Island, Peachtree City, and throughout the Lowcountry where carts share roads with cars</li>
<li><strong>Public road crossings:</strong> Golf carts crossing multi-lane roads at designated and undesignated crossing points</li>
<li><strong>Parking lots and shopping centers:</strong> Golf carts navigating retail and commercial parking areas</li>
<li><strong>Intersections:</strong> Golf carts entering intersections where drivers fail to yield or cannot see the low-profile cart</li>
<li><strong>Golf course-adjacent roads:</strong> Carts crossing roads that run between holes on a golf course</li>
<li><strong>Resort and hotel properties:</strong> Areas where golf carts and motor vehicles share access roads</li>
</ul>

<h2>Georgia &amp; South Carolina Road Use Laws</h2>
<p>Georgia law under <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/" target="_blank" rel="noopener">O.C.G.A. § 40-6-330 et seq.</a> permits golf carts on public roads with speed limits of 25 mph or less (extendable to 35 mph by local ordinance) and requires basic safety equipment including working headlights, taillights, and reflectors. When a golf cart is lawfully operating on a public road, motorists owe the same duty of care they owe to any other road user — they must maintain a safe following distance, yield the right of way as required, and exercise reasonable caution.</p>
<p>South Carolina regulates golf cart road use through local ordinances, with communities throughout the Lowcountry, Grand Strand, and Midlands having adopted specific golf cart traffic rules. In both states, a motorist who negligently collides with a lawfully operating golf cart is liable for the resulting injuries under standard negligence principles. Even where a golf cart is operating outside its permitted zone, comparative fault applies — the motor vehicle driver still bears responsibility for their own negligence.</p>

<h2>Visibility and Negligence Issues</h2>
<p>Golf carts are significantly smaller, lower, and slower than passenger vehicles, creating visibility challenges for both golf cart operators and motor vehicle drivers. Insurance companies frequently argue that the golf cart's low profile contributed to the collision — but this argument often fails because motorists have a duty to watch for all road users, including smaller vehicles. Our attorneys counter these defense arguments with evidence of the driver's distraction, speed, or failure to yield.</p>

<h2>Comparative Fault in Golf Cart vs. Vehicle Cases</h2>
<p>Georgia applies modified comparative fault under <a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>, allowing recovery if the golf cart occupant is less than 50% at fault. South Carolina similarly bars recovery only if the injured party is 51% or more at fault. Even if the golf cart operator made an error — such as crossing a road without looking or failing to use headlights at dusk — the motor vehicle driver may still bear the majority of fault if they were speeding, distracted, or impaired.</p>

<h2>Damages in Golf Cart vs. Vehicle Collisions</h2>
<p>Because golf carts offer virtually no occupant protection, vehicle collisions frequently produce catastrophic injuries including traumatic brain injuries, spinal cord injuries, multiple fractures, internal organ damage, and fatalities. Recoverable damages include all medical expenses, lost wages, pain and suffering, permanent disability, and in fatal cases, <a href="/wrongful-death-lawyers/">wrongful death damages</a>. The personal injury statute of limitations is 2 years in Georgia (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) and 3 years in South Carolina (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>).</p>

<h2>Why Choose Roden Law for Golf Cart vs. Vehicle Claims</h2>
<p>Our attorneys serve communities across coastal Georgia and South Carolina where golf carts are a daily mode of transportation. We understand the traffic patterns, local ordinances, and common collision scenarios unique to these communities. We work on a contingency fee basis and fight aggressively to secure full compensation for golf cart occupants injured by negligent motorists.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I recover compensation if a car hit my golf cart on a public road?',
                'answer'   => 'Yes. If the motor vehicle driver was negligent — speeding, distracted, failing to yield, or driving impaired — they are liable for your injuries. Georgia (O.C.G.A. § 40-6-330) permits golf carts on roads with speed limits of 25 mph or less, and motorists must exercise care around them.',
            ),
            array(
                'question' => 'What if the driver says they could not see my golf cart?',
                'answer'   => 'Motorists have a duty to watch for all road users, including golf carts. Failing to see a lawfully operating golf cart is evidence of negligence, not a defense. Our attorneys use this argument to establish the driver\'s fault.',
            ),
            array(
                'question' => 'Are golf cart passengers eligible for compensation after a vehicle collision?',
                'answer'   => 'Absolutely. Passengers in a golf cart struck by a motor vehicle can pursue claims against the negligent driver regardless of any fault attributed to the golf cart operator. Passengers are rarely found at fault in collision cases.',
            ),
            array(
                'question' => 'What injuries are common in golf cart vs. vehicle collisions?',
                'answer'   => 'Due to the lack of seatbelts, airbags, and doors on standard golf carts, occupants frequently suffer traumatic brain injuries, spinal cord injuries, broken bones, internal organ damage, and ejection injuries. These collisions are often catastrophic.',
            ),
            array(
                'question' => 'How long do I have to file a claim after a golf cart-vehicle collision?',
                'answer'   => 'Georgia allows 2 years from the date of the accident (O.C.G.A. § 9-3-33), and South Carolina allows 3 years (S.C. Code § 15-3-530). Contact an attorney promptly to preserve evidence and protect your right to compensation.',
            ),
        ),
    ),

    /* ============================================================
       3. Golf Cart Passenger Ejection
       ============================================================ */
    array(
        'title'   => 'Golf Cart Passenger Ejection Lawyers',
        'slug'    => 'golf-cart-passenger-ejection',
        'excerpt' => 'Thrown from a golf cart and injured in Georgia or South Carolina? Our attorneys represent passengers ejected from golf carts due to reckless driving, mechanical failures, and inadequate safety features.',
        'content' => <<<'HTML'
<h2>Golf Cart Passenger Ejection Injuries</h2>
<p>One of the most dangerous aspects of golf cart design is the complete absence of occupant restraint systems and enclosed cabin protection in most standard golf carts. Unlike automobiles, golf carts typically have no seatbelts, no doors, no side panels, and no rollover protection — leaving passengers vulnerable to being thrown from the vehicle during sudden stops, sharp turns, collisions, and <a href="/golf-cart-accident-lawyers/golf-cart-rollover/">rollovers</a>. According to the <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">CPSC</a>, passenger ejection is one of the leading mechanisms of injury in golf cart accidents, frequently resulting in traumatic brain injuries, spinal cord damage, and fatal injuries.</p>
<p>At Roden Law, our golf cart accident attorneys represent passengers ejected from golf carts across Georgia and South Carolina. We investigate whether the ejection was caused by operator negligence, a vehicle defect, or dangerous property conditions — and pursue maximum compensation from all responsible parties.</p>

<h2>Common Causes of Passenger Ejection</h2>
<p>Passengers are thrown from golf carts under a range of preventable circumstances:</p>
<ul>
<li><strong>Sharp turns at excessive speed:</strong> The operator turns sharply while traveling too fast, generating centrifugal force that throws unsecured passengers off the side of the cart</li>
<li><strong>Sudden braking:</strong> Hard stops that pitch passengers forward, especially rear-facing passengers on carts with rear seats</li>
<li><strong>Rollover events:</strong> The cart tips onto its side or rolls completely, throwing all occupants from the vehicle (see <a href="/golf-cart-accident-lawyers/golf-cart-rollover/">golf cart rollovers</a>)</li>
<li><strong>Collisions with vehicles or objects:</strong> Impact forces that dislodge passengers from an open cart (see <a href="/golf-cart-accident-lawyers/golf-cart-vehicle-collision/">golf cart vehicle collisions</a>)</li>
<li><strong>Hitting bumps, curbs, or potholes:</strong> Road surface irregularities that bounce passengers from the seat, particularly on rear-facing bench seats</li>
<li><strong>Reckless or impaired operation:</strong> Operators driving erratically, performing stunts, or operating while under the influence of alcohol (see <a href="/golf-cart-accident-lawyers/golf-cart-dui/">golf cart DUI accidents</a>)</li>
</ul>

<h2>Design Defect and Manufacturer Liability</h2>
<p>The golf cart industry has long faced criticism for producing vehicles without basic occupant protection features. While the market has begun to offer seatbelts and hip restraints on some models, most golf carts in service today — and many new models — still lack these basic safety features. Under Georgia product liability law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-3/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>) and South Carolina's Products Liability Act (<a href="https://www.scstatehouse.gov/code/t15c073.php" target="_blank" rel="noopener">S.C. Code § 15-73-10 et seq.</a>), manufacturers may be held strictly liable for design defects that make their products unreasonably dangerous — including the failure to incorporate feasible safety features like seatbelts, doors, and handgrips that could prevent ejection.</p>
<p>Major golf cart manufacturers including Club Car (Ingersoll Rand), E-Z-GO (Textron), and Yamaha have the engineering capability and resources to incorporate occupant restraint systems. Their failure to do so may constitute a design defect that subjects them to <a href="/product-liability-lawyers/">product liability claims</a> when ejection injuries occur.</p>

<h2>Operator and Property Owner Liability</h2>
<p>Golf cart operators owe their passengers a duty of care to operate the vehicle safely and avoid maneuvers that could eject passengers. Operators who speed, turn sharply, drive recklessly, or operate while impaired can be held personally liable for passenger ejection injuries. Property owners — including golf courses, resorts, residential communities, and commercial properties — may also bear liability if they fail to maintain safe cart paths, enforce speed limits, or regulate golf cart operation on their premises under Georgia premises liability law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>).</p>

<h2>Injuries From Golf Cart Ejection</h2>
<p>Ejection injuries are among the most severe golf cart injuries because the passenger's body strikes the ground, curb, or other hard surface at the cart's speed of travel — without any protective equipment. The most common ejection injuries include traumatic brain injuries (even from low-speed ejections), skull fractures and facial injuries, spinal cord injuries and vertebral fractures, broken hips — particularly devastating for elderly passengers, shoulder and wrist fractures from attempting to break the fall, and road rash and skin avulsions. Georgia allows 2 years to file suit (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>), while South Carolina provides 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>).</p>

<h2>Why Choose Roden Law for Golf Cart Ejection Claims</h2>
<p>Passenger ejection cases often involve complex questions of operator negligence, product design, and property owner responsibility. Our attorneys have the experience and resources to investigate all potential sources of liability and pursue the maximum compensation available under Georgia and South Carolina law. We work on a contingency fee basis — you pay nothing unless we recover for you.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Why do so many golf carts lack seatbelts?',
                'answer'   => 'Most standard golf carts were designed for low-speed golf course use and historically did not include seatbelts. However, as golf carts are increasingly used on roads and in communities at higher speeds, the lack of restraint systems has become a serious safety issue that may give rise to product liability claims.',
            ),
            array(
                'question' => 'Can I sue the golf cart manufacturer if I was ejected due to no seatbelts?',
                'answer'   => 'Yes. Under Georgia (O.C.G.A. § 51-1-11) and South Carolina (S.C. Code § 15-73-10) product liability law, manufacturers can be held liable for design defects — including the failure to incorporate feasible safety features like seatbelts that could have prevented ejection injuries.',
            ),
            array(
                'question' => 'Is the driver liable if I was thrown from the golf cart?',
                'answer'   => 'Yes. Golf cart operators owe passengers a duty of care. Operators who make sharp turns, speed, brake suddenly, or drive recklessly can be held liable for passenger ejection injuries under standard negligence principles.',
            ),
            array(
                'question' => 'Are elderly passengers more at risk for ejection injuries?',
                'answer'   => 'Yes. Elderly passengers are particularly vulnerable due to reduced grip strength, balance issues, and bone density loss. Ejection injuries like hip fractures and traumatic brain injuries can be life-threatening for older adults. This increased vulnerability is factored into damages calculations.',
            ),
            array(
                'question' => 'What compensation is available for a golf cart ejection injury?',
                'answer'   => 'You may recover medical expenses, lost wages, pain and suffering, permanent disability, disfigurement, and in severe cases, loss of quality of life. Product liability claims against the manufacturer may also support punitive damages for conscious disregard of passenger safety.',
            ),
        ),
    ),

    /* ============================================================
       4. Golf Course Cart Accident
       ============================================================ */
    array(
        'title'   => 'Golf Course Cart Accident Lawyers',
        'slug'    => 'golf-course-cart-accident',
        'excerpt' => 'Injured in a golf cart accident on a golf course in Georgia or South Carolina? Our attorneys hold golf courses and resorts liable for unsafe cart paths, poorly maintained carts, and negligent operations.',
        'content' => <<<'HTML'
<h2>Golf Course Cart Accident Claims</h2>
<p>Golf courses are responsible for the safety of the golf carts they own, maintain, and provide to their patrons. When a golf course fails to maintain its cart fleet in safe operating condition, neglects cart path maintenance, or fails to warn of dangerous course conditions, it can be held liable for injuries that result. According to the <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">CPSC</a>, thousands of golf cart injuries occur on golf courses each year, ranging from minor scrapes to catastrophic brain injuries and fatalities — particularly among elderly golfers.</p>
<p>At Roden Law, our golf cart accident attorneys represent golfers and golf course visitors injured in cart accidents across Georgia and South Carolina. From premier resort courses on Hilton Head and Kiawah Island to municipal courses in Savannah, Charleston, and Columbia, we hold golf course operators accountable when their negligence causes preventable injuries.</p>

<h2>Golf Course Negligence: Common Hazards</h2>
<p>Golf courses can create dangerous conditions through a variety of maintenance and operational failures:</p>
<ul>
<li><strong>Poorly maintained cart paths:</strong> Crumbling edges, potholes, tree root upheaval, loose gravel, and missing sections that cause carts to leave the path or tip over</li>
<li><strong>Steep grades without warnings:</strong> Cart paths on hillsides, bridges, and elevated areas without adequate signage, guardrails, or speed warnings</li>
<li><strong>Wet and slippery conditions:</strong> Cart paths flooded by sprinkler systems, morning dew, or rain without "slow down" or "caution" warnings</li>
<li><strong>Defective or poorly maintained carts:</strong> Brake failures, steering defects, throttle malfunctions, and worn tires on carts the course provides to guests</li>
<li><strong>Inadequate cart path design:</strong> Sharp blind curves, paths too narrow for two-cart traffic, and paths that cross pedestrian areas without visibility</li>
<li><strong>Lack of course marshals:</strong> Failure to monitor cart operation and enforce safe driving practices</li>
</ul>

<h2>Georgia &amp; South Carolina Premises Liability</h2>
<p>Golf courses owe their patrons — who are business invitees — the highest duty of care under premises liability law. Georgia's premises liability statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>) requires property owners to exercise ordinary care to keep their premises safe and to warn of hazards that are not obvious to invitees. South Carolina common law imposes a similar duty on business operators to maintain reasonably safe premises and protect invitees from foreseeable harm.</p>
<p>A golf course that knows (or should know) about a dangerous cart path condition, a defective cart in its fleet, or a steep grade that has caused prior accidents — and fails to address the hazard — is negligent. Our attorneys obtain course maintenance records, incident reports, and prior complaint histories to establish that the golf course had notice of the dangerous condition.</p>

<h2>Liability Waivers on Golf Courses</h2>
<p>Many golf courses require players to sign or agree to liability waivers when renting a cart or paying greens fees. While these waivers may limit liability for inherent risks of the game of golf, they generally cannot shield a golf course from claims based on its own negligence — such as providing a defective cart, failing to maintain cart paths, or failing to warn of known hazards. Georgia courts scrutinize exculpatory clauses for clarity, specificity, and public policy considerations. South Carolina similarly limits the enforceability of waivers that attempt to absolve a business of its own negligent conduct.</p>

<h2>Common Golf Course Cart Injuries</h2>
<p>Golf course cart accidents produce a wide range of injuries, from relatively minor to life-threatening. The most common include broken bones (especially wrists, hips, and collarbones), traumatic brain injuries from ejection or rollover, spinal injuries from cart path drops or rough terrain, knee and ankle injuries from passengers stepping off moving carts, lacerations from contact with cart frames and windshields, and concussions from sudden stops. Elderly golfers are disproportionately affected — their reduced bone density and balance make them more vulnerable to serious injury from even low-speed cart incidents.</p>

<h2>Damages and Filing Deadlines</h2>
<p>Injured golfers may recover compensation for medical expenses, lost wages, pain and suffering, rehabilitation costs, permanent disability, and diminished quality of life. Georgia's statute of limitations is 2 years (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>), and South Carolina allows 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). If the golf course is owned by a municipality, shorter government notice deadlines may apply.</p>

<h2>Why Choose Roden Law for Golf Course Cart Claims</h2>
<p>Our firm serves the Georgia and South Carolina coastal communities where golf is a way of life. We understand golf course operations, cart fleet management practices, and the liability standards that apply to these businesses. We handle all golf course cart accident cases on a contingency fee basis — no fees unless we recover compensation for your injuries.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue a golf course for a cart accident on their property?',
                'answer'   => 'Yes. Golf courses owe their patrons a duty of care to maintain safe cart paths, provide carts in good working condition, and warn of known hazards. Failure in any of these duties constitutes negligence under Georgia (O.C.G.A. § 51-3-1) and South Carolina premises liability law.',
            ),
            array(
                'question' => 'Does the waiver I signed at the golf course prevent me from suing?',
                'answer'   => 'Not necessarily. Waivers generally cannot shield a golf course from claims based on its own negligence — such as providing a defective cart or failing to maintain cart paths. Georgia and South Carolina courts scrutinize these waivers and may find them unenforceable.',
            ),
            array(
                'question' => 'What if the golf cart provided by the course had a mechanical problem?',
                'answer'   => 'If the course provided a cart with defective brakes, steering, or other mechanical issues, the course is liable for negligent maintenance. The cart manufacturer may also be liable under product liability law if a manufacturing defect caused the failure.',
            ),
            array(
                'question' => 'Are golf courses liable for cart path hazards?',
                'answer'   => 'Yes. Golf courses must maintain cart paths in reasonably safe condition. Potholes, crumbling edges, steep grades without guardrails, and wet surfaces without warnings are all conditions that can give rise to liability if they cause a cart accident.',
            ),
            array(
                'question' => 'What compensation can I recover from a golf course cart accident?',
                'answer'   => 'You may recover medical expenses, lost wages, pain and suffering, rehabilitation costs, permanent disability, and diminished quality of life. If the course was grossly negligent or ignored known hazards, punitive damages may also be available.',
            ),
        ),
    ),

    /* ============================================================
       5. Golf Cart DUI Accident
       ============================================================ */
    array(
        'title'   => 'Golf Cart DUI Accident Lawyers',
        'slug'    => 'golf-cart-dui',
        'excerpt' => 'Injured by a golf cart operator driving under the influence in Georgia or South Carolina? Our attorneys pursue maximum compensation — including punitive damages — against impaired golf cart drivers.',
        'content' => <<<'HTML'
<h2>Golf Cart DUI Accidents in Georgia &amp; South Carolina</h2>
<p>Many people are surprised to learn that DUI laws apply to golf carts — but in both Georgia and South Carolina, operating a golf cart while under the influence of alcohol or drugs is illegal and can result in criminal DUI charges, exactly as if the driver were operating a car. Despite this, golf cart DUI remains disturbingly common, particularly in resort communities, vacation destinations, and retirement communities where alcohol consumption and golf cart transportation frequently overlap. When an impaired golf cart operator causes an accident, the consequences for passengers, pedestrians, and other road users can be devastating.</p>
<p>At Roden Law, our attorneys represent victims of golf cart DUI accidents across Georgia and South Carolina. These cases often support claims for punitive damages — additional compensation designed to punish the impaired driver's reckless disregard for the safety of others.</p>

<h2>DUI Laws Apply to Golf Carts</h2>
<p>Georgia's DUI statute (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-15/" target="_blank" rel="noopener">O.C.G.A. § 40-6-391</a>) prohibits driving under the influence of alcohol or drugs while operating any "vehicle" — a term that includes golf carts when operated on public roads, cart paths connected to public roads, and in many community settings. The legal BAC limit is 0.08% for drivers 21 and older.</p>
<p>South Carolina's DUI law similarly applies to golf cart operation. Operating a golf cart on any public road or in any publicly accessible area while impaired violates South Carolina's DUI statute and exposes the driver to both criminal penalties and civil liability. A golf cart DUI conviction — or even an arrest — provides powerful evidence in a civil injury lawsuit against the impaired operator.</p>
<p>For additional information about DUI accident claims, see our <a href="/car-accident-lawyers/drunk-driver-accident/">drunk driver accident lawyers</a> page.</p>

<h2>Where Golf Cart DUI Accidents Occur</h2>
<p>Golf cart DUI accidents are particularly common in specific settings:</p>
<ul>
<li><strong>Resort and vacation communities:</strong> Hilton Head Island, Kiawah Island, and Myrtle Beach area communities where golf carts are the primary mode of evening transportation</li>
<li><strong>Retirement communities:</strong> Sun City and similar communities where golf carts are used for daily errands and social events that involve alcohol</li>
<li><strong>Golf courses:</strong> Beverage cart service on courses leads to impaired driving on cart paths and parking areas (see <a href="/golf-cart-accident-lawyers/golf-course-cart-accident/">golf course cart accidents</a>)</li>
<li><strong>Community events and festivals:</strong> Local events where golf cart transportation is combined with alcohol consumption</li>
<li><strong>Restaurant and bar districts:</strong> Areas where patrons use golf carts to travel between nightlife venues</li>
</ul>

<h2>Punitive Damages in Golf Cart DUI Cases</h2>
<p>Both Georgia and South Carolina allow punitive damages in DUI cases to punish the defendant's willful disregard for the safety of others. Georgia generally caps punitive damages at $250,000 under <a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-5-1/" target="_blank" rel="noopener">O.C.G.A. § 51-12-5.1</a>, but this cap does not apply in cases involving DUI or intentional misconduct — meaning punitive damages in golf cart DUI cases can be unlimited. South Carolina allows punitive damages upon proof of willful, wanton, or reckless conduct by clear and convincing evidence, with no statutory cap.</p>

<h2>Proving a Golf Cart DUI Accident Case</h2>
<p>Critical evidence in a golf cart DUI case includes police reports documenting BAC test results and field sobriety observations, witness testimony about the operator's behavior and alcohol consumption, surveillance footage from restaurants, bars, clubhouses, and community cameras, criminal case records including DUI arrest reports and dispositions, receipts and records from bars or restaurants that served the operator, and medical records documenting the victim's injuries. Our attorneys work closely with law enforcement to obtain all available evidence and build the strongest possible case.</p>

<h2>Dram Shop Liability</h2>
<p>If a bar, restaurant, clubhouse, or event host served alcohol to the golf cart operator when they were visibly intoxicated, a dram shop claim may be available. Georgia's dram shop law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-4/" target="_blank" rel="noopener">O.C.G.A. § 51-1-40</a>) and South Carolina's statute (<a href="https://www.scstatehouse.gov/code/t61c004.php" target="_blank" rel="noopener">S.C. Code § 61-4-580</a>) hold alcohol vendors liable when they knowingly serve a visibly intoxicated person who then causes injury. This provides an additional source of compensation beyond the impaired driver's personal assets and insurance.</p>

<h2>Why Choose Roden Law for Golf Cart DUI Claims</h2>
<p>Golf cart DUI cases require aggressive representation to secure the punitive damages and full compensation that victims deserve. Our attorneys have extensive experience with impaired driving cases and understand how to leverage criminal DUI proceedings to strengthen your civil claim. We handle all golf cart DUI cases on a contingency fee basis — no fees unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can you get a DUI on a golf cart in Georgia or South Carolina?',
                'answer'   => 'Yes. Georgia\'s DUI statute (O.C.G.A. § 40-6-391) and South Carolina\'s DUI law both apply to golf carts operated on public roads and in publicly accessible areas. The legal BAC limit of 0.08% applies the same as for car drivers.',
            ),
            array(
                'question' => 'Are punitive damages available in a golf cart DUI accident case?',
                'answer'   => 'Yes. Georgia allows unlimited punitive damages in DUI cases (the standard $250,000 cap under O.C.G.A. § 51-12-5.1 does not apply to DUI). South Carolina also allows punitive damages for willful, wanton, or reckless conduct with no statutory cap.',
            ),
            array(
                'question' => 'Can I sue the bar or restaurant that served the drunk golf cart driver?',
                'answer'   => 'Yes. Under Georgia\'s dram shop law (O.C.G.A. § 51-1-40) and South Carolina\'s statute (S.C. Code § 61-4-580), establishments that knowingly serve alcohol to a visibly intoxicated person can be held liable for injuries that person causes.',
            ),
            array(
                'question' => 'What if the golf cart DUI driver was not convicted in criminal court?',
                'answer'   => 'A criminal conviction is not required for a civil injury claim. Civil cases use a lower "preponderance of evidence" standard, so you may still recover compensation even if criminal charges are reduced or dismissed.',
            ),
            array(
                'question' => 'What compensation is available to victims of golf cart DUI accidents?',
                'answer'   => 'You may recover medical expenses, lost wages, pain and suffering, emotional distress, property damage, and punitive damages. In fatal cases, surviving family members may file wrongful death claims for additional compensation.',
            ),
        ),
    ),

    /* ============================================================
       6. Golf Cart Pedestrian Accident
       ============================================================ */
    array(
        'title'   => 'Golf Cart Pedestrian Accident Lawyers',
        'slug'    => 'golf-cart-pedestrian-accident',
        'excerpt' => 'Struck by a golf cart while walking in Georgia or South Carolina? Our attorneys represent pedestrians injured by negligent golf cart operators on roads, sidewalks, golf courses, and in communities.',
        'content' => <<<'HTML'
<h2>Golf Cart Pedestrian Accident Claims</h2>
<p>As golf carts become an increasingly common mode of transportation in residential communities, resort areas, and downtown districts across Georgia and South Carolina, collisions between golf carts and pedestrians have become a growing safety concern. Although golf carts travel at lower speeds than motor vehicles, they are still heavy enough — typically 500 to 1,000 pounds — to cause serious injuries when they strike a pedestrian, particularly elderly individuals, children, and people with mobility impairments. The <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">CPSC</a> data shows that pedestrian strikes by golf carts frequently result in broken bones, head injuries, and soft tissue damage requiring hospitalization.</p>
<p>At Roden Law, our <a href="/pedestrian-accident-lawyers/">pedestrian accident attorneys</a> represent individuals struck by golf carts throughout Georgia and South Carolina. We pursue full compensation from negligent golf cart operators, property owners, and — where applicable — golf cart manufacturers whose design decisions contribute to pedestrian injuries.</p>

<h2>Where Golf Cart Pedestrian Accidents Happen</h2>
<p>Golf cart pedestrian accidents occur in a variety of settings:</p>
<ul>
<li><strong>Residential communities:</strong> Golf cart communities where carts and pedestrians share sidewalks, roads, and multi-use paths</li>
<li><strong>Golf courses:</strong> Golfers struck by carts on cart paths, around tee boxes, and near clubhouses (see <a href="/golf-cart-accident-lawyers/golf-course-cart-accident/">golf course cart accidents</a>)</li>
<li><strong>Resort and hotel properties:</strong> Guests walking through resort grounds where golf carts operate as shuttles or personal transportation</li>
<li><strong>Shopping and retail areas:</strong> Pedestrians in parking lots and commercial areas where golf carts are permitted</li>
<li><strong>Event venues:</strong> Festivals, fairs, and outdoor events where golf carts are used for staff and VIP transportation</li>
<li><strong>Crosswalks and road crossings:</strong> Pedestrians struck while crossing roads in golf cart communities</li>
</ul>

<h2>Golf Cart Operator Duty of Care to Pedestrians</h2>
<p>Golf cart operators owe pedestrians a duty of reasonable care under both Georgia and South Carolina negligence law. Georgia's golf cart statute (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/" target="_blank" rel="noopener">O.C.G.A. § 40-6-330</a>) subjects golf cart operators to the same traffic laws that govern motor vehicle drivers, including the duty to yield to pedestrians in crosswalks and exercise caution in areas where pedestrians are present. South Carolina's local ordinances similarly require golf cart operators to yield to pedestrians and operate at safe speeds.</p>
<p>An operator who strikes a pedestrian because they were distracted, speeding, impaired, or failed to yield is negligent and can be held civilly liable for the resulting injuries. When the operator was under the influence of alcohol, additional punitive damages may be available (see <a href="/golf-cart-accident-lawyers/golf-cart-dui/">golf cart DUI accidents</a>).</p>

<h2>Property Owner and Business Liability</h2>
<p>Property owners, golf courses, resorts, and community associations may bear liability for pedestrian injuries caused by golf carts when they fail to implement adequate safety measures. Under Georgia premises liability law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>) and South Carolina common law, property owners must exercise ordinary care to prevent foreseeable injuries to people on their premises. This includes establishing and enforcing speed limits for golf carts, designing pedestrian-safe pathways and crossings, maintaining adequate visibility at intersections and blind corners, posting warnings in high-pedestrian-traffic areas, and training employees who operate carts as part of their job duties.</p>

<h2>Common Pedestrian Injuries From Golf Cart Strikes</h2>
<p>Even at relatively low speeds, golf carts can inflict serious injuries on pedestrians:</p>
<ul>
<li><strong>Traumatic brain injuries:</strong> From being struck and falling, hitting the head on pavement or hard surfaces</li>
<li><strong>Hip fractures:</strong> Particularly devastating for elderly pedestrians, often requiring surgery and extended rehabilitation</li>
<li><strong>Knee and leg injuries:</strong> The cart's bumper height aligns with pedestrian lower extremities, causing leg fractures and knee ligament damage</li>
<li><strong>Spinal injuries:</strong> From the impact force and fall</li>
<li><strong>Lacerations and contusions:</strong> From contact with the cart's body and mechanical components</li>
</ul>

<h2>Damages and Filing Deadlines</h2>
<p>Pedestrians struck by golf carts may recover compensation for all medical expenses, lost wages, pain and suffering, permanent disability, and diminished quality of life. Georgia's statute of limitations is 2 years (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>), while South Carolina allows 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). For general pedestrian accident information, visit our <a href="/pedestrian-accident-lawyers/">pedestrian accident lawyers</a> page.</p>

<h2>Why Choose Roden Law for Golf Cart Pedestrian Claims</h2>
<p>Our attorneys serve the Georgia and South Carolina coastal and resort communities where golf carts are ubiquitous — and where pedestrian conflicts are most common. We understand local golf cart ordinances, community liability structures, and the insurance coverage issues unique to these cases. We handle all golf cart pedestrian accident claims on a contingency fee basis with no upfront costs.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue if a golf cart hit me while I was walking?',
                'answer'   => 'Yes. Golf cart operators owe pedestrians a duty of care under Georgia (O.C.G.A. § 40-6-330) and South Carolina law. An operator who strikes a pedestrian due to inattention, speeding, or failure to yield is liable for resulting injuries.',
            ),
            array(
                'question' => 'Is the golf course or community liable if a cart hits a pedestrian on their property?',
                'answer'   => 'Potentially yes. Property owners have a duty to maintain safe conditions for pedestrians under premises liability law (O.C.G.A. § 51-3-1 in Georgia). Failure to enforce speed limits, design safe crossings, or warn of cart traffic can make the property owner liable.',
            ),
            array(
                'question' => 'What should I do if I am hit by a golf cart?',
                'answer'   => 'Call 911, seek medical attention immediately even if injuries seem minor, photograph the scene and the golf cart, get the operator\'s name and contact information, identify witnesses, and contact a golf cart accident attorney before speaking with any insurance company.',
            ),
            array(
                'question' => 'Are golf cart pedestrian accidents covered by insurance?',
                'answer'   => 'Coverage depends on the circumstances. The cart operator\'s homeowner\'s insurance, the property owner\'s commercial liability insurance, or the golf cart\'s specific insurance policy may provide coverage. An attorney can identify all available insurance sources.',
            ),
            array(
                'question' => 'How long do I have to file a claim after being hit by a golf cart?',
                'answer'   => 'Georgia allows 2 years from the date of injury (O.C.G.A. § 9-3-33), and South Carolina allows 3 years (S.C. Code § 15-3-530). Contact an attorney promptly to preserve evidence and protect your right to compensation.',
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
