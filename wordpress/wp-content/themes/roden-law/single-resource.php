<?php
/**
 * Single Resource Template
 *
 * Resource pages (guides, state law explainers, what-to-do articles).
 * Content with sidebar, author attribution (E-E-A-T), reading time,
 * related practice areas, and filing deadlines.
 *
 * @package Roden_Law
 */

get_header();

$firm      = roden_firm_data();
$post_id   = get_the_ID();
$author_id = get_post_meta( $post_id, '_roden_author_attorney', true );
$atty      = $author_id ? get_post( $author_id ) : null;
$atty_title = $atty ? get_post_meta( $atty->ID, '_roden_atty_title', true ) : '';
?>

<section class="hero hero-resource">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <h1 class="hero-title"><?php the_title(); ?></h1>
        <div class="post-meta-bar">
            <?php if ( $atty ) : ?>
                <div class="post-author">
                    <div class="post-author-photo">
                        <?php if ( has_post_thumbnail( $atty ) ) : ?>
                            <?php echo get_the_post_thumbnail( $atty, 'thumbnail', array( 'alt' => esc_attr( $atty->post_title . ', ' . $atty_title . ' at Roden Law' ) ) ); ?>
                        <?php endif; ?>
                    </div>
                    <div class="post-author-info">
                        <a href="<?php echo esc_url( get_permalink( $atty ) ); ?>" class="post-author-name"><?php echo esc_html( $atty->post_title ); ?></a>
                        <span class="post-author-title"><?php echo esc_html( $atty_title ); ?></span>
                    </div>
                </div>
            <?php endif; ?>
            <span class="post-date"><?php echo esc_html( get_the_date() ); ?></span>
            <?php
            $updated_ts = roden_updated_byline_ts(); // a recorded content change, never post_modified
            if ( $updated_ts ) : ?>
                <span class="post-updated"><?php esc_html_e( 'Updated:', 'roden-law' ); ?> <?php echo esc_html( roden_format_long_date( $updated_ts ) ); ?></span>
            <?php endif; ?>
            <span class="post-read-time"><?php printf( /* translators: %d: reading time in minutes. */ esc_html__( '%d min read', 'roden-law' ), (int) roden_reading_time() ); ?></span>
            <?php echo roden_last_reviewed_html(); // escaped in the helper; '' when unset ?>
            <?php echo roden_last_refreshed_html(); // escaped in the helper; '' when unset ?>
        </div>
    </div>
</section>

<div class="content-with-sidebar">
    <div class="container content-sidebar-grid">

        <article class="main-content entry-content">
            <?php
            $key_takeaways = get_post_meta( $post_id, '_roden_key_takeaways', true );
            if ( $key_takeaways ) : ?>
                <section class="key-takeaways-box">
                    <h2 class="key-takeaways-title"><?php esc_html_e( 'Key Takeaways', 'roden-law' ); ?></h2>
                    <p><?php echo wp_kses_post( $key_takeaways ); ?></p>
                </section>
            <?php endif; ?>

            <?php if ( has_post_thumbnail() ) : ?>
                <figure class="post-featured-image">
                    <?php the_post_thumbnail( 'large' ); ?>
                </figure>
            <?php endif; ?>

            <?php the_content(); ?>

            <?php roden_inline_cta_banner(); ?>

            <?php
            // "Related Pages" from _roden_see_also. The renderer normalizes the
            // stored nested practice-area paths to their flat canonical — see
            // roden_see_also_links() in inc/template-tags.php.
            roden_see_also_links( $post_id );
            ?>

            <?php roden_faq_section( $post_id ); ?>

            <?php roden_author_attribution( $post_id ); ?>

            <!-- Google Preferred Source -->
            <div class="post-preferred-source">
                <p><?php esc_html_e( 'Want more from Roden Law in your Google results?', 'roden-law' ); ?></p>
                <?php roden_preferred_source_badge( 'light' ); ?>
            </div>
        </article>

        <aside class="sidebar sidebar-resource">
            <div class="sidebar-sticky">
                <?php roden_contact_form_sidebar(); ?>

                <?php roden_filing_deadlines_sidebar(); ?>

                <?php
                // Related resources (sibling resources in same practice_category)
                $res_cat_terms = wp_get_object_terms( $post_id, 'practice_category', array( 'fields' => 'slugs' ) );
                $res_cat_terms = is_wp_error( $res_cat_terms ) ? array() : $res_cat_terms;
                /*
                 * The SC-law guides keep `south-carolina-law` as their sibling
                 * set. wp_get_object_terms() sorts by term name, so adding a
                 * topic term that sorts before it (Car Accidents, Motorcycle
                 * Accidents, Premises Liability, Slip & Fall) would silently
                 * switch this sidebar to that topic. Topic terms were added to
                 * fill intersection and sub-type lists (2026-10-23), not to
                 * change these sidebars.
                 */
                $res_cat_slug  = in_array( 'south-carolina-law', $res_cat_terms, true ) ? 'south-carolina-law' : ( $res_cat_terms ? $res_cat_terms[0] : '' );
                $res_guide_args = array(
                    'count'   => 5,
                    'cat_slug' => $res_cat_slug,
                    'heading'  => __( 'Related Guides', 'roden-law' ),
                    'display'  => 'sidebar',
                    'exclude'  => $post_id,
                    // Same-state guides only (from _roden_jurisdiction).
                    'jurisdiction_of' => $post_id,
                );
                $shown_guides = roden_related_resources( $res_guide_args );
                /*
                 * A topic with no other same-state guide (the only golf cart
                 * guide, Georgia's only wrongful death guide) renders nothing.
                 * Then list as an untermed guide does, so a term never removes
                 * this box.
                 */
                if ( ! $shown_guides && '' !== $res_cat_slug ) {
                    $res_guide_args['cat_slug'] = '';
                    $shown_guides = roden_related_resources( $res_guide_args );
                }
                ?>

                <?php
                // Other guides: same state rule as above, minus the ones it listed.
                roden_related_practice_areas( 6, array(
                    'jurisdiction_of' => $post_id,
                    'exclude'         => is_array( $shown_guides ) ? $shown_guides : array(),
                    // It lists guides, not practice areas. Existing msgid, already
                    // translated in es_ES.po/.mo ("Recursos Relacionados").
                    'heading'         => __( 'Related Resources', 'roden-law' ),
                ) );
                ?>

                <?php roden_why_roden_sidebar(); ?>
            </div>
        </aside>

    </div>
</div>

<?php get_footer(); ?>
