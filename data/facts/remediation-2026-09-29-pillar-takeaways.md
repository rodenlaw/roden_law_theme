# Legal sweep: 24 pillar Key Takeaways paragraphs (draft) + live pillar-page conflicts

- **Scope A (DRAFT):** the 24 hand-written Key Takeaways paragraphs in `data/practice-area-drafts/2026-09/pillar-takeaways/takeaways.json`. They replace the generated template paragraph on the 24 two-state `/practice-areas/*-lawyers/` pillars.
- **Scope B (LIVE):** the "live page text that conflicts with the signed packs" list in that folder's `README.md`. It was confirmed against the rendered pillars (`scratchpad/pillars2/<slug>.html|.txt`) and against a read-only dump of the 24 EN pillar posts: `post_content`, `post_excerpt` and every `_roden*` meta key (`scratchpad/pb/pillars.json`, dumped 2026-09-29 by `scratchpad/pb/dump-pillars.php`, which is SELECT-only).
- **Packs:** `internal-ai-scripts/law/SC.json` and `GA.json` (main at 328fe90).
  - **SC is signed,** with 48 signed authorities and 0 pending.
  - **GA is signed,** with 22 signed authorities and 10 pending. It is a shared pack and was not edited. Pending GA authorities touched here:
    - `GA 34-9-17` (fault-based bars to comp)
    - `GA 34-9-11` (exclusive remedy)
    - `GA 51-12-5.1` (punitive)
  - Under rule 1, none of these backs a new claim.
- **Nothing was written** to production, the theme, or either pack.

Source key:
- **PAGE** means `post_content`.
- **FAQ[n]** means `_roden_faqs[n].answer` (0-based). It is also published as FAQPage JSON-LD.
- **META** means another `_roden_*` key.
- **TEMPLATE** means theme code or `inc/firm-data.php`. A TEMPLATE fix reaches every page that renders it.

---

# PART A: the 24 draft paragraphs

## Engine replay

- **Command:** `sweep-claims.mjs --fixtures scratchpad/pb/parta-fixture.json`.
- **Entries:** the 24 **final** paragraphs (with the changes below applied), each on the `keyTakeaways` and `body` surfaces, plus the writer's 10 planted positive controls.
- **Result: 58/58 expectations met.** 48 clean entries returned nothing, and all 10 controls fired:
  - `ga-medmal-discovery-rule`
  - `wc-deadline-cited-to-tort-statute` (GA and SC)
  - `sc-three-foot-passing`
  - `sctca-three-year-default`
  - `nelson-bar-miscited-to-15-38-15`
  - `wrongful-death-deadline-cited-to-definitions`
  - `municipal-ante-litem-12-months`
  - `hands-free-repealed-section`
  - `georgia-is-no-fault`
- **Final texts:** `scratchpad/pb/takeaways-final.json`.
- **Word counts** stay within 117–130: boating 130, product 130, maritime 129, dog bite 130, med mal 130, truck 118.

## Decisions on the five flagged statements

### (1) Workers' comp: "Workers' compensation is no-fault in both states"

**Keep. PASS.**
- **SC half:** signed (`SC 42-9-60`: "Ordinary fault or comparative negligence plays no part").
- **GA half:** rests on pending `GA 34-9-17`. It is **not a new claim on the site**:
  - The live WC pillar (3610) body already says "Workers' compensation is a no-fault system … being partly at fault does not bar benefits".
  - Eric Roden's reviewed GA WC pages carry the same framing: the Savannah WC law box, 2026-09-26, and the GA statewide 6322 "Fault: No-fault" card, accepted in `remediation-2026-09-29-ga-statewide.md` W3.
  - It is correct against the § 34-9-17 primary text (Wayback snapshot 20250213234232). The only fault bars are the employee's willful misconduct and intoxication.
- **Conditions:**
  - The paragraph cites no GA fault section, and that must stay so. Do not add `§ 34-9-17` until it is signed.
  - The engine's `georgia-is-no-fault` rule correctly does not fire, because it targets auto insurance. Its control fired.
- **Open item:** **ga-reviewer**, sign `GA 34-9-17`.

### (2) Maritime / boating: "where state law governs"

**The framing is acceptable. It narrows and asserts no federal rule.**
- Both paragraphs condition the state deadlines on state law applying. That is a restriction, not a claim of law, and it needs no authority.
- **The defect is the fault sentence.** Boating stated the GA/SC fault bars **unconditionally**, while the deadline sentence was conditioned. Where federal maritime law governs, the state bars do not apply.
  - No signed authority states the admiralty fault rule, and it is an open item (see open-legal-questions). So the fix is to condition the fault sentence, not to state the federal rule.
- **Maritime** already said "Under state law", but applied tort fault to "the worker". Under state law, an injured worker's claim against the employer is workers' compensation, where fault plays no part (`SC 42-9-60`). That is the tort-leakage class. It is narrowed to a negligence suit.

### (3) Nursing home: tort deadlines vs med-mal deadlines

**Keep as written. PASS.**
- The paragraph labels § 9-3-33 / § 15-3-530 "the **general** injury deadline". The number is the same under both regimes: two years in Georgia (§ 9-3-71(a) also runs two years from injury or death), and three years in South Carolina (§ 15-3-545(A)).
- So the paragraph does not mislead on the deadline. What it omits is the malpractice repose: five years in GA, six years in SC.
- Adding a sentence that the malpractice statutes govern care-based nursing-home claims would be a **new claim with no signed authority**:
  - GA: the § 9-3-70 definition is not in the pack.
  - SC: § 15-3-545 reaches a "health care provider" through Chapter 38-79 Article 5 definitions that were repealed in 2020. That is the open SC nursing-home SOL question.
