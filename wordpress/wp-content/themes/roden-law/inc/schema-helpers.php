<?php
/**
 * Schema Helpers — All 10 JSON-LD schema types + BlogPosting.
 *
 * Outputs structured data via the wp_head hook.
 * No schema plugins required — everything is handled here.
 *
 * Schema types:
 *  1. Organization / LawFirm     — Homepage
 *  2. LegalService                — Homepage + practice area pages
 *  3. LocalBusiness               — Homepage (×5) + location pages
 *  4. Person / Attorney           — Attorney pages + author attribution
 *  5. FAQPage                     — Practice area + location pages
 *  6. HowTo                       — Resource pages
 *  7. BreadcrumbList              — Sitewide (except homepage)
 *  8. Speakable                   — Homepage + practice area heroes
 *  9. AggregateRating             — Homepage
 * 10. WebSite                     — Homepage (Sitelinks Searchbox)
 * 11. BlogPosting                 — Blog posts (bonus)
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   HELPERS
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

/**
 * Build a clean description string for schema. Prefers a hand-authored meta
 * description, falls back to the post excerpt, then to a trimmed content
 * fallback. Strips the WP excerpt-truncation suffix (`[…]` / `[&hellip;]`)
 * which leaks into auto-generated descriptions and reads as broken text in
 * SERPs and AI citations.
 *
 * @param int|null $post_id Post ID (defaults to current post).
 * @return string Cleaned description.
 */
function roden_schema_clean_description( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $meta    = get_post_meta( $post_id, '_roden_meta_description', true );
    if ( $meta ) {
        return trim( wp_strip_all_tags( $meta ) );
    }

    $excerpt = get_the_excerpt( $post_id );
    if ( $excerpt ) {
        // Drop the trailing "[…]" / "[&hellip;]" / "…" WP appends to auto-excerpts.
        $excerpt = preg_replace( '/\s*\[(?:&hellip;|\xE2\x80\xA6|\.{3})\]\s*$/u', '', $excerpt );
        $excerpt = preg_replace( '/\s*\xE2\x80\xA6\s*$/u', '', $excerpt );
        return trim( wp_strip_all_tags( html_entity_decode( $excerpt, ENT_QUOTES, 'UTF-8' ) ) );
    }

    $content = get_post_field( 'post_content', $post_id );
    return trim( wp_trim_words( wp_strip_all_tags( $content ), 30, '' ) );
}

/**
 * Check if we're viewing a singular practice_area post.
 * Handles both our CPT slug (practice_area) and ACF's (practice-area).
 *
 * @return bool
 */
function roden_is_pa_singular() {
    return is_singular( 'practice_area' ) || is_singular( 'practice-area' );
}

/**
 * Get the custom logo URL, cached per request.
 *
 * @return string|false Logo URL or false.
 */
function roden_get_logo_url() {
    static $logo_url = null;
    if ( null === $logo_url ) {
        $logo_id  = get_theme_mod( 'custom_logo' );
        $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : false;
    }
    return $logo_url;
}

/**
 * Get the canonical URL for a practice_area post.
 *
 * For intersection and sub-type pages (child practice_area posts), WordPress's
 * get_permalink() returns the CPT default path (/practice-areas/parent/child/)
 * rather than the canonical rewrite path (/parent/child/). This helper returns
 * the correct canonical URL by building it from the parent and child post slugs.
 *
 * For all other post types and for pillar pages (no parent), falls back to
 * get_permalink() which is already correct.
 *
 * @param int|WP_Post|null $post_or_id Post ID, WP_Post object, or null for current post.
 * @return string Canonical URL.
 */
function roden_get_canonical_url( $post_or_id = null ) {
    $post = $post_or_id ? get_post( $post_or_id ) : get_post();
    if ( ! $post ) {
        return get_permalink( $post_or_id );
    }

    // Only intercept child practice_area posts — pillar and other types are fine.
    if (
        in_array( $post->post_type, array( 'practice_area', 'practice-area' ), true )
        && $post->post_parent
    ) {
        $parent = get_post( $post->post_parent );
        if ( $parent ) {
            return home_url( '/' . $parent->post_name . '/' . $post->post_name . '/' );
        }
    }

    return get_permalink( $post );
}

/**
 * Page templates that are intentionally noindex (PPC / Google Ads landing
 * pages). Centralized so canonical output, breadcrumb schema, and sitemap
 * exclusion stay in sync — these pages hardcode <meta robots noindex> and
 * must not emit a canonical, carry BreadcrumbList, or appear in the sitemap.
 *
 * @return string[] Template paths relative to the theme root.
 */
function roden_noindex_page_templates() {
    return array(
        'templates/template-landing-page.php',
        'templates/template-landing-truck.php',
        'templates/template-landing-truck-columbia.php',
        'templates/template-landing-charleston.php',
        'templates/template-landing-sc-statewide.php',
        'templates/template-landing-ga-car-accident.php',
    );
}

/**
 * Whether the current request renders a noindex landing page template.
 *
 * @return bool
 */
function roden_is_noindex_landing() {
    foreach ( roden_noindex_page_templates() as $tpl ) {
        if ( is_page_template( $tpl ) ) {
            return true;
        }
    }
    return false;
}

/* ==========================================================================
   SCHEMA DISPATCHER (wp_head hook)
   ========================================================================== */

add_action( 'wp_head', 'roden_output_schema', 1 );
function roden_output_schema() {
    $firm = roden_firm_data();

    if ( is_front_page() ) {
        roden_schema_organization( $firm );
        roden_schema_legal_service( $firm ); // emits aggregateRating inline on homepage
        roden_schema_local_business_all( $firm );
        roden_schema_speakable_homepage( $firm );
        roden_schema_website( $firm );
        roden_schema_breadcrumbs(); // Single-item homepage breadcrumb (site hierarchy signal)
    }

    if ( roden_is_pa_singular() ) {
        roden_schema_legal_service( $firm );
        roden_schema_pa_attorney( $firm );
        roden_schema_faq_page();
        roden_schema_speakable_practice_area();

        // LocalBusiness + HowTo on intersection pages — ties to physical office + "What to Do" steps.
        if ( function_exists( 'roden_is_intersection_page' ) && roden_is_intersection_page() ) {
            roden_schema_local_business_single( $firm );
            roden_schema_intersection_howto( $firm );
        }

        // Article schema for sub-type pages (child PA posts without an office key).
        if ( function_exists( 'roden_is_subtype_page' ) && roden_is_subtype_page() ) {
            roden_schema_article_subtype( $firm );
        }
    }

    if ( is_singular( 'location' ) ) {
        $is_neighborhood = get_post_meta( get_the_ID(), '_roden_is_neighborhood', true );
        if ( $is_neighborhood ) {
            roden_schema_neighborhood_legal_service( $firm );
            roden_schema_local_business_neighborhood( $firm );
        } elseif ( roden_is_state_landing() ) {
            roden_schema_state_landing( $firm );
        } else {
            roden_schema_local_business_single( $firm );
        }
        roden_schema_faq_page();
        roden_schema_speakable_location();
    }

    if ( is_singular( 'attorney' ) ) {
        roden_schema_person( $firm );
    }

    if ( is_post_type_archive( 'attorney' ) ) {
        roden_schema_attorneys_list( $firm );
    }

    if ( is_singular( 'case_result' ) ) {
        roden_schema_case_result( $firm );
    }

    if ( is_singular( 'testimonial' ) ) {
        roden_schema_testimonial( $firm );
    }

    if ( is_singular( 'resource' ) ) {
        // Most resource posts are informational articles, not step-by-step
        // guides. Emit Article/BlogPosting by default; opt into HowTo only
        // when the post is explicitly flagged via _roden_is_howto meta (set
        // for genuine "What to do after X" content).
        $is_howto = get_post_meta( get_the_ID(), '_roden_is_howto', true );
        if ( $is_howto ) {
            roden_schema_howto();
        } else {
            roden_schema_article( $firm );
        }
    }

    if ( is_singular( 'post' ) ) {
        roden_schema_article( $firm );
        roden_schema_faq_page();
    }

    // Taxonomy archives — CollectionPage schema
    if ( is_tax( 'practice_category' ) || is_tax( 'location_served' ) ) {
        roden_schema_taxonomy_archive( $firm );
    }

    // CPT archives + blog index — CollectionPage / Blog schema. Previously
    // these pages emitted only a BreadcrumbList, leaving the archive itself
    // entity-less in the graph.
    if ( is_post_type_archive( 'resource' ) ) {
        roden_schema_collection_page( $firm, 'CollectionPage', 'resource' );
    }
    if ( is_home() ) {
        roden_schema_collection_page( $firm, 'Blog', 'post' );
    }

    // Contact page — Organization with ContactPoint
    if ( is_page( 'contact' ) ) {
        roden_schema_contact_page( $firm );
    }

    // About page — AboutPage tied to the firm Organization entity.
    // The strongest entity-defining page on the site needs schema that
    // explicitly links its content to the firm @id so AI systems treat it
    // as the canonical "what is Roden Law" answer source.
    if ( is_page( 'about' ) ) {
        roden_schema_about_page( $firm );
    }

    // SC statewide PPC landing page — LegalService + FAQPage + LocalBusiness (SC offices)
    if ( is_page_template( 'templates/template-landing-sc-statewide.php' ) ) {
        roden_schema_sc_statewide( $firm );
    }

    // BreadcrumbList on all pages except front page and noindex landing pages.
    if ( ! is_front_page() && ! roden_is_noindex_landing() ) {
        roden_schema_breadcrumbs();
    }
}

/* ==========================================================================
   1. Organization / LawFirm (Homepage)
   ========================================================================== */

