<?php
/**
 * Seeder: FAQs for 20 Intersection Pages (Bicycle, E-Scooter, ATV, Golf Cart × 5 cities)
 *
 * Run via WP-CLI on WP Engine:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-intersection-faqs-batch2.php
 *
 * Idempotent — skips pages that already have FAQs.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Office data for phone numbers and jurisdiction detection
   ------------------------------------------------------------------ */

$offices = array(
    'savannah-ga'    => array( 'city' => 'Savannah',       'state' => 'GA', 'state_full' => 'Georgia',          'phone' => '(912) 303-5850', 'court' => 'Chatham County Superior Court' ),
    'darien-ga'      => array( 'city' => 'Darien',         'state' => 'GA', 'state_full' => 'Georgia',          'phone' => '(912) 303-5850', 'court' => 'McIntosh County Superior Court' ),
    'charleston-sc'  => array( 'city' => 'Charleston',     'state' => 'SC', 'state_full' => 'South Carolina',   'phone' => '(843) 790-8999', 'court' => 'Charleston County Circuit Court' ),
    'columbia-sc'    => array( 'city' => 'Columbia',        'state' => 'SC', 'state_full' => 'South Carolina',   'phone' => '(803) 219-2816', 'court' => 'Richland County Circuit Court' ),
    'myrtle-beach-sc'=> array( 'city' => 'Myrtle Beach',   'state' => 'SC', 'state_full' => 'South Carolina',   'phone' => '(843) 612-1980', 'court' => 'Horry County Circuit Court' ),
);

/* ------------------------------------------------------------------
   FAQ templates per practice area — {city}, {state}, {state_full},
   {phone}, {court}, {sol}, {sol_cite}, {fault_pct}, {fault_cite}
   are replaced per office.
   ------------------------------------------------------------------ */

