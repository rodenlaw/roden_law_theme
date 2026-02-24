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

define( 'RODEN_VERSION', '1.1.0' );
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

    // Practice Areas
    register_post_type( 'practice_area', [
        'labels' => [
            'name'          => 'Practice Areas',
            'singular_name' => 'Practice Area',
            'add_new_item'  => 'Add New Practice Area',
            'edit_item'     => 'Edit Practice Area',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'practice-areas', 'with_front' => false ],
        'menu_icon'     => 'dashicons-hammer',
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ],
        'show_in_rest'  => true,
        'template'      => [
            ['core/paragraph', ['placeholder' => 'Enter the main practice area content here...']],
        ],
    ] );

    // Locations
    register_post_type( 'location', [
        'labels' => [
            'name'          => 'Locations',
            'singular_name' => 'Location',
            'add_new_item'  => 'Add New Location',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'locations', 'with_front' => false ],
        'menu_icon'     => 'dashicons-location-alt',
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ],
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
    ?>
    <table class="form-table">
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
        foreach ( ['_roden_jurisdiction','_roden_sol_ga','_roden_sol_sc','_roden_sub_types','_roden_author_attorney'] as $key ) {
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
