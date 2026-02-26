<?php
/**
 * Template: Intersection Page (Practice Area x Location)
 *
 * Displayed for child practice_area posts that have a _roden_pa_office_key
 * matching one of the 5 offices (e.g. /car-accident-lawyers/savannah-ga/).
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Ensure template helpers are available (guard against include-chain failures)
if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}

/* ── Gather data ─────────────────────────────────────────────────────── */

$firm    = roden_firm_data();
$post_id = get_the_ID();
$post    = get_post( $post_id );

$pa_office_key = get_post_meta( $post_id, '_roden_pa_office_key', true );
$office        = $firm['offices'][ $pa_office_key ];
$state_key     = $office['state']; // 'GA' or 'SC'
$jurisdiction  = isset( $firm['jurisdiction'][ $state_key ] ) ? $firm['jurisdiction'][ $state_key ] : null;

$parent_post  = $post->post_parent ? get_post( $post->post_parent ) : null;
$parent_title = $parent_post ? $parent_post->post_title : '';
$parent_url   = $parent_post ? get_permalink( $parent_post ) : '';

$author_id = get_post_meta( $post_id, '_roden_author_attorney', true );

// Practice category for filtering case results
$pa_terms = wp_get_object_terms( $post_id, 'practice_category', array( 'fields' => 'slugs' ) );
if ( is_wp_error( $pa_terms ) ) {
    $pa_terms = array();
}
// Fall back to parent's terms
if ( empty( $pa_terms ) && $parent_post ) {
    $pa_terms = wp_get_object_terms( $parent_post->ID, 'practice_category', array( 'fields' => 'slugs' ) );
    if ( is_wp_error( $pa_terms ) ) {
        $pa_terms = array();
    }
}
$cat_slug = ! empty( $pa_terms ) ? $pa_terms[0] : '';

// Related sub-types (sibling children without an office key)
$related_subtypes = get_posts( array(
    'post_type'      => 'practice_area',
    'post_parent'    => $post->post_parent,
    'posts_per_page' => 20,
    'exclude'        => array( $post_id ),
    'orderby'        => 'title',
    'order'          => 'ASC',
    'meta_query'     => array(
        'relation' => 'OR',
        array( 'key' => '_roden_pa_office_key', 'compare' => 'NOT EXISTS' ),
        array( 'key' => '_roden_pa_office_key', 'value' => '', 'compare' => '=' ),
    ),
) );
?>

<!-- ================================================================
     HERO
     ================================================================ -->
<section class="hero hero-intersection">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">
            <div class="hero-content">
                <span class="state-badge state-<?php echo esc_attr( strtolower( $office['state'] ) ); ?>">
                    <?php echo esc_html( $office['state_full'] ); ?>
                </span>
                <h1 class="hero-title"><?php the_title(); ?></h1>
                <p class="hero-subtitle">
                    Roden Law's <?php echo esc_html( $office['city'] ); ?> <?php echo esc_html( strtolower( $parent_title ) ); ?>s serve <?php echo esc_html( $office['service_area'] ); ?> No fees unless we win.
                </p>

                <!-- NAP Block -->
                <div class="nap-block">
                    <h3 class="nap-name"><?php echo esc_html( $office['name'] ); ?></h3>
                    <div class="nap-details">
                        <div class="nap-col">
                            <span class="nap-label">Address</span>
                            <span><?php echo esc_html( $office['street'] ); ?></span>
                            <span>
                                <?php echo esc_html( $office['city'] ); ?>,
                                <?php echo esc_html( $office['state'] ); ?>
                                <?php echo esc_html( $office['zip'] ); ?>
                            </span>
                        </div>
                        <div class="nap-col">
                            <span class="nap-label">Phone</span>
                            <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="nap-phone">
                                <?php echo esc_html( $office['phone'] ); ?>
                            </a>
                            <span class="nap-hours">Available 24/7</span>
                        </div>
                    </div>
                    <div class="nap-actions">
                        <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary">Call Now</a>
                        <a href="<?php echo esc_url( $office['map_url'] ); ?>" class="btn btn-outline-light" target="_blank" rel="noopener noreferrer">Get Directions</a>
                    </div>
                </div>
            </div>
            <div class="hero-form hero-map-form">
                <?php roden_contact_form_sidebar( $office['phone'] ); ?>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================
     LOCATION MATRIX — All 5 offices for this practice area
     ================================================================ -->
<section class="section-location-matrix">
    <div class="container">
        <h2 class="matrix-title"><?php echo esc_html( $parent_title ); ?> — All Locations</h2>
        <div class="location-matrix-grid">
            <?php foreach ( $firm['offices'] as $key => $o ) :
                $is_current = ( $key === $pa_office_key );
                // Find sibling intersection page for this office
                $sibling_posts = get_posts( array(
                    'post_type'   => 'practice_area',
                    'post_parent' => $post->post_parent,
                    'meta_key'    => '_roden_pa_office_key',
                    'meta_value'  => $key,
                    'numberposts' => 1,
                ) );
                $intersection_url = ! empty( $sibling_posts ) ? get_permalink( $sibling_posts[0] ) : '#';
            ?>
                <div class="matrix-card <?php echo $is_current ? 'matrix-card-active' : ''; ?>">
                    <span class="matrix-state state-<?php echo esc_attr( strtolower( $o['state'] ) ); ?>">
                        <?php echo esc_html( $o['state'] ); ?>
                    </span>
                    <h3 class="matrix-city">
                        <?php if ( ! $is_current ) : ?>
                            <a href="<?php echo esc_url( $intersection_url ); ?>"><?php echo esc_html( $o['city'] ); ?></a>
                        <?php else : ?>
                            <?php echo esc_html( $o['city'] ); ?>
                        <?php endif; ?>
                    </h3>
                    <?php if ( $is_current ) : ?>
                        <span class="matrix-current">Current Page</span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================================================================
     MAIN CONTENT + SIDEBAR
     ================================================================ -->
