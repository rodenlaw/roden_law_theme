# Site-health remediation, 2026-10-23

Follow-up to `remediation-2026-10-22.md` (#247). One finding class, fixed by owner
decision of 2026-10-23, accepting that it changes resource lists on legally reviewed
pages.

| Class | Status | Where |
|---|---|---|
| crawl: resource orphans, generator `roden_related_resources()` | fixed (PR, unmerged) | `inc/template-tags.php` |
| Two-state I-95 guide tagged `ga`, now surfaces on 3 Savannah pages | **owner, decide before merge** | resource meta (DB) |
| Cross-state links in single-resource sidebars (pre-existing, unchanged) | deferred, fix proposed | `single-resource.php` + function |
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
