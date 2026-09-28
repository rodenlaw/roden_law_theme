<?php
/**
 * Rewrite /resources/columbia-i-26-i-20-i-77-interchange-truck-accidents/ (post
 * 4656) in place. Columbia car legal sweep, L4
 * (data/facts/remediation-2026-09-28-columbia-car.md); owner, 2026-09-28: "let's
 * fix these last 4 items before moving on".
 *
 * The URL is kept: it earns 5,852 impressions / 16 months at position 7 on
 * "i-26 and i-77 interchange columbia" (docs/site-architecture/evidence/
 * inventory.csv). What was wrong, checked 2026-09-28:
 * - There is no single "I-26/I-20/I-77 interchange". I-77 begins at I-26 Exit 116
 *   in Cayce, south of downtown; I-20 meets I-77 east of downtown and I-26 west
 *   of downtown (Malfunction Junction, I-26 Exit 107), not "I-20/I-26/US-378".
 * - The "weaving" example routed I-26 -> I-20 -> I-77; a truck from Charleston
 *   takes I-26 Exit 116 straight onto I-77.
 * - "Joint and several liability … each liable party … the full amount": a
 *   defendant less than 50% at fault is only severally liable (SC 15-38-15).
 * - "Less than 51% at fault" restated as Nelson's 50%-or-less; unsourced "584
 *   killed 2016-2020", "highest crash-rate counties", "only city", "most
 *   dangerous" superlatives, "legally requires" preservation, and punitive
 *   damages for "dispatching drivers through known dangerous interchanges" cut.
 * Carolina Crossroads figures are the project site's (scdotcarolinacrossroads.com,
 * read 2026-09-28). Every legal sentence rests on the signed SC pack.
 *
 * Title, content, excerpt, key takeaways and FAQs replaced; slug, author and
 * jurisdiction unchanged. Direct column write (post_modified untouched); meta via
 * update_post_meta( wp_slash() ); read back.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/rewrite-columbia-interchange-resource.php > docs/backups/columbia-interchange-resource-2026-09-28.json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/rewrite-columbia-interchange-resource.php > docs/backups/columbia-interchange-resource-2026-09-28.json
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply = isset( $args[0] ) && 'apply' === $args[0];
$id    = 4656;
global $wpdb;

$p = get_post( $id );
if ( ! $p || 'resource' !== $p->post_type || 'publish' !== $p->post_status || 0 !== strpos( $p->post_title, "Columbia's I-26/I-20/I-77 Interchange" ) ) {
	fwrite( STDERR, "ABORT: post {$id} is not the interchange resource the sweep read.\n" );
	exit( 1 );
}

$title = 'Truck Accidents at Columbia\'s I-20, I-26 and I-77 Interchanges';

$body = <<<'HTML'
<h2>Where Columbia's Interstates Meet</h2>
<p>Three interstates serve Columbia, and each meets the others at a separate interchange. Much of the Midlands' freight passes through at least one of them:</p>
<ul>
<li><strong>I-26 and I-77, south of downtown.</strong> I-77 begins at I-26 Exit 116 in Cayce and curves east around Columbia and then runs north toward Rock Hill and Charlotte. A truck coming from Charleston on I-26 and bound for Charlotte takes this interchange straight onto I-77. See <a href="/resources/i-77-truck-accidents-columbia-rock-hill/">I-77 truck accidents from Columbia to Rock Hill</a>.</li>
<li><strong>I-20 and I-26, west of downtown.</strong> This is the interchange known locally as Malfunction Junction, at I-26 Exit 107. See <a href="/resources/bush-river-road-i-26-truck-accidents-columbia/">Bush River Road and I-26</a>.</li>
<li><strong>I-20 and I-77, northeast of downtown.</strong> Traffic between I-20 and I-77 changes here. See <a href="/resources/i-20-truck-accidents-columbia/">I-20 truck accidents in the Columbia area</a>.</li>
</ul>
<p>I-126 leaves I-26 at Exit 108 and carries traffic into downtown Columbia.</p>

<h2>Carolina Crossroads: Work Zones Around Malfunction Junction</h2>
<p>SCDOT's <a href="https://www.scdotcarolinacrossroads.com/" target="_blank" rel="noopener">Carolina Crossroads</a> project is reconfiguring 14 miles of the I-20/I-26/I-126 corridor, a $2.69 billion investment. SCDOT says more than 134,000 vehicles travel through that corridor every day. Construction began in November 2021 and is expected to be substantially complete in the mid-2030s, so drivers face shifting lanes, ramp changes and narrowed shoulders for years. See <a href="/resources/carolina-crossroads-construction-zone-truck-accidents/">Carolina Crossroads construction zone accidents</a>.</p>

<h2>How Interchange Truck Crashes Happen</h2>
<table>
<thead>
<tr><th>Crash type</th><th>How it happens</th></tr>
</thead>
<tbody>
<tr><td>Sideswipe</td><td>A truck changes lanes into a vehicle in its blind spot while moving toward a ramp</td></tr>
<tr><td>Rear-end</td><td>A truck cannot stop for traffic backed up at a ramp or in a work zone</td></tr>
<tr><td>Late lane change</td><td>A driver realizes too late that the truck is in the wrong lane and forces into an occupied one</td></tr>
<tr><td>Ramp rollover</td><td>A truck takes a ramp curve too fast for its load</td></tr>
<tr><td>Merge collision</td><td>A short merge leaves too little room to match the speed of traffic</td></tr>
</tbody>
</table>

<h2>Who Can Be Responsible</h2>
<ul>
<li><strong>The truck driver</strong>, for unsafe lane changes, speed too fast for conditions or distraction.</li>
<li><strong>The motor carrier</strong>, for inadequate training or supervision, or schedules that push drivers to hurry.</li>
<li><strong>A freight broker or shipper</strong>, where the facts support it.</li>
<li><strong>A government agency</strong>, where a road or work-zone defect contributed. Claims against SCDOT fall under the South Carolina Tort Claims Act (see below).</li>
</ul>
<p>Federal safety rules for commercial trucks, covering hours of service, driver qualification, and vehicle inspection and maintenance, are set by the <a href="https://www.fmcsa.dot.gov/regulations" target="_blank" rel="noopener">Federal Motor Carrier Safety Administration</a>. A violation can be strong evidence that the driver or the carrier was careless.</p>

<h2>South Carolina Rules That Shape an Interchange Truck Claim</h2>
<ul>
<li><strong>Deadline:</strong> three years from the date of the crash to file a lawsuit (<a href="https://www.scstatehouse.gov/code/t15c003.php" target="_blank" rel="noopener">S.C. Code § 15-3-530</a>).</li>
<li><strong>Your share of fault:</strong> you can recover if you are 50% or less at fault, with your award reduced by your share (Nelson v. Concrete Supply Co.).</li>
<li><strong>More than one defendant:</strong> a defendant found less than 50% at fault generally pays only its own share of the damages (S.C. Code § 15-38-15), which is one reason every responsible party should be identified.</li>
<li><strong>Government defendants:</strong> suit must be filed within two years, or three years if a verified claim is filed with the agency within one year, and recovery is capped at $300,000 per person and $600,000 per occurrence (<a href="https://www.scstatehouse.gov/code/t15c078.php" target="_blank" rel="noopener">S.C. Code §§ 15-78-110, 15-78-80, 15-78-120</a>).</li>
<li><strong>Punitive damages:</strong> awarded only in rare cases, and they must be proved by clear and convincing evidence (S.C. Code § 15-33-135).</li>
</ul>

<h2>What to Do After a Truck Crash at a Columbia Interchange</h2>
<ol>
<li><strong>Get to safety if you can.</strong> Ramps and merge zones are dangerous places to stop.</li>
<li><strong>Call 911</strong> and give the interstate, direction of travel and nearest exit or mile marker.</li>
<li><strong>Record the truck's details:</strong> company name, USDOT number and trailer number.</li>
<li><strong>Photograph the scene</strong>, including signs, lane markings and any work-zone setup.</li>
<li><strong>Get medical care</strong>, even if you feel fine at first.</li>
<li><strong>Talk to a truck accident lawyer early</strong>, so a preservation request can go to the carrier before data and video are overwritten.</li>
</ol>

<h2>Free Consultation With Roden Law's Columbia Office</h2>
<p>Roden Law's <a href="/locations/south-carolina/columbia/">Columbia office</a> at 1545 Sumter St., Suite B handles truck accident cases throughout the Midlands on contingency: no fee unless we win. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free consultation.</p>
<p>Related resources: <a href="/resources/blythewood-i-77-truck-accidents/">Blythewood and I-77 Truck Accidents</a> | <a href="/resources/carolina-crossroads-construction-zone-truck-accidents/">Carolina Crossroads Construction Zone Truck Accidents</a></p>
HTML;

$excerpt = 'Truck accidents at the interchanges where I-20, I-26 and I-77 meet around Columbia, SC, including Malfunction Junction and the Carolina Crossroads work zones, and how South Carolina law applies.';

$takeaways = 'Columbia\'s three interstates meet at three separate interchanges: <strong>I-26 and I-77</strong> in Cayce south of downtown, <strong>I-20 and I-26</strong> (Malfunction Junction) west of downtown, and <strong>I-20 and I-77</strong> northeast of downtown. SCDOT\'s Carolina Crossroads project is rebuilding the I-20/I-26/I-126 corridor into the mid-2030s. A truck crash claim in South Carolina must generally be filed within <strong>three years</strong> (<strong>S.C. Code &sect; 15-3-530</strong>), and you can recover if you are 50% or less at fault.';

$faqs = array(
	array( 'question' => 'Where do I-26 and I-77 meet in Columbia?', 'answer' => 'I-77 begins at I-26 Exit 116 in Cayce, south of downtown Columbia, and curves east around Columbia and then runs north toward Rock Hill and Charlotte. I-20 meets I-26 west of downtown, at the interchange known as Malfunction Junction, and meets I-77 northeast of downtown.' ),
	array( 'question' => 'What is "Malfunction Junction" in Columbia?', 'answer' => 'It is the local name for the I-20 / I-26 interchange west of downtown Columbia. SCDOT\'s Carolina Crossroads project is reconfiguring the I-20/I-26/I-126 corridor around it, with construction expected to be substantially complete in the mid-2030s.' ),
	array( 'question' => 'Can SCDOT be held liable for a truck crash at an interchange?', 'answer' => 'Potentially, where a road or work-zone defect contributed. Claims against SCDOT fall under the South Carolina Tort Claims Act: suit must be filed within two years, or three years if a verified claim is filed with the agency within one year (S.C. Code §§ 15-78-110, 15-78-80), and recovery is capped at $300,000 per person and $600,000 per occurrence (S.C. Code § 15-78-120).' ),
	array( 'question' => 'What if more than one company is responsible?', 'answer' => 'Each can be named. Under S.C. Code § 15-38-15, a defendant found less than 50% at fault generally pays only its own share of the damages, so identifying every responsible party, such as the driver, the carrier and a broker, can affect how much you recover.' ),
	array( 'question' => 'What evidence matters after an interchange truck crash?', 'answer' => 'The truck\'s electronic logging and telematics data, dashcam and roadside video, the carrier\'s dispatch and driver records, maintenance records, and photos of the signs and lane markings. Some of it can be overwritten, so a written preservation request should go to the carrier as early as possible.' ),
);

$backup = array(
	'generated' => gmdate( 'c' ),
	'batch'     => 'columbia-interchange-resource',
	'mode'      => $apply ? 'apply' : 'dry-run',
	'ID'        => $id,
	'before'    => array(
		'post_title'           => $p->post_title,
		'post_content'         => $p->post_content,
		'post_excerpt'         => $p->post_excerpt,
		'_roden_key_takeaways' => get_post_meta( $id, '_roden_key_takeaways', true ),
		'_roden_faqs'          => get_post_meta( $id, '_roden_faqs', true ),
	),
);
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fwrite( STDERR, sprintf( "%s — post %d: title, content (%d -> %d words), excerpt, takeaways, %d FAQs\n", $apply ? 'APPLY' : 'DRY RUN', $id, str_word_count( wp_strip_all_tags( $p->post_content ) ), str_word_count( wp_strip_all_tags( $body ) ), count( $faqs ) ) );
if ( ! $apply ) {
	exit( 0 );
}

$wpdb->update( $wpdb->posts, array( 'post_title' => $title, 'post_content' => $body, 'post_excerpt' => $excerpt ), array( 'ID' => $id ), array( '%s', '%s', '%s' ), array( '%d' ) );
update_post_meta( $id, '_roden_key_takeaways', wp_slash( $takeaways ) );
update_post_meta( $id, '_roden_faqs', wp_slash( $faqs ) );
clean_post_cache( $id );
wp_cache_delete( $id, 'post_meta' );

$row = $wpdb->get_row( $wpdb->prepare( "SELECT post_title, post_content, post_excerpt FROM {$wpdb->posts} WHERE ID = %d", $id ) );
$ok  = $row->post_title === $title && $row->post_content === $body && $row->post_excerpt === $excerpt
	&& get_post_meta( $id, '_roden_key_takeaways', true ) === $takeaways && get_post_meta( $id, '_roden_faqs', true ) === $faqs;
fwrite( STDERR, ( $ok ? 'VERIFIED' : 'MISMATCH' ) . "\n" );
exit( $ok ? 0 : 1 );
