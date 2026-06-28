<?php
/**
 * Seeder (1 of 2): FAQs for resource pages that lacked them (Charleston-area, SC).
 *
 * Adds _roden_faqs so these resources emit FAQPage JSON-LD (schema-helpers.php
 * resource branch) + render the visible FAQ accordion. AI-SEO push, audit 2026-06-26.
 * Split into 2 small files to stay under WP Engine's eval-file size limit.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-resource-faqs-aeo-1.php
 *
 * Idempotent — skips resources that already have FAQs.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faqs_by_slug = array (
  'north-charleston-truck-accident-guide' => 
  array (
    0 => 
    array (
      'question' => 'How long do I have to file a truck accident lawsuit in South Carolina?',
      'answer' => 'In South Carolina you generally have three years from the date of the truck accident to file a personal injury lawsuit, under S.C. Code Section 15-3-530. Missing this deadline usually bars your claim entirely. Wrongful death claims also follow the three-year limit, measured from the date of death.',
    ),
    1 => 
    array (
      'question' => 'Who can be held liable for a commercial truck accident in North Charleston?',
      'answer' => 'Liability for a North Charleston truck accident can extend beyond the driver to the trucking company, the cargo loader, a maintenance contractor, or a parts manufacturer. Trucking companies are often responsible for their drivers\' negligence and for unsafe hiring, training, scheduling, or vehicle-maintenance practices that caused the crash.',
    ),
    2 => 
    array (
      'question' => 'What FMCSA evidence matters most in a truck accident claim?',
      'answer' => 'Federal Motor Carrier Safety Administration records are central evidence in a truck crash claim. Key items include the driver\'s hours-of-service logs, electronic logging device data, the driver qualification file, drug and alcohol testing results, vehicle inspection and maintenance records, and the truck\'s black-box or telematics data showing speed and braking.',
    ),
    3 => 
    array (
      'question' => 'What should I do immediately after a truck accident in North Charleston?',
      'answer' => 'After a North Charleston truck accident, call 911, seek medical care even if you feel fine, and photograph the scene, vehicles, and any skid marks. Get the driver\'s name, company, and insurance, identify witnesses, and avoid giving recorded statements to the trucking company\'s insurer before consulting an attorney.',
    ),
    4 => 
    array (
      'question' => 'Why are truck accident cases harder than regular car accident cases?',
      'answer' => 'Truck accident cases are more complex because they involve federal regulations, multiple potentially liable parties, larger commercial insurance policies, and specialized evidence like logbooks and electronic data that can disappear fast. Trucking companies often deploy rapid-response teams to the scene, so preserving evidence early is critical to a fair outcome.',
    ),
  ),
  'workers-comp-north-charleston-warehouse-port' => 
  array (
    0 => 
    array (
      'question' => 'Can warehouse and port workers in North Charleston get workers\' compensation?',
      'answer' => 'Yes. Most warehouse and port workers in North Charleston are covered by the South Carolina Workers\' Compensation Act (S.C. Code Title 42). Covered injuries include those from forklifts, falling cargo, repetitive lifting, and machinery. Benefits apply regardless of who was at fault, as long as the injury arose out of employment.',
    ),
    1 => 
    array (
      'question' => 'What benefits does South Carolina workers\' compensation pay an injured worker?',
      'answer' => 'South Carolina workers\' compensation pays for all authorized medical treatment, plus wage-replacement benefits equal to two-thirds of your average weekly wage while you cannot work. It also provides permanent disability awards based on the body part injured. These benefits are administered through the South Carolina Workers\' Compensation Commission.',
    ),
    2 => 
    array (
      'question' => 'Is workers\' comp my only option, or can I sue after a port injury?',
      'answer' => 'Workers\' compensation is generally the exclusive remedy against your employer in South Carolina, meaning you usually cannot sue your employer directly. However, if a third party such as an equipment manufacturer, contractor, or another company caused your port injury, you may pursue a separate negligence claim against that party.',
    ),
    3 => 
    array (
      'question' => 'What is a third-party claim for a North Charleston warehouse injury?',
      'answer' => 'A third-party claim lets an injured worker sue someone other than their employer whose negligence caused the harm, such as a defective-machine manufacturer, a delivery company, or a property owner. Unlike workers\' comp, a third-party claim can recover pain and suffering and full lost wages on top of comp benefits.',
    ),
    4 => 
    array (
      'question' => 'How long do I have to report a work injury in South Carolina?',
      'answer' => 'In South Carolina you must report a workplace injury to your employer within 90 days, and you generally have two years to file a workers\' compensation claim with the Workers\' Compensation Commission. Reporting promptly protects your benefits, since delays give insurers grounds to dispute that the injury was work-related.',
    ),
  ),
  'rideshare-accident-north-charleston' => 
  array (
    0 => 
    array (
      'question' => 'Who pays for an Uber or Lyft accident in North Charleston?',
      'answer' => 'Who pays after a North Charleston rideshare crash depends on the driver\'s app status. When the app is off, the driver\'s personal insurance applies. When the driver is logged in and available, limited rideshare coverage applies. When carrying a passenger or en route to one, Uber and Lyft\'s one-million-dollar liability policy typically applies.',
    ),
    1 => 
    array (
      'question' => 'Does Uber\'s $1 million insurance always cover my injuries?',
      'answer' => 'No. Uber and Lyft\'s one-million-dollar liability coverage applies only during an active trip, meaning the driver has accepted a ride or has a passenger aboard. If the driver was offline or merely waiting for a request, lower coverage tiers apply, and the rideshare company\'s full policy will not be available.',
    ),
    2 => 
    array (
      'question' => 'What insurance applies when a rideshare driver is waiting for a ride request?',
      'answer' => 'When a rideshare driver is logged into the app but has not yet accepted a trip, Uber and Lyft provide contingent liability coverage of roughly fifty thousand dollars per person and one hundred thousand per accident for injuries to others, plus property damage. This fills gaps where the driver\'s personal policy excludes rideshare use.',
    ),
    3 => 
    array (
      'question' => 'Can I sue Uber or Lyft directly after a North Charleston crash?',
      'answer' => 'Usually you pursue the company\'s insurance policy rather than suing Uber or Lyft directly, because drivers are classified as independent contractors. You can file a claim against the at-fault driver and access the applicable rideshare coverage tier. The standard South Carolina three-year filing deadline applies under S.C. Code Section 15-3-530.',
    ),
    4 => 
    array (
      'question' => 'What should I do as a passenger injured in a rideshare accident?',
      'answer' => 'As an injured rideshare passenger, screenshot your trip details in the app, seek medical attention, and photograph the scene and vehicles. Report the crash to both the police and the rideshare app. Get insurance information from all drivers involved, since multiple policies may apply to your injury claim.',
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