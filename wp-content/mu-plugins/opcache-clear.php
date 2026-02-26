<?php
/**
 * One-time OPcache invalidation for Roden Law theme files.
 * Forces PHP to recompile theme files after GitPush deployment.
 * Safe to remove after one page load.
 */

if ( ! function_exists( 'opcache_invalidate' ) ) {
    return;
}

$theme_dir = ABSPATH . 'wp-content/themes/roden-law/';
$files     = array(
    'header.php',
    'footer.php',
    'functions.php',
    'single-location.php',
    'front-page.php',
    'templates/template-location.php',
    'inc/firm-data.php',
    'inc/schema-helpers.php',
    'inc/template-tags.php',
    'style.css',
);

foreach ( $files as $file ) {
    $path = $theme_dir . $file;
    if ( file_exists( $path ) ) {
        opcache_invalidate( $path, true );
    }
}
