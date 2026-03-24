<?php
/**
 * Template: Pillar Practice Area Page — 17-Section Layout
 *
 * Loaded by single-practice_area.php when $is_pillar is true.
 *
 * Expects these variables from the router:
 *   $firm, $post_id, $post, $jurisdiction, $jurisdiction_label,
 *   $sol_ga, $sol_sc, $sub_types, $author_id,
 *   $child_subtypes, $child_intersections,
 *   $hero_intro, $why_hire, $common_causes, $common_injuries
 *
 * @package RodenLaw
 */

// Author data (used in multiple sections)
$atty       = $author_id ? get_post( $author_id ) : null;
$atty_title = $atty ? get_post_meta( $atty->ID, '_roden_atty_title', true ) : '';
$atty_bar   = $atty ? get_post_meta( $atty->ID, '_roden_bar_admissions', true ) : '';

// Practice category for queries
$pa_terms = wp_get_object_terms( $post_id, 'practice_category', array( 'fields' => 'slugs' ) );
$cat_slug = ! empty( $pa_terms ) ? $pa_terms[0] : '';
?>

<!-- ═══════════════════════════════════════════════════════════════════════
     SECTION 1: HERO
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="hero hero-practice-area">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">
            <div class="hero-content">
                <div class="speakable-hero" data-speakable="true">
                    <h1 class="hero-title"><?php the_title(); ?></h1>
                    <p class="hero-jurisdiction">&#9878; Serving: <strong><?php echo esc_html( $jurisdiction_label ); ?></strong></p>
                </div>
                <div class="speakable-intro" data-speakable="true">
                    <?php if ( $hero_intro ) : ?>
                        <p class="hero-subtitle"><?php echo wp_kses_post( $hero_intro ); ?></p>
                    <?php elseif ( has_excerpt() ) : ?>
                        <p class="hero-subtitle"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                    <?php endif; ?>
                </div>

                <?php roden_stats_bar(); ?>

                <div class="hero-actions">
                    <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary btn-lg">&#128222; Call <?php echo esc_html( $firm['phone'] ); ?></a>
                </div>
            </div>
            <div class="hero-form">
                <?php roden_contact_form_sidebar(); ?>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════
     SECTION 2: TRUST BAR (Bar Association Badges)
     ═══════════════════════════════════════════════════════════════════════ -->
