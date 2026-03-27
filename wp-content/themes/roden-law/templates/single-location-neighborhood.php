<?php
/**
 * Template: Neighborhood Page (Location child)
 *
 * Hyper-local landing page for neighborhoods served by a parent office.
 * Inherits office data from the parent location page and adds
 * neighborhood-specific sections: dangerous roads, hospitals, landmarks.
 *
 * Schema: LegalService, BreadcrumbList, FAQPage
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}

/* == Gather data ========================================================= */

$firm    = roden_firm_data();
$post_id = get_the_ID();

// Get neighborhood meta
$parent_office_key = get_post_meta( $post_id, '_roden_parent_office_key', true );
$roads             = get_post_meta( $post_id, '_roden_neighborhood_roads', true );
$hospitals         = get_post_meta( $post_id, '_roden_neighborhood_hospitals', true );
$landmarks         = get_post_meta( $post_id, '_roden_neighborhood_landmarks', true );
$service_area      = get_post_meta( $post_id, '_roden_neighborhood_service_area', true );
$population        = get_post_meta( $post_id, '_roden_neighborhood_population', true );
$court             = get_post_meta( $post_id, '_roden_neighborhood_court', true );
$faqs              = get_post_meta( $post_id, '_roden_faqs', true );
$neighborhood_name = get_the_title();

// Resolve parent office — fall back to office key on parent post
if ( ! $parent_office_key ) {
    $parent_id = wp_get_post_parent_id( $post_id );
    if ( $parent_id ) {
        $parent_office_key = get_post_meta( $parent_id, '_roden_office_key', true );
    }
}

if ( ! $parent_office_key || ! isset( $firm['offices'][ $parent_office_key ] ) ) {
    echo '<div class="container"><p>Parent office not configured. Please set the Parent Office Key in the admin.</p></div>';
    return;
}

$office       = $firm['offices'][ $parent_office_key ];
$state_key    = $office['state'];
$jurisdiction = isset( $firm['jurisdiction'][ $state_key ] ) ? $firm['jurisdiction'][ $state_key ] : null;
$stats        = $firm['trust_stats'];

// Meta title / SEO fields from Yoast are handled by that plugin if active.
// H1 from post meta or auto-generated.
$h1 = get_post_meta( $post_id, '_roden_neighborhood_h1', true );
if ( ! $h1 ) {
    $h1 = 'Personal Injury Lawyer Serving ' . $neighborhood_name . ', ' . $office['state_full'];
}

// Map embed URL for parent office
$map_embed = get_post_meta( wp_get_post_parent_id( $post_id ), '_roden_map_embed', true );
if ( ! $map_embed && ! empty( $office['map_embed'] ) ) {
    $map_embed = $office['map_embed'];
}
if ( ! $map_embed ) {
    $map_query = urlencode( $office['street'] . ', ' . $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] );
    $map_embed = 'https://maps.google.com/maps?q=' . $map_query . '&output=embed&z=15';
}

// Get Directions link for this neighborhood
$directions_url = 'https://www.google.com/maps/dir/' . urlencode( $neighborhood_name . ', ' . $office['state'] ) . '/' . urlencode( $office['street'] . ', ' . $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] ) . '/';

// Schema (LegalService, LocalBusiness, FAQPage, BreadcrumbList) is output
// automatically by roden_output_schema() via wp_head — no inline output needed.
?>

<!-- ================================================================
     1. HERO SECTION
     ================================================================ -->
