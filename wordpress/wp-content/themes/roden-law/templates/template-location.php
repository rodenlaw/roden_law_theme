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
    echo '<div class="container"><p>' . esc_html__( 'Office not configured. Please set the Office Key in the admin.', 'roden-law' ) . '</p></div>';
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
if ( ! $map_embed && ! empty( $office['map_embed'] ) ) {
    $map_embed = $office['map_embed'];
}
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
                    <?php esc_html_e( 'Personal Injury Lawyer', 'roden-law' ); ?><br>
                    <span class="text-accent"><?php printf( /* translators: %s: city + state, e.g. "Savannah, GA". */ esc_html__( 'in %s', 'roden-law' ), esc_html( $office['market_name'] . ', ' . $office['state'] ) ); ?></span>
                </h1>
                <p class="hero-subtitle">
                    <?php
                    printf(
                        /* translators: 1: city/market name; 2: amount recovered wrapped in <strong>; 3: service area sentence (ends with a period). */
                        esc_html__( 'Roden Law\'s %1$s personal injury attorneys have recovered %2$s for injury victims across %3$s No fees unless we win.', 'roden-law' ),
                        esc_html( $office['market_name'] ),
                        '<strong>' . esc_html( $stats['recovered'] ) . '</strong>',
                        esc_html( $service_area )
                    );
                    ?>
                </p>

                <?php roden_last_updated_date( $post_id ); ?>

                <!-- Trust Stats (matching homepage hero-stats) -->
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['recovered'] ); ?></span>
                        <span class="stat-label"><?php esc_html_e( 'Recovered for Clients', 'roden-law' ); ?></span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['rating'] ); ?>&#9733;</span>
                        <span class="stat-label"><?php esc_html_e( 'Client Rating', 'roden-law' ); ?></span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['cases'] ); ?></span>
                        <span class="stat-label"><?php esc_html_e( 'Cases Handled', 'roden-law' ); ?></span>
                    </div>
                </div>

                <!-- Hero CTAs -->
                <div class="hero-ctas">
                    <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary btn-lg">
                        <?php printf( /* translators: %s: phone number. */ esc_html__( 'Call %s', 'roden-law' ), esc_html( $office['phone'] ) ); ?>
                    </a>
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
                <span class="badge-label"><?php esc_html_e( 'State Bar of Georgia', 'roden-law' ); ?></span>
            </div>
            <div class="badge-item">
                <span class="badge-icon" aria-hidden="true"></span>
                <span class="badge-label"><?php esc_html_e( 'American Association for Justice', 'roden-law' ); ?></span>
            </div>
            <div class="badge-item">
                <span class="badge-icon" aria-hidden="true"></span>
                <span class="badge-label"><?php esc_html_e( 'Georgia Trial Lawyers', 'roden-law' ); ?></span>
            </div>
            <div class="badge-item">
                <span class="badge-icon" aria-hidden="true"></span>
                <span class="badge-label"><?php esc_html_e( 'American Bar Association', 'roden-law' ); ?></span>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================
     3. GOOGLE MAP — full-width embedded map + NAP info bar
     ================================================================ -->
