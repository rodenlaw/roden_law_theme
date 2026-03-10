<?php
/**
 * Seeder: 8 Construction Accident Sub-Type Pages
 *
 * Creates 8 child posts under the construction-accident-lawyers pillar, each
 * covering a specific type of construction site accident.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-construction-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: construction-accident-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'construction-accident-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'construction-accident-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "construction-accident-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'construction-accidents', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Construction Accidents', 'practice_category', array( 'slug' => 'construction-accidents' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Scaffold and Ladder Fall
       ============================================================ */
    array(
        'title'   => 'Scaffold and Ladder Fall Lawyers',
        'slug'    => 'scaffold-ladder-fall',
        'excerpt' => 'Fell from a scaffold or ladder on a construction site in Georgia or South Carolina? Our attorneys pursue workers\' compensation and third-party negligence claims for fall injuries caused by unsafe equipment and OSHA violations.',
        'content' => <<<'HTML'
<h2>Scaffold &amp; Ladder Fall Injury Claims</h2>
<p>Falls from scaffolds and ladders are the leading cause of death and serious injury in the construction industry. OSHA identifies falls as the number one killer of construction workers, and scaffolding-related accidents alone account for thousands of injuries each year. According to the <a href="https://www.bls.gov/iif/" target="_blank" rel="noopener">Bureau of Labor Statistics</a>, falls, slips, and trips are the most frequently cited cause of fatal workplace injuries in construction. Workers who survive scaffold and ladder falls often face <a href="/brain-injury-lawyers/">traumatic brain injuries</a>, <a href="/spinal-cord-injury-lawyers/">spinal cord injuries</a>, multiple fractures, and permanent disability.</p>
<p>At Roden Law, our scaffold and ladder fall attorneys represent injured construction workers throughout Georgia and South Carolina. We pursue both <a href="/workers-compensation-lawyers/">workers' compensation benefits</a> and third-party negligence claims to maximize recovery for fall victims.</p>

<h2>OSHA Scaffold and Ladder Standards</h2>
<p>OSHA's construction safety standards establish detailed requirements for scaffolds and ladders on construction sites:</p>
<ul>
<li><strong>Scaffold standards (29 CFR 1926.451):</strong> Require guardrails on all open sides of scaffolds 10 feet or more above the ground, mandate competent person inspections before each shift, establish load capacity requirements, and require proper access to scaffold platforms</li>
<li><strong>Ladder standards (29 CFR 1926.1053):</strong> Require ladders to extend at least 3 feet above landing surfaces, mandate non-slip surfaces, prohibit defective ladders, and establish proper setup angles (4-to-1 ratio for straight ladders)</li>
<li><strong>Fall protection standards (29 CFR 1926.502):</strong> Require fall protection systems — guardrails, safety nets, or personal fall arrest systems — for workers at heights of 6 feet or more in construction</li>
</ul>
<p>Scaffold violations are consistently among <a href="https://www.osha.gov/top10citedstandards" target="_blank" rel="noopener">OSHA's most frequently cited standards</a>. These violations constitute strong evidence of negligence in fall injury claims.</p>

<h2>Common Causes of Scaffold &amp; Ladder Falls</h2>
<p>Scaffold and ladder falls on construction sites typically result from:</p>
<ul>
<li><strong>Missing guardrails:</strong> Scaffolds erected without required guardrails, midrails, and toeboards</li>
<li><strong>Improper scaffold assembly:</strong> Unstable foundations, missing cross-braces, and overloaded platforms</li>
<li><strong>Defective ladders:</strong> Broken rungs, bent side rails, and worn non-slip feet</li>
<li><strong>Inadequate fall protection:</strong> No harnesses, lanyards, or anchor points provided</li>
<li><strong>Weather conditions:</strong> Wet, icy, or windy conditions making scaffold and ladder use unsafe</li>
<li><strong>Lack of training:</strong> Workers not trained on safe scaffold access and ladder use</li>
</ul>

<h2>Workers' Compensation &amp; Third-Party Claims</h2>
<p>Georgia's workers' compensation system (<a href="https://law.justia.com/codes/georgia/title-34/chapter-9/" target="_blank" rel="noopener">O.C.G.A. § 34-9-1 et seq.</a>) provides medical benefits and wage replacement for injured construction workers regardless of fault. South Carolina's system operates similarly. However, workers' comp does not cover pain and suffering or full damages.</p>
<p>Critical third-party claims may be available against general contractors who controlled the job site and failed to enforce safety standards, scaffold manufacturers or suppliers who provided <a href="/construction-accident-lawyers/defective-construction-equipment/">defective equipment</a>, property owners who maintained unsafe conditions, and subcontractors whose negligence created fall hazards. These third-party claims allow recovery of full damages including pain and suffering, which workers' comp does not provide.</p>

<h2>Pursuing Maximum Compensation</h2>
<p>Scaffold and ladder fall victims may recover workers' compensation benefits covering medical treatment and wage replacement, plus third-party damages for pain and suffering, permanent disability, disfigurement, emotional distress, and reduced earning capacity. Georgia's comparative fault rule (O.C.G.A. § 51-12-33) allows recovery if less than 50% at fault. South Carolina permits recovery if less than 51% at fault. Our attorneys investigate OSHA citations, inspection reports, and equipment maintenance records to build the strongest possible case. Contact Roden Law for a free consultation — no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What are OSHA\'s requirements for scaffold safety?',
                'answer'   => 'OSHA (29 CFR 1926.451) requires guardrails on scaffolds 10+ feet high, competent person inspections before each shift, proper scaffold construction and load ratings, safe access via ladders or stairways, and fall protection for all workers on scaffolds.',
            ),
            array(
                'question' => 'Can I sue my employer for a scaffold fall?',
                'answer'   => 'Generally, workers\' compensation is your exclusive remedy against your employer. However, you can file third-party claims against general contractors, scaffold manufacturers, property owners, and other parties whose negligence caused your fall.',
            ),
            array(
                'question' => 'What if the scaffold was improperly assembled?',
                'answer'   => 'If the scaffold was improperly erected — missing guardrails, unstable foundation, improper bracing — the general contractor, scaffold erector, and scaffold supplier may all face liability. OSHA requires a "competent person" to supervise scaffold assembly.',
            ),
            array(
                'question' => 'How long do I have to file a construction fall injury claim?',
                'answer'   => 'Workers\' compensation deadlines are 1 year in Georgia (O.C.G.A. § 34-9-82) and 2 years in South Carolina. Personal injury claims have a 2-year deadline in Georgia (O.C.G.A. § 9-3-33) and 3-year deadline in South Carolina (S.C. Code § 15-3-530).',
            ),
            array(
                'question' => 'What compensation is available for a scaffold fall?',
                'answer'   => 'Workers\' comp provides medical benefits and wage replacement. Third-party claims can provide additional compensation for pain and suffering, permanent disability, disfigurement, emotional distress, and full lost earning capacity.',
            ),
        ),
    ),

    /* ============================================================
       2. Crane and Heavy Equipment Accident
       ============================================================ */
    array(
        'title'   => 'Crane and Heavy Equipment Accident Lawyers',
        'slug'    => 'crane-heavy-equipment-accident',
        'excerpt' => 'Injured in a crane or heavy equipment accident on a construction site in Georgia or South Carolina? Our attorneys hold contractors, equipment owners, and manufacturers accountable for equipment-related injuries.',
        'content' => <<<'HTML'
<h2>Crane &amp; Heavy Equipment Accident Claims</h2>
<p>Crane collapses, excavator accidents, and heavy equipment failures are among the most catastrophic incidents on construction sites. The enormous forces involved — cranes can lift hundreds of tons and excavators weigh tens of thousands of pounds — mean that equipment accidents frequently result in fatal or life-altering injuries. According to <a href="https://www.osha.gov/cranes-derricks" target="_blank" rel="noopener">OSHA</a>, crane-related incidents cause dozens of worker fatalities each year, with many more serious injuries going unreported.</p>
<p>At Roden Law, our crane and heavy equipment accident attorneys represent injured workers and bystanders throughout Georgia and South Carolina. We investigate equipment failures, operator errors, and safety violations to hold every responsible party accountable.</p>

<h2>Types of Heavy Equipment Accidents</h2>
<p>Construction sites use a vast array of heavy machinery, each presenting unique hazards:</p>
<ul>
<li><strong>Crane collapses and tip-overs:</strong> Overloading, improper setup, high winds, and ground instability causing cranes to collapse</li>
<li><strong>Struck-by incidents:</strong> Workers hit by crane loads, excavator buckets, backhoe arms, or <a href="/construction-accident-lawyers/falling-object-injury/">falling objects</a> from equipment</li>
<li><strong>Caught-in/between hazards:</strong> Workers crushed between heavy equipment and fixed structures or pinned by moving components</li>
<li><strong>Rollover accidents:</strong> Bulldozers, forklifts, and loaders overturning on uneven terrain</li>
<li><strong>Electrocution:</strong> Cranes and aerial lifts contacting <a href="/construction-accident-lawyers/electrocution-construction-site/">overhead power lines</a></li>
<li><strong>Hydraulic failures:</strong> Sudden loss of hydraulic pressure causing booms, buckets, and platforms to drop without warning</li>
</ul>

<h2>OSHA Heavy Equipment Standards</h2>
<p>OSHA's crane and derrick standards for construction (29 CFR 1926 Subpart CC) establish comprehensive safety requirements including certified and licensed crane operators, pre-operation inspections of all equipment, load capacity calculations and load chart compliance, ground condition assessments for crane setup, minimum clearance distances from power lines, signal person requirements for crane operations, and regular equipment maintenance and inspection records.</p>
<p>Additional OSHA standards govern excavation safety (29 CFR 1926 Subpart P), earthmoving equipment (29 CFR 1926 Subpart O), and general equipment safety. Violations of these standards are powerful evidence of negligence in injury claims.</p>

<h2>Determining Liability</h2>
<p>Crane and heavy equipment accidents frequently involve multiple responsible parties:</p>
<ul>
<li><strong>General contractors:</strong> Overall site safety responsibility and OSHA compliance obligations</li>
<li><strong>Crane and equipment operators:</strong> Duty to operate safely and within equipment specifications</li>
<li><strong>Equipment owners and rental companies:</strong> Duty to maintain equipment and ensure proper inspection</li>
<li><strong>Equipment manufacturers:</strong> Liability for <a href="/construction-accident-lawyers/defective-construction-equipment/">design and manufacturing defects</a> under <a href="/product-liability-lawyers/">product liability law</a></li>
<li><strong>Subcontractors:</strong> Responsibility for their work areas and equipment</li>
<li><strong>Property owners:</strong> Potential liability for site conditions and contractor selection</li>
</ul>

<h2>Pursuing Maximum Compensation</h2>
<p>Victims of crane and heavy equipment accidents may pursue <a href="/workers-compensation-lawyers/">workers' compensation benefits</a> for medical treatment and wage replacement, plus third-party negligence claims for pain and suffering, permanent disability, disfigurement, emotional distress, and full lost earning capacity. Under Georgia law (O.C.G.A. § 51-12-33), recovery is available if less than 50% at fault. South Carolina permits recovery if less than 51% at fault. In cases involving fatal injuries, surviving family members may file <a href="/wrongful-death-lawyers/">wrongful death claims</a>. Our attorneys work with crane engineers, accident reconstructionists, and OSHA compliance experts to build compelling cases for maximum recovery. Contact Roden Law for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who is liable for a crane collapse on a construction site?',
                'answer'   => 'Multiple parties may be liable: the general contractor for site safety, the crane operator for operational errors, the crane owner/rental company for maintenance failures, and the manufacturer for equipment defects. OSHA investigation findings help establish responsibility.',
            ),
            array(
                'question' => 'Does OSHA require crane operators to be licensed?',
                'answer'   => 'Yes. OSHA\'s crane standard (29 CFR 1926 Subpart CC) requires crane operators in construction to be certified by an accredited testing organization. Employers must also ensure operators are qualified for the specific type of crane being used.',
            ),
            array(
                'question' => 'Can a bystander injured by a crane collapse sue?',
                'answer'   => 'Yes. Unlike employees who are generally limited to workers\' compensation, bystanders and members of the public can file full personal injury lawsuits against all responsible parties, recovering complete damages including pain and suffering.',
            ),
            array(
                'question' => 'What if the heavy equipment was rented?',
                'answer'   => 'Equipment rental companies may be liable if they rented defective equipment, failed to conduct proper inspections, or rented to unqualified operators. The rental agreement does not necessarily shield the rental company from liability for injuries.',
            ),
            array(
                'question' => 'How long do I have to file a crane accident claim?',
                'answer'   => 'Workers\' compensation deadlines are 1 year in Georgia (O.C.G.A. § 34-9-82) and 2 years in South Carolina. Personal injury claims have a 2-year deadline in Georgia (O.C.G.A. § 9-3-33) and 3 years in South Carolina (S.C. Code § 15-3-530).',
            ),
        ),
    ),

    /* ============================================================
       3. Electrocution on Construction Site
       ============================================================ */
    array(
        'title'   => 'Electrocution on Construction Site Lawyers',
        'slug'    => 'electrocution-construction-site',
        'excerpt' => 'Electrocuted on a construction site in Georgia or South Carolina? Our attorneys pursue workers\' compensation and third-party claims against contractors, power companies, and equipment manufacturers for electrical injuries.',
        'content' => <<<'HTML'
<h2>Construction Site Electrocution Claims</h2>
<p>Electrocution is one of OSHA's "Fatal Four" — the four leading causes of death in the construction industry, along with falls, struck-by incidents, and caught-in/between hazards. The <a href="https://www.bls.gov/iif/" target="_blank" rel="noopener">Bureau of Labor Statistics</a> reports that construction workers suffer hundreds of fatal and non-fatal electrocution injuries annually. Contact with overhead power lines, exposed wiring, and improperly grounded equipment creates lethal hazards on construction sites throughout Georgia and South Carolina.</p>
<p>At Roden Law, our construction site electrocution attorneys represent workers and their families in both <a href="/workers-compensation-lawyers/">workers' compensation claims</a> and third-party negligence lawsuits. Electrocution injuries — including <a href="/burn-injury-lawyers/electrical-burn-injury/">electrical burns</a>, cardiac arrest, nerve damage, and amputations — can be permanently disabling or fatal, and our attorneys pursue every available source of compensation.</p>

<h2>Common Causes of Construction Site Electrocutions</h2>
<p>Construction site electrocution incidents typically result from preventable hazards:</p>
<ul>
<li><strong>Overhead power line contact:</strong> Cranes, aerial lifts, scaffolding, and long materials (pipes, ladders, rebar) contacting energized overhead lines</li>
<li><strong>Exposed wiring:</strong> Damaged insulation, improper splices, and exposed conductors on temporary electrical systems</li>
<li><strong>Improperly grounded equipment:</strong> Power tools and equipment lacking proper grounding or GFCI protection</li>
<li><strong>Underground utilities:</strong> Excavation striking buried electrical lines that were not properly located and marked</li>
<li><strong>Damaged extension cords:</strong> Frayed, cut, or improperly repaired cords used in wet conditions</li>
<li><strong>Inadequate lockout/tagout:</strong> Working on electrical systems that were not properly de-energized and locked out</li>
</ul>

<h2>OSHA Electrical Safety Standards for Construction</h2>
<p>OSHA's construction electrical standards (29 CFR 1926 Subpart K) and general electrical safety requirements establish critical protections:</p>
<ul>
<li>Minimum clearance distances from overhead power lines (varies by voltage, minimum 10 feet for lines under 50kV)</li>
<li>Ground-fault circuit interrupter (GFCI) protection for all temporary wiring on construction sites</li>
<li>Lockout/tagout (LOTO) procedures (29 CFR 1910.147) before working on electrical systems</li>
<li>Assured equipment grounding conductor program as an alternative to GFCI</li>
<li>Proper training for workers exposed to electrical hazards</li>
<li>Use of insulated tools and personal protective equipment</li>
</ul>
<p>Violations of these standards constitute evidence of negligence and may support both workers' compensation claims and third-party lawsuits.</p>

<h2>Electrocution Injuries &amp; Complications</h2>
<p>Electrical current passing through the body causes devastating injuries that extend far beyond visible <a href="/burn-injury-lawyers/">burn marks</a>: cardiac arrest and arrhythmias, severe entry and exit wound burns, internal tissue destruction along the current's path, nerve damage and chronic neuropathic pain, <a href="/brain-injury-lawyers/">traumatic brain injury</a> from cardiac arrest or falls, compartment syndrome requiring emergency surgery, rhabdomyolysis and kidney failure, and amputation of affected limbs. Many electrocution complications — including cataracts, neurological disorders, and cardiac problems — may not manifest until weeks or months after the initial injury.</p>

<h2>Liability in Construction Electrocution Cases</h2>
<p>Multiple parties may bear responsibility for construction site electrocutions: general contractors who failed to implement electrical safety programs, subcontractors who created or ignored electrical hazards, power utility companies that failed to de-energize or relocate lines when requested, equipment manufacturers whose <a href="/construction-accident-lawyers/defective-construction-equipment/">defective products</a> lacked proper insulation or grounding, and property owners who failed to disclose known electrical hazards. Georgia's comparative fault statute (O.C.G.A. § 51-12-33) allows recovery if less than 50% at fault. South Carolina permits recovery if less than 51% at fault. Our attorneys investigate OSHA citations, utility company records, and equipment specifications to identify all liable parties. Contact Roden Law for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the most common cause of construction site electrocutions?',
                'answer'   => 'Contact with overhead power lines is the leading cause of construction electrocution deaths. OSHA requires minimum clearance distances of at least 10 feet from power lines under 50kV, with greater distances for higher-voltage lines.',
            ),
            array(
                'question' => 'Can I sue a power company for a construction site electrocution?',
                'answer'   => 'Yes. Power companies may be liable if they failed to de-energize lines upon request, failed to relocate lines near construction activity, or failed to install protective covers. They have a duty to respond to safety requests from contractors working near their lines.',
            ),
            array(
                'question' => 'What is OSHA\'s lockout/tagout requirement?',
                'answer'   => 'Lockout/tagout (29 CFR 1910.147) requires that electrical systems be completely de-energized, locked out, and tagged before any worker performs maintenance or construction work on them. Failure to follow LOTO procedures is a leading cause of electrocution.',
            ),
            array(
                'question' => 'Are electrocution injuries covered by workers\' compensation?',
                'answer'   => 'Yes. On-the-job electrocution injuries are covered by workers\' comp in Georgia (O.C.G.A. § 34-9-1) and South Carolina. Third-party claims against general contractors, power companies, and equipment manufacturers may also provide additional compensation.',
            ),
            array(
                'question' => 'What if my family member was killed by electrocution on a construction site?',
                'answer'   => 'Surviving family members may file wrongful death claims against responsible third parties and receive workers\' compensation death benefits. Georgia (O.C.G.A. § 51-4-1) and South Carolina both allow wrongful death actions for fatal electrocutions.',
            ),
        ),
    ),

    /* ============================================================
       4. Trench Collapse
       ============================================================ */
    array(
        'title'   => 'Trench Collapse Lawyers',
        'slug'    => 'trench-collapse',
        'excerpt' => 'Injured in a trench collapse on a construction site in Georgia or South Carolina? Our attorneys hold contractors accountable for OSHA trenching violations that cause cave-in injuries and deaths.',
        'content' => <<<'HTML'
<h2>Trench Collapse Injury Claims in Georgia &amp; South Carolina</h2>
<p>Trench collapses are among the deadliest hazards in the construction industry. A single cubic yard of soil weighs approximately 3,000 pounds — enough to crush and suffocate a worker in minutes. <a href="https://www.osha.gov/trenching" target="_blank" rel="noopener">OSHA</a> reports that trench cave-ins kill dozens of workers annually, and these deaths are almost entirely preventable through proper protective systems. Despite OSHA's clear trenching and excavation standards, contractors continue to send workers into unprotected trenches, resulting in catastrophic injuries and deaths.</p>
<p>At Roden Law, our trench collapse attorneys represent injured workers and families of workers killed in trench cave-ins throughout Georgia and South Carolina. These cases frequently involve egregious OSHA violations that support both <a href="/workers-compensation-lawyers/">workers' compensation claims</a> and third-party negligence lawsuits with potential punitive damages.</p>

<h2>OSHA Trenching and Excavation Standards</h2>
<p>OSHA's excavation standard (29 CFR 1926 Subpart P) establishes mandatory safety requirements for all trenching and excavation work:</p>
<ul>
<li><strong>Protective systems required:</strong> Trenches 5 feet or deeper must use sloping, shoring, or trench boxes to prevent cave-ins</li>
<li><strong>Competent person inspections:</strong> A qualified person must inspect trench conditions before each shift and after rain, vibration, or other changes</li>
<li><strong>Soil classification:</strong> Soil must be classified (Type A, B, or C) to determine appropriate protective measures</li>
<li><strong>Means of egress:</strong> Ladders, steps, or ramps must be within 25 feet of workers in trenches 4+ feet deep</li>
<li><strong>Spoil pile placement:</strong> Excavated material must be kept at least 2 feet from the trench edge</li>
<li><strong>Water accumulation:</strong> Procedures must address water in trenches and dewatering equipment</li>
<li><strong>Underground utilities:</strong> All utility lines must be located before excavation begins</li>
</ul>

<h2>Common Causes of Trench Collapses</h2>
<p>Trench cave-ins are almost always preventable. The most common causes include:</p>
<ul>
<li><strong>No protective system:</strong> Working in unshored, unsloped trenches without trench boxes</li>
<li><strong>Improper shoring:</strong> Protective systems inadequate for soil type, trench depth, or conditions</li>
<li><strong>Failure to inspect:</strong> No competent person evaluating trench conditions before work begins</li>
<li><strong>Vibration from equipment:</strong> Heavy equipment operating too close to trench edges, destabilizing walls</li>
<li><strong>Water saturation:</strong> Rain or groundwater weakening trench walls</li>
<li><strong>Overloaded trench edges:</strong> Spoil piles, equipment, or materials placed too close to the edge</li>
</ul>

<h2>Injuries from Trench Collapses</h2>
<p>Workers trapped in trench collapses face immediate life-threatening injuries: suffocation and asphyxiation from the weight of soil on the chest, crush injuries to internal organs, <a href="/spinal-cord-injury-lawyers/">spinal cord injuries</a> and paralysis, broken bones and fractures throughout the body, <a href="/brain-injury-lawyers/">traumatic brain injury</a> from oxygen deprivation, and hypothermia during prolonged burial. Rescue operations for buried workers are extremely complex and dangerous — secondary collapses frequently injure rescue workers as well. Even workers who survive trench collapses often face permanent disabilities and long-term psychological trauma.</p>

<h2>Pursuing a Trench Collapse Claim</h2>
<p>Trench collapse cases often involve clear OSHA violations that support strong negligence claims against general contractors who failed to require protective systems, excavation subcontractors who ignored OSHA standards, competent persons who failed to inspect and classify soil conditions, equipment operators whose actions destabilized trench walls, and property owners who hired unqualified contractors. Georgia law (O.C.G.A. § 51-12-33) allows recovery if less than 50% at fault. South Carolina allows recovery if less than 51% at fault. Punitive damages may be available when contractors knowingly sent workers into unprotected trenches. In fatal trench collapses, <a href="/wrongful-death-lawyers/">wrongful death claims</a> provide additional remedies for surviving families. Contact Roden Law for a free consultation — our attorneys fight for maximum accountability.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'How deep does a trench have to be before OSHA requires protection?',
                'answer'   => 'OSHA requires protective systems (sloping, shoring, or trench boxes) for all trenches 5 feet or deeper, unless the excavation is made entirely in stable rock. For trenches 20 feet or deeper, a registered professional engineer must design the protective system.',
            ),
            array(
                'question' => 'Who is responsible for trench safety on a construction site?',
                'answer'   => 'The general contractor, excavation subcontractor, and designated "competent person" all share responsibility. OSHA requires a competent person to inspect trench conditions daily and after any change in conditions. The general contractor has overall site safety obligations.',
            ),
            array(
                'question' => 'Can I receive punitive damages for a trench collapse injury?',
                'answer'   => 'Possibly. If the contractor knowingly violated OSHA trenching standards — for example, by sending workers into an unshored trench to save time and money — courts may award punitive damages for willful and wanton disregard for worker safety.',
            ),
            array(
                'question' => 'What should I do if I witness a trench collapse?',
                'answer'   => 'Call 911 immediately. Do not enter the trench — secondary collapses are common and can bury rescuers. Keep others away from the trench edges. Professional rescue teams with specialized equipment are needed for safe extraction.',
            ),
            array(
                'question' => 'How long do I have to file a trench collapse injury claim?',
                'answer'   => 'Workers\' comp deadlines are 1 year in Georgia (O.C.G.A. § 34-9-82) and 2 years in South Carolina. Personal injury claims have a 2-year deadline in Georgia (O.C.G.A. § 9-3-33) and 3 years in South Carolina (S.C. Code § 15-3-530).',
            ),
        ),
    ),

    /* ============================================================
       5. Falling Object Injury
       ============================================================ */
    array(
        'title'   => 'Falling Object Injury Lawyers',
        'slug'    => 'falling-object-injury',
        'excerpt' => 'Struck by a falling object on a construction site in Georgia or South Carolina? Our attorneys pursue workers\' compensation and third-party claims for injuries caused by falling tools, materials, and debris.',
        'content' => <<<'HTML'
<h2>Falling Object Injury Claims on Construction Sites</h2>
<p>Struck-by incidents involving falling objects are one of OSHA's "Fatal Four" — the four most common causes of construction worker fatalities. Tools, building materials, structural components, and debris falling from heights can strike workers with tremendous force, causing <a href="/brain-injury-lawyers/">traumatic brain injuries</a>, skull fractures, <a href="/spinal-cord-injury-lawyers/">spinal cord injuries</a>, and death. According to the <a href="https://www.bls.gov/iif/" target="_blank" rel="noopener">Bureau of Labor Statistics</a>, struck-by hazards account for a significant percentage of all construction fatalities and serious injuries each year.</p>
<p>At Roden Law, our falling object injury attorneys represent construction workers and bystanders who are struck by falling items on or near construction sites throughout Georgia and South Carolina. We pursue <a href="/workers-compensation-lawyers/">workers' compensation benefits</a> and third-party negligence claims to ensure victims receive full compensation.</p>

<h2>Common Falling Object Hazards on Construction Sites</h2>
<p>Falling object injuries on construction sites result from a variety of preventable hazards:</p>
<ul>
<li><strong>Unsecured tools and equipment:</strong> Hand tools, power tools, and small equipment dropped from <a href="/construction-accident-lawyers/scaffold-ladder-fall/">scaffolds, ladders</a>, and elevated platforms</li>
<li><strong>Building materials:</strong> Lumber, steel beams, concrete blocks, and roofing materials falling during lifting and placement</li>
<li><strong>Crane load drops:</strong> <a href="/construction-accident-lawyers/crane-heavy-equipment-accident/">Crane rigging failures</a>, improper load securement, and overloading causing loads to drop</li>
<li><strong>Demolition debris:</strong> Uncontrolled falling of structural elements during demolition work</li>
<li><strong>Overhead work:</strong> Materials and debris falling from <a href="/construction-accident-lawyers/roofing-accident/">roofing operations</a> and upper floors</li>
<li><strong>Stacked materials:</strong> Improperly stacked lumber, pipe, or materials toppling over</li>
</ul>

<h2>OSHA Standards for Falling Object Protection</h2>
<p>OSHA's construction standards require comprehensive protections against falling objects:</p>
<ul>
<li><strong>Hard hat requirements (29 CFR 1926.100):</strong> All workers exposed to falling object hazards must wear approved hard hats</li>
<li><strong>Toe boards on scaffolds (29 CFR 1926.451):</strong> Scaffolds must have toeboards on all open sides to prevent tools and materials from falling</li>
<li><strong>Overhead protection (29 CFR 1926.451):</strong> Workers below scaffolds must be protected by debris nets, canopies, or barricades</li>
<li><strong>Tool lanyards and tethering:</strong> Tools used at heights should be tethered to prevent drops</li>
<li><strong>Controlled access zones:</strong> Areas below overhead work must be barricaded to prevent pedestrian access</li>
<li><strong>Proper material hoisting:</strong> Materials must be properly rigged and secured for lifting operations</li>
</ul>

<h2>Injuries from Falling Objects</h2>
<p>The severity of falling object injuries depends on the weight of the object, the height from which it fell, and whether the victim was wearing protective equipment. Common injuries include <a href="/brain-injury-lawyers/">traumatic brain injuries</a> and concussions even through hard hats, skull fractures, cervical and <a href="/spinal-cord-injury-lawyers/">spinal cord injuries</a>, broken bones in the shoulders, arms, and hands, crush injuries, eye injuries and blindness, and fatal injuries from heavy objects falling from significant heights.</p>

<h2>Pursuing a Falling Object Injury Claim</h2>
<p>Liability for falling object injuries may rest with general contractors who failed to implement overhead protection measures, subcontractors performing overhead work without proper safeguards, crane operators and rigging crews responsible for load drops, equipment manufacturers whose <a href="/construction-accident-lawyers/defective-construction-equipment/">defective products</a> failed (slings, shackles, hoisting devices), and property owners who failed to protect the public from construction hazards. Georgia law (O.C.G.A. § 51-12-33) allows recovery if less than 50% at fault. South Carolina allows recovery if less than 51% at fault. Our attorneys investigate site conditions, OSHA citations, and contractor safety programs to identify all responsible parties. Contact Roden Law for a free consultation — no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Is my employer liable if I was hit by a falling tool on a construction site?',
                'answer'   => 'Your employer is covered by workers\' compensation, which provides medical and wage benefits regardless of fault. Third-party claims against general contractors, subcontractors doing the overhead work, or tool manufacturers may provide additional compensation.',
            ),
            array(
                'question' => 'What OSHA standards protect workers from falling objects?',
                'answer'   => 'OSHA requires hard hats (29 CFR 1926.100), toeboards on scaffolds (29 CFR 1926.451), overhead protection such as debris nets, barricading areas below overhead work, and proper material handling procedures. Violations are evidence of negligence.',
            ),
            array(
                'question' => 'Can a pedestrian sue for a falling object from a construction site?',
                'answer'   => 'Yes. Pedestrians and members of the public injured by falling construction debris can file personal injury lawsuits against the general contractor, subcontractors, and property owner. They are not limited to workers\' compensation.',
            ),
            array(
                'question' => 'What if I was wearing a hard hat but still got injured?',
                'answer'   => 'Hard hats protect against some falling objects but have limitations. If you were injured despite wearing a hard hat, you still have valid claims. The fact that you wore safety equipment demonstrates you were following safety rules.',
            ),
            array(
                'question' => 'How long do I have to file a falling object injury claim?',
                'answer'   => 'Workers\' comp deadlines are 1 year in Georgia (O.C.G.A. § 34-9-82) and 2 years in South Carolina. Personal injury claims allow 2 years in Georgia (O.C.G.A. § 9-3-33) and 3 years in South Carolina (S.C. Code § 15-3-530).',
            ),
        ),
    ),

    /* ============================================================
       6. Defective Construction Equipment
       ============================================================ */
    array(
        'title'   => 'Defective Construction Equipment Lawyers',
        'slug'    => 'defective-construction-equipment',
        'excerpt' => 'Injured by defective construction equipment in Georgia or South Carolina? Our attorneys hold equipment manufacturers, distributors, and rental companies strictly liable for injuries caused by dangerous tools and machinery.',
        'content' => <<<'HTML'
<h2>Defective Construction Equipment Injury Claims</h2>
<p>Construction workers rely on a vast array of tools and equipment — from hand tools and power tools to heavy machinery and safety systems — to perform their jobs. When this equipment is defective, the consequences can be catastrophic. Manufacturing defects, design flaws, and inadequate warnings cause tools to malfunction, safety systems to fail, and heavy equipment to behave unpredictably. Under <a href="/product-liability-lawyers/">product liability law</a>, manufacturers and distributors of defective construction equipment can be held strictly liable for the injuries their products cause.</p>
<p>At Roden Law, our defective construction equipment attorneys represent injured workers across Georgia and South Carolina in product liability claims against equipment manufacturers, component part suppliers, distributors, and rental companies. These claims provide compensation beyond workers' compensation benefits, including pain and suffering and punitive damages.</p>

<h2>Common Defective Equipment Claims</h2>
<p>Our attorneys handle construction equipment defect cases involving:</p>
<ul>
<li><strong>Power tool defects:</strong> Circular saws, nail guns, grinders, and drills with defective guards, triggers, or safety mechanisms</li>
<li><strong>Heavy equipment failures:</strong> <a href="/construction-accident-lawyers/crane-heavy-equipment-accident/">Cranes, excavators, and forklifts</a> with hydraulic failures, braking defects, or stability issues</li>
<li><strong>Fall protection failures:</strong> Defective harnesses, lanyards, self-retracting lifelines, and anchor points that fail during a fall</li>
<li><strong>Scaffold component defects:</strong> <a href="/construction-accident-lawyers/scaffold-ladder-fall/">Defective scaffold frames, planks, couplers, and base plates</a></li>
<li><strong>Ladder defects:</strong> Structural failures, defective locking mechanisms, and inadequate non-slip feet</li>
<li><strong>Electrical equipment:</strong> <a href="/construction-accident-lawyers/electrocution-construction-site/">Tools and equipment</a> with inadequate insulation or grounding defects</li>
<li><strong>Personal protective equipment:</strong> Defective hard hats, safety glasses, gloves, and respiratory protection</li>
</ul>

<h2>Product Liability Law in Georgia &amp; South Carolina</h2>
<p>Georgia's product liability statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-3/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>) holds manufacturers strictly liable for injuries caused by defective products. This means injured workers do not need to prove negligence — only that the product was defective and the defect caused their injuries. South Carolina similarly applies strict liability to defective product cases. Three types of defects may support a claim:</p>
<ul>
<li><strong>Design defects:</strong> The equipment's design makes it unreasonably dangerous even when manufactured correctly — e.g., a power tool without an adequate safety guard</li>
<li><strong>Manufacturing defects:</strong> An error during production caused a specific unit to deviate from the intended design — e.g., a cracked weld on a scaffold frame</li>
<li><strong>Failure to warn:</strong> The manufacturer failed to provide adequate warnings about known hazards — e.g., insufficient safety labels on hazardous equipment</li>
</ul>

<h2>Rental Company Liability</h2>
<p>Construction equipment rental companies have a duty to inspect, maintain, and repair equipment before renting it to contractors. When rental companies rent defective equipment without proper inspection, fail to perform required maintenance, ignore known defects, or fail to provide adequate operating instructions and safety information, they may share liability for injuries caused by the equipment. Rental companies cannot shield themselves from liability by requiring contractors to sign indemnity agreements when their own negligence contributed to the injury.</p>

<h2>Pursuing a Defective Equipment Claim</h2>
<p>Defective construction equipment claims are pursued in addition to <a href="/workers-compensation-lawyers/">workers' compensation benefits</a>, allowing recovery of full damages. Liable parties include the equipment manufacturer, component part manufacturers, distributors and wholesale suppliers, rental companies, and retailers. Georgia allows recovery if less than 50% at fault (O.C.G.A. § 51-12-33). South Carolina allows recovery if less than 51% at fault. Preserving the defective equipment is critical — our attorneys act quickly to secure and preserve evidence before it is repaired, discarded, or returned to the rental company. Contact Roden Law for a free product liability consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Do I need to prove the manufacturer was negligent?',
                'answer'   => 'No. Under strict product liability law in Georgia (O.C.G.A. § 51-1-11) and South Carolina, you only need to prove the equipment was defective and the defect caused your injury. You do not need to prove how or why the defect occurred.',
            ),
            array(
                'question' => 'Can I sue an equipment rental company for a defect?',
                'answer'   => 'Yes. Rental companies have a duty to inspect and maintain equipment. If they rented defective equipment or failed to perform required maintenance, they can be held liable for resulting injuries alongside the manufacturer.',
            ),
            array(
                'question' => 'What should I do if defective equipment injures me at work?',
                'answer'   => 'Seek medical attention, report the injury to your employer, do NOT return the defective equipment to the rental company or discard it, take photos of the equipment and the defect, file a workers\' compensation claim, and consult an attorney about potential product liability claims.',
            ),
            array(
                'question' => 'Can I file a product liability claim in addition to workers\' compensation?',
                'answer'   => 'Yes. Workers\' comp covers medical bills and wage replacement, but product liability claims against third-party manufacturers allow you to recover additional damages including pain and suffering, disfigurement, and potentially punitive damages.',
            ),
            array(
                'question' => 'How long do I have to file a defective equipment claim?',
                'answer'   => 'Georgia\'s personal injury statute of limitations is 2 years (O.C.G.A. § 9-3-33), with a 10-year statute of repose for products (O.C.G.A. § 51-1-11). South Carolina allows 3 years for personal injury (S.C. Code § 15-3-530). Evidence preservation is critical — consult an attorney immediately.',
            ),
        ),
    ),

    /* ============================================================
       7. Roofing Accident
       ============================================================ */
    array(
        'title'   => 'Roofing Accident Lawyers',
        'slug'    => 'roofing-accident',
        'excerpt' => 'Injured in a roofing accident in Georgia or South Carolina? Our attorneys pursue workers\' compensation and third-party claims for roofers who suffer falls, burns, heat stroke, and other injuries on the job.',
        'content' => <<<'HTML'
<h2>Roofing Accident Injury Claims in Georgia &amp; South Carolina</h2>
<p>Roofing is consistently ranked among the most dangerous occupations in the United States. The <a href="https://www.bls.gov/iif/" target="_blank" rel="noopener">Bureau of Labor Statistics</a> reports that roofers experience one of the highest rates of fatal workplace injuries of any occupation, primarily due to falls from rooftops, ladders, and scaffolds. Beyond falls, roofers face exposure to extreme heat, <a href="/burn-injury-lawyers/">burn injuries</a> from hot tar and torches, <a href="/construction-accident-lawyers/electrocution-construction-site/">electrocution</a> from overhead power lines, and injuries from <a href="/construction-accident-lawyers/falling-object-injury/">falling materials</a>.</p>
<p>At Roden Law, our roofing accident attorneys represent injured roofers and their families throughout Georgia and South Carolina. We pursue both <a href="/workers-compensation-lawyers/">workers' compensation claims</a> and third-party lawsuits to maximize recovery for roofing accident victims.</p>

<h2>Common Causes of Roofing Accidents</h2>
<p>Roofing accidents result from a combination of inherent workplace hazards and preventable safety failures:</p>
<ul>
<li><strong>Falls from roofs:</strong> The leading cause of roofing deaths — workers falling from roof edges, through skylights, or through weakened roof structures</li>
<li><strong>Ladder accidents:</strong> <a href="/construction-accident-lawyers/scaffold-ladder-fall/">Falls from improperly set up or defective ladders</a> while accessing rooftops</li>
<li><strong>Burns from hot materials:</strong> Contact with hot tar, asphalt, and torch-applied roofing materials</li>
<li><strong>Heat-related illness:</strong> Heat stroke and heat exhaustion from working in direct sun on hot roofing surfaces</li>
<li><strong>Electrocution:</strong> Contact with overhead power lines from ladders, metal flashing, or equipment</li>
<li><strong>Collapsing roof structures:</strong> Workers falling through deteriorated or structurally unsound roof decking</li>
<li><strong>Material handling injuries:</strong> Heavy roofing materials causing back injuries, crush injuries, and strains</li>
</ul>

<h2>OSHA Fall Protection Requirements for Roofing</h2>
<p>OSHA's fall protection standards (29 CFR 1926 Subpart M) require comprehensive fall protection for roofing workers:</p>
<ul>
<li><strong>Low-slope roofs:</strong> Workers on low-slope roofs (4:12 pitch or less) more than 6 feet above ground must use guardrails, safety nets, or personal fall arrest systems, or work within a warning line system combined with a safety monitor</li>
<li><strong>Steep-slope roofs:</strong> Workers on steep-slope roofs (greater than 4:12 pitch) more than 6 feet above ground must use guardrails, safety nets, or personal fall arrest systems</li>
<li><strong>Hole covers:</strong> All holes in roof surfaces must be covered or guarded to prevent falls through</li>
<li><strong>Skylight protection:</strong> Skylights must be guarded or screened to prevent workers from falling through</li>
</ul>
<p>Fall protection violations are consistently among <a href="https://www.osha.gov/top10citedstandards" target="_blank" rel="noopener">OSHA's most frequently cited standards</a>, and roofing contractors are among the most commonly cited employers.</p>

<h2>Injuries in Roofing Accidents</h2>
<p>Falls from roofs cause devastating injuries including <a href="/brain-injury-lawyers/">traumatic brain injuries</a>, <a href="/spinal-cord-injury-lawyers/">spinal cord injuries</a> and paralysis, multiple bone fractures, internal organ damage, and death. Roofers also suffer <a href="/burn-injury-lawyers/">burn injuries</a> from hot tar and torch operations, chronic respiratory conditions from asphalt fume inhalation, and heat-related illnesses that can be fatal if not treated promptly.</p>

<h2>Pursuing a Roofing Accident Claim</h2>
<p>Liable parties in roofing accident cases include the roofing contractor and employer, general contractors who controlled the job site, property owners who hired uninsured or unqualified roofers, manufacturers of <a href="/construction-accident-lawyers/defective-construction-equipment/">defective roofing equipment</a> and fall protection systems, and building owners who failed to disclose roof structural deficiencies. Workers' compensation provides medical and wage benefits, while third-party claims allow recovery of pain and suffering and other full damages. Georgia law (O.C.G.A. § 51-12-33) allows recovery if less than 50% at fault. South Carolina allows recovery if less than 51%. Contact Roden Law for a free consultation — we fight for injured roofers across both states.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Is roofing really one of the most dangerous jobs?',
                'answer'   => 'Yes. The Bureau of Labor Statistics consistently ranks roofing among the occupations with the highest fatal injury rates. Falls from roofs are the primary cause, but roofers also face burns, electrocution, and heat illness risks.',
            ),
            array(
                'question' => 'What fall protection does OSHA require for roofing work?',
                'answer'   => 'OSHA (29 CFR 1926 Subpart M) requires fall protection for all roofing workers more than 6 feet above ground. On low-slope roofs, guardrails, safety nets, fall arrest systems, or warning line/safety monitor systems are required. Steep-slope roofs require guardrails, nets, or fall arrest systems.',
            ),
            array(
                'question' => 'Can a homeowner be liable for a roofer\'s injury?',
                'answer'   => 'Potentially. Homeowners who hire unlicensed or uninsured roofing contractors, fail to disclose known roof hazards, or maintain dangerous conditions on their property may share liability for roofing injuries.',
            ),
            array(
                'question' => 'What if my roofing employer did not provide fall protection?',
                'answer'   => 'Your employer\'s failure to provide required fall protection is an OSHA violation that supports your workers\' compensation claim and may support third-party claims. Document the lack of safety equipment and report the violation to OSHA.',
            ),
            array(
                'question' => 'How long do I have to file a roofing accident claim?',
                'answer'   => 'Workers\' comp deadlines are 1 year in Georgia (O.C.G.A. § 34-9-82) and 2 years in South Carolina. Personal injury claims allow 2 years in Georgia (O.C.G.A. § 9-3-33) and 3 years in South Carolina (S.C. Code § 15-3-530).',
            ),
        ),
    ),

    /* ============================================================
       8. Highway and Road Construction Accident
       ============================================================ */
    array(
        'title'   => 'Highway and Road Construction Accident Lawyers',
        'slug'    => 'highway-road-construction-accident',
        'excerpt' => 'Injured in a highway or road construction zone accident in Georgia or South Carolina? Our attorneys handle claims for workers struck by vehicles and motorists injured in construction zone crashes.',
        'content' => <<<'HTML'
<h2>Highway &amp; Road Construction Accident Claims</h2>
<p>Highway and road construction zones are among the most dangerous work environments in the nation. The <a href="https://www.fhwa.dot.gov/publications/research/safety/" target="_blank" rel="noopener">Federal Highway Administration (FHWA)</a> reports that hundreds of workers and motorists are killed in work zone crashes each year, with thousands more suffering serious injuries. Construction zone workers face the constant threat of being struck by vehicles traveling at high speeds, while motorists encounter confusing traffic patterns, reduced lanes, uneven pavement, and inadequate signage that contribute to crashes.</p>
<p>At Roden Law, our highway construction accident attorneys represent both injured workers and motorists throughout Georgia and South Carolina. Whether you are a construction worker struck by a passing vehicle or a driver injured due to inadequate work zone safety, we pursue full compensation from all responsible parties.</p>

<h2>Georgia &amp; South Carolina Work Zone Laws</h2>
<p>Both states have enacted enhanced penalties for traffic violations in construction zones to protect workers and motorists:</p>
<ul>
<li><strong>Georgia:</strong> <a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-10/" target="_blank" rel="noopener">O.C.G.A. § 40-6-188</a> doubles fines for speeding in active work zones when workers are present. Georgia law also authorizes enhanced penalties for reckless driving in construction zones.</li>
<li><strong>South Carolina:</strong> S.C. Code § 56-5-1535 imposes enhanced penalties for speeding in highway work zones, including doubled fines and potential license suspension for repeat offenses.</li>
</ul>
<p>Violations of these laws constitute evidence of negligence per se in personal injury claims — meaning the violator is automatically considered negligent.</p>

<h2>Common Causes of Work Zone Accidents</h2>
<p>Highway construction zone accidents result from a combination of driver behavior and contractor negligence:</p>
<ul>
<li><strong>Speeding through work zones:</strong> Motorists exceeding reduced speed limits, the most common cause of fatal work zone crashes</li>
<li><strong>Distracted driving:</strong> Cell phone use, GPS adjustments, and driver inattention in <a href="/car-accident-lawyers/">complex construction zone traffic patterns</a></li>
<li><strong>Inadequate traffic control:</strong> Missing or confusing signs, inadequate lane markings, and insufficient advance warning</li>
<li><strong>Impaired driving:</strong> <a href="/car-accident-lawyers/drunk-driver-accident/">Alcohol and drug impairment</a> worsened by unfamiliar road conditions</li>
<li><strong>Rear-end collisions:</strong> Sudden stops in congested work zones causing <a href="/car-accident-lawyers/rear-end-collision/">chain-reaction crashes</a></li>
<li><strong>Heavy equipment conflicts:</strong> <a href="/construction-accident-lawyers/crane-heavy-equipment-accident/">Construction equipment</a> entering and exiting active traffic lanes</li>
<li><strong>Night work hazards:</strong> Poor visibility, glare from equipment, and driver drowsiness during nighttime construction</li>
</ul>

<h2>Injuries in Highway Construction Accidents</h2>
<p>The combination of vehicle speeds and exposed workers produces severe injuries including <a href="/brain-injury-lawyers/">traumatic brain injuries</a>, <a href="/spinal-cord-injury-lawyers/">spinal cord injuries</a> and paralysis, crush injuries from being pinned between vehicles and equipment, multiple bone fractures, amputations, <a href="/burn-injury-lawyers/">burn injuries</a> from vehicle fires, and <a href="/wrongful-death-lawyers/">wrongful death</a>. Workers who are struck by vehicles while on foot suffer particularly devastating injuries due to the complete lack of protection.</p>

<h2>Pursuing a Work Zone Accident Claim</h2>
<p>Liability in highway construction accidents may rest with negligent motorists who violated work zone traffic laws, construction contractors who failed to implement adequate traffic control plans, government agencies (GDOT, SCDOT) responsible for work zone design and oversight, subcontractors responsible for signage, flagging, and traffic control, and <a href="/truck-accident-lawyers/">truck drivers and trucking companies</a> operating in work zones. Georgia's comparative fault rule (O.C.G.A. § 51-12-33) allows recovery if less than 50% at fault. South Carolina allows recovery if less than 51% at fault. Workers may also pursue <a href="/workers-compensation-lawyers/">workers' compensation</a> in addition to third-party claims. Our attorneys investigate crash reports, work zone plans, traffic control logs, and video evidence to build compelling cases. Contact Roden Law for a free consultation — no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Are fines doubled in Georgia construction zones?',
                'answer'   => 'Yes. Georgia law (O.C.G.A. § 40-6-188) doubles fines for speeding in active work zones when construction workers are present. This law also supports negligence claims against speeding motorists in work zone accidents.',
            ),
            array(
                'question' => 'Can a construction worker sue a driver who hit them in a work zone?',
                'answer'   => 'Yes. Construction workers struck by motorists in work zones can file third-party personal injury claims against the driver in addition to receiving workers\' compensation benefits. This allows recovery of pain and suffering and other damages not available through workers\' comp.',
            ),
            array(
                'question' => 'Who is responsible for traffic control in a construction zone?',
                'answer'   => 'The construction contractor is typically responsible for implementing the traffic control plan, while the state DOT (GDOT or SCDOT) approves and oversees the plan. Both may be liable if inadequate traffic control contributed to an accident.',
            ),
            array(
                'question' => 'Can I sue the government for a construction zone accident?',
                'answer'   => 'Potentially. Government agencies responsible for road construction design, traffic control plans, and work zone oversight may be liable under certain circumstances. Georgia and South Carolina have specific rules regarding sovereign immunity that an attorney can evaluate for your case.',
            ),
            array(
                'question' => 'How long do I have to file a highway construction accident claim?',
                'answer'   => 'Personal injury claims have a 2-year deadline in Georgia (O.C.G.A. § 9-3-33) and 3 years in South Carolina (S.C. Code § 15-3-530). Claims against government entities may have shorter notice periods. Workers\' comp deadlines are 1 year (GA) and 2 years (SC).',
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
