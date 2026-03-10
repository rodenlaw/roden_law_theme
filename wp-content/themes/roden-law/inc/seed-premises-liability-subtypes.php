<?php
/**
 * Seeder: 8 Premises Liability Sub-Type Pages
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-premises-liability-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: premises-liability-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'premises-liability-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'premises-liability-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "premises-liability-lawyers" not found.' );
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

$cat_term = term_exists( 'premises-liability', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Premises Liability', 'practice_category', array( 'slug' => 'premises-liability' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Retail Store and Shopping Center Injury
       ============================================================ */
    array(
        'title'   => 'Retail Store and Shopping Center Injury Lawyers',
        'slug'    => 'retail-store-shopping-center-injury',
        'excerpt' => 'Injured in a retail store or shopping center? Property owners and retailers owe customers a high duty of care. Our premises liability attorneys fight for full compensation when negligent property conditions cause injuries.',
        'content' => <<<'HTML'
<h2>Retail Store and Shopping Center Injury Lawyers in Georgia &amp; South Carolina</h2>
<p>Millions of people visit retail stores and shopping centers every day, trusting that the premises are reasonably safe. When property owners and retailers fail to maintain safe conditions, customers suffer serious injuries — from <a href="/slip-and-fall-lawyers/">slip and fall accidents</a> on wet floors to falling merchandise from improperly stacked shelves. The <a href="https://www.bls.gov/" target="_blank" rel="noopener">Bureau of Labor Statistics</a> and the National Floor Safety Institute report that falls are the leading cause of retail injury claims, but hazards extend well beyond wet floors.</p>
<p>At Roden Law, our retail store injury attorneys represent shoppers injured in stores, malls, and shopping centers throughout Georgia and South Carolina. We hold property owners, retail chains, and management companies accountable when their negligent maintenance, inadequate safety protocols, or understaffing leads to preventable injuries.</p>

<h2>Common Retail Store and Shopping Center Hazards</h2>
<p>Our attorneys handle claims involving a wide range of retail hazards:</p>
<ul>
<li><strong>Wet and slippery floors:</strong> Spills, tracked-in rainwater, freshly mopped floors without warning signs, and leaking refrigeration units create <a href="/slip-and-fall-lawyers/">dangerous slip and fall conditions</a></li>
<li><strong>Falling merchandise:</strong> Items improperly stacked on high shelves, unsecured displays, and top-heavy product arrangements that fall and strike customers</li>
<li><strong>Damaged flooring:</strong> Cracked tiles, torn carpet, uneven thresholds, missing floor mats, and changes in elevation without warning</li>
<li><strong>Obstructed aisles:</strong> Pallets, boxes, stocking carts, and merchandise left in walkways, creating tripping hazards</li>
<li><strong>Parking lot hazards:</strong> Potholes, poor lighting, inadequate drainage, ice and snow accumulation, and missing curb markers in <a href="/premises-liability-lawyers/parking-lot-garage-accident/">parking lots and garages</a></li>
<li><strong>Defective shopping carts:</strong> Broken wheels, collapsing carts, and carts that tip over, especially dangerous for children riding in the cart</li>
<li><strong>Automatic door malfunctions:</strong> Doors that close on customers, fail to open, or open unexpectedly</li>
</ul>

<h2>Premises Liability Law for Retail Injuries</h2>
<p>Both Georgia and South Carolina impose a heightened duty of care on retail establishments toward their customers (invitees):</p>
<ul>
<li><strong>Georgia:</strong> Under <a href="https://law.justia.com/codes/georgia/title-51/chapter-3/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>, property owners must exercise "ordinary care" to keep the premises safe for invitees. This includes a duty to inspect the property, discover hazardous conditions, and either correct them or warn invitees. Georgia courts apply the "equal knowledge" rule — a plaintiff cannot recover if they had equal knowledge of the hazard and could have avoided it.</li>
<li><strong>South Carolina:</strong> South Carolina imposes a similar duty on landowners toward invitees — the duty to exercise reasonable care to keep the premises in a reasonably safe condition, to warn of dangerous conditions that are not obvious, and to conduct reasonable inspections to discover latent hazards.</li>
</ul>
<p>Customers are classified as "invitees" — the highest duty category — because they enter the property for the mutual benefit of both parties (commercial transactions).</p>

<h2>Proving a Retail Store Injury Claim</h2>
<p>Our attorneys establish liability by proving that the store knew or should have known about the hazardous condition and failed to remedy it or warn customers. Key evidence includes:</p>
<ul>
<li><strong>Surveillance footage:</strong> Store cameras often capture both the hazard and the accident — but footage is frequently overwritten within days, making prompt legal action critical</li>
<li><strong>Incident reports:</strong> Internal store reports documenting the accident and conditions</li>
<li><strong>Inspection and maintenance logs:</strong> Records showing when floors were last inspected, cleaned, or mopped</li>
<li><strong>Prior complaints:</strong> Evidence of prior customer or employee complaints about the same hazard</li>
<li><strong>Expert testimony:</strong> Safety engineers and premises liability experts who evaluate whether the store met industry safety standards</li>
</ul>

<h2>Compensation for Retail Store Injuries</h2>
<p>Injured shoppers may recover medical expenses, lost wages, pain and suffering, permanent disability or disfigurement, and loss of enjoyment of life. Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/" target="_blank" rel="noopener">O.C.G.A. Title 51</a>) and South Carolina law provide full compensatory damages, and punitive damages may be available where the store's conduct was egregiously negligent.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What duty does a retail store owe to customers?',
                'answer'   => 'Retail stores owe customers (invitees) the highest duty of care under premises liability law. They must exercise ordinary care to keep the premises safe, conduct regular inspections to discover hazards, promptly clean up spills, repair dangerous conditions, and warn customers of hazards that cannot be immediately fixed.',
            ),
            array(
                'question' => 'How long does a store have to clean up a spill before they are liable?',
                'answer'   => 'There is no fixed time limit. The question is whether the store knew or should have known about the spill and had a reasonable opportunity to clean it up. If employees created the spill, the store is liable immediately. If a customer caused it, the store must show it had reasonable inspection procedures in place.',
            ),
            array(
                'question' => 'What should I do if I am injured in a retail store?',
                'answer'   => 'Report the incident to store management and ask for a written incident report. Photograph the hazard (spill, debris, damaged floor) and your injuries. Get contact information from any witnesses. Seek medical attention immediately. Do not give a recorded statement to the store\'s insurance company without consulting an attorney.',
            ),
            array(
                'question' => 'Can I sue a shopping center for a parking lot injury?',
                'answer'   => 'Yes. Shopping center owners and management companies are responsible for maintaining safe parking areas, including proper lighting, pothole repair, adequate drainage, ice and snow removal, and clearly marked pedestrian walkways. Both the individual store and the property owner may share liability.',
            ),
            array(
                'question' => 'What is the statute of limitations for a retail store injury?',
                'answer'   => 'Georgia allows 2 years from the date of injury (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). However, you should act quickly because surveillance footage — often the most critical evidence — is typically overwritten within 7-30 days.',
            ),
        ),
    ),

    /* ============================================================
       2. Restaurant and Hotel Injury
       ============================================================ */
    array(
        'title'   => 'Restaurant and Hotel Injury Lawyers',
        'slug'    => 'restaurant-hotel-injury',
        'excerpt' => 'Injured at a restaurant or hotel? Hospitality businesses owe guests a high duty of care. From wet floors to unsafe staircases to foodborne illness, our attorneys hold negligent establishments accountable.',
        'content' => <<<'HTML'
<h2>Restaurant and Hotel Injury Lawyers in Georgia &amp; South Carolina</h2>
<p>Restaurants, hotels, resorts, and other hospitality businesses welcome millions of guests each year. As commercial establishments that invite the public onto their premises for mutual benefit, they owe their guests a high duty of care under premises liability law. When restaurants and hotels fail to maintain safe conditions — whether through slippery floors, unsafe stairways, defective furniture, or <a href="/premises-liability-lawyers/inadequate-security/">inadequate security</a> — guests can suffer serious, life-altering injuries.</p>
<p>At Roden Law, our premises liability attorneys represent guests injured at restaurants, hotels, resorts, and other hospitality venues throughout Georgia and South Carolina. We hold both the business operator and the property owner accountable for unsafe conditions.</p>

<h2>Common Restaurant Injury Hazards</h2>
<p>Restaurant injuries frequently involve:</p>
<ul>
<li><strong>Wet and greasy floors:</strong> Kitchen grease, spilled drinks, tracked-in rainwater, and freshly mopped floors without adequate warning signs — the leading cause of <a href="/slip-and-fall-lawyers/">restaurant slip and fall claims</a></li>
<li><strong>Uneven flooring and transitions:</strong> Carpet-to-tile transitions, raised thresholds, steps without handrails, and damaged flooring</li>
<li><strong>Defective furniture:</strong> Broken chairs, unstable tables, and collapsing booths that cause falls or injuries</li>
<li><strong>Burns:</strong> Hot surfaces, scalding beverages, flaming desserts, and hot plates served without adequate warning</li>
<li><strong>Foodborne illness:</strong> Undercooked food, cross-contamination, allergen exposure, and health code violations</li>
<li><strong>Falling objects:</strong> Unsecured décor, ceiling fixtures, or shelving that falls onto guests</li>
</ul>

<h2>Common Hotel Injury Hazards</h2>
<p>Hotel injuries present unique risks due to the 24-hour nature of the business and guests' unfamiliarity with the property:</p>
<ul>
<li><strong>Bathroom falls:</strong> Slippery bathtubs, showers without grab bars or non-slip surfaces, wet bathroom floors, and inadequate lighting</li>
<li><strong>Balcony and railing failures:</strong> Inadequate or broken balcony railings, especially dangerous at upper-floor rooms</li>
<li><strong>Swimming pool accidents:</strong> See our <a href="/premises-liability-lawyers/swimming-pool-accident/">swimming pool accident</a> page for detailed information on pool safety and liability</li>
<li><strong><a href="/premises-liability-lawyers/elevator-escalator-accident/">Elevator and escalator malfunctions:</a></strong> Mechanical failures causing falls, entrapment, or crushing injuries</li>
<li><strong>Bed bug infestations:</strong> Failure to inspect, treat, and eradicate bed bug infestations causing physical and emotional harm</li>
<li><strong>Carbon monoxide exposure:</strong> Malfunctioning heating systems and poor ventilation</li>
<li><strong><a href="/premises-liability-lawyers/inadequate-security/">Security failures:</a></strong> Assaults, robberies, and sexual assaults resulting from inadequate security measures</li>
</ul>

<h2>Premises Liability Law for Hospitality Businesses</h2>
<p>Under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>), restaurants and hotels must exercise ordinary care to keep their premises safe for guests. South Carolina imposes a similar duty. Because guests are invitees, the business must proactively inspect the property, discover hazards, and correct them promptly — or provide adequate warnings.</p>
<p>Hotels have an especially high duty because guests are sleeping on the premises and are particularly vulnerable during overnight hours. Georgia courts have recognized that innkeepers have an elevated responsibility for guest safety.</p>

