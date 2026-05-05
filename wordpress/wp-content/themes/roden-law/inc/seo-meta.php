<?php
/**
 * Native SEO Meta Tags — Canonical, Description, Open Graph, Twitter Cards.
 *
 * Eliminates the need for Yoast / Rank Math for basic on-page SEO.
 * All output hooks at wp_head priority 1 (alongside schema).
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   0. PAGINATED TITLE — append "– Page N" on archive pages 2+
   ========================================================================== */

add_filter( 'document_title_parts', 'roden_seo_title_optimization' );
/**
 * Optimize title tags for SEO.
 *
 * - Practice area pages: append location or jurisdiction context.
 * - Intersection pages: include city + state for local SEO.
 * - Paginated archives: append "– Page N".
 *
 * @param array $title_parts Title parts array.
 * @return array
 */
function roden_seo_title_optimization( $title_parts ) {
    $firm = roden_firm_data();

    // Homepage — descriptive title with primary keywords.
    if ( is_front_page() ) {
        $title_parts['title'] = 'Personal Injury Lawyers in Georgia & South Carolina';
        return $title_parts;
    }

    // Practice area pages — add jurisdiction/location context.
    if ( is_singular() && in_array( get_post_type(), array( 'practice_area', 'practice-area' ), true ) ) {
        $post    = get_post();
        $post_id = $post->ID;

        if ( $post->post_parent ) {
            $office_key = get_post_meta( $post_id, '_roden_pa_office_key', true );

            if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
                // Intersection page — append "in City, ST" only if not already present.
                // Post titles like "Car Accident Lawyers in Savannah, GA" already contain the location.
                $office  = $firm['offices'][ $office_key ];
                $geo_tag = $office['city'] . ', ' . $office['state'];
                if ( false === stripos( $title_parts['title'], $geo_tag ) ) {
                    $title_parts['title'] .= ' in ' . $geo_tag;
                }
            } else {
                // Sub-type page — append jurisdiction.
                $jurisdiction = strtolower( get_post_meta( $post_id, '_roden_jurisdiction', true ) ?: 'both' );
                if ( 'ga' === $jurisdiction ) {
                    $title_parts['title'] .= ' in Georgia';
                } elseif ( 'sc' === $jurisdiction ) {
                    $title_parts['title'] .= ' in South Carolina';
                } else {
                    $title_parts['title'] .= ' in Georgia & South Carolina';
                }
            }
        } else {
            // Pillar page — append "in Georgia & South Carolina".
            $title_parts['title'] .= ' in Georgia & South Carolina';
        }
    }

    // Location pages — append state.
    if ( is_singular( 'location' ) ) {
        $office_key = get_post_meta( get_the_ID(), '_roden_office_key', true );
        if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
            $office = $firm['offices'][ $office_key ];
            $title_parts['title'] .= ' – ' . $office['state_full'] . ' Personal Injury Lawyers';
        }
    }

    // Attorney pages — append role for E-E-A-T and search context.
    if ( is_singular( 'attorney' ) ) {
        $atty_title = get_post_meta( get_the_ID(), '_roden_atty_title', true );
        if ( $atty_title ) {
            $title_parts['title'] .= ', ' . $atty_title;
        } else {
            $title_parts['title'] .= ', Personal Injury Attorney';
        }
    }

    // Paginated archives — append page number.
    $paged = get_query_var( 'paged', 0 );
    if ( $paged >= 2 ) {
        $title_parts['title'] .= sprintf( ' – Page %d', $paged );
    }

    return $title_parts;
}

/* ==========================================================================
   1. CANONICAL TAG
   ========================================================================== */

// Remove WordPress core's default canonical output — we handle it ourselves
// because practice_area child posts need rewritten URLs, not WP defaults.
remove_action( 'wp_head', 'rel_canonical' );

