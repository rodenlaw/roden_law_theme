<?php
/**
 * 404 Template
 * @package RodenLaw
 */
get_header();
$firm = roden_firm_data();
?>

<section class="hero hero-page">
    <div class="container text-center">
        <h1 class="hero-title"><?php esc_html_e( 'Page Not Found', 'roden-law' ); ?></h1>
        <p class="hero-subtitle"><?php esc_html_e( 'The page you\'re looking for doesn\'t exist or has been moved.', 'roden-law' ); ?></p>
        <div class="blog-search" style="max-width: 480px; margin: 24px auto 0;">
            <?php get_search_form(); ?>
        </div>
        <div class="hero-actions" style="margin-top: 16px;">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg"><?php esc_html_e( 'Go to Homepage', 'roden-law' ); ?></a>
            <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-outline-light btn-lg"><?php printf( /* translators: %s: phone number. */ esc_html__( 'Call %s', 'roden-law' ), esc_html( $firm['phone'] ) ); ?></a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title text-center"><?php esc_html_e( 'Looking for Something?', 'roden-law' ); ?></h2>
        <div class="error-links-grid">
            <div class="error-link-col">
                <h3><?php esc_html_e( 'Practice Areas', 'roden-law' ); ?></h3>
                <?php
                $pas_args = ['post_type'=>'practice_area','posts_per_page'=>8,'orderby'=>'menu_order','order'=>'ASC'];
                if ( function_exists( 'roden_es_exclusion_meta_query' ) ) {
                    $pas_args['meta_query'] = roden_es_exclusion_meta_query();
                }
                $pas = get_posts( $pas_args );
                echo '<ul>';
                foreach ($pas as $pa) echo '<li><a href="'.esc_url(get_permalink($pa)).'">'.esc_html($pa->post_title).'</a></li>';
                echo '</ul>';
                ?>
            </div>
            <div class="error-link-col">
                <h3><?php esc_html_e( 'Locations', 'roden-law' ); ?></h3>
                <ul>
                    <?php foreach ($firm['offices'] as $key => $office) :
                        $slug = sanitize_title($office['market_name']);
                        $ss = $office['state']==='GA' ? 'georgia' : 'south-carolina';
                    ?>
                        <li><a href="<?php echo esc_url(home_url('/locations/'.$ss.'/'.$slug.'/')); ?>"><?php echo esc_html($office['market_name'].', '.$office['state']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php
// Output BreadcrumbList schema for 404 page — maintains site structure signal.
if ( function_exists( 'roden_json_ld' ) ) {
    roden_json_ld( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => array(
            array(
                '@type'    => 'ListItem',
                'position' => 1,
                'name'     => 'Home',
                'item'     => home_url( '/' ),
            ),
            array(
                '@type'    => 'ListItem',
                'position' => 2,
                'name'     => 'Page Not Found',
            ),
        ),
    ) );
}
?>

<?php get_footer(); ?>
