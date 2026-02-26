# CLAUDE.md — Roden Law WordPress Theme

## Project Overview

Building a standalone WordPress theme for **Roden Law (Roden Love LLC)**, a personal injury law firm serving Georgia and South Carolina across 5 office locations. The theme implements an AI-SEO and local SEO strategy that builds topical authority through sophisticated content architecture while targeting geo-specific legal queries.

**Repo:** `roden-law` (standalone WordPress theme)
**Deployment:** WP Engine via GitHub integration (push to `main` → auto-deploy)
**Theme directory name:** `roden-law`
**WordPress version:** 6.x
**PHP version:** 8.1+

---

## Reference Documents (in project root — DO NOT deploy)

These files are project references and should be in `.gitignore`:
- `Roden-Law-AI-SEO-Audit-Report.docx` — Full AI-SEO and local SEO audit
- `roden-practice-area-url-architecture.docx` — Complete 177-page URL architecture
- `roden-law-template-preview.jsx` — React visual preview of all templates (design reference)

---

## Architecture Summary

### Content Types

| Type | Post Type | Count | Purpose |
|------|-----------|-------|---------|
| Practice Areas | `practice_area` | 18 pillars + 90 intersection + 69 sub-type = 177 | Main service pages with topic clusters |
| Locations | `location` | 5 | Office pages with full NAP + schema |
| Attorneys | `attorney` | ~8 | Bio pages with E-E-A-T signals |
| Case Results | `case_result` | ~20+ | Settlement/verdict showcase |
| Testimonials | `testimonial` | ~10+ | Client reviews |
| Resources | `resource` | ~10+ | AI-cited guides, what-to-do, state law pages |

### Taxonomies

| Taxonomy | Slug | Applied To |
|----------|------|-----------|
| Practice Category | `practice_category` | practice_area, case_result, resource |
| Location Served | `location_served` | practice_area, case_result, attorney |

### Three-Tier URL Architecture

```
Pillar:        /practice-areas/car-accident-lawyers/
Intersection:  /car-accident-lawyers/savannah-ga/
Sub-Type:      /car-accident-lawyers/drunk-driver-accident/
```

- **Pillar Pages** (18): Main practice area pages at `/practice-areas/[slug]/`
- **Intersection Pages** (90): Practice area × location combos at `/[slug]/[city-state]/`
- **Sub-Type Pages** (69): Specialized case types at `/[slug]/[sub-type]/`
- **Location Pages** (5): At `/locations/[state]/[city]/`
- **Attorney Pages**: At `/attorneys/[name]/`
- **Resource Pages**: At `/resources/[slug]/`

Intersection and sub-type pages are **child posts** of the pillar `practice_area` post. The template auto-detects page type by checking if the slug matches an office key (intersection) or not (sub-type).

---

## Office Data (5 Locations)

