<?php
/**
 * Template: City Office Page (Location)
 *
 * Displayed for location posts with a _roden_office_key.
 * Hero with NAP + map, stat bar, practice areas, about section,
 * why choose, state law, local court, attorneys, service area,
 * directions, case results, FAQ, other offices, footer CTA, sidebar.
 *
 * @package RodenLaw
 * @version 2.0.0
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
     1. HERO
     ================================================================ -->
<section class="hero hero-location">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">

            <!-- LEFT: NAP + Info -->
            <div class="hero-content">
                <span class="state-badge state-<?php echo esc_attr( strtolower( $office['state'] ) ); ?>">
                    <?php echo esc_html( $office['state_full'] ); ?>
                </span>
                <h1 class="hero-title">
                    Personal Injury Lawyer<br>in <?php echo esc_html( $office['city'] . ', ' . $office['state'] ); ?>
                </h1>
                <p class="hero-subtitle">
                    Roden Law's <?php echo esc_html( $office['city'] ); ?> personal injury attorneys serve <?php echo esc_html( $service_area ); ?>
                </p>

                <!-- NAP Block -->
                <div class="nap-block" itemscope itemtype="https://schema.org/LegalService">
                    <meta itemprop="name" content="<?php echo esc_attr( $office['name'] ); ?>">
                    <h3 class="nap-name"><?php echo esc_html( $office['name'] ); ?></h3>
                    <div class="nap-details">
                        <div class="nap-col" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                            <span class="nap-label">Address</span>
                            <span itemprop="streetAddress"><?php echo esc_html( $office['street'] ); ?></span>
                            <span>
                                <span itemprop="addressLocality"><?php echo esc_html( $office['city'] ); ?></span>,
                                <span itemprop="addressRegion"><?php echo esc_html( $office['state'] ); ?></span>
                                <span itemprop="postalCode"><?php echo esc_html( $office['zip'] ); ?></span>
                            </span>
                        </div>
                        <div class="nap-col">
                            <span class="nap-label">Phone</span>
                            <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="nap-phone" itemprop="telephone">
                                <?php echo esc_html( $office['phone'] ); ?>
                            </a>
                            <span class="nap-hours">Available 24/7</span>
                        </div>
                    </div>
                    <div class="nap-actions" itemprop="geo" itemscope itemtype="https://schema.org/GeoCoordinates">
                        <meta itemprop="latitude" content="<?php echo esc_attr( $office['latitude'] ); ?>">
                        <meta itemprop="longitude" content="<?php echo esc_attr( $office['longitude'] ); ?>">
                        <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary">Call Now</a>
                        <a href="<?php echo esc_url( $office['map_url'] ); ?>" class="btn btn-outline-white" target="_blank" rel="noopener noreferrer">Get Directions</a>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Map + Form -->
            <div class="hero-map-form">
                <div class="map-embed">
                    <iframe
                        title="Map — <?php echo esc_attr( $office['name'] ); ?>"
                        src="<?php echo esc_url( $map_embed ); ?>"
                        width="100%" height="280"
                        style="border:0; display:block;"
                        allowfullscreen loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <?php roden_contact_form_sidebar( $office['phone'] ); ?>
            </div>

        </div>
    </div>
</section>

<!-- ================================================================
     2. STAT BAR (NEW)
     ================================================================ -->
<section class="roden-section--stat-bar">
    <div class="container">
        <?php roden_stats_bar(); ?>
    </div>
</section>

<!-- ================================================================
     3. PRACTICE AREAS AT THIS LOCATION
     ================================================================ -->
<section class="section section-light">
    <div class="container">
        <h2 class="section-title">Cases We Handle in <?php echo esc_html( $office['city'] ); ?></h2>
        <?php roden_practice_areas_grid( 4 ); ?>
    </div>
</section>

<!-- ================================================================
     4. MAIN CONTENT + SIDEBAR
     ================================================================ -->
<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <!-- MAIN COLUMN -->
        <article class="main-content">

            <!-- 4a. the_content() — About Section -->
            <div class="content-section">
                <h2>About Our <?php echo esc_html( $office['city'] ); ?> Office</h2>
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

            <!-- 4b. Why Choose Roden Law in [City] (NEW) -->
            <div class="content-section">
                <h2>Why Choose Roden Law in <?php echo esc_html( $office['city'] ); ?>?</h2>
                <div class="roden-why-choose__grid">
                    <div class="roden-why-choose__item">
                        <h4><?php echo esc_html( $firm['trust_stats']['recovered'] ); ?> Recovered</h4>
                        <p>Our firm has recovered over <?php echo esc_html( $firm['trust_stats']['recovered'] ); ?> for injured clients across Georgia and South Carolina.</p>
                    </div>
                    <div class="roden-why-choose__item">
                        <h4>Local <?php echo esc_html( $office['state_full'] ); ?> Attorneys</h4>
                        <p>Our <?php echo esc_html( $office['city'] ); ?> team practices exclusively in <?php echo esc_html( $office['state_full'] ); ?> courts, including the <?php echo esc_html( $office['court'] ); ?>.</p>
                    </div>
                    <div class="roden-why-choose__item">
                        <h4>No Fee Unless We Win</h4>
                        <p>We work on contingency — you pay nothing upfront and owe no fees unless we recover compensation for you.</p>
                    </div>
                    <div class="roden-why-choose__item">
                        <h4><?php echo esc_html( $firm['trust_stats']['rating'] ); ?>-Star Client Rating</h4>
                        <p>With <?php echo esc_html( $firm['trust_stats']['reviews'] ); ?> client reviews and a <?php echo esc_html( $firm['trust_stats']['rating'] ); ?>-star average, our results and service speak for themselves.</p>
                    </div>
                </div>
            </div>

            <!-- 4c. State-Specific Law Box -->
            <?php if ( $jurisdiction ) : ?>
            <div class="content-section">
                <div class="state-law-box">
                    <h3><?php echo esc_html( $jurisdiction['state_full'] ); ?> Personal Injury Law</h3>
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
            </div>
            <?php endif; ?>

            <!-- 4d. Local Court Reference (NEW) -->
            <div class="content-section">
                <h2>Local Court Information</h2>
                <div class="roden-local-court__card">
                    <h3><?php echo esc_html( $office['court'] ); ?></h3>
                    <?php if ( ! empty( $office['court_address'] ) ) : ?>
                    <div class="court-detail">
                        <span class="court-label">Address:</span>
                        <span><?php echo esc_html( $office['court_address'] ); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ( $jurisdiction ) : ?>
                    <div class="court-detail">
                        <span class="court-label">Jurisdiction:</span>
                        <span><?php echo esc_html( $jurisdiction['state_full'] ); ?> — <?php echo esc_html( $office['state'] ); ?> State Courts</span>
                    </div>
                    <div class="court-detail">
                        <span class="court-label">Filing Deadline:</span>
                        <span><?php echo esc_html( $jurisdiction['statute_years'] ); ?> years from the date of injury (<?php echo esc_html( $jurisdiction['statute_cite'] ); ?>)</span>
                    </div>
                    <?php endif; ?>
                    <p style="margin-top:var(--space-md); font-size:0.9rem; color:var(--color-gray);">
                        Our <?php echo esc_html( $office['city'] ); ?> attorneys regularly appear before the <?php echo esc_html( $office['court'] ); ?> and are familiar with local procedures, judges, and filing requirements.
                    </p>
                </div>
            </div>

            <?php roden_inline_cta_banner(); ?>

            <!-- 4e. Attorneys -->
            <div class="content-section">
                <h2>Your <?php echo esc_html( $office['city'] ); ?> Attorneys</h2>
                <?php roden_attorneys_grid( array( 'office_key' => $office_key, 'columns' => 3 ) ); ?>
            </div>

            <!-- 4f. Service Area / Communities (NEW) -->
            <?php if ( ! empty( $office['nearby_communities'] ) ) : ?>
            <div class="content-section">
                <h2>Communities We Serve from <?php echo esc_html( $office['city'] ); ?></h2>
                <p>In addition to <?php echo esc_html( $office['city'] ); ?>, our attorneys represent injury victims throughout these nearby communities:</p>
                <div class="roden-service-area__grid">
                    <?php foreach ( $office['nearby_communities'] as $community ) : ?>
                        <span class="roden-service-area__tag"><?php echo esc_html( $community ); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- 4g. How to Find Our Office / Directions (NEW) -->
            <?php if ( ! empty( $office['directions'] ) ) : ?>
            <div class="content-section">
                <h2>How to Find Our <?php echo esc_html( $office['city'] ); ?> Office</h2>
                <div class="roden-directions__card">
                    <div class="directions-address">
                        <h4><?php echo esc_html( $office['name'] ); ?></h4>
                        <address>
                            <?php echo esc_html( $office['street'] ); ?><br>
                            <?php echo esc_html( $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] ); ?>
                        </address>
                        <a href="<?php echo esc_url( $office['map_url'] ); ?>" class="btn btn-primary" target="_blank" rel="noopener noreferrer">
                            Get Directions on Google Maps
                        </a>
                    </div>
                    <div class="directions-text">
                        <p><?php echo esc_html( $office['directions'] ); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Intersection Links: PA x Location pages for this office -->
            <?php
            $intersection_pages = get_posts( array(
                'post_type'      => 'practice_area',
                'posts_per_page' => 50,
                'orderby'        => 'title',
                'order'          => 'ASC',
                'meta_query'     => array(
                    array( 'key' => '_roden_pa_office_key', 'value' => $office_key, 'compare' => '=' ),
                ),
            ) );
            if ( $intersection_pages ) : ?>
            <div class="content-section">
                <h2><?php echo esc_html( $office['city'] ); ?> Practice Area Pages</h2>
                <div class="intersection-links-grid">
                    <?php foreach ( $intersection_pages as $ip ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $ip ) ); ?>" class="intersection-link-card">
                            <?php echo esc_html( $ip->post_title ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- 4h. Case Results -->
            <div class="content-section">
                <h2>Recent Results</h2>
                <?php roden_case_results_grid( array( 'count' => 3, 'columns' => 3 ) ); ?>
            </div>

            <!-- 4i. FAQ Accordion (NEW — reads _roden_faqs) -->
            <?php roden_faq_section( $post_id ); ?>

            <!-- 4j. Other Office Locations (NEW) -->
            <div class="content-section">
                <h2>Our Other Office Locations</h2>
                <p>Roden Law serves injury victims across Georgia and South Carolina from <?php echo count( $firm['offices'] ); ?> offices. Visit any of our locations for a free consultation.</p>
                <div class="roden-other-offices__grid">
                    <?php foreach ( $firm['offices'] as $k => $o ) :
                        if ( $k === $office_key ) continue;
                        $slug       = strtolower( str_replace( ' ', '-', $o['city'] ) );
                        $state_slug = $o['state'] === 'GA' ? 'georgia' : 'south-carolina';
                        $office_url = home_url( '/locations/' . $state_slug . '/' . $slug . '/' );
                    ?>
                    <a href="<?php echo esc_url( $office_url ); ?>" class="roden-other-offices__card">
                        <span class="office-badge badge-<?php echo esc_attr( strtolower( $o['state'] ) ); ?>">
                            <?php echo esc_html( $o['state'] ); ?>
                        </span>
                        <h4><?php echo esc_html( $o['city'] . ', ' . $o['state'] ); ?></h4>
                        <address style="font-style:normal; font-size:0.85rem; color:var(--color-gray);">
                            <?php echo esc_html( $o['street'] ); ?>
                        </address>
                        <span class="office-phone"><?php echo esc_html( $o['phone'] ); ?></span>
                        <span class="office-link">View Office &rarr;</span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- 4k. Bottom CTA -->
            <div class="bottom-cta-box">
                <h2>Contact Our <?php echo esc_html( $office['city'] ); ?> Office Today</h2>
                <p>
                    If you were injured in <?php echo esc_html( $office['city'] ); ?> and believe another party is at fault,
                    contact us for a free, no-obligation review. Call
                    <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>"><?php echo esc_html( $office['phone'] ); ?></a>
                    — no upfront cost.
                </p>
                <div class="cta-actions">
                    <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary">
                        Call <?php echo esc_html( $office['phone'] ); ?>
                    </a>
                    <a href="#contact" class="btn btn-outline">Free Case Evaluation</a>
                </div>
            </div>

        </article>

        <!-- SIDEBAR -->
        <aside class="sidebar sidebar-location">
            <div class="sidebar-sticky">

                <!-- Contact Form -->
                <?php roden_contact_form_sidebar( $office['phone'] ); ?>

                <!-- NAP Card -->
                <div class="sidebar-widget sidebar-nap-card">
                    <h3 class="nap-card-name"><?php echo esc_html( $office['name'] ); ?></h3>
                    <address>
                        <?php echo esc_html( $office['street'] ); ?><br>
                        <?php echo esc_html( $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] ); ?>
                    </address>
                    <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="nap-card-phone">
                        <?php echo esc_html( $office['phone'] ); ?>
                    </a>
                    <a href="<?php echo esc_url( $office['map_url'] ); ?>" class="btn btn-secondary btn-block" target="_blank" rel="noopener noreferrer">
                        View on Google Maps
                    </a>
                </div>

                <!-- Filing Deadline (single state) -->
                <?php if ( $jurisdiction ) : ?>
                <div class="sidebar-widget sidebar-deadlines">
                    <h3 class="widget-title"><?php echo esc_html( $jurisdiction['state_full'] ); ?> Filing Deadline</h3>
                    <div class="deadline-badges">
                        <div class="deadline-badge <?php echo $state_key === 'GA' ? 'deadline-ga' : 'deadline-sc'; ?>" style="flex:1;">
                            <span class="deadline-years"><?php echo esc_html( $jurisdiction['statute_years'] ); ?> yr</span>
                            <span class="deadline-state"><?php echo esc_html( $jurisdiction['state_full'] ); ?></span>
                        </div>
                    </div>
                    <p class="deadline-warning">Missing the deadline forfeits your right to recover.</p>
                </div>
                <?php endif; ?>

                <!-- Other Offices -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Our Other Offices</h3>
                    <ul class="sidebar-links">
                        <?php foreach ( $firm['offices'] as $k => $o ) :
                            if ( $k === $office_key ) continue;
                            $slug = strtolower( str_replace( ' ', '-', $o['city'] ) );
                            $ss   = $o['state'] === 'GA' ? 'georgia' : 'south-carolina';
                        ?>
                            <li><a href="<?php echo esc_url( home_url( '/locations/' . $ss . '/' . $slug . '/' ) ); ?>">&rarr; <?php echo esc_html( $o['city'] . ', ' . $o['state'] ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Why Roden Law -->
                <div class="sidebar-widget sidebar-why-us">
                    <h3 class="widget-title">Why Roden Law?</h3>
                    <ul class="why-us-list">
                        <li><?php echo esc_html( $firm['trust_stats']['recovered'] ); ?> Recovered for Clients</li>
                        <li><?php echo esc_html( $firm['trust_stats']['rating'] ); ?> Average Client Rating</li>
                        <li><?php echo esc_html( $firm['trust_stats']['cases'] ); ?> Cases Successfully Handled</li>
                        <li>No Fee Unless We Win</li>
                        <li>Free 24/7 Consultations</li>
                        <li>Licensed in GA &amp; SC</li>
                    </ul>
                </div>

            </div>
        </aside>

    </div>
</div>
