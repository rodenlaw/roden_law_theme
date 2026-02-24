<?php
/**
 * Roden Law AI-SEO Theme — functions.php
 *
 * Core theme engine: firm data config, custom post types, taxonomies,
 * automatic JSON-LD schema, meta boxes, enqueue, and theme supports.
 *
 * @package RodenLaw
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'RODEN_VERSION', '1.5.0' );
define( 'RODEN_DIR', get_template_directory() );
define( 'RODEN_URI', get_template_directory_uri() );

/* ─────────────────────────────────────────────────────────────────────────────
   1. CENTRAL FIRM DATA
   ────────────────────────────────────────────────────────────────────────── */

function roden_firm_data() {
    return [
        'name'          => 'Roden Law',
        'legal_name'    => 'Roden Love LLC',
        'url'           => 'https://rodenlaw.com',
        'logo'          => RODEN_URI . '/assets/images/roden-law-logo.png',
        'phone'         => '1-844-RESULTS',
        'phone_e164'    => '+18447378587',
        'email'         => 'info@rodenlaw.com',
        'founded'       => '2018',
        'description'   => 'Roden Law is a multi-location personal injury law firm serving Georgia and South Carolina. Our attorneys have recovered $250M+ for injury victims. No fees unless we win.',
        'slogan'        => 'Georgia & South Carolina Personal Injury Lawyers Who Fight for Maximum Compensation',
        'recovered'     => '$250M+',
        'cases_handled' => '5,000+',
        'rating'        => 4.9,
        'review_count'  => 500,
        'experience'    => '62 Years',
        'states'        => ['Georgia', 'South Carolina'],
        'same_as'       => [
            'https://www.facebook.com/RodenLawGroup',
            'https://www.linkedin.com/company/roden-law',
            'https://twitter.com/RodenLawGroup',
            'https://www.youtube.com/@RodenLawGroup',
            'https://www.avvo.com/attorneys/31406-ga-eric-roden-4857617.html',
        ],
        'offices'       => [
            'savannah' => [
                'name'      => 'Roden Law — Savannah',
                'address'   => '333 Commercial Dr.',
                'city'      => 'Savannah',
                'state'     => 'GA',
                'state_full'=> 'Georgia',
                'zip'       => '31406',
                'phone'     => '(912) 303-5850',
                'phone_e164'=> '+19123035850',
                'lat'       => 32.0286,
                'lng'       => -81.0658,
                'map_url'   => 'https://maps.google.com/?q=333+Commercial+Drive+Savannah+GA+31406',
                'service_area' => 'Savannah, Pooler, Richmond Hill, Hinesville, Statesboro, and surrounding Southeast Georgia communities.',
                'court'     => 'Chatham County Superior Court',
                'sol'       => '2 years (O.C.G.A. § 9-3-33)',
                'fault'     => 'Modified comparative — recovery if less than 50% at fault (O.C.G.A. § 51-12-33)',
            ],
            'darien' => [
                'name'      => 'Roden Law — Darien',
                'address'   => '1108 North Way',
                'city'      => 'Darien',
                'state'     => 'GA',
                'state_full'=> 'Georgia',
                'zip'       => '31305',
                'phone'     => '(912) 303-5850',
                'phone_e164'=> '+19123035850',
                'lat'       => 31.3713,
                'lng'       => -81.4337,
                'map_url'   => 'https://maps.google.com/?q=1108+North+Way+Darien+GA+31305',
                'service_area' => 'Darien, Brunswick, St. Simons Island, Jekyll Island, Waycross, and surrounding Southeast Georgia coastal communities.',
                'court'     => 'McIntosh County Superior Court',
                'sol'       => '2 years (O.C.G.A. § 9-3-33)',
                'fault'     => 'Modified comparative — recovery if less than 50% at fault (O.C.G.A. § 51-12-33)',
            ],
            'charleston' => [
                'name'      => 'Roden Law — Charleston',
                'address'   => '127 King St., Suite 200',
                'city'      => 'Charleston',
                'state'     => 'SC',
                'state_full'=> 'South Carolina',
                'zip'       => '29401',
                'phone'     => '(843) 790-8999',
                'phone_e164'=> '+18437908999',
                'lat'       => 32.7808,
                'lng'       => -79.9338,
                'map_url'   => 'https://maps.google.com/?q=127+King+Street+Suite+200+Charleston+SC+29401',
                'service_area' => 'Charleston, North Charleston, Summerville, Mount Pleasant, Goose Creek, and surrounding Lowcountry communities.',
                'court'     => 'Charleston County Circuit Court',
                'sol'       => '3 years (S.C. Code § 15-3-530)',
                'fault'     => 'Modified comparative — recovery if less than 51% at fault',
            ],
            'columbia' => [
                'name'      => 'Roden Law — Columbia',
                'address'   => '1545 Sumter St., Suite B',
                'city'      => 'Columbia',
                'state'     => 'SC',
                'state_full'=> 'South Carolina',
                'zip'       => '29201',
                'phone'     => '(803) 219-2816',
                'phone_e164'=> '+18032192816',
                'lat'       => 34.0007,
                'lng'       => -81.0348,
                'map_url'   => 'https://maps.google.com/?q=1545+Sumter+Street+Suite+B+Columbia+SC+29201',
                'service_area' => 'Columbia, Lexington, Irmo, West Columbia, Cayce, Forest Acres, and surrounding Midlands South Carolina communities.',
                'court'     => 'Richland County Circuit Court',
                'sol'       => '3 years (S.C. Code § 15-3-530)',
                'fault'     => 'Modified comparative — recovery if less than 51% at fault',
            ],
            'myrtle-beach' => [
                'name'      => 'Roden Law — Myrtle Beach',
                'address'   => '631 Bellamy Ave., Suite C-B',
                'city'      => 'Myrtle Beach',
                'state'     => 'SC',
                'state_full'=> 'South Carolina',
                'zip'       => '29576',
                'phone'     => '(843) 612-1980',
                'phone_e164'=> '+18436121980',
                'lat'       => 33.5518,
                'lng'       => -79.0454,
                'map_url'   => 'https://maps.google.com/?q=631+Bellamy+Ave+Suite+C-B+Murrells+Inlet+SC+29576',
                'service_area' => 'Myrtle Beach, Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and surrounding Grand Strand communities.',
                'court'     => 'Horry County Circuit Court',
                'sol'       => '3 years (S.C. Code § 15-3-530)',
                'fault'     => 'Modified comparative — recovery if less than 51% at fault',
            ],
        ],
    ];
}

