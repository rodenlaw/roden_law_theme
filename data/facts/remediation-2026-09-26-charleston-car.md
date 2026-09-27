# Pre-publish legal sweep: Charleston car accident page (post 3624, DRAFT)

- **Page:** `/car-accident-lawyers/charleston-sc/` (post 3624, `practice_area`, draft, on `roden_office_practice_allowlist()` wave 1)
- **Jurisdiction:** South Carolina only. Reviewer of record: Graeham C. Gillin (SC Bar).
- **Swept:** the rendered draft HTML (`scratchpad/preview/draft3624.html`) and all seven JSON-LD blocks in it (LegalService, Person, FAQPage, WebPage, HowTo, LocalBusiness/LegalService/LawFirm, BreadcrumbList).
  - The page's own surfaces, from `bin/rebuild-charleston-car-accident.php`: body, excerpt, meta description, key takeaways and FAQs.
  - The template blocks: hero, NAP bar, law box, what-to-do steps, local-context essay, negligence intro, compensation intro, stats block, attorneys, case results, resources and sidebar.
- **Sweep method:** by claim class, not by string.
  - Engine run: 22 blocks replayed through `sweep-claims.mjs --fixtures` with `--states SC,GA`. It returned **0 findings**.
  - Every finding below was found by hand reading. Finding 1 shows a gap in the rules (see "Pack changes").
- **Pack state:** `law/SC.json` is **UNSIGNED** (`signOff.status: "unsigned"`, every `verifiedBy: null`).
  - Every legal claim on this rebuilt page is a new claim resting on unsigned authorities.
  - Gillin's review of this page is therefore the only attorney check any of them get before publish. The byline "Reviewed by Graeham C. Gillin" must not go live until he has actually reviewed it.

**Verdict: FAIL.** One error-level finding (a false statement of SC law) blocks publish. It comes from the shared theme essay, not from this page's own content.

Source key:
- **PAGE** means `bin/rebuild-charleston-car-accident.php`.
- **TEMPLATE** means the theme or parent-pillar meta, so the fix also reaches other pages.

---

## ERROR

### E1. The SC Tort Claims Act is described as having "notice deadlines"

- **Surface / block:** body, the "Filing a Personal Injury Case in Charleston" local-context essay, paragraph 3.
- **Source:** TEMPLATE, `inc/firm-data.php` Charleston office `local_context` (line 188) and `local_context_es` (line 196).
- **Published:** "Shorter notice deadlines apply if SCDOT or the City of Charleston is a defendant under the SC Tort Claims Act."
- **Corrected:** "If SCDOT or the City of Charleston is the defendant, the South Carolina Tort Claims Act sets a shorter deadline: two years (S.C. Code § 15-78-110), or three years if a verified claim is filed with the agency within one year (S.C. Code § 15-78-80). It requires no pre-suit notice."
- **Spanish (`local_context_es`) corrected:** "Si el SCDOT o la Ciudad de Charleston es la parte demandada, la South Carolina Tort Claims Act fija un plazo más corto: dos años (S.C. Code § 15-78-110), o tres años si se presenta un reclamo verificado ante la agencia dentro de un año (S.C. Code § 15-78-80). No exige notificación previa a la demanda."
- **Authority:** `SC 15-78-110`, `SC 15-78-80` (unsigned).
- **Rule:** none fired. The false claim sits in the gap between two rules:
  - `sctca-shorter-notice-hedge` needs "may/might/could apply".
  - `sctca-mandatory-notice` needs "mandatory/required notice" wording, or the Act named before the notice phrase.
- **Why it is an error:** the SCTCA imposes no notice at all, and the optional verified claim *lengthens* the deadline. The page contradicts itself: this page's own body ("Crashes involving a city, county or state vehicle") correctly says the verified claim is optional.
- **Same claim class elsewhere (fix in the same PR):**
  - North Charleston office `local_context`, firm-data.php line 236: "…and shorter Tort Claims Act notice deadlines apply when SCDOT or the SC Ports Authority is a defendant."
  - North Charleston office `local_context_es`, line 244: "…y rigen plazos de notificación más cortos bajo la Tort Claims Act…"
  - Corrected (EN): "…apply. Claims against SCDOT or the SC Ports Authority fall under the South Carolina Tort Claims Act: two years to sue (S.C. Code § 15-78-110), or three if a verified claim is filed within one year (S.C. Code § 15-78-80), with no pre-suit notice."
- **Fix path:** a theme PR against `inc/firm-data.php` (a repo file, deployed by `deploy.yml`, not a database write). No pages are live on the intersection template today, so the essays render only on this draft and on future wave-1 pages.

