<?php
/**
 * Template: Case Results Page (page-case-results.php)
 *
 * Automatically loaded for the /case-results/ page (slug match).
 * Hero, featured result, results grid, stats bar, disclaimer, bottom CTA.
 *
 * @package Roden_Law
 */

get_header();

$firm  = roden_firm_data();
$stats = $firm['trust_stats'];

/* ------------------------------------------------------------------
   Featured Result — highest _roden_case_amount_raw
   ------------------------------------------------------------------ */

$featured_query = new WP_Query( array(
    'post_type'      => 'case_result',
    'posts_per_page' => 1,
    'orderby'        => 'meta_value_num',
    'meta_key'       => '_roden_case_amount_raw',
    'order'          => 'DESC',
) );

$featured_id     = 0;
$featured_amount = '';
$featured_type   = '';
$featured_title  = '';
$featured_desc   = '';

if ( $featured_query->have_posts() ) {
    $featured_query->the_post();
    $featured_id     = get_the_ID();
    $featured_amount = get_post_meta( $featured_id, '_roden_case_amount', true );
    $featured_type   = get_post_meta( $featured_id, '_roden_case_type', true );
    $featured_title  = get_the_title();
    $featured_desc   = get_post_meta( $featured_id, '_roden_description', true );
    wp_reset_postdata();
}

// Fallback if no CPT posts exist yet
if ( ! $featured_id ) {
    $featured_amount = '$27,000,000';
    $featured_type   = 'Settlement';
    $featured_title  = 'Truck Accident';
    $featured_desc   = 'Client paralyzed in collision with commercial semi-truck.';
}
?>

    <!-- ============================================================
         HERO
         ============================================================ -->
    <section class="hero hero-page">
        <div class="site-container">
            <?php roden_breadcrumb_html(); ?>
            <h1 class="hero-title">Our Results Speak for Themselves</h1>
            <p class="hero-subtitle">
                Roden Law has recovered <strong><?php echo esc_html( $stats['recovered'] ); ?></strong>
                for injured clients across Georgia and South Carolina.
                These case results reflect our commitment to fighting for maximum compensation.
            </p>
        </div>
    </section>

    <!-- ============================================================
         FEATURED RESULT
         ============================================================ -->
    <section class="section featured-result-section">
        <div class="site-container">
            <div class="featured-result-card">
                <span class="featured-result-label">Featured Result</span>
                <span class="featured-result-amount"><?php echo esc_html( $featured_amount ); ?></span>
                <div class="featured-result-meta">
                    <?php if ( $featured_type ) : ?>
                        <span class="featured-result-type"><?php echo esc_html( ucfirst( $featured_type ) ); ?></span>
                    <?php endif; ?>
                    <span class="featured-result-title"><?php echo esc_html( $featured_title ); ?></span>
                </div>
                <?php if ( $featured_desc ) : ?>
                    <p class="featured-result-desc"><?php echo esc_html( $featured_desc ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ============================================================
         RESULTS GRID
         ============================================================ -->
    <section class="section section-alt" id="all-results">
        <div class="site-container">
            <div class="section-header">
                <h2>Case Results</h2>
                <p>Settlements, verdicts, and recoveries our attorneys have secured.</p>
            </div>

            <?php
            roden_case_results_grid( array(
                'count'   => 20,
                'columns' => 3,
                'exclude' => $featured_id ? array( $featured_id ) : array(),
            ) );
            ?>
        </div>
    </section>

    <!-- ============================================================
         STATS BAR
         ============================================================ -->
    <section class="roden-section--stat-bar">
        <div class="site-container">
            <?php roden_stats_bar(); ?>
        </div>
    </section>

    <!-- ============================================================
         DISCLAIMER
         ============================================================ -->
    <section class="section">
        <div class="site-container">
            <div class="results-disclaimer-box">
                <h3>Important Disclaimer</h3>
                <p>
                    The results shown on this page are gross settlement, verdict, and recovery amounts
                    before deduction of attorney fees and litigation costs. Every case is unique, and
                    past results do not guarantee a similar outcome. The amount recovered in any case
                    depends on the specific facts, injuries, and applicable law. Roden Law evaluates
                    every case on its individual merits and provides honest assessments of potential value.
                </p>
            </div>
        </div>
    </section>

    <!-- ============================================================
         BOTTOM CTA
         ============================================================ -->
    <section class="section bg-navy cta-bottom">
        <div class="site-container text-center">
            <h2 class="text-white">Injured? Let Us Fight for You</h2>
            <p class="text-white" style="opacity:0.85; max-width:600px; margin:0 auto var(--space-xl);">
                No fees unless we win. Free consultations available 24/7 across Georgia and South Carolina.
            </p>
            <div class="hero-ctas" style="justify-content:center;">
                <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>"
                   class="btn btn-primary btn-lg">
                    Call <?php echo esc_html( $firm['vanity_phone'] ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( '/free-case-review/' ) ); ?>"
                   class="btn btn-outline-white btn-lg">
                    Free Case Review
                </a>
            </div>
        </div>
    </section>

<?php get_footer(); ?>
