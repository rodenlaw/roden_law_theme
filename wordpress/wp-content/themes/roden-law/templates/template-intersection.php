<?php
/**
 * Template: Intersection Page (Practice Area x Location)
 *
 * Displayed for child practice_area posts that have a _roden_pa_office_key
 * matching one of the 6 offices (e.g. /car-accident-lawyers/savannah-ga/).
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Ensure template helpers are available (guard against include-chain failures)
if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}

/* ── Gather data ─────────────────────────────────────────────────────── */

$firm    = roden_firm_data();
$post_id = get_the_ID();
$post    = get_post( $post_id );

$pa_office_key = get_post_meta( $post_id, '_roden_pa_office_key', true );
$office        = $firm['offices'][ $pa_office_key ];
$state_key     = $office['state']; // 'GA' or 'SC'
$jurisdiction  = isset( $firm['jurisdiction'][ $state_key ] ) ? $firm['jurisdiction'][ $state_key ] : null;

$parent_post  = $post->post_parent ? get_post( $post->post_parent ) : null;
$parent_title = $parent_post ? $parent_post->post_title : '';
$parent_url   = $parent_post ? get_permalink( $parent_post ) : '';

$author_id = get_post_meta( $post_id, '_roden_author_attorney', true );

// Practice category for filtering case results
$pa_terms = wp_get_object_terms( $post_id, 'practice_category', array( 'fields' => 'slugs' ) );
if ( is_wp_error( $pa_terms ) ) {
    $pa_terms = array();
}
// Fall back to parent's terms
if ( empty( $pa_terms ) && $parent_post ) {
    $pa_terms = wp_get_object_terms( $parent_post->ID, 'practice_category', array( 'fields' => 'slugs' ) );
    if ( is_wp_error( $pa_terms ) ) {
        $pa_terms = array();
    }
}
$cat_slug = ! empty( $pa_terms ) ? $pa_terms[0] : '';

// Related sub-types (sibling children without an office key)
$related_subtypes_meta_query = array(
    'relation' => 'OR',
    array( 'key' => '_roden_pa_office_key', 'compare' => 'NOT EXISTS' ),
    array( 'key' => '_roden_pa_office_key', 'value' => '', 'compare' => '=' ),
);
if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
    $related_subtypes_meta_query = array(
        'relation' => 'AND',
        $related_subtypes_meta_query,
        roden_es_exclusion_meta_query(),
    );
}
$related_subtypes = get_posts( array(
    'post_type'      => 'practice_area',
    'post_parent'    => $post->post_parent,
    'posts_per_page' => 20,
    'exclude'        => array( $post_id ),
    'orderby'        => 'title',
    'order'          => 'ASC',
    'meta_query'     => $related_subtypes_meta_query,
) );
?>

<!-- ================================================================
     HERO
     ================================================================ -->
<section class="hero hero-intersection">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">
            <div class="hero-content">
                <span class="state-badge state-<?php echo esc_attr( strtolower( $office['state'] ) ); ?>">
                    <?php echo esc_html( $office['state_full'] ); ?>
                </span>
                <h1 class="hero-title"><?php the_title(); ?></h1>
                <p class="hero-subtitle">
                    <?php
                    printf(
                        /* translators: 1: city/market name; 2: lowercase practice area title, e.g. "car accident lawyers"; 3: service area sentence (ends with a period). */
                        esc_html__( 'Roden Law\'s %1$s %2$s serve %3$s No fees unless we win.', 'roden-law' ),
                        esc_html( $office['market_name'] ),
                        esc_html( strtolower( $parent_title ) ),
                        esc_html( $office['service_area'] )
                    );
                    ?>
                </p>

                <?php roden_last_updated_date( $post_id ); ?>

                <!-- NAP Block -->
                <div class="nap-block">
                    <h3 class="nap-name"><?php echo esc_html( $office['name'] ); ?></h3>
                    <div class="nap-details">
                        <div class="nap-col">
                            <span class="nap-label"><?php esc_html_e( 'Address', 'roden-law' ); ?></span>
                            <span><?php echo esc_html( $office['street'] ); ?></span>
                            <span>
                                <?php echo esc_html( $office['city'] ); ?>,
                                <?php echo esc_html( $office['state'] ); ?>
                                <?php echo esc_html( $office['zip'] ); ?>
                            </span>
                        </div>
                        <div class="nap-col">
                            <span class="nap-label"><?php esc_html_e( 'Phone', 'roden-law' ); ?></span>
                            <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="nap-phone">
                                <?php echo esc_html( $office['phone'] ); ?>
                            </a>
                            <span class="nap-hours"><?php esc_html_e( 'Available 24/7', 'roden-law' ); ?></span>
                        </div>
                    </div>
                    <div class="nap-actions">
                        <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary"><?php esc_html_e( 'Call Now', 'roden-law' ); ?></a>
                        <a href="<?php echo esc_url( $office['map_url'] ); ?>" class="btn btn-outline-light" target="_blank" rel="noopener noreferrer nofollow"><?php esc_html_e( 'Get Directions', 'roden-law' ); ?></a>
                    </div>
                </div>
            </div>
            <div class="hero-form hero-map-form">
                <?php roden_contact_form_sidebar( $office['phone'] ); ?>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================
     LOCATION MATRIX — All 6 offices for this practice area
     ================================================================ -->