- **Open items:** **gillin** (SC nursing-home SOL) and **ga-reviewer** (add § 9-3-70 scope) before any repose sentence is added.
- The "may apply" hedge on the § 15-32-220 cap is signed (`SC 15-32-220`: "the cap reaches nursing-home malpractice claims").

### (4) Construction: GA "generally within one year" and the SC § 42-1-410 sentence

**Both PASS.**
- **GA:** "generally due within one year of the injury (O.C.G.A. § 34-9-82)" is the first prong of the signed claim. "Generally" correctly covers the treatment and last-payment prongs, which the WC pillar and the WC paragraph state in full. It is not the two-years-from-injury error.
- **SC:** "A South Carolina contractor that subcontracted the work can be the statutory employer who owes those benefits (§ 42-1-410)" matches the signed `SC 42-1-410` claim.
  - It rightly says nothing about the statutory employer's tort immunity. `SC 42-1-540` is signed for the direct employer only, and extending it to statutory employers is not in the pack.
  - "Outside party, such as a scaffold maker" does not imply a suit against the general contractor.

### (5) Brain injury: GA seat belt "may reduce your recovery" vs § 40-8-76.1

**PASS.**
- The signed `GA 40-8-76.1` claim says SB 68 subsection (d) admits non-use on negligence, comparative negligence, causation and apportionment, "and it may diminish recovery". It sets no percentage cap. The sentence states exactly that, with no figure.
- SB 68 Section 9 applies Section 5 to causes of action **pending** on 2025-04-21 (`docs/briefs/2026-08-07-georgia-tort-reform-sb68.md`), so "Georgia admits" is right for current claims.
- The SC half ("bars that evidence in civil cases") matches `SC 56-5-6540` (inadmissible). Watch item: SC Bill 280.

## Per-slug verdicts

| Slug | Verdict | Change |
|---|---|---|
| personal-injury-lawyers | PASS | none |
| e-bike-accident-lawyers | PASS | none |
| golf-cart-accident-lawyers | PASS | none |
| atv-side-by-side-accident-lawyers | PASS | none |
| electric-scooter-accident-lawyers | PASS | none |
| bicycle-accident-lawyers | PASS | none |
| pedestrian-accident-lawyers | PASS | none |
| premises-liability-lawyers | PASS | none |
| nursing-home-abuse-lawyers | PASS | none (see (3)) |
| construction-accident-lawyers | PASS | none (see (4)) |
| burn-injury-lawyers | PASS | none |
| boating-accident-lawyers | **CHANGE** | A1 |
| product-liability-lawyers | **CHANGE** | A2 |
| maritime-injury-lawyers | **CHANGE** | A3 |
| spinal-cord-injury-lawyers | PASS | none |
| brain-injury-lawyers | PASS | none (see (5)) |
| dog-bite-lawyers | **CHANGE** | A4 |
| workers-compensation-lawyers | PASS | none (see (1)); GA half rests on pending § 34-9-17 and existing reviewed copy |
| wrongful-death-lawyers | PASS | none |
| medical-malpractice-lawyers | **CHANGE** | A5 (error) |
| motorcycle-accident-lawyers | PASS | none |
| slip-and-fall-lawyers | PASS | none |
| truck-accident-lawyers | **CHANGE** | A6 |
| car-accident-lawyers | PASS | none |

### A5 (ERROR). medical-malpractice-lawyers: repose stated as absolute in both states

The fix, before -> after:
- "and never more than five years after the negligent act (O.C.G.A. § 9-3-71)" -> "and generally no more than five years after the negligent act (O.C.G.A. § 9-3-71)"
- "but no more than six years (S.C. Code § 15-3-545)" -> "but generally no more than six years (S.C. Code § 15-3-545)"
- "Your own fault bars recovery" -> "Your fault bars recovery". This only holds the word count at 130.

**Georgia authority: `GA 9-3-71`.** The signed claim itself states the exceptions to the five-year limit:
- A foreign object runs one year after discovery (§ 9-3-72), outside the § 9-3-71 limits.
- A minor under five has until two years after the fifth birthday, with repose at age ten (§ 9-3-73). A one-year-old's claim can therefore survive nine years.

**South Carolina authority: `SC 15-3-545`.** The signed claim sets out the exceptions to the six-year limit:
- (B): for a foreign object, the six-year limit does not apply.
- (D): a minor's tolling runs up to seven years.

"Never" and a bare "no more than" are false in both states.

**Rule:** none; the engine has no repose-absolute rule. **Proposed pack rule:** `medmal-repose-absolute` (GA and SC, warn), which would fire on "never more than (five|six) years" near § 9-3-71 / § 15-3-545. Add a fixture control first.

### A1. boating-accident-lawyers: the state fault bar is unconditioned
- **Before:** "Georgia allows no recovery at 50% or greater fault (O.C.G.A. § 51-12-33), and South Carolina none above 50% (Nelson v. Concrete Supply Co.)."
- **After:** "Under state law, Georgia allows no recovery at 50% or greater fault (O.C.G.A. § 51-12-33), and South Carolina none above 50% (Nelson v. Concrete Supply Co.)."
- **Authority:** `GA 51-12-33`, `Nelson v. Concrete Supply Co.` The condition mirrors the paragraph's own opening, "When state law governs". See (2).
- **Rule:** none (manual).

### A2. product-liability-lawyers: the negligence fault bar applied to every product claim
- **Before:** "If the jury assigns you part of the blame, Georgia bars recovery at 50%"
- **After:** "On a negligence claim, if the jury assigns you part of the blame, Georgia bars recovery at 50%"
- **Authority:** `GA 51-12-33`, and `Nelson v. Concrete Supply Co.`, a negligence case. No signed authority covers comparative fault in a **strict** product-liability claim, the pillar's core theory. South Carolina law on whether ordinary comparative negligence applies to strict liability is an open question: **gillin**.
- **Rule:** none (manual).