```php
'savannah' => [
    'name'        => 'Roden Law — Savannah',
    'address'     => '333 Commercial Dr.',
    'city'        => 'Savannah',
    'state'       => 'GA',
    'state_full'  => 'Georgia',
    'zip'         => '31406',
    'phone'       => '(912) 303-5850',
    'lat'         => 32.0291,
    'lng'         => -81.0490,
    'court'       => 'Chatham County Superior Court',
    'slug'        => 'savannah-ga',
    'state_slug'  => 'georgia',
    'service_area' => 'Savannah, Pooler, Richmond Hill, Hinesville, Statesboro, Brunswick, and surrounding Southeast Georgia communities.',
],
'darien' => [
    'name'        => 'Roden Law — Darien',
    'address'     => '1108 North Way',
    'city'        => 'Darien',
    'state'       => 'GA',
    'state_full'  => 'Georgia',
    'zip'         => '31305',
    'phone'       => '(912) 303-5850',
    'lat'         => 31.3702,
    'lng'         => -81.4340,
    'court'       => 'McIntosh County Superior Court',
    'slug'        => 'darien-ga',
    'state_slug'  => 'georgia',
    'service_area' => 'Darien, Brunswick, St. Simons Island, Jekyll Island, Waycross, and surrounding Southeast Georgia coastal communities.',
],
'charleston' => [
    'name'        => 'Roden Law — Charleston',
    'address'     => '127 King Street, Suite 200',
    'city'        => 'Charleston',
    'state'       => 'SC',
    'state_full'  => 'South Carolina',
    'zip'         => '29401',
    'phone'       => '(843) 790-8999',
    'lat'         => 32.7876,
    'lng'         => -79.9353,
    'court'       => 'Charleston County Circuit Court',
    'slug'        => 'charleston-sc',
    'state_slug'  => 'south-carolina',
    'service_area' => 'Charleston, North Charleston, Summerville, Mount Pleasant, Goose Creek, and surrounding Lowcountry communities.',
],
'columbia' => [
    'name'        => 'Roden Law — Columbia',
    'address'     => '1545 Sumter St., Suite B',
    'city'        => 'Columbia',
    'state'       => 'SC',
    'state_full'  => 'South Carolina',
    'zip'         => '29201',
    'phone'       => '(803) 219-2816',
    'lat'         => 34.0007,
    'lng'         => -81.0348,
    'court'       => 'Richland County Circuit Court',
    'slug'        => 'columbia-sc',
    'state_slug'  => 'south-carolina',
    'service_area' => 'Columbia, Lexington, Irmo, West Columbia, Cayce, Forest Acres, and surrounding Midlands South Carolina communities.',
],
'myrtle-beach' => [
    'name'        => 'Roden Law — Myrtle Beach',
    'address'     => '631 Bellamy Ave., Suite C-B',
    'city'        => 'Murrells Inlet',
    'state'       => 'SC',
    'state_full'  => 'South Carolina',
    'zip'         => '29576',
    'phone'       => '(843) 612-1980',
    'lat'         => 33.5510,
    'lng'         => -79.0465,
    'court'       => 'Horry County Circuit Court',
    'slug'        => 'myrtle-beach-sc',
    'state_slug'  => 'south-carolina',
    'service_area' => 'Myrtle Beach, Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and surrounding Grand Strand communities.',
],
```

---

## Jurisdiction-Specific Law Data

### Statute of Limitations (Personal Injury)
- **Georgia:** 2 years (O.C.G.A. § 9-3-33)
- **South Carolina:** 3 years (S.C. Code § 15-3-530)

### Comparative Fault
- **Georgia:** Modified comparative fault — recovery if less than 50% at fault (O.C.G.A. § 51-12-33)
- **South Carolina:** Modified comparative fault — recovery if less than 51% at fault

Templates must auto-detect jurisdiction based on office state and display the correct law data. Both GA and SC data should appear on pillar pages; only the relevant state's data on intersection and location pages.

---

## 18 Practice Areas (Pillar Slugs)

1. `car-accident-lawyers`
2. `truck-accident-lawyers`
3. `slip-and-fall-lawyers`
4. `motorcycle-accident-lawyers`
5. `medical-malpractice-lawyers`
6. `wrongful-death-lawyers`
7. `workers-compensation-lawyers`
8. `dog-bite-lawyers`
9. `brain-injury-lawyers`
10. `spinal-cord-injury-lawyers`
11. `maritime-injury-lawyers`
12. `product-liability-lawyers`
13. `boating-accident-lawyers`
14. `burn-injury-lawyers`
15. `construction-accident-lawyers`
16. `nursing-home-abuse-lawyers`
17. `premises-liability-lawyers`
18. `pedestrian-accident-lawyers`

---

## JSON-LD Schema Types (10 total — all output via functions.php)

1. **Organization / LawFirm** — Homepage
2. **LegalService** — Practice area pages + homepage
3. **LocalBusiness** — Location pages + homepage (×5)
4. **Person / Attorney** — Attorney pages + author attribution
5. **FAQPage** — Practice area pages (5-8 Q&As each)
6. **HowTo** — Resource pages (step-by-step guides)
7. **BreadcrumbList** — Sitewide
8. **Speakable** — Homepage + practice area hero sections
9. **AggregateRating** — Homepage (4.9 stars, 500+ reviews)
10. **WebSite** — Homepage (Sitelinks Searchbox)

