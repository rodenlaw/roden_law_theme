<?php
/**
 * Template: Sub-Type Practice Area Page
 *
 * Loaded by single-practice_area.php when $is_subtype is true.
 *
 * Expects these variables from the router:
 *   $firm, $post_id, $post, $jurisdiction, $jurisdiction_label,
 *   $sol_ga, $sol_sc, $author_id, $parent_post,
 *   $parent_title, $parent_url, $siblings
 *
 * @package RodenLaw
 */
?>

<!-- HERO -->
<section class="hero hero-practice-area">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">
            <div class="hero-content">
                <div class="speakable-hero" data-speakable="true">
                    <h1 class="hero-title"><?php the_title(); ?></h1>
                    <p class="hero-jurisdiction">&#9878; SERVING: <strong><?php echo esc_html( $jurisdiction_label ); ?></strong></p>
                </div>
                <?php if ( has_excerpt() ) : ?>
                    <p class="hero-subtitle"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                <?php endif; ?>

                <?php roden_stats_bar(); ?>

                <div class="hero-actions">
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary btn-lg">&#128222; Call <?php echo esc_html($firm['phone']); ?></a>
                    <a href="#contact" class="btn btn-outline-light btn-lg">Free Case Review</a>
                </div>
            </div>
            <div class="hero-form">
                <?php roden_contact_form_sidebar(); ?>
            </div>
        </div>
    </div>
</section>

<!-- MAIN + SIDEBAR -->
<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">
        <article class="main-content">

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <!-- Statute of Limitations -->
            <?php if ( $sol_ga || $sol_sc ) : ?>
                <div class="content-section">
                    <h2>Meeting the Statute of Limitations</h2>
                    <div class="sol-grid">
                        <?php if ( $sol_ga && in_array($jurisdiction, ['both','ga']) ) : ?>
                            <div class="sol-card sol-ga">
                                <span class="sol-state">&#127825; Georgia Filing Deadline</span>
                                <span class="sol-years">2 Years</span>
                                <span class="sol-cite"><?php echo esc_html( $sol_ga ); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ( $sol_sc && in_array($jurisdiction, ['both','sc']) ) : ?>
                            <div class="sol-card sol-sc">
                                <span class="sol-state">&#127769; South Carolina Filing Deadline</span>
                                <span class="sol-years">3 Years</span>
                                <span class="sol-cite"><?php echo esc_html( $sol_sc ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php roden_inline_cta_banner(); ?>

            <!-- Case Results -->
            <div class="content-section">
                <h2>Recent Case Results</h2>
                <?php roden_case_results_grid( [ 'count' => 3, 'columns' => 3 ] ); ?>
            </div>

            <?php roden_faq_section( $post_id ); ?>

            <!-- Bottom CTA -->
            <div class="bottom-cta-box">
                <h2>Contact Our <?php the_title(); ?>s Today</h2>
                <p>If you were injured and believe another party is at fault, contact us for a free, no-obligation review. We dedicate our skills and resources to recovering the maximum compensation you deserve — at no upfront cost.</p>
                <div class="cta-actions">
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary">&#128222; Call <?php echo esc_html($firm['phone']); ?></a>
                    <a href="#contact" class="btn btn-outline-light">Free Case Evaluation</a>
                </div>
            </div>
        </article>

        <aside class="sidebar sidebar-practice">
            <div class="sidebar-sticky">
                <?php roden_contact_form_sidebar(); ?>

                <!-- Back to Pillar -->
                <?php if ( $parent_post ) : ?>
                <div class="sidebar-widget">
                    <h3 class="widget-title">&#128203; Main Practice Area</h3>
                    <a href="<?php echo esc_url( $parent_url ); ?>" class="sidebar-back-link">&larr; <?php echo esc_html( $parent_title ); ?></a>
                </div>
                <?php endif; ?>

                <!-- Related Sub-Types -->
                <?php if ( $siblings ) : ?>
                <div class="sidebar-widget">
                    <h3 class="widget-title">Related Case Types</h3>
                    <ul class="sidebar-links">
                        <?php foreach ( $siblings as $sib ) : ?>
                            <li><a href="<?php echo esc_url( get_permalink( $sib ) ); ?>">&rarr; <?php echo esc_html( $sib->post_title ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Filing Deadlines -->
                <div class="sidebar-widget sidebar-deadlines">
                    <h3 class="widget-title">&#9201; Filing Deadlines</h3>
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

                <!-- Why Roden Law -->
                <div class="sidebar-widget sidebar-why-us">
                    <h3 class="widget-title">Why Roden Law?</h3>
                    <ul class="why-us-list">
                        <li>&#10003; <?php echo esc_html($firm['recovered']); ?> Recovered for Clients</li>
                        <li>&#10003; <?php echo esc_html($firm['rating']); ?>&#9733; Average Client Rating</li>
                        <li>&#10003; <?php echo esc_html($firm['cases_handled']); ?> Cases Successfully Handled</li>
                        <li>&#10003; No Fee Unless We Win</li>
                        <li>&#10003; Free 24/7 Consultations</li>
                        <li>&#10003; Licensed in GA &amp; SC</li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>
