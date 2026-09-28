<?php
/**
 * Write the rebuilt Charleston motorcycle accident page into post 3639, KEEPING
 * IT A DRAFT. Wave 1, #7 of docs/site-architecture/README.md (owner: "move on
 * to the next batch", 2026-09-28). South Carolina only; the map, NAP bar, law
 * box, steps, case types, results and FAQ render from template-intersection.php.
 * GSC before retirement (#142, 2026-09-18): 63,069 impressions over 16 months,
 * position 13.1 in the last 90 days, 0 clicks; head terms "charleston motorcycle
 * accident lawyer" (17,141) and "… attorney" (8,767).
 *
 * Publishing is a separate step, after the legal sweep and Graeham C. Gillin's
 * sign-off. This script never publishes, never removes _roden_retired, and never
 * sets _roden_last_reviewed (a review date is stamped only by the reviewer's word).
 *
 * Statutes are from internal-ai-scripts/law/SC.json, except S.C. Code
 * §§ 56-5-3640 and 56-5-3660, read against scstatehouse.gov/code/t56c005.php on
 * 2026-09-28 and added to the pack as pending: they need Gillin's sign-off
 * before this page publishes. No statistic (data/statistics.json holds none for
 * South Carolina motorcycle crashes). No punitive-damages figure.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/rebuild-charleston-motorcycle-accident.php \
 *       > docs/backups/charleston-motorcycle-accident-before-$(date +%Y-%m-%d).json
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/rebuild-charleston-motorcycle-accident.php \
 *       > docs/backups/charleston-motorcycle-accident-before-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3639;

$p = get_post( $id );
if ( ! $p instanceof WP_Post || 'practice_area' !== $p->post_type || 'charleston-sc' !== $p->post_name ) {
    fprintf( $err, "ABORT: post %d is not the charleston-sc practice_area.\n", $id );
    exit( 1 );
}
if ( 'draft' !== $p->post_status ) {
    fprintf( $err, "ABORT: post %d is '%s'; this script only writes to the draft.\n", $id, $p->post_status );
    exit( 1 );
}
if ( 'motorcycle-accident-lawyers' !== get_post_field( 'post_name', $p->post_parent ) ) {
    fprintf( $err, "ABORT: parent is not the motorcycle accident pillar.\n" );
    exit( 1 );
}

$body = <<<'HTML'
<h2>Why Hire Roden Law After a Charleston Motorcycle Accident</h2>
<p>Riders are often blamed for crashes they did not cause. The other driver's insurer may assume you were speeding or weaving, and it may treat a missing helmet as the whole story. A motorcycle claim is won by showing what actually happened, and much of that evidence, such as video, the scene and the bike itself, does not last long.</p>
<ul>
<li><strong>No fee unless we win.</strong> The consultation is free, and you pay nothing up front.</li>
<li><strong>A South Carolina lawyer on your case.</strong> Your case is handled under South Carolina law by attorneys licensed here, from our office at 127 King Street.</li>
<li><strong>Evidence preserved early.</strong> We work to secure video, the crash report, witness accounts and your damaged bike and gear before they are lost or repaired.</li>
<li><strong>The full value of the claim.</strong> Medical care, lost income, pain and suffering, and the bike, riding gear and aftermarket parts.</li>
</ul>

<h2>Where Charleston Motorcycle Crashes Happen</h2>
<p>Charleston's riding season runs most of the year, and bikes share the same roads as port trucks, commuters and beach traffic.</p>
<h3>I-26 and I-526</h3>
<p>The interstates carry fast, heavy traffic through North Charleston, where frequent merges and lane changes leave little room for a driver who fails to check a blind spot. For crashes near the port and North Charleston, our <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> at 2703 Spruill Avenue is closer.</p>
<h3>Dorchester Road and Rivers Avenue</h3>
<p>These are busy commercial corridors with many driveways and turning lanes. See <a href="/blog/motorcycle-accidents-dorchester-road-data/">motorcycle accidents on Dorchester Road</a>.</p>
<h3>US-17: the Ravenel Bridge and Savannah Highway</h3>
<p>US-17 carries riders over the Arthur Ravenel Jr. Bridge into Mount Pleasant and through West Ashley on Savannah Highway.</p>
<h3>Folly Road and Maybank Highway</h3>
<p>The routes to Folly Beach, James Island and Johns Island draw riders on weekends, along with visitors unfamiliar with the roads.</p>

<h2>How Motorcycle Crashes Happen</h2>
<p>Many crashes happen when a driver turns left across a rider's path, pulls out from a side street or driveway, or changes lanes into a motorcycle they did not see. Others involve rear-end collisions, road hazards or a vehicle that leaves the scene. See <a href="/motorcycle-accident-lawyers/hit-and-run-motorcycle-accident/">hit-and-run motorcycle accidents</a> and <a href="/motorcycle-accident-lawyers/single-vehicle-motorcycle-crash/">single-vehicle motorcycle crashes</a>, and for what to do in the days after a crash, <a href="/blog/7-mistakes-to-avoid-after-a-motorcycle-accident/">mistakes to avoid after a motorcycle accident</a> and <a href="/blog/the-importance-of-gathering-evidence-after-a-motorcycle-accident/">gathering evidence after a motorcycle accident</a>.</p>

<h2>South Carolina Rules That Shape a Motorcycle Claim</h2>
<h3>Your right to the lane</h3>
<p>South Carolina law entitles every motorcycle to the full use of a lane, and no driver may operate a vehicle in a way that deprives a motorcycle of it, except when motorcycles ride two abreast in the lane (<a href="https://www.scstatehouse.gov/code/t56c005.php">S.C. Code § 56-5-3640</a>). The same section prohibits riding between lanes of traffic or rows of vehicles, and riding more than two abreast in a single lane.</p>
<h3>Helmets</h3>
<p>South Carolina requires a helmet only for operators and passengers under 21 (S.C. Code § 56-5-3660). If you were 21 or older, riding without a helmet broke no law. Insurers sometimes raise it anyway, which is one more reason to have the evidence of how the crash happened.</p>
<h3>Vehicles owned by a city, county or state agency</h3>
<p>If a City of Charleston, Charleston County or SCDOT vehicle caused the crash, the South Carolina Tort Claims Act applies. Suit must be filed within two years of when the loss was or should have been discovered (<a href="https://www.scstatehouse.gov/code/t15c078.php">S.C. Code § 15-78-110</a>). Filing a verified claim with the agency within one year is optional and extends that period to three years (S.C. Code § 15-78-80). Recovery against a government entity is capped at $300,000 per person and $600,000 per occurrence, with no punitive damages (S.C. Code § 15-78-120). See <a href="/car-accident-lawyers/government-vehicle-accident/">government vehicle accidents</a>.</p>
<h3>Your own coverage</h3>
<p>Every South Carolina auto policy must include uninsured motorist coverage (<a href="https://www.scstatehouse.gov/code/t38c077.php">S.C. Code § 38-77-150</a>), and insurers must offer underinsured motorist coverage (S.C. Code § 38-77-160). Because injuries in motorcycle crashes are often severe, your own UM or UIM coverage can matter when the at-fault driver's policy is not enough.</p>
<h3>Where your case would be filed</h3>
<p>Most Charleston County motorcycle accident lawsuits are filed in the Court of Common Pleas at the Charleston County Judicial Center, 100 Broad Street, about a block from our King Street office. For how South Carolina motorcycle settlements are valued, see <a href="/resources/south-carolina-motorcycle-accident-settlement-value/">South Carolina motorcycle accident settlement value</a>, and for crashes elsewhere in the state, our <a href="/south-carolina-motorcycle-accident-lawyer/">South Carolina motorcycle accident lawyers</a>. If you were in a car rather than on a bike, see our <a href="/car-accident-lawyers/charleston-sc/">Charleston car accident lawyers</a>.</p>
HTML;

$key_takeaways = 'If you were injured in a motorcycle accident in Charleston, South Carolina law gives you three years from the date of the crash to file a lawsuit (S.C. Code § 15-3-530), or generally two years if the vehicle that hit you belonged to a government entity such as the City of Charleston or SCDOT (S.C. Code § 15-78-110). South Carolina uses modified comparative negligence: you can recover if you are 50% or less at fault, with your award reduced by your share (Nelson v. Concrete Supply Co.). Riders 21 and older are not required to wear a helmet (S.C. Code § 56-5-3660), and every motorcycle is entitled to the full use of its lane (S.C. Code § 56-5-3640). Roden Law\'s Charleston office at 127 King Street handles motorcycle accident cases on contingency: the consultation is free and there is no fee unless we win.';

$faqs = array(
    array( 'question' => 'How much does a Charleston motorcycle accident lawyer cost?', 'answer' => 'Nothing up front. Roden Law handles motorcycle accident cases on a contingency fee. The consultation is free, and there is no fee unless we win your case.' ),
    array( 'question' => 'How long do I have to file a motorcycle accident lawsuit in South Carolina?', 'answer' => 'Three years from the date of the crash under S.C. Code § 15-3-530. If a government entity is responsible, the deadline is two years under S.C. Code § 15-78-110, or three years if a verified claim was filed with the agency within one year.' ),
    array( 'question' => 'Can I still recover if I was not wearing a helmet?', 'answer' => 'Yes, you can still bring a claim. South Carolina requires a helmet only for operators and passengers under 21 (S.C. Code § 56-5-3660), so a rider 21 or older without one broke no law. An insurer may still raise it, which is one reason to preserve the evidence of how the crash happened.' ),
    array( 'question' => 'Can I still recover if I was partly at fault?', 'answer' => 'Yes, if you were 50% or less at fault. South Carolina\'s modified comparative negligence rule (Nelson v. Concrete Supply Co.) reduces your award by your share of fault and bars recovery only above 50%.' ),
    array( 'question' => 'Is lane splitting legal in South Carolina?', 'answer' => 'No. S.C. Code § 56-5-3640 prohibits riding between lanes of traffic or rows of vehicles. The same section entitles every motorcycle to the full use of a lane (except when motorcycles ride two abreast in it), and a driver who crowds a rider out of the lane violates it.' ),
    array( 'question' => 'What if the driver who hit me was uninsured or underinsured?', 'answer' => 'Your own coverage may pay. Every South Carolina auto policy must include uninsured motorist coverage (S.C. Code § 38-77-150), and insurers must offer underinsured motorist coverage (S.C. Code § 38-77-160).' ),
);

$post_fields = array(
    'ID'           => $id,
    'post_title'   => 'Charleston Motorcycle Accident Lawyers',
    'post_content' => $body,
    // Published as the Article description by roden_schema_article().
    'post_excerpt' => 'Hurt in a Charleston motorcycle accident? Roden Law\'s King Street lawyers handle South Carolina motorcycle accident claims. Free consultation, no fee unless we win.',
);
$meta = array(
    '_roden_key_takeaways'    => $key_takeaways,
    '_roden_faqs'             => $faqs,
    '_roden_meta_title'       => 'Charleston Motorcycle Accident Lawyer | Roden Law',
    '_roden_meta_description' => 'Hurt in a Charleston motorcycle accident? Roden Law\'s King Street lawyers handle South Carolina motorcycle claims. Free consultation, no fee unless we win. (843) 790-8999.',
    '_roden_author_attorney'  => '3732', // Graeham C. Gillin, SC Bar
);

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'charleston-motorcycle-accident-rebuild',
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
