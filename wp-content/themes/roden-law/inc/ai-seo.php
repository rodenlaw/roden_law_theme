<?php
/**
 * AI SEO Enhancements — Robots.txt, AI bot access, and crawl optimization.
 *
 * Ensures AI search crawlers (GPTBot, PerplexityBot, ClaudeBot, etc.) can
 * access and cite Roden Law content in AI-generated answers.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   1. ROBOTS.TXT — AI BOT ACCESS RULES
   ========================================================================== */

add_filter( 'robots_txt', 'roden_ai_robots_txt', 10, 2 );

/**
 * Append AI crawler access rules to WordPress's dynamic robots.txt.
 *
 * By default, WordPress generates a basic robots.txt via wp_robots_txt().
 * We append explicit Allow rules for all major AI search crawlers so they
 * can index and cite our content in AI-generated answers.
 *
 * @param string $output  The existing robots.txt content.
 * @param bool   $public  Whether the site is public (blog_public option).
 * @return string Modified robots.txt content.
 */
function roden_ai_robots_txt( $output, $public ) {
    // Only add rules if the site is public.
    if ( ! $public ) {
        return $output;
    }

    $ai_bots = "\n# AI Search Crawlers — Allow for citation in AI-generated answers\n";

    // OpenAI (ChatGPT)
    $ai_bots .= "User-agent: GPTBot\n";
    $ai_bots .= "Allow: /\n";
    $ai_bots .= "Disallow: /wp-admin/\n\n";

    $ai_bots .= "User-agent: ChatGPT-User\n";
    $ai_bots .= "Allow: /\n\n";

    // Perplexity
    $ai_bots .= "User-agent: PerplexityBot\n";
    $ai_bots .= "Allow: /\n\n";

    // Anthropic (Claude)
    $ai_bots .= "User-agent: ClaudeBot\n";
    $ai_bots .= "Allow: /\n\n";

    $ai_bots .= "User-agent: anthropic-ai\n";
    $ai_bots .= "Allow: /\n\n";

    // Google AI (Gemini, AI Overviews)
    $ai_bots .= "User-agent: Google-Extended\n";
    $ai_bots .= "Allow: /\n\n";

    // Microsoft Copilot (via Bing)
    $ai_bots .= "User-agent: Bingbot\n";
    $ai_bots .= "Allow: /\n\n";

    // Brave Search (used by Claude when browsing)
    $ai_bots .= "User-agent: Brave\n";
    $ai_bots .= "Allow: /\n\n";

    // Block training-only crawlers (not search — protects content from bulk scraping)
    $ai_bots .= "# Block training-only crawlers (not search bots)\n";
    $ai_bots .= "User-agent: CCBot\n";
    $ai_bots .= "Disallow: /\n\n";

    // llms.txt reference
    $ai_bots .= "# LLM-friendly site information\n";
    $ai_bots .= "# See: " . home_url( '/llms/' ) . "\n";
    $ai_bots .= "# Extended: " . home_url( '/llms-full/' ) . "\n";

    return $output . $ai_bots;
}

/* ==========================================================================
   2. X-ROBOTS-TAG HEADER — Ensure AI bots aren't accidentally noindexed
   ========================================================================== */

add_action( 'wp_head', 'roden_ai_meta_tags', 2 );

/**
 * Output meta tags that help AI systems understand content freshness and type.
 * These supplement our JSON-LD schema with lightweight HTML-level signals.
 */
function roden_ai_meta_tags() {
    // dateModified meta tag — helps AI systems identify content freshness
    if ( is_singular() ) {
        $modified = get_the_modified_date( 'c' );
        if ( $modified ) {
            echo '<meta property="article:modified_time" content="' . esc_attr( $modified ) . '" />' . "\n";
        }
    }
}
