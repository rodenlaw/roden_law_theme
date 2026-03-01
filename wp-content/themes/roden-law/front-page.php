<?php
/**
 * Homepage Template (front-page.php)
 *
 * Full homepage with: hero + contact form, trust bar, practice areas grid,
 * locations grid (5 offices), case results, testimonials, and bottom CTA.
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

// Notable case results (hardcoded from CLAUDE.md — can be replaced by CPT query later)
$featured_results = array(
    array( 'amount' => '$27,000,000', 'type' => 'Truck Accident',     'label' => 'Settlement', 'offer' => '$500,000',  'multiplier' => '54x' ),
    array( 'amount' => '$10,860,000', 'type' => 'Product Liability',  'label' => 'Verdict',    'offer' => '$250,000',  'multiplier' => '43x' ),
    array( 'amount' => '$9,800,000',  'type' => 'Premises Liability', 'label' => 'Recovery',   'offer' => '$200,000',  'multiplier' => '49x' ),
    array( 'amount' => '$3,000,000',  'type' => 'Auto Accident',      'label' => 'Settlement', 'offer' => '$75,000',   'multiplier' => '40x' ),
);

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
                            esc_html__( 'Roden Law has recovered %s for injury victims across Savannah, Charleston, Columbia, Myrtle Beach, and Darien. No fees unless we win. Free case review 24/7.', 'roden-law' ),
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
                        <div class="hero-stat">
                            <span class="stat-number"><?php echo esc_html( $stats['experience'] ); ?> <?php esc_html_e( 'Yrs', 'roden-law' ); ?></span>
                            <span class="stat-label"><?php esc_html_e( 'Combined Experience', 'roden-law' ); ?></span>
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
                        <a href="#free-case-review" class="btn btn-outline-white btn-lg">
                            <?php esc_html_e( 'Free Case Review', 'roden-law' ); ?>
                        </a>
                    </div>
                </div>

                <!-- Hero Contact Form -->
                <div class="hero-form" id="free-case-review">
                    <div class="hero-form-inner hero-form-light">
                        <h2 class="hero-form-title"><?php esc_html_e( 'Free Case Review', 'roden-law' ); ?></h2>
                        <p class="hero-form-subtitle"><?php esc_html_e( 'No fees unless we win', 'roden-law' ); ?> &bull; <?php esc_html_e( '500+ 5-star reviews', 'roden-law' ); ?></p>

                        <?php
                        if ( shortcode_exists( 'gravityform' ) ) {
                            echo do_shortcode( '[gravityform id="1" title="false" description="false" ajax="true"]' );
                        } elseif ( shortcode_exists( 'wpforms' ) ) {
                            echo do_shortcode( '[wpforms id="1" title="false" description="false"]' );
                        } else {
                            // Fallback form
                            ?>
                            <form class="hero-contact-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
                                <div class="form-group">
                                    <input type="text" name="full_name"
                                           placeholder="<?php esc_attr_e( 'Full Name', 'roden-law' ); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email"
                                           placeholder="<?php esc_attr_e( 'Email', 'roden-law' ); ?>">
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <input type="tel" name="phone"
                                               placeholder="<?php esc_attr_e( 'Phone', 'roden-law' ); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="zip" inputmode="numeric" pattern="[0-9]{5}"
                                               placeholder="<?php esc_attr_e( 'Zip Code', 'roden-law' ); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select name="case_type" required>
                                        <option value="" disabled selected><?php esc_attr_e( 'Case Type', 'roden-law' ); ?></option>
                                        <option value="car-accident"><?php esc_html_e( 'Car Accident', 'roden-law' ); ?></option>
                                        <option value="truck-accident"><?php esc_html_e( 'Truck Accident', 'roden-law' ); ?></option>
                                        <option value="motorcycle-accident"><?php esc_html_e( 'Motorcycle Accident', 'roden-law' ); ?></option>
                                        <option value="pedestrian-accident"><?php esc_html_e( 'Pedestrian Accident', 'roden-law' ); ?></option>
                                        <option value="other"><?php esc_html_e( 'Other Personal Injury', 'roden-law' ); ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <textarea name="description" rows="3"
                                              placeholder="<?php esc_attr_e( 'Tell us what happened...', 'roden-law' ); ?>"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-cta-submit">
                                        <?php esc_html_e( 'Review My Case', 'roden-law' ); ?>
                                    </button>
                                </div>
                                <p class="hero-form-trust"><?php esc_html_e( '100% Free', 'roden-law' ); ?> &bull; <?php esc_html_e( 'No Obligation', 'roden-law' ); ?> &bull; <?php esc_html_e( 'Confidential', 'roden-law' ); ?></p>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
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
                    <span class="badge-icon" aria-hidden="true"></span>
                    <span class="badge-label"><?php esc_html_e( 'State Bar of Georgia', 'roden-law' ); ?></span>
                </div>
                <div class="badge-item">
                    <span class="badge-icon" aria-hidden="true"></span>
                    <span class="badge-label"><?php esc_html_e( 'American Association for Justice', 'roden-law' ); ?></span>
                </div>
                <div class="badge-item">
                    <span class="badge-icon" aria-hidden="true"></span>
                    <span class="badge-label"><?php esc_html_e( 'Georgia Trial Lawyers', 'roden-law' ); ?></span>
                </div>
                <div class="badge-item">
                    <span class="badge-icon" aria-hidden="true"></span>
                    <span class="badge-label"><?php esc_html_e( 'American Bar Association', 'roden-law' ); ?></span>
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
         LOCATIONS GRID — 5 OFFICES
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
                        <h3><?php echo esc_html( $office['city'] ); ?></h3>
                        <address>
                            <?php echo esc_html( $office['street'] ); ?><br>
                            <?php echo esc_html( $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] ); ?>
                        </address>
                        <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="location-phone">
                            <?php echo esc_html( $office['phone'] ); ?>
                        </a>
                        <a href="<?php echo esc_url( home_url( '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['city'] ) . '/' ) ); ?>"
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
                            <strong><?php esc_html_e( '5 Office Locations', 'roden-law' ); ?></strong>
                            <span><?php esc_html_e( 'Local attorneys in Savannah, Charleston, Columbia, Myrtle Beach, and Darien', 'roden-law' ); ?></span>
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

            <div class="results-grid">
                <?php foreach ( $featured_results as $result ) : ?>
                    <div class="card case-result-card case-result-card-dark">
                        <span class="case-type"><?php echo esc_html( $result['type'] ); ?></span>
                        <span class="case-offer"><?php esc_html_e( 'Insurance Offered:', 'roden-law' ); ?> <?php echo esc_html( $result['offer'] ); ?></span>
                        <span class="amount"><?php echo esc_html( $result['amount'] ); ?></span>
                        <span class="case-multiplier"><?php echo esc_html( $result['multiplier'] ); ?> <?php esc_html_e( 'More', 'roden-law' ); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php
            // Also try to pull from published case_result CPT posts
            $case_query = new WP_Query( array(
                'post_type'      => 'case_result',
                'posts_per_page' => 4,
                'orderby'        => 'meta_value_num',
                'meta_key'       => '_roden_case_amount',
                'order'          => 'DESC',
            ) );

            if ( $case_query->have_posts() ) : ?>
                <div class="results-grid results-grid-cpt" style="margin-top: var(--space-xl);">
                    <?php while ( $case_query->have_posts() ) : $case_query->the_post();
                        $amount = get_post_meta( get_the_ID(), '_roden_case_amount', true );
                        $type   = get_post_meta( get_the_ID(), '_roden_case_type', true );
                        if ( $amount ) :
                            // Format amount as currency
                            $formatted = '$' . number_format( (float) $amount );
                    ?>
                        <div class="card case-result-card case-result-card-dark">
                            <?php if ( $type ) : ?>
                                <span class="case-type"><?php echo esc_html( $type ); ?></span>
                            <?php endif; ?>
                            <span class="amount"><?php echo esc_html( $formatted ); ?></span>
                            <span class="case-description"><?php the_title(); ?></span>
                        </div>
                    <?php endif; endwhile; ?>
                </div>
            <?php
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </section>


    <!-- ============================================================
         TESTIMONIALS — Carousel with Social Proof
         ============================================================ -->
    <?php
    $testimonial_query = new WP_Query( array(
        'post_type'      => 'testimonial',
        'posts_per_page' => 6,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    if ( $testimonial_query->have_posts() ) :
        $testimonial_count = $testimonial_query->post_count;
    ?>
    <section class="section section-alt" id="testimonials">
        <div class="site-container">
            <div class="testimonial-social-proof">
                <div class="social-proof-stars" aria-label="<?php esc_attr_e( '5 star rating', 'roden-law' ); ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <h2><?php esc_html_e( '500+ Five-Star Reviews', 'roden-law' ); ?></h2>
                <p><?php esc_html_e( 'Our clients trust us to fight for maximum compensation.', 'roden-law' ); ?></p>
            </div>

            <div class="testimonial-carousel" data-total="<?php echo esc_attr( $testimonial_count ); ?>">
                <div class="testimonial-track">
                    <?php while ( $testimonial_query->have_posts() ) : $testimonial_query->the_post(); ?>
                        <div class="card testimonial-card">
                            <span class="testimonial-quote" aria-hidden="true">&#x201C;&#x201C;</span>
                            <div class="testimonial-text">
                                <?php the_content(); ?>
                            </div>
                            <div class="testimonial-footer">
                                <p class="author"><?php the_title(); ?></p>
                                <div class="stars" aria-label="<?php esc_attr_e( '5 star rating', 'roden-law' ); ?>">
                                    &#9733;&#9733;&#9733;&#9733;&#9733;
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php if ( $testimonial_count > 3 ) : ?>
                <div class="testimonial-dots">
                    <?php
                    $total_pages = ceil( $testimonial_count / 3 );
                    for ( $i = 0; $i < $total_pages; $i++ ) :
                    ?>
                        <button class="testimonial-dot<?php echo 0 === $i ? ' active' : ''; ?>"
                                data-page="<?php echo esc_attr( $i ); ?>"
                                aria-label="<?php printf( esc_attr__( 'Go to testimonial page %d', 'roden-law' ), $i + 1 ); ?>"></button>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
    endif;
    wp_reset_postdata();
    ?>


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
