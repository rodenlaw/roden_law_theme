<?php
/**
 * Roden Law Theme Functions
 *
 * Core engine: loads modular inc/ files, handles theme setup
 * and widget areas. Enqueue, meta boxes, nav menus, and schema
 * markup live in their own inc/ modules.
 *
 * @package Roden_Law
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   1. LOAD INC/ MODULES
   ========================================================================== */

require_once get_template_directory() . '/inc/firm-data.php';
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/rewrite-rules.php';
require_once get_template_directory() . '/inc/schema-helpers.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/nav-menus.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/meta-boxes.php';
require_once get_template_directory() . '/inc/legacy-redirects.php';

// Belt-and-suspenders: verify template-tags loaded (require retries if require_once cached a failure)
if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require get_template_directory() . '/inc/template-tags.php';
}

/* ==========================================================================
   2. THEME SETUP
   ========================================================================== */

add_action( 'after_setup_theme', 'roden_theme_setup' );
function roden_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    add_image_size( 'attorney-headshot', 400, 533, true );
    add_image_size( 'attorney-portrait', 600, 800, true );
    add_image_size( 'card-thumb', 600, 400, true );
    add_image_size( 'hero-bg', 1920, 800, true );
}

/* ==========================================================================
   3. OLD-FORMAT PAGE REDIRECTS — Legacy pages → canonical URLs
   ========================================================================== */

add_action( 'template_redirect', 'roden_old_page_redirects', 1 );
function roden_old_page_redirects() {
    if ( ! is_page() ) {
        return;
    }

    // Map page slugs to their canonical destinations
    $redirects = array(
        'car-accident-lawyer'                  => '/practice-areas/car-accident-lawyers/',
        'charleston-car-accident-lawyer'       => '/practice-areas/car-accident-lawyers/charleston-sc/',
        'south-carolina-car-accident-lawyer'   => '/practice-areas/car-accident-lawyers/',
        'south-carolina-truck-accident-lawyer' => '/practice-areas/truck-accident-lawyers/',
        'columbia-truck-accident-lawyer'       => '/practice-areas/truck-accident-lawyers/columbia-sc/',
        'savannah'                             => '/practice-areas/',
        'brunswick'                            => '/practice-areas/',
        'charleston'                           => '/practice-areas/',
        'thank-you-ppc-2'                      => '/',
        'class-actions'                        => '/class-action-lawyers/',
    );

    $slug = get_post_field( 'post_name', get_the_ID() );

    if ( isset( $redirects[ $slug ] ) ) {
        wp_redirect( home_url( $redirects[ $slug ] ), 301 );
        exit;
    }
}

/* ==========================================================================
   3b. ENSURE CORE SITEMAPS WORK — prevent plugin/redirect interference
   ========================================================================== */

// Force-enable WP core sitemaps (removed SEO plugins may have left them disabled).
add_filter( 'wp_sitemaps_enabled', '__return_true', 99 );

// Block canonical redirects on sitemap URLs so WordPress doesn't redirect
// them to unrelated posts or strip trailing slashes.
add_filter( 'redirect_canonical', 'roden_canonical_skip_sitemaps', 10, 2 );
function roden_canonical_skip_sitemaps( $redirect_url, $requested_url ) {
    if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], 'sitemap' ) !== false ) {
        return false;
    }
    return $redirect_url;
}

/* ==========================================================================
   3c. STAFF — Redirect single pages & exclude from sitemap
   ========================================================================== */

add_filter( 'wp_sitemaps_posts_query_args', 'roden_exclude_staff_from_sitemap', 10, 2 );
function roden_exclude_staff_from_sitemap( $args, $post_type ) {
    if ( 'attorney' === $post_type ) {
        $args['meta_query'] = array(
            'relation' => 'OR',
            array( 'key' => '_roden_team_role', 'value' => 'attorney' ),
            array( 'key' => '_roden_team_role', 'compare' => 'NOT EXISTS' ),
        );
    }
    return $args;
}

