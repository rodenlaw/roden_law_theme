<?php
/**
 * Seeder: 8 Spinal Cord Injury Sub-Type Pages
 *
 * Creates 8 child posts under the spinal-cord-injury-lawyers pillar, each
 * covering a specific type of spinal cord injury.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-spinal-cord-subtypes.php
 *
 * Idempotent — skips any post whose slug already exists under the parent pillar.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Find the parent pillar: spinal-cord-injury-lawyers
   ------------------------------------------------------------------ */

$pillar = get_page_by_path( 'spinal-cord-injury-lawyers', OBJECT, 'practice_area' );

if ( ! $pillar ) {
    $pillar = get_page_by_path( 'spinal-cord-injury-lawyers', OBJECT, 'practice-area' );
}

if ( ! $pillar ) {
    WP_CLI::error( 'Pillar post "spinal-cord-injury-lawyers" not found. Create it first.' );
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

$cat_term = term_exists( 'spinal-cord-injuries', 'practice_category' );
if ( ! $cat_term ) {
    $cat_term = wp_insert_term( 'Spinal Cord Injuries', 'practice_category', array( 'slug' => 'spinal-cord-injuries' ) );
}
$cat_term_id = is_array( $cat_term ) ? $cat_term['term_id'] : $cat_term;

/* ------------------------------------------------------------------
   Sub-type definitions
   ------------------------------------------------------------------ */

$subtypes = array(

    /* ============================================================
       1. Complete Spinal Cord Injury
       ============================================================ */
    array(
        'title'   => 'Complete Spinal Cord Injury Lawyers',
        'slug'    => 'complete-spinal-cord-injury',
        'excerpt' => 'Suffered a complete spinal cord injury due to someone else\'s negligence? A complete SCI causes total loss of motor function and sensation below the injury level. Our attorneys fight for the lifetime compensation you deserve.',
        'content' => <<<'HTML'
<h2>Complete Spinal Cord Injury Lawyers in Georgia &amp; South Carolina</h2>
<p>A complete spinal cord injury (SCI) is among the most catastrophic injuries a person can suffer. In a complete injury, the spinal cord is fully severed or damaged to the point where no signals can pass through the injury site, resulting in total loss of motor function and sensation below the level of injury. The <a href="https://www.nscisc.uab.edu/" target="_blank" rel="noopener">National Spinal Cord Injury Statistical Center</a> reports that approximately 17,900 new spinal cord injuries occur in the United States each year, with vehicle crashes and falls being the leading causes.</p>
<p>At Roden Law, our complete spinal cord injury lawyers represent victims and families across Georgia and South Carolina. We understand the lifetime implications of a complete SCI and pursue full compensation for the extraordinary medical care, adaptive equipment, home modifications, and ongoing support that victims require for the rest of their lives.</p>

<h2>Understanding Complete vs. Incomplete Spinal Cord Injuries</h2>
<p>Spinal cord injuries are classified as either complete or <a href="/spinal-cord-injury-lawyers/incomplete-spinal-cord-injury/">incomplete</a>. In a complete injury, there is no preserved motor or sensory function below the neurological level of injury. This means:</p>
<ul>
<li><strong>Total motor loss:</strong> No voluntary movement is possible below the injury site</li>
<li><strong>Total sensory loss:</strong> No feeling — including pain, temperature, or touch — below the injury level</li>
<li><strong>Permanent condition:</strong> While medical advances continue, complete SCIs rarely recover significant function</li>
<li><strong>Secondary complications:</strong> Bladder and bowel dysfunction, respiratory compromise (in cervical injuries), chronic pain, pressure sores, autonomic dysreflexia, and increased risk of blood clots</li>
</ul>
<p>The level of injury determines whether the result is <a href="/spinal-cord-injury-lawyers/paraplegia/">paraplegia</a> (lower body paralysis from thoracic, lumbar, or sacral injuries) or <a href="/spinal-cord-injury-lawyers/tetraplegia-quadriplegia/">tetraplegia/quadriplegia</a> (paralysis of all four limbs from cervical injuries).</p>

<h2>Common Causes of Complete Spinal Cord Injuries</h2>
<p>Complete SCIs typically result from high-energy trauma that applies extreme force to the spinal column:</p>
<ul>
<li><strong><a href="/car-accident-lawyers/">Car accidents</a>:</strong> The leading cause of spinal cord injuries, accounting for nearly 39% of all SCIs — high-speed impacts, rollovers, and ejections are particularly likely to cause complete injuries</li>
<li><strong>Falls:</strong> Falls from significant heights in construction, industrial settings, or even residential properties can cause complete cord damage</li>
<li><strong>Acts of violence:</strong> Gunshot wounds and other penetrating injuries can sever the spinal cord entirely</li>
<li><strong><a href="/motorcycle-accident-lawyers/">Motorcycle crashes</a>:</strong> The lack of structural protection makes riders especially vulnerable to catastrophic spinal injuries</li>
<li><strong>Diving and sports injuries:</strong> Impact to the head or neck in shallow water or during contact sports can cause cervical complete injuries</li>
</ul>

<h2>Lifetime Costs of a Complete Spinal Cord Injury</h2>
<p>Complete SCIs impose staggering lifetime costs. According to the <a href="https://www.nscisc.uab.edu/" target="_blank" rel="noopener">NSCISC</a>, estimated lifetime costs for a person injured at age 25 with high tetraplegia exceed $5 million, while paraplegia costs approach $2.5 million. These figures include direct medical costs, rehabilitation, adaptive equipment, home and vehicle modifications, personal care attendants, and lost wages — but do not account for pain, suffering, or diminished quality of life.</p>
<p>Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-4/" target="_blank" rel="noopener">O.C.G.A. § 51-12-4</a>) allows recovery of all damages that naturally flow from the injury, including future medical expenses and impaired earning capacity. South Carolina similarly permits recovery of all actual damages, including future life care costs established through expert testimony.</p>

<h2>Life Care Planning and Expert Testimony</h2>
<p>Our attorneys work with life care planners, vocational rehabilitation experts, and economists to document the full scope of lifetime needs. A comprehensive life care plan addresses medical care and specialist follow-ups, durable medical equipment (power wheelchairs, standing frames, respiratory equipment), home modifications (ramps, widened doorways, accessible bathrooms, ceiling lifts), vehicle modifications (wheelchair-accessible vans with hand controls), personal care attendant services, psychological counseling, and vocational retraining when partial employment is possible.</p>
<p>Under Georgia's modified comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>), you can recover damages as long as you were less than 50% at fault. South Carolina allows recovery when you are less than 51% at fault. Your compensation is reduced by your percentage of fault.</p>

<h2>Filing Deadlines for Spinal Cord Injury Claims</h2>
<p>Georgia imposes a <strong>2-year statute of limitations</strong> for personal injury claims under <a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>. South Carolina allows <strong>3 years</strong> under <a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>. Given the complexity of complete SCI cases and the need for extensive expert analysis, we urge victims and families to contact an attorney as early as possible.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the difference between a complete and incomplete spinal cord injury?',
                'answer'   => 'A complete spinal cord injury results in total loss of motor function and sensation below the level of injury — no signals can pass through the damaged area. An incomplete injury preserves some function or sensation below the injury site, meaning partial recovery may be possible.',
            ),
            array(
                'question' => 'What are the lifetime costs of a complete spinal cord injury?',
                'answer'   => 'Lifetime costs vary by injury level but are staggering. High tetraplegia (cervical complete injuries) can exceed $5 million in lifetime costs for a person injured at age 25, while paraplegia costs approach $2.5 million. These figures include medical care, equipment, home modifications, personal attendants, and lost wages.',
            ),
            array(
                'question' => 'Can I recover compensation for a complete spinal cord injury in Georgia?',
                'answer'   => 'Yes. Under Georgia law (O.C.G.A. § 51-12-4), you can recover all damages that flow from the injury, including medical expenses, future care costs, lost wages, impaired earning capacity, pain and suffering, and loss of enjoyment of life — as long as you were less than 50% at fault (O.C.G.A. § 51-12-33).',
            ),
            array(
                'question' => 'What is a life care plan and why is it important?',
                'answer'   => 'A life care plan is a comprehensive document prepared by a certified life care planner that details all of the medical, rehabilitative, and supportive care a spinal cord injury victim will need for the rest of their life. It is critical for establishing the true cost of the injury and ensuring that a settlement or verdict provides adequate funding.',
            ),
            array(
                'question' => 'How long do I have to file a spinal cord injury lawsuit?',
                'answer'   => 'Georgia has a 2-year statute of limitations (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). However, complete SCI cases require extensive expert analysis and evidence preservation, so contacting an attorney as soon as possible is critical.',
            ),
        ),
    ),

    /* ============================================================
       2. Incomplete Spinal Cord Injury
       ============================================================ */
    array(
        'title'   => 'Incomplete Spinal Cord Injury Lawyers',
        'slug'    => 'incomplete-spinal-cord-injury',
        'excerpt' => 'Suffered an incomplete spinal cord injury? Even partial cord damage can cause life-changing impairment. Our attorneys pursue maximum compensation while your medical picture continues to evolve.',
        'content' => <<<'HTML'
<h2>Incomplete Spinal Cord Injury Lawyers in Georgia &amp; South Carolina</h2>
<p>An incomplete spinal cord injury occurs when the spinal cord is partially damaged, preserving some motor function, sensory function, or both below the level of injury. Unlike a <a href="/spinal-cord-injury-lawyers/complete-spinal-cord-injury/">complete spinal cord injury</a> where all function is lost, incomplete injuries exist on a spectrum — some victims retain substantial movement and sensation, while others have only minimal preserved function. The <a href="https://www.nscisc.uab.edu/" target="_blank" rel="noopener">National Spinal Cord Injury Statistical Center</a> reports that incomplete injuries now account for more than 67% of all spinal cord injuries, partly due to improved emergency medical care that limits secondary cord damage.</p>
<p>At Roden Law, our incomplete spinal cord injury lawyers represent victims throughout Georgia and South Carolina. We understand the unique challenges of incomplete SCI cases — including the evolving medical picture, the potential for partial recovery, and the need to secure compensation that accounts for both best-case and worst-case outcomes.</p>

<h2>Types of Incomplete Spinal Cord Injuries</h2>
<p>Incomplete SCIs are classified into several clinical syndromes based on which area of the spinal cord is damaged:</p>
<ul>
<li><strong>Central cord syndrome:</strong> The most common incomplete SCI — affects the center of the spinal cord, typically causing greater weakness in the arms than the legs. Often results from hyperextension injuries in older adults with cervical spondylosis</li>
<li><strong>Brown-Sequard syndrome:</strong> Damage to one side of the spinal cord, causing motor loss on the injured side and sensory loss on the opposite side</li>
<li><strong>Anterior cord syndrome:</strong> Damage to the front of the spinal cord, affecting motor function and pain/temperature sensation while preserving proprioception (position sense) and light touch</li>
<li><strong>Posterior cord syndrome:</strong> Rare — affects the back of the cord, impairing proprioception while preserving motor function and pain sensation</li>
<li><strong>Conus medullaris syndrome:</strong> Damage to the tip of the spinal cord at the thoracolumbar junction, affecting bladder, bowel, and lower extremity function</li>
</ul>

<h2>The Challenge of Evolving Prognosis</h2>
<p>One of the most complex aspects of incomplete SCI cases is the evolving prognosis. Unlike complete injuries where the outcome is generally known early, incomplete injuries may improve significantly over months or years of rehabilitation — or may plateau with permanent deficits. This uncertainty creates challenges in valuing the case:</p>
<ul>
<li><strong>Insurance companies exploit uncertainty:</strong> Insurers may push for early settlements before the full extent of permanent impairment is known</li>
<li><strong>Maximum medical improvement (MMI):</strong> Neurological recovery from incomplete SCI can continue for 12 to 24 months or longer — settling before MMI risks undervaluing the claim</li>
<li><strong>Future medical needs:</strong> Even with partial recovery, victims may need ongoing physical therapy, pain management, adaptive equipment, and periodic medical monitoring</li>
</ul>
<p>Our attorneys protect clients by refusing premature settlements and working with neurologists and rehabilitation specialists to project long-term outcomes before negotiating.</p>

<h2>Common Causes and Negligence</h2>
<p>Incomplete spinal cord injuries result from many of the same trauma mechanisms as complete injuries — <a href="/car-accident-lawyers/">car crashes</a>, falls, <a href="/motorcycle-accident-lawyers/">motorcycle accidents</a>, and workplace incidents. However, incomplete injuries can also result from medical negligence, such as surgical errors during spinal procedures, failure to diagnose and treat spinal instability after trauma, or delayed treatment of spinal cord compression from <a href="/spinal-cord-injury-lawyers/herniated-ruptured-disc/">herniated discs</a> or <a href="/spinal-cord-injury-lawyers/spinal-fracture/">spinal fractures</a>.</p>

<h2>Compensation for Incomplete Spinal Cord Injuries</h2>
<p>Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-4/" target="_blank" rel="noopener">O.C.G.A. § 51-12-4</a>) and South Carolina law allow recovery of all actual damages, including past and future medical expenses, rehabilitation and therapy costs, lost wages and diminished earning capacity, pain and suffering, loss of enjoyment of life, and emotional distress. Under Georgia's comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>), you can recover if less than 50% at fault. South Carolina allows recovery if less than 51% at fault.</p>

<h2>Filing Deadlines</h2>
<p>Georgia's statute of limitations is <strong>2 years</strong> (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) and South Carolina allows <strong>3 years</strong> (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). Do not wait until you reach maximum medical improvement to contact a lawyer — filing deadlines run from the date of injury, not the date you finish treatment.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is an incomplete spinal cord injury?',
                'answer'   => 'An incomplete spinal cord injury is partial damage to the spinal cord that preserves some motor function, sensory function, or both below the level of injury. Unlike a complete injury where all function is lost, incomplete injuries vary widely — from minimal impairment to near-total paralysis with only slight preserved sensation.',
            ),
            array(
                'question' => 'Can incomplete spinal cord injuries improve over time?',
                'answer'   => 'Yes, many incomplete SCIs show improvement over months or even years, particularly with intensive rehabilitation. Neurological recovery can continue for 12 to 24 months or longer. However, the degree of recovery varies greatly, and some deficits may be permanent.',
            ),
            array(
                'question' => 'Should I settle my incomplete SCI case quickly?',
                'answer'   => 'No. Insurance companies often push for early settlements before the full extent of permanent impairment is known. We recommend waiting until you reach maximum medical improvement (MMI) so that the true long-term impact and costs can be accurately assessed.',
            ),
            array(
                'question' => 'What types of compensation are available for incomplete spinal cord injuries?',
                'answer'   => 'You can recover medical expenses (past and future), rehabilitation costs, lost wages, diminished earning capacity, pain and suffering, loss of enjoyment of life, and emotional distress. Georgia (O.C.G.A. § 51-12-4) and South Carolina allow recovery of all actual damages flowing from the injury.',
            ),
            array(
                'question' => 'How long do I have to file an incomplete spinal cord injury lawsuit?',
                'answer'   => 'Georgia imposes a 2-year statute of limitations (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). The deadline runs from the date of injury, not when you finish treatment — so do not wait to consult an attorney.',
            ),
        ),
    ),

    /* ============================================================
       3. Paraplegia
       ============================================================ */
    array(
        'title'   => 'Paraplegia Lawyers',
        'slug'    => 'paraplegia',
        'excerpt' => 'Paralyzed from the waist down due to someone else\'s negligence? Paraplegia demands a lifetime of medical care and support. Our attorneys fight for the full compensation needed to secure your future.',
        'content' => <<<'HTML'
<h2>Paraplegia Lawyers in Georgia &amp; South Carolina</h2>
<p>Paraplegia — the paralysis of the lower body, including partial or total loss of function in both legs and often the trunk — is a devastating, life-altering condition. It results from damage to the thoracic, lumbar, or sacral regions of the spinal cord, leaving the upper body unaffected but eliminating the ability to walk, stand, or control lower-body functions. The <a href="https://www.christopherreeve.org/todays-care/paralysis-resource-center" target="_blank" rel="noopener">Christopher & Dana Reeve Foundation</a> estimates that approximately 5.4 million Americans live with some form of paralysis.</p>
<p>At Roden Law, our paraplegia lawyers fight for victims across Georgia and South Carolina who face a lifetime of challenges after negligence-caused injuries. We understand that paraplegia is not just a medical diagnosis — it transforms every aspect of daily life and imposes enormous financial burdens that must be fully compensated.</p>

<h2>How Paraplegia Differs from Tetraplegia</h2>
<p>Paraplegia affects the lower body due to injury at or below the thoracic spine (T1 and below), while <a href="/spinal-cord-injury-lawyers/tetraplegia-quadriplegia/">tetraplegia (quadriplegia)</a> affects all four limbs due to cervical spine injury. Paraplegic individuals typically retain full use of their arms and hands, which allows greater independence — but they still face profound challenges:</p>
<ul>
<li><strong>Mobility:</strong> Permanent wheelchair dependence for daily activities</li>
<li><strong>Bladder and bowel dysfunction:</strong> Neurogenic bladder and bowel requiring catheterization and bowel programs</li>
<li><strong>Sexual dysfunction:</strong> Loss of sexual function and fertility challenges</li>
<li><strong>Skin integrity:</strong> Constant risk of pressure sores from wheelchair sitting</li>
<li><strong>Chronic pain:</strong> Neuropathic pain at and below the injury level affecting quality of life</li>
<li><strong>Mental health:</strong> Depression, anxiety, and adjustment disorders are common following paraplegia</li>
</ul>
<p>Paraplegia can be either <a href="/spinal-cord-injury-lawyers/complete-spinal-cord-injury/">complete</a> (total loss of function) or <a href="/spinal-cord-injury-lawyers/incomplete-spinal-cord-injury/">incomplete</a> (some preserved function), significantly affecting the long-term prognosis and compensation needs.</p>

<h2>Common Causes of Paraplegia</h2>
<p>Paraplegia most frequently results from traumatic events involving extreme force to the thoracic or lumbar spine:</p>
<ul>
<li><strong><a href="/car-accident-lawyers/">Motor vehicle accidents</a>:</strong> The leading cause — high-speed collisions, T-bone crashes, and rollovers concentrate force on the mid and lower spine</li>
<li><strong>Falls:</strong> Falls from height in construction, industrial, and residential settings</li>
<li><strong><a href="/motorcycle-accident-lawyers/">Motorcycle crashes</a>:</strong> Riders ejected or thrown from motorcycles are especially vulnerable to mid-spine injuries</li>
<li><strong>Acts of violence:</strong> Gunshot and stabbing wounds to the back</li>
<li><strong>Sports and recreation:</strong> High-impact sports injuries, particularly equestrian, skiing, and cycling accidents</li>
<li><strong>Medical negligence:</strong> Surgical errors during spinal surgery, failure to stabilize spinal fractures, or delayed treatment of <a href="/spinal-cord-injury-lawyers/cauda-equina-syndrome/">cauda equina syndrome</a></li>
</ul>

<h2>Lifetime Costs and Compensation</h2>
<p>The <a href="https://www.nscisc.uab.edu/" target="_blank" rel="noopener">NSCISC</a> estimates lifetime costs for paraplegia at approximately $2.5 million for a person injured at age 25. This includes wheelchair and mobility equipment, accessible housing and vehicle modifications, personal care attendant services, ongoing medical care and rehabilitation, bladder and bowel management supplies, and psychological counseling.</p>
<p>Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-4/" target="_blank" rel="noopener">O.C.G.A. § 51-12-4</a>) allows full recovery of all damages naturally flowing from the injury, including future medical and life care expenses, lost earning capacity, pain and suffering, loss of enjoyment of life, and loss of consortium for spouses. South Carolina similarly permits comprehensive damage recovery.</p>
<p>Under Georgia's comparative fault statute (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>), recovery is available if your fault was less than 50%. South Carolina's threshold is 51%.</p>

<h2>Filing Deadlines</h2>
<p>Georgia's 2-year statute of limitations (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) and South Carolina's 3-year limit (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>) apply. Given the catastrophic nature of paraplegia and the extensive expert analysis required, early attorney involvement is essential.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is paraplegia?',
                'answer'   => 'Paraplegia is the partial or complete paralysis of the lower body, including both legs and often the trunk, caused by damage to the thoracic, lumbar, or sacral spinal cord. Individuals typically retain full use of their arms and hands but require a wheelchair for mobility.',
            ),
            array(
                'question' => 'What are the estimated lifetime costs of paraplegia?',
                'answer'   => 'The National Spinal Cord Injury Statistical Center estimates lifetime costs for paraplegia at approximately $2.5 million for a person injured at age 25. This includes medical care, equipment, home and vehicle modifications, personal attendants, and lost wages.',
            ),
            array(
                'question' => 'What is the difference between paraplegia and quadriplegia?',
                'answer'   => 'Paraplegia affects the lower body (legs and trunk) due to injury at the thoracic spine level or below. Quadriplegia (tetraplegia) affects all four limbs due to injury at the cervical (neck) level. Quadriplegia is generally more severe and costly.',
            ),
            array(
                'question' => 'Can I work after paraplegia?',
                'answer'   => 'Many paraplegic individuals return to some form of employment, particularly in sedentary or office-based roles, with appropriate accommodations. However, vocational retraining is often required, and earning capacity is typically reduced. Lost earning capacity is a key component of compensation.',
            ),
            array(
                'question' => 'How long do I have to file a paraplegia lawsuit?',
                'answer'   => 'Georgia allows 2 years from the date of injury (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). The complexity of paraplegia cases — requiring life care planners, vocational experts, and medical specialists — makes early legal action critical.',
            ),
        ),
    ),

    /* ============================================================
       4. Tetraplegia / Quadriplegia
       ============================================================ */
    array(
        'title'   => 'Tetraplegia / Quadriplegia Lawyers',
        'slug'    => 'tetraplegia-quadriplegia',
        'excerpt' => 'Paralyzed in all four limbs due to a cervical spinal cord injury? Tetraplegia requires the highest level of lifetime care. Our lawyers pursue the maximum compensation to secure your future.',
        'content' => <<<'HTML'
<h2>Tetraplegia / Quadriplegia Lawyers in Georgia &amp; South Carolina</h2>
<p>Tetraplegia — also known as quadriplegia — is the most severe form of spinal cord injury, resulting in partial or total paralysis of all four limbs, the trunk, and often the respiratory system. It occurs when the cervical (neck) region of the spinal cord is damaged, disrupting nerve signals from the brain to the entire body below the neck. The <a href="https://www.nscisc.uab.edu/" target="_blank" rel="noopener">National Spinal Cord Injury Statistical Center</a> reports that cervical injuries account for approximately 60% of all spinal cord injuries, making tetraplegia the most common outcome of traumatic SCI.</p>
<p>At Roden Law, our tetraplegia lawyers handle the most catastrophic injury cases across Georgia and South Carolina. We understand that tetraplegia cases demand the highest level of legal representation because the stakes — lifetime care costing millions of dollars — are enormous.</p>

<h2>Levels of Tetraplegia</h2>
<p>The severity of tetraplegia depends on which cervical vertebra is injured:</p>
<ul>
<li><strong>C1-C3 (high tetraplegia):</strong> Paralysis from the neck down, typically requiring a ventilator for breathing, 24-hour attendant care, and power wheelchair with head or chin control</li>
<li><strong>C4:</strong> Some shoulder and neck movement, ventilator dependence in many cases, power wheelchair with head control</li>
<li><strong>C5:</strong> Shoulder and biceps function, some ability to bend elbows, power wheelchair with hand control possible</li>
<li><strong>C6:</strong> Wrist extension (allowing some gripping with adaptive devices), greater independence with adaptive equipment</li>
<li><strong>C7-C8:</strong> Increasing arm and hand function, potential for some independent transfers and self-care with modifications</li>
</ul>
<p>Even the least severe forms of tetraplegia (C7-C8) result in significant impairment compared to <a href="/spinal-cord-injury-lawyers/paraplegia/">paraplegia</a>, because hand dexterity and grip strength are compromised.</p>

<h2>Lifetime Care Costs</h2>
<p>Tetraplegia imposes the highest lifetime costs of any injury. The <a href="https://www.nscisc.uab.edu/" target="_blank" rel="noopener">NSCISC</a> estimates:</p>
<ul>
<li><strong>High tetraplegia (C1-C4):</strong> Over $5.1 million in lifetime costs for a person injured at age 25, with first-year costs exceeding $1.1 million</li>
<li><strong>Low tetraplegia (C5-C8):</strong> Approximately $3.8 million lifetime, with first-year costs around $830,000</li>
</ul>
<p>These figures cover direct medical costs only and do not include lost wages, pain and suffering, or loss of enjoyment of life. Our attorneys work with life care planners and economists to document the full financial impact, which often exceeds the NSCISC estimates when all damages are included.</p>

<h2>Common Causes of Tetraplegia</h2>
<p>Tetraplegia results from trauma to the cervical spine:</p>
<ul>
<li><strong><a href="/car-accident-lawyers/">Car and truck accidents</a>:</strong> The leading cause — high-speed frontal and rear-end collisions cause hyperflexion and hyperextension of the neck</li>
<li><strong>Diving accidents:</strong> Striking the bottom of a pool, lake, or ocean in shallow water — a leading cause in young adults</li>
<li><strong>Falls:</strong> Falls from height landing on the head or neck</li>
<li><strong><a href="/motorcycle-accident-lawyers/">Motorcycle crashes</a>:</strong> Ejection or impact causing cervical fracture-dislocation</li>
<li><strong>Sports injuries:</strong> Football, rugby, gymnastics, and equestrian accidents</li>
<li><strong>Medical negligence:</strong> Surgical errors during cervical spine procedures or failure to diagnose cervical instability after trauma</li>
</ul>
<p>When tetraplegia results from another party's negligence, the victim has the right to pursue full compensation under Georgia and South Carolina personal injury law.</p>

<h2>Pursuing Maximum Compensation</h2>
<p>Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-4/" target="_blank" rel="noopener">O.C.G.A. § 51-12-4</a>) allows recovery of all damages naturally flowing from the injury. In tetraplegia cases, this includes millions in future medical care, 24-hour attendant care, respiratory equipment and management, adaptive technology, home modifications for full accessibility, wheelchair-accessible vehicle with driver adaptations, lost lifetime earnings, and compensation for extraordinary pain, suffering, and loss of life's pleasures.</p>
<p>Georgia's comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>) allows recovery if less than 50% at fault. South Carolina's threshold is 51%.</p>

<h2>Filing Deadlines</h2>
<p>Georgia's 2-year statute of limitations (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) and South Carolina's 3-year limit (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>) apply. Tetraplegia cases are among the most complex in personal injury law and require substantial preparation — contact an attorney immediately.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the difference between tetraplegia and quadriplegia?',
                'answer'   => 'Tetraplegia and quadriplegia are the same condition — paralysis of all four limbs due to cervical spinal cord injury. "Tetraplegia" is the preferred medical term (from Greek "tetra" meaning four), while "quadriplegia" (from Latin "quadri") is more commonly used in everyday language.',
            ),
            array(
                'question' => 'How much does lifetime care for tetraplegia cost?',
                'answer'   => 'The NSCISC estimates lifetime costs of over $5.1 million for high tetraplegia (C1-C4) and approximately $3.8 million for low tetraplegia (C5-C8) for a person injured at age 25. These figures include only direct medical costs and do not account for lost wages, pain and suffering, or diminished quality of life.',
            ),
            array(
                'question' => 'Will a tetraplegic person need 24-hour care?',
                'answer'   => 'Individuals with high tetraplegia (C1-C4) typically require 24-hour attendant care, including assistance with breathing (ventilator management), all personal care, transfers, and daily activities. Lower-level tetraplegia (C5-C8) may allow some independence with adaptive equipment, but substantial daily assistance is still required.',
            ),
            array(
                'question' => 'Can tetraplegia be caused by medical negligence?',
                'answer'   => 'Yes. Tetraplegia can result from surgical errors during cervical spine procedures, failure to diagnose cervical instability after trauma, delayed treatment of cervical cord compression, or improper patient handling during transport or medical procedures. These cases may give rise to medical malpractice claims.',
            ),
            array(
                'question' => 'How long do I have to file a tetraplegia lawsuit?',
                'answer'   => 'Georgia allows 2 years (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530) from the date of injury. Given the extraordinary complexity and the millions of dollars at stake, immediate legal representation is essential.',
            ),
        ),
    ),

    /* ============================================================
       5. Herniated and Ruptured Disc
       ============================================================ */
    array(
        'title'   => 'Herniated and Ruptured Disc Lawyers',
        'slug'    => 'herniated-ruptured-disc',
        'excerpt' => 'Herniated or ruptured disc from an accident? Disc injuries can cause debilitating pain, numbness, and weakness. Our attorneys fight for full compensation including surgery costs and long-term treatment.',
        'content' => <<<'HTML'
<h2>Herniated and Ruptured Disc Lawyers in Georgia &amp; South Carolina</h2>
<p>A herniated disc (also called a ruptured, bulging, or slipped disc) occurs when the soft center of a spinal disc pushes through a crack in the tougher exterior casing, irritating or compressing nearby nerves. While sometimes dismissed as a "minor" injury, herniated discs can cause excruciating pain, radiating numbness and tingling, muscle weakness, and — in severe cases — loss of bladder or bowel control that may indicate <a href="/spinal-cord-injury-lawyers/cauda-equina-syndrome/">cauda equina syndrome</a>, a surgical emergency.</p>
<p>At Roden Law, our herniated disc lawyers help accident victims throughout Georgia and South Carolina recover fair compensation for injuries that insurance companies routinely undervalue. We understand the medical complexity of disc injuries and fight to ensure our clients receive compensation that reflects the true impact on their lives.</p>

<h2>How Accidents Cause Disc Injuries</h2>
<p>Spinal discs act as shock absorbers between vertebrae. Traumatic force from accidents can cause the disc's nucleus pulposus to herniate through the annulus fibrosus, resulting in nerve compression:</p>
<ul>
<li><strong><a href="/car-accident-lawyers/">Car accidents</a>:</strong> Rear-end collisions and side-impact crashes generate sudden force that compresses and damages spinal discs, particularly in the cervical (neck) and lumbar (lower back) regions</li>
<li><strong><a href="/slip-and-fall-lawyers/">Slip and fall injuries</a>:</strong> Landing on the back or buttocks during a fall can herniate lumbar discs instantly</li>
<li><strong><a href="/truck-accident-lawyers/">Truck accidents</a>:</strong> The massive force of commercial vehicle collisions frequently causes multiple disc herniations</li>
<li><strong>Workplace injuries:</strong> Heavy lifting, repetitive bending, and industrial accidents commonly cause disc injuries</li>
<li><strong><a href="/motorcycle-accident-lawyers/">Motorcycle crashes</a>:</strong> Impact forces during motorcycle collisions affect the entire spine</li>
</ul>

<h2>Common Symptoms and Diagnosis</h2>
<p>Herniated disc symptoms depend on the location and severity of the herniation:</p>
<ul>
<li><strong>Cervical disc herniation:</strong> Neck pain radiating into the shoulders, arms, and hands (cervical radiculopathy); numbness and tingling in fingers; weakness in grip strength</li>
<li><strong>Lumbar disc herniation:</strong> Lower back pain radiating into the buttocks, legs, and feet (sciatica); numbness in legs or feet; difficulty walking or standing</li>
<li><strong>Thoracic disc herniation:</strong> Mid-back pain, band-like pain around the torso — less common but often more difficult to diagnose</li>
</ul>
<p>Diagnosis typically requires MRI imaging to confirm the herniation and identify which nerve roots are affected. Insurance companies frequently argue that disc herniations are pre-existing degenerative conditions rather than accident-caused injuries — our attorneys work with radiologists and spine specialists to establish causation.</p>

<h2>Treatment and Surgery</h2>
<p>Herniated disc treatment ranges from conservative care to surgery:</p>
<ul>
<li><strong>Conservative treatment:</strong> Physical therapy, pain medication, epidural steroid injections, and activity modification — typically tried for 6-12 weeks</li>
<li><strong>Microdiscectomy:</strong> Minimally invasive surgery to remove the herniated portion of the disc</li>
<li><strong>Laminectomy:</strong> Removal of part of the vertebral bone to relieve nerve compression</li>
<li><strong>Spinal fusion:</strong> For severe cases or multiple affected levels, vertebrae are fused together with hardware — significantly restricting mobility</li>
<li><strong>Artificial disc replacement:</strong> A newer option that preserves more spinal motion than fusion</li>
</ul>
<p>Spinal surgery costs $50,000 to $150,000 or more, and many disc injury victims require multiple surgeries over their lifetime, along with ongoing pain management.</p>

<h2>Compensation for Disc Injuries</h2>
<p>Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-4/" target="_blank" rel="noopener">O.C.G.A. § 51-12-4</a>) allows recovery of all damages flowing from the injury, including medical expenses, surgery costs, physical therapy, lost wages, pain and suffering, and diminished quality of life. Under the "eggshell plaintiff" doctrine recognized in both Georgia and South Carolina, a defendant takes the plaintiff as they find them — if a pre-existing degenerative condition was asymptomatic before the accident and the accident caused it to become symptomatic, the defendant is liable for the full extent of the resulting injury.</p>
<p>Georgia's comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>) allows recovery if less than 50% at fault. South Carolina's threshold is 51%.</p>

<h2>Filing Deadlines</h2>
<p>Georgia's 2-year statute of limitations (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) and South Carolina's 3-year limit (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>) apply. Disc herniation symptoms sometimes develop or worsen in the days and weeks following an accident, so prompt medical evaluation and legal consultation are critical.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'Can a car accident cause a herniated disc?',
                'answer'   => 'Absolutely. The sudden forces in a car accident — especially rear-end collisions — can compress spinal discs and cause herniation. Even moderate-speed crashes generate enough force to damage discs in the cervical (neck) and lumbar (lower back) spine.',
            ),
            array(
                'question' => 'What if the insurance company says my herniated disc is pre-existing?',
                'answer'   => 'Insurance companies frequently make this argument, but the "eggshell plaintiff" doctrine protects you. If your disc was degenerative but asymptomatic before the accident, and the accident caused it to become painful and symptomatic, the defendant is responsible for the full extent of your injury. Our attorneys work with spine specialists to establish this causation.',
            ),
            array(
                'question' => 'How much is a herniated disc case worth?',
                'answer'   => 'Value depends on severity, treatment required, and impact on your life. Cases requiring surgery, especially spinal fusion, are worth significantly more than cases resolved with conservative treatment. A single-level fusion case with significant pain and disability may be worth several hundred thousand dollars or more.',
            ),
            array(
                'question' => 'What is the difference between a herniated disc and a bulging disc?',
                'answer'   => 'A bulging disc extends outward uniformly, like a hamburger too big for its bun, without the outer layer tearing. A herniated disc involves the inner gel-like nucleus actually pushing through a tear in the outer layer, often directly compressing a nerve root. Herniations are generally more severe and more likely to require surgery.',
            ),
            array(
                'question' => 'How long do I have to file a herniated disc injury claim?',
                'answer'   => 'Georgia allows 2 years from the date of injury (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Because disc injury symptoms can develop or worsen days or weeks after an accident, seek medical evaluation and legal advice promptly.',
            ),
        ),
    ),

    /* ============================================================
       6. Spinal Fracture
       ============================================================ */
    array(
        'title'   => 'Spinal Fracture Lawyers',
        'slug'    => 'spinal-fracture',
        'excerpt' => 'Suffered a spinal fracture in an accident? Vertebral fractures range from stable compression fractures to unstable burst fractures that threaten the spinal cord. Our lawyers pursue maximum compensation for these serious injuries.',
        'content' => <<<'HTML'
<h2>Spinal Fracture Lawyers in Georgia &amp; South Carolina</h2>
<p>A spinal fracture — a break in one or more of the 33 vertebrae that make up the spinal column — is a serious injury that can range from a stable compression fracture requiring bracing to an unstable burst fracture or fracture-dislocation that threatens the spinal cord with permanent paralysis. The <a href="https://www.aans.org/" target="_blank" rel="noopener">American Association of Neurological Surgeons</a> reports that approximately 17,000 spinal fractures occur annually in the United States from trauma, with motor vehicle crashes and falls being the leading causes.</p>
<p>At Roden Law, our spinal fracture lawyers represent accident victims throughout Georgia and South Carolina. We understand the critical distinction between stable and unstable fractures, the risk of neurological injury, and the long-term consequences that demand full compensation.</p>

<h2>Types of Spinal Fractures</h2>
<p>Spinal fractures are classified by their mechanism of injury, location, and stability:</p>
<ul>
<li><strong>Compression fracture:</strong> The vertebral body collapses under axial loading, losing height. Generally stable, but can cause chronic pain and spinal deformity (kyphosis)</li>
<li><strong>Burst fracture:</strong> The vertebral body shatters in multiple directions, often sending bone fragments into the spinal canal where they can damage the spinal cord — a surgical emergency</li>
<li><strong>Flexion-distraction (Chance) fracture:</strong> The vertebra is pulled apart by a flexion-distraction force, commonly seen in lap-belt injuries during car crashes. May be associated with abdominal organ injuries</li>
<li><strong>Fracture-dislocation:</strong> The most unstable type — the vertebra is both fractured and displaced from its normal alignment, almost always causing spinal cord injury</li>
<li><strong>Transverse process fracture:</strong> A fracture of the bony wing projecting from the vertebra. Generally stable but indicates significant force was applied</li>
</ul>

<h2>Spinal Fractures and Cord Injury Risk</h2>
<p>The critical concern with spinal fractures is whether the spinal cord or nerve roots are compromised. Unstable fractures — particularly burst fractures and fracture-dislocations — carry a high risk of <a href="/spinal-cord-injury-lawyers/complete-spinal-cord-injury/">complete</a> or <a href="/spinal-cord-injury-lawyers/incomplete-spinal-cord-injury/">incomplete spinal cord injury</a>, resulting in <a href="/spinal-cord-injury-lawyers/paraplegia/">paraplegia</a> or <a href="/spinal-cord-injury-lawyers/tetraplegia-quadriplegia/">tetraplegia</a>. Even stable fractures can become unstable if not properly diagnosed and treated — making emergency room and trauma care decisions critical.</p>

<h2>Common Causes of Spinal Fractures</h2>
<ul>
<li><strong><a href="/car-accident-lawyers/">Car accidents</a>:</strong> The leading cause of spinal fractures — high-speed collisions, rollovers, and ejections apply extreme force to the spinal column. Lap-belt-only restraints are associated with flexion-distraction (Chance) fractures</li>
<li><strong>Falls from height:</strong> Construction falls, industrial accidents, and falls from ladders or roofs are a major source of thoracolumbar fractures</li>
<li><strong><a href="/motorcycle-accident-lawyers/">Motorcycle crashes</a>:</strong> Lack of structural protection means riders absorb the full impact force</li>
<li><strong><a href="/truck-accident-lawyers/">Truck accidents</a>:</strong> The massive weight and force of commercial vehicle collisions cause the most severe spinal fractures</li>
<li><strong>Pedestrian and bicycle accidents:</strong> Being struck by a vehicle can cause spinal fractures from the initial impact or the subsequent fall</li>
</ul>

<h2>Treatment for Spinal Fractures</h2>
<p>Treatment depends on fracture type and stability:</p>
<ul>
<li><strong>Bracing:</strong> Stable compression fractures may heal with a thoracolumbosacral orthosis (TLSO) brace worn for 8-12 weeks</li>
<li><strong>Vertebroplasty/kyphoplasty:</strong> Injection of bone cement into a compressed vertebral body to stabilize the fracture and restore height</li>
<li><strong>Surgical stabilization:</strong> Unstable fractures require spinal fusion with pedicle screws, rods, and sometimes cages to stabilize the spine and decompress the spinal cord</li>
<li><strong>Emergency decompression:</strong> When bone fragments compress the spinal cord, emergency surgery to remove fragments and stabilize the spine may preserve neurological function</li>
</ul>

<h2>Compensation and Legal Rights</h2>
<p>Georgia law (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-4/" target="_blank" rel="noopener">O.C.G.A. § 51-12-4</a>) allows recovery of all damages, including surgery and hospitalization costs, rehabilitation, lost wages, pain and suffering, permanent impairment, and future medical needs. Georgia's comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>) allows recovery if less than 50% at fault. South Carolina's threshold is 51%.</p>

<h2>Filing Deadlines</h2>
<p>Georgia's 2-year statute of limitations (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) and South Carolina's 3-year limit (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>) apply. Contact a spinal fracture lawyer as soon as possible to preserve critical evidence.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is the most dangerous type of spinal fracture?',
                'answer'   => 'Fracture-dislocations are the most dangerous because the vertebra is both broken and displaced, almost always causing spinal cord damage. Burst fractures are also very dangerous because bone fragments can enter the spinal canal and compress or lacerate the spinal cord.',
            ),
            array(
                'question' => 'Can a spinal fracture heal without surgery?',
                'answer'   => 'Stable compression fractures can often heal with bracing over 8-12 weeks. However, unstable fractures (burst fractures, fracture-dislocations) almost always require surgical stabilization with metal hardware (screws, rods, plates) to prevent spinal cord injury and maintain spinal alignment.',
            ),
            array(
                'question' => 'What is a Chance fracture?',
                'answer'   => 'A Chance fracture (flexion-distraction fracture) occurs when a vertebra is pulled apart by a forward-flexion force, commonly caused by lap-belt restraints during car crashes. The upper body flexes forward while the lap belt holds the pelvis, causing the vertebra to fracture through all three spinal columns.',
            ),
            array(
                'question' => 'What compensation is available for a spinal fracture?',
                'answer'   => 'You can recover all damages flowing from the injury, including surgery and hospitalization costs, rehabilitation, lost wages, pain and suffering, permanent impairment, and future medical needs. Cases involving spinal cord injury from fractures can be worth millions of dollars.',
            ),
            array(
                'question' => 'How long do I have to file a spinal fracture claim?',
                'answer'   => 'Georgia allows 2 years from the date of injury (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Early legal action is critical to preserve medical records, accident evidence, and witness testimony.',
            ),
        ),
    ),

    /* ============================================================
       7. Cauda Equina Syndrome
       ============================================================ */
    array(
        'title'   => 'Cauda Equina Syndrome Lawyers',
        'slug'    => 'cauda-equina-syndrome',
        'excerpt' => 'Cauda equina syndrome from an accident or delayed diagnosis? This surgical emergency requires immediate treatment to prevent permanent paralysis. Our attorneys hold negligent parties accountable.',
        'content' => <<<'HTML'
<h2>Cauda Equina Syndrome Lawyers in Georgia &amp; South Carolina</h2>
<p>Cauda equina syndrome (CES) is a rare but devastating condition that occurs when the bundle of nerve roots at the base of the spinal cord — called the cauda equina (Latin for "horse's tail") — is compressed, causing loss of bladder and bowel control, lower extremity weakness, saddle anesthesia (numbness in the groin, buttocks, and inner thighs), and potential permanent paralysis. CES is a <strong>surgical emergency</strong> — studies published in the <a href="https://pubmed.ncbi.nlm.nih.gov/" target="_blank" rel="noopener">National Library of Medicine</a> show that decompression surgery within 48 hours of symptom onset significantly improves outcomes, while delays lead to permanent neurological damage.</p>
<p>At Roden Law, our cauda equina syndrome lawyers handle cases arising from both traumatic accidents and medical negligence — including failure to diagnose and treat CES as the surgical emergency it is. We represent victims throughout Georgia and South Carolina.</p>

<h2>Causes of Cauda Equina Syndrome</h2>
<p>CES can result from traumatic injury or medical conditions, and may also arise from medical negligence:</p>
<ul>
<li><strong>Traumatic causes:</strong> <a href="/spinal-cord-injury-lawyers/spinal-fracture/">Spinal fractures</a>, <a href="/spinal-cord-injury-lawyers/herniated-ruptured-disc/">severe disc herniations</a> from <a href="/car-accident-lawyers/">car accidents</a>, falls, or industrial injuries that compress the cauda equina nerve bundle</li>
<li><strong>Surgical complications:</strong> Misplaced hardware during spinal surgery, post-operative hematoma compressing the nerves, or incomplete decompression</li>
<li><strong>Delayed diagnosis:</strong> Emergency room physicians or primary care doctors who fail to recognize the "red flag" symptoms of CES (bilateral leg weakness, bowel/bladder dysfunction, saddle numbness) and delay referral for emergency MRI and surgery</li>
<li><strong>Spinal epidural abscess or hematoma:</strong> Infections or bleeding that compress the cauda equina, requiring emergency drainage</li>
</ul>

<h2>Red Flag Symptoms: A Medical Emergency</h2>
<p>CES presents with characteristic warning signs that should trigger immediate emergency evaluation:</p>
<ul>
<li><strong>Bilateral sciatica:</strong> Severe pain radiating down both legs (unlike typical disc herniation, which usually affects one side)</li>
<li><strong>Saddle anesthesia:</strong> Numbness or reduced sensation in the areas that would contact a saddle — inner thighs, buttocks, perineum, and genitals</li>
<li><strong>Bladder dysfunction:</strong> Urinary retention (inability to urinate), incontinence, or loss of awareness of bladder fullness</li>
<li><strong>Bowel dysfunction:</strong> Fecal incontinence or inability to control bowel movements</li>
<li><strong>Lower extremity weakness:</strong> Progressive weakness in legs and feet, difficulty walking</li>
<li><strong>Sexual dysfunction:</strong> Loss of sensation and function</li>
</ul>
<p>When these symptoms are present, an MRI must be performed urgently. Failure to order an emergent MRI when CES is suspected constitutes <a href="/medical-malpractice-lawyers/">medical negligence</a> in most circumstances.</p>

<h2>The 48-Hour Window</h2>
<p>Medical literature strongly supports that surgical decompression within 48 hours of the onset of CES symptoms provides the best chance of neurological recovery. Delays beyond 48 hours are associated with significantly worse outcomes, including permanent bladder, bowel, and sexual dysfunction, permanent lower extremity weakness or paralysis, chronic neuropathic pain, and lifelong dependence on catheters and bowel programs.</p>
<p>Our attorneys retain neurosurgical experts to analyze the timeline from symptom onset to diagnosis and surgery, establishing whether the standard of care was met.</p>

<h2>Legal Claims for Cauda Equina Syndrome</h2>
<p>CES cases may involve two types of claims: <strong>personal injury</strong> (when trauma from an accident causes the condition) and <strong><a href="/medical-malpractice-lawyers/">medical malpractice</a></strong> (when healthcare providers fail to diagnose and treat CES promptly). Georgia medical malpractice claims require an affidavit from a qualified expert under <a href="https://law.justia.com/codes/georgia/title-9/chapter-11/article-2/section-9-11-9.1/" target="_blank" rel="noopener">O.C.G.A. § 9-11-9.1</a>. South Carolina medical malpractice claims require a Notice of Intent to File Suit and an expert affidavit under <a href="https://www.scstatehouse.gov/code/t15c079.php" target="_blank" rel="noopener">S.C. Code § 15-79-125</a>.</p>
<p>Georgia's comparative fault rule (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>) allows recovery if less than 50% at fault. South Carolina's threshold is 51%.</p>

<h2>Filing Deadlines</h2>
<p>For personal injury claims: Georgia allows 2 years (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) and South Carolina allows 3 years (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>). Medical malpractice claims may have shorter deadlines and additional procedural requirements. Contact an attorney immediately to preserve your rights.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'What is cauda equina syndrome?',
                'answer'   => 'Cauda equina syndrome (CES) is a condition where the bundle of nerve roots at the base of the spinal cord is compressed, causing loss of bladder and bowel control, saddle numbness, lower extremity weakness, and potential permanent paralysis. It is a surgical emergency requiring immediate decompression.',
            ),
            array(
                'question' => 'Is cauda equina syndrome a medical emergency?',
                'answer'   => 'Yes. CES requires emergency decompression surgery, ideally within 48 hours of symptom onset. Delays in diagnosis and treatment are associated with significantly worse outcomes, including permanent bladder, bowel, and sexual dysfunction, and permanent paralysis.',
            ),
            array(
                'question' => 'Can I sue for delayed diagnosis of cauda equina syndrome?',
                'answer'   => 'Yes. If a healthcare provider failed to recognize the red flag symptoms of CES (bilateral leg weakness, bladder/bowel dysfunction, saddle numbness) and delayed diagnosis or referral for emergency surgery, resulting in worse outcomes, you may have a medical malpractice claim.',
            ),
            array(
                'question' => 'What are the long-term effects of cauda equina syndrome?',
                'answer'   => 'Even with prompt surgery, many CES patients experience permanent residual deficits including bladder and bowel dysfunction, chronic pain, sexual dysfunction, and some degree of lower extremity weakness. Delayed treatment dramatically increases the likelihood and severity of permanent damage.',
            ),
            array(
                'question' => 'How long do I have to file a cauda equina syndrome lawsuit?',
                'answer'   => 'Personal injury claims have a 2-year limit in Georgia (O.C.G.A. § 9-3-33) and 3 years in South Carolina (S.C. Code § 15-3-530). Medical malpractice claims may have shorter deadlines and require expert affidavits. Contact an attorney immediately to understand your specific filing requirements.',
            ),
        ),
    ),

    /* ============================================================
       8. Spinal Cord Injuries in Car Accidents
       ============================================================ */
    array(
        'title'   => 'Spinal Cord Injuries in Car Accidents',
        'slug'    => 'spinal-cord-injury-car-accident',
        'excerpt' => 'Spinal cord injury from a car accident? Vehicle crashes are the leading cause of SCIs. Our attorneys bridge expertise in both auto accident and catastrophic injury litigation to maximize your recovery.',
        'content' => <<<'HTML'
<h2>Spinal Cord Injuries in Car Accidents — Georgia &amp; South Carolina</h2>
<p><a href="/car-accident-lawyers/">Car accidents</a> are the leading cause of spinal cord injuries in the United States, accounting for approximately 39% of all new SCIs according to the <a href="https://www.nscisc.uab.edu/" target="_blank" rel="noopener">National Spinal Cord Injury Statistical Center</a>. The tremendous forces generated in vehicle collisions — even at moderate speeds — can fracture vertebrae, herniate discs, and damage or sever the spinal cord, resulting in life-altering <a href="/spinal-cord-injury-lawyers/paraplegia/">paraplegia</a> or <a href="/spinal-cord-injury-lawyers/tetraplegia-quadriplegia/">tetraplegia</a>.</p>
<p>At Roden Law, our attorneys combine deep experience in both automobile accident litigation and catastrophic spinal cord injury cases. We represent victims throughout Georgia and South Carolina, pursuing the maximum compensation needed to cover a lifetime of medical care, adaptive equipment, and lost earnings.</p>

<h2>How Car Accidents Cause Spinal Cord Injuries</h2>
<p>Different crash types produce different mechanisms of spinal cord injury:</p>
<ul>
<li><strong>Rear-end collisions:</strong> Cause hyperextension-hyperflexion (whiplash) injuries to the cervical spine. In severe rear-end crashes, cervical fracture-dislocation can cause <a href="/spinal-cord-injury-lawyers/tetraplegia-quadriplegia/">tetraplegia</a></li>
<li><strong>Head-on collisions:</strong> Generate extreme deceleration forces that compress the thoracic and lumbar spine, causing <a href="/spinal-cord-injury-lawyers/spinal-fracture/">burst fractures</a> and <a href="/spinal-cord-injury-lawyers/herniated-ruptured-disc/">disc herniations</a></li>
<li><strong>T-bone (side-impact) crashes:</strong> Lateral forces can cause spinal fracture-dislocations and rotational injuries to the cord</li>
<li><strong>Rollovers:</strong> Multiple impact forces from all directions, combined with potential roof crush and ejection, create high risk of cervical SCI</li>
<li><strong>Ejection:</strong> Unbelted occupants ejected from vehicles suffer spinal cord injuries at extremely high rates due to impact with the ground, other objects, or the vehicle itself</li>
</ul>

<h2>Establishing Liability in Car Accident SCI Cases</h2>
<p>Proving who caused the accident is the foundation of a spinal cord injury claim. Common sources of liability include:</p>
<ul>
<li><strong>Negligent drivers:</strong> Distracted driving, speeding, impaired driving (DUI), running red lights, aggressive driving, and failure to yield</li>
<li><strong><a href="/truck-accident-lawyers/">Commercial vehicle operators</a>:</strong> Truck driver fatigue, trucking company safety violations, and overloaded vehicles — trucking companies are vicariously liable for their drivers' negligence</li>
<li><strong>Vehicle manufacturers:</strong> <a href="/product-liability-lawyers/defective-auto-parts/">Defective auto parts</a> including defective seatbelts, airbags, roof structures, and seats that fail to protect occupants during crashes</li>
<li><strong>Government entities:</strong> Dangerous road design, inadequate signage, missing guardrails, or failure to maintain roadways</li>
</ul>
<p>Georgia follows the rule of modified comparative fault (<a href="https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-33/" target="_blank" rel="noopener">O.C.G.A. § 51-12-33</a>), allowing recovery if the injured person's fault was less than 50%. South Carolina's threshold is 51%.</p>

<h2>Concurrent Brain and Spinal Cord Injuries</h2>
<p>Car accident victims who suffer spinal cord injuries frequently also sustain <a href="/brain-injury-lawyers/">traumatic brain injuries (TBI)</a>. The same violent forces that damage the spinal cord can also cause the brain to strike the inside of the skull. Concurrent TBI and SCI significantly compound the victim's challenges, complicating rehabilitation and dramatically increasing lifetime care costs. Our attorneys evaluate every car accident SCI case for potential brain injury and ensure both injuries are fully documented and compensated.</p>

<h2>Insurance Issues in Car Accident SCI Cases</h2>
<p>Spinal cord injury damages routinely exceed the at-fault driver's insurance policy limits. Our attorneys pursue all available coverage:</p>
<ul>
<li><strong>At-fault driver's liability insurance:</strong> The primary source, but often insufficient for catastrophic SCI</li>
<li><strong>Underinsured motorist (UIM) coverage:</strong> Your own policy's UIM coverage can supplement the at-fault driver's insufficient coverage</li>
<li><strong>Umbrella policies:</strong> Additional liability coverage above standard policy limits</li>
<li><strong>Employer liability:</strong> When the at-fault driver was working at the time of the crash (respondeat superior)</li>
<li><strong>Multiple defendants:</strong> Identifying all potentially liable parties — vehicle manufacturers, road designers, bar owners who overserved a drunk driver</li>
</ul>

<h2>Filing Deadlines</h2>
<p>Georgia's 2-year statute of limitations (<a href="https://law.justia.com/codes/georgia/title-9/chapter-3/article-2/section-9-3-33/" target="_blank" rel="noopener">O.C.G.A. § 9-3-33</a>) and South Carolina's 3-year limit (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>) apply. Evidence preservation is critical in car accident SCI cases — vehicle data recorders, surveillance footage, and physical evidence degrade or are destroyed quickly.</p>
HTML,
        'faqs' => array(
            array(
                'question' => 'How common are spinal cord injuries from car accidents?',
                'answer'   => 'Car accidents are the leading cause of spinal cord injuries, accounting for approximately 39% of all new SCIs. The extreme forces in vehicle collisions can fracture vertebrae, herniate discs, and damage or sever the spinal cord, causing paraplegia or tetraplegia.',
            ),
            array(
                'question' => 'What types of car crashes most commonly cause spinal cord injuries?',
                'answer'   => 'High-speed head-on collisions, rollovers, and T-bone crashes cause the most severe spinal cord injuries. Rear-end collisions can cause cervical SCI through hyperextension-hyperflexion. Ejection from the vehicle dramatically increases SCI risk.',
            ),
            array(
                'question' => 'What if the at-fault driver\'s insurance is not enough to cover my spinal cord injury?',
                'answer'   => 'SCI damages routinely exceed policy limits. We pursue all available coverage including your own underinsured motorist (UIM) policy, umbrella policies, employer liability (if the driver was working), and claims against additional liable parties such as vehicle manufacturers or trucking companies.',
            ),
            array(
                'question' => 'Can I also have a brain injury from the same car accident?',
                'answer'   => 'Yes. Concurrent traumatic brain injury (TBI) is very common in car accidents that cause spinal cord injuries — the same violent forces that damage the cord can also injure the brain. Both injuries must be fully evaluated and compensated, as concurrent TBI and SCI dramatically increase lifetime care costs.',
            ),
            array(
                'question' => 'How long do I have to file a spinal cord injury car accident claim?',
                'answer'   => 'Georgia allows 2 years (O.C.G.A. § 9-3-33) and South Carolina allows 3 years (S.C. Code § 15-3-530). Critical evidence like vehicle data recorders, surveillance footage, and the vehicle itself can be lost quickly, so immediate legal action is important.',
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
