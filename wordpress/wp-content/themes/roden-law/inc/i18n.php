<?php
/**
 * Bespoke Locale Layer — Spanish (/es/) without a multilingual plugin.
 *
 * Implements the contract in I18N-SILO-CONVENTIONS.md:
 *   - /es/ subdirectory mirroring English slugs exactly
 *   - self-canonical per locale, never cross-locale
 *   - reciprocal hreflang (en / es / x-default → EN) via per-page head tags
 *
 * How Spanish content is modeled (no plugin):
 *   - ES pages are separate posts linked to their EN counterpart by meta:
 *       _roden_locale          = 'es'          (on the ES post)
 *       _roden_translation_of  = {EN post ID}  (on the ES post)
 *       _roden_translation_es  = {ES post ID}  (on the EN post)
 *   - `page` posts live as real children of the top-level 'es' page, so
 *     /es/, /es/contact/, /es/about/ resolve natively — no rewrites.
 *   - practice_area / location ES posts store an internal 'es-' slug prefix
 *     (WP requires unique slugs per type+parent); rewrite rules in
 *     inc/rewrite-rules.php and the permalink filters below map them to the
 *     public mirrored URL: /es/practice-areas/car-accident-lawyers/ etc.
 *   - Chrome strings render Spanish via gettext: the 'locale' filter below
 *     switches to es_ES on /es/ requests and load_theme_textdomain() picks
 *     up languages/es_ES.mo.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   1. LOCALE DETECTION
   ========================================================================== */

/**
 * Whether the current request is for a Spanish (/es/) URL.
 *
 * URI-based so it works before the main query resolves (textdomain loading,
 * pre_get_posts). All public ES URLs live under /es/ — internal duplicate
 * paths (/practice-areas/es-*) are 301'd to /es/ by roden_es_canonical_redirect().
 *
 * @return bool
 */
function roden_is_es_request() {
    static $is_es = null;
    if ( null !== $is_es ) {
        return $is_es;
    }
    $path  = wp_parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH ) ?: '/';
    $is_es = (bool) preg_match( '#^/es(/|$)#', $path );
    return $is_es;
}

/**
 * Current request language: 'en' or 'es'.
 *
 * @return string
 */
function roden_current_lang() {
    if ( is_admin() && ! wp_doing_ajax() ) {
        return 'en';
    }
    return roden_is_es_request() ? 'es' : 'en';
}

/**
 * Language of a post: 'en' or 'es'.
 *
 * @param int|WP_Post|null $post Post ID or object (defaults to current post).
 * @return string
 */
function roden_post_lang( $post = null ) {
    $post = get_post( $post );
    if ( ! $post ) {
        return 'en';
    }
    return 'es' === get_post_meta( $post->ID, '_roden_locale', true ) ? 'es' : 'en';
}

/**
 * Homepage URL for a language, optionally with a path appended.
 *
 * roden_lang_home_url( 'es', '/practice-areas/' ) → https://…/es/practice-areas/
 *
 * @param string $lang 'en' or 'es'.
 * @param string $path Optional path (leading slash optional).
 * @return string
 */
function roden_lang_home_url( $lang = null, $path = '/' ) {
    if ( null === $lang ) {
        $lang = roden_current_lang();
    }
    $path = '/' . ltrim( $path, '/' );
    if ( 'es' === $lang ) {
        $path = '/es' . ( '/' === $path ? '/' : $path );
    }
    return home_url( $path );
}

/**
 * Blog index URL for a language.
 *
 * The Spanish blog hub (/es/blog/) is a rewrite-driven virtual URL — there is
 * no page_for_posts post behind it — so every consumer (canonical, hreflang,
 * breadcrumbs, schema, sitemap) must build it from here to stay in agreement.
 *
 * @param string|null $lang 'en' or 'es' (defaults to current request language).
 * @return string
 */
function roden_blog_home_url( $lang = null ) {
    if ( null === $lang ) {
        $lang = roden_current_lang();
    }
    if ( 'es' === $lang ) {
        return home_url( '/es/blog/' );
    }
    return get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' );
}

/* ==========================================================================
   2. LOCALE SWITCH — Spanish gettext on /es/ requests
   ========================================================================== */

