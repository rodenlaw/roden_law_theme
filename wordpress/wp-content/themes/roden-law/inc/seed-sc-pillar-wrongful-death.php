<?php
/**
 * Seeder: INDEXABLE statewide pillar "South Carolina Wrongful Death Lawyers"
 * (SC competitor gap analysis 2026-06-29, P0-4). Head term:
 * "south carolina wrongful death lawyer" (320/mo, Roden pos 0).
 *
 * Built on templates/template-pillar-sc-statewide.php (indexable). Ships DRAFT.
 * SC-only law. Carries _roden_key_takeaways + _roden_faqs (FAQPage schema).
 *
 * Run: wp eval-file wp-content/themes/roden-law/inc/seed-sc-pillar-wrongful-death.php
 * Idempotent.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$slug          = 'south-carolina-wrongful-death-lawyer';
$title         = 'South Carolina Wrongful Death Lawyers';
$template      = 'templates/template-pillar-sc-statewide.php';
$practice      = 'Wrongful Death';
$meta_desc     = 'Lost a loved one to someone else\'s negligence in South Carolina? Roden Law\'s South Carolina wrongful death lawyers help families pursue accountability and compensation statewide. Free, compassionate case review.';
$key_takeaways = 'A South Carolina wrongful death claim must be brought by the personal representative of the deceased person\'s estate, not by family members directly, under S.C. Code § 15-51-10 and following. The claim must generally be filed within 3 years of the date of death. South Carolina law allows the estate to recover for the surviving spouse and children (and, in some cases, parents), including for the loss of the loved one\'s support, companionship, and guidance, as well as funeral expenses. A separate survival action can recover for the deceased person\'s own pain before death. Roden Law has offices in Charleston, North Charleston, Columbia, and Myrtle Beach and handles these sensitive cases statewide on a contingency fee — no fees unless we win.';

$content = '<p>Losing a loved one because of someone else&rsquo;s carelessness is devastating, and no lawsuit can undo it. What a South Carolina wrongful death claim can do is hold the responsible party accountable and provide for the family&rsquo;s future. Roden Law&rsquo;s South Carolina wrongful death lawyers guide families through this process with compassion and resolve, from offices in Charleston, North Charleston, Columbia, and Myrtle Beach, serving the entire state. We work on a contingency fee &mdash; there are no fees unless we win.</p>

<h2>Who can file a wrongful death claim in South Carolina?</h2>
<p>In South Carolina, a wrongful death claim must be brought by the <strong>personal representative</strong> of the deceased person&rsquo;s estate &mdash; not by individual family members on their own &mdash; under <strong>S.C. Code &sect; 15-51-10</strong> and following. The recovery, however, is for the benefit of the surviving family. If the estate does not yet have a personal representative, the court can appoint one. A South Carolina wrongful death lawyer can help the family take that first step.</p>

<h2>Who benefits from a South Carolina wrongful death recovery?</h2>
<p>South Carolina law (S.C. Code &sect; 15-51-20) directs a wrongful death recovery to the deceased person&rsquo;s statutory beneficiaries in a set order: <strong>first the surviving spouse and children; if there is no spouse or child, then the parents; and if none of those survive, then the deceased person&rsquo;s heirs</strong>. When there is both a spouse and children, the recovery is divided the way the estate would pass under South Carolina&rsquo;s intestacy rules &mdash; the spouse receives one-half and the children share the other half. These proceeds generally pass to the family directly and are not used to pay the deceased person&rsquo;s creditors.</p>

<h2>What compensation is available in a South Carolina wrongful death case?</h2>
<p>Depending on the facts, a wrongful death recovery can include the family&rsquo;s loss of the loved one&rsquo;s financial support, the loss of companionship, guidance, and society, the family&rsquo;s grief and mental anguish, and funeral and burial expenses. South Carolina also recognizes a separate <strong>survival action</strong>, brought by the estate, to recover for the deceased person&rsquo;s own conscious pain, suffering, and medical expenses between the injury and death. The two claims are often pursued together.</p>

<h2>How long do I have to file a wrongful death claim in South Carolina?</h2>
<p>A South Carolina wrongful death claim must generally be filed within <strong>3 years of the date of death</strong>, consistent with S.C. Code &sect; 15-3-530. When a government entity is involved, a shorter Tort Claims Act deadline may apply. See our explainer on the <a href="/resources/south-carolina-statute-of-limitations/">South Carolina statute of limitations</a>.</p>

<h2>What kinds of accidents lead to wrongful death claims?</h2>
<p>Roden Law pursues wrongful death claims arising from <a href="/practice-areas/car-accident-lawyers/">car accidents</a>, <a href="/practice-areas/truck-accident-lawyers/">truck accidents</a>, motorcycle crashes, medical negligence, unsafe premises, and defective products. If another party&rsquo;s negligence caused your loved one&rsquo;s death, you may have a claim &mdash; even if the cause is not obvious. Comparative negligence can still affect recovery; see <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a>.</p>

<h2>Talk to a South Carolina wrongful death lawyer for free</h2>
<p>If your family has lost someone to another&rsquo;s negligence in South Carolina, Roden Law will listen, explain your options, and handle the legal process so you can focus on your family. A wrongful death attorney will review your case at no cost, and there are no fees unless we win.</p>';

$faqs = array(
    array(
        'question' => 'Who can file a wrongful death claim in South Carolina?',
        'answer'   => 'In South Carolina, a wrongful death claim must be brought by the personal representative of the deceased person\'s estate, not by family members directly, under S.C. Code § 15-51-10 et seq. The recovery is for the benefit of the surviving family. If there is no personal representative, the court can appoint one.',
    ),
    array(
        'question' => 'How long do I have to file a wrongful death claim in South Carolina?',
        'answer'   => 'A South Carolina wrongful death claim must generally be filed within 3 years of the date of death, consistent with S.C. Code § 15-3-530. A shorter deadline may apply when a government entity is involved, so confirm your specific deadline with an attorney.',
    ),
    array(
        'question' => 'What compensation is available in a South Carolina wrongful death case?',
        'answer'   => 'Depending on the facts, recovery can include the loss of the loved one\'s financial support, companionship, guidance, and society, the family\'s grief and mental anguish, and funeral and burial expenses. A separate survival action, brought by the estate, can recover for the deceased person\'s own pain and medical expenses before death.',
    ),
    array(
        'question' => 'What is the difference between a wrongful death claim and a survival action?',
        'answer'   => 'A wrongful death claim compensates the surviving family for their losses, while a survival action compensates the estate for what the deceased person endured — conscious pain, suffering, and medical expenses — between the injury and death. The two are often pursued together.',
    ),
    array(
        'question' => 'How much does a South Carolina wrongful death lawyer cost?',
        'answer'   => 'Roden Law handles wrongful death cases on a contingency fee basis. The family pays nothing upfront and no legal fees unless we win. Our fee is a percentage of the recovery we obtain.',
    ),
    array(
        'question' => 'Does Roden Law handle wrongful death cases across all of South Carolina?',
        'answer'   => 'Yes. Roden Law has offices in Charleston, North Charleston, Columbia, and Myrtle Beach and handles wrongful death cases statewide, including the Upstate and Pee Dee regions.',
    ),
);

require __DIR__ . '/_sc-pillar-insert.php';
