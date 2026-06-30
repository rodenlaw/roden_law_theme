<?php
/**
 * Seeder: INDEXABLE non-office city pillar "Florence SC Workers' Compensation Lawyer"
 * (SC competitor gap analysis 2026-06-29, roadmap row 5 — Upstate/Pee Dee P1).
 *
 * Florence is a NON-OFFICE city (Roden has no Florence office), so this is built
 * as a `page` CPT on templates/template-pillar-sc-statewide.php — the same
 * indexable pattern as the P0 statewide pillars. It CANNOT use the intersection
 * or neighborhood templates (those are hard-locked to the 5 office keys).
 *
 * Reuses the shared insert routine in _sc-pillar-insert.php verbatim.
 * Ships as a DRAFT. SC-only law (no GA O.C.G.A. bleed).
 *
 * NOTE: the template's shared SC-law callout shows the general 3-yr tort SOL,
 * which is NOT the workers'-comp deadline. This page states the WC deadlines
 * explicitly in the body: report to employer within 90 days (S.C. Code
 * § 42-15-20); file with the SC WC Commission within 2 years (§ 42-15-40).
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-city-florence-workers-comp.php
 *   wp rewrite flush
 *
 * ORCHESTRATOR: confirm no pre-existing slug collision before running — P0 hit
 * one. The include is idempotent and back-fills rather than duplicating.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$slug          = 'florence-sc-workers-compensation-lawyer';
$title         = 'Florence SC Workers\' Compensation Lawyer';
$template      = 'templates/template-pillar-sc-statewide.php';
$practice      = 'Workers\' Compensation';
$meta_desc     = 'Hurt on the job in Florence, SC? Roden Law\'s South Carolina workers\' compensation lawyers help Pee Dee workers report on time and fight denials. Free case review — no fee unless we win.';
$key_takeaways = 'If you were hurt on the job in Florence, South Carolina, you must report the injury to your employer within 90 days (S.C. Code § 42-15-20) and file your claim with the South Carolina Workers\' Compensation Commission within 2 years of the injury (S.C. Code § 42-15-40). Workers\' compensation is a no-fault system, so you do not have to prove your employer did anything wrong — but missing a deadline or accepting a lowball impairment rating can cost you benefits. Florence is the Pee Dee\'s healthcare, distribution, and transportation hub at the I-95/I-20 crossroads, and Roden Law\'s South Carolina workers\' compensation lawyers represent injured Pee Dee workers statewide on a contingency fee — no fees unless we win.';

$content = '<p>If you were injured at work in Florence, South Carolina, you may be worried about lost income, medical bills, and an insurer that is in no hurry to approve your care. Roden Law&rsquo;s South Carolina workers&rsquo; compensation lawyers help injured Pee Dee workers &mdash; in healthcare, distribution and warehousing, transportation, and the trades &mdash; obtain the medical treatment and wage benefits the law provides. We work on a contingency fee basis: you pay nothing upfront and no legal fees unless we win your case.</p>

<h2>What are the workers\' comp deadlines in South Carolina?</h2>
<p>South Carolina sets two deadlines you cannot afford to miss. First, you must <strong>report your injury to your employer within 90 days</strong> of the accident under <strong>S.C. Code &sect; 42-15-20</strong> &mdash; in writing and as soon as possible is best. Second, you must <strong>file your claim with the South Carolina Workers&rsquo; Compensation Commission within 2 years</strong> of the injury under <strong>S.C. Code &sect; 42-15-40</strong>. These deadlines differ from the general 3-year deadline that applies to car-accident and other injury lawsuits, so do not assume you have the same amount of time.</p>

<h2>Do I have to prove my employer was at fault?</h2>
<p>No. South Carolina workers&rsquo; compensation is a <strong>no-fault system</strong>. You generally do not have to prove your employer was negligent &mdash; only that you were injured in the course and scope of your job. In exchange, workers&rsquo; comp is usually your exclusive remedy against your employer. That makes the system simpler than a lawsuit, but insurers still dispute whether injuries are work-related, so careful documentation matters.</p>

<h2>What benefits can injured Florence workers receive?</h2>
<p>South Carolina workers&rsquo; compensation can cover authorized medical treatment, a portion of your lost wages while you cannot work, and compensation for permanent impairment based on a disability rating. According to the South Carolina Workers&rsquo; Compensation Commission&rsquo;s schedule, different body parts carry different benefit values, and the impairment rating set at maximum medical improvement directly affects your award. Insurers sometimes press for a lower rating or a quick settlement &mdash; a lawyer can help ensure your rating and benefits match your actual injury.</p>

<h2>What if my Florence workers\' comp claim is denied?</h2>
<p>A denial can be appealed. You can request a hearing before the South Carolina Workers&rsquo; Compensation Commission, where an attorney can present medical evidence and testimony for you. Insurers commonly deny by claiming the injury was not work-related, that a deadline was missed, or that a pre-existing condition is the real cause &mdash; arguments the right evidence can overcome. Roden Law handles the hearing process so you can focus on getting better.</p>

<h2>Where do injured Florence workers get hurt?</h2>
<p>Florence is the economic anchor of the Pee Dee, built around <strong>MUSC Health Florence</strong> and <strong>McLeod Regional Medical Center</strong>, large distribution and manufacturing operations, and the freight traffic drawn by the <strong>I-95 and I-20</strong> crossroads. Healthcare-worker injuries, warehouse and forklift accidents, trucking and loading-dock injuries, and manufacturing-line injuries are common. Workers&rsquo; comp claims arising in Florence are administered through the statewide South Carolina Workers&rsquo; Compensation Commission, not a local court.</p>

<h2>Talk to a South Carolina workers\' comp lawyer for free</h2>
<p>Roden Law represents Florence and Pee Dee workers even though our nearest offices are in Columbia, Myrtle Beach, Charleston, and North Charleston. A South Carolina workers&rsquo; compensation attorney will review your case at no cost, confirm your deadlines, and fight a denial if one comes. There are no fees unless we win. Learn more about your rights on our <a href="/south-carolina-workers-compensation-lawyer/">South Carolina workers&rsquo; compensation</a> page and our <a href="/practice-areas/workers-compensation-lawyers/">workers&rsquo; compensation practice</a>.</p>';

$faqs = array(
    array(
        'question' => 'How long do I have to report a work injury in Florence, SC?',
        'answer'   => 'You must report your injury to your employer within 90 days of the accident under S.C. Code § 42-15-20. Reporting in writing as soon as possible is best, because delay gives the insurer a reason to dispute that the injury was work-related.',
    ),
    array(
        'question' => 'How long do I have to file a workers\' comp claim in South Carolina?',
        'answer'   => 'You must file your claim with the South Carolina Workers\' Compensation Commission within 2 years of the injury under S.C. Code § 42-15-40. This is separate from the 90-day deadline to report the injury to your employer.',
    ),
    array(
        'question' => 'Do I have to prove my employer was at fault to get workers\' comp?',
        'answer'   => 'No. South Carolina workers\' compensation is a no-fault system. You generally only have to show you were injured in the course and scope of your job — not that your employer did anything wrong.',
    ),
    array(
        'question' => 'What can I do if my Florence workers\' comp claim is denied?',
        'answer'   => 'You can request a hearing before the South Carolina Workers\' Compensation Commission. An attorney can present medical evidence and testimony to overcome common denial reasons, such as a claim that the injury was not work-related or that a deadline was missed.',
    ),
    array(
        'question' => 'Does Roden Law have an office in Florence?',
        'answer'   => 'Roden Law does not have a Florence office, but our South Carolina workers\' compensation lawyers represent injured Pee Dee workers statewide. Claims are administered through the statewide SC Workers\' Compensation Commission, and a free case review is available wherever you are.',
    ),
    array(
        'question' => 'How much does a South Carolina workers\' comp lawyer cost?',
        'answer'   => 'Roden Law handles workers\' compensation cases on a contingency fee basis. You pay nothing upfront and no legal fees unless we win benefits for you. Attorney fees in SC workers\' comp cases are also subject to Commission approval.',
    ),
);

require __DIR__ . '/_sc-pillar-insert.php';
