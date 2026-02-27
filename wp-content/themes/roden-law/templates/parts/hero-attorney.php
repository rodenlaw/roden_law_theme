<?php
/**
 * Template Part: Hero — Attorney Bio Page
 *
 * Expects variables from the calling template:
 *   $firm, $title, $office, $bar_items, $avvo_url, $linkedin
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$firm      = isset( $firm ) ? $firm : roden_firm_data();
$title     = isset( $title ) ? $title : '';
$office    = isset( $office ) ? $office : null;
$bar_items = isset( $bar_items ) ? $bar_items : array();
$avvo_url  = isset( $avvo_url ) ? $avvo_url : '';
$linkedin  = isset( $linkedin ) ? $linkedin : '';
?>
<section class="hero hero-attorney">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="attorney-hero-grid">

            <div class="attorney-photo-col">
                <div class="attorney-hero-photo">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'attorney-portrait', array( 'alt' => get_the_title() . ' — ' . ( $title ?: 'Attorney' ) . ' at Roden Law' ) ); ?>
                    <?php else : ?>
                        <div class="attorney-photo-placeholder">&#128100;</div>
                    <?php endif; ?>
                </div>
                <div class="attorney-profile-links">
                    <?php if ( $avvo_url ) : ?>
                        <a href="<?php echo esc_url( $avvo_url ); ?>" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">Avvo Profile</a>
                    <?php endif; ?>
                    <?php if ( $linkedin ) : ?>
                        <a href="<?php echo esc_url( $linkedin ); ?>" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="attorney-bio-col">
                <h1 class="hero-title"><?php the_title(); ?></h1>
                <?php if ( $title ) : ?>
                    <span class="attorney-hero-title"><?php echo esc_html( $title ); ?></span>
                <?php endif; ?>
                <?php if ( $office ) : ?>
                    <span class="attorney-hero-office">&#128205; <?php echo esc_html( $office['city'] . ', ' . $office['state'] ); ?> — <?php echo esc_html( $office['phone'] ); ?></span>
                <?php endif; ?>

                <div class="bar-badges">
                    <?php foreach ( $bar_items as $bar ) :
                        $parts = array_map( 'trim', explode( '|', $bar ) );
                    ?>
                        <span class="bar-badge">Licensed: <?php echo esc_html( $parts[1] ?? $parts[0] ); ?></span>
                    <?php endforeach; ?>
                </div>

                <div class="attorney-hero-bio">
                    <?php if ( has_excerpt() ) : ?>
                        <p><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                    <?php endif; ?>
                </div>

                <div class="hero-actions">
                    <?php if ( $office ) : ?>
                        <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary btn-lg">&#128222; <?php echo esc_html( $office['phone'] ); ?></a>
                    <?php endif; ?>
                    <a href="#contact" class="btn btn-outline-light btn-lg">Free Consultation</a>
                </div>
            </div>

        </div>
    </div>
</section>