<section class="section-location-matrix">
    <div class="container">
        <h2 class="matrix-title"><?php printf( /* translators: %s: practice area title. */ esc_html__( '%s — All Locations', 'roden-law' ), esc_html( $parent_title ) ); ?></h2>
        <div class="location-matrix-grid">
            <?php
            // Pre-fetch all sibling intersections in one query (avoid N+1).
            $all_siblings_args = array(
                'post_type'      => 'practice_area',
                'post_parent'    => $post->post_parent,
                'posts_per_page' => 10,
                'meta_key'       => '_roden_pa_office_key',
                'meta_compare'   => 'EXISTS',
            );
            if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
                $all_siblings_args['meta_query'] = roden_es_exclusion_meta_query();
            }
            $all_siblings = get_posts( $all_siblings_args );
            $sibling_urls = array();
            foreach ( $all_siblings as $sib ) {
                $sib_key = get_post_meta( $sib->ID, '_roden_pa_office_key', true );
                if ( $sib_key ) {
                    $sibling_urls[ $sib_key ] = get_permalink( $sib );
                }
            }
            ?>
            <?php foreach ( $firm['offices'] as $key => $o ) :
                $is_current       = ( $key === $pa_office_key );
                $intersection_url = isset( $sibling_urls[ $key ] ) ? $sibling_urls[ $key ] : '#';
            ?>
                <div class="matrix-card <?php echo $is_current ? 'matrix-card-active' : ''; ?>">
                    <span class="matrix-state state-<?php echo esc_attr( strtolower( $o['state'] ) ); ?>">
                        <?php echo esc_html( $o['state'] ); ?>
                    </span>
                    <h3 class="matrix-city">
                        <?php if ( ! $is_current ) : ?>
                            <a href="<?php echo esc_url( $intersection_url ); ?>"><?php echo esc_html( $o['market_name'] ); ?></a>
                        <?php else : ?>
                            <?php echo esc_html( $o['market_name'] ); ?>
                        <?php endif; ?>
                    </h3>
                    <?php if ( $is_current ) : ?>
                        <span class="matrix-current"><?php esc_html_e( 'Current Page', 'roden-law' ); ?></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================================================================
     MAIN CONTENT + SIDEBAR
     ================================================================ -->
