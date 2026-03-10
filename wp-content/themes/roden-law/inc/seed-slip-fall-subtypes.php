<?php
/**
 * Seeder: 8 Slip and Fall Sub-Type Pages
 *
 * Creates 8 child posts under the slip-and-fall-lawyers pillar, each covering
 * a specific type of slip, trip, or fall accident scenario.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-slip-fall-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: slip-and-fall-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'slip-and-fall-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'slip-and-fall-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "slip-and-fall-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'slip-and-fall', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Slip & Fall', 'practice_category', array( 'slug' => 'slip-and-fall' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Grocery Store Slip and Fall
       ============================================================ */
    array(
        'title'   => 'Grocery Store Slip and Fall Lawyers',
        'slug'    => 'grocery-store-slip-and-fall',
        'excerpt' => 'Injured in a grocery store slip and fall in Georgia or South Carolina? Our attorneys hold negligent stores accountable for hazardous conditions and fight for full compensation.',
        'content' => <<<'HTML'
<h2>Grocery Store Slip and Fall Accidents in Georgia &amp; South Carolina</h2>
<p>Grocery stores are among the most common locations for slip and fall injuries in the United States. Spilled liquids, dropped produce, leaking refrigeration units, freshly mopped floors, and improperly maintained entryways create constant hazards for shoppers. According to the <a href="https://www.nsc.org/work-safety/safety-topics/slips-trips-and-falls" target="_blank" rel="noopener">National Safety Council (NSC)</a>, falls are the third leading cause of preventable injury-related deaths in the United States. At Roden Law, our grocery store slip and fall lawyers represent victims across Georgia and South Carolina who are injured because a store failed to maintain safe conditions.</p>
<p>Grocery stores owe a high duty of care to their customers. Under Georgia premises liability law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/article-1/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>), property owners and occupiers must exercise ordinary care to keep their premises safe for invited guests. South Carolina imposes a similar duty under common law, requiring property owners to warn of or remedy dangerous conditions they know about or should have discovered through reasonable inspection.</p>

<h2>Proving a Grocery Store Slip and Fall Claim</h2>
<p>To succeed in a grocery store slip and fall case, you must demonstrate that the store knew or should have known about the hazardous condition and failed to take reasonable steps to address it. Key evidence includes:</p>
<ul>
<li>Surveillance camera footage showing how long the hazard existed before your fall</li>
<li>Incident reports filed by store employees at the time of the accident</li>
<li>Maintenance and inspection logs showing cleaning schedules and compliance</li>
<li>Witness statements from other shoppers or employees who saw the hazard</li>
<li>Photographs of the hazard, your injuries, and your footwear at the time of the fall</li>
<li>Medical records linking your injuries to the fall</li>
</ul>
<p>The "time-on-the-floor" element is critical. Courts in both Georgia and South Carolina evaluate whether the hazard existed long enough that a reasonably attentive store should have discovered and corrected it. Under Georgia law, the injured party must show the store had actual or constructive knowledge of the hazard (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/article-1/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>).</p>

<h2>Common Grocery Store Hazards</h2>
<p>Grocery stores present a wide variety of slip, trip, and fall hazards, including:</p>
<ul>
<li>Spilled liquids from broken containers, leaking packages, or condensation</li>
<li>Dropped produce, grapes, lettuce leaves, and other food items on the floor</li>
<li>Freshly mopped floors without adequate warning signs or barriers</li>
<li>Wet or icy entryways and parking lot transitions during inclement weather</li>
<li>Uneven flooring, torn mats, or curled carpet edges</li>
<li>Cluttered aisles with stock carts, boxes, and product displays blocking walkways</li>
</ul>
<p>If you were injured in a <a href="/slip-and-fall-lawyers/wet-floor-accident/">wet floor accident</a> or tripped over merchandise in a <a href="/slip-and-fall-lawyers/retail-store-trip-and-fall/">retail store</a>, you may have a valid premises liability claim. Our lawyers also handle <a href="/premises-liability-lawyers/">premises liability cases</a> involving a broad range of dangerous property conditions.</p>

<h2>Damages in Grocery Store Fall Cases</h2>
<p>Victims of grocery store slip and fall accidents may recover compensation for medical expenses including emergency treatment, surgery, and rehabilitation; lost wages and diminished earning capacity during recovery; pain and suffering and emotional distress; and ongoing care needs for permanent injuries such as hip fractures, traumatic brain injuries, or spinal cord damage. Older adults face particularly severe consequences from falls — the <a href="https://www.cdc.gov/falls/" target="_blank" rel="noopener">Centers for Disease Control and Prevention (CDC)</a> reports that falls are the leading cause of injury death among adults 65 and older.</p>

