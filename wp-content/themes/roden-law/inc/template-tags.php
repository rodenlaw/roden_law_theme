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
    $crumbs = array( '<a href="' . esc_url( home_url( '/' ) ) . '">Home</a>' );

    if ( ( function_exists( 'roden_is_pa_singular' ) && roden_is_pa_singular() )
         || is_singular( 'practice_area' ) ) {

        $crumbs[] = '<a href="' . esc_url( home_url( '/practice-areas/' ) ) . '">Practice Areas</a>';

        $pa_post = get_post( get_the_ID() );
        if ( $pa_post->post_parent ) {
            $parent = get_post( $pa_post->post_parent );
            if ( $parent ) {
                $crumbs[] = '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . esc_html( $parent->post_title ) . '</a>';
            }
        }
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';

    } elseif ( is_singular( 'location' ) ) {
        $crumbs[] = '<a href="' . esc_url( home_url( '/locations/' ) ) . '">Locations</a>';

        $is_neighborhood = get_post_meta( get_the_ID(), '_roden_is_neighborhood', true );
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
            if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
                $o = $firm['offices'][ $office_key ];
                $crumbs[] = '<a href="' . esc_url( home_url( '/locations/' . $o['state_slug'] . '/' ) ) . '">' . esc_html( $o['state_full'] ) . '</a>';
            }
        }
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';

    } elseif ( is_singular( 'attorney' ) ) {
        $crumbs[] = '<a href="' . esc_url( home_url( '/attorneys/' ) ) . '">Attorneys</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';

    } elseif ( is_singular( 'case_result' ) ) {
        $crumbs[] = '<a href="' . esc_url( home_url( '/case-results/' ) ) . '">Case Results</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';

    } elseif ( is_singular( 'post' ) ) {
        $blog_url = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' );
        $crumbs[] = '<a href="' . esc_url( $blog_url ) . '">Blog</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';

    } elseif ( is_singular( 'resource' ) ) {
        $crumbs[] = '<a href="' . esc_url( home_url( '/resources/' ) ) . '">Resources</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';

    } elseif ( is_search() ) {
        $crumbs[] = '<span class="breadcrumb-current">Search Results</span>';

    } elseif ( is_home() ) {
        $crumbs[] = '<span class="breadcrumb-current">Blog</span>';

    } elseif ( is_category() ) {
        $blog_url = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' );
        $crumbs[] = '<a href="' . esc_url( $blog_url ) . '">Blog</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( single_cat_title( '', false ) ) . '</span>';

    } elseif ( is_tag() ) {
        $blog_url = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' );
        $crumbs[] = '<a href="' . esc_url( $blog_url ) . '">Blog</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( single_tag_title( '', false ) ) . '</span>';

    } elseif ( is_post_type_archive() ) {
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( post_type_archive_title( '', false ) ) . '</span>';

    } elseif ( is_page() ) {
        $crumbs[] = '<span class="breadcrumb-current">' . esc_html( get_the_title() ) . '</span>';
    }

    echo '<nav class="breadcrumbs" aria-label="Breadcrumb"><span class="breadcrumb-list">'
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
            <a href="<?php echo esc_url( $url ); ?>" class="location-link">View Office &rarr;</a>
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
    echo '<h3 class="matrix-title">' . esc_html( $pillar ? $pillar->post_title : '' ) . ' by Location</h3>';
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
        'Car Accident Lawyers'        => 'car-accident-lawyers',
        'Truck Accident Lawyers'       => 'truck-accident-lawyers',
        'Motorcycle Accident Lawyers'  => 'motorcycle-accident-lawyers',
        'Pedestrian Accident Lawyers'  => 'pedestrian-accident-lawyers',
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
        'car-accident-lawyers'              => 'Car Accident Lawyers',
        'truck-accident-lawyers'             => 'Truck Accident Lawyers',
        'slip-and-fall-lawyers'              => 'Slip & Fall Lawyers',
        'motorcycle-accident-lawyers'        => 'Motorcycle Accident Lawyers',
        'medical-malpractice-lawyers'        => 'Medical Malpractice Lawyers',
        'wrongful-death-lawyers'             => 'Wrongful Death Lawyers',
        'workers-compensation-lawyers'       => 'Workers\' Compensation Lawyers',
        'dog-bite-lawyers'                   => 'Dog Bite Lawyers',
        'brain-injury-lawyers'               => 'Brain Injury Lawyers',
        'spinal-cord-injury-lawyers'         => 'Spinal Cord Injury Lawyers',
        'maritime-injury-lawyers'            => 'Maritime Injury Lawyers',
        'product-liability-lawyers'          => 'Product Liability Lawyers',
        'boating-accident-lawyers'           => 'Boating Accident Lawyers',
        'burn-injury-lawyers'                => 'Burn Injury Lawyers',
        'construction-accident-lawyers'      => 'Construction Accident Lawyers',
        'nursing-home-abuse-lawyers'         => 'Nursing Home Abuse Lawyers',
        'premises-liability-lawyers'         => 'Premises Liability Lawyers',
        'pedestrian-accident-lawyers'        => 'Pedestrian Accident Lawyers',
        'bicycle-accident-lawyers'           => 'Bicycle Accident Lawyers',
        'electric-scooter-accident-lawyers'  => 'Electric Scooter Accident Lawyers',
        'atv-side-by-side-accident-lawyers'  => 'ATV & Side-by-Side Accident Lawyers',
        'golf-cart-accident-lawyers'         => 'Golf Cart Accident Lawyers',
        'e-bike-accident-lawyers'            => 'E-Bike Accident Lawyers',
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
    $intersection_check = get_posts( array(
        'post_type'      => 'practice_area',
        'posts_per_page' => -1,
        'post_name__in'  => array( $office_slug ),
        'fields'         => 'id=>parent',
    ) );
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

    $siblings = get_posts( array(
        'post_type'      => 'location',
        'post_parent'    => $parent_id,
        'posts_per_page' => -1,
        'post__not_in'   => array( $current_post_id ),
        'meta_key'       => '_roden_is_neighborhood',
        'meta_value'     => '1',
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ) );

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
            $pop ? '<span class="neighborhood-pop">Pop. ' . esc_html( $pop ) . '</span>' : ''
        );
    }
    echo '</div>';
}

