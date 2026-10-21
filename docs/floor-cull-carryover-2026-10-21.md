# Floor-cull merge carry-over plan, 2026-10-21

The plan for carrying content from the six pages merged in the floor cull (#223 redirects, #224 applied) into
the four posts that now receive their redirects. The owner said "lets do 2 now" on 2026-10-21. **This is the
plan only. Nothing here has been written to prod.**

How it was built:
- **Sources:** the drafted posts, read from `docs/backups/floor-cull-posts-2026-10-21.json`.
- **Targets:** `post_content` and every `_roden_*` key, read from prod with `wp eval-file` (read-only). Each
  target was also fetched live with `?nc=`, and the H2 used as an anchor below is present on each page.
- **Claims sweep:** every proposed passage was replayed through
  `internal-ai-scripts/scripts/facts/sweep-claims.mjs --fixtures` against the GA and SC packs: 11/11 clean.

The rule throughout: carry only what the target lacks and a reader would use. Generic boilerplate, CTAs,
duplicates, and any statistic without a named source and year are dropped, each listed below with the reason.

## Summary

| Target | Post | Ledger | Carried | Dropped | Words added | New FAQs | Passages that state law |
|---|---|---|---:|---:|---:|---:|---|
| Ravenel cyclists guide | 3499 | unknown (no hold) | 2 | 6 | ~130 | 1 | R1, RF1 (Nelson v. Concrete Supply Co.); R2 (SC 15-78-110, SC 15-78-80) |
| Folly Road / James Island | 4344 | **waiting to 2027-01-04** | 1 | 5 | ~45 | 0 | none |
| Ashley Phosphate / I-26 | 4337 | **waiting to 2026-12-31** | 3 | 8 | ~120 | 0 | none |
| Savannah highways | 4538 | **waiting to 2027-01-01** | 4 | 12 | ~120 | 0 | none |

---

## 1. Ravenel cyclists guide (post 3499)

**Source:** 3487, `/blog/what-to-do-after-a-bike-crash-on-charlestons-ravenel-bridge/`.

**Target:** `/blog/a-cyclists-guide-after-a-ravenel-bridge-accident/`.
- Author: `_roden_author_attorney` 3732.
- **No `_roden_last_reviewed`.**
- Ledger status: `unknown`; last change 2025-09-13.
- In the freshness benchmark **control** cohort (not refreshed).

### Carry

**R1: comparative fault.** The target never mentions shared fault.
- *Source:* "South Carolina applies a modified comparative fault rule from Nelson v. Concrete Supply Co., under
  which you can recover if you are 50% or less at fault, with your award reduced by your percentage of
  responsibility." (source FAQ 4)
- *Place:* in "Navigating Insurance Claims and Legal Counsel", after the S.C. Code § 15-3-530 paragraph.
- *New text:* "If the other side says you share the blame, you can still recover. South Carolina bars a claim only
  when the injured person is more than 50% at fault (Nelson v. Concrete Supply Co.); at 50% or less, the award
  is reduced by your share, so a cyclist found 20% at fault recovers 80% of the damages."
- *Authority:* SC pack `Nelson v. Concrete Supply Co.` (verified 2026-09-08, Gillin). The source attributed
  this rule to another law firm's website; that attribution is dropped and the case is cited instead.

**R2: other liable parties and the government deadline.** The target names only the driver.
- *Source:* "if a dangerous road condition like a large, unmarked pothole on the bridge contributed to the crash,
  a government entity could share responsibility." Also source FAQ 5: "a party responsible for the roadway or
  path surface, another cyclist, or a vehicle owner separate from the driver."
- *Place:* the same section, after R1.
- *New text:* "A driver is not the only possible defendant. Another cyclist, or the owner of a vehicle someone
  else was driving, may share liability, and so may the public body responsible for the path if a broken or
  obstructed surface caused the crash. A lawsuit against a South Carolina government entity must be filed
  within two years, or three if a verified claim is filed with the agency first (S.C. Code §§ 15-78-110,
  15-78-80)."
- *Authority:* SC pack `SC 15-78-110` and `SC 15-78-80`. The wording avoids any "notice required" phrasing (rules
  `sctca-mandatory-notice`, `sctca-shorter-notice-hedge`).
- **Why it matters:** the page's only deadline is the three-year § 15-3-530 rule, which is wrong for a claim
  over the bridge path.

**RF1: new FAQ.**
- *Q:* "What if I was partly at fault for a Ravenel Bridge bike crash?"
- *A:* "You can still recover if you were 50% or less at fault. South Carolina bars a claim only above 50%
  (Nelson v. Concrete Supply Co.), and the award is reduced by your share of the fault."
- *Authority:* SC pack `Nelson v. Concrete Supply Co.`

### Dropped

| Source material | Why |
|---|---|
| Comparative-fault rule attributed to another law firm's website | Replaced by the case citation (R1) |
| "As noted in a guide from Enjuris…" on keeping medical records | Third-party guide; the target already covers records |
| Road Hazards row of the evidence table | Covered by the target's "Surroundings: path conditions" row |
| Expense folder items (bills, repair estimate, lost wages) | Covered by the target's "dedicated folder" paragraph |
| Get the report from Charleston PD or Mount Pleasant PD | The target already names both departments |
| SOL paragraph and SOL FAQ | Duplicates the target |

---

## 2. Folly Road / James Island (post 4344)

**Source:** 3451, `/blog/a-step-by-step-guide-for-folly-road-car-accidents/`.

**Target:** `/blog/folly-road-car-accidents-james-island-charleston/`.
- Author: 3732.
- `_roden_last_reviewed` 2026-09-25; `_roden_last_refreshed` 2026-10-06.
- Ledger: **waiting until 2027-01-04**.
- Freshness benchmark: **refreshed** cohort (2026-09-25).

The target is the fuller page (2,975 words against the source's 1,842), with SCDOT audit data, conflict points,
government liability and dram-shop law. Almost nothing in the source is new.

### Carry

**F1: which agency writes the report.**
- *Source:* "Depending on the exact location of the Folly Beach crash, either the Folly Beach Police Department or
  the Charleston County Sheriff's Office will respond."
- **Correction:** this is incomplete. Folly Road also runs through City of Charleston limits, and it is a state
  route.
- *Place:* in "What to Do After an Accident on Folly Road", after the "Call 911" step.
- *New text:* "Which agency writes the report depends on where on Folly Road the crash happens: the Charleston
  Police Department, the Charleston County Sheriff's Office, the Folly Beach Police Department or the South
  Carolina Highway Patrol. Note the agency and the report number before you leave."
- **`[VERIFY]` before apply:** confirm the agency list against the City of Charleston and Town of James Island
  limits, and SCHP's role on SC-171. Cut any agency that cannot be confirmed.
- No legal claim.

### Dropped

| Source material | Why |
|---|---|
| Exchange-information list and table | The target's "Exchange information" step covers it |
| "Be wary of early settlement offers" | Generic |
| SOL paragraph and FAQ | Duplicates the target, which also has the wrongful-death and TCA deadlines |
| Comparative-negligence paragraph | Duplicates the target. Wording note under Surprises |
| "Turn on hazard lights" | Covered by "Move to safety" |

---

## 3. Ashley Phosphate / I-26 (post 4337)

**Source:** 4664, `/resources/ashley-phosphate-i-26-truck-accidents/`.

**Target:** `/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/`.
- Author: 3732.
- `_roden_last_reviewed` 2026-10-02; `_roden_last_refreshed` 2026-10-06.
- Ledger: **waiting until 2026-12-31**.
- Freshness benchmark: **refreshed** cohort (2026-10-02). The benchmark notes it already carries 4624's merged
  content.

The target has nothing specific to trucks. The source was the truck page for the same intersection.

### Carry

**A1: new row in the "Common Crash Types at Busy Interchanges" table.**
- *Source:* "Trucks making right turns require a wide turning radius, often swinging into adjacent lanes…
  the cab clears the crosswalk, but the long trailer sweeps through the pedestrian's path."
- *New row:* Right-turn trailer sweep | A truck's trailer cuts the corner or swings into the next lane on a right
  turn, catching a car, motorcycle or a pedestrian in the crosswalk | Crush injuries, fractures, traumatic brain
  injury.

**A2: a truck step in "What to Do If You're Injured at This Intersection"**, after "Photograph everything".
- *Source:* "Document the truck: Company name, USDOT number, trailer number, cargo type…" and "Evidence from ELD
  devices, traffic cameras, and the truck's event data recorder must be preserved immediately."
- *New text:* "If a truck was involved, photograph the company name, the USDOT number on the cab door and the
  trailer number, and ask a lawyer to send a preservation letter for the truck's electronic logging device (ELD)
  and event data recorder before the data is overwritten."

**A3: one sourced local fact**, appended to "3. Commercial Density Around the Interchange".
- *Source:* "South Carolina Department of Transportation traffic data places Ashley Phosphate Road among
  Charleston County's five deadliest roads — four of which run through North Charleston, alongside Rivers Avenue,
  Dorchester Road and Remount Road (Live 5 News, July 2026)."
- *New text:* "Live 5 News reported in July 2026 that SCDOT data place Ashley Phosphate Road among Charleston
  County's five deadliest roads, four of which run through North Charleston, alongside Rivers Avenue, Dorchester
  Road and Remount Road."
- **`[VERIFY]` before apply:** find the Live 5 article and link it. Cut A3 if it cannot be found.

None of the three states law.

### Dropped

| Source material | Why |
|---|---|
| "an 80,000-pound truck needs approximately 525 feet to stop from 65 mph" | No source |
| "This intersection is in North Charleston Police jurisdiction" | Unverified; the I-26 ramps may be SCHP's |
| SCDOT liable for "intersection design defects" (liability table and FAQ) | **Wrong:** design is immune under § 15-78-60(15). The target is correct and must not be overwritten |
| "less than 51% at fault" | Same wording issue as the target (see Surprises) |
| Punitive damages bullet | Generic. The SC standard (clear and convincing, § 15-33-135) would need its own review |
| I-26 & Aviation Avenue section | A separate interchange; the Aviation pages were retired to the truck pillar |
| Traffic-camera FAQ | The target covers cameras and preservation |
| Trident Medical Center | Already in the target |

---

## 4. Savannah highways (post 4538)

**Sources:**
- 4649 `/resources/i-16-truck-accidents-savannah/`
- 4648 `/resources/i-95-truck-accidents-savannah-brunswick/`
- 4670 `/resources/abercorn-street-truck-accidents-savannah/`

**Target:** `/blog/savannah-dangerous-highways-i16-i95-abercorn/`.
- Author: 3729.
- `_roden_last_reviewed` 2026-10-02; `_roden_last_refreshed` 2026-10-03.
- Ledger: **waiting until 2027-01-01**.
- Freshness benchmark: **refreshed** cohort (2026-10-02).

### Carry

**S1: port truck volume**, appended to the "Port traffic" bullet in "Why Savannah's Highways Are So Dangerous".
- *Source (4649):* "The Port of Savannah handles 14,000 to 16,000 truck moves a day, Monday through Friday
  (Georgia Ports Authority), and much of that traffic reaches I-16 at Dean Forest Road and I-516". Also: "Trucks
  reach I-16 at Dean Forest Road (exit 160) and by the Jimmy DeLoach Parkway (exit 152), which also connects the
  port to I-95."
- *New text:* "The port handles 14,000 to 16,000 truck moves a day, Monday through Friday (Georgia Ports
  Authority), and much of that traffic reaches I-16 at Dean Forest Road (exit 160) or by the Jimmy DeLoach
  Parkway (exit 152), which also connects to I-95."

**S2: the human cost of truck crashes**, appended to the "Truck accidents on I-16 are particularly devastating"
paragraph.
- *Source (4649):* "197 people died in Georgia crashes involving large trucks in 2024, and 173 of them were in
  other vehicles or on foot (NHTSA, Traffic Safety Facts: Large Trucks)."
- *New text:* "Statewide, 197 people died in Georgia crashes involving large trucks in 2024, and 173 of them were in
  other vehicles or on foot (NHTSA, Traffic Safety Facts: Large Trucks)."

**S3: a truck step in "What to Do After a Highway Crash in Savannah"**, after "Call 911".
- *Source (4649, 4670):* "Document the truck: Company name, USDOT number (on the cab door), trailer number, and
  cargo type."
- *New text:* "If a truck was involved, photograph its company name, the USDOT number on the cab door, the trailer
  number and the cargo type; they identify the carrier and its insurer."

**S4: trauma centre**, appended to the "Seek medical treatment" step.
- *Source (4649):* "Memorial Health in Savannah is the region's Level I trauma center."
- *New text:* "Memorial Health University Medical Center in Savannah is the region's Level I trauma center."
- **`[VERIFY]` before apply:** check the Georgia DPH trauma-centre list.

None of the four states law.

### Dropped

| Source material | Why |
|---|---|
| 4648: "Georgia recorded 257 truck-related fatalities in 2023 — an 81% increase from 142 in 2013" | No source named. S2 is the sourced figure |
| 4648: "I-95 has been called the most dangerous highway in the country" | No source; the target already has the FARS ranking |
| 4648: "30,000+ daily truck trips" (FAQ) | Contradicts the GPA's 14,000–16,000 |
| 4648: rural counties 34% / 21%; 18% of rural fatal crashes involve trucks | No source named |
| 4648: Richmond Hill–Darien, Darien exit, Glynn widening | Outside this page's Savannah scope; Darien/Brunswick has its own kept page |
| 4648: post-accident testing "must occur within hours per FMCSA rules" | Imprecise (49 C.F.R. § 382.303 sets 2/8-hour alcohol and 32-hour drug windows); not in the GA pack |
| 4648/4670: 525-foot stopping distances | No source |
| 4649: FMCSR violations as negligence per se under O.C.G.A. § 51-1-6 | Not in the GA pack; the target already calls violations evidence of negligence |
| 4649: January 2026 Bleckley County crash; Bibb County 6,103 crashes | Outside Savannah |
| 4670: "Savannah-Chatham Metropolitan Police responds" | **Stale:** that department was dissolved in 2018 (now Savannah PD and Chatham County PD) |
| 4670: Gateway Blvd fire-engine crash (Jan 2023), Apache Ave fuel spill (Apr 2026), Montgomery Cross Rd fatal (Jan 2026) | No source named |
| 4670: liability table, punitive bullet, Abercorn & White Bluff | Generic, or already in the target |

---

## Law items and attorney review

| Item | Claim | Pack authority | Reviewer |
|---|---|---|---|
| R1, RF1 | SC plaintiff's bar: more than 50%; reduced at 50% or less | SC `Nelson v. Concrete Supply Co.` | Gillin (SC owner rule) |
| R2 | SCTCA: 2 years, or 3 with a verified claim | SC `SC 15-78-110`, `SC 15-78-80` | Gillin |

No Georgia law is carried, so the pending Roden GA sign-off (D6) does not block the Savannah items. Three
`[VERIFY]` items are factual rather than legal: F1 agencies, A3 Live 5 source, S4 trauma level.

## Surprises

1. **SC comparative-fault wording on two held targets.** Folly Road (body, key takeaways, FAQ) and Ashley
   Phosphate (body) say "less than 51%" or "51% or more". The SC pack (Nelson) says barred at *more than 50%*,
   recover at *50% or less*. The two match only in whole percentages; at 50.5% they differ. This is the open
   threshold item on the board, not a new error class. The Ravenel text uses the pack's wording.
2. **Ravenel target, PIP sentence.** It says "your own auto insurance may provide benefits through Personal
   Injury Protection (PIP)". South Carolina has no mandatory PIP, and the SC pack has no PIP authority. This is
   not a confirmed error, but it states SC insurance law without a reviewer of record. Ask Gillin with R1/R2.
3. **Ravenel target has no review date.** It has no `_roden_last_reviewed`, and its only deadline is three years,
   which is wrong for a claim over the bridge path (R2 fixes this).
4. **Two source errors kept out of the targets:** SCDOT "design defect" liability (Ashley source) and the
   dissolved SCMPD (Abercorn source).

## Ledger and freshness benchmark

Three targets are `waiting` and in the **refreshed** cohort: Folly Road (refreshed 2026-09-25), Ashley Phosphate
(2026-10-02) and Savannah highways (2026-10-02). The Ravenel guide is in the **control** cohort.

The merge redirects already feed these pages new inbound signal, so they are confounded whether or not the
carry-over happens. Separately, **18 of the 41 retired posts are in the control cohort** and should leave it.

**Proposed edit to `docs/gsc-2026-10-06/cohorts.json` (not made).** Benchmark convention (method notes in
`docs/gsc-benchmark-2026-10-06.md`): retired, merged and redirected posts are excluded from both cohorts.
1. Delete these keys from `refreshed`:
   - `/blog/folly-road-car-accidents-james-island-charleston/`
   - `/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/`
   - `/blog/savannah-dangerous-highways-i16-i95-abercorn/`
2. Remove `/blog/a-cyclists-guide-after-a-ravenel-bridge-accident/` and the 18 retired control posts from the
   `control` array.
3. Add a top-level map recording why:

```json
"excluded": {
  "/blog/folly-road-car-accidents-james-island-charleston/": "floor-cull merge redirects 2026-10-21",
  "/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/": "floor-cull merge redirects 2026-10-21",
  "/blog/savannah-dangerous-highways-i16-i95-abercorn/": "floor-cull merge redirects 2026-10-21",
  "/blog/a-cyclists-guide-after-a-ravenel-bridge-accident/": "floor-cull merge redirects 2026-10-21",
  "<each of the 18 retired control posts>": "retired 2026-10-21 (floor cull)"
}
```

Also add one line to the method notes: "Floor cull 2026-10-21: 4 merge targets and 18 retired control posts
excluded; see cohorts.json `excluded`." The refreshed cohort drops from 79 to 76.

## Apply notes (for when this is approved)

- Write all surfaces on a working copy and save once (`bin/backfill-helmet-citations.php` pattern), with
  `wp_slash`.
- Set `_roden_content_modified`, because this changes what the pages say.
- Do not touch `_roden_last_reviewed` until the reviewer signs.
- The Ravenel FAQ goes in `_roden_faqs`, which also feeds the FAQPage schema.
- Afterwards:
  - run `bin/check-unslashed-post-writes.php`;
  - run `sweep-claims.mjs --client roden --fresh`;
  - regenerate `content/meta.json`.

## Applied 2026-10-21 (owner: "do 1 and 3 now")

Folly Road, Ashley Phosphate and Savannah highways only. The Ravenel guide is held for Gillin (R1, RF1, R2, plus
the PIP sentence).

- **Script:** `bin/apply-floor-cull-carryover.php`.
  - Dry run first: all 8 anchors matched exactly once.
  - Applied with `wp_slash`; the `post_content` read-back matched on all 3.
  - `_roden_content_modified` set; `_roden_last_reviewed` untouched.
  - Backup: `docs/backups/floor-cull-carryover-2026-10-21.json`.
- **Words added:** 4344 +54, 4337 +116, 4538 +112.
- **[VERIFY] items, resolved against primary sources:**
  - F1 is worded "may come from", since no official page assigns Folly Road stretches to agencies. Links:
    Charleston PD Patrol Division, Town of James Island (CCSO partnership), Folly Beach PD.
  - A3: Live 5 News, 2026-07-31, citing SCDOT data. It is worded as four of the county's five deadliest roads
    being in North Charleston, with no ranking claimed.
  - S4: Georgia DPH 2026 trauma-center list, Level I, ACS-verified.
- **Two figures checked as well:**
  - S1: GPA press release of 2026-01-27, verbatim "14,000-16,000 truck moves daily, Monday through Friday". The
    unverified exit numbers and the Jimmy DeLoach–I-16 link were cut.
  - S2: NHTSA DOT HS 813 816, Large Trucks: 2024 Data, Table 7, Georgia row 197/173. "On foot" became "outside a
    vehicle" because nonoccupants include cyclists.
- **Checks after apply:**
  - Both caches flushed; all 8 insertions render on the live pages.
  - `check-unslashed-post-writes.php` PASS, static and live.
  - `sweep-claims.mjs --fresh`: the only finding is the known troubled-teen FAQ (#215), none on these posts.
- **Freshness benchmark:** `cohorts.json` now excludes the 4 merge targets and the 18 retired control posts.
  Refreshed 79 → 76; control 279 → 260. The method note was added to `docs/gsc-benchmark-2026-10-06.md`.
