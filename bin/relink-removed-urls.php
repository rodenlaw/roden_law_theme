<?php
/**
 * Repoint editorial links at any removal batch's redirect targets.
 *
 * Generalised deliberately. bin/relink-batch-a-locations.php,
 * bin/relink-batch-c.php and bin/relink-dead-locations.php are three near-identical
 * copies of the same replacement logic, which is precisely the duplicated-render
 * problem CLAUDE.md says "has bitten twice" — a fix applied to one is not applied to
 * the others. This is the fourth batch to need it, so it takes a map function name
 * instead of hardcoding one. Prefer this for future batches.
 *
 * The map function must return path => target, as roden_phase1_removed_urls() and
 * its component functions do. Targets are READ from it rather than declared, so a
 * relinked href always lands exactly where the 301 would have sent it; if the two
 * disagreed we would be moving the hop rather than removing it.
 *
 * ANCHOR TEXT IS LEFT ALONE, as in every prior relink: "Folly Beach" still reads as
 * a link and simply resolves to the Charleston hub, rather than being unwrapped
 * mid-sentence.
 *
 *   Dry run:
 *     ssh $H "wp --path=$P eval-file - roden_corridor_fold_urls" \
 *       < bin/relink-removed-urls.php > relink-dry.json
 *
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - roden_corridor_fold_urls apply" \
 *       < bin/relink-removed-urls.php > docs/backups/<batch>-relink-<date>.json
 */

$fn    = isset( $args[0] ) ? (string) $args[0] : '';
$apply = isset( $args[1] ) && 'apply' === $args[1];

$err = fopen( 'php://stderr', 'w' );

$allowed = array( 'roden_corridor_fold_urls', 'roden_dead_location_urls', 'roden_phase1_batch_urls', 'roden_phase1_removed_urls' );
if ( ! in_array( $fn, $allowed, true ) ) {
    fprintf( $err, "Usage: eval-file - <map-function> [apply]\n  one of: %s\n", implode( ', ', $allowed ) );
    exit( 1 );
}
if ( ! function_exists( $fn ) ) {
    fprintf( $err, "ABORT: %s() is not defined — deploy the theme change first.\n", $fn );
    exit( 1 );
}

$map = call_user_func( $fn );
if ( ! is_array( $map ) || ! $map ) {
    fprintf( $err, "ABORT: %s() returned nothing.\n", $fn );
    exit( 1 );
}
fprintf( $err, "%s — relink via %s() (%d URLs)\n\n", $apply ? 'APPLY' : 'DRY RUN', $fn, count( $map ) );

global $wpdb;
$home   = untrailingslashit( home_url() );
$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'relink:' . $fn,
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'post_content before/after per post. Restore by writing "before" back to wp_posts.post_content.',
    'posts'     => array(),
);
$links = 0; $changed = 0; $es = 0;

foreach ( $map as $path => $target ) {
    /*
     * Both address forms where one exists. A child practice_area also answers at
     * /practice-areas/{pillar}/{child}/, and 7 of batch (c)'s 42 references used it.
     * roden_canonicalize_pa_path() decides whether a nested form maps back to this
     * path, so there is one definition of that relationship rather than a second
     * guess here.
     */
    $forms  = array( $path );
    $nested = '/practice-areas' . $path;
    if ( function_exists( 'roden_canonicalize_pa_path' )
        && roden_canonicalize_pa_path( $nested ) === $path ) {
        $forms[] = $nested;
    }

    $ids = array();
    foreach ( $forms as $f ) {
        $ids = array_merge( $ids, (array) $wpdb->get_col( $wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_type <> 'revision' AND post_content LIKE %s",
            '%' . $wpdb->esc_like( $f ) . '%'
        ) ) );
    }

    foreach ( array_unique( $ids ) as $id ) {
        $post = get_post( $id );
        if ( ! $post instanceof WP_Post ) {
            continue;
        }
        $before = $post->post_content;
        $after  = $before;

        /*
         * href only, absolute and site-relative, and only where the path is followed
         * by a quote, '#' or '?' — so /loris/ never matches /loris-heights/. String
         * replacement, not a regex: these bodies carry enough hand-written HTML that
         * a pattern is a liability. Verified against relative, absolute,
         * single-quoted, fragment and query forms, a longer sibling sharing the
         * prefix, and the bare place name in prose.
         */
        foreach ( $forms as $f ) {
            foreach ( array( $home . $f, $f ) as $needle ) {
                $rep = ( '/' === $needle[0] ) ? $target : $home . $target;
                foreach ( array( '"', "'" ) as $q ) {
                    $after = str_replace( $q . $needle . $q, $q . $rep . $q, $after );
                    foreach ( array( '#', '?' ) as $sfx ) {
                        $after = str_replace( $q . $needle . $sfx, $q . $rep . $sfx, $after );
                    }
                }
            }
        }

        if ( $after === $before ) {
            continue;
        }

        $n = 0;
        foreach ( $forms as $f ) {
            $n += substr_count( $before, $f ) - substr_count( $after, $f );
        }
        $links += max( $n, 0 );
        $changed++;
        $is_es = ( 'es' === get_post_meta( $post->ID, '_roden_locale', true ) );
        if ( $is_es ) {
            $es++;
        }
        $backup['posts'][] = array(
            'ID' => (int) $post->ID, 'post_title' => $post->post_title,
            'permalink' => get_permalink( $post ), 'locale' => $is_es ? 'es' : 'en',
            'from' => $path, 'to' => $target, 'before' => $before, 'after' => $after,
        );
        fprintf( $err, "  %-5d %-3s %-56s -> %s\n", $post->ID, $is_es ? 'es' : 'en', $path, $target );

        if ( $apply ) {
            /*
             * Direct column write, not wp_update_post(): that stamps post_modified,
             * and single.php renders "Updated <date>" from it with schema
             * dateModified and og:article:modified_time alongside. Repointing a
             * hyperlink must not advertise legal posts as freshly updated on a site
             * being re-rated for quality. Verified byte-identical on batches (a) and (c).
             */
            $ok = $wpdb->update( $wpdb->posts, array( 'post_content' => $after ),
                array( 'ID' => $post->ID ), array( '%s' ), array( '%d' ) );
            if ( false === $ok ) {
                fprintf( $err, "        FAILED: db write error on %d\n", $post->ID );
                exit( 1 );
            }
            clean_post_cache( $post->ID );
        }
    }
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fprintf( $err, "\n%s: %d links across %d posts", $apply ? 'Rewrote' : 'Would rewrite', $links, $changed );
fprintf( $err, $es ? " (%d of them /es/ posts linking to English URLs — pre-existing, preserved)\n" : "\n", $es );