function roden_schema_organization( $firm ) {
    // Merge social + legal directory profiles, drop empties, dedupe.
    // Social handles + legal directories (Avvo, Justia, GBP, etc.) help AI
    // systems cross-reference the firm as an authoritative legal entity.
    $same_as = array_filter( array_merge(
        array_values( $firm['social'] ),
        array_values( $firm['legal_directories'] ?? array() )
    ) );

    $schema = array(
        '@context'     => 'https://schema.org',
        '@type'        => array( 'Organization', 'LawFirm' ),
        '@id'          => $firm['url'] . '/#organization',
        'name'         => $firm['name'],
        'url'          => $firm['url'],
        'description'  => $firm['description'],
        'telephone'    => $firm['phone_e164'],
        'foundingDate' => $firm['founded'],
        'areaServed'   => array(
            array( '@type' => 'State', 'name' => 'Georgia' ),
            array( '@type' => 'State', 'name' => 'South Carolina' ),
        ),
        'sameAs' => array_values( array_unique( $same_as ) ),
    );

    // legalName only when the registered legal name differs from the brand
    // name. Today legal_entity equals name; emitting both is redundant and
    // misleads validators that treat them as distinct entities.
    if ( ! empty( $firm['legal_entity'] ) && $firm['legal_entity'] !== $firm['name'] ) {
        $schema['legalName'] = $firm['legal_entity'];
    }

    $logo_url = roden_get_logo_url();
    if ( $logo_url ) {
        $schema['logo'] = array(
            '@type'      => 'ImageObject',
            'url'        => $logo_url,
            'contentUrl' => $logo_url,
        );
        $schema['image'] = $logo_url;
    }

    // All offices as sub-locations. Reference the canonical LocalBusiness
    // @id (defined by roden_schema_local_business_office on the same page)
    // so AI systems treat the nested entries and standalone blocks as the
    // same entities — no duplicated sameAs/address/geo to drift out of sync.
    $locations = array();
    foreach ( $firm['offices'] as $key => $office ) {
        $locations[] = array(
            '@type' => 'LocalBusiness',
            '@id'   => $firm['url'] . '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['market_name'] ) . '/#localbusiness',
            'name'  => $office['name'],
        );
    }
    $schema['location'] = $locations;

    // Founders — link to Person entities
    $schema['founder'] = array(
        array(
            '@type' => 'Person',
            '@id'   => $firm['url'] . '/attorneys/eric-roden/#person',
            'name'  => 'Eric Roden',
        ),
        array(
            '@type' => 'Person',
            '@id'   => $firm['url'] . '/attorneys/tyler-love/#person',
            'name'  => 'Tyler Love',
        ),
    );

    // ContactPoints live on the canonical Organization so the contact page can
    // just reference #organization by @id instead of redefining the entity.
    $schema['contactPoint'] = roden_build_contact_points( $firm );

    roden_json_ld( $schema );
}

/* ==========================================================================
   2. LegalService (Homepage + Practice Area pages)
   ========================================================================== */

