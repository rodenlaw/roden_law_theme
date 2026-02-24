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

// CITY OFFICE PAGE (original template continues below)
if ( ! $office ) {
    echo '<div class="container"><p>Office not configured. Please set the Office Key in the admin.</p></div>';
    get_footer();
    return;
}

$state_slug = $office['state'] === 'GA' ? 'georgia' : 'south-carolina';
$map_query  = urlencode( $office['address'] . ', ' . $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] );
$map_src    = 'https://maps.google.com/maps?q=' . $map_query . '&output=embed&z=15';
?>

<!-- HERO -->
<section class="hero hero-location">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">

            <!-- LEFT: NAP + Info -->
            <div class="hero-content">
                <span class="state-badge state-<?php echo esc_attr(strtolower($office['state'])); ?>">
                    <?php echo esc_html( $office['state_full'] ); ?>
                </span>
                <h1 class="hero-title">
                    Personal Injury Lawyer<br>in <?php echo esc_html( $office['city'] . ', ' . $office['state'] ); ?>
                </h1>
                <p class="hero-subtitle">
                    Roden Law's <?php echo esc_html($office['city']); ?> personal injury attorneys serve <?php echo esc_html($office['service_area']); ?>
                </p>

                <!-- NAP Block -->
                <div class="nap-block" itemscope itemtype="https://schema.org/LegalService">
                    <meta itemprop="name" content="<?php echo esc_attr($office['name']); ?>">
                    <h3 class="nap-name">📍 <?php echo esc_html( $office['name'] ); ?></h3>
                    <div class="nap-details">
                        <div class="nap-col" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                            <span class="nap-label">Address</span>
                            <span itemprop="streetAddress"><?php echo esc_html( $office['address'] ); ?></span>
                            <span>
                                <span itemprop="addressLocality"><?php echo esc_html( $office['city'] ); ?></span>,
                                <span itemprop="addressRegion"><?php echo esc_html( $office['state'] ); ?></span>
                                <span itemprop="postalCode"><?php echo esc_html( $office['zip'] ); ?></span>
                            </span>
                        </div>
                        <div class="nap-col">
                            <span class="nap-label">Phone</span>
                            <a href="tel:<?php echo esc_attr($office['phone_e164']); ?>" class="nap-phone" itemprop="telephone">
                                <?php echo esc_html( $office['phone'] ); ?>
                            </a>
                            <span class="nap-hours">Available 24/7</span>
                        </div>
                    </div>
                    <div class="nap-actions" itemprop="geo" itemscope itemtype="https://schema.org/GeoCoordinates">
                        <meta itemprop="latitude" content="<?php echo esc_attr($office['lat']); ?>">
                        <meta itemprop="longitude" content="<?php echo esc_attr($office['lng']); ?>">
                        <a href="tel:<?php echo esc_attr($office['phone_e164']); ?>" class="btn btn-primary">📞 Call Now</a>
                        <a href="<?php echo esc_url($office['map_url']); ?>" class="btn btn-outline-light" target="_blank" rel="noopener noreferrer">🗺 Get Directions</a>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Map + Form -->
            <div class="hero-map-form">
                <div class="map-embed">
                    <iframe
                        title="Map — <?php echo esc_attr($office['name']); ?>"
                        src="<?php echo esc_url($map_src); ?>"
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

<!-- PRACTICE AREAS AT THIS LOCATION -->
<section class="section section-light">
    <div class="container">
        <h2 class="section-title">Personal Injury Cases We Handle in <?php echo esc_html($office['city']); ?></h2>
        <?php roden_practice_areas_grid( 4 ); ?>
    </div>
</section>

<!-- MAIN + SIDEBAR -->
<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <article class="main-content">

            <div class="content-section">
                <h2>About Our <?php echo esc_html($office['city']); ?> Office</h2>
                <div class="entry-content">
                    <?php
                    $content = get_the_content();
                    if ( trim( $content ) ) {
                        the_content();
                    } else {
                        echo '<p>Roden Law\'s ' . esc_html($office['city']) . ' office serves injury victims throughout the region. Our ' . esc_html($office['city']) . ' personal injury attorneys handle all types of injury claims under ' . esc_html($office['state_full']) . ' law.</p>';
                        echo '<p>Serving ' . esc_html($office['service_area']) . '</p>';
                    }
                    ?>
                    <p>Our <?php echo esc_html($office['city']); ?> office handles all personal injury matters under <?php echo esc_html($office['state_full']); ?> law with deep knowledge of local courts including the <?php echo esc_html($office['court']); ?>.</p>
                </div>
            </div>

            <!-- State Law Box -->
            <div class="content-section">
                <div class="state-law-box">
                    <h3>⚖ <?php echo esc_html($office['state_full']); ?> Personal Injury Law</h3>
                    <div class="law-details-grid">
                        <div class="law-detail">
                            <span class="law-label">Statute of Limitations</span>
                            <span class="law-value"><?php echo esc_html( $office['sol'] ); ?></span>
                        </div>
                        <div class="law-detail">
                            <span class="law-label">Comparative Fault</span>
                            <span class="law-value"><?php echo esc_html( $office['fault'] ); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attorneys -->
            <?php
            $atty_query = new WP_Query([
                'post_type'      => 'attorney',
                'posts_per_page' => 10,
                'meta_query'     => $office_key ? [[ 'key' => '_roden_office_key', 'value' => $office_key ]] : [],
            ]);
            if ( $atty_query->have_posts() ) : ?>
            <div class="content-section">
                <h2>Your <?php echo esc_html($office['city']); ?> Attorneys</h2>
                <?php roden_attorneys_grid( [ 'office_key' => $office_key, 'columns' => 3 ] ); ?>
            </div>
            <?php endif; wp_reset_postdata(); ?>

            <!-- Case Results -->
            <div class="content-section">
                <h2>Recent Results</h2>
                <?php roden_case_results_grid( [ 'count' => 3, 'columns' => 3 ] ); ?>
            </div>

            <?php roden_faq_section( $post_id ); ?>

        </article>

        <!-- SIDEBAR -->
        <aside class="sidebar sidebar-location">
            <div class="sidebar-sticky">
                <!-- NAP Card -->
                <div class="sidebar-widget sidebar-nap-card">
                    <h3 class="nap-card-name"><?php echo esc_html($office['name']); ?></h3>
                    <address>
                        <?php echo esc_html($office['address']); ?><br>
                        <?php echo esc_html($office['city'] . ', ' . $office['state'] . ' ' . $office['zip']); ?>
                    </address>
                    <a href="tel:<?php echo esc_attr($office['phone_e164']); ?>" class="nap-card-phone"><?php echo esc_html($office['phone']); ?></a>
                    <a href="<?php echo esc_url($office['map_url']); ?>" class="btn btn-dark btn-block" target="_blank" rel="noopener noreferrer">🗺 View on Google Maps</a>
                </div>

                <!-- Other Offices -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Our Other Offices</h3>
                    <ul class="sidebar-links">
                        <?php foreach ( $firm['offices'] as $k => $o ) :
                            if ( $k === $office_key ) continue;
                            $slug = strtolower( str_replace(' ', '-', $o['city']) );
                            $ss   = $o['state'] === 'GA' ? 'georgia' : 'south-carolina';
                            ?>
                            <li><a href="<?php echo esc_url( home_url('/locations/' . $ss . '/' . $slug . '/') ); ?>">→ <?php echo esc_html($o['city'] . ', ' . $o['state']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </aside>

    </div>
</div>

<?php get_footer(); ?>
