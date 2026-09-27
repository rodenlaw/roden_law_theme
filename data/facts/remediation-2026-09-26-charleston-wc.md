# Pre-publish legal sweep: Charleston workers' compensation page (post 3654, DRAFT)

- **Page:** `/workers-compensation-lawyers/charleston-sc/` (post 3654, `practice_area`, draft; parent: WC pillar, post 3610).
- **Jurisdiction:** South Carolina only. Reviewer of record: Graeham C. Gillin (SC Bar).
- **What was swept:** the rendered draft HTML (`scratchpad/preview/draft3654.html`) and all 7 JSON-LD blocks in it (LegalService, Person, FAQPage, WebPage, HowTo, LocalBusiness/LegalService/LawFirm, BreadcrumbList). All 7 parse.
  - **Page surfaces**, from `bin/rebuild-charleston-workers-comp.php`: body, excerpt (rendered as the "What Is a Workers' Compensation Case" block), meta description (also the LegalService `description`), key takeaways, 6 FAQs.
  - **Template blocks:** hero, NAP bar, office map and directions, the SC WC what-to-do steps and HowTo (#175), the law box, the sidebar deadline widget (#176), the WC pillar's "Do I Have a Case" and "Types of Compensation" intros (post 3610, as corrected today by `bin/fix-wc-pillar-intros.php`), the SC statewide up-link, the stats block, resources, the bottom CTA and the footer.
- **Pack:** `law/SC.json` at `origin/main`. It is **SIGNED** (Graeham C. Gillin, 2026-09-26). But it holds only two workers' comp authorities: `SC 42-15-20` and `SC 42-15-40`. See B1.
- **Engine run:**
  - 162 blocks were replayed through `sweep-claims.mjs --fixtures scratchpad/draft3654-fixture.json --law scratchpad/law-main3654/law --states SC,GA`, plus the whole page as one block. The blocks came from the rendered text and every JSON-LD `text`/`description`/`name`.
  - Result: **0 findings.**
  - A positive control fired `wc-deadline-cited-to-tort-statute`: a WC deadline cited to § 15-3-530.
  - Every finding below comes from hand reading, by claim class, against the primary text. I read chapters t42c001, t42c005, t42c009 and t42c015 at scstatehouse.gov on 2026-09-26.

**Verdict: FAIL. There is one error-level finding (E1, TEMPLATE) and one publish blocker (B1, pack).**
- The page's own copy (PAGE) has no error. Every statute is cited and linked correctly. There is no 3-year SOL, no § 15-3-530, no Nelson/51%, no Georgia law and no posted panel.
- Tort leakage exists in two template sentences (E1, W5).
- There are 7 warnings.

Source key:
- **PAGE** means `bin/rebuild-charleston-workers-comp.php` or post 3654's existing meta.
- **TEMPLATE** means the theme or WC-pillar meta. A TEMPLATE fix reaches other pages too.

---

## BLOCKER

### B1. Three cited statutes have no authority in the signed pack

- **Surfaces:** body, key takeaways, FAQs 3–6 (and their FAQPage JSON-LD), the "Do I Have a Case" and "Types of Compensation" pillar blocks.
- **Source:** PAGE and TEMPLATE. The rebuild script's docblock says "Every statute is from internal-ai-scripts/law/SC.json". For three sections that is not true.
- **Claims with no pack authority:**
  - § 42-1-540, exclusive remedy: body, KT, FAQ 3, FAQ 6, and the pillar "Do I Have a Case" block.
  - § 42-9-60, intoxication / wilful intention, and the burden: body, FAQ 4.
  - § 42-9-10, 66 2/3% of AWW, the state-AWW cap and 500 weeks: body, KT, FAQ 5, and the pillar "Types of Compensation" block.
- **The substance checks out against the primary text** (details under W1–W3). What is missing is the signed authority. Under rule 1, an authority cannot back a new claim until the attorney signs it.
- **Action:** open a pack PR adding these three as authorities with `verifiedBy: null`, and put them in Gillin's sign-off packet for this page. Proposed entries:

```json
{ "id": "SC 42-1-540", "cite": "S.C. Code § 42-1-540", "subject": "workers' compensation exclusive remedy",
  "claim": "When employer and employee have accepted the Act, its rights and remedies exclude all other rights and remedies of the employee (and personal representative, dependents, next of kin) against the employer, at common law or otherwise. The bar does not reach acts of another subcontractor (or its employees) hired by a common employer. Separately, an employer that fails to secure compensation can be sued at law (§ 42-5-40).",
  "quantities": [], "evidence": "https://www.scstatehouse.gov/code/t42c001.php (read 2026-09-26)", "verifiedBy": null },
{ "id": "SC 42-9-60", "cite": "S.C. Code § 42-9-60", "subject": "workers' compensation intoxication / wilful-intent defense",
  "claim": "No compensation is payable if the injury or death was occasioned by the employee's intoxication or wilful intention to injure or kill himself or another. The burden of proof is on the person claiming the section applies.",
  "quantities": [], "evidence": "https://www.scstatehouse.gov/code/t42c009.php (read 2026-09-26)", "verifiedBy": null },
{ "id": "SC 42-9-10", "cite": "S.C. Code § 42-9-10", "subject": "workers' compensation total disability rate and duration",
  "claim": "Total disability pays 66 2/3% of the employee's average weekly wage, not more than the State average weekly wage for the preceding fiscal year and not less than $75 a week (or the actual AWW if lower), for no more than 500 weeks — except that a totally and permanently disabled paraplegic, quadriplegic, or person with physical brain damage receives benefits for life (subsection (C)).",
  "quantities": ["66 2/3%", "66⅔%", "sixty-six and two-thirds percent", "500 weeks", "five hundred weeks", "$75"],
  "evidence": "https://www.scstatehouse.gov/code/t42c009.php (read 2026-09-26)", "verifiedBy": null }
```

- **Evidence note:** Justia sits behind a Cloudflare challenge from here, so I read the text at scstatehouse.gov.

---

## ERROR

### E1. The SC statewide up-link promises a "comparative-fault rule" on a workers' comp page

- **Surface / block:** body, the line under the rules section, "Serving all of South Carolina".
- **Source:** TEMPLATE, `inc/template-tags.php:2728`, `roden_sc_statewide_uplink()`. This is one msgid for every practice area, with an ES twin at `languages/es_ES.po:2209`.
  - It renders on every SC intersection whose statewide pillar is published, and `/south-carolina-workers-compensation-lawyer/` is published.
  - This draft is the first SC WC intersection to render it. `content/meta.json` lists no other SC WC intersection. It will render on the Columbia, Myrtle Beach and North Charleston WC pages when they are built.
- **Published:** "Serving all of South Carolina: see our statewide South Carolina Workers’ Compensation Lawyers page for South Carolina’s filing deadline, comparative-fault rule, and how these cases work across the state."
- **Corrected (WC branch):** "Serving all of South Carolina: see our statewide South Carolina Workers’ Compensation Lawyers page for South Carolina’s notice and filing deadlines and how these claims work across the state."
  - Implement this as a separate msgid, selected when `$parent_slug === 'workers-compensation-lawyers'`. Keep the tort msgid unchanged for the other pillars.
  - Add the ES translation of the new msgid and recompile `es_ES.mo` (CLAUDE.md gotcha).
- **Authority:** `SC 42-15-20`, `SC 42-15-40` (signed); proposed `SC 42-1-540` (B1). Workers' comp has no comparative-fault rule, and fault is not a defense except under § 42-9-60.
- **Rule:** none. This is tort leakage: the reader is told a comparative-fault rule governs their WC claim. Two paragraphs earlier the page says "Fault does not matter, with two exceptions". The page contradicts itself.
- **Pack follow-up (proposed rule, `warn`):** `wc-comparative-fault-leak`, which fires on `comparative[- ]fault|comparative negligence|\b5[01]%` when the context contains `workers' comp`. Its `unless` would be `third[- ]party|not the|does not apply|no comparative`, so that the pillar's correct sentence "Fault does matter in one place: a third-party claim … comparative-fault rules apply" passes. Add that sentence as a control in `law/fixtures/` before the rule lands.

---

## WARN

### W1. "For up to 500 weeks" omits the lifetime benefit in § 42-9-10(C)

- **Surfaces:** body ("What workers’ comp pays"), key takeaways, FAQ 5 and its FAQPage JSON-LD (PAGE); the pillar "Types of Compensation" block (TEMPLATE, post 3610 `_roden_pillar_compensation_intro`). There are 4 surfaces, and the same sentence appears on each.
- **Published (body):** "Total disability pays 66 2/3% of your average weekly wage, no more than the state average weekly wage, for up to 500 weeks (S.C. Code § 42-9-10)."
- **Corrected (body, FAQ 5, pillar block):** "Total disability pays 66 2/3% of your average weekly wage, no more than the state average weekly wage, for up to 500 weeks, or for life for a worker left paraplegic, quadriplegic or with physical brain damage (S.C. Code § 42-9-10)."
- **Published (KT):** "Total disability pays 66 2/3% of your average weekly wage, up to the state average weekly wage, for up to 500 weeks (S.C. Code § 42-9-10)."
- **Corrected (KT):** "Total disability pays 66 2/3% of your average weekly wage, up to the state average weekly wage, generally for up to 500 weeks (S.C. Code § 42-9-10)."
- **Authority:** proposed `SC 42-9-10` (B1). § 42-9-10(A) says "except as provided in subsection (C)", and (C) provides lifetime benefits.
- **Rule:** none. The rest of the sentence is accurate: 66 2/3%, the cap at the State AWW for the preceding fiscal year, and 500 weeks as the general limit.

### W2. FAQ 6 states the exclusive remedy with no condition

- **Surface:** FAQ 6 and its FAQPage JSON-LD. PAGE (`$faqs[5]`). The body, KT and FAQ 3 are all hedged ("Where you and your employer are under the Act", "generally", "Usually not"). FAQ 6 stands alone in schema without a hedge.
- **Published:** "Not from workers' compensation. There are no pain-and-suffering or punitive damages from the employer (S.C. Code § 42-1-540). A separate claim against a third party who caused the injury can include them."
- **Corrected:** "Not from workers' compensation. Where you and your employer are under the Workers' Compensation Act, there are no pain-and-suffering or punitive damages from the employer (S.C. Code § 42-1-540). A separate claim against a third party who caused the injury can include them."
- **Authority:** proposed `SC 42-1-540`. See also § 42-5-40: an employer that failed to secure compensation "shall be liable … at law in an action instituted by the employee". So the flat statement is not true in every case.
- **Rule:** none.

### W3. The 90-day notice is the outer limit; the statute says "immediately"

- **Surfaces:** body "Two deadlines, not one", KT, FAQ 2, meta description / LegalService `description` (PAGE); what-to-do step 1 and HowTo, the law box, and the sidebar (TEMPLATE).
- **Issue:** § 42-15-20(A) requires notice "immediately … on the occurrence of an accident, or as soon thereafter as practicable". Compensation that accrued before notice is not payable unless the employer knew. The 90 days in (B) is the bar.
  - Every surface is consistent with the signed `SC 42-15-20` claim ("within 90 days"), so this is not an error.
  - But "you have 90 days to notify" (the meta description) invites a worker to wait.
- **Published (body):** "You must give your employer notice of the injury within 90 days (S.C. Code § 42-15-20), and file your claim…"
- **Corrected (body):** "You must give your employer notice of the injury right away, and no later than 90 days after the accident (S.C. Code § 42-15-20), and file your claim…"
- **Published (meta description):** "Hurt on the job in Charleston? You have 90 days to notify your employer and two years to file."
- **Corrected (meta description):** "Hurt on the job in Charleston? Notify your employer right away (no later than 90 days) and file within two years."
- **Optional, TEMPLATE step 1:** keep the step, and change "within 90 days of the injury" to "right away, and no later than 90 days after the accident".
- **Authority:** `SC 42-15-20` (signed). Suggest amending its `claim` to mention "immediately / as soon as practicable" and the repetitive-trauma discovery rule in (C). That is a change to a signed authority, so it needs a re-sign.
- **Rule:** none.

### W4. What-to-do step 1 makes an unsourced empirical claim

- **Surface:** step 1 and HowTo step 1 (TEMPLATE, the SC WC steps in `roden_what_to_do_steps_data()`).
- **Published:** "This is the deadline injured workers miss most often, and missing it can bar your claim entirely."
- **Corrected:** "Missing it can bar your claim entirely."
- **Authority:** `SC 42-15-20` (signed) supports the bar, with its reasonable-excuse exception, which "can" covers. Nothing supports "most often".
- **Rule:** none. This is a statistic class with no registry source.

### W5. The bottom CTA uses negligence framing on a no-fault page

- **Surface:** "Contact Our Charleston Office Today" (TEMPLATE, `templates/template-intersection.php:693`, one msgid for all intersections; ES at `es_ES.po:2954`).
- **Published:** "If you were injured in Charleston and believe another party is at fault, contact us for a free, no-obligation review. Call (843) 790-8999 — no upfront cost."
- **Corrected (WC branch):** "If you were hurt on the job in Charleston, contact us for a free, no-obligation review of your workers’ compensation claim and any third-party claim. Call (843) 790-8999 — no upfront cost."
- **Authority:** proposed `SC 42-1-540` (B1). Fault is not an element of a WC claim.
- **Rule:** none. This is tort leakage. The same msgid pattern exists in `template-subtype.php:264` and `template-practice-area.php:723`.

### W6. "Last reviewed: July 31, 2026" is stamped on content Gillin has not reviewed

- **Surfaces:** the byline under the "What Is…" block ("Reviewed by Graeham C. Gillin, Partner, COO … Last reviewed: July 31, 2026") and the WebPage JSON-LD (`lastReviewed: 2026-07-31`, `reviewedBy`).
- **Source:** PAGE. This is post 3654's pre-rebuild `_roden_last_reviewed`. The rebuild script correctly never sets it, but it also does not clear it. The old stamp therefore now certifies a review of copy that did not exist on 07-31.
- **Action:** do not publish with this stamp. At Gillin's sign-off, set `_roden_last_reviewed` to his review date. If publishing without his word, delete the key first.
- **Related (cosmetic, TEMPLATE):** "Last updated: September 27, 2026" renders from the UTC `post_modified_gmt` (03:14 UTC on 09-27 is 23:14 ET on 09-26).

### W7. Third-party examples do not mention statutory-employer immunity

- **Surfaces:** step 7 and HowTo ("a negligent driver, a contractor on site, or a defective machine's manufacturer") and the pillar "Do I Have a Case" block ("a property owner where you were injured"). Both TEMPLATE.
- **Issue:** under § 42-1-400 an owner whose trade includes the work, and an upstream contractor, can be the worker's *statutory employer*. Such a party is protected by § 42-1-540 and cannot be sued.
  - The § 42-1-540 proviso preserves suits only against *another subcontractor* hired by a common employer.
  - "May recover" hedges step 7. The pillar block states "remain available" flat.
- **Published (pillar):** "Third-party tort claims against non-employer tortfeasors remain available (e.g., a defective machine manufacturer, a negligent driver who hits you at work, a property owner where you were injured) and can be pursued in parallel with the workers’ comp claim."
- **Corrected (pillar, SC branch):** "Third-party tort claims against someone who is not your employer or statutory employer remain available (e.g., a defective machine manufacturer, a negligent driver who hits you at work, or another subcontractor on the job) and can be pursued in parallel with the workers’ comp claim."
- **Authority:** proposed `SC 42-1-540`. § 42-1-400 is not in the pack; add it as pending if the corrected wording is adopted.
- **Rule:** none. Low severity.

---

## Checked and clean (no finding)

- **Filing deadline:** "within two years of the accident" with the Commission (§ 42-15-40), in the body, KT, FAQ 2, law box and sidebar "2 yr". Matches the statute and the signed authority.
  - Step 5 says "2 years from the date of injury". The statute says "after an accident". This is a harmless variance for an accident case.
  - Occupational-disease and repetitive-trauma claims run from diagnosis or knowledge (with a 7-year repose for repetitive trauma). The page links those claim types but states no deadline for them. Consider a clause if the pillar ever does.
- **Form 50** is correct for an employee's claim.
- **"Telling your supervisor is not the same as filing a claim"** and step 5 "Reporting … is not the same as filing" are correct.
- **§ 42-9-60:** "intoxication or wilful intention to injure himself or another" matches the statute (which also says "or kill"). "The party raising that defense has to prove it" matches "the burden of proof shall be upon such person".
  - The heading "two exceptions" is accurate for § 42-9-60.
- **Exclusive remedy:** body, KT, FAQ 3 and the pillar block are correctly conditioned on both parties being under the Act.
- **Choosing doctors (step 2):** "ask your employer or its insurer, in writing, which doctor is authorized to treat you". This is consistent with § 42-15-60(A), under which the employer furnishes the attending physician. It has no Georgia posted panel (#175 holds).
- **Federal pointer:** "Some port and maritime workers are covered by federal law rather than South Carolina workers' compensation." This is acceptable as a pointer. The federal-authority question is an owner decision and is not re-raised.
  - Wording only: coverage can be concurrent (the "twilight zone"). "instead of, or in addition to," would be more precise.
- **Tort-leakage scan:** no § 15-3-530, 3-year SOL, Nelson, 51%/50%, punitive-damages-from-employer claim or "negligence" element anywhere on the page.
  - "Negligent driver / negligent … " appears only for third parties, which is correct.
  - The law box reads "No-fault — benefits do not depend on proving employer negligence" (correct).
  - The "Results at a Glance" stats block has no legal content (grid and "Cases successfully handled" are owner decisions and not re-raised).
- **Citations:** the format is uniformly "S.C. Code § …", which matches `citeFormats.canonical`.
  - Links: § 42-15-20 goes to t42c015, § 42-9-10 to t42c009, § 42-1-540 to t42c001. All are the correct chapters.
  - § 42-15-40 and § 42-9-60 are cited unlinked (fine).
- **Surface agreement:** the FAQPage JSON-LD answers are character-identical to the visible FAQs. The HowTo matches the visible steps.
- **No Georgia law** anywhere, including the pillar blocks (SC branch rendered).
- **Info, not legal:** the "Local Workers' Compensation Lawyers Resources" block lists moped, golf-cart, helmet and Grand Strand crash posts. They are irrelevant to WC; the resource selector is not filtering by practice area.

## Counts by rule

| Rule | Findings |
|---|---|
| (engine) any pack rule | 0 |
| hand: tort leakage (comparative fault) | 1 error (E1) |
| hand: pack authority missing | 1 blocker (B1: 3 authorities) |
| hand: incomplete statement of law | 3 warn (W1, W2, W3) |
| hand: unsourced statistic | 1 warn (W4) |
| hand: tort framing | 1 warn (W5) |
| hand: review attribution | 1 warn (W6) |
| hand: statutory-employer scope | 1 warn (W7) |

By source: PAGE — B1 (in part), W1 (3 surfaces), W2, W3 (4 surfaces), W6. TEMPLATE — E1, W1 (pillar block), W3 (steps/law box/sidebar, optional), W4, W5, W7.

## False positives

None. The engine produced no findings. The proposed `wc-comparative-fault-leak` rule (E1) needs the pillar's correct third-party sentence as a fixture control before it lands.
