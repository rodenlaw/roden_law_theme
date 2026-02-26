<?php
/**
 * Template Tags — reusable display functions
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ─── BREADCRUMB HTML ──────────────────────────────────────────────────── */

function roden_breadcrumb_html() {
    if ( is_front_page() ) return;
    $firm = roden_firm_data();
    $crumbs = [ '<a href="' . esc_url( home_url('/') ) . '">Home</a>' ];

    if ( is_singular( 'practice_area' ) ) {
        $crumbs[] = '<a href="' . esc_url( home_url('/practice-areas/') ) . '">Practice Areas</a>';
        // If child page (intersection or sub-type), show parent pillar
        $pa_post = get_post( get_the_ID() );
        if ( $pa_post->post_parent ) {
            $parent = get_post( $pa_post->post_parent );
            if ( $parent ) {
                $crumbs[] = '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . esc_html( $parent->post_title ) . '</a>';
            }
        }
        $crumbs[] = '<span class="breadcrumb-current">' . get_the_title() . '</span>';
    } elseif ( is_singular( 'location' ) ) {
        $crumbs[] = '<a href="' . esc_url( home_url('/locations/') ) . '">Locations</a>';
        $office_key = get_post_meta( get_the_ID(), '_roden_office_key', true );
        if ( $office_key && isset( $firm['offices'][$office_key] ) ) {
            $o = $firm['offices'][$office_key];
            $state_slug = strtolower( str_replace(' ', '-', $o['state_full']) );
            $crumbs[] = '<a href="' . esc_url( home_url('/locations/' . $state_slug . '/') ) . '">' . esc_html($o['state_full']) . '</a>';
        }
        $crumbs[] = '<span class="breadcrumb-current">' . get_the_title() . '</span>';
    } elseif ( is_singular( 'attorney' ) ) {
        $crumbs[] = '<a href="' . esc_url( home_url('/attorneys/') ) . '">Attorneys</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . get_the_title() . '</span>';
    } elseif ( is_singular( 'post' ) ) {
        $crumbs[] = '<a href="' . esc_url( get_permalink( get_option('page_for_posts') ) ?: home_url('/blog/') ) . '">Blog</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . get_the_title() . '</span>';
    } elseif ( is_singular( 'resource' ) ) {
        $crumbs[] = '<a href="' . esc_url( home_url('/resources/') ) . '">Resources</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . get_the_title() . '</span>';
    } elseif ( is_search() ) {
        $crumbs[] = '<span class="breadcrumb-current">Search Results</span>';
    } elseif ( is_home() ) {
        $crumbs[] = '<span class="breadcrumb-current">Blog</span>';
    } elseif ( is_category() ) {
        $crumbs[] = '<a href="' . esc_url( get_permalink( get_option('page_for_posts') ) ?: home_url('/blog/') ) . '">Blog</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . single_cat_title( '', false ) . '</span>';
    } elseif ( is_tag() ) {
        $crumbs[] = '<a href="' . esc_url( get_permalink( get_option('page_for_posts') ) ?: home_url('/blog/') ) . '">Blog</a>';
        $crumbs[] = '<span class="breadcrumb-current">' . single_tag_title( '', false ) . '</span>';
    } elseif ( is_post_type_archive() ) {
        $crumbs[] = '<span class="breadcrumb-current">' . post_type_archive_title( '', false ) . '</span>';
    } elseif ( is_page() ) {
        $crumbs[] = '<span class="breadcrumb-current">' . get_the_title() . '</span>';
    }

    echo '<nav class="breadcrumbs" aria-label="Breadcrumb"><span class="breadcrumb-list">' . implode( ' <span class="breadcrumb-sep">›</span> ', $crumbs ) . '</span></nav>';
}

/* ─── CASE RESULTS GRID ────────────────────────────────────────────────── */