Schema output is handled by helper functions in `inc/schema-helpers.php` and called via `wp_head` action hooks. No schema plugins required.

---

## Theme File Structure

Files marked [EXISTS] are already present in the project.

```
roden-law/
├── CLAUDE.md                          [EXISTS] This file
├── style.css                          [EXISTS] Theme header + base styles
├── functions.php                      [EXISTS] Core engine
├── front-page.php                     [EXISTS] Homepage template
├── header.php                         [EXISTS] Global header
├── footer.php                         [EXISTS] Global footer
├── index.php                          Fallback template
├── single-practice_area.php           Routes to pillar/intersection/sub-type
├── single-location.php                Location page template
├── single-attorney.php                Attorney bio template
├── single-case_result.php             Case result detail (optional)
├── single-resource.php                Resource page template
├── archive-practice_area.php          Practice areas listing
├── archive-attorney.php               Attorney team page
├── archive-case_result.php            Results showcase
├── single.php                         Blog post template (with author schema)
├── archive.php                        Blog archive
├── page.php                           Generic page
├── 404.php                            404 page
├── searchform.php                     Search form
├── search.php                         Search results
├── screenshot.png                     Theme screenshot
│
├── inc/                               [EXISTS] Includes directory
│   ├── firm-data.php                  Central config: roden_firm_data()
│   ├── custom-post-types.php          CPT + taxonomy registration
│   ├── meta-boxes.php                 All custom meta boxes
│   ├── schema-helpers.php             All JSON-LD schema output functions
│   ├── template-tags.php              Reusable display functions
│   ├── rewrite-rules.php              Custom URL rewrites for intersection/sub-type
│   ├── enqueue.php                    Script and style enqueue
│   ├── nav-menus.php                  Menu registration
│   ├── gravity-forms.php              Gravity Forms integration hooks
│   └── admin-columns.php             Custom admin list columns for CPTs
│
├── templates/                         [EXISTS] Page-specific template parts
│   ├── template-practice-area.php     Practice area pillar template
│   ├── template-location.php          Location page template
│   ├── template-attorney.php          Attorney bio template
│   ├── template-homepage.php          Homepage template
│   ├── template-intersection.php      PA × Location intersection page
│   ├── template-subtype.php           Sub-type specialization page
│   └── parts/                         Reusable template fragments
│       ├── hero-practice-area.php
│       ├── hero-location.php
│       ├── hero-attorney.php
│       ├── location-matrix.php        5-office grid with intersection links
│       ├── faq-accordion.php          FAQ section with FAQPage schema
│       ├── case-results-grid.php      Filterable results grid
│       ├── attorneys-grid.php         Attorney cards with office filtering
│       ├── contact-form-sidebar.php   Sidebar CTA form
│       ├── sidebar-filing-deadlines.php
│       ├── sidebar-related-pas.php
│       ├── sidebar-why-roden.php      Trust signals sidebar
│       ├── inline-cta-banner.php      Mid-content CTA bar
│       ├── comparative-fault.php      GA vs SC fault rules display
│       ├── content-blog-card.php      Blog post card for archives
│       └── author-attribution.php     E-E-A-T author box
│
├── js/                                [EXISTS] JavaScript files
│   ├── main.js                        Frontend JS (FAQ accordion, sticky nav)
│   └── admin.js                       Admin meta box JS (repeater fields)
│
├── assets/                            Static assets
│   ├── css/
│   │   ├── main.css                   Primary stylesheet
│   │   ├── components.css             Reusable component styles
│   │   └── admin.css                  Admin meta box styles
│   └── images/
│       └── (badge SVGs, placeholders)
│
└── .gitignore                         Ignore reference docs, node_modules, etc.
```

**Template routing note:** WordPress uses `single-{post_type}.php` for single CPT views. The `templates/` folder contains reusable template fragments called by those single-* files. The routing pattern:

