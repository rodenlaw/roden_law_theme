<?php
/**
 * Seeder: 8 Burn Injury Sub-Type Pages
 *
 * Creates 8 child posts under the burn-injury-lawyers pillar, each covering
 * a specific type of burn injury.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-burn-injury-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: burn-injury-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'burn-injury-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'burn-injury-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "burn-injury-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'burn-injuries', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Burn Injuries', 'practice_category', array( 'slug' => 'burn-injuries' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Workplace Burn Injury
       ============================================================ */
    array(
        'title'   => 'Workplace Burn Injury Lawyers',
        'slug'    => 'workplace-burn-injury',
        'excerpt' => 'Suffered a burn injury at work in Georgia or South Carolina? Our attorneys pursue workers\' compensation benefits and third-party negligence claims against responsible parties for maximum compensation.',
        'content' => <<<'HTML'
<h2>Workplace Burn Injury Claims in Georgia &amp; South Carolina</h2>
<p>Burn injuries are among the most devastating workplace injuries, frequently resulting in permanent scarring, disfigurement, and long-term disability. According to the <a href="https://www.bls.gov/iif/" target="_blank" rel="noopener">Bureau of Labor Statistics (BLS)</a>, thousands of workers suffer burn injuries on the job each year in industries including manufacturing, construction, food service, chemical processing, and utilities. Georgia and South Carolina workers who sustain burn injuries may be entitled to workers' compensation benefits and, in many cases, additional compensation through third-party negligence claims.</p>
<p>At Roden Law, our workplace burn injury lawyers understand the intersection of <a href="/workers-compensation-lawyers/">workers' compensation law</a> and personal injury liability that governs these complex cases. We pursue every available avenue of compensation for workers who suffer burns due to employer negligence, unsafe working conditions, defective equipment, or the negligence of third parties.</p>

<h2>Common Causes of Workplace Burns</h2>
<p>Workplace burn injuries occur in a wide variety of settings and through numerous mechanisms:</p>
<ul>
<li><strong>Thermal burns:</strong> Contact with flames, hot surfaces, steam, or molten materials in manufacturing and food service</li>
<li><strong>Chemical burns:</strong> Exposure to <a href="/burn-injury-lawyers/chemical-burn-injury/">corrosive chemicals</a> in industrial settings, laboratories, and cleaning operations</li>
<li><strong>Electrical burns:</strong> Contact with live electrical equipment, exposed wiring, or arc flash events in <a href="/construction-accident-lawyers/">construction</a> and utilities</li>
<li><strong>Explosions:</strong> <a href="/burn-injury-lawyers/explosion-gas-line-burn/">Gas leaks, combustible dust, and chemical reactions</a> causing blast injuries and flash burns</li>
<li><strong>Friction burns:</strong> Contact with moving machinery, conveyor belts, and industrial equipment</li>
<li><strong>Scalding:</strong> <a href="/burn-injury-lawyers/scalding-hot-liquid-burn/">Hot liquid spills</a> in food service, industrial processes, and maintenance work</li>
</ul>

<h2>OSHA Standards &amp; Employer Obligations</h2>
<p>The <a href="https://www.osha.gov/" target="_blank" rel="noopener">Occupational Safety and Health Administration (OSHA)</a> establishes safety standards that employers must follow to protect workers from burn hazards. Key OSHA requirements include providing appropriate personal protective equipment (PPE) including fire-resistant clothing, maintaining proper ventilation for chemical and thermal hazards, implementing lockout/tagout procedures for electrical and mechanical equipment, providing adequate fire suppression systems, conducting hazard communication training for chemical exposure risks, and maintaining emergency eyewash stations and safety showers.</p>
<p>Violations of OSHA standards (29 CFR 1910 for general industry; 29 CFR 1926 for construction) can serve as powerful evidence of employer negligence in burn injury cases.</p>

<h2>Workers' Compensation vs. Third-Party Claims</h2>
<p>Georgia's workers' compensation system (<a href="https://law.justia.com/codes/georgia/title-34/chapter-9/" target="_blank" rel="noopener">O.C.G.A. § 34-9-1 et seq.</a>) provides no-fault benefits for workplace injuries, including medical treatment, temporary total disability payments, and permanent partial disability benefits. South Carolina's system operates similarly. However, workers' compensation limits the damages available — you cannot recover for pain and suffering through workers' comp alone.</p>
<p>If a third party contributed to your burn injury — such as a <a href="/burn-injury-lawyers/defective-product-burn/">defective equipment manufacturer</a>, a subcontractor, a property owner, or a chemical supplier — you may file a separate personal injury lawsuit against that party to recover full damages including pain and suffering, emotional distress, and disfigurement. Our attorneys evaluate every workplace burn case for potential third-party claims.</p>

<h2>Compensation for Workplace Burn Injuries</h2>
<p>Workplace burn victims may be entitled to workers' compensation benefits covering medical treatment and rehabilitation, wage replacement during recovery, permanent impairment benefits, and vocational rehabilitation. Additional third-party claim damages may include pain and suffering, emotional distress, permanent disfigurement, loss of quality of life, and future medical expenses including reconstructive surgery. Contact Roden Law for a free consultation — we fight for maximum compensation for workplace burn victims.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue my employer for a workplace burn injury?',
                'answer'   => 'In most cases, workers\' compensation is the exclusive remedy against your employer. However, if a third party such as a equipment manufacturer, subcontractor, or chemical supplier contributed to your burn, you can file a separate personal injury lawsuit against that party for full damages.',
            ),
            array(
                'question' => 'What workers\' compensation benefits are available for burn injuries in Georgia?',
                'answer'   => 'Georgia workers\' comp (O.C.G.A. § 34-9-1) provides medical treatment, temporary total disability payments (two-thirds of average weekly wage), permanent partial disability benefits, and vocational rehabilitation. Severe burns may qualify for permanent total disability benefits.',
            ),
            array(
                'question' => 'Can OSHA violations help my burn injury case?',
                'answer'   => 'Yes. OSHA violations can serve as strong evidence of negligence in a third-party claim. Common violations in burn cases include failure to provide PPE, inadequate hazard communication, and improper lockout/tagout procedures.',
            ),
            array(
                'question' => 'What should I do after suffering a burn at work?',
                'answer'   => 'Seek immediate medical attention, report the injury to your employer, document the hazardous condition with photos, preserve any defective equipment, file a workers\' compensation claim, and consult an attorney to evaluate potential third-party claims.',
            ),
            array(
                'question' => 'How long do I have to file a workers\' compensation claim for a burn injury?',
                'answer'   => 'In Georgia, you must report the injury to your employer within 30 days and file a claim within one year (O.C.G.A. § 34-9-82). In South Carolina, the notice period is 90 days and the filing deadline is two years. Missing these deadlines can bar your claim.',
            ),
        ),
    ),

    /* ============================================================
       2. House Fire and Apartment Fire Burn
       ============================================================ */
    array(
        'title'   => 'House Fire and Apartment Fire Burn Lawyers',
        'slug'    => 'house-apartment-fire-burn',
        'excerpt' => 'Burned in a house fire or apartment fire in Georgia or South Carolina? Our attorneys hold landlords, property managers, and negligent parties accountable for fire injuries caused by unsafe conditions.',
        'content' => <<<'HTML'
<h2>House Fire &amp; Apartment Fire Burn Injury Claims</h2>
<p>House fires and apartment fires cause some of the most devastating burn injuries, often resulting in permanent disfigurement, respiratory damage, and death. The <a href="https://www.nfpa.org/education-and-research/research/nfpa-research/fire-statistical-reports" target="_blank" rel="noopener">National Fire Protection Association (NFPA)</a> reports that U.S. fire departments respond to hundreds of thousands of structure fires each year, causing thousands of civilian deaths and tens of thousands of injuries. In apartment buildings and rental properties, negligent landlords and property managers are frequently responsible for conditions that cause or worsen fires.</p>
<p>At Roden Law, our fire injury attorneys represent burn victims throughout Georgia and South Carolina who were injured due to landlord negligence, faulty electrical wiring, defective appliances, arson, and building code violations. We pursue full compensation against every responsible party.</p>

<h2>Common Causes of Residential Fires</h2>
<p>Residential fires that give rise to injury claims often result from preventable conditions:</p>
<ul>
<li><strong>Faulty electrical wiring:</strong> Outdated, overloaded, or improperly installed wiring is a leading cause of residential fires, particularly in older apartments</li>
<li><strong>Defective appliances and products:</strong> <a href="/burn-injury-lawyers/defective-product-burn/">Malfunctioning heaters, stoves, dryers, and electrical panels</a> causing fires</li>
<li><strong>Gas leaks:</strong> <a href="/burn-injury-lawyers/explosion-gas-line-burn/">Natural gas and propane leaks</a> from faulty connections or damaged lines</li>
<li><strong>Missing or disabled smoke alarms:</strong> Landlords who fail to install or maintain working smoke detectors</li>
<li><strong>Blocked fire exits:</strong> Locked, obstructed, or inadequate emergency exits in multi-unit buildings</li>
<li><strong>Heating equipment:</strong> Space heaters, furnaces, and fireplaces that malfunction or are improperly installed</li>
<li><strong>Arson:</strong> Intentionally set fires, often covered by the property owner's insurance</li>
</ul>

<h2>Landlord &amp; Property Owner Liability</h2>
<p>Georgia law (<a href="https://law.justia.com/codes/georgia/title-44/chapter-7/" target="_blank" rel="noopener">O.C.G.A. § 44-7-1 et seq.</a>) imposes duties on landlords to maintain rental properties in a habitable and safe condition. South Carolina's landlord-tenant laws impose similar obligations. Property owners and managers may be held liable for fire injuries when they fail to maintain electrical systems and wiring, fail to install or maintain working smoke detectors and fire alarms, block or lock fire exits, ignore known fire hazards, fail to provide adequate fire extinguishers in common areas, or violate building and fire codes.</p>
<p>Under Georgia's <a href="/premises-liability-lawyers/">premises liability statute</a> (O.C.G.A. § 51-3-1), property owners owe a duty of ordinary care to maintain safe conditions for tenants and their guests.</p>

<h2>Building Code &amp; Fire Code Violations</h2>
<p>Georgia and South Carolina adopt and enforce building codes and fire codes that establish minimum safety standards for residential structures. Violations of these codes — such as missing smoke detectors, inadequate fire-rated construction, blocked egress routes, or outdated electrical panels — constitute evidence of negligence. Fire investigators and building inspectors' reports documenting code violations are critical evidence in residential fire injury cases.</p>

<h2>Compensation for Fire Burn Victims</h2>
<p>Victims of residential fire burns may recover damages for emergency medical treatment and burn unit care, skin grafts and reconstructive surgeries, physical therapy and rehabilitation, scarring and permanent disfigurement, pain and suffering, emotional and psychological trauma (including PTSD), lost wages and earning capacity, loss of personal property, and wrongful death damages if a loved one was killed. Our attorneys work with fire investigators, building code experts, and burn care specialists to establish liability and document the full extent of our clients' damages. Contact Roden Law for a free consultation — no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue my landlord if I was burned in an apartment fire?',
                'answer'   => 'Yes. If the fire was caused by the landlord\'s failure to maintain electrical systems, install working smoke detectors, provide adequate fire exits, or otherwise maintain safe premises, the landlord can be held liable for your burn injuries under Georgia (O.C.G.A. § 44-7-1) or South Carolina landlord-tenant law.',
            ),
            array(
                'question' => 'Is a landlord required to install smoke detectors in Georgia?',
                'answer'   => 'Yes. Georgia law (O.C.G.A. § 25-2-40) requires smoke detectors in all residential dwellings. Landlords must ensure detectors are operational at the time of each new tenancy. Failure to comply constitutes negligence if a fire causes injury.',
            ),
            array(
                'question' => 'What if a defective appliance caused the fire?',
                'answer'   => 'If a defective heater, stove, dryer, or other appliance caused the fire, the manufacturer may be liable under product liability law. You may also have claims against the installer, retailer, or landlord who provided the defective equipment.',
            ),
            array(
                'question' => 'How long do I have to file a fire injury lawsuit in Georgia or South Carolina?',
                'answer'   => 'Georgia\'s statute of limitations for personal injury is 2 years (O.C.G.A. § 9-3-33). South Carolina allows 3 years (S.C. Code § 15-3-530). Property damage claims may have different deadlines. Acting quickly is important to preserve fire investigation evidence.',
            ),
            array(
                'question' => 'Can I recover compensation for PTSD after a house fire?',
                'answer'   => 'Yes. Emotional and psychological damages — including post-traumatic stress disorder, anxiety, depression, and sleep disorders — are compensable in fire injury claims. Our attorneys work with mental health professionals to document these damages.',
            ),
        ),
    ),

    /* ============================================================
       3. Chemical Burn Injury
       ============================================================ */
    array(
        'title'   => 'Chemical Burn Injury Lawyers',
        'slug'    => 'chemical-burn-injury',
        'excerpt' => 'Suffered a chemical burn in Georgia or South Carolina? Our attorneys pursue claims against employers, chemical manufacturers, and property owners for injuries caused by exposure to corrosive and toxic chemicals.',
        'content' => <<<'HTML'
<h2>Chemical Burn Injury Claims in Georgia &amp; South Carolina</h2>
<p>Chemical burns are caused by exposure to corrosive substances including acids, alkalis, solvents, oxidizers, and other hazardous chemicals. Unlike thermal burns, chemical burns continue to damage tissue until the chemical is completely removed, often resulting in deeper and more severe injuries. The <a href="https://www.cdc.gov/niosh/" target="_blank" rel="noopener">National Institute for Occupational Safety and Health (NIOSH)</a> reports that chemical burns account for a significant percentage of occupational injuries, with workers in manufacturing, agriculture, construction, and cleaning services at highest risk.</p>
<p>At Roden Law, our chemical burn injury attorneys represent victims throughout Georgia and South Carolina who suffer burns from workplace chemical exposure, consumer product defects, hazardous material spills, and negligent property maintenance.</p>

<h2>Common Sources of Chemical Burns</h2>
<p>Chemical burn injuries arise from diverse sources in both occupational and consumer settings:</p>
<ul>
<li><strong>Industrial chemicals:</strong> Acids (sulfuric, hydrochloric, hydrofluoric), alkalis (sodium hydroxide, potassium hydroxide), and solvents used in manufacturing</li>
<li><strong>Construction materials:</strong> Wet concrete (calcium hydroxite), paint strippers, adhesives, and sealants encountered on <a href="/construction-accident-lawyers/">construction sites</a></li>
<li><strong>Cleaning products:</strong> Industrial-strength cleaners, degreasers, and bleach solutions</li>
<li><strong>Agricultural chemicals:</strong> Pesticides, herbicides, fertilizers, and anhydrous ammonia</li>
<li><strong>Consumer products:</strong> <a href="/burn-injury-lawyers/defective-product-burn/">Defective household chemicals</a>, drain cleaners, and beauty products</li>
<li><strong>Hazardous material spills:</strong> Transportation accidents and pipeline releases exposing communities to corrosive substances</li>
</ul>

<h2>OSHA &amp; Hazard Communication Requirements</h2>
<p>The <a href="https://www.osha.gov/hazcom" target="_blank" rel="noopener">OSHA Hazard Communication Standard (29 CFR 1910.1200)</a> requires employers to inform workers about chemical hazards in the workplace through Safety Data Sheets (SDS), container labeling, and employee training. Additional OSHA requirements include providing appropriate personal protective equipment (PPE) for chemical handling, maintaining emergency eyewash stations and safety showers within 10 seconds of chemical use areas, implementing chemical spill response procedures, and ensuring proper ventilation in areas where chemicals are used or stored.</p>
<p>Failure to comply with these requirements constitutes evidence of employer negligence and may support both <a href="/workers-compensation-lawyers/">workers' compensation claims</a> and third-party liability actions.</p>

<h2>Severity of Chemical Burns</h2>
<p>Chemical burns are classified by depth: superficial (first-degree), partial-thickness (second-degree), and full-thickness (third-degree). Alkali burns are generally more severe than acid burns because they penetrate deeper into tissue. Hydrofluoric acid is particularly dangerous because it can cause systemic toxicity and cardiac arrest even from small exposure areas. Chemical burns to the eyes can cause permanent vision loss, and inhalation of chemical fumes can cause severe respiratory injuries.</p>

<h2>Liability in Chemical Burn Cases</h2>
<p>Multiple parties may bear responsibility for chemical burn injuries: employers who fail to provide adequate PPE and safety training, chemical manufacturers who produce unreasonably dangerous products or provide inadequate warnings, property owners and contractors who fail to contain hazardous materials, and transportation companies responsible for chemical spills. Under Georgia law (O.C.G.A. § 51-12-33), you may recover damages if less than 50% at fault. South Carolina allows recovery if less than 51% at fault. Our attorneys work with chemical engineers and toxicology experts to establish the source of exposure, the adequacy of safety measures, and the full extent of our clients' injuries. Contact Roden Law for a free case evaluation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What should I do immediately after a chemical burn?',
                'answer'   => 'Remove contaminated clothing, flush the affected area with clean water for at least 20 minutes (unless the chemical is reactive with water), do not try to neutralize the chemical, seek emergency medical treatment, identify the chemical involved using the SDS, and report the incident to your supervisor if it occurred at work.',
            ),
            array(
                'question' => 'Can I sue a chemical manufacturer for a burn injury?',
                'answer'   => 'Yes. Under product liability law, chemical manufacturers can be held liable for producing unreasonably dangerous products, failing to provide adequate warnings, or providing defective safety information. You do not need to prove negligence — strict liability may apply.',
            ),
            array(
                'question' => 'What is the employer\'s obligation regarding chemical safety?',
                'answer'   => 'Employers must comply with OSHA\'s Hazard Communication Standard (29 CFR 1910.1200) by maintaining Safety Data Sheets, labeling chemical containers, training employees on chemical hazards, providing PPE, and installing emergency eyewash stations and safety showers.',
            ),
            array(
                'question' => 'Are chemical burns covered by workers\' compensation?',
                'answer'   => 'Yes. Chemical burns sustained at work are covered by Georgia workers\' comp (O.C.G.A. § 34-9-1) and South Carolina\'s system. You may also have third-party claims against chemical manufacturers or suppliers for additional damages including pain and suffering.',
            ),
            array(
                'question' => 'How long do I have to file a chemical burn lawsuit?',
                'answer'   => 'Georgia\'s statute of limitations is 2 years (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Workers\' comp deadlines are shorter — 1 year in Georgia and 2 years in South Carolina. Consult an attorney promptly.',
            ),
        ),
    ),

    /* ============================================================
       4. Electrical Burn Injury
       ============================================================ */
    array(
        'title'   => 'Electrical Burn Injury Lawyers',
        'slug'    => 'electrical-burn-injury',
        'excerpt' => 'Suffered an electrical burn injury in Georgia or South Carolina? Our attorneys handle electrocution and arc flash injury claims against employers, contractors, power companies, and property owners.',
        'content' => <<<'HTML'
<h2>Electrical Burn Injury Claims in Georgia &amp; South Carolina</h2>
<p>Electrical burns are among the most severe and complex burn injuries, capable of causing devastating internal damage that far exceeds what is visible on the skin's surface. Electrical current passing through the body can destroy muscle tissue, damage organs, cause cardiac arrhythmias, and produce thermal burns at entry and exit points. The <a href="https://www.bls.gov/iif/" target="_blank" rel="noopener">Bureau of Labor Statistics</a> reports that electrocutions consistently rank among the top causes of workplace fatalities, and OSHA identifies electrocution as one of the "Fatal Four" hazards in the construction industry.</p>
<p>At Roden Law, our electrical burn injury attorneys represent workers, homeowners, and members of the public who suffer electrocution injuries due to negligence throughout Georgia and South Carolina. These cases often overlap with <a href="/construction-accident-lawyers/electrocution-construction-site/">construction site electrocution claims</a> and <a href="/workers-compensation-lawyers/">workers' compensation cases</a>.</p>

<h2>Common Causes of Electrical Burns</h2>
<p>Electrical burn injuries result from several types of electrical contact:</p>
<ul>
<li><strong>Arc flash and arc blast:</strong> Explosive releases of energy from electrical faults creating temperatures up to 35,000°F — hotter than the surface of the sun</li>
<li><strong>Direct contact with live conductors:</strong> Touching exposed wiring, energized equipment, or overhead power lines</li>
<li><strong>Faulty electrical equipment:</strong> <a href="/burn-injury-lawyers/defective-product-burn/">Defective appliances, tools, and machinery</a> with inadequate insulation or grounding</li>
<li><strong>Construction site hazards:</strong> Contact with overhead power lines during crane operations, scaffolding work, or <a href="/construction-accident-lawyers/">construction activities</a></li>
<li><strong>Residential electrical hazards:</strong> Outdated wiring, ungrounded outlets, and improper DIY electrical work</li>
<li><strong>Downed power lines:</strong> Storm damage, vehicle collisions with utility poles, and inadequate line maintenance</li>
</ul>

<h2>OSHA Electrical Safety Standards</h2>
<p>OSHA's electrical safety standards (29 CFR 1910 Subpart S for general industry; 29 CFR 1926 Subpart K for construction) establish comprehensive requirements for electrical safety in the workplace. Key requirements include lockout/tagout (LOTO) procedures before working on energized equipment, maintaining safe clearance distances from overhead power lines, providing insulated tools and PPE including arc-flash rated clothing, implementing ground-fault circuit interrupter (GFCI) protection, and conducting electrical safety training for all exposed workers.</p>
<p>The <a href="https://www.nfpa.org/codes-and-standards/nfpa-70e" target="_blank" rel="noopener">NFPA 70E Standard for Electrical Safety</a> in the workplace provides additional requirements for arc flash risk assessment and protective equipment. Violations of OSHA or NFPA standards constitute strong evidence of negligence.</p>

<h2>The Severity of Electrical Burns</h2>
<p>Electrical burns present unique medical challenges because the visible surface burns often represent only a fraction of the total injury. Electrical current follows paths of least resistance through the body, damaging muscles, nerves, blood vessels, and organs along the way. Complications include compartment syndrome requiring emergency fasciotomy, rhabdomyolysis (muscle breakdown) causing kidney failure, cardiac arrhythmias and arrest, neurological damage and chronic pain syndromes, cataracts developing months after exposure, and amputation of affected extremities.</p>

<h2>Pursuing an Electrical Burn Injury Claim</h2>
<p>Liable parties in electrical burn cases may include employers who violated OSHA electrical safety standards, general contractors responsible for construction site safety, electrical contractors who performed negligent wiring or installation, power companies that failed to maintain lines or de-energize systems, <a href="/product-liability-lawyers/">manufacturers of defective electrical equipment</a>, and property owners who maintained dangerous electrical conditions. Georgia's comparative fault statute (O.C.G.A. § 51-12-33) allows recovery if less than 50% at fault. South Carolina allows recovery if less than 51% at fault. Our attorneys work with electrical engineers and burn specialists to prove liability and maximize compensation. Contact Roden Law for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is an arc flash injury?',
                'answer'   => 'An arc flash is an explosive release of electrical energy through the air, producing intense heat (up to 35,000°F), blinding light, pressure waves, and shrapnel. Arc flash injuries can cause severe burns, hearing loss, and blast trauma even without direct electrical contact.',
            ),
            array(
                'question' => 'Can I sue a power company for an electrical burn from a downed power line?',
                'answer'   => 'Yes. Power companies have a duty to maintain their lines and promptly respond to outages and downed lines. If a power company\'s negligence — such as deferred maintenance, failure to clear vegetation, or delayed response — caused your electrical burn, they can be held liable.',
            ),
            array(
                'question' => 'What OSHA standards apply to electrical safety?',
                'answer'   => 'OSHA\'s electrical safety standards (29 CFR 1910 Subpart S for general industry; 29 CFR 1926 Subpart K for construction) require lockout/tagout procedures, safe clearance distances, GFCI protection, insulated tools, and arc-flash rated PPE. Violations are strong evidence of negligence.',
            ),
            array(
                'question' => 'Are electrical burns covered by workers\' compensation?',
                'answer'   => 'Yes. On-the-job electrical burns are covered by workers\' comp in both Georgia (O.C.G.A. § 34-9-1) and South Carolina. Third-party claims against contractors, equipment manufacturers, or power companies may also be available for additional damages.',
            ),
            array(
                'question' => 'How serious are internal injuries from electrocution?',
                'answer'   => 'Very serious. Electrical current damages internal tissues that cannot be seen externally. Victims may suffer muscle destruction, organ damage, cardiac complications, nerve damage, and kidney failure from muscle breakdown (rhabdomyolysis). Delayed complications like cataracts can appear months later.',
            ),
        ),
    ),

    /* ============================================================
       5. Explosion and Gas Line Burn
       ============================================================ */
    array(
        'title'   => 'Explosion and Gas Line Burn Lawyers',
        'slug'    => 'explosion-gas-line-burn',
        'excerpt' => 'Burned in an explosion or gas line accident in Georgia or South Carolina? Our attorneys hold gas companies, property owners, and contractors accountable for explosion injuries caused by negligence.',
        'content' => <<<'HTML'
<h2>Explosion &amp; Gas Line Burn Injury Claims</h2>
<p>Explosions and gas line accidents cause catastrophic burn injuries that can devastate entire families and communities. Natural gas leaks, propane tank failures, industrial explosions, and combustible dust events produce intense thermal burns, blast wave injuries, and shrapnel trauma. The <a href="https://www.phmsa.dot.gov/data-and-statistics/pipeline/gas-distribution-gas-gathering-gas-transmission-hazardous-liquids" target="_blank" rel="noopener">Pipeline and Hazardous Materials Safety Administration (PHMSA)</a> tracks hundreds of gas pipeline incidents annually across the United States, resulting in fatalities, injuries, and millions of dollars in property damage.</p>
<p>At Roden Law, our explosion injury attorneys represent victims of gas line accidents, industrial explosions, and propane tank failures throughout Georgia and South Carolina. These cases involve complex investigations to determine the source of the leak or ignition and identify all responsible parties.</p>

<h2>Common Causes of Explosions &amp; Gas Line Accidents</h2>
<p>Explosion and gas line burn injuries frequently result from preventable failures:</p>
<ul>
<li><strong>Natural gas leaks:</strong> Corroded or damaged gas distribution lines, faulty connections, and aging infrastructure</li>
<li><strong>Propane system failures:</strong> Defective regulators, damaged tanks, and improper installation</li>
<li><strong>Construction-related strikes:</strong> <a href="/construction-accident-lawyers/">Construction workers</a> hitting unmarked or improperly marked underground gas lines</li>
<li><strong>Defective gas appliances:</strong> <a href="/burn-injury-lawyers/defective-product-burn/">Malfunctioning furnaces, water heaters, and stoves</a> causing gas accumulation</li>
<li><strong>Industrial combustible dust:</strong> Grain dust, metal powder, and chemical dust explosions in manufacturing and processing facilities</li>
<li><strong>Chemical reactions:</strong> Improper storage or mixing of incompatible chemicals</li>
<li><strong>Failure to odorize gas:</strong> Inadequate mercaptan levels making leaks undetectable</li>
</ul>

<h2>Gas Utility &amp; Pipeline Operator Liability</h2>
<p>Gas utility companies and pipeline operators are held to high standards of care because of the inherently dangerous nature of natural gas distribution. Both Georgia and South Carolina regulate gas utilities through their public service commissions and require compliance with federal pipeline safety regulations (49 CFR 192). Gas companies may be liable for failure to properly maintain gas lines and connections, failure to detect and repair leaks, inadequate odorization of natural gas, failure to respond promptly to leak reports, improper installation of gas meters and regulators, and failure to locate and mark underground lines before excavation.</p>
<p>Under Georgia law (<a href="https://law.justia.com/codes/georgia/title-25/chapter-15/" target="_blank" rel="noopener">O.C.G.A. § 25-15-1 et seq.</a>), excavators must contact Georgia 811 before digging, and utility companies must accurately mark underground lines. South Carolina has similar "Call Before You Dig" laws (S.C. Code § 58-36-10 et seq.) requiring utility locating before excavation.</p>

<h2>Injuries from Explosions</h2>
<p>Explosion injuries are typically classified in four categories: primary blast injuries from pressure waves damaging lungs, ears, and organs; secondary injuries from shrapnel and flying debris; tertiary injuries from being thrown by the blast force; and quaternary injuries including burns, crush injuries, and inhalation of toxic fumes. Victims of explosions frequently suffer <a href="/brain-injury-lawyers/">traumatic brain injuries</a>, severe burns across large body surface areas, <a href="/spinal-cord-injury-lawyers/">spinal cord injuries</a>, amputations, hearing loss, and respiratory damage from smoke and chemical inhalation.</p>

<h2>Pursuing an Explosion Injury Claim</h2>
<p>Explosion and gas line cases require immediate investigation to preserve evidence before the scene is altered or repaired. Our attorneys work with fire investigators, gas engineers, and explosion experts to determine the cause, identify all responsible parties, and pursue maximum compensation. Liable parties may include gas utility companies, pipeline operators, propane suppliers, appliance manufacturers, contractors, and property owners. Georgia allows recovery if less than 50% at fault (O.C.G.A. § 51-12-33). South Carolina allows recovery if less than 51% at fault. Contact Roden Law immediately if you have been injured in an explosion — evidence preservation is critical.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue a gas company for an explosion caused by a gas leak?',
                'answer'   => 'Yes. Gas companies have a duty to maintain their infrastructure, detect leaks, and respond promptly to reports of gas odors. If a gas company\'s negligence caused the leak that led to the explosion, they can be held liable for all resulting injuries and damages.',
            ),
            array(
                'question' => 'What should I do if I smell gas in my home?',
                'answer'   => 'Leave the building immediately without operating light switches or electronics. Call 911 and your gas company from a safe distance. Do not re-enter until professionals confirm it is safe. If the gas company\'s delayed response causes an explosion, they may be liable.',
            ),
            array(
                'question' => 'Who is responsible if a construction crew hits a gas line?',
                'answer'   => 'Liability may fall on the excavating contractor for failing to call 811 before digging, the utility company for failing to accurately mark lines, or the project owner for inadequate site safety. Often, multiple parties share fault.',
            ),
            array(
                'question' => 'Are propane tank explosions covered by product liability law?',
                'answer'   => 'Yes. If the explosion was caused by a defective propane tank, regulator, or valve, the manufacturer can be held strictly liable. Claims may also be pursued against the propane supplier, installer, or maintenance company.',
            ),
            array(
                'question' => 'How long do I have to file an explosion injury claim?',
                'answer'   => 'Georgia\'s statute of limitations is 2 years (O.C.G.A. § 9-3-33) and South Carolina\'s is 3 years (S.C. Code § 15-3-530). However, explosion evidence deteriorates rapidly, so contacting an attorney immediately is crucial to preserve the scene and evidence.',
            ),
        ),
    ),

    /* ============================================================
       6. Scalding and Hot Liquid Burn
       ============================================================ */
    array(
        'title'   => 'Scalding and Hot Liquid Burn Lawyers',
        'slug'    => 'scalding-hot-liquid-burn',
        'excerpt' => 'Suffered a scald burn from hot liquids in Georgia or South Carolina? Our attorneys pursue compensation from restaurants, landlords, employers, and manufacturers responsible for preventable scalding injuries.',
        'content' => <<<'HTML'
<h2>Scalding &amp; Hot Liquid Burn Injury Claims</h2>
<p>Scald burns — caused by contact with hot liquids, steam, and grease — are the most common type of burn injury in the United States and are particularly devastating for children and elderly individuals. The <a href="https://ameriburn.org/" target="_blank" rel="noopener">American Burn Association</a> reports that scalds account for approximately 35% of all burn injuries requiring hospital admission. Hot water, coffee, soup, grease, steam, and other heated liquids can cause severe second- and third-degree burns in seconds at temperatures as low as 140°F.</p>
<p>At Roden Law, our scald burn attorneys represent victims throughout Georgia and South Carolina who suffer burn injuries from restaurant negligence, dangerously hot tap water in rental properties, <a href="/burn-injury-lawyers/workplace-burn-injury/">workplace spills</a>, and defective products that fail to adequately contain or regulate hot liquids.</p>

<h2>Common Causes of Scalding Injuries</h2>
<p>Scald burn claims arise from a variety of negligent conditions:</p>
<ul>
<li><strong>Restaurant and food service burns:</strong> Dangerously hot beverages, soups, and grease served or handled without adequate safety precautions</li>
<li><strong>Excessively hot tap water:</strong> Landlords and property managers who set water heaters above 120°F, creating scalding risks especially for children and elderly tenants</li>
<li><strong>Workplace scalds:</strong> Industrial steam burns, cooking grease splashes, and hot water exposure in food processing and manufacturing</li>
<li><strong>Defective products:</strong> <a href="/burn-injury-lawyers/defective-product-burn/">Coffee makers, kettles, pressure cookers, and instant pots</a> with inadequate safety features</li>
<li><strong>Daycare and nursing home negligence:</strong> Children and elderly residents scalded due to inadequate supervision and unsafe water temperatures</li>
<li><strong>Steam pipe and radiator burns:</strong> Exposed heating elements in older buildings and apartments</li>
</ul>

<h2>Premises Liability &amp; Landlord Obligations</h2>
<p>Property owners and landlords have a duty under Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-3/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a>) and South Carolina <a href="/premises-liability-lawyers/">premises liability law</a> to maintain their properties in a reasonably safe condition. This includes ensuring water heater temperatures are set to safe levels (the Consumer Product Safety Commission recommends 120°F), maintaining steam and radiator systems, and protecting tenants from known scalding hazards.</p>
<p>Landlords in both states can be held liable when they maintain water heaters at dangerously high temperatures, fail to install anti-scald devices in showers and bathtubs, leave exposed steam pipes or radiators accessible, or ignore tenant complaints about excessively hot water.</p>

