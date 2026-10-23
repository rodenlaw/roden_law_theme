# Site-health remediation, 2026-10-23

Follow-up to `remediation-2026-10-22.md` (#247). One finding class, fixed by owner
decision of 2026-10-23, accepting that it changes resource lists on legally reviewed
pages.

| Class | Status | Where |
|---|---|---|
| crawl: resource orphans, generator `roden_related_resources()` | fixed (PR, unmerged) | `inc/template-tags.php` |
| Two-state I-95 guide tagged `ga`, now surfaces on 3 Savannah pages | **owner, decide before merge** | resource meta (DB) |
| Cross-state links in single-resource sidebars | fixed (second PR, unmerged; see below) | `single-resource.php` + function |
| Intersection pillars carry no `practice_category`, so no topical filter | deferred, data | DB taxonomy |
| Cross-state links in the resource "Other Practice Areas" block | fixed (third PR, unmerged; see below) | `single-resource.php` + `roden_related_practice_areas()` |
| Same block repeated "Related Guides" items | fixed (same PR) | same |
| Same block headed "Other Practice Areas" while listing guides | fixed (same PR, separate droppable commit) | `single-resource.php` |
| ES GA resource pages: second box now empty (only one other GA guide in ES) | deferred, content | ES translations |

## Fixed: `roden_related_resources()` filtered a newest-N slice

### Generator

The function fetched the newest `count + 4` resources (`count + 16` with an
`office_key`), date DESC, and only then applied the local boost and the other-office /
other-state drops. An older local guide could never surface once enough newer statewide
guides existed. Same flaw #247 fixed in `templates/template-location.php`.

Fix: query every published resource in the locale (still with the `practice_category`
tax_query and `exclude` when given; `posts_per_page => -1`, `no_found_rows`), run the
unchanged rules in PHP, then cap at `count`. Ordering, the local boost, the
other-office drop, the other-state drop (2026-09-26 W10, 2026-09-28 Columbia W2),
the heading / fallback_heading switch, `exclude` and the locale meta_query are untouched.
No strings, no CSS/JS, no content or DB edits.

### Verification (read-only `wp eval-file -` on prod, 2026-10-23)

The probe loads the `origin/main` and the patched function under renamed prefixes and
calls both with each caller's exact args for every published page of the three
templates. It ran twice: `--url=https://rodenlaw.com/` (EN) and
`--url=https://rodenlaw.com/es/` (ES), each over pages of that locale only.

| Template | Pages | Render the block | Changed |
|---|---|---|---|
| intersection (EN) | 11 | 11 | **11** |
| sub-type (EN) | 118 | 21 | 0 |
| single-resource (EN) | 47 | 47 | 0 |
| single-resource (ES) | 11 | 11 | 0 |
| intersection / sub-type (ES) | 0 | — | — |

- 97 sub-types render no block because their parent pillar has no `practice_category`
  term. The template skips the block in that case, before and after this change.
- No ES intersection or sub-type pages exist: all 23 published ES practice areas are
  pillars. The ES zero reflects the pages that exist; the probe did not miss any.
- Sub-type and single-resource output is identical **by construction**. Without an
  `office_key` no filter applies, so the first `count` of the newest slice equals the
  first `count` of the full set. The probe confirms it for all 79 pages.
- All 11 intersection headings switch from the fallback ("{State} {PA} Resources") to
  "Local {PA} Resources", because each now finds a real local guide.

Before / after on the 11 changed pages:

- 7 Charleston pages (car, truck, motorcycle, wrongful death, medical malpractice,
  workers' comp, and North Charleston car): before, SC moped / golf-cart / helmet /
  liquor-liability guides. After, the Charleston County court claim guide and the North
  Charleston pedestrian, truck and dangerous-roads guides. The North Charleston page gets
  its own 3 guides plus SC moped laws.
- 3 Savannah pages (car, truck, workers' comp): before, GA wrongful-death / UM / car-seat /
  moped. After, I-95 widening (GA-SC border), Bay Street trucks, Port of Savannah truck
  routes, and GA wrongful-death settlement value.
- Columbia car: Broad River Road trucks first, then 3 SC statewide guides.

Reachability through this function (EN): 23 of 47 resources before, **28** after.
Newly linked: bay-street-truck-accidents-savannah-historic-district,
broad-river-road-truck-accidents-columbia, north-charleston-truck-accident-guide,
pedestrian-bicycle-safety-north-charleston, personal-injury-claim-charleston-county-court,
port-of-savannah-truck-routes. Dropped: south-carolina-liquor-liability-2026. It is not
orphaned: 4 published items link it in their bodies (practice areas
drunk-driver-bicycle-accident and golf-cart-dui, and 2 Charleston blog posts). The 19
still unreachable through this function are statewide or two-state guides. The
other-state rule or an uncategorised pillar keeps them out. That is policy, not this
defect.

### Jurisdiction check (AFTER lists)

- **Intersection pages: 0 resources tagged for the other state, 0 tagged `both`.**
- **One substantive exception, new with this change:** `i-95-widening-construction-zone-ga-sc`
  is tagged `_roden_jurisdiction = ga`, but its body covers both states. It cites S.C. Code
  and O.C.G.A. (2 each), gives both limitation periods and covers the SCDOT Jasper County
  project. It now renders first on `/car-accident-lawyers/savannah-ga/`,
  `/truck-accident-lawyers/savannah-ga/` and `/workers-compensation-lawyers/savannah-ga/`.
  Under the W10 rule ("drop … including two-state comparisons") it should not be there.
  The filter is correct. The tag is wrong. **Proposed narrowest fix (owner, DB):** set its
  `_roden_jurisdiction` to `both`, then regenerate `content/meta.json`. The existing
  other-state rule then drops it from every office page, and its Savannah slot goes to
  the next GA guide. No code change.
- Sub-type pages: all 21 that render are `_roden_jurisdiction = both`, so the wider pool
  creates no cross-state exposure there.
- Single-resource sidebars: **pre-existing and unchanged** (output byte-identical before
  and after). 53 EN and 8 ES pairs where a single-state resource lists a guide for the other
  state, e.g. `myrtle-beach-fatal-crashes` (SC) → georgia-moped-laws, georgia-car-seat-laws;
  `georgia-car-accident-settlement-value` (GA) → south-carolina-car-accident-settlement-value.
  These pages never had the state filter. **Proposed fix (not in this PR):** in
  `single-resource.php` pass the resource's own jurisdiction, e.g. `'state' => 'SC'` when
  `_roden_jurisdiction` is sc / south-carolina(-only). In the function, derive
  `$other_state` from that arg when no `office_key` is given, so the existing drop applies
  unchanged. No strings. It changes the 5-item sidebar on the 21 resource pages that list another state's guide today (19 EN, 2 ES; 61 pairs), so it
  needs its own owner decision.

### Not jurisdiction, but for the legal reviewer

None of the 11 intersection pages has a `practice_category`: the pillars carry no term.
The `cat_slug` filter therefore never applies, and before and after alike the lists are
"local" rather than "on-topic". After the change, the Charleston workers' comp page lists
the Charleston County court personal-injury claim guide and truck / pedestrian guides.
SC workers' comp claims go to the Workers' Compensation Commission, not county court. The
page only links the guide and makes no claim, but a reviewer may want the pillars tagged
(DB, `practice_category`). Tagging would also turn the block on for the 97 silent
sub-types.

## Re-run after deploy

Flush both cache layers first, then:

```
node vendor/site-health/site-health.mjs crawl --repo . --base https://rodenlaw.com
```

Expected: no new orphans. The 6 guides above gain a template link. The crawl gate is now
blocking (#249), so a regression would show as a red deploy job.

## Fixed (second PR): single-resource sidebars listed the other state's guides

Owner decision 2026-10-23: fix now.

### Generator

`single-resource.php` calls `roden_related_resources()` with `count`, `cat_slug` and
`exclude` but no `office_key`. The other-state drop only runs when an `office_key` is
given, so resource sidebars never had a state filter. Example: `myrtle-beach-fatal-crashes`
(SC) listed Georgia Moped Laws, Georgia Car Seat Laws, GA UM coverage and GA wrongful death.

### Fix

- New optional arg `jurisdiction_of` (post ID). When there is **no** `office_key`, the
  function reads that post's `_roden_jurisdiction` through the existing normaliser
  `roden_page_jurisdiction_states()`, which covers ga / georgia / georgia-only, the three
  SC spellings, and `both`. If the page is about one state, the function keeps a resource
  only when the resource's own tag, read the same way, names that same single state.
- `single-resource.php` passes `'jurisdiction_of' => $post_id`. Nothing else changes.
- The signal is the **tag on both sides, never the slug**. The office path is different:
  it reads the resource's tag first and falls back to the slug for untagged resources.
  This PR leaves that path and its signal alone. The new branch runs only when the office
  path did not set `$other_state`, and no office caller passes the new arg.
- **`both` resources are kept on single-state pages** (owner decision 2026-10-23, after
  review; the first version of this PR dropped them). A two-state guide covers the page's
  own state too, and a sidebar is navigation, not the page stating law. The office rule
  still drops `both`. Trade-off numbers
  are below.
- Untagged resources are kept and their state is not guessed. There are **0 untagged
  published resources** (58 in total: EN 28 sc, 13 ga, 6 both; ES 9 sc, 2 ga), so this
  rule places nothing today.
- A page tagged `both` or untagged gets no filter. That covers the 6 `both` EN resource
  pages and no untagged ones.
- No strings, no CSS/JS, no content or DB edits. `php -l` is clean on both files.

### Verification (read-only `wp eval-file -` on prod, 2026-10-23)

Prod theme matched `origin/main` on all 93 theme files (md5) before the run. The harness
renders the real templates twice in one process: `origin/main` (template plus function)
and patched (patched `single-resource.php` plus the patched function under a renamed
prefix). For practice areas it renders `single-practice_area.php`, and the
intersection and sub-type includes are routed through the same rename. Each page is
routed with `$wp->main()` on a clone of the global `WP`. EN ran with
`--url=https://rodenlaw.com/`, ES with `--url=https://rodenlaw.com/es/`, each over that
locale's pages. A third render keeps `both` resources, to size the alternative.
get_header() and get_footer() load once per process, so a warm-up render runs first
and the harness compares the body. Neither file calls the function.

| Template | Pages rendered | Sidebar/section changed | Rest of page |
|---|---|---|---|
| single-resource (EN) | 47 | **28** | identical (all 47) |
| single-resource (ES) | 11 | **2** | identical (all 11) |
| intersection (EN) | 11 (all show the block) | 0 | full body byte-identical, 11/11 |
| sub-type (EN) | 118 | 0 | full body byte-identical, 118/118 |

Correction to the brief: 21 sub-types *call* the function, because their parent has a
`practice_category`. None of those categories (atv, bicycle, electric-scooter, golf-cart
accidents) has a resource, so **0 sub-types display the box**, before and after. The
full-body comparison covers all 118 either way.

**Cross-state pairs, read by tag on both sides:** before **78 pairs on 30 pages** (70 on
28 EN, 8 on 2 ES). After: **0**. The earlier count of "61 on 21" read the page tag
literally as `ga`/`sc`. That missed the 10 pages tagged `georgia-only` /
`south-carolina-only`, and it was taken before #251 retagged 4689. The table below uses
the normalised count.

**`both` choice: kept** (owner, 2026-10-23). Re-verified after the change with the same
harness against the committed code: cross-state pairs 0 (EN and ES), 21 `both` slots on 21
single-state EN pages, intersection 11/11 and sub-type 118/118 byte-identical, rest of
every resource page identical, 0 render errors. The I-95 widening guide stays linked from
the 11 truck guides.

Numbers as first measured: today 11 sidebar slots on 11 single-state EN pages hold a `both`
resource, all of them `i-95-widening-construction-zone-ga-sc`. If `both` is dropped
(this PR), that becomes 0. If `both` is kept, it becomes **21 slots on 21 pages**. Freeing
the other-state slots pulls `georgia-vs-south-carolina-workers-compensation` onto the 10
uncategorised state-law guides, and I-95 widening stays on the 11 truck guides. Keeping
`both` would also fill the five SC truck sidebars back to 5 items. With `both` dropped
they show 4. No ES page is affected either way.

**Short or empty sidebars after the fix:**

| Page | Before → after | Note |
|---|---|---|
| `/resources/georgia-car-accident-settlement-value/` | 2 → **0** | The box disappears cleanly: the function returns before any markup, and the rest of the page is identical. The `car-accidents` category has no other GA EN resource. |
| `/resources/south-carolina-car-accident-settlement-value/` | 2 → 1 | Only dangerous-roads-north-charleston remains. |
| `/resources/dangerous-roads-north-charleston/` | 2 → 1 | Only south-carolina-car-accident-settlement-value remains. |
| `/es/resources/georgia-truck-accident-settlement-value/` | 5 → 1 | All 4 dropped items were SC workers' comp / PI guides. Only 2 GA ES resources exist. |
| `/es/resources/georgia-car-accident-settlement-value/` | 5 → 1 | Same. |
| `/es/resources/south-carolina-car-accident-settlement-value/` | 0 → 0 | Already empty before this change (alone in its ES category). |

The short lists come from thin `practice_category` pools, and on ES from having only 2
GA resources. They do not come from the filter being wrong. Widening to uncategorised
same-state guides would be a separate rule, and is not in this PR.

Every changed page, before → after (count; pairs = other-state items before; both = `both`
items before; out; in):

| Page | Tag | Items | Pairs | both | Removed | Added |
|---|---|---|---|---|---|---|
| georgia-wrongful-death-settlement-value | ga | 5 → 5 | 2 | 0 | south-carolina-moped-laws, south-carolina-golf-cart-laws | georgia-helmet-laws, georgia-statute-of-limitations |
| georgia-uninsured-motorist-coverage | ga | 5 → 5 | 2 | 0 | south-carolina-moped-laws, south-carolina-golf-cart-laws | georgia-helmet-laws, georgia-statute-of-limitations |
| georgia-car-seat-laws | ga | 5 → 5 | 2 | 0 | south-carolina-moped-laws, south-carolina-golf-cart-laws | georgia-helmet-laws, georgia-statute-of-limitations |
| south-carolina-moped-laws | sc | 5 → 5 | 4 | 0 | georgia-wrongful-death-settlement-value, georgia-uninsured-motorist-coverage, georgia-car-seat-laws, georgia-moped-laws | south-carolina-helmet-laws, myrtle-beach-fatal-crashes, south-carolina-liquor-liability-2026, south-carolina-wrongful-death-settlement-value |
| georgia-moped-laws | ga | 5 → 5 | 2 | 0 | south-carolina-moped-laws, south-carolina-golf-cart-laws | georgia-helmet-laws, georgia-statute-of-limitations |
| south-carolina-golf-cart-laws | sc | 5 → 5 | 4 | 0 | georgia-wrongful-death-settlement-value, georgia-uninsured-motorist-coverage, georgia-car-seat-laws, georgia-moped-laws | south-carolina-helmet-laws, myrtle-beach-fatal-crashes, south-carolina-liquor-liability-2026, south-carolina-wrongful-death-settlement-value |
| south-carolina-helmet-laws | sc | 5 → 5 | 4 | 0 | georgia-wrongful-death-settlement-value, georgia-uninsured-motorist-coverage, georgia-car-seat-laws, georgia-moped-laws | south-carolina-golf-cart-laws, myrtle-beach-fatal-crashes, south-carolina-liquor-liability-2026, south-carolina-wrongful-death-settlement-value |
| georgia-helmet-laws | ga | 5 → 5 | 1 | 0 | south-carolina-moped-laws | georgia-statute-of-limitations |
| myrtle-beach-fatal-crashes | sc | 5 → 5 | 4 | 0 | georgia-wrongful-death-settlement-value, georgia-uninsured-motorist-coverage, georgia-car-seat-laws, georgia-moped-laws | south-carolina-golf-cart-laws, south-carolina-helmet-laws, south-carolina-liquor-liability-2026, south-carolina-wrongful-death-settlement-value |
| south-carolina-liquor-liability-2026 | sc | 5 → 5 | 4 | 0 | georgia-wrongful-death-settlement-value, georgia-uninsured-motorist-coverage, georgia-car-seat-laws, georgia-moped-laws | south-carolina-golf-cart-laws, south-carolina-helmet-laws, myrtle-beach-fatal-crashes, south-carolina-wrongful-death-settlement-value |
| georgia-statute-of-limitations | ga | 5 → 5 | 1 | 0 | south-carolina-moped-laws | georgia-helmet-laws |
| south-carolina-car-accident-settlement-value | sc | 2 → 1 | 1 | 0 | georgia-car-accident-settlement-value | — |
| georgia-truck-accident-settlement-value | ga | 5 → 5 | 4 | 1 | south-carolina-truck-accident-settlement-value, i-95-widening-construction-zone-ga-sc, blythewood-i-77-truck-accidents, carolina-crossroads-construction-zone-truck-accidents, us-52-truck-train-accidents-goose-creek | i-16-i-95-construction-zone-truck-accidents, bay-street-truck-accidents-savannah-historic-district, port-of-savannah-truck-routes, pooler-warehouse-district-truck-accidents, logging-truck-accidents-us-17-mcintosh-glynn |
| georgia-car-accident-settlement-value | ga | 2 → 0 (box gone) | 2 | 0 | south-carolina-car-accident-settlement-value, dangerous-roads-north-charleston | — |
| south-carolina-truck-accident-settlement-value | sc | 5 → 4 | 1 | 1 | georgia-truck-accident-settlement-value, i-95-widening-construction-zone-ga-sc | broad-river-road-truck-accidents-columbia |
| blythewood-i-77-truck-accidents | sc | 5 → 4 | 1 | 1 | georgia-truck-accident-settlement-value, i-95-widening-construction-zone-ga-sc | broad-river-road-truck-accidents-columbia |
| carolina-crossroads-construction-zone-truck-accidents | sc | 5 → 4 | 1 | 1 | georgia-truck-accident-settlement-value, i-95-widening-construction-zone-ga-sc | broad-river-road-truck-accidents-columbia |
| us-52-truck-train-accidents-goose-creek | sc | 5 → 4 | 1 | 1 | georgia-truck-accident-settlement-value, i-95-widening-construction-zone-ga-sc | broad-river-road-truck-accidents-columbia |
| i-16-i-95-construction-zone-truck-accidents | ga | 5 → 5 | 3 | 1 | south-carolina-truck-accident-settlement-value, i-95-widening-construction-zone-ga-sc, blythewood-i-77-truck-accidents, carolina-crossroads-construction-zone-truck-accidents | bay-street-truck-accidents-savannah-historic-district, port-of-savannah-truck-routes, pooler-warehouse-district-truck-accidents, logging-truck-accidents-us-17-mcintosh-glynn |
| broad-river-road-truck-accidents-columbia | sc | 5 → 4 | 1 | 1 | georgia-truck-accident-settlement-value, i-95-widening-construction-zone-ga-sc | us-52-truck-train-accidents-goose-creek |
| bay-street-truck-accidents-savannah-historic-district | ga | 5 → 5 | 3 | 1 | south-carolina-truck-accident-settlement-value, i-95-widening-construction-zone-ga-sc, blythewood-i-77-truck-accidents, carolina-crossroads-construction-zone-truck-accidents | i-16-i-95-construction-zone-truck-accidents, port-of-savannah-truck-routes, pooler-warehouse-district-truck-accidents, logging-truck-accidents-us-17-mcintosh-glynn |
| logging-truck-accidents-us-17-mcintosh-glynn | ga | 5 → 5 | 3 | 1 | south-carolina-truck-accident-settlement-value, i-95-widening-construction-zone-ga-sc, blythewood-i-77-truck-accidents, carolina-crossroads-construction-zone-truck-accidents | i-16-i-95-construction-zone-truck-accidents, bay-street-truck-accidents-savannah-historic-district, port-of-savannah-truck-routes, pooler-warehouse-district-truck-accidents |
| pooler-warehouse-district-truck-accidents | ga | 5 → 5 | 3 | 1 | south-carolina-truck-accident-settlement-value, i-95-widening-construction-zone-ga-sc, blythewood-i-77-truck-accidents, carolina-crossroads-construction-zone-truck-accidents | i-16-i-95-construction-zone-truck-accidents, bay-street-truck-accidents-savannah-historic-district, port-of-savannah-truck-routes, logging-truck-accidents-us-17-mcintosh-glynn |
| port-of-savannah-truck-routes | ga | 5 → 5 | 3 | 1 | south-carolina-truck-accident-settlement-value, i-95-widening-construction-zone-ga-sc, blythewood-i-77-truck-accidents, carolina-crossroads-construction-zone-truck-accidents | i-16-i-95-construction-zone-truck-accidents, bay-street-truck-accidents-savannah-historic-district, pooler-warehouse-district-truck-accidents, logging-truck-accidents-us-17-mcintosh-glynn |
| personal-injury-claim-charleston-county-court | sc | 5 → 5 | 4 | 0 | georgia-wrongful-death-settlement-value, georgia-uninsured-motorist-coverage, georgia-car-seat-laws, georgia-moped-laws | south-carolina-golf-cart-laws, south-carolina-helmet-laws, myrtle-beach-fatal-crashes, south-carolina-liquor-liability-2026 |
| pedestrian-bicycle-safety-north-charleston | sc | 5 → 5 | 4 | 0 | georgia-wrongful-death-settlement-value, georgia-uninsured-motorist-coverage, georgia-car-seat-laws, georgia-moped-laws | south-carolina-golf-cart-laws, south-carolina-helmet-laws, myrtle-beach-fatal-crashes, south-carolina-liquor-liability-2026 |
| north-charleston-truck-accident-guide | sc | 5 → 5 | 4 | 0 | georgia-wrongful-death-settlement-value, georgia-uninsured-motorist-coverage, georgia-car-seat-laws, georgia-moped-laws | south-carolina-golf-cart-laws, south-carolina-helmet-laws, myrtle-beach-fatal-crashes, south-carolina-liquor-liability-2026 |
| dangerous-roads-north-charleston | sc | 2 → 1 | 1 | 0 | georgia-car-accident-settlement-value | — |
| es/georgia-truck-accident-settlement-value | ga | 5 → 1 | 4 | 0 | south-carolina-workers-comp-impairment-rating-mmi, south-carolina-personal-injury-faq, how-much-does-south-carolina-workers-comp-pay, south-carolina-workers-comp-claim-denied | — |
| es/georgia-car-accident-settlement-value | ga | 5 → 1 | 4 | 0 | south-carolina-workers-comp-impairment-rating-mmi, south-carolina-personal-injury-faq, how-much-does-south-carolina-workers-comp-pay, south-carolina-workers-comp-claim-denied | — |

### Re-run after deploy

**Reachability.** EN resources linked from a resource sidebar or an intersection block go
from 28 to 33. Seven gain a link: logging-truck US-17, I-16/I-95, Pooler warehouse,
GA statute of limitations, GA helmet laws, Myrtle Beach fatal crashes, SC liquor
liability. Two lose their last such link:

- `georgia-car-accident-settlement-value`: only SC car pages listed it. 7 published
  bodies still link it, including the GA car accident page and the Savannah pillar.
- `i-95-widening-construction-zone-ga-sc` (`both` since #251): only single-state truck
  guides listed it. **0 body links.** It stays reachable from the `/resources/` archive
  (page 4), so the crawl should not report it as an orphan. Its only links, though,
  are now archive pagination. If the owner wants it in sidebars, keeping `both` (above)
  restores it on 11 truck guides.

ES reachability is unchanged at 8.

### Re-run after deploy

Flush both cache layers, then run the crawl check (as above). Expected: no new orphans.
Spot-check `/resources/myrtle-beach-fatal-crashes/`: the sidebar should list only SC
guides. `/resources/georgia-car-accident-settlement-value/` should have no Related
Guides box.

## Fixed (third PR): the resource "Other Practice Areas" block listed the other state's guides

Owner decision 2026-10-23: apply the #252 rule to the block below "Related Guides".

### Generator

`single-resource.php` calls `roden_related_practice_areas( 6 )` after "Related Guides". A
resource has no parent, so the function takes its pillar branch: the first 7 resources by
`menu_order`, locale-filtered, sliced to 6, with no jurisdiction filter. Every resource has
`menu_order` 0, so the order was MySQL's tie order under `LIMIT 7`. The result was the same 7
resources on every page (4860, 4861, 5220, 5223, 5348, 5352, 5353), whatever the page's
state. Example: `myrtle-beach-fatal-crashes` (SC) listed `georgia-statute-of-limitations`.
`templates/parts/sidebar-related-pas.php` wraps the function but **has no callers**, and no
other template calls the function.

### Fix

- New optional second argument `$args`, passed only from `single-resource.php`. With no
  `$args`, every line of the old path runs unchanged.
- `jurisdiction_of`: the #252 rule (owner decisions), via the new helper
  `roden_related_pas_state_filter()`. It decides from `_roden_jurisdiction` through
  `roden_page_jurisdiction_states()` on both sides. On a single-state page it drops only
  resources tagged for the other single state. `both` and untagged resources are kept
  (0 published resources are untagged). A `both` or untagged page gets no filter.
- `exclude`: the IDs "Related Guides" rendered. `roden_related_resources()` now returns
  them. Its HTML is unchanged (proved below), and no caller used its return value.
- Over-fetch then cap: `posts_per_page => -1`, filter, then slice to 6.
- Order. The old tie order cannot be reproduced without `LIMIT`, so the scoped path needs
  an explicit one. It uses publication order (`menu_order`, date, ID), starting just after
  the current page and wrapping around, so each page lists the guides published after it.
  This is deterministic and spreads the links across the set. Oldest-first was tried and
  rejected: it put the same 4 North Charleston guides on ~33 pages and took the last
  sidebar link from `georgia-vs-south-carolina-filing-deadlines`.
- Heading (separate commit, droppable): "Related Resources". This is an existing msgid,
  already used in `template-practice-area.php` and translated in `es_ES.po` and `.mo`
  ("Recursos Relacionados"). No msgid was added or changed.
- No CSS/JS, no content or DB edits, no new pages. `php -l` is clean.

### Verification (read-only `wp eval-file -` on prod, 2026-10-23)

All 83 theme php/css/js files on prod matched `origin/main` (fc54696) by md5 before the run.
The harness is the #252 one, adapted. It renders `single-resource.php` on `origin/main` and
on the patch in one process. The patched template calls `roden_related_resources_p` /
`roden_related_practice_areas_p` (the patched code under a renamed prefix) and the new helper.
Each page is routed with `$wp->main()` on a clone of the global `WP`. EN ran with
`--url=https://rodenlaw.com/` and ES with `--url=https://rodenlaw.com/es/`, each covering
every published resource in that locale. Bodies were compared from `<main>` to `</main>`.

| | EN (47 pages) | ES (11 pages) |
|---|---|---|
| Pages whose block changed | 47 | 11 |
| Cross-state items in the block (by tag) | 47 on 41 pages → **0** | 12 on 2 pages → **0** |
| `both` items on single-state pages | 154 → 83 | 0 → 0 |
| Items repeating "Related Guides" | 13 on 13 pages → **0** | 24 on 8 pages → **0** |
| Block sizes after | all 6 | 6 ×1, 3 ×8, **empty ×2** |
| "Related Guides" box | 47/47 identical | 11/11 identical |
| Rest of page | 47/47 byte-identical | 9/11 byte-identical, 2 whitespace-only (the emptied box) |
| Resources with a link from a resource sidebar | 35 → **47 of 47** | 11 → 11 of 11 |

- **Box empties on 2 pages**: `/es/resources/georgia-car-accident-settlement-value/` and
  `/es/resources/georgia-truck-accident-settlement-value/`. ES has only 2 GA resources, and
  each is already in the other's "Related Guides". Before, each listed 6 SC guides.
- No block falls to 1 item. Eight ES SC pages drop from 6 to 3, because 3 of their old 6
  were repeats of "Related Guides".
- **Other callers, byte-identical.** The no-`$args` form, live vs patched, renders identical
  output on all 176 `practice_area` posts (153 EN, 23 ES), with and without the count
  argument. A full render of `single-practice_area.php` (routing the pillar, intersection,
  sub-type and statewide includes) is byte-identical live vs patched on 153/153 EN and 23/23 ES.
  That covers the 49 that render a `roden_related_resources()` block. The pillar sidebar
  "Related Practice Areas" uses `orderby => rand`, so for this comparison it was pinned to
  `ID` on **both** sides; a main-vs-main control differs on 24/24 pillars without the pin
  and on 0 with it.

Every resource page, before → after. "Pairs" counts other-state items before; "Repeats"
counts items before that were also in "Related Guides"; `both` counts items after:

| Page | Tag | Items | Pairs before | Repeats before | `both` after | After |
|---|---|---|---|---|---|---|
| dangerous-roads-north-charleston | sc | 6 → 6 | 1 | 0 | 0 | north-charleston-truck-accident-guide, pedestrian-bicycle-safety-north-charleston, personal-injury-claim-charleston-county-court, broad-river-road-truck-accidents-columbia, us-52-truck-train-accidents-goose-creek, carolina-crossroads-construction-zone-truck-accidents |
| north-charleston-truck-accident-guide | sc | 6 → 6 | 1 | 0 | 0 | pedestrian-bicycle-safety-north-charleston, personal-injury-claim-charleston-county-court, broad-river-road-truck-accidents-columbia, us-52-truck-train-accidents-goose-creek, carolina-crossroads-construction-zone-truck-accidents, blythewood-i-77-truck-accidents |
| pedestrian-bicycle-safety-north-charleston | sc | 6 → 6 | 1 | 0 | 1 | personal-injury-claim-charleston-county-court, broad-river-road-truck-accidents-columbia, us-52-truck-train-accidents-goose-creek, carolina-crossroads-construction-zone-truck-accidents, blythewood-i-77-truck-accidents, i-95-widening-construction-zone-ga-sc |
| personal-injury-claim-charleston-county-court | sc | 6 → 6 | 1 | 0 | 1 | broad-river-road-truck-accidents-columbia, us-52-truck-train-accidents-goose-creek, carolina-crossroads-construction-zone-truck-accidents, blythewood-i-77-truck-accidents, i-95-widening-construction-zone-ga-sc, south-carolina-truck-accident-settlement-value |
| port-of-savannah-truck-routes | ga | 6 → 6 | 1 | 0 | 3 | logging-truck-accidents-us-17-mcintosh-glynn, georgia-car-accident-settlement-value, truck-accident-settlement-process, georgia-statute-of-limitations, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence |
| pooler-warehouse-district-truck-accidents | ga | 6 → 6 | 1 | 0 | 3 | logging-truck-accidents-us-17-mcintosh-glynn, georgia-car-accident-settlement-value, truck-accident-settlement-process, georgia-statute-of-limitations, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence |
| logging-truck-accidents-us-17-mcintosh-glynn | ga | 6 → 6 | 1 | 0 | 4 | georgia-car-accident-settlement-value, truck-accident-settlement-process, georgia-statute-of-limitations, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines |
| bay-street-truck-accidents-savannah-historic-district | ga | 6 → 6 | 1 | 0 | 4 | georgia-car-accident-settlement-value, truck-accident-settlement-process, georgia-statute-of-limitations, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines |
| broad-river-road-truck-accidents-columbia | sc | 6 → 6 | 1 | 0 | 0 | south-carolina-car-accident-settlement-value, south-carolina-statute-of-limitations, south-carolina-comparative-negligence, south-carolina-um-uim-stacking, south-carolina-car-seat-laws, south-carolina-personal-injury-faq |
| i-16-i-95-construction-zone-truck-accidents | ga | 6 → 6 | 1 | 0 | 4 | georgia-car-accident-settlement-value, truck-accident-settlement-process, georgia-statute-of-limitations, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines |
| us-52-truck-train-accidents-goose-creek | sc | 6 → 6 | 1 | 0 | 0 | south-carolina-car-accident-settlement-value, south-carolina-statute-of-limitations, south-carolina-comparative-negligence, south-carolina-um-uim-stacking, south-carolina-car-seat-laws, south-carolina-personal-injury-faq |
| carolina-crossroads-construction-zone-truck-accidents | sc | 6 → 6 | 1 | 0 | 0 | south-carolina-car-accident-settlement-value, south-carolina-statute-of-limitations, south-carolina-comparative-negligence, south-carolina-um-uim-stacking, south-carolina-car-seat-laws, south-carolina-personal-injury-faq |
| blythewood-i-77-truck-accidents | sc | 6 → 6 | 1 | 0 | 0 | south-carolina-car-accident-settlement-value, south-carolina-statute-of-limitations, south-carolina-comparative-negligence, south-carolina-um-uim-stacking, south-carolina-car-seat-laws, south-carolina-personal-injury-faq |
| i-95-widening-construction-zone-ga-sc | both | 6 → 6 | 0 | 0 | 0 | georgia-car-accident-settlement-value, south-carolina-car-accident-settlement-value, south-carolina-statute-of-limitations, south-carolina-comparative-negligence, south-carolina-um-uim-stacking, south-carolina-car-seat-laws |
| south-carolina-truck-accident-settlement-value | sc | 6 → 6 | 1 | 0 | 0 | south-carolina-car-accident-settlement-value, south-carolina-statute-of-limitations, south-carolina-comparative-negligence, south-carolina-um-uim-stacking, south-carolina-car-seat-laws, south-carolina-personal-injury-faq |
| georgia-car-accident-settlement-value | ga | 6 → 6 | 1 | 0 | 4 | georgia-truck-accident-settlement-value, truck-accident-settlement-process, georgia-statute-of-limitations, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines |
| georgia-truck-accident-settlement-value | ga | 6 → 6 | 1 | 0 | 5 | truck-accident-settlement-process, georgia-statute-of-limitations, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines, georgia-vs-south-carolina-workers-compensation |
| south-carolina-car-accident-settlement-value | sc | 6 → 6 | 1 | 0 | 0 | south-carolina-statute-of-limitations, south-carolina-comparative-negligence, south-carolina-um-uim-stacking, south-carolina-car-seat-laws, south-carolina-personal-injury-faq, south-carolina-workers-comp-body-part-values |
| south-carolina-statute-of-limitations | sc | 6 → 6 | 1 | 1 | 0 | south-carolina-comparative-negligence, south-carolina-um-uim-stacking, south-carolina-car-seat-laws, south-carolina-personal-injury-faq, south-carolina-workers-comp-body-part-values, how-much-does-south-carolina-workers-comp-pay |
| south-carolina-comparative-negligence | sc | 6 → 6 | 1 | 1 | 0 | south-carolina-um-uim-stacking, south-carolina-car-seat-laws, south-carolina-personal-injury-faq, south-carolina-workers-comp-body-part-values, how-much-does-south-carolina-workers-comp-pay, south-carolina-workers-comp-impairment-rating-mmi |
| south-carolina-um-uim-stacking | sc | 6 → 6 | 1 | 1 | 1 | south-carolina-car-seat-laws, south-carolina-personal-injury-faq, south-carolina-workers-comp-body-part-values, how-much-does-south-carolina-workers-comp-pay, south-carolina-workers-comp-impairment-rating-mmi, truck-accident-settlement-process |
| south-carolina-car-seat-laws | sc | 6 → 6 | 1 | 1 | 2 | south-carolina-personal-injury-faq, south-carolina-workers-comp-body-part-values, how-much-does-south-carolina-workers-comp-pay, south-carolina-workers-comp-impairment-rating-mmi, truck-accident-settlement-process, i-26-i-95-corridor-report |
| south-carolina-personal-injury-faq | sc | 6 → 6 | 1 | 1 | 3 | south-carolina-workers-comp-body-part-values, how-much-does-south-carolina-workers-comp-pay, south-carolina-workers-comp-impairment-rating-mmi, truck-accident-settlement-process, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence |
| south-carolina-workers-comp-body-part-values | sc | 6 → 6 | 1 | 1 | 4 | how-much-does-south-carolina-workers-comp-pay, south-carolina-workers-comp-impairment-rating-mmi, truck-accident-settlement-process, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines |
| how-much-does-south-carolina-workers-comp-pay | sc | 6 → 6 | 1 | 1 | 5 | south-carolina-workers-comp-impairment-rating-mmi, truck-accident-settlement-process, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines, georgia-vs-south-carolina-workers-compensation |
| south-carolina-workers-comp-impairment-rating-mmi | sc | 6 → 6 | 1 | 1 | 5 | truck-accident-settlement-process, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines, georgia-vs-south-carolina-workers-compensation, south-carolina-liquor-liability-2026 |
| south-carolina-workers-comp-claim-denied | sc | 6 → 6 | 1 | 1 | 5 | truck-accident-settlement-process, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines, georgia-vs-south-carolina-workers-compensation, south-carolina-liquor-liability-2026 |
| south-carolina-motorcycle-accident-settlement-value | sc | 6 → 6 | 1 | 1 | 5 | truck-accident-settlement-process, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines, georgia-vs-south-carolina-workers-compensation, south-carolina-liquor-liability-2026 |
| south-carolina-slip-and-fall-settlement-value | sc | 6 → 6 | 1 | 1 | 5 | truck-accident-settlement-process, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines, georgia-vs-south-carolina-workers-compensation, south-carolina-liquor-liability-2026 |
| south-carolina-premises-liability-settlement-value | sc | 6 → 6 | 1 | 1 | 5 | truck-accident-settlement-process, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines, georgia-vs-south-carolina-workers-compensation, south-carolina-liquor-liability-2026 |
| south-carolina-wrongful-death-settlement-value | sc | 6 → 6 | 1 | 1 | 5 | truck-accident-settlement-process, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines, georgia-vs-south-carolina-workers-compensation, south-carolina-liquor-liability-2026 |
| truck-accident-settlement-process | both | 6 → 6 | 0 | 0 | 0 | georgia-statute-of-limitations, i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines, georgia-vs-south-carolina-workers-compensation, south-carolina-liquor-liability-2026 |
| georgia-statute-of-limitations | ga | 6 → 6 | 2 | 0 | 4 | i-26-i-95-corridor-report, georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines, georgia-vs-south-carolina-workers-compensation, port-of-savannah-truck-routes, pooler-warehouse-district-truck-accidents |
| i-26-i-95-corridor-report | both | 6 → 6 | 0 | 0 | 0 | georgia-vs-south-carolina-comparative-negligence, georgia-vs-south-carolina-filing-deadlines, georgia-vs-south-carolina-workers-compensation, south-carolina-liquor-liability-2026, myrtle-beach-fatal-crashes, georgia-helmet-laws |
| georgia-vs-south-carolina-comparative-negligence | both | 6 → 6 | 0 | 0 | 0 | georgia-vs-south-carolina-filing-deadlines, georgia-vs-south-carolina-workers-compensation, south-carolina-liquor-liability-2026, myrtle-beach-fatal-crashes, georgia-helmet-laws, south-carolina-helmet-laws |
| georgia-vs-south-carolina-filing-deadlines | both | 6 → 6 | 0 | 0 | 0 | georgia-vs-south-carolina-workers-compensation, south-carolina-liquor-liability-2026, myrtle-beach-fatal-crashes, georgia-helmet-laws, south-carolina-helmet-laws, south-carolina-golf-cart-laws |
| georgia-vs-south-carolina-workers-compensation | both | 6 → 6 | 0 | 0 | 0 | south-carolina-liquor-liability-2026, myrtle-beach-fatal-crashes, georgia-helmet-laws, south-carolina-helmet-laws, south-carolina-golf-cart-laws, dangerous-roads-north-charleston |
| south-carolina-liquor-liability-2026 | sc | 6 → 6 | 1 | 0 | 0 | dangerous-roads-north-charleston, north-charleston-truck-accident-guide, pedestrian-bicycle-safety-north-charleston, personal-injury-claim-charleston-county-court, broad-river-road-truck-accidents-columbia, us-52-truck-train-accidents-goose-creek |
| myrtle-beach-fatal-crashes | sc | 6 → 6 | 1 | 0 | 0 | dangerous-roads-north-charleston, north-charleston-truck-accident-guide, pedestrian-bicycle-safety-north-charleston, personal-injury-claim-charleston-county-court, broad-river-road-truck-accidents-columbia, us-52-truck-train-accidents-goose-creek |
| georgia-helmet-laws | ga | 6 → 6 | 2 | 0 | 1 | port-of-savannah-truck-routes, pooler-warehouse-district-truck-accidents, logging-truck-accidents-us-17-mcintosh-glynn, bay-street-truck-accidents-savannah-historic-district, i-16-i-95-construction-zone-truck-accidents, i-95-widening-construction-zone-ga-sc |
| south-carolina-helmet-laws | sc | 6 → 6 | 1 | 0 | 0 | dangerous-roads-north-charleston, north-charleston-truck-accident-guide, pedestrian-bicycle-safety-north-charleston, personal-injury-claim-charleston-county-court, broad-river-road-truck-accidents-columbia, us-52-truck-train-accidents-goose-creek |
| south-carolina-golf-cart-laws | sc | 6 → 6 | 1 | 0 | 0 | dangerous-roads-north-charleston, north-charleston-truck-accident-guide, pedestrian-bicycle-safety-north-charleston, personal-injury-claim-charleston-county-court, broad-river-road-truck-accidents-columbia, us-52-truck-train-accidents-goose-creek |
| georgia-moped-laws | ga | 6 → 6 | 2 | 0 | 1 | port-of-savannah-truck-routes, pooler-warehouse-district-truck-accidents, logging-truck-accidents-us-17-mcintosh-glynn, bay-street-truck-accidents-savannah-historic-district, i-16-i-95-construction-zone-truck-accidents, i-95-widening-construction-zone-ga-sc |
| south-carolina-moped-laws | sc | 6 → 6 | 1 | 0 | 0 | dangerous-roads-north-charleston, north-charleston-truck-accident-guide, pedestrian-bicycle-safety-north-charleston, personal-injury-claim-charleston-county-court, broad-river-road-truck-accidents-columbia, us-52-truck-train-accidents-goose-creek |
| georgia-car-seat-laws | ga | 6 → 6 | 2 | 0 | 1 | port-of-savannah-truck-routes, pooler-warehouse-district-truck-accidents, logging-truck-accidents-us-17-mcintosh-glynn, bay-street-truck-accidents-savannah-historic-district, i-16-i-95-construction-zone-truck-accidents, i-95-widening-construction-zone-ga-sc |
| georgia-uninsured-motorist-coverage | ga | 6 → 6 | 2 | 0 | 1 | port-of-savannah-truck-routes, pooler-warehouse-district-truck-accidents, logging-truck-accidents-us-17-mcintosh-glynn, bay-street-truck-accidents-savannah-historic-district, i-16-i-95-construction-zone-truck-accidents, i-95-widening-construction-zone-ga-sc |
| georgia-wrongful-death-settlement-value | ga | 6 → 6 | 2 | 0 | 1 | port-of-savannah-truck-routes, pooler-warehouse-district-truck-accidents, logging-truck-accidents-us-17-mcintosh-glynn, bay-street-truck-accidents-savannah-historic-district, i-16-i-95-construction-zone-truck-accidents, i-95-widening-construction-zone-ga-sc |

| Page | Tag | Items | Pairs before | Repeats before | `both` after | After |
|---|---|---|---|---|---|---|
| es/south-carolina-statute-of-limitations | sc | 6 → 3 | 0 | 3 | 0 | es-south-carolina-comparative-negligence, es-south-carolina-um-uim-stacking, es-south-carolina-car-accident-settlement-value |
| es/south-carolina-comparative-negligence | sc | 6 → 3 | 0 | 3 | 0 | es-south-carolina-um-uim-stacking, es-south-carolina-car-accident-settlement-value, es-south-carolina-statute-of-limitations |
| es/south-carolina-um-uim-stacking | sc | 6 → 3 | 0 | 3 | 0 | es-south-carolina-car-accident-settlement-value, es-south-carolina-statute-of-limitations, es-south-carolina-comparative-negligence |
| es/south-carolina-car-accident-settlement-value | sc | 6 → 6 | 0 | 0 | 0 | es-how-much-does-south-carolina-workers-comp-pay, es-south-carolina-workers-comp-claim-denied, es-south-carolina-workers-comp-body-part-values, es-south-carolina-workers-comp-impairment-rating-mmi, es-south-carolina-personal-injury-faq, es-south-carolina-statute-of-limitations |
| es/how-much-does-south-carolina-workers-comp-pay | sc | 6 → 3 | 0 | 3 | 0 | es-south-carolina-statute-of-limitations, es-south-carolina-comparative-negligence, es-south-carolina-car-accident-settlement-value |
| es/south-carolina-workers-comp-claim-denied | sc | 6 → 3 | 0 | 3 | 0 | es-south-carolina-statute-of-limitations, es-south-carolina-comparative-negligence, es-south-carolina-car-accident-settlement-value |
| es/south-carolina-workers-comp-body-part-values | sc | 6 → 3 | 0 | 3 | 0 | es-south-carolina-statute-of-limitations, es-south-carolina-comparative-negligence, es-south-carolina-car-accident-settlement-value |
| es/south-carolina-workers-comp-impairment-rating-mmi | sc | 6 → 3 | 0 | 3 | 0 | es-south-carolina-statute-of-limitations, es-south-carolina-comparative-negligence, es-south-carolina-car-accident-settlement-value |
| es/south-carolina-personal-injury-faq | sc | 6 → 3 | 0 | 3 | 0 | es-south-carolina-statute-of-limitations, es-south-carolina-comparative-negligence, es-south-carolina-car-accident-settlement-value |
| es/georgia-car-accident-settlement-value | ga | 6 → 0 | 6 | 0 | 0 | — (box gone) |
| es/georgia-truck-accident-settlement-value | ga | 6 → 0 | 6 | 0 | 0 | — (box gone) |

### Owner items

- **Heading**: "Related Resources" sits directly under "Related Guides". If the owner prefers
  a new wording (e.g. "More Guides"), that is a new msgid with an `es_ES.po` entry and a
  local `.mo` recompile. Dropping the second commit restores "Other Practice Areas".
- **ES GA resources**: the second box is gone on both. Only a new ES GA translation fills it.
- **Order**: the wrap-around publication order is my choice; the old order had no intent
  behind it. It is a one-line change if the owner wants another.

### Re-run after deploy

Flush both cache layers. Then run the crawl check
(`node vendor/site-health/site-health.mjs crawl --repo . --base https://rodenlaw.com`).
Expected: no new orphans; EN resources linked from resource sidebars go 35 → 47. Spot-check
`/resources/myrtle-beach-fatal-crashes/`: the second box is headed "Related Resources" and
lists six SC guides, none of them in "Related Guides".

## Fixed (fourth PR): salvage of `backup/floor-cull-followups-2026-10-22`

Owner decision 2026-10-23: salvage the unpushed work from the 2026-10-22 session into one
PR. The backup branch stays on origin (tip 44d0daf).

| Backup commit | Decision | Why |
|---|---|---|
| 5c9a7fc, Coleman `/blog/` alias | **dropped** | Same entry #247 already merged |
| fec0b53, 404 slug guess replayed against the removal map | **kept as is** (cherry-picked, applies cleanly) | Not on main |
| 44d0daf, office resources | **partly kept**, rewritten on top of #247 | See below |

| Class | Status | Where |
|---|---|---|
| redirects: retired posts' truncated and cross-section aliases 404 (the fourth alias form) | fixed (PR, unmerged) | `roden_removed_slug_guess_key()`, `inc/legacy-redirects.php` |
| crawl: Charleston office page listed North Charleston's guides; NC hub had no resources section | fixed (same PR) | `roden_office_local_resources()` + `_section()`, `inc/template-tags.php` |
| 2-hop chains `/blog/privacy-policy-2/` and `/blog/savannah/` (synthetic) | deferred, pre-existing, unchanged by this PR | legacy map |
| 18 `/blog/` forms of legacy-map root keys still 404 (`/blog/contact-us/`, ...) | deferred, no request evidence (none in the fixture) | legacy map |

### Redirects: the 404 slug guess

Generator: core's `redirect_guess_404_permalink()` only matches **published** posts by
prefix. A truncated or cross-section address (`/blog/{resource-slug}/`,
`/blog/i-526-truck-accidents-charleston/`) reached its post only that way. Retiring the
post (a draft) killed the address, while the canonical form kept its 301.
`roden_removed_slug_guess_key()` runs the same match over the removal-map keys. It runs
last, on a 404 only, and only after core's own guess has found nothing. It honours core's
filters, so `/es/` stays guess-free. When the prefix matches retired posts with different
destinations it does nothing.

Read-only prod replay, run 2026-10-23. It drives the real `template_redirect` pipeline,
with only `inc/legacy-redirects.php`'s own functions swapped (main vs patched), and follows
each hop. The main run matched live first hops on 99/99 sampled paths (curl, 24 retried
after WPE 429s).

| Path set | Paths | Changed | Change type |
|---|---|---|---|
| `redirects.csv` fixture | 997 | 0 | — |
| Sitemap EN | 594 | 0 | 0 redirect before or after |
| Sitemap ES | 56 | 0 | 0 redirect before or after |
| Alias candidates for the 41 floor-cull posts | 178 | 23 | 404 → one 301 → 200 |
| `/blog/` forms of root keys with no `/blog/` key | 33 | 6 | 404 → one 301 → 200 |
| Synthetic prefix truncations of the 41 cull slugs (`/blog/`, `/resources/`), not in any set above | 441 | 297 | 404 → one 301 → 200 |
| **All /es/ paths** (included above) | 99 | **0** | — |
| **Total unique** | 2,276 | 326 | |

All 326 changes are 404 → a single 301 → 200. All 12 distinct destinations return 200
live. The 6 root-key `/blog/` forms are the Florence, Greenville and Spartanburg
car/workers'-comp keys, which are in the removal map. The 18 `/blog/` forms flagged in #247
(`/blog/contact-us/`, `/blog/who-we-are/`, ...) are keys of the **legacy** map, which the
guess does not read, so they still 404, the same as on main. Pre-existing 2-hop chains,
identical on main and patched: `/blog/privacy-policy-2/` → `/privacy-policy-2/` →
`/privacy-policy/`, and `/blog/savannah/` (synthetic) → `/savannah/` → `/practice-areas/`.
48 fixture `case-result` rows read as loops in the harness only, because they redirect to
a `#fragment` that the in-process follower re-requests. Live, each is one hop to
`/case-results/`, and the rows are identical on both sides.

site-health `redirects`, live, before this PR: `997 legacy URLs · ok: 997 · chains: 0 · lost: 0`.
Expected after: unchanged (the fixture rows do not change in the replay).

### Office pages: longest-match assignment and the North Charleston hub

Reconciled with #247 (aebe0d3). #247 made template-location.php filter every locale
resource first, then cap at 6, and render local matches only. Kept from 44d0daf:

- **Longest match.** Each resource belongs to the one office whose city or market is the
  longest match in its slug. `north-charleston-truck-accident-guide` contains "charleston",
  but it is North Charleston's guide.
- **North Charleston hub.** `/locations/south-carolina/north-charleston/` is a full office
  that renders through `single-location-neighborhood.php`, and that template had no
  resources section. It now prints the same section, on an office hub only (slug equals
  its own office key; Brunswick is excluded). The section is the last one and unshaded,
  so the alt/plain banding still alternates. 44d0daf had it shaded and after "Dangerous
  Roads", which would have put two shaded sections side by side.
- The markup moves into `roden_office_local_resources_section()`, shared by both templates.
  It is byte-identical to #247's (same md5 on Savannah, Columbia and Myrtle Beach).

**Disagreement resolved for #247:** 44d0daf padded the list with the state's single-state
guides. #247 deliberately renders local matches only, and I found no evidence for the fill,
so it is dropped.

Read-only prod render, main vs patched templates, every location post in both locales:

| Page | Main | Patched |
|---|---|---|
| Charleston | 4 (county court + 3 North Charleston guides) | 1 (`personal-injury-claim-charleston-county-court`) |
| North Charleston hub | no section | 3 (`pedestrian-bicycle-safety-north-charleston`, `north-charleston-truck-accident-guide`, `dangerous-roads-north-charleston`) |
| Savannah | 2 | 2, section byte-identical |
| Columbia | 1 | 1, section byte-identical |
| Myrtle Beach | 1 | 1, section byte-identical |
| Darien, Brunswick | none | none |
| /es/ Savannah, Charleston, Columbia, Myrtle Beach | none | none |

- Other-state guides on any office page: **0** (normalised via `roden_page_jurisdiction_states()`).
- Rest of every page: identical except for HTML comments and whitespace.
- No resource loses its last office-page link: the three North Charleston guides move from
  the Charleston page to the North Charleston hub.
- site-health `crawl`, live, before this PR: `650/650 · not 200: 0 · orphans: 0 ·
  unreachable from /: 0`. Expected after: unchanged.

### Related-resources rules (#250, #252, #253) and city pages (5b4f123)

Unchanged by construction. The `template-tags.php` diff only adds lines (+115/−0, 2 new
functions, not hooked). All 73 existing functions are byte-identical to `origin/main`,
including `roden_related_resources()`, `roden_related_practice_areas()` and
`roden_related_pas_state_filter()`. Their callers (`single-resource.php`,
`template-intersection.php`, `template-subtype.php`) are untouched, so 5b4f123's
template-intersection.php is untouched too. The redirect change runs only on a 404, and 0
sitemap URLs change. No CSS/JS, no new msgids (both strings already in `es_ES.po`), no
content or DB edits, no new URLs: the doorway ratio and floor are unchanged. `php -l` is
clean on all 4 files. Prod matched `origin/main` on all 93 theme files by md5 before the run.

### Re-run after deploy

Flush both cache layers, then run
`node vendor/site-health/site-health.mjs redirects crawl --repo . --base https://rodenlaw.com --live`.
Expected: redirects 997 ok / 0 chains / 0 lost; crawl 0 orphans. Spot-check
`curl -sI https://rodenlaw.com/blog/i-526-truck-accidents-charleston/`: one 301 to
`/truck-accident-lawyers/charleston-sc/`. `/locations/south-carolina/north-charleston/`
should list its three guides.

## Fixed (fifth PR): `/blog/` forms of root-level legacy keys, and three 2-hop chains

Owner decision 2026-10-23: fix the `/blog/` forms of old root-level legacy-map keys that
404, and fold in the `/blog/privacy-policy-2/` chain deferred above.

### The list (regenerated from code against prod, 2026-10-23)

`roden_get_legacy_redirect_map()` has 44 root-level keys. 25 have no `/blog/` key in either
map. Their `/blog/` forms on prod (replay matches live curl):

| `/blog/` form | Main | Patched |
|---|---|---|
| `/blog/truck-accident-lawyers-columbia-sc/` | 404 | 301 `/practice-areas/truck-accident-lawyers/` |
| `/blog/truck-accident-lawyers-near-me/` | 404 | 301 `/practice-areas/truck-accident-lawyers/` |
| `/blog/south-carolina-rear-end-accident-lawyer/` | 404 | 301 `/car-accident-lawyers/rear-end-collision/` |
| `/blog/free-case-review/` | 404 | 301 `/contact/` |
| `/blog/who-is-at-fault-in-a-charleston-merge-accident/` | 404 | 301 `/car-accident-lawyers/charleston-sc/` |
| `/blog/thank-you-ppc-2/` | 404 | 301 `/` |
| `/blog/who-we-are/` | 404 | 301 `/about/` |
| `/blog/contact-us/` | 404 | 301 `/contact/` |
| `/blog/truck-accident-lawyer-2/` | 404 | 301 `/practice-areas/truck-accident-lawyers/` |
| `/blog/columbia-car-accident-lawyers/` | 404 | 301 `/car-accident-lawyers/columbia-sc/` |
| `/blog/areas-we-serve/` | 404 | 301 `/locations/` |
| `/blog/can-a-car-accident-lawyer-help-with-claiming-insurance-benefits/` | 404 | 301 `/blog/are-accident-lawyers-worth-it/` |
| `/blog/terms-privacy-policy/` | 404 | 301 `/privacy-policy/` |
| `/blog/results/` | 404 | 301 `/case-results/` |
| `/blog/should-i-worry-if-i-have-stomach-pain-after-a-car-accident-in-charleston/` | 404 | 301 `/practice-areas/car-accident-lawyers/` |
| `/blog/car-crash-crush-injuries-in-charleston/` | 404 | 404, unchanged (see below) |
| `/blog/a-charleston-residents-guide-to-tourist-car-accidents/` | 404 | 404, unchanged (see below) |

The other 8 already resolve on main and are unchanged: six `/blog/{pillar}-lawyers/` forms
(one 301 to the pillar), `/blog/your-guide-to-justice-after-a-charleston-truck-accident/`
(a live post, 200) and `/blog/a-guide-to-car-accident-claims-at-columbias-toughest-intersections/`
(core's old-slug redirect, one 301 to `/blog/columbia-dangerous-intersections-roads/`).

So 17 `/blog/` forms 404 on prod, not 18. The earlier figure of 18 does not reproduce: the
pre-#256 replay output gives the same 17. 15 are fixed. 2 are deliberately left alone.

### Approach: a narrow generic rule, not explicit entries

`roden_blog_form_legacy_dest()` runs last in `roden_legacy_content_redirects()`. When a request
is `/blog/{x}/`, 404s, and `/{x}/` is a legacy-map key, it 301s to that key's destination
through the same funnel (`roden_redirect_dest_or_fallback()`).

Why not explicit entries: 19 root keys already have a hand-written `/blog/` twin, and 8 of
those twins now land somewhere other than their root key (final destination, replayed). For example
`/how-can-an-attorney-help-with-my-car-accident-claim/` goes to
`/are-accident-lawyers-worth-it/`, while its `/blog/` twin goes to
`/blog/benefits-of-hiring-personal-injury-lawyer/`. A twin is a copy of a decision, and
copies drift. The rule follows the root key, so re-pointing a key moves both forms. A key
added later gets its `/blog/` form with no extra entry. Existing twins still win, because the
exact-match lookup runs first.

How it stays narrow:
- It runs only on a 404, after the removal map (priority 0) and after every pattern rule.
- It matches only a single segment under `/blog/`, so `/es/` and nested paths never match.
- Core's old-slug redirect wins.
- Core's 404 slug guess wins when it finds a published post, unless that post's own address
  is the key itself (following it would be a 2-hop chain to the same place).
- 410 entries are not extended to their `/blog/` form.
- A key whose destination is this same `/blog/` URL is left alone, so it cannot loop. These
  are the two unchanged rows above.

### Chains fixed at their generator

- **`/blog/privacy-policy-2/`** went `/privacy-policy-2/` → `/privacy-policy/`. Generator: core's
  404 guess found the still-published page 3602, and the removal map 301'd that page.
  `roden_removed_slug_guess_key()` now checks core's guess first. If the guessed address is
  itself a removal key, it returns that key, so the request takes one hop to the same final
  destination.
- **`/should-i-worry-if-i-have-stomach-pain-after-a-car-accident-in-charleston/`** went to
  `/blog/stomach-pain-…/`, which is itself a legacy key, then on to the pillar. The funnel
  followed the removal map but not the legacy map. It now follows the legacy map too. The
  loop is bounded and never follows into a 410. Today this is the only destination in either
  map that is also a legacy key.
- **`/a-guide-to-car-accident-claims-at-columbias-toughest-intersections/`** went to its old
  `/blog/` address, then through core's old-slug redirect. For a `/blog/{slug}/` destination
  that is not a published post, the funnel now uses a published post whose `_wp_old_slug` is
  `{slug}`, as core would.

The replay found the last two. Neither was in the brief, and neither is in the fixture.

### Verification

Read-only replay on prod through the real `template_redirect` pipeline, main vs patched,
following every hop. Fragments are stripped before re-requesting. Prod matched `origin/main`
on every theme file by md5 before the run. Sample checked against live curl: all match.

| Set | Paths | Changed |
|---|---|---|
| `redirects.csv` fixture | 997 | 0 |
| Sitemap URLs, EN + ES | 594 + 56 | 0 (0 redirect, main or patched) |
| `/blog/` forms of every legacy + removal key | 700 | 16 |
| Legacy-map keys themselves (excl. the one 410) | 267 | 2 |
| Removal-map keys themselves | 601 | 0 |
| Cull alias candidates | 178 | 0 |
| #256 truncation set | 565 | 0 |
| Every `/es/` path (incl. 43 `/es/blog/` forms) | 212 | 0 |

All 18 changes are either 404 → one 301 → 200 (15) or 2-hop → one 301 → 200 (3). No existing
200 changed. No existing single-hop redirect changed destination. The final destination
is unchanged for all 3 chains. Paths that were chains or lost, across all sets: main 7,
patched 4.

site-health `redirects`, live, before this PR (2026-10-23T19:13Z):
`997 legacy URLs · ok: 997 · chains: 0 · lost: 0`. Expected after: unchanged, since no
fixture row changes.

### Deferred / owner

| Item | Status | Why |
|---|---|---|
| `/car-crash-crush-injuries-in-charleston/` → `/blog/car-crash-crush-injuries-in-charleston/` → 404 | deferred, owner | The `/blog/` URL was left 404 on purpose (Category 19 note: no comparable page). The root key still 301s into it. Options: point the root key at nothing (410), or leave it until the page is written. |
| `/a-charleston-residents-guide-to-tourist-car-accidents/` → `/blog/…/` → 404 | deferred, owner | No post by that slug exists in any status, and there is no old-slug record. Its `-2`/`-4` twins go to `/practice-areas/car-accident-lawyers/`. Pick a destination or 410. |
| 8 root keys whose `/blog/` twin lands elsewhere (e.g. root → `/blog/are-accident-lawyers-worth-it/`, twin → `/blog/benefits-of-hiring-personal-injury-lawyer/`) | deferred, owner | Pre-existing, unchanged by this PR. Two decisions for one old URL. If they should agree, delete the twin (the generic rule then takes over) or re-point the root key. |
| `/blog/savannah/`, `/blog/practice-areas/brunswick/` 2-hop | deferred, synthetic | Core's guess lands on a published page that `roden_old_page_redirects()` (functions.php) redirects. No request evidence. |

### Re-run after deploy

Run `node vendor/site-health/site-health.mjs redirects --repo . --base https://rodenlaw.com --live`.
Expected: 997 ok / 0 chains / 0 lost. Spot-check `curl -sIL https://rodenlaw.com/blog/contact-us/`
and `/blog/privacy-policy-2/`: each should be one 301 to `/contact/` and `/privacy-policy/`.

## Prepared (sixth PR, not applied): pillar `practice_category` terms

Owner decision 2026-10-23, following the #250 finding: give the practice-area pillars a
`practice_category` term. Intersections and sub-types read their resource topic from the
parent pillar's term. No main pillar had one, so `cat_slug` was `''` on all 11
intersections (they listed local but off-topic guides: the Charleston workers' comp page
listed the Charleston County court PI-claim guide), and the 97 sub-types under untermed
pillars never called the resources block. **Status: prepared and simulated, not written.**
The board strategist applies the change after review.

### Mapping (existing terms only)

Inventory read from prod 2026-10-23. 24 EN + 23 ES top-level pillars, 24 terms, no new
terms. Every pillar except personal injury has a term of the same name. The terms were
created for this purpose and are already on the pillars' children (125 published
practice_area posts).

| Pillar (EN id / ES id) | Term | Before (EN / ES) |
|---|---|---|
| atv-side-by-side-accident-lawyers (4089 / 4900) | atv-accidents | has it / has it |
| bicycle-accident-lawyers (4087 / 4898) | bicycle-accidents | has it / has it |
| boating-accident-lawyers (3616 / 4895) | boating-accidents | none / none |
| brain-injury-lawyers (3612 / 4890) | brain-injuries | none / none |
| burn-injury-lawyers (3617 / 4896) | burn-injuries | none / none |
| car-accident-lawyers (3604 / 4873) | car-accidents | none / none |
| construction-accident-lawyers (3618 / 4876) | construction-accidents | none / none |
| dog-bite-lawyers (3611 / 4880) | dog-bites | none / none |
| e-bike-accident-lawyers (4578 / no ES) | e-bike-accidents | has it / n/a |
| electric-scooter-accident-lawyers (4088 / 4899) | electric-scooter-accidents | has it / has it |
| golf-cart-accident-lawyers (4090 / 4901) | golf-cart-accidents | has it / has it |
| maritime-injury-lawyers (3614 / 4894) | maritime-injuries | none / none |
| medical-malpractice-lawyers (3608 / 4881) | medical-malpractice | none / none |
| motorcycle-accident-lawyers (3607 / 4877) | motorcycle-accidents | none / none |
| nursing-home-abuse-lawyers (3619 / 4897) | nursing-home-abuse | none / none |
| pedestrian-accident-lawyers (3621 / 4878) | pedestrian-accidents | none / none |
| premises-liability-lawyers (3620 / 4893) | premises-liability | none / none |
| product-liability-lawyers (3615 / 4892) | product-liability | none / none |
| slip-and-fall-lawyers (3606 / 4879) | slip-and-fall | none / none |
| spinal-cord-injury-lawyers (3613 / 4891) | spinal-cord-injuries | none / none |
| truck-accident-lawyers (3605 / 4874) | truck-accidents | none / none |
| workers-compensation-lawyers (3610 / 4875) | workers-compensation | none / none |
| wrongful-death-lawyers (3609 / 4882) | wrongful-death | none / none |
| **personal-injury-lawyers (4692 / 5200)** | **none fits: flagged, not mapped** | none / none |

36 to set (18 EN + 18 ES); 9 already carry the term. Spanish pillars take their English
twin's term because that is how the site already does it: Spanish resources carry the same
slugs (`car-accidents` on 1, `south-carolina-law` on 8), and the 4 Spanish pillars that
already had a term carry their twin's. Spanish pillars have no children, so ES only affects
the 18 ES pillar pages.

Resources per term (published): `car-accidents` 3 EN + 1 ES; `truck-accidents` 12 EN;
`south-carolina-law` 13 EN + 8 ES (a jurisdiction tag, not a practice term). No other term
has a resource. 21 published resources have no term. No case result has any term.
Map: `docs/practice-category/pillar-map-2026-10-23.json`.

### What the raw term assignment would have broken (simulation, current code)

Read-only harness on prod. It filters `get_object_terms` so the mapped pillars appear to
carry their term, pins `ORDER BY RAND()` (the pillar "Related Practice Areas" widget), and
renders every page three times: live, simulated, and live again as a control. 0 control
diffs on 289 rendered pages (265 pages plus 24 term archives; the archives' SQL main
query cannot be filtered, so they are covered separately below). Assigning the terms with today's code would have made three changes
nobody asked for:

1. **Case results → hardcoded fallback cards.** `roden_case_results_grid()` filters by
   `practice_category`, and no case result has one. The grid matched nothing and fell back
   to the 4 hardcoded, unlinked cards. All 11 intersections and 16 more EN + 18 ES pillars
   would have switched. The 5 EN + 4 ES pillars that already have a term show this today.
2. **Pillar "Related Resources" (blog) block removed.** It filtered posts by
   `practice_category`, but posts are not in that taxonomy. 18 EN + 18 ES pillars would
   lose 5–6 blog links each. Again, the 9 termed pillars already show no block.
3. **Pillar "Related Guides" box removed** on every pillar whose category has no resource
   (16 EN, 17 ES).

### Code in this PR (separate commits)

- `roden_case_results_grid()`: if the `practice_category` clause matches nothing, drop that
  clause and keep the rest of the query.
- `template-practice-area.php`: the blog block uses the blog-category map only. The guides
  box keeps the category filter but falls back to the newest guides when the category has
  none in this locale.
- `template-subtype.php`: passes `jurisdiction_of` (the #252 rule). See the jurisdiction
  section below.

`bin/assign-pillar-practice-category.php` checks for all four markers in the live theme and
refuses `apply` until they are deployed.

### Simulation with the PR code (live vs patched code + terms)

Pages compared byte-for-byte (`<main>` body and the `roden_output_schema()` JSON-LD). Every
changed link sits inside a resource, blog or case-result block (0 non-block link changes).

| Template | Pages | Changed by code alone | Changed by code + terms | Schema changed |
|---|---|---|---|---|
| Pillar EN | 24 | 5 (already-termed: blog block, guides box, real case results return) | 7 (those 5 + car, truck) | 0 |
| Pillar ES | 23 | 4 (already-termed, same) | 5 (those 4 + car) | 0 |
| Intersection (EN; ES has none) | 11 | 0 | 11 | 0 |
| Sub-type (EN; ES has none) | 118 | 0 | 9 | 0 |
| Single resource EN / ES | 47 / 11 | 0 | 0 | 0 |
| Office pages, neighbourhood hub (EN / ES) | 9 / 4 | 0 | 0 | 0 |
| Hubs (/, /practice-areas/, /locations/, /resources/, /case-results/, /blog/, /attorneys/; 5 ES) | 12 | 0 | 0 | 0 |
| Blog posts (sample, EN / ES) | 3 / 3 | 0 | 0 | 0 |

The code-only pillar changes fix a defect that is already live on 9 pillars, whether or not
the terms are ever applied. Car and truck pillars switch their guides box to on-topic
guides (EN car 3 car guides, EN truck 4 truck guides, ES car 1). Case results and blog
blocks are unchanged on every pillar that gains a term.

**Sub-types:** 9 newly show "Related Guides & Legal Resources": 6 car sub-types (SC + GA
car settlement value, dangerous-roads-north-charleston) and 3 truck sub-types (GA + SC
truck settlement value, i-95-widening (both), blythewood-i-77). The SC-only port-freight
page drops the GA guide and adds carolina-crossroads. The other 109 call the block and
still show nothing, because their category has no resource.

**Intersections (resource block before → after; case results unchanged on all 11):**

| Page | Before | After |
|---|---|---|
| car / savannah-ga | Local …, 4 (2 truck guides, GA WD, GA UM) | "Georgia Car Accident Resources", 1: georgia-car-accident-settlement-value |
| car / charleston-sc | Local …, 4 (incl. Charleston County court PI guide) | Local …, 2: dangerous-roads-north-charleston, SC car settlement value |
| car / north-charleston-sc | Local …, 4 | Local …, 2: same two |
| car / columbia-sc | Local …, 4 (Broad River truck, moped, golf cart, helmet) | "South Carolina Car Accident Resources", 1: SC car settlement value |
| truck / savannah-ga | Local …, 4 (incl. GA WD, GA UM) | Local …, 4: bay-street, port-of-savannah, GA truck settlement value, i-16-i-95 |
| truck / charleston-sc | Local …, 4 (incl. PI court guide, pedestrian safety) | "South Carolina Truck Accident Resources", 4: SC truck settlement value, blythewood-i-77, carolina-crossroads, us-52-goose-creek |
| motorcycle / charleston-sc | Local …, 4 | **block gone** (no motorcycle-accidents resource) |
| medical-malpractice / charleston-sc | Local …, 4 | **block gone** |
| wrongful-death / charleston-sc | Local …, 4 | **block gone** |
| workers-compensation / savannah-ga | Local …, 4 | **block gone** |
| workers-compensation / charleston-sc | Local …, 4 | **block gone** |

3 intersections fall back to the "{State} … Resources" heading and 5 empty. The owner's
example page (WC Charleston) stops listing the PI court guide by losing the block, because
no resource carries `workers-compensation`. On-topic guides do exist but are tagged only
`south-carolina-law` or untagged: 4 SC workers' comp guides, GA-vs-SC workers' comp, GA/SC
wrongful death settlement value, SC motorcycle settlement value. Tagging them would fill
these blocks. That is a separate data decision (owner item below). No resource loses its
last link: the three guides that leave intersection lists (Charleston County court PI,
North Charleston pedestrian safety, North Charleston truck guide) are still linked from the
Charleston office page and the North Charleston hub (checked live).

### Jurisdiction check

Ran `roden_page_jurisdiction_states()` on page and resource for every list rendered in
all three modes: 784 page→resource links checked.

- Current code + terms: **1 cross-state pair**:
  `/truck-accident-lawyers/port-freight-truck-accident/` (SC-only) → `georgia-truck-accident-settlement-value` (GA).
- With the `template-subtype.php` fix: **0**.
- Callers: intersections pass `office_key` (the office state rule, which drops `both`).
  Sub-types passed no state filter before this PR and now pass `jurisdiction_of` (115 of
  118 are two-state, so they stay unfiltered). Single-resource sidebars pass
  `jurisdiction_of` (#252) and use the resource's own term, so pillar terms cannot reach
  them (0 changed).

### Sitemap, archives, doorway, floor, schema, breadcrumbs

- **Sitemap:** no effect. The `taxonomies` provider is removed (`roden_remove_sitemap_providers()`).
  Live providers are posts, eshubs and hubs, and none of the 8 live sub-sitemaps contains
  `practice-category`. No URL is added or removed.
- **Term archives** (`/practice-category/{slug}/`) already exist for all 24 terms and are
  `noindex, follow` (`roden_output_noindex_pages()`). They already list the pillars'
  children. After apply, each of the 18 archives also lists its EN pillar (ES is filtered
  out on EN requests). No new archive URL appears: every term already has published objects.
- **Term counts:** WordPress recounts the touched terms on write (published objects only).
  The stored counts are stale today, so the EN blog sidebar "Categories" widget shows
  different numbers after apply. Examples: Truck Accidents 45 → 17, Car Accidents 19 → 12,
  most others 8 → 5–10. Cosmetic. No term drops to 0.
- **Doorway ratio / floor:** unchanged by construction. No page, URL, title or content
  changes, and no sitemap change.
- **Structured data:** `roden_output_schema()` output byte-identical on all 289 rendered pages in
  all modes. Only `is_tax('practice_category')` archives read the taxonomy for schema.
- **Breadcrumbs:** no breadcrumb code reads `practice_category`. The full `<main>` diff
  shows no change outside the listed blocks.
- **content/meta.json:** does not export taxonomy terms, so no regeneration is needed.

### Apply (board strategist, after the theme commits are deployed)

```bash
H=rodenlawprod@rodenlawprod.ssh.wpengine.net
M=docs/practice-category/pillar-map-2026-10-23.json
ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file - b64:$(base64 < $M)"       < bin/assign-pillar-practice-category.php   # dry run
ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file - b64:$(base64 < $M) apply" < bin/assign-pillar-practice-category.php   # write
ssh $H "cd ~/sites/rodenlawprod && wp cache flush && wp page-cache flush"
```

Dry run on prod 2026-10-23: 36 set, 9 same, 0 refused, and all 4 prerequisites MISSING
(expected before deploy). Keep the `BACKUP-JSON` line: it is a rollback map for the same
script. The apply path has not been executed. Nothing was written to production.

### Owner items

- **Personal injury pillar** (EN 4692, ES 5200): no existing term fits. Either leave it
  without one or create a `personal-injury` term. It has no children, so only its own
  pillar blocks would change.
- **Resource tagging:** 5 intersections and 109 sub-types have no resource in their
  category. Tagging the existing on-topic guides would fill them (listed above). Adding a
  term alongside `south-carolina-law` keeps single-resource sidebars unchanged, because
  they read the first term by name.
- ES pillar blog block (pre-existing): untermed ES pillars list the 5 newest ES posts
  (currently HIPAA posts on the car pillar). The code fix gives the 4 termed ES pillars the
  same list.
- Pre-existing: on `car/charleston-sc`, `roden_related_resources()` still treats
  `dangerous-roads-north-charleston` as Charleston-local, because "charleston" is a
  substring. #256's longest-match helper covers office pages only.

### Re-run after deploy and apply

`node vendor/site-health/site-health.mjs crawl --repo . --base https://rodenlaw.com --live`.
Expected: 0 orphans, 0 non-200 (no URL changes). Spot-check that `/car-accident-lawyers/charleston-sc/`
lists the two car guides and real case results, `/workers-compensation-lawyers/charleston-sc/`
has no resources block, and `/practice-areas/bicycle-accident-lawyers/` shows a Related
Resources blog block again.

## Prepared (seventh PR, not applied): resource `practice_category` terms, before the pillar terms

Owner decision 2026-10-23, on the sixth PR's finding: tag on-topic resources with their
existing `practice_category` term first, then apply the pillar terms. Only `car-accidents`
and `truck-accidents` were on any published resource, so the pillar terms alone empty the
resources block on 5 intersections and leave 109 sub-types without one. **Status: prepared
and simulated, nothing written to production.** #259 merged and deployed during this work
(prod theme = `origin/main` a2316dd, checked by md5 over all 198 theme files), so "live"
below already includes #259's code. The pillar terms are not applied yet (5 EN + 4 ES
pillars carry a term, as before).

### Mapping (append only, existing terms only)

Survey of all 58 published resources (47 EN, 11 ES), read from prod 2026-10-23: title,
H2s, excerpt and opening text. 28 get a term, 16 already carry the right one, 14 are left
out. No term is removed and none is created. Map: `docs/practice-category/resource-map-2026-10-23.json`.

| Resource (id) | Now | Add | Why |
|---|---|---|---|
| SC workers' comp body part values (4839), pay (4840), MMI (4841), denied (4842) | south-carolina-law | workers-compensation | SC workers' comp guides |
| ES twins of those four (4935, 4933, 4936, 4934) | south-carolina-law | workers-compensation | same |
| georgia-vs-south-carolina-workers-compensation (5354) | none | workers-compensation | two-state WC comparison |
| south-carolina-wrongful-death-settlement-value (4861) | south-carolina-law | wrongful-death | |
| georgia-wrongful-death-settlement-value (6331) | none | wrongful-death | |
| south-carolina-motorcycle-accident-settlement-value (4858) | south-carolina-law | motorcycle-accidents | |
| georgia-helmet-laws (6312) | none | motorcycle-accidents | the motorcycle helmet statute; closes "Talk to a Georgia Motorcycle Accident Lawyer" |
| south-carolina-helmet-laws (6313) | none | motorcycle-accidents | "the whole of the state's motorcycle helmet requirement" |
| south-carolina-slip-and-fall-settlement-value (4859) | south-carolina-law | slip-and-fall | |
| south-carolina-premises-liability-settlement-value (4860) | south-carolina-law | premises-liability | |
| south-carolina-golf-cart-laws (6314) | none | golf-cart-accidents | "If you are hurt in a golf cart crash" |
| north-charleston-truck-accident-guide (4632) | none | truck-accidents | |
| truck-accident-settlement-process (5220) | none | truck-accidents | |
| i-26-i-95-corridor-report (5348) | none | truck-accidents | fatal truck crash report |
| pedestrian-bicycle-safety-north-charleston (4639) | none | bicycle-accidents, pedestrian-accidents | H2s: SC Pedestrian Laws, SC Bicycle Laws |
| georgia-car-seat-laws (6329), georgia-uninsured-motorist-coverage (6330) | none | car-accidents | crash-claim guides; both close "Talk to a Georgia car accident lawyer" |
| south-carolina-car-seat-laws (4813), south-carolina-um-uim-stacking (4812), ES twin (4931) | south-carolina-law | car-accidents | crash-claim / auto coverage after a crash |
| ES georgia-car-accident-settlement-value (5210) | none | car-accidents | EN twin 4807 carries it |
| ES georgia-truck-accident-settlement-value (5211) | none | truck-accidents | EN twin 4808 carries it |

Left out (no clear single existing term): Grand Strand fatal crash report (5398, all crash
types), SC liquor liability 2026 (5355, dram shop: premises or car both arguable), GA and SC
moped laws (6315, 6316, no moped term), Charleston County court PI claim (4640), and the
general-PI guides (SC SOL 4810, SC comparative negligence 4811, SC PI FAQ 4814, GA SOL 5223,
GA-vs-SC comparative negligence 5352, GA-vs-SC deadlines 5353, ES 4929, 4930, 4937). No
`personal-injury` term exists. Medical malpractice has no resource at all.

### Single-resource sidebars: how the term is picked, and the fix

`single-resource.php` called `wp_get_object_terms( $post_id, 'practice_category',
array( 'fields' => 'slugs' ) )` and used `$res_cat_terms[0]`. The default `orderby` is
`name ASC`, so the first term **by name** wins. The sixth PR's note ("adding a term alongside
`south-carolina-law` keeps sidebars unchanged") holds only for terms named after "South
Carolina Law". Per mapped resource:

- **Unchanged by order:** Workers' Compensation and Wrongful Death sort after South Carolina
  Law: 4839–4842, 4933–4936, 4861 (9).
- **Would have switched topic:** Car Accidents, Motorcycle Accidents, Premises Liability and
  Slip & Fall sort before it: 4812, 4813, 4931, 4858, 4859, 4860 (6).
- **Untermed, so any term switches the sidebar** from the all-topics list to the topic: 13.

Two theme commits in this PR, both in `single-resource.php`:

1. Use `south-carolina-law` when the resource carries it, else the first term as before.
   The 6 above keep their sidebar byte for byte (simulated).
2. If the topic list renders nothing, render it again without the topic (the untermed
   behaviour). That keeps the Related Guides box on 6 resources whose topic has no other
   same-state guide: 6312, 6314, 6331, 4639, 5210, 5211 (byte-identical to today). Side
   effect, visible as soon as this deploys: two resources that show **no** Related Guides
   box today get one: EN `georgia-car-accident-settlement-value` (its car pool is all SC)
   and ES `south-carolina-car-accident-settlement-value` (it is the only ES car guide). After
   the tags, both list car guides instead. If the owner wants zero movement before apply,
   drop commit 2. The price is that the 6 resources above lose the box at apply.

### Simulation (read-only, prod, 2026-10-23)

The harness renders every page five times: live, patched code with today's data, patched
code with the pillar terms (the sixth PR's state), patched code with **both** term sets, and
live again as a control. Terms are simulated for single-object term reads and, new in this
run, for tax queries: in sim modes a `query` filter swaps `wp_term_relationships` for a
derived table holding the extra rows in `SELECT … FROM wp_posts` statements. That is
what makes `roden_related_resources()` and the term archives see the resource tags. Prod has a
persistent object cache, so in sim modes `cache_results` is off and the term filters skip
`get_the_terms`/`update_object_term_cache` before their cache writes. After the run, all 234
practice_area/resource relationship cache entries matched the database (0 mismatches).

289 pages: 0 control diffs, 0 schema diffs outside the term archives.

| Template | Pages | Changed: pillar terms only | Changed: both | Notes |
|---|---|---|---|---|
| Intersection (EN) | 11 | 11 | 11 | 8 differ from pillar-only |
| Sub-type (EN) | 118 | 9 | 48 | blocks now shown on 48 (was 0 live, 9 pillar-only); 70 still none |
| Pillar EN / ES | 24 / 23 | 2 / 1 | 10 / 3 | Related Guides box only; blog block and case results unchanged |
| Single resource EN / ES | 47 / 11 | 1 / 1 (commit 2) | 22 / 1 | sidebars only, see below |
| Office pages + North Charleston hub EN / ES | 9 / 4 | 0 | 0 | |
| Hubs EN / ES, blog posts EN / ES | 12 / 6 | 0 | 0 | |
| Term archives (EN, noindex) | 24 | 17 | 20 | list the newly termed pillars and resources |

**Intersections, resource block (live → both):**

| Page | Live | Pillar terms only | Both |
|---|---|---|---|
| car / savannah-ga | Local: 2 truck, GA WD, GA UM | GA: GA car value | GA: GA UM, GA car seat, GA car value |
| car / charleston-sc | Local: PI court, ped/bike, N Chas truck, dangerous roads | Local: dangerous roads, SC car value | Local: dangerous roads, SC car seat, SC UM stacking, SC car value |
| car / north-charleston-sc | Local: ped/bike, N Chas truck, dangerous roads, SC moped | Local: dangerous roads, SC car value | same as Charleston |
| car / columbia-sc | Local: Broad River truck, moped, golf cart, helmet | SC: SC car value | SC: SC car seat, SC UM stacking, SC car value |
| truck / savannah-ga | Local: Bay St, port, GA WD, GA UM | Local: Bay St, port, GA truck value, I-16/I-95 | same as pillar-only |
| truck / charleston-sc | Local: PI court, ped/bike, N Chas truck, dangerous roads | SC: SC truck value, Blythewood, Crossroads, US-52 | Local: N Chas truck, SC truck value, Blythewood, Crossroads |
| **motorcycle / charleston-sc** | Local: 4 off-topic | **gone** | SC: SC helmet, SC motorcycle value |
| **wrongful-death / charleston-sc** | Local: 4 off-topic | **gone** | SC: SC WD value |
| **workers-comp / charleston-sc** | Local: 4 off-topic (incl. PI court) | **gone** | SC: SC WC denied, pay, MMI, body parts |
| **medical-malpractice / charleston-sc** | Local: 4 off-topic | **gone** | **still gone**: no med-mal resource exists |
| **workers-comp / savannah-ga** | Local: 4 off-topic | **gone** | **still gone**: the only GA WC guide is the two-state comparison, which the office rule drops |

3 of the 5 that emptied now list on-topic guides, and 2 stay empty. Case results are
unchanged on all 11.

**Sub-types newly showing "Related Guides & Legal Resources"** (48; all two-state except
the SC-only retail-shopping-center-fall and port-freight pages):
bicycle 5 and pedestrian 4 (the North Charleston ped/bike guide); golf cart 5 (SC golf cart
laws); motorcycle 3 (SC helmet, GA helmet, SC motorcycle value); premises 6 (SC premises
value); slip and fall 6 (SC slip and fall value); workers' comp 4 (GA-vs-SC WC + 3 SC WC);
wrongful death 6 (GA + SC WD value); car 6 and truck 3 (were already in the 9; their lists
change, see below). Still none (no resource in the category): dog bite 8, nursing home 8,
medical malpractice 8, maritime 6, product 6, burn 6, construction 6, ATV 6, e-scooter 5,
brain 4, spinal cord 4, boating 3 (70).

**Single-resource sidebar changes (EN 22, ES 1):**
- Newly termed, switch from the all-topics list to the topic (7): N Chas truck guide,
  truck settlement process, I-26/I-95 report, GA-vs-SC WC, SC helmet, GA car seat, GA UM.
- Already termed, gain the new siblings (15): the 12 truck guides (Related Guides now
  leads with the I-26/I-95 report and the settlement-process guide, newest first),
  dangerous-roads-north-charleston and SC car value (add SC car seat, SC UM stacking),
  GA car value (commit 2, then GA UM and GA car seat).
- ES SC car value: commit 2, then ES SC UM stacking.
- Unchanged: the other 21 mapped resources (9 by name order, 6 by commit 1, 6 by commit 2).
- No sidebar box empties. "Related Resources" (second box) changes only where the first
  box's list changed (it excludes what the first box shows).

**Blocks that empty:** only the two intersections above. No resource loses its last block
link: every one of the 58 still has inbound block links on the simulated pages. The biggest
drop is SC moped laws, 38 → 22.

**Ranking note:** lists are newest first, capped at 4. On the car pillar and the 6 car
sub-types, the four newest car guides (GA UM, GA car seat, SC car seat, SC UM stacking)
push out the two settlement-value guides. If the owner prefers the value guides there,
drop the four car-seat/UM rows (6329, 6330, 4813, 4812, 4931) from the map. Each row stands alone.

### Jurisdiction check

I ran `roden_page_jurisdiction_states()` on both page and resource for every resource link in
every rendered list (resource blocks, both resource sidebars): 808 links live, 811 with pillar
terms, 866 with both. **Cross-state single-state pairs: 0 / 0 / 0.** Coverage is real, not
an empty sweep: 371 links sit on SC-only resource pages, 136 on GA-only, 29 on single-state
intersections, and 5 on SC-only sub-types. 119 single-state → two-state pairs are kept by
the keep-both rule (sidebars, sub-types; the office rule still drops `both` on
intersections).

### Archives, sitemap, schema, breadcrumbs, doorway/floor

- Term archives stay `noindex, follow` (checked live on `/practice-category/workers-compensation/`
  and `/motorcycle-accidents/`). The sitemap index has no taxonomy sub-sitemap (8 providers:
  post, page, attorney, practice_area, location, resource, eshubs, hubs). 20 archives list
  more items and their CollectionPage JSON-LD changes with them. They are noindex. No new
  archive URL appears, because every term already has published objects.
- `roden_output_schema()` output is byte-identical on all 265 non-archive pages in every mode.
  No breadcrumb code reads `practice_category`. Every changed link sits in a resource block
  or sidebar list.
- Doorway ratio / granularity floor: no page, URL, title, content or sitemap change.
- Term counts recount on write (cosmetic, blog sidebar "Categories" widget).
- `content/meta.json` does not export taxonomy terms, so it needs no regeneration.

### Apply (board strategist): order matters

```bash
H=rodenlawprod@rodenlawprod.ssh.wpengine.net
WP="wp --path=/home/wpe-user/sites/rodenlawprod"
# 0. Merge this PR; the deploy carries the single-resource.php fix. The resource script refuses 'apply' without it.
# 1. Resource tags
M=docs/practice-category/resource-map-2026-10-23.json
ssh $H "$WP eval-file - b64:$(base64 < $M)"       < bin/assign-resource-practice-category.php   # dry run: 28 add, 0 refused
ssh $H "$WP eval-file - b64:$(base64 < $M) apply" < bin/assign-resource-practice-category.php   # keep the BACKUP-JSON line
# 2. Pillar terms (#259; its prerequisites are live since a2316dd)
P=docs/practice-category/pillar-map-2026-10-23.json
ssh $H "$WP eval-file - b64:$(base64 < $P)"       < bin/assign-pillar-practice-category.php
ssh $H "$WP eval-file - b64:$(base64 < $P) apply" < bin/assign-pillar-practice-category.php
# 3. Flush both caches
ssh $H "cd ~/sites/rodenlawprod && wp cache flush && wp page-cache flush"
```

Rollback for step 1: save the BACKUP-JSON payload to a file B and run
`ssh $H "$WP eval-file - b64:$(base64 < B) rollback [apply]" < bin/assign-resource-practice-category.php`.
It removes only the terms the apply added, and only while each post still carries exactly
what the apply left on it.

Dry run on prod 2026-10-23: 28 to tag, 0 refused, both prerequisites MISSING (expected
before deploy). Guard test (dry run): a pillar ID, a wrong term ID, a stale `current`
and a non-existent post were each refused. Nothing was written to production.

### Owner items

- **medical-malpractice / charleston-sc** and **workers-comp / savannah-ga** lose their (off-topic)
  resource block at pillar apply. They need an SC med-mal guide or a GA-only WC guide, or the
  owner accepts no block. Relaxing the office rule to keep `both` is not proposed: the rule
  exists because an office page states one state's law.
- The 14 left-out resources above, if the owner wants any of them in a topic.
- Car-seat/UM rows vs settlement-value guides on car lists (ranking note).
- Pre-existing: `roden_related_resources()` treats North Charleston guides as Charleston-local
  (substring match): the Charleston truck intersection now leads with the North Charleston
  truck guide under "Local". #256's longest-match helper covers office pages only.

### Re-run after deploy and apply

`node vendor/site-health/site-health.mjs crawl --repo . --base https://rodenlaw.com --live`
and `… linktopics …`. Expected: no new non-200 or orphan (no URL changes). Block anchors are
the destination's own title, so they add no link-topic findings. Spot checks:
`/workers-compensation-lawyers/charleston-sc/` lists the 4 SC WC guides,
`/motorcycle-accident-lawyers/lane-splitting-accident/` shows the block,
`/resources/south-carolina-motorcycle-accident-settlement-value/` sidebar is unchanged.

## Fixed (#260): owner decisions on the fifth PR's deferred items

Owner decisions, 2026-10-23 (revised the same day; this replaces an earlier pair rule):
(1) 410 both self-referencing legacy keys, every address form; (2) align the 8
disagreeing root/`/blog/` pairs **to the `/blog/` twin**. The twins carry all the GSC
history (the five "hire a lawyer" twins alone: 1,049 impressions), and their
destinations were a deliberate 2026-09-03 cull choice. So every twin keeps its
destination and the root key is re-pointed to match.

One file of code (`inc/legacy-redirects.php`), three commits: 410 root + `/blog/` forms;
8 root keys follow their twin; 410 the `/blog-` and `/blog/blog-` forms. Map edits only,
no logic change, no new strings.

### 410 (status: fixed)

These 8 URLs return 410 through the legacy map's existing `false` value (the
mechanism `/practice-areas/coronavirus-business-claims/` uses):

| Slug | Forms |
|---|---|
| `car-crash-crush-injuries-in-charleston` | `/{slug}/`, `/blog/{slug}/`, `/blog-{slug}/`, `/blog/blog-{slug}/` |
| `a-charleston-residents-guide-to-tourist-car-accidents` | same four |

Before: the root, `/blog-` and `/blog/blog-` forms were 301 → 404; the `/blog/` forms were 404.

**Why four explicit entries, not a resolver change.** `roden_resolve_legacy_blog_dest()`
skips a `false` root key and falls back to `/blog/`. Making it return "gone" would
change every 410 key's `/blog-` forms, not just these two. The replay proves that would
be wider: `/blog-practice-areas/coronavirus-business-claims/` and its `/blog/blog-` form
go 301 → `/blog/` (200) today, and nobody decided to change them. The explicit
entries are exact-match, so they are read before the `/blog-` pattern rules, and they
reach exactly the 4 URLs. Both control URLs are unchanged in the replay.

Nothing else in either map points at these URLs. The `-2`/`-3`/`-4` tourist twins are
unchanged. The handler is not 404-gated, so if a post is ever published at one of
these addresses, its entry must be deleted. A code comment says so.

### The 8 pairs (status: fixed, root re-pointed, twin unchanged)

| Slug | Root key: old → | Root key: new → (= twin, unchanged) | Twin impr. |
|---|---|---|---|
| why-should-i-hire-an-accident-lawyer-after-an-accident | `/blog/are-accident-lawyers-worth-it/` | `/blog/benefits-of-hiring-personal-injury-lawyer/` | 473 |
| when-should-you-hire-an-attorney-after-being-in-an-accident | `/blog/are-accident-lawyers-worth-it/` | `/blog/benefits-of-hiring-personal-injury-lawyer/` | 235 |
| why-is-having-a-personal-injury-lawyer-important | `/blog/are-accident-lawyers-worth-it/` | `/blog/benefits-of-hiring-personal-injury-lawyer/` | 206 |
| why-should-i-consult-a-personal-injury-lawyer-for-my-accident | `/blog/are-accident-lawyers-worth-it/` | `/blog/benefits-of-hiring-personal-injury-lawyer/` | 107 |
| how-can-an-attorney-help-with-my-car-accident-claim | `/blog/are-accident-lawyers-worth-it/` | `/blog/benefits-of-hiring-personal-injury-lawyer/` | 28 |
| why-is-workers-compensation-so-important-to-have | `/blog/am-i-eligible-for-workers-compensation/` | `/practice-areas/workers-compensation-lawyers/` | 201 |
| what-are-the-upsides-of-filing-a-personal-injury-lawsuit | `/blog/how-do-i-know-if-i-have-a-personal-injury-case/` | `/blog/questions-about-filing-a-lawsuit/` | 47 |
| what-are-the-benefits-of-hiring-a-workers-compensation-lawyer | `/blog/are-accident-lawyers-worth-it/` | `/practice-areas/workers-compensation-lawyers/` | 461 |

(Twin impressions are the figures in the Category 19 comments.) The old root values
were root-level slugs (`/are-accident-lawyers-worth-it/`), normalised to `/blog/` by the
funnel. The new values are written in their served form.

**Moved forms.** `roden_resolve_legacy_blog_dest()` reads the root key, so each pair's
`/blog-{slug}/` and `/blog/blog-{slug}/` forms move with it. That is 16 URLs, and all 16
are `redirects.csv` rows. Each is one 301 → 200 at the new destination (replay, patched):

- `/blog-{slug}/` and `/blog/blog-{slug}/` for the five "hire a lawyer" slugs → `/blog/benefits-of-hiring-personal-injury-lawyer/` (10 URLs)
- the same two forms of `why-is-workers-compensation-so-important-to-have` and `what-are-the-benefits-of-hiring-a-workers-compensation-lawyer` → `/practice-areas/workers-compensation-lawyers/` (4)
- the same two forms of `what-are-the-upsides-of-filing-a-personal-injury-lawsuit` → `/blog/questions-about-filing-a-lawsuit/` (2)

No other map entry or removal-map entry resolves through these 8 root keys. The replay
of every legacy and removal key shows no other change.

**`redirects.csv`:** the file does not change. It has no destination column (`URL,Last
crawled`). 16 of its URLs now resolve to a different destination, each still one hop to
a 200, so the check stays 997 / 0 / 0.

### Impressions check (every GSC export in the repo, 45 files incl. `.gz`)

- **The 8 root keys and the 16 moved forms: none appears in any export.** No URL with
  impressions changes destination.
- The 8 `/blog/` twins all appear, with 42 to 175 daily rows each in
  `gsc-2026-10-06/blog_page_date`. All 8 are unchanged in the replay.
- **The 410 set:** status change only, no new destination. The two `/blog-` forms and the
  tourist `/blog/` form have no impressions. These do:
  - `/blog/car-crash-crush-injuries-in-charleston/`: 764 impressions over 16 months, already 404 today.
  - `/car-crash-crush-injuries-in-charleston/`: 532 impressions over 16 months (pos. 24.7), 301 → 404 today.
  - `/a-charleston-residents-guide-to-tourist-car-accidents/`: 21 impressions, 301 → 404 today.

### Verification

This was a read-only replay on prod through the real `template_redirect` pipeline. It used
the #258 harness and the same path sets, plus the two coronavirus `/blog-` control forms.
Prod matched `origin/main` (a2316dd) by md5 on all 93 theme files. The main run was
byte-identical to the previous run's main output, and all 32 changed paths' main
behaviour matched live `curl`.

| Set | Paths | Changed |
|---|---|---|
| `redirects.csv` fixture | 997 | 16 (the moved forms, destination only, 1 hop → 200) |
| Sitemap, EN + ES | 594 + 56 | 0 (0 redirect, main or patched) |
| `/blog/` forms of every legacy + removal key | 700 | 2 (the two `/blog/` 410s, 404 → 410); twins 0 |
| Legacy keys | 267 + 1 (410) | 10 (8 root keys re-pointed, 2 → 410) |
| 410-slug forms (root, `/blog/`, `/blog-`, `/blog/blog-`, `-2/-3/-4`, `/es/`) | 14 EN + 4 ES | 8 → 410; `-2/-3/-4` and `/es/` 0 |
| Removal keys | 601 | 0 |
| Cull alias candidates | 136 EN + 42 ES | 0 |
| #256 truncation set | 565 | 0 |
| All `/es/` paths | 216 | 0 |
| Control: coronavirus `/blog-` forms | 2 | 0 |

That is 32 EN changes in all, and 0 ES: 8 → 410, 8 root keys and 16 forms → one 301 → 200
at the twin's destination. Chains or lost across all sets: main 8, patched 2. The 2 left
are the pre-existing synthetic `/blog/savannah/` and `/blog/practice-areas/brunswick/`.

site-health `redirects`, live, before (2026-10-23T19:51Z):
`redirects.csv: 997 legacy URLs replayed against https://rodenlaw.com · ok: 997 · chains: 0 · lost: 0`.
Expected after: the same.

### Owner items

- The crush-injury root URL has 532 impressions, separate from the `/blog/` URL's 764.
  Both now answer 410 rather than 404 or 301 → 404. That matches the decision. It is
  recorded here because the earlier tables showed only the `/blog/` figure.
- `why-is-workers-compensation-so-important-to-have` now goes to the WC pillar, not the
  eligibility post, in all four forms. This follows the align-to-twin rule. Neither page
  is about why coverage matters.

### Re-run after deploy

Flush both cache layers. Then run
`node vendor/site-health/site-health.mjs redirects --repo . --base https://rodenlaw.com --live`
and expect 997 / 0 / 0. Then check:
- `curl -sI https://rodenlaw.com/blog-car-crash-crush-injuries-in-charleston/` should return 410.
- `curl -sI https://rodenlaw.com/why-should-i-hire-an-accident-lawyer-after-an-accident/` should be one 301 to `/blog/benefits-of-hiring-personal-injury-lawyer/`.
