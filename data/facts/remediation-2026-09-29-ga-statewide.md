# Pre-publish legal sweep: six Georgia statewide pillar pages (posts 6317–6322, DRAFT)

- **Pages (all `page`, draft, template `template-pillar-ga-statewide.php`):**
  - 6317 `/georgia-personal-injury-lawyer/`
  - 6318 `/georgia-car-accident-lawyers/`
  - 6319 `/georgia-truck-accident-lawyers/`
  - 6320 `/georgia-motorcycle-accident-lawyer/`
  - 6321 `/georgia-wrongful-death-lawyer/`
  - 6322 `/georgia-workers-compensation-lawyer/`
- **Jurisdiction:** Georgia only. The author of record is Eric Roden (attorney post 3729).
  - The owner states Eric Roden has cleared these pages. This sweep records that statement as relayed and did not see it directly.
  - Georgia claims that rest on **pending** pack authorities rest on his review, consistent with the Savannah WC sweep of 2026-09-26. His clearance does not sign a pending authority in the shared pack.
- **Pack:** `internal-ai-scripts/law/GA.json` (main at 49a460f). It is **signed**: 22 signed authorities and 11 pending. Pending authorities that touch these pages:
  - `GA 34-9-11` (exclusive remedy / third-party suits)
  - `GA 34-9-17` (fault-based bars to comp)
  - `GA 33-34-4` (compulsory liability insurance)
- **What was swept:**
  - **Source:** `data/practice-area-drafts/2026-09/ga-statewide/*.json`. Every field that publishes: `body_html`, `key_takeaways`, `meta_description`, and 6 FAQs per page.
  - **Rendered drafts:** `scratchpad/ga/draft{6317..6322}.txt` / `.html` / `-ld.json`. This covers the key takeaways box, the law callout (TEMPLATE), the office strip, the FAQ accordion, the bottom CTA and all 3 JSON-LD blocks per page (LegalService, FAQPage, BreadcrumbList). All of them parse.
  - The FAQPage JSON-LD matches the visible FAQs character for character on all six pages.
  - The meta, og and twitter descriptions match the source `meta_description` on all six.
- **Render coverage gap (not a template defect):** the rendered `.html` / `.txt` contain **no body**. The render harness queried a *draft* as an anonymous WP-CLI user, WP_Query drops non-public posts, so the `while ( have_posts() ) the_content()` loop never ran.
  - The body was therefore swept from the source JSON. `bin/create-ga-statewide-pages.php` verified that source byte-equal to `post_content` at apply time.
  - After publishing, render one page and confirm the body appears between the key takeaways box and the law callout.
- **Engine run:** 505 blocks were replayed through `sweep-claims.mjs --fixtures scratchpad/ga-statewide-fixture.json --states GA`. The blocks were every rendered line, every body paragraph, each KT, meta description, FAQ and JSON-LD string, plus per-page whole-body and whole-page blocks.
  - Result: **0 findings.**
  - Positive controls all fired: `georgia-is-no-fault`, `municipal-ante-litem-12-months`, `wrongful-death-deadline-cited-to-definitions`, `seat-belt-percentage-cap`.
  - Every corrected sentence below was re-swept: 5/5 clean.
- **Primary text read this pass (Wayback snapshots of Justia; Justia itself serves a bot challenge):**
  - § 9-3-71: `web.archive.org/web/20241108124121/https://law.justia.com/codes/georgia/title-9/chapter-3/article-4/section-9-3-71/`
  - § 51-11-7: `web.archive.org/web/20241010194829/https://law.justia.com/codes/georgia/title-51/chapter-11/article-1/section-51-11-7/`
  - § 34-9-11: `web.archive.org/web/20241111204703/https://law.justia.com/codes/georgia/title-34/chapter-9/article-1/section-34-9-11/`
  - § 34-9-17: `web.archive.org/web/20250213234232/https://law.justia.com/codes/georgia/title-34/chapter-9/article-1/section-34-9-17/`
  - SB 68 applicability (Section 9): `docs/briefs/2026-08-07-georgia-tort-reform-sb68.md`.

