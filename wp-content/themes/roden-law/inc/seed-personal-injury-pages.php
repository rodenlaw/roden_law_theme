<?php
/**
 * Seeder: personal-injury-lawyers pillar + 5 city intersection pages
 *
 * Creates the pillar post and 5 intersection posts with full content,
 * meta fields, and attorney attribution. Run via WP-CLI eval-file.
 *
 * Usage:
 *   cd sites/rodenlawdev1
 *   wp eval-file wp-content/themes/roden-law/inc/seed-personal-injury-pages.php
 *
 * Safe to re-run: skips posts that already exist by slug.
 *
 * ROD-63
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Starting personal-injury-lawyers page seeder...' );

// ── Helper: Get attorney post ID by slug ────────────────────────────────────
function roden_get_attorney_id( $slug ) {
	$post = get_page_by_path( $slug, OBJECT, 'attorney' );
	return $post ? $post->ID : 0;
}

$eric_roden_id    = roden_get_attorney_id( 'eric-roden' );
$graeham_gillin_id = roden_get_attorney_id( 'graeham-gillin' );
$joshua_dorminy_id = roden_get_attorney_id( 'joshua-dorminy' );

WP_CLI::log( "Attorney IDs — Eric: {$eric_roden_id}, Graeham: {$graeham_gillin_id}, Joshua: {$joshua_dorminy_id}" );

// ── Pillar page content ─────────────────────────────────────────────────────
$pillar_content = <<<'HTML'
<p>When you or a loved one suffers an injury because of someone else's negligence, you deserve experienced legal representation that fights for every dollar you're owed. Roden Law's personal injury attorneys serve clients across Georgia and South Carolina from five office locations — Savannah, Darien, Charleston, Columbia, and Myrtle Beach. We have recovered more than <strong>$250 million</strong> for injured clients, and we handle every case on a <strong>contingency fee basis</strong>: you pay nothing unless we win.</p>

<h2>What Is a Personal Injury Claim?</h2>
<p>A personal injury claim arises when one person's negligent, reckless, or intentional conduct causes physical, emotional, or financial harm to another person. To establish liability, four elements must be proven: the at-fault party owed you a duty of care; they breached that duty; their breach directly caused your injuries; and you suffered actual damages as a result.</p>
<p>Personal injury law covers a broad spectrum of accidents and incidents. Our attorneys handle cases ranging from common highway collisions to complex product liability suits, medical malpractice claims, and catastrophic workplace injuries.</p>

<h2>Practice Areas We Handle</h2>
<p>Roden Law's personal injury attorneys represent clients in a full range of cases across Georgia and South Carolina:</p>
<ul>
<li><a href="/practice-areas/car-accident-lawyers/">Car Accident Claims</a> — collisions, head-on crashes, rear-end accidents, highway pile-ups</li>
<li><a href="/practice-areas/truck-accident-lawyers/">Truck &amp; Commercial Vehicle Accidents</a> — 18-wheelers, delivery vehicles, overloaded trucks</li>
<li><a href="/practice-areas/slip-and-fall-lawyers/">Slip and Fall / Premises Liability</a> — dangerous floors, parking lots, inadequate security</li>
<li><a href="/practice-areas/motorcycle-accident-lawyers/">Motorcycle Accidents</a> — lane-change collisions, door accidents, road hazards</li>
<li><a href="/practice-areas/medical-malpractice-lawyers/">Medical Malpractice</a> — surgical errors, misdiagnosis, birth injuries</li>
<li><a href="/practice-areas/wrongful-death-lawyers/">Wrongful Death</a> — fatal accidents, survivor claims, estate recovery</li>
<li><a href="/practice-areas/workers-compensation-lawyers/">Workers' Compensation</a> — workplace injuries, denied claims, third-party liability</li>
<li><a href="/practice-areas/brain-injury-lawyers/">Brain &amp; Head Injuries</a> — traumatic brain injury, concussions, skull fractures</li>
<li><a href="/practice-areas/spinal-cord-injury-lawyers/">Spinal Cord Injuries</a> — paralysis, disc injuries, nerve damage</li>
<li><a href="/practice-areas/dog-bite-lawyers/">Dog Bite Injuries</a> — strict liability in Georgia and South Carolina</li>
<li><a href="/practice-areas/product-liability-lawyers/">Defective Product Liability</a> — dangerous consumer goods, automotive defects</li>
<li><a href="/practice-areas/maritime-injury-lawyers/">Maritime Injuries</a> — Jones Act claims, offshore accidents, dock injuries</li>
</ul>

<h2>Why Choose Roden Law?</h2>
<p>Choosing the right personal injury attorney can mean the difference between a lowball insurance settlement and the full compensation your injuries warrant. Here is what sets Roden Law apart from other firms:</p>
<ul>
<li><strong>$250M+ Recovered:</strong> Our track record speaks for itself. We have secured millions in verdicts and settlements for clients throughout Georgia and South Carolina.</li>
<li><strong>5,000+ Cases Handled:</strong> Experience across every type of personal injury case means your attorney has seen situations like yours before.</li>
<li><strong>Senior Attorney Involvement:</strong> Unlike high-volume advertising firms, your case is handled by an attorney — not a paralegal or case manager.</li>
<li><strong>No Upfront Costs:</strong> We work on a contingency fee basis. If we do not recover compensation for you, you owe us nothing.</li>
<li><strong>Five Office Locations:</strong> We have physical offices in <a href="/locations/georgia/savannah/">Savannah</a>, <a href="/locations/georgia/darien/">Darien</a>, <a href="/locations/south-carolina/charleston/">Charleston</a>, <a href="/locations/south-carolina/columbia/">Columbia</a>, and <a href="/locations/south-carolina/myrtle-beach/">Myrtle Beach</a> — serving clients across the Southeast coast.</li>
</ul>

<h2>Georgia Personal Injury Law</h2>
<p>If your injury occurred in Georgia, specific state laws will govern your claim. Understanding these rules is essential before speaking with an insurance adjuster.</p>
<h3>Georgia Statute of Limitations</h3>
<p>Under <strong>O.C.G.A. § 9-3-33</strong>, personal injury victims in Georgia have <strong>two years from the date of injury</strong> to file a lawsuit. Missing this deadline almost always bars your claim permanently. Exceptions exist for minors, mental incapacity, and cases involving fraud by the defendant — but do not rely on these without consulting an attorney.</p>
<h3>Georgia Modified Comparative Fault</h3>
<p>Georgia follows the <strong>modified comparative fault rule under O.C.G.A. § 51-12-33</strong>. You can recover compensation as long as you are found to be <strong>less than 50% at fault</strong> for the accident. However, your recovery is reduced proportionally by your share of fault. If you are found 50% or more at fault, you recover nothing. Insurance companies routinely attempt to inflate your percentage of fault to reduce their payout — an experienced attorney protects against this tactic.</p>

<h2>South Carolina Personal Injury Law</h2>
<p>South Carolina's personal injury laws differ meaningfully from Georgia's. If your accident happened in South Carolina, these rules apply.</p>
<h3>South Carolina Statute of Limitations</h3>
<p>Under <strong>S.C. Code § 15-3-530</strong>, you have <strong>three years from the date of injury</strong> to file a personal injury lawsuit in South Carolina. While this is one year longer than Georgia's deadline, waiting weakens your case: witnesses' memories fade, surveillance footage gets deleted, and physical evidence disappears.</p>
<h3>South Carolina Modified Comparative Fault</h3>
<p>South Carolina also uses a modified comparative fault system. You can recover compensation as long as you are <strong>less than 51% at fault</strong>. As in Georgia, your recovery is reduced by your percentage of fault. The 51% threshold gives South Carolina plaintiffs a slight advantage over Georgia, but the practical analysis is similar: document your case carefully and do not give recorded statements without legal advice.</p>

<h2>How the Personal Injury Claims Process Works</h2>
<p>Personal injury cases follow a predictable process, though timing varies by case complexity. Here is what to expect when you hire Roden Law:</p>
<ol>
<li><strong>Free Case Evaluation:</strong> We review your situation — the accident, your injuries, liability evidence, and insurance coverage — at no cost to you. Call 1-844-RESULTS or fill out our online form anytime.</li>
<li><strong>Investigation and Evidence Preservation:</strong> Our team gathers police reports, medical records, witness statements, surveillance footage, and expert opinions to build a complete picture of what happened and who is responsible.</li>
<li><strong>Medical Documentation:</strong> Your treatment records are the foundation of your claim. We coordinate with your healthcare providers to ensure all injuries and future treatment needs are properly documented.</li>
<li><strong>Demand and Negotiation:</strong> Once you reach maximum medical improvement, we submit a comprehensive demand package to the at-fault party's insurer and negotiate aggressively on your behalf.</li>
<li><strong>Litigation if Necessary:</strong> If the insurer refuses a fair settlement, we file suit in the appropriate Georgia or South Carolina court and take your case to trial. Insurance companies know our attorneys try cases — that changes how they negotiate.</li>
</ol>

<h2>What Compensation Can You Recover?</h2>
<p>Georgia and South Carolina personal injury law allows victims to seek two categories of damages:</p>
<h3>Economic Damages</h3>
<p>These are quantifiable financial losses: past and future medical expenses, lost wages, loss of earning capacity, property damage, and out-of-pocket costs related to the injury.</p>
<h3>Non-Economic Damages</h3>
<p>These compensate for subjective losses: pain and suffering, emotional distress, loss of enjoyment of life, and loss of consortium. South Carolina does not cap non-economic damages in most personal injury cases. Georgia does not cap them in standard PI cases (medical malpractice caps differ).</p>
<h3>Punitive Damages</h3>
<p>In cases involving willful misconduct, fraud, or gross negligence — such as a drunk driver or a company that concealed a known product defect — courts may award punitive damages to punish the defendant and deter similar conduct.</p>

<h2>Our Office Locations</h2>
<p>Roden Law maintains five offices across Georgia and South Carolina to serve clients where they live and where their accidents happen:</p>
<ul>
<li><a href="/personal-injury-lawyers/savannah-ga/"><strong>Savannah, GA</strong></a> — 333 Commercial Dr., Savannah, GA 31406 — (912) 303-5850</li>
<li><a href="/personal-injury-lawyers/darien-ga/"><strong>Darien, GA</strong></a> — 1108 North Way, Darien, GA 31305 — (912) 303-5850</li>
<li><a href="/personal-injury-lawyers/charleston-sc/"><strong>Charleston, SC</strong></a> — 127 King Street, Suite 200, Charleston, SC 29401 — (843) 790-8999</li>
<li><a href="/personal-injury-lawyers/columbia-sc/"><strong>Columbia, SC</strong></a> — 1545 Sumter St., Suite B, Columbia, SC 29201 — (803) 219-2816</li>
<li><a href="/personal-injury-lawyers/myrtle-beach-sc/"><strong>Myrtle Beach, SC</strong></a> — 631 Bellamy Ave., Suite C-B, Murrells Inlet, SC 29576 — (843) 612-1980</li>
</ul>
HTML;

// ── Intersection page content templates ────────────────────────────────────

$intersection_pages = array(
	'savannah-ga' => array(
		'title'       => 'Personal Injury Lawyers in Savannah, GA',
		'office_key'  => 'savannah',
		'jurisdiction'=> 'georgia',
		'attorney_id' => $eric_roden_id,
		'sol_ga'      => '2 years (O.C.G.A. § 9-3-33)',
		'content'     => <<<'HTML'
<p>Roden Law's Savannah personal injury attorneys have helped hundreds of clients throughout Chatham County and the surrounding coastal Georgia region recover compensation for serious injuries. If you were hurt in a car accident on Abercorn Street, a slip and fall at a Savannah River Street hotel, a workplace injury at the Port of Savannah, or any other accident caused by someone else's negligence, our team is ready to fight for you. Call us at <a href="tel:+19123035850">(912) 303-5850</a> for a free case evaluation.</p>

<h2>Personal Injury Cases We Handle in Savannah</h2>
<p>Our Savannah office represents clients in a wide range of injury cases that arise in Chatham County and the Southeast Georgia region:</p>
<ul>
<li><a href="/car-accident-lawyers/savannah-ga/">Car Accidents in Savannah</a> — I-16, I-95, Abercorn Street, and DeRenne Avenue corridors</li>
<li><a href="/truck-accident-lawyers/savannah-ga/">Truck Accidents</a> — Port of Savannah trucking routes, US-17, I-95, I-16</li>
<li><a href="/slip-and-fall-lawyers/savannah-ga/">Slip and Fall / Premises Liability</a> — River Street, City Market, hotels, parking garages</li>
<li><a href="/motorcycle-accident-lawyers/savannah-ga/">Motorcycle Accidents</a> — Coastal highway crashes, lane-change collisions</li>
<li><a href="/maritime-injury-lawyers/savannah-ga/">Maritime Injuries</a> — Port workers, dock accidents, Jones Act claims</li>
<li><a href="/workers-compensation-lawyers/savannah-ga/">Workers' Compensation</a> — Port of Savannah, construction sites, warehousing</li>
<li><a href="/wrongful-death-lawyers/savannah-ga/">Wrongful Death</a> — Fatal accidents throughout Chatham County</li>
<li><a href="/medical-malpractice-lawyers/savannah-ga/">Medical Malpractice</a> — Memorial Health, Candler Hospital, and other facilities</li>
<li><a href="/brain-injury-lawyers/savannah-ga/">Brain &amp; Head Injuries</a> — Traumatic brain injuries from Savannah accidents</li>
<li><a href="/spinal-cord-injury-lawyers/savannah-ga/">Spinal Cord Injuries</a> — High-speed collision injuries, construction falls</li>
</ul>

<h2>Why Hire a Local Savannah Personal Injury Attorney?</h2>
<p>Hiring an attorney with deep roots in Savannah and Chatham County gives your case advantages that out-of-town firms cannot match. Our attorneys know the local courts, the local judges, and the local tactics that insurance defense firms use in this market.</p>
<p>We understand the roads where accidents happen most often in Savannah: the I-16 interchange near downtown, the congested Abercorn Street corridor from the Landings to Oglethorpe Mall, and the Port of Savannah access roads that see heavy truck traffic around the clock. We know which intersections are most dangerous and why — and we use that knowledge to build stronger liability cases for our clients.</p>
<p>Our Savannah office is located at 333 Commercial Drive, a few minutes south of downtown. We serve clients throughout Chatham County, as well as Pooler, Richmond Hill, Hinesville, Statesboro, Effingham County, and the surrounding Southeast Georgia region.</p>

<h2>Georgia Personal Injury Law: What Savannah Clients Need to Know</h2>
<h3>Filing Deadline: 2 Years</h3>
<p>Georgia law gives personal injury victims <strong>two years from the date of the accident</strong> to file a lawsuit under <strong>O.C.G.A. § 9-3-33</strong>. This deadline is firm. If you miss it, you almost certainly lose your right to any compensation, regardless of how serious your injuries are. Do not wait to consult an attorney — the sooner we begin preserving evidence and building your case, the stronger your position.</p>
<h3>Modified Comparative Fault</h3>
<p>Georgia follows a <strong>modified comparative fault rule under O.C.G.A. § 51-12-33</strong>. You can recover compensation as long as you are found to be <strong>less than 50% responsible</strong> for the accident. However, your recovery is reduced by your percentage of fault. If an insurance adjuster is arguing you were partially at fault — a common tactic — call us before making any statements.</p>
<h3>Filing in Chatham County Superior Court</h3>
<p>Personal injury lawsuits in Savannah are typically filed in the <strong>Chatham County Superior Court</strong> at 133 Montgomery Street. Our attorneys are familiar with local court procedures and rules, which allows us to move your case forward efficiently and without procedural errors that can delay resolution.</p>

<h2>Savannah's Most Dangerous Roads and Accident Hotspots</h2>
<p>Several areas of Savannah generate a disproportionate share of personal injury claims:</p>
<ul>
<li><strong>Abercorn Street corridor:</strong> One of Savannah's busiest commercial streets, with high pedestrian and vehicle traffic from Oglethorpe Mall to the Historic District. Rear-end and intersection collisions are common.</li>
<li><strong>I-16 / I-95 interchange:</strong> High-speed merging, heavy truck traffic from the Port, and frequent lane changes create dangerous conditions — especially for motorcyclists and smaller vehicles.</li>
<li><strong>River Street and the Historic District:</strong> Heavy pedestrian traffic, cobblestone surfaces, and numerous bars and restaurants create slip-and-fall and pedestrian accident risk, particularly at night.</li>
<li><strong>Port of Savannah access roads:</strong> The largest single container port on the US East Coast generates constant commercial truck traffic on local roads. Truck accidents in this area are often severe and involve complex multi-party liability.</li>
</ul>

<h2>Compensation Available in Georgia Personal Injury Cases</h2>
<p>Georgia personal injury law allows you to seek compensation for all losses caused by the at-fault party's negligence:</p>
<ul>
<li><strong>Medical expenses</strong> — emergency care, hospitalization, surgery, rehabilitation, and future treatment costs</li>
<li><strong>Lost wages</strong> — income you missed while recovering, plus lost earning capacity if your injuries are permanent</li>
<li><strong>Pain and suffering</strong> — compensation for physical pain and the emotional toll of your injuries</li>
<li><strong>Property damage</strong> — repair or replacement of your vehicle and other damaged property</li>
<li><strong>Loss of consortium</strong> — for spouses who have lost companionship or support due to a spouse's serious injuries</li>
</ul>

<h2>What to Do After a Personal Injury in Savannah</h2>
<p>The steps you take in the first hours and days after an accident significantly affect your claim. If you are physically able:</p>
<ol>
<li>Call 911 and ensure everyone receives medical attention. A police report is essential documentation.</li>
<li>Take photographs of the scene, all vehicles involved, any visible injuries, and surrounding conditions.</li>
<li>Get the names and contact information of witnesses before they leave.</li>
<li>Seek medical evaluation even if you feel fine. Whiplash, internal injuries, and traumatic brain injuries may not show symptoms immediately.</li>
<li>Do not give recorded statements to insurance adjusters before consulting an attorney.</li>
<li>Contact Roden Law at (912) 303-5850 for a free, no-obligation case review.</li>
</ol>
HTML,
	),
	'charleston-sc' => array(
		'title'       => 'Personal Injury Lawyers in Charleston, SC',
		'office_key'  => 'charleston',
		'jurisdiction'=> 'south-carolina',
		'attorney_id' => $graeham_gillin_id,
		'sol_sc'      => '3 years (S.C. Code § 15-3-530)',
		'content'     => <<<'HTML'
<p>Roden Law's Charleston personal injury attorneys represent clients throughout the Lowcountry — from North Charleston and Mount Pleasant to Summerville, Goose Creek, and the surrounding communities. Whether you were hurt in a crash on I-26, a boat accident in Charleston Harbor, a slip and fall in a downtown hotel, or a workplace injury at the Port of Charleston, our team is ready to help you pursue the compensation you deserve. Call <a href="tel:+18437908999">(843) 790-8999</a> for a free consultation.</p>

<h2>Personal Injury Cases We Handle in Charleston</h2>
<p>Our Charleston office handles the full range of personal injury cases that arise in the Lowcountry:</p>
<ul>
<li><a href="/car-accident-lawyers/charleston-sc/">Car Accidents in Charleston</a> — I-26, I-526, US-17, the Ravenel Bridge, Highway 61</li>
<li><a href="/truck-accident-lawyers/charleston-sc/">Truck &amp; Commercial Vehicle Accidents</a> — Port of Charleston traffic, I-26 corridor crashes</li>
<li><a href="/slip-and-fall-lawyers/charleston-sc/">Slip and Fall / Premises Liability</a> — King Street, Market Street, hotels, tourist attractions</li>
<li><a href="/motorcycle-accident-lawyers/charleston-sc/">Motorcycle Accidents</a> — Coastal roads, lane-split restrictions, scenic route collisions</li>
<li><a href="/maritime-injury-lawyers/charleston-sc/">Maritime &amp; Boating Injuries</a> — Charleston Harbor, ICW, offshore accidents</li>
<li><a href="/workers-compensation-lawyers/charleston-sc/">Workers' Compensation</a> — Port, military base contractors, construction, hospitality</li>
<li><a href="/wrongful-death-lawyers/charleston-sc/">Wrongful Death</a> — Fatal accidents throughout Charleston County</li>
<li><a href="/medical-malpractice-lawyers/charleston-sc/">Medical Malpractice</a> — MUSC, Roper St. Francis, Bon Secours</li>
<li><a href="/brain-injury-lawyers/charleston-sc/">Brain &amp; Head Injuries</a> — Traumatic brain injuries from motor vehicle crashes</li>
<li><a href="/boating-accident-lawyers/charleston-sc/">Boating Accidents</a> — Lowcountry waterway crashes and injuries</li>
</ul>

<h2>Why Hire a Local Charleston Personal Injury Attorney?</h2>
<p>Charleston's legal landscape has unique characteristics that make local knowledge essential. Our attorneys know the Charleston County Circuit Court, the judges on the bench, and the local defense firms that insurers routinely retain. That familiarity translates directly to more effective representation.</p>
<p>We also understand what makes Charleston injury cases distinctive. The I-26/I-526 interchange near the airport is one of South Carolina's most accident-prone highway segments. The Ravenel Bridge generates serious crash dynamics when fog or wind affects visibility. King Street's dense pedestrian activity, especially on weekends, creates ongoing slip-and-fall and pedestrian accident risk. The Port of Charleston and JBcharleston generate substantial workers' compensation and third-party liability cases.</p>
<p>Our Charleston office is located at 127 King Street, Suite 200, in the heart of downtown. We serve clients throughout Charleston County and the surrounding Lowcountry communities of North Charleston, Mount Pleasant, Summerville, Goose Creek, Hanahan, James Island, and West Ashley.</p>

<h2>South Carolina Personal Injury Law: What Charleston Clients Need to Know</h2>
<h3>Filing Deadline: 3 Years</h3>
<p>South Carolina law gives personal injury victims <strong>three years from the date of the accident</strong> to file a lawsuit under <strong>S.C. Code § 15-3-530</strong>. While this is longer than Georgia's two-year window, waiting weakens your case. Witnesses move, surveillance footage gets overwritten, and physical evidence disappears. Contact an attorney as soon as possible.</p>
<h3>Modified Comparative Fault in South Carolina</h3>
<p>South Carolina uses a <strong>modified comparative fault system</strong>. You can recover damages as long as you are found <strong>less than 51% responsible</strong> for the accident. Your recovery is reduced proportionally by your share of fault. If you are 51% or more at fault, you recover nothing. Insurance companies aggressively try to assign fault to claimants — this is exactly why having your own attorney matters.</p>
<h3>Filing in Charleston County Circuit Court</h3>
<p>Personal injury lawsuits in Charleston are heard by the <strong>Charleston County Circuit Court</strong> at 100 Broad Street. Graeham C. Gillin, our lead Charleston attorney, has extensive experience practicing before the Circuit Court and understands the procedural requirements that govern your case.</p>

<h2>Charleston's Most Dangerous Roads and Accident Areas</h2>
<ul>
<li><strong>I-26 near the airport:</strong> Complex interchanges, heavy commercial traffic, and merge zones make this one of the most accident-prone stretches of highway in South Carolina.</li>
<li><strong>I-526 (Mark Clark Expressway):</strong> High-speed multi-lane highway with limited exit spacing and significant truck traffic from the port.</li>
<li><strong>US-17 (Savannah Highway):</strong> Long commercial corridor from West Ashley to Hollywood with numerous signalized intersections and pedestrian crossings.</li>
<li><strong>Ravenel Bridge access roads:</strong> Congested on-ramps and the bridge's long span create merging hazards and limited accident recovery space.</li>
<li><strong>King Street and the Market area:</strong> Dense pedestrian traffic, dockless scooters, and distracted drivers create ongoing pedestrian and slip-and-fall risk.</li>
</ul>

<h2>Compensation Available in South Carolina Personal Injury Cases</h2>
<ul>
<li><strong>Medical expenses</strong> — past and future treatment, rehabilitation, assistive devices</li>
<li><strong>Lost wages and earning capacity</strong> — income lost during recovery and reduced future earnings</li>
<li><strong>Pain and suffering</strong> — South Carolina does not impose a statutory cap on pain and suffering in standard PI cases</li>
<li><strong>Property damage</strong> — vehicle repair or replacement and other damaged property</li>
<li><strong>Loss of consortium</strong> — damages for spouses and family members affected by serious injuries</li>
<li><strong>Punitive damages</strong> — available in cases of willful, wanton, or reckless conduct</li>
</ul>

<h2>What to Do After an Injury in Charleston</h2>
<ol>
<li>Call 911. Get the police report number — you will need it for your claim.</li>
<li>Photograph everything: vehicles, injuries, road conditions, traffic signals, signage.</li>
<li>Get witness contact information before they leave the scene.</li>
<li>Seek medical attention promptly, even if symptoms seem minor at first.</li>
<li>Do not give recorded statements to insurance adjusters without first speaking to an attorney.</li>
<li>Call Roden Law's Charleston office at (843) 790-8999 for a free case review.</li>
</ol>
HTML,
	),
	'columbia-sc' => array(
		'title'       => 'Personal Injury Lawyers in Columbia, SC',
		'office_key'  => 'columbia',
		'jurisdiction'=> 'south-carolina',
		'attorney_id' => $graeham_gillin_id,
		'sol_sc'      => '3 years (S.C. Code § 15-3-530)',
		'content'     => <<<'HTML'
<p>Roden Law represents personal injury victims in Columbia, Lexington, Irmo, West Columbia, Cayce, and throughout the South Carolina Midlands. Our Columbia attorneys understand the local courts, local insurance practices, and the specific accident patterns that put Midlands residents at risk — from the I-20/I-26/I-77 interchange to the University of South Carolina area to Fort Jackson's surrounding roads. If you were injured because of someone else's negligence, we are ready to fight for full compensation. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free consultation.</p>

<h2>Personal Injury Cases We Handle in Columbia</h2>
<p>Our Columbia office handles personal injury cases arising throughout Richland County and the surrounding Midlands area:</p>
<ul>
<li><a href="/car-accident-lawyers/columbia-sc/">Car Accidents in Columbia</a> — I-20, I-26, I-77, US-1, Garners Ferry Road, Gervais Street</li>
<li><a href="/truck-accident-lawyers/columbia-sc/">Truck &amp; Commercial Vehicle Accidents</a> — I-20/I-77 corridor, distribution center traffic, hazmat carriers</li>
<li><a href="/slip-and-fall-lawyers/columbia-sc/">Slip and Fall / Premises Liability</a> — USC campus, State House area, shopping centers, parking decks</li>
<li><a href="/motorcycle-accident-lawyers/columbia-sc/">Motorcycle Accidents</a> — Broad River Road, Two Notch Road, Garners Ferry Road</li>
<li><a href="/workers-compensation-lawyers/columbia-sc/">Workers' Compensation</a> — government workers, contractors, warehousing, healthcare workers</li>
<li><a href="/wrongful-death-lawyers/columbia-sc/">Wrongful Death</a> — fatal accidents throughout Richland and Lexington Counties</li>
<li><a href="/medical-malpractice-lawyers/columbia-sc/">Medical Malpractice</a> — Prisma Health, Lexington Medical Center, Palmetto Health</li>
<li><a href="/brain-injury-lawyers/columbia-sc/">Brain &amp; Head Injuries</a> — TBI from motor vehicle accidents and falls</li>
<li><a href="/pedestrian-accident-lawyers/columbia-sc/">Pedestrian Accidents</a> — USC area foot traffic, downtown Columbia pedestrian zones</li>
<li><a href="/bicycle-accident-lawyers/columbia-sc/">Bicycle Accidents</a> — Saluda River Greenway, city bike lanes</li>
</ul>

<h2>Why Hire a Local Columbia Personal Injury Attorney?</h2>
<p>Columbia's personal injury market has several well-funded competitors who rely on heavy advertising to attract clients. What sets Roden Law apart is direct attorney involvement in every case. You will work with your attorney — not a rotating team of paralegals — from intake through resolution.</p>
<p>Our Columbia office is located at 1545 Sumter Street, Suite B, in the downtown corridor near the University of South Carolina. This puts us close to Richland County Circuit Court, making it easy to handle filings, hearings, and client meetings without delay. We serve clients throughout Columbia, Lexington, Irmo, West Columbia, Cayce, Forest Acres, Blythewood, and surrounding communities.</p>

<h2>South Carolina Personal Injury Law: What Columbia Clients Need to Know</h2>
<h3>Filing Deadline: 3 Years</h3>
<p>South Carolina's statute of limitations for personal injury claims is <strong>three years under S.C. Code § 15-3-530</strong>. Do not mistake a longer deadline for flexibility — evidence disappears quickly, and the earlier we begin investigating your case, the stronger your claim will be.</p>
<h3>Modified Comparative Fault</h3>
<p>South Carolina uses <strong>modified comparative fault</strong>, allowing recovery as long as you are <strong>less than 51% responsible</strong>. Insurance adjusters commonly try to shift blame onto the injured party to reduce or eliminate their payout. Our attorneys anticipate and counter this strategy.</p>
<h3>Filing in Richland County Circuit Court</h3>
<p>Personal injury lawsuits in Columbia are filed in the <strong>Richland County Circuit Court</strong> at 1701 Main Street. Our attorneys understand the local rules, local judges, and the procedural expectations of the court — knowledge that directly benefits your case.</p>

<h2>Columbia's Most Dangerous Roads and Accident Areas</h2>
<p>Columbia's highway system handles substantial through-traffic from three major interstates converging in the Midlands, creating dangerous conditions:</p>
<ul>
<li><strong>I-20/I-26/I-77 interchange:</strong> One of the most complex highway exchanges in South Carolina, with heavy commercial traffic and frequent rear-end and lane-change collisions.</li>
<li><strong>Two Notch Road (US-1):</strong> Long commercial corridor through Northeast Columbia with numerous signalized intersections and high pedestrian crossing activity.</li>
<li><strong>Garners Ferry Road:</strong> Major arterial through Southeast Columbia with significant truck and commuter traffic.</li>
<li><strong>Broad River Road:</strong> Northwest Columbia corridor with heavy traffic near Harbison and Dutch Square commercial areas.</li>
<li><strong>USC and Five Points area:</strong> Dense pedestrian activity from the student population creates ongoing pedestrian accident and DUI-involved crash risk, especially at night and on weekends.</li>
</ul>

<h2>Compensation Available in South Carolina Personal Injury Cases</h2>
<ul>
<li><strong>Medical expenses</strong> — emergency room, surgery, hospitalization, physical therapy, future care</li>
<li><strong>Lost wages and earning capacity</strong> — for both short-term recovery and permanent disability</li>
<li><strong>Pain and suffering</strong> — non-economic damages without statutory cap in standard PI cases</li>
<li><strong>Property damage</strong> — vehicle repair or replacement</li>
<li><strong>Punitive damages</strong> — for cases involving reckless or willful misconduct</li>
</ul>

<h2>What to Do After a Personal Injury in Columbia</h2>
<ol>
<li>Call 911 immediately and obtain a copy of the police incident report.</li>
<li>Document the scene with photographs before conditions change.</li>
<li>Gather witness names and contact information.</li>
<li>Seek immediate medical care — do not delay treatment, as gaps in medical records are used against claimants.</li>
<li>Avoid giving recorded statements to insurance adjusters; they will use your words against you.</li>
<li>Call Roden Law's Columbia office at (803) 219-2816 for a free, confidential case evaluation.</li>
</ol>
HTML,
	),
	'myrtle-beach-sc' => array(
		'title'       => 'Personal Injury Lawyers in Myrtle Beach, SC',
		'office_key'  => 'myrtle-beach',
		'jurisdiction'=> 'south-carolina',
		'attorney_id' => $graeham_gillin_id,
		'sol_sc'      => '3 years (S.C. Code § 15-3-530)',
		'content'     => <<<'HTML'
<p>Roden Law's Myrtle Beach area attorneys represent injury victims throughout the Grand Strand — from Myrtle Beach and North Myrtle Beach to Murrells Inlet, Pawleys Island, Conway, and Surfside Beach. Our office is located in Murrells Inlet at 631 Bellamy Avenue, Suite C-B. Whether you were injured in a car accident on US-17, a golf cart collision on a resort property, a slip and fall at a hotel, or a boating accident in the Intracoastal Waterway, we are here to help. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free case evaluation.</p>

<h2>Personal Injury Cases We Handle in Myrtle Beach</h2>
<p>Our Myrtle Beach area office handles personal injury cases throughout Horry County and the surrounding Grand Strand:</p>
<ul>
<li><a href="/car-accident-lawyers/myrtle-beach-sc/">Car Accidents in Myrtle Beach</a> — US-17, US-501, SC-31, Business 17, Highway 544</li>
<li><a href="/truck-accident-lawyers/myrtle-beach-sc/">Truck &amp; Commercial Vehicle Accidents</a> — Distribution and delivery vehicle crashes on US-501 and US-17</li>
<li><a href="/slip-and-fall-lawyers/myrtle-beach-sc/">Slip and Fall / Premises Liability</a> — Hotels, resorts, Boardwalk, restaurants, vacation rentals</li>
<li><a href="/golf-cart-accident-lawyers/myrtle-beach-sc/">Golf Cart Accidents</a> — Resort properties, Ocean Lakes, golf courses, Barefoot Landing</li>
<li><a href="/boating-accident-lawyers/myrtle-beach-sc/">Boating &amp; Watercraft Accidents</a> — ICW, Atlantic Ocean, waterpark injuries</li>
<li><a href="/motorcycle-accident-lawyers/myrtle-beach-sc/">Motorcycle Accidents</a> — Bike Week incidents, coastal highway crashes</li>
<li><a href="/workers-compensation-lawyers/myrtle-beach-sc/">Workers' Compensation</a> — Hospitality workers, hotel employees, construction</li>
<li><a href="/wrongful-death-lawyers/myrtle-beach-sc/">Wrongful Death</a> — Fatal accidents throughout Horry County</li>
<li><a href="/pedestrian-accident-lawyers/myrtle-beach-sc/">Pedestrian Accidents</a> — Boardwalk, Myrtle Beach Pelicans stadium area, downtown</li>
<li><a href="/electric-scooter-accident-lawyers/myrtle-beach-sc/">Electric Scooter Accidents</a> — Rental scooter crashes on resort properties and public streets</li>
</ul>

<h2>Injured While Visiting Myrtle Beach? Your Rights Still Apply.</h2>
<p>Many personal injury claims in Myrtle Beach involve out-of-state visitors who are unfamiliar with South Carolina law. If you were hurt while vacationing in Myrtle Beach, you have the same legal rights as any South Carolina resident. South Carolina law governs your claim regardless of your home state.</p>
<p>This matters because: your home state's insurance requirements and tort laws do not control. South Carolina's three-year statute of limitations applies. And the at-fault party's insurer will be subject to South Carolina's modified comparative fault rules. An experienced South Carolina personal injury attorney — not your hometown lawyer who has never practiced in SC courts — is your best resource.</p>

<h2>Why Hire a Local Myrtle Beach Personal Injury Attorney?</h2>
<p>Myrtle Beach's personal injury landscape is distinctive because of the tourist economy. Hotels and resorts have in-house risk management teams trained to minimize liability exposure immediately after an accident occurs. Property owners document incidents their way before you have a chance to document them yours. Having legal representation early — ideally before you leave the Grand Strand — protects your interests.</p>
<p>Our Murrells Inlet office is conveniently located to serve all of Horry County, from North Myrtle Beach to Pawleys Island. We know the local courts, local insurance defense firms, and the particular liability issues that arise in resort-area personal injury cases.</p>

<h2>South Carolina Personal Injury Law: What Grand Strand Clients Need to Know</h2>
<h3>Filing Deadline: 3 Years</h3>
<p>Under <strong>S.C. Code § 15-3-530</strong>, you have <strong>three years</strong> from the date of injury to file a lawsuit. If you were a visitor and returned home after your vacation, this timeline still runs from the date of the accident in South Carolina.</p>
<h3>Modified Comparative Fault</h3>
<p>South Carolina's <strong>modified comparative fault rule</strong> allows recovery as long as you are found <strong>less than 51% responsible</strong>. This is especially relevant in resort cases where property owners attempt to shift blame to the injured guest.</p>
<h3>Filing in Horry County Circuit Court</h3>
<p>Personal injury lawsuits in Myrtle Beach are filed in the <strong>Horry County Circuit Court</strong> at 1301 2nd Avenue, Conway, SC. Our attorneys are experienced before the Horry County courts and understand local court procedures.</p>

<h2>Myrtle Beach's Most Dangerous Roads and Accident Areas</h2>
<ul>
<li><strong>US-17 Business (Kings Highway):</strong> The primary commercial artery through Myrtle Beach, with constant pedestrian crossings, frequent stop-and-go traffic, and high distracted-driver risk from tourists unfamiliar with the road.</li>
<li><strong>US-501:</strong> The main inland route from Conway to Myrtle Beach, heavily traveled by both commercial trucks and tourist vehicles, with dangerous merge zones near SC-31.</li>
<li><strong>SC-31 (Carolina Bays Parkway):</strong> High-speed limited-access highway connecting the northern and southern Grand Strand. Exit ramp accidents are common.</li>
<li><strong>The Boardwalk and Ocean Boulevard:</strong> Dense pedestrian and golf cart activity, especially during peak tourist season and special events.</li>
<li><strong>Resort parking lots and private roads:</strong> Golf cart and low-speed vehicle accidents on private resort property require analysis of both premises liability and traffic laws.</li>
</ul>

<h2>Compensation You Can Pursue</h2>
<ul>
<li><strong>Medical expenses</strong> — including any treatment you received during your visit and ongoing care after returning home</li>
<li><strong>Lost wages</strong> — for time missed from your regular job due to the injury</li>
<li><strong>Pain and suffering</strong> — South Carolina imposes no cap on these damages in standard PI cases</li>
<li><strong>Travel and accommodation costs</strong> — related to returning for medical treatment or legal proceedings</li>
<li><strong>Property damage</strong> — vehicle repairs and other lost property</li>
</ul>

<h2>What to Do After an Injury in Myrtle Beach</h2>
<ol>
<li>Report the incident to the property owner or manager and obtain a copy of any incident report they file.</li>
<li>Call 911 for any traffic accident or serious fall — a police report is essential evidence.</li>
<li>Photograph the scene, your injuries, the hazard that caused your fall, or the vehicles involved.</li>
<li>Get medical attention before leaving the area if at all possible — medical records created close in time to the injury are the strongest evidence.</li>
<li>Do not accept any settlement offers from the hotel or resort's insurance without speaking to an attorney first.</li>
<li>Call Roden Law at (843) 612-1980 before you leave town. We can begin protecting your interests immediately.</li>
</ol>
HTML,
	),
	'darien-ga' => array(
		'title'       => 'Personal Injury Lawyers in Darien, GA',
		'office_key'  => 'darien',
		'jurisdiction'=> 'georgia',
		'attorney_id' => $eric_roden_id ?: $joshua_dorminy_id,
		'sol_ga'      => '2 years (O.C.G.A. § 9-3-33)',
		'content'     => <<<'HTML'
<p>Roden Law is the only personal injury law firm with a physical office in McIntosh County, Georgia. Our Darien attorneys represent injury victims throughout the Golden Isles and southeastern coastal Georgia, including Brunswick, St. Simons Island, Jekyll Island, Waycross, and the surrounding communities. If you were hurt in a car accident on US-17 or I-95, a boating accident in the Altamaha River or the ICW, a workplace injury at an area industrial facility, or any other accident caused by someone else's negligence, our team is here to help. Call <a href="tel:+19123035850">(912) 303-5850</a> for a free consultation.</p>

<h2>Personal Injury Cases We Handle in Darien</h2>
<p>Our Darien office serves personal injury clients across McIntosh County and the surrounding coastal Georgia region:</p>
<ul>
<li><a href="/car-accident-lawyers/darien-ga/">Car Accidents in Darien and McIntosh County</a> — US-17, I-95, US-341, SR-99</li>
<li><a href="/truck-accident-lawyers/darien-ga/">Truck Accidents</a> — I-95 commercial corridor, timber and agricultural carrier routes</li>
<li><a href="/maritime-injury-lawyers/darien-ga/">Maritime &amp; Boating Injuries</a> — Altamaha River, Darien River, ICW, offshore</li>
<li><a href="/slip-and-fall-lawyers/darien-ga/">Slip and Fall / Premises Liability</a> — Golden Isles resorts, Jekyll Island State Park facilities</li>
<li><a href="/workers-compensation-lawyers/darien-ga/">Workers' Compensation</a> — industrial, timber, paper mill, and maritime workers</li>
<li><a href="/wrongful-death-lawyers/darien-ga/">Wrongful Death</a> — fatal accidents throughout McIntosh County and the Golden Isles</li>
<li><a href="/boating-accident-lawyers/darien-ga/">Boating Accidents</a> — coastal waterway collisions, recreational vessel injuries</li>
<li><a href="/motorcycle-accident-lawyers/darien-ga/">Motorcycle Accidents</a> — coastal highway crashes on US-17 and SR-99</li>
<li><a href="/brain-injury-lawyers/darien-ga/">Brain &amp; Head Injuries</a> — TBI from high-speed crashes on rural and coastal highways</li>
<li><a href="/spinal-cord-injury-lawyers/darien-ga/">Spinal Cord Injuries</a> — catastrophic injuries from truck and vehicle collisions</li>
</ul>

<h2>The Only Personal Injury Law Office in McIntosh County</h2>
<p>Most personal injury firms in coastal Georgia are based in Savannah and travel to McIntosh County only for court appearances. Roden Law is different: we maintain a physical office at 1108 North Way in Darien, staffed by attorneys who know the local roads, the local courts, and the local communities.</p>
<p>Our proximity to McIntosh County Superior Court means we can handle your case without the delays that come from managing a coastal county matter from a distant Savannah or Atlanta office. We also understand the specific industries and accident patterns that are unique to this area — from I-95 commercial trucking to timber carrier routes to boating and maritime incidents on the Altamaha River and the Intracoastal Waterway.</p>

<h2>Georgia Personal Injury Law: What Darien Clients Need to Know</h2>
<h3>Filing Deadline: 2 Years</h3>
<p>Georgia's personal injury statute of limitations is <strong>two years from the date of the accident</strong> under <strong>O.C.G.A. § 9-3-33</strong>. This applies whether your accident happened in McIntosh County, Glynn County, Brantley County, or anywhere else in Georgia. Do not wait — the investigation process takes time, and we need to act before evidence disappears.</p>
<h3>Modified Comparative Fault</h3>
<p>Georgia uses a <strong>modified comparative fault rule under O.C.G.A. § 51-12-33</strong>. You can recover damages as long as you are less than 50% at fault. In rural and coastal areas, insurance adjusters for trucking companies and large carriers are particularly aggressive about shifting blame to the injured party. Our attorneys understand these tactics and know how to counter them.</p>
<h3>Filing in McIntosh County Superior Court</h3>
<p>Personal injury lawsuits arising from McIntosh County accidents are typically filed in the <strong>McIntosh County Superior Court</strong> at 310 Northway, Darien, GA 31305. Our attorneys are familiar with local court procedures and can handle your case efficiently without the logistical delays associated with out-of-county firms.</p>

<h2>Darien's Most Dangerous Roads and Accident Areas</h2>
<ul>
<li><strong>I-95 through McIntosh County:</strong> One of the Southeast's busiest commercial truck corridors. Speed differentials between commercial carriers and passenger vehicles at Exit 49 and the US-17 interchange create dangerous merge conditions.</li>
<li><strong>US-17 (the Coastal Highway):</strong> A two-lane and four-lane state route that carries significant through-traffic along the Georgia coast. Limited shoulders, frequent wildlife crossings, and heavy timber truck use make this road particularly hazardous at night and during poor weather.</li>
<li><strong>Altamaha River and coastal waterways:</strong> Recreational boating, commercial fishing, and charter vessel activity on the Altamaha, Darien River, and ICW generate boating accidents and maritime injury claims throughout the season.</li>
<li><strong>Golden Isles resort access roads:</strong> The causeway to St. Simons Island and the Jekyll Island Causeway see heavy tourist traffic during peak season, with a mix of unfamiliar drivers and local commuters.</li>
</ul>

<h2>Compensation Available in Georgia Personal Injury Cases</h2>
<ul>
<li><strong>Medical expenses</strong> — emergency care, surgery, hospitalization, rehabilitation, and future treatment</li>
<li><strong>Lost wages</strong> — income lost during recovery and reduced earning capacity for permanent injuries</li>
<li><strong>Pain and suffering</strong> — compensation for physical pain and emotional distress</li>
<li><strong>Property damage</strong> — vehicle repair or replacement</li>
<li><strong>Punitive damages</strong> — available in cases of willful, wanton, or reckless conduct</li>
</ul>

<h2>What to Do After a Personal Injury in Darien or the Golden Isles</h2>
<ol>
<li>Call 911 and ensure a police or law enforcement report is filed. In McIntosh County, you may be dealing with the McIntosh County Sheriff's Department or Georgia State Patrol.</li>
<li>Photograph all vehicles, the scene, any visible injuries, road conditions, and signage.</li>
<li>Get witness contact information at the scene.</li>
<li>Seek prompt medical care, even if you feel relatively fine. Rural areas have limited trauma care — our office can help you identify the right providers for your injuries.</li>
<li>Do not give recorded statements to any insurer before consulting an attorney.</li>
<li>Call Roden Law's Darien office at (912) 303-5850 for a free case evaluation. We serve the entire coastal Georgia region from our McIntosh County office.</li>
</ol>
HTML,
	),
);

// ── Create or update pillar post ────────────────────────────────────────────

$existing_pillar = get_page_by_path( 'personal-injury-lawyers', OBJECT, 'practice_area' );

if ( $existing_pillar ) {
	WP_CLI::log( "Pillar post already exists (ID: {$existing_pillar->ID}). Updating content." );
	$pillar_id = $existing_pillar->ID;
	wp_update_post( array(
		'ID'           => $pillar_id,
		'post_content' => $pillar_content,
		'post_title'   => 'Personal Injury Lawyers in Georgia & South Carolina',
		'post_status'  => 'publish',
	) );
} else {
	WP_CLI::log( 'Creating pillar post: personal-injury-lawyers' );
	$pillar_id = wp_insert_post( array(
		'post_type'    => 'practice_area',
		'post_status'  => 'publish',
		'post_title'   => 'Personal Injury Lawyers in Georgia & South Carolina',
		'post_name'    => 'personal-injury-lawyers',
		'post_content' => $pillar_content,
		'post_parent'  => 0,
	), true );

	if ( is_wp_error( $pillar_id ) ) {
		WP_CLI::error( 'Failed to create pillar: ' . $pillar_id->get_error_message() );
	}
}

WP_CLI::log( "Pillar ID: {$pillar_id}" );

// Set pillar meta fields
update_post_meta( $pillar_id, '_roden_jurisdiction', 'both' );
update_post_meta( $pillar_id, '_roden_sol_ga', '2 years (O.C.G.A. § 9-3-33)' );
update_post_meta( $pillar_id, '_roden_sol_sc', '3 years (S.C. Code § 15-3-530)' );
update_post_meta( $pillar_id, '_roden_author_attorney', $eric_roden_id );

// Set FAQs on pillar
$pillar_faqs = array(
	array(
		'question' => 'What is a personal injury claim?',
		'answer'   => 'A personal injury claim is a legal action brought when someone is injured due to another party\'s negligence, recklessness, or intentional misconduct. To succeed, you must prove that the at-fault party owed you a duty of care, breached that duty, and that the breach directly caused your injuries and damages. Personal injury claims can arise from car accidents, slip and falls, medical errors, defective products, workplace accidents, and many other situations.',
	),
	array(
		'question' => 'How long do I have to file a personal injury lawsuit in Georgia and South Carolina?',
		'answer'   => 'In Georgia, you have two years from the date of your injury to file a personal injury lawsuit under O.C.G.A. § 9-3-33. In South Carolina, the deadline is three years under S.C. Code § 15-3-530. Missing these deadlines almost always bars your claim permanently. Contact an attorney as soon as possible — investigation takes time and evidence disappears quickly.',
	),
	array(
		'question' => 'What is modified comparative fault and how does it affect my case in Georgia or South Carolina?',
		'answer'   => 'Both Georgia and South Carolina use modified comparative fault rules. In Georgia (O.C.G.A. § 51-12-33), you can recover damages as long as you are found less than 50% at fault. In South Carolina, the threshold is 51%. If you are at or above that threshold, you recover nothing. Below it, your recovery is reduced proportionally by your percentage of fault. Insurance companies routinely try to inflate your share of fault — having an experienced attorney levels that playing field.',
	),
	array(
		'question' => 'What types of compensation can I recover in a personal injury case?',
		'answer'   => 'Personal injury victims can recover both economic and non-economic damages. Economic damages include medical expenses (past and future), lost wages, loss of earning capacity, and property damage. Non-economic damages cover pain and suffering, emotional distress, loss of enjoyment of life, and loss of consortium. In cases involving willful or reckless conduct, punitive damages may also be available. Georgia and South Carolina do not cap non-economic damages in standard personal injury cases.',
	),
	array(
		'question' => 'How much does a personal injury lawyer cost?',
		'answer'   => 'Roden Law handles all personal injury cases on a contingency fee basis. You pay no attorney fees and no costs unless we recover compensation for you. If we win your case, our fee is a percentage of the recovery. If we do not recover anything, you owe us nothing. This means anyone injured by someone else\'s negligence can afford top-quality legal representation, regardless of their financial situation.',
	),
	array(
		'question' => 'How long does a personal injury case take to settle?',
		'answer'   => 'The timeline varies significantly depending on the complexity of your case, the severity of your injuries, and how cooperative the at-fault party\'s insurer is. Straightforward cases with clear liability and documented damages may resolve in a few months. Cases with disputed liability, multiple parties, or catastrophic injuries can take a year or more — and some go to trial, which extends the timeline further. We work to resolve cases as efficiently as possible while ensuring you receive full and fair compensation.',
	),
	array(
		'question' => 'Should I accept the insurance company\'s first settlement offer?',
		'answer'   => 'Almost always, no. Insurance companies make early settlement offers specifically to close claims before victims fully understand the extent of their injuries and future costs. Once you accept a settlement and sign a release, you cannot go back for more money — even if your injuries turn out to be more serious than initially apparent. Always have an attorney evaluate any settlement offer before accepting it.',
	),
	array(
		'question' => 'What should I do immediately after a personal injury accident?',
		'answer'   => 'If you are physically able: call 911 and get a police report; photograph the scene, vehicles, and any visible injuries; collect witness contact information; seek medical attention promptly (even if you feel okay — many serious injuries are not immediately apparent); do not give recorded statements to insurance adjusters; and contact a personal injury attorney as soon as possible. The steps you take in the first hours and days after an accident can significantly affect the outcome of your claim.',
	),
);
update_post_meta( $pillar_id, '_roden_faqs', $pillar_faqs );

WP_CLI::success( "Pillar post configured: ID {$pillar_id} at /practice-areas/personal-injury-lawyers/" );

// ── Create intersection posts ───────────────────────────────────────────────

foreach ( $intersection_pages as $city_slug => $page ) {
	WP_CLI::log( "Processing intersection: {$city_slug}" );

	$existing = get_posts( array(
		'post_type'      => 'practice_area',
		'post_status'    => array( 'publish', 'draft' ),
		'post_parent'    => $pillar_id,
		'name'           => $city_slug,
		'posts_per_page' => 1,
	) );

	if ( $existing ) {
		$post_id = $existing[0]->ID;
		WP_CLI::log( "  Updating existing post ID: {$post_id}" );
		wp_update_post( array(
			'ID'           => $post_id,
			'post_content' => $page['content'],
			'post_title'   => $page['title'],
			'post_status'  => 'publish',
		) );
	} else {
		$post_id = wp_insert_post( array(
			'post_type'    => 'practice_area',
			'post_status'  => 'publish',
			'post_title'   => $page['title'],
			'post_name'    => $city_slug,
			'post_content' => $page['content'],
			'post_parent'  => $pillar_id,
		), true );

		if ( is_wp_error( $post_id ) ) {
			WP_CLI::warning( "  Failed to create {$city_slug}: " . $post_id->get_error_message() );
			continue;
		}
		WP_CLI::log( "  Created post ID: {$post_id}" );
	}

	// Set meta fields
	update_post_meta( $post_id, '_roden_office_key', $page['office_key'] );
	update_post_meta( $post_id, '_roden_jurisdiction', $page['jurisdiction'] );
	if ( ! empty( $page['sol_ga'] ) ) {
		update_post_meta( $post_id, '_roden_sol_ga', $page['sol_ga'] );
	}
	if ( ! empty( $page['sol_sc'] ) ) {
		update_post_meta( $post_id, '_roden_sol_sc', $page['sol_sc'] );
	}
	if ( $page['attorney_id'] ) {
		update_post_meta( $post_id, '_roden_author_attorney', $page['attorney_id'] );
	}

	WP_CLI::success( "  {$city_slug}: post ID {$post_id} published at /personal-injury-lawyers/{$city_slug}/" );
}

// Flush rewrite rules
flush_rewrite_rules();
WP_CLI::success( 'Rewrite rules flushed.' );

WP_CLI::log( '' );
WP_CLI::log( 'Next step: run the FAQ seeder for intersection pages.' );
WP_CLI::log( '  wp eval-file wp-content/themes/roden-law/inc/seed-personal-injury-faqs.php' );
WP_CLI::log( '' );
WP_CLI::success( 'personal-injury-lawyers seeder complete.' );