### A3. maritime-injury-lawyers: tort fault applied to "the worker"
- **Before:** "Under state law, the worker's fault bars recovery at 50% in Georgia"
- **After:** "In a state-law negligence suit, your fault bars recovery at 50% in Georgia"
- **Authority:** `SC 42-9-60`: fault plays no part in a state comp claim. `GA 51-12-33` and `Nelson` apply to the negligence suit.
- **Rule:** none. This is the WC tort-leakage class.

### A4. dog-bite-lawyers: an unsourced statistic, and the SC fault rule unconditioned
- **Before:** "Children are bitten most often, and facial scarring can need years of treatment."
- **After:** "Facial bites can leave scars that need years of treatment."
  - This follows the brief's no-statistics rule. The claim has no source in the paragraph or the stats registry.
- **Before:** "A Georgia victim found 50% or more at fault cannot recover"
- **After:** "In a negligence claim, a Georgia victim found 50% or more at fault cannot recover"
  - South Carolina dog-bite liability is strict under § 47-3-110, which is not in the pack, and its defenses are provocation and trespass.
  - `Nelson` is a negligence authority, so the fault sentence is scoped to negligence claims. Whether comparative negligence reduces a § 47-3-110 claim is an open question: **gillin**.
- **Authority:** `GA 51-12-33`, `Nelson v. Concrete Supply Co.`

### A6. truck-accident-lawyers: "settles whether the driver needed one"
- **Before:** "which settles whether the driver needed one"
- **After:** "which bears on whether the driver needed one"
- **Authority:** `GA 40-5-142`, which is signed only as the 26,001-lb GVWR threshold. The CDL requirement also turns on combination weight, passenger count and hazmat, none of which is in the pack, so the weight rating alone does not "settle" it.
- **Rule:** none (manual).

### Optional wording (not required, no legal error)
- **slip-and-fall:** "Georgia defendants have two fault defenses" reads as exhaustive. "can raise two fault defenses" is safer.
- **"at 50%" for Georgia** (golf cart, scooter, construction, product, maritime, med mal, nursing home): correct, because the bar begins at 50%. The engine accepts it. "at 50% or more" is clearer if the words allow.

---

# PART B: live pillar-page conflicts

Batch file: `data/facts/pillar-conflicts-batch-2026-09-29.json`. It uses the applier schema of `bin/apply-linked-pages-batch.php`, and `faqN` is 0-based. Every `from` was checked to occur exactly once in the current field of the 2026-09-29 dump. META and TEMPLATE fixes are not data the applier can write, so they are listed per pillar and collected in the "Template and meta fixes" section.

## workers-compensation-lawyers (3610) `/practice-areas/workers-compensation-lawyers/`

The README conflicts are **confirmed**. Where each one lives:

| # | Surface | Where it lives | Published | Class |
|---|---|---|---|---|
| PB-WC1 | FAQ[0] + FAQPage | `_roden_faqs[0]` | "You then have one year from the date of injury to file a formal claim … (O.C.G.A. § 34-9-82)." | apply |
| PB-WC2 | FAQ[0] + FAQPage | `_roden_faqs[0]` | "For occupational diseases, the one-year period begins when you knew or should have known the condition was work-related." | ga (cut) |
| PB-WC3 | FAQ[1] + FAQPage | `_roden_faqs[1]` | "For occupational diseases, the two-year period begins from the date of disability or the date you were informed of the condition by a physician." | gillin (cut) |
| T-WC1 | "Filing Deadlines" lead | TEMPLATE `templates/template-practice-area.php:306` (msgid "Workers' compensation runs on its own deadlines … In Georgia you have %1$s from the date of injury to file your claim (%2$s)") with `%1$s` = `statute_years` "1 Year" | "In Georgia you have 1 Year from the date of injury to file your claim (O.C.G.A. § 34-9-82)." | template |
| T-WC2 | GA sol-card | TEMPLATE `template-practice-area.php:330`, `$pa_sol_years( $pa_sol_ga )` | "Georgia Filing Deadline / 1 Year" | template |
| T-WC3 | sidebar "Filing Deadlines" badge | TEMPLATE `inc/template-tags.php:1409` `roden_deadline_badges_sidebar()` | "1 yr" | template |
| M-WC1 | body, the "Serving South Carolina?" paragraph | META `_roden_why_hire` (not `post_content`) | "…page covering the deadlines, statutes, and comparative-fault rules specific to South Carolina." | meta |
| M-WC2 | meta description | META `_roden_meta_description` | "Georgia allows 1 year to file, South Carolina 2." | meta |

**Before -> after:**
- **PB-WC1:** "You then have one year from the date of injury to file a formal claim with the State Board of Workers' Compensation (O.C.G.A. § 34-9-82)." -> "You then have one year from the date of injury, one year from the last remedial treatment your employer furnished, or two years from the last weekly benefit payment to file a formal claim with the State Board of Workers' Compensation (O.C.G.A. § 34-9-82)."
  - **Authority:** `GA 34-9-82`.
- **PB-WC2 / PB-WC3:** cut the sentence. Each occupational-disease trigger is outside its signed pack claim.
  - GA § 34-9-281 is not in the pack, and it carries an outer limit after last exposure that the sentence omits.
  - SC `42-15-40` is signed only as "two years from the date of the accident".
  - Restore either sentence only on a signed amendment.
