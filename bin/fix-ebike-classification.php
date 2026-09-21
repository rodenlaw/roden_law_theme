<?php
/**
 * E-bike classification precision — 2026-09-21.
 *
 * The e-bike pillar (4578) made speed the trigger for an e-bike becoming a
 * moped and offered "a moped or motor vehicle" as alternatives. The statutes
 * hinge on motor power: Georgia's e-bike is a motor of 750 W or less
 * (O.C.G.A. § 40-1-1(15.3)); its moped is a motor driven cycle of at most 2
 * brake horsepower, unassisted top speed 30 mph or less, automatic drive
 * (§ 40-1-1(28)), and a moped IS a motor vehicle there (§ 40-1-1(33) excludes
 * e-bikes but not mopeds; § 40-1-1(29) excludes mopeds from "motorcycle").
 * South Carolina's moped is a motor over 750 W up to 1,500 W (S.C. Code
 * § 56-1-10(26)); a 750 W bike whose motor alone exceeds 20 mph is outside the
 * e-bike definition (§ 56-1-10(29)) without becoming a moped.
 *
 * Five edits, three surfaces, one post. Same cumulative write path as
 * bin/fix-moped-claims.php. Record: data/facts/moped-verification-2026-09-19.md.
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/fix-ebike-classification.php        # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-ebike-classification.php  # apply
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — e-bike classification, %d edits\n\n", $apply ? 'APPLY' : 'DRY RUN', 5 );

$edits = json_decode( <<<'EDITS'
[
 {
  "ID": 4578,
  "surface": "post_content",
  "before_substr": "E-bikes exceeding the 750W or 20 mph thresholds may be reclassified as mopeds, which must be registered with the SCDMV but are not required to be titled or insured in South Carolina (S.C. Code § 56-2-3010).",
  "after_substr": "An e-bike with a motor over 750 watts, up to 1,500 watts, is a moped under South Carolina law (S.C. Code § 56-1-10(26)) — registered with the SCDMV but not required to be titled or insured (S.C. Code § 56-2-3010). A 750-watt bike whose motor alone exceeds 20 mph falls outside the e-bike definition without becoming a moped.",
  "count": 1,
  "kind": "imprecise-classification"
 },
 {
  "ID": 4578,
  "surface": "post_content",
  "before_substr": "An e-bike that exceeds either threshold — for example, a modified Class III capable of 28 mph — could be reclassified as a moped under South Carolina law, fundamentally changing the legal framework for a crash claim.",
  "after_substr": "An e-bike fitted with a bigger motor — for example, a 1,000-watt conversion — is a moped under South Carolina law rather than a bicycle, fundamentally changing the legal framework for a crash claim.",
  "count": 1,
  "kind": "imprecise-classification"
 },
 {
  "ID": 4578,
  "surface": "_roden_why_hire",
  "before_substr": "E-bikes exceeding these thresholds may be reclassified as mopeds, which must be registered but are not required to be titled or insured (S.C. Code § 56-2-3010).",
  "after_substr": "An e-bike with a motor over 750 watts, up to 1,500 watts, is a moped (S.C. Code § 56-1-10(26)) — registered but not required to be titled or insured (S.C. Code § 56-2-3010).",
  "count": 1,
  "kind": "imprecise-classification"
 },
 {
  "ID": 4578,
  "surface": "_roden_faqs",
  "index": 1,
  "before": "South Carolina defines e-bikes under S.C. Code § 56-1-10(29) (H.3174, effective February 3, 2020) with a single definition — no class system. An e-bike must have a motor of 750 watts or less and cannot exceed 20 mph on motor power alone. E-bikes meeting this definition are treated as bicycles. Those exceeding the thresholds may be reclassified as mopeds, which must be registered with the SCDMV (S.C. Code § 56-2-3010). There is no statewide helmet requirement (S.C. Code § 56-5-3520 applies the bicycle rules, which set none).",
  "after": "South Carolina defines e-bikes under S.C. Code § 56-1-10(29) (H.3174, effective February 3, 2020) with a single definition — no class system. An e-bike must have a motor of 750 watts or less and cannot exceed 20 mph on motor power alone. E-bikes meeting this definition are treated as bicycles. A bike with a motor over 750 watts, up to 1,500 watts, is a moped instead (S.C. Code § 56-1-10(26)), which must be registered with the SCDMV but not titled or insured (S.C. Code § 56-2-3010); a 750-watt bike whose motor alone exceeds 20 mph is outside the e-bike definition without being a moped. There is no statewide helmet requirement (S.C. Code § 56-5-3520 applies the bicycle rules, which set none).",
  "kind": "imprecise-classification"
 },
 {
  "ID": 4578,
  "surface": "_roden_faqs",
  "index": 3,
  "before": "No. In both Georgia and South Carolina, e-bikes that meet the statutory definitions are classified as bicycles, not motor vehicles. No driver's license, registration, or insurance is required. However, if your e-bike exceeds the legal definition (750W or speed limits), it may be reclassified as a moped or motor vehicle.",
  "after": "No. In both Georgia and South Carolina, e-bikes that meet the statutory definitions are classified as bicycles, not motor vehicles. No driver's license, registration, or insurance is required. If your e-bike exceeds the statutory definition, it is no longer treated as a bicycle. In Georgia a motor of more than 750 watts takes it out of the e-bike definition (O.C.G.A. § 40-1-1(15.3)); it is a moped if the motor is 2 brake horsepower or less, the unassisted top speed is 30 mph or less and the drive is automatic (O.C.G.A. § 40-1-1(28)), and a motorcycle above that — and a moped is a motor vehicle in Georgia (O.C.G.A. § 40-1-1(33)), so licence and helmet rules apply. In South Carolina a motor over 750 watts and up to 1,500 watts makes it a moped (S.C. Code § 56-1-10(26)); above 1,500 watts it is outside the moped definition too.",
  "kind": "imprecise-classification"
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
$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'ebike-classification', 'mode' => $apply ? 'apply' : 'dry-run', 'note' => 'before/after per surface after ALL edits to that surface. Restore meta with update_post_meta( wp_slash( before ) ); restore bodies by writing before back to wp_posts.post_content.', 'surfaces' => array() );
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
