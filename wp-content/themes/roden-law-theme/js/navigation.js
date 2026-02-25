/**
 * Roden Law — Mobile Navigation Toggle
 *
 * Handles hamburger menu open/close and accessible aria attributes.
 *
 * @package Roden_Law
 */
( function() {
    'use strict';

    var toggle = document.querySelector( '.menu-toggle' );
    var nav    = document.getElementById( 'site-navigation' );

    if ( ! toggle || ! nav ) {
        return;
    }

    toggle.addEventListener( 'click', function() {
        var expanded = 'true' === toggle.getAttribute( 'aria-expanded' );
        toggle.setAttribute( 'aria-expanded', String( ! expanded ) );
        toggle.classList.toggle( 'active' );
        nav.classList.toggle( 'toggled' );
    } );

    // Close menu when clicking outside
    document.addEventListener( 'click', function( e ) {
        if ( nav.classList.contains( 'toggled' ) &&
             ! nav.contains( e.target ) &&
             ! toggle.contains( e.target ) ) {
            toggle.setAttribute( 'aria-expanded', 'false' );
            toggle.classList.remove( 'active' );
            nav.classList.remove( 'toggled' );
        }
    } );

    // Close menu on Escape key
    document.addEventListener( 'keydown', function( e ) {
        if ( 'Escape' === e.key && nav.classList.contains( 'toggled' ) ) {
            toggle.setAttribute( 'aria-expanded', 'false' );
            toggle.classList.remove( 'active' );
            nav.classList.remove( 'toggled' );
            toggle.focus();
        }
    } );
} )();
