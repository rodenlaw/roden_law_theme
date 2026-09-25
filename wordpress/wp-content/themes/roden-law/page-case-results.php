<?php
/**
 * Template: Case Results Page (page-case-results.php)
 *
 * Automatically loaded for the /case-results/ page (slug match).
 *
 * This is the only place case results are published. Until 2026-09-25 each of
 * the 156 also had its own URL, /case-results/{slug}/ -- a page that was 84%
 * template around an amount, a result type and a one-phrase category, which
 * earned 2 clicks in 16 months while this page earned 21. They were folded in
 * here. Every result is rendered server-side under id="{slug}", and every old
 * single URL 301s to that anchor (roden_case_result_single_redirect()).
 *
 * The filters are progressive enhancement: the bar stays hidden and the full
 * list shows until the script in roden_case_results_filter_js() runs, so a
 * crawler or a no-JS visitor sees all 156.
 *
 * @package Roden_Law
 */

get_header();

$firm  = roden_firm_data();
$stats = $firm['trust_stats'];

$results = new WP_Query( array(
    'post_type'      => 'case_result',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'meta_value_num',
    'meta_key'       => '_roden_case_amount_raw',
    'order'          => 'DESC',
    'no_found_rows'  => true,
) );

/*
 * Amount bands, highest first. Bounds are inclusive lower, exclusive upper, in
 * whole dollars against _roden_case_amount_raw.
 */
$bands = array(
    '1m'   => array( 'label' => '$1M+',           'min' => 1000000, 'max' => PHP_INT_MAX ),
    '500k' => array( 'label' => '$500K – $999K',  'min' => 500000,  'max' => 1000000 ),
    '250k' => array( 'label' => '$250K – $499K',  'min' => 250000,  'max' => 500000 ),
    'u250' => array( 'label' => 'Under $250K',    'min' => 0,       'max' => 250000 ),
);

$items      = array();
$categories = array();
$types      = array();
$band_count = array_fill_keys( array_keys( $bands ), 0 );

foreach ( $results->posts as $cr ) {
    $raw      = (int) get_post_meta( $cr->ID, '_roden_case_amount_raw', true );
    $type     = trim( (string) get_post_meta( $cr->ID, '_roden_case_type', true ) );
    $category = roden_case_result_category( $cr->ID );
    $band     = '';
    foreach ( $bands as $key => $b ) {
        if ( $raw >= $b['min'] && $raw < $b['max'] ) {
            $band = $key;
            break;
        }
    }

    $items[] = array(
        'id'       => $cr->ID,
        'slug'     => $cr->post_name,
        'amount'   => get_post_meta( $cr->ID, '_roden_case_amount', true ),
        'type'     => $type,
        'category' => $category,
        'band'     => $band,
        'desc'     => get_post_meta( $cr->ID, '_roden_description', true ),
    );

    if ( $category ) {
        $categories[ $category ] = ( $categories[ $category ] ?? 0 ) + 1;
    }
    if ( $type ) {
        $types[ $type ] = ( $types[ $type ] ?? 0 ) + 1;
    }
    if ( $band ) {
        $band_count[ $band ]++;
    }
}
arsort( $categories );
arsort( $types );

$total = count( $items );
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
         ALL RESULTS — filterable
         ============================================================ -->
    <section class="section section-alt" id="all-results">
        <div class="site-container">
            <div class="section-header">
                <h2>Case Results</h2>
                <p>Settlements, verdicts, and recoveries our attorneys have secured, largest first.</p>
            </div>

            <?php if ( $items ) : ?>

            <div class="results-filter-bar" id="results-filter-bar" hidden>
                <div class="filter-group" role="group" aria-label="Filter by case type">
                    <span class="filter-label">Case type</span>
                    <button type="button" class="filter-btn active" data-filter="category" data-value="" aria-pressed="true">All</button>
                    <?php foreach ( $categories as $label => $n ) : ?>
                        <button type="button" class="filter-btn" data-filter="category" data-value="<?php echo esc_attr( $label ); ?>" aria-pressed="false">
                            <?php echo esc_html( $label ); ?> <span class="filter-count">(<?php echo (int) $n; ?>)</span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="filter-group" role="group" aria-label="Filter by result">
                    <span class="filter-label">Result</span>
                    <button type="button" class="filter-btn active" data-filter="type" data-value="" aria-pressed="true">All</button>
                    <?php foreach ( $types as $label => $n ) : ?>
                        <button type="button" class="filter-btn" data-filter="type" data-value="<?php echo esc_attr( $label ); ?>" aria-pressed="false">
                            <?php echo esc_html( $label ); ?> <span class="filter-count">(<?php echo (int) $n; ?>)</span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="filter-group" role="group" aria-label="Filter by amount">
                    <span class="filter-label">Amount</span>
                    <button type="button" class="filter-btn active" data-filter="band" data-value="" aria-pressed="true">All</button>
                    <?php foreach ( $bands as $key => $b ) :
                        if ( ! $band_count[ $key ] ) {
                            continue;
                        } ?>
                        <button type="button" class="filter-btn" data-filter="band" data-value="<?php echo esc_attr( $key ); ?>" aria-pressed="false">
                            <?php echo esc_html( $b['label'] ); ?> <span class="filter-count">(<?php echo (int) $band_count[ $key ]; ?>)</span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <p class="results-shown" id="results-shown" aria-live="polite">
                    Showing <?php echo (int) $total; ?> of <?php echo (int) $total; ?> results
                </p>
            </div>

            <ul class="case-results-grid cols-3 case-results-list" id="case-results-list">
                <?php foreach ( $items as $it ) : ?>
                    <li class="result-card" id="<?php echo esc_attr( $it['slug'] ); ?>"
                        data-category="<?php echo esc_attr( $it['category'] ); ?>"
                        data-type="<?php echo esc_attr( $it['type'] ); ?>"
                        data-band="<?php echo esc_attr( $it['band'] ); ?>">
                        <?php if ( $it['type'] ) : ?>
                            <span class="result-type"><?php echo esc_html( ucfirst( $it['type'] ) ); ?></span>
                        <?php endif; ?>
                        <span class="result-amount"><?php echo esc_html( $it['amount'] ); ?></span>
                        <?php if ( $it['category'] ) : ?>
                            <span class="result-title"><?php echo esc_html( $it['category'] ); ?></span>
                        <?php endif; ?>
                        <?php if ( $it['desc'] ) : ?>
                            <p class="result-desc"><?php echo esc_html( $it['desc'] ); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p class="no-results-msg" id="no-results-msg" hidden>No case results match these filters.</p>

            <?php endif; ?>
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
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"
                   class="btn btn-outline-white btn-lg">
                    Free Case Review
                </a>
            </div>
        </div>
    </section>

<?php get_footer(); ?>
