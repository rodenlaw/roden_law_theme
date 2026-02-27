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
                        <a href="<?php echo esc_url($avvo_url); ?>" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">Avvo Profile</a>
                    <?php endif; ?>
                    <?php if ( $linkedin ) : ?>
                        <a href="<?php echo esc_url($linkedin); ?>" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">LinkedIn</a>
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
                    <span class="attorney-hero-office">&#128205; <?php echo esc_html($office['city'] . ', ' . $office['state']); ?> — <?php echo esc_html($office['phone']); ?></span>
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

                <div class="hero-actions">
                    <?php if ( $office ) : ?>
                        <a href="tel:<?php echo esc_attr($office['phone_e164']); ?>" class="btn btn-primary btn-lg">&#128222; <?php echo esc_html($office['phone']); ?></a>
                    <?php endif; ?>
                    <a href="#contact" class="btn btn-outline-light btn-lg">Free Consultation</a>
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
                        <a href="tel:<?php echo esc_attr($office['phone_e164']); ?>" class="btn btn-primary btn-block"><?php echo esc_html($office['phone']); ?></a>
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
