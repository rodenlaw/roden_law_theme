<?php
/**
 * Write the rebuilt Savannah workers' compensation page into post 3652,
 * KEEPING IT A DRAFT. Wave 1, #6 of docs/site-architecture/README.md (owner:
 * "do the Savannah's WC page", 2026-09-26). Georgia only; the map, law box (WC
 * claim deadline and 30-day notice), Georgia WC steps, the Savannah WC essay,
 * results and FAQ render from template-intersection.php. Georgia claims for
 * Roden are reviewed by Eric Roden.
 *
 * Publishing is a separate step, after the legal sweep and Eric Roden's
 * sign-off. This script never publishes, never removes _roden_retired, and never
 * sets _roden_last_reviewed (a review date is stamped only by the reviewer's word).
 *
 * Statutes: §§ 34-9-82, 34-9-80, 34-9-261 are signed in the GA pack; §§ 34-9-11 and
 * 34-9-17 are pending there and rest on Eric Roden's review of this page. No punitive-damages
 * figure and no statistic. Federal coverage (Longshore Act) is mentioned only as
 * a pointer, with no specifics.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/rebuild-savannah-workers-comp.php \
 *       > docs/backups/savannah-workers-comp-before-$(date +%Y-%m-%d).json
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/rebuild-savannah-workers-comp.php \
 *       > docs/backups/savannah-workers-comp-before-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3652;

$p = get_post( $id );
if ( ! $p instanceof WP_Post || 'practice_area' !== $p->post_type || 'savannah-ga' !== $p->post_name ) {
    fprintf( $err, "ABORT: post %d is not the savannah-ga practice_area.\n", $id );
    exit( 1 );
}
if ( 'draft' !== $p->post_status ) {
    fprintf( $err, "ABORT: post %d is '%s'; this script only writes to the draft.\n", $id, $p->post_status );
    exit( 1 );
}
if ( 'workers-compensation-lawyers' !== get_post_field( 'post_name', $p->post_parent ) ) {
    fprintf( $err, "ABORT: parent is not the workers' compensation pillar.\n" );
    exit( 1 );
}

$body = <<<'HTML'
<h2>Why Hire Roden Law After a Savannah Workplace Injury</h2>
<p>Workers' compensation is supposed to be simple: you get hurt at work, and benefits pay for your treatment and part of your lost wages. In practice, claims are delayed, benefits are cut off early, and injured workers are told they missed a deadline. Our Savannah lawyers handle the claim so you can focus on getting better.</p>
<ul>
<li><strong>No fee unless we win.</strong> The consultation is free, and you pay nothing up front.</li>
<li><strong>A Georgia lawyer on your case.</strong> Your claim is handled under Georgia law by attorneys licensed here, from our office at 333 Commercial Drive.</li>
<li><strong>Deadlines tracked for you.</strong> Notice to your employer and the claim with the State Board of Workers' Compensation each have their own deadline.</li>
<li><strong>Third-party claims found.</strong> If someone other than your employer caused the injury, a separate claim can recover what workers' comp does not.</li>
</ul>

<h2>Where Savannah Workplace Injuries Happen</h2>
<h3>The port</h3>
<p>Container and equipment work at Garden City Terminal produces crush, struck-by and fall injuries. Some port and maritime workers are covered by federal law instead of, or in addition to, Georgia workers' compensation. See <a href="/blog/longshoreman-injury-claims/">longshoreman injury claims</a>.</p>
<h3>Warehouses and distribution</h3>
<p>The warehouse corridor around Pooler and I-16 produces lifting, forklift and loading-dock injuries. See <a href="/resources/pooler-warehouse-district-truck-accidents/">the Pooler warehouse district</a>.</p>
<h3>Construction, manufacturing and hospitals</h3>
<p>Falls, equipment accidents, repetitive strain and patient-lifting injuries fill out the rest. Repetitive strain and work-caused illness count too; see <a href="/workers-compensation-lawyers/occupational-disease/">occupational disease claims</a>.</p>

<h2>Georgia Workers' Compensation Rules</h2>
<h3>Two deadlines, not one</h3>
<p>Give your employer notice of the injury right away, and no later than 30 days after it happens (O.C.G.A. § 34-9-80). The claim itself must be filed with the State Board of Workers' Compensation within one year of the injury, or within one year of the last employer-furnished medical treatment, or two years from the last payment of weekly benefits (O.C.G.A. § 34-9-82). Telling your supervisor is not the same as filing a claim. See <a href="/blog/workers-compensation-claim-process-georgia/">how the Georgia claim process works</a>.</p>
<h3>Choosing your doctor</h3>
<p>Georgia employers generally must post a panel of physicians, and treating outside it without approval can cost you coverage. Ask for the panel in writing. See <a href="/blog/changing-workers-comp-doctors-in-georgia/">changing workers' comp doctors in Georgia</a>.</p>
<h3>Fault usually does not matter</h3>
<p>You do not have to prove your employer was careless. Benefits can be barred for an employee's willful misconduct or for intoxication (O.C.G.A. § 34-9-17).</p>
<h3>What workers' comp pays</h3>
<p>Weekly income benefits are capped at a maximum set by statute and adjusted periodically (O.C.G.A. § 34-9-261), so the current figure should be confirmed with the State Board before you rely on it. See <a href="/blog/workers-comp-benefits-georgia-taxable/">whether Georgia workers' comp benefits are taxable</a>.</p>
<h3>You usually cannot sue your employer, but you may be able to sue someone else</h3>
<p>Workers' compensation is generally your exclusive remedy against your employer: no lawsuit and no pain-and-suffering or punitive damages from the employer (O.C.G.A. § 34-9-11). A claim against a third party, such as a negligent driver or the maker of a defective machine, is separate. See <a href="/workers-compensation-lawyers/third-party-workplace-injury/">third-party workplace injury claims</a>.</p>
<p>If your claim has been denied, see <a href="/workers-compensation-lawyers/denied-workers-comp-claim/">denied workers' comp claims</a> and <a href="/blog/appealing-a-denied-workers-compensation-claim/">appealing a denial</a>.</p>
HTML;

$key_takeaways = 'If you were hurt at work in Savannah, Georgia law requires you to notify your employer right away, and no later than 30 days (O.C.G.A. § 34-9-80) and to file a claim with the State Board of Workers\' Compensation, generally within one year of the injury (O.C.G.A. § 34-9-82). You do not have to prove fault, but workers\' compensation is generally your exclusive remedy against your employer, with no pain-and-suffering damages (O.C.G.A. § 34-9-11). Georgia employers generally must post a panel of physicians, so ask for it before you choose a doctor. Roden Law\'s Savannah office at 333 Commercial Drive handles workers\' comp claims: the consultation is free and there is no fee unless we win.';

$faqs = array(
    array( 'question' => 'How much does a Savannah workers\' comp lawyer cost?', 'answer' => 'Nothing up front. The consultation is free, and there is no fee unless we win your case.' ),
    array( 'question' => 'How long do I have to report a work injury in Georgia?', 'answer' => 'Notify your employer right away, and no later than 30 days after the injury (O.C.G.A. § 34-9-80). The claim must be filed with the State Board of Workers\' Compensation within one year of the injury, or one year from the last employer-furnished medical treatment, or two years from the last payment of weekly benefits (O.C.G.A. § 34-9-82).' ),
    array( 'question' => 'Can I choose my own doctor?', 'answer' => 'Usually not at first. Georgia employers generally must post a panel of physicians, and treating outside it without approval can cost you coverage. Ask your employer for the panel in writing.' ),
    array( 'question' => 'Can I sue my employer for a workplace injury?', 'answer' => 'Usually not. Workers\' compensation is generally your exclusive remedy against your employer (O.C.G.A. § 34-9-11). You may still have a claim against a third party who caused the injury.' ),
    array( 'question' => 'Does it matter if the accident was my fault?', 'answer' => 'Generally no. Workers\' comp does not depend on fault. Benefits can be barred for willful misconduct or intoxication (O.C.G.A. § 34-9-17).' ),
    array( 'question' => 'Can I get pain and suffering damages?', 'answer' => 'Not from workers\' compensation. There are generally no pain-and-suffering or punitive damages from the employer (O.C.G.A. § 34-9-11). A separate claim against a third party who caused the injury can include them.' ),
);

$post_fields = array(
    'ID'           => $id,
    'post_title'   => 'Savannah Workers\' Compensation Lawyers',
    'post_content' => $body,
    // Published as the Article description by roden_schema_article().
    'post_excerpt' => 'Hurt on the job in Savannah? Roden Law\'s Savannah lawyers handle Georgia workers\' compensation claims and third-party injury claims. Free consultation, no fee unless we win.',
);
$meta = array(
    '_roden_key_takeaways'    => $key_takeaways,
    '_roden_faqs'             => $faqs,
    '_roden_meta_title'       => 'Savannah Workers\' Comp Lawyer | Roden Law',
    '_roden_meta_description' => 'Hurt on the job in Savannah? Notify your employer within 30 days and file with the State Board, generally within one year. Roden Law\'s Savannah lawyers can help. (912) 303-5850.',
    '_roden_author_attorney'  => '3729', // Eric Roden, GA Bar
);

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'savannah-workers-comp-rebuild',
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
