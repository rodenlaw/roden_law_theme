<?php
/**
 * Seeder: INDEXABLE non-office city pillar "Spartanburg SC Workers' Compensation Lawyer"
 * (SC competitor gap analysis 2026-06-29, roadmap row 5 — Upstate/Pee Dee P1).
 *
 * Spartanburg is a NON-OFFICE city (Roden has no Spartanburg office), so this is
 * built as a `page` CPT on templates/template-pillar-sc-statewide.php — the same
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
 *   wp eval-file wp-content/themes/roden-law/inc/seed-city-spartanburg-workers-comp.php
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

$slug          = 'spartanburg-sc-workers-compensation-lawyer';
$title         = 'Spartanburg SC Workers\' Compensation Lawyer';
$template      = 'templates/template-pillar-sc-statewide.php';
$practice      = 'Workers\' Compensation';
$meta_desc     = 'Hurt on the job in Spartanburg, SC? Roden Law\'s South Carolina workers\' compensation lawyers help Upstate workers report on time and fight denials. Free case review — no fee unless we win.';
$key_takeaways = 'If you were hurt on the job in Spartanburg, South Carolina, you must report the injury to your employer within 90 days (S.C. Code § 42-15-20) and file your claim with the South Carolina Workers\' Compensation Commission within 2 years of the injury (S.C. Code § 42-15-40). Workers\' compensation is a no-fault system, so you do not have to prove your employer did anything wrong — but missing a deadline or accepting a lowball impairment rating can cost you benefits. Spartanburg is a major Upstate manufacturing and logistics center along the I-85/I-26 corridor, and Roden Law\'s South Carolina workers\' compensation lawyers represent injured Upstate workers statewide on a contingency fee — no fees unless we win.';

$content = '<p>If you were injured at work in Spartanburg, South Carolina, you may be facing lost wages, mounting medical bills, and an insurer that is slow to approve treatment. Roden Law&rsquo;s South Carolina workers&rsquo; compensation lawyers help injured Upstate workers &mdash; on the manufacturing line, in warehouses and distribution centers, in healthcare, and in the trades &mdash; secure the medical care and wage benefits the law provides. We work on a contingency fee basis: you pay nothing upfront and no legal fees unless we win your case.</p>

<h2>What are the workers\' comp deadlines in South Carolina?</h2>
<p>South Carolina imposes two deadlines you cannot afford to miss. First, you must <strong>report your injury to your employer within 90 days</strong> of the accident under <strong>S.C. Code &sect; 42-15-20</strong> &mdash; ideally in writing and as soon as possible. Second, you must <strong>file your claim with the South Carolina Workers&rsquo; Compensation Commission within 2 years</strong> of the injury under <strong>S.C. Code &sect; 42-15-40</strong>. These are different from the general 3-year deadline that applies to car-accident and other injury lawsuits, so do not assume the same timeline applies.</p>

<h2>Do I have to prove my employer was at fault?</h2>
<p>No. South Carolina workers&rsquo; compensation is a <strong>no-fault system</strong>. You generally do not have to prove your employer was negligent &mdash; only that you were injured in the course and scope of your employment. In return, workers&rsquo; comp is usually your exclusive remedy against your employer. The system is meant to be simpler than a lawsuit, but insurers still contest whether injuries are work-related, which is where good documentation and an attorney help.</p>

<h2>What benefits can injured Spartanburg workers receive?</h2>
<p>South Carolina workers&rsquo; compensation can cover authorized medical care, a portion of your lost wages while you are unable to work, and compensation for permanent impairment based on a disability rating. According to the South Carolina Workers&rsquo; Compensation Commission&rsquo;s schedule, different body parts carry different benefit values, and the impairment rating assigned at maximum medical improvement directly affects your award. Insurers sometimes push for a lower rating or a fast settlement &mdash; a lawyer can make sure the rating and benefits reflect your real injury.</p>

<h2>What if my Spartanburg workers\' comp claim is denied?</h2>
<p>A denial can be challenged. You can request a hearing before the South Carolina Workers&rsquo; Compensation Commission, where an attorney can present medical records and testimony to support your claim. Insurers often deny by arguing the injury was not work-related, that a deadline was missed, or that a pre-existing condition is to blame &mdash; arguments that the right evidence can defeat. Roden Law manages the hearing process so you can focus on healing.</p>

<h2>Where do injured Spartanburg workers get hurt?</h2>
<p>Spartanburg sits at the heart of the Upstate&rsquo;s manufacturing and logistics economy, where the <strong>BMW supplier network</strong>, large distribution centers, and freight operations cluster around the <strong>I-85 and I-26</strong> interchange. Forklift and warehouse accidents, machinery and assembly-line injuries, repetitive-motion conditions, and trucking and loading-dock injuries are common. Workers&rsquo; comp claims from Spartanburg are handled through the statewide South Carolina Workers&rsquo; Compensation Commission rather than a local court.</p>

<h2>Talk to a South Carolina workers\' comp lawyer for free</h2>
<p>Roden Law represents Spartanburg and Upstate workers even though our nearest offices are in Charleston, North Charleston, Columbia, and Myrtle Beach. A South Carolina workers&rsquo; compensation attorney will review your case at no cost, confirm your deadlines, and fight a denial if one comes. There are no fees unless we win. Learn more about your rights on our <a href="/south-carolina-workers-compensation-lawyer/">South Carolina workers&rsquo; compensation</a> page and our <a href="/practice-areas/workers-compensation-lawyers/">workers&rsquo; compensation practice</a>.</p>';

$faqs = array(
    array(
        'question' => 'How long do I have to report a work injury in Spartanburg, SC?',
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
        'question' => 'What can I do if my Spartanburg workers\' comp claim is denied?',
        'answer'   => 'You can request a hearing before the South Carolina Workers\' Compensation Commission. An attorney can present medical evidence and testimony to overcome common denial reasons, such as a claim that the injury was not work-related or that a deadline was missed.',
    ),
    array(
        'question' => 'Does Roden Law have an office in Spartanburg?',
        'answer'   => 'Roden Law does not have a Spartanburg office, but our South Carolina workers\' compensation lawyers represent injured Upstate workers statewide. Claims are administered through the statewide SC Workers\' Compensation Commission, and a free case review is available wherever you are.',
    ),
    array(
        'question' => 'How much does a South Carolina workers\' comp lawyer cost?',
        'answer'   => 'Roden Law handles workers\' compensation cases on a contingency fee basis. You pay nothing upfront and no legal fees unless we win benefits for you. Attorney fees in SC workers\' comp cases are also subject to Commission approval.',
    ),
);

require __DIR__ . '/_sc-pillar-insert.php';
