<?php
/**
 * Enumerate every statutory citation on the site, across all four surfaces.
 *
 *   ssh $H "wp --path=... eval-file -" < bin/inventory-statute-citations.php
 *
 * Read-only. This is the input to a verification sweep, not the sweep itself:
 * you cannot verify what you have not enumerated, and every accuracy incident on
 * this site so far was found by accident rather than by looking.
 *
 * Reads post_content, post_excerpt, _roden_faqs, _roden_key_takeaways,
 * _roden_meta_description, _roden_sol_ga and _roden_sol_sc — the surfaces
 * CLAUDE.md names, because a claim that lives in one usually lives in more.
 */

$rows = get_posts( array(
    'post_type'   => array( 'post', 'page', 'resource', 'practice_area', 'location' ),
    'post_status' => 'publish',
    'numberposts' => -1,
    'fields'      => 'ids',
) );

// O.C.G.A. § 9-3-33 / OCGA 51-12-33 / S.C. Code § 15-3-530 / S.C. Code Ann. § 56-5-6460
$RE = '/\b(O\.?C\.?G\.?A\.?|S\.?C\.?\s*Code(?:\s*Ann\.?)?)\s*(?:&sect;|§|Section)?\s*([0-9]+-[0-9]+-[0-9]+(?:\.[0-9]+)?(?:\([a-z0-9]+\))*)/i';

$cites = array();   // "GA 40-8-76" => array( 'pages' => [ids], 'surfaces' => [names] )
$scanned = 0;

foreach ( $rows as $id ) {
    $p = get_post( $id );
    $scanned++;

    $faqs = maybe_unserialize( get_post_meta( $id, '_roden_faqs', true ) );
    if ( is_string( $faqs ) ) {
        $d = json_decode( $faqs, true );
        if ( is_array( $d ) ) {
            $faqs = $d;
        }
    }

    $surfaces = array(
        'post_content'           => $p->post_content,
        'post_excerpt'           => $p->post_excerpt,
        '_roden_faqs'            => is_array( $faqs ) ? wp_json_encode( $faqs ) : (string) $faqs,
        '_roden_key_takeaways'   => (string) get_post_meta( $id, '_roden_key_takeaways', true ),
        '_roden_meta_description'=> (string) get_post_meta( $id, '_roden_meta_description', true ),
        '_roden_sol_ga'          => (string) get_post_meta( $id, '_roden_sol_ga', true ),
        '_roden_sol_sc'          => (string) get_post_meta( $id, '_roden_sol_sc', true ),
    );

    foreach ( $surfaces as $name => $text ) {
        if ( ! $text ) {
            continue;
        }
        if ( ! preg_match_all( $RE, $text, $m, PREG_SET_ORDER ) ) {
            continue;
        }
        foreach ( $m as $hit ) {
            $state = ( 0 === stripos( $hit[1], 'O' ) ) ? 'GA' : 'SC';
            $key   = $state . ' ' . preg_replace( '/\([a-z0-9]+\)/i', '', $hit[2] );
            if ( ! isset( $cites[ $key ] ) ) {
                $cites[ $key ] = array( 'pages' => array(), 'surfaces' => array() );
            }
            $cites[ $key ]['pages'][ $id ]        = true;
            $cites[ $key ]['surfaces'][ $name ]   = true;
        }
    }
}

uasort( $cites, function ( $a, $b ) {
    return count( $b['pages'] ) <=> count( $a['pages'] );
} );

echo "pages scanned: $scanned\n";
echo "distinct statutes cited: " . count( $cites ) . "\n\n";
printf( "%-22s %6s  %s\n", 'CITATION', 'PAGES', 'SURFACES' );
foreach ( $cites as $key => $c ) {
    printf( "%-22s %6d  %s\n", $key, count( $c['pages'] ), implode( ',', array_keys( $c['surfaces'] ) ) );
}

// Meta-only citations are the dangerous ones: a body sweep never sees them.
echo "\n--- cited ONLY in meta, never in a body (invisible to a post_content sweep) ---\n";
$metaonly = 0;
foreach ( $cites as $key => $c ) {
    $s = array_keys( $c['surfaces'] );
    if ( ! in_array( 'post_content', $s, true ) ) {
        printf( "  %-22s %3d pages  [%s]\n", $key, count( $c['pages'] ), implode( ',', $s ) );
        $metaonly++;
    }
}
echo "  count: $metaonly\n";
