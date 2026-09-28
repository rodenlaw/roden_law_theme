<?php
/**
 * Write the rebuilt Charleston wrongful death page into post 3649, KEEPING IT A DRAFT.
 * Wave 1, #10 of docs/site-architecture/README.md (owner: "fix those FAQs and
 * then do the last wave 1 pages", 2026-09-28). South Carolina only; the map, NAP
 * bar, law box, steps, results and FAQ render from template-intersection.php,
 * with the pillar intros corrected by bin/fix-wd-medmal-pillar-intros.php.
 * GSC before retirement: 60,291 impressions over 16 months, position 16.8 in
 * the last 90 days.
 *
 * Publishing is a separate step, after the legal sweep and Graeham C. Gillin's
 * sign-off, which must include §§ 15-51-10, 15-51-40, 15-5-90 and 15-79-125 (pending in internal-ai-scripts #69).
 * This script never publishes, never removes _roden_retired, and never sets
 * _roden_last_reviewed. Every other statute is from the signed SC pack. No
 * statistic. No hospital is named as the site of any error.
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/rebuild-charleston-wrongful-death.php > docs/backups/charleston-wrongful-death-before-$(date +%Y-%m-%d).json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/rebuild-charleston-wrongful-death.php > docs/backups/charleston-wrongful-death-before-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3649;

$p = get_post( $id );
if ( ! $p instanceof WP_Post || 'practice_area' !== $p->post_type || 'charleston-sc' !== $p->post_name ) {
    fprintf( $err, "ABORT: post %d is not the charleston-sc practice_area.\n", $id );
    exit( 1 );
}
if ( 'draft' !== $p->post_status ) {
    fprintf( $err, "ABORT: post %d is '%s'; this script only writes to the draft.\n", $id, $p->post_status );
    exit( 1 );
}
if ( 'wrongful-death-lawyers' !== get_post_field( 'post_name', $p->post_parent ) ) {
    fprintf( $err, "ABORT: parent is not the wrongful death pillar.\n" );
    exit( 1 );
}

$body = <<<'HTML'
<h2>Why Families Choose Roden Law After a Death in Charleston</h2>
<p>Losing someone because of another person's carelessness is devastating, and a wrongful death claim should not add to the burden. We handle the legal work, including helping the estate's personal representative bring the claim, so the family can focus on each other.</p>
<ul>
<li><strong>No fee unless we win.</strong> The consultation is free, and the family pays nothing up front.</li>
<li><strong>A South Carolina lawyer on the case.</strong> The claim is handled under South Carolina law by attorneys licensed here, from our office at 127 King Street.</li>
<li><strong>A full investigation.</strong> Crash reports, video, medical records and witness accounts, gathered before they are lost.</li>
<li><strong>Both claims pursued together.</strong> The wrongful death action for the family and the survival action for the person's own claim.</li>
</ul>

<h2>Deaths We See in Charleston Cases</h2>
<p>A wrongful death claim can arise from any fatal injury caused by someone else's negligence, including:</p>
<ul>
<li><strong>Fatal crashes</strong> on I-26, I-526, US-17 and the peninsula's streets. See our <a href="/car-accident-lawyers/charleston-sc/">Charleston car accident</a>, <a href="/truck-accident-lawyers/charleston-sc/">truck accident</a> and <a href="/motorcycle-accident-lawyers/charleston-sc/">motorcycle accident</a> lawyers.</li>
<li><strong>Deaths caused by medical negligence.</strong> See <a href="/wrongful-death-lawyers/medical-malpractice-death/">medical malpractice deaths</a>.</li>
<li><strong>Deaths in nursing homes.</strong> See <a href="/wrongful-death-lawyers/nursing-home-wrongful-death/">nursing home wrongful death</a>.</li>
<li><strong>Crashes involving a government vehicle.</strong> See <a href="/car-accident-lawyers/government-vehicle-accident/">government vehicle accidents</a>.</li>
</ul>

<h2>South Carolina Wrongful Death Law</h2>
<h3>Who brings the claim</h3>
<p>When a death is caused by someone else's wrongful act or negligence, the person responsible can be sued just as if the injured person had lived (S.C. Code § 15-51-10). The claim is brought by the estate's personal representative, the executor or administrator, for the benefit of the spouse and children; if there are none, the parents; and if there are none, the heirs (<a href="https://www.scstatehouse.gov/code/t15c051.php">S.C. Code § 15-51-20</a>).</p>
<h3>Two claims: wrongful death and survival</h3>
<p>The wrongful death action compensates the family for the loss the death caused them. Separately, the person's own claim for their injuries survives their death and can be brought by the estate (S.C. Code § 15-5-90). The two are usually pursued together.</p>
<h3>Damages</h3>
<p>The jury awards damages in proportion to the loss the death caused each family member, and may add punitive damages when the conduct was reckless, wilful or malicious. The recovery is divided among the family as it would be under the intestacy rules (S.C. Code § 15-51-40). Punitive damages must be proved by clear and convincing evidence (S.C. Code § 15-33-135).</p>
<h3>Deadlines</h3>
<p>A wrongful death lawsuit generally must be filed within three years (S.C. Code § 15-3-530). If a government entity is responsible, the South Carolina Tort Claims Act applies: suit must be filed within two years, or three years if a verified claim is filed with the agency within one year, and recovery is capped at $300,000 per person and $600,000 per occurrence (<a href="https://www.scstatehouse.gov/code/t15c078.php">S.C. Code §§ 15-78-110, 15-78-80, 15-78-120</a>). If the death was caused by medical malpractice, a Notice of Intent and a qualified expert\'s affidavit must be filed before suit (S.C. Code §§ 15-79-125, 15-36-100), the deadline may run from the treatment rather than the death, with a six-year outer limit (S.C. Code § 15-3-545), and noneconomic damages are generally capped (S.C. Code § 15-32-220).</p>
<h3>Where the case would be filed</h3>
<p>Most Charleston County wrongful death lawsuits are filed in the Court of Common Pleas at the Charleston County Judicial Center, 100 Broad Street. For more, see our <a href="/south-carolina-wrongful-death-lawyer/">South Carolina wrongful death lawyers</a> and <a href="/resources/south-carolina-wrongful-death-settlement-value/">what a South Carolina wrongful death case is worth</a>.</p>
HTML;

$key_takeaways = 'In South Carolina, a wrongful death claim is brought by the estate\'s personal representative for the benefit of the spouse and children, or if there are none, the parents, or if none, the heirs (S.C. Code § 15-51-20). It generally must be filed within three years (S.C. Code § 15-3-530), or within two years if a government entity is responsible, three if a verified claim is filed with the agency within one year (S.C. Code §§ 15-78-110, 15-78-80). A separate survival action lets the estate pursue the person\'s own claim (S.C. Code § 15-5-90), and punitive damages are possible when the conduct was reckless, wilful or malicious (S.C. Code § 15-51-40). Roden Law\'s Charleston office at 127 King Street handles wrongful death cases on contingency: the consultation is free and there is no fee unless we win.';

$faqs = array(
    array( 'question' => 'Who can file a wrongful death claim in South Carolina?', 'answer' => 'The estate\'s personal representative, the executor or administrator, files it. The claim is for the benefit of the spouse and children; if there are none, the parents; and if there are none, the heirs (S.C. Code § 15-51-20).' ),
    array( 'question' => 'How long do we have to file a wrongful death claim in South Carolina?', 'answer' => 'Generally three years (S.C. Code § 15-3-530). If a government entity is responsible, suit must be filed within two years, or three years if a verified claim is filed with the agency within one year (S.C. Code §§ 15-78-110, 15-78-80). Talk to a lawyer early, because the estate may need to be opened first.' ),
    array( 'question' => 'What is the difference between a wrongful death and a survival action?', 'answer' => 'The wrongful death action compensates the family for the loss the death caused them (S.C. Code §§ 15-51-10, 15-51-40). The survival action is the person\'s own claim for their injuries, which survives their death and is brought by the estate (S.C. Code § 15-5-90).' ),
    array( 'question' => 'Is there a cap on wrongful death damages in South Carolina?', 'answer' => 'There is no cap on the family\'s compensatory damages in an ordinary case, but there are important exceptions. Claims against a government entity are capped at $300,000 per person and $600,000 per occurrence (S.C. Code § 15-78-120), and claims against a charitable organization, which can include a nonprofit hospital or nursing home, are limited to the same amounts (S.C. Code § 33-56-180). Noneconomic damages in a death caused by medical malpractice are generally capped (S.C. Code § 15-32-220). Punitive damages are generally capped at the greater of three times the compensatory damages or $739,245 in 2026, a figure adjusted each year (S.C. Code § 15-32-530).' ),
    array( 'question' => 'Are punitive damages available in a wrongful death case?', 'answer' => 'They can be, when the death was the result of recklessness, wilfulness or malice (S.C. Code § 15-51-40). They must be proved by clear and convincing evidence (S.C. Code § 15-33-135), are generally capped (S.C. Code § 15-32-530), and are not available against a government entity (S.C. Code § 15-78-120).' ),
    array( 'question' => 'How much does a Charleston wrongful death lawyer cost?', 'answer' => 'Nothing up front. Roden Law handles wrongful death cases on a contingency fee. The consultation is free, and there is no fee unless we win.' ),
);

$post_fields = array(
    'ID'           => $id,
    'post_title'   => 'Charleston Wrongful Death Lawyers',
    'post_content' => $body,
    // Published as the Article description by roden_schema_article().
    'post_excerpt' => 'Lost a loved one to someone else\'s negligence in Charleston? Roden Law\'s King Street lawyers handle South Carolina wrongful death claims. Free consultation, no fee unless we win.',
);
$meta = array(
    '_roden_key_takeaways'    => $key_takeaways,
    '_roden_faqs'             => $faqs,
    '_roden_meta_title'       => 'Charleston Wrongful Death Lawyer | Roden Law',
    '_roden_meta_description' => 'Lost a loved one to negligence in Charleston? Roden Law\'s King Street lawyers handle South Carolina wrongful death claims. Free consultation, no fee unless we win. (843) 790-8999.',
    '_roden_author_attorney'  => '3732', // Graeham C. Gillin, SC Bar
);

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'charleston-wrongful-death-rebuild',
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
