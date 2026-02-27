<?php
/**
 * Template: City Office Page (Location)
 *
 * Full-width section-based layout matching homepage pattern.
 * Schema: LocalBusiness, LegalService, PostalAddress, GeoCoordinates, BreadcrumbList
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Ensure template helpers are available (guard against include-chain failures)
if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}

/* == Gather data ========================================================= */

$firm       = roden_firm_data();
$post_id    = get_the_ID();
$office_key = get_post_meta( $post_id, '_roden_office_key', true );

if ( ! $office_key || ! isset( $firm['offices'][ $office_key ] ) ) {
    echo '<div class="container"><p>Office not configured. Please set the Office Key in the admin.</p></div>';
    return;
}

$office     = $firm['offices'][ $office_key ];
$state_key  = $office['state']; // 'GA' or 'SC'
$jurisdiction = isset( $firm['jurisdiction'][ $state_key ] ) ? $firm['jurisdiction'][ $state_key ] : null;
$stats      = $firm['trust_stats'];

// Meta overrides
$service_area_override = get_post_meta( $post_id, '_roden_service_area', true );
$service_area = $service_area_override ? $service_area_override : $office['service_area'];

$map_embed = get_post_meta( $post_id, '_roden_map_embed', true );
if ( ! $map_embed ) {
    $map_query = urlencode( $office['street'] . ', ' . $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] );
    $map_embed = 'https://maps.google.com/maps?q=' . $map_query . '&output=embed&z=15';
}

$local_content = get_post_meta( $post_id, '_roden_local_content', true );
$faqs          = get_post_meta( $post_id, '_roden_faqs', true );
?>

<!-- ================================================================
     1. HERO — matches homepage: breadcrumb, badge, h1, stats, CTAs + form
     ================================================================ -->
<section class="hero hero-location">
    <div class="hero-bg-overlay"></div>
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">

            <!-- LEFT: Info + Stats + CTAs -->
            <div class="hero-content">
                <span class="state-badge state-<?php echo esc_attr( strtolower( $office['state'] ) ); ?>">
                    <?php echo esc_html( $office['state_full'] ); ?>
                </span>
                <h1 class="hero-title">
                    Personal Injury Lawyer<br>
                    <span class="text-accent">in <?php echo esc_html( $office['city'] . ', ' . $office['state'] ); ?></span>
                </h1>
                <p class="hero-subtitle">
                    Roden Law's <?php echo esc_html( $office['city'] ); ?> personal injury attorneys have recovered <strong><?php echo esc_html( $stats['recovered'] ); ?></strong> for injury victims across <?php echo esc_html( $service_area ); ?> No fees unless we win.
                </p>

                <!-- Trust Stats (matching homepage hero-stats) -->
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['recovered'] ); ?></span>
                        <span class="stat-label">Recovered for Clients</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['rating'] ); ?>&#9733;</span>
                        <span class="stat-label">Client Rating</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['cases'] ); ?></span>
                        <span class="stat-label">Cases Handled</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['experience'] ); ?> Yrs</span>
                        <span class="stat-label">Combined Experience</span>
                    </div>
                </div>

                <!-- Hero CTAs -->
                <div class="hero-ctas">
                    <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary btn-lg">
                        Call <?php echo esc_html( $office['phone'] ); ?>
                    </a>
                    <a href="#free-case-review" class="btn btn-outline-light btn-lg">Free Case Review</a>
                </div>
            </div>

            <!-- RIGHT: Contact Form -->
            <div class="hero-form" id="free-case-review">
                <?php roden_contact_form_sidebar( $office['phone'] ); ?>
            </div>

        </div>
    </div>
</section>

<!-- ================================================================
     2. BADGE BAR — reuse homepage trust badges
     ================================================================ -->
<div class="badge-bar">
    <div class="container">
        <div class="badge-bar-inner">
            <div class="badge-item">
                <span class="badge-icon" aria-hidden="true"></span>
                <span class="badge-label">State Bar of Georgia</span>
            </div>
            <div class="badge-item">
                <span class="badge-icon" aria-hidden="true"></span>
                <span class="badge-label">American Association for Justice</span>
            </div>
            <div class="badge-item">
                <span class="badge-icon" aria-hidden="true"></span>
                <span class="badge-label">Georgia Trial Lawyers</span>
            </div>
            <div class="badge-item">
                <span class="badge-icon" aria-hidden="true"></span>
                <span class="badge-label">American Bar Association</span>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================
     3. GOOGLE MAP — full-width embedded map + NAP info bar
     ================================================================ -->