<h2>Why Choose Roden Law for Your Grocery Store Fall Case</h2>
<p>Our attorneys act quickly to preserve surveillance footage and incident reports before stores can destroy or overwrite this critical evidence. We work with safety experts to demonstrate how the store violated its duty of care and pursue maximum compensation through insurance claims or litigation. There is no fee unless we win your case.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'How do I prove the grocery store was negligent?',
                'answer'   => 'You must show the store knew or should have known about the hazardous condition and failed to correct it or warn customers. Evidence such as surveillance footage, inspection logs, and witness statements can help establish that the hazard existed long enough for the store to have discovered it.',
            ),
            array(
                'question' => 'What if I did not report the fall to the store manager?',
                'answer'   => 'While reporting the fall creates important documentation, you can still file a claim. Medical records, witness testimony, and surveillance footage can help prove your case even without an incident report.',
            ),
            array(
                'question' => 'How long do I have to file a grocery store slip and fall claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years from the date of injury (O.C.G.A. § 9-3-33). In South Carolina, you have 3 years (S.C. Code § 15-3-530). Acting quickly is important to preserve surveillance footage, which stores may overwrite within days or weeks.',
            ),
            array(
                'question' => 'Can I recover damages if I was partially at fault for the fall?',
                'answer'   => 'Yes. Georgia allows recovery if you are less than 50% at fault (O.C.G.A. § 51-12-33). South Carolina permits recovery if you are less than 51% at fault. Your compensation is reduced by your percentage of fault.',
            ),
            array(
                'question' => 'What compensation is available for a grocery store fall injury?',
                'answer'   => 'You may recover medical expenses, lost wages, pain and suffering, emotional distress, and ongoing care costs. In cases involving particularly egregious negligence, punitive damages may also be available.',
            ),
        ),
    ),

    /* ============================================================
       2. Restaurant Slip and Fall
       ============================================================ */
    array(
        'title'   => 'Restaurant Slip and Fall Lawyers',
        'slug'    => 'restaurant-slip-and-fall',
        'excerpt' => 'Suffered a slip and fall injury at a restaurant in Georgia or South Carolina? Our lawyers hold restaurant owners accountable for unsafe floor conditions, spills, and maintenance failures.',
        'content' => <<<'HTML'
<h2>Restaurant Slip and Fall Accidents in Georgia &amp; South Carolina</h2>
<p>Restaurants present unique slip and fall hazards due to the constant presence of food, beverages, grease, and high foot traffic. From spilled drinks and dropped food to greasy kitchen floors and uneven outdoor patios, restaurant environments create conditions that can cause serious injuries to diners, employees, and delivery personnel. According to the <a href="https://www.bls.gov/iif/" target="_blank" rel="noopener">Bureau of Labor Statistics (BLS)</a>, the restaurant and food service industry consistently ranks among the highest for workplace slip, trip, and fall injuries.</p>
<p>At Roden Law, our restaurant slip and fall lawyers understand the premises liability laws that govern these cases in Georgia and South Carolina. Under <a href="https://law.justia.com/codes/georgia/title-51/chapter-3/article-1/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>, restaurant owners must exercise ordinary care to keep their premises safe for patrons — this includes regular floor inspections, prompt spill cleanup, and adequate warning signage. South Carolina holds restaurant operators to the same standard of reasonable care under its common law premises liability framework.</p>

<h2>Common Restaurant Slip and Fall Hazards</h2>
<p>Restaurant slip and fall accidents commonly result from:</p>
<ul>
<li>Spilled food and beverages on dining room floors</li>
<li>Grease accumulation near kitchen areas and service stations</li>
<li>Wet floors from mopping without proper warning signs</li>
<li>Condensation near beverage stations, ice machines, and refrigerated display cases</li>
<li>Uneven flooring transitions between dining areas, bars, and outdoor patios</li>
<li>Loose or torn carpet, rugs, and floor mats at entrances</li>
<li>Inadequate lighting in hallways, restrooms, and parking areas</li>
<li>Cracked or uneven sidewalks and steps leading to the entrance</li>
</ul>
<p>Many of these hazards also arise in <a href="/slip-and-fall-lawyers/grocery-store-slip-and-fall/">grocery stores</a> and <a href="/slip-and-fall-lawyers/retail-store-trip-and-fall/">retail stores</a>. If your fall was caused specifically by a <a href="/slip-and-fall-lawyers/wet-floor-accident/">wet floor</a>, our attorneys have extensive experience with that type of claim as well.</p>

<h2>Restaurant Owner Duties Under Georgia &amp; South Carolina Law</h2>
<p>Both Georgia and South Carolina classify restaurant patrons as "invitees" — individuals who enter property for the mutual benefit of themselves and the property owner. Invitees receive the highest duty of care under premises liability law. Restaurant owners must conduct regular inspections to identify and correct hazards, promptly clean up spills and food debris, place warning signs when floors are wet or being cleaned, maintain adequate lighting in all areas accessible to patrons, and repair damaged flooring, steps, and walkways.</p>
<p>Failure to meet these duties establishes the negligence element of a premises liability claim. Georgia courts apply the "equal knowledge" rule — if you had the same knowledge of the hazard as the property owner, your claim may be weakened. Our attorneys work to demonstrate that the restaurant knew or should have known about the dangerous condition before your injury occurred.</p>

<h2>Injuries from Restaurant Falls</h2>
<p>Restaurant slip and fall injuries range from minor bruises to life-altering conditions including broken hips and wrists, traumatic brain injuries from striking the head on hard surfaces, spinal cord injuries, torn ligaments and rotator cuff tears, and deep lacerations from broken glass or sharp fixtures. Elderly patrons face the greatest risk of severe injury, as falls account for a significant percentage of emergency department visits among older adults.</p>

<h2>Recovering Damages After a Restaurant Fall</h2>
<p>Our attorneys pursue full compensation for restaurant fall victims, including all medical expenses, lost income, pain and suffering, and long-term care costs. We act quickly to secure surveillance footage and incident reports before this critical evidence is lost. Contact Roden Law for a free consultation — there is no fee unless we recover compensation for you.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What must I prove in a restaurant slip and fall case?',
                'answer'   => 'You must demonstrate that the restaurant owner knew or should have known about the hazardous condition and failed to correct it or warn you. Evidence such as surveillance footage, inspection records, and employee testimony can establish the restaurant\'s negligence.',
            ),
            array(
                'question' => 'Can I sue a restaurant if I slipped on a spill from another customer?',
                'answer'   => 'Yes. While the restaurant did not create the spill, it has a duty to inspect the premises regularly and clean up hazards within a reasonable time. If the spill existed long enough that the restaurant should have discovered and addressed it, the restaurant may be liable.',
            ),
            array(
                'question' => 'What if the restaurant placed a wet floor sign but I still fell?',
                'answer'   => 'A wet floor sign alone may not be sufficient. The restaurant must take reasonable steps to prevent the hazard, not merely warn about it. Additionally, if the sign was poorly placed or not visible, the restaurant may still bear liability.',
            ),
            array(
                'question' => 'How long does a restaurant have to fix a known hazard?',
                'answer'   => 'There is no specific time limit, but courts evaluate what is "reasonable" under the circumstances. A spill in a busy dining area should be cleaned up within minutes, while a less trafficked area may allow slightly more time. The key question is whether the restaurant exercised ordinary care.',
            ),
            array(
                'question' => 'What is the statute of limitations for a restaurant fall claim?',
                'answer'   => 'In Georgia, you have 2 years from the date of injury to file a lawsuit (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530). Evidence such as surveillance footage may be overwritten quickly, so prompt action is critical.',
            ),
        ),
    ),

    /* ============================================================
       3. Wet Floor Accident
       ============================================================ */
    array(
        'title'   => 'Wet Floor Accident Lawyers',
        'slug'    => 'wet-floor-accident',
        'excerpt' => 'Injured in a wet floor accident at a store, restaurant, or commercial property? Our Georgia and South Carolina attorneys pursue full compensation for slip and fall injuries caused by wet or slippery surfaces.',
        'content' => <<<'HTML'
<h2>Wet Floor Accidents in Georgia &amp; South Carolina</h2>
<p>Wet floor accidents are among the most frequent causes of slip and fall injuries in commercial properties, workplaces, and public buildings. Whether caused by a spill that went unattended, a freshly mopped floor without adequate warning signs, a leaking roof, or rainwater tracked into an entryway, a wet floor creates a serious hazard for anyone walking through the area. The <a href="https://www.nsc.org/work-safety/safety-topics/slips-trips-and-falls" target="_blank" rel="noopener">National Safety Council (NSC)</a> identifies slips and falls as one of the leading causes of unintentional injuries, with wet or slippery surfaces playing a major role.</p>
<p>At Roden Law, our wet floor accident lawyers represent victims across Georgia and South Carolina who suffer injuries because property owners or businesses failed to keep their floors safe and dry. Under Georgia premises liability law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/article-1/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>), property owners must exercise ordinary care to protect visitors from foreseeable hazards — including wet floors. South Carolina applies the same reasonable care standard under its common law framework.</p>

