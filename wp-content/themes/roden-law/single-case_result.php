<?php
/**
 * Single Case Result Template
 *
 * Displays case result details: amount, type, description, attorney,
 * and related case results from the same practice category.
 *
 * @package Roden_Law
 */

get_header();

$firm    = roden_firm_data();
$post_id = get_the_ID();

$amount      = get_post_meta( $post_id, '_roden_case_amount', true );
$type        = get_post_meta( $post_id, '_roden_case_type', true );
$description = get_post_meta( $post_id, '_roden_description', true );
$attorney_id = get_post_meta( $post_id, '_roden_attorney', true );
$attorney    = $attorney_id ? get_post( $attorney_id ) : null;
?>

<section class="hero hero-case-result">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <div class="hero-content text-center">
            <?php if ( $type ) : ?>
                <span class="result-type-badge"><?php echo esc_html( ucfirst( $type ) ); ?></span>
            <?php endif; ?>
            <?php if ( $amount ) : ?>
                <span class="result-hero-amount"><?php echo esc_html( $amount ); ?></span>
            <?php endif; ?>
            <h1 class="hero-title"><?php the_title(); ?></h1>
        </div>
    </div>
</section>

<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <article class="main-content">
            <?php if ( $description ) : ?>
                <div class="content-section">
                    <h2>Case Details</h2>
                    <p><?php echo wp_kses_post( $description ); ?></p>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <?php if ( $attorney ) :
                $atty_title = get_post_meta( $attorney->ID, '_roden_atty_title', true );
            ?>
                <div class="content-section">
                    <h2>Handled By</h2>
                    <div class="author-card">
                        <div class="author-photo">
                            <?php if ( has_post_thumbnail( $attorney ) ) : ?>
                                <?php echo get_the_post_thumbnail( $attorney, 'thumbnail' ); ?>
                            <?php endif; ?>
                        </div>
                        <div class="author-info">
                            <h3 class="author-name">
                                <a href="<?php echo esc_url( get_permalink( $attorney ) ); ?>"><?php echo esc_html( $attorney->post_title ); ?></a>
                            </h3>
                            <?php if ( $atty_title ) : ?>
                                <span class="author-title"><?php echo esc_html( $atty_title ); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="content-section">
                <h2>More Case Results</h2>
                <?php
                $pa_terms = wp_get_object_terms( $post_id, 'practice_category', array( 'fields' => 'slugs' ) );
                $cat_slug = ( ! is_wp_error( $pa_terms ) && ! empty( $pa_terms ) ) ? $pa_terms[0] : '';
                roden_case_results_grid( array(
                    'count'             => 4,
                    'columns'           => 4,
                    'practice_category' => $cat_slug,
                ) );
                ?>
            </div>

            <div class="results-disclaimer-box">
                <p><strong>Disclaimer:</strong> Results shown are gross settlement/verdict amounts before attorney fees and cost deductions. Past results do not guarantee or suggest similar recovery in your case. Each case is unique.</p>
            </div>
        </article>

        <aside class="sidebar sidebar-case-result">
            <div class="sidebar-sticky">
                <div class="sidebar-widget sidebar-consult-cta">
                    <h3>Free Case Review</h3>
                    <p>Think you have a case? Get a free, no-obligation consultation.</p>
                    <a href="tel:<?php echo esc_attr( $firm['phone_e164'] ); ?>" class="btn btn-primary btn-block"><?php echo esc_html( $firm['phone'] ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>#free-case-review" class="btn btn-outline-light btn-block">Case Review Form</a>
                </div>

                <?php roden_why_roden_sidebar(); ?>
            </div>
        </aside>

    </div>
</div>

<?php get_footer(); ?>
