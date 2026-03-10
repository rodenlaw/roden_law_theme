<?php
/**
 * Seeder: 8 Workers' Compensation Sub-Type Pages
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-workers-comp-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: workers-compensation-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'workers-compensation-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'workers-compensation-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "workers-compensation-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'workers-compensation', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( "Workers' Compensation", 'practice_category', array( 'slug' => 'workers-compensation' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Construction Worker Injury
       ============================================================ */
    array(
        'title'   => 'Construction Worker Injury Lawyers',
        'slug'    => 'construction-worker-injury',
        'excerpt' => 'Injured on a construction site in Georgia or South Carolina? Our attorneys fight for full workers\' compensation benefits and pursue third-party liability claims for maximum recovery.',
        'content' => <<<'HTML'
<h2>Legal Representation for Injured Construction Workers</h2>
<p>Construction consistently ranks among the most dangerous industries in the United States. According to the <a href="https://www.osha.gov/construction" target="_blank" rel="noopener">Occupational Safety and Health Administration (OSHA)</a>, approximately one in five workplace fatalities occurs in the construction industry. Workers on job sites across Georgia and South Carolina face daily exposure to falls, electrocution, struck-by incidents, and caught-in/between hazards — OSHA's "Fatal Four" that account for over 60% of construction deaths annually.</p>
<p>At Roden Law, our construction worker injury lawyers understand the unique challenges these cases present. Construction injuries often involve overlapping workers' compensation claims and third-party liability actions against general contractors, subcontractors, equipment manufacturers, and property owners. We pursue every available avenue of recovery so injured workers and their families receive full compensation.</p>

<h2>Workers' Compensation for Construction Injuries</h2>
<p>Both Georgia and South Carolina require employers with three or more employees to carry workers' compensation insurance. Georgia's workers' compensation system is governed by <a href="https://law.justia.com/codes/georgia/title-34/chapter-9/" target="_blank" rel="noopener">O.C.G.A. § 34-9-1 et seq.</a>, while South Carolina's system operates under <a href="https://www.scstatehouse.gov/code/t42c001.php" target="_blank" rel="noopener">S.C. Code § 42-1-10 et seq.</a> Workers' comp provides medical benefits, temporary total disability payments (typically two-thirds of the worker's average weekly wage), permanent partial or total disability benefits, and vocational rehabilitation.</p>
<p>Construction workers do not need to prove their employer was at fault — workers' compensation is a no-fault system. However, in exchange for guaranteed benefits, the exclusive remedy doctrine generally bars employees from suing their employer directly for negligence.</p>

<h2>Third-Party Liability in Construction Accidents</h2>
<p>While workers' comp limits claims against your employer, you may have additional claims against third parties whose negligence contributed to your injury. Common third-party defendants in construction cases include general contractors who failed to maintain safe site conditions, subcontractors whose negligent work created hazards, equipment and machinery manufacturers liable under <a href="/practice-areas/product-liability-lawyers/">product liability</a> theories, property owners who knew about dangerous conditions, and architects or engineers whose defective designs caused failures. These third-party claims allow you to recover damages not available through workers' comp, including pain and suffering, full lost wages, and punitive damages. Our <a href="/practice-areas/construction-accident-lawyers/">construction accident lawyers</a> work alongside your workers' comp claim to maximize total recovery.</p>

<h2>Common Construction Site Injuries</h2>
<p>Construction injuries are often severe and life-altering. The most frequent injuries our attorneys handle include:</p>
<ul>
<li>Falls from scaffolding, ladders, roofs, and elevated work platforms</li>
<li>Electrocution and electrical burns from exposed wiring or overhead power lines</li>
<li>Crush injuries from heavy equipment, collapsing structures, or trench cave-ins</li>
<li><a href="/practice-areas/brain-injury-lawyers/">Traumatic brain injuries</a> from falling objects or falls from heights</li>
<li><a href="/practice-areas/spinal-cord-injury-lawyers/">Spinal cord injuries</a> resulting in partial or complete paralysis</li>
<li>Amputations caused by unguarded machinery or power tools</li>
<li><a href="/practice-areas/burn-injury-lawyers/">Burn injuries</a> from chemical exposure, explosions, or welding accidents</li>
</ul>

<h2>OSHA Violations as Evidence</h2>
<p>OSHA sets mandatory safety standards for the construction industry, including fall protection requirements (29 CFR 1926.501), scaffolding safety standards, trenching and excavation rules, and personal protective equipment mandates. When an employer or contractor violates OSHA regulations and a worker is injured as a result, those violations serve as powerful evidence of negligence in both workers' comp and third-party claims. Our attorneys obtain OSHA inspection records, citation histories, and incident reports to build the strongest possible case for injured construction workers.</p>

