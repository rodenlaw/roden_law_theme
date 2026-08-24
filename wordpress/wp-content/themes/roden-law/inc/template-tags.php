<?php
/**
 * Template Tags — Reusable display functions + page type detection helpers.
 *
 * All output functions are prefixed roden_ and designed to be called
 * directly from template files. Each renders self-contained HTML.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   PRACTICE-AREA RESOLUTION — pillar lookup, display noun, statute resolver

   Pillar, intersection and sub-type pages are all 'practice_area' posts in a
   parent/child tree whose root is the pillar. Several templates need to know
   which pillar they belong to — to pick the right filing deadline, the right
   "what to do" steps, or a grammatical display noun — so the walk-up lives
   here once instead of being re-derived per template.
   ========================================================================== */

/**
 * Walk up to the topmost 'practice_area' ancestor (the pillar).
 *
 * @param int|null $post_id Post to resolve. Defaults to the current post.
 * @return WP_Post|null Pillar post, or null when not a practice_area.
 */
function roden_pa_pillar_post( $post_id = null ) {
    $post_id = $post_id ? $post_id : get_the_ID();
    if ( ! $post_id ) {
        return null;
    }

    $post = get_post( $post_id );
    if ( ! $post || 'practice_area' !== $post->post_type ) {
        return null;
    }

    // Depth guard: a corrupted parent cycle must not hang the request.
    $depth = 0;
    while ( $post->post_parent && $depth < 10 ) {
        $parent = get_post( $post->post_parent );
        if ( ! $parent || 'practice_area' !== $parent->post_type ) {
            break;
        }
        $post = $parent;
        $depth++;
    }

    return $post;
}

/**
 * Pillar slug for the current (or given) practice-area post.
 *
 * @param int|null $post_id Post to resolve. Defaults to the current post.
 * @return string Pillar slug, or '' when not a practice_area.
 */
function roden_current_pa_slug( $post_id = null ) {
    $pillar = roden_pa_pillar_post( $post_id );
    return $pillar ? $pillar->post_name : '';
}

/**
 * Grammatical display noun for the practice area, e.g. "Workers' Compensation".
 *
 * Post titles end in "Lawyers", which reads fine as a page title but breaks
 * every heading that interpolates it — "Types of Workers' Compensation Lawyers
 * Cases We Handle". This strips that trailing role word so headings read
 * naturally, and on intersection pages it resolves the PILLAR title so the
 * city suffix ("... in Savannah, GA") never leaks into a heading.
 *
 * Applies to every practice area. The 'roden_pa_noun_optin' filter accepts true
 * (all — the default) or an array of pillar slugs to restrict it; it was
 * introduced as a staged rollout for workers' compensation and widened once the
 * output had been verified across the other pillars.
 *
 * Spanish titles put the role word first ("Abogados de Compensación Laboral"),
 * so the trailing-suffix rule cannot reach it — hence the separate leading form.
 *
 * @param string   $fallback Text to return when the practice area is excluded.
 * @param int|null $post_id  Post to resolve. Defaults to the current post.
 * @return string Display noun.
 */
function roden_pa_noun( $fallback = '', $post_id = null ) {
    $fallback = ( '' !== $fallback ) ? $fallback : get_the_title( $post_id ? $post_id : null );

    $pillar = roden_pa_pillar_post( $post_id );
    if ( ! $pillar ) {
        return $fallback;
    }

    $optin = apply_filters( 'roden_pa_noun_optin', true );
    if ( true !== $optin && ! in_array( $pillar->post_name, (array) $optin, true ) ) {
        return $fallback;
    }

    $noun = $pillar->post_title;

    // English: "Car Accident Lawyers" → "Car Accident".
    $noun = preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', $noun );

    // Spanish: "Abogados de Compensación Laboral" → "Compensación Laboral".
    $noun = preg_replace( '/^(Abogad[oa]s?|Aboga(?:do|da)s?)\s+de\s+/iu', '', $noun );

    $noun = trim( $noun, " \t\n\r\0\x0B-–—" );

    // Never return an empty heading — a title that is only a role word
    // ("Lawyers", "Abogados") would otherwise blank the heading entirely.
    return ( '' !== $noun ) ? $noun : $fallback;
}

/**
 * Resolve the filing deadline for a state, honouring practice-area overrides.
 *
 * $firm['jurisdiction'] holds each state's TORT statute of limitations. That is
 * correct for negligence claims but wrong for statutory schemes with their own
 * deadline — a Georgia workers' comp claim is one year (O.C.G.A. § 34-9-82),
 * not the two-year tort SOL. Templates must call this rather than reading
 * $firm['jurisdiction'][$state]['statute_years'] directly.
 *
 * @param string      $state_key Two-letter state key, 'GA' or 'SC'.
 * @param string|null $pa_slug   Pillar slug. Null = detect from current post.
 * @return array|null Keys: state_full, statute_years, statute_cite, notice_label,
 *                    notice_detail, filing_venue, is_override. Null on unknown state.
 */
function roden_resolve_statute( $state_key, $pa_slug = null ) {
    $firm      = roden_firm_data();
    $state_key = strtoupper( (string) $state_key );

    if ( ! isset( $firm['jurisdiction'][ $state_key ] ) ) {
        return null;
    }

    $base = $firm['jurisdiction'][ $state_key ];

    $resolved = array(
        'state_full'      => $base['state_full'],
        'statute_years'   => $base['statute_years'],
        'statute_cite'    => $base['statute_cite'],
        'comp_fault_rule' => isset( $base['comp_fault_rule'] ) ? $base['comp_fault_rule'] : '',
        'comp_fault_cite' => isset( $base['comp_fault_cite'] ) ? $base['comp_fault_cite'] : '',
        'notice_label'    => '',
        'notice_detail'   => '',
        'filing_venue'    => '',
        'is_override'     => false,
    );

    if ( null === $pa_slug ) {
        $pa_slug = roden_current_pa_slug();
    }

    $overrides = isset( $firm['statute_overrides'] ) ? $firm['statute_overrides'] : array();

    // Spanish pages hang off mirrored pillars prefixed 'es-'
    // (es-workers-compensation-lawyers), which would miss the override map and
    // silently fall back to the tort statute of limitations — i.e. show injured
    // Spanish-speaking workers a deadline twice as long as the real one. Strip
    // the language prefix so the lookup is language-neutral.
    $lookup_slug = $pa_slug ? preg_replace( '/^es-/', '', (string) $pa_slug ) : '';

    if ( $lookup_slug && isset( $overrides[ $lookup_slug ][ $state_key ] ) ) {
        $resolved = array_merge( $resolved, $overrides[ $lookup_slug ][ $state_key ] );

        /*
         * Both locales now get the full statutory treatment.
         *
         * Until 2026-07-31 this branch blanked the prose fields and forced
         * is_override = false on /es/, because the comp strings had no entry in
         * es_ES.po at all — not untranslated, simply absent — so the templates
         * would have rendered English legal copy mid-Spanish-sentence. Spanish
         * pages got the corrected deadlines with their existing translated tort
         * framing, which was right on the numbers and wrong on the concept: it
         * described comparative fault on a no-fault claim.
         *
         * The 38 missing strings are now translated (see es_ES.po), and the
         * statute_overrides prose in inc/firm-data.php is wrapped in __(), so
         * the suppression is gone.
         */
        $resolved['is_override'] = true;
    }

    return $resolved;
}

/**
 * Sentence-case an accident phrase without flattening a curated one.
 *
 * Derived labels arrive lowercase ("car accident") and want capitalizing.
 * Curated phrases from roden_pa_accident_phrase() are already cased the way
 * they should read ("a Dog Bite"), and ucfirst() would leave them as
 * "A Dog Bite". Only touch strings that carry no capitals of their own.
 *
 * @param string $phrase Accident phrase.
 * @return string Phrase ready for a heading.
 */
function roden_accident_phrase_case( $phrase ) {
    $phrase = (string) $phrase;

    // Spanish keeps sentence case mid-heading. "Qué Hacer Después de Un
    // accidente de auto" capitalizes an article in the middle of a sentence,
    // which is wrong in Spanish; the phrase belongs lowercase after "de".
    if ( function_exists( 'roden_current_lang' ) && 'es' === roden_current_lang() ) {
        return $phrase;
    }

    return ( $phrase === strtolower( $phrase ) ) ? ucfirst( $phrase ) : $phrase;
}

/**
 * The "what happened to you" noun phrase for a practice area.
 *
 * Templates derive this by lowercasing the pillar title and stripping
 * "Lawyers", which works for event-named areas ("a car accident") but produces
 * nonsense for areas named after the remedy rather than the event — workers'
 * compensation yields "What to Do After A workers' compensation".
 *
 * Returns a phrase including its article, ready for ucfirst().
 *
 * @param string $pa_slug  Pillar slug. Empty = detect from current post.
 * @param string $fallback Phrase to use when no override applies.
 * @return string Noun phrase, e.g. "a workplace injury".
 */
function roden_pa_accident_phrase( $pa_slug = '', $fallback = '' ) {
    if ( '' === $pa_slug ) {
        $pa_slug = roden_current_pa_slug();
    }

    /*
     * Callers run these through ucfirst(), which only touches the first
     * character — so a phrase supplied already title-cased survives intact.
     * That is how "What to Do After Nursing Home Abuse" reads correctly while
     * the article-led phrases still render as "After A workplace injury",
     * matching the site's existing headings.
     */
    $phrases = apply_filters(
        'roden_pa_accident_phrases',
        array(
            'workers-compensation-lawyers'   => __( 'a Workplace Injury', 'roden-law' ),
            'nursing-home-abuse-lawyers'     => __( 'Nursing Home Abuse', 'roden-law' ),
            'medical-malpractice-lawyers'    => __( 'Suspected Medical Malpractice', 'roden-law' ),
            'slip-and-fall-lawyers'          => __( 'a Slip and Fall', 'roden-law' ),
            'premises-liability-lawyers'     => __( 'an Injury on Someone Else\'s Property', 'roden-law' ),
            'dog-bite-lawyers'               => __( 'a Dog Bite', 'roden-law' ),
            'wrongful-death-lawyers'         => __( 'a Fatal Accident', 'roden-law' ),
            'brain-injury-lawyers'           => __( 'a Brain Injury', 'roden-law' ),
            'spinal-cord-injury-lawyers'     => __( 'a Spinal Cord Injury', 'roden-law' ),
            'maritime-injury-lawyers'        => __( 'a Maritime Injury', 'roden-law' ),
            'product-liability-lawyers'      => __( 'an Injury From a Defective Product', 'roden-law' ),
            'burn-injury-lawyers'            => __( 'a Burn Injury', 'roden-law' ),
            'construction-accident-lawyers'  => __( 'a Construction Accident', 'roden-law' ),

            /*
             * Spanish pillars. Most ES titles reduce to a sensible bare plural
             * once "Abogados de " is stripped ("Accidentes de Auto"), and need
             * no entry here. These three name the remedy rather than the event,
             * so the strip alone would leave "Qué Hacer Después de Compensación
             * Laboral" — "what to do after workers' compensation".
             *
             * Not wrapped in __(): these keys only ever match on Spanish pillars,
             * so the string is already in its target language. A Spanish msgid
             * would just sit untranslatable in the catalog.
             */
            'es-workers-compensation-lawyers' => 'una Lesión en el Trabajo',
            'es-premises-liability-lawyers'   => 'una Lesión en Propiedad Ajena',
            'es-product-liability-lawyers'    => 'una Lesión por un Producto Defectuoso',
        )
    );

    if ( $pa_slug && isset( $phrases[ $pa_slug ] ) ) {
        return $phrases[ $pa_slug ];
    }

    return $fallback;
}

/**
 * Filter and order a practice area's sub-types for a given office/state.
 *
 * Sub-types are shared across every location under a pillar, but not all of
 * them travel: "Boeing & Aerospace Worker Injury" describes a North Charleston
 * employer and is noise — or worse, a credibility hit — on a Savannah page.
 *
 * Two opt-in post meta flags control this, so nothing changes for sub-types
 * that set neither:
 *   _roden_state_scope     'GA' | 'SC'  — restrict to one state.
 *   _roden_subtype_hidden  '1'          — suppress everywhere (duplicate pages).
 *
 * @param WP_Post[] $subtypes   Sub-type posts.
 * @param string    $state_key  Two-letter state key of the current page.
 * @param string    $office_key Office key of the current page, e.g. 'savannah'.
 * @return WP_Post[] Filtered, ordered sub-types.
 */
function roden_filter_subtypes_for_state( $subtypes, $state_key = '', $office_key = '' ) {
    $state_key = strtoupper( (string) $state_key );
    $filtered  = array();

    foreach ( $subtypes as $st ) {
        if ( get_post_meta( $st->ID, '_roden_subtype_hidden', true ) ) {
            continue;
        }

        $scope = strtoupper( (string) get_post_meta( $st->ID, '_roden_state_scope', true ) );
        if ( $scope && $state_key && $scope !== $state_key ) {
            continue;
        }

        $filtered[] = $st;
    }

    /**
     * Sub-type slugs to promote to the front for a given office.
     *
     * Savannah is deliberately absent. The obvious lead for it would be
     * port-worker-injury — the Port of Savannah defines that market — but that
     * page is written for South Carolina: it is titled "in South Carolina",
     * cites only S.C. Code § 42-15-40, and mentions Charleston four times as
     * often as Savannah. Promoting it on a Georgia page would send an injured
     * Georgia worker to South Carolina law. A Georgia port-worker page needs
     * to be written before Savannah gets a priority entry here.
     *
     * @param array  $map        office key => array of slugs, most important first.
     * @param string $office_key Current office key.
     * @param string $state_key  Current state key.
     */
    $priority_map = apply_filters(
        'roden_subtype_priority_slugs',
        array(
            'charleston'       => array( 'port-worker-injury' ),
            // boeing-aerospace-injury was listed here until batch (c) retired it
            // under plan rule 5. A slug that no longer resolves degrades quietly
            // (array_search returns false, usort sorts it to PHP_INT_MAX), which
            // is exactly why a stale entry survives unnoticed — so it goes with
            // the page. port-worker-injury is a different, surviving sub-type.
            'north-charleston' => array( 'port-worker-injury' ),
        ),
        $office_key,
        $state_key
    );

    $priority = isset( $priority_map[ $office_key ] ) ? $priority_map[ $office_key ] : array();

    if ( $priority ) {
        usort(
            $filtered,
            function ( $a, $b ) use ( $priority ) {
                $ai = array_search( $a->post_name, $priority, true );
                $bi = array_search( $b->post_name, $priority, true );
                $ai = ( false === $ai ) ? PHP_INT_MAX : $ai;
                $bi = ( false === $bi ) ? PHP_INT_MAX : $bi;

                if ( $ai === $bi ) {
                    return strcasecmp( $a->post_title, $b->post_title );
                }
                return $ai <=> $bi;
            }
        );
    }

    return apply_filters( 'roden_pa_subtypes', $filtered, $state_key, $office_key );
}

/* ==========================================================================
   BREADCRUMBS (HTML output — complements BreadcrumbList schema)
   ========================================================================== */

function roden_breadcrumb_html() {
    if ( is_front_page() ) {
        return;
    }

    $firm   = roden_firm_data();
    $lang   = function_exists( 'roden_current_lang' ) ? roden_current_lang() : 'en';
    $crumbs = array( '<a href="' . esc_url( roden_lang_home_url( $lang ) ) . '">' . esc_html__( 'Home', 'roden-law' ) . '</a>' );

    if ( ( function_exists( 'roden_is_pa_singular' ) && roden_is_pa_singular() )
         || is_singular( 'practice_area' ) ) {

        $crumbs[] = '<a href="' . esc_url( roden_lang_home_url( $lang, '/practice-areas/' ) ) . '">' . esc_html__( 'Practice Areas', 'roden-law' ) . '</a>';

        $pa_post = get_post( get_the_ID() );
        if ( $pa_post->post_parent ) {
            $parent = get_post( $pa_post->post_parent );
            if ( $parent ) {
                $crumbs[] = '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . esc_html( $parent->post_title ) . '</a>';
            }
        }
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';

    } elseif ( is_singular( 'location' ) ) {
        $crumbs[] = '<a href="' . esc_url( roden_lang_home_url( $lang, '/locations/' ) ) . '">' . esc_html__( 'Locations', 'roden-law' ) . '</a>';

        $is_neighborhood = get_post_meta( get_the_ID(), '_roden_is_neighborhood', true );
        // No Spanish state pages — skip state/ancestor crumbs on /es/.
        if ( 'es' === $lang ) {
            $is_neighborhood = false;
        }
        if ( $is_neighborhood ) {
            // Neighborhood page: walk ancestors up to the office page.
            // Supports arbitrary depth: Home > Locations > State > City > [Intermediate Neighborhood] > Current
            $parent_office_key = get_post_meta( get_the_ID(), '_roden_parent_office_key', true );
            if ( $parent_office_key && isset( $firm['offices'][ $parent_office_key ] ) ) {
                $o = $firm['offices'][ $parent_office_key ];
                $crumbs[] = '<a href="' . esc_url( home_url( '/locations/' . $o['state_slug'] . '/' ) ) . '">' . esc_html( $o['state_full'] ) . '</a>';

                // Collect all ancestors up to (and including) the office page.
                $ancestors = array();
                $walk_id   = wp_get_post_parent_id( get_the_ID() );
                $state_url = trailingslashit( home_url( '/locations/' . $o['state_slug'] . '/' ) );
                while ( $walk_id ) {
                    $ancestors[] = $walk_id;
                    // Stop once we reach the office-level page (has _roden_office_key).
                    if ( get_post_meta( $walk_id, '_roden_office_key', true ) ) {
                        break;
                    }
                    $walk_id = wp_get_post_parent_id( $walk_id );
                }
                // Ancestors are child-first; reverse to get root-first order.
                $ancestors = array_reverse( $ancestors );
                foreach ( $ancestors as $anc_id ) {
                    // Skip state-level ancestors — already added above from office data.
                    if ( trailingslashit( get_permalink( $anc_id ) ) === $state_url ) {
                        continue;
                    }
                    $crumbs[] = '<a href="' . esc_url( get_permalink( $anc_id ) ) . '">' . esc_html( get_the_title( $anc_id ) ) . '</a>';
                }
            }
        } else {
            // Standard office page: Home > Locations > State > City
            $office_key = get_post_meta( get_the_ID(), '_roden_office_key', true );
            if ( 'en' === $lang && $office_key && isset( $firm['offices'][ $office_key ] ) ) {
                $o = $firm['offices'][ $office_key ];
                $crumbs[] = '<a href="' . esc_url( home_url( '/locations/' . $o['state_slug'] . '/' ) ) . '">' . esc_html( $o['state_full'] ) . '</a>';
            }
        }
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';

    } elseif ( is_singular( 'attorney' ) ) {
        $crumbs[] = '<a href="' . esc_url( home_url( '/attorneys/' ) ) . '">' . esc_html__( 'Attorneys', 'roden-law' ) . '</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';

    } elseif ( is_singular( 'case_result' ) ) {
        $crumbs[] = '<a href="' . esc_url( home_url( '/case-results/' ) ) . '">' . esc_html__( 'Case Results', 'roden-law' ) . '</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';

    } elseif ( is_singular( 'post' ) ) {
        // Lang-aware: ES posts crumb to /es/blog/, not cross-locale to /blog/.
        $blog_url = function_exists( 'roden_blog_home_url' )
            ? roden_blog_home_url( $lang )
            : ( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) );
        $crumbs[] = '<a href="' . esc_url( $blog_url ) . '">' . esc_html__( 'Blog', 'roden-law' ) . '</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';

    } elseif ( is_singular( 'resource' ) ) {
        $crumbs[] = '<a href="' . esc_url( home_url( '/resources/' ) ) . '">' . esc_html__( 'Resources', 'roden-law' ) . '</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';

    } elseif ( is_search() ) {
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html__( 'Search Results', 'roden-law' ) . '</span>';

    } elseif ( is_home() ) {
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html__( 'Blog', 'roden-law' ) . '</span>';

    } elseif ( is_category() ) {
        $blog_url = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' );
        $crumbs[] = '<a href="' . esc_url( $blog_url ) . '">' . esc_html__( 'Blog', 'roden-law' ) . '</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( single_cat_title( '', false ) ) . '</span>';

    } elseif ( is_tag() ) {
        $blog_url = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' );
        $crumbs[] = '<a href="' . esc_url( $blog_url ) . '">' . esc_html__( 'Blog', 'roden-law' ) . '</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( single_tag_title( '', false ) ) . '</span>';

    } elseif ( is_post_type_archive() ) {
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( post_type_archive_title( '', false ) ) . '</span>';

    } elseif ( is_page() ) {
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';
    }

    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'roden-law' ) . '"><span class="breadcrumb-list">'
         . implode( ' <span class="breadcrumb-sep">&rsaquo;</span> ', $crumbs )
         . '</span></nav>';
}

