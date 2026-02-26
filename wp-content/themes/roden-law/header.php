<?php
/**
 * Site Header
 *
 * Top bar with vanity phone + office count, sticky navy header with logo,
 * primary navigation, CTA button, and mobile hamburger toggle.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$firm = roden_firm_data();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sr-only" href="#main-content"><?php esc_html_e( 'Skip to content', 'roden-law' ); ?></a>

<div id="page" class="site">

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="site-container">
            <div class="top-bar-left">
                <span class="top-bar-text">
                    <?php esc_html_e( 'Serving Georgia & South Carolina', 'roden-law' ); ?>
                    <span class="top-bar-divider" aria-hidden="true">&mdash;</span>
                    <?php esc_html_e( 'No Fees Unless We Win', 'roden-law' ); ?>
                </span>
            </div>
            <div class="top-bar-right">
                <a href="tel:<?php echo esc_attr( $firm['offices']['savannah']['phone_raw'] ); ?>" class="top-bar-phone">
                    <?php echo esc_html( $firm['vanity_phone'] ); ?>
                </a>
                <span class="top-bar-consult"><?php esc_html_e( 'Free 24/7 Consultations', 'roden-law' ); ?></span>
            </div>
        </div>
    </div>

    <!-- Site Header -->
    <header id="masthead" class="site-header" role="banner">
        <div class="site-container">

            <!-- Logo -->
            <div class="site-logo">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <span class="site-logo-text"><?php echo esc_html( $firm['name'] ); ?></span>
                        <span class="site-logo-tagline"><?php esc_html_e( 'Personal Injury Attorneys', 'roden-law' ); ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Primary Navigation -->
            <nav id="site-navigation" class="main-navigation" role="navigation"
                 aria-label="<?php esc_attr_e( 'Primary Menu', 'roden-law' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => 'roden_fallback_menu',
                ) );
                ?>
            </nav>

            <!-- Header CTA -->
            <div class="header-cta">
                <a href="tel:<?php echo esc_attr( $firm['offices']['savannah']['phone_raw'] ); ?>"
                   class="btn btn-cta-phone">
                    <?php echo esc_html( $firm['vanity_phone'] ); ?>
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="menu-toggle" aria-controls="site-navigation"
                    aria-expanded="false"
                    aria-label="<?php esc_attr_e( 'Toggle Menu', 'roden-law' ); ?>">
                <span class="menu-toggle-bar"></span>
                <span class="menu-toggle-bar"></span>
                <span class="menu-toggle-bar"></span>
            </button>

        </div>
    </header>

    <div id="main-content" class="site-content">
<?php

/**
 * Fallback menu when no menu is assigned to the primary location.
 * Outputs links to the main CPT archives and a few key pages.
 */
function roden_fallback_menu() {
    $firm = roden_firm_data();
    ?>
    <ul id="primary-menu" class="nav-menu">
        <li class="menu-item"><a href="<?php echo esc_url( home_url( '/practice-areas/' ) ); ?>"><?php esc_html_e( 'Practice Areas', 'roden-law' ); ?></a></li>
        <li class="menu-item menu-item-has-children">
            <a href="<?php echo esc_url( home_url( '/locations/' ) ); ?>"><?php esc_html_e( 'Locations', 'roden-law' ); ?></a>
            <ul class="sub-menu">
                <?php foreach ( $firm['offices'] as $office ) :
                    $city_slug = sanitize_title( $office['city'] );
                    $url = home_url( '/locations/' . $office['state_slug'] . '/' . $city_slug . '/' );
                ?>
                    <li class="menu-item"><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $office['city'] . ', ' . $office['state'] ); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li class="menu-item"><a href="<?php echo esc_url( home_url( '/attorneys/' ) ); ?>"><?php esc_html_e( 'Attorneys', 'roden-law' ); ?></a></li>
        <li class="menu-item"><a href="<?php echo esc_url( home_url( '/case-results/' ) ); ?>"><?php esc_html_e( 'Results', 'roden-law' ); ?></a></li>
        <li class="menu-item menu-item-has-children">
            <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About Us', 'roden-law' ); ?></a>
            <ul class="sub-menu">
                <li class="menu-item"><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'roden-law' ); ?></a></li>
            </ul>
        </li>
        <li class="menu-item"><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'roden-law' ); ?></a></li>
    </ul>
    <?php
}
