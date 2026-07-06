<?php
/**
 * Template: Pillar Practice Area Page — 17-Section Layout
 *
 * Loaded by single-practice_area.php when $is_pillar is true.
 *
 * Expects these variables from the router:
 *   $firm, $post_id, $post, $jurisdiction, $jurisdiction_label,
 *   $sol_ga, $sol_sc, $sub_types, $author_id,
 *   $child_subtypes, $child_intersections,
 *   $hero_intro, $why_hire, $common_causes, $common_injuries
 *
 * @package RodenLaw
 */

// Author data (used in multiple sections)
$atty       = $author_id ? get_post( $author_id ) : null;
$atty_title = $atty ? get_post_meta( $atty->ID, '_roden_atty_title', true ) : '';
$atty_bar   = $atty ? get_post_meta( $atty->ID, '_roden_bar_admissions', true ) : '';

// Practice category for queries
$pa_terms = wp_get_object_terms( $post_id, 'practice_category', array( 'fields' => 'slugs' ) );
$cat_slug = ! empty( $pa_terms ) ? $pa_terms[0] : '';
?>

<!-- ═══════════════════════════════════════════════════════════════════════
     SECTION 1: HERO
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="hero hero-practice-area">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-grid">
            <div class="hero-content">
                <div class="speakable-hero" data-speakable="true">
                    <h1 class="hero-title"><?php the_title(); ?></h1>
                    <p class="hero-jurisdiction">&#9878; <?php esc_html_e( 'Serving:', 'roden-law' ); ?> <strong><?php echo esc_html( $jurisdiction_label ); ?></strong></p>
                </div>
                <div class="speakable-intro" data-speakable="true">
                    <?php if ( $hero_intro ) : ?>
                        <p class="hero-subtitle"><?php echo wp_kses_post( $hero_intro ); ?></p>
                    <?php elseif ( has_excerpt() ) : ?>
                        <p class="hero-subtitle"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                    <?php endif; ?>
                </div>

                <?php roden_last_updated_date( $post_id ); ?>

                <?php roden_stats_bar(); ?>

                <div class="hero-actions">
                    <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary btn-lg">&#128222; <?php printf( /* translators: %s: phone number. */ esc_html__( 'Call %s', 'roden-law' ), esc_html( $firm['phone'] ) ); ?></a>
                </div>
            </div>
            <div class="hero-form">
                <?php roden_contact_form_sidebar(); ?>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════
     SECTION 2: TRUST BAR (Bar Association Badges)
     ═══════════════════════════════════════════════════════════════════════ -->
<div class="pa-trust-bar">
    <div class="container">
        <?php
        $badges = array(
            array( 'name' => __( 'State Bar of Georgia', 'roden-law' ),             'abbr' => 'GA Bar' ),
            array( 'name' => __( 'American Association for Justice', 'roden-law' ), 'abbr' => 'AAJ' ),
            array( 'name' => __( 'Georgia Trial Lawyers Association', 'roden-law' ), 'abbr' => 'GTLA' ),
            array( 'name' => __( 'American Bar Association', 'roden-law' ),         'abbr' => 'ABA' ),
        );
        foreach ( $badges as $badge ) :
            $badge_file = get_template_directory() . '/assets/images/badges/' . sanitize_title( $badge['abbr'] ) . '.svg';
            $has_image  = file_exists( $badge_file );
        ?>
            <div class="trust-badge">
                <?php if ( $has_image ) : ?>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/badges/' . sanitize_title( $badge['abbr'] ) . '.svg' ); ?>"
                         alt="<?php printf( /* translators: %s: bar association name. */ esc_attr__( '%s Member Badge', 'roden-law' ), esc_attr( $badge['name'] ) ); ?>"
                         width="32" height="32" loading="lazy">
                <?php else : ?>
                    <span class="trust-badge__icon">&#9878;</span>
                <?php endif; ?>
                <span class="trust-badge__name"><?php echo esc_html( $badge['name'] ); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════════════
     JUMP-TO-SECTION NAV (sticky on scroll, mobile-friendly horizontal scroll)
     ═══════════════════════════════════════════════════════════════════════ -->