add_action( 'template_redirect', 'roden_staff_redirect' );
function roden_staff_redirect() {
    if ( ! is_singular( 'attorney' ) ) {
        return;
    }
    $role = get_post_meta( get_the_ID(), '_roden_team_role', true );
    if ( 'staff' === $role ) {
        wp_redirect( home_url( '/attorneys/' ), 301 );
        exit;
    }
}

/* ==========================================================================
   3c-2. DISABLE USERS SITEMAP + LEGACY CPT SITEMAPS
   ========================================================================== */

// Remove the users sitemap entirely (exposes author accounts).
add_filter( 'wp_sitemaps_add_provider', 'roden_remove_users_sitemap', 10, 2 );
function roden_remove_users_sitemap( $provider, $name ) {
    if ( 'users' === $name ) {
        return false;
    }
    return $provider;
}

// Remove legacy CPT sitemaps: case-result (hyphen), class-action, staff.
add_filter( 'wp_sitemaps_post_types', 'roden_remove_legacy_cpt_sitemaps' );
function roden_remove_legacy_cpt_sitemaps( $post_types ) {
    unset( $post_types['case-result'] );
    unset( $post_types['class-action'] );
    unset( $post_types['staff'] );
    return $post_types;
}

/* ==========================================================================
   3c-3. EXCLUDE TOXIC / LOW-VALUE PAGES FROM SITEMAP
   ========================================================================== */

add_filter( 'wp_sitemaps_posts_query_args', 'roden_exclude_toxic_pages_from_sitemap', 10, 2 );
function roden_exclude_toxic_pages_from_sitemap( $args, $post_type ) {
    if ( 'page' === $post_type ) {
        $exclude_slugs = array(
            'gracias-ppc-2',
            'gracias-ppc-3',
            'thank-you',
            'test',
            'privacy-policy-2',
            'car-accident-lawyer',
            'south-carolina-truck-accident-lawyer',
            'columbia-truck-accident-lawyer',
            'charleston-car-accident-lawyer',
            'south-carolina-car-accident-lawyer',
        );

        // Get post IDs by slug to exclude.
        $exclude_ids = array();
        $pages = get_posts( array(
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'post_name__in'  => $exclude_slugs,
            'fields'         => 'ids',
            'posts_per_page' => 50,
        ) );
        $exclude_ids = array_merge( $exclude_ids, $pages );

        // Exclude old office URL structure: /savannah/practice-areas/, etc.
        // These are child pages with slug 'practice-areas' under city parents.
        $office_pa_pages = get_posts( array(
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'name'           => 'practice-areas',
            'fields'         => 'ids',
            'posts_per_page' => 20,
        ) );
        foreach ( $office_pa_pages as $pa_page_id ) {
            $parent = get_post( wp_get_post_parent_id( $pa_page_id ) );
            if ( $parent && in_array( $parent->post_name, array( 'savannah', 'brunswick', 'charleston' ), true ) ) {
                $exclude_ids[] = $pa_page_id;
            }
        }

        if ( ! empty( $exclude_ids ) ) {
            $existing = isset( $args['post__not_in'] ) ? $args['post__not_in'] : array();
            $args['post__not_in'] = array_merge( $existing, $exclude_ids );
        }
    }

    // Exclude duplicate class-action-lawyers if it's a practice_area.
    if ( 'practice_area' === $post_type ) {
        $dupes = get_posts( array(
            'post_type'      => 'practice_area',
            'post_status'    => 'publish',
            'name'           => 'class-action-lawyers',
            'fields'         => 'ids',
            'posts_per_page' => 10,
        ) );
        if ( count( $dupes ) > 1 ) {
            // Keep the first (oldest), exclude the rest.
            sort( $dupes );
            array_shift( $dupes );
            $existing = isset( $args['post__not_in'] ) ? $args['post__not_in'] : array();
            $args['post__not_in'] = array_merge( $existing, $dupes );
        }
    }

    return $args;
}

