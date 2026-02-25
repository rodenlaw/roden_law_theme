<?php
/**
 * Roden Law Theme Functions
 *
 * Core engine: loads modular inc/ files, handles theme setup,
 * asset enqueue, meta boxes, schema markup, and widget areas.
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

    register_nav_menus( array(
        'primary'   => __( 'Primary Navigation', 'roden-law' ),
        'footer'    => __( 'Footer Navigation', 'roden-law' ),
        'mobile'    => __( 'Mobile Navigation', 'roden-law' ),
    ) );

    add_image_size( 'attorney-headshot', 400, 533, true );
    add_image_size( 'card-thumb', 600, 400, true );
    add_image_size( 'hero-bg', 1920, 800, true );
}

/* ==========================================================================
   3. ENQUEUE STYLES & SCRIPTS
   ========================================================================== */

add_action( 'wp_enqueue_scripts', 'roden_enqueue_assets' );
function roden_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style(
        'roden-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Merriweather:wght@700;800;900&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'roden-style',
        get_stylesheet_uri(),
        array( 'roden-google-fonts' ),
        wp_get_theme()->get( 'Version' )
    );

    // Mobile navigation toggle
    wp_enqueue_script(
        'roden-navigation',
        get_template_directory_uri() . '/js/navigation.js',
        array(),
        wp_get_theme()->get( 'Version' ),
        true
    );
}

/* ==========================================================================
   4. META BOXES
   ========================================================================== */

add_action( 'add_meta_boxes', 'roden_add_meta_boxes' );
function roden_add_meta_boxes() {

    // Office Key — for location pages
    add_meta_box(
        'roden_office_key',
        __( 'Office Configuration', 'roden-law' ),
        'roden_office_key_meta_box',
        'location',
        'side'
    );

    // PA Office Key — for intersection pages (practice_area CPT)
    add_meta_box(
        'roden_pa_office_key',
        __( 'Intersection Office Key', 'roden-law' ),
        'roden_pa_office_key_meta_box',
        'practice_area',
        'side'
    );

    // Jurisdiction — for practice areas and locations
    add_meta_box(
        'roden_jurisdiction',
        __( 'Jurisdiction', 'roden-law' ),
        'roden_jurisdiction_meta_box',
        array( 'practice_area', 'location' ),
        'side'
    );

    // FAQs — for practice area pages
    add_meta_box(
        'roden_faqs',
        __( 'FAQs (generates FAQPage schema)', 'roden-law' ),
        'roden_faqs_meta_box',
        'practice_area',
        'normal',
        'high'
    );

    // Bar Admissions — for attorneys
    add_meta_box(
        'roden_bar_admissions',
        __( 'Bar Admissions', 'roden-law' ),
        'roden_bar_admissions_meta_box',
        'attorney',
        'side'
    );

    // Case Result Details
    add_meta_box(
        'roden_case_details',
        __( 'Case Result Details', 'roden-law' ),
        'roden_case_details_meta_box',
        'case_result',
        'normal',
        'high'
    );

    // Location — Service Area
    add_meta_box(
        'roden_service_area',
        __( 'Service Area', 'roden-law' ),
        'roden_service_area_meta_box',
        'location',
        'normal'
    );

    // Location — Map Embed URL
    add_meta_box(
        'roden_map_embed',
        __( 'Google Maps Embed URL', 'roden-law' ),
        'roden_map_embed_meta_box',
        'location',
        'side'
    );

    // Location — Local Content
    add_meta_box(
        'roden_local_content',
        __( 'Local Content (courts, institutions)', 'roden-law' ),
        'roden_local_content_meta_box',
        'location',
        'normal'
    );

    // Attorney — Office Key
    add_meta_box(
        'roden_atty_office_key',
        __( 'Office Assignment', 'roden-law' ),
        'roden_atty_office_key_meta_box',
        'attorney',
        'side'
    );
}

