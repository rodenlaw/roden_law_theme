<?php
/**
 * Apply corrections to `_roden_faqs` entries on published pages.
 *
 * WHY THIS EXISTS SEPARATELY FROM apply-stat-remediation.php.
 *
 * That script patches `post_content`. It cannot see FAQ answers, because those
 * live in post meta — and on 2026-08-25 that gap let a corrected claim survive
 * on a page that had just been fixed. The body of /steps-after-work-injury/ was
 * corrected, the DB sweep of post_content came back clean, and the false
 * deadline was still on the live page: it was also in `_roden_faqs`, which the
 * sweep never looked at.
 *
 * FAQ answers are worse than body copy to get wrong, because inc/ renders them
 * into FAQPage structured data. A false statement there is not just published,
 * it is handed to search engines as a machine-readable answer.
 *
 * THE RULE THIS ENCODES: when a claim is corrected in a body, sweep the meta for
 * the same claim CLASS — not for the same string. The FAQ almost always words it
 * differently, which is exactly why a string sweep misses it.
 *
 * Patch format (JSON), one entry per FAQ to change:
 *
 *   { "batch": "...",
 *     "edits": [ { "ID": 1698, "slug": "...", "index": 1,
 *                  "before": "<exact current answer>",
 *                  "after":  "<replacement>",
 *                  "kind": "reversed-requirement",
 *                  "note": "why it was wrong" } ] }
 *
 * `index` is advisory — the match is made on the exact `before` text, so a
 * reordered FAQ array cannot cause the wrong answer to be overwritten. If the
 * text has changed since the patch was written, the run aborts rather than
 * clobbering someone else's edit.
 *
 *   ssh $H "wp --path=$P eval-file - <patch.json>"        # dry run
 *   ssh $H "wp --path=$P eval-file - <patch.json> apply"  # apply
 *
 * Sets `_roden_last_refreshed` and leaves `post_modified` alone, for the reasons
 * documented in apply-stat-remediation.php.
 */

$path  = isset( $args[0] ) ? (string) $args[0] : '';
$apply = isset( $args[1] ) && 'apply' === $args[1];
$err   = fopen( 'php://stderr', 'w' );

if ( '' === $path || ! file_exists( $path ) ) {
    fprintf( $err, "Usage: eval-file - <patch.json> [apply]\n" );
    exit( 1 );
}
$patch = json_decode( (string) file_get_contents( $path ), true );
if ( ! is_array( $patch ) || empty( $patch['edits'] ) ) {
    fprintf( $err, "ABORT: %s is not a readable FAQ patch.\n", $path );
    exit( 1 );
}

fprintf( $err, "%s — %d edit(s), %s\n\n", $apply ? 'APPLY' : 'DRY RUN',
    count( $patch['edits'] ), $patch['batch'] );

/* ---- Resolve and verify every edit before writing any of them ---- */
$ready = array();
foreach ( $patch['edits'] as $e ) {
    $id   = (int) $e['ID'];
    $post = get_post( $id );

    if ( ! $post instanceof WP_Post ) {
        fprintf( $err, "ABORT: post %d not found.\n", $id );
        exit( 1 );
    }
    if ( 'publish' !== $post->post_status ) {
        fprintf( $err, "ABORT: post %d is '%s' — this patch was built against the live page.\n", $id, $post->post_status );
        exit( 1 );
    }

    $faqs = get_post_meta( $id, '_roden_faqs', true );
    if ( ! is_array( $faqs ) ) {
        fprintf( $err, "ABORT: post %d has no _roden_faqs array.\n", $id );
        exit( 1 );
    }

    $hit = null;
    foreach ( $faqs as $i => $q ) {
        if ( isset( $q['answer'] ) && $q['answer'] === $e['before'] ) { $hit = $i; break; }
    }
    if ( null === $hit ) {
        foreach ( $faqs as $i => $q ) {
            if ( isset( $q['answer'] ) && $q['answer'] === $e['after'] ) { $hit = 'done'; break; }
        }
        if ( 'done' === $hit ) {
            fprintf( $err, "  skip  %-5d %s (already applied)\n", $id, $e['slug'] );
            continue;
        }
        fprintf( $err, "ABORT: post %d (%s) — no FAQ answer matches the expected text.\n", $id, $e['slug'] );
        fprintf( $err, "       It has been edited since the patch was written. Regenerate it.\n" );
        exit( 1 );
    }

    $ready[] = array( 'id' => $id, 'faqs' => $faqs, 'index' => $hit, 'edit' => $e );
}

if ( ! $ready ) { fprintf( $err, "\nNothing to do.\n" ); exit( 0 ); }

/* ---- Act ---- */
$today = current_time( 'Y-m-d' );
$done  = 0;
foreach ( $ready as $r ) {
    $e = $r['edit'];
    fprintf( $err, "  %-5s %-5d %-46s  FAQ #%d  [%s]\n",
        $apply ? 'edit' : 'would', $r['id'], substr( $e['slug'], 0, 46 ), $r['index'], $e['kind'] );
    fprintf( $err, "          %s\n", $e['note'] );

    if ( ! $apply ) { continue; }

    $faqs = $r['faqs'];
    $faqs[ $r['index'] ]['answer'] = $e['after'];
    update_post_meta( $r['id'], '_roden_faqs', $faqs );
    update_post_meta( $r['id'], '_roden_last_refreshed', $today );
    clean_post_cache( $r['id'] );

    $back = get_post_meta( $r['id'], '_roden_faqs', true );
    if ( ! is_array( $back ) || $back[ $r['index'] ]['answer'] !== $e['after'] ) {
        fprintf( $err, "        FAILED read-back on %d — stopping.\n", $r['id'] );
        exit( 1 );
    }
    $done++;
}

fprintf( $err, "\n%s: %d FAQ answer(s)\n", $apply ? 'Edited' : 'Would edit', $apply ? $done : count( $ready ) );
if ( $apply ) {
    fprintf( $err, "_roden_last_refreshed set to %s. post_modified untouched.\n", $today );
    fprintf( $err, "Next: flush both caches, then check the RENDERED page — FAQ meta also feeds FAQPage schema.\n" );
}
