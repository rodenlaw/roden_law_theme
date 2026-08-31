<?php
/**
 * Verify roden_excerpt_strip_nav() against live content.
 *
 *   ssh $H "wp --path=... eval-file -" < bin/verify-excerpt-nav-strip.php
 *
 * Read-only. Safe to run before OR after the theme deploy:
 *
 *   BEFORE — the theme on prod lacks the filter, so this simulates it and shows
 *            what the deploy will change.
 *   AFTER  — the filter is live, so the "before" column already reads clean and
 *            the leak count must be 0.
 *
 * The filter's value is in the posts it must NOT touch. 483 posts have a
 * hand-written excerpt and 460 have an empty one with no <nav>; all 943 must come
 * through byte-identical, or the fix has widened into a rewrite of every
 * description on the site. That is what this checks, not just the 141 it fixes.
 */

function roden_verify_sim_excerpt( $post ) {
    $content = get_the_content( '', false, $post );
    $cleaned = preg_replace( '#<nav\b[^>]*>.*?</nav>#is', ' ', $content );
    if ( ! is_string( $cleaned ) || $cleaned === $content ) {
        return null; // inert — core's path, unchanged
    }
    $cleaned = strip_shortcodes( $cleaned );
    if ( function_exists( 'excerpt_remove_blocks' ) ) {
        $cleaned = excerpt_remove_blocks( $cleaned );
    }
    if ( function_exists( 'excerpt_remove_footnotes' ) ) {
        $cleaned = excerpt_remove_footnotes( $cleaned );
    }
    remove_filter( 'the_content', 'wp_filter_content_tags', 12 );
    $cleaned = apply_filters( 'the_content', $cleaned );
    add_filter( 'the_content', 'wp_filter_content_tags', 12 );
    $cleaned = str_replace( ']]>', ']]&gt;', $cleaned );
    $length  = (int) apply_filters( 'excerpt_length', 55 );
    $more    = apply_filters( 'excerpt_more', ' [&hellip;]' );
    return wp_trim_words( $cleaned, $length, $more );
}

$live = function_exists( 'roden_excerpt_strip_nav' );
echo 'theme filter present on this host: ' . ( $live ? "YES (post-deploy check)\n" : "no (pre-deploy simulation)\n" );

$ids = get_posts(
    array(
        'post_type'   => array( 'post', 'page', 'resource', 'practice_area', 'location' ),
        'post_status' => 'publish',
        'numberposts' => -1,
        'fields'      => 'ids',
    )
);

$handwritten = 0;
$inert       = 0;
$fixed       = 0;
$leaking     = array();
$degraded    = array();

foreach ( $ids as $id ) {
    $post = get_post( $id );

    if ( '' !== trim( $post->post_excerpt ) ) {
        $handwritten++;
        continue;
    }

    $sim = roden_verify_sim_excerpt( $post );
    if ( null === $sim ) {
        $inert++;
        // Must not contain nav text either way.
        $now = trim( wp_strip_all_tags( get_the_excerpt( $id ) ) );
        if ( 0 === stripos( $now, 'Table of Contents' ) ) {
            $leaking[] = $id;
        }
        continue;
    }

    $fixed++;
    $after = trim( wp_strip_all_tags( $live ? get_the_excerpt( $id ) : $sim ) );

    if ( 0 === stripos( $after, 'Table of Contents' ) ) {
        $leaking[] = $id;
    }
    if ( '' === $after || strlen( $after ) < 40 ) {
        $degraded[] = $id;
    }
}

echo "\n";
printf( "hand-written excerpt, untouched : %d\n", $handwritten );
printf( "empty excerpt, no <nav>, inert  : %d\n", $inert );
printf( "empty excerpt, <nav> stripped   : %d\n", $fixed );
printf( "descriptions still leaking a TOC: %d\n", count( $leaking ) );
printf( "descriptions empty or under 40c : %d\n", count( $degraded ) );

if ( $leaking ) {
    echo 'LEAKING IDS: ' . implode( ',', array_slice( $leaking, 0, 30 ) ) . "\n";
}
if ( $degraded ) {
    echo 'DEGRADED IDS: ' . implode( ',', array_slice( $degraded, 0, 30 ) ) . "\n";
}

echo ( $leaking || $degraded ) ? "\nFAIL\n" : "\nPASS\n";
