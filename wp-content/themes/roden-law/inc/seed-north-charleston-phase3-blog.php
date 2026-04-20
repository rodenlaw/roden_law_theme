<?php
/**
 * Seeder: North Charleston Phase 3 — Blog Posts
 *
 * Creates 5 blog posts:
 *   1. Pedestrian Safety in Park Circle: A Growing Concern
 *   2. Port Truck Accidents in Charleston: Who's Liable?
 *   3. Motorcycle Accidents on Dorchester Road: What the Data Shows
 *   4. Is North Charleston's Crime Rate Connected to Hit-and-Run Accidents?
 *   5. Understanding SC's 3-Year Statute of Limitations After a Crash
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-north-charleston-phase3-blog.php
 *
 * Idempotent — skips posts whose slugs already exist.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $graeham ? $graeham->ID : 0;

// Blog category
$blog_cat = term_exists( 'north-charleston', 'category' );
if ( ! $blog_cat ) {
    $blog_cat = wp_insert_term( 'North Charleston', 'category', array( 'slug' => 'north-charleston' ) );
}
$blog_cat_id = is_array( $blog_cat ) ? (int) $blog_cat['term_id'] : (int) $blog_cat;

$posts = array(

    /* ============================================================
       1. Pedestrian Safety in Park Circle
       ============================================================ */
    array(
        'title'   => 'Pedestrian Safety in Park Circle: A Growing Concern',
        'slug'    => 'pedestrian-safety-park-circle-north-charleston',
        'excerpt' => 'Park Circle is one of North Charleston\'s most walkable neighborhoods — but pedestrian crashes are rising as foot traffic outpaces infrastructure. Here\'s what you need to know about safety and your legal rights.',
        'tags'    => array( 'pedestrian accidents', 'Park Circle', 'North Charleston', 'walkability' ),
        'content' => <<<'HTML'
<p>Park Circle has transformed from a quiet North Charleston neighborhood into one of the Lowcountry's hottest destinations — craft breweries, restaurants, boutiques, and a thriving arts scene along East Montague Avenue. With growth comes foot traffic. And with foot traffic on streets that weren't designed for it comes danger.</p>

<h2>The Collision Between Walkability and Industrial Traffic</h2>
<p>Park Circle's walkability paradox: the neighborhood is pedestrian-friendly internally (sidewalks, tree-lined streets, the circle park itself), but it's bordered by roads that are actively hostile to people on foot:</p>
<ul>
<li><strong>Spruill Avenue</strong> runs directly through the district, carrying heavy industrial and truck traffic from the former Navy Yard and port-adjacent facilities</li>
<li><strong>East Montague Avenue's</strong> commercial growth has increased foot traffic, but crosswalks and pedestrian signals haven't kept pace</li>
<li><strong>The Virginia Avenue/Montague Avenue intersection</strong> is a documented high-collision spot where turning vehicles conflict with crosswalk traffic</li>
<li><strong>The Park Circle roundabout</strong> itself produces conflicts between vehicles unfamiliar with the yield pattern and pedestrians/cyclists</li>
</ul>

<h2>Who's Being Hit?</h2>
<p>Pedestrian crash victims in Park Circle tend to be:</p>
<ul>
<li><strong>Restaurant and bar patrons</strong> crossing East Montague or Montague Avenue after dark</li>
<li><strong>Cyclists</strong> using the neighborhood's bike lanes and encountering vehicles in conflict zones</li>
<li><strong>Workers</strong> walking from residential areas to jobs along Spruill Avenue and the industrial corridor</li>
<li><strong>Children and families</strong> using the park, playground, and neighborhood streets for recreation</li>
</ul>

<h2>What Needs to Change</h2>
<p>Traffic calming and pedestrian safety improvements that Park Circle needs:</p>
<ul>
<li>Protected pedestrian crossings at East Montague/Virginia Avenue and East Montague/Spruill Avenue</li>
<li>Speed reduction measures on Spruill Avenue through the commercial district</li>
<li>Dedicated bicycle infrastructure separated from vehicle lanes (not just painted lines)</li>
<li>Improved lighting at crosswalks, especially on the east side of the roundabout</li>
<li>Truck routing that diverts heavy industrial traffic away from the neighborhood's pedestrian core</li>
</ul>

<h2>Your Rights If You're Struck</h2>
<p>South Carolina law requires all drivers to exercise <strong>due care to avoid striking pedestrians</strong> (S.C. Code § 56-5-3230) — regardless of who has the technical right-of-way. If a driver hits you while you're in a crosswalk, you have a strong claim. Even outside a crosswalk, the driver may bear majority fault if they were speeding, distracted, or failed to keep a proper lookout.</p>

<p>Under South Carolina's comparative fault rule, you can recover damages as long as you were less than 51% at fault. The <strong>3-year statute of limitations</strong> (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>) applies.</p>

<h2>What to Do After Being Hit in Park Circle</h2>
<ol>
<li>Call 911 — get a police report documenting the crash</li>
<li>Get medical attention even if injuries seem minor</li>
<li>Photograph the crosswalk (or lack thereof), the vehicle, and your injuries</li>
<li>Get witness information from nearby restaurant/bar patrons or business owners</li>
<li>Contact Roden Law — our <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> is in Park Circle on Spruill Avenue. Call <a href="tel:+18436126561">(843) 612-6561</a>.</li>
</ol>
HTML,
    ),

    /* ============================================================
       2. Port Truck Accidents: Who's Liable?
       ============================================================ */
    array(
        'title'   => "Port Truck Accidents in Charleston: Who's Liable?",
        'slug'    => 'port-truck-accidents-charleston-liability',
        'excerpt' => 'Port of Charleston truck accidents involve multiple liable parties — the driver, trucking company, chassis leasing company, cargo shipper, and terminal operator. Here\'s how to determine who pays for your injuries.',
        'tags'    => array( 'truck accidents', 'Port of Charleston', 'North Charleston', 'I-26' ),
        'content' => <<<'HTML'
<p>The Port of Charleston moves over 2.7 million container units annually. Every one of those containers travels by truck at some point — primarily through North Charleston on I-26, I-526, and Rivers Avenue. When a port truck crashes into your vehicle, the question isn't just "who's at fault?" — it's "who are ALL the parties responsible?"</p>

<h2>Why Port Truck Claims Are Different</h2>
<p>A standard car accident involves one at-fault driver and their insurance company. A port truck crash can involve <strong>5-6 separate liable parties</strong>, each with their own insurance. This complexity works in your favor — more defendants means more insurance coverage available.</p>

<h2>The Chain of Liability</h2>

<h3>1. The Truck Driver</h3>
<p>The individual operating the vehicle. Many port truck drivers are owner-operators or work for small carriers. They may be fatigued (rushing to make port appointment windows), distracted (navigating to unfamiliar terminals), or operating unsafe equipment they're economically pressured not to reject.</p>

<h3>2. The Motor Carrier</h3>
<p>The trucking company whose operating authority the driver uses. They are responsible for hiring qualified drivers, ensuring compliance with hours-of-service rules, and maintaining vehicles. Under respondeat superior, the carrier is liable for the driver's negligence committed within the scope of employment.</p>

<h3>3. The Chassis Leasing Company</h3>
<p>This is unique to port trucking. Container chassis — the trailers that haul shipping containers — are often part of shared pools. They're leased, swapped between carriers daily, and maintenance is often deferred. When a chassis defect (bad brakes, bald tires, broken lights) causes a crash, the chassis owner/lessor bears liability.</p>

<h3>4. The Cargo Shipper/Loader</h3>
<p>If the container was overweight (exceeding the 80,000-pound gross vehicle weight limit) or improperly loaded (creating an unbalanced load that shifts), the entity that packed or loaded the container may be liable. Weight manifests and bill of lading data are critical evidence.</p>

<h3>5. The Port Terminal Operator</h3>
<p>SC Ports Authority or terminal operators may bear liability if dispatch procedures, loading operations, or terminal conditions contributed to the crash. For example, forcing a truck to depart with a known overweight container.</p>

<h3>6. The Freight Broker</h3>
<p>If a freight broker arranged the haul and hired an unqualified or underinsured carrier, they may be independently liable for negligent hiring.</p>

<h2>Common Port Truck Crash Scenarios</h2>
<ul>
<li><strong>I-526 merge crashes:</strong> Heavy container trucks merging at the Leeds Avenue interchange with insufficient acceleration</li>
<li><strong>I-26 rear-end crashes:</strong> Overweight trucks unable to stop in time during I-26 congestion near Ashley Phosphate</li>
<li><strong>Rivers Avenue rollovers:</strong> Top-heavy loaded containers on turns at the Rivers/I-526 interchange</li>
<li><strong>Chassis brake failure:</strong> Shared-pool chassis with worn brakes rear-ending passenger vehicles</li>
<li><strong>Tire blowouts:</strong> Retreaded tires (common on port trucks) failing at highway speed on I-26</li>
</ul>

<h2>Evidence That Makes or Breaks Your Case</h2>
<ul>
<li><strong>Bill of lading:</strong> Shows container weight and contents</li>
<li><strong>Chassis inspection records:</strong> Shows maintenance history (or lack thereof)</li>
<li><strong>Port appointment data:</strong> Shows time pressure the driver was under</li>
<li><strong>ELD/driver logs:</strong> Shows hours of service compliance</li>
<li><strong>USDOT/MC number:</strong> Identifies the motor carrier and their safety record</li>
</ul>

<h2>What You Should Do</h2>
<p>After any crash with a port truck:</p>
<ol>
<li>Photograph the <strong>USDOT number</strong> on the cab door and the <strong>container number</strong></li>
<li>Note whether the container appears loaded or empty (affects weight and handling)</li>
<li>Call an attorney within 24-48 hours — chassis inspection records and port data must be preserved immediately</li>
</ol>
<p>Roden Law handles port truck accident claims from our <a href="/locations/south-carolina/north-charleston/">North Charleston office</a>. Call <a href="tel:+18436126561">(843) 612-6561</a> for a free consultation.</p>
HTML,
    ),

    /* ============================================================
       3. Motorcycle Accidents on Dorchester Road
       ============================================================ */
    array(
        'title'   => 'Motorcycle Accidents on Dorchester Road: What the Data Shows',
        'slug'    => 'motorcycle-accidents-dorchester-road-data',
        'excerpt' => 'Dorchester Road in North Charleston has a documented history of fatal motorcycle crashes. Left-turning vehicles and heavy truck traffic make this corridor deadly for riders. Here\'s what the data shows.',
        'tags'    => array( 'motorcycle accidents', 'Dorchester Road', 'North Charleston' ),
        'content' => <<<'HTML'
<p>In March 2026, a motorcyclist was killed on Dorchester Road at the intersection with Forest Hills Drive — struck by a heavy-duty pickup truck. It wasn't the first fatal motorcycle crash on this corridor. It won't be the last.</p>

<p>Dorchester Road's combination of <strong>high speeds, heavy truck traffic, and unprotected left-turn intersections</strong> creates a recipe for deadly motorcycle collisions. Here's what the data and evidence tell us.</p>

<h2>Why Dorchester Road Kills Motorcyclists</h2>

<h3>The Left-Turn Problem</h3>
<p>Nationally, left-turning vehicles cause 42% of fatal motorcycle crashes (NHTSA data). On Dorchester Road, this statistic comes to life at every unprotected left-turn intersection:</p>
<ul>
<li>A car waits to turn left</li>
<li>The driver scans oncoming traffic but fails to register an approaching motorcycle (smaller visual profile = perceived as farther away)</li>
<li>The driver turns directly into the motorcycle's path</li>
<li>At 50 mph, the rider has less than 2 seconds to react</li>
</ul>
<p>The Forest Hills Drive intersection, Bacons Bridge Road, and the Ashley Phosphate junction all follow this deadly pattern.</p>

<h3>Heavy Truck Traffic</h3>
<p>Cement mixers, dump trucks, and construction vehicles share Dorchester Road with motorcycles. These vehicles create specific hazards:</p>
<ul>
<li><strong>Massive blind spots:</strong> A motorcycle is invisible in a truck's blind zone</li>
<li><strong>Air turbulence:</strong> Wind wash from large trucks can destabilize a motorcycle</li>
<li><strong>Debris:</strong> Gravel, concrete, and construction material falling from trucks</li>
<li><strong>Obscured sight lines:</strong> Trucks in turning lanes block left-turning drivers' view of approaching motorcycles</li>
</ul>

<h3>Speed</h3>
<p>Traffic on Dorchester Road regularly exceeds the 45-55 mph posted limits. Every additional mph reduces a rider's survival odds dramatically:</p>
<ul>
<li>At 30 mph impact: ~60% survival rate for a motorcycle crash</li>
<li>At 40 mph: ~40% survival rate</li>
<li>At 50 mph: ~20% survival rate</li>
</ul>

<h2>The Helmet Question</h2>
<p>South Carolina does not require adult riders to wear helmets. Legally, this means:</p>
<ul>
<li>Not wearing a helmet is <strong>not</strong> negligence per se (it's legal)</li>
<li>The defense may argue helmet non-use worsened <strong>head injuries specifically</strong></li>
<li>Comparative fault may reduce your recovery for head injuries — but does NOT bar your claim</li>
<li>An experienced attorney can argue that the crash itself (not helmet non-use) caused the fatality or life-threatening injury</li>
</ul>

<h2>What Families Should Know</h2>
<p>If your loved one was killed on Dorchester Road, South Carolina's <a href="/wrongful-death-lawyers/north-charleston-sc/">wrongful death law</a> allows surviving family members to recover:</p>
<ul>
<li>Funeral and burial expenses</li>
<li>Lost future income the deceased would have earned</li>
<li>Loss of companionship, guidance, and consortium</li>
<li>Pain and suffering the victim experienced before death</li>
<li>Punitive damages if the at-fault driver acted recklessly</li>
</ul>

<h2>What Needs to Change</h2>
<ul>
<li>Protected left-turn signals at Forest Hills Drive, Bacons Bridge Rd, and other high-crash intersections</li>
<li>Motorcycle awareness signage in high-conflict zones</li>
<li>Speed enforcement on the corridor</li>
<li>Truck route restrictions during peak motorcycle riding hours</li>
</ul>

<h2>Free Consultation</h2>
<p>Roden Law represents motorcyclists and their families after Dorchester Road crashes. Contact our <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> at <a href="tel:+18436126561">(843) 612-6561</a>.</p>
HTML,
    ),

    /* ============================================================
       4. Hit-and-Run and Crime Rate Connection
       ============================================================ */
    array(
        'title'   => "Is North Charleston's Crime Rate Connected to Hit-and-Run Accidents?",
        'slug'    => 'north-charleston-crime-rate-hit-and-run',
        'excerpt' => 'North Charleston has one of the highest crime rates in America — and a disproportionate number of hit-and-run crashes. Here\'s the connection and what your legal options are if a driver flees the scene after hitting you.',
        'tags'    => array( 'hit and run', 'North Charleston', 'uninsured motorist' ),
        'content' => <<<'HTML'
<p>North Charleston has a crime rate of 47 per 1,000 residents — one of the highest in America. While violent crime gets the headlines, there's a less-discussed connection: cities with elevated crime rates also tend to have higher rates of <strong>hit-and-run accidents</strong>. When drivers flee the scene, it's often because they are unlicensed, uninsured, impaired, or have outstanding warrants.</p>

<h2>The Hit-and-Run Problem</h2>
<p>Hit-and-run crashes disproportionately harm the most vulnerable road users:</p>
<ul>
<li><strong>Pedestrians:</strong> Cannot get a license plate number while lying injured on the road</li>
<li><strong>Cyclists:</strong> Often left in the roadway by drivers who flee without stopping</li>
<li><strong>Late-night crash victims:</strong> Fewer witnesses, harder to identify the vehicle</li>
</ul>
<p>The corridors with the most hit-and-run incidents in North Charleston mirror the most dangerous roads generally: Rivers Avenue, Ashley Phosphate Road, and I-26 service roads.</p>

<h2>Why Drivers Flee</h2>
<ul>
<li><strong>No insurance:</strong> South Carolina has an approximately 9% uninsured driver rate. Drivers without insurance flee to avoid financial liability.</li>
<li><strong>Suspended/revoked license:</strong> Driving without a valid license means any police contact results in arrest</li>
<li><strong>DUI/impairment:</strong> Intoxicated drivers flee to avoid DUI charges, which carry severe criminal penalties</li>
<li><strong>Outstanding warrants:</strong> Any police interaction triggers an arrest</li>
<li><strong>Stolen vehicle:</strong> The driver isn't the registered owner and cannot afford to be connected to the car</li>
</ul>

<h2>Your Legal Options After a Hit-and-Run</h2>

<h3>1. Uninsured Motorist (UM) Coverage</h3>
<p>Your own UM coverage is your primary safety net. In South Carolina, UM coverage applies to hit-and-run crashes where the at-fault driver cannot be identified. Key points:</p>
<ul>
<li>SC law requires insurers to offer UM coverage on every auto policy</li>
<li>UM coverage pays for medical expenses, lost wages, and pain and suffering — just like a claim against the at-fault driver's insurance</li>
<li>You must report the hit-and-run to police within a reasonable time</li>
<li>Your own insurer becomes the opposing party — they will try to minimize your claim just as an at-fault driver's insurer would</li>
</ul>

<h3>2. Identifying the Driver</h3>
<p>If the driver can be identified, you have a standard claim against their insurance (if any). Identification sources:</p>
<ul>
<li>Surveillance cameras (business security, traffic cameras, doorbell cameras)</li>
<li>Witness testimony (license plate, vehicle description)</li>
<li>Vehicle debris at the scene (may include parts with serial numbers)</li>
<li>Police investigation (paint transfer, parts matching)</li>
</ul>

<h3>3. Crime Victims' Compensation</h3>
<p>South Carolina's Crime Victims' Compensation Fund may provide supplemental benefits for hit-and-run victims, including medical expenses and lost wages not covered by insurance.</p>

<h2>What to Do Immediately After a Hit-and-Run</h2>
<ol>
<li><strong>Call 911 immediately</strong> — Report the hit-and-run. A timely police report is required for most UM claims.</li>
<li><strong>Note everything you can:</strong> Vehicle color, make, model, direction of travel, any partial plate numbers</li>
<li><strong>Look for cameras:</strong> Nearby businesses, traffic cameras, Ring doorbells. Note their locations for your attorney.</li>
<li><strong>Get witness contacts:</strong> Anyone who saw the vehicle before or after the crash</li>
<li><strong>Preserve evidence:</strong> Your damaged vehicle, clothing, and any debris left by the fleeing vehicle</li>
<li><strong>Contact an attorney:</strong> UM claims against your own insurer require the same aggressive advocacy as any other insurance claim</li>
</ol>

<h2>SC Hit-and-Run Criminal Penalties</h2>
<p>Leaving the scene of an accident involving injury is a felony in South Carolina (S.C. Code § 56-5-1210), carrying up to 25 years in prison if the crash resulted in death. This criminal liability is separate from your civil claim for damages.</p>

<h2>Filing Deadline</h2>
<p>You have <strong>3 years</strong> to file your injury claim (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). For UM claims, check your policy for notice requirements — some require notification within a specific timeframe. Contact Roden Law at <a href="tel:+18436126561">(843) 612-6561</a>.</p>
HTML,
    ),

    /* ============================================================
       5. SC's 3-Year Statute of Limitations
       ============================================================ */
    array(
        'title'   => "Understanding South Carolina's 3-Year Statute of Limitations After a Crash",
        'slug'    => 'south-carolina-statute-of-limitations-personal-injury',
        'excerpt' => 'South Carolina gives you 3 years to file a personal injury lawsuit — but waiting costs you evidence, witnesses, and leverage. Here\'s what every crash victim in SC needs to know about the filing deadline.',
        'tags'    => array( 'statute of limitations', 'South Carolina', 'personal injury law' ),
        'content' => <<<'HTML'
<p>After a car accident, truck crash, or any personal injury in South Carolina, you have a legal deadline to file your lawsuit. Miss it, and your claim is permanently barred — no matter how serious your injuries or how clear the other driver's fault. Here's what you need to know about South Carolina's statute of limitations.</p>

<h2>The Basic Rule: 3 Years</h2>
<p>Under <a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>, you have <strong>3 years from the date of your injury</strong> to file a personal injury lawsuit in South Carolina. This applies to:</p>
<ul>
<li>Car accidents</li>
<li>Truck accidents</li>
<li>Motorcycle crashes</li>
<li>Pedestrian and bicycle accidents</li>
<li>Slip and fall injuries</li>
<li>Dog bites</li>
<li>Medical malpractice (with specific rules)</li>
<li>Any other negligence-based injury claim</li>
</ul>

<h2>Exceptions: Shorter Deadlines</h2>
<p>Some claims have deadlines shorter than 3 years:</p>
<table>
<thead>
<tr><th>Claim Type</th><th>Deadline</th><th>Authority</th></tr>
</thead>
<tbody>
<tr><td>Government entity (Tort Claims Act)</td><td>Notice required; 2-year filing</td><td>S.C. Code § 15-78-80</td></tr>
<tr><td>Workers' compensation</td><td>2 years from injury</td><td>S.C. Code § 42-15-40</td></tr>
<tr><td>Longshore Act (federal)</td><td>1 year from injury</td><td>33 U.S.C. § 913</td></tr>
<tr><td>Wrongful death</td><td>3 years from death</td><td>S.C. Code § 15-3-530</td></tr>
<tr><td>Medical malpractice</td><td>3 years, but discovery rule applies</td><td>S.C. Code § 15-3-545</td></tr>
</tbody>
</table>

<h2>Why Waiting Hurts You (Even Within the Deadline)</h2>
<p>The statute of limitations is the <em>last</em> day you can file — not the ideal day. Every month you wait costs you:</p>

<h3>Evidence Degrades</h3>
<ul>
<li>Surveillance footage is overwritten (24-72 hours for many businesses)</li>
<li>Traffic camera data is purged (days to weeks)</li>
<li>Truck ELD data is overwritten (days without a preservation letter)</li>
<li>Vehicle damage is repaired or the car is scrapped</li>
<li>Road conditions change (potholes fixed, signs added, construction completed)</li>
</ul>

<h3>Witnesses Forget</h3>
<ul>
<li>Memories fade within weeks — details become unreliable after months</li>
<li>Witnesses move, change phone numbers, or become unreachable</li>
<li>Police officers who responded may transfer or retire</li>
</ul>

<h3>Insurance Companies Notice</h3>
<ul>
<li>A delay in hiring an attorney signals to insurers that you're not serious</li>
<li>Gaps between the accident and medical treatment suggest injuries aren't severe</li>
<li>Insurers lowball victims who haven't retained counsel, knowing they're less likely to sue</li>
</ul>

<h2>The Discovery Rule</h2>
<p>In rare cases, the statute of limitations may be extended if the injured person did not know (and could not reasonably have known) about the injury at the time it occurred. This "discovery rule" most commonly applies to:</p>
<ul>
<li>Medical malpractice (delayed diagnosis)</li>
<li>Toxic exposure with latent symptoms</li>
<li>Defective products causing gradual harm</li>
</ul>
<p>For car accidents and most injury cases, the discovery rule does NOT apply — you know you're injured on the day of the crash.</p>

<h2>Tolling: When the Clock Pauses</h2>
<p>The statute of limitations may be "tolled" (paused) in specific circumstances:</p>
<ul>
<li><strong>Minor plaintiff:</strong> If the injured person is under 18, the clock doesn't start until they turn 18</li>
<li><strong>Defendant absent from state:</strong> If the at-fault party leaves South Carolina, time may toll during their absence</li>
<li><strong>Mental incapacity:</strong> If the injury rendered the plaintiff mentally incapacitated</li>
</ul>

<h2>What "Filing" Means</h2>
<p>The statute requires that your <strong>lawsuit be filed with the court</strong> — not that settlement negotiations be ongoing, not that you've hired an attorney, not that you've sent a demand letter. The Summons and Complaint must be filed with the Clerk of Court before the 3-year anniversary of your injury.</p>

<h2>Don't Wait</h2>
<p>Contact an attorney as soon as possible after your injury — ideally within days or weeks, not months or years. Early consultation costs nothing (Roden Law offers free case evaluations) and allows your attorney to:</p>
<ul>
<li>Send evidence preservation letters immediately</li>
<li>Obtain surveillance footage before it's overwritten</li>
<li>Interview witnesses while memories are fresh</li>
<li>Begin medical documentation from the start</li>
<li>Put the insurance company on notice that you're represented</li>
</ul>
<p>Call Roden Law's <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> at <a href="tel:+18436126561">(843) 612-6561</a>.</p>
HTML,
    ),
);

