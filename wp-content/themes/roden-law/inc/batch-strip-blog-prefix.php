<?php
/**
 * ONE-TIME USE: Bulk-rename post slugs to strip "blog-" prefix.
 *
 * Run via WP-CLI:   wp eval-file wp-content/themes/roden-law/inc/batch-strip-blog-prefix.php
 * Or add temporarily to functions.php with an admin_init hook (remove after running).
 *
 * IMPORTANT: The pattern redirect in legacy-redirects.php handles 301s
 * from old /blog/blog-[slug]/ to new /blog/[slug]/ URLs automatically.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $wpdb;

// Find all published posts whose slug starts with "blog-"
$posts = $wpdb->get_results(
    "SELECT ID, post_name, post_title
     FROM {$wpdb->posts}
     WHERE post_type = 'post'
       AND post_status IN ('publish', 'draft', 'pending')
       AND post_name LIKE 'blog-%'
     ORDER BY ID ASC"
);

$renamed  = 0;
$skipped  = 0;
$conflicts = array();

foreach ( $posts as $post ) {
    $old_slug = $post->post_name;
    $new_slug = preg_replace( '/^blog-/', '', $old_slug );

    // Skip if slug doesn't actually start with blog-
    if ( $new_slug === $old_slug ) {
        $skipped++;
        continue;
    }

    // Check for slug conflicts — another post might already use the new slug
    $existing = $wpdb->get_var( $wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts}
         WHERE post_name = %s AND post_type = 'post' AND ID != %d",
        $new_slug,
        $post->ID
    ) );

    if ( $existing ) {
        $conflicts[] = array(
            'post_id'  => $post->ID,
            'old_slug' => $old_slug,
            'new_slug' => $new_slug,
            'conflict_id' => $existing,
        );
        continue;
    }

    // Rename the slug
    $wpdb->update(
        $wpdb->posts,
        array( 'post_name' => $new_slug ),
        array( 'ID' => $post->ID ),
        array( '%s' ),
        array( '%d' )
    );

    $renamed++;

    // Log progress every 50 posts
    if ( $renamed % 50 === 0 ) {
        if ( defined( 'WP_CLI' ) ) {
            WP_CLI::log( "Renamed {$renamed} slugs so far..." );
        }
    }
}

// Clean permalink cache
clean_post_cache( 0 );
wp_cache_flush();

// Output results
$summary = "BLOG SLUG CLEANUP: Renamed {$renamed} slugs, skipped {$skipped}, conflicts: " . count( $conflicts );

if ( defined( 'WP_CLI' ) ) {
    WP_CLI::success( $summary );
    if ( ! empty( $conflicts ) ) {
        WP_CLI::warning( 'Slug conflicts found:' );
        foreach ( $conflicts as $c ) {
            WP_CLI::log( "  Post {$c['post_id']}: {$c['old_slug']} → {$c['new_slug']} (conflicts with post {$c['conflict_id']})" );
        }
    }
} else {
    error_log( $summary );
    if ( ! empty( $conflicts ) ) {
        error_log( 'Conflicts: ' . print_r( $conflicts, true ) );
    }
}
