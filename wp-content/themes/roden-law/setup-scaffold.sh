#!/bin/bash
# Roden Law Theme — Smart Scaffold
# Only creates files/dirs that DON'T already exist. Never overwrites.
# Run from ~/Projects/roden-law/

set -e

echo "🏗️  Roden Law Theme — Adding missing scaffold files..."
echo "   (Existing files will NOT be touched)"
echo ""

created=0
skipped=0

# Helper: create file only if missing
create_if_missing() {
    local filepath="$1"
    local content="$2"
    
    if [ -f "$filepath" ]; then
        echo "  ⏭  SKIP (exists): $filepath"
        ((skipped++))
    else
        mkdir -p "$(dirname "$filepath")"
        echo "$content" > "$filepath"
        echo "  ✅ CREATED: $filepath"
        ((created++))
    fi
}

# ─── Directories ────────────────────────────────────────────────────────────
for dir in inc templates templates/parts assets/css assets/images js; do
    if [ ! -d "$dir" ]; then
        mkdir -p "$dir"
        echo "  📁 CREATED DIR: $dir/"
    fi
done

# ─── .gitignore ─────────────────────────────────────────────────────────────
create_if_missing ".gitignore" "# Reference docs — don't deploy
*.docx
*.jsx
*.png
!screenshot.png

# OS files
.DS_Store
Thumbs.db

# Node (if ever needed)
node_modules/

# IDE
.vscode/
.idea/
*.swp
*.swo"

# ─── index.php (WordPress requires this) ───────────────────────────────────
create_if_missing "index.php" '<?php
/**
 * Fallback template.
 * @package RodenLaw
 */
get_header();
?>
<main id="main" class="roden-main">
    <div class="roden-container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php the_excerpt(); ?>
            </article>
        <?php endwhile; the_posts_navigation(); endif; ?>
    </div>
</main>
<?php get_footer();'

# ─── Root-level single/archive templates ────────────────────────────────────
create_if_missing "single-practice_area.php" '<?php
/**
 * Single Practice Area Router.
 * Detects pillar / intersection / sub-type and loads correct template.
 * @package RodenLaw
 */
get_header();
$page_type = function_exists("roden_practice_area_type") ? roden_practice_area_type() : "pillar";
switch ( $page_type ) {
    case "intersection":
        get_template_part( "templates/template-intersection" );
        break;
    case "subtype":
        get_template_part( "templates/template-subtype" );
        break;
    default:
        get_template_part( "templates/template-practice-area" );
        break;
}
get_footer();'

create_if_missing "single-location.php" '<?php
/** Single Location Page. @package RodenLaw */
get_header();
get_template_part( "templates/template-location" );
get_footer();'

create_if_missing "single-attorney.php" '<?php
/** Single Attorney Page. @package RodenLaw */
get_header();
get_template_part( "templates/template-attorney" );
get_footer();'

create_if_missing "single-case_result.php" '<?php
/** Single Case Result. @package RodenLaw */
get_header();
// TODO: Implement case result detail template
get_footer();'

create_if_missing "single-resource.php" '<?php
/** Single Resource Page. @package RodenLaw */
get_header();
// TODO: Implement resource template
get_footer();'

create_if_missing "single.php" '<?php
/** Blog Post Template — includes author schema for E-E-A-T. @package RodenLaw */
get_header();
// TODO: Implement blog single with author attribution
get_footer();'

create_if_missing "archive-practice_area.php" '<?php
/** Practice Areas Archive. @package RodenLaw */
get_header();
// TODO: Implement practice areas listing
get_footer();'

create_if_missing "archive-attorney.php" '<?php
/** Attorney Team Archive. @package RodenLaw */
get_header();
// TODO: Implement attorney team page
get_footer();'

create_if_missing "archive-case_result.php" '<?php
/** Case Results Archive. @package RodenLaw */
get_header();
// TODO: Implement results showcase
get_footer();'