<section class="section section-map">
    <iframe
        title="Map — <?php echo esc_attr( $office['name'] ); ?>"
        src="<?php echo esc_url( $map_embed ); ?>"
        width="100%" height="400"
        style="border:0; display:block;"
        allowfullscreen loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
    <div class="map-nap-bar">
        <div class="container map-nap-inner">
            <div class="map-nap-address">
                <strong><?php echo esc_html( $office['name'] ); ?></strong>
                <span><?php echo esc_html( $office['street'] . ', ' . $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] ); ?></span>
            </div>
            <div class="map-nap-actions">
                <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary"><?php echo esc_html( $office['phone'] ); ?></a>
                <a href="<?php echo esc_url( $office['map_url'] ); ?>" class="btn btn-outline-light" target="_blank" rel="noopener noreferrer">Get Directions</a>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================
     4. PRACTICE AREAS — full-width (matches homepage)
     ================================================================ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Cases We Handle in <?php echo esc_html( $office['city'] ); ?></h2>
            <p class="section-subtitle">Our <?php echo esc_html( $office['city'] ); ?> attorneys handle all types of personal injury cases in <?php echo esc_html( $office['state_full'] ); ?>.</p>
        </div>
        <?php roden_intersection_grid( $office_key, 3 ); ?>
    </div>
</section>

<!-- ================================================================
     5. ABOUT — full-width section with the_content()
     ================================================================ -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">About Our <?php echo esc_html( $office['city'] ); ?> Office</h2>
        </div>
        <div class="entry-content">
            <?php
            $content = get_the_content();
            if ( trim( $content ) ) {
                the_content();
            } else {
                echo '<p>Roden Law\'s ' . esc_html( $office['city'] ) . ' office serves injury victims throughout the region. Our ' . esc_html( $office['city'] ) . ' personal injury attorneys handle all types of injury claims under ' . esc_html( $office['state_full'] ) . ' law.</p>';
                echo '<p>Serving ' . esc_html( $service_area ) . '</p>';
            }
            ?>
            <?php if ( $local_content ) : ?>
                <div class="local-content">
                    <?php echo wp_kses_post( $local_content ); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ================================================================
     6. WHY CHOOSE — 4-column cards (full-width)
     ================================================================ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Why Choose Roden Law in <?php echo esc_html( $office['city'] ); ?>?</h2>
        </div>
        <div class="why-choose-grid">
            <div class="card why-choose-card">
                <h3>No Fee Unless We Win</h3>
                <p>You pay nothing upfront. Our contingency fee model means we only get paid when you recover compensation.</p>
            </div>
            <div class="card why-choose-card">
                <h3><?php echo esc_html( $stats['recovered'] ); ?> Recovered</h3>
                <p>Our track record speaks for itself — over <?php echo esc_html( $stats['recovered'] ); ?> recovered for personal injury victims.</p>
            </div>
            <div class="card why-choose-card">
                <h3>Local <?php echo esc_html( $office['state_full'] ); ?> Attorneys</h3>
                <p>Our <?php echo esc_html( $office['city'] ); ?> team practices in <?php echo esc_html( $office['state_full'] ); ?> courts, including the <?php echo esc_html( $office['court'] ); ?>.</p>
            </div>
            <div class="card why-choose-card">
                <h3><?php echo esc_html( $stats['rating'] ); ?>-Star Client Rating</h3>
                <p>Rated <?php echo esc_html( $stats['rating'] ); ?> stars from <?php echo esc_html( $stats['reviews'] ); ?> client reviews. Our clients trust us to deliver results.</p>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================
     7. STATE LAW + LOCAL COURT — full-width jurisdiction info
     ================================================================ -->
<?php if ( $jurisdiction ) : ?>
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html( $jurisdiction['state_full'] ); ?> Personal Injury Law</h2>
        </div>
        <div class="jurisdiction-cards">
            <div class="state-law-box">
                <div class="law-details-grid">
                    <div class="law-detail">
                        <span class="law-label">Statute of Limitations</span>
                        <span class="law-value">
                            <?php echo esc_html( $jurisdiction['statute_years'] ); ?> years
                            (<?php echo esc_html( $jurisdiction['statute_cite'] ); ?>)
                        </span>
                    </div>
                    <div class="law-detail">
                        <span class="law-label">Comparative Fault</span>
                        <span class="law-value">
                            <?php echo esc_html( $jurisdiction['comp_fault_rule'] ); ?>
                            <?php if ( $jurisdiction['comp_fault_cite'] ) : ?>
                                (<?php echo esc_html( $jurisdiction['comp_fault_cite'] ); ?>)
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="local-court-card">
                <h3><?php echo esc_html( $office['court'] ); ?></h3>
                <?php if ( ! empty( $office['court_address'] ) ) : ?>
                <div class="court-detail">
                    <span class="law-label">Address:</span>
                    <span class="law-value"><?php echo esc_html( $office['court_address'] ); ?></span>
                </div>
                <?php endif; ?>
                <p style="margin-top:12px; font-size:0.9rem; color:var(--gray-600);">
                    Our <?php echo esc_html( $office['city'] ); ?> attorneys regularly appear before the <?php echo esc_html( $office['court'] ); ?> and are familiar with local procedures and filing requirements.
                </p>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================================================================
     8. ATTORNEYS — full-width (matches homepage)
     ================================================================ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Your <?php echo esc_html( $office['city'] ); ?> Attorneys</h2>
        </div>
        <?php roden_attorneys_grid( array( 'office_key' => $office_key, 'columns' => 3 ) ); ?>
    </div>