- **T-WC1:** the statutory lead must use `deadline_detail` when it is set.
  - **Before:** "In Georgia you have 1 Year from the date of injury to file your claim (O.C.G.A. § 34-9-82)."
  - **After:** "In Georgia the claim is due 1 year from injury, extended by employer-paid treatment or benefits (O.C.G.A. § 34-9-82)."
  - The replacement is the approved `statute_overrides.GA.deadline_detail` string at `inc/firm-data.php:1016`, which the "Claim Deadline" law box on the same page already renders. Branch on `! empty( $pa_sol_ga['deadline_detail'] )`.
  - It is a new msgid, so add the ES translation.
  - **Authority:** `GA 34-9-82`.
- **T-WC2:** the GA card may keep "1 Year" as the large figure, but it must carry the extensions. When `deadline_detail` is set, render it in `sol-cite` instead of the bare cite. After: "1 Year" / "1 year from injury, extended by employer-paid treatment or benefits (O.C.G.A. § 34-9-82)".
- **T-WC3:** the sidebar `.deadline-cite` line under the badges should print `deadline_detail` when set, as `template-intersection.php:805` already does for `$sb_statute`.
  - The pillar widget `roden_deadline_badges_sidebar()` prints only the cite, so "1 yr" stands alone.
  - This is the Savannah WC E1 class on the pillar.
- **M-WC1:** in `_roden_why_hire`, "comparative-fault rules specific to South Carolina" -> "benefit rules specific to South Carolina".
  - **Authority:** `SC 42-9-60`: comparative negligence plays no part in a comp claim. This is the WC tort-leakage class.
  - The same sentence on the PI, car, truck and wrongful-death pillars is correct and is left alone.
- **M-WC2:** in `_roden_meta_description`, "Georgia allows 1 year to file, South Carolina 2." -> "Georgia generally allows 1 year to file, South Carolina 2."
  - **Authority:** `GA 34-9-82`.
  - "Over $300 million recovered" is a firm statistic; this sweep does not rule on it.

**Also seen (not in the README; noted, not batched):**
- **FAQ[5]** "a third-party claim against … a subcontractor … or property owner". In SC an owner or contractor can be the statutory employer (`SC 42-1-400`/`-410`, signed). Whether that makes it immune from suit is not signed.
  - In GA, § 34-9-11 (pending) also excludes co-employees.
  - Class: **gillin / ga-reviewer**. The safe wording is "such as an equipment manufacturer or a negligent driver".
- **FAQ[6]:** GA § 34-9-2 (three employees), SC § 42-1-360 (four employees). **FAQ[7]:** the GA 25% fee cap. None of these is in either pack. They are unsigned but not contradicted.
- **TEMPLATE `inc/template-tags.php:1712` / `:1658`:** step "File your claim" renders "File with the your state workers' compensation board" on two-state pillars.
  - The `filing_venue` fallback begins with "your" inside a msgid that already says "the".
  - Change the fallback to "workers' compensation board in your state". This is grammar only.

## wrongful-death-lawyers (3609) `/practice-areas/wrongful-death-lawyers/`

The README conflicts are **confirmed**, and a fifth was found (PB-WD3, an inverted one-third rule).

| # | Surface | Where it lives | Published | Class |
|---|---|---|---|---|
| PB-WD1 | FAQ[2] + FAQPage | `_roden_faqs[2]` | "In Georgia, the statute of limitations for wrongful death is 2 years from the date of death (O.C.G.A. § 9-3-33). In South Carolina, you have 3 years from the date of death (S.C. Code § 15-3-530)." | apply |
| PB-WD2 | FAQ[4] + FAQPage | `_roden_faqs[4]` | "Georgia uses the \"full value of the life\" standard (O.C.G.A. § 51-4-2)" | apply |
| PB-WD3 | FAQ[0] + FAQPage | `_roden_faqs[0]` | "When a surviving spouse files and there are children, the spouse must share at least one-third of the recovery equally among the children." | ga |
| PB-WD4 | FAQ[8] + FAQPage | `_roden_faqs[8]` | "South Carolina's threshold is 51%." | apply |
| T-WD1 | comparison table SOL row | TEMPLATE `inc/template-tags.php:3672` `$sol_sc_cell` | "3 years from the date of death (S.C. Code § 15-3-530)" | gillin |
| T-WD2 | "what to do" step 1 | TEMPLATE `inc/template-tags.php:1938` (GA/two-state branch) | "Georgia gives the claim first to the surviving spouse, then children, then parents, then the estate (O.C.G.A. § 51-4-2)." | ga |
| M-WD1 | negligence intro `{{GA}}` branch | META `_roden_pillar_negligence_intro` | "…with children sharing under O.C.G.A. § 51-4-2, and the action must be filed within 2 years of death (O.C.G.A. § 9-3-33)." | ga |

**Before -> after:**
- **PB-WD1:** -> "In Georgia, a wrongful death suit must be filed within 2 years (O.C.G.A. § 9-3-33). In South Carolina, the deadline is generally 3 years (S.C. Code § 15-3-530)."
  - **Authority:** `GA 51-4-1` (signed: the two-year WD deadline is § 9-3-33), `GA 9-3-33`, `SC 15-3-530`.
  - Neither signed claim carries a death-based start. The SC wording follows the house rule from the Charleston WD sweep. The template's own step 3 already avoids "from the date of death" for SC.
- **PB-WD2:** "(O.C.G.A. § 51-4-2)" -> "(O.C.G.A. § 51-4-1)".
  - **Authority:** `GA 51-4-1` (defines "full value of the life of the decedent").
  - The rest of the answer ("one of the broadest measures … often results in substantial recoveries") is firm characterization. No ruling was made on it.
