<?php
/**
 * Single Practice Area Template — Pillar Page
 *
 * LegalService + FAQPage + Speakable schema.
 * Jurisdiction-explicit hero, location matrix, sub-type grid,
 * FAQ accordion, case results, attorney attribution, sidebar.
 *
 * @package RodenLaw
 */

get_header();
$firm = roden_firm_data();
$post_id = get_the_ID();

$jurisdiction  = get_post_meta( $post_id, '_roden_jurisdiction', true ) ?: 'both';
$sol_ga        = get_post_meta( $post_id, '_roden_sol_ga', true );
$sol_sc        = get_post_meta( $post_id, '_roden_sol_sc', true );
$sub_types_raw = get_post_meta( $post_id, '_roden_sub_types', true );
$author_id     = get_post_meta( $post_id, '_roden_author_attorney', true );
$sub_types     = $sub_types_raw ? array_filter( array_map( 'trim', explode( "\n", $sub_types_raw ) ) ) : [];

$jurisdiction_label = 'Georgia & South Carolina';
if ( $jurisdiction === 'ga' ) $jurisdiction_label = 'Georgia';
elseif ( $jurisdiction === 'sc' ) $jurisdiction_label = 'South Carolina';
?>

<!-- HERO -->
<section class="hero hero-practice-area">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">
            <div class="hero-content">
                <div class="speakable-hero" data-speakable="true">
                    <h1 class="hero-title"><?php the_title(); ?></h1>
                    <p class="hero-jurisdiction">⚖ SERVING: <strong><?php echo esc_html( $jurisdiction_label ); ?></strong></p>
                </div>
                <div class="speakable-intro" data-speakable="true">
                    <?php if ( has_excerpt() ) : ?>
                        <p class="hero-subtitle"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                    <?php endif; ?>
                </div>

                <?php roden_stats_bar(); ?>

                <div class="hero-actions">
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary btn-lg">📞 Call <?php echo esc_html($firm['phone']); ?></a>
                    <a href="#contact" class="btn btn-outline-light btn-lg">Free Case Review</a>
                </div>
            </div>
            <div class="hero-form">
                <?php roden_contact_form_sidebar(); ?>
            </div>
        </div>
    </div>
</section>

<!-- LOCATION MATRIX -->
<section class="section-location-matrix">
    <div class="container">
        <h2 class="matrix-title">Our <?php the_title(); ?> Offices</h2>
        <div class="location-matrix-grid">
            <?php foreach ( $firm['offices'] as $key => $office ) :
                $pa_slug = sanitize_title( get_the_title() );
                $city_slug = strtolower( str_replace( ' ', '-', $office['city'] ) );
                $intersection_url = home_url( '/' . $pa_slug . '/' . $city_slug . '-' . strtolower($office['state']) . '/' );
            ?>
                <div class="matrix-card">
                    <span class="matrix-state state-<?php echo esc_attr(strtolower($office['state'])); ?>"><?php echo esc_html($office['state']); ?></span>
                    <h3 class="matrix-city"><?php echo esc_html( $office['city'] ); ?></h3>
                    <span class="matrix-url">/<?php echo esc_html($pa_slug); ?>/<?php echo esc_html($city_slug); ?>-<?php echo esc_html(strtolower($office['state'])); ?>/</span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- MAIN CONTENT + SIDEBAR -->
