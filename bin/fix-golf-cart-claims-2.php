<?php
/**
 * Golf-cart claim-class remediation, round 2 — 2026-09-19.
 *
 * Found by the writer of /resources/south-carolina-golf-cart-laws/ while reading
 * the eight pages that state the rule, and confirmed against scstatehouse.gov:
 *
 *   4090 pillar, _roden_faqs[4] — "neither Georgia nor South Carolina currently
 *        requires [seatbelts]". § 56-2-90(E) (eff 2025-05-22): every passenger
 *        under 12 wears a fastened belt on public roads. Georgia claim dropped
 *        (not read). Publishes as FAQPage structured data.
 *   4343 body — "a cart modified to exceed 20 mph may have effectively created an
 *        unregistered, uninsured LSV". § 56-2-120(A): the State issues no VIN to
 *        retrofitted golf carts and they do not qualify as LSVs. Inverted.
 *   4343 body — golf cart vs LSV table: golf-cart registration "not required",
 *        insurance "not required by state law" (both false under § 56-2-90(A)),
 *        speeds and equipment uncited. Rewritten with the sections.
 *   4343 _roden_faqs[4] — same table content as prose; same corrections, with
 *        the LSV definition from § 56-1-10.
 *   4754 body — Surfside Beach's road permission attributed to the state
 *        statute; the 35 mph cap is statutory, the local permission is the
 *        town's. Reworded.
 *
 * Same cumulative per-surface write path as bin/fix-golf-cart-claims.php.
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/fix-golf-cart-claims-2.php \
 *     > docs/backups/golf-cart-claims-2-$(date +%Y-%m-%d).json          # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-golf-cart-claims-2.php \
 *     > docs/backups/golf-cart-claims-2-$(date +%Y-%m-%d).json          # apply
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — golf-cart claim class round 2, %d edits\n\n", $apply ? 'APPLY' : 'DRY RUN', 5 );

$edits = json_decode( <<<'EDITS'
[
 {
  "ID": 4090,
  "surface": "_roden_faqs",
  "index": 4,
  "before": "Most standard golf carts do not have seatbelts, and neither Georgia nor South Carolina currently requires them for traditional golf carts. However, Low-Speed Vehicles (LSVs) — which look similar but meet higher safety standards — are required to have seatbelts. The absence of safety features is relevant in product liability claims.",
  "after": "Most standard golf carts are not built with seatbelts, and South Carolina law does not require a golf cart to be equipped with them. It does require every passenger under 12 to wear a fastened safety belt when the cart is on a public street or highway (S.C. Code § 56-2-90(E), effective May 22, 2025), so a cart that carries children on the road needs them. Low-Speed Vehicles (LSVs) — which look similar but meet higher safety standards — are required to have seatbelts. The absence of safety features is relevant in product liability claims.",
  "kind": "false-statement-of-law"
 },
 {
  "ID": 4343,
  "surface": "post_content",
  "before_substr": "A golf cart owner who modifies the cart to exceed 20 mph may have effectively created an unregistered, uninsured LSV, creating additional liability exposure.",
  "after_substr": "A golf cart modified to run faster does not become an LSV: South Carolina issues no vehicle identification number to retrofitted golf carts, and they do not qualify as low-speed vehicles (S.C. Code § 56-2-120(A)). A modified cart is simply an unlawful vehicle on the road, which creates its own liability exposure for the owner.",
  "count": 1,
  "kind": "false-statement-of-law"
 },
 {
  "ID": 4343,
  "surface": "post_content",
  "before_substr": "<table class=\"comparison-table\">\n<thead>\n<tr>\n<th>Feature</th>\n<th>Golf Cart</th>\n<th>Low-Speed Vehicle (LSV)</th>\n</tr>\n</thead>\n<tbody>\n<tr>\n<td>Maximum speed</td>\n<td>Under 20 mph</td>\n<td>20-25 mph</td>\n</tr>\n<tr>\n<td>Safety equipment required</td>\n<td>Minimal (lights if driven after dark)</td>\n<td>Headlights, taillights, turn signals, mirrors, seatbelts, windshield, VIN</td>\n</tr>\n<tr>\n<td>Registration</td>\n<td>Not required (permit may be required locally)</td>\n<td>Must be titled and registered with SCDMV</td>\n</tr>\n<tr>\n<td>Insurance</td>\n<td>Not required by state law</td>\n<td>Must carry liability insurance</td>\n</tr>\n<tr>\n<td>Road access</td>\n<td>Roads with speed limits of 35 mph or less</td>\n<td>Roads with speed limits of 35 mph or less</td>\n</tr>\n</tbody>\n</table>",
  "after_substr": "<table class=\"comparison-table\">\n<thead>\n<tr>\n<th>Feature</th>\n<th>Golf Cart</th>\n<th>Low-Speed Vehicle (LSV)</th>\n</tr>\n</thead>\n<tbody>\n<tr>\n<td>Speed</td>\n<td>No statutory speed definition; typically under 20 mph</td>\n<td>More than 20 and not more than 25 mph (S.C. Code § 56-1-10)</td>\n</tr>\n<tr>\n<td>Safety equipment required</td>\n<td>Working headlights and taillights for night operation where a local ordinance permits it (§ 56-2-90(C)(2))</td>\n<td>Headlights, taillights, turn signals, mirrors, seatbelts, windshield, VIN — federal standard FMVSS 500 (§ 56-2-100(C))</td>\n</tr>\n<tr>\n<td>Permit and registration</td>\n<td>DMV permit decal and registration certificate, $5, renewed every five years (§ 56-2-90(A))</td>\n<td>Must be titled and registered with SCDMV (§ 56-2-120)</td>\n</tr>\n<tr>\n<td>Insurance</td>\n<td>Proof of liability insurance required for the permit, carried by the operator (§ 56-2-90(A)–(B))</td>\n<td>Must carry liability insurance (§ 56-2-120(C))</td>\n</tr>\n<tr>\n<td>Road access</td>\n<td>Roads posted 35 mph or less; absent a local ordinance, secondary highways within four miles of the registered address (§ 56-2-90(C)–(D))</td>\n<td>Roads posted 35 mph or less (§ 56-2-100(A))</td>\n</tr>\n</tbody>\n</table>",
  "count": 1,
  "kind": "false-statement-of-law"
 },
 {
  "ID": 4343,
  "surface": "_roden_faqs",
  "index": 4,
  "before": "Golf carts have a maximum speed under 20 mph and require minimal safety equipment. Low-speed vehicles (LSVs) travel 20-25 mph and must have headlights, taillights, turn signals, mirrors, seatbelts, a windshield, and a VIN. LSVs must be titled, registered, and carry liability insurance. The distinction matters for liability because an LSV without required safety equipment may create additional manufacturer and owner liability.",
  "after": "South Carolina law does not define a golf cart by speed; in practice they run under 20 mph. A low-speed vehicle (LSV) is a four-wheeled vehicle whose top speed is more than 20 and not more than 25 mph (S.C. Code § 56-1-10). It must meet federal standard FMVSS 500 — headlights, taillights, turn signals, mirrors, seatbelts, a windshield and a VIN — and be titled, registered and insured like a car (§§ 56-2-100, 56-2-120). A retrofitted golf cart cannot become an LSV: the state issues it no VIN (§ 56-2-120(A)). The distinction matters for liability because an LSV without required safety equipment may create additional manufacturer and owner liability.",
  "kind": "false-statement-of-law"
 },
 {
  "ID": 4754,
  "surface": "post_content",
  "before_substr": "<li>Surfside Beach permits street-legal golf carts only on roads posted <strong>35 mph or under</strong>, under S.C. Code § 56-2-90 — putting permitted carts directly into the US-17 Business and Glenns Bay Road traffic mix.</li>",
  "after_substr": "<li>Under S.C. Code § 56-2-90, permitted golf carts may use only roads posted <strong>35 mph or under</strong>, and Surfside Beach allows them on its qualifying streets — putting permitted carts directly into the US-17 Business and Glenns Bay Road traffic mix.</li>",
  "count": 1,
  "kind": "misattributed-rule"
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
$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'golf-cart-claims-2', 'mode' => $apply ? 'apply' : 'dry-run', 'note' => 'before/after per surface after ALL edits to that surface. Restore meta with update_post_meta( wp_slash( before ) ); restore bodies by writing before back to wp_posts.post_content.', 'surfaces' => array() );
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
