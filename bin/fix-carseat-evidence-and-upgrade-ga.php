<?php
/**
 * Two linked changes, one claim class: whether a child-restraint violation can
 * be used against an injury claim.
 *
 *   ssh $H "wp --path=... eval-file -" < bin/fix-carseat-evidence-and-upgrade-ga.php
 *
 * Set RODEN_APPLY=1 in the environment to write; default is a DRY RUN.
 *
 * PART A — /resources/south-carolina-car-seat-laws/ (4813) states the law backwards.
 *
 *   S.C. Code § 56-5-6460: "A violation of this article shall not constitute
 *   negligence, per se, contributory negligence nor be admissible as evidence in
 *   any trial of any civil action or trial."
 *
 *   Evidence of a car-seat violation is inadmissible in South Carolina. The page
 *   says an insurer "may try to raise that as comparative fault" — on THREE of the
 *   four surfaces CLAUDE.md names: post_content, _roden_faqs (which also renders
 *   FAQPage structured data), and _roden_key_takeaways (the box above the article).
 *   This is the site's best-performing resource: 18,639 impressions, 138 clicks.
 *
 * PART B — /blog/georgia-car-seat-law-overview/ (1874) is a 2025 stub, and one of
 * its few legal statements is false.
 *
 *   It says a child under eight may ride in front if "properly restrained in the
 *   correct car seat or booster seat AND WEIGH AT LEAST 40 POUNDS." The 40-pound
 *   provision in O.C.G.A. § 40-8-76 is not a front-seat condition at all — it
 *   governs when a child may be secured by a LAP BELT (where the vehicle has no
 *   lap-and-shoulder belts, or all of them are already restraining other children).
 *   The front-seat exception turns on rear-seat availability and carries no weight
 *   condition. Two separate provisions welded into one false rule.
 *
 *   The page also has no <h2> at all (bold pseudo-headings), cites no statute,
 *   leads with 2008-2009 national figures framed as Georgia's, and links twice to
 *   the pre-cull flat URLs (/savannah/car-accident-lawyers/), which now resolve
 *   only through a 301.
 *
 * THE TWO-STATE CONTRAST, which is why these must ship together:
 *
 *   SC § 56-5-6460     not negligence per se, not contributory negligence,
 *                      AND not admissible in any civil action
 *   GA § 40-8-76(c)    "shall not constitute negligence per se nor contributory
 *                      negligence per se" — no admissibility bar
 *
 *   Fixing only one would leave two linked pages contradicting each other.
 *
 * NOT CONFLATED: SB 68 (2025) amended § 40-8-76.1 — SAFETY BELTS, age 8+ — not
 * § 40-8-76, child restraints. Different section, different rule. bin/en-fix-
 * seatbelt-defense-sb68.php handles the belt statute; this script does not touch it.
 *
 * Sources verified 2026-08-31: FindLaw (GA § 40-8-76, quoting subsections (b)(1),
 * (b)(2) and (c)); scstatehouse.gov / Justia (SC § 56-5-6460).
 *
 * HOW IT EDITS. Exact-match str_replace only, never preg_replace — a "$" in a
 * preg_replace replacement has silently eaten content on this site before. Every
 * edit asserts its search string occurs EXACTLY once, and verifies afterwards that
 * the new text is present and the old text is gone. Any failure aborts that edit
 * without touching the others. Idempotent: already-corrected text is skipped.
 */

$APPLY = (bool) getenv( 'RODEN_APPLY' );
echo $APPLY ? "=== APPLY MODE ===\n\n" : "=== DRY RUN (set RODEN_APPLY=1 to write) ===\n\n";

$backups = array();
$failed  = 0;

/** Replace exactly one occurrence, or report why not. */
function roden_edit( $haystack, $search, $replace, $label, &$failed ) {
    if ( false !== strpos( $haystack, $replace ) ) {
        echo "  SKIP (already applied): $label\n";
        return $haystack;
    }
    $n = substr_count( $haystack, $search );
    if ( 1 !== $n ) {
        echo "  FAIL ($n occurrences, expected 1): $label\n";
        $failed++;
        return $haystack;
    }
    echo "  ok: $label\n";
    return str_replace( $search, $replace, $haystack );
}

