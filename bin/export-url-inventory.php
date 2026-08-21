<?php
/**
 * Export every published, publicly-queryable URL with the facts needed to
 * triage it for the SEO pre-emption plan (Phase 1).
 *
 * Run from the repo, piped over stdin — never deployed:
 *   ssh $H "wp --path=$P eval-file -" < bin/export-url-inventory.php > url-inventory.csv
 *
 * Body length counts post_content AND the meta fields that actually carry the
 * prose on this site: several templates render _roden_why_hire and friends
 * instead of post_content, so a post_content-only word count reads thin pages
 * as empty and real pages as thin.
 */

$types = get_post_types( array( 'public' => true ), 'names' );
unset( $types['attachment'] );

$meta_body_keys = array( '_roden_why_hire', '_roden_intro', '_roden_content', '_roden_body' );

$out = fopen( 'php://stdout', 'w' );
fputcsv( $out, array( 'url', 'post_type', 'path_depth', 'locale', 'post_id', 'slug', 'words', 'parent_id', 'status', 'title' ) );

foreach ( $types as $type ) {
    $paged = 1;
    while ( true ) {
        $q = new WP_Query( array(
            'post_type'              => $type,
            'post_status'            => 'publish',
            'posts_per_page'         => 200,
            'paged'                  => $paged,
            'no_found_rows'          => false,
            'ignore_sticky_posts'    => true,
            'update_post_term_cache' => false,
        ) );
        if ( ! $q->have_posts() ) {
            break;
        }

        foreach ( $q->posts as $p ) {
            $url  = get_permalink( $p );
            $path = (string) wp_parse_url( $url, PHP_URL_PATH );
            $segs = array_values( array_filter( explode( '/', trim( $path, '/' ) ), 'strlen' ) );

            $locale = ( isset( $segs[0] ) && 'es' === $segs[0] ) ? 'es' : 'en';
            $depth  = count( $segs );

            $text = (string) $p->post_content;
            foreach ( $meta_body_keys as $mk ) {
                $mv = get_post_meta( $p->ID, $mk, true );
                if ( is_string( $mv ) && '' !== $mv ) {
                    $text .= ' ' . $mv;
                }
            }
            $words = str_word_count( wp_strip_all_tags( strip_shortcodes( $text ) ) );

            fputcsv( $out, array(
                $url,
                $type,
                $depth,
                $locale,
                $p->ID,
                $p->post_name,
                $words,
                $p->post_parent,
                $p->post_status,
                $p->post_title,
            ) );
        }
        $paged++;
        wp_reset_postdata();
    }
}
fclose( $out );
