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

/* ==========================================================================
   SCHEMA DISPATCHER (wp_head hook)
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
        roden_schema_breadcrumbs(); // Single-item homepage breadcrumb (site hierarchy signal)
    }

    if ( roden_is_pa_singular() ) {
        roden_schema_legal_service( $firm );
        roden_schema_pa_attorney( $firm );
        roden_schema_faq_page();
        roden_schema_speakable_practice_area();

        // Article schema for sub-type pages (child PA posts without an office key).
        if ( roden_is_subtype_page() ) {
            roden_schema_article_subtype( $firm );
        }
    }

    if ( is_singular( 'location' ) ) {
        $is_neighborhood = get_post_meta( get_the_ID(), '_roden_is_neighborhood', true );
        if ( $is_neighborhood ) {
            roden_schema_neighborhood_legal_service( $firm );
            roden_schema_local_business_neighborhood( $firm );
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

    if ( is_singular( 'resource' ) ) {
        roden_schema_howto();
    }

    if ( is_singular( 'post' ) ) {
        roden_schema_article( $firm );
        roden_schema_faq_page();
    }

    // Contact page — Organization with ContactPoint
    if ( is_page( 'contact' ) ) {
        roden_schema_contact_page( $firm );
    }

    // SC statewide PPC landing page — LegalService + FAQPage + LocalBusiness (SC offices)
    if ( is_page_template( 'templates/template-landing-sc-statewide.php' ) ) {
        roden_schema_sc_statewide( $firm );
    }

    // BreadcrumbList on all pages except front page and noindex landing pages
    $is_landing = is_page_template( 'templates/template-landing-page.php' )
               || is_page_template( 'templates/template-landing-truck.php' )
               || is_page_template( 'templates/template-landing-truck-columbia.php' )
               || is_page_template( 'templates/template-landing-sc-statewide.php' );
    if ( ! is_front_page() && ! $is_landing ) {
        roden_schema_breadcrumbs();
    }
}

/* ==========================================================================
   1. Organization / LawFirm (Homepage)
   ========================================================================== */

