<?php
/**
 * Site Footer
 *
 * 4-column layout: firm info + social links, practice area links, 6-office NAP
 * grid, and a mini contact form. Copyright bar at bottom.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$firm  = roden_firm_data();
$year  = gmdate( 'Y' );

// Location and neighborhood pages show local office phones; all others show vanity number.
$is_local_page = is_singular( 'location' );

// Practice areas for footer links (matches homepage featured grid)
$footer_practice_areas = array(
    'Car Accidents'        => 'car-accident-lawyers',
    'Truck Accidents'       => 'truck-accident-lawyers',
    'Motorcycle Accidents'  => 'motorcycle-accident-lawyers',
    'Pedestrian Accidents'  => 'pedestrian-accident-lawyers',
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
                        <li>
                            <a href="<?php echo esc_url( home_url( '/practice-areas/' ) ); ?>">
                                <?php esc_html_e( 'Other Personal Injuries', 'roden-law' ); ?>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 3: Our Offices -->
                <div class="footer-col footer-offices-col">
                    <h4 class="footer-heading footer-heading-accent">
                        <?php esc_html_e( 'Our Offices', 'roden-law' ); ?>
                    </h4>
                    <?php foreach ( $firm['offices'] as $key => $office ) : ?>
                        <div class="footer-office">
                            <h5><?php echo esc_html( $office['market_name'] . ', ' . $office['state'] ); ?></h5>
                            <address>
                                <?php echo esc_html( $office['street'] ); ?><br>
                                <a href="tel:<?php echo esc_attr( $is_local_page ? $office['phone_raw'] : $firm['phone_raw'] ); ?>">
                                    <?php echo esc_html( $is_local_page ? $office['phone'] : $firm['vanity_phone'] ); ?>
                                </a>
                            </address>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Column 4: Free Case Review CTA -->
                <div class="footer-col footer-form-col">
                    <h4 class="footer-heading footer-heading-accent">
                        <?php esc_html_e( 'Free Case Review', 'roden-law' ); ?>
                    </h4>
                    <p class="footer-cta-text">Injured? Find out what your case is worth. No fees unless we win.</p>
                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="footer-cta-btn">Get Your Free Case Review</a>
                </div>

            </div><!-- .footer-grid -->

            <!-- Legal Disclaimers -->
            <div class="footer-disclaimers">
                <p><strong>Disclaimer:</strong> Attorney Eric Roden is responsible for the content of this website, and his primary office address is 333 Commercial Drive, Savannah, GA 31406. South Carolina cases are principally handled out of the Charleston and North Charleston, South Carolina offices. South Carolina cases are primarily handled by attorney Graeham Gillin, and the primary office addresses are 127 King Street, Charleston, SC 29401 and 2703 Spruill Ave, North Charleston, SC 29405. Georgia cases are principally handled out of the Savannah and Darien, Georgia offices.</p>
                <p><strong>Case Results:</strong> Case "value," "results," and/or "maximum compensation" is determined from the total settlement amount. The settlement amounts shown are gross numbers before attorney's fees and cost deductions. The % fees will be computed before deducting expenses and costs from the gross settlement. Each case is unique, and the examples shown are just that, examples of past results. Past results do not guarantee or suggest recovery in your specific case. Each case is different.</p>
                <p><strong>No Upfront Fees:</strong> Fees and costs apply only upon successful recovery. No fees or costs with no recovery.</p>
                <p><strong>Testimonials:</strong> Testimonials reflect individual experiences and do not guarantee similar outcomes. No clients were paid for endorsements unless otherwise disclosed.</p>
                <p><strong>Content:</strong> The term 'expert witness' refers to individuals who testify based on their professional expertise in court. Roden Law attorneys do not claim the title of legal 'expert' as defined by South Carolina Rule 7.4(b), unless certified by the appropriate authority.</p>
                <p>The information contained in this Website is provided for informational purposes only and should not be construed as legal advice on any subject matter. Furthermore, The Firm does not wish to represent anyone desiring representation based upon viewing this Website in a state where this Website fails to comply with all laws and ethical rules of that state. Roden Law is licensed to practice in the states of Georgia and South Carolina. Reproduction, distribution, republication, and/or retransmission of material contained within The Roden Law Website is prohibited unless the prior written permission of Roden Law has been obtained.</p>
            </div>

            <!-- Copyright Bar -->
            <div class="footer-bottom">
                <span>
                    &copy; <?php echo esc_html( $year ); ?> <?php echo esc_html( $firm['legal_entity'] ); ?>.
                    <?php esc_html_e( 'All Rights Reserved', 'roden-law' ); ?>
                    | <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" class="footer-privacy-link"><?php esc_html_e( 'Privacy Policy', 'roden-law' ); ?></a>
                </span>
                <span>
                    <?php esc_html_e( 'Licensed in Georgia & South Carolina', 'roden-law' ); ?>
                </span>
            </div>

        </div><!-- .site-container -->
    </footer>

</div><!-- #page -->

<!-- Back to Top Button -->
<button class="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'roden-law' ); ?>" type="button">&#8593;</button>

<!-- Sticky Mobile CTA Bar (visible on mobile after scrolling past hero) -->
<div class="pa-mobile-cta" aria-label="<?php esc_attr_e( 'Contact Roden Law', 'roden-law' ); ?>">
    <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="pa-mobile-cta__phone">&#128222; <?php echo esc_html( $firm['phone'] ); ?></a>
    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="pa-mobile-cta__review"><?php esc_html_e( 'Free Review', 'roden-law' ); ?></a>
</div>

<!-- JuvoLeads Live Chat (desktop only) -->
<script>
if (window.innerWidth > 768) {
    var s = document.createElement('script');
    s.src = 'https://cdn.juvoleads.com/tag/9262634398.js';
    s.async = true;
    document.body.appendChild(s);
}
</script>

<?php wp_footer(); ?>
</body>
</html>
