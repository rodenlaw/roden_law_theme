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
        <?php
        $pa_posts = get_posts(['post_type'=>'practice_area','posts_per_page'=>-1,'orderby'=>'menu_order','order'=>'ASC']);
        // Also check the old CPT slug with hyphen
        if ( empty($pa_posts) ) {
            $pa_posts = get_posts(['post_type'=>'practice-area','posts_per_page'=>-1,'orderby'=>'menu_order','order'=>'ASC']);
        }
        if ( ! empty($pa_posts) ) :
            echo '<div class="practice-areas-grid cols-4">';
            foreach ( $pa_posts as $pa ) {
                echo '<a href="' . esc_url(get_permalink($pa)) . '" class="practice-area-card">';
                echo '<span class="pa-icon">⚖</span>';
                echo '<span class="pa-name">' . esc_html($pa->post_title) . '</span>';
                echo '</a>';
            }
            echo '</div>';
        else :
            $fallback_pas = [
                'Car Accident'=>'car-accident-lawyers','Truck Accident'=>'truck-accident-lawyers',
                'Slip & Fall'=>'slip-and-fall-lawyers','Medical Malpractice'=>'medical-malpractice-lawyers',
                'Motorcycle Accident'=>'motorcycle-accident-lawyers','Wrongful Death'=>'wrongful-death-lawyers',
                "Workers' Comp"=>'workers-compensation-lawyers','Dog Bite'=>'dog-bite-lawyers',
                'Brain Injury'=>'brain-injury-lawyers','Spinal Cord Injury'=>'spinal-cord-injury-lawyers',
                'Maritime'=>'maritime-injury-lawyers','Product Liability'=>'product-liability-lawyers',
                'Boating Accident'=>'boating-accident-lawyers','Burn Injury'=>'burn-injury-lawyers',
                'Construction Accident'=>'construction-accident-lawyers','Nursing Home Abuse'=>'nursing-home-abuse-lawyers',
            ];
            echo '<div class="practice-areas-grid cols-4">';
            foreach ( $fallback_pas as $name => $slug ) {
                echo '<a href="' . esc_url(home_url('/practice-areas/' . $slug . '/')) . '" class="practice-area-card">';
                echo '<span class="pa-icon">⚖</span>';
                echo '<span class="pa-name">' . esc_html($name) . '</span>';
                echo '</a>';
            }
            echo '</div>';
        endif;
        ?>
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
        <?php
        $cr_posts = get_posts(['post_type'=>'case_result','posts_per_page'=>4,'orderby'=>'date','order'=>'DESC']);
        if ( ! empty($cr_posts) ) :
            echo '<div class="case-results-grid cols-4">';
            foreach ($cr_posts as $cr) {
                $amount = get_post_meta($cr->ID, '_roden_cr_amount', true);
                $type = get_post_meta($cr->ID, '_roden_cr_type', true);
                $desc = get_post_meta($cr->ID, '_roden_cr_description', true);
                echo '<div class="result-card">';
                echo '<span class="result-type">' . esc_html($type ?: 'Settlement') . '</span>';
                echo '<span class="result-amount">' . esc_html($amount ?: '$0') . '</span>';
                echo '<span class="result-title">' . esc_html($cr->post_title) . '</span>';
                if ($desc) echo '<p class="result-desc">' . esc_html($desc) . '</p>';
                echo '</div>';
            }
            echo '</div>';
        else :
            $fallback_results = [
                ['amount'=>'$27,000,000','type'=>'Settlement','title'=>'Truck Accident','desc'=>'Client paralyzed in collision with commercial semi-truck.'],
                ['amount'=>'$10,860,000','type'=>'Verdict','title'=>'Product Liability','desc'=>'Defective product caused catastrophic injury.'],
                ['amount'=>'$9,800,000','type'=>'Recovery','title'=>'Premises Liability','desc'=>'Severe injury due to negligent property maintenance.'],
                ['amount'=>'$3,000,000','type'=>'Settlement','title'=>'Auto Accident','desc'=>'Wrongful death — surviving spouse of auto accident victim.'],
            ];
            echo '<div class="case-results-grid cols-4">';
            foreach ($fallback_results as $r) {
                echo '<div class="result-card">';
                echo '<span class="result-type">' . esc_html($r['type']) . '</span>';
                echo '<span class="result-amount">' . esc_html($r['amount']) . '</span>';
                echo '<span class="result-title">' . esc_html($r['title']) . '</span>';
                echo '<p class="result-desc">' . esc_html($r['desc']) . '</p>';
                echo '</div>';
            }
            echo '</div>';
            echo '<p class="results-disclaimer">Results shown are gross settlement/verdict amounts before fees and costs. Past results do not guarantee similar outcomes.</p>';
        endif;
        ?>
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
