<?php
/**
 * Seeder: 6 ATV & Side-by-Side Accident Sub-Type Pages
 *
 * Creates 6 child posts under the atv-side-by-side-accident-lawyers pillar,
 * each covering a specific type of ATV or UTV accident.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-atv-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: atv-side-by-side-accident-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'atv-side-by-side-accident-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'atv-side-by-side-accident-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "atv-side-by-side-accident-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'atv-accidents', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'ATV & Side-by-Side Accidents', 'practice_category', array( 'slug' => 'atv-accidents' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. ATV Rollover Accident
       ============================================================ */
    array(
        'title'   => 'ATV Rollover Accident Lawyers',
        'slug'    => 'atv-rollover-accident',
        'excerpt' => 'Injured in an ATV rollover accident in Georgia or South Carolina? Our attorneys pursue maximum compensation for victims of ATV rollovers caused by defective design, unsafe terrain, and operator negligence.',
        'content' => <<<'HTML'
<h2>ATV Rollover Accidents in Georgia &amp; South Carolina</h2>
<p>ATV rollovers are among the most catastrophic off-road vehicle accidents, frequently resulting in crush injuries, spinal cord damage, traumatic brain injuries, and death. All-terrain vehicles have a high center of gravity relative to their narrow wheelbase, making them inherently prone to tipping and rolling over — particularly on uneven terrain, slopes, and during sharp turns. According to the <a href="https://www.cpsc.gov/Safety-Education/Safety-Guides/Sports-Fitness-and-Recreation/ATVs" target="_blank" rel="noopener">Consumer Product Safety Commission (CPSC)</a>, ATV-related deaths average approximately 700 per year nationwide, with rollovers accounting for a significant portion of fatalities.</p>
<p>At Roden Law, our ATV accident attorneys represent victims of rollover crashes throughout Georgia and South Carolina. We investigate whether the rollover was caused by a vehicle design defect, property owner negligence, inadequate safety features, or operator inexperience — and we pursue every available source of compensation.</p>

<h2>What Causes ATV Rollovers</h2>
<p>ATV rollovers can result from multiple factors, often occurring in combination. The most common causes include:</p>
<ul>
<li><strong>Defective vehicle design:</strong> ATVs with excessively high centers of gravity, inadequate stability margins, or suspension systems that do not properly absorb terrain variations</li>
<li><strong>Steep or uneven terrain:</strong> Slopes exceeding the ATV's grade capability, hidden ruts, and sudden elevation changes</li>
<li><strong>Excessive speed on turns:</strong> The physics of a narrow-wheelbase vehicle create high rollover risk during aggressive cornering</li>
<li><strong>Carrying passengers on single-rider ATVs:</strong> Adding a passenger raises the center of gravity and alters handling characteristics (see also <a href="/atv-side-by-side-accident-lawyers/child-atv-injury/">child ATV injuries</a>)</li>
<li><strong>Towing loads beyond rated capacity:</strong> Trailer loads that exceed the ATV's towing rating create instability</li>
<li><strong>Lack of rollover protection:</strong> Unlike <a href="/atv-side-by-side-accident-lawyers/side-by-side-utv-accident/">side-by-side UTVs</a>, most ATVs have no roll cage, leaving riders completely exposed during a rollover</li>
</ul>

<h2>Georgia &amp; South Carolina ATV Laws</h2>
<p>Georgia regulates ATV operation under <a href="https://law.justia.com/codes/georgia/title-40/chapter-7/article-5/" target="_blank" rel="noopener">O.C.G.A. § 40-7-120 et seq.</a>, which establishes requirements for ATV use on public and private land, age restrictions for operators, and safety equipment mandates. Georgia law prohibits operating an ATV on public roads (with limited exceptions for agricultural and crossing purposes) and requires riders under 16 to complete an approved safety course.</p>
<p>South Carolina regulates ATV use under <a href="https://www.scstatehouse.gov/code/t56c015.php" target="_blank" rel="noopener">S.C. Code § 56-15-10 et seq.</a> and local ordinances. South Carolina law restricts ATV operation on public roads and requires age-appropriate supervision for minors. Both states allow injured parties to pursue negligence claims against property owners who maintain unsafe ATV riding areas, manufacturers who produce defectively designed vehicles, and operators whose reckless driving causes injuries to others.</p>

<h2>Product Liability in ATV Rollover Cases</h2>
<p>Many ATV rollovers are caused — at least in part — by defective vehicle design. Manufacturers have long been criticized for producing ATVs with stability margins that are too narrow, failing to incorporate rollover protection structures (ROPS), and marketing high-powered machines to inexperienced riders. Under Georgia's product liability statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-3/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a>) and South Carolina's strict liability framework (<a href="https://www.scstatehouse.gov/code/t15c073.php" target="_blank" rel="noopener">S.C. Code § 15-73-10 et seq.</a>), manufacturers can be held strictly liable when a design defect makes the ATV unreasonably dangerous. Our attorneys work with mechanical engineers and <a href="/product-liability-lawyers/">product liability experts</a> to analyze vehicle dynamics and determine whether design deficiencies contributed to the rollover.</p>

<h2>Damages in ATV Rollover Cases</h2>
<p>ATV rollover victims often suffer catastrophic injuries requiring extensive medical treatment. Recoverable damages include emergency medical care and hospitalization, spinal surgery and traumatic brain injury treatment, long-term rehabilitation and physical therapy, lost wages and diminished earning capacity, pain and suffering, permanent disability and disfigurement, and in fatal rollover cases, <a href="/wrongful-death-lawyers/">wrongful death damages</a> for surviving family members. Georgia's statute of limitations is 2 years (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>), and South Carolina allows 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>).</p>

<h2>Why Choose Roden Law for ATV Rollover Claims</h2>
<p>ATV rollover cases often involve complex technical analysis of vehicle dynamics, terrain conditions, and manufacturing standards. Our firm has the resources to retain engineering experts, accident reconstruction specialists, and biomechanical consultants who can establish exactly how the rollover occurred and why. We handle all ATV accident cases on a contingency fee basis — no fees unless we recover compensation for you.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Why are ATVs so prone to rollovers?',
                'answer'   => 'ATVs have a high center of gravity relative to their narrow wheelbase, making them inherently unstable — especially on slopes, during turns, and when carrying passengers or heavy loads. Unlike side-by-side UTVs, most ATVs also lack roll cages to protect riders during a rollover.',
            ),
            array(
                'question' => 'Can I sue the ATV manufacturer if the vehicle rolled over due to a design defect?',
                'answer'   => 'Yes. Under Georgia law (O.C.G.A. § 51-1-11) and South Carolina law (S.C. Code § 15-73-10), manufacturers are strictly liable for design defects that make their products unreasonably dangerous. An ATV with inadequate stability margins may be considered defectively designed.',
            ),
            array(
                'question' => 'What should I do after an ATV rollover accident?',
                'answer'   => 'Seek immediate medical attention, do not move the ATV from the crash site if possible, photograph the scene and the ATV from multiple angles, preserve the ATV for expert inspection, get witness information, and contact an ATV accident attorney before speaking with insurance adjusters.',
            ),
            array(
                'question' => 'What is the statute of limitations for an ATV rollover claim?',
                'answer'   => 'In Georgia, you have 2 years from the date of injury to file a lawsuit (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530). Product liability claims may have additional time limitations, so prompt legal consultation is important.',
            ),
            array(
                'question' => 'Are property owners liable for ATV rollover accidents on their land?',
                'answer'   => 'Property owners who invite or permit ATV riding on their land may be liable if they fail to warn of known hazards such as steep grades, hidden drop-offs, or unstable terrain. Georgia and South Carolina premises liability laws require property owners to maintain reasonably safe conditions for invited users.',
            ),
        ),
    ),

    /* ============================================================
       2. Side-by-Side (UTV) Accident
       ============================================================ */
    array(
        'title'   => 'Side-by-Side (UTV) Accident Lawyers',
        'slug'    => 'side-by-side-utv-accident',
        'excerpt' => 'Injured in a side-by-side or UTV accident in Georgia or South Carolina? Our attorneys handle Polaris RZR, Can-Am, and other utility vehicle crash claims involving defects, rollovers, and operator negligence.',
        'content' => <<<'HTML'
<h2>Side-by-Side &amp; UTV Accident Claims</h2>
<p>Side-by-side vehicles — also known as utility task vehicles (UTVs) or recreational off-highway vehicles (ROVs) — have surged in popularity across Georgia and South Carolina for both recreational use and property management. Vehicles like the Polaris RZR, Can-Am Maverick, Kawasaki Teryx, and Yamaha YXZ are marketed for high-performance off-road adventure, but their power-to-weight ratios and off-road capabilities create serious injury risks. The <a href="https://www.cpsc.gov/Safety-Education/Safety-Guides/Sports-Fitness-and-Recreation/ATVs" target="_blank" rel="noopener">CPSC</a> has tracked a rapid increase in UTV-related injuries and deaths in recent years, with rollovers, ejections, and collisions causing devastating harm.</p>
<p>At Roden Law, our ATV and UTV accident attorneys represent victims of side-by-side crashes throughout Georgia and South Carolina. Whether your accident involved a vehicle defect, operator negligence, or unsafe terrain conditions, we pursue full compensation for your injuries.</p>

<h2>Common Side-by-Side Accident Causes</h2>
<p>Side-by-side vehicles present unique hazards that differ from traditional ATVs and motor vehicles:</p>
<ul>
<li><strong>Rollover accidents:</strong> Despite roll cages, UTVs still roll over at alarming rates — particularly high-performance sport models driven at speed on uneven terrain (see also <a href="/atv-side-by-side-accident-lawyers/atv-rollover-accident/">ATV rollover accidents</a>)</li>
<li><strong>Passenger ejection:</strong> Occupants thrown from the vehicle during a rollover, often due to inadequate restraint systems or doors that open on impact</li>
<li><strong>Defective seatbelts and harnesses:</strong> Three-point belts that fail to restrain occupants in a rollover, or harness systems that are difficult to latch properly</li>
<li><strong>Excessive speed on trails:</strong> High-performance UTVs capable of 70+ mph operated on narrow trails and rough terrain</li>
<li><strong>On-road collisions:</strong> UTVs operated illegally on public roads, where they are struck by motor vehicles (see <a href="/atv-side-by-side-accident-lawyers/atv-road-collision/">ATV road collisions</a>)</li>
<li><strong>Defective components:</strong> Recalled parts, faulty steering, suspension failures, and throttle malfunctions (see <a href="/atv-side-by-side-accident-lawyers/atv-product-defect/">ATV product defects</a>)</li>
</ul>

<h2>Polaris RZR Recalls and Safety Issues</h2>
<p>Polaris Industries, the manufacturer of the popular RZR line of side-by-side vehicles, has been the subject of numerous <a href="https://www.cpsc.gov/" target="_blank" rel="noopener">CPSC recalls</a> involving fire hazards, steering defects, suspension failures, and throttle issues. Multiple RZR models have been recalled for engine compartment fires caused by fuel system leaks and overheating exhaust components. If you were injured in a Polaris RZR accident, a manufacturing or design defect may be a contributing factor, giving rise to a <a href="/product-liability-lawyers/">product liability claim</a> in addition to any negligence claims.</p>

<h2>Georgia &amp; South Carolina UTV Regulations</h2>
<p>Georgia law under <a href="https://law.justia.com/codes/georgia/title-40/chapter-7/article-5/" target="_blank" rel="noopener">O.C.G.A. § 40-7-120 et seq.</a> classifies side-by-side vehicles alongside ATVs for regulatory purposes, restricting their use on public roads and establishing age and safety requirements. South Carolina regulates off-highway vehicles under <a href="https://www.scstatehouse.gov/code/t56c015.php" target="_blank" rel="noopener">S.C. Code § 56-15-10 et seq.</a>, with similar restrictions on road use and requirements for equipment standards.</p>
<p>Operating a side-by-side on a public road in violation of these statutes can constitute negligence per se. When an operator's violation of these laws contributes to an accident that injures a passenger or third party, the violation itself can establish fault.</p>

<h2>Damages in Side-by-Side Accident Cases</h2>
<p>UTV accidents frequently result in severe injuries due to the open-air design and high-speed capabilities of these vehicles. Common injuries include crush injuries from rollovers, traumatic brain injuries, spinal cord damage, amputations, severe burns from post-crash fires, and death. Recoverable damages include all medical expenses, lost income, pain and suffering, permanent disability, and in fatal cases, <a href="/wrongful-death-lawyers/">wrongful death damages</a>. Georgia allows 2 years to file suit (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>), while South Carolina provides 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>).</p>