/* ==========================================================================
   CASE RESULTS GRID
   ========================================================================== */

function roden_case_results_grid( $args = array() ) {
    $defaults = array(
        'count'             => 4,
        'practice_category' => '',
        'location_served'   => '',
        'columns'           => 4,
        'exclude'           => array(),
    );
    $args = wp_parse_args( $args, $defaults );

    $query_args = array(
        'post_type'      => 'case_result',
        'posts_per_page' => $args['count'],
        'orderby'        => 'meta_value_num',
        'meta_key'       => '_roden_case_amount_raw',
        'order'          => 'DESC',
    );

    if ( ! empty( $args['exclude'] ) ) {
        $query_args['post__not_in'] = (array) $args['exclude'];
    }

    $tax_query = array();
    if ( $args['practice_category'] ) {
        $tax_query[] = array( 'taxonomy' => 'practice_category', 'field' => 'slug', 'terms' => $args['practice_category'] );
    }
    if ( $args['location_served'] ) {
        $tax_query[] = array( 'taxonomy' => 'location_served', 'field' => 'slug', 'terms' => $args['location_served'] );
    }
    if ( ! empty( $tax_query ) ) {
        $query_args['tax_query'] = $tax_query;
    }

    $results = new WP_Query( $query_args );

    // Fallback: hardcoded results if no CPT posts exist yet
    if ( ! $results->have_posts() ) {
        $fallback_results = array(
            array( 'amount' => '$27,000,000', 'type' => 'Settlement', 'title' => 'Truck Accident',      'desc' => 'Client paralyzed in collision with commercial semi-truck.' ),
            array( 'amount' => '$10,860,000', 'type' => 'Verdict',    'title' => 'Product Liability',    'desc' => 'Defective product caused catastrophic injury.' ),
            array( 'amount' => '$9,800,000',  'type' => 'Recovery',   'title' => 'Premises Liability',   'desc' => 'Client suffered severe injury due to negligent property maintenance.' ),
            array( 'amount' => '$3,000,000',  'type' => 'Settlement', 'title' => 'Auto Accident',        'desc' => 'Wrongful death — surviving spouse of auto accident victim.' ),
        );
        $show = array_slice( $fallback_results, 0, $args['count'] );
        echo '<div class="case-results-grid cols-' . intval( $args['columns'] ) . '">';
        foreach ( $show as $r ) {
            echo '<div class="result-card">';
            echo '<span class="result-type">' . esc_html( $r['type'] ) . '</span>';
            echo '<span class="result-amount">' . esc_html( $r['amount'] ) . '</span>';
            echo '<span class="result-title">' . esc_html( $r['title'] ) . '</span>';
            echo '<p class="result-desc">' . esc_html( $r['desc'] ) . '</p>';
            echo '</div>';
        }
        echo '</div>';
        echo '<p class="results-disclaimer">Results shown are gross settlement/verdict amounts before fees and costs. Past results do not guarantee similar outcomes.</p>';
        return;
    }

    echo '<div class="case-results-grid cols-' . intval( $args['columns'] ) . '">';
    while ( $results->have_posts() ) :
        $results->the_post();
        $amount = get_post_meta( get_the_ID(), '_roden_case_amount', true );
        $type   = get_post_meta( get_the_ID(), '_roden_case_type', true );
        $desc   = get_post_meta( get_the_ID(), '_roden_description', true );
        ?>
        <div class="result-card">
            <span class="result-type"><?php echo esc_html( ucfirst( $type ) ); ?></span>
            <span class="result-amount"><?php echo esc_html( $amount ); ?></span>
            <span class="result-title"><?php the_title(); ?></span>
            <?php if ( $desc ) : ?>
                <p class="result-desc"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
        </div>
        <?php
    endwhile;
    echo '</div>';
    echo '<p class="results-disclaimer">Results shown are gross settlement/verdict amounts before fees and costs. Past results do not guarantee similar outcomes.</p>';
    wp_reset_postdata();
}

/* ==========================================================================
   ATTORNEYS GRID
   ========================================================================== */

function roden_attorneys_grid( $args = array() ) {
    $defaults = array(
        'count'      => -1,
        'office_key' => '',
        'columns'    => 4,
        'role'       => '',
    );
    $args = wp_parse_args( $args, $defaults );

    $query_args = array(
        'post_type'      => 'attorney',
        'posts_per_page' => $args['count'],
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );

    $meta_query = array();
    if ( $args['office_key'] ) {
        $meta_query[] = array( 'key' => '_roden_atty_office_key', 'value' => $args['office_key'], 'compare' => '=' );
    }
    if ( 'attorney' === $args['role'] ) {
        $meta_query[] = array(
            'relation' => 'OR',
            array( 'key' => '_roden_team_role', 'value' => 'attorney' ),
            array( 'key' => '_roden_team_role', 'compare' => 'NOT EXISTS' ),
        );
    }
    if ( ! empty( $meta_query ) ) {
        $query_args['meta_query'] = $meta_query;
    }

    $attorneys = new WP_Query( $query_args );
    if ( ! $attorneys->have_posts() ) {
        return;
    }

    echo '<div class="attorneys-grid cols-' . intval( $args['columns'] ) . '">';
    while ( $attorneys->have_posts() ) :
        $attorneys->the_post();
        $title    = get_post_meta( get_the_ID(), '_roden_atty_title', true );
        $office_k = get_post_meta( get_the_ID(), '_roden_atty_office_key', true );
        $firm     = roden_firm_data();
        $bar_info = '';
        if ( $office_k && isset( $firm['offices'][ $office_k ] ) ) {
            $bar_info = $firm['offices'][ $office_k ]['city'] . ', ' . $firm['offices'][ $office_k ]['state'];
        }
        ?>
        <div class="attorney-card">
            <a href="<?php the_permalink(); ?>" class="attorney-card-link">
                <div class="attorney-photo">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'attorney-headshot' ); ?>
                    <?php else : ?>
                        <div class="attorney-photo-placeholder"></div>
                    <?php endif; ?>
                </div>
                <h3 class="attorney-name"><?php the_title(); ?></h3>
                <?php if ( $title ) : ?>
                    <span class="attorney-title"><?php echo esc_html( $title ); ?></span>
                <?php endif; ?>
                <?php if ( $bar_info ) : ?>
                    <span class="attorney-office"><?php echo esc_html( $bar_info ); ?></span>
                <?php endif; ?>
            </a>
        </div>
        <?php
    endwhile;
    echo '</div>';
    wp_reset_postdata();
}

/* ==========================================================================
   STAFF GRID
   ========================================================================== */

function roden_staff_grid( $args = array() ) {
    $defaults = array(
        'count'   => -1,
        'columns' => 4,
    );
    $args = wp_parse_args( $args, $defaults );

    $query_args = array(
        'post_type'      => 'attorney',
        'posts_per_page' => $args['count'],
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'meta_query'     => array(
            array(
                'key'   => '_roden_team_role',
                'value' => 'staff',
            ),
        ),
    );

    $staff = new WP_Query( $query_args );
    if ( ! $staff->have_posts() ) {
        return;
    }

    $firm = roden_firm_data();

    echo '<div class="attorneys-grid cols-' . intval( $args['columns'] ) . '">';
    while ( $staff->have_posts() ) :
        $staff->the_post();
        $title    = get_post_meta( get_the_ID(), '_roden_atty_title', true );
        $office_k = get_post_meta( get_the_ID(), '_roden_atty_office_key', true );
        $office_info = '';
        if ( $office_k && isset( $firm['offices'][ $office_k ] ) ) {
            $office_info = $firm['offices'][ $office_k ]['city'] . ', ' . $firm['offices'][ $office_k ]['state'];
        }
        ?>
        <div class="attorney-card">
            <div class="attorney-photo">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'attorney-headshot' ); ?>
                <?php else : ?>
                    <div class="attorney-photo-placeholder"></div>
                <?php endif; ?>
            </div>
            <h3 class="attorney-name"><?php the_title(); ?></h3>
            <?php if ( $title ) : ?>
                <span class="attorney-title"><?php echo esc_html( $title ); ?></span>
            <?php endif; ?>
            <?php if ( $office_info ) : ?>
                <span class="attorney-office"><?php echo esc_html( $office_info ); ?></span>
            <?php endif; ?>
        </div>
        <?php
    endwhile;
    echo '</div>';
    wp_reset_postdata();
}

/* ==========================================================================
   LOCATION CARDS (simple office list, optional exclusion)
   ========================================================================== */

function roden_location_cards( $exclude_key = '' ) {
    $firm = roden_firm_data();
    echo '<div class="location-cards-grid">';
    foreach ( $firm['offices'] as $key => $office ) {
        if ( $key === $exclude_key ) {
            continue;
        }
        $url = home_url( '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['market_name'] ) . '/' );
        ?>
        <div class="location-card">
            <span class="location-state-badge state-<?php echo esc_attr( strtolower( $office['state'] ) ); ?>">
                <?php echo esc_html( $office['state'] ); ?>
            </span>
            <h3 class="location-city">
                <a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $office['market_name'] ); ?></a>
            </h3>
            <address>
                <?php echo esc_html( $office['street'] ); ?><br>
                <?php echo esc_html( $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] ); ?>
            </address>
            <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="location-phone">
                <?php echo esc_html( $office['phone'] ); ?>
            </a>
            <a href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: office market name. */ __( 'View %s office', 'roden-law' ), $office['market_name'] ) ); ?>" class="location-link"><?php esc_html_e( 'View Office', 'roden-law' ); ?> &rarr;</a>
        </div>
        <?php
    }
    echo '</div>';
}

/* ==========================================================================
   LOCATION MATRIX — 6-office grid with intersection links per practice area
   ========================================================================== */

/**
 * Render the location matrix showing all 6 offices with links
 * to the intersection page for the current (or specified) practice area.
 *
 * @param int|null $pillar_id Practice area pillar post ID (defaults to current or parent).
 */
function roden_location_matrix( $pillar_id = null ) {
    if ( ! $pillar_id ) {
        $post = get_post();
        $pillar_id = $post->post_parent ? $post->post_parent : $post->ID;
    }

    $pillar      = get_post( $pillar_id );
    $pillar_slug = $pillar ? $pillar->post_name : '';
    $firm        = roden_firm_data();

    echo '<div class="location-matrix">';
    echo '<h3 class="matrix-title">' . sprintf(
        /* translators: %s: practice area title, e.g. "Car Accident Lawyers". */
        esc_html__( '%s by Location', 'roden-law' ),
        esc_html( $pillar ? $pillar->post_title : '' )
    ) . '</h3>';
    echo '<div class="matrix-grid">';

    foreach ( $firm['offices'] as $key => $office ) {
        $intersection_url = home_url( '/' . $pillar_slug . '/' . $office['slug'] . '/' );
        ?>
        <a href="<?php echo esc_url( $intersection_url ); ?>" class="matrix-card">
            <span class="matrix-state state-<?php echo esc_attr( strtolower( $office['state'] ) ); ?>">
                <?php echo esc_html( $office['state'] ); ?>
            </span>
            <span class="matrix-city"><?php echo esc_html( $office['market_name'] ); ?></span>
            <span class="matrix-phone"><?php echo esc_html( $office['phone'] ); ?></span>
        </a>
        <?php
    }

    echo '</div>';
    echo '</div>';
}

/* ==========================================================================
   PRACTICE AREAS GRID
   ========================================================================== */

function roden_practice_areas_grid( $columns = 4 ) {
    $featured_slugs = array(
        'car-accident-lawyers',
        'truck-accident-lawyers',
        'motorcycle-accident-lawyers',
        'pedestrian-accident-lawyers',
    );

    $featured = array(
        __( 'Car Accident Lawyers', 'roden-law' )        => 'car-accident-lawyers',
        __( 'Truck Accident Lawyers', 'roden-law' )      => 'truck-accident-lawyers',
        __( 'Motorcycle Accident Lawyers', 'roden-law' ) => 'motorcycle-accident-lawyers',
        __( 'Pedestrian Accident Lawyers', 'roden-law' ) => 'pedestrian-accident-lawyers',
    );

    // ES pillars live under 'es-'-prefixed slugs (inc/i18n.php §4), so look up
    // the prefixed slugs on a Spanish request and build Spanish URLs below.
    $lang  = function_exists( 'roden_current_lang' ) ? roden_current_lang() : 'en';
    $is_es = ( 'es' === $lang );

    // Try to load from CPT posts.
    $areas = get_posts( array(
        'post_type'      => 'practice_area',
        'posts_per_page' => -1,
        'post_parent'    => 0,
        'post_name__in'  => $is_es
            ? array_map( function ( $s ) { return 'es-' . $s; }, $featured_slugs )
            : $featured_slugs,
        'orderby'        => 'post_name__in',
        'order'          => 'ASC',
    ) );

    echo '<div class="practice-areas-grid cols-' . intval( $columns ) . '">';

    if ( ! empty( $areas ) ) {
        foreach ( $areas as $area ) {
            ?>
            <a href="<?php echo esc_url( get_permalink( $area ) ); ?>" class="practice-area-card">
                <?php if ( has_post_thumbnail( $area ) ) : ?>
                    <?php echo get_the_post_thumbnail( $area, 'card-thumb', array( 'class' => 'pa-thumb' ) ); ?>
                <?php endif; ?>
                <span class="pa-name"><?php echo esc_html( $area->post_title ); ?></span>
            </a>
            <?php
        }
    } else {
        // Fallback if no CPT posts exist yet.
        foreach ( $featured as $name => $slug ) {
            $url = function_exists( 'roden_lang_home_url' )
                ? roden_lang_home_url( $lang, '/practice-areas/' . $slug . '/' )
                : home_url( '/practice-areas/' . $slug . '/' );
            echo '<a href="' . esc_url( $url ) . '" class="practice-area-card">';
            echo '<span class="pa-name">' . esc_html( $name ) . '</span>';
            echo '</a>';
        }
    }

    // "Other" catch-all link — the hub for this locale.
    $archive_url = function_exists( 'roden_lang_home_url' )
        ? roden_lang_home_url( $lang, '/practice-areas/' )
        : home_url( '/practice-areas/' );
    echo '<a href="' . esc_url( $archive_url ) . '" class="practice-area-card">';
    echo '<span class="pa-name">' . esc_html__( 'Other Personal Injury Types', 'roden-law' ) . '</span>';
    echo '</a>';

    echo '</div>';
}

/* ==========================================================================
   INTERSECTION GRID — Practice areas linked to office-specific pages
   ========================================================================== */

/**
 * Render a grid of all 18 practice areas linking to intersection pages
 * for a specific office. Used on location pages instead of the generic
 * practice areas grid.
 *
 * @param string $office_key Office key (e.g., 'savannah', 'charleston').
 * @param int    $columns    Number of grid columns (default 3).
 */
