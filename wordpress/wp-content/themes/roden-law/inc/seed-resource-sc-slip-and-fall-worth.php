<?php
/**
 * Seeder: "How Much Is a SC Slip and Fall Case Worth?" resource page.
 *
 * AEO value/answer page targeting "how much is a slip and fall settlement worth
 * in South Carolina" — answer-first, SC-jurisdiction, with Key Takeaways +
 * FAQPage schema + author attribution. SC competitor-gap build (row 7, 2026-06-29).
 * Scoped to FALLS specifically (wet floors, uneven surfaces, stairs, ice);
 * the broader category lives on the premises-liability value page.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-resource-sc-slip-and-fall-worth.php
 *
 * Idempotent — skips if the slug already exists. Ships as DRAFT.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title         = 'How Much Is a SC Slip and Fall Case Worth?';
$slug          = 'south-carolina-slip-and-fall-settlement-value';
$meta_desc     = 'Most South Carolina slip and fall settlements turn on notice, fall mechanics, and injury severity. There is no cap on your compensatory damages in an ordinary fall case.';
$key_takeaways = 'Most South Carolina slip and fall settlements range from a few thousand dollars for minor falls to six or seven figures for serious ones, and value turns heavily on whether the property owner knew or should have known about the hazard (notice). South Carolina places no cap on compensatory damages in an ordinary fall case, but your award is reduced by your share of fault and barred at 51%. If you fell on public property, S.C. Tort Claims Act caps of $300,000 per person / $600,000 per occurrence may apply. You generally have 3 years to file (S.C. Code § 15-3-530). Every case is unique.';
$content       = '<p>Most South Carolina slip and fall settlements fall between roughly <strong>$10,000 and $150,000</strong>, though cases involving broken hips, spinal injuries, or traumatic brain injury from a fall can reach <strong>several hundred thousand dollars or more</strong>. Slip and fall value depends less on a formula and more on three things: <strong>how the fall happened, whether the property owner had notice of the hazard, and how serious the injury is</strong>. There is no single "average" that fits every fall.</p>

<p>Below we explain honestly how South Carolina slip and fall case value is calculated, why "notice" so often decides the case, illustrative ranges by injury severity, and how South Carolina law shapes your final payout. These figures are educational illustrations only — past results do not guarantee future outcomes, and every case is unique.</p>

<h2>What Determines the Value of a South Carolina Slip and Fall Case</h2>
<p>The value of a South Carolina slip and fall case is determined by two things working together: the strength of your liability case (can you prove the owner was negligent?) and the size of your damages (how badly were you hurt?). A serious injury with weak liability can be worth less than a moderate injury with clear liability.</p>

<h3>The fall mechanics and the hazard</h3>
<p>Slip and fall claims arise from specific, provable hazards. The clearer and more dangerous the hazard, the stronger the case:</p>
<ul>
<li><strong>Wet or slippery floors</strong> — spills, freshly mopped floors with no warning sign, tracked-in rainwater.</li>
<li><strong>Uneven or defective surfaces</strong> — cracked sidewalks, torn carpet, loose mats, potholes in a parking lot.</li>
<li><strong>Stairs and steps</strong> — missing handrails, broken treads, poor lighting on a stairwell.</li>
<li><strong>Ice and weather hazards</strong> — untreated ice on a walkway or entrance during a South Carolina cold snap.</li>
</ul>

<h3>Your damages</h3>
<p>Once liability is established, value scales with your damages — economic (medical bills, lost wages, future care) and non-economic (pain and suffering, loss of enjoyment of life). <strong>South Carolina places no cap on these compensatory damages</strong> in an ordinary slip and fall case; the statutory non-economic cap applies only to medical-malpractice claims. Falls disproportionately cause <strong>hip and wrist fractures, back injuries, and head trauma</strong>, especially in older adults, and those injuries drive the higher settlement ranges.</p>

<h2>Why "Notice" Decides Most South Carolina Slip and Fall Cases</h2>
<p>The single biggest driver of slip and fall value in South Carolina is <strong>notice</strong> — whether the property owner knew, or should have known, about the hazard and failed to fix it or warn you. A property owner is not automatically responsible just because you fell; you generally must show the owner was negligent about a dangerous condition.</p>
<ul>
<li><strong>Actual notice</strong> — the owner knew about the hazard (an employee saw the spill) and did nothing.</li>
<li><strong>Constructive notice</strong> — the hazard existed long enough that a reasonable owner should have discovered and addressed it (a spill left for an hour, a pothole that has been there for months).</li>
</ul>
<p>Graeham C. Gillin, a partner at Roden Law\'s Charleston office, notes that evidence of notice — incident reports, cleaning logs, surveillance video, and prior complaints — often determines whether a South Carolina fall case is worth a few thousand dollars or six figures, which is why preserving that evidence quickly is so important.</p>

<h2>Typical Settlement Ranges by Injury Severity</h2>
<p>Slip and fall settlement value scales with injury severity once liability is clear. The illustrative ranges below reflect how value generally tiers up — they are educational examples, not predictions, and your case could fall well outside them.</p>

<table>
<tr><th>Injury severity</th><th>Typical examples</th><th>Illustrative settlement range</th></tr>
<tr><td>Minor</td><td>Bruises, sprains, minor cuts, full recovery</td><td>$3,000 &ndash; $25,000</td></tr>
<tr><td>Moderate</td><td>Wrist or ankle fracture, minor surgery, physical therapy</td><td>$25,000 &ndash; $100,000</td></tr>
<tr><td>Severe</td><td>Hip fracture, back injury, surgery with lasting limitations</td><td>$100,000 &ndash; $500,000+</td></tr>
<tr><td>Catastrophic</td><td>Traumatic brain injury, spinal cord injury, wrongful death</td><td>$500,000 &ndash; several million+</td></tr>
</table>

<p>These ranges are illustrations only. Two falls with the same injury can settle for very different amounts depending on how clear the owner\'s negligence is, your comparative fault, and available insurance. No range here is a promise or a prediction of what your case is worth.</p>

<h2>How South Carolina Law Affects Your Payout</h2>
<p>South Carolina law affects your slip and fall payout in three major ways: the deadline to file, how your own fault reduces your award, and special caps when a government entity owns the property.</p>

<h3>The filing deadline (statute of limitations)</h3>
<p>In South Carolina, you generally have <strong>3 years</strong> from the date of the fall to file a lawsuit under <strong>S.C. Code § 15-3-530</strong>. Miss that deadline and you typically lose the right to recover anything. Notice deadlines can be much shorter when a government entity is involved.</p>

<h3>Comparative fault reduces your award</h3>
<p>South Carolina follows <strong>modified comparative negligence</strong>: you can recover as long as you are <strong>less than 51% at fault</strong>, but your award is reduced by your percentage of fault. In fall cases, property owners frequently argue you were not watching where you were going or ignored an obvious hazard. If your case is worth $100,000 and you are 20% at fault, you recover $80,000; at 51% or more, you recover nothing. Learn how <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a> works.</p>

<h3>Government property: the Tort Claims Act caps</h3>
<p>If you fell on <strong>public property</strong> — a city or county building, a school, an SCDOT sidewalk — your recovery may be limited by the <strong>South Carolina Tort Claims Act (S.C. Code § 15-78-120)</strong>, which caps damages at <strong>$300,000 per person and $600,000 per occurrence</strong> and bars punitive damages against the government. These caps are fixed and are a critical disclosure if a government entity is responsible for where you fell.</p>

<h2>How Slip and Fall Settlements Are Calculated</h2>
<p>A slip and fall settlement is calculated by first establishing liability, then adding your economic damages to your non-economic damages, and finally adjusting for fault and available insurance.</p>
<ul>
<li><strong>Liability</strong> comes first — without proof of notice and negligence, even a serious injury may recover little.</li>
<li><strong>Special damages</strong> (economic) are added up from medical bills, wage statements, and future-care estimates.</li>
<li><strong>General damages</strong> (non-economic) are estimated from injury severity and permanence, often using a rough "multiplier" of the economic damages.</li>
<li><strong>Fault and coverage</strong> then adjust the total — reduced by your comparative-fault share and limited by the property owner\'s liability insurance (or the Tort Claims Act caps on public property).</li>
</ul>
<p>The multiplier is a rough industry concept, not a South Carolina legal formula. No lawyer can promise a particular number; the real value comes from the specific facts and evidence.</p>

<h2>Why Roden Law for Your South Carolina Slip and Fall Case</h2>
<p>Firm-wide, Roden Law has recovered <strong>more than $300 million</strong> for injured clients across <strong>more than 5,000 cases</strong> of all types, and holds a <strong>4.9-star average</strong> across hundreds of client reviews. These figures reflect results across every kind of injury claim the firm handles, not slip-and-fall cases alone, and are shared to show the firm\'s overall track record rather than to predict any individual outcome. Proving that the property owner knew or should have known about the hazard is usually what decides a slip-and-fall case, and it is where our South Carolina attorneys focus first.</p>
<p>This result is shared to show what is possible in the most serious cases. It is not a promise or prediction. Past results do not guarantee future outcomes, and every case is unique. If you want an honest assessment of what your South Carolina slip and fall claim may be worth, a Roden Law attorney can review your case at no cost. There are no fees unless we win.</p>
<p>A slip and fall is one type of premises case. For the broader category — negligent security, inadequate maintenance, and other unsafe conditions — see our <a href="/resources/south-carolina-premises-liability-settlement-value/">South Carolina premises liability case value</a> guide and our <a href="/practice-areas/premises-liability-lawyers/">premises liability practice</a> page. You can also reach our <a href="/locations/south-carolina/charleston/">Charleston office</a> directly to speak with an attorney.</p>';
$faqs          = array (
  0 =>
  array (
    'question' => 'What is the average slip and fall settlement in South Carolina?',
    'answer' => 'There is no reliable single average. Most South Carolina slip and fall settlements range from a few thousand dollars for minor falls to six or seven figures for serious ones. Value depends heavily on whether the property owner had notice of the hazard, how badly you were hurt, and your share of fault. Every case is unique and no result is guaranteed.',
  ),
  1 =>
  array (
    'question' => 'What do I have to prove to win a slip and fall case in South Carolina?',
    'answer' => 'You generally must prove the property owner was negligent about a dangerous condition — that they knew about the hazard (actual notice) or that it existed long enough that they should have known (constructive notice) and failed to fix it or warn you. Evidence like incident reports, cleaning logs, and surveillance video is often decisive.',
  ),
  2 =>
  array (
    'question' => 'Is there a cap on damages in a South Carolina slip and fall case?',
    'answer' => 'Not in an ordinary case against a private business or homeowner — South Carolina places no cap on compensatory damages. But if you fell on government property, the South Carolina Tort Claims Act (S.C. Code § 15-78-120) caps damages at $300,000 per person and $600,000 per occurrence and bars punitive damages.',
  ),
  3 =>
  array (
    'question' => 'How long do I have to file a slip and fall claim in South Carolina?',
    'answer' => 'In South Carolina, you generally have 3 years from the date of the fall to file a lawsuit under S.C. Code § 15-3-530. If a government entity owns the property, notice deadlines can be much shorter. Acting early also helps preserve evidence like surveillance video before it is overwritten.',
  ),
  4 =>
  array (
    'question' => 'Can my slip and fall settlement be reduced if I was partly at fault?',
    'answer' => 'Yes. South Carolina uses modified comparative negligence, so your award is reduced by your fault percentage and barred if you are 51% or more at fault. Property owners often argue you ignored an obvious hazard or were not watching where you were going. An attorney can push back on inflated fault claims to protect your recovery.',
  ),
  5 =>
  array (
    'question' => 'What is the difference between a slip and fall case and a premises liability case?',
    'answer' => 'A slip and fall is one type of premises liability case — it involves falls specifically, from hazards like wet floors, uneven surfaces, stairs, or ice. Premises liability is the broader category that also covers negligent security, assaults on a property, pool and stairwell hazards, and other unsafe conditions. See our premises liability case value guide for the broader picture.',
  ),
);
$see_also      = array (
  0 =>
  array (
    'url' => '/practice-areas/slip-and-fall-lawyers/',
    'text' => 'South Carolina Slip and Fall Lawyers',
  ),
  1 =>
  array (
    'url' => '/resources/south-carolina-premises-liability-settlement-value/',
    'text' => 'How Much Is a SC Premises Liability Case Worth?',
  ),
  2 =>
  array (
    'url' => '/practice-areas/premises-liability-lawyers/',
    'text' => 'Premises Liability Lawyers',
  ),
  3 =>
  array (
    'url' => '/resources/south-carolina-comparative-negligence/',
    'text' => 'South Carolina Comparative Negligence',
  ),
);

// Author attribution — Graeham C. Gillin (Charleston, SC partner).
$author    = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $author ? $author->ID : 0;
if ( ! $author_id ) {
    WP_CLI::warning( 'Attorney "graeham-c-gillin" not found — author attribution will be empty.' );
}

// Ensure the south-carolina-law practice_category term exists.
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