$faq_templates = array(

    /* ============================================================
       BICYCLE ACCIDENT
       ============================================================ */
    'bicycle-accident-lawyers' => array(
        array(
            'question' => 'What should I do after a bicycle accident in {city}?',
            'answer'   => 'After a bicycle accident in {city}, your first priority is getting medical attention — even if you feel fine, many injuries like concussions and internal bleeding do not show symptoms immediately. Call 911 and file a police report with {court} jurisdiction. Document the scene with photos of your bicycle, any vehicle involved, road conditions, and your injuries. Get the driver\'s insurance information and contact details for any witnesses. Do not give a recorded statement to the driver\'s insurance company before speaking with an attorney. Contact Roden Law at {phone} for a free consultation — we handle all bicycle accident cases on a contingency fee basis, so you pay nothing unless we win your case.',
        ),
        array(
            'question' => 'Can I sue a driver who hit me while I was cycling in {state_full}?',
            'answer'   => 'Yes. In {state_full}, bicyclists have the same rights to the road as motor vehicle drivers. If a driver\'s negligence caused your bicycle accident — whether through distracted driving, failure to yield, dooring, or running a red light — you can file a personal injury claim against them. {state_full} follows a modified comparative fault rule, meaning you can recover damages as long as you are less than {fault_pct}% at fault ({fault_cite}). Even if the driver claims you were partially responsible, an experienced bicycle accident attorney can help demonstrate the full extent of their negligence. Our {city} attorneys have recovered over $250 million for injured clients across Georgia and South Carolina.',
        ),
        array(
            'question' => 'How long do I have to file a bicycle accident lawsuit in {state_full}?',
            'answer'   => 'In {state_full}, the statute of limitations for personal injury claims, including bicycle accidents, is {sol} from the date of the accident ({sol_cite}). If you miss this deadline, you will almost certainly lose your right to pursue compensation. While {sol} may seem like enough time, evidence disappears, witnesses forget details, and insurance companies use delays against you. We recommend consulting a bicycle accident attorney as soon as possible after your accident. Call our {city} office at {phone} for a free case evaluation.',
        ),
        array(
            'question' => 'What compensation can I receive for a bicycle accident in {city}?',
            'answer'   => 'Bicycle accident victims in {city} may be entitled to compensation for medical bills (emergency care, surgery, rehabilitation, and future treatment), lost wages and reduced earning capacity, pain and suffering, property damage to your bicycle and equipment, scarring and disfigurement, and loss of enjoyment of life. Because cyclists have no protective barrier like a vehicle occupant, bicycle accident injuries tend to be severe — traumatic brain injuries, broken bones, spinal injuries, and road rash are common. The value of your case depends on the severity of your injuries, the impact on your daily life, and the strength of the evidence. At Roden Law, we fight to recover the full value of your claim, not a lowball insurance settlement. Call {phone} for a free consultation.',
        ),
        array(
            'question' => 'Do I need a lawyer for a bicycle accident claim in {city}?',
            'answer'   => 'While you are not legally required to hire an attorney, bicycle accident claims present unique challenges that benefit from experienced legal representation. Insurance companies routinely blame cyclists for accidents, minimize injuries by claiming pre-existing conditions, and offer settlements far below the true value of the case. An experienced bicycle accident lawyer can investigate the accident (including obtaining traffic camera footage and accident reconstruction), handle all insurance company communications, calculate the full value of your current and future damages, and negotiate or litigate for maximum compensation. At Roden Law, we handle bicycle accident cases on a contingency fee basis — you pay nothing upfront and owe no fees unless we win. Call our {city} office at {phone}.',
        ),
        array(
            'question' => 'What if the driver who hit me on my bicycle left the scene in {city}?',
            'answer'   => 'Hit-and-run bicycle accidents are unfortunately common, but you still have options for recovering compensation. If you have uninsured motorist (UM) coverage on your auto insurance policy, it may cover your bicycle accident injuries even though you were not driving a car at the time. You should immediately report the hit-and-run to the {city} police and file a report. Document everything you remember about the vehicle (color, make, model, license plate, direction of travel). Check for nearby surveillance cameras that may have captured the accident. An experienced attorney can help track down the driver and maximize your recovery through all available insurance sources. Contact Roden Law at {phone} — we have handled numerous hit-and-run bicycle cases across {state_full}.',
        ),
    ),

    /* ============================================================
       ELECTRIC SCOOTER ACCIDENT
       ============================================================ */
    'electric-scooter-accident-lawyers' => array(
        array(
            'question' => 'Who is liable for an electric scooter accident in {city}?',
            'answer'   => 'Liability in an electric scooter accident in {city} can fall on multiple parties depending on the circumstances. A negligent motor vehicle driver who strikes a scooter rider may be liable. The scooter rental company (such as Bird, Lime, or Spin) may be liable if the scooter was defectively maintained or had mechanical issues. The scooter manufacturer may be liable under product liability if a design or manufacturing defect caused the accident. The city or property owner may be liable if dangerous road conditions (potholes, uneven pavement, missing signage) contributed to the crash. In {state_full}, you can recover damages as long as you are less than {fault_pct}% at fault ({fault_cite}). Our {city} attorneys can investigate your accident and identify all liable parties to maximize your recovery. Call {phone} for a free consultation.',
        ),
        array(
            'question' => 'Can I sue a scooter company like Bird or Lime after an accident in {state_full}?',
            'answer'   => 'Yes, but it can be complex. Scooter rental companies typically require users to agree to terms of service that include liability waivers and arbitration clauses before riding. However, these waivers do not protect the company from all claims — particularly if the accident was caused by a defective or poorly maintained scooter. In {state_full}, waivers cannot absolve a company of liability for gross negligence or willful misconduct. Additionally, if you were injured as a bystander or pedestrian (not a rider), the waiver does not apply to you at all. An experienced attorney can review the specific terms and circumstances of your case. Contact our {city} office at {phone} for a free evaluation of your scooter accident claim.',
        ),
        array(
            'question' => 'What is the statute of limitations for an electric scooter accident in {state_full}?',
            'answer'   => 'In {state_full}, you have {sol} from the date of the accident to file a personal injury lawsuit for an electric scooter accident ({sol_cite}). If a defective scooter caused the crash, you may also have a product liability claim with the same deadline. Missing the statute of limitations will permanently bar your claim, so it is critical to contact an attorney promptly. Call Roden Law at {phone} for a free consultation with our {city} team.',
        ),
        array(
            'question' => 'What should I do after an electric scooter accident in {city}?',
            'answer'   => 'After an electric scooter accident in {city}: seek medical attention immediately, even for seemingly minor injuries; call 911 and file a police report; photograph the scooter (including the ID number), the accident scene, road conditions, and your injuries; save the scooter rental app data showing your trip details and rental agreement; get contact information from any witnesses; do not admit fault or give a recorded statement to any insurance company; and contact an attorney before accepting any settlement. Electric scooter accident evidence can disappear quickly — rental companies may repair or redistribute the scooter, and app data may be deleted. Our {city} attorneys can send a preservation letter to protect this critical evidence. Call {phone} today.',
        ),
        array(
            'question' => 'Does my health insurance cover electric scooter accident injuries in {state_full}?',
            'answer'   => 'Your health insurance will typically cover treatment for electric scooter accident injuries, but it may assert a subrogation lien (a right to be reimbursed from any settlement or verdict you receive). Auto insurance may also apply — if you have uninsured/underinsured motorist coverage and a vehicle was involved, your auto policy may cover your scooter accident injuries. The scooter rental company\'s commercial insurance policy may also provide coverage. Navigating multiple insurance sources is one of the most complex aspects of e-scooter accident claims. Our {city} attorneys can identify all available coverage sources and negotiate lien reductions to maximize the money you take home. Call Roden Law at {phone} for a free case review.',
        ),
        array(
            'question' => 'How much is my electric scooter accident case worth in {city}?',
            'answer'   => 'The value of your electric scooter accident case depends on the severity of your injuries, the total medical costs (past and future), lost income, pain and suffering, and the degree of the at-fault party\'s negligence. Common e-scooter injuries include traumatic brain injuries (many riders don\'t wear helmets), broken bones, facial injuries, dental damage, and road rash. Severe cases involving permanent disability or disfigurement are worth significantly more. Insurance companies often try to minimize scooter accident claims, but at Roden Law we have recovered over $250 million for our clients and we fight for the full value of every case. Call our {city} office at {phone} for a free, no-obligation consultation.',
        ),
    ),

    /* ============================================================
       ATV / SIDE-BY-SIDE ACCIDENT
       ============================================================ */
    'atv-side-by-side-accident-lawyers' => array(
        array(
            'question' => 'Who can be held liable for an ATV accident in {state_full}?',
            'answer'   => 'Multiple parties may be liable for an ATV or side-by-side accident in {state_full}. The operator of another vehicle involved in the crash may be liable for negligent driving. The property owner or landowner who allowed unsafe ATV use on their property may be liable under premises liability. The ATV manufacturer may be liable under product liability if a design defect, manufacturing defect, or inadequate safety warnings caused or worsened the accident. A rental or tour company may be liable if they provided a defective vehicle or inadequate safety instruction. In {state_full}, you can recover compensation as long as you are less than {fault_pct}% at fault ({fault_cite}). Our {city} ATV accident attorneys can investigate your case and identify all responsible parties. Call {phone} for a free consultation.',
        ),
        array(
            'question' => 'What is the statute of limitations for an ATV accident in {state_full}?',
            'answer'   => 'In {state_full}, you have {sol} from the date of the ATV accident to file a personal injury lawsuit ({sol_cite}). If a minor was injured, the statute of limitations may be tolled (paused) until they reach the age of majority. If a defective ATV caused the accident, a product liability claim has the same deadline. Missing this deadline will permanently bar your case. ATV accident investigations benefit from prompt action — physical evidence at the accident site deteriorates, and the ATV itself may be repaired or scrapped. Contact Roden Law at {phone} as soon as possible after your accident.',
        ),
        array(
            'question' => 'Can I file a lawsuit if my child was injured in an ATV accident in {city}?',
            'answer'   => 'Yes. ATV accidents involving children are tragically common — the Consumer Product Safety Commission reports that children under 16 account for a significant percentage of ATV-related injuries and deaths each year. In {state_full}, parents or legal guardians can file a personal injury claim on behalf of a minor child. Potential defendants include the ATV manufacturer (especially if the vehicle was not age-appropriate), the property owner who allowed a child to ride without proper supervision, and any adult who permitted or encouraged unsafe riding. {state_full} law also considers whether the child was provided with a helmet and other safety equipment. Our {city} attorneys handle child ATV injury cases with sensitivity and determination. Call {phone} for a free consultation.',
        ),
        array(
            'question' => 'What compensation can I get for an ATV accident injury in {city}?',
            'answer'   => 'ATV and side-by-side accident victims in {city} may recover compensation for emergency medical treatment and hospitalization, ongoing medical care including surgery and rehabilitation, lost wages and future earning capacity, pain and suffering, permanent disability or disfigurement, property damage to the ATV and equipment, and wrongful death damages if a loved one was killed. ATV accidents frequently result in catastrophic injuries — spinal cord injuries, traumatic brain injuries, amputations, and severe burns — because riders have minimal protection. The value of your case depends on the severity of the injuries and the available insurance coverage. At Roden Law, we have recovered over $250 million for injured clients. Call our {city} office at {phone} for a free case evaluation.',
        ),
        array(
            'question' => 'Is the ATV manufacturer liable if the vehicle rolled over in {state_full}?',
            'answer'   => 'ATVs and side-by-sides have a well-documented history of rollover accidents, and the manufacturer may be liable under {state_full} product liability law if a design defect contributed to the rollover. Common defects include an unreasonably high center of gravity, inadequate roll-cage protection in side-by-sides, defective steering or suspension components, insufficient warnings about rollover risk, and lack of seatbelts or occupant restraint systems. In {state_full}, product liability claims can be based on strict liability (the product was unreasonably dangerous) or negligence (the manufacturer failed to exercise reasonable care). You do not need to prove the manufacturer was negligent under strict liability — only that the product was defective and caused your injuries. Our {city} attorneys work with accident reconstruction and engineering experts to build strong product liability cases. Call {phone} for a free consultation.',
        ),
        array(
            'question' => 'Do I need a lawyer for an ATV accident claim in {city}?',
            'answer'   => 'ATV accident cases are significantly more complex than typical car accident claims because they often involve multiple liable parties (manufacturer, property owner, rental company), product liability theories requiring expert analysis, recreational use waivers that insurance companies use to deny claims, and off-road locations where evidence is harder to preserve. Insurance companies frequently argue that ATV riding is an inherently dangerous activity and that the rider assumed the risk. An experienced ATV accident attorney can counter these defenses and fight for the compensation you deserve. At Roden Law, we handle ATV accident cases on a contingency fee basis — you pay nothing unless we win. Call our {city} office at {phone}.',
        ),
    ),

    /* ============================================================
       GOLF CART ACCIDENT
       ============================================================ */
    'golf-cart-accident-lawyers' => array(
        array(
            'question' => 'Can I sue after a golf cart accident in {city}?',
            'answer'   => 'Yes. If you were injured in a golf cart accident in {city} due to someone else\'s negligence, you have the right to pursue a personal injury claim. Golf cart accidents can occur on golf courses, in residential communities, on public roads where golf carts are permitted, and at resorts or commercial properties. Potential defendants include the negligent golf cart operator, the golf course or resort that owns and maintains the cart, a property owner who failed to maintain safe paths, and the golf cart manufacturer if a mechanical defect caused the accident. In {state_full}, you can recover damages as long as you are less than {fault_pct}% at fault ({fault_cite}). Contact Roden Law at {phone} for a free consultation.',
        ),
        array(
            'question' => 'What is the statute of limitations for a golf cart accident in {state_full}?',
            'answer'   => 'In {state_full}, you have {sol} from the date of the golf cart accident to file a personal injury lawsuit ({sol_cite}). This deadline applies whether the accident occurred on a golf course, a public road, or private property. If a defective golf cart caused the crash, the same deadline applies to product liability claims. Do not wait to seek legal advice — evidence like surveillance footage, maintenance records, and witness memories deteriorate quickly. Call our {city} office at {phone} for a free case evaluation.',
        ),
        array(
            'question' => 'Who is liable for a golf cart accident on a golf course in {city}?',
            'answer'   => 'Liability for a golf course golf cart accident in {city} depends on the specific circumstances. The golf cart operator may be liable for reckless or negligent driving (speeding, sharp turns, distracted operation, or driving under the influence). The golf course may be liable if they failed to properly maintain the golf cart, failed to enforce safety rules, or had dangerous course conditions (steep hills, blind curves, poorly maintained cart paths). The golf cart manufacturer may be liable if a defect in the brakes, steering, or other components caused or contributed to the accident. Golf courses often require liability waivers, but these waivers typically do not protect against gross negligence or willful misconduct in {state_full}. Our {city} attorneys can review the facts of your case and identify all liable parties. Call {phone}.',
        ),
        array(
            'question' => 'Are golf cart accidents covered by auto insurance in {state_full}?',
            'answer'   => 'Golf cart insurance coverage in {state_full} depends on where the accident occurred and the type of golf cart. If the golf cart was being operated on a public road (where permitted by local ordinance), auto insurance may apply. If the accident occurred on a golf course, the course\'s commercial liability insurance is typically the primary coverage. Homeowner\'s insurance may cover golf cart accidents that occur on residential property. Some golf cart owners carry separate golf cart liability policies. If the at-fault party has no insurance, your own uninsured motorist coverage may apply. Identifying the correct insurance coverage is a critical first step in any golf cart accident claim. Our {city} attorneys can investigate all available coverage sources. Call Roden Law at {phone} for a free consultation.',
        ),
        array(
            'question' => 'What injuries are common in golf cart accidents in {city}?',
            'answer'   => 'Golf cart accidents cause more serious injuries than many people expect. Because golf carts lack seatbelts, airbags, and enclosed cabins, occupants are vulnerable to ejection and direct impact injuries. Common golf cart accident injuries include traumatic brain injuries and concussions (especially when riders are ejected), broken bones (arms, wrists, hips, and legs), spinal cord injuries and back injuries, lacerations and road rash, crush injuries when carts tip over, and wrongful death in severe cases. Children and elderly passengers are particularly vulnerable. If you or a family member was injured in a golf cart accident, you may be entitled to compensation for medical expenses, lost wages, pain and suffering, and more. Call our {city} office at {phone} for a free case review.',
        ),
        array(
            'question' => 'Can I get compensation if I was a passenger in a golf cart accident in {state_full}?',
            'answer'   => 'Yes. As a golf cart passenger, you were not operating the vehicle and bear no fault for the accident in most cases. You can file a claim against the driver of the golf cart, the golf course or property owner, and/or the golf cart manufacturer — whoever was responsible for the accident. Passenger claims are often stronger than driver claims because the passenger clearly did not contribute to the negligent operation of the vehicle. In {state_full}, comparative fault rules ({fault_cite}) mean your compensation would only be reduced if you somehow contributed to your own injuries (for example, by distracting the driver or riding in an unsafe position). Our {city} golf cart accident lawyers can help you recover the full compensation you deserve. Call {phone} for a free consultation.',
        ),
    ),
);

