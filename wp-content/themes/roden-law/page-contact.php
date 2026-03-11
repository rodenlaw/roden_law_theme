<?php
/**
 * Template: Contact Page (page-contact.php)
 *
 * Automatically loaded for the /contact/ page (slug match).
 * Hero, contact form, phone CTA box, office locations.
 *
 * @package Roden_Law
 */

get_header();

$firm  = roden_firm_data();
$stats = $firm['trust_stats'];
?>

    <!-- ============================================================
         HERO
         ============================================================ -->
    <section class="hero hero-page">
        <div class="site-container">
            <?php roden_breadcrumb_html(); ?>
            <h1 class="hero-title"><?php esc_html_e( 'Contact Roden Law', 'roden-law' ); ?></h1>
            <p class="hero-subtitle">
                <?php esc_html_e( 'Injured? Get your free case review today. No fees unless we win.', 'roden-law' ); ?>
            </p>
        </div>
    </section>

    <!-- ============================================================
         CONTACT FORM + PHONE CTA
         ============================================================ -->
    <section class="section">
        <div class="site-container">
            <div class="contact-page-grid">

                <!-- Contact Form -->
                <div class="contact-page-form">
                    <?php roden_contact_form_sidebar(); ?>
                </div>

                <!-- Phone CTA + Info -->
                <div class="contact-page-info">
                    <div class="contact-phone-box">
                        <span class="contact-phone-label"><?php esc_html_e( 'Call Us 24/7', 'roden-law' ); ?></span>
                        <a href="tel:<?php echo esc_attr( $firm['phone_raw'] ); ?>" class="contact-phone-number">
                            <?php echo esc_html( $firm['vanity_phone'] ); ?>
                        </a>
                        <span class="contact-phone-sub"><?php esc_html_e( 'Free Consultation &bull; No Fees Unless We Win', 'roden-law' ); ?></span>
                    </div>

                    <div class="contact-info-text">
                        <h2><?php esc_html_e( 'Schedule a Free Consultation', 'roden-law' ); ?></h2>
                        <p><?php esc_html_e( 'The moments following a personal injury can be overwhelming and uncertain. Our accomplished attorneys can guide you through the complex aftermath of an accident and help you obtain the justice you need to move on with your life.', 'roden-law' ); ?></p>
                        <p><?php esc_html_e( 'Our team has decades of combined experience helping injury victims get the compensation they need to cover medical care, lost wages, pain and suffering, and other damages. There is no risk in contacting us — we offer free, no-obligation consultations.', 'roden-law' ); ?></p>
                    </div>

                    <!-- Trust Stats -->
                    <div class="contact-trust-stats">
                        <div class="contact-stat">
                            <span class="contact-stat-num"><?php echo esc_html( $stats['recovered'] ); ?></span>
                            <span class="contact-stat-label"><?php esc_html_e( 'Recovered', 'roden-law' ); ?></span>
                        </div>
                        <div class="contact-stat">
                            <span class="contact-stat-num"><?php echo esc_html( $stats['rating'] ); ?>&#9733;</span>
                            <span class="contact-stat-label"><?php esc_html_e( 'Rating', 'roden-law' ); ?></span>
                        </div>
                        <div class="contact-stat">
                            <span class="contact-stat-num"><?php echo esc_html( $stats['cases'] ); ?></span>
                            <span class="contact-stat-label"><?php esc_html_e( 'Cases Handled', 'roden-law' ); ?></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================
         OFFICE LOCATIONS
         ============================================================ -->
    <section class="section section-alt" id="offices">
        <div class="site-container">
            <div class="section-header">
                <h2><?php esc_html_e( 'Our Office Locations', 'roden-law' ); ?></h2>
                <p><?php esc_html_e( '5 offices across Georgia and South Carolina', 'roden-law' ); ?></p>
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
