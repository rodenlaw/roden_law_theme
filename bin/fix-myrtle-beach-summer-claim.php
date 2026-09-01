<?php
/**
 * Correct the disproven summer-seasonality claim on
 * /blog/myrtle-beach-dangerous-roads-intersections/ (post 4537).
 *
 *   ssh $H "wp --path=... eval-file -"        < bin/fix-myrtle-beach-summer-claim.php
 *   ssh $H "wp --path=... eval-file - apply"  < bin/fix-myrtle-beach-summer-claim.php
 *
 * WHAT WAS WRONG. The page carries a section headed "Seasonal Risks: Why Summer
 * Is the Deadliest Time" and states that "the period from Memorial Day through
 * Labor Day is the most dangerous time to drive in the Myrtle Beach area."
 *
 * The federal fatal-crash record says the opposite. NHTSA FARS 2020-2024, Horry
 * County (STATE 45, COUNTY 51):
 *
 *     June-August share of fatal crashes   22.6%   (74 of 328)
 *     South Carolina, same months          26.1%
 *     even spread across the year          25.0%
 *
 * Summer is slightly BELOW average on the Grand Strand, and below the state's own
 * summer share. Worst months: October (40), May (36), December (34).
 *
 * The claim appeared on THREE surfaces — post_content, _roden_faqs (which also
 * renders FAQPage structured data) and _roden_key_takeaways. All three are
 * corrected here; that is the CLAUDE.md rule, and this page is the reason it
 * exists.
 *
 * WHAT IS DELIBERATELY LEFT ALONE. The page also asserts intersection crash
 * counts ("65% more car accidents than the second-most hazardous", "70 crashes in
 * a three-year period", "49 crashes documented") and a 20-million visitor figure.
 * FARS is FATAL crashes only and cannot evaluate total-crash rankings, so these
 * are unsourced but NOT disproven. Removing claims that merely lack a citation is
 * how commit 7656f24 came to restore three claims it had wrongly stripped. They
 * stay; they need a source, not a deletion.
 *
 * The U.S. 17 claim is narrowed rather than removed: "South Carolina's most
 * dangerous highway for summertime travel" is an unverifiable ranking with a
 * seasonal qualifier this data undercuts, but US-17 genuinely does carry more
 * fatal crashes than any other Horry County route (39, against 23 on US-501), so
 * the checkable version of the claim replaces the uncheckable one.
 *
 * SOURCED TO FARS DIRECTLY, not to the new report. /resources/myrtle-beach-fatal-
 * crashes/ (post 5398) is still a DRAFT pending attorney review, and linking a
 * live page to an unpublished URL would be a broken link. Add the internal link
 * when that report publishes.
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (pass 'apply' to write) ===\n\n";

$id   = 4537;
$post = get_post( $id );
if ( ! $post || 'myrtle-beach-dangerous-roads-intersections' !== $post->post_name ) {
    echo "ABORT: post $id is not the Myrtle Beach roads post\n";
    return;
}

$failed  = 0;
$content = $post->post_content;

function roden_edit( $hay, $search, $replace, $label, &$failed ) {
    if ( false !== strpos( $hay, $replace ) ) {
        echo "  SKIP (already applied): $label\n";
        return $hay;
    }
    $n = substr_count( $hay, $search );
    if ( 1 !== $n ) {
        echo "  FAIL ($n occurrences, expected 1): $label\n";
        $failed++;
        return $hay;
    }
    echo "  ok: $label\n";
    return str_replace( $search, $replace, $hay );
}

/* ---- 1. table of contents ---- */
$content = roden_edit( $content,
    '<li><a href="#seasonal-risks">Seasonal Risks: Why Summer Is the Deadliest Time</a></li>',
    '<li><a href="#seasonal-risks">Seasonal Risk: What the Fatal-Crash Record Shows</a></li>',
    'TOC entry', $failed );

/* ---- 2. heading + the disproven paragraph ---- */
$old_sec = '<h2 id="seasonal-risks">Seasonal Risks: Why Summer Is the Deadliest Time</h2>

<p>Crash data consistently shows that the period from Memorial Day through Labor Day is the most dangerous time to drive in the Myrtle Beach area. The combination of peak tourist traffic, increased pedestrian activity, higher rates of impaired driving, and more motorcycles and bicycles on the road creates conditions where serious crashes spike dramatically.</p>';

$new_sec = '<h2 id="seasonal-risks">Seasonal Risk: What the Fatal-Crash Record Shows</h2>

<p>Summer is the intuitive answer, and the federal fatal-crash record does not support it. Between 2020 and 2024, <strong>22.6% of Horry County\'s fatal crashes happened in June, July and August</strong> — below the 25% an even spread across the year would produce, and below South Carolina\'s own summer share of 26.1%. The worst months were October, May and December. <em>Source: NHTSA Fatality Analysis Reporting System, 2020–2024.</em></p>

<p>That does not make summer traffic harmless. Peak season brings far more vehicles, unfamiliar drivers, pedestrians and motorcycles, and it produces more crashes overall. What it does not produce is a disproportionate share of the fatal ones — those are spread across the calendar. Any claim of a summer fatality peak needs a source measuring something other than deaths.</p>';

$content = roden_edit( $content, $old_sec, $new_sec, 'heading + disproven paragraph', $failed );

