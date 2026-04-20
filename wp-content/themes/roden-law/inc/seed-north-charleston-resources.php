<?php
/**
 * Seeder: North Charleston Resource Pages (Phase 1)
 *
 * Creates 2 resource posts targeting North Charleston informational keywords:
 *   1. Most Dangerous Roads & Intersections in North Charleston
 *   2. What to Do After a Car Accident in North Charleston, SC
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-north-charleston-resources.php
 *
 * Idempotent — skips any post whose slug already exists.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Look up Graeham Gillin's attorney post ID for author attribution
   (North Charleston office's lead attorney)
   ------------------------------------------------------------------ */

$graeham = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_attorney_id = $graeham ? $graeham->ID : 0;
if ( $author_attorney_id ) {
    WP_CLI::log( "Author attorney: Graeham C. Gillin (ID {$author_attorney_id})" );
} else {
    WP_CLI::warning( 'Attorney "graeham-c-gillin" not found — _roden_author_attorney will be empty.' );
}

/* ------------------------------------------------------------------
   Ensure practice_category terms exist
   ------------------------------------------------------------------ */

$cat_car = term_exists( 'car-accidents', 'practice_category' );
if ( ! $cat_car ) {
    $cat_car = wp_insert_term( 'Car Accidents', 'practice_category', array( 'slug' => 'car-accidents' ) );
}
$cat_car_id = is_array( $cat_car ) ? $cat_car['term_id'] : $cat_car;

/* ------------------------------------------------------------------
   Resource definitions
   ------------------------------------------------------------------ */

