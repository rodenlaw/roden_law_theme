<?php
/**
 * Template: Testimonials Page (page-testimonials.php)
 *
 * Automatically loaded for the /testimonials/ page (slug match).
 * Renders page content followed by Google Reviews via Trustindex plugin.
 *
 * @package Roden_Law
 */

get_header();

$firm = roden_firm_data();

if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}
?>

    <section class="hero hero-page">
        <div class="site-container">
            <?php roden_breadcrumb_html(); ?>
            <h1 class="hero-title"><?php the_title(); ?></h1>
        </div>
    </section>

    <section class="section">
        <div class="site-container">
            <article class="entry-content page-content">
                <?php
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile;
                ?>
            </article>
        </div>
    </section>

    <!-- Google Reviews via Trustindex -->
    <section class="section section-alt">
        <div class="site-container">
            <?php echo do_shortcode( '[trustindex data-widget-id="8d903e043e59816ac5166169ae1"]' ); ?>
        </div>
    </section>

    <!-- Bottom CTA -->
    <section class="section bg-navy cta-bottom">
        <div class="site-container text-center">
            <h2 class="text-white"><?php esc_html_e( 'Injured? Get Your Free Case Review Today.', 'roden-law' ); ?></h2>
            <p class="text-white" style="opacity:0.85; max-width:600px; margin:0 auto var(--space-xl);">
                <?php esc_html_e( 'No fees unless we win. Available 24/7 across Georgia and South Carolina.', 'roden-law' ); ?>
            </p>
            <div class="hero-ctas" style="justify-content:center;">
                <a href="tel:<?php echo esc_attr( $firm['phone_raw'] ); ?>"
                   class="btn btn-primary btn-lg">
                    <?php
                    printf(
                        esc_html__( 'Call %s', 'roden-law' ),
                        esc_html( $firm['vanity_phone'] )
                    );
                    ?>
                </a>
            </div>
        </div>
    </section>

<?php get_footer(); ?>
