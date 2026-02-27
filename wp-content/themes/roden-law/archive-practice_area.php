<?php
/**
 * Archive: Practice Areas
 *
 * Displays all 18 pillar practice areas in a grid.
 * Uses roden_practice_areas_grid() which queries top-level (parent=0)
 * practice_area posts, with a hardcoded fallback if no CPT posts exist.
 *
 * @package Roden_Law
 */

get_header();

$firm = roden_firm_data();
?>

<section class="hero hero-archive">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <h1 class="hero-title"><?php esc_html_e( 'Personal Injury Practice Areas', 'roden-law' ); ?></h1>
        <p class="hero-subtitle">
            <?php esc_html_e( 'Roden Law handles all types of personal injury cases across Georgia and South Carolina. Our attorneys have recovered', 'roden-law' ); ?>
            <strong><?php echo esc_html( $firm['trust_stats']['recovered'] ); ?></strong>
            <?php esc_html_e( 'for injured clients. Select a practice area below to learn more.', 'roden-law' ); ?>
        </p>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <?php
        // Full grid of all 18 pillar practice areas.
        $all_areas = get_posts( array(
            'post_type'      => 'practice_area',
            'posts_per_page' => -1,
            'post_parent'    => 0,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ) );

        // Fallback: use firm data slugs if no CPT posts exist yet.
        if ( empty( $all_areas ) ) {
            $pa_labels = array(
                'car-accident-lawyers'          => 'Car Accident Lawyers',
                'truck-accident-lawyers'         => 'Truck Accident Lawyers',
                'slip-and-fall-lawyers'          => 'Slip & Fall Lawyers',
                'motorcycle-accident-lawyers'    => 'Motorcycle Accident Lawyers',
                'medical-malpractice-lawyers'    => 'Medical Malpractice Lawyers',
                'wrongful-death-lawyers'         => 'Wrongful Death Lawyers',
                'workers-compensation-lawyers'   => 'Workers\' Compensation Lawyers',
                'dog-bite-lawyers'               => 'Dog Bite Lawyers',
                'brain-injury-lawyers'           => 'Brain Injury Lawyers',
                'spinal-cord-injury-lawyers'     => 'Spinal Cord Injury Lawyers',
                'maritime-injury-lawyers'        => 'Maritime Injury Lawyers',
                'product-liability-lawyers'      => 'Product Liability Lawyers',
                'boating-accident-lawyers'       => 'Boating Accident Lawyers',
                'burn-injury-lawyers'            => 'Burn Injury Lawyers',
                'construction-accident-lawyers'  => 'Construction Accident Lawyers',
                'nursing-home-abuse-lawyers'     => 'Nursing Home Abuse Lawyers',
                'premises-liability-lawyers'     => 'Premises Liability Lawyers',
                'pedestrian-accident-lawyers'    => 'Pedestrian Accident Lawyers',
            );
            ?>
            <div class="practice-area-grid practice-area-grid--cols-3">
                <?php foreach ( $pa_labels as $slug => $name ) :
                    $url = home_url( '/practice-areas/' . $slug . '/' );
                ?>
                    <a href="<?php echo esc_url( $url ); ?>" class="card practice-area-card">
                        <h3><?php echo esc_html( $name ); ?></h3>
                        <span class="card-arrow" aria-hidden="true">&rarr;</span>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php
        } else {
            ?>
            <div class="practice-area-grid practice-area-grid--cols-3">
                <?php foreach ( $all_areas as $area ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $area ) ); ?>" class="card practice-area-card">
                        <h3><?php echo esc_html( $area->post_title ); ?></h3>
                        <span class="card-arrow" aria-hidden="true">&rarr;</span>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php
        }
        ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h2><?php esc_html_e( 'Our Offices', 'roden-law' ); ?></h2>
            <p><?php esc_html_e( 'We serve clients from 5 locations across Georgia and South Carolina.', 'roden-law' ); ?></p>
        </div>
        <?php roden_location_cards(); ?>
    </div>
</section>

<section class="section bg-navy cta-bottom">
    <div class="container text-center">
        <h2 class="text-white"><?php esc_html_e( 'Injured? Get Your Free Case Review.', 'roden-law' ); ?></h2>
        <p class="text-white" style="opacity:0.85; max-width:600px; margin:0 auto var(--space-xl);">
            <?php esc_html_e( 'No fees unless we win. Available 24/7 across Georgia and South Carolina.', 'roden-law' ); ?>
        </p>
        <div class="hero-ctas" style="justify-content:center;">
            <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary btn-lg">
                <?php printf( esc_html__( 'Call %s', 'roden-law' ), esc_html( $firm['vanity_phone'] ) ); ?>
            </a>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>#free-case-review" class="btn btn-outline-white btn-lg">
                <?php esc_html_e( 'Free Case Review', 'roden-law' ); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
