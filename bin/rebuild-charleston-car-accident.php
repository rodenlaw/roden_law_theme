<?php
/**
 * Write the rebuilt Charleston car accident page into post 3624, KEEPING IT A
 * DRAFT. Plan: docs/charleston-car-accident-rebuild-plan-2026-09-26.md. Owner
 * decision 2026-09-26: rebuild as a South Carolina–only page with the King St
 * map (the map, NAP bar, law box, steps, case types, results and FAQ render
 * from template-intersection.php; this script writes only what the template
 * cannot know).
 *
 * Publishing is a separate step, after the legal sweep and Graeham C. Gillin's
 * sign-off. This script never publishes, never removes _roden_retired, and never
 * sets _roden_last_reviewed (a review date is stamped only by the reviewer's word).
 *
 * Every statute is from internal-ai-scripts/law/SC.json. No punitive-damages
 * figure. No Charleston crash statistic (none in data/statistics.json).
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/rebuild-charleston-car-accident.php \
 *       > docs/backups/charleston-car-accident-before-$(date +%Y-%m-%d).json
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/rebuild-charleston-car-accident.php \
 *       > docs/backups/charleston-car-accident-before-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3624;

$p = get_post( $id );
if ( ! $p instanceof WP_Post || 'practice_area' !== $p->post_type || 'charleston-sc' !== $p->post_name ) {
    fprintf( $err, "ABORT: post %d is not the charleston-sc practice_area.\n", $id );
    exit( 1 );
}
if ( 'draft' !== $p->post_status ) { // re-run 2026-09-26 for sweep finding W11
    fprintf( $err, "ABORT: post %d is '%s'; this script only writes to the draft.\n", $id, $p->post_status );
    exit( 1 );
}
if ( 'car-accident-lawyers' !== get_post_field( 'post_name', $p->post_parent ) ) {
    fprintf( $err, "ABORT: parent is not the car accident pillar.\n" );
    exit( 1 );
}

$body = <<<'HTML'
<h2>Why Hire Roden Law After a Charleston Car Accident</h2>
<p>A Charleston crash can involve more than one driver and more than one insurer: visitors in rental cars, rideshare drivers, delivery vans and port traffic all share the peninsula and the bridges. We work out who is responsible and which coverage pays.</p>
<ul>
<li><strong>No fee unless we win.</strong> The consultation is free, and you pay nothing up front.</li>
<li><strong>A South Carolina lawyer on your case.</strong> Your case is handled under South Carolina law by attorneys licensed here, from our office at 127 King Street.</li>
<li><strong>Built for trial.</strong> We prepare every case as if it will be tried in the Charleston County Court of Common Pleas.</li>
<li><strong>Every policy found.</strong> At-fault liability, your own uninsured and underinsured motorist coverage, rideshare and commercial policies.</li>
</ul>

<h2>Where Car Accidents Happen in Charleston</h2>
<p>Most of the Charleston crashes we see happen on a handful of roads. Each one causes problems in its own way, and each shapes how fault gets proved.</p>
<h3>I-26 and the I-26 / I-526 interchange</h3>
<p>I-26 carries commuters, port trucks and beach traffic onto the peninsula. Merge crashes and rear-end chain collisions near the I-526 interchange often involve several vehicles and several insurers. Our guides to <a href="/blog/car-accidents-on-i-26-in-north-charleston/">car accidents on I-26 in North Charleston</a> and <a href="/blog/i-26-i-526-truck-accidents-what-to-do-whos-liable/">I-26 and I-526 truck accidents</a> cover these crashes in detail.</p>
<h3>I-526 (Mark Clark Expressway)</h3>
<p>I-526 links West Ashley, North Charleston, Daniel Island and Mount Pleasant. Work zones on the corridor change lane patterns and speeds, which matters when deciding who was at fault. See <a href="/blog/i-526-expansion-construction-zone-accidents-charleston/">I-526 construction zone accidents</a>.</p>
<h3>The Ravenel Bridge and the US-17 Crosstown</h3>
<p>The Arthur Ravenel Jr. Bridge and the Crosstown carry US-17 across the harbor and the peninsula. High speeds on the bridge and stop-and-go traffic on the Crosstown produce rear-end and lane-change crashes. See <a href="/blog/18-wheeler-wrecks-on-the-arthur-ravenel-jr-bridge-us-17/">truck wrecks on the Ravenel Bridge</a>.</p>
<h3>West Ashley: Savannah Highway, Sam Rittenberg and Glenn McConnell</h3>
<p>West Ashley's commercial corridors combine dense driveways, turning traffic and heavy commuter volume. Left-turn and side-impact crashes are common. See <a href="/blog/west-ashley-vs-downtown-charleston-driving-risks/">West Ashley vs. downtown driving risks</a> and <a href="/blog/what-to-do-after-a-car-crash-on-savannah-highway/">what to do after a crash on Savannah Highway</a>.</p>
<h3>James Island and Johns Island: Folly Road and Maybank Highway</h3>
<p>Folly Road and Maybank Highway are the main routes to the islands and the beach, with long stretches of two-lane road and seasonal traffic. See <a href="/blog/folly-road-car-accidents-james-island-charleston/">Folly Road car accidents</a> and <a href="/blog/maybank-highway-car-accidents-johns-island/">Maybank Highway car accidents</a>.</p>
<h3>Downtown: the King and Meeting Street grid</h3>
<p>On the peninsula, visitors unfamiliar with one-way streets, rideshare pickups, carriage tours and pedestrians all share narrow streets. See <a href="/blog/what-to-do-after-a-hit-and-run-in-downtown-charleston/">hit-and-run crashes downtown</a>.</p>
<h3>Mount Pleasant: Coleman Boulevard and US-17 North</h3>
<p>We also represent Mount Pleasant drivers hurt on Coleman Boulevard and the US-17 North corridor. See <a href="/blog/car-accidents-on-coleman-boulevard-in-mount-pleasant/">Coleman Boulevard car accidents</a>.</p>
<p>Hurt north of the Neck, on Rivers Avenue, Ashley Phosphate Road or Dorchester Road? Our <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> at 2703 Spruill Avenue is closer.</p>

<h2>South Carolina Rules That Shape a Charleston Claim</h2>
<h3>Crashes involving a city, county or state vehicle</h3>
<p>If a City of Charleston, Charleston County or SCDOT vehicle caused the crash, or a road defect did, the South Carolina Tort Claims Act applies. Suit must be filed within two years of when the loss was or should have been discovered (<a href="https://www.scstatehouse.gov/code/t15c078.php">S.C. Code § 15-78-110</a>). Filing a verified claim with the agency within one year is optional and extends that period to three years (S.C. Code § 15-78-80). Recovery against a government entity is capped at $300,000 per person and $600,000 per occurrence, with no punitive damages (S.C. Code § 15-78-120). See <a href="/car-accident-lawyers/government-vehicle-accident/">government vehicle accidents</a>.</p>
<h3>Insurance: minimum limits, UM and UIM</h3>
<p>South Carolina drivers must carry at least $25,000 per person and $50,000 per accident in bodily injury liability, plus $25,000 in property damage (<a href="https://www.scstatehouse.gov/code/t38c077.php">S.C. Code § 38-77-140</a>). A serious crash can exceed those limits quickly. Every South Carolina auto policy must include uninsured motorist coverage (S.C. Code § 38-77-150), and insurers must offer underinsured motorist coverage (S.C. Code § 38-77-160). After a hit-and-run with an unknown driver, UM claims require a prompt police report and corroboration that the other vehicle existed (S.C. Code § 38-77-170). See <a href="/resources/south-carolina-um-uim-stacking/">UM and UIM coverage in South Carolina</a>.</p>
<h3>Where your case would be filed</h3>
<p>Most Charleston County car accident lawsuits are filed in the Court of Common Pleas at the Charleston County Judicial Center, 100 Broad Street, a few blocks from our King Street office. For how South Carolina settlements are valued, see <a href="/resources/south-carolina-car-accident-settlement-value/">South Carolina car accident settlement value</a>.</p>
HTML;

$key_takeaways = 'If you were injured in a car accident in Charleston, South Carolina law gives you three years from the date of the crash to file a lawsuit (S.C. Code § 15-3-530), or two years if the at-fault party is a government entity such as the City of Charleston or SCDOT (S.C. Code § 15-78-110). South Carolina uses modified comparative negligence: you can recover if you are 50% or less at fault, with your award reduced by your share (Nelson v. Concrete Supply Co.). Every South Carolina auto policy must include uninsured motorist coverage (S.C. Code § 38-77-150). Roden Law\'s Charleston office at 127 King Street handles car accident cases on contingency: the consultation is free and there is no fee unless we win.';

$faqs = array(
    array( 'question' => 'How much does a Charleston car accident lawyer cost?', 'answer' => 'Nothing up front. Roden Law handles car accident cases on a contingency fee. The consultation is free, and there is no fee unless we win your case.' ),
    array( 'question' => 'How long do I have to file a car accident lawsuit in South Carolina?', 'answer' => 'Three years from the date of the crash under S.C. Code § 15-3-530. If a government entity is responsible, the deadline is two years under S.C. Code § 15-78-110, or three years if a verified claim was filed with the agency within one year.' ),
    array( 'question' => 'Can I still recover if I was partly at fault?', 'answer' => 'Yes, if you were 50% or less at fault. South Carolina\'s modified comparative negligence rule (Nelson v. Concrete Supply Co.) reduces your award by your share of fault and bars recovery only above 50%.' ),
    array( 'question' => 'What if the driver who hit me was uninsured or drove off?', 'answer' => 'Your own uninsured motorist coverage, which every South Carolina auto policy must include (S.C. Code § 38-77-150), can pay. For a hit-and-run by an unknown driver, report the crash to police promptly: the claim requires a police report and corroboration that the other vehicle existed (S.C. Code § 38-77-170).' ),
    array( 'question' => 'Where would my Charleston car accident case be filed?', 'answer' => 'Most Charleston County car accident lawsuits are filed in the Court of Common Pleas at the Charleston County Judicial Center, 100 Broad Street, a few blocks from our King Street office.' ),
    array( 'question' => 'Do I need a lawyer if the other insurer already made an offer?', 'answer' => 'Talk to a lawyer before you accept. A settlement ends your claim, and early offers are often made before the full cost of your injuries is known. A free review costs you nothing.' ),
);

$post_fields = array(
    'ID'           => $id,
    'post_title'   => 'Charleston Car Accident Lawyers',
    'post_content' => $body,
    // Published as the Article description by roden_schema_article().
    'post_excerpt' => 'Hurt in a Charleston car accident? Roden Law\'s King Street lawyers handle South Carolina car accident claims. Free consultation, no fee unless we win.',
);
$meta = array(
    '_roden_key_takeaways'    => $key_takeaways,
    '_roden_faqs'             => $faqs,
    '_roden_meta_title'       => 'Charleston Car Accident Lawyer | Roden Law',
    '_roden_meta_description' => 'Hurt in a Charleston car accident? Roden Law\'s King Street lawyers handle South Carolina car accident claims. Free consultation, no fee unless we win. (843) 790-8999.',
    '_roden_author_attorney'  => '3732', // Graeham C. Gillin, SC Bar
);

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'charleston-car-accident-rebuild',
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
