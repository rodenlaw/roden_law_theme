/**
 * Roden Law — AI-SEO WordPress Theme JavaScript
 * Mobile navigation, FAQ accordion, smooth scroll, form handling
 */

(function () {
    'use strict';

    /* ── Mobile Navigation ────────────────────────────────────── */

    const mobileToggle = document.querySelector('.mobile-toggle');
    const mobileOverlay = document.querySelector('.mobile-nav-overlay');
    const mobileClose = document.querySelector('.mobile-close');

    function openMobileNav() {
        if (mobileOverlay) {
            mobileOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeMobileNav() {
        if (mobileOverlay) {
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    if (mobileToggle) mobileToggle.addEventListener('click', openMobileNav);
    if (mobileClose) mobileClose.addEventListener('click', closeMobileNav);
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', function (e) {
            if (e.target === mobileOverlay) closeMobileNav();
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMobileNav();
    });

    /* ── FAQ Accordion ────────────────────────────────────────── */

    document.querySelectorAll('.faq-question').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('.faq-item');
            var answer = item.querySelector('.faq-answer');
            var toggle = btn.querySelector('.faq-toggle');
            var isOpen = btn.getAttribute('aria-expanded') === 'true';

            // Close all other FAQs in the same accordion
            var accordion = btn.closest('.faq-accordion');
            if (accordion) {
                accordion.querySelectorAll('.faq-question[aria-expanded="true"]').forEach(function (other) {
                    if (other !== btn) {
                        other.setAttribute('aria-expanded', 'false');
                        var otherAnswer = other.closest('.faq-item').querySelector('.faq-answer');
                        var otherToggle = other.querySelector('.faq-toggle');
                        if (otherAnswer) otherAnswer.style.display = 'none';
                        if (otherToggle) otherToggle.textContent = '+';
                    }
                });
            }

            // Toggle current
            if (isOpen) {
                btn.setAttribute('aria-expanded', 'false');
                if (answer) answer.style.display = 'none';
                if (toggle) toggle.textContent = '+';
            } else {
                btn.setAttribute('aria-expanded', 'true');
                if (answer) answer.style.display = 'block';
                if (toggle) toggle.textContent = '−';
            }
        });
    });

    // Initialize FAQ answers as hidden
    document.querySelectorAll('.faq-answer').forEach(function (answer) {
        var btn = answer.closest('.faq-item').querySelector('.faq-question');
        if (btn && btn.getAttribute('aria-expanded') !== 'true') {
            answer.style.display = 'none';
        }
    });

    /* ── Smooth Scroll for Anchor Links ───────────────────────── */

    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            var targetId = link.getAttribute('href');
            if (targetId === '#') return;
            var target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                var headerHeight = document.querySelector('.site-header')
                    ? document.querySelector('.site-header').offsetHeight
                    : 0;
                var top = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 16;
                window.scrollTo({ top: top, behavior: 'smooth' });
                closeMobileNav();
            }
        });
    });

    /* ── Phone Link Tracking (GA4 Event) ──────────────────────── */

    document.querySelectorAll('a[href^="tel:"]').forEach(function (link) {
        link.addEventListener('click', function () {
            if (typeof gtag === 'function') {
                gtag('event', 'phone_call', {
                    event_category: 'contact',
                    event_label: link.getAttribute('href'),
                });
            }
        });
    });

    /* ── Form Submission Tracking ─────────────────────────────── */

    document.querySelectorAll('.roden-contact-form, .roden-footer-form').forEach(function (form) {
        form.addEventListener('submit', function () {
            if (typeof gtag === 'function') {
                gtag('event', 'form_submit', {
                    event_category: 'contact',
                    event_label: form.closest('.sidebar-contact-form') ? 'sidebar' : 'footer',
                });
            }
        });
    });

    /* ── Sticky Header Shadow on Scroll ───────────────────────── */

    var header = document.querySelector('.site-header');
    if (header) {
        var lastScroll = 0;
        window.addEventListener('scroll', function () {
            var current = window.pageYOffset;
            if (current > 10) {
                header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.12)';
            } else {
                header.style.boxShadow = '0 2px 16px rgba(0,0,0,0.08)';
            }
            lastScroll = current;
        }, { passive: true });
    }

})();
