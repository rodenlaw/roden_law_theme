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
            $accident_type_label = preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', get_the_title() );
            $accident_type_lower = strtolower( $accident_type_label );
            if ( strpos( $accident_type_lower, 'a ' ) !== 0 && strpos( $accident_type_lower, 'an ' ) !== 0 ) {
                $vowels = array( 'a', 'e', 'i', 'o', 'u' );
                $article = in_array( strtolower( $accident_type_lower[0] ), $vowels ) ? 'an ' : 'a ';
                $accident_type_lower = $article . $accident_type_lower;
            }
            roden_what_to_do_steps( $accident_type_lower );
            ?>

            <!-- ═══════════════════════════════════════════════════════════
                 ELEMENTS OF NEGLIGENCE (inherited from pillar — AI-extractable)
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-elements-section" data-ai-extractable="true">
                <h2><?php printf( /* translators: %s: case type with "Lawyers/Attorneys" stripped. */ esc_html__( 'Proving Your %s Case', 'roden-law' ), esc_html( preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', get_the_title() ) ) ); ?></h2>
                <p><?php printf( /* translators: %s: lowercase accident type with leading article, e.g. "a drunk driver accident". */ esc_html__( 'To win a personal injury case involving %s, your attorney must establish the four elements of negligence by a preponderance of the evidence.', 'roden-law' ), esc_html( $accident_type_lower ) ); ?></p>
                <div class="pa-elements">
                    <?php
                    $elements = array(
                        array( 'num' => '01', 'title' => __( 'Duty of Care', 'roden-law' ), 'body' => __( 'The other party owed you a legal duty to act in a manner that ensured your safety.', 'roden-law' ) ),
                        array( 'num' => '02', 'title' => __( 'Breach of Duty', 'roden-law' ), 'body' => __( 'The other party breached that duty by failing to act as a reasonably prudent person would have.', 'roden-law' ) ),
                        array( 'num' => '03', 'title' => __( 'Causation', 'roden-law' ), 'body' => __( 'The breach directly caused your injuries. We gather evidence proving that but for their negligence, you would not have been harmed.', 'roden-law' ) ),
                        array( 'num' => '04', 'title' => __( 'Damages', 'roden-law' ), 'body' => __( 'You suffered actual, quantifiable damages — medical expenses, lost income, pain and suffering — as a direct result.', 'roden-law' ) ),
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
                 COMPENSATION TYPES (AI-extractable)
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-compensation" data-ai-extractable="true">
                <h2><?php printf( /* translators: %s: case type with "Lawyers/Attorneys" stripped. */ esc_html__( 'Compensation Available in %s Cases', 'roden-law' ), esc_html( preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', get_the_title() ) ) ); ?></h2>
                <p class="section-lead"><?php printf( /* translators: %s: lowercase accident type with leading article. */ esc_html__( 'Victims of %s injuries in Georgia and South Carolina can pursue economic damages (quantifiable financial losses) and non-economic damages (quality-of-life impacts). There is no cap on compensatory damages in either state.', 'roden-law' ), esc_html( $accident_type_lower ) ); ?></p>
                <div class="pa-compensation__grid">
                    <div class="pa-compensation__col">
                        <h3><?php esc_html_e( 'Economic Damages', 'roden-law' ); ?></h3>
                        <ul>
                            <li><?php esc_html_e( 'Past and future medical expenses', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Lost wages or income', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Loss of earning capacity', 'roden-law' ); ?></li>
                            <li><?php esc_html_e( 'Property damage and repair/replacement', 'roden-law' ); ?></li>
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
                 STATUTE OF LIMITATIONS
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( $sol_ga || $sol_sc ) : ?>
                <div class="content-section" data-ai-extractable="true">
                    <h2><?php printf( /* translators: %s: case type with "Lawyers/Attorneys" stripped. */ esc_html__( 'Statute of Limitations for %s Cases', 'roden-law' ), esc_html( preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', get_the_title() ) ) ); ?></h2>
                    <p class="section-lead"><?php esc_html_e( 'The statute of limitations is the legal deadline for filing a personal injury lawsuit.', 'roden-law' ); ?> <?php if ( in_array($jurisdiction, ['both','ga']) ) : ?><?php printf( /* translators: %s: "2 years" wrapped in <strong>. */ esc_html__( 'In Georgia, you have %s from the date of injury (O.C.G.A. § 9-3-33).', 'roden-law' ), '<strong>' . esc_html__( '2 years', 'roden-law' ) . '</strong>' ); ?> <?php endif; ?><?php if ( in_array($jurisdiction, ['both','sc']) ) : ?><?php printf( /* translators: %s: "3 years" wrapped in <strong>. */ esc_html__( 'In South Carolina, you have %s (S.C. Code § 15-3-530).', 'roden-law' ), '<strong>' . esc_html__( '3 years', 'roden-law' ) . '</strong>' ); ?> <?php endif; ?><?php esc_html_e( 'Missing this deadline permanently bars your claim.', 'roden-law' ); ?></p>
                    <div class="sol-grid">
                        <?php if ( $sol_ga && in_array($jurisdiction, ['both','ga']) ) : ?>
                            <div class="sol-card sol-ga">
                                <span class="sol-state">&#127825; <?php esc_html_e( 'Georgia Filing Deadline', 'roden-law' ); ?></span>
                                <span class="sol-years"><?php esc_html_e( '2 Years', 'roden-law' ); ?></span>
                                <span class="sol-cite"><?php echo esc_html( $sol_ga ); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ( $sol_sc && in_array($jurisdiction, ['both','sc']) ) : ?>
                            <div class="sol-card sol-sc">
                                <span class="sol-state">&#127769; <?php esc_html_e( 'South Carolina Filing Deadline', 'roden-law' ); ?></span>
                                <span class="sol-years"><?php esc_html_e( '3 Years', 'roden-law' ); ?></span>
                                <span class="sol-cite"><?php echo esc_html( $sol_sc ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <p><?php esc_html_e( 'If you fail to file within the statute of limitations, your claim will be dismissed and you will permanently lose the right to pursue compensation.', 'roden-law' ); ?></p>
                </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 COMPARATIVE FAULT (AI-extractable)
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-fault" data-ai-extractable="true">
                <h2><?php esc_html_e( 'What If I\'m Partially At Fault?', 'roden-law' ); ?></h2>
                <div class="pa-fault__grid">
                    <?php if ( in_array($jurisdiction, ['both','ga']) ) : ?>
                    <div class="pa-fault__box pa-fault__box--ga">
                        <h3>&#127825; <?php esc_html_e( 'Georgia — Modified Comparative Fault', 'roden-law' ); ?></h3>
                        <p><?php printf( /* translators: %s: the phrase "less than 50% at fault" wrapped in <strong>. */ esc_html__( 'You can recover if %s (O.C.G.A. § 51-12-33). Your award is reduced by your fault percentage.', 'roden-law' ), '<strong>' . esc_html__( 'less than 50% at fault', 'roden-law' ) . '</strong>' ); ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if ( in_array($jurisdiction, ['both','sc']) ) : ?>
                    <div class="pa-fault__box pa-fault__box--sc">
                        <h3>&#127769; <?php esc_html_e( 'South Carolina — Modified Comparative Fault', 'roden-law' ); ?></h3>
                        <p><?php printf( /* translators: %s: the phrase "less than 51% at fault" wrapped in <strong>. */ esc_html__( 'You can recover if %s. Your award is reduced by your fault percentage.', 'roden-law' ), '<strong>' . esc_html__( 'less than 51% at fault', 'roden-law' ) . '</strong>' ); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <p><?php esc_html_e( 'For example, if you filed a $100,000 lawsuit and a court finds you are 30% at fault, your award would be reduced to $70,000. Our attorneys work to minimize any fault assigned to you.', 'roden-law' ); ?></p>
            </div>

            <?php roden_inline_cta_banner(); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 AI STATISTICS BLOCK (+37% visibility)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_ai_stats_block( get_the_title() ); ?>

            <!-- Case Results -->
            <div class="content-section">
                <h2><?php esc_html_e( 'Recent Case Results', 'roden-law' ); ?></h2>
                <?php roden_case_results_grid( [ 'count' => 3, 'columns' => 3 ] ); ?>
            </div>

            <!-- See Also links (internal link injection via _roden_see_also meta) -->
            <?php
            $see_also = get_post_meta( $post_id, '_roden_see_also', true );
            if ( ! empty( $see_also ) && is_array( $see_also ) ) : ?>
                <div class="content-section see-also-section">
                    <h2><?php esc_html_e( 'Related Pages', 'roden-law' ); ?></h2>
                    <div class="pa-resources__grid">
                        <?php foreach ( $see_also as $link ) : ?>
                            <a href="<?php echo esc_url( home_url( $link['url'] ) ); ?>" class="resource-link">
                                <span class="resource-link__title"><?php echo esc_html( $link['text'] ); ?></span>
                                <span class="resource-link__arrow">&rarr;</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

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
                            $int_office = get_post_meta( $int_page->ID, '_roden_pa_office_key', true );
                            $int_city = isset( $firm['offices'][ $int_office ] ) ? $firm['offices'][ $int_office ]['city'] . ', ' . $firm['offices'][ $int_office ]['state'] : $int_page->post_title;
                        ?>
                            <li><a href="<?php echo esc_url( roden_get_canonical_url( $int_page ) ); ?>">&rarr; <?php echo esc_html( $int_city ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

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