/** Office Key meta box callback. */
function roden_office_key_meta_box( $post ) {
    wp_nonce_field( 'roden_office_key_nonce', '_roden_office_key_nonce' );
    $value = get_post_meta( $post->ID, '_roden_office_key', true );
    $firm  = roden_firm_data();
    ?>
    <p>
        <label for="roden_office_key"><?php esc_html_e( 'Office:', 'roden-law' ); ?></label><br>
        <select id="roden_office_key" name="_roden_office_key" style="width:100%;">
            <option value=""><?php esc_html_e( '— Select Office —', 'roden-law' ); ?></option>
            <?php foreach ( $firm['offices'] as $key => $office ) : ?>
                <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $value, $key ); ?>>
                    <?php echo esc_html( $office['city'] . ', ' . $office['state'] ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <p class="description"><?php esc_html_e( 'Links this location page to firm data config.', 'roden-law' ); ?></p>
    <?php
}

/** PA Office Key meta box callback (for intersection pages). */
function roden_pa_office_key_meta_box( $post ) {
    wp_nonce_field( 'roden_pa_office_key_nonce', '_roden_pa_office_key_nonce' );
    $value = get_post_meta( $post->ID, '_roden_pa_office_key', true );
    $firm  = roden_firm_data();
    ?>
    <p>
        <label for="roden_pa_office_key"><?php esc_html_e( 'Office (intersection pages only):', 'roden-law' ); ?></label><br>
        <select id="roden_pa_office_key" name="_roden_pa_office_key" style="width:100%;">
            <option value=""><?php esc_html_e( '— None (pillar or sub-type) —', 'roden-law' ); ?></option>
            <?php foreach ( $firm['offices'] as $key => $office ) : ?>
                <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $value, $key ); ?>>
                    <?php echo esc_html( $office['city'] . ', ' . $office['state'] . ' (' . $key . ')' ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <p class="description"><?php esc_html_e( 'Set this for intersection pages (PA x Location). Leave blank for pillar or sub-type pages.', 'roden-law' ); ?></p>
    <?php
}

/** Jurisdiction meta box callback. */
function roden_jurisdiction_meta_box( $post ) {
    wp_nonce_field( 'roden_jurisdiction_nonce', '_roden_jurisdiction_nonce' );
    $value = get_post_meta( $post->ID, '_roden_jurisdiction', true );
    ?>
    <p>
        <label for="roden_jurisdiction"><?php esc_html_e( 'State:', 'roden-law' ); ?></label><br>
        <select id="roden_jurisdiction" name="_roden_jurisdiction" style="width:100%;">
            <option value=""><?php esc_html_e( '— Select State —', 'roden-law' ); ?></option>
            <option value="GA" <?php selected( $value, 'GA' ); ?>><?php esc_html_e( 'Georgia', 'roden-law' ); ?></option>
            <option value="SC" <?php selected( $value, 'SC' ); ?>><?php esc_html_e( 'South Carolina', 'roden-law' ); ?></option>
        </select>
    </p>
    <p class="description"><?php esc_html_e( 'Controls statute of limitations and comparative fault display.', 'roden-law' ); ?></p>
    <?php
}

/** FAQs meta box callback. */
function roden_faqs_meta_box( $post ) {
    wp_nonce_field( 'roden_faqs_nonce', '_roden_faqs_nonce' );
    $faqs = get_post_meta( $post->ID, '_roden_faqs', true );
    if ( ! is_array( $faqs ) || empty( $faqs ) ) {
        $faqs = array( array( 'question' => '', 'answer' => '' ) );
    }
    ?>
    <div id="roden-faq-container">
        <?php foreach ( $faqs as $i => $faq ) : ?>
            <div class="roden-faq-row" style="margin-bottom:15px;padding:10px;background:#f9f9f9;border:1px solid #ddd;">
                <p>
                    <label><strong><?php printf( __( 'Question %d:', 'roden-law' ), $i + 1 ); ?></strong></label><br>
                    <input type="text" name="_roden_faqs[<?php echo (int) $i; ?>][question]"
                           value="<?php echo esc_attr( $faq['question'] ?? '' ); ?>" style="width:100%;">
                </p>
                <p>
                    <label><strong><?php esc_html_e( 'Answer:', 'roden-law' ); ?></strong></label><br>
                    <textarea name="_roden_faqs[<?php echo (int) $i; ?>][answer]"
                              rows="3" style="width:100%;"><?php echo esc_textarea( $faq['answer'] ?? '' ); ?></textarea>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button" onclick="rodenAddFaq()"><?php esc_html_e( '+ Add FAQ', 'roden-law' ); ?></button>
    <script>
    function rodenAddFaq() {
        var c = document.getElementById('roden-faq-container');
        var n = c.querySelectorAll('.roden-faq-row').length;
        var d = document.createElement('div');
        d.className = 'roden-faq-row';
        d.style.cssText = 'margin-bottom:15px;padding:10px;background:#f9f9f9;border:1px solid #ddd;';
        d.innerHTML = '<p><label><strong>Question ' + (n + 1) + ':</strong></label><br>' +
            '<input type="text" name="_roden_faqs[' + n + '][question]" value="" style="width:100%;"></p>' +
            '<p><label><strong>Answer:</strong></label><br>' +
            '<textarea name="_roden_faqs[' + n + '][answer]" rows="3" style="width:100%;"></textarea></p>';
        c.appendChild(d);
    }
    </script>
    <?php
}

