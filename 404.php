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
        <h1 class="hero-title">Page Not Found</h1>
        <p class="hero-subtitle">The page you're looking for doesn't exist or has been moved.</p>
        <div class="hero-actions">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg">Go to Homepage</a>
            <a href="tel:<?php echo esc_attr($firm['phone_e164']); ?>" class="btn btn-outline-light btn-lg">📞 Call <?php echo esc_html($firm['phone']); ?></a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title text-center">Looking for Something?</h2>
        <div class="error-links-grid">
            <div class="error-link-col">
                <h3>Practice Areas</h3>
                <?php
                $pas = get_posts(['post_type'=>'practice_area','posts_per_page'=>8,'orderby'=>'menu_order','order'=>'ASC']);
                echo '<ul>';
                foreach ($pas as $pa) echo '<li><a href="'.esc_url(get_permalink($pa)).'">'.esc_html($pa->post_title).'</a></li>';
                echo '</ul>';
                ?>
            </div>
            <div class="error-link-col">
                <h3>Locations</h3>
                <ul>
                    <?php foreach ($firm['offices'] as $key => $office) :
                        $slug = strtolower(str_replace(' ','-',$office['city']));
                        $ss = $office['state']==='GA' ? 'georgia' : 'south-carolina';
                    ?>
                        <li><a href="<?php echo esc_url(home_url('/locations/'.$ss.'/'.$slug.'/')); ?>"><?php echo esc_html($office['city'].', '.$office['state']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
