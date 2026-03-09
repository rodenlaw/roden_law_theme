<?php
/**
 * Seeder: 6 Commercial Vehicle Sub-Type Pages
 *
 * Creates 6 child posts under the car-accident-lawyers pillar, each covering
 * a specific type of commercial vehicle accident. Also updates the parent
 * commercial-vehicle-accident page content to link to each new page.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-commercial-vehicle-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: car-accident-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'car-accident-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'car-accident-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "car-accident-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'car-accidents', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Car Accidents', 'practice_category', array( 'slug' => 'car-accidents' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Delivery Vehicle Accident
       ============================================================ */
    array(
        'title'   => 'Delivery Vehicle Accident Lawyers',
        'slug'    => 'delivery-vehicle-accident',
        'excerpt' => 'Injured in a delivery vehicle crash in Georgia or South Carolina? Our attorneys hold delivery companies and their drivers accountable for accidents caused by tight schedules and reckless driving.',
        'content' => <<<'HTML'
<h2>Delivery Vehicle Accidents in Georgia &amp; South Carolina</h2>
<p>The explosive growth of e-commerce and on-demand delivery has put more delivery vehicles on the road than ever before. According to the <a href="https://www.fmcsa.dot.gov/safety/data-and-statistics/large-truck-and-bus-crash-facts" target="_blank" rel="noopener">Federal Motor Carrier Safety Administration (FMCSA)</a>, last-mile delivery vehicles are involved in a growing number of traffic crashes each year as companies like Amazon, FedEx, UPS, and food delivery platforms push drivers to meet aggressive delivery windows. The <a href="https://www.nhtsa.gov/road-safety/passenger-vehicles" target="_blank" rel="noopener">National Highway Traffic Safety Administration (NHTSA)</a> has identified the increase in delivery van traffic — particularly in residential neighborhoods and commercial districts — as an emerging safety concern.</p>
<p>At Roden Law, our delivery vehicle accident lawyers understand the unique legal dynamics of these cases. Delivery drivers are often pressured by quotas, route optimization algorithms, and narrow delivery windows that incentivize speeding, running stop signs, and making unsafe stops. When these pressures cause an accident, both the driver and the delivery company can be held accountable.</p>

<h2>Who Is Liable in a Delivery Vehicle Accident?</h2>
<p>Liability in delivery vehicle accidents depends on the driver's employment relationship with the delivery company:</p>
<ul>
<li><strong>Direct employees (UPS, FedEx Ground, USPS):</strong> The employer is vicariously liable under respondeat superior when the driver causes an accident within the scope of employment.</li>
<li><strong>Independent contractors (Amazon Flex, gig delivery):</strong> Companies may argue limited liability, but courts in Georgia and South Carolina examine the actual level of control the company exercises over the driver — including routes, schedules, uniforms, and vehicle requirements.</li>
<li><strong>Delivery Service Partners (Amazon DSPs):</strong> Amazon contracts with third-party delivery companies that hire their own drivers. Liability may extend to both the DSP and Amazon depending on the degree of operational control Amazon maintains.</li>
</ul>
<p>The <a href="https://www.osha.gov/driving-guidelines" target="_blank" rel="noopener">Occupational Safety and Health Administration (OSHA)</a> publishes guidelines for employer driving safety programs, and failures to implement adequate driver training and safety policies can establish negligent supervision claims against the delivery company.</p>

<h2>Common Causes of Delivery Vehicle Crashes</h2>
<p>Delivery drivers face unique hazards that contribute to accident risk:</p>
<ul>
<li>Double-parking or stopping in travel lanes to make deliveries</li>
<li>Backing up without adequate visibility in residential areas</li>
<li>Speeding and running stop signs to meet delivery quotas</li>
<li>Distracted driving from navigation apps and delivery management software</li>
<li>Fatigue from long shifts and excessive daily delivery counts</li>
<li>Operating oversized vehicles in neighborhoods not designed for commercial traffic</li>
</ul>
<p>FMCSA data indicates that delivery vehicles exceeding 10,001 pounds must comply with federal safety regulations including hours-of-service limits and vehicle maintenance standards. Violations of these regulations are strong evidence of negligence.</p>

<h2>Injuries in Delivery Vehicle Accidents</h2>
<p>Delivery vans and trucks are significantly larger and heavier than passenger vehicles. Crashes involving these vehicles frequently cause traumatic brain injuries, spinal cord injuries, multiple fractures, crush injuries, internal organ damage, and wrongful death. Even low-speed collisions — such as a delivery van backing into a pedestrian — can cause serious, life-altering injuries.</p>

<h2>Insurance Coverage in Delivery Vehicle Cases</h2>
<p>Delivery companies typically carry commercial auto insurance policies with limits far exceeding standard personal auto coverage. Major carriers like UPS and FedEx maintain multi-million dollar liability policies. Even smaller delivery operations and gig economy platforms are required to maintain commercial coverage. Our attorneys identify every available insurance policy — the driver's personal coverage, the company's commercial policy, umbrella coverage, and any third-party liability — to maximize your recovery.</p>

<h2>Why Choose Roden Law for Your Delivery Vehicle Case</h2>
<p>Our attorneys have handled complex delivery vehicle accident claims across Georgia and South Carolina. We investigate the driver's employment status, delivery route data, company safety policies, and vehicle maintenance records to build the strongest possible case. There is no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue Amazon if an Amazon delivery driver hit me?',
                'answer'   => 'Potentially, yes. While Amazon often uses Delivery Service Partners (DSPs) — third-party companies that hire their own drivers — courts examine the actual control Amazon exercises over the delivery process. If Amazon controls routes, delivery windows, and operational standards, it may share liability.',
            ),
            array(
                'question' => 'What if the delivery driver was an independent contractor?',
                'answer'   => 'Even if a company classifies a driver as an independent contractor, courts look at the actual working relationship. If the company controls routes, schedules, vehicle requirements, or uniforms, the driver may be deemed an employee for liability purposes.',
            ),
            array(
                'question' => 'Are delivery companies required to carry commercial insurance?',
                'answer'   => 'Yes. Companies operating delivery vehicles for business purposes must carry commercial auto insurance. Federal regulations require carriers operating vehicles over 10,001 pounds to maintain minimum coverage of $750,000 to $5 million depending on cargo.',
            ),
            array(
                'question' => 'What if a delivery vehicle hit me while I was walking in my neighborhood?',
                'answer'   => 'Pedestrians struck by delivery vehicles have strong claims. Delivery drivers have a heightened duty of care in residential areas. Both the driver and the delivery company can be held liable for your injuries.',
            ),
            array(
                'question' => 'How long do I have to file a delivery vehicle accident claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years from the date of the accident (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530). Contact an attorney promptly to preserve critical evidence.',
            ),
            array(
                'question' => 'What evidence is important in a delivery vehicle accident case?',
                'answer'   => 'Key evidence includes the driver\'s delivery route data, GPS and telematics records, the company\'s safety and training policies, the driver\'s employment records and driving history, and any dashcam or surveillance footage from the area.',
            ),
        ),
    ),

    /* ============================================================
       2. Company Car Accident
       ============================================================ */
    array(
        'title'   => 'Company Car Accident Lawyers',
        'slug'    => 'company-car-accident',
        'excerpt' => 'Injured in a company car crash in Georgia or South Carolina? Our attorneys pursue claims against negligent employees and their employers to secure full compensation.',
        'content' => <<<'HTML'
<h2>Company Car Accident Claims in Georgia &amp; South Carolina</h2>
<p>When an employee causes an accident while driving a company-owned or company-leased vehicle, the legal landscape becomes more complex than a standard car accident claim. Employers who provide vehicles to their employees assume responsibility for ensuring those vehicles are safely maintained and that drivers are properly qualified. According to the <a href="https://www.nhtsa.gov/equipment/fleet-safety" target="_blank" rel="noopener">National Highway Traffic Safety Administration (NHTSA)</a>, motor vehicle crashes are the leading cause of work-related deaths in the United States, and employer fleet safety programs are critical to reducing this toll.</p>
<p>At Roden Law, our company car accident lawyers help victims navigate the multiple layers of liability and insurance that apply when a business employee causes a crash. These cases often involve higher insurance coverage limits and additional legal theories that can significantly increase your recovery compared to a claim against an individual driver.</p>

<h2>Employer Liability Under Respondeat Superior</h2>
<p>Under the legal doctrine of respondeat superior — Latin for "let the master answer" — employers are vicariously liable for the negligent acts of their employees committed within the scope of employment. When an employee causes an accident while driving a company car for work purposes, the employer bears legal responsibility for the resulting injuries.</p>
<p>Georgia courts apply a broad interpretation of "scope of employment" that includes not only the primary work task but also incidental activities such as driving to meetings, running work errands, and traveling between job sites. South Carolina similarly holds employers liable when the employee's driving serves the employer's business interests, even if the employee deviates slightly from assigned duties.</p>

<h2>Direct Employer Negligence Claims</h2>
<p>Beyond vicarious liability, employers can be directly liable for their own negligence in managing company vehicles and drivers. The <a href="https://www.osha.gov/driving-guidelines" target="_blank" rel="noopener">Occupational Safety and Health Administration (OSHA)</a> recommends comprehensive fleet safety programs including driver screening, training, and monitoring. Direct negligence theories include:</p>
<ul>
<li><strong>Negligent hiring:</strong> Failing to check driving records before assigning company vehicles</li>
<li><strong>Negligent entrustment:</strong> Providing a vehicle to a driver known to be unfit — due to a history of accidents, DUI convictions, or suspended license</li>
<li><strong>Negligent supervision:</strong> Failing to monitor employee driving behavior, address complaints, or enforce safety policies</li>
<li><strong>Negligent maintenance:</strong> Failing to properly maintain company vehicles, leading to mechanical failures</li>
</ul>
<p>These direct negligence claims are important because they can result in liability even when the employee was technically outside the scope of employment at the time of the crash.</p>

<h2>Company Car vs. Personal Vehicle for Work</h2>
<p>Liability analysis depends on whether the employee was driving a company-owned vehicle or a personal vehicle for work purposes:</p>
<ul>
<li><strong>Company-owned vehicle:</strong> The employer's commercial auto insurance is the primary coverage. Respondeat superior applies broadly.</li>
<li><strong>Personal vehicle for work (reimbursed mileage):</strong> The employee's personal insurance may be primary, but the employer can still be vicariously liable if the employee was performing work duties.</li>
<li><strong>Company car for personal use:</strong> If the employer permits personal use of the company car, liability questions become more complex and depend on the specific circumstances of the crash.</li>
</ul>

<h2>Insurance Coverage in Company Car Cases</h2>
<p>Company car cases often involve substantially higher insurance coverage than personal vehicle accidents. Businesses typically carry commercial auto policies with limits of $1 million or more, plus commercial umbrella or excess liability policies that provide additional layers of coverage. NHTSA fleet safety guidelines recommend that employers carry adequate liability coverage to protect both the company and third parties injured in crashes involving company vehicles.</p>

<h2>Building Your Company Car Accident Case</h2>
<p>Our attorneys investigate every aspect of the employer's fleet management: driver hiring and screening practices, training programs, vehicle maintenance records, GPS and telematics data, the employee's driving history and disciplinary records, and the company's fleet safety policies. This thorough approach identifies all sources of liability and maximizes your compensation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue the employer if their employee hit me while driving a company car?',
                'answer'   => 'Yes. Under respondeat superior, employers are vicariously liable for accidents caused by employees driving company vehicles within the scope of employment. The employer\'s commercial insurance typically provides significantly higher coverage limits.',
            ),
            array(
                'question' => 'What if the employee was running a personal errand in the company car?',
                'answer'   => 'Liability depends on the circumstances. If the employer permits personal use of the company car, or if the errand was incidental to work duties (such as stopping for lunch during a work trip), the employer may still be liable. Georgia and South Carolina courts examine the specific facts.',
            ),
            array(
                'question' => 'Does the employer have to check driving records before giving an employee a company car?',
                'answer'   => 'While not always legally required, failure to screen driving records before assigning company vehicles can establish a negligent hiring or negligent entrustment claim if the employee has a poor driving history and causes an accident.',
            ),
            array(
                'question' => 'What insurance applies in a company car accident?',
                'answer'   => 'The employer\'s commercial auto insurance is typically primary when the employee is driving a company-owned vehicle. Businesses often carry $1 million or more in coverage plus umbrella policies. Both the driver\'s and employer\'s policies may apply.',
            ),
            array(
                'question' => 'How long do I have to file a company car accident claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years (O.C.G.A. § 9-3-33). In South Carolina, you have 3 years (S.C. Code § 15-3-530). However, evidence of employer negligence — such as training records and internal communications — should be preserved quickly.',
            ),
            array(
                'question' => 'What is negligent entrustment in a company car case?',
                'answer'   => 'Negligent entrustment occurs when an employer provides a company vehicle to a driver the employer knew or should have known was unfit — such as a driver with multiple DUI convictions, a suspended license, or a history of at-fault accidents.',
            ),
        ),
    ),

    /* ============================================================
       3. Service & Utility Vehicle Crash
       ============================================================ */
    array(
        'title'   => 'Service &amp; Utility Vehicle Crash Lawyers',
        'slug'    => 'service-vehicle-accident',
        'excerpt' => 'Hurt in a crash with a service or utility vehicle in Georgia or South Carolina? Our attorneys hold service companies accountable for negligent driving and unsafe vehicle operation.',
        'content' => <<<'HTML'
<h2>Service &amp; Utility Vehicle Accidents in Georgia &amp; South Carolina</h2>
<p>Service and utility vehicles — including plumber vans, electrician trucks, HVAC vehicles, landscaping trailers, cable and internet service trucks, and utility company vehicles — are a constant presence on roads throughout Georgia and South Carolina. These vehicles often carry heavy equipment, tow trailers, and make frequent stops in residential neighborhoods and on busy highways. According to the <a href="https://www.osha.gov/transportation/motor-vehicle-safety" target="_blank" rel="noopener">Occupational Safety and Health Administration (OSHA)</a>, motor vehicle crashes are the leading cause of work-related fatalities, and service industry workers who spend significant time driving are at elevated risk.</p>
<p>At Roden Law, our service vehicle accident lawyers understand the unique hazards these vehicles present and the multiple liability theories available to injured victims. When a service company's driver causes an accident, we pursue compensation from every responsible party — including the driver, the service company, and any third-party vehicle or equipment owners.</p>

<h2>Common Hazards of Service &amp; Utility Vehicles</h2>
<p>Service vehicles create specific road hazards that contribute to accidents:</p>
<ul>
<li><strong>Improperly secured equipment:</strong> Tools, materials, and equipment that shift or fall from service vehicles can strike other motorists or create road debris</li>
<li><strong>Trailer towing hazards:</strong> Landscaping trailers, equipment trailers, and utility trailers that are improperly hitched, overloaded, or have faulty lighting</li>
<li><strong>Sudden stops and lane blocking:</strong> Service vehicles frequently stop abruptly to locate addresses or park in travel lanes</li>
<li><strong>Large blind spots:</strong> Cargo vans and box trucks used by service companies have significant blind spots that increase crash risk</li>
<li><strong>Distracted driving:</strong> Service workers using GPS, dispatch apps, and work phones while driving between job sites</li>
</ul>
<p>The <a href="https://www.fmcsa.dot.gov/safety/cargo-securement/drivers-cargo-securement" target="_blank" rel="noopener">FMCSA's cargo securement rules</a> and the <a href="https://www.transportation.gov/" target="_blank" rel="noopener">Department of Transportation (DOT)</a> regulations govern how commercial vehicles must secure loads. Violations of these rules are evidence of negligence when unsecured cargo causes an accident.</p>

<h2>Liability in Service Vehicle Accidents</h2>
<p>Service vehicle accident cases involve multiple potential defendants:</p>
<ul>
<li><strong>The driver:</strong> Personally liable for negligent driving, distraction, or traffic violations</li>
<li><strong>The service company:</strong> Vicariously liable under respondeat superior for employees, and potentially liable for independent contractors depending on control exercised</li>
<li><strong>Vehicle or equipment owners:</strong> If the service company leases vehicles or equipment, the owner may be liable for maintenance failures</li>
<li><strong>Utility companies:</strong> Power companies, water utilities, and telecom providers are liable for accidents caused by their vehicles and employees</li>
</ul>
<p>OSHA's motor vehicle safety guidelines establish best practices for employer fleet management programs. Employers who fail to implement adequate driver training, vehicle maintenance schedules, and safety policies face both direct and vicarious liability claims.</p>

<h2>Utility Company Vehicle Accidents</h2>
<p>Utility company vehicles — including power line trucks, water and sewer trucks, and telecom vehicles — present particular hazards because they frequently operate on roadsides and in work zones. When utility workers fail to properly set up work zone warnings in accordance with the <a href="https://mutcd.fhwa.dot.gov/" target="_blank" rel="noopener">Manual on Uniform Traffic Control Devices (MUTCD)</a>, motorists may collide with the utility vehicle or work crew. Utility companies operating government-contracted services may also raise sovereign immunity issues requiring strict compliance with notice requirements.</p>

<h2>Trailer and Equipment Accidents</h2>
<p>Many service vehicles tow trailers carrying mowers, tools, construction materials, and other heavy equipment. When trailers detach due to improper hitching, when loads shift and fall onto the roadway, or when trailer lighting fails to alert following motorists, the resulting accidents can be catastrophic. Our attorneys work with accident reconstruction experts to determine whether the trailer equipment met DOT safety standards and whether the service company followed proper loading and securement procedures.</p>

<h2>Pursuing Your Service Vehicle Accident Claim</h2>
<p>Our investigation covers the service company's safety policies and training programs, the driver's qualifications and driving record, vehicle and trailer maintenance and inspection records, GPS and dispatch data, load securement practices, and compliance with applicable OSHA and DOT regulations. We build a comprehensive case to hold all responsible parties accountable.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue the service company if their worker hit me?',
                'answer'   => 'Yes. Under respondeat superior, service companies are liable for accidents caused by their employees while performing work duties. Even independent contractor relationships may create liability if the company controls how the work is performed.',
            ),
            array(
                'question' => 'What if equipment fell off a service vehicle and caused my accident?',
                'answer'   => 'Service companies are responsible for properly securing all tools, materials, and equipment on their vehicles. FMCSA cargo securement rules and DOT regulations establish loading standards. Failure to comply is evidence of negligence.',
            ),
            array(
                'question' => 'Are utility companies liable for accidents caused by their vehicles?',
                'answer'   => 'Yes. Utility companies are liable for the negligent acts of their employees, including improper work zone setup, failure to maintain vehicle lighting, and dangerous parking. Claims against government-contracted utilities may have special notice requirements.',
            ),
            array(
                'question' => 'What if a trailer detached from a service vehicle and hit my car?',
                'answer'   => 'Trailer detachment accidents may involve liability for the driver (improper hitching), the service company (negligent maintenance), and potentially the trailer manufacturer (defective hitch mechanism). Our attorneys investigate all potential responsible parties.',
            ),
            array(
                'question' => 'How long do I have to file a service vehicle accident claim?',
                'answer'   => 'In Georgia, you have 2 years from the date of the accident (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530). Claims involving government utility vehicles may have shorter notice deadlines.',
            ),
            array(
                'question' => 'What insurance coverage applies in service vehicle accidents?',
                'answer'   => 'Service companies typically carry commercial auto insurance with higher limits than personal policies. Utility companies often carry multi-million dollar policies. Our attorneys identify all available coverage including commercial, umbrella, and third-party policies.',
            ),
        ),
    ),

    /* ============================================================
       4. Government Vehicle Accident
       ============================================================ */
    array(
        'title'   => 'Government Vehicle Accident Lawyers',
        'slug'    => 'government-vehicle-accident',
        'excerpt' => 'Injured in an accident caused by a government vehicle in Georgia or South Carolina? Our lawyers navigate sovereign immunity rules and strict notice deadlines to pursue your claim.',
        'content' => <<<'HTML'
<h2>Government Vehicle Accident Claims in Georgia &amp; South Carolina</h2>
<p>Accidents involving government vehicles — including police cars, fire trucks, public works vehicles, military vehicles, postal trucks, and other federal, state, and local government fleet vehicles — present legal challenges that differ significantly from standard car accident cases. Government entities enjoy sovereign immunity protections that limit when and how they can be sued. However, both Georgia and South Carolina have enacted tort claims acts that waive immunity in many circumstances, allowing injured victims to pursue compensation.</p>
<p>At Roden Law, our government vehicle accident lawyers have experience navigating the complex procedural requirements of claims against federal, state, and local government entities. These cases demand strict compliance with notice deadlines and filing procedures — missing even one requirement can permanently bar your claim.</p>

<h2>Georgia Government Vehicle Accident Claims</h2>
<p>Georgia's sovereign immunity framework creates specific requirements for claims against government entities:</p>
<ul>
<li><strong>State agencies:</strong> The Georgia Tort Claims Act (<a href="https://law.justia.com/codes/georgia/title-50/chapter-21/" target="_blank" rel="noopener">O.C.G.A. § 50-21-20 et seq.</a>) waives sovereign immunity for state employees acting within the scope of employment, with certain exceptions. Claims must be filed with the Georgia Department of Administrative Services (DOAS) within 12 months of the incident.</li>
<li><strong>County and municipal governments:</strong> Georgia's ante litem notice requirement (<a href="https://law.justia.com/codes/georgia/title-36/chapter-33/" target="_blank" rel="noopener">O.C.G.A. § 36-33-5</a>) requires written notice to the governing authority within 6 months of the incident before filing a lawsuit. This notice must describe the time, place, and extent of the injury.</li>
<li><strong>Emergency vehicles:</strong> Georgia law provides limited immunity for emergency vehicle operators (O.C.G.A. § 40-6-6), but this immunity does not apply when the operator acts with reckless disregard for the safety of others.</li>
</ul>

<h2>South Carolina Government Vehicle Accident Claims</h2>
<p>South Carolina's <a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">South Carolina Tort Claims Act (S.C. Code § 15-78-10 et seq.)</a> governs claims against state and local government entities:</p>
<ul>
<li><strong>Waiver of immunity:</strong> The Act waives sovereign immunity for government employee negligence occurring within the scope of official duty, including vehicle operations.</li>
<li><strong>Damage caps:</strong> Recovery against a single government entity is capped at $300,000 per claimant and $600,000 per occurrence. For multiple entities, the total cap is $1.2 million per occurrence.</li>
<li><strong>Filing requirements:</strong> Claims must be filed with the appropriate governmental entity, and the entity has 180 days to investigate before a lawsuit can be filed.</li>
<li><strong>Exceptions:</strong> Certain activities — including discretionary functions, legislative acts, and judicial proceedings — remain immune from suit.</li>
</ul>

<h2>Federal Government Vehicle Accidents</h2>
<p>Accidents involving federal government vehicles — including USPS mail trucks, military vehicles, and federal agency fleet vehicles — are governed by the <a href="https://www.justice.gov/civil/federal-tort-claims-act" target="_blank" rel="noopener">Federal Tort Claims Act (FTCA), 28 U.S.C. § 1346(b)</a>. The FTCA requires filing an administrative claim with the responsible federal agency within 2 years of the accident. The agency has 6 months to respond before a lawsuit can be filed in federal court. Punitive damages and jury trials are not available under the FTCA.</p>

<h2>Emergency Vehicle Accidents</h2>
<p>Both Georgia and South Carolina provide limited immunity for emergency vehicle operators responding to emergencies. However, this immunity is not absolute. When police officers, firefighters, or emergency medical technicians operate their vehicles with reckless disregard for public safety — such as running red lights at excessive speed without sirens, or engaging in high-speed pursuits through residential areas — they and their government employers may be held liable for resulting injuries.</p>

<h2>Critical Deadlines in Government Vehicle Cases</h2>
<p>Government vehicle accident claims have the strictest filing deadlines of any personal injury case. Missing the ante litem notice deadline in Georgia (6 months for municipalities) or the administrative filing requirements under the FTCA (2 years) can permanently bar your claim — even if the standard personal injury statute of limitations has not expired. Contact an attorney immediately after any accident involving a government vehicle.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue the government if a government vehicle hit me?',
                'answer'   => 'Yes, in most cases. Georgia\'s Tort Claims Act and South Carolina\'s Tort Claims Act waive sovereign immunity for negligent vehicle operation by government employees. Federal vehicle claims proceed under the Federal Tort Claims Act. Strict notice and filing requirements apply.',
            ),
            array(
                'question' => 'What is the ante litem notice requirement in Georgia?',
                'answer'   => 'Under O.C.G.A. § 36-33-5, you must provide written notice to the county or municipal governing authority within 6 months of the accident before you can file a lawsuit. The notice must describe the time, place, and extent of your injuries.',
            ),
            array(
                'question' => 'Are there damage caps in government vehicle accident cases?',
                'answer'   => 'South Carolina caps recovery at $300,000 per claimant and $600,000 per occurrence against a single government entity. Federal claims under the FTCA do not have a statutory cap but do not allow punitive damages or jury trials. Georgia\'s Tort Claims Act has specific caps depending on the entity.',
            ),
            array(
                'question' => 'What if a police car caused my accident during a high-speed chase?',
                'answer'   => 'Emergency vehicle immunity is not absolute. When officers drive with reckless disregard for public safety — such as pursuing suspects at excessive speeds through residential areas without adequate warning — the government entity may be liable.',
            ),
            array(
                'question' => 'How do I file a claim against a federal vehicle like a USPS truck?',
                'answer'   => 'You must file an administrative claim with the responsible federal agency (such as USPS) within 2 years of the accident under the Federal Tort Claims Act. The agency has 6 months to respond before you can file suit in federal court.',
            ),
            array(
                'question' => 'How long do I have to file a government vehicle accident claim?',
                'answer'   => 'Deadlines vary by entity: Georgia municipal claims require ante litem notice within 6 months; state claims must be filed within 12 months with DOAS; federal claims must be filed within 2 years under the FTCA. The standard personal injury statute of limitations also applies.',
            ),
            array(
                'question' => 'What if a military vehicle caused my accident?',
                'answer'   => 'Claims against the U.S. military proceed under the Federal Tort Claims Act. You must file an administrative claim with the appropriate military branch within 2 years. An experienced attorney can guide you through the federal claims process.',
            ),
        ),
    ),

    /* ============================================================
       5. Construction Vehicle Accident
       ============================================================ */
    array(
        'title'   => 'Construction Vehicle Accident Lawyers',
        'slug'    => 'construction-vehicle-accident',
        'excerpt' => 'Hurt in a construction vehicle crash on Georgia or South Carolina roads? Our lawyers hold construction companies accountable for unsafe equipment operation and work zone negligence.',
        'content' => <<<'HTML'
<h2>Construction Vehicle Accidents on Georgia &amp; South Carolina Roads</h2>
<p>Construction vehicles — including dump trucks, cement mixers, bulldozers, excavators, cranes, and other heavy equipment — pose serious dangers when operated on or near public roads. According to the <a href="https://www.osha.gov/construction" target="_blank" rel="noopener">Occupational Safety and Health Administration (OSHA)</a>, the construction industry is one of the most hazardous in the United States, and construction vehicle accidents are a leading cause of both worker and bystander injuries. The <a href="https://www.fmcsa.dot.gov/safety/data-and-statistics/large-truck-and-bus-crash-facts" target="_blank" rel="noopener">FMCSA</a> reports that large trucks, including construction vehicles, are involved in thousands of fatal crashes annually.</p>
<p>At Roden Law, our construction vehicle accident lawyers handle claims arising from construction vehicle crashes on public roads, in work zones, and at construction sites. These cases involve complex regulatory frameworks, multiple responsible parties, and significantly higher insurance coverage than standard auto accidents.</p>

<h2>Types of Construction Vehicle Accidents</h2>
<p>Our attorneys handle the full range of construction vehicle crashes:</p>
<ul>
<li><strong>Dump truck accidents:</strong> Overloaded or improperly loaded dump trucks that lose cargo, tip over, or jackknife on highways</li>
<li><strong>Cement mixer crashes:</strong> Top-heavy vehicles prone to rollover, especially on curves and highway ramps</li>
<li><strong>Heavy equipment on roadways:</strong> Bulldozers, excavators, and graders moving slowly on public roads or crossing intersections</li>
<li><strong>Crane accidents:</strong> Mobile cranes that strike vehicles, power lines, or structures during transport or operation</li>
<li><strong>Work zone crashes:</strong> Vehicles striking construction equipment or workers in inadequately marked work zones</li>
</ul>

<h2>Work Zone Safety Regulations</h2>
<p>Construction work zones on public roads must comply with the <a href="https://mutcd.fhwa.dot.gov/htm/2009r1r2/part6/part6_toc.htm" target="_blank" rel="noopener">Manual on Uniform Traffic Control Devices (MUTCD), Part 6</a>, which establishes detailed standards for work zone traffic control. The MUTCD requires advance warning signs, properly channelized traffic, flaggers or automated flagger assistance devices, barrier protection for workers, and adequate lighting for nighttime operations. When construction companies fail to implement proper work zone traffic control, they are liable for accidents that result.</p>
<p>Georgia DOT and <a href="https://www.scdot.org/" target="_blank" rel="noopener">SCDOT</a> each maintain supplemental work zone safety standards that construction contractors must follow on state road projects. Violations of these standards are strong evidence of negligence.</p>

<h2>Liability in Construction Vehicle Accidents</h2>
<p>Construction vehicle accident cases frequently involve multiple liable parties:</p>
<ul>
<li><strong>The driver/operator:</strong> Personally liable for negligent vehicle operation</li>
<li><strong>The construction company:</strong> Vicariously liable for employee conduct and directly liable for negligent hiring, training, and supervision</li>
<li><strong>The general contractor:</strong> May be liable for work zone safety even if the vehicle belonged to a subcontractor</li>
<li><strong>Equipment owners and lessors:</strong> Liable for known maintenance defects or failure to properly inspect equipment</li>
<li><strong>Government entities:</strong> GDOT or SCDOT may be liable for requiring work zone configurations that created unsafe conditions</li>
</ul>

<h2>OSHA and FMCSA Regulatory Violations</h2>
<p>OSHA construction standards (29 CFR 1926) require employers to train operators, maintain equipment, and implement traffic control plans for work adjacent to public roads. FMCSA regulations require commercial driver's licenses (CDLs) for operators of vehicles over 26,001 pounds, along with hours-of-service compliance and pre-trip inspections. Our attorneys obtain OSHA inspection records, FMCSA compliance data, and company safety records to prove regulatory violations that caused or contributed to the accident.</p>

<h2>Compensation in Construction Vehicle Cases</h2>
<p>Construction vehicle accidents frequently cause catastrophic injuries due to the size and weight of the vehicles involved. Victims may recover compensation for extensive medical treatment and surgeries, permanent disability and loss of earning capacity, pain and suffering, loss of enjoyment of life, and wrongful death damages. Construction companies typically carry large commercial insurance policies, and multiple policies from different liable parties may be available to cover your losses.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Who is liable if a construction dump truck hit my car?',
                'answer'   => 'Multiple parties may be liable: the driver, the construction company that employed the driver, the general contractor overseeing the project, and potentially the vehicle or equipment owner. Our attorneys identify all responsible parties to maximize your recovery.',
            ),
            array(
                'question' => 'What if I was hit in a construction work zone?',
                'answer'   => 'Construction companies must comply with MUTCD work zone traffic control standards, including proper signage, flaggers, and barriers. If inadequate work zone setup contributed to your accident, the construction company and potentially the government entity overseeing the project may be liable.',
            ),
            array(
                'question' => 'Are construction companies required to carry commercial insurance?',
                'answer'   => 'Yes. Construction companies operating commercial vehicles must carry commercial auto insurance. Federal regulations require minimum coverage of $750,000 to $5 million for large vehicles. Construction companies typically carry substantial commercial policies plus umbrella coverage.',
            ),
            array(
                'question' => 'What OSHA regulations apply to construction vehicles on public roads?',
                'answer'   => 'OSHA construction standards (29 CFR 1926) require operator training, vehicle maintenance, traffic control plans, and safety procedures for work near public roads. Violations of these standards are evidence of negligence.',
            ),
            array(
                'question' => 'How long do I have to file a construction vehicle accident claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years (O.C.G.A. § 9-3-33). In South Carolina, you have 3 years (S.C. Code § 15-3-530). If a government entity is involved, shorter notice deadlines may apply.',
            ),
            array(
                'question' => 'What if debris from a construction vehicle caused my accident?',
                'answer'   => 'Construction companies are responsible for properly securing loads on their vehicles. FMCSA cargo securement rules and DOT regulations establish loading standards. When debris falls from a construction vehicle and causes an accident, the company is liable for failing to secure its load.',
            ),
        ),
    ),

    /* ============================================================
       6. Bus Accident
       ============================================================ */
    array(
        'title'   => 'Bus Accident Lawyers',
        'slug'    => 'bus-accident',
        'excerpt' => 'Injured in a bus accident in Georgia or South Carolina? Our lawyers handle claims involving private buses, charter buses, shuttle services, and hotel courtesy vehicles.',
        'content' => <<<'HTML'
<h2>Bus Accident Claims in Georgia &amp; South Carolina</h2>
<p>Bus accidents — involving private shuttle buses, charter buses, tour buses, hotel courtesy vehicles, airport shuttles, and church buses — can cause devastating injuries due to the size and passenger capacity of these vehicles. According to the <a href="https://www.fmcsa.dot.gov/safety/data-and-statistics/large-truck-and-bus-crash-facts" target="_blank" rel="noopener">Federal Motor Carrier Safety Administration (FMCSA)</a>, thousands of bus crashes occur annually across the United States, resulting in hundreds of fatalities and thousands of injuries. The <a href="https://www.nhtsa.gov/road-safety/bus-safety" target="_blank" rel="noopener">National Highway Traffic Safety Administration (NHTSA)</a> has identified the lack of seat belts on many bus types as a significant factor in passenger injury severity.</p>
<p>At Roden Law, our bus accident lawyers represent passengers, pedestrians, cyclists, and other motorists injured in crashes involving commercial and private bus operations throughout Georgia and South Carolina. These cases involve heightened standards of care, complex regulatory requirements, and often multiple responsible parties.</p>

<h2>Common Carrier Duty of Care</h2>
<p>Under Georgia and South Carolina law, commercial bus operators are classified as "common carriers" — meaning they owe the highest duty of care to their passengers. Unlike ordinary drivers who must exercise reasonable care, common carriers must exercise extraordinary diligence for the safety of their passengers. This heightened standard means that bus companies are held to a stricter standard of liability when passengers are injured.</p>
<p>Georgia law (O.C.G.A. § 46-9-132) requires common carriers to exercise "extraordinary diligence" to protect the lives and persons of their passengers. South Carolina similarly imposes a heightened duty of care on common carriers, requiring the highest degree of care consistent with the practical operation of the vehicle.</p>

<h2>Types of Bus Accidents We Handle</h2>
<ul>
<li><strong>Charter and tour bus crashes:</strong> Long-distance tour buses and charter services operating on highways and interstates</li>
<li><strong>Hotel and resort shuttle accidents:</strong> Courtesy shuttles operating between hotels, airports, and attractions</li>
<li><strong>Airport shuttle crashes:</strong> Private airport shuttle and car services transporting passengers</li>
<li><strong>Church and organization bus accidents:</strong> Buses operated by religious organizations, schools, and community groups</li>
<li><strong>Party bus and limousine crashes:</strong> Vehicles often operating with inadequate safety equipment and undertrained drivers</li>
<li><strong>Employee shuttle accidents:</strong> Buses transporting workers to and from job sites</li>
</ul>

<h2>FMCSA Regulations for Bus Operations</h2>
<p>Commercial bus operations carrying passengers for hire must comply with <a href="https://www.fmcsa.dot.gov/passenger-carrier-safety" target="_blank" rel="noopener">FMCSA passenger carrier safety regulations</a>, including:</p>
<ul>
<li>Commercial Driver's License (CDL) with passenger endorsement for the driver</li>
<li>Hours-of-service limits to prevent fatigued driving</li>
<li>Regular vehicle inspections and maintenance records</li>
<li>Drug and alcohol testing programs for drivers</li>
<li>Minimum insurance requirements of $5 million for buses carrying 16+ passengers</li>
</ul>
<p>The <a href="https://www.transit.dot.gov/safety" target="_blank" rel="noopener">Federal Transit Administration (FTA)</a> provides additional safety oversight for transit bus operations. FMCSA's Safety Measurement System (SMS) tracks bus company safety records, and poor safety scores can indicate a pattern of regulatory violations.</p>

<h2>Bus Passenger Injuries</h2>
<p>Bus passengers face unique injury risks because most buses do not have seat belts for passengers, seats may not have adequate head restraints, standing passengers have no restraint protection, and the large size of buses can result in rollover or multi-vehicle crashes. Common bus accident injuries include traumatic brain injuries from striking seats or interior surfaces, spinal cord injuries, broken bones from being thrown within the bus, and severe lacerations from broken glass.</p>

<h2>Liability in Bus Accidents</h2>
<p>Bus accident cases may involve multiple liable parties including the bus driver, the bus company or charter service, the vehicle maintenance provider, other motorists who contributed to the crash, the bus manufacturer (if a defect contributed to the accident), and government entities responsible for road conditions. The common carrier standard of care strengthens passenger claims and makes it easier to establish liability compared to standard car accident cases.</p>

<h2>Pursuing Maximum Compensation</h2>
<p>Our attorneys investigate every bus accident case by obtaining the bus company's FMCSA safety records, reviewing the driver's CDL status and driving history, examining vehicle maintenance and inspection logs, analyzing hours-of-service records for fatigue violations, and consulting with transportation safety experts. Bus companies are required to carry substantial insurance — $5 million minimum for larger passenger carriers — providing greater recovery potential for injured victims.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the common carrier duty of care in bus accident cases?',
                'answer'   => 'Commercial bus operators are classified as common carriers under Georgia and South Carolina law, meaning they owe passengers the highest duty of care — extraordinary diligence for passenger safety. This is a stricter standard than the reasonable care required of ordinary drivers.',
            ),
            array(
                'question' => 'How much insurance do bus companies carry?',
                'answer'   => 'FMCSA requires commercial bus operators carrying 16 or more passengers to maintain minimum insurance of $5 million. Smaller operators must carry at least $1.5 million. Many bus companies carry additional umbrella coverage.',
            ),
            array(
                'question' => 'Can I sue a hotel for an accident in their shuttle bus?',
                'answer'   => 'Yes. Hotels that operate courtesy shuttles are responsible for the safe operation of those vehicles. If the shuttle driver was negligent or the vehicle was poorly maintained, the hotel or resort may be liable for your injuries.',
            ),
            array(
                'question' => 'What if I was a passenger on the bus that crashed?',
                'answer'   => 'As a bus passenger, you benefit from the common carrier heightened duty of care. Bus companies must exercise extraordinary diligence for passenger safety. You can pursue a claim against the bus company, the driver, and any other parties whose negligence contributed to the crash.',
            ),
            array(
                'question' => 'Are charter bus companies regulated by the federal government?',
                'answer'   => 'Yes. Charter bus companies operating across state lines or for hire must register with FMCSA, comply with passenger carrier safety regulations, maintain CDL-qualified drivers, follow hours-of-service rules, and carry minimum insurance of $5 million for buses with 16+ passengers.',
            ),
            array(
                'question' => 'How long do I have to file a bus accident claim?',
                'answer'   => 'In Georgia, the statute of limitations is 2 years (O.C.G.A. § 9-3-33). In South Carolina, you have 3 years (S.C. Code § 15-3-530). If the bus was operated by a government entity, shorter notice deadlines may apply.',
            ),
            array(
                'question' => 'What if the bus accident was caused by a fatigued driver?',
                'answer'   => 'FMCSA hours-of-service regulations limit how long commercial bus drivers can operate without rest. If the driver exceeded these limits, it is strong evidence of negligence by both the driver and the bus company that allowed or required the violations.',
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
    update_post_meta( $post_id, '_roden_parent_subtype', 'commercial-vehicle-accident' );

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

/* ------------------------------------------------------------------
   UPDATE COMMERCIAL-VEHICLE-ACCIDENT PAGE CONTENT
   Add links to each new sub-type in the bold list items
   ------------------------------------------------------------------ */

WP_CLI::log( '' );
WP_CLI::log( 'Updating commercial-vehicle-accident page content with links...' );

$commercial_page = get_posts( array(
    'post_type'   => $pillar_type,
    'name'        => 'commercial-vehicle-accident',
    'post_parent' => $pillar_id,
    'post_status' => array( 'publish', 'draft', 'pending', 'private' ),
    'numberposts' => 1,
) );

if ( empty( $commercial_page ) ) {
    WP_CLI::warning( 'Could not find commercial-vehicle-accident page to update.' );
} else {
    $page    = $commercial_page[0];
    $content = $page->post_content;

    // Map bold text to the new sub-type URLs.
    $link_map = array(
        '<strong>Delivery vehicle accidents:</strong>'      => '<strong><a href="/car-accident-lawyers/delivery-vehicle-accident/">Delivery vehicle accidents</a>:</strong>',
        '<strong>Company car accidents:</strong>'            => '<strong><a href="/car-accident-lawyers/company-car-accident/">Company car accidents</a>:</strong>',
        '<strong>Service and utility vehicle crashes:</strong>' => '<strong><a href="/car-accident-lawyers/service-vehicle-accident/">Service and utility vehicle crashes</a>:</strong>',
        '<strong>Government vehicle accidents:</strong>'     => '<strong><a href="/car-accident-lawyers/government-vehicle-accident/">Government vehicle accidents</a>:</strong>',
        '<strong>Construction vehicle accidents:</strong>'   => '<strong><a href="/car-accident-lawyers/construction-vehicle-accident/">Construction vehicle accidents</a>:</strong>',
        '<strong>Bus accidents:</strong>'                    => '<strong><a href="/car-accident-lawyers/bus-accident/">Bus accidents</a>:</strong>',
    );

    $updated_content = $content;
    $links_added     = 0;

    foreach ( $link_map as $old => $new ) {
        if ( strpos( $updated_content, $old ) !== false && strpos( $updated_content, $new ) === false ) {
            $updated_content = str_replace( $old, $new, $updated_content );
            $links_added++;
        }
    }

    if ( $links_added > 0 ) {
        wp_update_post( array(
            'ID'           => $page->ID,
            'post_content' => $updated_content,
        ) );
        WP_CLI::success( "Updated commercial-vehicle-accident page (ID {$page->ID}) — added {$links_added} links." );
    } else {
        WP_CLI::log( '  No changes needed — links already present or bold text not found.' );
    }
}

WP_CLI::log( '' );
WP_CLI::log( 'Run: wp rewrite flush' );
