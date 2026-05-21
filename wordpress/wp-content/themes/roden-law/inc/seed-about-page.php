<?php
/**
 * Seed script: Ensure the /about/ Page exists.
 *
 * Idempotent — running this repeatedly is safe:
 *   - If a published Page with slug "about" exists, no-op.
 *   - If a trashed Page with slug "about" exists, restore it to publish.
 *   - Otherwise, create a new Page (title "About", slug "about", empty body).
 *
 * The theme file page-about.php applies automatically via the WP
 * page-{slug}.php template hierarchy, so no page_template assignment
 * is needed and post_content can stay empty — all rendering is in PHP.
 *
 * Usage (on WP Engine):
 *   wp eval-file wp-content/themes/roden-law/inc/seed-about-page.php
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_CLI' ) ) {
    return;
}

$slug = 'about';

$published = get_page_by_path( $slug, OBJECT, 'page' );

if ( $published && 'publish' === $published->post_status ) {
    WP_CLI::success( "About page already exists and is published (ID: {$published->ID})." );
    return;
}

if ( $published && 'trash' === $published->post_status ) {
    $restored = wp_untrash_post( $published->ID );
    if ( ! $restored ) {
        WP_CLI::error( "Failed to restore trashed About page (ID: {$published->ID})." );
        return;
    }
    wp_update_post( array(
        'ID'          => $published->ID,
        'post_status' => 'publish',
        'post_name'   => $slug,
    ) );
    WP_CLI::success( "Restored trashed About page (ID: {$published->ID}) to publish." );
    return;
}

$existing = get_posts( array(
    'name'        => $slug,
    'post_type'   => 'page',
    'post_status' => 'any',
    'numberposts' => 1,
) );

if ( ! empty( $existing ) ) {
    $post = $existing[0];
    wp_update_post( array(
        'ID'          => $post->ID,
        'post_status' => 'publish',
        'post_name'   => $slug,
    ) );
    WP_CLI::success( "Promoted existing About page (ID: {$post->ID}, prior status: {$post->post_status}) to publish." );
    return;
}

$page_id = wp_insert_post( array(
    'post_type'    => 'page',
    'post_title'   => 'About',
    'post_name'    => $slug,
    'post_status'  => 'publish',
    'post_content' => '',
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
), true );

if ( is_wp_error( $page_id ) ) {
    WP_CLI::error( $page_id->get_error_message() );
    return;
}

WP_CLI::success( "Created About page (ID: {$page_id}, slug: /{$slug}/)." );