function roden_case_results_grid( $args = [] ) {
    $defaults = [
        'count'             => 4,
        'practice_category' => '',
        'location_served'   => '',
        'columns'           => 4,
    ];
    $args = wp_parse_args( $args, $defaults );

    $query_args = [
        'post_type'      => 'case_result',
        'posts_per_page' => $args['count'],
        'orderby'        => 'meta_value',
        'meta_key'       => '_roden_cr_amount',
        'order'          => 'DESC',
    ];

    $tax_query = [];
    if ( $args['practice_category'] ) {
        $tax_query[] = [ 'taxonomy' => 'practice_category', 'field' => 'slug', 'terms' => $args['practice_category'] ];
    }
    if ( $args['location_served'] ) {
        $tax_query[] = [ 'taxonomy' => 'location_served', 'field' => 'slug', 'terms' => $args['location_served'] ];
    }
    if ( $tax_query ) $query_args['tax_query'] = $tax_query;

    $results = new WP_Query( $query_args );

    // Fallback: show hardcoded results if no CPT posts exist yet
    if ( ! $results->have_posts() ) {
        $fallback_results = [
            ['amount'=>'$27,000,000', 'type'=>'Settlement', 'title'=>'Truck Accident', 'desc'=>'Client paralyzed in collision with commercial semi-truck.'],
            ['amount'=>'$10,860,000', 'type'=>'Verdict',    'title'=>'Product Liability', 'desc'=>'Defective product caused catastrophic injury.'],
            ['amount'=>'$9,800,000',  'type'=>'Recovery',   'title'=>'Premises Liability', 'desc'=>'Client suffered severe injury due to negligent property maintenance.'],
            ['amount'=>'$3,000,000',  'type'=>'Settlement', 'title'=>'Auto Accident', 'desc'=>'Wrongful death — surviving spouse of auto accident victim.'],
        ];
        $show = array_slice($fallback_results, 0, $args['count']);
        echo '<div class="case-results-grid cols-' . intval($args['columns']) . '">';
        foreach ($show as $r) {
            echo '<div class="result-card">';
            echo '<span class="result-type">' . esc_html($r['type']) . '</span>';
            echo '<span class="result-amount">' . esc_html($r['amount']) . '</span>';
            echo '<span class="result-title">' . esc_html($r['title']) . '</span>';
            echo '<p class="result-desc">' . esc_html($r['desc']) . '</p>';
            echo '</div>';
        }
        echo '</div>';
        echo '<p class="results-disclaimer">Results shown are gross settlement/verdict amounts before fees and costs. Past results do not guarantee similar outcomes.</p>';
        return;
    }

    echo '<div class="case-results-grid cols-' . intval($args['columns']) . '">';
    while ( $results->have_posts() ) : $results->the_post();
        $amount = get_post_meta( get_the_ID(), '_roden_cr_amount', true );
        $type   = get_post_meta( get_the_ID(), '_roden_cr_type', true );
        $desc   = get_post_meta( get_the_ID(), '_roden_cr_description', true );
        ?>
        <div class="result-card">
            <span class="result-type"><?php echo esc_html( $type ); ?></span>
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

/* ─── ATTORNEYS GRID ───────────────────────────────────────────────────── */

function roden_attorneys_grid( $args = [] ) {
    $defaults = [
        'count'      => -1,
        'office_key' => '',
        'columns'    => 4,
    ];
    $args = wp_parse_args( $args, $defaults );

    $query_args = [
        'post_type'      => 'attorney',
        'posts_per_page' => $args['count'],
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ];
    if ( $args['office_key'] ) {
        $query_args['meta_query'] = [
            [ 'key' => '_roden_atty_office_key', 'value' => $args['office_key'], 'compare' => '=' ],
        ];
    }

    $attorneys = new WP_Query( $query_args );
    if ( ! $attorneys->have_posts() ) return;

    echo '<div class="attorneys-grid cols-' . intval($args['columns']) . '">';
    while ( $attorneys->have_posts() ) : $attorneys->the_post();
        $title     = get_post_meta( get_the_ID(), '_roden_atty_title', true );
        $office_k  = get_post_meta( get_the_ID(), '_roden_atty_office_key', true );
        $firm      = roden_firm_data();
        $bar_info  = '';
        if ( $office_k && isset($firm['offices'][$office_k]) ) {
            $bar_info = 'Licensed: ' . $firm['offices'][$office_k]['state'];
        }
        ?>
        <div class="attorney-card">
            <a href="<?php the_permalink(); ?>" class="attorney-card-link">
                <div class="attorney-photo">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'attorney-portrait' ); ?>
                    <?php else : ?>
                        <div class="attorney-photo-placeholder">👤</div>
                    <?php endif; ?>
                </div>
                <h3 class="attorney-name"><?php the_title(); ?></h3>
                <?php if ( $title ) : ?>
                    <span class="attorney-title"><?php echo esc_html( $title ); ?></span>
                <?php endif; ?>
                <?php if ( $bar_info ) : ?>
                    <span class="attorney-bar"><?php echo esc_html( $bar_info ); ?></span>
                <?php endif; ?>
            </a>
        </div>
        <?php
    endwhile;
    echo '</div>';
    wp_reset_postdata();
}

