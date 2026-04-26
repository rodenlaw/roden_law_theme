<?php
/**
 * Update pedestrian sub-type pages with internal cross-links.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/update-pedestrian-internal-links.php
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$updates = 0;

/* ------------------------------------------------------------------
   Helper: find-and-replace in post content
   ------------------------------------------------------------------ */
function roden_update_content( $post_id, $replacements ) {
    $post = get_post( $post_id );
    if ( ! $post ) {
        WP_CLI::warning( "Post {$post_id} not found." );
        return false;
    }
    $content = $post->post_content;
    $changed = false;

    foreach ( $replacements as $search => $replace ) {
        if ( strpos( $content, $search ) !== false && strpos( $content, $replace ) === false ) {
            $content = str_replace( $search, $replace, $content );
            $changed = true;
        }
    }

    if ( $changed ) {
        wp_update_post( array(
            'ID'           => $post_id,
            'post_content' => $content,
        ) );
        WP_CLI::success( "Updated: \"{$post->post_title}\" (ID {$post_id})" );
        return true;
    } else {
        WP_CLI::log( "SKIP: \"{$post->post_title}\" (ID {$post_id}) — already has links or search text not found." );
        return false;
    }
}

/* ------------------------------------------------------------------
   1. Crosswalk (4079) → link to intersection page
   ------------------------------------------------------------------ */
$r = roden_update_content( 4079, array(
    '<li><strong>Right-turn-on-red violations:</strong> Drivers making a right turn on red who focus on oncoming traffic and fail to check the crosswalk for pedestrians</li>' =>
    '<li><strong>Right-turn-on-red violations:</strong> Drivers making a right turn on red who focus on oncoming traffic and fail to check the crosswalk for pedestrians. See our page on <a href="/pedestrian-accident-lawyers/intersection-pedestrian-accident/">intersection pedestrian accidents</a> for more on turning-vehicle crashes.</li>',

    '<li><strong>Distracted driving:</strong> Texting or phone use that prevents drivers from seeing pedestrians entering the crosswalk</li>' =>
    '<li><strong>Distracted driving:</strong> Texting or phone use that prevents drivers from seeing pedestrians entering the crosswalk. Learn more about <a href="/pedestrian-accident-lawyers/distracted-driver-pedestrian-accident/">distracted driver pedestrian accidents</a>.</li>',
) );
if ( $r ) $updates++;

/* ------------------------------------------------------------------
   2. Intersection (4080) → link to crosswalk and left-turn info
   ------------------------------------------------------------------ */
$r = roden_update_content( 4080, array(
    '<li><strong>Left-turning vehicles:</strong> Drivers focused on finding gaps in oncoming traffic often fail to check the crosswalk for pedestrians before completing their turn. This is the leading cause of intersection pedestrian crashes.</li>' =>
    '<li><strong>Left-turning vehicles:</strong> Drivers focused on finding gaps in oncoming traffic often fail to check the <a href="/pedestrian-accident-lawyers/crosswalk-accident/">crosswalk</a> for pedestrians before completing their turn. This is the leading cause of intersection pedestrian crashes.</li>',

    '<li><strong>Red-light runners:</strong> Drivers who enter the intersection after the signal has changed, striking pedestrians who have begun crossing on their walk signal</li>' =>
    '<li><strong>Red-light runners:</strong> Drivers who enter the intersection after the signal has changed, striking pedestrians who have begun crossing on their walk signal. <a href="/pedestrian-accident-lawyers/drunk-driver-pedestrian-accident/">Drunk drivers</a> are disproportionately likely to run red lights.</li>',
) );
if ( $r ) $updates++;

/* ------------------------------------------------------------------
   3. Hit & Run (4081) → link to drunk driver page + motorcycle hit & run
   ------------------------------------------------------------------ */
$r = roden_update_content( 4081, array(
    'Drivers flee for many reasons, including intoxication, lack of insurance, outstanding warrants, or simple panic.' =>
    'Drivers flee for many reasons, including <a href="/pedestrian-accident-lawyers/drunk-driver-pedestrian-accident/">intoxication</a>, lack of insurance, outstanding warrants, or simple panic.',

    'community tips and social media, and body shop and repair records for vehicles matching the description.' =>
    'community tips and social media, and body shop and repair records for vehicles matching the description. Our firm also handles <a href="/motorcycle-accident-lawyers/hit-and-run-motorcycle-accident/">hit-and-run motorcycle accidents</a>, which present similar challenges in identifying the fleeing driver.',
) );
if ( $r ) $updates++;

/* ------------------------------------------------------------------
   4. Distracted Driver (4082) → link to school zone + crosswalk pages
   ------------------------------------------------------------------ */
