<?php
/**
 * Seeder: INDEXABLE statewide pillar "South Carolina Car Accident Lawyers"
 * (internal-linking audit 2026-07-01, fix #4). Head term:
 * "south carolina car accident lawyer" — the highest-volume SC vertical, which
 * previously had NO indexable organic pillar.
 *
 * PLURAL slug on purpose: the SINGULAR /south-carolina-car-accident-lawyer/ is the
 * noindex PPC landing page (template-landing-sc-statewide.php, headline A/B test),
 * so this indexable pillar takes the plural slug — mirrors the truck pillar pattern.
 *
 * Built on templates/template-pillar-sc-statewide.php (indexable). Ships DRAFT.
 * SC-only law. Carries _roden_key_takeaways + _roden_faqs (FAQPage schema).
 *
 * SC facts verified against roden_firm_data()['jurisdiction']['SC']: 3-year SOL
 * (S.C. Code § 15-3-530), 51%-bar modified comparative fault, mandatory UM coverage
 * with stacking, 25/50/25 minimum liability (S.C. Code § 38-77-140).
 *
 * Run: wp eval-file wp-content/themes/roden-law/inc/seed-sc-pillar-car-accident.php
 * Idempotent.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$slug          = 'south-carolina-car-accident-lawyers';
$title         = 'South Carolina Car Accident Lawyers';
$template      = 'templates/template-pillar-sc-statewide.php';
$practice      = 'Car Accident';
$meta_desc     = 'Injured in a car accident in South Carolina? Roden Law\'s South Carolina car accident lawyers help crash victims recover compensation statewide, from Charleston to Columbia to Myrtle Beach. Free case review, no fees unless we win.';
$key_takeaways = 'South Carolina is an at-fault (tort) state: the driver who caused the crash — and their insurer — pays for the injuries. An injured driver generally has 3 years from the date of the crash to file a lawsuit under S.C. Code § 15-3-530. South Carolina follows a modified comparative negligence rule, so you can recover as long as you were less than 51% at fault, with your award reduced by your share of blame. South Carolina requires at least 25/50/25 in liability coverage and mandatory uninsured motorist (UM) coverage (S.C. Code § 38-77-140 and following), and it allows stacking of UM/UIM coverage when the at-fault driver is uninsured or underinsured. Roden Law has offices in Charleston, North Charleston, Columbia, and Myrtle Beach and handles car accident claims statewide on a contingency fee — no fees unless we win.';

$content = '<p>A car accident can upend your life in seconds &mdash; medical bills, lost income, a totaled vehicle, and an insurance company that is already working to pay you as little as possible. Roden Law&rsquo;s South Carolina car accident lawyers level that fight. We build the evidence, deal with the adjusters, and pursue the full value of your claim, serving injured drivers statewide from offices in Charleston, North Charleston, Columbia, and Myrtle Beach. We work on a contingency fee &mdash; you pay nothing unless we win.</p>

<h2>Who pays after a car accident in South Carolina?</h2>
<p>South Carolina is an <strong>at-fault (tort) state</strong>. That means the driver who caused the crash is responsible for the harm, and you generally pursue that driver&rsquo;s liability insurance for your injuries and losses. South Carolina requires every driver to carry at least <strong>25/50/25</strong> in liability coverage &mdash; $25,000 per injured person, $50,000 per accident, and $25,000 for property damage &mdash; along with mandatory <strong>uninsured motorist (UM)</strong> coverage, under S.C. Code &sect; 38-77-140 and following. A South Carolina car accident lawyer identifies every policy and party that may owe you compensation.</p>

<h2>How long do I have to file a car accident claim in South Carolina?</h2>
<p>In most cases you have <strong>3 years from the date of the crash</strong> to file a personal injury lawsuit, under <strong>S.C. Code &sect; 15-3-530</strong>. Shorter notice deadlines can apply when a government entity &mdash; such as SCDOT or a city &mdash; is involved, under the South Carolina Tort Claims Act. Because evidence disappears quickly, it is best not to wait. Read more on the <a href="/resources/south-carolina-statute-of-limitations/">South Carolina statute of limitations</a>.</p>

<h2>What if I was partly at fault for the crash?</h2>
<p>South Carolina uses a <strong>modified comparative negligence</strong> rule: you can still recover as long as you were <strong>less than 51% at fault</strong>, with your award reduced by your percentage of blame. Insurers routinely try to shift more fault onto you to cut what they pay, so how fault is assigned is often the whole ballgame &mdash; see how <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a> works.</p>

<h2>What if the other driver had no insurance or too little?</h2>
<p>South Carolina requires UM coverage and allows you to <strong>stack</strong> uninsured and underinsured motorist coverage in many situations, which can multiply the coverage available when the at-fault driver is uninsured or carries only the minimum policy. This is one of the most valuable and overlooked parts of a South Carolina car accident claim &mdash; ask about <a href="/resources/south-carolina-um-uim-stacking/">stacking UM/UIM coverage</a>.</p>

<h2>What compensation can I recover after a South Carolina car accident?</h2>
<p>Depending on the facts, a car accident recovery can include your medical bills (past and future), lost wages and lost earning capacity, vehicle repair or replacement, and pain and suffering. In cases involving especially reckless conduct &mdash; such as a drunk driver &mdash; punitive damages may also be available. We document the full extent of your losses so the insurer cannot minimize them.</p>

<h2>What are common causes of South Carolina car accidents?</h2>
<ul>
<li><strong>Distracted driving</strong> &mdash; texting and phone use behind the wheel.</li>
<li><strong>Speeding and aggressive driving</strong> &mdash; especially on interstates like I-26, I-20, and I-95.</li>
<li><strong>Impaired driving</strong> &mdash; alcohol or drugs.</li>
<li><strong>Running red lights and failure to yield</strong> &mdash; intersection collisions.</li>
<li><strong>Rear-end and merge crashes</strong> &mdash; in congested corridors like Malfunction Junction in Columbia.</li>
</ul>
<p>Crashes involving other vehicle types follow their own rules and insurers. If you were hurt by a commercial truck or while riding a motorcycle, see our <a href="/south-carolina-truck-accident-lawyers/">South Carolina truck accident lawyers</a> and <a href="/south-carolina-motorcycle-accident-lawyer/">South Carolina motorcycle accident lawyers</a> pages.</p>

<h2>Talk to a South Carolina car accident lawyer for free</h2>
<p>Roden Law represents car accident victims throughout South Carolina, from the Lowcountry and the Midlands to the Grand Strand and the Upstate. A car accident attorney will review your case at no cost, explain the deadline that applies to you, and start protecting your evidence right away. There are no fees unless we win. Explore our <a href="/practice-areas/car-accident-lawyers/">car accident practice</a> &mdash; one of the <a href="/south-carolina-personal-injury-lawyer/">South Carolina personal injury</a> claims we handle statewide.</p>';

$faqs = array(
    array(
        'question' => 'Is South Carolina an at-fault or no-fault state for car accidents?',
        'answer'   => 'South Carolina is an at-fault (tort) state. The driver who caused the crash, and their insurer, is responsible for the resulting injuries and losses, so you pursue the at-fault driver\'s liability coverage rather than your own no-fault benefits.',
    ),
    array(
        'question' => 'How long do I have to file a car accident lawsuit in South Carolina?',
        'answer'   => 'In most cases you have 3 years from the date of the crash to file, under S.C. Code § 15-3-530. Shorter notice deadlines can apply when a government entity is involved under the South Carolina Tort Claims Act, so confirm your specific deadline with an attorney.',
    ),
    array(
        'question' => 'What happens if I was partly at fault for the accident?',
        'answer'   => 'South Carolina follows a modified comparative negligence rule. You can recover as long as you were less than 51% at fault, but your award is reduced by your percentage of fault. Insurers often try to assign you extra blame to reduce what they pay.',
    ),
    array(
        'question' => 'What if the driver who hit me had no insurance or not enough?',
        'answer'   => 'South Carolina requires uninsured motorist (UM) coverage and allows stacking of UM and underinsured (UIM) coverage in many situations. Stacking can significantly increase the coverage available when the at-fault driver is uninsured or carries only a minimum policy.',
    ),
    array(
        'question' => 'How much does a South Carolina car accident lawyer cost?',
        'answer'   => 'Roden Law handles car accident cases on a contingency fee basis. You pay nothing upfront and no legal fees unless we win. Our fee is a percentage of the recovery we obtain for you.',
    ),
    array(
        'question' => 'Does Roden Law handle car accident cases across all of South Carolina?',
        'answer'   => 'Yes. Roden Law has offices in Charleston, North Charleston, Columbia, and Myrtle Beach and handles car accident claims statewide, including the Upstate and Pee Dee regions.',
    ),
);

require __DIR__ . '/_sc-pillar-insert.php';
