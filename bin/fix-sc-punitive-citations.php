<?php
/**
 * Two more miscited authorities in the South Carolina punitive-damages material.
 *
 *   ssh $H "wp --path=... eval-file -" < bin/fix-sc-punitive-citations.php
 *   RODEN_APPLY=1 to write; default is a DRY RUN.
 *
 * Found while verifying O.C.G.A. 51-12-5.1, which itself came back CLEAN across
 * all 51 pages that cite it.
 *
 * THE TWO SECTIONS, verified verbatim 2026-08-31 (Justia / scstatehouse.gov):
 *
 *   S.C. Code 15-32-530(A)  "an award of punitive damages may not exceed the
 *                            greater of three times the amount of compensatory
 *                            damages awarded to each claimant entitled thereto
 *                            or the sum of five hundred thousand dollars"
 *                            -> THE CAP
 *
 *   S.C. Code 15-33-135     "In any civil action where punitive damages are
 *                            claimed, the plaintiff has the burden of proving
 *                            such damages by clear and convincing evidence"
 *                            -> THE BURDEN OF PROOF
 *
 * (1) 15-33-135 cited for the CAP. Two pages. Five other pages cite it correctly
 *     for the burden of proof and are untouched.
 *
 * (2) /golf-cart-accident-lawyers/golf-cart-dui/ gives the right answer for the
 *     wrong reason, twice — body and FAQ. It says South Carolina allows punitive
 *     damages "for willful, wanton, or reckless conduct with no statutory cap."
 *
 *     On a DUI page the no-cap conclusion is CORRECT, but not for that reason.
 *     Willful/wanton/reckless is the standard for punitive damages being
 *     AVAILABLE. The cap is removed by 15-32-530(C), whose triggers are intent to
 *     harm, a felony conviction arising from the same conduct, or — the one that
 *     applies here — that the defendant "acted or failed to act while under the
 *     influence of alcohol, drugs ... to the degree that the defendant's judgment
 *     is substantially impaired."
 *
 *     Stated as-is the sentence is a rule that would be wrong the moment anyone
 *     copied it to a non-DUI page, which is exactly how claims propagate here.
 *
 * DELIBERATELY NOT TOUCHED:
 *   - 1703's other use, "When a plaintiff seeks punitive damages (S.C. Code
 *     15-33-135), the defendant may introduce the plaintiff's driving history" —
 *     loose, but it is about punitive damages generally, not the cap.
 *   - 4534, which cites 15-33-135 for the willful/wanton standard in the body and
 *     CORRECTLY for clear-and-convincing in its key takeaways. Its real gap is
 *     that it never states the cap at all — incompleteness, not error, and
 *     rewriting a page's damages section is not a citation fix.
 *
 * Exact-match str_replace only. Each edit asserts exactly one occurrence.
 */

$APPLY = (bool) getenv( 'RODEN_APPLY' );
echo $APPLY ? "=== APPLY MODE ===\n\n" : "=== DRY RUN (set RODEN_APPLY=1 to write) ===\n\n";