</section>

<!-- ================================================================
     9. CASE RESULTS — dark section (matches homepage .bg-navy)
     ================================================================ -->
<section class="section bg-navy">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title text-white">Our Results Speak for Themselves</h2>
        </div>
        <?php roden_case_results_grid( array( 'count' => 4, 'columns' => 4 ) ); ?>
    </div>
</section>

<!-- ================================================================
     10. COMMUNITIES + SERVICE AREA
     ================================================================ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Communities We Serve from <?php echo esc_html( $office['city'] ); ?></h2>
            <p class="section-subtitle">Our <?php echo esc_html( $office['city'] ); ?> personal injury lawyers proudly serve <?php echo esc_html( $service_area ); ?></p>
        </div>
        <?php if ( ! empty( $office['nearby_communities'] ) ) : ?>
        <div class="communities-grid">
            <?php foreach ( $office['nearby_communities'] as $community ) : ?>
                <span class="community-tag"><?php echo esc_html( $community ); ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if ( ! empty( $office['directions'] ) ) : ?>
        <div class="directions-box">
            <h3>How to Find Our <?php echo esc_html( $office['city'] ); ?> Office</h3>
            <p><?php echo esc_html( $office['directions'] ); ?></p>
            <a href="<?php echo esc_url( $office['map_url'] ); ?>" class="btn btn-primary" target="_blank" rel="noopener noreferrer">
                Get Directions on Google Maps
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ================================================================
     11. FAQ — accordion (if FAQs exist)
     ================================================================ -->
<?php if ( ! empty( $faqs ) && is_array( $faqs ) ) : ?>
<section class="section">
    <div class="container">
        <?php roden_faq_section( $post_id ); ?>
    </div>
</section>
<?php endif; ?>

<!-- ================================================================
     12. OTHER OFFICES — reuse homepage locations-grid pattern
     ================================================================ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Other Offices</h2>
            <p class="section-subtitle">Roden Law serves injury victims across Georgia and South Carolina from <?php echo count( $firm['offices'] ); ?> offices.</p>
        </div>
        <div class="locations-grid">
            <?php foreach ( $firm['offices'] as $k => $o ) :
                if ( $k === $office_key ) continue;
                $slug       = strtolower( str_replace( ' ', '-', $o['city'] ) );
                $state_slug = $o['state'] === 'GA' ? 'georgia' : 'south-carolina';
                $office_url = home_url( '/locations/' . $state_slug . '/' . $slug . '/' );
            ?>
            <div class="card location-card">
                <span class="badge <?php echo 'GA' === $o['state'] ? 'badge-ga' : 'badge-sc'; ?>">
                    <?php echo esc_html( $o['state'] ); ?>
                </span>
                <h3><?php echo esc_html( $o['city'] ); ?></h3>
                <address>
                    <?php echo esc_html( $o['street'] ); ?><br>
                    <?php echo esc_html( $o['city'] . ', ' . $o['state'] . ' ' . $o['zip'] ); ?>
                </address>
                <a href="tel:<?php echo esc_attr( $o['phone_raw'] ); ?>" class="location-phone">
                    <?php echo esc_html( $o['phone'] ); ?>
                </a>
                <a href="<?php echo esc_url( $office_url ); ?>" class="location-link">View Office &rarr;</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================================================================
     13. BOTTOM CTA — navy banner (matches homepage)
     ================================================================ -->
<section class="section bg-navy cta-bottom">
    <div class="container text-center">
        <h2 class="text-white">Injured in <?php echo esc_html( $office['city'] ); ?>? Get Your Free Case Review Today.</h2>
        <p class="text-white" style="opacity:0.85; max-width:600px; margin:0 auto var(--space-xl, 32px);">
            No fees unless we win. Available 24/7 across <?php echo esc_html( $office['state_full'] ); ?>.
        </p>
        <div class="hero-ctas" style="justify-content:center;">
            <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary btn-lg">
                Call <?php echo esc_html( $office['phone'] ); ?>
            </a>
            <a href="#free-case-review" class="btn btn-outline-light btn-lg">Free Case Evaluation</a>
        </div>
    </div>
</section>
