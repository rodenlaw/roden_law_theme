<?php
/**
 * Moped claim-class remediation — 2026-09-19.
 *
 * Found while verifying the moped statutes for the two moped-law reference pages
 * (data/facts/moped-verification-2026-09-19.md). One page states the rule:
 *
 *   4578 e-bike pillar — an over-threshold e-bike "may be reclassified as
 *        mopeds, requiring title, registration, and insurance" (body) and
 *        "requiring registration and insurance" (_roden_why_hire). S.C. Code
 *        § 56-2-3010: a moped operated on a public highway must be registered
 *        and licensed; "Mopeds are not required to be titled or insured in this
 *        State." Title and insurance claims corrected; the FAQ's bare
 *        "requiring registration" gains the citation.
 *
 * Same cumulative per-surface write path as bin/fix-golf-cart-claims-2.php.
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/fix-moped-claims.php        # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-moped-claims.php  # apply
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — moped claim class, %d edits\n\n", $apply ? 'APPLY' : 'DRY RUN', 3 );

$edits = json_decode( <<<'EDITS'
[
 {
  "ID": 4578,
  "surface": "post_content",
  "before_substr": "E-bikes exceeding the 750W or 20 mph thresholds may be reclassified as mopeds, requiring title, registration, and insurance.",
  "after_substr": "E-bikes exceeding the 750W or 20 mph thresholds may be reclassified as mopeds, which must be registered with the SCDMV but are not required to be titled or insured in South Carolina (S.C. Code § 56-2-3010).",
  "count": 1,
  "kind": "false-statement-of-law"
 },
 {
  "ID": 4578,
  "surface": "_roden_why_hire",
  "before_substr": " E-bikes exceeding these thresholds may be reclassified as mopeds requiring registration and insurance.",
  "after_substr": " E-bikes exceeding these thresholds may be reclassified as mopeds, which must be registered but are not required to be titled or insured (S.C. Code § 56-2-3010).",
  "count": 1,
  "kind": "false-statement-of-law"
 },
 {
  "ID": 4578,
  "surface": "_roden_faqs",
  "index": 1,
  "before": "South Carolina defines e-bikes under S.C. Code § 56-1-10(29) (H.3174, effective February 3, 2020) with a single definition — no class system. An e-bike must have a motor of 750 watts or less and cannot exceed 20 mph on motor power alone. E-bikes meeting this definition are treated as bicycles. Those exceeding the thresholds may be reclassified as mopeds requiring registration. There is no statewide helmet requirement (S.C. Code § 56-5-3520 applies the bicycle rules, which set none).",
  "after": "South Carolina defines e-bikes under S.C. Code § 56-1-10(29) (H.3174, effective February 3, 2020) with a single definition — no class system. An e-bike must have a motor of 750 watts or less and cannot exceed 20 mph on motor power alone. E-bikes meeting this definition are treated as bicycles. Those exceeding the thresholds may be reclassified as mopeds, which must be registered with the SCDMV (S.C. Code § 56-2-3010). There is no statewide helmet requirement (S.C. Code § 56-5-3520 applies the bicycle rules, which set none).",
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
$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'moped-claims', 'mode' => $apply ? 'apply' : 'dry-run', 'note' => 'before/after per surface after ALL edits to that surface. Restore meta with update_post_meta( wp_slash( before ) ); restore bodies by writing before back to wp_posts.post_content.', 'surfaces' => array() );
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