<h2>Scalding Injuries in Children &amp; Elderly Adults</h2>
<p>Children under 5 and adults over 65 are at dramatically higher risk for severe scald burns because their skin is thinner and burns at lower temperatures. Scalding injuries in children are among the most common forms of child burn injuries. When a child is scalded at a daycare, school, or rental property, the supervising institution or property owner may face liability for negligent supervision or unsafe premises. When elderly residents are scalded in <a href="/nursing-home-abuse-lawyers/">nursing homes or assisted living facilities</a>, the facility may face negligence claims for inadequate supervision and unsafe water temperatures.</p>

<h2>Compensation for Scalding Injuries</h2>
<p>Victims of scalding burns may recover compensation for burn unit hospitalization and treatment, skin grafts and reconstructive surgery, physical therapy and scar management, pain and suffering, permanent scarring and disfigurement, emotional distress and psychological trauma, lost wages and reduced earning capacity, and future medical expenses. Georgia allows recovery if less than 50% at fault (O.C.G.A. § 51-12-33), and South Carolina allows recovery if less than 51% at fault. Contact Roden Law for a free consultation regarding your scalding burn injury.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue a restaurant for a hot coffee or soup burn?',
                'answer'   => 'Yes, if the restaurant served beverages or food at unreasonably dangerous temperatures without adequate warnings, used defective containers, or if employees negligently spilled hot liquids on you. Restaurants have a duty to serve products safely.',
            ),
            array(
                'question' => 'Is my landlord liable if the tap water scalded my child?',
                'answer'   => 'A landlord may be liable if the water heater was set above safe temperatures (the recommended maximum is 120°F) or if anti-scald devices were required but not installed. Georgia and South Carolina landlords must maintain safe conditions for tenants.',
            ),
            array(
                'question' => 'How hot does water have to be to cause a scald burn?',
                'answer'   => 'Water at 140°F causes a third-degree burn in just 5 seconds. At 150°F, a severe burn occurs in 2 seconds. At 160°F, it takes less than 1 second. The CPSC recommends setting water heaters to no higher than 120°F.',
            ),
            array(
                'question' => 'What damages can I recover for a scalding injury?',
                'answer'   => 'You may recover medical expenses, surgery costs, pain and suffering, permanent scarring and disfigurement, emotional distress, lost wages, and future medical care. In cases involving reckless conduct, punitive damages may also be available.',
            ),
            array(
                'question' => 'How long do I have to file a scalding burn lawsuit?',
                'answer'   => 'Georgia\'s statute of limitations is 2 years (O.C.G.A. § 9-3-33) and South Carolina\'s is 3 years (S.C. Code § 15-3-530). Claims involving minors may be tolled until the child reaches the age of majority. Consult an attorney promptly.',
            ),
        ),
    ),

    /* ============================================================
       7. Vehicle Fire Burn
       ============================================================ */
    array(
        'title'   => 'Vehicle Fire Burn Lawyers',
        'slug'    => 'vehicle-fire-burn',
        'excerpt' => 'Burned in a vehicle fire after a car accident in Georgia or South Carolina? Our attorneys pursue claims against at-fault drivers, vehicle manufacturers, and mechanics for fire-related burn injuries.',
        'content' => <<<'HTML'
<h2>Vehicle Fire Burn Injury Claims in Georgia &amp; South Carolina</h2>
<p>Vehicle fires following <a href="/car-accident-lawyers/">car accidents</a> cause some of the most catastrophic burn injuries imaginable. Occupants trapped in burning vehicles — whether due to impact damage preventing escape, jammed doors, or defective seatbelt releases — can suffer full-thickness burns across large portions of their bodies, inhalation injuries from toxic smoke, and permanent disfigurement. The <a href="https://www.nfpa.org/education-and-research/research/nfpa-research/fire-statistical-reports" target="_blank" rel="noopener">National Fire Protection Association (NFPA)</a> reports that vehicle fires cause hundreds of civilian deaths and thousands of injuries each year in the United States.</p>
<p>At Roden Law, our vehicle fire burn attorneys represent victims across Georgia and South Carolina in claims against negligent drivers who caused the initial collision, vehicle manufacturers whose design or manufacturing defects contributed to the fire, and auto repair shops whose negligent maintenance created fire hazards.</p>

<h2>Common Causes of Vehicle Fires</h2>
<p>Vehicle fires can result from collision-related causes and vehicle defects:</p>
<ul>
<li><strong>Post-collision fuel system rupture:</strong> Ruptured fuel tanks, severed fuel lines, and damaged fuel injectors releasing gasoline near ignition sources</li>
<li><strong>Defective fuel system design:</strong> Inadequately protected fuel tanks prone to rupture in rear-end or side-impact collisions</li>
<li><strong>Electrical system failures:</strong> Short circuits, faulty wiring, and <a href="/burn-injury-lawyers/electrical-burn-injury/">electrical defects</a> igniting flammable materials</li>
<li><strong>Battery fires:</strong> Electric vehicle and hybrid battery thermal runaway events</li>
<li><strong>Negligent repairs:</strong> Improper fuel system work, faulty electrical repairs, and oil leaks left unaddressed by mechanics</li>
<li><strong>Turbocharger and exhaust heat:</strong> Components reaching extreme temperatures near flammable materials</li>
<li><strong>Recalled vehicles:</strong> Manufacturers failing to adequately notify owners of fire-related recalls</li>
</ul>

<h2>Vehicle Manufacturer Liability</h2>
<p>Vehicle manufacturers can be held strictly liable under <a href="/product-liability-lawyers/">product liability law</a> when design or manufacturing defects cause or worsen vehicle fires. Common product liability claims in vehicle fire cases include fuel tank placement in crash-vulnerable locations, inadequate fuel system crash protection, defective fuel line connections and clamps, electrical system defects causing short circuits, insufficient fire barriers between engine compartment and cabin, and defective seatbelt or door latch mechanisms that trap occupants in burning vehicles.</p>
<p>The <a href="https://www.nhtsa.gov/recalls" target="_blank" rel="noopener">NHTSA recall database</a> documents hundreds of vehicle recalls related to fire risks. If your vehicle was subject to a recall that you were not adequately notified about, the manufacturer may face enhanced liability.</p>

<h2>Multiple Parties &amp; Insurance Coverage</h2>
<p>Vehicle fire burn cases often involve multiple liable parties: the at-fault driver whose negligence caused the initial collision, the vehicle manufacturer responsible for fire-related defects, auto repair shops that performed negligent maintenance, and parts manufacturers whose aftermarket components contributed to the fire. Georgia's comparative fault rule (O.C.G.A. § 51-12-33) allows you to recover damages if less than 50% at fault. South Carolina permits recovery if less than 51% at fault.</p>

<h2>Compensation for Vehicle Fire Burns</h2>
<p>Vehicle fire burn victims may be entitled to compensation for burn unit hospitalization, skin grafts, and reconstructive surgery, inhalation injury treatment, permanent scarring and disfigurement, pain and suffering, lost wages and diminished earning capacity, emotional trauma and PTSD, future medical care and rehabilitation, and <a href="/wrongful-death-lawyers/">wrongful death damages</a> if a loved one perished. Our attorneys work with fire investigators, automotive engineers, and burn care specialists to build compelling cases. Punitive damages may be available when manufacturers knowingly sold vehicles with fire-prone defects. Contact Roden Law for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue a car manufacturer if my vehicle caught fire after a crash?',
                'answer'   => 'Yes. If a design or manufacturing defect — such as an inadequately protected fuel tank, faulty wiring, or defective fuel lines — caused or worsened the fire, the manufacturer can be held strictly liable under product liability law.',
            ),
            array(
                'question' => 'What if my vehicle was subject to a fire-related recall?',
                'answer'   => 'If the manufacturer failed to adequately notify you of a fire-related recall, they may face enhanced liability. Check the NHTSA recall database at nhtsa.gov/recalls for your vehicle\'s recall history.',
            ),
            array(
                'question' => 'Can an auto mechanic be liable for a vehicle fire?',
                'answer'   => 'Yes. If negligent repairs — such as improper fuel system work, faulty electrical connections, or failure to address oil leaks — caused or contributed to the fire, the mechanic or repair shop can be held liable for resulting burn injuries.',
            ),
            array(
                'question' => 'Are electric vehicle battery fires handled differently?',
                'answer'   => 'EV battery fires involve unique technical issues including thermal runaway, toxic gas release, and difficulty extinguishing lithium-ion battery fires. These cases may involve product liability claims against the EV manufacturer and battery supplier.',
            ),
            array(
                'question' => 'How long do I have to file a vehicle fire burn claim?',
                'answer'   => 'Georgia\'s statute of limitations is 2 years (O.C.G.A. § 9-3-33) and South Carolina\'s is 3 years (S.C. Code § 15-3-530). Product liability claims may have different deadlines. Consult an attorney promptly to preserve evidence from the vehicle.',
            ),
        ),
    ),

    /* ============================================================
       8. Defective Product Burn
       ============================================================ */
    array(
        'title'   => 'Defective Product Burn Lawyers',
        'slug'    => 'defective-product-burn',
        'excerpt' => 'Burned by a defective product in Georgia or South Carolina? Our attorneys hold manufacturers, distributors, and retailers strictly liable for burn injuries caused by dangerous consumer and industrial products.',
        'content' => <<<'HTML'
<h2>Defective Product Burn Injury Claims</h2>
<p>Defective products cause thousands of burn injuries every year, from exploding e-cigarettes and overheating electronics to malfunctioning space heaters and defective pressure cookers. When a product is unreasonably dangerous due to a design defect, manufacturing defect, or inadequate warnings, the manufacturer, distributor, and retailer can all be held liable under <a href="/product-liability-lawyers/">product liability law</a> — without requiring proof that any specific party was negligent.</p>
<p>At Roden Law, our defective product burn attorneys represent victims across Georgia and South Carolina who suffer burn injuries from consumer products, industrial equipment, appliances, and electronics that fail to perform safely. We work with product engineers, fire investigators, and materials scientists to prove defects and pursue maximum compensation from manufacturers and their insurers.</p>

<h2>Common Products That Cause Burn Injuries</h2>
<p>Our attorneys handle burn injury claims involving a wide range of defective products:</p>
<ul>
<li><strong>Heating appliances:</strong> Space heaters, furnaces, fireplaces, and radiators with design or manufacturing defects</li>
<li><strong>Kitchen appliances:</strong> Pressure cookers, Instant Pots, coffee makers, and stoves that fail to contain heat or pressure</li>
<li><strong>Electronics:</strong> Laptops, smartphones, hoverboards, and power banks with defective lithium-ion batteries that overheat and ignite</li>
<li><strong>E-cigarettes and vaping devices:</strong> Battery explosions causing severe facial, hand, and thigh burns</li>
<li><strong>Children's products:</strong> Sleepwear, toys, and nursery items that fail to meet flammability standards</li>
<li><strong>Industrial equipment:</strong> Machinery, tools, and <a href="/burn-injury-lawyers/chemical-burn-injury/">chemical products</a> used in <a href="/burn-injury-lawyers/workplace-burn-injury/">workplace settings</a></li>
<li><strong>Automotive products:</strong> <a href="/burn-injury-lawyers/vehicle-fire-burn/">Vehicle components</a>, aftermarket parts, and automotive chemicals</li>
</ul>

<h2>Product Liability Law in Georgia &amp; South Carolina</h2>
<p>Georgia's product liability statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-3/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>) holds manufacturers strictly liable for injuries caused by defective products. This means you do not need to prove negligence — only that the product was defective and that the defect caused your injuries. South Carolina similarly applies strict liability to product defect cases, recognizing three types of defects:</p>
<ul>
<li><strong>Design defects:</strong> The product's fundamental design makes it unreasonably dangerous, even when manufactured correctly</li>
<li><strong>Manufacturing defects:</strong> An error during production causes a specific unit to deviate from the intended design</li>
<li><strong>Failure to warn:</strong> The manufacturer failed to provide adequate warnings or instructions about burn risks</li>
</ul>
<p>The <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">Consumer Product Safety Commission (CPSC)</a> tracks product recalls and safety reports that can provide critical evidence in defective product burn cases.</p>

<h2>Who Can Be Held Liable?</h2>
<p>Under the product liability chain of distribution, multiple parties can be held liable for defective product burn injuries: the product manufacturer, component part manufacturers, distributors and wholesalers, and retailers who sold the product. This strict liability doctrine ensures that injured consumers can recover compensation regardless of which party in the distribution chain introduced the defect.</p>

<h2>Compensation &amp; Punitive Damages</h2>
<p>Victims of defective product burns may recover medical expenses, reconstructive surgery costs, pain and suffering, permanent scarring and disfigurement, lost wages, emotional distress, and future medical care. In cases where the manufacturer knew about the defect and failed to act, punitive damages may be available. Georgia caps most punitive damages at $250,000 (O.C.G.A. § 51-12-5.1) with certain exceptions. South Carolina has no statutory cap but requires clear and convincing evidence. Our attorneys fight aggressively against manufacturers and their insurance companies to secure full compensation for defective product burn victims. Contact Roden Law for a free consultation — no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Do I need to prove the manufacturer was negligent?',
                'answer'   => 'No. Under strict product liability law in both Georgia (O.C.G.A. § 51-1-11) and South Carolina, you only need to prove the product was defective and the defect caused your burn injuries. You do not need to prove how or why the manufacturer made the error.',
            ),
            array(
                'question' => 'What should I do if a product burns me?',
                'answer'   => 'Seek immediate medical attention, preserve the product exactly as it is (do not repair or discard it), take photographs of the product and your injuries, keep all packaging and receipts, report the incident to the CPSC at SaferProducts.gov, and contact an attorney before speaking with the manufacturer.',
            ),
            array(
                'question' => 'Can I sue if the product was recalled after my injury?',
                'answer'   => 'Yes. A product recall actually strengthens your case by demonstrating the manufacturer acknowledged the defect. If you were not adequately notified of the recall before your injury, this may further support your claim.',
            ),
            array(
                'question' => 'Who is liable — the manufacturer or the store that sold it?',
                'answer'   => 'Both can be held liable under the chain of distribution doctrine. In practice, the manufacturer typically bears primary responsibility, but distributors and retailers can also be held liable. Having multiple liable parties can increase available insurance coverage for your recovery.',
            ),
            array(
                'question' => 'How long do I have to file a defective product burn claim?',
                'answer'   => 'Georgia\'s statute of limitations is 2 years for personal injury (O.C.G.A. § 9-3-33), with a 10-year statute of repose for product liability claims (O.C.G.A. § 51-1-11). South Carolina allows 3 years for personal injury (S.C. Code § 15-3-530). Consult an attorney promptly.',
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