<section class="section section-map">
    <iframe
        title="<?php printf( esc_attr__( 'Location map for Roden Law — %s', 'roden-law' ), esc_attr( $office['market_name'] ) ); ?>"
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
                <a href="<?php echo esc_url( $office['map_url'] ); ?>" class="btn btn-outline-light" target="_blank" rel="noopener noreferrer nofollow"><?php esc_html_e( 'Get Directions', 'roden-law' ); ?></a>
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
            <h2 class="section-title"><?php printf( /* translators: %s: city/market name. */ esc_html__( 'Cases We Handle in %s', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h2>
            <p class="section-subtitle"><?php printf( /* translators: 1: city/market name; 2: state name. */ esc_html__( 'Our %1$s attorneys handle all types of personal injury cases in %2$s.', 'roden-law' ), esc_html( $office['market_name'] ), esc_html( $office['state_full'] ) ); ?></p>
        </div>
        <?php roden_intersection_grid( $office_key, 3 ); ?>
    </div>
</section>

<!-- ================================================================
     4b. NEIGHBORHOODS SERVED (auto-renders if parent has neighborhood children)
     ================================================================ -->
<?php
$neighborhood_children_args = array(
    'post_type'      => 'location',
    'post_parent'    => $post_id,
    'posts_per_page' => -1,
    'meta_key'       => '_roden_is_neighborhood',
    'meta_value'     => '1',
    'orderby'        => 'title',
    'order'          => 'ASC',
    'post_status'    => 'publish',
);
if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
    $neighborhood_children_args['meta_query'] = roden_es_exclusion_meta_query();
}
$neighborhood_children = get_posts( $neighborhood_children_args );

if ( ! empty( $neighborhood_children ) ) :
?>
<section class="section roden-neighborhoods-served">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?php printf( /* translators: %s: city/market name. */ esc_html__( 'Areas Served in the %s Metro Region', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h2>
            <p class="section-subtitle">
                <?php printf( /* translators: %s: city/market name (used twice). */ esc_html__( 'Roden Law\'s %1$s office serves injury victims throughout the greater %1$s metro region. Click any area below to learn about local accident hotspots, nearby hospitals, and how we can help.', 'roden-law' ), esc_html( $office['market_name'] ) ); ?>
            </p>
        </div>
        <div class="roden-neighborhood-grid">
            <?php foreach ( $neighborhood_children as $child ) :
                $child_pop = get_post_meta( $child->ID, '_roden_neighborhood_population', true );
            ?>
                <a href="<?php echo esc_url( get_permalink( $child->ID ) ); ?>" class="neighborhood-card">
                    <span class="neighborhood-name"><?php echo esc_html( $child->post_title ); ?></span>
                    <?php if ( $child_pop ) : ?>
                        <span class="neighborhood-pop"><?php printf( /* translators: %s: neighborhood population figure. */ esc_html__( 'Pop. %s', 'roden-law' ), esc_html( $child_pop ) ); ?></span>
                    <?php endif; ?>
                    <span class="neighborhood-arrow">&rarr;</span>
                </a>
            <?php endforeach; ?>
        </div>
        <p class="neighborhoods-note">
            <?php
            printf(
                /* translators: 1: city/market name; 2: phone number link. */
                esc_html__( 'Don\'t see your area? We serve all of the greater %1$s metro region. Call %2$s for a free consultation.', 'roden-law' ),
                esc_html( $office['market_name'] ),
                '<a href="tel:' . esc_attr( $office['phone_raw'] ) . '">' . esc_html( $office['phone'] ) . '</a>'
            );
            ?>
        </p>
    </div>
</section>
<?php endif; ?>

<!-- ================================================================
     4c. LOCAL LEGAL RESOURCES (auto-renders resources relevant to this office)
     ================================================================ -->
<?php
$loc_resource_args = array(
    'post_type'      => 'resource',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
);
if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
    $loc_resource_args['meta_query'] = roden_es_exclusion_meta_query();
}
$loc_resource_query = new WP_Query( $loc_resource_args );
if ( $loc_resource_query->have_posts() ) :
    // Filter and boost resources relevant to this office's geographic area.
    $loc_boosted = array();
    $loc_rest    = array();
    $loc_market_slug = sanitize_title( $office['market_name'] );
    $loc_city_slug   = sanitize_title( $office['city'] );
    $loc_state_lower = strtolower( $office['state'] );

    while ( $loc_resource_query->have_posts() ) {
        $loc_resource_query->the_post();
        $r_slug = get_post_field( 'post_name', get_the_ID() );
        $r_item = array(
            'title' => get_the_title(),
            'url'   => get_the_permalink(),
        );
        if ( strpos( $r_slug, $loc_market_slug ) !== false || strpos( $r_slug, $loc_city_slug ) !== false ) {
            $loc_boosted[] = $r_item;
        } else {
            $loc_rest[] = $r_item;
        }
    }
    wp_reset_postdata();

    // Only show this section if we have at least 1 local resource.
    if ( ! empty( $loc_boosted ) ) :
        $loc_items = array_slice( array_merge( $loc_boosted, $loc_rest ), 0, 6 );
?>
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?php printf( /* translators: %s: city/market name. */ esc_html__( 'Legal Resources for %s', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h2>
            <p class="section-subtitle"><?php printf( /* translators: %s: city/market name. */ esc_html__( 'Guides and resources about accident hotspots, local roads, and injury claims in the %s area.', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></p>
        </div>
        <div class="pa-resources__grid">
            <?php foreach ( $loc_items as $lr ) : ?>
                <a href="<?php echo esc_url( $lr['url'] ); ?>" class="resource-link">
                    <span class="resource-link__title"><?php echo esc_html( $lr['title'] ); ?></span>
                    <span class="resource-link__arrow">&rarr;</span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
    endif;
endif;
?>

<!-- ================================================================
     5. ABOUT — full-width section with the_content()
     ================================================================ -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?php printf( /* translators: %s: city/market name. */ esc_html__( 'About Our %s Office', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h2>
        </div>
        <div class="entry-content">
            <?php
            $content = get_the_content();
            if ( trim( $content ) ) {
                the_content();
            } else {
                echo '<p>' . sprintf(
                    /* translators: 1: city/market name (used twice); 2: state name. */
                    esc_html__( 'Roden Law\'s %1$s office serves injury victims throughout the region. Our %1$s personal injury attorneys handle all types of injury claims under %2$s law.', 'roden-law' ),
                    esc_html( $office['market_name'] ),
                    esc_html( $office['state_full'] )
                ) . '</p>';
                echo '<p>' . sprintf(
                    /* translators: %s: service area sentence (ends with a period). */
                    esc_html__( 'Serving %s', 'roden-law' ),
                    esc_html( $service_area )
                ) . '</p>';
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
     5b. EXPERT QUOTE (AI-citable — +30% visibility)
     ================================================================ -->
<?php
// Try to find an expert quote from the lead attorney at this office
$location_attorneys = get_posts( array(
    'post_type'      => 'attorney',
    'posts_per_page' => 1,
    'meta_key'       => '_roden_office_key',
    'meta_value'     => $office_key,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
$loc_expert_quote = get_post_meta( $post_id, '_roden_expert_quote', true );
if ( $loc_expert_quote && ! empty( $location_attorneys ) ) {
    roden_expert_quote_block( $loc_expert_quote, $location_attorneys[0]->ID );
} elseif ( $loc_expert_quote ) {
    // Show quote without specific attorney attribution
    echo '<blockquote class="expert-quote-block" data-ai-extractable="true"><p>&ldquo;' . wp_kses_post( $loc_expert_quote ) . '&rdquo;</p><footer><cite>&mdash; ' . sprintf( /* translators: %s: city/market name. */ esc_html__( 'Roden Law, %s Office', 'roden-law' ), esc_html( $office['market_name'] ) ) . '</cite></footer></blockquote>';
}
?>

<!-- ================================================================
     6. WHY CHOOSE — 4-column cards (full-width)
     ================================================================ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?php printf( /* translators: %s: city/market name. */ esc_html__( 'Why Choose Roden Law in %s?', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h2>
        </div>
        <div class="why-choose-grid">
            <div class="card why-choose-card">
                <h3><?php esc_html_e( 'No Fee Unless We Win', 'roden-law' ); ?></h3>
                <p><?php esc_html_e( 'You pay nothing upfront. Our contingency fee model means we only get paid when you recover compensation.', 'roden-law' ); ?></p>
            </div>
            <div class="card why-choose-card">
                <h3><?php printf( /* translators: %s: amount recovered, e.g. "$300M+". */ esc_html__( '%s Recovered', 'roden-law' ), esc_html( $stats['recovered'] ) ); ?></h3>
                <p><?php printf( /* translators: %s: amount recovered, e.g. "$300M+". */ esc_html__( 'Our track record speaks for itself — over %s recovered for personal injury victims.', 'roden-law' ), esc_html( $stats['recovered'] ) ); ?></p>
            </div>
            <div class="card why-choose-card">
                <h3><?php printf( /* translators: %s: state name. */ esc_html__( 'Local %s Attorneys', 'roden-law' ), esc_html( $office['state_full'] ) ); ?></h3>
                <p><?php printf( /* translators: 1: city/market name; 2: state name; 3: local court name. */ esc_html__( 'Our %1$s team practices in %2$s courts, including the %3$s.', 'roden-law' ), esc_html( $office['market_name'] ), esc_html( $office['state_full'] ), esc_html( $office['court'] ) ); ?></p>
            </div>
            <div class="card why-choose-card">
                <h3><?php printf( /* translators: %s: star rating, e.g. "4.9". */ esc_html__( '%s-Star Client Rating', 'roden-law' ), esc_html( $stats['rating'] ) ); ?></h3>
                <p><?php printf( /* translators: 1: star rating; 2: review-count phrase, e.g. "hundreds of". */ esc_html__( 'Rated %1$s stars from %2$s client reviews. Our clients trust us to deliver results.', 'roden-law' ), esc_html( $stats['rating'] ), esc_html( $stats['reviews'] ) ); ?></p>
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
            <h2 class="section-title"><?php printf( /* translators: %s: state name. */ esc_html__( '%s Personal Injury Law', 'roden-law' ), esc_html( $jurisdiction['state_full'] ) ); ?></h2>
        </div>
        <div class="jurisdiction-cards">
            <div class="state-law-box">
                <div class="law-details-grid">
                    <div class="law-detail">
                        <span class="law-label"><?php esc_html_e( 'Statute of Limitations', 'roden-law' ); ?></span>
                        <span class="law-value">
                            <?php printf( /* translators: 1: number of years; 2: statute citation. */ esc_html__( '%1$s years (%2$s)', 'roden-law' ), esc_html( $jurisdiction['statute_years'] ), esc_html( $jurisdiction['statute_cite'] ) ); ?>
                        </span>
                    </div>
                    <div class="law-detail">
                        <span class="law-label"><?php esc_html_e( 'Comparative Fault', 'roden-law' ); ?></span>
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
                    <span class="law-label"><?php esc_html_e( 'Address:', 'roden-law' ); ?></span>
                    <span class="law-value"><?php echo esc_html( $office['court_address'] ); ?></span>
                </div>
                <?php endif; ?>
                <p style="margin-top:12px; font-size:0.9rem; color:var(--gray-600);">
                    <?php printf( /* translators: 1: city/market name; 2: local court name. */ esc_html__( 'Our %1$s attorneys regularly appear before the %2$s and are familiar with local procedures and filing requirements.', 'roden-law' ), esc_html( $office['market_name'] ), esc_html( $office['court'] ) ); ?>
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
            <h2 class="section-title"><?php printf( /* translators: %s: city/market name. */ esc_html__( 'Your %s Attorneys', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h2>
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
            <h2 class="section-title text-white"><?php esc_html_e( 'Our Results Speak for Themselves', 'roden-law' ); ?></h2>
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
            <h2 class="section-title"><?php printf( /* translators: %s: city/market name. */ esc_html__( 'Communities We Serve from %s', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h2>
            <p class="section-subtitle"><?php printf( /* translators: 1: city/market name; 2: service area sentence (ends with a period). */ esc_html__( 'Our %1$s personal injury lawyers proudly serve %2$s', 'roden-law' ), esc_html( $office['market_name'] ), esc_html( $service_area ) ); ?></p>
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
            <h3><?php printf( /* translators: %s: city/market name. */ esc_html__( 'How to Find Our %s Office', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h3>
            <p><?php echo esc_html( $office['directions'] ); ?></p>
            <a href="<?php echo esc_url( $office['map_url'] ); ?>" class="btn btn-primary" target="_blank" rel="noopener noreferrer nofollow">
                <?php esc_html_e( 'Get Directions on Google Maps', 'roden-law' ); ?>
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
            <h2 class="section-title"><?php esc_html_e( 'Our Other Offices', 'roden-law' ); ?></h2>
            <p class="section-subtitle"><?php printf( /* translators: %d: number of offices. */ esc_html__( 'Roden Law serves injury victims across Georgia and South Carolina from %d offices.', 'roden-law' ), count( $firm['offices'] ) ); ?></p>
        </div>
        <div class="locations-grid">
            <?php foreach ( $firm['offices'] as $k => $o ) :
                if ( $k === $office_key ) continue;
                $slug       = sanitize_title( $o['market_name'] );
                $state_slug = $o['state'] === 'GA' ? 'georgia' : 'south-carolina';
                $office_url = home_url( '/locations/' . $state_slug . '/' . $slug . '/' );
            ?>
            <div class="card location-card">
                <span class="badge <?php echo 'GA' === $o['state'] ? 'badge-ga' : 'badge-sc'; ?>">
                    <?php echo esc_html( $o['state'] ); ?>
                </span>
                <h3><?php echo esc_html( $o['market_name'] ); ?></h3>
                <address>
                    <?php echo esc_html( $o['street'] ); ?><br>
                    <?php echo esc_html( $o['city'] . ', ' . $o['state'] . ' ' . $o['zip'] ); ?>
                </address>
                <a href="tel:<?php echo esc_attr( $o['phone_raw'] ); ?>" class="location-phone">
                    <?php echo esc_html( $o['phone'] ); ?>
                </a>
                <a href="<?php echo esc_url( $office_url ); ?>" class="location-link"><?php esc_html_e( 'View Office', 'roden-law' ); ?> &rarr;</a>
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
        <h2 class="text-white"><?php printf( /* translators: %s: city/market name. */ esc_html__( 'Injured in %s? Get Your Free Case Review Today.', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h2>
        <p class="text-white" style="opacity:0.85; max-width:600px; margin:0 auto var(--space-xl, 32px);">
            <?php printf( /* translators: %s: state name. */ esc_html__( 'No fees unless we win. Available 24/7 across %s.', 'roden-law' ), esc_html( $office['state_full'] ) ); ?>
        </p>
        <div class="hero-ctas" style="justify-content:center;">
            <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary btn-lg">
                <?php printf( /* translators: %s: phone number. */ esc_html__( 'Call %s', 'roden-law' ), esc_html( $office['phone'] ) ); ?>
            </a>
            <a href="#free-case-review" class="btn btn-outline-light btn-lg"><?php esc_html_e( 'Free Case Review', 'roden-law' ); ?></a>
        </div>
    </div>
</section>
