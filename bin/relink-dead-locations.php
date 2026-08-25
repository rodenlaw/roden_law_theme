<?php
/**
 * Repoint editorial links that point at the 66 retired location pages.
 *
 * Run BEFORE bin/remove-dead-location-pages.php. That script refuses to apply
 * while any published post still links to one of these URLs, because shipping it
 * would leave real editorial links resolving through a 301 — which the plan's
 * acceptance criteria forbid (SEO-PREEMPTION-PLAN-rodenlaw.md §4).
 *
 * The href is repointed at the parent office-city hub; the ANCHOR TEXT IS LEFT
 * ALONE. So "Mount Pleasant" still reads as a link and simply resolves to
 * Charleston, rather than being unwrapped mid-sentence. Same approach as
 * bin/relink-batch-a-locations.php, which did this for 53 links across 23 posts.
 *
 * Paths and targets come from roden_dead_location_urls() in inc/legacy-redirects.php.
 * Nothing is duplicated here, so the relink set cannot drift from the redirect map.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/relink-dead-locations.php \
 *       > docs/backups/dead-locations-relink-$(date +%Y-%m-%d).json
 *
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/relink-dead-locations.php \
 *       > docs/backups/dead-locations-relink-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — relink the 66 dead location pages\n\n", $apply ? 'APPLY' : 'DRY RUN' );

if ( ! function_exists( 'roden_dead_location_urls' ) ) {
    fprintf( $err, "ABORT: roden_dead_location_urls() is not defined — deploy the theme change first.\n" );
    exit( 1 );
}
$map = roden_dead_location_urls();

global $wpdb;
$home    = untrailingslashit( home_url() );
$backup  = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'dead-locations-relink',
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
         * Replace the href only, in both absolute and site-relative form, and only
         * where the path is followed by a quote, '#' or '?' — so /…/loris/ never
         * matches /…/loris-heights/, which shares its prefix. String replacement,
         * not a regex: these bodies carry enough hand-written HTML that a pattern
         * is a liability, which is why relink-batch-a-locations.php avoided one too.
         *
         * Verified against relative, absolute, single-quoted, fragment and query
         * forms, a longer sibling path, and the bare town name in prose. Only the
         * five link forms change; the sibling and the prose are left alone.
         */
        $after = $before;
        foreach ( array( $home . $path, $path ) as $needle ) {
            $rep = ( $needle === $path ) ? $target : $home . $target;
            foreach ( array( '"', "'" ) as $q ) {
                // href="...loris/"  — the ordinary case
                $after = str_replace( $q . $needle . $q, $q . $rep . $q, $after );
                // href="...loris/#faq" and href="...loris/?ref=x" — rarer, but the
                // removal script's link-debt check finds these too, so a relink that
                // skipped them would leave it aborting on links nothing could fix.
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
        fprintf( $err, "  %-5d %-46s -> %s\n", $post->ID, $path, $target );

        if ( $apply ) {
            /*
             * Direct column write, deliberately, not wp_update_post().
             *
             * wp_update_post() stamps post_modified, and single.php renders an
             * "Updated <date>" line from it with schema dateModified and
             * og:article:modified_time alongside. Repointing a hyperlink would
             * therefore advertise legal blog posts as freshly updated when nothing
             * a reader cares about changed — the wrong signal on a site being
             * re-rated for quality. Verified on batch (a): post_modified was
             * byte-identical before and after.
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
    fprintf( $err, "Now re-run remove-dead-location-pages.php dry run — it should report no link debt.\n" );
}