<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <!-- MAIN CONTENT -->
        <article class="main-content">

            <!-- Main Content from Editor -->
            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <!-- Sub-Types -->
            <?php if ( $sub_types ) : ?>
                <div class="content-section">
                    <h2 class="section-title">Types of <?php the_title(); ?> Cases We Handle</h2>
                    <div class="sub-types-grid">
                        <?php foreach ( $sub_types as $st ) : ?>
                            <div class="sub-type-card">
                                <span class="st-name"><?php echo esc_html( $st ); ?></span>
                                <span class="st-arrow">→</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Statute of Limitations -->
            <?php if ( $sol_ga || $sol_sc ) : ?>
                <div class="content-section">
                    <h2 class="section-title">Meeting the Statute of Limitations</h2>
                    <div class="sol-grid">
                        <?php if ( $sol_ga && in_array($jurisdiction, ['both','ga']) ) : ?>
                            <div class="sol-card sol-ga">
                                <span class="sol-state">🍑 Georgia Filing Deadline</span>
                                <span class="sol-years">2 Years</span>
                                <span class="sol-cite"><?php echo esc_html( $sol_ga ); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ( $sol_sc && in_array($jurisdiction, ['both','sc']) ) : ?>
                            <div class="sol-card sol-sc">
                                <span class="sol-state">🌙 South Carolina Filing Deadline</span>
                                <span class="sol-years">3 Years</span>
                                <span class="sol-cite"><?php echo esc_html( $sol_sc ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <p>If you fail to file within the statute of limitations, your claim will be dismissed and you will permanently lose the right to pursue compensation. Consult with a skilled attorney to ensure your claim is filed on time.</p>
                </div>
            <?php endif; ?>

            <?php roden_inline_cta_banner(); ?>

            <!-- Case Results -->
            <div class="content-section">
                <h2 class="section-title">Recent Case Results</h2>
                <?php
                $pa_terms = wp_get_object_terms( $post_id, 'practice_category', ['fields'=>'slugs'] );
                $cat_slug = ! empty($pa_terms) ? $pa_terms[0] : '';
                roden_case_results_grid( [ 'count' => 3, 'columns' => 3, 'practice_category' => $cat_slug ] );
                ?>
            </div>

            <!-- Author Attribution (E-E-A-T) -->
            <?php if ( $author_id ) :
                $atty = get_post( $author_id );
                if ( $atty ) :
                    $atty_title = get_post_meta( $atty->ID, '_roden_atty_title', true );
                ?>
                <div class="content-section author-attribution">
                    <h2 class="section-title">About the Author</h2>
                    <div class="author-card">
                        <div class="author-photo">
                            <?php if ( has_post_thumbnail( $atty ) ) : ?>
                                <?php echo get_the_post_thumbnail( $atty, 'thumbnail' ); ?>
                            <?php else : ?>
                                <div class="author-photo-placeholder">👤</div>
                            <?php endif; ?>
                        </div>
                        <div class="author-info">
                            <h3 class="author-name">
                                <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>"><?php echo esc_html( $atty->post_title ); ?></a>
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
                <?php endif; ?>
            <?php endif; ?>

            <!-- FAQ Section -->
            <?php roden_faq_section( $post_id ); ?>

            <!-- Bottom CTA -->
            <div class="bottom-cta-box">
                <h2>Contact Our <?php the_title(); ?>s Today</h2>
                <p>If you were injured and believe another party is at fault, contact us for a free, no-obligation review. We dedicate our skills and resources to recovering the maximum compensation you deserve — at no upfront cost.</p>
                <div class="cta-actions">
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary">📞 Call <?php echo esc_html($firm['phone']); ?></a>
                    <a href="#contact" class="btn btn-outline-light">Free Case Evaluation</a>
                </div>
            </div>
        </article>

        <!-- SIDEBAR -->
        <aside class="sidebar sidebar-practice">
            <div class="sidebar-sticky">
                <?php roden_contact_form_sidebar(); ?>

                <!-- Filing Deadlines -->
                <div class="sidebar-widget sidebar-deadlines">
                    <h3 class="widget-title">⏱ Filing Deadlines</h3>
                    <div class="deadline-badges">
                        <div class="deadline-badge deadline-ga">
                            <span class="deadline-years">2 yr</span>
                            <span class="deadline-state">Georgia</span>
                        </div>
                        <div class="deadline-badge deadline-sc">
                            <span class="deadline-years">3 yr</span>
                            <span class="deadline-state">South Carolina</span>
                        </div>
                    </div>
                    <p class="deadline-warning">Missing the deadline forfeits your right to recover.</p>
                </div>

                <!-- Related Practice Areas -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Related Practice Areas</h3>
                    <?php
                    $related = get_posts( [ 'post_type' => 'practice_area', 'posts_per_page' => 7, 'exclude' => [$post_id], 'orderby' => 'rand' ] );
                    if ( $related ) :
                        echo '<ul class="sidebar-links">';
                        foreach ( $related as $r ) {
                            echo '<li><a href="' . esc_url(get_permalink($r)) . '">→ ' . esc_html($r->post_title) . '</a></li>';
                        }
                        echo '</ul>';
                    endif;
                    ?>
                </div>

                <!-- Why Roden Law -->
                <div class="sidebar-widget sidebar-why-us">
                    <h3 class="widget-title">Why Roden Law?</h3>
                    <ul class="why-us-list">
                        <li>✓ <?php echo esc_html($firm['recovered']); ?> Recovered for Clients</li>
                        <li>✓ <?php echo esc_html($firm['rating']); ?>★ Average Client Rating</li>
                        <li>✓ <?php echo esc_html($firm['cases_handled']); ?> Cases Successfully Handled</li>
                        <li>✓ No Fee Unless We Win</li>
                        <li>✓ Free 24/7 Consultations</li>
                        <li>✓ Licensed in GA &amp; SC</li>
                    </ul>
                </div>
            </div>
        </aside>

    </div>
</div>

<?php get_footer(); ?>