create_if_missing "archive.php" '<?php
/** Blog Archive. @package RodenLaw */
get_header();
// TODO: Implement blog archive with category filtering
get_footer();'

create_if_missing "page.php" '<?php
/** Generic Page Template. @package RodenLaw */
get_header();
?>
<main id="main" class="roden-main">
    <div class="roden-container">
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php get_footer();'

create_if_missing "404.php" '<?php
/** 404 Page. @package RodenLaw */
get_header();
?>
<main id="main" class="roden-main">
    <div class="roden-container" style="text-align:center;padding:80px 20px;">
        <h1>Page Not Found</h1>
        <p>The page you are looking for does not exist or has been moved.</p>
        <p><a href="<?php echo esc_url( home_url("/") ); ?>">Return to Homepage</a></p>
        <p>Or call us at <a href="tel:+18447378587">1-844-RESULTS</a> for immediate help.</p>
    </div>
</main>
<?php get_footer();'

create_if_missing "sidebar.php" '<?php
/** Default Sidebar. @package RodenLaw */
// TODO: Implement default sidebar
'

create_if_missing "searchform.php" '<?php
/** Search Form. @package RodenLaw */
?>
<form role="search" method="get" class="roden-search-form" action="<?php echo esc_url( home_url("/") ); ?>">
    <label for="s" class="screen-reader-text">Search</label>
    <input type="search" id="s" name="s" placeholder="Search Roden Law..." value="<?php echo get_search_query(); ?>">
    <button type="submit">Search</button>
</form>'

create_if_missing "search.php" '<?php
/** Search Results. @package RodenLaw */
get_header();
?>
<main id="main" class="roden-main">
    <div class="roden-container">
        <h1>Search Results for: <?php echo get_search_query(); ?></h1>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article <?php post_class(); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php the_excerpt(); ?>
            </article>
        <?php endwhile; the_posts_navigation(); else : ?>
            <p>No results found. Try a different search or call <a href="tel:+18447378587">1-844-RESULTS</a>.</p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer();'

# ─── inc/ stubs (only if missing) ──────────────────────────────────────────
create_if_missing "inc/firm-data.php" '<?php
/**
 * Central firm data configuration.
 * Single source of truth for all office data, firm stats, and jurisdiction info.
 * @package RodenLaw
 */
if ( ! defined("ABSPATH") ) exit;
// TODO: Implement roden_firm_data() — see CLAUDE.md for complete data'

create_if_missing "inc/custom-post-types.php" '<?php
/**
 * Custom Post Types and Taxonomies.
 * Registers: practice_area, location, attorney, case_result, testimonial, resource
 * Taxonomies: practice_category, location_served
 * @package RodenLaw
 */
if ( ! defined("ABSPATH") ) exit;
// TODO: Implement CPT and taxonomy registration — see CLAUDE.md'

create_if_missing "inc/rewrite-rules.php" '<?php
/**
 * Custom Rewrite Rules for three-tier URL architecture.
 * @package RodenLaw
 */
if ( ! defined("ABSPATH") ) exit;
// TODO: Implement rewrite rules — see CLAUDE.md'

create_if_missing "inc/meta-boxes.php" '<?php
/**
 * Custom Meta Boxes for all CPTs.
 * Uses native WordPress meta box API — no ACF dependency.
 * @package RodenLaw
 */
if ( ! defined("ABSPATH") ) exit;
// TODO: Implement meta boxes — see CLAUDE.md'

create_if_missing "inc/schema-helpers.php" '<?php
/**
 * JSON-LD Schema Output — all 10 types.
 * Hooked to wp_head. No plugin required.
 * @package RodenLaw
 */
if ( ! defined("ABSPATH") ) exit;
// TODO: Implement schema output — see CLAUDE.md'

create_if_missing "inc/template-tags.php" '<?php
/**
 * Reusable Template Tags and display functions.
 * @package RodenLaw
 */