/* ---------------------------------------------------------------------------
 * PART A — South Carolina resource (4813)
 * ------------------------------------------------------------------------- */

$sc = get_post( 4813 );
if ( ! $sc || 'south-carolina-car-seat-laws' !== $sc->post_name ) {
    echo "ABORT: post 4813 is not the SC car seat resource\n";
    return;
}
echo "PART A — {$sc->post_title} (" . get_permalink( 4813 ) . ")\n";

$backups[4813] = array(
    'post_content'         => $sc->post_content,
    '_roden_faqs'          => get_post_meta( 4813, '_roden_faqs', true ),
    '_roden_key_takeaways' => get_post_meta( 4813, '_roden_key_takeaways', true ),
);

$sc_body_old = 'Beyond safety, child-restraint compliance can affect a personal injury claim. If a child is injured in a crash and was not properly restrained, the at-fault driver&rsquo;s insurer may try to raise that as <strong>comparative fault</strong> to reduce what they owe &mdash; arguing the lack of a proper seat contributed to the injuries. South Carolina&rsquo;s modified comparative negligence rule means how fault is divided has a direct effect on recovery. Properly restraining your child protects the child first and foremost, and also removes an argument the insurance company would otherwise use against your claim.';

$sc_body_new = 'Parents often ask whether a car-seat problem can be used against their child&rsquo;s claim. In South Carolina it cannot. <strong>S.C. Code &sect; 56-5-6460</strong> provides that a violation of the child-restraint article &ldquo;shall not constitute negligence, per se, contributory negligence nor be admissible as evidence in any trial of any civil action or trial.&rdquo; An at-fault driver&rsquo;s insurer cannot introduce a car-seat violation to argue comparative fault or to reduce what it owes your child. <strong>Georgia&rsquo;s rule is different</strong>: <strong>O.C.G.A. &sect; 40-8-76(c)</strong> provides only that a violation &ldquo;shall not constitute negligence per se nor contributory negligence per se,&rdquo; and contains no equivalent bar on admissibility. Restraining your child correctly is first and foremost about keeping them safe.';

$sc_content = roden_edit( $sc->post_content, $sc_body_old, $sc_body_new, 'SC body paragraph', $failed );

$sc_kt_old = 'Following the law protects your child and also protects an injury claim, because failing to restrain a child can be raised as comparative fault.';
$sc_kt_new = 'Following the law protects your child, and a violation cannot be used against a claim: S.C. Code &sect; 56-5-6460 makes a child-restraint violation inadmissible as evidence in any civil action. Georgia differs &mdash; O.C.G.A. &sect; 40-8-76(c) says only that a violation is not negligence per se or contributory negligence per se.';

$sc_kt = roden_edit( (string) $backups[4813]['_roden_key_takeaways'], $sc_kt_old, $sc_kt_new, 'SC key takeaways', $failed );

$sc_faq_old = 'It can. If a child was not properly restrained, the at-fault driver\'s insurer may argue comparative fault to reduce what they owe, claiming the lack of a proper seat contributed to the injuries. South Carolina\'s modified comparative negligence rule means how fault is divided affects recovery, so properly restraining your child both keeps them safer and removes an argument insurers use against claims.';
$sc_faq_new = 'No. S.C. Code § 56-5-6460 provides that a violation of South Carolina\'s child-restraint article "shall not constitute negligence, per se, contributory negligence nor be admissible as evidence in any trial of any civil action or trial." The at-fault driver\'s insurer cannot use a car-seat violation to argue comparative fault or to reduce your child\'s recovery. Georgia\'s law differs: O.C.G.A. § 40-8-76(c) provides only that a violation is not negligence per se or contributory negligence per se, with no equivalent bar on admissibility.';

