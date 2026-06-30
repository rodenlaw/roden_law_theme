<?php
/**
 * Seeder: INDEXABLE statewide PI-MASTER pillar
 * "South Carolina Personal Injury Lawyers" (SC competitor gap analysis
 * 2026-06-29, P0-4). Head terms: "personal injury attorney south carolina"
 * (590/mo), "injury attorneys in south carolina" (1,300/mo), Roden pos 0.
 *
 * This is the master statewide pillar that anchors the SC silo — it links DOWN
 * to the practice-specific SC pillars (truck, motorcycle, wrongful death,
 * workers' comp, car accident) and the SC-law explainer hub.
 *
 * Built on templates/template-pillar-sc-statewide.php (indexable). Ships DRAFT.
 * SC-only law. Carries _roden_key_takeaways + _roden_faqs (FAQPage schema).
 *
 * Run: wp eval-file wp-content/themes/roden-law/inc/seed-sc-pillar-personal-injury.php
 * Idempotent.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$slug          = 'south-carolina-personal-injury-lawyer';
$title         = 'South Carolina Personal Injury Lawyers';
$template      = 'templates/template-pillar-sc-statewide.php';
$practice      = 'Personal Injury';
$meta_desc     = 'Injured by someone else\'s negligence in South Carolina? Roden Law\'s South Carolina personal injury lawyers recover maximum compensation statewide — car, truck, motorcycle, workplace, and more. Free review, no fee unless we win.';
$key_takeaways = 'If you were injured by someone else\'s negligence anywhere in South Carolina, you generally have 3 years from the date of injury to file a claim under S.C. Code § 15-3-530, and you can recover as long as you were less than 51% at fault. South Carolina personal injury law covers car, truck, and motorcycle crashes, workplace injuries, unsafe premises, defective products, and wrongful death. You may be able to recover medical bills, lost wages, pain and suffering, and — in serious cases — punitive damages, and you can often stack uninsured/underinsured motorist coverage when the at-fault party is underinsured. Roden Law has offices in Charleston, North Charleston, Columbia, and Myrtle Beach and represents injured people across the entire state on a contingency fee — no fees unless we win.';

$content = '<p>When someone else&rsquo;s carelessness leaves you injured in South Carolina, you should not have to face the insurance companies alone. Roden Law&rsquo;s South Carolina personal injury lawyers represent injured people across the entire state &mdash; from the Lowcountry and the Grand Strand to the Midlands, the Upstate, and the Pee Dee &mdash; from offices in Charleston, North Charleston, Columbia, and Myrtle Beach. We work on a contingency fee, so you pay nothing upfront and no legal fees unless we win your case.</p>

<h2>What types of cases do South Carolina personal injury lawyers handle?</h2>
<p>Personal injury covers any harm caused by another party&rsquo;s negligence. Roden Law handles the full range across South Carolina:</p>
<ul>
<li><a href="/south-carolina-car-accident-lawyer/">Car accidents</a> &mdash; the most common injury claims statewide.</li>
<li><a href="/south-carolina-truck-accident-lawyers/">Truck accidents</a> &mdash; complex cases against trucking companies and their insurers.</li>
<li><a href="/south-carolina-motorcycle-accident-lawyer/">Motorcycle accidents</a> &mdash; where riders face built-in insurer bias.</li>
<li><a href="/south-carolina-workers-compensation-lawyer/">Workplace injuries</a> &mdash; workers&rsquo; compensation and third-party claims.</li>
<li><a href="/south-carolina-wrongful-death-lawyer/">Wrongful death</a> &mdash; when negligence takes a loved one&rsquo;s life.</li>
<li>Slip-and-fall and unsafe premises, defective products, and more.</li>
</ul>

<h2>How long do I have to file a personal injury claim in South Carolina?</h2>
<p>For most personal injury claims, the deadline is <strong>3 years from the date of injury</strong> under <strong>S.C. Code &sect; 15-3-530</strong>. Some claims &mdash; especially those against a government entity under the South Carolina Tort Claims Act &mdash; have shorter deadlines, and workers&rsquo; compensation runs on its own timeline. See our full explainer on the <a href="/resources/south-carolina-statute-of-limitations/">South Carolina statute of limitations</a>.</p>

<h2>How does fault affect what I can recover in South Carolina?</h2>
<p>South Carolina follows a <strong>modified comparative negligence</strong> rule: you can recover as long as you were less than 51% at fault, but your award is reduced by your share of fault. Insurers routinely try to inflate your fault to pay less &mdash; our attorneys push back. Learn how <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a> works.</p>

<h2>What compensation can I recover in a South Carolina injury case?</h2>
<p>Depending on your case, you may recover economic damages (medical bills, future medical care, lost wages, and lost earning capacity), non-economic damages (pain and suffering, emotional distress, and loss of enjoyment of life), and, in cases involving gross negligence, punitive damages. When the at-fault party is uninsured or underinsured, you may also be able to <a href="/resources/south-carolina-um-uim-stacking/">stack UM/UIM coverage</a> to increase what is available.</p>

<h2>Why choose Roden Law for your South Carolina injury case?</h2>
<p>Roden Law has recovered hundreds of millions of dollars for injury victims, brings decades of combined trial experience, and has four offices across South Carolina so help is never far away. We handle every case on a contingency fee, and we treat each client&rsquo;s case as if our own family were involved.</p>

<h2>Talk to a South Carolina personal injury lawyer for free</h2>
<p>If you were injured by someone else&rsquo;s negligence anywhere in South Carolina, a Roden Law attorney will review your case at no cost, explain the deadline that applies to you, and outline your options. There are no fees unless we win.</p>';

$faqs = array(
    array(
        'question' => 'How long do I have to file a personal injury claim in South Carolina?',
        'answer'   => 'For most personal injury claims, you have 3 years from the date of injury to file under S.C. Code § 15-3-530. Some claims — especially those against a government entity — have shorter deadlines, and workers\' compensation runs on its own timeline, so confirm your specific deadline with an attorney.',
    ),
    array(
        'question' => 'Can I recover compensation if I was partly at fault in South Carolina?',
        'answer'   => 'Yes. South Carolina follows a modified comparative negligence rule. You can recover as long as you were less than 51% at fault, though your award is reduced by your share of fault. Insurers often try to inflate your fault to pay less — our attorneys push back.',
    ),
    array(
        'question' => 'What compensation can I recover in a South Carolina injury case?',
        'answer'   => 'You may recover economic damages (medical bills, future care, lost wages, and lost earning capacity), non-economic damages (pain and suffering, emotional distress, and loss of enjoyment of life), and, in cases of gross negligence, punitive damages. When the at-fault party is underinsured, you may also be able to stack UM/UIM coverage.',
    ),
    array(
        'question' => 'What types of cases does Roden Law handle in South Carolina?',
        'answer'   => 'Roden Law handles car, truck, and motorcycle accidents, workplace injuries, slip-and-fall and unsafe premises, defective products, and wrongful death claims throughout South Carolina.',
    ),
    array(
        'question' => 'How much does a South Carolina personal injury lawyer cost?',
        'answer'   => 'Roden Law handles personal injury cases on a contingency fee basis. You pay nothing upfront and no legal fees unless we win. Our fee is a percentage of the settlement or verdict we recover for you.',
    ),
    array(
        'question' => 'Does Roden Law serve all of South Carolina?',
        'answer'   => 'Yes. Roden Law has offices in Charleston, North Charleston, Columbia, and Myrtle Beach and represents injured people statewide, including the Upstate and Pee Dee regions.',
    ),
);

require __DIR__ . '/_sc-pillar-insert.php';
