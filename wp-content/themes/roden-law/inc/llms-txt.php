<?php
/**
 * llms.txt — LLM-Friendly Site Information
 *
 * Serves /llms.txt and /llms-full.txt as dynamic Markdown files per the
 * llmstxt.org specification. Helps AI systems (ChatGPT, Perplexity,
 * Google AI Overviews, Claude) understand site structure and authority.
 *
 * @package Roden_Law
 * @see     https://llmstxt.org/
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   1. REWRITE RULES + QUERY VARS
   ========================================================================== */

add_action( 'init', 'roden_llms_txt_rewrite_rules' );

/**
 * Register rewrite rules for /llms and /llms-full.
 *
 * WP Engine's nginx intercepts .txt requests as static files (404 before
 * PHP runs), so we serve at extensionless URLs with Content-Type: text/markdown.
 */
function roden_llms_txt_rewrite_rules() {
    add_rewrite_rule( '^llms/?$', 'index.php?roden_llms_txt=1', 'top' );
    add_rewrite_rule( '^llms-full/?$', 'index.php?roden_llms_txt=full', 'top' );
}

add_filter( 'query_vars', 'roden_llms_txt_query_vars' );

/**
 * Register the custom query var.
 */
function roden_llms_txt_query_vars( $vars ) {
    $vars[] = 'roden_llms_txt';
    return $vars;
}

add_action( 'template_redirect', 'roden_serve_llms_txt' );

/**
 * Serve llms.txt / llms-full.txt content when the query var is set.
 */
function roden_serve_llms_txt() {
    $val = get_query_var( 'roden_llms_txt' );

    if ( ! $val ) {
        return;
    }

    $full = ( 'full' === $val );

    header( 'Content-Type: text/markdown; charset=utf-8' );
    header( 'X-Robots-Tag: noindex' );
    echo roden_generate_llms_txt( $full );
    exit;
}

/* ==========================================================================
   2. CONTENT GENERATOR
   ========================================================================== */

/**
 * Generate llms.txt (or llms-full.txt) Markdown content.
 *
 * @param bool $full Whether to generate the extended version.
 * @return string Markdown content.
 */