$faqs_raw = $backups[4813]['_roden_faqs'];
$faqs     = maybe_unserialize( $faqs_raw );
if ( is_string( $faqs ) ) {
    $decoded = json_decode( $faqs, true );
    if ( is_array( $decoded ) ) {
        $faqs = $decoded;
    }
}
$faq_hits = 0;
if ( is_array( $faqs ) ) {
    foreach ( $faqs as $i => $q ) {
        if ( is_array( $q ) && isset( $q['answer'] ) && trim( $q['answer'] ) === trim( $sc_faq_old ) ) {
            $faqs[ $i ]['answer'] = $sc_faq_new;
            $faq_hits++;
        }
    }
}
if ( 1 === $faq_hits ) {
    echo "  ok: SC FAQ answer\n";
} elseif ( is_array( $faqs ) && false !== strpos( wp_json_encode( $faqs ), 'not admissible as evidence in any trial' ) ) {
    echo "  SKIP (already applied): SC FAQ answer\n";
} else {
    echo "  FAIL ($faq_hits matches, expected 1): SC FAQ answer\n";
    $failed++;
}

/* ---------------------------------------------------------------------------
 * PART B — Georgia blog post (1874), full upgrade in place. URL unchanged.
 * ------------------------------------------------------------------------- */

$ga = get_post( 1874 );
if ( ! $ga || 'georgia-car-seat-law-overview' !== $ga->post_name ) {
    echo "ABORT: post 1874 is not the GA car seat post\n";
    return;
}
echo "\nPART B — {$ga->post_title} (" . get_permalink( 1874 ) . ")\n";

$backups[1874] = array(
    'post_title'   => $ga->post_title,
    'post_excerpt' => $ga->post_excerpt,
    'post_content' => $ga->post_content,
    'custom_h1_title' => get_post_meta( 1874, 'custom_h1_title', true ),
);

$ga_title   = 'Georgia Car Seat and Booster Seat Laws';
$ga_excerpt = 'Georgia requires a child restraint for every child under 8 (O.C.G.A. § 40-8-76), in a rear seat, with narrow exceptions. Reviewed by a Georgia attorney.';

$ga_kt = 'Georgia law (O.C.G.A. &sect; 40-8-76) requires every child under eight years old to be restrained in a child passenger restraining system appropriate for the child&rsquo;s height and weight, in a rear seat. A child may ride in front only if the vehicle has no rear seating position appropriate for restraining a child, or all appropriate rear positions are already occupied by other children &mdash; there is no weight condition for riding in front. A child taller than 4 feet 9 inches is restrained by a safety belt instead, under O.C.G.A. &sect; 40-8-76.1. A violation carries a fine of up to $50 for a first conviction and up to $100 for a second or subsequent conviction. Under &sect; 40-8-76(c) a violation is not negligence per se nor contributory negligence per se.';

$ga_faqs = array(
    array(
        'question' => 'What are the car seat laws in Georgia?',
        'answer'   => 'O.C.G.A. § 40-8-76 requires every driver transporting a child under eight years of age in a passenger automobile, van or pickup truck to provide for the proper restraint of that child in a child passenger restraining system appropriate for the child\'s height and weight and approved by the U.S. Department of Transportation under Federal Motor Vehicle Safety Standard 213. The child must be restrained in a rear seat, with narrow exceptions. A child whose height is over 4 feet 9 inches is instead restrained by a safety belt under O.C.G.A. § 40-8-76.1.',
    ),
    array(
        'question' => 'Does my child have to ride in the back seat in Georgia?',
        'answer'   => 'Generally yes. O.C.G.A. § 40-8-76 requires a child under eight to be properly restrained in a rear seat. The statute allows a child to be restrained in a front seat only if the vehicle has no rear seating position appropriate for correctly restraining a child, or all appropriate rear seating positions are occupied by other children. There is no weight threshold that permits front-seat riding.',
    ),
    array(
        'question' => 'What is the 40-pound rule in Georgia\'s car seat law?',
        'answer'   => 'It is often misstated as a front-seat rule. It is not. Under O.C.G.A. § 40-8-76, a child weighing at least 40 pounds may be secured by a lap belt only when the vehicle is not equipped with both lap and shoulder belts, or when every lap-and-shoulder belt other than the driver\'s is already being used to properly restrain other children. It governs which belt may be used, not where the child may sit.',
    ),
    array(
        'question' => 'What is the fine for a car seat violation in Georgia?',
        'answer'   => 'Under O.C.G.A. § 40-8-76, a first conviction carries a fine of not more than $50.00, and a second or subsequent conviction a fine of not more than $100.00. The statute provides that no court shall impose additional fees or surcharges on such a fine.',
    ),
    array(
        'question' => 'Can a car seat violation be used against my child\'s injury claim in Georgia?',
        'answer'   => 'O.C.G.A. § 40-8-76(c) provides that a violation "shall not constitute negligence per se nor contributory negligence per se," so a violation does not by itself establish fault. Georgia\'s statute does not contain the broader evidentiary bar South Carolina\'s does. South Carolina is the stronger rule for families: under S.C. Code § 56-5-6460 a child-restraint violation is not admissible as evidence in any civil action at all. If your child was hurt in a crash, a Georgia attorney can explain how this applies to your case.',
    ),
);

