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

// South Carolina statewide pillars (root-relative paths — heading gives SC context).
$footer_sc_pillars = array(
    'Car Accidents'         => '/south-carolina-car-accident-lawyers/',
    'Truck Accidents'       => '/south-carolina-truck-accident-lawyers/',
    'Motorcycle Accidents'  => '/south-carolina-motorcycle-accident-lawyer/',
    'Workers&rsquo; Compensation' => '/south-carolina-workers-compensation-lawyer/',
    'Wrongful Death'        => '/south-carolina-wrongful-death-lawyer/',
    'Personal Injury'       => '/south-carolina-personal-injury-lawyer/',
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
                               target="_blank" rel="noopener noreferrer nofollow">
                                <span aria-hidden="true">f</span>
                            </a>
                        <?php endif; ?>
                        <?php if ( ! empty( $firm['social']['linkedin'] ) ) : ?>
                            <a href="<?php echo esc_url( $firm['social']['linkedin'] ); ?>"
                               aria-label="<?php esc_attr_e( 'LinkedIn', 'roden-law' ); ?>"
                               target="_blank" rel="noopener noreferrer nofollow">
                                <span aria-hidden="true">in</span>
                            </a>
                        <?php endif; ?>
                        <?php if ( ! empty( $firm['social']['twitter'] ) ) : ?>
                            <a href="<?php echo esc_url( $firm['social']['twitter'] ); ?>"
                               aria-label="<?php esc_attr_e( 'X / Twitter', 'roden-law' ); ?>"
                               target="_blank" rel="noopener noreferrer nofollow">
                                <span aria-hidden="true">x</span>
                            </a>
                        <?php endif; ?>
                        <?php if ( ! empty( $firm['social']['youtube'] ) ) : ?>
                            <a href="<?php echo esc_url( $firm['social']['youtube'] ); ?>"
                               aria-label="<?php esc_attr_e( 'YouTube', 'roden-law' ); ?>"
                               target="_blank" rel="noopener noreferrer nofollow">
                                <span aria-hidden="true">&#9654;</span>
                            </a>
                        <?php endif; ?>
                        <?php if ( ! empty( $firm['social']['instagram'] ) ) : ?>
                            <a href="<?php echo esc_url( $firm['social']['instagram'] ); ?>"
                               aria-label="<?php esc_attr_e( 'Instagram', 'roden-law' ); ?>"
                               target="_blank" rel="noopener noreferrer nofollow">
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
                        <li>
                            <a href="<?php echo esc_url( home_url( '/resources/' ) ); ?>">
                                <?php esc_html_e( 'Resources', 'roden-law' ); ?>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 3: Our Offices — grouped by state with state-landing header links -->
                <div class="footer-col footer-offices-col">
                    <h4 class="footer-heading footer-heading-accent">
                        <?php esc_html_e( 'Our Offices', 'roden-law' ); ?>
                    </h4>
                    <?php
                    $state_buckets = array(
                        array(
                            'state_full' => __( 'Georgia', 'roden-law' ),
                            'state_abbr' => 'GA',
                            'state_slug' => 'georgia',
                        ),
                        array(
                            'state_full' => __( 'South Carolina', 'roden-law' ),
                            'state_abbr' => 'SC',
                            'state_slug' => 'south-carolina',
                        ),
                    );
                    foreach ( $state_buckets as $bucket ) :
                        $state_landing_url = home_url( '/locations/' . $bucket['state_slug'] . '/' );
                    ?>
                        <div class="footer-state-bucket">
                            <h5 class="footer-state-heading">
                                <a href="<?php echo esc_url( $state_landing_url ); ?>">
                                    <?php
                                    /* translators: %s: state name (Georgia or South Carolina) */
                                    echo esc_html( sprintf( __( '%s Offices', 'roden-law' ), $bucket['state_full'] ) );
                                    ?>
                                </a>
                            </h5>
                            <?php foreach ( $firm['offices'] as $key => $office ) :
                                if ( $office['state'] !== $bucket['state_abbr'] ) {
                                    continue;
                                }
                                $city_slug = sanitize_title( $office['market_name'] );
                                $office_url = home_url( '/locations/' . $office['state_slug'] . '/' . $city_slug . '/' );
                            ?>
                                <div class="footer-office">
                                    <h6>
                                        <a href="<?php echo esc_url( $office_url ); ?>">
                                            <?php echo esc_html( $office['market_name'] . ', ' . $office['state'] ); ?>
                                        </a>
                                    </h6>
                                    <address>
                                        <?php echo esc_html( $office['street'] ); ?><br>
                                        <a href="tel:<?php echo esc_attr( $is_local_page ? $office['phone_raw'] : $firm['phone_raw'] ); ?>">
                                            <?php echo esc_html( $is_local_page ? $office['phone'] : $firm['vanity_phone'] ); ?>
                                        </a>
                                    </address>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Column 4: South Carolina statewide pillars -->
                <div class="footer-col footer-sc-statewide">
                    <h4 class="footer-heading footer-heading-accent">
                        <?php esc_html_e( 'South Carolina', 'roden-law' ); ?>
                    </h4>
                    <ul class="footer-links">
                        <?php foreach ( $footer_sc_pillars as $label => $path ) : ?>
                            <li>
                                <a href="<?php echo esc_url( home_url( $path ) ); ?>">
                                    <?php echo wp_kses( $label, array() ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Column 5: Free Case Review CTA -->
                <div class="footer-col footer-form-col">
                    <h4 class="footer-heading footer-heading-accent">
                        <?php esc_html_e( 'Free Case Review', 'roden-law' ); ?>
                    </h4>
                    <p class="footer-cta-text"><?php esc_html_e( 'Injured? Find out what your case is worth. No fees unless we win.', 'roden-law' ); ?></p>
                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="footer-cta-btn"><?php esc_html_e( 'Get Your Free Case Review', 'roden-law' ); ?></a>
                </div>

            </div><!-- .footer-grid -->

            <!-- Legal Disclaimers -->
            <div class="footer-disclaimers">
                <p><strong><?php esc_html_e( 'Disclaimer:', 'roden-law' ); ?></strong> <?php esc_html_e( 'Attorney Eric Roden is responsible for the content of this website, and his primary office address is 333 Commercial Drive, Savannah, GA 31406. South Carolina cases are principally handled out of the Charleston and North Charleston, South Carolina offices. South Carolina cases are primarily handled by attorney Graeham Gillin, and the primary office addresses are 127 King Street, Charleston, SC 29401 and 2703 Spruill Ave, North Charleston, SC 29405. Georgia cases are principally handled out of the Savannah and Darien, Georgia offices.', 'roden-law' ); ?></p>
                <p><strong><?php esc_html_e( 'Case Results:', 'roden-law' ); ?></strong> <?php esc_html_e( 'Case "value," "results," and/or "maximum compensation" is determined from the total settlement amount. The settlement amounts shown are gross numbers before attorney\'s fees and cost deductions. The % fees will be computed before deducting expenses and costs from the gross settlement. Each case is unique, and the examples shown are just that, examples of past results. Past results do not guarantee or suggest recovery in your specific case. Each case is different.', 'roden-law' ); ?></p>
                <p><strong><?php esc_html_e( 'No Upfront Fees:', 'roden-law' ); ?></strong> <?php esc_html_e( 'Fees and costs apply only upon successful recovery. No fees or costs with no recovery.', 'roden-law' ); ?></p>
                <p><strong><?php esc_html_e( 'Testimonials:', 'roden-law' ); ?></strong> <?php esc_html_e( 'Testimonials reflect individual experiences and do not guarantee similar outcomes. No clients were paid for endorsements unless otherwise disclosed.', 'roden-law' ); ?></p>
                <p><strong><?php esc_html_e( 'Content:', 'roden-law' ); ?></strong> <?php esc_html_e( 'The term \'expert witness\' refers to individuals who testify based on their professional expertise in court. Roden Law attorneys do not claim the title of legal \'expert\' as defined by South Carolina Rule 7.4(b), unless certified by the appropriate authority.', 'roden-law' ); ?></p>
                <p><?php esc_html_e( 'The information contained in this Website is provided for informational purposes only and should not be construed as legal advice on any subject matter. Furthermore, The Firm does not wish to represent anyone desiring representation based upon viewing this Website in a state where this Website fails to comply with all laws and ethical rules of that state. Roden Law is licensed to practice in the states of Georgia and South Carolina. Reproduction, distribution, republication, and/or retransmission of material contained within The Roden Law Website is prohibited unless the prior written permission of Roden Law has been obtained.', 'roden-law' ); ?></p>
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

<?php wp_footer(); ?>
<script type="text/javascript" src="//cdn.callrail.com/companies/481994887/9f5e5ebaf1d98d87a441/12/swap.js"></script>
</body>
</html>
