<?php
/**
 * Seeder: Backfill Key Takeaways for Blog Posts & Resource Pages
 *
 * Adds _roden_key_takeaways meta to all existing blog posts and resource
 * pages that were published without one.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-key-takeaways-backfill.php
 *
 * Idempotent — skips posts that already have a key takeaways value.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$takeaways = array(

    /* ==================================================================
       BLOG POSTS
       ================================================================== */

    'ashley-phosphate-i-26-south-carolinas-deadliest-intersection' => array(
        'type' => 'post',
        'text' => 'The intersection of <strong>Ashley Phosphate Road and I-26</strong> in North Charleston averages one crash every three days, making it the most dangerous intersection in South Carolina. High-speed off-ramp traffic, complex left turns, and commercial density are the primary factors. Under <strong>S.C. Code § 15-3-530</strong>, injured victims have <strong>3 years</strong> to file suit. Government entities like SCDOT may share liability for design deficiencies under the South Carolina Tort Claims Act.',
    ),

    'pedestrian-safety-park-circle-north-charleston' => array(
        'type' => 'post',
        'text' => 'Pedestrian crashes are rising in Park Circle as foot traffic from restaurants and nightlife outpaces road infrastructure. <strong>Spruill Avenue</strong> carries heavy industrial and truck traffic through the walkable district, and crosswalks on East Montague Avenue lack adequate signals. South Carolina law requires drivers to exercise <strong>due care to avoid striking pedestrians</strong> (<strong>S.C. Code § 56-5-3230</strong>). Victims can recover damages under the state\'s comparative fault rule if they are less than 51% at fault, with a <strong>3-year filing deadline</strong> (<strong>S.C. Code § 15-3-530</strong>).',
    ),

    'port-truck-accidents-charleston-liability' => array(
        'type' => 'post',
        'text' => 'Port of Charleston truck accidents involve up to <strong>5–6 liable parties</strong> — the truck driver, motor carrier, chassis leasing company, cargo shipper, port terminal operator, and freight broker. Chassis defects, overweight containers, and hours-of-service violations are common contributing factors. <strong>FMCSA regulations</strong> require electronic logging devices and regular vehicle inspections. South Carolina\'s <strong>3-year statute of limitations</strong> (<strong>S.C. Code § 15-3-530</strong>) applies, and preserving evidence like ELD data and dash-cam footage is critical.',
    ),

    'motorcycle-accidents-dorchester-road-data' => array(
        'type' => 'post',
        'text' => 'Dorchester Road in North Charleston is one of South Carolina\'s most hazardous corridors for motorcyclists. <strong>Left-turn collisions</strong> account for approximately 42% of fatal motorcycle crashes statewide. Heavy truck traffic, limited sight lines, and speeds above 45 mph drastically reduce survival odds. South Carolina does not require helmets for riders over 21 but comparative fault applies — riders can recover damages if less than <strong>51% at fault</strong>. The <strong>3-year statute of limitations</strong> (<strong>S.C. Code § 15-3-530</strong>) governs all injury claims.',
    ),

    'north-charleston-crime-rate-hit-and-run' => array(
        'type' => 'post',
        'text' => 'North Charleston has a disproportionately high rate of <strong>hit-and-run accidents</strong>, and research links elevated crime rates to drivers\' willingness to flee crash scenes. Uninsured motorist (UM) coverage is the primary recovery path when the at-fault driver is unidentified. South Carolina requires UM/UIM coverage on every auto policy. Hit-and-run is a criminal offense under <strong>S.C. Code § 56-5-1210</strong>, and victims may also access the <strong>Crime Victims\' Compensation Fund</strong>. The <strong>3-year filing deadline</strong> (<strong>S.C. Code § 15-3-530</strong>) applies to civil claims.',
    ),

    'south-carolina-statute-of-limitations-personal-injury' => array(
        'type' => 'post',
        'text' => 'South Carolina gives personal injury victims <strong>3 years</strong> from the date of injury to file a lawsuit (<strong>S.C. Code § 15-3-530</strong>). Exceptions include: <strong>2-year deadline</strong> for claims against government entities under the SC Tort Claims Act, <strong>tolling for minors</strong> (deadline paused until age 18), and the <strong>discovery rule</strong> (clock starts when the injury is or should have been discovered). Waiting to file weakens cases — evidence degrades, witnesses forget, and defendants destroy records.',
    ),

    /* ==================================================================
       RESOURCE PAGES
       ================================================================== */

    'dangerous-roads-north-charleston' => array(
        'type' => 'resource',
        'text' => 'North Charleston\'s most dangerous roads include the <strong>Ashley Phosphate/I-26 interchange</strong> (one crash every 3 days), the <strong>I-26/I-526 interchange</strong>, <strong>Rivers Avenue from Remount to I-526</strong>, and <strong>Dorchester Road</strong>. Contributing factors include high-speed merges, commercial truck volume, and inadequate pedestrian infrastructure. South Carolina\'s <strong>3-year statute of limitations</strong> (<strong>S.C. Code § 15-3-530</strong>) applies to all injury claims on these roads, and government entities may share liability for known design deficiencies.',
    ),

    'what-to-do-after-car-accident-north-charleston' => array(
        'type' => 'resource',
        'text' => 'After a car accident in North Charleston, you should <strong>call 911</strong> for a police report, seek immediate medical attention, <strong>photograph the scene and your injuries</strong>, collect witness information, and <strong>avoid giving recorded statements</strong> to insurance adjusters. South Carolina is a fault-based insurance state — the at-fault driver\'s insurer pays. You have <strong>3 years to file a personal injury lawsuit</strong> (<strong>S.C. Code § 15-3-530</strong>) and can recover damages if you are less than <strong>51% at fault</strong> under the state\'s comparative negligence rule.',
    ),

    'north-charleston-truck-accident-guide' => array(
        'type' => 'resource',
        'text' => 'Truck accidents on North Charleston\'s <strong>I-26 and Rivers Avenue corridor</strong> involve federal <strong>FMCSA regulations</strong>, multiple liable parties (driver, carrier, chassis lessor, cargo shipper), and higher insurance minimums ($750K–$5M). Common crash types include jackknife, rollover, rear-end, underride, and tire blowout collisions. <strong>Electronic logging device (ELD) data</strong> and dash-cam footage are critical evidence that can be destroyed within 30 days. South Carolina\'s <strong>3-year statute of limitations</strong> (<strong>S.C. Code § 15-3-530</strong>) applies.',
    ),

    'workers-comp-north-charleston-warehouse-port' => array(
        'type' => 'resource',
        'text' => 'North Charleston warehouse and port workers may be covered by <strong>South Carolina Workers\' Compensation</strong> (2-year filing deadline) or the federal <strong>Longshore and Harbor Workers\' Compensation Act (LHWCA)</strong> (1-year filing deadline) depending on where the injury occurred. Workers\' comp provides medical benefits, temporary disability (66⅔% of wages), and permanent impairment ratings. <strong>Third-party claims</strong> against equipment manufacturers, property owners, or negligent contractors can provide additional compensation beyond workers\' comp limits.',
    ),

    'rideshare-accident-north-charleston' => array(
        'type' => 'resource',
        'text' => 'Uber and Lyft accidents in North Charleston involve a <strong>3-phase insurance system</strong>: Phase 1 (app on, no match) provides $50K/$100K liability — a dangerous coverage gap; Phases 2–3 (en route/during trip) carry <strong>$1 million coverage</strong>. Common crash locations include the I-26/Rivers Avenue corridor and airport pickup zones. South Carolina requires <strong>UM/UIM coverage</strong> on every auto policy. Rideshare companies aggressively defend claims using arbitration clauses and independent-contractor arguments. The <strong>3-year statute of limitations</strong> (<strong>S.C. Code § 15-3-530</strong>) applies.',
    ),

    'pedestrian-bicycle-safety-north-charleston' => array(
        'type' => 'resource',
        'text' => 'South Carolina law grants pedestrians the right-of-way in crosswalks and requires drivers to exercise <strong>due care</strong> (<strong>S.C. Code § 56-5-3230</strong>). Bicyclists have the <strong>same rights and duties as motor vehicles</strong> and are entitled to a <strong>3-foot passing distance</strong>. North Charleston\'s most dangerous corridors for pedestrians and cyclists include Rivers Avenue, Dorchester Road, and the Park Circle area. Victims can recover damages under comparative fault if less than <strong>51% at fault</strong>, with a <strong>3-year filing deadline</strong> (<strong>S.C. Code § 15-3-530</strong>).',
    ),

    'personal-injury-claim-charleston-county-court' => array(
        'type' => 'resource',
        'text' => 'Filing a personal injury claim in <strong>Charleston County Circuit Court</strong> involves a pre-litigation phase (demand letter, negotiation), formal filing, discovery (12–18 months), mediation, and potentially a jury trial. The <strong>3-year statute of limitations</strong> (<strong>S.C. Code § 15-3-530</strong>) is a hard deadline — cases filed even one day late are permanently barred. Most cases settle during mediation or after discovery. Charleston County juries hear civil cases at the <strong>Charleston County Courthouse</strong> on Broad Street, with typical trial timelines of 18–24 months from filing.',
    ),

    'construction-zone-accidents-north-charleston' => array(
        'type' => 'resource',
        'text' => 'The <strong>I-526 Lowcountry Corridor project</strong> and ongoing North Charleston road construction create elevated crash risks from lane shifts, reduced visibility, and heavy equipment. Liable parties may include the <strong>at-fault driver, general contractor, subcontractors, traffic control companies, and SCDOT</strong>. Contractors must follow <strong>MUTCD standards</strong> for work-zone signage and traffic management plans. Claims against government entities require compliance with the <strong>SC Tort Claims Act</strong> notice provisions. South Carolina imposes <strong>enhanced penalties</strong> for speeding in work zones, and the <strong>3-year statute of limitations</strong> (<strong>S.C. Code § 15-3-530</strong>) applies.',
    ),

);

/* ------------------------------------------------------------------
   Process each post
   ------------------------------------------------------------------ */

$updated = 0;
$skipped = 0;

foreach ( $takeaways as $slug => $data ) {
    $post = get_page_by_path( $slug, OBJECT, $data['type'] );

    if ( ! $post ) {
        WP_CLI::warning( "NOT FOUND: {$data['type']} \"{$slug}\" — skipping." );
        continue;
    }

    $existing = get_post_meta( $post->ID, '_roden_key_takeaways', true );
    if ( $existing ) {
        WP_CLI::log( "SKIP: \"{$post->post_title}\" (ID {$post->ID}) — already has key takeaways." );
        $skipped++;
        continue;
    }

    update_post_meta( $post->ID, '_roden_key_takeaways', wp_kses_post( $data['text'] ) );
    WP_CLI::success( "UPDATED: \"{$post->post_title}\" (ID {$post->ID}) — key takeaways added." );
    $updated++;
}

WP_CLI::log( '' );
WP_CLI::log( "Done. Updated: {$updated} | Skipped: {$skipped} | Total: " . count( $takeaways ) );