```php
// single-practice_area.php decides which templates/ file to load:
$page_type = roden_practice_area_type(); // 'pillar', 'intersection', or 'subtype'

switch ( $page_type ) {
    case 'intersection':
        get_template_part( 'templates/template-intersection' );
        break;
    case 'subtype':
        get_template_part( 'templates/template-subtype' );
        break;
    default:
        get_template_part( 'templates/template-practice-area' );
        break;
}
```

---

## E-E-A-T Compliance Rules

1. **Every practice area page MUST have attorney attribution** — "About the Author" section with Person schema, bar admissions, and link to attorney profile
2. **Every blog post MUST have a visible byline** with author schema linking to the attorney's profile page
3. **All statute of limitations references MUST specify the jurisdiction** — never generic "two-year deadline"
4. **All legal citations MUST reference the actual statute** — O.C.G.A. § for Georgia, S.C. Code § for South Carolina
5. **Bar association badges MUST have alt-text** describing the organization and membership
6. **sameAs properties** must link to Avvo, Martindale, Super Lawyers, LinkedIn for each attorney
7. **No page should exist without breadcrumb navigation** — BreadcrumbList schema on every page

---

## Meta Box Fields Reference

### Practice Area (`practice_area`)
- `_roden_jurisdiction` — select: both, georgia, south-carolina
- `_roden_sol_ga` — text (e.g., "2 years (O.C.G.A. § 9-3-33)")
- `_roden_sol_sc` — text (e.g., "3 years (S.C. Code § 15-3-530)")
- `_roden_faqs` — repeater: question, answer pairs (5-8 per page)
- `_roden_author_attorney` — select: attorney post ID for E-E-A-T attribution
- `_roden_office_key` — text: for intersection pages, matches office key (savannah, charleston, etc.)
- `_roden_sub_types` — relationship: linked sub-type child pages

### Location (`location`)
- `_roden_office_key` — text: must match key in firm_data (savannah, darien, charleston, columbia, myrtle-beach)
- `_roden_service_area` — textarea: surrounding cities/neighborhoods
- `_roden_map_embed` — text: Google Maps embed URL or API key
- `_roden_local_content` — wysiwyg: location-specific content about local courts, institutions

### Attorney (`attorney`)
- `_roden_title` — text (e.g., "Founding Partner, CEO")
- `_roden_office_key` — text: primary office
- `_roden_bar_admissions` — repeater: state, year, court
- `_roden_education` — repeater: degree, institution
- `_roden_awards` — repeater: award name, year
- `_roden_avvo_url` — url
- `_roden_linkedin_url` — url
- `_roden_bio` — wysiwyg

### Case Result (`case_result`)
- `_roden_amount` — text (e.g., "$3,000,000")
- `_roden_result_type` — select: settlement, verdict, recovery
- `_roden_description` — textarea
- `_roden_attorney` — select: attorney post ID

---

## Rewrite Rules

The intersection/sub-type URL structure requires custom rewrite rules:

```php
// Intersection: /car-accident-lawyers/savannah-ga/
// Sub-type:     /car-accident-lawyers/drunk-driver-accident/
// Both resolve to: practice_area CPT with parent-child relationship

add_rewrite_rule(
    '^([^/]+)/([^/]+)/?$',
    'index.php?practice_area=$matches[1]/$matches[2]',
    'top'
);
```

The `single-practice_area.php` template detects the page type:
1. If post has no parent → **Pillar page**
2. If post has parent AND `_roden_office_key` matches an office → **Intersection page**
3. If post has parent AND no matching office key → **Sub-type page**

---

## Firm Stats (for schema + display)

- **$250M+** recovered for clients
- **4.9** star average rating
- **500+** client reviews
- **5,000+** cases handled
- **62 years** combined experience
- **5** office locations
- **1-844-RESULTS** toll-free number
- **Contingency fee** — no fees unless we win

---

## Key Attorneys

