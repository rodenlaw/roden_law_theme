<?php
/**
 * Internal-consistency pass over the site's statutory claims.
 *
 *   ssh $H "wp --path=... eval-file -" < bin/verify-statute-consistency.php
 *
 * Read-only. Companion to bin/inventory-statute-citations.php.
 *
 * The idea: where the same statute is described in materially different terms on
 * different pages, at least one of those pages is wrong — and that is detectable
 * without consulting a single external source. It cannot prove a claim correct
 * (every page agreeing on a wrong number still reads as consistent), so this is a
 * triage pass that says WHERE to spend external verification, not a substitute
 * for it.
 *
 * Every accuracy incident on this site so far was found by accident. This looks.
 *
 * KNOWN LIMIT — READ BEFORE ACTING ON OUTPUT. Signatures are extracted per
 * SENTENCE, and a sentence that cites several statutes contributes ALL of its
 * quantities to EVERY citation in it. So a correct sentence like
 *
 *   "O.C.G.A. 36-33-5 must be served within six months, and a claim against
 *    Chatham County must be presented within 12 months under O.C.G.A. 36-11-1"
 *
 * registers "12month" against 36-33-5, which is not what it says. On the first
 * run this produced an 11-page false alarm on the municipal ante litem deadline
 * — the exact claim PR #94 had fixed — and every one of the 15 sentences turned
 * out to be correct on inspection.
 *
 * Comparison tables trip it the same way: a GA-vs-SC row legitimately carries
 * both states' numbers, so 50pct and 51pct both attach to both citations.
 *
 * TREAT EVERY SIGNATURE SPLIT AS A QUESTION, NEVER A FINDING. Read the sentences
 * before concluding anything. The repo has been here before: 151fd62, "the alarm
 * I raised was too loud."
 *
 * The fix, if this gets invested in further, is to bind each quantity to its
 * NEAREST citation rather than to every citation in the sentence.
 */

$TARGETS = array(
    'SC 15-3-530'  => 'SC statute of limitations',
    'GA 9-3-33'    => 'GA statute of limitations',
    'GA 51-12-33'  => 'GA apportionment / fault bar',
    'SC 15-38-15'  => 'SC comparative negligence bar',
    'GA 51-12-5.1' => 'GA punitive damages cap',
    'SC 15-78-110' => 'SC Tort Claims Act limitation',
    'GA 36-33-5'   => 'GA municipal ante litem',
    'SC 15-32-220' => 'SC med-mal non-economic cap',
    'SC 42-15-40'  => 'SC workers comp limitation',
    'GA 34-9-82'   => 'GA workers comp limitation',
    'SC 15-32-530' => 'SC punitive damages cap',
    'SC 38-77-150' => 'SC UM coverage',
);

$rows = get_posts( array(
    'post_type'   => array( 'post', 'page', 'resource', 'practice_area', 'location' ),
    'post_status' => 'publish',
    'numberposts' => -1,
    'fields'      => 'ids',
) );

/** Normalise a claim to its load-bearing quantities, so wording differences collapse. */
function roden_claim_signature( $sentence ) {
    $s = strtolower( wp_strip_all_tags( $sentence ) );
    $sig = array();
    // durations
    if ( preg_match_all( '/\b(one|two|three|four|five|six|seven|eight|nine|ten|twelve|1|2|3|4|5|6|7|8|9|10|12|24|30|90|120|180|365)\s*[- ]?\s*(year|month|day)s?\b/', $s, $m, PREG_SET_ORDER ) ) {
        foreach ( $m as $x ) { $sig[] = $x[1] . $x[2]; }
    }
    // percentages
    if ( preg_match_all( '/\b(\d{1,3})\s*(?:%|percent)/', $s, $m ) ) {
        foreach ( $m[1] as $x ) { $sig[] = $x . 'pct'; }
    }
    // money
    if ( preg_match_all( '/\$\s?([\d,]+(?:\.\d+)?)\s*(million)?/', $s, $m, PREG_SET_ORDER ) ) {
        foreach ( $m as $x ) { $sig[] = '$' . str_replace( ',', '', $x[1] ) . ( ! empty( $x[2] ) ? 'M' : '' ); }
    }
    // polarity words that flip a rule
    foreach ( array( 'no cap', 'not admissible', 'no limit', 'does not apply', 'unlimited', 'struck down', 'unconstitutional' ) as $p ) {
        if ( false !== strpos( $s, $p ) ) { $sig[] = '!' . str_replace( ' ', '_', $p ); }
    }
    sort( $sig );
    return implode( '|', array_unique( $sig ) );
}

$claims = array(); // target => signature => array( count, sample, pages[] )

foreach ( $rows as $id ) {
    $p = get_post( $id );
    $faqs = maybe_unserialize( get_post_meta( $id, '_roden_faqs', true ) );
    if ( is_string( $faqs ) ) { $d = json_decode( $faqs, true ); if ( is_array( $d ) ) { $faqs = $d; } }

    $blob = $p->post_content . ' '
          . ( is_array( $faqs ) ? wp_json_encode( $faqs ) : (string) $faqs ) . ' '
          . (string) get_post_meta( $id, '_roden_key_takeaways', true );

    foreach ( $TARGETS as $cite => $label ) {
        list( , $num ) = explode( ' ', $cite );
        $quoted = preg_quote( $num, '/' );
        // sentence containing the citation
        foreach ( preg_split( '/(?<=[.!?])\s+/', wp_strip_all_tags( $blob ) ) as $sent ) {
            if ( ! preg_match( '/' . $quoted . '/', $sent ) ) { continue; }
            $sig = roden_claim_signature( $sent );
            if ( '' === $sig ) { continue; }
            if ( ! isset( $claims[ $cite ][ $sig ] ) ) {
                $claims[ $cite ][ $sig ] = array( 'n' => 0, 'sample' => trim( preg_replace( '/\s+/', ' ', $sent ) ), 'pages' => array() );
            }
            $claims[ $cite ][ $sig ]['n']++;
            $claims[ $cite ][ $sig ]['pages'][ $id ] = true;
        }
    }
}

foreach ( $TARGETS as $cite => $label ) {
    if ( empty( $claims[ $cite ] ) ) { continue; }
    $variants = $claims[ $cite ];
    uasort( $variants, function ( $a, $b ) { return $b['n'] <=> $a['n']; } );
    $total = count( $variants );
    printf( "\n===== %s — %s : %d distinct claim signature(s) =====\n", $cite, $label, $total );
    $shown = 0;
    foreach ( $variants as $sig => $v ) {
        if ( $shown++ >= 6 ) { printf( "  ... %d more signature(s)\n", $total - 6 ); break; }
        printf( "  [%3dx, %2d pages] %s\n", $v['n'], count( $v['pages'] ), $sig ?: '(no quantities)' );
        printf( "        e.g. %s\n", substr( $v['sample'], 0, 155 ) );
    }
}
