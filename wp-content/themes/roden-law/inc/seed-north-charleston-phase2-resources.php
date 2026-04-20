<?php
/**
 * Seeder: North Charleston Phase 2 — Resource Pages
 *
 * Creates 3 resource posts:
 *   1. North Charleston Truck Accident Guide: I-26 & Rivers Ave Corridor
 *   2. Workers' Comp for North Charleston Warehouse & Port Workers
 *   3. Rideshare Accident Claims in North Charleston: Uber & Lyft Guide
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-north-charleston-phase2-resources.php
 *
 * Idempotent — skips any post whose slug already exists.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Author attribution
   ------------------------------------------------------------------ */

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $graeham ? $graeham->ID : 0;
WP_CLI::log( $author_id ? "Author: Graeham C. Gillin (ID {$author_id})" : 'WARNING: Attorney not found.' );

/* ------------------------------------------------------------------
   Taxonomy terms
   ------------------------------------------------------------------ */

$terms = array();
$term_defs = array(
    'truck-accidents'      => 'Truck Accidents',
    'workers-compensation' => "Workers' Compensation",
    'car-accidents'        => 'Car Accidents',
);
foreach ( $term_defs as $slug => $name ) {
    $t = term_exists( $slug, 'practice_category' );
    if ( ! $t ) {
        $t = wp_insert_term( $name, 'practice_category', array( 'slug' => $slug ) );
    }
    $terms[ $slug ] = is_array( $t ) ? (int) $t['term_id'] : (int) $t;
}

/* ------------------------------------------------------------------
   Resource definitions
   ------------------------------------------------------------------ */