function roden_intersection_grid( $office_key, $columns = 3 ) {
    $firm = roden_firm_data();

    /*
     * Resolve through roden_market() rather than indexing $firm['offices'].
     * A service-area town has its own intersection pages — Spartanburg has four —
     * and indexing offices only meant this grid could never link to them. On a
     * town page it would either bail, or (once callers passed the parent office
     * key) advertise the PARENT city's pages under the town's heading.
     */
    $office = function_exists( 'roden_market' ) ? roden_market( $office_key ) : null;
    if ( ! $office && isset( $firm['offices'][ $office_key ] ) ) {
        $office = $firm['offices'][ $office_key ];
    }

    if ( ! $office ) {
        return;
    }

    $office_slug = $office['slug']; // e.g. 'savannah-ga', 'spartanburg-sc'

    // All 22 pillar slug => label pairs (fallback).
    $pa_labels = array(
        'car-accident-lawyers'              => __( 'Car Accident Lawyers', 'roden-law' ),
        'truck-accident-lawyers'             => __( 'Truck Accident Lawyers', 'roden-law' ),
        'slip-and-fall-lawyers'              => __( 'Slip & Fall Lawyers', 'roden-law' ),
        'motorcycle-accident-lawyers'        => __( 'Motorcycle Accident Lawyers', 'roden-law' ),
        'medical-malpractice-lawyers'        => __( 'Medical Malpractice Lawyers', 'roden-law' ),
        'wrongful-death-lawyers'             => __( 'Wrongful Death Lawyers', 'roden-law' ),
        'workers-compensation-lawyers'       => __( 'Workers\' Compensation Lawyers', 'roden-law' ),
        'dog-bite-lawyers'                   => __( 'Dog Bite Lawyers', 'roden-law' ),
        'brain-injury-lawyers'               => __( 'Brain Injury Lawyers', 'roden-law' ),
        'spinal-cord-injury-lawyers'         => __( 'Spinal Cord Injury Lawyers', 'roden-law' ),
        'maritime-injury-lawyers'            => __( 'Maritime Injury Lawyers', 'roden-law' ),
        'product-liability-lawyers'          => __( 'Product Liability Lawyers', 'roden-law' ),
        'boating-accident-lawyers'           => __( 'Boating Accident Lawyers', 'roden-law' ),
        'burn-injury-lawyers'                => __( 'Burn Injury Lawyers', 'roden-law' ),
        'construction-accident-lawyers'      => __( 'Construction Accident Lawyers', 'roden-law' ),
        'nursing-home-abuse-lawyers'         => __( 'Nursing Home Abuse Lawyers', 'roden-law' ),
        'premises-liability-lawyers'         => __( 'Premises Liability Lawyers', 'roden-law' ),
        'pedestrian-accident-lawyers'        => __( 'Pedestrian Accident Lawyers', 'roden-law' ),
        'bicycle-accident-lawyers'           => __( 'Bicycle Accident Lawyers', 'roden-law' ),
        'electric-scooter-accident-lawyers'  => __( 'Electric Scooter Accident Lawyers', 'roden-law' ),
        'atv-side-by-side-accident-lawyers'  => __( 'ATV & Side-by-Side Accident Lawyers', 'roden-law' ),
        'golf-cart-accident-lawyers'         => __( 'Golf Cart Accident Lawyers', 'roden-law' ),
        'e-bike-accident-lawyers'            => __( 'E-Bike Accident Lawyers', 'roden-law' ),
    );

    // Locale of the request. ES pillars are stored under 'es-'-prefixed slugs
    // (inc/i18n.php §4), so every slug lookup and every URL below has to be
    // built for the right language — this grid is the location template's main
    // practice-area module, and hardcoding home_url() had it linking all 22
    // English pillars from every /es/ office page.
    $lang      = function_exists( 'roden_current_lang' ) ? roden_current_lang() : 'en';
    $is_es     = ( 'es' === $lang );
    $slug_for  = function ( $slug ) use ( $is_es ) {
        return $is_es ? 'es-' . $slug : $slug;
    };

    // Try to load pillar posts from the DB for titles + thumbnails.
    $pillar_posts = get_posts( array(
        'post_type'      => 'practice_area',
        'posts_per_page' => -1,
        'post_parent'    => 0,
        'post_name__in'  => array_map( $slug_for, array_keys( $pa_labels ) ),
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ) );

    // Index by public slug (the 'es-' prefix is internal only) for lookup.
    $pillar_map = array();
    foreach ( $pillar_posts as $p ) {
        $key = function_exists( 'roden_strip_es_slug' ) ? roden_strip_es_slug( $p->post_name ) : $p->post_name;
        $pillar_map[ $key ] = $p;
    }

    // Check which pillars have intersection pages for this office. ES
    // intersections keep the plain city slug — only pillars are prefixed —
    // so post_name__in matches in both locales.
    $intersection_check_args = array(
        'post_type'      => 'practice_area',
        'posts_per_page' => -1,
        'post_name__in'  => array( $office_slug ),
        'fields'         => 'id=>parent',
    );
    if ( function_exists( 'roden_locale_meta_query' ) ) {
        $intersection_check_args['meta_query'] = roden_locale_meta_query();
    }
    /*
     * NOTE: 'fields' => 'id=>parent' makes get_posts() return array( ID => parent ID )
     * — plain integers, NOT post objects. The previous loop read $ic->post_parent
     * on an integer, so $parent_slug was always empty and this map was always
     * EMPTY. Every location and neighbourhood page therefore linked its
     * "Cases We Handle" cards to the generic pillar instead of the city's own
     * intersection page, silently, on ~219 pages. Verified against production:
     * the buggy loop produced 0 entries where the corrected one produces 30.
     */
    $intersection_check = get_posts( $intersection_check_args );
    $pillars_with_intersection = array();
    foreach ( $intersection_check as $ic_id => $ic_parent_id ) {
        $parent_slug = get_post_field( 'post_name', $ic_parent_id );
        if ( $parent_slug ) {
            // Parent of an ES intersection is 'es-car-accident-lawyers'; key the
            // map on the public slug so it lines up with $pa_labels.
            if ( function_exists( 'roden_strip_es_slug' ) ) {
                $parent_slug = roden_strip_es_slug( $parent_slug );
            }
            $pillars_with_intersection[ $parent_slug ] = true;
        }
    }

    echo '<div class="practice-areas-grid cols-' . intval( $columns ) . '">';

    foreach ( $pa_labels as $slug => $fallback_label ) {
        // Link to intersection page if it exists, otherwise fall back to pillar
        // page. roden_lang_home_url() prefixes /es/ on Spanish requests; the
        // permalink filter already maps ES posts to their public URL.
        if ( isset( $pillars_with_intersection[ $slug ] ) ) {
            $url = function_exists( 'roden_lang_home_url' )
                ? roden_lang_home_url( $lang, '/' . $slug . '/' . $office_slug . '/' )
                : home_url( '/' . $slug . '/' . $office_slug . '/' );
        } elseif ( isset( $pillar_map[ $slug ] ) ) {
            $url = get_permalink( $pillar_map[ $slug ] );
        } elseif ( $is_es ) {
            // No Spanish pillar for this practice area yet. Linking the English
            // one would put the reader back in the wrong language, so skip the
            // card entirely — the gap is the signal to build the page.
            continue;
        } else {
            $url = home_url( '/practice-areas/' . $slug . '/' );
        }
        $label = isset( $pillar_map[ $slug ] ) ? $pillar_map[ $slug ]->post_title : $fallback_label;
        ?>
        <a href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: 1: practice area, 2: office market name. */ __( '%1$s — %2$s', 'roden-law' ), $label, $office['market_name'] ) ); ?>" class="practice-area-card">
            <?php if ( isset( $pillar_map[ $slug ] ) && has_post_thumbnail( $pillar_map[ $slug ] ) ) : ?>
                <?php echo get_the_post_thumbnail( $pillar_map[ $slug ], 'card-thumb', array( 'class' => 'pa-thumb' ) ); ?>
            <?php endif; ?>
            <span class="pa-name"><?php echo esc_html( $label ); ?></span>
        </a>
        <?php
    }

    echo '</div>';
}

/* ==========================================================================
   NEIGHBORHOOD SIBLING GRID
   ========================================================================== */

/**
 * Output neighborhood sibling grid.
 * Displays all sibling neighborhood pages under the same parent location.
 *
 * @param int $current_post_id Current neighborhood post ID.
 */
function roden_neighborhood_grid( $current_post_id ) {
    $parent_id = wp_get_post_parent_id( $current_post_id );
    if ( ! $parent_id ) {
        return;
    }

    $sibling_args = array(
        'post_type'      => 'location',
        'post_parent'    => $parent_id,
        'posts_per_page' => -1,
        'post__not_in'   => array( $current_post_id ),
        'meta_key'       => '_roden_is_neighborhood',
        'meta_value'     => '1',
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    );
    if ( function_exists( 'roden_locale_meta_query' ) ) {
        $sibling_args['meta_query'] = roden_locale_meta_query();
    }
    $siblings = get_posts( $sibling_args );

    if ( empty( $siblings ) ) {
        return;
    }

    echo '<div class="roden-neighborhood-grid">';
    foreach ( $siblings as $sibling ) {
        $pop = get_post_meta( $sibling->ID, '_roden_neighborhood_population', true );
        printf(
            '<a href="%s" class="neighborhood-card">
                <span class="neighborhood-name">%s</span>
                %s
                <span class="neighborhood-arrow">&rarr;</span>
            </a>',
            esc_url( get_permalink( $sibling->ID ) ),
            esc_html( $sibling->post_title ),
            $pop ? '<span class="neighborhood-pop">' . sprintf( /* translators: %s: neighborhood population figure. */ esc_html__( 'Pop. %s', 'roden-law' ), esc_html( $pop ) ) . '</span>' : ''
        );
    }
    echo '</div>';
}

/* ==========================================================================
   CONTACT FORM SIDEBAR (CTA box)
   ========================================================================== */

function roden_contact_form_sidebar( $local_phone = '', $source = '' ) {
    ?>
    <div class="sidebar-contact-form">
        <h3 class="form-title"><?php esc_html_e( 'Free Case Review', 'roden-law' ); ?></h3>
        <?php $rf_stats = roden_firm_data(); ?>
        <p class="form-subtitle"><?php esc_html_e( 'No fees unless we win', 'roden-law' ); ?><br><?php printf( /* translators: %d: rounded live Google review count, e.g. 170. */ esc_html__( '%d+ verified Google reviews', 'roden-law' ), (int) $rf_stats['trust_stats']['review_count_rounded'] ); ?></p>
        <form class="roden-sidebar-form" id="roden-sidebar-form" novalidate>
            <?php wp_nonce_field( 'roden_sidebar_form', 'roden_form_nonce' ); ?>
            <input type="hidden" name="gclid" class="roden-gclid" value="">
            <input type="hidden" name="lang" value="<?php echo esc_attr( function_exists( 'roden_current_lang' ) ? roden_current_lang() : 'en' ); ?>">
            <?php if ( $source ) : ?>
            <input type="hidden" name="source" value="<?php echo esc_attr( $source ); ?>">
            <?php endif; ?>
            <div style="position:absolute;left:-9999px;" aria-hidden="true">
                <input type="text" name="website_url" tabindex="-1" autocomplete="off">
            </div>
            <div class="rsf-row rsf-half">
                <div>
                    <label for="rsf-first-name" class="screen-reader-text"><?php esc_html_e( 'First Name', 'roden-law' ); ?></label>
                    <input type="text" name="first_name" id="rsf-first-name" placeholder="<?php esc_attr_e( 'First Name', 'roden-law' ); ?>" autocomplete="given-name" required>
                </div>
                <div>
                    <label for="rsf-last-name" class="screen-reader-text"><?php esc_html_e( 'Last Name', 'roden-law' ); ?></label>
                    <input type="text" name="last_name" id="rsf-last-name" placeholder="<?php esc_attr_e( 'Last Name', 'roden-law' ); ?>" autocomplete="family-name" required>
                </div>
            </div>
            <label for="rsf-phone" class="screen-reader-text"><?php esc_html_e( 'Phone Number', 'roden-law' ); ?></label>
            <input type="tel" name="phone" id="rsf-phone" placeholder="(555) 555-5555" autocomplete="tel" required>
            <label for="rsf-email" class="screen-reader-text"><?php esc_html_e( 'Email Address', 'roden-law' ); ?></label>
            <input type="email" name="email" id="rsf-email" placeholder="<?php esc_attr_e( 'Email', 'roden-law' ); ?>" autocomplete="email" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" required>
            <label for="rsf-message" class="screen-reader-text"><?php esc_html_e( 'Describe what happened', 'roden-law' ); ?></label>
            <textarea name="message" id="rsf-message" placeholder="<?php esc_attr_e( 'Please describe what happened', 'roden-law' ); ?>" rows="8"></textarea>
            <label class="rsf-consent">
                <input type="checkbox" name="consent" value="1" checked required>
                <span><?php
                    printf(
                        /* translators: %s: link to the Terms & Privacy Policy page. */
                        wp_kses( __( 'I hereby expressly consent to receive automated communications including calls, texts, emails, and/or prerecorded messages. By submitting this form, you agree to our %s.', 'roden-law' ), array( 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ) ) ),
                        '<a href="' . esc_url( home_url( '/terms-privacy-policy/' ) ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Terms &amp; Privacy Policy', 'roden-law' ) . '</a>'
                    );
                ?></span>
            </label>
            <button type="submit" class="rsf-submit-btn"><?php esc_html_e( 'See If You Qualify', 'roden-law' ); ?></button>
            <p class="rsf-error" style="display:none;"></p>
        </form>
        <p class="form-disclaimer"><?php esc_html_e( 'Results may vary depending on your particular facts and legal circumstances.', 'roden-law' ); ?></p>
    </div>
    <?php
}

/* ==========================================================================
   INLINE CTA BANNER (mid-content)
   ========================================================================== */

function roden_inline_cta_banner() {
    $firm = roden_firm_data();
    ?>
    <div class="inline-cta-banner">
        <div class="cta-text">
            <strong><?php esc_html_e( 'Free Case Review — No Fees Unless We Win', 'roden-law' ); ?></strong>
            <span><?php esc_html_e( 'Available 24/7 · Georgia & South Carolina', 'roden-law' ); ?></span>
        </div>
        <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary"><?php echo esc_html( $firm['phone'] ); ?></a>
    </div>
    <?php
}

/* ==========================================================================
   TRUST STATS BAR
   ========================================================================== */

function roden_stats_bar() {
    $firm  = roden_firm_data();
    $stats = array(
        array( 'num' => $firm['recovered'],     'label' => __( 'Recovered for Clients', 'roden-law' ) ),
        array( 'num' => $firm['rating'] . '★',  'label' => __( 'Client Rating', 'roden-law' ) ),
        array( 'num' => $firm['cases_handled'], 'label' => __( 'Cases Handled', 'roden-law' ) ),
    );
    echo '<div class="stats-bar">';
    foreach ( $stats as $s ) {
        echo '<div class="stat-item">';
        echo '<span class="stat-num">' . esc_html( $s['num'] ) . '</span>';
        echo '<span class="stat-label">' . esc_html( $s['label'] ) . '</span>';
        echo '</div>';
    }
    echo '</div>';
}

/* ==========================================================================
   LAST UPDATED DATE (AI Freshness Signal)
   ========================================================================== */

/**
 * Output a visible "Last Updated" date for AI freshness signals.
 * AI systems weight recency heavily — pages with visible dates get cited more.
 *
 * @param int|null $post_id Post ID (defaults to current).
 */
function roden_last_updated_date( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $modified = get_the_modified_date( 'F j, Y', $post_id );
    if ( ! $modified ) {
        return;
    }
    echo '<p class="last-updated">';
    echo '<time datetime="' . esc_attr( get_the_modified_date( 'c', $post_id ) ) . '">';
    echo esc_html__( 'Last updated:', 'roden-law' ) . ' ' . esc_html( $modified );
    echo '</time>';
    echo '</p>';
}

/* ==========================================================================
   AI DEFINITION BLOCK (Extractable Answer Block)
   ========================================================================== */

/**
 * Output a structured definition block optimized for AI snippet extraction.
 * Renders a 40-60 word direct-answer paragraph that AI systems can extract
 * as a standalone response to "What is [practice area]?" queries.
 *
 * @param string $practice_area_title The practice area title (e.g., "Car Accident Lawyers").
 * @param string $custom_definition   Optional custom definition text from post meta.
 */
function roden_ai_definition_block( $practice_area_title, $custom_definition = '', $place = '' ) {
    if ( $custom_definition ) {
        $definition = $custom_definition;
    } else {
        $definition = get_the_excerpt();
    }

    if ( ! $definition ) {
        return;
    }

    // Build a clean label for the H2. Delegates to roden_pa_noun() rather than
    // repeating the suffix strip, which was English-only and left Spanish pages
    // reading "¿Qué Es un Caso de Abogados de Compensación Laboral?".
    $label = roden_pa_noun( $practice_area_title );
    $label = rtrim( $label, ' -' );

    // Author attribution for "According to" framing (+30% AI visibility).
    $author_id   = get_post_meta( get_the_ID(), '_roden_author_attorney', true );
    $author_name = '';
    $author_title = '';
    if ( $author_id ) {
        $atty = get_post( $author_id );
        if ( $atty && 'publish' === $atty->post_status ) {
            $author_name  = $atty->post_title;
            $author_title = get_post_meta( $atty->ID, '_roden_atty_title', true );
        }
    }
    ?>
    <div class="ai-definition-block" data-ai-extractable="true">
        <h2><?php
        // On intersection pages the title is "<Area> Lawyers in <City>, <ST>",
        // so the trailing-suffix strip above cannot reach the role word and the
        // heading renders "What Is a Workers' Compensation Lawyers in Savannah,
        // GA Case?". Callers pass the place separately to avoid that.
        if ( $place ) {
            printf(
                /* translators: 1: practice area label, e.g. "Workers' Compensation"; 2: place, e.g. "Savannah, GA". */
                esc_html__( 'What Is a %1$s Case in %2$s?', 'roden-law' ),
                esc_html( $label ),
                esc_html( $place )
            );
        } else {
            printf( /* translators: %s: practice area label, e.g. "Car Accident". */ esc_html__( 'What Is a %s Case?', 'roden-law' ), esc_html( $label ) );
        }
        ?></h2>
        <p class="definition-text"><?php echo wp_kses_post( $definition ); ?></p>
        <?php
        // The review date rides with the attribution rather than getting its own
        // block: "reviewed by whom" and "reviewed when" are one claim, and the
        // three practice-area templates all reach it through this function, so
        // it lands on pillar, intersection and sub-type without touching them
        // individually. Rendered even when no attorney is set, because the date
        // is meaningful on its own and 81 practice-area pages carry one.
        $reviewed_html = roden_last_reviewed_html();
        if ( $author_name || $reviewed_html ) : ?>
            <p class="definition-attribution">
                <?php
                if ( $author_name ) {
                    echo '— ';
                    printf(
                        /* translators: 1: attorney name (bold), 2: attorney title. */
                        $author_title ? esc_html__( 'Reviewed by %1$s, %2$s at Roden Law', 'roden-law' ) : esc_html__( 'Reviewed by %1$s at Roden Law', 'roden-law' ),
                        '<strong>' . esc_html( $author_name ) . '</strong>',
                        esc_html( $author_title )
                    );
                }
                if ( $reviewed_html ) {
                    echo $author_name ? ' · ' : '— ';
                    echo $reviewed_html; // escaped in roden_last_reviewed_html()
                }
                ?>
            </p>
        <?php endif; ?>
    </div>
    <?php
}

