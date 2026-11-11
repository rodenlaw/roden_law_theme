# Site-health remediation, 2026-11-11

Input: `data/site-health/latest.json` (generated 2026-11-04T16:35Z, live mode against
https://rodenlaw.com). **Every check passes**, including `crawl` ("links that 404 or redirect:
0 · false affordances: 0"). The finding handled here was not in the report. It was seen live in
Chrome on 2026-11-10, on `/practice-areas/bicycle-accident-lawyers/`.

Prod drift check before work: all 83 theme `.php`/`.css`/`.js`/`.mo` files matched origin/main.

## Finding class: pillar location matrix, North Charleston card unlinked (FIXED)

"Our {Practice} Offices" (`templates/template-practice-area.php`) shows one card per office.
On the bicycle pillar the North Charleston card had no link. Its `.matrix-url` span printed
`/bicycle-accident-lawyers/north-charleston-sc/` as plain text. That path is a retired city page,
and it 301s to the pillar.

### Root cause

The matrix looked up location pages only by `_roden_office_key`. North Charleston's page
(post 3763, `/locations/south-carolina/north-charleston/`) is an **office hub stored as a
neighbourhood post**. Read-only prod meta:

```
3763 publish /locations/south-carolina/north-charleston/
     _roden_is_neighborhood=1  _roden_parent_office_key=north-charleston  (no _roden_office_key)
```

It renders through `single-location-neighborhood.php`. That template already treats
"neighbourhood whose slug equals its parent office key" as the office hub (resources section,
#256). The matrix had no such rule. Since there was no intersection child for that office, the
card fell through to unlinked and printed the synthesized path.

Two hypotheses from the brief:

- (a) "`_roden_office_key` missing on 3763": **true, but by design.** Neighbourhood posts store
  the office under `_roden_parent_office_key`. The meta box for that post type writes that key, so
  the post is not mis-entered. The bug is in the code, and no data step is needed.
- (b) "`posts_per_page` 10 truncates the list": **not the cause today.** There are exactly 9
  published English location posts (3595-3601, 3763, 3863), all returned. It was latent, though:
  a 10th and 11th English location post would have silently dropped offices. Fixed anyway.

### Blast radius (live HTML of all 47 published pillars, fetched 2026-11-11)

| Set | Pillars | Wrong card(s) |
|---|---|---|
| EN pillars | 23 of 24 | North Charleston unlinked + synthesized `/{pillar}/north-charleston-sc/` printed (all 23 return 301) |
| EN car-accident | 1 | none: it links North Charleston to its intersection (4540) |
| ES pillars | 23 of 23 | Darien **and** North Charleston unlinked, no path printed. See deferred item 1 |

Across the four shared templates:

- `template-practice-area.php` is the only renderer of this card. Fixed.
- `template-intersection.php` has a matrix of *sibling intersections* only. It links no location
  pages and prints no path, and it renders only with 2 or more siblings (car-accident only).
  Not affected.
- `template-subtype.php` has a "See by Location" sidebar that lists intersection children only.
  Not affected.
- `single-location-neighborhood.php` has no office matrix. Not affected. It is the template that
  renders the hub itself.

### Fix

- New `roden_office_location_urls( $lang = null )` in `inc/template-tags.php` maps office key to
  location URL in the locale. It takes `_roden_office_key` posts plus office hubs (neighbourhood
  post whose `roden_strip_es_slug( slug ) === _roden_parent_office_key`). An explicit key wins.
  It reads all published location posts (`posts_per_page -1`), so no cap. Brunswick (3863, parent
  `darien`, slug `brunswick`) is correctly not treated as an office page.
- `template-practice-area.php` uses it. The synthesized `/{pillar}/{office-slug}/` fallback is
  removed entirely: an office with no page in the locale shows its name only. Spanish pillars
  already did this (T-ES12).
- No CSS/JS change (no `Version:` bump). No translated string changed.

### Verification (read-only, against production data)

The matrix section was rendered on prod for every pillar, with main and patched source, in EN
and ES request contexts. Only `wp eval-file -` over stdin was used, with nothing written.

- The main render matched live HTML card for card (every card's link and printed path) on all
  47 pillars, so the harness reproduces production.
- Patched EN: 24/24 pillars have every card linked (before: 1/24). The only diff lines are the
  23 North Charleston cards: unlinked + synthesized path became a link to
  `/locations/south-carolina/north-charleston/` (200) + that path.
- Patched ES: no diff on any of the 23 pillars (expected; see deferred item 1).
- `a11y` (`auditHtml` from vendor/site-health) on all 47 live pages vs the same pages with the
  patched matrix substituted: issues 0 → 0, warnings 0 → 0. Links to the hub across the 47
  pillars: 94 → 117.
- `crawl` cannot see this class. The synthesized path was text, not an `<a>`, so it never counted
  as a redirecting link, and an unlinked `<h3>` is not a false affordance. The report's "0" here
  was true but vacuous. After deploy, the North Charleston hub gains 23 inbound pillar links. The
  target is a served 200 page, so `crawl` stays clean.

Post-merge: `wp cache flush` and `wp page-cache flush` from `~/sites/rodenlawprod`. Then
re-fetch one EN pillar and confirm the North Charleston card links to
`/locations/south-carolina/north-charleston/`. **No prod data step is needed.**

## Deferred

1. **Spanish pillars: Darien and North Charleston cards unlinked (owner, data).** The Spanish
   location twins exist but are `draft`: 4869 `es-darien` (`_roden_office_key=darien`) and 4883
   `es-north-charleston` (`_roden_office_key=north-charleston`). Both carry full content. Once
   published, the matrix links them without a code change: 4869/4883 carry `_roden_office_key`,
   and the helper reads the locale's posts. Linking English office pages from Spanish pillars
   instead would break the site's convention: `template-location.php` skips offices that have
   no Spanish page. Correction (2026-11-11, later): they are drafts on purpose. Both were retired on 2026-09-26 on the owner's word ("retire (but don't delete)") and 301 through `roden_dead_es_hub_urls()` (#160); see `data/facts/remediation-2026-11-11-es-location-drafts.md`. North Charleston was republished 2026-11-11 (RECOVERY-LOG). Publishing is an owner
   decision, and these posts carry legal content, so it needs review first.
2. **`roden_location_matrix()` (inc/template-tags.php) and `templates/parts/location-matrix.php`
   are dead code** that synthesizes the same retired `/{pillar}/{office-slug}/` links: 0 callers
   (grep 2026-11-11). They are harmless while unused, but a trap if someone wires the part in.
   They are left for a separate cleanup PR to keep this one to the finding.
   **Done 2026-11-11 (owner request):** the function, the part file, and the `.location-matrix`
   CSS it alone used (block plus three media-query lines) are removed; style.css 1.4.48 → 1.4.49.
   The `'%s by Location'` msgid is now unused; its `es_ES.po` entry is left in place (harmless).
3. **Checker blind spot.** site-health has no check for visible text that prints an internal
   path which redirects, and none for a card grid where one card of N is unlinked. This class
   was found by eye. It is recorded here as a candidate check for the package. No change was
   made in this PR.
