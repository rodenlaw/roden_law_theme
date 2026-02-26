<?php
/**
 * Schema Helpers — All 10 JSON-LD schema types.
 *
 * Outputs structured data via the wp_head hook.
 * No schema plugins required — everything is handled here.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   JSON-LD Output Helper
   ========================================================================== */

/**
 * Output a JSON-LD script tag.
 *
 * @param array $data Schema data array.
 */
function roden_json_ld( $data ) {
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
    echo "\n" . '</script>' . "\n";
}

/* ==========================================================================
   Schema Dispatcher (wp_head hook)
   ========================================================================== */

add_action( 'wp_head', 'roden_output_schema', 1 );
function roden_output_schema() {
    $firm = roden_firm_data();

    if ( is_front_page() ) {
        roden_schema_organization( $firm );
        roden_schema_legal_service( $firm );
        roden_schema_local_business_all( $firm );
        roden_schema_speakable_homepage( $firm );
        roden_schema_aggregate_rating( $firm );
        roden_schema_website( $firm );
    }

    if ( is_singular( 'practice_area' ) ) {
        roden_schema_legal_service( $firm );
        roden_schema_faq_page();
        roden_schema_speakable_practice_area();
    }

    if ( is_singular( 'location' ) ) {
        roden_schema_local_business_single( $firm );
        roden_schema_faq_page();
    }

    if ( is_singular( 'attorney' ) ) {
        roden_schema_person( $firm );
    }

    if ( is_singular( 'resource' ) ) {
        roden_schema_howto();
    }

    if ( is_singular( 'post' ) ) {
        roden_schema_article( $firm );
    }

    // BreadcrumbList on all pages (except front page)
    if ( ! is_front_page() ) {
        roden_schema_breadcrumbs();
    }
}

/* ==========================================================================
   Schema Type 1: Organization / LawFirm (Homepage)
   ========================================================================== */

function roden_schema_organization( $firm ) {
    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => array( 'Organization', 'LegalService' ),
        '@id'         => $firm['url'] . '/#organization',
        'name'        => $firm['name'],
        'legalName'   => $firm['legal_entity'],
        'url'         => $firm['url'],
        'description' => $firm['description'],
        'telephone'   => $firm['vanity_phone'],
        'foundingDate'=> $firm['founded'],
        'areaServed'  => array(
            array( '@type' => 'State', 'name' => 'Georgia' ),
            array( '@type' => 'State', 'name' => 'South Carolina' ),
        ),
        'sameAs' => array_values( $firm['social'] ),
    );

    // Add logo if custom logo is set
    $logo_id = get_theme_mod( 'custom_logo' );
    if ( $logo_id ) {
        $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
        if ( $logo_url ) {
            $schema['logo'] = array(
                '@type'      => 'ImageObject',
                'url'        => $logo_url,
                'contentUrl' => $logo_url,
            );
            $schema['image'] = $logo_url;
        }
    }

    // Add all offices as locations
    $locations = array();
    foreach ( $firm['offices'] as $key => $office ) {
        $locations[] = array(
            '@type' => 'LocalBusiness',
            'name'  => $firm['name'] . ' — ' . $office['city'],
            'address' => array(
                '@type'           => 'PostalAddress',
                'streetAddress'   => $office['street'],
                'addressLocality' => $office['city'],
                'addressRegion'   => $office['state'],
                'postalCode'      => $office['zip'],
                'addressCountry'  => 'US',
            ),
            'telephone' => $office['phone'],
            'geo' => array(
                '@type'     => 'GeoCoordinates',
                'latitude'  => $office['latitude'],
                'longitude' => $office['longitude'],
            ),
        );
    }
    $schema['location'] = $locations;

    roden_json_ld( $schema );
}

/* ==========================================================================
   Schema Type 2: LegalService (Homepage + Practice Area pages)
   ========================================================================== */

