<?php
/**
 * Write the rebuilt Charleston workers' compensation page into post 3654,
 * KEEPING IT A DRAFT. Wave 1, #5 of docs/site-architecture/README.md (owner:
 * "start Charleston workers' comp", 2026-09-26). South Carolina only; the map,
 * law box (WC deadline and notice), WC steps, results and FAQ render from
 * template-intersection.php. GSC before retirement: 38k impressions at ~17.5,
 * the nested duplicate 23.6k at ~10.9.
 *
 * Publishing is a separate step, after the legal sweep and Graeham C. Gillin's
 * sign-off. This script never publishes, never removes _roden_retired, and never
 * sets _roden_last_reviewed (a review date is stamped only by the reviewer's word).
 *
 * Every statute is from internal-ai-scripts/law/SC.json. No punitive-damages
 * figure and no statistic. Federal coverage (Longshore Act) is mentioned only as
 * a pointer, with no specifics.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/rebuild-charleston-workers-comp.php \
 *       > docs/backups/charleston-workers-comp-before-$(date +%Y-%m-%d).json
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/rebuild-charleston-workers-comp.php \
 *       > docs/backups/charleston-workers-comp-before-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3654;

$p = get_post( $id );
if ( ! $p instanceof WP_Post || 'practice_area' !== $p->post_type || 'charleston-sc' !== $p->post_name ) {
    fprintf( $err, "ABORT: post %d is not the charleston-sc practice_area.\n", $id );
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
<h2>Why Hire Roden Law After a Charleston Workplace Injury</h2>
<p>Workers' compensation is supposed to be simple: you get hurt at work, and benefits pay for your treatment and part of your lost wages. In practice, claims are delayed, benefits are cut off early, and injured workers are told they missed a deadline. Our Charleston lawyers handle the claim so you can focus on getting better.</p>
<ul>
<li><strong>No fee unless we win.</strong> The consultation is free, and you pay nothing up front.</li>
<li><strong>A South Carolina lawyer on your case.</strong> Your claim is handled under South Carolina law by attorneys licensed here, from our office at 127 King Street.</li>
<li><strong>Deadlines tracked for you.</strong> Notice to your employer and the claim with the South Carolina Workers' Compensation Commission each have their own deadline.</li>
<li><strong>Third-party claims found.</strong> If someone other than your employer caused the injury, a separate claim can recover what workers' comp does not.</li>
</ul>

<h2>Where Charleston Workplace Injuries Happen</h2>
<h3>The port and logistics</h3>
<p>Terminal, trucking and warehouse work around the Port of Charleston produces crush, struck-by and lifting injuries. Some port and maritime workers are covered by federal law rather than South Carolina workers' compensation. See <a href="/blog/longshoreman-injury-claims/">longshoreman injury claims</a>.</p>
<h3>Manufacturing and aerospace</h3>
<p>Plants in North Charleston produce machinery, repetitive-motion and chemical-exposure injuries. See <a href="/blog/boeing-north-charleston-workplace-injuries-workers-comp/">workplace injuries at North Charleston plants</a>. Our <a href="/locations/south-carolina/north-charleston/">North Charleston office</a> at 2703 Spruill Avenue is close to the industrial corridor.</p>
<h3>Construction</h3>
<p>Charleston's building boom brings falls, equipment accidents and trench and scaffold injuries. See <a href="/blog/construction-worker-injuries-charleston-sc-rights/">construction worker injuries in Charleston</a>.</p>
<h3>Hospitals, hotels and restaurants</h3>
<p>Healthcare, hospitality and restaurant workers downtown are hurt lifting patients and guests' luggage, on wet floors and in kitchens. Repetitive strain counts too; see <a href="/workers-compensation-lawyers/occupational-disease/">occupational disease claims</a>.</p>

<h2>South Carolina Workers' Compensation Rules</h2>
<h3>Two deadlines, not one</h3>
<p>You must give your employer notice of the injury right away, and no later than 90 days after the accident (<a href="https://www.scstatehouse.gov/code/t42c015.php">S.C. Code § 42-15-20</a>), and file your claim with the South Carolina Workers' Compensation Commission within two years of the accident (S.C. Code § 42-15-40). Telling your supervisor is not the same as filing a claim.</p>
<h3>Fault does not matter, with two exceptions</h3>
<p>You do not have to prove your employer was careless. No compensation is payable if the injury was caused by the worker's intoxication or wilful intention to injure himself or another, and the party raising that defense has to prove it (S.C. Code § 42-9-60).</p>
<h3>What workers' comp pays</h3>
<p>Total disability pays 66 2/3% of your average weekly wage, no more than the state average weekly wage, for up to 500 weeks, or for life for a worker left paraplegic, quadriplegic or with physical brain damage (<a href="https://www.scstatehouse.gov/code/t42c009.php">S.C. Code § 42-9-10</a>). See <a href="/resources/how-much-does-south-carolina-workers-comp-pay/">how much South Carolina workers' comp pays</a>, <a href="/resources/south-carolina-workers-comp-body-part-values/">South Carolina body part values</a> and <a href="/resources/south-carolina-workers-comp-impairment-rating-mmi/">impairment ratings and MMI</a>.</p>
<h3>You usually cannot sue your employer, but you may be able to sue someone else</h3>
<p>Where you and your employer are under the Act, workers' compensation is your exclusive remedy against the employer: no lawsuit and no pain-and-suffering or punitive damages from the employer (<a href="https://www.scstatehouse.gov/code/t42c001.php">S.C. Code § 42-1-540</a>). A claim against a third party, such as a negligent driver or the maker of a defective machine, is separate. See <a href="/workers-compensation-lawyers/third-party-workplace-injury/">third-party workplace injury claims</a>.</p>
<p>If your claim has been denied, see <a href="/resources/south-carolina-workers-comp-claim-denied/">what to do after a denial</a> and <a href="/workers-compensation-lawyers/denied-workers-comp-claim/">denied workers' comp claims</a>. For the rest of South Carolina, see our <a href="/south-carolina-workers-compensation-lawyer/">South Carolina workers' compensation lawyers</a>.</p>
HTML;

$key_takeaways = 'If you were hurt at work in Charleston, South Carolina law requires you to notify your employer right away, and no later than 90 days (S.C. Code § 42-15-20) and to file a claim with the South Carolina Workers\' Compensation Commission within two years of the accident (S.C. Code § 42-15-40). You do not have to prove fault, but workers\' compensation is generally your exclusive remedy against your employer, with no pain-and-suffering damages (S.C. Code § 42-1-540). Total disability pays 66 2/3% of your average weekly wage, up to the state average weekly wage, generally for up to 500 weeks (S.C. Code § 42-9-10). Roden Law\'s Charleston office at 127 King Street handles workers\' comp claims: the consultation is free and there is no fee unless we win.';

$faqs = array(
    array( 'question' => 'How much does a Charleston workers\' comp lawyer cost?', 'answer' => 'Nothing up front. The consultation is free, and there is no fee unless we win your case.' ),
    array( 'question' => 'How long do I have to report a work injury in South Carolina?', 'answer' => 'You must notify your employer right away, and no later than 90 days after the injury (S.C. Code § 42-15-20), and file your claim with the South Carolina Workers\' Compensation Commission within two years of the accident (S.C. Code § 42-15-40).' ),
    array( 'question' => 'Can I sue my employer for a workplace injury?', 'answer' => 'Usually not. Where you and your employer are under the Workers\' Compensation Act, workers\' comp is your exclusive remedy against the employer (S.C. Code § 42-1-540). You may still have a claim against a third party who caused the injury.' ),
    array( 'question' => 'Does it matter if the accident was my fault?', 'answer' => 'Generally no. Workers\' comp does not depend on fault. Benefits can be denied if the injury was caused by your intoxication or wilful intention to injure yourself or another, and the party raising that defense must prove it (S.C. Code § 42-9-60).' ),
    array( 'question' => 'How much does workers\' comp pay in South Carolina?', 'answer' => 'Total disability pays 66 2/3% of your average weekly wage, no more than the state average weekly wage, for up to 500 weeks, or for life for a worker left paraplegic, quadriplegic or with physical brain damage (S.C. Code § 42-9-10).' ),
    array( 'question' => 'Can I get pain and suffering damages?', 'answer' => 'Not from workers\' compensation. Where you and your employer are under the Workers\' Compensation Act, there are no pain-and-suffering or punitive damages from the employer (S.C. Code § 42-1-540). A separate claim against a third party who caused the injury can include them.' ),
);

$post_fields = array(
    'ID'           => $id,
    'post_title'   => 'Charleston Workers\' Compensation Lawyers',
    'post_content' => $body,
    // Published as the Article description by roden_schema_article().
    'post_excerpt' => 'Hurt on the job in Charleston? Roden Law\'s King Street lawyers handle South Carolina workers\' compensation claims and third-party injury claims. Free consultation, no fee unless we win.',
);
$meta = array(
    '_roden_key_takeaways'    => $key_takeaways,
    '_roden_faqs'             => $faqs,
    '_roden_meta_title'       => 'Charleston Workers\' Comp Lawyer | Roden Law',
    '_roden_meta_description' => 'Hurt on the job in Charleston? Notify your employer right away (no later than 90 days) and file within two years. Roden Law\'s King Street lawyers handle South Carolina workers\' comp claims. (843) 790-8999.',
    '_roden_author_attorney'  => '3732', // Graeham C. Gillin, SC Bar
);

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'charleston-workers-comp-rebuild',
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
