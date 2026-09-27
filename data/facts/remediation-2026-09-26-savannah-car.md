# Pre-publish legal sweep: Savannah car accident page (post 3622, DRAFT)

- **Page:** `/car-accident-lawyers/savannah-ga/` (post 3622, `practice_area`, draft).
- **Jurisdiction:** Georgia only. Author and reviewer of record: Eric Roden (GA Bar).
- **Swept:** the rendered draft HTML (`scratchpad/preview/draft3622.html`) and all seven JSON-LD blocks in it (LegalService, Person, FAQPage, WebPage, HowTo, LocalBusiness/LegalService/LawFirm, BreadcrumbList). All seven parse.
  - The page's own surfaces, from `bin/rebuild-savannah-car-accident.php`: body, excerpt, meta description, key takeaways and FAQs.
  - The template blocks: hero, NAP bar, office block and directions (theme #170), law box, what-to-do steps (step 5 from #171), the Savannah local-context essay (theme #170), the GA branches of the car pillar's negligence and compensation intros (post 3604), stats block, resources, sidebar and footer.
- **Sweep method:** by claim class, not by string.
  - Engine run: 28 blocks (20 body/KT/sidebar blocks, 6 FAQs, the HowTo, the meta description) replayed through `sweep-claims.mjs --fixtures` against the origin/main packs, `--states GA,SC` and again `--states GA`. It returned **0 findings** (fixture: `scratchpad/draft3622-fixture.json`).
  - Every claim class the brief named was then checked by hand. Results are below.
- **Pack state:** the GA pack is **signed** (`signOff.status: "signed"`, every authority `verifiedBy` set). For Roden, Georgia claims are signed off by Eric Roden (owner confirmed 2026-09-26). Every legal sentence on this page matches a signed GA pack authority.

**Verdict: PASS.** There are no error-level findings. There are four low-severity warnings: two in the page and two in the template. None misstates Georgia law. Fix them before or after publish at the owner's choice.

Source key:
- **PAGE** means `bin/rebuild-savannah-car-accident.php`.
- **TEMPLATE** means the theme or parent-pillar meta, so a fix also reaches other pages.

---

## Claim classes checked

| Check | Result |
|---|---|
| South Carolina law on the page | **PASS.** No `S.C. Code`, no § 15-3-530, no § 15-38-15, no SCTCA, no "51%", no "50% or less", no "stacking" anywhere in the HTML or JSON-LD. The only SC mentions are firm-level ("Georgia & South Carolina", "Licensed in GA & SC", the footer, the site disclaimer) and one resources link (W3). |
| Punitive damages | **PASS.** The word "punitive" does not appear. There are no dollar figures other than the § 33-7-11 minimum limits and the firm's case-results grid (out of scope). |
| Citation format | **PASS.** All 23 visible cites and 7 JSON-LD cites are `O.C.G.A. § X-X-XX`. There is no "OCGA", no "Ga. Code Ann." and no "§§". The page has no statute links. |
| Comparative fault, § 51-12-33 | **PASS, and consistent on 6 surfaces.** The KT and the essay say "bars recovery if you are 50% or more at fault" and "bars recovery only if the plaintiff is 50% or more at fault". The law box says "recover if less than 50% at fault". The negligence intro says "bars recovery if you are 50% or more at fault". FAQ 3 and its schema say "Yes, if you were less than 50% at fault. Georgia bars recovery at 50% or more…". § 51-11-7 is not miscited. |
| SOL, § 9-3-33 vs § 9-3-32 | **PASS.** Two years for injury appears in the KT, the essay, the negligence intro, the law box, the sidebar and FAQ 2. Four years for vehicle damage under § 9-3-32 appears in the body and FAQ 2, and each is attributed to the right section. The deadline is hedged ("generally", "usually ends"). |
| Ante litem, §§ 36-33-5 / 36-11-1 / 50-21-26 | **PASS.** City: six months, § 36-33-5 (body, KT, FAQ 4). County: twelve months, § 36-11-1 (body, FAQ 4; the KT has it without a cite). State: twelve months, § 50-21-26 (body; the KT has it without a cite). No city/county period is swapped, and the State notice is not given as six months. |
| § 33-7-11 | **PASS.** "insurers must offer uninsured motorist coverage" appears in the body, the essay and FAQ 5. UM is never called mandatory. The body, essay and pillar intro show no "stacking". The limits of 25/50/25 match the pack. See INFO 2. |
| No-fault / PIP / thresholds | **PASS.** The compensation intro's GA branch says "Georgia is an at-fault state". The SC template's "neither … nor any neighboring state" sentence does not render here. |
| What-to-do step 5, § 40-6-270 | **PASS.** The visible step and HowTo step 5 are identical and match the pack claim. The 3-to-15-year range does not appear. See INFO 1. |
| FARS statistic | **PASS.** "Chatham County recorded 40 traffic deaths in 2022", attributed to NHTSA FARS, matches `data/statistics.json` `chatham-county-traffic-deaths-2022` (value 40, asOf 2022). The stale "59" is absent. |
| Memorial Health Level I | **PASS.** The page says "Memorial Health University Medical Center on Waters Avenue, a Level I trauma center". It makes no "only" claim. The GA pack's `grady-only-level-i` rule itself records that Savannah's Memorial Health genuinely is Level I. The page's word "only" appears just twice, both in boilerplate unrelated to trauma. See W1 on "LifeStar". |
| Savannah office directions | **PASS.** Checked against the exit lists and route descriptions for I-16, I-516, I-95 in Georgia and SR 204. These are secondary compilations; GDOT's own pages could not be reached from here. See "Directions" below. |
| Courthouse address | **PASS.** 133 Montgomery Street, Savannah 31401 is the Chatham County Court Complex (Coleman Courthouse), per chathamcourts.org. The Superior Court Clerk is listed there by chathamcountyga.gov. "Usually filed" hedges venue. |
| Phones | **PASS.** The visible "(912) 303-5850" and `tel:+19123035850` (x6) match `client.json` for Savannah. `tel:+18447378587` (x12) is 1-844-RESULTS. LegalService `telephone` is the toll-free line; LocalBusiness is the office line. |
| FAQ vs FAQPage JSON-LD | **PASS.** All 6 questions and answers are identical, character for character. |
| Steps vs HowTo JSON-LD | **PASS.** All 7 steps are identical. |
| Firm stats | $300M+, 4.9, 5,000+, 62 years and 6 offices are unchanged from Charleston. "170+" is computed live. LocalBusiness `reviewCount: 59` is the Savannah GBP, so it is consistent by design. "Cases successfully handled" is already logged and is not re-raised. |
| Author / reviewer | Eric Roden, Founding Partner, CEO, with State Bar of Georgia credential in Person schema. `client.json` barStates `["GA"]`. Correct for a GA-only page. |
| Out of scope (owner) | The case-results grid and the attorneys block are not reviewed. |

### Directions (firm-data `offices.savannah.directions`, TEMPLATE)

Published: "From I-16 East, take Exit 164A onto I-516 E/DeRenne Ave, then turn south on Abercorn St. From I-95, take Exit 94 onto GA-204 E (Abercorn St) toward Savannah."

- **I-16 Exit 164A.** This is I-516 east / US 17 south / US 80 east / SR 21 south (W.F. Lynes Parkway). Exit 164B is I-516 west toward Garden City. The directions are correct.
- **I-516's eastern end.** I-516 ends at Montgomery Street, where SR 21 continues east as DeRenne Avenue. "I-516 E/DeRenne Ave" is therefore correct. Turning south (right) from DeRenne onto Abercorn leads toward Oglethorpe Mall. The office geo (32.0046, -81.1082) lies south of DeRenne on that stretch, so this is correct.
- **I-95 Exit 94.** This is SR 204 (Savannah / Pembroke). SR 204 runs east from I-95 as Abercorn Expressway and becomes Abercorn Street. The directions are correct.
- **No change needed.** The Charleston-style error ("King and Calhoun") has no counterpart here.

---

## WARN (low): not errors of law

### W1. "often arriving by LifeStar helicopter" has no source

- **Surface / block:** body, "Filing a Personal Injury Case in Savannah" essay, paragraph 2.
- **Source:** TEMPLATE, `inc/firm-data.php` Savannah `local_context` (line 70) and `local_context_es` (line 78).
- **Published:** "Seriously injured victims across southeast Georgia are routed to Memorial Health University Medical Center on Waters Avenue, a Level I trauma center, often arriving by LifeStar helicopter."
- **Corrected:** "Seriously injured victims across southeast Georgia are routed to Memorial Health University Medical Center on Waters Avenue, a Level I trauma center."
- **ES corrected:** "Las víctimas con lesiones graves de todo el sureste de Georgia son trasladadas al **Memorial Health University Medical Center, en Waters Avenue**, un centro de trauma de Nivel I."
- **Authority:** none needed for the level (see the Level I row above). Nothing on file supports the air-ambulance brand name or "often". The name and service could not be confirmed from a primary source here.
- **Same class elsewhere:** Darien `local_context` (line 129) and `_es` (line 137) say "flown by LifeStar". Keep those only if the firm can confirm that the service operates under that name today.
- **Not a finding:** the Savannah workers' comp essay (line 90), the Darien essays (lines 129, 137) and the Darien WC essay (line 146) call Memorial "the region's only Level I" / "the only Level I trauma center in southeast Georgia". That is consistent with the GA pack's own note. None renders on this page.

### W2. "Abercorn Street (SR 204) runs from downtown…"

- **Surface / block:** body, "Where Car Accidents Happen in Savannah" > "Abercorn Street".
- **Source:** PAGE, `bin/rebuild-savannah-car-accident.php` line 56.
- **Published:** "Abercorn Street (SR 204) runs from downtown past the Oglethorpe Mall area to the southside, with heavy retail traffic, frequent signals and turning vehicles."
- **Corrected:** "Abercorn Street runs from downtown past the Oglethorpe Mall area to the southside, where it carries SR 204, with heavy retail traffic, frequent signals and turning vehicles."
- **Why:** SR 204 was truncated in 2020 to end at DeRenne Avenue. Abercorn north of DeRenne, through Midtown and downtown, is no longer SR 204. The office and the mall are on the SR 204 segment, so the directions are unaffected.
- **Same class, optional:** the essay's "DeRenne Avenue, Abercorn Street (SR 204), and the historic downtown grid" (firm-data line 70, `_es` line 78) is not wrong for the southside segment. Dropping "(SR 204)" there removes the ambiguity.

### W3. A South Carolina resource on a Georgia-only page

- **Surface / block:** body, "Local Car Accident Lawyers Resources".
- **Source:** TEMPLATE (resources query).
- **Published:** the link "Grand Strand Fatal Crash Report: Horry County, 2020–2024".
- **Finding:** this is the same class as Charleston W10 (a Georgia moped guide on the SC page), mirrored. The fix is the one already proposed: filter the resources to the page's jurisdiction. The I-26/I-95 corridor report covers both states and is fine.

### W4. An absolute practice claim

- **Surface / block:** body, "Why Hire Roden Law After a Savannah Car Accident".
- **Source:** PAGE, line 49.
- **Published:** "Built for trial. We prepare every case as if it will be tried at the Chatham County Courthouse."
- **Corrected:** "Built for trial. We prepare cases to be tried at the Chatham County Courthouse if the insurer will not pay fairly."
- **Authority / rule:** n/a. This is GA RPC 7.1 hygiene: "every case" cannot be verified. It has the same low severity as Charleston W11 and is optional.

---

## INFO: questions for the GA pack, not page findings

1. **§ 40-6-270 scope.**
   - Step 5 says "every driver involved in a crash" must stop, give information and render aid.
   - The duty in § 40-6-270(a) is triggered by a crash involving injury, death, or damage to a vehicle that is driven or attended. Unattended vehicles and fixtures are covered by §§ 40-6-271 and 40-6-272, and the duty to render aid runs to injured persons.
   - The page matches the pack claim word for word, so any narrowing belongs in the pack claim first. The police-notification duty (§ 40-6-273) is still not in the pack.
2. **§ 33-7-11 wording.**
   - "Insurers must offer" UM is true, but § 33-7-11(a)(3) makes UM part of the policy unless the insured rejects it in writing. FAQ 5 ("check whether your policy includes it") is safe as written.
   - Also confirm whether the 25/50/25 duty to *carry* should be cited to § 33-7-11 alone or also to the compulsory-insurance provisions (§§ 33-34-4, 40-9-37).
   - These are questions for the GA pack's authority text. Statute text could not be retrieved here (Justia returned a bot challenge), so neither is asserted as an error.
3. **"Last updated: September 27, 2026"** is rendered from `dateModified` 2026-09-27T02:18Z, which is 2026-09-26 in Savannah. The stamp resets when the page is published and is not a legal issue.

## Counts by rule

| Rule | Findings | Severity |
|---|---:|---|
| (engine) all GA + SC rules | 0 | none |
| Hand: unsourced local fact (LifeStar) | 1 (+2 Darien sibling essays) | warn, low |
| Hand: route designation (SR 204) | 1 | warn, low |
| Hand: single-state presentation / unfiltered resources | 1 | warn, low |
| Hand: marketing absolute | 1 | warn, low |
| **Total** | **4** (0 error, 4 warn) | |

Source split: **TEMPLATE, 2** (W1, W3); **PAGE, 2** (W2, W4).

## False positives

None. The engine raised nothing, and every hand check of a known SC-template leak (51%, "50% or less", stacking, SC cites, "neighboring state", no-fault) came back clean. No pack PR is needed for this page.

## Before publish

1. Optional: apply W2 and W4 in `bin/rebuild-savannah-car-accident.php`, and W1 in a theme PR against `inc/firm-data.php` (EN and ES). Re-render and replay `scratchpad/draft3622-fixture.json`.
2. Eric Roden reviews the page, including INFO 1 and 2 for the GA pack. Only then set `_roden_last_reviewed` and publish.
