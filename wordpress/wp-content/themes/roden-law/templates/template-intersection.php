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

// Resolve through roden_market(), which covers the 6 offices AND the
// service-area towns served from them. The previous
// $firm['offices'][ $pa_office_key ] was unguarded and fatalled on any key it
// did not know — including every service area.
$office = roden_market( $pa_office_key );

// An unresolvable key is a data error (meta pointing at a market that no
// longer exists). Bail to the sub-type template rather than fatalling.
if ( null === $office ) {
    if ( current_user_can( 'edit_posts' ) ) {
        echo '<div class="container"><p><strong>' . esc_html__( 'Configuration error:', 'roden-law' ) . '</strong> '
            . esc_html__( 'this page\'s market key does not match any office or service area.', 'roden-law' )
            . '</p></div>';
    }
    return;
}

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
if ( function_exists( 'roden_locale_meta_query' ) ) {
    $related_subtypes_meta_query = array(
        'relation' => 'AND',
        $related_subtypes_meta_query,
        roden_locale_meta_query(),
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

// Drop sub-types scoped to the other state (Boeing is a South Carolina
// employer) and promote the ones that define this market. Sidebar and the
// in-content grid both render from this list so they can never disagree.
$related_subtypes = roden_filter_subtypes_for_state(
    $related_subtypes,
    $state_key,
    $pa_office_key
);

// Practice-area aware deadline. $int_is_statutory marks schemes that run on
// their own statutory track (workers' compensation) rather than tort law —
// several sections below are wrong for those and must branch or be skipped.
$int_statute      = roden_resolve_statute( $state_key );
$int_is_statutory = ( $int_statute && $int_statute['is_override'] );
// Wrongful death is derivative: the fault that counts is the person who died,
// not the reader's (Charleston wrongful death sweep, 2026-09-28, W1/W5).
$int_is_wd = ( $parent_post && 'wrongful-death-lawyers' === preg_replace( '/^es-/', '', $parent_post->post_name ) );
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
                    <h2 class="nap-name"><?php echo esc_html( $office['name'] ); ?></h2>
                    <?php if ( ! empty( $office['is_service_area'] ) ) : ?>
                        <?php // The firm has no office in this town. Say so plainly, above
                              // the address, so the parent office's address below is never
                              // read as a local one. ?>
                        <p class="nap-serving-note"><?php
                            printf(
                                /* translators: 1: town served, e.g. "Summerville"; 2: office the firm actually occupies, e.g. "North Charleston". */
                                esc_html__( 'We serve %1$s clients from our %2$s office — there is no Roden Law office in %1$s.', 'roden-law' ),
                                esc_html( $office['market_name'] ),
                                esc_html( $office['parent_office_name'] )
                            );
                        ?></p>
                    <?php endif; ?>
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
<?php
    // Pre-fetch all sibling intersections in one query (avoid N+1).
    $all_siblings_args = array(
        'post_type'      => 'practice_area',
        'post_parent'    => $post->post_parent,
        // Was 10, which silently truncated once markets outgrew the six
        // offices — leaving office cards unlinked at random.
        'posts_per_page' => -1,
        'meta_key'       => '_roden_pa_office_key',
        'meta_compare'   => 'EXISTS',
    );
    if ( function_exists( 'roden_locale_meta_query' ) ) {
        $all_siblings_args['meta_query'] = roden_locale_meta_query();
    }
    $all_siblings = get_posts( $all_siblings_args );
    $sibling_urls = array();
    foreach ( $all_siblings as $sib ) {
        $sib_key = get_post_meta( $sib->ID, '_roden_pa_office_key', true );
        if ( $sib_key ) {
            $sibling_urls[ $sib_key ] = get_permalink( $sib );
        }
    }
    // Every other office practice page was retired (#142/#143); only the
    // allowlisted ones come back. A grid with one card is noise, so it renders
    // only once a second office in this practice is live.
if ( count( $sibling_urls ) >= 2 ) :
?>
<section class="section-location-matrix">
    <div class="container">
        <h3 class="matrix-title"><?php printf( /* translators: %s: practice area title. */ esc_html__( '%s — All Locations', 'roden-law' ), esc_html( $parent_title ) ); ?></h3>
        <div class="location-matrix-grid">
            <?php foreach ( $firm['offices'] as $key => $o ) :
                $is_current = ( $key === $pa_office_key );
                // No sibling for this office → render the city unlinked rather
                // than href="#". Rare in English (all six offices have pages for
                // most pillars); the norm on /es/, where only four practice
                // areas have city pages so far.
                $intersection_url = isset( $sibling_urls[ $key ] ) ? $sibling_urls[ $key ] : '';
            ?>
                <div class="matrix-card <?php echo $is_current ? 'matrix-card-active' : ''; ?>">
                    <span class="matrix-state state-<?php echo esc_attr( strtolower( $o['state'] ) ); ?>">
                        <?php echo esc_html( $o['state'] ); ?>
                    </span>
                    <h3 class="matrix-city">
                        <?php if ( ! $is_current && $intersection_url ) : ?>
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
<?php endif; ?>

<!-- ================================================================
     MAIN CONTENT + SIDEBAR
     ================================================================ -->
<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <!-- MAIN COLUMN -->
        <article class="main-content">

            <!-- AI Definition Block (extractable answer for AI systems) -->
            <?php
            // roden_pa_noun() returns get_the_title() unchanged for practice
            // areas that have not opted in, so $int_def_place stays empty and
            // those pages keep their existing heading.
            $int_def_noun  = roden_pa_noun();
            $int_def_place = ( $int_def_noun !== get_the_title() )
                ? $office['market_name'] . ', ' . $office['state']
                : '';
            roden_ai_definition_block( $int_def_noun, '', $int_def_place );
            ?>

            <!-- ═══════════════════════════════════════════════════════════
                 KEY TAKEAWAYS (extractable summary box for AI/snippets).
                 Generator lives in inc/template-tags.php so the pillar and
                 sub-type templates render the same box from the same values —
                 CLAUDE.md records that a practice-area fix applied to one of
                 these four templates and not the others "has bitten twice".
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_pa_key_takeaways_box( $post_id, $office ); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 OFFICE + EMBEDDED MAP. The ranking page carries the office's
                 NAP and a map of its Business Profile, the way competitors'
                 winning city pages do (docs/site-architecture/README.md).
                 Only rendered for a real office — never a service-area town.
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $int_map = get_post_meta( $post_id, '_roden_map_embed', true );
            if ( ! $int_map && ! empty( $office['map_embed'] ) ) {
                $int_map = $office['map_embed'];
            }
            if ( $int_map && empty( $office['is_service_area'] ) ) : ?>
                <div class="content-section intersection-office" id="office">
                    <h2><?php printf( /* translators: %s: city/market name. */ esc_html__( 'Visit Our %s Office', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h2>
                    <div class="map-embed">
                        <iframe
                            title="<?php printf( esc_attr__( 'Location map for Roden Law — %s', 'roden-law' ), esc_attr( $office['market_name'] ) ); ?>"
                            src="<?php echo esc_url( $int_map ); ?>"
                            width="100%" height="380"
                            style="border:0;"
                            allowfullscreen loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <div class="map-nap-bar">
                        <div class="map-nap-inner">
                            <div class="map-nap-address">
                                <strong><?php echo esc_html( $office['name'] ); ?></strong>
                                <span><?php echo esc_html( $office['street'] . ', ' . $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] ); ?></span>
                            </div>
                            <div class="map-nap-actions">
                                <a href="tel:<?php echo esc_attr( $office['phone_raw'] ); ?>" class="btn btn-primary"><?php echo esc_html( $office['phone'] ); ?></a>
                                <a href="<?php echo esc_url( $office['map_url'] ); ?>" class="btn btn-outline-light" target="_blank" rel="noopener noreferrer nofollow"><?php esc_html_e( 'Get Directions', 'roden-law' ); ?></a>
                            </div>
                        </div>
                    </div>
                    <?php if ( ! empty( $office['directions'] ) && 'es' !== ( function_exists( 'roden_current_lang' ) ? roden_current_lang() : 'en' ) ) : ?>
                        <p><strong><?php esc_html_e( 'Getting here:', 'roden-law' ); ?></strong> <?php echo esc_html( $office['directions'] ); ?></p>
                    <?php endif; ?>
                </div>
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
            // Locale-safe accident phrase, office city and state all resolve in
            // roden_what_to_do_context() so the HowTo schema in
            // schema-helpers.php renders from the same values.
            $wtd_ctx             = roden_what_to_do_context();
            $accident_type_label = $wtd_ctx['accident_phrase'];
            roden_what_to_do_steps(
                $accident_type_label,
                $wtd_ctx['city'],
                $wtd_ctx['state_full'],
                $wtd_ctx['state_key']
            );
            ?>

            <!-- State Law Box (single jurisdiction) -->
            <?php
            if ( $jurisdiction && $int_statute ) :
                // Heading names the practice area, not a hardcoded "Personal
                // Injury" — a workers' comp page reading "Georgia Personal
                // Injury Law" is both wrong and confusing.
                $int_law_noun = roden_pa_noun( __( 'Personal Injury', 'roden-law' ) );
                ?>
            <div class="content-section">
                <div class="state-law-box">
                    <h3><?php printf( /* translators: 1: state name, e.g. "Georgia"; 2: practice area noun, e.g. "Workers' Compensation". */ esc_html__( '%1$s %2$s Law', 'roden-law' ), esc_html( $jurisdiction['state_full'] ), esc_html( $int_law_noun ) ); ?></h3>
                    <div class="law-details-grid">
                        <div class="law-detail">
                            <span class="law-label"><?php echo esc_html( $int_statute['is_override'] ? __( 'Deadline to File a Claim', 'roden-law' ) : __( 'Statute of Limitations', 'roden-law' ) ); ?></span>
                            <span class="law-value">
                                <?php if ( ! empty( $int_statute['deadline_detail'] ) ) : ?>
                                    <?php echo esc_html( $int_statute['deadline_detail'] ); ?>
                                <?php else : ?>
                                <?php printf( /* translators: 1: number of years; 2: statute citation. */ esc_html( _n( '%1$s year (%2$s)', '%1$s years (%2$s)', (int) $int_statute['statute_years'], 'roden-law' ) ), esc_html( $int_statute['statute_years'] ), esc_html( $int_statute['statute_cite'] ) ); ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php if ( $int_statute['notice_label'] && $int_statute['notice_detail'] ) : ?>
                        <div class="law-detail">
                            <span class="law-label"><?php echo esc_html( $int_statute['notice_label'] ); ?></span>
                            <span class="law-value"><?php echo esc_html( $int_statute['notice_detail'] ); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if ( $int_statute['is_override'] ) : ?>
                        <div class="law-detail">
                            <span class="law-label"><?php esc_html_e( 'Fault', 'roden-law' ); ?></span>
                            <span class="law-value"><?php esc_html_e( 'No-fault — benefits do not depend on proving employer negligence', 'roden-law' ); ?></span>
                        </div>
                        <?php else : ?>
                        <div class="law-detail">
                            <span class="law-label"><?php esc_html_e( 'Comparative Fault', 'roden-law' ); ?></span>
                            <span class="law-value">
                                <?php
                                // Runtime lookup: firm-data rule strings have
                                // hand-added msgids in es_ES.po (make-pot can't
                                // extract variable msgids).
                                if ( $int_is_wd && 'South Carolina' === $jurisdiction['state_full'] ) {
                                    esc_html_e( 'Modified — no recovery if the person who died was more than 50% at fault', 'roden-law' );
                                } else {
                                    echo esc_html( __( $jurisdiction['comp_fault_rule'], 'roden-law' ) ); // phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText
                                }
                                ?>
                                <?php if ( $jurisdiction['comp_fault_cite'] ) : ?>
                                    (<?php echo esc_html( $jurisdiction['comp_fault_cite'] ); ?>)
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 TYPES OF CASES WE HANDLE (Sub-Types)
                 Mirrors the pillar page's #pa-case-types grid so a visitor who
                 lands on the city page gets the same routes into the sub-type
                 pages. Uses the state-filtered $related_subtypes above, so the
                 sidebar list and this grid always match.
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( $related_subtypes ) : ?>
                <div class="content-section" id="pa-case-types">
                    <h2><?php
                    printf(
                        /* translators: 1: practice area noun, e.g. "Workers' Compensation"; 2: city/market name. */
                        esc_html__( 'Types of %1$s Cases We Handle in %2$s', 'roden-law' ),
                        esc_html( roden_pa_noun( $parent_title ) ),
                        esc_html( $office['market_name'] )
                    );
                    ?></h2>
                    <div class="sub-types-grid">
                        <?php foreach ( $related_subtypes as $cst ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $cst ) ); ?>" class="sub-type-card sub-type-link">
                                <span class="st-name"><?php echo esc_html( $cst->post_title ); ?></span>
                                <span class="st-arrow">&rarr;</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 OFFICE LOCAL CONTEXT (per-office "Filing in [Court]")
                 No-op when office has no local_context configured.
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            /*
             * The default per-office essay describes filing a civil complaint
             * in superior court under the tort SOL — wrong on a comp page, so
             * statutory pages request their own variant. Offices without one
             * render nothing rather than the misleading default.
             */
            // Wrongful death uses the office's 'wd' essay where one exists (its
            // fault sentence is about the person who died); otherwise the default.
            // Medical malpractice likewise uses a 'mm' essay: the default names
            // § 15-3-530, but med mal runs on § 15-3-545 (med mal sweep, E1).
            $int_is_mm = ( $parent_post && 'medical-malpractice-lawyers' === preg_replace( '/^es-/', '', $parent_post->post_name ) );
            $int_essay = $int_is_statutory ? 'wc' : ( ( $int_is_wd && ! empty( $office['local_context_wd'] ) ) ? 'wd' : ( ( $int_is_mm && ! empty( $office['local_context_mm'] ) ) ? 'mm' : '' ) );
            roden_office_local_context_block( $office, $jurisdiction, $int_essay );
            ?>

            <!-- ═══════════════════════════════════════════════════════════
                 PILLAR LINK — negligence and compensation live on the pillar.

                 Until 2026-10-23 this template re-rendered the pillar's generic
                 sections on every city page: the four elements of negligence
                 (or the pillar's negligence intro), the compensation columns,
                 a second CTA banner and the AI statistics block. With place
                 names masked, Charleston, Columbia and North Charleston car
                 accident shared 67-76% of their text and the 11 city pages a
                 median 57% (content-similarity baseline 2026-10-23). The same
                 treatment the scenario template got on 2026-09-25: the city
                 page keeps what is local (office, filing court and local
                 context, the state-law box with the deadline and fault rule,
                 the "what to do" steps that feed the HowTo schema) and links to
                 the pillar for the general law. Same string as
                 template-subtype.php's rules box.
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( $parent_post ) : ?>
            <div class="content-section">
                <p class="pa-rules__more"><a href="<?php echo esc_url( $parent_url ); ?>"><?php printf(
                    /* translators: %s: pillar practice area title, e.g. "Dog Bite Lawyers". */
                    esc_html__( 'How negligence, compensation, deadlines and fault work: %s', 'roden-law' ),
                    esc_html( $parent_title )
                ); ?> &rarr;</a></p>
            </div>
            <?php endif; ?>

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
                'heading'    => sprintf( /* translators: %s: practice area noun. */ __( 'Local %s Resources', 'roden-law' ), roden_pa_noun( $parent_title ) ),
                'fallback_heading' => sprintf( /* translators: 1: state name; 2: practice area noun. */ __( '%1$s %2$s Resources', 'roden-law' ), $office['state_full'], roden_pa_noun( $parent_title ) ),
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

            <?php
            // The city page keeps only the FAQs that are its own (copied
            // entries were removed 2026-10-23, bin/apply-city-faq-dedupe.php);
            // the pillar carries the full set. One page may now have none.
            if ( $parent_post ) : ?>
            <div class="content-section">
                <p class="pa-rules__more"><a href="<?php echo esc_url( $parent_url . '#faq' ); ?>"><?php printf(
                    /* translators: %s: practice area noun, e.g. "Car Accident". */
                    esc_html__( 'More %s questions, answered on our main page', 'roden-law' ),
                    esc_html( roden_pa_noun( $parent_title ) )
                ); ?> &rarr;</a></p>
            </div>
            <?php endif; ?>

            <!-- Bottom CTA -->
            <div class="bottom-cta-box">
                <h2><?php printf( /* translators: %s: city/market name. */ esc_html__( 'Contact Our %s Office Today', 'roden-law' ), esc_html( $office['market_name'] ) ); ?></h2>
                <p>
                    <?php
                    printf(
                        /* translators: 1: city/market name; 2: phone number link. */
                        // No-fault claims get their own line (Charleston WC sweep, W5).
                        $int_is_statutory
                            ? esc_html__( 'If you were hurt on the job in %1$s, contact us for a free, no-obligation review of your workers’ compensation claim and any third-party claim. Call %2$s — no upfront cost.', 'roden-law' )
                            : ( $int_is_wd
                            ? esc_html__( 'If you lost a loved one in %1$s because of someone else’s negligence, contact us for a free, confidential review. Call %2$s — no upfront cost.', 'roden-law' )
                            : esc_html__( 'If you were injured in %1$s and believe another party is at fault, contact us for a free, no-obligation review. Call %2$s — no upfront cost.', 'roden-law' ) ),
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
                    <h3 class="nap-card-name"><?php echo esc_html( $office['name'] ); ?></h2>
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
                <?php
                // Reuse the statute resolved at the top of the template. Resolving
                // again here ran after the resources/results loops had moved the
                // current post, so the practice-area override was missed and a
                // workers' comp page showed the 3-year tort deadline instead of
                // the 2-year claim deadline (Charleston WC rebuild, 2026-09-26).
                $sb_statute = $int_statute;
                if ( $jurisdiction && $sb_statute ) : ?>
                <div class="sidebar-widget sidebar-deadlines">
                    <?php
                    // Workers' comp: same English, but Spanish says "Reclamo" (a comp
                    // claim), not "Demanda" (a lawsuit); state name via the catalog
                    // (T-ES5/T-ES6, matching the pillar).
                    $sb_state_label = ( 'GA' === $state_key ) ? __( 'Georgia', 'roden-law' ) : ( ( 'SC' === $state_key ) ? __( 'South Carolina', 'roden-law' ) : $jurisdiction['state_full'] );
                    ?>
                    <h3 class="widget-title"><?php
                    printf(
                        /* translators: %s: state name. */
                        esc_html( $int_is_statutory ? _x( '%s Filing Deadline', 'workers compensation claim', 'roden-law' ) : __( '%s Filing Deadline', 'roden-law' ) ),
                        esc_html( $sb_state_label )
                    );
                    ?></h3>
                    <div class="deadline-badges">
                        <div class="deadline-badge <?php echo $state_key === 'GA' ? 'deadline-ga' : 'deadline-sc'; ?>" style="flex:1;">
                            <span class="deadline-years"><?php
                            // Same msgid for both forms: English reads "1 yr" / "2 yr" either
                            // way, but Spanish needs año/años and cannot get it from __().
                            printf(
                                /* translators: %s: number of years. */
                                esc_html( _n( '%s yr', '%s yr', (int) $sb_statute['statute_years'], 'roden-law' ) ),
                                esc_html( $sb_statute['statute_years'] )
                            );
                            ?></span>
                            <span class="deadline-state"><?php echo esc_html( $jurisdiction['state_full'] ); ?></span>
                        </div>
                    </div>
                    <p class="deadline-cite"><?php echo esc_html( ! empty( $sb_statute['deadline_detail'] ) ? $sb_statute['deadline_detail'] : $sb_statute['statute_cite'] ); ?></p>
                    <?php if ( $sb_statute['notice_detail'] ) : ?>
                        <p class="deadline-notice">
                            <strong><?php echo esc_html( $sb_statute['notice_label'] ); ?>:</strong>
                            <?php echo esc_html( $sb_statute['notice_detail'] ); ?>
                        </p>
                    <?php endif; ?>
                    <p class="deadline-warning"><?php esc_html_e( 'Missing the deadline usually ends your right to recover.', 'roden-law' ); ?></p>
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