/* ------------------------------------------------------------------
   Create posts
   ------------------------------------------------------------------ */

$created = 0;
$skipped = 0;

foreach ( $posts as $p ) {
    $existing = get_page_by_path( $p['slug'], OBJECT, 'post' );
    if ( $existing ) {
        WP_CLI::log( "SKIP: \"{$p['title']}\" already exists (ID {$existing->ID})" );
        $skipped++;
        continue;
    }

    $post_id = wp_insert_post( array(
        'post_type'    => 'post',
        'post_title'   => $p['title'],
        'post_name'    => $p['slug'],
        'post_status'  => 'publish',
        'post_content' => $p['content'],
        'post_excerpt' => $p['excerpt'],
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "FAILED: \"{$p['title']}\" — " . $post_id->get_error_message() );
        continue;
    }

    update_post_meta( $post_id, '_roden_author_attorney', $author_id );
    update_post_meta( $post_id, '_roden_jurisdiction', 'sc' );

    wp_set_post_categories( $post_id, array( $blog_cat_id ) );

    if ( ! empty( $p['tags'] ) ) {
        wp_set_post_tags( $post_id, $p['tags'] );
    }

    WP_CLI::success( "CREATED: \"{$p['title']}\" (ID {$post_id}) → /blog/{$p['slug']}/" );
    $created++;
}

WP_CLI::log( '' );
WP_CLI::log( "Done. Created: {$created} | Skipped: {$skipped}" );