/* ==========================================================================
   3c. LEGACY /who-we-are/attorneys/ → /attorneys/ redirect
   ========================================================================== */

add_action( 'template_redirect', 'roden_legacy_attorney_redirect', 2 );
function roden_legacy_attorney_redirect() {
    if ( ! is_404() ) {
        return;
    }
    $path = trim( $_SERVER['REQUEST_URI'], '/' );
    if ( preg_match( '#^who-we-are/attorneys/([^/?]+)#', $path, $m ) ) {
        wp_redirect( home_url( '/attorneys/' . $m[1] . '/' ), 301 );
        exit;
    }
    if ( preg_match( '#^who-we-are/attorneys/?$#', $path ) ) {
        wp_redirect( home_url( '/attorneys/' ), 301 );
        exit;
    }
}

/* ==========================================================================
   3d. 404 REDIRECT — Send all 404s to the homepage
   ========================================================================== */

add_action( 'template_redirect', 'roden_redirect_404_to_home', 20 );
function roden_redirect_404_to_home() {
    // Don't redirect sitemap or XML requests — let WordPress handle them.
    if ( isset( $_SERVER['REQUEST_URI'] ) ) {
        $uri = $_SERVER['REQUEST_URI'];
        if ( strpos( $uri, 'sitemap' ) !== false || strpos( $uri, '.xml' ) !== false ) {
            return;
        }
    }

    if ( is_404() ) {
        wp_redirect( home_url( '/' ), 302 );
        exit;
    }
}

/* ==========================================================================
   4. TEMPLATE ROUTING — Bridge ACF CPT names to theme templates
   ========================================================================== */

add_filter( 'template_include', 'roden_bridge_cpt_templates', 1001 );
/**
 * Route posts from ACF-registered CPTs (hyphen names) to our theme templates
 * (underscore names). ACF registers 'practice-area'; our template file is
 * single-practice_area.php.
 *
 * Uses template_include at priority 1001 to override ACF Extended's
 * front_template filter (priority 999).
 */
function roden_bridge_cpt_templates( $template ) {
    // Archive templates: bridge both CPT slugs to our underscore-named file.
    if ( is_post_type_archive( 'practice-area' ) || is_post_type_archive( 'practice_area' ) ) {
        $custom = get_template_directory() . '/archive-practice_area.php';
        if ( file_exists( $custom ) ) {
            return $custom;
        }
    }

    if ( ! is_singular() ) {
        return $template;
    }

    $map = [
        'practice-area' => '/single-practice_area.php',
    ];

    $post_type = get_post_type();
    if ( isset( $map[ $post_type ] ) ) {
        $custom = get_template_directory() . $map[ $post_type ];
        if ( file_exists( $custom ) ) {
            return $custom;
        }
    }

    return $template;
}

/* ==========================================================================
   5. PAGE TEMPLATES — Register templates in templates/ subdirectory
   ========================================================================== */

add_filter( 'theme_page_templates', 'roden_register_page_templates' );
function roden_register_page_templates( $templates ) {
    $templates['templates/template-landing-page.php']  = 'Landing Page';
    $templates['templates/template-landing-truck.php']          = 'Truck Accident Landing Page';
    $templates['templates/template-landing-truck-columbia.php'] = 'Truck Accident Landing Page — Columbia';
    $templates['templates/template-landing-sc-statewide.php']  = 'Landing Page — SC Statewide';
    return $templates;
}

/* ==========================================================================
   6. WIDGET AREAS
   ========================================================================== */