<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <!-- MAIN COLUMN -->
        <article class="main-content">

            <!-- Editor Content -->
            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <!-- State Law Box (single jurisdiction) -->
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

            <?php roden_inline_cta_banner(); ?>

            <!-- Office Attorneys -->
            <div class="content-section">
                <h2>Our <?php echo esc_html( $office['city'] ); ?> Attorneys</h2>
                <?php roden_attorneys_grid( array( 'office_key' => $pa_office_key, 'columns' => 3 ) ); ?>
            </div>

            <!-- Case Results -->
            <div class="content-section">
                <h2>Recent Case Results</h2>
                <?php roden_case_results_grid( array( 'count' => 3, 'columns' => 3, 'practice_category' => $cat_slug ) ); ?>
            </div>

            <!-- Author Attribution (E-E-A-T) -->
            <?php if ( $author_id ) :
                $atty = get_post( $author_id );
                if ( $atty ) :
                    $atty_title = get_post_meta( $atty->ID, '_roden_atty_title', true );
            ?>
            <div class="content-section author-attribution">
                <h2>About the Author</h2>
                <div class="author-card">
                    <div class="author-photo">
                        <?php if ( has_post_thumbnail( $atty ) ) : ?>
                            <?php echo get_the_post_thumbnail( $atty, 'thumbnail' ); ?>
                        <?php else : ?>
                            <div class="author-photo-placeholder"></div>
                        <?php endif; ?>
                    </div>
                    <div class="author-info">
                        <h3 class="author-name">
                            <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>">
                                <?php echo esc_html( $atty->post_title ); ?>
                            </a>
                        </h3>
                        <?php if ( $atty_title ) : ?>
                            <span class="author-title"><?php echo esc_html( $atty_title ); ?></span>
                        <?php endif; ?>
                        <?php if ( $atty->post_excerpt ) : ?>
                            <p class="author-bio"><?php echo wp_kses_post( $atty->post_excerpt ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; endif; ?>

            <!-- FAQ Accordion -->
            <?php roden_faq_section( $post_id ); ?>

            <!-- Bottom CTA -->
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
                    <a href="#contact" class="btn btn-outline-light">Free Case Evaluation</a>
                </div>
            </div>

        </article>

        <!-- SIDEBAR -->
        <aside class="sidebar sidebar-practice">
            <div class="sidebar-sticky">

                <!-- Contact Form -->
                <?php roden_contact_form_sidebar( $office['phone'] ); ?>

                <!-- Back to Pillar -->
                <?php if ( $parent_post ) : ?>
                <div class="sidebar-widget">
                    <h3 class="widget-title">Main Practice Area</h3>
                    <a href="<?php echo esc_url( $parent_url ); ?>" class="sidebar-back-link">
                        &larr; <?php echo esc_html( $parent_title ); ?>
                    </a>
                </div>
                <?php endif; ?>

                <!-- Related Sub-Types -->
                <?php if ( $related_subtypes ) : ?>
                <div class="sidebar-widget">
                    <h3 class="widget-title">Related Case Types</h3>
                    <ul class="sidebar-links">
                        <?php foreach ( $related_subtypes as $sib ) : ?>
                            <li>
                                <a href="<?php echo esc_url( get_permalink( $sib ) ); ?>">
                                    &rarr; <?php echo esc_html( $sib->post_title ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Sidebar NAP Card -->
                <div class="sidebar-widget sidebar-nap-card">
                    <h3 class="nap-card-name"><?php echo esc_html( $office['name'] ); ?></h3>
                    <address>
                        <?php echo esc_html( $office['street'] ); ?><br>
                        <?php echo esc_html( $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] ); ?>
                    </address>
                    <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="nap-card-phone">
                        <?php echo esc_html( $office['phone'] ); ?>
                    </a>
                    <a href="<?php echo esc_url( $office['map_url'] ); ?>" class="btn btn-dark btn-block" target="_blank" rel="noopener noreferrer">
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

                <!-- Why Roden Law -->
                <div class="sidebar-widget sidebar-why-us">
                    <h3 class="widget-title">Why Roden Law?</h3>
                    <ul class="why-us-list">
                        <li><?php echo esc_html( $firm['recovered'] ); ?> Recovered for Clients</li>
                        <li><?php echo esc_html( $firm['rating'] ); ?> Average Client Rating</li>
                        <li><?php echo esc_html( $firm['cases_handled'] ); ?> Cases Successfully Handled</li>
                        <li>No Fee Unless We Win</li>
                        <li>Free 24/7 Consultations</li>
                        <li>Licensed in GA &amp; SC</li>
                    </ul>
                </div>

            </div>
        </aside>

    </div>
</div>
