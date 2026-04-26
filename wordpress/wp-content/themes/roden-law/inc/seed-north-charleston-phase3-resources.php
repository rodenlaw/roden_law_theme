<?php
/**
 * Seeder: North Charleston Phase 3 — Resource Pages
 *
 * Creates 3 resource posts:
 *   1. North Charleston Pedestrian & Bicycle Safety: Know Your Rights
 *   2. Filing a Personal Injury Claim in Charleston County Circuit Court
 *   3. North Charleston Construction Zone Accident Rights
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-north-charleston-phase3-resources.php
 *
 * Idempotent — skips any post whose slug already exists.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $graeham ? $graeham->ID : 0;

$resources = array(

    /* ============================================================
       1. Pedestrian & Bicycle Safety Guide
       ============================================================ */
    array(
        'title'   => 'North Charleston Pedestrian & Bicycle Safety: Know Your Rights',
        'slug'    => 'pedestrian-bicycle-safety-north-charleston',
        'excerpt' => 'Guide to pedestrian and bicycle safety rights in North Charleston, SC. Covers dangerous roads (Rivers Ave, Park Circle), South Carolina pedestrian laws, driver duties, and how to file an injury claim after being struck.',
        'content' => <<<'HTML'
<h2>Pedestrian &amp; Bicycle Safety in North Charleston</h2>
<p>North Charleston presents a paradox: the city is investing in walkable neighborhoods like Park Circle while simultaneously maintaining some of the most pedestrian-hostile roads in South Carolina. <a href="/car-accident-lawyers/rivers-avenue-accident/">Rivers Avenue</a> — 6 lanes, 50 mph, minimal crosswalks — kills pedestrians with disturbing regularity. Meanwhile, the growing cycling infrastructure in Park Circle exists alongside industrial truck traffic on Spruill Avenue just blocks away.</p>
<p>This guide covers your legal rights as a pedestrian or cyclist in North Charleston, the most dangerous roads to know, and what to do if you are struck by a vehicle.</p>

<h2>South Carolina Pedestrian Laws</h2>
<ul>
<li><strong>Crosswalk rights (S.C. Code § 56-5-3130):</strong> Drivers must yield to pedestrians in marked and unmarked crosswalks. An "unmarked crosswalk" exists at any intersection even without painted lines.</li>
<li><strong>Due care doctrine (S.C. Code § 56-5-3230):</strong> All drivers must exercise due care to avoid striking a pedestrian, regardless of who has the right-of-way.</li>
<li><strong>Pedestrian duties (S.C. Code § 56-5-3150):</strong> Pedestrians crossing outside a crosswalk must yield to vehicles — but this does NOT mean a driver is excused from exercising due care.</li>
<li><strong>Sidewalk rule:</strong> Where sidewalks are provided, pedestrians must use them. Where no sidewalk exists, pedestrians should walk on the left side facing traffic.</li>
</ul>

<h2>South Carolina Bicycle Laws</h2>
<ul>
<li><strong>Same rights and duties as vehicles (S.C. Code § 56-5-3420):</strong> Bicyclists on public roads have the same rights as motorists and must follow the same traffic laws.</li>
<li><strong>Ride as far right as practicable:</strong> Cyclists should ride near the right side of the road, but may use the full lane when the lane is too narrow to share safely.</li>
<li><strong>Passing distance:</strong> Drivers must give cyclists at least 3 feet of clearance when passing (recommended; enforcement varies).</li>
<li><strong>Helmet:</strong> Not required for adults in SC, but strongly recommended. Non-use does not bar an injury claim.</li>
<li><strong>Night riding:</strong> Front white light and rear red reflector required after dark.</li>
</ul>

<h2>Most Dangerous Roads for Pedestrians &amp; Cyclists</h2>
<table>
<thead>
<tr><th>Road</th><th>Hazard for Pedestrians</th><th>Hazard for Cyclists</th></tr>
</thead>
<tbody>
<tr><td><a href="/pedestrian-accident-lawyers/rivers-avenue-pedestrian/">Rivers Avenue</a></td><td>6 lanes, no crosswalks near bus stops, 50 mph</td><td>No bike lanes, heavy truck traffic, high speed</td></tr>
<tr><td><a href="/car-accident-lawyers/ashley-phosphate-road-accident/">Ashley Phosphate Road</a></td><td>Wide crossing, heavy turning traffic</td><td>No bike infrastructure, commercial truck turning</td></tr>
<tr><td><a href="/car-accident-lawyers/dorchester-road-accident/">Dorchester Road</a></td><td>No sidewalks in sections, high speed</td><td>Narrow shoulders, heavy traffic, construction debris</td></tr>
<tr><td>East Montague Avenue</td><td>Pedestrian activity outpacing infrastructure upgrades</td><td>On-street parking conflicts with bike lane</td></tr>
<tr><td>Spruill Avenue</td><td>Industrial truck traffic near residential areas</td><td>Speed differentials between trucks and bikes</td></tr>
</tbody>
</table>

<h2>Park Circle: A Walkable Neighborhood with Remaining Hazards</h2>
<p>Park Circle has emerged as one of North Charleston's most walkable neighborhoods, with the tree-lined circle park, East Montague Avenue restaurants, and growing bike infrastructure. However, hazards remain:</p>
<ul>
<li>Spruill Avenue's truck traffic crosses through the district, creating dangerous conflicts with pedestrians and cyclists</li>
<li>The roundabout at Park Circle produces sideswipe collisions that endanger cyclists sharing the road</li>
<li>East Montague's on-street parking creates "door zone" hazards for cyclists</li>
<li>Growing foot traffic has outpaced crosswalk improvements at several intersections</li>
</ul>

<h2>What to Do If You Are Struck</h2>
<ol>
<li><strong>Stay at the scene and call 911</strong> — A police report is essential evidence</li>
<li><strong>Get medical attention immediately</strong> — Even if you can stand. Internal injuries and concussions have delayed symptoms.</li>
<li><strong>Photograph the scene</strong> — Your injuries, the vehicle, the road conditions, any crosswalk (or lack thereof)</li>
<li><strong>Get the driver's information</strong> — License plate, insurance, name, phone number</li>
<li><strong>Get witness contacts</strong> — Bystanders who saw the crash</li>
<li><strong>Do not say "I'm fine"</strong> — This statement will be used against you by insurance</li>
<li><strong>Contact an attorney</strong> — Pedestrian and bicycle cases often involve insurance disputes about right-of-way</li>
</ol>

<h2>Compensation in Pedestrian &amp; Bicycle Cases</h2>
<p>Because pedestrian and cyclist injuries are typically severe (no vehicle protection), damages are often substantial:</p>
<ul>
<li>Extensive medical bills (trauma surgery, ICU, rehabilitation)</li>
<li>Long-term disability and loss of earning capacity</li>
<li>Pain and suffering proportional to injury severity</li>
<li>Disfigurement and scarring</li>
<li>Wrongful death damages for fatal crashes</li>
</ul>

<h2>Filing Deadline</h2>
<p>South Carolina gives you <strong>3 years</strong> to file a claim (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). Contact Roden Law's <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> at <a href="tel:+18436126561">(843) 612-6561</a> for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Does a driver have to stop if they hit a pedestrian who was jaywalking?',
                'answer'   => 'Absolutely. Leaving the scene of an accident involving injury is a crime in South Carolina regardless of who had the right-of-way. Beyond criminal liability, the driver also owes a civil duty of care to avoid striking any pedestrian — jaywalking does not eliminate the driver\'s negligence if they were speeding, distracted, or failed to keep a proper lookout.',
            ),
            array(
                'question' => 'Can I recover damages if I was hit while cycling without a helmet?',
                'answer'   => 'Yes. South Carolina does not require adult cyclists to wear helmets. While the defense may argue helmet non-use contributed to head injury severity (potentially reducing your recovery under comparative fault), it cannot bar your claim entirely. The driver who struck you remains primarily liable.',
            ),
            array(
                'question' => 'What if the driver who hit me fled the scene?',
                'answer'   => 'You may still have a claim through your own uninsured motorist (UM) coverage or through the at-fault driver\'s insurance if they are later identified. File a police report immediately to document the hit-and-run. An attorney can also help identify the vehicle through surveillance footage and witness accounts.',
            ),
        ),
    ),

    /* ============================================================
       2. Charleston County Circuit Court Guide
       ============================================================ */
    array(
        'title'   => 'Filing a Personal Injury Claim in Charleston County Circuit Court',
        'slug'    => 'personal-injury-claim-charleston-county-court',
        'excerpt' => 'Guide to filing a personal injury lawsuit in Charleston County Circuit Court for North Charleston, Charleston, and Lowcountry accident victims. Covers the court process, filing deadlines, what to expect, and how jury trials work in SC.',
        'content' => <<<'HTML'
<h2>Personal Injury Claims in Charleston County Circuit Court</h2>
<p>If you were injured in North Charleston, Charleston, Mount Pleasant, or anywhere in Charleston County, your personal injury lawsuit will be filed in the <strong>Charleston County Circuit Court</strong> at 100 Broad Street, Charleston, SC 29401. Understanding the court process reduces anxiety and helps you make informed decisions about your case.</p>

<h2>Before Filing: The Pre-Litigation Phase</h2>
<p>Most personal injury cases begin with an insurance claim before any lawsuit is filed:</p>
<ol>
<li><strong>Medical treatment:</strong> Reach maximum medical improvement (MMI) or a clear prognosis before settling</li>
<li><strong>Demand letter:</strong> Your attorney sends a detailed demand to the insurance company with medical records, bills, lost wage documentation, and a settlement demand amount</li>
<li><strong>Negotiation:</strong> The insurance company responds (usually with a lower counter-offer). Rounds of negotiation follow.</li>
<li><strong>Settlement or litigation:</strong> If a fair settlement is reached, the case resolves without a lawsuit. If not, we file suit.</li>
</ol>
<p><strong>Most cases settle before trial.</strong> Approximately 95% of personal injury cases resolve without going to verdict. But having an attorney prepared to try the case gives you leverage the insurance company respects.</p>

<h2>Filing the Lawsuit</h2>
<p>If settlement negotiations fail, your attorney files a Summons and Complaint in Charleston County Circuit Court:</p>
<ul>
<li><strong>Summons:</strong> Notifies the defendant that a lawsuit has been filed</li>
<li><strong>Complaint:</strong> Describes the facts of your case, the legal basis for your claim, and the damages you seek</li>
<li><strong>Filing fee:</strong> Paid to the Clerk of Court</li>
<li><strong>Service:</strong> The defendant must be formally served with the lawsuit documents</li>
</ul>

<h2>The Litigation Timeline</h2>
<table>
<thead>
<tr><th>Phase</th><th>Timeframe</th><th>What Happens</th></tr>
</thead>
<tbody>
<tr><td>Filing &amp; service</td><td>Months 1-2</td><td>Complaint filed, defendant served, answer due within 30 days</td></tr>
<tr><td>Discovery</td><td>Months 3-12</td><td>Interrogatories, depositions, document requests, medical record exchanges</td></tr>
<tr><td>Expert disclosure</td><td>Months 8-14</td><td>Medical experts, accident reconstructionists, economists provide opinions</td></tr>
<tr><td>Mediation</td><td>Months 12-18</td><td>Court-ordered settlement conference with a neutral mediator</td></tr>
<tr><td>Trial preparation</td><td>Months 16-22</td><td>Pre-trial motions, jury instructions, exhibit preparation</td></tr>
<tr><td>Trial</td><td>Months 18-24+</td><td>Jury selection, presentation of evidence, verdict</td></tr>
</tbody>
</table>
<p><strong>Total timeline:</strong> Most personal injury cases in Charleston County take 18-24 months from filing to resolution. Complex cases (multiple defendants, severe injuries) may take longer.</p>

<h2>What to Expect at Deposition</h2>
<p>During discovery, you will likely be deposed — questioned under oath by the defendant's attorney. Key guidelines:</p>
<ul>
<li>Tell the truth — you are under oath</li>
<li>Answer only the question asked — don't volunteer extra information</li>
<li>Say "I don't know" or "I don't remember" if true — never guess</li>
<li>Your attorney will be present and can object to improper questions</li>
<li>The deposition is recorded and can be used at trial</li>
</ul>

<h2>Mediation: The Most Likely Resolution Point</h2>
<p>Charleston County Circuit Court requires mediation in most civil cases. A neutral mediator facilitates settlement discussions. Key facts:</p>
<ul>
<li>Both sides present their case privately to the mediator</li>
<li>The mediator shuttles between rooms suggesting settlement ranges</li>
<li>Nothing said in mediation can be used at trial if it fails</li>
<li>A large percentage of cases settle at mediation — having a prepared attorney maximizes your result</li>
</ul>

<h2>Jury Trials in Charleston County</h2>
<p>If mediation fails, your case goes to a jury trial:</p>
<ul>
<li><strong>Jury selection (voir dire):</strong> 12 jurors selected from the Charleston County jury pool</li>
<li><strong>Opening statements:</strong> Both sides outline their case</li>
<li><strong>Plaintiff's case:</strong> Your attorney presents medical evidence, expert testimony, and witness accounts</li>
<li><strong>Defendant's case:</strong> The defense presents their evidence and experts</li>
<li><strong>Closing arguments:</strong> Both sides summarize</li>
<li><strong>Jury deliberation and verdict:</strong> The jury decides fault percentages and damage amounts</li>
</ul>

<h2>Statute of Limitations</h2>
<p>You must file your lawsuit within <strong>3 years</strong> of the date of injury (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). If you miss this deadline, your case is permanently barred. Special deadlines apply to claims against government entities (SC Tort Claims Act) and workers' compensation (2 years).</p>

<h2>Why an Experienced Local Attorney Matters</h2>
<p>Roden Law's attorneys practice regularly in Charleston County Circuit Court. We know the judges, the local rules, and the jury pool. This matters because:</p>
<ul>
<li>Local procedural rules affect scheduling, motions, and discovery deadlines</li>
<li>Charleston County jury tendencies inform case valuation and trial strategy</li>
<li>Relationships with mediators help facilitate productive settlement discussions</li>
<li>Familiarity with opposing attorneys and insurance defense firms informs negotiation approach</li>
</ul>
<p>Call <a href="tel:+18436126561">(843) 612-6561</a> for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'How long does a personal injury case take in Charleston County?',
                'answer'   => 'Most cases take 18-24 months from filing to resolution. Many settle during the pre-litigation phase (before a lawsuit is filed) or at court-ordered mediation. Complex cases with multiple defendants or severe injuries may take longer. Approximately 95% of cases resolve without going to a jury verdict.',
            ),
            array(
                'question' => 'Will I have to go to court?',
                'answer'   => 'Most likely not for trial — the vast majority of cases settle. However, you will need to attend your deposition (sworn testimony), possibly mediation, and any court hearings your attorney advises. If your case does go to trial, your testimony will be important.',
            ),
            array(
                'question' => 'What happens if we lose at trial?',
                'answer'   => 'If the jury finds in the defendant\'s favor (or finds you more than 50% at fault), you would not receive a verdict award. Because Roden Law works on contingency, you would owe no attorney fees in this scenario. You may still owe costs (expert fees, filing fees) depending on your fee agreement. Appeals are possible in some circumstances.',
            ),
        ),
    ),

    /* ============================================================
       3. Construction Zone Accident Rights
       ============================================================ */
    array(
        'title'   => 'North Charleston Construction Zone Accident Rights',
        'slug'    => 'construction-zone-accidents-north-charleston',
        'excerpt' => 'Guide to your legal rights after a construction zone accident in North Charleston. Covers the I-526 widening project, contractor liability, government claims under the SC Tort Claims Act, and enhanced work zone penalties.',
        'content' => <<<'HTML'
<h2>Your Rights After a Construction Zone Accident in North Charleston</h2>
<p>North Charleston's highways are in a state of perpetual construction. The multi-year <strong>I-526 Lowcountry Corridor widening project</strong>, recurring I-26 maintenance, Rivers Avenue intersection upgrades, and residential development road work create a maze of construction zones where crash risk increases 20-40% according to the <a href="https://www.fhwa.dot.gov/" target="_blank" rel="noopener">Federal Highway Administration</a>.</p>
<p>If you were injured in a construction zone crash, your claim may involve more defendants — and more available insurance — than a standard car accident. Here is what you need to know.</p>

<h2>The I-526 Widening Project: Special Risks</h2>
<p>The I-526 Lowcountry Corridor project is the largest active highway construction project in the Charleston area. Its work zones present specific dangers:</p>
<ul>
<li><strong>Shifting lane patterns:</strong> Traffic is rerouted through temporary lanes that change as construction phases progress</li>
<li><strong>Concrete barrier corridors:</strong> Jersey barriers line narrowed lanes, eliminating escape routes</li>
<li><strong>Reduced speed zones:</strong> Speed drops from 60+ mph to 45 mph, creating dangerous speed differentials between compliant and non-compliant drivers</li>
<li><strong>Temporary ramps and exits:</strong> Unfamiliar geometry confuses regular commuters</li>
<li><strong>Construction equipment:</strong> Slow-moving vehicles entering travel lanes from work areas</li>
<li><strong>Night work:</strong> Many construction activities occur at night, when reduced visibility compounds all other hazards</li>
</ul>

<h2>Who Can You Sue After a Work Zone Crash?</h2>

<h3>The At-Fault Driver</h3>
<p>Standard negligence claim — speeding through the zone, distracted driving, failure to merge, rear-ending stopped traffic. South Carolina doubles speeding fines in work zones when workers are present, reflecting the heightened duty of care.</p>

<h3>The Construction Contractor</h3>
<p>Private contractors are NOT protected by government immunity. They can be sued directly if:</p>
<ul>
<li>Signage was missing, incorrect, or placed too close to the hazard</li>
<li>The lane shift design was confusing or violated MUTCD standards</li>
<li>Temporary barriers were improperly placed or missing</li>
<li>Construction debris entered travel lanes</li>
<li>Flagging operations were inadequate or absent</li>
<li>Work zone lighting was insufficient for nighttime operations</li>
</ul>

<h3>SCDOT (Government Entity)</h3>
<p>If SCDOT approved an unsafe Traffic Management Plan (TMP), failed to enforce contractor compliance, or maintained a dangerous road condition, claims are possible under the <a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">South Carolina Tort Claims Act (S.C. Code § 15-78-80)</a>. Requirements:</p>
<ul>
<li>Written notice to the government entity</li>
<li>Compliance with specific procedural requirements</li>
<li>Must fall within a recognized exception to sovereign immunity</li>
</ul>

<h3>Traffic Control Subcontractors</h3>
<p>Many construction projects hire specialized traffic control companies to manage signage, flagging, and lane closures. If their negligence caused or contributed to your crash, they are independently liable.</p>

<h2>Evidence Specific to Work Zone Crashes</h2>
<p>Beyond standard accident evidence, work zone cases benefit from:</p>
<ul>
<li><strong>The Traffic Management Plan (TMP):</strong> A required document detailing exactly how traffic should be routed through the zone. Deviations from the TMP are evidence of negligence.</li>
<li><strong>MUTCD compliance:</strong> The Manual on Uniform Traffic Control Devices sets federal standards for work zone signage and lane markings. Non-compliance = negligence.</li>
<li><strong>Contractor daily logs:</strong> Record what work was performed, what traffic controls were in place, and any incidents</li>
<li><strong>SCDOT inspection reports:</strong> Government inspectors monitor contractor compliance</li>
<li><strong>Pre-crash photographs:</strong> Other drivers or construction workers may have photographed the zone layout before your crash</li>
</ul>

<h2>Enhanced Penalties = Stronger Claims</h2>
<p>South Carolina's enhanced penalty structure for work zone violations benefits your civil claim:</p>
<ul>
<li>Doubled fines establish that the law recognizes heightened danger in work zones</li>
<li>A speeding ticket in a work zone is powerful evidence of negligence</li>
<li>Reckless driving charges carry more weight when the driver was operating in a known hazardous area</li>
</ul>

<h2>Statute of Limitations</h2>
<ul>
<li><strong>Against drivers and private contractors:</strong> 3 years (S.C. Code § 15-3-530)</li>
<li><strong>Against government entities (SCDOT):</strong> Tort Claims Act notice requirements apply — contact an attorney immediately to ensure compliance</li>
</ul>
<p>Call Roden Law at <a href="tel:+18436126561">(843) 612-6561</a> for a free case evaluation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue the construction company for my I-526 work zone crash?',
                'answer'   => 'Yes. Private construction contractors are not protected by government immunity. If inadequate signage, confusing lane shifts, missing barriers, debris in travel lanes, or poor flagging operations contributed to your crash, the contractor may be directly liable for negligence. Their Traffic Management Plan and MUTCD compliance are key evidence.',
            ),
            array(
                'question' => 'Is SCDOT liable for work zone accidents?',
                'answer'   => 'Potentially. If SCDOT approved an unsafe Traffic Management Plan, failed to inspect or enforce contractor compliance, or maintained a known dangerous road condition, claims are possible under the SC Tort Claims Act. These claims have strict procedural requirements — contact an attorney immediately to preserve your rights.',
            ),
            array(
                'question' => 'What is a Traffic Management Plan and why does it matter for my case?',
                'answer'   => 'A Traffic Management Plan (TMP) is a required document that details exactly how traffic should be routed through a construction zone — lane configurations, signage placement, speed reductions, and flagging operations. If the contractor deviated from the approved TMP, that deviation is strong evidence of negligence in your crash.',
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

    WP_CLI::success( "CREATED: \"{$r['title']}\" (ID {$post_id}) → /resources/{$r['slug']}/" );
    $created++;
}

WP_CLI::log( '' );
WP_CLI::log( "Done. Created: {$created} | Skipped: {$skipped}" );
