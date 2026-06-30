<?php
/**
 * Seeder: "MMI and Impairment Ratings in SC Workers' Comp" explainer.
 *
 * SC workers'-comp explainer set, page 3 of 4 (SC competitor gap analysis
 * 2026-06-29, P1 row 6). Out-formats Derrick's MMI/impairment cluster with a
 * verified explanation of how permanent partial disability is calculated +
 * FAQPage schema. South-Carolina-only. Ships as DRAFT for human review.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-resource-wc-mmi-impairment.php
 *
 * Idempotent — skips if the slug already exists.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title         = 'MMI and Impairment Ratings in SC Workers\' Comp';
$slug          = 'south-carolina-workers-comp-impairment-rating-mmi';
$meta_desc     = 'How maximum medical improvement (MMI) and impairment ratings work in South Carolina workers\' comp, and how a permanent partial disability award is calculated from your rating.';
$key_takeaways = 'Maximum medical improvement (MMI) is the point at which your work injury has stabilized and is not expected to improve further with treatment. South Carolina law does not define MMI by statute — it is a medical and Commission concept — but your permanent partial disability (PPD) award is not assessed until you reach it. Once at MMI, a doctor assigns an impairment rating, and your scheduled PPD award is calculated as: impairment percentage × the scheduled weeks for that body part (S.C. Code § 42-9-30) × your comp rate (66⅔% of your average weekly wage). For example, a 50% impairment to a hand is 0.50 × 185 = 92.5 weeks of benefits. South Carolina does not require any specific edition of the AMA Guides, so the doctor\'s medical impairment percentage can differ from the legal "loss of use" percentage the Commission actually finds — and the scheduled rating is a floor, not a ceiling, because a wage-loss or total-disability claim can pay more.';
$content       = '<p><strong>Maximum medical improvement (MMI)</strong> is the moment your work injury has healed as much as it is going to &mdash; your condition has stabilized and is not expected to get meaningfully better with further treatment. MMI matters because South Carolina does not assess your <strong>permanent</strong> benefits until you reach it. Up to that point you may receive temporary benefits; once you are at MMI, a doctor assigns an <strong>impairment rating</strong> that drives your permanent partial disability (PPD) award.</p>

<p>Below, a Roden Law attorney explains what MMI means, how an impairment rating becomes a dollar figure, and why the medical impairment percentage is not always the same as the legal "loss of use" the Commission finds. Roden Law works on a contingency fee basis &mdash; no upfront cost and no fees unless we win.</p>

<h2>What does maximum medical improvement (MMI) mean?</h2>
<p>MMI means your condition has plateaued: additional treatment is not expected to improve the underlying injury, even if you still have ongoing symptoms or need maintenance care. South Carolina <strong>does not define MMI by statute</strong> &mdash; it is a medical and Commission concept that your treating doctor determines based on your recovery. Reaching MMI does not mean you are "all better"; it means your condition is as stable as it is going to get, which is the point at which any <strong>permanent</strong> impairment can be measured.</p>

<h2>How is an impairment rating turned into a workers\' comp award?</h2>
<p>For a scheduled body part, your permanent partial disability award is calculated by multiplying three numbers:</p>
<p><strong>impairment percentage &times; scheduled weeks (&sect; 42-9-30) &times; comp rate (66&frac23;% of AWW)</strong></p>
<p>Example: a worker with a <strong>50% impairment to a hand</strong> is entitled to 0.50 &times; 185 weeks = <strong>92.5 weeks</strong> of benefits, paid at 66&frac23;% of that worker&rsquo;s average weekly wage. If the comp rate were $600 per week, that is 92.5 &times; $600 = $55,500. The scheduled weeks for each body part come from the &sect; 42-9-30 schedule &mdash; see our <a href="/resources/south-carolina-workers-comp-body-part-values/">body part value chart</a> for the full list.</p>

<h2>Which edition of the AMA Guides does South Carolina use?</h2>
<p>None is mandated. <strong>South Carolina does not require any specific edition of the AMA Guides to the Evaluation of Permanent Impairment.</strong> An impairment rating is medical-opinion evidence that the Workers&rsquo; Compensation Commission weighs &mdash; not an automatic, binding number. Because of this, two doctors can assign different ratings, and the rating you are first offered by the insurer&rsquo;s physician is not necessarily the rating the Commission will adopt.</p>

<h2>Is the impairment rating the same as my "loss of use"?</h2>
<p>Not necessarily. The <strong>impairment percentage is a medical opinion</strong> about the physical loss to the body part. The <strong>"loss of use" percentage is a legal finding</strong> by the Commission about how much use of that body part you have actually lost &mdash; and it can be <strong>higher than the medical impairment number</strong>, because it accounts for how the injury affects your real-world ability to use the body part at work. A worker with a 20% medical impairment rating may be found to have a much higher loss of use depending on the evidence. This gap is one of the most contested parts of a workers&rsquo; comp case.</p>

<h2>Can I recover more than my scheduled rating?</h2>
<p>Yes &mdash; the scheduled rating is a <strong>floor, not a ceiling</strong>. Instead of accepting a scheduled PPD award, an injured worker may pursue a <strong>loss of earning capacity (wage-loss) claim under S.C. Code &sect; 42-9-20</strong> or a <strong>total disability claim under &sect; 42-9-10</strong>. If your injury limits the kind of work you can do or what you can earn, one of these paths can pay substantially more than the scheduled weeks alone. Which approach maximizes your recovery depends on your wages, your work restrictions, and the medical evidence.</p>

<h2>Why you should not accept the first rating you are offered</h2>
<p>Because the impairment rating drives the dollar value of your permanent award, the insurance company has every incentive to send you to a doctor who assigns a low number and to push you toward a quick settlement at MMI. A Roden Law attorney can review your rating, seek a second opinion where warranted, and argue for the higher "loss of use" finding &mdash; or a wage-loss or total-disability award &mdash; that the facts support. The review is free, and there are no fees unless we win.</p>
<p>For more, see our <a href="/resources/south-carolina-workers-comp-body-part-values/">body part value chart</a>, <a href="/resources/how-much-does-south-carolina-workers-comp-pay/">how much South Carolina workers&rsquo; comp pays</a>, and <a href="/resources/south-carolina-workers-comp-claim-denied/">what to do if your claim is denied</a>. You can also learn about your rights on our <a href="/south-carolina-workers-compensation-lawyer/">South Carolina workers&rsquo; compensation</a> page and our <a href="/practice-areas/workers-compensation-lawyers/">workers&rsquo; compensation practice</a> page.</p>';

$faqs = array(
    array(
        'question' => 'What does maximum medical improvement (MMI) mean in South Carolina workers\' comp?',
        'answer'   => 'MMI is the point at which your work injury has stabilized and is not expected to improve further with treatment, even if you still have symptoms. South Carolina does not define MMI by statute — it is a medical and Commission concept determined by your treating doctor. Your permanent partial disability award is not assessed until you reach MMI.',
    ),
    array(
        'question' => 'How is my impairment rating turned into a workers\' comp award?',
        'answer'   => 'For a scheduled body part, the award is your impairment percentage × the scheduled weeks for that part (S.C. Code § 42-9-30) × your comp rate (66⅔% of your average weekly wage). For example, a 50% impairment to a hand equals 0.50 × 185 = 92.5 weeks of benefits, paid at your comp rate.',
    ),
    array(
        'question' => 'Which edition of the AMA Guides does South Carolina require?',
        'answer'   => 'None. South Carolina does not mandate any specific edition of the AMA Guides. An impairment rating is medical-opinion evidence that the Workers\' Compensation Commission weighs, not an automatic binding number, which is why two doctors can assign different ratings and the insurer\'s first rating is not necessarily the one the Commission adopts.',
    ),
    array(
        'question' => 'Is my impairment rating the same as my loss of use?',
        'answer'   => 'Not necessarily. The impairment percentage is a medical opinion about physical loss to the body part. The "loss of use" percentage is a legal finding by the Commission about how much use you have actually lost, and it can be higher than the medical impairment number because it accounts for how the injury affects your real-world ability to use the body part at work.',
    ),
    array(
        'question' => 'Can I recover more than my scheduled impairment rating?',
        'answer'   => 'Yes. The scheduled rating is a floor, not a ceiling. Instead of a scheduled award, you may pursue a loss of earning capacity (wage-loss) claim under § 42-9-20 or a total disability claim under § 42-9-10. If your injury limits the work you can do or what you can earn, one of these paths can pay more than the scheduled weeks.',
    ),
    array(
        'question' => 'Should I accept the first impairment rating the insurance company offers?',
        'answer'   => 'Be cautious. Because the rating drives the value of your permanent award, the insurer has an incentive to send you to a doctor who assigns a low number and push a quick settlement at MMI. An attorney can review the rating, seek a second opinion where warranted, and argue for a higher loss-of-use finding or a wage-loss or total-disability award.',
    ),
);

$see_also = array(
    array(
        'url'  => '/resources/south-carolina-workers-comp-body-part-values/',
        'text' => 'South Carolina Workers\' Comp Body Part Value Chart',
    ),
    array(
        'url'  => '/resources/how-much-does-south-carolina-workers-comp-pay/',
        'text' => 'How Much Does South Carolina Workers\' Comp Pay?',
    ),
    array(
        'url'  => '/resources/south-carolina-workers-comp-claim-denied/',
        'text' => 'What to Do If Your SC Workers\' Comp Claim Is Denied',
    ),
    array(
        'url'  => '/south-carolina-workers-compensation-lawyer/',
        'text' => 'South Carolina Workers\' Compensation Lawyer',
    ),
);

// Author attribution — Graeham C. Gillin (Charleston, SC partner).
$author    = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $author ? $author->ID : 0;
if ( ! $author_id ) {
    WP_CLI::warning( 'Attorney "graeham-c-gillin" not found — author attribution will be empty.' );
}

// SC-law explainer hub category.
$cat = term_exists( 'south-carolina-law', 'practice_category' );
if ( ! $cat ) {
    $cat = wp_insert_term( 'South Carolina Law', 'practice_category', array( 'slug' => 'south-carolina-law' ) );
}
$cat_id = is_array( $cat ) ? (int) $cat['term_id'] : (int) $cat;

// Idempotency guard.
$existing = get_page_by_path( $slug, OBJECT, 'resource' );
if ( $existing ) {
    WP_CLI::log( "SKIP: \"{$title}\" already exists (ID {$existing->ID}) — /resources/{$slug}/" );
    WP_CLI::log( 'Done.' );
    return;
}

$post_id = wp_insert_post( array(
    'post_type'    => 'resource',
    'post_status'  => 'draft',
    'post_title'   => $title,
    'post_name'    => $slug,
    'post_content' => $content,
    'post_excerpt' => $meta_desc,
), true );

if ( is_wp_error( $post_id ) ) {
    WP_CLI::error( "FAILED to create \"{$title}\": " . $post_id->get_error_message() );
    return;
}

update_post_meta( $post_id, '_roden_author_attorney',  $author_id );
update_post_meta( $post_id, '_roden_jurisdiction',     'sc' );
update_post_meta( $post_id, '_roden_key_takeaways',    $key_takeaways );
update_post_meta( $post_id, '_roden_meta_description', $meta_desc );
update_post_meta( $post_id, '_roden_faqs',             $faqs );
update_post_meta( $post_id, '_roden_see_also',         $see_also );

if ( $cat_id ) {
    wp_set_object_terms( $post_id, array( $cat_id ), 'practice_category' );
}

WP_CLI::success( "CREATED (DRAFT): \"{$title}\" (ID {$post_id}) → /resources/{$slug}/" );
WP_CLI::log( '- ' . count( $faqs ) . ' FAQs, Key Takeaways set, author ID ' . $author_id . ', category south-carolina-law.' );
WP_CLI::log( 'Done.' );
