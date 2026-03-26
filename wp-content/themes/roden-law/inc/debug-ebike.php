<?php
/**
 * Update e-bike pillar page (ID 4579) with full content and meta.
 * Run: wp eval-file wp-content/themes/roden-law/inc/debug-ebike.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$post_id = 4579;
$post = get_post( $post_id );
if ( ! $post ) {
    echo "Post {$post_id} not found\n";
    return;
}
echo "Updating post {$post_id}: {$post->post_title}\n";

// Eric Roden
$eric = get_page_by_path( 'eric-roden', OBJECT, 'attorney' );
$author_id = $eric ? $eric->ID : 0;
echo "Author: Eric Roden ID {$author_id}\n";

// Full content
$content = file_get_contents( __DIR__ . '/ebike-content.html' );
if ( ! $content ) {
    echo "ERROR: Could not read ebike-content.html\n";
    return;
}
echo "Content loaded: " . strlen( $content ) . " bytes\n";

// Update post content
wp_update_post( array(
    'ID'           => $post_id,
    'post_content' => $content,
    'post_excerpt' => 'Injured in an e-bike accident in Georgia or South Carolina? Our attorneys fight for maximum compensation in cases involving vehicle collisions, battery fires, defective equipment, and all types of electric bicycle crashes.',
) );

// Hero intro
update_post_meta( $post_id, '_roden_hero_intro', 'E-bikes reach speeds of 20-28 mph with riders exposed to the same hazards as cyclists — but with nearly twice the injury severity. Research shows e-bike crashes produce traumatic brain injuries at double the rate of regular bicycle accidents and cranial hemorrhages at nearly five times the rate. Both Georgia and South Carolina have enacted specific e-bike statutes that affect your rights after a crash.' );

// Why hire
$why_hire = '<p>E-bike accident cases are uniquely complex — liability may involve the driver who struck you, the e-bike manufacturer (especially in battery fire cases), a rental or tour company, or a government entity responsible for dangerous road conditions. Insurance companies routinely blame e-bike riders for traveling too fast or riding where they shouldn\'t, and an experienced attorney knows how to dismantle these defenses.</p>';
$why_hire .= '<p>Georgia enacted HB 454 (effective July 1, 2019), creating a three-class e-bike system under <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-12/" target="_blank" rel="noopener">O.C.G.A. &sect;&sect; 40-6-300 through 40-6-303</a>. Class I e-bikes are pedal-assist only up to 20 mph. Class II adds a throttle (still 20 mph max). Class III is pedal-assist up to 28 mph. All classes are capped at 750 watts. Georgia requires helmets for all ages on Class III e-bikes and restricts Class III riders to age 15 and older.</p>';
$why_hire .= '<p>South Carolina takes a different approach under <a href="https://www.scstatehouse.gov/code/t56c001.php" target="_blank" rel="noopener">S.C. Code &sect; 56-1-10(29)</a> (H.3174, effective February 3, 2020). South Carolina does not use a class system — instead, it defines an e-bike as a bicycle with a motor of 750 watts or less that cannot exceed 20 mph on motor power alone. E-bikes exceeding these thresholds may be reclassified as mopeds requiring registration and insurance. South Carolina has no statewide helmet law for e-bike riders, and riders have the same rights and duties as bicyclists under <a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code &sect; 56-5-3520</a>.</p>';
update_post_meta( $post_id, '_roden_why_hire', $why_hire );

// Jurisdiction and SOL
update_post_meta( $post_id, '_roden_jurisdiction', 'both' );
update_post_meta( $post_id, '_roden_sol_ga', 'O.C.G.A. § 9-3-33' );
update_post_meta( $post_id, '_roden_sol_sc', 'S.C. Code § 15-3-530' );

// Author
if ( $author_id ) {
    update_post_meta( $post_id, '_roden_author_attorney', $author_id );
}

// FAQs
$faqs = array(
    array( 'question' => 'What are the e-bike laws in Georgia?', 'answer' => 'Georgia uses a three-class system under O.C.G.A. §§ 40-6-300 through 40-6-303 (effective July 1, 2019). Class I is pedal-assist to 20 mph, Class II adds a throttle (20 mph), and Class III is pedal-assist to 28 mph. All are capped at 750 watts. E-bikes are treated as bicycles — no license, registration, or insurance required. Helmets are required for all ages on Class III e-bikes, and riders must be at least 15 for Class III.' ),
    array( 'question' => 'What are the e-bike laws in South Carolina?', 'answer' => 'South Carolina defines e-bikes under S.C. Code § 56-1-10(29) (H.3174, effective February 3, 2020) with a single definition — no class system. An e-bike must have a motor of 750 watts or less and cannot exceed 20 mph on motor power alone. E-bikes meeting this definition are treated as bicycles. Those exceeding the thresholds may be reclassified as mopeds requiring registration. There is no statewide helmet requirement.' ),
    array( 'question' => 'Can I sue the e-bike manufacturer if the battery caught fire?', 'answer' => 'Yes. Both Georgia (O.C.G.A. § 51-1-11) and South Carolina (S.C. Code § 15-73-10) impose strict product liability on manufacturers, distributors, and retailers of defective products. The CPSC has issued multiple e-bike battery recalls in 2024-2025 affecting brands like Rad Power Bikes, FENGQS, and VIVI. You may have claims against the e-bike manufacturer, the battery cell manufacturer, and the retailer.' ),
    array( 'question' => 'Do I need a license to ride an e-bike?', 'answer' => 'No. In both Georgia and South Carolina, e-bikes that meet the statutory definitions are classified as bicycles, not motor vehicles. No driver\'s license, registration, or insurance is required. However, if your e-bike exceeds the legal definition (750W or speed limits), it may be reclassified as a moped or motor vehicle.' ),
    array( 'question' => 'Are helmets required for e-bike riders?', 'answer' => 'In Georgia, helmets are required for all ages on Class III e-bikes (28 mph pedal-assist) and for riders under 16 on Class I and II e-bikes. South Carolina has no statewide helmet law for e-bike riders. Not wearing a helmet does not bar your claim in either state, but it may be raised as comparative fault for head injuries.' ),
    array( 'question' => 'How long do I have to file an e-bike accident claim?', 'answer' => 'Georgia has a 2-year statute of limitations (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Product liability claims involving defective batteries or components may have additional considerations. Contact an attorney promptly to preserve evidence — surveillance footage and electronic data can be lost quickly.' ),
    array( 'question' => 'Can I get a DUI on an e-bike?', 'answer' => 'In Georgia, DUI laws apply broadly to "vehicles," and an e-bike may qualify — meaning you could potentially face DUI charges while riding an e-bike on public roads. In South Carolina, the law is less clear: e-bikes are defined as bicycles, but the motor creates a legal gray area. Regardless, riding under the influence increases your comparative fault in a civil injury claim.' ),
    array( 'question' => 'What compensation can I recover after an e-bike accident?', 'answer' => 'E-bike accident victims may recover medical expenses (including future treatment), lost wages, pain and suffering, burn treatment and scarring from battery incidents, permanent disability, loss of enjoyment of life, and wrongful death damages for surviving families. Punitive damages may apply in cases involving drunk drivers, defective products, or egregious negligence.' ),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

// Common causes
$causes = array(
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
);
update_post_meta( $post_id, '_roden_common_causes', $causes );

// Common injuries
$injuries = array(
    array( 'name' => 'Traumatic Brain Injuries (TBI)', 'description' => 'E-bike riders suffer TBIs at a rate of 37.8% compared to 19.4% for conventional cyclists — nearly double. Cranial hemorrhages are 4.68 times more likely in e-bike crashes due to higher impact speeds. Even helmeted riders face elevated TBI risk at 20-28 mph.' ),
    array( 'name' => 'Facial Fractures', 'description' => 'E-bike crashes produce facial fractures at 3.19 times the rate of regular bicycle accidents. Jaw fractures, orbital fractures, and dental injuries are common when riders strike vehicles, pavement, or fixed objects at e-bike speeds.' ),
    array( 'name' => 'Burns from Battery Fires', 'description' => 'Lithium-ion thermal runaway produces temperatures exceeding 1,000 degrees F, causing severe thermal and chemical burns. Battery fires can occur during charging, riding, or storage, and may require extensive skin grafting and reconstructive surgery.' ),
    array( 'name' => 'Spinal Cord Injuries', 'description' => 'Higher e-bike impact speeds increase the risk of vertebral fractures, herniated discs, and spinal cord damage. Collisions at 20-28 mph can cause partial or complete paralysis requiring lifelong medical care.' ),
    array( 'name' => 'Broken Bones (Extremities)', 'description' => 'Wrists, collarbones, pelvis, and leg fractures are common in e-bike crashes. The heavier weight of e-bikes (50-70 lbs) compared to regular bicycles adds force to impacts and can pin riders during falls.' ),
    array( 'name' => 'Road Rash and Skin Injuries', 'description' => 'Higher e-bike speeds produce more severe abrasion injuries than traditional bicycle crashes. Deep road rash at 20+ mph often penetrates through skin and muscle, requiring skin grafts and leaving permanent scarring.' ),
    array( 'name' => 'Internal Organ Damage', 'description' => 'Blunt force trauma at e-bike speeds of 20-28 mph can rupture the spleen, lacerate the liver, or damage kidneys. Internal injuries may not be immediately apparent and require emergency surgical intervention.' ),
    array( 'name' => 'Wrongful Death', 'description' => 'E-bike fatalities are rising as ridership increases nationwide. Families who lose a loved one in an e-bike crash — whether from a vehicle collision, battery fire, or defective equipment — can pursue wrongful death claims in Georgia or South Carolina.' ),
);
update_post_meta( $post_id, '_roden_common_injuries', $injuries );

// Sub types
$sub_types = implode( "\n", array(
    'E-Bike vs. Vehicle Collisions',
    'E-Bike Battery Fire & Explosion Injuries',
    'E-Bike Defect & Product Liability Claims',
    'E-Bike Dooring Accidents',
    'E-Bike Intersection Crashes',
    'E-Bike Road Hazard Crashes',
    'E-Bike Rental & Tour Accidents',
    'E-Bike DUI Accidents',
) );
update_post_meta( $post_id, '_roden_sub_types', $sub_types );

// Taxonomy
$cat_term = term_exists( 'e-bike-accidents', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'E-Bike Accidents', 'practice_category', array( 'slug' => 'e-bike-accidents' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;
if ( $cat_term_id ) {
    wp_set_object_terms( $post_id, (int) $cat_term_id, 'practice_category' );
    echo "Category assigned: term ID {$cat_term_id}\n";
}

echo "All meta fields updated for post {$post_id}\n";
echo "DONE\n";
