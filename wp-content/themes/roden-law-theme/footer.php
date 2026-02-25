<?php
/**
 * Site Footer
 *
 * 4-column layout: firm info + social links, practice area links, 5-office NAP
 * grid, and a mini contact form. Copyright bar at bottom.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$firm  = roden_firm_data();
$year  = gmdate( 'Y' );

// Practice areas for footer links
$footer_practice_areas = array(
    'Car Accident'         => 'car-accident-lawyers',
    'Truck Accident'       => 'truck-accident-lawyers',
    'Slip & Fall'          => 'slip-and-fall-lawyers',
    'Motorcycle Accident'  => 'motorcycle-accident-lawyers',
    'Medical Malpractice'  => 'medical-malpractice-lawyers',
    'Wrongful Death'       => 'wrongful-death-lawyers',
    'Workers\' Comp'       => 'workers-compensation-lawyers',
    'Dog Bite'             => 'dog-bite-lawyers',
    'Brain Injury'         => 'brain-injury-lawyers',
);
?>
    </div><!-- .site-content -->

    <!-- Site Footer -->
    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="site-container">

            <!-- Footer 4-Column Grid -->
            <div class="footer-grid">

                <!-- Column 1: Firm Info -->
                <div class="footer-col footer-about">
                    <h4 class="footer-heading"><?php echo esc_html( $firm['name'] ); ?></h4>
                    <p class="footer-description">
                        <?php echo esc_html( $firm['trust_stats']['recovered'] ); ?>
                        <?php esc_html_e( 'recovered for injury victims across Georgia and South Carolina. No fees unless we win.', 'roden-law' ); ?>
                    </p>
                    <div class="footer-social">
                        <?php if ( ! empty( $firm['social']['facebook'] ) ) : ?>
                            <a href="<?php echo esc_url( $firm['social']['facebook'] ); ?>"
                               aria-label="<?php esc_attr_e( 'Facebook', 'roden-law' ); ?>"
                               target="_blank" rel="noopener noreferrer">
                                <span aria-hidden="true">f</span>
                            </a>
                        <?php endif; ?>
                        <?php if ( ! empty( $firm['social']['linkedin'] ) ) : ?>
                            <a href="<?php echo esc_url( $firm['social']['linkedin'] ); ?>"
                               aria-label="<?php esc_attr_e( 'LinkedIn', 'roden-law' ); ?>"
                               target="_blank" rel="noopener noreferrer">
                                <span aria-hidden="true">in</span>
                            </a>
                        <?php endif; ?>
                        <?php if ( ! empty( $firm['social']['twitter'] ) ) : ?>
                            <a href="<?php echo esc_url( $firm['social']['twitter'] ); ?>"
                               aria-label="<?php esc_attr_e( 'X / Twitter', 'roden-law' ); ?>"
                               target="_blank" rel="noopener noreferrer">
                                <span aria-hidden="true">x</span>
                            </a>
                        <?php endif; ?>
                        <?php if ( ! empty( $firm['social']['youtube'] ) ) : ?>
                            <a href="<?php echo esc_url( $firm['social']['youtube'] ); ?>"
                               aria-label="<?php esc_attr_e( 'YouTube', 'roden-law' ); ?>"
                               target="_blank" rel="noopener noreferrer">
                                <span aria-hidden="true">&#9654;</span>
                            </a>
                        <?php endif; ?>
                        <?php if ( ! empty( $firm['social']['instagram'] ) ) : ?>
                            <a href="<?php echo esc_url( $firm['social']['instagram'] ); ?>"
                               aria-label="<?php esc_attr_e( 'Instagram', 'roden-law' ); ?>"
                               target="_blank" rel="noopener noreferrer">
                                <span aria-hidden="true">ig</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Column 2: Practice Areas -->
                <div class="footer-col footer-practice-areas">
                    <h4 class="footer-heading footer-heading-accent">
                        <?php esc_html_e( 'Practice Areas', 'roden-law' ); ?>
                    </h4>
                    <ul class="footer-links">
                        <?php foreach ( $footer_practice_areas as $label => $slug ) : ?>
                            <li>
                                <a href="<?php echo esc_url( home_url( '/practice-areas/' . $slug . '/' ) ); ?>">
                                    <?php echo esc_html( $label ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Column 3: Our Offices -->
                <div class="footer-col footer-offices-col">
                    <h4 class="footer-heading footer-heading-accent">
                        <?php esc_html_e( 'Our Offices', 'roden-law' ); ?>
                    </h4>
                    <?php foreach ( $firm['offices'] as $key => $office ) : ?>
                        <div class="footer-office">
                            <h5><?php echo esc_html( $office['city'] . ', ' . $office['state'] ); ?></h5>
                            <address>
                                <?php echo esc_html( $office['street'] ); ?><br>
                                <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>">
                                    <?php echo esc_html( $office['phone'] ); ?>
                                </a>
                            </address>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Column 4: Mini Contact Form / Free Review CTA -->
                <div class="footer-col footer-form-col">
                    <h4 class="footer-heading footer-heading-accent">
                        <?php esc_html_e( 'Free Case Review', 'roden-law' ); ?>
                    </h4>
                    <div class="footer-mini-form">
                        <?php
                        // If a form plugin shortcode exists, use it.
                        // Otherwise render a basic fallback form.
                        if ( shortcode_exists( 'gravityform' ) ) {
                            // Gravity Forms — update ID to match your form
                            echo do_shortcode( '[gravityform id="1" title="false" description="false" ajax="true"]' );
                        } elseif ( shortcode_exists( 'wpforms' ) ) {
                            // WPForms — update ID to match your form
                            echo do_shortcode( '[wpforms id="1" title="false" description="false"]' );
                        } else {
                            // Fallback static form (no form plugin active)
                            ?>
                            <form class="footer-contact-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
                                <div class="form-group">
                                    <input type="text" name="footer_name" placeholder="<?php esc_attr_e( 'Name', 'roden-law' ); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="tel" name="footer_phone" placeholder="<?php esc_attr_e( 'Phone', 'roden-law' ); ?>" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" style="width:100%;">
                                        <?php esc_html_e( 'Get Free Review', 'roden-law' ); ?>
                                    </button>
                                </div>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>

            </div><!-- .footer-grid -->

            <!-- Copyright Bar -->
            <div class="footer-bottom">
                <span>
                    &copy; <?php echo esc_html( $year ); ?> <?php echo esc_html( $firm['legal_entity'] ); ?>.
                    <?php esc_html_e( 'All Rights Reserved.', 'roden-law' ); ?>
                </span>
                <span>
                    <?php esc_html_e( 'Licensed in Georgia & South Carolina', 'roden-law' ); ?>
                    <?php if ( has_nav_menu( 'footer' ) ) : ?>
                        <span class="footer-divider" aria-hidden="true">|</span>
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'footer',
                            'container'      => false,
                            'menu_class'     => 'footer-legal-menu',
                            'depth'          => 1,
                        ) );
                        ?>
                    <?php endif; ?>
                </span>
            </div>

        </div><!-- .site-container -->
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
