<?php
/**
 * Generic Page Template
 * @package RodenLaw
 */
get_header();
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
    </div>
</section>

<?php get_footer(); ?>
