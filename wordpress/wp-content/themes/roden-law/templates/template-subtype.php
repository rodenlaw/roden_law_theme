<?php
/**
 * Template: Sub-Type Practice Area Page
 *
 * Loaded by single-practice_area.php when $is_subtype is true.
 *
 * Expects these variables from the router:
 *   $firm, $post_id, $post, $jurisdiction, $jurisdiction_label,
 *   $sol_ga, $sol_sc, $author_id, $parent_post,
 *   $parent_title, $parent_url, $siblings
 *
 * @package RodenLaw
 */
?>

<!-- HERO -->
<section class="hero hero-practice-area">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">
            <div class="hero-content">
                <div class="speakable-hero" data-speakable="true">
                    <h1 class="hero-title"><?php the_title(); ?></h1>
                    <p class="hero-jurisdiction">&#9878; <?php esc_html_e( 'SERVING:', 'roden-law' ); ?> <strong><?php echo esc_html( $jurisdiction_label ); ?></strong></p>
                </div>
                <?php if ( has_excerpt() ) : ?>
                    <p class="hero-subtitle"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                <?php endif; ?>

                <?php roden_last_updated_date( $post_id ); ?>

                <?php roden_stats_bar(); ?>

                <div class="hero-actions">
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary btn-lg">&#128222; <?php printf( /* translators: %s: phone number. */ esc_html__( 'Call %s', 'roden-law' ), esc_html( $firm['phone'] ) ); ?></a>
                </div>
            </div>
            <div class="hero-form">
                <?php roden_contact_form_sidebar(); ?>
            </div>
        </div>
    </div>
</section>

