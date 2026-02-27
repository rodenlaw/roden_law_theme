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
        $office_key = get_post_meta( get_the_ID(), '_roden_office_key', true );
        if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
            $o = $firm['offices'][ $office_key ];
            $crumbs[] = '<a href="' . esc_url( home_url( '/locations/' . $o['state_slug'] . '/' ) ) . '">' . esc_html( $o['state_full'] ) . '</a>';
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
    );
    $args = wp_parse_args( $args, $defaults );

    $query_args = array(
        'post_type'      => 'case_result',
        'posts_per_page' => $args['count'],
        'orderby'        => 'meta_value',
        'meta_key'       => '_roden_case_amount',
        'order'          => 'DESC',
    );

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
    );
    $args = wp_parse_args( $args, $defaults );

    $query_args = array(
        'post_type'      => 'attorney',
        'posts_per_page' => $args['count'],
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );
    if ( $args['office_key'] ) {
        $query_args['meta_query'] = array(
            array( 'key' => '_roden_atty_office_key', 'value' => $args['office_key'], 'compare' => '=' ),
        );
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
   LOCATION CARDS (simple office list, optional exclusion)
   ========================================================================== */

function roden_location_cards( $exclude_key = '' ) {
    $firm = roden_firm_data();
    echo '<div class="location-cards-grid">';
    foreach ( $firm['offices'] as $key => $office ) {
        if ( $key === $exclude_key ) {
            continue;
        }
        $url = home_url( '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['city'] ) . '/' );
        ?>
        <div class="location-card">
            <span class="location-state-badge state-<?php echo esc_attr( strtolower( $office['state'] ) ); ?>">
                <?php echo esc_html( $office['state'] ); ?>
            </span>
            <h3 class="location-city">
                <a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $office['city'] ); ?></a>
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
   LOCATION MATRIX — 5-office grid with intersection links per practice area
   ========================================================================== */

/**
 * Render the location matrix showing all 5 offices with links
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
            <span class="matrix-city"><?php echo esc_html( $office['city'] ); ?></span>
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
    $areas = get_posts( array(
        'post_type'      => 'practice_area',
        'posts_per_page' => -1,
        'post_parent'    => 0,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ) );

    // Fallback: hardcoded practice areas if no CPT posts exist yet
    if ( empty( $areas ) ) {
        $fallback = array(
            'Car Accident'          => 'car-accident-lawyers',
            'Truck Accident'        => 'truck-accident-lawyers',
            'Slip & Fall'           => 'slip-and-fall-lawyers',
            'Medical Malpractice'   => 'medical-malpractice-lawyers',
            'Motorcycle Accident'   => 'motorcycle-accident-lawyers',
            'Wrongful Death'        => 'wrongful-death-lawyers',
            'Workers\' Comp'        => 'workers-compensation-lawyers',
            'Dog Bite'              => 'dog-bite-lawyers',
            'Brain Injury'          => 'brain-injury-lawyers',
            'Spinal Cord Injury'    => 'spinal-cord-injury-lawyers',
            'Maritime'              => 'maritime-injury-lawyers',
            'Product Liability'     => 'product-liability-lawyers',
            'Boating Accident'      => 'boating-accident-lawyers',
            'Burn Injury'           => 'burn-injury-lawyers',
            'Construction Accident' => 'construction-accident-lawyers',
            'Nursing Home Abuse'    => 'nursing-home-abuse-lawyers',
            'Premises Liability'    => 'premises-liability-lawyers',
            'Pedestrian Accident'   => 'pedestrian-accident-lawyers',
        );
        echo '<div class="practice-areas-grid cols-' . intval( $columns ) . '">';
        foreach ( $fallback as $name => $slug ) {
            $url = home_url( '/practice-areas/' . $slug . '/' );
            echo '<a href="' . esc_url( $url ) . '" class="practice-area-card">';
            echo '<span class="pa-name">' . esc_html( $name ) . '</span>';
            echo '</a>';
        }
        echo '</div>';
        return;
    }

    echo '<div class="practice-areas-grid cols-' . intval( $columns ) . '">';
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
    echo '</div>';
}

/* ==========================================================================
   CONTACT FORM SIDEBAR (CTA box)
   ========================================================================== */

function roden_contact_form_sidebar( $local_phone = '' ) {
    $firm  = roden_firm_data();
    $phone = $local_phone ?: $firm['phone'];
    ?>
    <div class="sidebar-contact-form">
        <h3 class="form-title">Free Case Review</h3>
        <p class="form-subtitle">No fees unless we win &bull; Available 24/7</p>
        <?php
        if ( shortcode_exists( 'gravityform' ) ) {
            echo do_shortcode( '[gravityform id="1" title="false" description="false" ajax="true"]' );
        } elseif ( shortcode_exists( 'wpforms' ) ) {
            echo do_shortcode( '[wpforms id="1"]' );
        } else {
            ?>
            <form class="roden-contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <input type="hidden" name="action" value="roden_contact_form">
                <?php wp_nonce_field( 'roden_contact', '_roden_contact_nonce' ); ?>
                <input type="text" name="full_name" placeholder="Full Name" required>
                <input type="tel" name="phone" placeholder="Phone Number" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="zip" placeholder="ZIP Code">
                <textarea name="message" placeholder="Briefly describe what happened..." rows="3"></textarea>
                <button type="submit" class="btn btn-primary btn-block">Submit Free Review</button>
            </form>
            <?php
        }
        ?>
        <p class="form-phone-fallback">&mdash; or call <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>"><?php echo esc_html( $phone ); ?></a> &mdash;</p>
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
            <strong>Free Case Evaluation &mdash; No Fees Unless We Win</strong>
            <span>Available 24/7 &middot; Georgia &amp; South Carolina</span>
        </div>
        <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary"><?php echo esc_html( $firm['phone'] ); ?></a>
    </div>
    <?php
}

/* ==========================================================================
   STAR RATING DISPLAY
   ========================================================================== */

function roden_stars( $rating = 4.9, $count = '500+', $small = false ) {
    $class = $small ? 'stars-display stars-small' : 'stars-display';
    echo '<div class="' . esc_attr( $class ) . '">';
    for ( $i = 1; $i <= 5; $i++ ) {
        echo '<span class="star">&#9733;</span>';
    }
    echo '<span class="star-rating">' . esc_html( $rating ) . '</span>';
    echo '<span class="star-count">(' . esc_html( $count ) . ' reviews)</span>';
    echo '</div>';
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
        array( 'num' => $firm['experience'],    'label' => 'Combined Experience' ),
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
    <div class="faq-section" id="faq">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="faq-accordion">
            <?php foreach ( $faqs as $i => $faq ) :
                if ( empty( $faq['question'] ) || empty( $faq['answer'] ) ) {
                    continue;
                }
                ?>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-<?php echo (int) $i; ?>">
                        <span><?php echo esc_html( $faq['question'] ); ?></span>
                        <span class="faq-toggle">+</span>
                    </button>
                    <div class="faq-answer" id="faq-answer-<?php echo (int) $i; ?>" hidden>
                        <p><?php echo wp_kses_post( $faq['answer'] ); ?></p>
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
                <strong><?php echo esc_html( $firm['trust_stats']['experience'] ); ?> Years</strong>
                <span>Combined Experience</span>
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