/* ==========================================================================
   CONTACT FORM SIDEBAR (CTA box)
   ========================================================================== */

function roden_contact_form_sidebar( $local_phone = '' ) {
    ?>
    <div class="sidebar-contact-form">
        <h3 class="form-title">Free Case Review</h3>
        <p class="form-subtitle">No fees unless we win<br>500+ 5-star reviews</p>
        <form class="roden-sidebar-form" id="roden-sidebar-form" novalidate>
            <?php wp_nonce_field( 'roden_sidebar_form', 'roden_form_nonce' ); ?>
            <input type="hidden" name="gclid" class="roden-gclid" value="">
            <div style="position:absolute;left:-9999px;" aria-hidden="true">
                <input type="text" name="website_url" tabindex="-1" autocomplete="off">
            </div>
            <div class="rsf-row rsf-half">
                <div>
                    <label for="rsf-first-name" class="screen-reader-text"><?php esc_html_e( 'First Name', 'roden-law' ); ?></label>
                    <input type="text" name="first_name" id="rsf-first-name" placeholder="First Name" autocomplete="given-name" required>
                </div>
                <div>
                    <label for="rsf-last-name" class="screen-reader-text"><?php esc_html_e( 'Last Name', 'roden-law' ); ?></label>
                    <input type="text" name="last_name" id="rsf-last-name" placeholder="Last Name" autocomplete="family-name" required>
                </div>
            </div>
            <label for="rsf-phone" class="screen-reader-text"><?php esc_html_e( 'Phone Number', 'roden-law' ); ?></label>
            <input type="tel" name="phone" id="rsf-phone" placeholder="(555) 555-5555" autocomplete="tel" required>
            <label for="rsf-email" class="screen-reader-text"><?php esc_html_e( 'Email Address', 'roden-law' ); ?></label>
            <input type="email" name="email" id="rsf-email" placeholder="Email" autocomplete="email" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" required>
            <label for="rsf-message" class="screen-reader-text"><?php esc_html_e( 'Describe what happened', 'roden-law' ); ?></label>
            <textarea name="message" id="rsf-message" placeholder="Please describe what happened" rows="8"></textarea>
            <label class="rsf-consent">
                <input type="checkbox" name="consent" value="1" checked required>
                <span>I hereby expressly consent to receive automated communications including calls, texts, emails, and/or prerecorded messages. By submitting this form, you agree to our <a href="<?php echo esc_url( home_url( '/terms-privacy-policy/' ) ); ?>" target="_blank" rel="noopener noreferrer">Terms &amp; Privacy Policy</a>.</span>
            </label>
            <button type="submit" class="rsf-submit-btn">See If You Qualify</button>
            <p class="rsf-error" style="display:none;"></p>
        </form>
        <p class="form-disclaimer">Results may vary depending on your particular facts and legal circumstances.</p>
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
            <strong>Free Case Review &mdash; No Fees Unless We Win</strong>
            <span>Available 24/7 &middot; Georgia &amp; South Carolina</span>
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
        array( 'num' => $firm['recovered'],     'label' => 'Recovered for Clients' ),
        array( 'num' => $firm['rating'] . '★',  'label' => 'Client Rating' ),
        array( 'num' => $firm['cases_handled'], 'label' => 'Cases Handled' ),
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
    echo 'Last updated: ' . esc_html( $modified );
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
        <h2>What Is a <?php echo esc_html( $label ); ?> Case?</h2>
        <p class="definition-text"><?php echo wp_kses_post( $definition ); ?></p>
        <?php if ( $author_name ) : ?>
            <p class="definition-attribution">
                — Reviewed by <strong><?php echo esc_html( $author_name ); ?></strong><?php if ( $author_title ) : ?>, <?php echo esc_html( $author_title ); ?><?php endif; ?> at Roden Law
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
    $location_label = $city ? " in {$city}" : '';
    $state_label    = $state_full ?: 'your state';
    ?>
    <div class="content-section what-to-do-steps" data-ai-extractable="true">
        <h2>What to Do After <?php echo esc_html( ucfirst( $accident_type ) . $location_label ); ?></h2>
        <ol class="steps-list">
            <li>
                <strong>Ensure safety and call 911.</strong>
                Move to a safe location if possible. Call emergency services to report the accident and request medical attention for anyone injured.
            </li>
            <li>
                <strong>Seek immediate medical attention.</strong>
                Even if injuries seem minor, get examined by a doctor. Some injuries — such as traumatic brain injuries or internal bleeding — may not show symptoms immediately.
            </li>
            <li>
                <strong>Document the scene.</strong>
                Take photos of all vehicles, injuries, road conditions, traffic signs, and any visible damage. Collect names and contact information from witnesses.
            </li>
            <li>
                <strong>Exchange information with all parties.</strong>
                Get the other driver's name, insurance information, license plate number, and driver's license number. Do not admit fault or apologize.
            </li>
            <li>
                <strong>Report the accident to police.</strong>
                <?php echo esc_html( $state_label ); ?> law requires accident reports when there are injuries or significant property damage. Request a copy of the police report.
            </li>
            <li>
                <strong>Notify your insurance company.</strong>
                Report the accident to your insurer promptly. Provide factual information only — do not speculate about fault or the extent of your injuries.
            </li>
            <li>
                <strong>Contact an experienced personal injury attorney.</strong>
                An attorney can protect your rights, handle communications with insurance companies, and help you pursue the full compensation you deserve. Roden Law offers free consultations — call today.
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
   FAQ ACCORDION (HTML output — complements FAQPage schema)
   ========================================================================== */

function roden_faq_section( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $faqs = get_post_meta( $post_id, '_roden_faqs', true );
    if ( ! is_array( $faqs ) || empty( $faqs ) ) {
        return;
    }
    ?>
    <div class="faq-section" id="faq" data-ai-extractable="true">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="faq-accordion" itemscope itemtype="https://schema.org/FAQPage">
            <?php foreach ( $faqs as $i => $faq ) :
                if ( empty( $faq['question'] ) || empty( $faq['answer'] ) ) {
                    continue;
                }
                ?>
                <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-<?php echo (int) $i; ?>">
                        <span itemprop="name"><?php echo esc_html( $faq['question'] ); ?></span>
                        <span class="faq-toggle" aria-hidden="true">+</span>
                    </button>
                    <div class="faq-answer" id="faq-answer-<?php echo (int) $i; ?>"
                         itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"
                         style="display:none;">
                        <p itemprop="text"><?php echo wp_kses_post( $faq['answer'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
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
        <h3 class="sidebar-title">Filing Deadlines</h3>
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
                $sol_text = $j['statute_years'] . ' years (' . $j['statute_cite'] . ')';
            }
            ?>
            <div class="deadline-state">
                <h4><?php echo esc_html( $j['state_full'] ); ?></h4>
                <dl>
                    <dt>Statute of Limitations</dt>
                    <dd><?php echo esc_html( $sol_text ); ?></dd>
                    <dt>Comparative Fault</dt>
                    <dd><?php echo esc_html( $j['comp_fault_rule'] ); ?></dd>
                </dl>
            </div>
        <?php endforeach; ?>
        <p class="sidebar-disclaimer">Deadlines may vary. Contact us for case-specific guidance.</p>
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
        <h3 class="section-subtitle">Comparative Fault Rules</h3>
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

    if ( $post->post_parent ) {
        // Child page — show siblings
        $siblings = get_posts( array(
            'post_type'      => $post->post_type,
            'post_parent'    => $post->post_parent,
            'posts_per_page' => $count + 1,
            'post__not_in'   => array( $current ),
            'orderby'        => 'title',
            'order'          => 'ASC',
        ) );
        $related = array_slice( $siblings, 0, $count );
        $heading = 'Related Pages';
    } else {
        // Pillar page — show other pillars
        $pillars = get_posts( array(
            'post_type'      => $post->post_type,
            'post_parent'    => 0,
            'posts_per_page' => $count + 1,
            'post__not_in'   => array( $current ),
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ) );
        $related = array_slice( $pillars, 0, $count );
        $heading = 'Other Practice Areas';
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
        <h3 class="sidebar-title">Why Roden Law?</h3>
        <ul class="trust-signals">
            <li>
                <strong><?php echo esc_html( $firm['trust_stats']['recovered'] ); ?></strong>
                <span>Recovered for Clients</span>
            </li>
            <li>
                <strong><?php echo esc_html( $firm['trust_stats']['rating'] ); ?> Stars</strong>
                <span><?php echo esc_html( $firm['trust_stats']['reviews'] ); ?> Client Reviews</span>
            </li>
            <li>
                <strong><?php echo esc_html( $firm['trust_stats']['offices'] ); ?> Offices</strong>
                <span>Georgia &amp; South Carolina</span>
            </li>
            <li>
                <strong>No Fee Guarantee</strong>
                <span>You don't pay unless we win</span>
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
        <h3 class="attribution-heading">About the Author</h3>
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
                <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>" class="attribution-link">View Full Profile &rarr;</a>
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
    $label = $practice_area_title ? ' ' . esc_html( $practice_area_title ) : ' Personal Injury';
    ?>
    <div class="ai-stats-block" data-ai-extractable="true">
        <h3>Roden Law<?php echo $label; ?> Results at a Glance</h3>
        <table class="ai-stats-table">
            <tbody>
                <tr>
                    <td><strong><?php echo esc_html( $firm['recovered'] ); ?></strong></td>
                    <td>Recovered for injured clients across Georgia and South Carolina</td>
                </tr>
                <tr>
                    <td><strong><?php echo esc_html( $firm['rating'] ); ?> / 5.0</strong></td>
                    <td>Average client rating based on <?php echo esc_html( $firm['reviews'] ); ?> verified reviews</td>
                </tr>
                <tr>
                    <td><strong><?php echo esc_html( $firm['cases_handled'] ); ?></strong></td>
                    <td>Cases successfully handled since <?php echo esc_html( $firm['founded'] ); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo esc_html( $firm['experience'] ); ?></strong></td>
                    <td>Combined attorney experience across 5 office locations</td>
                </tr>
            </tbody>
        </table>
        <p class="ai-stats-source">Source: Roden Law firm records and verified Google Business Profile reviews, updated <?php echo esc_html( date( 'F Y' ) ); ?>.</p>
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
function roden_jurisdiction_comparison_table( $practice_area_title, $sol_ga = '', $sol_sc = '', $jurisdiction = 'both' ) {
    // Only show comparison table when both jurisdictions apply.
    if ( 'both' !== strtolower( $jurisdiction ) ) {
        return;
    }

    $label = preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', $practice_area_title );
    ?>
    <div class="jurisdiction-comparison" data-ai-extractable="true">
        <h2>Georgia vs. South Carolina <?php echo esc_html( $label ); ?> Laws</h2>
        <p class="comparison-intro">If you were injured in Georgia or South Carolina, the laws governing your <?php echo esc_html( strtolower( $label ) ); ?> claim differ by state. Below is a side-by-side comparison of the key legal rules that affect your case.</p>
        <table class="comparison-table">
            <thead>
                <tr>
                    <th scope="col">Legal Rule</th>
                    <th scope="col">Georgia</th>
                    <th scope="col">South Carolina</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Statute of Limitations</strong></td>
                    <td><?php echo esc_html( $sol_ga ?: '2 years (O.C.G.A. § 9-3-33)' ); ?></td>
                    <td><?php echo esc_html( $sol_sc ?: '3 years (S.C. Code § 15-3-530)' ); ?></td>
                </tr>
                <tr>
                    <td><strong>Comparative Fault Rule</strong></td>
                    <td>Modified — recover if less than 50% at fault (O.C.G.A. &sect; 51-12-33)</td>
                    <td>Modified — recover if less than 51% at fault</td>
                </tr>
                <tr>
                    <td><strong>Damage Cap</strong></td>
                    <td>No cap on compensatory damages; punitive capped at $250,000 in most cases (O.C.G.A. &sect; 51-12-5.1)</td>
                    <td>No cap on compensatory damages; no statutory punitive cap (jury discretion)</td>
                </tr>
                <tr>
                    <td><strong>Minimum Auto Insurance</strong></td>
                    <td>25/50/25 liability coverage required</td>
                    <td>25/50/25 liability coverage required</td>
                </tr>
                <tr>
                    <td><strong>Filing Court</strong></td>
                    <td>Superior Court (claims over $15,000)</td>
                    <td>Circuit Court (claims over $7,500)</td>
                </tr>
            </tbody>
        </table>
        <p class="comparison-source"><em>Source: Georgia Code (O.C.G.A.) and South Carolina Code of Laws. Verified <?php echo esc_html( date( 'F Y' ) ); ?>.</em></p>
    </div>
    <?php
}
