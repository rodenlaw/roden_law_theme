# Rebuild `/car-accident-lawyers/charleston-sc/` — plan (2026-09-26)

**Decision (owner, 2026-09-26):** bring the Charleston car accident page back as a
South Carolina–only page with an embedded map of the King Street listing. It must not
share a page with Georgia. This reverses one of the 47 retirements in #143 on purpose.

**Why:** Trey Harrell holds #1 in the Maps pack for "charleston car accident attorney"
around West Ashley. Their dedicated page
(`treyhelps.com/charleston-injury/car-accident-lawyer/`: URL, title and H1 all
"Charleston Car Accident Lawyer"; about 3,400 words; office address block, embedded
map, LocalBusiness schema with the Place ID) is their main organic asset for this
query: #8 for "charleston car accident lawyer" and #10 for "charleston car accident
attorney" in Semrush.

Since 2026-09-19 Roden has had nothing for this query. The URL 301s to the two-state
pillar. The full competitor audit is the "Trey Harrell Competitor Audit" artifact.

**Preview:** `data/practice-area-drafts/2026-09/charleston-car-accident-rebuild.html`
(main content only). It was rendered inside the live site's header, footer and CSS,
served on localhost.

## Keep the URL and the post

Restore **post 3624** (a draft since 2026-09-25) at `/car-accident-lawyers/charleston-sc/`.
Do not create a new URL. The old URL keeps its 16 months of history, and **8 legacy
redirects** in `inc/legacy-redirects.php` already point at it:

- `/blog/accidents-near-musc-and-calhoun-street/` and its root twin
- `/blog/charleston-car-crash-facial-injuries/`
- `/blog/highway-road-shoulder-accidents-in-charleston/`
- `/blog/how-to-get-your-charleston-police-accident-report/`
- `/blog/legal-help-shoulder-injuries-after-charleston-car-crash/`
- `/blog/liability-for-backing-up-crashes-in-charleston/`
- `/who-is-at-fault-in-a-charleston-merge-accident/`
- `/practice-areas/charleston/car-accident-lawyers/`

Restoring the page makes all of them resolve in a single hop again.

