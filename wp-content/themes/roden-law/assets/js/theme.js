/**
 * Roden Law — AI-SEO WordPress Theme JavaScript
 * FAQ accordion, smooth scroll, GA tracking, sticky header
 */

(function () {
    'use strict';

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

    /* ── Testimonial Carousel ─────────────────────────────────── */

    var carousel = document.querySelector('.testimonial-carousel');
    if (carousel) {
        var track = carousel.querySelector('.testimonial-track');
        var dots = carousel.querySelectorAll('.testimonial-dot');
        var cards = track ? track.querySelectorAll('.testimonial-card') : [];
        var currentPage = 0;
        var autoTimer = null;

        function getPerPage() {
            return window.innerWidth < 768 ? 1 : 3;
        }

        function getTotalPages() {
            var perPage = getPerPage();
            return Math.ceil(cards.length / perPage);
        }

        function goToPage(page) {
            var totalPages = getTotalPages();
            if (page < 0) page = totalPages - 1;
            if (page >= totalPages) page = 0;
            currentPage = page;

            var perPage = getPerPage();
            var offset = currentPage * (100 / perPage) * perPage;
            track.style.transform = 'translateX(-' + offset + '%)';

            // Update dots
            dots.forEach(function (dot) {
                dot.classList.remove('active');
            });
            // On mobile the number of pages differs — only activate if dot exists
            if (dots[currentPage]) {
                dots[currentPage].classList.add('active');
            }
        }

        // Dot click handlers
        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                var page = parseInt(dot.getAttribute('data-page'), 10);
                goToPage(page);
                resetAutoAdvance();
            });
        });

        // Auto-advance
        function startAutoAdvance() {
            autoTimer = setInterval(function () {
                goToPage(currentPage + 1);
            }, 6000);
        }

        function resetAutoAdvance() {
            if (autoTimer) clearInterval(autoTimer);
            startAutoAdvance();
        }

        startAutoAdvance();

        // Pause on hover
        carousel.addEventListener('mouseenter', function () {
            if (autoTimer) clearInterval(autoTimer);
        });

        carousel.addEventListener('mouseleave', function () {
            startAutoAdvance();
        });

        // Handle resize — recalculate position
        window.addEventListener('resize', function () {
            goToPage(0);
        });
    }

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