function roden_schema_legal_service( $firm ) {
    // Homepage uses the firm-level @id; all other pages get page-specific @ids
    // linked back to the firm entity via isPartOf to maintain entity hierarchy.
    $firm_ls_id = $firm['url'] . '/#legalservice';
    if ( is_front_page() ) {
        $ls_id  = $firm_ls_id;
        $ls_url = $firm['url'];
    } else {
        $ls_url = roden_get_canonical_url();
        $ls_id  = rtrim( $ls_url, '/' ) . '/#legalservice';
    }

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'LegalService',
        '@id'         => $ls_id,
        'name'        => $firm['name'],
        'url'         => $ls_url,
        'description' => $firm['description'],
        'telephone'   => $firm['phone_e164'],
        'priceRange'  => '$$',
        'areaServed'  => array(
            array( '@type' => 'State', 'name' => 'Georgia' ),
            array( '@type' => 'State', 'name' => 'South Carolina' ),
        ),
        'serviceType' => 'Personal Injury Law',
        'knowsAbout'  => array(
            'Car Accidents', 'Truck Accidents', 'Slip and Fall',
            'Motorcycle Accidents', 'Medical Malpractice', 'Wrongful Death',
            'Workers Compensation', 'Dog Bites', 'Brain Injuries',
            'Spinal Cord Injuries', 'Maritime Injuries', 'Product Liability',
            'Boating Accidents', 'Burn Injuries', 'Construction Accidents',
            'Nursing Home Abuse', 'Premises Liability', 'Pedestrian Accidents',
            'Bicycle Accidents', 'Electric Scooter Accidents',
            'ATV & Side-by-Side Accidents', 'Golf Cart Accidents',
        ),
    );

    // Non-homepage pages: link back to the firm-level entity
    if ( ! is_front_page() ) {
        $schema['isPartOf'] = array( '@id' => $firm_ls_id );
    }

    // image — firm logo as a fallback so the LocalBusiness-derived rich
    // result has the required image field. Per-PA hero images are not
    // surfaced as schema today; once they are, prefer those for pillar pages.
    $logo_url = roden_get_logo_url();
    if ( $logo_url ) {
        $schema['image'] = $logo_url;
    }

    // Homepage carries the firm-wide AggregateRating inline as a property of
    // the LegalService it rates, not as a standalone node. Google's review
    // snippet docs expect aggregateRating to be a property of the reviewed
    // entity; standalone nodes only bind reliably inside a single @graph.
    if ( is_front_page() ) {
        $review_count = isset( $firm['trust_stats']['review_count'] ) ? intval( $firm['trust_stats']['review_count'] ) : 500;
        $rating       = isset( $firm['trust_stats']['rating'] ) ? $firm['trust_stats']['rating'] : '4.9';
        $schema['aggregateRating'] = array(
            '@type'       => 'AggregateRating',
            'ratingValue' => $rating,
            'bestRating'  => '5',
            'worstRating' => '1',
            'reviewCount' => $review_count,
        );
    }

    // On singular practice area, customize for that page
    if ( roden_is_pa_singular() ) {
        $schema['name']        = get_the_title() . ' — ' . $firm['name'];
        $schema['description'] = roden_schema_clean_description( get_the_ID() );

        // dateModified — critical AI freshness signal (+40% citation boost with recency)
        $schema['dateModified'] = get_the_modified_date( 'c' );

        $is_intersection = function_exists( 'roden_is_intersection_page' ) && roden_is_intersection_page();

        // Narrow areaServed on intersection pages to the specific location
        if ( $is_intersection ) {
            $office = roden_get_intersection_office();
            if ( $office ) {
                $schema['areaServed'] = array(
                    array(
                        '@type' => 'City',
                        'name'  => $office['market_name'] . ', ' . $office['state'],
                    ),
                );
            }
        }

        // No aggregateRating on per-PA LegalService entities. Asserting the
        // firm-wide rating on every practice-area page is treated by Google as
        // self-serving review snippet markup (the rating is about the firm,
        // not the specific service) and risks sitewide review-snippet
        // suppression / manual action. Per-office ratings on the co-emitted
        // intersection LocalBusiness are still allowed because they're scoped
        // to a real reviewed entity (the office's GBP listing).

        // provider is always the firm (Organization) — a single attorney
        // doesn't "provide" an entire practice area, and Person isn't a
        // valid provider type for LegalService in Google's parsing. E-E-A-T
        // attorney attribution still ships through roden_schema_pa_attorney()
        // as a separate Person entity referenced by the WebPage / Article.
        $schema['provider'] = array(
            '@id' => $firm['url'] . '/#organization',
        );
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   3. LocalBusiness (all offices — Homepage)
   ========================================================================== */

function roden_schema_local_business_all( $firm ) {
    foreach ( $firm['offices'] as $key => $office ) {
        roden_schema_local_business_office( $firm, $key, $office );
    }
}

/* ==========================================================================
   3b. LocalBusiness (single office — Location page)
   ========================================================================== */

function roden_schema_local_business_single( $firm ) {
    $office_key = get_post_meta( get_the_ID(), '_roden_office_key', true );

    // Fallback: derive from post_name slug when meta is absent (intersection pages).
    // roden_is_intersection_page() already confirmed post_name is a known office slug.
    if ( ! $office_key ) {
        $post = get_post();
        if ( $post ) {
            $office_key = roden_office_key_from_slug( $post->post_name );
        }
    }

    if ( ! $office_key || ! isset( $firm['offices'][ $office_key ] ) ) {
        return;
    }
    roden_schema_local_business_office( $firm, $office_key, $firm['offices'][ $office_key ] );
}

/** Shared LocalBusiness builder for one office. */
function roden_schema_local_business_office( $firm, $key, $office ) {
    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => array( 'LocalBusiness', 'LegalService', 'LawFirm' ),
        '@id'        => $firm['url'] . '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['market_name'] ) . '/#localbusiness',
        'name'       => $office['name'],
        'url'        => $firm['url'] . '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['market_name'] ) . '/',
        'telephone'  => $office['phone'],
        'priceRange' => '$$',
        'address'    => roden_schema_postal_address( $office ),
        'geo'        => roden_schema_geo( $office ),
        'areaServed' => roden_schema_office_area_served( $office ),
        'openingHoursSpecification' => array(
            array(
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
                'opens'     => '08:00',
                'closes'    => '18:00',
            ),
        ),
        'openingHours'       => 'Mo-Fr 08:00-18:00',
        'hasMap'             => $office['map_url'],
        'parentOrganization' => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        ),
    );

    // Per-location sameAs — Google Business Profile, Yelp, etc. These are
    // location-scoped entities (one listing per office), so they belong on
    // the LocalBusiness, not the firm-level Organization. Filter empties.
    $office_same_as = array_filter( array(
        $office['gbp_url']  ?? '',
        $office['yelp_url'] ?? '',
    ) );
    if ( ! empty( $office_same_as ) ) {
        $schema['sameAs'] = array_values( $office_same_as );
    }

    // aggregateRating — output when per-office GBP review count has been populated.
    // review_count and review_rating are set in inc/firm-data.php per office.
    $review_count  = isset( $office['review_count'] ) ? intval( $office['review_count'] ) : 0;
    $review_rating = isset( $office['review_rating'] ) ? $office['review_rating'] : '4.9';
    if ( $review_count > 0 ) {
        $schema['aggregateRating'] = array(
            '@type'       => 'AggregateRating',
            'ratingValue' => $review_rating,
            'bestRating'  => '5',
            'worstRating' => '1',
            'reviewCount' => $review_count,
        );
    }

    $logo_url = roden_get_logo_url();
    if ( $logo_url ) {
        $schema['image'] = $logo_url;
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   4. Person / Attorney (Attorney pages + author attribution)
   ========================================================================== */

function roden_schema_person( $firm ) {
    $post_id = get_the_ID();

    // worksFor is a graph stub — the canonical Organization is defined once
    // on the homepage. Redefining it here with different properties would
    // create a conflicting @id and degrade entity recognition.
    $office_key = get_post_meta( $post_id, '_roden_atty_office_key', true );
    $works_for  = array(
        '@type' => 'Organization',
        '@id'   => $firm['url'] . '/#organization',
        'name'  => $firm['name'],
    );

    // Use canonical rodenlaw.com domain for @id regardless of current site URL
    // (prevents dev site domain from leaking into Person @id on staging/dev).
    $atty_slug    = get_post_field( 'post_name', $post_id );
    $canonical_id = $firm['url'] . '/attorneys/' . $atty_slug . '/#person';
    $atty_url     = str_replace( home_url(), $firm['url'], get_permalink() );

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'Person',
        '@id'         => $canonical_id,
        'name'        => get_the_title(),
        'url'         => $atty_url,
        'description' => html_entity_decode( wp_strip_all_tags( get_the_excerpt() ?: wp_trim_words( get_the_content(), 30 ) ), ENT_QUOTES, 'UTF-8' ),
        'worksFor'    => $works_for,
    );

    // workLocation — graph-link to the attorney's primary office LocalBusiness.
    // Provides geographic context without redefining the office entity.
    if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
        $office = $firm['offices'][ $office_key ];
        $market_slug = sanitize_title( $office['market_name'] ?? $office['city'] );
        $schema['workLocation'] = array(
            '@type' => 'LocalBusiness',
            '@id'   => $firm['url'] . '/locations/' . $office['state_slug'] . '/' . $market_slug . '/#localbusiness',
            'name'  => $office['name'],
        );
    }

    // Featured image
    if ( has_post_thumbnail() ) {
        $schema['image'] = get_the_post_thumbnail_url( $post_id, 'attorney-headshot' );
    }

    // Job title — meta field first, fall back to firm data
    $job_title = get_post_meta( $post_id, '_roden_atty_title', true );
    if ( ! $job_title ) {
        $slug = get_post_field( 'post_name', $post_id );
        if ( isset( $firm['attorneys'][ $slug ] ) ) {
            $job_title = $firm['attorneys'][ $slug ]['title'];
        }
    }
    if ( $job_title ) {
        $schema['jobTitle'] = $job_title;
    }

    // Bar admissions → hasCredential
    // Pull from post meta first; supplement with firm-data.php bars to ensure
    // completeness (e.g. SC admission that may not yet be in meta).
    $bar      = get_post_meta( $post_id, '_roden_bar_admissions', true );
    $bar_list = $bar ? array_filter( array_map( 'trim', explode( "\n", $bar ) ) ) : array();

    // Supplement from firm-data bar_admissions array (state names like 'Georgia', 'South Carolina')
    if ( isset( $firm['attorneys'][ $atty_slug ]['bar_admissions'] ) ) {
        $bar_state_map = array(
            'Georgia'        => 'State Bar of Georgia',
            'South Carolina' => 'South Carolina State Bar',
        );
        foreach ( $firm['attorneys'][ $atty_slug ]['bar_admissions'] as $state ) {
            $bar_name = isset( $bar_state_map[ $state ] ) ? $bar_state_map[ $state ] : $state . ' State Bar';
            // Avoid duplicate if meta already has a matching entry
            $already_listed = false;
            foreach ( $bar_list as $existing ) {
                if ( false !== stripos( $existing, $state ) ) {
                    $already_listed = true;
                    break;
                }
            }
            if ( ! $already_listed ) {
                $bar_list[] = $bar_name;
            }
        }
    }

    if ( ! empty( $bar_list ) ) {
        $bar_state_to_org = array(
            'georgia'        => 'State Bar of Georgia',
            'south carolina' => 'South Carolina State Bar',
        );
        $schema['hasCredential'] = array_map( function( $admission ) use ( $bar_state_to_org ) {
            $credential = array(
                '@type'              => 'EducationalOccupationalCredential',
                'credentialCategory' => 'Bar Admission',
                'name'               => $admission,
            );
            // Add recognizedBy for known state bars
            foreach ( $bar_state_to_org as $state_key => $org_name ) {
                if ( false !== stripos( $admission, $state_key ) ) {
                    $credential['recognizedBy'] = array(
                        '@type' => 'GovernmentOrganization',
                        'name'  => $org_name,
                    );
                    break;
                }
            }
            return $credential;
        }, array_values( $bar_list ) );
    }

    // Education → alumniOf
    $education = get_post_meta( $post_id, '_roden_education', true );
    if ( is_array( $education ) && ! empty( $education ) ) {
        $alumni = array();
        foreach ( $education as $edu ) {
            if ( ! empty( $edu['institution'] ) ) {
                $alumni[] = array(
                    '@type' => 'EducationalOrganization',
                    'name'  => $edu['institution'],
                );
            }
        }
        if ( ! empty( $alumni ) ) {
            $schema['alumniOf'] = $alumni;
        }
    }

    // sameAs — Avvo, LinkedIn, and additional profile links
    $same_as  = array();
    $avvo     = get_post_meta( $post_id, '_roden_avvo_url', true );
    $linkedin = get_post_meta( $post_id, '_roden_linkedin_url', true );
    $extra    = get_post_meta( $post_id, '_roden_same_as', true );
    if ( $avvo ) {
        $same_as[] = $avvo;
    }
    if ( $linkedin ) {
        $same_as[] = $linkedin;
    }
    if ( is_array( $extra ) ) {
        $same_as = array_merge( $same_as, $extra );
    }
    if ( ! empty( $same_as ) ) {
        $schema['sameAs'] = array_values( array_unique( $same_as ) );
    }

    // knowsAbout — personal injury practice areas
    $schema['knowsAbout'] = array( 'Personal Injury Law', 'Insurance Claims', 'Civil Litigation' );

    // Awards — from _roden_awards repeater meta field
    $awards_raw = get_post_meta( $post_id, '_roden_awards', true );
    if ( is_array( $awards_raw ) && ! empty( $awards_raw ) ) {
        $award_list = array();
        foreach ( $awards_raw as $award ) {
            if ( ! empty( $award['award'] ) ) {
                $label = $award['award'];
                if ( ! empty( $award['year'] ) ) {
                    $label .= ' ' . $award['year'];
                }
                $award_list[] = $label;
            }
        }
        if ( ! empty( $award_list ) ) {
            $schema['award'] = $award_list;
        }
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   4b. Person — Attorney attribution on practice area pages (E-E-A-T)
   ========================================================================== */

/**
 * Output Person schema for the attorney attributed to a practice area page.
 * Uses _roden_author_attorney post meta; falls back to Eric Roden if not set.
 * Also adds a `provider` reference from the page's LegalService to this Person.
 *
 * Called from the dispatcher when roden_is_pa_singular() is true.
 */
function roden_schema_pa_attorney( $firm ) {
    $post_id   = get_the_ID();
    $author_id = get_post_meta( $post_id, '_roden_author_attorney', true );

    // Resolve attorney post; fall back to Eric Roden post by slug
    $atty = null;
    if ( $author_id ) {
        $atty = get_post( $author_id );
        if ( ! $atty || 'publish' !== $atty->post_status ) {
            $atty = null;
        }
    }
    if ( ! $atty ) {
        // Fallback: look up Eric Roden post by post_name
        $results = get_posts( array(
            'post_type'   => 'attorney',
            'name'        => 'eric-roden',
            'post_status' => 'publish',
            'numberposts' => 1,
        ) );
        $atty = ! empty( $results ) ? $results[0] : null;
    }

    if ( ! $atty ) {
        return;
    }

    $atty_slug    = $atty->post_name;
    $canonical_id = $firm['url'] . '/attorneys/' . $atty_slug . '/#person';
    $atty_url     = str_replace( home_url(), $firm['url'], get_permalink( $atty->ID ) );

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'Person',
        '@id'         => $canonical_id,
        'name'        => $atty->post_title,
        'url'         => $atty_url,
        'worksFor'    => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        ),
    );

    // Job title from firm data
    if ( isset( $firm['attorneys'][ $atty_slug ]['title'] ) ) {
        $schema['jobTitle'] = $firm['attorneys'][ $atty_slug ]['title'];
    }

    // Bar admissions from firm data with recognizedBy
    if ( isset( $firm['attorneys'][ $atty_slug ]['bar_admissions'] ) ) {
        $bar_state_to_org = array(
            'Georgia'        => 'State Bar of Georgia',
            'South Carolina' => 'South Carolina State Bar',
        );
        $credentials = array();
        foreach ( $firm['attorneys'][ $atty_slug ]['bar_admissions'] as $state ) {
            $org_name    = isset( $bar_state_to_org[ $state ] ) ? $bar_state_to_org[ $state ] : $state . ' State Bar';
            $credentials[] = array(
                '@type'              => 'EducationalOccupationalCredential',
                'credentialCategory' => 'Bar Admission',
                'name'               => $org_name,
                'recognizedBy'       => array(
                    '@type' => 'GovernmentOrganization',
                    'name'  => $org_name,
                ),
            );
        }
        if ( ! empty( $credentials ) ) {
            $schema['hasCredential'] = $credentials;
        }
    }

    // headshot
    if ( has_post_thumbnail( $atty->ID ) ) {
        $schema['image'] = get_the_post_thumbnail_url( $atty->ID, 'attorney-headshot' );
    }

    // sameAs — Avvo, LinkedIn, and additional profile links (E-E-A-T)
    $same_as  = array();
    $avvo     = get_post_meta( $atty->ID, '_roden_avvo_url', true );
    $linkedin = get_post_meta( $atty->ID, '_roden_linkedin_url', true );
    $extra    = get_post_meta( $atty->ID, '_roden_same_as', true );
    if ( $avvo ) {
        $same_as[] = $avvo;
    }
    if ( $linkedin ) {
        $same_as[] = $linkedin;
    }
    if ( is_array( $extra ) ) {
        $same_as = array_merge( $same_as, $extra );
    }
    if ( ! empty( $same_as ) ) {
        $schema['sameAs'] = array_values( array_unique( $same_as ) );
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   5. FAQPage (Practice Area + Location pages)
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
        '@id'        => roden_get_canonical_url() . '#faqs',
        'mainEntity' => $faq_entities,
    ) );
}

/* ==========================================================================
   6. HowTo (Resource pages)
   ========================================================================== */

/**
 * Output HowTo schema on resource pages.
 * Parses post content for ordered list items (<ol><li>) to build steps.
 * Falls back to H2/H3 headings as steps if no ordered list found.
 */
