<?php
/**
 * Schema Helpers — JSON-LD structured data output
 *
 * Generates Organization, LegalService, LocalBusiness, Person/Attorney,
 * FAQPage, Speakable, BreadcrumbList, WebSite, AggregateRating, HowTo.
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ─── MASTER SCHEMA OUTPUT HOOK ────────────────────────────────────────── */

add_action( 'wp_head', 'roden_output_schema', 5 );
function roden_output_schema() {
    $firm = roden_firm_data();

    // Always output: Organization + WebSite + BreadcrumbList
    roden_schema_organization( $firm );
    roden_schema_website( $firm );
    roden_schema_breadcrumbs();

    // Homepage: AggregateRating + all LocalBusiness
    if ( is_front_page() ) {
        roden_schema_aggregate_rating( $firm );
        roden_schema_speakable_homepage( $firm );
        foreach ( $firm['offices'] as $key => $office ) {
            roden_schema_local_business( $firm, $office, $key );
        }
    }

    // Single practice area: LegalService + FAQPage + Speakable
    // Intersection pages also get LocalBusiness for the specific office
    if ( is_singular( 'practice_area' ) ) {
        roden_schema_legal_service( $firm, get_queried_object() );
        roden_schema_faqpage( get_queried_object_id() );
        roden_schema_speakable_practice_area( $firm, get_queried_object() );

        // Intersection page: also output LocalBusiness for the specific office
        $pa_office_key = get_post_meta( get_the_ID(), '_roden_pa_office_key', true );
        if ( $pa_office_key && isset( $firm['offices'][ $pa_office_key ] ) ) {
            roden_schema_local_business( $firm, $firm['offices'][ $pa_office_key ], $pa_office_key );
        }
    }

    // Single location: LocalBusiness + LegalService
    if ( is_singular( 'location' ) ) {
        $office_key = get_post_meta( get_the_ID(), '_roden_office_key', true );
        if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
            // City office page — single LocalBusiness
            roden_schema_local_business( $firm, $firm['offices'][ $office_key ], $office_key );
        } else {
            // State landing page — output LocalBusiness for each office in this state
            $post_slug = get_post_field( 'post_name', get_the_ID() );
            $state_abbr = $post_slug === 'georgia' ? 'GA' : ( $post_slug === 'south-carolina' ? 'SC' : '' );
            if ( $state_abbr ) {
                foreach ( $firm['offices'] as $key => $office ) {
                    if ( $office['state'] === $state_abbr ) {
                        roden_schema_local_business( $firm, $office, $key );
                    }
                }
            }
        }
        roden_schema_faqpage( get_queried_object_id() );
    }

    // Single attorney: Person
    if ( is_singular( 'attorney' ) ) {
        roden_schema_person( $firm, get_queried_object() );
    }

    // Blog posts: FAQPage if FAQs exist + Article
    if ( is_singular( 'post' ) ) {
        roden_schema_article( $firm, get_queried_object() );
        roden_schema_faqpage( get_queried_object_id() );
    }

    // Resources: FAQPage + HowTo if applicable
    if ( is_singular( 'resource' ) ) {
        roden_schema_faqpage( get_queried_object_id() );
    }
}

/* ─── HELPER: Output JSON-LD block ────────────────────────────────────── */

function roden_jsonld( $data ) {
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
    echo "\n" . '</script>' . "\n";
}

/* ─── ORGANIZATION ─────────────────────────────────────────────────────── */

function roden_schema_organization( $firm ) {
    $schema = [
        '@context'   => 'https://schema.org',
        '@type'      => ['Organization', 'LegalService'],
        '@id'        => $firm['url'] . '/#organization',
        'name'       => $firm['name'],
        'legalName'  => $firm['legal_name'],
        'url'        => $firm['url'],
        'logo'       => [
            '@type'      => 'ImageObject',
            'url'        => $firm['logo'],
            'contentUrl' => $firm['logo'],
        ],
        'image'         => $firm['logo'],
        'telephone'     => $firm['phone_e164'],
        'email'         => $firm['email'],
        'foundingDate'  => $firm['founded'],
        'description'   => $firm['description'],
        'slogan'        => $firm['slogan'],
        'areaServed'    => array_map( fn($s) => [
            '@type' => 'State',
            'name'  => $s,
        ], $firm['states'] ),
        'sameAs'        => $firm['same_as'],
        'knowsAbout'    => [
            'Personal Injury Law',
            'Car Accident Claims',
            'Truck Accident Litigation',
            'Slip and Fall Claims',
            'Medical Malpractice',
            'Wrongful Death',
            'Workers Compensation',
        ],
        'aggregateRating' => [
            '@type'       => 'AggregateRating',
            'ratingValue' => $firm['rating'],
            'reviewCount' => $firm['review_count'],
            'bestRating'  => 5,
            'worstRating' => 1,
        ],
    ];

    // Add all offices as department/location
    $locations = [];
    foreach ( $firm['offices'] as $key => $office ) {
        $locations[] = [
            '@type'   => 'LegalService',
            'name'    => $office['name'],
            'address' => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => $office['address'],
                'addressLocality' => $office['city'],
                'addressRegion'   => $office['state'],
                'postalCode'      => $office['zip'],
                'addressCountry'  => 'US',
            ],
            'telephone' => $office['phone_e164'],
            'geo'       => [
                '@type'     => 'GeoCoordinates',
                'latitude'  => $office['lat'],
                'longitude' => $office['lng'],
            ],
        ];
    }
    $schema['location'] = $locations;

    roden_jsonld( $schema );
}

