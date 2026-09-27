<?php
/**
 * Write the rebuilt Savannah car accident page into post 3622, KEEPING IT A
 * DRAFT. Wave 1, #3 of docs/site-architecture/README.md (owner: "then start
 * Savannah car", 2026-09-26) — the first GEORGIA office practice page. Georgia
 * only; the map, NAP bar, law box, steps, case types, results and FAQ render
 * from template-intersection.php. GSC before retirement: 92k impressions at
 * position ~20. Georgia claims for Roden are signed off by Eric Roden.
 *
 * Publishing is a separate step, after the legal sweep and Graeham C. Gillin's
 * sign-off (Eric Roden for Georgia). This script never publishes, never removes _roden_retired, and never
 * sets _roden_last_reviewed (a review date is stamped only by the reviewer's word).
 *
 * Every statute is from internal-ai-scripts/law/GA.json. No punitive-damages
 * figure. One statistic, from data/statistics.json (chatham-county-traffic-deaths-2022).
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/rebuild-savannah-car-accident.php \
 *       > docs/backups/savannah-car-accident-before-$(date +%Y-%m-%d).json
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/rebuild-savannah-car-accident.php \
 *       > docs/backups/savannah-car-accident-before-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3622;

$p = get_post( $id );
if ( ! $p instanceof WP_Post || 'practice_area' !== $p->post_type || 'savannah-ga' !== $p->post_name ) {
    fprintf( $err, "ABORT: post %d is not the savannah-ga practice_area.\n", $id );
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
<h2>Why Hire Roden Law After a Savannah Car Accident</h2>
<p>Savannah is Roden Law's home office. Our car accident lawyers work from 333 Commercial Drive, just off Abercorn Street, and handle crashes across Chatham County and the surrounding coast.</p>
<ul>
<li><strong>No fee unless we win.</strong> The consultation is free, and you pay nothing up front.</li>
<li><strong>A Georgia lawyer on your case.</strong> Your case is handled under Georgia law by attorneys licensed here.</li>
<li><strong>Built for trial.</strong> We prepare cases to be tried at the Chatham County Courthouse if the insurer will not pay fairly.</li>
<li><strong>Every policy found.</strong> The at-fault driver's liability coverage, your own uninsured motorist coverage, and rideshare or commercial policies where they apply.</li>
</ul>

<h2>Where Car Accidents Happen in Savannah</h2>
<p>According to NHTSA's Fatality Analysis Reporting System, Chatham County recorded 40 traffic deaths in 2022. Most of the Savannah crashes we see happen on a handful of roads. See our guides to <a href="/blog/dangerous-savannah-intersections/">Savannah's most dangerous intersections</a> and <a href="/blog/savannah-dangerous-highways-i16-i95-abercorn/">I-16, I-95 and Abercorn Street</a>.</p>
<h3>Abercorn Street</h3>
<p>Abercorn Street runs from downtown past the Oglethorpe Mall area to the southside, where it carries SR 204, with heavy retail traffic, frequent signals and turning vehicles. Our office sits just off it. See <a href="/resources/abercorn-street-truck-accidents-savannah/">Abercorn Street truck accidents</a>.</p>
<h3>I-16, I-516 and I-95</h3>
<p>I-16 brings traffic into downtown, I-516 connects it to the port and the southside, and I-95 carries interstate traffic past Pooler and Richmond Hill. Port trucks share all three. See <a href="/resources/i-16-truck-accidents-savannah/">I-16 truck accidents</a> and <a href="/resources/i-516-truck-accidents-port-savannah/">I-516 and the Port of Savannah</a>.</p>
<h3>Pooler and the Jimmy DeLoach corridor</h3>
<p>Warehouse growth around Pooler has added freight traffic to local roads. See <a href="/resources/pooler-warehouse-district-truck-accidents/">the Pooler warehouse district</a> and <a href="/resources/jimmy-deloach-connector-truck-accidents-savannah/">the Jimmy DeLoach Connector</a>.</p>
<h3>Downtown and the historic district</h3>
<p>Downtown's grid mixes visitors, pedestrians and delivery traffic. See <a href="/blog/east-bay-street-savannah-pedestrian-accident-lawyer/">East Bay Street pedestrian accidents</a>.</p>
<p>Common crash types we handle include <a href="/blog/who-pays-for-damages-from-t-bone-crashes-in-savannah/">T-bone crashes</a> and <a href="/blog/liability-in-head-on-collisions-savannah-ga/">head-on collisions</a>. If an insurer has already offered you money, read <a href="/blog/accepting-a-cash-offer-after-savannah-car-crash/">accepting a cash offer after a Savannah crash</a> first.</p>

<h2>Georgia Rules That Shape a Savannah Claim</h2>
<h3>Crashes involving a city, county or state vehicle</h3>
<p>Georgia requires written notice before you can sue a government. A claim against a city must be presented within six months of the injury (O.C.G.A. § 36-33-5). A claim against a county must be presented within twelve months (O.C.G.A. § 36-11-1), and notice of a claim against the State of Georgia must be given within twelve months (O.C.G.A. § 50-21-26). These deadlines are much shorter than the two-year deadline for a lawsuit, so call early. See <a href="/car-accident-lawyers/government-vehicle-accident/">government vehicle accidents</a>.</p>
<h3>Insurance: minimum limits and uninsured motorist coverage</h3>
<p>Georgia drivers must carry at least $25,000 per person and $50,000 per accident in bodily injury liability, plus $25,000 in property damage, and insurers must offer uninsured motorist coverage (O.C.G.A. § 33-7-11). A serious crash can exceed those minimums quickly, which is why your own uninsured motorist coverage matters.</p>
<h3>Vehicle damage has its own deadline</h3>
<p>A claim for damage to your car has a four-year deadline in Georgia (O.C.G.A. § 9-3-32). The two-year deadline in O.C.G.A. § 9-3-33 is for injury claims.</p>
<h3>Where your case would be filed</h3>
<p>Savannah car accident lawsuits are usually filed at the Chatham County Courthouse, 133 Montgomery Street. For how Georgia settlements are valued, see <a href="/resources/georgia-car-accident-settlement-value/">Georgia car accident settlement value</a>, and for deadlines, <a href="/resources/georgia-statute-of-limitations/">the Georgia statute of limitations</a>.</p>
HTML;

$key_takeaways = 'If you were injured in a car accident in Savannah, Georgia law gives you two years from the date of the crash to file an injury lawsuit (O.C.G.A. § 9-3-33). A claim against a city must be presented within six months (O.C.G.A. § 36-33-5), and against a county or the State within twelve months. Georgia bars recovery if you are 50% or more at fault; below that, your award is reduced by your share (O.C.G.A. § 51-12-33). Roden Law\'s Savannah office at 333 Commercial Drive handles car accident cases on contingency: the consultation is free and there is no fee unless we win.';

$faqs = array(
    array( 'question' => 'How much does a Savannah car accident lawyer cost?', 'answer' => 'Nothing up front. Roden Law handles car accident cases on a contingency fee. The consultation is free, and there is no fee unless we win your case.' ),
    array( 'question' => 'How long do I have to file a car accident lawsuit in Georgia?', 'answer' => 'Two years from the date of the crash for an injury claim under O.C.G.A. § 9-3-33. A claim for damage to your vehicle has four years under O.C.G.A. § 9-3-32.' ),
    array( 'question' => 'Can I still recover if I was partly at fault?', 'answer' => 'Yes, if you were less than 50% at fault. Georgia bars recovery at 50% or more; below that, your award is reduced by your share of fault (O.C.G.A. § 51-12-33).' ),
    array( 'question' => 'What if a city or county vehicle hit me?', 'answer' => 'Georgia requires written notice before a lawsuit against a government. A claim against a city must be presented within six months of the injury (O.C.G.A. § 36-33-5); against a county, within twelve months (O.C.G.A. § 36-11-1).' ),
    array( 'question' => 'What if the driver who hit me was uninsured?', 'answer' => 'Your own uninsured motorist coverage may pay. Georgia insurers must offer it (O.C.G.A. § 33-7-11), so check whether your policy includes it.' ),
    array( 'question' => 'Where would my Savannah car accident case be filed?', 'answer' => 'Savannah car accident lawsuits are usually filed at the Chatham County Courthouse, 133 Montgomery Street.' ),
);

$post_fields = array(
    'ID'           => $id,
    'post_title'   => 'Savannah Car Accident Lawyers',
    'post_content' => $body,
    // Published as the Article description by roden_schema_article().
    'post_excerpt' => 'Hurt in a Savannah car accident? Roden Law\'s Savannah lawyers handle Georgia car accident claims from our Commercial Drive office. Free consultation, no fee unless we win.',
);
$meta = array(
    '_roden_key_takeaways'    => $key_takeaways,
    '_roden_faqs'             => $faqs,
    '_roden_meta_title'       => 'Savannah Car Accident Lawyer | Roden Law',
    '_roden_meta_description' => 'Hurt in a Savannah car accident? Roden Law\'s Savannah lawyers handle Georgia car accident claims. Free consultation, no fee unless we win. (912) 303-5850.',
    '_roden_author_attorney'  => '3729', // Eric Roden, GA Bar (writer profile: Georgia content)
);

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'savannah-car-accident-rebuild',
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