<h2>Common Causes of Wet Floor Accidents</h2>
<p>Wet floor hazards arise in many settings and from a wide range of causes:</p>
<ul>
<li>Freshly mopped or waxed floors without visible warning signs or barriers</li>
<li>Spills from beverages, food, cleaning products, or leaking merchandise</li>
<li>Rainwater, snow, or ice tracked into building entryways without floor mats or drainage</li>
<li>Leaking pipes, HVAC condensation, or roof leaks creating puddles</li>
<li>Restroom overflow or plumbing failures</li>
<li>Produce misting and refrigeration condensation in grocery stores</li>
<li>Pool decks, spas, and water parks without slip-resistant surfaces</li>
</ul>
<p>These hazards commonly occur in <a href="/slip-and-fall-lawyers/grocery-store-slip-and-fall/">grocery stores</a>, <a href="/slip-and-fall-lawyers/restaurant-slip-and-fall/">restaurants</a>, <a href="/slip-and-fall-lawyers/hotel-resort-injury/">hotels and resorts</a>, <a href="/slip-and-fall-lawyers/retail-store-trip-and-fall/">retail stores</a>, and workplaces. Property owners in all of these settings have a duty to prevent wet floor injuries or adequately warn visitors of the danger.</p>

<h2>Warning Signs and Legal Duties</h2>
<p>Many property owners believe that simply placing a "wet floor" sign eliminates their liability. This is not necessarily the case. While warning signs are an important step, Georgia and South Carolina law require property owners to take reasonable steps to <em>prevent</em> the hazard — not merely warn about it. If a floor has been mopped, the property owner should block access to the area until it is dry. If a chronic leak creates recurring puddles, the owner must repair the underlying problem rather than relying on perpetual warning signs.</p>
<p>Additionally, a wet floor sign must be conspicuously placed where it is actually visible to approaching pedestrians. A sign placed behind the hazard or in a location where it cannot be seen does not satisfy the property owner's duty of care.</p>

<h2>Injuries from Wet Floor Falls</h2>
<p>Wet floor falls can cause severe injuries, particularly for elderly individuals. Common injuries include hip fractures, broken wrists and arms, traumatic brain injuries from striking the head on hard surfaces, herniated discs and spinal injuries, and torn ligaments and tendons. Falls on wet surfaces often occur suddenly and without warning, leaving victims unable to brace themselves and increasing the severity of impact injuries. The <a href="https://www.cdc.gov/falls/" target="_blank" rel="noopener">CDC</a> reports that one out of five falls causes a serious injury such as broken bones or a head injury.</p>

<h2>Comparative Fault in Wet Floor Cases</h2>
<p>Property owners frequently argue that the injured person was partially at fault — for example, by not watching where they were walking, wearing inappropriate footwear, or ignoring a warning sign. Under Georgia's modified comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>), you can recover damages as long as you are less than 50% at fault. South Carolina allows recovery if you are less than 51% at fault. Our attorneys work to minimize any allegations of shared fault and maximize your compensation.</p>