<h2>Why Choose Roden Law for Side-by-Side Accident Claims</h2>
<p>UTV cases require detailed technical analysis of vehicle design, terrain conditions, and manufacturer safety standards. Our attorneys have the experience and resources to handle complex side-by-side accident claims, including product liability cases against major manufacturers like Polaris, Can-Am, and Kawasaki. We work on a contingency fee basis — you pay nothing unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Are side-by-side vehicles safer than ATVs?',
                'answer'   => 'Side-by-sides offer some safety advantages over ATVs, including roll cages, seatbelts, and a wider wheelbase. However, they are still prone to rollovers, especially at high speeds and on uneven terrain. Their higher speeds and greater weight can also lead to more severe crash outcomes.',
            ),
            array(
                'question' => 'Can I sue Polaris if my RZR caught fire or rolled over due to a defect?',
                'answer'   => 'Yes. Polaris has been the subject of multiple CPSC recalls for fire hazards and mechanical defects. Under Georgia and South Carolina product liability law, you can pursue strict liability, negligence, and breach of warranty claims against the manufacturer.',
            ),
            array(
                'question' => 'Is it legal to drive a side-by-side on public roads in Georgia or South Carolina?',
                'answer'   => 'Generally no. Georgia (O.C.G.A. § 40-7-120) and South Carolina (S.C. Code § 56-15-10) restrict side-by-side operation on public roads, with limited exceptions. Operating illegally on a road can affect liability determinations in an accident case.',
            ),
            array(
                'question' => 'What should I do after a UTV accident?',
                'answer'   => 'Call 911, do not move the vehicle unless necessary for safety, photograph the scene and the UTV, preserve the vehicle for expert inspection, seek medical attention, and contact an attorney before accepting any insurance settlement or signing any documents.',
            ),
            array(
                'question' => 'What compensation is available for a side-by-side accident?',
                'answer'   => 'You may recover medical expenses, lost wages, pain and suffering, permanent disability, disfigurement, and emotional distress. In product defect cases, punitive damages may also be available. Fatal accidents give rise to wrongful death claims by surviving family members.',
            ),
        ),
    ),

    /* ============================================================
       3. ATV Product Defect
       ============================================================ */
    array(
        'title'   => 'ATV Product Defect Lawyers',
        'slug'    => 'atv-product-defect',
        'excerpt' => 'Injured by a defective ATV or side-by-side in Georgia or South Carolina? Our product liability attorneys hold manufacturers accountable for dangerous design defects, mechanical failures, and recalled components.',
        'content' => <<<'HTML'
<h2>ATV &amp; UTV Product Defect Claims</h2>
<p>When an all-terrain vehicle or side-by-side malfunctions due to a manufacturing defect, design flaw, or inadequate safety warning, the consequences can be catastrophic. The <a href="https://www.cpsc.gov/Safety-Education/Safety-Guides/Sports-Fitness-and-Recreation/ATVs" target="_blank" rel="noopener">CPSC</a> has issued hundreds of ATV and UTV recalls over the past decade, covering defects ranging from fire hazards and steering failures to throttle malfunctions and brake system problems. Despite these recalls, defective ATVs and UTVs continue to injure and kill riders across Georgia and South Carolina.</p>
<p>At Roden Law, our <a href="/product-liability-lawyers/">product liability attorneys</a> handle ATV and UTV defect cases against manufacturers including Polaris, Honda, Yamaha, Can-Am (BRP), Kawasaki, Arctic Cat, and CFMOTO. We retain engineering experts to analyze failed components and determine whether a defect caused or contributed to your crash.</p>

<h2>Common ATV &amp; UTV Product Defects</h2>
<p>ATV and UTV product defect cases typically fall into three legal categories — manufacturing defects, design defects, and failure to warn:</p>
<ul>
<li><strong>Throttle and acceleration defects:</strong> Stuck throttles, unintended acceleration, and electronic throttle control failures that cause loss of control</li>
<li><strong>Steering system failures:</strong> Power steering malfunctions, tie rod failures, and steering column defects that prevent the rider from controlling direction</li>
<li><strong>Brake system defects:</strong> Brake fade, premature brake wear, hydraulic line failures, and parking brake malfunctions that fail to prevent the vehicle from moving</li>
<li><strong>Fire hazards:</strong> Fuel system leaks, overheating exhaust components, and electrical shorts that cause engine compartment fires — a particular problem in Polaris RZR models</li>
<li><strong>Suspension and frame failures:</strong> A-arm failures, shock absorber defects, and frame cracks that cause loss of control or structural collapse</li>
<li><strong>Roll cage and restraint deficiencies:</strong> Inadequate roll cage strength in <a href="/atv-side-by-side-accident-lawyers/side-by-side-utv-accident/">side-by-side vehicles</a>, seatbelt failures, and door latch defects that allow occupant ejection during <a href="/atv-side-by-side-accident-lawyers/atv-rollover-accident/">rollovers</a></li>
</ul>

<h2>Product Liability Law in Georgia &amp; South Carolina</h2>
<p>Georgia's product liability framework under <a href="https://law.justia.com/codes/georgia/title-51/chapter-1/article-3/" target="_blank" rel="noopener">O.C.G.A. § 51-1-11</a> allows injured plaintiffs to pursue claims against manufacturers, distributors, and retailers in the product's chain of commerce. Claims may be based on strict liability (the product was defective and unreasonably dangerous), negligence (the manufacturer failed to exercise reasonable care), or breach of warranty (the product failed to perform as warranted).</p>
<p>South Carolina's Products Liability Act (<a href="https://www.scstatehouse.gov/code/t15c073.php" target="_blank" rel="noopener">S.C. Code § 15-73-10 et seq.</a>) similarly imposes strict liability on manufacturers for defective products. Both states recognize the "consumer expectations" test and the "risk-utility" test for determining whether a product design is unreasonably dangerous. Georgia also has a 10-year statute of repose for product liability claims (O.C.G.A. § 51-1-11(b)), meaning claims must generally be filed within 10 years of the product's first sale.</p>

<h2>CPSC Recalls and Their Impact on Your Claim</h2>
<p>A CPSC recall of the ATV or UTV model involved in your accident is powerful evidence in a product liability case. The recall demonstrates that the manufacturer itself — or the federal government — determined that the product posed an unreasonable safety risk. Our attorneys obtain complete recall files, including internal manufacturer communications, engineering analysis, consumer complaint databases, and injury reports, to build the strongest possible case against the manufacturer.</p>

<h2>Preserving Evidence in ATV Defect Cases</h2>
<p>If you suspect a product defect caused your ATV or UTV accident, preserving the vehicle is essential. Do not repair, dispose of, or allow anyone to modify the vehicle. Photograph it thoroughly, and inform your attorney immediately so we can issue a spoliation preservation letter to all parties. We arrange for independent engineering inspections of the failed component to document the defect before evidence is lost.</p>

<h2>Why Choose Roden Law for ATV Product Defect Claims</h2>
<p>Product liability cases against major ATV manufacturers require significant resources — expert engineering analysis, deposition of corporate witnesses, review of internal design documents, and often nationwide litigation coordination. Our firm has the experience and financial resources to take on these well-funded corporate defendants. We advance all case costs and work on a contingency fee basis — you pay nothing unless we recover compensation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'How do I know if a defect caused my ATV accident?',
                'answer'   => 'Signs of a product defect include unexpected mechanical failures (throttle sticking, brakes failing, steering locking), post-crash fire, structural failures (frame cracks, suspension collapse), and any situation where the ATV behaved unexpectedly. An engineering expert can inspect the vehicle to determine if a defect was involved.',
            ),
            array(
                'question' => 'Can I sue the ATV manufacturer even if I was partially at fault?',
                'answer'   => 'Yes. Georgia allows recovery if you are less than 50% at fault (O.C.G.A. § 51-12-33), and South Carolina allows recovery if you are less than 51% at fault. Even if operator error contributed to the crash, a product defect may bear significant responsibility.',
            ),
            array(
                'question' => 'Does a CPSC recall help my product liability case?',
                'answer'   => 'Yes. A recall is strong evidence that the manufacturer acknowledged a safety defect. However, you do not need a recall to pursue a defect claim — many defective products have never been recalled. An experienced attorney can evaluate your case regardless.',
            ),
            array(
                'question' => 'What is the deadline to file an ATV product defect lawsuit?',
                'answer'   => 'Georgia allows 2 years for personal injury (O.C.G.A. § 9-3-33) with a 10-year statute of repose from the product\'s first sale. South Carolina allows 3 years (S.C. Code § 15-3-530). Contact an attorney promptly to preserve your rights.',
            ),
            array(
                'question' => 'What should I do with the ATV after a crash involving a suspected defect?',
                'answer'   => 'Do not repair, modify, or dispose of the ATV. Photograph it from all angles, document the failed component, and contact an attorney immediately. We will issue a preservation letter and arrange for independent engineering inspection of the vehicle.',
            ),
        ),
    ),

    /* ============================================================
       4. Child ATV Injury
       ============================================================ */
    array(
        'title'   => 'Child ATV Injury Lawyers',
        'slug'    => 'child-atv-injury',
        'excerpt' => 'Child injured or killed in an ATV accident in Georgia or South Carolina? Our attorneys hold negligent adults, property owners, and manufacturers accountable for preventable child ATV injuries.',
        'content' => <<<'HTML'
<h2>Child ATV Injuries: A Preventable Crisis</h2>
<p>Children are disproportionately represented in ATV injury and death statistics. According to the <a href="https://www.cpsc.gov/Safety-Education/Safety-Guides/Sports-Fitness-and-Recreation/ATVs" target="_blank" rel="noopener">CPSC</a>, children under 16 account for approximately 25% of all ATV-related deaths and an even higher percentage of ATV-related injuries nationwide. The AAP (American Academy of Pediatrics) has long recommended that no child under 16 operate an ATV, regardless of the vehicle's engine size or the child's experience level. Despite these warnings, children continue to ride ATVs — often adult-sized machines — across Georgia and South Carolina, with devastating consequences.</p>
<p>At Roden Law, our child injury and ATV accident attorneys represent families whose children have been injured or killed in preventable ATV accidents. These cases are deeply personal to our team, and we pursue every available legal avenue to hold responsible parties accountable and secure the resources these families need.</p>

<h2>Georgia &amp; South Carolina Child ATV Laws</h2>
<p>Georgia's ATV statute (<a href="https://law.justia.com/codes/georgia/title-40/chapter-7/article-5/" target="_blank" rel="noopener">O.C.G.A. § 40-7-120 et seq.</a>) establishes age-based restrictions for ATV operation. Children under 16 are prohibited from operating an ATV on public land unless they have completed an approved ATV safety course. The law also restricts children from operating ATVs with engine sizes that exceed age-appropriate limits established by the CPSC. Parents and guardians who knowingly permit a child to violate these restrictions may face both criminal penalties and civil liability.</p>
<p>South Carolina's off-highway vehicle statute (<a href="https://www.scstatehouse.gov/code/t56c015.php" target="_blank" rel="noopener">S.C. Code § 56-15-10 et seq.</a>) similarly restricts minor ATV operation and requires parental supervision. Under both states' negligence laws, adults who provide an age-inappropriate ATV to a child, or who fail to supervise a child's ATV use, can be held liable for resulting injuries under negligent entrustment and negligent supervision theories.</p>

<h2>Who Is Liable for Child ATV Injuries</h2>
<p>Child ATV injury cases often involve multiple responsible parties:</p>
<ul>
<li><strong>Parents and guardians:</strong> Adults who permit children to operate ATVs without proper supervision, safety training, or age-appropriate equipment may be liable for negligent supervision and negligent entrustment</li>
<li><strong>Property owners:</strong> Landowners who invite or permit children to ride ATVs on their property without adequate safety measures, warnings, or supervision</li>
<li><strong>ATV manufacturers:</strong> Companies that produce and market ATVs to minors or fail to include adequate warnings about age restrictions and dangers (see <a href="/atv-side-by-side-accident-lawyers/atv-product-defect/">ATV product defects</a>)</li>
<li><strong>ATV rental and tour operators:</strong> Businesses that rent ATVs to minors or allow children to participate in guided tours without proper safety equipment (see <a href="/atv-side-by-side-accident-lawyers/atv-rental-tour-accident/">ATV rental and tour accidents</a>)</li>
<li><strong>Other adult operators:</strong> Adults operating ATVs recklessly in areas where children are present, or adults carrying child passengers on single-rider ATVs</li>
</ul>

<h2>The Danger of Adult-Sized ATVs for Children</h2>
<p>The CPSC has established age-based engine size recommendations: under 6 years old — no ATV use; ages 6-11 — engine displacement under 70cc; ages 12-15 — engine displacement under 90cc; ages 16+ — any engine size with proper training. Allowing a child to operate an adult-sized ATV (250cc, 450cc, or larger) dramatically increases the risk of loss of control, rollover, and fatal injury. The child simply lacks the body weight, strength, cognitive development, and reaction time to safely control a powerful machine.</p>

<h2>Wrongful Death Claims for Child ATV Fatalities</h2>
<p>When a child is killed in an ATV accident, surviving parents may pursue a <a href="/wrongful-death-lawyers/">wrongful death claim</a> under Georgia's wrongful death statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-4/" target="_blank" rel="noopener">O.C.G.A. § 51-4-1 et seq.</a>) or South Carolina's wrongful death statute (<a href="https://www.scstatehouse.gov/code/t15c051.php" target="_blank" rel="noopener">S.C. Code § 15-51-10 et seq.</a>). These claims seek compensation for the full value of the child's life, including the loss of the child's future companionship, guidance, and society. Georgia also allows a separate survival action for the child's pain and suffering before death.</p>

<h2>Damages in Child ATV Injury Cases</h2>
<p>Recoverable damages in child ATV injury cases include all past and future medical expenses, including surgeries, hospitalization, rehabilitation, and any needed adaptive equipment; pain and suffering; permanent disability and scarring; loss of future earning capacity; emotional trauma and PTSD treatment; and in fatal cases, wrongful death damages. Georgia's statute of limitations is generally 2 years (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>), while South Carolina allows 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). Special tolling rules may extend these deadlines for minor children.</p>

<h2>Why Choose Roden Law for Child ATV Injury Claims</h2>
<p>Child injury cases require compassion, thoroughness, and an unwavering commitment to accountability. Our attorneys have extensive experience with catastrophic child injury claims and understand the unique legal and emotional dynamics involved. We work on a contingency fee basis and advance all case costs — your family pays nothing unless we secure a recovery.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What age is too young to ride an ATV in Georgia?',
                'answer'   => 'The CPSC recommends no ATV use for children under 6 years old. Georgia law (O.C.G.A. § 40-7-120) restricts children under 16 from operating ATVs on public land without a safety course and prohibits age-inappropriate engine sizes. The AAP recommends no child under 16 operate any ATV.',
            ),
            array(
                'question' => 'Can I sue if another adult let my child ride an ATV and they were injured?',
                'answer'   => 'Yes. An adult who provides an ATV to a child — or permits a child to ride without proper supervision, training, or age-appropriate equipment — can be held liable under negligent entrustment and negligent supervision theories in both Georgia and South Carolina.',
            ),
            array(
                'question' => 'Are ATV manufacturers liable for child injuries?',
                'answer'   => 'Potentially yes. Manufacturers who market ATVs to children, fail to include adequate age-restriction warnings, or design vehicles without appropriate speed limiters for youth models may face product liability claims for resulting injuries.',
            ),
            array(
                'question' => 'What is the statute of limitations for a child ATV injury claim?',
                'answer'   => 'Georgia allows 2 years (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530), but special tolling rules may extend these deadlines for minor children. Consult an attorney to understand the specific deadlines in your case.',
            ),
            array(
                'question' => 'Can we file a wrongful death claim if our child was killed in an ATV accident?',
                'answer'   => 'Yes. Georgia (O.C.G.A. § 51-4-1) and South Carolina (S.C. Code § 15-51-10) both allow parents to file wrongful death claims for the loss of a child. These claims seek compensation for the full value of the child\'s life, including future companionship and society.',
            ),
        ),
    ),

    /* ============================================================
       5. ATV Rental and Tour Accident
       ============================================================ */
    array(
        'title'   => 'ATV Rental and Tour Accident Lawyers',
        'slug'    => 'atv-rental-tour-accident',
        'excerpt' => 'Injured during an ATV rental or guided tour in Georgia or South Carolina? Our attorneys hold tour operators and rental companies accountable for unsafe equipment, inadequate training, and dangerous trail conditions.',
        'content' => <<<'HTML'
<h2>ATV Rental &amp; Guided Tour Accident Claims</h2>
<p>ATV and UTV rental businesses and guided tour operations have become increasingly popular tourist attractions across Georgia and South Carolina, particularly in rural areas, coastal communities, and mountain regions. While these businesses promise outdoor adventure, many operate with minimal safety oversight — providing little or no rider training, renting out poorly maintained vehicles, and leading tours through terrain that exceeds the abilities of inexperienced riders. When rental companies and tour operators prioritize profit over safety, the results can be catastrophic.</p>
<p>At Roden Law, our ATV accident attorneys hold rental companies and tour operators accountable when their negligence causes injuries to riders. We investigate every aspect of the operation — from vehicle maintenance records and rider training protocols to trail conditions and guide qualifications — to identify the failures that caused your accident.</p>

<h2>Common Causes of ATV Rental &amp; Tour Accidents</h2>
<p>ATV rental and tour accidents frequently result from operational failures by the business, including:</p>
<ul>
<li><strong>Inadequate rider training:</strong> Providing a brief verbal orientation instead of hands-on instruction in ATV handling, braking, and terrain navigation</li>
<li><strong>Poorly maintained vehicles:</strong> Renting ATVs with worn brakes, bald tires, steering problems, or unresolved mechanical issues (see <a href="/atv-side-by-side-accident-lawyers/atv-product-defect/">ATV product defects</a>)</li>
<li><strong>Age-inappropriate vehicle assignments:</strong> Allowing minors to operate adult-sized ATVs or failing to enforce CPSC age and size recommendations (see <a href="/atv-side-by-side-accident-lawyers/child-atv-injury/">child ATV injuries</a>)</li>
<li><strong>Dangerous trail conditions:</strong> Leading tours through terrain with steep grades, sharp drop-offs, water crossings, or obstacles without adequate warnings</li>
<li><strong>Inadequate guide supervision:</strong> Tour guides who set unsafe pace, ride too far ahead of the group, or fail to monitor inexperienced riders</li>
<li><strong>Failure to provide safety equipment:</strong> Not requiring or providing helmets, goggles, gloves, and protective clothing</li>
<li><strong>Overloaded tours:</strong> Groups that are too large for guides to supervise effectively, particularly with mixed-experience-level riders</li>
</ul>

<h2>Liability Waivers and Their Limitations</h2>
<p>Nearly every ATV rental company requires riders to sign a liability waiver before operating. Many riders believe these waivers prevent them from filing a lawsuit if they are injured — but this is not always the case. Georgia courts have held that liability waivers cannot protect a business from claims based on gross negligence, willful misconduct, or violations of public safety statutes. A waiver that attempts to release a business from all liability, including its own negligent acts, may be deemed unconscionable and unenforceable.</p>
<p>South Carolina similarly limits the enforceability of exculpatory agreements, particularly when they involve services offered to the general public. Courts examine factors including the clarity of the waiver language, whether the injured party had a meaningful choice, and whether enforcing the waiver would violate public policy. Our attorneys aggressively challenge these waivers when they stand between our clients and fair compensation.</p>

<h2>Georgia &amp; South Carolina Business Liability Standards</h2>
<p>ATV rental and tour companies owe a duty of reasonable care to their customers under both Georgia and South Carolina negligence law. Georgia's general negligence statute and premises liability principles under <a href="https://law.justia.com/codes/georgia/title-51/chapter-3/" target="_blank" rel="noopener">O.C.G.A. § 51-3-1</a> require businesses to maintain safe conditions and adequately warn of known hazards. South Carolina imposes similar duties under common law negligence principles. Commercial ATV operations must also comply with <a href="https://law.justia.com/codes/georgia/title-40/chapter-7/article-5/" target="_blank" rel="noopener">O.C.G.A. § 40-7-120</a> (Georgia) and <a href="https://www.scstatehouse.gov/code/t56c015.php" target="_blank" rel="noopener">S.C. Code § 56-15-10</a> (South Carolina) governing off-highway vehicle operation.</p>

<h2>Investigating Rental Company Negligence</h2>
<p>Our attorneys conduct thorough investigations of ATV rental and tour operations, obtaining vehicle maintenance and inspection records, training protocols and guide qualifications, prior accident reports and customer complaints, insurance certificates and coverage details, and any state or local permitting and inspection records. This evidence is critical to establishing that the company knew or should have known about the hazards that caused your injuries.</p>

<h2>Why Choose Roden Law for ATV Rental &amp; Tour Claims</h2>
<p>Rental and tour companies often rely on liability waivers and aggressive insurance adjusters to discourage injured riders from pursuing claims. Our attorneys know how to challenge these defenses and hold negligent operators accountable. We work on a contingency fee basis — no fees unless we recover compensation for your injuries. Contact us for a free consultation.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Does the liability waiver I signed prevent me from suing the ATV rental company?',
                'answer'   => 'Not necessarily. Georgia and South Carolina courts do not enforce waivers that attempt to absolve a business of gross negligence, willful misconduct, or violations of safety statutes. An attorney can evaluate whether the waiver is enforceable in your specific case.',
            ),
            array(
                'question' => 'What should I do if I am injured during an ATV tour?',
                'answer'   => 'Seek immediate medical attention, photograph the ATV and the scene, get contact information for the tour guide and other participants, save a copy of any waiver you signed, do not give recorded statements to the company\'s insurance, and contact an attorney promptly.',
            ),
            array(
                'question' => 'Is the rental company liable if the ATV they provided was poorly maintained?',
                'answer'   => 'Yes. Rental companies have a duty to maintain their vehicles in safe operating condition. Renting an ATV with worn brakes, steering defects, or other mechanical problems constitutes negligence that can make the company liable for injuries caused by the equipment failure.',
            ),
            array(
                'question' => 'Can I sue if the tour guide led us through dangerous terrain?',
                'answer'   => 'Yes. Tour operators have a duty to select appropriate trails for the group\'s skill level, provide adequate warnings about hazards, and supervise riders throughout the tour. Leading inexperienced riders through advanced terrain without proper warnings is negligence.',
            ),
            array(
                'question' => 'What is the statute of limitations for an ATV rental accident claim?',
                'answer'   => 'Georgia allows 2 years from the date of injury (O.C.G.A. § 9-3-33), and South Carolina allows 3 years (S.C. Code § 15-3-530). Contact an attorney promptly to ensure your claim is filed within the applicable deadline.',
            ),
        ),
    ),

    /* ============================================================
       6. ATV Road Collision
       ============================================================ */
    array(
        'title'   => 'ATV Road Collision Lawyers',
        'slug'    => 'atv-road-collision',
        'excerpt' => 'Injured in an ATV or UTV collision on a public road in Georgia or South Carolina? Our attorneys handle complex liability cases involving off-highway vehicles struck by motor vehicles on roadways.',
        'content' => <<<'HTML'
<h2>ATV Collisions on Public Roads</h2>
<p>All-terrain vehicles and side-by-side UTVs are designed for off-road use, but they are frequently operated on public roads — particularly in rural Georgia and South Carolina communities where ATVs are used for farm work, property maintenance, and general transportation. When an ATV operating on a public road is struck by a car, truck, or other motor vehicle, the results are almost always catastrophic. ATVs lack the safety features of passenger vehicles — no airbags, no crumple zones, no seatbelts (on most ATVs), and minimal visibility lighting — leaving riders exposed to devastating impact forces.</p>
<p>At Roden Law, our ATV accident attorneys handle road collision cases throughout Georgia and South Carolina. These cases involve complex liability questions about whether the ATV was legally on the road, whether the motor vehicle driver was negligent, and whether the ATV's lack of safety equipment contributed to the severity of the injuries.</p>

<h2>Georgia &amp; South Carolina ATV Road Use Laws</h2>
<p>Georgia law under <a href="https://law.justia.com/codes/georgia/title-40/chapter-7/article-5/" target="_blank" rel="noopener">O.C.G.A. § 40-7-120 et seq.</a> generally prohibits operating ATVs on public roads, with exceptions for agricultural purposes, road crossings, and certain designated areas. When an ATV is legally crossing or traveling along a roadway under these exceptions, the operator must comply with applicable traffic laws and safety equipment requirements.</p>
<p>South Carolina's off-highway vehicle statute (<a href="https://www.scstatehouse.gov/code/t56c015.php" target="_blank" rel="noopener">S.C. Code § 56-15-10 et seq.</a>) similarly restricts ATV road use, though specific regulations vary by county and municipality. Some South Carolina counties have adopted local ordinances permitting limited ATV road use on roads with speed limits of 35 mph or less.</p>
<p>Critically, even if an ATV is on the road illegally, the motor vehicle driver still owes a duty of care to avoid collisions. A driver who strikes an ATV because they were speeding, distracted, driving under the influence, or failed to exercise reasonable care can be held liable for the resulting injuries, regardless of whether the ATV was lawfully on the road.</p>

<h2>Common ATV Road Collision Scenarios</h2>
<p>Our attorneys have handled ATV road collision cases involving a wide range of circumstances:</p>
<ul>
<li><strong>Road crossings:</strong> ATVs struck while legally crossing a public road from one property to another — often at high-risk rural intersections with limited visibility</li>
<li><strong>Agricultural use:</strong> Farm ATVs traveling along road shoulders or crossing roads between fields, struck by passing traffic</li>
<li><strong>Rural road travel:</strong> ATVs used as transportation on low-speed rural roads, struck by faster-moving vehicles</li>
<li><strong>Nighttime collisions:</strong> ATVs with inadequate lighting struck by vehicles at dusk or after dark</li>
<li><strong>DUI collisions:</strong> Impaired drivers striking ATVs — see also our <a href="/car-accident-lawyers/drunk-driver-accident/">drunk driver accident</a> page for information about DUI liability</li>
<li><strong>Hit-and-run incidents:</strong> Drivers striking ATV riders and fleeing the scene</li>
</ul>

<h2>Comparative Fault in ATV Road Cases</h2>
<p>ATV road collision cases frequently involve shared fault. The motor vehicle driver may have been speeding or distracted, while the ATV operator may have been on the road illegally or without proper safety equipment. Georgia's modified comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>) allows recovery as long as the injured party is less than 50% at fault. South Carolina similarly applies modified comparative negligence, barring recovery only if the plaintiff is 51% or more at fault.</p>
<p>Our attorneys work with accident reconstruction experts to analyze each collision and establish the motor vehicle driver's share of fault — even in cases where the ATV rider bears some responsibility for being on the road.</p>

<h2>Injuries in ATV Road Collisions</h2>
<p>The speed differential between a car (traveling 45–55 mph) and an ATV (traveling 15–25 mph on roads) means that road collisions often produce the most severe injuries of any ATV accident type. Common injuries include traumatic brain injuries, spinal cord injuries and paralysis, multiple fractures, internal organ damage, amputations, and fatal injuries. The lack of rollover protection on most ATVs means riders may be thrown from the vehicle or crushed beneath it. In fatal cases, families may pursue <a href="/wrongful-death-lawyers/">wrongful death claims</a>.</p>

<h2>Damages and Statute of Limitations</h2>
<p>ATV road collision victims may recover compensation for all medical expenses, lost wages and future earning capacity, pain and suffering, permanent disability, property damage, and wrongful death damages in fatal cases. Georgia's statute of limitations is 2 years (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>), and South Carolina allows 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>).</p>

<h2>Why Choose Roden Law for ATV Road Collision Claims</h2>
<p>ATV road collision cases require careful analysis of both traffic law and off-highway vehicle regulations, combined with accident reconstruction expertise. Our attorneys understand how to navigate the comparative fault issues unique to these cases and maximize your recovery even when liability is shared. We handle all ATV accident cases on a contingency fee basis — you owe nothing unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I recover compensation if my ATV was on the road illegally when I was hit?',
                'answer'   => 'Yes. Even if the ATV was on the road in violation of Georgia or South Carolina law, the motor vehicle driver still owed a duty of care. Under comparative fault rules, you can recover damages as long as you are less than 50% at fault in Georgia or less than 51% in South Carolina.',
            ),
            array(
                'question' => 'Is it legal to ride an ATV on public roads in Georgia?',
                'answer'   => 'Generally no. Georgia law (O.C.G.A. § 40-7-120) prohibits ATV operation on public roads with limited exceptions for agricultural use, road crossings, and certain designated areas. Some counties may have additional local regulations.',
            ),
            array(
                'question' => 'Who is at fault when a car hits an ATV on a road?',
                'answer'   => 'Fault depends on the specific circumstances — including whether the ATV was legally on the road, whether the car driver was speeding or distracted, and whether both parties had adequate lighting and visibility. Both drivers may share fault under comparative negligence rules.',
            ),
            array(
                'question' => 'What should I do if I am hit by a car while riding my ATV?',
                'answer'   => 'Call 911 immediately, do not move if you suspect spinal injuries, photograph the scene and both vehicles, get the driver\'s insurance information, obtain witness contact details, seek medical attention, and contact an ATV accident attorney before speaking with any insurance company.',
            ),
            array(
                'question' => 'What damages are available in an ATV road collision case?',
                'answer'   => 'You may recover medical expenses, lost wages, pain and suffering, permanent disability, property damage, and in fatal cases, wrongful death damages. Punitive damages may be available if the motor vehicle driver was impaired or engaged in reckless conduct.',
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
