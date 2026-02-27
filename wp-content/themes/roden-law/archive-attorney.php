<?php
/**
 * Archive: Attorneys — Team Page
 *
 * Displays all attorneys in a grid layout, grouped conceptually
 * by office. Includes firm trust stats and a bottom CTA.
 *
 * @package Roden_Law
 */

get_header();

$firm = roden_firm_data();
?>

<section class="hero hero-archive">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <h1 class="hero-title"><?php esc_html_e( 'Our Attorneys', 'roden-law' ); ?></h1>
        <p class="hero-subtitle">
            <?php esc_html_e( 'Meet the experienced personal injury attorneys at Roden Law. Licensed in Georgia and South Carolina, our team has recovered', 'roden-law' ); ?>
            <strong><?php echo esc_html( $firm['trust_stats']['recovered'] ); ?></strong>
            <?php esc_html_e( 'for injured clients across 5 office locations.', 'roden-law' ); ?>
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
        <div class="section-header">
            <h2><?php esc_html_e( 'Meet the Team', 'roden-law' ); ?></h2>
        </div>
        <?php roden_attorneys_grid( array( 'columns' => 4 ) ); ?>
    </div>
</section>

<?php
// Attorneys by office
foreach ( $firm['offices'] as $key => $office ) :
    $has_attorneys = new WP_Query( array(
        'post_type'      => 'attorney',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array( 'key' => '_roden_atty_office_key', 'value' => $key ),
        ),
    ) );

    if ( ! $has_attorneys->have_posts() ) {
        wp_reset_postdata();
        continue;
    }
    wp_reset_postdata();
?>
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2><?php echo esc_html( $office['city'] . ', ' . $office['state'] ); ?> Attorneys</h2>
            </div>
            <?php roden_attorneys_grid( array( 'office_key' => $key, 'columns' => 3 ) ); ?>
        </div>
    </section>
<?php endforeach; ?>

<section class="section bg-navy cta-bottom">
    <div class="container text-center">
        <h2 class="text-white"><?php esc_html_e( 'Schedule a Free Consultation', 'roden-law' ); ?></h2>
        <p class="text-white" style="opacity:0.85; max-width:600px; margin:0 auto var(--space-xl);">
            <?php esc_html_e( 'Speak directly with one of our experienced personal injury attorneys. No fees unless we win.', 'roden-law' ); ?>
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