<h2>Contact Roden Law After a Wet Floor Accident</h2>
<p>If you were injured in a wet floor accident, it is essential to act quickly. Surveillance footage may be overwritten, witnesses may become unavailable, and the property owner may repair the hazard to hide evidence. Our attorneys investigate wet floor accidents thoroughly and pursue every avenue of recovery. Contact us for a free consultation — there is no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Is a wet floor sign enough to protect a business from liability?',
                'answer'   => 'Not always. While warning signs are important, property owners must also take reasonable steps to prevent the hazard — such as blocking access to wet areas, using slip-resistant mats, and promptly drying floors. A sign alone does not eliminate liability if the owner could have done more to prevent the fall.',
            ),
            array(
                'question' => 'What should I do immediately after a wet floor fall?',
                'answer'   => 'Report the incident to the property manager, take photos of the wet surface and your injuries, collect contact information from witnesses, seek medical attention even if injuries seem minor, and contact a slip and fall attorney before giving statements to insurance companies.',
            ),
            array(
                'question' => 'Can I file a claim if I fell in a wet restroom?',
                'answer'   => 'Yes. Property owners are responsible for maintaining all areas accessible to visitors, including restrooms. If the wet condition resulted from a maintenance failure, plumbing leak, or inadequate cleaning protocol, the property owner may be liable.',
            ),
            array(
                'question' => 'How long does a business have to clean up a spill?',
                'answer'   => 'Courts evaluate what is reasonable under the circumstances. In high-traffic areas like grocery stores and restaurants, spills should be addressed within minutes. The longer a hazard exists, the stronger the argument that the business should have discovered and corrected it.',
            ),
            array(
                'question' => 'What if I was wearing high heels or flip-flops when I fell?',
                'answer'   => 'The defense may argue contributory fault based on your footwear, but this does not automatically bar your claim. Georgia and South Carolina both use comparative fault rules, meaning your compensation may be reduced but not eliminated if you were partially responsible.',
            ),
        ),
    ),

    /* ============================================================
       4. Parking Lot Fall
       ============================================================ */
    array(
        'title'   => 'Parking Lot Fall Lawyers',
        'slug'    => 'parking-lot-fall',
        'excerpt' => 'Injured in a parking lot fall in Georgia or South Carolina? Our attorneys hold property owners accountable for potholes, uneven surfaces, poor lighting, and other hazardous conditions.',
        'content' => <<<'HTML'
<h2>Parking Lot Fall Accidents in Georgia &amp; South Carolina</h2>
<p>Parking lots may seem like safe environments, but they are a frequent site of slip, trip, and fall injuries. Crumbling asphalt, potholes, uneven surfaces, poorly marked curbs, inadequate lighting, ice, and oil slicks all create conditions that can cause pedestrians to fall and suffer serious injuries. The <a href="https://www.nsc.org/community-safety/safety-topics/parking-lot-safety" target="_blank" rel="noopener">National Safety Council</a> highlights parking lot safety as a significant concern, with thousands of injuries occurring annually in parking facilities across the country.</p>
<p>At Roden Law, our parking lot fall lawyers represent victims across Georgia and South Carolina who are injured due to poorly maintained parking areas. Under <a href="https://law.justia.com/codes/georgia/title-51/chapter-3/article-1/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>, property owners have a duty to exercise ordinary care in maintaining their premises, including parking lots, for the safety of invited visitors. South Carolina applies the same reasonable care standard.</p>

<h2>Common Parking Lot Hazards</h2>
<p>Parking lot fall injuries are caused by a range of hazardous conditions, including:</p>
<ul>
<li>Potholes and cracked or crumbling asphalt</li>
<li>Uneven pavement, raised expansion joints, and broken concrete</li>
<li>Poorly marked or hidden curbs, speed bumps, and wheel stops</li>
<li>Inadequate drainage causing standing water and ice accumulation</li>
<li>Oil, grease, and antifreeze spills from vehicles</li>
<li>Insufficient lighting making it difficult to see hazards at night</li>
<li>Overgrown vegetation, debris, and tree roots disrupting walkways</li>
<li>Missing or damaged handrails on parking garage ramps and stairways</li>
</ul>
<p>If your parking lot fall involved a <a href="/slip-and-fall-lawyers/stairway-escalator-fall/">stairway hazard</a> in a parking garage, or a <a href="/slip-and-fall-lawyers/wet-floor-accident/">wet surface</a> near the entrance of a business, our attorneys handle those types of claims as well. Parking lot falls may also give rise to broader <a href="/premises-liability-lawyers/">premises liability claims</a> depending on the circumstances.</p>

<h2>Who Is Liable for a Parking Lot Fall?</h2>
<p>Liability for parking lot fall injuries depends on who owns and maintains the parking area. Potentially liable parties include:</p>
<ul>
<li>Property owners who fail to repair known hazards or conduct regular maintenance</li>
<li>Commercial tenants (stores, restaurants) responsible for the parking area under their lease</li>
<li>Property management companies contracted to maintain the lot</li>
<li>Paving and construction companies that performed substandard work</li>
<li>Municipal entities responsible for public parking lots and garages</li>
</ul>
<p>In many cases, the lease agreement between the property owner and commercial tenant allocates responsibility for parking lot maintenance. Our attorneys investigate these agreements to identify every liable party.</p>

<h2>Proving Negligence in a Parking Lot Fall</h2>
<p>To succeed in a parking lot fall case, you must demonstrate that the responsible party knew or should have known about the hazardous condition and failed to repair it or warn visitors. Evidence of constructive knowledge is often established by showing the hazard existed for a sufficient period — for example, a pothole that developed over weeks or months, or a lighting fixture that had been burned out for an extended time. Georgia's constructive knowledge standard requires proof that reasonable inspection would have revealed the hazard.</p>

<h2>Damages and Compensation</h2>
<p>Victims of parking lot falls may recover compensation for all medical expenses, lost wages and earning capacity, pain and suffering, and ongoing rehabilitation needs. Falls on hard asphalt and concrete surfaces often cause particularly severe injuries including hip fractures, wrist fractures, knee injuries, and traumatic brain injuries. Under Georgia law (O.C.G.A. § 51-12-33), your damages are reduced by your percentage of fault but you can still recover if you are less than 50% responsible. South Carolina's threshold is 51%.</p>

<h2>Contact Roden Law After a Parking Lot Fall</h2>
<p>If you were injured in a parking lot fall, photograph the hazard, report the incident to the property owner or business manager, and seek medical attention immediately. Then contact Roden Law for a free consultation. We investigate quickly to preserve evidence before hazards are repaired and surveillance footage is overwritten.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who is responsible for maintaining a parking lot?',
                'answer'   => 'Responsibility depends on the property ownership and lease arrangements. The property owner, commercial tenants, or a property management company may be liable. Our attorneys investigate lease agreements and maintenance contracts to identify all responsible parties.',
            ),
            array(
                'question' => 'Can I sue if I tripped over a pothole in a parking lot?',
                'answer'   => 'Yes, if the pothole existed long enough that the property owner should have discovered and repaired it. Evidence such as prior complaints, maintenance records, and the size and visibility of the pothole can establish negligence.',
            ),
            array(
                'question' => 'What if the parking lot fall happened at night due to poor lighting?',
                'answer'   => 'Property owners have a duty to provide adequate lighting in parking areas. If insufficient lighting prevented you from seeing a hazard, the property owner may be liable for failing to maintain safe conditions.',
            ),
            array(
                'question' => 'How long do I have to file a parking lot fall claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years (O.C.G.A. § 9-3-33). In South Carolina, you have 3 years (S.C. Code § 15-3-530). If the parking lot is owned by a government entity, shorter notice deadlines may apply.',
            ),
            array(
                'question' => 'Does comparative fault apply to parking lot fall cases?',
                'answer'   => 'Yes. The property owner may argue you were partially at fault for not watching where you walked. Georgia allows recovery if you are less than 50% at fault (O.C.G.A. § 51-12-33), and South Carolina allows recovery if you are less than 51% at fault.',
            ),
        ),
    ),

    /* ============================================================
       5. Stairway and Escalator Fall
       ============================================================ */
    array(
        'title'   => 'Stairway and Escalator Fall Lawyers',
        'slug'    => 'stairway-escalator-fall',
        'excerpt' => 'Injured in a stairway or escalator fall in Georgia or South Carolina? Our attorneys pursue claims against property owners and equipment manufacturers for unsafe conditions and mechanical failures.',
        'content' => <<<'HTML'
<h2>Stairway and Escalator Fall Accidents in Georgia &amp; South Carolina</h2>
<p>Stairways and escalators are essential features of commercial buildings, shopping centers, parking garages, and apartment complexes — but when they are poorly maintained, they become dangerous. The <a href="https://www.cpsc.gov/Research--Statistics/NEISS-Injury-Data" target="_blank" rel="noopener">U.S. Consumer Product Safety Commission (CPSC)</a> estimates that escalator-related injuries result in approximately 10,000 emergency room visits annually, while stairway falls are responsible for over one million injuries each year in the United States.</p>
<p>At Roden Law, our stairway and escalator fall lawyers handle cases throughout Georgia and South Carolina involving injuries caused by defective, poorly maintained, or improperly designed stairs and escalators. These cases may involve <a href="/premises-liability-lawyers/">premises liability</a> claims against property owners as well as <a href="/product-liability-lawyers/">product liability</a> claims against escalator manufacturers.</p>

<h2>Common Causes of Stairway Falls</h2>
<p>Stairway falls are often caused by hazardous conditions that a property owner should have identified and corrected:</p>
<ul>
<li>Missing, loose, or broken handrails</li>
<li>Uneven step heights or inconsistent tread depths</li>
<li>Worn, torn, or missing stair treads and non-slip strips</li>
<li>Inadequate lighting in stairwells</li>
<li>Wet, icy, or debris-covered stairs</li>
<li>Building code violations in stair construction or renovation</li>
<li>Missing or damaged stair nosing (the edge of each step)</li>
</ul>
<p>Georgia and South Carolina building codes establish minimum safety standards for stairways, including handrail height, tread width, riser height, and lighting requirements. Violations of these codes can serve as strong evidence of negligence in a premises liability claim.</p>

<h2>Escalator Accident Causes and Liability</h2>
<p>Escalator accidents present unique liability questions because they may involve both the property owner who maintains the escalator and the manufacturer who designed and built it:</p>
<ul>
<li>Sudden stops or speed changes that throw passengers off balance</li>
<li>Entrapment of clothing, shoes, fingers, or toes in escalator mechanisms</li>
<li>Missing or broken comb plates at escalator landings</li>
<li>Gaps between steps that catch heels or small objects</li>
<li>Failure to conduct required maintenance and safety inspections</li>
</ul>
<p>Under Georgia premises liability law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/article-1/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>), the property owner is responsible for maintaining escalators in safe operating condition. If a design or manufacturing defect caused the accident, a <a href="/product-liability-lawyers/">product liability claim</a> against the manufacturer may also be available. South Carolina similarly holds both property owners and manufacturers accountable under their respective duties.</p>

