<?php
/**
 * Template Part: Hero — Location Page
 *
 * Expects variables from the calling template:
 *   $firm, $office, $office_key, $service_area, $stats
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$firm         = isset( $firm ) ? $firm : roden_firm_data();
$stats        = isset( $stats ) ? $stats : $firm['trust_stats'];
$office       = isset( $office ) ? $office : array();
$service_area = isset( $service_area ) ? $service_area : '';

if ( empty( $office ) ) {
    return;
}
?>
<section class="hero hero-location">
    <div class="hero-bg-overlay"></div>
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">

            <div class="hero-content">
                <span class="state-badge state-<?php echo esc_attr( strtolower( $office['state'] ) ); ?>">
                    <?php echo esc_html( $office['state_full'] ); ?>
                </span>
                <h1 class="hero-title">
                    <?php esc_html_e( 'Personal Injury Lawyer', 'roden-law' ); ?><br>
                    <span class="text-accent"><?php printf( /* translators: %s: city + state, e.g. "Savannah, GA". */ esc_html__( 'in %s', 'roden-law' ), esc_html( $office['market_name'] . ', ' . $office['state'] ) ); ?></span>
                </h1>
                <p class="hero-subtitle">
                    <?php
                    printf(
                        /* translators: 1: city/market name; 2: amount recovered wrapped in <strong>; 3: service area sentence (ends with a period). */
                        esc_html__( 'Roden Law\'s %1$s personal injury attorneys have recovered %2$s for injury victims across %3$s No fees unless we win.', 'roden-law' ),
                        esc_html( $office['market_name'] ),
                        '<strong>' . esc_html( $stats['recovered'] ) . '</strong>',
                        esc_html( $service_area )
                    );
                    ?>
                </p>

                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['recovered'] ); ?></span>
                        <span class="stat-label"><?php esc_html_e( 'Recovered for Clients', 'roden-law' ); ?></span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['rating'] ); ?>&#9733;</span>
                        <span class="stat-label"><?php esc_html_e( 'Client Rating', 'roden-law' ); ?></span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['cases'] ); ?></span>
                        <span class="stat-label"><?php esc_html_e( 'Cases Handled', 'roden-law' ); ?></span>
                    </div>
                </div>

                <div class="hero-ctas">
                    <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary btn-lg">
                        <?php printf( /* translators: %s: phone number. */ esc_html__( 'Call %s', 'roden-law' ), esc_html( $office['phone'] ) ); ?>
                    </a>
                </div>
            </div>

            <div class="hero-form" id="free-case-review">
                <?php roden_contact_form_sidebar( $office['phone'] ); ?>
            </div>

        </div>
    </div>
</section>