<section class="hero hero-neighborhood">
    <div class="hero-bg-overlay"></div>
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">

            <!-- LEFT: Info + CTAs -->
            <div class="hero-content">
                <span class="state-badge state-<?php echo esc_attr( strtolower( $office['state'] ) ); ?>">
                    SERVING <?php echo esc_html( strtoupper( $neighborhood_name ) ); ?> FROM OUR <?php echo esc_html( strtoupper( $office['market_name'] ) ); ?> OFFICE
                </span>
                <h1 class="hero-title"><?php echo esc_html( $h1 ); ?></h1>
                <p class="hero-subtitle">
                    Roden Law's <?php echo esc_html( $office['market_name'] ); ?> office serves injury victims throughout <?php echo esc_html( $neighborhood_name ); ?>
                    <?php if ( $service_area ) :
                        $area_text = wp_strip_all_tags( $service_area );
                        // Strip "Serving {anything}, " prefix to get just the surrounding areas list.
                        // Handles all patterns: "Serving Pooler, ...", "Serving the French Quarter, ...",
                        // "Serving downtown Conway, ...", "Serving active-duty personnel, ...", etc.
                        $area_clean = preg_replace( '/^Serving\s+[^,]+,\s*/i', '', $area_text );
                        // Remove trailing period so we can control punctuation.
                        $area_clean = rtrim( $area_clean, '.' );
                        if ( $area_clean && $area_clean !== $area_text ) : ?>
                            , <?php echo esc_html( $area_clean ); ?>.
                        <?php else : ?>
                            and the surrounding area.
                        <?php endif; ?>
                    <?php else : ?>
                        and the surrounding area.
                    <?php endif; ?>
                    No fees unless we win.
                </p>

                <!-- Trust Stats -->
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
                </div>

                <!-- Hero CTAs -->
                <div class="hero-ctas">
                    <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary btn-lg">
                        Call <?php echo esc_html( $office['phone'] ); ?>
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
     2. NAP BLOCK — Parent office info + map
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
                <a href="<?php echo esc_url( $directions_url ); ?>" class="btn btn-outline-light" target="_blank" rel="noopener noreferrer">Get Directions from <?php echo esc_html( $neighborhood_name ); ?></a>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================
     3. ABOUT [NEIGHBORHOOD] — post_content + population
     ================================================================ -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">About <?php echo esc_html( $neighborhood_name ); ?></h2>
            <?php if ( $population ) : ?>
                <p class="section-subtitle">Population: <?php echo esc_html( $population ); ?></p>
            <?php endif; ?>
        </div>
        <div class="entry-content neighborhood-content">
            <?php
            $content = get_the_content();
            if ( trim( $content ) ) {
                the_content();
            } else {
                echo '<p>Roden Law\'s ' . esc_html( $office['market_name'] ) . ' office serves injury victims in '
                     . esc_html( $neighborhood_name ) . ' and the surrounding ' . esc_html( $office['state_full'] )
                     . ' communities. If you\'ve been injured in ' . esc_html( $neighborhood_name )
                     . ', contact us for a free case review.</p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- ================================================================
     3b. SUB-NEIGHBORHOODS (if this neighborhood has children)
     ================================================================ -->
<?php
$sub_neighborhoods = get_posts( array(
    'post_type'      => 'location',
    'post_parent'    => $post_id,
    'posts_per_page' => -1,
    'meta_key'       => '_roden_is_neighborhood',
    'meta_value'     => '1',
    'orderby'        => 'title',
    'order'          => 'ASC',
    'post_status'    => 'publish',
) );

if ( ! empty( $sub_neighborhoods ) ) :
?>
<section class="section section-alt roden-neighborhoods-served">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Neighborhoods We Serve in <?php echo esc_html( $neighborhood_name ); ?></h2>
            <p class="section-subtitle">
                Click any neighborhood below to learn about local accident hotspots, nearby hospitals, and how Roden Law can help.
            </p>
        </div>
        <div class="roden-neighborhood-grid">
            <?php foreach ( $sub_neighborhoods as $child ) :
                $child_pop = get_post_meta( $child->ID, '_roden_neighborhood_population', true );
            ?>
                <a href="<?php echo esc_url( get_permalink( $child->ID ) ); ?>" class="neighborhood-card">
                    <span class="neighborhood-name"><?php echo esc_html( $child->post_title ); ?></span>
                    <?php if ( $child_pop ) : ?>
                        <span class="neighborhood-pop">Pop. <?php echo esc_html( $child_pop ); ?></span>
                    <?php endif; ?>
                    <span class="neighborhood-arrow">&rarr;</span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================================================================
     4. DANGEROUS ROADS & INTERSECTIONS
     ================================================================ -->
<?php if ( $roads ) : ?>
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Dangerous Roads &amp; Intersections in <?php echo esc_html( $neighborhood_name ); ?></h2>
        </div>
        <div class="neighborhood-roads-content entry-content">
            <?php echo wpautop( esc_html( $roads ) ); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================================================================
     5. NEAREST HOSPITALS & ERs
     ================================================================ -->
<?php if ( $hospitals ) : ?>
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Nearest Hospitals &amp; Emergency Rooms</h2>
            <p class="section-subtitle">If you've been injured in <?php echo esc_html( $neighborhood_name ); ?>, seek medical attention immediately at one of these nearby facilities.</p>
        </div>
        <div class="neighborhood-hospitals">
            <?php
            $hospital_lines = array_filter( array_map( 'trim', explode( "\n", $hospitals ) ) );
            foreach ( $hospital_lines as $hospital ) :
                // Parse format: Name — Address — Phone
                $parts = array_map( 'trim', explode( '—', $hospital ) );
                $h_name    = $parts[0] ?? '';
                $h_address = $parts[1] ?? '';
                $h_phone   = $parts[2] ?? '';
            ?>
                <div class="hospital-card">
                    <h3 class="hospital-name"><?php echo esc_html( $h_name ); ?></h3>
                    <?php if ( $h_address ) : ?>
                        <span class="hospital-address"><?php echo esc_html( $h_address ); ?></span>
                    <?php endif; ?>
                    <?php if ( $h_phone ) : ?>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $h_phone ) ); ?>" class="hospital-phone"><?php echo esc_html( $h_phone ); ?></a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================================================================
     6. PRACTICE AREAS GRID — links to intersection pages
     ================================================================ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Cases We Handle in <?php echo esc_html( $neighborhood_name ); ?></h2>
            <p class="section-subtitle">Our <?php echo esc_html( $office['market_name'] ); ?> attorneys handle all types of personal injury cases for <?php echo esc_html( $neighborhood_name ); ?> residents.</p>
        </div>
        <?php roden_intersection_grid( $parent_office_key, 3 ); ?>
    </div>
