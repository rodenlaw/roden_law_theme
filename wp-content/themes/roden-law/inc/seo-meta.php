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

    // Practice area pages — add jurisdiction/location context.
    if ( is_singular() && in_array( get_post_type(), array( 'practice_area', 'practice-area' ), true ) ) {
        $post    = get_post();
        $post_id = $post->ID;

        if ( $post->post_parent ) {
            $office_key = get_post_meta( $post_id, '_roden_pa_office_key', true );

            if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
                // Intersection page — append "in City, ST".
                $office = $firm['offices'][ $office_key ];
                $title_parts['title'] .= ' in ' . $office['city'] . ', ' . $office['state'];
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
            $post = get_post( $post_id );
            if ( $post->post_parent ) {
                // Intersection or sub-type — include parent context.
                $parent = get_post( $post->post_parent );
                $parent_title = $parent ? get_the_title( $parent ) : '';
                $office_key = get_post_meta( $post_id, '_roden_office_key', true );

                if ( $office_key ) {
                    // Intersection page.
                    $offices = $firm['offices'];
                    $city = isset( $offices[ $office_key ] ) ? $offices[ $office_key ]['city'] . ', ' . $offices[ $office_key ]['state'] : '';
                    return roden_seo_truncate( $title . '. Experienced ' . strtolower( $parent_title ) . ' serving ' . $city . '. Free consultation. No fees unless we win.', 160 );
                }

                // Sub-type page.
                return roden_seo_truncate( $title . '. ' . $firm['name'] . ' handles ' . strtolower( $title ) . ' cases across Georgia and South Carolina. Free consultation.', 160 );
            }

            // Pillar page.
            return roden_seo_truncate( $title . ' at ' . $firm['name'] . '. Serving Georgia and South Carolina with over $250M recovered. Free consultation — no fees unless we win.', 160 );

        case 'location':
            $office_key = get_post_meta( $post_id, '_roden_office_key', true );
            $offices = $firm['offices'];
            $city = isset( $offices[ $office_key ] ) ? $offices[ $office_key ]['city'] . ', ' . $offices[ $office_key ]['state'] : '';
            return roden_seo_truncate( $firm['name'] . ' in ' . $city . '. Personal injury lawyers with local expertise. Free consultation — call today.', 160 );

        case 'attorney':
            $atty_title = get_post_meta( $post_id, '_roden_title', true );
            $label = $atty_title ? $title . ', ' . $atty_title : $title;
            return roden_seo_truncate( $label . ' at ' . $firm['name'] . '. Personal injury attorney serving Georgia and South Carolina.', 160 );

        case 'case_result':
            $amount = get_post_meta( $post_id, '_roden_amount', true );
            $type   = get_post_meta( $post_id, '_roden_result_type', true );
            $prefix = $amount ? $amount . ' ' . ucfirst( $type ?: 'recovery' ) . '. ' : '';
            return roden_seo_truncate( $prefix . $title . '. ' . $firm['name'] . ' — over $250 million recovered for injured clients.', 160 );

        case 'resource':
            return roden_seo_truncate( $title . '. Free legal resource from ' . $firm['name'] . '. Personal injury guidance for Georgia and South Carolina.', 160 );

        case 'post':
        default:
            // Blog posts — first 160 chars of content.
            $content = get_the_content( null, false, $post_id );
            $content = wp_strip_all_tags( strip_shortcodes( $content ) );
            return roden_seo_truncate( $content, 160 );
    }
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
            if ( $img ) {
                return array(
                    'url'    => $img[0],
                    'width'  => $img[1],
                    'height' => $img[2],
                    'alt'    => get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ),
                );
            }
        }
    }

    // Fallback: site logo.
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
function roden_seo_truncate( $text, $length = 160 ) {
    $text = wp_strip_all_tags( $text );
    $text = preg_replace( '/\s+/', ' ', trim( $text ) );

    if ( mb_strlen( $text ) <= $length ) {
        return $text;
    }

    $truncated = mb_substr( $text, 0, $length );
    // Cut at last word boundary.
    $last_space = mb_strrpos( $truncated, ' ' );
    if ( $last_space > $length * 0.8 ) {
        $truncated = mb_substr( $truncated, 0, $last_space );
    }

    return $truncated;
}