$resources = array(

    /* ============================================================
       1. North Charleston Truck Accident Guide
       ============================================================ */
    array(
        'title'      => 'North Charleston Truck Accident Guide: I-26 & Rivers Avenue Corridor',
        'slug'       => 'north-charleston-truck-accident-guide',
        'excerpt'    => 'Complete guide to truck accident claims in North Charleston, SC. Covers I-26 and Rivers Avenue corridor hazards, FMCSA regulations, port truck traffic, evidence preservation, and your legal rights under South Carolina law.',
        'categories' => array( 'truck-accidents' ),
        'content'    => <<<'HTML'
<h2>Truck Accidents in North Charleston: What You Need to Know</h2>
<p>North Charleston sits at the convergence of two major freight-generating forces: the <strong>Port of Charleston</strong> (one of the East Coast's busiest container ports) and <strong>Boeing South Carolina</strong> (assembling 787 Dreamliners in a 1.2-million-square-foot facility). The result is extraordinary commercial truck density on I-26, I-526, and Rivers Avenue — and a correspondingly high rate of serious truck crashes.</p>
<p>This guide covers everything you need to know about truck accident claims in the North Charleston area: why they happen, what makes them different from car accidents, your legal rights, and how to protect your claim.</p>

<h2>North Charleston Truck Accident Statistics</h2>
<ul>
<li>The <strong>I-26/I-526 interchange</strong> recorded 354 collisions in a 5-year period, many involving commercial trucks</li>
<li>The <strong>Rivers Avenue/I-526 interchange</strong> produced 62 injuries over the same period — truck traffic is a primary factor</li>
<li>A <strong>tractor-trailer struck the I-526 overhead sign</strong> near Rivers Avenue in February 2026, then hit the Eagle Drive overpass on I-26</li>
<li>A <strong>concrete truck drove off the I-26 overpass</strong> near Dorchester Road</li>
<li>A <strong>cement truck overturned on Rivers Avenue</strong> in March 2025, shutting down lanes</li>
<li>Semi-truck collisions have simultaneously disrupted traffic on both I-26 and I-526</li>
</ul>

<h2>Types of Truck Accidents on North Charleston Roads</h2>

<h3>Jackknife Crashes</h3>
<p>When a truck's trailer swings out to form a 90-degree angle with the cab — often triggered by hard braking on wet pavement or during sudden traffic stops on I-26. A jackknifed trailer sweeps across multiple lanes, striking vehicles alongside and ahead.</p>

<h3>Rollovers</h3>
<p>Top-heavy trucks (cement mixers, tankers, loaded container trucks) overturn on curves, during abrupt lane changes, or when loads shift. Rivers Avenue and the I-526 ramps are common rollover locations due to their turn geometry.</p>

<h3>Rear-End Crashes</h3>
<p>An 80,000-pound truck needs 500+ feet to stop from 60 mph. In I-26 congestion — especially near the Ashley Phosphate interchange where traffic stops suddenly — trucks frequently cannot stop in time. The mass difference makes these crashes catastrophic for the passenger vehicle ahead.</p>

<h3>Underride Crashes</h3>
<p>When a passenger vehicle slides under the rear or side of a trailer. These crashes often cause decapitation or crush injuries because the trailer height bypasses the car's crumple zones entirely. Inadequate underride guards are a known safety deficiency in older trailers.</p>

<h3>Tire Blowouts and Debris</h3>
<p>Truck tire failures send debris across lanes at highway speed and can cause the driver to lose control. Retreaded tires (common on port trucks) have higher failure rates.</p>

<h2>Why Truck Accident Cases Are Different</h2>

<h3>1. Federal Regulations Apply</h3>
<p>Commercial trucks are governed by <a href="https://www.fmcsa.dot.gov/" target="_blank" rel="noopener">FMCSA regulations</a> covering:</p>
<ul>
<li><strong>Hours of Service:</strong> Maximum 11 hours driving in a 14-hour window after 10 hours off</li>
<li><strong>Electronic Logging Devices:</strong> Required digital recording of driving hours</li>
<li><strong>Drug and alcohol testing:</strong> Pre-employment, random, post-accident, and reasonable suspicion testing</li>
<li><strong>Vehicle maintenance:</strong> Pre-trip inspections, systematic maintenance plans, brake adjustment standards</li>
<li><strong>Cargo securement:</strong> Weight limits, tie-down requirements, and load distribution rules</li>
<li><strong>Driver qualification:</strong> CDL requirements, medical certification, and background checks</li>
</ul>
<p>Violations of any FMCSA regulation constitute evidence of negligence — and potentially support punitive damages if the violation was knowing and willful.</p>

<h3>2. Multiple Liable Parties</h3>
<p>A single truck crash may create claims against 4-6 defendants:</p>
<table>
<thead>
<tr><th>Party</th><th>Potential Liability</th></tr>
</thead>
<tbody>
<tr><td>Truck driver</td><td>Negligence, fatigue, distraction, DUI</td></tr>
<tr><td>Trucking company</td><td>Negligent hiring, HOS pressure, maintenance failures</td></tr>
<tr><td>Cargo shipper/loader</td><td>Overweight, improperly secured, or hazardous cargo</td></tr>
<tr><td>Truck/parts manufacturer</td><td>Defective brakes, tires, steering, coupling</td></tr>
<tr><td>Maintenance provider</td><td>Negligent inspection or repair</td></tr>
<tr><td>Chassis leasing company</td><td>Defective leased equipment (common for port trucks)</td></tr>
</tbody>
</table>

<h3>3. Evidence Disappears Quickly</h3>
<p>Critical truck accident evidence has a short shelf life:</p>
<ul>
<li><strong>ELD data:</strong> Overwritten within days unless preserved</li>
<li><strong>Dash cam footage:</strong> Typically recorded on 24-72 hour loops</li>
<li><strong>Drug/alcohol tests:</strong> Must be administered within hours per FMCSA rules (post-accident testing is required for certain crashes)</li>
<li><strong>Vehicle inspection records:</strong> May be altered or "lost"</li>
<li><strong>Dispatch communications:</strong> Text messages and dispatch orders showing schedule pressure</li>
</ul>
<p><strong>This is why you need a lawyer immediately.</strong> Roden Law sends spoliation preservation letters within hours of engagement, legally requiring the trucking company to preserve all evidence.</p>

<h3>4. Higher Insurance Limits</h3>
<p>Federal law requires commercial trucks to carry minimum insurance of $750,000 to $5,000,000 depending on cargo type. This means more coverage is available — but it also means insurance companies deploy aggressive defense teams. You need experienced counsel.</p>

<h2>Steps After a Truck Accident in North Charleston</h2>
<ol>
<li><strong>Get to safety and call 911</strong> — Highway patrol will respond to I-26/I-526 crashes. Request medical assistance.</li>
<li><strong>Do not exit into travel lanes</strong> — Secondary crashes from following traffic are a leading cause of death at truck crash scenes.</li>
<li><strong>Document everything:</strong> Truck company name, USDOT number (on cab door), trailer number, driver info, damage photos, mile markers.</li>
<li><strong>Note the cargo:</strong> What was the truck carrying? Containers (port truck)? Concrete? Fuel? This identifies the liable parties.</li>
<li><strong>Get medical attention immediately</strong> — Trident Medical Center is the closest facility for most I-26/Rivers Ave crashes.</li>
<li><strong>Contact a truck accident attorney</strong> — Do this within 24-48 hours. Evidence preservation cannot wait.</li>
</ol>

<h2>South Carolina Law</h2>
<ul>
<li><strong>Statute of limitations:</strong> 3 years from injury (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>)</li>
<li><strong>Comparative fault:</strong> Recovery allowed if less than 51% at fault</li>
<li><strong>Punitive damages:</strong> Available if the trucking company or driver acted with willful disregard for safety (e.g., knowingly allowing a fatigued driver to operate, falsifying logs)</li>
</ul>

<h2>Free Consultation</h2>
<p>Roden Law's North Charleston office handles truck accident cases on contingency — no fees unless we recover compensation. Call <a href="tel:+18436126561">(843) 612-6561</a> or visit us on Spruill Avenue in Park Circle. We respond to truck accident consultations within 24 hours and begin evidence preservation immediately.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'How is a truck accident case different from a regular car accident case?',
                'answer'   => 'Truck cases involve federal FMCSA regulations (hours of service, maintenance, cargo rules), multiple liable parties (driver, trucking company, manufacturer, cargo shipper), higher insurance limits ($750K-$5M), and rapidly disappearing evidence (ELD data, dash cams). They require immediate legal action to preserve evidence and identify all responsible parties.',
            ),
            array(
                'question' => 'What should I look for at a truck accident scene?',
                'answer'   => 'Document the trucking company name and USDOT number (displayed on the cab door), the trailer number, the type of cargo, the driver\'s CDL and insurance information, and all vehicle damage. Photograph mile markers, road conditions, and any visible defects on the truck (bald tires, broken lights, fluid leaks).',
            ),
            array(
                'question' => 'How quickly do I need to contact a lawyer after a truck accident?',
                'answer'   => 'Within 24-48 hours is ideal. ELD driving data may be overwritten within days, dash cam footage operates on short recording loops, and post-accident drug/alcohol testing must occur within hours. A lawyer\'s first action is sending a spoliation letter requiring the trucking company to preserve all evidence.',
            ),
            array(
                'question' => 'Can I get punitive damages in a truck accident case?',
                'answer'   => 'Yes, if the trucking company or driver acted with willful or reckless disregard for safety — such as knowingly allowing a fatigued driver to operate, falsifying driving logs, ignoring known vehicle defects, or pressuring drivers to exceed hours-of-service limits. Punitive damages are meant to punish egregious behavior and can significantly increase your recovery.',
            ),
        ),
    ),

    /* ============================================================
       2. Workers' Comp for Warehouse & Port Workers
       ============================================================ */
    array(
        'title'      => "Workers' Comp for North Charleston Warehouse & Port Workers",
        'slug'       => 'workers-comp-north-charleston-warehouse-port',
        'excerpt'    => "Complete guide to workers' compensation for warehouse and port workers in North Charleston, SC. Covers state vs. federal (Longshore Act) claims, third-party lawsuits, common injuries, and filing deadlines.",
        'categories' => array( 'workers-compensation' ),
        'content'    => <<<'HTML'
<h2>Workers' Compensation for Warehouse &amp; Port Workers in North Charleston</h2>
<p>North Charleston is the hub of Charleston's logistics economy — from the Port of Charleston's container terminals to the distribution warehouses lining I-26 and Rivers Avenue. If you work in warehousing, logistics, or port operations, your job is among the most physically dangerous in the Lowcountry. The Bureau of Labor Statistics reports that warehouse workers are injured at nearly <strong>double the rate</strong> of the average American worker.</p>
<p>This guide explains your workers' compensation rights, how to determine whether state or federal law covers your injury, and when you may have additional third-party claims worth significantly more than workers' comp alone.</p>

<h2>State Workers' Comp vs. Federal Longshore Act</h2>
<p>The first question for any port-area worker is: <strong>which law covers me?</strong></p>

<h3>South Carolina Workers' Compensation</h3>
<p>Covers most workers in South Carolina, including:</p>
<ul>
<li>Inland warehouse workers</li>
<li>Distribution center employees</li>
<li>Truck drivers (non-maritime)</li>
<li>Fulfillment center workers</li>
<li>Cold storage facility employees</li>
<li>Port administrative and security staff</li>
</ul>
<p><strong>Benefits:</strong> 66.67% of average weekly wage (AWW), medical expenses, permanent disability ratings.</p>
<p><strong>Deadlines:</strong> Report to employer within 90 days. File claim within 2 years.</p>

<h3>Longshore and Harbor Workers' Compensation Act (LHWCA)</h3>
<p>Federal law covering workers engaged in maritime employment on or adjacent to navigable waters:</p>
<ul>
<li>Longshoremen loading/unloading vessels</li>
<li>Crane operators on the wharf</li>
<li>Ship repair workers</li>
<li>Container terminal workers at waterfront facilities</li>
<li>Marine terminal equipment operators</li>
</ul>
<p><strong>Benefits:</strong> 66.67% of AWW with higher maximum rates than SC, full medical coverage with no time limit, vocational rehabilitation.</p>
<p><strong>Deadlines:</strong> Notice to employer within 30 days. File claim within <strong>1 year</strong> — significantly shorter than state law.</p>

<h2>What Workers' Comp Covers</h2>
<ul>
<li><strong>Medical treatment:</strong> All reasonable and necessary medical care related to your work injury — doctors, surgery, physical therapy, medications, medical devices</li>
<li><strong>Temporary total disability:</strong> Wage replacement while you cannot work (66.67% of AWW in SC)</li>
<li><strong>Temporary partial disability:</strong> Supplemental pay if you return to work at reduced capacity/pay</li>
<li><strong>Permanent partial disability:</strong> Compensation for lasting impairment after maximum medical improvement</li>
<li><strong>Permanent total disability:</strong> Lifetime benefits if you can never return to gainful employment</li>
<li><strong>Death benefits:</strong> Funeral expenses and survivor benefits for families of workers killed on the job</li>
</ul>

<h2>What Workers' Comp Does NOT Cover</h2>
<ul>
<li>Pain and suffering</li>
<li>Emotional distress</li>
<li>Full lost wages (only 66.67%)</li>
<li>Punitive damages</li>
<li>Loss of enjoyment of life</li>
</ul>
<p><strong>This is why third-party claims matter.</strong> If someone other than your direct employer contributed to your injury, a separate personal injury lawsuit can recover these additional damages.</p>

<h2>Third-Party Claims: When You Can Sue for More</h2>
<p>Common third-party defendants for warehouse and port workers:</p>
<table>
<thead>
<tr><th>Third Party</th><th>Scenario</th></tr>
</thead>
<tbody>
<tr><td>Forklift manufacturer</td><td>Defective brakes, mast failure, or stability defect caused your injury</td></tr>
<tr><td>Racking/shelving company</td><td>Improperly installed or under-rated racking collapsed</td></tr>
<tr><td>Property owner/landlord</td><td>Building defects: collapsed floor, inadequate drainage, broken dock leveler</td></tr>
<tr><td>Truck driver (external)</td><td>Delivery truck pulled away from dock while you were inside trailer</td></tr>
<tr><td>Chemical manufacturer</td><td>Toxic exposure from improperly labeled containers or fumigated goods</td></tr>
<tr><td>Equipment maintenance company</td><td>Negligent repair of forklift, conveyor, or crane</td></tr>
<tr><td>Vessel owner (LHWCA)</td><td>Unsafe vessel conditions injured you during loading/unloading</td></tr>
</tbody>
</table>

<h2>Common Warehouse &amp; Port Injuries</h2>
<ul>
<li><strong>Back injuries:</strong> Herniated discs, muscle strains, and spinal fractures from repetitive lifting, falls, and crush incidents</li>
<li><strong>Crush injuries:</strong> Being caught between containers, struck by forklifts, or pinned by collapsing racking</li>
<li><strong>Falls:</strong> Loading dock falls (4-5 feet to concrete), falls from container stacks, and same-level falls on slippery surfaces</li>
<li><strong>Amputations:</strong> Caught-in conveyor belts, caught-between equipment, and unguarded machinery</li>
<li><strong>Traumatic brain injuries:</strong> Struck by falling objects from racking or container stacks</li>
<li><strong>Heat stroke:</strong> Non-climate-controlled warehouses exceeding 100°F in SC summers</li>
<li><strong>Repetitive strain:</strong> Carpal tunnel, rotator cuff tears, and tendinitis from constant lifting, scanning, and reaching</li>
</ul>

<h2>5 Steps to Protect Your Claim</h2>
<ol>
<li><strong>Report immediately:</strong> Tell your supervisor about any injury the same day it occurs. Under SC law, you have 90 days — but delays create suspicion and weaken your claim.</li>
<li><strong>Get medical treatment:</strong> Go to the authorized doctor if your employer directs one; if not, choose your own. Document everything.</li>
<li><strong>Document the hazard:</strong> Photograph the condition that caused your injury — wet floor, broken equipment, collapsed racking, overloaded pallet.</li>
<li><strong>Keep records:</strong> Save copies of incident reports, medical records, wage stubs, and any communication with your employer about the injury.</li>
<li><strong>Consult an attorney:</strong> Especially if your employer disputes the claim, directs you to a company doctor who minimizes your injuries, or if a third party may be liable.</li>
</ol>

<h2>Filing Deadlines Summary</h2>
<table>
<thead>
<tr><th>Claim Type</th><th>Notice</th><th>Filing Deadline</th></tr>
</thead>
<tbody>
<tr><td>SC Workers' Comp</td><td>90 days</td><td>2 years from injury</td></tr>
<tr><td>LHWCA (Federal)</td><td>30 days</td><td>1 year from injury</td></tr>
<tr><td>Third-party lawsuit</td><td>N/A</td><td>3 years from injury</td></tr>
</tbody>
</table>

<h2>Free Consultation</h2>
<p>Roden Law's <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> represents warehouse and port workers in both workers' comp and third-party injury claims. We evaluate your case for free and work on contingency — no fees unless we recover compensation. Call <a href="tel:+18436126561">(843) 612-6561</a>.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'How do I know if I\'m covered by state workers\' comp or the federal Longshore Act?',
                'answer'   => 'It depends on your job duties and work location. If you perform maritime work (loading/unloading vessels, crane operation, ship repair) on or adjacent to navigable waters, the federal Longshore Act likely applies. If you work in an inland warehouse, distribution center, or non-maritime port facility, South Carolina state workers\' comp applies. An attorney can make this determination based on your specific role.',
            ),
            array(
                'question' => 'Can I get fired for filing a workers\' comp claim?',
                'answer'   => 'South Carolina law prohibits retaliation against employees who file legitimate workers\' compensation claims. If you are terminated, demoted, or otherwise punished after reporting an injury or filing a claim, you may have a separate retaliation claim. Document all adverse employment actions that occur after your injury report.',
            ),
            array(
                'question' => 'What if my employer says my injury isn\'t work-related?',
                'answer'   => 'Employers and their insurance carriers frequently dispute whether injuries are work-related — especially for back injuries, repetitive strain, and conditions with gradual onset. Medical documentation establishing a link between your job duties and your condition is critical. An attorney can help obtain medical opinions supporting causation and challenge improper denials.',
            ),
            array(
                'question' => 'Is workers\' comp the only money I can get for a warehouse injury?',
                'answer'   => 'No. If a third party (not your direct employer) contributed to your injury — such as a forklift manufacturer, property owner, equipment maintenance company, or truck driver — you may file a separate personal injury lawsuit for full damages including pain and suffering. This third-party claim is in addition to your workers\' comp benefits.',
            ),
        ),
    ),

    /* ============================================================
       3. Rideshare Accident Claims Guide
       ============================================================ */
    array(
        'title'      => 'Rideshare Accident Claims in North Charleston: Uber & Lyft Guide',
        'slug'       => 'rideshare-accident-north-charleston',
        'excerpt'    => 'Guide to Uber and Lyft accident claims in North Charleston, SC. Explains the 3-phase insurance system, how to determine coverage, what to do after a rideshare crash, and your rights under South Carolina law.',
        'categories' => array( 'car-accidents' ),
        'content'    => <<<'HTML'
<h2>Rideshare Accident Claims in North Charleston</h2>
<p>Uber and Lyft have become integral to North Charleston's transportation landscape — from airport runs on International Boulevard to late-night rides from Park Circle restaurants to commuter trips avoiding I-26 congestion. But rideshare accidents create insurance nightmares that standard car accident claims don't. Multiple insurers, disputed coverage phases, and corporate legal teams make these cases complex.</p>
<p>This guide explains exactly how rideshare insurance works, what to do after an accident, and how to ensure you receive full compensation.</p>

<h2>The Three-Phase Insurance System</h2>
<p>Uber and Lyft don't provide consistent coverage. The insurance that applies to your crash depends entirely on what the driver was doing at the moment of impact:</p>

<table>
<thead>
<tr><th>Phase</th><th>Driver Status</th><th>Coverage Available</th></tr>
</thead>
<tbody>
<tr><td><strong>Phase 1</strong></td><td>App on, waiting for ride request</td><td>$50K per person / $100K per accident / $25K property</td></tr>
<tr><td><strong>Phase 2</strong></td><td>Ride accepted, driving to pickup</td><td><strong>$1,000,000</strong> liability + UM/UIM + contingent comp/collision</td></tr>
<tr><td><strong>Phase 3</strong></td><td>Passenger in vehicle</td><td><strong>$1,000,000</strong> liability + UM/UIM + contingent comp/collision</td></tr>
<tr><td>Off-app</td><td>Not logged into rideshare app</td><td>Driver's personal auto policy only</td></tr>
</tbody>
</table>

<h3>The Phase 1 Coverage Gap</h3>
<p>Phase 1 is where most disputes occur. The driver's personal auto insurance typically excludes commercial activity (driving for hire). Uber/Lyft's Phase 1 coverage is minimal ($50K/$100K). If the crash is serious, this coverage may be inadequate — and both insurers will try to shift responsibility to the other. This gap requires aggressive legal advocacy to resolve.</p>

<h2>Who Can File a Rideshare Accident Claim?</h2>

<h3>Rideshare Passengers</h3>
<p>As a passenger, you're in the strongest legal position — you cannot be at fault for the crash. If the rideshare driver was negligent, Uber/Lyft's $1 million policy (Phase 3) covers your injuries. If another driver caused the crash, you file against that driver's insurance, with Uber/Lyft's UM/UIM as backup.</p>

<h3>Other Drivers Hit by a Rideshare Vehicle</h3>
<p>If an Uber or Lyft driver caused your accident, you file against the rideshare company's commercial policy. The coverage level depends on the driver's phase at the time of impact. Your attorney must subpoena trip data to prove what phase applied.</p>

<h3>Pedestrians and Cyclists</h3>
<p>If struck by a rideshare vehicle, you file against the driver and the applicable Uber/Lyft policy. North Charleston's high-activity rideshare areas — Park Circle, Rivers Avenue shopping corridors, and the airport vicinity — see frequent pedestrian exposure to rideshare vehicles making pickups and drop-offs.</p>

<h2>Common Rideshare Crash Causes in North Charleston</h2>
<ul>
<li><strong>Distracted driving:</strong> Checking the app for requests, reading navigation, communicating with passengers — rideshare drivers are constantly interacting with their phones</li>
<li><strong>Sudden stops and U-turns:</strong> Drivers stopping in travel lanes for pickups on Rivers Avenue, Ashley Phosphate Road, and Dorchester Road</li>
<li><strong>Double-parking:</strong> Blocking lanes near restaurants, bars, and hotels while waiting for passengers</li>
<li><strong>Unfamiliarity with area:</strong> Following GPS into wrong turns, erratic navigation near the I-26 interchange</li>
<li><strong>Fatigue:</strong> Drivers working 10-14 hour shifts to maximize earnings, especially during surge pricing events</li>
<li><strong>Airport corridor activity:</strong> High rideshare density on International Boulevard creates congestion and conflict</li>
</ul>

<h2>What to Do After a Rideshare Accident</h2>
<ol>
<li><strong>Call 911</strong> — Get a police report regardless of severity</li>
<li><strong>Screenshot your ride</strong> — If you were a passenger, screenshot the trip screen showing driver name, license plate, and trip status before closing the app</li>
<li><strong>Document the driver's app status</strong> — Ask the driver if they were on a ride, heading to pickup, or just driving. Note whether a passenger was in the vehicle.</li>
<li><strong>Photograph everything</strong> — Vehicle damage, the rideshare Trade Dress (Uber/Lyft sticker), injuries, and the scene</li>
<li><strong>Report through the app</strong> — Report the accident through Uber/Lyft's in-app safety feature. This creates a record of the trip status.</li>
<li><strong>See a doctor within 24 hours</strong></li>
<li><strong>Contact an attorney</strong> — Rideshare insurance disputes require legal experience. Do not accept a quick settlement from Uber/Lyft's insurer.</li>
</ol>

<h2>The Uber/Lyft Defense Playbook</h2>
<p>Rideshare companies use specific strategies to minimize payouts:</p>
<ul>
<li><strong>"The driver was not on a trip"</strong> — Denying the driver was in Phase 2 or 3, shifting you to the minimal Phase 1 policy or the driver's personal insurance</li>
<li><strong>"Independent contractor, not employee"</strong> — Arguing the company has no direct liability for the driver's actions</li>
<li><strong>Arbitration clauses</strong> — Riders who agreed to Uber/Lyft's terms of service may be forced into arbitration rather than court</li>
<li><strong>Quick lowball offers</strong> — Offering a few thousand dollars before you understand your injury's full extent</li>
</ul>

<h2>South Carolina Law</h2>
<p>South Carolina's TNC (Transportation Network Company) Act requires Uber and Lyft to maintain the tiered insurance described above. Additional protections:</p>
<ul>
<li><strong>3-year statute of limitations</strong> (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>)</li>
<li><strong>Comparative fault:</strong> Recovery if less than 51% at fault</li>
<li><strong>UM/UIM stacking:</strong> SC allows stacking of uninsured motorist coverage across multiple policies in some cases</li>
</ul>

<h2>Free Consultation</h2>
<p>Roden Law's <a href="/locations/south-carolina/north-charleston/">North Charleston attorneys</a> handle rideshare accident claims against Uber, Lyft, and their insurance carriers. We subpoena trip data, determine the applicable coverage phase, and fight for full compensation. Call <a href="tel:+18436126561">(843) 612-6561</a> — free consultation, no fees unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Does Uber or Lyft pay for my injuries if their driver caused the accident?',
                'answer'   => 'Yes — if the driver was in Phase 2 (en route to pickup) or Phase 3 (passenger in vehicle), Uber/Lyft carries $1 million in liability coverage. If the driver was only in Phase 1 (app on, no ride accepted), coverage drops to $50,000/$100,000. The key is proving the driver\'s exact status at the time of the crash, which requires subpoenaing trip data from the company.',
            ),
            array(
                'question' => 'What if I was a passenger in the Uber/Lyft when the crash happened?',
                'answer'   => 'You are in the strongest legal position. As a passenger, you cannot be at fault. If the rideshare driver caused the crash, Uber/Lyft\'s $1 million Phase 3 policy covers you. If another driver caused it, you claim against that driver\'s insurance, with Uber/Lyft\'s $1 million UM/UIM coverage as backup if the other driver is uninsured.',
            ),
            array(
                'question' => 'Can Uber/Lyft force me into arbitration?',
                'answer'   => 'If you\'re a rider who agreed to Uber/Lyft\'s terms of service, you may be subject to an arbitration clause. However, arbitration clauses typically don\'t bind third parties (other drivers hit by rideshare vehicles, pedestrians). Even for riders, arbitration clauses can sometimes be challenged. An attorney can evaluate whether arbitration applies to your specific claim.',
            ),
        ),
    ),
);

