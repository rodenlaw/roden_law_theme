# Site architecture plan — rodenlaw.com (2026-09-26)

**Status: approved in part on 2026-09-26. Rule 6 is reopened for a capped, allowlisted office practice layer, and the first retirement batch shipped (157 / 671 = 23.40%). Wave 1 is not built yet.**

This folder is the living plan. Its files:

| File | What it is |
|---|---|
| `architecture.json` | Source of truth: the page tree, the geo-budget ledger, the linking rules, the phases and the open decisions. Edit this file. |
| `map.html` | The visual map. It renders `architecture.json`. Run `python3 -m http.server` in this folder and open `/map.html`. |
| `evidence/` | The data behind every number (see below) |

The files in `evidence/`:

- `inventory.csv`: all 685 sitemap URLs with page type, geo flag, market, and 16-month and 90-day GSC figures, each tagged WINNER, PROMISING, OK or DEAD.
- `query-clusters.csv`: market × practice demand, with the URLs that receive it and cannibalization flags.
- `retired-with-impressions.csv`: 630 retired URLs that still drew impressions in the last 30 days.
- `competitor-*.md`, `serp-classified.csv`, `volumes.csv`: which page type wins each head term, per market.
- `build.py`: rebuilds the inventory and clusters.

To extend the plan: add or change nodes in `architecture.json` (`kind`, `wave`, `evidence`, `note`), add ledger steps for any geo change, and reload the map. Every geo addition needs a matching ledger line.

## What the data says

1. **The informational layer earns the clicks.** Over the last 90 days:
   - blog: 1,393 clicks
   - resources: 575
   - homepage: 490
   - attorney bios: 330 (all six are WINNERs)
   
   The top pages are SC reference pages. Car-seat laws alone earned 200 clicks.
2. **The offer layer is broken.**
   - The 25 two-state pillars earned **10 clicks in 90 days**, at average positions 40–86.
   - The six SC statewide practice pages earned 2 clicks.
   - The office practice pages that ranked 9–30 on the biggest demand were retired on 09-18/19 and 301 to those pillars:

   | Cluster | Impressions, 16 months |
   |---|---|
   | Charleston car | 203k |
   | Savannah car | 183k |
   | Charleston truck | 82k |
   | Charleston workers' comp | 68k |
   | Charleston med mal | 66k |
   | Charleston motorcycle | 63k |
   | Charleston wrongful death | 60k |
   | Savannah workers' comp | 58k (position 8.6 over 90 days) |
   | Savannah truck | 56k |
   | North Charleston car | 54k |
   | Columbia car | 51k |
3. **Competitors win these searches with the page type we retired.**
   - "[city] car/truck accident lawyer" goes to a dedicated practice-in-city page in Savannah, Columbia and Myrtle Beach. In Charleston it goes to a practice page from a firm based there.
   - "[city] personal injury lawyer" goes to a homepage or a strong city page.
   - About 72–80% of Maps-driven traffic lands on the URL the Business Profile links to.
   - Broad coverage of many towns doesn't pay: Steinberg's ~100 town pages each earn under 0.5%.
4. **A traffic drop is coming.** 38% of the last 30 days' impressions still go to 568 retired URLs. Google hasn't processed those redirects yet. When it does, rankings of 9–15 hand over to pillars at 40–86. Expect a drop in October, caused by the retirements, not a penalty.
5. **Cannibalization:**
   - The homepage and office hubs split "[city] personal injury lawyer".
   - The Darien and Brunswick hubs split every Darien cluster.
   - Spanish twins outrank English pages on English North Charleston queries.
6. **Business Profile landings are wrong or stale.**
   - The Brunswick profile links to a URL that 301s to the national PI pillar.
   - Appointment links go to `/contact-us/`, which 301s to `/contact/`.
   - Columbia and North Charleston have 0% share of local voice in Local Falcon.

## The architecture

```
Home (/)                                     brand + two-state; stops targeting city terms
├── Locations (/locations/)                  GEO
│   ├── Georgia → Savannah hub, Darien hub (+ Brunswick: pick one landing)
│   └── South Carolina → Charleston, North Charleston, Columbia, Myrtle Beach hubs
│        Each office hub = the Business Profile landing + "[City] Personal Injury Lawyer"
│        └── Office practice pages (/{practice}-lawyers/{city-st}/)   GEO, capped, allowlisted
│             Wave 1 (11): Charleston car ✔approved, truck, WC, motorcycle, wrongful death, med mal;
│                          Savannah car, truck, WC; North Charleston car; Columbia car
│             Wave 2 (7, gated): Savannah med mal, premises; Charleston premises;
│                          North Charleston truck, motorcycle; Columbia truck; Myrtle Beach car
├── Statewide practice pages                 not geo
│   ├── South Carolina (6, exist)
│   └── Georgia (6, build)
├── Practice pillars (/practice-areas/, 25)  two-state explainers; consolidate the ~76% overlap
│   └── Scenario sub-types (132)
├── Resources (/resources/, 67)              the best earners; grow (studies #2–#5, legal guides)
├── Blog (/blog/, 375)                        explainers + local spokes; retire 14 DEAD geo posts
├── Attorneys · Case results · About · Contact
└── Español (/es/, 58)                       fix hreflang first; 31 DEAD
```