Source key:
- **PAGE** means the draft's source JSON / post content and meta.
- **TEMPLATE** means the theme. A TEMPLATE fix reaches other pages too.
- **LINKED/LIVE** means an already-published page.

## Verdicts

| Post | Page | Verdict | Findings |
|---|---|---|---|
| 6317 | Personal injury | **FAIL** | E1 (3 surfaces) |
| 6318 | Car | PASS | W4, I1, I2 |
| 6319 | Truck | PASS | I2 |
| 6320 | Motorcycle | PASS | I3 |
| 6321 | Wrongful death | PASS (fix W2 before publish recommended) | W2, I4 |
| 6322 | Workers' comp | PASS (fix W1 before publish recommended) | W1, W3 |

- **SC leaks:** none on any page. There is no S.C. Code cite, no 51% or three-year figure, and no SCTCA, Commission or § 42- cite inside the article.
  - The callout rendered its GA branch on all six. On 6322 it rendered its WC branch, so there is no tort law on the WC page.
- **Tort leakage on the WC page:** none. The only "two years" on 6322 is the correct last-weekly-payment prong. The page says outright that there is no two-years-from-injury rule.

---

## ERROR

### E1. 6317: medical malpractice "two years from injury or discovery" (§ 9-3-71)

- **Surfaces (PAGE):** `key_takeaways`, `body_html` (H2 "How long do I have to file…"), `faq0` (visible and FAQPage JSON-LD).
- **Published / corrected:**
  - **key_takeaways:** "Medical malpractice claims carry two years from injury or discovery and a five-year statute of repose (O.C.G.A. § 9-3-71)."
    → "Medical malpractice claims generally carry two years from the date of injury and a five-year statute of repose (O.C.G.A. § 9-3-71)."
  - **body_html:** "Medical malpractice claims have two years from the injury or its discovery, with a five-year statute of repose (O.C.G.A. § 9-3-71)."
    → "Medical malpractice claims generally have two years from the date of injury, with a five-year statute of repose (O.C.G.A. § 9-3-71)."
  - **faq0:** "Medical malpractice claims have two years from injury or discovery with a five-year statute of repose (O.C.G.A. § 9-3-71), and claims against a government body require written notice much sooner."
    → "Medical malpractice claims generally have two years from the date of injury, with a five-year statute of repose (O.C.G.A. § 9-3-71), and claims against a government body require written notice much sooner."
- **Authority:** `GA 9-3-71` (signed). The page copies the signed `claim` ("Two years from the date of injury or discovery…"). **That claim is broader than the statute:**
  - § 9-3-71(a): "within two years after the date on which an injury or death arising from a negligent or wrongful act or omission occurred."
  - (b) is the five-year repose; (c) calls (a) "a two-year statute of limitations".
  - There is no discovery language in the section. Discovery-type timing exists only in narrow case law (misdiagnosis, where the injury "occurs" when symptoms manifest) and in § 9-3-72 (foreign objects, which is not in the pack).
- **Why error:** a reader told the clock runs from *discovery* can miss the real deadline. "Generally" preserves the case-law exceptions without stating them.
- **Rule:** none. The engine passed all three surfaces.
- **Pack follow-up (pack PR; do not edit here):**
  - Amend the `GA 9-3-71` `claim` to "Two years from the date on which the injury or death occurred, with a five-year statute of repose; (a) contains no discovery rule." Evidence: the snapshot above. This needs re-signature by the GA pack attorney.
  - Then add rule `ga-med-mal-discovery` (error): assert `(?:2|two) years from (?:the date of )?(?:injury or )?(?:its )?discovery` near `9-3-71|malpractice`, fixtures first.
- **Same class, LIVE (content/meta.json FAQs), for the next batch:**
  - Med-mal FAQs:
    - `/medical-malpractice-lawyers/anesthesia-error/` ("2 years from the date of injury or discovery")
    - `/medical-malpractice-lawyers/emergency-room-negligence/` ("from injury or discovery")
    - `/medical-malpractice-lawyers/informed-consent-failure/` ("from the date of injury or discovery")
    - `/medical-malpractice-lawyers/hospital-acquired-infection/` ("2 years from discovery")
    - `/medical-malpractice-lawyers/medication-error/` ("2 years from discovery")
  - The same class under § 9-3-33:
    - `/nursing-home-abuse-lawyers/nursing-home-neglect/` ("2 years from the date of injury or discovery")
    - `/product-liability-lawyers/dangerous-pharmaceutical-drug/` and `/product-liability-lawyers/defective-medical-device/` ("2 years from discovery of the injury", with a "10-year statute of repose" that no pack authority backs)

