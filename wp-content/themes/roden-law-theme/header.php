<?php
/**
 * Theme Header
 *
 * @package RodenLaw
 */
$firm = roden_firm_data();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">Skip to content</a>

<!-- Top Bar -->
<div class="top-bar">
    <div class="container top-bar-inner">
        <div class="top-bar-left">
            <span class="top-bar-text">Serving Georgia &amp; South Carolina — No Fees Unless We Win</span>
        </div>
        <div class="top-bar-right">
            <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="top-bar-phone">
                📞 <?php echo esc_html( $firm['phone'] ); ?>
            </a>
            <span class="top-bar-text">Free 24/7 Consultations</span>
        </div>
    </div>
</div>

<!-- Main Navigation -->
<header class="site-header" id="site-header">
    <div class="container header-inner">
        <a href="<?php echo esc_url( home_url('/') ); ?>" class="site-brand" rel="home">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <div class="brand-icon">R</div>
                <div class="brand-text">
                    <span class="brand-name">RODEN LAW</span>
                    <span class="brand-tagline">Personal Injury Attorneys</span>
                </div>
            <?php endif; ?>
        </a>

        <nav class="main-nav" id="main-nav" role="navigation" aria-label="Primary Navigation">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-menu',
                'fallback_cb'    => 'roden_fallback_nav',
                'depth'          => 2,
            ] );
            ?>
        </nav>

        <div class="header-cta">
            <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary header-phone">
                <?php echo esc_html( $firm['phone'] ); ?>
            </a>
        </div>

        <button class="mobile-toggle" id="mobile-toggle" aria-label="Toggle navigation" aria-expanded="false">
            <span class="hamburger"></span>
        </button>
    </div>
</header>

<!-- Mobile Nav Drawer -->
<div class="mobile-nav-overlay" id="mobile-nav-overlay">
    <div class="mobile-nav-drawer" id="mobile-nav-drawer">
        <div class="mobile-nav-header">
            <span class="brand-name">RODEN LAW</span>
            <button class="mobile-close" id="mobile-close" aria-label="Close navigation">&times;</button>
        </div>
        <?php
        wp_nav_menu( [
            'theme_location' => 'mobile',
            'container'      => false,
            'menu_class'     => 'mobile-menu',
            'fallback_cb'    => 'roden_fallback_nav',
            'depth'          => 2,
        ] );
        ?>
        <div class="mobile-nav-cta">
            <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary btn-block">
                📞 Call <?php echo esc_html( $firm['phone'] ); ?>
            </a>
        </div>
    </div>
</div>

<main id="main-content" class="site-main">
<?php
/**
 * Fallback nav if no menu is set
 */
function roden_fallback_nav() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url( home_url('/practice-areas/') ) . '">Practice Areas</a></li>';
    echo '<li><a href="' . esc_url( home_url('/locations/') ) . '">Locations</a></li>';
    echo '<li><a href="' . esc_url( home_url('/attorneys/') ) . '">Attorneys</a></li>';
    echo '<li><a href="' . esc_url( home_url('/results/') ) . '">Results</a></li>';
    echo '<li><a href="' . esc_url( home_url('/blog/') ) . '">Blog</a></li>';
    echo '</ul>';
}
