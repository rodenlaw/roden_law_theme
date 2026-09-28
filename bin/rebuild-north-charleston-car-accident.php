<?php
/**
 * Write the rebuilt North Charleston car accident page into post 4540, KEEPING IT
 * A DRAFT. Wave 1, #9 of docs/site-architecture/README.md (owner: "go to the
 * next page in wave 1", 2026-09-28). South Carolina only; the map (#188), NAP
 * bar, law box, steps, case types, results and FAQ render from
 * template-intersection.php, with the North Charleston office essay tightened in
 * #188. GSC before retirement: 54,264 impressions over 16 months, position 17.9
 * in the last 90 days.
 *
 * Publishing is a separate step, after the legal sweep and Graeham C. Gillin's
 * sign-off. This script never publishes, never removes _roden_retired, and never
 * sets _roden_last_reviewed.
 *
 * Every statute is from the signed internal-ai-scripts/law/SC.json; the SC rules
 * wording is the Gillin-reviewed Charleston and Columbia car pages'. No
 * statistic. North Charleston lies in Charleston, Berkeley and Dorchester
 * counties, so the venue line is hedged as on the Columbia page.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/rebuild-north-charleston-car-accident.php \
 *       > docs/backups/north-charleston-car-accident-before-$(date +%Y-%m-%d).json
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/rebuild-north-charleston-car-accident.php \
 *       > docs/backups/north-charleston-car-accident-before-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 4540;

$p = get_post( $id );
if ( ! $p instanceof WP_Post || 'practice_area' !== $p->post_type || 'north-charleston-sc' !== $p->post_name ) {
    fprintf( $err, "ABORT: post %d is not the north-charleston-sc practice_area.\n", $id );
    exit( 1 );
}
if ( 'draft' !== $p->post_status ) {
    fprintf( $err, "ABORT: post %d is '%s'; this script only writes to the draft.\n", $id, $p->post_status );
    exit( 1 );
}
if ( 'car-accident-lawyers' !== get_post_field( 'post_name', $p->post_parent ) ) {
    fprintf( $err, "ABORT: parent is not the car accident pillar.\n" );
    exit( 1 );
}

$body = <<<'HTML'
<h2>Why Hire Roden Law After a North Charleston Car Accident</h2>
<p>After a crash, the other driver's insurer starts building its case right away. You should have someone building yours: gathering the crash report, video and medical records, and dealing with the adjusters so you can focus on getting better.</p>
<ul>
<li><strong>No fee unless we win.</strong> The consultation is free, and you pay nothing up front.</li>
<li><strong>A South Carolina lawyer on your case.</strong> Your case is handled under South Carolina law by attorneys licensed here, from our office at 2703 Spruill Avenue in North Charleston.</li>
<li><strong>Evidence preserved early.</strong> We work to secure video, the crash report and witness accounts before they are lost.</li>
<li><strong>The full value of the claim.</strong> Medical care, lost income, pain and suffering, and damage to your vehicle.</li>
</ul>

<h2>Where Car Accidents Happen in North Charleston</h2>
<p>North Charleston sits where I-26, I-526 and the port routes meet, so commuters share the road with container trucks, airport traffic and shoppers. For a closer look, see <a href="/resources/dangerous-roads-north-charleston/">dangerous roads and intersections in North Charleston</a>.</p>
<h3>I-26</h3>
<p>I-26 carries commuters from Summerville and Goose Creek into Charleston alongside freight headed to and from the port. See <a href="/blog/car-accidents-on-i-26-in-north-charleston/">car accidents on I-26 in North Charleston</a> and <a href="/blog/car-accidents-ladson-i-26-exit-203-danger-zone/">car accidents near Ladson and I-26 Exit 203</a>.</p>
<h3>Ashley Phosphate Road</h3>
<p>The Ashley Phosphate Road interchange with I-26 brings interstate traffic straight into one of the area's busiest shopping corridors. See <a href="/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/">Ashley Phosphate Road and I-26</a>.</p>
<h3>Rivers Avenue and Dorchester Road</h3>
<p>These long commercial corridors have frequent signals, driveways and turning traffic, and many people cross them on foot. See <a href="/blog/rivers-avenue-pedestrian-deaths-north-charleston/">pedestrian safety on Rivers Avenue</a>.</p>
<h3>Park Circle and the port routes</h3>
<p>Around Park Circle and along Spruill Avenue and North Rhett Avenue, neighborhood streets carry port trucks. See <a href="/blog/pedestrian-safety-park-circle-north-charleston/">pedestrian safety in Park Circle</a>. If a commercial truck was involved, see our <a href="/truck-accident-lawyers/charleston-sc/">Charleston truck accident lawyers</a>.</p>
<p>If the driver who hit you left the scene, see <a href="/blog/north-charleston-crime-rate-hit-and-run/">hit-and-run accidents in North Charleston</a>.</p>

<h2>South Carolina Rules That Shape a North Charleston Claim</h2>
<h3>Crashes involving a city, county or state vehicle</h3>
<p>If a City of North Charleston, county or SCDOT vehicle caused the crash, or a road defect did, the South Carolina Tort Claims Act applies. Suit must be filed within two years of when the loss was or should have been discovered (<a href="https://www.scstatehouse.gov/code/t15c078.php">S.C. Code § 15-78-110</a>). Filing a verified claim with the agency within one year is optional and extends that period to three years (S.C. Code § 15-78-80). Recovery against a government entity is capped at $300,000 per person and $600,000 per occurrence, with no punitive damages (S.C. Code § 15-78-120). See <a href="/car-accident-lawyers/government-vehicle-accident/">government vehicle accidents</a>.</p>
<h3>Insurance: minimum limits, UM and UIM</h3>
<p>South Carolina drivers must carry at least $25,000 per person and $50,000 per accident in bodily injury liability, plus $25,000 in property damage (<a href="https://www.scstatehouse.gov/code/t38c077.php">S.C. Code § 38-77-140</a>). A serious crash can exceed those limits quickly. Every South Carolina auto policy must include uninsured motorist coverage (S.C. Code § 38-77-150), and insurers must offer underinsured motorist coverage (S.C. Code § 38-77-160). After a hit-and-run with an unknown driver, UM claims require a prompt police report and corroboration that the other vehicle existed (S.C. Code § 38-77-170).</p>
<h3>Where your case would be filed</h3>
<p>Most North Charleston car accident lawsuits are filed in the Charleston County Court of Common Pleas at the Charleston County Judicial Center, 100 Broad Street, downtown. North Charleston also reaches into Berkeley and Dorchester counties, and a crash in one of those parts of the city may be filed in that county instead. For how South Carolina settlements are valued, see <a href="/resources/south-carolina-car-accident-settlement-value/">South Carolina car accident settlement value</a>. For a crash on the peninsula, see our <a href="/car-accident-lawyers/charleston-sc/">Charleston car accident lawyers</a>.</p>
HTML;

$key_takeaways = 'If you were injured in a car accident in North Charleston, South Carolina law gives you three years from the date of the crash to file a lawsuit (S.C. Code § 15-3-530), or generally two years if the at-fault party is a government entity such as the City of North Charleston or SCDOT (S.C. Code § 15-78-110). South Carolina uses modified comparative negligence: you can recover if you are 50% or less at fault, with your award reduced by your share (Nelson v. Concrete Supply Co.). Every South Carolina auto policy must include uninsured motorist coverage (S.C. Code § 38-77-150). Roden Law\'s North Charleston office at 2703 Spruill Avenue handles car accident cases on contingency: the consultation is free and there is no fee unless we win.';

$faqs = array(
    array( 'question' => 'How much does a North Charleston car accident lawyer cost?', 'answer' => 'Nothing up front. Roden Law handles car accident cases on a contingency fee. The consultation is free, and there is no fee unless we win your case.' ),
    array( 'question' => 'How long do I have to file a car accident lawsuit in South Carolina?', 'answer' => 'Three years from the date of the crash under S.C. Code § 15-3-530. If a government entity is responsible, the deadline is two years under S.C. Code § 15-78-110, or three years if a verified claim was filed with the agency within one year.' ),
    array( 'question' => 'Can I still recover if I was partly at fault?', 'answer' => 'Yes, if you were 50% or less at fault. South Carolina\'s modified comparative negligence rule (Nelson v. Concrete Supply Co.) reduces your award by your share of fault and bars recovery only above 50%.' ),
    array( 'question' => 'What if the driver who hit me was uninsured or drove off?', 'answer' => 'Your own uninsured motorist coverage, which every South Carolina auto policy must include (S.C. Code § 38-77-150), can pay. For a hit-and-run by an unknown driver, report the crash to police promptly: the claim requires a police report and corroboration that the other vehicle existed (S.C. Code § 38-77-170).' ),
    array( 'question' => 'Where would my North Charleston car accident case be filed?', 'answer' => 'Most North Charleston car accident lawsuits are filed in the Charleston County Court of Common Pleas at the Charleston County Judicial Center, 100 Broad Street. North Charleston also reaches into Berkeley and Dorchester counties, and a crash in one of those parts of the city may be filed in that county instead.' ),
    array( 'question' => 'Do I need a lawyer if the other insurer already made an offer?', 'answer' => 'Talk to a lawyer before you accept. A settlement ends your claim, and early offers are often made before the full cost of your injuries is known. A free review costs you nothing.' ),
);

$post_fields = array(
    'ID'           => $id,
    'post_title'   => 'North Charleston Car Accident Lawyers',
    'post_content' => $body,
    // Published as the Article description by roden_schema_article().
    'post_excerpt' => 'Hurt in a North Charleston car accident? Roden Law\'s Spruill Avenue lawyers handle South Carolina car accident claims. Free consultation, no fee unless we win.',
);
$meta = array(
    '_roden_key_takeaways'    => $key_takeaways,
    '_roden_faqs'             => $faqs,
    '_roden_meta_title'       => 'North Charleston Car Accident Lawyer | Roden Law',
    '_roden_meta_description' => 'Hurt in a North Charleston car accident? Roden Law\'s Spruill Avenue lawyers handle South Carolina car accident claims. Free consultation, no fee unless we win. (843) 612-6561.',
    '_roden_author_attorney'  => '3732', // Graeham C. Gillin, SC Bar
);

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'north-charleston-car-accident-rebuild',
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
