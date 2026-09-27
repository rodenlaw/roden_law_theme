<?php
/**
 * Write the rebuilt Charleston truck accident page into post 3629, KEEPING IT A
 * DRAFT. Wave 1, #2 of docs/site-architecture/README.md (owner: "start
 * Charleston truck", 2026-09-26). South Carolina only; the map, NAP bar, law
 * box, steps, case types, results and FAQ render from template-intersection.php.
 * GSC before retirement: positions 10-12 on "charleston truck accident
 * lawyer/attorney", 2.8 on "truck accident lawyer charleston sc", 32k
 * impressions, 0 clicks.
 *
 * Publishing is a separate step, after the legal sweep and Graeham C. Gillin's
 * sign-off. This script never publishes, never removes _roden_retired, and never
 * sets _roden_last_reviewed (a review date is stamped only by the reviewer's word).
 *
 * Every statute is from internal-ai-scripts/law/SC.json. No punitive-damages
 * figure. The one statistic is from data/statistics.json (sc-fatal-large-truck-crashes,
 * NHTSA FARS 2024). No federal-regulation specifics beyond what FMCSA governs.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/rebuild-charleston-truck-accident.php \
 *       > docs/backups/charleston-truck-accident-before-$(date +%Y-%m-%d).json
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/rebuild-charleston-truck-accident.php \
 *       > docs/backups/charleston-truck-accident-before-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3629;

$p = get_post( $id );
if ( ! $p instanceof WP_Post || 'practice_area' !== $p->post_type || 'charleston-sc' !== $p->post_name ) {
    fprintf( $err, "ABORT: post %d is not the charleston-sc practice_area.\n", $id );
    exit( 1 );
}
if ( 'draft' !== $p->post_status ) {
    fprintf( $err, "ABORT: post %d is '%s'; this script only writes to the draft.\n", $id, $p->post_status );
    exit( 1 );
}
if ( 'truck-accident-lawyers' !== get_post_field( 'post_name', $p->post_parent ) ) {
    fprintf( $err, "ABORT: parent is not the truck accident pillar.\n" );
    exit( 1 );
}

$body = <<<'HTML'
<h2>Why Hire Roden Law After a Charleston Truck Accident</h2>
<p>A truck crash is not a car crash with a bigger vehicle. The trucking company, its insurer and often a broker or shipper each have their own lawyers, and the evidence that proves fault, such as the truck's electronic logs, maintenance records and the carrier's safety files, is in their hands.</p>
<ul>
<li><strong>No fee unless we win.</strong> The consultation is free, and you pay nothing up front.</li>
<li><strong>A South Carolina lawyer on your case.</strong> Your case is handled under South Carolina law by attorneys licensed here, from our office at 127 King Street.</li>
<li><strong>Evidence preserved early.</strong> We send preservation demands for electronic logging data, dashcam video and maintenance records before they can be overwritten or discarded.</li>
<li><strong>Every responsible party named.</strong> The driver, the motor carrier, and where the facts support it, the broker, the shipper or the company that loaded or maintained the truck.</li>
</ul>

<h2>Why Charleston Sees So Many Truck Crashes</h2>
<p>The Port of Charleston's terminals, including Wando Welch in Mount Pleasant and the North Charleston and Hugh Leatherman terminals, send container trucks onto I-26, I-526 and US-17 every day, alongside commuter and tourist traffic. According to NHTSA's Fatality Analysis Reporting System, South Carolina recorded 126 fatal large-truck crashes in 2024.</p>
<h3>I-26 and the I-26 / I-526 interchange</h3>
<p>I-26 is the main freight route between the port and the rest of the state, and the I-526 interchange is where port trucks, commuters and airport traffic merge. See <a href="/blog/i-26-i-526-truck-accidents-what-to-do-whos-liable/">I-26 and I-526 truck accidents</a> and <a href="/resources/ashley-phosphate-i-26-truck-accidents/">Ashley Phosphate Road and I-26 truck accidents</a>.</p>
<h3>I-526 (Mark Clark Expressway)</h3>
<p>I-526 carries freight between the Wando Welch terminal, North Charleston and West Ashley, and its work zones change lane patterns for heavy trucks. See <a href="/resources/i-526-truck-accidents-charleston/">I-526 truck accidents</a> and <a href="/resources/i-526-construction-zone-truck-accidents-charleston/">I-526 construction zone truck accidents</a>.</p>
<h3>The port routes</h3>
<p>Port Access Road, Spruill Avenue, Rivers Avenue and Dorchester Road carry drayage trucks to and from the North Charleston terminals. See <a href="/resources/port-access-road-truck-accidents-leatherman-terminal/">Port Access Road and the Leatherman Terminal</a>, <a href="/resources/spruill-avenue-port-trucks-north-charleston/">Spruill Avenue port trucks</a>, <a href="/resources/rivers-avenue-truck-accidents-north-charleston/">Rivers Avenue truck accidents</a> and <a href="/resources/dorchester-road-truck-accidents-north-charleston/">Dorchester Road truck accidents</a>. For a crash near the port, our <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> at 2703 Spruill Avenue is closer.</p>
<h3>US-17: the Ravenel Bridge and Savannah Highway</h3>
<p>US-17 brings trucks over the Arthur Ravenel Jr. Bridge and through West Ashley on Savannah Highway. See <a href="/blog/18-wheeler-wrecks-on-the-arthur-ravenel-jr-bridge-us-17/">18-wheeler wrecks on the Ravenel Bridge</a> and <a href="/blog/savannah-highway-truck-accidents-west-ashley-us-17/">Savannah Highway truck accidents</a>.</p>
<h3>Delivery trucks downtown</h3>
<p>On the peninsula, box trucks and delivery vans share narrow streets with pedestrians and cyclists. See <a href="/blog/charleston-delivery-truck-pedestrian-cyclist-accidents/">delivery truck accidents in Charleston</a>.</p>

<h2>Who Can Be Responsible for a Charleston Truck Crash</h2>
<p>A truck claim often has more than one defendant: the driver, the motor carrier that employed or contracted the driver, a freight broker, the shipper or the company that loaded the cargo, and the company that maintained the truck. Federal safety rules for commercial trucks, covering hours of service, driver qualification, vehicle inspection and maintenance, and drug and alcohol testing, are set by the <a href="https://www.fmcsa.dot.gov/regulations">Federal Motor Carrier Safety Administration</a>. A violation can be strong evidence that the driver or the carrier was careless. For a step-by-step look at a claim, see <a href="/blog/your-guide-to-justice-after-a-charleston-truck-accident/">our guide after a Charleston truck accident</a>.</p>

<h2>South Carolina Rules That Shape a Truck Claim</h2>
<h3>Trucks owned by a city, county or state agency</h3>
<p>If a City of Charleston, Charleston County or SCDOT truck caused the crash, the South Carolina Tort Claims Act applies. Suit must be filed within two years of when the loss was or should have been discovered (<a href="https://www.scstatehouse.gov/code/t15c078.php">S.C. Code § 15-78-110</a>). Filing a verified claim with the agency within one year is optional and extends that period to three years (S.C. Code § 15-78-80). Recovery against a government entity is capped at $300,000 per person and $600,000 per occurrence, with no punitive damages (S.C. Code § 15-78-120). See <a href="/car-accident-lawyers/government-vehicle-accident/">government vehicle accidents</a>.</p>
<h3>Your own coverage</h3>
<p>Every South Carolina auto policy must include uninsured motorist coverage (<a href="https://www.scstatehouse.gov/code/t38c077.php">S.C. Code § 38-77-150</a>), and insurers must offer underinsured motorist coverage (S.C. Code § 38-77-160). Your own UM or UIM coverage can matter if a truck's coverage does not reach the full cost of your injuries. See <a href="/resources/south-carolina-um-uim-stacking/">UM and UIM coverage in South Carolina</a>.</p>
<h3>Where your case would be filed</h3>
<p>Most Charleston County truck accident lawsuits are filed in the Court of Common Pleas at the Charleston County Judicial Center, 100 Broad Street, a few blocks from our King Street office. For how South Carolina truck settlements are valued, see <a href="/resources/south-carolina-truck-accident-settlement-value/">South Carolina truck accident settlement value</a>. If a car was involved rather than a commercial truck, see our <a href="/car-accident-lawyers/charleston-sc/">Charleston car accident lawyers</a>.</p>
HTML;

$key_takeaways = 'If you were injured in a truck accident in Charleston, South Carolina law gives you three years from the date of the crash to file a lawsuit (S.C. Code § 15-3-530), or two years if the truck belonged to a government entity such as the City of Charleston or SCDOT (S.C. Code § 15-78-110). South Carolina uses modified comparative negligence: you can recover if you are 50% or less at fault, with your award reduced by your share (Nelson v. Concrete Supply Co.). A truck claim often has several defendants, including the driver, the motor carrier and sometimes a broker or shipper, and the evidence that proves fault needs to be preserved early. Roden Law\'s Charleston office at 127 King Street handles truck accident cases on contingency: the consultation is free and there is no fee unless we win.';

$faqs = array(
    array( 'question' => 'How much does a Charleston truck accident lawyer cost?', 'answer' => 'Nothing up front. Roden Law handles truck accident cases on a contingency fee. The consultation is free, and there is no fee unless we win your case.' ),
    array( 'question' => 'How long do I have to file a truck accident lawsuit in South Carolina?', 'answer' => 'Three years from the date of the crash under S.C. Code § 15-3-530. If a government entity is responsible, the deadline is two years under S.C. Code § 15-78-110, or three years if a verified claim was filed with the agency within one year.' ),
    array( 'question' => 'Who can be held responsible for a truck crash?', 'answer' => 'Often more than the driver. Depending on the facts, the motor carrier, a freight broker, the shipper or loader, and the company that maintained the truck can all share responsibility.' ),
    array( 'question' => 'Can I still recover if I was partly at fault?', 'answer' => 'Yes, if you were 50% or less at fault. South Carolina\'s modified comparative negligence rule (Nelson v. Concrete Supply Co.) reduces your award by your share of fault and bars recovery only above 50%.' ),
    array( 'question' => 'What if the truck belonged to the city, the county or SCDOT?', 'answer' => 'The South Carolina Tort Claims Act applies. Suit must be filed within two years (S.C. Code § 15-78-110), and recovery is capped at $300,000 per person and $600,000 per occurrence, with no punitive damages (S.C. Code § 15-78-120).' ),
    array( 'question' => 'What evidence matters most after a truck crash?', 'answer' => 'The truck\'s electronic logging data, dashcam and other video, maintenance and inspection records, and the carrier\'s driver files. Some of it can be overwritten or discarded, so it should be requested in writing as early as possible.' ),
);

$post_fields = array(
    'ID'           => $id,
    'post_title'   => 'Charleston Truck Accident Lawyers',
    'post_content' => $body,
    // Published as the Article description by roden_schema_article().
    'post_excerpt' => 'Hurt in a Charleston truck accident? Roden Law\'s King Street lawyers handle South Carolina truck accident claims against drivers, carriers and brokers. Free consultation, no fee unless we win.',
);
$meta = array(
    '_roden_key_takeaways'    => $key_takeaways,
    '_roden_faqs'             => $faqs,
    '_roden_meta_title'       => 'Charleston Truck Accident Lawyer | Roden Law',
    '_roden_meta_description' => 'Hurt in a Charleston truck accident? Roden Law\'s King Street lawyers handle South Carolina truck claims against drivers, carriers and brokers. Free consultation, no fee unless we win. (843) 790-8999.',
    '_roden_author_attorney'  => '3732', // Graeham C. Gillin, SC Bar
);

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'charleston-truck-accident-rebuild',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'before'    => array(
        'post_title'   => $p->post_title,
        'post_content' => $p->post_content,
        'post_excerpt' => $p->post_excerpt,
        'meta'         => get_post_meta( $id ),
    ),
);
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

fprintf( $err, "%s — post %d (%s), stays draft\n", $apply ? 'APPLY' : 'DRY RUN', $id, $p->post_status );
fprintf( $err, "  title   %s -> %s\n", $p->post_title, $post_fields['post_title'] );
fprintf( $err, "  content %d -> %d chars, %d words\n", strlen( $p->post_content ), strlen( $body ), str_word_count( wp_strip_all_tags( $body ) ) );
foreach ( $meta as $k => $v ) {
    fprintf( $err, "  meta    %s (%s)\n", $k, is_array( $v ) ? count( $v ) . ' items' : strlen( $v ) . ' chars' );
}
if ( ! $apply ) {
    exit( 0 );
}

// wp_update_post() and update_post_meta() unslash what they are given (CLAUDE.md).
$r = wp_update_post( wp_slash( $post_fields ), true );
if ( is_wp_error( $r ) ) {
    fprintf( $err, "FAILED: %s\n", $r->get_error_message() );
    exit( 1 );
}
foreach ( $meta as $k => $v ) {
    update_post_meta( $id, $k, wp_slash( $v ) );
}
clean_post_cache( $id );

// Read back from the table and meta, not the object cache.
global $wpdb;
$row = $wpdb->get_row( $wpdb->prepare( "SELECT post_status, post_title, post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
$ok  = 'draft' === $row->post_status && $row->post_content === $body && $row->post_title === $post_fields['post_title'];
$f   = maybe_unserialize( $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = '_roden_faqs'", $id ) ) );
$ok  = $ok && is_array( $f ) && count( $f ) === count( $faqs ) && $f[2]['answer'] === $faqs[2]['answer'];
fprintf( $err, "%s: status=%s, content %s, faqs %d\n", $ok ? 'VERIFIED' : 'MISMATCH', $row->post_status, $row->post_content === $body ? 'exact' : 'DIFFERS', is_array( $f ) ? count( $f ) : 0 );
exit( $ok ? 0 : 1 );
