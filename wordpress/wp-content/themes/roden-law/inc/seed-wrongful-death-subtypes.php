<?php
/**
 * Seeder: 8 Wrongful Death Sub-Type Pages
 *
 * Creates 8 child posts under the wrongful-death-lawyers pillar, each covering
 * a specific cause of wrongful death.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-wrongful-death-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: wrongful-death-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'wrongful-death-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'wrongful-death-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "wrongful-death-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'wrongful-death', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Wrongful Death', 'practice_category', array( 'slug' => 'wrongful-death' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Fatal Car Accident
       ============================================================ */
    array(
        'title'   => 'Fatal Car Accident Lawyers',
        'slug'    => 'fatal-car-accident',
        'excerpt' => 'Lost a loved one in a fatal car accident in Georgia or South Carolina? Our wrongful death attorneys pursue maximum compensation from negligent drivers and their insurers on behalf of surviving families.',
        'content' => <<<'HTML'
<h2>Fatal Car Accident Wrongful Death Claims in Georgia &amp; South Carolina</h2>
<p>Car accidents are the leading cause of wrongful death claims in the United States. According to the <a href="https://www.nhtsa.gov/press-releases/traffic-crash-death-estimates-2022" target="_blank" rel="noopener">National Highway Traffic Safety Administration (NHTSA)</a>, over 40,000 people die in motor vehicle crashes each year — many due to preventable negligence such as distracted driving, speeding, drunk driving, and reckless lane changes. When a negligent driver causes a fatal crash, the victim's surviving family members have the right to pursue a wrongful death claim for compensation.</p>
<p>At Roden Law, our fatal car accident lawyers represent grieving families across Georgia and South Carolina. We understand that no amount of money can replace your loved one, but a wrongful death claim can provide financial security for your family and hold the responsible party accountable for their actions.</p>

<h2>Georgia Wrongful Death Law</h2>
<p>Georgia's wrongful death statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-4/section-51-4-1/" target="_blank" rel="noopener">O.C.G.A. § 51-4-1 et seq.</a>) provides a framework for surviving family members to recover damages. In Georgia, the right to bring a wrongful death claim follows a specific hierarchy: the surviving spouse has the first right to file suit; if there is no surviving spouse, the children may file; and if there are no children, the parents or the estate administrator may bring the claim.</p>
<p>Georgia distinguishes between two types of damages in wrongful death cases: (1) the "full value of the life" of the deceased, which represents what the deceased would have earned and contributed to the family over their remaining lifetime, and (2) a separate estate claim for the deceased's pre-death pain and suffering, medical expenses, and funeral costs.</p>

<h2>South Carolina Wrongful Death Law</h2>
<p>South Carolina's wrongful death statute (<a href="https://www.scstatehouse.gov/code/t15c051.php" target="_blank" rel="noopener">S.C. Code § 15-51-10 et seq.</a>) allows the personal representative of the deceased's estate to bring a wrongful death action on behalf of statutory beneficiaries. Damages are distributed among the surviving spouse, children, and in some cases parents, based on their dependency on the deceased. South Carolina also provides for a separate survival action for the deceased's pre-death damages.</p>

<h2>Common Causes of Fatal Car Accidents</h2>
<p>Fatal car accidents are frequently caused by:</p>
<ul>
<li>Distracted driving, including texting and smartphone use</li>
<li>Drunk and drugged driving</li>
<li>Excessive speed and aggressive driving</li>
<li>Running red lights and stop signs</li>
<li>Wrong-way driving on highways</li>
<li>Drowsy and fatigued driving</li>
<li>Failure to yield the right of way</li>
</ul>
<p>Our <a href="/car-accident-lawyers/">car accident lawyers</a> handle the full spectrum of motor vehicle collision cases, including specific sub-types such as <a href="/car-accident-lawyers/drunk-driver-accident/">drunk driver accidents</a>, <a href="/car-accident-lawyers/head-on-collision/">head-on collisions</a>, and <a href="/car-accident-lawyers/hit-and-run/">hit-and-run accidents</a>. When these crashes result in death, our wrongful death team steps in to pursue justice for the family.</p>

<h2>Multiple Sources of Compensation</h2>
<p>Fatal car accident claims may involve multiple sources of recovery, including the at-fault driver's liability insurance, your loved one's underinsured/uninsured motorist (UM/UIM) coverage, employer liability if the at-fault driver was on the job, dram shop claims if the driver was over-served alcohol, and vehicle manufacturer claims if a defective vehicle component contributed to the fatality.</p>

<h2>Statute of Limitations</h2>
<p>In Georgia, wrongful death claims must be filed within 2 years of the date of death (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years from the date of death (S.C. Code § 15-3-530). Missing these deadlines typically bars your claim permanently. Contact Roden Law for a free consultation — there is no fee unless we recover compensation for your family.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who can file a wrongful death claim for a fatal car accident in Georgia?',
                'answer'   => 'In Georgia, the surviving spouse has the primary right to file. If there is no spouse, the children may file. If there are no children, the parents or estate administrator may bring the claim (O.C.G.A. § 51-4-2).',
            ),
            array(
                'question' => 'What damages are available in a fatal car accident wrongful death claim?',
                'answer'   => 'Damages include the full value of the deceased\'s life (future earnings and contributions), pre-death pain and suffering, medical expenses incurred before death, funeral and burial costs, and loss of companionship and support.',
            ),
            array(
                'question' => 'Can I file a wrongful death claim if the at-fault driver was uninsured?',
                'answer'   => 'Yes. You may recover compensation through your loved one\'s uninsured motorist (UM) coverage. Additionally, other liable parties — such as employers, vehicle manufacturers, or establishments that served alcohol — may provide additional sources of recovery.',
            ),
            array(
                'question' => 'How is a wrongful death claim different from a criminal case?',
                'answer'   => 'A wrongful death claim is a civil lawsuit seeking financial compensation, while a criminal case seeks punishment through the justice system. The two proceed independently — you can file a wrongful death claim regardless of whether criminal charges are filed or result in conviction.',
            ),
            array(
                'question' => 'What is the statute of limitations for a fatal car accident wrongful death claim?',
                'answer'   => 'In Georgia, the deadline is 2 years from the date of death (O.C.G.A. § 9-3-33). In South Carolina, it is 3 years (S.C. Code § 15-3-530). Prompt action is critical to preserve evidence and identify all liable parties.',
            ),
        ),
    ),

    /* ============================================================
       2. Fatal Truck Accident
       ============================================================ */
    array(
        'title'   => 'Fatal Truck Accident Lawyers',
        'slug'    => 'fatal-truck-accident',
        'excerpt' => 'Lost a loved one in a fatal truck accident in Georgia or South Carolina? Our wrongful death attorneys pursue claims against negligent trucking companies, drivers, and other liable parties for maximum compensation.',
        'content' => <<<'HTML'
<h2>Fatal Truck Accident Wrongful Death Claims in Georgia &amp; South Carolina</h2>
<p>Accidents involving commercial trucks, tractor-trailers, and 18-wheelers are among the deadliest on our roadways. The <a href="https://www.nhtsa.gov/road-safety/large-trucks" target="_blank" rel="noopener">NHTSA</a> reports that large truck crashes kill approximately 5,000 people each year, with the vast majority of fatalities being occupants of passenger vehicles. The sheer size and weight differential between a fully loaded semi-truck (up to 80,000 pounds) and a standard passenger car (approximately 3,500 pounds) means that collisions are often fatal for the car's occupants.</p>
<p>At Roden Law, our fatal truck accident lawyers represent families across Georgia and South Carolina who have lost loved ones in crashes caused by negligent truck drivers, trucking companies, and other responsible parties. These cases are significantly more complex than typical car accident claims because they involve federal trucking regulations, multiple insurance policies, and corporate defendants with aggressive legal teams.</p>

<h2>Georgia &amp; South Carolina Wrongful Death Framework</h2>
<p>Fatal truck accident claims are brought under the wrongful death statutes of the state where the accident occurred. Georgia's wrongful death statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-4/section-51-4-1/" target="_blank" rel="noopener">O.C.G.A. § 51-4-1 et seq.</a>) allows the surviving spouse, children, or parents to recover the "full value of the life" of the deceased. South Carolina's statute (<a href="https://www.scstatehouse.gov/code/t15c051.php" target="_blank" rel="noopener">S.C. Code § 15-51-10 et seq.</a>) allows the estate's personal representative to bring the action on behalf of statutory beneficiaries.</p>

<h2>Federal Trucking Regulations and Liability</h2>
<p>Commercial trucks operating in interstate commerce are governed by <a href="https://www.fmcsa.dot.gov/regulations" target="_blank" rel="noopener">Federal Motor Carrier Safety Administration (FMCSA)</a> regulations that establish strict requirements for:</p>
<ul>
<li>Hours-of-service (HOS) limits to prevent driver fatigue</li>
<li>Commercial driver's license (CDL) qualifications and medical certifications</li>
<li>Vehicle inspection, maintenance, and repair protocols</li>
<li>Drug and alcohol testing programs</li>
<li>Cargo securement standards</li>
<li>Minimum insurance coverage ($750,000 to $5 million depending on cargo)</li>
</ul>
<p>Violations of these federal regulations can serve as powerful evidence of negligence in a wrongful death case. Our <a href="/truck-accident-lawyers/">truck accident lawyers</a> have extensive experience identifying FMCSA violations and holding trucking companies accountable.</p>

<h2>Multiple Liable Parties</h2>
<p>Fatal truck accident cases often involve multiple defendants:</p>
<ul>
<li>The truck driver who was fatigued, distracted, impaired, or speeding</li>
<li>The trucking company that hired an unqualified driver, pressured drivers to violate HOS rules, or failed to maintain vehicles</li>
<li>The cargo loader that improperly loaded or secured the freight</li>
<li>The truck or parts manufacturer if a mechanical defect contributed to the crash</li>
<li>The maintenance company that failed to properly inspect or repair the truck</li>
</ul>
<p>Identifying all liable parties is critical to maximizing the family's recovery. Trucking companies carry much larger insurance policies than individual drivers, and multiple sources of coverage may apply.</p>

<h2>Preserving Critical Evidence</h2>
<p>Trucking companies are required to retain certain records after a crash, but evidence can be lost quickly. Electronic logging device (ELD) data, dashcam footage, GPS records, pre-trip inspection reports, and driver qualification files must be preserved through a spoliation letter sent immediately after the crash. Our attorneys act within hours to send preservation demands and begin independent investigations.</p>

<h2>Contact Roden Law After a Fatal Truck Accident</h2>
<p>If your family has lost a loved one in a truck accident, time is critical. Georgia's wrongful death statute of limitations is 2 years (O.C.G.A. § 9-3-33), and South Carolina's is 3 years (S.C. Code § 15-3-530). Contact Roden Law immediately for a free consultation — there is no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue the trucking company in addition to the driver?',
                'answer'   => 'Yes. Trucking companies are often liable under respondeat superior (employer liability) and may also be directly liable for negligent hiring, inadequate training, failure to maintain vehicles, or pressuring drivers to violate hours-of-service rules.',
            ),
            array(
                'question' => 'What federal regulations apply to truck accident cases?',
                'answer'   => 'The FMCSA establishes regulations for hours of service, driver qualifications, vehicle maintenance, drug testing, and cargo securement. Violations of these regulations serve as strong evidence of negligence in a wrongful death claim.',
            ),
            array(
                'question' => 'How much insurance do trucking companies carry?',
                'answer'   => 'Federal law requires minimum insurance coverage of $750,000 for general freight carriers and up to $5 million for carriers transporting hazardous materials. Many large trucking companies carry policies well above the minimums.',
            ),
            array(
                'question' => 'What evidence is important in a fatal truck accident case?',
                'answer'   => 'Critical evidence includes electronic logging device (ELD) data, dashcam footage, GPS records, pre-trip inspection reports, driver qualification files, toxicology results, and the truck\'s maintenance history. A spoliation letter must be sent immediately to preserve this evidence.',
            ),
            array(
                'question' => 'What is the statute of limitations for a fatal truck accident claim?',
                'answer'   => 'In Georgia, wrongful death claims must be filed within 2 years of the date of death (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530).',
            ),
        ),
    ),

    /* ============================================================
       3. Medical Malpractice Death
       ============================================================ */
    array(
        'title'   => 'Medical Malpractice Death Lawyers',
        'slug'    => 'medical-malpractice-death',
        'excerpt' => 'Lost a loved one due to medical malpractice in Georgia or South Carolina? Our wrongful death attorneys pursue claims against negligent doctors, surgeons, hospitals, and healthcare providers.',
        'content' => <<<'HTML'
<h2>Medical Malpractice Wrongful Death Claims in Georgia &amp; South Carolina</h2>
<p>When a patient dies due to medical negligence, the family faces not only devastating grief but also the complexity of pursuing a wrongful death claim against healthcare providers and institutions. According to research published by <a href="https://pubmed.ncbi.nlm.nih.gov/" target="_blank" rel="noopener">Johns Hopkins University</a>, medical errors are the third leading cause of death in the United States, claiming an estimated 250,000 lives annually. These preventable deaths include fatalities from surgical errors, misdiagnosis, medication mistakes, hospital-acquired infections, and failures of communication among medical teams.</p>
<p>At Roden Law, our medical malpractice wrongful death lawyers represent families across Georgia and South Carolina who have lost loved ones to preventable medical errors. These cases require both medical and legal expertise, and our attorneys work with board-certified medical experts to build compelling cases for accountability and compensation.</p>

<h2>Georgia Wrongful Death and Medical Malpractice Requirements</h2>
<p>Medical malpractice wrongful death claims in Georgia must comply with two overlapping legal frameworks: the wrongful death statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-4/section-51-4-1/" target="_blank" rel="noopener">O.C.G.A. § 51-4-1 et seq.</a>) and the medical malpractice statute requiring an expert affidavit (<a href="https://law.justia.com/codes/georgia/title-9/chapter-11/article-2/section-9-11-9-1/" target="_blank" rel="noopener">O.C.G.A. § 9-11-9.1</a>). The expert affidavit must be filed simultaneously with the complaint and must identify at least one act of negligence committed by each defendant healthcare provider.</p>
<p>Georgia's statute of repose (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-5/section-9-3-71/" target="_blank" rel="noopener">O.C.G.A. § 9-3-71</a>) imposes a 5-year outer deadline for medical malpractice claims, running from the date of the negligent act regardless of when the death occurred.</p>

<h2>South Carolina Medical Malpractice Death Requirements</h2>
<p>South Carolina's wrongful death statute (<a href="https://www.scstatehouse.gov/code/t15c051.php" target="_blank" rel="noopener">S.C. Code § 15-51-10 et seq.</a>) works in conjunction with the medical malpractice pre-suit requirements of <a href="https://www.scstatehouse.gov/code/t15c079.php" target="_blank" rel="noopener">S.C. Code § 15-79-125</a>, which requires a Notice of Intent to File Suit accompanied by an expert opinion before a medical malpractice wrongful death lawsuit can proceed.</p>

<h2>Common Causes of Medical Malpractice Deaths</h2>
<p>Fatal medical errors include:</p>
<ul>
<li><a href="/medical-malpractice-lawyers/surgical-error/">Surgical errors</a> — wrong-site surgery, uncontrolled hemorrhage, organ perforation</li>
<li><a href="/medical-malpractice-lawyers/misdiagnosis-delayed-diagnosis/">Misdiagnosis and delayed diagnosis</a> — allowing treatable conditions to become fatal</li>
<li><a href="/medical-malpractice-lawyers/medication-error/">Medication errors</a> — fatal overdoses, allergic reactions, and drug interactions</li>
<li><a href="/medical-malpractice-lawyers/anesthesia-error/">Anesthesia errors</a> — oxygen deprivation leading to brain death</li>
<li><a href="/medical-malpractice-lawyers/hospital-acquired-infection/">Hospital-acquired infections</a> — MRSA, C. diff, and sepsis progressing to fatal organ failure</li>
<li><a href="/medical-malpractice-lawyers/emergency-room-negligence/">Emergency room negligence</a> — premature discharge, failure to diagnose critical conditions</li>
<li><a href="/medical-malpractice-lawyers/birth-injury/">Birth injuries</a> — neonatal deaths from preventable delivery complications</li>
</ul>
<p>Each of these sub-types of medical malpractice requires specialized expert analysis to establish the standard of care, the deviation from that standard, and the causal connection to the patient's death. Our <a href="/medical-malpractice-lawyers/">medical malpractice lawyers</a> have the experience and resources to pursue these complex claims.</p>

<h2>Damages in Medical Malpractice Death Cases</h2>
<p>Families may recover compensation through both the wrongful death claim and a separate survival action. Wrongful death damages include the full value of the deceased's life (future earnings and contributions), loss of companionship and consortium, and the family's mental anguish. The survival action covers the deceased's pre-death pain and suffering, medical expenses incurred before death, and funeral and burial costs.</p>

<h2>Contact Roden Law for a Medical Malpractice Death Case</h2>
<p>Medical malpractice death cases have strict procedural requirements and deadlines. Georgia's 2-year statute of limitations (O.C.G.A. § 9-3-33) and 5-year statute of repose, combined with the expert affidavit requirement, make early legal consultation essential. Contact Roden Law for a free, confidential consultation — there is no fee unless we recover compensation for your family.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the expert affidavit requirement in Georgia medical malpractice death cases?',
                'answer'   => 'Under O.C.G.A. § 9-11-9.1, you must file an expert affidavit from a qualified medical professional simultaneously with your wrongful death complaint. The affidavit must identify at least one negligent act by each defendant. Failure to comply can result in dismissal.',
            ),
            array(
                'question' => 'Who can file a medical malpractice wrongful death claim?',
                'answer'   => 'In Georgia, the surviving spouse has the primary right to file (O.C.G.A. § 51-4-2). If there is no surviving spouse, children, parents, or the estate administrator may file. In South Carolina, the estate\'s personal representative files on behalf of statutory beneficiaries.',
            ),
            array(
                'question' => 'What is the statute of repose for medical malpractice in Georgia?',
                'answer'   => 'Under O.C.G.A. § 9-3-71, medical malpractice claims must generally be brought within 5 years of the negligent act, regardless of when the patient died. This absolute deadline applies even if the connection between the negligence and death was not discovered until later.',
            ),
            array(
                'question' => 'Can I sue a hospital for a patient death?',
                'answer'   => 'Yes. Hospitals may be directly liable for systemic failures such as understaffing, inadequate infection control, or failure to enforce safety protocols. Hospitals may also be vicariously liable for the negligence of their employee physicians, nurses, and staff.',
            ),
            array(
                'question' => 'What damages are available in a medical malpractice death case?',
                'answer'   => 'Damages include the full value of the deceased\'s life, loss of companionship, pre-death pain and suffering, medical expenses, and funeral costs. Georgia and South Carolina allow both wrongful death and survival actions to maximize the family\'s total recovery.',
            ),
        ),
    ),

    /* ============================================================
       4. Workplace Fatality
       ============================================================ */
    array(
        'title'   => 'Workplace Fatality Lawyers',
        'slug'    => 'workplace-fatality',
        'excerpt' => 'Lost a loved one in a workplace accident in Georgia or South Carolina? Our wrongful death attorneys pursue claims beyond workers\' compensation against negligent third parties, equipment manufacturers, and property owners.',
        'content' => <<<'HTML'
<h2>Workplace Fatality Wrongful Death Claims in Georgia &amp; South Carolina</h2>
<p>Every worker deserves to return home safely at the end of the day, but workplace accidents claim thousands of lives each year. The <a href="https://www.bls.gov/iif/soii-data.htm" target="_blank" rel="noopener">Bureau of Labor Statistics (BLS)</a> reports over 5,000 fatal work injuries annually in the United States, with the construction, transportation, and agriculture industries accounting for the highest fatality rates. The <a href="https://www.osha.gov/data/commonstats" target="_blank" rel="noopener">Occupational Safety and Health Administration (OSHA)</a> identifies the "Fatal Four" causes of construction deaths as falls, struck-by incidents, electrocutions, and caught-in/between accidents.</p>
<p>At Roden Law, our workplace fatality lawyers represent families across Georgia and South Carolina who have lost loved ones in preventable workplace accidents. While workers' compensation provides limited death benefits, our attorneys identify third-party liability claims that allow families to recover full wrongful death damages beyond what workers' compensation provides.</p>

<h2>Workers' Compensation Death Benefits vs. Wrongful Death Claims</h2>
<p>Georgia and South Carolina workers' compensation systems provide death benefits to the surviving spouse and dependents of workers killed on the job. However, these benefits are limited — covering a portion of lost wages and funeral expenses, but not providing compensation for pain and suffering, loss of companionship, or the full value of the worker's life.</p>
<p>A third-party wrongful death claim allows the family to pursue full damages under the wrongful death statutes. Georgia's wrongful death law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-4/section-51-4-1/" target="_blank" rel="noopener">O.C.G.A. § 51-4-1 et seq.</a>) and South Carolina's (<a href="https://www.scstatehouse.gov/code/t15c051.php" target="_blank" rel="noopener">S.C. Code § 15-51-10 et seq.</a>) provide significantly greater compensation than workers' compensation alone. Our <a href="/workers-compensation-lawyers/">workers' compensation lawyers</a> work alongside our wrongful death team to coordinate both claims for maximum recovery.</p>

<h2>Common Causes of Workplace Fatalities</h2>
<p>Fatal workplace accidents frequently result from:</p>
<ul>
<li>Falls from heights — scaffolding collapses, ladder failures, unguarded roof edges</li>
<li>Struck-by accidents — falling objects, vehicle collisions on job sites, crane accidents</li>
<li>Electrocutions — contact with power lines, defective electrical equipment, improper lockout/tagout</li>
<li>Caught-in/between — machinery entanglement, trench collapses, crushing incidents</li>
<li>Explosions and fires — gas leaks, chemical reactions, combustible dust</li>
<li>Toxic exposure — asbestos, silica, chemical inhalation, confined space oxygen depletion</li>
<li>Transportation incidents — commercial vehicle crashes, forklift accidents</li>
</ul>
<p>Many of these fatalities involve <a href="/construction-accident-lawyers/">construction site accidents</a> where OSHA regulations were violated. When defective equipment contributes to a death, <a href="/product-liability-lawyers/">product liability claims</a> may also be available.</p>

<h2>Third-Party Liability in Workplace Deaths</h2>
<p>While you generally cannot sue your employer beyond workers' compensation, third parties whose negligence caused or contributed to the death can be held fully liable:</p>
<ul>
<li>Property owners who maintained unsafe conditions at the worksite</li>
<li>General contractors responsible for overall job site safety</li>
<li>Equipment and machinery manufacturers whose defective products caused the death</li>
<li>Subcontractors whose negligence created the dangerous condition</li>
<li>Chemical manufacturers who failed to warn of hazardous properties</li>
</ul>

<h2>OSHA Investigations and Evidence</h2>
<p>OSHA investigates all workplace fatalities, and their findings can provide valuable evidence for a wrongful death claim. OSHA citations, inspection reports, and penalty assessments document specific safety violations that contributed to the death. Our attorneys obtain these records and use them alongside our own independent investigation to build the strongest possible case.</p>

<h2>Contact Roden Law After a Workplace Fatality</h2>
<p>Georgia's wrongful death statute of limitations is 2 years (O.C.G.A. § 9-3-33), and South Carolina's is 3 years (S.C. Code § 15-3-530). Workers' compensation death benefits have separate reporting deadlines. Contact Roden Law immediately for a free consultation to ensure all deadlines are met and evidence is preserved.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I file a wrongful death claim if my loved one died at work?',
                'answer'   => 'Yes, if a third party (someone other than the employer) contributed to the death. While workers\' compensation is typically the exclusive remedy against the employer, you can file a separate wrongful death lawsuit against negligent third parties such as property owners, contractors, or equipment manufacturers.',
            ),
            array(
                'question' => 'What are workers\' compensation death benefits?',
                'answer'   => 'Workers\' compensation death benefits provide a portion of the deceased worker\'s wages to the surviving spouse and dependents, plus funeral expenses. These benefits are limited and do not include pain and suffering or the full value of life available through a wrongful death claim.',
            ),
            array(
                'question' => 'Can I receive both workers\' compensation and wrongful death damages?',
                'answer'   => 'Yes, but the workers\' compensation carrier may have a lien on your third-party wrongful death recovery. Our attorneys negotiate these liens to maximize the net amount your family receives.',
            ),
            array(
                'question' => 'What role does OSHA play in a workplace fatality case?',
                'answer'   => 'OSHA investigates all workplace fatalities and may issue citations for safety violations. OSHA findings, while not binding in civil cases, provide valuable evidence of negligence that can strengthen a wrongful death claim.',
            ),
            array(
                'question' => 'What is the statute of limitations for a workplace fatality wrongful death claim?',
                'answer'   => 'In Georgia, wrongful death claims must be filed within 2 years of the date of death (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530). Workers\' compensation claims have separate, shorter reporting deadlines.',
            ),
        ),
    ),

    /* ============================================================
       5. Defective Product Death
       ============================================================ */
    array(
        'title'   => 'Defective Product Death Lawyers',
        'slug'    => 'defective-product-death',
        'excerpt' => 'Lost a loved one due to a defective product in Georgia or South Carolina? Our wrongful death attorneys hold manufacturers, distributors, and retailers accountable for dangerous products that cause fatal injuries.',
        'content' => <<<'HTML'
<h2>Defective Product Wrongful Death Claims in Georgia &amp; South Carolina</h2>
<p>When a defective product causes a death, the manufacturer, distributor, and retailer may all be held liable under product liability law. The <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">U.S. Consumer Product Safety Commission (CPSC)</a> receives reports of thousands of product-related deaths each year, involving everything from defective vehicles and auto parts to dangerous household appliances, children's products, and industrial equipment. These deaths are often entirely preventable if the product had been properly designed, manufactured, and tested.</p>
<p>At Roden Law, our defective product death lawyers represent families across Georgia and South Carolina who have lost loved ones to dangerous products. We pursue accountability against every entity in the chain of distribution — from the manufacturer to the retailer — to secure maximum compensation for the surviving family.</p>

<h2>Georgia Product Liability Law</h2>
<p>Georgia's product liability framework allows wrongful death claims based on three theories of liability:</p>
<ul>
<li><strong>Design defect:</strong> The product was inherently dangerous due to its design, and a safer alternative design was feasible</li>
<li><strong>Manufacturing defect:</strong> The product deviated from its intended design during production, making it unreasonably dangerous</li>
<li><strong>Failure to warn (marketing defect):</strong> The product lacked adequate warnings or instructions about known risks</li>
</ul>
<p>Georgia applies a negligence-based standard for product liability claims under <a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-2/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>, requiring proof that the defendant failed to exercise reasonable care. The wrongful death statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-4/section-51-4-1/" target="_blank" rel="noopener">O.C.G.A. § 51-4-1 et seq.</a>) provides the framework for surviving family members to recover damages.</p>

<h2>South Carolina Product Liability Law</h2>
<p>South Carolina allows product liability claims under both negligence and strict liability theories. Under strict liability, the plaintiff does not need to prove the manufacturer was negligent — only that the product was defective and unreasonably dangerous when it left the manufacturer's control. South Carolina's wrongful death statute (<a href="https://www.scstatehouse.gov/code/t15c051.php" target="_blank" rel="noopener">S.C. Code § 15-51-10 et seq.</a>) allows the estate's personal representative to bring the action.</p>

<h2>Common Defective Products That Cause Deaths</h2>
<p>Product liability wrongful death cases commonly involve:</p>
<ul>
<li>Defective vehicles — rollover-prone designs, faulty ignition switches, defective airbags (including Takata recalls)</li>
<li>Defective auto parts — tire blowouts, brake failures, steering defects</li>
<li>Dangerous pharmaceutical drugs and medical devices</li>
<li>Defective industrial and construction equipment</li>
<li>Dangerous children's products — choking hazards, toxic materials, unstable furniture</li>
<li>Defective household appliances — electrical fires, gas leaks, carbon monoxide exposure</li>
<li>Defective safety equipment — helmets, harnesses, fall protection that fails to perform</li>
</ul>
<p>Our <a href="/product-liability-lawyers/">product liability lawyers</a> handle the full spectrum of defective product cases. When defective products cause deaths on construction sites, our <a href="/wrongful-death-lawyers/workplace-fatality/">workplace fatality lawyers</a> coordinate both product liability and wrongful death claims for maximum recovery.</p>

<h2>Proving a Defective Product Death Case</h2>
<p>These cases require expert testimony from engineers, materials scientists, and industry specialists who can identify the specific defect, demonstrate that the product was unreasonably dangerous, and establish the causal connection between the defect and the death. Our attorneys work with these experts and also investigate whether the manufacturer was aware of the defect through prior complaints, recalls, or internal testing data.</p>

<h2>Contact Roden Law for a Defective Product Death Case</h2>
<p>Product evidence must be preserved immediately — do not dispose of, repair, or alter the product involved in the death. Georgia's statute of limitations is 2 years (O.C.G.A. § 9-3-33) with a 10-year statute of repose for product liability. South Carolina's is 3 years (S.C. Code § 15-3-530) with a similar repose period. Contact Roden Law for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who can be held liable for a death caused by a defective product?',
                'answer'   => 'Any entity in the chain of distribution may be liable, including the product designer, manufacturer, component part suppliers, distributors, and retailers. Our attorneys investigate the entire chain to identify all responsible parties.',
            ),
            array(
                'question' => 'What is the difference between a design defect and a manufacturing defect?',
                'answer'   => 'A design defect means the product was inherently dangerous as designed — every unit is defective. A manufacturing defect means the design was adequate but a specific unit deviated from the design during production, making that particular product dangerous.',
            ),
            array(
                'question' => 'Should I keep the product that caused the death?',
                'answer'   => 'Yes. Preserving the product in its post-incident condition is critical for expert analysis. Do not repair, alter, or discard the product. Notify your attorney immediately so a preservation protocol can be established.',
            ),
            array(
                'question' => 'Does a product recall affect my wrongful death claim?',
                'answer'   => 'A recall can actually strengthen your claim by demonstrating that the manufacturer knew the product was dangerous. However, recalls do not eliminate your right to file a claim — you may still pursue compensation for a death caused by a recalled product.',
            ),
            array(
                'question' => 'What is the statute of limitations for a defective product death claim?',
                'answer'   => 'In Georgia, wrongful death claims must be filed within 2 years (O.C.G.A. § 9-3-33), with a 10-year product liability statute of repose. In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530). Deadlines may vary depending on the specific product and theory of liability.',
            ),
        ),
    ),

    /* ============================================================
       6. Nursing Home Wrongful Death
       ============================================================ */
    array(
        'title'   => 'Nursing Home Wrongful Death Lawyers',
        'slug'    => 'nursing-home-wrongful-death',
        'excerpt' => 'Lost a loved one due to nursing home abuse or neglect in Georgia or South Carolina? Our wrongful death attorneys pursue claims against negligent nursing homes, assisted living facilities, and their corporate owners.',
        'content' => <<<'HTML'
<h2>Nursing Home Wrongful Death Claims in Georgia &amp; South Carolina</h2>
<p>Families trust nursing homes and assisted living facilities to provide safe, compassionate care for their elderly loved ones. When that trust is betrayed through abuse, neglect, or understaffing, the consequences can be fatal. According to the <a href="https://www.cms.gov/Medicare/Provider-Enrollment-and-Certification/CertificationandComplianc/NHs" target="_blank" rel="noopener">Centers for Medicare &amp; Medicaid Services (CMS)</a>, thousands of nursing home residents suffer serious harm each year from preventable conditions including falls, infections, malnutrition, dehydration, and medication errors.</p>
<p>At Roden Law, our nursing home wrongful death lawyers represent families across Georgia and South Carolina who have lost loved ones due to nursing home negligence and abuse. We hold facilities and their corporate owners accountable when profit-driven decisions — such as inadequate staffing and cost-cutting on care — lead to preventable deaths.</p>

<h2>Common Causes of Nursing Home Deaths</h2>
<p>Preventable nursing home deaths frequently result from:</p>
<ul>
<li><strong>Falls:</strong> Inadequate fall prevention protocols, insufficient supervision, and failure to assist with mobility</li>
<li><strong>Infections:</strong> Poor hygiene, inadequate wound care, and failure to follow infection control procedures</li>
<li><strong>Pressure ulcers (bedsores):</strong> Failure to reposition immobile residents, leading to stage IV ulcers that become infected</li>
<li><strong>Malnutrition and dehydration:</strong> Inadequate feeding assistance, failure to monitor nutritional intake</li>
<li><strong>Medication errors:</strong> Wrong medications, wrong doses, failure to monitor drug interactions</li>
<li><strong>Elopement:</strong> Residents with dementia wander away from the facility due to inadequate security</li>
<li><strong>Physical abuse:</strong> Staff-on-resident violence, including hitting, restraint injuries, and sexual abuse</li>
<li><strong>Choking and aspiration:</strong> Failure to follow dietary restrictions or provide adequate mealtime supervision</li>
</ul>
<p>Our <a href="/nursing-home-abuse-lawyers/">nursing home abuse lawyers</a> handle the full range of nursing home negligence cases, and when neglect or abuse results in death, our wrongful death team pursues maximum accountability.</p>

<h2>Georgia &amp; South Carolina Nursing Home Wrongful Death Law</h2>
<p>Nursing home wrongful death claims are brought under the state wrongful death statutes — Georgia's <a href="https://law.justia.com/codes/georgia/title-51/chapter-4/section-51-4-1/" target="_blank" rel="noopener">O.C.G.A. § 51-4-1 et seq.</a> and South Carolina's <a href="https://www.scstatehouse.gov/code/t15c051.php" target="_blank" rel="noopener">S.C. Code § 15-51-10 et seq.</a> These claims may also involve violations of state nursing home regulations and federal requirements for facilities that participate in Medicare and Medicaid.</p>
<p>Georgia's Disabled Adults and Elder Persons Protection Act provides additional remedies for abuse and neglect of vulnerable adults, and evidence from Adult Protective Services (APS) investigations and CMS survey deficiencies can strengthen a wrongful death claim.</p>

<h2>Understaffing as a Root Cause</h2>
<p>Many nursing home deaths can be traced to chronic understaffing. When facilities do not employ enough nurses and certified nursing assistants (CNAs) to provide adequate care, residents suffer. Studies consistently show a direct correlation between nurse-to-patient ratios and resident outcomes. CMS staffing data is publicly available through the <a href="https://www.medicare.gov/care-compare/" target="_blank" rel="noopener">Medicare Care Compare</a> tool, and our attorneys use this data to demonstrate that a facility's staffing fell below safe levels.</p>

<h2>Damages in Nursing Home Wrongful Death Cases</h2>
<p>Families may recover compensation for the full value of the deceased's life, pre-death pain and suffering (which can be substantial in cases involving prolonged neglect), medical expenses, funeral costs, and loss of companionship. In cases involving willful neglect or abuse, punitive damages may be available to punish the facility and deter future misconduct. Contact Roden Law for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue a nursing home for a loved one\'s death?',
                'answer'   => 'Yes. If your loved one died due to the nursing home\'s negligence, abuse, or understaffing, you can file a wrongful death claim against the facility and potentially its corporate owners and management company.',
            ),
            array(
                'question' => 'What evidence is important in a nursing home wrongful death case?',
                'answer'   => 'Critical evidence includes the resident\'s medical records, staffing logs, CMS survey deficiency reports, incident reports, family complaints, photographs of the resident\'s condition, and Adult Protective Services investigation findings.',
            ),
            array(
                'question' => 'Are punitive damages available in nursing home wrongful death cases?',
                'answer'   => 'Yes, in cases involving willful neglect, abuse, or reckless disregard for resident safety. Georgia generally caps punitive damages at $250,000 (O.C.G.A. § 51-12-5.1) with exceptions, while South Carolina requires clear and convincing evidence of willful conduct.',
            ),
            array(
                'question' => 'Can I hold the nursing home\'s corporate owner liable?',
                'answer'   => 'Yes. If the corporate entity controlled staffing levels, budgets, or care policies that contributed to the death, it may be held directly liable. Our attorneys investigate the corporate ownership structure to identify all responsible parties.',
            ),
            array(
                'question' => 'What is the statute of limitations for a nursing home wrongful death claim?',
                'answer'   => 'In Georgia, wrongful death claims must be filed within 2 years of the date of death (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530). Evidence from nursing home records should be preserved as quickly as possible.',
            ),
        ),
    ),

    /* ============================================================
       7. Drowning and Swimming Pool Death
       ============================================================ */
    array(
        'title'   => 'Drowning and Swimming Pool Death Lawyers',
        'slug'    => 'drowning-swimming-pool-death',
        'excerpt' => 'Lost a loved one in a drowning or swimming pool accident in Georgia or South Carolina? Our wrongful death attorneys hold negligent property owners, pool operators, and product manufacturers accountable.',
        'content' => <<<'HTML'
<h2>Drowning and Swimming Pool Wrongful Death Claims in Georgia &amp; South Carolina</h2>
<p>Drowning is a leading cause of accidental death in the United States, particularly among children. The <a href="https://www.cdc.gov/drowning/" target="_blank" rel="noopener">Centers for Disease Control and Prevention (CDC)</a> reports that approximately 4,000 people die from unintentional drowning each year, and drowning is the number one cause of death for children ages 1-4. Many of these deaths are entirely preventable and result from inadequate supervision, defective pool equipment, missing safety barriers, and negligent property owners.</p>
<p>At Roden Law, our drowning and swimming pool death lawyers represent families across Georgia and South Carolina who have lost loved ones in preventable drowning incidents. Whether the drowning occurred in a residential pool, a hotel or resort pool, a public aquatic facility, or a natural body of water, our attorneys investigate every angle to hold negligent parties accountable.</p>

<h2>Georgia &amp; South Carolina Pool Safety Laws</h2>
<p>Both Georgia and South Carolina have enacted pool safety regulations designed to prevent drownings. Georgia's pool safety regulations require fencing, self-closing and self-latching gates, drain covers compliant with the federal <a href="https://www.cpsc.gov/Safety-Education/Safety-Guides/Pools-and-Spas/Virginia-Graeme-Baker-Pool-And-Spa-Safety-Act" target="_blank" rel="noopener">Virginia Graeme Baker Pool and Spa Safety Act</a>, and proper signage. South Carolina's public swimming pool regulations establish similar requirements for public and commercial pools.</p>
<p>Violations of these safety regulations can establish negligence per se — meaning the violation itself is evidence of negligence — in a wrongful death claim.</p>

<h2>Common Causes of Preventable Drownings</h2>
<p>Drowning wrongful death cases commonly involve:</p>
<ul>
<li><strong>Inadequate fencing and barriers:</strong> Pools without proper fencing, self-closing gates, or pool covers, allowing unsupervised access</li>
<li><strong>Defective pool drains:</strong> Suction entrapment from non-compliant drain covers, trapping victims underwater</li>
<li><strong>Inadequate lifeguard supervision:</strong> Understaffed or inattentive lifeguards at public pools, hotels, and water parks</li>
<li><strong>Lack of safety equipment:</strong> Missing rescue equipment, flotation devices, or emergency communication systems</li>
<li><strong>Defective pool equipment:</strong> Malfunctioning pumps, broken ladders, slippery decking</li>
<li><strong>Negligent property maintenance:</strong> Cloudy water obscuring visibility, broken lights, algae-covered surfaces</li>
<li><strong>Apartment complex and HOA pools:</strong> Failure to enforce rules, maintain equipment, or provide supervision</li>
</ul>
<p>Pool drownings at hotels and resorts involve both <a href="/premises-liability-lawyers/">premises liability</a> claims against the property owner and potential <a href="/product-liability-lawyers/">product liability</a> claims against defective equipment manufacturers. Our <a href="/slip-and-fall-lawyers/hotel-resort-injury/">hotel and resort injury lawyers</a> have specific experience with hospitality industry drowning cases.</p>

<h2>Wrongful Death Claims for Child Drownings</h2>
<p>Child drowning cases are particularly devastating and legally distinct. Property owners owe a heightened duty of care regarding "attractive nuisances" — features like swimming pools that are likely to attract children who cannot appreciate the danger. Under Georgia's wrongful death statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-4/section-51-4-1/" target="_blank" rel="noopener">O.C.G.A. § 51-4-1 et seq.</a>), parents may recover the full value of their child's life. South Carolina's wrongful death statute (<a href="https://www.scstatehouse.gov/code/t15c051.php" target="_blank" rel="noopener">S.C. Code § 15-51-10 et seq.</a>) provides similar remedies.</p>

<h2>Damages in Drowning Death Cases</h2>
<p>Families who lose a loved one to drowning may recover compensation for the full value of the deceased's life, pre-death pain and suffering (drowning victims may experience terror and conscious suffering), medical expenses for resuscitation attempts, funeral and burial costs, loss of companionship, and in cases of egregious negligence, punitive damages. Contact Roden Law for a free consultation — there is no fee unless we recover compensation for your family.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who is liable for a swimming pool drowning?',
                'answer'   => 'Potentially liable parties include the pool owner, the property manager, the hotel or resort operator, the lifeguard or lifeguard company, and the manufacturer of defective pool equipment such as drain covers. Liability depends on who had the duty to maintain the pool and ensure safety.',
            ),
            array(
                'question' => 'What is the Virginia Graeme Baker Act?',
                'answer'   => 'The Virginia Graeme Baker Pool and Spa Safety Act is a federal law requiring public pools and spas to have compliant drain covers to prevent suction entrapment. Violations of this law can serve as evidence of negligence in a drowning wrongful death case.',
            ),
            array(
                'question' => 'Can I sue an apartment complex if my child drowned in their pool?',
                'answer'   => 'Yes. Apartment complexes and HOAs that maintain pools have a duty to comply with safety regulations, including fencing, gate locks, and signage. The "attractive nuisance" doctrine may impose additional duties regarding child safety.',
            ),
            array(
                'question' => 'What is the statute of limitations for a drowning wrongful death claim?',
                'answer'   => 'In Georgia, wrongful death claims must be filed within 2 years of the date of death (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530).',
            ),
            array(
                'question' => 'Do drowning victims suffer before death?',
                'answer'   => 'Medical evidence indicates that drowning victims often experience a period of conscious terror and struggling before losing consciousness. This pre-death suffering is compensable through a survival action in addition to the wrongful death claim.',
            ),
        ),
    ),

    /* ============================================================
       8. Pedestrian and Cyclist Fatality
       ============================================================ */
    array(
        'title'   => 'Pedestrian and Cyclist Fatality Lawyers',
        'slug'    => 'pedestrian-cyclist-fatality',
        'excerpt' => 'Lost a loved one in a pedestrian or cyclist accident in Georgia or South Carolina? Our wrongful death attorneys pursue claims against negligent drivers, municipalities, and other responsible parties.',
        'content' => <<<'HTML'
<h2>Pedestrian and Cyclist Fatality Wrongful Death Claims in Georgia &amp; South Carolina</h2>
<p>Pedestrians and cyclists are the most vulnerable users of our roadways. Without the protection of a vehicle's safety features, a collision with a car or truck is often fatal. The <a href="https://www.nhtsa.gov/road-safety/pedestrian-safety" target="_blank" rel="noopener">NHTSA</a> reports that over 7,500 pedestrians and nearly 1,000 cyclists are killed in traffic crashes each year in the United States, and these numbers have been rising steadily. Georgia and South Carolina consistently rank among the most dangerous states for pedestrians and cyclists.</p>
<p>At Roden Law, our pedestrian and cyclist fatality lawyers represent families across Georgia and South Carolina who have lost loved ones to negligent drivers. Whether your loved one was walking, jogging, cycling, or using a wheelchair, we pursue full accountability and maximum compensation from every responsible party.</p>

<h2>Georgia &amp; South Carolina Pedestrian and Cyclist Laws</h2>
<p>Georgia law (<a href="https://law.justia.com/codes/georgia/title-40/chapter-6/article-5/" target="_blank" rel="noopener">O.C.G.A. § 40-6-90 et seq.</a>) requires drivers to exercise due care to avoid colliding with pedestrians and to yield the right of way to pedestrians in crosswalks. Georgia's bicycle safety law (O.C.G.A. § 40-6-292) requires drivers to maintain a safe passing distance of at least 3 feet when overtaking a cyclist.</p>
<p>South Carolina requires drivers to yield to pedestrians in crosswalks and exercise due care to avoid colliding with pedestrians and cyclists at all times. South Carolina's "Three-Foot Law" requires motorists to provide at least 3 feet of clearance when passing a cyclist. Violations of these laws establish negligence in a wrongful death claim.</p>

<h2>Common Causes of Pedestrian and Cyclist Fatalities</h2>
<p>Fatal pedestrian and cyclist accidents are most commonly caused by:</p>
<ul>
<li><strong>Distracted driving:</strong> Texting, phone calls, and GPS use diverting attention from the road</li>
<li><strong>Failure to yield:</strong> Drivers not yielding to pedestrians in crosswalks or cyclists in bike lanes</li>
<li><strong>Speeding:</strong> Higher speeds dramatically increase pedestrian and cyclist fatality rates</li>
<li><strong>Drunk and impaired driving:</strong> Reduced reaction time and impaired judgment</li>
<li><strong>Left-turn and right-hook crashes:</strong> Drivers turning across pedestrian crosswalks or cyclist paths</li>
<li><strong>Hit-and-run:</strong> Drivers fleeing the scene of a fatal pedestrian or cyclist crash</li>
<li><strong>Unsafe road design:</strong> Missing crosswalks, bike lanes, sidewalks, and adequate lighting</li>
<li><strong>Large vehicle blind spots:</strong> Trucks and SUVs with limited visibility striking pedestrians at intersections</li>
</ul>
<p>Our <a href="/pedestrian-accident-lawyers/">pedestrian accident lawyers</a> and <a href="/car-accident-lawyers/">car accident lawyers</a> have extensive experience with the unique dynamics of vehicle-pedestrian and vehicle-cyclist collisions.</p>

<h2>Municipal Liability for Unsafe Road Design</h2>
<p>In some cases, the municipality or state Department of Transportation may bear partial liability for a pedestrian or cyclist death if the road was designed or maintained in an unsafe manner. Missing crosswalks, absent pedestrian signals, lack of bike lanes, faded road markings, and insufficient lighting can all contribute to fatal accidents. Claims against government entities have special notice requirements and shorter deadlines — Georgia's ante litem notice requirement typically requires notice within 12 months, and South Carolina's South Carolina Tort Claims Act imposes specific procedures.</p>

<h2>Wrongful Death Damages for Pedestrian and Cyclist Fatalities</h2>
<p>Under Georgia's wrongful death statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-4/section-51-4-1/" target="_blank" rel="noopener">O.C.G.A. § 51-4-1 et seq.</a>) and South Carolina's (<a href="https://www.scstatehouse.gov/code/t15c051.php" target="_blank" rel="noopener">S.C. Code § 15-51-10 et seq.</a>), families may recover the full value of the deceased's life, including future earnings and contributions, pre-death pain and suffering, medical expenses, funeral costs, and loss of companionship. In hit-and-run cases, the deceased's uninsured motorist (UM) coverage may provide compensation when the at-fault driver is never identified.</p>

<h2>Contact Roden Law After a Pedestrian or Cyclist Fatality</h2>
<p>Time is critical in pedestrian and cyclist fatality cases. Surveillance camera footage from nearby businesses, traffic cameras, and dashcams must be preserved before it is overwritten. Georgia's statute of limitations is 2 years (O.C.G.A. § 9-3-33) and South Carolina's is 3 years (S.C. Code § 15-3-530), but claims against government entities may have shorter deadlines. Contact Roden Law immediately for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What if the driver who killed my loved one fled the scene?',
                'answer'   => 'In hit-and-run fatalities, the deceased\'s uninsured motorist (UM) coverage may provide compensation. Additionally, if the driver is later identified, a wrongful death claim can be filed. Our attorneys work with law enforcement and private investigators to identify hit-and-run drivers.',
            ),
            array(
                'question' => 'Can I sue the city if poor road design contributed to the death?',
                'answer'   => 'Potentially. If missing crosswalks, absent traffic signals, lack of bike lanes, or insufficient lighting contributed to the accident, the municipality or state DOT may bear partial liability. Claims against government entities have special procedures and shorter deadlines.',
            ),
            array(
                'question' => 'Does comparative fault apply if the pedestrian or cyclist was partially at fault?',
                'answer'   => 'Yes. Georgia allows recovery if the deceased was less than 50% at fault (O.C.G.A. § 51-12-33), and South Carolina allows recovery if less than 51% at fault. Damages are reduced by the percentage of fault attributed to the deceased.',
            ),
            array(
                'question' => 'Why are pedestrian and cyclist fatalities increasing?',
                'answer'   => 'Researchers attribute rising pedestrian and cyclist deaths to increased distracted driving (smartphone use), the growing popularity of larger vehicles (SUVs and trucks with bigger blind spots), higher speeds on roadways, and insufficient pedestrian and cycling infrastructure.',
            ),
            array(
                'question' => 'What is the statute of limitations for a pedestrian or cyclist fatality claim?',
                'answer'   => 'In Georgia, the wrongful death statute of limitations is 2 years from the date of death (O.C.G.A. § 9-3-33). In South Carolina, it is 3 years (S.C. Code § 15-3-530). Claims against government entities for unsafe road design may have shorter notice requirements.',
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
