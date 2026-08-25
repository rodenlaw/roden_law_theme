<?php
/**
 * Repoint editorial links that point at the 11 batch (c) micro-permutation pages.
 *
 * Run BEFORE bin/remove-micro-permutations.php, which refuses to apply while any
 * published post still links to one of these URLs.
 *
 * WHY THIS EXISTS, AND WHY IT WAS NOT ANTICIPATED. PR #61 said batch (c) needed no
 * link stripping, on the grounds that every one of the 11 is linked from its parent
 * pillar by $child_subtypes — a get_posts() query that self-heals when the post is
 * trashed. That was true and it was not the whole picture: a DB sweep after the
 * redirects deployed found 42 editorial links in post BODIES across 25 posts, which
 * no template query touches. Batch (a) hit the same thing (53 links, 23 posts). The
 * lesson is that "the grid self-heals" answers a different question from "is this
 * URL linked", and only the second one gates a removal.
 *
 * Targets are read from roden_phase1_removed_urls() rather than declared here, so a
 * relinked href always lands exactly where the 301 would have sent it. If the two
 * disagreed we would simply be moving the hop rather than removing it.
 *
 * The ANCHOR TEXT IS LEFT ALONE, as in bin/relink-batch-a-locations.php: "I-26
 * accident lawyer" still reads as a link and resolves to the car-accident pillar,
 * rather than being unwrapped mid-sentence.
 *
 * Note on the Spanish posts. Seven of the 25 are /es/ posts linking to ENGLISH
 * URLs — pre-existing, and this script preserves it rather than silently
 * "improving" it, because repointing them at /es/practice-areas/ is a content
 * decision, not a link-hygiene one. Flagged in the run summary.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/relink-batch-c.php > relink-dry.json
 *
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/relink-batch-c.php \
 *       > docs/backups/batch-c-relink-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

$paths = array(
    '/car-accident-lawyers/ashley-phosphate-road-accident/',
    '/car-accident-lawyers/dorchester-road-accident/',
    '/car-accident-lawyers/i-26-accident/',
    '/car-accident-lawyers/i-526-accident/',
    '/car-accident-lawyers/rivers-avenue-accident/',
    '/motorcycle-accident-lawyers/dorchester-road-motorcycle/',
    '/pedestrian-accident-lawyers/rivers-avenue-pedestrian/',
    '/truck-accident-lawyers/i-26-truck-accident/',
    '/workers-compensation-lawyers/boeing-aerospace-injury/',
    '/workers-compensation-lawyers/gulfstream-aerospace-injury/',
    '/workers-compensation-lawyers/savannah-port-worker-injury/',
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — relink batch (c)\n\n", $apply ? 'APPLY' : 'DRY RUN' );

if ( ! function_exists( 'roden_phase1_removed_urls' ) ) {
    fprintf( $err, "ABORT: roden_phase1_removed_urls() is not defined.\n" );
    exit( 1 );
}
$map = roden_phase1_removed_urls();
foreach ( $paths as $p ) {
    if ( empty( $map[ $p ] ) ) {
        fprintf( $err, "ABORT: %s is not in the redirect map — relinking it would point at a live page that is about to be trashed.\n", $p );
        exit( 1 );
    }
}

global $wpdb;
$home = untrailingslashit( home_url() );
$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'batch-c-relink',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'post_content before/after per post. Restore by writing "before" back to wp_posts.post_content.',
    'posts'     => array(),
);
$links = 0; $changed = 0; $es = 0;

foreach ( $paths as $path ) {
    $target = $map[ $path ];
    $like   = '%' . $wpdb->esc_like( $path ) . '%';
    $ids    = $wpdb->get_col( $wpdb->prepare(
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
         * href only, absolute and site-relative, and only where the path is
         * followed by a quote, '#' or '?' — so /i-26-accident/ never matches
         * /i-26-accident-lawyer/. String replacement, not a regex: these bodies
         * carry enough hand-written HTML that a pattern is a liability.
         */
        /*
         * Both address forms. Some bodies link the NESTED practice-area path
         * (/practice-areas/car-accident-lawyers/i-26-accident/) rather than the flat
         * canonical — 7 of the 42 references found. Those are links too, and after
         * the trash step they would resolve only via the removal handler's
         * canonicalisation rather than pointing somewhere real, so they get
         * repointed as well.
         */
        $forms = array( $path );
        $nested = '/practice-areas' . $path;
        if ( function_exists( 'roden_canonicalize_pa_path' )
            && roden_canonicalize_pa_path( $nested ) === $path ) {
            $forms[] = $nested;
        }

        $after = $before;
        $needles = array();
        foreach ( $forms as $f ) {
            $needles[] = $home . $f;
            $needles[] = $f;
        }
        foreach ( $needles as $needle ) {
            $rep = ( '/' === $needle[0] ) ? $target : $home . $target;
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
        fprintf( $err, "  %-5d %-3s %-54s -> %s\n", $post->ID, $is_es ? 'es' : 'en', $path, $target );

        if ( $apply ) {
            /*
             * Direct column write, not wp_update_post(): that stamps post_modified,
             * and single.php renders "Updated <date>" from it with schema
             * dateModified and og:article:modified_time alongside. Repointing a
             * hyperlink must not advertise legal posts as freshly updated on a site
             * being re-rated for quality. Verified on batch (a): byte-identical.
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
fprintf( $err, "\n%s: %d links across %d posts (%d of them /es/ posts linking to English URLs — pre-existing, preserved)\n",
    $apply ? 'Rewrote' : 'Would rewrite', $links, $changed, $es );
if ( $apply ) {
    fprintf( $err, "Now re-run bin/remove-micro-permutations.php dry run — it should no longer abort.\n" );
}
