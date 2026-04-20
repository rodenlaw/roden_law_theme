<?php
/**
 * Template: Attorney Bio Page
 *
 * Loaded by single-attorney.php.
 *
 * Expects these variables from the router:
 *   $firm, $post_id, $title, $office_key, $office,
 *   $bar_items, $edu_items, $award_items, $avvo_url, $linkedin
 *
 * @package RodenLaw
 */
?>

<!-- HERO -->
<section class="hero hero-attorney">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="attorney-hero-grid">

            <!-- Photo Column -->
            <div class="attorney-photo-col">
                <div class="attorney-hero-photo">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'attorney-portrait', ['alt' => get_the_title() . ' — ' . ($title ?: 'Attorney') . ' at Roden Law'] ); ?>
                    <?php else : ?>
                        <div class="attorney-photo-placeholder">&#128100;</div>
                    <?php endif; ?>
                </div>
                <div class="attorney-profile-links">
                    <?php if ( $avvo_url ) : ?>
                        <a href="<?php echo esc_url($avvo_url); ?>" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer nofollow">Avvo Profile</a>
                    <?php endif; ?>
                    <?php if ( $linkedin ) : ?>
                        <a href="<?php echo esc_url($linkedin); ?>" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer nofollow">LinkedIn</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Bio Column -->
            <div class="attorney-bio-col">
                <h1 class="hero-title"><?php the_title(); ?></h1>
                <?php if ( $title ) : ?>
                    <span class="attorney-hero-title"><?php echo esc_html($title); ?></span>
                <?php endif; ?>
                <?php if ( $office ) : ?>
                    <span class="attorney-hero-office">&#128205; <?php echo esc_html($office['market_name'] . ', ' . $office['state']); ?> — <?php echo esc_html($firm['vanity_phone']); ?></span>
                <?php endif; ?>

                <!-- Bar admission badges -->
                <div class="bar-badges">
                    <?php foreach ( $bar_items as $bar ) :
                        $parts = array_map('trim', explode(' — ', $bar));
                    ?>
                        <span class="bar-badge">Licensed: <?php echo esc_html($parts[0]); ?></span>
                    <?php endforeach; ?>
                </div>

                <div class="attorney-hero-bio">
                    <?php if ( has_excerpt() ) : ?>
                        <p><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                    <?php endif; ?>
                </div>

                <?php roden_last_updated_date( $post_id ); ?>

                <div class="hero-actions">
                    <?php if ( $office ) : ?>
                        <a href="tel:<?php echo esc_attr($firm['phone_raw']); ?>" class="btn btn-primary btn-lg">&#128222; <?php echo esc_html($firm['vanity_phone']); ?></a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- MAIN + SIDEBAR -->
