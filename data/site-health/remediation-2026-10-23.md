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
