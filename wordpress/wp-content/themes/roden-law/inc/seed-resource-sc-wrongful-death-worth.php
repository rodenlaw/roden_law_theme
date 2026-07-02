<?php
/**
 * Seeder: "How Much Is a SC Wrongful Death Case Worth?" resource page.
 *
 * AEO value/answer page targeting "how much is a wrongful death settlement worth
 * in South Carolina" — answer-first, SC-jurisdiction, with Key Takeaways +
 * FAQPage schema + author attribution. SC competitor-gap build (row 7, 2026-06-29).
 * Distinguishes the wrongful-death claim (S.C. Code § 15-51) from the survival
 * action (S.C. Code § 15-5-90).
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-resource-sc-wrongful-death-worth.php
 *
 * Idempotent — skips if the slug already exists. Ships as DRAFT.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title         = 'How Much Is a SC Wrongful Death Case Worth?';
$slug          = 'south-carolina-wrongful-death-settlement-value';
$meta_desc     = 'South Carolina wrongful death cases carry no cap on compensatory damages and can include two claims — the wrongful-death claim and a survival action. Value depends on the loss and the facts.';
$key_takeaways = 'South Carolina wrongful death settlements range from six figures to several million dollars, and there is no cap on compensatory damages in an ordinary case. A South Carolina death case can involve two separate claims: the wrongful-death claim (S.C. Code § 15-51) for the beneficiaries\' losses — financial support, companionship, grief, and guidance — and a survival action (S.C. Code § 15-5-90) for the decedent\'s own pre-death pain and suffering. Punitive damages are available for reckless conduct. Your award is reduced by any fault of the decedent, and Tort Claims Act caps apply against a government defendant. You generally have 3 years to file.';
$content       = '<p>Most South Carolina wrongful death settlements fall between roughly <strong>$250,000 and several million dollars</strong>, depending on the circumstances of the death, the deceased person\'s age, earnings, and family, and the strength of the liability case. South Carolina places <strong>no cap on compensatory damages</strong> in an ordinary wrongful death case. Because the value of a human life cannot be reduced to a formula, there is no meaningful "average" — every case turns on its own facts.</p>

<p>Below we explain honestly how South Carolina wrongful death case value is calculated, the two distinct claims a death case can involve, what the beneficiaries can recover, and how South Carolina law shapes the final payout. These figures are educational illustrations only — past results do not guarantee future outcomes, and every case is unique.</p>

<h2>Two Claims: Wrongful Death vs. the Survival Action</h2>
<p>A South Carolina death caused by negligence can give rise to <strong>two separate claims</strong>, and a thorough case pursues both because they compensate different losses.</p>

<h3>The wrongful-death claim (S.C. Code § 15-51)</h3>
<p>The wrongful-death claim compensates the <strong>surviving beneficiaries</strong> for <em>their</em> losses caused by the death. Brought by the estate\'s personal representative for the benefit of the statutory beneficiaries, it can recover:</p>
<ul>
<li><strong>Loss of financial support</strong> — the income and services the deceased would have provided.</li>
<li><strong>Loss of companionship and society</strong> — the relationship, care, and comfort now gone.</li>
<li><strong>Mental anguish and grief</strong> of the beneficiaries.</li>
<li><strong>Loss of guidance</strong> — especially for children who lost a parent.</li>
<li><strong>Funeral and burial expenses.</strong></li>
</ul>

<h3>The survival action (S.C. Code § 15-5-90)</h3>
<p>The survival action compensates the <strong>estate</strong> for what the deceased <em>personally</em> endured before death — most importantly the <strong>conscious pain and suffering</strong> between the injury and death, plus the medical bills incurred during that period. When a person survived for a time and suffered, the survival action can add significant value on top of the wrongful-death claim.</p>
<p>Graeham C. Gillin, a partner at Roden Law\'s Charleston office, notes that pursuing both claims together is essential in South Carolina, because they compensate fundamentally different losses — the family\'s loss and the decedent\'s own suffering — and overlooking the survival action can leave substantial value on the table.</p>

<h2>Who Can Recover in a South Carolina Wrongful Death Case</h2>
<p>South Carolina law sets a fixed order of beneficiaries who share the wrongful-death recovery:</p>
<ul>
<li>First, the <strong>surviving spouse and children</strong>.</li>
<li>If there is no spouse or child, the <strong>surviving parents</strong>.</li>
<li>If none of those survive, the <strong>heirs at law</strong> of the deceased.</li>
</ul>
<p>The claim itself is filed by the <strong>personal representative</strong> (executor or administrator) of the estate on the beneficiaries\' behalf.</p>

<h2>What Determines the Value of a South Carolina Wrongful Death Case</h2>
<p>Wrongful death value is determined by the size of the losses and the strength of the liability case. Key value drivers include:</p>
<ul>
<li><strong>The deceased\'s earnings and life expectancy</strong> — a younger wage-earner with dependents typically supports a larger financial-support component.</li>
<li><strong>The family relationships</strong> — a spouse and minor children generally support larger companionship and guidance damages.</li>
<li><strong>Conscious pain and suffering before death</strong> — the survival-action component.</li>
<li><strong>The defendant\'s conduct</strong> — reckless or willful conduct can support punitive damages.</li>
<li><strong>Available insurance</strong> — the practical ceiling on what can actually be recovered.</li>
</ul>
<p><strong>South Carolina places no cap on these compensatory damages</strong> in an ordinary wrongful death case; the statutory non-economic cap applies only to medical-malpractice claims.</p>

<h2>Illustrative Value by Circumstances</h2>
<p>Because wrongful death value depends so heavily on the individual and the family, ranges are especially rough here. The illustrations below are educational only — not predictions, and your case could fall well outside them.</p>

<table>
<tr><th>Circumstances</th><th>Typical considerations</th><th>Illustrative range</th></tr>
<tr><td>Older adult, limited dependents</td><td>Companionship, funeral costs, limited financial support</td><td>$250,000 &ndash; $1,000,000</td></tr>
<tr><td>Working adult with dependents</td><td>Significant lost financial support, guidance for children</td><td>$1,000,000 &ndash; several million</td></tr>
<tr><td>Egregious or reckless conduct</td><td>Full compensatory losses plus possible punitive damages</td><td>Several million+</td></tr>
</table>

<p>These figures are illustrations only and are not a promise or prediction. The true value of a wrongful death case depends entirely on the specific facts, the losses proven, and the available insurance.</p>

<h2>How South Carolina Law Affects Your Payout</h2>
<p>South Carolina law affects a wrongful death payout in several ways: the deadline to file, the deceased\'s own fault, punitive damages, and special caps against government defendants.</p>

<h3>The filing deadline (statute of limitations)</h3>
<p>In South Carolina, you generally have <strong>3 years</strong> from the date of death to file a wrongful death lawsuit under <strong>S.C. Code § 15-3-530</strong>. Government-defendant claims can carry much shorter notice deadlines.</p>

<h3>Comparative fault</h3>
<p>South Carolina\'s <strong>modified comparative negligence</strong> rule applies: if the deceased was partly at fault, the recovery is reduced by that percentage, and barred if the deceased was 51% or more at fault. Learn how <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a> works.</p>

<h3>Punitive damages</h3>
<p>Punitive damages are available in South Carolina wrongful death cases when the death resulted from <strong>reckless or willful conduct</strong> — such as a drunk driver or grossly unsafe conduct. Under <strong>S.C. Code § 15-32-530</strong>, punitive damages are generally capped at the greater of three times compensatory damages or an inflation-adjusted minimum (about <strong>$739,000 as of 2026, adjusted annually</strong>), and that cap is removed entirely when the defendant was driving under the influence, convicted of a felony from the conduct, or acted with intent to harm.</p>

<h3>Government defendant caps</h3>
<p>If a government entity caused the death, the <strong>South Carolina Tort Claims Act (S.C. Code § 15-78-120)</strong> caps damages at <strong>$300,000 per person and $600,000 per occurrence</strong> and bars punitive damages against the government.</p>

<h2>Why Roden Law for Your South Carolina Wrongful Death Case</h2>
<p>Firm-wide, Roden Law has recovered <strong>more than $300 million</strong> for injured clients and the families of those killed by negligence, across <strong>more than 5,000 cases</strong>, and holds a <strong>4.9-star average</strong> across hundreds of client reviews. These figures reflect results across every kind of case the firm handles and are shared to show the firm\'s overall track record rather than to predict any individual outcome. In a wrongful death case, our South Carolina attorneys handle the legal process with compassion so your family can focus on healing.</p>
<p>This result is shared to show what is possible in the most serious cases. It is not a promise or prediction. Past results do not guarantee future outcomes, and every case is unique. If you want an honest, compassionate assessment of what your family\'s South Carolina wrongful death claim may be worth, a Roden Law attorney can review your case at no cost. There are no fees unless we win.</p>
<p>To learn more, see our <a href="/south-carolina-wrongful-death-lawyer/">South Carolina wrongful death lawyer</a> page and our <a href="/practice-areas/wrongful-death-lawyers/">wrongful death practice</a> overview. You may also find our related value guides useful: <a href="/resources/south-carolina-car-accident-settlement-value/">car accident case value</a> and <a href="/resources/south-carolina-truck-accident-settlement-value/">truck accident case value</a>. You can reach our <a href="/locations/south-carolina/charleston/">Charleston office</a> directly to speak with an attorney.</p>';
$faqs          = array (
  0 =>
  array (
    'question' => 'What is the average wrongful death settlement in South Carolina?',
    'answer' => 'There is no reliable single average, because a life cannot be reduced to a formula. South Carolina wrongful death settlements commonly range from six figures to several million dollars, depending on the deceased person\'s age, earnings, and family, the circumstances of the death, and available insurance. There is no cap on compensatory damages. Every case is unique and no result is guaranteed.',
  ),
  1 =>
  array (
    'question' => 'What is the difference between a wrongful death claim and a survival action in South Carolina?',
    'answer' => 'A wrongful-death claim (S.C. Code § 15-51) compensates the surviving beneficiaries for their losses — financial support, companionship, grief, and guidance. A survival action (S.C. Code § 15-5-90) compensates the estate for what the deceased personally endured before death, especially conscious pain and suffering. A thorough South Carolina case pursues both because they cover different losses.',
  ),
  2 =>
  array (
    'question' => 'Who can file and recover in a South Carolina wrongful death case?',
    'answer' => 'The estate\'s personal representative files the claim on behalf of the statutory beneficiaries. The recovery goes first to the surviving spouse and children; if there are none, to the surviving parents; and if none survive, to the deceased person\'s heirs at law. This fixed order is set by South Carolina law.',
  ),
  3 =>
  array (
    'question' => 'Is there a cap on wrongful death damages in South Carolina?',
    'answer' => 'No, not in an ordinary case — South Carolina places no cap on compensatory damages in wrongful death. Punitive damages are generally capped under S.C. Code § 15-32-530, but that cap is removed for DUI, felony, or intent-to-harm conduct. If a government entity caused the death, the Tort Claims Act caps recovery at $300,000 per person and $600,000 per occurrence.',
  ),
  4 =>
  array (
    'question' => 'How long do I have to file a wrongful death claim in South Carolina?',
    'answer' => 'In South Carolina, you generally have 3 years from the date of death to file a wrongful death lawsuit under S.C. Code § 15-3-530. If a government entity is a defendant, notice deadlines can be much shorter. Acting early helps preserve evidence and protects the family\'s right to recover.',
  ),
  5 =>
  array (
    'question' => 'Are punitive damages available in South Carolina wrongful death cases?',
    'answer' => 'Yes, when the death resulted from reckless or willful conduct such as drunk driving. Under S.C. Code § 15-32-530, punitive damages are generally capped at the greater of three times compensatory damages or an inflation-adjusted minimum (about $739,000 as of 2026, adjusted annually), and that cap is removed entirely for DUI, felony conduct, or intent to harm. They are not available against a government defendant.',
  ),
);
$see_also      = array (
  0 =>
  array (
    'url' => '/south-carolina-wrongful-death-lawyer/',
    'text' => 'South Carolina Wrongful Death Lawyer',
  ),
  1 =>
  array (
    'url' => '/practice-areas/wrongful-death-lawyers/',
    'text' => 'Wrongful Death Lawyers',
  ),
  2 =>
  array (
    'url' => '/resources/south-carolina-car-accident-settlement-value/',
    'text' => 'How Much Is a SC Car Accident Case Worth?',
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
