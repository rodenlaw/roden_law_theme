<?php
/**
 * Meta Boxes — All custom fields for all CPTs
 *
 * Registers meta boxes, renders field UI, and handles save logic
 * for all 4 content types that need custom fields:
 *   - practice_area (jurisdiction, SOL, FAQs, author attribution, office key)
 *   - location       (office key, service area, map embed, local content)
 *   - attorney       (title, office, bar admissions, education, awards, URLs)
 *   - case_result    (amount, result type, description, attorney)
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   REGISTER META BOXES
   ========================================================================== */

add_action( 'add_meta_boxes', 'roden_add_meta_boxes' );
function roden_add_meta_boxes() {

    /* ── Practice Area ─────────────────────────────────────────────── */

    add_meta_box(
        'roden_pa_jurisdiction',
        __( 'Jurisdiction & Statute of Limitations', 'roden-law' ),
        'roden_pa_jurisdiction_meta_box',
        'practice_area',
        'side'
    );

    add_meta_box(
        'roden_pa_office_key',
        __( 'Intersection Office Key', 'roden-law' ),
        'roden_pa_office_key_meta_box',
        'practice_area',
        'side'
    );

    add_meta_box(
        'roden_pa_author',
        __( 'Author Attribution (E-E-A-T)', 'roden-law' ),
        'roden_pa_author_meta_box',
        array( 'practice_area', 'post', 'resource' ),
        'side'
    );

    add_meta_box(
        'roden_faqs',
        __( 'FAQs (generates FAQPage schema)', 'roden-law' ),
        'roden_faqs_meta_box',
        array( 'practice_area', 'location' ),
        'normal',
        'high'
    );

    /* ── Location ──────────────────────────────────────────────────── */

    add_meta_box(
        'roden_office_key',
        __( 'Office Configuration', 'roden-law' ),
        'roden_office_key_meta_box',
        'location',
        'side'
    );

    add_meta_box(
        'roden_service_area',
        __( 'Service Area', 'roden-law' ),
        'roden_service_area_meta_box',
        'location',
        'normal'
    );

    add_meta_box(
        'roden_map_embed',
        __( 'Google Maps Embed URL', 'roden-law' ),
        'roden_map_embed_meta_box',
        'location',
        'side'
    );

    add_meta_box(
        'roden_local_content',
        __( 'Local Content (courts, institutions)', 'roden-law' ),
        'roden_local_content_meta_box',
        'location',
        'normal'
    );

    /* ── Attorney ──────────────────────────────────────────────────── */

    add_meta_box(
        'roden_atty_profile',
        __( 'Attorney Profile', 'roden-law' ),
        'roden_atty_profile_meta_box',
        'attorney',
        'normal',
        'high'
    );

    add_meta_box(
        'roden_atty_education',
        __( 'Education', 'roden-law' ),
        'roden_atty_education_meta_box',
        'attorney',
        'normal'
    );

    add_meta_box(
        'roden_atty_awards',
        __( 'Awards & Recognition', 'roden-law' ),
        'roden_atty_awards_meta_box',
        'attorney',
        'normal'
    );

    /* ── Case Result ──────────────────────────────────────────────── */

    add_meta_box(
        'roden_case_details',
        __( 'Case Result Details', 'roden-law' ),
        'roden_case_details_meta_box',
        'case_result',
        'normal',
        'high'
    );
}

/* ==========================================================================
   PRACTICE AREA META BOX CALLBACKS
   ========================================================================== */

/**
 * Jurisdiction & Statute of Limitations meta box.
 * Handles _roden_jurisdiction (both/GA/SC), _roden_sol_ga, _roden_sol_sc.
 */