<h2>Multiple Liable Parties</h2>
<p>Restaurant and hotel injury cases often involve multiple defendants:</p>
<ul>
<li>The business operator (franchisee or management company)</li>
<li>The property owner (if different from the operator)</li>
<li>The franchisor (in franchise hotel/restaurant cases where the brand sets safety standards)</li>
<li>Maintenance contractors responsible for cleaning, repair, or snow/ice removal</li>
<li>Third-party security companies</li>
</ul>

<h2>Compensation for Restaurant and Hotel Injuries</h2>
<p>Injured guests may recover all medical expenses, lost wages and earning capacity, pain and suffering, emotional distress, and travel-related losses. Both Georgia and South Carolina allow full compensatory damages under their respective tort laws, and punitive damages may be available where the business demonstrated egregious disregard for guest safety.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What duty does a hotel owe to its guests?',
                'answer'   => 'Hotels owe guests (invitees) a high duty of care — they must maintain safe premises, conduct regular inspections, promptly address hazards, and provide adequate warnings. Because guests sleep on the premises and are unfamiliar with the property, courts recognize that hotels have an elevated responsibility for guest safety.',
            ),
            array(
                'question' => 'Can I sue a restaurant for food poisoning?',
                'answer'   => 'Yes. If you can establish that the restaurant served contaminated food that made you sick, you may have claims based on negligence, breach of warranty, and strict liability. Evidence such as health department records, other illness reports, and medical documentation linking your illness to the restaurant strengthens the case.',
            ),
            array(
                'question' => 'Who is liable for injuries at a franchise hotel or restaurant?',
                'answer'   => 'Potentially multiple parties: the individual franchise operator, the property owner, and in some cases the franchisor (brand) if it controlled the safety standards or operations that contributed to the injury. An attorney can identify all liable parties to maximize your recovery.',
            ),
            array(
                'question' => 'What should I do if I slip and fall at a restaurant?',
                'answer'   => 'Report the incident to management immediately and request a written incident report. Photograph the hazardous condition (wet floor, debris, damaged surface) and your injuries. Get witness names and contact information. Seek prompt medical attention. Preserve your shoes and clothing as evidence.',
            ),
            array(
                'question' => 'What is the statute of limitations for a hotel or restaurant injury claim?',
                'answer'   => 'Georgia allows 2 years (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Act quickly to preserve evidence — restaurants and hotels routinely overwrite surveillance footage within days, and incident reports may be lost or altered over time.',
            ),
        ),
    ),

    /* ============================================================
       3. Apartment Complex Injury
       ============================================================ */
    array(
        'title'   => 'Apartment Complex Injury Lawyers',
        'slug'    => 'apartment-complex-injury',
        'excerpt' => 'Injured in an apartment complex? Landlords must maintain safe premises for tenants and their guests. From broken stairways to parking lot hazards to inadequate security, our attorneys hold negligent landlords accountable.',
        'content' => <<<'HTML'
<h2>Apartment Complex Injury Lawyers in Georgia &amp; South Carolina</h2>
<p>Apartment complexes are homes to millions of renters, and landlords have a legal obligation to maintain the property in a reasonably safe condition. When landlords cut corners on maintenance, fail to repair known hazards, or provide <a href="/premises-liability-lawyers/inadequate-security/">inadequate security</a>, tenants and their guests suffer preventable injuries. The <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">Consumer Product Safety Commission</a> reports that residential premises injuries — including falls, burns, and structural failures — account for millions of emergency room visits each year.</p>
<p>At Roden Law, our apartment injury attorneys represent tenants and visitors injured in apartment complexes throughout Georgia and South Carolina. We hold landlords, property management companies, and corporate apartment owners accountable for unsafe living conditions that lead to injury.</p>

<h2>Common Apartment Complex Hazards</h2>
<p>Our attorneys handle claims arising from a wide range of dangerous apartment conditions:</p>
<ul>
<li><strong>Broken or defective stairways:</strong> Missing handrails, loose steps, broken stair treads, poor lighting in stairwells, and accumulated ice or debris on outdoor stairs</li>
<li><strong>Slippery common areas:</strong> Wet lobbies, unmopped hallways, icy walkways, and <a href="/slip-and-fall-lawyers/">slip and fall hazards</a> in laundry rooms and common spaces</li>
<li><strong>Parking lot hazards:</strong> Potholes, poor lighting, inadequate signage, and unsafe speed bumps in <a href="/premises-liability-lawyers/parking-lot-garage-accident/">parking areas</a></li>
<li><strong>Defective balconies and railings:</strong> Rotting wood, loose railings, and structural failures causing falls from elevated surfaces</li>
<li><strong>Fire safety failures:</strong> Missing or disabled smoke detectors, blocked fire exits, expired fire extinguishers, and failure to maintain fire suppression systems</li>
<li><strong>Swimming pool dangers:</strong> Missing fences, broken gates, no lifeguard or safety equipment, and chemical imbalances. See our <a href="/premises-liability-lawyers/swimming-pool-accident/">swimming pool accident</a> page.</li>
<li><strong>Criminal activity:</strong> Assaults, robberies, and break-ins facilitated by <a href="/premises-liability-lawyers/inadequate-security/">inadequate security</a> — broken locks, missing lighting, non-functional cameras, and no security personnel</li>
<li><strong>Environmental hazards:</strong> Mold, lead paint, carbon monoxide, and pest infestations</li>
</ul>

<h2>Georgia and South Carolina Landlord Liability</h2>
<p>Landlord premises liability obligations differ slightly between the two states:</p>
<ul>
<li><strong>Georgia:</strong> Under <a href="https://law.justia.com/codes/georgia/title-51/chapter-3/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>, landlords must exercise ordinary care to keep the premises safe. Georgia's landlord-tenant code (<a href="https://law.justia.com/codes/georgia/title-44/chapter-7/" target="_blank" rel="noopener">O.C.G.A. § 44-7-1 et seq.</a>) requires landlords to maintain the property in a habitable condition and make necessary repairs. Landlords must maintain control over common areas (hallways, stairwells, parking lots, pools) at all times.</li>
<li><strong>South Carolina:</strong> The <a href="https://www.scstatehouse.gov/code/t27c040.php" target="_blank" rel="noopener">S.C. Code § 27-40-10 et seq.</a> (South Carolina Residential Landlord and Tenant Act) requires landlords to maintain the premises in a safe and habitable condition, comply with building and housing codes, and make timely repairs.</li>
</ul>
<p>Importantly, landlords retain liability for common areas regardless of what the lease says — lease provisions that attempt to waive liability for landlord negligence are generally unenforceable in both states.</p>

<h2>Proving an Apartment Complex Injury Claim</h2>
<p>The key element in apartment injury cases is proving that the landlord knew or should have known about the hazardous condition and failed to fix it. Our attorneys gather evidence including maintenance request records and work orders, prior tenant complaints, building code violation records, property inspection reports, and photographs and video of the hazardous condition.</p>

<h2>Compensation for Apartment Complex Injuries</h2>
<p>Injured tenants and guests may recover medical expenses, lost wages, pain and suffering, relocation costs, and punitive damages when the landlord's neglect was willful or egregious. Both Georgia and South Carolina permit full compensatory damages under their premises liability frameworks.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue my landlord for an injury in a common area?',
                'answer'   => 'Yes. Landlords have a non-delegable duty to maintain common areas — hallways, stairwells, lobbies, parking lots, swimming pools, and walkways — in a safe condition. Even if the landlord hired a property management company, the landlord retains ultimate responsibility for common area safety.',
            ),
            array(
                'question' => 'Does my lease prevent me from suing the landlord for injuries?',
                'answer'   => 'Generally, no. Lease provisions that attempt to waive the landlord\'s liability for negligence are typically unenforceable under Georgia and South Carolina law. You cannot contractually waive a landlord\'s duty to maintain safe premises, especially in common areas.',
            ),
            array(
                'question' => 'What if I reported the hazard to my landlord before I was injured?',
                'answer'   => 'Prior notice to the landlord strengthens your case significantly. If you reported a broken stair, missing handrail, or other hazard and the landlord failed to repair it, that establishes actual knowledge of the danger. Keep copies of all maintenance requests and correspondence.',
            ),
            array(
                'question' => 'Can a guest who is injured at my apartment complex sue the landlord?',
                'answer'   => 'Yes. Landlord premises liability extends to tenants, their guests, and all lawful visitors. A guest injured by a hazardous condition in a common area or resulting from the landlord\'s failure to maintain the property has the same right to bring a premises liability claim.',
            ),
            array(
                'question' => 'What is the statute of limitations for an apartment complex injury claim?',
                'answer'   => 'Georgia has a 2-year statute of limitations (O.C.G.A. § 9-3-33) and South Carolina has 3 years (S.C. Code § 15-3-530). Report the hazard in writing to the landlord immediately after the injury, document the condition with photos, and consult an attorney promptly.',
            ),
        ),
    ),

    /* ============================================================
       4. Parking Lot and Garage Accident
       ============================================================ */
    array(
        'title'   => 'Parking Lot and Garage Accident Lawyers',
        'slug'    => 'parking-lot-garage-accident',
        'excerpt' => 'Injured in a parking lot or parking garage? Property owners must maintain safe conditions including proper lighting, repaired surfaces, and adequate signage. Our attorneys pursue full compensation for parking lot injuries.',
        'content' => <<<'HTML'
<h2>Parking Lot and Garage Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Parking lots and garages are among the most overlooked hazard zones in premises liability law. The <a href="https://www.nsc.org/" target="_blank" rel="noopener">National Safety Council</a> reports that tens of thousands of crashes occur in parking lots and structures annually, resulting in hundreds of deaths and thousands of injuries. Beyond vehicle collisions, parking lot hazards include potholes, poor lighting, ice accumulation, pedestrian conflicts, and <a href="/premises-liability-lawyers/inadequate-security/">security failures</a> that enable criminal assaults.</p>
<p>At Roden Law, our parking lot accident attorneys represent people injured in parking lots and garages throughout Georgia and South Carolina — whether by a vehicle collision, a trip and fall, or a criminal act facilitated by the property owner's negligence.</p>

<h2>Common Parking Lot and Garage Hazards</h2>
<p>Our attorneys handle parking lot injury claims involving:</p>
<ul>
<li><strong>Potholes and surface defects:</strong> Cracked, crumbling, or uneven pavement causing trips, falls, and vehicle damage</li>
<li><strong>Poor lighting:</strong> Inadequate, broken, or burned-out lighting that creates visibility hazards and enables criminal activity</li>
<li><strong>Missing or faded markings:</strong> Absent lane markings, stop signs, speed bumps, and pedestrian crosswalks</li>
<li><strong>Ice and snow:</strong> Failure to salt, sand, or clear ice from parking surfaces and walkways during winter weather</li>
<li><strong>Pedestrian conflicts:</strong> Lack of designated pedestrian walkways separating foot traffic from vehicles</li>
<li><strong>Drainage problems:</strong> Standing water, oil slicks, and flooding creating <a href="/slip-and-fall-lawyers/">slip and fall</a> conditions</li>
<li><strong>Structural defects in garages:</strong> Crumbling concrete, exposed rebar, low-clearance strikes, and ramp hazards</li>
<li><strong>Criminal activity:</strong> Robberies, assaults, carjackings, and sexual assaults enabled by <a href="/premises-liability-lawyers/inadequate-security/">inadequate security measures</a></li>
</ul>

<h2>Property Owner Responsibility for Parking Lot Safety</h2>
<p>Under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>) and South Carolina premises liability law, property owners must exercise ordinary care to maintain parking lots in a safe condition for invitees. This includes regular inspection and repair of surfaces, adequate lighting at all hours, proper drainage, clear signage and lane markings, and reasonable security measures based on the crime history of the area.</p>
<p>Georgia's comparative fault rule means that even if the injured person bears some responsibility (such as not watching where they were walking), they may still recover damages if their fault was less than 50%. South Carolina uses a similar modified comparative fault standard with a 51% threshold.</p>

