# Pre-publish legal sweep: North Charleston car accident page (post 4540, DRAFT)

- **Page:** `/car-accident-lawyers/north-charleston-sc/`. Post 4540, `practice_area`, draft, `_roden_retired` still set. Parent: the car accident pillar. Allowlisted in #188. Wave 1, #9.
- **Jurisdiction:** South Carolina only. Reviewer of record: Graeham C. Gillin (SC Bar).
- **What was swept:** the rendered draft (`scratchpad/draft4540.txt`, `scratchpad/preview/draft4540.html`) and all 7 JSON-LD blocks (LegalService, Person, FAQPage, WebPage, HowTo, LocalBusiness/LegalService/LawFirm, BreadcrumbList).
  - **Page surfaces**, from `bin/rebuild-north-charleston-car-accident.php`: body, excerpt (Article `description`), meta description, key takeaways, 6 FAQs.
  - **Template blocks:** hero, NAP bar, office map and `directions`, law box, what-to-do steps and HowTo, case types, the North Charleston `local_context` essay (EN and ES, both revised in #188, `inc/firm-data.php`), the car pillar's negligence and compensation intros, the statewide uplink, the stats block, attorneys, case results, resources, the CTAs and the sidebar.
  - **Where the #188 text renders:**
    - `directions` renders on the North Charleston hub (`template-location.php:473`) and on every North Charleston intersection (`template-intersection.php:307`, EN only).
    - `local_context` renders on North Charleston intersections. There is no `local_context_wc` for this office, so the essay does not render on a workers' comp page.
  - **Linked pages** were read in the sweep's WordPress export (`data/content-cache/wp-export.json`, exported 2026-09-28 18:20 UTC: bodies, excerpts, FAQs, key takeaways).
- **Pack:** `law/SC.json` is **SIGNED**: Graeham C. Gillin, 2026-09-26, 34 authorities, no `pendingAuthorities`.
  - Every authority this page rests on is signed and has `verifiedBy` set: `SC 15-3-530`, `Nelson v. Concrete Supply Co.`, `SC 15-78-110`, `SC 15-78-80`, `SC 15-78-120`, `SC 38-77-140`, `SC 38-77-150`, `SC 38-77-160`, `SC 38-77-170`, `SC 56-5-1260`, `SC 56-5-1270`.
  - No claim on the page needs a new authority. The venue sentence names no statute (see the facts table).
- **Engine run:**
  - I replayed 48 blocks through `sweep-claims.mjs --fixtures scratchpad/draft4540-fixture.json --states SC,GA` on internal-ai-scripts `main` (`042f154`). The blocks are 32 rendered-text blocks (including the key takeaways and the essay), 6 FAQPage answers, 7 HowTo steps, the LegalService and HowTo descriptions, and a positive control.
  - Result: **0 findings**. The positive control (a § 15-38-15 miscite) fired, so the rules were loaded. Result line: 48/48.
  - A second fixture (`scratchpad/nchs-linked-fixture.json`, 11 linked-page sentences plus a control) returned 0 on all 11. Every one of those is a false negative (see "Pack changes").

**Verdict: PASS for the page.**
- No error-level finding on any rendered surface, page or template. Three low-severity warnings (W1–W3).
- The SC rules text is the Columbia and Charleston car wording that Gillin reviewed, word for word, and it matches the signed pack on every surface.
- **One LINKED error (L1) is live today.** The hit-and-run post the body links to calls leaving the scene of an injury crash a felony (it is a misdemeanor unless the injury is great bodily injury). It also gets UM/UIM wrong in both directions. Fix it in the same batch; it does not block this page.
- Byline: "Reviewed by Graeham C. Gillin" must not go live until he has reviewed this page.
  - `_roden_last_reviewed` is correctly unset (checked in `docs/backups/north-charleston-car-accident-before-2026-09-28.json`).
  - `bin/publish-north-charleston-car-accident.php` aborts until `$reviewed` is set.

Source key:
- **PAGE** means `bin/rebuild-north-charleston-car-accident.php` (post 4540 content and meta).
- **TEMPLATE** means the theme or `inc/firm-data.php`.
- **LINKED** means a separate published page this page links to. It is not rendered here, so it does not block this publish.

---

## Road, court and hospital facts

| Claim as published | Where | Result | Evidence |
|---|---|---|---|
| "North Charleston also reaches into Berkeley and Dorchester counties" | PAGE body + FAQ 5 | **Confirmed** | Wikipedia *North Charleston, South Carolina*: "a city in Berkeley, Charleston, and Dorchester counties". |
| "a crash in one of those parts of the city may be filed in that county instead" | PAGE body + FAQ 5 | **Confirmed; correct as hedged** | § 15-7-30 (scstatehouse.gov/code/t15c007.php, read 2026-09-28) makes the county where "the most substantial part of the alleged act or omission … occurred" a proper venue against every class of defendant: (C)(2) resident individuals, (D)(1) nonresidents, (E)(2) domestic entities, (F)(1)/(G)(1) foreign entities. The alternatives are the defendant's residence or principal place of business, so "may" is right and "must" would be wrong. For a government defendant, § 15-78-100(b) requires the suit "in the county in which the act or omission occurred", so a Berkeley- or Dorchester-side crash with a city, county or SCDOT defendant *must* go there. The sentence does not contradict that. |
| "Most North Charleston car accident lawsuits are filed in the Charleston County Court of Common Pleas" | PAGE body + FAQ 5; TEMPLATE essay ("usually") | Hedged generalization; accepted | No filing data was checked. Most of the city lies in Charleston County, and "most" / "usually" are hedged. It is the same form the Columbia page uses. |
| "Charleston County Judicial Center, 100 Broad Street, downtown" | PAGE body + FAQ 5; TEMPLATE essay; firm-data `court_address` | **Confirmed** | OSM/Nominatim: "Charleston County Judicial Center, 100, Broad Street, … Charleston, Charleston County, 29401". The Clerk of Court and Probate Court resolve to the same address. |
| Trident Medical Center, 9330 Medical Plaza Drive, Level II; MUSC Health University Medical Center, "the region's Level I" | TEMPLATE essay (EN + ES) | **Confirmed** (by the caller, 2026-09-28) | Level II per ACS, Level I per MUSC. There is no "only" or "flown to" wording left. |
| "Hugh Leatherman Terminal" … "I-26 / I-526 / Rivers Avenue corridor" | TEMPLATE essay | **Confirmed** | Nominatim places Hugh K. Leatherman Terminal in North Charleston (32.841, -79.939), about 1.4 mi east of the office. I-26, I-526 and US 52 (Rivers Ave) all run through the city. |
| "The Ashley Phosphate Road interchange with I-26" | PAGE body; TEMPLATE essay | **Confirmed** | Wikipedia I-26 exit list: Exit 209A/B, Ashley Phosphate Road. "One of the area's busiest shopping corridors" is hedged ("one of"). |
| "I-26 carries commuters from Summerville and Goose Creek into Charleston" | PAGE body | **Confirmed** | I-26 has exits for Summerville (197, 199) and Goose Creek (205). |
| "car accidents near Ladson and I-26 Exit 203" (a link title) | PAGE body | **Confirmed** | Exit 203 is College Park Road – Ladson. |
| Map embed and NAP | TEMPLATE | **Confirmed** | Nominatim: "2703, Spruill Avenue, Union Heights, North Charleston, 29405" at 32.84732, -79.96120. That matches the LocalBusiness `geo` exactly. The caller verified that the place ID resolves to 2703 Spruill Ave. |
| "near Park Circle" | PAGE body; TEMPLATE `directions` | **Not supported. See W1.** | The office geocodes to **Union Heights**. Park Circle (the neighborhood centroid, 32.8816, -79.9764) is about 2.5 mi (4 km) north, and the circle itself is about 2.7 mi away. |

---

## WARN (page and template; low)

### W1. "Near Park Circle" places the office about 2.5 miles from where it is

- **Where it renders:**
  - PAGE body, "A South Carolina lawyer on your case." bullet.
  - TEMPLATE `directions` ("Getting here:"). This also renders on the North Charleston hub and on every North Charleston intersection, so it is live today.
- **Published:**
  - PAGE: "Your case is handled under South Carolina law by attorneys licensed here, from our office at 2703 Spruill Avenue, near Park Circle."
  - TEMPLATE: "Our North Charleston office is at 2703 Spruill Avenue, near Park Circle. Free client parking is available on site."
- **Issue:** the address geocodes to Union Heights (see the facts table). Park Circle is about 2.5 mi north. The pre-#188 wording ("in the Park Circle area") was the same claim, so this is not new.
  - The "Park Circle and the port routes" section is a road description, not an office location, and can stay.
- **Corrected (PAGE):** "Your case is handled under South Carolina law by attorneys licensed here, from our office at 2703 Spruill Avenue in North Charleston."
- **Corrected (TEMPLATE):** "Our North Charleston office is at 2703 Spruill Avenue, in the Union Heights neighborhood. Free client parking is available on site."
  - Or simply drop ", near Park Circle". The owner's GBP category or listing may use "Park Circle" as a marketing area; if it does, keep the GBP and the page consistent.
- **Authority:** n/a (not law). **Rule:** none. **Severity:** low.

### W2. The essay's venue line has no Berkeley/Dorchester hedge

- **Where it renders:** TEMPLATE `local_context` and `local_context_es` (North Charleston intersections).
- **Published:** "North Charleston personal injury cases are usually filed in the **Charleston County Court of Common Pleas at 100 Broad Street downtown**, through the South Carolina Judicial Branch's e-filing system."
- **Issue:** "usually" makes it true. But the page body and FAQ 5 carry the Berkeley/Dorchester sentence, and the essay also renders on the North Charleston truck and other intersections that have no such sentence of their own.
- **Corrected (optional):** "…through the South Carolina Judicial Branch's e-filing system; a crash in the Berkeley or Dorchester County part of the city may be filed in that county instead."
  - ES: "…a través del sistema de presentación electrónica del Poder Judicial de Carolina del Sur; un choque en la parte de la ciudad situada en el condado de Berkeley o de Dorchester puede presentarse en ese condado."
- **Authority:** n/a. No venue authority is in the pack, and the sentence is hedged and names no statute.
- **Severity:** low. Optional.

### W3. "Our North Charleston Attorneys" renders as an empty heading

- **Where it renders:** TEMPLATE, `template-intersection.php:633` (`roden_attorneys_grid( office_key => 'north-charleston' )`).
- **Issue:** the H2 is followed by nothing. The attorney CPT query returns no one for this office, although firm-data `offices.north-charleston.attorneys` lists `graeham-gillin`. On the Columbia page the same block rendered Ivy S. Montano.
  - There is no legal claim. The body's "attorneys licensed here" is true of the firm (Gillin and Montano are SC-barred per `client.json`).
- **Fix:** assign the attorney CPT posts to the office, or suppress the H2 when the grid is empty. If you do the latter, do it in all four practice-area templates.
- **Severity:** low, presentation only.

Carried, not new: the statewide uplink points at `/south-carolina-car-accident-lawyer/` (post 4536). That is a template-rendered `page` with 0 characters of `post_content`, so no sweep can see it. This is the same gap as Columbia's W3.

---

## LINKED (do not block this publish)

All eleven sentences below were replayed through the engine and returned nothing (`scratchpad/nchs-linked-fixture.json`, 12/12 with a § 56-5-1210 control that fired). They are false negatives, not clean.

### L1. Hit-and-run post: wrong grade of offense; UM/UIM wrong both ways (live, error class)

- **Page:** `/blog/north-charleston-crime-rate-hit-and-run/` (post 4645, `_roden_jurisdiction: sc`, author meta Graeham C. Gillin, `lastReviewed` empty). It is linked from the body ("hit-and-run accidents in North Charleston").
- **Published (body, "SC Hit-and-Run Criminal Penalties"):** "Leaving the scene of an accident involving injury is a felony in South Carolina (S.C. Code § 56-5-1210), carrying up to 25 years in prison if the crash resulted in death."
  - § 56-5-1210(A)(1) makes it a **misdemeanor** (30 days to 1 year) when "injury results but great bodily injury or death does not result". It is a felony only for great bodily injury (up to 10 years) or death (1 to 25 years).
  - **Corrected:** "Leaving the scene of a crash that injures someone is a crime in South Carolina (S.C. Code § 56-5-1210): a misdemeanor for an injury, a felony carrying up to 10 years when the injury is great bodily injury, and a felony carrying up to 25 years when someone dies."
  - Authority `SC 56-5-1210` (its claim carries all three tiers).
- **Published (key takeaways):** "South Carolina requires UM/UIM coverage on every auto policy."
  - UIM is only offered.
  - **Corrected:** "South Carolina requires uninsured motorist (UM) coverage on every auto policy (S.C. Code § 38-77-150); underinsured motorist (UIM) coverage must be offered but can be declined (S.C. Code § 38-77-160)."
- **Published (body, UM key points):** "SC law requires insurers to offer UM coverage on every auto policy"
  - UM is mandatory, not merely offered. This line contradicts the post's own key takeaways and this page.
  - **Corrected:** "SC law requires UM coverage on every auto policy (S.C. Code § 38-77-150)"
- Authority `SC 38-77-150`, `SC 38-77-160`.
- **Same post, not law:** "a crime rate of 47 per 1,000 residents — one of the highest in America", "research links elevated crime rates to drivers' willingness to flee" and "an approximately 9% uninsured driver rate" are unsourced. Source them or cut them.
- **Severity:** **error on a live page.** Fix it before or with this publish.
- **Fix path:** `bin/` patcher. Use exact-match `str_replace` on `post_content`, and the key-takeaways meta through `update_post_meta( …, wp_slash() )`. Build strings with no `$`. Then regenerate `content/meta.json` and run `bin/check-unslashed-post-writes.php`.

### L2. Dangerous-roads resource: § 15-78-80 cited for SCTCA liability and for the two-year deadline

- **Page:** `/resources/dangerous-roads-north-charleston/` (post 4617), linked from the body.
- **Published (FAQ "Can I sue the city…" + FAQPage):** "Under the South Carolina Tort Claims Act (S.C. Code § 15-78-80), government entities can be held liable for dangerous road conditions they knew or should have known about."
  - **Corrected:** "Under the South Carolina Tort Claims Act (S.C. Code § 15-78-10 et seq.), government entities can be held liable for dangerous road conditions they knew or should have known about."
  - The rest of that answer (§ 15-78-110 two years; optional verified claim under § 15-78-80) is correct.
- **Published (body):** "…but these run on a shorter deadline — two years from discovery rather than three — under the South Carolina Tort Claims Act ( S.C. Code § 15-78-80 )."
  - **Corrected:** "…but these run on a shorter deadline — two years from discovery rather than three — under the South Carolina Tort Claims Act (S.C. Code § 15-78-110), extended to three years only if a verified claim is filed with the agency within one year (S.C. Code § 15-78-80)."
- **Published (key takeaways):** "South Carolina's 3-year statute of limitations (S.C. Code § 15-3-530) applies to all injury claims on these roads, and government entities may share liability…"
  - "All" is wrong for the government claims the same sentence goes on to raise.
  - **Corrected:** "South Carolina's 3-year statute of limitations (S.C. Code § 15-3-530) applies to most injury claims on these roads; claims against government entities, which may share liability for known design deficiencies, generally must be filed within two years (S.C. Code § 15-78-110)."
- **Not law:** "a population exceeding 131,000" (2020 census: 114,852; verify against a current Census estimate or cut it) and "consistently ranks among the most dangerous areas in South Carolina" (unsourced).
- **Authority:** `SC 15-78-110`, `SC 15-78-80`, `SC 15-3-530`. **Rule:** none (the Columbia plan's proposed `sctca-caps-cited-to-15-78-80` covers caps, not deadlines; see pack item 3). **Severity:** warn.

### L3. Rivers Avenue post: § 56-5-3130 stated backwards

- **Page:** `/blog/rivers-avenue-pedestrian-deaths-north-charleston/` (post 4339, Gillin-attributed, `lastReviewed` 2026-09-02), linked from the body.
- **Published (body):** "Crosswalk rights (S.C. Code § 56-5-3130) — drivers must yield the right-of-way to pedestrians in marked crosswalks and at intersections with traffic signals"
  - § 56-5-3130(a) applies "**When traffic-control signals are not in place or not in operation**" (t56c005, read 2026-09-28). It covers any crosswalk, marked or unmarked. At signalized crossings the signals govern.
  - **Corrected:** "Crosswalk rights (S.C. Code § 56-5-3130) — where traffic signals are not in place or not working, drivers must yield to a pedestrian crossing within a crosswalk, marked or unmarked; at signalized crossings, drivers and pedestrians follow the signals"
- **Authority:** none in the pack. Propose `SC 56-5-3130` as pending (see pack item 6). The other pedestrian cites on the post (§ 56-5-3150(a), § 56-5-3230) match the primary text but also have no pack authority.
- **Not law:** "one of the deadliest pedestrian corridors in South Carolina" and "one of the highest per-capita pedestrian fatality rates of any city in South Carolina" are unsourced.
- **Severity:** warn.

### L4. The wrongful-death deadline is cited to § 15-51-20 (3 posts, 5 surfaces)

- **Published:** "For wrongful death claims, the deadline is three years from the date of death (S.C. Code § 15-51-20)." It appears in:
  - `/blog/ashley-phosphate-road-i-26-dangerous-intersection-charleston/` (4337): FAQ + FAQPage, and body.
  - `/blog/car-accidents-ladson-i-26-exit-203-danger-zone/` (4346): body ("South Carolina wrongful death — three years from date of death (S.C. Code § 15-51-20)").
  - `/blog/rivers-avenue-pedestrian-deaths-north-charleston/` (4339): FAQ + FAQPage, and body.
- **Issue:** the signed `SC 15-51-20` says only that the action "must be brought by the executor or administrator". The three-year period is § 15-3-530. "From the date of death" is an accrual rule with no pack authority.
- **Corrected:** "Wrongful death claims generally must also be filed within three years (S.C. Code § 15-3-530), and are brought by the personal representative of the estate (S.C. Code § 15-51-20)."
  - Keep "from the date of death" only after Gillin confirms it and a pack authority for § 15-3-530(6) is signed.
- **Authority:** `SC 15-3-530`, `SC 15-51-20`. **Rule:** none (proposed as item 4). **Severity:** warn.

### L5. Ladson post: SCTCA "notified", a town that does not exist, and wrong exit geography

- **Page:** `/blog/car-accidents-ladson-i-26-exit-203-danger-zone/` (4346, Gillin-attributed).
- **Published (body):** "An attorney familiar with all three counties can ensure your case is filed in the most favorable jurisdiction and that all necessary governmental entities are properly notified."
  - The SCTCA has no notice requirement. This is the `sctca-mandatory-notice` class in words the rule does not match.
  - **Corrected:** "An attorney familiar with all three counties can make sure your case is filed in the right county and on time, including the shorter two-year deadline that applies to claims against government entities (S.C. Code § 15-78-110)."
  - Authority `SC 15-78-80` (no mandatory notice), `SC 15-78-110`.
- **Published (body):** "…Dorchester County, or the Town of Ladson may bear responsibility…"
  - Ladson is an unincorporated census-designated place (Wikipedia *Ladson, South Carolina*). There is no Town of Ladson.
  - Corrected: "…Berkeley County, Dorchester County or Charleston County may bear responsibility…" (match the list the sentence starts with).
- **Published (body):** "US-17A (Old Orangeburg Road) and I-26 Exit 199 — the southern gateway to Ladson"
  - Exit 199 is US 17 Alternate at Summerville (Wikipedia I-26 exit list), which is north-west of Ladson (Exit 203), not south.
  - Corrected: "US 17 Alternate and I-26 Exit 199 — the Summerville interchange just north-west of Ladson"
- **Published (FAQ + body):** "any lawsuit must be filed in the county where the accident occurred or where the defendant resides"
  - Close to § 15-7-30(C) for an individual South Carolina defendant, but incomplete for businesses (principal place of business) and out-of-state drivers (the plaintiff's county).
  - Low. Optional: "generally may be filed in the county where the accident occurred or where the defendant lives or is based".
- **Severity:** warn (the notice line); low (the rest).

### L6. Settlement-value resource: "requires insurers to offer" UM; the damages-cap statement omits the SCTCA

- **Page:** `/resources/south-carolina-car-accident-settlement-value/` (4809), linked from the body.
- **Published (body):** "South Carolina requires insurers to offer uninsured motorist coverage, and UM/UIM steps in when the responsible driver is uninsured or carries only the $25,000 minimum."
  - **Corrected:** "South Carolina requires uninsured motorist coverage on every auto policy (S.C. Code § 38-77-150) and requires insurers to offer underinsured motorist coverage (S.C. Code § 38-77-160); UM/UIM steps in when the responsible driver is uninsured or carries only the $25,000 minimum."
  - Build it without a literal `$` in any `preg_replace`; use `str_replace` with a nowdoc.
- **Published (key takeaways, body):** "…with no general cap on damages in ordinary auto cases"; "the statutory non-economic cap applies only to medical malpractice claims, not to car crashes."
  - This omits the $300,000 / $600,000 cap on claims against a government entity (§ 15-78-120), which this page states.
  - Low. Append: "(claims against a government entity are capped at $300,000 per person and $600,000 per occurrence, S.C. Code § 15-78-120)".
- The punitive paragraph is **correct**: § 15-32-530, "$739,245, the 2026 inflation-indexed figure", "subject to statutory exceptions".
- **Authority:** `SC 38-77-150`, `SC 38-77-160`, `SC 15-78-120`. **Severity:** warn.

### L7. Ashley Phosphate post: "applies to all claims", and a garbled section sign

- **Page:** 4337, key takeaways: "…the three-year statute of limitations (S.C. Code SS 15-3-530) applies to all claims."
  - "All" contradicts the post's own SCTCA sentence (two years).
  - "SS" is a mangled "§". The same "SS" appears in the Rivers Avenue key takeaways (4339).
  - **Corrected:** "…the three-year statute of limitations (S.C. Code § 15-3-530) applies to most claims, and claims against a government entity generally have two years (S.C. Code § 15-78-110)."
  - 4339 key takeaways: "(S.C. Code SS 15-3-530)" → "(S.C. Code § 15-3-530)".
- **Not law:** "traffic camera footage is typically overwritten within 30-72 hours" and "roughly 40% more distance to stop" are unsourced.
- **Severity:** warn, low.

### L8. Case-type sub-pages: SCTCA "notice" wording is still live (carried from the Columbia plan, L6), plus one caps residue

- **`/car-accident-lawyers/commercial-vehicle-accident/` FAQ:** "You may file a claim against the government entity, but strict notice requirements and shorter filing deadlines apply."
  - Still unfixed. Use the Columbia L6 correction.
- **`/car-accident-lawyers/bus-accident/` FAQ:** "If the bus was operated by a government entity, shorter notice deadlines may apply."
  - Still unfixed. Use the Columbia L6 correction.
- **`/car-accident-lawyers/government-vehicle-accident/` FAQ "Are there damage caps…" + FAQPage:** "South Carolina caps recovery at $300,000 per claimant and $600,000 per occurrence against a single government entity."
  - The body was corrected (L1 of the Columbia plan: "however many government entities are involved"). This FAQ still implies a different cap for several entities, so the body and the structured data now disagree.
  - **Corrected:** "South Carolina caps recovery at $300,000 per person and $600,000 per occurrence, however many government entities are involved (S.C. Code § 15-78-120)."
  - Same page, body intro: "These cases demand strict compliance with notice deadlines and filing procedures." This is unscoped on a two-state page. Low: "…with notice deadlines (in Georgia and federal claims) and filing deadlines."
- Every surface is linked from the case-types grid and the sidebar.
- **Authority:** `SC 15-78-80`, `SC 15-78-110`, `SC 15-78-120`. **Severity:** warn.

### L9. Statewide pages

- `/south-carolina-car-accident-lawyers/` (post 4846, in site navigation) FAQ + body: "allows stacking of UM and underinsured (UIM) coverage in many situations".
  - It is hedged, but it does not mention the § 38-77-160 limit on excess coverage when the insured's own vehicle is not involved. That is the stacking class already on the Gillin list.
  - Low.
- The uplink target 4536 cannot be seen by any sweep (see "Carried" under W3).

### Clean on the classes checked

- `/resources/south-carolina-liquor-liability-2026/` (5355) states the 2026 amendment to § 15-38-15(F) correctly: alcohol and gross negligence came out; "wilful, wanton, reckless, or intentional" and illegal drugs remain. It also correctly says the (A) fifty-percent threshold and the plaintiff's bar are unchanged, and it gives the effective-date rule.
- `/blog/car-accidents-on-i-26-in-north-charleston/` (3435): SOL "generally three years", nothing else legal.
- `/blog/pedestrian-safety-park-circle-north-charleston/` (4642): SOL and fault are correct. § 56-5-3230 matches the text (no pack authority). "A documented high-collision spot" is unsourced (low).

### L10. Spanish twin (post 4906)

- `_roden_translation_es: 4906` is set on 4540. 4906 is not published: it is absent from the export and from `content/meta.json`.
- Do not publish it until it is rebuilt from this copy and swept. The `local_context_es` it would render is already consistent with the EN essay.
- **Severity:** info.

---

## Checks that PASS

| Check | Result |
|---|---|
| South Carolina only | There is **no Georgia law** on the page or in its 7 JSON-LD blocks. The pillar intros render their SC branch. The firm-level "Georgia & South Carolina" CTA text and the stats are accepted boilerplate. |
| SOL | 3 years, § 15-3-530, the same in the key takeaways, FAQ 2, law box, essay, negligence intro and sidebar. "Generally" and "usually ends your right to recover" are used. |
| Government entity | Two years under § 15-78-110 (from loss or discovery), with an optional verified claim within one year that extends it to three (§ 15-78-80), in the body, key takeaways and FAQ 2. $300,000 / $600,000 and no punitive damages under § 15-78-120. There is **no "notice" wording** anywhere on the page. |
| Comparative fault | *Nelson* (in full in the law box). § 15-38-15 appears nowhere. "50% or less", "less than 51%", "51%-bar" and "51% or more … bars" are all equivalent. |
| Insurance | 25/50/25 under § 38-77-140; UM mandatory under § 38-77-150; UIM offered under § 38-77-160; the § 38-77-170 police report and corroboration. There is **no stacking claim**. |
| Damages | The compensation intro states the SCTCA cap as the exception, with no "no cap" overstatement and no punitive figure. |
| Police-report step and HowTo | § 56-5-1260 / § 56-5-1270 match the signed pack. Step 5 and HowTo step 5 are identical. |
| FAQ vs FAQPage JSON-LD | All 6 answers match the rendered text character for character. |
| Excerpt / meta description / LegalService and HowTo descriptions | These are marketing only, with no legal claim. |
| Essay (#188) | "Hazard profile is dominated by", "recurring crash corridors" and "flown to MUSC" are gone. There is no statistic, no SCTCA sentence and no "only Level I". The ES text is equivalent. |
| Directions (#188) | The unverifiable Exit 213 / Montague turns are gone. Only the address remains (see W1 for "near Park Circle"). |
| Statistics | No numeric crash statistic on the page. |
| Citation format | Every cite is `S.C. Code § …`. The two scstatehouse.gov links point to `t15c078` and `t38c077`. |
| JSON-LD validity | 7/7 blocks parse. |
| Firm boilerplate (accepted or owner-deferred; not re-raised) | The stats block, the unfiltered case-results grid, the statewide uplink's "comparative-fault rule" and the bottom CTA's "believe another party is at fault". |

## Counts by rule

| Rule | Findings | Severity |
|---|---:|---|
| (engine) all SC + GA rules, 48 blocks + control | 0 | — |
| Hand: office location claim not supported (Park Circle) | 1 (2 surfaces) | warn, low |
| Hand: venue line without the county hedge (essay) | 1 | warn, low |
| Hand: empty template block (attorneys) | 1 | warn, low |
| Hand, LINKED: hit-and-run grade misstated; UM/UIM mandatory vs offered | 1 (3 surfaces) | **error (live)** |
| Hand, LINKED: § 15-78-80 cited for liability and deadline; "applies to all" | 1 | warn |
| Hand, LINKED: § 56-5-3130 inverted | 1 | warn |
| Hand, LINKED: wrongful-death deadline cited to § 15-51-20 | 1 (3 posts, 5 surfaces) | warn |
| Hand, LINKED: SCTCA "notified", Town of Ladson, exit geography | 1 | warn |
| Hand, LINKED: UM "offer"; cap statement omits SCTCA | 1 | warn |
| Hand, LINKED: "applies to all claims"; "SS" | 1 | warn, low |
| Hand, LINKED: sub-type notice wording; gov-vehicle FAQ caps residue | 1 (3 pages) | warn |
| Hand, LINKED: statewide stacking | 1 | low |
| Hand: untranslated twin | 1 | info |
| **Total** | **14** (0 page errors, 3 page warnings, 1 linked error, 9 linked warnings, 1 info) | |

Source split:
- **PAGE:** W1 (body bullet).
- **TEMPLATE:** W1 (`directions`), W2, W3.
- **LINKED:** L1–L9. **Other:** L10.

## False positives

None. The engine raised nothing. The linked sentences above are **false negatives**, confirmed 11/11 by `scratchpad/nchs-linked-fixture.json`. They go to an `internal-ai-scripts` PR, never to a content edit alone.

## Pack changes (proposed; not made)

Fixtures come first, in `law/fixtures/`. Re-run both fixture sets to 100% before merging.

1. **New rule `sc-hit-and-run-injury-felony` (error, SC).**
   - **Positive:** L1 sentence 1.
   - **Controls:** the corrected L1 sentence; "a felony when great bodily injury results".
   - **Pattern:** `(?:leav|flee)\w*[^.]{0,40}scene[^.]{0,60}injur\w*[^.]{0,20}\bis\s+a\s+felony`, with `unless` `great\s+bodily|serious\s+bodily|death\s+results`.
   - Backed by `SC 56-5-1210`.
2. **New rules `sc-uim-stated-mandatory` and `sc-um-stated-offer-only` (error, SC).**
   - **Positives:** L1 key takeaways ("requires UM/UIM coverage on every auto policy"); L1 body and L6 ("requires insurers to offer (UM|uninsured motorist) coverage").
   - **Controls:** this page's "Every South Carolina auto policy must include uninsured motorist coverage … insurers must offer underinsured motorist coverage".
   - Backed by `SC 38-77-150`, `SC 38-77-160`.
3. **Extend the Columbia plan's proposed `sctca-caps-cited-to-15-78-80` to deadlines and to the Act itself.**
   - **Positives:** L2 (FAQ and body).
   - **Controls:** the pack's § 15-78-80 wording and this page's § 15-78-80 sentence (optional verified claim, three years).
   - **Pattern:** `(?:two|2)[- ]years?[^.]{0,120}\(\s*S\.C\. Code §\s*15-78-80\s*\)` with `unless` `15-78-110`, and `Tort Claims Act\s*\(S\.C\. Code §\s*15-78-80\)`.
4. **New rule `sc-wrongful-death-sol-cited-to-15-51-20` (warn, SC).**
   - **Positive:** L4.
   - **Control:** the corrected L4 sentence.
   - **Pattern:** `wrongful death[^.]{0,80}(?:three|3)\s+years[^.]{0,60}15-51-20`.
5. **Extend `sctca-mandatory-notice` to "governmental entities are properly notified"** (L5), with a Georgia/FTCA/ante-litem `unless`.
6. **Pending authorities (`verifiedBy: null`, for Gillin's packet):**
   - `SC 56-5-3130`: drivers yield to pedestrians in crosswalks where signals are not in place or not operating. Evidence: scstatehouse.gov/code/t56c005.php.
   - `SC 56-5-3150` and `SC 56-5-3230`: already cited on live posts.
   - `SC 15-7-30` + `SC 15-78-100(b)`: venue. A proper venue is the county of the act or omission, or the defendant's residence or principal place of business; SCTCA suits must be brought in the county of the act. Evidence: t15c007.php, t15c078.php. Needed only if a page is to cite venue.
   - `SC 15-3-530(6)`: wrongful death, three years, with accrual confirmed by Gillin.

After any pack change: `node scripts/facts/vendor.mjs rodenlaw --write` if the client vendors the pack, then `--check`.

## Before publish

1. Optional page and template edits:
   - W1: `bin/rebuild-north-charleston-car-accident.php` body bullet, and firm-data `directions`.
   - W2: firm-data essay, EN and ES.
   - W3: template.
   - Re-run the script against the draft, re-render, and replay `scratchpad/draft4540-fixture.json` (48 entries).
2. **Recommended in the same batch:** fix L1 (the hit-and-run post) and the L8 government-vehicle FAQ residue through a `bin/` patcher and `bin/apply-faq-remediation.php`. Then regenerate `content/meta.json` and run `bin/check-unslashed-post-writes.php`.
3. Gillin reviews and signs off the page. Only then set `$reviewed` in `bin/publish-north-charleston-car-accident.php`, which removes `_roden_retired` and sets `_roden_last_reviewed`. Leave post 4906 unpublished (L10).
4. Separately:
   - L2–L7 and L9 go to a North Charleston linked-posts batch.
   - The L8 sub-type FAQs go with the Columbia L6 items.
   - Wrongful-death accrual (L4) and § 56-5-3130 (L3) go to Gillin's packet.
   - The Georgia comparison sentences on 4337, 4339 and 4346 are outside this sweep and go to the Georgia reviewer.