## WARN: unsupported or previously removed facts

### W1. Two crash statistics that were already removed as unverified

- **Surface / block:** body, the local-context essay, paragraph 2.
- **Source:** TEMPLATE, firm-data.php Charleston `local_context` line 186 and `_es` line 194. The same two figures appear in North Charleston `local_context` line 234 and `_es` line 242.
- **Published:** "Charleston County logged more than 2,500 truck-related crashes in 2023, and the I-26/I-526 interchange just west of the peninsula recorded 354 collisions over a five-year period."
- **Corrected:** delete the sentence.
- **Authority:** none exists. Both figures were **removed from 9 post bodies on 2026-08-25** as unverifiable (`docs/stat-audit-2026-08-25.md` claims #3 and #5; `bin/apply-stat-remediation.php`). They survived in the theme essays, which that remediation structurally could not see.
- **Rule:** none (the statistics registry covers post content only).
- **Severity:** warn by definition (not law), but **treat it as a publish blocker**, because this claim class has already been adjudicated false-to-publish.

### W2. "MUSC Health … the Lowcountry's only Level I trauma center"

- **Surface / block:** body, the local-context essay, paragraph 2.
- **Source:** TEMPLATE, firm-data.php line 186 and `_es` line 194.
- **Published:** "Serious-injury patients from peninsula crashes are routed to MUSC Health (171 Ashley Ave) — the Lowcountry's only Level I trauma center."
- **Corrected:** "Serious-injury patients from peninsula crashes are typically taken to MUSC Health University Medical Center (171 Ashley Ave), an adult and pediatric Level I trauma center."
- **Authority:** firm-data's own verified `trauma_center` value, "MUSC Medical Center (Adult and Pediatric Level I)", checked against the SC DPH list in Aug 2026 (firm-data.php lines 372–375). That source supports the level. It does not support "only".
- **Rule:** none.
- **Why:** firm-data's comment records that the Georgia side "published a false 'only Level I' claim in 55 places". "Lowcountry" has no fixed boundary: Memorial Health in Savannah is Level I and serves Beaufort and Jasper. Drop the superlative.

### W3. Court and procedure facts with no source

- **Surface / block:** body, the local-context essay, paragraph 1.
- **Source:** TEMPLATE, firm-data.php line 184 and `_es` line 192.
- **Published:** "Filing a personal injury case in downtown Charleston means filing in the Charleston County Court of Common Pleas at 100 Broad Street, on the Tyler Odyssey-based South Carolina E-Filing system. Most cases are sent to mandatory mediation under SC ADR rules before reaching the jury trial roster, and a typical contested case takes 18–30 months from complaint to verdict."
- **Corrected:** "A car accident lawsuit from downtown Charleston is usually filed in the Charleston County Court of Common Pleas at 100 Broad Street, through the South Carolina Judicial Branch's e-filing system. Most contested cases go to mediation under the South Carolina ADR Rules before trial."
- **Authority:** none in the pack. The corrected sentence drops the three claims no source supports:
  - "means filing in", because venue follows § 15-7-30 and can be the defendant's county;
  - the vendor name;
  - "18–30 months".
- **Rule:** none.
- **Also:** the Columbia, Myrtle Beach and service-area essays repeat "Tyler Odyssey" and the ADR claims (firm-data lines 279, 327 and 591–786). If the vendor name cannot be sourced, give them the same treatment.

### W4. Negligence per se stated without the statutory carve-outs

- **Surface / block:** body, "Do I Have a Car Accident Case in Charleston?".
- **Source:** TEMPLATE, the parent pillar meta `_roden_pillar_negligence_intro` on `/practice-areas/car-accident-lawyers/`. It renders, with state tokens, on every car-accident intersection in both states.
- **Published:** "Violating a Rule of the Road (SC-specific traffic statutes) supports a *negligence per se* theory and can be powerful evidence at trial."
- **Corrected:** "Violating a traffic statute can support a negligence per se theory and can be powerful evidence at trial, although South Carolina bars some violations from evidence entirely, such as not wearing a seat belt (S.C. Code § 56-5-6540) or a child-restraint violation (S.C. Code § 56-5-6460)."
  - Because the meta is tokenised for both states, the two SC carve-outs need `{if SC}` state conditionals or a per-state variant. Do not show SC citations on Georgia pages.
- **Authority:** `SC 56-5-6540`, `SC 56-5-6460` (unsigned).
- **Rule:** none. The existing `sc-seatbelt-limited-not-inadmissible` and `sc-carseat-comparative-fault` rules match only direct assertions, not a blanket per se statement.
- **Formatting defect in the same block:** `roden_render_pillar_intro()` converts only `**bold**`, so `*negligence per se*` renders with literal asterisks on the page.

### W5. The deadline stated as absolute

- **Surface / block:** body, "Do I Have…"; and the sidebar box "South Carolina Filing Deadline".
- **Source:** TEMPLATE, pillar `_roden_pillar_negligence_intro`, and the sidebar filing-deadline widget.
- **Published:** "You have 3 years from the crash date to file (S.C. Code § 15-3-530) — missing the deadline forfeits your right to recover regardless of how strong the case is." / "Missing the deadline forfeits your right to recover."
- **Corrected:** "You generally have 3 years from the crash date to file (S.C. Code § 15-3-530). Missing the deadline usually ends your right to recover, however strong the case."
- **Authority:** `SC 15-3-530`. Low severity: tolling exists (for example for minors), and the discovery rule in § 15-3-535 is not in the pack.
- **Rule:** none.

### W6. The compensation block makes claims about other states and overstates the absence of caps

- **Surface / block:** body, "Types of Compensation in South Carolina Car Accident Cases".
- **Source:** TEMPLATE, parent pillar meta `_roden_pillar_compensation_intro`.
- **Published:** "Neither South Carolina nor any neighboring state operates a no-fault auto system — recovery flows through the at-fault driver's liability policy, with uninsured/underinsured motorist (UM/UIM) stacking as a critical secondary source when injuries exceed the at-fault driver's minimum 25/50/25 limits. There is no statutory cap on noneconomic damages in ordinary auto cases in South Carolina, so pain-and-suffering, loss of enjoyment, and disfigurement recoveries are limited only by the evidence and the comparative-fault bar."
- **Corrected:** "South Carolina is an at-fault state: recovery flows through the at-fault driver's liability policy, which need only carry $25,000 per person and $50,000 per accident (S.C. Code § 38-77-140), with your own uninsured and underinsured motorist (UM/UIM) coverage as a critical second source (S.C. Code §§ 38-77-150, 38-77-160). South Carolina sets no general cap on noneconomic damages in a claim against a private driver, so pain and suffering, loss of enjoyment and disfigurement are limited by the evidence and the comparative-fault bar. Claims against a government entity are the exception: recovery is capped at $300,000 per person and $600,000 per occurrence (S.C. Code § 15-78-120)."
- **Authority:** `SC 38-77-140`, `SC 38-77-150`, `SC 38-77-160`, `SC 15-78-120` (unsigned). `SC 33-56-180`, the charity cap, is a further exception if Gillin wants it named.
- **Rule:** none.
- **Why:**
  - "Any neighboring state" is a claim about Georgia and North Carolina law on a single-state page.
  - "Stacking" overstates SC law: stacking is limited, and the pack has no authority for it.
  - "Limited only by" contradicts the page's own § 15-78-120 paragraph for the government-vehicle crashes the page covers.
- **Visibility gap (important):** `_roden_pillar_compensation_intro` is **not in `bin/export-content-meta.php`**, so it is absent from `content/meta.json` and every meta sweep reads zero for it. Add the key to the export whitelist in the same PR. This is the "a sweep that cannot see a field reports zero" failure described in CLAUDE.md.

### W7. Police-report step is imprecise (theme default, both states, HowTo schema)

- **Surface / block:** body, "What to Do After a Car Accident" step 5, *and* the HowTo JSON-LD step 5.
- **Source:** TEMPLATE, `inc/template-tags.php` line 2130, `roden_what_to_do_steps_data()`. It is used on intersections, pillars and sub-types, with `%s` = state name, in both states and in Spanish through the `.po` file.
- **Published:** "South Carolina law requires accident reports when there are injuries or significant property damage. Request a copy of the police report."
- **Corrected (SC):** "South Carolina law requires you to notify police immediately after a crash that injures or kills anyone (S.C. Code § 56-5-1260), and to file a written report with the DMV within 15 days if no officer investigated a crash involving injury or $1,000 or more in property damage (S.C. Code § 56-5-1270). Request a copy of the police report."
- **Authority:** not in the pack. Proposed new authorities `SC 56-5-1260` and `SC 56-5-1270`, `verifiedBy: null`.
  - Read against https://www.scstatehouse.gov/code/t56c005.php on 2026-09-26. The Justia URL still needs to be added as evidence before the sign-off packet.
- **Rule:** none.
- **Scope:** this needs a per-state string, because the Georgia rule (O.C.G.A. § 40-6-273) differs. Changing the msgid drops the Spanish (CLAUDE.md), so re-add it in `es_ES.po` and recompile `es_ES.mo`.

## WARN: firm facts and single-state presentation

### W8. The stats block contradicts `profiles/writer-profile.md`

- **Surface / block:** body, "Results at a Glance" (the `.ai-stats-block`, which is also a Speakable selector); the sidebar form subtitle.
- **Source:** TEMPLATE, template-tags.php lines 3032–3040 and firm-data `trust_stats`.
- **Published:**
  - "4.9 / 5.0 — Average client rating across 170+ verified Google reviews from our six offices"
  - "5,000+ — Cases successfully handled since 2013"
  - "170+ verified Google reviews"
- **Profile (verbatim):** "4.9-star average · 500+ client reviews · 5,000+ cases handled".
- **Finding:**
  - "170+" is computed live from the per-office GBP counts (59+0+105+2+2+2) and is honest. The profile's "500+" is stale or counts another source. Per the profile's own rule, trust the live page and fix the profile: `client.json`, then regenerate.
  - "Successfully handled" is a stronger claim than the profile's "handled". It reads as "all won". Recommend: "Cases handled since 2013".
- **Consistent:** LocalBusiness `reviewCount: 105` is the Charleston GBP only, and is consistent by design.

### W9. An attorney who is not in `firm-facts.md`

- **Surface / block:** body, "Our Charleston Attorneys".
- **Source:** TEMPLATE (attorney CPT query by office).
- **Published:** "Nolan Alexander, Of Counsel, Charleston, SC".
- **Finding:**
  - He is a published attorney post (`/attorneys/nolan-alexander/`, post 3736) and appears on `/attorneys/`.
  - `client.json` / `firm-facts.md` does not list him, and that file says "A name not in this table is not on staff and must not appear."
  - The owner confirms either way: add him to `client.json` with his bar admissions (SC required for this page), or unassign him from Charleston.

### W10. Georgia material on a single-state page (no Georgia law found)

- **Georgia law:** PASS. No Georgia statute, rule or deadline appears anywhere on the page or in its JSON-LD.
- **Firm-level mentions (accepted, not law):** "Available 24/7 · Georgia & South Carolina" (CTA), "$300M+ recovered … across Georgia and South Carolina", "Licensed in GA & SC", the footer.
- **Resources block (TEMPLATE, warn):** it links "Georgia Moped Laws: Who Can Ride, What You Need…" from an SC-only page. Filter the resources to the page's jurisdiction.
- **Compensation block:** "any neighboring state" (see W6).

### W11. Marketing generalizations with no support

- **Surface / block:** body, "Why Hire Roden Law…".
- **Source:** PAGE.
- **Published:**
  - "Charleston crashes rarely involve just two local drivers and one policy."
  - "Insurers pay more when they know that."
- **Corrected:**
  - "Charleston crashes often involve more than two local drivers and one policy."
  - "Insurers take a case more seriously when they know it is ready for trial."
- **Authority / rule:** n/a (SC RPC 7.1 unverifiable-claim hygiene). Low severity.

### W12. Case results with no filter

- **Surface / block:** body, "Recent Case Results".
- **Source:** TEMPLATE.
- **Published:** $27,000,000 truck settlement; $10,860,000 product-liability verdict; $9,800,000 premises recovery.
- **Finding:**
  - None of the three is a car-accident result, and the state is not shown on a single-state SC page. They match `/case-results/`, and the "past results" disclaimer is present.
  - "Recent" cannot be checked from the page.
  - Recommend filtering by practice and state, or retitling the block "Selected Case Results". Low severity.

## Checks that PASS

| Check | Result |
|---|---|
| SOL | 3 years, S.C. Code § 15-3-530, the same in the KT, FAQ 2, law box, essay, negligence intro and sidebar. |
| Government-entity deadline | Two years under § 15-78-110 and three years with a verified claim under § 15-78-80, in the body, KT and FAQ 2. Correct everywhere **except** E1. |
| Comparative fault | Nelson v. Concrete Supply Co. is cited (in full in the law box: 303 S.C. 243, 399 S.E.2d 783 (1991)). **§ 15-38-15 appears nowhere.** Phrasings vary ("50% or less", "less than 51%", "51% or more … bars") but are equivalent. |
| Punitive damages | **No punitive dollar figure anywhere** (neither $500,000 nor $739,245). The only punitive statement is "no punitive damages" against a government entity (§ 15-78-120), which is correct. |
| UM / UIM / minimum limits / hit-and-run | §§ 38-77-140, -150, -160 and -170, all matching the pack claims. |
| SCTCA caps | $300,000 / $600,000 under § 15-78-120, correct. |
| Citation format | Every cite is `S.C. Code § XX-X-XXX`. No "Ann.", no `O.C.G.A.` |
| scstatehouse.gov links | 2 links, both in the `www.scstatehouse.gov/code/tNNcNNN.php` form, with correct chapters (§ 15-78 → `t15c078`, § 38-77 → `t38c077`). |
| Phones | Visible "(843) 790-8999" and `tel:+18437908999` (×6) match firm-facts for Charleston. `tel:+18447378587` (×12) = 1-844-RESULTS, correct. LegalService `telephone` is the toll-free line; LocalBusiness is the office line. |
| FAQ vs FAQPage JSON-LD | All 6 answers are identical, character for character. |
| Steps vs HowTo JSON-LD | Identical. Step 5 carries W7 in both places. |
| Firm stats | $300M+, 4.9, 5,000+, 62 years and 6 offices match the profile. The review count and "successfully" differ (W8). |
| Author / reviewer | Graeham C. Gillin (SC Bar). There is no Eric Roden attribution. |
| JSON-LD validity | 7/7 blocks parse. |

## Counts by rule

| Rule | Findings | Severity |
|---|---:|---|
| (engine) all SC + GA rules | 0 | — |
| Hand: SCTCA notice class (gap next to `sctca-mandatory-notice` / `sctca-shorter-notice-hedge`) | 1 (+2 sibling essays) | error |
| Hand: unverified statistic (stat-audit 2026-08-25 class) | 1 (+2 sibling essays) | warn, block |
| Hand: superlative / "only Level I" | 1 | warn |
| Hand: procedure and venue without a source | 1 | warn |
| Hand: overbroad statement of law (per se, deadline, caps, police report) | 4 | warn |
| Hand: firm facts (stats, attorney) | 2 | warn |
| Hand: single-state presentation / unfiltered blocks | 2 | warn |
| Hand: marketing generalization | 1 | warn |
| **Total** | **13** (1 error, 12 warn) | |

Source split:
- **TEMPLATE, 12:** E1, W1–W10 and W12. They reach future wave-1 intersections, all car-accident intersections, and pillars and sub-types for W7.
- **PAGE, 1:** W11.

## False positives

None. The engine raised nothing.

The reverse problem is the one that matters. These are **false negatives** and go to a pack PR (`internal-ai-scripts`), not to a content edit:

1. **SCTCA "notice deadlines apply" with no hedge.** Proposed: add a branch to `sctca-mandatory-notice` (error).
   - Branch:
     ```
     (?:shorter|special|strict)\s+(?:(?:south carolina\s+|sc\s+)?tort claims act\s+)?notice\s+(?:deadlines?|requirements?|periods?|rules?)\s+(?:apply|applies|govern)[^.]{0,120}(?:scdot|tort claims act|15-78|city of|county|state agenc|ports authority)
     ```
   - The existing `unless` guards are kept (`georgia|ante litem|…|federal`).
   - Tested in scratch: it hits both published sentences (Charleston, North Charleston) and passes 4 controls: the corrected E1 sentence, a Georgia ante-litem sentence, the page's own "optional" sentence, and an FTCA sentence.
   - Order of work: add the positives and controls to `law/fixtures/` first, then re-run both fixture sets to 100%, per the pack's rules.
2. The engine has **no rule class for the removed stat-audit figures** ("2,500 truck-related crashes", "354 collisions"). Consider a `rodenlaw` statistics-registry `banned` entry that also sweeps theme-sourced text, or a fixture for the theme essays like `roden-comparison-table-2026-09-26.json`.
3. **Proposed pending authorities:** `SC 56-5-1260` (immediate police notice, injury or death) and `SC 56-5-1270` (15-day written report to DMV, injury/death or $1,000+ property damage, if not investigated), `verifiedBy: null`, for Gillin's sign-off packet.

## Before publish

1. A theme PR fixing E1 (EN + ES, Charleston + North Charleston) and W1–W3. Recommended in the same PR: W6 export-whitelist key; W4/W6 pillar-meta rewrites through the `bin/` patcher (exact-match `str_replace` + `wp_slash`); W7 per-state msgid + `es_ES.mo`.
2. Re-render the draft and re-run this sweep, including the replay fixture (`scratchpad/draft3624-fixture.json`).
3. Gillin reviews and signs off the page. Only then set `_roden_last_reviewed` and publish.
