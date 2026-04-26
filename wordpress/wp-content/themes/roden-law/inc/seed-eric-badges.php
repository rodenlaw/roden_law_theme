<?php
/**
 * One-time seeder: Add badge images to Eric Roden's attorney profile.
 * Run via: wp eval-file wp-content/themes/roden-law/inc/seed-eric-badges.php
 */

$eric_id = 3729;

$badges = array(
    array(
        'image' => 'img-badge-top-100-high-stakes-litigators-2026.png',
        'alt'   => "America's Top 100 High Stakes Litigators 2026",
    ),
);

update_post_meta( $eric_id, '_roden_atty_badges', $badges );

// Also add to text awards if not already there
$awards = get_post_meta( $eric_id, '_roden_awards', true );
if ( ! is_array( $awards ) ) {
    $awards = array();
}

$already_has = false;
foreach ( $awards as $aw ) {
    if ( isset( $aw['award'] ) && strpos( $aw['award'], 'Top 100 High Stakes' ) !== false ) {
        $already_has = true;
        break;
    }
}

if ( ! $already_has ) {
    $awards[] = array(
        'award' => "America's Top 100 High Stakes Litigators",
        'year'  => '2026',
    );
    update_post_meta( $eric_id, '_roden_awards', $awards );
    WP_CLI::success( 'Added award text + badge to Eric Roden (ID ' . $eric_id . ').' );
} else {
    WP_CLI::success( 'Badge added. Award text already existed for Eric Roden (ID ' . $eric_id . ').' );
}
