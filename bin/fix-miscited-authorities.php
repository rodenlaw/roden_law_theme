<?php
/**
 * Two miscitations: correct rules, wrong authorities.
 *
 *   ssh $H "wp --path=... eval-file -" < bin/fix-miscited-authorities.php
 *   RODEN_APPLY=1 to write; default is a DRY RUN.
 *
 * Found by the verification pass over the three highest-exposure statutes. Those
 * three — S.C. Code 15-3-530 (606 pages), O.C.G.A. 9-3-33 (469) and O.C.G.A.
 * 51-12-33 (289) — were all VERIFIED CORRECT against statutory text. These two
 * turned up alongside them.
 *
 * NEITHER IS A FALSE STATEMENT OF THE RULE. In both cases the rule and the number
 * the reader acts on are right; the authority cited for them is wrong. That is a
 * lesser defect than the car-seat error, and this script does not touch a single
 * substantive claim — only the citation attached to it.
 *
 * (1) S.C. Code 15-38-15 cited for the PLAINTIFF'S recovery bar.
 *
 *     15-38-15 governs defendant-side joint and several liability, and expressly
 *     provides that including the plaintiff's fault in the calculation "shall not
 *     reduce the amount of plaintiff's recoverable damages." The plaintiff's bar
 *     comes from Nelson v. Concrete Supply Co., 303 S.C. 243, 399 S.E.2d 783
 *     (1991), which adopted modified comparative negligence.
 *
 *     The site already knows this: 198 instances of "Nelson v. Concrete Supply
 *     Co." across 56 pages, and 14 pages cite 15-38-15 correctly for joint and
 *     several liability. This corrects the pages that contradict them.
 *
 *     NOT the question bc04c6f settled. That commit fixed whether a defendant at
 *     exactly 50% is jointly liable ("less than fifty percent" in the statute).
 *     Same section, different question, and it left this one untouched.
 *
 * (2) O.C.G.A. 9-3-30 cited for vehicle or property damage.
 *
 *     9-3-30(a) is "All actions for trespass upon or damage to realty". Vehicle
 *     damage is personalty: 9-3-31, "Actions for injuries to personalty shall be
 *     brought within four years". The four-year period the pages state is right;
 *     the section points the reader at real-property law.
 *
 *     /resources/georgia-statute-of-limitations/ already has it right in a table
 *     — 9-3-32 for vehicle/personal property, 9-3-30 for real property — so this
 *     is again the site disagreeing with itself. Occurrences in a genuine realty
 *     context are left alone by the guard below.
 *
 * SECOND PASS, 2026-08-31. The first run left SIX survivals, and the reason is
 * the one CLAUDE.md states outright: it swept a STRING FORM, not the claim class.
 * The misses wrote the same citation as "S.C. Code section 15-38-15", "S.C. Code
 * Section 15-38-15" and "S.C. Code 15-38-15" — no section symbol at all. The
 * pattern now accepts all of them.
 *
 * The joint-and-several guard was also too broad: a bare /joint/ matched "Joint
 * Base Charleston" on /blog/military-base-accidents-joint-base-charleston-rights/
 * and would have skipped a real miscitation on any page whose place name contains
 * the word. It now requires the actual phrase.
 *
 * Sources verified 2026-08-31 against scstatehouse.gov, Justia and FindLaw.
 *
 * ON preg_replace_callback. CLAUDE.md's ban is on preg_replace, whose REPLACEMENT
 * STRING interpolates "$" and has silently eaten content here before. A callback's
 * return value is not interpolated at all, so the hazard does not exist. It is
 * used because the correct edit depends on surrounding context — the same citation
 * must be corrected in one sentence and preserved in the next — which a literal
 * str_replace cannot express. Every replacement is still a fixed literal string.
 */

$APPLY = (bool) getenv( 'RODEN_APPLY' );
echo $APPLY ? "=== APPLY MODE ===\n\n" : "=== DRY RUN (set RODEN_APPLY=1 to write) ===\n\n";

$NELSON = 'Nelson v. Concrete Supply Co.';

/**
 * Correct 15-38-15 -> Nelson, only where the passage states the PLAINTIFF'S bar.
 * Leaves joint-and-several passages untouched.
 */
