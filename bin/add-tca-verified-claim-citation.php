<?php
/**
 * Cite § 15-78-80 alongside § 15-78-110 where a page states the verified-claim
 * requirement.
 *
 *   ssh $H "wp --path=... eval-file -"       < bin/add-tca-verified-claim-citation.php
 *   ssh $H "wp --path=... eval-file - apply" < bin/add-tca-verified-claim-citation.php
 *
 * WHY. § 15-78-110 sets the Tort Claims Act limitation period — two years, or
 * three "if the claimant first filed a claim pursuant to this chapter". It says
 * nothing about a VERIFIED claim and nothing about ONE YEAR. Those come from
 * § 15-78-80(d): "If filed, the claim must be received within one year after the
 * loss was or should have been discovered."
 *
 * Pages state the rule correctly and cite only § 15-78-110. Nothing is wrong; the
 * one-year deadline is the actionable item and its source is missing, so a reader
 * following the citation will not find it.
 *
 * DELIBERATELY NARROW. Two unambiguous shapes only:
 *
 *   A. a parenthetical "(S.C. Code [Ann.] § 15-78-110)" with a verified-claim or
 *      one-year clause within 200 characters
 *   B. a table cell "<td>S.C. Code [Ann.] § 15-78-110</td>" whose row already
 *      mentions a verified claim
 *
 * NOT TOUCHED, and each for a stated reason — this is why the script is not a
 * blanket search-and-replace:
 *
 *   - THE SPANISH PAGES (4929, 4937) cite "S.C. Code § 15-78-10 y siguientes",
 *     which is the chapter. § 15-78-80 is inside it. They are already correct at
 *     the level they cite, and editing Spanish content to add a narrower cite
 *     would be churn in a locale this repo has a documented history of breaking.
 *   - /resources/georgia-vs-south-carolina-filing-deadlines/ (5353) states on the
 *     page that "the gaps left in the South Carolina column are deliberate…
 *     deadlines this guide has not independently verified". Adding a citation
 *     there would contradict the page's own disclosure.
 *   - Sentences where § 15-78-110 sits before the clause and no parenthetical is
 *     adjacent. Inserting a citation mid-sentence there is a rewrite, not a
 *     citation fix.
 *
 * Every replacement is a fixed literal built from the matched text. Idempotent:
 * a passage already naming § 15-78-80 is skipped.
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (pass 'apply' to write) ===\n\n";

$SKIP = array( 4929, 4937, 5353 ); // reasons in the docblock above

/** True when a verified-claim / one-year clause sits within $r chars of $pos. */
function roden_tca_near( $text, $pos, $r = 200 ) {
    $win = substr( $text, max( 0, $pos - $r ), $r * 2 );
    return (bool) preg_match( '/verified claim/i', $win );
}

function roden_tca_fix( $text, &$n ) {
    // A. parenthetical citation
    $text = preg_replace_callback(
        '/\((S\.C\.\s*Code(?:\s*Ann\.)?\s*(?:&sect;|§)\s*)15-78-110\)/u',
        function ( $m ) use ( $text, &$n ) {
            static $off = 0;
            $pos = strpos( $text, $m[0], $off );
            $off = ( false === $pos ) ? $off : $pos + 1;
            if ( false === $pos || ! roden_tca_near( $text, $pos ) ) {
                return $m[0];
            }
            $n++;
            // "§ 15-78-110" -> "§§ 15-78-110, 15-78-80"
            $lead = preg_replace( '/(&sect;|§)\s*$/u', '', $m[1] );
            $sym  = ( false !== strpos( $m[1], '&sect;' ) ) ? '&sect;&sect;' : '§§';
            return '(' . $lead . $sym . ' 15-78-110, 15-78-80)';
        },
        $text
    );

    // B. table cell citation
    $text = preg_replace_callback(
        '#<td>(S\.C\.\s*Code(?:\s*Ann\.)?\s*(?:&sect;|§)\s*)15-78-110</td>#u',
        function ( $m ) use ( $text, &$n ) {
            static $off = 0;
            $pos = strpos( $text, $m[0], $off );
            $off = ( false === $pos ) ? $off : $pos + 1;
            if ( false === $pos || ! roden_tca_near( $text, $pos, 320 ) ) {
                return $m[0];
            }
            $n++;
            $lead = preg_replace( '/(&sect;|§)\s*$/u', '', $m[1] );
            $sym  = ( false !== strpos( $m[1], '&sect;' ) ) ? '&sect;&sect;' : '§§';
            return '<td>' . $lead . $sym . ' 15-78-110, 15-78-80</td>';
        },
        $text
    );

    return $text;
}

$rows = get_posts( array(
    'post_type'   => array( 'post', 'page', 'resource', 'practice_area', 'location' ),
    'post_status' => 'publish',
    'numberposts' => -1,
    'fields'      => 'ids',
) );

$backups = array();
$total   = 0;

foreach ( $rows as $id ) {
    if ( in_array( $id, $SKIP, true ) ) {
        continue;
    }
    $post = get_post( $id );
    if ( false === strpos( $post->post_content, '15-78-110' ) ) {
        continue;
    }
    if ( false !== strpos( $post->post_content, '15-78-80' ) ) {
        continue; // already cites it somewhere on the page
    }

    $n   = 0;
    $new = roden_tca_fix( $post->post_content, $n );
    if ( ! $n || $new === $post->post_content ) {
        continue;
    }

    printf( "  [%d] %-58s %d edit(s)\n", $id, substr( parse_url( get_permalink( $id ), PHP_URL_PATH ), 0, 58 ), $n );
    $total += $n;

    if ( ! $apply ) {
        continue;
    }
    $backups[ $id ] = array( 'url' => get_permalink( $id ), 'post_content' => $post->post_content );
    wp_update_post( array( 'ID' => $id, 'post_content' => $new ), true );
    update_post_meta( $id, '_roden_last_reviewed', current_time( 'Y-m-d' ) );
    clean_post_cache( $id );
}

printf( "\n%d edit(s) across %d page(s)\n", $total, $apply ? count( $backups ) : 0 );

if ( ! $apply ) {
    echo "\nDry run. Nothing written.\n";
    return;
}
echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\n";

echo "\n--- VERIFY ---\n";
$bad = 0;
foreach ( array_keys( $backups ) as $id ) {
    $c  = get_post( $id )->post_content;
    $ok = ( false !== strpos( $c, '15-78-80' ) )
        && ( false === strpos( $c, '15-78-110, 15-78-80, 15-78-80' ) );
    printf( "  [%d] cites 15-78-80: %-4s no double-insert: %s\n", $id,
        false !== strpos( $c, '15-78-80' ) ? 'yes' : 'NO',
        false === strpos( $c, '15-78-80, 15-78-80' ) ? 'ok' : 'DUPLICATE' );
    if ( ! $ok ) { $bad++; }
}
printf( "\n%d problem(s).\nDone.\n", $bad );
