<?php
/**
 * Seeder: medical-malpractice-lawyers × Myrtle Beach, SC intersection (ENRICH)
 *
 * UPDATES the existing /medical-malpractice-lawyers/myrtle-beach-sc/ page in
 * place with rich, practice-specific, hyperlocal content + FAQPage meta +
 * attorney attribution. Part of P2 row-9 BATCH 3.
 *
 * Template auto-generates SC state-law box, "what to do" steps, negligence
 * elements, compensation block, Key Takeaways, attorneys, case results, and FAQ
 * accordion. post_content ADDS: answer-first intro, "why Roden Law", local
 * hospitals/context, and med-mal SC nuances — no duplication.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-medmal-myrtle-beach.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching medical-malpractice-lawyers × Myrtle Beach, SC...' );

$pillar = get_page_by_path( 'medical-malpractice-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "medical-malpractice-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents patients harmed by medical negligence in Myrtle Beach, South Carolina and throughout the Grand Strand</strong> — Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and Georgetown. We handle every medical malpractice claim on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18436121980">(843) 612-1980</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Myrtle Beach Medical Malpractice Claim</h2>
<p>Medical malpractice is the most technical and heavily defended type of injury case in South Carolina — hospitals and their insurers retain specialized defense counsel and expert physicians from day one. What separates Roden Law is direct attorney involvement paired with the medical experts needed to prove a departure from the standard of care. We serve the Grand Strand from Murrells Inlet through Georgetown, and Horry County cases are filed at the courthouse in Conway — so investigation, records review, and filings happen without the delay of running a coastal case from a distant office.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to investigate your claim.</li>
<li><strong>Medical experts on every case</strong> — South Carolina requires an expert affidavit before suit, and we build that proof from the outset.</li>
<li><strong>Trial-ready</strong> — we prepare every claim for the Horry County courts in Conway, which is what moves hospital insurers to pay full value.</li>
</ul>

<h2>Grand Strand Medical Malpractice Cases We Handle</h2>
<p>Grand Strand patients are served by Grand Strand Medical Center and the region's Horry and Georgetown County hospitals, and the cases our attorneys see most often include:</p>
<ul>
<li><strong>Surgical errors and anesthesia mistakes</strong> at Grand Strand Medical Center and neighboring coastal hospitals.</li>
<li><strong>Misdiagnosis and delayed diagnosis</strong> — cancer, stroke, heart attack, and infection missed or read too late.</li>
<li><strong>Emergency-room negligence</strong> — a particular concern in a tourism region where seasonal patient volume strains ERs.</li>
<li><strong>Birth injuries</strong> — oxygen deprivation, improper delivery, and maternal-care failures.</li>
<li><strong>Medication and hospital-acquired-infection claims</strong> — wrong drug or dose and preventable post-operative infections.</li>
</ul>

<h2>South Carolina Medical Malpractice Law: What Grand Strand Patients Need to Know</h2>
<h3>You Must File a Notice of Intent and Expert Affidavit First</h3>
<p>Before you can sue for medical malpractice in South Carolina, you must file a <strong>Notice of Intent to File Suit accompanied by an expert affidavit under S.C. Code § 15-79-125</strong>, and the parties must complete a <strong>pre-suit mediation period</strong> before litigation begins. This expert requirement is why choosing an experienced malpractice firm early matters — the medical proof has to be in place before the case can even start.</p>
<h3>The Deadline: 3 Years, Capped by a 6-Year Repose</h3>
<p>The statute of limitations is generally <strong>three years from the date you discovered (or should have discovered) the injury, but no later than six years from the negligent act under S.C. Code § 15-3-545</strong>. A retained foreign object has its own two-year-from-discovery rule. These overlapping deadlines make prompt review essential.</p>
<h3>South Carolina Caps Non-Economic Damages in Med-Mal</h3>
<p>Unlike ordinary injury cases, South Carolina <strong>caps non-economic damages (pain and suffering) in medical malpractice under S.C. Code § 15-32-220</strong> — roughly <strong>$596,001 per provider or institution and about $1,788,003 in aggregate as of 2026</strong>, adjusted annually for inflation. <strong>Economic damages — medical bills, lost earnings, and future care — are not capped</strong>, and the cap can be lifted entirely where the conduct was grossly negligent, reckless, or willful.</p>

<h2>Learn More About South Carolina Injury Law</h2>
<ul>
<li><a href="/resources/south-carolina-comparative-negligence/">How South Carolina's comparative negligence rule affects your recovery</a></li>
</ul>
HTML;

$existing = get_posts( array(
	'post_type'      => 'practice_area',
	'post_status'    => array( 'publish', 'draft' ),
	'post_parent'    => $pillar_id,
	'name'           => 'myrtle-beach-sc',
	'posts_per_page' => 1,
) );

$postarr = array(
	'post_type'    => 'practice_area',
	'post_status'  => 'publish',
	'post_title'   => 'Medical Malpractice Lawyers in Myrtle Beach, SC',
	'post_name'    => 'myrtle-beach-sc',
	'post_content' => $content,
	'post_parent'  => $pillar_id,
);

if ( $existing ) {
	$post_id       = $existing[0]->ID;
	$postarr['ID'] = $post_id;
	wp_update_post( $postarr );
	WP_CLI::log( "Updated existing post ID: {$post_id}" );
} else {
	$post_id = wp_insert_post( $postarr, true );
	if ( is_wp_error( $post_id ) ) {
		WP_CLI::error( 'Failed to create page: ' . $post_id->get_error_message() );
	}
	WP_CLI::log( "Created post ID: {$post_id}" );
}

update_post_meta( $post_id, '_roden_pa_office_key', 'myrtle-beach' );
update_post_meta( $post_id, '_roden_office_key', 'myrtle-beach' );
update_post_meta( $post_id, '_roden_jurisdiction', 'south-carolina' );
if ( $attorney_id ) {
	update_post_meta( $post_id, '_roden_author_attorney', $attorney_id );
}

$faqs = array(
	array(
		'question' => 'Who are the best medical malpractice lawyers in Myrtle Beach, SC?',
		'answer'   => 'Roden Law is a leading medical malpractice firm serving Myrtle Beach and the Grand Strand, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. We handle every case on a contingency fee basis — no fee unless we win — and retain medical experts from the outset. Call (843) 612-1980 for a free consultation.',
	),
	array(
		'question' => 'How long do I have to file a medical malpractice claim in South Carolina?',
		'answer'   => 'Generally three years from the date you discovered or should have discovered the injury, but no later than six years from the negligent act (S.C. Code § 15-3-545). A retained foreign object has a separate two-year-from-discovery rule. Because these deadlines overlap, it is best to have your case reviewed promptly.',
	),
	array(
		'question' => 'Do I need an expert before suing for malpractice in Myrtle Beach?',
		'answer'   => 'Yes. South Carolina requires you to file a Notice of Intent to File Suit with a supporting expert affidavit before litigation, and the parties must complete a pre-suit mediation period (S.C. Code § 15-79-125). Roden Law lines up the necessary medical experts as part of investigating your claim.',
	),
	array(
		'question' => 'Is there a cap on medical malpractice damages in South Carolina?',
		'answer'   => 'Yes — but only on non-economic damages. Under S.C. Code § 15-32-220, non-economic damages are capped at roughly $596,001 per provider or institution and about $1,788,003 in aggregate as of 2026, adjusted annually for inflation. Economic damages such as medical bills, lost earnings, and future care are not capped, and the cap can be lifted for gross negligence, reckless, or willful conduct.',
	),
	array(
		'question' => 'How much does a Myrtle Beach medical malpractice lawyer cost?',
		'answer'   => 'Roden Law handles Grand Strand medical malpractice cases on a contingency fee basis. You pay no attorney fees and no upfront costs — including the cost of the medical experts needed to build your case — and we are only paid a percentage of the recovery if we win. If there is no recovery, you owe us nothing.',
	),
	array(
		'question' => 'What counts as medical malpractice at a Grand Strand hospital?',
		'answer'   => 'Medical malpractice occurs when a provider fails to meet the accepted standard of care of a reasonably prudent practitioner in the same specialty, and that failure causes harm. Common examples at institutions such as Grand Strand Medical Center include surgical errors, misdiagnosis, emergency-room negligence, birth injuries, and hospital-acquired infections.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /medical-malpractice-lawyers/myrtle-beach-sc/ — post ID {$post_id}" );
