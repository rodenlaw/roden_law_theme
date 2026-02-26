<?php
/**
 * Custom Search Form
 *
 * @package RodenLaw
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Site search', 'roden-law' ); ?>">
    <label class="screen-reader-text" for="search-field"><?php esc_html_e( 'Search for:', 'roden-law' ); ?></label>
    <input type="search" id="search-field" class="search-field" placeholder="<?php esc_attr_e( "Search articles (e.g. 'truck accident')", 'roden-law' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    <button type="submit" class="search-submit btn btn-primary"><?php esc_html_e( 'Search', 'roden-law' ); ?></button>
</form>