/* ─── WEBSITE + SITELINKS SEARCHBOX ────────────────────────────────────── */

function roden_schema_website( $firm ) {
    roden_jsonld( [
        '@context'        => 'https://schema.org',
        '@type'           => 'WebSite',
        '@id'             => $firm['url'] . '/#website',
        'name'            => $firm['name'],
        'url'             => $firm['url'],
        'publisher'       => [ '@id' => $firm['url'] . '/#organization' ],
        'potentialAction' => [
            '@type'       => 'SearchAction',
            'target'      => [
                '@type'       => 'EntryPoint',
                'urlTemplate' => $firm['url'] . '/?s={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ] );
}

/* ─── BREADCRUMBS ──────────────────────────────────────────────────────── */

function roden_schema_breadcrumbs() {
    if ( is_front_page() ) return;

    $firm  = roden_firm_data();
    $items = [];
    $pos   = 1;

    $items[] = [
        '@type'    => 'ListItem',
        'position' => $pos++,
        'name'     => 'Home',
        'item'     => $firm['url'],
    ];

    if ( is_singular( 'practice_area' ) ) {
        $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => 'Practice Areas', 'item' => $firm['url'] . '/practice-areas/' ];
        // If child page (intersection or sub-type), include parent pillar
        $pa_post = get_post( get_the_ID() );
        if ( $pa_post->post_parent ) {
            $parent = get_post( $pa_post->post_parent );
            if ( $parent ) {
                $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => $parent->post_title, 'item' => get_permalink( $parent ) ];
            }
        }
        $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => get_the_title() ];
    } elseif ( is_singular( 'location' ) ) {
        $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => 'Locations', 'item' => $firm['url'] . '/locations/' ];
        $office_key = get_post_meta( get_the_ID(), '_roden_office_key', true );
        if ( $office_key && isset( $firm['offices'][$office_key] ) ) {
            $o = $firm['offices'][$office_key];
            $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => $o['state_full'], 'item' => $firm['url'] . '/locations/' . strtolower(str_replace(' ','-',$o['state_full'])) . '/' ];
        }
        $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => get_the_title() ];
    } elseif ( is_singular( 'attorney' ) ) {
        $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => 'Attorneys', 'item' => $firm['url'] . '/attorneys/' ];
        $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => get_the_title() ];
    } elseif ( is_singular( 'post' ) ) {
        $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => 'Blog', 'item' => get_permalink( get_option('page_for_posts') ) ?: $firm['url'] . '/blog/' ];
        $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => get_the_title() ];
    } elseif ( is_singular( 'resource' ) ) {
        $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => 'Resources', 'item' => $firm['url'] . '/resources/' ];
        $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => get_the_title() ];
    } elseif ( is_archive() ) {
        $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => post_type_archive_title( '', false ) ?: 'Archive' ];
    } else {
        $items[] = [ '@type' => 'ListItem', 'position' => $pos++, 'name' => get_the_title() ];
    }

    roden_jsonld( [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    ] );
}

/* ─── LOCAL BUSINESS (per office) ──────────────────────────────────────── */

function roden_schema_local_business( $firm, $office, $key ) {
    $slug = strtolower( str_replace( ' ', '-', $office['city'] ) );
    $state_slug = $office['state'] === 'GA' ? 'georgia' : 'south-carolina';

    roden_jsonld( [
        '@context'       => 'https://schema.org',
        '@type'          => ['LocalBusiness', 'LegalService', 'ProfessionalService'],
        '@id'            => $firm['url'] . '/locations/' . $state_slug . '/' . $slug . '/#localbusiness',
        'name'           => $office['name'],
        'image'          => $firm['logo'],
        'telephone'      => $office['phone_e164'],
        'url'            => $firm['url'] . '/locations/' . $state_slug . '/' . $slug . '/',
        'priceRange'     => 'Free Consultation',
        'address'        => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $office['address'],
            'addressLocality' => $office['city'],
            'addressRegion'   => $office['state'],
            'postalCode'      => $office['zip'],
            'addressCountry'  => 'US',
        ],
        'geo'            => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => $office['lat'],
            'longitude' => $office['lng'],
        ],
        'openingHoursSpecification' => [
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday'],
            'opens'     => '08:00',
            'closes'    => '18:00',
        ],
        'areaServed'     => $office['service_area'],
        'parentOrganization' => [ '@id' => $firm['url'] . '/#organization' ],
        'aggregateRating' => [
            '@type'       => 'AggregateRating',
            'ratingValue' => $firm['rating'],
            'reviewCount' => $firm['review_count'],
        ],
    ] );
}