---

## WARN

### W1. 6322: the third-party claim sentence covers co-workers, who are immune

- **Surface (PAGE):** `body_html`, H2 "Can I bring a claim against someone other than my employer?"
- **Published:** "Sometimes, yes. If someone other than your employer caused the injury, such as a negligent driver who hit you during a work trip, you may also have a separate personal injury claim against that person."
- **Corrected:** "Sometimes, yes. If someone other than your employer or a co-worker caused the injury, such as a negligent driver from another company who hit you during a work trip, you may also have a separate personal injury claim against that person."
- **Authority:** pending `GA 34-9-11`, on Eric Roden's review.
  - § 34-9-11(a), read this pass: "No employee shall be deprived of any right to bring an action against any third-party tort-feasor, **other than an employee of the same employer** or any person who … provides workers' compensation benefits…"
  - A negligent co-worker driving on a work trip is "someone other than your employer" and is immune.
- **Rule:** none.
- **Assessment (e):** the section's *sourcing* is acceptable on Eric Roden's review, and "Sometimes" and "may" hedge it. The co-employee over-breadth is a text-verified inaccuracy, and the fix is one phrase, so change it before publish.
  - "That claim has its own deadline and its own rules" is correct, and no cite is needed.
- **Pack follow-up:** add the co-employee exclusion to the pending `GA 34-9-11` `claim`. This was already suggested in the Savannah WC sweep (W4 there).

### W2. 6321: the law callout gives the personal-injury "from the date of injury" deadline on the wrongful-death page

- **Surface (TEMPLATE):** `roden_statewide_law_callout('GA')`, the non-WC branch in `inc/template-tags.php` (function at line ~3896). It renders the same card on the WD page.
- **Published:** "Georgia generally gives injured people 2 years from the date of injury to file a personal injury lawsuit. A claim against a city requires written notice within six months, and against a county or the State within twelve months."
- **Corrected (GA + `$is_wd` only):** "Georgia generally gives families 2 years to file a wrongful death lawsuit. A claim against a city requires written notice within six months, and against a county or the State within twelve months."
- **Authority:** `GA 9-3-33` and `GA 51-4-1` (signed). "The two-year wrongful death deadline is § 9-3-33."
- **Why:** the page's own copy deliberately states no start date, because the pack has no accrual-at-death authority. The callout is the only surface that says "from the date of injury", and it speaks to "injured people" about a "personal injury lawsuit" on a page for families.
  - This is warn, not error. Where the death follows the injury, the stated date is earlier, not later, so it cannot make a family miss the deadline. But it is wrong for the page.
- **Implementation:** add an `elseif ( $is_wd )` for GA. It is a new msgid: add the ES entry and recompile `es_ES.mo`.
  - The SC WD statewide page has the same structural issue in its SC branch; see the Charleston WD sweep (2026-09-28) for the SC wording.
- **Also (info):** the WD comparative-fault card prints no cite. Add `<p class="cite"><?php echo esc_html( $law['comp_fault_cite'] ); ?></p>` to the `$is_wd` branch.

### W3. 6322: the "Fault: No-fault" card (TEMPLATE) rests on pending § 34-9-17

- **Surface (TEMPLATE):** the WC branch of `roden_statewide_law_callout()`, shared with SC WC statewide pages.
- **Published:** "Fault — No-fault — benefits do not depend on proving employer negligence"
- **Assessment (e):** **acceptable as published**, on Eric Roden's review.
  - It is correct against the primary text. The only fault-based bars in § 34-9-17 are the *employee's* willful misconduct and intoxication or drugs, and the burden is on the party claiming the forfeiture ((c)).
  - It is the same wording as the live Savannah WC page, which the 2026-09-26 sweep judged correct.
  - It is not a new pack-backed claim. It is an unsigned claim that rests on the reviewer, and it remains so until `GA 34-9-17` is signed.