function roden_fix_sc_bar( $text, &$n ) {
    return preg_replace_callback(
        '/(?:S\.?C\.?\s*Code\s*)?(?:&sect;|§|[Ss]ection)?\s*15-38-15/u',
        function ( $m ) use ( $text, &$n ) {
            static $offset = 0;
            $pos   = strpos( $text, $m[0], $offset );
            $offset = ( false === $pos ) ? $offset : $pos + 1;
            $ahead = ( false === $pos ) ? '' : substr( $text, $pos, 300 );

            // Correct usage: defendant-side apportionment. Leave it.
            if ( preg_match( '/joint(?:ly)?\s+and\s+several|jointly\s+liable|severally\s+liable|indivisible|apportion/i', $ahead ) ) {
                return $m[0];
            }

            /*
             * Already hedged, or already crediting the case. /blog/georgia-
             * comparative-negligence-law/ says the rule was "established through
             * case law and codified in part under S.C. Code 15-38-15", which is a
             * fair characterisation and the most careful wording on the site.
             * Swapping the citation there would produce "codified in part under
             * Nelson v. Concrete Supply Co." — a case is not a codification.
             * Leave any passage that already names case law or the case itself.
             */
            $around = ( false === $pos ) ? '' : substr( $text, max( 0, $pos - 140 ), 300 );
            if ( preg_match( '/case law|Nelson/i', $around ) ) {
                return $m[0];
            }
            // Plaintiff-bar usage: this is the miscitation.
            if ( preg_match( '/\b(you|your|plaintiff)\b[^<]{0,110}\b(recover|barred|blame|fault)/i', $ahead ) ) {
                $n++;
                return 'Nelson v. Concrete Supply Co.';
            }
            return $m[0];
        },
        $text
    );
}

/** Correct 9-3-30 -> 9-3-31 only in a personal-property context. */
function roden_fix_ga_property( $text, &$n ) {
    return preg_replace_callback(
        '/(?:&sect;|§)\s*9-3-30/u',
        function ( $m ) use ( $text, &$n ) {
            static $offset = 0;
            $pos    = strpos( $text, $m[0], $offset );
            $offset = ( false === $pos ) ? $offset : $pos + 1;
            $back   = ( false === $pos ) ? '' : substr( $text, max( 0, $pos - 240 ), 300 );

            // Genuine realty usage: 9-3-30 is correct there. Leave it.
            if ( preg_match( '/real\s*propert|realty/i', $back ) ) {
                return $m[0];
            }
            if ( preg_match( '/propert|vehicle|diminished|car damage/i', $back ) ) {
                $n++;
                return str_replace( '9-3-30', '9-3-31', $m[0] );
            }
            return $m[0];
        },
        $text
    );
}

$rows = get_posts( array(
    'post_type'   => array( 'post', 'page', 'resource', 'practice_area', 'location' ),
    'post_status' => 'publish',
    'numberposts' => -1,
    'fields'      => 'ids',
) );

$backups = array();
$tot_sc = 0; $tot_ga = 0; $pages_sc = array(); $pages_ga = array();

foreach ( $rows as $id ) {
    $post = get_post( $id );
    $faqs = maybe_unserialize( get_post_meta( $id, '_roden_faqs', true ) );
    if ( is_string( $faqs ) ) { $d = json_decode( $faqs, true ); if ( is_array( $d ) ) { $faqs = $d; } }

    $n_sc = 0; $n_ga = 0;

    $content = roden_fix_ga_property( roden_fix_sc_bar( $post->post_content, $n_sc ), $n_ga );
    $kt_old  = (string) get_post_meta( $id, '_roden_key_takeaways', true );
    $kt      = roden_fix_ga_property( roden_fix_sc_bar( $kt_old, $n_sc ), $n_ga );

    $faqs_new = $faqs;
    if ( is_array( $faqs_new ) ) {
        foreach ( $faqs_new as $k => $q ) {
            if ( ! is_array( $q ) ) { continue; }
            foreach ( array( 'question', 'answer' ) as $f ) {
                if ( ! isset( $q[ $f ] ) ) { continue; }
                $faqs_new[ $k ][ $f ] = roden_fix_ga_property( roden_fix_sc_bar( $q[ $f ], $n_sc ), $n_ga );
            }
        }
    }

    if ( ! $n_sc && ! $n_ga ) { continue; }

    $backups[ $id ] = array(
        'url'                  => get_permalink( $id ),
        'post_content'         => $post->post_content,
        '_roden_key_takeaways' => $kt_old,
        '_roden_faqs'          => $faqs,
    );
    $tot_sc += $n_sc; $tot_ga += $n_ga;
    if ( $n_sc ) { $pages_sc[ $id ] = true; }
    if ( $n_ga ) { $pages_ga[ $id ] = true; }

    printf( "[%d] %-70s  SC:%d GA:%d\n", $id, substr( get_permalink( $id ), 21 ), $n_sc, $n_ga );

    if ( $APPLY ) {
        if ( $content !== $post->post_content ) {
            wp_update_post( array( 'ID' => $id, 'post_content' => $content ), true );
        }
        if ( $kt !== $kt_old ) { update_post_meta( $id, '_roden_key_takeaways', $kt ); }
        if ( $faqs_new !== $faqs ) { update_post_meta( $id, '_roden_faqs', $faqs_new ); }
        update_post_meta( $id, '_roden_last_reviewed', current_time( 'Y-m-d' ) );
        clean_post_cache( $id );
    }
}

printf( "\n15-38-15 -> Nelson  : %d edits across %d pages\n", $tot_sc, count( $pages_sc ) );
printf( "9-3-30   -> 9-3-31  : %d edits across %d pages\n", $tot_ga, count( $pages_ga ) );

if ( ! $APPLY ) {
    echo "\nDry run. Re-run with RODEN_APPLY=1 to write.\n";
    return;
}

echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\n";
echo "\nDone.\n";
