<?php
/**
 * Golf-cart claim-class remediation — 2026-09-19.
 *
 * S.C. Code § 56-2-105, the golf-cart section four live pages cited as current
 * law, was REPEALED 2025-05-22 by 2025 Act No. 64 §2 and replaced by § 56-2-90
 * (Act 64 §1). Verified on scstatehouse.gov and the H.3292 bill page; record in
 * data/facts/golf-cart-verification-2026-09-19.md. Owner asked for the fix.
 *
 * Edits (14, seven posts, body and _roden_faqs):
 *   4343 — the § 56-2-105 rules list rewritten to § 56-2-90 (permit, roads, crossing,
 *          age, hours, under-12 belt, ordinances); "does not require liability
 *          insurance" corrected (§ 56-2-90(A)–(B) require proof of it); FAQ 0 and 1.
 *   4364 — two § 56-2-105 sentences → § 56-2-90; "minors under 15" → under 16 (§ 56-2-90(B)).
 *   4754 — two body citations and FAQ 4: § 56-2-105 → § 56-2-90.
 *   4804 — § 56-2-105 → § 56-2-90.
 *   4738 — § 56-2-100 / § 56-3-115 miscitations → § 56-2-90 (golf carts) and
 *          § 56-2-100 (low-speed vehicles); § 56-3-115 is a hearing-loss notation.
 *   4185 — "no comprehensive statewide golf cart statute" → the statute, stated.
 *   4186 — "regulates … through local ordinances" → statewide statute, varied by ordinance.
 *
 * Same cumulative per-surface write path as bin/backfill-helmet-citations.php:
 * every edit lands on a running working copy and each surface is written once.
 * Body substrings carry an expected occurrence count.
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/fix-golf-cart-claims.php \
 *     > docs/backups/golf-cart-claims-$(date +%Y-%m-%d).json          # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-golf-cart-claims.php \
 *     > docs/backups/golf-cart-claims-$(date +%Y-%m-%d).json          # apply
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — golf-cart claim class, %d edits\n\n", $apply ? 'APPLY' : 'DRY RUN', 15 );

$edits = json_decode( <<<'EDITS'
[
 {
  "ID": 4343,
  "surface": "post_content",
  "before_substr": "<p>South Carolina regulates golf cart use on public roads under S.C. Code § 56-2-105:</p>\n\n<ul>\n<li><strong>Permitted roads</strong> — golf carts may be operated on secondary highways and streets within municipalities where the speed limit is <strong>35 mph or less</strong></li>\n<li><strong>Crossing roads</strong> — golf carts may cross highways with speed limits higher than 35 mph at designated crossings</li>\n<li><strong>Operator age</strong> — the operator must be at least <strong>16 years old</strong> and hold a valid driver's license</li>\n<li><strong>Operating hours</strong> — golf carts may be operated on public roads only during <strong>daylight hours</strong> unless equipped with headlights, taillights, turn signals, and a rearview mirror</li>\n<li><strong>Local ordinances</strong> — municipalities and counties may adopt additional regulations; Isle of Palms, Sullivan's Island, Daniel Island, and other Charleston-area communities have specific golf cart ordinances</li>\n</ul>",
  "after_substr": "<p>South Carolina regulates golf cart use on public roads under S.C. Code § 56-2-90 (2025 Act No. 64, effective May 22, 2025, which replaced the former § 56-2-105):</p>\n\n<ul>\n<li><strong>Permit</strong> — the owner must obtain a DMV permit decal and registration certificate, with proof of ownership and proof of liability insurance and a $5 fee, renewed every five years or on a change of address (§ 56-2-90(A))</li>\n<li><strong>Permitted roads</strong> — highways where the speed limit is <strong>35 mph or less</strong>; absent a local ordinance, only secondary highways, and only within four miles of the address on the registration (or of a gated community's entrance) (§ 56-2-90(C)–(D))</li>\n<li><strong>Crossing roads</strong> — golf carts may cross a highway with a speed limit above 35 mph at an intersection (§ 56-2-90(D)(4))</li>\n<li><strong>Operator age</strong> — the operator must be at least <strong>16 years old</strong>, hold a valid driver's license, and carry the registration, proof of insurance and license (§ 56-2-90(B))</li>\n<li><strong>Operating hours</strong> — <strong>daylight hours</strong> only, unless a municipal or county ordinance permits night operation and the cart has working headlights and taillights (§ 56-2-90(C)(2), (D)(1))</li>\n<li><strong>Children</strong> — every passenger under 12 must wear a fastened safety belt (§ 56-2-90(E))</li>\n<li><strong>Local ordinances</strong> — municipalities and counties may set hours, methods and locations within those limits; Isle of Palms, Sullivan's Island, Daniel Island, and other Charleston-area communities have specific golf cart ordinances</li>\n</ul>",
  "count": 1,
  "kind": "repealed-section-cited"
 },
 {
  "ID": 4343,
  "surface": "post_content",
  "before_substr": "<p>Unlike motor vehicles, South Carolina <strong>does not require golf cart owners to carry liability insurance</strong>. This creates a major coverage gap when accidents occur:</p>",
  "after_substr": "<p>South Carolina <strong>does require proof of liability insurance to obtain a golf cart permit</strong> (S.C. Code § 56-2-90(A)), and the operator must carry that proof on the road (§ 56-2-90(B)). Coverage gaps still occur — carts driven without a permit, policies with low limits, and carts kept to private roads that were never permitted:</p>",
  "count": 1,
  "kind": "false-statement-of-law"
 },
 {
  "ID": 4343,
  "surface": "_roden_faqs",
  "index": 0,
  "before": "Yes, with restrictions. Under S.C. Code section 56-2-105, golf carts may be operated on secondary highways and streets within municipalities where the speed limit is 35 mph or less. The operator must be at least 16 years old with a valid driver license. Golf carts may only be operated during daylight hours unless equipped with headlights, taillights, turn signals, and a rearview mirror. Local municipalities may impose additional rules.",
  "after": "Yes, with restrictions. Under S.C. Code § 56-2-90, a permitted golf cart may be operated on highways where the speed limit is 35 mph or less — absent a local ordinance, only on secondary highways and within four miles of the registered address. The operator must be at least 16 years old with a valid driver license. Golf carts may be operated only during daylight hours unless a municipal or county ordinance permits night operation and the cart has working headlights and taillights. Passengers under 12 must wear a seat belt. Local municipalities may impose additional rules.",
  "kind": "repealed-section-cited"
 },
 {
  "ID": 4343,
  "surface": "_roden_faqs",
  "index": 1,
  "before": "No. South Carolina does not require golf cart owners to carry liability insurance, which creates a significant coverage gap when accidents occur. Homeowner insurance may provide some coverage, but it varies by policy. If you are injured by an uninsured golf cart, your own auto policy uninsured motorist coverage may apply. An attorney can help identify all available sources of coverage.",
  "after": "Yes, for road use. A golf cart permit requires proof of liability insurance (S.C. Code § 56-2-90(A)), and the operator must carry proof of insurance while driving (§ 56-2-90(B)). Gaps still occur: carts operated without a permit, low policy limits, and carts kept to private roads. Homeowner insurance may provide some coverage, but it varies by policy. If you are injured by an uninsured golf cart, your own auto policy uninsured motorist coverage may apply. An attorney can help identify all available sources of coverage.",
  "kind": "false-statement-of-law"
 },
 {
  "ID": 4364,
  "surface": "post_content",
  "before_substr": "South Carolina law (S.C. Code Section 56-2-105) permits golf carts on roads with speed limits of 35 miles per hour or less, provided the cart is registered and the operator holds a valid driver's license.",
  "after_substr": "South Carolina law (S.C. Code § 56-2-90, which replaced § 56-2-105 in May 2025) permits golf carts on roads with speed limits of 35 miles per hour or less, provided the cart carries a DMV permit and the operator is at least 16 and holds a valid driver's license.",
  "count": 1,
  "kind": "repealed-section-cited"
 },
 {
  "ID": 4364,
  "surface": "post_content",
  "before_substr": "Yes, under South Carolina law (S.C. Code Section 56-2-105), golf carts may be operated on roads with posted speed limits of 35 miles per hour or less, provided the cart is registered with the SCDMV and the operator has a valid driver's license.",
  "after_substr": "Yes, under South Carolina law (S.C. Code § 56-2-90), golf carts may be operated on roads with posted speed limits of 35 miles per hour or less, provided the cart carries an SCDMV permit decal and the operator is at least 16 with a valid driver's license.",
  "count": 1,
  "kind": "repealed-section-cited"
 },
 {
  "ID": 4364,
  "surface": "post_content",
  "before_substr": "South Carolina law requires the golf cart operator to hold a valid driver's license, meaning minors under 15 cannot legally operate a golf cart on public roads.",
  "after_substr": "South Carolina law requires the golf cart operator to be at least 16 and hold a valid driver's license (S.C. Code § 56-2-90(B)), so anyone under 16 cannot legally operate a golf cart on public roads.",
  "count": 1,
  "kind": "wrong-age-threshold"
 },
 {
  "ID": 4754,
  "surface": "post_content",
  "before_substr": "under S.C. Code Ann. § 56-2-105 — putting",
  "after_substr": "under S.C. Code § 56-2-90 — putting",
  "count": 1,
  "kind": "repealed-section-cited"
 },
 {
  "ID": 4754,
  "surface": "post_content",
  "before_substr": "Street-legal carts on 35-mph roads only (S.C. Code Ann. § 56-2-105)",
  "after_substr": "Street-legal carts on 35-mph roads only (S.C. Code § 56-2-90)",
  "count": 1,
  "kind": "repealed-section-cited"
 },
 {
  "ID": 4754,
  "surface": "_roden_faqs",
  "index": 4,
  "before": "Street-legal, permitted golf carts are allowed only on roads posted 35 mph or under, under S.C. Code Ann. § 56-2-105, which limits where and when they may be driven. Operating a cart outside those limits can affect the fault analysis in a crash, which is one reason these cases benefit from local legal review.",
  "after": "Street-legal, permitted golf carts are allowed only on roads posted 35 mph or under, under S.C. Code § 56-2-90, which limits where and when they may be driven. Operating a cart outside those limits can affect the fault analysis in a crash, which is one reason these cases benefit from local legal review.",
  "kind": "repealed-section-cited"
 },
 {
  "ID": 4804,
  "surface": "post_content",
  "before_substr": "S.C. Code Ann. § 56-2-105 limits where a permitted golf cart may legally be driven on public roads",
  "after_substr": "S.C. Code § 56-2-90 (which replaced § 56-2-105 in May 2025) limits where a permitted golf cart may legally be driven on public roads",
  "count": 1,
  "kind": "repealed-section-cited"
 },
 {
  "ID": 4738,
  "surface": "post_content",
  "before_substr": "South Carolina golf-cart and LSV rules under S.C. Code § 56-2-100 and § 56-3-115 strictly limit where these vehicles can legally operate.",
  "after_substr": "South Carolina's golf-cart rules (S.C. Code § 56-2-90) and low-speed-vehicle rules (§ 56-2-100) strictly limit where these vehicles can legally operate.",
  "count": 1,
  "kind": "miscitation"
 },
 {
  "ID": 4738,
  "surface": "post_content",
  "before_substr": "Roadway eligibility, operator licensure, and permit status under § 56-2-100 and § 56-3-115 control liability.",
  "after_substr": "Roadway eligibility, operator licensure, and permit status under § 56-2-90 (golf carts) and § 56-2-100 (low-speed vehicles) control liability.",
  "count": 1,
  "kind": "miscitation"
 },
 {
  "ID": 4185,
  "surface": "post_content",
  "before_substr": "South Carolina does not have a comprehensive statewide golf cart statute, so regulation falls largely to local ordinances.",
  "after_substr": "South Carolina regulates golf carts statewide under S.C. Code § 56-2-90 — a DMV permit with proof of liability insurance, operators 16 and older with a license, and roads posted 35 mph or less — and lets municipalities and counties adjust hours, locations and night operation by ordinance.",
  "count": 1,
  "kind": "false-statement-of-law"
 },
 {
  "ID": 4186,
  "surface": "post_content",
  "before_substr": "South Carolina regulates golf cart road use through local ordinances, with communities throughout the Lowcountry, Grand Strand, and Midlands having adopted specific golf cart traffic rules.",
  "after_substr": "South Carolina regulates golf cart road use statewide under S.C. Code § 56-2-90, with municipalities and counties adjusting hours, locations and night operation by ordinance — communities throughout the Lowcountry, Grand Strand, and Midlands have adopted specific golf cart traffic rules.",
  "count": 1,
  "kind": "misleading"
 }
]
EDITS
, true );

global $wpdb;
$work = array();   // "$id|$surface" => array( 'id', 'surface', 'before', 'after' )

function &working_copy( &$work, $id, $surface, $err ) {
    $k = $id . '|' . $surface;
    if ( ! isset( $work[ $k ] ) ) {
        $v = ( 'post_content' === $surface ) ? get_post_field( 'post_content', $id ) : get_post_meta( $id, $surface, true );
        $work[ $k ] = array( 'id' => $id, 'surface' => $surface, 'before' => $v, 'after' => $v, 'edits' => 0 );
    }
    return $work[ $k ];
}

/* ---- Resolve every edit against the running working copy before writing any ---- */
foreach ( $edits as $n => $e ) {
    $id = (int) $e['ID']; $p = get_post( $id );
    if ( ! $p instanceof WP_Post || 'publish' !== $p->post_status ) { fprintf( $err, "ABORT: edit %d — post %d missing or not published.\n", $n + 1, $id ); exit( 1 ); }
    $surface = $e['surface'];
    $label   = sprintf( "edit %-2d %-5d %-30s %s", $n + 1, $id, $surface, wp_parse_url( get_permalink( $p ), PHP_URL_PATH ) );
    $w = &working_copy( $work, $id, $surface, $err );

    if ( '_roden_faqs' === $surface ) {
        if ( ! is_array( $w['after'] ) ) { fprintf( $err, "ABORT: %s — _roden_faqs is not an array.\n", $label ); exit( 1 ); }
        $hit = null;
        foreach ( $w['after'] as $i => $q ) { if ( isset( $q['answer'] ) && $q['answer'] === $e['before'] ) { $hit = $i; break; } }
        if ( null === $hit ) {
            foreach ( $w['after'] as $q ) { if ( isset( $q['answer'] ) && $q['answer'] === $e['after'] ) { fprintf( $err, "  skip   %s — already applied\n", $label ); unset( $w ); continue 2; } }
            fprintf( $err, "ABORT: %s — no FAQ answer matches the before text.\n", $label ); exit( 1 );
        }
        $w['after'][ $hit ]['answer'] = $e['after']; $w['edits']++;
        fprintf( $err, "  %s %s [faq #%d]\n", $apply ? 'edit  ' : 'would ', $label, $hit );
        unset( $w ); continue;
    }

    /* post_content and plain string meta: substring with an expected occurrence count */
    $cur  = (string) $w['after'];
    $want = isset( $e['count'] ) ? (int) $e['count'] : 1;
    $have = substr_count( $cur, $e['before_substr'] );
    if ( $have !== $want ) {
        if ( 0 === $have && false !== strpos( $cur, $e['after_substr'] ) ) { fprintf( $err, "  skip   %s — already applied\n", $label ); unset( $w ); continue; }
        fprintf( $err, "ABORT: %s — before text found %d time(s), expected %d.\n", $label, $have, $want ); exit( 1 );
    }
    $w['after'] = str_replace( $e['before_substr'], $e['after_substr'], $cur ); $w['edits']++;
    fprintf( $err, "  %s %s%s\n", $apply ? 'edit  ' : 'would ', $label, $want > 1 ? " [x$want]" : '' );
    unset( $w );
}

