<?php
/**
 * Seeder: E-Bike Accident Lawyers Pillar Page
 *
 * Creates one pillar page: E-Bike Accident Lawyers (e-bike-accident-lawyers)
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-ebike-pillar.php
 *
 * Idempotent — skips if the slug already exists.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

echo "SCRIPT START\n";
echo "WP_CLI exists: " . ( class_exists( 'WP_CLI' ) ? 'yes' : 'no' ) . "\n";

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
   Determine the practice_area post type slug
   ------------------------------------------------------------------ */

$pa_post_type = 'practice_area';
if ( ! post_type_exists( $pa_post_type ) ) {
    $pa_post_type = 'practice-area';
}
if ( ! post_type_exists( $pa_post_type ) ) {
    WP_CLI::error( 'Practice area post type not found.' );
    return;
}

/* ------------------------------------------------------------------
   Pillar definitions
   ------------------------------------------------------------------ */

echo "BEFORE PILLARS ARRAY\n";
$pillars = array(

    /* ============================================================
       1. E-Bike Accident Lawyers
       ============================================================ */
    array(
        'title'   => 'E-Bike Accident Lawyers',
        'slug'    => 'e-bike-accident-lawyers',
        'excerpt' => 'Injured in an e-bike accident in Georgia or South Carolina? Our attorneys fight for maximum compensation in cases involving vehicle collisions, battery fires, defective equipment, and all types of electric bicycle crashes.',
        'hero_intro' => 'E-bikes reach speeds of 20–28 mph with riders exposed to the same hazards as cyclists — but with nearly twice the injury severity. Research shows e-bike crashes produce traumatic brain injuries at double the rate of regular bicycle accidents and cranial hemorrhages at nearly five times the rate. Both Georgia and South Carolina have enacted specific e-bike statutes that affect your rights after a crash.',
        'why_hire' => '<p>E-bike accident cases are uniquely complex — liability may involve the driver who struck you, the e-bike manufacturer (especially in battery fire cases), a rental or tour company, or a government entity responsible for dangerous road conditions. Insurance companies routinely blame e-bike riders for traveling too fast or riding where they shouldn\'t, and an experienced attorney knows how to dismantle these defenses.</p><p>Georgia enacted HB 454 (effective July 1, 2019), creating a three-class e-bike system under <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-12/" target="_blank" rel="noopener">O.C.G.A. §§ 40-6-300 through 40-6-303</a>. Class I e-bikes are pedal-assist only up to 20 mph. Class II adds a throttle (still 20 mph max). Class III is pedal-assist up to 28 mph. All classes are capped at 750 watts. Georgia requires helmets for all ages on Class III e-bikes and restricts Class III riders to age 15 and older.</p><p>South Carolina takes a different approach under <a href="https://www.scstatehouse.gov/code/t56c001.php" target="_blank" rel="noopener">S.C. Code § 56-1-10(29)</a> (H.3174, effective February 3, 2020). South Carolina does not use a class system — instead, it defines an e-bike as a bicycle with a motor of 750 watts or less that cannot exceed 20 mph on motor power alone. E-bikes exceeding these thresholds may be reclassified as mopeds requiring registration and insurance. South Carolina has no statewide helmet law for e-bike riders, and riders have the same rights and duties as bicyclists under <a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-3520</a>.</p>',
        'content' => <<<'HTML'
<h2>E-Bike Accident Lawyers Serving Georgia &amp; South Carolina</h2>
<p>Electric bicycles have transformed transportation across Georgia and South Carolina, offering an efficient, accessible way to commute, exercise, and explore. But with their rapid adoption has come a surge in serious injuries. A peer-reviewed study analyzing CPSC data found 45,586 e-bike injuries requiring emergency department visits between 2017 and 2022 — a roughly 30-fold increase over that period. The higher speeds, heavier frames, and battery-related hazards of e-bikes make crashes significantly more dangerous than traditional bicycle accidents.</p>
<p>At <a href="/attorneys/eric-roden/">Roden Law</a>, our e-bike accident lawyers represent injured riders throughout Georgia and South Carolina. We understand the specific e-bike statutes in both states, the complex liability issues involving manufacturers and battery defects, and the severe injuries these crashes cause. If you or a loved one has been hurt in an e-bike accident, we fight for full compensation — on a contingency fee basis with no upfront costs.</p>

<h2>Georgia &amp; South Carolina E-Bike Laws</h2>
<p>Both states have enacted legislation specifically addressing electric bicycles, but their approaches differ significantly:</p>
<ul>
<li><strong>Georgia (O.C.G.A. §§ 40-6-300–303):</strong> Georgia uses a three-class system enacted in 2019. Class I e-bikes provide pedal-assist only up to 20 mph. Class II adds a throttle with a 20 mph cap. Class III provides pedal-assist up to 28 mph. All classes are limited to 750 watts. E-bikes are treated as bicycles, not motor vehicles, and do not require registration, insurance, or a driver's license. Helmets are required for all ages on Class III e-bikes, and riders must be at least 15 to operate a Class III.</li>
<li><strong>South Carolina (S.C. Code § 56-1-10(29)):</strong> South Carolina enacted H.3174 in 2020 with a single unified definition — no class system. An e-bike must have a motor of 750 watts or less and cannot exceed 20 mph under motor power alone. E-bikes meeting this definition are treated as bicycles. E-bikes exceeding the 750W or 20 mph thresholds may be reclassified as mopeds, requiring title, registration, and insurance. There is no statewide helmet requirement for e-bike riders.</li>
</ul>
<p>Understanding which law applies to your e-bike is critical. If your e-bike exceeds the statutory definition in either state, different rules — and potentially different liability standards — may apply to your accident claim.</p>

<h2>E-Bike Classifications: What You Need to Know</h2>
<p>Georgia's three-class system creates important distinctions that affect where you can ride, what safety equipment is required, and how your case is evaluated after an accident:</p>
<ul>
<li><strong>Class I (Pedal-Assist, 20 mph):</strong> The motor only engages when you pedal and cuts off at 20 mph. Allowed on roads, bike lanes, and most multi-use paths. Helmet required for riders under 16.</li>
<li><strong>Class II (Throttle-Assist, 20 mph):</strong> Includes a throttle that can propel the bike without pedaling, capped at 20 mph. Same access as Class I. Helmet required for riders under 16.</li>
<li><strong>Class III (Pedal-Assist, 28 mph):</strong> Pedal-assist up to 28 mph — significantly faster than Classes I and II. Restricted from certain multi-use paths. Helmet required for <strong>all ages</strong>. Minimum rider age of 15.</li>
</ul>
<p>South Carolina's single definition treats all qualifying e-bikes the same: 750 watts maximum, 20 mph maximum on motor power alone. An e-bike that exceeds either threshold — for example, a modified Class III capable of 28 mph — could be reclassified as a moped under South Carolina law, fundamentally changing the legal framework for a crash claim.</p>

<h2>Common Types of E-Bike Accidents</h2>
<p>Our attorneys handle the full spectrum of e-bike crash cases:</p>
<ul>
<li><strong>Vehicle collisions:</strong> Cars, trucks, and buses striking e-bike riders — the most common and most dangerous type of e-bike accident. Drivers frequently misjudge e-bike speed, expecting bicycle-pace travel and failing to yield</li>
<li><strong>Dooring accidents:</strong> Occupants of parked vehicles opening doors directly into the path of an approaching e-bike rider. At e-bike speeds of 20+ mph, the rider has almost no time to react</li>
<li><strong>Intersection crashes:</strong> Drivers running red lights, rolling through stop signs, or making turns across e-bike riders in <a href="/practice-areas/bicycle-accident-lawyers/">bike lanes</a>. Right-hook and left-cross collisions are especially common</li>
<li><strong>Road hazards:</strong> Potholes, railroad tracks, storm grates, gravel, and debris are more dangerous at e-bike speeds. A pothole that a traditional cyclist might navigate at 12 mph becomes far more hazardous at 25 mph</li>
<li><strong>Speed-related loss of control:</strong> Especially on Class III e-bikes reaching 28 mph, riders may lose control on curves, wet surfaces, or steep descents. The heavier weight of e-bikes (typically 50–70 lbs vs. 20–30 lbs for regular bikes) extends stopping distances</li>
<li><strong>Battery fires and explosions:</strong> Lithium-ion battery thermal runaway causing fires during charging, riding, or storage — a growing <a href="/practice-areas/product-liability-lawyers/">product liability</a> concern</li>
</ul>

<h2>E-Bike Battery Fires &amp; Product Liability</h2>
<p>Lithium-ion battery fires represent one of the most alarming risks in the e-bike industry. When a battery cell fails, it can trigger thermal runaway — a chain reaction where one failing cell overheats adjacent cells, causing rapid, uncontrollable fire and potentially violent explosions. These incidents can occur while charging, during a ride, or even while the e-bike is stored.</p>
<p>The <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">Consumer Product Safety Commission (CPSC)</a> has issued multiple e-bike battery recalls in 2024 and 2025, including recalls affecting Rad Power Bikes, FENGQS, and VIVI e-bikes. Battery fires have caused deaths, severe <a href="/practice-areas/burn-injury-lawyers/">burns</a>, property destruction, and house fires across the country.</p>
<p>Both Georgia and South Carolina provide strong legal remedies for victims of defective e-bike batteries:</p>
<ul>
<li><strong>Georgia strict product liability (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/section-51-1-11/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>):</strong> Manufacturers, distributors, and retailers can be held liable for injuries caused by defective products without requiring proof of negligence</li>
<li><strong>South Carolina strict product liability (<a href="https://www.scstatehouse.gov/code/t15c073.php" target="_blank" rel="noopener">S.C. Code § 15-73-10</a>):</strong> Sellers of products in a defective condition unreasonably dangerous to the user are strictly liable for resulting injuries</li>
</ul>
<p>Claims may be brought against the e-bike manufacturer, the battery cell manufacturer, the retailer, and any distributor in the chain of commerce. Our attorneys work with electrical engineering and battery experts to trace the cause of thermal runaway and build strong product liability cases.</p>

<h2>E-Bike Accident Injuries</h2>
<p>Research consistently shows that e-bike injuries are more severe than traditional bicycle injuries. A study published in <em>Injury Prevention</em> found that e-bike riders suffered <a href="/practice-areas/brain-injury-lawyers/">traumatic brain injuries</a> at a rate of 37.8% compared to 19.4% for conventional cyclists — nearly double. Cranial hemorrhages were 4.68 times more likely in e-bike crashes, and facial fractures occurred at 3.19 times the rate.</p>
<p>Common e-bike accident injuries include:</p>
<ul>
<li><strong>Traumatic brain injuries:</strong> The higher speeds of e-bikes dramatically increase TBI risk. Even helmeted riders suffer concussions and brain bleeding at elevated rates compared to regular cyclists</li>
<li><strong>Facial fractures:</strong> Jaw, orbital, and dental injuries are 3.19 times more common in e-bike crashes. Higher-speed impacts with vehicles, pavement, or fixed objects cause devastating facial trauma</li>
<li><strong>Burns from battery fires:</strong> Lithium-ion thermal runaway produces temperatures exceeding 1,000°F, causing severe thermal and chemical burns that may require extensive skin grafting and reconstructive surgery</li>
<li><strong><a href="/practice-areas/spinal-cord-injury-lawyers/">Spinal cord injuries</a>:</strong> The higher impact speeds in e-bike crashes cause vertebral fractures and spinal cord damage. Paralysis risk increases with collision speed</li>
<li><strong>Broken bones:</strong> Wrists, collarbones, pelvis, and leg fractures from higher-speed impacts. The heavier weight of e-bikes can also pin and injure riders in a fall</li>
<li><strong>Road rash and skin injuries:</strong> Higher speeds produce more severe abrasion injuries. Deep road rash often requires skin grafts and leaves permanent scarring</li>
<li><strong>Internal organ damage:</strong> Blunt force at 20–28 mph causes organ rupture, splenic laceration, and internal bleeding that may not be immediately apparent</li>
<li><strong><a href="/practice-areas/wrongful-death-lawyers/">Wrongful death</a>:</strong> E-bike fatalities are rising nationally as ridership increases. Families who lose a loved one in an e-bike crash can pursue wrongful death claims against all responsible parties</li>
</ul>

<h2>Pursuing Maximum Compensation</h2>
<p>E-bike accident cases often involve multiple defendants and multiple sources of insurance coverage. Our attorneys investigate every angle to identify all liable parties — the driver who struck you, the e-bike manufacturer, a rental company, a retailer who sold a recalled battery, or a government entity that failed to maintain safe road conditions.</p>
<p>Under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/" target="_blank" rel="noopener">O.C.G.A. Title 51</a>) and South Carolina law, e-bike accident victims may recover compensation for:</p>
<ul>
<li>All medical expenses (emergency care, surgery, rehabilitation, future treatment)</li>
<li>Lost wages and diminished earning capacity</li>
<li>Pain and suffering</li>
<li>Burn treatment and scarring from battery incidents</li>
<li>Permanent disability and loss of enjoyment of life</li>
<li>Wrongful death damages for surviving families</li>
<li>Punitive damages in cases involving drunk drivers, defective products, or egregious corporate negligence</li>
</ul>
<p>Georgia applies modified comparative fault — you can recover damages if you are less than 50% at fault (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>). South Carolina allows recovery if you are less than 51% at fault. Even if you were partially at fault — for example, not wearing a helmet or exceeding a speed limit — you may still recover significant compensation.</p>
<p>If you or a loved one has been injured in an e-bike accident in Georgia or South Carolina, contact Roden Law for a free consultation. We handle all e-bike accident cases on a contingency fee basis — you pay nothing unless we win.</p>
HTML,
        'category_name' => 'E-Bike Accidents',
        'category_slug' => 'e-bike-accidents',
        'sub_types' => array(
            'E-Bike vs. Vehicle Collisions',
            'E-Bike Battery Fire & Explosion Injuries',
            'E-Bike Defect & Product Liability Claims',
            'E-Bike Dooring Accidents',
            'E-Bike Intersection Crashes',
            'E-Bike Road Hazard Crashes',
            'E-Bike Rental & Tour Accidents',
            'E-Bike DUI Accidents',
        ),
        'common_causes' => array(
            'Distracted drivers striking e-bike riders',
            'Drivers misjudging e-bike speed and failing to yield',
            'Dooring (opening car doors into e-bike path)',
            'Intersection collisions (running red lights, failure to yield)',
            'Road hazards (potholes, railroad tracks, debris) at higher e-bike speeds',
            'Lithium-ion battery thermal runaway (fires/explosions)',
            'Defective brakes, motors, or controllers',
            'Rider inexperience with higher speeds and heavier weight',
            'Right-hook turns across e-bike riders in bike lanes',
            'Rear-end collisions from drivers not seeing e-bikes',
            'Riding at night without proper lighting',
            'Speed-related loss of control (especially Class III at 28 mph)',
        ),
        'common_injuries' => array(
            array( 'name' => 'Traumatic Brain Injuries (TBI)', 'description' => 'E-bike riders suffer TBIs at a rate of 37.8% compared to 19.4% for conventional cyclists — nearly double. Cranial hemorrhages are 4.68 times more likely in e-bike crashes due to higher impact speeds. Even helmeted riders face elevated TBI risk at 20–28 mph.' ),
            array( 'name' => 'Facial Fractures', 'description' => 'E-bike crashes produce facial fractures at 3.19 times the rate of regular bicycle accidents. Jaw fractures, orbital fractures, and dental injuries are common when riders strike vehicles, pavement, or fixed objects at e-bike speeds.' ),
            array( 'name' => 'Burns from Battery Fires', 'description' => 'Lithium-ion thermal runaway produces temperatures exceeding 1,000°F, causing severe thermal and chemical burns. Battery fires can occur during charging, riding, or storage, and may require extensive skin grafting and reconstructive surgery.' ),
            array( 'name' => 'Spinal Cord Injuries', 'description' => 'Higher e-bike impact speeds increase the risk of vertebral fractures, herniated discs, and spinal cord damage. Collisions at 20–28 mph can cause partial or complete paralysis requiring lifelong medical care.' ),
            array( 'name' => 'Broken Bones (Extremities)', 'description' => 'Wrists, collarbones, pelvis, and leg fractures are common in e-bike crashes. The heavier weight of e-bikes (50–70 lbs) compared to regular bicycles adds force to impacts and can pin riders during falls.' ),
            array( 'name' => 'Road Rash and Skin Injuries', 'description' => 'Higher e-bike speeds produce more severe abrasion injuries than traditional bicycle crashes. Deep road rash at 20+ mph often penetrates through skin and muscle, requiring skin grafts and leaving permanent scarring.' ),
            array( 'name' => 'Internal Organ Damage', 'description' => 'Blunt force trauma at e-bike speeds of 20–28 mph can rupture the spleen, lacerate the liver, or damage kidneys. Internal injuries may not be immediately apparent and require emergency surgical intervention.' ),
            array( 'name' => 'Wrongful Death', 'description' => 'E-bike fatalities are rising as ridership increases nationwide. Families who lose a loved one in an e-bike crash — whether from a vehicle collision, battery fire, or defective equipment — can pursue wrongful death claims in Georgia or South Carolina.' ),
        ),
        'faqs' => array(
            array( 'question' => 'What are the e-bike laws in Georgia?', 'answer' => 'Georgia uses a three-class system under O.C.G.A. §§ 40-6-300 through 40-6-303 (effective July 1, 2019). Class I is pedal-assist to 20 mph, Class II adds a throttle (20 mph), and Class III is pedal-assist to 28 mph. All are capped at 750 watts. E-bikes are treated as bicycles — no license, registration, or insurance required. Helmets are required for all ages on Class III e-bikes, and riders must be at least 15 for Class III.' ),
            array( 'question' => 'What are the e-bike laws in South Carolina?', 'answer' => 'South Carolina defines e-bikes under S.C. Code § 56-1-10(29) (H.3174, effective February 3, 2020) with a single definition — no class system. An e-bike must have a motor of 750 watts or less and cannot exceed 20 mph on motor power alone. E-bikes meeting this definition are treated as bicycles. Those exceeding the thresholds may be reclassified as mopeds requiring registration. There is no statewide helmet requirement.' ),
            array( 'question' => 'Can I sue the e-bike manufacturer if the battery caught fire?', 'answer' => 'Yes. Both Georgia (O.C.G.A. § 51-1-11) and South Carolina (S.C. Code § 15-73-10) impose strict product liability on manufacturers, distributors, and retailers of defective products. The CPSC has issued multiple e-bike battery recalls in 2024–2025 affecting brands like Rad Power Bikes, FENGQS, and VIVI. You may have claims against the e-bike manufacturer, the battery cell manufacturer, and the retailer.' ),
            array( 'question' => 'Do I need a license to ride an e-bike?', 'answer' => 'No. In both Georgia and South Carolina, e-bikes that meet the statutory definitions are classified as bicycles, not motor vehicles. No driver\'s license, registration, or insurance is required. However, if your e-bike exceeds the legal definition (750W or speed limits), it may be reclassified as a moped or motor vehicle.' ),
            array( 'question' => 'Are helmets required for e-bike riders?', 'answer' => 'In Georgia, helmets are required for all ages on Class III e-bikes (28 mph pedal-assist) and for riders under 16 on Class I and II e-bikes. South Carolina has no statewide helmet law for e-bike riders. Not wearing a helmet does not bar your claim in either state, but it may be raised as comparative fault for head injuries.' ),
            array( 'question' => 'How long do I have to file an e-bike accident claim?', 'answer' => 'Georgia has a 2-year statute of limitations (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Product liability claims involving defective batteries or components may have additional considerations. Contact an attorney promptly to preserve evidence — surveillance footage and electronic data can be lost quickly.' ),
            array( 'question' => 'Can I get a DUI on an e-bike?', 'answer' => 'In Georgia, DUI laws apply broadly to "vehicles," and an e-bike may qualify — meaning you could potentially face DUI charges while riding an e-bike on public roads. In South Carolina, the law is less clear: e-bikes are defined as bicycles, but the motor creates a legal gray area. Regardless, riding under the influence increases your comparative fault in a civil injury claim.' ),
            array( 'question' => 'What compensation can I recover after an e-bike accident?', 'answer' => 'E-bike accident victims may recover medical expenses (including future treatment), lost wages, pain and suffering, burn treatment and scarring from battery incidents, permanent disability, loss of enjoyment of life, and wrongful death damages for surviving families. Punitive damages may apply in cases involving drunk drivers, defective products, or egregious negligence.' ),
        ),
    ),

); // end $pillars array

