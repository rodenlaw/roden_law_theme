/**
 * Roden Law — AI-SEO WordPress Theme JavaScript
 * FAQ accordion, smooth scroll, GA tracking, sticky header
 */

(function () {
    'use strict';

    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

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
                window.scrollTo({ top: top, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
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

    document.querySelectorAll('.gform_wrapper form, .roden-contact-form, .roden-footer-form').forEach(function (form) {
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
            }, 8000);
        }

        function resetAutoAdvance() {
            if (autoTimer) clearInterval(autoTimer);
            startAutoAdvance();
        }

        if (!prefersReducedMotion) startAutoAdvance();

        // Pause on hover
        carousel.addEventListener('mouseenter', function () {
            if (autoTimer) clearInterval(autoTimer);
        });

        carousel.addEventListener('mouseleave', function () {
            if (!prefersReducedMotion) startAutoAdvance();
        });

        // Handle resize — recalculate position
        window.addEventListener('resize', function () {
            goToPage(0);
        });
    }

    /* ── Results Carousel Arrows ──────────────────────────────── */

    document.querySelectorAll('.results-carousel').forEach(function (carousel) {
        var track = carousel.querySelector('.results-track');
        var leftBtn = carousel.querySelector('.results-arrow-left');
        var rightBtn = carousel.querySelector('.results-arrow-right');
        if (!track) return;

        var scrollAmount = 280;

        if (leftBtn) {
            leftBtn.addEventListener('click', function () {
                track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });
        }
        if (rightBtn) {
            rightBtn.addEventListener('click', function () {
                track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });
        }

        // Keyboard navigation: arrow keys when carousel or buttons are focused
        carousel.setAttribute('tabindex', '0');
        carousel.setAttribute('role', 'region');
        carousel.setAttribute('aria-label', 'Case results');
        carousel.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        });
    });

    /* ── Sticky Mobile CTA Bar ────────────────────────────────── */

    var mobileCta = document.querySelector('.pa-mobile-cta');
    if (mobileCta) {
        var ctaVisible = false;
        window.addEventListener('scroll', function () {
            var scrollY = window.pageYOffset;
            // Show after scrolling past the hero (approx 500px)
            if (scrollY > 500 && !ctaVisible) {
                mobileCta.style.transform = 'translateY(0)';
                ctaVisible = true;
            } else if (scrollY <= 500 && ctaVisible) {
                mobileCta.style.transform = 'translateY(100%)';
                ctaVisible = false;
            }
        }, { passive: true });

        // Start hidden, slide up
        mobileCta.style.transform = 'translateY(100%)';
        mobileCta.style.transition = 'transform 0.3s ease';
    }

    /* ── Jump Nav Active Section Tracking ──────────────────────── */

    var jumpNav = document.querySelector('.pa-jump-nav');
    if (jumpNav) {
        var jumpLinks = jumpNav.querySelectorAll('a[href^="#"]');
        var sections = [];
        jumpLinks.forEach(function (link) {
            var target = document.querySelector(link.getAttribute('href'));
            if (target) sections.push({ link: link, el: target });
        });

        if (sections.length) {
            var headerOffset = 140; // header + jump nav height
            window.addEventListener('scroll', function () {
                var scrollY = window.pageYOffset + headerOffset;
                var current = null;
                for (var i = sections.length - 1; i >= 0; i--) {
                    if (scrollY >= sections[i].el.offsetTop) {
                        current = sections[i].link;
                        break;
                    }
                }
                jumpLinks.forEach(function (l) { l.classList.remove('active'); });
                if (current) current.classList.add('active');
            }, { passive: true });
        }
    }

    /* ── Back to Top Button ─────────────────────────────────────── */

    var backToTop = document.querySelector('.back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 600) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        }, { passive: true });

        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
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
