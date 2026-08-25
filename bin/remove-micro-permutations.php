<?php
/**
 * Phase 1 batch (c) — retire the practice micro-permutations.
 *
 * SEO pre-emption plan rule 5: single-road and single-employer practice pages,
 * 301 to the parent pillar. Eleven pages, all English, 643-2,003 unique words.
 *
 * These are NOT thin doorways the way batches (b) and (d) were, and the rule
 * says so: "merge any with real traffic into the parent practice page or
 * convert to a bylined blog/resource post". Three carry 1,000-2,000 words, and
 * STEINBERG-MODEL-PLAN-rodenlaw.md priorities 1 and 2 (the I-26/I-95 Corridor
 * Report, the Port Worker Injury Report) are built from exactly this material.
 * So the backup this script emits is not just an undo — it is the source text
 * for those studies. Keep it.
 *
 * Redirecting now does not foreclose that. roden_phase1_removed_urls() is a
 * flat path => target map read once at template_redirect priority 0; when the
 * studies publish, edit the destination there and it stays single-hop.
 *
 * Internal links need no stripping. Every one of these is linked from its own
 * parent pillar, but those links come from $child_subtypes in
 * single-practice_area.php:100 — a get_posts() query on post_parent that
 * defaults to published posts — so trashing removes the link with no edit.
 * Verified against the function, and the guard below independently refuses to
 * run if any published post's BODY links here.
 *
 * ORDER MATTERS. The 301s in inc/legacy-redirects.php must be LIVE before this
 * runs, or these URLs 404 in the gap. They are path-keyed so they fire whether
 * or not the post exists — deploy first, then run this.
 *
 * Posts are TRASHED, not force-deleted. A full JSON backup of every post and
 * its meta goes to STDOUT on both dry and apply runs; status goes to STDERR.
 * The database is not in this repo and has no undo.
 *
 *   Dry run (default) — this is also how you capture the study source text:
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-micro-permutations.php \
 *       > docs/backups/batch-c-micro-permutations-$(date +%Y-%m-%d).json
 *
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-micro-permutations.php \
 *       > docs/backups/batch-c-micro-permutations-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/*
 * ID => public path, as one map rather than two parallel arrays — pairing them
 * by index is how batch (b) nearly trashed the wrong pages.
 * Source: url-triage.csv, practice_area rows classified CONSOLIDATE under rule 5.
 */