<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <!-- MAIN COLUMN -->
        <article class="main-content">

            <!-- AI Definition Block (extractable answer for AI systems) -->
            <?php roden_ai_definition_block( get_the_title() ); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 KEY TAKEAWAYS (extractable summary box for AI/snippets).
                 Renders a hand-written _roden_key_takeaways if set; otherwise
                 auto-generates a jurisdiction-aware summary from the office +
                 firm-data law values already shown in the State Law box below
                 (no new facts — resummarized for extractability, near-zero cost).
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $int_takeaways = get_post_meta( $post_id, '_roden_key_takeaways', true );
            if ( ! $int_takeaways && $jurisdiction ) {
                $ta_label   = strtolower( preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', $parent_title ) );
                if ( '' === $ta_label ) {
                    $ta_label = __( 'accident', 'roden-law' );
                }
                $ta_article = in_array( strtolower( $ta_label[0] ), array( 'a', 'e', 'i', 'o', 'u' ), true ) ? 'an' : 'a';
                // Derive a clean fault threshold from the canonical rule string
                // ("Modified — recover if less than 51% at fault" → "less than 51% at fault").
                $ta_fault = trim( preg_replace( '/^Modified\s*[—-]\s*recover if\s*/i', '', $jurisdiction['comp_fault_rule'] ) );
                if ( '' === $ta_fault ) {
                    $ta_fault = $jurisdiction['comp_fault_rule'];
                }
                $int_takeaways = sprintf(
                    /* translators: 1: article "a"/"an"; 2: accident type, e.g. "car accident"; 3: city/market name; 4: state name; 5: statute-of-limitations years; 6: statute citation; 7: fault threshold phrase, e.g. "less than 51% at fault". */
                    __( 'If you were injured in %1$s %2$s in %3$s, %4$s, you generally have %5$s years from the date of injury to file a lawsuit (%6$s). %4$s follows a modified comparative negligence rule — you can still recover as long as you are %7$s, with your award reduced by your percentage of fault. There is no cap on compensatory damages in an ordinary %4$s injury case. Roden Law represents %3$s injury victims on a contingency fee: the consultation is free and there is no fee unless we win.', 'roden-law' ),
                    esc_html( $ta_article ),
                    esc_html( $ta_label ),
                    esc_html( $office['market_name'] ),
                    esc_html( $office['state_full'] ),
                    esc_html( $jurisdiction['statute_years'] ),
                    esc_html( $jurisdiction['statute_cite'] ),
                    esc_html( $ta_fault )
                );
            }
            if ( $int_takeaways ) : ?>
            <section class="key-takeaways-box" data-ai-extractable="true">
                <h2 class="key-takeaways-title"><?php esc_html_e( 'Key Takeaways', 'roden-law' ); ?></h2>
                <p><?php echo wp_kses_post( $int_takeaways ); ?></p>
            </section>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 WHY HIRE SECTION (uses own content, then parent fallback)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $int_why_hire = get_post_meta( $post_id, '_roden_why_hire', true );
            if ( $int_why_hire ) : ?>
                <div class="content-section pa-why-hire">
                    <h2><?php printf( /* translators: 1: practice area title; 2: city/market name. */ esc_html__( 'Why Hire %1$s in %2$s?', 'roden-law' ), esc_html( $parent_title ), esc_html( $office['market_name'] ) ); ?></h2>
                    <div class="pa-why-hire__body">
                        <?php echo apply_filters( 'the_content', $int_why_hire ); ?>
                    </div>
                </div>
            <?php elseif ( get_the_content() ) : ?>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            <?php elseif ( $parent_post ) :
                $parent_why_hire = get_post_meta( $parent_post->ID, '_roden_why_hire', true );
                if ( $parent_why_hire ) : ?>
                <div class="content-section pa-why-hire">
                    <h2><?php printf( /* translators: 1: practice area title; 2: city/market name. */ esc_html__( 'Why Hire %1$s in %2$s?', 'roden-law' ), esc_html( $parent_title ), esc_html( $office['market_name'] ) ); ?></h2>
                    <div class="pa-why-hire__body">
                        <?php echo apply_filters( 'the_content', $parent_why_hire ); ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 HUB-AND-SPOKE: up-link to the SC statewide pillar (SC only;
                 no-op until the matching SC pillar page is published)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            if ( function_exists( 'roden_sc_statewide_uplink' ) && $parent_post ) {
                roden_sc_statewide_uplink( $office, $parent_post->post_name, $parent_title );
            }
            ?>

            <!-- ═══════════════════════════════════════════════════════════
                 EXPERT QUOTE (AI-citable attorney quote — +30% visibility)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $expert_quote = get_post_meta( $post_id, '_roden_expert_quote', true );
            if ( ! $expert_quote && $parent_post ) {
                $expert_quote = get_post_meta( $parent_post->ID, '_roden_expert_quote', true );
            }
            if ( $expert_quote ) {
                roden_expert_quote_block( $expert_quote, $author_id );
            }
            ?>

            <?php roden_inline_cta_banner(); ?>

            <!-- What to Do Steps (AI-extractable for "what to do after X in Y" queries) -->
            <?php
            $accident_type_label = $parent_title ? strtolower( str_replace( ' Lawyers', '', $parent_title ) ) : __( 'an accident', 'roden-law' );
            // Convert "car accident" to "a car accident"
            if ( strpos( $accident_type_label, 'a ' ) !== 0 && strpos( $accident_type_label, 'an ' ) !== 0 ) {
                $vowels = array( 'a', 'e', 'i', 'o', 'u' );
                $article = in_array( strtolower( $accident_type_label[0] ), $vowels ) ? 'an ' : 'a ';
                $accident_type_label = $article . $accident_type_label;
            }
            roden_what_to_do_steps(
                $accident_type_label,
                $office['market_name'] . ', ' . $office['state'],
                $office['state_full']
            );
            ?>

            <!-- State Law Box (single jurisdiction) -->
            <?php if ( $jurisdiction ) : ?>
            <div class="content-section">
                <div class="state-law-box">
                    <h3><?php printf( /* translators: %s: state name, e.g. "Georgia". */ esc_html__( '%s Personal Injury Law', 'roden-law' ), esc_html( $jurisdiction['state_full'] ) ); ?></h3>
                    <div class="law-details-grid">
                        <div class="law-detail">
                            <span class="law-label"><?php esc_html_e( 'Statute of Limitations', 'roden-law' ); ?></span>
                            <span class="law-value">
                                <?php printf( /* translators: 1: number of years; 2: statute citation. */ esc_html__( '%1$s years (%2$s)', 'roden-law' ), esc_html( $jurisdiction['statute_years'] ), esc_html( $jurisdiction['statute_cite'] ) ); ?>
                            </span>
                        </div>
                        <div class="law-detail">
                            <span class="law-label"><?php esc_html_e( 'Comparative Fault', 'roden-law' ); ?></span>
                            <span class="law-value">
                                <?php echo esc_html( $jurisdiction['comp_fault_rule'] ); ?>
                                <?php if ( $jurisdiction['comp_fault_cite'] ) : ?>
                                    (<?php echo esc_html( $jurisdiction['comp_fault_cite'] ); ?>)
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 OFFICE LOCAL CONTEXT (per-office "Filing in [Court]")
                 No-op when office has no local_context configured.
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_office_local_context_block( $office, $jurisdiction ); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 NEGLIGENCE / LIABILITY FRAMING
                 Pillar override (when _roden_pillar_negligence_intro set on
                 parent) replaces the generic 4-element block. Falls back to
                 the universal 4-element block for pillars without overrides.
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $accident_label_clean    = strtolower( preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', $parent_title ) );
            $pillar_negligence_html  = $parent_post
                ? roden_render_pillar_intro( $parent_post->ID, '_roden_pillar_negligence_intro', $office, $jurisdiction )
                : '';
            ?>
            <?php if ( $pillar_negligence_html ) : ?>
            <div class="content-section pa-pillar-negligence" data-ai-extractable="true">
                <h2><?php printf( /* translators: 1: capitalized accident type, e.g. "Car accident"; 2: city/market name. */ esc_html__( 'Do I Have a %1$s Case in %2$s?', 'roden-law' ), esc_html( ucfirst( $accident_label_clean ) ), esc_html( $office['market_name'] ) ); ?></h2>
                <?php echo $pillar_negligence_html; ?>
            </div>
            <?php else : ?>
            <div class="content-section pa-elements-section" data-ai-extractable="true">
                <h2><?php printf( /* translators: 1: capitalized accident type, e.g. "Car accident"; 2: city/market name. */ esc_html__( 'Do I Have a %1$s Case in %2$s?', 'roden-law' ), esc_html( ucfirst( $accident_label_clean ) ), esc_html( $office['market_name'] ) ); ?></h2>
                <p><?php printf( /* translators: %s: state name. */ esc_html__( 'To win a personal injury case in %s, your attorney must prove four elements of negligence by a preponderance of the evidence.', 'roden-law' ), esc_html( $office['state_full'] ) ); ?></p>
                <div class="pa-elements">
                    <?php
                    $elements = array(
                        array( 'num' => '01', 'title' => __( 'Duty of Care', 'roden-law' ), 'body' => __( 'The other party owed you a legal duty to act in a manner that ensured your safety.', 'roden-law' ) ),
                        array( 'num' => '02', 'title' => __( 'Breach of Duty', 'roden-law' ), 'body' => __( 'The other party breached that duty by failing to act as a reasonably prudent person would have in the same situation.', 'roden-law' ) ),
                        array( 'num' => '03', 'title' => __( 'Causation', 'roden-law' ), 'body' => __( 'The breach directly caused your injuries. We gather evidence proving that but for their negligence, you would not have been harmed.', 'roden-law' ) ),
                        array( 'num' => '04', 'title' => __( 'Damages', 'roden-law' ), 'body' => __( 'You suffered actual, quantifiable damages — medical expenses, lost income, pain and suffering — as a direct result of the at-fault party\'s breach.', 'roden-law' ) ),
                    );
                    foreach ( $elements as $el ) : ?>
                        <div class="pa-element">
                            <div class="pa-element__num"><?php echo esc_html( $el['num'] ); ?></div>
                            <div class="pa-element__content">
                                <h3><?php echo esc_html( $el['title'] ); ?></h3>
                                <p><?php echo esc_html( $el['body'] ); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 COMPENSATION / DAMAGES FRAMING
                 Pillar override (when _roden_pillar_compensation_intro set on
                 parent) replaces the generic two-column block. Falls back to
                 the universal economic/non-economic split.
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $pillar_compensation_html = $parent_post
                ? roden_render_pillar_intro( $parent_post->ID, '_roden_pillar_compensation_intro', $office, $jurisdiction )
                : '';
            ?>
            <?php if ( $pillar_compensation_html ) : ?>
            <div class="content-section pa-pillar-compensation" data-ai-extractable="true">
                <h2><?php printf( /* translators: 1: state name; 2: capitalized accident type, e.g. "Car accident". */ esc_html__( 'Types of Compensation in %1$s %2$s Cases', 'roden-law' ), esc_html( $office['state_full'] ), esc_html( ucfirst( $accident_label_clean ) ) ); ?></h2>
                <?php echo $pillar_compensation_html; ?>
            </div>
            <?php else : ?>
            <div class="content-section pa-compensation" data-ai-extractable="true">
                <h2><?php printf( /* translators: 1: state name; 2: capitalized accident type, e.g. "Car accident". */ esc_html__( 'Types of Compensation in %1$s %2$s Cases', 'roden-law' ), esc_html( $office['state_full'] ), esc_html( ucfirst( $accident_label_clean ) ) ); ?></h2>
                <p class="section-lead"><?php printf( /* translators: 1: lowercase accident type; 2: state name. */ esc_html__( 'Victims of %1$s injuries in %2$s can pursue two categories of damages: economic damages (quantifiable financial losses) and non-economic damages (quality-of-life impacts). There is no cap on compensatory damages in %2$s.', 'roden-law' ), esc_html( $accident_label_clean ), esc_html( $office['state_full'] ) ); ?></p>
                <div class="pa-compensation__grid">
                    <div class="pa-compensation__col">
                        <h3><?php esc_html_e( 'Economic Damages', 'roden-law' ); ?></h3>
                        <ul>
                            <li><?php esc_html_e( 'Past and future medical expenses', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Lost wages or income', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Loss of earning capacity', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Property damage and vehicle repair/replacement', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Cost of rehabilitation and physical therapy', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Assistive medical equipment', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Cost of long-term or lifelong care', 'roden-law' ); ?></li>
                        </ul>
                    </div>
                    <div class="pa-compensation__col">
                        <h3><?php esc_html_e( 'Non-Economic Damages', 'roden-law' ); ?></h3>
                        <ul>
                            <li><?php esc_html_e( 'Pain and suffering', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Mental and emotional distress', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Loss of companionship (spouse/family)', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Disability and disfigurement', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Loss of enjoyment of life', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Humiliation or loss of reputation', 'roden-law' ); ?></li>
                        </ul>
                        <p class="pa-compensation__note"><em><?php esc_html_e( 'Non-economic damages can only be pursued through a personal injury lawsuit, not a standard insurance claim.', 'roden-law' ); ?></em></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php roden_inline_cta_banner(); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 AI STATISTICS BLOCK (+37% visibility)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_ai_stats_block( get_the_title() ); ?>

            <!-- Office Attorneys -->
            <div class="content-section">
                <h2><?php printf( /* translators: %s: city/market name. */ esc_html__( 'Our %s Attorneys', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h2>
                <?php roden_attorneys_grid( array( 'office_key' => $pa_office_key, 'columns' => 3 ) ); ?>
            </div>

            <!-- Case Results -->
            <div class="content-section">
                <h2><?php esc_html_e( 'Recent Case Results', 'roden-law' ); ?></h2>
                <?php roden_case_results_grid( array( 'count' => 3, 'columns' => 3, 'practice_category' => $cat_slug ) ); ?>
            </div>

            <!-- Related Guides & Resources (local + practice-area filtered) -->
            <?php
            roden_related_resources( array(
                'count'      => 4,
                'cat_slug'   => $cat_slug,
                'office_key' => $pa_office_key,
                'heading'    => sprintf( /* translators: %s: practice area title. */ __( 'Local %s Resources', 'roden-law' ), $parent_title ),
                'display'    => 'section',
            ) );
            ?>

            <!-- Author Attribution (E-E-A-T) -->
            <?php if ( $author_id ) :
                $atty = get_post( $author_id );
                if ( $atty ) :
                    $atty_title = get_post_meta( $atty->ID, '_roden_atty_title', true );
            ?>
            <div class="content-section author-attribution">
                <h2><?php esc_html_e( 'About the Author', 'roden-law' ); ?></h2>
                <div class="author-card">
                    <div class="author-photo">
                        <?php if ( has_post_thumbnail( $atty ) ) : ?>
                            <?php echo get_the_post_thumbnail( $atty, 'thumbnail', array( 'alt' => esc_attr( sprintf( /* translators: 1: attorney name; 2: attorney title. */ __( '%1$s, %2$s at Roden Law', 'roden-law' ), $atty->post_title, $atty_title ) ) ) ); ?>
                        <?php else : ?>
                            <div class="author-photo-placeholder"></div>
                        <?php endif; ?>
                    </div>
                    <div class="author-info">
                        <h3 class="author-name">
                            <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>">
                                <?php echo esc_html( $atty->post_title ); ?>
                            </a>
                        </h3>
                        <?php if ( $atty_title ) : ?>
                            <span class="author-title"><?php echo esc_html( $atty_title ); ?></span>
                        <?php endif; ?>
                        <?php if ( $atty->post_excerpt ) : ?>
                            <p class="author-bio"><?php echo wp_kses_post( $atty->post_excerpt ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; endif; ?>

            <!-- FAQ Accordion -->
            <?php roden_faq_section( $post_id ); ?>

            <!-- Bottom CTA -->
            <div class="bottom-cta-box">
                <h2><?php printf( /* translators: %s: city/market name. */ esc_html__( 'Contact Our %s Office Today', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h2>
                <p>
                    <?php
                    printf(
                        /* translators: 1: city/market name; 2: phone number link. */
                        esc_html__( 'If you were injured in %1$s and believe another party is at fault, contact us for a free, no-obligation review. Call %2$s — no upfront cost.', 'roden-law' ),
                        esc_html( $office['market_name'] ),
                        '<a href="tel:' . esc_attr( $office['phone_raw'] ) . '">' . esc_html( $office['phone'] ) . '</a>'
                    );
                    ?>
                </p>
                <div class="cta-actions">
                    <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary">
                        <?php printf( /* translators: %s: phone number. */ esc_html__( 'Call %s', 'roden-law' ), esc_html( $office['phone'] ) ); ?>
                    </a>
                    <a href="#contact" class="btn btn-outline-light"><?php esc_html_e( 'Free Case Review', 'roden-law' ); ?></a>
                </div>
            </div>

        </article>

        <!-- SIDEBAR -->
        <aside class="sidebar sidebar-practice">
            <div class="sidebar-sticky">

                <!-- Contact Form -->
                <?php roden_contact_form_sidebar( $office['phone'] ); ?>

                <!-- Back to Pillar -->
                <?php if ( $parent_post ) : ?>
                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php esc_html_e( 'Main Practice Area', 'roden-law' ); ?></h3>
                    <a href="<?php echo esc_url( $parent_url ); ?>" class="sidebar-back-link">
                        &larr; <?php echo esc_html( $parent_title ); ?>
                    </a>
                </div>
                <?php endif; ?>

                <!-- Related Sub-Types -->
                <?php if ( $related_subtypes ) : ?>
                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php esc_html_e( 'Related Case Types', 'roden-law' ); ?></h3>
                    <ul class="sidebar-links">
                        <?php foreach ( $related_subtypes as $sib ) : ?>
                            <li>
                                <a href="<?php echo esc_url( get_permalink( $sib ) ); ?>">
                                    &rarr; <?php echo esc_html( $sib->post_title ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Sidebar NAP Card -->
                <div class="sidebar-widget sidebar-nap-card">
                    <h3 class="nap-card-name"><?php echo esc_html( $office['name'] ); ?></h3>
                    <address>
                        <?php echo esc_html( $office['street'] ); ?><br>
                        <?php echo esc_html( $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] ); ?>
                    </address>
                    <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="nap-card-phone">
                        <?php echo esc_html( $office['phone'] ); ?>
                    </a>
                    <a href="<?php echo esc_url( $office['map_url'] ); ?>" class="btn btn-dark btn-block" target="_blank" rel="noopener noreferrer nofollow">
                        <?php esc_html_e( 'View on Google Maps', 'roden-law' ); ?>
                    </a>
                </div>

                <!-- Filing Deadline (single state) -->
                <?php if ( $jurisdiction ) : ?>
                <div class="sidebar-widget sidebar-deadlines">
                    <h3 class="widget-title"><?php printf( /* translators: %s: state name. */ esc_html__( '%s Filing Deadline', 'roden-law' ), esc_html( $jurisdiction['state_full'] ) ); ?></h3>
                    <div class="deadline-badges">
                        <div class="deadline-badge <?php echo $state_key === 'GA' ? 'deadline-ga' : 'deadline-sc'; ?>" style="flex:1;">
                            <span class="deadline-years"><?php printf( /* translators: %s: number of years. */ esc_html__( '%s yr', 'roden-law' ), esc_html( $jurisdiction['statute_years'] ) ); ?></span>
                            <span class="deadline-state"><?php echo esc_html( $jurisdiction['state_full'] ); ?></span>
                        </div>
                    </div>
                    <p class="deadline-warning"><?php esc_html_e( 'Missing the deadline forfeits your right to recover.', 'roden-law' ); ?></p>
                </div>
                <?php endif; ?>

                <!-- Why Roden Law -->
                <div class="sidebar-widget sidebar-why-us">
                    <h3 class="widget-title"><?php esc_html_e( 'Why Roden Law?', 'roden-law' ); ?></h3>
                    <ul class="why-us-list">
                        <li><?php printf( /* translators: %s: amount recovered, e.g. "$300M+". */ esc_html__( '%s Recovered for Clients', 'roden-law' ), esc_html( $firm['recovered'] ) ); ?></li>
                        <li><?php printf( /* translators: %s: star rating, e.g. "4.9". */ esc_html__( '%s Average Client Rating', 'roden-law' ), esc_html( $firm['rating'] ) ); ?></li>
                        <li><?php printf( /* translators: %s: number of cases handled, e.g. "5,000+". */ esc_html__( '%s Cases Successfully Handled', 'roden-law' ), esc_html( $firm['cases_handled'] ) ); ?></li>
                        <li><?php esc_html_e( 'No Fee Unless We Win', 'roden-law' ); ?></li>
                        <li><?php esc_html_e( 'Free 24/7 Consultations', 'roden-law' ); ?></li>
                        <li><?php esc_html_e( 'Licensed in GA & SC', 'roden-law' ); ?></li>
                    </ul>
                </div>

            </div>
        </aside>

    </div>
</div>
