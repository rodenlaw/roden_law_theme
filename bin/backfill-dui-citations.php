<?php
/**
 * DUI citations for mopeds and golf carts — 2026-09-21.
 *
 * Both DUI sections were unreadable on 2026-09-19 (the fetch tool truncates the
 * 696 KB South Carolina chapter page; the writer's environment could not reach
 * FindLaw) so the moped and golf-cart pages stated the rule in words or left it
 * out. Read 2026-09-21: O.C.G.A. § 40-6-391(a) forbids driving "any moving
 * vehicle" impaired — no definitional chain needed; S.C. Code § 56-5-2930(A)
 * forbids driving "a motor vehicle" impaired, and a moped is "defined as a motor
 * vehicle" (§ 56-1-10(26)) while a golf cart is self-propelled and therefore one
 * under § 56-1-10(7). The chapter confirms the reading: the interlock provisions
 * carve out "a moped or motorcycle" by name (2017 Act No. 89 §34).
 *
 * Seven edits, four posts: 6315 (GA moped) table row + takeaway; 6316 (SC moped)
 * body + takeaway; 6314 (SC golf cart) body; 4189 (golf-cart DUI sub-type) body
 * + FAQ 0. Same cumulative write path as bin/fix-ebike-classification.php.
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/backfill-dui-citations.php        # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/backfill-dui-citations.php  # apply
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — DUI citations, %d edits\n\n", $apply ? 'APPLY' : 'DRY RUN', 7 );

$edits = json_decode( <<<'EDITS'
[
 {
  "ID": 6315,
  "surface": "post_content",
  "before_substr": "<td>§ 40-6-350</td></tr>",
  "after_substr": "<td>§ 40-6-350</td></tr><tr><td>DUI</td><td>Georgia's DUI statute reaches \"any moving vehicle\", so it applies to a moped rider</td><td>§ 40-6-391(a)</td></tr>",
  "count": 1,
  "kind": "citation-backfill"
 },
 {
  "ID": 6315,
  "surface": "_roden_key_takeaways",
  "before_substr": "A moped operator carries any other Georgia driver's rights and duties — <strong>§ 40-6-350</strong>.",
  "after_substr": "A moped operator carries any other Georgia driver's rights and duties — <strong>§ 40-6-350</strong> — including the DUI law, which reaches any moving vehicle — <strong>§ 40-6-391(a)</strong>.",
  "count": 1,
  "kind": "citation-backfill"
 },
 {
  "ID": 6316,
  "surface": "post_content",
  "before_substr": "state traffic laws apply to the rider, including DUI — and an adjuster",
  "after_substr": "state traffic laws apply to the rider, including DUI (S.C. Code § 56-5-2930) — and an adjuster",
  "count": 1,
  "kind": "citation-backfill"
 },
 {
  "ID": 6316,
  "surface": "_roden_key_takeaways",
  "before_substr": "so state traffic laws — including DUI — apply — S.C. Code § 56-1-10(26).",
  "after_substr": "so state traffic laws — including DUI, S.C. Code § 56-5-2930 — apply — S.C. Code § 56-1-10(26).",
  "count": 1,
  "kind": "citation-backfill"
 },
 {
  "ID": 6314,
  "surface": "post_content",
  "before_substr": "and it does not excuse the driver who ran the stop sign.</p>",
  "after_substr": "and it does not excuse the driver who ran the stop sign. Because a golf cart is self-propelled it is a motor vehicle under S.C. Code § 56-1-10(7), and South Carolina's DUI statute (§ 56-5-2930) applies to anyone driving one on a public road.</p>",
  "count": 1,
  "kind": "citation-backfill"
 },
 {
  "ID": 4189,
  "surface": "post_content",
  "before_substr": "<p>South Carolina's DUI law similarly applies to golf cart operation.",
  "after_substr": "<p>South Carolina's DUI law (S.C. Code § 56-5-2930) similarly applies to golf cart operation: the statute reaches any motor vehicle, and a golf cart, being self-propelled, is one under S.C. Code § 56-1-10(7).",
  "count": 1,
  "kind": "citation-backfill"
 },
 {
  "ID": 4189,
  "surface": "_roden_faqs",
  "index": 0,
  "before": "Yes. Georgia's DUI statute (O.C.G.A. § 40-6-391) and South Carolina's DUI law both apply to golf carts operated on public roads and in publicly accessible areas. The legal BAC limit of 0.08% applies the same as for car drivers.",
  "after": "Yes. Georgia's DUI statute (O.C.G.A. § 40-6-391) and South Carolina's (S.C. Code § 56-5-2930) both apply to golf carts operated on public roads and in publicly accessible areas. The legal BAC limit of 0.08% applies the same as for car drivers.",
  "kind": "citation-backfill"
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
$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'dui-citations', 'mode' => $apply ? 'apply' : 'dry-run', 'note' => 'before/after per surface after ALL edits to that surface. Restore meta with update_post_meta( wp_slash( before ) ); restore bodies by writing before back to wp_posts.post_content.', 'surfaces' => array() );
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
foreach ( array_keys( $touched ) as $id ) { update_post_meta( $id, '_roden_last_refreshed', '2026-09-21' ); }
fprintf( $err, "\nApplied %d edits across %d surfaces on %d posts. Next: flush caches, check the live pages, run bin/check-unslashed-post-writes.php, regenerate content/meta.json.\n", $n_edits, count( $backup['surfaces'] ), count( $touched ) );
