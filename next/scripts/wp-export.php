<?php
/**
 * WordPress Content Exporter for Sanity Migration
 * Run via WP-CLI: wp eval-file wp-content/themes/roden-law/../../next/scripts/wp-export.php
 * Or copy to theme: wp eval-file wp-content/themes/roden-law/inc/wp-export.php
 * Outputs JSON to /tmp/roden-export.json
 */

$out = ['practice_area' => [], 'location' => [], 'attorney' => [], 'case_result' => [], 'testimonial' => [], 'resource' => [], 'post' => [], 'taxonomy' => []];

$types = ['practice_area','location','attorney','case_result','testimonial','resource','post'];
foreach ($types as $type) {
    $posts = get_posts(['post_type' => $type, 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'ID', 'order' => 'ASC']);
    foreach ($posts as $p) {
        $meta = get_post_meta($p->ID);
        $clean_meta = [];
        foreach ($meta as $k => $v) {
            if (strpos($k, '_roden_') === 0 || in_array($k, ['_thumbnail_id'])) {
                $clean_meta[$k] = maybe_unserialize($v[0]);
            }
        }
        // Get featured image URL
        $thumb_url = '';
        if (!empty($clean_meta['_thumbnail_id'])) {
            $thumb_url = wp_get_attachment_url((int)$clean_meta['_thumbnail_id']);
        }
        // Get taxonomies
        $cats = wp_get_object_terms($p->ID, 'practice_category', ['fields' => 'slugs']);
        $locs = wp_get_object_terms($p->ID, 'location_served', ['fields' => 'slugs']);

        $out[$type][] = [
            'id' => $p->ID,
            'title' => $p->post_title,
            'slug' => $p->post_name,
            'content' => $p->post_content,
            'excerpt' => $p->post_excerpt,
            'parent' => $p->post_parent,
            'date' => $p->post_date,
            'modified' => $p->post_modified,
            'meta' => $clean_meta,
            'featured_image' => $thumb_url,
            'practice_category' => is_wp_error($cats) ? [] : $cats,
            'location_served' => is_wp_error($locs) ? [] : $locs,
        ];
    }
    WP_CLI::log("Exported " . count($out[$type]) . " {$type} posts");
}

// Taxonomies
foreach (['practice_category', 'location_served', 'category'] as $tax) {
    $terms = get_terms(['taxonomy' => $tax, 'hide_empty' => false]);
    if (!is_wp_error($terms)) {
        foreach ($terms as $t) {
            $out['taxonomy'][] = ['taxonomy' => $tax, 'name' => $t->name, 'slug' => $t->slug, 'count' => $t->count];
        }
    }
}
WP_CLI::log("Exported " . count($out['taxonomy']) . " taxonomy terms");

$json = json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
file_put_contents('/tmp/roden-export.json', $json);
WP_CLI::success("Export saved to /tmp/roden-export.json (" . strlen($json) . " bytes)");