<div class="pa-trust-bar">
    <div class="container">
        <?php
        $badges = array(
            array( 'name' => 'State Bar of Georgia',           'abbr' => 'GA Bar' ),
            array( 'name' => 'American Association for Justice', 'abbr' => 'AAJ' ),
            array( 'name' => 'Georgia Trial Lawyers Association', 'abbr' => 'GTLA' ),
            array( 'name' => 'American Bar Association',       'abbr' => 'ABA' ),
        );
        foreach ( $badges as $badge ) :
            $badge_file = get_template_directory() . '/assets/images/badges/' . sanitize_title( $badge['abbr'] ) . '.svg';
            $has_image  = file_exists( $badge_file );
        ?>
            <div class="trust-badge">
                <?php if ( $has_image ) : ?>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/badges/' . sanitize_title( $badge['abbr'] ) . '.svg' ); ?>"
                         alt="<?php echo esc_attr( $badge['name'] ); ?> Member Badge"
                         width="32" height="32" loading="lazy">
                <?php else : ?>
                    <span class="trust-badge__icon">&#9878;</span>
                <?php endif; ?>
                <span class="trust-badge__name"><?php echo esc_html( $badge['name'] ); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════════════
     SECTION 3: LOCATION MATRIX
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="section-location-matrix">
    <div class="container">
        <h2 class="matrix-title">Our <?php the_title(); ?> Offices</h2>
        <div class="location-matrix-grid">
            <?php
            // Pre-build location page URL cache keyed by office key.
            $location_urls = array();
            $location_posts = get_posts( array(
                'post_type'      => 'location',
                'posts_per_page' => 10,
                'post_status'    => 'publish',
            ) );
            foreach ( $location_posts as $lp ) {
                $lp_key = get_post_meta( $lp->ID, '_roden_office_key', true );
                if ( $lp_key ) {
                    $location_urls[ $lp_key ] = get_permalink( $lp );
                }
            }

            foreach ( $firm['offices'] as $key => $office ) :
                $matrix_url    = '';
                $matrix_label  = '';

                // Prefer intersection page; fall back to location page.
                foreach ( $child_intersections as $ci ) {
                    if ( get_post_meta( $ci->ID, '_roden_pa_office_key', true ) === $key ) {
                        $matrix_url   = get_permalink( $ci );
                        $matrix_label = 'City Page';
                        break;
                    }
                }
                if ( ! $matrix_url && isset( $location_urls[ $key ] ) ) {
                    $matrix_url   = $location_urls[ $key ];
                    $matrix_label = 'Office';
                }
            ?>
                <div class="matrix-card">
                    <span class="matrix-state state-<?php echo esc_attr( strtolower( $office['state'] ) ); ?>"><?php echo esc_html( $office['state'] ); ?></span>
                    <h3 class="matrix-city">
                        <?php if ( $matrix_url ) : ?>
                            <a href="<?php echo esc_url( $matrix_url ); ?>"><?php echo esc_html( $office['market_name'] ); ?></a>
                        <?php else : ?>
                            <?php echo esc_html( $office['market_name'] ); ?>
                        <?php endif; ?>
                    </h3>
                    <span class="matrix-url">/<?php echo esc_html( $post->post_name ); ?>/<?php echo esc_html( $office['slug'] ); ?>/</span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════
     MAIN CONTENT + SIDEBAR WRAPPER
     ═══════════════════════════════════════════════════════════════════════ -->