/* ─── LOCATION CARDS ───────────────────────────────────────────────────── */

function roden_location_cards( $exclude_key = '' ) {
    $firm = roden_firm_data();
    echo '<div class="location-cards-grid">';
    foreach ( $firm['offices'] as $key => $office ) {
        if ( $key === $exclude_key ) continue;
        $slug = strtolower( str_replace( ' ', '-', $office['city'] ) );
        $state_slug = $office['state'] === 'GA' ? 'georgia' : 'south-carolina';
        $url = home_url( '/locations/' . $state_slug . '/' . $slug . '/' );
        ?>
        <div class="location-card" itemscope itemtype="https://schema.org/LegalService">
            <span class="location-state-badge state-<?php echo esc_attr( strtolower($office['state']) ); ?>">
                <?php echo esc_html( $office['state'] ); ?>
            </span>
            <h3 class="location-city" itemprop="name">
                <a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $office['city'] ); ?></a>
            </h3>
            <address itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                <span itemprop="streetAddress"><?php echo esc_html( $office['address'] ); ?></span><br>
                <span itemprop="addressLocality"><?php echo esc_html( $office['city'] ); ?></span>,
                <span itemprop="addressRegion"><?php echo esc_html( $office['state'] ); ?></span>
                <span itemprop="postalCode"><?php echo esc_html( $office['zip'] ); ?></span>
            </address>
            <a href="tel:<?php echo esc_attr( $office['phone_e164'] ); ?>" class="location-phone" itemprop="telephone">
                <?php echo esc_html( $office['phone'] ); ?>
            </a>
            <a href="<?php echo esc_url( $url ); ?>" class="location-link">View Office →</a>
        </div>
        <?php
    }
    echo '</div>';
}

/* ─── PRACTICE AREA GRID ──────────────────────────────────────────────── */

function roden_practice_areas_grid( $columns = 4 ) {
    $areas = get_posts( [
        'post_type'      => 'practice_area',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ] );

    // Fallback: show hardcoded practice areas if no CPT posts exist yet
    if ( empty( $areas ) ) {
        $fallback = [
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
        ];
        echo '<div class="practice-areas-grid cols-' . intval($columns) . '">';
        foreach ( $fallback as $name => $slug ) {
            $url = home_url( '/practice-areas/' . $slug . '/' );
            echo '<a href="' . esc_url($url) . '" class="practice-area-card">';
            echo '<span class="pa-icon">⚖</span>';
            echo '<span class="pa-name">' . esc_html($name) . '</span>';
            echo '</a>';
        }
        echo '</div>';
        return;
    }

    echo '<div class="practice-areas-grid cols-' . intval($columns) . '">';
    foreach ( $areas as $area ) {
        ?>
        <a href="<?php echo esc_url( get_permalink( $area ) ); ?>" class="practice-area-card">
            <span class="pa-icon">⚖</span>
            <span class="pa-name"><?php echo esc_html( $area->post_title ); ?></span>
        </a>
        <?php
    }
    echo '</div>';
}

/* ─── CONTACT FORM (simple CTA box) ───────────────────────────────────── */

