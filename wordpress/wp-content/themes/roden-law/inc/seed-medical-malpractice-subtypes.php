<?php
/**
 * Seeder: 8 Medical Malpractice Sub-Type Pages
 *
 * Creates 8 child posts under the medical-malpractice-lawyers pillar, each
 * covering a specific type of medical negligence.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-medical-malpractice-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: medical-malpractice-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'medical-malpractice-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'medical-malpractice-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "medical-malpractice-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'medical-malpractice', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Medical Malpractice', 'practice_category', array( 'slug' => 'medical-malpractice' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Surgical Error
       ============================================================ */
    array(
        'title'   => 'Surgical Error Lawyers',
        'slug'    => 'surgical-error',
        'excerpt' => 'Suffered a surgical error in Georgia or South Carolina? Our medical malpractice attorneys hold negligent surgeons and hospitals accountable for wrong-site surgery, retained instruments, and other preventable mistakes.',
        'content' => <<<'HTML'
<h2>Surgical Error Claims in Georgia &amp; South Carolina</h2>
<p>Surgical errors are among the most devastating forms of medical malpractice. When a surgeon operates on the wrong body part, leaves instruments inside a patient, damages healthy tissue, or performs an unnecessary procedure, the consequences can be catastrophic and permanent. According to a landmark study published by <a href="https://pubmed.ncbi.nlm.nih.gov/" target="_blank" rel="noopener">Johns Hopkins researchers</a>, medical errors — including surgical mistakes — are the third leading cause of death in the United States, claiming an estimated 250,000 lives annually.</p>
<p>At Roden Law, our surgical error lawyers represent patients across Georgia and South Carolina who are harmed by preventable surgical mistakes. These cases require specialized legal and medical expertise to prove that the surgeon deviated from the accepted standard of care and that this deviation directly caused the patient's injuries.</p>

<h2>Georgia &amp; South Carolina Medical Malpractice Requirements</h2>
<p>Medical malpractice claims in Georgia require an expert affidavit at the time of filing. Under <a href="https://law.justia.com/codes/georgia/title-9/chapter-11/article-2/section-9-11-9-1/" target="_blank" rel="noopener">O.C.G.A. § 9-11-9.1</a>, the plaintiff must attach an affidavit from a qualified medical expert stating that at least one act of negligence occurred and identifying the specific standard of care that was violated. South Carolina imposes a similar requirement under <a href="https://www.scstatehouse.gov/code/t15c079.php" target="_blank" rel="noopener">S.C. Code § 15-79-125</a>, requiring a Notice of Intent to File Suit accompanied by an expert opinion before a medical malpractice lawsuit can proceed.</p>
<p>Georgia also imposes a statute of repose for medical malpractice claims. Under <a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-5/section-9-3-71/" target="_blank" rel="noopener">O.C.G.A. § 9-3-71</a>, claims must generally be brought within five years of the negligent act, regardless of when the injury was discovered, with limited exceptions for foreign objects left in the body.</p>

<h2>Common Types of Surgical Errors</h2>
<p>Surgical errors that may give rise to medical malpractice claims include:</p>
<ul>
<li><strong>Wrong-site surgery:</strong> Operating on the wrong body part, wrong side, or wrong patient</li>
<li><strong>Retained surgical instruments:</strong> Sponges, clamps, needles, or other tools left inside the patient</li>
<li><strong>Nerve damage:</strong> Severing or compressing nerves during the procedure, causing numbness, paralysis, or chronic pain</li>
<li><strong>Organ perforation:</strong> Accidentally puncturing organs during laparoscopic or abdominal surgery</li>
<li><strong>Excessive bleeding:</strong> Failure to control hemorrhaging during or after surgery</li>
<li><strong>Post-operative infection:</strong> Failure to maintain sterile conditions or properly close incisions</li>
</ul>
<p>Some surgical errors result in complications that require additional corrective surgeries, while others cause permanent disability or death. In fatal cases, our <a href="/wrongful-death-lawyers/medical-malpractice-death/">medical malpractice death lawyers</a> can help the family pursue a wrongful death claim. Surgical errors involving <a href="/medical-malpractice-lawyers/anesthesia-error/">anesthesia</a> are addressed on our dedicated anesthesia error page.</p>

<h2>"Never Events" and Hospital Accountability</h2>
<p>The medical community classifies certain surgical errors as "never events" — mistakes so egregious they should never occur. Wrong-site surgery and retained foreign objects are the most commonly cited never events. The <a href="https://www.jointcommission.org/" target="_blank" rel="noopener">Joint Commission</a>, which accredits hospitals nationwide, requires implementation of the Universal Protocol — including pre-surgical verification, surgical site marking, and a time-out before incision — to prevent these errors. When a hospital fails to enforce these protocols, it may share liability with the negligent surgeon.</p>

<h2>Damages in Surgical Error Cases</h2>
<p>Victims of surgical errors may recover compensation for additional corrective surgeries and medical treatment, lost income during extended recovery, pain and suffering, permanent disability and loss of function, emotional distress and diminished quality of life, and future medical care needs. Georgia caps non-economic damages in medical malpractice cases in certain circumstances, while South Carolina imposes caps under its tort reform provisions. Our attorneys work to maximize your recovery within these frameworks.</p>

<h2>Contact Roden Law for a Surgical Error Case</h2>
<p>Surgical error cases are medically and legally complex. Our attorneys work with board-certified medical experts to review operative reports, medical records, and hospital protocols to build a strong case for negligence. Contact Roden Law for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the expert affidavit requirement in Georgia medical malpractice cases?',
                'answer'   => 'Under O.C.G.A. § 9-11-9.1, you must file an affidavit from a qualified medical expert simultaneously with your complaint. The affidavit must identify at least one negligent act and the standard of care that was violated. Failure to include this affidavit can result in dismissal.',
            ),
            array(
                'question' => 'What are "never events" in surgery?',
                'answer'   => 'Never events are surgical errors so serious they should never occur, such as wrong-site surgery, wrong-patient surgery, and retained surgical instruments. These events often establish clear negligence because they result from failures to follow mandatory safety protocols.',
            ),
            array(
                'question' => 'Can I sue the hospital in addition to the surgeon?',
                'answer'   => 'Yes. Hospitals may be liable under theories of corporate negligence (failure to enforce safety protocols) or vicarious liability (if the surgeon was a hospital employee rather than an independent contractor). Our attorneys investigate all potential defendants.',
            ),
            array(
                'question' => 'What is the statute of limitations for surgical error claims?',
                'answer'   => 'In Georgia, the general statute of limitations is 2 years (O.C.G.A. § 9-3-33), with a 5-year statute of repose (O.C.G.A. § 9-3-71). In South Carolina, you have 3 years from the date of the injury or discovery (S.C. Code § 15-3-545). Exceptions may apply for retained foreign objects.',
            ),
            array(
                'question' => 'How do you prove a surgical error case?',
                'answer'   => 'Surgical error cases require expert medical testimony establishing the accepted standard of care, how the surgeon deviated from it, and how that deviation caused your injuries. Evidence includes operative reports, medical records, imaging studies, and hospital protocol documentation.',
            ),
        ),
    ),

    /* ============================================================
       2. Misdiagnosis and Delayed Diagnosis
       ============================================================ */
    array(
        'title'   => 'Misdiagnosis and Delayed Diagnosis Lawyers',
        'slug'    => 'misdiagnosis-delayed-diagnosis',
        'excerpt' => 'Harmed by a misdiagnosis or delayed diagnosis in Georgia or South Carolina? Our medical malpractice lawyers pursue claims when doctors fail to identify serious conditions like cancer, heart disease, and infections in time.',
        'content' => <<<'HTML'
<h2>Misdiagnosis and Delayed Diagnosis Claims in Georgia &amp; South Carolina</h2>
<p>Diagnostic errors are the most common type of medical malpractice in the United States. A report by the <a href="https://www.nationalacademies.org/our-work/improving-diagnosis-in-health-care" target="_blank" rel="noopener">National Academies of Sciences, Engineering, and Medicine</a> found that most Americans will experience at least one diagnostic error in their lifetime, and that diagnostic failures contribute to approximately 10% of patient deaths. When a doctor misdiagnoses a serious condition, fails to order appropriate tests, or delays a critical diagnosis, the patient may lose valuable treatment time and suffer preventable harm.</p>
<p>At Roden Law, our misdiagnosis and delayed diagnosis lawyers represent patients across Georgia and South Carolina who are harmed by diagnostic failures. Whether your doctor missed cancer, failed to diagnose a heart attack or stroke, or confused your symptoms with a less serious condition, we pursue the full compensation you deserve.</p>

<h2>Common Misdiagnosed and Delayed Conditions</h2>
<p>Certain medical conditions are misdiagnosed or delayed with alarming frequency:</p>
<ul>
<li><strong>Cancer:</strong> Failure to order biopsies, misread pathology slides, or follow up on abnormal screening results</li>
<li><strong>Heart attack and stroke:</strong> Symptoms dismissed as anxiety, indigestion, or musculoskeletal pain — particularly in women</li>
<li><strong>Infections and sepsis:</strong> Failure to identify infections before they become life-threatening</li>
<li><strong>Appendicitis:</strong> Misdiagnosed as gastrointestinal issues until the appendix ruptures</li>
<li><strong>Pulmonary embolism:</strong> Blood clots mistaken for pneumonia, anxiety, or muscle strain</li>
<li><strong>Meningitis:</strong> Symptoms attributed to the flu or migraine until the infection progresses</li>
<li><strong>Ectopic pregnancy:</strong> Failure to diagnose before rupture, causing internal bleeding</li>
</ul>
<p>Many diagnostic failures in <a href="/medical-malpractice-lawyers/emergency-room-negligence/">emergency rooms</a> occur because of overcrowding, rushed assessments, and failure to order appropriate diagnostic tests. When misdiagnosis results in death, our <a href="/wrongful-death-lawyers/medical-malpractice-death/">medical malpractice wrongful death lawyers</a> can help the family pursue justice.</p>

<h2>Proving a Misdiagnosis Claim</h2>
<p>To succeed in a misdiagnosis case, you must demonstrate three elements: (1) a doctor-patient relationship existed, creating a duty of care; (2) the doctor failed to meet the accepted standard of care in diagnosing your condition — meaning a competent doctor in the same specialty would have made the correct diagnosis under similar circumstances; and (3) the misdiagnosis or delay directly caused you harm that would not have occurred with a timely and accurate diagnosis.</p>
<p>Georgia requires a medical expert affidavit under <a href="https://law.justia.com/codes/georgia/title-9/chapter-11/article-2/section-9-11-9-1/" target="_blank" rel="noopener">O.C.G.A. § 9-11-9.1</a> to be filed with the complaint, and South Carolina requires a Notice of Intent and expert opinion under <a href="https://www.scstatehouse.gov/code/t15c079.php" target="_blank" rel="noopener">S.C. Code § 15-79-125</a>. Our attorneys work with qualified medical experts in the relevant specialty to establish the standard of care and how the defendant failed to meet it.</p>

<h2>The "Differential Diagnosis" Standard</h2>
<p>Courts evaluate diagnostic accuracy using the "differential diagnosis" method — the systematic process doctors use to identify a disease by ruling out possible conditions based on symptoms, test results, and medical history. If a doctor failed to include the correct diagnosis on their differential list, failed to order tests that would have confirmed or ruled out a condition, or failed to follow up on abnormal results, these failures may constitute negligence.</p>

<h2>Damages from Diagnostic Errors</h2>
<p>The harm from misdiagnosis depends on the condition involved. Delayed cancer diagnosis may allow the disease to progress to a later stage requiring more aggressive treatment with lower survival rates. Missed heart attacks and strokes cause permanent cardiac and neurological damage that timely treatment could have prevented. Our attorneys pursue compensation for all additional medical treatment necessitated by the delay, lost income, pain and suffering, reduced life expectancy, and diminished quality of life. If a delayed diagnosis resulted in a <a href="/brain-injury-lawyers/">traumatic brain injury</a>, such as from an undiagnosed stroke, additional specialized damages may apply.</p>

<h2>Contact Roden Law for a Misdiagnosis Case</h2>
<p>Time is critical in misdiagnosis cases — both for your health and your legal rights. Georgia's statute of repose (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-5/section-9-3-71/" target="_blank" rel="noopener">O.C.G.A. § 9-3-71</a>) imposes an absolute 5-year deadline from the date of the negligent act, regardless of when you discovered the error. Contact Roden Law for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the difference between misdiagnosis and delayed diagnosis?',
                'answer'   => 'Misdiagnosis occurs when a doctor identifies the wrong condition entirely. Delayed diagnosis means the doctor eventually identifies the correct condition, but the delay caused the patient to miss the window for optimal treatment, allowing the condition to worsen.',
            ),
            array(
                'question' => 'How do I prove a misdiagnosis case?',
                'answer'   => 'You must show a doctor-patient relationship existed, the doctor failed to meet the accepted standard of care in diagnosing your condition, and the diagnostic error directly caused harm. A qualified medical expert must provide an affidavit (Georgia) or opinion (South Carolina) supporting your claim.',
            ),
            array(
                'question' => 'What is the most commonly misdiagnosed condition?',
                'answer'   => 'Cancer is the most commonly misdiagnosed condition in malpractice claims, particularly breast cancer, lung cancer, and colorectal cancer. Other frequently misdiagnosed conditions include heart attacks, strokes, and infections.',
            ),
            array(
                'question' => 'Can I sue if my cancer was diagnosed late?',
                'answer'   => 'Yes, if a doctor failed to order appropriate screening tests, misread test results, or failed to follow up on abnormal findings, and the delay caused your cancer to progress to a more advanced stage requiring more aggressive treatment.',
            ),
            array(
                'question' => 'What is the statute of repose for medical malpractice in Georgia?',
                'answer'   => 'Under O.C.G.A. § 9-3-71, medical malpractice claims must generally be filed within 5 years of the negligent act, regardless of when the injury was discovered. This is in addition to the 2-year statute of limitations that begins when the injury is or should have been discovered.',
            ),
        ),
    ),

    /* ============================================================
       3. Medication Error
       ============================================================ */
    array(
        'title'   => 'Medication Error Lawyers',
        'slug'    => 'medication-error',
        'excerpt' => 'Harmed by a medication error in Georgia or South Carolina? Our medical malpractice attorneys pursue claims for wrong prescriptions, dosage errors, dangerous drug interactions, and pharmacy dispensing mistakes.',
        'content' => <<<'HTML'
<h2>Medication Error Claims in Georgia &amp; South Carolina</h2>
<p>Medication errors harm an estimated 1.5 million Americans each year, according to the <a href="https://www.fda.gov/drugs/drug-safety-and-availability/medication-errors-related-cder-regulated-drug-products" target="_blank" rel="noopener">U.S. Food and Drug Administration (FDA)</a>. These errors — which include prescribing the wrong medication, dispensing incorrect dosages, failing to check for dangerous drug interactions, and administering medication to the wrong patient — can cause severe adverse reactions, organ damage, and death. In hospital settings, medication errors are one of the most common types of preventable medical harm.</p>
<p>At Roden Law, our medication error lawyers represent patients across Georgia and South Carolina who are injured by negligent prescribing, dispensing, or administration of medications. These cases may involve doctors, nurses, pharmacists, hospitals, and pharmaceutical manufacturers, and require careful investigation to identify all responsible parties.</p>

<h2>Types of Medication Errors</h2>
<p>Medication errors can occur at every stage of the medication process:</p>
<ul>
<li><strong>Prescribing errors:</strong> Wrong medication, wrong dosage, failure to account for allergies or drug interactions</li>
<li><strong>Dispensing errors:</strong> Pharmacy provides the wrong drug, wrong strength, or wrong quantity</li>
<li><strong>Administration errors:</strong> Wrong patient, wrong route (oral vs. IV), wrong timing, or wrong dose given by nursing staff</li>
<li><strong>Monitoring errors:</strong> Failure to monitor drug levels, kidney function, or other parameters during treatment</li>
<li><strong>Communication errors:</strong> Illegible prescriptions, confusing drug names, or incomplete medication reconciliation during transitions of care</li>
</ul>
<p>Medication errors in <a href="/medical-malpractice-lawyers/emergency-room-negligence/">emergency room settings</a> are particularly dangerous due to the fast-paced environment and the frequency of multiple simultaneous medications. When medication errors cause fatal reactions, our <a href="/wrongful-death-lawyers/medical-malpractice-death/">medical malpractice death lawyers</a> pursue wrongful death claims on behalf of the family.</p>

<h2>Georgia &amp; South Carolina Legal Requirements</h2>
<p>Medication error claims are a form of medical malpractice and are subject to the same procedural requirements. In Georgia, the plaintiff must file an expert affidavit under <a href="https://law.justia.com/codes/georgia/title-9/chapter-11/article-2/section-9-11-9-1/" target="_blank" rel="noopener">O.C.G.A. § 9-11-9.1</a> identifying the specific negligent act. South Carolina requires a Notice of Intent to File Suit and expert opinion under <a href="https://www.scstatehouse.gov/code/t15c079.php" target="_blank" rel="noopener">S.C. Code § 15-79-125</a>.</p>
<p>Claims against pharmacies may also involve negligence theories separate from medical malpractice, depending on whether the error is classified as a professional or commercial act. Georgia's statute of repose (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-5/section-9-3-71/" target="_blank" rel="noopener">O.C.G.A. § 9-3-71</a>) imposes a 5-year outer deadline for medical malpractice claims.</p>

<h2>Identifying Liable Parties</h2>
<p>Multiple parties may be responsible for a single medication error:</p>
<ul>
<li>The prescribing physician who failed to check drug interactions or patient allergies</li>
<li>The pharmacist who dispensed the wrong medication or incorrect dosage</li>
<li>The nurse who administered the medication to the wrong patient or via the wrong route</li>
<li>The hospital whose systems failed to catch the error through automated safety checks</li>
<li>The pharmaceutical manufacturer if confusing packaging or labeling contributed to the error</li>
</ul>
<p>Our attorneys review electronic health records, pharmacy logs, medication administration records (MARs), and automated dispensing system data to trace the error to its source and hold all negligent parties accountable.</p>

<h2>Damages from Medication Errors</h2>
<p>Medication errors can cause a range of harm, from allergic reactions and organ damage to overdose, coma, and death. Victims may recover compensation for all medical expenses related to treating the adverse reaction, hospitalization costs, lost income, pain and suffering, long-term organ damage or disability, and future medical monitoring needs. Contact Roden Law for a free consultation — there is no fee unless we win your case.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue a pharmacist for dispensing the wrong medication?',
                'answer'   => 'Yes. Pharmacists have a professional duty to dispense medications accurately, verify prescriptions, and check for dangerous drug interactions. If a pharmacist\'s error caused you harm, you may have a valid malpractice or negligence claim.',
            ),
            array(
                'question' => 'What should I do if I suspect a medication error?',
                'answer'   => 'Seek immediate medical attention if you are experiencing adverse effects. Preserve the medication and packaging, document your symptoms, request copies of your medical records and prescription history, and contact an attorney before the evidence is lost.',
            ),
            array(
                'question' => 'Who is liable for a medication error in a hospital?',
                'answer'   => 'Multiple parties may be liable, including the prescribing doctor, the dispensing pharmacist, the administering nurse, and the hospital itself. Our attorneys investigate the chain of events to identify all responsible parties.',
            ),
            array(
                'question' => 'Are medication errors common?',
                'answer'   => 'Yes. The FDA estimates that medication errors harm approximately 1.5 million Americans each year. In hospitals, medication errors are one of the most frequent types of preventable adverse events.',
            ),
            array(
                'question' => 'What is the statute of limitations for a medication error claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years from discovery, with a 5-year statute of repose (O.C.G.A. § 9-3-71). In South Carolina, the deadline is 3 years from the date of injury or discovery (S.C. Code § 15-3-545).',
            ),
        ),
    ),

    /* ============================================================
       4. Birth Injury
       ============================================================ */
    array(
        'title'   => 'Birth Injury Lawyers',
        'slug'    => 'birth-injury',
        'excerpt' => 'Did your child suffer a birth injury due to medical negligence in Georgia or South Carolina? Our attorneys fight for families harmed by preventable delivery room errors, including cerebral palsy, Erb\'s palsy, and brain injuries.',
        'content' => <<<'HTML'
<h2>Birth Injury Claims in Georgia &amp; South Carolina</h2>
<p>The birth of a child should be a joyful event, but medical negligence during pregnancy, labor, or delivery can cause devastating injuries that affect a child for life. According to the <a href="https://www.cdc.gov/reproductivehealth/" target="_blank" rel="noopener">Centers for Disease Control and Prevention (CDC)</a>, birth injuries affect approximately 7 in every 1,000 births in the United States. When these injuries result from preventable medical errors, families deserve justice and the resources to provide their child with the care they need.</p>
<p>At Roden Law, our birth injury lawyers represent families across Georgia and South Carolina whose children are harmed by obstetric negligence. These cases are among the most complex in medical malpractice law, requiring expert analysis of fetal monitoring strips, delivery room decisions, and neonatal care protocols.</p>

<h2>Common Types of Birth Injuries</h2>
<p>Birth injuries caused by medical negligence include:</p>
<ul>
<li><strong>Cerebral palsy:</strong> Often caused by oxygen deprivation (hypoxia) during labor and delivery</li>
<li><strong>Erb's palsy and brachial plexus injuries:</strong> Nerve damage from excessive force during delivery, particularly with shoulder dystocia</li>
<li><strong>Hypoxic-ischemic encephalopathy (HIE):</strong> Brain damage from insufficient oxygen supply to the newborn</li>
<li><strong>Intracranial hemorrhage:</strong> Bleeding in the brain caused by traumatic delivery or improper use of forceps or vacuum extractors</li>
<li><strong>Facial nerve paralysis:</strong> Damage to facial nerves from pressure during delivery or improper instrument use</li>
<li><strong>Bone fractures:</strong> Clavicle and humerus fractures from difficult deliveries</li>
<li><strong>Spinal cord injuries:</strong> Caused by excessive traction or rotation during delivery</li>
</ul>
<p>Many birth injuries result in permanent <a href="/brain-injury-lawyers/">brain injuries</a> that require lifelong medical care, therapy, and adaptive support. In the most tragic cases, birth injuries can be fatal — our <a href="/wrongful-death-lawyers/">wrongful death lawyers</a> help families who have lost a child due to delivery room negligence.</p>

<h2>Causes of Preventable Birth Injuries</h2>
<p>Medical negligence during childbirth takes many forms:</p>
<ul>
<li>Failure to monitor fetal heart rate patterns indicating distress</li>
<li>Delayed decision to perform an emergency cesarean section</li>
<li>Improper use of forceps or vacuum extraction devices</li>
<li>Excessive force during delivery, particularly in shoulder dystocia situations</li>
<li>Failure to manage preeclampsia, gestational diabetes, or other pregnancy complications</li>
<li>Failure to diagnose and respond to umbilical cord complications</li>
<li>Inadequate neonatal resuscitation</li>
</ul>

<h2>Georgia &amp; South Carolina Birth Injury Law</h2>
<p>Birth injury claims are subject to medical malpractice procedural requirements. Georgia requires an expert affidavit under <a href="https://law.justia.com/codes/georgia/title-9/chapter-11/article-2/section-9-11-9-1/" target="_blank" rel="noopener">O.C.G.A. § 9-11-9.1</a>, and South Carolina requires a Notice of Intent and expert opinion under <a href="https://www.scstatehouse.gov/code/t15c079.php" target="_blank" rel="noopener">S.C. Code § 15-79-125</a>.</p>
<p>An important consideration in birth injury cases is the statute of limitations for minors. In Georgia, minors generally have until their seventh birthday to file a medical malpractice claim, subject to the 5-year statute of repose (O.C.G.A. § 9-3-73). South Carolina allows minors to file suit within the normal limitations period after reaching the age of majority. These extended deadlines give families additional time, but early investigation is always advisable.</p>

<h2>Lifetime Damages in Birth Injury Cases</h2>
<p>Birth injury cases often involve the most significant damages in medical malpractice law because they encompass a lifetime of care needs. Recoverable damages include all past and future medical expenses including surgeries, therapy, and medications; costs of assistive devices, home modifications, and adaptive technology; special education and developmental therapy expenses; lost future earning capacity; pain and suffering endured by the child; and parents' emotional distress and loss of the parent-child relationship. Our attorneys work with life care planning experts and economists to calculate the full cost of your child's lifetime needs. Contact Roden Law for a free, confidential consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the statute of limitations for a birth injury claim?',
                'answer'   => 'In Georgia, minors generally have until their seventh birthday to file a medical malpractice claim (O.C.G.A. § 9-3-73), subject to the 5-year statute of repose. South Carolina allows claims to be filed within the standard limitations period after the child reaches the age of majority. Early investigation is strongly recommended.',
            ),
            array(
                'question' => 'How do I know if my child\'s birth injury was caused by medical negligence?',
                'answer'   => 'Not all birth injuries are the result of negligence. An experienced medical malpractice attorney can review your medical records, fetal monitoring strips, and delivery documentation with qualified experts to determine whether the standard of care was violated.',
            ),
            array(
                'question' => 'Can I sue for a birth injury that caused cerebral palsy?',
                'answer'   => 'Yes, if the cerebral palsy resulted from preventable medical negligence — such as failure to monitor fetal distress, delayed C-section, or improper management of oxygen deprivation during delivery. Expert medical analysis is required to establish causation.',
            ),
            array(
                'question' => 'What damages are available in a birth injury case?',
                'answer'   => 'Birth injury damages can be substantial, covering lifetime medical care, therapy, adaptive equipment, special education, lost future earnings, and pain and suffering. Life care planning experts help calculate the full scope of your child\'s needs.',
            ),
            array(
                'question' => 'Who can be held liable for a birth injury?',
                'answer'   => 'Potentially liable parties include the obstetrician, nurses, anesthesiologist, hospital, and midwife — anyone whose negligence during prenatal care, labor, or delivery contributed to the injury.',
            ),
        ),
    ),

    /* ============================================================
       5. Anesthesia Error
       ============================================================ */
    array(
        'title'   => 'Anesthesia Error Lawyers',
        'slug'    => 'anesthesia-error',
        'excerpt' => 'Suffered an anesthesia error during surgery in Georgia or South Carolina? Our medical malpractice attorneys pursue claims for dosage errors, intubation injuries, failure to monitor, and anesthesia awareness.',
        'content' => <<<'HTML'
<h2>Anesthesia Error Claims in Georgia &amp; South Carolina</h2>
<p>Anesthesia is a critical component of surgical care, and errors in its administration can have catastrophic consequences — from brain damage caused by oxygen deprivation to death from overdose or allergic reaction. The <a href="https://www.asahq.org/" target="_blank" rel="noopener">American Society of Anesthesiologists (ASA)</a> has made significant advances in anesthesia safety, but preventable errors continue to occur when anesthesiologists, nurse anesthetists (CRNAs), and surgical teams fail to follow established protocols.</p>
<p>At Roden Law, our anesthesia error lawyers represent patients across Georgia and South Carolina who are harmed by negligent anesthesia care. These cases demand specialized knowledge of anesthesia pharmacology, patient monitoring standards, and airway management protocols.</p>

<h2>Types of Anesthesia Errors</h2>
<p>Anesthesia errors that may constitute medical malpractice include:</p>
<ul>
<li><strong>Dosage errors:</strong> Administering too much or too little anesthetic, leading to overdose or intraoperative awareness</li>
<li><strong>Failure to review patient history:</strong> Ignoring allergies, current medications, or medical conditions that affect anesthesia tolerance</li>
<li><strong>Intubation injuries:</strong> Damage to the teeth, throat, vocal cords, or trachea during airway management</li>
<li><strong>Failure to monitor:</strong> Inadequate monitoring of vital signs including oxygen saturation, blood pressure, heart rate, and end-tidal CO2</li>
<li><strong>Delayed response to complications:</strong> Failing to quickly address malignant hyperthermia, anaphylaxis, or respiratory distress</li>
<li><strong>Anesthesia awareness:</strong> Patient regains consciousness during surgery while paralyzed and unable to communicate</li>
<li><strong>Post-anesthesia negligence:</strong> Inadequate monitoring in the recovery room leading to respiratory arrest</li>
</ul>
<p>Anesthesia errors frequently occur alongside <a href="/medical-malpractice-lawyers/surgical-error/">surgical errors</a>, and our attorneys evaluate both the surgical and anesthesia care in every operating room injury case.</p>

<h2>Georgia &amp; South Carolina Legal Framework</h2>
<p>Anesthesia error claims are subject to the same procedural requirements as other medical malpractice cases. Georgia requires an expert affidavit under <a href="https://law.justia.com/codes/georgia/title-9/chapter-11/article-2/section-9-11-9-1/" target="_blank" rel="noopener">O.C.G.A. § 9-11-9.1</a>, and South Carolina requires pre-suit notice and expert opinion under <a href="https://www.scstatehouse.gov/code/t15c079.php" target="_blank" rel="noopener">S.C. Code § 15-79-125</a>. Georgia's 5-year statute of repose (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-5/section-9-3-71/" target="_blank" rel="noopener">O.C.G.A. § 9-3-71</a>) applies as an outer deadline.</p>
<p>Liability may extend to the anesthesiologist, the CRNA, the supervising physician, and the hospital or surgical center. Georgia and South Carolina courts apply different rules regarding the liability of supervising physicians for CRNA negligence, and our attorneys navigate these distinctions to ensure all responsible parties are held accountable.</p>

<h2>Brain Injuries from Anesthesia Errors</h2>
<p>The most devastating anesthesia errors involve oxygen deprivation (anoxia or hypoxia), which can cause permanent <a href="/brain-injury-lawyers/">brain injuries</a> within minutes. When an anesthesiologist fails to maintain a secure airway, monitor oxygen levels, or respond to a breathing emergency, the resulting brain damage may include cognitive impairment, memory loss, personality changes, seizure disorders, coma, and death. These cases require expert neurology and neuropsychology testimony to document the full extent of the injury.</p>

<h2>Anesthesia Awareness</h2>
<p>Anesthesia awareness occurs when a patient becomes conscious during surgery but remains paralyzed by muscle relaxants and unable to alert the surgical team. Patients who experience awareness may feel pain, pressure, and hear conversations while being unable to move or speak. This terrifying experience frequently leads to post-traumatic stress disorder (PTSD), anxiety, sleep disturbances, and lasting psychological harm. Anesthesia awareness typically results from inadequate dosing or failure to use brain function monitors such as the bispectral index (BIS).</p>

<h2>Contact Roden Law for an Anesthesia Error Case</h2>
<p>Anesthesia error cases require immediate investigation to preserve anesthesia records, monitoring data, and medication logs. Contact Roden Law for a free consultation — our attorneys work with anesthesiology experts to build strong cases for maximum compensation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is anesthesia awareness?',
                'answer'   => 'Anesthesia awareness occurs when a patient regains consciousness during surgery while still paralyzed by muscle relaxants, making them unable to move or speak. Patients may feel pain and hear conversations. This traumatic experience often leads to PTSD and constitutes medical malpractice when caused by improper dosing or monitoring.',
            ),
            array(
                'question' => 'Who is liable for an anesthesia error?',
                'answer'   => 'Potentially liable parties include the anesthesiologist, the nurse anesthetist (CRNA), the supervising physician, and the hospital or surgical center. Liability depends on the specific error and the employment or supervisory relationships involved.',
            ),
            array(
                'question' => 'Can anesthesia errors cause brain damage?',
                'answer'   => 'Yes. Anesthesia errors that result in oxygen deprivation can cause permanent brain injuries within minutes. Failure to maintain a secure airway or respond to a breathing emergency are among the most dangerous anesthesia errors.',
            ),
            array(
                'question' => 'What is the expert affidavit requirement for anesthesia error claims?',
                'answer'   => 'Georgia requires an expert affidavit filed with the complaint (O.C.G.A. § 9-11-9.1), and South Carolina requires a pre-suit Notice of Intent with an expert opinion (S.C. Code § 15-79-125). The expert must be qualified in anesthesiology or a related field.',
            ),
            array(
                'question' => 'How long do I have to file an anesthesia error claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years from the date of injury or discovery, with a 5-year statute of repose (O.C.G.A. § 9-3-71). In South Carolina, you have 3 years from the date of injury or discovery (S.C. Code § 15-3-545).',
            ),
        ),
    ),

    /* ============================================================
       6. Emergency Room Negligence
       ============================================================ */
    array(
        'title'   => 'Emergency Room Negligence Lawyers',
        'slug'    => 'emergency-room-negligence',
        'excerpt' => 'Harmed by emergency room negligence in Georgia or South Carolina? Our medical malpractice lawyers pursue claims for ER misdiagnosis, delayed treatment, premature discharge, and failure to triage.',
        'content' => <<<'HTML'
<h2>Emergency Room Negligence Claims in Georgia &amp; South Carolina</h2>
<p>Emergency rooms are high-pressure environments where life-and-death decisions must be made quickly. While the fast pace of ER medicine creates inherent challenges, patients still deserve competent care that meets the accepted standard. When ER doctors, nurses, and staff make negligent errors — misdiagnosing a heart attack, failing to triage a critical patient, or prematurely discharging someone with a serious condition — the consequences can be devastating. According to a study published in the <a href="https://www.acep.org/" target="_blank" rel="noopener">Annals of Emergency Medicine</a>, diagnostic errors occur in an estimated 5.7% of emergency department visits, affecting approximately 7.4 million patients annually in the United States.</p>
<p>At Roden Law, our emergency room negligence lawyers represent patients across Georgia and South Carolina who are harmed by ER medical errors. We understand the unique legal and medical complexities of these cases and work with emergency medicine experts to establish the applicable standard of care.</p>

<h2>Common Forms of Emergency Room Negligence</h2>
<p>ER negligence takes many forms, including:</p>
<ul>
<li><strong>Misdiagnosis or failure to diagnose:</strong> Missing heart attacks, strokes, appendicitis, pulmonary embolism, or meningitis</li>
<li><strong>Delayed treatment:</strong> Failure to triage critical patients promptly, resulting in deterioration</li>
<li><strong>Premature discharge:</strong> Sending patients home before their condition is properly evaluated or stabilized</li>
<li><strong>Medication errors:</strong> Wrong drugs, wrong doses, or failure to check for allergies and drug interactions</li>
<li><strong>Failure to order appropriate tests:</strong> Not performing CT scans, blood work, or imaging that would reveal a serious condition</li>
<li><strong>Inadequate follow-up instructions:</strong> Failing to advise patients on warning signs requiring return to the ER</li>
</ul>
<p>ER <a href="/medical-malpractice-lawyers/misdiagnosis-delayed-diagnosis/">misdiagnosis</a> is the most frequently cited form of emergency room negligence. <a href="/medical-malpractice-lawyers/medication-error/">Medication errors</a> in the ER are also common due to the chaotic environment and multiple simultaneous patients. When ER negligence results in death, our <a href="/wrongful-death-lawyers/medical-malpractice-death/">medical malpractice death lawyers</a> help families pursue wrongful death claims.</p>

<h2>EMTALA and the Duty to Screen and Stabilize</h2>
<p>The federal <a href="https://www.cms.gov/Regulations-and-Guidance/Legislation/EMTALA" target="_blank" rel="noopener">Emergency Medical Treatment and Labor Act (EMTALA)</a> requires all hospitals that participate in Medicare (virtually all hospitals) to provide a medical screening examination to anyone who arrives at the ER and to stabilize emergency medical conditions before discharge or transfer. Violations of EMTALA may give rise to federal claims in addition to state medical malpractice claims.</p>

<h2>Georgia &amp; South Carolina ER Malpractice Requirements</h2>
<p>Emergency room negligence claims are subject to the same procedural requirements as other medical malpractice cases. Georgia requires an expert affidavit under <a href="https://law.justia.com/codes/georgia/title-9/chapter-11/article-2/section-9-11-9-1/" target="_blank" rel="noopener">O.C.G.A. § 9-11-9.1</a>, and South Carolina requires pre-suit notice and expert opinion under <a href="https://www.scstatehouse.gov/code/t15c079.php" target="_blank" rel="noopener">S.C. Code § 15-79-125</a>.</p>
<p>An important consideration in ER negligence cases is the question of whether the ER physician is a hospital employee or an independent contractor. Many ERs are staffed by independent physician groups, which can affect hospital liability. Our attorneys investigate the employment structure to identify all liable parties.</p>

<h2>The "Emergency" Standard of Care</h2>
<p>While ER doctors are held to the standard of a reasonably competent emergency physician under similar circumstances, the emergency context is relevant. Courts recognize that ER physicians must often make rapid decisions with incomplete information. However, this does not excuse failure to order obvious tests, ignoring critical symptoms, or discharging patients without adequate evaluation. Georgia law considers the emergency circumstances but does not lower the fundamental duty of competent care.</p>

<h2>Contact Roden Law After ER Negligence</h2>
<p>If you or a loved one was harmed by emergency room negligence, contact Roden Law for a free consultation. Time is critical — Georgia's 5-year statute of repose (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-5/section-9-3-71/" target="_blank" rel="noopener">O.C.G.A. § 9-3-71</a>) creates an absolute outer deadline for filing. Our attorneys handle ER negligence cases on a contingency basis — no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Is the standard of care different in emergency rooms?',
                'answer'   => 'ER physicians are held to the standard of a reasonably competent emergency physician under similar circumstances. While courts consider the emergency context, this does not excuse clear negligence such as ignoring critical symptoms, failing to order obvious tests, or premature discharge.',
            ),
            array(
                'question' => 'What is EMTALA and how does it protect ER patients?',
                'answer'   => 'EMTALA is a federal law requiring hospitals to provide a medical screening examination to anyone who arrives at the ER and to stabilize emergency conditions before discharge or transfer. Violations of EMTALA can result in federal liability in addition to state malpractice claims.',
            ),
            array(
                'question' => 'Can I sue the hospital if the ER doctor was an independent contractor?',
                'answer'   => 'Potentially. While hospitals may argue the ER doctor was not their employee, courts in Georgia and South Carolina may still hold hospitals liable under apparent agency — if the hospital held the doctor out as its agent and the patient reasonably believed the doctor was a hospital employee.',
            ),
            array(
                'question' => 'What if I was sent home from the ER and my condition worsened?',
                'answer'   => 'Premature discharge is a common form of ER negligence. If the ER failed to properly evaluate your condition before sending you home, and you suffered additional harm as a result, you may have a valid medical malpractice claim.',
            ),
            array(
                'question' => 'How long do I have to file an ER negligence claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years from injury or discovery, with a 5-year statute of repose (O.C.G.A. § 9-3-71). In South Carolina, you have 3 years from the date of injury or discovery (S.C. Code § 15-3-545).',
            ),
        ),
    ),

    /* ============================================================
       7. Hospital-Acquired Infection
       ============================================================ */
    array(
        'title'   => 'Hospital-Acquired Infection Lawyers',
        'slug'    => 'hospital-acquired-infection',
        'excerpt' => 'Suffered a hospital-acquired infection in Georgia or South Carolina? Our medical malpractice attorneys pursue claims for MRSA, C. diff, sepsis, and other preventable healthcare-associated infections.',
        'content' => <<<'HTML'
<h2>Hospital-Acquired Infection Claims in Georgia &amp; South Carolina</h2>
<p>Hospital-acquired infections (HAIs) — also called healthcare-associated infections — affect approximately one in every 31 hospital patients on any given day, according to the <a href="https://www.cdc.gov/hai/" target="_blank" rel="noopener">Centers for Disease Control and Prevention (CDC)</a>. These preventable infections cause tens of thousands of deaths annually and add billions of dollars in healthcare costs. When hospitals fail to follow established infection control protocols, patients suffer needlessly from infections they did not have when they were admitted.</p>
<p>At Roden Law, our hospital-acquired infection lawyers represent patients across Georgia and South Carolina who contract infections due to substandard hygiene practices, inadequate sterilization, or failure to follow infection prevention guidelines. These cases require expert analysis of hospital infection control protocols, staffing practices, and epidemiological data.</p>

<h2>Common Hospital-Acquired Infections</h2>
<p>The most frequently litigated hospital-acquired infections include:</p>
<ul>
<li><strong>MRSA (Methicillin-resistant Staphylococcus aureus):</strong> An antibiotic-resistant bacterium spread through contact with contaminated surfaces or healthcare workers' hands</li>
<li><strong>C. difficile (Clostridioides difficile):</strong> A severe intestinal infection often triggered by antibiotic overuse</li>
<li><strong>Surgical site infections (SSIs):</strong> Infections at the site of a surgical incision due to improper sterile technique</li>
<li><strong>Central line-associated bloodstream infections (CLABSIs):</strong> Infections caused by bacteria entering the bloodstream through IV catheters</li>
<li><strong>Catheter-associated urinary tract infections (CAUTIs):</strong> UTIs caused by prolonged or improper use of urinary catheters</li>
<li><strong>Ventilator-associated pneumonia (VAP):</strong> Lung infections in patients on mechanical ventilators</li>
<li><strong>Sepsis:</strong> A life-threatening systemic response to infection that can lead to organ failure and death</li>
</ul>
<p>Hospital-acquired infections that lead to sepsis and death are among the most tragic cases we handle. If you lost a loved one to a preventable hospital infection, our <a href="/wrongful-death-lawyers/medical-malpractice-death/">medical malpractice death lawyers</a> can help your family pursue a wrongful death claim.</p>

<h2>How Hospitals Fail to Prevent Infections</h2>
<p>The CDC and the <a href="https://www.jointcommission.org/" target="_blank" rel="noopener">Joint Commission</a> establish detailed infection prevention guidelines that hospitals are expected to follow. Common failures that lead to HAIs include:</p>
<ul>
<li>Inadequate hand hygiene compliance among healthcare workers</li>
<li>Failure to properly sterilize surgical instruments and equipment</li>
<li>Improper insertion, maintenance, or timely removal of central lines and urinary catheters</li>
<li>Failure to isolate patients with known infectious conditions</li>
<li>Inadequate environmental cleaning and disinfection</li>
<li>Antibiotic overuse contributing to resistant organism development</li>
<li>Understaffing that prevents proper infection control oversight</li>
</ul>

<h2>Georgia &amp; South Carolina Legal Requirements</h2>
<p>Hospital-acquired infection claims are a form of medical malpractice subject to the expert affidavit requirement in Georgia (<a href="https://law.justia.com/codes/georgia/title-9/chapter-11/article-2/section-9-11-9-1/" target="_blank" rel="noopener">O.C.G.A. § 9-11-9.1</a>) and the Notice of Intent requirement in South Carolina (<a href="https://www.scstatehouse.gov/code/t15c079.php" target="_blank" rel="noopener">S.C. Code § 15-79-125</a>). Georgia's 5-year statute of repose (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-5/section-9-3-71/" target="_blank" rel="noopener">O.C.G.A. § 9-3-71</a>) applies as an outer deadline.</p>
<p>Proving that an infection was hospital-acquired rather than community-acquired requires expert epidemiological analysis. Our attorneys work with infectious disease specialists to establish when and how the infection was contracted and whether the hospital's infection control practices met the accepted standard of care.</p>

<h2>Damages in Hospital-Acquired Infection Cases</h2>
<p>Hospital-acquired infections can extend hospital stays by weeks or months, require additional surgeries, cause permanent organ damage, and in the worst cases result in amputation or death. Victims may recover compensation for all additional medical treatment, extended hospitalization costs, lost income, pain and suffering, permanent disability, and future medical care needs. Contact Roden Law for a free consultation — there is no fee unless we recover compensation for you.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'How do I prove my infection was acquired in the hospital?',
                'answer'   => 'Expert analysis of your medical records, admission cultures, and the timing of infection onset can establish that you did not have the infection upon admission. Infectious disease specialists compare hospital infection rates and protocol compliance to determine whether the infection was preventable.',
            ),
            array(
                'question' => 'Are all hospital infections the result of negligence?',
                'answer'   => 'Not necessarily. Some infections occur despite proper precautions. However, if the hospital failed to follow established infection control protocols — such as hand hygiene, sterile technique, or catheter care bundles — the infection may be the result of negligence.',
            ),
            array(
                'question' => 'What is MRSA and can I sue for a hospital MRSA infection?',
                'answer'   => 'MRSA is a drug-resistant staph infection commonly spread in healthcare settings. If the hospital failed to follow proper hygiene and isolation protocols, leading to your MRSA infection, you may have a valid medical malpractice claim.',
            ),
            array(
                'question' => 'Can a hospital-acquired infection lead to a wrongful death claim?',
                'answer'   => 'Yes. Hospital-acquired infections that progress to sepsis, organ failure, or other fatal complications can give rise to wrongful death claims if the infection resulted from the hospital\'s negligent infection control practices.',
            ),
            array(
                'question' => 'What is the statute of limitations for a hospital infection claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years from discovery, with a 5-year statute of repose (O.C.G.A. § 9-3-71). In South Carolina, the deadline is 3 years from the date of injury or discovery (S.C. Code § 15-3-545).',
            ),
        ),
    ),

    /* ============================================================
       8. Failure to Obtain Informed Consent
       ============================================================ */
    array(
        'title'   => 'Failure to Obtain Informed Consent Lawyers',
        'slug'    => 'informed-consent-failure',
        'excerpt' => 'Did your doctor fail to inform you of the risks before a procedure in Georgia or South Carolina? Our medical malpractice lawyers pursue informed consent claims when patients are not given the information needed to make treatment decisions.',
        'content' => <<<'HTML'
<h2>Informed Consent Claims in Georgia &amp; South Carolina</h2>
<p>Every patient has the legal right to make informed decisions about their medical care. Before performing a surgery, procedure, or treatment, a doctor must explain the nature of the proposed treatment, its material risks and potential complications, alternative treatment options, and the risks of foregoing treatment entirely. When a doctor fails to provide this information and the patient suffers harm from a risk they were not warned about, the patient may have an informed consent claim — a specific type of medical malpractice.</p>
<p>At Roden Law, our informed consent lawyers represent patients across Georgia and South Carolina who were not given the information they needed to make meaningful decisions about their medical care. These cases arise when patients suffer complications they would have avoided had they been properly informed of the risks and alternatives.</p>

<h2>Georgia Informed Consent Law</h2>
<p>Georgia's informed consent requirements are established through case law and statute. Under Georgia law, a doctor must disclose material risks that a reasonable patient would want to know in making a treatment decision. Georgia uses the "professional" standard — meaning the disclosure required is measured by what a reasonable medical practitioner in the same specialty would have disclosed under similar circumstances.</p>
<p>Georgia's medical malpractice framework applies to informed consent claims, including the expert affidavit requirement under <a href="https://law.justia.com/codes/georgia/title-9/chapter-11/article-2/section-9-11-9-1/" target="_blank" rel="noopener">O.C.G.A. § 9-11-9.1</a> and the 5-year statute of repose under <a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-5/section-9-3-71/" target="_blank" rel="noopener">O.C.G.A. § 9-3-71</a>.</p>

<h2>South Carolina Informed Consent Law</h2>
<p>South Carolina addresses informed consent through its medical malpractice statute. Under <a href="https://www.scstatehouse.gov/code/t15c079.php" target="_blank" rel="noopener">S.C. Code § 15-79-125</a>, informed consent claims are subject to the same Notice of Intent and expert opinion requirements as other medical malpractice actions. South Carolina courts evaluate whether the doctor provided sufficient information for a reasonable patient to make an informed decision about their treatment.</p>

<h2>Common Informed Consent Failures</h2>
<p>Informed consent failures can occur in many medical contexts:</p>
<ul>
<li>Failure to disclose known risks of a surgical procedure, such as nerve damage, paralysis, or infection</li>
<li>Not informing patients of less invasive alternative treatments</li>
<li>Failing to explain the risks of a medication, including serious side effects and drug interactions</li>
<li>Performing a different or more extensive procedure than what the patient consented to</li>
<li>Not disclosing the surgeon's lack of experience with a particular procedure</li>
<li>Obtaining consent when the patient was under sedation, in pain, or otherwise unable to give meaningful consent</li>
<li>Failing to use a qualified interpreter for non-English-speaking patients</li>
</ul>
<p>Informed consent failures often accompany other forms of malpractice. If your doctor performed a procedure you did not fully consent to and a <a href="/medical-malpractice-lawyers/surgical-error/">surgical error</a> occurred, you may have claims for both informed consent failure and surgical negligence. When informed consent failures involve <a href="/medical-malpractice-lawyers/anesthesia-error/">anesthesia</a>, the anesthesiologist's separate duty to obtain consent for the anesthesia plan may also apply.</p>

<h2>Proving an Informed Consent Claim</h2>
<p>To succeed in an informed consent case, you must prove three elements:</p>
<ul>
<li><strong>Failure to disclose:</strong> The doctor did not adequately inform you of a material risk, complication, or alternative treatment</li>
<li><strong>Causation:</strong> Had you been properly informed, you would not have consented to the procedure</li>
<li><strong>Harm:</strong> You suffered injury from the undisclosed risk</li>
</ul>
<p>The causation element often centers on what a "reasonable patient" would have decided if properly informed. Courts consider whether the undisclosed risk was significant enough that a reasonable person would have reconsidered the treatment.</p>

<h2>Damages in Informed Consent Cases</h2>
<p>Patients who prove informed consent violations may recover compensation for all injuries and complications resulting from the procedure, additional medical treatment required, lost wages during recovery, pain and suffering, emotional distress, and loss of bodily function or autonomy. In cases where an informed consent failure leads to catastrophic injury or death, our <a href="/wrongful-death-lawyers/">wrongful death lawyers</a> are available to assist. Contact Roden Law for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is "informed consent" in medical malpractice?',
                'answer'   => 'Informed consent is a patient\'s legal right to receive adequate information about a proposed treatment — including its risks, benefits, and alternatives — before agreeing to it. A doctor who fails to provide this information and whose patient is harmed by an undisclosed risk may be liable for medical malpractice.',
            ),
            array(
                'question' => 'Does signing a consent form prevent me from filing a claim?',
                'answer'   => 'Not necessarily. A signed consent form does not automatically bar a claim. If the form was vague, the doctor did not adequately explain the risks in person, or the patient signed while under duress or sedation, the consent may not be valid.',
            ),
            array(
                'question' => 'How do I prove I would have refused the procedure if properly informed?',
                'answer'   => 'Courts typically apply a "reasonable patient" standard — would a reasonable person in your position have declined the procedure if informed of the undisclosed risk? Your testimony about your values, concerns, and decision-making process is important evidence.',
            ),
            array(
                'question' => 'Can I file an informed consent claim if I signed a consent form?',
                'answer'   => 'Yes. A consent form is one piece of evidence, but it does not conclusively establish that adequate informed consent was given. The key question is whether the doctor personally explained the material risks and alternatives, not simply whether a form was signed.',
            ),
            array(
                'question' => 'What is the statute of limitations for an informed consent claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years from the date of injury or discovery, with a 5-year statute of repose (O.C.G.A. § 9-3-71). In South Carolina, the deadline is 3 years from the date of injury or discovery (S.C. Code § 15-3-545).',
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