- **Optional (not required):** a GA-only variant that states the carve-out: "No-fault — benefits do not depend on proving employer negligence, though willful misconduct or intoxication can bar a claim (O.C.G.A. § 34-9-17)". Use it only once `GA 34-9-17` is signed.
- **Rule:** none. The engine's `georgia-is-no-fault` rule correctly does not fire, because it targets auto insurance.

### W4. 6318: "Georgia is an at-fault (tort) state" has no pack authority

- **Surfaces (PAGE):** `key_takeaways`, the body H2 "Who pays after a car accident in Georgia?", and `faq0`.
- **Assessment:** true, and the inverse is a documented live error (`georgia-is-no-fault`). No signed authority states it. The nearest is pending `GA 33-34-4` (compulsory liability insurance). It rests on Eric Roden's review. No change is required.

---

## INFO

- **I1 (6318):** the seat belt sentences are acceptable. See (b).
- **I2 (6318, 6319, 6320): "personal auto policies must carry at least $25,000 per person and $50,000 per accident … (O.C.G.A. § 33-7-11)".**
  - The page matches the signed `GA 33-7-11` claim.
  - The pending `GA 33-34-4` records that the liability minimum is the § 33-34-4 → § 40-9-37 chain, and that § 33-7-11 governs UM.
  - No change is needed now. When `GA 33-34-4` is signed, re-cite the liability-minimum clause as "(O.C.G.A. §§ 33-34-4, 40-9-37)" and keep § 33-7-11 for UM.
