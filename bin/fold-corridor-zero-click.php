<?php
/**
 * Corridor fold — retire the 11 April-2026 corridor resources that earn nothing.
 *
 * These are the pages docs/gsc-evidence-2026-08-24.md identifies as having earned
 * ZERO clicks in the 13 months to 2026-08-22. The other 37 in the same seeding
 * band rank page-one and are KEEP: the Steinberg plan assumed the whole campaign
 * would fold into the I-26/I-95 Corridor Report, and the GSC data said otherwise.
 * Only the dead ones go. Approved by the owner 2026-08-24.
 *
 * THE BACKUP IS THE POINT. ~12,900 words across these 11 posts become chapters of
 * Study #1 — this is a content harvest that happens to end in a redirect, not a
 * deletion. The JSON on STDOUT is the study's source text. Keep it.
 *
 * Known gap, stated because it bounds the confidence here: the GSC UI export caps
 * Pages.csv at 1,000 rows with a 1-click minimum, so zero-click pages are absent
 * and their IMPRESSIONS are unknown. "Zero clicks" is certain; "invisible" is not.
 * A page pulling impressions without clicks is a different problem. That is why
 * these 301 rather than 404, and why the bodies are preserved rather than dropped.
 *
 * Targets are practice pillars — guardrail keeps, therefore chain-proof by
 * construction, the same reasoning batch (a) used for tier-2 city hubs. Repoint to
 * the Corridor Report when it publishes; roden_phase1_removed_urls() is a flat
 * lookup read once at template_redirect, so editing a destination stays single-hop.
 *
 * ORDER MATTERS. The 301s must be LIVE before this runs, or these URLs 404 in the
 * gap. They are path-keyed and fire whether or not the post exists.
 *
 * Posts are TRASHED, not force-deleted. Reversible with wp post untrash <ID>.
 *
 *   Dry run (default) — this is the harvest:
 *     ssh $H "wp --path=$P eval-file -" < bin/fold-corridor-zero-click.php \
 *       > docs/backups/corridor-fold-$(date +%Y-%m-%d).json
 *
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/fold-corridor-zero-click.php \
 *       > docs/backups/corridor-fold-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ID => public path. One map, not two parallel arrays. */
$expect = array(
    4618 => '/resources/what-to-do-after-car-accident-north-charleston/',
    4633 => '/resources/workers-comp-north-charleston-warehouse-port/',
    4634 => '/resources/rideshare-accident-north-charleston/',
    4641 => '/resources/construction-zone-accidents-north-charleston/',
    4657 => '/resources/lexington-county-truck-accidents-distribution-corridor/',
    4662 => '/resources/port-of-charleston-truck-routes/',
    4666 => '/resources/mount-pleasant-truck-accidents-wando-welch/',
    4667 => '/resources/highway-501-truck-accidents-conway-myrtle-beach/',
    4668 => '/resources/us-17-truck-accidents-grand-strand/',
    4669 => '/resources/seasonal-truck-accidents-myrtle-beach/',
    4673 => '/resources/ogeechee-road-truck-accidents-savannah/',
);

/*
 * The 37 performers, by ID. Named explicitly as a tripwire: if this script is ever
 * re-run against an edited $expect, an overlap means someone is about to trash a
 * page that ranks. The whole point of the GSC pass was to tell these apart.
 */
$keep_ids = array(
    4617, 4632, 4639, 4640, 4648, 4649, 4650, 4651, 4652, 4653, 4654, 4655, 4656,
    4661, 4663, 4664, 4665, 4670, 4671, 4672, 4674, 4675, 4676, 4677, 4678, 4679,
    4680, 4681, 4682, 4683, 4684, 4685, 4686, 4687, 4688, 4689, 4690,
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — corridor fold (11 zero-click resources)\n\n", $apply ? 'APPLY' : 'DRY RUN' );

$overlap = array_intersect( array_keys( $expect ), $keep_ids );
if ( $overlap ) {
    fprintf( $err, "ABORT: %s is in the keep set — that page earns clicks.\n", implode( ', ', $overlap ) );
    exit( 1 );
}

global $wpdb;
$found = array();

foreach ( $expect as $id => $path ) {
    $p = get_post( $id );

    if ( ! $p instanceof WP_Post ) {
        fprintf( $err, "ABORT: ID %d not found.\n", $id );
        exit( 1 );
    }
    if ( 'resource' !== $p->post_type ) {
        fprintf( $err, "ABORT: ID %d is post_type '%s', expected 'resource'.\n", $id, $p->post_type );
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
     * Guard: refuse if any published post's body links here. Note this is a real
     * risk on this set in a way it was not for batch (d) — _roden_see_also links
     * between resources are template-rendered, but editorial body links are not.
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

    /*
     * Report, don't block, on _roden_see_also references from other posts. Those
     * render through roden_see_also_links() and will simply 301 after this runs —
     * a hop, not a break — but they should be cleaned in the same session.
     */
    $meta_refs = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_key = '_roden_see_also' AND meta_value LIKE %s",
        $like
    ) );
    if ( $meta_refs > 0 ) {
        fprintf( $err, "  NOTE: %d _roden_see_also entries reference %s — clean these in the same session.\n", $meta_refs, $actual );
    }

    $found[] = $p;
}

if ( count( $found ) !== count( $expect ) ) {
    fprintf( $err, "ABORT: resolved %d of %d.\n", count( $found ), count( $expect ) );
    exit( 1 );
}

/* ---- Harvest before touching anything ---- */

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'corridor-fold-zero-click',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Source text for the I-26/I-95 Corridor Report (Steinberg plan Study #1). Also a restore point: wp_untrash_post( ID ).',
    'evidence'  => 'docs/gsc-evidence-2026-08-24.md — zero clicks 2025-07-23 to 2026-08-22',
    'posts'     => array(),
);
foreach ( $found as $p ) {
    $backup['posts'][] = array(
        'ID'            => (int) $p->ID,
        'post_title'    => $p->post_title,
        'post_name'     => $p->post_name,
        'post_type'     => $p->post_type,
        'post_status'   => $p->post_status,
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
    fprintf( $err, "Harvest captured on STDOUT — that is Study #1's source text, not just an undo.\n" );
    fprintf( $err, "Next: flush caches, verify the 11 redirects single-hop, regenerate content/meta.json.\n" );
}
