<?php
/**
 * Template Name: SC Statewide Pillar (Indexable)
 *
 * INDEXABLE organic statewide "South Carolina [practice] lawyer" pillar pages
 * (SC competitor gap analysis 2026-06-29, P0-4). Distinct from the noindex PPC
 * template-landing-sc-statewide.php — this one uses the normal site chrome
 * (get_header/get_footer) so it automatically inherits:
 *   - the real site canonical (<link rel="canonical">, seo-meta.php)
 *   - BreadcrumbList schema (schema dispatcher, not in roden_noindex list)
 *   - XML sitemap inclusion (it is NOT in roden_noindex_page_templates())
 *   - FAQPage + LegalService schema (wired in schema-helpers.php dispatcher)
 *
 * This template is intentionally NOT added to roden_noindex_page_templates(),
 * so it ships indexable and the live noindex PPC landing pages are untouched.
 *
 * Content is driven by page meta so each pillar is independently editable:
 *   _roden_pillar_practice    string  Practice label, e.g. "Truck Accident"
 *   _roden_pillar_practice_l  string  Lowercase label, e.g. "truck accident"
 *   _roden_key_takeaways      string  AI-extractable summary paragraph
 *   post_content              html    The pillar body (answer-first H2 sections)
 *   _roden_faqs               array   [ ['question'=>, 'answer'=>], ... ]
 *
 * SC law is pulled from roden_firm_data()['jurisdiction']['SC'] so the SOL cite
 * and 51% comparative-fault rule stay correct and never bleed GA O.C.G.A. law.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'roden_breadcrumb_html' ) ) {
    require_once get_template_directory() . '/inc/template-tags.php';
}

$firm   = roden_firm_data();
$sc_law = $firm['jurisdiction']['SC'];

// SC offices for the statewide coverage strip.
$sc_office_keys = array( 'charleston', 'north-charleston', 'columbia', 'myrtle-beach' );

$practice_label = get_post_meta( get_the_ID(), '_roden_pillar_practice', true );
$key_takeaways  = get_post_meta( get_the_ID(), '_roden_key_takeaways', true );

get_header();
?>

<section class="hero hero-page">
    <div class="container">
        <?php roden_breadcrumb_html(); ?>
        <h1 class="hero-title"><?php the_title(); ?></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <article class="entry-content page-content sc-pillar">

            <style>
                .sc-pillar .sc-law-callout { margin: 40px 0; padding: 28px; background: var(--light-bg, #F8F6F2); border-left: 4px solid var(--orange, #FCB415); border-radius: 8px; }
                .sc-pillar .sc-law-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; margin-top: 16px; }
                .sc-pillar .sc-law-card .law-value { font-size: 28px; font-weight: 800; color: var(--navy, #013046); margin: 4px 0; }
                .sc-pillar .sc-law-card .cite { font-style: italic; color: var(--text-medium, #555); font-size: 14px; }
                .sc-pillar .sc-law-links { margin-top: 20px; font-size: 15px; }
                .sc-pillar .sc-offices-strip { margin: 40px 0; }
                .sc-pillar .sc-offices-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 16px; }
                .sc-pillar .sc-office-card { padding: 20px; border: 1px solid var(--border, #e0e0e0); border-radius: 8px; }
                .sc-pillar .sc-office-card h3 { margin: 0 0 8px; color: var(--navy, #013046); }
                .sc-pillar .sc-pillar-cta { margin: 48px 0 0; padding: 32px; background: var(--navy, #013046); color: #fff; border-radius: 10px; text-align: center; }
                .sc-pillar .sc-pillar-cta h2 { color: #fff; margin-top: 0; }
                .sc-pillar .sc-pillar-cta .btn { margin: 8px 6px 0; }
            </style>

            <?php if ( $key_takeaways ) : ?>
                <section class="key-takeaways-box" data-ai-extractable="true">
                    <h2 class="key-takeaways-title">Key Takeaways</h2>
                    <p><?php echo wp_kses_post( $key_takeaways ); ?></p>
                </section>
            <?php endif; ?>

            <?php
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
            ?>

            <!-- ===== SOUTH CAROLINA LAW CALLOUT (SC-only — no GA bleed) ===== -->
            <div class="sc-law-callout">
                <h2>South Carolina Law That Affects Your Case</h2>
                <div class="sc-law-grid">
                    <div class="sc-law-card">
                        <h3>Filing Deadline (Statute of Limitations)</h3>
                        <p class="law-value"><?php echo esc_html( $sc_law['statute_years'] ); ?> years</p>
                        <p>South Carolina generally gives injured people
                        <?php echo esc_html( $sc_law['statute_years'] ); ?> years from the date of injury to
                        file a personal injury lawsuit. Some claims &mdash; especially those against a
                        government entity under the South Carolina Tort Claims Act &mdash; have shorter
                        deadlines.</p>
                        <p class="cite"><?php echo esc_html( $sc_law['statute_cite'] ); ?></p>
                    </div>
                    <div class="sc-law-card">
                        <h3>Modified Comparative Negligence</h3>
                        <p class="law-value">51% bar</p>
                        <p>Under South Carolina&rsquo;s modified comparative negligence rule, you can still
                        recover compensation as long as you were less than 51% at fault. Your award is
                        reduced by your share of fault &mdash; insurers often try to inflate it, and our
                        attorneys push back.</p>
                    </div>
                </div>
                <p class="sc-law-links">
                    Learn more:
                    <a href="/resources/south-carolina-statute-of-limitations/">South Carolina statute of limitations</a> &middot;
                    <a href="/resources/south-carolina-comparative-negligence/">South Carolina comparative negligence</a> &middot;
                    <a href="/resources/south-carolina-um-uim-stacking/">stacking UM/UIM coverage</a>
                </p>
            </div>

            <!-- ===== 4 OFFICES ACROSS SOUTH CAROLINA ===== -->
            <div class="sc-offices-strip">
                <h2>Roden Law Offices Serving All of South Carolina</h2>
                <div class="sc-offices-grid">
                    <?php
                    foreach ( $sc_office_keys as $key ) :
                        if ( ! isset( $firm['offices'][ $key ] ) ) {
                            continue;
                        }
                        $office = $firm['offices'][ $key ];
                        $market = isset( $office['market_name'] ) ? $office['market_name'] : $office['city'];
                        ?>
                        <div class="sc-office-card">
                            <h3><?php echo esc_html( $market ); ?></h3>
                            <p><?php echo esc_html( $office['address'] ); ?><br>
                            <?php echo esc_html( $office['city'] ); ?>, <?php echo esc_html( $office['state'] ); ?>
                            <?php echo esc_html( $office['zip'] ); ?></p>
                            <p><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $office['phone'] ) ); ?>"><?php echo esc_html( $office['phone'] ); ?></a></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ===== FAQ ACCORDION (FAQPage schema emitted via schema dispatcher) ===== -->
            <?php roden_faq_section( get_the_ID() ); ?>

            <!-- ===== BOTTOM CTA ===== -->
            <div class="sc-pillar-cta">
                <h2>Free Case Review &mdash; No Fee Unless We Win</h2>
                <p>If you were injured<?php echo $practice_label ? ' in a South Carolina ' . esc_html( strtolower( $practice_label ) ) : ' in South Carolina'; ?>,
                a Roden Law attorney will review your case at no cost and explain your options.
                We work on a contingency fee basis &mdash; you pay nothing unless we recover for you.</p>
                <p><a class="btn btn-primary" href="tel:18447378587">Call 1-844-RESULTS</a>
                <a class="btn btn-secondary" href="/contact/">Request a Free Case Review</a></p>
            </div>

        </article>
    </div>
</section>

<?php get_footer(); ?>