$ga_content = <<<'HTML'
<p>Georgia requires every child under eight years old to ride in a child passenger restraining system suited to the child&rsquo;s height and weight, secured in a rear seat. The requirement is set out in <strong>O.C.G.A. &sect; 40-8-76</strong>, and the restraint must be approved by the U.S. Department of Transportation under Federal Motor Vehicle Safety Standard 213. Once a child&rsquo;s height is over 4 feet 9 inches, the child is restrained by a safety belt instead, under <strong>O.C.G.A. &sect; 40-8-76.1</strong>.</p>

<p>This guide explains Georgia&rsquo;s child-restraint rules in plain language, the exceptions that actually exist in the statute, what a violation costs, and how a car-seat issue is treated if your child is injured in a crash &mdash; where Georgia and South Carolina differ sharply.</p>

<h2>What are the car seat laws in Georgia?</h2>
<p>O.C.G.A. &sect; 40-8-76 requires every driver transporting a child under eight years of age in a passenger automobile, van or pickup truck to provide for that child&rsquo;s proper restraint while the vehicle is in motion on a public road. Two points do most of the work:</p>
<ul>
<li><strong>The restraint must fit the child</strong> &mdash; the statute ties the requirement to the child&rsquo;s <em>height and weight</em>, not to a birthday. Follow the height and weight limits printed on your specific seat by its manufacturer.</li>
<li><strong>The restraint must be federally approved</strong> &mdash; the seat must meet Federal Motor Vehicle Safety Standard 213.</li>
</ul>
<p>Georgia&rsquo;s statute does not divide childhood into named stages the way some states do. It sets one requirement for children under eight, a rear-seat rule, and a height-based off-ramp at 4 feet 9 inches.</p>

<h2>Does my child have to ride in the back seat in Georgia?</h2>
<p>Generally yes. The statute requires that a child under eight &ldquo;shall be properly restrained in a rear seat of the motor vehicle.&rdquo; There are exactly two exceptions, and both are about seating availability:</p>
<ul>
<li>the vehicle has <strong>no rear seating position appropriate</strong> for correctly restraining a child, or</li>
<li><strong>all appropriate rear seating positions are occupied</strong> by other children.</li>
</ul>
<p><strong>There is no weight threshold that lets a child ride in front.</strong> This is the most commonly misstated part of Georgia&rsquo;s law, and it comes from confusing the rear-seat exceptions with a separate provision about lap belts, explained next.</p>

<h2>What the 40-pound provision actually says</h2>
<p>O.C.G.A. &sect; 40-8-76 does contain a 40-pound rule, but it governs <em>which belt</em> may restrain a child, not <em>where the child may sit</em>. A child weighing at least 40 pounds may be secured by a lap belt when:</p>
<ul>
<li>the vehicle is <strong>not equipped with both lap and shoulder belts</strong>; or</li>
<li>not counting the driver&rsquo;s seat, every lap-and-shoulder belt in the vehicle is <strong>already being used to properly restrain other children</strong>.</li>
</ul>
<p>Read as a front-seat permission slip, this provision becomes a false statement of Georgia law. It is a fallback for vehicles whose belts cannot accommodate every child.</p>