<h2>Proving a Stairway or Escalator Claim</h2>
<p>Successful stairway and escalator fall claims typically require evidence of the hazardous condition, the property owner's knowledge of the condition, and the causal connection between the hazard and your injuries. Key evidence includes building inspection reports, maintenance and repair records, surveillance camera footage, building code compliance documentation, expert testimony from safety engineers, and photographs of the defective condition.</p>

<h2>Damages in Stairway and Escalator Fall Cases</h2>
<p>Falls on stairs and escalators frequently result in severe injuries due to the height and hard surfaces involved. Victims may recover compensation for all medical treatment, surgical procedures, lost income, pain and suffering, and diminished quality of life. In cases involving egregious maintenance failures or known hazards left unrepaired, punitive damages may also be available under Georgia law (O.C.G.A. § 51-12-5.1). Contact Roden Law for a free case evaluation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who is liable for a stairway fall in an apartment building?',
                'answer'   => 'The property owner or landlord is generally responsible for maintaining common area stairways in safe condition. If a property management company handles maintenance, they may also bear liability.',
            ),
            array(
                'question' => 'Can I sue an escalator manufacturer for an escalator injury?',
                'answer'   => 'Yes. If a design or manufacturing defect caused the escalator malfunction that led to your injury, you may have a product liability claim against the manufacturer in addition to a premises liability claim against the property owner.',
            ),
            array(
                'question' => 'What building codes apply to stairway safety in Georgia?',
                'answer'   => 'Georgia adopts the International Building Code (IBC), which sets standards for stair dimensions, handrail requirements, lighting, and non-slip surfaces. Violations of these codes can serve as evidence of negligence in a fall case.',
            ),
            array(
                'question' => 'Are escalator injuries covered under premises liability?',
                'answer'   => 'Yes. Under Georgia law (O.C.G.A. § 51-3-1), property owners must exercise ordinary care in maintaining all property features, including escalators. Failure to maintain, inspect, or repair an escalator that injures a visitor can give rise to a premises liability claim.',
            ),
            array(
                'question' => 'What is the statute of limitations for a stairway or escalator fall?',
                'answer'   => 'In Georgia, you have 2 years to file a personal injury lawsuit (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530). Product liability claims may have different limitation periods depending on the specific circumstances.',
            ),
        ),
    ),

    /* ============================================================
       6. Hotel / Resort Injury
       ============================================================ */
    array(
        'title'   => 'Hotel / Resort Injury Lawyers',
        'slug'    => 'hotel-resort-injury',
        'excerpt' => 'Injured at a hotel or resort in Georgia or South Carolina? Our attorneys hold hospitality businesses accountable for slip and fall injuries, pool accidents, and unsafe property conditions.',
        'content' => <<<'HTML'
<h2>Hotel and Resort Injury Claims in Georgia &amp; South Carolina</h2>
<p>Georgia and South Carolina are popular tourist and business travel destinations, with coastal resorts, historic hotels, and convention venues drawing millions of visitors each year. When hotels and resorts fail to maintain safe conditions, guests can suffer serious slip and fall injuries, pool accidents, elevator and escalator injuries, and other harm. The <a href="https://www.bls.gov/iif/soii-data.htm" target="_blank" rel="noopener">Bureau of Labor Statistics</a> consistently identifies the accommodations industry as having elevated rates of slip, trip, and fall incidents.</p>
<p>At Roden Law, our hotel and resort injury lawyers represent guests, visitors, and employees who are hurt because a hospitality business failed to uphold its duty of care. Under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/article-1/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>), hotel operators owe a duty of ordinary care to their guests — a standard that requires regular inspections, prompt hazard correction, and adequate warnings of known dangers. South Carolina applies a similar standard under its common law premises liability framework.</p>