add_action( 'wp_head', 'roden_output_canonical', 1 );
/**
 * Output <link rel="canonical"> using our custom canonical URL logic.
 *
 * For practice_area children (intersection + sub-type pages), this outputs
 * the rewritten URL (e.g., /car-accident-lawyers/savannah-ga/) instead of
 * WordPress's default CPT path (/practice-areas/parent/child/).
 */
function roden_output_canonical() {
    // Skip on 404, search, and noindex landing pages.
    if ( is_404() || is_search() ) {
        return;
    }

    // Skip noindex landing pages.
    $noindex_templates = array(
        'templates/template-landing-page.php',
        'templates/template-landing-truck.php',
        'templates/template-landing-truck-columbia.php',
        'templates/template-landing-charleston.php',
        'templates/template-landing-sc-statewide.php',
        'templates/template-landing-ga-car-accident.php',
    );
    foreach ( $noindex_templates as $tpl ) {
        if ( is_page_template( $tpl ) ) {
            return;
        }
    }

    $url = roden_seo_get_canonical();
    if ( $url ) {
        echo '<link rel="canonical" href="' . esc_url( $url ) . '" />' . "\n";
    }
}

/**
 * Determine the canonical URL for the current page.
 *
 * @return string Canonical URL.
 */
function roden_seo_get_canonical() {
    if ( is_front_page() ) {
        return home_url( '/' );
    }

    if ( is_singular() ) {
        // Use the practice_area-aware canonical helper from schema-helpers.php.
        return roden_get_canonical_url();
    }

    if ( is_post_type_archive() ) {
        return get_post_type_archive_link( get_queried_object()->name );
    }

    if ( is_tax() || is_category() || is_tag() ) {
        $term = get_queried_object();
        return $term ? get_term_link( $term ) : '';
    }

    if ( is_home() ) {
        return get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' );
    }

    return '';
}

/* ==========================================================================
   1b. SITEMAP — emit canonical URLs for practice_area children
   ========================================================================== */

add_filter( 'wp_sitemaps_posts_entry', 'roden_sitemap_canonical_entry', 10, 3 );
/**
 * Override the sitemap entry URL for practice_area children so the sitemap
 * publishes the same URL the page's <link rel="canonical"> points to.
 *
 * Without this, WP emits the default CPT URL (/practice-areas/{pillar}/{child}/)
 * for the 132 intersection + 192 sub-type posts, while every page sets
 * canonical to the rewritten URL (/{pillar}/{child}/). Both URLs return 200,
 * the canonical de-duplicates them for indexing, but the sitemap-canonical
 * mismatch wastes Googlebot's crawl budget and dilutes signals during the
 * consolidation window.
 *
 * @param array   $entry      Sitemap URL entry: [ 'loc' => ..., ... ].
 * @param WP_Post $post       The post being added.
 * @param string  $post_type  The post type.
 * @return array
 */
function roden_sitemap_canonical_entry( $entry, $post, $post_type ) {
    if ( ! in_array( $post_type, array( 'practice_area', 'practice-area' ), true ) ) {
        return $entry;
    }

    if ( function_exists( 'roden_get_canonical_url' ) ) {
        $canonical = roden_get_canonical_url( $post );
        if ( $canonical ) {
            $entry['loc'] = $canonical;
        }
    }

    return $entry;
}

/* ==========================================================================
   2. META DESCRIPTION
   ========================================================================== */

add_action( 'wp_head', 'roden_output_meta_description', 1 );
/**
 * Output <meta name="description"> from post excerpt, custom field, or auto-generated.
 */
function roden_output_meta_description() {
    if ( is_404() || is_search() ) {
        return;
    }

    $desc = roden_seo_get_description();
    if ( $desc ) {
        echo '<meta name="description" content="' . esc_attr( $desc ) . '" />' . "\n";
    }
}

/**
 * Build the meta description for the current page.
 *
 * Priority: custom field → excerpt → auto-generated from content/context.
 *
 * @return string Meta description (max 160 chars).
 */
