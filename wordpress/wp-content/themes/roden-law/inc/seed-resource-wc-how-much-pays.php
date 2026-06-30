<?php
/**
 * Seeder: "How Much Does South Carolina Workers' Comp Pay?" explainer.
 *
 * SC workers'-comp explainer set, page 2 of 4 (SC competitor gap analysis
 * 2026-06-29, P1 row 6). Out-formats Joye's "how much does workers comp pay"
 * page with verified comp-rate, max/min, TTD/TPD, waiting period, caps,
 * medical + mileage figures and FAQPage schema. South-Carolina-only.
 * Ships as DRAFT for human review.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-resource-wc-how-much-pays.php
 *
 * NOTE: Annual figures (max weekly rate $1,189.94 for 2026; mileage 72.5¢/mile
 * as of Jan 1, 2026) are phrased with their year/date so they self-flag as
 * time-bound. Verified against scstatehouse.gov + wcc.sc.gov 2026-06-30.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title         = 'How Much Does South Carolina Workers\' Comp Pay?';
$slug          = 'how-much-does-south-carolina-workers-comp-pay';
$meta_desc     = 'South Carolina workers\' comp pays two-thirds of your average weekly wage, subject to an annual maximum and a $75 minimum. Learn the rates, waiting period, caps, and medical and mileage benefits.';
$key_takeaways = 'South Carolina workers\' compensation pays temporary total disability (TTD) benefits at two-thirds (66⅔%) of your average weekly wage while you are out of work, subject to an annual maximum and minimum. The maximum is set each year by date of injury — for injuries occurring in 2026, the maximum is $1,189.94 per week — and the minimum is $75 per week (or your full wage if it is less). There is a 7-day waiting period before wage benefits start (S.C. Code § 42-9-200), but if your disability lasts more than 14 days you are paid back to day one. Medical benefits, including authorized treatment and mileage reimbursement for trips more than 5 miles one-way, are paid from day one with no waiting period. Total disability benefits are generally capped at 500 weeks, except for paraplegia, quadriplegia, or physical brain damage, which can be paid for life. These wage benefits are not taxable.';
$content       = '<p>South Carolina workers&rsquo; compensation pays you a portion of your lost wages plus your authorized medical care when you are hurt on the job. For lost wages, the core benefit &mdash; <strong>temporary total disability (TTD)</strong> &mdash; pays <strong>two-thirds (66&frac23;%) of your average weekly wage (AWW)</strong> while a work injury keeps you out of work (S.C. Code &sect; 42-9-10(A)). These wage-replacement benefits are <strong>not taxable</strong>.</p>

<p>How much you actually receive depends on your average weekly wage, an annual maximum and minimum, the type of disability, and how long it lasts. Below, a Roden Law attorney breaks down the rates, the waiting period, the caps, and the medical and mileage benefits. Roden Law works on a contingency fee basis &mdash; no upfront cost and no fees unless we win. Note: the dollar maximums and the mileage rate below are <strong>updated annually</strong>, so always confirm the figure that applies to your date of injury.</p>

<h2>How much does South Carolina workers\' comp pay per week?</h2>
<p>The basic weekly benefit is <strong>66&frac23;% of your average weekly wage</strong>, which is figured from your earnings (typically over the four quarters before your injury, as defined in &sect; 42-1-40). That amount is then capped at an annual maximum and floored at a minimum:</p>
<ul>
<li><strong>Maximum:</strong> set each year and applied by your date of injury. <strong>For injuries occurring in 2026, the maximum is $1,189.94 per week</strong> (for injuries in 2025 it was $1,134.43). This figure is tied to the statewide average weekly wage and changes every year.</li>
<li><strong>Minimum:</strong> <strong>$75 per week</strong>, fixed in statute &mdash; unless your average weekly wage is less than $75, in which case you receive your full average weekly wage.</li>
</ul>
<p>So a worker earning a $900 average weekly wage would receive about $600 per week (66&frac23;% of $900), comfortably under the 2026 maximum. A high earner is capped at the annual maximum no matter how high their wages were.</p>

<h2>Is there a waiting period before benefits start?</h2>
<p>Yes. Under <strong>S.C. Code &sect; 42-9-200</strong>, no wage-loss benefits are paid for the <strong>first 7 calendar days</strong> of disability. However, if your disability lasts <strong>more than 14 days</strong>, you are paid <strong>retroactively from day one</strong> &mdash; so the waiting period effectively disappears for longer disabilities. Importantly, the waiting period applies only to wage benefits. <strong>Medical benefits are paid from day one</strong>, with no waiting period.</p>

<h2>What types of disability benefits are there?</h2>
<ul>
<li><strong>Temporary total disability (TTD):</strong> paid at 66&frac23;% of your AWW while you are completely unable to work and still recovering.</li>
<li><strong>Temporary partial disability (TPD):</strong> if you can do some work but earn less than before, you receive <strong>66&frac23;% of the difference</strong> between your pre-injury AWW and what you can earn now, under &sect; 42-9-20. TPD is <strong>capped at 340 weeks</strong>.</li>
<li><strong>Permanent partial disability (PPD):</strong> paid after you reach maximum medical improvement, based on the scheduled-member values in &sect; 42-9-30. See our <a href="/resources/south-carolina-workers-comp-body-part-values/">body part value chart</a> for how this is calculated.</li>
<li><strong>Permanent total disability (PTD):</strong> for the most severe injuries, discussed below.</li>
</ul>

<h2>How long can workers\' comp benefits last?</h2>
<p>Total disability benefits in South Carolina are generally <strong>capped at 500 weeks</strong> under &sect; 42-9-10(B). There is a critical exception: for <strong>paraplegia, quadriplegia, or physical brain damage</strong>, benefits are <strong>not capped</strong> and can be paid for the worker&rsquo;s lifetime under &sect; 42-9-10(C). Temporary partial disability is separately capped at 340 weeks.</p>

<h2>Does workers\' comp pay my medical bills and mileage?</h2>
<p>Yes. The employer or its insurer must pay for <strong>authorized medical treatment</strong> that tends to lessen your disability, under &sect; 42-15-60. In South Carolina, the employer generally <strong>directs your care and chooses the treating doctor</strong> &mdash; seeing an unauthorized doctor on your own can mean those bills are not covered, so it is important to follow the authorized treatment path or have your attorney challenge it.</p>
<p>You are also entitled to <strong>mileage reimbursement</strong> for travel to authorized medical appointments when the trip is <strong>more than 5 miles one-way</strong>. The mileage rate is <strong>set annually</strong>; <strong>as of January 1, 2026, it is 72.5 cents per mile</strong>. Keep a log of your medical trips so you can claim every reimbursable mile.</p>

<h2>How soon do I have to report my injury and file?</h2>
<p>South Carolina workers&rsquo; comp is a <strong>no-fault</strong> system &mdash; you do not have to prove your employer did anything wrong &mdash; but you must meet two deadlines. You must <strong>report your injury to your employer within 90 days</strong> (&sect; 42-15-20), and you must <strong>file your claim within 2 years</strong> (&sect; 42-15-40). Missing either deadline can bar your benefits entirely, so report promptly and file on time.</p>

<h2>Talk to a South Carolina workers\' comp attorney</h2>
<p>How much you receive depends heavily on how your average weekly wage is calculated and which disability benefits you pursue &mdash; numbers the insurance company has every reason to keep low. A Roden Law attorney can verify your comp rate, make sure you receive every benefit and reimbursable mile you are owed, and pursue a larger award if your injury is permanent. The review is free, and there are no fees unless we win.</p>
<p>For more, see our <a href="/resources/south-carolina-workers-comp-body-part-values/">body part value chart</a>, <a href="/resources/south-carolina-workers-comp-impairment-rating-mmi/">how MMI and impairment ratings work</a>, and <a href="/resources/south-carolina-workers-comp-claim-denied/">what to do if your claim is denied</a>. You can also learn about your rights on our <a href="/south-carolina-workers-compensation-lawyer/">South Carolina workers&rsquo; compensation</a> page and our <a href="/practice-areas/workers-compensation-lawyers/">workers&rsquo; compensation practice</a> page.</p>';

$faqs = array(
    array(
        'question' => 'How much does South Carolina workers\' comp pay per week?',
        'answer'   => 'South Carolina workers\' comp pays two-thirds (66⅔%) of your average weekly wage, subject to an annual maximum and minimum. The maximum is set each year by date of injury — for injuries occurring in 2026, it is $1,189.94 per week — and the minimum is $75 per week, unless your average weekly wage is less than $75, in which case you receive your full wage.',
    ),
    array(
        'question' => 'Is there a waiting period before South Carolina workers\' comp starts paying?',
        'answer'   => 'Yes. Under S.C. Code § 42-9-200, no wage-loss benefits are paid for the first 7 calendar days of disability. But if your disability lasts more than 14 days, you are paid retroactively back to day one. The waiting period applies only to wage benefits — medical benefits are paid from day one with no waiting period.',
    ),
    array(
        'question' => 'How long can South Carolina workers\' comp benefits last?',
        'answer'   => 'Total disability benefits are generally capped at 500 weeks under § 42-9-10(B). The major exception is for paraplegia, quadriplegia, or physical brain damage, which are not capped and can be paid for the worker\'s lifetime. Temporary partial disability benefits are separately capped at 340 weeks.',
    ),
    array(
        'question' => 'Does South Carolina workers\' comp pay for medical bills and mileage?',
        'answer'   => 'Yes. The employer or insurer pays for authorized medical treatment under § 42-15-60, and in South Carolina the employer generally directs your care and chooses the doctor. You are also reimbursed for mileage to authorized appointments more than 5 miles one-way; the rate is set annually and, as of January 1, 2026, is 72.5 cents per mile.',
    ),
    array(
        'question' => 'Are South Carolina workers\' comp benefits taxable?',
        'answer'   => 'No. Workers\' compensation wage-replacement benefits in South Carolina are not subject to federal or state income tax. That is one reason the two-thirds (66⅔%) wage rate often replaces a larger share of your take-home pay than the percentage alone suggests.',
    ),
    array(
        'question' => 'What is temporary partial disability in South Carolina workers\' comp?',
        'answer'   => 'Temporary partial disability (TPD) applies when you can return to some work but earn less than before your injury. Under § 42-9-20, you receive 66⅔% of the difference between your pre-injury average weekly wage and your reduced earning ability, and TPD benefits are capped at 340 weeks.',
    ),
);

$see_also = array(
    array(
        'url'  => '/resources/south-carolina-workers-comp-body-part-values/',
        'text' => 'South Carolina Workers\' Comp Body Part Value Chart',
    ),
    array(
        'url'  => '/resources/south-carolina-workers-comp-impairment-rating-mmi/',
        'text' => 'MMI and Impairment Ratings in SC Workers\' Comp',
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