function roden_generate_llms_txt( $full = false ) {
    $cache_key = $full ? 'roden_llms_full_txt' : 'roden_llms_txt';
    $cached    = get_transient( $cache_key );

    if ( false !== $cached ) {
        return $cached;
    }

    $firm    = roden_firm_data();
    $site    = 'https://rodenlaw.com';
    $output  = '';

    // ── Header ──────────────────────────────────────────────────────────
    $output .= "# Roden Law\n\n";
    $output .= "> Personal injury law firm serving Georgia and South Carolina with {$firm['trust_stats']['offices']} offices\n";
    $output .= "> and over {$firm['trust_stats']['recovered']} recovered. Contingency fee — no fees unless we win.\n";
    $output .= "> Call {$firm['vanity_phone']} for a free consultation.\n\n";

    $output .= "Roden Law ({$firm['legal_entity']}) handles car accidents, truck accidents, medical\n";
    $output .= "malpractice, wrongful death, workers' compensation, and other personal injury\n";
    $output .= "cases across Georgia and South Carolina.\n\n";

    // ── Practice Areas ──────────────────────────────────────────────────
    $output .= "## Practice Areas\n\n";

    $pillars = get_posts( array(
        'post_type'      => 'practice_area',
        'post_parent'    => 0,
        'posts_per_page' => 100,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
    ) );

    foreach ( $pillars as $pillar ) {
        $url   = get_permalink( $pillar );
        $title = get_the_title( $pillar );
        $desc  = roden_llms_get_excerpt( $pillar );
        $output .= "- [{$title}]({$url})";
        if ( $desc ) {
            $output .= ": {$desc}";
        }
        $output .= "\n";

        // Full version: list child pages (intersections + sub-types)
        if ( $full ) {
            $children = get_posts( array(
                'post_type'      => 'practice_area',
                'post_parent'    => $pillar->ID,
                'posts_per_page' => 100,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            ) );
            foreach ( $children as $child ) {
                $child_url   = get_permalink( $child );
                $child_title = get_the_title( $child );
                $output .= "  - [{$child_title}]({$child_url})\n";
            }
        }
    }
    $output .= "\n";

    // ── Office Locations ────────────────────────────────────────────────
    $output .= "## Office Locations\n\n";

    foreach ( $firm['offices'] as $key => $office ) {
        $city_label = $office['market_name'] ?? $office['city'];
        $loc_url    = "{$site}/locations/{$office['state_slug']}/{$key}/";
        $output .= "- [{$city_label}, {$office['state']}]({$loc_url}): {$office['street']}, {$office['city']}, {$office['state']} {$office['zip']} — {$office['phone']}";
        if ( $full && ! empty( $office['service_area'] ) ) {
            $output .= " — Serving {$office['service_area']}";
        }
        $output .= "\n";
    }
    $output .= "\n";

    // ── Attorneys ───────────────────────────────────────────────────────
    $output .= "## Attorneys\n\n";

    foreach ( $firm['attorneys'] as $slug => $atty ) {
        $atty_url = "{$site}/attorneys/{$slug}/";
        $bars     = implode( ', ', $atty['bar_admissions'] );
        $output  .= "- [{$atty['name']}]({$atty_url}): {$atty['title']} — Licensed in {$bars}";
        if ( $full && ! empty( $atty['focus'] ) ) {
            $output .= " — {$atty['focus']}";
        }
        $output .= "\n";
    }
    $output .= "\n";

    // ── Jurisdiction Information ────────────────────────────────────────
    $output .= "## Jurisdiction Information\n\n";

    foreach ( $firm['jurisdiction'] as $abbr => $j ) {
        $output .= "- **{$j['state_full']}**: {$j['statute_years']}-year statute of limitations ({$j['statute_cite']}), {$j['comp_fault_rule']}";
        if ( ! empty( $j['comp_fault_cite'] ) ) {
            $output .= " ({$j['comp_fault_cite']})";
        }
        $output .= "\n";
    }
    $output .= "\n";

    // ── Optional / Additional Resources ─────────────────────────────────
    $output .= "## Optional\n\n";
    $output .= "- [Case Results]({$site}/case-results/): Notable settlements and verdicts\n";
    $output .= "- [Resources]({$site}/resources/): Legal guides and educational articles\n";
    $output .= "- [Blog]({$site}/blog/): Legal news and educational content\n";
    $output .= "- [Contact / Free Consultation]({$site}/contact/): Reach Roden Law\n";

    // Full version: expand resources, blog posts
    if ( $full ) {
        $output .= "\n";

        // Resources
        $resources = get_posts( array(
            'post_type'      => 'resource',
            'posts_per_page' => 50,
            'post_status'    => 'publish',
            'orderby'        => 'title',
            'order'          => 'ASC',
        ) );
        if ( $resources ) {
            $output .= "### Resources\n\n";
            foreach ( $resources as $res ) {
                $res_url   = get_permalink( $res );
                $res_title = get_the_title( $res );
                $output   .= "- [{$res_title}]({$res_url})\n";
            }
            $output .= "\n";
        }

        // Recent blog posts
        $posts = get_posts( array(
            'post_type'      => 'post',
            'posts_per_page' => 30,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );
        if ( $posts ) {
            $output .= "### Recent Blog Posts\n\n";
            foreach ( $posts as $blog ) {
                $blog_url   = get_permalink( $blog );
                $blog_title = get_the_title( $blog );
                $output    .= "- [{$blog_title}]({$blog_url})\n";
            }
            $output .= "\n";
        }

        // Case results
        $results = get_posts( array(
            'post_type'      => 'case_result',
            'posts_per_page' => 50,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );
        if ( $results ) {
            $output .= "### Case Results\n\n";
            foreach ( $results as $cr ) {
                $cr_url    = get_permalink( $cr );
                $cr_title  = get_the_title( $cr );
                $cr_amount = get_post_meta( $cr->ID, '_roden_amount', true );
                $output   .= "- [{$cr_title}]({$cr_url})";
                if ( $cr_amount ) {
                    $output .= ": {$cr_amount}";
                }
                $output .= "\n";
            }
            $output .= "\n";
        }
    }

    // Cache for 24 hours.
    set_transient( $cache_key, $output, DAY_IN_SECONDS );

    return $output;
}

/* ==========================================================================
   3. CACHE INVALIDATION
   ========================================================================== */

/**
 * Flush llms.txt transient caches when relevant content changes.
 */
function roden_llms_txt_flush_cache() {
    delete_transient( 'roden_llms_txt' );
    delete_transient( 'roden_llms_full_txt' );
}

add_action( 'save_post_practice_area', 'roden_llms_txt_flush_cache' );
add_action( 'save_post_attorney',      'roden_llms_txt_flush_cache' );
add_action( 'save_post_location',      'roden_llms_txt_flush_cache' );
add_action( 'save_post_resource',      'roden_llms_txt_flush_cache' );
add_action( 'save_post_case_result',   'roden_llms_txt_flush_cache' );
add_action( 'save_post_post',          'roden_llms_txt_flush_cache' );

/* ==========================================================================
   4. HELPER
   ========================================================================== */

/**
 * Get a short plain-text excerpt for a post (max ~160 chars).
 *
 * @param WP_Post $post Post object.
 * @return string Plain-text excerpt or empty string.
 */
function roden_llms_get_excerpt( $post ) {
    $excerpt = $post->post_excerpt;
    if ( ! $excerpt ) {
        $excerpt = wp_strip_all_tags( $post->post_content );
    }
    $excerpt = str_replace( array( "\r", "\n" ), ' ', $excerpt );
    $excerpt = preg_replace( '/\s+/', ' ', trim( $excerpt ) );

    if ( strlen( $excerpt ) > 160 ) {
        $excerpt = substr( $excerpt, 0, 157 ) . '...';
    }

    return $excerpt;
}
