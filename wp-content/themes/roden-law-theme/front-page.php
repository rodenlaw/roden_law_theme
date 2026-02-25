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
    array( 'amount' => '$27,000,000', 'type' => 'Truck Accident',    'label' => 'Settlement' ),
    array( 'amount' => '$10,860,000', 'type' => 'Product Liability', 'label' => 'Verdict' ),
    array( 'amount' => '$9,800,000',  'type' => 'Premises Liability','label' => 'Recovery' ),
    array( 'amount' => '$3,000,000',  'type' => 'Auto Accident',     'label' => 'Settlement' ),
);

// 18 practice areas for grid
$practice_areas = array(
    array( 'name' => 'Car Accident Lawyers',          'slug' => 'car-accident-lawyers' ),
    array( 'name' => 'Truck Accident Lawyers',         'slug' => 'truck-accident-lawyers' ),
    array( 'name' => 'Slip & Fall Lawyers',            'slug' => 'slip-and-fall-lawyers' ),
    array( 'name' => 'Motorcycle Accident Lawyers',    'slug' => 'motorcycle-accident-lawyers' ),
    array( 'name' => 'Medical Malpractice Lawyers',    'slug' => 'medical-malpractice-lawyers' ),
    array( 'name' => 'Wrongful Death Lawyers',         'slug' => 'wrongful-death-lawyers' ),
    array( 'name' => 'Workers\' Compensation Lawyers', 'slug' => 'workers-compensation-lawyers' ),
    array( 'name' => 'Dog Bite Lawyers',               'slug' => 'dog-bite-lawyers' ),
    array( 'name' => 'Brain Injury Lawyers',           'slug' => 'brain-injury-lawyers' ),
    array( 'name' => 'Spinal Cord Injury Lawyers',     'slug' => 'spinal-cord-injury-lawyers' ),
    array( 'name' => 'Maritime Injury Lawyers',        'slug' => 'maritime-injury-lawyers' ),
    array( 'name' => 'Product Liability Lawyers',      'slug' => 'product-liability-lawyers' ),
    array( 'name' => 'Boating Accident Lawyers',       'slug' => 'boating-accident-lawyers' ),
    array( 'name' => 'Burn Injury Lawyers',            'slug' => 'burn-injury-lawyers' ),
    array( 'name' => 'Construction Accident Lawyers',  'slug' => 'construction-accident-lawyers' ),
    array( 'name' => 'Nursing Home Abuse Lawyers',     'slug' => 'nursing-home-abuse-lawyers' ),
    array( 'name' => 'Premises Liability Lawyers',     'slug' => 'premises-liability-lawyers' ),
    array( 'name' => 'Pedestrian Accident Lawyers',    'slug' => 'pedestrian-accident-lawyers' ),
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

                    <!-- Hero CTAs -->
                    <div class="hero-ctas">
                        <a href="tel:<?php echo esc_attr( $firm['offices']['savannah']['phone_raw'] ); ?>"
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
                    <div class="hero-form-inner">
                        <h2 class="hero-form-title"><?php esc_html_e( 'Free Case Review', 'roden-law' ); ?></h2>
                        <p class="hero-form-subtitle"><?php esc_html_e( 'No fees unless we win', 'roden-law' ); ?></p>

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
                                    <input type="tel" name="phone"
                                           placeholder="<?php esc_attr_e( 'Phone Number', 'roden-law' ); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email"
                                           placeholder="<?php esc_attr_e( 'Email', 'roden-law' ); ?>">
                                </div>
                                <div class="form-group">
                                    <textarea name="description" rows="3"
                                              placeholder="<?php esc_attr_e( 'Briefly describe what happened...', 'roden-law' ); ?>"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" style="width:100%;">
                                        <?php esc_html_e( 'Submit Free Review', 'roden-law' ); ?>
                                    </button>
                                </div>
                                <p class="hero-form-footer">
                                    <?php
                                    printf(
                                        /* translators: %s: vanity phone */
                                        esc_html__( '— or call %s —', 'roden-law' ),
                                        esc_html( $firm['vanity_phone'] )
                                    );
                                    ?>
                                </p>
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
         TRUST BAR
         ============================================================ -->
    <div class="trust-bar" aria-label="<?php esc_attr_e( 'Firm credentials', 'roden-law' ); ?>">
        <div class="trust-stat">
            <span class="stat-number"><?php echo esc_html( $stats['recovered'] ); ?></span>
            <span class="stat-label"><?php esc_html_e( 'Recovered', 'roden-law' ); ?></span>
        </div>
        <div class="trust-stat">
            <span class="stat-number"><?php echo esc_html( $stats['rating'] ); ?>&#9733;</span>
            <span class="stat-label"><?php esc_html_e( 'Client Rating', 'roden-law' ); ?></span>
        </div>
        <div class="trust-stat">
            <span class="stat-number"><?php echo esc_html( $stats['cases'] ); ?></span>
            <span class="stat-label"><?php esc_html_e( 'Cases Handled', 'roden-law' ); ?></span>
        </div>
        <div class="trust-stat">
            <span class="stat-number"><?php echo esc_html( $stats['experience'] ); ?> <?php esc_html_e( 'Yrs', 'roden-law' ); ?></span>
            <span class="stat-label"><?php esc_html_e( 'Combined Experience', 'roden-law' ); ?></span>
        </div>
    </div>


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
                        <h3><?php echo esc_html( $pa['name'] ); ?></h3>
                        <span class="card-arrow" aria-hidden="true">&rarr;</span>
                    </a>
                <?php endforeach; ?>
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
                        <a href="<?php echo esc_url( home_url( '/locations/' . strtolower( $office['state'] ) . '/' . sanitize_title( $office['city'] ) . '/' ) ); ?>"
                           class="location-link">
                            <?php esc_html_e( 'View Office', 'roden-law' ); ?> &rarr;
                        </a>
                    </div>
                <?php endforeach; ?>
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
                        <span class="case-type"><?php echo esc_html( $result['label'] ); ?></span>
                        <span class="amount"><?php echo esc_html( $result['amount'] ); ?></span>
                        <span class="case-description"><?php echo esc_html( $result['type'] ); ?></span>
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
         TESTIMONIALS
         ============================================================ -->
    <?php
    $testimonial_query = new WP_Query( array(
        'post_type'      => 'testimonial',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    if ( $testimonial_query->have_posts() ) : ?>
    <section class="section section-alt" id="testimonials">
        <div class="site-container">
            <div class="section-header">
                <h2><?php esc_html_e( 'What Our Clients Say', 'roden-law' ); ?></h2>
                <p>
                    <?php
                    printf(
                        /* translators: %s: star rating */
                        esc_html__( 'Rated %s stars by our clients', 'roden-law' ),
                        esc_html( $stats['rating'] )
                    );
                    ?>
                </p>
            </div>

            <div class="card-grid testimonial-grid">
                <?php while ( $testimonial_query->have_posts() ) : $testimonial_query->the_post(); ?>
                    <div class="card testimonial-card">
                        <div class="stars" aria-label="<?php esc_attr_e( '5 star rating', 'roden-law' ); ?>">
                            &#9733;&#9733;&#9733;&#9733;&#9733;
                        </div>
                        <div class="testimonial-text">
                            <?php the_content(); ?>
                        </div>
                        <p class="author"><?php the_title(); ?></p>
                    </div>
                <?php endwhile; ?>
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
                <a href="tel:<?php echo esc_attr( $firm['offices']['savannah']['phone_raw'] ); ?>"
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