/* ------------------------------------------------------------------
   Jurisdiction-specific replacement values
   ------------------------------------------------------------------ */

$jurisdiction = array(
    'GA' => array(
        'sol'        => '2 years',
        'sol_cite'   => 'O.C.G.A. § 9-3-33',
        'fault_pct'  => '50',
        'fault_cite' => 'O.C.G.A. § 51-12-33',
    ),
    'SC' => array(
        'sol'        => '3 years',
        'sol_cite'   => 'S.C. Code § 15-3-530',
        'fault_pct'  => '51',
        'fault_cite' => 'S.C. Code § 15-38-15',
    ),
);

/* ------------------------------------------------------------------
   Process each practice area × city combination
   ------------------------------------------------------------------ */

$total_updated = 0;
$total_skipped = 0;

foreach ( $faq_templates as $pillar_slug => $template_faqs ) {

    $pillar = get_page_by_path( $pillar_slug, OBJECT, 'practice_area' );
    if ( ! $pillar ) {
        WP_CLI::warning( "Pillar \"{$pillar_slug}\" not found — skipping." );
        continue;
    }

    foreach ( $offices as $city_slug => $office ) {

        // Find the intersection page (child of pillar with this city slug)
        $children = get_posts( array(
            'post_type'      => 'practice_area',
            'post_parent'    => $pillar->ID,
            'name'           => $city_slug,
            'posts_per_page' => 1,
            'post_status'    => 'publish',
        ) );

        if ( empty( $children ) ) {
            WP_CLI::warning( "{$pillar_slug}/{$city_slug} — intersection page not found." );
            continue;
        }

        $page = $children[0];

        // Check if FAQs already exist
        $existing = get_post_meta( $page->ID, '_roden_faqs', true );
        if ( is_array( $existing ) && count( $existing ) > 0 ) {
            WP_CLI::log( "SKIP {$pillar_slug}/{$city_slug} (ID {$page->ID}) — already has " . count( $existing ) . " FAQs." );
            $total_skipped++;
            continue;
        }

        // Build replacement values
        $j    = $jurisdiction[ $office['state'] ];
        $vars = array(
            '{city}'       => $office['city'],
            '{state}'      => $office['state'],
            '{state_full}' => $office['state_full'],
            '{phone}'      => $office['phone'],
            '{court}'      => $office['court'],
            '{sol}'        => $j['sol'],
            '{sol_cite}'   => $j['sol_cite'],
            '{fault_pct}'  => $j['fault_pct'],
            '{fault_cite}' => $j['fault_cite'],
        );

        // Apply replacements to each FAQ
        $faqs = array();
        foreach ( $template_faqs as $tpl ) {
            $faqs[] = array(
                'question' => str_replace( array_keys( $vars ), array_values( $vars ), $tpl['question'] ),
                'answer'   => str_replace( array_keys( $vars ), array_values( $vars ), $tpl['answer'] ),
            );
        }

        update_post_meta( $page->ID, '_roden_faqs', $faqs );
        WP_CLI::success( "{$pillar_slug}/{$city_slug} (ID {$page->ID}) — " . count( $faqs ) . " FAQs added." );
        $total_updated++;
    }
}

WP_CLI::log( "\n--- SUMMARY ---" );
WP_CLI::log( "Updated: {$total_updated} pages" );
WP_CLI::log( "Skipped: {$total_skipped} pages (already had FAQs)" );
WP_CLI::log( "Done." );
