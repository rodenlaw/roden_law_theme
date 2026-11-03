<?php
/**
 * Take down the false statements of Georgia law that sit on Tyler Love's
 * October review cards (data/facts/reviews/2026-10-attorney/plan.json,
 * section ga-corrections; passes 1-3), plus one class survivor (4090
 * _roden_pillar_negligence_intro, the golf-cart speed limit) and the Spanish
 * twin G28. Owner, 2026-11-02: "take all false sentences down now".
 *
 * DELETION ONLY. Each edit removes the false sentence or clause; where removal
 * would leave a fragment, the repair reuses words already on the page. No edit
 * states a new rule of law: the corrected wording on each card still waits for
 * Love. Five FAQs whose whole answer was the false claim are removed (they
 * also render as FAQPage structured data).
 *
 * Same mechanics as bin/apply-sc-followups-2026-10-27.php: exact match once on
 * every surface before any write; FAQ removals (by question text) run after
 * the string edits so indices hold; one write per surface via wp_slash; read
 * back from the table; _roden_content_modified set per post.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/remove-false-ga-claims-2026-11-02.php > docs/backups/remove-false-ga-claims-2026-11-02.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$edits = json_decode( <<<'EDITS'
[
 {
  "post": 4088,
  "field": "content",
  "from": "Electric scooters are regulated under <a href=\"https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/part-2a/section-40-6-320/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 40-6-320 et seq.</a>. Riders must be at least 15 years old (or 16 for rental scooters). Maximum speed is 20 mph. ",
  "to": "",
  "item": "F24"
 },
 {
  "post": 4088,
  "field": "faq:0:answer",
  "from": "Yes. Georgia regulates e-scooters under O.C.G.A. § 40-6-320 et seq. Riders must be at least 15 (16 for rentals). Maximum speed is 20 mph. Many cities, including Savannah, have additional local ordinances",
  "to": "Yes. Many cities, including Savannah, have local ordinances",
  "item": "F25"
 },
 {
  "post": 4088,
  "field": "_roden_why_hire",
  "from": "Georgia classifies electric scooters as \"electric personal transporters\" under <a href=\"https://law.justia.com/codes/georgia/title-40/chapter-1/section-40-1-1/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 40-1-1(15.4)</a> and regulates their use under <a href=\"https://law.justia.com/codes/georgia/title-40/chapter-6/article-12/section-40-6-320/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 40-6-320 et seq.</a>, limiting riders to 20 mph and requiring use on streets (not sidewalks in many municipalities). ",
  "to": "",
  "item": "F26"
 },
 {
  "post": 4224,
  "field": "content",
  "from": "Georgia law classifies electric scooters as \"personal transportation vehicles\" under <a href=\"https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/part-2a/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 40-6-320 et seq.</a>, which grants e-scooter riders many of the same rights and responsibilities as bicyclists on public roadways. Riders may use bike lanes, multi-use paths, and roadways with speed limits of 35 mph or less. ",
  "to": "",
  "item": "F27"
 },
 {
  "post": 4224,
  "field": "faqdel",
  "from": "Do e-scooter riders have the same rights as cars on Georgia roads?",
  "to": "",
  "item": "F28"
 },
 {
  "post": 4227,
  "field": "content",
  "from": "Georgia law under <a href=\"https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/part-2a/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 40-6-320 et seq.</a> generally prohibits e-scooter operation on sidewalks unless permitted by local ordinance. ",
  "to": "",
  "item": "F29"
 },
 {
  "post": 4229,
  "field": "faq:1:answer",
  "from": "Yes. Under Georgia law (O.C.G.A. § 40-6-320), e-scooter riders have the same right-of-way protections as bicyclists. They must",
  "to": "Yes. E-scooter riders must",
  "item": "F32"
 },
 {
  "post": 4090,
  "field": "content",
  "from": "<a href=\"https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/part-3/section-40-6-330/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 40-6-330 et seq.</a> permits golf cart operation on public roads with speed limits of 25 mph or less, during daylight hours, and only on roads specifically designated for golf cart use. Operators must be at least 16 and hold a valid driver's license or learner's permit. ",
  "to": "<a href=\"https://law.justia.com/codes/georgia/title-40/chapter-6/article-13/part-3/section-40-6-330/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 40-6-330 et seq.</a> permits golf cart operation only on roads specifically designated for golf cart use. ",
  "item": "F33"
 },
 {
  "post": 4090,
  "field": "faq:0:answer",
  "from": "Only on roads specifically designated for golf cart use with speed limits of 25 mph or less, during daylight hours. Operators must be at least 16 with a valid license.",
  "to": "Only on roads specifically designated for golf cart use.",
  "item": "F34"
 },
 {
  "post": 4090,
  "field": "_roden_why_hire",
  "from": "limiting their use to designated streets and communities with speed limits of 25 mph or less.",
  "to": "limiting their use to designated streets.",
  "item": "F35"
 },
 {
  "post": 4090,
  "field": "_roden_pillar_negligence_intro",
  "from": "golf carts may operate on roads with speed limits ≤35 mph in jurisdictions that have authorized them by ordinance.",
  "to": "golf carts may operate in jurisdictions that have authorized them by ordinance.",
  "item": "F35-class"
 },
 {
  "post": 4186,
  "field": "content",
  "from": " permits golf carts on public roads with speed limits of 25 mph or less (extendable to 35 mph by local ordinance) and requires",
  "to": " permits golf carts on designated public roads and requires",
  "item": "F36"
 },
 {
  "post": 4186,
  "field": "faq:0:answer",
  "from": "Georgia (O.C.G.A. § 40-6-330) permits golf carts on roads with speed limits of 25 mph or less, and",
  "to": "Georgia (O.C.G.A. § 40-6-330) permits golf carts on designated roads, and",
  "item": "F37"
 },
 {
  "post": 1662,
  "field": "content",
  "from": "<p>If your employer retaliates against you for filing a workers' compensation claim, we can protect your rights under Georgia's anti-retaliation statute (O.C.G.A. § 34-9-17) or South Carolina's corresponding protections.</p>\n\n",
  "to": "",
  "item": "E1"
 },
 {
  "post": 1662,
  "field": "faqdel",
  "from": "Can my employer fire me for filing a workers' compensation claim?",
  "to": "",
  "item": "E2"
 },
 {
  "post": 1690,
  "field": "content",
  "from": "Intoxication Defense (O.C.G.A. § 34-9-17(a))</h3>",
  "to": "Intoxication Defense (O.C.G.A. § 34-9-17)</h3>",
  "item": "E3"
 },
 {
  "post": 1690,
  "field": "content",
  "from": "<li>The employer must have a drug-free workplace policy in place</li>\n<li>The test must be conducted within the time frames specified by the policy</li>\n",
  "to": "",
  "item": "E4"
 },
 {
  "post": 1690,
  "field": "content",
  "from": "\n<li>Alcohol intoxication must be proven to be the proximate cause of the injury</li>",
  "to": "",
  "item": "E4"
 },
 {
  "post": 1690,
  "field": "faq:2:answer",
  "from": "The employer must have a drug-free workplace policy in place, and the test must follow proper protocols. ",
  "to": "",
  "item": "E5"
 },
 {
  "post": 1693,
  "field": "content",
  "from": "\n<li><strong>Intoxication defense:</strong> If the employer proves you were intoxicated at the time of the injury, benefits can be denied (O.C.G.A. § 34-9-17)</li>",
  "to": "",
  "item": "E6"
 },
 {
  "post": 1693,
  "field": "faq:4:answer",
  "from": "The only exceptions are injuries caused by",
  "to": "The exceptions include injuries caused by",
  "item": "E7"
 },
 {
  "post": 1695,
  "field": "content",
  "from": "The only exceptions are intoxication (O.C.G.A. § 34-9-17; S.C. Code § 42-9-60) and intentional self-harm.",
  "to": "Exceptions include intoxication (O.C.G.A. § 34-9-17; S.C. Code § 42-9-60) and intentional self-harm.",
  "item": "E8"
 },
 {
  "post": 1693,
  "field": "content",
  "from": "<tr>\n<td>Agricultural workers</td>\n<td>Exempt unless employer regularly employs 10+ farmworkers</td>\n<td>Exempt unless the employer elects coverage (S.C. Code §§ 42-1-360(4), 42-1-380)</td>\n</tr>\n",
  "to": "",
  "item": "F21"
 },
 {
  "post": 1677,
  "field": "content",
  "from": "<p>For injuries not on the schedule (such as back or neck injuries), benefits are determined based on the impairment rating and its effect on your earning capacity, subject to the 400-week overall cap.</p>\n",
  "to": "",
  "item": "F22"
 },
 {
  "post": 1666,
  "field": "content",
  "from": " are entitled to lifetime income benefits and typically receive",
  "to": " typically receive",
  "item": "E11"
 },
 {
  "post": 1666,
  "field": "content",
  "from": "<td>O.C.G.A. § 34-9-200.1 (lifetime benefits)</td>",
  "to": "<td>O.C.G.A. § 34-9-200.1</td>",
  "item": "E12"
 },
 {
  "post": 1666,
  "field": "faq:2:answer",
  "from": "under O.C.G.A. § 34-9-200.1 that provides lifetime benefits.",
  "to": "under O.C.G.A. § 34-9-200.1.",
  "item": "E13"
 },
 {
  "post": 1666,
  "field": "_roden_key_takeaways",
  "from": " State Board of Workers' Compensation under O.C.G.A. § 34-9-200.1, while",
  "to": " State Board of Workers' Compensation, while",
  "item": "E14"
 },
 {
  "post": 1677,
  "field": "content",
  "from": "<li><strong>Duration:</strong> PTD benefits continue for the <strong>lifetime of the injured worker</strong> for catastrophic injuries — defined as <a href=\"/practice-areas/spinal-cord-injury-lawyers/\">spinal cord injuries</a> causing paralysis, amputation of major limbs, severe <a href=\"/practice-areas/brain-injury-lawyers/\">traumatic brain injury</a>, severe burns to more than 25% of the body, or total blindness (O.C.G.A. § 34-9-200.1)</li>\n",
  "to": "",
  "item": "E15"
 },
 {
  "post": 1677,
  "field": "faq:3:answer",
  "from": "In Georgia, <strong>catastrophic injuries</strong> — spinal cord injuries causing paralysis, amputation of major limbs, severe brain injury, severe burns, or total blindness — qualify for lifetime benefits (O.C.G.A. § 34-9-200.1). ",
  "to": "",
  "item": "E16"
 },
 {
  "post": 1677,
  "field": "faq:3:answer",
  "from": " Medical benefits have no time limit in either state.",
  "to": "",
  "item": "E25"
 },
 {
  "post": 1677,
  "field": "_roden_key_takeaways",
  "from": "Georgia provides lifetime benefits for catastrophic injuries (O.C.G.A. § 34-9-200.1). Medical benefits have no time limit in either state. ",
  "to": "",
  "item": "E25"
 },
 {
  "post": 1677,
  "field": "content",
  "from": "<tr>\n<td>PTD (catastrophic)</td>\n<td>Lifetime (O.C.G.A. § 34-9-200.1)</td>\n<td>500 weeks; for life only if paraplegic, quadriplegic or physical brain damage (S.C. Code § 42-9-10(C))</td>\n</tr>\n<tr>\n<td>Medical benefits</td>\n<td>No time limit</td>\n<td>No time limit</td>\n</tr>\n",
  "to": "",
  "item": "E23"
 },
 {
  "post": 1677,
  "field": "content",
  "from": "In both Georgia and South Carolina, medical benefits generally continue <strong>as long as",
  "to": "In South Carolina, medical benefits generally continue <strong>as long as",
  "item": "E22"
 },
 {
  "post": 1677,
  "field": "content",
  "from": "<li><strong>Georgia:</strong> Medical benefits have no specific time limit. The employer/insurer must provide all reasonable and necessary medical treatment for the life of the claim (O.C.G.A. § 34-9-200). However, the insurer can request a change of condition hearing to dispute ongoing treatment.</li>\n",
  "to": "",
  "item": "E22"
 },
 {
  "post": 1677,
  "field": "faqdel",
  "from": "Do workers' comp medical benefits ever expire?",
  "to": "",
  "item": "E24"
 },
 {
  "post": 5354,
  "field": "content",
  "from": "<tr>\r\n<td>Medical benefits</td>\r\n<td colspan=\"2\">not governed by these week limits</td>\r\n</tr>\r\n",
  "to": "",
  "item": "E27"
 },
 {
  "post": 1674,
  "field": "content",
  "from": "requires employers to provide <strong>\"all medical, surgical, hospital, and other treatment\"</strong> that is",
  "to": "requires employers to provide medical, surgical, hospital, and other treatment that is",
  "item": "E28"
 },
 {
  "post": 1752,
  "field": "content",
  "from": "employers must furnish \"the employee entitled thereto medical, surgical, and hospital care and other treatment, items, and services which are prescribed by a licensed physician.\"",
  "to": "employers must furnish medical, surgical, and hospital care and other treatment, items, and services prescribed by a licensed physician.",
  "item": "E29"
 },
 {
  "post": 1674,
  "field": "faq:0:answer",
  "from": "require employers to provide all necessary medical treatment",
  "to": "require employers to provide necessary medical treatment",
  "item": "E30"
 },
 {
  "post": 1682,
  "field": "content",
  "from": " a doctor you choose if you request it within 120 days of your first income-benefit check (",
  "to": " a doctor you choose (",
  "item": "G10"
 },
 {
  "post": 1702,
  "field": "content",
  "from": " at the insurer's expense — the request must be made within 120 days of your first income-benefit check (",
  "to": " at the insurer's expense (",
  "item": "G11"
 },
 {
  "post": 1702,
  "field": "faq:5:answer",
  "from": " at the insurer's expense within 120 days of your first income-benefit check (",
  "to": " at the insurer's expense (",
  "item": "G12"
 },
 {
  "post": 4111,
  "field": "content",
  "from": "Georgia law defines an occupational disease as a disease arising out of and in the course of employment that is caused by hazards recognized as peculiar to a particular trade, occupation, or process (<a href=\"https://law.justia.com/codes/georgia/title-34/chapter-9/article-8/part-1/section-34-9-280/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 34-9-280</a>). ",
  "to": "",
  "item": "G13"
 },
 {
  "post": 4111,
  "field": "faq:2:answer",
  "from": "is a compensable occupational disease in both Georgia and South Carolina",
  "to": "is compensable in both Georgia and South Carolina",
  "item": "G14"
 },
 {
  "post": 1676,
  "field": "content",
  "from": " A child under five at the time of the malpractice has until the tenth birthday (O.C.G.A. § 9-3-73).",
  "to": "",
  "item": "E17"
 },
 {
  "post": 1676,
  "field": "faq:3:answer",
  "from": " Children under five at the time of the malpractice have until their tenth birthday (O.C.G.A. § 9-3-73).",
  "to": "",
  "item": "E18"
 },
 {
  "post": 1696,
  "field": "faq:2:answer",
  "from": "children injured before age five, who have until their tenth birthday (O.C.G.A. § 9-3-73)",
  "to": "children injured before age five (O.C.G.A. § 9-3-73)",
  "item": "E19"
 },
 {
  "post": 4195,
  "field": "content",
  "from": "In Georgia, minors generally have until their seventh birthday to file a medical malpractice claim, subject to the 5-year statute of repose (O.C.G.A. § 9-3-73). ",
  "to": "",
  "item": "E20"
 },
 {
  "post": 4195,
  "field": "faq:0:answer",
  "from": "In Georgia, minors generally have until their seventh birthday to file a medical malpractice claim (O.C.G.A. § 9-3-73), subject to the 5-year statute of repose. ",
  "to": "",
  "item": "E21"
 },
 {
  "post": 4197,
  "field": "content",
  "from": " Georgia law considers the emergency circumstances but does not lower the fundamental duty of competent care.",
  "to": "",
  "item": "E34"
 },
 {
  "post": 4363,
  "field": "content",
  "from": "<td>Same or similar specialty (O.C.G.A. Section 24-7-702)</td>",
  "to": "<td>O.C.G.A. Section 24-7-702</td>",
  "item": "E39"
 },
 {
  "post": 4173,
  "field": "faq:2:answer",
  "from": "cyclists may use the full lane, have the right of way",
  "to": "cyclists have the right of way",
  "item": "E45"
 },
 {
  "post": 1790,
  "field": "content",
  "from": " Some drivers pay the fine online without appearing in court, which O.C.G.A. § 40-13-58 treats as an admission of guilt; it is reported as a conviction.",
  "to": "",
  "item": "F23"
 },
 {
  "post": 1780,
  "field": "content",
  "from": "Slamming on the brakes when there is no reason (<a href=\"https://law.justia.com/codes/georgia/title-40/chapter-6/article-6/section-40-6-123/\">O.C.G.A. § 40-6-123(c)</a>)</li>",
  "to": "Slamming on the brakes when there is no reason</li>",
  "item": "G15"
 },
 {
  "post": 4162,
  "field": "content",
  "from": "<a href=\"https://law.justia.com/codes/georgia/title-40/chapter-6/article-10/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 40-6-188</a> doubles fines for speeding in active work zones when workers are present. Georgia law also authorizes",
  "to": "Georgia law authorizes",
  "item": "G16"
 },
 {
  "post": 4162,
  "field": "faqdel",
  "from": "Are fines doubled in Georgia construction zones?",
  "to": "",
  "item": "G17"
 },
 {
  "post": 4683,
  "field": "content",
  "from": "Work zone speed violations:</strong> Georgia law doubles fines for speeding in active construction zones, and work zone speeding can be used",
  "to": "Work zone speed violations:</strong> Work zone speeding can be used",
  "item": "G18"
 },
 {
  "post": 1799,
  "field": "content",
  "from": " Also, speeding is expensive because tickets are usually doubled in construction zones.",
  "to": "",
  "item": "G19"
 },
 {
  "post": 4163,
  "field": "content",
  "from": "Georgia:</strong> The <a href=\"https://law.justia.com/codes/georgia/title-31/chapter-8/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 31-8-1 et seq.</a> (Georgia Long-Term Care Facility Licensing Act) establishes licensing standards and a resident bill of rights. ",
  "to": "Georgia:</strong> ",
  "item": "E47"
 },
 {
  "post": 4164,
  "field": "content",
  "from": "Georgia's nursing home licensing requirements under <a href=\"https://law.justia.com/codes/georgia/title-31/chapter-8/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 31-8-1 et seq.</a> mandate minimum standards of care and staffing. ",
  "to": "",
  "item": "E48"
 },
 {
  "post": 4165,
  "field": "content",
  "from": "Georgia:</strong> <a href=\"https://law.justia.com/codes/georgia/title-31/chapter-8/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 31-8-1 et seq.</a> requires licensed facilities to maintain proper medication administration procedures and qualified nursing staff. The Georgia Board of Pharmacy and Board of Nursing set additional standards.",
  "to": "Georgia:</strong> The Georgia Board of Pharmacy and Board of Nursing set standards.",
  "item": "E49"
 },
 {
  "post": 4166,
  "field": "content",
  "from": " Additionally, <a href=\"https://law.justia.com/codes/georgia/title-31/chapter-8/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 31-8-1 et seq.</a> provides a regulatory framework for nursing home accountability.",
  "to": "",
  "item": "E51"
 },
 {
  "post": 4168,
  "field": "content",
  "from": "Georgia categorizes ALFs as \"personal care homes\" and requires licensing",
  "to": "Georgia requires licensing",
  "item": "E52"
 },
 {
  "post": 4117,
  "field": "content",
  "from": "to maintain proper enclosures, use leashes, and carry liability insurance.",
  "to": "to maintain proper enclosures.",
  "item": "E53"
 },
 {
  "post": 4119,
  "field": "content",
  "from": "establishes two classifications for aggressive dogs:</p>\n<ul>\n<li><strong>Dangerous dog:</strong> A dog that causes a substantial puncture wound, aggressively attacks in a manner that causes injury, or has been classified as potentially dangerous and exhibits continued dangerous behavior</li>\n<li><strong>Vicious dog:</strong> A dog that inflicts serious injury on a human or kills a human, without provocation</li>\n</ul>",
  "to": "establishes two classifications for aggressive dogs: \"dangerous\" and \"vicious.\"</p>",
  "item": "E54-55"
 },
 {
  "post": 4119,
  "field": "content",
  "from": "must maintain a proper enclosure, post warning signs, maintain $50,000 in liability insurance or a surety bond, and keep the dog muzzled and leashed when off the owner's property.",
  "to": "must maintain a proper enclosure and post warning signs.",
  "item": "E56"
 },
 {
  "post": 4120,
  "field": "content",
  "from": " Georgia's Responsible Dog Ownership Law (<a href=\"https://law.justia.com/codes/georgia/title-4/chapter-8/article-2/\" target=\"_blank\" rel=\"noopener\">O.C.G.A. § 4-8-20 et seq.</a>) also applies, as aggressive behavior toward other animals is a factor in classifying a dog as \"dangerous.\"",
  "to": "",
  "item": "E57"
 },
 {
  "post": 4116,
  "field": "content",
  "from": "\"next friend,\" and any settlement must be approved by the court to protect the child's interests.",
  "to": "\"next friend.\"",
  "item": "G29"
 },
 {
  "post": 4207,
  "field": "content",
  "from": " mandates that any youth athlete suspected of sustaining a concussion must be immediately removed from play and prohibited from returning until cleared in writing by a qualified healthcare provider. The law applies to all youth athletic activities organized by schools and youth sports organizations.",
  "to": " is Georgia's youth-athlete concussion law.",
  "item": "G20-21"
 },
 {
  "post": 4207,
  "field": "content",
  "from": " Coaches and organizations that violate these laws bear direct liability for resulting brain injuries.",
  "to": "",
  "item": "G22"
 },
 {
  "post": 4207,
  "field": "content",
  "from": "<p>Violation of these statutes constitutes negligence per se — automatic proof of negligence — in a lawsuit for second impact syndrome injuries.</p>\n",
  "to": "",
  "item": "G22"
 },
 {
  "post": 4207,
  "field": "faqdel",
  "from": "Can I sue a coach for returning my child to play after a concussion?",
  "to": "",
  "item": "G22"
 },
 {
  "post": 4205,
  "field": "content",
  "from": " requires youth sports organizations and schools to provide concussion information to athletes and parents, remove from play any athlete suspected of sustaining a concussion, and require written clearance from a licensed healthcare provider before the athlete can return to play. Failure to comply with these requirements can serve as evidence of negligence.",
  "to": " is Georgia's youth-athlete concussion law.",
  "item": "G23-24"
 },
 {
  "post": 4205,
  "field": "faq:2:answer",
  "from": "Georgia's Return to Play Act (O.C.G.A. § 20-2-324.1) requires youth sports organizations to educate athletes and parents about concussions, remove athletes suspected of having a concussion, and require medical clearance before return to play. Violations support negligence claims.",
  "to": "Georgia's Return to Play Act (O.C.G.A. § 20-2-324.1) is Georgia's youth-athlete concussion law.",
  "item": "G24"
 },
 {
  "post": 4144,
  "field": "content",
  "from": "Penalties include fines, jail time, and mandatory boater safety courses.",
  "to": "Penalties include fines and jail time.",
  "item": "G25"
 },
 {
  "post": 4144,
  "field": "faq:3:answer",
  "from": "fines up to $1,000, up to 12 months in jail, and mandatory completion of a boater safety course",
  "to": "fines up to $1,000 and up to 12 months in jail",
  "item": "G26"
 },
 {
  "post": 3616,
  "field": "faq:7:answer",
  "from": "near other vessels and swimmers, prohibits operation after sunset, and requires operators born after January 1, 1998 to complete a boating safety course",
  "to": "near other vessels and swimmers and prohibits operation after sunset",
  "item": "G27"
 },
 {
  "post": 4895,
  "field": "faq:7:answer",
  "from": "cerca de otras embarcaciones y de nadadores, prohíbe operarlas después de la puesta del sol y exige que los operadores nacidos después del 1 de enero de 1998 completen un curso de seguridad náutica",
  "to": "cerca de otras embarcaciones y de nadadores y prohíbe operarlas después de la puesta del sol",
  "item": "G28"
 }
]

EDITS
, true );
if ( ! is_array( $edits ) ) { fwrite( STDERR, "ABORT: edit table did not parse\n" ); exit( 1 ); }

function surface_of( $field ) {
	return ( 0 === strpos( $field, 'faq:' ) || 'faqdel' === $field ) ? '_roden_faqs' : $field;
}
$work = array(); $orig = array();
foreach ( $edits as $e ) {
	$p = $e['post'];
	if ( ! isset( $work[ $p ] ) ) {
		$post = get_post( $p );
		if ( ! $post || 'publish' !== $post->post_status ) { fwrite( STDERR, "ABORT: $p missing or not published\n" ); exit( 1 ); }
		$work[ $p ] = array( 'content' => $post->post_content );
		$orig[ $p ] = array( 'content' => $post->post_content );
	}
	$surface = surface_of( $e['field'] );
	if ( ! isset( $work[ $p ][ $surface ] ) ) {
		$v = get_post_meta( $p, $surface, true );
		if ( '' === $v || null === $v ) { fwrite( STDERR, "ABORT: $p has no $surface\n" ); exit( 1 ); }
		$work[ $p ][ $surface ] = $v; $orig[ $p ][ $surface ] = $v;
	}
}
$fail = 0; $log = array();
// Pass 1: string edits.
foreach ( $edits as $e ) {
	if ( 'faqdel' === $e['field'] ) continue;
	$p = $e['post'];
	if ( 0 === strpos( $e['field'], 'faq:' ) ) {
		list( , $i, $k ) = explode( ':', $e['field'] );
		$s = isset( $work[ $p ]['_roden_faqs'][ $i ][ $k ] ) ? $work[ $p ]['_roden_faqs'][ $i ][ $k ] : null;
	} else {
		$s = $work[ $p ][ $e['field'] ];
	}
	$n = is_string( $s ) ? substr_count( $s, $e['from'] ) : -1;
	if ( 1 !== $n ) { fwrite( STDERR, "MISMATCH {$e['item']} $p {$e['field']}: matched $n\n" ); $fail++; continue; }
	$s = str_replace( $e['from'], $e['to'], $s );
	if ( 0 === strpos( $e['field'], 'faq:' ) ) { $work[ $p ]['_roden_faqs'][ $i ][ $k ] = $s; } else { $work[ $p ][ $e['field'] ] = $s; }
	$log[] = array( 'item' => $e['item'], 'post' => $p, 'field' => $e['field'], 'from' => $e['from'], 'to' => $e['to'] );
	fwrite( STDERR, ( $apply ? 'fixing' : 'would fix' ) . " {$e['item']} $p {$e['field']}\n" );
}
// Pass 2: FAQ removals by exact question.
foreach ( $edits as $e ) {
	if ( 'faqdel' !== $e['field'] ) continue;
	$p = $e['post']; $hits = array();
	foreach ( $work[ $p ]['_roden_faqs'] as $i => $f ) { if ( isset( $f['question'] ) && $f['question'] === $e['from'] ) $hits[] = $i; }
	if ( 1 !== count( $hits ) ) { fwrite( STDERR, "MISMATCH {$e['item']} $p faqdel: matched " . count( $hits ) . "\n" ); $fail++; continue; }
	$removed = $work[ $p ]['_roden_faqs'][ $hits[0] ];
	array_splice( $work[ $p ]['_roden_faqs'], $hits[0], 1 );
	$log[] = array( 'item' => $e['item'], 'post' => $p, 'field' => 'faqdel:' . $hits[0], 'from' => $removed, 'to' => null );
	fwrite( STDERR, ( $apply ? 'removing' : 'would remove' ) . " {$e['item']} $p FAQ {$hits[0]}\n" );
}
if ( $fail ) { fwrite( STDERR, "ABORT: $fail mismatches, nothing written\n" ); exit( 1 ); }

$out = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'edits' => $log, 'before' => $orig );
if ( $apply ) {
	global $wpdb; $now = gmdate( 'Y-m-d H:i:s' );
	foreach ( $work as $p => $surfaces ) {
		foreach ( $surfaces as $key => $val ) {
			if ( $val === $orig[ $p ][ $key ] ) continue;
			if ( 'content' === $key ) {
				$r = wp_update_post( wp_slash( array( 'ID' => $p, 'post_content' => $val ) ), true );
				if ( is_wp_error( $r ) ) { fwrite( STDERR, "FAILED write $p content: " . $r->get_error_message() . "\n" ); exit( 1 ); }
			} else {
				update_post_meta( $p, $key, wp_slash( $val ) );
			}
		}
		update_post_meta( $p, '_roden_content_modified', wp_slash( $now ) );
		clean_post_cache( $p ); wp_cache_delete( $p, 'post_meta' );
		foreach ( $surfaces as $key => $val ) {
			if ( 'content' === $key ) {
				$back = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $p ) );
			} else {
				$raw  = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s", $p, $key ) );
				$back = maybe_unserialize( $raw );
			}
			if ( $back !== $val ) { fwrite( STDERR, "FAILED read-back $p $key\n" ); exit( 1 ); }
		}
		fwrite( STDERR, "read-back OK $p\n" );
	}
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
