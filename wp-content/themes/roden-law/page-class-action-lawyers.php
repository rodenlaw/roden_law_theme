<?php
/**
 * Template: Class Action Lawyers Pillar Page (page-class-action-lawyers.php)
 *
 * Automatically loaded for the /class-action-lawyers/ page (slug match).
 * Hero, trust bar, class action types grid, main content + sidebar,
 * FAQ, bottom CTA, mobile sticky bar.
 *
 * @package Roden_Law
 */

get_header();

$firm = roden_firm_data();
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
                    <h1 class="hero-title">Class Action Lawyers</h1>
                    <p class="hero-jurisdiction">&#9878; Serving: <strong>Georgia &amp; South Carolina</strong></p>
                </div>
                <div class="speakable-intro" data-speakable="true">
                    <p class="hero-subtitle">Our mass tort and class action attorneys represent individuals and families harmed by dangerous drugs, defective products, toxic chemicals, and corporate negligence. If you or a loved one has been affected, we can help you pursue the compensation you deserve.</p>
                </div>

                <?php roden_stats_bar(); ?>

                <div class="hero-actions">
                    <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary btn-lg">&#128222; Call <?php echo esc_html( $firm['phone'] ); ?></a>
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
            array( 'name' => 'State Bar of Georgia',            'abbr' => 'GA Bar' ),
            array( 'name' => 'American Association for Justice', 'abbr' => 'AAJ' ),
            array( 'name' => 'Georgia Trial Lawyers Association', 'abbr' => 'GTLA' ),
            array( 'name' => 'American Bar Association',        'abbr' => 'ABA' ),
        );
        foreach ( $badges as $badge ) :
            $badge_file = get_template_directory() . '/assets/images/badges/' . sanitize_title( $badge['abbr'] ) . '.svg';
            $has_image  = file_exists( $badge_file );
        ?>
            <div class="trust-badge">
                <?php if ( $has_image ) : ?>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/badges/' . sanitize_title( $badge['abbr'] ) . '.svg' ); ?>"
                         alt="<?php echo esc_attr( $badge['name'] ); ?> Member Badge"
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
     SECTION 3: CLASS ACTION TYPES GRID
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="section-location-matrix">
    <div class="container">
        <h2 class="matrix-title">Mass Torts &amp; Class Actions We Handle</h2>
        <p style="text-align:center; max-width:700px; margin:0 auto var(--space-lg); color:var(--text-medium);">
            Our attorneys are actively investigating and pursuing claims in the following mass tort and class action cases. Click any case type to learn more about your legal options.
        </p>
        <div class="sub-types-grid">
            <?php
            $class_actions = new WP_Query( array(
                'post_type'      => 'class-action',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            ) );

            if ( $class_actions->have_posts() ) :
                while ( $class_actions->have_posts() ) :
                    $class_actions->the_post();
                    ?>
                    <a href="<?php the_permalink(); ?>" class="sub-type-card sub-type-link">
                        <span class="st-name"><?php the_title(); ?></span>
                        <span class="st-arrow">&rarr;</span>
                    </a>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p>No class action cases are currently listed. Please check back soon.</p>
            <?php endif; ?>
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
                 SECTION 4: WHAT ARE MASS TORTS & CLASS ACTIONS?
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-why-hire">
                <h2>What Are Mass Torts &amp; Class Actions?</h2>
                <div class="pa-why-hire__body">
                    <p>Mass torts and class action lawsuits allow large groups of people who have been harmed by the same product, drug, or corporate conduct to seek justice collectively. While often used interchangeably, these legal actions have important differences:</p>
                    <ul>
                        <li><strong>Mass Tort:</strong> Each plaintiff files an individual lawsuit, but the cases are consolidated for efficiency. Each person's injuries and damages are evaluated separately, which often results in higher individual compensation.</li>
                        <li><strong>Class Action:</strong> A single lawsuit is filed on behalf of an entire group (the "class"). One or more representative plaintiffs stand in for the group, and any settlement or verdict is divided among all class members.</li>
                    </ul>
                    <p>Both types of litigation are powerful tools for holding corporations accountable when their products or actions cause widespread harm. At Roden Law, our attorneys have the experience and resources to take on large corporations and fight for the compensation our clients deserve.</p>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 5: INLINE CTA BANNER (#1)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_inline_cta_banner(); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 6: HOW CLASS ACTION LAWSUITS WORK
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-elements-section">
                <h2>How Class Action Lawsuits Work</h2>
                <p>Mass tort and class action cases typically follow a structured legal process. Here is what you can expect when you pursue a claim:</p>
                <div class="pa-elements">
                    <?php
                    $steps = array(
                        array(
                            'num'   => '01',
                            'title' => 'Investigation & Case Review',
                            'body'  => 'Our attorneys investigate the facts of your case, review medical records, and determine whether you have a viable claim. We identify the responsible parties and gather evidence of their negligence or wrongdoing.',
                        ),
                        array(
                            'num'   => '02',
                            'title' => 'Filing the Lawsuit',
                            'body'  => 'Once we establish the merits of your case, we file the lawsuit on your behalf. In mass tort cases, your individual claim is filed alongside others; in class actions, representative plaintiffs are selected to lead the litigation.',
                        ),
                        array(
                            'num'   => '03',
                            'title' => 'Discovery & Litigation',
                            'body'  => 'During discovery, both sides exchange evidence, depose witnesses, and retain expert consultants. This phase can reveal critical internal documents showing what corporations knew about the dangers of their products.',
                        ),
                        array(
                            'num'   => '04',
                            'title' => 'Resolution',
                            'body'  => 'Cases may be resolved through a negotiated settlement, a bellwether trial verdict, or a global settlement fund. Our attorneys fight to maximize your compensation and will not settle for less than you deserve.',
                        ),
                    );
                    foreach ( $steps as $step ) : ?>
                        <div class="pa-element">
                            <div class="pa-element__num"><?php echo esc_html( $step['num'] ); ?></div>
                            <div class="pa-element__content">
                                <h3><?php echo esc_html( $step['title'] ); ?></h3>
                                <p><?php echo esc_html( $step['body'] ); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 7: TYPES OF COMPENSATION
                 ═══════════════════════════════════════════════════════════ -->
            <div class="content-section pa-compensation">
                <h2>Types of Compensation You Can Recover</h2>
                <div class="pa-compensation__grid">
                    <div class="pa-compensation__col">
                        <h3>Economic Damages</h3>
                        <ul>
                            <li>Past and future medical expenses</li>
                            <li>Lost wages or income</li>
                            <li>Loss of earning capacity</li>
                            <li>Cost of rehabilitation and physical therapy</li>
                            <li>Assistive medical equipment</li>
                            <li>Cost of long-term or lifelong care</li>
                            <li>Out-of-pocket expenses related to injury</li>
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
                            <li>Diminished quality of life</li>
                        </ul>
                        <p class="pa-compensation__note"><em>Compensation amounts vary by case type and individual circumstances. Mass tort claims are evaluated individually, which often allows for higher recovery than class action settlements.</em></p>
                    </div>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 INLINE CTA BANNER (#2)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_inline_cta_banner(); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 8: FAQ SECTION (Hardcoded)
                 ═══════════════════════════════════════════════════════════ -->
            <div class="faq-section" id="faq">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <div class="faq-accordion">
                    <?php
                    $faqs = array(
                        array(
                            'question' => 'What is the difference between a mass tort and a class action lawsuit?',
                            'answer'   => 'In a <strong>class action</strong>, one lawsuit is filed on behalf of an entire group, and any settlement is divided among all class members. In a <strong>mass tort</strong>, each plaintiff files their own individual claim, but the cases are consolidated for pretrial proceedings. Mass torts typically result in higher individual compensation because each person\'s unique injuries and damages are evaluated separately.',
                        ),
                        array(
                            'question' => 'How much does it cost to join a class action or mass tort lawsuit?',
                            'answer'   => 'There is no upfront cost. Roden Law handles mass tort and class action cases on a <strong>contingency fee basis</strong>, which means you pay nothing unless we recover compensation for you. We cover all investigation, filing, and litigation costs, and our fees are a percentage of your recovery.',
                        ),
                        array(
                            'question' => 'How long do mass tort and class action cases take?',
                            'answer'   => 'These cases can take anywhere from <strong>one to several years</strong> depending on the complexity of the litigation, the number of plaintiffs, and whether the case goes to trial or settles. Our attorneys keep clients informed throughout the process and work to resolve cases as efficiently as possible.',
                        ),
                        array(
                            'question' => 'How do I know if I qualify for a class action or mass tort lawsuit?',
                            'answer'   => 'If you have been harmed by a dangerous drug, defective product, toxic chemical, or other corporate negligence, you may qualify. Contact us for a <strong>free, no-obligation case review</strong>. Our attorneys will evaluate your situation, review your medical records, and determine whether you have a viable claim.',
                        ),
                        array(
                            'question' => 'Can I still file a claim if I did not experience severe side effects?',
                            'answer'   => 'Potentially, yes. Eligibility depends on the specific lawsuit and the criteria established for participation. Even if your injuries seem minor, they may still qualify for compensation. The best way to find out is to <strong>contact our attorneys for a free evaluation</strong> of your specific circumstances.',
                        ),
                    );

                    foreach ( $faqs as $i => $faq ) : ?>
                        <div class="faq-item">
                            <button class="faq-question" aria-expanded="false" aria-controls="faq-ca-answer-<?php echo (int) $i; ?>">
                                <span><?php echo esc_html( $faq['question'] ); ?></span>
                                <span class="faq-toggle">+</span>
                            </button>
                            <div class="faq-answer" id="faq-ca-answer-<?php echo (int) $i; ?>" hidden>
                                <p><?php echo wp_kses_post( $faq['answer'] ); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 INLINE CTA BANNER (#3)
                 ═══════════════════════════════════════════════════════════ -->
            <?php roden_inline_cta_banner(); ?>

            <!-- ═══════════════════════════════════════════════════════════
                 SECTION 9: BOTTOM CTA BLOCK
                 ═══════════════════════════════════════════════════════════ -->
            <div class="bottom-cta-box">
                <h2>Contact Our Class Action Lawyers Today</h2>
                <p>If you or a loved one has been harmed by a dangerous product, drug, or toxic substance, contact us for a free, no-obligation case review. Our mass tort attorneys have the resources and experience to take on large corporations and fight for the compensation you deserve &mdash; at no upfront cost.</p>
                <div class="cta-actions">
                    <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary">&#128222; Call <?php echo esc_html( $firm['phone'] ); ?></a>
                    <a href="#contact" class="btn btn-outline-light">Free Case Review</a>
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
                    <h3 class="widget-title">&#9201; Filing Deadlines</h3>
                    <div class="deadline-badges">
                        <div class="deadline-badge deadline-ga">
                            <span class="deadline-years">Varies</span>
                            <span class="deadline-state">Georgia</span>
                        </div>
                        <div class="deadline-badge deadline-sc">
                            <span class="deadline-years">Varies</span>
                            <span class="deadline-state">South Carolina</span>
                        </div>
                    </div>
                    <p class="deadline-warning">Mass tort filing deadlines vary by case type. Contact us immediately to ensure your claim is filed on time.</p>
                </div>

                <!-- Related Practice Areas -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Related Practice Areas</h3>
                    <?php
                    $related_pas = get_posts( array(
                        'post_type'      => 'practice_area',
                        'posts_per_page' => 7,
                        'post_parent'    => 0,
                        'orderby'        => 'rand',
                    ) );
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
                    <h3 class="widget-title">Why Roden Law?</h3>
                    <ul class="why-us-list">
                        <li>&#10003; <?php echo esc_html( $firm['recovered'] ); ?> Recovered for Clients</li>
                        <li>&#10003; <?php echo esc_html( $firm['rating'] ); ?>&#9733; Average Client Rating</li>
                        <li>&#10003; <?php echo esc_html( $firm['cases_handled'] ); ?> Cases Successfully Handled</li>
                        <li>&#10003; No Fee Unless We Win</li>
                        <li>&#10003; Free 24/7 Consultations</li>
                        <li>&#10003; Licensed in GA &amp; SC</li>
                    </ul>
                </div>
            </div>
        </aside>

    </div>
</div>


<?php get_footer(); ?>