<h2>When can my child stop using a child restraint?</h2>
<p>Georgia gives two paths out of the child-restraint requirement:</p>
<ul>
<li><strong>Age</strong> &mdash; the requirement in &sect; 40-8-76 applies to children <strong>under eight</strong>. At eight, the child is covered by the safety-belt requirement in &sect; 40-8-76.1 instead.</li>
<li><strong>Height</strong> &mdash; if a parent or guardian can show the child&rsquo;s height is <strong>over 4 feet 9 inches</strong>, the child is restrained by a safety belt under &sect; 40-8-76.1 rather than a child restraint.</li>
</ul>
<p>Meeting the legal minimum and being safely restrained are not the same thing. Safety guidance from the National Highway Traffic Safety Administration is to keep a child in each stage &mdash; rear-facing, then forward-facing harness, then booster &mdash; until they reach the seat&rsquo;s upper height or weight limit, and to keep children under 13 in the back seat. A booster still belongs in the picture for many children who are legally past the restraint requirement but whose adult belt does not yet fit: the lap belt should sit low across the hips rather than the stomach, and the shoulder belt across the centre of the chest rather than the neck.</p>

<h2>What is the penalty for a car seat violation in Georgia?</h2>
<p>Under O.C.G.A. &sect; 40-8-76, a <strong>first conviction</strong> carries a fine of <strong>not more than $50.00</strong>, and a <strong>second or subsequent conviction</strong> a fine of <strong>not more than $100.00</strong>. The statute provides that no court shall impose additional fees or surcharges on such a fine.</p>

<h2>Can a car seat violation be used against my child&rsquo;s injury claim?</h2>
<p>This is where Georgia and South Carolina part company, and the difference matters to any family that drives between the two.</p>
<table class="comparison-table">
<thead>
<tr><th>&nbsp;</th><th>Georgia</th><th>South Carolina</th></tr>
</thead>
<tbody>
<tr><td>Statute</td><td>O.C.G.A. &sect; 40-8-76(c)</td><td>S.C. Code &sect; 56-5-6460</td></tr>
<tr><td>Negligence per se?</td><td>No</td><td>No</td></tr>
<tr><td>Contributory negligence?</td><td>Not <em>per se</em></td><td>No</td></tr>
<tr><td>Admissible in a civil action?</td><td>No statutory bar</td><td><strong>Not admissible at all</strong></td></tr>
</tbody>
</table>
<p>Georgia&rsquo;s provision states that a violation &ldquo;shall not constitute negligence per se nor contributory negligence per se.&rdquo; That means a violation does not by itself establish fault &mdash; but &sect; 40-8-76 contains no provision barring the evidence outright.</p>
<p>South Carolina goes considerably further. Under <strong>S.C. Code &sect; 56-5-6460</strong>, a violation of the child-restraint article &ldquo;shall not constitute negligence, per se, contributory negligence nor be admissible as evidence in any trial of any civil action or trial.&rdquo; See our guide to <a href="/resources/south-carolina-car-seat-laws/">South Carolina car seat and booster seat laws</a> for how that works.</p>
<p>One distinction worth keeping straight: Georgia&rsquo;s <strong>seat-belt</strong> statute, &sect; 40-8-76.1, is a different section with a different history &mdash; Senate Bill 68 changed its evidentiary rule in 2025. That change applies to safety belts, not to the child-restraint requirement in &sect; 40-8-76.</p>

<h2>Get help after a Georgia crash involving your child</h2>
<p>A crash that injures your child is every parent&rsquo;s worst moment. If another driver was at fault, you should not have to face the medical bills and the insurance company alone. Roden Law&rsquo;s Georgia attorneys can investigate the crash, deal with the insurers, and pursue full compensation for your child&rsquo;s injuries.</p>
<p>For related reading, see our <a href="/car-accident-lawyers/savannah-ga/">Savannah car accident lawyers</a> page and our <a href="/practice-areas/car-accident-lawyers/">car accident practice area</a>. You can <a href="/contact/">contact Roden Law</a> for a free consultation or call <a href="tel:+18447378587">1-844-RESULTS</a>.</p>
HTML;