add_action( 'widgets_init', 'roden_register_sidebars' );
function roden_register_sidebars() {
    register_sidebar( array(
        'name'          => __( 'Practice Area Sidebar', 'roden-law' ),
        'id'            => 'sidebar-practice-area',
        'description'   => __( 'Sidebar for practice area pages', 'roden-law' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Location Sidebar', 'roden-law' ),
        'id'            => 'sidebar-location',
        'description'   => __( 'Sidebar for location pages', 'roden-law' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Blog Sidebar', 'roden-law' ),
        'id'            => 'sidebar-blog',
        'description'   => __( 'Sidebar for blog and resource pages', 'roden-law' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Widgets', 'roden-law' ),
        'id'            => 'sidebar-footer',
        'description'   => __( 'Footer widget area', 'roden-law' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}

/* ==========================================================================
   7. THANK-YOU PAGE — Noindex + Conversion Tracking
   ========================================================================== */

add_filter( 'wp_robots', 'roden_thankyou_noindex' );
function roden_thankyou_noindex( $robots ) {
    if ( is_page( 'thank-you' ) ) {
        $robots['noindex'] = true;
        $robots['nofollow'] = true;
    }
    return $robots;
}

add_action( 'wp_head', 'roden_thankyou_conversion_tracking' );
function roden_thankyou_conversion_tracking() {
    if ( ! is_page( 'thank-you' ) ) {
        return;
    }
    ?>
    <script>
    window.addEventListener('load', function () {
        /* Google Analytics / GA4 generate_lead event */
        if (typeof gtag === 'function') {
            gtag('event', 'generate_lead', {
                event_category: 'contact',
                event_label: 'form_submission',
                value: 1
            });
        }
    });
    </script>
    <?php
}

/* ==========================================================================
   7b. ROBOTS.TXT — Remove Crawl-delay + welcome AI crawlers
   ========================================================================== */

add_filter( 'robots_txt', 'roden_custom_robots_txt', 100, 2 );
function roden_custom_robots_txt( $output, $public ) {
    if ( '0' === $public ) {
        return $output; // respect "Discourage search engines" setting
    }

    $output  = "User-agent: *\n";
    $output .= "Disallow: /wp-admin/\n";
    $output .= "Allow: /wp-admin/admin-ajax.php\n\n";

    $output .= "# AI Search Crawlers — explicitly welcomed\n";
    $ai_bots = array(
        'OAI-SearchBot',
        'ChatGPT-User',
        'GPTBot',
        'Google-Extended',
        'PerplexityBot',
        'ClaudeBot',
        'anthropic-ai',
        'Applebot-Extended',
        'cohere-ai',
    );
    foreach ( $ai_bots as $bot ) {
        $output .= "User-agent: {$bot}\nAllow: /\n\n";
    }

    $output .= "Sitemap: https://rodenlaw.com/wp-sitemap.xml/\n";

    return $output;
}

/* ==========================================================================
   7c. HOMEPAGE META DESCRIPTION
   ========================================================================== */

add_action( 'wp_head', 'roden_homepage_meta_description', 1 );
function roden_homepage_meta_description() {
    if ( ! is_front_page() ) {
        return;
    }
    // Skip if an SEO plugin already outputs a meta description.
    if ( defined( 'WPSEO_VERSION' ) ) {
        return;
    }
    echo '<meta name="description" content="Roden Law is a personal injury law firm with offices in Charleston, Savannah, Columbia, Myrtle Beach, and Darien. Over $250 million recovered for injured clients. Free consultation. No fees unless we win. Call 1-844-RESULTS.">' . "\n";
}

/* ==========================================================================
   7d. FORCE en-US LOCALE — Fallback when Polylang is not active
   ========================================================================== */

add_filter( 'locale', 'roden_force_en_us_locale' );
function roden_force_en_us_locale( $locale ) {
    if ( ! is_admin() && ! function_exists( 'pll_current_language' ) ) {
        return 'en_US';
    }
    return $locale;
}

/* ==========================================================================
   8. CUSTOM SIDEBAR FORM — AJAX handler → GF entry
   ========================================================================== */

add_action( 'wp_ajax_roden_sidebar_submit', 'roden_sidebar_form_handler' );
add_action( 'wp_ajax_nopriv_roden_sidebar_submit', 'roden_sidebar_form_handler' );
function roden_sidebar_form_handler() {
    check_ajax_referer( 'roden_sidebar_form', 'roden_form_nonce' );

    $first_name = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last_name  = sanitize_text_field( $_POST['last_name'] ?? '' );
    $phone      = sanitize_text_field( $_POST['phone'] ?? '' );
    $email      = sanitize_email( $_POST['email'] ?? '' );
    $case_type  = sanitize_text_field( $_POST['case_type'] ?? '' );
    $message    = sanitize_textarea_field( $_POST['message'] ?? '' );
    $consent    = ! empty( $_POST['consent'] ) ? 1 : 0;

    // Validate required fields.
    if ( ! $first_name || ! $last_name || ! $phone || ! $email || ! $case_type || ! $consent ) {
        wp_send_json_error( 'Please fill in all required fields and accept the consent.' );
    }

    // Create a GF entry directly (bypasses form validation so Zip isn't required).
    if ( class_exists( 'GFAPI' ) ) {
        $entry_data = array(
            'form_id'    => 1,
            '9'          => $first_name,
            '10'         => $last_name,
            '4'          => $phone,
            '3'          => $email,
            '11'         => $case_type,
            '6'          => $message,
            '12.1'       => $consent ? 'Checked' : '',
            'source_url' => wp_get_referer() ? wp_get_referer() : home_url(),
            'ip'         => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        );
        $entry_id = GFAPI::add_entry( $entry_data );

        if ( ! is_wp_error( $entry_id ) ) {
            // Trigger GF notifications (admin alert + client confirmation emails).
            $form  = GFAPI::get_form( 1 );
            $entry = GFAPI::get_entry( $entry_id );
            GFAPI::send_notifications( $form, $entry );
        }
    } else {
        // Fallback: send email directly.
        $to      = 'intake@rodenlaw.com';
        $subject = 'New Case Review: ' . $case_type . ' — ' . $first_name . ' ' . $last_name;
        $body    = "Name: $first_name $last_name\nPhone: $phone\nEmail: $email\nCase Type: $case_type\nMessage: $message";
        wp_mail( $to, $subject, $body );
    }

    wp_send_json_success( array( 'redirect' => home_url( '/thank-you/' ) ) );
}

/**
 * Sidebar form JS — submit via fetch, redirect on success.
 */
add_action( 'wp_footer', 'roden_sidebar_form_js', 999 );
function roden_sidebar_form_js() {
    ?>
    <script>
    (function(){
        var form = document.getElementById('roden-sidebar-form');
        if (!form) return;

        /* --- Phone auto-format: (xxx) xxx-xxxx --- */
        var phoneInput = document.getElementById('rsf-phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
                var digits = this.value.replace(/\D/g, '').substring(0, 10);
                if (digits.length === 0) { this.value = ''; }
                else if (digits.length <= 3) { this.value = '(' + digits; }
                else if (digits.length <= 6) { this.value = '(' + digits.substring(0,3) + ') ' + digits.substring(3); }
                else { this.value = '(' + digits.substring(0,3) + ') ' + digits.substring(3,6) + '-' + digits.substring(6); }
            });
        }

        /* --- Email validation --- */
        var emailInput = document.getElementById('rsf-email');
        if (emailInput) {
            emailInput.addEventListener('blur', function() {
                var v = this.value.trim();
                if (v && !/^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/.test(v)) {
                    this.setCustomValidity('Please enter a valid email (e.g. name@example.com)');
                } else {
                    this.setCustomValidity('');
                }
            });
            emailInput.addEventListener('input', function() { this.setCustomValidity(''); });
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var btn = form.querySelector('.rsf-submit-btn');
            var errEl = form.querySelector('.rsf-error');
            /* Validate phone has 10 digits */
            var phoneDigits = (phoneInput ? phoneInput.value : '').replace(/\D/g, '');
            if (phoneDigits.length !== 10) {
                errEl.textContent = 'Please enter a valid 10-digit phone number.';
                errEl.style.display = 'block';
                if (phoneInput) phoneInput.focus();
                return;
            }
            /* Validate email format */
            var emailVal = emailInput ? emailInput.value.trim() : '';
            if (!/^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/.test(emailVal)) {
                errEl.textContent = 'Please enter a valid email address.';
                errEl.style.display = 'block';
                if (emailInput) emailInput.focus();
                return;
            }
            btn.disabled = true;
            btn.textContent = 'Submitting…';
            errEl.style.display = 'none';
            var fd = new FormData(form);
            fd.append('action', 'roden_sidebar_submit');
            fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
                method: 'POST',
                body: fd
            })
            .then(function(r){ return r.json(); })
            .then(function(data){
                if (data.success && data.data.redirect) {
                    window.location.href = data.data.redirect;
                } else {
                    errEl.textContent = data.data || 'Something went wrong. Please call 1-844-RESULTS.';
                    errEl.style.display = 'block';
                    btn.disabled = false;
                    btn.textContent = 'See If You Qualify';
                }
            })
            .catch(function(){
                errEl.textContent = 'Network error. Please call 1-844-RESULTS.';
                errEl.style.display = 'block';
                btn.disabled = false;
                btn.textContent = 'See If You Qualify';
            });
        });
    })();
    </script>
    <?php
}

/* ==========================================================================
   9. LOAD MORE CASE RESULTS — AJAX handler
   ========================================================================== */

add_action( 'wp_ajax_roden_load_more_results', 'roden_load_more_results_handler' );
add_action( 'wp_ajax_nopriv_roden_load_more_results', 'roden_load_more_results_handler' );
function roden_load_more_results_handler() {
    $offset   = absint( $_POST['offset'] ?? 0 );
    $exclude  = absint( $_POST['exclude'] ?? 0 );
    $category = sanitize_text_field( $_POST['category'] ?? '' );
    $per_page = 20;

    $query_args = array(
        'post_type'      => 'case_result',
        'posts_per_page' => $per_page,
        'offset'         => $offset,
        'orderby'        => 'meta_value_num',
        'meta_key'       => '_roden_case_amount_raw',
        'order'          => 'DESC',
    );

    if ( $exclude ) {
        $query_args['post__not_in'] = array( $exclude );
    }

    if ( $category ) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'practice_category',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        );
    }

    $results = new WP_Query( $query_args );

    if ( ! $results->have_posts() ) {
        wp_send_json_success( array( 'html' => '', 'count' => 0 ) );
    }

    ob_start();
    while ( $results->have_posts() ) :
        $results->the_post();
        $amount = get_post_meta( get_the_ID(), '_roden_case_amount', true );
        $type   = get_post_meta( get_the_ID(), '_roden_case_type', true );
        $desc   = get_post_meta( get_the_ID(), '_roden_description', true );
        ?>
        <div class="result-card">
            <span class="result-type"><?php echo esc_html( ucfirst( $type ) ); ?></span>
            <span class="result-amount"><?php echo esc_html( $amount ); ?></span>
            <span class="result-title"><?php the_title(); ?></span>
            <?php if ( $desc ) : ?>
                <p class="result-desc"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
        </div>
        <?php
    endwhile;
    $html = ob_get_clean();
    wp_reset_postdata();

    wp_send_json_success( array(
        'html'  => $html,
        'count' => $results->post_count,
    ) );
}

