<?php
/**
 * Seeder: Replace Wrong-Way Driver with T-Bone Accident sub-type
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-tbone-replace-wrongway.php
 *
 * Actions:
 *   1. Trashes the "wrong-way-driver-accident" sub-type page
 *   2. Creates a new "t-bone-accident" sub-type page under car-accident-lawyers
 *
 * Idempotent — skips if t-bone already exists, skips trash if wrong-way already gone.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: car-accident-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'car-accident-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'car-accident-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "car-accident-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'car-accidents', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Car Accidents', 'practice_category', array( 'slug' => 'car-accidents' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Step 1: Trash the wrong-way-driver-accident sub-type
   ------------------------------------------------------------------ */

$wrong_way = get_posts( array(
    'post_type'   => $pillar_type,
    'name'        => 'wrong-way-driver-accident',
    'post_parent' => $pillar_id,
    'post_status' => array( 'publish', 'draft', 'pending', 'private' ),
    'numberposts' => 1,
) );

if ( ! empty( $wrong_way ) ) {
    $ww_id = $wrong_way[0]->ID;
    wp_trash_post( $ww_id );
    WP_CLI::success( "Trashed \"Wrong-Way Driver Accident Lawyers\" (ID {$ww_id})" );
} else {
    WP_CLI::log( 'SKIP: "wrong-way-driver-accident" not found or already trashed.' );
}

/* ------------------------------------------------------------------
   Step 2: Create the T-Bone Accident sub-type
   ------------------------------------------------------------------ */

$existing = get_posts( array(
    'post_type'   => $pillar_type,
    'name'        => 't-bone-accident',
    'post_parent' => $pillar_id,
    'post_status' => array( 'publish', 'draft', 'pending', 'private', 'trash' ),
    'numberposts' => 1,
) );

