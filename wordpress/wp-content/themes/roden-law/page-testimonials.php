<?php
/**
 * Template: Testimonials Page (page-testimonials.php)
 *
 * Loaded for the /testimonials/ page (slug match, page 1895). The URL belonged
 * to the testimonial post-type archive until 2026-11-02, which shadowed this
 * template completely; the CPT now registers 'has_archive' => false (single
 * testimonial URLs keep their /testimonials/<slug>/ rewrite).
 *
 * Renders the page content, then every published testimonial in full on one
 * page, then the firm-wide Google review count with a link to each office's
 * Google Business Profile.
 *
 * Deliberately absent:
 * - No third-party review widget. The Trustindex shortcode that used to sit
 *   here printed as raw text: the plugin is not installed and the firm has no
 *   account (owner decision, 2026-11-02).
 * - No star glyphs, no AggregateRating and no Review markup. Testimonials carry
 *   no rating, and self-serving review markup was removed sitewide on
 *   2026-10-22 (inc/schema-helpers.php).
 * - No links to the single testimonial pages. They are noindexed and out of
 *   the sitemap; this page shows each quote in full instead.
 *
 * @package Roden_Law
 */

get_header();

$firm = roden_firm_data();

if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}

// Every published testimonial, newest first (same order as the homepage block).
$roden_testimonials = get_posts( array(
    'post_type'        => 'testimonial',
    'post_status'      => 'publish',
    'posts_per_page'   => -1,
    'orderby'          => 'date',
    'order'            => 'DESC',
    'no_found_rows'    => true,
    'suppress_filters' => false,
) );

// Testimonial bodies were pasted from email, Canva and review sites and carry
// spans, divs and data-* attributes. Keep paragraphs and basic emphasis only.
$roden_quote_tags = array(
    'p'      => array(),
    'br'     => array(),
    'em'     => array(),
    'strong' => array(),
);

// Offices with a Google Business Profile that has reviews on it. An office
// whose profile has none (review_count 0) is not offered as "our reviews".
$roden_review_offices = array();
foreach ( $firm['offices'] as $office_key => $office ) {
    if ( empty( $office['gbp_url'] ) || empty( $office['review_count'] ) ) {
        continue;
    }
    $roden_review_offices[ $office_key ] = $office;
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

    <?php if ( $roden_testimonials ) : ?>
    <section class="section section-alt testimonials-page" aria-labelledby="testimonials-list-heading">
        <div class="site-container">
            <h2 id="testimonials-list-heading" class="section-title"><?php esc_html_e( 'In Their Own Words', 'roden-law' ); ?></h2>

            <ul class="testimonials-list">
                <?php foreach ( $roden_testimonials as $roden_t ) :
                    $roden_quote = wp_kses( wpautop( wptexturize( $roden_t->post_content ) ), $roden_quote_tags );
                    $roden_quote = trim( preg_replace( '#<p>(?:\s|&nbsp;|<br\s*/?>)*</p>#i', '', $roden_quote ) );
                    if ( '' === $roden_quote ) {
                        continue;
                    }
                    $roden_where = get_post_meta( $roden_t->ID, '_roden_testimonial_location', true );
                ?>
                    <li class="testimonial-item">
                        <figure class="testimonial-figure">
                            <blockquote class="testimonial-quote">
                                <?php echo $roden_quote; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_kses above. ?>
                            </blockquote>
                            <figcaption class="testimonial-attribution">
                                <?php
                                echo esc_html( get_the_title( $roden_t ) );
                                if ( $roden_where ) {
                                    echo ', ' . esc_html( $roden_where );
                                }
                                ?>
                            </figcaption>
                        </figure>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p class="testimonials-disclaimer"><?php esc_html_e( 'Testimonials reflect individual experiences and do not guarantee similar outcomes. No clients were paid for endorsements unless otherwise disclosed.', 'roden-law' ); ?> <?php esc_html_e( 'Past results do not guarantee a similar outcome in your case.', 'roden-law' ); ?></p>
        </div>
    </section>
    <?php endif; ?>

    <section class="section google-reviews" aria-labelledby="google-reviews-heading">
        <div class="site-container">
            <h2 id="google-reviews-heading" class="section-title"><?php printf( /* translators: %d: rounded live Google review count, e.g. 170. */ esc_html__( '%d+ Verified Google Reviews', 'roden-law' ), (int) $firm['trust_stats']['review_count_rounded'] ); ?></h2>

            <?php if ( $roden_review_offices ) : ?>
                <ul class="google-review-links">
                    <?php foreach ( $roden_review_offices as $office ) :
                        $roden_office_label = ! empty( $office['market_name'] ) ? $office['market_name'] : $office['city'];
                    ?>
                        <li>
                            <a href="<?php echo esc_url( $office['gbp_url'] ); ?>"><?php
                                printf(
                                    /* translators: %s: office name, e.g. Savannah. */
                                    esc_html__( 'Read our %s reviews on Google', 'roden-law' ),
                                    esc_html( $roden_office_label )
                                );
                            ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
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
