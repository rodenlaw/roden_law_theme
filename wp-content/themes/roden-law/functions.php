<?php
/**
 * Roden Law Theme Functions
 *
 * Core engine: loads modular inc/ files, handles theme setup,
 * asset enqueue, meta boxes, and widget areas.
 * Schema markup lives in inc/schema-helpers.php.
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

    // FAQs — for practice area and location pages
    add_meta_box(
        'roden_faqs',
        __( 'FAQs (generates FAQPage schema)', 'roden-law' ),
        'roden_faqs_meta_box',
        array( 'practice_area', 'location' ),
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
   5. WIDGET AREAS
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