<nav class="pa-jump-nav" aria-label="<?php esc_attr_e( 'Page sections', 'roden-law' ); ?>">
    <div class="container">
        <ul class="pa-jump-nav__list">
            <li><a href="#pa-overview"><?php esc_html_e( 'Overview', 'roden-law' ); ?></a></li>
            <li><a href="#pa-case-types"><?php esc_html_e( 'Case Types', 'roden-law' ); ?></a></li>
            <li><a href="#pa-deadlines"><?php esc_html_e( 'Deadlines', 'roden-law' ); ?></a></li>
            <li><a href="#pa-your-case"><?php esc_html_e( 'Your Case', 'roden-law' ); ?></a></li>
            <li><a href="#pa-compensation"><?php esc_html_e( 'Compensation', 'roden-law' ); ?></a></li>
            <li><a href="#pa-results"><?php esc_html_e( 'Results', 'roden-law' ); ?></a></li>
            <li><a href="#pa-faqs"><?php esc_html_e( 'FAQs', 'roden-law' ); ?></a></li>
            <li><a href="#pa-contact"><?php esc_html_e( 'Contact', 'roden-law' ); ?></a></li>
        </ul>
    </div>
</nav>

<!-- ═══════════════════════════════════════════════════════════════════════
     SECTION 3: LOCATION MATRIX
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="section-location-matrix">
    <div class="container">
        <h2 class="matrix-title"><?php printf( /* translators: %s: practice area title. */ esc_html__( 'Our %s Offices', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
        <div class="location-matrix-grid">
            <?php
            // Pre-build location page URL cache keyed by office key.
            $location_urls = array();
            $location_posts_args = array(
                'post_type'      => 'location',
                'posts_per_page' => 10,
                'post_status'    => 'publish',
            );
            if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
                $location_posts_args['meta_query'] = roden_es_exclusion_meta_query();
            }
            $location_posts = get_posts( $location_posts_args );
            foreach ( $location_posts as $lp ) {
                $lp_key = get_post_meta( $lp->ID, '_roden_office_key', true );
                if ( $lp_key ) {
                    $location_urls[ $lp_key ] = get_permalink( $lp );
                }
            }

            foreach ( $firm['offices'] as $key => $office ) :
                $matrix_url    = '';
                $matrix_label  = '';

                // Prefer intersection page; fall back to location page.
                foreach ( $child_intersections as $ci ) {
                    if ( get_post_meta( $ci->ID, '_roden_pa_office_key', true ) === $key ) {
                        $matrix_url   = get_permalink( $ci );
                        $matrix_label = 'City Page';
                        break;
                    }
                }
                if ( ! $matrix_url && isset( $location_urls[ $key ] ) ) {
                    $matrix_url   = $location_urls[ $key ];
                    $matrix_label = 'Office';
                }
            ?>
                <div class="matrix-card">
                    <span class="matrix-state state-<?php echo esc_attr( strtolower( $office['state'] ) ); ?>"><?php echo esc_html( $office['state'] ); ?></span>
                    <h3 class="matrix-city">
                        <?php if ( $matrix_url ) : ?>
                            <a href="<?php echo esc_url( $matrix_url ); ?>"><?php echo esc_html( $office['market_name'] ); ?></a>
                        <?php else : ?>
                            <?php echo esc_html( $office['market_name'] ); ?>
                        <?php endif; ?>
                    </h3>
                    <span class="matrix-url">/<?php echo esc_html( $post->post_name ); ?>/<?php echo esc_html( $office['slug'] ); ?>/</span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════
     MAIN CONTENT + SIDEBAR WRAPPER
     ═══════════════════════════════════════════════════════════════════════ -->
<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <!-- MAIN CONTENT -->
        <article class="main-content">

            <!-- ═══════════════════════════════════════════════════════════
                 AI DEFINITION BLOCK (extractable answer for AI systems)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_ai_definition_block( get_the_title(), $hero_intro ); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 4: WHY HIRE A [Practice Area] LAWYER?
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-why-hire" id="pa-overview">
                <h2><?php printf( /* translators: %s: practice area title, e.g. "Car Accident Lawyers". */ esc_html__( 'Why Hire %s?', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
                <?php if ( $why_hire ) : ?>
                    <div class="pa-why-hire__body">
                        <?php echo apply_filters( 'the_content', $why_hire ); ?>
                    </div>
                <?php elseif ( get_the_content() ) : ?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
                <p><?php esc_html_e( 'At Roden Law, our personal injury attorneys have helped numerous victims secure millions in compensation across Georgia and South Carolina. We provide all potential clients with a free, no-obligation review of their claim and do not charge upfront legal fees.', 'roden-law' ); ?></p>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 EXPERT QUOTE (AI-citable attorney quote — +30% visibility)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $expert_quote = get_post_meta( $post_id, '_roden_expert_quote', true );
            if ( $expert_quote ) {
                roden_expert_quote_block( $expert_quote, $author_id );
            }
            ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 5: INLINE CTA BANNER (#1 of 3)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_inline_cta_banner(); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 WHAT TO DO STEPS (AI-extractable process for "what to do" queries)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $accident_label = strtolower( preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', get_the_title() ) );
            roden_what_to_do_steps( $accident_label );
            ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 6: TYPES OF CASES WE HANDLE (Sub-Types)
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( $child_subtypes || $sub_types ) : ?>
                <div class="content-section" id="pa-case-types">
                    <h2><?php printf( /* translators: %s: practice area title. */ esc_html__( 'Types of %s Cases We Handle', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
                    <div class="sub-types-grid">
                        <?php if ( $child_subtypes ) : ?>
                            <?php foreach ( $child_subtypes as $cst ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $cst ) ); ?>" class="sub-type-card sub-type-link">
                                    <span class="st-name"><?php echo esc_html( $cst->post_title ); ?></span>
                                    <span class="st-arrow">&rarr;</span>
                                </a>
                            <?php endforeach; ?>
                        <?php elseif ( $sub_types ) : ?>
                            <?php foreach ( $sub_types as $st ) : ?>
                                <div class="sub-type-card">
                                    <span class="st-name"><?php echo esc_html( $st ); ?></span>
                                    <span class="st-arrow">&rarr;</span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 7: STATUTE OF LIMITATIONS (GA vs SC)
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( $sol_ga || $sol_sc ) : ?>
                <div class="content-section" id="pa-deadlines" data-ai-extractable="true">
                    <h2><?php printf( /* translators: %s: practice area title. */ esc_html__( 'Statute of Limitations for %s Cases', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
                    <p class="section-lead"><?php
                    printf(
                        /* translators: 1: "2 years" wrapped in <strong>; 2: "3 years" wrapped in <strong>. */
                        esc_html__( 'The statute of limitations is the legal deadline for filing a personal injury lawsuit. In Georgia, you have %1$s from the date of injury (O.C.G.A. § 9-3-33). In South Carolina, you have %2$s (S.C. Code § 15-3-530). Missing this deadline permanently bars your claim.', 'roden-law' ),
                        '<strong>' . esc_html__( '2 years', 'roden-law' ) . '</strong>',
                        '<strong>' . esc_html__( '3 years', 'roden-law' ) . '</strong>'
                    );
                    ?></p>
                    <div class="sol-grid">
                        <?php if ( $sol_ga && in_array( $jurisdiction, array( 'both', 'ga', 'GA' ) ) ) : ?>
                            <div class="sol-card sol-ga">
                                <span class="sol-state">&#127825; <?php esc_html_e( 'Georgia Filing Deadline', 'roden-law' ); ?></span>
                                <span class="sol-years"><?php esc_html_e( '2 Years', 'roden-law' ); ?></span>
                                <span class="sol-cite"><?php echo esc_html( $sol_ga ); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ( $sol_sc && in_array( $jurisdiction, array( 'both', 'sc', 'SC' ) ) ) : ?>
                            <div class="sol-card sol-sc">
                                <span class="sol-state">&#127769; <?php esc_html_e( 'South Carolina Filing Deadline', 'roden-law' ); ?></span>
                                <span class="sol-years"><?php esc_html_e( '3 Years', 'roden-law' ); ?></span>
                                <span class="sol-cite"><?php echo esc_html( $sol_sc ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <p><?php esc_html_e( 'If you fail to file within the statute of limitations, your claim will be dismissed and you will permanently lose the right to pursue compensation. You should not hesitate to consult with a skilled attorney to ensure your claim is filed on time.', 'roden-law' ); ?></p>
                </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 7b: GA vs SC COMPARISON TABLE (AI-extractable)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_jurisdiction_comparison_table( get_the_title(), $sol_ga, $sol_sc, $jurisdiction ); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 8: DO I HAVE A CASE? (4 Elements of Negligence)
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-elements-section" id="pa-your-case" data-ai-extractable="true">
                <h2><?php printf( /* translators: %s: practice area title. */ esc_html__( 'Do I Have a %s Case?', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
                <p><?php esc_html_e( 'To win a personal injury case in Georgia or South Carolina, your attorney must prove the four elements of negligence. Each element must be established by a preponderance of the evidence for you to recover compensation.', 'roden-law' ); ?></p>
                <div class="pa-elements">
                    <?php
                    $elements = array(
                        array(
                            'num'   => '01',
                            'title' => __( 'Duty of Care', 'roden-law' ),
                            'body'  => __( 'The other party owed you a duty of care and was obligated to act in a manner that ensured your safety and the safety of others.', 'roden-law' ),
                        ),
                        array(
                            'num'   => '02',
                            'title' => __( 'Breach of Duty', 'roden-law' ),
                            'body'  => __( 'The other party breached that duty by failing to act as a reasonably safe and prudent person would have in the same situation.', 'roden-law' ),
                        ),
                        array(
                            'num'   => '03',
                            'title' => __( 'Causation', 'roden-law' ),
                            'body'  => __( 'The at-fault party\'s conduct and the resulting accident directly caused your injuries. We gather evidence to prove that but for their negligence, you would not have been harmed.', 'roden-law' ),
                        ),
                        array(
                            'num'   => '04',
                            'title' => __( 'Damages', 'roden-law' ),
                            'body'  => __( 'You suffered actual, quantifiable damages — medical expenses, lost income, pain and suffering — as a direct result of the at-fault party\'s breach.', 'roden-law' ),
                        ),
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

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 9: COMPENSATION TYPES
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-compensation" id="pa-compensation" data-ai-extractable="true">
                <h2><?php printf( /* translators: %s: practice area title. */ esc_html__( 'Types of Compensation in %s Cases', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
                <p class="section-lead"><?php printf( /* translators: %s: lowercase accident type, e.g. "car accident". */ esc_html__( 'Victims of %s injuries in Georgia and South Carolina can pursue two categories of damages: economic damages (quantifiable financial losses) and non-economic damages (quality-of-life impacts). There is no cap on compensatory damages in either state.', 'roden-law' ), esc_html( strtolower( preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', get_the_title() ) ) ) ); ?></p>
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

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 10: COMPARATIVE FAULT (GA vs SC)
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-fault" data-ai-extractable="true">
                <h2><?php printf( /* translators: %s: practice area title. */ esc_html__( 'Comparative Fault in %s Cases — What If I\'m Partially At Fault?', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
                <div class="pa-fault__grid">
                    <div class="pa-fault__box pa-fault__box--ga">
                        <h3>&#127825; <?php esc_html_e( 'Georgia — Modified Comparative Fault', 'roden-law' ); ?></h3>
                        <p><?php printf( /* translators: %s: the phrase "less than 50% at fault" wrapped in <strong>. */ esc_html__( 'You can recover if %s (O.C.G.A. § 51-12-33). Your award is reduced by your fault percentage.', 'roden-law' ), '<strong>' . esc_html__( 'less than 50% at fault', 'roden-law' ) . '</strong>' ); ?></p>
                    </div>
                    <div class="pa-fault__box pa-fault__box--sc">
                        <h3>&#127769; <?php esc_html_e( 'South Carolina — Modified Comparative Fault', 'roden-law' ); ?></h3>
                        <p><?php printf( /* translators: %s: the phrase "less than 51% at fault" wrapped in <strong>. */ esc_html__( 'You can recover if %s. Your award is reduced by your fault percentage.', 'roden-law' ), '<strong>' . esc_html__( 'less than 51% at fault', 'roden-law' ) . '</strong>' ); ?></p>
                    </div>
                </div>
                <p><?php esc_html_e( 'For example, if you filed a $100,000 lawsuit and a court finds you are 30% at fault, your award would be reduced to $70,000. Our attorneys will work to minimize any fault assigned to you.', 'roden-law' ); ?></p>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 INLINE CTA BANNER (#2 of 3)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_inline_cta_banner(); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 11: COMMON CAUSES
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( ! empty( $common_causes ) ) : ?>
                <div class="content-section pa-common-list" data-ai-extractable="true">
                    <h2><?php printf( /* translators: %s: practice area title. */ esc_html__( 'Common Causes of %s Cases', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
                    <ul class="pa-two-col-list">
                        <?php foreach ( $common_causes as $cause ) : ?>
                            <li><?php echo esc_html( $cause ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 12: COMMON INJURIES
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( ! empty( $common_injuries ) ) : ?>
                <div class="content-section pa-injuries" data-ai-extractable="true">
                    <h2><?php printf( /* translators: %s: practice area title. */ esc_html__( 'Common Injuries in %s Cases', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
                    <div class="pa-injuries__list">
                        <?php foreach ( $common_injuries as $injury ) : ?>
                            <div class="pa-injury">
                                <strong class="pa-injury__name"><?php echo esc_html( $injury['name'] ); ?></strong>
                                <?php if ( ! empty( $injury['description'] ) ) : ?>
                                    <p class="pa-injury__desc"><?php echo esc_html( $injury['description'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 AI STATISTICS BLOCK (extractable firm stats — +37% visibility)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_ai_stats_block( get_the_title() ); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 13: CASE RESULTS
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section" id="pa-results">
                <h2><?php printf( /* translators: %s: practice area title. */ esc_html__( 'Recent %s Case Results', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
                <?php roden_case_results_grid( array( 'count' => 4, 'columns' => 3, 'practice_category' => $cat_slug ) ); ?>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 14: ABOUT THE AUTHOR (E-E-A-T)
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( $atty ) : ?>
                <div class="content-section author-attribution" id="author">
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
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 15: FAQ SECTION
                 ═══════════════════════════════════════════════════════════ -->
            <div id="pa-faqs">
                <?php if ( $atty ) : ?>
                    <p class="pa-faq-attribution">
                        <?php
                        printf(
                            /* translators: 1: attorney name wrapped in <strong>; 2: attorney title. */
                            esc_html__( 'Reviewed by %1$s, %2$s — Licensed in Georgia & South Carolina', 'roden-law' ),
                            '<strong>' . esc_html( $atty->post_title ) . '</strong>',
                            esc_html( $atty_title )
                        );
                        ?>
                    </p>
                <?php endif; ?>
                <?php roden_faq_section( $post_id ); ?>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 INLINE CTA BANNER (#3 of 3)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_inline_cta_banner(); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 16: RELATED RESOURCES / BLOG LINKS
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $related_args = array(
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'post_status'    => 'publish',
            );
            if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
                $related_args['meta_query'] = roden_es_exclusion_meta_query();
            }

            // Try practice_category taxonomy first.
            $has_tax_filter = false;
            if ( $cat_slug ) {
                $related_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'practice_category',
                        'field'    => 'slug',
                        'terms'    => $cat_slug,
                    ),
                );
                $has_tax_filter = true;
            }

            // Fall back to WordPress category by mapping the PA slug to a blog category.
            if ( ! $has_tax_filter ) {
                $pa_to_blog_cat = array(
                    'personal-injury-lawyers'           => 'personal-injury',
                    'car-accident-lawyers'              => 'car-accident',
                    'truck-accident-lawyers'             => 'truck-accident',
                    'motorcycle-accident-lawyers'        => 'personal-injury',
                    'slip-and-fall-lawyers'              => 'personal-injury',
                    'medical-malpractice-lawyers'        => 'medical-malpractice',
                    'wrongful-death-lawyers'             => 'personal-injury',
                    'workers-compensation-lawyers'       => 'workers-compensation',
                    'dog-bite-lawyers'                   => 'personal-injury',
                    'brain-injury-lawyers'               => 'personal-injury',
                    'spinal-cord-injury-lawyers'         => 'personal-injury',
                    'maritime-injury-lawyers'            => 'personal-injury',
                    'product-liability-lawyers'          => 'personal-injury',
                    'boating-accident-lawyers'           => 'personal-injury',
                    'burn-injury-lawyers'                => 'personal-injury',
                    'construction-accident-lawyers'      => 'workers-compensation',
                    'nursing-home-abuse-lawyers'         => 'nursing-home-abuse',
                    'premises-liability-lawyers'         => 'personal-injury',
                    'pedestrian-accident-lawyers'        => 'car-accident',
                    'bicycle-accident-lawyers'           => 'bicycle-accident',
                    'electric-scooter-accident-lawyers'  => 'personal-injury',
                    'atv-side-by-side-accident-lawyers'  => 'personal-injury',
                    'golf-cart-accident-lawyers'         => 'personal-injury',
                    'e-bike-accident-lawyers'            => 'bicycle-accident',
                );
                $pa_slug   = $post->post_name;
                $blog_cat  = isset( $pa_to_blog_cat[ $pa_slug ] ) ? $pa_to_blog_cat[ $pa_slug ] : '';
                if ( $blog_cat ) {
                    $related_args['category_name'] = $blog_cat;
                }
            }

            $related_posts = new WP_Query( $related_args );
            if ( $related_posts->have_posts() ) : ?>
                <div class="content-section pa-resources">
                    <h2><?php esc_html_e( 'Related Resources', 'roden-law' ); ?></h2>
                    <div class="pa-resources__grid">
                        <?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="resource-link">
                                <span class="resource-link__title"><?php the_title(); ?></span>
                                <span class="resource-link__arrow">&rarr;</span>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php
                wp_reset_postdata();
            endif;
            ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 16b: RELATED GUIDES (Resource CPT)
                 ═══════════════════════════════════════════════════════════ -->
            <?php
            $resource_args = array(
                'post_type'      => 'resource',
                'posts_per_page' => 4,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
                $resource_args['meta_query'] = roden_es_exclusion_meta_query();
            }
            if ( $cat_slug ) {
                $resource_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'practice_category',
                        'field'    => 'slug',
                        'terms'    => $cat_slug,
                    ),
                );
            }
            $resource_posts = new WP_Query( $resource_args );
            if ( $resource_posts->have_posts() ) : ?>
                <div class="content-section pa-guides">
                    <h2><?php esc_html_e( 'Related Guides & Legal Resources', 'roden-law' ); ?></h2>
                    <div class="pa-resources__grid">
                        <?php while ( $resource_posts->have_posts() ) : $resource_posts->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="resource-link">
                                <span class="resource-link__title"><?php the_title(); ?></span>
                                <span class="resource-link__arrow">&rarr;</span>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php
                wp_reset_postdata();
            endif;
            ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 17: BOTTOM CTA BLOCK
                 ═══════════════════════════════════════════════════════════ -->
            <div class="bottom-cta-box" id="pa-contact">
                <h2><?php printf( /* translators: %s: practice area title, e.g. "Car Accident Lawyers". */ esc_html__( 'Contact Our %s Today', 'roden-law' ), esc_html( get_the_title() ) ); ?></h2>
                <p><?php esc_html_e( 'If you were injured and believe another party is at fault, contact us for a free, no-obligation review. We dedicate our skills and resources to recovering the maximum compensation you deserve — at no upfront cost.', 'roden-law' ); ?></p>
                <div class="cta-actions">
                    <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary">&#128222; <?php printf( /* translators: %s: phone number. */ esc_html__( 'Call %s', 'roden-law' ), esc_html( $firm['phone'] ) ); ?></a>
                    <a href="#contact" class="btn btn-outline-light"><?php esc_html_e( 'Free Case Review', 'roden-law' ); ?></a>
                </div>
            </div>

        </article>

        <!-- ═══════════════════════════════════════════════════════════════
             SIDEBAR (Sticky on Desktop)
             ═══════════════════════════════════════════════════════════════ -->
        <aside class="sidebar sidebar-practice">
            <div class="sidebar-sticky">
                <?php roden_contact_form_sidebar(); ?>

                <!-- Filing Deadlines -->
                <div class="sidebar-widget sidebar-deadlines">
                    <h3 class="widget-title">&#9201; <?php esc_html_e( 'Filing Deadlines', 'roden-law' ); ?></h3>
                    <div class="deadline-badges">
                        <div class="deadline-badge deadline-ga">
                            <span class="deadline-years"><?php esc_html_e( '2 yr', 'roden-law' ); ?></span>
                            <span class="deadline-state"><?php esc_html_e( 'Georgia', 'roden-law' ); ?></span>
                        </div>
                        <div class="deadline-badge deadline-sc">
                            <span class="deadline-years"><?php esc_html_e( '3 yr', 'roden-law' ); ?></span>
                            <span class="deadline-state"><?php esc_html_e( 'South Carolina', 'roden-law' ); ?></span>
                        </div>
                    </div>
                    <p class="deadline-warning"><?php esc_html_e( 'Missing the deadline forfeits your right to recover.', 'roden-law' ); ?></p>
                </div>

                <!-- Related Practice Areas -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php esc_html_e( 'Related Practice Areas', 'roden-law' ); ?></h3>
                    <?php
                    $related_pas_args = array(
                        'post_type'      => 'practice_area',
                        'posts_per_page' => 7,
                        'exclude'        => array( $post_id ),
                        'post_parent'    => 0,
                        'orderby'        => 'rand',
                    );
                    if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
                        $related_pas_args['meta_query'] = roden_es_exclusion_meta_query();
                    }
                    $related_pas = get_posts( $related_pas_args );
                    if ( $related_pas ) :
                        echo '<ul class="sidebar-links">';
                        foreach ( $related_pas as $r ) {
                            echo '<li><a href="' . esc_url( get_permalink( $r ) ) . '">&rarr; ' . esc_html( $r->post_title ) . '</a></li>';
                        }
                        echo '</ul>';
                    endif;
                    ?>
                </div>

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