/* ─────────────────────────────────────────────────────────────────────────────
   2. THEME SETUP
   ────────────────────────────────────────────────────────────────────────── */

add_action( 'after_setup_theme', 'roden_theme_setup' );
function roden_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    register_nav_menus( [
        'primary'   => __( 'Primary Navigation', 'roden-law' ),
        'footer'    => __( 'Footer Navigation', 'roden-law' ),
        'mobile'    => __( 'Mobile Navigation', 'roden-law' ),
    ] );

    add_image_size( 'attorney-portrait', 400, 500, true );
    add_image_size( 'hero-bg', 1920, 800, true );
    add_image_size( 'card-thumb', 600, 400, true );
}

/* ─────────────────────────────────────────────────────────────────────────────
   3. ENQUEUE STYLES & SCRIPTS
   ────────────────────────────────────────────────────────────────────────── */

add_action( 'wp_enqueue_scripts', 'roden_enqueue_assets' );
function roden_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style( 'roden-google-fonts',
        'https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Inter:wght@400;500;600;700;800&display=swap',
        [], null
    );

    // Main theme stylesheet
    wp_enqueue_style( 'roden-theme', RODEN_URI . '/assets/css/theme.css', [ 'roden-google-fonts' ], RODEN_VERSION );

    // Main JS
    wp_enqueue_script( 'roden-theme', RODEN_URI . '/assets/js/theme.js', [], RODEN_VERSION, true );

    // Localize for AJAX and firm data
    wp_localize_script( 'roden-theme', 'rodenData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'roden_nonce' ),
        'phone'   => roden_firm_data()['phone'],
    ] );
}

/* ─────────────────────────────────────────────────────────────────────────────
   4. CUSTOM POST TYPES
   ────────────────────────────────────────────────────────────────────────── */

add_action( 'init', 'roden_register_post_types' );
function roden_register_post_types() {

    // Practice Areas (hierarchical: pillar → intersection/sub-type)
    register_post_type( 'practice_area', [
        'labels' => [
            'name'          => 'Practice Areas',
            'singular_name' => 'Practice Area',
            'add_new_item'  => 'Add New Practice Area',
            'edit_item'     => 'Edit Practice Area',
        ],
        'public'        => true,
        'has_archive'   => true,
        'hierarchical'  => true,
        'rewrite'       => [ 'slug' => 'practice-areas', 'with_front' => false ],
        'menu_icon'     => 'dashicons-hammer',
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields', 'page-attributes' ],
        'show_in_rest'  => true,
        'template'      => [
            ['core/paragraph', ['placeholder' => 'Enter the main practice area content here...']],
        ],
    ] );

    // Locations (hierarchical: state/city)
    register_post_type( 'location', [
        'labels' => [
            'name'          => 'Locations',
            'singular_name' => 'Location',
            'add_new_item'  => 'Add New Location',
        ],
        'public'        => true,
        'has_archive'   => true,
        'hierarchical'  => true,
        'rewrite'       => [ 'slug' => 'locations', 'with_front' => false ],
        'menu_icon'     => 'dashicons-location-alt',
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields', 'page-attributes' ],
        'show_in_rest'  => true,
    ] );

    // Attorneys
    register_post_type( 'attorney', [
        'labels' => [
            'name'          => 'Attorneys',
            'singular_name' => 'Attorney',
            'add_new_item'  => 'Add New Attorney',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'attorneys', 'with_front' => false ],
        'menu_icon'     => 'dashicons-businessperson',
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ],
        'show_in_rest'  => true,
    ] );

    // Case Results
    register_post_type( 'case_result', [
        'labels' => [
            'name'          => 'Case Results',
            'singular_name' => 'Case Result',
            'add_new_item'  => 'Add New Case Result',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'results', 'with_front' => false ],
        'menu_icon'     => 'dashicons-awards',
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ],
        'show_in_rest'  => true,
    ] );

    // Testimonials
    register_post_type( 'testimonial', [
        'labels' => [
            'name'          => 'Testimonials',
            'singular_name' => 'Testimonial',
        ],
        'public'        => true,
        'has_archive'   => false,
        'rewrite'       => [ 'slug' => 'testimonials', 'with_front' => false ],
        'menu_icon'     => 'dashicons-format-quote',
        'supports'      => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
        'show_in_rest'  => true,
    ] );

    // Resources
    register_post_type( 'resource', [
        'labels' => [
            'name'          => 'Resources',
            'singular_name' => 'Resource',
            'add_new_item'  => 'Add New Resource',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'resources', 'with_front' => false ],
        'menu_icon'     => 'dashicons-book-alt',
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ],
        'show_in_rest'  => true,
    ] );
}

/* ─────────────────────────────────────────────────────────────────────────────
   5. CUSTOM TAXONOMIES
   ────────────────────────────────────────────────────────────────────────── */

add_action( 'init', 'roden_register_taxonomies' );
function roden_register_taxonomies() {

    // Practice Category — shared across practice_area, case_result, resource
    register_taxonomy( 'practice_category', [ 'practice_area', 'case_result', 'resource', 'post' ], [
        'labels' => [
            'name'          => 'Practice Categories',
            'singular_name' => 'Practice Category',
        ],
        'public'            => true,
        'hierarchical'      => true,
        'rewrite'           => [ 'slug' => 'practice-category', 'with_front' => false ],
        'show_in_rest'      => true,
        'show_admin_column' => true,
    ] );

    // Location Served — shared across case_result, attorney, resource
    register_taxonomy( 'location_served', [ 'case_result', 'attorney', 'resource', 'post' ], [
        'labels' => [
            'name'          => 'Locations Served',
            'singular_name' => 'Location Served',
        ],
        'public'            => true,
        'hierarchical'      => true,
        'rewrite'           => [ 'slug' => 'location-served', 'with_front' => false ],
        'show_in_rest'      => true,
        'show_admin_column' => true,
    ] );
}

/* ─────────────────────────────────────────────────────────────────────────────
   6. META BOXES
   ────────────────────────────────────────────────────────────────────────── */