The template is `templates/template-intersection.php`. It already renders South
Carolina law only (the office's state) and already emits LocalBusiness schema with
`geo`, `hasMap` and the King Street GBP in `sameAs` (`roden_schema_local_business_office`).
No other published page uses this template now, so changes to it are contained.

## What closes the gap to Trey

| Gap | Trey | Rebuilt page |
|---|---|---|
| Query match in URL, title and H1 | Yes | Title and H1 "Charleston Car Accident Lawyers"; the URL already matches |
| Embedded map of the listing | Yes | **New** office section with the King St `map_embed` (CID `0x88fe7bd134041e93:0x2c255a08f0b45377`), address, phone and directions |
| Office address, phone and hours on the ranking page | Yes | Hero NAP block, office section, sidebar NAP card |
| Named Charleston roads | I-26, Glenn McConnell, Ravenel, Savannah Hwy, Rivers | I-26 and the I-526 interchange, I-526, Ravenel and the Crosstown, Savannah Hwy / Sam Rittenberg / Glenn McConnell, Folly Rd, Maybank Hwy, the King/Meeting grid, Coleman Blvd. Each links to the firm's own road guide. Rivers Ave and Ashley Phosphate hand off to the North Charleston office. |
| West Ashley coverage | A dedicated West Ashley page | A West Ashley section on this page, with no new geo URL |
| Local court | No | Charleston County Judicial Center, 100 Broad St |
| Attorney author and reviewer | None | Graeham C. Gillin, SC Bar: byline, definition block and FAQ attribution |
| FAQ | 3 | 6, all South Carolina |
| Case results | About a dozen car-accident cards | 3 firm-wide auto results, labelled firm-wide (the results carry no state tag) |
| Word count | ~3,400 | ~2,000 in the body, plus the template's own blocks |

## Content rules applied (the draft already follows these)

- **Every statute comes from `internal-ai-scripts/law/SC.json`:**
  - § 15-3-530 (3 years)
  - § 15-78-110, -80 and -120 (government claims: 2 years, or 3 with a verified claim; $300k/$600k caps)
  - *Nelson* (recovery at 50% or less)
  - § 38-77-140, -150, -160 and -170 (25/50/25 minimums, UM mandatory, UIM offered, hit-and-run corroboration)
  - § 15-33-135 and § 15-32-530 (punitive damages)
- **No punitive dollar figure.** The floor question (the $500,000 floor versus the 2026 CPI figure of $739,245) is still with Gillin.
- **Two claims from the old version were dropped because the pack does not support them:**
  - "stack UM/UIM coverage across policies". The page now links to `/resources/south-carolina-um-uim-stacking/` instead.
  - "South Carolina does not cap pain and suffering in standard car accident cases".
- **No Charleston crash statistics.** `data/statistics.json` has no Charleston County figure. SCDPS shows 50 Charleston County traffic deaths for 2024, but that is preliminary and unverified here. It can be added only after it goes into the registry with a source and vintage.
- **MUSC wording.** It says "MUSC Health … operates a Level I trauma center" and does not say "only". Confirm this against the SC DHEC trauma-center list before publishing.
- **Firm stats are verbatim** from the writer profile.
- **Phone.** Only the Charleston office line (843) 790-8999 appears, with `tel:+18437908999`.
- **No competitor is named in the copy.**

## Build steps

1. **Template: map section.** In `template-intersection.php`, add an office section after the Key Takeaways box. Use the heading "Visit Our %s Office", `$office['map_embed']` (or the `_roden_map_embed` meta override) inside `.map-embed`, a `.map-nap-bar`, and `$office['directions']`. Also change the hero's "Get Directions" link to an in-page anchor to that section.
2. **Template: sibling grid.** Suppress the "All Locations" section when the page has fewer than 2 published siblings. Every other intersection is retired, so today it would render a single card.
3. **CSS.** Add the office-map styles (they are in the preview) to `assets/css/theme.css`, and bump `Version:` in `style.css` from 1.4.29 to 1.4.30.
4. **i18n.** Add the new msgids to `languages/es_ES.po` and recompile `es_ES.mo` locally (there is no `msgfmt` on WP Engine).
5. **Guardrail.** `roden_guard_practice_permutation_publish` (`inc/content-guardrails.php`
   L253–281) reverts any unpublished → publish `charleston-sc` permutation to draft while
   `RODEN_LOCATION_FREEZE` is on. Add an allowlist of approved office practice pages; do not
   lift the freeze. See `docs/site-architecture/README.md`, P0.
6. **Redirect.** Remove `'/car-accident-lawyers/charleston-sc/'` from `roden_earning_intersection_urls()` (`inc/legacy-redirects.php:1933`). Confirm the nested `/practice-areas/car-accident-lawyers/charleston-sc/` resolves to the page and not the pillar; #143 verified flat and nested separately. The Spanish twin (post 4902, line 1737) stays retired; see below.
7. **Content.** Run a `bin/` script over stdin to write the post:
   - `post_content` from the draft
   - `_roden_faqs` (6 Q&As)
   - `_roden_key_takeaways`
   - `post_excerpt` (it becomes the Article `description`)
   - `_roden_author_attorney` → Gillin
   - `_roden_last_reviewed`
   - status `publish`, and remove `_roden_retired`
   
   Write with `wp_update_post( wp_slash( … ) )` and `update_post_meta` on slashed values.
8. **Title.** The post title becomes "Charleston Car Accident Lawyers". The SEO title is "Charleston Car Accident Lawyer | Roden Law". Confirm which meta key the theme reads for the `<title>` before writing it.
9. **Internal links in.** Link to the page from `/locations/south-carolina/charleston/` and from the car accident pillar's South Carolina section. Then add links from the Charleston road posts it links out to, starting with the West Ashley, Savannah Highway and Folly Road posts.
10. **Guards after deploy:**
   - `bin/check-unslashed-post-writes.php` (static and live JSON-LD)
   - regenerate `content/meta.json`
   - flush both caches (`wp cache flush` and `wp page-cache flush`)
   - check the single-hop 301s for the 8 legacy URLs

## What the old URL's history says (GSC, `sc-domain:rodenlaw.com`)

The post was published 2026-02-27, so it had about 6½ months live. Over that time it
earned 6 clicks on 89,742 impressions at an average position of 20.7. On the 224
"Charleston car/auto accident lawyer/attorney" query variants it had 32,777 impressions
and 0 clicks, at positions 17–24 (Trey sits at #8–10). Weekly, the flat URL:

| Period | Position | What happened |
|---|---|---|
| Mar – early May | (nested URL only) 21–35 | `/practice-areas/car-accident-lawyers/charleston-sc/` was indexed as a second copy and took 29,176 impressions |
| May 5 | — | `78a2414` aligned the sitemap with canonical URLs; the flat URL takes over |
| **Week of Jun 1** | **13.6** | Best week: the only Roden Charleston page ranking for broad "Charleston accident/injury lawyer" queries |
| Jun – Jul | 17–24 | Steady |
| **Aug 6** | 20 → 33 | Only this page fell; sibling intersections were flat. It lost every "charleston personal injury lawyer/attorney" query to `/personal-injury-lawyers/charleston-sc/` (post 5052, published **2026-07-22**), and its own car queries fell 12–15 places. No git deploy that day. |
| **Aug 20** | 35 → 43 | Post 5052 jumped from position 51 to 18 (867 impressions a day) the day after the per-page SC Why Hire copy (#42/#43). The car page fell again. The intersection layer as a whole *improved* (22.0 → 18.7), so this was not the Aug 18–21 spam update. |
| Sep 19 | — | Retired (#143) |

**Diagnosis:** self-inflicted cannibalization, not a penalty and not a template change.
The page ranked best while it was the only Roden Charleston page in the broad query
space. It slid each time the Charleston PI intersection gained. The March–May duplicate
nested URL split its signals the same way.

(The location page's apparent swings, position ~2 → ~22 → ~2, are the local pack. GSC
credits pack impressions to whatever URL the King St GBP links to: the location page with
`utm_campaign` in April, the homepage in June–July, `?ref=gmb_chs` from late August. They
are not organic cannibalization.)

**Guards this adds to the build:**
- **One Charleston page per intent.** Post 5052 (PI × Charleston) stays retired. The
  location page keeps its "personal injury / office" focus and links to this page with
  the anchor "Charleston car accident lawyers". Do not retitle it toward car accidents.
- **One URL.** The nested `/practice-areas/car-accident-lawyers/charleston-sc/` must 301 to the
  flat URL (not to the pillar), with a self-referencing canonical on the flat URL.
  Verify both before and after deploy.
- **Watch for a swap.** For 60 days after launch, check weekly in GSC which Roden URL
  Google shows for "charleston car accident lawyer/attorney". A second URL appearing
  means cannibalization again.

## Page-ratio ceiling

Measured today (`node bin/doorway-ratio-now.mjs`): **171 / 685 = 24.96%**, against a 25%
ceiling. Restoring one geo page makes it 172 / 686 = **25.07%, which fails.** One geo page
has to leave in the same batch.

The candidate trades are near-duplicate pairs, so merging one into the other loses no topic:

- `/blog/what-to-do-after-a-bike-crash-on-charlestons-ravenel-bridge/` and `/blog/a-cyclists-guide-after-a-ravenel-bridge-accident/`
- `/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/` and `/blog/ashley-phosphate-i-26-south-carolinas-deadliest-intersection/`

Pull 16 months of GSC clicks for all four. Merge the lower earner of one pair into its twin (a 301, relink, then draft with `_roden_retired`), following the #68 pattern. That gives 171 / 685 = 24.96% again.

**Spanish twin (post 4902):** restoring it is a second geo page, so it needs a second
trade. Leave it retired until the English page shows movement.

## Sign-off before publish

1. The **legal-accuracy lead** sweeps the draft (post_content, FAQs, key takeaways and excerpt) against `SC.json`.
2. **Graeham C. Gillin** reviews it, since the page states South Carolina law and carries his name. His approval queue already holds the damage-cap rows, so send this with them.
3. Resolve the MUSC wording and the choice of trade page.

## Measurement

- **Baseline:** Local Falcon 9×9 grid, 5-mile radius, keyword "charleston car accident attorney", King St profile (report `0a1e77847644635`, 2026-09-26), plus the three point checks in the audit (West Ashley #14, downtown #2, North Charleston not in the top 20).
- **Re-scan:** the same grid at 4 and 8 weeks after launch. In GSC, watch the URL for "charleston car accident lawyer/attorney" queries.
- **Success:** the page indexes and ranks top 20 organically within 8 weeks, and the King St profile moves up at the West Ashley points.
- **After launch:** a GBP post on the King St profile linking to the page.

## Not in scope

- A separate West Ashley page. It would be a new geo URL.
- Changing the King St GBP's website link.
- Reporting Trey's listings to Google.
