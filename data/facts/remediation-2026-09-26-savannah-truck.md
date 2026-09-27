# Pre-publish legal sweep: Savannah truck accident page (post 3627, DRAFT)

- **Page:** `/truck-accident-lawyers/savannah-ga/` (post 3627, `practice_area`, draft; parent: truck pillar, post 3605).
- **Jurisdiction:** Georgia only. Author and reviewer of record: Eric Roden (GA Bar).
- **What was swept:** the rendered draft HTML (`scratchpad/preview/draft3627.html`) and all 7 JSON-LD blocks in it (LegalService, Person, FAQPage, WebPage, HowTo, LocalBusiness/LegalService/LawFirm, BreadcrumbList). All 7 parse.
  - **Page surfaces**, from `bin/rebuild-savannah-truck-accident.php`: body, excerpt (also the LegalService `description` and the definition block), meta description, key takeaways, 6 FAQs.
  - **Template blocks:** hero, NAP bar, office block and directions, law box, what-to-do steps and HowTo, the Savannah local-context essay, the truck pillar's `{{GA}}` negligence and compensation intros (as corrected today by `bin/fix-truck-pillar-intros.php` pass 3), stats block, resources, sidebar, footer.
- **Pack:** `law/GA.json` at `internal-ai-scripts` `origin/main` (`47edf53` is the last GA change). It is **signed** (`signOff.status: "signed"`, `verifiedBy` set on all 22 authorities). For Roden, Georgia claims are signed off by Eric Roden.
- **Engine run:**
  - 135 blocks (121 rendered-text blocks, 6 FAQPage answers, 7 HowTo steps, the LegalService description) were replayed through `sweep-claims.mjs --fixtures scratchpad/draft3627-fixture.json --law scratchpad/law-main3627`, once with `--states GA,SC` and once with `--states GA`.
  - Result: **0 findings** (136/136 expectations met).
  - A positive control (a city claim given twelve months under § 36-33-5) fired `municipal-ante-litem-12-months`, which confirms the rules were loaded.
  - Every finding below comes from hand reading, by claim class.
