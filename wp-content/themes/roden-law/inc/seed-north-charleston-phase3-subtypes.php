<?php
/**
 * Seeder: North Charleston Phase 3 — Sub-Type Pages
 *
 * Creates 5 sub-type pages across 4 pillar parents:
 *
 * Under construction-accident-lawyers:
 *   1. Highway Construction Zone Injuries
 *
 * Under motorcycle-accident-lawyers:
 *   2. Dorchester Road Motorcycle Accidents
 *
 * Under pedestrian-accident-lawyers:
 *   3. Rivers Avenue Pedestrian Accidents
 *
 * Under slip-and-fall-lawyers:
 *   4. Retail & Shopping Center Falls
 *
 * Under premises-liability-lawyers:
 *   5. Apartment Complex Injuries
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-north-charleston-phase3-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under its parent.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find parent pillars
   ------------------------------------------------------------------ */

$pillar_slugs = array(
    'construction-accident-lawyers',
    'motorcycle-accident-lawyers',
    'pedestrian-accident-lawyers',
    'slip-and-fall-lawyers',
    'premises-liability-lawyers',
);

$pillars = array();
foreach ( $pillar_slugs as $slug ) {
    $p = get_page_by_path( $slug, OBJECT, 'practice_area' );
    if ( ! $p ) {
        $p = get_page_by_path( $slug, OBJECT, 'practice-area' );
    }
    if ( ! $p ) {
        WP_CLI::warning( "Pillar \"{$slug}\" not found — will skip its sub-types." );
        continue;
    }
    $pillars[ $slug ] = $p;
    WP_CLI::log( "Pillar: \"{$p->post_title}\" (ID {$p->ID})" );
}

$pillar_type = ! empty( $pillars ) ? reset( $pillars )->post_type : 'practice_area';

/* ------------------------------------------------------------------
   Author attribution
   ------------------------------------------------------------------ */

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $graeham ? $graeham->ID : 0;

/* ------------------------------------------------------------------
   Taxonomy terms
   ------------------------------------------------------------------ */