<h2>Common Hotel and Resort Hazards</h2>
<p>Hotels and resorts present a wide variety of hazards across guest rooms, common areas, pools, restaurants, and parking facilities:</p>
<ul>
<li>Wet lobby floors, pool decks, and bathroom surfaces without non-slip treatments</li>
<li>Poorly maintained stairways, handrails, and elevators</li>
<li>Swimming pool and hot tub hazards including slippery decks, inadequate fencing, and broken drains</li>
<li>Balcony and railing defects that create fall risks from height</li>
<li>Inadequate lighting in hallways, parking garages, and exterior walkways</li>
<li>Loose or damaged carpeting, torn rugs, and uneven flooring</li>
<li>Negligent security leading to assaults in poorly lit or unsecured areas</li>
</ul>
<p>Many of these hazards overlap with other types of premises liability claims. If your hotel injury involved a <a href="/slip-and-fall-lawyers/wet-floor-accident/">wet floor</a>, <a href="/slip-and-fall-lawyers/stairway-escalator-fall/">stairway or escalator</a>, or <a href="/slip-and-fall-lawyers/parking-lot-fall/">parking lot</a>, our attorneys can evaluate the specific circumstances of your case. For broader dangerous property conditions, visit our <a href="/premises-liability-lawyers/">premises liability</a> page.</p>

<h2>Hotel Guest Status Under Premises Liability Law</h2>
<p>Hotel guests are classified as "invitees" under both Georgia and South Carolina premises liability law, which means they receive the highest duty of care. Hotels must proactively inspect for hazards, repair dangerous conditions, and warn guests of risks that cannot be immediately corrected. This duty extends to all areas accessible to guests, including guest rooms, lobbies, restaurants, fitness centers, pool areas, and parking structures.</p>
<p>A hotel's duty of care also extends to out-of-state guests. Georgia and South Carolina courts regularly hear premises liability cases filed by travelers from other states, and the same standards of care apply regardless of the guest's home state.</p>

<h2>Swimming Pool and Water Feature Injuries</h2>
<p>Pools and water features are among the most dangerous areas at hotels and resorts. Georgia's Pool Safety Act and South Carolina's public swimming pool regulations establish requirements for fencing, signage, drain covers, lifeguard staffing, and water quality. Violations of these regulations can establish negligence per se in an injury claim. Tragically, pool accidents can result in drowning — if you have lost a loved one in a hotel drowning incident, our <a href="/wrongful-death-lawyers/">wrongful death lawyers</a> can help your family pursue justice.</p>