if ( ! defined("ABSPATH") ) exit;
// TODO: Implement template tags — see CLAUDE.md'

create_if_missing "inc/enqueue.php" '<?php
/**
 * Script and Style Enqueue.
 * @package RodenLaw
 */
if ( ! defined("ABSPATH") ) exit;
// TODO: Implement enqueue — see CLAUDE.md'

create_if_missing "inc/nav-menus.php" '<?php
/**
 * Navigation Menus.
 * @package RodenLaw
 */
if ( ! defined("ABSPATH") ) exit;
function roden_register_menus() {
    register_nav_menus( [
        "primary" => "Primary Navigation",
        "footer"  => "Footer Navigation",
        "mobile"  => "Mobile Navigation",
    ] );
}
add_action( "after_setup_theme", "roden_register_menus" );'

create_if_missing "inc/admin-columns.php" '<?php
/**
 * Custom Admin List Columns for CPTs.
 * @package RodenLaw
 */
if ( ! defined("ABSPATH") ) exit;
// TODO: Implement admin columns'

create_if_missing "inc/gravity-forms.php" '<?php
/**
 * Gravity Forms Integration.
 * @package RodenLaw
 */
if ( ! defined("ABSPATH") ) exit;
// TODO: Implement GF integration'

# ─── templates/ stubs ──────────────────────────────────────────────────────
create_if_missing "templates/template-intersection.php" '<?php
/**
 * Intersection Page Template — Practice Area × Location.
 * Loaded by single-practice_area.php when page type is "intersection".
 * @package RodenLaw
 */
// TODO: Implement intersection template — see CLAUDE.md'

create_if_missing "templates/template-subtype.php" '<?php
/**
 * Sub-Type Page Template — Specialized case types.
 * Loaded by single-practice_area.php when page type is "subtype".
 * @package RodenLaw
 */
// TODO: Implement sub-type template — see CLAUDE.md'

# Template parts
for part in hero-practice-area hero-location hero-attorney \
    location-matrix faq-accordion case-results-grid attorneys-grid \
    contact-form-sidebar sidebar-filing-deadlines sidebar-related-pas \
    sidebar-why-roden inline-cta-banner comparative-fault \
    content-blog-card author-attribution; do
    create_if_missing "templates/parts/${part}.php" "<?php
/**
 * Template Part: ${part}
 * @package RodenLaw
 */
// TODO: Implement — see CLAUDE.md"
done

# ─── Asset stubs ────────────────────────────────────────────────────────────
create_if_missing "assets/css/main.css" '/* Roden Law — Main Stylesheet */
/* TODO: Implement — see CLAUDE.md for design tokens */'

create_if_missing "assets/css/components.css" '/* Roden Law — Component Styles */
/* TODO: Implement */'

create_if_missing "assets/css/admin.css" '/* Roden Law — Admin Styles */
/* TODO: Implement */'

# JS files go in existing js/ folder
create_if_missing "js/main.js" '// Roden Law — Frontend JS
// TODO: Implement FAQ accordion, sticky nav, mobile menu'

create_if_missing "js/admin.js" '// Roden Law — Admin JS
// TODO: Implement repeater fields for meta boxes'

# ─── Summary ────────────────────────────────────────────────────────────────
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  ✅ Created: $created files"
echo "  ⏭  Skipped: $skipped files (already existed)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "📋 Next steps:"
echo "   1. Replace your existing CLAUDE.md with the updated version"
echo "   2. git init (if not already) && git add -A"  
echo "   3. git commit -m 'Add scaffold + updated CLAUDE.md'"
echo "   4. Connect to GitHub and WP Engine"
echo "   5. Open Claude Code: claude"
echo "   6. First prompt: 'Read CLAUDE.md. Then read all existing files"
echo "      in inc/, templates/, and the root PHP files. Assess what exists"
echo "      vs what needs to be built. Give me a status report.'"
echo ""