$terms = array();
$term_defs = array(
    'construction-accidents' => 'Construction Accidents',
    'motorcycle-accidents'   => 'Motorcycle Accidents',
    'pedestrian-accidents'   => 'Pedestrian Accidents',
    'slip-and-fall'          => 'Slip and Fall',
    'premises-liability'     => 'Premises Liability',
);
foreach ( $term_defs as $slug => $name ) {
    $t = term_exists( $slug, 'practice_category' );
    if ( ! $t ) {
        $t = wp_insert_term( $name, 'practice_category', array( 'slug' => $slug ) );
    }
    $terms[ $slug ] = is_array( $t ) ? (int) $t['term_id'] : (int) $t;
}

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Highway Construction Zone Injuries
       ============================================================ */
    array(
        'parent_slug' => 'construction-accident-lawyers',
        'cat_slug'    => 'construction-accidents',
        'title'       => 'Highway Construction Zone Injury Lawyers',
        'slug'        => 'highway-construction-zone',
        'excerpt'     => 'Injured in a highway construction zone on I-526, I-26, or other South Carolina roads? Construction zone crashes carry enhanced penalties for at-fault drivers and may create liability for contractors. Free consultation at Roden Law.',
        'content'     => <<<'HTML'
<h2>Highway Construction Zone Injury Lawyers — South Carolina</h2>
<p>The ongoing <strong>I-526 Lowcountry Corridor widening project</strong> and recurring maintenance on I-26 have turned North Charleston's highways into a patchwork of construction zones — narrowed lanes, shifted traffic patterns, concrete barriers, reduced speeds, and heavy equipment operating feet from 60 mph traffic. Crash rates increase 20-40% in highway work zones according to the <a href="https://www.fhwa.dot.gov/" target="_blank" rel="noopener">Federal Highway Administration (FHWA)</a>.</p>
<p>If you were injured in a construction zone, the at-fault driver isn't the only potential defendant. The construction contractor, SCDOT, and traffic management subcontractor may all bear liability if inadequate signage, confusing lane shifts, or unsafe work zone design contributed to your crash.</p>

<h2>Active Construction Zones in North Charleston</h2>
<ul>
<li><strong>I-526 Lowcountry Corridor (West):</strong> Multi-year widening project adding capacity through North Charleston and West Ashley. Active work zones with lane shifts, barrier walls, and temporary ramps.</li>
<li><strong>I-26 periodic maintenance:</strong> Bridge repairs, resurfacing, and median work creating recurring construction zones between Ashley Phosphate and the I-526 interchange</li>
<li><strong>Rivers Avenue improvements:</strong> Intersection upgrades and utility work narrowing lanes in sections</li>
<li><strong>Dorchester Road corridor:</strong> Residential and commercial development requiring utility cuts and road modifications</li>
</ul>

<h2>Why Construction Zones Are Dangerous</h2>
<ul>
<li><strong>Lane shifts:</strong> Sudden lateral lane shifts confuse drivers, especially at night or in rain when temporary markings are hard to see</li>
<li><strong>Narrowed lanes:</strong> Standard 12-foot lanes reduced to 10 or 11 feet leave no margin for error, especially for trucks</li>
<li><strong>Speed differentials:</strong> Reduced speed limits (often 45 mph in a 65 zone) create dangerous speed differences between compliant and non-compliant drivers</li>
<li><strong>Concrete barriers:</strong> Jersey barriers prevent escape routes — a loss of control that might end on a shoulder instead results in a barrier strike</li>
<li><strong>Construction equipment:</strong> Slow-moving equipment entering and exiting travel lanes without adequate acceleration distance</li>
<li><strong>Distracted workers:</strong> Flaggers and equipment operators near live traffic face constant danger from inattentive drivers</li>
</ul>

<h2>Liable Parties in Work Zone Crashes</h2>
<table>
<thead>
<tr><th>Party</th><th>Potential Liability</th></tr>
</thead>
<tbody>
<tr><td>At-fault driver</td><td>Speeding, distraction, failure to merge, rear-end in slowed traffic</td></tr>
<tr><td>General contractor</td><td>Inadequate signage, confusing lane shifts, poor traffic management plan</td></tr>
<tr><td>Traffic control subcontractor</td><td>Missing signs, malfunctioning signals, insufficient advance warning</td></tr>
<tr><td>SCDOT</td><td>Approving an unsafe traffic management plan, failing to enforce contractor compliance</td></tr>
<tr><td>Equipment operators</td><td>Entering travel lanes without flagging, operating without adequate visibility measures</td></tr>
</tbody>
</table>

<h2>Enhanced Penalties in South Carolina Work Zones</h2>
<p>South Carolina law imposes enhanced penalties for traffic violations in active work zones:</p>
<ul>
<li>Speeding fines are <strong>doubled</strong> in construction zones when workers are present</li>
<li>Reckless driving charges may be enhanced</li>
<li>These enhanced penalties also serve as evidence of the driver's heightened duty of care — violating work zone rules strengthens your negligence case</li>
</ul>

<h2>SCDOT and Contractor Liability (Tort Claims Act)</h2>
<p>If SCDOT or a government contractor's negligent work zone design caused your crash, claims are governed by the <a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">South Carolina Tort Claims Act (S.C. Code § 15-78-80)</a>. Key requirements:</p>
<ul>
<li>Written notice to the government entity</li>
<li>Strict compliance with notice procedures</li>
<li>Damages caps apply in some circumstances</li>
<li>Immunity exceptions must be navigated carefully</li>
</ul>
<p>Private contractors are <strong>not</strong> protected by government immunity — they can be sued directly for negligence.</p>

<h2>Your Rights</h2>
<p>South Carolina's 3-year statute of limitations applies (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). For claims involving government entities, notice requirements may be shorter. Contact Roden Law at <a href="tel:+18436126561">(843) 612-6561</a> immediately after any work zone crash.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue the construction company if their work zone caused my crash?',
                'answer'   => 'Yes. If inadequate signage, confusing lane shifts, missing barriers, or poor traffic management design contributed to your crash, the construction contractor may be directly liable for negligence. Unlike government entities, private contractors are not protected by sovereign immunity.',
            ),
            array(
                'question' => 'Are fines doubled in construction zones in South Carolina?',
                'answer'   => 'Yes. Speeding and other traffic violations carry enhanced (doubled) penalties in active work zones when workers are present. This heightened legal standard also supports your personal injury claim by establishing the at-fault driver\'s increased duty of care in the work zone.',
            ),
            array(
                'question' => 'What evidence should I gather after a construction zone accident?',
                'answer'   => 'Photograph the work zone layout — signage, lane markings, barriers, lane shifts, and the presence or absence of flaggers. Note whether signs were missing, confusing, or placed too close to the hazard. Document the speed limit signs and any advance warning signs. This evidence may establish contractor or SCDOT liability beyond just the other driver.',
            ),
        ),
    ),

    /* ============================================================
       2. Dorchester Road Motorcycle Accidents
       ============================================================ */
    array(
        'parent_slug' => 'motorcycle-accident-lawyers',
        'cat_slug'    => 'motorcycle-accidents',
        'title'       => 'Dorchester Road Motorcycle Accident Lawyers',
        'slug'        => 'dorchester-road-motorcycle',
        'excerpt'     => 'Dorchester Road in North Charleston has seen multiple fatal motorcycle crashes. Left-turning vehicles, heavy truck traffic, and high speeds create extreme danger for riders. Roden Law handles motorcycle accident claims — free consultation.',
        'content'     => <<<'HTML'
<h2>Dorchester Road Motorcycle Accident Lawyers — North Charleston</h2>
<p>Dorchester Road through North Charleston and Summerville has a documented history of fatal motorcycle crashes. The corridor's combination of high speeds (45-55 mph), heavy commercial truck traffic, and intersections with limited visibility makes it one of the most dangerous roads for motorcyclists in the Lowcountry. A fatal motorcycle-versus-truck collision at Dorchester Road and Forest Hills Drive in March 2026 underscores the ongoing danger.</p>
<p>Roden Law's <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> represents motorcyclists injured on <a href="/car-accident-lawyers/dorchester-road-accident/">Dorchester Road</a> and throughout the Charleston area. Motorcycle crash cases require different legal strategies than car accidents — we understand the unique biases riders face and how to overcome them.</p>

<h2>Why Dorchester Road Is Deadly for Motorcyclists</h2>
<ul>
<li><strong>Left-turn collisions:</strong> The #1 cause of motorcycle fatalities. Vehicles turning left at intersections fail to see oncoming motorcycles due to their smaller visual profile. Dorchester Road's unprotected left turns at Forest Hills Drive, Bacons Bridge Road, and Ashley Phosphate are high-risk locations.</li>
<li><strong>Heavy truck traffic:</strong> Cement mixers, dump trucks, and construction vehicles share the corridor with motorcycles. These large vehicles have massive blind spots and create turbulent air wash that can destabilize riders.</li>
<li><strong>Speed:</strong> Traffic frequently exceeds the 45-55 mph posted limits. At these speeds, a motorcycle rider has less than 2 seconds to react to a left-turning vehicle.</li>
<li><strong>Road surface conditions:</strong> Aging pavement, gravel from construction sites, and uneven utility cuts create hazards invisible to car drivers but potentially fatal for motorcyclists.</li>
<li><strong>Limited escape routes:</strong> Curbed medians and adjacent drainage ditches leave riders nowhere to go when a collision is imminent.</li>
</ul>

<h2>The Left-Turn Problem</h2>
<p>According to the <a href="https://www.nhtsa.gov/" target="_blank" rel="noopener">NHTSA</a>, left-turning vehicles cause approximately 42% of fatal motorcycle crashes. The physics are simple but deadly:</p>
<ol>
<li>A car waits to turn left across traffic</li>
<li>The driver judges the gap in oncoming traffic — but a motorcycle's narrow profile makes it appear farther away and traveling slower than it actually is</li>
<li>The driver initiates the turn</li>
<li>The motorcyclist has a fraction of a second to react</li>
<li>The motorcycle strikes the turning vehicle broadside, or the rider attempts to evade and loses control</li>
</ol>
<p>On Dorchester Road, this scenario plays out at every unprotected left-turn intersection. The high approach speeds (50+ mph) and commercial vehicle sight obstructions make it worse.</p>

<h2>Motorcycle Injuries Are More Severe</h2>
<p>Motorcyclists are <strong>29 times more likely to die</strong> in a crash than car occupants (per vehicle mile traveled). Without the protective shell of a car, motorcycle crashes commonly produce:</p>
<ul>
<li><strong>Traumatic brain injuries</strong> — even with a helmet, high-speed impacts cause severe TBI</li>
<li><strong>Road rash and degloving</strong> — skin stripped away by pavement contact at speed</li>
<li><strong>Fractures</strong> — legs, pelvis, arms, and hands absorb initial impact forces</li>
<li><strong>Spinal cord injuries</strong> — impact with vehicles or fixed objects can cause paralysis</li>
<li><strong>Internal injuries</strong> — organ damage from blunt force impact</li>
<li><strong>Amputation</strong> — crush injuries from being caught under vehicles or striking fixed objects</li>
</ul>

<h2>South Carolina Motorcycle Laws</h2>
<ul>
<li><strong>Helmet law:</strong> Only riders under 21 are required to wear helmets. Adults may ride without one — but not wearing a helmet does NOT bar your injury claim.</li>
<li><strong>Comparative fault:</strong> The defense may argue helmet non-use contributed to head injury severity, potentially reducing (but not eliminating) your recovery.</li>
<li><strong>Lane splitting:</strong> Illegal in South Carolina. If you were lane splitting when the crash occurred, you may bear partial fault.</li>
<li><strong>Insurance:</strong> SC requires minimum liability insurance for motorcycles ($25K/$50K/$25K). UM/UIM coverage is strongly recommended.</li>
</ul>

<h2>Overcoming Anti-Motorcycle Bias</h2>
<p>Motorcyclists face implicit bias from jurors, adjusters, and even police officers who assume riders are reckless or that "they should have known the risk." Roden Law combats this bias by:</p>
<ul>
<li>Establishing the rider's experience, training, and safety record</li>
<li>Demonstrating the other driver's clear violation (failure to yield, failure to look)</li>
<li>Using accident reconstruction to show the motorcycle was traveling at or below the speed limit</li>
<li>Presenting the science of motorcycle conspicuity and why left-turn drivers fail to see bikes</li>
</ul>

<h2>Filing Deadline</h2>
<p>You have <strong>3 years</strong> from the date of your Dorchester Road motorcycle crash to file suit (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). In fatal cases, the <a href="/wrongful-death-lawyers/north-charleston-sc/">wrongful death statute</a> applies. Contact Roden Law at <a href="tel:+18436126561">(843) 612-6561</a>.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I recover damages if I was not wearing a helmet on Dorchester Road?',
                'answer'   => 'Yes. South Carolina does not require adult riders to wear helmets, so not wearing one is legal and cannot be used as evidence of negligence per se. However, the defense may argue that helmet non-use worsened head injuries specifically, which could reduce (but not eliminate) your recovery under comparative fault. An experienced attorney can minimize this impact.',
            ),
            array(
                'question' => 'Who is at fault when a car turns left into a motorcycle?',
                'answer'   => 'The turning driver bears primary fault for failing to yield to oncoming traffic — this is a violation of South Carolina traffic law. The motorcyclist may be partially at fault only if they were speeding or running a red light. In most left-turn motorcycle crashes, the turning driver is 80-100% at fault.',
            ),
            array(
                'question' => 'What should I do if my loved one was killed on Dorchester Road?',
                'answer'   => 'South Carolina wrongful death law allows surviving family members to recover compensation for funeral expenses, lost future income, loss of companionship, and pain the victim experienced before death. The claim is filed by the estate\'s personal representative. Contact Roden Law immediately — evidence preservation is time-sensitive.',
            ),
        ),
    ),

    /* ============================================================
       3. Rivers Avenue Pedestrian Accidents
       ============================================================ */
    array(
        'parent_slug' => 'pedestrian-accident-lawyers',
        'cat_slug'    => 'pedestrian-accidents',
        'title'       => 'Rivers Avenue Pedestrian Accident Lawyers',
        'slug'        => 'rivers-avenue-pedestrian',
        'excerpt'     => 'Rivers Avenue in North Charleston is one of SC\'s most dangerous roads for pedestrians — wide lanes, 50 mph traffic, and no safe crossings near bus stops. Roden Law represents pedestrian crash victims. Free consultation.',
        'content'     => <<<'HTML'
<h2>Rivers Avenue Pedestrian Accident Lawyers — North Charleston</h2>
<p><a href="/car-accident-lawyers/rivers-avenue-accident/">Rivers Avenue (US-52)</a> is one of the most dangerous roads for pedestrians in South Carolina. The multi-lane corridor — up to 6 lanes in sections — carries traffic at 45-50 mph through dense commercial zones where bus riders, workers, and shoppers must cross on foot. The road was designed for vehicle throughput, not pedestrian safety, and the result is a regular toll of pedestrian injuries and fatalities.</p>
<p>Roden Law's <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> represents pedestrians struck on Rivers Avenue and throughout the Lowcountry. Pedestrian victims suffer the most severe injuries of any road user — and they are almost never at fault when a driver strikes them in or near a crosswalk.</p>

<h2>Why Rivers Avenue Is Deadly for Pedestrians</h2>
<ul>
<li><strong>No safe crossings:</strong> Bus stops are located on both sides of Rivers Avenue, but many sections lack marked crosswalks or pedestrian signals. Riders must cross 6 lanes of 50 mph traffic to reach their stop.</li>
<li><strong>Wide crossing distance:</strong> Crossing Rivers Avenue requires traversing 70-80+ feet of pavement — a 15-20 second exposure to traffic that approaches at 73 feet per second (50 mph).</li>
<li><strong>No median refuge:</strong> In many sections, there is no raised median where pedestrians can wait mid-crossing — it's all-or-nothing.</li>
<li><strong>Speed:</strong> Traffic regularly exceeds 50 mph. A pedestrian struck at 40 mph has a 45% chance of dying; at 50 mph, it rises to 75%.</li>
<li><strong>Turning vehicles:</strong> Drivers turning into shopping centers, restaurants, and gas stations focus on traffic gaps — not pedestrians at the road edge.</li>
<li><strong>Poor lighting:</strong> Nighttime pedestrian fatalities are disproportionately high on Rivers Avenue due to inadequate street lighting in commercial sections.</li>
</ul>

<h2>Pedestrian Crash Statistics</h2>
<p>Key data for Rivers Avenue pedestrian safety:</p>
<ul>
<li>The Rivers Ave/I-526 interchange produced <strong>62 injuries</strong> over a 5-year period — many involving pedestrians</li>
<li>North Charleston reports multiple <strong>fatal pedestrian crashes annually</strong> on the Rivers Avenue corridor</li>
<li>Pedestrians account for a disproportionate share of traffic fatalities despite representing a small fraction of road users</li>
<li>The majority of pedestrian strikes on Rivers Avenue occur <strong>outside marked crosswalks</strong> — because adequate crosswalks don't exist where people need them</li>
</ul>

<h2>Who Is At Fault?</h2>
<p>South Carolina law requires drivers to exercise due care to avoid striking pedestrians — even if the pedestrian is jaywalking. Key legal principles:</p>
<ul>
<li><strong>Crosswalk rule:</strong> Drivers must yield to pedestrians in marked and unmarked crosswalks (S.C. Code § 56-5-3130)</li>
<li><strong>Due care doctrine:</strong> All drivers must exercise due care to avoid colliding with any pedestrian, regardless of right-of-way (S.C. Code § 56-5-3230)</li>
<li><strong>Comparative fault:</strong> Even if a pedestrian was crossing outside a crosswalk, the driver may bear majority fault if they were speeding, distracted, or failed to keep a proper lookout</li>
<li><strong>Infrastructure liability:</strong> The city or SCDOT may bear liability for failing to provide pedestrian crossings where the need is obvious and documented</li>
</ul>

<h2>Pedestrian Injuries</h2>
<p>A pedestrian has zero protection from a multi-ton vehicle. Injuries are typically severe or fatal:</p>
<ul>
<li><strong>Traumatic brain injury:</strong> Head strikes the vehicle hood, windshield, or pavement</li>
<li><strong>Spinal cord injury:</strong> Vertebral fractures from the initial impact or secondary fall</li>
<li><strong>Pelvic and lower extremity fractures:</strong> The "bumper height" impact pattern strikes legs and pelvis first</li>
<li><strong>Internal organ damage:</strong> Blunt force to abdomen causes splenic rupture, liver laceration, kidney damage</li>
<li><strong>Fatal injuries:</strong> At 50 mph, a pedestrian has only a 25% chance of survival</li>
</ul>

<h2>Government Liability for Dangerous Road Design</h2>
<p>When a road is designed without pedestrian safety in mind — despite known pedestrian activity — the government entity responsible may bear liability under the <a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">South Carolina Tort Claims Act</a>. Evidence supporting infrastructure claims on Rivers Avenue:</p>
<ul>
<li>Bus stops located where no crosswalk exists</li>
<li>Known pedestrian fatality history without safety improvements</li>
<li>Absence of pedestrian signals at high-activity intersections</li>
<li>Lack of median refuges on a 6-lane road</li>
<li>Inadequate lighting in areas with documented nighttime pedestrian activity</li>
</ul>

<h2>Your Rights</h2>
<p>You have <strong>3 years</strong> to file a personal injury claim (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). Government liability claims under the Tort Claims Act have shorter notice requirements. Contact Roden Law immediately at <a href="tel:+18436126561">(843) 612-6561</a>.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I recover damages if I was crossing Rivers Avenue outside a crosswalk?',
                'answer'   => 'Yes. South Carolina law requires drivers to exercise due care to avoid striking pedestrians regardless of right-of-way. Even if you bear some comparative fault for crossing outside a crosswalk, the driver may bear majority fault for speeding, distraction, or failure to keep a proper lookout. You can recover as long as you were less than 51% at fault.',
            ),
            array(
                'question' => 'Can I sue the city for not having crosswalks on Rivers Avenue?',
                'answer'   => 'Potentially. Under the SC Tort Claims Act, government entities may be liable for dangerous road designs when they know (or should know) that pedestrians regularly cross in areas without safe crossing infrastructure — especially near bus stops. The documented pedestrian fatality history on Rivers Avenue supports this type of claim.',
            ),
            array(
                'question' => 'What compensation can a pedestrian recover after being hit?',
                'answer'   => 'Pedestrian victims can recover medical expenses (often extensive due to injury severity), lost wages, future medical costs, pain and suffering, disability and disfigurement, and loss of enjoyment of life. In fatal cases, surviving family members can pursue wrongful death damages.',
            ),
        ),
    ),

    /* ============================================================
       4. Retail & Shopping Center Falls
       ============================================================ */
    array(
        'parent_slug' => 'slip-and-fall-lawyers',
        'cat_slug'    => 'slip-and-fall',
        'title'       => 'Retail & Shopping Center Slip and Fall Lawyers',
        'slug'        => 'retail-shopping-center-fall',
        'excerpt'     => 'Slip and fall accidents at North Charleston shopping centers, big-box stores, and retail outlets cause serious injuries. Property owners are liable for known hazards. Roden Law — free consultation for slip and fall claims.',
        'content'     => <<<'HTML'
<h2>Retail &amp; Shopping Center Fall Lawyers — North Charleston</h2>
<p>North Charleston is a major retail hub for the Lowcountry, with shopping centers, big-box stores, outlet malls, and grocery stores lining Rivers Avenue, Ashley Phosphate Road, and Tanger Outlets. Every year, hundreds of shoppers are injured in slip and fall accidents caused by wet floors, spilled merchandise, uneven surfaces, poor lighting, and neglected parking lots. Property owners and retailers have a legal duty to maintain safe premises — when they fail, they are liable for your injuries.</p>

<h2>Common Causes of Retail Slip and Falls</h2>
<ul>
<li><strong>Wet floors:</strong> Spilled liquids in grocery aisles, mopped floors without warning signs, rainwater tracked inside entrances, condensation from refrigeration units</li>
<li><strong>Spilled merchandise:</strong> Dropped produce, broken containers, scattered clothing items, loose packaging creating trip hazards</li>
<li><strong>Uneven flooring:</strong> Transition strips between surfaces, raised tiles, damaged carpet, worn thresholds</li>
<li><strong>Parking lot hazards:</strong> Potholes, crumbling pavement, uneven curbs, ice/frost in winter, inadequate lighting</li>
<li><strong>Stairway defects:</strong> Worn treads, missing handrails, inconsistent riser heights, poor lighting in enclosed stairwells</li>
<li><strong>Mat and rug hazards:</strong> Bunched entrance mats, curled rug edges, unsecured floor coverings</li>
<li><strong>Inadequate maintenance:</strong> Failure to clean spills promptly, ignoring reported hazards, deferring repairs</li>
</ul>

<h2>Major Retail Locations in North Charleston</h2>
<p>Roden Law handles slip and fall cases from retailers and shopping centers throughout North Charleston, including (but not limited to):</p>
<ul>
<li>Tanger Outlets North Charleston</li>
<li>Northwoods Mall</li>
<li>Centre Pointe shopping area</li>
<li>Rivers Avenue retail corridor (Walmart, Target, Home Depot, Lowes)</li>
<li>Ashley Phosphate Road commercial strip</li>
<li>Grocery stores (Publix, Harris Teeter, Food Lion, Aldi)</li>
</ul>

<h2>Proving a Retail Slip and Fall Case</h2>
<p>South Carolina premises liability law requires you to prove three elements:</p>
<ol>
<li><strong>Dangerous condition existed:</strong> A wet floor, spill, defect, or other hazard was present</li>
<li><strong>The property owner knew or should have known:</strong> Either they created the hazard, knew about it and failed to fix it, or the hazard existed long enough that a reasonable inspection would have discovered it</li>
<li><strong>The condition caused your injury:</strong> You slipped, tripped, or fell because of the specific hazard</li>
</ol>

<h3>The "Constructive Notice" Standard</h3>
<p>You don't need to prove the store <em>actually</em> knew about the hazard. If a spill existed for 15-30+ minutes without cleanup, courts can infer the store <em>should</em> have discovered it through reasonable inspection. Evidence of how long the hazard existed includes:</p>
<ul>
<li>Dirty or dried appearance of the spill (not fresh)</li>
<li>Shopping cart tracks through the spill (indicating time elapsed)</li>
<li>Witness testimony that they noticed it before your fall</li>
<li>Store inspection logs showing no recent check of that area</li>
<li>Surveillance footage showing when the spill occurred</li>
</ul>

<h2>What to Do After a Retail Fall</h2>
<ol>
<li><strong>Report it to the store manager</strong> — Ask them to create an incident report. Get a copy or photograph it.</li>
<li><strong>Photograph the hazard</strong> — Capture the spill, defect, or condition before it is cleaned up. Photograph your shoes (to prove they are not contributory).</li>
<li><strong>Get witness names</strong> — If other shoppers saw the hazard or your fall, get contact information</li>
<li><strong>Preserve your clothing and shoes</strong> — Don't wash or discard the clothing and footwear you were wearing</li>
<li><strong>Seek medical attention</strong> — Even if you can walk, soft tissue injuries and fractures may not be immediately apparent</li>
<li><strong>Do not give a recorded statement</strong> — The store's insurance company will contact you quickly. Consult an attorney first.</li>
</ol>

<h2>Common Injuries from Retail Falls</h2>
<ul>
<li><strong>Hip fractures:</strong> Especially in older adults — can require surgery and extended rehabilitation</li>
<li><strong>Wrist and arm fractures:</strong> From instinctively bracing against the fall</li>
<li><strong>Back injuries:</strong> Herniated discs, compression fractures, and soft tissue damage</li>
<li><strong>Head injuries:</strong> Striking the head on flooring, shelving, or displays during the fall</li>
<li><strong>Knee injuries:</strong> Torn ligaments (ACL, MCL) from twisting during the fall</li>
</ul>

<h2>South Carolina Law</h2>
<p>You have <strong>3 years</strong> to file a premises liability claim (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). South Carolina's comparative fault rule allows recovery if you were less than 51% at fault — stores often argue the hazard was "open and obvious," but a wet floor in a store aisle is not something shoppers reasonably expect to encounter. Call Roden Law at <a href="tel:+18436126561">(843) 612-6561</a>.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'How do I prove the store knew about the spill that caused my fall?',
                'answer'   => 'You can establish "constructive notice" — proving the hazard existed long enough that a reasonable inspection would have found it. Evidence includes the dried or dirty appearance of a spill, cart tracks through it, witness testimony, surveillance footage, and the store\'s own inspection logs showing when employees last checked the area.',
            ),
            array(
                'question' => 'What if the store says I should have seen the hazard?',
                'answer'   => 'The "open and obvious" defense is commonly raised but often fails. Shoppers are looking at merchandise, not the floor. Wet floors without warning signs are not "obvious" to a person walking normally through a store. South Carolina law considers whether the hazard was truly obvious to a reasonable person exercising ordinary care, not whether it was theoretically visible.',
            ),
            array(
                'question' => 'Should I report my fall to the store manager?',
                'answer'   => 'Yes — always report it and ask for a written incident report. This creates an official record of the fall and the condition that caused it. However, keep your description brief and factual. Do not speculate about fault, minimize your injuries, or give a recorded statement without consulting an attorney first.',
            ),
        ),
    ),

    /* ============================================================
       5. Apartment Complex Injuries
       ============================================================ */
    array(
        'parent_slug' => 'premises-liability-lawyers',
        'cat_slug'    => 'premises-liability',
        'title'       => 'Apartment Complex Injury Lawyers',
        'slug'        => 'apartment-complex-injury',
        'excerpt'     => 'Injured at a North Charleston apartment complex? Landlords are liable for unsafe conditions — broken stairs, poor lighting, inadequate security, pool accidents, and maintenance failures. Roden Law — free consultation.',
        'content'     => <<<'HTML'
<h2>Apartment Complex Injury Lawyers — North Charleston, SC</h2>
<p>North Charleston has one of the highest renter populations in the Charleston metro area, with hundreds of apartment complexes housing tens of thousands of residents. Landlords and property management companies have a legal duty to maintain safe premises — but many cut corners on maintenance, security, and repairs. When tenants or visitors are injured because of these failures, the property owner is liable.</p>
<p>Roden Law represents tenants and visitors injured at apartment complexes throughout North Charleston. Our <a href="/premises-liability-lawyers/north-charleston-sc/">premises liability attorneys</a> hold negligent landlords accountable for unsafe conditions that cause harm.</p>

<h2>Common Apartment Complex Injuries</h2>
<ul>
<li><strong>Stairway falls:</strong> Broken or missing handrails, rotting treads, uneven steps, poor lighting in stairwells. Multi-story apartment buildings without elevators force daily stair use.</li>
<li><strong>Parking lot injuries:</strong> Potholes, crumbling pavement, inadequate lighting, missing speed bumps, and vehicle-pedestrian conflicts in poorly designed lots</li>
<li><strong>Swimming pool accidents:</strong> Missing or broken fencing, no lifeguard or safety equipment, broken pool drains, slippery deck surfaces, and inadequate chemical maintenance</li>
<li><strong>Inadequate security:</strong> Broken locks, non-functioning gates, no security cameras, poor lighting in common areas — leading to assaults, robberies, and break-ins</li>
<li><strong>Balcony and railing failures:</strong> Rotted balcony supports, loose railings, and structural collapse. These falls can be fatal.</li>
<li><strong>Fire safety failures:</strong> Non-functioning smoke detectors, blocked exits, missing fire extinguishers, faulty wiring causing electrical fires</li>
<li><strong>Dog bites:</strong> Landlords who allow aggressive breeds without restrictions, or fail to enforce leash policies in common areas</li>
<li><strong>Mold and toxic exposure:</strong> Unaddressed water damage, HVAC contamination, and pest control chemical exposure causing respiratory illness</li>
</ul>

<h2>Landlord Duty of Care</h2>
<p>Under South Carolina premises liability law, landlords owe tenants and their guests a duty to:</p>
<ul>
<li>Maintain common areas (stairwells, hallways, parking lots, pools, laundry rooms) in reasonably safe condition</li>
<li>Repair known hazards within a reasonable time after learning of them</li>
<li>Conduct regular inspections to discover dangerous conditions</li>
<li>Provide adequate security measures when criminal activity is foreseeable</li>
<li>Comply with building codes, fire codes, and housing regulations</li>
<li>Warn of known hazards that cannot be immediately repaired</li>
</ul>

<h2>Negligent Security Claims</h2>
<p>If you were assaulted, robbed, or otherwise victimized due to inadequate security at your apartment complex, the landlord may be liable. Factors courts consider:</p>
<ul>
<li>Prior criminal incidents at the property (establishing foreseeability)</li>
<li>Crime rates in the surrounding area</li>
<li>Whether security measures (lighting, locks, cameras, gates, patrols) were adequate</li>
<li>Whether the landlord knew about security deficiencies and failed to address them</li>
<li>Whether broken security features (gates, locks) were reported but not repaired</li>
</ul>

<h2>Building Code Violations as Evidence</h2>
<p>North Charleston building code and fire code violations serve as evidence of negligence. Common violations at apartment complexes include:</p>
<ul>
<li>Missing or non-functional smoke detectors</li>
<li>Handrails not meeting code height or strength requirements</li>
<li>Inadequate egress (blocked or locked exit doors)</li>
<li>Electrical code violations creating fire risk</li>
<li>Pool fencing not meeting barrier requirements</li>
<li>Deferred structural maintenance creating collapse hazards</li>
</ul>
<p>Code violations don't just prove negligence — they may support negligence per se, making liability essentially automatic.</p>

<h2>What to Do After an Apartment Injury</h2>
<ol>
<li><strong>Document the hazard</strong> — Photograph the dangerous condition (broken stair, missing railing, unlit area) immediately</li>
<li><strong>Report to management in writing</strong> — Email or text creates a dated record. Keep copies of all communications.</li>
<li><strong>Check if you previously reported the issue</strong> — Prior complaints prove the landlord knew about the hazard</li>
<li><strong>Get medical attention</strong> — Document your injuries with medical records</li>
<li><strong>Contact an attorney</strong> — Landlords and their insurance companies will attempt to blame you or deny responsibility</li>
</ol>

<h2>Your Rights</h2>
<p>South Carolina's 3-year statute of limitations applies (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). You may recover medical expenses, lost wages, pain and suffering, and in egregious cases of landlord negligence, punitive damages. Contact Roden Law at <a href="tel:+18436126561">(843) 612-6561</a>.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue my landlord if I was injured in my apartment complex?',
                'answer'   => 'Yes, if the injury was caused by a dangerous condition that the landlord knew about or should have discovered through reasonable inspections. Landlords are liable for unsafe common areas (stairs, parking lots, pools), deferred maintenance, inadequate security, and building code violations.',
            ),
            array(
                'question' => 'What if I already reported the hazard and nothing was done?',
                'answer'   => 'Prior written complaints actually strengthen your case significantly — they prove the landlord had actual knowledge of the dangerous condition and chose not to fix it. This eliminates any dispute about whether the landlord "knew" about the hazard. Save all emails, texts, and maintenance request records.',
            ),
            array(
                'question' => 'Can I sue my apartment complex if I was assaulted on the property?',
                'answer'   => 'If the assault was foreseeable (prior incidents at the property, high-crime area) and the landlord failed to provide adequate security measures (lighting, functioning locks/gates, cameras), you may have a negligent security claim. The landlord isn\'t liable for the assault itself, but for creating conditions that allowed it to happen.',
            ),
        ),
    ),
);

