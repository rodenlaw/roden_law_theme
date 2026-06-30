<?php
/**
 * Seeder: "South Carolina Modified Comparative Negligence — the 51% Bar" explainer.
 *
 * SC-law explainer hub, page 2 of 4 (SC competitor gap analysis 2026-06-29, P0-1).
 * Out-formats Steinberg + Derrick comparative-negligence articles with worked
 * dollar examples + FAQPage schema. South-Carolina-only jurisdiction.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-resource-sc-comparative-negligence.php
 *
 * Idempotent — skips if the slug already exists. Ships as DRAFT for human review.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title         = 'South Carolina Comparative Negligence — the 51% Bar Explained';
$slug          = 'south-carolina-comparative-negligence';
$meta_desc     = 'South Carolina is a modified comparative negligence state with a 51% bar: you can recover if you are less than 51% at fault, but your award drops by your fault share.';
$key_takeaways = 'South Carolina follows modified comparative negligence with a 51% bar. You can recover compensation as long as you are less than 51% at fault for your own injuries, but your award is reduced by your percentage of fault. If you are 51% or more at fault, you recover nothing. For example, on a $300,000 case, being 20% at fault leaves you $240,000, while 51% fault leaves you $0. Insurance companies routinely try to inflate your fault percentage to cut or eliminate your payout, which is why how fault is assigned has a direct dollar impact on your case.';
$content       = '<p>South Carolina is a <strong>modified comparative negligence</strong> state with a <strong>51% bar</strong>. In plain terms: you can still recover money for your injuries as long as you are <strong>less than 51% at fault</strong> &mdash; that is, 50% or less &mdash; but whatever you recover is <strong>reduced by your own percentage of fault</strong>. If you are found 51% or more at fault, you recover nothing. So if your case is worth $300,000 and you are 20% at fault, you recover $240,000; if you are 51% at fault, you recover $0.</p>

<p>This single rule shapes the value of almost every injury claim in South Carolina, because the at-fault driver&rsquo;s insurance company will fight hard to pin as much blame on you as possible. Below, a Roden Law attorney explains how the 51% bar works, walks through worked dollar examples, and shows how insurers weaponize comparative fault &mdash; and how a lawyer pushes back. Roden Law works on a contingency fee basis: no upfront cost, and no legal fees unless we win your case.</p>

<h2>Is South Carolina a comparative negligence state?</h2>
<p>Yes. South Carolina follows <strong>modified comparative negligence</strong>. Under this system, an injured person who is partly responsible for an accident can still recover damages &mdash; but only up to a limit, and only with a reduction for their own share of the blame. South Carolina adopted this rule in the South Carolina Supreme Court&rsquo;s decision in <strong>Nelson v. Concrete Supply Co.</strong> (1991), which replaced the older, harsher "contributory negligence" rule that barred any plaintiff who was even 1% at fault.</p>
<p>South Carolina&rsquo;s comparative negligence rule is <strong>common law &mdash; not a statute</strong>. It comes from the South Carolina Supreme Court&rsquo;s decision in <em>Nelson v. Concrete Supply Co.</em>, 303 S.C. 243, 399 S.E.2d 783 (1991), and applies to negligence claims arising on or after July 1, 1991. Where more than one defendant is at fault, your share of the blame is compared against their <em>combined</em> fault.</p>

<h2>What is the 51% bar?</h2>
<p>The "51% bar" is the cutoff that decides whether you can recover at all:</p>
<ul>
<li>If you are <strong>50% or less at fault</strong>, you can recover &mdash; reduced by your fault percentage.</li>
<li>If you are <strong>51% or more at fault</strong>, you are barred and recover nothing.</li>
</ul>
<p>This is why South Carolina is called a "51% bar" state rather than a "50% bar" state: the line falls at 51%. A plaintiff who is exactly 50% at fault still recovers (half of their damages); a plaintiff who tips to 51% recovers zero. That one-percentage-point difference can be worth hundreds of thousands of dollars, which is exactly why fault allocation is so heavily contested.</p>

<h2>How does comparative fault reduce my settlement? Worked examples</h2>
<p>Your recovery is calculated by taking your total damages and subtracting your percentage of fault. The table below uses a sample case to show how the 51% bar plays out at different fault levels.</p>
<table>
<tr><th>Total case value</th><th>Your share of fault</th><th>What you recover</th></tr>
<tr><td>$300,000</td><td>0% (other party fully at fault)</td><td>$300,000</td></tr>
<tr><td>$300,000</td><td>20%</td><td>$240,000</td></tr>
<tr><td>$300,000</td><td>50%</td><td>$150,000</td></tr>
<tr><td>$300,000</td><td>51% or more</td><td>$0 (barred)</td></tr>
</table>
<p>A few takeaways from these examples. At low fault levels the reduction is modest. At 50% you still recover half. But the moment your fault is assessed at 51%, you lose everything &mdash; there is no partial recovery beyond the bar. That cliff is what makes the difference between, say, 49% and 51% fault so consequential, and why insurers fight to push your number over the line.</p>

<h2>What if I&rsquo;m partly at fault &mdash; can I still recover?</h2>
<p>Yes, as long as your share of fault stays below 51%. Many injured people wrongly assume that because they made a mistake &mdash; they were speeding slightly, looked away for a moment, or were not wearing a seatbelt &mdash; they cannot recover at all. That is not how South Carolina law works. You can be partly responsible and still win meaningful compensation; your award is simply reduced in proportion to your fault. Do not let an insurance adjuster talk you out of a valid claim by overstating your role in the crash.</p>

<h2>How insurance companies use comparative fault against you</h2>
<p>Comparative fault is the insurance industry&rsquo;s favorite tool for cutting payouts. Adjusters know that every percentage point of fault they shift onto you reduces what they owe &mdash; and that pushing you to 51% erases the claim entirely. Common tactics include:</p>
<ul>
<li>Asking for a <strong>recorded statement</strong> early, then using your words to suggest you contributed to the crash.</li>
<li>Arguing you were <strong>distracted, speeding, or could have avoided</strong> the collision, even with thin evidence.</li>
<li>Pointing to a <strong>seatbelt or helmet</strong> issue to inflate your share of the harm.</li>
<li>Making a <strong>fast, low settlement offer</strong> before you understand how fault could be argued against you.</li>
</ul>
<p>An experienced South Carolina injury attorney counters these tactics with evidence &mdash; the police report, crash reconstruction, witness statements, vehicle data, and medical records &mdash; to keep your fault percentage as low as the facts support, and to protect your recovery from being chipped away or barred.</p>

<h2>How is fault divided among multiple defendants?</h2>
<p>When more than one party is responsible &mdash; for example, two drivers plus a trucking company &mdash; South Carolina law also governs how fault and payment are apportioned <em>among the defendants</em>. Under <strong>S.C. Code &sect; 15-38-15</strong>, a defendant found <strong>less than 50% at fault</strong> is generally responsible only for its own share of the damages, while a defendant found <strong>50% or more at fault</strong> can be held responsible for the entire award. The practical point for you is that having multiple defendants can mean multiple insurance policies available to pay your claim &mdash; one reason identifying every liable party early is so important.</p>

<h2>Protect your recovery &mdash; talk to a South Carolina injury attorney</h2>
<p>If you have been injured in South Carolina and the other side is hinting that the crash was partly your fault, do not accept their version of events &mdash; and do not accept a lowball offer built on inflated fault. A Roden Law attorney will investigate, build the evidence that keeps your fault percentage low, and fight for the full value of your claim. The review is free, and there are no fees unless we win.</p>
<p>To understand the deadline that applies to your case, see our guide to the <a href="/resources/south-carolina-statute-of-limitations/">South Carolina statute of limitations</a>, and explore our <a href="/practice-areas/car-accident-lawyers/">car accident</a> and <a href="/practice-areas/truck-accident-lawyers/">truck accident</a> practice pages. You can also reach our <a href="/locations/south-carolina/charleston/">Charleston office</a> at (843) 790-8999.</p>';

$faqs = array(
    array(
        'question' => 'Is South Carolina a comparative negligence state?',
        'answer'   => 'Yes. South Carolina follows modified comparative negligence with a 51% bar, adopted in Nelson v. Concrete Supply Co. (1991). You can recover compensation as long as you are less than 51% at fault, but your award is reduced by your percentage of fault. At 51% or more fault, you recover nothing.',
    ),
    array(
        'question' => 'What is the 51% bar in South Carolina?',
        'answer'   => 'The 51% bar is the cutoff for recovery. If you are 50% or less at fault, you can recover damages, reduced by your fault percentage. If you are 51% or more at fault, you are barred from recovering anything. That one-percentage-point line can be worth hundreds of thousands of dollars, which is why fault is heavily contested.',
    ),
    array(
        'question' => 'Can I still recover if the accident was partly my fault in South Carolina?',
        'answer'   => 'Yes, as long as your share of fault is less than 51%. Many injured people wrongly assume any mistake bars their claim, but South Carolina only reduces your award in proportion to your fault. For example, on a $200,000 case where you are 25% at fault, you would recover $150,000.',
    ),
    array(
        'question' => 'How do insurance companies use comparative fault against me?',
        'answer'   => 'Insurers try to inflate your percentage of fault because every point reduces what they owe, and pushing you to 51% erases the claim entirely. They request early recorded statements, argue you were distracted or speeding, and make fast lowball offers. An attorney counters with evidence to keep your fault percentage as low as the facts support.',
    ),
    array(
        'question' => 'What happens to my settlement if I am found 30% at fault?',
        'answer'   => 'Your recovery is reduced by your fault percentage. If you are 30% at fault on a case worth $300,000, you recover $210,000 — that is the full value minus your 30% share. As long as you stay below 51% at fault, you still recover; the award is simply reduced proportionally.',
    ),
);

$see_also = array(
    array(
        'url'  => '/resources/south-carolina-statute-of-limitations/',
        'text' => 'South Carolina Statute of Limitations for Injury Claims',
    ),
    array(
        'url'  => '/practice-areas/car-accident-lawyers/',
        'text' => 'South Carolina Car Accident Lawyers',
    ),
    array(
        'url'  => '/practice-areas/truck-accident-lawyers/',
        'text' => 'South Carolina Truck Accident Lawyers',
    ),
);

// Author attribution — Graeham C. Gillin (Charleston, SC partner).
$author    = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' );
$author_id = $author ? $author->ID : 0;
if ( ! $author_id ) {
    WP_CLI::warning( 'Attorney "graeham-c-gillin" not found — author attribution will be empty.' );
}

// SC-law explainer hub category.
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
