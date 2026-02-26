<?php
/**
 * Blog Index / Archive Template
 *
 * @package RodenLaw
 */

get_header();
if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}
$firm = roden_firm_data();
?>

<section class="hero hero-blog">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <h1 class="hero-title">
            <?php
            if ( is_category() ) {
                single_cat_title();
            } elseif ( is_tag() ) {
                single_tag_title();
            } elseif ( is_tax() ) {
                single_term_title();
            } elseif ( is_search() ) {
                printf( 'Search Results: %s', get_search_query() );
            } else {
                echo 'Roden Law Blog';
            }
            ?>
        </h1>
        <p class="hero-subtitle">
            Legal insights, accident news, and injury law resources for Georgia and South Carolina residents — written by licensed personal injury attorneys.
        </p>
        <div class="blog-search">
            <?php get_search_form(); ?>
        </div>
    </div>
</section>

<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <div class="main-content">
            <?php if ( have_posts() ) : ?>
                <div class="blog-grid">
                    <?php while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/content', 'card' );
                    endwhile; ?>
                </div>

                <nav class="pagination" aria-label="Blog pagination">
                    <?php
                    the_posts_pagination( [
                        'mid_size'  => 2,
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                    ] );
                    ?>
                </nav>
            <?php else : ?>
                <div class="no-results">
                    <p>No articles found. Try a different search term or category.</p>
                </div>
            <?php endif; ?>
        </div>

        <aside class="sidebar sidebar-blog">
            <div class="sidebar-sticky">
                <div class="sidebar-widget sidebar-consult-cta">
                    <h3>Injured? Talk to a Lawyer.</h3>
                    <p>Free consultation. No fees unless we win.</p>
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary btn-block"><?php echo esc_html($firm['phone']); ?></a>
                    <a href="#contact" class="btn btn-outline-light btn-block">Free Case Evaluation</a>
                </div>

                <div class="sidebar-widget">
                    <h3 class="widget-title">Categories</h3>
                    <ul class="sidebar-links">
                        <?php
                        $cats = get_categories(['hide_empty'=>true]);
                        foreach ( $cats as $cat ) {
                            echo '<li><a href="' . esc_url(get_category_link($cat)) . '">' . esc_html($cat->name) . ' <span class="count">(' . $cat->count . ')</span></a></li>';
                        }
                        ?>
                    </ul>
                </div>

                <div class="sidebar-widget">
                    <h3 class="widget-title">Practice Areas</h3>
                    <?php
                    $pas = get_posts(['post_type'=>'practice_area','posts_per_page'=>6,'orderby'=>'menu_order','order'=>'ASC']);
                    echo '<ul class="sidebar-links">';
                    foreach ( $pas as $pa ) {
                        echo '<li><a href="' . esc_url(get_permalink($pa)) . '">' . esc_html($pa->post_title) . '</a></li>';
                    }
                    echo '</ul>';
                    ?>
                </div>
            </div>
        </aside>

    </div>
</div>

<?php get_footer(); ?>