// Priority 20: runs after roden_force_en_us_locale() (priority 10) so the
// Spanish locale survives the en_US pin on English requests.
add_filter( 'locale', 'roden_es_locale_filter', 20 );
function roden_es_locale_filter( $locale ) {
    if ( ! is_admin() && roden_is_es_request() ) {
        return 'es_ES';
    }
    return $locale;
}

add_action( 'after_setup_theme', 'roden_load_textdomain' );
function roden_load_textdomain() {
    load_theme_textdomain( 'roden-law', get_template_directory() . '/languages' );
}

// <body> class for locale-scoped CSS.
add_filter( 'body_class', 'roden_es_body_class' );
function roden_es_body_class( $classes ) {
    if ( 'es' === roden_current_lang() ) {
        $classes[] = 'lang-es';
    }
    return $classes;
}

/* ==========================================================================
   3. TRANSLATION LOOKUP
   ========================================================================== */

/**
 * Get the counterpart post ID in the target language, or 0.
 *
 * @param int|WP_Post|null $post Post to translate from.
 * @param string           $lang Target language: 'en' or 'es'.
 * @return int
 */
function roden_get_translation_id( $post = null, $lang = 'es' ) {
    $post = get_post( $post );
    if ( ! $post ) {
        return 0;
    }
    if ( roden_post_lang( $post ) === $lang ) {
        return $post->ID;
    }
    $meta_key = ( 'es' === $lang ) ? '_roden_translation_es' : '_roden_translation_of';
    $id       = (int) get_post_meta( $post->ID, $meta_key, true );
    return ( $id && 'publish' === get_post_status( $id ) ) ? $id : 0;
}

/**
 * URL of the counterpart page in the target language. Falls back to that
 * language's homepage when no translation exists — never a dead link.
 *
 * @param string           $lang Target language.
 * @param int|WP_Post|null $post Post context (defaults to queried object).
 * @return string
 */
function roden_translation_url( $lang, $post = null ) {
    if ( null === $post && is_singular() ) {
        $post = get_queried_object();
    }
    if ( $post instanceof WP_Post ) {
        $id = roden_get_translation_id( $post, $lang );
        if ( $id ) {
            return roden_get_canonical_url( $id );
        }
    }
    return roden_lang_home_url( $lang );
}

/* ==========================================================================
   4. PERMALINKS — ES posts emit their public /es/ mirrored URL
   ========================================================================== */

/**
 * Strip the internal 'es-' slug prefix used to satisfy WP slug uniqueness.
 *
 * @param string $slug Post slug.
 * @return string
 */
function roden_strip_es_slug( $slug ) {
    return preg_replace( '/^es-/', '', (string) $slug );
}

// Priority 20 — after roden_pa_permalink (10), which already routes child
// practice_area posts through roden_get_canonical_url(); this catches the
// remaining ES CPT posts (top-level pillars, locations).
add_filter( 'post_type_link', 'roden_es_post_type_link', 20, 2 );
// Blog posts use the 'post_link' filter (not 'post_type_link') — same mapping,
// so ES blog posts emit /es/blog/{slug}/ in the sitemap, feeds, and templates.
add_filter( 'post_link', 'roden_es_post_type_link', 20, 2 );
function roden_es_post_type_link( $url, $post ) {
    if ( $post instanceof WP_Post
        && 'es' === roden_post_lang( $post )
        && function_exists( 'roden_get_canonical_url' )
    ) {
        return roden_get_canonical_url( $post );
    }
    return $url;
}

/* ==========================================================================
   5. CANONICAL REDIRECT — internal es- URLs 301 to the public /es/ URL
   ========================================================================== */

// WordPress still resolves the internal path (/practice-areas/es-car-accident-lawyers/)
// for ES CPT posts; 301 it to the single public /es/ URL so each page serves
// exactly one 200 URL (I18N conventions §1).
add_action( 'template_redirect', 'roden_es_canonical_redirect', 3 );
function roden_es_canonical_redirect() {
    if ( ! is_singular() || is_admin() ) {
        return;
    }
    $post = get_queried_object();
    if ( ! $post instanceof WP_Post || 'es' !== roden_post_lang( $post ) ) {
        return;
    }
    // Pages under the 'es' parent already live at their canonical native path.
    if ( 'page' === $post->post_type ) {
        return;
    }
    $request_path   = untrailingslashit( wp_parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH ) ?: '/' );
    $canonical_path = untrailingslashit( wp_parse_url( roden_get_canonical_url( $post ), PHP_URL_PATH ) ?: '/' );
    if ( $request_path !== $canonical_path ) {
        wp_safe_redirect( roden_get_canonical_url( $post ), 301 );
        exit;
    }
}