<h2>Recovering Damages After a Hotel Injury</h2>
<p>Hotel and resort injury victims may recover compensation for medical expenses, lost wages, pain and suffering, travel expenses related to the injury, and long-term care needs. Because hotels typically carry substantial commercial liability insurance, significant recoveries are possible when negligence is clearly established. Contact Roden Law for a free consultation — we handle cases on a contingency basis with no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What duty of care does a hotel owe its guests?',
                'answer'   => 'Hotels owe guests the highest duty of care as "invitees" under Georgia (O.C.G.A. § 51-3-1) and South Carolina premises liability law. This requires proactive inspections, prompt hazard correction, and adequate warnings of known dangers in all areas accessible to guests.',
            ),
            array(
                'question' => 'Can I file a claim if I was injured at a hotel pool?',
                'answer'   => 'Yes. Hotels must comply with state pool safety regulations regarding fencing, signage, drain covers, and maintenance. If the hotel violated these requirements or failed to maintain a safe pool area, it may be liable for your injuries.',
            ),
            array(
                'question' => 'What if I slipped in the hotel bathroom?',
                'answer'   => 'Hotels must provide non-slip surfaces and grab bars in bathrooms. If the bathroom lacked proper safety features or had a known hazard like a leaking shower, the hotel may be liable for your fall injuries.',
            ),
            array(
                'question' => 'Can I file a claim in Georgia or South Carolina if I live in another state?',
                'answer'   => 'Yes. If the injury occurred at a Georgia or South Carolina hotel, the claim is generally filed in that state. The same premises liability standards apply regardless of the guest\'s home state.',
            ),
            array(
                'question' => 'How long do I have to file a hotel injury claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years (O.C.G.A. § 9-3-33). In South Carolina, you have 3 years (S.C. Code § 15-3-530). Prompt action is important to preserve evidence such as surveillance footage and maintenance records.',
            ),
        ),
    ),

    /* ============================================================
       7. Retail Store Trip and Fall
       ============================================================ */
    array(
        'title'   => 'Retail Store Trip and Fall Lawyers',
        'slug'    => 'retail-store-trip-and-fall',
        'excerpt' => 'Tripped and fell in a retail store in Georgia or South Carolina? Our attorneys hold stores accountable for cluttered aisles, uneven flooring, and other tripping hazards that cause injuries.',
        'content' => <<<'HTML'
<h2>Retail Store Trip and Fall Accidents in Georgia &amp; South Carolina</h2>
<p>Retail stores — from big-box chains to small boutiques — have a legal duty to maintain safe conditions for their customers. Unfortunately, cluttered aisles, protruding merchandise displays, electrical cords, uneven flooring, torn carpeting, and improperly placed floor mats create tripping hazards that injure thousands of shoppers every year. According to the <a href="https://www.nsc.org/work-safety/safety-topics/slips-trips-and-falls" target="_blank" rel="noopener">National Safety Council</a>, slips, trips, and falls account for a significant percentage of retail customer injuries nationwide.</p>
<p>At Roden Law, our retail store trip and fall lawyers represent injured shoppers across Georgia and South Carolina. Under Georgia premises liability law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/article-1/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>), retail stores owe their customers — who are classified as "invitees" — the highest duty of care, including regular inspections for hazards and prompt corrective action. South Carolina applies the same standard under its common law framework.</p>

<h2>Common Retail Store Tripping Hazards</h2>
<p>Retail store trip and fall injuries are frequently caused by:</p>
<ul>
<li>Merchandise, boxes, and stock carts left in aisles during restocking</li>
<li>Floor display stands, end caps, and promotional signage that protrude into walkways</li>
<li>Electrical cords, extension cables, and charging stations crossing customer pathways</li>
<li>Torn, wrinkled, or bunched carpet and floor mats at entrances and transitions</li>
<li>Uneven flooring at thresholds between different surface materials</li>
<li>Broken or raised floor tiles and damaged concrete</li>
<li>Children's play areas and demonstration stations with trip hazards</li>
</ul>
<p>Similar hazards occur in <a href="/slip-and-fall-lawyers/grocery-store-slip-and-fall/">grocery stores</a>, and many retail environments also present <a href="/slip-and-fall-lawyers/wet-floor-accident/">wet floor hazards</a> from cleaning, leaking merchandise, or weather-related water intrusion. Our attorneys evaluate all potential hazards and liability theories in each case.</p>

<h2>Store Employee and Management Knowledge</h2>
<p>A critical element in retail store trip and fall cases is establishing that the store knew or should have known about the tripping hazard. Evidence of knowledge may include prior complaints from customers or employees about the same hazard, corporate safety audit reports identifying recurring issues, employee training materials addressing specific hazards, maintenance schedules showing gaps in floor inspections, and surveillance footage showing the hazard existing for an extended period before the fall.</p>
<p>Under Georgia law, the "constructive knowledge" standard allows you to establish the store's awareness by showing the hazard existed for a sufficient time that a reasonable inspection would have revealed it. South Carolina applies a similar analysis.</p>

<h2>Big-Box Store and Chain Retailer Claims</h2>
<p>Large retail chains like Walmart, Target, Home Depot, and Lowe's have corporate safety protocols and extensive surveillance systems. While these companies have large legal teams defending against injury claims, their own corporate safety standards can often be used against them. If a store failed to follow its own inspection and maintenance procedures, this failure supports a negligence claim.</p>

