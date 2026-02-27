<?php
/**
 * Single Resource Template
 *
 * Resource pages (guides, state law explainers, what-to-do articles).
 * Content with sidebar, author attribution (E-E-A-T), reading time,
 * related practice areas, and filing deadlines.
 *
 * @package Roden_Law
 */

get_header();

$firm      = roden_firm_data();
$post_id   = get_the_ID();
$author_id = get_post_meta( $post_id, '_roden_author_attorney', true );
$atty      = $author_id ? get_post( $author_id ) : null;
$atty_title = $atty ? get_post_meta( $atty->ID, '_roden_atty_title', true ) : '';
?>

<section class="hero hero-resource">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <h1 class="hero-title"><?php the_title(); ?></h1>
        <div class="post-meta-bar">
            <?php if ( $atty ) : ?>
                <div class="post-author">
                    <div class="post-author-photo">
                        <?php if ( has_post_thumbnail( $atty ) ) : ?>
                            <?php echo get_the_post_thumbnail( $atty, 'thumbnail' ); ?>
                        <?php endif; ?>
                    </div>
                    <div class="post-author-info">
                        <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>" class="post-author-name"><?php echo esc_html( $atty->post_title ); ?></a>
                        <span class="post-author-title"><?php echo esc_html( $atty_title ); ?></span>
                    </div>
                </div>
            <?php endif; ?>
            <span class="post-date"><?php echo esc_html( get_the_date() ); ?></span>
            <span class="post-read-time"><?php echo (int) roden_reading_time(); ?> min read</span>
        </div>
    </div>
</section>

<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <article class="main-content entry-content">
            <?php if ( has_post_thumbnail() ) : ?>
                <figure class="post-featured-image">
                    <?php the_post_thumbnail( 'large' ); ?>
                </figure>
            <?php endif; ?>

            <?php the_content(); ?>

            <?php roden_inline_cta_banner(); ?>

            <?php roden_faq_section( $post_id ); ?>

            <?php roden_author_attribution( $post_id ); ?>
        </article>

        <aside class="sidebar sidebar-resource">
            <div class="sidebar-sticky">
                <?php roden_contact_form_sidebar(); ?>

                <?php roden_filing_deadlines_sidebar(); ?>

                <?php roden_related_practice_areas( 6 ); ?>

                <?php roden_why_roden_sidebar(); ?>
            </div>
        </aside>

    </div>
</div>

<?php get_footer(); ?>