function roden_contact_form_sidebar( $local_phone = '' ) {
    $firm = roden_firm_data();
    $phone = $local_phone ?: $firm['phone'];
    ?>
    <div class="sidebar-contact-form">
        <h3 class="form-title">Free Case Review</h3>
        <p class="form-subtitle">No fees unless we win • Available 24/7</p>
        <?php
        // If Gravity Forms or WPForms shortcode exists, use it
        if ( shortcode_exists('gravityform') ) {
            echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]');
        } elseif ( shortcode_exists('wpforms') ) {
            echo do_shortcode('[wpforms id="1"]');
        } else {
            // Fallback static form
            ?>
            <form class="roden-contact-form" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                <input type="hidden" name="action" value="roden_contact_form" />
                <?php wp_nonce_field('roden_contact','_roden_contact_nonce'); ?>
                <input type="text" name="full_name" placeholder="Full Name" required />
                <input type="tel" name="phone" placeholder="Phone Number" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="text" name="zip" placeholder="ZIP Code" />
                <textarea name="message" placeholder="Briefly describe what happened..." rows="3"></textarea>
                <button type="submit" class="btn btn-primary btn-block">Submit Free Review</button>
            </form>
            <?php
        }
        ?>
        <p class="form-phone-fallback">— or call <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>"><?php echo esc_html($phone); ?></a> —</p>
    </div>
    <?php
}

/* ─── INLINE CTA BANNER ───────────────────────────────────────────────── */

function roden_inline_cta_banner() {
    $firm = roden_firm_data();
    ?>
    <div class="inline-cta-banner">
        <div class="cta-text">
            <strong>Free Case Evaluation — No Fees Unless We Win</strong>
            <span>Available 24/7 · Georgia &amp; South Carolina</span>
        </div>
        <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary">📞 <?php echo esc_html($firm['phone']); ?></a>
    </div>
    <?php
}

/* ─── STAR RATING DISPLAY ──────────────────────────────────────────────── */

function roden_stars( $rating = 4.9, $count = '500+', $small = false ) {
    $class = $small ? 'stars-display stars-small' : 'stars-display';
    echo '<div class="' . esc_attr($class) . '">';
    for ( $i = 1; $i <= 5; $i++ ) {
        echo '<span class="star">★</span>';
    }
    echo '<span class="star-rating">' . esc_html($rating) . '</span>';
    echo '<span class="star-count">(' . esc_html($count) . ' reviews)</span>';
    echo '</div>';
}

/* ─── STATS BAR ────────────────────────────────────────────────────────── */

function roden_stats_bar() {
    $firm = roden_firm_data();
    $stats = [
        [ 'num' => $firm['recovered'],     'label' => 'Recovered for Clients' ],
        [ 'num' => $firm['rating'] . '★',  'label' => 'Client Rating' ],
        [ 'num' => $firm['cases_handled'], 'label' => 'Cases Handled' ],
        [ 'num' => $firm['experience'],    'label' => 'Combined Experience' ],
    ];
    echo '<div class="stats-bar">';
    foreach ( $stats as $s ) {
        echo '<div class="stat-item">';
        echo '<span class="stat-num">' . esc_html( $s['num'] ) . '</span>';
        echo '<span class="stat-label">' . esc_html( $s['label'] ) . '</span>';
        echo '</div>';
    }
    echo '</div>';
}

/* ─── READING TIME ─────────────────────────────────────────────────────── */

function roden_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( wp_strip_all_tags( $content ) );
    return max( 1, ceil( $word_count / 250 ) );
}

/* ─── FAQ ACCORDION ────────────────────────────────────────────────────── */

function roden_faq_section( $post_id = null ) {
    if ( ! $post_id ) $post_id = get_the_ID();
    $faqs = get_post_meta( $post_id, '_roden_faqs', true );
    if ( ! is_array( $faqs ) || empty( $faqs ) ) return;
    ?>
    <div class="faq-section" id="faq">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="faq-accordion">
            <?php foreach ( $faqs as $i => $faq ) : ?>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-<?php echo $i; ?>">
                        <span><?php echo esc_html( $faq['question'] ); ?></span>
                        <span class="faq-toggle">+</span>
                    </button>
                    <div class="faq-answer" id="faq-answer-<?php echo $i; ?>" hidden>
                        <p><?php echo wp_kses_post( $faq['answer'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
