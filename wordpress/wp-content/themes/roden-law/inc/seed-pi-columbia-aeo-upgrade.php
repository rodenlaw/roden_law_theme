<?php
/**
 * Seeder: (re)create /personal-injury-lawyers/columbia-sc/ with AEO content
 *
 * The PA URL silo dedup removed the PI city-intersection set and left the
 * personal-injury-lawyers pillar childless. Per explicit decision (2026-06-23)
 * we recreate a dedicated Columbia PI city page to target "best PI attorney
 * Columbia SC" — distinct from the car-accident Columbia page because it spans
 * all injury types. Answer-first trust-signal lead + 7 FAQs (FAQPage schema).
 *
 * Office local_context (Malfunction Junction / Carolina Crossroads / Prisma
 * Richland) renders separately via template-intersection.php — not duplicated.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-pi-columbia-aeo-upgrade.php
 *
 * Safe to re-run: updates in place if the page already exists.
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( '(Re)creating /personal-injury-lawyers/columbia-sc/...' );

$pillar = get_page_by_path( 'personal-injury-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "personal-injury-lawyers" not found.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents injured people in Columbia, South Carolina and across the Midlands</strong> — Lexington, Irmo, West Columbia, Cayce, Forest Acres, and Blythewood. We hold a <strong>4.9-star average rating from 500+ client reviews</strong>, have recovered <strong>more than $300 million</strong> for injured clients, and take every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Our Columbia attorneys know the local courts, the local insurance adjusters, and the specific accident patterns that put Midlands residents at risk — from the I-20/I-26/I-77 interchange to the University of South Carolina area to Fort Jackson's surrounding roads. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free consultation.</p>

<h2>Personal Injury Cases We Handle in Columbia</h2>
<p>Our Columbia office handles personal injury cases arising throughout Richland County and the surrounding Midlands:</p>
<ul>
<li><a href="/car-accident-lawyers/columbia-sc/">Car Accidents</a> — I-20, I-26, I-77, US-1, Garners Ferry Road, Gervais Street</li>
<li><a href="/truck-accident-lawyers/columbia-sc/">Truck &amp; Commercial Vehicle Accidents</a> — I-20/I-77 corridor, distribution-center traffic</li>
<li><a href="/slip-and-fall-lawyers/columbia-sc/">Slip and Fall / Premises Liability</a> — USC campus, State House area, shopping centers</li>
<li><a href="/motorcycle-accident-lawyers/columbia-sc/">Motorcycle Accidents</a> — Broad River Road, Two Notch Road, Garners Ferry Road</li>
<li><a href="/workers-compensation-lawyers/columbia-sc/">Workers' Compensation</a> — government workers, contractors, warehousing, healthcare</li>
<li><a href="/wrongful-death-lawyers/columbia-sc/">Wrongful Death</a> — fatal accidents throughout Richland and Lexington Counties</li>
<li><a href="/medical-malpractice-lawyers/columbia-sc/">Medical Malpractice</a> — Prisma Health, Lexington Medical Center</li>
<li><a href="/brain-injury-lawyers/columbia-sc/">Brain &amp; Head Injuries</a> — TBI from crashes and falls</li>
<li><a href="/pedestrian-accident-lawyers/columbia-sc/">Pedestrian Accidents</a> — USC-area and downtown foot traffic</li>
<li><a href="/bicycle-accident-lawyers/columbia-sc/">Bicycle Accidents</a> — Saluda River Greenway, city bike lanes</li>
</ul>

<h2>Why Hire a Local Columbia Personal Injury Attorney?</h2>
<p>Columbia's personal injury market is dominated by well-funded firms that rely on heavy advertising. What sets Roden Law apart is direct attorney involvement in every case: you work with your attorney — not a rotating team of paralegals — from intake through resolution. Our office at 1545 Sumter Street, Suite B sits in the downtown corridor near the University of South Carolina, minutes from the Richland County Court of Common Pleas, so filings, hearings, and client meetings happen without delay.</p>

<h2>South Carolina Personal Injury Law: What Columbia Clients Need to Know</h2>
<h3>Filing Deadline: 3 Years</h3>
<p>South Carolina's statute of limitations for personal injury claims is <strong>three years under S.C. Code § 15-3-530</strong>. Do not mistake a longer deadline for flexibility — evidence disappears quickly, and the earlier we begin investigating, the stronger your claim.</p>
<h3>Modified Comparative Fault</h3>
<p>South Carolina uses <strong>modified comparative fault</strong>, allowing recovery as long as you are <strong>less than 51% responsible</strong>. Insurance adjusters routinely try to shift blame onto the injured party to cut their payout — our attorneys anticipate and counter that strategy.</p>
<h3>Filing in Richland County</h3>
<p>Personal injury lawsuits in Columbia are filed in the <strong>Richland County Court of Common Pleas at 1701 Main Street</strong>. Our attorneys know the local rules, judges, and procedural expectations — knowledge that directly benefits your case.</p>

<h2>Columbia's Most Dangerous Roads and Accident Areas</h2>
<ul>
<li><strong>I-20/I-26/I-77 interchange (Malfunction Junction):</strong> one of South Carolina's most complex exchanges, now in the middle of SCDOT's $2.08 billion Carolina Crossroads reconstruction, with heavy commercial traffic and frequent rear-end and lane-change crashes.</li>
<li><strong>Two Notch Road (US-1):</strong> long commercial corridor with numerous signalized intersections and high pedestrian activity.</li>
<li><strong>Garners Ferry Road:</strong> major Southeast Columbia arterial with significant truck and commuter traffic.</li>
<li><strong>Broad River Road:</strong> Northwest Columbia corridor with heavy traffic near Harbison and Dutch Square.</li>
<li><strong>USC and Five Points:</strong> dense pedestrian activity and DUI-involved crash risk, especially at night and on weekends.</li>
</ul>

<h2>Compensation Available in South Carolina Personal Injury Cases</h2>
<ul>
<li><strong>Medical expenses</strong> — emergency care, surgery, hospitalization, physical therapy, future care</li>
<li><strong>Lost wages and earning capacity</strong> — for short-term recovery and permanent disability</li>
<li><strong>Pain and suffering</strong> — non-economic damages, uncapped in standard SC personal injury cases</li>
<li><strong>Property damage</strong> — vehicle repair or replacement</li>
<li><strong>Punitive damages</strong> — for reckless or willful misconduct</li>
</ul>

<h2>What to Do After a Personal Injury in Columbia</h2>
<ol>
<li>Call 911 and obtain a copy of the police or incident report.</li>
<li>Document the scene with photographs before conditions change.</li>
<li>Gather witness names and contact information.</li>
<li>Seek immediate medical care — gaps in treatment are used against claimants. Serious-injury victims are routed to Prisma Health Richland, the Midlands' only Level I trauma center.</li>
<li>Avoid giving recorded statements to insurance adjusters.</li>
<li>Call Roden Law's Columbia office at (803) 219-2816 for a free, confidential case evaluation.</li>
</ol>
HTML;

$existing = get_posts( array(
	'post_type'      => 'practice_area',
	'post_status'    => array( 'publish', 'draft' ),
	'post_parent'    => $pillar_id,
	'name'           => 'columbia-sc',
	'posts_per_page' => 1,
) );

$postarr = array(
	'post_type'    => 'practice_area',
	'post_status'  => 'publish',
	'post_title'   => 'Personal Injury Lawyers in Columbia, SC',
	'post_name'    => 'columbia-sc',
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

update_post_meta( $post_id, '_roden_office_key', 'columbia' );
update_post_meta( $post_id, '_roden_jurisdiction', 'south-carolina' );
update_post_meta( $post_id, '_roden_sol_sc', '3 years (S.C. Code § 15-3-530)' );
if ( $attorney_id ) {
	update_post_meta( $post_id, '_roden_author_attorney', $attorney_id );
}

$faqs = array(
	array(
		'question' => 'Who are the best personal injury lawyers in Columbia, SC?',
		'answer'   => 'Roden Law is a leading personal injury firm serving Columbia and the South Carolina Midlands, with a 4.9-star average from 500+ client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles car accidents, truck wrecks, slip and falls, and wrongful death on a contingency fee basis — no fee unless we win — and you work directly with your attorney. Call (803) 219-2816 for a free consultation.',
	),
	array(
		'question' => 'How long do I have to file a personal injury lawsuit in Columbia, South Carolina?',
		'answer'   => 'In South Carolina the statute of limitations for most personal injury claims is three years from the date of injury (S.C. Code § 15-3-530). Missing it almost always bars recovery, and a shorter notice period can apply if a government entity is involved. Contact an attorney early — evidence disappears quickly.',
	),
	array(
		'question' => 'What is modified comparative fault in South Carolina?',
		'answer'   => 'South Carolina follows modified comparative fault: you can recover as long as you are less than 51% responsible, with your award reduced by your share of fault. Insurers routinely try to inflate your fault percentage — an experienced Columbia attorney pushes back to keep it as low as the facts support.',
	),
	array(
		'question' => 'How much does a Columbia personal injury lawyer cost?',
		'answer'   => 'Roden Law handles personal injury cases on a contingency fee basis — no fees upfront and nothing owed unless we win. Our fee is a percentage of the recovery, so anyone injured in Columbia can access experienced representation regardless of their finances.',
	),
	array(
		'question' => 'What compensation can I recover in a Columbia personal injury case?',
		'answer'   => 'You may recover economic damages (medical bills, lost wages, reduced earning capacity, property damage) and non-economic damages (pain and suffering, emotional distress, loss of enjoyment of life), which South Carolina does not cap in standard cases. Punitive damages are available for reckless or willful misconduct.',
	),
	array(
		'question' => 'Do I need a lawyer for a personal injury claim in Columbia?',
		'answer'   => 'You are not required to, but represented claimants typically recover significantly more than those who negotiate alone, even after fees. An attorney investigates the crash, values future medical costs accurately, handles the insurers, and is ready to try the case. Roden Law works on contingency, so there is no upfront cost to find out what your claim is worth.',
	),
	array(
		'question' => 'What should I do immediately after an accident in Columbia?',
		'answer'   => 'Seek medical attention right away, call 911 and file a police report, photograph the scene, collect witness contact information, and do not give a recorded statement to any insurer before speaking with an attorney. Then call Roden Law at (803) 219-2816 — the sooner we investigate, the stronger your case.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

flush_rewrite_rules();
WP_CLI::success( "Published /personal-injury-lawyers/columbia-sc/ — post ID {$post_id}" );
