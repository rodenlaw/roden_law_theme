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
                    Personal Injury Lawyer<br>
                    <span class="text-accent">in <?php echo esc_html( $office['city'] . ', ' . $office['state'] ); ?></span>
                </h1>
                <p class="hero-subtitle">
                    Roden Law's <?php echo esc_html( $office['city'] ); ?> personal injury attorneys have recovered <strong><?php echo esc_html( $stats['recovered'] ); ?></strong> for injury victims across <?php echo esc_html( $service_area ); ?> No fees unless we win.
                </p>

                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['recovered'] ); ?></span>
                        <span class="stat-label">Recovered for Clients</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['rating'] ); ?>&#9733;</span>
                        <span class="stat-label">Client Rating</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['cases'] ); ?></span>
                        <span class="stat-label">Cases Handled</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?php echo esc_html( $stats['experience'] ); ?> Yrs</span>
                        <span class="stat-label">Combined Experience</span>
                    </div>
                </div>

                <div class="hero-ctas">
                    <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary btn-lg">
                        Call <?php echo esc_html( $office['phone'] ); ?>
                    </a>
                    <a href="#free-case-review" class="btn btn-outline-light btn-lg">Free Case Review</a>
                </div>
            </div>

            <div class="hero-form" id="free-case-review">
                <?php roden_contact_form_sidebar( $office['phone'] ); ?>
            </div>

        </div>
    </div>
</section>