<h2>Why Choose Roden Law for Construction Injury Cases</h2>
<p>Our team has recovered millions for injured construction workers across Georgia and South Carolina. We handle the workers' comp claim and any third-party litigation simultaneously, ensuring no benefit or damage category is overlooked. We work on a contingency fee basis — you pay nothing unless we win your case. If you or a loved one has been injured on a construction site, contact our <a href="/workers-compensation-lawyers/third-party-workplace-injury/">third-party workplace injury</a> team for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I file a workers\' comp claim and a third-party lawsuit for a construction injury?',
                'answer'   => 'Yes. Workers\' compensation covers your employer, but you may also sue negligent third parties such as general contractors, subcontractors, equipment manufacturers, or property owners. This dual approach often yields significantly greater total compensation.',
            ),
            array(
                'question' => 'What are OSHA\'s "Fatal Four" construction hazards?',
                'answer'   => 'OSHA identifies falls, struck-by incidents, electrocution, and caught-in/between hazards as the "Fatal Four" — responsible for over 60% of construction worker deaths. Employers must implement safeguards against each of these hazards.',
            ),
            array(
                'question' => 'How much does workers\' compensation pay for construction injuries in Georgia?',
                'answer'   => 'Georgia workers\' comp pays two-thirds of your average weekly wage for temporary total disability, subject to a maximum weekly benefit cap set annually by the State Board of Workers\' Compensation (O.C.G.A. § 34-9-261). Medical expenses related to the injury are covered in full.',
            ),
            array(
                'question' => 'What if my employer does not have workers\' compensation insurance?',
                'answer'   => 'Both Georgia and South Carolina penalize employers who fail to carry required workers\' comp insurance. Uninsured employers lose their protection from lawsuits, meaning you can file a direct negligence action for the full range of damages including pain and suffering.',
            ),
            array(
                'question' => 'How long do I have to report a construction injury for workers\' comp?',
                'answer'   => 'In Georgia, you must report a workplace injury to your employer within 30 days (O.C.G.A. § 34-9-80). In South Carolina, the reporting deadline is 90 days (S.C. Code § 42-15-20). Failing to report promptly can jeopardize your claim.',
            ),
        ),
    ),

    /* ============================================================
       2. Factory and Manufacturing Injury
       ============================================================ */
    array(
        'title'   => 'Factory and Manufacturing Injury Lawyers',
        'slug'    => 'factory-manufacturing-injury',
        'excerpt' => 'Suffered a factory or manufacturing injury in Georgia or South Carolina? Our lawyers pursue workers\' comp benefits and third-party claims against negligent equipment manufacturers and contractors.',
        'content' => <<<'HTML'
<h2>Representing Injured Factory and Manufacturing Workers</h2>
<p>Factory and manufacturing workers in Georgia and South Carolina operate in environments filled with heavy machinery, conveyor systems, chemical agents, and extreme temperatures. The <a href="https://www.bls.gov/iif/" target="_blank" rel="noopener">Bureau of Labor Statistics (BLS)</a> reports that the manufacturing sector accounts for tens of thousands of workplace injuries annually, including amputations, crush injuries, chemical burns, and respiratory illnesses. When employers cut corners on safety or equipment manufacturers sell defective machinery, workers pay the price.</p>
<p>At Roden Law, our factory injury attorneys have extensive experience navigating the intersection of workers' compensation, OSHA regulations, and product liability law. We fight to ensure injured manufacturing workers receive every dollar they deserve — both through the workers' comp system and through third-party liability claims.</p>

<h2>Workers' Compensation for Manufacturing Injuries</h2>
<p>Georgia's Workers' Compensation Act (<a href="https://law.justia.com/codes/georgia/title-34/chapter-9/" target="_blank" rel="noopener">O.C.G.A. § 34-9-1 et seq.</a>) and South Carolina's Workers' Compensation Law (<a href="https://www.scstatehouse.gov/code/t42c001.php" target="_blank" rel="noopener">S.C. Code § 42-1-10 et seq.</a>) provide injured workers with medical benefits, income replacement, and disability compensation without requiring proof of employer fault. Factory workers are entitled to coverage for all reasonable and necessary medical treatment, temporary total disability benefits at two-thirds of the average weekly wage, permanent partial disability ratings based on the injured body part, and permanent total disability benefits when the worker cannot return to gainful employment.</p>

<h2>Common Factory and Manufacturing Injuries</h2>
<p>Manufacturing environments present a wide range of hazards that can cause catastrophic injuries:</p>
<ul>
<li><strong>Amputations:</strong> Unguarded punch presses, saws, and conveyor systems cause hundreds of workplace amputations annually</li>
<li><strong>Crush injuries:</strong> Workers caught between heavy machinery, presses, or rolling stock</li>
<li><strong>Chemical burns and exposure:</strong> Contact with industrial solvents, acids, and toxic substances</li>
<li><strong>Respiratory illness:</strong> Inhalation of dust, fumes, and airborne chemicals leading to <a href="/workers-compensation-lawyers/occupational-disease/">occupational diseases</a></li>
<li><strong>Hearing loss:</strong> Prolonged exposure to industrial noise above safe decibel levels</li>
<li><strong>Electrocution:</strong> Faulty wiring, improperly grounded equipment, or arc flash incidents</li>
<li><strong><a href="/workers-compensation-lawyers/repetitive-stress-injury/">Repetitive stress injuries</a>:</strong> Carpal tunnel syndrome, tendinitis, and other conditions from repetitive motions</li>
</ul>

<h2>Third-Party Product Liability Claims</h2>
<p>When a defective machine, tool, or safety device contributes to a factory injury, the injured worker may pursue a <a href="/practice-areas/product-liability-lawyers/">product liability claim</a> against the manufacturer, distributor, or installer — in addition to workers' compensation benefits. Product liability claims can include design defects (the machine was inherently dangerous), manufacturing defects (the specific unit deviated from specifications), and failure to warn (inadequate safety labels, instructions, or warnings). These claims allow recovery of pain and suffering, full lost wages, diminished earning capacity, and potentially punitive damages — none of which are available through workers' comp alone.</p>

<h2>OSHA Machine Guarding Standards</h2>
<p>OSHA's machine guarding standard (29 CFR 1910.212) requires employers to protect workers from hazards created by point of operation, nip points, rotating parts, flying chips, and sparks. Additional OSHA standards govern lockout/tagout procedures (29 CFR 1910.147) to prevent machines from being energized during maintenance, hazard communication (29 CFR 1910.1200) for chemical exposure, and personal protective equipment requirements (29 CFR 1910.132). OSHA violations documented through workplace inspections or citations provide strong evidence of employer and third-party negligence.</p>

<h2>Why Choose Roden Law for Factory Injury Claims</h2>
<p>Our attorneys understand the technical complexities of manufacturing injury cases. We work with industrial safety experts, vocational rehabilitation specialists, and life care planners to document the full extent of your injuries and losses. Whether your case involves a straightforward workers' comp claim or a complex third-party product liability action, we pursue maximum recovery on a contingency fee basis — no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue my employer for a factory injury in Georgia or South Carolina?',
                'answer'   => 'Generally, workers\' compensation is the exclusive remedy against your employer. However, you can sue third parties such as equipment manufacturers, maintenance contractors, or property owners whose negligence contributed to your injury.',
            ),
            array(
                'question' => 'What is the OSHA lockout/tagout standard?',
                'answer'   => 'The lockout/tagout standard (29 CFR 1910.147) requires employers to disable machinery and equipment during servicing and maintenance to prevent unexpected startup. Violations of this standard are a leading cause of factory amputations and crush injuries.',
            ),
            array(
                'question' => 'How are permanent disability benefits calculated for factory workers?',
                'answer'   => 'Both Georgia and South Carolina use schedules that assign specific numbers of weeks of compensation for the loss or loss of use of particular body parts. For injuries not on the schedule, an impairment rating from a physician determines the benefit amount.',
            ),
            array(
                'question' => 'What if I was exposed to toxic chemicals at a manufacturing plant?',
                'answer'   => 'Chemical exposure injuries are covered by workers\' compensation. You may also have a third-party claim against the chemical manufacturer or distributor. Additionally, long-term exposure causing occupational disease is compensable under both Georgia and South Carolina workers\' comp laws.',
            ),
            array(
                'question' => 'How long do I have to file a workers\' comp claim for a factory injury?',
                'answer'   => 'In Georgia, the statute of limitations for workers\' comp claims is one year from the date of injury or the last payment of benefits (O.C.G.A. § 34-9-82). In South Carolina, you have two years from the date of injury (S.C. Code § 42-15-40).',
            ),
        ),
    ),

    /* ============================================================
       3. Warehouse and Distribution Injury
       ============================================================ */
    array(
        'title'   => 'Warehouse and Distribution Injury Lawyers',
        'slug'    => 'warehouse-distribution-injury',
        'excerpt' => 'Hurt in a warehouse or distribution center in Georgia or South Carolina? Our attorneys pursue workers\' comp benefits and hold negligent third parties accountable for unsafe working conditions.',
        'content' => <<<'HTML'
<h2>Legal Help for Warehouse and Distribution Center Injuries</h2>
<p>The explosive growth of e-commerce and logistics has transformed Georgia and South Carolina into major distribution hubs, with sprawling warehouse complexes in Savannah, Charleston, Columbia, and along the I-95 and I-85 corridors. The <a href="https://www.bls.gov/iif/" target="_blank" rel="noopener">Bureau of Labor Statistics</a> reports that warehouse and storage workers experience injury rates significantly higher than the national average, with over 5 injuries per 100 full-time workers annually. The pressure to meet demanding production quotas compounds the danger, as workers are pushed to move faster through environments filled with forklifts, heavy pallets, and automated equipment.</p>
<p>At Roden Law, our warehouse injury lawyers help injured workers navigate the workers' compensation system while identifying third-party claims that can dramatically increase total recovery.</p>

<h2>Workers' Compensation Coverage for Warehouse Workers</h2>
<p>Under Georgia's Workers' Compensation Act (<a href="https://law.justia.com/codes/georgia/title-34/chapter-9/" target="_blank" rel="noopener">O.C.G.A. § 34-9-1 et seq.</a>) and South Carolina's Workers' Compensation Law (<a href="https://www.scstatehouse.gov/code/t42c001.php" target="_blank" rel="noopener">S.C. Code § 42-1-10 et seq.</a>), warehouse workers injured on the job are entitled to full medical coverage for treatment of workplace injuries, temporary total disability benefits at two-thirds of the average weekly wage, permanent impairment benefits for lasting injuries, and vocational rehabilitation if unable to return to previous duties. The workers' comp system is no-fault, meaning you do not need to prove your employer was negligent. You simply need to demonstrate the injury arose out of and in the course of employment.</p>

<h2>Common Warehouse and Distribution Injuries</h2>
<p>Warehouse and distribution workers face numerous hazards every shift:</p>
<ul>
<li><strong>Forklift accidents:</strong> Collisions, tip-overs, pedestrian strikes, and falling loads from improperly stacked pallets</li>
<li><strong>Falling merchandise:</strong> Items falling from high shelving, racking collapse, and unstable stacking</li>
<li><strong>Conveyor belt injuries:</strong> Hands, fingers, and clothing caught in moving belts and rollers</li>
<li><strong>Slip, trip, and fall injuries:</strong> Wet floors, cluttered aisles, uneven surfaces, and <a href="/practice-areas/slip-and-fall-lawyers/">slip-and-fall hazards</a></li>
<li><strong>Overexertion injuries:</strong> Back injuries, herniated discs, and muscle tears from heavy lifting</li>
<li><strong><a href="/workers-compensation-lawyers/repetitive-stress-injury/">Repetitive motion injuries</a>:</strong> Carpal tunnel, tendinitis, and chronic strain from repetitive picking and packing</li>
<li><strong>Loading dock accidents:</strong> Falls from dock edges, trailer shifts, and being struck by backing trucks</li>
</ul>

<h2>Third-Party Claims in Warehouse Injury Cases</h2>
<p>Beyond workers' compensation, injured warehouse employees may have claims against third parties including forklift manufacturers whose defective equipment caused the accident, staffing agencies that failed to provide adequate safety training, property owners who maintained unsafe premises, racking and shelving system designers whose products failed, and <a href="/practice-areas/truck-accident-lawyers/">trucking companies</a> whose drivers caused loading dock accidents. Third-party claims provide access to full compensatory damages — including pain and suffering, emotional distress, and punitive damages — that are not available through workers' comp.</p>

<h2>OSHA Warehouse Safety Requirements</h2>
<p>OSHA requires warehouse operators to maintain safe working environments, including proper forklift operator training and certification (29 CFR 1910.178), clear aisle markings and pedestrian walkways, fall protection at elevated platforms and loading docks, proper material storage and stacking procedures, and adequate lighting, ventilation, and emergency exits. Documented OSHA violations strengthen both workers' comp claims and third-party negligence actions.</p>

<h2>Why Choose Roden Law for Warehouse Injury Cases</h2>
<p>Our attorneys serve injured warehouse workers at distribution centers throughout the Savannah port corridor, the Charleston logistics hub, and inland facilities across Georgia and South Carolina. We handle your workers' comp claim while aggressively pursuing all available third-party claims. There is no fee unless we win your case. Contact us for a free consultation about your warehouse injury.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can a temporary worker file a workers\' comp claim for a warehouse injury?',
                'answer'   => 'Yes. Temporary and staffing agency workers are generally covered by workers\' compensation through either the staffing agency or the host employer. Additionally, temp workers may have third-party claims against the warehouse operator for unsafe conditions.',
            ),
            array(
                'question' => 'What should I do after being injured in a warehouse?',
                'answer'   => 'Report the injury to your supervisor immediately, seek medical attention, document the scene with photos if possible, and contact an attorney. In Georgia, you must report within 30 days (O.C.G.A. § 34-9-80); in South Carolina, within 90 days (S.C. Code § 42-15-20).',
            ),
            array(
                'question' => 'Are forklift accidents covered by workers\' compensation?',
                'answer'   => 'Yes. Forklift accidents that occur during the course of employment are covered by workers\' comp. If a defective forklift or inadequate training by a third party contributed to the accident, additional claims may be available against those parties.',
            ),
            array(
                'question' => 'Can I be fired for filing a workers\' comp claim in Georgia or South Carolina?',
                'answer'   => 'Both states prohibit employers from retaliating against workers who file workers\' comp claims. Georgia\'s anti-retaliation provision is found in O.C.G.A. § 34-9-17, and South Carolina\'s in S.C. Code § 41-1-80. If you are terminated for filing a claim, you may have a separate retaliation lawsuit.',
            ),
            array(
                'question' => 'What if my warehouse employer denies my workers\' comp claim?',
                'answer'   => 'A <a href="/workers-compensation-lawyers/denied-workers-comp-claim/">denied workers\' comp claim</a> can be challenged through a formal hearing process. In Georgia, you file a request for hearing with the State Board of Workers\' Compensation. In South Carolina, you file with the Workers\' Compensation Commission. An attorney can significantly improve your chances of a successful appeal.',
            ),
        ),
    ),

    /* ============================================================
       4. Repetitive Stress Injury
       ============================================================ */
    array(
        'title'   => 'Repetitive Stress Injury Lawyers',
        'slug'    => 'repetitive-stress-injury',
        'excerpt' => 'Suffering from a repetitive stress injury caused by your job in Georgia or South Carolina? Our attorneys help workers secure workers\' comp benefits for carpal tunnel, tendinitis, and chronic strain.',
        'content' => <<<'HTML'
<h2>Workers' Compensation for Repetitive Stress Injuries</h2>
<p>Repetitive stress injuries (RSIs) — also called cumulative trauma disorders or repetitive motion injuries — develop gradually over weeks, months, or years of performing the same physical tasks at work. According to the <a href="https://www.bls.gov/iif/" target="_blank" rel="noopener">Bureau of Labor Statistics</a>, musculoskeletal disorders caused by repetitive motions, overexertion, and sustained awkward postures account for nearly one-third of all workplace injuries requiring time away from work. These injuries affect workers across every industry, from <a href="/workers-compensation-lawyers/factory-manufacturing-injury/">factory assembly lines</a> and <a href="/workers-compensation-lawyers/warehouse-distribution-injury/">warehouse operations</a> to office environments and healthcare settings.</p>
<p>At Roden Law, our repetitive stress injury lawyers understand the unique challenges these claims present. Unlike sudden traumatic injuries, RSIs develop over time, making it more difficult to pinpoint an exact date of injury and easier for insurers to dispute the work-related nature of the condition. We build comprehensive medical and occupational evidence to prove your RSI is directly linked to your job duties.</p>

<h2>Common Repetitive Stress Injuries</h2>
<p>The most frequently diagnosed work-related repetitive stress injuries include:</p>
<ul>
<li><strong>Carpal tunnel syndrome:</strong> Compression of the median nerve in the wrist, common among assembly workers, typists, and cashiers</li>
<li><strong>Tendinitis:</strong> Inflammation of tendons in the wrist, elbow, shoulder, or knee from repetitive motions</li>
<li><strong>Tennis elbow (lateral epicondylitis):</strong> Overuse injury affecting the tendons on the outside of the elbow</li>
<li><strong>Trigger finger:</strong> Locking or catching of fingers caused by repetitive gripping</li>
<li><strong>Rotator cuff injuries:</strong> Shoulder damage from repetitive overhead reaching and lifting</li>
<li><strong>Bursitis:</strong> Inflammation of the fluid-filled sacs cushioning joints, common in the knee, hip, and shoulder</li>
<li><strong>De Quervain's tenosynovitis:</strong> Inflammation of thumb tendons from repetitive pinching or gripping</li>
<li><strong>Herniated discs:</strong> Spinal disc damage from repetitive bending, twisting, and heavy lifting</li>
</ul>

<h2>Filing RSI Workers' Comp Claims in Georgia and South Carolina</h2>
<p>Georgia's Workers' Compensation Act (<a href="https://law.justia.com/codes/georgia/title-34/chapter-9/" target="_blank" rel="noopener">O.C.G.A. § 34-9-1 et seq.</a>) covers occupational injuries that arise "out of and in the course of employment," including gradual-onset conditions like RSIs. South Carolina's Workers' Compensation Law (<a href="https://www.scstatehouse.gov/code/t42c001.php" target="_blank" rel="noopener">S.C. Code § 42-1-10 et seq.</a>) similarly provides coverage for repetitive trauma injuries.</p>
<p>A critical issue in RSI claims is determining the "date of injury." Georgia courts generally recognize the date of injury as the date the worker knew or should have known the condition was work-related. South Carolina follows a similar approach. This date triggers the deadlines for reporting the injury and filing a claim. Because these dates are subject to dispute, early legal consultation is essential.</p>

<h2>Challenges in Repetitive Stress Injury Claims</h2>
<p>Insurance companies frequently challenge RSI claims on the grounds that the condition is not work-related, is a pre-existing condition, or resulted from non-work activities. Common insurer defenses include arguing that activities like gardening, sports, or hobbies caused the condition, claiming the worker failed to report the injury timely, and disputing the treating physician's causation opinion. Our attorneys counter these defenses with detailed job analysis reports, ergonomic evaluations, independent medical examinations, and expert testimony linking your specific job duties to the diagnosed condition.</p>

<h2>Benefits Available for RSI Claims</h2>
<p>If your RSI claim is approved, you are entitled to full medical treatment including surgery, physical therapy, and medications, temporary total disability benefits while you cannot work, temporary partial disability if you can work in a limited capacity, permanent partial impairment benefits based on your disability rating, and vocational rehabilitation if you cannot return to your previous occupation. In severe cases where an RSI renders a worker permanently unable to perform any gainful employment, permanent total disability benefits may be available.</p>

<h2>Why Choose Roden Law for RSI Claims</h2>
<p>Our workers' compensation attorneys have successfully represented workers with repetitive stress injuries across Georgia and South Carolina. We understand the medical evidence needed to prove these claims and the insurer tactics used to deny them. Contact us for a free consultation — we charge no fee unless we win your case.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Is carpal tunnel syndrome covered by workers\' compensation?',
                'answer'   => 'Yes. Carpal tunnel syndrome and other repetitive stress injuries are covered by workers\' compensation in both Georgia and South Carolina when they arise out of and in the course of employment. Medical evidence linking the condition to your job duties is essential.',
            ),
            array(
                'question' => 'How do I prove my repetitive stress injury is work-related?',
                'answer'   => 'Proof typically requires medical records and physician opinions linking the condition to specific job tasks, a detailed job analysis documenting repetitive motions, ergonomic assessments, and testimony from coworkers performing similar duties who experienced similar symptoms.',
            ),
            array(
                'question' => 'What is the deadline for filing an RSI workers\' comp claim?',
                'answer'   => 'Because RSIs develop gradually, the "date of injury" is typically when you knew or should have known the condition was work-related. In Georgia, you have one year from that date to file (O.C.G.A. § 34-9-82). In South Carolina, the deadline is two years (S.C. Code § 42-15-40).',
            ),
            array(
                'question' => 'Can I get workers\' comp for a repetitive stress injury if I have a pre-existing condition?',
                'answer'   => 'Yes. If your work duties aggravated or accelerated a pre-existing condition, the aggravation is compensable under workers\' comp. You do not need to prove that work was the sole cause — just that it was a contributing factor.',
            ),
            array(
                'question' => 'What if my employer says RSIs are not covered by workers\' comp?',
                'answer'   => 'This is incorrect. Both Georgia and South Carolina recognize repetitive stress injuries as compensable workplace injuries. If your employer or their insurer denies your claim, an attorney can file a formal hearing request to challenge the denial.',
            ),
        ),
    ),

    /* ============================================================
       5. Occupational Disease
       ============================================================ */
    array(
        'title'   => 'Occupational Disease Lawyers',
        'slug'    => 'occupational-disease',
        'excerpt' => 'Diagnosed with an occupational disease from workplace exposure in Georgia or South Carolina? Our attorneys pursue workers\' comp benefits and third-party claims for toxic exposure, lung disease, and occupational cancers.',
        'content' => <<<'HTML'
<h2>Legal Representation for Occupational Disease Claims</h2>
<p>Occupational diseases are illnesses and health conditions caused by exposure to hazardous substances or conditions in the workplace over an extended period. According to the <a href="https://www.cdc.gov/niosh/" target="_blank" rel="noopener">National Institute for Occupational Safety and Health (NIOSH)</a>, millions of American workers are exposed to substances that have been linked to cancer, respiratory disease, neurological damage, and organ failure. Workers in <a href="/workers-compensation-lawyers/factory-manufacturing-injury/">manufacturing</a>, construction, mining, agriculture, healthcare, and the maritime industry face the highest risk.</p>
<p>At Roden Law, our occupational disease lawyers handle complex exposure claims throughout Georgia and South Carolina. These cases require specialized knowledge of toxicology, industrial hygiene, and the medical science linking workplace exposures to specific diseases. We build the evidence needed to overcome the significant challenges these claims present.</p>

<h2>Workers' Compensation for Occupational Diseases</h2>
<p>Georgia law defines an occupational disease as a disease arising out of and in the course of employment that is caused by hazards recognized as peculiar to a particular trade, occupation, or process (<a href="https://law.justia.com/codes/georgia/title-34/chapter-9/article-1/section-34-9-280/" target="_blank" rel="noopener">O.C.G.A. § 34-9-280</a>). South Carolina's occupational disease provision (<a href="https://www.scstatehouse.gov/code/t42c011.php" target="_blank" rel="noopener">S.C. Code § 42-11-10 et seq.</a>) provides similar coverage, defining an occupational disease as one that is due to causes and conditions characteristic of and peculiar to the particular trade, occupation, or employment.</p>
<p>Unlike traumatic injuries with a clear date of occurrence, occupational diseases develop over months or years of exposure. Both states allow claims when the disease becomes manifest and the worker knows or should know it is work-related.</p>

<h2>Common Occupational Diseases</h2>
<p>Our attorneys handle the full spectrum of occupational disease claims, including:</p>
<ul>
<li><strong>Mesothelioma and asbestosis:</strong> Caused by asbestos exposure in construction, shipbuilding, and manufacturing</li>
<li><strong>Occupational asthma:</strong> Triggered by inhaling dust, chemicals, fumes, or biological agents</li>
<li><strong>Silicosis:</strong> Lung disease from inhaling crystalline silica dust in mining, sandblasting, and stonecutting</li>
<li><strong>Occupational cancers:</strong> Bladder, lung, and blood cancers linked to benzene, formaldehyde, and other carcinogens</li>
<li><strong>Hearing loss:</strong> Permanent damage from prolonged noise exposure exceeding safe decibel levels</li>
<li><strong>Lead poisoning:</strong> Neurological damage from exposure in painting, battery manufacturing, and demolition</li>
<li><strong>Dermatitis:</strong> Chronic skin conditions from chemical and irritant exposure</li>
<li><strong>Infectious diseases:</strong> Healthcare workers exposed to bloodborne pathogens, tuberculosis, and COVID-19</li>
</ul>

<h2>Proving an Occupational Disease Claim</h2>
<p>Occupational disease claims require establishing a direct link between workplace exposures and your diagnosed condition. Key evidence includes a complete occupational history documenting all workplace exposures, medical records and diagnostic testing confirming the disease, expert medical testimony on causation, industrial hygiene reports measuring exposure levels, employer safety records and Material Safety Data Sheets (MSDS), and OSHA inspection and citation records. Insurance companies aggressively challenge occupational disease claims, arguing that the illness has non-occupational causes or that exposure levels were too low to cause the condition. Our attorneys work with leading occupational medicine physicians and industrial hygienists to build compelling causation evidence.</p>

<h2>Third-Party Liability in Occupational Disease Cases</h2>
<p>Beyond workers' compensation, occupational disease victims may have claims against manufacturers of toxic chemicals, asbestos products, or hazardous materials, contractors who created exposure conditions, and property owners who failed to remediate known hazards. These <a href="/workers-compensation-lawyers/third-party-workplace-injury/">third-party claims</a> provide access to full compensatory and punitive damages not available through workers' comp.</p>

<h2>Statutes of Limitations for Occupational Disease</h2>
<p>Georgia's statute of limitations for occupational disease claims is one year from the date the employee knew or should have known the disease was occupationally related (O.C.G.A. § 34-9-281). South Carolina allows two years from the date of disability or the date the employee knew or should have known the disease was work-related (S.C. Code § 42-15-40). Because these deadlines can be complex, early consultation with an attorney is critical.</p>

<h2>Why Choose Roden Law for Occupational Disease Claims</h2>
<p>Occupational disease cases are among the most complex workers' compensation claims. Our attorneys combine legal expertise with knowledge of toxicology and occupational medicine to build winning cases. We represent workers throughout Georgia and South Carolina on a contingency fee basis — no fee unless we recover compensation for you.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What qualifies as an occupational disease under workers\' comp?',
                'answer'   => 'An occupational disease is an illness arising out of and caused by conditions peculiar to your particular occupation. It must be caused by workplace exposures rather than ordinary conditions to which the general public is exposed. Examples include mesothelioma, silicosis, and occupational cancers.',
            ),
            array(
                'question' => 'How long do I have to file an occupational disease claim?',
                'answer'   => 'In Georgia, you have one year from when you knew or should have known the disease was work-related (O.C.G.A. § 34-9-281). In South Carolina, the deadline is two years (S.C. Code § 42-15-40). These deadlines run from the date of knowledge, not the date of first exposure.',
            ),
            array(
                'question' => 'Can I file a workers\' comp claim for hearing loss from workplace noise?',
                'answer'   => 'Yes. Occupational hearing loss from prolonged noise exposure is a compensable occupational disease in both Georgia and South Carolina. You will need audiological testing and medical evidence linking the hearing loss to your workplace noise exposure.',
            ),
            array(
                'question' => 'What if my occupational disease was caused by a product used at work?',
                'answer'   => 'You may have both a workers\' comp claim against your employer and a product liability claim against the manufacturer of the toxic substance. The third-party claim can provide additional damages including pain and suffering and punitive damages.',
            ),
            array(
                'question' => 'Does workers\' comp cover cancer caused by workplace chemical exposure?',
                'answer'   => 'Yes, if you can establish that the cancer was caused by workplace exposure to carcinogenic substances. This requires medical evidence, exposure documentation, and often expert testimony linking the specific chemicals to your cancer diagnosis.',
            ),
        ),
    ),

    /* ============================================================
       6. Denied Workers' Comp Claim
       ============================================================ */
    array(
        'title'   => "Denied Workers' Comp Claim Lawyers",
        'slug'    => 'denied-workers-comp-claim',
        'excerpt' => "Had your workers' compensation claim denied in Georgia or South Carolina? Our attorneys challenge wrongful denials and fight to restore the benefits injured workers deserve.",
        'content' => <<<'HTML'
<h2>Fighting Wrongful Workers' Compensation Denials</h2>
<p>Receiving a denial letter for your workers' compensation claim can feel devastating — especially when you are dealing with painful injuries, mounting medical bills, and lost income. Unfortunately, initial claim denials are common. Insurance companies deny workers' comp claims for a variety of reasons, many of which can be successfully challenged through the administrative hearing process. According to industry data, a significant percentage of denied claims are ultimately overturned when workers retain experienced legal representation.</p>
<p>At Roden Law, our workers' comp denial attorneys represent injured workers throughout Georgia and South Carolina whose claims have been wrongfully denied, delayed, or terminated. We understand the appeals process in both states and aggressively fight to restore the benefits our clients are owed.</p>

<h2>Common Reasons Workers' Comp Claims Are Denied</h2>
<p>Insurance companies deny workers' compensation claims for a range of reasons, including:</p>
<ul>
<li><strong>Missed reporting deadlines:</strong> Georgia requires injury reporting within 30 days (<a href="https://law.justia.com/codes/georgia/title-34/chapter-9/article-5/section-34-9-80/" target="_blank" rel="noopener">O.C.G.A. § 34-9-80</a>); South Carolina within 90 days (<a href="https://www.scstatehouse.gov/code/t42c015.php" target="_blank" rel="noopener">S.C. Code § 42-15-20</a>)</li>
<li><strong>Disputed work-relatedness:</strong> The insurer claims the injury did not arise out of employment</li>
<li><strong>Pre-existing conditions:</strong> The insurer attributes your symptoms to a prior condition rather than the workplace incident</li>
<li><strong>Insufficient medical evidence:</strong> Medical records do not adequately document the injury or link it to work</li>
<li><strong>Independent medical examination (IME) disputes:</strong> The insurer's chosen doctor contradicts your treating physician</li>
<li><strong>Employer disputes:</strong> The employer contests the claim, alleging the injury did not occur at work or was caused by horseplay or intoxication</li>
<li><strong>Late filing:</strong> The claim was filed after the statute of limitations — one year in Georgia (O.C.G.A. § 34-9-82), two years in South Carolina (S.C. Code § 42-15-40)</li>
</ul>

<h2>The Georgia Workers' Comp Appeals Process</h2>
<p>If your workers' comp claim is denied in Georgia, you can challenge the denial by filing a WC-14 Request for Hearing with the State Board of Workers' Compensation. The process involves a hearing before an Administrative Law Judge (ALJ) who evaluates medical evidence, witness testimony, and legal arguments. If the ALJ rules against you, further appeals are available to the Appellate Division of the State Board and ultimately to the Superior Court. At every stage, having an experienced attorney significantly improves the likelihood of a favorable outcome.</p>

<h2>The South Carolina Workers' Comp Appeals Process</h2>
<p>In South Carolina, denied claims are heard by the Workers' Compensation Commission. You file a Form 50 to request a hearing before a commissioner. The hearing functions like a mini-trial, with testimony, cross-examination, and documentary evidence. Unfavorable decisions can be appealed to the Full Commission and then to the South Carolina Court of Appeals. South Carolina's process requires strict adherence to procedural rules and evidentiary standards — mistakes can result in the loss of benefits.</p>

<h2>Strategies for Overturning a Denial</h2>
<p>Our attorneys use proven strategies to challenge wrongful denials:</p>
<ul>
<li>Obtaining detailed medical opinions from treating physicians linking the injury to workplace duties</li>
<li>Challenging the insurer's IME doctor with cross-examination and competing expert testimony</li>
<li>Gathering workplace evidence including incident reports, safety records, and witness statements</li>
<li>Demonstrating that pre-existing conditions were aggravated by workplace activities</li>
<li>Filing motions for emergency medical treatment when the denial puts the worker's health at risk</li>
</ul>

<h2>Why Choose Roden Law to Appeal Your Denied Claim</h2>
<p>A denied workers' comp claim is not the end of the road. Our attorneys have extensive experience before the Georgia State Board of Workers' Compensation and the South Carolina Workers' Compensation Commission. We handle every aspect of the appeal, from gathering medical evidence to presenting your case at hearing. There is no fee unless we successfully overturn the denial and secure your benefits. If you have a related <a href="/workers-compensation-lawyers/third-party-workplace-injury/">third-party workplace injury claim</a>, we pursue both avenues simultaneously for maximum recovery.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I appeal a denied workers\' comp claim in Georgia?',
                'answer'   => 'Yes. You can file a WC-14 Request for Hearing with the Georgia State Board of Workers\' Compensation. A hearing before an Administrative Law Judge will evaluate the evidence and determine whether benefits should be awarded.',
            ),
            array(
                'question' => 'How long do I have to appeal a denied workers\' comp claim?',
                'answer'   => 'In Georgia, you should file a hearing request promptly, as the overall statute of limitations is one year from the date of injury or last benefit payment (O.C.G.A. § 34-9-82). In South Carolina, the statute of limitations is two years (S.C. Code § 42-15-40).',
            ),
            array(
                'question' => 'What if the insurance company\'s doctor says I am not injured?',
                'answer'   => 'An independent medical examination (IME) opinion is not binding. Your treating physician\'s opinion carries significant weight, and your attorney can challenge the IME doctor\'s credibility through cross-examination and competing medical evidence.',
            ),
            array(
                'question' => 'Can I still get benefits if I missed the reporting deadline?',
                'answer'   => 'Possibly. Georgia and South Carolina courts recognize exceptions to reporting deadlines, such as when the employer had actual knowledge of the injury or when the employee had good cause for the delay. An attorney can evaluate whether an exception applies to your case.',
            ),
            array(
                'question' => 'Do I need a lawyer to appeal a denied workers\' comp claim?',
                'answer'   => 'While you can represent yourself, the appeals process involves complex procedural rules, evidentiary standards, and legal arguments. Statistics show that workers represented by attorneys are significantly more likely to successfully overturn denials and obtain benefits.',
            ),
        ),
    ),

    /* ============================================================
       7. Third-Party Workplace Injury
       ============================================================ */
    array(
        'title'   => 'Third-Party Workplace Injury Lawyers',
        'slug'    => 'third-party-workplace-injury',
        'excerpt' => 'Injured at work by a negligent third party in Georgia or South Carolina? Our lawyers pursue both workers\' comp benefits and third-party liability claims for maximum recovery beyond the comp system.',
        'content' => <<<'HTML'
<h2>Maximizing Recovery Through Third-Party Workplace Injury Claims</h2>
<p>Workers' compensation provides important benefits to injured workers, but it has significant limitations — it does not cover pain and suffering, does not provide full wage replacement, and does not allow for punitive damages. When a workplace injury is caused in whole or in part by a negligent third party — someone other than your employer or a co-worker — you may be entitled to file a separate personal injury lawsuit that provides access to these additional damages.</p>
<p>At Roden Law, our third-party workplace injury lawyers identify and pursue every available source of compensation for injured workers across Georgia and South Carolina. By combining a workers' comp claim with a third-party lawsuit, we consistently recover significantly more than workers' comp alone would provide.</p>

<h2>What Is a Third-Party Workplace Injury Claim?</h2>
<p>Under Georgia's Workers' Compensation Act (<a href="https://law.justia.com/codes/georgia/title-34/chapter-9/" target="_blank" rel="noopener">O.C.G.A. § 34-9-1 et seq.</a>) and South Carolina's Workers' Compensation Law (<a href="https://www.scstatehouse.gov/code/t42c001.php" target="_blank" rel="noopener">S.C. Code § 42-1-10 et seq.</a>), the exclusive remedy doctrine bars injured employees from suing their own employer for negligence. However, this bar does not extend to third parties whose negligence contributed to the workplace injury. A third-party claim is a standard personal injury lawsuit filed in civil court against these non-employer defendants.</p>

<h2>Common Third-Party Defendants in Workplace Injury Cases</h2>
<p>Third-party claims arise in a wide variety of workplace injury scenarios:</p>
<ul>
<li><strong>Equipment and machinery manufacturers:</strong> Defective tools, machines, or safety devices that malfunction — giving rise to <a href="/practice-areas/product-liability-lawyers/">product liability claims</a></li>
<li><strong>Property owners:</strong> Landowners who maintain unsafe conditions on premises where employees work — a form of <a href="/practice-areas/premises-liability-lawyers/">premises liability</a></li>
<li><strong>General contractors and subcontractors:</strong> On <a href="/workers-compensation-lawyers/construction-worker-injury/">construction sites</a>, multiple contractors share responsibility for safety</li>
<li><strong>Motor vehicle drivers:</strong> Employees injured in <a href="/practice-areas/car-accident-lawyers/">car accidents</a> or <a href="/practice-areas/truck-accident-lawyers/">truck accidents</a> while working have claims against at-fault drivers</li>
<li><strong>Maintenance and repair companies:</strong> Companies hired to service equipment that later malfunctions</li>
<li><strong>Chemical manufacturers and suppliers:</strong> Companies that produce or distribute toxic substances causing <a href="/workers-compensation-lawyers/occupational-disease/">occupational diseases</a></li>
</ul>

<h2>Damages Available in Third-Party Claims</h2>
<p>Unlike workers' compensation, third-party personal injury claims provide access to the full range of compensatory damages, including past and future medical expenses, full lost wages and lost earning capacity (not the two-thirds cap in workers' comp), pain and suffering, emotional distress and mental anguish, loss of enjoyment of life, and punitive damages in cases of egregious negligence or intentional misconduct.</p>
<p>Under Georgia's comparative fault law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>), you can recover damages if you are less than 50% at fault. South Carolina allows recovery if you are less than 51% at fault. Your compensation is reduced by your percentage of fault.</p>