function roden_schema_legal_service( $firm ) {
    $schema = array(
        '@context'       => 'https://schema.org',
        '@type'          => 'LegalService',
        '@id'            => $firm['url'] . '/#legalservice',
        'name'           => $firm['name'],
        'url'            => $firm['url'],
        'description'    => $firm['description'],
        'telephone'      => $firm['vanity_phone'],
        'priceRange'     => 'Free Consultation',
        'areaServed'     => array(
            array( '@type' => 'State', 'name' => 'Georgia' ),
            array( '@type' => 'State', 'name' => 'South Carolina' ),
        ),
        'serviceType'    => 'Personal Injury Law',
        'knowsAbout'     => array(
            'Car Accidents', 'Truck Accidents', 'Slip and Fall',
            'Motorcycle Accidents', 'Medical Malpractice', 'Wrongful Death',
            'Workers Compensation', 'Dog Bites', 'Brain Injuries',
            'Spinal Cord Injuries', 'Maritime Injuries', 'Product Liability',
            'Boating Accidents', 'Burn Injuries', 'Construction Accidents',
            'Nursing Home Abuse', 'Premises Liability', 'Pedestrian Accidents',
        ),
    );

    // On singular practice area, add specific service info
    if ( is_singular( 'practice_area' ) ) {
        $schema['name']        = get_the_title() . ' — ' . $firm['name'];
        $schema['url']         = get_permalink();
        $schema['description'] = get_the_excerpt() ?: wp_trim_words( get_the_content(), 30 );
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   Schema Type 3: LocalBusiness (all offices — Homepage)
   ========================================================================== */

function roden_schema_local_business_all( $firm ) {
    foreach ( $firm['offices'] as $key => $office ) {
        roden_schema_local_business_office( $firm, $key, $office );
    }
}

/* ==========================================================================
   Schema Type 3b: LocalBusiness (single office — Location page)
   ========================================================================== */

function roden_schema_local_business_single( $firm ) {
    $office_key = get_post_meta( get_the_ID(), '_roden_office_key', true );
    if ( ! $office_key || ! isset( $firm['offices'][ $office_key ] ) ) {
        return;
    }
    roden_schema_local_business_office( $firm, $office_key, $firm['offices'][ $office_key ] );
}

/** Shared LocalBusiness builder for one office. */
function roden_schema_local_business_office( $firm, $key, $office ) {
    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => array( 'LocalBusiness', 'LegalService' ),
        '@id'        => $firm['url'] . '/locations/' . $key . '/#localbusiness',
        'name'       => $firm['name'] . ' — ' . $office['city'],
        'url'        => $firm['url'] . '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['city'] ) . '/',
        'telephone'  => $office['phone'],
        'priceRange' => 'Free Consultation',
        'address'    => array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => $office['street'],
            'addressLocality' => $office['city'],
            'addressRegion'   => $office['state'],
            'postalCode'      => $office['zip'],
            'addressCountry'  => 'US',
        ),
        'geo' => array(
            '@type'     => 'GeoCoordinates',
            'latitude'  => $office['latitude'],
            'longitude' => $office['longitude'],
        ),
        'openingHoursSpecification' => array(
            array(
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
                'opens'     => '08:00',
                'closes'    => '18:00',
            ),
        ),
        'openingHours'       => 'Mo-Fr 08:00-18:00',
        'hasMap'             => 'https://www.google.com/maps/dir/?api=1&destination='
                                . $office['latitude'] . ',' . $office['longitude'],
        'parentOrganization' => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        ),
    );

    // Add logo/image if custom logo is set
    $logo_id = get_theme_mod( 'custom_logo' );
    if ( $logo_id ) {
        $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
        if ( $logo_url ) {
            $schema['image'] = $logo_url;
        }
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   Schema Type 4: Person / Attorney (Attorney pages)
   ========================================================================== */

function roden_schema_person( $firm ) {
    $post_id       = get_the_ID();
    $bar           = get_post_meta( $post_id, '_roden_bar_admissions', true );
    $bar_list      = $bar ? array_map( 'trim', explode( "\n", $bar ) ) : array();

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'Person',
        '@id'         => get_permalink() . '#person',
        'name'        => get_the_title(),
        'url'         => get_permalink(),
        'description' => get_the_excerpt() ?: wp_trim_words( get_the_content(), 30 ),
        'worksFor'    => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        ),
    );

    if ( has_post_thumbnail() ) {
        $schema['image'] = get_the_post_thumbnail_url( $post_id, 'attorney-headshot' );
    }

    if ( ! empty( $bar_list ) ) {
        $schema['hasCredential'] = array_map( function( $admission ) {
            return array(
                '@type'          => 'EducationalOccupationalCredential',
                'credentialCategory' => 'Bar Admission',
                'name'           => $admission,
            );
        }, $bar_list );
    }

    // Try to match attorney to firm data for job title
    $slug = get_post_field( 'post_name', $post_id );
    if ( isset( $firm['attorneys'][ $slug ] ) ) {
        $schema['jobTitle'] = $firm['attorneys'][ $slug ]['title'];
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   Schema Type 5: FAQPage (Practice Area pages)
   ========================================================================== */

function roden_schema_faq_page() {
    $faqs = get_post_meta( get_the_ID(), '_roden_faqs', true );
    if ( ! is_array( $faqs ) || empty( $faqs ) ) {
        return;
    }

    $faq_entities = array();
    foreach ( $faqs as $faq ) {
        if ( empty( $faq['question'] ) || empty( $faq['answer'] ) ) {
            continue;
        }
        $faq_entities[] = array(
            '@type'          => 'Question',
            'name'           => $faq['question'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => $faq['answer'],
            ),
        );
    }

    if ( empty( $faq_entities ) ) {
        return;
    }

    roden_json_ld( array(
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $faq_entities,
    ) );
}

/* ==========================================================================
   Schema Type 7: BreadcrumbList (Sitewide, except homepage)
   ========================================================================== */

function roden_schema_breadcrumbs() {
    $items    = array();
    $position = 1;

    // Home
    $items[] = array(
        '@type'    => 'ListItem',
        'position' => $position++,
        'name'     => __( 'Home', 'roden-law' ),
        'item'     => home_url( '/' ),
    );

    if ( is_singular( 'practice_area' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Practice Areas', 'roden-law' ),
            'item'     => home_url( '/practice-areas/' ),
        );

        // If this is a child (intersection or sub-type), add parent
        $post   = get_post();
        $parent = $post->post_parent;
        if ( $parent ) {
            $items[] = array(
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => get_the_title( $parent ),
                'item'     => get_permalink( $parent ),
            );
        }

        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_singular( 'location' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Locations', 'roden-law' ),
            'item'     => home_url( '/locations/' ),
        );
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_singular( 'attorney' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Attorneys', 'roden-law' ),
            'item'     => home_url( '/attorneys/' ),
        );
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_singular( 'case_result' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Case Results', 'roden-law' ),
            'item'     => home_url( '/case-results/' ),
        );
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_singular( 'resource' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Resources', 'roden-law' ),
            'item'     => home_url( '/resources/' ),
        );
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_singular( 'post' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Blog', 'roden-law' ),
            'item'     => get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ),
        );
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_singular() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_search() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Search Results', 'roden-law' ),
            'item'     => get_search_link(),
        );

    } elseif ( is_home() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Blog', 'roden-law' ),
            'item'     => get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ),
        );

    } elseif ( is_post_type_archive() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => post_type_archive_title( '', false ),
            'item'     => get_post_type_archive_link( get_queried_object()->name ?? get_post_type() ),
        );
    }

    if ( count( $items ) < 2 ) {
        return;
    }

    roden_json_ld( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    ) );
}

