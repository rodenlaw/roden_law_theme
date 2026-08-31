<?php
/**
 * Step 1 of KNOWLEDGE-BASE-PLAN-rodenlaw.md — upgrade the Super Speeder page.
 *
 *   ssh $H "wp --path=... eval-file -" < bin/upgrade-super-speeder-page.php
 *
 * /blog/georgia-super-speeder-law/ (post 1790) earns 63,120 impressions and 58
 * clicks at position 29.6. The body is not the problem: 1,853 words, O.C.G.A.
 * § 40-6-189(b) cited correctly, a two-state comparison table, FAQs and key
 * takeaways all present, and custom_h1_title already reads "What Is a Super
 * Speeder in Georgia?". Two fields around it are.
 *
 * 1. post_title is "What Are Excessive Speeding Laws?" — it does not contain
 *    the phrase anyone searches. There is no SEO plugin on this site; the title
 *    tag is post_title straight through document_title_parts, and
 *    roden_seo_title_optimization() does not touch the `post` type at all. So
 *    post_title IS the title tag. "super speeder ga" (2,322 impr) ranks 43.6,
 *    "georgia super speeder law" (502 impr) ranks 35.9.
 *
 * 2. post_excerpt is EMPTY, so get_the_excerpt() auto-generates from
 *    post_content — which begins with the TOC nav. The page therefore publishes
 *    "Table of Contents What Is a Super Speeder in Georgia? How the Super
 *    Speeder Law Works..." as BOTH its <meta name="description"> and its Article
 *    schema `description`, because roden_seo_get_description() and
 *    roden_schema_article() both read get_the_excerpt().
 *
 * This is the four-surfaces problem from CLAUDE.md in a field nobody inspects:
 * one empty column, published wrong twice over. 126 posts share it site-wide —
 * see the scan in the accompanying report; this script fixes only 1790.
 *
 * Idempotent: re-running is a no-op once applied. Backs up before writing.
 */

$id = 1790;

$new_title = 'Georgia Super Speeder Law: Fines and Penalties';

// Becomes <meta name="description"> AND the Article schema description.
// Kept under 160 chars so roden_seo_truncate() does not cut it mid-clause.
$new_excerpt = "Georgia's Super Speeder Law adds a $200 surcharge for driving 75+ mph on a two-lane road or 85+ mph anywhere, with license suspension if unpaid within 120 days.";

$post = get_post( $id );
if ( ! $post ) {
    echo "ABORT: post $id not found\n";
    return;
}
if ( 'georgia-super-speeder-law' !== $post->post_name ) {
    echo "ABORT: post $id is '{$post->post_name}', not the Super Speeder page\n";
    return;
}

echo "--- BEFORE ---\n";
echo "title  : {$post->post_title}\n";
echo "excerpt: [" . $post->post_excerpt . "]\n";
echo "modified: {$post->post_modified}\n";
echo "published description: " . substr( trim( wp_strip_all_tags( get_the_excerpt( $id ) ) ), 0, 90 ) . "...\n";

if ( $post->post_title === $new_title && trim( $post->post_excerpt ) === trim( $new_excerpt ) ) {
    echo "\nAlready applied — nothing to do.\n";
    return;
}

// Backup: the database is not in the repo and this change has no undo.
$backup = array(
    'applied_at'   => current_time( 'mysql' ),
    'post_id'      => $id,
    'post_name'    => $post->post_name,
    'post_title'   => $post->post_title,
    'post_excerpt' => $post->post_excerpt,
    'post_modified'=> $post->post_modified,
);
echo "\nBACKUP-JSON: " . wp_json_encode( $backup ) . "\n";

$res = wp_update_post(
    array(
        'ID'           => $id,
        'post_title'   => $new_title,
        'post_excerpt' => $new_excerpt,
    ),
    true
);

if ( is_wp_error( $res ) ) {
    echo "FAILED: " . $res->get_error_message() . "\n";
    return;
}

clean_post_cache( $id );
$after = get_post( $id );

echo "\n--- AFTER ---\n";
echo "title  : {$after->post_title}\n";
echo "excerpt: {$after->post_excerpt}\n";
echo "modified: {$after->post_modified}\n";
echo "slug UNCHANGED: " . ( 'georgia-super-speeder-law' === $after->post_name ? 'yes' : 'NO — INVESTIGATE' ) . "\n";
echo "h1 UNCHANGED  : " . get_post_meta( $id, 'custom_h1_title', true ) . "\n";
echo "published description now: " . trim( wp_strip_all_tags( get_the_excerpt( $id ) ) ) . "\n";
echo "\nDone.\n";