function roden_seo_get_description() {
    $firm = roden_firm_data();

    // Homepage.
    if ( is_front_page() ) {
        return roden_seo_truncate( $firm['description'], 160 );
    }

    // Singular pages — check for a custom meta description field first.
    if ( is_singular() ) {
        $post_id = get_the_ID();

        // Custom meta description field (any CPT).
        $custom = get_post_meta( $post_id, '_roden_meta_description', true );
        if ( $custom ) {
            return roden_seo_truncate( $custom, 160 );
        }

        // Post excerpt.
        $excerpt = get_the_excerpt();
        if ( $excerpt && $excerpt !== wp_trim_words( get_the_content(), 55, '' ) ) {
            return roden_seo_truncate( wp_strip_all_tags( $excerpt ), 160 );
        }

        // Auto-generate based on post type.
        return roden_seo_auto_description( $post_id, $firm );
    }

    // Archives.
    if ( is_post_type_archive( 'practice_area' ) ) {
        return roden_seo_truncate( 'Explore our practice areas. ' . $firm['name'] . ' handles car accidents, truck accidents, wrongful death, and more across Georgia and South Carolina.', 160 );
    }

    if ( is_post_type_archive( 'attorney' ) ) {
        return roden_seo_truncate( 'Meet the attorneys at ' . $firm['name'] . '. Our experienced personal injury lawyers serve clients across Georgia and South Carolina.', 160 );
    }

    if ( is_post_type_archive( 'case_result' ) ) {
        return roden_seo_truncate( 'View our case results. ' . $firm['name'] . ' has recovered over $250 million for injured clients in Georgia and South Carolina.', 160 );
    }

    if ( is_home() ) {
        return roden_seo_truncate( 'Personal injury news, guides, and legal insights from ' . $firm['name'] . '. Serving Georgia and South Carolina.', 160 );
    }

    if ( is_tax() || is_category() || is_tag() ) {
        $term = get_queried_object();
        if ( $term && ! empty( $term->description ) ) {
            return roden_seo_truncate( wp_strip_all_tags( $term->description ), 160 );
        }
    }

    return '';
}

/**
 * Auto-generate a meta description for singular posts.
 *
 * Each template is crafted to:
 * - Include the primary keyword naturally (title / practice area / location).
 * - Add a unique data point per page (stat, jurisdiction, service area) so no
 *   two pages produce an identical description.
 * - End with a CTA that fits within 155-160 chars.
 *
 * @param int   $post_id Post ID.
 * @param array $firm    Firm data.
 * @return string
 */
function roden_seo_auto_description( $post_id, $firm ) {
    $post_type = get_post_type( $post_id );
    $title     = get_the_title( $post_id );

    switch ( $post_type ) {
        case 'practice_area':
        case 'practice-area':
            return roden_seo_auto_desc_practice_area( $post_id, $title, $firm );

        case 'location':
            return roden_seo_auto_desc_location( $post_id, $title, $firm );

        case 'attorney':
            return roden_seo_auto_desc_attorney( $post_id, $title, $firm );

        case 'case_result':
            return roden_seo_auto_desc_case_result( $post_id, $title, $firm );

        case 'resource':
            return roden_seo_auto_desc_resource( $post_id, $title, $firm );

        case 'post':
        default:
            return roden_seo_auto_desc_blog( $post_id, $title, $firm );
    }
}

/**
 * Meta description for practice_area posts (pillar, intersection, sub-type).
 */
