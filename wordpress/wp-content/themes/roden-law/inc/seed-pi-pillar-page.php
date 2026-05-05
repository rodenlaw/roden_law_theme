<?php
/**
 * Seeder: Personal Injury Lawyers — master pillar page
 *
 * Creates /practice-areas/personal-injury-lawyers/ — the umbrella pillar
 * sitting above the 22 PA-specific pillars. Tracked as F-NEW-1c in the
 * 2026-05-05 prod landing-page audit memory.
 *
 * Run on prod via:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-pi-pillar-page.php
 *
 * Idempotent — exits early if the slug already exists.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$pa_post_type = post_type_exists( 'practice_area' ) ? 'practice_area' : 'practice-area';
$slug         = 'personal-injury-lawyers';

$existing = get_posts( array(
    'post_type'   => $pa_post_type,
    'name'        => $slug,
    'post_parent' => 0,
    'post_status' => array( 'publish', 'draft', 'pending', 'private', 'trash' ),
    'numberposts' => 1,
) );
if ( ! empty( $existing ) ) {
    if ( defined( 'WP_CLI' ) && WP_CLI ) {
        WP_CLI::warning( "PI pillar already exists (ID {$existing[0]->ID}, status {$existing[0]->post_status}). Nothing to do." );
    }
    return;
}

$eric_post = get_page_by_path( 'eric-roden', OBJECT, 'attorney' );
$author_id = $eric_post ? $eric_post->ID : 0;

$hero_intro = 'Personal injury law in Georgia and South Carolina exists to make injured victims whole when another party\'s negligence causes them harm. Roden Law has recovered more than $250 million for personal injury clients across both states, with a 4.9-star average client rating. We work on contingency — no fee unless we win.';

$why_hire  = '';
$why_hire .= '<p>A "personal injury" claim is any civil action seeking compensation for bodily, emotional, or financial harm caused by another party\'s negligence, recklessness, or intentional act. Personal injury is the broadest practice area in civil law — it covers everything from a rear-end collision to a defective medical device to a fatal commercial-trucking crash.</p>';
$why_hire .= '<p>Both Georgia and South Carolina recognize a victim\'s right to recover both economic damages (medical bills, lost wages, future care) and non-economic damages (pain, suffering, loss of enjoyment of life). Neither state caps compensatory damages in ordinary personal injury cases. The applicable rules — fault thresholds, filing deadlines, and the procedural hurdles built into specific case types — differ between the two states and within case types, which is why representation matters.</p>';
$why_hire .= '<p>Insurance carriers staff their claims departments with adjusters and defense counsel whose job is to minimize what they pay. An unrepresented claimant routinely settles for a fraction of what the case is worth. We level the playing field, gather the evidence (police reports, scene photos, surveillance footage, medical records, expert opinions), and negotiate from a credible trial-ready posture.</p>';

// Body content — built in pieces with concatenation (heredoc unreliable on WPE per memory).
$content  = '';
$content .= '<h2>What Counts as a Personal Injury Case in Georgia and South Carolina?</h2>';
$content .= '<p>Personal injury is an umbrella term covering any civil claim where a plaintiff seeks compensation for harm caused by another party\'s negligence, recklessness, intentional misconduct, or strict liability for a defective product. The vast majority of personal injury claims arise from one of the following:</p>';
$content .= '<ul>';
$content .= '<li><a href="/practice-areas/car-accident-lawyers/">Car accidents</a> — the single most common source of PI claims in both states</li>';
$content .= '<li><a href="/practice-areas/truck-accident-lawyers/">Commercial truck accidents</a> governed by federal motor-carrier regulations</li>';
$content .= '<li><a href="/practice-areas/motorcycle-accident-lawyers/">Motorcycle</a>, <a href="/practice-areas/bicycle-accident-lawyers/">bicycle</a>, <a href="/practice-areas/e-bike-accident-lawyers/">e-bike</a>, <a href="/practice-areas/electric-scooter-accident-lawyers/">electric scooter</a>, and <a href="/practice-areas/pedestrian-accident-lawyers/">pedestrian</a> crashes</li>';
$content .= '<li><a href="/practice-areas/slip-and-fall-lawyers/">Slip-and-fall</a> and <a href="/practice-areas/premises-liability-lawyers/">premises liability</a> claims against property owners</li>';
$content .= '<li><a href="/practice-areas/medical-malpractice-lawyers/">Medical malpractice</a> for departures from the standard of care</li>';
$content .= '<li><a href="/practice-areas/nursing-home-abuse-lawyers/">Nursing home abuse and neglect</a></li>';
$content .= '<li><a href="/practice-areas/dog-bite-lawyers/">Dog bites and animal attacks</a></li>';
$content .= '<li><a href="/practice-areas/product-liability-lawyers/">Defective product</a> and pharmaceutical claims</li>';
$content .= '<li><a href="/practice-areas/brain-injury-lawyers/">Traumatic brain injuries</a>, <a href="/practice-areas/spinal-cord-injury-lawyers/">spinal cord injuries</a>, and <a href="/practice-areas/burn-injury-lawyers/">burn injuries</a> from any cause</li>';
$content .= '<li><a href="/practice-areas/maritime-injury-lawyers/">Maritime and offshore injuries</a> under the Jones Act and general maritime law</li>';
$content .= '<li><a href="/practice-areas/boating-accident-lawyers/">Boating</a>, <a href="/practice-areas/atv-side-by-side-accident-lawyers/">ATV/UTV</a>, and <a href="/practice-areas/golf-cart-accident-lawyers/">golf cart</a> recreational-vehicle accidents</li>';
$content .= '<li><a href="/practice-areas/construction-accident-lawyers/">Construction-site accidents</a> and <a href="/practice-areas/workers-compensation-lawyers/">workers\' compensation</a> claims</li>';
$content .= '<li><a href="/practice-areas/wrongful-death-lawyers/">Wrongful death</a> claims when negligence kills a loved one</li>';
$content .= '</ul>';

$content .= '<h2 id="negligence-framework">The Four Elements of Negligence</h2>';
$content .= '<p>To recover in any personal injury case in Georgia or South Carolina, a plaintiff must prove four elements by a preponderance of the evidence:</p>';
$content .= '<ol>';
$content .= '<li><strong>Duty.</strong> The defendant owed the plaintiff a legal duty of care — for example, a driver\'s duty to operate a vehicle safely, a property owner\'s duty to keep premises reasonably safe for invitees, or a doctor\'s duty to meet the professional standard of care.</li>';
$content .= '<li><strong>Breach.</strong> The defendant failed to meet that duty by acting (or failing to act) as a reasonably prudent person would have under the same circumstances.</li>';
$content .= '<li><strong>Causation.</strong> The breach was both the actual ("but-for") cause and the proximate cause of the plaintiff\'s injuries.</li>';
$content .= '<li><strong>Damages.</strong> The plaintiff suffered actual, compensable harm.</li>';
$content .= '</ol>';
$content .= '<p>Some claim types replace or supplement this framework — strict products liability, dog-bite statutes, premises-liability invitee/licensee distinctions, and medical-malpractice expert-affidavit requirements all operate under specialized rules — but the underlying logic of duty/breach/cause/harm runs through every personal injury case.</p>';

$content .= '<h2 id="damages">Types of Compensation Available</h2>';
$content .= '<p>Both Georgia and South Carolina permit recovery of three categories of damages in personal injury cases:</p>';
$content .= '<ul>';
$content .= '<li><strong>Economic damages</strong> (uncapped in both states): past and future medical expenses, lost wages, loss of earning capacity, property damage, rehabilitation costs, assistive equipment, and long-term care.</li>';
$content .= '<li><strong>Non-economic damages</strong> (uncapped in ordinary PI cases in both states): pain and suffering, mental and emotional distress, disability, disfigurement, loss of enjoyment of life, and loss of consortium. South Carolina caps non-economic damages at $350,000 per defendant / $1.05M aggregate <em>only</em> in medical malpractice cases (S.C. Code § 15-32-220), adjusted annually for inflation. Georgia\'s attempt to cap medical-malpractice non-economic damages was struck down as unconstitutional in <em>Atlanta Oculoplastic Surgery, P.C. v. Nestlehutt</em>, 286 Ga. 731 (2010).</li>';
$content .= '<li><strong>Punitive damages</strong> for willful misconduct, gross negligence, or conduct showing entire want of care. Georgia caps punitives at $250,000 in most cases (O.C.G.A. § 51-12-5.1), with significant exceptions: no cap for product liability, intentional torts, or conduct involving alcohol/drug intoxication. South Carolina caps punitives at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530), with a higher tier when the conduct caused the death of the victim.</li>';
$content .= '</ul>';

$content .= '<h2 id="comparative-fault">Modified Comparative Fault — What If You\'re Partially At Fault?</h2>';
$content .= '<p>Both states use a <strong>modified comparative fault</strong> system, but with different thresholds:</p>';
$content .= '<ul>';
$content .= '<li><strong>Georgia (O.C.G.A. § 51-12-33):</strong> You can recover if you are <strong>less than 50%</strong> at fault. Your award is reduced by your percentage of fault. At 50% or higher, recovery is barred entirely.</li>';
$content .= '<li><strong>South Carolina (<em>Nelson v. Concrete Supply Co.</em>, 303 S.C. 243 (1991)):</strong> You can recover if you are <strong>50% or less</strong> at fault — a one-percentage-point higher threshold than Georgia. Your award is reduced by your percentage of fault. At 51% or higher, recovery is barred.</li>';
$content .= '</ul>';
$content .= '<p>Insurance carriers in both states routinely contest fault percentages because every percentage point shifted onto the plaintiff reduces what they pay. Aggressive fault investigation — scene reconstruction, witness interviews, expert testimony — is one of the highest-leverage activities in any PI case.</p>';

$content .= '<h2 id="statute-of-limitations">Statute of Limitations: 2 Years (GA) vs. 3 Years (SC)</h2>';
$content .= '<p>The statute of limitations is the absolute deadline for filing suit. Missing it forfeits the claim regardless of merit:</p>';
$content .= '<ul>';
$content .= '<li><strong>Georgia: 2 years</strong> from the date of injury for most personal injury claims (O.C.G.A. § 9-3-33). Wrongful death also runs 2 years from the date of death (O.C.G.A. § 9-3-33). Medical malpractice runs 2 years with a 5-year statute of repose (O.C.G.A. § 9-3-71).</li>';
$content .= '<li><strong>South Carolina: 3 years</strong> from the date of injury for most personal injury claims (S.C. Code § 15-3-530). Medical malpractice runs 3 years from discovery with a 6-year statute of repose (S.C. Code § 15-3-545). Claims against governmental entities under the South Carolina Tort Claims Act have shorter notice and filing deadlines (S.C. Code § 15-78-110).</li>';
$content .= '</ul>';
$content .= '<p>Several special cases trigger shorter deadlines: claims against city, county, or state government (notice of claim required within months, not years); claims involving minors (tolling rules apply); and claims under the Federal Tort Claims Act. Do not assume the standard 2 or 3-year window applies until you have spoken with an attorney.</p>';

$content .= '<h2 id="when-to-call">When Should You Call a Personal Injury Lawyer?</h2>';
$content .= '<p>Call as soon as you can after the incident — ideally before giving any recorded statement to an insurance carrier. Critical evidence has a short shelf life: surveillance footage gets overwritten in days or weeks, vehicle event-data recorders get reset, witness memories fade, scene conditions change. Early representation also prevents recorded-statement and "quick settlement" tactics that insurers use to lock in lowball outcomes before the full extent of injuries is known.</p>';
$content .= '<p>Roden Law offers free, no-obligation consultations 24/7. There is no charge to evaluate your case, and no obligation if you choose not to retain us.</p>';

$content .= '<h2 id="fees">Attorney Fees: Contingency, No Fee Unless We Win</h2>';
$content .= '<p>All Roden Law personal injury cases are handled on a <strong>contingency fee</strong> basis. You pay nothing upfront. Our fee is a percentage of the recovery we obtain — settlement or verdict — and there is no fee at all if we don\'t recover compensation for you. Case expenses (filing fees, deposition costs, expert witness fees) are advanced by the firm and reimbursed from the recovery, again only if we win. This structure aligns our incentives directly with yours: we earn only when you do.</p>';

$content .= '<h2>Personal Injury Offices in Georgia and South Carolina</h2>';
$content .= '<p>Roden Law maintains personal injury offices across both states. Each office is staffed by attorneys licensed in the relevant jurisdiction and intimately familiar with local courts and insurance practice:</p>';
$content .= '<ul>';
$content .= '<li><a href="/locations/georgia/savannah/">Savannah, GA</a> &middot; <a href="/locations/georgia/darien/">Darien, GA</a></li>';
$content .= '<li><a href="/locations/south-carolina/charleston/">Charleston, SC</a> &middot; <a href="/locations/south-carolina/north-charleston/">North Charleston, SC</a> &middot; <a href="/locations/south-carolina/columbia/">Columbia, SC</a> &middot; <a href="/locations/south-carolina/myrtle-beach/">Myrtle Beach, SC</a></li>';
$content .= '</ul>';

// FAQ array — 8 location-agnostic Q&As about PI law in GA + SC.
$faqs = array(
    array( 'question' => 'What is a personal injury case?', 'answer' => 'A personal injury case is any civil claim seeking compensation for bodily, emotional, or financial harm caused by another party\'s negligence, recklessness, intentional misconduct, or strict liability. The most common categories are motor vehicle crashes, premises liability (slip-and-fall), medical malpractice, defective products, and wrongful death. The plaintiff bears the burden of proving the defendant caused the harm and that compensatory damages are warranted.' ),
    array( 'question' => 'How long do I have to file a personal injury claim in Georgia or South Carolina?', 'answer' => 'Georgia\'s statute of limitations is 2 years from the date of injury for most personal injury claims (O.C.G.A. § 9-3-33). South Carolina\'s is 3 years (S.C. Code § 15-3-530). Medical malpractice cases follow related but distinct rules with statutes of repose (5 years in GA under O.C.G.A. § 9-3-71; 6 years in SC under S.C. Code § 15-3-545). Claims against government entities require shorter pre-suit notice. Missing any applicable deadline permanently bars the claim.' ),
    array( 'question' => 'What if I\'m partially at fault for what happened?', 'answer' => 'Both states use modified comparative fault. In Georgia, you can recover if you are less than 50% at fault, with your award reduced by your fault percentage (O.C.G.A. § 51-12-33). In South Carolina, you can recover if you are 50% or less at fault, again with a proportional reduction. For example, on a $100,000 claim with 30% plaintiff fault, recovery is $70,000. At 50% (GA) or 51% (SC) plaintiff fault, recovery is barred entirely.' ),
    array( 'question' => 'How much is my personal injury case worth?', 'answer' => 'Case value depends on injury severity, total medical expenses (past and future), lost wages and lost earning capacity, property damage, the impact on quality of life, available insurance coverage, and the strength of liability evidence. Roden Law has recovered settlements and verdicts ranging from tens of thousands to multi-million-dollar outcomes. We provide free case evaluations to assess the realistic value range for your specific claim.' ),
    array( 'question' => 'How much does a personal injury lawyer cost?', 'answer' => 'Roden Law works on a contingency fee basis — you pay nothing upfront and no attorney fee unless we win your case. Our fee is a percentage of the recovery we obtain through settlement or verdict. Case expenses (filing fees, deposition costs, expert witness fees) are advanced by the firm and reimbursed from the recovery, also contingent on winning. There is no financial risk to you in retaining counsel.' ),
    array( 'question' => 'What kinds of damages can I recover in a personal injury case?', 'answer' => 'You can recover three categories of damages: (1) economic damages — past and future medical bills, lost income, lost earning capacity, and property damage (uncapped in both states); (2) non-economic damages — pain and suffering, mental anguish, disability, disfigurement, and loss of enjoyment of life (uncapped in ordinary PI cases in both states); and (3) punitive damages for grossly negligent or intentional conduct (capped under O.C.G.A. § 51-12-5.1 in GA and S.C. Code § 15-32-530 in SC, with significant exceptions).' ),
    array( 'question' => 'Should I talk to the other side\'s insurance company?', 'answer' => 'No — not without an attorney. Insurance adjusters are trained to elicit statements that minimize or defeat claims. They will request a recorded statement, ask leading questions, and use anything you say against you later. Decline politely, refer them to your attorney, and let counsel handle all communications. The carrier is not your advocate; it has a financial interest opposite to yours.' ),
    array( 'question' => 'What should I do immediately after I\'ve been injured?', 'answer' => 'Get medical attention even if injuries seem minor (some injuries — concussions, soft-tissue trauma, internal bleeding — are not immediately apparent). Document the scene with photos and video. Get contact information from any witnesses. File a police or incident report. Do not admit fault or apologize. Preserve any physical evidence (damaged equipment, clothing, footwear). Contact a personal injury attorney before giving any statement to an insurance carrier or signing any release.' ),
);

// Common causes — broad PI causation factors across all sub-PA categories.
$common_causes = array(
    'Distracted, drunk, or reckless driving',
    'Commercial vehicle and trucking-industry safety violations',
    'Failure to keep premises in reasonably safe condition',
    'Defective products and pharmaceuticals',
    'Medical errors and departures from standard of care',
    'Workplace and construction-site safety violations',
    'Inadequate security on commercial premises',
    'Aggressive or inattentive operation of recreational vehicles',
    'Animal owner failure to restrain or warn',
    'Manufacturer defects in lithium-ion batteries and consumer electronics',
    'Government and municipal failure to maintain public infrastructure',
    'Maritime and offshore-industry safety failures',
);

// Common injuries — full spectrum of PI injuries.
$common_injuries = array(
    array( 'name' => 'Traumatic Brain Injuries (TBI)',     'description' => 'Concussions, contusions, and severe TBI from impacts, falls, or penetrating trauma. Cognitive impairment, memory loss, personality changes, and seizure disorders may persist for years or be permanent, requiring extensive rehabilitation and lifelong care.' ),
    array( 'name' => 'Spinal Cord Injuries',                'description' => 'Vertebral fractures, herniated discs, and spinal cord damage that can cause partial or complete paralysis, loss of sensation, and lifelong dependence on assistive devices and around-the-clock care.' ),
    array( 'name' => 'Broken Bones and Fractures',          'description' => 'Fractures of arms, legs, ribs, pelvis, and the spine — often requiring surgery, hardware implantation, and prolonged rehabilitation that interferes with work and daily life.' ),
    array( 'name' => 'Internal Organ Damage',                'description' => 'Blunt force or penetrating trauma causing internal bleeding, ruptured spleen, liver lacerations, and kidney injury. Internal injuries may not be immediately apparent and require emergency surgical intervention.' ),
    array( 'name' => 'Burn Injuries and Disfigurement',     'description' => 'Thermal, chemical, and electrical burns — from vehicle fires, defective batteries, and industrial accidents — frequently require skin grafts, reconstructive surgery, and leave permanent scarring and disability.' ),
    array( 'name' => 'Soft-Tissue Injuries',                 'description' => 'Sprains, strains, contusions, and herniated discs affecting muscles, tendons, and ligaments. Chronic pain and prolonged recovery often interfere with work, sleep, and daily activities for months or years.' ),
    array( 'name' => 'Wrongful Death',                       'description' => 'When negligence causes a fatality, surviving family members can pursue both wrongful-death and survival claims for the loss of the decedent\'s life, pre-death pain and suffering, lost financial support, and loss of companionship.' ),
    array( 'name' => 'Post-Traumatic Stress Disorder (PTSD)','description' => 'The psychological aftermath of a serious injury or accident — anxiety, flashbacks, depression, sleep disturbance — is fully compensable as non-economic damages in both Georgia and South Carolina.' ),
);

// Pillar token-aware intros — used by intersection template if PI ever gets intersection children.
$negligence_intro  = 'Personal injury law in {state_full} hinges on the four elements of common-law negligence: duty, breach, causation, and damages. Specific claim types layer on additional rules — products liability adds strict-liability theories, premises liability turns on the visitor\'s status as invitee/licensee/trespasser, medical malpractice requires a contemporaneous expert affidavit. {state_full}\'s comparative-fault rule bars recovery if you are {comp_fault_threshold} or more at fault, so insurers in {market_name} routinely contest fault percentages. You have **{sol_years} years from the date of injury** to file ({sol_cite}) — missing the deadline forfeits the claim.';
$compensation_intro = 'Both {state_full} and neighboring states allow recovery of economic damages (medical bills, lost wages, lost earning capacity), non-economic damages (pain and suffering, disability, loss of enjoyment of life), and — for grossly negligent or intentional conduct — punitive damages. {state_full} does not cap non-economic damages in ordinary personal injury cases, so the recovery ceiling is set by the evidence and the comparative-fault bar, not by statute. Punitive damages in {state_full} are capped by statute with significant exceptions for product liability and conduct involving intoxication.';

// Insert post.
$post_id = wp_insert_post( array(
    'post_type'    => $pa_post_type,
    'post_title'   => 'Personal Injury Lawyers',
    'post_name'    => $slug,
    'post_content' => $content,
    'post_excerpt' => 'Personal injury law in Georgia and South Carolina covers car accidents, truck wrecks, slip-and-falls, medical malpractice, defective products, wrongful death, and more. Roden Law has recovered $250M+ for personal injury clients across both states.',
    'post_status'  => 'publish',
    'post_parent'  => 0,
    'post_author'  => 1,
), true );
if ( is_wp_error( $post_id ) ) {
    if ( defined( 'WP_CLI' ) && WP_CLI ) WP_CLI::error( 'wp_insert_post failed: ' . $post_id->get_error_message() );
    return;
}

update_post_meta( $post_id, '_roden_jurisdiction',                'both' );
update_post_meta( $post_id, '_roden_sol_ga',                       'O.C.G.A. § 9-3-33' );
update_post_meta( $post_id, '_roden_sol_sc',                       'S.C. Code § 15-3-530' );
update_post_meta( $post_id, '_roden_hero_intro',                   $hero_intro );
update_post_meta( $post_id, '_roden_why_hire',                     $why_hire );
update_post_meta( $post_id, '_roden_faqs',                         $faqs );
update_post_meta( $post_id, '_roden_common_causes',                $common_causes );
update_post_meta( $post_id, '_roden_common_injuries',              $common_injuries );
update_post_meta( $post_id, '_roden_pillar_negligence_intro',      $negligence_intro );
update_post_meta( $post_id, '_roden_pillar_compensation_intro',    $compensation_intro );
if ( $author_id ) update_post_meta( $post_id, '_roden_author_attorney', $author_id );

// Intentionally skip _roden_sub_types meta and practice_category taxonomy — the
// 22 sub-PA links live inline in $content as anchor tags, and leaving
// practice_category empty lets template-practice-area.php fall through to its
// PA→blog-category map (where 'personal-injury-lawyers' => 'personal-injury'
// pulls the 92 posts in the Personal Injury blog category).

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::success( "Created PI pillar (ID {$post_id}) at /practice-areas/{$slug}/" );
    WP_CLI::log( 'Next: wp cache flush && wp page-cache flush' );
}