/* ------------------------------------------------------------------
   Create posts
   ------------------------------------------------------------------ */

$created = 0;
$skipped = 0;

foreach ( $resources as $r ) {
    $existing = get_page_by_path( $r['slug'], OBJECT, 'resource' );
    if ( $existing ) {
        WP_CLI::log( "SKIP: \"{$r['title']}\" already exists (ID {$existing->ID})" );
        $skipped++;
        continue;
    }

    $post_id = wp_insert_post( array(
        'post_type'    => 'resource',
        'post_title'   => $r['title'],
        'post_name'    => $r['slug'],
        'post_status'  => 'publish',
        'post_content' => $r['content'],
        'post_excerpt' => $r['excerpt'],
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "FAILED: \"{$r['title']}\" — " . $post_id->get_error_message() );
        continue;
    }

    update_post_meta( $post_id, '_roden_author_attorney', $author_id );
    update_post_meta( $post_id, '_roden_jurisdiction', 'sc' );

    if ( ! empty( $r['faqs'] ) ) {
        update_post_meta( $post_id, '_roden_faqs', $r['faqs'] );
    }

    if ( ! empty( $r['categories'] ) ) {
        $term_ids = array_map( function( $slug ) use ( $terms ) {
            return $terms[ $slug ] ?? 0;
        }, $r['categories'] );
        $term_ids = array_filter( $term_ids );
        if ( $term_ids ) {
            wp_set_object_terms( $post_id, $term_ids, 'practice_category' );
        }
    }

    WP_CLI::success( "CREATED: \"{$r['title']}\" (ID {$post_id}) → /resources/{$r['slug']}/" );
    $created++;
}

WP_CLI::log( '' );
WP_CLI::log( "Done. Created: {$created} | Skipped: {$skipped}" );
