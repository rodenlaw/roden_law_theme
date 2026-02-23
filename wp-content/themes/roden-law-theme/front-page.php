<?php
/**
 * Homepage Template
 *
 * Hero with speakable markup, stats with LegalService schema,
 * practice area grid, multi-location section with LocalBusiness,
 * case results with ItemList, attorney grid, testimonials, CTA.
 *
 * @package RodenLaw
 */

get_header();
$firm = roden_firm_data();
?>

<!-- HERO SECTION -->
<section class="hero hero-homepage">
    <div class="hero-bg-overlay"></div>
    <div class="container hero-grid">
        <div class="hero-content">
            <div class="speakable-hero" data-speakable="true">
                <h1 class="hero-title">
                    Georgia &amp; South Carolina<br>
                    <span class="text-accent">Personal Injury Lawyers</span><br>
                    Who Fight for Maximum Compensation
                </h1>
                <p class="hero-subtitle speakable-summary">
                    Roden Law has recovered <strong><?php echo esc_html( $firm['recovered'] ); ?></strong> for injury victims across Savannah, Charleston, Columbia, Myrtle Beach, and Darien. No fees unless we win. Free case review 24/7.
                </p>
            </div>

            <?php roden_stats_bar(); ?>

            <div class="hero-actions">
                <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary btn-lg">📞 Call <?php echo esc_html($firm['phone']); ?></a>
                <a href="#contact" class="btn btn-outline-light btn-lg">Free Case Review</a>
            </div>
        </div>

        <div class="hero-form">
            <?php roden_contact_form_sidebar(); ?>
        </div>
    </div>
</section>

<!-- TRUST BAR -->
<div class="trust-bar">
    <div class="container trust-bar-inner">
        <?php
        $badges = ['State Bar of Georgia','American Association for Justice','Georgia Trial Lawyers','American Bar Association'];
        foreach ( $badges as $badge ) :
        ?>
            <div class="trust-badge">
                <span class="trust-icon">⚖</span>
                <span class="trust-label"><?php echo esc_html( $badge ); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- PRACTICE AREAS -->
<section class="section section-light" id="practice-areas">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">Personal Injury Practice Areas</h2>
            <p class="section-subtitle">We handle all types of personal injury cases throughout Georgia and South Carolina.</p>
        </div>
        <?php roden_practice_areas_grid( 4 ); ?>
    </div>
</section>

<!-- LOCATIONS -->
<section class="section" id="locations">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">Our Offices in Georgia &amp; South Carolina</h2>
        </div>
        <?php roden_location_cards(); ?>
    </div>
</section>

<!-- CASE RESULTS -->
<section class="section section-dark" id="results">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title text-white">Our Results Speak for Themselves</h2>
        </div>
        <?php roden_case_results_grid( [ 'count' => 4, 'columns' => 4 ] ); ?>
    </div>
</section>

<!-- ATTORNEYS -->
<section class="section section-light" id="attorneys">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">Meet Our Attorneys</h2>
            <p class="section-subtitle">Experienced personal injury lawyers licensed in Georgia and South Carolina.</p>
        </div>
        <?php roden_attorneys_grid( [ 'columns' => 4 ] ); ?>
    </div>
</section>

<!-- WHY RODEN LAW -->
<section class="section" id="why-us">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">Why Choose Roden Law?</h2>
        </div>
        <div class="value-props-grid">
            <?php
            $props = [
                ['icon'=>'💰', 'title'=>$firm['recovered'].' Recovered', 'text'=>'We have secured hundreds of millions of dollars in compensation for our clients.'],
                ['icon'=>'⭐', 'title'=>$firm['rating'].' Star Rating', 'text'=>'Our clients consistently rate us among the top personal injury firms.'],
                ['icon'=>'🏆', 'title'=>$firm['cases_handled'].' Cases', 'text'=>'Thousands of injury victims have trusted us with their cases.'],
                ['icon'=>'🤝', 'title'=>'No Fee Unless We Win', 'text'=>'We work on contingency — you pay nothing upfront and nothing if we don\'t recover for you.'],
                ['icon'=>'📞', 'title'=>'Free 24/7 Consultations', 'text'=>'Get a free, no-obligation case evaluation any time, day or night.'],
                ['icon'=>'📍', 'title'=>'5 Office Locations', 'text'=>'Offices across Georgia and South Carolina for convenient access.'],
            ];
            foreach ( $props as $prop ) :
            ?>
                <div class="value-prop-card">
                    <span class="vp-icon"><?php echo $prop['icon']; ?></span>
                    <h3 class="vp-title"><?php echo esc_html( $prop['title'] ); ?></h3>
                    <p class="vp-text"><?php echo esc_html( $prop['text'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="section section-light" id="testimonials">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">What Our Clients Say</h2>
            <?php roden_stars( $firm['rating'], $firm['review_count'] . '+' ); ?>
        </div>
        <?php
        $testimonials = get_posts(['post_type'=>'testimonial','posts_per_page'=>3]);
        if ( $testimonials ) :
            echo '<div class="testimonials-grid">';
            foreach ( $testimonials as $t ) :
                echo '<div class="testimonial-card">';
                echo '<div class="testimonial-stars">★★★★★</div>';
                echo '<blockquote class="testimonial-text">' . wp_kses_post( $t->post_content ) . '</blockquote>';
                echo '<cite class="testimonial-author">' . esc_html( $t->post_title ) . '</cite>';
                echo '</div>';
            endforeach;
            echo '</div>';
        endif;
        ?>
    </div>
</section>

<!-- BOTTOM CTA -->
<section class="section section-cta" id="contact">
    <div class="container text-center">
        <h2 class="section-title text-white">Injured? Get Your Free Case Review Today.</h2>
        <p class="section-subtitle text-light">Our attorneys are standing by 24/7. No fees unless we recover compensation for you.</p>
        <div class="cta-actions">
            <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-primary btn-lg">📞 Call <?php echo esc_html($firm['phone']); ?></a>
            <a href="#contact-form" class="btn btn-outline-light btn-lg">Free Case Evaluation</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