/** Bar Admissions meta box callback. */
function roden_bar_admissions_meta_box( $post ) {
    wp_nonce_field( 'roden_bar_admissions_nonce', '_roden_bar_admissions_nonce' );
    $value = get_post_meta( $post->ID, '_roden_bar_admissions', true );
    ?>
    <p>
        <label for="roden_bar_admissions"><?php esc_html_e( 'Bar Admissions (one per line):', 'roden-law' ); ?></label><br>
        <textarea id="roden_bar_admissions" name="_roden_bar_admissions"
                  rows="4" style="width:100%;"><?php echo esc_textarea( $value ); ?></textarea>
    </p>
    <p class="description"><?php esc_html_e( 'Example: Georgia Bar, South Carolina Bar', 'roden-law' ); ?></p>
    <?php
}

/** Case Details meta box callback. */
function roden_case_details_meta_box( $post ) {
    wp_nonce_field( 'roden_case_details_nonce', '_roden_case_details_nonce' );
    $amount = get_post_meta( $post->ID, '_roden_case_amount', true );
    $type   = get_post_meta( $post->ID, '_roden_case_type', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="roden_case_amount"><?php esc_html_e( 'Amount ($)', 'roden-law' ); ?></label></th>
            <td><input type="text" id="roden_case_amount" name="_roden_case_amount"
                       value="<?php echo esc_attr( $amount ); ?>" placeholder="e.g. 27000000" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="roden_case_type"><?php esc_html_e( 'Case Type', 'roden-law' ); ?></label></th>
            <td><input type="text" id="roden_case_type" name="_roden_case_type"
                       value="<?php echo esc_attr( $type ); ?>" placeholder="e.g. Truck Accident Settlement" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

/** Service Area meta box callback. */
function roden_service_area_meta_box( $post ) {
    wp_nonce_field( 'roden_service_area_nonce', '_roden_service_area_nonce' );
    $value = get_post_meta( $post->ID, '_roden_service_area', true );
    ?>
    <p>
        <label for="roden_service_area"><?php esc_html_e( 'Service area description (overrides firm-data default if set):', 'roden-law' ); ?></label><br>
        <textarea id="roden_service_area" name="_roden_service_area"
                  rows="3" style="width:100%;"><?php echo esc_textarea( $value ); ?></textarea>
    </p>
    <p class="description"><?php esc_html_e( 'List surrounding cities and neighborhoods this office serves.', 'roden-law' ); ?></p>
    <?php
}

/** Map Embed URL meta box callback. */
function roden_map_embed_meta_box( $post ) {
    wp_nonce_field( 'roden_map_embed_nonce', '_roden_map_embed_nonce' );
    $value = get_post_meta( $post->ID, '_roden_map_embed', true );
    ?>
    <p>
        <label for="roden_map_embed"><?php esc_html_e( 'Custom Map Embed URL:', 'roden-law' ); ?></label><br>
        <input type="url" id="roden_map_embed" name="_roden_map_embed"
               value="<?php echo esc_attr( $value ); ?>" style="width:100%;"
               placeholder="https://maps.google.com/maps?q=...&output=embed">
    </p>
    <p class="description"><?php esc_html_e( 'Leave blank to auto-generate from office address.', 'roden-law' ); ?></p>
    <?php
}

/** Local Content meta box callback (wysiwyg). */
function roden_local_content_meta_box( $post ) {
    wp_nonce_field( 'roden_local_content_nonce', '_roden_local_content_nonce' );
    $value = get_post_meta( $post->ID, '_roden_local_content', true );
    wp_editor( $value, 'roden_local_content_editor', array(
        'textarea_name' => '_roden_local_content',
        'textarea_rows' => 8,
        'media_buttons' => false,
        'teeny'         => true,
    ) );
    ?>
    <p class="description"><?php esc_html_e( 'Additional content about local courts, institutions, and community ties.', 'roden-law' ); ?></p>
    <?php
}

/** Attorney Office Key meta box callback. */
function roden_atty_office_key_meta_box( $post ) {
    wp_nonce_field( 'roden_atty_office_key_nonce', '_roden_atty_office_key_nonce' );
    $value = get_post_meta( $post->ID, '_roden_atty_office_key', true );
    $firm  = roden_firm_data();
    ?>
    <p>
        <label for="roden_atty_office_key"><?php esc_html_e( 'Primary Office:', 'roden-law' ); ?></label><br>
        <select id="roden_atty_office_key" name="_roden_atty_office_key" style="width:100%;">
            <option value=""><?php esc_html_e( '— Select Office —', 'roden-law' ); ?></option>
            <?php foreach ( $firm['offices'] as $key => $office ) : ?>
                <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $value, $key ); ?>>
                    <?php echo esc_html( $office['city'] . ', ' . $office['state'] . ' (' . $key . ')' ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <p class="description"><?php esc_html_e( 'Assigns this attorney to an office for location page filtering.', 'roden-law' ); ?></p>
    <?php
}

/* ---------- Save Meta Fields ---------- */

add_action( 'save_post', 'roden_save_meta_fields' );
function roden_save_meta_fields( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // PA Office Key (intersection pages)
    if ( isset( $_POST['_roden_pa_office_key_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_pa_office_key_nonce'], 'roden_pa_office_key_nonce' ) ) {
        update_post_meta( $post_id, '_roden_pa_office_key',
            sanitize_text_field( $_POST['_roden_pa_office_key'] ?? '' ) );
    }

    // Office Key
    if ( isset( $_POST['_roden_office_key_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_office_key_nonce'], 'roden_office_key_nonce' ) ) {
        update_post_meta( $post_id, '_roden_office_key',
            sanitize_text_field( $_POST['_roden_office_key'] ?? '' ) );
    }

    // Jurisdiction
    if ( isset( $_POST['_roden_jurisdiction_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_jurisdiction_nonce'], 'roden_jurisdiction_nonce' ) ) {
        $jurisdiction = sanitize_text_field( $_POST['_roden_jurisdiction'] ?? '' );
        if ( in_array( $jurisdiction, array( 'GA', 'SC', '' ), true ) ) {
            update_post_meta( $post_id, '_roden_jurisdiction', $jurisdiction );
        }
    }

    // FAQs
    if ( isset( $_POST['_roden_faqs_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_faqs_nonce'], 'roden_faqs_nonce' ) ) {
        $raw_faqs = $_POST['_roden_faqs'] ?? array();
        $clean    = array();
        if ( is_array( $raw_faqs ) ) {
            foreach ( $raw_faqs as $faq ) {
                $q = sanitize_text_field( $faq['question'] ?? '' );
                $a = sanitize_textarea_field( $faq['answer'] ?? '' );
                if ( $q && $a ) {
                    $clean[] = array( 'question' => $q, 'answer' => $a );
                }
            }
        }
        update_post_meta( $post_id, '_roden_faqs', $clean );
    }

    // Bar Admissions
    if ( isset( $_POST['_roden_bar_admissions_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_bar_admissions_nonce'], 'roden_bar_admissions_nonce' ) ) {
        update_post_meta( $post_id, '_roden_bar_admissions',
            sanitize_textarea_field( $_POST['_roden_bar_admissions'] ?? '' ) );
    }

    // Case Details
    if ( isset( $_POST['_roden_case_details_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_case_details_nonce'], 'roden_case_details_nonce' ) ) {
        update_post_meta( $post_id, '_roden_case_amount',
            sanitize_text_field( $_POST['_roden_case_amount'] ?? '' ) );
        update_post_meta( $post_id, '_roden_case_type',
            sanitize_text_field( $_POST['_roden_case_type'] ?? '' ) );
    }

    // Service Area
    if ( isset( $_POST['_roden_service_area_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_service_area_nonce'], 'roden_service_area_nonce' ) ) {
        update_post_meta( $post_id, '_roden_service_area',
            sanitize_textarea_field( $_POST['_roden_service_area'] ?? '' ) );
    }

    // Map Embed URL
    if ( isset( $_POST['_roden_map_embed_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_map_embed_nonce'], 'roden_map_embed_nonce' ) ) {
        update_post_meta( $post_id, '_roden_map_embed',
            esc_url_raw( $_POST['_roden_map_embed'] ?? '' ) );
    }

    // Local Content (wysiwyg — allow safe HTML)
    if ( isset( $_POST['_roden_local_content_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_local_content_nonce'], 'roden_local_content_nonce' ) ) {
        update_post_meta( $post_id, '_roden_local_content',
            wp_kses_post( $_POST['_roden_local_content'] ?? '' ) );
    }

    // Attorney Office Key
    if ( isset( $_POST['_roden_atty_office_key_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_atty_office_key_nonce'], 'roden_atty_office_key_nonce' ) ) {
        update_post_meta( $post_id, '_roden_atty_office_key',
            sanitize_text_field( $_POST['_roden_atty_office_key'] ?? '' ) );
    }
}

/* ==========================================================================
   5. SCHEMA MARKUP — JSON-LD
   ========================================================================== */

add_action( 'wp_head', 'roden_output_schema', 1 );
function roden_output_schema() {
    $firm = roden_firm_data();

    if ( is_front_page() ) {
        roden_schema_organization( $firm );
        roden_schema_legal_service( $firm );
        roden_schema_local_business_all( $firm );
        roden_schema_speakable_homepage( $firm );
        roden_schema_aggregate_rating( $firm );
        roden_schema_website( $firm );
    }

    if ( is_singular( 'practice_area' ) ) {
        roden_schema_legal_service( $firm );
        roden_schema_faq_page();
        roden_schema_speakable_practice_area();
    }

    if ( is_singular( 'location' ) ) {
        roden_schema_local_business_single( $firm );
    }

    if ( is_singular( 'attorney' ) ) {
        roden_schema_person( $firm );
    }

    if ( is_singular( 'resource' ) ) {
        roden_schema_howto();
    }

    // BreadcrumbList on all pages (except front page)
    if ( ! is_front_page() ) {
        roden_schema_breadcrumbs();
    }
}

/**
 * Output a JSON-LD script tag.
 *
 * @param array $data Schema data array.
 */
function roden_json_ld( $data ) {
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
    echo "\n" . '</script>' . "\n";
}

/* ---------- Schema Type 1: Organization / LawFirm ---------- */

function roden_schema_organization( $firm ) {
    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => array( 'Organization', 'LegalService' ),
        '@id'         => $firm['url'] . '/#organization',
        'name'        => $firm['name'],
        'legalName'   => $firm['legal_entity'],
        'url'         => $firm['url'],
        'description' => $firm['description'],
        'telephone'   => $firm['vanity_phone'],
        'foundingDate'=> $firm['founded'],
        'areaServed'  => array(
            array( '@type' => 'State', 'name' => 'Georgia' ),
            array( '@type' => 'State', 'name' => 'South Carolina' ),
        ),
        'sameAs' => array_values( $firm['social'] ),
    );

    // Add logo if custom logo is set
    $logo_id = get_theme_mod( 'custom_logo' );
    if ( $logo_id ) {
        $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
        if ( $logo_url ) {
            $schema['logo'] = array(
                '@type'      => 'ImageObject',
                'url'        => $logo_url,
                'contentUrl' => $logo_url,
            );
            $schema['image'] = $logo_url;
        }
    }

    // Add all offices as locations
    $locations = array();
    foreach ( $firm['offices'] as $key => $office ) {
        $locations[] = array(
            '@type' => 'LocalBusiness',
            'name'  => $firm['name'] . ' — ' . $office['city'],
            'address' => array(
                '@type'           => 'PostalAddress',
                'streetAddress'   => $office['street'],
                'addressLocality' => $office['city'],
                'addressRegion'   => $office['state'],
                'postalCode'      => $office['zip'],
                'addressCountry'  => 'US',
            ),
            'telephone' => $office['phone'],
            'geo' => array(
                '@type'     => 'GeoCoordinates',
                'latitude'  => $office['latitude'],
                'longitude' => $office['longitude'],
            ),
        );
    }
    $schema['location'] = $locations;

    roden_json_ld( $schema );
}

/* ---------- Schema Type 2: LegalService ---------- */

function roden_schema_legal_service( $firm ) {
    $schema = array(
        '@context'       => 'https://schema.org',
        '@type'          => 'LegalService',
        '@id'            => $firm['url'] . '/#legalservice',
        'name'           => $firm['name'],
        'url'            => $firm['url'],
        'description'    => $firm['description'],
        'telephone'      => $firm['vanity_phone'],
        'priceRange'     => 'Free Consultation',
        'areaServed'     => array(
            array( '@type' => 'State', 'name' => 'Georgia' ),
            array( '@type' => 'State', 'name' => 'South Carolina' ),
        ),
        'serviceType'    => 'Personal Injury Law',
        'knowsAbout'     => array(
            'Car Accidents', 'Truck Accidents', 'Slip and Fall',
            'Motorcycle Accidents', 'Medical Malpractice', 'Wrongful Death',
            'Workers Compensation', 'Dog Bites', 'Brain Injuries',
            'Spinal Cord Injuries', 'Maritime Injuries', 'Product Liability',
            'Boating Accidents', 'Burn Injuries', 'Construction Accidents',
            'Nursing Home Abuse', 'Premises Liability', 'Pedestrian Accidents',
        ),
    );

    // On singular practice area, add specific service info
    if ( is_singular( 'practice_area' ) ) {
        $schema['name']        = get_the_title() . ' — ' . $firm['name'];
        $schema['url']         = get_permalink();
        $schema['description'] = get_the_excerpt() ?: wp_trim_words( get_the_content(), 30 );
    }

    roden_json_ld( $schema );
}

/* ---------- Schema Type 3: LocalBusiness (all offices — homepage) ---------- */

function roden_schema_local_business_all( $firm ) {
    foreach ( $firm['offices'] as $key => $office ) {
        roden_schema_local_business_office( $firm, $key, $office );
    }
}

/* ---------- Schema Type 3b: LocalBusiness (single office — location page) ---------- */

function roden_schema_local_business_single( $firm ) {
    $office_key = get_post_meta( get_the_ID(), '_roden_office_key', true );
    if ( ! $office_key || ! isset( $firm['offices'][ $office_key ] ) ) {
        return;
    }
    roden_schema_local_business_office( $firm, $office_key, $firm['offices'][ $office_key ] );
}

/** Shared LocalBusiness builder for one office. */
function roden_schema_local_business_office( $firm, $key, $office ) {
    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => array( 'LocalBusiness', 'LegalService', 'Attorney' ),
        '@id'        => $firm['url'] . '/locations/' . $key . '/#localbusiness',
        'name'       => $firm['name'] . ' — ' . $office['city'],
        'url'        => $firm['url'] . '/locations/' . $office['state_slug'] . '/' . sanitize_title( $office['city'] ) . '/',
        'telephone'  => $office['phone'],
        'priceRange' => 'Free Consultation',
        'address'    => array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => $office['street'],
            'addressLocality' => $office['city'],
            'addressRegion'   => $office['state'],
            'postalCode'      => $office['zip'],
            'addressCountry'  => 'US',
        ),
        'geo' => array(
            '@type'     => 'GeoCoordinates',
            'latitude'  => $office['latitude'],
            'longitude' => $office['longitude'],
        ),
        'openingHoursSpecification' => array(
            array(
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
                'opens'     => '08:00',
                'closes'    => '18:00',
            ),
        ),
        'parentOrganization' => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        ),
    );

    roden_json_ld( $schema );
}