/* ==========================================================================
   6. QUERY HYGIENE — keep ES posts out of English listings
   ========================================================================== */

/**
 * Meta query clause excluding Spanish posts. Reusable in template queries
 * (grids, related-content lists) that would otherwise sweep in ES posts.
 *
 * @return array
 */
function roden_es_exclusion_meta_query() {
    return array(
        'relation' => 'OR',
        array( 'key' => '_roden_locale', 'compare' => 'NOT EXISTS' ),
        array( 'key' => '_roden_locale', 'value' => 'es', 'compare' => '!=' ),
    );
}

// Main queries: archives, search, blog home. Singular queries resolve by
// path and can't cross locales; the sitemap runs its own queries and must
// include ES URLs, so it is intentionally untouched.
add_action( 'pre_get_posts', 'roden_es_filter_main_query' );
function roden_es_filter_main_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() || $query->is_singular() ) {
        return;
    }
    if ( roden_is_es_request() ) {
        // ES archive requests (/es/blog/) list only Spanish posts.
        $query->set( 'meta_query', array(
            array( 'key' => '_roden_locale', 'value' => 'es' ),
        ) );
        return;
    }
    $clause   = roden_es_exclusion_meta_query();
    $existing = $query->get( 'meta_query' );
    if ( ! empty( $existing ) ) {
        $query->set( 'meta_query', array( 'relation' => 'AND', $existing, $clause ) );
    } else {
        $query->set( 'meta_query', $clause );
    }
}

/* ==========================================================================
   7. HREFLANG — reciprocal en / es / x-default head tags
   ========================================================================== */

// Priority 2: after canonical/schema (1), before styles.
add_action( 'wp_head', 'roden_output_hreflang', 2 );
function roden_output_hreflang() {
    if ( is_404() || is_search() ) {
        return;
    }

    // Blog hub pair: /blog/ ↔ /es/blog/. Page 1 only — paginated views have
    // no 1:1 counterpart (the two locales paginate independently).
    if ( is_home() ) {
        if ( ! roden_es_enabled() || (int) get_query_var( 'paged', 0 ) >= 2 ) {
            return;
        }
        $urls = array(
            'en'        => roden_blog_home_url( 'en' ),
            'es'        => roden_blog_home_url( 'es' ),
            'x-default' => roden_blog_home_url( 'en' ),
        );
        foreach ( $urls as $code => $url ) {
            echo '<link rel="alternate" hreflang="' . esc_attr( $code ) . '" href="' . esc_url( $url ) . '" />' . "\n";
        }
        return;
    }

    // Static hub pairs: the EN side of /practice-areas/, /locations/, and
    // /resources/ is a CPT archive or unpaired page — no post meta can link
    // it to its ES twin page, so these three pairs match by path.
    $hub_paths = array( '/practice-areas/', '/locations/', '/resources/' );
    $req_path  = trailingslashit( wp_parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH ) ?: '/' );
    $base_path = preg_replace( '#^/es/#', '/', $req_path );
    if ( roden_es_enabled() && in_array( $base_path, $hub_paths, true ) ) {
        $urls = array(
            'en'        => home_url( $base_path ),
            'es'        => home_url( '/es' . $base_path ),
            'x-default' => home_url( $base_path ),
        );
        foreach ( $urls as $code => $url ) {
            echo '<link rel="alternate" hreflang="' . esc_attr( $code ) . '" href="' . esc_url( $url ) . '" />' . "\n";
        }
        return;
    }

    if ( ! is_singular() ) {
        return;
    }
    if ( function_exists( 'roden_is_noindex_landing' ) && roden_is_noindex_landing() ) {
        return;
    }

    $post = get_queried_object();
    if ( ! $post instanceof WP_Post ) {
        return;
    }

    $lang       = roden_post_lang( $post );
    $other_lang = ( 'es' === $lang ) ? 'en' : 'es';
    $other_id   = roden_get_translation_id( $post, $other_lang );

    // Only emit a cluster when a real translation pair exists.
    if ( ! $other_id ) {
        return;
    }

    $self_url  = roden_get_canonical_url( $post );
    $other_url = roden_get_canonical_url( $other_id );

    $urls = array(
        $lang       => $self_url,
        $other_lang => $other_url,
    );
    // x-default always points at the English page (default-locale fallback).
    $urls['x-default'] = $urls['en'];

    foreach ( array( 'en', 'es', 'x-default' ) as $code ) {
        if ( ! empty( $urls[ $code ] ) ) {
            echo '<link rel="alternate" hreflang="' . esc_attr( $code ) . '" href="' . esc_url( $urls[ $code ] ) . '" />' . "\n";
        }
    }
}

