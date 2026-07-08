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
            <a href="<?php echo esc_url( $url ); ?>" class="location-link"><?php esc_html_e( 'View Office', 'roden-law' ); ?> &rarr;</a>
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

    // Try to load from CPT posts.
    $areas = get_posts( array(
        'post_type'      => 'practice_area',
        'posts_per_page' => -1,
        'post_parent'    => 0,
        'post_name__in'  => $featured_slugs,
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
            $url = home_url( '/practice-areas/' . $slug . '/' );
            echo '<a href="' . esc_url( $url ) . '" class="practice-area-card">';
            echo '<span class="pa-name">' . esc_html( $name ) . '</span>';
            echo '</a>';
        }
    }

    // "Other" catch-all link.
    $archive_url = home_url( '/practice-areas/' );
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
    $firm   = roden_firm_data();
    $office = isset( $firm['offices'][ $office_key ] ) ? $firm['offices'][ $office_key ] : null;

    if ( ! $office ) {
        return;
    }

    $office_slug = $office['slug']; // e.g. 'savannah-ga'

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

    // Try to load pillar posts from the DB for titles + thumbnails.
    $pillar_posts = get_posts( array(
        'post_type'      => 'practice_area',
        'posts_per_page' => -1,
        'post_parent'    => 0,
        'post_name__in'  => array_keys( $pa_labels ),
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ) );

    // Index by slug for lookup.
    $pillar_map = array();
    foreach ( $pillar_posts as $p ) {
        $pillar_map[ $p->post_name ] = $p;
    }

    // Check which pillars have intersection pages for this office.
    $intersection_check_args = array(
        'post_type'      => 'practice_area',
        'posts_per_page' => -1,
        'post_name__in'  => array( $office_slug ),
        'fields'         => 'id=>parent',
    );
    if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
        $intersection_check_args['meta_query'] = roden_es_exclusion_meta_query();
    }
    $intersection_check = get_posts( $intersection_check_args );
    $pillars_with_intersection = array();
    foreach ( $intersection_check as $ic ) {
        $parent_slug = get_post_field( 'post_name', $ic->post_parent );
        if ( $parent_slug ) {
            $pillars_with_intersection[ $parent_slug ] = true;
        }
    }

    echo '<div class="practice-areas-grid cols-' . intval( $columns ) . '">';

    foreach ( $pa_labels as $slug => $fallback_label ) {
        // Link to intersection page if it exists, otherwise fall back to pillar page.
        if ( isset( $pillars_with_intersection[ $slug ] ) ) {
            $url = home_url( '/' . $slug . '/' . $office_slug . '/' );
        } elseif ( isset( $pillar_map[ $slug ] ) ) {
            $url = get_permalink( $pillar_map[ $slug ] );
        } else {
            $url = home_url( '/practice-areas/' . $slug . '/' );
        }
        $label = isset( $pillar_map[ $slug ] ) ? $pillar_map[ $slug ]->post_title : $fallback_label;
        ?>
        <a href="<?php echo esc_url( $url ); ?>" class="practice-area-card">
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
    if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
        $sibling_args['meta_query'] = roden_es_exclusion_meta_query();
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
        <p class="form-subtitle"><?php esc_html_e( 'No fees unless we win', 'roden-law' ); ?><br><?php esc_html_e( 'Hundreds of 5-star reviews', 'roden-law' ); ?></p>
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
function roden_ai_definition_block( $practice_area_title, $custom_definition = '' ) {
    if ( $custom_definition ) {
        $definition = $custom_definition;
    } else {
        $definition = get_the_excerpt();
    }

    if ( ! $definition ) {
        return;
    }

    // Build a clean label for the H2 (strip trailing "Lawyers" / "Attorneys" for natural phrasing).
    $label = preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', $practice_area_title );
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
        <h2><?php printf( /* translators: %s: practice area label, e.g. "Car Accident". */ esc_html__( 'What Is a %s Case?', 'roden-law' ), esc_html( $label ) ); ?></h2>
        <p class="definition-text"><?php echo wp_kses_post( $definition ); ?></p>
        <?php if ( $author_name ) : ?>
            <p class="definition-attribution">
                <?php
                echo '— ';
                printf(
                    /* translators: 1: attorney name (bold), 2: attorney title. */
                    $author_title ? esc_html__( 'Reviewed by %1$s, %2$s at Roden Law', 'roden-law' ) : esc_html__( 'Reviewed by %1$s at Roden Law', 'roden-law' ),
                    '<strong>' . esc_html( $author_name ) . '</strong>',
                    esc_html( $author_title )
                );
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
function roden_what_to_do_steps( $accident_type, $city = '', $state_full = '' ) {
    $state_label = $state_full ?: __( 'your state', 'roden-law' );
    ?>
    <div class="content-section what-to-do-steps" data-ai-extractable="true">
        <h2><?php
        if ( $city ) {
            printf(
                /* translators: 1: accident type, e.g. "A Car Accident"; 2: city + state, e.g. "Savannah, GA". */
                esc_html__( 'What to Do After %1$s in %2$s', 'roden-law' ),
                esc_html( ucfirst( $accident_type ) ),
                esc_html( $city )
            );
        } else {
            printf(
                /* translators: %s: accident type, e.g. "A Car Accident". */
                esc_html__( 'What to Do After %s', 'roden-law' ),
                esc_html( ucfirst( $accident_type ) )
            );
        }
        ?></h2>
        <ol class="steps-list">
            <li>
                <strong><?php esc_html_e( 'Ensure safety and call 911.', 'roden-law' ); ?></strong>
                <?php esc_html_e( 'Move to a safe location if possible. Call emergency services to report the accident and request medical attention for anyone injured.', 'roden-law' ); ?>
            </li>
            <li>
                <strong><?php esc_html_e( 'Seek immediate medical attention.', 'roden-law' ); ?></strong>
                <?php esc_html_e( 'Even if injuries seem minor, get examined by a doctor. Some injuries — such as traumatic brain injuries or internal bleeding — may not show symptoms immediately.', 'roden-law' ); ?>
            </li>
            <li>
                <strong><?php esc_html_e( 'Document the scene.', 'roden-law' ); ?></strong>
                <?php esc_html_e( 'Take photos of all vehicles, injuries, road conditions, traffic signs, and any visible damage. Collect names and contact information from witnesses.', 'roden-law' ); ?>
            </li>
            <li>
                <strong><?php esc_html_e( 'Exchange information with all parties.', 'roden-law' ); ?></strong>
                <?php esc_html_e( 'Get the other driver\'s name, insurance information, license plate number, and driver\'s license number. Do not admit fault or apologize.', 'roden-law' ); ?>
            </li>
            <li>
                <strong><?php esc_html_e( 'Report the accident to police.', 'roden-law' ); ?></strong>
                <?php
                printf(
                    /* translators: %s: state name, e.g. "Georgia", or the phrase "your state". */
                    esc_html__( '%s law requires accident reports when there are injuries or significant property damage. Request a copy of the police report.', 'roden-law' ),
                    esc_html( $state_label )
                );
                ?>
            </li>
            <li>
                <strong><?php esc_html_e( 'Notify your insurance company.', 'roden-law' ); ?></strong>
                <?php esc_html_e( 'Report the accident to your insurer promptly. Provide factual information only — do not speculate about fault or the extent of your injuries.', 'roden-law' ); ?>
            </li>
            <li>
                <strong><?php esc_html_e( 'Contact an experienced personal injury attorney.', 'roden-law' ); ?></strong>
                <?php esc_html_e( 'An attorney can protect your rights, handle communications with insurance companies, and help you pursue the full compensation you deserve. Roden Law offers free consultations — call today.', 'roden-law' ); ?>
            </li>
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
            if ( ! isset( $firm['jurisdiction'][ $state_key ] ) ) {
                continue;
            }
            $j = $firm['jurisdiction'][ $state_key ];

            // Use override if available
            $sol_text = '';
            if ( 'GA' === $state_key && $sol_ga_override ) {
                $sol_text = $sol_ga_override;
            } elseif ( 'SC' === $state_key && $sol_sc_override ) {
                $sol_text = $sol_sc_override;
            } else {
                $sol_text = sprintf(
                    /* translators: 1: number of years; 2: statute citation, e.g. "O.C.G.A. § 9-3-33". */
                    __( '%1$s years (%2$s)', 'roden-law' ),
                    $j['statute_years'],
                    $j['statute_cite']
                );
            }
            ?>
            <div class="deadline-state">
                <h4><?php echo esc_html( $j['state_full'] ); ?></h4>
                <dl>
                    <dt><?php esc_html_e( 'Statute of Limitations', 'roden-law' ); ?></dt>
                    <dd><?php echo esc_html( $sol_text ); ?></dd>
                    <dt><?php esc_html_e( 'Comparative Fault', 'roden-law' ); ?></dt>
                    <dd><?php echo esc_html( $j['comp_fault_rule'] ); ?></dd>
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

    // Keep Spanish (_roden_locale=es) posts out of English-page listings.
    $es_exclusion = function_exists( 'roden_es_exclusion_meta_query' ) ? roden_es_exclusion_meta_query() : null;

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
        if ( $es_exclusion ) {
            $sibling_args['meta_query'] = $es_exclusion;
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
        if ( $es_exclusion ) {
            $pillar_args['meta_query'] = $es_exclusion;
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
        <h3 class="attribution-heading"><?php esc_html_e( 'About the Author', 'roden-law' ); ?></h3>
        <div class="attribution-inner">
            <?php if ( has_post_thumbnail( $atty ) ) : ?>
                <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>" class="attribution-photo">
                    <?php echo get_the_post_thumbnail( $atty, 'attorney-headshot', array( 'itemprop' => 'image' ) ); ?>
                </a>
            <?php endif; ?>
            <div class="attribution-bio">
                <h4 itemprop="name">
                    <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>"><?php echo esc_html( $atty->post_title ); ?></a>
                </h4>
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
                    <td><strong><?php echo esc_html( $firm['recovered'] ); ?></strong></td>
                    <td><?php esc_html_e( 'Recovered for injured clients across Georgia and South Carolina', 'roden-law' ); ?></td>
                </tr>
                <tr>
                    <td><strong><?php printf( /* translators: %s: star rating, e.g. "4.9". */ esc_html__( '%s / 5.0', 'roden-law' ), esc_html( $firm['rating'] ) ); ?></strong></td>
                    <td><?php esc_html_e( 'Average client rating across hundreds of verified Google reviews from our six offices', 'roden-law' ); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo esc_html( $firm['cases_handled'] ); ?></strong></td>
                    <td><?php printf( /* translators: %s: founding year, e.g. "2013". */ esc_html__( 'Cases successfully handled since %s', 'roden-law' ), esc_html( $firm['founded'] ) ); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo esc_html( $firm['experience'] ); ?></strong></td>
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

    // Keep Spanish (_roden_locale=es) resources out of English-page listings.
    if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
        $query_args['meta_query'] = roden_es_exclusion_meta_query();
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
function roden_office_local_context_block( $office, $jurisdiction = array() ) {
    // Locale-aware: Spanish pages render the office's local_context_es essay;
    // if it doesn't exist the block is skipped — never English on /es/.
    if ( function_exists( 'roden_current_lang' ) && 'es' === roden_current_lang() ) {
        $body = isset( $office['local_context_es'] ) ? trim( $office['local_context_es'] ) : '';
    } else {
        $body = isset( $office['local_context'] ) ? trim( $office['local_context'] ) : '';
    }
    if ( ! $body ) return;

    $body = roden_replace_local_tokens( $body, $office, $jurisdiction );
    $body = roden_markdown_bold_to_html( $body );
    $market_name = isset( $office['market_name'] ) && $office['market_name']
        ? $office['market_name']
        : ( $office['city'] ?? '' );
    ?>
    <div class="content-section pa-local-context" data-ai-extractable="true">
        <h2><?php printf( /* translators: %s: city/market name, e.g. "Savannah". */ esc_html__( 'Filing a Personal Injury Case in %s', 'roden-law' ), esc_html( $market_name ) ); ?></h2>
        <div class="pa-local-context__body">
            <?php echo apply_filters( 'the_content', $body ); ?>
        </div>
    </div>
    <?php
}
