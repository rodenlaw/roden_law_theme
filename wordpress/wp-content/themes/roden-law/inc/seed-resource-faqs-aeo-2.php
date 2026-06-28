<?php
/**
 * Seeder (2 of 2): FAQs for resource pages that lacked them (Charleston-area, SC).
 *
 * Adds _roden_faqs so these resources emit FAQPage JSON-LD (schema-helpers.php
 * resource branch) + render the visible FAQ accordion. AI-SEO push, audit 2026-06-26.
 * Split into 2 small files to stay under WP Engine's eval-file size limit.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-resource-faqs-aeo-2.php
 *
 * Idempotent — skips resources that already have FAQs.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faqs_by_slug = array (
  'pedestrian-bicycle-safety-north-charleston' => 
  array (
    0 => 
    array (
      'question' => 'Who is at fault when a car hits a pedestrian in North Charleston?',
      'answer' => 'Fault in a North Charleston pedestrian crash depends on who had the right of way. Drivers must yield to pedestrians in marked and unmarked crosswalks, but pedestrians must obey signals and avoid darting into traffic. South Carolina uses comparative negligence, so fault can be shared between the driver and the pedestrian.',
    ),
    1 => 
    array (
      'question' => 'Can I recover damages if I was partly at fault for a bike accident?',
      'answer' => 'Yes, if you were less than 51 percent at fault. South Carolina follows modified comparative negligence, so an injured cyclist can still recover damages as long as their share of fault stays below 51 percent. Your compensation is reduced by your percentage of fault, so reducing assigned blame matters.',
    ),
    2 => 
    array (
      'question' => 'What damages can an injured pedestrian or cyclist claim in South Carolina?',
      'answer' => 'An injured pedestrian or cyclist in South Carolina can claim medical expenses, future treatment costs, lost wages, reduced earning capacity, and pain and suffering. Because pedestrians and cyclists are unprotected, injuries are often severe, so claims frequently include rehabilitation, long-term care, and compensation for permanent disability or disfigurement.',
    ),
    3 => 
    array (
      'question' => 'What happens if the driver who hit me had no insurance?',
      'answer' => 'If an uninsured or hit-and-run driver injures you, your own auto policy\'s uninsured motorist coverage can pay for your injuries even though you were on foot or on a bike. South Carolina requires insurers to offer this coverage, and it often applies to pedestrians and cyclists struck by a vehicle.',
    ),
    4 => 
    array (
      'question' => 'Do cyclists have the same road rights as cars in South Carolina?',
      'answer' => 'Yes. Under South Carolina law, bicycles are vehicles, and cyclists have the same rights and duties as drivers. Cyclists may use the full lane when needed for safety, and motorists must give a safe passing distance. Drivers who violate these rules can be held liable for resulting crashes.',
    ),
  ),
  'personal-injury-claim-charleston-county-court' => 
  array (
    0 => 
    array (
      'question' => 'How does a personal injury claim move through Charleston County court?',
      'answer' => 'A Charleston County personal injury claim usually starts with investigation and an insurance demand. If no settlement is reached, your attorney files a lawsuit in the Charleston County Court of Common Pleas, followed by discovery, mediation, and possibly trial. Most cases settle before reaching a jury verdict.',
    ),
    1 => 
    array (
      'question' => 'How long does a personal injury lawsuit take in South Carolina?',
      'answer' => 'A South Carolina personal injury case can take anywhere from several months to a few years. Straightforward claims often settle within months, while cases involving serious injuries, disputed liability, or litigation in the Court of Common Pleas can take one to three years through discovery, mediation, and trial.',
    ),
    2 => 
    array (
      'question' => 'What is the deadline to file a personal injury lawsuit in South Carolina?',
      'answer' => 'South Carolina gives you three years from the date of injury to file most personal injury lawsuits, under S.C. Code Section 15-3-530. Filing in the Charleston County Court of Common Pleas after this deadline almost always results in dismissal, so it is important to act well before time runs out.',
    ),
    3 => 
    array (
      'question' => 'What are the stages of a personal injury lawsuit?',
      'answer' => 'A personal injury lawsuit moves through several stages: filing the complaint, the defendant\'s answer, discovery where both sides exchange evidence and depositions, mediation to attempt settlement, and trial if no agreement is reached. Either party may also file pretrial motions, and a verdict can be appealed afterward.',
    ),
    4 => 
    array (
      'question' => 'Do I have to go to court for my personal injury claim?',
      'answer' => 'Most personal injury claims settle without a trial, so you may never appear before a judge or jury. However, filing a lawsuit in the Charleston County Court of Common Pleas and preparing for trial often pressures insurers into fair offers. If a fair settlement is not reached, trial becomes necessary.',
    ),
  ),
  'construction-zone-accidents-north-charleston' => 
  array (
    0 => 
    array (
      'question' => 'Who is liable for a construction zone accident in North Charleston?',
      'answer' => 'Liability for a North Charleston construction-zone crash can fall on the contractor, subcontractor, SCDOT, or another driver, depending on the cause. Contractors must use proper signage, barriers, and traffic control. When negligent setup, missing warnings, or unsafe lane shifts cause a crash, the responsible company or agency can be held accountable.',
    ),
    1 => 
    array (
      'question' => 'Can I sue SCDOT for a poorly designed work zone?',
      'answer' => 'You may pursue a claim against the South Carolina Department of Transportation for a hazardous work zone, but claims against state agencies fall under the South Carolina Tort Claims Act, which imposes shorter notice requirements and damage caps. These cases are complex, so prompt legal action is important to preserve your rights.',
    ),
    2 => 
    array (
      'question' => 'What are common causes of construction zone truck accidents?',
      'answer' => 'Construction-zone truck accidents commonly result from sudden lane narrowing, abrupt stops in backed-up traffic, inadequate or confusing signage, poor lighting, and speeding through reduced-speed areas. Large trucks need extra stopping distance, so when a work zone forces quick maneuvers, rear-end collisions and rollovers become far more likely.',
    ),
    3 => 
    array (
      'question' => 'Do reduced speed limits in work zones affect my injury claim?',
      'answer' => 'Yes. Reduced work-zone speed limits set the standard of care for drivers, so exceeding them is strong evidence of negligence in your injury claim. South Carolina also increases penalties for work-zone violations. A driver who ignored posted reduced limits can be held liable for crashes caused by that excessive speed.',
    ),
    4 => 
    array (
      'question' => 'What evidence helps prove a construction zone accident claim?',
      'answer' => 'Strong evidence in a construction-zone claim includes photos of signage, barriers, and lane markings, the traffic-control plan, the contractor\'s permits, dashcam or surveillance video, and witness statements. Documenting the work zone quickly matters, because contractors often change the layout soon after a crash, erasing proof of unsafe conditions.',
    ),
  ),
);

$updated = 0;
$skipped = 0;
$missing = 0;

foreach ( $faqs_by_slug as $slug => $faqs ) {

    $post = get_page_by_path( $slug, OBJECT, 'resource' );
    if ( ! $post ) {
        WP_CLI::warning( "Resource \"{$slug}\" not found — skipping." );
        $missing++;
        continue;
    }

    $existing = get_post_meta( $post->ID, '_roden_faqs', true );
    if ( is_array( $existing ) && count( $existing ) > 0 ) {
        WP_CLI::log( "SKIP {$slug} (ID {$post->ID}) — already has " . count( $existing ) . " FAQs." );
        $skipped++;
        continue;
    }

    $clean = array();
    foreach ( $faqs as $faq ) {
        if ( empty( $faq['question'] ) || empty( $faq['answer'] ) ) {
            continue;
        }
        $clean[] = array(
            'question' => sanitize_text_field( $faq['question'] ),
            'answer'   => sanitize_textarea_field( $faq['answer'] ),
        );
    }

    update_post_meta( $post->ID, '_roden_faqs', $clean );
    WP_CLI::success( "{$slug} (ID {$post->ID}) — " . count( $clean ) . " FAQs added." );
    $updated++;
}

WP_CLI::log( "\n--- SUMMARY ---" );
WP_CLI::log( "Updated: {$updated} | Skipped: {$skipped} | Missing: {$missing}" );
WP_CLI::log( "Done." );