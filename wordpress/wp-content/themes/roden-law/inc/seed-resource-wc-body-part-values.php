<?php
/**
 * Seeder: "South Carolina Workers' Comp Body Part Value Chart" explainer.
 *
 * SC workers'-comp explainer set, page 1 of 4 (SC competitor gap analysis
 * 2026-06-29, P1 row 6). Out-formats Joye's body-part-values page with the
 * verified S.C. Code § 42-9-30 scheduled-member week table + FAQPage schema.
 * South-Carolina-only jurisdiction. Ships as DRAFT for human review.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-resource-wc-body-part-values.php
 *
 * Idempotent — skips if the slug already exists.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title         = 'South Carolina Workers\' Comp Body Part Value Chart';
$slug          = 'south-carolina-workers-comp-body-part-values';
$meta_desc     = 'South Carolina\'s workers\' comp body-part value chart under S.C. Code § 42-9-30: how many weeks of benefits each scheduled member (arm, hand, back, eye, more) is worth.';
$key_takeaways = 'South Carolina\'s workers\' compensation law assigns a set number of weeks of benefits to each body part under the "scheduled member" table in S.C. Code § 42-9-30. Each award is paid at two-thirds (66⅔%) of your average weekly wage for the listed number of weeks. For example, the loss of a hand is worth 185 weeks, an arm 220 weeks, and a leg 195 weeks. The back is the key exception: it is worth 300 weeks if you have 49% or less loss of use, but 500 weeks if you have 50% or more loss of use (and a 50%-or-more back injury triggers a rebuttable presumption of total and permanent disability). A partial loss of use is paid proportionally — for example, 50% loss of use of a hand equals 92.5 weeks. These week values are fixed by statute, but the dollar amount depends on your wages, which is why having your impairment rating and wage calculation done correctly matters.';
$content       = '<p>South Carolina workers&rsquo; compensation law puts a specific value on most body parts. Under the <strong>scheduled-member table in S.C. Code &sect; 42-9-30</strong>, each body part is assigned a set number of weeks of benefits, and each week is paid at <strong>two-thirds (66&frac23;%) of your average weekly wage (AWW)</strong>. So a permanent injury to a scheduled body part is worth: <em>(weeks for that part) &times; (impairment percentage) &times; (66&frac23;% of your AWW)</em>.</p>

<p>The table below lists the verified week values from &sect; 42-9-30. Below it, a Roden Law attorney explains how to read the schedule, how partial loss of use is calculated, and why the back is treated differently from every other body part. Roden Law works on a contingency fee basis &mdash; no upfront cost and no fees unless we win.</p>

<h2>How many weeks is each body part worth in South Carolina?</h2>
<p>Each scheduled body part below is paid at 66&frac23;% of your average weekly wage for the listed number of weeks (for a total loss of use). A <strong>partial</strong> loss of use is paid proportionally &mdash; for example, 50% loss of use of a hand is 50% &times; 185 = 92.5 weeks.</p>
<table>
<tr><th>Body part (scheduled member)</th><th>Maximum weeks of benefits</th></tr>
<tr><td>Thumb</td><td>65</td></tr>
<tr><td>Index finger</td><td>40</td></tr>
<tr><td>Second finger</td><td>35</td></tr>
<tr><td>Third finger</td><td>25</td></tr>
<tr><td>Fourth (little) finger</td><td>20</td></tr>
<tr><td>Great toe</td><td>35</td></tr>
<tr><td>Other toe</td><td>10</td></tr>
<tr><td>Hand</td><td>185</td></tr>
<tr><td>Arm</td><td>220</td></tr>
<tr><td>Shoulder</td><td>300</td></tr>
<tr><td>Foot</td><td>140</td></tr>
<tr><td>Leg</td><td>195</td></tr>
<tr><td>Hip</td><td>280</td></tr>
<tr><td>Eye (or total loss of vision)</td><td>140</td></tr>
<tr><td>Hearing, one ear</td><td>80</td></tr>
<tr><td>Hearing, both ears</td><td>165</td></tr>
<tr><td>Back &mdash; 49% or less loss of use</td><td>300</td></tr>
<tr><td>Back &mdash; 50% or more loss of use</td><td>500 (and presumed total &amp; permanent disability)</td></tr>
<tr><td>Unscheduled / &ldquo;whole person&rdquo; injury</td><td>up to 500</td></tr>
<tr><td>Serious permanent disfigurement (face, head, neck, or other exposed area, including burn or keloid scars)</td><td>up to 50</td></tr>
</table>

<h2>How do I calculate what my injury is worth?</h2>
<p>Three numbers drive a scheduled award in South Carolina:</p>
<ul>
<li><strong>The scheduled weeks</strong> for the injured body part (from the table above).</li>
<li><strong>Your impairment / loss-of-use percentage</strong>, set at maximum medical improvement (MMI).</li>
<li><strong>Your compensation rate</strong> &mdash; 66&frac23;% of your average weekly wage.</li>
</ul>
<p>Multiply them together. Example: a worker with a 50% loss of use of a hand has 50% &times; 185 weeks = 92.5 weeks of benefits, paid at 66&frac23;% of that worker&rsquo;s average weekly wage. If the worker&rsquo;s comp rate were $600 per week, that award would be 92.5 &times; $600 = $55,500.</p>

<h2>Why is the back worth more than other body parts?</h2>
<p>The back is the one scheduled member with two tiers. A back injury with <strong>49% or less loss of use is worth up to 300 weeks</strong>, but a back injury with <strong>50% or more loss of use is worth up to 500 weeks</strong>. Just as important: a back injury rated at <strong>50% or more loss of use triggers a rebuttable presumption of total and permanent disability</strong> &mdash; meaning the law presumes the worker is totally and permanently disabled unless that presumption is rebutted. This is why the difference between a 49% and a 50% back rating can be worth hundreds of weeks of benefits, and why the rating is so heavily contested.</p>

<h2>What is a &ldquo;scheduled&rdquo; vs. &ldquo;unscheduled&rdquo; injury?</h2>
<p>A <strong>scheduled member</strong> is a body part that appears on the &sect; 42-9-30 list &mdash; an arm, hand, leg, eye, and so on. An <strong>unscheduled</strong> injury (sometimes called a &ldquo;whole person&rdquo; injury) is one not on the list, such as an injury to an internal organ or a more general bodily condition. Unscheduled injuries are compensated based on loss of earning capacity, up to 500 weeks. Disfigurement &mdash; serious permanent scarring of the face, head, neck, or another normally exposed area, including burn or keloid scars &mdash; is a separate category worth up to 50 weeks.</p>

<h2>Can I recover more than the scheduled amount?</h2>
<p>Sometimes, yes. The scheduled value is a <strong>floor, not a ceiling</strong>. Instead of taking the scheduled award, an injured worker may be able to pursue a <strong>loss of earning capacity (wage-loss) claim under S.C. Code &sect; 42-9-20</strong> or a <strong>total disability claim under &sect; 42-9-10</strong>, either of which can pay more than the scheduled weeks if the injury affects the worker&rsquo;s ability to earn a living. Which path produces the larger recovery depends on your wages, your work restrictions, and the medical evidence &mdash; an analysis a workers&rsquo; comp attorney can run for you.</p>

<h2>Talk to a South Carolina workers\' comp attorney about your rating</h2>
<p>The number of weeks your injury is worth depends on a loss-of-use percentage that the insurance company and its doctors have every incentive to keep low. A Roden Law attorney can review your impairment rating, your wage calculation, and whether a wage-loss or total-disability claim would pay you more than the schedule. The review is free, and there are no fees unless we win.</p>
<p>For more, see <a href="/resources/south-carolina-workers-comp-impairment-rating-mmi/">how MMI and impairment ratings work</a>, <a href="/resources/how-much-does-south-carolina-workers-comp-pay/">how much South Carolina workers&rsquo; comp pays</a>, and <a href="/resources/south-carolina-workers-comp-claim-denied/">what to do if your claim is denied</a>. You can also learn about your rights on our <a href="/south-carolina-workers-compensation-lawyer/">South Carolina workers&rsquo; compensation</a> page and our <a href="/practice-areas/workers-compensation-lawyers/">workers&rsquo; compensation practice</a> page.</p>';

$faqs = array(
    array(
        'question' => 'How many weeks of benefits is a body part worth in South Carolina workers\' comp?',
        'answer'   => 'S.C. Code § 42-9-30 sets a number of weeks for each body part, paid at two-thirds (66⅔%) of your average weekly wage. Key values include a hand at 185 weeks, an arm at 220 weeks, a leg at 195 weeks, a foot at 140 weeks, an eye at 140 weeks, and a shoulder at 300 weeks. The back is worth 300 weeks at 49% or less loss of use and 500 weeks at 50% or more.',
    ),
    array(
        'question' => 'How is the value of my injury calculated?',
        'answer'   => 'Multiply three numbers: the scheduled weeks for the injured body part, your loss-of-use percentage (set at maximum medical improvement), and your compensation rate (66⅔% of your average weekly wage). For example, a 50% loss of use of a hand is 50% × 185 = 92.5 weeks, paid at your comp rate.',
    ),
    array(
        'question' => 'Why is a back injury worth more in South Carolina?',
        'answer'   => 'The back is the one scheduled member with two tiers. A back injury with 49% or less loss of use is worth up to 300 weeks, while a back injury with 50% or more loss of use is worth up to 500 weeks. A back rated at 50% or more also triggers a rebuttable presumption of total and permanent disability, which is why the rating is heavily contested.',
    ),
    array(
        'question' => 'What is the difference between a scheduled and unscheduled injury?',
        'answer'   => 'A scheduled member is a body part on the § 42-9-30 list, such as an arm, hand, leg, or eye. An unscheduled or "whole person" injury is one not on the list and is compensated based on loss of earning capacity, up to 500 weeks. Disfigurement of a normally exposed area is a separate category worth up to 50 weeks.',
    ),
    array(
        'question' => 'Can I get more than the scheduled amount for my injury?',
        'answer'   => 'Sometimes. The scheduled value is a floor, not a ceiling. Instead of the scheduled award, you may be able to pursue a loss of earning capacity (wage-loss) claim under S.C. Code § 42-9-20 or a total disability claim under § 42-9-10, either of which can pay more if the injury affects your ability to earn a living.',
    ),
    array(
        'question' => 'How does a partial loss of use affect my award?',
        'answer'   => 'A partial loss of use is paid proportionally under § 42-9-30. For example, a 50% loss of use of a hand equals 50% × 185 = 92.5 weeks, and a 25% loss of use of a leg equals 25% × 195 = 48.75 weeks. The percentage comes from your loss-of-use rating, which is set once you reach maximum medical improvement.',
    ),
);

$see_also = array(
    array(
        'url'  => '/resources/how-much-does-south-carolina-workers-comp-pay/',
        'text' => 'How Much Does South Carolina Workers\' Comp Pay?',
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
