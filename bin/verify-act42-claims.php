<?php
/**
 * Sweep the site against the FORBIDDEN list in
 * docs/briefs/2026-08-26-sc-act42-liquor-liability.md.
 *
 *   ssh $H "wp --path=... eval-file -" < bin/verify-act42-claims.php
 *
 * Read-only. The brief lists six claims that must not appear about 2025 Act No.
 * 42, each because it is the error most likely to circulate. This checks whether
 * any of them made it onto the site — including into the pages written FROM the
 * brief, which is where a misreading would do the most damage.
 *
 * The check that matters most is the alcohol direction. The Statehouse serves
 * amended bills with strike/insert markup, and the brief's own author briefly
 * concluded the alcohol exception SURVIVED after reading a flattened version. A
 * page saying alcohol conduct still escapes subsection (A) would be that same
 * error, published.
 */

$rows = get_posts( array(
    'post_type'   => array( 'post', 'page', 'resource', 'practice_area', 'location' ),
    'post_status' => 'publish',
    'numberposts' => -1,
    'fields'      => 'ids',
) );

$FORBIDDEN = array(
    'abolished dram-shop'       => '/act (no\.? )?42[^.]{0,120}(abolish|eliminat|remov)[^.]{0,40}(dram.?shop|liability of (bars|licensees))/i',
    'bars no longer liable'     => '/(bars|licensees|establishments) (are )?no longer (liable|responsible)/i',
    'changed comparative rule'  => '/act (no\.? )?42[^.]{0,140}(comparative negligence rule|51% bar|changed .{0,20}comparative)/i',
    'changed the 50% threshold' => '/act (no\.? )?42[^.]{0,140}(changed|raised|lowered)[^.]{0,40}fifty percent/i',
    'flat 50% joint liability'  => '/licensee is jointly and severally liable for fifty percent/i',
    'alcohol still excepted'    => '/(alcohol|intoxicat)[^.]{0,90}(still|continues to)[^.]{0,40}(escape|exempt|excepted|does not apply)/i',
    'act 42 applied to Georgia' => '/act (no\.? )?42[^.]{0,160}(georgia|O\.C\.G\.A)/i',
);

/*
 * NEGATION AND PROXIMITY GUARD — the whole reason the first run scored 6/6 false.
 *
 * Two things defeat a plain pattern here, and both are things the CORRECT pages do:
 *
 *  1. The authoritative page states each forbidden claim in order to deny it —
 *     "Act 42 did not abolish dram-shop liability", "Did Act 42 change South
 *     Carolina's comparative negligence rule? No." A detector that cannot see a
 *     negation flags the page doing the best job.
 *  2. The 61-2-147 condition can sit on EITHER side of the fifty-percent clause.
 *     Both pages put it first ("where a verdict is rendered against both..."), so
 *     a forward-only lookahead misses it.
 *
 * So: check a window on both sides, and treat a nearby negation or condition as
 * exculpatory. A claim is only reported when neither appears.
 */
function roden_act42_excused( $plain, $offset, $label ) {
    $before = substr( $plain, max( 0, $offset - 260 ), min( 260, $offset ) );
    $after  = substr( $plain, $offset, 320 );
    $window = $before . ' ' . $after;

    // Stating a myth in order to correct it.
    if ( preg_match( '/\b(did not|does not|do not|never|is not|are not|no longer applies|myth|wrongly|incorrect)\b/i', $window ) ) {
        return true;
    }
    // Question-and-answer form: "Did Act 42 ...? No."
    if ( preg_match( '/\?\s*(",\s*"answer"\s*:\s*")?\s*No\b/i', $after ) ) {
        return true;
    }
    // The 61-2-147 conditional, on either side.
    if ( 'flat 50% joint liability' === $label
        && preg_match( '/verdict is rendered against both|both a licens|where a verdict/i', $window ) ) {
        return true;
    }
    return false;
}

$hits = array();
$hits = array();
foreach ( $rows as $id ) {
    $p = get_post( $id );
    $f = maybe_unserialize( get_post_meta( $id, '_roden_faqs', true ) );
    if ( is_string( $f ) ) { $d = json_decode( $f, true ); if ( is_array( $d ) ) { $f = $d; } }
    $surfaces = array(
        'post_content'         => $p->post_content,
        'post_excerpt'         => $p->post_excerpt,
        '_roden_faqs'          => is_array( $f ) ? wp_json_encode( $f, JSON_UNESCAPED_UNICODE ) : (string) $f,
        '_roden_key_takeaways' => (string) get_post_meta( $id, '_roden_key_takeaways', true ),
    );
    foreach ( $surfaces as $sname => $text ) {
        if ( ! $text ) { continue; }
        $plain = preg_replace( '/\s+/', ' ', wp_strip_all_tags( $text ) );
        foreach ( $FORBIDDEN as $label => $re ) {
            if ( preg_match( $re, $plain, $m, PREG_OFFSET_CAPTURE ) ) {
                if ( roden_act42_excused( $plain, (int) $m[0][1], $label ) ) {
                    continue;
                }
                $hits[] = array( $id, get_permalink( $id ), $sname, $label,
                    substr( $plain, max( 0, $m[0][1] - 90 ), 300 ) );
            }
        }
    }
}

printf( "pages scanned: %d\nforbidden-claim hits: %d\n\n", count( $rows ), count( $hits ) );
foreach ( $hits as $h ) {
    printf( "  [%d] %s\n      surface=%s  claim=%s\n      ...%s...\n\n", $h[0], $h[1], $h[2], $h[3], $h[4] );
}

// Positive check: the pages that DO discuss the Act should state it correctly.
echo "--- pages naming Act 42, and whether they carry the conditional on 61-2-147 ---\n";
foreach ( $rows as $id ) {
    $p = get_post( $id );
    $f = maybe_unserialize( get_post_meta( $id, '_roden_faqs', true ) );
    if ( is_string( $f ) ) { $d = json_decode( $f, true ); if ( is_array( $d ) ) { $f = $d; } }
    $blob = preg_replace( '/\s+/', ' ', wp_strip_all_tags(
        $p->post_content . ' ' . ( is_array( $f ) ? wp_json_encode( $f ) : '' ) . ' '
        . (string) get_post_meta( $id, '_roden_key_takeaways', true ) ) );
    if ( ! preg_match( '/Act (No\.? )?42|H\.?3430/i', $blob ) ) { continue; }
    $has147  = false !== strpos( $blob, '61-2-147' );
    $hasCond = (bool) preg_match( '/verdict is rendered against both|both a licens/i', $blob );
    printf( "  [%d] %-58s 61-2-147:%-4s conditional:%s\n", $id,
        substr( parse_url( get_permalink( $id ), PHP_URL_PATH ), 0, 58 ),
        $has147 ? 'yes' : 'no', $hasCond ? 'yes' : ( $has147 ? 'NO' : 'n/a' ) );
}