- **Reused from the Savannah car sweep** (`remediation-2026-09-26-savannah-car.md`, PASS, fixes shipped in #172): the office directions, the essay's courthouse and Memorial Health sentences, and step 5. These render identically here. The LifeStar sentence is gone, and the resources block is Georgia-only.

**Verdict: PASS. No error-level finding.**
- There are 3 warnings: 1 TEMPLATE, 1 PAGE, and 1 PAGE + TEMPLATE.
- W1 is the one to fix before publish. It states a punitive-damages basis in words Georgia law treats as insufficient, and it cites no authority.

Source key:
- **PAGE** means `bin/rebuild-savannah-truck-accident.php`.
- **TEMPLATE** means the theme, `inc/firm-data.php`, or truck-pillar meta (post 3605). A TEMPLATE fix reaches other pages too.

---

## WARN

### W1. The GA punitive-damages sentence names "gross" failures and states no standard

- **Surface / block:** body, "Types of Compensation in Georgia Truck Accident Cases".
- **Source:** TEMPLATE. This is the truck pillar (post 3605) `_roden_pillar_compensation_intro`, `{{GA}}` branch, as left by `bin/fix-truck-pillar-intros.php` pass 3. It will render on every Georgia truck intersection.
- **Published:** "Falsified logs, hours-of-service violations, and gross safety-management failures can support a claim for punitive damages."
- **Corrected:** "Where falsified logs, hours-of-service violations or other safety failures show willful misconduct or a conscious indifference to the consequences, they can support a claim for punitive damages, which must be proven by clear and convincing evidence (O.C.G.A. § 51-12-5.1(b))."
- **Why:**
  - Under § 51-12-5.1(b), punitive damages require clear and convincing proof of willful misconduct, malice, fraud, wantonness, oppression, or "that entire want of care which would raise the presumption of conscious indifference to consequences."
  - Georgia courts hold that negligence, even gross negligence, will not support punitive damages (e.g. *Colonial Pipeline Co. v. Brown*, 258 Ga. 115 (1988)).
  - "Gross safety-management failures" names exactly the insufficient standard. An hours-of-service violation alone is ordinary negligence evidence. A knowing violation or falsified logs is what reaches the statute.
  - Pass 3 correctly removed the $250,000 figure and the § 51-12-5.1(f) cite, but the claim itself was left uncited.
- **Authority:** **none in the GA pack.** It is proposed below as a pending authority (`verifiedBy: null`).
  - Until Eric Roden signs it, choose one:
    - (a) remove the sentence from the `{{GA}}` branch; or
    - (b) ship the corrected sentence under his page review.
  - No dollar figure may be added either way (house rule).
- **Rule:** none. There is no punitive rule in the GA pack.
- **Severity:** warn (medium). "Can support" is hedged, but the named basis is the one Georgia excludes.
- **Fix path:** a `bin/` patcher on post 3605 meta with an exact-match `str_replace` inside the `{{GA}}` branch and `wp_slash`. The `{{SC}}` branch (Charleston W3) is untouched.

### W2. "Work zones at the I-16 interchange" is time-sensitive and unconfirmed

- **Surface / block:** body, "Why Savannah Sees So Many Truck Crashes" > "I-95 and the I-16 / I-95 interchange".
- **Source:** PAGE, `bin/rebuild-savannah-truck-accident.php`, the `<h3>I-95 and the I-16 / I-95 interchange</h3>` paragraph.
- **Published:** "I-95 carries interstate freight past Pooler and Richmond Hill, and work zones at the I-16 interchange change lane patterns for heavy trucks."
- **Corrected:** "I-95 carries interstate freight past Pooler and Richmond Hill, and its interchange with I-16, reconfigured by GDOT's 16@95 improvement project, moves heavy trucks between the two interstates."
- **Why:**
  - GDOT's 16@95 project (the turbine ramps at I-16 exit 157, the I-95 NB collector-distributor road, and I-16 widening to I-516) opened its new ramps in March and June 2023.
  - It was still under construction in January 2024.
  - Its status in September 2026 could not be confirmed from here (GDOT GeoPI returned 200 without project data). The present-tense "work zones … change lane patterns" may already be stale. The corrected wording is true whether or not work continues.
- **Authority:** none (a local fact, not law). Secondary source: the Interstate 16 route history citing GDOT, WTOC and the Savannah Morning News.
- **Related, not in scope:** the linked resource `/resources/i-16-i-95-construction-zone-truck-accidents/` carries the same time-sensitivity.

### W3. Federal claims with no pack authority (the claims are true; the authority is missing)

- **Surface / block:**
  - PAGE, body "Who Can Be Responsible for a Savannah Truck Crash": "Federal safety rules for commercial trucks, covering hours of service, driver qualification, vehicle inspection and maintenance, and drug and alcohol testing, are set by the Federal Motor Carrier Safety Administration. A violation can be strong evidence that the driver or the carrier was careless."
  - TEMPLATE, pillar `{{GA}}` negligence intro: "…the Federal Motor Carrier Safety Regulations govern hours of service, driver qualification, vehicle maintenance, and drug and alcohol testing…"
  - Broker liability appears in 6 places: the meta description and LegalService description ("handle Georgia truck claims against drivers, carriers and brokers"), the excerpt, the KT, FAQ 3, and the body twice.
- **Corrected:** no change to the wording.
  - All of it is generic.
  - There are no hours figures, no ELD retention period, no MCS-90 amounts and no 49 C.F.R. section numbers.
  - Broker liability is hedged ("where the facts support it", "depending on the facts").
  - The same statements were checked against primary text on the Charleston truck sweep (W4): eCFR Title 49, Parts 382, 391, 395 and 396, and *Montgomery v. Caribe Transport II, LLC*, No. 24-1238 (U.S. May 14, 2026).
- **Authority:** none in any pack. The two federal pending authorities proposed on 2026-09-26 are **not yet on `internal-ai-scripts` origin/main** (`git grep` for Montgomery/14501 under `law/` returns nothing). Eric Roden's page review is the only attorney check these statements get until they land.
- **Rule:** n/a.

---

## Checks that PASS

| Check | Result |
|---|---|
| No SC law | **PASS.** No `S.C. Code`, no § 15-3-530, no SCTCA, no "51%", no "50% or less", no "neighboring states", no stacking, in the HTML or JSON-LD. SC appears only at firm level: the header, the office list, "Licensed in GA & SC", the footer disclaimer, and "South Carolina Rule 7.4(b)" in the disclaimer. |
| No punitive dollar figures | **PASS.** No $250,000, no "§ 51-12-5.1(f)", no MCS-90. The only punitive statement is W1. The only dollar figures are the § 33-7-11 minimums and the firm stats and case results (out of scope). |
| Cite format | **PASS.** All 23 visible and JSON-LD cites are `O.C.G.A. § X-X-XX`: §§ 9-3-32, 9-3-33, 33-7-11, 36-11-1, 36-33-5, 40-6-270, 50-21-26, 51-12-33. There is no "OCGA", no "Ga. Code Ann." and no "§§". |
| 50% bar, § 51-12-33 | **PASS, consistent on 6 surfaces.** KT: "bars recovery if you are 50% or more at fault; below that, your award is reduced by your share". FAQ 4 and schema: "Yes, if you were less than 50% at fault. Georgia bars recovery at 50% or more". Law box: "recover if less than 50% at fault". Essay: "bars recovery only if the plaintiff is 50% or more at fault". § 51-11-7 is not cited. Joint and several liability is not mentioned. |
| § 9-3-33 vs § 9-3-32 | **PASS.** Two years for injury appears in the KT, essay, pillar intro ("generally"), law box, sidebar ("usually ends") and FAQ 2. Four years for vehicle damage appears in FAQ 2 only, attributed to § 9-3-32. No workers' comp context. |
| Ante litem | **PASS.** City: six months, § 36-33-5 (body, KT, FAQ 5). County: twelve months, § 36-11-1 (body, FAQ 5; the KT has it without a cite). State: twelve months, § 50-21-26 (body; KT). None is swapped, and the GTCA is not given six months. The KT line "against a county or the State within twelve months" was replayed and clears `municipal-ante-litem-12-months` on its county guard, correctly. |
| § 33-7-11 "must offer" | **PASS.** Body: "Georgia insurers must offer uninsured motorist coverage (O.C.G.A. § 33-7-11)". Essay: 25/50 limits plus "insurers must offer". UM is never called mandatory. (The wording question is out of scope; see car INFO 2.) |
| FMCSA statements | **PASS as generic** (see W3). Nothing specific appears without a source. |
| Garden City Terminal and freight corridors | **PASS.** gaports.com returned 403 to a plain request (no personal data sent), so this was verified from secondary sources. Garden City Terminal is the Georgia Ports Authority's dedicated container terminal at the Port of Savannah. I-516 begins in Garden City as the freeway continuation of SR 21 and ends at DeRenne Avenue on the southside. The Jimmy DeLoach Parkway has an interchange with I-95 (exit 106, the "Jimmy DeLoach Connector"), built as the port connector. Dean Forest Road is SR 307, running from Garden City to I-16 and on to Bourne Avenue near the airport. I-95 passes Pooler and Richmond Hill. "Warehouse district west of the city" is consistent with that. W2 is the only time-sensitive corridor claim. |
| Pillar `{{GA}}` text | **PASS except W1.** Negligence intro: the § 40-1-112 drafting note ("verify current posture before filing") no longer renders, and no `{{`/`}}` tokens or `**` leak. Compensation intro: no $250,000 and no § 51-12-5.1(f); the remaining sentence is W1. |
| No-fault / PIP / thresholds | **PASS.** None appear. |
| Step 5 / HowTo 5 | Identical to the car page and to the pack claim (the § 40-6-270 scope question is out of scope). |
| Essay, directions, courthouse | Identical template text to the car sweep. The directions were verified there. "133 Montgomery Street" is the Chatham County courthouse complex. Memorial Health is "a Level I trauma center" with no "only" and no LifeStar. |
| FAQ vs FAQPage JSON-LD | All 6 match character for character. |
| Steps vs HowTo JSON-LD | Identical. |
| Author / reviewer | Eric Roden, with the State Bar of Georgia credential in Person schema. The rebuild script leaves `_roden_last_reviewed` unset. |

## INFO (no change required)

1. **Federal court.** "Savannah truck accident lawsuits are usually filed at the Chatham County Courthouse" is hedged and true for filing. Claims against out-of-state carriers are often removed to the U.S. District Court for the Southern District of Georgia (Savannah Division) on diversity. Optional addition: "…or, when the carrier is from out of state, may be moved to federal court in Savannah." There is no pack authority, so it is not a finding.
2. **Federal vehicles.** The ante litem subsection is scoped to "a city, county or the State" and is accurate as scoped. A crash with a federal truck (military, USPS) is under the FTCA, which requires an administrative claim within two years (28 U.S.C. § 2401(b)). The page does not claim otherwise.
3. **"Abercorn Street (SR 204)"** in the essay is still the optional car-sweep W2 item, not re-raised.
4. **"Last updated: September 27, 2026"** is a UTC `dateModified` (2026-09-27T02:24Z). It re-stamps on publish.
5. **Resources block:** Georgia moped and helmet guides on a truck page. This is relevance, not legal accuracy.

## Counts by rule

| Rule | Findings | Severity |
|---|---:|---|
| (engine) all GA + SC rules, signed GA pack | 0 | none |
| Hand: punitive standard misstated / uncited | 1 (W1) | warn (medium) |
| Hand: time-sensitive local fact | 1 (W2) | warn (low) |
| Hand: federal claims without pack authority (verified true) | 1 (W3) | warn (low) |
| **Total** | **3**, 0 errors | |

Source split:
- **TEMPLATE:** W1, and the pillar half of W3.
- **PAGE:** W2, and the body/FAQ/meta half of W3.

## False positives

None. The engine raised nothing on the page, and the one positive control fired as intended. No `unless` guard is needed.

## Pack additions (to an `internal-ai-scripts` PR, `verifiedBy: null`, for Eric Roden's review for Roden)

1. **`GA 51-12-5.1`** (new)
   - `cite`: "O.C.G.A. § 51-12-5.1"
   - `subject`: "punitive damages standard"
   - `claim`: "Punitive damages require clear and convincing evidence of willful misconduct, malice, fraud, wantonness, oppression, or that entire want of care which would raise the presumption of conscious indifference to consequences. Negligence, even gross negligence, is not enough."
   - `quantities`: []
   - `evidence`: `https://law.justia.com/codes/georgia/title-51/chapter-12/article-1/section-51-12-5-1/`. **Not retrieved from here:** Justia returned a 403 challenge, ga.elaws.us a 503 and casetext a 410. The claim text is from the statute as commonly quoted and must be read against primary text before signing.
   - The subsection (g) cap and the (e)/(f) exceptions are deliberately left out of the claim, because the house rule is no punitive figures.
   - Candidate rule for later, once signed: a GA sentence that ties punitive damages to "gross negligence" or "gross … failures" without the (b) standard.
2. **The two federal pending authorities** from the Charleston truck sweep (FMCSR Parts 382/391/395/396; *Montgomery v. Caribe Transport II*) are still unfiled. They cover W3 on this page too.

## Before publish

1. TEMPLATE: fix W1 on post 3605 `_roden_pillar_compensation_intro`, `{{GA}}` branch, by a `bin/` patcher (exact-match `str_replace`, `wp_slash`). Use option (a) or (b) above.
2. PAGE: apply W2 in `bin/rebuild-savannah-truck-accident.php` and re-run it. It stays a draft.
3. Re-render the draft and replay `scratchpad/draft3627-fixture.json` with `--law` at `origin/main`.
4. Eric Roden reviews the page, including W1 and W3. Only then set `_roden_last_reviewed` and publish.