function roden_seo_auto_desc_practice_area( $post_id, $title, $firm ) {
    $post = get_post( $post_id );

    if ( ! $post->post_parent ) {
        // --- Pillar page ---
        // e.g. "Car Accident Lawyers serving Georgia & South Carolina. Over $250M recovered. Free consultation — no fees unless we win."
        return roden_seo_truncate(
            $title . ' serving Georgia & South Carolina. Over $250M recovered. Free consultation — no fees unless we win.',
            160
        );
    }

    // Child page — intersection or sub-type.
    $office_key = get_post_meta( $post_id, '_roden_pa_office_key', true );
    if ( ! $office_key ) {
        $office_key = get_post_meta( $post_id, '_roden_office_key', true );
    }

    $parent      = get_post( $post->post_parent );
    $parent_name = $parent ? get_the_title( $parent ) : '';

    if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
        // --- Intersection page ---
        $office = $firm['offices'][ $office_key ];
        $city   = $office['city'];
        $state  = $office['state_full'];
        $court  = $office['court'];
        $sol    = isset( $firm['jurisdiction'][ $office['state'] ]['statute_years'] )
            ? $firm['jurisdiction'][ $office['state'] ]['statute_years'] . '-year'
            : '';

        // e.g. "Experienced car accident lawyers in Savannah, Georgia. 2-year filing deadline. Local team near Chatham County Superior Court. Free case review."
        $desc = $parent_name . ' in ' . $city . ', ' . $state . '.';
        if ( $sol ) {
            $desc .= ' ' . ucfirst( $sol ) . ' filing deadline.';
        }
        $desc .= ' Local team near ' . $court . '. Free case review.';
        return roden_seo_truncate( $desc, 160 );
    }

    // --- Sub-type page ---
    // e.g. "Drunk driver accident lawyers at Roden Law. Experienced with drunk driving injury claims in Georgia & South Carolina. Free consultation."
    // Strip trailing "Lawyers" / "Attorneys" to build a natural phrase.
    $case_type = preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', $title );
    $desc = $title . ' at ' . $firm['name'] . '. Experienced with '
        . strtolower( $case_type ) . ' injury claims in Georgia & South Carolina. Free consultation.';
    return roden_seo_truncate( $desc, 160 );
}

/**
 * Meta description for location posts.
 */
function roden_seo_auto_desc_location( $post_id, $title, $firm ) {
    $office_key = get_post_meta( $post_id, '_roden_office_key', true );

    // Neighborhood pages (no office key or _roden_is_neighborhood flag).
    $is_neighborhood = get_post_meta( $post_id, '_roden_is_neighborhood', true );
    if ( $is_neighborhood ) {
        $parent_key = get_post_meta( $post_id, '_roden_parent_office_key', true );
        $parent_office = ( $parent_key && isset( $firm['offices'][ $parent_key ] ) )
            ? $firm['offices'][ $parent_key ] : null;
        $near = $parent_office ? ' near ' . $parent_office['city'] : '';
        return roden_seo_truncate(
            'Personal injury lawyers serving ' . $title . $near . '. ' . $firm['name'] . ' — free consultation, no fees unless we win.',
            160
        );
    }

    if ( ! $office_key || ! isset( $firm['offices'][ $office_key ] ) ) {
        return roden_seo_truncate(
            $firm['name'] . ' — ' . $title . '. Personal injury lawyers serving Georgia & South Carolina. Free consultation.',
            160
        );
    }

    $office = $firm['offices'][ $office_key ];

    // Build service area snippet — first 3 cities from service_area string.
    $svc = $office['service_area'];
    $cities_str = '';
    if ( $svc ) {
        $parts = array_map( 'trim', explode( ',', strtok( $svc, '.' ) ) );
        // Take up to 3 nearby cities (skip the office city itself, which is usually first).
        $nearby = array_slice( array_filter( $parts, function( $c ) use ( $office ) {
            return stripos( $c, $office['city'] ) === false && stripos( $c, 'surrounding' ) === false;
        }), 0, 3 );
        if ( $nearby ) {
            $cities_str = ' Also serving ' . implode( ', ', $nearby ) . '.';
        }
    }

    // e.g. "Roden Law in Savannah, GA — personal injury lawyers with over $250M recovered. Also serving Pooler, Richmond Hill, Hinesville. Call (912) 303-5850."
    return roden_seo_truncate(
        $firm['name'] . ' in ' . $office['city'] . ', ' . $office['state']
        . ' — personal injury lawyers with over $250M recovered.'
        . $cities_str
        . ' Call ' . $office['phone'] . '.',
        160
    );
}