function roden_schema_howto() {
    $post_id = get_the_ID();
    $title   = get_the_title( $post_id );
    $content = get_the_content( null, false, $post_id );
    $url     = get_permalink( $post_id );

    $steps = roden_extract_howto_steps( $content );
    if ( empty( $steps ) ) {
        return;
    }

    $step_entities = array();
    $position      = 1;
    foreach ( $steps as $step ) {
        $step_entities[] = array(
            '@type'    => 'HowToStep',
            'position' => $position++,
            'name'     => $step['name'],
            'text'     => $step['text'],
            'url'      => $url . '#step-' . sanitize_title( $step['name'] ),
        );
    }

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'HowTo',
        '@id'         => $url . '#howto',
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
 * Build a readable HowTo step name from the step body text.
 *
 * The previous approach (wp_trim_words at 8 words) sliced mid-sentence,
 * producing fragments like "Move to safety: If your vehicle is drivable,".
 * This helper prefers the first natural clause break (`.`, `?`, `!`,
 * `:`, `;` or em/en dash) within the first 80 characters, falling back to
 * an 8-word trim with trailing punctuation stripped.
 *
 * @param string $text Plain-text step body.
 * @return string Clean step name.
 */
function roden_howto_step_name( $text ) {
    $text = trim( $text );
    if ( '' === $text ) {
        return '';
    }
    // Prefer the first natural clause/sentence break inside the leading 80 chars.
    if ( preg_match( '/^([^.!?:;\x{2014}\x{2013}]{8,80}?)\s*[.!?:;\x{2014}\x{2013}]/u', $text, $m ) ) {
        $name = trim( $m[1] );
        if ( mb_strlen( $name ) >= 8 ) {
            return $name;
        }
    }
    // Fallback: first 8 words with trailing punctuation trimmed off.
    return rtrim( wp_trim_words( $text, 8, '' ), " \t\n\r\0\x0B,;:.-" );
}

/**
 * Extract HowTo steps from post content.
 * Strategy 1: <ol><li> elements. Strategy 2: H2/H3 headings.
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
                        'name' => roden_howto_step_name( $text ),
                        'text' => $text,
                    );
                }
            }
        }
    }

    if ( ! empty( $steps ) ) {
        return $steps;
    }

    // Strategy 2: H2/H3 headings as step names
    if ( preg_match_all( '/<h[23][^>]*>(.*?)<\/h[23]>/si', $content, $heading_matches ) ) {
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

/* ==========================================================================
   6b. HowTo — Intersection pages ("What to Do After [Accident] in [City]")
   ========================================================================== */

/**
 * Output HowTo schema for intersection pages' "What to Do" steps.
 * These target high-value "what to do after [accident] in [city]" queries
 * that frequently trigger AI Overviews and Google featured snippets.
 *
 * @param array $firm Firm data from roden_firm_data().
 */
function roden_schema_intersection_howto( $firm ) {
    $post    = get_post();
    $parent  = $post->post_parent ? get_post( $post->post_parent ) : null;

    if ( ! $parent ) {
        return;
    }

    $office_key = get_post_meta( get_the_ID(), '_roden_pa_office_key', true );
    $office     = isset( $firm['offices'][ $office_key ] ) ? $firm['offices'][ $office_key ] : null;

    if ( ! $office ) {
        return;
    }

    $accident_type = strtolower( str_replace( ' Lawyers', '', $parent->post_title ) );
    $city_label    = $office['market_name'] . ', ' . $office['state'];
    $url           = roden_get_canonical_url();

    $steps = array(
        array( 'name' => 'Ensure safety and call 911',                 'text' => 'Move to a safe location if possible. Call emergency services to report the accident and request medical attention for anyone injured.' ),
        array( 'name' => 'Seek immediate medical attention',           'text' => 'Even if injuries seem minor, get examined by a doctor. Some injuries may not show symptoms immediately.' ),
        array( 'name' => 'Document the scene',                        'text' => 'Take photos of all vehicles, injuries, road conditions, traffic signs, and any visible damage. Collect names and contact information from witnesses.' ),
        array( 'name' => 'Exchange information with all parties',      'text' => 'Get the other driver\'s name, insurance information, license plate number, and driver\'s license number. Do not admit fault or apologize.' ),
        array( 'name' => 'Report the accident to police',             'text' => $office['state_full'] . ' law requires accident reports when there are injuries or significant property damage. Request a copy of the police report.' ),
        array( 'name' => 'Notify your insurance company',             'text' => 'Report the accident to your insurer promptly. Provide factual information only — do not speculate about fault or the extent of your injuries.' ),
        array( 'name' => 'Contact an experienced personal injury attorney', 'text' => 'An attorney can protect your rights, handle communications with insurance companies, and help you pursue the full compensation you deserve.' ),
    );

    $step_entities = array();
    foreach ( $steps as $i => $step ) {
        $step_entities[] = array(
            '@type'    => 'HowToStep',
            'position' => $i + 1,
            'name'     => $step['name'],
            'text'     => $step['text'],
            'url'      => $url . '#step-' . sanitize_title( $step['name'] ),
        );
    }

    roden_json_ld( array(
        '@context'    => 'https://schema.org',
        '@type'       => 'HowTo',
        '@id'         => $url . '#howto',
        'name'        => 'What to Do After ' . ucfirst( $accident_type ) . ' in ' . $city_label,
        'description' => 'Step-by-step guide on what to do after ' . $accident_type . ' in ' . $city_label . '. Protect your rights and maximize your compensation.',
        'url'         => $url,
        'step'        => $step_entities,
    ) );
}

/* ==========================================================================
   7. BreadcrumbList (Sitewide, except homepage)
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

    if ( roden_is_pa_singular() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Practice Areas', 'roden-law' ),
            'item'     => home_url( '/practice-areas/' ),
        );

        // If child (intersection or sub-type), add parent pillar
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
            'item'     => roden_get_canonical_url(),
        );

    } elseif ( is_singular( 'location' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Locations', 'roden-law' ),
            'item'     => home_url( '/locations/' ),
        );

        $firm            = roden_firm_data();
        $is_neighborhood = get_post_meta( get_the_ID(), '_roden_is_neighborhood', true );

        if ( $is_neighborhood ) {
            // Neighborhood: Locations > State > [ancestors] > Neighborhood
            $parent_office_key = get_post_meta( get_the_ID(), '_roden_parent_office_key', true );
            if ( $parent_office_key && isset( $firm['offices'][ $parent_office_key ] ) ) {
                $office = $firm['offices'][ $parent_office_key ];
                $state_url = trailingslashit( home_url( '/locations/' . $office['state_slug'] . '/' ) );
                $items[] = array(
                    '@type'    => 'ListItem',
                    'position' => $position++,
                    'name'     => $office['state_full'],
                    'item'     => home_url( '/locations/' . $office['state_slug'] . '/' ),
                );
                // Walk ancestor chain (same logic as HTML breadcrumb in template-tags.php).
                $ancestors = array();
                $walk_id   = wp_get_post_parent_id( get_the_ID() );
                while ( $walk_id ) {
                    $ancestors[] = $walk_id;
                    if ( get_post_meta( $walk_id, '_roden_office_key', true ) ) {
                        break;
                    }
                    $walk_id = wp_get_post_parent_id( $walk_id );
                }
                $ancestors = array_reverse( $ancestors );
                foreach ( $ancestors as $anc_id ) {
                    // Skip state-level ancestors — already added above.
                    if ( trailingslashit( get_permalink( $anc_id ) ) === $state_url ) {
                        continue;
                    }
                    $items[] = array(
                        '@type'    => 'ListItem',
                        'position' => $position++,
                        'name'     => get_the_title( $anc_id ),
                        'item'     => get_permalink( $anc_id ),
                    );
                }
            }
        } else {
            // Standard office: Locations > State > City
            $office_key = get_post_meta( get_the_ID(), '_roden_office_key', true );
            if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
                $office = $firm['offices'][ $office_key ];
                $items[] = array(
                    '@type'    => 'ListItem',
                    'position' => $position++,
                    'name'     => $office['state_full'],
                    'item'     => home_url( '/locations/' . $office['state_slug'] . '/' ),
                );
            }
        }

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

    } elseif ( is_singular() && ! is_front_page() ) {
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

    // Allow single-item BreadcrumbList on homepage (signals top of hierarchy);
    // require at least 2 items on all other pages.
    $min_items = is_front_page() ? 1 : 2;
    if ( count( $items ) < $min_items ) {
        return;
    }

    // Pick the correct URL for the @id. roden_get_canonical_url() falls back
    // to get_permalink(), which on archive pages returns the loop's current
    // post (the *first* post in the archive), not the archive itself. This
    // makes the resource/blog archive breadcrumb @id point at a stale single
    // post unless we special-case the archive cases first.
    if ( is_front_page() ) {
        $breadcrumb_url = home_url( '/' );
    } elseif ( is_post_type_archive() ) {
        $breadcrumb_url = get_post_type_archive_link( get_queried_object()->name ?? get_post_type() );
    } elseif ( is_home() ) {
        $breadcrumb_url = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' );
    } elseif ( is_search() ) {
        $breadcrumb_url = get_search_link();
    } else {
        $breadcrumb_url = roden_get_canonical_url();
    }
    roden_json_ld( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        '@id'             => $breadcrumb_url . '#breadcrumbs',
        'itemListElement' => $items,
    ) );
}

/* ==========================================================================
   8. Speakable (Homepage + Practice Area pages)
   ========================================================================== */

function roden_schema_speakable_homepage( $firm ) {
    // url is intentionally omitted here. The @id already encodes the page URL,
    // and co-emitting `url` next to the homepage Organization's `url` produces
    // a "Duplicate field url" non-critical warning in Google's Rich Results
    // Test for the merged Organization rich result.
    roden_json_ld( array(
        '@context'   => 'https://schema.org',
        '@type'      => 'WebPage',
        '@id'        => $firm['url'] . '/#webpage',
        'name'       => $firm['name'] . ' — Personal Injury Lawyers in Georgia & South Carolina',
        'isPartOf'   => array( '@id' => $firm['url'] . '/#website' ),
        'about'      => array( '@id' => $firm['url'] . '/#organization' ),
        'breadcrumb' => array( '@id' => $firm['url'] . '/#breadcrumbs' ),
        'speakable'  => array(
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => array( '.hero h1', '.hero p', '.trust-bar' ),
        ),
    ) );
}

function roden_schema_speakable_practice_area() {
    $firm = roden_firm_data();
    $url  = roden_get_canonical_url();
    // url omitted — @id encodes the URL, and a sibling LegalService entity on
    // the same page already declares the canonical url, causing a duplicate
    // warning when Google merges entities for the rich result.
    roden_json_ld( array(
        '@context'     => 'https://schema.org',
        '@type'        => 'WebPage',
        '@id'          => $url . '#webpage',
        'name'         => get_the_title(),
        'dateModified' => get_the_modified_date( 'c' ),
        'isPartOf'     => array( '@id' => $firm['url'] . '/#website' ),
        'about'        => array( '@id' => $firm['url'] . '/#organization' ),
        'breadcrumb'   => array( '@id' => $url . '#breadcrumbs' ),
        'speakable'    => array(
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => array(
                '.hero h1',
                '.hero p',
                '.ai-definition-block',
                '.what-to-do-steps',
                '.expert-quote-block',
                '.jurisdiction-comparison',
                '.ai-stats-block',
            ),
        ),
    ) );
}

function roden_schema_speakable_location() {
    $firm = roden_firm_data();
    $url  = get_permalink();
    // url omitted — see roden_schema_speakable_practice_area note above.
    roden_json_ld( array(
        '@context'     => 'https://schema.org',
        '@type'        => 'WebPage',
        '@id'          => $url . '#webpage',
        'name'         => get_the_title(),
        'dateModified' => get_the_modified_date( 'c' ),
        'isPartOf'     => array( '@id' => $firm['url'] . '/#website' ),
        'about'        => array( '@id' => $firm['url'] . '/#organization' ),
        'breadcrumb'   => array( '@id' => $url . '#breadcrumbs' ),
        'speakable'    => array(
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => array( '.hero h1', '.hero-subtitle', '.why-choose-grid', '.jurisdiction-cards' ),
        ),
    ) );
}

/* ==========================================================================
   9. AggregateRating — emitted inline on the homepage LegalService entity
   by roden_schema_legal_service(). Per-office ratings ride on each
   LocalBusiness in roden_schema_local_business_office when the per-office
   GBP review_count is populated. No standalone AggregateRating function.
   ========================================================================== */

/* ==========================================================================
   10. WebSite with Sitelinks Searchbox (Homepage)
   ========================================================================== */

function roden_schema_website( $firm ) {
    roden_json_ld( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'WebSite',
        '@id'             => $firm['url'] . '/#website',
        'name'            => $firm['name'],
        'url'             => $firm['url'],
        'inLanguage'      => 'en-US',
        'publisher'       => array( '@id' => $firm['url'] . '/#organization' ),
        'potentialAction' => array(
            '@type'       => 'SearchAction',
            'target'      => array(
                '@type'       => 'EntryPoint',
                'urlTemplate' => $firm['url'] . '/?s={search_term_string}',
            ),
            'query-input' => 'required name=search_term_string',
        ),
    ) );
}

