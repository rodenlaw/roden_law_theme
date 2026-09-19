<?php
/**
 * Helmet citation backfill — 2026-09-19.
 *
 * The Georgia bicycle and e-bike helmet statutes were traced on 2026-09-19
 * (docs/statute-verification-tracker.md, "2026-09-19 helmet pass"). Every
 * uncited statement on these three pages matched the text; this adds the
 * citations. No claim changes. South Carolina e-bike statements on the e-bike
 * pillar gain their citation too (S.C. Code § 56-5-3520, Verified the same day).
 *
 *   4087 /practice-areas/bicycle-accident-lawyers/   body, _roden_faqs[2]
 *   1859 /blog/safe-bike-riding-georgias-roadways/    body, _roden_faqs[2]
 *   4578 /practice-areas/e-bike-accident-lawyers/    body (4 sentences, one of
 *        them twice), _roden_why_hire, _roden_faqs[0], [1], [4]
 *
 * Same guards and write path as bin/fix-helmet-claims.php, with one change that
 * script did not need: several edits land on the SAME surface of the same post
 * (three body edits and three FAQ edits on 4578), so every edit is applied to a
 * running per-surface working copy and each surface is written ONCE. Computing
 * each edit's result from the original and writing them in turn would let the
 * last write erase the earlier ones. Body substrings carry an expected
 * occurrence count; the run aborts on any other count.
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/backfill-helmet-citations.php \
 *     > docs/backups/helmet-citations-$(date +%Y-%m-%d).json          # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/backfill-helmet-citations.php \
 *     > docs/backups/helmet-citations-$(date +%Y-%m-%d).json          # apply
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — helmet citation backfill, %d edits\n\n", $apply ? 'APPLY' : 'DRY RUN', 12 );

$edits = json_decode( <<<'EDITS'
[
 {
  "ID": 4087,
  "surface": "post_content",
  "before_substr": "Georgia requires helmets for riders under 16. South Carolina has no statewide bicycle helmet law.",
  "after_substr": "Georgia requires helmets for riders under 16 (O.C.G.A. § 40-6-296(d)). South Carolina has no statewide bicycle helmet law.",
  "count": 1,
  "kind": "citation-backfill"
 },
 {
  "ID": 4087,
  "surface": "_roden_faqs",
  "index": 2,
  "before": "No. Georgia only requires bicycle helmets for riders under 16, and South Carolina has no statewide bicycle helmet law. Not wearing a helmet does not bar an adult's claim, though it may be raised as comparative fault for head injuries. You can still recover damages.",
  "after": "No. Georgia only requires bicycle helmets for riders under 16 (O.C.G.A. § 40-6-296(d)), and South Carolina has no statewide bicycle helmet law. Not wearing a helmet does not bar an adult's claim, though it may be raised as comparative fault for head injuries. You can still recover damages.",
  "kind": "citation-backfill"
 },
 {
  "ID": 1859,
  "surface": "post_content",
  "before_substr": "Wearing a helmet (required for all riders under 16 years old)",
  "after_substr": "Wearing a helmet (required for all riders under 16 years old under O.C.G.A. § 40-6-296(d))",
  "count": 1,
  "kind": "citation-backfill"
 },
 {
  "ID": 1859,
  "surface": "_roden_faqs",
  "index": 2,
  "before": "A helmet is required for all riders under 16 years old. Older riders are not required to wear one, but it remains the single most effective protection against a catastrophic head injury.",
  "after": "A helmet is required for all riders under 16 years old (O.C.G.A. § 40-6-296(d)). Older riders are not required to wear one, but it remains the single most effective protection against a catastrophic head injury.",
  "kind": "citation-backfill"
 },
 {
  "ID": 4578,
  "surface": "post_content",
  "before_substr": "Helmets are required for all ages on Class III e-bikes, and riders must be at least 15 to operate a Class III.",
  "after_substr": "Helmets are required for all ages on Class III e-bikes, and riders must be at least 15 to operate a Class III (O.C.G.A. § 40-6-303(b)–(c)).",
  "count": 1,
  "kind": "citation-backfill"
 },
 {
  "ID": 4578,
  "surface": "post_content",
  "before_substr": "There is no statewide helmet requirement for e-bike riders.",
  "after_substr": "There is no statewide helmet requirement for e-bike riders (S.C. Code § 56-5-3520 applies the bicycle rules, which set none).",
  "count": 1,
  "kind": "citation-backfill"
 },
 {
  "ID": 4578,
  "surface": "post_content",
  "before_substr": "Helmet required for riders under 16.",
  "after_substr": "Helmet required for riders under 16 (O.C.G.A. § 40-6-296(d), via § 40-6-301).",
  "count": 2,
  "kind": "citation-backfill"
 },
 {
  "ID": 4578,
  "surface": "_roden_why_hire",
  "before_substr": "Georgia requires helmets for all ages on Class III e-bikes and restricts Class III riders to age 15 and older.",
  "after_substr": "Georgia requires helmets for all ages on Class III e-bikes and restricts Class III riders to age 15 and older (O.C.G.A. § 40-6-303).",
  "count": 1,
  "kind": "citation-backfill"
 },
 {
  "ID": 4578,
  "surface": "_roden_faqs",
  "index": 0,
  "before": "Georgia uses a three-class system under O.C.G.A. §§ 40-6-300 through 40-6-303 (effective July 1, 2019). Class I is pedal-assist to 20 mph, Class II adds a throttle (20 mph), and Class III is pedal-assist to 28 mph. All are capped at 750 watts. E-bikes are treated as bicycles — no license, registration, or insurance required. Helmets are required for all ages on Class III e-bikes, and riders must be at least 15 for Class III.",
  "after": "Georgia uses a three-class system under O.C.G.A. §§ 40-6-300 through 40-6-303 (effective July 1, 2019). Class I is pedal-assist to 20 mph, Class II adds a throttle (20 mph), and Class III is pedal-assist to 28 mph. All are capped at 750 watts. E-bikes are treated as bicycles — no license, registration, or insurance required. Helmets are required for all ages on Class III e-bikes, and riders must be at least 15 for Class III (§ 40-6-303(b)–(c)).",
  "kind": "citation-backfill"
 },
 {
  "ID": 4578,
  "surface": "_roden_faqs",
  "index": 1,
  "before": "South Carolina defines e-bikes under S.C. Code § 56-1-10(29) (H.3174, effective February 3, 2020) with a single definition — no class system. An e-bike must have a motor of 750 watts or less and cannot exceed 20 mph on motor power alone. E-bikes meeting this definition are treated as bicycles. Those exceeding the thresholds may be reclassified as mopeds requiring registration. There is no statewide helmet requirement.",
  "after": "South Carolina defines e-bikes under S.C. Code § 56-1-10(29) (H.3174, effective February 3, 2020) with a single definition — no class system. An e-bike must have a motor of 750 watts or less and cannot exceed 20 mph on motor power alone. E-bikes meeting this definition are treated as bicycles. Those exceeding the thresholds may be reclassified as mopeds requiring registration. There is no statewide helmet requirement (S.C. Code § 56-5-3520 applies the bicycle rules, which set none).",
  "kind": "citation-backfill"
 },
 {
  "ID": 4578,
  "surface": "_roden_faqs",
  "index": 4,
  "before": "In Georgia, helmets are required for all ages on Class III e-bikes (28 mph pedal-assist) and for riders under 16 on Class I and II e-bikes. South Carolina has no statewide helmet law for e-bike riders. Not wearing a helmet does not bar your claim in either state, but it may be raised as comparative fault for head injuries.",
  "after": "In Georgia, helmets are required for all ages on Class III e-bikes (28 mph pedal-assist) under O.C.G.A. § 40-6-303(c), and for riders under 16 on Class I and II e-bikes (O.C.G.A. § 40-6-296(d), via § 40-6-301). South Carolina has no statewide helmet law for e-bike riders (S.C. Code § 56-5-3520). Not wearing a helmet does not bar your claim in either state, but it may be raised as comparative fault for head injuries.",
  "kind": "citation-backfill"
 },
 {
  "ID": 4578,
  "surface": "post_content",
  "before_substr": "Helmet required for <strong>all ages</strong>. Minimum rider age of 15.",
  "after_substr": "Helmet required for <strong>all ages</strong>. Minimum rider age of 15 (O.C.G.A. § 40-6-303(b)–(c)).",
  "count": 1,
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
$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'helmet-citations', 'mode' => $apply ? 'apply' : 'dry-run', 'note' => 'before/after per surface after ALL edits to that surface. Restore meta with update_post_meta( wp_slash( before ) ); restore bodies by writing before back to wp_posts.post_content.', 'surfaces' => array() );
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
