<?php
/**
 * Template part: Blog Post Card
 *
 * @package RodenLaw
 */

$author_id  = get_post_meta( get_the_ID(), '_roden_author_attorney', true );
$atty       = $author_id ? get_post( $author_id ) : null;
$atty_title = $atty ? get_post_meta( $atty->ID, '_roden_atty_title', true ) : '';
$categories = get_the_category();
$cat_name   = ! empty($categories) ? $categories[0]->name : '';
?>

<article class="blog-card" id="post-<?php the_ID(); ?>">
    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" class="blog-card-image">
            <?php the_post_thumbnail( 'card-thumb' ); ?>
            <?php if ( $cat_name ) : ?>
                <span class="blog-card-tag"><?php echo esc_html($cat_name); ?></span>
            <?php endif; ?>
        </a>
    <?php else : ?>
        <a href="<?php the_permalink(); ?>" class="blog-card-image blog-card-image-placeholder">
            <span class="placeholder-icon">⚖</span>
            <?php if ( $cat_name ) : ?>
                <span class="blog-card-tag"><?php echo esc_html($cat_name); ?></span>
            <?php endif; ?>
        </a>
    <?php endif; ?>

    <div class="blog-card-body">
        <div class="blog-card-meta">
            <?php if ( $cat_name ) : ?>
                <span class="blog-card-category"><?php echo esc_html($cat_name); ?></span>
                <span class="meta-sep">•</span>
            <?php endif; ?>
            <span class="blog-card-date"><?php echo get_the_date(); ?></span>
        </div>

        <h2 class="blog-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <p class="blog-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>

        <div class="blog-card-footer">
            <?php if ( $atty ) : ?>
                <div class="blog-card-author">
                    <span class="author-avatar">👤</span>
                    <div class="author-meta">
                        <span class="author-name"><?php echo esc_html($atty->post_title); ?></span>
                        <span class="author-title"><?php echo esc_html($atty_title); ?></span>
                    </div>
                </div>
            <?php endif; ?>
            <a href="<?php the_permalink(); ?>" class="read-more-link">Read More →</a>
        </div>
    </div>
</article>
