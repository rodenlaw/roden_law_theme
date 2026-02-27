<?php
/**
 * Archive: Case Results — Results Showcase
 *
 * Displays case results in a grid, sorted by amount descending.
 * Includes trust stats, disclaimer, and a bottom CTA.
 *
 * @package Roden_Law
 */

get_header();

$firm = roden_firm_data();
?>

<section class="hero hero-archive hero-case-results-archive">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <h1 class="hero-title"><?php esc_html_e( 'Case Results', 'roden-law' ); ?></h1>
        <p class="hero-subtitle">
            <?php esc_html_e( 'Our track record speaks for itself. Roden Law has recovered', 'roden-law' ); ?>
            <strong><?php echo esc_html( $firm['trust_stats']['recovered'] ); ?></strong>
            <?php esc_html_e( 'for personal injury victims across Georgia and South Carolina.', 'roden-law' ); ?>
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php roden_stats_bar(); ?>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <?php roden_case_results_grid( array( 'count' => 20, 'columns' => 4 ) ); ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="results-disclaimer-box">
            <h3><?php esc_html_e( 'Important Disclaimer', 'roden-law' ); ?></h3>
            <p><?php esc_html_e( 'Case "value," "results," and/or "maximum compensation" is determined from the total settlement amount. The settlement amounts shown are gross numbers before attorney\'s fees and cost deductions. The % fees will be computed before deducting expenses and costs from the gross settlement. Each case is unique, and the examples shown are just that, examples of past results. Past results do not guarantee or suggest recovery in your specific case.', 'roden-law' ); ?></p>
        </div>
    </div>
</section>

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