/* ==========================================================================
   WHAT TO DO AFTER [ACCIDENT TYPE] (Structured Steps for AI Extraction)
   ========================================================================== */

/**
 * Output structured "What to Do" steps for intersection/practice area pages.
 * These step-by-step blocks are highly citable by AI systems for
 * "what to do after [accident type] in [city]" queries.
 *
 * @param string $accident_type e.g., "a car accident"
 * @param string $city          e.g., "Savannah, GA"
 * @param string $state_full    e.g., "Georgia"
 */
/**
 * Render the sidebar "Filing Deadlines" badge widget, resolver-driven.
 *
 * The pillar and sub-type templates each carried a byte-identical copy of this
 * markup with the year values HARDCODED as "2 yr" / "3 yr" — the tort statutes
 * of limitation. On a workers' comp page that told a Georgia worker they had
 * two years to file when O.C.G.A. § 34-9-82 gives them one, directly
 * contradicting the correct figure in the same page's main content.
 *
 * That is the same defect the 2026-07-30 pass set out to remove; it survived
 * because the conversion covered the main-content deadline sections and missed
 * this widget in two of the four templates. Hence one shared renderer.
 *
 * The intersection template keeps its own single-state variant: it is already
 * resolver-driven and its heading names the state ("Georgia Filing Deadline"),
 * so it is deliberately not folded in here.
 *
 * @param string[] $state_keys Two-letter state keys to show, e.g. array( 'GA', 'SC' ).
 */
function roden_deadline_badges_sidebar( $state_keys ) {
    $resolved = array();
    foreach ( (array) $state_keys as $key ) {
        $statute = roden_resolve_statute( $key );
        if ( $statute ) {
            $resolved[ strtoupper( $key ) ] = $statute;
        }
    }

    if ( ! $resolved ) {
        return;
    }

    $multi = count( $resolved ) > 1;
    ?>
    <div class="sidebar-widget sidebar-deadlines">
        <h3 class="widget-title">&#9201; <?php esc_html_e( 'Filing Deadlines', 'roden-law' ); ?></h3>
        <div class="deadline-badges">
            <?php foreach ( $resolved as $key => $statute ) : ?>
                <div class="deadline-badge <?php echo ( 'GA' === $key ) ? 'deadline-ga' : 'deadline-sc'; ?>">
                    <span class="deadline-years"><?php
                        // Same msgid for both forms: English reads "1 yr" / "2 yr"
                        // either way, but Spanish needs año/años.
                        printf(
                            /* translators: %s: number of years. */
                            esc_html( _n( '%s yr', '%s yr', (int) $statute['statute_years'], 'roden-law' ) ),
                            esc_html( $statute['statute_years'] )
                        );
                    ?></span>
                    <span class="deadline-state"><?php echo esc_html( $statute['state_full'] ); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <?php foreach ( $resolved as $statute ) : ?>
            <p class="deadline-cite"><?php
                // Two-state widgets need the citation labelled, or it is unclear
                // which state each belongs to.
                echo esc_html( $multi ? $statute['state_full'] . ': ' . $statute['statute_cite'] : $statute['statute_cite'] );
            ?></p>
            <?php if ( $statute['notice_label'] && $statute['notice_detail'] ) : ?>
                <p class="deadline-notice">
                    <strong><?php echo esc_html( $statute['notice_label'] ); ?>:</strong>
                    <?php echo esc_html( $statute['notice_detail'] ); ?>
                </p>
            <?php endif; ?>
        <?php endforeach; ?>
        <p class="deadline-warning"><?php esc_html_e( 'Missing the deadline forfeits your right to recover.', 'roden-law' ); ?></p>
    </div>
    <?php
}

/**
 * Map a page's jurisdiction meta to the state keys its sidebar should show.
 *
 * @param string $jurisdiction 'ga' | 'sc' | 'both' (case-insensitive).
 * @return string[] State keys.
 */
function roden_jurisdiction_state_keys( $jurisdiction ) {
    $jurisdiction = strtolower( (string) $jurisdiction );

    if ( 'ga' === $jurisdiction ) {
        return array( 'GA' );
    }
    if ( 'sc' === $jurisdiction ) {
        return array( 'SC' );
    }

    return array( 'GA', 'SC' );
}

/**
 * Prefix an accident phrase with the correct indefinite article.
 *
 * "car accident" → "a car accident"; "injury" → "an injury". Already-articled
 * phrases pass through untouched.
 *
 * @param string $phrase Lowercase accident phrase.
 * @return string Phrase with a leading article.
 */
function roden_what_to_do_article( $phrase ) {
    $phrase = (string) $phrase;
    if ( '' === $phrase ) {
        return $phrase;
    }
    if ( 0 === strpos( $phrase, 'a ' ) || 0 === strpos( $phrase, 'an ' ) ) {
        return $phrase;
    }
    $vowels = array( 'a', 'e', 'i', 'o', 'u' );
    return ( in_array( strtolower( $phrase[0] ), $vowels, true ) ? 'an ' : 'a ' ) . $phrase;
}

/**
 * Resolve the "What to Do" heading/step context for a practice-area post.
 *
 * The three practice-area templates each derived these four values inline, and
 * the HowTo emitter in schema-helpers.php held a fourth copy of the
 * intersection derivation. That duplication is why the visible steps and the
 * structured data drifted apart once already. This is now the single source:
 * templates render from it and the schema emitter reads the same values, so a
 * page and its HowTo cannot disagree.
 *
 * @param int|null $post_id Post ID (defaults to current post).
 * @return array|null array{accident_phrase,city,state_full,state_key}, or null.
 */
function roden_what_to_do_context( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $post = get_post( $post_id );
    if ( ! $post ) {
        return null;
    }

    $ctx = array(
        'accident_phrase'       => '',
        'accident_phrase_lower' => '',
        'city'                  => '',
        'state_full'            => '',
        'state_key'             => '',
    );

    $firm         = roden_firm_data();
    $is_es        = function_exists( 'roden_current_lang' ) && 'es' === roden_current_lang();
    $parent_post  = $post->post_parent ? get_post( $post->post_parent ) : null;
    $parent_title = $parent_post ? $parent_post->post_title : '';

    // ── Intersection: market key decides, matching single-practice_area.php's router.
    // roden_market() resolves offices and service-area towns alike; indexing
    // $firm['offices'] here would leave every town page without its context.
    $office_key = get_post_meta( $post_id, '_roden_pa_office_key', true );
    $office     = $office_key ? roden_market( $office_key ) : null;

    if ( $office ) {
        // ES intersections seed _roden_accident_phrase ("un accidente de auto")
        // because the English article/suffix derivation doesn't apply to them.
        $phrase = get_post_meta( $post_id, '_roden_accident_phrase', true );
        if ( ! $phrase && ! $is_es ) {
            $phrase = roden_pa_accident_phrase();
        }
        if ( ! $phrase ) {
            if ( $is_es || ! $parent_title ) {
                $phrase = __( 'an accident', 'roden-law' );
            } else {
                $phrase = roden_what_to_do_article( str_replace( ' Lawyers', '', $parent_title ) );
            }
        }
        $ctx['accident_phrase'] = $phrase;
        $ctx['city']            = $office['market_name'] . ', ' . $office['state'];
        $ctx['state_full']      = $office['state_full'];
        $ctx['state_key']       = $office['state'];
        return roden_what_to_do_context_finish( $ctx );
    }

    // ── Sub-type: any other child post.
    if ( $post->post_parent ) {
        $label = preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', get_the_title( $post_id ) );
        // Sub-type titles are case types, not events, so the derivation yields
        // "a Savannah Port Worker Injury". Practice areas that define an event
        // phrase override it.
        $ctx['accident_phrase'] = roden_pa_accident_phrase(
            '',
            $is_es ? $label : roden_what_to_do_article( $label )
        );

        // Statutory schemes (workers' comp) are no-fault and run on their own
        // deadlines, so the steps need the state; tort sub-types stay generic.
        $jur       = strtolower( (string) ( get_post_meta( $post_id, '_roden_jurisdiction', true ) ?: 'both' ) );
        $state_key = ( 'sc' === $jur ) ? 'SC' : 'GA';
        $statute   = roden_resolve_statute( $state_key );
        $ctx['state_key'] = ( $statute && ! empty( $statute['is_override'] ) ) ? $state_key : '';
        return roden_what_to_do_context_finish( $ctx );
    }

    // ── Pillar: two-state, so no city and no state-specific deadlines.
    //
    // Pillar titles are already title-cased ("Car Accident Lawyers"). Lowercasing
    // them here and leaning on ucfirst() is what produced "What to Do After Car
    // accident" — no article and a sentence-cased noun. roden_pa_noun() strips
    // the role word in both languages, including the Spanish leading "Abogados
    // de ", which otherwise left every ES pillar reading "Qué Hacer Después de
    // Abogados de Accidentes de Auto" — "what to do after car accident lawyers".
    $label = roden_pa_noun( '', $post_id );

    // Spanish takes a bare plural after "de" ("Después de Accidentes de Auto");
    // an English-style indefinite article would be wrong, and the gender needed
    // to pick un/una is not derivable from the title.
    $ctx['accident_phrase'] = roden_pa_accident_phrase(
        '',
        $is_es ? $label : roden_what_to_do_article( $label )
    );

    return roden_what_to_do_context_finish( $ctx );
}

/**
 * Fill in the lowercase variant of the resolved accident phrase.
 *
 * Headings want "a Rear-End Collision"; the negligence and damages sentences
 * on sub-type pages want it mid-prose as "a rear-end collision".
 *
 * @param array $ctx Context array with accident_phrase set.
 * @return array Same array with accident_phrase_lower filled in.
 */
function roden_what_to_do_context_finish( $ctx ) {
    $phrase = $ctx['accident_phrase'];
    $ctx['accident_phrase_lower'] = function_exists( 'mb_strtolower' )
        ? mb_strtolower( $phrase, 'UTF-8' )
        : strtolower( $phrase );

    return $ctx;
}

/**
 * Build the ordered "what to do" step list for a practice area.
 *
 * Split out of roden_what_to_do_steps() so the visible list and the HowTo
 * structured data in schema-helpers.php render from ONE source. They used to
 * be independent, which let the schema drift from the page.
 *
 * The default set is the car-accident sequence this function has always
 * emitted. Practice areas whose real-world process differs materially — comp
 * claims run through a state board, not an auto insurer — supply their own.
 *
 * @param string $pa_slug    Pillar slug. Empty = detect from current post.
 * @param string $state_full State name for interpolation, e.g. "Georgia".
 * @param string $state_key  Two-letter state key. Empty = derive from $state_full.
 * @return array List of array{title:string, body:string}.
 */