**Linking rules:**
- Each office Business Profile links to its office hub.
- The hub links to its practice pages, the attorneys at that office, and local guides.
- Each practice page links up to the hub, the statewide page and the pillar, and shows one state only.
- Each local blog post links to one office practice page, with an anchor that names it.
- Resources link to the statewide page and the pillar.

## Geo budget

Today: 171 / 685 = **24.96%**, against a 25% ceiling.

| Step | Geo / total | Ratio |
|---|---|---|
| Retire the 14 DEAD geo blog posts (done 2026-09-26) | 157 / 671 | 23.40% |
| Retire the 2 DEAD Spanish office hubs (done 2026-09-26) | 155 / 669 | 23.17% |
| Wave 1: 11 office practice pages (includes the Charleston car trade) | 166 / 680 | 24.41% |
| Georgia statewide practice pages (6, not geo) | 166 / 686 | 24.20% |
| Planned reference pages (≥8, not geo) | 166 / 694 | 23.92% |

That leaves roughly 7 slots for wave 2. Each further geo page needs 3 non-geo pages or 1 geo retirement.

## Phases

**P0 — Hygiene and Business Profile landings (weeks 1–2)**
- Point every office profile at its hub. The Brunswick profile URL now 301s to the Darien hub (live 2026-09-26). Fix the `/contact-us/` appointment links.
- noindex `/test/`.
- Resolve the 53 non-sitemap URLs that return 200 and the 9 that 404.
- Fix the typo redirect for Columbia premises (`premisesliability`).
- Replace the blanket `RODEN_LOCATION_FREEZE` block with an allowlist (`inc/content-guardrails.php` L253–281). Without this, publishing the Charleston car page gets reverted to draft.

**P1 — Office practice pages, wave 1 (weeks 2–8)**
- Retire the 14 DEAD geo blog posts first — done 2026-09-26.
- Restore 11 pages at their old URLs, in batches of 3–4. The post drafts survive from 09-25. Order: Charleston car → Charleston truck → Savannah car → Savannah WC → Charleston WC → Charleston motorcycle → Columbia car → North Charleston car → Savannah truck → Charleston wrongful death → Charleston med mal.
- Each page follows the Charleston car template:
  - one state only
  - office map, NAP and local roads
  - statutes from the law pack
  - an attorney byline
  - a legal sweep, then Gillin's (SC) or Eric Roden's (GA) sign-off
  - the nested duplicate URL 301s to the flat URL

**P2 — Office hubs and the state layer (weeks 4–10)**
- Retitle each hub "[City] Personal Injury Lawyer", separate it from the homepage, and add the practice-page grid.
- Build the Georgia statewide practice pages.
- Choose one Darien landing page.
- Fix Spanish/English hreflang.

**P3 — Reference layer and pillars (ongoing)**
- Studies and legal guides under `/resources/`.
- One canonical explainer to cut the pillar overlap.

**P4 — Measure and gate (weeks 12–16)**
- A wave-1 page stays if by day 120 it ranks ≤20 on its head term or earns clicks. Otherwise it is retired again.
- Wave 2 opens only if the wave-1 median position is ≤15 and the ledger has room.

## Decisions

Recorded 2026-09-26, owner:

1. **Rule 6 is reopened** for a capped, allowlisted set of office practice pages. The Charleston car exception becomes the first entry.
2. **The DEAD geo pages are retired** to fund wave 1. This batch covers the 14 blog posts (`roden_dead_geo_post_urls()`). The two Spanish office hubs (Darien, North Charleston) were retired the same day on a second instruction: drafted, not deleted, each 301 to its English hub.
3. **The Darien office page is the Business Profile landing** for the Darien area, not Brunswick.

## Constraints still in force

- No sub-city, neighbourhood, road or route-plus-city URLs.
- No office practice pages in cities without an office.
- Single-state pages only for office practice pages.
- Legal sign-off before any publish.
- Retirements go to draft with `_roden_retired` and a single-hop 301.
- The Spanish mirror rule applies.
