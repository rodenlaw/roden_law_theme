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
                        if (otherAnswer) otherAnswer.classList.remove('faq-answer-open');
                        if (otherToggle) otherToggle.textContent = '+';
                    }
                });
            }

            // Toggle current via CSS class (avoids inline style reflow)
            if (isOpen) {
                btn.setAttribute('aria-expanded', 'false');
                if (answer) answer.classList.remove('faq-answer-open');
                if (toggle) toggle.textContent = '+';
            } else {
                btn.setAttribute('aria-expanded', 'true');
                if (answer) answer.classList.add('faq-answer-open');
                if (toggle) toggle.textContent = '−';
            }
        });
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

    /* ── Testimonial Carousel ─────────────────────────────────── */

    var carousel = document.querySelector('.testimonial-carousel');
    if (carousel) {
        var track = carousel.querySelector('.testimonial-track');
        var dots = carousel.querySelectorAll('.testimonial-dot');
        var cards = track ? track.querySelectorAll('.testimonial-card') : [];
        var currentPage = 0;
        var carouselInterval = parseInt(carousel.getAttribute('data-interval'), 10) || 8000;
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
            }, carouselInterval);
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

        // Handle resize — recalculate position (debounced)
        var resizeTimer = null;
        window.addEventListener('resize', function () {
            if (resizeTimer) clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () { goToPage(0); }, 150);
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

    /* ── Sticky Mobile CTA Bar (Intersection Observer) ─────────── */

    var mobileCta = document.querySelector('.pa-mobile-cta');
    if (mobileCta) {
        // Start hidden
        mobileCta.style.transform = 'translateY(100%)';
        mobileCta.style.transition = 'transform 0.3s ease';

        // Create a sentinel element at the 500px scroll threshold
        var ctaSentinel = document.createElement('div');
        ctaSentinel.style.cssText = 'position:absolute;top:500px;height:1px;width:1px;pointer-events:none;';
        document.body.appendChild(ctaSentinel);

        var ctaObserver = new IntersectionObserver(function (entries) {
            // When sentinel scrolls out of view (above viewport), show CTA
            mobileCta.style.transform = entries[0].isIntersecting ? 'translateY(100%)' : 'translateY(0)';
        });
        ctaObserver.observe(ctaSentinel);
    }

    /* ── Jump Nav Active Section Tracking (Intersection Observer) ── */

    var jumpNav = document.querySelector('.pa-jump-nav');
    if (jumpNav) {
        var jumpLinks = jumpNav.querySelectorAll('a[href^="#"]');
        var sectionMap = {};
        var sectionEls = [];

        jumpLinks.forEach(function (link) {
            var target = document.querySelector(link.getAttribute('href'));
            if (target) {
                sectionMap[target.id] = link;
                sectionEls.push(target);
            }
        });

        if (sectionEls.length) {
            var siteHeader = document.querySelector('.site-header');
            var topOffset = (siteHeader ? siteHeader.offsetHeight : 72) + jumpNav.offsetHeight + 16;

            var sectionObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        jumpLinks.forEach(function (l) { l.classList.remove('active'); });
                        var active = sectionMap[entry.target.id];
                        if (active) active.classList.add('active');
                    }
                });
            }, {
                rootMargin: '-' + topOffset + 'px 0px -60% 0px',
                threshold: 0
            });

            sectionEls.forEach(function (el) { sectionObserver.observe(el); });
        }
    }

    /* ── Back to Top Button (Intersection Observer) ─────────────── */

    var backToTop = document.querySelector('.back-to-top');
    if (backToTop) {
        var bttSentinel = document.createElement('div');
        bttSentinel.style.cssText = 'position:absolute;top:600px;height:1px;width:1px;pointer-events:none;';
        document.body.appendChild(bttSentinel);

        var bttObserver = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                backToTop.classList.remove('visible');
            } else {
                backToTop.classList.add('visible');
            }
        });
        bttObserver.observe(bttSentinel);

        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
        });
    }

    /* ── Sticky Header Shadow (Intersection Observer) ─────────── */

    var header = document.querySelector('.site-header');
    if (header) {
        var shadowSentinel = document.createElement('div');
        shadowSentinel.style.cssText = 'position:absolute;top:10px;height:1px;width:1px;pointer-events:none;';
        document.body.appendChild(shadowSentinel);

        var shadowObserver = new IntersectionObserver(function (entries) {
            header.style.boxShadow = entries[0].isIntersecting
                ? '0 2px 16px rgba(0,0,0,0.08)'
                : '0 2px 20px rgba(0,0,0,0.12)';
        });
        shadowObserver.observe(shadowSentinel);
    }

})();
