<?php
/**
 * Helmet claim-class remediation — 2026-09-19.
 *
 * Triggered by the two helmet-law drafts (content-plan/2026-10.md, entries 1a/1b),
 * whose writers read the 20 pages carrying helmet claims and filed divergences.
 * A sweep of every published post across post_content, _roden_faqs,
 * _roden_key_takeaways, post_excerpt AND every other post-meta key found 175
 * helmet sentences on 51 pages plus 22 meta rows on four more surfaces
 * (_roden_common_injuries, _roden_why_hire, _roden_pillar_negligence_intro,
 * _roden_common_causes). Most are descriptive or already frame helmet non-use
 * as an insurer argument and are untouched. These are the edits:
 *
 *  1. 3607 motorcycle pillar, _roden_common_injuries[1].description — "Georgia
 *     does not require helmets for riders over 18". FALSE: O.C.G.A. § 40-6-315
 *     is universal (Verified table, pass 4), and the same page's FAQ and
 *     negligence intro say so. Lived on a FIFTH surface no sweep read.
 *  2. 4087 bicycle pillar, _roden_faqs[2] — "South Carolina has no statewide
 *     helmet law", unqualified on a page whose motorcycle sibling states the
 *     under-21 rule. True for bicycles only; qualified.
 *  3. 4087 bicycle pillar, _roden_pillar_negligence_intro — same sentence,
 *     same fix.
 *  4. 4088 e-scooter pillar, post_content — "local ordinances governing …
 *     helmet requirements". Unsourced; the SC writer found no municipal helmet
 *     ordinance on 2026-09-19. Trace-or-omit: omitted, logged for the attorney.
 *  5. 4088 e-scooter pillar, _roden_faqs[4] — "Some South Carolina
 *     municipalities require helmets for scooter riders." Same; sentence cut.
 *  6. 1667 blog, post_content — "Failure to wear a helmet can be used as
 *     evidence of comparative fault for head injuries." Neither statute says
 *     anything about evidence; reframed as the insurer's argument.
 *  7. 1667 blog, _roden_faqs[4] — same sentence, same reframe.
 *  8. 4644 blog, _roden_key_takeaways — "riders over 21" → "riders 21 and
 *     older": § 56-5-3660 reaches riders UNDER 21, so a 21-year-old is exempt.
 *
 * Every edit is guarded on the exact current text and aborts on a mismatch.
 * Meta writes go through update_post_meta( wp_slash( … ) ) — it unslashes.
 * The body write is a direct column update, no post_modified stamp, per the
 * reasoning in apply-stat-remediation.php. Sets _roden_last_refreshed.
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/fix-helmet-claims.php \
 *     > docs/backups/helmet-claims-$(date +%Y-%m-%d).json          # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-helmet-claims.php \
 *     > docs/backups/helmet-claims-$(date +%Y-%m-%d).json          # apply
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — helmet claim class, 9 edits\n\n", $apply ? 'APPLY' : 'DRY RUN' );

$reframe = 'Insurers may argue that not wearing a helmet contributed to head injuries; that is a comparative-fault argument they have to prove, not an automatic reduction.';

$edits = array(
    array(
        'ID' => 3607, 'surface' => '_roden_common_injuries', 'index' => 1, 'field' => 'description',
        'before' => 'Even with a helmet, the violent forces in a motorcycle crash can cause concussions, skull fractures, and severe TBI. Georgia does not require helmets for riders over 18, increasing the risk of catastrophic head trauma.',
        'after'  => 'Even with a helmet, the violent forces in a motorcycle crash can cause concussions, skull fractures, and severe TBI. Georgia requires every motorcycle rider and passenger to wear a helmet (O.C.G.A. § 40-6-315), and a helmet reduces, but does not remove, the risk of catastrophic head trauma.',
        'kind' => 'false-statement-of-law',
    ),
    array(
        'ID' => 4087, 'surface' => '_roden_faqs', 'index' => 2,
        'before' => "No. Georgia only requires helmets for riders under 16, and South Carolina has no statewide helmet law. Not wearing a helmet does not bar an adult's claim, though it may be raised as comparative fault for head injuries. You can still recover damages.",
        'after'  => "No. Georgia only requires bicycle helmets for riders under 16, and South Carolina has no statewide bicycle helmet law. Not wearing a helmet does not bar an adult's claim, though it may be raised as comparative fault for head injuries. You can still recover damages.",
        'kind' => 'unqualified-statement',
    ),
    array(
        'ID' => 4087, 'surface' => '_roden_pillar_negligence_intro',
        'before_substr' => '{{/GA}}{{SC}}South Carolina has no statewide helmet requirement. {{/SC}}',
        'after_substr'  => '{{/GA}}{{SC}}South Carolina has no statewide bicycle helmet requirement. {{/SC}}',
        'kind' => 'unqualified-statement',
    ),
    array(
        'ID' => 4088, 'surface' => 'post_content',
        'before_substr' => 'local ordinances governing speed limits, parking, riding areas, and helmet requirements.',
        'after_substr'  => 'local ordinances governing speed limits, parking, and riding areas.',
        'kind' => 'unsourced-claim-omitted',
    ),
    array(
        'ID' => 4088, 'surface' => '_roden_faqs', 'index' => 4,
        'before' => 'Georgia does not require helmets for adult e-scooter riders, but strongly recommends them. Some South Carolina municipalities require helmets for scooter riders. Not wearing a helmet does not bar your claim, but may be raised as comparative fault for head injuries.',
        'after'  => 'Georgia does not require helmets for adult e-scooter riders, but strongly recommends them. Not wearing a helmet does not bar your claim, but may be raised as comparative fault for head injuries.',
        'kind' => 'unsourced-claim-omitted',
    ),
    array(
        'ID' => 1667, 'surface' => 'post_content',
        'before_substr' => 'Failure to wear a helmet can be used as evidence of comparative fault for head injuries.</li>',
        'after_substr'  => $reframe . '</li>',
        'kind' => 'evidentiary-claim-reframed',
    ),
    array(
        'ID' => 1667, 'surface' => '_roden_faqs', 'index' => 4,
        'before' => 'Yes. Georgia requires all motorcycle riders and passengers to wear helmets (O.C.G.A. § 40-6-315). Failure to wear a helmet can be used as evidence of comparative fault for head injuries, potentially reducing your compensation. South Carolina only requires helmets for riders under 21.',
        'after'  => 'Yes. Georgia requires all motorcycle riders and passengers to wear helmets (O.C.G.A. § 40-6-315). ' . $reframe . ' South Carolina only requires helmets for riders under 21.',
        'kind' => 'evidentiary-claim-reframed',
    ),
    array(
        // Edit 9, found by the post-apply re-sweep of every meta key: the same
        // unsourced municipal-helmet claim on a THIRD surface of the e-scooter
        // pillar. "Differ on … helmet requirements" asserts that some require one.
        'ID' => 4088, 'surface' => '_roden_pillar_negligence_intro',
        'before_substr' => 'differ on speed limits, geofencing, sidewalk use, and helmet requirements.',
        'after_substr'  => 'differ on speed limits, geofencing, and sidewalk use.',
        'kind' => 'unsourced-claim-omitted',
    ),
    array(
        'ID' => 4644, 'surface' => '_roden_key_takeaways',
        'before_substr' => 'South Carolina does not require helmets for riders over 21 but comparative fault applies',
        'after_substr'  => 'South Carolina does not require helmets for riders 21 and older but comparative fault applies',
        'kind' => 'imprecise-age-threshold',
    ),
);

global $wpdb;
$plan = array();

/* ---- Resolve every edit against live content before writing any ---- */
foreach ( $edits as $n => $e ) {
    $id = (int) $e['ID']; $p = get_post( $id );
    if ( ! $p instanceof WP_Post || 'publish' !== $p->post_status ) { fprintf( $err, "ABORT: edit %d — post %d missing or not published.\n", $n + 1, $id ); exit( 1 ); }
    $surface = $e['surface'];
    $label   = sprintf( "edit %d  %-5d %-30s %s", $n + 1, $id, $surface, wp_parse_url( get_permalink( $p ), PHP_URL_PATH ) );

    if ( 'post_content' === $surface ) {
        $cur = $p->post_content;
        if ( substr_count( $cur, $e['before_substr'] ) !== 1 ) {
            if ( false !== strpos( $cur, $e['after_substr'] ) ) { fprintf( $err, "  skip   %s — already applied\n", $label ); continue; }
            fprintf( $err, "ABORT: %s — before text not found exactly once.\n", $label ); exit( 1 );
        }
        $new = str_replace( $e['before_substr'], $e['after_substr'], $cur );
        $plan[] = array( 'edit' => $e, 'label' => $label, 'write' => 'body', 'id' => $id, 'before' => $cur, 'after' => $new );
        fprintf( $err, "  %s %s\n", $apply ? 'edit  ' : 'would ', $label );
        continue;
    }

    $raw = get_post_meta( $id, $surface, true );

    if ( '_roden_faqs' === $surface ) {
        if ( ! is_array( $raw ) ) { fprintf( $err, "ABORT: %s — _roden_faqs is not an array.\n", $label ); exit( 1 ); }
        $hit = null;
        foreach ( $raw as $i => $q ) { if ( isset( $q['answer'] ) && $q['answer'] === $e['before'] ) { $hit = $i; break; } }
        if ( null === $hit ) {
            foreach ( $raw as $q ) { if ( isset( $q['answer'] ) && $q['answer'] === $e['after'] ) { fprintf( $err, "  skip   %s — already applied\n", $label ); continue 2; } }
            fprintf( $err, "ABORT: %s — no FAQ answer matches the before text.\n", $label ); exit( 1 );
        }
        $new = $raw; $new[ $hit ]['answer'] = $e['after'];
        $plan[] = array( 'edit' => $e, 'label' => $label, 'write' => 'meta', 'id' => $id, 'key' => $surface, 'before' => $raw, 'after' => $new );
        fprintf( $err, "  %s %s [faq #%d]\n", $apply ? 'edit  ' : 'would ', $label, $hit );
        continue;
    }

    if ( '_roden_common_injuries' === $surface ) {
        if ( ! is_array( $raw ) ) { fprintf( $err, "ABORT: %s — not an array.\n", $label ); exit( 1 ); }
        $hit = null;
        foreach ( $raw as $i => $row ) { if ( isset( $row[ $e['field'] ] ) && $row[ $e['field'] ] === $e['before'] ) { $hit = $i; break; } }
        if ( null === $hit ) {
            foreach ( $raw as $row ) { if ( isset( $row[ $e['field'] ] ) && $row[ $e['field'] ] === $e['after'] ) { fprintf( $err, "  skip   %s — already applied\n", $label ); continue 2; } }
            fprintf( $err, "ABORT: %s — no element matches the before text.\n", $label ); exit( 1 );
        }
        $new = $raw; $new[ $hit ][ $e['field'] ] = $e['after'];
        $plan[] = array( 'edit' => $e, 'label' => $label, 'write' => 'meta', 'id' => $id, 'key' => $surface, 'before' => $raw, 'after' => $new );
        fprintf( $err, "  %s %s [element %d]\n", $apply ? 'edit  ' : 'would ', $label, $hit );
        continue;
    }

    /* Plain string meta with a substring guard. */
    $cur = (string) $raw;
    if ( substr_count( $cur, $e['before_substr'] ) !== 1 ) {
        if ( false !== strpos( $cur, $e['after_substr'] ) ) { fprintf( $err, "  skip   %s — already applied\n", $label ); continue; }
        fprintf( $err, "ABORT: %s — before text not found exactly once.\n", $label ); exit( 1 );
    }
    $new = str_replace( $e['before_substr'], $e['after_substr'], $cur );
    $plan[] = array( 'edit' => $e, 'label' => $label, 'write' => 'meta', 'id' => $id, 'key' => $surface, 'before' => $cur, 'after' => $new );
    fprintf( $err, "  %s %s\n", $apply ? 'edit  ' : 'would ', $label );
}