- **PB-WD3:** -> "When a surviving spouse files and there are children, the spouse shares the recovery equally with them, but the spouse's share is never less than one-third."
  - As published, the sentence **inverts** § 51-4-2(d)(1): the one-third is the spouse's floor, not an amount the spouse must share out.
  - No signed authority covers it; § 51-4-2 is not in the GA pack. **ga-reviewer:** sign § 51-4-2 and apply this, or cut the sentence.
  - The two § 51-4-2 cites in FAQ[0] for standing are also unsigned (ga).
- **PB-WD4:** -> "South Carolina allows recovery as long as the deceased was 50% or less at fault (Nelson v. Concrete Supply Co.)."
  - **Authority:** `Nelson v. Concrete Supply Co.` "Threshold is 51%" can be read as a floor. The fault is the decedent's (`SC 15-51-10`).
- **T-WD1:** -> "Generally 3 years (S.C. Code § 15-3-530)", matching step 3's SC branch.
  - § 15-3-530(6) does run "upon the death", but the signed claim does not say so.
  - **gillin:** sign the amendment and the cell may keep "from the date of death".
- **T-WD2 / M-WD1:** true as far as the GA reviewer has said, but both rest on § 51-4-2, which is not in the pack. **ga-reviewer.** No change until it is signed. Clean-cut alternative: drop the parenthetical cite.
- **Also, not legal:** the comparison-table intro msgid `inc/template-tags.php:3698` reads "If you were injured in Georgia or South Carolina, the laws governing your wrongful death claim…". This is the "injured in a wrongful death" class; needs a WD branch ("If you lost a family member…").
- The KT box line 65 ("If you were injured in a wrongful death … less than 51% at fault") is the template paragraph that Part A replaces.

## medical-malpractice-lawyers (3608) `/practice-areas/medical-malpractice-lawyers/`

The README conflicts are **confirmed**, with one correction to the README: the "3 years from the date of the act" phrase is in **FAQ[1]**, the general SOL FAQ, not an SC-only FAQ. The § 15-79-125 sentence is published **twice**: in FAQ[2] and in the `_roden_why_hire` body block.

| # | Surface | Where it lives | Published | Class |
|---|---|---|---|---|
| PB-MM1 | FAQ[1] + FAQPage | `_roden_faqs[1]` | "…with an absolute 5-year statute of repose from the date of the negligent act. South Carolina allows 3 years from the date of the act or 3 years from discovery…" | apply |
| PB-MM2 | FAQ[2] + FAQPage | `_roden_faqs[2]` | "South Carolina has a similar requirement under S.C. Code § 15-79-125, requiring an expert opinion before filing." | apply |
| PB-MM3 | FAQ[5] + FAQPage | `_roden_faqs[5]` | "…sets a base of $350,000 against a single provider and $1.05 million where more than one is liable, adjusted annually for inflation." | apply |
| M-MM1 | body block | META `_roden_why_hire` | "South Carolina has similar expert requirements under S.C. Code § 15-79-125." | meta |
| M-MM2 | body block + FAQ[2] | META `_roden_why_hire`, `_roden_faqs[2]` | "Under O.C.G.A. § 9-11-9.1, every malpractice complaint must be accompanied by an expert affidavit … Failure to include this affidavit results in immediate dismissal." / "Without this affidavit, the court will dismiss the case." | ga |
| T-MM1 | "what to do" step | TEMPLATE `inc/template-tags.php:1809` | "…South Carolina requires a Notice of Intent to File Suit with an expert affidavit followed by mandatory mediation (S.C. Code § 15-79-125)." | template |

