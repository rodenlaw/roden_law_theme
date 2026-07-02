<?php
/**
 * Seeder: "How Much Is a SC Premises Liability Case Worth?" resource page.
 *
 * AEO value/answer page targeting "how much is a premises liability settlement
 * worth in South Carolina" — answer-first, SC-jurisdiction, with Key Takeaways +
 * FAQPage schema + author attribution. SC competitor-gap build (row 7, 2026-06-29).
 * Scoped to the BROAD category (negligent security/assaults, inadequate
 * maintenance, pool/stairwell/parking-lot hazards); slip-and-fall is one subset
 * covered in depth on its own value page.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-resource-sc-premises-liability-worth.php
 *
 * Idempotent — skips if the slug already exists. Ships as DRAFT.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title         = 'How Much Is a SC Premises Liability Case Worth?';
$slug          = 'south-carolina-premises-liability-settlement-value';
$meta_desc     = 'South Carolina premises liability covers far more than falls — negligent security, assaults, and unsafe conditions. There is no cap on your compensatory damages in ordinary cases.';
$key_takeaways = 'South Carolina premises liability settlements range from tens of thousands of dollars to several million, depending on the hazard, how badly you were hurt, and whether the owner knew about the danger. Premises liability is broad — it covers negligent security and assaults, inadequate maintenance, pool, stairwell, and parking-lot hazards, and slip and falls. South Carolina places no cap on compensatory damages in ordinary cases, but your award is reduced by your fault (barred at 51%), and Tort Claims Act caps of $300,000 per person / $600,000 per occurrence apply on government property. You generally have 3 years to file (S.C. Code § 15-3-530).';
$content       = '<p>Most South Carolina premises liability settlements fall between roughly <strong>$25,000 and $500,000</strong>, while the most serious cases — a shooting at an under-secured apartment complex, a child drowning in an unfenced pool, a catastrophic fall from a defective stairwell — can reach <strong>several million dollars or more</strong>. Premises liability is a <strong>broad category</strong>: it covers any injury caused by a property owner\'s failure to keep their premises reasonably safe, not just slip and falls. There is no single "average" that fits every case.</p>

<p>Below we explain honestly how South Carolina premises liability case value is calculated, the many hazard types this area of law covers, illustrative ranges by injury severity, and how South Carolina law shapes your final payout. These figures are educational illustrations only — past results do not guarantee future outcomes, and every case is unique.</p>

<h2>What Premises Liability Covers in South Carolina</h2>
<p>Premises liability is the area of law that holds property owners and occupiers responsible when their negligence makes a property unsafe and someone is hurt. It is much broader than a slip and fall. South Carolina premises cases include:</p>
<ul>
<li><strong>Negligent security and assaults</strong> — a robbery, shooting, or assault at an apartment complex, bar, parking garage, or hotel that failed to provide reasonable lighting, cameras, or security despite known crime risk.</li>
<li><strong>Inadequate maintenance</strong> — collapsing balconies, falling fixtures, exposed wiring, or structures left in disrepair.</li>
<li><strong>Pool and water hazards</strong> — drownings and near-drownings at unfenced or unsupervised pools, especially involving children.</li>
<li><strong>Stairwell and railing failures</strong> — falls caused by broken handrails, defective treads, or code violations.</li>
<li><strong>Parking-lot hazards</strong> — potholes, poor lighting, unmarked drop-offs, and uncontrolled traffic.</li>
<li><strong>Slip and falls</strong> — one common subset of premises liability, covered in depth on our <a href="/resources/south-carolina-slip-and-fall-settlement-value/">slip and fall case value</a> page.</li>
</ul>
<p>The type of hazard matters for value: a negligent-security case that involves a serious assault or death often carries far higher stakes than a minor trip-and-fall, both because the injuries are catastrophic and because the owner\'s conduct can support punitive damages.</p>

<h2>What Determines the Value of a South Carolina Premises Liability Case</h2>
<p>Premises liability value is determined by the strength of your liability case and the size of your damages, working together. You generally must show the owner knew or should have known about the dangerous condition (notice) and failed to address it.</p>

<h3>Economic and non-economic damages</h3>
<p>Once liability is established, value scales with your damages — economic (medical bills, lost wages, future care) and non-economic (pain and suffering, mental anguish, loss of enjoyment of life). <strong>South Carolina places no cap on these compensatory damages</strong> in an ordinary premises case; the statutory non-economic cap applies only to medical-malpractice claims.</p>
<p>Graeham C. Gillin, a partner at Roden Law\'s Charleston office, notes that in negligent-security cases, evidence of prior crime on or near the property — police reports, prior incidents, and the owner\'s knowledge of the risk — often makes the difference between a modest claim and a substantial one, because it establishes that the harm was foreseeable and preventable.</p>

<h2>Typical Settlement Ranges by Injury Severity</h2>
<p>Premises liability settlement value scales with injury severity once liability is clear. The illustrative ranges below reflect how value generally tiers up — they are educational examples, not predictions, and your case could fall well outside them.</p>

<table>
<tr><th>Injury severity</th><th>Typical examples</th><th>Illustrative settlement range</th></tr>
<tr><td>Minor</td><td>Sprains, minor cuts, short recovery</td><td>$10,000 &ndash; $50,000</td></tr>
<tr><td>Moderate</td><td>Fractures, surgery, several months of treatment</td><td>$50,000 &ndash; $250,000</td></tr>
<tr><td>Severe</td><td>Permanent injury, assault injuries, long-term impairment</td><td>$250,000 &ndash; $1,000,000+</td></tr>
<tr><td>Catastrophic</td><td>Brain injury, spinal cord injury, drowning, wrongful death</td><td>$1,000,000 &ndash; several million+</td></tr>
</table>

<p>These ranges are illustrations only. Two premises cases with the same injury can settle for very different amounts depending on how clear the owner\'s negligence is, your comparative fault, and available insurance. No range here is a promise or a prediction.</p>

<h2>How South Carolina Law Affects Your Payout</h2>
<p>South Carolina law affects your premises liability payout in three major ways: the deadline to file, how your own fault reduces your award, and special caps when a government entity owns the property.</p>

<h3>The filing deadline (statute of limitations)</h3>
<p>In South Carolina, you generally have <strong>3 years</strong> from the date of injury to file a premises liability lawsuit under <strong>S.C. Code § 15-3-530</strong>. Miss that deadline and you typically lose the right to recover. Government-property claims can carry much shorter notice deadlines.</p>

<h3>Comparative fault reduces your award</h3>
<p>South Carolina follows <strong>modified comparative negligence</strong>: you can recover as long as you are <strong>less than 51% at fault</strong>, but your award is reduced by your percentage of fault. If your case is worth $400,000 and you are 15% at fault, you recover $340,000; at 51% or more, you recover nothing. Learn how <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a> works.</p>

<h3>Government property: the Tort Claims Act caps</h3>
<p>If your injury happened on <strong>public property</strong> — a city or county facility, a public housing complex, a school, or an SCDOT-maintained area — the <strong>South Carolina Tort Claims Act (S.C. Code § 15-78-120)</strong> caps damages at <strong>$300,000 per person and $600,000 per occurrence</strong> and bars punitive damages against the government. These fixed caps are a critical disclosure if a government entity is responsible for the property where you were hurt.</p>

<h3>Punitive damages in serious cases</h3>
<p>Punitive damages may be available when a private owner acted recklessly — for example, ignoring repeated warnings about violent crime or a known deadly hazard. Under <strong>S.C. Code § 15-32-530</strong>, punitive damages are generally capped at the greater of three times compensatory damages or an inflation-adjusted minimum (about <strong>$739,000 as of 2026, adjusted annually</strong>). They are not available against a government defendant and are never guaranteed.</p>

<h2>How Premises Liability Settlements Are Calculated</h2>
<p>A premises liability settlement is calculated by first establishing liability, then adding your economic damages to your non-economic damages, and finally adjusting for fault and available insurance.</p>
<ul>
<li><strong>Liability</strong> comes first — proving the owner knew or should have known about the hazard and failed to act.</li>
<li><strong>Special damages</strong> (economic) are added up from medical bills, wage statements, and future-care estimates.</li>
<li><strong>General damages</strong> (non-economic) are estimated from injury severity and permanence, often using a rough "multiplier" of the economic damages.</li>
<li><strong>Fault and coverage</strong> then adjust the total — reduced by your comparative-fault share and limited by the owner\'s liability insurance (or Tort Claims Act caps on public property).</li>
</ul>
<p>The multiplier is a rough industry concept, not a South Carolina legal formula. No lawyer can promise a particular number; the real value comes from the specific facts and evidence.</p>

<h2>Why Roden Law for Your South Carolina Premises Liability Case</h2>
<p>Firm-wide, Roden Law has recovered <strong>more than $300 million</strong> for injured clients across <strong>more than 5,000 cases</strong> of all types, and holds a <strong>4.9-star average</strong> across hundreds of client reviews. These figures reflect results across every kind of injury claim the firm handles, not premises cases alone, and are shared to show the firm\'s overall track record rather than to predict any individual outcome. In a premises case, our South Carolina attorneys focus on proving notice, establishing liability, and identifying every source of available insurance coverage — the factors that most directly drive what a claim is worth.</p>
<p>This result is shared to show what is possible in the most serious cases. It is not a promise or prediction. Past results do not guarantee future outcomes, and every case is unique. If you want an honest assessment of what your South Carolina premises liability claim may be worth, a Roden Law attorney can review your case at no cost. There are no fees unless we win.</p>
<p>For a fall specifically, see our <a href="/resources/south-carolina-slip-and-fall-settlement-value/">South Carolina slip and fall case value</a> guide. To learn more about how these claims work, see our <a href="/practice-areas/premises-liability-lawyers/">premises liability practice</a> page, and our related value guides for <a href="/resources/south-carolina-car-accident-settlement-value/">car accidents</a> and <a href="/resources/south-carolina-wrongful-death-settlement-value/">wrongful death</a>. You can also reach our <a href="/locations/south-carolina/charleston/">Charleston office</a> directly to speak with an attorney.</p>';
$faqs          = array (
  0 =>
  array (
    'question' => 'What is the average premises liability settlement in South Carolina?',
    'answer' => 'There is no reliable single average. South Carolina premises liability settlements range from tens of thousands of dollars to several million, depending on the hazard, how badly you were hurt, whether the owner had notice, and your share of fault. Negligent-security and catastrophic-injury cases sit at the high end. Every case is unique and no result is guaranteed.',
  ),
  1 =>
  array (
    'question' => 'What is the difference between premises liability and slip and fall in South Carolina?',
    'answer' => 'Premises liability is the broad category covering any injury from an unsafe property — negligent security and assaults, inadequate maintenance, pool and stairwell hazards, and parking-lot dangers. A slip and fall is one common subset involving falls specifically. Both require proving the owner was negligent about a hazard they knew or should have known about.',
  ),
  2 =>
  array (
    'question' => 'Can I sue for an assault or shooting at a business in South Carolina?',
    'answer' => 'Sometimes. A negligent-security claim can hold a property owner responsible when they failed to provide reasonable security — lighting, cameras, or guards — despite known crime risk, and that failure allowed an assault or shooting to occur. Evidence of prior crime on or near the property is often key to showing the harm was foreseeable and preventable.',
  ),
  3 =>
  array (
    'question' => 'Is there a cap on damages in a South Carolina premises liability case?',
    'answer' => 'Not in an ordinary case against a private owner — South Carolina places no cap on compensatory damages. But if the property is government-owned, the South Carolina Tort Claims Act (S.C. Code § 15-78-120) caps damages at $300,000 per person and $600,000 per occurrence and bars punitive damages against the government.',
  ),
  4 =>
  array (
    'question' => 'How long do I have to file a premises liability claim in South Carolina?',
    'answer' => 'In South Carolina, you generally have 3 years from the date of injury to file a premises liability lawsuit under S.C. Code § 15-3-530. If a government entity owns the property, notice deadlines can be much shorter. Acting early also helps preserve evidence like surveillance video and incident reports before they disappear.',
  ),
  5 =>
  array (
    'question' => 'Are punitive damages available in South Carolina premises liability cases?',
    'answer' => 'They can be, against a private owner who acted recklessly — for example, ignoring repeated warnings about violent crime or a known deadly hazard. Under S.C. Code § 15-32-530, punitive damages are generally capped at the greater of three times compensatory damages or an inflation-adjusted minimum (about $739,000 as of 2026, adjusted annually). They are not available against a government defendant.',
  ),
);
$see_also      = array (
  0 =>
  array (
    'url' => '/practice-areas/premises-liability-lawyers/',
    'text' => 'South Carolina Premises Liability Lawyers',
  ),
  1 =>
  array (
    'url' => '/resources/south-carolina-slip-and-fall-settlement-value/',
    'text' => 'How Much Is a SC Slip and Fall Case Worth?',
  ),
  2 =>
  array (
    'url' => '/resources/south-carolina-wrongful-death-settlement-value/',
    'text' => 'How Much Is a SC Wrongful Death Case Worth?',
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
