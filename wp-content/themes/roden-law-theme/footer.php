<?php
/**
 * Theme Footer
 *
 * @package RodenLaw
 */
$firm = roden_firm_data();
?>
</main>

<footer class="site-footer">
    <div class="container footer-grid">
        <!-- Column 1: Brand + Description -->
        <div class="footer-col footer-brand-col">
            <div class="footer-brand-name">Roden Law</div>
            <p class="footer-desc"><?php echo esc_html( $firm['recovered'] ); ?> recovered for injury victims across Georgia and South Carolina. No fees unless we win.</p>
            <div class="footer-social">
                <?php foreach ( $firm['same_as'] as $url ) :
                    $icon = '🔗';
                    if ( str_contains($url, 'facebook') ) $icon = 'f';
                    elseif ( str_contains($url, 'linkedin') ) $icon = 'in';
                    elseif ( str_contains($url, 'twitter') || str_contains($url, 'x.com') ) $icon = 'x';
                    elseif ( str_contains($url, 'youtube') ) $icon = '▶';
                    ?>
                    <a href="<?php echo esc_url( $url ); ?>" class="social-icon" target="_blank" rel="noopener noreferrer" aria-label="Social Media"><?php echo esc_html($icon); ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Column 2: Practice Areas -->
        <div class="footer-col">
            <h4 class="footer-heading">Practice Areas</h4>
            <?php
            $pas = get_posts(['post_type'=>'practice_area','posts_per_page'=>8,'orderby'=>'menu_order','order'=>'ASC']);
            if ( $pas ) :
                echo '<ul class="footer-links">';
                foreach ( $pas as $pa ) {
                    echo '<li><a href="' . esc_url(get_permalink($pa)) . '">→ ' . esc_html($pa->post_title) . '</a></li>';
                }
                echo '</ul>';
            else :
                echo '<ul class="footer-links">';
                foreach (['Car Accident','Truck Accident','Slip & Fall','Medical Malpractice','Wrongful Death'] as $p) {
                    echo '<li><a href="#">→ ' . esc_html($p) . '</a></li>';
                }
                echo '</ul>';
            endif;
            ?>
        </div>

        <!-- Column 3: Offices -->
        <div class="footer-col">
            <h4 class="footer-heading">Our Offices</h4>
            <div class="footer-offices">
                <?php foreach ( $firm['offices'] as $key => $office ) : ?>
                    <div class="footer-office">
                        <strong><?php echo esc_html( $office['city'] . ', ' . $office['state'] ); ?></strong>
                        <a href="tel:<?php echo esc_attr( $office['phone_e164'] ); ?>"><?php echo esc_html( $office['phone'] ); ?></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Column 4: Free Review CTA -->
        <div class="footer-col">
            <h4 class="footer-heading">Free Review</h4>
            <div class="footer-mini-form">
                <?php if ( shortcode_exists('gravityform') ) : ?>
                    <?php echo do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]'); ?>
                <?php else : ?>
                    <form class="roden-footer-form" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                        <input type="hidden" name="action" value="roden_contact_form" />
                        <input type="text" name="full_name" placeholder="Name" />
                        <input type="tel" name="phone" placeholder="Phone" />
                        <button type="submit" class="btn btn-primary btn-block">Get Free Review</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html( $firm['legal_name'] ); ?>. All Rights Reserved | Licensed in Georgia &amp; South Carolina</p>
            <p class="footer-disclaimer">The information on this website is for general information purposes only. Nothing on this site should be taken as legal advice for any individual case or situation. This information is not intended to create, and receipt or viewing does not constitute, an attorney-client relationship.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
