<?php
/**
 * Template Part: Hero — Practice Area (Pillar + Sub-Type)
 *
 * Expects variables from the calling template:
 *   $firm, $jurisdiction_label
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$firm = isset( $firm ) ? $firm : roden_firm_data();
$jurisdiction_label = isset( $jurisdiction_label ) ? $jurisdiction_label : 'Georgia & South Carolina';
?>
<section class="hero hero-practice-area">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">
            <div class="hero-content">
                <div class="speakable-hero" data-speakable="true">
                    <h1 class="hero-title"><?php the_title(); ?></h1>
                    <p class="hero-jurisdiction">&#9878; SERVING: <strong><?php echo esc_html( $jurisdiction_label ); ?></strong></p>
                </div>
                <div class="speakable-intro" data-speakable="true">
                    <?php if ( has_excerpt() ) : ?>
                        <p class="hero-subtitle"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                    <?php endif; ?>
                </div>

                <?php roden_stats_bar(); ?>

                <div class="hero-actions">
                    <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary btn-lg">&#128222; Call <?php echo esc_html( $firm['phone'] ); ?></a>
                    <a href="#contact" class="btn btn-outline-light btn-lg">Free Case Review</a>
                </div>
            </div>
            <div class="hero-form">
                <?php roden_contact_form_sidebar(); ?>
            </div>
        </div>
    </div>
</section>
