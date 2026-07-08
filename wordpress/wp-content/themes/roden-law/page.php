<?php
/**
 * Generic Page Template
 * @package RodenLaw
 */
get_header();
if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}
?>

<section class="hero hero-page">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <h1 class="hero-title"><?php the_title(); ?></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <article class="entry-content page-content">
            <?php
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
            ?>
        </article>
        <?php
        // Class-action tort pages: visible FAQ accordion pairing with the
        // FAQPage JSON-LD from schema-helpers.php (Google requires the
        // marked-up Q&A to be visible on the page). Renders nothing until
        // _roden_faqs is populated.
        if ( function_exists( 'roden_class_action_page_type' ) && roden_class_action_page_type() ) {
            roden_faq_section();
        }
        ?>
    </div>
</section>

<?php get_footer(); ?>
