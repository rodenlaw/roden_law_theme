<?php
/**
 * Seeder: "Stacking UM/UIM Coverage in South Carolina" explainer.
 *
 * SC-law explainer hub, page 3 of 4 (SC competitor gap analysis 2026-06-29, P0-1).
 * Promotes content Roden already references inline into its own citable page.
 * South-Carolina-only. Ships as DRAFT for human review.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-resource-sc-um-uim-stacking.php
 *
 * NOTE: UM/UIM stacking mechanics are nuanced and policy-dependent. Statutory
 * framework (S.C. Code §§ 38-77-140/150/160) plus the class-one/class-two and
 * vehicle-involvement rules verified against the SC Code + case law 2026-06-30.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title         = 'Stacking UM and UIM Coverage in South Carolina';
$slug          = 'south-carolina-um-uim-stacking';
$meta_desc     = 'South Carolina lets drivers stack uninsured (UM) and underinsured (UIM) coverage across multiple vehicles or policies — potentially multiplying what you can recover.';
$key_takeaways = 'South Carolina allows injured drivers to stack uninsured motorist (UM) and underinsured motorist (UIM) coverage, meaning you may combine the coverage limits from more than one vehicle or policy to increase what you can recover after a crash with an uninsured or underinsured driver. Stacking can dramatically raise the money available when the at-fault driver carries little or no insurance. Whether and how you can stack depends on your specific policies and how the coverage was purchased, so the policies must be reviewed carefully. Because insurers do not volunteer stacking, having an attorney examine every available policy is often the difference between a capped payout and full compensation.';
$content       = '<p>South Carolina is one of the states that allows drivers to <strong>stack</strong> uninsured motorist (UM) and underinsured motorist (UIM) coverage &mdash; that is, to combine the coverage limits from more than one vehicle or more than one policy to increase the total money available after a crash. When you are hit by a driver who has no insurance or not enough insurance, stacking can be the difference between a payout capped at one small policy limit and a recovery large enough to actually cover your medical bills, lost income, and other losses.</p>

<p>This page explains, in plain language, what UM and UIM coverage are, how stacking works in South Carolina, and why having an attorney review every available policy matters so much. South Carolina&rsquo;s uninsured and underinsured motorist rules are set out in <strong>S.C. Code &sect;&sect; 38-77-140, 38-77-150, and 38-77-160</strong>, and the right to stack has been shaped by decades of South Carolina court decisions. Roden Law works on a contingency fee basis &mdash; no upfront cost, and no legal fees unless we win.</p>

<h2>What are UM and UIM coverage?</h2>
<p>UM and UIM are the parts of your own auto policy that protect you when the at-fault driver cannot:</p>
<ul>
<li><strong>Uninsured motorist (UM) coverage</strong> pays for your injuries when the at-fault driver has <em>no</em> liability insurance, or in hit-and-run situations where the driver cannot be identified.</li>
<li><strong>Underinsured motorist (UIM) coverage</strong> pays when the at-fault driver <em>does</em> have insurance, but not enough to cover the full extent of your injuries.</li>
</ul>
<p>These coverages matter because South Carolina&rsquo;s minimum required liability limits are relatively low. When a seriously injured person is hit by a driver carrying only the minimum, the at-fault policy can run out long before the medical bills do. UM and UIM &mdash; especially when stacked &mdash; fill that gap.</p>

<h2>What does it mean to "stack" coverage in South Carolina?</h2>
<p>Stacking means combining UM or UIM limits from more than one source to create a larger pool of coverage. There are two common forms:</p>
<ul>
<li><strong>Intra-policy stacking</strong> &mdash; combining the coverage on multiple vehicles insured under a single policy.</li>
<li><strong>Inter-policy stacking</strong> &mdash; combining coverage from separate policies that may apply to you.</li>
</ul>
<p>For example, if you have UIM coverage on two vehicles in your household, stacking may allow you to combine those limits rather than being held to just one. The result can multiply the coverage available to pay your claim. Whether you can stack depends in part on your relationship to the policyholder: South Carolina generally allows the <strong>named insured, their spouse, and resident relatives</strong> (so-called "class one" insureds) to stack across vehicles and policies, while a passenger or permissive driver ("class two") is usually limited to the coverage on the vehicle they were in. The rules also turn on which vehicles and policies were involved in the crash, which is exactly why every potentially applicable policy needs to be reviewed.</p>

<h2>Why stacking can dramatically increase your recovery</h2>
<p>The value of stacking is easiest to see with the math. Suppose an uninsured driver causes a crash that leaves you with $200,000 in damages, and you carry $100,000 in UM coverage on each of two household vehicles. Without stacking, you might be limited to a single $100,000 limit. With stacking, you may be able to combine them toward your $200,000 in losses. The same logic applies to UIM when the at-fault driver&rsquo;s policy is too small to cover serious injuries.</p>
<p>This is exactly why insurance companies do not go out of their way to tell you that stacking might be available &mdash; it costs them more. Identifying every policy that could apply, and determining whether and how it can be stacked, is a core part of maximizing a serious South Carolina injury claim.</p>

<h2>How do I know if I can stack my coverage?</h2>
<p>Whether you can stack &mdash; and how much &mdash; depends on the specific language of your policies, how the coverage was purchased, the number of vehicles and policies involved, and your relationship to the policyholders. Because the answer turns on policy details that are easy to misread, the safest approach is to have an attorney obtain and review <em>every</em> policy that might cover you: your own, those in your household, and sometimes others. People are frequently told "that&rsquo;s all the coverage there is" when, in fact, additional stackable coverage exists.</p>
<p>If you were hurt by an uninsured or underinsured driver in South Carolina, a Roden Law attorney can review your policies at no cost and identify all the coverage that may be available to you.</p>

<h2>Hit by an uninsured or underinsured driver in South Carolina?</h2>
<p>Being injured by a driver who carried little or no insurance is frustrating and frightening &mdash; but it does not mean you are out of options. South Carolina&rsquo;s UM/UIM and stacking rules exist precisely for this situation. Roden Law&rsquo;s South Carolina attorneys will dig through every applicable policy, pursue stacked coverage where the law allows, and fight for the full value of your claim.</p>
<p>For related guidance, see our overview of the <a href="/resources/south-carolina-statute-of-limitations/">South Carolina statute of limitations</a>, how <a href="/resources/south-carolina-comparative-negligence/">comparative negligence</a> affects recovery, and our <a href="/practice-areas/car-accident-lawyers/">car accident</a> practice page. You can also reach our <a href="/locations/south-carolina/charleston/">Charleston office</a> at (843) 790-8999.</p>';

$faqs = array(
    array(
        'question' => 'Can you stack UM and UIM coverage in South Carolina?',
        'answer'   => 'Yes. South Carolina allows drivers to stack uninsured (UM) and underinsured (UIM) motorist coverage in many situations, meaning you may combine coverage limits from more than one vehicle or policy to increase what you can recover. Whether and how you can stack depends on your specific policies, so each policy must be reviewed carefully.',
    ),
    array(
        'question' => 'What is the difference between UM and UIM coverage?',
        'answer'   => 'Uninsured motorist (UM) coverage pays for your injuries when the at-fault driver has no liability insurance, or in hit-and-run cases where the driver cannot be identified. Underinsured motorist (UIM) coverage pays when the at-fault driver has insurance but not enough to cover the full extent of your injuries. Both protect you through your own policy.',
    ),
    array(
        'question' => 'How does stacking increase my recovery in South Carolina?',
        'answer'   => 'Stacking combines coverage limits from multiple vehicles or policies into a larger pool. For example, if you have $100,000 in UM coverage on each of two household vehicles, stacking may let you combine them toward your losses rather than being capped at a single limit. This can multiply the money available when the at-fault driver has little or no insurance.',
    ),
    array(
        'question' => 'How do I know if I can stack my coverage?',
        'answer'   => 'It depends on your policy language, how the coverage was purchased, the number of vehicles and policies involved, and your relationship to the policyholders. Because the answer turns on details that are easy to misread, the safest approach is to have an attorney review every policy that might apply — people are often wrongly told that no additional coverage exists.',
    ),
);

$see_also = array(
    array(
        'url'  => '/resources/south-carolina-statute-of-limitations/',
        'text' => 'South Carolina Statute of Limitations for Injury Claims',
    ),
    array(
        'url'  => '/resources/south-carolina-comparative-negligence/',
        'text' => 'South Carolina Comparative Negligence — the 51% Bar',
    ),
    array(
        'url'  => '/practice-areas/car-accident-lawyers/',
        'text' => 'South Carolina Car Accident Lawyers',
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
