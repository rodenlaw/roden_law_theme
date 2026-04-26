<?php
/**
 * Homepage Template (front-page.php)
 *
 * Full homepage with: hero + contact form, trust bar, practice areas grid,
 * locations grid (6 offices), case results, testimonials, and bottom CTA.
 *
 * Schema output for this page (auto via functions.php):
 * Organization, LegalService, LocalBusiness ×5, Speakable,
 * AggregateRating, WebSite (Sitelinks Searchbox)
 *
 * @package Roden_Law
 */

get_header();

$firm  = roden_firm_data();
$stats = $firm['trust_stats'];

// Top 15 case results from CPT (sorted by raw amount, highest first)
$top_results_query = new WP_Query( array(
    'post_type'      => 'case_result',
    'posts_per_page' => 15,
    'orderby'        => 'meta_value_num',
    'meta_key'       => '_roden_case_amount_raw',
    'order'          => 'DESC',
) );

// Featured practice areas for grid
$practice_areas = array(
    array( 'name' => 'Car Accident Lawyers',        'slug' => 'car-accident-lawyers',        'scenario' => 'Injured in a car accident?' ),
    array( 'name' => 'Truck Accident Lawyers',       'slug' => 'truck-accident-lawyers',       'scenario' => 'Hit by a commercial truck?' ),
    array( 'name' => 'Motorcycle Accident Lawyers',  'slug' => 'motorcycle-accident-lawyers',  'scenario' => 'Motorcycle crash injuries?' ),
    array( 'name' => 'Pedestrian Accident Lawyers',  'slug' => 'pedestrian-accident-lawyers',  'scenario' => 'Struck as a pedestrian?' ),
);
?>

    <!-- ============================================================
         HERO SECTION
         ============================================================ -->
    <section class="hero hero-homepage">
        <div class="site-container">
            <div class="hero-grid">

                <!-- Hero Content -->
                <div class="hero-content">
                    <h1>
                        <?php esc_html_e( 'Georgia & South Carolina', 'roden-law' ); ?><br>
                        <span class="text-orange"><?php esc_html_e( 'Personal Injury Lawyers', 'roden-law' ); ?></span><br>
                        <?php esc_html_e( 'Who Fight for Maximum Compensation', 'roden-law' ); ?>
                    </h1>

                    <p class="hero-description">
                        <?php
                        printf(
                            /* translators: %s: amount recovered */
                            esc_html__( 'Roden Law has recovered %s for injury victims across Savannah, Charleston, North Charleston, Columbia, Myrtle Beach, and Darien. No fees unless we win. Free case review 24/7.', 'roden-law' ),
                            '<strong>' . esc_html( $stats['recovered'] ) . '</strong>'
                        );
                        ?>
                    </p>

                    <!-- Trust Stats Row -->
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <span class="stat-number"><?php echo esc_html( $stats['recovered'] ); ?></span>
                            <span class="stat-label"><?php esc_html_e( 'Recovered for Clients', 'roden-law' ); ?></span>
                        </div>
                        <div class="hero-stat">
                            <span class="stat-number"><?php echo esc_html( $stats['rating'] ); ?>&#9733;</span>
                            <span class="stat-label"><?php esc_html_e( 'Client Rating', 'roden-law' ); ?></span>
                        </div>
                        <div class="hero-stat">
                            <span class="stat-number"><?php echo esc_html( $stats['cases'] ); ?></span>
                            <span class="stat-label"><?php esc_html_e( 'Cases Handled', 'roden-law' ); ?></span>
                        </div>
                    </div>

                    <p class="hero-guarantee">&#10003; No Fees Unless We Win &bull; Free Consultation 24/7</p>

                    <!-- Hero CTAs -->
                    <div class="hero-ctas">
                        <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>"
                           class="btn btn-primary btn-lg">
                            <?php
                            printf(
                                /* translators: %s: vanity phone */
                                esc_html__( 'Call %s', 'roden-law' ),
                                esc_html( $firm['vanity_phone'] )
                            );
                            ?>
                        </a>
                    </div>
                </div>

                <!-- Hero Contact Form -->
                <div class="hero-form" id="free-case-review">
                    <?php roden_contact_form_sidebar(); ?>
                </div>

            </div><!-- .hero-grid -->
        </div><!-- .site-container -->
    </section>


    <!-- ============================================================
         BADGE BAR — Bar Association Memberships
         ============================================================ -->
    <div class="badge-bar" aria-label="<?php esc_attr_e( 'Bar association memberships', 'roden-law' ); ?>">
        <div class="site-container">
            <div class="badge-bar-inner">
                <div class="badge-item">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/img-badge-state-bar-of-georgia.webp' ); ?>"
                         alt="<?php esc_attr_e( 'State Bar of Georgia', 'roden-law' ); ?>" loading="lazy" width="120" height="60">
                </div>
                <div class="badge-item">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/img-badge-american-association-for-justice.webp' ); ?>"
                         alt="<?php esc_attr_e( 'American Association for Justice', 'roden-law' ); ?>" loading="lazy" width="120" height="60">
                </div>
                <div class="badge-item">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/img-badge-gtla.webp' ); ?>"
                         alt="<?php esc_attr_e( 'Georgia Trial Lawyers Association', 'roden-law' ); ?>" loading="lazy" width="120" height="60">
                </div>
                <div class="badge-item">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/img-badge-aba.webp' ); ?>"
                         alt="<?php esc_attr_e( 'American Bar Association', 'roden-law' ); ?>" loading="lazy" width="120" height="60">
                </div>
            </div>
        </div>
    </div>


    <!-- ============================================================
         HOW IT WORKS — 3-Step Process
         ============================================================ -->
    <section class="section" id="how-it-works">
        <div class="site-container">
            <div class="section-header">
                <h2><?php esc_html_e( 'How It Works', 'roden-law' ); ?></h2>
                <p><?php esc_html_e( 'Getting started is simple — and completely free.', 'roden-law' ); ?></p>
            </div>

            <div class="how-it-works-grid">
                <div class="how-it-works-step">
                    <span class="step-number">1</span>
                    <h3><?php esc_html_e( 'Free Consultation', 'roden-law' ); ?></h3>
                    <p><?php esc_html_e( 'Tell us what happened. We\'ll review your case for free — no obligation.', 'roden-law' ); ?></p>
                </div>
                <div class="how-it-works-step">
                    <span class="step-number">2</span>
                    <h3><?php esc_html_e( 'We Build Your Case', 'roden-law' ); ?></h3>
                    <p><?php esc_html_e( 'Our attorneys investigate, gather evidence, and handle all legal work.', 'roden-law' ); ?></p>
                </div>
                <div class="how-it-works-step">
                    <span class="step-number">3</span>
                    <h3><?php esc_html_e( 'You Get Compensated', 'roden-law' ); ?></h3>
                    <p><?php esc_html_e( 'We negotiate maximum compensation. No fees unless we win.', 'roden-law' ); ?></p>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================================================
         PRACTICE AREAS GRID
         ============================================================ -->
    <section class="section section-alt" id="practice-areas">
        <div class="site-container">
            <div class="section-header">
                <h2><?php esc_html_e( 'Personal Injury Practice Areas', 'roden-law' ); ?></h2>
                <p><?php esc_html_e( 'We handle all types of personal injury cases throughout Georgia and South Carolina.', 'roden-law' ); ?></p>
            </div>

            <div class="practice-area-grid">
                <?php foreach ( $practice_areas as $pa ) : ?>
                    <a href="<?php echo esc_url( home_url( '/practice-areas/' . $pa['slug'] . '/' ) ); ?>"
                       class="card practice-area-card">
                        <div>
                            <span class="card-scenario"><?php echo esc_html( $pa['scenario'] ); ?></span>
                            <h3><?php echo esc_html( $pa['name'] ); ?></h3>
                        </div>
                        <span class="card-arrow" aria-hidden="true">&rarr;</span>
                    </a>
                <?php endforeach; ?>
                <a href="<?php echo esc_url( home_url( '/practice-areas/' ) ); ?>"
                   class="card practice-area-card">
                    <h3><?php esc_html_e( 'Other Personal Injury Types', 'roden-law' ); ?></h3>
                    <span class="card-arrow" aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </section>


    <!-- ============================================================
         LOCATIONS GRID — 6 OFFICES
         ============================================================ -->
    <section class="section" id="locations">
        <div class="site-container">
            <div class="section-header">
                <h2><?php esc_html_e( 'Our Offices in Georgia & South Carolina', 'roden-law' ); ?></h2>
            </div>

            <div class="locations-grid">
                <?php foreach ( $firm['offices'] as $key => $office ) : ?>
                    <div class="card location-card">
                        <span class="badge <?php echo 'GA' === $office['state'] ? 'badge-ga' : 'badge-sc'; ?>">
                            <?php echo esc_html( $office['state'] ); ?>
                        </span>
                        <h3><?php echo esc_html( $office['market_name'] ); ?></h3>
                        <address>
                            <?php echo esc_html( $office['street'] ); ?><br>
                            <?php echo esc_html( $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] ); ?>
                        </address>
                        <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="location-phone">
                            <?php echo esc_html( $office['phone'] ); ?>
                        </a>
                        <a href="<?php echo esc_url( home_url( '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['market_name'] ) . '/' ) ); ?>"
                           class="location-link">
                            <?php esc_html_e( 'View Office', 'roden-law' ); ?> &rarr;
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!-- ============================================================
         WHY RODEN LAW — Founder Story
         ============================================================ -->
    <section class="section founder-section" id="why-roden-law">
        <div class="site-container">
            <div class="founder-grid">

                <div class="founder-image">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/img-hero-eric-roden-2024-desktop.png' ); ?>"
                         alt="<?php esc_attr_e( 'Eric Roden, Founding Partner of Roden Law', 'roden-law' ); ?>"
                         width="600" height="720" loading="lazy">
                </div>

                <div class="founder-content">
                    <h2><?php esc_html_e( 'Why Roden Law?', 'roden-law' ); ?></h2>

                    <blockquote class="founder-quote">
                        <p><?php esc_html_e( 'I started Roden Law because I saw too many injury victims get lowballed by insurance companies. Our team fights for every dollar you deserve — and we don\'t get paid unless you do.', 'roden-law' ); ?></p>
                        <cite><?php esc_html_e( '— Eric Roden, Founding Partner', 'roden-law' ); ?></cite>
                    </blockquote>

                    <div class="founder-values">
                        <div class="founder-value">
                            <strong><?php esc_html_e( '$250M+ Recovered', 'roden-law' ); ?></strong>
                            <span><?php esc_html_e( 'Proven track record across Georgia and South Carolina', 'roden-law' ); ?></span>
                        </div>
                        <div class="founder-value">
                            <strong><?php esc_html_e( 'No Upfront Costs', 'roden-law' ); ?></strong>
                            <span><?php esc_html_e( '100% contingency. You pay nothing unless we win.', 'roden-law' ); ?></span>
                        </div>
                        <div class="founder-value">
                            <strong><?php esc_html_e( '6 Office Locations', 'roden-law' ); ?></strong>
                            <span><?php esc_html_e( 'Local attorneys in Savannah, Charleston, North Charleston, Columbia, Myrtle Beach, and Darien', 'roden-law' ); ?></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ============================================================
         CASE RESULTS
         ============================================================ -->
    <section class="section bg-navy" id="results">
        <div class="site-container">
            <div class="section-header">
                <h2 class="text-white"><?php esc_html_e( 'Our Results Speak for Themselves', 'roden-law' ); ?></h2>
            </div>

            <div class="results-carousel">
                <button class="results-arrow results-arrow-left" aria-label="<?php esc_attr_e( 'Scroll left', 'roden-law' ); ?>">&lsaquo;</button>
                <div class="results-track">
                    <?php
                    while ( $top_results_query->have_posts() ) : $top_results_query->the_post();
                        $amount   = get_post_meta( get_the_ID(), '_roden_case_amount', true );
                        $type     = get_post_meta( get_the_ID(), '_roden_case_type', true );
                        $title    = get_the_title();
                        // Extract category from title: "$27,000,000 Settlement | Truck Accident"
                        $category = '';
                        if ( strpos( $title, '|' ) !== false ) {
                            $category = trim( substr( $title, strpos( $title, '|' ) + 1 ) );
                        }
                    ?>
                        <div class="card case-result-card case-result-card-dark">
                            <?php if ( $category ) : ?>
                                <span class="case-type"><?php echo esc_html( $category ); ?></span>
                            <?php endif; ?>
                            <span class="amount"><?php echo esc_html( $amount ); ?></span>
                            <?php if ( $type ) : ?>
                                <span class="case-label"><?php echo esc_html( ucfirst( $type ) ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
                <button class="results-arrow results-arrow-right" aria-label="<?php esc_attr_e( 'Scroll right', 'roden-law' ); ?>">&rsaquo;</button>
            </div>
        </div>
    </section>


    <!-- ============================================================
         TESTIMONIALS — Google Reviews via Trustindex
         ============================================================ -->
    <section class="section section-alt" id="testimonials">
        <div class="site-container">
            <div class="testimonial-social-proof">
                <div class="social-proof-stars" aria-label="<?php esc_attr_e( '5 star rating', 'roden-law' ); ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <h2><?php esc_html_e( '500+ Five-Star Reviews', 'roden-law' ); ?></h2>
                <p><?php esc_html_e( 'Our clients trust us to fight for maximum compensation.', 'roden-law' ); ?></p>
            </div>

            <?php echo do_shortcode( '[trustindex data-widget-id="fe3ce9843b72815ccc26abe2c19"]' ); ?>
        </div>
    </section>


    <!-- ============================================================
         MEET OUR ATTORNEYS — Team Spotlight
         ============================================================ -->
    <?php
    $attorney_query = new WP_Query( array(
        'post_type'      => 'attorney',
        'posts_per_page' => 4,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ) );

    if ( $attorney_query->have_posts() ) : ?>
    <section class="section" id="attorneys">
        <div class="site-container">
            <div class="section-header">
                <h2><?php esc_html_e( 'Meet Our Attorneys', 'roden-law' ); ?></h2>
                <p><?php esc_html_e( 'Experienced trial lawyers fighting for injury victims across Georgia and South Carolina.', 'roden-law' ); ?></p>
            </div>

            <div class="attorney-spotlight-grid">
                <?php while ( $attorney_query->have_posts() ) : $attorney_query->the_post();
                    $title = get_post_meta( get_the_ID(), '_roden_title', true );
                ?>
                    <div class="attorney-spotlight-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="attorney-spotlight-photo">
                                <?php the_post_thumbnail( 'medium', array( 'loading' => 'lazy' ) ); ?>
                            </div>
                        <?php endif; ?>
                        <h3><?php the_title(); ?></h3>
                        <?php if ( $title ) : ?>
                            <p class="attorney-spotlight-title"><?php echo esc_html( $title ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="text-center" style="margin-top: var(--space-xl);">
                <a href="<?php echo esc_url( home_url( '/attorneys/' ) ); ?>" class="btn btn-outline-navy">
                    <?php esc_html_e( 'Meet the Full Team', 'roden-law' ); ?> &rarr;
                </a>
            </div>
        </div>
    </section>
    <?php
    endif;
    wp_reset_postdata();
    ?>


    <!-- ============================================================
         BOTTOM CTA BANNER
         ============================================================ -->
    <section class="section bg-navy cta-bottom">
        <div class="site-container text-center">
            <h2 class="text-white"><?php esc_html_e( 'Injured? Get Your Free Case Review Today.', 'roden-law' ); ?></h2>
            <p class="text-white" style="opacity:0.85; max-width:600px; margin:0 auto var(--space-xl);">
                <?php esc_html_e( 'No fees unless we win. Available 24/7 across Georgia and South Carolina.', 'roden-law' ); ?>
            </p>
            <div class="hero-ctas" style="justify-content:center;">
                <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>"
                   class="btn btn-primary btn-lg">
                    <?php
                    printf(
                        esc_html__( 'Call %s', 'roden-law' ),
                        esc_html( $firm['vanity_phone'] )
                    );
                    ?>
                </a>
                <a href="#free-case-review" class="btn btn-outline-white btn-lg">
                    <?php esc_html_e( 'Free Case Review', 'roden-law' ); ?>
                </a>
            </div>
        </div>
    </section>

<?php get_footer();