/* ==========================================================================
   11. BlogPosting (Blog posts)
   ========================================================================== */

function roden_schema_article( $firm ) {
    $post_id = get_the_ID();
    $content = get_post_field( 'post_content', $post_id );
    $excerpt = get_the_excerpt( $post_id );

    $schema = array(
        '@context'      => 'https://schema.org',
        '@type'         => 'BlogPosting',
        '@id'           => get_permalink( $post_id ) . '#blogposting',
        'headline'      => get_the_title( $post_id ),
        'description'   => html_entity_decode( wp_strip_all_tags( $excerpt ?: wp_trim_words( $content, 30 ) ), ENT_QUOTES, 'UTF-8' ),
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

    // Featured image — use wp_get_attachment_image_src to get dimensions that
    // match the 'large' size URL (wp_get_attachment_metadata returns full-size dims).
    if ( has_post_thumbnail( $post_id ) ) {
        $img_id  = get_post_thumbnail_id( $post_id );
        $img_src = wp_get_attachment_image_src( $img_id, 'large' );
        if ( $img_src ) {
            $schema['image'] = array(
                '@type'  => 'ImageObject',
                'url'    => $img_src[0],
                'width'  => $img_src[1],
                'height' => $img_src[2],
            );
        }
    }

    // Author — linked attorney if set, WP author, or fall back to firm
    $author_id = get_post_meta( $post_id, '_roden_author_attorney', true );
    $atty      = $author_id ? get_post( $author_id ) : null;

    if ( $atty && 'publish' === $atty->post_status ) {
        $atty_canonical_url = str_replace( home_url(), $firm['url'], get_permalink( $atty ) );
        $schema['author'] = array(
            '@type' => 'Person',
            '@id'   => $firm['url'] . '/attorneys/' . $atty->post_name . '/#person',
            'name'  => $atty->post_title,
            'url'   => $atty_canonical_url,
        );
    } else {
        $wp_author = get_the_author();
        if ( $wp_author ) {
            $schema['author'] = array(
                '@type' => 'Person',
                'name'  => $wp_author,
            );
        } else {
            // Fall back to the firm as author when no individual is set
            $schema['author'] = array(
                '@type' => 'Organization',
                '@id'   => $firm['url'] . '/#organization',
                'name'  => $firm['name'],
            );
        }
    }

    // Publisher logo
    $logo_url = roden_get_logo_url();
    if ( $logo_url ) {
        $schema['publisher']['logo'] = array(
            '@type' => 'ImageObject',
            'url'   => $logo_url,
        );
    }

    // Article section from primary category
    $categories = get_the_category( $post_id );
    if ( ! empty( $categories ) ) {
        $schema['articleSection'] = $categories[0]->name;
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   12. Article — Sub-type practice area pages
   ========================================================================== */

/**
 * Output Article schema for sub-type practice area pages.
 *
 * @param array $firm Firm data from roden_firm_data().
 */
function roden_schema_article_subtype( $firm ) {
    $post_id = get_the_ID();
    $post    = get_post( $post_id );
    $content = get_post_field( 'post_content', $post_id );
    $excerpt = get_the_excerpt( $post_id );

    $canonical_url = roden_get_canonical_url( $post_id );
    $schema = array(
        '@context'      => 'https://schema.org',
        '@type'         => 'Article',
        'headline'      => get_the_title( $post_id ),
        'description'   => html_entity_decode( wp_strip_all_tags( $excerpt ?: wp_trim_words( $content, 30 ) ), ENT_QUOTES, 'UTF-8' ),
        'url'           => $canonical_url,
        'datePublished' => get_the_date( 'c', $post_id ),
        'dateModified'  => get_the_modified_date( 'c', $post_id ),
        'wordCount'     => str_word_count( wp_strip_all_tags( $content ) ),
        'mainEntityOfPage' => array(
            '@type' => 'WebPage',
            '@id'   => $canonical_url,
        ),
        'publisher' => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        ),
    );

    // Featured image.
    if ( has_post_thumbnail( $post_id ) ) {
        $img_url  = get_the_post_thumbnail_url( $post_id, 'large' );
        $img_id   = get_post_thumbnail_id( $post_id );
        $img_meta = wp_get_attachment_metadata( $img_id );
        $schema['image'] = array(
            '@type'  => 'ImageObject',
            'url'    => $img_url,
            'width'  => $img_meta['width'] ?? 0,
            'height' => $img_meta['height'] ?? 0,
        );
    }

    // Author — linked attorney from _roden_author_attorney meta.
    $author_id = get_post_meta( $post_id, '_roden_author_attorney', true );
    $atty      = $author_id ? get_post( $author_id ) : null;

    if ( $atty && 'publish' === $atty->post_status ) {
        $schema['author'] = array(
            '@type' => 'Person',
            '@id'   => $firm['url'] . '/attorneys/' . $atty->post_name . '/#person',
            'name'  => $atty->post_title,
            'url'   => str_replace( home_url(), $firm['url'], get_permalink( $atty ) ),
        );
    } else {
        $schema['author'] = array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        );
    }

    // Publisher logo.
    $logo_url = roden_get_logo_url();
    if ( $logo_url ) {
        $schema['publisher']['logo'] = array(
            '@type' => 'ImageObject',
            'url'   => $logo_url,
        );
    }

    // About — link to parent pillar page.
    $parent = get_post( $post->post_parent );
    if ( $parent && 'publish' === $parent->post_status ) {
        $schema['about'] = array(
            '@type' => 'Thing',
            'name'  => $parent->post_title,
            'url'   => get_permalink( $parent ),
        );
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   8a. AboutPage (About page) — entity definition for AI systems
   ========================================================================== */

function roden_schema_about_page( $firm ) {
    $url = roden_get_canonical_url();

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'AboutPage',
        '@id'         => rtrim( $url, '/' ) . '/#aboutpage',
        'url'         => $url,
        'name'        => 'About Roden Law',
        'description' => $firm['description'],
        // mainEntity links this page's content to the canonical firm entity
        // defined on the homepage. AI systems use this to route "what is
        // Roden Law" queries to the entity, not just this page.
        'mainEntity'  => array(
            '@id' => $firm['url'] . '/#organization',
        ),
    );

    roden_json_ld( $schema );
}

/* ==========================================================================
   8. ContactPage (Contact page)
   ========================================================================== */

function roden_schema_contact_page( $firm ) {
    // Mirror the AboutPage pattern: emit a ContactPage entity scoped to this
    // URL and link to the canonical #organization (defined on the homepage)
    // via mainEntity. ContactPoints live on #organization itself — do not
    // redefine the organization here, which would create a conflicting
    // @id with different properties on each page.
    $url = roden_get_canonical_url();

    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => 'ContactPage',
        '@id'        => rtrim( $url, '/' ) . '/#contactpage',
        'url'        => $url,
        'name'       => 'Contact Roden Law',
        'description' => 'Contact Roden Law personal injury attorneys for a free consultation. Offices in Savannah, Darien, Charleston, North Charleston, Columbia, and Myrtle Beach.',
        'mainEntity' => array(
            '@id' => $firm['url'] . '/#organization',
        ),
    );

    roden_json_ld( $schema );
}

/**
 * Build the deduplicated ContactPoint[] array used by the canonical
 * Organization entity. Offices that share a phone line (e.g. Savannah +
 * Darien on the GA intake number) collapse into one ContactPoint with a
 * combined areaServed list.
 *
 * @param array $firm Firm data from roden_firm_data().
 * @return array ContactPoint schema fragments.
 */
function roden_build_contact_points( $firm ) {
    $by_phone = array();
    foreach ( $firm['offices'] as $office ) {
        $phone = $office['phone'];
        if ( ! isset( $by_phone[ $phone ] ) ) {
            $by_phone[ $phone ] = array();
        }
        $by_phone[ $phone ][] = $office['state_full'];
    }

    $contact_points = array();
    foreach ( $by_phone as $phone => $states ) {
        $states_unique = array_values( array_unique( $states ) );
        $contact_points[] = array(
            '@type'             => 'ContactPoint',
            'telephone'         => $phone,
            'contactType'       => 'customer service',
            'areaServed'        => count( $states_unique ) === 1 ? $states_unique[0] : $states_unique,
            'availableLanguage' => array( 'English', 'Spanish' ),
        );
    }
    return $contact_points;
}

/* ==========================================================================
   13. Neighborhood LegalService (Neighborhood pages)
   ========================================================================== */

/**
 * Output a rich LegalService schema for neighborhood pages.
 *
 * Includes @id, serviceType, knowsAbout (22 PAs + court), areaServed
 * (multiple communities), makesOffer, openingHours, hasMap, and image.
 *
 * @param array $firm Firm data from roden_firm_data().
 */
function roden_schema_neighborhood_legal_service( $firm ) {
    $post_id           = get_the_ID();
    $neighborhood_name = get_the_title();
    $parent_office_key = get_post_meta( $post_id, '_roden_parent_office_key', true );

    if ( ! $parent_office_key ) {
        $parent_id = wp_get_post_parent_id( $post_id );
        if ( $parent_id ) {
            $parent_office_key = get_post_meta( $parent_id, '_roden_office_key', true );
        }
    }

    if ( ! $parent_office_key || ! isset( $firm['offices'][ $parent_office_key ] ) ) {
        return;
    }

    $office = $firm['offices'][ $parent_office_key ];

    // Directions URL
    $directions_url = 'https://www.google.com/maps/dir/'
        . urlencode( $neighborhood_name . ', ' . $office['state'] ) . '/'
        . urlencode( $office['street'] . ', ' . $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] ) . '/';

    // Geo — use neighborhood-specific coords if set, otherwise parent office
    $nb_lat = get_post_meta( $post_id, '_roden_neighborhood_latitude', true );
    $nb_lng = get_post_meta( $post_id, '_roden_neighborhood_longitude', true );
    $geo = array(
        '@type'     => 'GeoCoordinates',
        'latitude'  => ( $nb_lat && $nb_lng ) ? (float) $nb_lat : $office['latitude'],
        'longitude' => ( $nb_lat && $nb_lng ) ? (float) $nb_lng : $office['longitude'],
    );

    // Determine area type — sub-neighborhood or city-level neighborhood
    $parent_id          = wp_get_post_parent_id( $post_id );
    $parent_is_neighborhood = $parent_id ? get_post_meta( $parent_id, '_roden_is_neighborhood', true ) : false;

    if ( $parent_is_neighborhood ) {
        $area_type = 'Neighborhood';
        $contained_in = array(
            '@type' => 'City',
            'name'  => get_the_title( $parent_id ),
            'containedInPlace' => array(
                '@type' => 'State',
                'name'  => $office['state_full'],
            ),
        );
    } else {
        $area_type = 'City';
        $contained_in = array(
            '@type' => 'State',
            'name'  => $office['state_full'],
        );
    }

    // Build areaServed — primary neighborhood + parsed communities from service_area
    $area_served = array(
        array(
            '@type'            => $area_type,
            'name'             => $neighborhood_name,
            'containedInPlace' => $contained_in,
        ),
    );

    $service_area_text = get_post_meta( $post_id, '_roden_neighborhood_service_area', true );
    if ( $service_area_text ) {
        $communities = array_filter( array_map( 'trim', preg_split( '/[,\n]+/', $service_area_text ) ) );
        foreach ( $communities as $community ) {
            if ( strcasecmp( $community, $neighborhood_name ) === 0 ) {
                continue;
            }
            // Reject prose fragments: too long for a place name, or starts with
            // a conjunction/article (e.g. "and surrounding communities along…").
            if ( mb_strlen( $community ) > 60 ) {
                continue;
            }
            if ( preg_match( '/^(and|or|the|including|serving|plus)\b/i', $community ) ) {
                continue;
            }
            $area_served[] = array(
                '@type' => 'Place',
                'name'  => $community,
            );
        }
    }

    // knowsAbout — 22 practice areas + court if set
    $knows_about = array(
        'Car Accidents', 'Truck Accidents', 'Slip and Fall',
        'Motorcycle Accidents', 'Medical Malpractice', 'Wrongful Death',
        'Workers Compensation', 'Dog Bites', 'Brain Injuries',
        'Spinal Cord Injuries', 'Maritime Injuries', 'Product Liability',
        'Boating Accidents', 'Burn Injuries', 'Construction Accidents',
        'Nursing Home Abuse', 'Premises Liability', 'Pedestrian Accidents',
        'Bicycle Accidents', 'Electric Scooter Accidents',
        'ATV & Side-by-Side Accidents', 'Golf Cart Accidents',
    );

    $court = get_post_meta( $post_id, '_roden_neighborhood_court', true );
    if ( $court ) {
        $knows_about[] = $court;
    }

    // makesOffer — top 6 practice area services
    $top_slugs = array(
        'car-accident-lawyers'        => 'Car Accident Lawyer',
        'truck-accident-lawyers'      => 'Truck Accident Lawyer',
        'motorcycle-accident-lawyers' => 'Motorcycle Accident Lawyer',
        'slip-and-fall-lawyers'       => 'Slip and Fall Lawyer',
        'wrongful-death-lawyers'      => 'Wrongful Death Lawyer',
        'medical-malpractice-lawyers' => 'Medical Malpractice Lawyer',
    );
    $offers = array();
    foreach ( $top_slugs as $slug => $label ) {
        $offers[] = array(
            '@type'       => 'Offer',
            'itemOffered' => array(
                '@type' => 'LegalService',
                'name'  => $label . ' in ' . $neighborhood_name,
                'url'   => home_url( '/' . $slug . '/' . $office['slug'] . '/' ),
            ),
        );
    }

    // Neighborhood-distinct name so the entity reads as a service *for that
    // neighborhood* rather than a duplicate of the parent office's listing.
    // Avoids the previous "Roden Law — Savannah" appearing identically on
    // every neighborhood under Savannah.
    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'LegalService',
        '@id'         => get_permalink() . '#legalservice',
        'name'        => $office['name'] . ' — Serving ' . $neighborhood_name,
        'description' => 'Personal injury lawyers serving ' . $neighborhood_name . ', ' . $office['state'] . '. Free consultation. No fees unless we win.',
        'url'         => get_permalink(),
        'telephone'   => $office['phone'],
        'priceRange'  => '$$',
        'serviceType' => 'Personal Injury Law',
        'address'     => roden_schema_postal_address( $office ),
        'geo'         => $geo,
        'areaServed'  => $area_served,
        'knowsAbout'  => $knows_about,
        'makesOffer'  => $offers,
        'hasMap'      => $directions_url,
        'openingHoursSpecification' => array(
            array(
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
                'opens'     => '08:00',
                'closes'    => '18:00',
            ),
        ),
        'openingHours' => 'Mo-Fr 08:00-18:00',
        'parentOrganization' => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
            'url'   => $firm['url'],
        ),
    );

    $logo_url = roden_get_logo_url();
    if ( $logo_url ) {
        $schema['image'] = $logo_url;
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   14. LocalBusiness for parent office on Neighborhood pages
   ========================================================================== */

/**
 * Output LocalBusiness schema for the parent office on neighborhood pages.
 *
 * Reads _roden_parent_office_key and outputs the parent office's LocalBusiness
 * with the canonical @id, plus the neighborhood name in areaServed.
 *
 * @param array $firm Firm data from roden_firm_data().
 */
function roden_schema_local_business_neighborhood( $firm ) {
    $post_id           = get_the_ID();
    $parent_office_key = get_post_meta( $post_id, '_roden_parent_office_key', true );

    if ( ! $parent_office_key ) {
        $parent_id = wp_get_post_parent_id( $post_id );
        if ( $parent_id ) {
            $parent_office_key = get_post_meta( $parent_id, '_roden_office_key', true );
        }
    }

    if ( ! $parent_office_key || ! isset( $firm['offices'][ $parent_office_key ] ) ) {
        return;
    }

    $office            = $firm['offices'][ $parent_office_key ];
    $neighborhood_name = get_the_title();
    $parent_id         = wp_get_post_parent_id( $post_id );
    $parent_is_neighborhood = $parent_id ? get_post_meta( $parent_id, '_roden_is_neighborhood', true ) : false;

    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => array( 'LocalBusiness', 'LegalService', 'LawFirm' ),
        '@id'        => $firm['url'] . '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['market_name'] ) . '/#localbusiness',
        'name'       => $office['name'],
        'url'        => $firm['url'] . '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['market_name'] ) . '/',
        'telephone'  => $office['phone'],
        'priceRange' => '$$',
        'address'    => roden_schema_postal_address( $office ),
        'geo'        => roden_schema_geo( $office ),
        'areaServed' => array(
            array(
                '@type' => $parent_is_neighborhood ? 'Neighborhood' : 'City',
                'name'  => $neighborhood_name . ', ' . $office['state'],
            ),
            array(
                '@type' => 'City',
                'name'  => $office['market_name'] . ', ' . $office['state'],
            ),
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
        'hasMap'             => $office['map_url'],
        'parentOrganization' => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        ),
    );

    // Per-location sameAs — Google Business Profile, Yelp, etc. These are
    // location-scoped entities (one listing per office), so they belong on
    // the LocalBusiness, not the firm-level Organization. Filter empties.
    $office_same_as = array_filter( array(
        $office['gbp_url']  ?? '',
        $office['yelp_url'] ?? '',
    ) );
    if ( ! empty( $office_same_as ) ) {
        $schema['sameAs'] = array_values( $office_same_as );
    }

    $logo_url = roden_get_logo_url();
    if ( $logo_url ) {
        $schema['image'] = $logo_url;
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   15. State Landing Page schema (F-NEW-4)
   ========================================================================== */

/**
 * Detect if the current request is a state landing page.
 *
 * State landings are `location` posts at /locations/georgia/ and
 * /locations/south-carolina/ — the parent locations under which the
 * city offices and neighborhoods nest. They have no _roden_office_key
 * and are not _roden_is_neighborhood.
 *
 * @return string|false State slug ('georgia' | 'south-carolina') or false.
 */
function roden_is_state_landing() {
    if ( ! is_singular( 'location' ) ) {
        return false;
    }
    $post = get_post();
    if ( ! $post ) {
        return false;
    }
    if ( get_post_meta( $post->ID, '_roden_is_neighborhood', true ) ) {
        return false;
    }
    if ( get_post_meta( $post->ID, '_roden_office_key', true ) ) {
        return false;
    }
    if ( in_array( $post->post_name, array( 'georgia', 'south-carolina' ), true ) ) {
        return $post->post_name;
    }
    return false;
}

/**
 * Output state-landing schema: state-scoped LegalService (with firm
 * AggregateRating + state areaServed + serviceLocation refs) and a
 * state-scoped Organization with department[] linking to the in-state
 * office LocalBusiness entities.
 *
 * Closes the F-NEW-4 audit finding: state landings previously emitted
 * only WebPage/BreadcrumbList/FAQPage and were schema-thin compared to
 * the office pages they sit above. Also closes the F-NEW-3 gap on state
 * landings (no LegalService entity to attach the firm rating to).
 *
 * @param array $firm Firm data from roden_firm_data().
 */
function roden_schema_state_landing( $firm ) {
    $state_slug = roden_is_state_landing();
    if ( ! $state_slug ) {
        return;
    }

    $state_full = ( 'georgia' === $state_slug ) ? 'Georgia' : 'South Carolina';
    $state_abbr = ( 'georgia' === $state_slug ) ? 'GA' : 'SC';

    $page_url = roden_get_canonical_url();
    $page_url = trailingslashit( $page_url );

    // Build serviceLocation list (full ref) and department[] (lightweight @id ref)
    // for every office whose state matches this landing page.
    $service_locations = array();
    $department_refs   = array();
    foreach ( $firm['offices'] as $office ) {
        if ( $office['state'] !== $state_abbr ) {
            continue;
        }
        $office_lb_id = $firm['url'] . '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['market_name'] ) . '/#localbusiness';
        $service_locations[] = array(
            '@type'     => array( 'LegalService', 'LocalBusiness' ),
            '@id'       => $office_lb_id,
            'name'      => $office['name'],
            'address'   => roden_schema_postal_address( $office ),
            'telephone' => $office['phone'],
            'geo'       => roden_schema_geo( $office ),
        );
        $department_refs[] = array(
            '@type' => 'LocalBusiness',
            '@id'   => $office_lb_id,
            'name'  => $office['name'],
        );
    }

    // --- LegalService (state-scoped) ---
    roden_json_ld( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'LegalService',
        '@id'             => $page_url . '#legalservice',
        'name'            => 'Personal Injury Lawyers in ' . $state_full . ' — ' . $firm['name'],
        'url'             => $page_url,
        'description'     => 'Roden Law represents personal injury victims throughout ' . $state_full . '. Free consultation, no fees unless we win.',
        'telephone'       => $firm['phone_e164'],
        'priceRange'      => '$$',
        'serviceType'     => 'Personal Injury Law',
        'dateModified'    => get_the_modified_date( 'c' ),
        'areaServed'      => array(
            '@type' => 'State',
            'name'  => $state_full,
        ),
        'serviceLocation' => $service_locations,
        'isPartOf'        => array( '@id' => $firm['url'] . '/#legalservice' ),
    ) );

    // --- Organization (state-scoped) with department[] ---
    roden_json_ld( array(
        '@context'           => 'https://schema.org',
        '@type'              => array( 'Organization', 'LawFirm' ),
        '@id'                => $page_url . '#organization',
        'name'               => $firm['name'] . ' — ' . $state_full,
        'url'                => $page_url,
        'parentOrganization' => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        ),
        'areaServed'         => array(
            '@type' => 'State',
            'name'  => $state_full,
        ),
        'department'         => $department_refs,
    ) );
}

