<?php
/**
 * Remove uncited and contradicted statistics from 12 published pages.
 *
 * Five numeric claims repeat verbatim across the site. Two are contradicted by
 * primary sources and three could not be verified from any public source; the
 * full trace is in docs/stat-audit-2026-08-25.md. On a legal site being re-rated
 * for quality — and one about to publish a research study whose whole value is
 * citability — an uncited number that a journalist can check and fail to confirm
 * is a liability, not filler.
 *
 * The edits are NOT computed here. They were generated and reviewed offline, then
 * written to docs/backups/stat-remediation-2026-08-25.json, which carries the
 * before text, the after text, an md5 of the before, and a line-by-line log of
 * every removal. This script only applies that file. Deliberate: a script that
 * regex-edits 12 pages of hand-written HTML in place is a script nobody can
 * review, and the diff is the whole point of the change.
 *
 * The md5 guard is what makes that safe. If a page has been edited since the
 * patch was generated, its before text no longer matches and the script aborts
 * rather than overwriting someone's work with stale content.
 *
 * DATES. post_content is written as a direct column update, so post_modified is
 * not stamped — the same reasoning as every relink in this project. What IS set
 * is `_roden_last_refreshed`, which inc/template-tags.php documents as the field
 * for exactly this: "the content was corrected or updated on this date. Says
 * nothing about who, and emits no reviewedBy." Its docstring even cites the
 * 2026-08-07 seat-belt corrections as the precedent — copy that was wrong, fixed
 * by someone who is not a lawyer. Stamping `_roden_last_reviewed` instead would
 * manufacture an E-E-A-T claim that nobody earned.
 *
 *   Dry run (default) — prints what would change, writes nothing:
 *     ssh $H "wp --path=$P eval-file - /tmp/stat-patch.json" \
 *       < bin/apply-stat-remediation.php
 *
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - /tmp/stat-patch.json apply" \
 *       < bin/apply-stat-remediation.php
 *
 * Get the patch onto the host first — scp is refused by WP Engine:
 *   ssh $H "cat > /tmp/stat-patch.json" < docs/backups/stat-remediation-2026-08-25.json
 */

$path  = isset( $args[0] ) ? (string) $args[0] : '';
$apply = isset( $args[1] ) && 'apply' === $args[1];

$err = fopen( 'php://stderr', 'w' );

if ( '' === $path || ! file_exists( $path ) ) {
    fprintf( $err, "Usage: eval-file - <patch.json> [apply]\n" );
    exit( 1 );
}
$patch = json_decode( (string) file_get_contents( $path ), true );
if ( ! is_array( $patch ) || empty( $patch['pages'] ) ) {
    fprintf( $err, "ABORT: %s is not a readable patch file.\n", $path );
    exit( 1 );
}

fprintf( $err, "%s — %d pages, %s\n\n", $apply ? 'APPLY' : 'DRY RUN',
    count( $patch['pages'] ), $patch['batch'] );

global $wpdb;
$today = current_time( 'Y-m-d' );

/* ---- Verify everything before touching anything ---- */
$ready = array();
foreach ( $patch['pages'] as $p ) {
    $post = get_post( (int) $p['ID'] );

    if ( ! $post instanceof WP_Post ) {
        fprintf( $err, "ABORT: post %d not found.\n", $p['ID'] );
        exit( 1 );
    }
    if ( 'publish' !== $post->post_status ) {
        fprintf( $err, "ABORT: post %d is '%s', not published — the patch was built against the live page.\n", $p['ID'], $post->post_status );
        exit( 1 );
    }
    if ( md5( $post->post_content ) !== $p['before_md5'] ) {
        fprintf( $err, "ABORT: post %d (%s) has changed since the patch was generated.\n", $p['ID'], $p['slug'] );
        fprintf( $err, "       Regenerate the patch rather than overwriting the newer content.\n" );
        exit( 1 );
    }
    if ( $post->post_content === $p['after'] ) {
        fprintf( $err, "  skip  %-5d %s (already applied)\n", $p['ID'], $p['slug'] );
        continue;
    }
    $ready[] = array( 'post' => $post, 'patch' => $p );
}

if ( ! $ready ) {
    fprintf( $err, "\nNothing to do.\n" );
    exit( 0 );
}

/* ---- Act ---- */
$done = 0; $removed = 0;
foreach ( $ready as $r ) {
    $post = $r['post']; $p = $r['patch'];
    fprintf( $err, "  %-5s %-5d %-46s  %d removal(s), %d -> %d chars\n",
        $apply ? 'edit' : 'would', $post->ID, substr( $p['slug'], 0, 46 ),
        count( $p['removed'] ), strlen( $p['before'] ), strlen( $p['after'] ) );
    foreach ( $p['removed'] as $rm ) {
        fprintf( $err, "          - [%s] %s\n", $rm['kind'], substr( $rm['text'], 0, 96 ) );
        $removed++;
    }
    if ( ! $apply ) {
        continue;
    }

    $ok = $wpdb->update(
        $wpdb->posts,
        array( 'post_content' => $p['after'] ),
        array( 'ID' => $post->ID ),
        array( '%s' ),
        array( '%d' )
    );
    if ( false === $ok ) {
        fprintf( $err, "        FAILED: db write error on %d\n", $post->ID );
        exit( 1 );
    }
    update_post_meta( $post->ID, '_roden_last_refreshed', $today );
    clean_post_cache( $post->ID );
    $done++;
}

fprintf( $err, "\n%s: %d pages, %d claim removals\n",
    $apply ? 'Edited' : 'Would edit', $apply ? $done : count( $ready ), $removed );
if ( $apply ) {
    fprintf( $err, "_roden_last_refreshed set to %s. post_modified deliberately untouched.\n", $today );
    fprintf( $err, "Next: flush both caches, then re-sweep for the five claims — expect zero.\n" );
}