echo "  title   : {$backups[1874]['post_title']}  ->  $ga_title\n";
echo "  excerpt : " . ( $backups[1874]['post_excerpt'] ?: '(EMPTY)' ) . "  ->  " . substr( $ga_excerpt, 0, 60 ) . "...\n";
echo "  words   : " . str_word_count( wp_strip_all_tags( $backups[1874]['post_content'] ) )
   . "  ->  " . str_word_count( wp_strip_all_tags( $ga_content ) ) . "\n";
echo "  h2 count: " . substr_count( $backups[1874]['post_content'], '<h2' ) . "  ->  " . substr_count( $ga_content, '<h2' ) . "\n";
echo "  301 links removed: " . ( substr_count( $backups[1874]['post_content'], 'rodenlaw.com/savannah/' ) + substr_count( $backups[1874]['post_content'], '/contact-us/' ) ) . "\n";
echo "  faqs    : " . count( $ga_faqs ) . " (was none)\n";

/* ---------------------------------------------------------------------------
 * Write
 * ------------------------------------------------------------------------- */

if ( $failed ) {
    echo "\n$failed edit(s) failed their exact-match assertion. NOTHING WRITTEN.\n";
    return;
}

echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\n";

if ( ! $APPLY ) {
    echo "\nDry run complete. All assertions passed. Re-run with RODEN_APPLY=1 to write.\n";
    return;
}

$today = current_time( 'Y-m-d' );

wp_update_post( array( 'ID' => 4813, 'post_content' => $sc_content ), true );
update_post_meta( 4813, '_roden_key_takeaways', $sc_kt );
update_post_meta( 4813, '_roden_faqs', $faqs );
update_post_meta( 4813, '_roden_last_reviewed', $today );

wp_update_post( array(
    'ID'           => 1874,
    'post_title'   => $ga_title,
    'post_excerpt' => $ga_excerpt,
    'post_content' => $ga_content,
), true );
update_post_meta( 1874, 'custom_h1_title', $ga_title );
update_post_meta( 1874, '_roden_meta_description', $ga_excerpt );
update_post_meta( 1874, '_roden_key_takeaways', $ga_kt );
update_post_meta( 1874, '_roden_faqs', $ga_faqs );
update_post_meta( 1874, '_roden_jurisdiction', 'ga' );
update_post_meta( 1874, '_roden_last_reviewed', $today );

clean_post_cache( 4813 );
clean_post_cache( 1874 );

echo "\n--- VERIFY ---\n";
$a = get_post( 4813 );
echo "4813 body has new SC rule : " . ( false !== strpos( $a->post_content, '56-5-6460' ) ? 'yes' : 'NO' ) . "\n";
echo "4813 old claim gone       : " . ( false === strpos( $a->post_content, 'may try to raise that as' ) ? 'yes' : 'NO' ) . "\n";
echo "4813 takeaways corrected  : " . ( false !== strpos( (string) get_post_meta( 4813, '_roden_key_takeaways', true ), '56-5-6460' ) ? 'yes' : 'NO' ) . "\n";
echo "4813 faq corrected        : " . ( false !== strpos( wp_json_encode( get_post_meta( 4813, '_roden_faqs', true ) ), '56-5-6460' ) ? 'yes' : 'NO' ) . "\n";
$b = get_post( 1874 );
echo "1874 title                : {$b->post_title}\n";
echo "1874 slug UNCHANGED       : " . ( 'georgia-car-seat-law-overview' === $b->post_name ? 'yes' : 'NO' ) . "\n";
echo "1874 cites 40-8-76        : " . ( false !== strpos( $b->post_content, '40-8-76' ) ? 'yes' : 'NO' ) . "\n";
echo "1874 false 40lb rule gone : " . ( false === strpos( $b->post_content, 'weigh at least 40 pounds' ) ? 'yes' : 'NO' ) . "\n";
echo "1874 301 links gone       : " . ( false === strpos( $b->post_content, 'rodenlaw.com/savannah/' ) ? 'yes' : 'NO' ) . "\n";
echo "\nDone.\n";
