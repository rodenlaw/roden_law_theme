<?php
/**
 * Seeder: 8 Maritime Injury Sub-Type Pages
 *
 * Creates 8 child posts under the maritime-injury-lawyers pillar, each
 * covering a specific type of maritime injury claim.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-maritime-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: maritime-injury-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'maritime-injury-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'maritime-injury-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "maritime-injury-lawyers" not found. Create it first.' );
    return;
}

$pillar_id   = $pillar->ID;
$pillar_type = $pillar->post_type;

WP_CLI::log( "Parent pillar: \"{$pillar->post_title}\" (ID {$pillar_id}, type {$pillar_type})" );

/* ------------------------------------------------------------------
   Look up Eric Roden's attorney post ID for author attribution
   ------------------------------------------------------------------ */

$eric = get_page_by_path( 'eric-roden', OBJECT, 'attorney' );
$author_attorney_id = $eric ? $eric->ID : 0;
if ( $author_attorney_id ) {
    WP_CLI::log( "Author attorney: Eric Roden (ID {$author_attorney_id})" );
} else {
    WP_CLI::warning( 'Attorney "eric-roden" not found — _roden_author_attorney will be empty.' );
}

/* ------------------------------------------------------------------
   Ensure practice_category term exists
   ------------------------------------------------------------------ */