- **I3 (6320):** the helmet law (§ 40-6-315) is omitted by design (writer's flag). The page makes no helmet claim beyond "insurers may raise it", which is accurate and hedged. No finding.
- **I4 (6321):** standing (§ 51-4-2), the estate claim (§ 51-4-5) and funeral and medical expenses are omitted by design (writer's flags). Nothing the page does say is false by omission, because "full value of the life" is stated as the measure of the wrongful-death claim. Add §§ 51-4-2 and 51-4-5 to the pack before a "who can file" section is written.
- **I5 (all, TEMPLATE, not legal):** the LegalService JSON-LD description reads "represents personal injury injury victims", "wrongful death injury victims" and "workers' compensation injury victims". The cause is `inc/schema-helpers.php:2988` appending "injury victims" after the practice label. It is a copy defect, not a legal one.
- **I6 (all, not legal):** the PI page repeats the firm stats "$300M+ recovered, 5,000+ cases handled, 62 years … 4.9-star average across 500+ client reviews". They match `inc/firm-data.php` (checked live 2026-08-19). They are outside the law layer.

## Specific assessments

- **(a) § 51-11-7 as used (6317, 6318, 6320): ACCEPTABLE.**
  - "bars recovery entirely when the injured person could have avoided the consequences of the other party's negligence by ordinary care" matches the signed `GA 51-11-7` claim.
  - It also matches the primary text: "If the plaintiff by ordinary care could have avoided the consequences to himself caused by the defendant's negligence, he is not entitled to recover."
  - It is correctly framed as "a separate rule", not the apportionment rule, so `comparative-negligence-wrong-statute` stays clear.
- **(b) Seat belt vs § 40-8-76.1 (6318 body + faq3): ACCEPTABLE.**
  - It tracks the signed claim nearly verbatim: SB 68, subsection (d), the five issues, "may diminish", and "no fixed limit" (no percentage cap).
  - No start-date caveat is needed. SB 68 Section 9 limits only Sections 6 and 7 to new causes of action, and the seat-belt amendment (Section 5) reaches pending ones (repo brief).
- **(c) Truck § 9-3-32 / § 9-3-33 (6319 body + faq0): ACCEPTABLE.**
  - "two years from the date of injury … § 9-3-33" matches the signed claim.
  - "Damage to your vehicle or other property carries a four-year period (§ 9-3-32)" and "Vehicle or cargo damage has a separate four-year period" match the signed `GA 9-3-32` claim, which names vehicle damage and cargo.
- **(d) Wrongful death (6321): ACCEPTABLE in the page copy.**
  - "full value of the life of the decedent, a term defined in § 51-4-1" is accurate. § 51-4-1 defines the term; the page does not claim § 51-4-1 creates the claim or the deadline.
  - "generally two years … under § 9-3-33" is exactly the signed `GA 51-4-1` claim, and it avoids `wrongful-death-deadline-cited-to-definitions`.
  - The only problem is the template callout (W2).
- **(e) WC third party and the No-fault card (6322):**
  - Third-party sentence: sourcing acceptable on Eric Roden's review (pending `GA 34-9-11`), but **change** it to exclude co-workers (W1). His clearance does not cure a text-verified over-breadth.
  - "No-fault" card: **acceptable** as published (W3).

## Required and recommended changes (exact strings)

| # | Page | Field | Before | After | Status |
|---|---|---|---|---|---|
| E1a | 6317 | key_takeaways | Medical malpractice claims carry two years from injury or discovery and a five-year statute of repose (O.C.G.A. § 9-3-71). | Medical malpractice claims generally carry two years from the date of injury and a five-year statute of repose (O.C.G.A. § 9-3-71). | REQUIRED |
| E1b | 6317 | body_html | Medical malpractice claims have two years from the injury or its discovery, with a five-year statute of repose (O.C.G.A. § 9-3-71). | Medical malpractice claims generally have two years from the date of injury, with a five-year statute of repose (O.C.G.A. § 9-3-71). | REQUIRED |
| E1c | 6317 | faq0 | Medical malpractice claims have two years from injury or discovery with a five-year statute of repose (O.C.G.A. § 9-3-71), | Medical malpractice claims generally have two years from the date of injury, with a five-year statute of repose (O.C.G.A. § 9-3-71), | REQUIRED |
| W1 | 6322 | body_html | If someone other than your employer caused the injury, such as a negligent driver who hit you during a work trip, | If someone other than your employer or a co-worker caused the injury, such as a negligent driver from another company who hit you during a work trip, | RECOMMENDED before publish |
| W2 | 6321 | template | Georgia generally gives injured people 2 years from the date of injury to file a personal injury lawsuit. | Georgia generally gives families 2 years to file a wrongful death lawsuit. (GA + `$is_wd` branch only; new msgid, add ES + recompile .mo) | RECOMMENDED before publish |

**Apply path:**
- E1 and W1: fix the source JSON, re-run `bin/create-ga-statewide-pages.php` (drafts, `wp_slash`), then re-run the sweep and `verify-faq-drafts.mjs`.
- W2: a theme PR, followed by a deploy.

## Counts by rule

| Rule | Findings |
|---|---|
| (no rule; hand reading) | E1 ×3 surfaces, W1, W2, W3, W4 |
| all GA pack rules | 0 |

## False positives

None. The engine raised no findings.

## Pack follow-ups (PR against internal-ai-scripts; never a silent edit)

1. **Amend `GA 9-3-71` `claim`:** remove "or discovery". Add rule `ga-med-mal-discovery`, with fixtures first: the 3 E1 sentences as positives, and the corrected sentences as controls.
2. **Pending `GA 34-9-11`:** add the co-employee and benefit-provider exclusions to the `claim`.
3. **Propose pending authorities:**
   - § 9-3-72 (foreign objects)
   - §§ 51-4-2 and 51-4-5 (WD standing and the estate claim)
   - § 40-6-315 (helmets)
   - WD accrual at death, if the attorney wants the start date stated.
   - Each needs primary text read first.


## Correction, 2026-09-30

Item (b)'s conclusion that no start-date caveat is needed on page 6318 is **wrong**. SB 69 (Act 10, 2025) § 5(c)(2) revised § 40-8-76.1(d) in the same words as SB 68 § 5 and limits it to causes of action commenced on or after 2025-04-21; the Code editor's note says SB 69's applicability governs. The live text is true for suits filed today but omits the limit. Wording and approval are with Eric Roden; see ga-statute-currency-2026-09-30.md §§ 2, 9.