function roden_what_to_do_steps_data( $pa_slug = '', $state_full = '', $state_key = '' ) {
    if ( '' === $pa_slug ) {
        $pa_slug = roden_current_pa_slug();
    }

    /*
     * Spanish pillars are prefixed 'es-', so they never matched the curated
     * branches below and every Spanish page fell through to the motor-vehicle
     * default — including workers' comp, which told Spanish-speaking injured
     * workers to exchange insurance details with the other driver.
     *
     * The prefix is stripped ONLY for practice areas whose step set is actually
     * translated. The default sequence IS in es_ES.po; the other twelve curated
     * sets are not, so stripping globally would trade a translated-but-generic
     * checklist for an untranslated-but-specific one — the wrong trade on a law
     * firm's Spanish pages. Add a slug here when its set lands in the catalog.
     */
    $es_translated = apply_filters( 'roden_what_to_do_steps_es_ready', array(
        'workers-compensation-lawyers',
    ) );

    $bare_slug = preg_replace( '/^es-/', '', (string) $pa_slug );
    if ( $bare_slug !== $pa_slug && in_array( $bare_slug, $es_translated, true ) ) {
        $pa_slug = $bare_slug;
    }

    // Derive the state key when only the full name was supplied.
    if ( '' === $state_key && $state_full ) {
        $firm = roden_firm_data();
        foreach ( $firm['jurisdiction'] as $key => $j ) {
            if ( $j['state_full'] === $state_full ) {
                $state_key = $key;
                break;
            }
        }
    }

    if ( 'workers-compensation-lawyers' === $pa_slug ) {
        $statute = $state_key ? roden_resolve_statute( $state_key, $pa_slug ) : null;

        $notice_detail = ( $statute && $statute['notice_detail'] )
            ? $statute['notice_detail']
            : __( 'as soon as possible — every state sets a strict notice deadline', 'roden-law' );

        $filing_venue = ( $statute && $statute['filing_venue'] )
            ? $statute['filing_venue']
            : __( 'your state workers\' compensation board', 'roden-law' );

        $filing_deadline = ( $statute && $statute['statute_years'] )
            ? sprintf(
                /* translators: 1: number of years; 2: statute citation. */
                _n( '%1$s year from the date of injury (%2$s)', '%1$s years from the date of injury (%2$s)', (int) $statute['statute_years'], 'roden-law' ),
                $statute['statute_years'],
                $statute['statute_cite']
            )
            : __( 'before your state deadline expires', 'roden-law' );

        $steps = array(
            array(
                'title' => __( 'Report the injury to your employer.', 'roden-law' ),
                'body'  => sprintf(
                    /* translators: %s: notice deadline, e.g. "within 30 days of the injury (O.C.G.A. § 34-9-80)". */
                    __( 'Notify a supervisor or HR in writing %s. This is the deadline injured workers miss most often, and missing it can bar your claim entirely.', 'roden-law' ),
                    $notice_detail
                ),
            ),
            array(
                'title' => __( 'Get medical care from an authorized physician.', 'roden-law' ),
                'body'  => __( 'Your employer should post a panel of physicians. Treating outside that panel without approval can leave you responsible for the bills and give the insurer a reason to dispute your claim — ask for the panel before you choose a doctor, except in an emergency.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Ask for the posted panel of physicians in writing.', 'roden-law' ),
                'body'  => __( 'If your employer has no valid posted panel, or refuses to provide it, you may be entitled to choose your own treating doctor. Keep a copy of the request.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Document the injury and the conditions that caused it.', 'roden-law' ),
                'body'  => __( 'Photograph the equipment, work area, and any hazard. Note who witnessed the incident and what you reported, to whom, and when. Keep copies of every form you sign.', 'roden-law' ),
            ),
            array(
                'title' => __( 'File your claim before the deadline.', 'roden-law' ),
                'body'  => sprintf(
                    /* translators: 1: filing venue; 2: filing deadline phrase. */
                    __( 'Reporting the injury to your employer is not the same as filing a claim. File with the %1$s — %2$s.', 'roden-law' ),
                    $filing_venue,
                    $filing_deadline
                ),
            ),
            array(
                'title' => __( 'Do not give a recorded statement without advice.', 'roden-law' ),
                'body'  => __( 'The insurance adjuster works for your employer\'s carrier, not for you. You are generally not required to give a recorded statement before speaking with an attorney.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Ask whether you also have a third-party claim.', 'roden-law' ),
                'body'  => __( 'Workers\' compensation does not pay for pain and suffering. If someone other than your employer contributed to the injury — a negligent driver, a contractor on site, or a defective machine\'s manufacturer — a separate claim may recover damages comp cannot. Roden Law offers free consultations.', 'roden-law' ),
            ),
        );

        /**
         * Filter the workers' compensation "what to do" steps.
         *
         * @param array  $steps     Step list.
         * @param string $state_key Two-letter state key.
         */
        return apply_filters( 'roden_what_to_do_steps_workers_comp', $steps, $state_key );
    }

    if ( 'nursing-home-abuse-lawyers' === $pa_slug ) {
        /*
         * Evidence in these cases disappears faster than in almost any other:
         * pressure sores heal or worsen, rooms get cleaned, staffing sheets and
         * camera footage are overwritten on routine retention schedules. The
         * steps are ordered to preserve proof before it is gone.
         */
        $steps = array(
            array(
                'title' => __( 'Make sure the resident is safe, then get an independent medical evaluation.', 'roden-law' ),
                'body'  => __( 'Call 911 if anyone is in immediate danger. Where you can, have the resident examined by a provider who is not employed by the facility — an outside record of the injury is far harder to dispute later.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Photograph everything today, and keep photographing.', 'roden-law' ),
                'body'  => __( 'Injuries, bruising, pressure sores, bedding, the room, and where the call button actually sits. Date every photo. Wounds heal or worsen and conditions get quietly corrected long before anyone investigates.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Report it to the facility in writing and ask for the incident report.', 'roden-law' ),
                'body'  => __( 'A verbal complaint to a nurse or aide leaves no trace. Put it in writing, keep a copy, note who you gave it to and when, and request the facility\'s own incident report.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Report it to the state as well.', 'roden-law' ),
                'body'  => __( 'In Georgia, the Healthcare Facility Regulation Division of the Department of Community Health licenses and investigates long-term care facilities; in South Carolina, the state agency that licenses the facility does. Either state can also be reached through the Long-Term Care Ombudsman and Adult Protective Services. Reports may be made anonymously, and a state investigation creates a record independent of the facility.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Request the complete records in writing.', 'roden-law' ),
                'body'  => __( 'Not just the chart — medication administration records, care plans, fall and wound assessments, and staffing schedules. Staffing levels are frequently where these cases are won, and those records are retained the shortest.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Do not sign anything the facility puts in front of you.', 'roden-law' ),
                'body'  => __( 'Admission packets routinely contain arbitration agreements that give up the right to a jury trial, and paperwork offered after an incident can release the claim entirely. Have anything you are asked to sign reviewed first.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Talk to an attorney before the trail goes cold.', 'roden-law' ),
                'body'  => __( 'Georgia requires an expert affidavit filed with the complaint in a professional negligence case (O.C.G.A. § 9-11-9.1), and South Carolina requires a Notice of Intent to File Suit with an expert affidavit before suit (S.C. Code § 15-79-125). Both take time to prepare, and both run against a deadline. Roden Law offers free consultations.', 'roden-law' ),
            ),
        );

        return apply_filters( 'roden_what_to_do_steps_nursing_home', $steps, $state_key );
    }

    if ( 'medical-malpractice-lawyers' === $pa_slug ) {
        $steps = array(
            array(
                'title' => __( 'Request your complete medical records in writing.', 'roden-law' ),
                'body'  => __( 'From every provider and facility involved, not just the one you suspect. Ask for the full file including imaging, nursing notes, and orders. In a malpractice case the records largely are the case.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Keep getting treatment — ideally from someone new.', 'roden-law' ),
                'body'  => __( 'Your health comes first, and a second opinion may catch something correctable. A gap in treatment is also one of the first things a defense expert points to when arguing an injury was not serious.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Write down what happened while you still remember it.', 'roden-law' ),
                'body'  => __( 'Dates, who you saw, what you were told before and after, and who else was in the room. The written record is authored entirely by the other side; your account is not.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Do not accept waived bills or a free corrective procedure in exchange for signing.', 'roden-law' ),
                'body'  => __( 'It is a common and entirely lawful offer. It is also sometimes paired with paperwork that ends your claim. Read what is attached, and have it reviewed before you sign it.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Be careful with risk management and insurance adjusters.', 'roden-law' ),
                'body'  => __( 'Those calls are documented and they are not made for your benefit. You are not required to give a recorded statement before speaking with an attorney.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Do not assume a bad outcome is — or is not — malpractice.', 'roden-law' ),
                'body'  => __( 'Medicine carries known risks, and a poor result on its own proves nothing. The question is whether the care fell below the accepted standard, and only a qualified expert in the same field can answer it.', 'roden-law' ),
            ),
            array(
                'title' => __( 'Contact an attorney early — the pre-suit requirements are slow.', 'roden-law' ),
                'body'  => __( 'Georgia requires an expert affidavit filed with the complaint (O.C.G.A. § 9-11-9.1), and South Carolina requires a Notice of Intent to File Suit with an expert affidavit followed by mandatory mediation (S.C. Code § 15-79-125). Locating the right expert and obtaining that opinion routinely takes months, and Georgia\'s deadline is two years. Roden Law offers free consultations.', 'roden-law' ),
            ),
        );

        return apply_filters( 'roden_what_to_do_steps_medical_malpractice', $steps, $state_key );
    }

    /* ----------------------------------------------------------------------
       Remaining practice areas whose real-world first steps differ materially
       from the motor-vehicle sequence. Each is ordered by what decides the
       case, not by what is easiest to write.
       ---------------------------------------------------------------------- */

    $library = array();

    $library['slip-and-fall-lawyers'] = array(
        array(
            'title' => __( 'Report it before you leave, and get a written incident report.', 'roden-law' ),
            'body'  => __( 'Tell a manager or owner while you are still there and ask for a copy of the report they fill out. A fall nobody recorded is the single most common reason these claims fail.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Photograph the hazard immediately — before it is cleaned up.', 'roden-law' ),
            'body'  => __( 'The spill, ice, torn mat, broken step, or missing handrail will be gone within the hour. Capture it from several angles, and include something for scale.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Photograph what was not there, too.', 'roden-law' ),
            'body'  => __( 'Absent warning cones, burnt-out lighting, and missing handrails matter as much as the hazard itself. Photograph your footwear as well — the defense will raise it.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Get names — witnesses and the employees who responded.', 'roden-law' ),
            'body'  => __( 'Staff turnover is high in retail and hospitality. The employee who told you "that happens all the time" may be unreachable in six months.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Ask that surveillance footage be preserved, in writing.', 'roden-law' ),
            'body'  => __( 'Most systems overwrite in days or weeks. A written preservation request creates an obligation and a paper trail if the footage later goes missing.', 'roden-law' ),
        ),
        array(
            'title' => __( 'See a doctor the same day.', 'roden-law' ),
            'body'  => __( 'Adrenaline masks injuries and a delay of even a few days becomes an argument that something else caused them.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Do not give a recorded statement or accept a goodwill gesture.', 'roden-law' ),
            'body'  => __( 'A covered ER visit or a gift card is sometimes offered alongside paperwork that ends the claim. Roden Law offers free consultations — ask before you sign.', 'roden-law' ),
        ),
    );

    $library['premises-liability-lawyers'] = array(
        array(
            'title' => __( 'Report it to the property owner or manager in writing.', 'roden-law' ),
            'body'  => __( 'Ask for a copy of any incident report. Verbal notice to whoever was on shift tends to disappear.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Photograph the condition before it is repaired.', 'roden-law' ),
            'body'  => __( 'Dangerous conditions get fixed quickly once someone is hurt — which is good for everyone except your ability to prove what it looked like.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Work out who actually controlled the property.', 'roden-law' ),
            'body'  => __( 'Owner, tenant, management company, security contractor, and maintenance vendor are often five different businesses with five different insurers. Note every name and logo you see.', 'roden-law' ),
        ),
        array(
            'title' => __( 'If you were the victim of a crime on the property, get the police report.', 'roden-law' ),
            'body'  => __( 'Negligent security claims turn on whether the owner knew the area was dangerous. Prior incidents at the same address are usually the proof, and they are on record.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Request preservation of surveillance footage in writing.', 'roden-law' ),
            'body'  => __( 'Retention is often measured in days. Ask in writing and keep a copy of the request.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Get medical care and keep every record.', 'roden-law' ),
            'body'  => __( 'Follow through on referrals. Gaps in treatment are the most common way a serious injury gets valued as a minor one.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Do not sign a release or give a recorded statement.', 'roden-law' ),
            'body'  => __( 'The adjuster calling within days works for the property owner. Roden Law offers free consultations.', 'roden-law' ),
        ),
    );

    $library['dog-bite-lawyers'] = array(
        array(
            'title' => __( 'Get medical attention — bite wounds infect.', 'roden-law' ),
            'body'  => __( 'Puncture wounds close over bacteria and often need irrigation and antibiotics. Facial bites and any bite to a child warrant immediate care.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Identify the owner and get the dog\'s vaccination records.', 'roden-law' ),
            'body'  => __( 'Name, address, and insurance if they will give it. Rabies vaccination status determines whether you face a post-exposure treatment decision, and it needs answering today.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Report the bite to animal control.', 'roden-law' ),
            'body'  => __( 'This is the step people skip because they do not want the dog harmed. It also creates the official record — and the history of prior complaints that often decides the case.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Note whether the dog was loose, and photograph where it happened.', 'roden-law' ),
            'body'  => __( 'In Georgia, showing the dog was off-leash in violation of a local leash or restraint ordinance can establish liability without proving the dog had ever bitten before (O.C.G.A. § 51-2-7). South Carolina imposes liability on the owner regardless of the dog\'s history (S.C. Code § 47-3-110).', 'roden-law' ),
        ),
        array(
            'title' => __( 'Photograph the wounds as they heal, not just today.', 'roden-law' ),
            'body'  => __( 'Bite injuries scar, and scarring is a large part of the claim — particularly for children. Photograph on a consistent background at regular intervals.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Ask around about the dog\'s history.', 'roden-law' ),
            'body'  => __( 'Neighbors frequently know about earlier snaps, lunges, or complaints that never reached animal control. That knowledge is evidence.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Do not let the owner talk you out of a claim as a favor.', 'roden-law' ),
            'body'  => __( 'These claims are usually paid by homeowner\'s or renter\'s insurance, not out of the owner\'s pocket — which is exactly what that coverage exists for. Roden Law offers free consultations.', 'roden-law' ),
        ),
    );

    $library['wrongful-death-lawyers'] = array(
        array(
            'title' => __( 'Take care of your family first.', 'roden-law' ),
            'body'  => __( 'Nothing below is more urgent than that. The steps that follow exist so that decisions made in the first weeks do not quietly cost you later.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Do not let anything be repaired, scrapped, or thrown away.', 'roden-law' ),
            'body'  => __( 'The vehicle, the equipment, the product, clothing, and personal effects are evidence. Insurers move quickly to total and dispose of vehicles — say no in writing until it has been examined.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Request the official reports.', 'roden-law' ),
            'body'  => __( 'The police or incident report, and the autopsy or medical examiner\'s report. Ask for the complete file, including photographs, rather than the summary page.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Be careful with early insurance contact.', 'roden-law' ),
            'body'  => __( 'An offer that arrives before anyone knows the full picture is not generosity. Do not give a recorded statement, sign a release, or cash a settlement check without advice.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Find out who is legally entitled to bring the claim.', 'roden-law' ),
            'body'  => __( 'It is not simply whoever was closest. Georgia gives the claim first to the surviving spouse, then children, then parents, then the estate (O.C.G.A. § 51-4-2). South Carolina requires the personal representative of the estate to bring it — which means opening an estate first. Getting this wrong wastes months.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Keep the financial records.', 'roden-law' ),
            'body'  => __( 'Pay records, benefits statements, and tax returns establish what the family lost. Funeral and medical bills belong in the file too.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Speak with an attorney before the deadline runs.', 'roden-law' ),
            'body'  => __( 'The clock generally runs from the date of death, and separate claims may belong to the estate and to the family. Roden Law offers free, no-obligation consultations.', 'roden-law' ),
        ),
    );

    $library['brain-injury-lawyers'] = array(
        array(
            'title' => __( 'Get evaluated even if you never lost consciousness.', 'roden-law' ),
            'body'  => __( 'Most traumatic brain injuries do not involve blacking out. "Walked away from it" is how serious injuries go undocumented on day one.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Make sure every symptom is written into the record.', 'roden-law' ),
            'body'  => __( 'Headaches, memory lapses, word-finding trouble, sleep disruption, irritability, and light or noise sensitivity. If it is not in the chart, it effectively did not happen.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Keep a daily symptom journal.', 'roden-law' ),
            'body'  => __( 'Brain injury symptoms fluctuate, and a contemporaneous log is far more persuasive than trying to reconstruct a bad month a year later.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Ask someone close to you to write down what they notice.', 'roden-law' ),
            'body'  => __( 'Families routinely see changes in temperament, patience, and follow-through that the injured person genuinely cannot perceive. That account carries real weight.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Follow through on every referral.', 'roden-law' ),
            'body'  => __( 'Neurology, imaging, vestibular therapy, and neuropsychological testing. Missed appointments become the argument that you had recovered.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Do not give a recorded statement while you are symptomatic.', 'roden-law' ),
            'body'  => __( 'Difficulty recalling detail is a symptom of the injury. On a transcript it reads as inconsistency, and it will be used that way.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Do not settle before the prognosis is known.', 'roden-law' ),
            'body'  => __( 'Cognitive and behavioral effects can take a year or more to declare themselves, and the lifetime cost of a brain injury dwarfs the early offer. Roden Law offers free consultations.', 'roden-law' ),
        ),
    );

    $library['spinal-cord-injury-lawyers'] = array(
        array(
            'title' => __( 'Follow the acute care and rehabilitation plan.', 'roden-law' ),
            'body'  => __( 'Early rehabilitation drives long-term function. It is also the record that establishes what was lost and what was recovered.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Document function, not just diagnosis.', 'roden-law' ),
            'body'  => __( 'What you could do before and what you can do now — dressing, transfers, driving, working, caring for children. That comparison, not the imaging, is what a jury understands.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Start a running record of costs from day one.', 'roden-law' ),
            'body'  => __( 'Wheelchairs and replacements, home and vehicle modification, catheters and supplies, transport, and paid or unpaid attendant care. These are the numbers that dominate the claim.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Preserve the evidence of how it happened.', 'roden-law' ),
            'body'  => __( 'The vehicle, the equipment, the scene. Do not authorize repair or disposal until it has been examined.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Ask whether a third-party claim exists.', 'roden-law' ),
            'body'  => __( 'If the injury happened at work, workers\' compensation will not pay for pain and suffering or full lifetime care. A claim against someone other than your employer can.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Do not accept an early offer.', 'roden-law' ),
            'body'  => __( 'These cases are valued on decades of future care, and that valuation needs a life-care plan and an economist — not an adjuster\'s estimate in month three. Roden Law offers free consultations.', 'roden-law' ),
        ),
    );

    $library['maritime-injury-lawyers'] = array(
        array(
            'title' => __( 'Report the injury and make sure it is entered in the log.', 'roden-law' ),
            'body'  => __( 'Tell the captain or your supervisor, confirm it was logged, and ask for a copy. An unlogged injury becomes an injury that allegedly happened ashore.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Get medical care, and know your employer may owe it regardless of fault.', 'roden-law' ),
            'body'  => __( 'A seaman injured in the service of a vessel is generally entitled to maintenance and cure — medical treatment and basic living costs — without proving anyone did anything wrong.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Read the company accident form before you sign it.', 'roden-law' ),
            'body'  => __( 'You will often be handed a statement written by someone else describing an incident you were present for. Correct it or decline to sign until you have advice.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Photograph the conditions and note who saw it.', 'roden-law' ),
            'body'  => __( 'Deck condition, gear, lighting, weather, and staffing. Crews rotate off and become very hard to find.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Find out which law covers you — it changes everything.', 'roden-law' ),
            'body'  => __( 'Crew members generally fall under the Jones Act, with the right to sue the employer directly. Longshore, dock, and terminal workers generally fall under the federal LHWCA. Shoreside workers fall under state workers\' compensation. The three pay very differently.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Do not give a recorded statement to a company representative or insurer.', 'roden-law' ),
            'body'  => __( 'They are gathering a defense, not helping you. You are generally not required to provide one before speaking with an attorney.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Move quickly — maritime deadlines are short and vary by system.', 'roden-law' ),
            'body'  => __( 'An LHWCA claim generally requires notice within 30 days and filing within one year (33 U.S.C. § 913). Roden Law offers free consultations.', 'roden-law' ),
        ),
    );

    $library['product-liability-lawyers'] = array(
        array(
            'title' => __( 'Keep the product. Do not return it, repair it, or send it back.', 'roden-law' ),
            'body'  => __( 'This is the whole case. Manufacturers and retailers commonly offer to "inspect and replace" the item — once it leaves your hands the evidence is gone and it is generally not coming back.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Keep everything that came with it.', 'roden-law' ),
            'body'  => __( 'Box, packaging, manual, warning labels, receipt, and any recall or safety notice. Warnings — and their absence — are frequently the heart of the claim.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Photograph the product and the scene before anything is moved.', 'roden-law' ),
            'body'  => __( 'The failure itself, the surrounding area, and how it was set up or installed. Do not disassemble it to work out what went wrong.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Write down the identifying details.', 'roden-law' ),
            'body'  => __( 'Make, model, serial or lot number, where and when you bought it, and exactly how you were using it. Model-specific recalls and prior complaints can often be traced from these alone.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Get medical attention and connect the injury to the product in the record.', 'roden-law' ),
            'body'  => __( 'Tell the provider what caused it, specifically. "Burn" and "burn from a lithium battery in a scooter that ignited while charging" are very different chart entries.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Be cautious about contacting the manufacturer yourself.', 'roden-law' ),
            'body'  => __( 'Their first response is usually a request to ship the item back for analysis. Report a safety hazard if you wish, but get advice before surrendering the product.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Do not accept a refund or replacement in exchange for signing.', 'roden-law' ),
            'body'  => __( 'A check for the purchase price is sometimes paired with a release of every claim arising from the injury. Roden Law offers free consultations.', 'roden-law' ),
        ),
    );

    $library['burn-injury-lawyers'] = array(
        array(
            'title' => __( 'Get to a burn center if one is reachable.', 'roden-law' ),
            'body'  => __( 'Burn depth is routinely underestimated in a general emergency room, and early specialist treatment changes both outcome and scarring.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Preserve whatever caused it.', 'roden-law' ),
            'body'  => __( 'The heater, appliance, battery, chemical container, lighter, or vehicle part. Do not discard it, return it, or allow it to be replaced under warranty.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Photograph the injury through every stage of healing.', 'roden-law' ),
            'body'  => __( 'Burns look dramatically different at one week, three months, and a year. A consistent photographic record is one of the most valuable things you can build.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Identify the cause precisely.', 'roden-law' ),
            'body'  => __( 'Defective product, gas or propane leak, chemical exposure, electrical fault, building code violation, or a workplace process. Who is responsible follows entirely from this.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Document what the injury costs beyond the hospital bill.', 'roden-law' ),
            'body'  => __( 'Compression garments, scar treatment, reconstructive procedures, time away from work, and psychological care. Burn injuries carry a large non-medical burden that goes unclaimed when it is not recorded.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Do not settle before the scarring has stabilized.', 'roden-law' ),
            'body'  => __( 'Final appearance and the need for revision surgery are often not clear for a year or more. An early settlement closes the door on all of it. Roden Law offers free consultations.', 'roden-law' ),
        ),
    );

    $library['construction-accident-lawyers'] = array(
        array(
            'title' => __( 'Get medical attention and report the injury to your employer.', 'roden-law' ),
            'body'  => __( 'Report it in writing and keep a copy. Workers\' compensation notice deadlines are short and separate from anything else here.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Know that serious incidents must be reported to OSHA.', 'roden-law' ),
            'body'  => __( 'An employer must report a work-related fatality within 8 hours, and an in-patient hospitalization, amputation, or loss of an eye within 24 hours (29 CFR 1904.39). If that does not happen, the report can be made directly.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Photograph the site before it changes.', 'roden-law' ),
            'body'  => __( 'Scaffolding, ladders, guardrails, trench shoring, fall protection, and the equipment involved. Sites are corrected and rebuilt within hours of an injury.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Write down every company on that site.', 'roden-law' ),
            'body'  => __( 'General contractor, subcontractors, equipment owners, and delivery firms. This is the most valuable ten minutes you will spend — a claim against a company other than your employer can recover damages workers\' compensation never pays.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Get witness names and phone numbers, not just first names.', 'roden-law' ),
            'body'  => __( 'Crews move between sites and subcontractors finish and leave. A first name and "he worked for the framing crew" is not enough to find someone later.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Preserve the equipment involved.', 'roden-law' ),
            'body'  => __( 'Ask in writing that the ladder, lift, saw, or harness be kept and not returned to service or to the rental company.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Do not give a recorded statement to any insurer.', 'roden-law' ),
            'body'  => __( 'Several carriers may contact you, and none of them work for you. Workers\' compensation and a third-party claim can run in parallel — Roden Law offers free consultations.', 'roden-law' ),
        ),
    );

    if ( isset( $library[ $pa_slug ] ) ) {
        /**
         * Filter a practice area's "what to do" steps.
         *
         * @param array  $steps     Step list.
         * @param string $pa_slug   Pillar slug.
         * @param string $state_key Two-letter state key.
         */
        return apply_filters( 'roden_what_to_do_steps', $library[ $pa_slug ], $pa_slug, $state_key );
    }

    /* ----------------------------------------------------------------------
       DEFAULT — motor-vehicle / general negligence sequence.
       ---------------------------------------------------------------------- */

    $state_label = $state_full ? $state_full : __( 'State', 'roden-law' );

    $steps = array(
        array(
            'title' => __( 'Ensure safety and call 911.', 'roden-law' ),
            'body'  => __( 'Move to a safe location if possible. Call emergency services to report the accident and request medical attention for anyone injured.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Seek immediate medical attention.', 'roden-law' ),
            'body'  => __( 'Even if injuries seem minor, get examined by a doctor. Some injuries — such as traumatic brain injuries or internal bleeding — may not show symptoms immediately.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Document the scene.', 'roden-law' ),
            'body'  => __( 'Take photos of all vehicles, injuries, road conditions, traffic signs, and any visible damage. Collect names and contact information from witnesses.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Exchange information with all parties.', 'roden-law' ),
            'body'  => __( 'Get the other driver\'s name, insurance information, license plate number, and driver\'s license number. Do not admit fault or apologize.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Report the accident to police.', 'roden-law' ),
            'body'  => sprintf(
                /* translators: %s: state name, e.g. "Georgia". */
                __( '%s law requires accident reports when there are injuries or significant property damage. Request a copy of the police report.', 'roden-law' ),
                $state_label
            ),
        ),
        array(
            'title' => __( 'Notify your insurance company.', 'roden-law' ),
            'body'  => __( 'Report the accident to your insurer promptly. Provide factual information only — do not speculate about fault or the extent of your injuries.', 'roden-law' ),
        ),
        array(
            'title' => __( 'Contact an experienced personal injury attorney.', 'roden-law' ),
            'body'  => __( 'An attorney can protect your rights, handle communications with insurance companies, and help you pursue the full compensation you deserve. Roden Law offers free consultations — call today.', 'roden-law' ),
        ),
    );

    /**
     * Filter the default "what to do" steps.
     *
     * @param array  $steps   Step list.
     * @param string $pa_slug Pillar slug.
     */
    return apply_filters( 'roden_what_to_do_steps_default', $steps, $pa_slug );
}

