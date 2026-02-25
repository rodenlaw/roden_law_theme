<?php
/**
 * Archive Template — handles practice_area, location, attorney, case_result, resource archives
 *
 * @package RodenLaw
 */

get_header();
if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}
$firm = roden_firm_data();
$post_type = get_post_type();
?>

<section class="hero hero-archive">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <h1 class="hero-title"><?php post_type_archive_title(); ?></h1>
        <?php if ( get_the_archive_description() ) : ?>
            <div class="hero-subtitle"><?php the_archive_description(); ?></div>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if ( have_posts() ) : ?>

            <?php if ( $post_type === 'practice_area' ) : ?>
                <?php roden_practice_areas_grid( 4 ); ?>

            <?php elseif ( $post_type === 'attorney' ) : ?>
                <?php roden_attorneys_grid( [ 'columns' => 4 ] ); ?>

            <?php elseif ( $post_type === 'location' ) : ?>
                <?php roden_location_cards(); ?>

            <?php elseif ( $post_type === 'case_result' ) : ?>
                <?php roden_case_results_grid( [ 'count' => 12, 'columns' => 4 ] ); ?>

            <?php else : ?>
                <div class="blog-grid">
                    <?php while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/content', 'card' );
                    endwhile; ?>
                </div>
                <nav class="pagination">
                    <?php the_posts_pagination( [ 'mid_size' => 2, 'prev_text' => '← Previous', 'next_text' => 'Next →' ] ); ?>
                </nav>
            <?php endif; ?>

        <?php else : ?>
            <p>No content found.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
