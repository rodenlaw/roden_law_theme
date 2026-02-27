/**
 * Roden Law — Navigation
 *
 * Mobile hamburger toggle, sub-menu dropdowns, top bar hide-on-scroll,
 * and accessible keyboard/click-outside handling.
 *
 * @package Roden_Law
 */
( function() {
    'use strict';

    /* ── Mobile Menu Toggle ────────────────────────────────────── */

    var toggle = document.querySelector( '.menu-toggle' );
    var nav    = document.getElementById( 'site-navigation' );

    if ( toggle && nav ) {
        toggle.addEventListener( 'click', function() {
            var expanded = 'true' === toggle.getAttribute( 'aria-expanded' );
            toggle.setAttribute( 'aria-expanded', String( ! expanded ) );
            toggle.classList.toggle( 'active' );
            nav.classList.toggle( 'toggled' );
            document.body.classList.toggle( 'nav-open' );
        } );

        // Close menu when clicking outside
        document.addEventListener( 'click', function( e ) {
            if ( nav.classList.contains( 'toggled' ) &&
                 ! nav.contains( e.target ) &&
                 ! toggle.contains( e.target ) ) {
                closeMenu();
            }
        } );

        // Close menu on Escape key
        document.addEventListener( 'keydown', function( e ) {
            if ( 'Escape' === e.key && nav.classList.contains( 'toggled' ) ) {
                closeMenu();
                toggle.focus();
            }
        } );
    }

    function closeMenu() {
        if ( ! toggle || ! nav ) return;
        toggle.setAttribute( 'aria-expanded', 'false' );
        toggle.classList.remove( 'active' );
        nav.classList.remove( 'toggled' );
        document.body.classList.remove( 'nav-open' );
    }

    /* ── Sub-Menu Dropdowns (Mobile) ───────────────────────────── */

    var parentItems = document.querySelectorAll( '.menu-item-has-children' );

    parentItems.forEach( function( item ) {
        var link = item.querySelector( ':scope > a' );
        if ( ! link ) return;

        // Create toggle button for sub-menu
        var btn = document.createElement( 'button' );
        btn.className = 'sub-menu-toggle';
        btn.setAttribute( 'aria-expanded', 'false' );
        btn.setAttribute( 'aria-label', 'Toggle submenu' );
        btn.innerHTML = '<span aria-hidden="true">&#9662;</span>';
        link.parentNode.insertBefore( btn, link.nextSibling );

        btn.addEventListener( 'click', function( e ) {
            e.preventDefault();
            e.stopPropagation();
            var isOpen = item.classList.contains( 'sub-open' );

            // Close other open sub-menus at the same level
            var siblings = item.parentNode.querySelectorAll( '.menu-item-has-children.sub-open' );
            siblings.forEach( function( sib ) {
                if ( sib !== item ) {
                    sib.classList.remove( 'sub-open' );
                    var sibBtn = sib.querySelector( '.sub-menu-toggle' );
                    if ( sibBtn ) {
                        sibBtn.setAttribute( 'aria-expanded', 'false' );
                        sibBtn.classList.remove( 'open' );
                    }
                }
            } );

            // Toggle current
            item.classList.toggle( 'sub-open' );
            btn.setAttribute( 'aria-expanded', String( ! isOpen ) );
            btn.classList.toggle( 'open' );
        } );
    } );

    /* ── Desktop Sub-Menu Hover (keyboard accessible) ──────────── */

    parentItems.forEach( function( item ) {
        // Show sub-menu on focus within (keyboard nav)
        item.addEventListener( 'focusin', function() {
            item.classList.add( 'sub-hover' );
        } );
        item.addEventListener( 'focusout', function( e ) {
            if ( ! item.contains( e.relatedTarget ) ) {
                item.classList.remove( 'sub-hover' );
            }
        } );
    } );

    /* ── Top Bar Hide on Scroll ────────────────────────────────── */

    var topBar = document.querySelector( '.top-bar' );
    var header = document.querySelector( '.site-header' );

    if ( topBar && header ) {
        var topBarHeight = topBar.offsetHeight;
        var lastScrollY  = 0;
        var ticking      = false;

        window.addEventListener( 'scroll', function() {
            lastScrollY = window.pageYOffset;
            if ( ! ticking ) {
                window.requestAnimationFrame( function() {
                    if ( lastScrollY > topBarHeight ) {
                        topBar.classList.add( 'top-bar-hidden' );
                        header.classList.add( 'header-stuck' );
                    } else {
                        topBar.classList.remove( 'top-bar-hidden' );
                        header.classList.remove( 'header-stuck' );
                    }
                    ticking = false;
                } );
                ticking = true;
            }
        }, { passive: true } );
    }

} )();