/* ---------- Schema Type 4: Person / Attorney ---------- */

function roden_schema_person( $firm ) {
    $post_id       = get_the_ID();
    $bar           = get_post_meta( $post_id, '_roden_bar_admissions', true );
    $bar_list      = $bar ? array_map( 'trim', explode( "\n", $bar ) ) : array();

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'Person',
        '@id'         => get_permalink() . '#person',
        'name'        => get_the_title(),
        'url'         => get_permalink(),
        'description' => get_the_excerpt() ?: wp_trim_words( get_the_content(), 30 ),
        'worksFor'    => array(
            '@type' => 'Organization',
            '@id'   => $firm['url'] . '/#organization',
            'name'  => $firm['name'],
        ),
    );

    if ( has_post_thumbnail() ) {
        $schema['image'] = get_the_post_thumbnail_url( $post_id, 'attorney-headshot' );
    }

    if ( ! empty( $bar_list ) ) {
        $schema['hasCredential'] = array_map( function( $admission ) {
            return array(
                '@type'          => 'EducationalOccupationalCredential',
                'credentialCategory' => 'Bar Admission',
                'name'           => $admission,
            );
        }, $bar_list );
    }

    // Try to match attorney to firm data for job title
    $slug = get_post_field( 'post_name', $post_id );
    if ( isset( $firm['attorneys'][ $slug ] ) ) {
        $schema['jobTitle'] = $firm['attorneys'][ $slug ]['title'];
    }

    roden_json_ld( $schema );
}