$r = roden_update_content( 4082, array(
    'A driver looking at a phone for just 5 seconds at 30 mph travels 220 feet' =>
    'This is especially dangerous in <a href="/pedestrian-accident-lawyers/school-zone-pedestrian-accident/">school zones</a> where children are present. A driver looking at a phone for just 5 seconds at 30 mph travels 220 feet',

    '<li><strong>Crash dynamics:</strong> No evidence of braking or evasive action before impact — a hallmark of distracted driving</li>' =>
    '<li><strong>Crash dynamics:</strong> No evidence of braking or evasive action before impact — a hallmark of distracted driving. This pattern is common in <a href="/pedestrian-accident-lawyers/crosswalk-accident/">crosswalk accidents</a> where distracted drivers fail to yield.</li>',
) );
if ( $r ) $updates++;

/* ------------------------------------------------------------------
   5. Drunk Driver (4083) → link to hit & run + car accident drunk driver
   ------------------------------------------------------------------ */
$r = roden_update_content( 4083, array(
    '<li><strong>Lane drift and loss of control:</strong> Impaired drivers weave across lanes and onto shoulders and sidewalks</li>' =>
    '<li><strong>Lane drift and loss of control:</strong> Impaired drivers weave across lanes and onto shoulders and sidewalks. Drunk drivers are also more likely to <a href="/pedestrian-accident-lawyers/hit-and-run-pedestrian-accident/">flee the scene</a> after striking a pedestrian.</li>',

    'to ensure pedestrian victims and their families receive full justice.' =>
    'to ensure pedestrian victims and their families receive full justice. We also handle <a href="/car-accident-lawyers/drunk-driver-accident/">drunk driver car accident claims</a> involving the same aggressive legal strategies.',
) );
if ( $r ) $updates++;

/* ------------------------------------------------------------------
   6. Backing-Up / Parking Lot (4084) → link to school zone page
   ------------------------------------------------------------------ */
$r = roden_update_content( 4084, array(
    '<li><strong>Backover accidents:</strong> A driver reverses out of a parking space or driveway without checking behind the vehicle, striking a pedestrian — particularly children who fall below the rear sight line</li>' =>
    '<li><strong>Backover accidents:</strong> A driver reverses out of a parking space or driveway without checking behind the vehicle, striking a pedestrian — particularly children who fall below the rear sight line. Backover crashes near schools are also a concern in <a href="/pedestrian-accident-lawyers/school-zone-pedestrian-accident/">school zone pedestrian accidents</a>.</li>',
) );
if ( $r ) $updates++;

/* ------------------------------------------------------------------
   7. School Zone (4085) → link to crosswalk + distracted driver pages
   ------------------------------------------------------------------ */
$r = roden_update_content( 4085, array(
    '<li><strong>Distracted driving:</strong> Phone use and other distractions are especially dangerous where children are present because kids can dart into the road with little warning</li>' =>
    '<li><strong>Distracted driving:</strong> Phone use and other distractions are especially dangerous where children are present because kids can dart into the road with little warning. Learn more about <a href="/pedestrian-accident-lawyers/distracted-driver-pedestrian-accident/">distracted driver pedestrian accidents</a>.</li>',

    '<li><strong>Speeding:</strong> Drivers who fail to reduce speed in school zones or ignore flashing school zone signs</li>' =>
    '<li><strong>Speeding:</strong> Drivers who fail to reduce speed in school zones or ignore flashing school zone signs, endangering children in <a href="/pedestrian-accident-lawyers/crosswalk-accident/">crosswalks</a></li>',
) );
if ( $r ) $updates++;

/* ------------------------------------------------------------------
   8. Jogger/Runner (4086) → link to distracted driver + hit & run pages
   ------------------------------------------------------------------ */
$r = roden_update_content( 4086, array(
    '<li><strong>Distracted driving:</strong> Drivers on phones, adjusting music, or otherwise distracted who drift onto shoulders or fail to see a runner on the road</li>' =>
    '<li><strong>Distracted driving:</strong> Drivers on phones, adjusting music, or otherwise distracted who drift onto shoulders or fail to see a runner on the road. <a href="/pedestrian-accident-lawyers/distracted-driver-pedestrian-accident/">Distracted driving</a> is the leading cause of runners being struck from behind.</li>',

    '<li><strong>Impaired driving:</strong> Drunk or drugged drivers who drift off the road and onto shoulders where runners are traveling</li>' =>
    '<li><strong>Impaired driving:</strong> <a href="/pedestrian-accident-lawyers/drunk-driver-pedestrian-accident/">Drunk or drugged drivers</a> who drift off the road and onto shoulders where runners are traveling. Impaired drivers who strike joggers are also more likely to <a href="/pedestrian-accident-lawyers/hit-and-run-pedestrian-accident/">flee the scene</a>.</li>',
) );
if ( $r ) $updates++;

/* ------------------------------------------------------------------
   Done
   ------------------------------------------------------------------ */

WP_CLI::log( '' );
WP_CLI::success( "Done. Updated {$updates} pages with internal cross-links." );