/* ---- Backup on stdout: one entry per surface, before and after ---- */
$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'golf-cart-claims', 'mode' => $apply ? 'apply' : 'dry-run', 'note' => 'before/after per surface after ALL edits to that surface. Restore meta with update_post_meta( wp_slash( before ) ); restore bodies by writing before back to wp_posts.post_content.', 'surfaces' => array() );
foreach ( $work as $w ) { if ( $w['edits'] ) { $backup['surfaces'][] = array( 'ID' => $w['id'], 'surface' => $w['surface'], 'edits' => $w['edits'], 'before' => $w['before'], 'after' => $w['after'] ); } }
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$n_edits = array_sum( array_map( function ( $w ) { return $w['edits']; }, $work ) );
if ( ! $apply ) { fprintf( $err, "\nWould apply %d of %d edits across %d surfaces.\n", $n_edits, count( $edits ), count( $backup['surfaces'] ) ); exit( 0 ); }

/* ---- Act: one write per surface ---- */
$touched = array();
foreach ( $work as $w ) {
    if ( ! $w['edits'] ) { continue; }
    if ( 'post_content' === $w['surface'] ) {
        $ok = $wpdb->update( $wpdb->posts, array( 'post_content' => $w['after'] ), array( 'ID' => $w['id'] ), array( '%s' ), array( '%d' ) );
        if ( false === $ok ) { fprintf( $err, "FAILED: body write on %d\n", $w['id'] ); exit( 1 ); }
        clean_post_cache( $w['id'] );
    } else {
        $ok = update_post_meta( $w['id'], $w['surface'], wp_slash( $w['after'] ) );
        if ( false === $ok ) { fprintf( $err, "FAILED: meta write %s on %d\n", $w['surface'], $w['id'] ); exit( 1 ); }
        $rb = get_post_meta( $w['id'], $w['surface'], true );
        if ( $rb !== $w['after'] ) { fprintf( $err, "FAILED: read-back mismatch on %d %s — check slashing.\n", $w['id'], $w['surface'] ); exit( 1 ); }
    }
    $touched[ $w['id'] ] = true;
}
foreach ( array_keys( $touched ) as $id ) { update_post_meta( $id, '_roden_last_refreshed', '2026-09-19' ); }
fprintf( $err, "\nApplied %d edits across %d surfaces on %d posts. Next: flush caches, check the live pages, run bin/check-unslashed-post-writes.php, regenerate content/meta.json.\n", $n_edits, count( $backup['surfaces'] ), count( $touched ) );