/* ==========================================================================
   SHARED SCHEMA FRAGMENTS
   ========================================================================== */

/**
 * Build a PostalAddress schema fragment from office data.
 *
 * @param array $office Office data from roden_firm_data().
 * @return array Schema PostalAddress.
 */
function roden_schema_postal_address( $office ) {
    return array(
        '@type'           => 'PostalAddress',
        'streetAddress'   => $office['street'],
        'addressLocality' => $office['city'],
        'addressRegion'   => $office['state'],
        'postalCode'      => $office['zip'],
        'addressCountry'  => 'US',
    );
}

/**
 * Build a GeoCoordinates schema fragment from office data.
 *
 * @param array $office Office data from roden_firm_data().
 * @return array Schema GeoCoordinates.
 */
function roden_schema_geo( $office ) {
    return array(
        '@type'     => 'GeoCoordinates',
        'latitude'  => $office['latitude'],
        'longitude' => $office['longitude'],
    );
}

/**
 * Build the areaServed list for an office LocalBusiness entity.
 *
 * Sources from $office['market_name'] (primary city) plus $office['nearby_communities']
 * (the list already curated in firm-data.php). Each entry is a Place with
 * containedInPlace pointing at the office's state.
 *
 * @param array $office Office data from roden_firm_data().
 * @return array Array of Place schema fragments.
 */
