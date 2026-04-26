# Roden Law — AI-SEO WordPress Theme

Custom WordPress theme for Roden Law (Roden Love LLC), a multi-location personal injury firm in Georgia and South Carolina.

## Theme Overview

This theme implements the complete AI-SEO and Local SEO architecture described in the Roden Law audit report. It includes automatic JSON-LD schema markup, custom post types for all content, and a design system matching the approved template preview.

### Key Features

- **Automatic Schema Markup** — Organization, LegalService, LocalBusiness, Person, FAQPage, Speakable, BreadcrumbList, WebSite, AggregateRating, and Article schemas output automatically based on page context
- **6 Custom Post Types** — Practice Areas, Locations, Attorneys, Case Results, Testimonials, Resources
- **2 Custom Taxonomies** — Practice Category, Location Served (shared across CPTs for content clustering)
- **Multi-Location Architecture** — 5 offices (Savannah, Darien, Charleston, Columbia, Myrtle Beach) with centralized firm data config
- **E-E-A-T Compliance** — Attorney attribution on practice areas and blog posts, credential display, Person schema
- **Jurisdiction-Aware** — Georgia vs South Carolina statute of limitations, comparative fault rules, and court references auto-display per page context
- **Mobile Responsive** — Hamburger nav drawer, stacked layouts, touch-friendly targets

## File Structure

```
roden-law-theme/
├── style.css                          # Theme header (required by WP)
├── functions.php                      # Core: firm data, CPTs, taxonomies, meta boxes, enqueue
├── header.php                         # Top bar + sticky nav + mobile drawer
├── footer.php                         # 4-column footer with offices + mini form
├── front-page.php                     # Homepage
├── single-practice_area.php           # Practice area pillar page
├── single-location.php                # Location/office page
├── single-attorney.php                # Attorney bio page
├── single.php                         # Blog post (with Article schema)
├── index.php                          # Blog listing
├── archive.php                        # Archive handler (all CPTs)
├── page.php                           # Generic page template
├── 404.php                            # Error page
├── inc/
│   ├── schema-helpers.php             # All JSON-LD schema output functions
│   └── template-tags.php              # Reusable display functions (grids, forms, etc)
├── template-parts/
│   └── content-card.php               # Blog post card partial
└── assets/
    ├── css/
    │   └── theme.css                  # Complete design system (1,200+ lines)
    └── js/
        └── theme.js                   # Mobile nav, FAQ accordion, scroll, analytics
```

## Deployment

### Prerequisites

- WordPress 6.0+
- PHP 8.0+
- WP Engine (or any managed WordPress host)
- Gravity Forms or WPForms (for contact forms)
- Google Maps API key (for location page embeds)

### Installation Steps

1. **Backup** the existing theme completely
2. Upload `roden-law-theme/` to `/wp-content/themes/`
3. Activate the theme in Appearance → Themes
4. Go to Settings → Permalinks → click **Save** (flushes rewrite rules for CPTs)
5. Create menus:
   - **Primary** (header nav) — assign to `primary` location
   - **Footer** — assign to `footer` location
   - **Mobile** — assign to `mobile` location
6. Add your logo via Appearance → Customize → Site Identity

### Content Setup

1. **Practice Areas** — Create posts under Practice Areas CPT. Set jurisdiction, sub-types, statute of limitations per state, and assign author attorney
2. **Locations** — Create one post per office. Set the `_roden_office_key` meta to match the key in `roden_firm_data()` (e.g., `savannah`, `charleston`)
3. **Attorneys** — Create posts with title, office, bar admissions, education, awards, and profile URLs
4. **Case Results** — Create posts with amount, type (Settlement/Verdict/Recovery), and description
5. **Blog Posts** — Write posts and link to an attorney via the Author Attorney dropdown for E-E-A-T attribution

### Form Integration

The theme includes fallback HTML forms. To use Gravity Forms or WPForms:

1. Create your contact form in the plugin
2. The sidebar form function (`roden_contact_form_sidebar()` in template-tags.php) checks for Gravity Forms shortcode first, then WPForms, then falls back to HTML

### Schema Validation

After deployment, validate all schema at:

- [Google Rich Results Test](https://search.google.com/test/rich-results)
- [Schema Markup Validator](https://validator.schema.org/)
- Google Search Console → Enhancements tab

## Firm Data Configuration

All office data is centralized in the `roden_firm_data()` function in `functions.php`. Update this single function to change phone numbers, addresses, coordinates, service areas, court names, or statute of limitations info across the entire site.

## Design System

| Token | Value | Usage |
|-------|-------|-------|
| Navy | `#013046` | Primary brand, headings, dark sections |
| Gold | `#FCB415` | CTA buttons, accents, SC state badge |
| Light | `#F8F6F2` | Section backgrounds, sidebar |
| Serif | Merriweather | Headings, stats, legal text |
| Sans | Inter | Body text, nav, UI elements |

## License

Private theme — © 2026 Roden Love LLC. All rights reserved.