/* ==========================================================================
   Schema Type 8: Speakable (Homepage + Practice Area pages)
   ========================================================================== */

function roden_schema_speakable_homepage( $firm ) {
    roden_json_ld( array(
        '@context' => 'https://schema.org',
        '@type'    => 'WebPage',
        'name'     => $firm['name'] . ' — Personal Injury Lawyers in Georgia & South Carolina',
        'url'      => $firm['url'],
        'speakable' => array(
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => array( '.hero h1', '.hero p', '.trust-bar' ),
        ),
    ) );
}

function roden_schema_speakable_practice_area() {
    roden_json_ld( array(
        '@context' => 'https://schema.org',
        '@type'    => 'WebPage',
        'name'     => get_the_title(),
        'url'      => get_permalink(),
        'speakable' => array(
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => array( '.hero h1', '.hero p' ),
        ),
    ) );
}

/* ==========================================================================
   Schema Type 9: AggregateRating (Homepage)
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
   Schema Type 10: WebSite with Sitelinks Searchbox (Homepage)
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
   Schema Type 11: BlogPosting (Blog posts)
   ========================================================================== */

/**
 * Output BlogPosting schema on single blog posts.
 *
 * @param array $firm Firm data from roden_firm_data().
 */
function roden_schema_article( $firm ) {
    $post_id   = get_the_ID();
    $content   = get_post_field( 'post_content', $post_id );
    $excerpt   = get_the_excerpt( $post_id );

    $schema = array(
        '@context'      => 'https://schema.org',
        '@type'         => 'BlogPosting',
        'headline'      => get_the_title( $post_id ),
        'description'   => $excerpt ?: wp_trim_words( wp_strip_all_tags( $content ), 30 ),
        'url'           => get_permalink( $post_id ),
        'datePublished' => get_the_date( 'c', $post_id ),
        'dateModified'  => get_the_modified_date( 'c', $post_id ),
        'wordCount'     => str_word_count( wp_strip_all_tags( $content ) ),
        'mainEntityOfPage' => array(
            '@type' => 'WebPage',
            '@id'   => get_permalink( $post_id ),
        ),
        'publisher' => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        ),
    );

    // Featured image
    if ( has_post_thumbnail( $post_id ) ) {
        $img_url = get_the_post_thumbnail_url( $post_id, 'large' );
        $img_id  = get_post_thumbnail_id( $post_id );
        $img_meta = wp_get_attachment_metadata( $img_id );
        $schema['image'] = array(
            '@type'  => 'ImageObject',
            'url'    => $img_url,
            'width'  => $img_meta['width'] ?? 0,
            'height' => $img_meta['height'] ?? 0,
        );
    }

    // Author — linked attorney if set, otherwise WP author
    $author_id = get_post_meta( $post_id, '_roden_author_attorney', true );
    $atty      = $author_id ? get_post( $author_id ) : null;

    if ( $atty ) {
        $schema['author'] = array(
            '@type' => 'Person',
            '@id'   => get_permalink( $atty ) . '#person',
            'name'  => $atty->post_title,
            'url'   => get_permalink( $atty ),
        );
    } else {
        $schema['author'] = array(
            '@type' => 'Person',
            'name'  => get_the_author(),
        );
    }

    // Publisher logo
    $logo_id = get_theme_mod( 'custom_logo' );
    if ( $logo_id ) {
        $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
        if ( $logo_url ) {
            $schema['publisher']['logo'] = array(
                '@type' => 'ImageObject',
                'url'   => $logo_url,
            );
        }
    }

    // Article section from primary category
    $categories = get_the_category( $post_id );
    if ( ! empty( $categories ) ) {
        $schema['articleSection'] = $categories[0]->name;
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   Schema Type 6: HowTo (Resource pages)
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