function roden_schema_organization( $firm ) {
    $schema = array(
        '@context'     => 'https://schema.org',
        '@type'        => array( 'Organization', 'LawFirm' ),
        '@id'          => $firm['url'] . '/#organization',
        'name'         => $firm['name'],
        'legalName'    => $firm['legal_entity'],
        'url'          => $firm['url'],
        'description'  => $firm['description'],
        'telephone'    => $firm['vanity_phone'],
        'foundingDate' => $firm['founded'],
        'areaServed'   => array(
            array( '@type' => 'State', 'name' => 'Georgia' ),
            array( '@type' => 'State', 'name' => 'South Carolina' ),
        ),
        'sameAs' => array_values( $firm['social'] ),
    );

    $logo_url = roden_get_logo_url();
    if ( $logo_url ) {
        $schema['logo'] = array(
            '@type'      => 'ImageObject',
            'url'        => $logo_url,
            'contentUrl' => $logo_url,
        );
        $schema['image'] = $logo_url;
    }

    // All offices as sub-locations
    $locations = array();
    foreach ( $firm['offices'] as $key => $office ) {
        $locations[] = array(
            '@type'     => 'LocalBusiness',
            'name'      => $office['name'],
            'address'   => roden_schema_postal_address( $office ),
            'telephone' => $office['phone'],
            'geo'       => roden_schema_geo( $office ),
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
        'telephone'   => $firm['vanity_phone'],
        'priceRange'  => 'Free Consultation',
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

    // On singular practice area, customize for that page
    if ( roden_is_pa_singular() ) {
        $schema['name']        = get_the_title() . ' — ' . $firm['name'];
        $schema['description'] = get_the_excerpt() ?: wp_trim_words( get_the_content(), 30 );

        // Narrow areaServed on intersection pages to the specific location
        if ( function_exists( 'roden_is_intersection_page' ) && roden_is_intersection_page() ) {
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
        'priceRange' => 'Free Consultation',
        'address'    => roden_schema_postal_address( $office ),
        'geo'        => roden_schema_geo( $office ),
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

    // Build worksFor: @type must be Organization to match @id /#organization
    $office_key = get_post_meta( $post_id, '_roden_atty_office_key', true );
    $works_for  = array(
        '@type'      => 'Organization',
        '@id'        => $firm['url'] . '/#organization',
        'name'       => $firm['name'],
        'url'        => $firm['url'],
        'telephone'  => $firm['phone_e164'],
        'priceRange' => 'Contingency (No Fee Unless We Win)',
    );
    if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
        $office = $firm['offices'][ $office_key ];
        $works_for['address'] = array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => $office['street'],
            'addressLocality' => $office['city'],
            'addressRegion'   => $office['state'],
            'postalCode'      => $office['zip'],
            'addressCountry'  => 'US',
        );
    }

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
            // Neighborhood: Locations > State > City > Neighborhood
            $parent_office_key = get_post_meta( get_the_ID(), '_roden_parent_office_key', true );
            $parent_id = wp_get_post_parent_id( get_the_ID() );
            if ( $parent_office_key && isset( $firm['offices'][ $parent_office_key ] ) ) {
                $office = $firm['offices'][ $parent_office_key ];
                $items[] = array(
                    '@type'    => 'ListItem',
                    'position' => $position++,
                    'name'     => $office['state_full'],
                    'item'     => home_url( '/locations/' . $office['state_slug'] . '/' ),
                );
                // Only add parent city crumb if it differs from current page title (avoids duplication).
                if ( $parent_id && strcasecmp( $office['market_name'], get_the_title() ) !== 0 ) {
                    $items[] = array(
                        '@type'    => 'ListItem',
                        'position' => $position++,
                        'name'     => $office['market_name'],
                        'item'     => get_permalink( $parent_id ),
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

    // Allow single-item BreadcrumbList on homepage (signals top of hierarchy);
    // require at least 2 items on all other pages.
    $min_items = is_front_page() ? 1 : 2;
    if ( count( $items ) < $min_items ) {
        return;
    }

    roden_json_ld( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    ) );
}

/* ==========================================================================
   8. Speakable (Homepage + Practice Area pages)
   ========================================================================== */

function roden_schema_speakable_homepage( $firm ) {
    roden_json_ld( array(
        '@context'  => 'https://schema.org',
        '@type'     => 'WebPage',
        'name'      => $firm['name'] . ' — Personal Injury Lawyers in Georgia & South Carolina',
        'url'       => $firm['url'],
        'speakable' => array(
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => array( '.hero h1', '.hero p', '.trust-bar' ),
        ),
    ) );
}

function roden_schema_speakable_practice_area() {
    roden_json_ld( array(
        '@context'  => 'https://schema.org',
        '@type'     => 'WebPage',
        'name'      => get_the_title(),
        'url'       => roden_get_canonical_url(),
        'speakable' => array(
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => array( '.hero h1', '.hero p' ),
        ),
    ) );
}

function roden_schema_speakable_location() {
    roden_json_ld( array(
        '@context'  => 'https://schema.org',
        '@type'     => 'WebPage',
        'name'      => get_the_title(),
        'url'       => get_permalink(),
        'speakable' => array(
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => array(
                '.location-hero__tagline',
                '.location-intro',
                '.location-service-area',
            ),
        ),
    ) );
}

/* ==========================================================================
   9. AggregateRating (Homepage)
   ========================================================================== */

function roden_schema_aggregate_rating( $firm ) {
    // Reflects verified Google Reviews count — sourced from firm data config.
    // References the existing LegalService entity instead of creating a new one.
    $review_count = $firm['trust_stats']['review_count'] ?? 500;

    roden_json_ld( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'LegalService',
        '@id'             => $firm['url'] . '/#legalservice',
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
   10. WebSite with Sitelinks Searchbox (Homepage)
   ========================================================================== */

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
   8. ContactPage (Contact page)
   ========================================================================== */

function roden_schema_contact_page( $firm ) {
    $contact_points = array();
    foreach ( $firm['offices'] as $office ) {
        $contact_points[] = array(
            '@type'       => 'ContactPoint',
            'telephone'   => $office['phone'],
            'contactType' => 'customer service',
            'areaServed'  => $office['state_full'],
            'availableLanguage' => array( 'English', 'Spanish' ),
        );
    }

    $schema = array(
        '@context'     => 'https://schema.org',
        '@type'        => 'Organization',
        '@id'          => $firm['url'] . '/#organization',
        'name'         => $firm['name'],
        'url'          => $firm['url'],
        'telephone'    => $firm['vanity_phone'],
        'contactPoint' => $contact_points,
    );

    $logo_url = roden_get_logo_url();
    if ( $logo_url ) {
        $schema['logo'] = $logo_url;
    }

    roden_json_ld( $schema );
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
            if ( strcasecmp( $community, $neighborhood_name ) !== 0 ) {
                $area_served[] = array(
                    '@type' => 'Place',
                    'name'  => $community,
                );
            }
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

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'LegalService',
        '@id'         => get_permalink() . '#legalservice',
        'name'        => $office['name'],
        'description' => 'Personal injury lawyers serving ' . $neighborhood_name . ', ' . $office['state'] . '. Free consultation. No fees unless we win.',
        'url'         => get_permalink(),
        'telephone'   => $office['phone'],
        'priceRange'  => 'Free consultation, contingency fee',
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

    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => array( 'LocalBusiness', 'LegalService', 'LawFirm' ),
        '@id'        => $firm['url'] . '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['market_name'] ) . '/#localbusiness',
        'name'       => $office['name'],
        'url'        => $firm['url'] . '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['market_name'] ) . '/',
        'telephone'  => $office['phone'],
        'priceRange' => 'Free Consultation',
        'address'    => roden_schema_postal_address( $office ),
        'geo'        => roden_schema_geo( $office ),
        'areaServed' => array(
            array(
                '@type' => 'City',
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

    $logo_url = roden_get_logo_url();
    if ( $logo_url ) {
        $schema['image'] = $logo_url;
    }

    roden_json_ld( $schema );
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
        'priceRange'      => 'Free Consultation — Contingency Fee',
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