/**
 * Meta description for attorney posts.
 */
function roden_seo_auto_desc_attorney( $post_id, $title, $firm ) {
    // Title / role.
    $atty_title = get_post_meta( $post_id, '_roden_atty_title', true );
    $label = $atty_title ? $title . ', ' . $atty_title : $title . ', Personal Injury Attorney';

    // Office location.
    $office_key = get_post_meta( $post_id, '_roden_atty_office_key', true );
    $office_city = '';
    if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
        $o = $firm['offices'][ $office_key ];
        $office_city = $o['city'] . ', ' . $o['state'];
    }

    // Bar admissions — extract state names.
    $bar_raw = get_post_meta( $post_id, '_roden_bar_admissions', true );
    $bar_str = '';
    if ( $bar_raw ) {
        // Bar field may be textarea with lines like "Georgia, 2015" or serialized.
        $states = array();
        foreach ( explode( "\n", $bar_raw ) as $line ) {
            $line = trim( $line );
            if ( $line ) {
                $parts = array_map( 'trim', explode( ',', $line ) );
                if ( $parts ) {
                    $states[] = $parts[0]; // State name.
                }
            }
        }
        $states = array_unique( $states );
        if ( $states ) {
            $bar_str = ' Licensed in ' . implode( ' & ', array_slice( $states, 0, 2 ) ) . '.';
        }
    }

    // e.g. "Eric Roden, Founding Partner at Roden Law in Savannah, GA. Licensed in Georgia & South Carolina. Free consultation."
    $desc = $label . ' at ' . $firm['name'];
    if ( $office_city ) {
        $desc .= ' in ' . $office_city;
    }
    $desc .= '.' . $bar_str . ' Free consultation.';
    return roden_seo_truncate( $desc, 160 );
}

/**
 * Meta description for case_result posts.
 */
function roden_seo_auto_desc_case_result( $post_id, $title, $firm ) {
    $amount = get_post_meta( $post_id, '_roden_case_amount', true );
    if ( ! $amount ) {
        $amount = get_post_meta( $post_id, '_roden_amount', true );
    }
    $type = get_post_meta( $post_id, '_roden_case_result_type', true );
    if ( ! $type ) {
        $type = get_post_meta( $post_id, '_roden_result_type', true );
    }

    if ( $amount ) {
        // e.g. "$3,000,000 Settlement — Truck Accident Case. Roden Law has recovered over $250M for injured clients across Georgia & South Carolina."
        $prefix = $amount . ' ' . ucfirst( $type ?: 'Recovery' ) . ' — ';
        return roden_seo_truncate(
            $prefix . $title . '. ' . $firm['name'] . ' has recovered over $250M for injured clients across Georgia & South Carolina.',
            160
        );
    }

    return roden_seo_truncate(
        $title . '. ' . $firm['name'] . ' — over $250 million recovered for injured clients in Georgia & South Carolina.',
        160
    );
}

/**
 * Meta description for resource posts.
 */
function roden_seo_auto_desc_resource( $post_id, $title, $firm ) {
    // Pull jurisdiction for context.
    $jurisdiction = get_post_meta( $post_id, '_roden_jurisdiction', true );
    $geo = 'Georgia & South Carolina';
    if ( 'georgia' === strtolower( $jurisdiction ) || 'ga' === strtolower( $jurisdiction ) ) {
        $geo = 'Georgia';
    } elseif ( 'south-carolina' === strtolower( $jurisdiction ) || 'sc' === strtolower( $jurisdiction ) ) {
        $geo = 'South Carolina';
    }

    // e.g. "What to Do After a Car Accident in Georgia. Step-by-step legal guide from Roden Law. Know your rights and protect your claim."
    return roden_seo_truncate(
        $title . '. Step-by-step legal guide from ' . $firm['name'] . '. Know your rights and protect your claim in ' . $geo . '.',
        160
    );
}

