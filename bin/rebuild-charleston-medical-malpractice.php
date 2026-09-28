<?php
/**
 * Write the rebuilt Charleston medical malpractice page into post 3644, KEEPING IT A DRAFT.
 * Wave 1, #11 of docs/site-architecture/README.md (owner: "fix those FAQs and
 * then do the last wave 1 pages", 2026-09-28). South Carolina only; the map, NAP
 * bar, law box, steps, results and FAQ render from template-intersection.php,
 * with the pillar intros corrected by bin/fix-wd-medmal-pillar-intros.php.
 * GSC before retirement: 66,031 impressions over 16 months, position 17.1 in
 * the last 90 days.
 *
 * Publishing is a separate step, after the legal sweep and Graeham C. Gillin's
 * sign-off, which must include §§ 15-79-125 and 15-36-100 (pending in internal-ai-scripts #69).
 * This script never publishes, never removes _roden_retired, and never sets
 * _roden_last_reviewed. Every other statute is from the signed SC pack. No
 * statistic. No hospital is named as the site of any error.
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/rebuild-charleston-medical-malpractice.php > docs/backups/charleston-medical-malpractice-before-$(date +%Y-%m-%d).json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/rebuild-charleston-medical-malpractice.php > docs/backups/charleston-medical-malpractice-before-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3644;

$p = get_post( $id );
if ( ! $p instanceof WP_Post || 'practice_area' !== $p->post_type || 'charleston-sc' !== $p->post_name ) {
    fprintf( $err, "ABORT: post %d is not the charleston-sc practice_area.\n", $id );
    exit( 1 );
}
if ( 'draft' !== $p->post_status ) {
    fprintf( $err, "ABORT: post %d is '%s'; this script only writes to the draft.\n", $id, $p->post_status );
    exit( 1 );
}
if ( 'medical-malpractice-lawyers' !== get_post_field( 'post_name', $p->post_parent ) ) {
    fprintf( $err, "ABORT: parent is not the medical malpractice pillar.\n" );
    exit( 1 );
}

$body = <<<'HTML'
<h2>Why Hire Roden Law After Medical Malpractice in Charleston</h2>
<p>Medical malpractice claims are heavily defended, and South Carolina requires specific steps before a lawsuit can even be filed. A case is won by showing, with qualified medical experts, that a provider fell below the standard of care and that it caused the harm.</p>
<ul>
<li><strong>No fee unless we win.</strong> The consultation is free, and you pay nothing up front.</li>
<li><strong>A South Carolina lawyer on your case.</strong> Your case is handled under South Carolina law by attorneys licensed here, from our office at 127 King Street.</li>
<li><strong>Expert review from the start.</strong> South Carolina requires a qualified expert's affidavit before suit, so we work with medical experts from the outset.</li>
<li><strong>Your records secured.</strong> We gather the medical records and build the timeline of what happened.</li>
</ul>

<h2>Medical Malpractice Cases We Handle</h2>
<ul>
<li><strong>Surgical errors.</strong> See <a href="/medical-malpractice-lawyers/surgical-error/">surgical error claims</a>.</li>
<li><strong>Misdiagnosis and delayed diagnosis.</strong> See <a href="/medical-malpractice-lawyers/misdiagnosis-delayed-diagnosis/">misdiagnosis claims</a> and <a href="/blog/emergency-room-errors-charleston-misdiagnosis-malpractice/">emergency room errors in Charleston</a>.</li>
<li><strong>Medication errors.</strong> See <a href="/medical-malpractice-lawyers/medication-error/">medication error claims</a>.</li>
<li><strong>Birth injuries.</strong> See <a href="/medical-malpractice-lawyers/birth-injury/">birth injury claims</a>.</li>
<li><strong>Nursing home neglect.</strong> See <a href="/practice-areas/nursing-home-abuse-lawyers/">nursing home abuse and neglect</a>.</li>
</ul>
<p>If a loved one died because of medical negligence, see <a href="/wrongful-death-lawyers/medical-malpractice-death/">medical malpractice deaths</a>. For how a claim against a hospital works, see <a href="/blog/charleston-medical-malpractice-hospital-claim-south-carolina/">filing a medical malpractice claim against a Charleston hospital</a>.</p>

<h2>South Carolina Medical Malpractice Law</h2>
<h3>Steps before a lawsuit</h3>
<p>Before a malpractice lawsuit can be filed, the patient must file a Notice of Intent to File Suit together with a qualified expert's affidavit identifying the negligent act or omission, and serve it on every provider named (<a href="https://www.scstatehouse.gov/code/t15c079.php">S.C. Code § 15-79-125</a>; S.C. Code § 15-36-100). Filing the notice pauses the filing deadline. The parties must then mediate, generally within 90 to 120 days of service. If mediation does not resolve the claim, the lawsuit can be filed.</p>
<h3>Deadlines</h3>
<p>A malpractice claim generally must be brought within three years of the treatment, or within three years of when the injury was or reasonably should have been discovered, but no more than six years after the treatment (<a href="https://www.scstatehouse.gov/code/t15c003.php">S.C. Code § 15-3-545</a>). If the provider is a government hospital or employee, the South Carolina Tort Claims Act also applies, with its own deadline and caps (S.C. Code §§ 15-78-110, 15-78-120).</p>
<h3>Damage caps</h3>
<p>South Carolina caps noneconomic damages, such as pain and suffering, in medical malpractice cases. The caps are adjusted each year; for 2026 they are $596,001 per health care provider or institution and $1,788,002 in total per claimant. They do not apply in cases of gross negligence or reckless conduct, and they do not limit economic damages such as medical costs and lost wages (S.C. Code § 15-32-220). Punitive damages must be proved by clear and convincing evidence (S.C. Code § 15-33-135).</p>
<h3>Your share of fault</h3>
<p>South Carolina uses modified comparative negligence: you can recover if you are 50% or less at fault, with your award reduced by your share (Nelson v. Concrete Supply Co.).</p>
<h3>Where the case would be filed</h3>
<p>Most Charleston County medical malpractice cases are filed in the Court of Common Pleas at the Charleston County Judicial Center, 100 Broad Street. For more on the limits, see <a href="/blog/medical-malpractice-limits-south-carolina/">medical malpractice damage caps and deadlines in South Carolina</a>.</p>
HTML;

$key_takeaways = 'Before a medical malpractice lawsuit can be filed in South Carolina, the patient must file a Notice of Intent to File Suit with a qualified expert\'s affidavit (S.C. Code §§ 15-79-125, 15-36-100), and the parties must mediate. The claim generally must be brought within three years of the treatment or of when the injury was or should have been discovered, but no more than six years after the treatment (S.C. Code § 15-3-545). Noneconomic damages are capped; for 2026 the caps are $596,001 per provider or institution and $1,788,002 in total, except in cases of gross negligence or reckless conduct (S.C. Code § 15-32-220). Roden Law\'s Charleston office at 127 King Street handles medical malpractice cases on contingency: the consultation is free and there is no fee unless we win.';

$faqs = array(
    array( 'question' => 'How long do I have to file a medical malpractice claim in South Carolina?', 'answer' => 'Generally three years from the treatment, or three years from when the injury was or reasonably should have been discovered, but no more than six years after the treatment (S.C. Code § 15-3-545). Filing a Notice of Intent to File Suit pauses the deadline (S.C. Code § 15-79-125).' ),
    array( 'question' => 'What has to happen before a malpractice lawsuit can be filed?', 'answer' => 'The patient must file a Notice of Intent to File Suit together with a qualified expert\'s affidavit identifying the negligent act or omission, and serve it on each provider named (S.C. Code §§ 15-79-125, 15-36-100). The parties then mediate, generally within 90 to 120 days. If that does not resolve the claim, the lawsuit can be filed.' ),
    array( 'question' => 'Is there a cap on medical malpractice damages in South Carolina?', 'answer' => 'Yes, on noneconomic damages. For 2026 the caps are $596,001 per health care provider or institution and $1,788,002 in total per claimant. They do not apply in cases of gross negligence or reckless conduct, and they do not limit economic damages such as medical costs and lost wages (S.C. Code § 15-32-220).' ),
    array( 'question' => 'What if the hospital or doctor is part of the government?', 'answer' => 'The South Carolina Tort Claims Act also applies. It has its own filing deadline, generally two years, and its own caps on recovery (S.C. Code §§ 15-78-110, 15-78-120), so it is important to identify early who employed the provider.' ),
    array( 'question' => 'Can I still recover if I was partly at fault?', 'answer' => 'Yes, if you were 50% or less at fault. South Carolina\'s modified comparative negligence rule (Nelson v. Concrete Supply Co.) reduces your award by your share of fault.' ),
    array( 'question' => 'How much does a Charleston medical malpractice lawyer cost?', 'answer' => 'Nothing up front. Roden Law handles medical malpractice cases on a contingency fee. The consultation is free, and there is no fee unless we win.' ),
);

$post_fields = array(
    'ID'           => $id,
    'post_title'   => 'Charleston Medical Malpractice Lawyers',
    'post_content' => $body,
    // Published as the Article description by roden_schema_article().
    'post_excerpt' => 'Harmed by medical negligence in Charleston? Roden Law\'s King Street lawyers handle South Carolina medical malpractice claims. Free consultation, no fee unless we win.',
);
$meta = array(
    '_roden_key_takeaways'    => $key_takeaways,
    '_roden_faqs'             => $faqs,
    '_roden_meta_title'       => 'Charleston Medical Malpractice Lawyer | Roden Law',
    '_roden_meta_description' => 'Harmed by medical negligence in Charleston? Roden Law\'s King Street lawyers handle South Carolina medical malpractice claims. Free consultation, no fee unless we win. (843) 790-8999.',
    '_roden_author_attorney'  => '3732', // Graeham C. Gillin, SC Bar
);

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'charleston-medical-malpractice-rebuild',
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