function roden_schema_office_area_served( $office ) {
    $state_full = $office['state_full'] ?? $office['state'];
    $state_part = array(
        '@type' => 'State',
        'name'  => $state_full,
    );

    $places = array(
        array(
            '@type'            => 'City',
            'name'             => $office['market_name'] . ', ' . $office['state'],
            'containedInPlace' => $state_part,
        ),
    );

    $nearby = isset( $office['nearby_communities'] ) && is_array( $office['nearby_communities'] )
        ? $office['nearby_communities']
        : array();
    foreach ( $nearby as $community ) {
        $community = trim( $community );
        if ( '' === $community ) {
            continue;
        }
        if ( strcasecmp( $community, $office['market_name'] ) === 0 ) {
            continue;
        }
        $places[] = array(
            '@type'            => 'Place',
            'name'             => $community . ', ' . $office['state'],
            'containedInPlace' => $state_part,
        );
    }

    return $places;
}

/* ==========================================================================
   Person schema for Attorneys archive page
   ========================================================================== */

/**
 * Output Person schema for each attorney on the archive page.
 *
 * @param array $firm Firm data from roden_firm_data().
 */
function roden_schema_attorneys_list( $firm ) {
    $attorneys = new WP_Query( array(
        'post_type'      => 'attorney',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'meta_query'     => array(
            array(
                'key'     => '_roden_atty_role',
                'value'   => 'attorney',
                'compare' => '=',
            ),
        ),
    ) );

    if ( ! $attorneys->have_posts() ) {
        // Fallback: query all attorneys without role filter
        $attorneys = new WP_Query( array(
            'post_type'      => 'attorney',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ) );
    }

    if ( ! $attorneys->have_posts() ) {
        return;
    }

    $persons = array();
    while ( $attorneys->have_posts() ) {
        $attorneys->the_post();
        $post_id = get_the_ID();

        $atty_post_name = get_post_field( 'post_name', $post_id );
        $person = array(
            '@type' => 'Person',
            '@id'   => $firm['url'] . '/attorneys/' . $atty_post_name . '/#person',
            'name'  => get_the_title(),
            'url'   => str_replace( home_url(), $firm['url'], get_permalink() ),
        );

        $job_title = get_post_meta( $post_id, '_roden_atty_title', true );
        if ( $job_title ) {
            $person['jobTitle'] = $job_title;
        }

        if ( has_post_thumbnail() ) {
            $person['image'] = get_the_post_thumbnail_url( $post_id, 'attorney-headshot' );
        }

        $office_key = get_post_meta( $post_id, '_roden_atty_office_key', true );
        if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
            $office = $firm['offices'][ $office_key ];
            $person['workLocation'] = array(
                '@type'   => 'Place',
                'name'    => $office['name'],
                'address' => roden_schema_postal_address( $office ),
            );
        }

        $person['worksFor'] = array(
            '@type' => 'LegalService',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        );

        $persons[] = $person;
    }
    wp_reset_postdata();

    roden_json_ld( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'ItemList',
        'name'            => 'Attorneys at ' . $firm['name'],
        'numberOfItems'   => count( $persons ),
        'itemListElement' => array_map( function( $person, $i ) {
            return array(
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'item'     => $person,
            );
        }, $persons, array_keys( $persons ) ),
    ) );
}

/* ==========================================================================
   14. SC Statewide PPC Landing Page Schema
       LegalService + FAQPage + LocalBusiness (3 SC offices)
   ========================================================================== */