function roden_what_to_do_steps( $accident_type, $city = '', $state_full = '', $state_key = '' ) {
    $steps = roden_what_to_do_steps_data( '', $state_full, $state_key );
    ?>
    <div class="content-section what-to-do-steps" data-ai-extractable="true">
        <h2><?php
        if ( $city ) {
            printf(
                /* translators: 1: accident type, e.g. "A Car Accident"; 2: city + state, e.g. "Savannah, GA". */
                esc_html__( 'What to Do After %1$s in %2$s', 'roden-law' ),
                esc_html( roden_accident_phrase_case( $accident_type ) ),
                esc_html( $city )
            );
        } else {
            printf(
                /* translators: %s: accident type, e.g. "A Car Accident". */
                esc_html__( 'What to Do After %s', 'roden-law' ),
                esc_html( roden_accident_phrase_case( $accident_type ) )
            );
        }
        ?></h2>
        <ol class="steps-list">
            <?php foreach ( $steps as $step ) : ?>
                <li>
                    <strong><?php echo esc_html( $step['title'] ); ?></strong>
                    <?php echo esc_html( $step['body'] ); ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
    <?php
}

/* ==========================================================================
   READING TIME
   ========================================================================== */

function roden_reading_time() {
    $content    = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( wp_strip_all_tags( $content ) );
    return max( 1, ceil( $word_count / 250 ) );
}

/**
 * States an attorney is actually admitted in.
 *
 * Reads the attorney post's own `_roden_bar_admissions` (the authoritative
 * record, one entry per line) and supplements from firm-data.php, matching how
 * schema-helpers.php builds hasCredential — so the visible byline and the
 * structured data cannot disagree.
 *
 * This exists because the byline on practice-area pages hardcoded "Licensed in
 * Georgia & South Carolina" next to whoever was named, regardless of their
 * admissions. On 2026-08-07 the firm confirmed Eric Roden is admitted in
 * Georgia only, which made that line a false credential claim on every pillar
 * page bylined to him.
 *
 * @param int $atty_id Attorney post ID.
 * @return array<string> e.g. array( 'Georgia' ) or array( 'Georgia', 'South Carolina' ).
 */
function roden_attorney_bar_states( $atty_id ) {
    $states = array();
    $raw    = (string) get_post_meta( $atty_id, '_roden_bar_admissions', true );
    foreach ( array( 'Georgia', 'South Carolina' ) as $state ) {
        if ( '' !== $raw && false !== stripos( $raw, $state ) ) {
            $states[] = $state;
        }
    }

    $firm  = function_exists( 'roden_firm_data' ) ? roden_firm_data() : array();
    $slug  = get_post_field( 'post_name', $atty_id );
    $extra = $firm['attorneys'][ $slug ]['bar_admissions'] ?? array();
    foreach ( (array) $extra as $state ) {
        if ( ! in_array( $state, $states, true ) ) {
            $states[] = $state;
        }
    }
    return $states;
}

/**
 * Visible "Updated" line, from `_roden_last_refreshed`.
 *
 * Deliberately NOT `_roden_last_reviewed`, and deliberately not worded as a
 * review. The two fields make different claims and only one of them is an
 * E-E-A-T assertion:
 *
 *   _roden_last_reviewed   an attorney checked this page. Licenses
 *                          `lastReviewed` + `reviewedBy` in schema.
 *   _roden_last_refreshed  the content was corrected or updated on this date.
 *                          Says nothing about who, and emits no reviewedBy.
 *
 * The distinction exists because pages get factual corrections far more often
 * than they get attorney review — the 2026-08-07 seat-belt fixes being the
 * case in point: the law had changed under them and the copy was wrong, but no
 * lawyer had signed off on the rewrite. Stamping those as "reviewed" would have
 * manufactured exactly the trust signal schema-helpers.php warns against, while
 * leaving them undated would hide a real and recent correction.
 *
 * Renders alongside "Last reviewed" when both are set; neither replaces the
 * other.
 *
 * @param int|null $post_id Defaults to the current post.
 * @return string Escaped HTML, or '' if no valid date is set.
 */
function roden_last_refreshed_html( $post_id = null ) {
    $post_id   = $post_id ? (int) $post_id : get_the_ID();
    $refreshed = trim( (string) get_post_meta( $post_id, '_roden_last_refreshed', true ) );
    if ( '' === $refreshed ) {
        return '';
    }

    $ts = strtotime( $refreshed );
    if ( ! $ts ) {
        return '';
    }

    $is_es = ( function_exists( 'roden_current_lang' ) && 'es' === roden_current_lang() )
        || 'es_ES' === get_locale();

    if ( $is_es ) {
        $months_es = array(
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre',
        );
        $formatted = sprintf(
            /* translators: 1: day of month, 2: month name in Spanish, 3: four-digit year. */
            _x( '%1$d de %2$s de %3$d', 'Spanish long date', 'roden-law' ),
            (int) gmdate( 'j', $ts ),
            $months_es[ (int) gmdate( 'n', $ts ) ],
            (int) gmdate( 'Y', $ts )
        );
    } else {
        $formatted = date_i18n( get_option( 'date_format' ), $ts );
    }

    return sprintf(
        '<time class="post-refreshed" datetime="%1$s">%2$s</time>',
        esc_attr( gmdate( 'Y-m-d', $ts ) ),
        esc_html(
            sprintf(
                /* translators: %s: date the content was last updated. */
                __( 'Content updated: %s', 'roden-law' ),
                $formatted
            )
        )
    );
}

/**
 * Visible "Last reviewed" line, from `_roden_last_reviewed`.
 *
 * The meta already licenses schema's `lastReviewed`/`reviewedBy` (see
 * roden_schema_review_fields), but until now nothing rendered it for a human:
 * 101 published posts carried a review date that only a crawler could see.
 *
 * `post_modified` is not a substitute, for the reason recorded in
 * schema-helpers.php — it moves on template deploys and bulk re-saves without
 * anyone having checked the law, and in July 2026 the workers' comp cluster
 * advertised timestamps up to five months stale. For YMYL legal content the
 * date an attorney actually reviewed the page is the honest freshness signal,
 * and it is one AI answer engines look for.
 *
 * Returns '' when unset or unparseable so callers can omit the element
 * entirely rather than print an empty label.
 *
 * @param int|null $post_id Defaults to the current post.
 * @return string Escaped HTML, or '' if no valid date is set.
 */
function roden_last_reviewed_html( $post_id = null ) {
    $post_id  = $post_id ? (int) $post_id : get_the_ID();
    $reviewed = trim( (string) get_post_meta( $post_id, '_roden_last_reviewed', true ) );
    if ( '' === $reviewed ) {
        return '';
    }

    $ts = strtotime( $reviewed );
    if ( ! $ts ) {
        return '';
    }

    // The label translates through the theme's `locale` filter, but the MONTH
    // NAME does not, and the obvious fix does not work. date_i18n reads
    // $wp_locale, which core builds with English months before the theme's
    // filter is in play, so /es/ rendered "Última revisión: August 3, 2026".
    // switch_to_locale( 'es_ES' ) cannot repair it: WP_Locale_Switcher returns
    // false without doing anything when the requested locale already equals
    // determine_locale(), and the theme's filter has already made that es_ES.
    // The switch silently no-ops and $wp_locale is never rebuilt — verified on
    // production before this was replaced.
    //
    // So format Spanish explicitly. Deterministic, no dependence on when core
    // happened to instantiate $wp_locale, and no locale switching mid-render.
    $is_es = ( function_exists( 'roden_current_lang' ) && 'es' === roden_current_lang() )
        || 'es_ES' === get_locale();

    if ( $is_es ) {
        $months_es = array(
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre',
        );
        $formatted = sprintf(
            /* translators: 1: day of month, 2: month name in Spanish, 3: four-digit year. */
            _x( '%1$d de %2$s de %3$d', 'Spanish long date', 'roden-law' ),
            (int) gmdate( 'j', $ts ),
            $months_es[ (int) gmdate( 'n', $ts ) ],
            (int) gmdate( 'Y', $ts )
        );
    } else {
        $formatted = date_i18n( get_option( 'date_format' ), $ts );
    }

    $label = sprintf(
        /* translators: %s: date an attorney last reviewed this page. */
        __( 'Last reviewed: %s', 'roden-law' ),
        $formatted
    );

    return sprintf(
        '<time class="post-reviewed" datetime="%1$s">%2$s</time>',
        esc_attr( gmdate( 'Y-m-d', $ts ) ),
        esc_html( $label )
    );
}

/* ==========================================================================
   FAQ ACCORDION (HTML output — FAQPage schema is JSON-LD only, in schema-helpers.php)
   ========================================================================== */

