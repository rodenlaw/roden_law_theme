<?php
/**
 * Template Name: About Page
 *
 * Automatically loaded for the /about/ page (slug match).
 * Also selectable from the Page Template dropdown in the editor.
 * Hero, founder story, commitment section, stats bar, case results,
 * attorneys grid, and bottom CTA.
 *
 * @package Roden_Law
 */

get_header();

$firm = roden_firm_data();
?>

    <!-- ============================================================
         HERO
         ============================================================ -->
    <section class="hero hero-page">
        <div class="site-container">
            <?php roden_breadcrumb_html(); ?>
            <h1 class="hero-title"><?php esc_html_e( 'About Roden Law', 'roden-law' ); ?></h1>
            <p class="hero-subtitle">
                <?php esc_html_e( 'Personal injury attorneys fighting for maximum compensation across Georgia and South Carolina since 2013.', 'roden-law' ); ?>
            </p>
        </div>
    </section>

    <!-- ============================================================
         FOUNDER STORY — 2-Column Grid
         ============================================================ -->
    <section class="section founder-section">
        <div class="site-container">
            <div class="founder-grid">

                <div class="founder-image">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/img-hero-eric-roden-2024-desktop.png' ); ?>"
                         alt="<?php esc_attr_e( 'Eric Roden, Founding Partner of Roden Law', 'roden-law' ); ?>"
                         width="600" height="720" loading="lazy">
                </div>

                <div class="founder-content">
                    <h2><?php esc_html_e( 'Our Story', 'roden-law' ); ?></h2>

                    <p>
                        <?php esc_html_e( 'Roden Law was founded in 2013 by Eric L. Roden and Tyler M. Love with a singular mission: fighting for injury victims. We built our firm on the principle that every person harmed by another\'s negligence deserves aggressive, personal representation — not the assembly-line treatment you get at larger firms.', 'roden-law' ); ?>
                    </p>

                    <p>
                        <?php esc_html_e( 'We understand that serious injuries create emotional, physical, and financial hardship. That\'s why our attorneys personally handle every case — you\'ll always speak directly with a lawyer who knows your story and is invested in your outcome.', 'roden-law' ); ?>
                    </p>

                    <blockquote class="founder-quote">
                        <p><?php esc_html_e( 'I started Roden Law because I saw too many injury victims get lowballed by insurance companies. Our team fights for every dollar you deserve — and we don\'t get paid unless you do.', 'roden-law' ); ?></p>
                        <cite><?php esc_html_e( '— Eric Roden, Founding Partner', 'roden-law' ); ?></cite>
                    </blockquote>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================
         OUR COMMITMENT — Value Propositions
         ============================================================ -->
    <section class="section section-alt">
        <div class="site-container">
            <div class="section-header">
                <h2><?php esc_html_e( 'Our Commitment to You', 'roden-law' ); ?></h2>
                <p><?php esc_html_e( 'At Roden Law, our injury attorneys are not afraid to do what it takes to help you obtain the maximum compensation you deserve — even if it means taking your case to trial.', 'roden-law' ); ?></p>
            </div>

            <div class="commitment-grid">
                <div class="commitment-item">
                    <h3><?php esc_html_e( 'Relentless Advocacy', 'roden-law' ); ?></h3>
                    <p><?php esc_html_e( 'We work tirelessly to secure the best possible outcome for every client, whether through negotiation or trial.', 'roden-law' ); ?></p>
                </div>
                <div class="commitment-item">
                    <h3><?php esc_html_e( 'Consistent Pursuit of Justice', 'roden-law' ); ?></h3>
                    <p><?php esc_html_e( 'We maintain consistency in pursuing justice across every case, no matter the size or complexity.', 'roden-law' ); ?></p>
                </div>
                <div class="commitment-item">
                    <h3><?php esc_html_e( 'Honest Guidance', 'roden-law' ); ?></h3>
                    <p><?php esc_html_e( 'We provide realistic explanations of how we can help and what to expect at every stage of your case.', 'roden-law' ); ?></p>
                </div>
                <div class="commitment-item">
                    <h3><?php esc_html_e( 'Open Communication', 'roden-law' ); ?></h3>
                    <p><?php esc_html_e( 'We prioritize client communication from intake through settlement or trial — you\'ll always know where your case stands.', 'roden-law' ); ?></p>
                </div>
            </div>

            <div class="contingency-callout">
                <h3><?php esc_html_e( 'We Don\'t Get Paid Unless You Do', 'roden-law' ); ?></h3>
                <p>
                    <?php esc_html_e( 'Roden Law operates exclusively on contingency. Our attorneys collect payment only from settlement or verdict proceeds — you will never owe us a fee if we don\'t recover compensation for you. This means our financial interests are completely aligned with yours.', 'roden-law' ); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- ============================================================
         STATS BAR
         ============================================================ -->
    <section class="section bg-navy">
        <div class="site-container">
            <?php roden_stats_bar(); ?>
        </div>
    </section>

    <!-- ============================================================
         CASE RESULTS
         ============================================================ -->
    <section class="section">
        <div class="site-container">
            <div class="section-header">
                <h2><?php esc_html_e( 'Our Results Speak for Themselves', 'roden-law' ); ?></h2>
                <p><?php esc_html_e( 'We have recovered over $250 million for injury victims across Georgia and South Carolina.', 'roden-law' ); ?></p>
            </div>

            <?php roden_case_results_grid( array( 'count' => 3, 'columns' => 3 ) ); ?>

            <div class="text-center" style="margin-top: var(--space-xl);">
                <a href="<?php echo esc_url( home_url( '/case-results/' ) ); ?>" class="btn btn-outline-navy">
                    <?php esc_html_e( 'View All Case Results', 'roden-law' ); ?> &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================================
         MEET OUR ATTORNEYS
         ============================================================ -->
    <section class="section section-alt" id="attorneys">
        <div class="site-container">
            <div class="section-header">
                <h2><?php esc_html_e( 'Meet Our Attorneys', 'roden-law' ); ?></h2>
                <p><?php esc_html_e( 'Experienced trial lawyers fighting for injury victims across Georgia and South Carolina.', 'roden-law' ); ?></p>
            </div>

            <?php roden_attorneys_grid( array( 'columns' => 4, 'role' => 'attorney' ) ); ?>

            <div class="text-center" style="margin-top: var(--space-xl);">
                <a href="<?php echo esc_url( home_url( '/attorneys/' ) ); ?>" class="btn btn-outline-navy">
                    <?php esc_html_e( 'View All Attorneys', 'roden-law' ); ?> &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================================
         BOTTOM CTA
         ============================================================ -->
    <section class="section bg-navy cta-bottom">
        <div class="site-container text-center">
            <h2 class="text-white"><?php esc_html_e( 'Ready to Get Started?', 'roden-law' ); ?></h2>
            <p class="text-white" style="opacity:0.85; max-width:600px; margin:0 auto var(--space-xl);">
                <?php esc_html_e( 'No fees unless we win. Available 24/7 across Georgia and South Carolina.', 'roden-law' ); ?>
            </p>
            <div class="hero-ctas" style="justify-content:center;">
                <a href="tel:<?php echo esc_attr( $firm['phone_raw'] ); ?>"
                   class="btn btn-primary btn-lg">
                    <?php
                    printf(
                        esc_html__( 'Call %s', 'roden-law' ),
                        esc_html( $firm['vanity_phone'] )
                    );
                    ?>
                </a>
            </div>
        </div>
    </section>

<?php get_footer(); ?>