$resources = array(

    /* ============================================================
       1. Most Dangerous Roads & Intersections in North Charleston
       ============================================================ */
    array(
        'title'   => 'Most Dangerous Roads & Intersections in North Charleston, SC',
        'slug'    => 'dangerous-roads-north-charleston',
        'excerpt' => 'Data-driven guide to the most dangerous roads and intersections in North Charleston, South Carolina. Ashley Phosphate & I-26, Rivers Avenue & I-526, Dorchester Road crash statistics and what to do if you are injured.',
        'content' => <<<'HTML'
<h2>North Charleston's Most Dangerous Roads and Intersections</h2>
<p>North Charleston consistently ranks among the most dangerous areas in South Carolina for traffic collisions. With a population exceeding 131,000 and major freight corridors bisecting residential neighborhoods, the city sees a disproportionate share of serious and fatal crashes. According to the <a href="https://www.scdps.sc.gov/" target="_blank" rel="noopener">South Carolina Department of Public Safety (SCDPS)</a>, Charleston County records hundreds of injury crashes annually, with North Charleston corridors accounting for a significant percentage.</p>

<h2>Ashley Phosphate Road &amp; I-26: South Carolina's Deadliest Intersection</h2>
<p>The intersection of Ashley Phosphate Road and I-26 is the most dangerous intersection in all of South Carolina, according to SCDPS collision reports. On average, a crash occurs at this intersection once every three days. Multiple left turn lanes, heavy commercial traffic, and drivers running red lights create hazardous conditions at all hours. Common crash types include:</p>
<ul>
<li><strong>Left-turn collisions</strong> — Vehicles turning across multiple lanes of opposing traffic</li>
<li><strong>Rear-end crashes</strong> — Sudden stops at red lights during high-speed approaches from I-26 off-ramps</li>
<li><strong>T-bone accidents</strong> — Red-light runners striking vehicles entering the intersection on green</li>
<li><strong>Pedestrian strikes</strong> — Pedestrians crossing the wide, multi-lane road face long exposure times</li>
</ul>
<p>If you were injured at the Ashley Phosphate/I-26 intersection, Roden Law's <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> handles these cases regularly and understands the specific traffic engineering failures that contribute to crashes here.</p>

<h2>I-26/I-526 Interchange</h2>
<p>The interchange where Interstate 26 meets Interstate 526 recorded 354 collisions over a five-year period, making it one of the highest-volume crash locations in the Lowcountry. The interchange demands rapid lane changes, merges at highway speed, and navigation of construction zones related to the ongoing I-526 widening project. Truck traffic from the Port of Charleston amplifies the severity — a collision involving an 80,000-pound tractor-trailer at 60+ mph produces catastrophic injuries.</p>

<h2>Rivers Avenue &amp; I-526</h2>
<p>The intersection of Rivers Avenue (US-52) and I-526 led the tri-county area in injuries over a five-year study period, with 62 people injured in collisions at this single location. Rivers Avenue is North Charleston's primary commercial corridor — a high-volume, multi-lane road carrying a mix of passenger vehicles, commercial trucks, and transit buses through dense retail and industrial zones. Contributing factors include:</p>
<ul>
<li>High speed differentials between highway traffic exiting I-526 and surface-street traffic</li>
<li>Heavy truck traffic from nearby industrial and port-related facilities</li>
<li>Frequent lane changes near shopping centers and fast-food drive-throughs</li>
<li>Inadequate pedestrian infrastructure despite adjacent bus stops</li>
</ul>

<h2>I-526 &amp; Leeds Avenue</h2>
<p>This interchange is especially hazardous due to merging trucks from the nearby port, sudden lane changes by commuters, and heavy traffic from the Boeing South Carolina facility. The weaving pattern required to enter and exit I-526 at Leeds Avenue creates conflict points where vehicles traveling at highway speed must cross paths with slower-moving merging traffic.</p>

<h2>Dorchester Road Corridor</h2>
<p>Dorchester Road between Ashley Phosphate Road and Ladson carries heavy commuter traffic through a mix of residential, commercial, and industrial zones. The corridor has seen multiple fatal motorcycle and pedestrian crashes. A concrete truck drove off the I-26 overpass near Dorchester Road, and fatal motorcycle-versus-truck collisions have occurred at the Forest Hills Drive intersection. Limited shoulders, aging road surfaces, and a lack of dedicated turn lanes contribute to the danger.</p>

<h2>Rivers Avenue (Full Corridor)</h2>
<p>Beyond the I-526 interchange, Rivers Avenue from Aviation Avenue to Remount Road is one of the most crash-prone corridors in North Charleston. Overturned cement trucks, high-speed rear-end collisions, and pedestrian fatalities are reported regularly. The road's width (up to 6 lanes in sections) encourages dangerous speeds while its dense commercial development generates constant turning conflicts.</p>

<h2>What to Do If You Are Injured on a North Charleston Road</h2>
<ol>
<li><strong>Call 911 immediately</strong> — A police report documents the scene and establishes fault</li>
<li><strong>Seek medical attention</strong> — Go to Trident Medical Center or Roper St. Francis even if injuries seem minor</li>
<li><strong>Document the scene</strong> — Photograph vehicle positions, road conditions, traffic signals, and injuries</li>
<li><strong>Do not admit fault</strong> — Under South Carolina's comparative fault rule, anything you say may reduce your recovery</li>
<li><strong>Contact an attorney before speaking to insurance</strong> — Insurance adjusters are trained to minimize payouts</li>
</ol>

<h2>Your Legal Rights After a Crash in North Charleston</h2>
<p>Under South Carolina law (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>), you have <strong>3 years</strong> from the date of your injury to file a personal injury lawsuit. South Carolina's modified comparative fault rule allows recovery as long as you are less than 51% at fault for the accident — your compensation is reduced by your percentage of responsibility.</p>
<p>Cases involving dangerous road design or maintenance failures may also allow claims against government entities, but these require a <strong>shorter notice period</strong> under the South Carolina Tort Claims Act (<a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">S.C. Code § 15-78-80</a>). Contact an attorney promptly to preserve all available claims.</p>

<h2>Why Road Design Matters in Your Injury Case</h2>
<p>Dangerous intersections are not simply the result of bad drivers. <strong>Road design deficiencies</strong> — inadequate turn lanes, poor sight lines, missing traffic signals, and outdated lane configurations — contribute to crash frequency and severity. When a government entity or private developer knew or should have known about a dangerous condition and failed to address it, they may bear liability for resulting injuries. Roden Law investigates road design factors in every North Charleston crash case.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the most dangerous intersection in North Charleston?',
                'answer'   => 'The intersection of Ashley Phosphate Road and I-26 is the most dangerous intersection in South Carolina, averaging a crash once every three days according to SCDPS data. The Rivers Avenue and I-526 interchange is the deadliest in terms of injuries, with 62 people injured over a five-year period.',
            ),
            array(
                'question' => 'Can I sue the city for a crash caused by a dangerous road?',
                'answer'   => 'Potentially, yes. Under the South Carolina Tort Claims Act (S.C. Code § 15-78-80), government entities can be held liable for dangerous road conditions they knew or should have known about. However, notice requirements are strict — you must notify the government within a specific timeframe, making prompt legal consultation essential.',
            ),
            array(
                'question' => 'How many car accidents happen in North Charleston each year?',
                'answer'   => 'Charleston County records hundreds of injury-producing crashes annually, with North Charleston corridors including I-26, I-526, Rivers Avenue, and Ashley Phosphate Road accounting for a significant portion. The I-26/I-526 interchange alone recorded 354 collisions over a five-year study period.',
            ),
            array(
                'question' => 'What should I do if I am in an accident on I-26 in North Charleston?',
                'answer'   => 'Call 911 immediately, move to safety if possible, seek medical attention (Trident Medical Center is the closest Level II trauma center), document the scene with photographs, and contact a personal injury attorney before providing statements to insurance companies. Under South Carolina law, you have 3 years to file a claim (S.C. Code § 15-3-530).',
            ),
            array(
                'question' => 'Why is Rivers Avenue so dangerous?',
                'answer'   => 'Rivers Avenue combines high traffic volume, wide multi-lane configuration (encouraging speed), dense commercial development (generating constant turning conflicts), heavy truck traffic from port and industrial facilities, and inadequate pedestrian infrastructure. This mix creates frequent rear-end collisions, turning crashes, pedestrian strikes, and truck rollovers.',
            ),
        ),
        'categories' => array( $cat_car_id ),
    ),

    /* ============================================================
       2. What to Do After a Car Accident in North Charleston, SC
       ============================================================ */
    array(
        'title'   => 'What to Do After a Car Accident in North Charleston, SC',
        'slug'    => 'what-to-do-after-car-accident-north-charleston',
        'excerpt' => 'Step-by-step guide for what to do immediately after a car accident in North Charleston, South Carolina. Learn how to protect your legal rights, when to call police, what evidence to gather, and how South Carolina injury law affects your claim.',
        'content' => <<<'HTML'
<h2>Immediate Steps After a Car Accident in North Charleston</h2>
<p>The actions you take in the minutes and hours after a car accident directly affect your ability to recover compensation under South Carolina law. North Charleston's high-traffic corridors — I-26, I-526, Rivers Avenue, Ashley Phosphate Road, and Dorchester Road — produce hundreds of injury crashes every year. Here is exactly what to do if you are involved in one.</p>

<h2>Step 1: Check for Injuries and Call 911</h2>
<p>Your first priority is safety. Check yourself and passengers for injuries. Call 911 even if the accident seems minor — South Carolina law (<a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-1210</a>) requires that you remain at the scene and report any accident involving injury, death, or property damage exceeding $1,000. The responding North Charleston Police Department officer will create an official crash report, which becomes critical evidence in your claim.</p>

<h2>Step 2: Move to Safety</h2>
<p>If your vehicle is operable and blocking traffic — especially on high-speed roads like I-26 or I-526 — South Carolina law allows you to move vehicles to the shoulder to prevent secondary crashes. However, document the vehicle positions before moving if possible (photograph from a safe distance).</p>

<h2>Step 3: Exchange Information</h2>
<p>Collect from all other drivers involved:</p>
<ul>
<li>Full name, address, and phone number</li>
<li>Driver's license number and state</li>
<li>Insurance company and policy number</li>
<li>Vehicle make, model, year, color, and license plate</li>
<li>Names and contact information of all passengers</li>
</ul>
<p>For <a href="/truck-accident-lawyers/north-charleston-sc/">truck accidents</a>, also note the trucking company name, USDOT number (displayed on the cab), and trailer number.</p>

<h2>Step 4: Document the Scene</h2>
<p>Use your phone to photograph:</p>
<ul>
<li>All vehicle damage from multiple angles</li>
<li>The overall scene showing road conditions, lane markings, and traffic signals</li>
<li>Skid marks, debris, and fluid spills on the road</li>
<li>Traffic signs and speed limit postings</li>
<li>Weather and lighting conditions</li>
<li>Your visible injuries (bruising, cuts, swelling)</li>
<li>The other driver's license plate and insurance card</li>
</ul>
<p>This evidence is particularly important at known dangerous locations like the Ashley Phosphate/I-26 intersection, where crash frequency suggests recurring road design issues.</p>

<h2>Step 5: Get Witness Information</h2>
<p>If bystanders witnessed the accident, ask for their names and phone numbers. Independent witness testimony can be decisive in disputed-fault cases, especially at complex intersections like Rivers Avenue and I-526 where multiple lanes and merging patterns make fault determination difficult.</p>

<h2>Step 6: Seek Medical Attention Promptly</h2>
<p>Even if you feel fine at the scene, see a doctor within 24-48 hours. Adrenaline masks pain, and many serious injuries — including traumatic brain injuries, whiplash, and internal bleeding — have delayed symptom onset. North Charleston's closest trauma and emergency facilities include:</p>
<ul>
<li><strong>Trident Medical Center</strong> — 9330 Medical Plaza Dr, North Charleston, SC 29406 — (843) 797-7000</li>
<li><strong>MUSC Health</strong> — 171 Ashley Ave, Charleston, SC 29425 — (843) 792-2300</li>
<li><strong>Roper St. Francis</strong> — 316 Calhoun St, Charleston, SC 29401 — (843) 724-2000</li>
</ul>
<p>A gap between the accident and medical treatment gives insurance companies grounds to argue that your injuries were not caused by the crash. Close this gap immediately.</p>

<h2>Step 7: Report to Your Insurance Company</h2>
<p>Notify your own insurance company of the accident, but keep your statement brief and factual. Do not speculate about fault, do not minimize your injuries, and do not give a recorded statement to the <em>other driver's</em> insurance company without legal counsel. Their adjuster's job is to minimize what they pay you.</p>

<h2>Step 8: Contact a Personal Injury Attorney</h2>
<p>Consult an attorney before accepting any settlement offer. Insurance companies routinely extend quick lowball offers hoping you will accept before understanding the full extent of your injuries. An experienced <a href="/car-accident-lawyers/north-charleston-sc/">North Charleston car accident lawyer</a> will:</p>
<ul>
<li>Calculate the true value of your claim (medical bills, lost wages, pain and suffering, future care)</li>
<li>Preserve evidence before it disappears (surveillance footage, black box data, road conditions)</li>
<li>Handle all communication with insurance companies</li>
<li>File suit within the statute of limitations if a fair settlement cannot be reached</li>
</ul>

<h2>Key South Carolina Laws That Affect Your Claim</h2>
<h3>Statute of Limitations: 3 Years</h3>
<p>Under <a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>, you have <strong>3 years</strong> from the date of your accident to file a personal injury lawsuit. Miss this deadline and your claim is permanently barred, regardless of how strong your case is.</p>

<h3>Modified Comparative Fault</h3>
<p>South Carolina follows a modified comparative fault rule. You can recover damages as long as you were <strong>less than 51% at fault</strong> for the accident. Your recovery is reduced by your percentage of fault. For example, if your damages total $100,000 and you were 20% at fault, you recover $80,000.</p>

<h3>Uninsured/Underinsured Motorist Coverage</h3>
<p>South Carolina requires insurance companies to offer UM/UIM coverage. If the at-fault driver has no insurance or insufficient coverage, your own UM/UIM policy may cover the difference. Check your policy — this coverage is critical in a state where approximately 9% of drivers are uninsured.</p>

<h2>Common Mistakes That Hurt Your Claim</h2>
<ul>
<li><strong>Posting on social media</strong> — Insurance companies monitor your Facebook and Instagram for posts that contradict your injury claims</li>
<li><strong>Giving a recorded statement</strong> — The other driver's insurer will use your words against you</li>
<li><strong>Accepting a quick settlement</strong> — Early offers rarely account for future medical needs or long-term impacts</li>
<li><strong>Failing to follow up with medical care</strong> — Gaps in treatment suggest your injuries are not serious</li>
<li><strong>Waiting too long</strong> — Evidence degrades, witnesses forget, and the 3-year deadline arrives faster than expected</li>
</ul>

<h2>Free Case Review</h2>
<p>Roden Law's <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> on Spruill Avenue offers free case consultations for accident victims. We work on contingency — you pay nothing unless we recover compensation for you. Call <a href="tel:+18436126561">(843) 612-6561</a> or fill out our online form today.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Do I need a lawyer after a car accident in North Charleston?',
                'answer'   => 'While not legally required, hiring an attorney significantly increases your recovery. Insurance companies have teams of adjusters and attorneys working to minimize your payout. An experienced car accident lawyer handles evidence preservation, claim valuation, and negotiation — and studies consistently show represented claimants recover more than unrepresented ones, even after attorney fees.',
            ),
            array(
                'question' => 'How long do I have to file a car accident claim in South Carolina?',
                'answer'   => 'You have 3 years from the date of the accident to file a personal injury lawsuit under S.C. Code § 15-3-530. However, evidence degrades over time — surveillance footage is overwritten, witnesses forget details, and vehicle damage is repaired. Contact an attorney as soon as possible to preserve your claim.',
            ),
            array(
                'question' => 'Should I go to the hospital after a minor car accident?',
                'answer'   => 'Yes. Many serious injuries — including concussions, whiplash, herniated discs, and internal bleeding — may not show symptoms immediately. Medical documentation within 24-48 hours of the accident also strengthens your legal claim by establishing a direct link between the crash and your injuries. Trident Medical Center and MUSC Health are the closest facilities to most North Charleston accident locations.',
            ),
            array(
                'question' => 'What if the other driver does not have insurance?',
                'answer'   => 'Your own uninsured/underinsured motorist (UM/UIM) coverage may apply. South Carolina law requires insurers to offer this coverage. If you carry UM/UIM on your policy, it can cover your medical expenses, lost wages, and pain and suffering when the at-fault driver is uninsured. An attorney can help you file this claim with your own insurer.',
            ),
            array(
                'question' => 'How much is my North Charleston car accident case worth?',
                'answer'   => 'Case value depends on the severity of your injuries, medical expenses, lost income, permanence of injury, and impact on daily life. Roden Law has recovered over $250 million for clients. We evaluate every case individually during a free consultation — there is no obligation and no fee unless we win.',
            ),
        ),
        'categories' => array( $cat_car_id ),
    ),
);

/* ------------------------------------------------------------------
   Create posts
   ------------------------------------------------------------------ */

$created = 0;
$skipped = 0;

foreach ( $resources as $r ) {
    // Check if slug already exists
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

    // Meta fields
    update_post_meta( $post_id, '_roden_author_attorney', $author_attorney_id );
    update_post_meta( $post_id, '_roden_jurisdiction', 'sc' );

    // FAQs
    if ( ! empty( $r['faqs'] ) ) {
        update_post_meta( $post_id, '_roden_faqs', $r['faqs'] );
    }

    // Taxonomy
    if ( ! empty( $r['categories'] ) ) {
        wp_set_object_terms( $post_id, array_map( 'intval', $r['categories'] ), 'practice_category' );
    }

    WP_CLI::success( "CREATED: \"{$r['title']}\" (ID {$post_id}) → /resources/{$r['slug']}/" );
    $created++;
}

WP_CLI::log( '' );
WP_CLI::log( "Done. Created: {$created} | Skipped: {$skipped}" );