/* ------------------------------------------------------------------
   INSERT POSTS
   ------------------------------------------------------------------ */

echo "PILLARS COUNT: " . count( $pillars ) . "\n";
$created = 0;
$skipped = 0;

foreach ( $pillars as $p ) {
    echo "Processing: {$p['slug']}\n";

    // Check if slug already exists.
    $existing = get_posts( array(
        'post_type'   => $pa_post_type,
        'name'        => $p['slug'],
        'post_parent' => 0,
        'post_status' => array( 'publish', 'draft', 'pending', 'private', 'trash' ),
        'numberposts' => 1,
    ) );

    echo "Existing count: " . count( $existing ) . "\n";

    if ( ! empty( $existing ) ) {
        echo "SKIP: already exists ID {$existing[0]->ID}\n";
        WP_CLI::log( "  SKIP: \"{$p['title']}\" already exists (ID {$existing[0]->ID})" );
        $skipped++;
        continue;
    }

    echo "Inserting...\n";
    $post_id = wp_insert_post( array(
        'post_type'    => $pa_post_type,
        'post_title'   => wp_strip_all_tags( html_entity_decode( $p['title'], ENT_QUOTES, 'UTF-8' ) ),
        'post_name'    => $p['slug'],
        'post_content' => $p['content'],
        'post_excerpt' => $p['excerpt'],
        'post_status'  => 'publish',
        'post_parent'  => 0,
        'post_author'  => 1,
    ), true );

    if ( is_wp_error( $post_id ) ) {
        echo "FAIL: " . $post_id->get_error_message() . "\n";
        WP_CLI::warning( "  FAIL: \"{$p['title']}\" — " . $post_id->get_error_message() );
        continue;
    }
    echo "Created ID: {$post_id}\n";

    // Meta fields.
    update_post_meta( $post_id, '_roden_jurisdiction', 'both' );
    update_post_meta( $post_id, '_roden_sol_ga', 'O.C.G.A. § 9-3-33' );
    update_post_meta( $post_id, '_roden_sol_sc', 'S.C. Code § 15-3-530' );
    update_post_meta( $post_id, '_roden_hero_intro', $p['hero_intro'] );
    update_post_meta( $post_id, '_roden_why_hire', $p['why_hire'] );
    update_post_meta( $post_id, '_roden_faqs', $p['faqs'] );
    update_post_meta( $post_id, '_roden_common_causes', $p['common_causes'] );
    update_post_meta( $post_id, '_roden_common_injuries', $p['common_injuries'] );
    update_post_meta( $post_id, '_roden_sub_types', implode( "\n", $p['sub_types'] ) );

    if ( $author_attorney_id ) {
        update_post_meta( $post_id, '_roden_author_attorney', $author_attorney_id );
    }

    // Taxonomy.
    $cat_term = term_exists( $p['category_slug'], 'practice_category' );
    if ( ! $cat_term ) {
        $cat_term = wp_insert_term( $p['category_name'], 'practice_category', array( 'slug' => $p['category_slug'] ) );
    }
    $cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;
    if ( $cat_term_id ) {
        wp_set_object_terms( $post_id, (int) $cat_term_id, 'practice_category' );
    }

    WP_CLI::success( "  CREATED: \"{$p['title']}\" (ID {$post_id}) at /practice-areas/{$p['slug']}/" );
    $created++;
}

WP_CLI::log( '' );
WP_CLI::success( "Done. Created: {$created}, Skipped: {$skipped}" );
WP_CLI::log( 'Run: wp rewrite flush' );
