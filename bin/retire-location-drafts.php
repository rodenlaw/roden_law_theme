<?php
/**
 * Trash the eight unpublished location drafts.
 *
 * Track E of the SEO recovery: the cull removed 196 URLs that a single Publish
 * click could recreate. inc/content-guardrails.php now blocks that click; this
 * removes the eight drafts sitting behind it, so the hazard is gone as well as
 * guarded.
 *
 * None was ever published, so there is no SEO consequence either way — no URL,
 * no index entry, no redirect needed. This is CMS hygiene, not a cull batch, and
 * it is why these are handled separately from batches (a)-(f).
 *
 * What they are, and why none should survive:
 *
 *   Three duplicate their own parent office city — darien under darien, columbia
 *   under columbia, myrtle-beach under myrtle-beach. Publishing one would put a
 *   second copy of a guardrail-protected hub at /locations/georgia/darien/darien/.
 *
 *   Two sit under a parent that batch (a) already trashed (effingham-county), so
 *   publishing them would create pages beneath a dead ancestor.
 *
 *   Three are sub-city by any reading — Sullivans Island under Mount Pleasant,
 *   Ardsley Park and Georgetown under Savannah. Sullivans Island is also a second
 *   page for a town whose tier-3 page was removed on 2026-08-25 for taking 540
 *   impressions and zero clicks.
 *
 * All eight are 60-167 words, all created in March 2026, none touched since.
 *
 * Posts are TRASHED, not force-deleted, and the full JSON backup on STDOUT
 * carries content and meta. Reversible with wp post untrash <ID>.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/retire-location-drafts.php > backup.json
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/retire-location-drafts.php \
 *       > docs/backups/location-drafts-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ID => slug, as one map. Pairing by index is how batch (b) nearly went wrong. */
$expect = array(
    3808 => 'georgetown',
    3810 => 'ardsley-park',
    3813 => 'myrtle-beach',
    3838 => 'columbia',
    3871 => 'darien',
    4273 => 'sullivans-island',
    4332 => 'springfield',
    4333 => 'guyton',
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — retire %d location drafts\n\n", $apply ? 'APPLY' : 'DRY RUN', count( $expect ) );

$found = array();
foreach ( $expect as $id => $slug ) {
    $p = get_post( $id );

    if ( ! $p instanceof WP_Post ) {
        fprintf( $err, "ABORT: ID %d not found.\n", $id );
        exit( 1 );
    }
    if ( 'location' !== $p->post_type ) {
        fprintf( $err, "ABORT: ID %d is post_type '%s', expected 'location'.\n", $id, $p->post_type );
        exit( 1 );
    }
    if ( $p->post_name !== $slug ) {
        fprintf( $err, "ABORT: ID %d has slug '%s', expected '%s'.\n", $id, $p->post_name, $slug );
        exit( 1 );
    }

    /*
     * The guard that matters. Every one of these must be unpublished — if one has
     * been published since this list was drawn up it has a live URL, and trashing
     * it without a 301 would create the 404 the plan forbids. Stop and re-triage
     * rather than silently doing damage.
     */
    if ( 'publish' === $p->post_status ) {
        fprintf( $err, "ABORT: ID %d (%s) is PUBLISHED — it has a live URL and needs a redirect, not a trash.\n", $id, $slug );
        exit( 1 );
    }

    $found[] = $p;
}

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'location-drafts',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Never-published drafts. No URL, no redirect needed. Restore with wp post untrash <ID>.',
    'posts'     => array(),
);
foreach ( $found as $p ) {
    $backup['posts'][] = array(
        'ID'            => (int) $p->ID,
        'post_title'    => $p->post_title,
        'post_name'     => $p->post_name,
        'post_status'   => $p->post_status,
        'post_parent'   => (int) $p->post_parent,
        'post_date_gmt' => $p->post_date_gmt,
        'post_content'  => $p->post_content,
        'meta'          => get_post_meta( $p->ID ),
    );
}
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$done = 0;
foreach ( $found as $p ) {
    if ( ! $apply ) {
        fprintf( $err, "  would trash  %-5d %-18s (%s)\n", $p->ID, $p->post_name, $p->post_status );
        continue;
    }
    if ( wp_trash_post( $p->ID ) ) {
        $done++;
        fprintf( $err, "  trashed      %-5d %s\n", $p->ID, $p->post_name );
    } else {
        fprintf( $err, "  FAILED       %-5d %s\n", $p->ID, $p->post_name );
    }
}
fprintf( $err, "\n%s: %d of %d\n", $apply ? 'Trashed' : 'Would trash', $apply ? $done : count( $found ), count( $found ) );