/* ─── LEGAL SERVICE (practice area) ────────────────────────────────────── */

function roden_schema_legal_service( $firm, $post ) {
    $jurisdiction = get_post_meta( $post->ID, '_roden_jurisdiction', true ) ?: 'both';
    $areas = [];
    if ( in_array( $jurisdiction, ['both','ga'] ) ) $areas[] = ['@type'=>'State','name'=>'Georgia'];
    if ( in_array( $jurisdiction, ['both','sc'] ) ) $areas[] = ['@type'=>'State','name'=>'South Carolina'];

    roden_jsonld( [
        '@context'    => 'https://schema.org',
        '@type'       => 'LegalService',
        '@id'         => get_permalink( $post ) . '#legalservice',
        'name'        => $firm['name'] . ' — ' . $post->post_title,
        'description' => wp_strip_all_tags( get_the_excerpt( $post ) ?: wp_trim_words( $post->post_content, 40 ) ),
        'url'         => get_permalink( $post ),
        'provider'    => [ '@id' => $firm['url'] . '/#organization' ],
        'areaServed'  => $areas,
        'serviceType' => $post->post_title,
    ] );
}

/* ─── PERSON / ATTORNEY ────────────────────────────────────────────────── */

function roden_schema_person( $firm, $post ) {
    $title          = get_post_meta( $post->ID, '_roden_atty_title', true );
    $office_key     = get_post_meta( $post->ID, '_roden_atty_office_key', true );
    $bar_raw        = get_post_meta( $post->ID, '_roden_atty_bar_admissions', true );
    $edu_raw        = get_post_meta( $post->ID, '_roden_atty_education', true );
    $awards_raw     = get_post_meta( $post->ID, '_roden_atty_awards', true );
    $avvo           = get_post_meta( $post->ID, '_roden_atty_avvo_url', true );
    $linkedin       = get_post_meta( $post->ID, '_roden_atty_linkedin', true );

    $schema = [
        '@context'   => 'https://schema.org',
        '@type'      => 'Person',
        '@id'        => get_permalink( $post ) . '#person',
        'name'       => $post->post_title,
        'jobTitle'   => $title ?: 'Attorney',
        'url'        => get_permalink( $post ),
        'worksFor'   => [ '@id' => $firm['url'] . '/#organization' ],
        'description'=> wp_strip_all_tags( get_the_excerpt( $post ) ?: wp_trim_words( $post->post_content, 40 ) ),
    ];

    if ( has_post_thumbnail( $post ) ) {
        $schema['image'] = get_the_post_thumbnail_url( $post, 'attorney-portrait' );
    }

    // Office
    if ( $office_key && isset( $firm['offices'][$office_key] ) ) {
        $o = $firm['offices'][$office_key];
        $schema['workLocation'] = [
            '@type'   => 'Place',
            'name'    => $o['name'],
            'address' => [
                '@type'           => 'PostalAddress',
                'addressLocality' => $o['city'],
                'addressRegion'   => $o['state'],
            ],
        ];
    }

    // Bar Admissions as credentials
    if ( $bar_raw ) {
        $creds = [];
        foreach ( explode( "\n", $bar_raw ) as $line ) {
            $line = trim( $line );
            if ( ! $line ) continue;
            $parts = array_map( 'trim', explode( '|', $line ) );
            $creds[] = [
                '@type'              => 'EducationalOccupationalCredential',
                'credentialCategory' => 'Bar Admission',
                'name'               => $parts[0],
            ];
        }
        if ( $creds ) $schema['hasCredential'] = $creds;
    }

    // Education
    if ( $edu_raw ) {
        $edu = [];
        foreach ( array_filter( array_map( 'trim', explode( "\n", $edu_raw ) ) ) as $line ) {
            $edu[] = [
                '@type' => 'EducationalOccupationalCredential',
                'name'  => $line,
            ];
        }
        if ( $edu ) $schema['alumniOf'] = $edu;
    }

    // Awards
    if ( $awards_raw ) {
        $schema['award'] = array_filter( array_map( 'trim', explode( "\n", $awards_raw ) ) );
    }

    // sameAs
    $same = [];
    if ( $avvo ) $same[] = $avvo;
    if ( $linkedin ) $same[] = $linkedin;
    if ( $same ) $schema['sameAs'] = $same;

    roden_jsonld( $schema );
}

