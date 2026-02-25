<?php
/**
 * Schema Helpers — AggregateRating, WebSite, HowTo
 *
 * These three schema types are separated per the theme architecture spec.
 * All output JSON-LD via the roden_json_ld() helper defined in functions.php.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   Schema Type 8: AggregateRating (Homepage — testimonials section)
   ========================================================================== */

/**
 * Output AggregateRating schema on the homepage.
 * Pulls from published testimonial posts to generate the rating.
 *
 * @param array $firm Firm data from roden_firm_data().
 */
function roden_schema_aggregate_rating( $firm ) {
    // Count published testimonials
    $testimonial_count = wp_count_posts( 'testimonial' );
    $review_count      = isset( $testimonial_count->publish ) ? (int) $testimonial_count->publish : 0;

    // Use firm trust stats as the canonical rating; fall back if no testimonials yet
    if ( $review_count < 1 ) {
        $review_count = 150; // baseline from existing reviews
    }

    roden_json_ld( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'LegalService',
        '@id'             => $firm['url'] . '/#rating',
        'name'            => $firm['name'],
        'url'             => $firm['url'],
        'aggregateRating' => array(
            '@type'       => 'AggregateRating',
            'ratingValue' => $firm['trust_stats']['rating'],
            'bestRating'  => '5',
            'worstRating' => '1',
            'reviewCount' => $review_count,
        ),
    ) );
}

/* ==========================================================================
   Schema Type 9: WebSite with Sitelinks Searchbox (Homepage)
   ========================================================================== */

/**
 * Output WebSite schema with SearchAction for Sitelinks Searchbox.
 *
 * @param array $firm Firm data from roden_firm_data().
 */
function roden_schema_website( $firm ) {
    roden_json_ld( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'WebSite',
        '@id'             => $firm['url'] . '/#website',
        'name'            => $firm['name'],
        'url'             => $firm['url'],
        'potentialAction' => array(
            '@type'       => 'SearchAction',
            'target'      => array(
                '@type'        => 'EntryPoint',
                'urlTemplate'  => $firm['url'] . '/?s={search_term_string}',
            ),
            'query-input' => 'required name=search_term_string',
        ),
    ) );
}

/* ==========================================================================
   Schema Type 10: HowTo (Resource pages — what-to-do guides)
   ========================================================================== */

/**
 * Output HowTo schema on resource pages.
 * Parses the post content for ordered list items (<ol><li>) to build steps.
 * Falls back to H2/H3 headings as steps if no ordered list is found.
 */
function roden_schema_howto() {
    $post_id = get_the_ID();
    $title   = get_the_title( $post_id );
    $content = get_the_content( null, false, $post_id );
    $url     = get_permalink( $post_id );

    // Try to extract steps from ordered list items
    $steps = roden_extract_howto_steps( $content );

    if ( empty( $steps ) ) {
        return;
    }

    $step_entities = array();
    $position      = 1;
    foreach ( $steps as $step ) {
        $step_entity = array(
            '@type'    => 'HowToStep',
            'position' => $position++,
            'name'     => $step['name'],
            'text'     => $step['text'],
            'url'      => $url . '#step-' . sanitize_title( $step['name'] ),
        );
        $step_entities[] = $step_entity;
    }

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'HowTo',
        'name'        => $title,
        'description' => get_the_excerpt( $post_id ) ?: wp_trim_words( $content, 30 ),
        'url'         => $url,
        'step'        => $step_entities,
    );

    if ( has_post_thumbnail( $post_id ) ) {
        $schema['image'] = get_the_post_thumbnail_url( $post_id, 'card-thumb' );
    }

    roden_json_ld( $schema );
}

/**
 * Extract HowTo steps from post content.
 * Looks for ordered lists first, then falls back to H2/H3 headings.
 *
 * @param string $content Post content (HTML).
 * @return array Array of steps with 'name' and 'text' keys.
 */
function roden_extract_howto_steps( $content ) {
    $steps = array();

    // Strategy 1: Extract from <ol><li> elements
    if ( preg_match( '/<ol[^>]*>(.*?)<\/ol>/si', $content, $ol_match ) ) {
        if ( preg_match_all( '/<li[^>]*>(.*?)<\/li>/si', $ol_match[1], $li_matches ) ) {
            foreach ( $li_matches[1] as $li ) {
                $text = wp_strip_all_tags( $li );
                if ( strlen( $text ) > 5 ) {
                    $steps[] = array(
                        'name' => wp_trim_words( $text, 8, '' ),
                        'text' => $text,
                    );
                }
            }
        }
    }

    if ( ! empty( $steps ) ) {
        return $steps;
    }

    // Strategy 2: Fall back to H2 or H3 headings as step names
    if ( preg_match_all( '/<h[23][^>]*>(.*?)<\/h[23]>/si', $content, $heading_matches ) ) {
        // Split content by headings to get the text following each heading
        $sections = preg_split( '/<h[23][^>]*>.*?<\/h[23]>/si', $content );
        array_shift( $sections ); // Remove content before first heading

        foreach ( $heading_matches[1] as $i => $heading ) {
            $name = wp_strip_all_tags( $heading );
            $text = isset( $sections[ $i ] ) ? wp_trim_words( wp_strip_all_tags( $sections[ $i ] ), 40 ) : $name;
            if ( strlen( $name ) > 3 ) {
                $steps[] = array(
                    'name' => $name,
                    'text' => $text,
                );
            }
        }
    }

    return $steps;
}
