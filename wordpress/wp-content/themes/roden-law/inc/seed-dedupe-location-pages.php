<?php
/**
 * Seeder: draft the 6 losing duplicate location pages — audit item #5.
 *
 * The 301s live in the redirect map (legacy-redirects.php CATEGORY 15) and
 * fire regardless of post status; drafting the posts removes them from the
 * sitemap and from hub-page children grids (publish-only queries).
 *
 * Run over SSH:  wp eval-file wp-content/themes/roden-law/inc/seed-dedupe-location-pages.php        (dry run)
 *                wp eval-file wp-content/themes/roden-law/inc/seed-dedupe-location-pages.php live   (commit)
 *
 * Resolves posts by comparing each published location post's permalink path
 * to the losing URL — immune to slug/parent ambiguity (two posts named
 * "guyton" exist under different parents).
 */

defined( 'ABSPATH' ) || exit;

$live = isset( $args ) && in_array( 'live', (array) $args, true );

$losers = array(
    '/locations/georgia/savannah/effingham-county/guyton/',
    '/locations/georgia/savannah/effingham-county/springfield/',
    '/locations/south-carolina/charleston/mount-pleasant/sullivans-island/',
    '/locations/south-carolina/columbia/columbia/',
    '/locations/south-carolina/myrtle-beach/myrtle-beach/',
    '/locations/georgia/darien/darien/',
);

$by_path = array();
foreach ( get_posts( array( 'post_type' => 'location', 'posts_per_page' => -1, 'post_status' => 'publish', 'fields' => 'ids' ) ) as $id ) {
    $path = wp_parse_url( get_permalink( $id ), PHP_URL_PATH );
    if ( $path ) {
        $by_path[ trailingslashit( $path ) ] = $id;
    }
}

echo $live ? "MODE: LIVE\n" : "MODE: DRY RUN (pass 'live' to commit)\n";

foreach ( $losers as $path ) {
    if ( ! isset( $by_path[ $path ] ) ) {
        echo "MISS  $path — no published location post at this path (already drafted?)\n";
        continue;
    }
    $id = $by_path[ $path ];
    if ( $live ) {
        wp_update_post( array( 'ID' => $id, 'post_status' => 'draft' ) );
        echo "DRAFTED  #$id  $path\n";
    } else {
        echo "WOULD DRAFT  #$id  $path  (" . get_the_title( $id ) . ")\n";
    }
}

echo "Done. Remember: wp cache flush && wp page-cache flush\n";
