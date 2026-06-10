<?php
/**
 * WordPress Content Exporter — STDOUT variant for piping over a single SSH
 * session (WP Engine runs each ssh/scp connection in a separate ephemeral
 * container, so a file written by scp isn't visible to a later ssh session).
 *
 * Usage (from repo root):
 *   ssh … "wp eval-file - 2>/dev/null" < next/scripts/wp-export-stdout.php > next/scripts/roden-export.json
 *
 * Emits the export JSON to STDOUT; progress goes to STDERR so it never
 * corrupts the captured JSON. Mirrors wp-export.php exactly otherwise.
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
        $thumb_url = '';
        if (!empty($clean_meta['_thumbnail_id'])) {
            $thumb_url = wp_get_attachment_url((int)$clean_meta['_thumbnail_id']);
        }
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
    fwrite(STDERR, "Exported " . count($out[$type]) . " {$type} posts\n");
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
fwrite(STDERR, "Exported " . count($out['taxonomy']) . " taxonomy terms\n");

$json = json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
fwrite(STDERR, "Export size: " . strlen($json) . " bytes\n");
echo $json;
