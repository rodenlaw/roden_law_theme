<?php
/**
 * Seeder: 8 Product Liability Sub-Type Pages
 *
 * Creates 8 child posts under the product-liability-lawyers pillar, each
 * covering a specific type of product liability claim.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-product-liability-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: product-liability-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'product-liability-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'product-liability-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "product-liability-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'product-liability', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Product Liability', 'practice_category', array( 'slug' => 'product-liability' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Defective Auto Parts
       ============================================================ */
    array(
        'title'   => 'Defective Auto Parts Lawyers',
        'slug'    => 'defective-auto-parts',
        'excerpt' => 'Injured by a defective auto part? Faulty brakes, airbags, tires, seatbelts, and other vehicle components cause thousands of serious injuries every year. Our product liability lawyers hold manufacturers accountable.',
        'content' => <<<'HTML'
<h2>Defective Auto Parts Lawyers in Georgia &amp; South Carolina</h2>
<p>When a vehicle component fails — a brake system that does not stop the car, an airbag that does not deploy (or deploys with lethal force), a tire that blows out at highway speed, or a seatbelt that unlatches on impact — the consequences are catastrophic. The <a href="https://www.nhtsa.gov/" target="_blank" rel="noopener">National Highway Traffic Safety Administration (NHTSA)</a> issues hundreds of vehicle recalls every year, affecting millions of vehicles, but many defective parts remain on the road and in use until they cause serious injury or death.</p>
<p>At Roden Law, our defective auto parts lawyers represent accident victims throughout Georgia and South Carolina who were injured because a vehicle component failed to perform as designed. We pursue claims against manufacturers, distributors, and retailers under strict liability and negligence theories to obtain full compensation for our clients.</p>

<h2>Common Defective Auto Parts</h2>
<p>Auto part defects fall into several categories, each with distinct failure modes:</p>
<ul>
<li><strong>Airbag defects:</strong> Non-deployment during a crash, delayed deployment, excessive force deployment (Takata shrapnel recalls), and inadvertent deployment without a crash</li>
<li><strong>Brake system failures:</strong> Brake fade, brake line rupture, anti-lock brake (ABS) malfunction, and electronic braking system software defects</li>
<li><strong>Tire defects:</strong> Tread separation, sidewall blowouts, manufacturing defects causing sudden failure at highway speeds</li>
<li><strong>Seatbelt defects:</strong> Inertial reel failure (seatbelt does not lock during impact), latch failure (buckle releases on impact), and webbing tears</li>
<li><strong>Steering system failures:</strong> Power steering pump failure, electronic power steering software glitches, tie rod failures causing loss of steering control</li>
<li><strong>Roof crush:</strong> Inadequate roof strength in rollover crashes, causing the roof to collapse into the passenger compartment</li>
<li><strong>Fuel system defects:</strong> Fuel tank placement, design, or materials that allow rupture and fire in crashes</li>
<li><strong>Accelerator defects:</strong> Sudden unintended acceleration from electronic throttle control malfunctions or floor mat interference</li>
</ul>

<h2>Georgia and South Carolina Product Liability Law</h2>
<p>Both Georgia and South Carolina provide legal frameworks for holding auto parts manufacturers accountable:</p>
<ul>
<li><strong>Georgia:</strong> Georgia's product liability statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-1/section-51-1-11/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>) allows strict liability claims against manufacturers of products that are defective and unreasonably dangerous. Claims can be based on design defects, manufacturing defects, or failure to warn. Georgia also allows negligence claims against manufacturers.</li>
<li><strong>South Carolina:</strong> South Carolina recognizes strict liability for defective products under common law, following the Restatement (Third) of Torts: Products Liability. Manufacturers, distributors, and retailers in the chain of distribution may be held strictly liable for defective products.</li>
</ul>
<p>Under Georgia's comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>), recovery is available if the injured party was less than 50% at fault. South Carolina's threshold is 51%.</p>

<h2>Crashworthiness and Enhanced Injury Claims</h2>
<p>Even when a <a href="/car-accident-lawyers/">car accident</a> is caused by another driver's negligence, a defective auto part may have made the injuries far worse than they should have been. This is the "crashworthiness" or "enhanced injury" doctrine — the manufacturer is liable for the additional injuries caused by the defective component, beyond what would have occurred in the same crash with a properly functioning part. For example, if a seatbelt fails during a crash, the manufacturer is liable for the enhanced injuries caused by the occupant being unrestrained, even though another driver caused the crash itself.</p>

<h2>NHTSA Recalls and Evidence</h2>
<p>NHTSA recall data, technical service bulletins (TSBs), and complaint databases provide valuable evidence in defective auto parts cases. Our attorneys research the <a href="https://www.nhtsa.gov/recalls" target="_blank" rel="noopener">NHTSA recall database</a> for every case to identify known defects, prior complaints, and recall campaigns involving the same component.</p>

<h2>Filing Deadlines</h2>
<p>Georgia's product liability statute of limitations is <strong>2 years</strong> from the date of injury (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) with a <strong>10-year statute of repose</strong> from the date of first sale (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-1/section-51-1-11/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11(c)</a>). South Carolina allows <strong>3 years</strong> from the date of injury (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>) with a separate statute of repose for certain products. Preserve the defective part as evidence — do not allow the vehicle to be repaired, scrapped, or destroyed before consulting an attorney.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What are the most commonly defective auto parts?',
                'answer'   => 'The most commonly defective auto parts include airbags (non-deployment or defective deployment), brakes (system failures), tires (tread separation and blowouts), seatbelts (buckle release or webbing failures), steering systems (loss of control), and fuel systems (fire risk in crashes).',
            ),
            array(
                'question' => 'Can I sue the auto parts manufacturer even if another driver caused my crash?',
                'answer'   => 'Yes. Under the "crashworthiness" or "enhanced injury" doctrine, a manufacturer is liable for the additional injuries caused by a defective part, beyond what would have occurred in the same crash with a properly functioning component. For example, if your airbag failed to deploy, the manufacturer is liable for the enhanced injuries.',
            ),
            array(
                'question' => 'What is the difference between a design defect and a manufacturing defect?',
                'answer'   => 'A design defect means the product was dangerous as designed — every unit has the same flaw. A manufacturing defect means the design was safe but a particular unit was improperly manufactured — deviating from the intended design. Both are actionable under Georgia and South Carolina product liability law.',
            ),
            array(
                'question' => 'How do NHTSA recalls help my defective auto parts case?',
                'answer'   => 'NHTSA recalls, technical service bulletins, and complaint data can establish that the manufacturer knew about the defect. This evidence strengthens your claim by showing the defect was a known problem, not an isolated incident.',
            ),
            array(
                'question' => 'How long do I have to file a defective auto parts claim?',
                'answer'   => 'Georgia allows 2 years from the date of injury (O.C.G.A. § 9-3-33) with a 10-year statute of repose. South Carolina allows 3 years (S.C. Code § 15-3-530). Critically, preserve the defective part — do not allow the vehicle to be repaired or scrapped before consulting an attorney.',
            ),
        ),
    ),

    /* ============================================================
       2. Defective Medical Device
       ============================================================ */
    array(
        'title'   => 'Defective Medical Device Lawyers',
        'slug'    => 'defective-medical-device',
        'excerpt' => 'Harmed by a defective medical device? Failed implants, surgical instruments, and diagnostic equipment cause serious injuries. Our product liability lawyers hold device manufacturers accountable.',
        'content' => <<<'HTML'
<h2>Defective Medical Device Lawyers in Georgia &amp; South Carolina</h2>
<p>Medical devices — from hip and knee implants to surgical mesh, pacemakers, insulin pumps, and diagnostic equipment — are supposed to improve health outcomes. When these devices are defectively designed, manufactured, or marketed, they can cause catastrophic harm: implant failures requiring revision surgery, internal bleeding, organ damage, infection, chronic pain, and even death. The <a href="https://www.fda.gov/medical-devices" target="_blank" rel="noopener">FDA</a> receives hundreds of thousands of medical device adverse event reports annually, and major device recalls affect millions of patients.</p>
<p>At Roden Law, our defective medical device lawyers represent patients throughout Georgia and South Carolina who have been harmed by devices that failed to perform safely. We pursue claims against device manufacturers under strict liability, negligence, and breach of warranty theories. When defective devices cause injury through <a href="/medical-malpractice-lawyers/">improper surgical implantation or use</a>, we pursue claims against both the manufacturer and the healthcare provider.</p>

<h2>Common Defective Medical Devices</h2>
<p>Medical device failures span a wide range of products:</p>
<ul>
<li><strong>Joint replacement implants:</strong> Hip and knee implants that fail prematurely, release metal ions into the bloodstream (metallosis), or cause bone deterioration — DePuy ASR hip implant and similar metal-on-metal devices have been the subject of massive litigation</li>
<li><strong>Surgical mesh:</strong> Hernia mesh and transvaginal mesh products that erode, contract, or cause chronic pain, infection, and organ perforation</li>
<li><strong>Cardiac devices:</strong> Pacemakers, defibrillators (ICDs), and heart valves that malfunction — including devices with defective leads that fracture or fail to deliver therapy</li>
<li><strong>Spinal implants:</strong> Spinal fusion hardware, artificial discs, and bone growth stimulators that fail or cause nerve damage</li>
<li><strong>Insulin pumps and infusion devices:</strong> Devices that deliver incorrect dosages, malfunction, or fail to alert to dangerous conditions</li>
<li><strong>Surgical instruments:</strong> Power morcellators, robotic surgery systems, and other surgical tools that malfunction during procedures</li>
<li><strong>Intrauterine devices (IUDs):</strong> Devices that migrate, perforate the uterus, or break during removal</li>
</ul>

<h2>Three Types of Medical Device Defects</h2>
<p>Medical device claims typically involve one or more of three defect categories:</p>
<ul>
<li><strong>Design defect:</strong> The device's design is inherently unsafe — every unit produced has the same dangerous characteristic. For example, a metal-on-metal hip implant design that inevitably generates toxic metal debris</li>
<li><strong>Manufacturing defect:</strong> The design is sound, but a particular unit was improperly manufactured — contaminated during production, assembled incorrectly, or made with substandard materials</li>
<li><strong>Marketing defect (failure to warn):</strong> The manufacturer failed to adequately warn physicians and patients about known risks, side effects, or contraindications</li>
</ul>

<h2>Georgia and South Carolina Product Liability Law for Medical Devices</h2>
<p>Georgia's product liability statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-1/section-51-1-11/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>) provides strict liability for defective products that are unreasonably dangerous. The "learned intermediary" doctrine, recognized in both Georgia and South Carolina, provides that a medical device manufacturer may satisfy its duty to warn by providing adequate warnings to the prescribing physician rather than directly to the patient — making it critical to prove that warnings to physicians were inadequate.</p>
<p>South Carolina recognizes strict liability for defective products under common law, following the Restatement (Third) of Torts. Georgia's comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>) applies, with a 50% bar in Georgia and 51% in South Carolina.</p>

<h2>FDA Preemption Challenges</h2>
<p>Device manufacturers frequently argue that FDA approval "preempts" (blocks) state law product liability claims. The legal landscape is complex:</p>
<ul>
<li><strong>PMA devices:</strong> Devices that received FDA Premarket Approval (PMA) have greater preemption protection under the Supreme Court's <em>Riegel v. Medtronic</em> (2008) decision, though claims based on manufacturing defects and violations of FDA requirements may survive</li>
<li><strong>510(k) devices:</strong> Devices cleared through the 510(k) "substantially equivalent" pathway receive less preemption protection under <em>Medtronic v. Lohr</em> (1996) — most state law claims can proceed</li>
</ul>
<p>Our attorneys analyze the specific FDA pathway for each device to craft claims that survive preemption challenges.</p>

<h2>Filing Deadlines</h2>
<p>Georgia's statute of limitations is <strong>2 years</strong> from the date of injury (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) with a <strong>10-year statute of repose</strong>. South Carolina allows <strong>3 years</strong> (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). For medical devices, the injury may not be discovered until years after implantation — the "discovery rule" may toll the statute of limitations until the patient knew or should have known of the defect.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What qualifies as a defective medical device?',
                'answer'   => 'A medical device is defective if it has a design defect (inherently unsafe design), a manufacturing defect (improperly produced), or a marketing defect (inadequate warnings to doctors and patients). Common examples include failed joint implants, hernia mesh, cardiac device malfunctions, and defective surgical instruments.',
            ),
            array(
                'question' => 'Can I sue a medical device manufacturer even if the FDA approved the device?',
                'answer'   => 'In many cases, yes. The answer depends on the FDA pathway. Devices cleared through the 510(k) process have limited preemption protection, and most state law claims can proceed. Even PMA-approved devices may be subject to claims based on manufacturing defects or violations of FDA requirements.',
            ),
            array(
                'question' => 'What is the "learned intermediary" doctrine?',
                'answer'   => 'The learned intermediary doctrine provides that a medical device manufacturer satisfies its duty to warn by giving adequate warnings to the prescribing physician — not directly to the patient. This means proving inadequate warnings to physicians is critical in failure-to-warn claims.',
            ),
            array(
                'question' => 'How do I know if my medical device was recalled?',
                'answer'   => 'Check the FDA\'s medical device recall database at fda.gov/medical-devices/medical-device-recalls. Your doctor should also notify you of recalls affecting devices implanted in you. If your device was recalled, contact an attorney to discuss your legal options.',
            ),
            array(
                'question' => 'How long do I have to file a defective medical device claim?',
                'answer'   => 'Georgia allows 2 years from discovery of the injury (O.C.G.A. § 9-3-33) with a 10-year statute of repose. South Carolina allows 3 years (S.C. Code § 15-3-530). The "discovery rule" may extend the deadline if the defect was not immediately apparent — but do not delay consulting an attorney.',
            ),
        ),
    ),

    /* ============================================================
       3. Dangerous Pharmaceutical Drug
       ============================================================ */
    array(
        'title'   => 'Dangerous Pharmaceutical Drug Lawyers',
        'slug'    => 'dangerous-pharmaceutical-drug',
        'excerpt' => 'Harmed by a dangerous prescription or over-the-counter drug? Pharmaceutical companies must disclose all known risks. Our lawyers hold drug manufacturers accountable for dangerous side effects.',
        'content' => <<<'HTML'
<h2>Dangerous Pharmaceutical Drug Lawyers in Georgia &amp; South Carolina</h2>
<p>Pharmaceutical companies have a duty to ensure their drugs are safe and to disclose all known risks to physicians and patients. When drug manufacturers conceal dangerous side effects, manipulate clinical trial data, or fail to adequately warn about known risks, patients suffer serious harm — including organ damage, stroke, heart attack, cancer, birth defects, addiction, and death. The <a href="https://www.fda.gov/drugs" target="_blank" rel="noopener">FDA</a> issues safety communications and drug recalls regularly, but many dangerous drugs remain on the market for years before the full scope of their risks is known.</p>
<p>At Roden Law, our dangerous drug lawyers represent patients throughout Georgia and South Carolina who have been harmed by prescription medications and over-the-counter drugs. We pursue claims against pharmaceutical manufacturers under strict liability, negligence, and fraud theories, and participate in multidistrict litigation (MDL) when cases are consolidated at the federal level.</p>

<h2>Types of Pharmaceutical Drug Claims</h2>
<p>Dangerous drug claims typically fall into several categories:</p>
<ul>
<li><strong>Failure to warn:</strong> The manufacturer knew or should have known about serious side effects but failed to adequately warn physicians and patients through labeling, package inserts, or direct-to-consumer advertising</li>
<li><strong>Defective design:</strong> The drug's chemical formulation is inherently dangerous — the risks outweigh the benefits for the indicated use</li>
<li><strong>Manufacturing contamination:</strong> The drug was contaminated during production — impurities, incorrect dosages, or cross-contamination with other substances</li>
<li><strong>Off-label promotion:</strong> The manufacturer illegally promoted the drug for uses not approved by the FDA, exposing patients to unapproved and unstudied risks</li>
<li><strong>Clinical trial fraud:</strong> The manufacturer manipulated or concealed adverse clinical trial results to obtain FDA approval</li>
</ul>

<h2>Georgia and South Carolina Pharmaceutical Liability</h2>
<p>Georgia's product liability statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-1/section-51-1-11/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>) applies to pharmaceutical products, allowing strict liability claims when a drug is defective and unreasonably dangerous. The learned intermediary doctrine applies in both Georgia and South Carolina — pharmaceutical manufacturers must provide adequate warnings to prescribing physicians, who then make treatment decisions for their patients.</p>
<p>Georgia's comparative fault statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>) allows recovery if less than 50% at fault. South Carolina's threshold is 51%. Punitive damages may be available when the manufacturer acted with willful misconduct or reckless disregard for patient safety.</p>

<h2>Common Dangerous Drugs and Drug Categories</h2>
<p>Major pharmaceutical litigation has targeted numerous drug categories:</p>
<ul>
<li><strong>Opioid pain medications:</strong> Manufacturers who minimized addiction risks and aggressively marketed opioids, contributing to the national addiction crisis</li>
<li><strong>Blood thinners:</strong> Anticoagulants associated with uncontrollable bleeding events and the lack of reversal agents</li>
<li><strong>Heartburn and acid reflux drugs:</strong> Proton pump inhibitors linked to kidney damage, bone fractures, and other serious conditions</li>
<li><strong>Diabetes medications:</strong> Drugs linked to ketoacidosis, kidney injury, amputations, and other serious side effects</li>
<li><strong>Antidepressants:</strong> SSRIs and other psychiatric medications linked to increased suicide risk, birth defects, and withdrawal syndrome</li>
<li><strong>Testosterone and hormone therapies:</strong> Products linked to cardiovascular events including heart attack and stroke</li>
<li><strong>Cancer treatments:</strong> Chemotherapy drugs and biological therapies with undisclosed or underreported severe side effects</li>
</ul>

<h2>Multidistrict Litigation (MDL)</h2>
<p>When a dangerous drug injures thousands of patients nationwide, individual lawsuits are often consolidated into a multidistrict litigation (MDL) in a single federal court for coordinated pretrial proceedings. MDL allows efficient handling of common issues — such as the manufacturer's knowledge of the drug's risks and the adequacy of warnings — while preserving each plaintiff's individual damage claims. Our attorneys represent Georgia and South Carolina plaintiffs in MDLs and individual actions.</p>

<h2>Filing Deadlines</h2>
<p>Georgia's statute of limitations is <strong>2 years</strong> from discovery of the injury (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) with a <strong>10-year statute of repose</strong> (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-1/section-51-1-11/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11(c)</a>). South Carolina allows <strong>3 years</strong> (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). The discovery rule applies — the limitations period begins when you knew or should have known the drug caused your injury, not necessarily the date you first took the medication.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue a drug company for a dangerous side effect?',
                'answer'   => 'Yes, if the manufacturer failed to adequately warn about the side effect, knew about the risk and concealed it, or the drug was defectively designed or manufactured. The key issue is whether the manufacturer provided adequate warnings to prescribing physicians about the specific risk that harmed you.',
            ),
            array(
                'question' => 'What if my doctor prescribed the drug — isn\'t the doctor liable?',
                'answer'   => 'The doctor may share liability if they prescribed the drug improperly, but the manufacturer is liable if they failed to provide the doctor with adequate warnings about the drug\'s risks. Under the learned intermediary doctrine, the manufacturer\'s duty is to warn the physician, who then decides whether to prescribe.',
            ),
            array(
                'question' => 'What is a multidistrict litigation (MDL)?',
                'answer'   => 'An MDL consolidates individual lawsuits against the same drug manufacturer into a single federal court for coordinated pretrial proceedings. This allows efficient handling of common issues while preserving each plaintiff\'s individual claims. If your case involves a widely-used dangerous drug, it may be part of an MDL.',
            ),
            array(
                'question' => 'Does FDA approval protect the drug company from lawsuits?',
                'answer'   => 'Generally, no. FDA approval does not preempt state law product liability claims for most prescription drugs. The Supreme Court\'s decision in Wyeth v. Levine (2009) held that FDA labeling requirements are a minimum standard, and manufacturers can be held liable under state law for failing to provide stronger warnings.',
            ),
            array(
                'question' => 'How long do I have to file a dangerous drug claim?',
                'answer'   => 'Georgia allows 2 years from discovery of the injury (O.C.G.A. § 9-3-33), with a 10-year statute of repose. South Carolina allows 3 years (S.C. Code § 15-3-530). The discovery rule may extend the deadline because drug side effects often develop years after the patient begins taking the medication.',
            ),
        ),
    ),

    /* ============================================================
       4. Defective Consumer Product
       ============================================================ */
    array(
        'title'   => 'Defective Consumer Product Lawyers',
        'slug'    => 'defective-consumer-product',
        'excerpt' => 'Injured by a defective consumer product? From electronics to sporting goods, manufacturers must ensure product safety. Our product liability lawyers hold companies accountable for dangerous products.',
        'content' => <<<'HTML'
<h2>Defective Consumer Product Lawyers in Georgia &amp; South Carolina</h2>
<p>Every day, consumers in Georgia and South Carolina rely on thousands of products to be safe — from household goods and electronics to recreational equipment and personal care products. When manufacturers cut corners on design, materials, quality control, or safety testing, the result is defective products that cause serious injuries. The <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">Consumer Product Safety Commission (CPSC)</a> reports that consumer product-related injuries result in approximately 29 million emergency department visits annually in the United States.</p>
<p>At Roden Law, our defective consumer product lawyers represent injured consumers throughout Georgia and South Carolina. We pursue strict liability and negligence claims against manufacturers, distributors, and retailers who place dangerous products into the stream of commerce.</p>

<h2>Common Defective Consumer Products</h2>
<p>Consumer product defects span virtually every product category:</p>
<ul>
<li><strong>Electronics and batteries:</strong> Lithium-ion battery explosions in phones, laptops, e-cigarettes, and hoverboards causing <a href="/burn-injury-lawyers/">burn injuries</a></li>
<li><strong>Power tools:</strong> Table saws, chainsaws, nail guns, and other tools that lack adequate safety guards or defect-free operation</li>
<li><strong>Recreational equipment:</strong> Defective bicycles, helmets, exercise equipment, trampolines, and all-terrain vehicles (ATVs)</li>
<li><strong>Furniture:</strong> Tip-over hazards from unstable dressers and bookshelves, particularly dangerous for children</li>
<li><strong>Personal care products:</strong> Cosmetics, hair products, and skincare items containing undisclosed harmful chemicals</li>
<li><strong>Outdoor and camping equipment:</strong> Defective propane heaters, camping stoves, and climbing gear</li>
<li><strong>Pressure cookers:</strong> Exploding pressure cookers with defective locking mechanisms</li>
</ul>

<h2>Three Theories of Product Liability</h2>
<p>Georgia and South Carolina law provide three legal theories for pursuing defective consumer product claims:</p>
<ul>
<li><strong>Strict liability:</strong> Under Georgia's product liability statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-1/section-51-1-11/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>) and South Carolina common law, a manufacturer is strictly liable for injuries caused by a product that is defective and unreasonably dangerous — regardless of whether the manufacturer was negligent</li>
<li><strong>Negligence:</strong> The manufacturer failed to exercise reasonable care in designing, manufacturing, testing, or labeling the product</li>
<li><strong>Breach of warranty:</strong> The product failed to meet express or implied warranties of safety and fitness for its intended use, governed by the Uniform Commercial Code adopted in both Georgia (<a href="https://law.justia.com/codes/georgia/title-11/" target="_blank" rel="noopener">O.C.G.A. Title 11</a>) and South Carolina</li>
</ul>

<h2>Who Can Be Held Liable?</h2>
<p>Georgia and South Carolina law allow claims against every entity in the product's chain of distribution:</p>
<ul>
<li><strong>Manufacturer:</strong> The company that designed and/or produced the defective product</li>
<li><strong>Component manufacturer:</strong> A supplier of a defective component incorporated into the finished product</li>
<li><strong>Distributor:</strong> The wholesale distributor who placed the product into the supply chain</li>
<li><strong>Retailer:</strong> The store or online seller that sold the product to the consumer</li>
<li><strong>Importer:</strong> For foreign-manufactured products, the U.S. importer may be treated as the manufacturer for liability purposes</li>
</ul>

<h2>CPSC Recalls and Evidence</h2>
<p>The <a href="https://www.cpsc.gov/Recalls" target="_blank" rel="noopener">CPSC recall database</a> is a valuable resource for identifying known product defects. When a product has been recalled, the recall itself is evidence that the manufacturer recognized the product was dangerous. Even products that have not been recalled may be defective — the CPSC cannot test every product, and many defects are only discovered after injuries occur.</p>

<h2>Comparative Fault and Product Misuse</h2>
<p>Manufacturers frequently raise product misuse as a defense, arguing the consumer used the product in an unforeseeable manner. However, Georgia and South Carolina law require manufacturers to anticipate reasonably foreseeable misuse and design products to be safe even when used in ways that are not exactly as intended. Under Georgia's comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>), recovery is available if less than 50% at fault. South Carolina's threshold is 51%.</p>

<h2>Filing Deadlines</h2>
<p>Georgia allows <strong>2 years</strong> from the date of injury (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) with a <strong>10-year statute of repose</strong>. South Carolina allows <strong>3 years</strong> (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). Preserve the defective product, its packaging, and all documentation — this evidence is critical to your claim.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What makes a consumer product "defective" under the law?',
                'answer'   => 'A product is legally defective if it has a design defect (the design itself is unreasonably dangerous), a manufacturing defect (the specific unit deviates from the intended design), or a marketing defect (inadequate warnings or instructions). Any of these can give rise to a product liability claim.',
            ),
            array(
                'question' => 'Can I sue the store that sold me a defective product?',
                'answer'   => 'Yes. Georgia and South Carolina allow claims against every entity in the chain of distribution — manufacturer, distributor, and retailer. This is particularly important when the manufacturer is a foreign company that may be difficult to sue directly.',
            ),
            array(
                'question' => 'What if I was using the product in an unintended way?',
                'answer'   => 'Manufacturers must anticipate reasonably foreseeable misuse and design products to be safe even when not used exactly as intended. If your use was reasonably foreseeable — even if not the manufacturer\'s intended use — you may still recover. Comparative fault rules may reduce but not eliminate your recovery.',
            ),
            array(
                'question' => 'How does a CPSC recall affect my case?',
                'answer'   => 'A recall is evidence that the manufacturer recognized the product was dangerous. However, you do not need a recall to have a valid claim — many defective products are never recalled. And a recall does not automatically establish liability; you still must prove the defect caused your injury.',
            ),
            array(
                'question' => 'How long do I have to file a defective consumer product claim?',
                'answer'   => 'Georgia allows 2 years from injury (O.C.G.A. § 9-3-33) with a 10-year statute of repose from first sale. South Carolina allows 3 years (S.C. Code § 15-3-530). Preserve the product, packaging, and all documentation as evidence.',
            ),
        ),
    ),

    /* ============================================================
       5. Defective Industrial Equipment
       ============================================================ */
    array(
        'title'   => 'Defective Industrial Equipment Lawyers',
        'slug'    => 'defective-industrial-equipment',
        'excerpt' => 'Injured by defective industrial equipment or machinery at work? Manufacturers must ensure equipment safety. Our product liability lawyers pursue claims beyond workers\' comp to maximize your recovery.',
        'content' => <<<'HTML'
<h2>Defective Industrial Equipment Lawyers in Georgia &amp; South Carolina</h2>
<p>Industrial workplaces in Georgia and South Carolina — including manufacturing plants, construction sites, warehouses, ports, and processing facilities — rely on heavy machinery and equipment that can cause devastating injuries when defective. Forklifts, presses, conveyors, cranes, saws, grinding machines, and other industrial equipment can amputate limbs, crush bones, cause <a href="/burn-injury-lawyers/">severe burns</a>, and kill workers when safety mechanisms fail or designs are inherently dangerous. The <a href="https://www.osha.gov/" target="_blank" rel="noopener">Occupational Safety and Health Administration (OSHA)</a> reports that contact with objects and equipment is one of the top four causes of workplace fatalities.</p>
<p>At Roden Law, our defective industrial equipment lawyers represent injured workers throughout Georgia and South Carolina. While <a href="/workers-compensation-lawyers/">workers' compensation</a> typically prevents you from suing your employer, product liability claims against the equipment manufacturer are a separate legal avenue that allows you to recover full compensatory damages — including pain and suffering — that workers' comp does not provide.</p>

<h2>Common Defective Industrial Equipment</h2>
<p>Industrial equipment defects occur across all types of machinery:</p>
<ul>
<li><strong>Presses and stamping machines:</strong> Missing or inadequate point-of-operation guards that allow hands and arms to enter the danger zone</li>
<li><strong>Conveyor systems:</strong> Exposed nip points, inadequate emergency stops, and unguarded moving parts that catch clothing, limbs, and hair</li>
<li><strong>Forklifts:</strong> Stability defects, defective mast and hydraulic systems, inadequate operator protection, and seatbelt failures</li>
<li><strong>Cranes and hoists:</strong> Boom failures, cable defects, overload protection failures, and anti-two-block device malfunctions</li>
<li><strong>Power saws and cutting equipment:</strong> Missing blade guards, kickback prevention failures, and defective safety interlock systems</li>
<li><strong>Grinding and polishing machines:</strong> Wheel guard failures, defective tool rests, and exploding abrasive wheels</li>
<li><strong>Compactors and balers:</strong> Inadequate guarding that allows workers to be drawn into the machine</li>
<li><strong>Injection molding machines:</strong> Guard interlock failures that allow access to the mold area during operation</li>
</ul>

<h2>Product Liability vs. Workers' Compensation</h2>
<p>When defective equipment injures a worker, two separate legal systems may apply:</p>
<ul>
<li><strong><a href="/workers-compensation-lawyers/">Workers' compensation</a>:</strong> Provides medical benefits and wage replacement regardless of fault, but bars lawsuits against the employer and does not include pain and suffering</li>
<li><strong>Product liability:</strong> A separate claim against the equipment manufacturer, which allows full compensatory damages including pain and suffering, disfigurement, loss of enjoyment of life, and punitive damages in egregious cases</li>
</ul>
<p>These claims are not mutually exclusive — you can receive workers' comp benefits while simultaneously pursuing a product liability lawsuit against the manufacturer. However, a workers' comp lien may attach to the product liability recovery.</p>

<h2>Georgia and South Carolina Industrial Equipment Liability</h2>
<p>Georgia's product liability statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-1/section-51-1-11/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>) imposes strict liability on manufacturers of defective products. Key considerations in industrial equipment cases include:</p>
<ul>
<li><strong>Machine guarding standards:</strong> OSHA regulations (29 CFR 1910 Subpart O) and ANSI safety standards establish minimum guarding requirements that manufacturers must meet or exceed</li>
<li><strong>State of the art defense:</strong> Georgia allows manufacturers to argue that a safer design was not feasible given the state of technology at the time of manufacture</li>
<li><strong>Employer modification:</strong> Manufacturers may argue that the employer modified the equipment or removed safety guards — but the manufacturer may still be liable if the modification was foreseeable</li>
</ul>
<p>Georgia's comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>) allows recovery if less than 50% at fault. South Carolina's threshold is 51%.</p>

<h2>Evidence Preservation in Equipment Cases</h2>
<p>The defective equipment itself is the most critical piece of evidence. Our attorneys send immediate preservation letters to the employer and manufacturer demanding that the equipment not be repaired, modified, or destroyed. We also pursue OSHA investigation reports, manufacturer maintenance records, prior complaint histories, and the machine's design and safety analysis documentation.</p>

<h2>Filing Deadlines</h2>
<p>Georgia allows <strong>2 years</strong> from the date of injury (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) with a <strong>10-year statute of repose</strong>. South Carolina allows <strong>3 years</strong> (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). Contact an attorney immediately to preserve the equipment and investigate the defect before the employer repairs or replaces the machine.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue the manufacturer of defective work equipment even though I receive workers\' comp?',
                'answer'   => 'Yes. Workers\' compensation and product liability are separate legal systems. You can receive workers\' comp benefits from your employer while simultaneously suing the equipment manufacturer for full damages — including pain and suffering, which workers\' comp does not provide.',
            ),
            array(
                'question' => 'What if my employer removed the safety guard from the machine?',
                'answer'   => 'Even if your employer removed or modified a safety device, the manufacturer may still be liable if the modification was reasonably foreseeable. Manufacturers have a duty to design equipment that resists foreseeable modifications and to warn against removing safety features.',
            ),
            array(
                'question' => 'What role do OSHA standards play in equipment defect cases?',
                'answer'   => 'OSHA regulations (particularly 29 CFR 1910 Subpart O for machine guarding) establish minimum safety standards. While OSHA regulates employers rather than manufacturers, failure to meet OSHA guarding standards is strong evidence that a machine was defectively designed.',
            ),
            array(
                'question' => 'What types of industrial equipment defects are most common?',
                'answer'   => 'The most common defects involve inadequate machine guarding (missing or insufficient point-of-operation guards), defective safety interlocks (allowing machine operation when guards are open), inadequate emergency stop systems, and stability defects in mobile equipment like forklifts.',
            ),
            array(
                'question' => 'How long do I have to file a defective equipment claim?',
                'answer'   => 'Georgia allows 2 years from injury (O.C.G.A. § 9-3-33) with a 10-year statute of repose. South Carolina allows 3 years (S.C. Code § 15-3-530). Critically, preserve the equipment — send an immediate preservation letter to prevent repair or destruction of evidence.',
            ),
        ),
    ),

    /* ============================================================
       6. Defective Children's Product
       ============================================================ */
    array(
        'title'   => 'Defective Children\'s Product Lawyers',
        'slug'    => 'defective-childrens-product',
        'excerpt' => 'Child injured by a defective toy, crib, car seat, or other product? Children\'s products must meet strict federal safety standards. Our lawyers hold manufacturers accountable when children are harmed.',
        'content' => <<<'HTML'
<h2>Defective Children's Product Lawyers in Georgia &amp; South Carolina</h2>
<p>Children are the most vulnerable consumers — they cannot evaluate product safety, they use products in unpredictable ways, and their smaller bodies are more susceptible to injury. When manufacturers of toys, cribs, car seats, strollers, high chairs, and other children's products fail to meet safety standards, the consequences can be devastating. The <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">Consumer Product Safety Commission (CPSC)</a> estimates that toy-related injuries alone send approximately 200,000 children to emergency rooms annually.</p>
<p>At Roden Law, our defective children's product lawyers represent families throughout Georgia and South Carolina whose children have been injured by dangerous products. We hold manufacturers, importers, and retailers accountable under strict federal safety standards and state product liability law.</p>

<h2>Common Defective Children's Products</h2>
<p>Children's product recalls and injury reports reveal persistent safety failures:</p>
<ul>
<li><strong>Cribs and sleep products:</strong> Drop-side cribs (now banned), inclined sleepers (Fisher-Price Rock 'n Play recall), soft bedding, and crib bumpers that pose suffocation and strangulation risks</li>
<li><strong>Car seats:</strong> Harness defects, latch failures, inadequate side-impact protection, and flammable materials</li>
<li><strong>Toys:</strong> Choking hazards (small parts), toxic paint and materials (lead, phthalates), sharp edges, projectile toys, and strangulation hazards from cords</li>
<li><strong>Strollers:</strong> Collapse mechanisms that amputate fingers, hinge pinch points, inadequate braking on inclines, and tip-over hazards</li>
<li><strong>High chairs:</strong> Harness failures allowing children to fall, structural collapse, and entrapment between the seat and tray</li>
<li><strong>Button batteries:</strong> Small lithium button batteries that can be swallowed, causing severe internal <a href="/burn-injury-lawyers/">chemical burns</a> and death within hours</li>
<li><strong>Playground equipment:</strong> Defective swings, slides, and climbing structures installed in parks, schools, and homes</li>
<li><strong>Children's clothing:</strong> Drawstrings that cause strangulation and flammable fabrics</li>
</ul>

<h2>Federal Safety Standards for Children's Products</h2>
<p>The Consumer Product Safety Improvement Act (CPSIA) of 2008 imposed strict federal requirements on children's products:</p>
<ul>
<li><strong>Mandatory third-party testing:</strong> Children's products must be tested by CPSC-accepted laboratories before sale</li>
<li><strong>Lead limits:</strong> Strict limits on lead content in children's products (100 ppm for substrate, 90 ppm for surface coatings)</li>
<li><strong>Phthalate restrictions:</strong> Bans on certain phthalates in toys and childcare articles</li>
<li><strong>Mandatory toy standards:</strong> ASTM F963 establishes safety requirements for toys including mechanical hazards, flammability, and chemical safety</li>
<li><strong>Crib standards:</strong> Federal mandatory crib standards (16 CFR 1219/1220) prohibiting drop-side cribs and setting strict structural requirements</li>
<li><strong>Product registration:</strong> Manufacturers must provide product registration cards to facilitate recall notification</li>
</ul>
<p>Violations of these federal standards are powerful evidence of a defective product under Georgia (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-1/section-51-1-11/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>) and South Carolina product liability law.</p>

<h2>Legal Claims for Children's Product Injuries</h2>
<p>Claims for injuries from defective children's products may be brought under:</p>
<ul>
<li><strong>Strict liability:</strong> The product was defective and unreasonably dangerous, regardless of the manufacturer's level of care</li>
<li><strong>Negligence:</strong> The manufacturer failed to exercise reasonable care in designing, testing, or marketing the product</li>
<li><strong>Breach of warranty:</strong> The product failed to meet express or implied warranties of safety</li>
<li><strong>Negligent supervision claims:</strong> In some cases, claims against retailers, daycare providers, or schools that provided or allowed use of a known dangerous product</li>
</ul>
<p>Georgia's comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>) applies, though a child's own comparative fault is evaluated under a different standard — young children are generally presumed incapable of contributory negligence.</p>

<h2>Wrongful Death of a Child</h2>
<p>When a defective children's product causes a child's death, Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-4/" target="_blank" rel="noopener">O.C.G.A. § 51-4-1 et seq.</a>) allows parents to bring a wrongful death claim for the full value of the child's life. South Carolina's wrongful death statute (<a href="https://www.scstatehouse.gov/code/t15c051.php" target="_blank" rel="noopener">S.C. Code § 15-51-10 et seq.</a>) similarly allows recovery by the estate for the benefit of surviving family members.</p>

<h2>Filing Deadlines</h2>
<p>Georgia allows <strong>2 years</strong> from the date of injury (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>). South Carolina allows <strong>3 years</strong> (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). For minor children, tolling rules may extend the filing deadline — but parents should not wait to take action. Preserve the product and all packaging as evidence.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What are the most dangerous children\'s products?',
                'answer'   => 'The most commonly recalled and dangerous children\'s products include sleep products (inclined sleepers, cribs), toys with small parts (choking hazards), button batteries (chemical burn risk if swallowed), car seats with defective harnesses, strollers with collapse/amputation hazards, and products containing lead or toxic chemicals.',
            ),
            array(
                'question' => 'Are children\'s product manufacturers held to higher safety standards?',
                'answer'   => 'Yes. The Consumer Product Safety Improvement Act (CPSIA) imposes mandatory third-party testing, strict lead and phthalate limits, and specific safety standards (like ASTM F963 for toys) on children\'s products. Violations of these standards are strong evidence of product defect.',
            ),
            array(
                'question' => 'Can a child\'s comparative fault reduce the recovery?',
                'answer'   => 'Young children are generally presumed incapable of contributory negligence under Georgia and South Carolina law. Manufacturers cannot blame a young child for using a product in a way that caused injury — children\'s products must be designed to be safe even when used by children.',
            ),
            array(
                'question' => 'Who can I sue if my child is injured by a defective product?',
                'answer'   => 'You can sue the manufacturer, the designer, the importer (for foreign products), the distributor, and the retailer. Every entity in the chain of distribution may be held strictly liable for placing a defective product into the market.',
            ),
            array(
                'question' => 'How long do I have to file a claim for a child injured by a defective product?',
                'answer'   => 'Georgia allows 2 years from injury (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Tolling rules may extend deadlines for minor children, but parents should act promptly and preserve the product and packaging as evidence.',
            ),
        ),
    ),

    /* ============================================================
       7. Food Contamination
       ============================================================ */
    array(
        'title'   => 'Food Contamination Lawyers',
        'slug'    => 'food-contamination',
        'excerpt' => 'Sickened by contaminated food? E. coli, salmonella, listeria, and other foodborne illnesses can cause serious injury and death. Our product liability lawyers hold food manufacturers and retailers accountable.',
        'content' => <<<'HTML'
<h2>Food Contamination Lawyers in Georgia &amp; South Carolina</h2>
<p>Food contamination is a serious and widespread public health problem. The <a href="https://www.cdc.gov/foodborneburden/" target="_blank" rel="noopener">Centers for Disease Control and Prevention (CDC)</a> estimates that 48 million Americans are sickened by contaminated food each year, resulting in 128,000 hospitalizations and 3,000 deaths. While many cases of food poisoning are mild, contamination with dangerous pathogens like E. coli O157:H7, Salmonella, Listeria monocytogenes, Hepatitis A, and Clostridium botulinum can cause kidney failure, meningitis, sepsis, permanent organ damage, and death — particularly in children, the elderly, pregnant women, and immunocompromised individuals.</p>
<p>At Roden Law, our food contamination lawyers represent victims throughout Georgia and South Carolina who have suffered serious illness from contaminated food products. We pursue strict liability and negligence claims against food manufacturers, processors, distributors, restaurants, and retailers.</p>

<h2>Common Foodborne Pathogens</h2>
<p>Serious food contamination cases typically involve these dangerous organisms:</p>
<ul>
<li><strong>E. coli O157:H7:</strong> Produces Shiga toxin that can cause hemolytic uremic syndrome (HUS) — kidney failure, seizures, and death. Common sources include undercooked ground beef, leafy greens, and unpasteurized products</li>
<li><strong>Salmonella:</strong> Causes salmonellosis with severe diarrhea, fever, and abdominal cramps. In severe cases, the infection spreads to the bloodstream. Common sources include poultry, eggs, produce, and pet food</li>
<li><strong>Listeria monocytogenes:</strong> Causes listeriosis — particularly dangerous for pregnant women (can cause miscarriage and stillbirth), newborns, elderly, and immunocompromised. Common sources include deli meats, soft cheeses, and ready-to-eat foods</li>
<li><strong>Campylobacter:</strong> The most common bacterial cause of diarrheal illness, occasionally leading to Guillain-Barr&eacute; syndrome (a form of paralysis). Common in undercooked poultry</li>
<li><strong>Hepatitis A:</strong> A viral liver infection transmitted through contaminated food or water, often traced to infected food handlers</li>
<li><strong>Norovirus:</strong> Highly contagious virus causing vomiting and diarrhea, commonly spread through contaminated food, particularly in restaurants and institutional settings</li>
</ul>

<h2>Legal Theories in Food Contamination Cases</h2>
<p>Food contamination claims in Georgia and South Carolina can be pursued under multiple theories:</p>
<ul>
<li><strong>Strict liability:</strong> Under Georgia's product liability statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-1/section-51-1-11/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>) and South Carolina common law, food is treated as a product, and manufacturers and sellers are strictly liable for contaminated food that is unreasonably dangerous</li>
<li><strong>Negligence:</strong> The food producer, processor, or handler failed to exercise reasonable care in preparation, storage, or handling — including violations of FDA Food Safety Modernization Act (FSMA) requirements</li>
<li><strong>Breach of implied warranty:</strong> All food sold is impliedly warranted to be fit for consumption under the UCC</li>
<li><strong>Restaurant liability:</strong> Restaurants that serve contaminated food may be liable under both product liability and negligence theories</li>
</ul>

<h2>Tracing Contamination to the Source</h2>
<p>Proving which food product caused an illness is a critical challenge. Our attorneys work with epidemiologists and public health investigators to establish causation:</p>
<ul>
<li><strong>Stool culture testing:</strong> Laboratory identification of the specific pathogen causing the illness</li>
<li><strong>PulseNet database:</strong> The CDC's national laboratory network that matches illness patterns to specific contamination outbreaks</li>
<li><strong>Traceback investigation:</strong> Following the food supply chain from the victim's meal back to the source farm, processing plant, or distributor</li>
<li><strong>Health department records:</strong> Inspection reports, violation histories, and complaint records for restaurants and food facilities</li>
</ul>

<h2>Damages in Food Contamination Cases</h2>
<p>Serious foodborne illness cases can result in substantial damages including medical expenses (hospitalization, dialysis for kidney failure, long-term treatment), lost wages and earning capacity, pain and suffering, permanent organ damage, <a href="/wrongful-death-lawyers/">wrongful death</a>, and emotional distress. Under Georgia's comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>), recovery is available if less than 50% at fault. South Carolina's threshold is 51%.</p>

<h2>Filing Deadlines</h2>
<p>Georgia allows <strong>2 years</strong> from the date of injury (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>). South Carolina allows <strong>3 years</strong> (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). Report your illness to your local health department and seek medical attention immediately — stool culture testing is critical evidence that must be obtained while you are symptomatic.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue a restaurant or food company for food poisoning?',
                'answer'   => 'Yes. When contaminated food causes serious illness, you can pursue claims against the restaurant, food manufacturer, processor, or distributor under strict liability, negligence, and breach of warranty theories. The key challenge is proving which specific food product caused your illness.',
            ),
            array(
                'question' => 'How do you prove which food made me sick?',
                'answer'   => 'Proving the source requires stool culture testing (to identify the pathogen), CDC PulseNet matching (to link your illness to a known outbreak), food traceback investigation, and epidemiological analysis. Medical records and health department reports provide additional evidence.',
            ),
            array(
                'question' => 'What foodborne illnesses are most dangerous?',
                'answer'   => 'E. coli O157:H7 (can cause kidney failure and death), Listeria (dangerous for pregnant women and immunocompromised), Salmonella (can spread to bloodstream), and Hepatitis A (liver infection) are among the most dangerous. Children, elderly, pregnant women, and immunocompromised individuals are at highest risk.',
            ),
            array(
                'question' => 'What should I do if I suspect food poisoning?',
                'answer'   => 'Seek medical attention immediately and request a stool culture test — this is critical evidence. Report your illness to your local health department. Preserve any leftover food, packaging, and receipts. Note where and when you ate the suspected food and what you consumed.',
            ),
            array(
                'question' => 'How long do I have to file a food contamination claim?',
                'answer'   => 'Georgia allows 2 years from the date of illness (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Act quickly — medical testing must be done while you are symptomatic, and food evidence degrades rapidly.',
            ),
        ),
    ),

    /* ============================================================
       8. Defective Home Appliance
       ============================================================ */
    array(
        'title'   => 'Defective Home Appliance Lawyers',
        'slug'    => 'defective-home-appliance',
        'excerpt' => 'Injured by a defective home appliance? Washing machines, dryers, stoves, water heaters, and other household appliances can cause fires, explosions, electrocution, and burns. Our lawyers hold manufacturers accountable.',
        'content' => <<<'HTML'
<h2>Defective Home Appliance Lawyers in Georgia &amp; South Carolina</h2>
<p>Home appliances are among the most trusted products in our daily lives — we rely on them without a second thought. But defective washing machines, dryers, dishwashers, stoves, ovens, refrigerators, water heaters, space heaters, and other household appliances cause thousands of injuries and property losses every year. The <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">CPSC</a> reports that home appliance-related incidents cause hundreds of deaths and tens of thousands of injuries annually, with dryer fires alone causing an estimated 2,900 home fires per year according to the <a href="https://www.nfpa.org/" target="_blank" rel="noopener">National Fire Protection Association (NFPA)</a>.</p>
<p>At Roden Law, our defective home appliance lawyers represent injury victims and families throughout Georgia and South Carolina. We pursue strict liability and negligence claims against appliance manufacturers, identifying the specific defect that caused the injury and holding the manufacturer accountable for the full scope of harm.</p>

<h2>Common Defective Home Appliances</h2>
<p>Home appliance defects create risks of fire, explosion, electrocution, and mechanical injury:</p>
<ul>
<li><strong>Dryers:</strong> Lint trap design defects that allow lint accumulation in the exhaust system, leading to fires. Defective thermal fuses and high-limit thermostats that fail to shut off heating elements</li>
<li><strong>Washing machines:</strong> Structural failures causing violent shaking and component ejection, mold-prone front-loader designs, and flooding from hose connection defects</li>
<li><strong>Stoves and ovens:</strong> Gas leak defects causing explosions, defective anti-tip brackets on ranges (risk of child tip-over scalding), and oven door glass spontaneously shattering</li>
<li><strong>Water heaters:</strong> Temperature and pressure relief valve failures causing explosions, scalding from inadequate temperature regulation, and gas leak defects</li>
<li><strong>Space heaters:</strong> Tip-over ignition defects, automatic shutoff failures, and combustible housing materials that cause <a href="/burn-injury-lawyers/">house fires and burn injuries</a></li>
<li><strong>Refrigerators:</strong> Compressor failures causing fire, defective ice maker water line connections causing flooding, and entrapment hazards in older models</li>
<li><strong>Dishwashers:</strong> Electrical defects causing fires, flooding from door seal failures, and heating element malfunctions</li>
<li><strong>Pressure cookers and instant pots:</strong> Defective locking mechanisms that allow the lid to be opened while pressurized, causing explosive release of scalding contents</li>
</ul>

<h2>Fire and Burn Injuries from Defective Appliances</h2>
<p>The most catastrophic home appliance injuries involve fire and <a href="/burn-injury-lawyers/">burns</a>. Defective dryers, space heaters, stoves, and electrical appliances can ignite house fires that cause severe burn injuries, smoke inhalation, carbon monoxide poisoning, and <a href="/wrongful-death-lawyers/">wrongful death</a>. These cases often involve extensive property damage in addition to personal injuries.</p>
<p>When a home appliance causes a fire, investigating the origin and cause of the fire is critical. Our attorneys work with certified fire investigators and electrical engineers to examine the appliance, identify the defect, and establish that the appliance — not user error or other causes — was responsible for the fire.</p>

<h2>Georgia and South Carolina Product Liability Law</h2>
<p>Home appliances are products subject to strict liability under Georgia's product liability statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-1/section-51-1-11/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>) and South Carolina common law:</p>
<ul>
<li><strong>Design defect:</strong> The appliance's design is inherently dangerous — for example, a dryer designed with a lint trap system that inevitably allows dangerous lint accumulation</li>
<li><strong>Manufacturing defect:</strong> A specific unit was improperly assembled or contained substandard components — a wiring defect in a particular dishwasher, for example</li>
<li><strong>Failure to warn:</strong> The manufacturer failed to adequately warn about fire risks, maintenance requirements, or dangerous conditions</li>
</ul>
<p>Georgia's comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>) allows recovery if less than 50% at fault. South Carolina's threshold is 51%.</p>

<h2>Evidence Preservation After an Appliance Incident</h2>
<p>Preserving the defective appliance is essential — particularly after a fire, where the appliance may be the key evidence. After a fire or explosion:</p>
<ul>
<li><strong>Do not dispose of the appliance:</strong> Even if it appears destroyed, forensic examination can identify the defect</li>
<li><strong>Photograph everything:</strong> The appliance, the damage scene, and any visible defects or failure points</li>
<li><strong>Save receipts and documentation:</strong> Purchase records, warranty information, and any recall notices</li>
<li><strong>Contact an attorney before insurance settlement:</strong> Insurance companies may try to dispose of the appliance or settle property claims quickly, eliminating your product liability evidence</li>
</ul>

<h2>Filing Deadlines</h2>
<p>Georgia allows <strong>2 years</strong> from the date of injury (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) with a <strong>10-year statute of repose</strong>. South Carolina allows <strong>3 years</strong> (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). Act immediately to preserve the appliance and prevent evidence destruction.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What are the most commonly defective home appliances?',
                'answer'   => 'Dryers (lint fire hazards), washing machines (structural failures), stoves and ovens (gas leaks, tip-over risks), water heaters (explosion risk from valve failures), space heaters (fire hazards), pressure cookers (explosive lid release), and dishwashers (electrical fire risk) are among the most commonly defective household appliances.',
            ),
            array(
                'question' => 'What should I do if a home appliance causes a fire?',
                'answer'   => 'Ensure everyone\'s safety first. Do not dispose of the appliance — even a burned appliance can be forensically examined to identify the defect. Photograph everything, save purchase receipts and warranty documents, and contact an attorney before settling with your homeowner\'s insurance company.',
            ),
            array(
                'question' => 'Can I sue the appliance manufacturer if my house catches fire?',
                'answer'   => 'Yes. If the fire was caused by a defect in the appliance, you can pursue strict liability and negligence claims against the manufacturer for personal injuries, property damage, and other losses. The key is preserving the appliance for forensic examination to prove the defect caused the fire.',
            ),
            array(
                'question' => 'What if my appliance was recalled but I never received the recall notice?',
                'answer'   => 'A recall does not eliminate your legal claims — if anything, it strengthens them by showing the manufacturer knew the product was dangerous. Manufacturers have a duty to effectively notify consumers of recalls. Failure to provide adequate recall notification may itself be evidence of negligence.',
            ),
            array(
                'question' => 'How long do I have to file a defective home appliance claim?',
                'answer'   => 'Georgia allows 2 years from injury (O.C.G.A. § 9-3-33) with a 10-year statute of repose from first sale. South Carolina allows 3 years (S.C. Code § 15-3-530). Preserve the appliance immediately — it is the most critical piece of evidence in your case.',
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
