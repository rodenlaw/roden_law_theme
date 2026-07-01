<?php
/**
 * Seeder: INDEXABLE statewide pillar "South Carolina Workers' Compensation Lawyers"
 * (SC competitor gap analysis 2026-06-29, P0-4). Head terms:
 * "south carolina workers compensation lawyer/attorney" (590–720/mo, Roden pos 0).
 *
 * Built on templates/template-pillar-sc-statewide.php (indexable). Ships DRAFT.
 * SC-only law. NOTE: workers' comp is governed by the SC Workers' Compensation
 * Act (S.C. Code Title 42), NOT the 3-yr tort SOL — the SC-law callout in the
 * template still shows the general tort SOL, so the body below states the
 * comp-specific deadlines explicitly: 90-day notice (§ 42-15-20) + 2-year filing
 * (§ 42-15-40), verified against scstatehouse.gov 2026-06-30.
 *
 * Run: wp eval-file wp-content/themes/roden-law/inc/seed-sc-pillar-workers-comp.php
 * Idempotent.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$slug          = 'south-carolina-workers-compensation-lawyer';
$title         = 'South Carolina Workers\' Compensation Lawyers';
$template      = 'templates/template-pillar-sc-statewide.php';
$practice      = 'Workers\' Compensation';
$meta_desc     = 'Hurt on the job in South Carolina? Roden Law\'s South Carolina workers\' compensation lawyers help injured workers get medical care and benefits — and fight denied claims statewide. Free case review.';
$key_takeaways = 'If you were hurt on the job in South Carolina, the workers\' compensation system — governed by the South Carolina Workers\' Compensation Act (S.C. Code Title 42), not the general tort statute of limitations — generally entitles you to medical treatment and wage-replacement benefits regardless of who was at fault. You must report your injury to your employer promptly (in writing where possible) and there are firm deadlines to file a claim with the South Carolina Workers\' Compensation Commission. Benefits can include covered medical care, a portion of lost wages, and compensation for permanent impairment. If your claim is denied or your benefits are cut off, you have the right to appeal. Roden Law has offices in Charleston, North Charleston, Columbia, and Myrtle Beach and represents injured workers statewide on a contingency fee — no fees unless we win.';

$content = '<p>A workplace injury can put your health, your paycheck, and your family at risk all at once. South Carolina&rsquo;s workers&rsquo; compensation system is supposed to provide medical care and wage benefits no matter who was at fault &mdash; but employers and their insurers do not always make it easy. Roden Law&rsquo;s South Carolina workers&rsquo; compensation lawyers help injured workers get the benefits they are owed and fight back when a claim is denied or cut short. We serve injured workers statewide from offices in Charleston, North Charleston, Columbia, and Myrtle Beach, on a contingency fee &mdash; no fees unless we win.</p>

<h2>What benefits does South Carolina workers&rsquo; compensation provide?</h2>
<p>Under the South Carolina Workers&rsquo; Compensation Act (S.C. Code Title 42), an injured worker is generally entitled to:</p>
<ul>
<li><strong>Medical treatment</strong> for the work injury, covered by the employer&rsquo;s insurer.</li>
<li><strong>Wage-replacement benefits</strong> &mdash; a portion of your average weekly wage while you cannot work.</li>
<li><strong>Permanent disability or impairment benefits</strong> if the injury leaves lasting effects.</li>
<li><strong>Vocational and related benefits</strong> in some cases, depending on the injury.</li>
</ul>
<p>Importantly, workers&rsquo; comp is a no-fault system: you generally do not have to prove your employer did anything wrong to qualify.</p>

<h2>What deadlines apply to a South Carolina workers&rsquo; comp claim?</h2>
<p>Workers&rsquo; comp runs on its own timeline, separate from the 3-year deadline for ordinary injury lawsuits. You must <strong>report your injury to your employer within 90 days</strong> of the accident (S.C. Code &sect; 42-15-20) &mdash; in writing whenever possible &mdash; and you must <strong>file your claim with the South Carolina Workers&rsquo; Compensation Commission within 2 years</strong> of the injury (S.C. Code &sect; 42-15-40). Missing either deadline can cost you your benefits, so report the injury right away and do not wait to file. (Some injuries, such as repetitive-trauma or occupational-disease conditions, follow special rules for when the clock starts.)</p>

<h2>What should I do if my workers&rsquo; comp claim is denied?</h2>
<p>Denials are common &mdash; insurers may dispute whether the injury is work-related, whether it is as serious as you say, or whether you reported it in time. A denial is not the end. You have the right to request a hearing before the South Carolina Workers&rsquo; Compensation Commission and to appeal. A workers&rsquo; compensation lawyer can gather the medical evidence, meet the deadlines, and present your case at the hearing.</p>

<h2>Can I sue a third party in addition to my workers&rsquo; comp claim?</h2>
<p>Workers&rsquo; comp usually bars you from suing your own employer, but if someone <em>other</em> than your employer caused your injury &mdash; for example, a negligent driver, a defective machine, or an outside contractor &mdash; you may have a separate <strong>third-party personal injury claim</strong>. That claim can recover damages workers&rsquo; comp does not, such as full lost wages and pain and suffering. South Carolina&rsquo;s <a href="/resources/south-carolina-comparative-negligence/">comparative negligence</a> rule applies to that separate claim.</p>

<h2>Talk to a South Carolina workers&rsquo; compensation lawyer for free</h2>
<p>If you were hurt at work anywhere in South Carolina, Roden Law will explain your rights, help you meet the deadlines, and fight a denial if one comes. A workers&rsquo; compensation attorney will review your case at no cost, and there are no fees unless we win. Explore our <a href="/practice-areas/workers-compensation-lawyers/">workers&rsquo; compensation practice</a>. If someone other than your employer helped cause your workplace injury, you may also have a separate <a href="/south-carolina-personal-injury-lawyer/">South Carolina personal injury</a> claim.</p>';

$faqs = array(
    array(
        'question' => 'What benefits can I get from South Carolina workers\' compensation?',
        'answer'   => 'Under the South Carolina Workers\' Compensation Act (S.C. Code Title 42), an injured worker is generally entitled to covered medical treatment, a portion of lost wages while unable to work, and compensation for permanent impairment. It is a no-fault system, so you usually do not have to prove your employer did anything wrong.',
    ),
    array(
        'question' => 'How long do I have to file a workers\' comp claim in South Carolina?',
        'answer'   => 'Workers\' comp has its own deadlines. You must report your injury to your employer within 90 days (S.C. Code § 42-15-20) — in writing where possible — and file your claim with the South Carolina Workers\' Compensation Commission within 2 years of the injury (S.C. Code § 42-15-40). Repetitive-trauma and occupational-disease claims follow special start-date rules, so confirm your exact deadlines with an attorney as soon as possible.',
    ),
    array(
        'question' => 'What should I do if my South Carolina workers\' comp claim is denied?',
        'answer'   => 'A denial is not the end. You can request a hearing before the South Carolina Workers\' Compensation Commission and appeal. A workers\' compensation lawyer can gather the medical evidence, meet the deadlines, and present your case at the hearing.',
    ),
    array(
        'question' => 'Can I sue someone besides my employer for a work injury in South Carolina?',
        'answer'   => 'Workers\' comp usually bars suing your own employer, but if someone other than your employer caused your injury — such as a negligent driver, a defective machine, or an outside contractor — you may have a separate third-party personal injury claim that can recover damages workers\' comp does not, like full lost wages and pain and suffering.',
    ),
    array(
        'question' => 'How much does a South Carolina workers\' compensation lawyer cost?',
        'answer'   => 'Roden Law handles workers\' compensation cases on a contingency fee basis. You pay nothing upfront and no legal fees unless we win. Our fee is a percentage of the benefits or recovery we obtain for you.',
    ),
    array(
        'question' => 'Does Roden Law handle workers\' comp claims across all of South Carolina?',
        'answer'   => 'Yes. Roden Law has offices in Charleston, North Charleston, Columbia, and Myrtle Beach and represents injured workers statewide, including the Upstate and Pee Dee regions.',
    ),
);

require __DIR__ . '/_sc-pillar-insert.php';