**Before -> after:**
- **PB-MM1:** -> "…with a 5-year statute of repose from the date of the negligent act. South Carolina allows 3 years from the treatment, omission or operation, or from when the injury was or should have been discovered, with a 6-year statute of repose (S.C. Code § 15-3-545)."
  - **Authority:** `GA 9-3-71` (§§ 9-3-72 and -73 fall outside the five years, so "absolute" contradicts the FAQ's own next sentence) and `SC 15-3-545`.
- **PB-MM2:** -> "South Carolina requires a qualified expert's affidavit, filed with a Notice of Intent to File Suit before the lawsuit (S.C. Code §§ 15-36-100, 15-79-125)."
  - **Authority:** `SC 15-36-100`, `SC 15-79-125`.
- **PB-MM3:** -> "…sets a base of $350,000 per provider or institution and $1.05 million in total, adjusted annually for inflation ($596,001 and $1,788,002 in 2026)."
  - **Authority:** `SC 15-32-220`. The aggregate is per claimant; it does not depend on more than one provider being liable. This is the unindexed-cap class from the 2026-09-26 table sweep.
- **M-MM1:** in `_roden_why_hire`, "South Carolina has similar expert requirements under S.C. Code § 15-79-125." -> "South Carolina requires a qualified expert's affidavit, filed with a Notice of Intent to File Suit (S.C. Code §§ 15-36-100, 15-79-125)."
  - **Authority:** `SC 15-36-100`, `SC 15-79-125`.
- **M-MM2:** O.C.G.A. § 9-11-9.1 is not in the GA pack, and "immediate dismissal" / "will dismiss" overstates a dismissal the statute lets a plaintiff cure in some cases. **ga-reviewer:** sign § 9-11-9.1. Until then, the clean cut is "Failure to include this affidavit results in immediate dismissal." -> "" (why_hire), and "Without this affidavit, the court will dismiss the case." -> "Without this affidavit, the case can be dismissed."
- **T-MM1:** "(S.C. Code § 15-79-125)" -> "(S.C. Code §§ 15-79-125, 15-36-100)". This is a new msgid, so add the ES translation.
- **FAQ[5], Georgia sentence:** rests on pending `Atlanta Oculoplastic Surgery v. Nestlehutt`. It also omits the § 51-12-5.1 punitive cap (pending) and the § 50-21-29(b)(2) State cap (pending). **ga-reviewer.** No change.
- The KT box line 65 (medical malpractice given the tort § 9-3-33 deadline) is the template paragraph that Part A replaces.

## brain-injury-lawyers (3612)

**Confirmed.**

| # | Surface | Where it lives | Class |
|---|---|---|---|
| PB-BI1 | FAQ[1] + FAQPage | `_roden_faqs[1]` | apply |

- **Before:** "However, in cases where the full extent of a brain injury is not immediately apparent, the discovery rule may apply — meaning the clock starts when you knew or should have known about the injury."
- **After:** "In Georgia, the clock runs from the date of injury even when the full extent of a brain injury is not yet apparent."
- **Authority:** `GA 9-3-33` (two years from the date of injury).
- The state-neutral "discovery rule may apply" is wrong for a Georgia traumatic injury.
  - South Carolina does have a discovery provision (§ 15-3-535), but it is **not in the SC pack**, so the replacement says nothing about the SC start. **gillin:** sign § 15-3-535 if the page should say so.
- No other brain-injury surface carries a discovery or seat-belt statement.

## pedestrian-accident-lawyers (3621)

**Confirmed.** Two more errors in the same class were found (PB-PED3, PB-PED4).

| # | Surface | Where it lives | Published | Class |
|---|---|---|---|---|
| PB-PED1 | FAQ[1] + FAQPage | `_roden_faqs[1]` | "…less than 50% at fault in Georgia or less than 51% in South Carolina…" | apply |
| PB-PED2 | FAQ[3] + FAQPage | `_roden_faqs[3]` | "Georgia and South Carolina both require UM coverage as part of auto insurance policies unless explicitly rejected in writing." | apply (**error** for SC) |
| PB-PED3 | FAQ[0] + FAQPage | `_roden_faqs[0]` | "For wrongful death claims, the same deadlines apply from the date of death." | apply |
| PB-PED4 | FAQ[8] + FAQPage | `_roden_faqs[8]` | "The statute of limitations for minors is tolled (paused) until the child turns 18" | apply (cut) |
| M-PED1 | body block | META `_roden_why_hire` | "Under Georgia law (O.C.G.A. § 40-6-91), drivers must yield to pedestrians in crosswalks and exercise due care to avoid colliding with any pedestrian on any roadway." | ga |
| PB-PED1 (cite) | FAQ[1] | `_roden_faqs[1]` | "(O.C.G.A. § 40-6-93)" | ga |

**Before -> after:**
- **PB-PED1:** -> "As long as you are less than 50% at fault in Georgia (O.C.G.A. § 51-12-33) or 50% or less at fault in South Carolina (Nelson v. Concrete Supply Co.), you can still recover damages, reduced by your percentage of fault."
  - **Authority:** `GA 51-12-33`, `Nelson`.
- **PB-PED2:** -> "South Carolina requires uninsured motorist coverage on every auto policy (S.C. Code § 38-77-150), and Georgia insurers must offer it (O.C.G.A. § 33-7-11)."
  - **Authority:** `SC 38-77-150` (mandatory, so it cannot be rejected), `GA 33-7-11`.
- **PB-PED3:** -> "For wrongful death claims, the same deadlines generally apply."
  - **Authority:** `GA 51-4-1`, `SC 15-3-530`, the same class as PB-WD1.
- **PB-PED4:** -> "Special deadline rules can apply to minors, but we recommend…"
  - This is a clean cut. "Tolled until 18" overstates South Carolina, where § 15-3-40 limits the extension to one year after the disability ends.
  - Neither § 15-3-40 nor O.C.G.A. § 9-3-90 is in a pack. **gillin / ga-reviewer** to restore a precise rule.
- **M-PED1 / §§ 40-6-91, -93:** not in the GA pack. The "due care … on any roadway" duty is § 40-6-93, not § 40-6-91. **ga-reviewer.**
  - Until it is signed, the clean fix in `_roden_why_hire` is "Under Georgia law (O.C.G.A. § 40-6-91), drivers must yield to pedestrians in crosswalks and exercise due care to avoid colliding with any pedestrian on any roadway." -> "Georgia law requires drivers to yield to pedestrians in crosswalks and to exercise due care toward pedestrians on any roadway."

## motorcycle-accident-lawyers (3607)

**README item: Georgia's universal helmet law, § 40-6-315, "not in the pack".**
- Partly true. It is not a `GA.json` authority, but the **signed SC pack** states it verbatim inside `SC 56-5-3660`'s claim: "(Georgia's universal helmet law is O.C.G.A. § 40-6-315.)"
- FAQ[1], `_roden_common_injuries` and the `{{GA}}` negligence-intro branch agree with that signed text. **No change. ga-reviewer:** add § 40-6-315 to GA.json so the GA pack carries it itself.

**SC bar wording:**
- FAQ[3]: "South Carolina allows recovery if you are less than 51% at fault." -> PB-F5 (below).

## bicycle-accident-lawyers (4087)

**Confirmed.** It is published twice, in FAQ[1] and the body.

| # | Surface | Where it lives | Class |
|---|---|---|---|
| PB-BK1 | FAQ[1] + FAQPage | `_roden_faqs[1]` | apply |
| PB-BK2 | body list item | `post_content` | apply |

- **PB-BK1:**
  - **Before:** "Georgia requires drivers to pass bicycles at a safe distance, generally interpreted as at least 3 feet. South Carolina (S.C. Code § 56-5-3435) similarly requires a safe passing distance."
  - **After:** "Georgia requires drivers to leave at least 3 feet when passing a bicycle (O.C.G.A. § 40-6-56). South Carolina requires a safe operating distance but names no distance (S.C. Code § 56-5-3435)."
  - **Authority:** `GA 40-6-56`, `SC 56-5-3435`. "Similarly" implied a matching South Carolina distance.