/**
 * Meta description for blog posts.
 */
function roden_seo_auto_desc_blog( $post_id, $title, $firm ) {
    // Try excerpt-quality content first: manual excerpt > first paragraph of content.
    $excerpt = get_the_excerpt( $post_id );
    if ( $excerpt ) {
        $cleaned = wp_strip_all_tags( $excerpt );
        // Only use if it's a real excerpt, not auto-generated content trim.
        if ( mb_strlen( $cleaned ) >= 50 ) {
            return roden_seo_truncate( $cleaned, 160 );
        }
    }

    // Extract first meaningful paragraph from post content.
    $content = get_post_field( 'post_content', $post_id );
    $content = strip_shortcodes( $content );
    $content = wp_strip_all_tags( $content );
    $content = preg_replace( '/\s+/', ' ', trim( $content ) );

    if ( mb_strlen( $content ) >= 50 ) {
        return roden_seo_truncate( $content, 160 );
    }

    // Final fallback.
    return roden_seo_truncate(
        $title . '. Personal injury insights from ' . $firm['name'] . ', serving Georgia & South Carolina.',
        160
    );
}

/* ==========================================================================
   3. OPEN GRAPH TAGS
   ========================================================================== */

add_action( 'wp_head', 'roden_output_open_graph', 1 );
/**
 * Output Open Graph meta tags for social sharing.
 */
function roden_output_open_graph() {
    if ( is_404() ) {
        return;
    }

    $firm = roden_firm_data();
    $og   = array(
        'og:locale'    => 'en_US',
        'og:site_name' => $firm['name'],
    );

    // URL.
    $canonical = roden_seo_get_canonical();
    if ( $canonical ) {
        $og['og:url'] = $canonical;
    }

    // Type.
    if ( is_singular( 'post' ) ) {
        $og['og:type'] = 'article';
    } else {
        $og['og:type'] = 'website';
    }

    // Title — use the document title.
    $og['og:title'] = wp_get_document_title();

    // Description.
    $desc = roden_seo_get_description();
    if ( $desc ) {
        $og['og:description'] = $desc;
    }

    // Image — featured image or firm logo.
    $image_data = roden_seo_get_og_image();
    if ( $image_data ) {
        $og['og:image']        = $image_data['url'];
        $og['og:image:width']  = $image_data['width'];
        $og['og:image:height'] = $image_data['height'];
        if ( ! empty( $image_data['alt'] ) ) {
            $og['og:image:alt'] = $image_data['alt'];
        }
    }

    // Article-specific.
    if ( is_singular( 'post' ) ) {
        $og['article:published_time'] = get_the_date( 'c' );
        $og['article:modified_time']  = get_the_modified_date( 'c' );
        $og['article:author']         = get_the_author();
    }

    // Output.
    foreach ( $og as $property => $content ) {
        if ( $content ) {
            echo '<meta property="' . esc_attr( $property ) . '" content="' . esc_attr( $content ) . '" />' . "\n";
        }
    }
}

/* ==========================================================================
   4. TWITTER CARD TAGS
   ========================================================================== */

add_action( 'wp_head', 'roden_output_twitter_card', 1 );
/**
 * Output Twitter Card meta tags.
 */
function roden_output_twitter_card() {
    if ( is_404() ) {
        return;
    }

    $tc = array(
        'twitter:card' => 'summary_large_image',
    );

    $tc['twitter:title'] = wp_get_document_title();

    $desc = roden_seo_get_description();
    if ( $desc ) {
        $tc['twitter:description'] = $desc;
    }

    $image_data = roden_seo_get_og_image();
    if ( $image_data ) {
        $tc['twitter:image'] = $image_data['url'];
        if ( ! empty( $image_data['alt'] ) ) {
            $tc['twitter:image:alt'] = $image_data['alt'];
        }
    }

    foreach ( $tc as $name => $content ) {
        if ( $content ) {
            echo '<meta name="' . esc_attr( $name ) . '" content="' . esc_attr( $content ) . '" />' . "\n";
        }
    }
}

