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
 * FIXED 2026-08-31: quantities now bind to their NEAREST citation, not to every
 * citation in the sentence. That removed some noise. It did not make the approach
 * work, for two structural reasons this site is full of:
 *
 *   1. TWO-STATE COMPARISON TABLES flatten to one unpunctuated "sentence" holding
 *      both states' citations and both states' numbers, inches apart. Nearest-
 *      citation binding is a coin flip there.
 *   2. JSON-ENCODED FAQ ARRAYS have no sentence boundary between entries, so
 *      '"},{"question":"' merges the end of one answer with the start of the next.
 *      This produced the run's other apparent finding: a $25,000 figure bound to
 *      the punitive-damages cap, which is really Georgia's minimum liability
 *      coverage in the following FAQ. Correct on both the EN and ES pages.
 *
 * SCORE FOR THE FIRST FULL RUN: twelve statutes, ~1,300 claim instances, THREE
 * things flagged, ZERO real errors. The ante litem alarm, the punitive-cap alarm
 * and the SC 51%-bar "disagreement" (three equivalent phrasings: "not more than
 * 50%", "less than 51%", "50% or less") were all artifacts.
 *
 * READ THAT AS A RESULT, NOT A FAILURE. It is weak positive evidence that the
 * high-exposure statutes are internally consistent. It is NOT evidence they are
 * correct — the car-seat error survived precisely because only one page carried
 * it, so there was nothing to disagree with. Consistency cannot catch a claim the
 * whole site gets wrong the same way.
 *
 * WHERE THE NEXT EFFORT SHOULD GO: external verification of the top statutes by
 * READING what the site asserts against the statutory text. Not pattern matching.
 * This file's value is the inventory it is paired with and the negative result
 * above, not as an ongoing detector.
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

/**
 * Every quantity in a sentence, with its character offset.
 *
 * Returned as array( offset => token ). Tokens are normalised so that wording
 * differences ("two years", "2 years", "2-year") collapse to one signature.
 */
function roden_quantities_with_offsets( $s ) {
    $out = array();
    $pats = array(
        '/\b(one|two|three|four|five|six|seven|eight|nine|ten|twelve|1|2|3|4|5|6|7|8|9|10|12|24|30|90|120|180|365)\s*[- ]?\s*(year|month|day)s?\b/i'
            => function ( $m ) {
                $w = array( 'one'=>'1','two'=>'2','three'=>'3','four'=>'4','five'=>'5','six'=>'6',
                            'seven'=>'7','eight'=>'8','nine'=>'9','ten'=>'10','twelve'=>'12' );
                $n = strtolower( $m[1] );
                return ( isset( $w[ $n ] ) ? $w[ $n ] : $n ) . strtolower( $m[2] );
            },
        '/\b(\d{1,3})\s*(?:%|percent)/i' => function ( $m ) { return $m[1] . 'pct'; },
        '/\$\s?([\d,]+(?:\.\d+)?)\s*(million|M)?\b/i'
            => function ( $m ) { return '$' . str_replace( ',', '', $m[1] ) . ( ! empty( $m[2] ) ? 'M' : '' ); },
    );
    foreach ( $pats as $re => $fmt ) {
        if ( preg_match_all( $re, $s, $mm, PREG_SET_ORDER | PREG_OFFSET_CAPTURE ) ) {
            foreach ( $mm as $m ) {
                $flat = array_map( function ( $x ) { return $x[0]; }, $m );
                $out[ $m[0][1] ] = $fmt( $flat );
            }
        }
    }
    // Polarity phrases that flip a rule outright.
    foreach ( array( 'no cap', 'not admissible', 'no limit', 'does not apply', 'unlimited',
                     'struck down', 'unconstitutional', 'no statutory cap' ) as $phrase ) {
        $off = 0;
        while ( false !== ( $off = stripos( $s, $phrase, $off ) ) ) {
            $out[ $off ] = '!' . str_replace( ' ', '_', $phrase );
            $off += strlen( $phrase );
        }
    }
    return $out;
}

/** Offsets of every statute citation in a sentence, as array( offset => "GA 9-3-33" ). */
function roden_citations_with_offsets( $s ) {
    $out = array();
    $re = '/\b(O\.?C\.?G\.?A\.?|S\.?C\.?\s*Code(?:\s*Ann\.?)?)?\s*(?:&sect;|§|Section)?\s*([0-9]+-[0-9]+-[0-9]+(?:\.[0-9]+)?)/i';
    if ( preg_match_all( $re, $s, $mm, PREG_SET_ORDER | PREG_OFFSET_CAPTURE ) ) {
        foreach ( $mm as $m ) {
            $num = $m[2][0];
            // State is inferred from the label when present; otherwise from the
            // numbering, which does not collide between the two codes in practice.
            $label = isset( $m[1][0] ) ? $m[1][0] : '';
            $state = '';
            if ( $label ) {
                $state = ( 0 === stripos( $label, 'O' ) ) ? 'GA' : 'SC';
            }
            $out[ $m[2][1] ] = array( 'num' => $num, 'state' => $state );
        }
    }
    return $out;
}

$claims = array();

foreach ( $rows as $id ) {
    $p = get_post( $id );
    $faqs = maybe_unserialize( get_post_meta( $id, '_roden_faqs', true ) );
    if ( is_string( $faqs ) ) { $d = json_decode( $faqs, true ); if ( is_array( $d ) ) { $faqs = $d; } }

    $blob = $p->post_content . ' '
          . ( is_array( $faqs ) ? wp_json_encode( $faqs ) : (string) $faqs ) . ' '
          . (string) get_post_meta( $id, '_roden_key_takeaways', true );

    foreach ( preg_split( '/(?<=[.!?])\s+/', wp_strip_all_tags( $blob ) ) as $sent ) {
        $cites = roden_citations_with_offsets( $sent );
        if ( ! $cites ) { continue; }
        $qty = roden_quantities_with_offsets( $sent );
        if ( ! $qty ) { continue; }

        // Bind each quantity to its NEAREST citation. This is the whole point:
        // a sentence citing several statutes must not hand all of its numbers to
        // all of them, which is how the first version produced a false alarm.
        $bound = array();
        foreach ( $qty as $qoff => $token ) {
            $best = null; $bestd = PHP_INT_MAX;
            foreach ( $cites as $coff => $c ) {
                $d = abs( $qoff - $coff );
                if ( $d < $bestd ) { $bestd = $d; $best = $coff; }
            }
            if ( null !== $best ) { $bound[ $best ][] = $token; }
        }

        foreach ( $bound as $coff => $tokens ) {
            $c = $cites[ $coff ];
            foreach ( $TARGETS as $target => $label ) {
                list( $tstate, $tnum ) = explode( ' ', $target );
                if ( $c['num'] !== $tnum ) { continue; }
                if ( $c['state'] && $c['state'] !== $tstate ) { continue; }
                sort( $tokens );
                $sig = implode( '|', array_unique( $tokens ) );
                if ( ! isset( $claims[ $target ][ $sig ] ) ) {
                    $claims[ $target ][ $sig ] = array( 'n' => 0, 'sample' => trim( preg_replace( '/\s+/', ' ', $sent ) ), 'pages' => array() );
                }
                $claims[ $target ][ $sig ]['n']++;
                $claims[ $target ][ $sig ]['pages'][ $id ] = true;
            }
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