<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <article class="main-content">

            <h2>About <?php the_title(); ?></h2>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 EXPERT QUOTE (AI-citable — +30% visibility)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $atty_quote = get_post_meta( $post_id, '_roden_expert_quote', true );
            if ( $atty_quote ) : ?>
                <blockquote class="expert-quote-block" data-ai-extractable="true" itemscope itemtype="https://schema.org/Quotation">
                    <p itemprop="text">&ldquo;<?php echo wp_kses_post( $atty_quote ); ?>&rdquo;</p>
                    <footer>
                        <cite itemscope itemtype="https://schema.org/Person">
                            &mdash; <span itemprop="name"><?php the_title(); ?></span>,
                            <?php if ( $title ) : ?>
                                <span itemprop="jobTitle"><?php echo esc_html( $title ); ?></span>,
                            <?php endif; ?>
                            <span itemprop="worksFor" itemscope itemtype="https://schema.org/LegalService">
                                <span itemprop="name">Roden Law</span>
                            </span>
                        </cite>
                    </footer>
                </blockquote>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 PRACTICE AREA SPECIALIZATIONS (GEO: topical authority)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            // Find practice areas where this attorney is the assigned author
            $attorney_pas = get_posts( array(
                'post_type'      => 'practice_area',
                'posts_per_page' => 20,
                'post_parent'    => 0,
                'meta_key'       => '_roden_author_attorney',
                'meta_value'     => $post_id,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ) );
            if ( $attorney_pas ) : ?>
                <div class="content-section attorney-specializations" data-ai-extractable="true">
                    <h2><?php the_title(); ?>&rsquo;s Practice Areas</h2>
                    <p><?php the_title(); ?> focuses on the following areas of personal injury law, serving clients across <?php echo $office ? esc_html( $office['state_full'] ) : 'Georgia and South Carolina'; ?>:</p>
                    <div class="specialization-grid">
                        <?php foreach ( $attorney_pas as $pa ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $pa ) ); ?>" class="specialization-card">
                                <span class="spec-name"><?php echo esc_html( $pa->post_title ); ?></span>
                                <span class="spec-arrow">&rarr;</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 EXPERIENCE & RESULTS NARRATIVE (E-E-A-T depth)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $firm = roden_firm_data();
            $years_experience = get_post_meta( $post_id, '_roden_years_experience', true );
            ?>
            <div class="content-section attorney-experience" data-ai-extractable="true">
                <h2>Experience &amp; Track Record</h2>
                <div class="experience-stats">
                    <?php if ( $years_experience ) : ?>
                        <div class="exp-stat">
                            <span class="exp-stat__num"><?php echo esc_html( $years_experience ); ?>+</span>
                            <span class="exp-stat__label">Years of Experience</span>
                        </div>
                    <?php endif; ?>
                    <div class="exp-stat">
                        <span class="exp-stat__num"><?php echo esc_html( $firm['recovered'] ); ?></span>
                        <span class="exp-stat__label">Recovered (Firm Total)</span>
                    </div>
                    <div class="exp-stat">
                        <span class="exp-stat__num"><?php echo esc_html( $firm['rating'] ); ?>&#9733;</span>
                        <span class="exp-stat__label">Client Rating</span>
                    </div>
                </div>
                <p><?php the_title(); ?> and the Roden Law team have recovered over <?php echo esc_html( $firm['recovered'] ); ?> for injured clients across Georgia and South Carolina. <?php if ( $office ) : ?>Based in <?php echo esc_html( $office['market_name'] ); ?>, <?php the_title(); ?> regularly appears before the <?php echo esc_html( $office['court'] ); ?> and is deeply familiar with local procedures and judges.<?php endif; ?></p>
            </div>

            <!-- Education -->
            <?php if ( $edu_items ) : ?>
                <div class="credential-section">
                    <h3 class="credential-heading">Education</h3>
                    <ul class="credential-list">
                        <?php foreach ( $edu_items as $item ) : ?>
                            <li><span class="check">&#10003;</span> <?php echo esc_html($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Bar Admissions -->
            <?php if ( $bar_items ) : ?>
                <div class="credential-section">
                    <h3 class="credential-heading">Bar Admissions</h3>
                    <ul class="credential-list">
                        <?php foreach ( $bar_items as $bar ) :
                            $parts = array_map('trim', explode(' — ', $bar));
                        ?>
                            <li><span class="check">&#10003;</span> <?php echo esc_html($bar); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Awards -->
            <?php if ( $award_items ) : ?>
                <div class="credential-section">
                    <h3 class="credential-heading">Awards &amp; Recognition</h3>
                    <ul class="credential-list">
                        <?php foreach ( $award_items as $award ) : ?>
                            <li><span class="check">&#10003;</span> <?php echo esc_html($award); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Award Badges -->
            <?php if ( ! empty( $badge_items ) ) : ?>
                <div class="credential-section attorney-badge-section">
                    <div class="attorney-badge-grid">
                        <?php foreach ( $badge_items as $badge ) : ?>
                            <div class="attorney-badge-item">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $badge['image'] ); ?>" alt="<?php echo esc_attr( $badge['alt'] ); ?>" loading="lazy" width="150" height="150">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Case Results -->
            <div class="content-section">
                <h2>Notable Results</h2>
                <?php roden_case_results_grid( [ 'count' => 4, 'columns' => 2 ] ); ?>
            </div>

            <!-- Team Grid -->
            <div class="content-section">
                <h2>Meet the Team</h2>
                <?php roden_attorneys_grid( [ 'columns' => 4 ] ); ?>
            </div>

        </article>

        <!-- SIDEBAR -->
        <aside class="sidebar sidebar-attorney">
            <div class="sidebar-sticky">
                <div class="sidebar-widget sidebar-consult-cta">
                    <h3 class="widget-title">Schedule a Consultation</h3>
                    <p>Speak directly with <?php the_title(); ?>. Free &amp; confidential.</p>
                    <?php if ( $office ) : ?>
                        <a href="tel:<?php echo esc_attr($firm['phone_raw']); ?>" class="btn btn-primary btn-block"><?php echo esc_html($firm['vanity_phone']); ?></a>
                    <?php endif; ?>
                    <a href="#contact" class="btn btn-outline-light btn-block">Case Review Form</a>
                </div>

                <div class="sidebar-widget">
                    <h3 class="widget-title">Jurisdiction</h3>
                    <p><?php the_title(); ?> is licensed to practice in:</p>
                    <div class="jurisdiction-badges">
                        <?php foreach ( $bar_items as $bar ) :
                            $parts = array_map('trim', explode(' — ', $bar));
                        ?>
                            <span class="jurisdiction-badge"><?php echo esc_html($parts[0]); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </aside>

    </div>
</div>