/* ---------- Schema Type 5: FAQPage ---------- */

function roden_schema_faq_page() {
    $faqs = get_post_meta( get_the_ID(), '_roden_faqs', true );
    if ( ! is_array( $faqs ) || empty( $faqs ) ) {
        return;
    }

    $faq_entities = array();
    foreach ( $faqs as $faq ) {
        if ( empty( $faq['question'] ) || empty( $faq['answer'] ) ) {
            continue;
        }
        $faq_entities[] = array(
            '@type'          => 'Question',
            'name'           => $faq['question'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => $faq['answer'],
            ),
        );
    }

    if ( empty( $faq_entities ) ) {
        return;
    }

    roden_json_ld( array(
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $faq_entities,
    ) );
}

/* ---------- Schema Type 6: BreadcrumbList ---------- */

function roden_schema_breadcrumbs() {
    $items    = array();
    $position = 1;

    // Home
    $items[] = array(
        '@type'    => 'ListItem',
        'position' => $position++,
        'name'     => __( 'Home', 'roden-law' ),
        'item'     => home_url( '/' ),
    );

    if ( is_singular( 'practice_area' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Practice Areas', 'roden-law' ),
            'item'     => home_url( '/practice-areas/' ),
        );

        // If this is a child (intersection or sub-type), add parent
        $post   = get_post();
        $parent = $post->post_parent;
        if ( $parent ) {
            $items[] = array(
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => get_the_title( $parent ),
                'item'     => get_permalink( $parent ),
            );
        }

        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_singular( 'location' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Locations', 'roden-law' ),
            'item'     => home_url( '/locations/' ),
        );
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_singular( 'attorney' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Attorneys', 'roden-law' ),
            'item'     => home_url( '/attorneys/' ),
        );
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_singular( 'case_result' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Case Results', 'roden-law' ),
            'item'     => home_url( '/case-results/' ),
        );
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_singular( 'resource' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => __( 'Resources', 'roden-law' ),
            'item'     => home_url( '/resources/' ),
        );
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_singular() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );

    } elseif ( is_post_type_archive() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => post_type_archive_title( '', false ),
            'item'     => get_post_type_archive_link( get_queried_object()->name ?? get_post_type() ),
        );
    }

    if ( count( $items ) < 2 ) {
        return;
    }

    roden_json_ld( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    ) );
}

/* ---------- Schema Type 7: Speakable ---------- */

function roden_schema_speakable_homepage( $firm ) {
    roden_json_ld( array(
        '@context' => 'https://schema.org',
        '@type'    => 'WebPage',
        'name'     => $firm['name'] . ' — Personal Injury Lawyers in Georgia & South Carolina',
        'url'      => $firm['url'],
        'speakable' => array(
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => array( '.hero h1', '.hero p', '.trust-bar' ),
        ),
    ) );
}

function roden_schema_speakable_practice_area() {
    roden_json_ld( array(
        '@context' => 'https://schema.org',
        '@type'    => 'WebPage',
        'name'     => get_the_title(),
        'url'      => get_permalink(),
        'speakable' => array(
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => array( '.hero h1', '.hero p' ),
        ),
    ) );
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