function roden_pa_jurisdiction_meta_box( $post ) {
    wp_nonce_field( 'roden_pa_jurisdiction_nonce', '_roden_pa_jurisdiction_nonce' );

    $jurisdiction = get_post_meta( $post->ID, '_roden_jurisdiction', true );
    $sol_ga       = get_post_meta( $post->ID, '_roden_sol_ga', true );
    $sol_sc       = get_post_meta( $post->ID, '_roden_sol_sc', true );
    ?>
    <p>
        <label for="roden_jurisdiction"><strong><?php esc_html_e( 'Jurisdiction:', 'roden-law' ); ?></strong></label><br>
        <select id="roden_jurisdiction" name="_roden_jurisdiction" style="width:100%;">
            <option value=""><?php esc_html_e( '— Select —', 'roden-law' ); ?></option>
            <option value="both" <?php selected( $jurisdiction, 'both' ); ?>><?php esc_html_e( 'Both (GA & SC)', 'roden-law' ); ?></option>
            <option value="GA" <?php selected( $jurisdiction, 'GA' ); ?>><?php esc_html_e( 'Georgia', 'roden-law' ); ?></option>
            <option value="SC" <?php selected( $jurisdiction, 'SC' ); ?>><?php esc_html_e( 'South Carolina', 'roden-law' ); ?></option>
        </select>
    </p>
    <p class="description"><?php esc_html_e( 'Pillar pages: "Both". Intersection pages: auto-detected from office.', 'roden-law' ); ?></p>

    <hr style="margin:12px 0;">

    <p>
        <label for="roden_sol_ga"><strong><?php esc_html_e( 'SOL Override — Georgia:', 'roden-law' ); ?></strong></label><br>
        <input type="text" id="roden_sol_ga" name="_roden_sol_ga"
               value="<?php echo esc_attr( $sol_ga ); ?>" style="width:100%;"
               placeholder="2 years (O.C.G.A. § 9-3-33)">
    </p>
    <p>
        <label for="roden_sol_sc"><strong><?php esc_html_e( 'SOL Override — South Carolina:', 'roden-law' ); ?></strong></label><br>
        <input type="text" id="roden_sol_sc" name="_roden_sol_sc"
               value="<?php echo esc_attr( $sol_sc ); ?>" style="width:100%;"
               placeholder="3 years (S.C. Code § 15-3-530)">
    </p>
    <p class="description"><?php esc_html_e( 'Leave blank to use defaults from firm data config.', 'roden-law' ); ?></p>
    <?php
}

/** PA Office Key meta box (intersection pages). */
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
    <p class="description"><?php esc_html_e( 'Set for intersection pages (PA × Location). Leave blank for pillar or sub-type pages.', 'roden-law' ); ?></p>
    <?php
}

/**
 * Author Attribution meta box (E-E-A-T).
 * Dropdown of published attorney posts for _roden_author_attorney.
 */