if ( ! empty( $existing ) ) {
    WP_CLI::log( "SKIP: \"T-Bone Accident Lawyers\" already exists (ID {$existing[0]->ID})" );
} else {

    $content = <<<'HTML'
<h2>T-Bone Accident Lawyers: Fighting for Side-Impact Collision Victims</h2>
<p>T-bone accidents — also called side-impact or broadside collisions — occur when the front of one vehicle strikes the side of another, forming a "T" shape at the point of impact. These crashes are among the most dangerous types of car accidents because vehicle doors and side panels offer significantly less structural protection than front or rear crumple zones. The <a href="https://www.iihs.org/topics/side-impacts" target="_blank" rel="noopener">Insurance Institute for Highway Safety (IIHS)</a> reports that side-impact crashes account for approximately 23% of all passenger vehicle occupant deaths each year.</p>
<p>At Roden Law, our t-bone accident lawyers have extensive experience representing victims of side-impact collisions throughout Georgia and South Carolina. We understand the severe injuries these crashes cause and the complex liability questions that often arise — particularly at intersections where multiple parties may share fault.</p>

<h2>Common Causes of T-Bone Accidents</h2>
<p>T-bone collisions most frequently occur at intersections and in parking lots where vehicles cross each other's paths. The most common causes include:</p>
<ul>
<li><strong>Running red lights or stop signs:</strong> The leading cause of broadside collisions, where a driver enters an intersection against a traffic signal or sign</li>
<li><strong>Failure to yield right of way:</strong> Drivers making left turns across oncoming traffic or pulling out from side streets without adequate clearance</li>
<li><strong>Distracted driving:</strong> Texting, phone use, or other distractions that cause a driver to miss traffic signals or approaching vehicles</li>
<li><strong>Drunk or impaired driving:</strong> Intoxicated drivers who misjudge gaps in traffic or fail to observe traffic controls</li>
<li><strong>Speeding:</strong> Excessive speed reduces reaction time and makes it impossible to stop before entering an intersection</li>
<li><strong>Obscured visibility:</strong> Overgrown vegetation, parked vehicles, or poor intersection design that limits drivers' ability to see cross-traffic</li>
</ul>

<h2>Why T-Bone Accidents Cause Severe Injuries</h2>
<p>The physics of side-impact collisions make them particularly dangerous. Unlike head-on or rear-end crashes, where the engine compartment or trunk absorbs much of the collision force, a T-bone strike hits the thinnest part of the vehicle — the door. Even with modern side-impact airbags and reinforced door beams, occupants on the struck side sit just inches from the point of impact.</p>
<p>Common injuries from T-bone accidents include:</p>
<ul>
<li><strong>Traumatic brain injuries (TBI):</strong> The lateral impact can cause the head to strike windows, door frames, or B-pillars</li>
<li><strong>Spinal cord injuries:</strong> Lateral compression forces on the spine can cause herniated discs, fractures, or paralysis</li>
<li><strong>Broken ribs and internal organ damage:</strong> The ribcage absorbs direct impact force, potentially puncturing lungs or damaging the spleen, liver, and kidneys</li>
<li><strong>Pelvic and hip fractures:</strong> The hip and pelvis on the impact side are extremely vulnerable in broadside crashes</li>
<li><strong>Shoulder and arm injuries:</strong> The arm and shoulder nearest the door are frequently crushed or pinned</li>
</ul>

<h2>Proving Liability in T-Bone Accident Cases</h2>
<p>Determining fault in T-bone accidents often centers on which driver had the right of way. Key evidence includes:</p>
<ul>
<li><strong>Traffic camera footage:</strong> Many Georgia and South Carolina intersections have traffic cameras or red-light cameras that capture the moments before and during a crash</li>
<li><strong>Witness statements:</strong> Testimony from other drivers, passengers, or pedestrians who saw which driver entered the intersection improperly</li>
<li><strong>Vehicle event data recorders (EDRs):</strong> "Black box" data showing speed, braking, and throttle position in the seconds before impact</li>
<li><strong>Police accident reports:</strong> Officer observations, citations issued, and preliminary fault determinations</li>
<li><strong>Accident reconstruction:</strong> Expert analysis of debris patterns, vehicle damage, and skid marks to determine speed and angle of impact</li>
</ul>
<p>Georgia follows a modified comparative fault rule under <a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>, where you can recover damages as long as you are less than 50% at fault, with your recovery reduced by your percentage of fault. South Carolina applies a similar modified comparative negligence standard that bars recovery only if you are 51% or more at fault.</p>

<h2>Compensation for T-Bone Accident Victims</h2>
<p>Given the severity of injuries in broadside collisions, compensation in T-bone accident cases can be substantial. Our attorneys pursue recovery for all current and future medical expenses, lost wages and diminished earning capacity, pain and suffering, permanent disability or disfigurement, loss of enjoyment of life, and property damage. In cases involving egregious conduct such as drunk driving or extreme speeding, punitive damages may also be available under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-5-1/" target="_blank" rel="noopener">O.C.G.A. § 51-12-5.1</a>) and South Carolina law.</p>
HTML;

    $faqs = array(
        array(
            'question' => 'What is a T-bone accident?',
            'answer'   => 'A T-bone accident, also called a side-impact or broadside collision, occurs when the front of one vehicle strikes the side of another at a roughly perpendicular angle, forming a T-shape. These crashes most commonly occur at intersections when one driver runs a red light, stop sign, or fails to yield the right of way.',
        ),
        array(
            'question' => 'Why are T-bone accidents so dangerous?',
            'answer'   => 'T-bone crashes are especially dangerous because vehicle doors provide far less structural protection than the front or rear of a car. Occupants on the struck side sit just inches from the point of impact, even with side airbags deployed. The IIHS reports that side-impact crashes account for about 23% of all passenger vehicle occupant deaths.',
        ),
        array(
            'question' => 'How is fault determined in a T-bone collision?',
            'answer'   => 'Fault typically depends on which driver had the right of way. Evidence like traffic camera footage, witness statements, police reports, and vehicle black box data help establish who violated a traffic signal or failed to yield. Georgia and South Carolina both use modified comparative fault rules.',
        ),
        array(
            'question' => 'What compensation can I recover after a T-bone accident?',
            'answer'   => 'Victims may recover medical expenses (current and future), lost wages, pain and suffering, permanent disability, loss of enjoyment of life, and property damage. Punitive damages may be available if the at-fault driver was drunk, racing, or engaged in other egregious conduct.',
        ),
        array(
            'question' => 'What should I do after being T-boned at an intersection?',
            'answer'   => 'Call 911 and seek medical attention immediately, even if injuries seem minor — side-impact crash injuries often worsen over time. Document the scene with photos, get witness contact information, and do not admit fault. Contact a personal injury attorney before speaking with insurance adjusters.',
        ),
    );

    $post_id = wp_insert_post( array(
        'post_type'    => $pillar_type,
        'post_title'   => 'T-Bone Accident Lawyers',
        'post_name'    => 't-bone-accident',
        'post_content' => $content,
        'post_excerpt' => 'Injured in a T-bone collision in Georgia or South Carolina? Side-impact crashes cause devastating injuries. Our attorneys fight for maximum compensation from negligent drivers who run red lights and stop signs.',
        'post_status'  => 'publish',
        'post_parent'  => $pillar_id,
        'post_author'  => 1,
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::error( "FAIL: \"T-Bone Accident Lawyers\" — " . $post_id->get_error_message() );
        return;
    }

    // Meta fields.
    update_post_meta( $post_id, '_roden_jurisdiction', 'both' );
    update_post_meta( $post_id, '_roden_sol_ga', 'O.C.G.A. § 9-3-33' );
    update_post_meta( $post_id, '_roden_sol_sc', 'S.C. Code § 15-3-530' );
    update_post_meta( $post_id, '_roden_faqs', $faqs );

    if ( $author_attorney_id ) {
        update_post_meta( $post_id, '_roden_author_attorney', $author_attorney_id );
    }

    // Taxonomy.
    if ( $cat_term_id ) {
        wp_set_object_terms( $post_id, (int) $cat_term_id, 'practice_category' );
    }

    WP_CLI::success( "CREATED: \"T-Bone Accident Lawyers\" (ID {$post_id})" );
}

/* ------------------------------------------------------------------
   Done
   ------------------------------------------------------------------ */

WP_CLI::log( '' );
WP_CLI::success( 'Done. Replaced wrong-way-driver-accident with t-bone-accident.' );
WP_CLI::log( 'Run: wp rewrite flush' );
