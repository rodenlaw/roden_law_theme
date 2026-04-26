<?php
/**
 * Cleanup leftover Rank Math + SmartCrawl (WDS) data.
 *
 * Run once via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/cleanup-seo-plugins.php
 *
 * Safe to run multiple times — only deletes if rows exist.
 */

defined( 'ABSPATH' ) || exit;

global $wpdb;

// ──────────────────────────────────────────────
// 1. Rank Math — wp_options
// ──────────────────────────────────────────────
$rm_options = $wpdb->get_col(
    "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'rank_math%' OR option_name LIKE 'rank-math%'"
);
// Also catch the admin-columns option for rank math
$rm_options[] = 'cpac_options_rank_math_locations__default';
$rm_options[] = 'cpac_options_rank_math_schema__default';
$rm_options = array_unique( array_filter( $rm_options ) );

echo "=== Rank Math: wp_options ===\n";
echo "Found " . count( $rm_options ) . " options.\n";
foreach ( $rm_options as $opt ) {
    delete_option( $opt );
    echo "  Deleted: $opt\n";
}

// ──────────────────────────────────────────────
// 2. Rank Math — wp_postmeta
// ──────────────────────────────────────────────
$rm_meta_count = $wpdb->get_var(
    "SELECT COUNT(*) FROM $wpdb->postmeta WHERE meta_key LIKE 'rank_math%'"
);
echo "\n=== Rank Math: wp_postmeta ===\n";
echo "Found $rm_meta_count rows.\n";
if ( $rm_meta_count > 0 ) {
    $wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE 'rank_math%'" );
    echo "  Deleted $rm_meta_count rows.\n";
}

// ──────────────────────────────────────────────
// 3. Rank Math — wp_termmeta
// ──────────────────────────────────────────────
$rm_termmeta_count = $wpdb->get_var(
    "SELECT COUNT(*) FROM $wpdb->termmeta WHERE meta_key LIKE 'rank_math%'"
);
echo "\n=== Rank Math: wp_termmeta ===\n";
echo "Found $rm_termmeta_count rows.\n";
if ( $rm_termmeta_count > 0 ) {
    $wpdb->query( "DELETE FROM $wpdb->termmeta WHERE meta_key LIKE 'rank_math%'" );
    echo "  Deleted $rm_termmeta_count rows.\n";
}

// ──────────────────────────────────────────────
// 4. Rank Math — wp_usermeta
// ──────────────────────────────────────────────
$rm_usermeta_count = $wpdb->get_var(
    "SELECT COUNT(*) FROM $wpdb->usermeta WHERE meta_key LIKE 'rank_math%'"
);
echo "\n=== Rank Math: wp_usermeta ===\n";
echo "Found $rm_usermeta_count rows.\n";
if ( $rm_usermeta_count > 0 ) {
    $wpdb->query( "DELETE FROM $wpdb->usermeta WHERE meta_key LIKE 'rank_math%'" );
    echo "  Deleted $rm_usermeta_count rows.\n";
}

// ──────────────────────────────────────────────
// 5. Rank Math — custom tables
// ──────────────────────────────────────────────
echo "\n=== Rank Math: custom tables ===\n";
$rm_tables = $wpdb->get_col(
    "SHOW TABLES LIKE '{$wpdb->prefix}rank_math%'"
);
if ( ! empty( $rm_tables ) ) {
    foreach ( $rm_tables as $table ) {
        $wpdb->query( "DROP TABLE IF EXISTS `$table`" );
        echo "  Dropped: $table\n";
    }
} else {
    echo "  No custom tables found.\n";
}

// ──────────────────────────────────────────────
// 6. SmartCrawl (WDS) — wp_options
// ──────────────────────────────────────────────
$wds_options = $wpdb->get_col(
    "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'wds%' OR option_name LIKE 'wds-%'"
);
$wds_options = array_unique( array_filter( $wds_options ) );

echo "\n=== SmartCrawl (WDS): wp_options ===\n";
echo "Found " . count( $wds_options ) . " options.\n";
foreach ( $wds_options as $opt ) {
    delete_option( $opt );
    echo "  Deleted: $opt\n";
}

// ──────────────────────────────────────────────
// 7. SmartCrawl (WDS) — wp_postmeta
// ──────────────────────────────────────────────
$wds_meta_count = $wpdb->get_var(
    "SELECT COUNT(*) FROM $wpdb->postmeta WHERE meta_key LIKE '_wds%' OR meta_key LIKE 'wds_%'"
);
echo "\n=== SmartCrawl (WDS): wp_postmeta ===\n";
echo "Found $wds_meta_count rows.\n";
if ( $wds_meta_count > 0 ) {
    $wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE '_wds%' OR meta_key LIKE 'wds_%'" );
    echo "  Deleted $wds_meta_count rows.\n";
}

// ──────────────────────────────────────────────
// 8. Rank Math — transients
// ──────────────────────────────────────────────
echo "\n=== Rank Math: transients ===\n";
$rm_transients = $wpdb->get_var(
    "SELECT COUNT(*) FROM $wpdb->options WHERE option_name LIKE '%rank_math%' AND option_name LIKE '_transient%'"
);
echo "Found $rm_transients transient rows.\n";
if ( $rm_transients > 0 ) {
    $wpdb->query(
        "DELETE FROM $wpdb->options WHERE option_name LIKE '%rank_math%' AND option_name LIKE '_transient%'"
    );
    echo "  Deleted.\n";
}

// ──────────────────────────────────────────────
// 9. Flush rewrite rules
// ──────────────────────────────────────────────
echo "\n=== Flushing rewrite rules ===\n";
flush_rewrite_rules();
echo "  Done.\n";

echo "\n✅ Cleanup complete. Verify sitemap at /wp-sitemap.xml\n";