| Name | Title | Primary Office | Bar |
|------|-------|---------------|-----|
| Eric Roden | Founding Partner, CEO | Savannah, GA | GA, SC |
| Tyler Love | Founding Partner, CTO | Savannah, GA | GA |
| Joshua Dorminy | Partner | Savannah, GA | GA, SC |
| Graeham C. Gillin | Partner, COO | Charleston, SC | SC |
| Kiley Reidy | Associate | Charleston, SC | SC |
| Zach Stohr | Associate | Charleston, SC | SC |
| Ivy S. Montano | Associate | Columbia, SC | SC |

---

## Development Commands

```bash
# Start development
cd ~/Projects/roden-law

# Claude Code
claude

# Git workflow
git add -A
git commit -m "description"
git push origin main  # triggers WP Engine deploy

# Validate schema after changes
# Use: https://search.google.com/test/rich-results
# Use: https://validator.schema.org/
```

---

## Build Order (Follow This Sequence)

When existing files have code, READ them first, then enhance/rebuild as needed. Do not blindly overwrite — check what exists.

### Phase 1 — Foundation (inc/ files)
1. `inc/firm-data.php` — Central config with all office data + helper functions
2. `inc/custom-post-types.php` — 6 CPTs + 2 taxonomies
3. `inc/rewrite-rules.php` — Three-tier URL architecture
4. `inc/meta-boxes.php` — All custom fields for all CPTs
5. `inc/enqueue.php` — Scripts and styles
6. `inc/nav-menus.php` — Menu registration
7. Update `functions.php` to load all inc/ files

### Phase 2 — Schema + Helpers
8. `inc/schema-helpers.php` — All 10 JSON-LD schema types
9. `inc/template-tags.php` — Reusable display functions + page type detection

### Phase 3 — Global Templates
10. `header.php` — Sticky nav, mega menu, mobile nav
11. `footer.php` — 4-column footer with all 5 offices
12. All `templates/parts/` files — Reusable template fragments

### Phase 4 — Page Templates
13. `front-page.php` — Homepage
14. `single-practice_area.php` — Router to pillar/intersection/sub-type
15. `templates/template-practice-area.php` — Pillar layout
16. `templates/template-intersection.php` — PA × Location layout
17. `templates/template-subtype.php` — Sub-type layout
18. `single-location.php` + `templates/template-location.php`
19. `single-attorney.php` + `templates/template-attorney.php`
20. `single.php` — Blog posts with author schema
21. Archive templates

### Phase 5 — Styles + JS
22. `assets/css/main.css`
23. `assets/css/components.css`
24. `js/main.js` — FAQ accordion, sticky nav, mobile menu

---

## Design Tokens

```css
:root {
    --navy: #1B3A6B;
    --orange: #E85C1F;
    --light-bg: #F8F6F2;
    --green: #27AE60;
    --text-dark: #333;
    --text-medium: #555;
    --text-light: #888;
    --border: #e0e0e0;
    --font-heading: 'Georgia', serif;
    --font-body: 'Merriweather Sans', sans-serif;
}
```

---

## Critical Implementation Notes

1. **Standalone theme** — do NOT merge with existing site theme code. This is a clean build.
2. **No page builder dependency** — all layouts are PHP templates with CSS.
3. **No schema plugins** — all JSON-LD is output by our own `inc/schema-helpers.php`.
4. **Gravity Forms integration** — forms are embedded via shortcode; the theme adds wrapper styling and lead tracking hooks.
5. **WP Engine compatibility** — avoid file writes, use transient caching for schema generation, respect WP Engine's object cache.
6. **Flush permalinks** after activating theme (Settings → Permalinks → Save) to register rewrite rules.
7. **SEO plugin compatibility** — designed to work with Rank Math or Yoast; our schema does not conflict because we check for existing schema before output.
8. **Reference docs stay in root** — the .docx and .jsx files are project references. Add them to .gitignore so they don't deploy to WP Engine.
9. **Templates folder convention** — this theme uses `templates/` for page-specific template files and `templates/parts/` for reusable fragments. WordPress `single-{cpt}.php` files in root act as routers that call the appropriate template.
