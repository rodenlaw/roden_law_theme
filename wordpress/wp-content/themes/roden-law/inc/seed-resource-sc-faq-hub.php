<?php
/**
 * Seeder: South Carolina Personal Injury FAQ hub (v1 — 20 highest-intent questions).
 *
 * SC competitor gap analysis 2026-06-29, P0-2. Competitors run huge un-schema'd
 * FAQ libraries (Sink 145, Steinberg 74, Derrick 138); Roden has none. This ships
 * the 20 highest-intent SC questions as a single resource page whose _roden_faqs
 * meta auto-emits FAQPage schema (schema-helpers.php) — so it out-formats every
 * competitor FAQ from day one WITHOUT needing new /faq/ routing or a new CPT.
 *
 * South-Carolina-only law. Ships as DRAFT for human review. The FAQ list is
 * deliberately kept to a single page to stay under the WP Engine eval-file size
 * limit (<200 lines) — FAQ v2 (80-120 Qs) is a separate, later batch.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-resource-sc-faq-hub.php
 *
 * Idempotent — skips if the slug already exists.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title         = 'South Carolina Personal Injury FAQ';
$slug          = 'south-carolina-personal-injury-faq';
$meta_desc     = 'Answers to the most common South Carolina personal injury questions: deadlines, fault, settlement value, medical bills, and whether you need a lawyer.';
$key_takeaways = 'In South Carolina you generally have 3 years to file a personal injury claim (S.C. Code § 15-3-530), and you can recover as long as you are less than 51% at fault. There is no fixed "average" settlement — value depends on your injuries, losses, fault, and available insurance. You are never required to hire a lawyer, but represented claimants typically recover significantly more, and Roden Law works on contingency, so there are no fees unless we win. The answers below cover the questions South Carolina injury victims ask most.';
$content       = '<p>If you have been injured in South Carolina, you probably have urgent questions: How long do I have to file? What if the crash was partly my fault? How much is my case worth? Do I even need a lawyer? Below, Roden Law answers the most common South Carolina personal injury questions in plain language. These answers describe <strong>South Carolina law</strong> specifically.</p>

<p>This page is a starting point, not legal advice for your specific situation. Every case is different. If you want answers tailored to your case, a Roden Law attorney will review it for free &mdash; and we work on a contingency fee basis, so there are no fees unless we win.</p>

<h2>South Carolina personal injury questions, answered</h2>
<p>The questions below are grouped by what injured people search for most: deadlines, fault, settlement value, medical bills, and working with a lawyer. For deeper explainers, see our guides to the <a href="/resources/south-carolina-statute-of-limitations/">South Carolina statute of limitations</a> and <a href="/resources/south-carolina-comparative-negligence/">comparative negligence</a>.</p>

<h2>Still have questions? Talk to a South Carolina attorney</h2>
<p>If your question is not answered here &mdash; or you want to know what your specific case is worth &mdash; a Roden Law attorney will review your situation at no cost. Call us or request a free case review. There are no fees unless we win.</p>
<p>You can reach our <a href="/locations/south-carolina/charleston/">Charleston office</a> at (843) 790-8999, our <a href="/locations/south-carolina/columbia/">Columbia office</a> at (803) 219-2816, or our Myrtle Beach office at (843) 612-1980.</p>';

// 20 highest-intent SC questions (seeded from competitor question inventories;
// all answers are South-Carolina-specific). Drives the FAQPage schema + accordion.
$faqs = array(
    array( 'question' => 'How long do I have to file a personal injury claim in South Carolina?',
        'answer' => 'In South Carolina, you generally have 3 years from the date of injury to file a personal injury lawsuit under S.C. Code § 15-3-530. Claims against government entities have a shorter deadline, and medical malpractice has special discovery and repose rules. Because missing the deadline usually bars your claim entirely, it is best to confirm your specific deadline with an attorney early.' ),
    array( 'question' => 'What is the statute of limitations for a car accident in South Carolina?',
        'answer' => 'A South Carolina car accident claim must generally be filed within 3 years of the crash (S.C. Code § 15-3-530). If a city, county, or state vehicle was involved, a shorter government-claims deadline may apply. Acting early also helps preserve evidence like vehicle data and witness statements.' ),
    array( 'question' => 'Can I still recover if the accident was partly my fault in South Carolina?',
        'answer' => 'Yes. South Carolina uses modified comparative negligence with a 51% bar. You can recover as long as you are less than 51% at fault, but your award is reduced by your fault percentage. For example, on a $200,000 case where you are 25% at fault, you recover $150,000. At 51% or more fault, you recover nothing.' ),
    array( 'question' => 'Is South Carolina a no-fault state for car accidents?',
        'answer' => 'No. South Carolina is an at-fault (tort) state, not a no-fault state. The driver who caused the crash — and their insurance — is responsible for the resulting injuries and damages. This is different from no-fault states where you turn first to your own insurer regardless of who caused the crash.' ),
    array( 'question' => 'How much is my personal injury case worth in South Carolina?',
        'answer' => 'There is no fixed average. Your case value depends on the severity of your injuries, your total medical bills and lost income, the impact on your life, your share of fault, and the available insurance coverage. Cases range from a few thousand dollars for minor injuries to seven figures for catastrophic ones. An attorney can give you an honest estimate after reviewing the facts.' ),
    array( 'question' => 'What is the average car accident settlement in South Carolina?',
        'answer' => 'There is no reliable single average, because settlements span a wide range based on injury severity, fault, and insurance limits. Minor soft-tissue cases may settle for a few thousand dollars, while serious-injury cases reach six or seven figures. Be skeptical of any "average" figure — your case is valued on its own specific facts.' ),
    array( 'question' => 'Who pays my medical bills after an accident in South Carolina?',
        'answer' => 'In the short term, your own health insurance, MedPay coverage, or out-of-pocket payments typically cover treatment. Ultimately, if another party was at fault, their liability insurance should reimburse your medical expenses as part of your injury claim. An attorney can help coordinate these sources and pursue full reimbursement from the at-fault party.' ),
    array( 'question' => 'Do I need a lawyer for a personal injury claim in South Carolina?',
        'answer' => 'You are not legally required to hire a lawyer, but represented claimants typically recover significantly more, even after fees. Insurers have adjusters and lawyers working to minimize your payout. An attorney investigates, values your claim accurately, handles the insurers, and litigates if needed. Roden Law works on contingency, so you pay nothing unless we win.' ),
    array( 'question' => 'How much does a personal injury lawyer cost in South Carolina?',
        'answer' => 'Roden Law handles personal injury cases on a contingency fee basis: you pay no attorney fees upfront and owe nothing unless we win. Our fee is a percentage of the recovery. If we do not win, you do not pay attorney fees. This lets anyone access experienced representation regardless of their finances.' ),
    array( 'question' => 'What should I do immediately after an accident in South Carolina?',
        'answer' => 'Seek medical attention right away, even if you feel fine — some serious injuries are not obvious at first. Call the police and get a report, document the scene with photos, collect witness contact information, and preserve evidence. Do not give a recorded statement to any insurer before speaking with an attorney, and contact a lawyer early so an investigation can begin while evidence is fresh.' ),
    array( 'question' => 'How long does a personal injury case take in South Carolina?',
        'answer' => 'It varies widely. Straightforward claims may resolve in a few months, while serious-injury cases that require full medical treatment, investigation, or litigation can take a year or more. Settling too early — before your injuries are fully understood — often leaves money on the table, so timing should follow your recovery and the strength of the evidence.' ),
    array( 'question' => 'What if I was injured by an uninsured driver in South Carolina?',
        'answer' => 'You may still recover through your own uninsured motorist (UM) coverage, and South Carolina allows stacking of UM and underinsured (UIM) coverage in many situations, which can combine limits from multiple vehicles or policies. Having an attorney review every applicable policy is often the difference between a capped payout and full compensation.' ),
    array( 'question' => 'How does comparative fault affect my settlement in South Carolina?',
        'answer' => 'Your recovery is reduced by your percentage of fault, and you are barred entirely if you are 51% or more at fault. On a $300,000 case, 20% fault leaves you $240,000, while 51% fault leaves you nothing. Insurers try to inflate your fault to cut your payout, which is why how fault is assigned has a direct dollar impact.' ),
    array( 'question' => 'Should I accept the insurance company\'s first offer in South Carolina?',
        'answer' => 'Usually not. First offers are typically far below the full value of a claim and are made before you fully understand your injuries and future costs. Once you accept and sign a release, you cannot reopen the claim. It is wise to have an attorney evaluate any offer before you accept it.' ),
    array( 'question' => 'What is the deadline for a wrongful death claim in South Carolina?',
        'answer' => 'A South Carolina wrongful death claim generally must be filed within 3 years and must be brought by the personal representative of the deceased person\'s estate (S.C. Code § 15-51-20). Because the rules around who can file and how damages are distributed are specific, families should consult an attorney promptly.' ),
    array( 'question' => 'Is there a cap on damages in South Carolina personal injury cases?',
        'answer' => 'In ordinary injury cases, such as car and truck crashes, there is no general cap on compensatory damages. South Carolina does cap noneconomic damages in medical malpractice cases, and punitive damages are subject to statutory limits. Most accident victims pursuing standard negligence claims are not affected by a noneconomic cap.' ),
    array( 'question' => 'Can I sue the government if a public vehicle or road caused my injury in South Carolina?',
        'answer' => 'Yes, but claims against government entities fall under the South Carolina Tort Claims Act (S.C. Code § 15-78-10 et seq.), which has a shorter deadline and special notice requirements than ordinary claims. If any government body may be responsible, contact an attorney immediately so you do not miss the shorter window.' ),
    array( 'question' => 'What types of compensation can I recover in a South Carolina injury case?',
        'answer' => 'You may recover economic damages (medical bills, lost wages, lost earning capacity, property damage) and noneconomic damages (pain and suffering, emotional distress, loss of enjoyment of life, disfigurement). In cases of egregious conduct, punitive damages may also be available. The total depends on the severity of your injuries and the strength of the evidence.' ),
    array( 'question' => 'Do I have to go to court for my South Carolina personal injury claim?',
        'answer' => 'Most personal injury claims settle without a trial. However, if the insurer refuses to offer fair compensation, your attorney may file suit and take the case toward trial. Having a firm that is willing and able to go to court often improves settlement offers, because insurers know the claim can be tried if necessary.' ),
    array( 'question' => 'How soon should I contact a lawyer after an accident in South Carolina?',
        'answer' => 'As soon as possible. Early involvement lets an attorney preserve evidence, identify all liable parties, deal with insurers before they pressure you, and protect your deadline. Waiting can let evidence disappear and deadlines approach. The consultation is free, and there are no fees unless we win.' ),
);

$see_also = array(
    array( 'url' => '/resources/south-carolina-statute-of-limitations/', 'text' => 'South Carolina Statute of Limitations for Injury Claims' ),
    array( 'url' => '/resources/south-carolina-comparative-negligence/', 'text' => 'South Carolina Comparative Negligence — the 51% Bar' ),
    array( 'url' => '/practice-areas/car-accident-lawyers/', 'text' => 'South Carolina Car Accident Lawyers' ),
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
WP_CLI::log( '- ' . count( $faqs ) . ' FAQs (FAQPage schema auto-emitted), Key Takeaways set, author ID ' . $author_id . '.' );
WP_CLI::log( 'Done.' );