function roden_pa_author_meta_box( $post ) {
    wp_nonce_field( 'roden_pa_author_nonce', '_roden_pa_author_nonce' );
    $value = get_post_meta( $post->ID, '_roden_author_attorney', true );

    $attorneys = get_posts( array(
        'post_type'      => 'attorney',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ) );
    ?>
    <p>
        <label for="roden_author_attorney"><strong><?php esc_html_e( 'Attributed Attorney:', 'roden-law' ); ?></strong></label><br>
        <select id="roden_author_attorney" name="_roden_author_attorney" style="width:100%;">
            <option value=""><?php esc_html_e( '— Select Attorney —', 'roden-law' ); ?></option>
            <?php foreach ( $attorneys as $atty ) : ?>
                <option value="<?php echo esc_attr( $atty->ID ); ?>" <?php selected( $value, $atty->ID ); ?>>
                    <?php echo esc_html( $atty->post_title ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <p class="description"><?php esc_html_e( 'Attorney for "About the Author" section and Person schema. Required for E-E-A-T.', 'roden-law' ); ?></p>
    <?php
}

/** FAQs repeater meta box. */
function roden_faqs_meta_box( $post ) {
    wp_nonce_field( 'roden_faqs_nonce', '_roden_faqs_nonce' );
    $faqs = get_post_meta( $post->ID, '_roden_faqs', true );
    if ( ! is_array( $faqs ) || empty( $faqs ) ) {
        $faqs = array( array( 'question' => '', 'answer' => '' ) );
    }
    ?>
    <div id="roden-faq-container">
        <?php foreach ( $faqs as $i => $faq ) : ?>
            <div class="roden-repeater-row" style="margin-bottom:15px;padding:10px;background:#f9f9f9;border:1px solid #ddd;position:relative;">
                <span class="roden-remove-row" style="position:absolute;top:5px;right:8px;cursor:pointer;color:#a00;font-size:18px;" title="Remove">&times;</span>
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
    <button type="button" class="button" id="roden-add-faq"><?php esc_html_e( '+ Add FAQ', 'roden-law' ); ?></button>
    <p class="description"><?php esc_html_e( 'Add 5-8 FAQs per page. Generates FAQPage schema automatically.', 'roden-law' ); ?></p>
    <?php
}

/* ==========================================================================
   LOCATION META BOX CALLBACKS
   ========================================================================== */

/** Office Key dropdown for location pages. */
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

/** Service Area textarea. */
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

/** Map Embed URL. */
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

/** Local Content wysiwyg. */
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

/* ==========================================================================
   ATTORNEY META BOX CALLBACKS
   ========================================================================== */

/**
 * Attorney Profile meta box.
 * Combines: _roden_title, _roden_atty_office_key, _roden_bar_admissions,
 *           _roden_avvo_url, _roden_linkedin_url.
 */
function roden_atty_profile_meta_box( $post ) {
    wp_nonce_field( 'roden_atty_profile_nonce', '_roden_atty_profile_nonce' );

    $title          = get_post_meta( $post->ID, '_roden_title', true );
    $office_key     = get_post_meta( $post->ID, '_roden_atty_office_key', true );
    $bar_admissions = get_post_meta( $post->ID, '_roden_bar_admissions', true );
    $avvo_url       = get_post_meta( $post->ID, '_roden_avvo_url', true );
    $linkedin_url   = get_post_meta( $post->ID, '_roden_linkedin_url', true );

    $firm = roden_firm_data();
    ?>
    <table class="form-table">
        <tr>
            <th><label for="roden_title"><?php esc_html_e( 'Job Title', 'roden-law' ); ?></label></th>
            <td>
                <input type="text" id="roden_title" name="_roden_title"
                       value="<?php echo esc_attr( $title ); ?>"
                       placeholder="e.g. Founding Partner, CEO" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="roden_atty_office_key"><?php esc_html_e( 'Primary Office', 'roden-law' ); ?></label></th>
            <td>
                <select id="roden_atty_office_key" name="_roden_atty_office_key" style="min-width:250px;">
                    <option value=""><?php esc_html_e( '— Select Office —', 'roden-law' ); ?></option>
                    <?php foreach ( $firm['offices'] as $key => $office ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $office_key, $key ); ?>>
                            <?php echo esc_html( $office['city'] . ', ' . $office['state'] ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="roden_bar_admissions"><?php esc_html_e( 'Bar Admissions', 'roden-law' ); ?></label></th>
            <td>
                <textarea id="roden_bar_admissions" name="_roden_bar_admissions"
                          rows="4" class="large-text"><?php echo esc_textarea( $bar_admissions ); ?></textarea>
                <p class="description"><?php esc_html_e( 'One per line. Format: "State Bar — Year" (e.g., "Georgia Bar — 2015")', 'roden-law' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="roden_avvo_url"><?php esc_html_e( 'Avvo Profile URL', 'roden-law' ); ?></label></th>
            <td>
                <input type="url" id="roden_avvo_url" name="_roden_avvo_url"
                       value="<?php echo esc_attr( $avvo_url ); ?>"
                       placeholder="https://www.avvo.com/attorneys/..." class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="roden_linkedin_url"><?php esc_html_e( 'LinkedIn Profile URL', 'roden-law' ); ?></label></th>
            <td>
                <input type="url" id="roden_linkedin_url" name="_roden_linkedin_url"
                       value="<?php echo esc_attr( $linkedin_url ); ?>"
                       placeholder="https://www.linkedin.com/in/..." class="regular-text">
            </td>
        </tr>
    </table>
    <?php
}

/** Education repeater meta box. */
function roden_atty_education_meta_box( $post ) {
    wp_nonce_field( 'roden_atty_education_nonce', '_roden_atty_education_nonce' );
    $education = get_post_meta( $post->ID, '_roden_education', true );
    if ( ! is_array( $education ) || empty( $education ) ) {
        $education = array( array( 'degree' => '', 'institution' => '' ) );
    }
    ?>
    <div id="roden-education-container">
        <?php foreach ( $education as $i => $edu ) : ?>
            <div class="roden-repeater-row" style="margin-bottom:10px;padding:10px;background:#f9f9f9;border:1px solid #ddd;display:flex;gap:10px;align-items:flex-start;position:relative;">
                <span class="roden-remove-row" style="position:absolute;top:5px;right:8px;cursor:pointer;color:#a00;font-size:18px;" title="Remove">&times;</span>
                <div style="flex:1;">
                    <label><?php esc_html_e( 'Degree:', 'roden-law' ); ?></label><br>
                    <input type="text" name="_roden_education[<?php echo (int) $i; ?>][degree]"
                           value="<?php echo esc_attr( $edu['degree'] ?? '' ); ?>" style="width:100%;"
                           placeholder="J.D.">
                </div>
                <div style="flex:1;">
                    <label><?php esc_html_e( 'Institution:', 'roden-law' ); ?></label><br>
                    <input type="text" name="_roden_education[<?php echo (int) $i; ?>][institution]"
                           value="<?php echo esc_attr( $edu['institution'] ?? '' ); ?>" style="width:100%;"
                           placeholder="University of Georgia School of Law">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button" id="roden-add-education"><?php esc_html_e( '+ Add Education', 'roden-law' ); ?></button>
    <?php
}

/** Awards repeater meta box. */
function roden_atty_awards_meta_box( $post ) {
    wp_nonce_field( 'roden_atty_awards_nonce', '_roden_atty_awards_nonce' );
    $awards = get_post_meta( $post->ID, '_roden_awards', true );
    if ( ! is_array( $awards ) || empty( $awards ) ) {
        $awards = array( array( 'award' => '', 'year' => '' ) );
    }
    ?>
    <div id="roden-awards-container">
        <?php foreach ( $awards as $i => $award ) : ?>
            <div class="roden-repeater-row" style="margin-bottom:10px;padding:10px;background:#f9f9f9;border:1px solid #ddd;display:flex;gap:10px;align-items:flex-start;position:relative;">
                <span class="roden-remove-row" style="position:absolute;top:5px;right:8px;cursor:pointer;color:#a00;font-size:18px;" title="Remove">&times;</span>
                <div style="flex:2;">
                    <label><?php esc_html_e( 'Award:', 'roden-law' ); ?></label><br>
                    <input type="text" name="_roden_awards[<?php echo (int) $i; ?>][award]"
                           value="<?php echo esc_attr( $award['award'] ?? '' ); ?>" style="width:100%;"
                           placeholder="Super Lawyers Rising Star">
                </div>
                <div style="flex:1;max-width:100px;">
                    <label><?php esc_html_e( 'Year:', 'roden-law' ); ?></label><br>
                    <input type="text" name="_roden_awards[<?php echo (int) $i; ?>][year]"
                           value="<?php echo esc_attr( $award['year'] ?? '' ); ?>" style="width:100%;"
                           placeholder="2024">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button" id="roden-add-award"><?php esc_html_e( '+ Add Award', 'roden-law' ); ?></button>
    <?php
}

/* ==========================================================================
   CASE RESULT META BOX CALLBACK
   ========================================================================== */

/** Case Result details: amount, type (select), description, attorney. */
function roden_case_details_meta_box( $post ) {
    wp_nonce_field( 'roden_case_details_nonce', '_roden_case_details_nonce' );

    $amount      = get_post_meta( $post->ID, '_roden_case_amount', true );
    $result_type = get_post_meta( $post->ID, '_roden_case_type', true );
    $description = get_post_meta( $post->ID, '_roden_description', true );
    $attorney_id = get_post_meta( $post->ID, '_roden_attorney', true );

    $attorneys = get_posts( array(
        'post_type'      => 'attorney',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ) );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="roden_case_amount"><?php esc_html_e( 'Amount', 'roden-law' ); ?></label></th>
            <td>
                <input type="text" id="roden_case_amount" name="_roden_case_amount"
                       value="<?php echo esc_attr( $amount ); ?>"
                       placeholder="$3,000,000" class="regular-text">
                <p class="description"><?php esc_html_e( 'Display format (e.g., "$3,000,000" or "$250K").', 'roden-law' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="roden_case_type"><?php esc_html_e( 'Result Type', 'roden-law' ); ?></label></th>
            <td>
                <select id="roden_case_type" name="_roden_case_type" style="min-width:200px;">
                    <option value=""><?php esc_html_e( '— Select —', 'roden-law' ); ?></option>
                    <option value="settlement" <?php selected( $result_type, 'settlement' ); ?>><?php esc_html_e( 'Settlement', 'roden-law' ); ?></option>
                    <option value="verdict" <?php selected( $result_type, 'verdict' ); ?>><?php esc_html_e( 'Verdict', 'roden-law' ); ?></option>
                    <option value="recovery" <?php selected( $result_type, 'recovery' ); ?>><?php esc_html_e( 'Recovery', 'roden-law' ); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="roden_description"><?php esc_html_e( 'Description', 'roden-law' ); ?></label></th>
            <td>
                <textarea id="roden_description" name="_roden_description"
                          rows="4" class="large-text"><?php echo esc_textarea( $description ); ?></textarea>
                <p class="description"><?php esc_html_e( 'Brief case summary for display on case results pages.', 'roden-law' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="roden_attorney"><?php esc_html_e( 'Lead Attorney', 'roden-law' ); ?></label></th>
            <td>
                <select id="roden_attorney" name="_roden_attorney" style="min-width:250px;">
                    <option value=""><?php esc_html_e( '— Select Attorney —', 'roden-law' ); ?></option>
                    <?php foreach ( $attorneys as $atty ) : ?>
                        <option value="<?php echo esc_attr( $atty->ID ); ?>" <?php selected( $attorney_id, $atty->ID ); ?>>
                            <?php echo esc_html( $atty->post_title ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

/* ==========================================================================
   SAVE META FIELDS
   ========================================================================== */

add_action( 'save_post', 'roden_save_meta_fields' );
function roden_save_meta_fields( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    /* ── Practice Area: Jurisdiction & SOL ───────────────────────── */

    if ( isset( $_POST['_roden_pa_jurisdiction_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_pa_jurisdiction_nonce'], 'roden_pa_jurisdiction_nonce' ) ) {

        $jurisdiction = sanitize_text_field( $_POST['_roden_jurisdiction'] ?? '' );
        if ( in_array( $jurisdiction, array( 'both', 'GA', 'SC', '' ), true ) ) {
            update_post_meta( $post_id, '_roden_jurisdiction', $jurisdiction );
        }

        update_post_meta( $post_id, '_roden_sol_ga',
            sanitize_text_field( $_POST['_roden_sol_ga'] ?? '' ) );
        update_post_meta( $post_id, '_roden_sol_sc',
            sanitize_text_field( $_POST['_roden_sol_sc'] ?? '' ) );
    }

    /* ── Practice Area: Office Key (intersection) ────────────────── */

    if ( isset( $_POST['_roden_pa_office_key_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_pa_office_key_nonce'], 'roden_pa_office_key_nonce' ) ) {
        update_post_meta( $post_id, '_roden_pa_office_key',
            sanitize_text_field( $_POST['_roden_pa_office_key'] ?? '' ) );
    }

    /* ── Author Attribution ──────────────────────────────────────── */

    if ( isset( $_POST['_roden_pa_author_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_pa_author_nonce'], 'roden_pa_author_nonce' ) ) {
        update_post_meta( $post_id, '_roden_author_attorney',
            absint( $_POST['_roden_author_attorney'] ?? 0 ) );
    }

    /* ── FAQs ────────────────────────────────────────────────────── */

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

    /* ── Location: Office Key ────────────────────────────────────── */

    if ( isset( $_POST['_roden_office_key_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_office_key_nonce'], 'roden_office_key_nonce' ) ) {
        update_post_meta( $post_id, '_roden_office_key',
            sanitize_text_field( $_POST['_roden_office_key'] ?? '' ) );
    }

    /* ── Location: Service Area ──────────────────────────────────── */

    if ( isset( $_POST['_roden_service_area_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_service_area_nonce'], 'roden_service_area_nonce' ) ) {
        update_post_meta( $post_id, '_roden_service_area',
            sanitize_textarea_field( $_POST['_roden_service_area'] ?? '' ) );
    }

    /* ── Location: Map Embed ─────────────────────────────────────── */

    if ( isset( $_POST['_roden_map_embed_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_map_embed_nonce'], 'roden_map_embed_nonce' ) ) {
        update_post_meta( $post_id, '_roden_map_embed',
            esc_url_raw( $_POST['_roden_map_embed'] ?? '' ) );
    }

    /* ── Location: Local Content ─────────────────────────────────── */

    if ( isset( $_POST['_roden_local_content_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_local_content_nonce'], 'roden_local_content_nonce' ) ) {
        update_post_meta( $post_id, '_roden_local_content',
            wp_kses_post( $_POST['_roden_local_content'] ?? '' ) );
    }

    /* ── Attorney: Profile ───────────────────────────────────────── */

    if ( isset( $_POST['_roden_atty_profile_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_atty_profile_nonce'], 'roden_atty_profile_nonce' ) ) {

        update_post_meta( $post_id, '_roden_title',
            sanitize_text_field( $_POST['_roden_title'] ?? '' ) );
        update_post_meta( $post_id, '_roden_atty_office_key',
            sanitize_text_field( $_POST['_roden_atty_office_key'] ?? '' ) );
        update_post_meta( $post_id, '_roden_bar_admissions',
            sanitize_textarea_field( $_POST['_roden_bar_admissions'] ?? '' ) );
        update_post_meta( $post_id, '_roden_avvo_url',
            esc_url_raw( $_POST['_roden_avvo_url'] ?? '' ) );
        update_post_meta( $post_id, '_roden_linkedin_url',
            esc_url_raw( $_POST['_roden_linkedin_url'] ?? '' ) );
    }

    /* ── Attorney: Education ─────────────────────────────────────── */

    if ( isset( $_POST['_roden_atty_education_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_atty_education_nonce'], 'roden_atty_education_nonce' ) ) {
        $raw = $_POST['_roden_education'] ?? array();
        $clean = array();
        if ( is_array( $raw ) ) {
            foreach ( $raw as $edu ) {
                $degree      = sanitize_text_field( $edu['degree'] ?? '' );
                $institution = sanitize_text_field( $edu['institution'] ?? '' );
                if ( $degree || $institution ) {
                    $clean[] = array( 'degree' => $degree, 'institution' => $institution );
                }
            }
        }
        update_post_meta( $post_id, '_roden_education', $clean );
    }

    /* ── Attorney: Awards ────────────────────────────────────────── */

    if ( isset( $_POST['_roden_atty_awards_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_atty_awards_nonce'], 'roden_atty_awards_nonce' ) ) {
        $raw = $_POST['_roden_awards'] ?? array();
        $clean = array();
        if ( is_array( $raw ) ) {
            foreach ( $raw as $item ) {
                $award = sanitize_text_field( $item['award'] ?? '' );
                $year  = sanitize_text_field( $item['year'] ?? '' );
                if ( $award ) {
                    $clean[] = array( 'award' => $award, 'year' => $year );
                }
            }
        }
        update_post_meta( $post_id, '_roden_awards', $clean );
    }

    /* ── Case Result: Details ────────────────────────────────────── */

    if ( isset( $_POST['_roden_case_details_nonce'] ) &&
         wp_verify_nonce( $_POST['_roden_case_details_nonce'], 'roden_case_details_nonce' ) ) {

        update_post_meta( $post_id, '_roden_case_amount',
            sanitize_text_field( $_POST['_roden_case_amount'] ?? '' ) );

        $result_type = sanitize_text_field( $_POST['_roden_case_type'] ?? '' );
        if ( in_array( $result_type, array( 'settlement', 'verdict', 'recovery', '' ), true ) ) {
            update_post_meta( $post_id, '_roden_case_type', $result_type );
        }

        update_post_meta( $post_id, '_roden_description',
            sanitize_textarea_field( $_POST['_roden_description'] ?? '' ) );

        update_post_meta( $post_id, '_roden_attorney',
            absint( $_POST['_roden_attorney'] ?? 0 ) );
    }
}