<h2>Parking Garage Specific Hazards</h2>
<p>Parking garages present additional dangers beyond surface lots:</p>
<ul>
<li><strong>Structural deterioration:</strong> Garages are exposed to water, salt, and vehicle fluids that accelerate concrete degradation</li>
<li><strong>Carbon monoxide buildup:</strong> Enclosed or poorly ventilated garages can accumulate dangerous carbon monoxide levels</li>
<li><strong>Elevator and stairwell hazards:</strong> Broken <a href="/premises-liability-lawyers/elevator-escalator-accident/">elevators</a>, dark stairwells, and missing handrails</li>
<li><strong>Height dangers:</strong> Inadequate barriers and guardrails on upper levels</li>
<li><strong>Limited visibility:</strong> Tight turns, blind corners, and columns that obstruct sightlines between vehicles and pedestrians</li>
</ul>

<h2>Compensation for Parking Lot Injuries</h2>
<p>Injured persons may recover compensation for medical expenses, lost wages, pain and suffering, permanent disability, and emotional distress. When criminal assaults are facilitated by inadequate security, additional damages for psychological trauma are typically available. Georgia (<a href="https://law.justia.com/codes/georgia/title-51/" target="_blank" rel="noopener">O.C.G.A. Title 51</a>) and South Carolina law provide the full range of compensatory damages in premises liability cases.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Is a property owner liable for a parking lot accident?',
                'answer'   => 'Property owners are liable when their negligence contributed to the accident — such as failure to repair potholes, maintain adequate lighting, clear ice and snow, or provide proper signage. Both Georgia and South Carolina hold property owners to a duty of ordinary care for invitees on their parking facilities.',
            ),
            array(
                'question' => 'Who is responsible for parking lot maintenance — the store or the property owner?',
                'answer'   => 'It depends on the lease agreement. Often the property owner (landlord) is responsible for common area maintenance including parking lots, but some leases shift responsibility to tenants. Regardless of the lease terms, our attorneys identify all potentially liable parties and pursue claims against each.',
            ),
            array(
                'question' => 'Can I sue for a pothole injury in a parking lot?',
                'answer'   => 'Yes. If the property owner knew or should have known about the pothole and failed to repair it or warn visitors, they are liable under premises liability law. Evidence of prior complaints, the pothole\'s age and visibility, and maintenance records are all relevant to proving your claim.',
            ),
            array(
                'question' => 'What if I was hit by a car in a parking lot?',
                'answer'   => 'You may have claims against both the driver who struck you and the property owner if poor parking lot design, missing signage, inadequate pedestrian walkways, or obstructed sight lines contributed to the accident. Our attorneys investigate all contributing factors.',
            ),
            array(
                'question' => 'What is the statute of limitations for a parking lot injury claim?',
                'answer'   => 'Georgia allows 2 years (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Document the hazardous condition with photos immediately — parking lot conditions change quickly as potholes are filled and lighting is repaired.',
            ),
        ),
    ),

    /* ============================================================
       5. Swimming Pool Accident
       ============================================================ */
    array(
        'title'   => 'Swimming Pool Accident Lawyers',
        'slug'    => 'swimming-pool-accident',
        'excerpt' => 'Swimming pool accidents cause devastating injuries and drowning deaths. Property owners have strict duties to maintain safe pools and prevent unauthorized access. Our attorneys hold negligent pool owners accountable.',
        'content' => <<<'HTML'
<h2>Swimming Pool Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Swimming pools are a source of recreation and relaxation — but they are also one of the most dangerous features on any property. The <a href="https://www.cdc.gov/drowning/" target="_blank" rel="noopener">CDC</a> reports that drowning is the leading cause of death for children ages 1-4 and a leading cause of unintentional death for all ages. Beyond drowning, pool accidents cause traumatic brain injuries from diving, spinal cord injuries, entrapment injuries from defective drains, chemical burns, and electrocution from faulty wiring. Many of these tragedies are entirely preventable with proper safety measures.</p>
<p>At Roden Law, our swimming pool accident attorneys represent victims and families throughout Georgia and South Carolina. We pursue claims against homeowners, apartment complexes, hotels, community pools, and any property owner whose negligence led to a pool-related injury or death.</p>

<h2>Common Swimming Pool Accident Causes</h2>
<p>Our attorneys handle swimming pool cases involving:</p>
<ul>
<li><strong>Drowning and near-drowning:</strong> Inadequate supervision, missing or broken pool fences and gates, lack of lifeguards at public/commercial pools, and absence of rescue equipment</li>
<li><strong>Diving injuries:</strong> Diving into shallow water, often due to missing depth markers, no "no diving" signs, or deceptive pool design that makes the water appear deeper than it is</li>
<li><strong>Drain entrapment:</strong> Hair, clothing, or body parts becoming caught in pool drains, leading to drowning or disembowelment. The federal <a href="https://www.cpsc.gov/Safety-Education/Safety-Education-Centers/Pool-Safely" target="_blank" rel="noopener">Virginia Graeme Baker Pool and Spa Safety Act</a> mandates anti-entrapment drain covers in public pools.</li>
<li><strong>Slip and fall injuries:</strong> Wet pool decks without non-slip surfaces, creating dangerous <a href="/slip-and-fall-lawyers/">slip and fall conditions</a></li>
<li><strong>Chemical injuries:</strong> Improper pool chemical storage, handling, or dosing causing burns, respiratory distress, or poisoning</li>
<li><strong>Electrocution:</strong> Faulty underwater lighting, nearby electrical equipment, or improper grounding and bonding of pool electrical systems</li>
</ul>

<h2>Georgia and South Carolina Pool Safety Laws</h2>
<p>Both states have specific pool safety requirements:</p>
<ul>
<li><strong>Georgia:</strong> <a href="https://law.justia.com/codes/georgia/title-31/chapter-45/" target="_blank" rel="noopener">O.C.G.A. § 31-45-1 et seq.</a> (Georgia Swimming Pool, Spa, and Recreational Water Establishment Act) regulates public and semi-public pools, requiring safety equipment, fencing, proper chemical maintenance, and trained operators. Georgia follows the Model Aquatic Health Code. Local ordinances may impose additional requirements.</li>
<li><strong>South Carolina:</strong> <a href="https://www.scstatehouse.gov/code/t44c001.php" target="_blank" rel="noopener">S.C. Code § 44-1-140</a> and DHEC regulations govern public swimming pools, requiring fencing, safety equipment, proper chemical levels, and compliance with the Virginia Graeme Baker Act for drain safety.</li>
</ul>
<p>Private residential pools also carry premises liability obligations. Under <a href="https://law.justia.com/codes/georgia/title-51/chapter-3/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>, homeowners must exercise ordinary care for invited guests. Additionally, the attractive nuisance doctrine may impose liability to trespassing children who are injured by an unfenced pool.</p>

<h2>Drowning Deaths and Wrongful Death Claims</h2>
<p>When a swimming pool accident results in death — particularly the drowning death of a child — families have the right to pursue a <a href="/wrongful-death-lawyers/">wrongful death claim</a>. Georgia's wrongful death statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-4/" target="_blank" rel="noopener">O.C.G.A. § 51-4-1</a>) measures damages by the "full value of the life" of the deceased. South Carolina's wrongful death statute (<a href="https://www.scstatehouse.gov/code/t15c051.php" target="_blank" rel="noopener">S.C. Code § 15-51-10</a>) allows recovery for pecuniary losses, mental shock, and loss of companionship.</p>

<h2>Compensation for Swimming Pool Injuries</h2>
<p>Pool accident victims may recover medical expenses, rehabilitation costs, lost wages, pain and suffering, permanent disability (particularly relevant in spinal cord and brain injury cases), and wrongful death damages. Punitive damages are available when the pool owner demonstrated willful or wanton disregard for safety — such as knowingly operating with broken drain covers, missing fencing, or known electrical defects.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What safety features are required for swimming pools?',
                'answer'   => 'Georgia and South Carolina require public and semi-public pools to have fencing with self-closing/self-latching gates, anti-entrapment drain covers (per the Virginia Graeme Baker Act), proper chemical maintenance, safety equipment (life rings, shepherd\'s hooks), and depth markers. Many local jurisdictions also require fencing around private residential pools.',
            ),
            array(
                'question' => 'Can a homeowner be liable for a drowning in their pool?',
                'answer'   => 'Yes. Homeowners must exercise ordinary care for invited guests. Additionally, the attractive nuisance doctrine may impose liability for injuries to trespassing children if the homeowner failed to fence the pool or install self-latching gates. Pools are considered inherently attractive and dangerous to children.',
            ),
            array(
                'question' => 'What is drain entrapment and why is it dangerous?',
                'answer'   => 'Drain entrapment occurs when hair, clothing, or body parts become caught in a pool drain\'s suction, trapping the swimmer underwater. It can cause drowning or severe internal injuries. The federal Virginia Graeme Baker Pool and Spa Safety Act requires anti-entrapment drain covers in public pools to prevent these tragedies.',
            ),
            array(
                'question' => 'Who is liable for a pool accident at an apartment complex or hotel?',
                'answer'   => 'The property owner, management company, and any contracted pool maintenance company may all share liability. If the pool lacked required fencing, safety equipment, or proper chemical maintenance, each party with responsibility for pool safety can be held accountable.',
            ),
            array(
                'question' => 'What is the statute of limitations for a swimming pool accident claim?',
                'answer'   => 'Georgia allows 2 years (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Wrongful death claims have the same deadlines measured from the date of death. Contact an attorney immediately to preserve evidence — pool conditions and maintenance records can change quickly.',
            ),
        ),
    ),

    /* ============================================================
       6. Inadequate Security
       ============================================================ */
    array(
        'title'   => 'Inadequate Security Lawyers',
        'slug'    => 'inadequate-security',
        'excerpt' => 'Were you assaulted, robbed, or attacked on someone else\'s property due to inadequate security? Property owners who fail to provide reasonable security measures can be held liable for criminal acts against visitors.',
        'content' => <<<'HTML'
<h2>Inadequate Security Lawyers in Georgia &amp; South Carolina</h2>
<p>When a property owner fails to provide reasonable security measures and a visitor is harmed by criminal activity — assault, robbery, sexual assault, or murder — the property owner can be held civilly liable. This area of premises liability law, known as negligent security, recognizes that while the criminal is primarily responsible, a property owner who knew or should have known about the risk of crime and failed to take reasonable precautions shares responsibility for the resulting harm.</p>
<p>At Roden Law, our negligent security attorneys represent victims of violent crime throughout Georgia and South Carolina — at apartment complexes, hotels, shopping centers, <a href="/premises-liability-lawyers/parking-lot-garage-accident/">parking lots</a>, bars, nightclubs, and other commercial properties where the owner's failure to provide adequate security contributed to the attack.</p>

<h2>What Constitutes Adequate Security?</h2>
<p>The level of security required depends on the nature of the property and the foreseeability of criminal activity. Factors include:</p>
<ul>
<li><strong>Prior crime history:</strong> Properties with a history of criminal activity in and around the premises are on notice of the risk and must take heightened precautions</li>
<li><strong>Area crime rates:</strong> Properties in high-crime areas have a greater obligation to provide security</li>
<li><strong>Type of property:</strong> Hotels, apartment complexes, and bars have different security obligations based on their nature and hours of operation</li>
<li><strong>Industry standards:</strong> What security measures are standard for similar properties in the area</li>
</ul>
<p>Reasonable security measures may include adequate lighting (especially in parking areas, stairwells, and entrances), working locks on doors, gates, and windows, surveillance cameras, security personnel, controlled access points, emergency call stations, and proper key/access card management.</p>

<h2>Georgia and South Carolina Negligent Security Law</h2>
<p>Both states apply premises liability principles to negligent security claims:</p>
<ul>
<li><strong>Georgia:</strong> Under <a href="https://law.justia.com/codes/georgia/title-51/chapter-3/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>, property owners must exercise ordinary care to protect invitees from foreseeable criminal acts. Georgia courts evaluate foreseeability based on the "totality of the circumstances," including prior similar crimes on or near the property. The Georgia Supreme Court has held that a property owner may be liable for criminal attacks when the owner had knowledge of prior criminal activity that made the attack foreseeable.</li>
<li><strong>South Carolina:</strong> South Carolina applies similar foreseeability principles, requiring property owners to take reasonable security measures when criminal activity is foreseeable based on the location, nature of the business, and prior crime history.</li>
</ul>

<h2>Common Inadequate Security Locations</h2>
<p>Our attorneys handle negligent security cases at:</p>
<ul>
<li><strong><a href="/premises-liability-lawyers/apartment-complex-injury/">Apartment complexes:</a></strong> Broken locks, non-functional gates, missing lighting, and failure to screen tenants</li>
<li><strong>Hotels and motels:</strong> Failure to restrict room access, missing deadbolts, non-functioning electronic locks, and inadequate parking lot security</li>
<li><strong>Shopping centers and <a href="/premises-liability-lawyers/retail-store-shopping-center-injury/">retail stores</a>:</strong> Parking lot robberies, assaults in dimly lit areas, and failure to employ security guards</li>
<li><strong>Bars and nightclubs:</strong> Failure to hire adequate bouncers, overserving patrons, and allowing weapons on premises</li>
<li><strong>Hospitals and medical facilities:</strong> Patient assaults, visitor violence, and workplace attacks</li>
<li><strong>College campuses:</strong> Dormitory assaults, campus parking lot attacks, and failure to implement campus security protocols</li>
</ul>

<h2>Compensation for Inadequate Security Victims</h2>
<p>Victims of criminal attacks enabled by negligent security may recover medical expenses, mental health treatment costs, lost wages, pain and suffering, post-traumatic stress disorder (PTSD) damages, loss of enjoyment of life, and punitive damages. Both Georgia and South Carolina recognize that the emotional and psychological harm from a violent assault can far exceed the physical injuries. <a href="/wrongful-death-lawyers/">Wrongful death claims</a> are available when a fatal assault results from inadequate security.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can a property owner be held liable for a criminal attack?',
                'answer'   => 'Yes. While the criminal bears primary responsibility, a property owner who failed to provide reasonable security measures can be held civilly liable if the criminal activity was foreseeable. Foreseeability is based on prior crime history at and near the property, the nature of the business, and industry security standards.',
            ),
            array(
                'question' => 'What makes criminal activity "foreseeable" for a negligent security claim?',
                'answer'   => 'Courts consider the totality of circumstances: prior crimes on the property, crime rates in the surrounding area, the type of business, hours of operation, and the general vulnerability of visitors. A history of criminal incidents at or near the property is strong evidence of foreseeability.',
            ),
            array(
                'question' => 'Can I sue my apartment complex for a break-in or assault?',
                'answer'   => 'Yes, if the apartment complex failed to provide adequate security. Evidence of broken locks, non-functional cameras, missing lighting, or failure to address prior criminal activity supports a negligent security claim. Landlords have a duty to provide reasonable security for tenants.',
            ),
            array(
                'question' => 'What security measures should a property owner provide?',
                'answer'   => 'The required level of security depends on the property type and crime risk, but reasonable measures typically include adequate lighting, working locks, surveillance cameras, security personnel (for high-risk properties), controlled access, and proper key management. The standard is what a reasonably prudent property owner would provide under similar circumstances.',
            ),
            array(
                'question' => 'What is the statute of limitations for a negligent security claim?',
                'answer'   => 'Georgia allows 2 years (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530) for personal injury claims. Assault and battery claims may have additional time considerations. Contact an attorney promptly — security footage is often overwritten quickly and crime patterns must be documented.',
            ),
        ),
    ),

    /* ============================================================
       7. Elevator and Escalator Accident
       ============================================================ */
    array(
        'title'   => 'Elevator and Escalator Accident Lawyers',
        'slug'    => 'elevator-escalator-accident',
        'excerpt' => 'Elevator and escalator accidents cause serious injuries including falls, entrapment, crushing injuries, and amputations. Property owners and maintenance companies must keep these systems safe. Our attorneys pursue full accountability.',
        'content' => <<<'HTML'
<h2>Elevator and Escalator Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Americans take over 18 billion elevator trips per year, and escalators carry an estimated 90 billion riders annually. While generally safe when properly maintained, elevator and escalator malfunctions can cause devastating injuries — from falls and entrapment to crushing injuries and amputations. The <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">Consumer Product Safety Commission (CPSC)</a> reports that escalators alone cause approximately 10,000 injuries per year, with children and elderly individuals at greatest risk.</p>
<p>At Roden Law, our elevator and escalator accident attorneys represent injury victims throughout Georgia and South Carolina. These cases are technically complex, often involving multiple liable parties — the building owner, the elevator/escalator maintenance company, and the equipment manufacturer. Our attorneys work with engineering experts to determine exactly what went wrong and who is responsible.</p>

<h2>Common Elevator Accidents</h2>
<p>Our attorneys handle elevator injury cases involving:</p>
<ul>
<li><strong>Misleveling:</strong> The elevator stops above or below the floor level, creating a trip-and-fall hazard as passengers step into or out of the car</li>
<li><strong>Door malfunctions:</strong> Doors that close too quickly, fail to detect obstructions, or open between floors</li>
<li><strong>Free-fall and sudden stops:</strong> Brake failures, cable issues, or control system malfunctions causing the car to drop or jolt violently</li>
<li><strong>Entrapment:</strong> Being trapped in a stalled elevator, causing physical injuries (from attempts to escape) and psychological trauma</li>
<li><strong>Shaft falls:</strong> Doors opening when the car is not at the landing, allowing passengers to fall into the shaft</li>
<li><strong>Crushing injuries:</strong> Being caught between the elevator car and the shaft wall, or between closing doors</li>
</ul>

<h2>Common Escalator Accidents</h2>
<p>Escalator injuries frequently involve:</p>
<ul>
<li><strong>Entrapment:</strong> Fingers, feet, clothing, or shoes caught in the gap between the step and the side panel (a particular danger for children)</li>
<li><strong>Sudden stops or reversals:</strong> Abrupt escalator stops causing passengers to fall forward in a chain reaction</li>
<li><strong>Missing or broken handrails:</strong> Handrails that stop moving, move at a different speed than the steps, or are missing entirely</li>
<li><strong>Step defects:</strong> Broken, missing, or uneven step treads that catch feet or cause falls</li>
<li><strong>Comb plate failures:</strong> Broken or missing comb plates at the top and bottom of the escalator that catch feet and clothing</li>
</ul>

<h2>Georgia and South Carolina Elevator Safety Regulations</h2>
<p>Both states regulate elevator and escalator safety:</p>
<ul>
<li><strong>Georgia:</strong> <a href="https://law.justia.com/codes/georgia/title-8/chapter-2/article-9/" target="_blank" rel="noopener">O.C.G.A. § 8-2-100 et seq.</a> (Georgia Elevator, Dumbwaiter, and Escalator Safety Act) requires annual inspections, licensed operators and mechanics, and compliance with national safety codes (ASME A17.1). The Office of Insurance and Safety Fire Commissioner oversees enforcement.</li>
<li><strong>South Carolina:</strong> South Carolina regulates elevators and escalators through the <a href="https://www.scstatehouse.gov/code/t41c018.php" target="_blank" rel="noopener">S.C. Code § 41-18-10 et seq.</a> (Elevator and Amusement Rides Safety Code Act), requiring inspections, licensing, and compliance with ASME standards.</li>
</ul>

<h2>Liability in Elevator and Escalator Cases</h2>
<p>Multiple parties may be liable for an elevator or escalator accident:</p>
<ul>
<li><strong>Building/property owner:</strong> Liable under premises liability (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/section-51-3-1/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>) for failing to maintain safe conditions</li>
<li><strong>Maintenance/service company:</strong> Companies like Otis, Schindler, ThyssenKrupp, and KONE that contract to maintain the equipment and may be liable for negligent maintenance or repair</li>
<li><strong>Manufacturer:</strong> The equipment manufacturer may face <a href="/product-liability-lawyers/">product liability claims</a> if a design or manufacturing defect caused the malfunction</li>
<li><strong>Inspection companies:</strong> Third-party inspectors who negligently failed to identify hazardous conditions</li>
</ul>

<h2>Compensation for Elevator and Escalator Injuries</h2>
<p>Victims may recover medical expenses, lost wages, pain and suffering, permanent disability (particularly in amputation and crushing injury cases), emotional distress including PTSD, and punitive damages. <a href="/wrongful-death-lawyers/">Wrongful death claims</a> are available for fatal elevator shaft falls and other deadly malfunctions.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who is responsible for elevator and escalator maintenance?',
                'answer'   => 'The building or property owner has the ultimate responsibility for maintaining safe elevators and escalators. However, most owners contract with specialized service companies (Otis, Schindler, ThyssenKrupp, etc.) for maintenance. Both the owner and the maintenance company can be held liable when negligent maintenance causes an accident.',
            ),
            array(
                'question' => 'What should I do if I am injured in an elevator or escalator accident?',
                'answer'   => 'Seek immediate medical attention. Report the incident to building management and request a copy of any incident report. Photograph the equipment if possible. Note the building address, elevator/escalator number, and any witnesses. Do not discuss the incident with the building\'s insurance company before consulting an attorney.',
            ),
            array(
                'question' => 'Are elevator accidents more common than people think?',
                'answer'   => 'Yes. While fatal elevator accidents are relatively rare, injuries from elevator misleveling, door malfunctions, and entrapment are more common than most people realize. Escalator injuries are even more prevalent — approximately 10,000 per year according to the CPSC, with children and elderly individuals at greatest risk.',
            ),
            array(
                'question' => 'Can I sue the elevator manufacturer?',
                'answer'   => 'Yes, if a design defect, manufacturing defect, or failure to warn contributed to the accident. Product liability claims against the manufacturer are separate from premises liability claims against the building owner and negligence claims against the maintenance company. Multiple parties can be held jointly liable.',
            ),
            array(
                'question' => 'What is the statute of limitations for an elevator or escalator injury claim?',
                'answer'   => 'Georgia has a 2-year statute of limitations (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Product liability claims against manufacturers may have different deadlines. Contact an attorney promptly, as critical maintenance records and inspection reports must be preserved before they are lost or destroyed.',
            ),
        ),
    ),

    /* ============================================================
       8. Amusement Park and Recreational Injury
       ============================================================ */
    array(
        'title'   => 'Amusement Park and Recreational Injury Lawyers',
        'slug'    => 'amusement-park-recreational-injury',
        'excerpt' => 'Injured at an amusement park, water park, trampoline park, or other recreational facility? These businesses have a duty to keep rides, attractions, and premises safe. Our attorneys pursue full compensation for recreational injuries.',
        'content' => <<<'HTML'
<h2>Amusement Park and Recreational Injury Lawyers in Georgia &amp; South Carolina</h2>
<p>Amusement parks, water parks, trampoline parks, go-kart tracks, zip lines, and other recreational facilities attract millions of visitors each year. While these attractions are designed for fun, they carry inherent risks — and when operators fail to maintain rides, train staff, or enforce safety rules, the consequences can be catastrophic. The <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">Consumer Product Safety Commission</a> tracks thousands of amusement ride injuries annually at fixed-site parks, and that number grows significantly when mobile rides (fairs and carnivals), trampoline parks, and other recreational venues are included.</p>
<p>At Roden Law, our recreational injury attorneys represent visitors injured at amusement and recreational facilities throughout Georgia and South Carolina. We hold operators, property owners, equipment manufacturers, and corporate franchisors accountable when their negligence turns a day of family fun into a life-changing tragedy.</p>

<h2>Types of Recreational Facility Injuries</h2>
<p>Our attorneys handle injury claims at a variety of recreational venues:</p>
<ul>
<li><strong>Amusement park rides:</strong> Roller coaster derailments, restraint failures, ride ejections, mechanical malfunctions, and operator error</li>
<li><strong>Water parks:</strong> Drowning, near-drowning, waterslide collisions, wave pool incidents, and chemical exposure. See also our <a href="/premises-liability-lawyers/swimming-pool-accident/">swimming pool accident</a> page.</li>
<li><strong>Trampoline parks:</strong> Broken bones, spinal cord injuries, traumatic brain injuries, and paralysis from bouncing collisions, falls, and landing in foam pits</li>
<li><strong>Go-kart tracks:</strong> Collisions, ejections, roll-overs, and track design defects</li>
<li><strong>Zip lines and ropes courses:</strong> Equipment failure, harness defects, and operator error</li>
<li><strong>Bounce houses and inflatable attractions:</strong> Collapses, wind-related incidents, and overcrowding injuries</li>
<li><strong>Miniature golf, batting cages, and arcades:</strong> Structural hazards, equipment defects, and premises maintenance failures</li>
</ul>

<h2>Georgia and South Carolina Amusement Ride Safety Laws</h2>
<p>Both states regulate amusement ride safety:</p>
<ul>
<li><strong>Georgia:</strong> <a href="https://law.justia.com/codes/georgia/title-34/chapter-12/" target="_blank" rel="noopener">O.C.G.A. § 34-12-1 et seq.</a> (Georgia Amusement Ride Safety Act) requires registration and inspection of amusement rides, sets operator qualifications, and mandates accident reporting. The Office of Insurance and Safety Fire Commissioner enforces the act.</li>
<li><strong>South Carolina:</strong> <a href="https://www.scstatehouse.gov/code/t41c018.php" target="_blank" rel="noopener">S.C. Code § 41-18-10 et seq.</a> (Elevator and Amusement Rides Safety Code Act) covers amusement rides, requiring inspections, insurance, and compliance with ASTM International standards for amusement ride safety.</li>
</ul>
<p>Violations of these statutes — operating without proper inspections, using untrained operators, or failing to report accidents — constitute negligence per se and powerfully support injury claims.</p>

<h2>Waivers and Assumption of Risk</h2>
<p>Most recreational facilities require visitors to sign liability waivers. Many families believe these waivers prevent them from suing if they're injured. However:</p>
<ul>
<li><strong>Georgia:</strong> Liability waivers are enforceable for ordinary negligence in Georgia, but they do <strong>not</strong> bar claims for gross negligence, willful misconduct, or violations of safety statutes. Waivers signed on behalf of minors are also subject to legal challenge.</li>
<li><strong>South Carolina:</strong> South Carolina courts enforce liability waivers more strictly than many states, but waivers cannot protect against gross negligence, recklessness, or intentional conduct. Waivers for minors are generally unenforceable.</li>
</ul>
<p>Our attorneys analyze every waiver to determine whether it is enforceable under the specific circumstances of your case.</p>

<h2>Multiple Liable Parties</h2>
<p>Recreational injury cases often involve multiple defendants, including the facility operator, the property owner (if different), ride or equipment manufacturers (<a href="/product-liability-lawyers/">product liability</a>), maintenance contractors, franchisors (for franchise-branded parks), and event organizers (for fairs, festivals, and temporary attractions).</p>

<h2>Compensation for Recreational Injuries</h2>
<p>Victims may recover medical expenses, rehabilitation costs, lost wages, pain and suffering, permanent disability, disfigurement, emotional distress, and <a href="/wrongful-death-lawyers/">wrongful death damages</a>. Punitive damages are available under Georgia (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/" target="_blank" rel="noopener">O.C.G.A. § 51-12-5.1</a>) and South Carolina law when the operator's conduct was willful, malicious, or showed conscious indifference to safety.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Does signing a waiver prevent me from suing an amusement park?',
                'answer'   => 'Not necessarily. While Georgia and South Carolina enforce waivers for ordinary negligence in some circumstances, waivers do not protect against gross negligence, willful misconduct, or statutory safety violations. Waivers signed on behalf of minors are also subject to legal challenge. An attorney can evaluate whether the waiver bars your specific claim.',
            ),
            array(
                'question' => 'Who regulates amusement park ride safety in Georgia?',
                'answer'   => 'The Georgia Office of Insurance and Safety Fire Commissioner enforces the Georgia Amusement Ride Safety Act (O.C.G.A. § 34-12-1 et seq.), which requires ride registration, inspections, operator qualifications, and accident reporting. Violations of these requirements support negligence claims.',
            ),
            array(
                'question' => 'Can I sue a trampoline park for my child\'s injury?',
                'answer'   => 'Yes. Despite waivers, trampoline parks can be held liable for inadequate supervision, failure to enforce safety rules, overcrowding, defective equipment, and failure to train staff. Waivers signed by parents on behalf of minor children are subject to legal challenge in both Georgia and South Carolina.',
            ),
            array(
                'question' => 'What are the most common amusement park injuries?',
                'answer'   => 'The most common injuries include broken bones, traumatic brain injuries, spinal cord injuries, soft tissue injuries (sprains and strains), lacerations, and drowning at water parks. Trampoline parks produce a disproportionate number of serious injuries, particularly spinal fractures and traumatic brain injuries.',
            ),
            array(
                'question' => 'What is the statute of limitations for an amusement park injury?',
                'answer'   => 'Georgia allows 2 years (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Claims against government-operated facilities may have shorter notice requirements. For injuries to minors, the statute may be tolled until the child reaches the age of majority — consult an attorney for details.',
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