$cat_term = term_exists( 'maritime-injuries', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Maritime Injuries', 'practice_category', array( 'slug' => 'maritime-injuries' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Jones Act Seaman Claim
       ============================================================ */
    array(
        'title'   => 'Jones Act Seaman Claim Lawyers',
        'slug'    => 'jones-act-seaman-claim',
        'excerpt' => 'Injured on the job as a seaman? The Jones Act gives maritime workers powerful rights not available under standard workers\' compensation. Our maritime lawyers fight for full Jones Act compensation.',
        'content' => <<<'HTML'
<h2>Jones Act Seaman Claim Lawyers in Georgia &amp; South Carolina</h2>
<p>The Jones Act (<a href="https://www.law.cornell.edu/uscode/text/46/30104" target="_blank" rel="noopener">46 U.S.C. § 30104</a>) is the primary federal statute protecting seamen injured in the course of their employment. Unlike standard <a href="/workers-compensation-lawyers/">workers' compensation</a>, which limits benefits and bars lawsuits against employers, the Jones Act allows injured seamen to sue their employers for negligence and recover full compensatory damages — including pain and suffering, which workers' comp does not provide. This makes the Jones Act one of the most powerful protections available to injured workers in any industry.</p>
<p>At Roden Law, our Jones Act lawyers represent injured seamen across Georgia and South Carolina's coastal waters, ports, and offshore operations. We understand the unique requirements of Jones Act claims and fight to maximize the recovery that maritime workers and their families deserve.</p>

<h2>Who Qualifies as a Jones Act Seaman?</h2>
<p>Not every worker on the water qualifies as a seaman under the Jones Act. To establish seaman status, two requirements must be met:</p>
<ul>
<li><strong>Contribution to vessel function:</strong> The worker must contribute to the function of a vessel or the accomplishment of its mission</li>
<li><strong>Substantial connection to a vessel:</strong> The worker must have a connection to a vessel (or fleet of vessels) in navigation that is substantial in terms of both duration and nature — generally spending at least 30% of their work time aboard a vessel in navigation</li>
</ul>
<p>Workers who may qualify as Jones Act seamen include deckhands, captains and pilots, engineers and mechanics aboard vessels, tugboat crew members, offshore platform workers (in certain circumstances), <a href="/maritime-injury-lawyers/commercial-fishing-injury/">commercial fishing crew</a>, and crew members on <a href="/maritime-injury-lawyers/cruise-ship-injury/">cruise ships</a>.</p>

<h2>Jones Act Negligence Standard</h2>
<p>The Jones Act uses a negligence standard that is significantly more favorable to injured seamen than ordinary negligence. Under the Jones Act:</p>
<ul>
<li><strong>"Featherweight" burden of proof:</strong> The seaman need only show that the employer's negligence played any part, even the slightest, in causing the injury — a much lower bar than the preponderance-of-the-evidence standard in typical personal injury cases</li>
<li><strong>Employer negligence includes:</strong> Failing to provide a reasonably safe workplace, failing to maintain safe equipment, understaffing the vessel, inadequate training, requiring work in dangerous conditions, and failure to provide adequate medical care after an injury</li>
<li><strong>No comparative fault bar:</strong> Unlike Georgia and South Carolina state law, a Jones Act seaman can recover even if partially at fault — their damages are reduced by their percentage of fault, but recovery is never barred entirely</li>
</ul>

<h2>Jones Act Damages</h2>
<p>A successful Jones Act claim allows recovery of comprehensive damages not available under workers' compensation:</p>
<ul>
<li><strong>Past and future medical expenses:</strong> All reasonable and necessary medical treatment</li>
<li><strong>Past and future lost wages:</strong> Both wages already lost and future earning capacity</li>
<li><strong>Pain and suffering:</strong> Physical pain, mental anguish, and emotional distress — a major category of damages unavailable under workers' comp</li>
<li><strong><a href="/maritime-injury-lawyers/maintenance-and-cure/">Maintenance and cure</a>:</strong> In addition to Jones Act damages, injured seamen are entitled to maintenance (daily living allowance) and cure (medical treatment) until reaching maximum medical improvement</li>
<li><strong><a href="/maritime-injury-lawyers/unseaworthiness-claim/">Unseaworthiness</a>:</strong> A separate claim that can be brought alongside the Jones Act if the vessel was not reasonably fit for its intended use</li>
</ul>

<h2>Jones Act vs. Workers' Compensation</h2>
<p>The Jones Act provides significantly greater protection than state workers' compensation systems:</p>
<ul>
<li><strong>Full damages:</strong> Jones Act allows pain and suffering; workers' comp does not</li>
<li><strong>Jury trial:</strong> Jones Act claims can be tried before a jury; workers' comp is an administrative proceeding</li>
<li><strong>No scheduled benefits:</strong> Workers' comp limits payouts by body part or disability rating; Jones Act damages are based on full actual losses</li>
<li><strong>Employer accountability:</strong> Jones Act holds employers directly accountable for negligence; workers' comp provides immunity from lawsuits</li>
</ul>

<h2>Filing a Jones Act Claim</h2>
<p>Jones Act claims must be filed within <strong>3 years</strong> of the date of injury under the general maritime statute of limitations. Claims can be filed in either federal or state court. However, employers and their insurers frequently pressure injured seamen to sign settlement agreements or return to work prematurely — contact a maritime attorney before making any statements or signing any documents.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the Jones Act?',
                'answer'   => 'The Jones Act (46 U.S.C. § 30104) is a federal law that allows seamen injured in the course of their employment to sue their employers for negligence. Unlike workers\' compensation, the Jones Act allows recovery of full compensatory damages including pain and suffering, and permits jury trials.',
            ),
            array(
                'question' => 'Who qualifies as a seaman under the Jones Act?',
                'answer'   => 'To qualify, a worker must (1) contribute to the function of a vessel or the accomplishment of its mission, and (2) have a substantial connection to a vessel in navigation — generally spending at least 30% of their work time aboard a vessel. Deckhands, captains, engineers, tugboat crew, and commercial fishing crew commonly qualify.',
            ),
            array(
                'question' => 'How is a Jones Act claim different from workers\' compensation?',
                'answer'   => 'The Jones Act allows full compensatory damages including pain and suffering (workers\' comp does not), permits jury trials (workers\' comp is administrative), and bases damages on actual losses rather than scheduled benefit limits. Jones Act seamen can also claim maintenance and cure and unseaworthiness.',
            ),
            array(
                'question' => 'What is the burden of proof in a Jones Act case?',
                'answer'   => 'The Jones Act uses a "featherweight" causation standard — the seaman need only show that the employer\'s negligence played any part, even the slightest, in causing the injury. This is a much lower bar than the preponderance-of-the-evidence standard in typical negligence cases.',
            ),
            array(
                'question' => 'How long do I have to file a Jones Act claim?',
                'answer'   => 'Jones Act claims must be filed within 3 years of the date of injury under the general maritime statute of limitations. However, employers often pressure injured seamen to settle quickly or sign documents that limit their rights — consult a maritime attorney before signing anything.',
            ),
        ),
    ),

    /* ============================================================
       2. Longshore and Harbor Worker
       ============================================================ */
    array(
        'title'   => 'Longshore and Harbor Worker Lawyers',
        'slug'    => 'longshore-harbor-worker',
        'excerpt' => 'Injured as a longshore or harbor worker? The LHWCA provides federal compensation benefits, but you may also have third-party negligence claims. Our maritime lawyers maximize your total recovery.',
        'content' => <<<'HTML'
<h2>Longshore and Harbor Worker Lawyers in Georgia &amp; South Carolina</h2>
<p>The Longshore and Harbor Workers' Compensation Act (<a href="https://www.law.cornell.edu/uscode/text/33/chapter-18" target="_blank" rel="noopener">LHWCA, 33 U.S.C. § 901 et seq.</a>) provides federal workers' compensation benefits to maritime workers who are injured on navigable waters or on adjoining piers, docks, terminals, and other waterfront areas — but who do not qualify as "seamen" under the Jones Act. The LHWCA covers a substantial workforce including longshoremen, dock workers, ship repairers, harbor construction workers, marine terminal operators, and other waterfront employees.</p>
<p>At Roden Law, our longshore and harbor worker lawyers serve the busy ports and waterfront industries of Savannah, Charleston, and the Georgia and South Carolina coastline. We help injured workers navigate the federal LHWCA claims process while also pursuing third-party negligence claims that can provide far greater compensation than LHWCA benefits alone.</p>

<h2>Who Is Covered by the LHWCA?</h2>
<p>The LHWCA covers workers who meet both a <strong>situs</strong> (location) and <strong>status</strong> (occupation) test:</p>
<ul>
<li><strong>Situs test:</strong> The injury must occur on navigable waters of the United States or on an adjoining area customarily used by an employer in loading, unloading, repairing, dismantling, or building a vessel — including piers, wharves, dry docks, marine terminals, and areas adjacent to navigable waters</li>
<li><strong>Status test:</strong> The worker must be engaged in maritime employment, including longshoremen who load and unload cargo, ship repairers and shipbuilders, harbor construction workers, marine terminal operators and clerks, and container freight workers on the waterfront</li>
</ul>
<p>Workers who do <em>not</em> qualify under the LHWCA include clerical and office workers, security guards, recreational marina employees, and workers covered by state <a href="/workers-compensation-lawyers/">workers' compensation</a>. Workers who qualify as "seamen" are covered by the <a href="/maritime-injury-lawyers/jones-act-seaman-claim/">Jones Act</a> instead.</p>

<h2>LHWCA Benefits</h2>
<p>The LHWCA provides several categories of benefits:</p>
<ul>
<li><strong>Medical benefits:</strong> All reasonable and necessary medical treatment related to the work injury, with no copays or deductibles — the employer or insurer must pay all medical costs</li>
<li><strong>Temporary total disability (TTD):</strong> Two-thirds of the worker's average weekly wage while unable to work, subject to a maximum weekly rate</li>
<li><strong>Temporary partial disability (TPD):</strong> Two-thirds of the difference between pre-injury and post-injury earning capacity</li>
<li><strong>Permanent partial disability (PPD):</strong> Compensation based on the body part affected and degree of impairment, using a scheduled benefits table</li>
<li><strong>Permanent total disability (PTD):</strong> Two-thirds of average weekly wage for life when the worker is permanently unable to work</li>
<li><strong>Death benefits:</strong> Compensation to surviving dependents, including funeral expenses</li>
</ul>

<h2>Third-Party Claims: Beyond LHWCA Benefits</h2>
<p>While the LHWCA bars direct lawsuits against the employer (similar to state workers' comp), injured longshore and harbor workers can pursue <strong>third-party negligence claims</strong> against parties other than their employer. Common third-party defendants include:</p>
<ul>
<li><strong>Vessel owners:</strong> Under <a href="https://www.law.cornell.edu/uscode/text/33/905" target="_blank" rel="noopener">33 U.S.C. § 905(b)</a>, a longshore worker injured aboard a vessel can sue the vessel owner for negligence — this is one of the most common and valuable third-party claims</li>
<li><strong>Equipment manufacturers:</strong> <a href="/product-liability-lawyers/defective-industrial-equipment/">Defective cranes, forklifts, rigging</a>, and other waterfront equipment — strict liability and negligence claims</li>
<li><strong>General contractors:</strong> On harbor construction projects, the general contractor may be liable for unsafe conditions</li>
<li><strong>Other employers:</strong> When workers from multiple companies share a worksite, one company's negligence may injure another company's employee</li>
</ul>
<p>Third-party claims allow recovery of <strong>full compensatory damages</strong> including pain and suffering — far exceeding the scheduled LHWCA benefits. Our attorneys pursue both LHWCA benefits and third-party claims simultaneously to maximize total recovery.</p>

<h2>LHWCA Claims Process</h2>
<p>LHWCA claims are administered by the <a href="https://www.dol.gov/agencies/owcp/dlhwc" target="_blank" rel="noopener">U.S. Department of Labor, Office of Workers' Compensation Programs (OWCP)</a>. The injured worker must provide written notice of injury to the employer within 30 days and file a formal claim within 1 year of injury (or 2 years from when the worker knew or should have known the injury was related to employment, for occupational diseases). Third-party negligence claims are subject to the applicable statute of limitations — typically 3 years under general maritime law.</p>

<h2>Port Cities We Serve</h2>
<p>Our attorneys serve longshore and harbor workers at the <strong>Port of Savannah</strong> — one of the busiest container ports in the nation — the <strong>Port of Charleston</strong>, and waterfront operations throughout Georgia and South Carolina. We understand the specific hazards of container terminal operations, ship loading and unloading, and harbor construction in these busy port environments.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the LHWCA?',
                'answer'   => 'The Longshore and Harbor Workers\' Compensation Act (33 U.S.C. § 901 et seq.) is a federal law providing workers\' compensation benefits to maritime workers injured on navigable waters or adjoining dock, pier, and terminal areas who do not qualify as seamen under the Jones Act.',
            ),
            array(
                'question' => 'What is the difference between LHWCA coverage and the Jones Act?',
                'answer'   => 'The Jones Act covers "seamen" — workers with a substantial connection to a vessel in navigation. The LHWCA covers maritime workers who work on or near navigable waters but are not seamen — longshoremen, dock workers, ship repairers, and harbor construction workers. The two statutes are mutually exclusive.',
            ),
            array(
                'question' => 'Can I sue my employer under the LHWCA?',
                'answer'   => 'No. Like state workers\' comp, the LHWCA bars lawsuits against your employer. However, you can pursue third-party negligence claims against vessel owners, equipment manufacturers, general contractors, and other parties whose negligence contributed to your injury — and these third-party claims allow full damages including pain and suffering.',
            ),
            array(
                'question' => 'What benefits does the LHWCA provide?',
                'answer'   => 'The LHWCA provides full medical benefits (no copays or deductibles), temporary total and partial disability payments (two-thirds of average weekly wage), permanent partial and total disability benefits, and death benefits for surviving dependents.',
            ),
            array(
                'question' => 'How long do I have to file an LHWCA claim?',
                'answer'   => 'You must give written notice to your employer within 30 days of injury and file a formal claim with the Department of Labor within 1 year. For occupational diseases, the 1-year period runs from when you knew or should have known the condition was work-related. Third-party claims generally have a 3-year statute of limitations.',
            ),
        ),
    ),

    /* ============================================================
       3. Unseaworthiness Claim
       ============================================================ */
    array(
        'title'   => 'Unseaworthiness Claim Lawyers',
        'slug'    => 'unseaworthiness-claim',
        'excerpt' => 'Injured because a vessel was not seaworthy? The doctrine of unseaworthiness imposes strict liability on vessel owners. Our maritime lawyers pursue this powerful claim to maximize your recovery.',
        'content' => <<<'HTML'
<h2>Unseaworthiness Claim Lawyers in Georgia &amp; South Carolina</h2>
<p>The doctrine of unseaworthiness is one of the most powerful legal protections available to maritime workers. Under general maritime law, vessel owners have an absolute, non-delegable duty to provide a vessel that is reasonably fit for its intended purpose. When a vessel or any of its equipment, appurtenances, or crew is not reasonably fit — rendering the vessel "unseaworthy" — and that condition causes injury, the vessel owner is strictly liable regardless of whether the owner was negligent or even knew about the condition.</p>
<p>At Roden Law, our unseaworthiness lawyers represent injured maritime workers throughout the Georgia and South Carolina coastline. We frequently assert unseaworthiness claims alongside <a href="/maritime-injury-lawyers/jones-act-seaman-claim/">Jones Act negligence claims</a> and <a href="/maritime-injury-lawyers/maintenance-and-cure/">maintenance and cure</a> demands to maximize total recovery for our clients.</p>

<h2>What Makes a Vessel Unseaworthy?</h2>
<p>Unseaworthiness encompasses a broad range of conditions — anything that renders the vessel or its equipment not reasonably fit for its intended use:</p>
<ul>
<li><strong>Defective equipment:</strong> Broken or worn-out lines, cables, winches, cranes, hatches, ladders, guardrails, or any other equipment aboard the vessel</li>
<li><strong>Slippery or unsafe deck surfaces:</strong> Oil, grease, fish slime, ice, or other substances creating hazardous walking surfaces</li>
<li><strong>Structural defects:</strong> Hull damage, corroded decking, improperly secured hatches, or unstable bulkheads</li>
<li><strong>Inadequate crew:</strong> An insufficient number of crew members, or crew members who are incompetent or unfit for their duties (including a violent or intoxicated crew member)</li>
<li><strong>Missing safety equipment:</strong> Absence of required safety gear, fire suppression equipment, navigation lights, or personal protective equipment</li>
<li><strong>Improper loading:</strong> Cargo that is improperly stowed, secured, or distributed, causing the vessel to list or capsize</li>
</ul>

<h2>Unseaworthiness vs. Jones Act Negligence</h2>
<p>While both claims can arise from the same incident, they have important differences:</p>
<ul>
<li><strong>Standard of liability:</strong> Unseaworthiness is a <strong>strict liability</strong> claim — no proof of negligence is required, only that the condition existed and caused the injury. The Jones Act requires proof of employer negligence (though with a "featherweight" burden)</li>
<li><strong>Who can bring the claim:</strong> Unseaworthiness claims are available to <a href="/maritime-injury-lawyers/jones-act-seaman-claim/">Jones Act seamen</a> and, in more limited circumstances, to <a href="/maritime-injury-lawyers/longshore-harbor-worker/">longshore workers</a> injured aboard a vessel</li>
<li><strong>Defendant:</strong> Unseaworthiness claims are brought against the vessel owner; Jones Act claims are brought against the employer (often, but not always, the same entity)</li>
<li><strong>Damages:</strong> Both allow recovery of full compensatory damages including pain and suffering, medical expenses, lost wages, and loss of earning capacity</li>
</ul>
<p>Our attorneys evaluate every maritime injury case for both unseaworthiness and Jones Act claims to ensure maximum recovery.</p>

<h2>Proving Unseaworthiness</h2>
<p>To prevail on an unseaworthiness claim, the injured worker must establish:</p>
<ul>
<li><strong>An unseaworthy condition existed:</strong> The vessel, its equipment, appurtenances, or crew was not reasonably fit for its intended purpose</li>
<li><strong>Causation:</strong> The unseaworthy condition was a proximate cause of the injury</li>
<li><strong>The worker was aboard the vessel in the service of the vessel:</strong> The injury occurred while the worker was performing duties aboard the vessel</li>
</ul>
<p>Importantly, the vessel owner's knowledge of the condition is irrelevant — the duty is absolute. Even a temporary condition (such as a momentary oil spill on deck) can render a vessel unseaworthy.</p>

<h2>Common Unseaworthiness Scenarios</h2>
<p>Our maritime lawyers have handled unseaworthiness cases involving defective or worn deck equipment that breaks during use, slippery walkways and stairways lacking non-skid surfaces, malfunctioning cranes and hoisting equipment, corroded or damaged structural components, inadequate lighting in work areas, incompetent or improperly trained crew members, and <a href="/maritime-injury-lawyers/tugboat-barge-accident/">barge</a> and vessel conditions that create unreasonable fall hazards.</p>

<h2>Statute of Limitations</h2>
<p>Unseaworthiness claims must be filed within <strong>3 years</strong> of the date of injury under the general maritime statute of limitations established by the Supreme Court in <em>The Dutra Group v. Batterton</em>. However, prompt investigation is critical to document the unseaworthy condition before it is repaired or the vessel is modified.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is an unseaworthiness claim?',
                'answer'   => 'An unseaworthiness claim holds vessel owners strictly liable when their vessel, its equipment, or its crew is not reasonably fit for its intended purpose and that condition causes injury. Unlike negligence claims, the injured worker does not need to prove the owner was careless — only that the unseaworthy condition existed and caused the injury.',
            ),
            array(
                'question' => 'What is the difference between unseaworthiness and Jones Act negligence?',
                'answer'   => 'Unseaworthiness is a strict liability claim — no proof of fault is needed, only that an unfit condition existed. Jones Act claims require proof of employer negligence (though with a very low burden). Both allow full compensatory damages. They are often brought together to maximize recovery.',
            ),
            array(
                'question' => 'What conditions make a vessel unseaworthy?',
                'answer'   => 'Virtually any condition that renders the vessel unfit for its intended purpose — defective equipment, slippery decks, structural problems, inadequate crew (including incompetent or intoxicated crew members), missing safety equipment, and improper cargo loading. Even temporary conditions can qualify.',
            ),
            array(
                'question' => 'Who can bring an unseaworthiness claim?',
                'answer'   => 'Jones Act seamen can bring unseaworthiness claims against vessel owners. Longshore and harbor workers can also assert unseaworthiness claims when they are injured aboard a vessel, though under 33 U.S.C. § 905(b), their claims against vessel owners are based on negligence rather than strict unseaworthiness.',
            ),
            array(
                'question' => 'How long do I have to file an unseaworthiness claim?',
                'answer'   => 'The general maritime statute of limitations is 3 years from the date of injury. However, prompt action is essential to document the unseaworthy condition before the vessel owner repairs it or modifies the vessel.',
            ),
        ),
    ),

    /* ============================================================
       4. Maintenance and Cure
       ============================================================ */
    array(
        'title'   => 'Maintenance and Cure Lawyers',
        'slug'    => 'maintenance-and-cure',
        'excerpt' => 'Denied maintenance and cure after a maritime injury? Seamen are entitled to daily living expenses and medical care regardless of fault. Our attorneys enforce this absolute right and pursue penalties for bad-faith denial.',
        'content' => <<<'HTML'
<h2>Maintenance and Cure Lawyers in Georgia &amp; South Carolina</h2>
<p>Maintenance and cure is one of the oldest remedies in maritime law — a doctrine dating back centuries that requires vessel owners and employers to provide injured or ill seamen with daily living expenses ("maintenance") and medical treatment ("cure") until the seaman reaches maximum medical improvement (MMI). Unlike <a href="/maritime-injury-lawyers/jones-act-seaman-claim/">Jones Act negligence</a> or <a href="/maritime-injury-lawyers/unseaworthiness-claim/">unseaworthiness claims</a>, maintenance and cure is an absolute right — it does not require proof of employer negligence, and the seaman is entitled to benefits regardless of who was at fault for the injury.</p>
<p>At Roden Law, our maintenance and cure lawyers represent injured seamen throughout Georgia and South Carolina who have been denied or underpaid the maintenance and cure they are legally entitled to. We fight to ensure seamen receive proper medical care and adequate living expenses during their recovery.</p>

<h2>What Is Maintenance?</h2>
<p>Maintenance is a daily stipend intended to cover the seaman's basic living expenses while recovering from an injury or illness. It is the maritime equivalent of what the seaman would have received in room and board while aboard the vessel:</p>
<ul>
<li><strong>Housing costs:</strong> Rent, mortgage payments, or fair rental value of the seaman's home</li>
<li><strong>Food expenses:</strong> Reasonable daily food costs</li>
<li><strong>Utilities:</strong> Electricity, water, gas, and other basic utilities</li>
</ul>
<p>While courts have historically set maintenance at modest daily rates ($25–$50/day was once common), more recent decisions recognize that the rate should reflect the seaman's actual reasonable living expenses. Our attorneys fight for maintenance rates that genuinely cover our clients' costs rather than accepting inadequate flat rates offered by employers.</p>

<h2>What Is Cure?</h2>
<p>Cure is the employer's obligation to provide all reasonable and necessary medical treatment related to the seaman's injury or illness until the seaman reaches maximum medical improvement (MMI):</p>
<ul>
<li><strong>Scope:</strong> All medical treatment, including doctor visits, hospitalization, surgery, physical therapy, prescription medications, diagnostic testing, and medical equipment</li>
<li><strong>Duration:</strong> Until MMI — the point at which further treatment will not improve the seaman's condition. Importantly, MMI does not mean the seaman is fully recovered — only that the condition has stabilized</li>
<li><strong>Choice of physician:</strong> While employers may initially direct medical care, seamen have the right to choose their own treating physicians if the employer's chosen doctors provide inadequate care</li>
<li><strong>No cost to seaman:</strong> The employer pays 100% of medical costs — there are no copays, deductibles, or coverage limits</li>
</ul>

<h2>When Employers Wrongfully Deny Maintenance and Cure</h2>
<p>Despite maintenance and cure being an absolute right, employers and their insurers frequently deny or delay these benefits. Common tactics include:</p>
<ul>
<li><strong>Claiming pre-existing condition:</strong> Arguing the injury or illness existed before employment (however, maintenance and cure is owed even if a pre-existing condition is aggravated by service)</li>
<li><strong>Disputing seaman status:</strong> Claiming the worker does not qualify as a seaman</li>
<li><strong>Premature MMI determinations:</strong> Sending the seaman to employer-selected doctors who declare MMI prematurely, cutting off benefits</li>
<li><strong>Inadequate maintenance rates:</strong> Offering maintenance at rates far below actual living expenses</li>
<li><strong>Surveillance and investigation:</strong> Using private investigators to challenge the validity of the seaman's injuries</li>
</ul>

<h2>Penalties for Bad-Faith Denial</h2>
<p>The Supreme Court's decision in <em>Atlantic Sounding Co. v. Townsend</em> (2009) confirmed that <strong>punitive damages</strong> are available when an employer willfully and arbitrarily denies maintenance and cure. Additionally, the <em>Vaughan v. Atkinson</em> (1962) line of cases established that compensatory damages, including attorney's fees, are recoverable when maintenance and cure is unreasonably denied. This creates a powerful deterrent against employer bad faith.</p>

<h2>Maintenance and Cure Alongside Other Maritime Claims</h2>
<p>Maintenance and cure exists independently of, and in addition to, other maritime remedies. An injured seaman may simultaneously receive maintenance and cure benefits while pursuing a Jones Act negligence claim and an <a href="/maritime-injury-lawyers/unseaworthiness-claim/">unseaworthiness claim</a>. The maintenance and cure obligation begins immediately upon injury and continues regardless of the outcome of any negligence or unseaworthiness litigation.</p>

<h2>Statute of Limitations</h2>
<p>Maintenance and cure claims are subject to the federal maritime doctrine of laches, which functions similarly to a statute of limitations. Courts generally apply a <strong>3-year</strong> limitations period. However, each day that maintenance and cure is wrongfully withheld may constitute a separate breach, extending the period for recovery of unpaid benefits.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is maintenance and cure in maritime law?',
                'answer'   => 'Maintenance is a daily stipend for living expenses (housing, food, utilities) and cure is all reasonable medical treatment — both paid by the employer. It is an absolute right for injured seamen regardless of who was at fault for the injury, continuing until maximum medical improvement (MMI).',
            ),
            array(
                'question' => 'Do I have to prove my employer was at fault to receive maintenance and cure?',
                'answer'   => 'No. Maintenance and cure is an absolute right — it does not depend on fault. If you were injured or became ill while in the service of a vessel, you are entitled to maintenance and cure regardless of whether the employer, you, or no one was at fault.',
            ),
            array(
                'question' => 'What happens if my employer refuses to pay maintenance and cure?',
                'answer'   => 'An employer who willfully and arbitrarily refuses to pay maintenance and cure can be liable for compensatory damages (including attorney\'s fees) and punitive damages. The Supreme Court confirmed the availability of punitive damages in Atlantic Sounding Co. v. Townsend (2009).',
            ),
            array(
                'question' => 'How much maintenance am I entitled to?',
                'answer'   => 'Maintenance should cover your actual reasonable daily living expenses including housing, food, and utilities. While employers often offer low flat rates, our attorneys fight for rates that reflect your real costs. Courts increasingly recognize that maintenance must be meaningful and adequate.',
            ),
            array(
                'question' => 'When does maintenance and cure end?',
                'answer'   => 'Maintenance and cure continues until you reach maximum medical improvement (MMI) — the point at which further treatment will not improve your condition. MMI does not mean you are fully recovered, only that your condition has stabilized. Employers sometimes try to declare MMI prematurely to cut off benefits.',
            ),
        ),
    ),

    /* ============================================================
       5. Offshore and Platform Injury
       ============================================================ */
    array(
        'title'   => 'Offshore and Platform Injury Lawyers',
        'slug'    => 'offshore-platform-injury',
        'excerpt' => 'Injured on an offshore platform or rig? The legal framework for offshore injuries is uniquely complex. Our maritime lawyers determine which laws protect you and pursue maximum compensation.',
        'content' => <<<'HTML'
<h2>Offshore and Platform Injury Lawyers in Georgia &amp; South Carolina</h2>
<p>Offshore oil rigs, gas platforms, wind energy installations, and other fixed and floating structures present some of the most dangerous working conditions in any industry. Workers face risks from heavy equipment operations, extreme weather, helicopter transport, chemical exposure, fires and explosions, falls from height, and the inherent isolation of working miles from shore. When injuries occur offshore, the legal framework for recovery is uniquely complex — potentially involving the <a href="/maritime-injury-lawyers/jones-act-seaman-claim/">Jones Act</a>, the <a href="/maritime-injury-lawyers/longshore-harbor-worker/">LHWCA</a>, the Outer Continental Shelf Lands Act (OCSLA), or state law, depending on the worker's status and the location of the injury.</p>
<p>At Roden Law, our offshore injury lawyers represent workers injured on platforms, rigs, and offshore installations throughout the Southeast Atlantic coast. We navigate the complex jurisdictional issues that determine which laws apply and pursue every available avenue of compensation.</p>

<h2>Which Law Applies to Your Offshore Injury?</h2>
<p>The law governing an offshore injury depends on the worker's status and the structure's classification:</p>
<ul>
<li><strong>Jones Act seamen:</strong> Workers with a substantial connection to a vessel in navigation — including mobile offshore drilling units (MODUs) and floating production platforms — are covered by the <a href="/maritime-injury-lawyers/jones-act-seaman-claim/">Jones Act</a>, which allows negligence claims against the employer plus <a href="/maritime-injury-lawyers/maintenance-and-cure/">maintenance and cure</a> and <a href="/maritime-injury-lawyers/unseaworthiness-claim/">unseaworthiness claims</a></li>
<li><strong>OCSLA workers:</strong> The Outer Continental Shelf Lands Act (<a href="https://www.law.cornell.edu/uscode/text/43/1333" target="_blank" rel="noopener">43 U.S.C. § 1333</a>) extends the LHWCA to workers on fixed platforms on the Outer Continental Shelf, providing federal workers' compensation benefits plus third-party negligence claims</li>
<li><strong>LHWCA workers:</strong> Workers on fixed platforms in state waters may be covered by the <a href="/maritime-injury-lawyers/longshore-harbor-worker/">LHWCA</a></li>
<li><strong>State law workers:</strong> In some circumstances, workers on fixed platforms may be covered by state workers' compensation and negligence law</li>
</ul>

<h2>Common Offshore Injuries</h2>
<p>The offshore environment exposes workers to severe hazards:</p>
<ul>
<li><strong>Crane and rigging accidents:</strong> Heavy lifts aboard platforms frequently cause crushing injuries, falls, and struck-by incidents</li>
<li><strong>Falls from height:</strong> Working on elevated platforms, scaffolding, and equipment exposes workers to falls that can cause <a href="/spinal-cord-injury-lawyers/">spinal cord injuries</a>, <a href="/brain-injury-lawyers/">traumatic brain injuries</a>, and death</li>
<li><strong>Explosions and fires:</strong> Hydrocarbon processing and storage on platforms creates risk of catastrophic <a href="/burn-injury-lawyers/">burn injuries</a> and blast injuries</li>
<li><strong>Chemical exposure:</strong> Exposure to drilling fluids, hydrogen sulfide gas, benzene, and other toxic substances</li>
<li><strong>Equipment failures:</strong> <a href="/product-liability-lawyers/defective-industrial-equipment/">Defective or poorly maintained equipment</a> causing crushing, amputation, and entanglement injuries</li>
<li><strong>Helicopter transport accidents:</strong> Workers traveling to and from offshore platforms by helicopter face aviation accident risks</li>
</ul>

<h2>Third-Party Liability on Offshore Platforms</h2>
<p>Offshore operations involve multiple contractors and subcontractors working simultaneously, creating numerous potential third-party claims:</p>
<ul>
<li><strong>Platform owner/operator:</strong> The operator of the platform may be liable for unsafe conditions and safety violations</li>
<li><strong>Other contractors:</strong> A contractor whose negligence injures another contractor's employee may be liable for negligence</li>
<li><strong>Equipment manufacturers:</strong> Makers of <a href="/product-liability-lawyers/defective-industrial-equipment/">defective industrial equipment</a> used on the platform</li>
<li><strong>Vessel owners:</strong> When injuries involve vessel operations (supply boats, crew boats, lift boats) at the platform</li>
</ul>
<p>These third-party claims allow full compensatory damages including pain and suffering, exceeding the benefits available under LHWCA or OCSLA workers' compensation.</p>

<h2>Filing Deadlines for Offshore Injury Claims</h2>
<p>Filing deadlines vary by the applicable law: Jones Act and general maritime law claims have a <strong>3-year</strong> statute of limitations. LHWCA/OCSLA claims require notice to the employer within <strong>30 days</strong> and a formal claim within <strong>1 year</strong>. Third-party negligence claims under state law adopted by OCSLA follow state filing deadlines — 2 years in Georgia (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) and 3 years in South Carolina (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). Determining which deadline applies requires prompt legal analysis.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What law applies to my offshore platform injury?',
                'answer'   => 'It depends on your worker classification and the platform type. Seamen on mobile drilling units may be covered by the Jones Act. Workers on fixed platforms on the Outer Continental Shelf are typically covered by OCSLA (which extends the LHWCA). The jurisdictional analysis is complex and requires an experienced maritime attorney.',
            ),
            array(
                'question' => 'What is the Outer Continental Shelf Lands Act (OCSLA)?',
                'answer'   => 'OCSLA (43 U.S.C. § 1333) extends the LHWCA to workers on fixed platforms and other installations on the Outer Continental Shelf. It provides federal workers\' compensation benefits and allows third-party negligence claims against parties other than the employer.',
            ),
            array(
                'question' => 'Can I sue my employer for an offshore injury?',
                'answer'   => 'If you qualify as a Jones Act seaman, yes — you can sue your employer for negligence under the Jones Act. If you are covered by the LHWCA/OCSLA, you cannot sue your employer directly, but you can pursue third-party negligence claims against platform operators, other contractors, and equipment manufacturers.',
            ),
            array(
                'question' => 'What are the most common offshore platform injuries?',
                'answer'   => 'Common offshore injuries include crane and rigging accidents, falls from height, explosions and burn injuries, chemical exposure, equipment failures causing crushing or amputation injuries, and helicopter transport accidents.',
            ),
            array(
                'question' => 'How long do I have to file an offshore injury claim?',
                'answer'   => 'Deadlines vary by the applicable law. Jones Act claims allow 3 years. LHWCA/OCSLA claims require notice within 30 days and a formal claim within 1 year. Third-party claims follow state deadlines adopted by OCSLA. Identifying the correct deadline requires prompt legal consultation.',
            ),
        ),
    ),

    /* ============================================================
       6. Commercial Fishing Injury
       ============================================================ */
    array(
        'title'   => 'Commercial Fishing Injury Lawyers',
        'slug'    => 'commercial-fishing-injury',
        'excerpt' => 'Injured while commercial fishing? The fishing industry is one of the most dangerous in America. Our maritime lawyers pursue Jones Act, unseaworthiness, and maintenance and cure claims for injured fishermen.',
        'content' => <<<'HTML'
<h2>Commercial Fishing Injury Lawyers in Georgia &amp; South Carolina</h2>
<p>Commercial fishing is consistently ranked as one of the most dangerous occupations in America. The <a href="https://www.bls.gov/iif/" target="_blank" rel="noopener">Bureau of Labor Statistics</a> reports that fishing workers suffer a fatality rate that is approximately 40 times the national average for all workers. Georgia and South Carolina's shrimp boats, crab boats, charter fishing vessels, and offshore fishing operations expose workers to drowning, equipment entanglement, crushing injuries, falls overboard, and severe weather events — often far from emergency medical care.</p>
<p>At Roden Law, our commercial fishing injury lawyers represent injured fishermen and their families throughout the Georgia and South Carolina coast. We understand the maritime laws that protect fishing workers — including the <a href="/maritime-injury-lawyers/jones-act-seaman-claim/">Jones Act</a>, the doctrine of <a href="/maritime-injury-lawyers/unseaworthiness-claim/">unseaworthiness</a>, and the right to <a href="/maritime-injury-lawyers/maintenance-and-cure/">maintenance and cure</a> — and we pursue maximum compensation from negligent vessel owners and operators.</p>

<h2>Maritime Laws Protecting Fishermen</h2>
<p>Commercial fishermen who work aboard vessels typically qualify as Jones Act seamen and have access to three powerful maritime remedies:</p>
<ul>
<li><strong><a href="/maritime-injury-lawyers/jones-act-seaman-claim/">Jones Act negligence</a>:</strong> Allows the fisherman to sue the vessel owner/employer for any negligence that played a part in causing the injury — with the favorable "featherweight" burden of proof</li>
<li><strong><a href="/maritime-injury-lawyers/unseaworthiness-claim/">Unseaworthiness</a>:</strong> Strict liability claim when the vessel, its equipment, or crew is not reasonably fit for its intended purpose</li>
<li><strong><a href="/maritime-injury-lawyers/maintenance-and-cure/">Maintenance and cure</a>:</strong> Absolute right to daily living expenses and medical care until maximum medical improvement, regardless of fault</li>
</ul>
<p>These remedies provide far greater protection than state <a href="/workers-compensation-lawyers/">workers' compensation</a>, which does not cover most commercial fishermen.</p>

<h2>Common Commercial Fishing Hazards</h2>
<p>The fishing industry's extreme danger arises from multiple hazards:</p>
<ul>
<li><strong>Vessel sinking and capsizing:</strong> Overloaded vessels, severe weather, instability from improperly stowed catch, and unseaworthy hull conditions can cause vessels to capsize or founder</li>
<li><strong>Falls overboard:</strong> Slippery decks, heavy seas, and working at the rail make falls overboard a constant risk — and cold water immersion can cause death within minutes</li>
<li><strong>Deck equipment injuries:</strong> Winches, block and tackle systems, nets, trawl doors, crab pots, and longlines can entangle, crush, or amputate limbs</li>
<li><strong>Struck-by injuries:</strong> Swinging booms, unsecured catch, and shifting equipment strike crew members</li>
<li><strong>Repetitive stress injuries:</strong> Constant hauling, pulling, and lifting in cold, wet conditions causes chronic musculoskeletal injuries</li>
<li><strong>Burns and chemical exposure:</strong> Engine room fires, hot equipment, and fuel spills cause <a href="/burn-injury-lawyers/">burn injuries</a></li>
</ul>

<h2>Employer Responsibilities to Fishing Crew</h2>
<p>Vessel owners and fishing operators owe their crew members specific duties under maritime law:</p>
<ul>
<li><strong>Seaworthy vessel:</strong> The vessel must be in a condition reasonably fit for the fishing operations to be performed</li>
<li><strong>Safe equipment:</strong> All fishing gear, deck equipment, and safety systems must be properly maintained and functional</li>
<li><strong>Adequate crew:</strong> The vessel must be sufficiently crewed for the operations — understaffing that leads to fatigue and injury is a form of negligence</li>
<li><strong>Safety equipment:</strong> Life rafts, personal flotation devices, EPIRBs (emergency position-indicating radio beacons), fire extinguishers, and first aid supplies must be provided and functional</li>
<li><strong>Training:</strong> Crew must be trained on safety procedures, equipment operation, and emergency protocols</li>
</ul>

<h2>Share vs. Wage Fishermen</h2>
<p>Many commercial fishermen are paid on a "share" or "lay" system — receiving a percentage of the catch rather than a fixed wage. Vessel owners sometimes argue that share fishermen are independent contractors not covered by the Jones Act. However, courts have consistently held that the Jones Act seaman analysis focuses on the worker's connection to the vessel, not the method of compensation. Share fishermen who meet the seaman status test are entitled to full Jones Act protections.</p>

<h2>Statute of Limitations</h2>
<p>Jones Act, unseaworthiness, and maintenance and cure claims generally must be filed within <strong>3 years</strong> of the date of injury. However, injured fishermen should contact a maritime attorney immediately — evidence aboard commercial fishing vessels degrades quickly, and vessel owners may repair or alter equipment before an investigation can be conducted.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Are commercial fishermen covered by workers\' compensation?',
                'answer'   => 'Most commercial fishermen are not covered by state workers\' compensation. Instead, they are protected by maritime law — specifically the Jones Act, the doctrine of unseaworthiness, and the right to maintenance and cure. These remedies provide greater protection than workers\' comp, including pain and suffering damages and jury trials.',
            ),
            array(
                'question' => 'Are share fishermen (paid by percentage of catch) covered by the Jones Act?',
                'answer'   => 'Yes. Courts have held that the method of compensation does not determine seaman status. Share fishermen who work aboard a vessel in navigation and contribute to the vessel\'s function qualify as Jones Act seamen, regardless of whether they are paid wages or a share of the catch.',
            ),
            array(
                'question' => 'What should I do if I\'m injured on a commercial fishing boat?',
                'answer'   => 'Report the injury to the captain immediately, request medical treatment, document the conditions that caused your injury (photos if possible), and get contact information from any witnesses. Do not sign any documents from the vessel owner or insurer. Contact a maritime attorney as soon as you reach shore.',
            ),
            array(
                'question' => 'Can I sue the boat owner if I\'m injured while commercial fishing?',
                'answer'   => 'Yes. Under the Jones Act, you can sue the vessel owner/employer for negligence. You can also assert an unseaworthiness claim if the vessel or its equipment was not reasonably fit for the fishing operations. Additionally, you have an absolute right to maintenance and cure — daily living expenses and medical care until maximum medical improvement.',
            ),
            array(
                'question' => 'How long do I have to file a commercial fishing injury claim?',
                'answer'   => 'Jones Act, unseaworthiness, and maintenance and cure claims must generally be filed within 3 years. However, evidence on fishing vessels degrades quickly, and owners may repair or alter equipment — so contacting a maritime attorney immediately is critical.',
            ),
        ),
    ),

    /* ============================================================
       7. Tugboat and Barge Accident
       ============================================================ */
    array(
        'title'   => 'Tugboat and Barge Accident Lawyers',
        'slug'    => 'tugboat-barge-accident',
        'excerpt' => 'Injured in a tugboat or barge accident? These heavy maritime operations carry unique risks. Our maritime lawyers pursue Jones Act, unseaworthiness, and third-party claims for tug and barge workers.',
        'content' => <<<'HTML'
<h2>Tugboat and Barge Accident Lawyers in Georgia &amp; South Carolina</h2>
<p>Tugboat and barge operations are essential to the commercial activity at the Ports of Savannah and Charleston and throughout the Intracoastal Waterway, rivers, and harbors of Georgia and South Carolina. These operations involve maneuvering massive vessels in tight quarters, making up and breaking apart tow configurations, and transferring personnel and equipment between vessels — all of which create significant risks for workers. Tugboat crews, barge workers, and deckhands face dangers from line-handling, heavy equipment, vessel collisions, falls between vessels, and crushing injuries.</p>
<p>At Roden Law, our tugboat and barge accident lawyers represent injured maritime workers throughout the Georgia and South Carolina waterway system. Tugboat crew members typically qualify as <a href="/maritime-injury-lawyers/jones-act-seaman-claim/">Jones Act seamen</a>, giving them access to powerful federal remedies for their injuries.</p>

<h2>Common Tugboat and Barge Accident Causes</h2>
<p>The heavy-duty nature of tug and barge operations creates specific hazard patterns:</p>
<ul>
<li><strong>Line-handling injuries:</strong> Mooring lines and tow cables under tremendous tension can snap, recoil, or whip, causing catastrophic striking injuries, amputations, and fatalities. Improperly sized or worn lines are a frequent cause of <a href="/maritime-injury-lawyers/unseaworthiness-claim/">unseaworthiness</a> claims</li>
<li><strong>Crushing between vessels:</strong> Workers stepping between a tug and barge, or between a tug and dock, risk being crushed when the vessels shift unexpectedly</li>
<li><strong>Falls overboard:</strong> Transferring between tug and barge, or working along the barge's edge, exposes workers to falls into the water, particularly at night or in rough conditions</li>
<li><strong>Allisions and collisions:</strong> Tugboats striking bridges, locks, other vessels, or submerged objects can throw crew members, cause fires, or lead to sinking</li>
<li><strong>Barge deck hazards:</strong> Uneven surfaces, open hatches, missing or damaged coamings, slippery surfaces, and inadequate lighting on barges create fall and trip hazards</li>
<li><strong>Winch and equipment failures:</strong> Towing winches, capstans, and deck machinery can malfunction, causing entanglement and crushing injuries</li>
</ul>

<h2>Legal Claims for Tugboat and Barge Workers</h2>
<p>Tugboat crew members typically qualify as Jones Act seamen and have access to three maritime remedies:</p>
<ul>
<li><strong><a href="/maritime-injury-lawyers/jones-act-seaman-claim/">Jones Act negligence</a>:</strong> Claims against the employer for failing to provide a safe workplace, maintain safe equipment, or properly train and staff the vessel</li>
<li><strong><a href="/maritime-injury-lawyers/unseaworthiness-claim/">Unseaworthiness</a>:</strong> Strict liability claims when the tug, barge, or equipment is not reasonably fit — including worn lines, defective deck machinery, and inadequate safety equipment</li>
<li><strong><a href="/maritime-injury-lawyers/maintenance-and-cure/">Maintenance and cure</a>:</strong> Absolute right to daily living expenses and medical treatment until maximum medical improvement</li>
</ul>
<p>Barge workers who do not qualify as seamen may be covered by the <a href="/maritime-injury-lawyers/longshore-harbor-worker/">LHWCA</a> and can pursue third-party claims against tug operators, barge owners, and equipment manufacturers.</p>

<h2>Third-Party Liability in Tug and Barge Operations</h2>
<p>Tug and barge operations frequently involve multiple companies, creating third-party liability opportunities:</p>
<ul>
<li><strong>Barge owner vs. tug operator:</strong> When a tug operator's negligence causes injury to a barge worker (or vice versa), the injured worker can sue the other company as a third party</li>
<li><strong>Terminal operators:</strong> Dock and terminal operators who create unsafe conditions for tug and barge crews</li>
<li><strong>Equipment manufacturers:</strong> Makers of <a href="/product-liability-lawyers/defective-industrial-equipment/">defective winches, lines, and deck equipment</a></li>
<li><strong>Charterers:</strong> Companies chartering tugs or barges that impose unsafe operational requirements</li>
</ul>

<h2>Savannah and Charleston Port Operations</h2>
<p>The Port of Savannah and Port of Charleston rely heavily on tug and barge operations for ship docking, undocking, cargo barge movements, and maintenance activities. Our attorneys are familiar with the specific operations, companies, and hazards at both ports and throughout the Georgia and South Carolina Intracoastal Waterway.</p>

<h2>Statute of Limitations</h2>
<p>Jones Act, unseaworthiness, and maintenance and cure claims must be filed within <strong>3 years</strong> of the date of injury. LHWCA claims require employer notice within <strong>30 days</strong> and a formal claim within <strong>1 year</strong>. Evidence preservation — including tug logs, voyage data recorders, and maintenance records — is critical and must begin immediately.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What are the most common tugboat accidents?',
                'answer'   => 'The most common tug and barge accidents involve line-handling injuries (snapping lines under tension), crushing injuries between vessels, falls overboard during vessel-to-vessel transfers, allisions with bridges or other structures, barge deck trip and fall hazards, and winch and equipment malfunctions.',
            ),
            array(
                'question' => 'Are tugboat workers covered by the Jones Act?',
                'answer'   => 'Yes. Tugboat crew members — including captains, engineers, and deckhands — typically qualify as Jones Act seamen because they have a substantial connection to a vessel in navigation. This gives them the right to sue their employer for negligence, plus unseaworthiness and maintenance and cure claims.',
            ),
            array(
                'question' => 'What if I was injured by a snapping line on a tug or barge?',
                'answer'   => 'Line-handling injuries are among the most common and dangerous tug and barge accidents. If the line was worn, improperly sized, or defective, the vessel may have been unseaworthy — giving you a strict liability claim. If crew training or procedures were inadequate, a Jones Act negligence claim also applies.',
            ),
            array(
                'question' => 'Can a barge worker who is not a seaman still recover damages?',
                'answer'   => 'Yes. Barge workers who do not qualify as Jones Act seamen may be covered by the Longshore and Harbor Workers\' Compensation Act (LHWCA), which provides workers\' compensation benefits. They can also pursue third-party negligence claims against tug operators, barge owners, or equipment manufacturers for full damages.',
            ),
            array(
                'question' => 'How long do I have to file a tugboat or barge accident claim?',
                'answer'   => 'Jones Act and unseaworthiness claims have a 3-year statute of limitations. LHWCA claims require notice within 30 days and a formal claim within 1 year. Preserving evidence — tug logs, maintenance records, and equipment condition — is critical and should begin immediately.',
            ),
        ),
    ),

    /* ============================================================
       8. Cruise Ship Injury
       ============================================================ */
    array(
        'title'   => 'Cruise Ship Injury Lawyers',
        'slug'    => 'cruise-ship-injury',
        'excerpt' => 'Injured on a cruise ship as a passenger or crew member? Cruise ship injury claims involve federal maritime law and complex jurisdictional rules. Our maritime lawyers fight for full compensation.',
        'content' => <<<'HTML'
<h2>Cruise Ship Injury Lawyers in Georgia &amp; South Carolina</h2>
<p>Cruise ship injuries affect both passengers and crew members, and the legal framework for recovery is governed by federal maritime law rather than state personal injury law. Cruise ships departing from or visiting Charleston, Savannah, and other Southeast ports carry thousands of passengers who may be injured by slip-and-fall hazards, <a href="/maritime-injury-lawyers/unseaworthiness-claim/">unseaworthy conditions</a>, shore excursion accidents, medical malpractice by ship's doctors, food poisoning, swimming pool accidents, and even crime. Crew members face additional hazards from <a href="/maritime-injury-lawyers/jones-act-seaman-claim/">working conditions aboard the vessel</a>.</p>
<p>At Roden Law, our cruise ship injury lawyers represent passengers and crew members injured on cruise ships throughout the Southeast. We understand the unique procedural requirements, contractual limitations, and maritime law principles that govern these complex cases.</p>

<h2>Passenger Injury Claims</h2>
<p>Cruise ship passengers who are injured due to the cruise line's negligence can bring maritime negligence claims. Common passenger injury scenarios include:</p>
<ul>
<li><strong><a href="/slip-and-fall-lawyers/">Slip and fall accidents</a>:</strong> Wet pool decks, slippery gangways, uneven surfaces, inadequate lighting, and spilled food or drinks</li>
<li><strong>Shore excursion injuries:</strong> Cruise lines often disclaim liability for third-party excursion operators, but may still be liable if they knew or should have known of safety deficiencies</li>
<li><strong>Food poisoning and illness:</strong> Norovirus outbreaks, undercooked food, and contaminated water affecting passengers</li>
<li><strong>Medical malpractice:</strong> Negligent treatment by ship's doctors and medical staff — cruise lines may argue the doctor is an independent contractor, but the ship has a duty to employ competent medical personnel</li>
<li><strong>Tender boat accidents:</strong> Injuries during transfer between the cruise ship and small tender boats used to reach ports</li>
<li><strong>Assault and crime:</strong> Inadequate security leading to passenger-on-passenger or crew-on-passenger assaults</li>
</ul>

<h2>Cruise Ship Ticket Contract Limitations</h2>
<p>Cruise ship tickets contain fine-print contract terms that significantly affect injury claims:</p>
<ul>
<li><strong>Forum selection clauses:</strong> Most major cruise lines require lawsuits to be filed in a specific court — typically the federal district court in Miami, Florida. This clause is generally enforceable under Supreme Court precedent (<em>Carnival Cruise Lines v. Shute</em>, 1991)</li>
<li><strong>Shortened statute of limitations:</strong> Cruise line contracts typically impose a <strong>1-year</strong> time limit to file a lawsuit — significantly shorter than the general maritime 3-year period — and require written notice of the claim within <strong>6 months</strong> of the injury</li>
<li><strong>Limitation of liability:</strong> Contracts may attempt to cap the cruise line's liability or require arbitration of certain claims</li>
</ul>
<p>These contractual limitations make prompt legal action critical. Missing the notice deadline or the shortened filing deadline can permanently bar your claim.</p>

<h2>Crew Member Claims</h2>
<p>Cruise ship crew members who are injured aboard the vessel are generally protected by the same maritime laws as other seamen:</p>
<ul>
<li><strong><a href="/maritime-injury-lawyers/jones-act-seaman-claim/">Jones Act negligence</a>:</strong> Crew members can sue the cruise line for negligence in providing a safe working environment</li>
<li><strong><a href="/maritime-injury-lawyers/unseaworthiness-claim/">Unseaworthiness</a>:</strong> Strict liability when vessel conditions are not reasonably fit</li>
<li><strong><a href="/maritime-injury-lawyers/maintenance-and-cure/">Maintenance and cure</a>:</strong> Absolute right to living expenses and medical treatment until maximum medical improvement</li>
</ul>
<p>However, crew employment contracts often contain forum selection and arbitration clauses that may complicate the claims process. Additionally, many cruise ship crew members are foreign nationals, adding jurisdictional complexity.</p>

<h2>Proving Cruise Line Negligence</h2>
<p>To prevail in a cruise ship passenger injury claim, the injured party must prove the cruise line knew or should have known of a dangerous condition and failed to correct it or warn passengers. Evidence critical to these cases includes the ship's incident reports and logs, surveillance camera footage (cruise ships have extensive camera systems), witness statements from other passengers and crew, medical records from the ship's infirmary, maintenance records and inspection reports, and prior similar incidents aboard the same ship or fleet.</p>
<p>Because cruise lines control all of this evidence and are under no obligation to preserve it indefinitely, filing a preservation demand immediately after injury is essential.</p>

<h2>Filing Deadlines</h2>
<p>Passenger claims: Check your ticket contract — most cruise lines impose a <strong>6-month notice requirement</strong> and a <strong>1-year filing deadline</strong>. General maritime crew claims: <strong>3 years</strong>. These deadlines run from the date of injury. Contact a cruise ship injury attorney immediately to preserve your rights.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue a cruise line if I\'m injured on a cruise ship?',
                'answer'   => 'Yes. Passengers can bring maritime negligence claims against cruise lines for injuries caused by the cruise line\'s failure to maintain safe conditions or warn of known hazards. However, your cruise ticket contains important contractual limitations on where, when, and how you can file a claim — making prompt legal action critical.',
            ),
            array(
                'question' => 'What is the time limit to file a cruise ship injury claim?',
                'answer'   => 'Most cruise line ticket contracts require written notice of your claim within 6 months and filing a lawsuit within 1 year of the injury — much shorter than the general maritime 3-year period. Missing these deadlines can permanently bar your claim. Check your ticket contract and contact an attorney immediately.',
            ),
            array(
                'question' => 'Where do I have to file a cruise ship injury lawsuit?',
                'answer'   => 'Most major cruise lines include a forum selection clause in the ticket contract requiring lawsuits to be filed in a specific court, typically the federal district court in Miami, Florida. This clause is generally enforceable under Supreme Court precedent (Carnival Cruise Lines v. Shute, 1991).',
            ),
            array(
                'question' => 'Can cruise ship crew members file injury claims?',
                'answer'   => 'Yes. Crew members typically qualify as Jones Act seamen and can bring Jones Act negligence claims, unseaworthiness claims, and maintenance and cure demands. However, crew employment contracts often contain arbitration and forum selection clauses that may affect how and where claims are pursued.',
            ),
            array(
                'question' => 'Is the cruise line liable for shore excursion injuries?',
                'answer'   => 'Cruise lines often argue they are not liable for injuries on third-party shore excursions. However, they may be liable if they knew or should have known the excursion operator had safety deficiencies, or if they retained control over the excursion. The specific facts and the ticket contract terms determine liability.',
            ),
        ),
    ),

); // end $subtypes array