/* ─── FAQ PAGE ─────────────────────────────────────────────────────────── */

function roden_schema_faqpage( $post_id ) {
    $faqs = get_post_meta( $post_id, '_roden_faqs', true );
    if ( ! is_array( $faqs ) || empty( $faqs ) ) return;

    $entities = [];
    foreach ( $faqs as $faq ) {
        if ( empty( $faq['q'] ) || empty( $faq['a'] ) ) continue;
        $entities[] = [
            '@type'          => 'Question',
            'name'           => $faq['q'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => $faq['a'],
            ],
        ];
    }
    if ( empty( $entities ) ) return;

    roden_jsonld( [
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $entities,
    ] );
}

/* ─── SPEAKABLE ────────────────────────────────────────────────────────── */

function roden_schema_speakable_homepage( $firm ) {
    roden_jsonld( [
        '@context'  => 'https://schema.org',
        '@type'     => 'WebPage',
        'name'      => $firm['name'] . ' — ' . $firm['slogan'],
        'url'       => $firm['url'],
        'speakable' => [
            '@type'    => 'SpeakableSpecification',
            'cssSelector' => ['.speakable-hero', '.speakable-summary'],
        ],
    ] );
}

function roden_schema_speakable_practice_area( $firm, $post ) {
    roden_jsonld( [
        '@context'  => 'https://schema.org',
        '@type'     => 'WebPage',
        'name'      => $post->post_title . ' — ' . $firm['name'],
        'url'       => get_permalink( $post ),
        'speakable' => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.speakable-hero', '.speakable-intro', '.faq-section'],
        ],
    ] );
}

/* ─── AGGREGATE RATING (homepage) ──────────────────────────────────────── */

function roden_schema_aggregate_rating( $firm ) {
    roden_jsonld( [
        '@context'        => 'https://schema.org',
        '@type'           => 'LegalService',
        'name'            => $firm['name'],
        'url'             => $firm['url'],
        'aggregateRating' => [
            '@type'       => 'AggregateRating',
            'ratingValue' => $firm['rating'],
            'reviewCount' => $firm['review_count'],
            'bestRating'  => 5,
            'worstRating' => 1,
        ],
    ] );
}

/* ─── ARTICLE (blog posts) ─────────────────────────────────────────────── */

function roden_schema_article( $firm, $post ) {
    $schema = [
        '@context'      => 'https://schema.org',
        '@type'         => 'Article',
        'headline'      => $post->post_title,
        'url'           => get_permalink( $post ),
        'datePublished' => get_the_date( 'c', $post ),
        'dateModified'  => get_the_modified_date( 'c', $post ),
        'publisher'     => [ '@id' => $firm['url'] . '/#organization' ],
        'description'   => wp_strip_all_tags( get_the_excerpt( $post ) ?: wp_trim_words( $post->post_content, 30 ) ),
    ];

    if ( has_post_thumbnail( $post ) ) {
        $schema['image'] = get_the_post_thumbnail_url( $post, 'large' );
    }

    // Author attribution — check for linked attorney
    $author_id = get_post_meta( $post->ID, '_roden_author_attorney', true );
    if ( $author_id ) {
        $atty = get_post( $author_id );
        if ( $atty ) {
            $schema['author'] = [
                '@type'   => 'Person',
                'name'    => $atty->post_title,
                'url'     => get_permalink( $atty ),
                'jobTitle'=> get_post_meta( $atty->ID, '_roden_atty_title', true ) ?: 'Attorney',
            ];
        }
    } else {
        $schema['author'] = [
            '@type' => 'Organization',
            'name'  => $firm['name'],
            'url'   => $firm['url'],
        ];
    }

    roden_jsonld( $schema );
}

/* ─── HOWTO (for resource pages) ───────────────────────────────────────── */

function roden_schema_howto( $title, $steps, $description = '' ) {
    $step_items = [];
    foreach ( $steps as $i => $step ) {
        $step_items[] = [
            '@type'    => 'HowToStep',
            'position' => $i + 1,
            'name'     => $step['name'],
            'text'     => $step['text'],
        ];
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'HowTo',
        'name'     => $title,
        'step'     => $step_items,
    ];
    if ( $description ) $schema['description'] = $description;

    roden_jsonld( $schema );
}

/* ─── META DESCRIPTION HELPER ──────────────────────────────────────────── */

function roden_intersection_meta_description( $practice_area, $city, $state ) {
    $firm = roden_firm_data();
    return sprintf(
        'Looking for a %s in %s, %s? %s has recovered %s for injury victims. Free consultation — no fees unless we win. Call today.',
        $practice_area, $city, $state, $firm['name'], $firm['recovered']
    );
}
