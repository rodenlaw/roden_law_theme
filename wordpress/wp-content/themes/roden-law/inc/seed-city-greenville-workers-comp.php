<?php
/**
 * Seeder: INDEXABLE non-office city pillar "Greenville SC Workers' Compensation Lawyer"
 * (SC competitor gap analysis 2026-06-29, roadmap row 5 — Upstate/Pee Dee P1).
 *
 * Greenville is a NON-OFFICE city (Roden has no Greenville office), so this is
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
 *   wp eval-file wp-content/themes/roden-law/inc/seed-city-greenville-workers-comp.php
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

$slug          = 'greenville-sc-workers-compensation-lawyer';
$title         = 'Greenville SC Workers\' Compensation Lawyer';
$template      = 'templates/template-pillar-sc-statewide.php';
$practice      = 'Workers\' Compensation';
$meta_desc     = 'Hurt on the job in Greenville, SC? Roden Law\'s South Carolina workers\' compensation lawyers help Upstate workers report on time and fight denials. Free case review — no fee unless we win.';
$key_takeaways = 'If you were hurt on the job in Greenville, South Carolina, you must report the injury to your employer within 90 days (S.C. Code § 42-15-20) and file your claim with the South Carolina Workers\' Compensation Commission within 2 years of the injury (S.C. Code § 42-15-40). Workers\' compensation is a no-fault system, so you do not have to prove your employer did anything wrong — but missing a deadline or accepting a lowball rating can cost you benefits. Greenville is a major Upstate employment hub (BMW, Prisma Health, and the I-85 logistics corridor), and Roden Law\'s South Carolina workers\' compensation lawyers represent injured Upstate workers statewide on a contingency fee — no fees unless we win.';

$content = '<p>If you were injured at work in Greenville, South Carolina, you may be worried about lost wages, medical bills, and whether your employer&rsquo;s insurer will treat you fairly. Roden Law&rsquo;s South Carolina workers&rsquo; compensation lawyers help injured Upstate workers &mdash; in manufacturing, warehousing, healthcare, and the trades &mdash; get the medical care and wage benefits the law provides. We work on a contingency fee basis: you pay nothing upfront and no legal fees unless we win your case.</p>

<h2>What are the workers\' comp deadlines in South Carolina?</h2>
<p>South Carolina sets two deadlines you cannot afford to miss. First, you must <strong>report your injury to your employer within 90 days</strong> of the accident under <strong>S.C. Code &sect; 42-15-20</strong> &mdash; in writing, as soon as possible, is best. Second, you must <strong>file your claim with the South Carolina Workers&rsquo; Compensation Commission within 2 years</strong> of the injury under <strong>S.C. Code &sect; 42-15-40</strong>. These deadlines are different from the general 3-year deadline for car-accident and other injury lawsuits, so do not assume you have years to act.</p>

<h2>Do I have to prove my employer was at fault?</h2>
<p>No. South Carolina workers&rsquo; compensation is a <strong>no-fault system</strong>. You generally do not have to prove your employer did anything wrong &mdash; you only have to show that you were injured in the course and scope of your job. In exchange, workers&rsquo; comp is usually your exclusive remedy against your employer. That trade-off makes the system simpler, but insurers still dispute whether injuries are work-related, so documentation matters.</p>

<h2>What benefits can injured Greenville workers receive?</h2>
<p>South Carolina workers&rsquo; compensation can cover authorized medical treatment, a portion of your lost wages while you cannot work, and compensation for permanent impairment based on a disability rating. According to the South Carolina Workers&rsquo; Compensation Commission&rsquo;s schedule, different body parts carry different benefit values, and the impairment rating your doctor assigns directly affects what you receive. Insurers sometimes push for a lower rating or a quick settlement &mdash; a lawyer can make sure your rating and benefits reflect your actual injury.</p>

<h2>What if my Greenville workers\' comp claim is denied?</h2>
<p>A denial is not the end. You can request a hearing before the South Carolina Workers&rsquo; Compensation Commission, where an attorney can present medical evidence and testimony on your behalf. Common reasons for denial &mdash; the insurer claims your injury was not work-related, that you missed a deadline, or that you had a pre-existing condition &mdash; can often be overcome with the right evidence. Roden Law handles the hearing process so you can focus on recovering.</p>

<h2>Where do injured Greenville workers get hurt?</h2>
<p>Greenville is one of the Upstate&rsquo;s largest job centers, anchored by the <strong>BMW manufacturing economy</strong>, the <strong>Prisma Health</strong> hospital system, and a dense network of warehouses and logistics operations along the <strong>I-85</strong> corridor. Manufacturing-line injuries, warehouse and forklift accidents, healthcare-worker injuries, and construction falls are common. Workers&rsquo; comp claims arising in Greenville are administered through the statewide South Carolina Workers&rsquo; Compensation Commission, not a local court.</p>

<h2>Talk to a South Carolina workers\' comp lawyer for free</h2>
<p>Roden Law represents Greenville and Upstate workers even though our nearest offices are in Charleston, North Charleston, Columbia, and Myrtle Beach. A South Carolina workers&rsquo; compensation attorney will review your case at no cost, confirm your deadlines, and fight a denial if one comes. There are no fees unless we win. Learn more about your rights on our <a href="/south-carolina-workers-compensation-lawyer/">South Carolina workers&rsquo; compensation</a> page and our <a href="/practice-areas/workers-compensation-lawyers/">workers&rsquo; compensation practice</a>.</p>';

$faqs = array(
    array(
        'question' => 'How long do I have to report a work injury in Greenville, SC?',
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
        'question' => 'What can I do if my Greenville workers\' comp claim is denied?',
        'answer'   => 'You can request a hearing before the South Carolina Workers\' Compensation Commission. An attorney can present medical evidence and testimony to overcome common denial reasons, such as a claim that the injury was not work-related or that a deadline was missed.',
    ),
    array(
        'question' => 'Does Roden Law have an office in Greenville?',
        'answer'   => 'Roden Law does not have a Greenville office, but our South Carolina workers\' compensation lawyers represent injured Upstate workers statewide. Claims are administered through the statewide SC Workers\' Compensation Commission, and a free case review is available wherever you are.',
    ),
    array(
        'question' => 'How much does a South Carolina workers\' comp lawyer cost?',
        'answer'   => 'Roden Law handles workers\' compensation cases on a contingency fee basis. You pay nothing upfront and no legal fees unless we win benefits for you. Attorney fees in SC workers\' comp cases are also subject to Commission approval.',
    ),
);

require __DIR__ . '/_sc-pillar-insert.php';
