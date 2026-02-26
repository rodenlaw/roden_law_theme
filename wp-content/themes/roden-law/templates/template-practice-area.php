<?php
/**
 * Template: Pillar Practice Area Page
 *
 * Loaded by single-practice_area.php when $is_pillar is true.
 *
 * Expects these variables from the router:
 *   $firm, $post_id, $post, $jurisdiction, $jurisdiction_label,
 *   $sol_ga, $sol_sc, $sub_types, $author_id,
 *   $child_subtypes, $child_intersections
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
                <div class="speakable-intro" data-speakable="true">
                    <?php if ( has_excerpt() ) : ?>
                        <p class="hero-subtitle"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                    <?php endif; ?>
                </div>

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

<!-- LOCATION MATRIX — links to actual intersection pages -->
<section class="section-location-matrix">
    <div class="container">
        <h2 class="matrix-title">Our <?php the_title(); ?> Offices</h2>
        <div class="location-matrix-grid">
            <?php foreach ( $firm['offices'] as $key => $office ) :
                $city_slug = strtolower( str_replace( ' ', '-', $office['city'] ) ) . '-' . strtolower( $office['state'] );
                // Check if intersection page exists
                $intersection_exists = false;
                $intersection_url = '#';
                foreach ( $child_intersections as $ci ) {
                    if ( get_post_meta( $ci->ID, '_roden_pa_office_key', true ) === $key ) {
                        $intersection_url = get_permalink( $ci );
                        $intersection_exists = true;
                        break;
                    }
                }
            ?>
                <div class="matrix-card">
                    <span class="matrix-state state-<?php echo esc_attr(strtolower($office['state'])); ?>"><?php echo esc_html($office['state']); ?></span>
                    <h3 class="matrix-city">
                        <?php if ( $intersection_exists ) : ?>
                            <a href="<?php echo esc_url( $intersection_url ); ?>"><?php echo esc_html( $office['city'] ); ?></a>
                        <?php else : ?>
                            <?php echo esc_html( $office['city'] ); ?>
                        <?php endif; ?>
                    </h3>
                    <span class="matrix-url">/<?php echo esc_html( $post->post_name ); ?>/<?php echo esc_html($city_slug); ?>/</span>
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

            <!-- Sub-Types — from CPT children OR from meta field -->
            <?php if ( $child_subtypes || $sub_types ) : ?>
                <div class="content-section">
                    <h2>Types of <?php the_title(); ?> Cases We Handle</h2>
                    <div class="sub-types-grid">
                        <?php if ( $child_subtypes ) : ?>
                            <?php foreach ( $child_subtypes as $cst ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $cst ) ); ?>" class="sub-type-card sub-type-link">
                                    <span class="st-name"><?php echo esc_html( $cst->post_title ); ?></span>
                                    <span class="st-arrow">&rarr;</span>
                                </a>
                            <?php endforeach; ?>
                        <?php elseif ( $sub_types ) : ?>
                            <?php foreach ( $sub_types as $st ) : ?>
                                <div class="sub-type-card">
                                    <span class="st-name"><?php echo esc_html( $st ); ?></span>
                                    <span class="st-arrow">&rarr;</span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

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
                    <p>If you fail to file within the statute of limitations, your claim will be dismissed and you will permanently lose the right to pursue compensation. Consult with a skilled attorney to ensure your claim is filed on time.</p>
                </div>
            <?php endif; ?>

            <?php roden_inline_cta_banner(); ?>

            <!-- Case Results -->
            <div class="content-section">
                <h2>Recent Case Results</h2>
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
                    <h2>About the Author</h2>
                    <div class="author-card">
                        <div class="author-photo">
                            <?php if ( has_post_thumbnail( $atty ) ) : ?>
                                <?php echo get_the_post_thumbnail( $atty, 'thumbnail' ); ?>
                            <?php else : ?>
                                <div class="author-photo-placeholder">&#128100;</div>
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
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary">&#128222; Call <?php echo esc_html($firm['phone']); ?></a>
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

                <!-- Related Practice Areas -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Related Practice Areas</h3>
                    <?php
                    $related = get_posts( [ 'post_type' => 'practice_area', 'posts_per_page' => 7, 'exclude' => [$post_id], 'post_parent' => 0, 'orderby' => 'rand' ] );
                    if ( $related ) :
                        echo '<ul class="sidebar-links">';
                        foreach ( $related as $r ) {
                            echo '<li><a href="' . esc_url(get_permalink($r)) . '">&rarr; ' . esc_html($r->post_title) . '</a></li>';
                        }
                        echo '</ul>';
                    endif;
                    ?>
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