/**
 * Load More case results JS.
 */
/* ==========================================================================
   10. DISABLE COMMENTS — Sitewide
   ========================================================================== */

add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );
add_filter( 'comments_array', '__return_empty_array', 10, 2 );

add_action( 'admin_menu', function () {
    remove_menu_page( 'edit-comments.php' );
} );

add_action( 'admin_bar_menu', function ( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'comments' );
}, 999 );

add_action( 'wp_before_admin_bar_render', function () {
    global $wp_admin_bar;
    if ( $wp_admin_bar ) {
        $wp_admin_bar->remove_menu( 'comments' );
    }
} );

/* ========================================================================== */

add_action( 'wp_footer', 'roden_load_more_js', 998 );
function roden_load_more_js() {
    if ( ! is_page( 'case-results' ) ) return;
    ?>
    <script>
    (function(){
        var btn = document.getElementById('load-more-results');
        var grid = document.querySelector('.case-results-grid');
        var shownEl = document.getElementById('shown-count');
        var loadMoreWrap = btn ? btn.parentNode : null;
        var total = btn ? parseInt(btn.getAttribute('data-total'), 10) : 0;
        var ajaxUrl = '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';
        var activeCategory = '';

        // Filter buttons
        var filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(function(filterBtn) {
            filterBtn.addEventListener('click', function() {
                var category = this.getAttribute('data-category');
                activeCategory = category;

                // Update active state
                filterBtns.forEach(function(b){ b.classList.remove('active'); });
                this.classList.add('active');

                // Reload grid with filter
                if (grid) grid.innerHTML = '';
                if (loadMoreWrap) {
                    loadMoreWrap.style.display = '';
                }

                var fd = new FormData();
                fd.append('action', 'roden_load_more_results');
                fd.append('offset', 0);
                fd.append('exclude', btn ? btn.getAttribute('data-exclude') : '');
                if (category) fd.append('category', category);

                fetch(ajaxUrl, { method: 'POST', body: fd })
                .then(function(r){ return r.json(); })
                .then(function(data){
                    if (data.success && data.data.html) {
                        grid.innerHTML = data.data.html;
                        if (btn) {
                            btn.setAttribute('data-offset', data.data.count);
                            btn.disabled = false;
                            btn.textContent = 'Load More Results';
                        }
                        if (shownEl) shownEl.textContent = data.data.count + 1;
                        if (data.data.count < 20 && loadMoreWrap) {
                            loadMoreWrap.style.display = 'none';
                        }
                    } else {
                        grid.innerHTML = '<p class="no-results-msg">No case results found in this category.</p>';
                        if (loadMoreWrap) loadMoreWrap.style.display = 'none';
                    }
                });
            });
        });

        // Load More button
        if (!btn) return;

        btn.addEventListener('click', function() {
            var offset = parseInt(btn.getAttribute('data-offset'), 10);
            var exclude = btn.getAttribute('data-exclude');
            btn.disabled = true;
            btn.textContent = 'Loading…';

            var fd = new FormData();
            fd.append('action', 'roden_load_more_results');
            fd.append('offset', offset);
            fd.append('exclude', exclude);
            if (activeCategory) fd.append('category', activeCategory);

            fetch(ajaxUrl, {
                method: 'POST',
                body: fd
            })
            .then(function(r){ return r.json(); })
            .then(function(data){
                if (data.success && data.data.html) {
                    grid.insertAdjacentHTML('beforeend', data.data.html);
                    var newOffset = offset + data.data.count;
                    btn.setAttribute('data-offset', newOffset);
                    var nowShown = parseInt(shownEl.textContent, 10) + data.data.count;
                    shownEl.textContent = nowShown;

                    if (nowShown >= total || data.data.count < 20) {
                        btn.parentNode.style.display = 'none';
                    } else {
                        btn.disabled = false;
                        btn.textContent = 'Load More Results';
                    }
                } else {
                    btn.parentNode.style.display = 'none';
                }
            })
            .catch(function(){
                btn.disabled = false;
                btn.textContent = 'Load More Results';
            });
        });
    })();
    </script>
    <?php
}
