<?php
/**
 * Repoint editorial links that point at the 41 floor-cull pages retired
 * 2026-10-21 (docs/floor-cull-2026-10-21.md): 6 merges and 35 retires.
 * _roden_see_also links need no rewrite: roden_resolve_see_also_url() resolves
 * them through the removal map at render time.
 *
 * Run BEFORE bin/remove-floor-cull.php, which refuses to apply while any
 * published post outside the batch still links to one of these URLs. Same
 * mechanics as bin/relink-zero-click-pages.php: href only, anchor text
 * untouched, direct column write so post_modified is not stamped. Paths and
 * targets are read from roden_floor_cull_urls() + roden_floor_cull_mid_urls()
 * in inc/legacy-redirects.php. No nested-path aliases: none is a practice_area.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/relink-floor-cull.php \
 *       > docs/backups/floor-cull-relink-$(date +%Y-%m-%d).json
 *
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/relink-floor-cull.php \
 *       > docs/backups/floor-cull-relink-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — relink the 41 floor-cull pages\n\n", $apply ? 'APPLY' : 'DRY RUN' );

if ( ! function_exists( 'roden_floor_cull_urls' ) ) {
    fprintf( $err, "ABORT: roden_floor_cull_urls() is not defined — deploy the theme change first.\n" );
    exit( 1 );
}
// The five middle-tier posts live in their own function so the owner can drop
// them; if it is gone, they are simply not part of the run.
$map = array_merge(
    roden_floor_cull_urls(),
    function_exists( 'roden_floor_cull_mid_urls' ) ? roden_floor_cull_mid_urls() : array()
);
$all = $map;

global $wpdb;
$home   = untrailingslashit( home_url() );
$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'floor-cull-relink',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'post_content before/after per post. Restore by writing "before" back to wp_posts.post_content.',
    'posts'     => array(),
);
$links   = 0;
$changed = 0;
$seen    = array();

foreach ( $all as $path => $target ) {
    $like = '%' . $wpdb->esc_like( $path ) . '%';
    $ids  = $wpdb->get_col( $wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_type <> 'revision' AND post_content LIKE %s",
        $like
    ) );
    foreach ( $ids as $id ) {
        $self = trailingslashit( (string) wp_parse_url( get_permalink( $id ), PHP_URL_PATH ) );
        if ( isset( $map[ $self ] ) ) {
            continue; // retiring in this batch
        }
        $post = get_post( $id );
        if ( ! $post instanceof WP_Post ) {
            continue;
        }
        $before = isset( $seen[ $id ] ) ? $seen[ $id ]['after'] : $post->post_content;
        $after  = $before;

        /*
         * Replace the href only, absolute and site-relative, and only where the
         * path is followed by a quote, '#' or '?' — so a path never matches a
         * longer sibling. String replacement, not a regex: hand-written HTML.
         */
        foreach ( array( $home . $path, $path ) as $needle ) {
            $rep = ( $needle === $path ) ? $target : $home . $target;
            foreach ( array( '"', "'" ) as $q ) {
                $after = str_replace( $q . $needle . $q, $q . $rep . $q, $after );
                foreach ( array( '#', '?' ) as $sfx ) {
                    $after = str_replace( $q . $needle . $sfx, $q . $rep . $sfx, $after );
                }
            }
        }
        if ( $after === $before ) {
            continue;
        }
        $n      = substr_count( $before, $path ) - substr_count( $after, $path );
        $links += max( $n, 0 );
        if ( ! isset( $seen[ $id ] ) ) {
            $changed++;
            $seen[ $id ] = array(
                'ID'         => (int) $id,
                'post_title' => $post->post_title,
                'permalink'  => get_permalink( $post ),
                'from'       => array(),
                'before'     => $post->post_content,
                'after'      => $after,
            );
        }
        $seen[ $id ]['after']  = $after;
        $seen[ $id ]['from'][] = $path . ' -> ' . $target;
        fprintf( $err, "  %-5d %-72s -> %s\n", $id, $path, $target );
    }
}

foreach ( $seen as $id => $rec ) {
    $backup['posts'][] = $rec;
    if ( $apply ) {
        /*
         * Direct column write, deliberately, not wp_update_post(): no
         * post_modified stamp (single.php renders "Updated <date>" from it), and
         * no wp_unslash() pass, so no wp_slash() is needed here.
         */
        $ok = $wpdb->update( $wpdb->posts, array( 'post_content' => $rec['after'] ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
        if ( false === $ok ) {
            fprintf( $err, "        FAILED: db write error on %d\n", $id );
            exit( 1 );
        }
        clean_post_cache( $id );
    }
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fprintf( $err, "\n%s: %d links across %d posts\n", $apply ? 'Rewrote' : 'Would rewrite', $links, $changed );
if ( $apply ) {
    fprintf( $err, "Now re-run remove-floor-cull.php dry run — it should report no link debt.\n" );
}