/* ==========================================================================
   8. LANGUAGE SWITCHER (rendered from header.php / footer.php)
   ========================================================================== */

/**
 * Whether the Spanish site is live: a published top-level 'es' page exists.
 * Gates the language switcher so the EN site never links to a 404 /es/
 * while Spanish content is still in draft review.
 *
 * @return bool
 */
function roden_es_enabled() {
    static $enabled = null;
    if ( null === $enabled ) {
        $page    = get_page_by_path( 'es' );
        $enabled = ( $page && 'publish' === $page->post_status );
    }
    return $enabled;
}

/**
 * Render the EN | ES language switcher.
 *
 * Links to the counterpart page when a translation exists, otherwise to the
 * other language's homepage. Renders nothing until the ES site is live.
 *
 * @param string $context 'topbar' | 'footer' — CSS hook only.
 */
function roden_language_switcher( $context = 'topbar' ) {
    if ( ! roden_es_enabled() ) {
        return;
    }
    $current = roden_current_lang();
    $langs   = array(
        'en' => __( 'English', 'roden-law' ),
        'es' => __( 'Español', 'roden-law' ),
    );
    ?>
    <nav class="lang-switcher lang-switcher--<?php echo esc_attr( $context ); ?>"
         aria-label="<?php esc_attr_e( 'Language', 'roden-law' ); ?>">
        <?php foreach ( $langs as $code => $label ) :
            $is_current = ( $code === $current );
            $url        = $is_current ? '' : roden_translation_url( $code );
            ?>
            <?php if ( $is_current ) : ?>
                <span class="lang-switcher-item is-current" aria-current="true"
                      title="<?php echo esc_attr( $label ); ?>"><?php echo esc_html( strtoupper( $code ) ); ?></span>
            <?php else : ?>
                <a class="lang-switcher-item" href="<?php echo esc_url( $url ); ?>"
                   hreflang="<?php echo esc_attr( $code ); ?>" lang="<?php echo esc_attr( $code ); ?>"
                   title="<?php echo esc_attr( $label ); ?>"><?php echo esc_html( strtoupper( $code ) ); ?></a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
    <?php
}

// Append an Español/English item to the primary nav so the switcher is
// reachable inside the mobile hamburger menu (the top bar collapses there).
add_filter( 'wp_nav_menu_items', 'roden_inject_lang_switcher_nav_item', 20, 2 );
function roden_inject_lang_switcher_nav_item( $items, $args ) {
    if ( ! roden_es_enabled() ) {
        return $items;
    }
    $location = $args->theme_location ?? '';
    if ( ! in_array( $location, array( 'primary', 'primary_es', 'mobile' ), true ) ) {
        return $items;
    }
    $current = roden_current_lang();
    $target  = ( 'es' === $current ) ? 'en' : 'es';
    $label   = ( 'es' === $current ) ? __( 'English', 'roden-law' ) : __( 'Español', 'roden-law' );
    $url     = roden_translation_url( $target );

    $items .= "\n" . '<li class="menu-item menu-item-lang-switch"><a href="' . esc_url( $url ) . '" hreflang="' . esc_attr( $target ) . '" lang="' . esc_attr( $target ) . '">' . esc_html( $label ) . '</a></li>';
    return $items;
}

/* ==========================================================================
   8b. ES HOMEPAGE TEMPLATE — mirror the English homepage design
   ========================================================================== */