/* ---- Backup on stdout ---- */
$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'helmet-claims', 'mode' => $apply ? 'apply' : 'dry-run', 'note' => 'before/after per surface. Restore meta with update_post_meta( wp_slash( before ) ); restore bodies by writing before back to wp_posts.post_content.', 'edits' => array() );
foreach ( $plan as $x ) { $backup['edits'][] = array( 'ID' => $x['id'], 'surface' => $x['edit']['surface'], 'kind' => $x['edit']['kind'], 'before' => $x['before'], 'after' => $x['after'] ); }
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

if ( ! $apply ) { fprintf( $err, "\nWould apply %d of %d edits.\n", count( $plan ), count( $edits ) ); exit( 0 ); }

/* ---- Act ---- */
$done = 0; $touched = array();
foreach ( $plan as $x ) {
    if ( 'body' === $x['write'] ) {
        $ok = $wpdb->update( $wpdb->posts, array( 'post_content' => $x['after'] ), array( 'ID' => $x['id'] ), array( '%s' ), array( '%d' ) );
        if ( false === $ok ) { fprintf( $err, "FAILED: body write on %d\n", $x['id'] ); exit( 1 ); }
        clean_post_cache( $x['id'] );
    } else {
        /* update_post_meta() unslashes; wp_slash() handles arrays and strings. */
        $ok = update_post_meta( $x['id'], $x['key'], wp_slash( $x['after'] ) );
        if ( false === $ok ) { fprintf( $err, "FAILED: meta write %s on %d\n", $x['key'], $x['id'] ); exit( 1 ); }
        /* Read back: the stored value must equal the intended one, byte for byte. */
        $rb = get_post_meta( $x['id'], $x['key'], true );
        if ( $rb !== $x['after'] ) { fprintf( $err, "FAILED: read-back mismatch on %d %s — check slashing.\n", $x['id'], $x['key'] ); exit( 1 ); }
    }
    $touched[ $x['id'] ] = true; $done++;
}
foreach ( array_keys( $touched ) as $id ) { update_post_meta( $id, '_roden_last_refreshed', '2026-09-19' ); }
fprintf( $err, "\nApplied %d edits across %d posts. Next: flush caches, check the live pages, run bin/check-unslashed-post-writes.php, regenerate content/meta.json.\n", $done, count( $touched ) );
