<?php
/**
 * Seeder: 8 Dog Bite Sub-Type Pages
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-dog-bite-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: dog-bite-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'dog-bite-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'dog-bite-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "dog-bite-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'dog-bites', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Dog Bites', 'practice_category', array( 'slug' => 'dog-bites' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Severe Dog Bite Injury
       ============================================================ */
    array(
        'title'   => 'Severe Dog Bite Injury Lawyers',
        'slug'    => 'severe-dog-bite-injury',
        'excerpt' => 'Suffered a severe dog bite causing disfigurement, nerve damage, or infection in Georgia or South Carolina? Our attorneys fight for maximum compensation for catastrophic dog attack injuries.',
        'content' => <<<'HTML'
<h2>Legal Representation for Severe Dog Bite Injuries</h2>
<p>Dog bites can cause far more than minor puncture wounds. Severe dog attacks frequently result in catastrophic injuries including deep lacerations, crushed bones, permanent nerve damage, disfiguring scars, and life-threatening infections. According to the <a href="https://www.cdc.gov/dog-bites/" target="_blank" rel="noopener">Centers for Disease Control and Prevention (CDC)</a>, approximately 4.5 million people are bitten by dogs in the United States each year, with roughly 800,000 requiring medical attention. Of those, tens of thousands require emergency room treatment for serious injuries, and dozens of deaths occur annually from dog attacks.</p>
<p>At Roden Law, our severe dog bite injury lawyers represent victims across Georgia and South Carolina who have suffered life-altering injuries from dog attacks. We pursue full compensation from dog owners, property owners, and insurance companies to cover the extensive medical treatment, reconstructive surgery, and long-term care these injuries demand.</p>

<h2>Georgia Dog Bite Liability Law</h2>
<p>Georgia's dog bite statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-2/article-1/section-51-2-7/" target="_blank" rel="noopener">O.C.G.A. § 51-2-7</a>) imposes liability on a dog owner when the dog was vicious or dangerous, the owner knew or should have known of the dog's dangerous propensity, and the owner carelessly managed the dog or allowed it to go at liberty. Georgia also applies the Responsible Dog Ownership Law (<a href="https://law.justia.com/codes/georgia/title-4/chapter-8/article-2/" target="_blank" rel="noopener">O.C.G.A. § 4-8-20 et seq.</a>), which classifies dogs as "dangerous" or "vicious" based on prior behavior and imposes specific requirements on owners of such animals.</p>

<h2>South Carolina Dog Bite Liability Law</h2>
<p>South Carolina applies a strict liability standard for dog bites under <a href="https://www.scstatehouse.gov/code/t47c003.php" target="_blank" rel="noopener">S.C. Code § 47-3-110</a>. A dog owner is liable for injuries when the person bitten was in a public place or was lawfully on private property (including by implied invitation). Unlike Georgia, South Carolina does not require the victim to prove the owner knew the dog was dangerous — liability attaches regardless of the dog's prior history.</p>

<h2>Types of Severe Dog Bite Injuries</h2>
<p>Severe dog attacks cause injuries requiring extensive medical treatment and often multiple surgeries:</p>
<ul>
<li><strong>Deep lacerations and tissue loss:</strong> Large dogs can exert over 300 pounds of bite force, tearing through skin, muscle, and tendons</li>
<li><strong>Crushed and broken bones:</strong> Particularly in the hands, arms, and facial bones</li>
<li><strong>Nerve damage:</strong> Severed or damaged nerves causing loss of sensation or motor function</li>
<li><strong>Disfiguring facial scars:</strong> Requiring multiple rounds of reconstructive and plastic surgery</li>
<li><strong>Infections:</strong> Dog bites carry bacteria including Pasteurella, Staphylococcus, and Capnocytophaga, which can cause sepsis, cellulitis, and osteomyelitis</li>
<li><strong><a href="/practice-areas/brain-injury-lawyers/">Traumatic brain injuries</a>:</strong> When victims are knocked down and strike their heads during an attack</li>
<li><strong>Psychological trauma:</strong> Post-traumatic stress disorder (PTSD), anxiety, and phobias</li>
</ul>

<h2>Damages in Severe Dog Bite Cases</h2>
<p>Victims of severe dog bite injuries may recover compensation for emergency medical treatment and hospitalization, reconstructive and plastic surgery costs, ongoing physical therapy and rehabilitation, lost wages during recovery, permanent scarring and disfigurement, pain and suffering, emotional distress and psychological treatment, and diminished quality of life. In cases where the dog owner knew the animal was dangerous and failed to take precautions, punitive damages may be available in both Georgia and South Carolina.</p>

<h2>Insurance Coverage for Dog Bite Claims</h2>
<p>Most dog bite claims are covered under the dog owner's homeowners or renters insurance policy. According to the <a href="https://www.iii.org/fact-statistic/facts-statistics-homeowners-and-renters-insurance" target="_blank" rel="noopener">Insurance Information Institute</a>, dog bite claims account for over one-third of all homeowners insurance liability payouts. When the dog owner is a renter or lacks adequate insurance, <a href="/dog-bite-lawyers/landlord-liability-dog-attack/">landlord liability</a> and other sources of coverage may be available. Our attorneys identify every insurance policy that may apply to maximize your recovery.</p>

<h2>Why Choose Roden Law for Severe Dog Bite Cases</h2>
<p>Our attorneys have extensive experience handling catastrophic dog bite cases throughout Georgia and South Carolina. We work with medical experts, plastic surgeons, and mental health professionals to fully document the scope of your injuries and future treatment needs. We handle your case on a contingency fee basis — no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What makes a dog bite injury "severe" for legal purposes?',
                'answer'   => 'Severe dog bite injuries include deep lacerations, broken bones, nerve damage, disfigurement requiring reconstructive surgery, serious infections, and psychological trauma. These injuries typically require emergency medical care and extensive follow-up treatment.',
            ),
            array(
                'question' => 'Does the dog owner\'s homeowners insurance cover severe dog bites?',
                'answer'   => 'Yes, in most cases. Homeowners and renters insurance policies typically include liability coverage for dog bite injuries. However, some policies exclude certain breeds or dogs with prior bite histories. Our attorneys investigate all available coverage.',
            ),
            array(
                'question' => 'Can I recover damages for scarring and disfigurement from a dog bite?',
                'answer'   => 'Yes. Permanent scarring and disfigurement are significant components of dog bite damages. Courts consider the visibility of the scars, the victim\'s age, the impact on quality of life, and the cost of past and future reconstructive surgery.',
            ),
            array(
                'question' => 'What is the statute of limitations for a severe dog bite claim?',
                'answer'   => 'In Georgia, you have 2 years from the date of the dog bite to file a personal injury lawsuit (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530).',
            ),
            array(
                'question' => 'Are punitive damages available in dog bite cases?',
                'answer'   => 'Yes, when the dog owner knew the animal was dangerous and failed to take reasonable precautions. Georgia caps punitive damages at $250,000 in most cases (O.C.G.A. § 51-12-5.1). South Carolina allows punitive damages with clear and convincing evidence of reckless conduct.',
            ),
        ),
    ),

    /* ============================================================
       2. Child Dog Bite
       ============================================================ */
    array(
        'title'   => 'Child Dog Bite Lawyers',
        'slug'    => 'child-dog-bite',
        'excerpt' => 'Is your child a victim of a dog bite in Georgia or South Carolina? Our attorneys pursue maximum compensation for children injured in dog attacks, including medical costs, scarring, and emotional trauma.',
        'content' => <<<'HTML'
<h2>Protecting Children Injured by Dog Bites</h2>
<p>Children are the most frequent victims of dog bites and suffer the most severe injuries. The <a href="https://www.cdc.gov/dog-bites/" target="_blank" rel="noopener">Centers for Disease Control and Prevention (CDC)</a> reports that children between the ages of 5 and 9 have the highest rate of dog bite injuries, and children are far more likely than adults to require medical treatment — including emergency room visits, hospitalization, and reconstructive surgery. Because of their small stature, children are often bitten on the face, head, and neck, resulting in devastating injuries and permanent scarring.</p>
<p>At Roden Law, our child dog bite lawyers understand the unique physical, emotional, and legal dimensions of these cases. We fight to ensure young victims receive the medical care and compensation they need for recovery, including coverage for future surgeries as the child grows.</p>

<h2>Why Children Are at Greater Risk</h2>
<p>Several factors make children uniquely vulnerable to dog bites and dog attacks:</p>
<ul>
<li><strong>Eye-level exposure:</strong> Young children's faces are at the same height as many dogs, increasing the risk of facial bites</li>
<li><strong>Unpredictable behavior:</strong> Children may pull ears, step on tails, or approach dogs during feeding, unknowingly triggering defensive or aggressive reactions</li>
<li><strong>Inability to read warning signs:</strong> Young children cannot recognize growling, bared teeth, and other pre-attack signals</li>
<li><strong>Smaller body size:</strong> Children suffer proportionally greater injuries because a dog's bite force impacts a smaller body</li>
<li><strong>Familiarity with the dog:</strong> Most child dog bites involve a dog known to the family — a family pet, neighbor's dog, or relative's animal</li>
</ul>

<h2>Georgia and South Carolina Laws Protecting Child Bite Victims</h2>
<p>Georgia's dog bite statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-2/article-1/section-51-2-7/" target="_blank" rel="noopener">O.C.G.A. § 51-2-7</a>) does not distinguish between adult and child victims, but courts recognize that children cannot be held to the same standard of care as adults. A defense of provocation or trespassing is much harder to sustain against a young child who did not understand the risk. South Carolina's strict liability statute (<a href="https://www.scstatehouse.gov/code/t47c003.php" target="_blank" rel="noopener">S.C. Code § 47-3-110</a>) imposes liability on the dog owner without requiring proof of prior dangerous propensity, providing strong protection for child victims.</p>
<p>Both states also have special procedural rules for lawsuits involving minors. A parent or legal guardian must bring the claim on the child's behalf as "next friend," and any settlement must be approved by the court to protect the child's interests. Georgia law (O.C.G.A. § 29-3-3) and South Carolina law (S.C. Code § 62-5-433) require judicial approval of minor settlements exceeding certain thresholds.</p>

<h2>Long-Term Impacts of Child Dog Bite Injuries</h2>
<p>Child dog bite injuries often have consequences extending far into adulthood:</p>
<ul>
<li><strong>Facial scarring:</strong> Scars on a child's face grow and change as the child develops, often requiring multiple revision surgeries over the years</li>
<li><strong>Psychological trauma:</strong> Children frequently develop PTSD, severe anxiety around animals, nightmares, and behavioral changes after a dog attack</li>
<li><strong>Nerve damage:</strong> Bites to the hands and face can damage developing nerves, affecting sensation and motor function</li>
<li><strong>Infection risk:</strong> Children's developing immune systems are more susceptible to bacterial infections from dog bites</li>
<li><strong>Social and developmental impact:</strong> Visible scarring and trauma can affect a child's social development, self-esteem, and school performance</li>
</ul>

<h2>Damages in Child Dog Bite Cases</h2>
<p>Compensation in child dog bite cases accounts for both current and future impacts, including emergency medical care and hospitalization, current and future reconstructive surgeries, psychological counseling and therapy, pain and suffering, future medical costs as the child grows, and impact on the child's quality of life. Courts in both Georgia and South Carolina give significant weight to the long-term impact of disfiguring injuries on a child's future.</p>

<h2>Why Choose Roden Law for Child Dog Bite Cases</h2>
<p>Our attorneys handle child dog bite cases with both compassion and aggressive advocacy. We work with pediatric plastic surgeons, child psychologists, and life care planners to document the full scope of the child's injuries and future needs. We also ensure court-approved settlements are structured to protect the child's financial interests until adulthood. There is no fee unless we win your child's case.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue if my child was bitten by a neighbor\'s dog?',
                'answer'   => 'Yes. Dog owners are liable for bite injuries under Georgia law (O.C.G.A. § 51-2-7) and South Carolina\'s strict liability statute (S.C. Code § 47-3-110). The claim is typically filed against the dog owner\'s homeowners or renters insurance policy.',
            ),
            array(
                'question' => 'What if my child provoked the dog before being bitten?',
                'answer'   => 'Courts apply a much lower standard of care to children. A young child who pulled a dog\'s tail or ears is generally not considered to have "provoked" the dog in a legally meaningful way, especially if the child was too young to understand the risk.',
            ),
            array(
                'question' => 'How are child dog bite settlements handled in court?',
                'answer'   => 'In both Georgia and South Carolina, settlements for minor children must be approved by a judge to ensure they are fair and in the child\'s best interest. Settlement funds are typically held in a protected account until the child reaches 18.',
            ),
            array(
                'question' => 'Can I recover damages for my child\'s future surgeries?',
                'answer'   => 'Yes. Children often need multiple reconstructive surgeries as they grow. Expert medical testimony can establish the anticipated future procedures and costs, which are included in the damages claim.',
            ),
            array(
                'question' => 'What is the statute of limitations for a child dog bite claim?',
                'answer'   => 'In Georgia, the 2-year statute of limitations is tolled (paused) for minors until the child turns 18 (O.C.G.A. § 9-3-90). In South Carolina, the 3-year limitation period is similarly tolled during minority. However, filing promptly preserves evidence and improves case outcomes.',
            ),
        ),
    ),

    /* ============================================================
       3. Dog Attack on Jogger and Cyclist
       ============================================================ */
    array(
        'title'   => 'Dog Attack on Jogger and Cyclist Lawyers',
        'slug'    => 'dog-attack-jogger-cyclist',
        'excerpt' => 'Attacked by a dog while jogging, running, or cycling in Georgia or South Carolina? Our attorneys hold negligent dog owners accountable and fight for full compensation for your injuries.',
        'content' => <<<'HTML'
<h2>Dog Attacks on Joggers, Runners, and Cyclists</h2>
<p>Joggers, runners, and cyclists are particularly vulnerable to dog attacks. A dog's natural prey drive is triggered by fast-moving targets, making people exercising outdoors frequent targets for aggressive pursuit and attack. According to the <a href="https://www.avma.org/resources-tools/pet-owners/dog-bite-prevention" target="_blank" rel="noopener">American Veterinary Medical Association (AVMA)</a>, dogs are more likely to chase and bite people who are running or cycling because the rapid movement activates instinctive chasing behavior. Joggers and cyclists often suffer compounded injuries — not only from the bite itself but from falling, being knocked off a bicycle, or running into traffic while trying to escape the attack.</p>
<p>At Roden Law, our attorneys represent joggers, runners, and cyclists across Georgia and South Carolina who have been injured by aggressive dogs. We pursue full compensation from dog owners and, where applicable, from property owners and landlords who allowed dangerous dogs to roam freely.</p>

<h2>Georgia and South Carolina Leash and Containment Laws</h2>
<p>Both Georgia and South Carolina have laws requiring dog owners to maintain control of their animals. Georgia's Responsible Dog Ownership Law (<a href="https://law.justia.com/codes/georgia/title-4/chapter-8/article-2/" target="_blank" rel="noopener">O.C.G.A. § 4-8-20 et seq.</a>) requires owners of classified "dangerous dogs" and "vicious dogs" to maintain proper enclosures, use leashes, and carry liability insurance. Many Georgia municipalities — including Savannah, Augusta, and Athens — have enacted local leash ordinances requiring all dogs to be leashed or contained when off the owner's property.</p>
<p>South Carolina imposes strict liability for dog bites under <a href="https://www.scstatehouse.gov/code/t47c003.php" target="_blank" rel="noopener">S.C. Code § 47-3-110</a> when the victim is attacked in a public place. Municipalities including Charleston, Columbia, and Myrtle Beach maintain local leash laws requiring dogs to be leashed or under voice control in public areas. Violation of a leash law is strong evidence of negligence in a dog attack case.</p>

<h2>Common Injuries in Dog Attacks on Joggers and Cyclists</h2>
<p>Dog attacks on exercising individuals often cause multiple types of injuries simultaneously:</p>
<ul>
<li><strong>Bite wounds:</strong> Punctures, lacerations, and tissue avulsions to the legs, arms, hands, and face</li>
<li><strong>Fall injuries:</strong> Broken bones, head injuries, and road rash from being knocked down or falling off a bicycle</li>
<li><strong><a href="/practice-areas/brain-injury-lawyers/concussion-mild-tbi/">Concussions</a>:</strong> Traumatic brain injury from striking the ground, particularly for cyclists without helmets</li>
<li><strong>Orthopedic injuries:</strong> Fractures of the wrist, hip, shoulder, or collarbone from impact with the ground</li>
<li><strong>Vehicle-related injuries:</strong> Victims who run or swerve into traffic may be struck by vehicles, creating additional <a href="/practice-areas/pedestrian-accident-lawyers/">pedestrian accident claims</a></li>
<li><strong>Infection:</strong> Dog bite wounds are highly prone to bacterial infection requiring antibiotic treatment or surgery</li>
</ul>

<h2>Establishing Liability for Dog Attacks on Exercisers</h2>
<p>Dog owners sometimes claim that joggers or cyclists "provoked" the attack by running past the dog. Georgia and South Carolina courts reject this defense — lawfully exercising in a public area is not provocation. Under Georgia law (O.C.G.A. § 51-2-7), the owner is liable if the dog was known to be dangerous and was carelessly managed. Under South Carolina's strict liability statute (S.C. Code § 47-3-110), the owner is liable regardless of prior knowledge if the attack occurred in a public place.</p>
<p>When a dog escapes a yard or runs off a property to attack a jogger or cyclist, evidence of inadequate fencing, broken gates, missing leashes, and prior escape incidents strengthens the claim. We also investigate whether the dog had prior complaints filed with animal control, which establishes the owner's knowledge of the danger.</p>

<h2>Damages for Jogger and Cyclist Dog Attack Victims</h2>
<p>Victims may recover compensation for all medical treatment including emergency care, surgery, and rehabilitation, lost wages during recovery, replacement or repair of damaged bicycles and equipment, pain and suffering, scarring and disfigurement, and emotional distress including fear of dogs and reluctance to exercise outdoors. When the attack causes permanent disability or ongoing limitations on physical activity, our attorneys work with medical experts to document the long-term impact on quality of life.</p>

<h2>Why Choose Roden Law for Jogger and Cyclist Dog Attack Cases</h2>
<p>Our attorneys serve joggers, runners, and cyclists throughout Georgia and South Carolina — from the <a href="/pedestrian-accident-lawyers/jogger-runner-accident/">urban trails of Savannah and Charleston</a> to rural roads and neighborhood streets. We investigate each attack thoroughly, identify all sources of liability and insurance coverage, and pursue maximum compensation. There is no fee unless we win your case.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Is running past a dog considered provocation under Georgia or South Carolina law?',
                'answer'   => 'No. Lawfully exercising in a public area — jogging, running, or cycling — is not legally considered provocation. Dog owners are responsible for controlling their animals regardless of whether someone is exercising nearby.',
            ),
            array(
                'question' => 'Can I sue if a dog chased me and I was injured falling, even though I wasn\'t bitten?',
                'answer'   => 'Yes. You do not need to be actually bitten to have a claim. If a dog\'s aggressive behavior — chasing, lunging, or jumping — caused you to fall and suffer injuries, the dog owner can be held liable for those injuries.',
            ),
            array(
                'question' => 'What if the dog that attacked me was running loose without a leash?',
                'answer'   => 'A <a href="/dog-bite-lawyers/loose-unleashed-dog-attack/">loose or unleashed dog</a> that attacks a jogger or cyclist is strong evidence of owner negligence. Violation of local leash laws constitutes negligence per se in many jurisdictions, making it easier to establish liability.',
            ),
            array(
                'question' => 'Can I recover the cost of my damaged bicycle after a dog attack?',
                'answer'   => 'Yes. Property damage — including damage to your bicycle, helmet, clothing, and electronics — is a recoverable component of your personal injury claim against the dog owner.',
            ),
            array(
                'question' => 'What should I do after a dog attack while jogging or cycling?',
                'answer'   => 'Call 911 and seek immediate medical attention. Photograph your injuries and the location. Try to identify the dog and its owner. Report the attack to local animal control. Obtain contact information from any witnesses. Then contact an attorney before speaking with insurance companies.',
            ),
        ),
    ),

    /* ============================================================
       4. Loose or Unleashed Dog Attack
       ============================================================ */
    array(
        'title'   => 'Loose or Unleashed Dog Attack Lawyers',
        'slug'    => 'loose-unleashed-dog-attack',
        'excerpt' => 'Attacked by a loose or unleashed dog in Georgia or South Carolina? Our attorneys hold negligent owners accountable for failing to contain their dogs and fight for full compensation.',
        'content' => <<<'HTML'
<h2>Accountability for Loose and Unleashed Dog Attacks</h2>
<p>When dog owners allow their animals to roam freely — whether through broken fences, open gates, missing leashes, or simple carelessness — innocent people pay the price. Loose dogs are responsible for a disproportionate share of serious bite injuries, as they are more likely to be unsupervised, stressed, and aggressive when encountering strangers. The <a href="https://www.cdc.gov/dog-bites/" target="_blank" rel="noopener">Centers for Disease Control and Prevention (CDC)</a> identifies loose and unrestrained dogs as a primary risk factor for dog bite injuries, with roaming dogs posing danger to pedestrians, children playing outdoors, delivery workers, and other pets.</p>
<p>At Roden Law, our loose dog attack attorneys represent victims throughout Georgia and South Carolina. We investigate how the dog escaped containment, whether the owner had prior notice of the dog's behavior, and whether local leash and containment laws were violated — building the strongest possible case for maximum compensation.</p>

<h2>Leash Laws in Georgia and South Carolina</h2>
<p>While Georgia does not have a statewide leash law, the state's Responsible Dog Ownership Law (<a href="https://law.justia.com/codes/georgia/title-4/chapter-8/article-2/" target="_blank" rel="noopener">O.C.G.A. § 4-8-20 et seq.</a>) imposes strict containment requirements on owners of classified dangerous and vicious dogs. Most Georgia municipalities — including Savannah (City Code § 5-1-5), Darien, and surrounding communities — have enacted local leash ordinances requiring all dogs to be leashed or confined when off the owner's property.</p>
<p>South Carolina also lacks a statewide leash law but provides strict liability for dog bites in public places under <a href="https://www.scstatehouse.gov/code/t47c003.php" target="_blank" rel="noopener">S.C. Code § 47-3-110</a>. Major South Carolina cities including Charleston, Columbia, and Myrtle Beach maintain local leash ordinances. Violation of these local laws constitutes negligence per se — meaning the owner is automatically considered negligent — making it significantly easier to establish liability in a dog bite case.</p>

<h2>How Dogs Escape Containment</h2>
<p>Our investigations frequently reveal a pattern of owner negligence that allowed the dog to escape:</p>
<ul>
<li><strong>Broken or inadequate fencing:</strong> Fences with gaps, holes, or sections too short to contain the dog</li>
<li><strong>Open or unlocked gates:</strong> Gates left open by residents, visitors, or service workers</li>
<li><strong>Failure to leash:</strong> Dogs allowed outdoors without a leash or left tied to inadequate tethers that break</li>
<li><strong>Open doors and windows:</strong> Dogs escaping through unsecured entry points</li>
<li><strong>Previous escapes ignored:</strong> History of the dog getting loose without the owner taking corrective action</li>
<li><strong>Inadequate containment for dog's size and strength:</strong> Lightweight chains, thin leashes, or flimsy enclosures unsuitable for large, powerful dogs</li>
</ul>

<h2>Establishing Liability for Loose Dog Attacks</h2>
<p>Under Georgia law (O.C.G.A. § 51-2-7), proving a loose dog attack claim requires showing the dog was dangerous or vicious, the owner knew or should have known of the danger, and the owner carelessly managed the dog or allowed it to go at liberty. Evidence of prior escapes, animal control complaints, and leash law violations all support these elements.</p>
<p>South Carolina's strict liability statute (S.C. Code § 47-3-110) provides a more direct path to recovery — the owner is liable for any attack in a public place regardless of prior knowledge of the dog's dangerousness. For attacks on private property, the victim must show they were lawfully present (including by implied invitation, such as delivery workers, mail carriers, and invited guests).</p>

<h2>Injuries from Loose Dog Attacks</h2>
<p>Attacks by loose, unsupervised dogs tend to be more severe because there is no owner present to intervene. Common injuries include severe bite wounds and tissue avulsion, multiple bite sites from sustained attacks, <a href="/dog-bite-lawyers/severe-dog-bite-injury/">disfiguring injuries</a> to the face and extremities, broken bones from being knocked down, and psychological trauma including PTSD. <a href="/dog-bite-lawyers/child-dog-bite/">Children</a> and elderly individuals are particularly vulnerable to serious injury from loose dog attacks.</p>

<h2>Additional Liable Parties</h2>
<p>Beyond the dog owner, other parties may share liability for a loose dog attack. <a href="/dog-bite-lawyers/landlord-liability-dog-attack/">Landlords</a> who knew a tenant's dog was dangerous and failed to require containment measures may be liable. Homeowners' associations that failed to enforce pet policies, dog walkers or pet sitters who lost control of the animal, and property managers responsible for maintaining fencing and gates may also bear responsibility. Our attorneys investigate all potential sources of liability and insurance coverage.</p>

<h2>Why Choose Roden Law for Loose Dog Attack Cases</h2>
<p>Our attorneys have deep experience investigating and litigating loose dog attack cases throughout Georgia and South Carolina. We obtain animal control records, prior complaint histories, and evidence of leash law violations to build compelling cases. We handle your claim on a contingency fee basis — no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Does Georgia have a leash law?',
                'answer'   => 'Georgia does not have a statewide leash law, but most municipalities — including Savannah, Augusta, and Athens — have local leash ordinances. The state\'s Responsible Dog Ownership Law (O.C.G.A. § 4-8-20 et seq.) also imposes strict containment requirements on dangerous and vicious dogs.',
            ),
            array(
                'question' => 'Is a dog owner automatically liable if their dog was off-leash?',
                'answer'   => 'In South Carolina, the owner is strictly liable for a dog bite in a public place under S.C. Code § 47-3-110, regardless of whether the dog was leashed. In Georgia, violation of a local leash law constitutes negligence per se, which significantly strengthens the victim\'s case.',
            ),
            array(
                'question' => 'What if the dog has escaped before and the owner did nothing?',
                'answer'   => 'A history of prior escapes is powerful evidence that the owner knew the dog was a flight risk and failed to take adequate precautions. This strengthens both the negligence claim and the case for punitive damages.',
            ),
            array(
                'question' => 'Can I file a complaint with animal control after a loose dog attack?',
                'answer'   => 'Yes, and you should. Filing an animal control complaint creates an official record of the incident. Animal control may investigate, quarantine the dog, and classify it as dangerous — all of which support your legal claim.',
            ),
            array(
                'question' => 'What compensation is available for a loose dog attack?',
                'answer'   => 'Victims may recover medical expenses, lost wages, pain and suffering, scarring and disfigurement, emotional distress, and property damage. Punitive damages may be available when the owner\'s negligence was particularly egregious.',
            ),
        ),
    ),

    /* ============================================================
       5. Dangerous Breed Attack
       ============================================================ */
    array(
        'title'   => 'Dangerous Breed Attack Lawyers',
        'slug'    => 'dangerous-breed-attack',
        'excerpt' => 'Injured in an attack by a pit bull, Rottweiler, or other dangerous breed in Georgia or South Carolina? Our attorneys hold negligent owners accountable for breed-specific risks and fight for full compensation.',
        'content' => <<<'HTML'
<h2>Legal Claims for Dangerous Breed Dog Attacks</h2>
<p>Certain dog breeds are statistically associated with a higher incidence of severe and fatal attacks. According to data compiled by the <a href="https://www.avma.org/resources-tools/pet-owners/dog-bite-prevention" target="_blank" rel="noopener">American Veterinary Medical Association (AVMA)</a> and peer-reviewed studies in medical journals, breeds including pit bulls, Rottweilers, German Shepherds, and their mixes are overrepresented in serious bite injury statistics. While any dog can bite regardless of breed, attacks by large, powerful breeds tend to cause more severe injuries due to their greater bite force and tenacity during an attack.</p>
<p>At Roden Law, our dangerous breed attack lawyers represent victims across Georgia and South Carolina who have suffered serious injuries from attacks by powerful dog breeds. We focus on the owner's negligence — their failure to properly contain, train, and manage a dog breed known to present elevated risk — to maximize compensation for our clients.</p>

<h2>Georgia's Dangerous Dog Classification</h2>
<p>Georgia's Responsible Dog Ownership Law (<a href="https://law.justia.com/codes/georgia/title-4/chapter-8/article-2/" target="_blank" rel="noopener">O.C.G.A. § 4-8-20 et seq.</a>) establishes two classifications for aggressive dogs:</p>
<ul>
<li><strong>Dangerous dog:</strong> A dog that causes a substantial puncture wound, aggressively attacks in a manner that causes injury, or has been classified as potentially dangerous and exhibits continued dangerous behavior</li>
<li><strong>Vicious dog:</strong> A dog that inflicts serious injury on a human or kills a human, without provocation</li>
</ul>
<p>Owners of classified dangerous dogs must maintain a proper enclosure, post warning signs, maintain $50,000 in liability insurance or a surety bond, and keep the dog muzzled and leashed when off the owner's property. Owners of vicious dogs face potential euthanasia orders and criminal penalties. These classifications are not breed-specific under state law, but they recognize that some dogs pose greater risks.</p>

<h2>South Carolina Dangerous Animal Provisions</h2>
<p>South Carolina's strict liability statute (<a href="https://www.scstatehouse.gov/code/t47c003.php" target="_blank" rel="noopener">S.C. Code § 47-3-110</a>) applies to all dog breeds equally — the owner is liable for bite injuries in public places regardless of breed. However, South Carolina courts consider a dog's breed and the owner's knowledge of breed-specific tendencies when evaluating whether the owner exercised reasonable care. Some South Carolina municipalities have enacted breed-specific regulations, though the state does not maintain a statewide breed-specific legislation (BSL) ban.</p>

<h2>Heightened Owner Responsibility for Powerful Breeds</h2>
<p>While breed alone does not create legal liability, owners of large, powerful breeds have a heightened duty of care because of the foreseeable risk of serious injury. Evidence that strengthens dangerous breed attack claims includes:</p>
<ul>
<li>The owner's knowledge of the breed's tendencies and bite force</li>
<li>Failure to provide adequate containment, fencing, or leashing</li>
<li>Lack of proper socialization and obedience training</li>
<li>Prior incidents of aggression, biting, or lunging at people</li>
<li>Violation of local breed-specific regulations or dangerous dog ordinances</li>
<li>Keeping the dog in environments with children or vulnerable individuals without safeguards</li>
</ul>

<h2>Injuries from Dangerous Breed Attacks</h2>
<p>Attacks by large, powerful breeds often cause catastrophic injuries requiring extensive medical intervention:</p>
<ul>
<li><strong>Massive tissue damage:</strong> Breeds with powerful jaws can crush bone and tear large sections of tissue</li>
<li><strong>Multiple and sustained bite injuries:</strong> Some breeds exhibit a "hold and shake" bite pattern that causes extensive tearing</li>
<li><strong><a href="/dog-bite-lawyers/severe-dog-bite-injury/">Disfiguring injuries</a>:</strong> Particularly to the face, arms, and legs requiring reconstructive surgery</li>
<li><strong>Fatal injuries:</strong> Large breed attacks account for the majority of dog bite fatalities in the United States</li>
<li><strong>Severe psychological trauma:</strong> PTSD, anxiety disorders, and lasting fear</li>
</ul>

<h2>Insurance and Breed Restrictions</h2>
<p>Many homeowners insurance companies maintain breed restriction lists, refusing to cover or charging higher premiums for breeds they classify as high-risk. When a dog owner's policy excludes their breed, there may be no insurance coverage for bite injuries. Our attorneys investigate all potential sources of recovery, including <a href="/dog-bite-lawyers/landlord-liability-dog-attack/">landlord liability</a> policies, umbrella coverage, and the owner's personal assets.</p>

<h2>Why Choose Roden Law for Dangerous Breed Attack Cases</h2>
<p>Our attorneys have handled numerous cases involving attacks by pit bulls, Rottweilers, German Shepherds, and other powerful breeds throughout Georgia and South Carolina. We work with veterinary experts, animal behaviorists, and medical specialists to build compelling cases that demonstrate the owner's negligence and the severity of your injuries. There is no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Are certain dog breeds more dangerous than others?',
                'answer'   => 'Statistically, certain large and powerful breeds are overrepresented in serious bite injury data. However, any dog can bite. Legal liability focuses on the owner\'s negligence — whether they properly contained, trained, and managed a dog whose breed presents foreseeable elevated risk.',
            ),
            array(
                'question' => 'Does Georgia have breed-specific legislation?',
                'answer'   => 'Georgia does not have a statewide breed ban, but the Responsible Dog Ownership Law (O.C.G.A. § 4-8-20 et seq.) allows individual dogs to be classified as "dangerous" or "vicious" based on behavior. Some Georgia municipalities have enacted local breed-specific regulations.',
            ),
            array(
                'question' => 'What if the dog owner\'s insurance excludes their dog\'s breed?',
                'answer'   => 'If the owner\'s homeowners insurance excludes their dog\'s breed, other sources of recovery may be available, including landlord liability insurance, umbrella policies, or the owner\'s personal assets. Our attorneys investigate all potential sources of compensation.',
            ),
            array(
                'question' => 'Can I sue if a pit bull attacks my child?',
                'answer'   => 'Yes. The dog owner is liable under Georgia\'s dog bite statute (O.C.G.A. § 51-2-7) or South Carolina\'s strict liability law (S.C. Code § 47-3-110). Our <a href="/dog-bite-lawyers/child-dog-bite/">child dog bite lawyers</a> pursue maximum compensation for young victims of dangerous breed attacks.',
            ),
            array(
                'question' => 'Are punitive damages available in dangerous breed attack cases?',
                'answer'   => 'Yes, particularly when the owner knew the dog was aggressive and failed to take adequate precautions. An owner who keeps a previously aggressive large breed without proper containment demonstrates the kind of reckless conduct that supports punitive damages.',
            ),
        ),
    ),

    /* ============================================================
       6. Dog-on-Dog Attack
       ============================================================ */
    array(
        'title'   => 'Dog-on-Dog Attack Lawyers',
        'slug'    => 'dog-on-dog-attack',
        'excerpt' => 'Was your dog attacked by another dog in Georgia or South Carolina? Our attorneys help pet owners recover veterinary bills, emotional distress damages, and hold negligent owners accountable.',
        'content' => <<<'HTML'
<h2>Legal Claims for Dog-on-Dog Attacks</h2>
<p>When an aggressive dog attacks your pet, the physical and emotional impact can be devastating. Veterinary emergency care is expensive, injuries to your pet can be life-threatening, and the experience is traumatic for both the animal and the owner. According to the <a href="https://www.avma.org/" target="_blank" rel="noopener">American Veterinary Medical Association (AVMA)</a>, dog-on-dog aggression is a significant animal welfare and public safety concern, as intervening owners frequently suffer bite injuries themselves while trying to protect their pets.</p>
<p>At Roden Law, our dog-on-dog attack attorneys represent pet owners across Georgia and South Carolina who seek to recover veterinary costs, property damage, emotional distress, and personal injury damages when they are bitten while intervening. We hold negligent dog owners accountable for failing to control their aggressive animals.</p>

<h2>Legal Framework for Dog-on-Dog Attack Claims</h2>
<p>Under both Georgia and South Carolina law, dogs are classified as personal property. When another person's dog attacks and injures your dog, the attacking dog's owner is liable for property damage — the cost of veterinary care and, in fatal cases, the fair market value or replacement cost of the dog.</p>
<p>Georgia's dog bite statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-2/article-1/section-51-2-7/" target="_blank" rel="noopener">O.C.G.A. § 51-2-7</a>) provides a basis for liability when the attacking dog was known to be vicious or dangerous and was carelessly managed. Georgia's Responsible Dog Ownership Law (<a href="https://law.justia.com/codes/georgia/title-4/chapter-8/article-2/" target="_blank" rel="noopener">O.C.G.A. § 4-8-20 et seq.</a>) also applies, as aggressive behavior toward other animals is a factor in classifying a dog as "dangerous."</p>
<p>South Carolina's strict liability statute (<a href="https://www.scstatehouse.gov/code/t47c003.php" target="_blank" rel="noopener">S.C. Code § 47-3-110</a>) specifically addresses attacks on persons, but dog-on-dog attacks are actionable under general negligence principles and property damage law. When a <a href="/dog-bite-lawyers/loose-unleashed-dog-attack/">loose or unleashed dog</a> attacks a leashed pet, the attacking dog's owner's negligence is clear.</p>

<h2>Owner Injuries During Dog-on-Dog Attacks</h2>
<p>A critical aspect of dog-on-dog attack cases is the injury risk to pet owners who intervene. When you attempt to separate fighting dogs or protect your pet from an aggressive animal, you may suffer severe bite wounds to your hands and arms, puncture wounds and lacerations, broken bones from being pulled or knocked down, and emotional trauma and PTSD. These personal injuries — suffered while trying to protect your property (your pet) — create a direct personal injury claim against the attacking dog's owner in addition to the property damage claim for your pet's injuries.</p>

<h2>Recoverable Damages in Dog-on-Dog Cases</h2>
<p>Victims of dog-on-dog attacks may recover compensation in several categories:</p>
<ul>
<li><strong>Veterinary bills:</strong> Emergency care, surgery, hospitalization, medications, and follow-up treatment for your injured pet</li>
<li><strong>Pet death:</strong> Fair market value or replacement cost if your pet is killed, plus euthanasia and cremation costs</li>
<li><strong>Owner medical bills:</strong> Emergency care, surgery, and treatment for bite injuries suffered while intervening</li>
<li><strong>Lost wages:</strong> Time missed from work for medical treatment and caring for your injured pet</li>
<li><strong>Pain and suffering:</strong> Physical pain from personal injuries and emotional distress from witnessing the attack</li>
<li><strong>Emotional distress:</strong> Georgia and South Carolina courts increasingly recognize the deep emotional bond between owners and pets</li>
</ul>

<h2>Reporting and Documentation</h2>
<p>After a dog-on-dog attack, take these steps to protect your legal rights: seek immediate veterinary care for your pet, call animal control to report the attacking dog, photograph your pet's injuries and any personal injuries you sustained, obtain the attacking dog owner's name, address, and insurance information, collect contact information from witnesses, and keep all veterinary records and bills. An animal control report creates an official record and may result in the attacking dog being classified as dangerous under O.C.G.A. § 4-8-20 or local ordinances.</p>

<h2>Why Choose Roden Law for Dog-on-Dog Attack Cases</h2>
<p>Our attorneys understand that pets are family. We pursue full compensation for both your pet's injuries and any personal injuries you suffered during the attack. We handle these cases on a contingency fee basis — no fee unless we recover compensation for you.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can I sue if another dog attacks and injures my dog?',
                'answer'   => 'Yes. Dogs are legally classified as property, and the attacking dog\'s owner is liable for veterinary costs and property damage. If you were also injured while trying to protect your pet, you have a personal injury claim as well.',
            ),
            array(
                'question' => 'What damages can I recover for a dog-on-dog attack?',
                'answer'   => 'You can recover veterinary bills, the replacement value of your pet if it was killed, your own medical expenses if you were injured intervening, lost wages, pain and suffering, and emotional distress damages.',
            ),
            array(
                'question' => 'What if I was bitten while trying to separate the dogs?',
                'answer'   => 'Injuries you sustain while trying to protect your pet from an attacking dog create a direct personal injury claim against the other dog\'s owner. These claims are separate from the property damage claim for your pet\'s injuries.',
            ),
            array(
                'question' => 'Should I report a dog-on-dog attack to animal control?',
                'answer'   => 'Yes. Filing an animal control report creates an official record, may lead to the attacking dog being classified as dangerous, and strengthens your legal case. Animal control records are important evidence in dog attack lawsuits.',
            ),
            array(
                'question' => 'Does homeowners insurance cover dog-on-dog attacks?',
                'answer'   => 'The attacking dog owner\'s homeowners or renters insurance typically covers liability for damage caused by their pet, including injuries to other animals and personal injuries to their owners. Our attorneys identify all applicable insurance coverage.',
            ),
        ),
    ),

    /* ============================================================
       7. Postal and Delivery Worker Bite
       ============================================================ */
    array(
        'title'   => 'Postal and Delivery Worker Bite Lawyers',
        'slug'    => 'postal-delivery-worker-bite',
        'excerpt' => 'Bitten by a dog while delivering mail or packages in Georgia or South Carolina? Our attorneys help postal workers, Amazon drivers, and delivery personnel recover full compensation from dog owners.',
        'content' => <<<'HTML'
<h2>Legal Help for Postal and Delivery Workers Bitten by Dogs</h2>
<p>Mail carriers, package delivery drivers, and other delivery personnel face a uniquely high risk of dog bite injuries. The <a href="https://www.usps.com/news" target="_blank" rel="noopener">United States Postal Service (USPS)</a> reports over 5,400 dog attacks on mail carriers annually, making postal workers one of the most frequently bitten occupational groups in the country. With the dramatic growth of e-commerce, Amazon, FedEx, UPS, and food delivery drivers face similar risks as they approach homes multiple times per day. Georgia and South Carolina both rank among the states with the highest numbers of reported dog attacks on postal workers.</p>
<p>At Roden Law, our attorneys represent postal and delivery workers across Georgia and South Carolina who have been bitten by dogs during the course of their duties. We pursue full compensation from dog owners and their insurance policies, and we help workers navigate the intersection of personal injury claims and workers' compensation benefits.</p>

<h2>Why Delivery Workers Are High-Risk Targets</h2>
<p>Delivery workers face elevated bite risk for several reasons:</p>
<ul>
<li><strong>Territorial behavior:</strong> Dogs perceive mail carriers and delivery drivers as intruders entering their territory</li>
<li><strong>Repeated exposure:</strong> Regular daily visits reinforce the dog's perception that the worker is a recurring threat</li>
<li><strong>Approach to the door:</strong> Workers must approach the home — and the dog's perceived territory boundary — to complete deliveries</li>
<li><strong>Hands occupied:</strong> Workers carrying packages cannot defend themselves or react as quickly to aggressive dogs</li>
<li><strong>Surprises:</strong> Dogs may be behind gates, inside screen doors, or unleashed in front yards without warning</li>
</ul>

<h2>Georgia and South Carolina Liability for Delivery Worker Bites</h2>
<p>Delivery workers who are bitten have strong legal claims under both Georgia and South Carolina law. Under Georgia's dog bite statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-2/article-1/section-51-2-7/" target="_blank" rel="noopener">O.C.G.A. § 51-2-7</a>), the dog owner is liable when they knew or should have known the dog was dangerous and carelessly managed it. Delivery workers are lawfully on the property by implied invitation — homeowners who order packages or receive mail implicitly invite delivery personnel onto their property.</p>
<p>South Carolina's strict liability statute (<a href="https://www.scstatehouse.gov/code/t47c003.php" target="_blank" rel="noopener">S.C. Code § 47-3-110</a>) provides even stronger protection. It imposes liability on the dog owner when the victim is in a public place or lawfully on private property, including by invitation. Delivery workers are clearly lawfully present, whether on the sidewalk, driveway, or porch.</p>

<h2>Workers' Comp vs. Third-Party Claims</h2>
<p>Delivery workers who are employees (USPS letter carriers, UPS drivers, FedEx employees) may receive workers' compensation benefits through their employer. However, workers' comp does not cover pain and suffering or provide full wage replacement. A <a href="/workers-compensation-lawyers/third-party-workplace-injury/">third-party personal injury claim</a> against the dog owner provides access to full compensatory damages beyond what workers' comp offers.</p>
<p>Independent contractors — including many Amazon Flex drivers, DoorDash and Grubhub delivery workers, and gig economy couriers — may not be covered by workers' comp at all, making a third-party personal injury claim their primary avenue for recovery. Our attorneys evaluate each worker's employment classification and pursue every available source of compensation.</p>

<h2>Common Delivery Worker Bite Injuries</h2>
<p>Delivery worker dog bite injuries frequently include severe hand and arm bites from defensive wounds, leg and calf bites from dogs attacking from behind, facial bites when bending to place packages, tendon and nerve damage to the hands affecting grip and dexterity, infections requiring antibiotic treatment or surgical debridement, and psychological trauma creating fear and anxiety about returning to the route. These injuries can result in significant time away from work and, in severe cases, permanent inability to continue in the delivery profession.</p>

<h2>Damages for Delivery Worker Dog Bite Victims</h2>
<p>Delivery workers injured by dog bites may recover compensation for all medical expenses and future treatment costs, lost wages and diminished earning capacity, pain and suffering, scarring and disfigurement, emotional distress and PTSD, and career impact if unable to continue delivery work. Our attorneys work with vocational experts to document the full economic impact when a dog bite injury forces a career change.</p>

<h2>Why Choose Roden Law for Delivery Worker Bite Cases</h2>
<p>Our attorneys have experience representing USPS letter carriers, Amazon drivers, UPS and FedEx workers, and food delivery couriers bitten by dogs throughout Georgia and South Carolina. We coordinate workers' comp benefits with third-party claims to maximize total recovery. There is no fee unless we win.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can a mail carrier sue a dog owner for a bite injury?',
                'answer'   => 'Yes. Mail carriers and other delivery workers can file personal injury claims against dog owners. They are lawfully on the property by implied invitation, giving them full protection under Georgia\'s dog bite statute (O.C.G.A. § 51-2-7) and South Carolina\'s strict liability law (S.C. Code § 47-3-110).',
            ),
            array(
                'question' => 'Can I file both a workers\' comp claim and a lawsuit against the dog owner?',
                'answer'   => 'Yes. Workers\' compensation covers your employer\'s liability, while a third-party personal injury claim targets the dog owner. Both can proceed simultaneously, and the combined recovery is typically much greater than workers\' comp alone.',
            ),
            array(
                'question' => 'What if I am an independent contractor delivery driver bitten by a dog?',
                'answer'   => 'Independent contractors (such as Amazon Flex, DoorDash, and Grubhub drivers) generally do not receive workers\' comp benefits, making a personal injury claim against the dog owner the primary avenue for recovery. Our attorneys help gig economy workers pursue full compensation.',
            ),
            array(
                'question' => 'Is the dog owner liable if they had a "Beware of Dog" sign?',
                'answer'   => 'A "Beware of Dog" sign does not protect the owner from liability. In fact, it can serve as evidence that the owner knew the dog was aggressive. Delivery workers are lawfully on the property and the owner has a duty to prevent bites regardless of posted warnings.',
            ),
            array(
                'question' => 'What should a delivery worker do after being bitten by a dog?',
                'answer'   => 'Seek immediate medical attention, report the incident to your employer or supervisor, report the bite to local animal control, photograph your injuries and the location, document the dog and owner information, and contact an attorney before giving recorded statements to insurance companies.',
            ),
        ),
    ),

    /* ============================================================
       8. Landlord Liability for Dog Attack
       ============================================================ */
    array(
        'title'   => 'Landlord Liability for Dog Attack Lawyers',
        'slug'    => 'landlord-liability-dog-attack',
        'excerpt' => 'Bitten by a tenant\'s dog in Georgia or South Carolina? Our attorneys pursue landlord liability claims when property owners knowingly allow dangerous dogs on rental properties.',
        'content' => <<<'HTML'
<h2>Landlord Liability for Dog Bite Injuries</h2>
<p>When a tenant's dog attacks and injures someone, the dog owner is the primary liable party — but the landlord may also bear responsibility. Landlords who know that a tenant keeps a dangerous dog and fail to take action can be held liable for resulting bite injuries. This theory of liability is particularly important when the tenant lacks adequate insurance or assets to cover the victim's damages, as the landlord's commercial property insurance often provides a significant additional source of recovery.</p>
<p>At Roden Law, our landlord liability dog attack lawyers represent victims across Georgia and South Carolina who have been bitten by dogs at rental properties, apartment complexes, and leased homes. We investigate whether the landlord had knowledge of the dangerous dog and failed to act — and we pursue every available source of compensation.</p>

<h2>Georgia Landlord Liability for Dog Bites</h2>
<p>Georgia courts have recognized landlord liability for dog bites under the principles established in the state's dog bite statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-2/article-1/section-51-2-7/" target="_blank" rel="noopener">O.C.G.A. § 51-2-7</a>) and general negligence law. A landlord may be liable when they had actual knowledge that the tenant's dog was dangerous or vicious, they had the ability to remove the dog or require the tenant to remove it (through lease provisions or local ordinances), and they failed to take reasonable action to protect others from the known danger.</p>
<p>Evidence of landlord knowledge includes prior bite incidents on the property reported to the landlord, complaints from other tenants or neighbors about the dog's aggressive behavior, animal control citations or dangerous dog classifications known to the landlord, observations by property managers or maintenance workers of the dog's aggressive tendencies, and breed restrictions in the lease that the landlord failed to enforce.</p>

<h2>South Carolina Landlord Liability for Dog Bites</h2>
<p>South Carolina applies the strict liability standard of <a href="https://www.scstatehouse.gov/code/t47c003.php" target="_blank" rel="noopener">S.C. Code § 47-3-110</a> to dog owners, but landlord liability requires a separate negligence analysis. A South Carolina landlord may be held liable when they knew the tenant's dog was dangerous, they had the authority to require removal of the dog, they failed to exercise that authority, and the failure to act was a proximate cause of the victim's injuries. South Carolina courts have also imposed liability on landlords who maintained control over common areas — hallways, parking lots, laundry rooms, playgrounds — where the attack occurred.</p>

<h2>Lease Provisions and Landlord Duty</h2>
<p>Many rental agreements include provisions addressing pets and dangerous animals. Common lease provisions include breed restrictions prohibiting specific breeds, weight limits on permitted pets, requirements for renter's insurance with dog bite liability coverage, provisions allowing the landlord to require removal of a dangerous animal, and pet deposit and pet rent requirements. When a landlord includes these provisions but fails to enforce them — for example, allowing a tenant to keep a prohibited breed or failing to require removal after a bite incident — the landlord's negligence is strengthened. Conversely, a landlord who has no pet policy and no knowledge of a dangerous dog faces a weaker liability claim.</p>

<h2>Apartment Complexes and Property Management Companies</h2>
<p>Dog attacks at apartment complexes and multi-family housing present additional liability theories. Property management companies that oversee daily operations may be liable for failing to enforce pet policies, failing to address complaints about aggressive dogs, maintaining inadequate fencing around common areas, and failing to respond to reports of <a href="/dog-bite-lawyers/loose-unleashed-dog-attack/">loose or unleashed dogs</a> on the property. Our attorneys investigate the roles of property owners, management companies, and on-site managers to identify every potentially liable party and source of insurance coverage.</p>

<h2>Insurance Coverage in Landlord Liability Cases</h2>
<p>Landlord liability claims often involve multiple insurance policies: the tenant's renter's insurance covering the dog owner's liability, the landlord's commercial property insurance covering premises liability, the property management company's professional liability policy, and umbrella or excess liability policies. Our attorneys identify and pursue every available policy to maximize recovery. This layered approach is especially important in <a href="/dog-bite-lawyers/severe-dog-bite-injury/">severe dog bite injury</a> cases where the tenant's renter's insurance alone is insufficient to cover catastrophic injuries.</p>

<h2>Why Choose Roden Law for Landlord Liability Dog Attack Cases</h2>
<p>Our attorneys have experience holding landlords and property management companies accountable for dog bite injuries across Georgia and South Carolina. We investigate lease provisions, complaint histories, animal control records, and property management practices to build strong landlord liability cases. We work on a contingency fee basis — no fee unless we win your case.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can a landlord be held liable for a tenant\'s dog bite?',
                'answer'   => 'Yes, if the landlord knew the tenant\'s dog was dangerous and had the ability to require removal but failed to act. Landlord liability requires knowledge plus inaction — simply owning the property is not enough without awareness of the danger.',
            ),
            array(
                'question' => 'What evidence shows a landlord knew about a dangerous dog?',
                'answer'   => 'Prior bite reports, complaints from other tenants, animal control citations, observations by property managers, lease violation notices about the dog, and correspondence between the tenant and landlord regarding the dog\'s behavior all demonstrate landlord knowledge.',
            ),
            array(
                'question' => 'Does the landlord\'s insurance cover dog bite injuries?',
                'answer'   => 'The landlord\'s commercial property insurance may cover dog bite injuries under its premises liability provision, particularly when the attack occurred in a common area or when the landlord was negligent in failing to address a known dangerous dog.',
            ),
            array(
                'question' => 'Can I sue both the dog owner and the landlord?',
                'answer'   => 'Yes. You can pursue claims against both the dog owner (the tenant) and the landlord. This approach maximizes available insurance coverage and total recovery, especially when the tenant\'s insurance is insufficient to cover your damages.',
            ),
            array(
                'question' => 'What if the lease prohibits dangerous breeds but the landlord did not enforce it?',
                'answer'   => 'A landlord who includes breed restrictions in the lease but fails to enforce them has arguably assumed a duty to protect tenants and visitors from dangerous breeds. Failure to enforce the lease provision strengthens the negligence claim against the landlord.',
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
