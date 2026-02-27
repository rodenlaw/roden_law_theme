<?php
/**
 * Template Part: Blog Post Card — Used in archives and blog listings
 *
 * Renders a single blog post card with thumbnail, date, reading time,
 * title, excerpt, and author attribution.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$reading_time = roden_reading_time();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-card' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" class="blog-card-thumb">
            <?php the_post_thumbnail( 'card-thumb', array( 'loading' => 'lazy' ) ); ?>
        </a>
    <?php endif; ?>

    <div class="blog-card-body">
        <div class="blog-card-meta">
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
            <span class="meta-sep">&middot;</span>
            <span class="reading-time"><?php echo (int) $reading_time; ?> min read</span>
            <?php
            $categories = get_the_category();
            if ( ! empty( $categories ) ) :
            ?>
                <span class="meta-sep">&middot;</span>
                <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="blog-card-cat">
                    <?php echo esc_html( $categories[0]->name ); ?>
                </a>
            <?php endif; ?>
        </div>

        <h3 class="blog-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <?php if ( has_excerpt() ) : ?>
            <p class="blog-card-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
        <?php else : ?>
            <p class="blog-card-excerpt"><?php echo esc_html( wp_trim_words( get_the_content(), 20 ) ); ?></p>
        <?php endif; ?>

        <div class="blog-card-footer">
            <?php
            $author_atty_id = get_post_meta( get_the_ID(), '_roden_author_attorney', true );
            if ( $author_atty_id ) :
                $atty = get_post( $author_atty_id );
                if ( $atty ) :
            ?>
                <span class="blog-card-author">
                    By <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>"><?php echo esc_html( $atty->post_title ); ?></a>
                </span>
            <?php endif; endif; ?>
            <a href="<?php the_permalink(); ?>" class="blog-card-link">Read More &rarr;</a>
        </div>
    </div>
</article>
