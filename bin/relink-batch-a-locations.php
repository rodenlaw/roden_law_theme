<?php
/**
 * Phase 1 batch (a) — repoint editorial links away from the neighbourhood pages
 * before they are retired.
 *
 * 23 blog posts carry 35 contextual links to the 88 pages batch (a) removes,
 * e.g. <a href="/locations/.../west-ashley/">West Ashley</a> mid-sentence. The
 * plan requires zero internal links resolving through a 301, so the href is
 * repointed at the parent city hub and the anchor text is left alone — the link
 * keeps its editorial meaning (West Ashley is part of Charleston) instead of
 * being unwrapped and losing it.
 *
 * Matching is exact-with-delimiter: the closing quote is part of the needle, so
 * "/a/b/" can never match inside "/a/b/c/". No regex, therefore no risk of a $
 * in a replacement string mangling content. Relative and absolute forms, with
 * and without a trailing slash, are all handled.
 *
 * Run BEFORE bin/remove-sc-neighborhood-locations.php — that script refuses to
 * trash a page anything still links to.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/relink-batch-a-locations.php \
 *       > backup-batch-a-relink.json
 *
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/relink-batch-a-locations.php \
 *       > backup-batch-a-relink.json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$home  = 'https://rodenlaw.com';

/* removed path => parent city hub it should point at instead */
$map = array(
    '/locations/south-carolina/charleston/downtown-charleston/cannonborough-elliotborough/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/north-charleston/goose-creek/liberty-hall-plantation/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/charleston/downtown-charleston/king-street-district/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/north-charleston/goose-creek/brickhope-plantation/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/north-charleston/goose-creek/crowfield-plantation/' => '/locations/south-carolina/north-charleston/',
    '/locations/georgia/savannah/midtown-savannah/ardsley-park-chatham-crescent/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/myrtle-beach/north-myrtle-beach/barefoot-landing/' => '/locations/south-carolina/myrtle-beach/',
    '/locations/south-carolina/charleston/downtown-charleston/harleston-village/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/north-charleston/summerville/historic-district/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/north-charleston/goose-creek/carnes-crossroads/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/charleston/downtown-charleston/wagener-terrace/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/charleston/downtown-charleston/french-quarter/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/charleston/downtown-charleston/south-of-broad/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/north-charleston/summerville/pine-forest-inn/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/charleston/west-ashley/grand-oaks-plantation/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/charleston/downtown-charleston/the-crosstown/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/north-charleston/summerville/summers-corner/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/charleston/downtown-charleston/ansonborough/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/north-charleston/goose-creek/boulder-bluff/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/north-charleston/dorchester-terrace-waylyn/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/myrtle-beach/georgetown/historic-district/' => '/locations/south-carolina/myrtle-beach/',
    '/locations/south-carolina/north-charleston/summerville/knightsville/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/north-charleston/goose-creek/devon-forest/' => '/locations/south-carolina/north-charleston/',
    '/locations/georgia/savannah/southside-savannah/georgetown-savannah/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/myrtle-beach/garden-city-beach/pier-area/' => '/locations/south-carolina/myrtle-beach/',
    '/locations/south-carolina/charleston/west-ashley/ashley-river-road/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/charleston/west-ashley/citadel-mall-area/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/north-charleston/goose-creek/westchester/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/myrtle-beach/surfside-beach/town-center/' => '/locations/south-carolina/myrtle-beach/',
    '/locations/south-carolina/myrtle-beach/myrtle-beach/market-common/' => '/locations/south-carolina/myrtle-beach/',
    '/locations/south-carolina/charleston/west-ashley/south-windermere/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/charleston/west-ashley/west-ashley-park/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/charleston/mount-pleasant/carolina-park/' => '/locations/south-carolina/charleston/',
    '/locations/georgia/savannah/southside-savannah/savannah-quarters/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/myrtle-beach/socastee/socastee-village/' => '/locations/south-carolina/myrtle-beach/',
    '/locations/south-carolina/myrtle-beach/myrtle-beach/grande-dunes/' => '/locations/south-carolina/myrtle-beach/',
    '/locations/south-carolina/north-charleston/goose-creek/howe-hall/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/north-charleston/olde-north-charleston/' => '/locations/south-carolina/north-charleston/',
    '/locations/georgia/savannah/downtown-savannah/historic-district/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/myrtle-beach/murrells-inlet/marshwalk/' => '/locations/south-carolina/myrtle-beach/',
    '/locations/south-carolina/myrtle-beach/carolina-forest/the-farm/' => '/locations/south-carolina/myrtle-beach/',
    '/locations/south-carolina/myrtle-beach/conway/historic-district/' => '/locations/south-carolina/myrtle-beach/',
    '/locations/south-carolina/myrtle-beach/myrtle-beach/golden-mile/' => '/locations/south-carolina/myrtle-beach/',
    '/locations/south-carolina/north-charleston/summerville/sangaree/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/north-charleston/summerville/cane-bay/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/charleston/mount-pleasant/old-village/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/north-charleston/oak-terrace-preserve/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/myrtle-beach/little-river/waterfront/' => '/locations/south-carolina/myrtle-beach/',
    '/locations/south-carolina/north-charleston/summerville/wescott/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/charleston/mount-pleasant/rivertowne/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/charleston/mount-pleasant/shem-creek/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/charleston/mount-pleasant/dunes-west/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/charleston/mount-pleasant/belle-hall/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/north-charleston/summerville/nexton/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/charleston/west-ashley/byrnes-downs/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/charleston/mount-pleasant/snee-farm/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/charleston/mount-pleasant/park-west/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/north-charleston/wescott-plantation/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/north-charleston/charleston-heights/' => '/locations/south-carolina/north-charleston/',
    '/locations/georgia/savannah/effingham-county/south-effingham/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/charleston/west-ashley/shadowmoss/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/north-charleston/chicora-cherokee/' => '/locations/south-carolina/north-charleston/',
    '/locations/georgia/savannah/downtown-savannah/river-street/' => '/locations/georgia/savannah/',
    '/locations/georgia/savannah/wilmington-island/town-center/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/charleston/west-ashley/avondale/' => '/locations/south-carolina/charleston/',
    '/locations/georgia/savannah/hinesville/fort-stewart-area/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/charleston/downtown-charleston/' => '/locations/south-carolina/charleston/',
    '/locations/georgia/savannah/statesboro/georgia-southern/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/charleston/mount-pleasant/ion/' => '/locations/south-carolina/charleston/',
    '/locations/south-carolina/north-charleston/liberty-hill/' => '/locations/south-carolina/north-charleston/',
    '/locations/georgia/savannah/port-wentworth/town-center/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/north-charleston/park-circle/' => '/locations/south-carolina/north-charleston/',
    '/locations/georgia/savannah/richmond-hill/city-center/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/north-charleston/northwoods/' => '/locations/south-carolina/north-charleston/',
    '/locations/south-carolina/columbia/northeast-columbia/' => '/locations/south-carolina/columbia/',
    '/locations/georgia/savannah/effingham-county/marlow/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/north-charleston/ferndale/' => '/locations/south-carolina/north-charleston/',
    '/locations/georgia/savannah/effingham-county/egypt/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/charleston/daniel-island/' => '/locations/south-carolina/charleston/',
    '/locations/georgia/savannah/pooler/godley-station/' => '/locations/georgia/savannah/',
    '/locations/south-carolina/charleston/west-ashley/' => '/locations/south-carolina/charleston/',
    '/locations/georgia/savannah/rincon/town-center/' => '/locations/georgia/savannah/',
    '/locations/georgia/savannah/pooler/west-pooler/' => '/locations/georgia/savannah/',
    '/locations/georgia/savannah/southside-savannah/' => '/locations/georgia/savannah/',
    '/locations/georgia/savannah/eastside-savannah/' => '/locations/georgia/savannah/',
    '/locations/georgia/savannah/westside-savannah/' => '/locations/georgia/savannah/',
    '/locations/georgia/savannah/downtown-savannah/' => '/locations/georgia/savannah/',
    '/locations/georgia/savannah/midtown-savannah/' => '/locations/georgia/savannah/',
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — Phase 1 batch (a) relink\n\n", $apply ? 'APPLY' : 'DRY RUN' );

global $wpdb;

/* Collect every published post that references any removed path. */
$targets = array();
foreach ( array_keys( $map ) as $p ) {
    $like = '%' . $wpdb->esc_like( $p ) . '%';
    $ids  = $wpdb->get_col( $wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_content LIKE %s", $like ) );
    foreach ( $ids as $id ) { $targets[ (int) $id ] = true; }
}
$targets = array_keys( $targets );
sort( $targets );

$backup  = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'phase1-a-relink',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Restore post_content verbatim from below if a rewrite goes wrong.',
    'posts'     => array(),
);
$changed = 0;
$links   = 0;

foreach ( $targets as $id ) {
    $post = get_post( $id );
    if ( ! $post instanceof WP_Post ) { continue; }

    $before = (string) $post->post_content;
    $after  = $before;
    $hits   = array();

    foreach ( $map as $from => $to ) {
        $from_ns = untrailingslashit( $from );
        $to_abs  = $home . $to;
        $pairs   = array(
            '"' . $from . '"'              => '"' . $to . '"',
            "'" . $from . "'"              => "'" . $to . "'",
            '"' . $from_ns . '"'           => '"' . $to . '"',
            "'" . $from_ns . "'"           => "'" . $to . "'",
            '"' . $home . $from . '"'      => '"' . $to_abs . '"',
            "'" . $home . $from . "'"      => "'" . $to_abs . "'",
            '"' . $home . $from_ns . '"'   => '"' . $to_abs . '"',
            "'" . $home . $from_ns . "'"   => "'" . $to_abs . "'",
        );
        foreach ( $pairs as $needle => $rep ) {
            $n = substr_count( $after, $needle );
            if ( $n > 0 ) {
                $after  = str_replace( $needle, $rep, $after );
                $links += $n;
                $hits[] = sprintf( '%dx %s -> %s', $n, $from, $to );
            }
        }
    }

    if ( $after === $before ) { continue; }

    $backup['posts'][] = array(
        'ID'           => (int) $post->ID,
        'post_name'    => $post->post_name,
        'permalink'    => get_permalink( $post ),
        'post_content' => $before,
    );
    $changed++;

    fprintf( $err, "  %-6d %s\n", $post->ID, $post->post_name );
    foreach ( array_unique( $hits ) as $h ) { fprintf( $err, "           %s\n", $h ); }

    if ( $apply ) {
        /*
         * Deliberately a direct column write rather than wp_update_post().
         *
         * wp_update_post() stamps post_modified with the current time, and
         * single.php renders an "Updated <date>" line from
         * get_the_modified_date() whenever it differs from the publish date —
         * with schema dateModified and og:article:modified_time alongside it.
         * Repointing a hyperlink would therefore advertise 23 legal blog posts
         * as freshly updated when nothing a reader cares about changed. On a
         * site being re-rated for quality that is exactly the wrong signal, so
         * post_modified is left alone and no revision is spawned.
         *
         * _roden_last_reviewed — the firm's own answer to when an attorney
         * actually reviewed the page — is untouched either way.
         */
        $ok = $wpdb->update(
            $wpdb->posts,
            array( 'post_content' => $after ),
            array( 'ID' => $post->ID ),
            array( '%s' ),
            array( '%d' )
        );
        if ( false === $ok ) {
            fprintf( $err, "           FAILED: db write error\n" );
            exit( 1 );
        }
        clean_post_cache( $post->ID );
    }
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fprintf( $err, "\n%s: %d links across %d posts\n", $apply ? 'Rewrote' : 'Would rewrite', $links, $changed );
