<?php
/**
 * Write the rebuilt Savannah truck accident page into post 3627, KEEPING IT A
 * DRAFT. Wave 1, #4 of docs/site-architecture/README.md (owner: "then start
 * Savannah truck", 2026-09-26). Georgia
 * only; the map, NAP bar, law box, steps, case types, results and FAQ render
 * from template-intersection.php. GSC before retirement: 10.7k impressions at
 * position ~15 (the nested duplicate at ~6). Georgia claims for Roden are signed off by Eric Roden.
 *
 * Publishing is a separate step, after the legal sweep and Graeham C. Gillin's
 * sign-off (Eric Roden for Georgia). This script never publishes, never removes _roden_retired, and never
 * sets _roden_last_reviewed (a review date is stamped only by the reviewer's word).
 *
 * Every statute is from internal-ai-scripts/law/GA.json. No punitive-damages
 * figure and no statistic. No federal-regulation specifics beyond what FMCSA governs.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/rebuild-savannah-truck-accident.php \
 *       > docs/backups/savannah-truck-accident-before-$(date +%Y-%m-%d).json
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/rebuild-savannah-truck-accident.php \
 *       > docs/backups/savannah-truck-accident-before-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3627;

$p = get_post( $id );
if ( ! $p instanceof WP_Post || 'practice_area' !== $p->post_type || 'savannah-ga' !== $p->post_name ) {
    fprintf( $err, "ABORT: post %d is not the savannah-ga practice_area.\n", $id );
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
<h2>Why Hire Roden Law After a Savannah Truck Accident</h2>
<p>A truck crash is not a car crash with a bigger vehicle. The trucking company, its insurer and often a broker or shipper each have their own lawyers, and the evidence that proves fault, such as the truck's electronic logs, maintenance records and the carrier's safety files, is in their hands.</p>
<ul>
<li><strong>No fee unless we win.</strong> The consultation is free, and you pay nothing up front.</li>
<li><strong>A Georgia lawyer on your case.</strong> Your case is handled under Georgia law by attorneys licensed here, from our office at 333 Commercial Drive.</li>
<li><strong>Evidence preserved early.</strong> We send preservation demands for electronic logging data, dashcam video and maintenance records before they can be overwritten or discarded. See <a href="/blog/why-get-black-box-data-after-truck-crash-savannah/">why black box data matters after a Savannah truck crash</a>.</li>
<li><strong>Every responsible party named.</strong> The driver, the motor carrier, and where the facts support it, the broker, the shipper or the company that loaded or maintained the truck.</li>
</ul>

<h2>Why Savannah Sees So Many Truck Crashes</h2>
<p>The Port of Savannah's Garden City Terminal sends container trucks onto I-16, I-516, I-95 and the roads around Pooler every day, and the warehouse district west of the city adds more. See <a href="/resources/port-of-savannah-truck-routes/">Port of Savannah truck routes</a>.</p>
<h3>I-16 and I-516</h3>
<p>I-16 and I-516 carry port freight between Garden City, downtown and the southside. See <a href="/resources/i-16-truck-accidents-savannah/">I-16 truck accidents</a> and <a href="/resources/i-516-truck-accidents-port-savannah/">I-516 and the Port of Savannah</a>.</p>
<h3>I-95 and the I-16 / I-95 interchange</h3>
<p>I-95 carries interstate freight past Pooler and Richmond Hill, and work zones at the I-16 interchange change lane patterns for heavy trucks. See <a href="/resources/i-95-truck-accidents-savannah-brunswick/">I-95 truck accidents</a> and <a href="/resources/i-16-i-95-construction-zone-truck-accidents/">I-16 and I-95 construction zone truck accidents</a>.</p>
<h3>Pooler and the warehouse district</h3>
<p>Distribution centers around Pooler put tractor-trailers on Dean Forest Road and the Jimmy DeLoach Connector. See <a href="/resources/pooler-warehouse-district-truck-accidents/">the Pooler warehouse district</a>, <a href="/resources/dean-forest-road-truck-accidents-pooler/">Dean Forest Road truck accidents</a> and <a href="/resources/jimmy-deloach-connector-truck-accidents-savannah/">the Jimmy DeLoach Connector</a>.</p>
<h3>Abercorn Street and downtown</h3>
<p>Delivery and freight trucks also share Abercorn Street and the historic district's narrow streets. See <a href="/resources/abercorn-street-truck-accidents-savannah/">Abercorn Street truck accidents</a> and <a href="/resources/bay-street-truck-accidents-savannah-historic-district/">Bay Street truck accidents</a>.</p>

<h2>Who Can Be Responsible for a Savannah Truck Crash</h2>
<p>A truck claim often has more than one defendant: the driver, the motor carrier that employed or contracted the driver, a freight broker, the shipper or the company that loaded the cargo, and the company that maintained the truck. Federal safety rules for commercial trucks, covering hours of service, driver qualification, vehicle inspection and maintenance, and drug and alcohol testing, are set by the <a href="https://www.fmcsa.dot.gov/regulations">Federal Motor Carrier Safety Administration</a>. A violation can be strong evidence that the driver or the carrier was careless.</p>

<h2>Georgia Rules That Shape a Truck Claim</h2>
<h3>Trucks owned by a city, county or the State</h3>
<p>Georgia requires written notice before you can sue a government. A claim against a city must be presented within six months of the injury (O.C.G.A. § 36-33-5). A claim against a county must be presented within twelve months (O.C.G.A. § 36-11-1), and notice of a claim against the State of Georgia must be given within twelve months (O.C.G.A. § 50-21-26). These deadlines are much shorter than the two-year deadline for a lawsuit, so call early.</p>
<h3>Your own coverage</h3>
<p>Georgia insurers must offer uninsured motorist coverage (O.C.G.A. § 33-7-11). Your own coverage can matter if the truck's coverage does not reach the full cost of your injuries.</p>
<h3>Where your case would be filed</h3>
<p>Savannah truck accident lawsuits are usually filed at the Chatham County Courthouse, 133 Montgomery Street. For how Georgia truck settlements are valued, see <a href="/resources/georgia-truck-accident-settlement-value/">Georgia truck accident settlement value</a>. If a car was involved rather than a commercial truck, see our <a href="/car-accident-lawyers/savannah-ga/">Savannah car accident lawyers</a>.</p>
HTML;

$key_takeaways = 'If you were injured in a truck accident in Savannah, Georgia law gives you two years from the date of the crash to file an injury lawsuit (O.C.G.A. § 9-3-33). A claim against a city must be presented within six months (O.C.G.A. § 36-33-5), and against a county or the State within twelve months. Georgia bars recovery if you are 50% or more at fault; below that, your award is reduced by your share (O.C.G.A. § 51-12-33). A truck claim often has several defendants, including the driver, the motor carrier and sometimes a broker or shipper, and the evidence needs to be preserved early. Roden Law\'s Savannah office at 333 Commercial Drive handles truck accident cases on contingency: the consultation is free and there is no fee unless we win.';

$faqs = array(
    array( 'question' => 'How much does a Savannah truck accident lawyer cost?', 'answer' => 'Nothing up front. Roden Law handles truck accident cases on a contingency fee. The consultation is free, and there is no fee unless we win your case.' ),
    array( 'question' => 'How long do I have to file a truck accident lawsuit in Georgia?', 'answer' => 'Two years from the date of the crash for an injury claim under O.C.G.A. § 9-3-33. A claim for damage to your vehicle has four years under O.C.G.A. § 9-3-32.' ),
    array( 'question' => 'Who can be held responsible for a truck crash?', 'answer' => 'Often more than the driver. Depending on the facts, the motor carrier, a freight broker, the shipper or loader, and the company that maintained the truck can all share responsibility.' ),
    array( 'question' => 'Can I still recover if I was partly at fault?', 'answer' => 'Yes, if you were less than 50% at fault. Georgia bars recovery at 50% or more; below that, your award is reduced by your share of fault (O.C.G.A. § 51-12-33).' ),
    array( 'question' => 'What if the truck belonged to a city or county?', 'answer' => 'Georgia requires written notice before a lawsuit against a government. A claim against a city must be presented within six months of the injury (O.C.G.A. § 36-33-5); against a county, within twelve months (O.C.G.A. § 36-11-1).' ),
    array( 'question' => 'What evidence matters most after a truck crash?', 'answer' => 'The truck\'s electronic logging data, dashcam and other video, maintenance and inspection records, and the carrier\'s driver files. Some of it can be overwritten or discarded, so it should be requested in writing as early as possible.' ),
);

$post_fields = array(
    'ID'           => $id,
    'post_title'   => 'Savannah Truck Accident Lawyers',
    'post_content' => $body,
    // Published as the Article description by roden_schema_article().
    'post_excerpt' => 'Hurt in a Savannah truck accident? Roden Law\'s Savannah lawyers handle Georgia truck accident claims against drivers, carriers and brokers. Free consultation, no fee unless we win.',
);
$meta = array(
    '_roden_key_takeaways'    => $key_takeaways,
    '_roden_faqs'             => $faqs,
    '_roden_meta_title'       => 'Savannah Truck Accident Lawyer | Roden Law',
    '_roden_meta_description' => 'Hurt in a Savannah truck accident? Roden Law\'s Savannah lawyers handle Georgia truck claims against drivers, carriers and brokers. Free consultation, no fee unless we win. (912) 303-5850.',
    '_roden_author_attorney'  => '3729', // Eric Roden, GA Bar (writer profile: Georgia content)
);

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'savannah-truck-accident-rebuild',
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
