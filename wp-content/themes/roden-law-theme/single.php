<?php
/**
 * Single Blog Post Template
 *
 * Article schema with attorney author attribution (E-E-A-T).
 *
 * @package RodenLaw
 */

get_header();
$firm      = roden_firm_data();
$post_id   = get_the_ID();
$author_id = get_post_meta( $post_id, '_roden_author_attorney', true );
$atty      = $author_id ? get_post( $author_id ) : null;
$atty_title = $atty ? get_post_meta( $atty->ID, '_roden_atty_title', true ) : '';
?>

<section class="hero hero-blog-single">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <h1 class="hero-title"><?php the_title(); ?></h1>
        <div class="post-meta-bar">
            <?php if ( $atty ) : ?>
                <div class="post-author">
                    <div class="post-author-photo">
                        <?php if ( has_post_thumbnail( $atty ) ) : ?>
                            <?php echo get_the_post_thumbnail( $atty, 'thumbnail' ); ?>
                        <?php else : ?>
                            <span class="author-placeholder">👤</span>
                        <?php endif; ?>
                    </div>
                    <div class="post-author-info">
                        <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>" class="post-author-name"><?php echo esc_html($atty->post_title); ?></a>
                        <span class="post-author-title"><?php echo esc_html($atty_title); ?></span>
                    </div>
                </div>
            <?php endif; ?>
            <span class="post-date"><?php echo get_the_date(); ?></span>
            <span class="post-read-time"><?php echo roden_reading_time(); ?> min read</span>
        </div>
    </div>
</section>

<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <article class="main-content entry-content" id="post-<?php the_ID(); ?>">
            <?php if ( has_post_thumbnail() ) : ?>
                <figure class="post-featured-image">
                    <?php the_post_thumbnail( 'large' ); ?>
                </figure>
            <?php endif; ?>

            <?php the_content(); ?>

            <?php roden_inline_cta_banner(); ?>

            <?php roden_faq_section( $post_id ); ?>

            <!-- Author Box -->
            <?php if ( $atty ) : ?>
                <div class="author-attribution">
                    <h3>About the Author</h3>
                    <div class="author-card">
                        <div class="author-photo">
                            <?php if ( has_post_thumbnail( $atty ) ) : ?>
                                <?php echo get_the_post_thumbnail( $atty, 'thumbnail' ); ?>
                            <?php else : ?>
                                <div class="author-photo-placeholder">👤</div>
                            <?php endif; ?>
                        </div>
                        <div class="author-info">
                            <h4><a href="<?php echo esc_url(get_permalink($atty)); ?>"><?php echo esc_html($atty->post_title); ?></a></h4>
                            <span class="author-title"><?php echo esc_html($atty_title); ?></span>
                            <?php if ( $atty->post_excerpt ) : ?>
                                <p><?php echo wp_kses_post($atty->post_excerpt); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Post Navigation -->
            <nav class="post-nav" aria-label="Post navigation">
                <div class="post-nav-links">
                    <?php
                    $prev = get_previous_post();
                    $next = get_next_post();
                    if ( $prev ) :
                        echo '<a href="' . esc_url(get_permalink($prev)) . '" class="post-nav-link post-nav-prev"><span class="nav-label">← Previous</span><span class="nav-title">' . esc_html($prev->post_title) . '</span></a>';
                    endif;
                    if ( $next ) :
                        echo '<a href="' . esc_url(get_permalink($next)) . '" class="post-nav-link post-nav-next"><span class="nav-label">Next →</span><span class="nav-title">' . esc_html($next->post_title) . '</span></a>';
                    endif;
                    ?>
                </div>
            </nav>
        </article>

        <aside class="sidebar sidebar-blog">
            <div class="sidebar-sticky">
                <!-- CTA -->
                <div class="sidebar-widget sidebar-consult-cta">
                    <h3>Injured? Talk to a Lawyer.</h3>
                    <p>Free consultation. No fees unless we win.</p>
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary btn-block">📞 <?php echo esc_html($firm['phone']); ?></a>
                    <a href="#contact" class="btn btn-outline-light btn-block">Free Case Evaluation</a>
                </div>

                <!-- Categories -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Categories</h3>
                    <ul class="sidebar-links">
                        <?php
                        $cats = get_terms(['taxonomy'=>'practice_category','hide_empty'=>true]);
                        foreach ( $cats as $cat ) {
                            echo '<li><a href="' . esc_url(get_term_link($cat)) . '">→ ' . esc_html($cat->name) . ' <span class="count">(' . $cat->count . ')</span></a></li>';
                        }
                        ?>
                    </ul>
                </div>

                <!-- Recent Posts -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Recent Posts</h3>
                    <ul class="sidebar-posts">
                        <?php
                        $recent = get_posts(['posts_per_page'=>5,'exclude'=>[$post_id]]);
                        foreach ( $recent as $r ) :
                        ?>
                            <li>
                                <a href="<?php echo esc_url(get_permalink($r)); ?>">
                                    <span class="sidebar-post-title"><?php echo esc_html($r->post_title); ?></span>
                                    <span class="sidebar-post-date"><?php echo get_the_date('', $r); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Practice Areas -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Practice Areas</h3>
                    <?php
                    $pas = get_posts(['post_type'=>'practice_area','posts_per_page'=>6,'orderby'=>'menu_order','order'=>'ASC']);
                    echo '<ul class="sidebar-links">';
                    foreach ( $pas as $pa ) {
                        echo '<li><a href="' . esc_url(get_permalink($pa)) . '">→ ' . esc_html($pa->post_title) . '</a></li>';
                    }
                    echo '</ul>';
                    ?>
                </div>
            </div>
        </aside>

    </div>
</div>

<?php get_footer(); ?>

<?php
/**
 * Estimated reading time
 */
function roden_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( wp_strip_all_tags( $content ) );
    return max( 1, ceil( $word_count / 250 ) );
}