// The 'es' root page renders through front-page.php (the full homepage
// layout: hero + form, badges, how-it-works, PA grid, offices, founder,
// results, testimonials, attorneys, CTA). All of its chrome is gettext, so
// it comes out in Spanish; locale-aware links inside the template point the
// grids at /es/ pages. Priority 20 — before the CPT bridge at 1001, after
// core template resolution.
/**
 * Whether the current request is the Spanish homepage (/es/) — a regular
 * page (post_name 'es', no parent, locale es) rendered with front-page.php,
 * so is_front_page() is FALSE for it. Schema and template code that wants
 * homepage treatment for /es/ must use this instead.
 *
 * @return bool
 */
function roden_is_es_home() {
    if ( ! is_page() || 'es' !== roden_current_lang() ) {
        return false;
    }
    $post = get_queried_object();
    return $post instanceof WP_Post
        && 'es' === $post->post_name
        && 0 === (int) $post->post_parent
        && 'es' === roden_post_lang( $post );
}

add_filter( 'template_include', 'roden_es_home_template', 20 );
function roden_es_home_template( $template ) {
    if ( roden_is_es_home() ) {
        $home = get_template_directory() . '/front-page.php';
        if ( file_exists( $home ) ) {
            return $home;
        }
    }
    return $template;
}

/* ==========================================================================
   9. ES NAV MENU LOCATIONS
   ========================================================================== */

add_action( 'after_setup_theme', 'roden_register_es_nav_menus', 11 );
function roden_register_es_nav_menus() {
    register_nav_menus( array(
        'primary_es' => __( 'Primary Navigation (Español)', 'roden-law' ),
        'footer_es'  => __( 'Footer Navigation (Español)', 'roden-law' ),
    ) );
}

/**
 * Theme location for the primary nav, per request language. When no menu is
 * assigned to primary_es, wp_nav_menu() falls through to the fallback_cb,
 * which renders the curated Spanish menu (see roden_fallback_menu()).
 *
 * @return string
 */
function roden_primary_nav_location() {
    return ( 'es' === roden_current_lang() ) ? 'primary_es' : 'primary';
}

/* ==========================================================================
   10. GA4 — site_language dataLayer variable
   ========================================================================== */

// Before GTM loads (roden_gtm_head is priority 1 on wp_head; this is 0).
add_action( 'wp_head', 'roden_datalayer_site_language', 0 );
function roden_datalayer_site_language() {
    echo '<script>window.dataLayer = window.dataLayer || []; window.dataLayer.push({"site_language":"' . esc_js( roden_current_lang() ) . '"});</script>' . "\n";
}

/* ==========================================================================
   11. NOINDEX + SITEMAP EXCLUSION for /es/gracias/
   ========================================================================== */

// The Spanish thank-you page mirrors /thank-you/: noindex, out of the sitemap.
add_filter( 'wp_robots', 'roden_es_gracias_noindex' );
function roden_es_gracias_noindex( $robots ) {
    if ( is_page( 'gracias' ) ) {
        $robots['noindex']  = true;
        $robots['nofollow'] = true;
    }
    return $robots;
}

/* ==========================================================================
   12. SITEMAP — virtual ES hub URLs (no post behind them)
   ========================================================================== */

// /es/blog/ is rewrite-driven (no page_for_posts post), so WP's core post/page
// sitemap providers never see it. Register a tiny provider for ES hub URLs
// that exist only as rewrites — without this the ES blog silo has no
// sitemap-listed entry point.
add_action( 'wp_sitemaps_init', 'roden_register_es_sitemap_provider' );
function roden_register_es_sitemap_provider( $sitemaps ) {
    if ( ! class_exists( 'WP_Sitemaps_Provider' ) || ! roden_es_enabled() ) {
        return;
    }

    // Name must be plain [a-z]+ — core's sitemap rewrite patterns parse
    // hyphenated names as provider-subtype and the URL 404s to HTML.
    $provider = new class() extends WP_Sitemaps_Provider {
        public function __construct() {
            $this->name        = 'eshubs';
            $this->object_type = 'eshubs';
        }

        public function get_url_list( $page_num, $object_subtype = '' ) {
            if ( $page_num > 1 ) {
                return array();
            }
            return array(
                array( 'loc' => roden_blog_home_url( 'es' ) ),
            );
        }

        public function get_max_num_pages( $object_subtype = '' ) {
            return 1;
        }
    };

    // NOTE: $name/$object_type are protected on WP_Sitemaps_Provider — never
    // read them from outside the instance (fatals on every request).
    $sitemaps->registry->add_provider( 'eshubs', $provider );
}