$EDITS = array(
    array(
        'id'      => 1703,
        'field'   => 'post_content',
        'label'   => '1703 table cell: cap cited to 15-33-135',
        'search'  => 'Greater of 3x compensatory or $500,000 (S.C. Code § 15-33-135)',
        'replace' => 'Greater of 3x compensatory or $500,000 (S.C. Code § 15-32-530)',
    ),
    array(
        'id'      => 1810,
        'field'   => 'post_content',
        'label'   => '1810 truck liability: cap uncited, availability miscited',
        'search'  => 'Available under S.C. Code § 15-33-135 for willful, wanton, or reckless conduct. Generally capped at the greater of three times compensatory damages or $500,000.',
        'replace' => 'Available for willful, wanton, or reckless conduct, proven by clear and convincing evidence (S.C. Code § 15-33-135). Generally capped at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530).',
    ),
    array(
        'id'      => 4189,
        'field'   => 'post_content',
        'label'   => '4189 body: no-cap attributed to the wrong trigger',
        'search'  => 'South Carolina allows punitive damages upon proof of willful, wanton, or reckless conduct by clear and convincing evidence, with no statutory cap.',
        'replace' => 'South Carolina allows punitive damages upon proof of willful, wanton, or reckless conduct by clear and convincing evidence (S.C. Code § 15-33-135). They are normally capped at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530), but § 15-32-530(C) removes the cap entirely where the defendant acted while under the influence of alcohol or drugs to the degree that his or her judgment was substantially impaired — which is the situation in a golf cart DUI case.',
    ),
    array(
        'id'      => 4189,
        'field'   => 'faq',
        'label'   => '4189 FAQ: no-cap attributed to the wrong trigger',
        'search'  => 'South Carolina also allows punitive damages for willful, wanton, or reckless conduct with no statutory cap.',
        'replace' => 'South Carolina normally caps punitive damages at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530), but that cap is removed where the defendant was under the influence to the degree that his or her judgment was substantially impaired (§ 15-32-530(C)), so a golf cart DUI case is uncapped in South Carolina as well.',
    ),
);

$backups = array();
$failed  = 0;
$applied = 0;

foreach ( $EDITS as $e ) {
    $post = get_post( $e['id'] );
    if ( ! $post ) {
        echo "  FAIL (post {$e['id']} not found): {$e['label']}\n";
        $failed++;
        continue;
    }

    if ( 'post_content' === $e['field'] ) {
        $text = $post->post_content;
    } else {
        $faqs = maybe_unserialize( get_post_meta( $e['id'], '_roden_faqs', true ) );
        if ( is_string( $faqs ) ) {
            $d = json_decode( $faqs, true );
            if ( is_array( $d ) ) { $faqs = $d; }
        }
        $text = is_array( $faqs ) ? wp_json_encode( $faqs ) : (string) $faqs;
    }

    if ( false !== strpos( $text, $e['replace'] ) ) {
        echo "  SKIP (already applied): {$e['label']}\n";
        continue;
    }

    $n = substr_count( $text, $e['search'] );
    if ( 1 !== $n ) {
        echo "  FAIL ($n occurrences, expected 1): {$e['label']}\n";
        $failed++;
        continue;
    }
    echo "  ok: {$e['label']}\n";
    $applied++;

    if ( ! $APPLY ) { continue; }

    if ( ! isset( $backups[ $e['id'] ] ) ) {
        $backups[ $e['id'] ] = array(
            'url'          => get_permalink( $e['id'] ),
            'post_content' => $post->post_content,
            '_roden_faqs'  => get_post_meta( $e['id'], '_roden_faqs', true ),
        );
    }

    if ( 'post_content' === $e['field'] ) {
        wp_update_post( array( 'ID' => $e['id'], 'post_content' => str_replace( $e['search'], $e['replace'], $post->post_content ) ), true );
    } else {
        $faqs = maybe_unserialize( get_post_meta( $e['id'], '_roden_faqs', true ) );
        if ( is_string( $faqs ) ) {
            $d = json_decode( $faqs, true );
            if ( is_array( $d ) ) { $faqs = $d; }
        }
        foreach ( $faqs as $k => $q ) {
            if ( is_array( $q ) && isset( $q['answer'] ) && false !== strpos( $q['answer'], $e['search'] ) ) {
                $faqs[ $k ]['answer'] = str_replace( $e['search'], $e['replace'], $q['answer'] );
            }
        }
        update_post_meta( $e['id'], '_roden_faqs', $faqs );
    }
    update_post_meta( $e['id'], '_roden_last_reviewed', current_time( 'Y-m-d' ) );
    clean_post_cache( $e['id'] );
}

printf( "\n%d edit(s) matched, %d failed\n", $applied, $failed );

if ( $failed ) {
    echo "Assertions failed. " . ( $APPLY ? "Edits that PASSED were written; failures were not.\n" : "Nothing written (dry run).\n" );
}
if ( $APPLY && $backups ) {
    echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\n";
}
echo "\nDone.\n";