<h2>Workers' Comp Liens and Subrogation</h2>
<p>An important consideration in third-party claims is the workers' comp lien. When you recover compensation from a third party, your employer's workers' comp insurer has a right to reimbursement (subrogation) for benefits already paid. Georgia's subrogation statute (O.C.G.A. § 34-9-11.1) and South Carolina's (S.C. Code § 42-1-560) govern how these liens are calculated and negotiated. Our attorneys negotiate aggressively to reduce the lien amount, maximizing the net recovery that goes into your pocket.</p>

<h2>Statute of Limitations for Third-Party Claims</h2>
<p>Third-party workplace injury claims are subject to the general personal injury statute of limitations: two years in Georgia (O.C.G.A. § 9-3-33) and three years in South Carolina (S.C. Code § 15-3-530). These deadlines are separate from — and often shorter than — the workers' comp filing deadlines, making early legal consultation critical.</p>

<h2>Why Choose Roden Law for Third-Party Workplace Claims</h2>
<p>Our attorneys have deep experience in both workers' compensation and personal injury litigation, allowing us to coordinate both claims for maximum total recovery. We handle the workers' comp claim, the third-party lawsuit, and the lien negotiations simultaneously. There is no fee unless we win your case. Contact us for a free evaluation of your workplace injury case.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is a third-party workplace injury claim?',
                'answer'   => 'A third-party claim is a personal injury lawsuit against someone other than your employer whose negligence caused your workplace injury. This is separate from — and in addition to — your workers\' compensation claim.',
            ),
            array(
                'question' => 'Can I file both a workers\' comp claim and a third-party lawsuit?',
                'answer'   => 'Yes. Workers\' comp covers your employer; the third-party lawsuit targets other negligent parties. Both can proceed simultaneously, and the combined recovery is typically far greater than workers\' comp alone.',
            ),
            array(
                'question' => 'What is a workers\' comp subrogation lien?',
                'answer'   => 'When you receive workers\' comp benefits and then recover damages from a third party, the workers\' comp insurer has a right to be reimbursed from the third-party recovery. Your attorney can negotiate to reduce this lien, increasing your net recovery.',
            ),
            array(
                'question' => 'What is the statute of limitations for a third-party workplace injury claim?',
                'answer'   => 'The personal injury statute of limitations applies: 2 years in Georgia (O.C.G.A. § 9-3-33) and 3 years in South Carolina (S.C. Code § 15-3-530). These deadlines are separate from workers\' comp filing deadlines.',
            ),
            array(
                'question' => 'How much more can I recover with a third-party claim versus workers\' comp alone?',
                'answer'   => 'Third-party claims provide access to pain and suffering, full lost wages, and punitive damages — none of which are available through workers\' comp. Total recovery can be several times greater than workers\' comp benefits alone, depending on the severity of the injury and the degree of third-party negligence.',
            ),
        ),
    ),

    /* ============================================================
       8. Fatal Workplace Accident
       ============================================================ */
    array(
        'title'   => 'Fatal Workplace Accident Lawyers',
        'slug'    => 'fatal-workplace-accident',
        'excerpt' => 'Lost a loved one in a workplace accident in Georgia or South Carolina? Our attorneys pursue workers\' comp death benefits and wrongful death claims to provide financial security for bereaved families.',
        'content' => <<<'HTML'
<h2>Legal Help After a Fatal Workplace Accident</h2>
<p>Losing a family member in a workplace accident is a devastating tragedy. According to the <a href="https://www.bls.gov/iif/oshcfoi1.htm" target="_blank" rel="noopener">Bureau of Labor Statistics Census of Fatal Occupational Injuries</a>, over 5,000 workers are killed on the job in the United States every year — an average of roughly 15 workplace deaths per day. Industries with the highest fatality rates include construction, transportation, agriculture, and manufacturing. Families left behind face not only profound grief but also the sudden loss of income, benefits, and financial security.</p>
<p>At Roden Law, our fatal workplace accident attorneys help grieving families in Georgia and South Carolina navigate the complex intersection of workers' compensation death benefits and <a href="/practice-areas/wrongful-death-lawyers/">wrongful death lawsuits</a>. We pursue every available avenue of compensation to provide financial stability for surviving spouses, children, and dependents.</p>

<h2>Workers' Compensation Death Benefits</h2>
<p>When a worker dies as a result of a workplace injury or occupational disease, their dependents are entitled to workers' compensation death benefits.</p>
<p><strong>Georgia (O.C.G.A. § 34-9-265):</strong> Death benefits are paid to the surviving spouse and dependent children at a rate of two-thirds of the deceased worker's average weekly wage, subject to the maximum weekly benefit. Benefits continue for up to 400 weeks for the spouse (or until remarriage) and for dependent children until age 18 (or 22 if enrolled in postsecondary education). Georgia also provides a burial expense allowance of up to $7,500 (<a href="https://law.justia.com/codes/georgia/title-34/chapter-9/article-6/section-34-9-265/" target="_blank" rel="noopener">O.C.G.A. § 34-9-265</a>).</p>
<p><strong>South Carolina (S.C. Code § 42-9-290):</strong> Death benefits are paid at two-thirds of the deceased worker's average weekly wage to the surviving spouse and dependents for up to 500 weeks. South Carolina provides a burial allowance of up to $2,500 (<a href="https://www.scstatehouse.gov/code/t42c009.php" target="_blank" rel="noopener">S.C. Code § 42-9-290</a>).</p>

<h2>Wrongful Death Lawsuits for Workplace Fatalities</h2>
<p>While workers' comp death benefits provide some financial support, they are limited in amount and do not compensate families for pain and suffering, loss of companionship, or the full financial impact of the death. When a third party's negligence caused or contributed to the fatal workplace accident, families may pursue a separate wrongful death lawsuit under Georgia's Wrongful Death Act (<a href="https://law.justia.com/codes/georgia/title-51/chapter-4/" target="_blank" rel="noopener">O.C.G.A. § 51-4-1 et seq.</a>) or South Carolina's Wrongful Death Act (<a href="https://www.scstatehouse.gov/code/t15c051.php" target="_blank" rel="noopener">S.C. Code § 15-51-10 et seq.</a>).</p>
<p>Wrongful death claims can be filed against negligent third parties including equipment manufacturers, general contractors, property owners, motor vehicle drivers, and maintenance companies. These claims provide access to full compensatory damages including the "full value of the life of the decedent" (in Georgia) and actual and punitive damages (in South Carolina).</p>

<h2>Common Causes of Fatal Workplace Accidents</h2>
<p>The most common causes of workplace fatalities that our attorneys handle include:</p>
<ul>
<li><strong>Falls from heights:</strong> Scaffolding collapses, unguarded roof edges, and ladder failures on <a href="/workers-compensation-lawyers/construction-worker-injury/">construction sites</a></li>
<li><strong>Struck-by incidents:</strong> Workers killed by falling objects, swinging equipment, or moving vehicles</li>
<li><strong>Electrocution:</strong> Contact with overhead power lines, exposed wiring, or improperly grounded equipment</li>
<li><strong>Caught-in/between:</strong> Workers trapped in or between machinery, equipment, or collapsing materials</li>
<li><strong>Vehicle accidents:</strong> <a href="/practice-areas/truck-accident-lawyers/">Commercial vehicle crashes</a> involving workers driving as part of their duties</li>
<li><strong>Explosions and fires:</strong> Chemical explosions, gas leaks, and industrial fires</li>
<li><strong>Toxic exposure:</strong> Acute exposure to lethal concentrations of chemicals or gases</li>
</ul>

<h2>Who Can File a Wrongful Death Claim</h2>
<p>In Georgia, a wrongful death action is brought by the surviving spouse, or if there is no spouse, by the children. If there is no spouse or children, the decedent's parents or the administrator of the estate may file. In South Carolina, the wrongful death action is brought by the personal representative of the estate for the benefit of statutory beneficiaries including the spouse, children, and parents.</p>

<h2>Statute of Limitations for Fatal Workplace Claims</h2>
<p>The wrongful death statute of limitations is two years in Georgia (O.C.G.A. § 9-3-33) and three years in South Carolina (S.C. Code § 15-3-530). Workers' comp death benefit claims must be filed within one year of the date of death in Georgia (O.C.G.A. § 34-9-82) and within two years in South Carolina (S.C. Code § 42-15-40). Acting quickly is essential to preserve all claims.</p>

<h2>Why Choose Roden Law for Fatal Workplace Accident Cases</h2>
<p>Our attorneys handle both workers' comp death benefits and wrongful death lawsuits, ensuring families receive maximum compensation from every available source. We coordinate with OSHA investigators, retain expert witnesses, and manage the complex interaction between workers' comp liens and wrongful death recoveries. There is no fee unless we win. Contact our <a href="/practice-areas/wrongful-death-lawyers/">wrongful death team</a> for a compassionate, free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What workers\' comp death benefits are available in Georgia?',
                'answer'   => 'Georgia provides weekly death benefits to the surviving spouse and dependent children at two-thirds of the deceased worker\'s average weekly wage for up to 400 weeks, plus a burial allowance of up to $7,500 (O.C.G.A. § 34-9-265).',
            ),
            array(
                'question' => 'Can we file a wrongful death lawsuit in addition to a workers\' comp claim?',
                'answer'   => 'Yes. If a third party\'s negligence caused the fatal workplace accident, the family can file a separate wrongful death lawsuit. This provides access to full compensatory damages — including pain and suffering and loss of companionship — that are not available through workers\' comp.',
            ),
            array(
                'question' => 'Who can file a wrongful death claim for a workplace fatality in Georgia?',
                'answer'   => 'In Georgia, the surviving spouse has the right to file a wrongful death action. If there is no surviving spouse, the children may file. If there is no spouse or children, the parents or the estate administrator may bring the claim (O.C.G.A. § 51-4-2).',
            ),
            array(
                'question' => 'How long do we have to file a wrongful death claim for a workplace accident?',
                'answer'   => 'The wrongful death statute of limitations is 2 years in Georgia (O.C.G.A. § 9-3-33) and 3 years in South Carolina (S.C. Code § 15-3-530). Workers\' comp death benefit claims have shorter deadlines: 1 year in Georgia and 2 years in South Carolina.',
            ),
            array(
                'question' => 'Does OSHA investigate fatal workplace accidents?',
                'answer'   => 'Yes. OSHA requires employers to report workplace fatalities within 8 hours. OSHA conducts investigations and may issue citations and penalties. OSHA investigation findings can serve as valuable evidence in both workers\' comp and wrongful death cases.',
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