/* ------------------------------------------------------------------
   INSERT POSTS
   ------------------------------------------------------------------ */

$created = 0;
$skipped = 0;

foreach ( $subtypes as $sub ) {
    // Check if slug already exists under this parent.
    $existing = get_posts( array(
        'post_type'   => $pillar_type,
        'name'        => $sub['slug'],
        'post_parent' => $pillar_id,
        'post_status' => array( 'publish', 'draft', 'pending', 'private', 'trash' ),
        'numberposts' => 1,
    ) );

    if ( ! empty( $existing ) ) {
        WP_CLI::log( "  SKIP: \"{$sub['title']}\" already exists (ID {$existing[0]->ID})" );
        $skipped++;
        continue;
    }

    $post_id = wp_insert_post( array(
        'post_type'    => $pillar_type,
        'post_title'   => wp_strip_all_tags( html_entity_decode( $sub['title'], ENT_QUOTES, 'UTF-8' ) ),
        'post_name'    => $sub['slug'],
        'post_content' => $sub['content'],
        'post_excerpt' => $sub['excerpt'],
        'post_status'  => 'publish',
        'post_parent'  => $pillar_id,
        'post_author'  => 1,
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "  FAIL: \"{$sub['title']}\" — " . $post_id->get_error_message() );
        continue;
    }

    // Meta fields.
    update_post_meta( $post_id, '_roden_jurisdiction', 'both' );
    update_post_meta( $post_id, '_roden_sol_ga', 'O.C.G.A. § 9-3-33' );
    update_post_meta( $post_id, '_roden_sol_sc', 'S.C. Code § 15-3-530' );
    update_post_meta( $post_id, '_roden_faqs', $sub['faqs'] );

    if ( $author_attorney_id ) {
        update_post_meta( $post_id, '_roden_author_attorney', $author_attorney_id );
    }

    // Taxonomy.
    if ( $cat_term_id ) {
        wp_set_object_terms( $post_id, (int) $cat_term_id, 'practice_category' );
    }

    WP_CLI::success( "  CREATED: \"{$sub['title']}\" (ID {$post_id})" );
    $created++;
}

WP_CLI::log( '' );
WP_CLI::success( "Done. Created: {$created}, Skipped: {$skipped}" );
WP_CLI::log( 'Run: wp rewrite flush' );
