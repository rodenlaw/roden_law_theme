<?php
/**
 * Archive: Case Results — Results Showcase
 *
 * Hero → Featured top result → 3-column grid → stats bar →
 * disclaimer → bottom CTA.
 *
 * @package Roden_Law
 */

get_header();

$firm = roden_firm_data();

/* ── Fetch the top result by amount for the featured callout ─────────── */
$top_query = new WP_Query( array(
    'post_type'      => 'case_result',
    'posts_per_page' => 1,
    'orderby'        => 'meta_value_num',
    'meta_key'       => '_roden_case_amount_raw',
    'order'          => 'DESC',
) );

$has_featured = $top_query->have_posts();
$featured_id  = 0;

if ( $has_featured ) {
    $top_query->the_post();
    $featured_id     = get_the_ID();
    $featured_amount = get_post_meta( $featured_id, '_roden_case_amount', true );
    $featured_type   = get_post_meta( $featured_id, '_roden_case_type', true );
    $featured_desc   = get_post_meta( $featured_id, '_roden_description', true );
    $featured_title  = get_the_title();
    wp_reset_postdata();
}
?>

<!-- ── Hero ────────────────────────────────────────────────────────────── -->
<section class="hero hero-archive hero-case-results-archive">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <h1 class="hero-title"><?php esc_html_e( 'Our Results Speak for Themselves', 'roden-law' ); ?></h1>
        <p class="hero-subtitle">
            <?php esc_html_e( 'Roden Law has recovered', 'roden-law' ); ?>
            <strong><?php echo esc_html( $firm['trust_stats']['recovered'] ); ?></strong>
            <?php esc_html_e( 'for personal injury victims across Georgia and South Carolina.', 'roden-law' ); ?>
        </p>
    </div>
</section>

<?php if ( $has_featured ) : ?>
<!-- ── Featured Result ────────────────────────────────────────────────── -->
<section class="section featured-result-section">
    <div class="container">
        <div class="featured-result-card">
            <span class="featured-result-label"><?php esc_html_e( 'Top Result', 'roden-law' ); ?></span>
            <span class="featured-result-amount"><?php echo esc_html( $featured_amount ); ?></span>
            <div class="featured-result-meta">
                <span class="featured-result-type"><?php echo esc_html( ucfirst( $featured_type ) ); ?></span>
                <span class="featured-result-sep">&mdash;</span>
                <span class="featured-result-title"><?php echo esc_html( $featured_title ); ?></span>
            </div>
            <?php if ( $featured_desc ) : ?>
                <p class="featured-result-desc"><?php echo esc_html( $featured_desc ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ── Results Grid (excludes featured) ───────────────────────────────── -->
<section class="section section-alt">
    <div class="container">
        <h2 class="section-title text-center"><?php esc_html_e( 'More Notable Results', 'roden-law' ); ?></h2>
        <?php
        roden_case_results_grid( array(
            'count'   => 20,
            'columns' => 3,
            'exclude' => $featured_id ? array( $featured_id ) : array(),
        ) );
        ?>
    </div>
</section>

<!-- ── Trust Stats Bar ────────────────────────────────────────────────── -->
<section class="section">
    <div class="container">
        <?php roden_stats_bar(); ?>
    </div>
</section>

<!-- ── Disclaimer ─────────────────────────────────────────────────────── -->
<section class="section section-alt">
    <div class="container">
        <div class="results-disclaimer-box">
            <h3><?php esc_html_e( 'Important Disclaimer', 'roden-law' ); ?></h3>
            <p><?php esc_html_e( 'Case "value," "results," and/or "maximum compensation" is determined from the total settlement amount. The settlement amounts shown are gross numbers before attorney\'s fees and cost deductions. The % fees will be computed before deducting expenses and costs from the gross settlement. Each case is unique, and the examples shown are just that, examples of past results. Past results do not guarantee or suggest recovery in your specific case.', 'roden-law' ); ?></p>
        </div>
    </div>
</section>

<!-- ── Bottom CTA ─────────────────────────────────────────────────────── -->
<section class="section bg-navy cta-bottom">
    <div class="container text-center">
        <h2 class="text-white"><?php esc_html_e( 'Injured? Let Us Fight for You.', 'roden-law' ); ?></h2>
        <p class="text-white" style="opacity:0.85; max-width:600px; margin:0 auto var(--space-xl);">
            <?php esc_html_e( 'No fees unless we win. Free consultations available 24/7.', 'roden-law' ); ?>
        </p>
        <div class="hero-ctas" style="justify-content:center;">
            <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary btn-lg">
                <?php printf( esc_html__( 'Call %s', 'roden-law' ), esc_html( $firm['vanity_phone'] ) ); ?>
            </a>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>#free-case-review" class="btn btn-outline-white btn-lg">
                <?php esc_html_e( 'Free Case Review', 'roden-law' ); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