- **PB-BK2:**
  - **Before:** "requires drivers to maintain a safe distance when passing a bicycle — generally interpreted as at least 3 feet of clearance"
  - **After:** "requires drivers to leave at least 3 feet of clearance when passing a bicycle"
  - **Authority:** `GA 40-6-56`.
- `_roden_why_hire` already says "at least 3 feet" correctly.
- **Noted, not batched:**
  - FAQ[0] cites § 40-6-294 (ga).
  - FAQ[2] cites § 40-6-296(d) (under-16 helmets; ga) and says "South Carolina has no statewide bicycle helmet law" (gillin). Neither is in a pack, and neither is contradicted.

## The SC "51%" wording class (car, motorcycle, premises, spinal, PI, e-bike)

The README list is **confirmed**. The sweep also found it on the PI pillar (FAQ[2]) and in the e-bike **body**.
- None of these is false: for whole percentages, "less than 51%" equals "50% or less".
- They are aligned to the site's `Nelson` wording, because "threshold is 51%" also reads as a floor.
- **Authority:** `Nelson v. Concrete Supply Co.` (and `GA 51-12-33` where the GA half is rewritten).

| # | Post | Field | Before | After |
|---|---|---|---|---|
| PB-F1 | 4692 PI | faq2 | "At 50% (GA) or 51% (SC) plaintiff fault, recovery is barred entirely." | "At 50% or more fault in Georgia, or more than 50% in South Carolina, recovery is barred entirely." |
| PB-F2 | 4578 e-bike | content | "South Carolina allows recovery if you are less than 51% at fault." | "South Carolina allows recovery if you are 50% or less at fault (Nelson v. Concrete Supply Co.)." |
| PB-F3 | 3620 premises | faq7 | "In South Carolina, the threshold is 51%." | "In South Carolina, you can recover if you are 50% or less at fault (Nelson v. Concrete Supply Co.)." |
| PB-F4 | 3613 spinal | faq5 | "South Carolina's threshold is 51%." | "South Carolina allows recovery at 50% or less fault (Nelson v. Concrete Supply Co.)." |
| PB-F5 | 3607 motorcycle | faq3 | "South Carolina allows recovery if you are less than 51% at fault." | "South Carolina allows recovery if you are 50% or less at fault (Nelson v. Concrete Supply Co.)." |
| PB-F6 | 3604 car | faq1 | "South Carolina's threshold is 51%." | "South Carolina allows recovery at 50% or less fault (Nelson v. Concrete Supply Co.)." |

- **Left alone:** premises FAQ[2] ("threshold in South Carolina is 51% … meaning you can recover damages if you are 50% or less at fault") explains itself.
- **The wrongful-death instance** is PB-WD4, and the pedestrian one is PB-PED1.

## Template and meta fixes (not in the batch file; the applier cannot write them)

Theme changes go through a PR on `wordpress/wp-content/themes/roden-law/`. Every new or changed msgid needs its `es_ES.po` entry and a recompiled `.mo`. Meta changes need a `bin/` patcher (exact-match `str_replace`, `wp_slash`), and then a regenerated `content/meta.json`.

| # | Where | Before | After | Authority | Class |
|---|---|---|---|---|---|
| T-WC1 | `templates/template-practice-area.php:306` statutory lead | "In Georgia you have 1 Year from the date of injury to file your claim (O.C.G.A. § 34-9-82)." | "In Georgia the claim is due 1 year from injury, extended by employer-paid treatment or benefits (O.C.G.A. § 34-9-82)." (use `$pa_sol_ga['deadline_detail']` when set) | GA 34-9-82 | apply |
| T-WC2 | `template-practice-area.php:330` GA sol-card | "1 Year" / "O.C.G.A. § 34-9-82" | "1 Year" / `deadline_detail` in `sol-cite` | GA 34-9-82 | apply |
| T-WC3 | `inc/template-tags.php:1409` `roden_deadline_badges_sidebar()` | "1 yr" + bare cite | print `deadline_detail` in `.deadline-cite` when set (as `template-intersection.php:805` does) | GA 34-9-82 | apply |
| T-WC4 | `inc/template-tags.php:1658` `filing_venue` fallback | "File with the your state workers' compensation board" | fallback "workers' compensation board in your state" | none (grammar) | apply |
| M-WC1 | 3610 `_roden_why_hire` | "comparative-fault rules specific to South Carolina" | "benefit rules specific to South Carolina" | SC 42-9-60 | apply |
| M-WC2 | 3610 `_roden_meta_description` | "Georgia allows 1 year to file, South Carolina 2." | "Georgia generally allows 1 year to file, South Carolina 2." | GA 34-9-82 | apply |
| T-WD1 | `inc/template-tags.php:3672` WD `$sol_sc_cell` | "3 years from the date of death (S.C. Code § 15-3-530)" | "Generally 3 years (S.C. Code § 15-3-530)" | SC 15-3-530 | gillin (keep the start date only on a signed § 15-3-530(6) amendment) |
| T-WD2 | `inc/template-tags.php:1938` WD step 1 (GA branch) | "…(O.C.G.A. § 51-4-2)." | unchanged until § 51-4-2 is signed; cut alternative: drop the cite | none | ga |
| T-WD3 | `inc/template-tags.php:3698` comparison intro on WD | "If you were injured in Georgia or South Carolina, the laws governing your wrongful death claim…" | WD branch: "If you lost a family member in Georgia or South Carolina, the laws governing your wrongful death claim differ by state." | none (framing) | apply |
| M-WD1 | 3609 `_roden_pillar_negligence_intro` `{{GA}}` | "…with children sharing under O.C.G.A. § 51-4-2, and the action must be filed within 2 years of death (O.C.G.A. § 9-3-33)." | unchanged until § 51-4-2 is signed; cut alternative: "…and the action must be filed within 2 years (O.C.G.A. § 9-3-33)." | GA 51-4-1 (for the cut) | ga |
| M-MM1 | 3608 `_roden_why_hire` | "South Carolina has similar expert requirements under S.C. Code § 15-79-125." | "South Carolina requires a qualified expert's affidavit, filed with a Notice of Intent to File Suit (S.C. Code §§ 15-36-100, 15-79-125)." | SC 15-36-100, SC 15-79-125 | apply |
| M-MM2 | 3608 `_roden_why_hire` + FAQ[2] | "Failure to include this affidavit results in immediate dismissal." / "Without this affidavit, the court will dismiss the case." | cut / "Without this affidavit, the case can be dismissed." | none (§ 9-11-9.1 unsigned) | ga |
| T-MM1 | `inc/template-tags.php:1809` med-mal step | "(S.C. Code § 15-79-125)" | "(S.C. Code §§ 15-79-125, 15-36-100)" | SC 15-36-100 | apply |
| M-PED1 | 3621 `_roden_why_hire` | "Under Georgia law (O.C.G.A. § 40-6-91), drivers must yield to pedestrians in crosswalks and exercise due care to avoid colliding with any pedestrian on any roadway." | "Georgia law requires drivers to yield to pedestrians in crosswalks and to exercise due care toward pedestrians on any roadway." | none (cite cut) | ga |