<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <!-- MAIN CONTENT -->
        <article class="main-content">

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 4: WHY HIRE A [Practice Area] LAWYER?
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-why-hire">
                <h2>Why Hire <?php the_title(); ?>?</h2>
                <?php if ( $why_hire ) : ?>
                    <div class="pa-why-hire__body">
                        <?php echo apply_filters( 'the_content', $why_hire ); ?>
                    </div>
                <?php elseif ( get_the_content() ) : ?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
                <p>At Roden Law, our personal injury attorneys have helped numerous victims secure millions in compensation across Georgia and South Carolina. We provide all potential clients with a free, no-obligation review of their claim and do not charge upfront legal fees.</p>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 5: INLINE CTA BANNER (#1 of 3)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_inline_cta_banner(); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 6: TYPES OF CASES WE HANDLE (Sub-Types)
                 ═══════════════════════════════════════════════════════════ -->
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

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 7: STATUTE OF LIMITATIONS (GA vs SC)
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( $sol_ga || $sol_sc ) : ?>
                <div class="content-section">
                    <h2>Meeting the Statute of Limitations</h2>
                    <div class="sol-grid">
                        <?php if ( $sol_ga && in_array( $jurisdiction, array( 'both', 'ga', 'GA' ) ) ) : ?>
                            <div class="sol-card sol-ga">
                                <span class="sol-state">&#127825; Georgia Filing Deadline</span>
                                <span class="sol-years">2 Years</span>
                                <span class="sol-cite"><?php echo esc_html( $sol_ga ); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ( $sol_sc && in_array( $jurisdiction, array( 'both', 'sc', 'SC' ) ) ) : ?>
                            <div class="sol-card sol-sc">
                                <span class="sol-state">&#127769; South Carolina Filing Deadline</span>
                                <span class="sol-years">3 Years</span>
                                <span class="sol-cite"><?php echo esc_html( $sol_sc ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <p>If you fail to file within the statute of limitations, your claim will be dismissed and you will permanently lose the right to pursue compensation. You should not hesitate to consult with a skilled attorney to ensure your claim is filed on time.</p>
                </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 8: DO I HAVE A CASE? (4 Elements of Negligence)
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-elements-section">
                <h2>Do I Have a Case?</h2>
                <p>Before our attorneys can take legal action, we must prove the four elements of negligence existed in your accident:</p>
                <div class="pa-elements">
                    <?php
                    $elements = array(
                        array(
                            'num'   => '01',
                            'title' => 'Duty of Care',
                            'body'  => 'The other party owed you a duty of care and was obligated to act in a manner that ensured your safety and the safety of others.',
                        ),
                        array(
                            'num'   => '02',
                            'title' => 'Breach of Duty',
                            'body'  => 'The other party breached that duty by failing to act as a reasonably safe and prudent person would have in the same situation.',
                        ),
                        array(
                            'num'   => '03',
                            'title' => 'Causation',
                            'body'  => 'The at-fault party\'s conduct and the resulting accident directly caused your injuries. We gather evidence to prove that but for their negligence, you would not have been harmed.',
                        ),
                        array(
                            'num'   => '04',
                            'title' => 'Damages',
                            'body'  => 'You suffered actual, quantifiable damages — medical expenses, lost income, pain and suffering — as a direct result of the at-fault party\'s breach.',
                        ),
                    );
                    foreach ( $elements as $el ) : ?>
                        <div class="pa-element">
                            <div class="pa-element__num"><?php echo esc_html( $el['num'] ); ?></div>
                            <div class="pa-element__content">
                                <h3><?php echo esc_html( $el['title'] ); ?></h3>
                                <p><?php echo esc_html( $el['body'] ); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 9: COMPENSATION TYPES
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-compensation">
                <h2>Types of Compensation You Can Recover</h2>
                <div class="pa-compensation__grid">
                    <div class="pa-compensation__col">
                        <h3>Economic Damages</h3>
                        <ul>
                            <li>Past and future medical expenses</li>
                            <li>Lost wages or income</li>
                            <li>Loss of earning capacity</li>
                            <li>Property damage and vehicle repair/replacement</li>
                            <li>Cost of rehabilitation and physical therapy</li>
                            <li>Assistive medical equipment</li>
                            <li>Cost of long-term or lifelong care</li>
                        </ul>
                    </div>
                    <div class="pa-compensation__col">
                        <h3>Non-Economic Damages</h3>
                        <ul>
                            <li>Pain and suffering</li>
                            <li>Mental and emotional distress</li>
                            <li>Loss of companionship (spouse/family)</li>
                            <li>Disability and disfigurement</li>
                            <li>Loss of enjoyment of life</li>
                            <li>Humiliation or loss of reputation</li>
                        </ul>
                        <p class="pa-compensation__note"><em>Non-economic damages can only be pursued through a personal injury lawsuit, not a standard insurance claim.</em></p>
                    </div>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 10: COMPARATIVE FAULT (GA vs SC)
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-fault">
                <h2>Comparative Fault — What If I'm Partially At Fault?</h2>
                <div class="pa-fault__grid">
                    <div class="pa-fault__box pa-fault__box--ga">
                        <h3>&#127825; Georgia — Modified Comparative Fault</h3>
                        <p>You can recover if <strong>less than 50% at fault</strong> (O.C.G.A. &sect; 51-12-33). Your award is reduced by your fault percentage.</p>
                    </div>
                    <div class="pa-fault__box pa-fault__box--sc">
                        <h3>&#127769; South Carolina — Modified Comparative Fault</h3>
                        <p>You can recover if <strong>less than 51% at fault</strong>. Your award is reduced by your fault percentage.</p>
                    </div>
                </div>
                <p>For example, if you filed a $100,000 lawsuit and a court finds you are 30% at fault, your award would be reduced to $70,000. Our attorneys will work to minimize any fault assigned to you.</p>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 INLINE CTA BANNER (#2 of 3)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_inline_cta_banner(); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 11: COMMON CAUSES
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( ! empty( $common_causes ) ) : ?>
                <div class="content-section pa-common-list">
                    <h2>Common Causes of <?php the_title(); ?> Cases</h2>
                    <ul class="pa-two-col-list">
                        <?php foreach ( $common_causes as $cause ) : ?>
                            <li><?php echo esc_html( $cause ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 12: COMMON INJURIES
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( ! empty( $common_injuries ) ) : ?>
                <div class="content-section pa-injuries">
                    <h2>Common Injuries in <?php the_title(); ?> Cases</h2>
                    <div class="pa-injuries__list">
                        <?php foreach ( $common_injuries as $injury ) : ?>
                            <div class="pa-injury">
                                <strong class="pa-injury__name"><?php echo esc_html( $injury['name'] ); ?></strong>
                                <?php if ( ! empty( $injury['description'] ) ) : ?>
                                    <p class="pa-injury__desc"><?php echo esc_html( $injury['description'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 13: CASE RESULTS
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section">
                <h2>Recent Case Results</h2>
                <?php roden_case_results_grid( array( 'count' => 4, 'columns' => 3, 'practice_category' => $cat_slug ) ); ?>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 14: ABOUT THE AUTHOR (E-E-A-T)
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( $atty ) : ?>
                <div class="content-section author-attribution" id="author">
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
                            <?php if ( $atty_bar ) : ?>
                                <span class="author-bar"><?php echo esc_html( $atty_bar ); ?></span>
                            <?php endif; ?>
                            <?php if ( $atty->post_excerpt ) : ?>
                                <p class="author-bio"><?php echo wp_kses_post( $atty->post_excerpt ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 15: FAQ SECTION
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( $atty ) : ?>
                <p class="pa-faq-attribution">
                    Reviewed by <strong><?php echo esc_html( $atty->post_title ); ?></strong>,
                    <?php echo esc_html( $atty_title ); ?> — Licensed in Georgia &amp; South Carolina
                </p>
            <?php endif; ?>
            <?php roden_faq_section( $post_id ); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 INLINE CTA BANNER (#3 of 3)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_inline_cta_banner(); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 16: RELATED RESOURCES / BLOG LINKS
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $related_args = array(
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'post_status'    => 'publish',
            );

            // Try practice_category taxonomy first.
            $has_tax_filter = false;
            if ( $cat_slug ) {
                $related_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'practice_category',
                        'field'    => 'slug',
                        'terms'    => $cat_slug,
                    ),
                );
                $has_tax_filter = true;
            }

            // Fall back to WordPress category by mapping the PA slug to a blog category.
            if ( ! $has_tax_filter ) {
                $pa_to_blog_cat = array(
                    'car-accident-lawyers'              => 'car-accident',
                    'truck-accident-lawyers'             => 'truck-accident',
                    'motorcycle-accident-lawyers'        => 'personal-injury',
                    'slip-and-fall-lawyers'              => 'personal-injury',
                    'medical-malpractice-lawyers'        => 'medical-malpractice',
                    'wrongful-death-lawyers'             => 'personal-injury',
                    'workers-compensation-lawyers'       => 'workers-compensation',
                    'dog-bite-lawyers'                   => 'personal-injury',
                    'brain-injury-lawyers'               => 'personal-injury',
                    'spinal-cord-injury-lawyers'         => 'personal-injury',
                    'maritime-injury-lawyers'            => 'personal-injury',
                    'product-liability-lawyers'          => 'personal-injury',
                    'boating-accident-lawyers'           => 'personal-injury',
                    'burn-injury-lawyers'                => 'personal-injury',
                    'construction-accident-lawyers'      => 'workers-compensation',
                    'nursing-home-abuse-lawyers'         => 'nursing-home-abuse',
                    'premises-liability-lawyers'         => 'personal-injury',
                    'pedestrian-accident-lawyers'        => 'car-accident',
                    'bicycle-accident-lawyers'           => 'bicycle-accident',
                    'electric-scooter-accident-lawyers'  => 'personal-injury',
                    'atv-side-by-side-accident-lawyers'  => 'personal-injury',
                    'golf-cart-accident-lawyers'         => 'personal-injury',
                );
                $pa_slug   = $post->post_name;
                $blog_cat  = isset( $pa_to_blog_cat[ $pa_slug ] ) ? $pa_to_blog_cat[ $pa_slug ] : '';
                if ( $blog_cat ) {
                    $related_args['category_name'] = $blog_cat;
                }
            }

            $related_posts = new WP_Query( $related_args );
            if ( $related_posts->have_posts() ) : ?>
                <div class="content-section pa-resources">
                    <h2>Related Resources</h2>
                    <div class="pa-resources__grid">
                        <?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="resource-link">
                                <span class="resource-link__title"><?php the_title(); ?></span>
                                <span class="resource-link__arrow">&rarr;</span>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php
                wp_reset_postdata();
            endif;
            ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 16b: RELATED GUIDES (Resource CPT)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $resource_args = array(
                'post_type'      => 'resource',
                'posts_per_page' => 4,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            if ( $cat_slug ) {
                $resource_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'practice_category',
                        'field'    => 'slug',
                        'terms'    => $cat_slug,
                    ),
                );
            }
            $resource_posts = new WP_Query( $resource_args );
            if ( $resource_posts->have_posts() ) : ?>
                <div class="content-section pa-guides">
                    <h2>Related Guides &amp; Legal Resources</h2>
                    <div class="pa-resources__grid">
                        <?php while ( $resource_posts->have_posts() ) : $resource_posts->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="resource-link">
                                <span class="resource-link__title"><?php the_title(); ?></span>
                                <span class="resource-link__arrow">&rarr;</span>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php
                wp_reset_postdata();
            endif;
            ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 17: BOTTOM CTA BLOCK
                 ═══════════════════════════════════════════════════════════ -->
            <div class="bottom-cta-box">
                <h2>Contact Our <?php the_title(); ?> Today</h2>
                <p>If you were injured and believe another party is at fault, contact us for a free, no-obligation review. We dedicate our skills and resources to recovering the maximum compensation you deserve — at no upfront cost.</p>
                <div class="cta-actions">
                    <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary">&#128222; Call <?php echo esc_html( $firm['phone'] ); ?></a>
                    <a href="#contact" class="btn btn-outline-light">Free Case Evaluation</a>
                </div>
            </div>

        </article>

        <!-- ═══════════════════════════════════════════════════════════════
             SIDEBAR (Sticky on Desktop)
             ═══════════════════════════════════════════════════════════════ -->
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
                    $related_pas = get_posts( array(
                        'post_type'      => 'practice_area',
                        'posts_per_page' => 7,
                        'exclude'        => array( $post_id ),
                        'post_parent'    => 0,
                        'orderby'        => 'rand',
                    ) );
                    if ( $related_pas ) :
                        echo '<ul class="sidebar-links">';
                        foreach ( $related_pas as $r ) {
                            echo '<li><a href="' . esc_url( get_permalink( $r ) ) . '">&rarr; ' . esc_html( $r->post_title ) . '</a></li>';
                        }
                        echo '</ul>';
                    endif;
                    ?>
                </div>

                <!-- Why Roden Law -->
                <div class="sidebar-widget sidebar-why-us">
                    <h3 class="widget-title">Why Roden Law?</h3>
                    <ul class="why-us-list">
                        <li>&#10003; <?php echo esc_html( $firm['recovered'] ); ?> Recovered for Clients</li>
                        <li>&#10003; <?php echo esc_html( $firm['rating'] ); ?>&#9733; Average Client Rating</li>
                        <li>&#10003; <?php echo esc_html( $firm['cases_handled'] ); ?> Cases Successfully Handled</li>
                        <li>&#10003; No Fee Unless We Win</li>
                        <li>&#10003; Free 24/7 Consultations</li>
                        <li>&#10003; Licensed in GA &amp; SC</li>
                    </ul>
                </div>
            </div>
        </aside>

    </div>
</div>

