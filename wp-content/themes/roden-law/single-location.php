<?php
/**
 * Single Location Template
 *
 * LocalBusiness + LegalService + PostalAddress + GeoCoordinates schema.
 * NAP hero, Google Maps, practice areas grid, state-specific law,
 * attorneys filtered by office, case results, sidebar with NAP card.
 *
 * @package RodenLaw
 */

get_header();
echo '<!-- SINGLE-LOCATION-GITPUSH-V2 -->';
if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}
$firm       = roden_firm_data();
$post_id    = get_the_ID();
$office_key = get_post_meta( $post_id, '_roden_office_key', true );
$office     = ( $office_key && isset( $firm['offices'][$office_key] ) ) ? $firm['offices'][$office_key] : null;

// Detect state landing page (parent location with no office key)
$is_state_page = false;
$state_offices = [];
if ( ! $office ) {
    $post_slug = get_post_field( 'post_name', $post_id );
    if ( in_array( $post_slug, ['georgia', 'south-carolina'] ) ) {
        $is_state_page = true;
        $state_abbr = $post_slug === 'georgia' ? 'GA' : 'SC';
        $state_full = $post_slug === 'georgia' ? 'Georgia' : 'South Carolina';
        foreach ( $firm['offices'] as $k => $o ) {
            if ( $o['state'] === $state_abbr ) {
                $state_offices[$k] = $o;
            }
        }
    }
}

// State Landing Page Template
if ( $is_state_page ) :
    $sol  = $state_abbr === 'GA' ? '2 years (O.C.G.A. § 9-3-33)' : '3 years (S.C. Code § 15-3-530)';
    $fault = $state_abbr === 'GA'
        ? 'Modified comparative — recovery if less than 50% at fault (O.C.G.A. § 51-12-33)'
        : 'Modified comparative — recovery if less than 51% at fault';
?>

<!-- STATE LANDING HERO -->
<section class="hero hero-location">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">
            <div class="hero-content">
                <span class="state-badge state-<?php echo esc_attr(strtolower($state_abbr)); ?>">
                    <?php echo esc_html($state_full); ?>
                </span>
                <h1 class="hero-title">
                    Personal Injury Lawyers<br>in <?php echo esc_html($state_full); ?>
                </h1>
                <p class="hero-subtitle">
                    Roden Law serves injury victims across <?php echo esc_html($state_full); ?> from <?php echo count($state_offices); ?> office<?php echo count($state_offices) > 1 ? 's' : ''; ?>. We have recovered $250M+ for our clients. Free case review — no fees unless we win.
                </p>
                <div class="hero-buttons">
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary">📞 Call <?php echo esc_html($firm['phone']); ?></a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline-light">Free Case Review</a>
                </div>
            </div>
            <div class="hero-map-form">
                <?php roden_contact_form_sidebar(); ?>
            </div>
        </div>
    </div>
</section>

<!-- OFFICES IN THIS STATE -->
<section class="section section-light">
    <div class="container">
        <h2 class="section-title">Our <?php echo esc_html($state_full); ?> Offices</h2>
        <div class="location-cards-grid cols-<?php echo count($state_offices); ?>">
            <?php foreach ( $state_offices as $k => $o ) :
                $slug = sanitize_title( $o['city'] );
                $state_slug = strtolower( str_replace(' ', '-', $o['state_full']) );
                $url = home_url( '/locations/' . $state_slug . '/' . $slug . '/' );
            ?>
            <div class="location-card" itemscope itemtype="https://schema.org/LegalService">
                <div class="location-card-header">
                    <span class="state-badge state-<?php echo esc_attr(strtolower($o['state'])); ?>"><?php echo esc_html($o['state']); ?></span>
                    <h3 itemprop="name"><?php echo esc_html($o['city']); ?></h3>
                </div>
                <address itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                    <span itemprop="streetAddress"><?php echo esc_html( $o['address'] ); ?></span><br>
                    <span itemprop="addressLocality"><?php echo esc_html( $o['city'] ); ?></span>,
                    <span itemprop="addressRegion"><?php echo esc_html( $o['state'] ); ?></span>
                    <span itemprop="postalCode"><?php echo esc_html( $o['zip'] ); ?></span>
                </address>
                <a href="tel:<?php echo esc_attr($o['phone_e164']); ?>" class="location-phone" itemprop="telephone">
                    <?php echo esc_html( $o['phone'] ); ?>
                </a>
                <p class="location-service-area"><?php echo esc_html( $o['service_area'] ); ?></p>
                <a href="<?php echo esc_url( $url ); ?>" class="location-link">View Office →</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- STATE LAW + CONTENT -->
<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">
        <article class="main-content">
            <h2><?php echo esc_html($state_full); ?> Personal Injury Law</h2>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <div class="state-law-box">
                <h3>⚖ <?php echo esc_html($state_full); ?> Filing Rules</h3>
                <div class="law-details-grid">
                    <div class="law-detail">
                        <span class="law-label">Statute of Limitations</span>
                        <span class="law-value"><?php echo esc_html( $sol ); ?></span>
                    </div>
                    <div class="law-detail">
                        <span class="law-label">Comparative Fault</span>
                        <span class="law-value"><?php echo esc_html( $fault ); ?></span>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <h2>Practice Areas We Handle in <?php echo esc_html($state_full); ?></h2>
                <?php roden_practice_areas_grid( 4 ); ?>
            </div>

            <div class="content-section">
                <h2>Recent Results</h2>
                <?php roden_case_results_grid( [ 'count' => 4, 'columns' => 4 ] ); ?>
            </div>

            <?php roden_faq_section( $post_id ); ?>
        </article>

        <aside class="sidebar sidebar-location">
            <div class="sidebar-sticky">
                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php echo esc_html($state_full); ?> Offices</h3>
                    <ul class="sidebar-links">
                        <?php foreach ( $state_offices as $k => $o ) :
                            $slug = sanitize_title( $o['city'] );
                            $ss = strtolower( str_replace(' ', '-', $o['state_full']) );
                        ?>
                            <li><a href="<?php echo esc_url( home_url('/locations/' . $ss . '/' . $slug . '/') ); ?>">→ <?php echo esc_html($o['city'] . ', ' . $o['state']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php
                // Show other state's offices
                $other_state = $state_abbr === 'GA' ? 'SC' : 'GA';
                $other_state_full = $other_state === 'GA' ? 'Georgia' : 'South Carolina';
                $other_offices = array_filter($firm['offices'], fn($o) => $o['state'] === $other_state);
                if ($other_offices) : ?>
                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php echo esc_html($other_state_full); ?> Offices</h3>
                    <ul class="sidebar-links">
                        <?php foreach ( $other_offices as $k => $o ) :
                            $slug = sanitize_title( $o['city'] );
                            $ss = strtolower( str_replace(' ', '-', $o['state_full']) );
                        ?>
                            <li><a href="<?php echo esc_url( home_url('/locations/' . $ss . '/' . $slug . '/') ); ?>">→ <?php echo esc_html($o['city'] . ', ' . $o['state']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</div>

<?php
    get_footer();
    return;
endif;
// END state landing page
// ──────────────────────────────────────────────────────────────────────────

// CITY OFFICE PAGE — routed to extracted template
get_template_part( 'templates/template-location' );
get_footer();