</section>

<!-- ================================================================
     7. STATE LAW BOX
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
                    <?php if ( $court ) : ?>
                    <div class="law-detail">
                        <span class="law-label">Court Jurisdiction</span>
                        <span class="law-value"><?php echo esc_html( $court ); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================================================================
     8. YOUR CHARLESTON ATTORNEYS
     ================================================================ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Your <?php echo esc_html( $office['market_name'] ); ?> Attorneys</h2>
            <p class="section-subtitle">Our <?php echo esc_html( $office['market_name'] ); ?>-based personal injury attorneys serve <?php echo esc_html( $neighborhood_name ); ?> residents.</p>
        </div>
        <?php roden_attorneys_grid( array( 'office_key' => $parent_office_key, 'columns' => 3 ) ); ?>
    </div>
</section>

<!-- ================================================================
     9. FAQ ACCORDION
     ================================================================ -->
<?php if ( ! empty( $faqs ) && is_array( $faqs ) ) : ?>
<section class="section">
    <div class="container">
        <?php roden_faq_section( $post_id ); ?>
    </div>
</section>
<?php endif; ?>

<!-- ================================================================
     10. NEARBY NEIGHBORHOODS GRID
     ================================================================ -->
<?php if ( function_exists( 'roden_neighborhood_grid' ) ) : ?>
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <?php
            $sibling_parent_id = wp_get_post_parent_id( $post_id );
            $parent_is_neighborhood = $sibling_parent_id ? get_post_meta( $sibling_parent_id, '_roden_is_neighborhood', true ) : false;
            if ( $parent_is_neighborhood ) :
                $parent_title = get_the_title( $sibling_parent_id );
            ?>
                <h2 class="section-title">Other <?php echo esc_html( $parent_title ); ?> Neighborhoods We Serve</h2>
                <p class="section-subtitle">Roden Law's <?php echo esc_html( $office['market_name'] ); ?> office serves communities throughout <?php echo esc_html( $parent_title ); ?> and the surrounding area.</p>
            <?php else : ?>
                <h2 class="section-title">Other Neighborhoods We Serve Near <?php echo esc_html( $neighborhood_name ); ?></h2>
                <p class="section-subtitle">Roden Law's <?php echo esc_html( $office['market_name'] ); ?> office serves communities throughout the greater <?php echo esc_html( $office['market_name'] ); ?> area.</p>
            <?php endif; ?>
        </div>
        <?php roden_neighborhood_grid( $post_id ); ?>
    </div>
</section>
<?php endif; ?>

<!-- ================================================================
     11. BOTTOM CTA
     ================================================================ -->
<section class="section bg-navy cta-bottom">
    <div class="container text-center">
        <h2 class="text-white">Injured in <?php echo esc_html( $neighborhood_name ); ?>? Contact Our <?php echo esc_html( $office['market_name'] ); ?> Office Today</h2>
        <p class="text-white" style="opacity:0.85; max-width:600px; margin:0 auto var(--space-xl, 32px);">
            No fees unless we win. Roden Law's <a href="<?php echo esc_url( get_permalink( wp_get_post_parent_id( $post_id ) ) ); ?>" style="color: var(--orange, #FCB415); text-decoration: underline;"><?php echo esc_html( $office['market_name'] ); ?> office</a>
            serves all of <?php echo esc_html( $neighborhood_name ); ?> and the surrounding <?php echo esc_html( $office['market_name'] ); ?> area.
        </p>
        <div class="hero-ctas" style="justify-content:center;">
            <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary btn-lg">
                Call <?php echo esc_html( $office['phone'] ); ?>
            </a>
            <a href="#free-case-review" class="btn btn-outline-light btn-lg">Free Case Review</a>
        </div>
    </div>
</section>