$expect = array(
    4619 => '/car-accident-lawyers/i-26-accident/',
    4620 => '/car-accident-lawyers/i-526-accident/',
    4621 => '/car-accident-lawyers/rivers-avenue-accident/',
    4622 => '/car-accident-lawyers/ashley-phosphate-road-accident/',
    4623 => '/car-accident-lawyers/dorchester-road-accident/',
    4626 => '/truck-accident-lawyers/i-26-truck-accident/',
    4629 => '/workers-compensation-lawyers/boeing-aerospace-injury/',
    4636 => '/motorcycle-accident-lawyers/dorchester-road-motorcycle/',
    4637 => '/pedestrian-accident-lawyers/rivers-avenue-pedestrian/',
    5162 => '/workers-compensation-lawyers/savannah-port-worker-injury/',
    5167 => '/workers-compensation-lawyers/gulfstream-aerospace-injury/',
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — Phase 1 batch (c)\n\n", $apply ? 'APPLY' : 'DRY RUN' );

global $wpdb;
$found = array();

foreach ( $expect as $id => $path ) {
    $p = get_post( $id );

    if ( ! $p instanceof WP_Post ) {
        fprintf( $err, "ABORT: ID %d not found.\n", $id );
        exit( 1 );
    }
    if ( 'practice_area' !== $p->post_type ) {
        fprintf( $err, "ABORT: ID %d is post_type '%s', expected 'practice_area'.\n", $id, $p->post_type );
        exit( 1 );
    }
    if ( 'publish' !== $p->post_status ) {
        fprintf( $err, "ABORT: ID %d is '%s', not published — already actioned?\n", $id, $p->post_status );
        exit( 1 );
    }

    $actual = trailingslashit( (string) wp_parse_url( get_permalink( $p ), PHP_URL_PATH ) );
    if ( $actual !== trailingslashit( $path ) ) {
        fprintf( $err, "ABORT: ID %d is at %s, expected %s.\n", $id, $actual, $path );
        exit( 1 );
    }

    /*
     * Guard: sub-type, not intersection. An intersection page carries
     * _roden_pa_office_key and belongs to a real office market — those are a
     * KEEP tier under rule 6 and must never be swept up here.
     */
    $office_key = get_post_meta( $id, '_roden_pa_office_key', true );
    if ( '' !== (string) $office_key ) {
        fprintf( $err, "ABORT: ID %d carries _roden_pa_office_key '%s' — that is an office intersection page, not a micro-permutation.\n", $id, $office_key );
        exit( 1 );
    }

    /*
     * Guard: the redirect target must be this page's own parent pillar, and
     * that pillar must be published. Batch (a) chose targets by hand for a
     * reason; here the parent IS the right target, so assert it rather than
     * trusting the map.
     */
    $parent = $p->post_parent ? get_post( $p->post_parent ) : null;
    if ( ! $parent instanceof WP_Post || 'publish' !== $parent->post_status ) {
        fprintf( $err, "ABORT: ID %d has no published parent pillar to redirect to.\n", $id );
        exit( 1 );
    }

    /*
     * Guard: refuse if any published post's body links here. Template-generated
     * pillar links live in $child_subtypes, not post_content, so this checks
     * for editorial links specifically — the ones that would 301-chain.
     */
    $like = '%' . $wpdb->esc_like( $actual ) . '%';
    $refs = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status='publish' AND ID <> %d AND post_content LIKE %s",
        $id, $like
    ) );
    if ( $refs > 0 ) {
        fprintf( $err, "ABORT: %d published posts still link to %s — strip those first.\n", $refs, $actual );
        exit( 1 );
    }

    $found[] = $p;
}

if ( count( $found ) !== count( $expect ) ) {
    fprintf( $err, "ABORT: resolved %d of %d.\n", count( $found ), count( $expect ) );
    exit( 1 );
}

/* ---- Backup before touching anything ---- */

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'phase1-c-micro-permutations',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Restore with wp_untrash_post( ID ). Also the source text for the Corridor and Port Worker studies — do not discard.',
    'posts'     => array(),
);
foreach ( $found as $p ) {
    $backup['posts'][] = array(
        'ID'            => (int) $p->ID,
        'post_title'    => $p->post_title,
        'post_name'     => $p->post_name,
        'post_type'     => $p->post_type,
        'post_status'   => $p->post_status,
        'post_parent'   => (int) $p->post_parent,
        'parent_path'   => (string) wp_parse_url( get_permalink( $p->post_parent ), PHP_URL_PATH ),
        'post_date_gmt' => $p->post_date_gmt,
        'permalink'     => get_permalink( $p ),
        'post_content'  => $p->post_content,
        'post_excerpt'  => $p->post_excerpt,
        'meta'          => get_post_meta( $p->ID ),
    );
}
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

/* ---- Act ---- */

$done = 0;
foreach ( $found as $p ) {
    $path = (string) wp_parse_url( get_permalink( $p ), PHP_URL_PATH );
    if ( ! $apply ) {
        fprintf( $err, "  would trash  %-5d %s\n", $p->ID, $path );
        continue;
    }
    if ( wp_trash_post( $p->ID ) ) {
        $done++;
        fprintf( $err, "  trashed      %-5d %s\n", $p->ID, $path );
    } else {
        fprintf( $err, "  FAILED       %-5d %s\n", $p->ID, $path );
    }
}

fprintf( $err, "\n%s: %d of %d\n", $apply ? 'Trashed' : 'Would trash', $apply ? $done : count( $found ), count( $found ) );
if ( $apply ) {
    fprintf( $err, "Backup captured on STDOUT. Restore any post with: wp post untrash <ID>\n" );
    fprintf( $err, "Next: flush caches, then verify the 11 redirects resolve single-hop.\n" );
}