function roden_faq_section( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $faqs = get_post_meta( $post_id, '_roden_faqs', true );
    if ( ! is_array( $faqs ) || empty( $faqs ) ) {
        return;
    }

    // Opt-in grouped rendering: if any FAQ carries a 'category', render grouped
    // <h3> sections, each with its own .faq-accordion so the "close others" JS
    // scopes per group. FAQs without a category render flat (unchanged).
    $has_categories = false;
    foreach ( $faqs as $faq ) {
        if ( ! empty( $faq['category'] ) ) {
            $has_categories = true;
            break;
        }
    }

    // Shared single-item renderer — identical markup in both modes.
    $render_item = function ( $faq, $uid ) {
        if ( empty( $faq['question'] ) || empty( $faq['answer'] ) ) {
            return;
        }
        ?>
        <div class="faq-item">
            <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-<?php echo esc_attr( $uid ); ?>">
                <span><?php echo esc_html( $faq['question'] ); ?></span>
                <span class="faq-toggle" aria-hidden="true">+</span>
            </button>
            <div class="faq-answer" id="faq-answer-<?php echo esc_attr( $uid ); ?>" style="display:none;">
                <p><?php echo wp_kses_post( $faq['answer'] ); ?></p>
            </div>
        </div>
        <?php
    };
    ?>
    <div class="faq-section" id="faq" data-ai-extractable="true">
        <h2 class="section-title"><?php esc_html_e( 'Frequently Asked Questions', 'roden-law' ); ?></h2>
        <?php if ( $has_categories ) :
            // Group, preserving first-seen category order.
            $grouped = array();
            foreach ( $faqs as $faq ) {
                $cat = ! empty( $faq['category'] ) ? $faq['category'] : __( 'More Questions', 'roden-law' );
                $grouped[ $cat ][] = $faq;
            }
            $uid = 0;
            foreach ( $grouped as $cat => $items ) : ?>
                <div class="faq-category">
                    <h3 class="faq-category-title"><?php echo esc_html( $cat ); ?></h3>
                    <div class="faq-accordion">
                        <?php foreach ( $items as $faq ) { $render_item( $faq, ++$uid ); } ?>
                    </div>
                </div>
            <?php endforeach;
        else : ?>
            <div class="faq-accordion">
                <?php foreach ( $faqs as $i => $faq ) { $render_item( $faq, (int) $i ); } ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

/* ==========================================================================
   SC STATEWIDE PILLAR HUB-AND-SPOKE LINK (intersection pages → SC pillar)
   ==========================================================================
   Maps a practice-area pillar slug to its indexable SC statewide pillar URL and
   renders an "up-link" on SC intersection (PA × city) pages so the city spokes
   anchor up into the statewide hub (SC competitor gap analysis 2026-06-29,
   P0-4 hub-and-spoke). Only renders for SC offices and only when a matching SC
   pillar exists, so it is safe before the pillars are published. */

/**
 * Map a pillar slug to the indexable SC statewide pillar slug (or null).
 *
 * @param string $pillar_slug e.g. 'truck-accident-lawyers'
 * @return string|null SC statewide pillar slug, or null if none.
 */
function roden_sc_statewide_pillar_slug( $pillar_slug ) {
    $map = array(
        'car-accident-lawyers'           => 'south-carolina-car-accident-lawyer',
        'truck-accident-lawyers'         => 'south-carolina-truck-accident-lawyers',
        'motorcycle-accident-lawyers'    => 'south-carolina-motorcycle-accident-lawyer',
        'wrongful-death-lawyers'         => 'south-carolina-wrongful-death-lawyer',
        'workers-compensation-lawyers'   => 'south-carolina-workers-compensation-lawyer',
    );
    return isset( $map[ $pillar_slug ] ) ? $map[ $pillar_slug ] : null;
}

/**
 * Render the hub-and-spoke up-link to the SC statewide pillar on an SC
 * intersection page. No-op unless the office is in SC AND a published SC pillar
 * page exists for the parent pillar.
 *
 * @param array       $office      The office array (must include 'state').
 * @param string      $parent_slug The parent pillar post_name.
 * @param string      $parent_title The parent pillar title (for link text fallback).
 */
function roden_sc_statewide_uplink( $office, $parent_slug, $parent_title = '' ) {
    if ( empty( $office['state'] ) || 'SC' !== $office['state'] ) {
        return;
    }
    $sc_slug = roden_sc_statewide_pillar_slug( $parent_slug );
    if ( ! $sc_slug ) {
        return;
    }
    // Only link when the SC pillar page is actually published (avoids 404s
    // while pillars are still drafts).
    $pillar = get_page_by_path( $sc_slug, OBJECT, 'page' );
    if ( ! $pillar || 'publish' !== $pillar->post_status ) {
        return;
    }
    $url   = home_url( '/' . $sc_slug . '/' );
    $label = get_the_title( $pillar );
    ?>
    <div class="content-section sc-statewide-uplink" data-ai-extractable="true">
        <p><?php
        printf(
            /* translators: %s: link to the South Carolina statewide pillar page (anchor text is the page title). */
            esc_html__( 'Serving all of South Carolina: see our statewide %s page for South Carolina’s filing deadline, comparative-fault rule, and how these cases work across the state.', 'roden-law' ),
            '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>'
        );
        ?></p>
    </div>
    <?php
}

/* ==========================================================================
   FILING DEADLINES SIDEBAR — Statute of limitations by jurisdiction
   ========================================================================== */

/**
 * Render filing deadline sidebar showing SOL and comparative fault.
 * Auto-detects jurisdiction from current post meta or displays both states.
 *
 * @param string $jurisdiction Force jurisdiction: 'GA', 'SC', or 'both'. Empty = auto-detect.
 */
function roden_filing_deadlines_sidebar( $jurisdiction = '' ) {
    $firm = roden_firm_data();

    // Auto-detect from post meta
    if ( ! $jurisdiction ) {
        $jurisdiction = get_post_meta( get_the_ID(), '_roden_jurisdiction', true );
    }

    // Intersection pages: detect from office
    if ( ! $jurisdiction && function_exists( 'roden_is_intersection_page' ) && roden_is_intersection_page() ) {
        $office = roden_get_intersection_office();
        if ( $office ) {
            $jurisdiction = $office['state'];
        }
    }

    // Default to both for pillar pages
    if ( ! $jurisdiction ) {
        $jurisdiction = 'both';
    }

    $states = array();
    if ( 'both' === $jurisdiction ) {
        $states = array( 'GA', 'SC' );
    } else {
        $states = array( $jurisdiction );
    }

    // Check for per-page SOL overrides
    $sol_ga_override = get_post_meta( get_the_ID(), '_roden_sol_ga', true );
    $sol_sc_override = get_post_meta( get_the_ID(), '_roden_sol_sc', true );
    ?>
    <div class="sidebar-filing-deadlines">
        <h3 class="sidebar-title"><?php esc_html_e( 'Filing Deadlines', 'roden-law' ); ?></h3>
        <?php foreach ( $states as $state_key ) :
            // Practice-area aware: a workers' comp page must show the comp
            // deadline, not the tort SOL. Falls back to jurisdiction defaults.
            $j = roden_resolve_statute( $state_key );
            if ( ! $j ) {
                continue;
            }

            // Per-page post meta still wins over both.
            $sol_text = '';
            if ( 'GA' === $state_key && $sol_ga_override ) {
                $sol_text = $sol_ga_override;
            } elseif ( 'SC' === $state_key && $sol_sc_override ) {
                $sol_text = $sol_sc_override;
            } else {
                $sol_text = sprintf(
                    /* translators: 1: number of years; 2: statute citation, e.g. "O.C.G.A. § 9-3-33". */
                    _n( '%1$s year (%2$s)', '%1$s years (%2$s)', (int) $j['statute_years'], 'roden-law' ),
                    $j['statute_years'],
                    $j['statute_cite']
                );
            }
            ?>
            <div class="deadline-state">
                <h4><?php echo esc_html( $j['state_full'] ); ?></h4>
                <dl>
                    <dt><?php echo esc_html( $j['is_override'] ? __( 'Deadline to File a Claim', 'roden-law' ) : __( 'Statute of Limitations', 'roden-law' ) ); ?></dt>
                    <dd><?php echo esc_html( $sol_text ); ?></dd>
                    <?php if ( $j['notice_label'] && $j['notice_detail'] ) : ?>
                        <dt><?php echo esc_html( $j['notice_label'] ); ?></dt>
                        <dd><?php echo esc_html( $j['notice_detail'] ); ?></dd>
                    <?php endif; ?>
                    <?php if ( $j['comp_fault_rule'] ) : ?>
                        <dt><?php esc_html_e( 'Comparative Fault', 'roden-law' ); ?></dt>
                        <dd><?php echo esc_html( $j['comp_fault_rule'] ); ?></dd>
                    <?php endif; ?>
                </dl>
            </div>
        <?php endforeach; ?>
        <p class="sidebar-disclaimer"><?php esc_html_e( 'Deadlines may vary. Contact us for case-specific guidance.', 'roden-law' ); ?></p>
    </div>
    <?php
}

/* ==========================================================================
   COMPARATIVE FAULT DISPLAY — GA vs SC rules
   ========================================================================== */

/**
 * Render a comparative fault comparison block.
 * Shows both states side-by-side on pillar pages, or single state on intersection/location.
 *
 * @param string $jurisdiction 'GA', 'SC', or 'both'. Empty = auto-detect.
 */
function roden_comparative_fault_display( $jurisdiction = '' ) {
    $firm = roden_firm_data();

    if ( ! $jurisdiction ) {
        $jurisdiction = get_post_meta( get_the_ID(), '_roden_jurisdiction', true );
    }
    if ( ! $jurisdiction ) {
        $jurisdiction = 'both';
    }

    $states = ( 'both' === $jurisdiction ) ? array( 'GA', 'SC' ) : array( $jurisdiction );
    ?>
    <div class="comparative-fault">
        <h3 class="section-subtitle"><?php esc_html_e( 'Comparative Fault Rules', 'roden-law' ); ?></h3>
        <div class="fault-grid cols-<?php echo count( $states ); ?>">
            <?php foreach ( $states as $state_key ) :
                if ( ! isset( $firm['jurisdiction'][ $state_key ] ) ) {
                    continue;
                }
                $j = $firm['jurisdiction'][ $state_key ];
                ?>
                <div class="fault-card state-<?php echo esc_attr( strtolower( $state_key ) ); ?>">
                    <h4><?php echo esc_html( $j['state_full'] ); ?></h4>
                    <p class="fault-rule"><?php echo esc_html( $j['comp_fault_rule'] ); ?></p>
                    <?php if ( ! empty( $j['comp_fault_cite'] ) ) : ?>
                        <p class="fault-cite"><?php echo esc_html( $j['comp_fault_cite'] ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

/* ==========================================================================
   RELATED PRACTICE AREAS SIDEBAR
   ========================================================================== */

/**
 * Render a list of related practice areas.
 * For pillar pages: shows other pillar pages.
 * For child pages: shows siblings under the same parent.
 *
 * @param int $count Max number of related items.
 */
function roden_related_practice_areas( $count = 6 ) {
    $post    = get_post();
    $current = $post->ID;

    // Match the request's locale: Spanish siblings/pillars on /es/, English elsewhere.
    $locale_mq = function_exists( 'roden_locale_meta_query' ) ? roden_locale_meta_query() : null;

    if ( $post->post_parent ) {
        // Child page — show siblings
        $sibling_args = array(
            'post_type'      => $post->post_type,
            'post_parent'    => $post->post_parent,
            'posts_per_page' => $count + 1,
            'post__not_in'   => array( $current ),
            'orderby'        => 'title',
            'order'          => 'ASC',
        );
        if ( $locale_mq ) {
            $sibling_args['meta_query'] = $locale_mq;
        }
        $siblings = get_posts( $sibling_args );
        $related = array_slice( $siblings, 0, $count );
        $heading = __( 'Related Pages', 'roden-law' );
    } else {
        // Pillar page — show other pillars
        $pillar_args = array(
            'post_type'      => $post->post_type,
            'post_parent'    => 0,
            'posts_per_page' => $count + 1,
            'post__not_in'   => array( $current ),
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        );
        if ( $locale_mq ) {
            $pillar_args['meta_query'] = $locale_mq;
        }
        $pillars = get_posts( $pillar_args );
        $related = array_slice( $pillars, 0, $count );
        $heading = __( 'Other Practice Areas', 'roden-law' );
    }

    if ( empty( $related ) ) {
        return;
    }
    ?>
    <div class="sidebar-related-pas">
        <h3 class="sidebar-title"><?php echo esc_html( $heading ); ?></h3>
        <ul>
            <?php foreach ( $related as $pa ) : ?>
                <li><a href="<?php echo esc_url( get_permalink( $pa ) ); ?>"><?php echo esc_html( $pa->post_title ); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
}

/* ==========================================================================
   WHY RODEN SIDEBAR — Trust signals
   ========================================================================== */

function roden_why_roden_sidebar() {
    $firm = roden_firm_data();
    ?>
    <div class="sidebar-why-roden">
        <h3 class="sidebar-title"><?php esc_html_e( 'Why Roden Law?', 'roden-law' ); ?></h3>
        <ul class="trust-signals">
            <li>
                <strong><?php echo esc_html( $firm['trust_stats']['recovered'] ); ?></strong>
                <span><?php esc_html_e( 'Recovered for Clients', 'roden-law' ); ?></span>
            </li>
            <li>
                <strong><?php printf( /* translators: %s: star rating, e.g. "4.9". */ esc_html__( '%s Stars', 'roden-law' ), esc_html( $firm['trust_stats']['rating'] ) ); ?></strong>
                <span><?php echo esc_html( $firm['trust_stats']['reviews'] ); ?></span>
            </li>
            <li>
                <strong><?php printf( /* translators: %s: number of offices. */ esc_html( _x( '%s Offices', 'office count', 'roden-law' ) ), esc_html( $firm['trust_stats']['offices'] ) ); ?></strong>
                <span><?php esc_html_e( 'Georgia & South Carolina', 'roden-law' ); ?></span>
            </li>
            <li>
                <strong><?php esc_html_e( 'No Fee Guarantee', 'roden-law' ); ?></strong>
                <span><?php esc_html_e( 'You don\'t pay unless we win', 'roden-law' ); ?></span>
            </li>
        </ul>
    </div>
    <?php
}

/* ==========================================================================
   AUTHOR ATTRIBUTION — E-E-A-T author box
   ========================================================================== */

/**
 * Render an "About the Author" attribution box for E-E-A-T.
 * Reads _roden_author_attorney meta to link to an attorney post.
 *
 * @param int|null $post_id Post ID (defaults to current post).
 */
function roden_author_attribution( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $author_id = get_post_meta( $post_id, '_roden_author_attorney', true );
    if ( ! $author_id ) {
        return;
    }

    $atty = get_post( $author_id );
    if ( ! $atty || 'publish' !== $atty->post_status ) {
        return;
    }

    $title          = get_post_meta( $atty->ID, '_roden_atty_title', true );
    $bar_admissions = get_post_meta( $atty->ID, '_roden_bar_admissions', true );
    $bar_list       = $bar_admissions ? array_filter( array_map( 'trim', explode( "\n", $bar_admissions ) ) ) : array();
    $excerpt        = get_the_excerpt( $atty ) ?: wp_trim_words( $atty->post_content, 30 );
    ?>
    <div class="author-attribution" itemscope itemtype="https://schema.org/Person">
        <h2 class="attribution-heading"><?php esc_html_e( 'About the Author', 'roden-law' ); ?></h2>
        <div class="attribution-inner">
            <?php if ( has_post_thumbnail( $atty ) ) : ?>
                <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>" class="attribution-photo">
                    <?php echo get_the_post_thumbnail( $atty, 'attorney-headshot', array( 'itemprop' => 'image' ) ); ?>
                </a>
            <?php endif; ?>
            <div class="attribution-bio">
                <h3 itemprop="name">
                    <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>"><?php echo esc_html( $atty->post_title ); ?></a>
                </h3>
                <?php if ( $title ) : ?>
                    <span class="attribution-title" itemprop="jobTitle"><?php echo esc_html( $title ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $bar_list ) ) : ?>
                    <span class="attribution-bar"><?php echo esc_html( implode( ' | ', $bar_list ) ); ?></span>
                <?php endif; ?>
                <p class="attribution-excerpt"><?php echo esc_html( $excerpt ); ?></p>
                <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>" class="attribution-link"><?php esc_html_e( 'View Full Profile', 'roden-law' ); ?> &rarr;</a>
            </div>
        </div>
    </div>
    <?php
}

/* ==========================================================================
   AI STATISTICS BLOCK (Extractable Firm Stats with Source Attribution)
   ========================================================================== */

/**
 * Output a structured statistics block optimized for AI extraction.
 * Statistics with cited sources boost AI visibility by +37% (Princeton GEO).
 *
 * @param string $practice_area_title The practice area title for contextual framing.
 */
function roden_ai_stats_block( $practice_area_title = '' ) {
    $firm  = roden_firm_data();
    $label = $practice_area_title ? $practice_area_title : __( 'Personal Injury', 'roden-law' );
    ?>
    <div class="ai-stats-block" data-ai-extractable="true">
        <h3><?php printf( /* translators: %s: practice area title, e.g. "Car Accident Lawyers" or "Personal Injury". */ esc_html__( 'Roden Law %s Results at a Glance', 'roden-law' ), esc_html( $label ) ); ?></h3>
        <table class="ai-stats-table">
            <tbody>
                <tr>
                    <th scope="row"><strong><?php echo esc_html( $firm['recovered'] ); ?></strong></th>
                    <td><?php esc_html_e( 'Recovered for injured clients across Georgia and South Carolina', 'roden-law' ); ?></td>
                </tr>
                <tr>
                    <th scope="row"><strong><?php printf( /* translators: %s: star rating, e.g. "4.9". */ esc_html__( '%s / 5.0', 'roden-law' ), esc_html( $firm['rating'] ) ); ?></strong></th>
                    <td><?php printf( /* translators: %d: rounded live Google review count, e.g. 170. */ esc_html__( 'Average client rating across %d+ verified Google reviews from our six offices', 'roden-law' ), (int) $firm['trust_stats']['review_count_rounded'] ); ?></td>
                </tr>
                <tr>
                    <th scope="row"><strong><?php echo esc_html( $firm['cases_handled'] ); ?></strong></th>
                    <td><?php printf( /* translators: %s: founding year, e.g. "2013". */ esc_html__( 'Cases successfully handled since %s', 'roden-law' ), esc_html( $firm['founded'] ) ); ?></td>
                </tr>
                <tr>
                    <th scope="row"><strong><?php echo esc_html( $firm['experience'] ); ?></strong></th>
                    <td><?php esc_html_e( 'Combined attorney experience across 5 office locations', 'roden-law' ); ?></td>
                </tr>
            </tbody>
        </table>
        <p class="ai-stats-source"><?php printf( /* translators: %s: month and year, e.g. "July 2026". */ esc_html__( 'Source: Roden Law firm records and verified Google Business Profile reviews, updated %s.', 'roden-law' ), esc_html( date_i18n( 'F Y' ) ) ); ?></p>
    </div>
    <?php
}

/**
 * Case Result — AI-extractable result summary block.
 *
 * Renders a self-contained, entity-rich answer passage (firm, amount, result
 * type, accident, injury, location, and the insurer's initial offer when known)
 * that AI engines can quote without surrounding context — the citable asset on
 * a case-result page. Factual case data only; deliberately NO Review markup,
 * because case results carry no real client review to back it. (AI-SEO audit
 * 2026-06-29.)
 *
 * @param int $post_id Optional case_result post ID. Defaults to current post.
 */
function roden_case_result_summary( $post_id = 0 ) {
    $post_id = $post_id ? $post_id : get_the_ID();

    $amount        = get_post_meta( $post_id, '_roden_case_amount', true );
    $result_type   = get_post_meta( $post_id, '_roden_case_type', true );
    $accident_type = get_post_meta( $post_id, '_roden_accident_type', true );
    $injury_type   = get_post_meta( $post_id, '_roden_injury_type', true );
    $initial_offer = get_post_meta( $post_id, '_roden_result_initial_offer', true );

    // Nothing citable without a recovery amount.
    if ( empty( $amount ) ) {
        return;
    }

    // Location from the location_served taxonomy, if assigned.
    $location  = '';
    $loc_terms = get_the_terms( $post_id, 'location_served' );
    if ( $loc_terms && ! is_wp_error( $loc_terms ) ) {
        $location = $loc_terms[0]->name;
    }

    $type_label = $result_type ? strtolower( $result_type ) : __( 'recovery', 'roden-law' );

    // Build the lead sentence from whatever facts are present (each value escaped).
    // Optional clauses are translated as standalone units and slotted into the
    // lead-sentence msgid via placeholders (empty when the fact is missing).
    $accident_clause = $accident_type
        ? ' ' . sprintf( /* translators: %s: accident/case type, e.g. "car accident". Appended to "Roden Law secured a [amount] [settlement]". */ __( 'in a %s case', 'roden-law' ), esc_html( $accident_type ) )
        : '';
    $injury_clause = $injury_type
        ? ' ' . sprintf( /* translators: %s: injury type, e.g. "a traumatic brain injury". Appended to the case-result lead sentence. */ __( 'involving %s', 'roden-law' ), esc_html( $injury_type ) )
        : '';
    $location_clause = $location
        ? ' ' . sprintf( /* translators: %s: location name, e.g. "Savannah, GA". Appended to the case-result lead sentence. */ __( 'in %s', 'roden-law' ), esc_html( $location ) )
        : '';

    $sentence = sprintf(
        /* translators: 1: recovery amount, e.g. "$3,000,000"; 2: result type, e.g. "settlement"; 3: optional "in a … case" clause; 4: optional "involving …" clause; 5: optional "in [location]" clause. */
        __( 'Roden Law secured a %1$s %2$s%3$s%4$s%5$s.', 'roden-law' ),
        esc_html( $amount ),
        esc_html( $type_label ),
        $accident_clause,
        $injury_clause,
        $location_clause
    );
    if ( $initial_offer ) {
        $sentence .= ' ' . sprintf(
            /* translators: %s: the insurer's initial offer amount, e.g. "$25,000". */
            __( 'The insurance company initially offered just %s before Roden Law intervened.', 'roden-law' ),
            esc_html( $initial_offer )
        );
    }
    ?>
    <div class="case-result-summary" data-ai-extractable="true">
        <h2><?php esc_html_e( 'Result Summary', 'roden-law' ); ?></h2>
        <p class="case-result-lead"><?php echo $sentence; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — pieces escaped above. ?></p>
        <table class="case-result-facts">
            <tbody>
                <tr><th scope="row"><?php esc_html_e( 'Amount recovered', 'roden-law' ); ?></th><td><?php echo esc_html( $amount ); echo $result_type ? ' (' . esc_html( $result_type ) . ')' : ''; ?></td></tr>
                <?php if ( $accident_type ) : ?><tr><th scope="row"><?php esc_html_e( 'Case type', 'roden-law' ); ?></th><td><?php echo esc_html( $accident_type ); ?></td></tr><?php endif; ?>
                <?php if ( $injury_type ) : ?><tr><th scope="row"><?php esc_html_e( 'Injury', 'roden-law' ); ?></th><td><?php echo esc_html( $injury_type ); ?></td></tr><?php endif; ?>
                <?php if ( $initial_offer ) : ?><tr><th scope="row"><?php esc_html_e( 'Insurer’s initial offer', 'roden-law' ); ?></th><td><?php echo esc_html( $initial_offer ); ?></td></tr><?php endif; ?>
                <?php if ( $location ) : ?><tr><th scope="row"><?php esc_html_e( 'Location', 'roden-law' ); ?></th><td><?php echo esc_html( $location ); ?></td></tr><?php endif; ?>
            </tbody>
        </table>
        <p class="case-result-summary-note"><?php esc_html_e( 'Result reported by Roden Law. Past results do not guarantee a similar outcome in your case.', 'roden-law' ); ?></p>
    </div>
    <?php
}

/* ==========================================================================
   EXPERT QUOTE BLOCK (AI-Citable Attorney Quote)
   ========================================================================== */

/**
 * Output an expert quote block with Person microdata for AI extraction.
 * Expert quotations boost AI visibility by +30% (Princeton GEO).
 *
 * @param string $quote         The quote text.
 * @param int    $attorney_id   The attorney post ID. Falls back to post's _roden_author_attorney.
 */
function roden_expert_quote_block( $quote, $attorney_id = 0 ) {
    if ( ! $quote ) {
        return;
    }

    if ( ! $attorney_id ) {
        $attorney_id = get_post_meta( get_the_ID(), '_roden_author_attorney', true );
    }
    if ( ! $attorney_id ) {
        return;
    }

    $atty = get_post( $attorney_id );
    if ( ! $atty || 'publish' !== $atty->post_status ) {
        return;
    }

    $title = get_post_meta( $atty->ID, '_roden_atty_title', true );
    $bar   = get_post_meta( $atty->ID, '_roden_bar_admissions', true );
    ?>
    <blockquote class="expert-quote-block" data-ai-extractable="true" itemscope itemtype="https://schema.org/Quotation">
        <p itemprop="text">&ldquo;<?php echo wp_kses_post( $quote ); ?>&rdquo;</p>
        <footer>
            <cite itemscope itemtype="https://schema.org/Person">
                &mdash; <span itemprop="name"><?php echo esc_html( $atty->post_title ); ?></span>,
                <?php if ( $title ) : ?>
                    <span itemprop="jobTitle"><?php echo esc_html( $title ); ?></span>,
                <?php endif; ?>
                <span itemprop="worksFor" itemscope itemtype="https://schema.org/LegalService">
                    <span itemprop="name">Roden Law</span>
                </span>
                <?php if ( $bar ) : ?>
                    <span class="expert-quote-bar">(<?php echo esc_html( trim( str_replace( "\n", ', ', $bar ) ) ); ?>)</span>
                <?php endif; ?>
            </cite>
        </footer>
    </blockquote>
    <?php
}

/* ==========================================================================
   GA vs SC COMPARISON TABLE (AI-Extractable for "[X] vs [Y]" Queries)
   ========================================================================== */

/**
 * Output a structured comparison table of Georgia vs South Carolina law.
 * Tables get cited ~33% of the time for comparison queries — the highest
 * citation share of any content type (Princeton GEO).
 *
 * @param string $practice_area_title The practice area for contextual headings.
 * @param string $sol_ga              GA statute of limitations text.
 * @param string $sol_sc              SC statute of limitations text.
 * @param string $jurisdiction        'both', 'ga', or 'sc'. Only 'both' shows the table.
 */
/* ==========================================================================
   RELATED RESOURCES — for sidebars and content sections
   ========================================================================== */

/**
 * Render a list of related resource posts.
 *
 * Queries resources by practice_category taxonomy and/or geographic relevance
 * (office slug in the resource's post_name). Useful in intersection, sub-type,
 * location, and resource page sidebars/sections.
 *
 * @param array $args {
 *     @type int    $count          Max resources to show. Default 6.
 *     @type string $cat_slug       practice_category slug to filter by.
 *     @type string $office_key     Office key for geographic relevance (matches slug fragments).
 *     @type string $heading        Section heading. Default 'Related Guides'.
 *     @type string $display        'sidebar' for compact list, 'section' for card grid. Default 'sidebar'.
 *     @type int    $exclude        Post ID to exclude (current resource page).
 * }
 */
function roden_related_resources( $args = array() ) {
    $defaults = array(
        'count'      => 6,
        'cat_slug'   => '',
        'office_key' => '',
        'heading'    => __( 'Related Guides', 'roden-law' ),
        'display'    => 'sidebar',
        'exclude'    => 0,
    );
    $args = wp_parse_args( $args, $defaults );

    $firm = roden_firm_data();

    // Build query: filter by practice_category if provided.
    $query_args = array(
        'post_type'      => 'resource',
        'posts_per_page' => $args['count'] + 4, // over-fetch to allow dedup/filtering
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    // Match the request's locale: Spanish resources on /es/, English elsewhere.
    if ( function_exists( 'roden_locale_meta_query' ) ) {
        $query_args['meta_query'] = roden_locale_meta_query();
    }

    if ( $args['exclude'] ) {
        $query_args['post__not_in'] = array( $args['exclude'] );
    }

    if ( $args['cat_slug'] ) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'practice_category',
                'field'    => 'slug',
                'terms'    => $args['cat_slug'],
            ),
        );
    }

    $resources = new WP_Query( $query_args );

    if ( ! $resources->have_posts() ) {
        wp_reset_postdata();
        return;
    }

    // If office_key provided, boost resources whose slug contains the office's city/market name.
    $boosted = array();
    $rest    = array();
    $office_slugs = array();

    if ( $args['office_key'] && isset( $firm['offices'][ $args['office_key'] ] ) ) {
        $o = $firm['offices'][ $args['office_key'] ];
        $office_slugs[] = sanitize_title( $o['city'] );
        $office_slugs[] = sanitize_title( $o['market_name'] );
        // Add state-level identifiers
        $office_slugs[] = strtolower( $o['state'] );
    }

    while ( $resources->have_posts() ) {
        $resources->the_post();
        $slug = get_post_field( 'post_name', get_the_ID() );

        $is_local = false;
        foreach ( $office_slugs as $fragment ) {
            if ( strpos( $slug, $fragment ) !== false ) {
                $is_local = true;
                break;
            }
        }

        $item = array(
            'id'    => get_the_ID(),
            'title' => get_the_title(),
            'url'   => get_the_permalink(),
        );

        if ( $is_local ) {
            $boosted[] = $item;
        } else {
            $rest[] = $item;
        }
    }
    wp_reset_postdata();

    // Merge: local resources first, then others, capped at $count.
    $items = array_slice( array_merge( $boosted, $rest ), 0, $args['count'] );

    if ( empty( $items ) ) {
        return;
    }

    if ( 'section' === $args['display'] ) :
    // Full-width card grid (for main content area)
    ?>
    <div class="content-section pa-guides">
        <h2><?php echo esc_html( $args['heading'] ); ?></h2>
        <div class="pa-resources__grid">
            <?php foreach ( $items as $item ) : ?>
                <a href="<?php echo esc_url( $item['url'] ); ?>" class="resource-link">
                    <span class="resource-link__title"><?php echo esc_html( $item['title'] ); ?></span>
                    <span class="resource-link__arrow">&rarr;</span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    else :
    // Sidebar list
    ?>
    <div class="sidebar-widget sidebar-related-resources">
        <h3 class="widget-title"><?php echo esc_html( $args['heading'] ); ?></h3>
        <ul class="sidebar-links">
            <?php foreach ( $items as $item ) : ?>
                <li>
                    <a href="<?php echo esc_url( $item['url'] ); ?>">
                        &rarr; <?php echo esc_html( $item['title'] ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    endif;
}

/* ==========================================================================
   JURISDICTION COMPARISON TABLE
   ========================================================================== */

function roden_jurisdiction_comparison_table( $practice_area_title, $sol_ga = '', $sol_sc = '', $jurisdiction = 'both' ) {
    // Only show comparison table when both jurisdictions apply.
    if ( 'both' !== strtolower( $jurisdiction ) ) {
        return;
    }

    $label = preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', $practice_area_title );
    ?>
    <div class="jurisdiction-comparison" data-ai-extractable="true">
        <h2><?php printf( /* translators: %s: practice area label with "Lawyers/Attorneys" stripped, e.g. "Car Accident". */ esc_html__( 'Georgia vs. South Carolina %s Laws', 'roden-law' ), esc_html( $label ) ); ?></h2>
        <p class="comparison-intro"><?php printf( /* translators: %s: lowercase practice area label, e.g. "car accident". */ esc_html__( 'If you were injured in Georgia or South Carolina, the laws governing your %s claim differ by state. Below is a side-by-side comparison of the key legal rules that affect your case.', 'roden-law' ), esc_html( strtolower( $label ) ) ); ?></p>
        <table class="comparison-table">
            <thead>
                <tr>
                    <th scope="col"><?php esc_html_e( 'Legal Rule', 'roden-law' ); ?></th>
                    <th scope="col"><?php esc_html_e( 'Georgia', 'roden-law' ); ?></th>
                    <th scope="col"><?php esc_html_e( 'South Carolina', 'roden-law' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong><?php esc_html_e( 'Statute of Limitations', 'roden-law' ); ?></strong></td>
                    <td><?php echo esc_html( $sol_ga ?: __( '2 years (O.C.G.A. § 9-3-33)', 'roden-law' ) ); ?></td>
                    <td><?php echo esc_html( $sol_sc ?: __( '3 years (S.C. Code § 15-3-530)', 'roden-law' ) ); ?></td>
                </tr>
                <tr>
                    <td><strong><?php esc_html_e( 'Comparative Fault Rule', 'roden-law' ); ?></strong></td>
                    <td><?php esc_html_e( 'Modified — recover if less than 50% at fault (O.C.G.A. § 51-12-33)', 'roden-law' ); ?></td>
                    <td><?php esc_html_e( 'Modified — recover if less than 51% at fault', 'roden-law' ); ?></td>
                </tr>
                <tr>
                    <td><strong><?php esc_html_e( 'Damage Cap', 'roden-law' ); ?></strong></td>
                    <td><?php esc_html_e( 'No cap on compensatory damages; punitive capped at $250,000 in most cases (O.C.G.A. § 51-12-5.1)', 'roden-law' ); ?></td>
                    <td><?php esc_html_e( 'No cap on compensatory damages; no statutory punitive cap (jury discretion)', 'roden-law' ); ?></td>
                </tr>
                <tr>
                    <td><strong><?php esc_html_e( 'Minimum Auto Insurance', 'roden-law' ); ?></strong></td>
                    <td><?php esc_html_e( '25/50/25 liability coverage required', 'roden-law' ); ?></td>
                    <td><?php esc_html_e( '25/50/25 liability coverage required', 'roden-law' ); ?></td>
                </tr>
                <tr>
                    <td><strong><?php esc_html_e( 'Filing Court', 'roden-law' ); ?></strong></td>
                    <td><?php esc_html_e( 'Superior Court (claims over $15,000)', 'roden-law' ); ?></td>
                    <td><?php esc_html_e( 'Circuit Court (claims over $7,500)', 'roden-law' ); ?></td>
                </tr>
            </tbody>
        </table>
        <p class="comparison-source"><em><?php printf( /* translators: %s: month and year, e.g. "July 2026". */ esc_html__( 'Source: Georgia Code (O.C.G.A.) and South Carolina Code of Laws. Verified %s.', 'roden-law' ), esc_html( date_i18n( 'F Y' ) ) ); ?></em></p>
    </div>
    <?php
}

/**
 * Replace per-intersection local tokens in pillar-level content.
 *
 * Tokens supported:
 *   {city}, {market_name}, {state_full}, {state_short},
 *   {office_court}, {office_court_address},
 *   {sol_years}, {sol_cite}, {comp_fault_threshold}
 *
 * @param string $text         Source text with {token} placeholders.
 * @param array  $office       Office array from firm-data.
 * @param array  $jurisdiction Jurisdiction array from firm-data ($firm['jurisdiction'][$state_key]).
 * @return string
 */
function roden_replace_local_tokens( $text, $office, $jurisdiction = array() ) {
    if ( ! $text ) return '';

    $market_name = isset( $office['market_name'] ) && $office['market_name']
        ? $office['market_name']
        : ( $office['city'] ?? '' );

    $threshold = '';
    if ( ! empty( $jurisdiction['comp_fault_rule'] ) ) {
        if ( preg_match( '/(\d{2})%/', $jurisdiction['comp_fault_rule'], $m ) ) {
            $threshold = $m[1] . '%';
        }
    }

    $tokens = array(
        '{city}'                 => $office['city'] ?? '',
        '{market_name}'          => $market_name,
        '{state_full}'           => $office['state_full'] ?? '',
        '{state_short}'          => $office['state'] ?? '',
        '{office_court}'         => $office['court'] ?? '',
        '{office_court_address}' => $office['court_address'] ?? '',
        '{sol_years}'            => isset( $jurisdiction['statute_years'] ) ? (string) $jurisdiction['statute_years'] : '',
        '{sol_cite}'             => $jurisdiction['statute_cite'] ?? '',
        '{comp_fault_threshold}' => $threshold,
    );

    return strtr( $text, $tokens );
}

/**
 * Convert lightweight `**bold**` markdown to <strong> tags. Pillar intros and
 * office local-context essays use **bold** for emphasis on statute citations
 * and key terms; the_content's wpautop filter doesn't process markdown.
 *
 * @param string $text Source with **bold** markers.
 * @return string Same text with `**foo**` replaced by `<strong>foo</strong>`.
 */
function roden_markdown_bold_to_html( $text ) {
    if ( ! $text ) return '';
    return preg_replace( '/\*\*([^*\n]+)\*\*/', '<strong>$1</strong>', $text );
}

/**
 * Render a pillar-level content block (negligence intro, compensation intro, etc.)
 * with per-intersection token replacement. Used on intersection pages to avoid
 * boilerplate duplication across all 6 sibling intersections.
 *
 * @param int    $parent_id    Parent pillar post ID.
 * @param string $meta_key     Pillar meta field to read (e.g. '_roden_pillar_negligence_intro').
 * @param array  $office       Office array.
 * @param array  $jurisdiction Jurisdiction array.
 * @return string Rendered HTML, or '' if pillar meta is empty.
 */
/**
 * Resolve {{GA}}...{{/GA}} / {{SC}}...{{/SC}} conditional blocks for a single-
 * jurisdiction context (intersection pages render one office's state only): keep
 * the office's state, drop the other, and unwrap the kept markers. Unknown/empty
 * state fails safe by unwrapping BOTH (shows all) rather than stripping everything.
 * Content without markers is returned unchanged (backward compatible).
 *
 * @param string $text
 * @param array  $office Office array (uses 'state' = 'GA'|'SC').
 * @return string
 */
function roden_strip_state_conditionals( $text, $office ) {
    $state = strtoupper( isset( $office['state'] ) ? $office['state'] : '' );
    if ( 'GA' === $state || 'SC' === $state ) {
        $other = ( 'GA' === $state ) ? 'SC' : 'GA';
        $text  = preg_replace( '/\{\{' . $other . '\}\}.*?\{\{\/' . $other . '\}\}/s', '', $text );
        $text  = str_replace( array( '{{' . $state . '}}', '{{/' . $state . '}}' ), '', $text );
    } else {
        $text = str_replace( array( '{{GA}}', '{{/GA}}', '{{SC}}', '{{/SC}}' ), '', $text );
    }
    return $text;
}

function roden_render_pillar_intro( $parent_id, $meta_key, $office, $jurisdiction = array() ) {
    if ( ! $parent_id ) return '';
    $raw = get_post_meta( $parent_id, $meta_key, true );
    if ( ! $raw ) return '';
    $raw         = roden_strip_state_conditionals( $raw, $office );
    $with_tokens = roden_replace_local_tokens( $raw, $office, $jurisdiction );
    $with_bold   = roden_markdown_bold_to_html( $with_tokens );
    return apply_filters( 'the_content', $with_bold );
}

/**
 * Render the per-office "Filing in [Court]" local context block on intersection
 * and (optionally) location pages. Pulls from the office's `local_context` array
 * key in firm-data. Returns '' if the office has no local context configured.
 *
 * @param array $office       Office array (must include 'local_context' key).
 * @param array $jurisdiction Jurisdiction array.
 * @return void Outputs HTML directly (or nothing).
 */
function roden_office_local_context_block( $office, $jurisdiction = array(), $variant = '' ) {
    // Locale-aware: Spanish pages render the office's *_es essay; if it doesn't
    // exist the block is skipped — never English on /es/.
    $is_es  = ( function_exists( 'roden_current_lang' ) && 'es' === roden_current_lang() );
    $suffix = $is_es ? '_es' : '';

    if ( $variant ) {
        /*
         * A variant is requested when the default essay would be wrong rather
         * than merely generic — the tort essay describes filing a civil
         * complaint in superior court under the two-year statute of
         * limitations, which is actively misleading on a workers' comp page.
         * So there is deliberately NO fallback: if the office has no variant
         * essay, render nothing rather than the wrong one.
         */
        $key  = 'local_context_' . $variant . $suffix;
        $body = isset( $office[ $key ] ) ? trim( $office[ $key ] ) : '';
    } else {
        $key  = 'local_context' . $suffix;
        $body = isset( $office[ $key ] ) ? trim( $office[ $key ] ) : '';
    }

    if ( ! $body ) return;

    $body = roden_replace_local_tokens( $body, $office, $jurisdiction );
    $body = roden_markdown_bold_to_html( $body );
    $market_name = isset( $office['market_name'] ) && $office['market_name']
        ? $office['market_name']
        : ( $office['city'] ?? '' );
    ?>
    <?php
    $headings = apply_filters(
        'roden_local_context_headings',
        array(
            ''   => __( 'Filing a Personal Injury Case in %s', 'roden-law' ),
            'wc' => __( 'Filing a Workers\' Compensation Claim in %s', 'roden-law' ),
        )
    );
    $heading = isset( $headings[ $variant ] ) ? $headings[ $variant ] : $headings[''];
    ?>
    <div class="content-section pa-local-context" data-ai-extractable="true">
        <h2><?php printf( /* translators: %s: city/market name, e.g. "Savannah". */ esc_html( $heading ), esc_html( $market_name ) ); ?></h2>
        <div class="pa-local-context__body">
            <?php echo apply_filters( 'the_content', $body ); ?>
        </div>
    </div>
    <?php
}