/* ==========================================================================
   5. TAXONOMY ARCHIVE NOINDEX
   ========================================================================== */

add_action( 'wp_head', 'roden_output_noindex_pages', 1 );
/**
 * Output noindex for thin/duplicate archive pages:
 * - Taxonomy archives (practice_category, location_served, tags)
 * - Search results (aggregated, not unique content)
 * - Author archives (exposes user accounts, thin content)
 * - Date archives (thin chronological listings)
 */
function roden_output_noindex_pages() {
    if (
        is_tax( 'practice_category' ) || is_tax( 'location_served' ) || is_tag()
        || is_search()
        || is_author()
        || is_date()
    ) {
        echo '<meta name="robots" content="noindex, follow" />' . "\n";
    }
}

/* ==========================================================================
   HELPERS
   ========================================================================== */

/**
 * Get the Open Graph image data for the current page.
 *
 * Returns featured image if available, otherwise the site logo.
 *
 * @return array|false Array with 'url', 'width', 'height', 'alt' or false.
 */
function roden_seo_get_og_image() {
    // Singular pages — try featured image first.
    if ( is_singular() ) {
        $thumb_id = get_post_thumbnail_id();
        if ( $thumb_id ) {
            $img = wp_get_attachment_image_src( $thumb_id, 'large' );
            if ( $img && $img[1] >= 600 ) {
                return array(
                    'url'    => $img[0],
                    'width'  => $img[1],
                    'height' => $img[2],
                    'alt'    => get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ),
                );
            }
        }
    }

    // Fallback: default social sharing image (1200x630).
    // Check for a dedicated OG image in the theme's assets folder first.
    $default_og_path = get_template_directory() . '/assets/images/og-default.jpg';
    if ( file_exists( $default_og_path ) ) {
        return array(
            'url'    => get_template_directory_uri() . '/assets/images/og-default.jpg',
            'width'  => 1200,
            'height' => 630,
            'alt'    => 'Roden Law — Personal Injury Lawyers in Georgia & South Carolina',
        );
    }

    // Final fallback: site logo (better than nothing).
    $logo_id = get_theme_mod( 'custom_logo' );
    if ( $logo_id ) {
        $img = wp_get_attachment_image_src( $logo_id, 'full' );
        if ( $img ) {
            return array(
                'url'    => $img[0],
                'width'  => $img[1],
                'height' => $img[2],
                'alt'    => get_bloginfo( 'name' ),
            );
        }
    }

    return false;
}

/**
 * Truncate a string to a max length at word boundary, adding ellipsis if needed.
 *
 * @param string $text   Text to truncate.
 * @param int    $length Max length.
 * @return string
 */
function roden_seo_truncate( $text, $length = 155 ) {
    $text = wp_strip_all_tags( $text );
    $text = preg_replace( '/\s+/', ' ', trim( $text ) );

    if ( mb_strlen( $text ) <= $length ) {
        return $text;
    }

    // Reserve space for ellipsis character.
    $truncated = mb_substr( $text, 0, $length - 1 );
    // Cut at last word boundary (within the last 20% of the string).
    $last_space = mb_strrpos( $truncated, ' ' );
    if ( $last_space > ( $length - 1 ) * 0.8 ) {
        $truncated = mb_substr( $truncated, 0, $last_space );
    }

    // Only add ellipsis if the text was actually truncated mid-sentence.
    $last_char = mb_substr( $truncated, -1 );
    if ( ! in_array( $last_char, array( '.', '!', '?' ), true ) ) {
        $truncated .= '…';
    }

    return $truncated;
}
