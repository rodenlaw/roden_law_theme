<?php
/**
 * Blog Home Template (Posts Page)
 *
 * WordPress loads home.php for the blog posts page (Settings > Reading > Posts page)
 * and for the rewrite-driven Spanish hub /es/blog/ (both resolve as is_home).
 * All user-facing strings are locale-branched on $is_es.
 *
 * @package RodenLaw
 */

get_header();
if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}
$firm  = roden_firm_data();
$is_es = function_exists( 'roden_current_lang' ) && 'es' === roden_current_lang();
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
                printf( $is_es ? 'Resultados de Búsqueda: %s' : 'Search Results: %s', get_search_query() );
            } else {
                echo $is_es ? 'Blog de Roden Law' : 'Roden Law Blog';
            }
            ?>
        </h1>
        <p class="hero-subtitle">
            <?php echo $is_es
                ? 'Consejos legales, noticias de accidentes y recursos sobre lesiones personales para residentes de Georgia y Carolina del Sur — escritos por abogados licenciados.'
                : 'Legal insights, accident news, and injury law resources for Georgia and South Carolina residents — written by licensed personal injury attorneys.'; ?>
        </p>
        <?php if ( ! $is_es ) : // Search queries resolve English-only; hide the box on /es/blog/. ?>
        <div class="blog-search">
            <?php get_search_form(); ?>
        </div>
        <?php endif; ?>
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

                <nav class="pagination" aria-label="<?php echo esc_attr( $is_es ? 'Paginación del blog' : 'Blog pagination' ); ?>">
                    <?php
                    the_posts_pagination( [
                        'mid_size'  => 2,
                        'prev_text' => $is_es ? '← Anterior' : '← Previous',
                        'next_text' => $is_es ? 'Siguiente →' : 'Next →',
                    ] );
                    ?>
                </nav>
            <?php else : ?>
                <div class="no-results">
                    <p><?php echo $is_es
                        ? 'No se encontraron artículos.'
                        : 'No articles found. Try a different search term or category.'; ?></p>
                </div>
            <?php endif; ?>
        </div>

        <aside class="sidebar sidebar-blog">
            <div class="sidebar-sticky">
                <div class="sidebar-widget sidebar-consult-cta">
                    <h3><?php echo $is_es ? '¿Lesionado? Hable con un Abogado.' : 'Injured? Talk to a Lawyer.'; ?></h3>
                    <p><?php echo $is_es ? 'Consulta gratuita. No paga honorarios a menos que ganemos.' : 'Free consultation. No fees unless we win.'; ?></p>
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary btn-block"><?php echo esc_html($firm['phone']); ?></a>
                    <a href="<?php echo esc_url( roden_lang_home_url( null, '/contact/' ) ); ?>" class="btn btn-outline-light btn-block"><?php echo $is_es ? 'Evaluación Gratuita de Su Caso' : 'Free Case Review'; ?></a>
                </div>

                <?php if ( ! $is_es ) : // Categories are English-only taxonomy archives. ?>
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
                <?php endif; ?>

                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php echo $is_es ? 'Áreas de Práctica' : 'Practice Areas'; ?></h3>
                    <?php
                    // Locale-filter so ES pillars never leak into the EN sidebar
                    // (and the ES hub links Spanish pillars, not English ones).
                    $pa_args = [
                        'post_type'      => 'practice_area',
                        'posts_per_page' => 6,
                        'orderby'        => 'menu_order',
                        'order'          => 'ASC',
                        'post_parent'    => 0,
                    ];
                    if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
                        $pa_args['meta_query'] = $is_es
                            ? [ [ 'key' => '_roden_locale', 'value' => 'es' ] ]
                            : roden_es_exclusion_meta_query();
                    }
                    $pas = get_posts( $pa_args );
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