function roden_schema_sc_statewide( $firm ) {
    $page_url    = $firm['url'] . '/south-carolina-car-accident-lawyer/';
    $sc_keys     = array( 'charleston', 'columbia', 'myrtle-beach' );

    // --- LegalService ---
    $service_locations = array();
    foreach ( $sc_keys as $key ) {
        if ( ! isset( $firm['offices'][ $key ] ) ) {
            continue;
        }
        $office              = $firm['offices'][ $key ];
        $service_locations[] = array(
            '@type'     => array( 'LegalService', 'LocalBusiness' ),
            '@id'       => $firm['url'] . '/locations/south-carolina/' . $key . '/#localbusiness',
            'name'      => $office['name'],
            'address'   => roden_schema_postal_address( $office ),
            'telephone' => $office['phone'],
            'geo'       => roden_schema_geo( $office ),
        );
    }

    roden_json_ld( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'LegalService',
        '@id'             => $page_url . '#legalservice',
        'name'            => 'South Carolina Car Accident Lawyers — Roden Law',
        'url'             => $page_url,
        'description'     => 'Roden Law represents car accident victims throughout South Carolina. With offices in Charleston, Columbia, and Myrtle Beach, our attorneys fight for maximum compensation on a contingency fee — no fees unless we win.',
        'telephone'       => $firm['vanity_phone'],
        'priceRange'      => '$$',
        'areaServed'      => array(
            '@type' => 'State',
            'name'  => 'South Carolina',
        ),
        'serviceType'     => 'Car Accident Law',
        'knowsAbout'      => array(
            'Car Accidents', 'Truck Accidents', 'Motorcycle Accidents',
            'Pedestrian Accidents', 'Bicycle Accidents', 'Wrongful Death',
            'Uninsured Motorist Claims', 'South Carolina Auto Insurance Law',
        ),
        'serviceLocation' => $service_locations,
        'hasOfferCatalog' => array(
            '@type'           => 'OfferCatalog',
            'name'            => 'Car Accident Legal Services',
            'itemListElement' => array(
                array(
                    '@type'           => 'Offer',
                    'itemOffered'     => array(
                        '@type' => 'Service',
                        'name'  => 'Free Car Accident Case Review',
                    ),
                    'price'           => '0',
                    'priceCurrency'   => 'USD',
                ),
            ),
        ),
    ) );

    // --- FAQPage (SC-specific) ---
    roden_json_ld( array(
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array(
            array(
                '@type'          => 'Question',
                'name'           => 'How long do I have to file a car accident lawsuit in South Carolina?',
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => 'In South Carolina, you have 3 years from the date of your car accident to file a personal injury lawsuit under S.C. Code § 15-3-530. Missing this deadline generally bars you from recovering any compensation, so it is critical to consult an attorney as soon as possible.',
                ),
            ),
            array(
                '@type'          => 'Question',
                'name'           => 'Can I recover compensation if I was partly at fault for the accident in South Carolina?',
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => 'Yes. South Carolina follows a modified comparative fault rule. You can recover damages as long as you are less than 51% at fault for the accident. However, your compensation will be reduced by your percentage of fault. If you are found 51% or more at fault, you cannot recover anything.',
                ),
            ),
            array(
                '@type'          => 'Question',
                'name'           => 'What compensation can I recover after a car accident in South Carolina?',
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => 'South Carolina car accident victims may recover economic damages (medical bills, lost wages, future medical care, property damage) and non-economic damages (pain and suffering, emotional distress, loss of enjoyment of life). In cases involving gross negligence, punitive damages may also be available.',
                ),
            ),
            array(
                '@type'          => 'Question',
                'name'           => 'What are the minimum auto insurance requirements in South Carolina?',
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => 'South Carolina law requires drivers to carry minimum liability coverage of $25,000 per person and $50,000 per accident for bodily injury, plus $25,000 for property damage. South Carolina also requires uninsured motorist coverage at the same minimums unless you sign a waiver. These minimums are often insufficient to cover serious injuries.',
                ),
            ),
            array(
                '@type'          => 'Question',
                'name'           => 'Do I need a lawyer for a car accident claim in South Carolina?',
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => 'While you are not legally required to hire a lawyer, studies consistently show that accident victims represented by an attorney recover significantly more — even after legal fees — than those who negotiate alone. Roden Law handles all car accident cases on contingency: no fees unless we win. Call (843) 790-8999 or (843) 612-1980 for a free case review.',
                ),
            ),
            array(
                '@type'          => 'Question',
                'name'           => 'How much does a car accident lawyer cost in South Carolina?',
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => 'Roden Law handles car accident cases on a contingency fee basis — you pay nothing unless we win your case. There are no upfront costs and no hourly fees. Our fee is a percentage of the settlement or verdict we recover for you.',
                ),
            ),
        ),
    ) );

    // --- LocalBusiness for each SC office ---
    foreach ( $sc_keys as $key ) {
        if ( ! isset( $firm['offices'][ $key ] ) ) {
            continue;
        }
        $office = $firm['offices'][ $key ];
        roden_schema_local_business_office( $firm, $key, $office );
    }
}

/* ==========================================================================
   CASE RESULT — Singular page schema
   ========================================================================== */

function roden_schema_case_result( $firm ) {
    $post_id     = get_the_ID();
    $amount      = get_post_meta( $post_id, '_roden_case_amount', true );
    $result_type = get_post_meta( $post_id, '_roden_case_type', true );
    $accident    = get_post_meta( $post_id, '_roden_accident_type', true );
    $description = get_post_meta( $post_id, '_roden_description', true );
    $attorney_id = get_post_meta( $post_id, '_roden_attorney', true );

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'CreativeWork',
        'name'        => get_the_title( $post_id ),
        'description' => $description ?: wp_trim_words( get_the_excerpt( $post_id ), 30 ),
        'url'         => get_permalink( $post_id ),
        'publisher'   => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        ),
    );

    if ( $amount ) {
        // Parse numeric value from formatted amount (e.g., "$3,000,000" → 3000000).
        $numeric = preg_replace( '/[^0-9.]/', '', $amount );
        if ( $numeric ) {
            $schema['about'] = array(
                '@type'    => 'MonetaryAmount',
                'currency' => 'USD',
                'value'    => $numeric,
                'name'     => $amount . ( $result_type ? ' ' . ucfirst( $result_type ) : '' ),
            );
        }
    }

    if ( $accident ) {
        $schema['keywords'] = $accident;
    }

    if ( $attorney_id ) {
        $atty = get_post( $attorney_id );
        if ( $atty && 'publish' === $atty->post_status ) {
            $schema['author'] = array(
                '@type' => 'Person',
                '@id'   => $firm['url'] . '/attorneys/' . $atty->post_name . '/#person',
                'name'  => $atty->post_title,
            );
        }
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   TESTIMONIAL — Singular page schema (Review)
   ========================================================================== */

function roden_schema_testimonial( $firm ) {
    $post_id = get_the_ID();
    $content = wp_strip_all_tags( get_the_content( null, false, $post_id ) );

    $schema = array(
        '@context'     => 'https://schema.org',
        '@type'        => 'Review',
        'itemReviewed' => array(
            '@type' => 'LegalService',
            '@id'   => $firm['url'] . '/#legalservice',
            'name'  => $firm['name'],
        ),
        'reviewBody'   => $content,
        'name'         => get_the_title( $post_id ),
        'url'          => get_permalink( $post_id ),
        'author'       => array(
            '@type' => 'Person',
            'name'  => get_the_title( $post_id ),
        ),
        'reviewRating' => array(
            '@type'       => 'Rating',
            'ratingValue' => '5',
            'bestRating'  => '5',
        ),
        'publisher'    => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        ),
    );

    roden_json_ld( $schema );
}

/* ==========================================================================
   TAXONOMY ARCHIVE — CollectionPage schema
   ========================================================================== */

/* ==========================================================================
   16. CollectionPage / Blog (CPT archive + blog index)
   ========================================================================== */

/**
 * Emit a CollectionPage (or Blog) entity for archive pages that otherwise
 * have no page-level schema. The recent posts are referenced via hasPart
 * for entity-graph completeness (each link points at the post's existing
 * BlogPosting / Article @id rather than redefining it).
 *
 * @param array  $firm      Firm data from roden_firm_data().
 * @param string $type      Schema.org type ('CollectionPage' or 'Blog').
 * @param string $post_type WP post type the archive iterates ('resource' / 'post').
 */
function roden_schema_collection_page( $firm, $type, $post_type ) {
    if ( 'post' === $post_type ) {
        $url  = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' );
        $name = single_post_title( '', false ) ?: __( 'Blog', 'roden-law' );
        $desc = get_bloginfo( 'description' );
    } else {
        $obj  = get_queried_object();
        $url  = get_post_type_archive_link( $post_type );
        $name = isset( $obj->labels->name ) ? $obj->labels->name : post_type_archive_title( '', false );
        $desc = isset( $obj->description ) ? $obj->description : '';
    }

    if ( ! $url ) {
        return;
    }

    $base_id = rtrim( $url, '/' ) . '/';

    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => $type,
        '@id'        => $base_id . '#' . strtolower( $type ),
        'url'        => $url,
        'name'       => $name,
        'isPartOf'   => array( '@id' => $firm['url'] . '/#website' ),
        'about'      => array( '@id' => $firm['url'] . '/#organization' ),
        'breadcrumb' => array( '@id' => $base_id . '#breadcrumbs' ),
    );

    if ( $desc ) {
        $schema['description'] = wp_strip_all_tags( $desc );
    }

    // Recent posts as an ItemList. Using ListItem entries instead of a
    // hasPart array of BlogPosting stubs avoids the validator treating
    // each archive entry as a standalone BlogPosting and flagging it for
    // missing image/author — the actual post pages already carry full
    // BlogPosting / HowTo schema. ItemList is the canonical pattern for
    // a CollectionPage / Blog index.
    $recent = get_posts( array(
        'post_type'      => $post_type,
        'posts_per_page' => 10,
        'post_status'    => 'publish',
        'no_found_rows'  => true,
    ) );
    if ( $recent ) {
        $list_items = array();
        $position   = 1;
        foreach ( $recent as $p ) {
            $list_items[] = array(
                '@type'    => 'ListItem',
                'position' => $position++,
                'url'      => get_permalink( $p ),
                'name'     => $p->post_title,
            );
        }
        $schema['mainEntity'] = array(
            '@type'           => 'ItemList',
            'numberOfItems'   => count( $list_items ),
            'itemListElement' => $list_items,
        );
    }

    roden_json_ld( $schema );
}

/* ==========================================================================
   15. Taxonomy archives (existing)
   ========================================================================== */

function roden_schema_taxonomy_archive( $firm ) {
    $term = get_queried_object();
    if ( ! $term || ! is_a( $term, 'WP_Term' ) ) {
        return;
    }

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'CollectionPage',
        'name'        => single_term_title( '', false ),
        'description' => term_description( $term ) ?: sprintf( '%s — %s', $term->name, $firm['name'] ),
        'url'         => get_term_link( $term ),
        'isPartOf'    => array(
            '@type' => 'WebSite',
            '@id'   => $firm['url'] . '/#website',
            'name'  => $firm['name'],
        ),
    );

    // List items in this collection.
    $posts = get_posts( array(
        'post_type'      => 'any',
        'posts_per_page' => 20,
        'tax_query'      => array(
            array(
                'taxonomy' => $term->taxonomy,
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ),
        ),
    ) );

    if ( $posts ) {
        $schema['hasPart'] = array();
        foreach ( $posts as $p ) {
            $schema['hasPart'][] = array(
                '@type' => 'WebPage',
                'name'  => $p->post_title,
                'url'   => get_permalink( $p ),
            );
        }
    }

    roden_json_ld( $schema );
}
