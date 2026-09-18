<?php
/**
 * Repoint editorial links that point at the 13 retired EVALUATE location pages.
 *
 * Run BEFORE bin/remove-evaluate-location-pages.php, which refuses to apply
 * while any published post still links to one of these URLs (SEO-PREEMPTION-PLAN
 * §4 forbids editorial links that resolve through a 301).
 *
 * Same mechanics as bin/relink-dead-locations.php (#68): href only, anchor text
 * untouched, direct column write so post_modified is not stamped and the post
 * does not advertise itself as freshly updated. Paths and targets are read from
 * roden_evaluate_location_urls() in inc/legacy-redirects.php — nothing is
 * duplicated here, so the relink set cannot drift from the redirect map.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/relink-evaluate-locations.php \
 *       > docs/backups/evaluate-locations-relink-$(date +%Y-%m-%d).json
 *
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/relink-evaluate-locations.php \
 *       > docs/backups/evaluate-locations-relink-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — relink the 13 EVALUATE location pages\n\n", $apply ? 'APPLY' : 'DRY RUN' );

if ( ! function_exists( 'roden_evaluate_location_urls' ) ) {
    fprintf( $err, "ABORT: roden_evaluate_location_urls() is not defined — deploy the theme change first.\n" );
    exit( 1 );
}
$map = roden_evaluate_location_urls();

global $wpdb;
$home    = untrailingslashit( home_url() );
$backup  = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'evaluate-locations-relink',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'post_content before/after per post. Restore by writing "before" back to wp_posts.post_content.',
    'posts'     => array(),
);
$links = 0;
$changed = 0;

foreach ( $map as $path => $target ) {
    $like = '%' . $wpdb->esc_like( $path ) . '%';
    $ids  = $wpdb->get_col( $wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_type <> 'revision' AND post_content LIKE %s",
        $like
    ) );
    foreach ( $ids as $id ) {
        $post = get_post( $id );
        if ( ! $post instanceof WP_Post ) {
            continue;
        }
        $before = $post->post_content;

        /*
         * Replace the href only, absolute and site-relative, and only where the
         * path is followed by a quote, '#' or '?' — so /…/little-river/ never
         * matches a longer sibling. String replacement, not a regex, for the same
         * reason the earlier relink scripts avoided one: hand-written HTML.
         */
        $after = $before;
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

        $n = substr_count( $before, $path ) - substr_count( $after, $path );
        $links   += max( $n, 0 );
        $changed += 1;
        $backup['posts'][] = array(
            'ID'         => (int) $post->ID,
            'post_title' => $post->post_title,
            'permalink'  => get_permalink( $post ),
            'from'       => $path,
            'to'         => $target,
            'before'     => $before,
            'after'      => $after,
        );
        fprintf( $err, "  %-5d %-56s -> %s\n", $post->ID, $path, $target );

        if ( $apply ) {
            /*
             * Direct column write, deliberately, not wp_update_post(): that would
             * stamp post_modified and single.php renders "Updated <date>" from it
             * with schema dateModified alongside. A direct write also bypasses the
             * wp_unslash() in wp_update_post(), so no wp_slash() is needed here.
             */
            $ok = $wpdb->update(
                $wpdb->posts,
                array( 'post_content' => $after ),
                array( 'ID' => $post->ID ),
                array( '%s' ),
                array( '%d' )
            );
            if ( false === $ok ) {
                fprintf( $err, "        FAILED: db write error on %d\n", $post->ID );
                exit( 1 );
            }
            clean_post_cache( $post->ID );
        }
    }
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fprintf( $err, "\n%s: %d links across %d posts\n", $apply ? 'Rewrote' : 'Would rewrite', $links, $changed );
if ( $apply ) {
    fprintf( $err, "Now re-run remove-evaluate-location-pages.php dry run — it should report no link debt.\n" );
}