<!-- MAIN + SIDEBAR -->
<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">
        <article class="main-content">

            <!-- AI Definition Block -->
            <?php roden_ai_definition_block( get_the_title() ); ?>

            <!-- Key Takeaways — extractable summary box (see template-tags.php) -->
            <?php roden_pa_key_takeaways_box( get_the_ID() ); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 WHY HIRE SECTION (inherited from parent if not set)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $subtype_why_hire = get_post_meta( $post_id, '_roden_why_hire', true );
            if ( $subtype_why_hire ) : ?>
                <div class="content-section pa-why-hire">
                    <h2><?php printf( /* translators: %s: practice area title. */ esc_html__( 'Why Hire %s?', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
                    <div class="pa-why-hire__body">
                        <?php echo apply_filters( 'the_content', $subtype_why_hire ); ?>
                    </div>
                </div>
            <?php elseif ( get_the_content() ) : ?>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            <?php elseif ( $parent_post && $why_hire ) : ?>
                <div class="content-section pa-why-hire">
                    <h2><?php printf( /* translators: %s: case type with "Lawyers/Attorneys" stripped, e.g. "Drunk Driver Accident". */ esc_html__( 'Why You Need a Lawyer for %s Cases', 'roden-law' ), esc_html( preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', get_the_title() ) ) ); ?></h2>
                    <div class="pa-why-hire__body">
                        <?php echo apply_filters( 'the_content', $why_hire ); ?>
                    </div>
                </div>
            <?php endif; ?>

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

            <!-- ═══════════════════════════════════════════════════════════
                 WHAT TO DO STEPS (AI-extractable for "what to do after X" queries)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            // Accident phrase and state resolution live in
            // roden_what_to_do_context() so the HowTo schema in
            // schema-helpers.php renders from the same values.
            $wtd_ctx = roden_what_to_do_context();
            roden_what_to_do_steps(
                $wtd_ctx['accident_phrase'],
                $wtd_ctx['city'],
                $wtd_ctx['state_full'],
                $wtd_ctx['state_key']
            );

            // Statutory schemes (workers' comp) are no-fault and run on their own
            // deadlines, so the rules box below answers differently for them.
            $st_jur       = strtolower( (string) $jurisdiction );
            $st_state_key = ( 'sc' === $st_jur ) ? 'SC' : 'GA';
            $st_statute   = roden_resolve_statute( $st_state_key );
            $st_statutory = ( $st_statute && $st_statute['is_override'] );
            ?>

            <!-- ═══════════════════════════════════════════════════════════
                 THE RULES THAT APPLY — deadline and fault, then the pillar.

                 Until 2026-09-25 this template re-rendered the pillar's four
                 generic sections on every scenario page: elements of
                 negligence, compensation types, the statute-of-limitations
                 section and the comparative-fault boxes. That was about 1,100
                 identical words on each of 182 pages, and 123 of them shared
                 half or more of their text with a sibling. The pillar keeps
                 the full treatment; a scenario page states the two rules that
                 decide a claim and links there. Same statute resolver and the
                 same strings as the sections it replaces. The deadline also
                 stays in the sidebar badge. Plan:
                 docs/scenario-pages-plan-2026-09-25.md.
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $st_ga = roden_resolve_statute( 'GA' );
            $st_sc = roden_resolve_statute( 'SC' );
            $st_yr = function ( $x ) {
                return sprintf( _n( '%s year', '%s years', (int) $x['statute_years'], 'roden-law' ), $x['statute_years'] );
            };
            ?>
            <div class="content-section pa-rules" data-ai-extractable="true">
                <h2><?php esc_html_e( 'The Rules That Apply', 'roden-law' ); ?></h2>
                <ul class="pa-rules__list">
                    <?php if ( in_array( $st_jur, array( 'both', 'ga' ), true ) && $st_ga ) : ?>
                        <li><?php printf(
                            /* translators: 1: deadline in <strong>; 2: statute citation. */
                            wp_kses_post( __( 'In Georgia, you have %1$s from the date of injury (%2$s).', 'roden-law' ) ),
                            '<strong>' . esc_html( $st_yr( $st_ga ) ) . '</strong>',
                            esc_html( $st_ga['statute_cite'] )
                        ); ?></li>
                    <?php endif; ?>
                    <?php if ( in_array( $st_jur, array( 'both', 'sc' ), true ) && $st_sc ) : ?>
                        <li><?php printf(
                            /* translators: 1: deadline in <strong>; 2: statute citation. */
                            wp_kses_post( __( 'In South Carolina, you have %1$s (%2$s).', 'roden-law' ) ),
                            '<strong>' . esc_html( $st_yr( $st_sc ) ) . '</strong>',
                            esc_html( $st_sc['statute_cite'] )
                        ); ?></li>
                    <?php endif; ?>
                    <?php if ( $st_statutory ) : ?>
                        <?php
                        // The notice period is shorter than the filing deadline and is
                        // a separate step; the old deadline cards carried it.
                        foreach ( array( 'ga' => $st_ga, 'sc' => $st_sc ) as $st_k => $st_x ) :
                            if ( $st_x && ! empty( $st_x['notice_detail'] ) && in_array( $st_jur, array( 'both', $st_k ), true ) ) : ?>
                                <li><strong><?php echo esc_html( 'ga' === $st_k ? __( 'Georgia', 'roden-law' ) : __( 'South Carolina', 'roden-law' ) ); ?>:</strong> <?php echo esc_html( rtrim( $st_x['notice_label'] . ' ' . $st_x['notice_detail'], '.' ) . '.' ); ?></li>
                            <?php endif;
                        endforeach; ?>
                        <li><?php esc_html_e( 'Workers\' compensation is a no-fault system. You do not have to prove your employer did anything wrong — you have to show the injury arose out of and in the course of your employment, and that you met the notice and filing deadlines.', 'roden-law' ); ?></li>
                    <?php else : ?>
                        <?php if ( in_array( $jurisdiction, array( 'both', 'ga' ), true ) ) : ?>
                            <li><strong><?php esc_html_e( 'Georgia — Modified Comparative Fault', 'roden-law' ); ?>:</strong> <?php printf( /* translators: %s: the phrase "less than 50% at fault" wrapped in <strong>. */ esc_html__( 'You can recover if %s (O.C.G.A. § 51-12-33). Your award is reduced by your fault percentage.', 'roden-law' ), '<strong>' . esc_html__( 'less than 50% at fault', 'roden-law' ) . '</strong>' ); ?></li>
                        <?php endif; ?>
                        <?php if ( in_array( $jurisdiction, array( 'both', 'sc' ), true ) ) : ?>
                            <li><strong><?php esc_html_e( 'South Carolina — Modified Comparative Fault', 'roden-law' ); ?>:</strong> <?php printf( /* translators: %s: the phrase "less than 51% at fault" wrapped in <strong>. */ esc_html__( 'You can recover if %s. Your award is reduced by your fault percentage.', 'roden-law' ), '<strong>' . esc_html__( 'less than 51% at fault', 'roden-law' ) . '</strong>' ); ?></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <?php if ( $parent_post ) : ?>
                    <p class="pa-rules__more"><a href="<?php echo esc_url( $parent_url ); ?>"><?php printf(
                        /* translators: %s: pillar practice area title, e.g. "Dog Bite Lawyers". */
                        esc_html__( 'How negligence, compensation, deadlines and fault work: %s', 'roden-law' ),
                        esc_html( $parent_title )
                    ); ?> &rarr;</a></p>
                <?php endif; ?>
            </div>

            <?php roden_inline_cta_banner(); ?>

            <!-- Case Results -->
            <div class="content-section">
                <h2><?php esc_html_e( 'Recent Case Results', 'roden-law' ); ?></h2>
                <?php roden_case_results_grid( [ 'count' => 3, 'columns' => 3 ] ); ?>
            </div>

            <!-- "Related Pages" from _roden_see_also. Shared renderer: it
                 normalizes the stored nested practice-area paths to their flat
                 canonical. See roden_see_also_links() in inc/template-tags.php. -->
            <?php roden_see_also_links( $post_id ); ?>

            <!-- Related Guides & Resources -->
            <?php
            $subtype_cat_slug = '';
            $subtype_pa_terms = $parent_post ? wp_get_object_terms( $parent_post->ID, 'practice_category', array( 'fields' => 'slugs' ) ) : array();
            if ( ! is_wp_error( $subtype_pa_terms ) && ! empty( $subtype_pa_terms ) ) {
                $subtype_cat_slug = $subtype_pa_terms[0];
            }
            if ( $subtype_cat_slug ) {
                roden_related_resources( array(
                    'count'   => 4,
                    'cat_slug' => $subtype_cat_slug,
                    'heading'  => __( 'Related Guides & Legal Resources', 'roden-law' ),
                    'display'  => 'section',
                ) );
            }
            ?>

            <!-- ═══════════════════════════════════════════════════════════
                 AUTHOR ATTRIBUTION (E-E-A-T)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            if ( ! $author_id && $parent_post ) {
                $author_id = get_post_meta( $parent_post->ID, '_roden_author_attorney', true );
            }
            if ( $author_id ) :
                $atty = get_post( $author_id );
                if ( $atty && 'publish' === $atty->post_status ) :
                    $atty_title = get_post_meta( $atty->ID, '_roden_atty_title', true );
                    $atty_bar   = get_post_meta( $atty->ID, '_roden_bar_admissions', true );
            ?>
            <div class="content-section author-attribution">
                <h2><?php esc_html_e( 'About the Author', 'roden-law' ); ?></h2>
                <div class="author-card">
                    <div class="author-photo">
                        <?php if ( has_post_thumbnail( $atty ) ) : ?>
                            <?php echo get_the_post_thumbnail( $atty, 'thumbnail', array( 'alt' => esc_attr( sprintf( /* translators: 1: attorney name; 2: attorney title. */ __( '%1$s, %2$s at Roden Law', 'roden-law' ), $atty->post_title, $atty_title ) ) ) ); ?>
                        <?php else : ?>
                            <div class="author-photo-placeholder">&#128100;</div>
                        <?php endif; ?>
                    </div>
                    <div class="author-info">
                        <h3 class="author-name">
                            <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>"><?php echo esc_html( $atty->post_title ); ?></a>
                        </h3>
                        <?php if ( $atty_title ) : ?>
                            <span class="author-title"><?php echo esc_html( $atty_title ); ?></span>
                        <?php endif; ?>
                        <?php if ( $atty_bar ) : ?>
                            <span class="author-bar"><?php echo esc_html( $atty_bar ); ?></span>
                        <?php endif; ?>
                        <?php if ( $atty->post_excerpt ) : ?>
                            <p class="author-bio"><?php echo wp_kses_post( $atty->post_excerpt ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; endif; ?>

            <?php roden_faq_section( $post_id ); ?>

            <!-- Bottom CTA -->
            <div class="bottom-cta-box">
                <h2><?php printf( /* translators: %s: practice area title. */ esc_html__( 'Contact Our %s Today', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
                <p><?php esc_html_e( 'If you were injured and believe another party is at fault, contact us for a free, no-obligation review. We dedicate our skills and resources to recovering the maximum compensation you deserve — at no upfront cost.', 'roden-law' ); ?></p>
                <div class="cta-actions">
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary">&#128222; <?php printf( /* translators: %s: phone number. */ esc_html__( 'Call %s', 'roden-law' ), esc_html( $firm['phone'] ) ); ?></a>
                    <a href="#contact" class="btn btn-outline-light"><?php esc_html_e( 'Free Case Review', 'roden-law' ); ?></a>
                </div>
            </div>
        </article>

        <aside class="sidebar sidebar-practice">
            <div class="sidebar-sticky">
                <?php roden_contact_form_sidebar(); ?>

                <!-- Back to Pillar -->
                <?php if ( $parent_post ) : ?>
                <div class="sidebar-widget">
                    <h3 class="widget-title">&#128203; <?php esc_html_e( 'Main Practice Area', 'roden-law' ); ?></h3>
                    <a href="<?php echo esc_url( $parent_url ); ?>" class="sidebar-back-link">&larr; <?php echo esc_html( $parent_title ); ?></a>
                </div>
                <?php endif; ?>

                <!-- Related Sub-Types -->
                <?php if ( $siblings ) : ?>
                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php esc_html_e( 'Related Case Types', 'roden-law' ); ?></h3>
                    <ul class="sidebar-links">
                        <?php foreach ( $siblings as $sib ) : ?>
                            <li><a href="<?php echo esc_url( get_permalink( $sib ) ); ?>">&rarr; <?php echo esc_html( $sib->post_title ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Location Pages -->
                <?php if ( ! empty( $sibling_intersections ) ) : ?>
                <div class="sidebar-widget">
                    <h3 class="widget-title">&#128205; <?php esc_html_e( 'See by Location', 'roden-law' ); ?></h3>
                    <ul class="sidebar-links">
                        <?php foreach ( $sibling_intersections as $int_page ) :
                            $int_office  = get_post_meta( $int_page->ID, '_roden_pa_office_key', true );
                            $int_market  = $int_office ? roden_market( $int_office ) : null;
                            // Offices keep their mailing city, exactly as before. A service
                            // area has no city of its own here — its mailing city is the
                            // parent office's — so it is labelled by market_name.
                            $int_city    = $int_market
                                ? ( empty( $int_market['is_service_area'] ) ? $int_market['city'] : $int_market['market_name'] ) . ', ' . $int_market['state']
                                : $int_page->post_title;
                        ?>
                            <li><a href="<?php echo esc_url( roden_get_canonical_url( $int_page ) ); ?>">&rarr; <?php echo esc_html( $int_city ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Filing Deadlines -->
                <?php roden_deadline_badges_sidebar( roden_jurisdiction_state_keys( $jurisdiction ) ); ?>

                <!-- Why Roden Law -->
                <div class="sidebar-widget sidebar-why-us">
                    <h3 class="widget-title"><?php esc_html_e( 'Why Roden Law?', 'roden-law' ); ?></h3>
                    <ul class="why-us-list">
                        <li>&#10003; <?php printf( /* translators: %s: amount recovered, e.g. "$300M+". */ esc_html__( '%s Recovered for Clients', 'roden-law' ), esc_html( $firm['recovered'] ) ); ?></li>
                        <li>&#10003; <?php printf( /* translators: %s: star rating followed by a star glyph, e.g. "4.9★". */ esc_html__( '%s Average Client Rating', 'roden-law' ), esc_html( $firm['rating'] ) . '&#9733;' ); ?></li>
                        <li>&#10003; <?php printf( /* translators: %s: number of cases handled, e.g. "5,000+". */ esc_html__( '%s Cases Successfully Handled', 'roden-law' ), esc_html( $firm['cases_handled'] ) ); ?></li>
                        <li>&#10003; <?php esc_html_e( 'No Fee Unless We Win', 'roden-law' ); ?></li>
                        <li>&#10003; <?php esc_html_e( 'Free 24/7 Consultations', 'roden-law' ); ?></li>
                        <li>&#10003; <?php esc_html_e( 'Licensed in GA & SC', 'roden-law' ); ?></li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>