<h2>Damages and Recovery</h2>
<p>Retail store trip and fall victims may recover compensation for medical expenses, lost income, pain and suffering, and ongoing care needs. Trip and fall injuries commonly include broken bones, torn ligaments, knee and ankle injuries, and traumatic brain injuries from striking the head on shelving or hard floors. Our attorneys pursue full compensation from the store's commercial liability insurance. Contact Roden Law for a free consultation — no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What must I prove in a retail store trip and fall case?',
                'answer'   => 'You must show that a tripping hazard existed, the store knew or should have known about it, and the store failed to correct the hazard or warn customers. Evidence of the store\'s knowledge — such as prior complaints, surveillance footage, and inspection logs — is critical.',
            ),
            array(
                'question' => 'Can I sue a large retail chain like Walmart or Target?',
                'answer'   => 'Yes. Large retailers owe the same duty of care as any property owner. In fact, their own corporate safety protocols and surveillance systems can provide evidence of negligence if the store failed to follow its established procedures.',
            ),
            array(
                'question' => 'What if I tripped over merchandise left in the aisle?',
                'answer'   => 'If store employees or vendors left merchandise in a walkway where it created a tripping hazard, the store may be liable. Stores have a duty to keep aisles clear and safe for customers, especially during restocking operations.',
            ),
            array(
                'question' => 'How soon should I report a retail store fall?',
                'answer'   => 'Report the fall immediately to store management to create an incident report. Also document the hazard with photographs, collect witness information, and seek medical attention. Prompt reporting helps preserve evidence and strengthens your claim.',
            ),
            array(
                'question' => 'What is the deadline to file a retail store fall lawsuit?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years from the date of injury (O.C.G.A. § 9-3-33). In South Carolina, you have 3 years (S.C. Code § 15-3-530).',
            ),
        ),
    ),

    /* ============================================================
       8. Workplace Slip and Fall
       ============================================================ */
    array(
        'title'   => 'Workplace Slip and Fall Lawyers',
        'slug'    => 'workplace-slip-and-fall',
        'excerpt' => 'Suffered a slip and fall at work in Georgia or South Carolina? Our attorneys help injured workers navigate workers\' compensation claims and third-party liability lawsuits for maximum recovery.',
        'content' => <<<'HTML'
<h2>Workplace Slip and Fall Injuries in Georgia &amp; South Carolina</h2>
<p>Slip and fall accidents are a leading cause of workplace injuries across every industry. The <a href="https://www.osha.gov/slips-trips-falls" target="_blank" rel="noopener">Occupational Safety and Health Administration (OSHA)</a> reports that slips, trips, and falls cause the majority of general industry accidents and are a leading cause of workers' compensation claims. In construction, falls are the number one cause of worker fatalities. Whether you work in an office, warehouse, retail store, restaurant, hospital, or construction site, your employer has a duty to maintain safe conditions and comply with OSHA safety standards.</p>
<p>At Roden Law, our workplace slip and fall lawyers help injured workers across Georgia and South Carolina understand their legal options. Depending on the circumstances, you may be entitled to <a href="/workers-compensation-lawyers/">workers' compensation benefits</a>, a third-party liability claim, or both.</p>

<h2>Workers' Compensation vs. Third-Party Claims</h2>
<p>Georgia and South Carolina both require most employers to carry workers' compensation insurance, which provides benefits for workplace injuries regardless of fault. However, workers' compensation typically limits the damages you can recover — it covers medical expenses and a portion of lost wages but does not include pain and suffering or punitive damages.</p>
<p>If a third party (someone other than your employer) contributed to your workplace fall, you may be able to file a separate personal injury lawsuit against that party for full damages. Common third-party defendants in workplace slip and fall cases include:</p>
<ul>
<li>Property owners or landlords (if your employer leases the workspace)</li>
<li>General contractors or subcontractors on construction sites</li>
<li>Cleaning and maintenance companies responsible for floor care</li>
<li>Manufacturers of defective flooring, ladders, scaffolding, or safety equipment</li>
<li>Vendors and delivery companies whose operations created a hazard</li>
</ul>
<p>Our attorneys evaluate every workplace fall case for both workers' compensation and third-party claim potential to maximize your total recovery.</p>

<h2>OSHA Standards for Slip and Fall Prevention</h2>
<p>OSHA establishes detailed standards for workplace slip and fall prevention, including requirements for walking-working surfaces (<a href="https://www.osha.gov/laws-regs/regulations/standardnumber/1910/1910Subpart" target="_blank" rel="noopener">29 CFR 1910 Subpart D</a>), fall protection in construction (<a href="https://www.osha.gov/laws-regs/regulations/standardnumber/1926/1926SubpartM" target="_blank" rel="noopener">29 CFR 1926 Subpart M</a>), housekeeping and floor maintenance, guardrails and handrails on elevated surfaces, and ladder and scaffold safety requirements. Violations of OSHA standards can serve as strong evidence of negligence in a third-party liability claim and may also support a citation against your employer. If your workplace fall involved a <a href="/construction-accident-lawyers/">construction site</a>, additional OSHA fall protection standards may apply.</p>

<h2>Common Workplace Slip and Fall Scenarios</h2>
<p>Our attorneys handle workplace fall cases arising from a wide range of circumstances:</p>
<ul>
<li>Wet or greasy floors in kitchens, break rooms, and manufacturing facilities</li>
<li>Spills in warehouses and distribution centers</li>
<li>Ice and snow on walkways, loading docks, and parking areas</li>
<li>Cluttered work areas and obstructed walkways</li>
<li>Inadequate lighting in stairwells, storage areas, and parking structures</li>
<li>Falls from ladders, scaffolds, and elevated platforms</li>
<li>Defective or improperly maintained floors, grates, and ramps</li>
</ul>

<h2>Georgia &amp; South Carolina Premises Liability for Workers</h2>
<p>Under Georgia's premises liability statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/article-1/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>), property owners owe a duty of ordinary care to all lawful visitors, including workers. South Carolina applies the same standard. If you were injured at a job site owned by a third party, that property owner may be liable for your injuries under premises liability law, in addition to any workers' compensation benefits you receive from your employer.</p>

<h2>Contact Roden Law After a Workplace Fall</h2>
<p>Workplace fall cases can be complex, involving overlapping workers' compensation and personal injury claims. Our attorneys help you navigate both systems to ensure you receive maximum compensation. Contact us for a free consultation — there is no fee unless we recover compensation for you.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue my employer for a workplace slip and fall?',
                'answer'   => 'In most cases, workers\' compensation is the exclusive remedy against your employer, meaning you cannot sue your employer directly. However, you may have a third-party claim against a property owner, contractor, equipment manufacturer, or other party whose negligence caused your fall.',
            ),
            array(
                'question' => 'What is the difference between workers\' compensation and a personal injury claim?',
                'answer'   => 'Workers\' compensation provides medical benefits and partial wage replacement regardless of fault, but does not include pain and suffering. A personal injury claim against a third party allows you to pursue full damages including pain and suffering, but requires proving negligence.',
            ),
            array(
                'question' => 'Can I receive both workers\' compensation and a third-party settlement?',
                'answer'   => 'Yes, but your workers\' compensation carrier may have a lien on your third-party recovery. Our attorneys negotiate these liens to maximize the amount you ultimately receive.',
            ),
            array(
                'question' => 'What if my employer violated OSHA safety standards?',
                'answer'   => 'OSHA violations do not create a direct private right of action, but they can serve as strong evidence of negligence in a third-party claim. You can also report violations to OSHA, which may result in citations and fines against your employer.',
            ),
            array(
                'question' => 'What is the statute of limitations for a workplace fall claim?',
                'answer'   => 'Workers\' compensation claims must be reported promptly — within 30 days in Georgia and within 90 days in South Carolina. Personal injury claims against third parties have a 2-year deadline in Georgia (O.C.G.A. § 9-3-33) and 3 years in South Carolina (S.C. Code § 15-3-530).',
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