/* ---- 3. the follow-on paragraph now reads oddly ---- */
$content = roden_edit( $content,
    '<p>But risk is not limited to summer. The spring and fall',
    '<p>Risk is spread across the year in other ways too. The spring and fall',
    'follow-on paragraph opener', $failed );

/* ---- 4. US-17: unverifiable ranking -> checkable count ---- */
$content = roden_edit( $content,
    '<p>U.S. 17 is ranked as <strong>South Carolina\'s most dangerous highway for summertime travel</strong>. Running',
    '<p>U.S. 17 carries more fatal crashes than any other route in Horry County — <strong>39 between 2020 and 2024</strong>, against 23 on U.S. 501, according to federal crash records. Running',
    'US-17 ranking claim', $failed );

/* ---- 5. FAQs ---- */
$faqs = maybe_unserialize( get_post_meta( $id, '_roden_faqs', true ) );
if ( is_string( $faqs ) ) {
    $d = json_decode( $faqs, true );
    if ( is_array( $d ) ) { $faqs = $d; }
}
$faq_edits = 0;
foreach ( (array) $faqs as $k => $q ) {
    if ( ! is_array( $q ) ) { continue; }

    if ( isset( $q['answer'] ) && false !== strpos( $q['answer'], "most dangerous highway for summertime travel" ) ) {
        $faqs[ $k ]['answer'] = 'U.S. 17 (Kings Highway) carries more fatal crashes than any other route in Horry County — 39 between 2020 and 2024, against 23 on U.S. 501, according to NHTSA federal crash data. Running through the heart of Myrtle Beach and the entire Grand Strand, it combines heavy tourist traffic, hundreds of commercial intersections, and frequent pedestrian crossings.';
        echo "  ok: FAQ[$k] US-17 ranking\n";
        $faq_edits++;
    }

    if ( isset( $q['question'] ) && false !== stripos( $q['question'], 'Why are Myrtle Beach roads so dangerous during summer' ) ) {
        $faqs[ $k ]['question'] = 'Are Myrtle Beach roads more dangerous in summer?';
        $faqs[ $k ]['answer']   = 'Not for fatal crashes. Federal data for 2020–2024 shows 22.6% of Horry County\'s fatal crashes fell in June through August — below the 25% an even spread across the year would give, and below South Carolina\'s 26.1%. Summer brings far more traffic, unfamiliar drivers and pedestrian activity and produces more crashes overall, but the fatal ones are spread across the calendar, with October, May and December the worst months.';
        echo "  ok: FAQ[$k] summer premise\n";
        $faq_edits++;
    }
}
if ( ! $faq_edits ) { echo "  SKIP: no FAQ edits matched (already applied?)\n"; }

/* ---- 6. key takeaways ---- */
$kt_old = get_post_meta( $id, '_roden_key_takeaways', true );
$kt = roden_edit( (string) $kt_old,
    "U.S. 17 ranks as the state's deadliest summer highway, while the",
    "U.S. 17 carries more fatal crashes than any other Horry County route (39 between 2020 and 2024, per federal data), and summer is not the deadliest season — 22.6% of fatal crashes fall in June through August, below an even spread. The",
    'key takeaways', $failed );

echo "\n";
if ( $failed ) {
    echo "$failed edit(s) failed their assertion. NOTHING WRITTEN.\n";
    return;
}
if ( ! $apply ) {
    echo "Dry run complete, all assertions passed.\n";
    return;
}

echo 'BACKUP-JSON: ' . wp_json_encode( array(
    'post_id' => $id,
    'post_content' => $post->post_content,
    '_roden_faqs' => maybe_unserialize( get_post_meta( $id, '_roden_faqs', true ) ),
    '_roden_key_takeaways' => $kt_old,
) ) . "\n";

wp_update_post( array( 'ID' => $id, 'post_content' => $content ), true );
update_post_meta( $id, '_roden_faqs', $faqs );
update_post_meta( $id, '_roden_key_takeaways', $kt );
update_post_meta( $id, '_roden_last_reviewed', current_time( 'Y-m-d' ) );
clean_post_cache( $id );

$after = get_post( $id );
echo "\n--- VERIFY ---\n";
echo 'body: "Deadliest Time" gone      : ' . ( false === strpos( $after->post_content, 'Deadliest Time' ) ? 'yes' : 'NO' ) . "\n";
echo 'body: Memorial-Day claim gone    : ' . ( false === strpos( $after->post_content, 'Memorial Day through Labor Day is the most dangerous' ) ? 'yes' : 'NO' ) . "\n";
echo 'body: 22.6% present              : ' . ( false !== strpos( $after->post_content, '22.6%' ) ? 'yes' : 'NO' ) . "\n";
$f2 = wp_json_encode( get_post_meta( $id, '_roden_faqs', true ) );
echo 'faqs: summertime ranking gone    : ' . ( false === strpos( $f2, 'summertime travel' ) ? 'yes' : 'NO' ) . "\n";
echo 'faqs: 22.6 present               : ' . ( false !== strpos( $f2, '22.6' ) ? 'yes' : 'NO' ) . "\n";
echo 'takeaways: deadliest summer gone : ' . ( false === strpos( (string) get_post_meta( $id, '_roden_key_takeaways', true ), "deadliest summer highway" ) ? 'yes' : 'NO' ) . "\n";
echo "\nDone.\n";