**ES twins.** The EN pillars have ES twins, for example 3610 -> 4875 via `_roden_translation_es`. The same FAQ classes should be swept on the twins before the batch is applied; they were not in this dump. This is the 2026-07-31 Spanish-twin lesson in CLAUDE.md.

---

# Replay

- **Part A:** 58/58. The 24 final paragraphs on 2 surfaces each returned nothing, and all 10 controls fired.
- **Part B:** `scratchpad/partb-fixture.json`, **63/63**. It contained:
  - every non-empty `to` (21)
  - every patched field in full after all edits (22 fields)
  - the 10 meta/template replacements above
  - the 10 positive controls, which all fired.
- **Published `from` strings** (`scratchpad/partb-from.json`, informational): **0 of 23 were caught by any rule.** Every Part B finding was manual. This is the engine gap.

# Proposed pack rules (each needs a fixture control first; no rule was changed here)

| Proposed rule | State | Would catch | Severity |
|---|---|---|---|
| `sc-um-rejectable` | SC | "both require UM … unless (explicitly) rejected in writing" (PB-PED2) | error |
| `medmal-repose-absolute` | GA, SC | "never more than five years" / "absolute 5-year … repose" near § 9-3-71 / § 15-3-545 (A5, PB-MM1) | warn |
| `ga-pi-discovery-rule` | GA | "discovery rule may apply" near § 9-3-33 (PB-BI1). This extends `ga-medmal-discovery-rule`'s logic to the tort SOL | warn |
| `ga-three-foot-interpreted` | GA | "safe distance … generally interpreted as at least 3 feet" (PB-BK1/2) | warn |
| `wc-occupational-disease-trigger` | GA, SC | an occupational-disease start date stated without an outer limit | warn |
| `sctca-three-year-default` (widen) | SC | "against a South Carolina county" (the writer's README engine gap) | existing |

# Counts

**Part A:**
- 18 PASS.
- 6 CHANGE: med mal (1 error, A5), boating, product, maritime, dog bite, truck.

**Part B batch (`pillar-conflicts-batch-2026-09-29.json`):** 23 edits on 12 posts.

| Class | Count | Ids |
|---|---:|---|
| apply | 20 | PB-WC1, PB-WD1, PB-WD2, PB-WD4, PB-MM1–3, PB-BI1, PB-PED1–4, PB-F1–6, PB-BK1–2 |
| gillin | 1 | PB-WC3 |
| ga | 2 | PB-WC2, PB-WD3 |

**Part B, not batchable:**
- 8 TEMPLATE: T-WC1–4, T-WD1–3, T-MM1. The KT box that Part A replaces is not counted.
- 6 META: M-WC1–2, M-WD1, M-MM1–2, M-PED1.

**By rule:** all Part B findings are manual (no rule). Part A A5 is also manual.

**Surfaces:**
- 20 of the 23 batch edits are FAQ answers, so each one is also a FAQPage JSON-LD fix.
- 3 are `post_content`.

# False positives

**None.** No rule fired on any correct sentence, so no `unless` guard is proposed.

# Open attorney items raised here

- **gillin:**
  - SC occupational-disease trigger (§ 42-15-40)
  - § 15-3-530(6) "upon the death" amendment (T-WD1)
  - § 15-3-535 discovery (brain)
  - § 15-3-40 minor tolling (pedestrian)
  - comparative fault in strict product and § 47-3-110 dog-bite claims (A2, A4)
  - SC bicycle-helmet statement
  - nursing-home SOL / repose (3)
- **ga-reviewer:**
  - sign `GA 34-9-17` (the WC paragraph and FAQ[8] rest on it)
  - § 34-9-281 (PB-WC2)
  - § 51-4-2 (PB-WD3, T-WD2, M-WD1)
  - § 9-11-9.1 (M-MM2)
  - §§ 40-6-91/-93 (M-PED1)
  - § 40-6-315 into GA.json
  - § 9-3-90 (minor tolling)
  - § 9-3-70 nursing-home scope