add_action( 'add_meta_boxes', 'roden_add_meta_boxes' );
function roden_add_meta_boxes() {

    // Practice Area meta
    add_meta_box( 'roden_practice_area_meta', 'Practice Area Settings', 'roden_practice_area_meta_cb', 'practice_area', 'normal', 'high' );

    // Location meta
    add_meta_box( 'roden_location_meta', 'Location / Office Settings', 'roden_location_meta_cb', 'location', 'normal', 'high' );

    // Attorney meta
    add_meta_box( 'roden_attorney_meta', 'Attorney Details', 'roden_attorney_meta_cb', 'attorney', 'normal', 'high' );

    // Case Result meta
    add_meta_box( 'roden_case_result_meta', 'Case Result Details', 'roden_case_result_meta_cb', 'case_result', 'normal', 'high' );

    // FAQ meta (multiple post types)
    foreach ( [ 'practice_area', 'location', 'resource', 'post' ] as $pt ) {
        add_meta_box( 'roden_faq_meta', 'FAQ Section (generates FAQPage schema)', 'roden_faq_meta_cb', $pt, 'normal', 'default' );
    }
}

function roden_practice_area_meta_cb( $post ) {
    wp_nonce_field( 'roden_pa_meta', 'roden_pa_nonce' );
    $jurisdiction = get_post_meta( $post->ID, '_roden_jurisdiction', true ) ?: 'both';
    $sol_ga       = get_post_meta( $post->ID, '_roden_sol_ga', true ) ?: '2 years (O.C.G.A. § 9-3-33)';
    $sol_sc       = get_post_meta( $post->ID, '_roden_sol_sc', true ) ?: '3 years (S.C. Code § 15-3-530)';
    $sub_types    = get_post_meta( $post->ID, '_roden_sub_types', true ) ?: '';
    $author_id    = get_post_meta( $post->ID, '_roden_author_attorney', true ) ?: '';
    $pa_office_key = get_post_meta( $post->ID, '_roden_pa_office_key', true ) ?: '';

    // Detect page type
    $page_type = 'pillar';
    if ( $pa_office_key ) $page_type = 'intersection';
    elseif ( $post->post_parent && ! $pa_office_key ) $page_type = 'subtype';
    ?>
    <table class="form-table">
        <tr><th><label>Page Type</label></th><td>
            <strong style="color: #1B3A6B; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">
                <?php echo esc_html( $page_type ); ?>
            </strong>
            <p class="description">Auto-detected: Pillar (top-level), Intersection (has office key), Sub-type (has parent, no office key).</p>
        </td></tr>
        <tr><th><label>Office Key (Intersection)</label></th><td>
            <?php $firm = roden_firm_data(); ?>
            <select name="_roden_pa_office_key">
                <option value="">— None (Pillar or Sub-type) —</option>
                <?php foreach ( $firm['offices'] as $key => $o ) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php selected($pa_office_key, $key); ?>>
                        <?php echo esc_html($o['city'] . ', ' . $o['state']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="description">Set this for intersection pages (practice area + location).</p>
        </td></tr>
        <tr><th><label>Jurisdiction</label></th><td>
            <select name="_roden_jurisdiction">
                <option value="both" <?php selected($jurisdiction,'both'); ?>>Georgia & South Carolina</option>
                <option value="ga" <?php selected($jurisdiction,'ga'); ?>>Georgia Only</option>
                <option value="sc" <?php selected($jurisdiction,'sc'); ?>>South Carolina Only</option>
            </select>
        </td></tr>
        <tr><th><label>GA Statute of Limitations</label></th><td>
            <input type="text" name="_roden_sol_ga" value="<?php echo esc_attr($sol_ga); ?>" class="regular-text" />
        </td></tr>
        <tr><th><label>SC Statute of Limitations</label></th><td>
            <input type="text" name="_roden_sol_sc" value="<?php echo esc_attr($sol_sc); ?>" class="regular-text" />
        </td></tr>
        <tr><th><label>Sub-Types (one per line)</label></th><td>
            <textarea name="_roden_sub_types" rows="6" class="large-text"><?php echo esc_textarea($sub_types); ?></textarea>
            <p class="description">E.g., Drunk Driver Accidents, Rideshare / Uber Accidents, etc.</p>
        </td></tr>
        <tr><th><label>Author Attorney</label></th><td>
            <?php
            $attorneys = get_posts(['post_type'=>'attorney','numberposts'=>-1,'orderby'=>'title','order'=>'ASC']);
            echo '<select name="_roden_author_attorney"><option value="">— Select Attorney —</option>';
            foreach ( $attorneys as $a ) {
                printf( '<option value="%d" %s>%s</option>', $a->ID, selected($author_id, $a->ID, false), esc_html($a->post_title) );
            }
            echo '</select>';
            ?>
        </td></tr>
    </table>
    <?php
}

function roden_location_meta_cb( $post ) {
    wp_nonce_field( 'roden_loc_meta', 'roden_loc_nonce' );
    $office_key = get_post_meta( $post->ID, '_roden_office_key', true ) ?: '';
    $firm       = roden_firm_data();
    ?>
    <table class="form-table">
        <tr><th><label>Office Key</label></th><td>
            <select name="_roden_office_key">
                <option value="">— Select Office —</option>
                <?php foreach ( $firm['offices'] as $key => $o ) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php selected($office_key, $key); ?>>
                        <?php echo esc_html( $o['city'] . ', ' . $o['state'] ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="description">Links this page to the office in the firm data config. NAP, schema, and map data will be pulled automatically.</p>
        </td></tr>
    </table>
    <?php
}

function roden_attorney_meta_cb( $post ) {
    wp_nonce_field( 'roden_atty_meta', 'roden_atty_nonce' );
    $fields = [
        '_roden_atty_title'      => [ 'Attorney Title', 'text', 'E.g., Founding Partner, CEO' ],
        '_roden_atty_office_key' => [ 'Primary Office', 'office_select', '' ],
        '_roden_atty_bar_admissions' => [ 'Bar Admissions (one per line)', 'textarea', 'State Bar of Georgia | GA | 2015' ],
        '_roden_atty_education'  => [ 'Education (one per line)', 'textarea', 'J.D., University of Georgia School of Law' ],
        '_roden_atty_awards'     => [ 'Awards (one per line)', 'textarea', 'Super Lawyers Rising Star' ],
        '_roden_atty_avvo_url'   => [ 'Avvo Profile URL', 'url', '' ],
        '_roden_atty_linkedin'   => [ 'LinkedIn URL', 'url', '' ],
    ];
    echo '<table class="form-table">';
    foreach ( $fields as $key => $cfg ) {
        $val = get_post_meta( $post->ID, $key, true ) ?: '';
        echo '<tr><th><label>' . esc_html($cfg[0]) . '</label></th><td>';
        if ( $cfg[1] === 'textarea' ) {
            printf( '<textarea name="%s" rows="4" class="large-text">%s</textarea>', esc_attr($key), esc_textarea($val) );
            if ($cfg[2]) echo '<p class="description">Format: ' . esc_html($cfg[2]) . '</p>';
        } elseif ( $cfg[1] === 'office_select' ) {
            $firm = roden_firm_data();
            echo '<select name="' . esc_attr($key) . '"><option value="">— Select —</option>';
            foreach ( $firm['offices'] as $k => $o ) {
                printf( '<option value="%s" %s>%s</option>', esc_attr($k), selected($val,$k,false), esc_html($o['city'].', '.$o['state']) );
            }
            echo '</select>';
        } else {
            printf( '<input type="%s" name="%s" value="%s" class="regular-text" />', esc_attr($cfg[1]), esc_attr($key), esc_attr($val) );
        }
        echo '</td></tr>';
    }
    echo '</table>';
}

function roden_case_result_meta_cb( $post ) {
    wp_nonce_field( 'roden_cr_meta', 'roden_cr_nonce' );
    $amount = get_post_meta( $post->ID, '_roden_cr_amount', true ) ?: '';
    $type   = get_post_meta( $post->ID, '_roden_cr_type', true ) ?: 'Settlement';
    $desc   = get_post_meta( $post->ID, '_roden_cr_description', true ) ?: '';
    ?>
    <table class="form-table">
        <tr><th><label>Amount</label></th><td>
            <input type="text" name="_roden_cr_amount" value="<?php echo esc_attr($amount); ?>" placeholder="$3,000,000" class="regular-text" />
        </td></tr>
        <tr><th><label>Result Type</label></th><td>
            <select name="_roden_cr_type">
                <?php foreach (['Settlement','Verdict','Recovery','Award'] as $t) : ?>
                    <option value="<?php echo esc_attr($t); ?>" <?php selected($type,$t); ?>><?php echo esc_html($t); ?></option>
                <?php endforeach; ?>
            </select>
        </td></tr>
        <tr><th><label>Short Description</label></th><td>
            <textarea name="_roden_cr_description" rows="3" class="large-text"><?php echo esc_textarea($desc); ?></textarea>
        </td></tr>
    </table>
    <?php
}

function roden_faq_meta_cb( $post ) {
    wp_nonce_field( 'roden_faq_meta', 'roden_faq_nonce' );
    $faqs = get_post_meta( $post->ID, '_roden_faqs', true ) ?: [];
    if ( ! is_array( $faqs ) ) $faqs = [];
    ?>
    <div id="roden-faq-repeater">
        <p class="description">Add Q&A pairs. These generate FAQPage JSON-LD schema automatically.</p>
        <div id="roden-faq-list">
            <?php foreach ( $faqs as $i => $faq ) : ?>
                <div class="roden-faq-item" style="background:#f9f9f9;border:1px solid #ddd;padding:12px;margin:8px 0;border-radius:4px;">
                    <p><strong>Question <?php echo $i + 1; ?>:</strong></p>
                    <input type="text" name="_roden_faqs[<?php echo $i; ?>][q]" value="<?php echo esc_attr($faq['q'] ?? ''); ?>" class="widefat" placeholder="Question" />
                    <p style="margin-top:6px;"><strong>Answer:</strong></p>
                    <textarea name="_roden_faqs[<?php echo $i; ?>][a]" rows="3" class="widefat" placeholder="Answer"><?php echo esc_textarea($faq['a'] ?? ''); ?></textarea>
                    <p><button type="button" class="button roden-remove-faq" onclick="this.closest('.roden-faq-item').remove();">Remove</button></p>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button button-primary" id="roden-add-faq">+ Add FAQ</button>
    </div>
    <script>
    document.getElementById('roden-add-faq').addEventListener('click', function() {
        var list = document.getElementById('roden-faq-list');
        var idx = list.children.length;
        var html = '<div class="roden-faq-item" style="background:#f9f9f9;border:1px solid #ddd;padding:12px;margin:8px 0;border-radius:4px;">'
            + '<p><strong>Question ' + (idx+1) + ':</strong></p>'
            + '<input type="text" name="_roden_faqs['+idx+'][q]" class="widefat" placeholder="Question" />'
            + '<p style="margin-top:6px;"><strong>Answer:</strong></p>'
            + '<textarea name="_roden_faqs['+idx+'][a]" rows="3" class="widefat" placeholder="Answer"></textarea>'
            + '<p><button type="button" class="button roden-remove-faq" onclick="this.closest(\'.roden-faq-item\').remove();">Remove</button></p>'
            + '</div>';
        list.insertAdjacentHTML('beforeend', html);
    });
    </script>
    <?php
}

/* ─── SAVE META ────────────────────────────────────────────────────────── */

add_action( 'save_post', 'roden_save_meta' );
function roden_save_meta( $post_id ) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;

    // Practice Area
    if ( isset($_POST['roden_pa_nonce']) && wp_verify_nonce($_POST['roden_pa_nonce'], 'roden_pa_meta') ) {
        foreach ( ['_roden_jurisdiction','_roden_sol_ga','_roden_sol_sc','_roden_sub_types','_roden_author_attorney','_roden_pa_office_key'] as $key ) {
            if ( isset($_POST[$key]) ) {
                update_post_meta( $post_id, $key, sanitize_textarea_field($_POST[$key]) );
            }
        }
    }

    // Location
    if ( isset($_POST['roden_loc_nonce']) && wp_verify_nonce($_POST['roden_loc_nonce'], 'roden_loc_meta') ) {
        if ( isset($_POST['_roden_office_key']) ) {
            update_post_meta( $post_id, '_roden_office_key', sanitize_text_field($_POST['_roden_office_key']) );
        }
    }

    // Attorney
    if ( isset($_POST['roden_atty_nonce']) && wp_verify_nonce($_POST['roden_atty_nonce'], 'roden_atty_meta') ) {
        $atty_fields = ['_roden_atty_title','_roden_atty_office_key','_roden_atty_bar_admissions','_roden_atty_education','_roden_atty_awards','_roden_atty_avvo_url','_roden_atty_linkedin'];
        foreach ( $atty_fields as $key ) {
            if ( isset($_POST[$key]) ) {
                update_post_meta( $post_id, $key, sanitize_textarea_field($_POST[$key]) );
            }
        }
    }

    // Case Result
    if ( isset($_POST['roden_cr_nonce']) && wp_verify_nonce($_POST['roden_cr_nonce'], 'roden_cr_meta') ) {
        foreach ( ['_roden_cr_amount','_roden_cr_type','_roden_cr_description'] as $key ) {
            if ( isset($_POST[$key]) ) {
                update_post_meta( $post_id, $key, sanitize_text_field($_POST[$key]) );
            }
        }
    }

    // FAQs
    if ( isset($_POST['roden_faq_nonce']) && wp_verify_nonce($_POST['roden_faq_nonce'], 'roden_faq_meta') ) {
        $faqs = [];
        if ( isset($_POST['_roden_faqs']) && is_array($_POST['_roden_faqs']) ) {
            foreach ( $_POST['_roden_faqs'] as $faq ) {
                if ( ! empty( $faq['q'] ) && ! empty( $faq['a'] ) ) {
                    $faqs[] = [
                        'q' => sanitize_text_field( $faq['q'] ),
                        'a' => sanitize_textarea_field( $faq['a'] ),
                    ];
                }
            }
        }
        update_post_meta( $post_id, '_roden_faqs', $faqs );
    }
}

/* ─────────────────────────────────────────────────────────────────────────────
   7. INCLUDES
   ────────────────────────────────────────────────────────────────────────── */

require_once RODEN_DIR . '/inc/schema-helpers.php';
require_once RODEN_DIR . '/inc/template-tags.php';

/* ─────────────────────────────────────────────────────────────────────────────
   8. WIDGETS & SIDEBARS
   ────────────────────────────────────────────────────────────────────────── */

add_action( 'widgets_init', 'roden_register_sidebars' );
function roden_register_sidebars() {
    register_sidebar( [
        'name'          => 'Blog Sidebar',
        'id'            => 'sidebar-blog',
        'description'   => 'Sidebar for blog pages.',
        'before_widget' => '<div class="sidebar-widget" id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );
    register_sidebar( [
        'name'          => 'Practice Area Sidebar',
        'id'            => 'sidebar-practice',
        'before_widget' => '<div class="sidebar-widget" id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );
}

/* ─────────────────────────────────────────────────────────────────────────────
   9. EXCERPT & MISC
   ────────────────────────────────────────────────────────────────────────── */

add_filter( 'excerpt_length', fn() => 30, 999 );
add_filter( 'excerpt_more', fn() => '&hellip;' );

// Flush rewrite rules on theme activation
add_action( 'after_switch_theme', function() {
    roden_register_post_types();
    roden_register_taxonomies();
    flush_rewrite_rules();
} );

/* ─────────────────────────────────────────────────────────────────────────────
   10. LOCATION HIERARCHY SETUP
   Creates state parent posts (Georgia, South Carolina) and reparents city
   location posts underneath them for /locations/georgia/savannah/ URL pattern.
   Runs once, tracked by option flag. Re-run by deleting the option.
   ────────────────────────────────────────────────────────────────────────── */

add_action( 'init', 'roden_setup_location_hierarchy', 99 );
function roden_setup_location_hierarchy() {
    // Only run once per version (delete option to re-run)
    if ( get_option( 'roden_location_hierarchy_v2' ) ) return;

    // Only run on normal page loads (avoid REST/AJAX/cron)
    if ( wp_doing_ajax() || wp_doing_cron() || ( defined('REST_REQUEST') && REST_REQUEST ) ) return;

    $firm = roden_firm_data();

    // State parent definitions
    $state_configs = [
        'Georgia' => [
            'slug'    => 'georgia',
            'title'   => 'Georgia',
            'content' => '<p>Roden Law serves injury victims throughout Georgia from our Savannah and Darien offices. Our Georgia personal injury attorneys have deep knowledge of state law, local courts, and the Georgia statute of limitations.</p>',
            'excerpt' => 'Personal injury lawyers serving Georgia from offices in Savannah and Darien. Free consultations — no fees unless we win.',
        ],
        'South Carolina' => [
            'slug'    => 'south-carolina',
            'title'   => 'South Carolina',
            'content' => '<p>Roden Law serves injury victims throughout South Carolina from our Charleston, Columbia, and Myrtle Beach offices. Our South Carolina personal injury attorneys understand state-specific comparative fault rules and the 3-year filing deadline.</p>',
            'excerpt' => 'Personal injury lawyers serving South Carolina from offices in Charleston, Columbia, and Myrtle Beach. Free consultations — no fees unless we win.',
        ],
    ];

    $parent_ids = [];

    // Create or find state parent posts
    foreach ( $state_configs as $state_name => $config ) {
        $existing = get_page_by_path( $config['slug'], OBJECT, 'location' );
        if ( $existing ) {
            $parent_ids[ $state_name ] = $existing->ID;
            if ( $existing->post_parent != 0 ) {
                wp_update_post( [ 'ID' => $existing->ID, 'post_parent' => 0 ] );
            }
        } else {
            $id = wp_insert_post( [
                'post_title'   => $config['title'],
                'post_name'    => $config['slug'],
                'post_type'    => 'location',
                'post_status'  => 'publish',
                'post_content' => $config['content'],
                'post_excerpt' => $config['excerpt'],
                'menu_order'   => $state_name === 'Georgia' ? 1 : 2,
            ] );
            if ( ! is_wp_error( $id ) ) {
                $parent_ids[ $state_name ] = $id;
            }
        }
    }

    // Process each office: find existing post by meta/title/slug, or create new
    foreach ( $firm['offices'] as $key => $office ) {
        $state_name = $office['state_full'];
        if ( ! isset( $parent_ids[ $state_name ] ) ) continue;

        $city_slug = sanitize_title( $office['city'] ); // e.g. 'savannah', 'myrtle-beach'
        $found_post = null;

        // Strategy 1: Find by _roden_office_key meta
        $meta_posts = get_posts( [
            'post_type' => 'location', 'meta_key' => '_roden_office_key',
            'meta_value' => $key, 'posts_per_page' => 1, 'post_status' => 'any',
        ] );
        if ( ! empty( $meta_posts ) ) {
            $found_post = $meta_posts[0];
        }

        // Strategy 2: Match by post title containing city name
        if ( ! $found_post ) {
            $title_posts = get_posts( [
                'post_type' => 'location', 'posts_per_page' => -1,
                'post_status' => 'any', 'post_parent' => 0,
            ] );
            foreach ( $title_posts as $p ) {
                // Match: title contains city name (e.g. "Savannah, Georgia" contains "Savannah")
                if ( stripos( $p->post_title, $office['city'] ) !== false ) {
                    // Make sure it's not a state parent
                    if ( ! in_array( $p->post_name, ['georgia', 'south-carolina'] ) ) {
                        $found_post = $p;
                        break;
                    }
                }
            }
        }

        // Strategy 3: Match by slug containing city slug
        if ( ! $found_post ) {
            $slug_posts = get_posts( [
                'post_type' => 'location', 'posts_per_page' => -1,
                'post_status' => 'any',
            ] );
            foreach ( $slug_posts as $p ) {
                if ( stripos( $p->post_name, $city_slug ) !== false ) {
                    if ( ! in_array( $p->post_name, ['georgia', 'south-carolina'] ) ) {
                        $found_post = $p;
                        break;
                    }
                }
            }
        }

        // Strategy 4: Create new post if nothing found
        if ( ! $found_post ) {
            $new_id = wp_insert_post( [
                'post_title'   => $office['city'] . ', ' . $office['state'],
                'post_name'    => $city_slug,
                'post_type'    => 'location',
                'post_status'  => 'publish',
                'post_parent'  => $parent_ids[ $state_name ],
                'post_content' => sprintf(
                    '<p>Roden Law\'s %s office serves injury victims throughout the region. Our %s personal injury attorneys handle all types of injury claims under %s law.</p><p>Serving %s</p>',
                    $office['city'], $office['city'], $office['state_full'], $office['service_area']
                ),
                'post_excerpt' => sprintf( 'Personal injury lawyer in %s, %s. Free consultation — no fees unless we win. Call %s.', $office['city'], $office['state'], $office['phone'] ),
            ] );
            if ( ! is_wp_error( $new_id ) ) {
                update_post_meta( $new_id, '_roden_office_key', $key );
            }
            continue; // Already parented and slugged correctly
        }

        // Update existing post: reparent + clean slug + set meta
        $update_data = [
            'ID'          => $found_post->ID,
            'post_parent' => $parent_ids[ $state_name ],
            'post_name'   => $city_slug,
        ];
        wp_update_post( $update_data );

        // Ensure office key meta is set
        update_post_meta( $found_post->ID, '_roden_office_key', $key );
    }

    // Flush rewrite rules so new hierarchy resolves
    flush_rewrite_rules();

    // Mark as complete
    update_option( 'roden_location_hierarchy_v2', true );

    if ( defined('WP_DEBUG') && WP_DEBUG ) {
        error_log( 'Roden Law: Location hierarchy v2 setup complete. State parents: ' . implode(', ', array_map(fn($id) => "#{$id}", $parent_ids)) );
    }
}

/* ─────────────────────────────────────────────────────────────────────────────
   11. LOCATION STATE META — auto-set _roden_state meta on state parent pages
   ────────────────────────────────────────────────────────────────────────── */

add_action( 'save_post_location', function( $post_id ) {
    // If this is a top-level location post (no parent), it's a state page
    $post = get_post( $post_id );
    if ( $post->post_parent == 0 ) {
        $slug = $post->post_name;
        if ( in_array( $slug, ['georgia', 'south-carolina'] ) ) {
            update_post_meta( $post_id, '_roden_is_state_page', true );
            update_post_meta( $post_id, '_roden_state_slug', $slug );
        }
    }
}, 10, 1 );

/* ─────────────────────────────────────────────────────────────────────────────
   12. PRACTICE AREA TOPIC CLUSTERS — auto-generate intersection + sub-type pages
   ────────────────────────────────────────────────────────────────────────── */

add_action( 'init', 'roden_setup_practice_clusters', 100 );
function roden_setup_practice_clusters() {
    if ( get_option( 'roden_practice_clusters_v1' ) ) return;
    if ( wp_doing_ajax() || wp_doing_cron() || ( defined('REST_REQUEST') && REST_REQUEST ) ) return;

    // Make sure CPTs are registered
    if ( ! post_type_exists( 'practice_area' ) ) return;

    $firm = roden_firm_data();

    // ── Define top 5 practice areas for intersection pages ──────────────
    $intersection_pas = [
        'car-accident-lawyers',
        'truck-accident-lawyers',
        'slip-and-fall-lawyers',
        'medical-malpractice-lawyers',
        'wrongful-death-lawyers',
    ];

    // ── Define sub-type pages for top 3 practice areas ─────────────────
    $subtype_configs = [
        'car-accident-lawyers' => [
            'drunk-driver-accidents'       => ['title' => 'Drunk Driver Accident Lawyer',       'desc' => 'Drunk and impaired drivers cause some of the most devastating crashes on Georgia and South Carolina roads. If you were injured by a drunk driver, Roden Law will hold them accountable and pursue maximum compensation for your injuries.'],
            'rideshare-accidents'          => ['title' => 'Rideshare / Uber Accident Lawyer',    'desc' => 'Rideshare accidents involving Uber and Lyft present unique insurance challenges. Multiple policies may apply depending on the driver\'s status at the time of the crash. Our attorneys know how to navigate these layered claims.'],
            'rear-end-collisions'          => ['title' => 'Rear-End Collision Lawyer',            'desc' => 'Rear-end collisions are among the most common car accidents and frequently result in whiplash, back injuries, and traumatic brain injuries. The trailing driver is almost always at fault.'],
            'hit-and-run-accidents'        => ['title' => 'Hit and Run Accident Lawyer',          'desc' => 'Hit and run accidents leave victims injured with no immediate recourse against the at-fault driver. Our attorneys pursue recovery through UM/UIM coverage, investigation, and law enforcement coordination.'],
            'distracted-driving-accidents' => ['title' => 'Distracted Driving Accident Lawyer',   'desc' => 'Texting, phone use, and other distractions are a leading cause of car accidents. We use phone records, witness testimony, and crash reconstruction to prove distracted driving negligence.'],
            'wrong-way-driver-accidents'   => ['title' => 'Wrong-Way Driver Accident Lawyer',     'desc' => 'Wrong-way collisions are often head-on crashes that cause catastrophic injuries or death. These cases frequently involve impaired driving or highway design defects.'],
            'commercial-vehicle-accidents' => ['title' => 'Commercial Vehicle Accident Lawyer',   'desc' => 'Accidents involving company vehicles, delivery vans, and fleet trucks raise questions of employer liability and vicarious responsibility. Our attorneys investigate corporate negligence.'],
            'multi-vehicle-pileups'        => ['title' => 'Multi-Vehicle Pileup Accident Lawyer', 'desc' => 'Multi-vehicle pileups involve complex liability determinations across multiple drivers and insurers. Our attorneys untangle these claims to identify every liable party and available insurance policy.'],
        ],
        'truck-accident-lawyers' => [
            '18-wheeler-accidents'           => ['title' => '18-Wheeler Accident Lawyer',          'desc' => '18-wheeler accidents cause catastrophic injuries due to the massive size differential between commercial trucks and passenger vehicles. Our attorneys understand FMCSA regulations and how to hold trucking companies accountable.'],
            'fatigued-trucker-accidents'      => ['title' => 'Fatigued Trucker Accident Lawyer',    'desc' => 'Federal hours-of-service rules exist to prevent trucker fatigue crashes. When trucking companies push drivers beyond legal limits, they bear responsibility for the resulting accidents and injuries.'],
            'overloaded-cargo-accidents'      => ['title' => 'Overloaded Cargo Accident Lawyer',    'desc' => 'Improperly loaded or overweight trucks are more likely to jackknife, roll over, or lose control. The cargo loader, shipper, and trucking company can all be held liable.'],
            'brake-failure-accidents'         => ['title' => 'Brake Failure Accident Lawyer',        'desc' => 'Commercial truck brake failures are often the result of negligent maintenance by the trucking company. Federal regulations require regular brake inspections and documentation.'],
            'underride-accidents'             => ['title' => 'Underride Accident Lawyer',            'desc' => 'Underride crashes — where a car slides beneath a truck\'s trailer — are among the most deadly types of truck accidents. These cases often involve inadequate underride guards and regulatory violations.'],
            'delivery-truck-accidents'        => ['title' => 'Delivery Truck Accident Lawyer',      'desc' => 'Amazon, FedEx, UPS, and other delivery vehicle accidents raise complex questions about driver classification, employer liability, and applicable insurance policies.'],
            'hazardous-materials-accidents'   => ['title' => 'Hazardous Materials Accident Lawyer', 'desc' => 'Trucks carrying hazardous materials must comply with strict federal regulations. Spills, leaks, and explosions can cause severe injuries to nearby motorists and residents.'],
            'jackknife-accidents'             => ['title' => 'Jackknife Accident Lawyer',            'desc' => 'Jackknife accidents occur when a truck\'s trailer swings outward at a sharp angle, sweeping across multiple lanes. These crashes frequently involve excessive speed, wet roads, or brake failure.'],
        ],
        'slip-and-fall-lawyers' => [
            'grocery-store-slip-and-fall'  => ['title' => 'Grocery Store Slip and Fall Lawyer',  'desc' => 'Grocery stores have a duty to keep floors clean and dry, mark hazards, and regularly inspect aisles. When they fail, they can be held liable for customer injuries.'],
            'restaurant-slip-and-fall'     => ['title' => 'Restaurant Slip and Fall Lawyer',     'desc' => 'Restaurants must maintain safe conditions for patrons, including keeping floors free of spills, grease, and debris. Slip and fall injuries in restaurants are common and often preventable.'],
            'parking-lot-slip-and-fall'    => ['title' => 'Parking Lot Slip and Fall Lawyer',    'desc' => 'Uneven surfaces, potholes, poor lighting, and ice or debris in parking lots cause thousands of fall injuries each year. Property owners are responsible for maintaining safe conditions.'],
            'stairway-accidents'           => ['title' => 'Stairway Accident Lawyer',            'desc' => 'Broken handrails, uneven steps, poor lighting, and missing non-slip surfaces make stairways dangerous. Building owners must maintain stairways to code standards.'],
            'wet-floor-accidents'          => ['title' => 'Wet Floor Accident Lawyer',           'desc' => 'Property owners must promptly clean spills and post visible warning signs. Failure to do so constitutes negligence when a visitor is injured on a wet or slippery surface.'],
            'workplace-slip-and-fall'      => ['title' => 'Workplace Slip and Fall Lawyer',      'desc' => 'Workplace falls may be covered by workers\' compensation, but third-party premises liability claims may also apply. Our attorneys identify all available avenues of recovery.'],
        ],
    ];

    // ── Find parent pillar posts by slug ────────────────────────────────
    $pillar_ids = [];
    foreach ( array_unique( array_merge( $intersection_pas, array_keys( $subtype_configs ) ) ) as $pa_slug ) {
        $found = get_page_by_path( $pa_slug, OBJECT, 'practice_area' );
        if ( $found ) {
            $pillar_ids[ $pa_slug ] = $found->ID;
        }
    }

    if ( empty( $pillar_ids ) ) {
        // No pillar pages exist yet — skip; will run on next load
        return;
    }

    $created_count = 0;

    // ── CREATE INTERSECTION PAGES (PA + Location) ───────────────────────
    foreach ( $intersection_pas as $pa_slug ) {
        if ( ! isset( $pillar_ids[ $pa_slug ] ) ) continue;
        $parent_id = $pillar_ids[ $pa_slug ];
        $parent_post = get_post( $parent_id );
        $parent_title = $parent_post->post_title; // e.g. "Car Accident Lawyer"

        foreach ( $firm['offices'] as $office_key => $office ) {
            $child_slug = strtolower( str_replace(' ', '-', $office['city']) ) . '-' . strtolower( $office['state'] );
            // e.g. savannah-ga, charleston-sc, myrtle-beach-sc

            // Check if already exists
            $existing = get_posts([
                'post_type'   => 'practice_area',
                'post_parent' => $parent_id,
                'name'        => $child_slug,
                'post_status' => 'any',
                'numberposts' => 1,
            ]);
            if ( ! empty( $existing ) ) continue;

            // Also check by meta
            $meta_exists = get_posts([
                'post_type'   => 'practice_area',
                'post_parent' => $parent_id,
                'meta_key'    => '_roden_pa_office_key',
                'meta_value'  => $office_key,
                'post_status' => 'any',
                'numberposts' => 1,
            ]);
            if ( ! empty( $meta_exists ) ) continue;

            $child_title = $parent_title . ' in ' . $office['city'] . ', ' . $office['state'];
            $sol_years = $office['state'] === 'GA' ? '2' : '3';
            $fault_pct = $office['state'] === 'GA' ? '50' : '51';

            $content = sprintf(
                '<h2>Why Hire a %s in %s?</h2>' .
                '<p>If you or someone you love has been injured in %s, you need an experienced attorney who understands %s law and knows the local courts. Roden Law\'s %s office has recovered millions for injury victims throughout %s. We handle your case on a contingency fee basis — you pay nothing unless we win compensation for you.</p>' .
                '<h2>%s %s Law</h2>' .
                '<p>Under %s law, you have <strong>%s years</strong> from the date of the accident to file a personal injury claim (%s). %s follows a modified comparative fault rule — you can recover damages as long as you are less than %s%% at fault, but your award is reduced by your percentage of fault.</p>' .
                '<h2>What to Do After an Accident in %s</h2>' .
                '<p>If you have been injured in an accident in the %s area, take these steps to protect your legal rights: call 911, seek medical attention even if you feel fine, document the scene with photos, gather witness contact information, and do not give a recorded statement to the other party\'s insurance company. Contact Roden Law\'s %s office at %s as soon as possible — early evidence preservation is critical to your case.</p>' .
                '<h2>Contact Our %s Office Today</h2>' .
                '<p>Our %s attorneys are ready to review your case at no cost. We serve clients throughout %s from our %s, %s location. Call %s for a free, no-obligation case evaluation.</p>',
                $parent_title, $office['city'],
                $office['city'], $office['state_full'], $office['city'], $office['service_area'],
                $office['state_full'], str_replace(' Lawyer', '', $parent_title),
                $office['state_full'], $sol_years, $office['sol'], $office['state_full'], $fault_pct,
                $office['city'], $office['city'],
                $office['city'], $office['phone'],
                $office['city'],
                $office['city'], $office['service_area'], $office['city'], $office['state'], $office['phone']
            );

            $excerpt = sprintf(
                '%s in %s, %s. Roden Law has recovered $250M+ for injury victims. Free consultation — no fees unless we win. Call %s.',
                $child_title, $office['city'], $office['state'], $office['phone']
            );

            $new_id = wp_insert_post([
                'post_title'   => $child_title,
                'post_name'    => $child_slug,
                'post_type'    => 'practice_area',
                'post_status'  => 'publish',
                'post_parent'  => $parent_id,
                'post_content' => $content,
                'post_excerpt' => $excerpt,
            ]);

            if ( ! is_wp_error( $new_id ) ) {
                update_post_meta( $new_id, '_roden_pa_office_key', $office_key );
                update_post_meta( $new_id, '_roden_jurisdiction', $office['state'] === 'GA' ? 'ga' : 'sc' );
                update_post_meta( $new_id, '_roden_sol_ga', '2 years (O.C.G.A. § 9-3-33)' );
                update_post_meta( $new_id, '_roden_sol_sc', '3 years (S.C. Code § 15-3-530)' );
                $created_count++;
            }
        }
    }

    // ── CREATE SUB-TYPE PAGES ───────────────────────────────────────────
    foreach ( $subtype_configs as $pa_slug => $subtypes ) {
        if ( ! isset( $pillar_ids[ $pa_slug ] ) ) continue;
        $parent_id = $pillar_ids[ $pa_slug ];
        $parent_post = get_post( $parent_id );

        foreach ( $subtypes as $st_slug => $st_config ) {
            // Check if exists
            $existing = get_posts([
                'post_type'   => 'practice_area',
                'post_parent' => $parent_id,
                'name'        => $st_slug,
                'post_status' => 'any',
                'numberposts' => 1,
            ]);
            if ( ! empty( $existing ) ) continue;

            $content = sprintf(
                '<p>%s</p>' .
                '<h2>How We Handle %s Cases</h2>' .
                '<p>At Roden Law, our attorneys have the experience and resources to thoroughly investigate %s cases across Georgia and South Carolina. We gather evidence, consult with experts, and build a compelling case to establish negligence and secure the compensation our clients deserve.</p>' .
                '<h2>Statute of Limitations</h2>' .
                '<p>In Georgia, you have <strong>2 years</strong> from the date of the accident to file a personal injury claim (O.C.G.A. § 9-3-33). In South Carolina, the deadline is <strong>3 years</strong> (S.C. Code § 15-3-530). Missing this deadline means losing your right to compensation.</p>' .
                '<h2>Compensation You May Be Entitled To</h2>' .
                '<p>Depending on the severity of your injuries and the circumstances of the accident, you may be entitled to compensation for medical expenses, lost wages, pain and suffering, loss of earning capacity, and other economic and non-economic damages. Contact us for a free case evaluation to understand your rights.</p>',
                $st_config['desc'],
                str_replace(' Lawyer', '', $st_config['title']),
                strtolower( str_replace(' Lawyer', '', $st_config['title']) )
            );

            $excerpt = sprintf(
                '%s serving Georgia & South Carolina. Roden Law — $250M+ recovered. Free consultation — no fees unless we win.',
                $st_config['title']
            );

            $new_id = wp_insert_post([
                'post_title'   => $st_config['title'],
                'post_name'    => $st_slug,
                'post_type'    => 'practice_area',
                'post_status'  => 'publish',
                'post_parent'  => $parent_id,
                'post_content' => $content,
                'post_excerpt' => $excerpt,
            ]);

            if ( ! is_wp_error( $new_id ) ) {
                update_post_meta( $new_id, '_roden_jurisdiction', 'both' );
                update_post_meta( $new_id, '_roden_sol_ga', '2 years (O.C.G.A. § 9-3-33)' );
                update_post_meta( $new_id, '_roden_sol_sc', '3 years (S.C. Code § 15-3-530)' );
                $created_count++;
            }
        }
    }

    // Flush rewrite rules for new hierarchical URLs
    flush_rewrite_rules();

    update_option( 'roden_practice_clusters_v1', true );

    if ( defined('WP_DEBUG') && WP_DEBUG ) {
        error_log( 'Roden Law: Practice area clusters setup complete. Created ' . $created_count . ' pages.' );
    }
}
