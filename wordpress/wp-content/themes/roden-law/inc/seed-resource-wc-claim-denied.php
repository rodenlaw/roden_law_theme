<?php
/**
 * Seeder: "What to Do If Your SC Workers' Comp Claim Is Denied" explainer.
 *
 * SC workers'-comp explainer set, page 4 of 4 (SC competitor gap analysis
 * 2026-06-29, P1 row 6). Out-formats Derrick's denied-claim cluster with the
 * verified SC appeal ladder + deadlines + FAQPage schema. South-Carolina-only.
 * Ships as DRAFT for human review.
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-resource-wc-claim-denied.php
 *
 * Idempotent — skips if the slug already exists.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title         = 'What to Do If Your SC Workers\' Comp Claim Is Denied';
$slug          = 'south-carolina-workers-comp-claim-denied';
$meta_desc     = 'A denied South Carolina workers\' comp claim is not the end. Learn the appeal ladder, the deadlines (14 days, 30 days), and the forms you need to fight a denial.';
$key_takeaways = 'A denied South Carolina workers\' compensation claim is not the end of your case — there is a defined appeal ladder, but the deadlines are short and unforgiving. You start by requesting a hearing with Form 50 (Form 52 for a death claim) before a single Commissioner of the Workers\' Compensation Commission. If you lose, you appeal to the Appellate Panel (the full Commission) within 14 days using Form 30 (a $150 fee applies). From there you can appeal to the South Carolina Court of Appeals within 30 days — a route available for injuries on or after July 1, 2007 — and finally seek discretionary review by the South Carolina Supreme Court. Common reasons for denial include disputes over whether the injury is work-related, missed deadlines, pre-existing-condition arguments, and independent-contractor misclassification. Because each appeal deadline is firm, getting an attorney involved quickly after a denial is critical.';
$content       = '<p>Having your South Carolina workers&rsquo; compensation claim denied is frustrating, but it is <strong>not the end of your case</strong>. The South Carolina Workers&rsquo; Compensation Commission has a defined appeal ladder, and many denials are reversed once the claim is properly presented with the right evidence. The catch is that each step has a <strong>short, firm deadline</strong> &mdash; miss one and you can lose your right to appeal entirely.</p>

<p>Below, a Roden Law attorney walks through why claims get denied, the appeal ladder step by step, and the deadlines you cannot afford to miss. Roden Law works on a contingency fee basis &mdash; no upfront cost and no fees unless we win.</p>

<h2>Why was my South Carolina workers\' comp claim denied?</h2>
<p>Insurers deny claims for a range of reasons, some legitimate and many contestable. The most common include:</p>
<ul>
<li><strong>Dispute over whether the injury is work-related</strong> &mdash; the insurer argues the injury did not arise out of or in the course of your employment.</li>
<li><strong>Missed deadlines</strong> &mdash; the insurer claims you did not report the injury within 90 days (&sect; 42-15-20) or did not file your claim within 2 years (&sect; 42-15-40).</li>
<li><strong>Pre-existing-condition arguments</strong> &mdash; the insurer blames a prior injury or degenerative condition rather than the workplace accident.</li>
<li><strong>Independent-contractor classification</strong> &mdash; the company argues you were a contractor, not an employee, and therefore not covered.</li>
</ul>
<p>Many of these defenses can be overcome with medical evidence, witness statements, and a correct reading of your employment status &mdash; which is exactly what the appeal process is for.</p>

<h2>What is the South Carolina workers\' comp appeal ladder?</h2>
<p>If your claim is denied, you move up a series of steps, each with its own deadline:</p>
<ul>
<li><strong>Step 1 &mdash; Request a hearing (Form 50).</strong> File a <strong>Form 50</strong> (or <strong>Form 52</strong> for a death claim) to request a hearing before a <strong>single Commissioner</strong> of the Workers&rsquo; Compensation Commission. The Commissioner holds a hearing and issues an order.</li>
<li><strong>Step 2 &mdash; Appeal to the Appellate Panel within 14 days.</strong> To challenge the single Commissioner&rsquo;s order, file a <strong>Form 30</strong> ("Request for Commission Review") within <strong>14 days</strong> under &sect; 42-17-50. A <strong>$150 fee</strong> applies. The full Commission, sitting as the <strong>Appellate Panel</strong>, reviews the decision.</li>
<li><strong>Step 3 &mdash; Appeal to the SC Court of Appeals within 30 days.</strong> If the Appellate Panel rules against you, you can appeal to the <strong>South Carolina Court of Appeals</strong> within <strong>30 days</strong> under &sect; 42-17-60. This direct route to the Court of Appeals applies to injuries occurring <strong>on or after July 1, 2007</strong>.</li>
<li><strong>Step 4 &mdash; Seek review by the SC Supreme Court.</strong> Finally, you may ask the <strong>South Carolina Supreme Court</strong> to review the case, though that review is <strong>discretionary</strong> &mdash; the Court decides whether to take it.</li>
</ul>

<h2>How long do I have to appeal a denial?</h2>
<p>The deadlines tighten as you go up the ladder, and they are strict:</p>
<table>
<tr><th>Appeal step</th><th>Deadline</th><th>Authority / form</th></tr>
<tr><td>Single Commissioner&rsquo;s order to the Appellate Panel</td><td>14 days</td><td>&sect; 42-17-50 (Form 30, $150 fee)</td></tr>
<tr><td>Appellate Panel to the SC Court of Appeals</td><td>30 days</td><td>&sect; 42-17-60</td></tr>
<tr><td>SC Court of Appeals to the SC Supreme Court</td><td>Discretionary review</td><td>SC Supreme Court</td></tr>
</table>
<p>Because the first appeal deadline is just <strong>14 days</strong>, you should not wait to act after a denial. Missing a deadline at any level can end your case regardless of how strong the underlying claim is.</p>

<h2>Should I get a lawyer to fight a denied claim?</h2>
<p>Strongly consider it. By the time a claim is denied, the insurer has already decided to fight you, and the appeal process is adversarial and deadline-driven. An attorney can gather the medical and employment evidence that overcomes the denial, file the right forms on time, and present your case at the hearing and on appeal. In South Carolina, workers&rsquo; comp attorneys work on a contingency basis and their fees are subject to Commission approval, so you can pursue an appeal without paying out of pocket.</p>

<h2>Talk to a South Carolina workers\' comp attorney after a denial</h2>
<p>If your claim has been denied, the clock is already running. A Roden Law attorney can review your denial letter, identify which defense the insurer is using, and build the case to reverse it &mdash; while protecting every appeal deadline. The review is free, and there are no fees unless we win.</p>
<p>For more, see <a href="/resources/how-much-does-south-carolina-workers-comp-pay/">how much South Carolina workers&rsquo; comp pays</a>, our <a href="/resources/south-carolina-workers-comp-body-part-values/">body part value chart</a>, and <a href="/resources/south-carolina-workers-comp-impairment-rating-mmi/">how MMI and impairment ratings work</a>. You can also learn about your rights on our <a href="/south-carolina-workers-compensation-lawyer/">South Carolina workers&rsquo; compensation</a> page and our <a href="/practice-areas/workers-compensation-lawyers/">workers&rsquo; compensation practice</a> page.</p>';

$faqs = array(
    array(
        'question' => 'What should I do if my South Carolina workers\' comp claim is denied?',
        'answer'   => 'A denial is not the end of your case. You request a hearing before a single Commissioner of the Workers\' Compensation Commission using Form 50 (Form 52 for a death claim). If you lose, you can appeal up a defined ladder with short deadlines. Because the first appeal deadline is only 14 days, you should act quickly and consider getting an attorney involved.',
    ),
    array(
        'question' => 'How long do I have to appeal a denied workers\' comp claim in South Carolina?',
        'answer'   => 'You have 14 days to appeal a single Commissioner\'s order to the Appellate Panel (full Commission) under § 42-17-50, using Form 30 with a $150 fee. From there you have 30 days to appeal to the South Carolina Court of Appeals under § 42-17-60. The final step, the South Carolina Supreme Court, is discretionary review.',
    ),
    array(
        'question' => 'Why do workers\' comp claims get denied in South Carolina?',
        'answer'   => 'Common reasons include disputes over whether the injury is work-related, claims that you missed the 90-day notice deadline or the 2-year filing deadline, pre-existing-condition arguments that blame a prior injury, and independent-contractor classification arguments that you were not a covered employee. Many of these defenses can be overcome with the right evidence.',
    ),
    array(
        'question' => 'What forms do I need to appeal a denial in South Carolina?',
        'answer'   => 'You start by requesting a hearing with Form 50 (Form 52 for a death claim) before a single Commissioner. To appeal that Commissioner\'s order to the Appellate Panel, you file Form 30, the Request for Commission Review, within 14 days, along with a $150 fee.',
    ),
    array(
        'question' => 'Do I need a lawyer to appeal a denied workers\' comp claim?',
        'answer'   => 'It is strongly advisable. Once a claim is denied, the process is adversarial and deadline-driven. An attorney can gather the medical and employment evidence to overcome the denial, file the right forms on time, and present your case at the hearing and on appeal. South Carolina workers\' comp attorneys work on contingency, with fees subject to Commission approval.',
    ),
    array(
        'question' => 'Can I appeal a South Carolina workers\' comp denial to court?',
        'answer'   => 'Yes. After the Appellate Panel (full Commission) rules, you can appeal to the South Carolina Court of Appeals within 30 days under § 42-17-60 — a direct route available for injuries on or after July 1, 2007. After that, you may seek discretionary review by the South Carolina Supreme Court.',
    ),
);

$see_also = array(
    array(
        'url'  => '/resources/how-much-does-south-carolina-workers-comp-pay/',
        'text' => 'How Much Does South Carolina Workers\' Comp Pay?',
    ),
    array(
        'url'  => '/resources/south-carolina-workers-comp-body-part-values/',
        'text' => 'South Carolina Workers\' Comp Body Part Value Chart',
    ),
    array(
        'url'  => '/resources/south-carolina-workers-comp-impairment-rating-mmi/',
        'text' => 'MMI and Impairment Ratings in SC Workers\' Comp',
    ),
    array(
        'url'  => '/south-carolina-workers-compensation-lawyer/',
        'text' => 'South Carolina Workers\' Compensation Lawyer',
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
