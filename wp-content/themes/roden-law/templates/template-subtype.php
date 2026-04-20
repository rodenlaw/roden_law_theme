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
                    <p class="hero-jurisdiction">&#9878; SERVING: <strong><?php echo esc_html( $jurisdiction_label ); ?></strong></p>
                </div>
                <?php if ( has_excerpt() ) : ?>
                    <p class="hero-subtitle"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                <?php endif; ?>

                <?php roden_last_updated_date( $post_id ); ?>

                <?php roden_stats_bar(); ?>

                <div class="hero-actions">
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary btn-lg">&#128222; Call <?php echo esc_html($firm['phone']); ?></a>
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
                    <h2>Why Hire <?php the_title(); ?>?</h2>
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
                    <h2>Why You Need a Lawyer for <?php echo esc_html( preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', get_the_title() ) ); ?> Cases</h2>
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
                <h2>Proving Your <?php echo esc_html( preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', get_the_title() ) ); ?> Case</h2>
                <p>To win a personal injury case involving <?php echo esc_html( $accident_type_lower ); ?>, your attorney must establish the four elements of negligence by a preponderance of the evidence.</p>
                <div class="pa-elements">
                    <?php
                    $elements = array(
                        array( 'num' => '01', 'title' => 'Duty of Care', 'body' => 'The other party owed you a legal duty to act in a manner that ensured your safety.' ),
                        array( 'num' => '02', 'title' => 'Breach of Duty', 'body' => 'The other party breached that duty by failing to act as a reasonably prudent person would have.' ),
                        array( 'num' => '03', 'title' => 'Causation', 'body' => 'The breach directly caused your injuries. We gather evidence proving that but for their negligence, you would not have been harmed.' ),
                        array( 'num' => '04', 'title' => 'Damages', 'body' => 'You suffered actual, quantifiable damages — medical expenses, lost income, pain and suffering — as a direct result.' ),
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
                <h2>Compensation Available in <?php echo esc_html( preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', get_the_title() ) ); ?> Cases</h2>
                <p class="section-lead">Victims of <?php echo esc_html( $accident_type_lower ); ?> injuries in Georgia and South Carolina can pursue economic damages (quantifiable financial losses) and non-economic damages (quality-of-life impacts). There is no cap on compensatory damages in either state.</p>
                <div class="pa-compensation__grid">
                    <div class="pa-compensation__col">
                        <h3>Economic Damages</h3>
                        <ul>
                            <li>Past and future medical expenses</li>
                            <li>Lost wages or income</li>
                            <li>Loss of earning capacity</li>
                            <li>Property damage and repair/replacement</li>
                            <li>Cost of rehabilitation and physical therapy</li>
                            <li>Assistive medical equipment</li>
                            <li>Cost of long-term or lifelong care</li>
                        </ul>
                    </div>
                    <div class="pa-compensation__col">
                        <h3>Non-Economic Damages</h3>
                        <ul>
                            <li>Pain and suffering</li>
                            <li>Mental and emotional distress</li>
                            <li>Loss of companionship (spouse/family)</li>
                            <li>Disability and disfigurement</li>
                            <li>Loss of enjoyment of life</li>
                            <li>Humiliation or loss of reputation</li>
                        </ul>
                        <p class="pa-compensation__note"><em>Non-economic damages can only be pursued through a personal injury lawsuit, not a standard insurance claim.</em></p>
                    </div>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 STATUTE OF LIMITATIONS
                 ═══════════════════════════════════════════════════════════ -->
            <?php if ( $sol_ga || $sol_sc ) : ?>
                <div class="content-section" data-ai-extractable="true">
                    <h2>Statute of Limitations for <?php echo esc_html( preg_replace( '/\s+(Lawyers?|Attorneys?)$/i', '', get_the_title() ) ); ?> Cases</h2>
                    <p class="section-lead">The statute of limitations is the legal deadline for filing a personal injury lawsuit. <?php if ( in_array($jurisdiction, ['both','ga']) ) : ?>In Georgia, you have <strong>2 years</strong> from the date of injury (O.C.G.A. &sect; 9-3-33). <?php endif; ?><?php if ( in_array($jurisdiction, ['both','sc']) ) : ?>In South Carolina, you have <strong>3 years</strong> (S.C. Code &sect; 15-3-530). <?php endif; ?>Missing this deadline permanently bars your claim.</p>
                    <div class="sol-grid">
                        <?php if ( $sol_ga && in_array($jurisdiction, ['both','ga']) ) : ?>
                            <div class="sol-card sol-ga">
                                <span class="sol-state">&#127825; Georgia Filing Deadline</span>
                                <span class="sol-years">2 Years</span>
                                <span class="sol-cite"><?php echo esc_html( $sol_ga ); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ( $sol_sc && in_array($jurisdiction, ['both','sc']) ) : ?>
                            <div class="sol-card sol-sc">
                                <span class="sol-state">&#127769; South Carolina Filing Deadline</span>
                                <span class="sol-years">3 Years</span>
                                <span class="sol-cite"><?php echo esc_html( $sol_sc ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <p>If you fail to file within the statute of limitations, your claim will be dismissed and you will permanently lose the right to pursue compensation.</p>
                </div>
            <?php endif; ?>

            <!-- ═══════════════════════════════════════════════════════════
                 COMPARATIVE FAULT (AI-extractable)
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-fault" data-ai-extractable="true">
                <h2>What If I'm Partially At Fault?</h2>
                <div class="pa-fault__grid">
                    <?php if ( in_array($jurisdiction, ['both','ga']) ) : ?>
                    <div class="pa-fault__box pa-fault__box--ga">
                        <h3>&#127825; Georgia — Modified Comparative Fault</h3>
                        <p>You can recover if <strong>less than 50% at fault</strong> (O.C.G.A. &sect; 51-12-33). Your award is reduced by your fault percentage.</p>
                    </div>
                    <?php endif; ?>
                    <?php if ( in_array($jurisdiction, ['both','sc']) ) : ?>
                    <div class="pa-fault__box pa-fault__box--sc">
                        <h3>&#127769; South Carolina — Modified Comparative Fault</h3>
                        <p>You can recover if <strong>less than 51% at fault</strong>. Your award is reduced by your fault percentage.</p>
                    </div>
                    <?php endif; ?>
                </div>
                <p>For example, if you filed a $100,000 lawsuit and a court finds you are 30% at fault, your award would be reduced to $70,000. Our attorneys work to minimize any fault assigned to you.</p>
            </div>

            <?php roden_inline_cta_banner(); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 AI STATISTICS BLOCK (+37% visibility)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_ai_stats_block( get_the_title() ); ?>

            <!-- Case Results -->
            <div class="content-section">
                <h2>Recent Case Results</h2>
                <?php roden_case_results_grid( [ 'count' => 3, 'columns' => 3 ] ); ?>
            </div>

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
                <h2>About the Author</h2>
                <div class="author-card">
                    <div class="author-photo">
                        <?php if ( has_post_thumbnail( $atty ) ) : ?>
                            <?php echo get_the_post_thumbnail( $atty, 'thumbnail', array( 'alt' => esc_attr( $atty->post_title . ', ' . $atty_title . ' at Roden Law' ) ) ); ?>
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
                <h2>Contact Our <?php the_title(); ?> Today</h2>
                <p>If you were injured and believe another party is at fault, contact us for a free, no-obligation review. We dedicate our skills and resources to recovering the maximum compensation you deserve — at no upfront cost.</p>
                <div class="cta-actions">
                    <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary">&#128222; Call <?php echo esc_html($firm['phone']); ?></a>
                    <a href="#contact" class="btn btn-outline-light">Free Case Review</a>
                </div>
            </div>
        </article>

        <aside class="sidebar sidebar-practice">
            <div class="sidebar-sticky">
                <?php roden_contact_form_sidebar(); ?>

                <!-- Back to Pillar -->
                <?php if ( $parent_post ) : ?>
                <div class="sidebar-widget">
                    <h3 class="widget-title">&#128203; Main Practice Area</h3>
                    <a href="<?php echo esc_url( $parent_url ); ?>" class="sidebar-back-link">&larr; <?php echo esc_html( $parent_title ); ?></a>
                </div>
                <?php endif; ?>

                <!-- Related Sub-Types -->
                <?php if ( $siblings ) : ?>
                <div class="sidebar-widget">
                    <h3 class="widget-title">Related Case Types</h3>
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
                    <h3 class="widget-title">&#128205; See by Location</h3>
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
                    <h3 class="widget-title">&#9201; Filing Deadlines</h3>
                    <div class="deadline-badges">
                        <div class="deadline-badge deadline-ga">
                            <span class="deadline-years">2 yr</span>
                            <span class="deadline-state">Georgia</span>
                        </div>
                        <div class="deadline-badge deadline-sc">
                            <span class="deadline-years">3 yr</span>
                            <span class="deadline-state">South Carolina</span>
                        </div>
                    </div>
                    <p class="deadline-warning">Missing the deadline forfeits your right to recover.</p>
                </div>

                <!-- Why Roden Law -->
                <div class="sidebar-widget sidebar-why-us">
                    <h3 class="widget-title">Why Roden Law?</h3>
                    <ul class="why-us-list">
                        <li>&#10003; <?php echo esc_html($firm['recovered']); ?> Recovered for Clients</li>
                        <li>&#10003; <?php echo esc_html($firm['rating']); ?>&#9733; Average Client Rating</li>
                        <li>&#10003; <?php echo esc_html($firm['cases_handled']); ?> Cases Successfully Handled</li>
                        <li>&#10003; No Fee Unless We Win</li>
                        <li>&#10003; Free 24/7 Consultations</li>
                        <li>&#10003; Licensed in GA &amp; SC</li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>