/* ------------------------------------------------------------------
   Create posts
   ------------------------------------------------------------------ */

$created = 0;
$skipped = 0;

foreach ( $subtypes as $st ) {
    if ( ! isset( $pillars[ $st['parent_slug'] ] ) ) {
        WP_CLI::warning( "SKIP: \"{$st['title']}\" — parent pillar not found." );
        $skipped++;
        continue;
    }

    $parent = $pillars[ $st['parent_slug'] ];

    $existing = get_posts( array(
        'post_type'      => $pillar_type,
        'post_status'    => array( 'publish', 'draft' ),
        'post_parent'    => $parent->ID,
        'name'           => $st['slug'],
        'posts_per_page' => 1,
    ) );

    if ( ! empty( $existing ) ) {
        WP_CLI::log( "SKIP: \"{$st['title']}\" already exists (ID {$existing[0]->ID})" );
        $skipped++;
        continue;
    }

    $post_id = wp_insert_post( array(
        'post_type'    => $pillar_type,
        'post_title'   => $st['title'],
        'post_name'    => $st['slug'],
        'post_parent'  => $parent->ID,
        'post_status'  => 'publish',
        'post_content' => $st['content'],
        'post_excerpt' => $st['excerpt'],
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "FAILED: \"{$st['title']}\" — " . $post_id->get_error_message() );
        continue;
    }

    update_post_meta( $post_id, '_roden_jurisdiction', 'sc' );
    update_post_meta( $post_id, '_roden_sol_sc', '3 years (S.C. Code § 15-3-530)' );
    update_post_meta( $post_id, '_roden_sol_ga', '2 years (O.C.G.A. § 9-3-33)' );
    update_post_meta( $post_id, '_roden_author_attorney', $author_id );

    if ( ! empty( $st['faqs'] ) ) {
        update_post_meta( $post_id, '_roden_faqs', $st['faqs'] );
    }

    $term_id = $terms[ $st['cat_slug'] ] ?? 0;
    if ( $term_id ) {
        wp_set_object_terms( $post_id, array( $term_id ), 'practice_category' );
    }

    $url_slug = $st['parent_slug'] . '/' . $st['slug'];
    WP_CLI::success( "CREATED: \"{$st['title']}\" (ID {$post_id}) → /{$url_slug}/" );
    $created++;
}

WP_CLI::log( '' );
WP_CLI::log( "Done. Created: {$created} | Skipped: {$skipped}" );
