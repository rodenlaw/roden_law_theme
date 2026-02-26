<?php
/**
 * Search Results Template
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
            <?php printf( esc_html__( 'Search Results for: %s', 'roden-law' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?>
        </h1>
        <p class="hero-subtitle">
            <?php
            if ( have_posts() ) {
                printf( esc_html__( '%d results found', 'roden-law' ), (int) $wp_query->found_posts );
            } else {
                esc_html_e( 'No results found. Try a different search term.', 'roden-law' );
            }
            ?>
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

                <nav class="pagination" aria-label="Search results pagination">
                    <?php
                    the_posts_pagination( [
                        'mid_size'  => 2,
                        'prev_text' => '&larr; Previous',
                        'next_text' => 'Next &rarr;',
                    ] );
                    ?>
                </nav>
            <?php else : ?>
                <div class="no-results">
                    <h2>No Results Found</h2>
                    <p>Sorry, nothing matched your search. Here are some suggestions:</p>
                    <ul class="no-results-suggestions">
                        <li>Check your spelling or try different keywords</li>
                        <li>Try more general search terms</li>
                        <li>Browse our <a href="<?php echo esc_url( home_url( '/practice-areas/' ) ); ?>">practice areas</a></li>
                    </ul>
                    <div class="no-results-cta">
                        <p>Need help with a personal injury case?</p>
                        <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary"><?php echo esc_html( $firm['phone'] ); ?></a>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>#contact" class="btn btn-dark">Free Case Evaluation</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <aside class="sidebar sidebar-blog">
            <div class="sidebar-sticky">
                <div class="sidebar-widget sidebar-consult-cta">
                    <h3>Injured? Talk to a Lawyer.</h3>
                    <p>Free consultation. No fees unless we win.</p>
                    <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary btn-block"><?php echo esc_html( $firm['phone'] ); ?></a>
                    <a href="#contact" class="btn btn-outline-light btn-block">Free Case Evaluation</a>
                </div>

                <div class="sidebar-widget">
                    <h3 class="widget-title">Categories</h3>
                    <ul class="sidebar-links">
                        <?php
                        $cats = get_categories( [ 'hide_empty' => true ] );
                        foreach ( $cats as $cat ) {
                            echo '<li><a href="' . esc_url( get_category_link( $cat ) ) . '">' . esc_html( $cat->name ) . ' <span class="count">(' . $cat->count . ')</span></a></li>';
                        }
                        ?>
                    </ul>
                </div>

                <div class="sidebar-widget">
                    <h3 class="widget-title">Practice Areas</h3>
                    <?php
                    $pas = get_posts( [ 'post_type' => 'practice_area', 'posts_per_page' => 6, 'orderby' => 'menu_order', 'order' => 'ASC' ] );
                    echo '<ul class="sidebar-links">';
                    foreach ( $pas as $pa ) {
                        echo '<li><a href="' . esc_url( get_permalink( $pa ) ) . '">' . esc_html( $pa->post_title ) . '</a></li>';
                    }
                    echo '</ul>';
                    ?>
                </div>
            </div>
        </aside>

    </div>
</div>

<?php get_footer(); ?>
