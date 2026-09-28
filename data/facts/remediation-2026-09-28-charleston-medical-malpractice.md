# Pre-publish legal sweep: Charleston medical malpractice page (post 3644, DRAFT)

- **Page:** `/medical-malpractice-lawyers/charleston-sc/`. Post 3644, `practice_area`, draft, `_roden_retired` still set. Parent: the medical malpractice pillar (3608). Wave 1, #11.
- **Jurisdiction:** South Carolina only. Reviewer of record: Graeham C. Gillin (SC Bar).
- **What was swept:** the rendered draft (`scratchpad/draft3644.txt`, `scratchpad/preview/draft3644.html`) and all 7 JSON-LD blocks (LegalService, Person, FAQPage, WebPage, HowTo, LocalBusiness/LegalService/LawFirm, BreadcrumbList).
  - **Page surfaces**, from `bin/rebuild-charleston-medical-malpractice.php`: body, excerpt (Article `description`), meta description, key takeaways, 6 FAQs.
  - **Template blocks:** hero, NAP bar, office map and `directions`, law box and sidebar (PR #192 `tort` override), what-to-do steps and HowTo (#192 SC-only text), case types, the Charleston `local_context` essay (`inc/firm-data.php`), the med-mal pillar's negligence and compensation intros (corrected today by `bin/fix-wd-medmal-pillar-intros.php`), the stats block, attorneys, case results, resources, the CTAs.
  - **Linked pages** were read in the sweep's WordPress export (`data/content-cache/wp-export.json`, exported 2026-09-28 19:16 UTC: bodies, excerpts, FAQs, key takeaways).
  - **Statute text** was read today at scstatehouse.gov: `t15c003` (§ 15-3-545), `t15c032` (§§ 15-32-210, -220, -230), `t15c033`, `t15c036` (§ 15-36-100), `t15c078` (§§ 15-78-110, -120), `t15c079` (§§ 15-79-120, -125).
- **Pack:** `law/SC.json` is **SIGNED** (Graeham C. Gillin, 2026-09-26; 34 authorities). **Its `pendingAuthorities` are UNSIGNED:** internal-ai-scripts PR #69 (`law/sc-wrongful-death-medmal-2026-09-28`, `1ecee68`) adds `SC 15-79-125` and `SC 15-36-100` (plus `SC 15-51-10`, `SC 15-51-40`, `SC 15-5-90`), with `verifiedBy` unset.
  - Signed and relied on: `SC 15-3-545`, `SC 15-32-220` (2026: $596,001 / $1,788,002), `SC 15-33-135`, `SC 15-78-110`, `SC 15-78-120`, `Nelson v. Concrete Supply Co.`, `SC 15-3-530` (the essay line; see E1).
  - **Every claim that rests on a PENDING authority** (they cannot go live until Gillin signs #69):

    | # | Surface | Claim |
    |---|---|---|
    | P1 | Key takeaways, sentence 1 | Notice of Intent with an expert's affidavit, and mediation, before suit (§§ 15-79-125, 15-36-100) |
    | P2 | Body, intro + "Expert review from the start." bullet | "South Carolina requires specific steps before a lawsuit…"; "requires a qualified expert's affidavit before suit" (no cite) |
    | P3 | Body, "Steps before a lawsuit" | NOI + affidavit + service; "Filing the notice pauses the filing deadline"; mediation "generally within 90 to 120 days of service"; then suit |
    | P4 | Step 7 + HowTo step 7 | "requires a Notice of Intent … and then mediation before a malpractice suit can be filed (§§ 15-79-125, 15-36-100)" |
    | P5 | Pillar negligence intro (SC branch) | NOI + affidavit; mediation "generally within 90 to 120 days" |
    | P6 | FAQ 1, sentence 2 (+ FAQPage) | "Filing a Notice of Intent to File Suit pauses the deadline (§ 15-79-125)" |
    | P7 | FAQ 2 (+ FAQPage) | the whole pre-suit answer |

    All seven match the primary text read today. § 15-79-125(A) requires contemporaneous filing of the notice and the affidavit, service on all named defendants, and says filing "tolls all applicable statutes of limitations". (C) sets mediation "within ninety days and no later than one hundred twenty days from the service", extendable by 60 days. (E) allows suit after mediation fails. Nothing here needs rewording; it needs the signature.
- **Engine run:**
  - I replayed 47 blocks through `sweep-claims.mjs --fixtures scratchpad/draft3644-fixture.json --states SC,GA` on internal-ai-scripts `1ecee68` (the #69 branch; its signed rules are identical to `main`). The blocks are 30 rendered-text blocks (including the key takeaways, essay and pillar intros), 6 FAQPage answers, 7 HowTo steps, the LegalService and HowTo descriptions, and two positive controls (a § 15-38-15 miscite and a med-mal "no cap" denial).
  - Result: **0 findings**. Both controls fired. Result line: 47/47.
  - A second fixture (`scratchpad/medmal-linked-fixture.json`: 13 sentences, including E1 and 12 linked-page errors, plus a control) returned 0 on all 13. **Every one of them is a false negative** (see "Pack changes").

**Verdict: FAIL as rendered. One template error (E1) blocks publish.**
- **E1** (template): the Charleston office essay tells a med-mal reader "you have 3 years to file under S.C. Code § 15-3-530". The page's own law box, sidebar, body and FAQ say § 15-3-545. That is the wrong statute for the claim, and the page contradicts itself.
- Four warnings are recommended before publish:
  - **W1:** the cap exceptions are incomplete on four surfaces.
  - **W2:** the Tort Claims Act sentence should give the deadline, the $1.2M physician limit and the bar on punitive damages.
  - **W3:** the unhedged law-box and sidebar deadline.
  - **W4:** two step sentences.
- W5 and W6 are low.
- **Four LINKED errors are live today** (L1–L4). Among them is `/blog/medical-malpractice-limits-south-carolina/`, the page this body links to "for more on the limits". It states unindexed $350,000 / $1.05M caps, a 90-day pre-filing notice, post-filing mediation and an invented minors rule, all of which contradict this page. They do not block this publish, but the link sends readers straight to them. Fix L1 in the same batch or unlink it.
- Byline: "Reviewed by Graeham C. Gillin" must not go live until he has reviewed this page *and* signed the #69 pending authorities.
  - `_roden_last_reviewed` is unset (`docs/backups/charleston-medical-malpractice-before-2026-09-28.json`).
  - `bin/publish-charleston-medical-malpractice.php` aborts until `$reviewed` is set.

Source key:
- **PAGE** means `bin/rebuild-charleston-medical-malpractice.php` (post 3644 content and meta).
- **PILLAR** means `bin/fix-wd-medmal-pillar-intros.php` (post 3608 meta; renders on every med-mal intersection).
- **TEMPLATE** means the theme or `inc/firm-data.php`.
- **LINKED** means a separate published page this page links to.

---

## The caller's questions

**(a) § 15-3-545 wording. Is "generally" enough?**
- The main rule is stated correctly. (A) says "within three years from the date of the treatment, omission, or operation … or three years from date of discovery or when it reasonably ought to have been discovered, not to exceed six years from date of occurrence, or as tolled by this section". "Treatment" for "treatment, omission, or operation" and "after the treatment" for "from date of occurrence" are fair plain-English readings.
- The statute has two exceptions, and this page links straight into both of them (surgical error and birth injury):
  - **(B) Foreign objects and negligently placed appliances:** "within two years from date of discovery or when it reasonably ought to have been discovered; provided, that, in no event … less than three years after the placement". **(B) has no six-year cap.** For these claims, "no more than six years after the treatment" is wrong.
  - **(D) Minors:** the period is "not tolled for a period of more than seven years on account of minority, and in any case more than one year after the disability ceases" (tolled indefinitely for parent/insurer fraud or collusion). A minor's claim can therefore outlive the six years.
- **Body, key takeaways and FAQ 1 all say "generally".** That is enough to be true, so those surfaces are not errors.
- **The law box and the sidebar are unhedged:** "3 years from the treatment or from discovery, no more than 6 years after the treatment (S.C. Code § 15-3-545)". Stated flatly, the "no more than 6 years" is false for (B) and (D) claims. See W3.
- The signed `SC 15-3-545` claim covers only the three-year/six-year rule. Stating (B) or (D) on the page needs a pack amendment signed first (Pack item 1). Put it in the same Gillin packet as #69, since publish waits on that signature anyway.

**(b) The 2026 caps sentence against § 15-32-220.**
- **Figures:** $596,001 per provider or institution and $1,788,002 total per claimant. These match the signed pack (RFA memo 2026-02-03, S.C. State Register Vol. 50 No. 2, 2026-02-27). "Adjusted each year" matches (F). "Do not limit economic damages" matches (D)(1).
- **The exceptions are incomplete.** (E) lifts the caps if the defendant "was grossly negligent, wilful, wanton, or reckless, and such conduct was the proximate cause of the claimant's noneconomic damages, **or** if the defendant has engaged in fraud or misrepresentation related to the claim, **or** … altered or destroyed medical records with the purpose of avoiding a claim or liability".
  - "gross negligence or reckless conduct" is not false, but it drops fraud and records destruction. Records destruction matters most to a client who is told to request the records. It also drops the causation link.
  - The signed pack claim already lists all four exceptions, so the fuller sentence is backed now. See W1.
- (D)(2) (the caps do not limit punitive damages) is not stated. That is optional.

**(c) The Tort Claims Act sentence; should § 15-78-120's $1.2M be mentioned?**
- As written, it is true but thin: "with its own deadline and caps".
- **Mention the $1.2M.** § 15-78-120(a)(3)–(4) is the operative limit whenever the harm was caused by "any licensed physician or dentist, employed by a governmental entity and acting within the scope of his profession": $1,200,000 per occurrence, however many agencies are involved.
  - For Charleston this is the usual case, because MUSC is a state institution.
  - If the page ever states a figure, $300,000 / $600,000 alone would be wrong for a government physician's error.
- Also state that punitive damages are not available (§ 15-78-120(b)). The page otherwise describes punitive damages without that limit.
- All of this is in the signed `SC 15-78-110` / `SC 15-78-120` claims, so it can go in now. See W2.
- Carve-out not worth stating: (a)(5) leaves a physician personally exposed for services paid from outside the entity's salary or practice plan.

**(d) Nelson's comparative-fault sentence on a med-mal page.**
- It is appropriate and correct. *Nelson* adopted modified comparative negligence for negligence actions generally, and no statute exempts medical malpractice. It is consistent across the body, FAQ 5, the law box ("less than 51%") and the essay.
- It is low-value on this page. Patient fault in med mal is fact-specific, and whether the conduct that brought the patient to the provider counts is not settled in the pack.
- Keep it as written. Do not add examples: they would be new claims with no authority.
- The 2026 amendment to § 15-38-15 (joint liability, nondefendant allocation) matters more in multi-defendant malpractice cases. It is not on the page, which is fine.

**(e) Template text wrong for med mal.** E1 (essay SOL line), W3 (law box / sidebar), W4 (two step sentences), W5 (resources and essay subject). The case-types grid, the CTA and the case results are covered under "Checks that PASS" and W5.

---

## ERROR (blocks publish)

### E1. The office essay gives the § 15-3-530 deadline on a medical malpractice page

- **Where it renders:** TEMPLATE, `inc/firm-data.php` `offices.charleston.local_context` (line 192) and `local_context_es` (line 200). Rendered by `roden_office_local_context_block()` from `templates/template-intersection.php:474`, heading "Filing a Personal Injury Case in Charleston".
- **Published:** "Under South Carolina law, you have **3 years to file under S.C. Code § 15-3-530**, and you can recover only if you are **less than 51% at fault**."
- **Issue:**
  - § 15-3-545 governs medical malpractice. It has its own accrual (treatment or discovery) and a six-year repose. PR #192 fixed the law box, sidebar and HowTo through the `tort` override, but the essay receives the unresolved `$jurisdiction` (template-intersection.php:44), not `$int_statute`.
  - Its line is hard-coded, so the page cites § 15-3-530 a few inches below a law box citing § 15-3-545. Same class as the workers'-comp leakage (Rule 5: a page contradicting itself across surfaces).
  - The Columbia essay (lines 291 EN and 299 ES) carries the identical line and will do the same on any Columbia med-mal intersection. None is live today.
- **Corrected (preferred, template):**
  1. `templates/template-intersection.php:474`: pass the resolved statute into the essay:
     ```php
     $ctx_jur = $jurisdiction;
     if ( $int_statute ) {
         $ctx_jur['statute_years'] = $int_statute['statute_years'];
         $ctx_jur['statute_cite']  = $int_statute['statute_cite'];
     }
     roden_office_local_context_block( $office, $ctx_jur, $int_is_statutory ? 'wc' : '' );
     ```
     The `{sol_years}` / `{sol_cite}` tokens already exist in `roden_replace_local_tokens()`.
  2. `firm-data.php`, Charleston and Columbia `local_context`:
     - Before: `Under South Carolina law, you have **3 years to file under S.C. Code § 15-3-530**, and you can recover only if you are **less than 51% at fault**.`
     - After: `Under South Carolina law, you generally have **{sol_years} years to file under {sol_cite}**, and you can recover only if you are **less than 51% at fault**.`
  3. `local_context_es` (both offices):
     - Before: `Conforme a la ley de Carolina del Sur, usted tiene **3 años para presentar la demanda conforme a S.C. Code § 15-3-530**, y solo puede recuperar una indemnización si tiene **menos del 51% de culpa**.`
     - After: `Conforme a la ley de Carolina del Sur, por lo general usted tiene **{sol_years} años para presentar la demanda conforme a {sol_cite}**, y solo puede recuperar una indemnización si tiene **menos del 51% de culpa**.`
  - On this page that renders "3 years to file under S.C. Code § 15-3-545". On car, truck and wrongful-death pages it renders § 15-3-530, unchanged.
  - The heredocs are not `__()` msgids, so there is no `.po` impact.
- **Minimal alternative:** skip the essay's last paragraph when `$int_statute` is a tort override (`! empty( $override['tort'] )`). The page already states the deadline four times.
- **Authority:** `SC 15-3-545` (signed). **Rule:** none (false negative; see Pack item 2). **Severity:** error.

---

## WARN (page, pillar and template; recommended before publish)

### W1. The cap exceptions omit fraud and records destruction (4 surfaces)

- **Published:**
  - PAGE body, "Damage caps": "They do not apply in cases of gross negligence or reckless conduct, and they do not limit economic damages such as medical costs and lost wages (S.C. Code § 15-32-220)."
  - PAGE FAQ 3 (+ FAQPage): the same sentence, word for word.
  - PAGE key takeaways: "Noneconomic damages are capped; for 2026 the caps are $596,001 per provider or institution and $1,788,002 in total, except in cases of gross negligence or reckless conduct (S.C. Code § 15-32-220)."
  - PILLAR compensation intro, `{{SC}}` branch: "…$1,788,002 in total per claimant, and they do not apply in cases of gross negligence or reckless conduct (S.C. Code § 15-32-220)."
- **Corrected:**
  - Body and FAQ 3: "They do not apply if the provider was grossly negligent, wilful, wanton or reckless and that conduct caused the harm, engaged in fraud or misrepresentation related to the claim, or altered or destroyed medical records to avoid the claim, and they do not limit economic damages such as medical costs and lost wages (S.C. Code § 15-32-220)."
  - Key takeaways: "Noneconomic damages are capped; for 2026 the caps are $596,001 per provider or institution and $1,788,002 in total per claimant, with exceptions for grossly negligent, wilful, wanton or reckless conduct, fraud, and altered or destroyed records (S.C. Code § 15-32-220)."
  - Pillar: "…$1,788,002 in total per claimant, and they do not apply to grossly negligent, wilful, wanton or reckless conduct that caused the harm, to fraud or misrepresentation related to the claim, or to medical records altered or destroyed to avoid the claim (S.C. Code § 15-32-220)."
    - This goes through `bin/fix-wd-medmal-pillar-intros.php` as a new `old`/`new` pair, exact-match `str_replace`, `update_post_meta( …, wp_slash() )`.
    - Build the strings in a nowdoc: they contain `$`.
- **Authority:** `SC 15-32-220` (signed; its claim lists all four exceptions). **Severity:** warn.

### W2. Tort Claims Act: state the two years, the $1.2M physician limit and no punitive damages

- **Published:**
  - PAGE body, "Deadlines": "If the provider is a government hospital or employee, the South Carolina Tort Claims Act also applies, with its own deadline and caps (S.C. Code §§ 15-78-110, 15-78-120)."
  - PAGE FAQ 4 (+ FAQPage): "The South Carolina Tort Claims Act also applies. It has its own filing deadline, generally two years, and its own caps on recovery (S.C. Code §§ 15-78-110, 15-78-120), so it is important to identify early who employed the provider."
- **Corrected:**
  - Body: "If the provider is a government hospital or employee, the South Carolina Tort Claims Act also applies: suit generally must be filed within two years of when the loss was or should have been discovered (S.C. Code § 15-78-110), recovery is capped at $1,200,000 per occurrence when a government-employed physician or dentist caused the harm and otherwise at $300,000 per person and $600,000 per occurrence, and punitive damages are not available (S.C. Code § 15-78-120)."
  - FAQ 4: "The South Carolina Tort Claims Act also applies. Suit generally must be filed within two years (S.C. Code § 15-78-110). Recovery is capped at $1,200,000 per occurrence when a government-employed physician or dentist caused the harm, and otherwise at $300,000 per person and $600,000 per occurrence, and punitive damages are not available (S.C. Code § 15-78-120). That is why it matters to identify early who employed the provider."
- There is no "notice" wording. Keep it that way (`sctca-mandatory-notice`).
- **Authority:** `SC 15-78-110`, `SC 15-78-120` (both signed). **Severity:** warn (true as written, but it withholds the figure that applies to most Charleston government-hospital claims).

### W3. The law box and sidebar state the six-year limit without "generally"

- **Where it renders:** TEMPLATE `firm-data.php:957`, `statute_overrides['medical-malpractice-lawyers']['SC']['deadline_detail']`. Shown in the law box ("Statute of Limitations") and in the sidebar under "3 yr".
- **Published:** "3 years from the treatment or from discovery, no more than 6 years after the treatment (S.C. Code § 15-3-545)"
- **Corrected:** "Generally 3 years from the treatment or from discovery, and no more than 6 years after the treatment (S.C. Code § 15-3-545)"
  - This is a `__()` msgid. Add the new msgid to `languages/es_ES.po` with the prior Spanish wording plus "Por lo general, …", then recompile `es_ES.mo` locally.
- **After the Pack item 1 amendment is signed** (optional, body "Deadlines", appended): "Different limits apply when a foreign object is left in the body (two years from discovery, and never less than three years from the placement) and when the patient was a minor (S.C. Code § 15-3-545(B), (D))."
- **Authority:** `SC 15-3-545` (signed for the main rule; (B)/(D) pending once added). **Severity:** warn.

### W4. Two step sentences overstate (steps + HowTo)

- **Where it renders:** TEMPLATE `inc/template-tags.php:1793` and `:1801` (med-mal SC steps, #192). These also render in HowTo schema.
- **Published (step 4):** "It is a common and entirely lawful offer."
  - "Entirely lawful" is a legal conclusion with no authority, and it is not universally true: waivers for federal-program patients can raise beneficiary-inducement issues.
  - **Corrected:** "It is a common offer."
- **Published (step 6):** "…and only a qualified expert in the same field can answer it."
  - § 15-36-100(A) qualifies experts by board certification *or* practice or teaching in "the area of practice or specialty", and (A)(3) admits other specialized knowledge. "Same field" is narrower than the statute.
  - **Corrected:** "…and usually only a qualified medical expert can answer it."
- Both are msgid changes. Update `es_ES.po` and recompile `.mo`.
- **Authority:** `SC 15-36-100` (pending) for step 6. **Severity:** low.

### W5. Resources and essay subject are not about medical malpractice

- The fallback "South Carolina Medical Malpractice Lawyers Resources" renders moped, golf cart, helmet and liquor-liability guides. That is `roden_related_resources()` with no med-mal resource tagged for `cat_slug`.
  - Fix: tag the three med-mal posts linked from the body as resources, or suppress the fallback on med mal.
- The essay's middle paragraph is about crash corridors and trauma transport ("Serious-injury patients from peninsula crashes…"). It is accurate (verified on the car and truck pages) but off-subject here.
  - Optional: add a `local_context_medmal` variant and route to it the way `wc` is routed.
- **Not law.** **Severity:** low.

### W6. Stale `_roden_sol_sc` meta on 3644 (and the med-mal subtypes)

- **Published (post meta, not rendered on this template):** `_roden_sol_sc` = "3 years (S.C. Code § 15-3-530)" on 3644. The export also shows `solSc` = § 15-3-530 on the eight med-mal subtypes (4192–4199) and on 4101 (medical malpractice death).
- **Issue:**
  - `roden_filing_deadlines_sidebar()` prints the meta verbatim wherever it runs (resources today).
  - `content/meta.json` records the wrong SOL for these posts, which is exactly the drift the record exists to catch.
- **Corrected:** `_roden_sol_sc` = "3 years (S.C. Code § 15-3-545)" on 3644 and the eight subtypes. Do this through `update_post_meta( …, wp_slash() )`, then regenerate `content/meta.json`.
- **Authority:** `SC 15-3-545`. **Severity:** low (latent).

---

## LINKED (do not block this publish)

All the sentences below were replayed through the engine and returned nothing (`scratchpad/medmal-linked-fixture.json`, 14/14 with a control that fired). They are false negatives, not clean.

### L1. `/blog/medical-malpractice-limits-south-carolina/` (post 4562): wrong on caps, notice, mediation, repose and minors (live, error class)

- **Linked from:** the body, "For more on the limits, see medical malpractice damage caps and deadlines in South Carolina". Author meta Gillin, `lastReviewed` empty.
- **Caps (key takeaways, FAQ 1, FAQ 6, body table, "Non-Economic Damages (Capped at $350,000 per defendant / $1.05M total)", "Who can be sued"):** "$350,000 per defendant and $1.05 million total".
  - These are the unindexed 2005 base figures. For 2026 they are $596,001 / $1,788,002.
  - The table also cites (A) for the institution cap (it is (B)) and (B) for the total (it is (C)).
  - **Corrected (FAQ 1 sentence 2):** "Yes. South Carolina caps non-economic damages at a base of $350,000 per provider or institution and $1,050,000 in total per claimant, adjusted each year for inflation: for 2026, $596,001 and $1,788,002 (S.C. Code § 15-32-220)."
  - Apply the same figures to the table ((A) single provider, (B) single institution, (C) total), the key takeaways, the "Capped at" heading and the per-defendant sentences.
- **Notice:** FAQ 3 / body / key takeaways say "you must serve a Notice of Intent to File Suit on each defendant at least 90 days before filing your complaint. This notice must include a medical records authorization…". Also "The statute of limitations is tolled during the 90-day period".
  - There is no 90-day waiting period and no records-authorization requirement.
  - § 15-79-125(A) requires the notice to be *filed* with an expert affidavit and served, and it tolls the limitations period. (C) requires mediation within 90 to 120 days of service.
  - **Corrected (FAQ 3):** "Under S.C. Code § 15-79-125, before filing a malpractice lawsuit you must file a Notice of Intent to File Suit together with a qualified expert's affidavit, and serve it on each defendant. Filing the notice tolls the statute of limitations. The parties must then mediate, generally within 90 to 120 days of service, before the lawsuit can be filed."
- **Mediation:** FAQ 4 / body say "After the lawsuit is filed, the case must go through a mediation process…". This is backwards: the § 15-79-125 mediation is *pre-suit*.
  - **Corrected:** "South Carolina requires mediation before a medical malpractice lawsuit is filed (S.C. Code § 15-79-125(C)); if it fails, the lawsuit can be filed."
- **Repose cite:** FAQ 5 / body / table say "six-year statute of repose (S.C. Code § 15-3-545(B))". The repose is in (A). (B) is the foreign-object rule, which has *no* six-year limit, so "no claim can be brought more than six years … regardless" is wrong for foreign objects.
  - **Corrected (FAQ 5, sentence 1):** "South Carolina's six-year statute of repose (S.C. Code § 15-3-545(A)) generally bars a malpractice lawsuit filed more than six years after the negligent act, even if the injury was discovered later; claims for foreign objects left in the body and claims of minors follow different rules."
- **Minors:** the table says "Minors under 6 years old — Extended to their 8th birthday — S.C. Code § 15-3-545(C)". Invented: (C) is the 1977 effective-date clause.
  - **Corrected row:** "Minors — Tolled during minority, but by no more than seven years, and no more than one year after the minor turns 18 — S.C. Code § 15-3-545(D)." (Needs Pack item 1 signed; until then delete the row.)
- **Other claims:**
  - "the South Carolina Supreme Court upheld these caps in *Platt v. CSX Transportation*" — I could not find this case. No SC Supreme Court decision by that name upholding § 15-32-220 is known to me. Treat it as fabricated until Gillin supplies a cite. **Delete the sentence.**
  - "South Carolina Medical Malpractice Act (S.C. Code § 15-79-10 et seq.)" — Chapter 79 begins at § 15-79-110. Corrected: "(S.C. Code §§ 15-79-110 to -130 and 15-32-200 to -240)".
  - "apply to all medical malpractice cases filed" — the caps apply to causes of action arising after July 1, 2005. Low.
  - "Nursing homes and assisted living facilities" — assisted living is expressly excluded from "nursing home" (§ 15-32-210(10)). Low.
  - "The three-year statute of limitations runs from the date of death (S.C. Code § 15-3-545(A))" — accrual for med-mal wrongful death is not in the pack. Send it to Gillin and delete until confirmed.
- **Severity:** **error on a live page**, and the body of the page being published links to it. Fix path: `bin/` patcher, exact `str_replace` + `wp_slash()`, FAQs via `bin/apply-faq-remediation.php`. Then regenerate `content/meta.json` and run `bin/check-unslashed-post-writes.php`.

### L2. `/blog/charleston-medical-malpractice-hospital-claim-south-carolina/` (4349): 90-day notice, minors, expert standard

- **Linked from:** the body ("filing a medical malpractice claim against a Charleston hospital").
- **Published:**
  - FAQ 2: "as part of the mandatory 90-day Notice of Intent".
  - FAQ 3: "you must serve a 90-day pre-suit notice before filing, so the effective deadline is earlier".
  - FAQ 6: "at least 90 days before filing the complaint".
  - Body: "at least 90 days before filing the complaint (S.C. Code § 15-79-125)".
  - Filing-deadlines list: "you must begin the process at least 90 days before the three-year deadline".
  - Table: "90-day Notice of Intent with expert affidavit".
  - Same correction as L1. The notice *tolls* the deadline; it does not shorten it.
- **Published (Filing Deadlines list):** "Minors — in South Carolina, minors generally have until their eighth birthday for birth injury claims, subject to certain conditions".
  - This is false; see L1. **Corrected:** "Minors — in South Carolina, the deadline is extended while the patient is a minor, but by no more than seven years and no more than one year after the patient turns 18 (S.C. Code § 15-3-545(D))." (Needs Pack item 1; until then delete.)
- **Published (FAQ 2 / body expert list):** "must have practiced within the past five years"; "must specialize or have specialized in the same field".
  - § 15-36-100(A)(2)(b) requires active practice or teaching in the specialty "for at least three of the last five years immediately preceding the opinion", *or* board certification ((A)(2)(a)), *or* (A)(3) specialized knowledge.
  - **Corrected (FAQ 2 sentence 2):** "The expert must be licensed and either board certified in the relevant specialty or have practiced or taught in it for at least three of the last five years (S.C. Code § 15-36-100)."
- **Key takeaways:** "Damages caps may apply in SC." Understated: they do apply. Low. Corrected: "South Carolina caps noneconomic damages ($596,001 per provider and $1,788,002 total for 2026, S.C. Code § 15-32-220)."
- Georgia rows and sentences on this post are outside this sweep. Send them to the Georgia reviewer.
- **Severity:** error (live).

### L3. `/blog/emergency-room-errors-charleston-misdiagnosis-malpractice/` (4363): 90-day notice, minors "under six", expert window, and no § 15-32-230

- **Linked from:** the body ("emergency room errors in Charleston").
- **Published:** "at least ninety days before filing the lawsuit"; FAQ 2 "as part of the 90-day pre-suit notice"; FAQ 3 "The 90-day pre-suit notice means you must start earlier"; "the pre-suit notice requirement adds at least ninety days to the timeline". Same correction as L1.
- **Published:** "The only exceptions are for cases involving foreign objects left in the body and for claims involving minors under the age of six."
  - "Under the age of six" is invented.
  - **Corrected:** "Different rules apply to foreign objects left in the body and to claims of minors (S.C. Code § 15-3-545(B), (D))."
- **Published:** "must have practiced or taught in the same or a similar medical specialty as the defendant within the three years preceding the alleged act of malpractice".
  - **Corrected:** as L2 ("three of the last five years immediately preceding the opinion").
- **Omission (the most important one for this post):** § 15-32-230. For care "rendered in a genuine emergency situation involving an immediate threat of death or serious bodily injury … in an emergency department or in an obstetrical or surgical suite, no physician may be held liable unless it is proven that the physician was grossly negligent". It applies only while the patient is not medically stable and before discharge from the ED.
  - An ER post that tells readers a missed stroke is "actionable malpractice" without this is misleading.
  - Add after the "Hospital Liability" section: "South Carolina also raises the bar for some emergency care: when a patient who is not medically stable faces an immediate threat of death or serious bodily injury, an emergency-department physician is liable only if grossly negligent (S.C. Code § 15-32-230). The rule does not cover care after the patient is stabilized or discharged, and it does not protect the hospital itself."
    - The last clause needs Gillin's confirmation. The section speaks only of "physician".
  - Needs pending authority `SC 15-32-230` (Pack item 1).
- **Severity:** error (live).

### L4. `/medical-malpractice-lawyers/birth-injury/` (4195): the SC minors rule is wrong (FAQ + body)

- **Published (FAQ 1 + FAQPage, and body):** "South Carolina allows claims to be filed within the standard limitations period after the child reaches the age of majority."
  - § 15-3-545(D) caps minority tolling at seven years and at one year after majority. A child injured at birth does *not* get three years from age 18.
  - **Corrected:** "In South Carolina, the deadline is extended while the child is a minor, but by no more than seven years and no more than one year after the child turns 18 (S.C. Code § 15-3-545(D))."
  - Needs Pack item 1 signed. Until then: "South Carolina extends the deadline for minors only for a limited time, so early investigation is essential."
- It is linked from the body, the case-types grid and the sidebar.
- **Severity:** error (live, and in FAQ schema).

### L5. `/medical-malpractice-lawyers/emergency-room-negligence/` (4197): the "emergency standard" omits § 15-32-230

- **Published (FAQ 1 + FAQPage):** "ER physicians are held to the standard of a reasonably competent emergency physician under similar circumstances. While courts consider the emergency context, this does not excuse clear negligence…"
  - In South Carolina this is wrong for genuine emergencies, where § 15-32-230 requires gross negligence.
  - **Corrected (append):** "In South Carolina, when an unstable patient faces an immediate threat of death or serious bodily injury, an emergency physician is liable only if grossly negligent (S.C. Code § 15-32-230)."
- The body section "The 'Emergency' Standard of Care" needs the same sentence. Its closing line is Georgia-only, so send it to the Georgia reviewer.
- **Authority:** `SC 15-32-230` (to be added as pending). **Severity:** warn.

### L6. `/medical-malpractice-lawyers/informed-consent-failure/` (4199): the SC disclosure standard (Gillin question)

- **Published:** "South Carolina courts evaluate whether the doctor provided sufficient information for a reasonable patient to make an informed decision"; FAQ 3: "Courts typically apply a 'reasonable patient' standard".
  - My understanding is that South Carolina measures disclosure by the professional (reasonable-physician) standard (*Hook v. Rothstein*, 281 S.C. 541, 316 S.E.2d 690 (Ct. App. 1984)). There is no pack authority.
  - Also "Under S.C. Code § 15-79-125, informed consent claims are subject to…": § 15-79-125 covers "medical malpractice" generally and does not mention informed consent. Low.
- **Action:** send to Gillin. If he confirms, the corrected body sentence is "South Carolina courts generally measure the disclosure a doctor owed by what a reasonable physician in the same field would have disclosed." Add `Hook v. Rothstein` as pending.
- **Severity:** warn.

### L7. Other linked pages

- **Surgical, medication, misdiagnosis, anesthesia and hospital-acquired infection subtypes (4192–4198):** the SC sentences ("3 years from the date of injury or discovery (§ 15-3-545)"; "Notice of Intent and expert opinion under § 15-79-125") are hedged or incomplete but not false.
  - The surgical page correctly flags "Exceptions may apply for retained foreign objects".
  - Their `solSc` meta says § 15-3-530 (W6).
  - Their Georgia sentences, and the subtype rules box's Georgia med-mal deadline line, are outside this sweep. Send them to the Georgia reviewer.
- **`/wrongful-death-lawyers/medical-malpractice-death/` (4101):** the SC section is correct (§ 15-51-10 et seq.; the personal representative files; the § 15-79-125 notice applies). There is no SC deadline stated.
- **Pillar 3608 FAQs:** SC rules correct ("Exceptions exist for foreign objects … and for minors"; caps as base + indexed; punitive $739,245).
  - "Without this affidavit, the court will dismiss the case" overstates § 15-36-100(C) (the short-deadline and common-knowledge exceptions). Low.
- **`/practice-areas/nursing-home-abuse-lawyers/` (3619) FAQ:** "In South Carolina, you have 3 years (S.C. Code § 15-3-530)". Whether § 15-3-545 governs med-mal claims against nursing homes is still open on Gillin's list.
  - § 15-3-545(A) defines providers by reference to Article 5, Chapter 79, Title 38, which was **repealed effective 2020-01-01** (read today at t38c079). No change until he rules.

---

## Checks that PASS

| Check | Result |
|---|---|
| South Carolina only | There is **no Georgia law** on the page or in its 7 JSON-LD blocks. The pillar intros render their `{{SC}}` branch. "Georgia & South Carolina" appears only in the firm CTA and the stats, which is accepted boilerplate. |
| SOL (§ 15-3-545) | Body, key takeaways, FAQ 1, negligence intro, law box and sidebar all agree: three years from treatment or discovery, six years outer. See E1 for the essay and W3 for the unhedged box. |
| Pre-suit (§§ 15-79-125, 15-36-100) | It matches the primary text on every surface (P1–P7). There is **no "90 days before filing"** wording. Pending signature. |
| Caps figures | $596,001 / $1,788,002 "for 2026", "adjusted each year", "per claimant", economic damages not limited. This is identical on the body, FAQ 3, key takeaways and pillar intro, and matches the signed pack. |
| Punitive | Only "clear and convincing evidence (§ 15-33-135)". No cap figure is stated, so no stale $500,000. |
| SCTCA | Correct cites (§§ 15-78-110, -120). There is **no notice wording** and no § 15-78-80 miscite. See W2 for completeness. |
| Comparative fault | *Nelson*, in full in the law box. § 15-38-15 appears nowhere. "50% or less" and "less than 51%" are equivalent. |
| Venue | "Most Charleston County medical malpractice cases are filed in the Court of Common Pleas at the Charleston County Judicial Center, 100 Broad Street" is hedged, and the address was verified on the car page. |
| FAQ vs FAQPage JSON-LD | All 6 answers match the rendered text character for character. |
| Steps vs HowTo | All 7 steps match. The SC-only text from #192 has no Georgia leakage and no tort-SOL leakage. |
| Excerpt / meta description / LegalService and HowTo descriptions | Marketing only, with no legal claim. |
| Directions / NAP | 127 King St "between Broad and Queen" (the #188 fix) is present. |
| Case-types grid, bottom CTA, case results, attorneys | Accepted or owner-deferred and not re-raised: the unfiltered results grid, "believe another party is at fault" (true of med mal) and the attorney grid. |
| Statistics | No numeric medical statistic on the page. The firm stats block is accepted boilerplate. |
| JSON-LD validity | 7/7 blocks parse. |

## Counts by rule

| Rule | Findings | Severity |
|---|---:|---|
| (engine) all SC + GA rules, 47 blocks + 2 controls | 0 | — |
| Hand: wrong SOL statute for the practice area (essay § 15-3-530 on med mal) | 1 (EN + ES, 2 offices' source) | **error** |
| Hand: cap exceptions incomplete (§ 15-32-220(E)) | 1 (4 surfaces) | warn |
| Hand: SCTCA figures and punitive bar omitted | 1 (2 surfaces) | warn |
| Hand: repose stated without hedge (law box / sidebar) | 1 | warn |
| Hand: step text overstates (lawful; expert field) | 1 (2 steps + HowTo) | low |
| Hand: off-subject resources and essay | 1 | low |
| Hand: stale `_roden_sol_sc` meta | 1 (10 posts) | low |
| Hand, LINKED: unindexed caps / 90-day notice / post-suit mediation / (B) repose / invented minors rule / unverifiable case | 1 post (4562), ~14 surfaces | **error (live)** |
| Hand, LINKED: 90-day notice / eighth birthday / expert window | 1 post (4349) | **error (live)** |
| Hand, LINKED: 90-day notice / "under six" / expert window / no § 15-32-230 | 1 post (4363) | **error (live)** |
| Hand, LINKED: SC minors rule wrong | 1 page (4195), FAQ + body | **error (live)** |
| Hand, LINKED: ER standard without § 15-32-230 | 1 page (4197) | warn |
| Hand, LINKED: SC informed-consent standard | 1 page (4199) | warn (Gillin) |
| **Total** | **13** (1 page error, 3 page warnings, 3 low, 4 linked errors, 2 linked warnings) | |

Source split:
- **PAGE:** W1 (3 surfaces), W2, W6.
- **PILLAR:** W1 (1 surface).
- **TEMPLATE:** E1, W3, W4, W5.
- **LINKED:** L1–L7.

## False positives

None. The engine raised nothing. Everything above is a **false negative**, confirmed 13/13 by `scratchpad/medmal-linked-fixture.json`. Fixes go to an `internal-ai-scripts` PR, never to a content edit alone.

## Pack changes (proposed; not made)

Fixtures come first, in `law/fixtures/`. Re-run both fixture sets to 100% before merging.

1. **Pending authorities (`verifiedBy: null`) to add to #69, for the same Gillin packet:**
   - **Amend `SC 15-3-545`** (as a pending amendment; the signed claim stays until he signs):
     - (B) foreign object / appliance: two years from discovery, never less than three years after placement, no six-year limit.
     - (D) minors: tolling no more than seven years and no more than one year after majority.
     - Quantities: "2 years", "seven years", "one year".
     - Evidence: scstatehouse.gov/code/t15c003.php, read 2026-09-28.
   - **`SC 15-32-230`:** genuine-emergency ED/OB/surgical-suite care; a physician is liable only for gross negligence; applies only while the patient is unstable and before discharge from the unit. Evidence: t15c032.php, read 2026-09-28.
   - **`Hook v. Rothstein`**, 281 S.C. 541, 316 S.E.2d 690 (Ct. App. 1984): informed-consent disclosure standard. Only if Gillin confirms (L6).
2. **New rule `sc-medmal-sol-cited-to-15-3-530` (error, SC).**
   - **Positive:** E1 in a block whose page context is medical malpractice.
   - **Controls:** the car-page essay; "unlike the § 15-3-530 deadline for other injuries, malpractice runs under § 15-3-545".
   - Needs page-level context (the essay sentence does not say "malpractice"). Either extend `forbiddenContexts` on `SC 15-3-530` to the page's practice area, or match within the block with `malpractice` and `contextUnless` for § 15-3-545. Fixture first.
3. **New rule `sc-medmal-cap-unindexed` (error, SC)**, the twin of `sc-punitive-floor-unindexed`.
   - **Positives:** L1's "$350,000 per defendant and $1.05 million total".
   - **Controls:** 4349's and 3608's "a base of $350,000 … adjusted annually for inflation", and this page's 2026 figures.
   - **Pattern:** `\$350,000[^.]{0,80}(?:\$1\.05\s*million|\$1,050,000)` with `unless` `base|adjust|index|inflation|596,001`.
4. **New rule `sc-medmal-noi-90-days-before-filing` (error, SC).**
   - **Positives:** L1, L2 and L3 ("at least 90 days before filing", "90-day Notice of Intent", "90-day pre-suit notice").
   - **Controls:** this page's "mediate, generally within 90 to 120 days of service".
   - **Pattern:** `(?:90|ninety)[- ]days?\s+before\s+filing|(?:90|ninety)-day\s+(?:pre-suit\s+)?notice`.
5. **New rule `sc-medmal-minor-birthday` (error, SC).**
   - **Positives:** "until their eighth birthday", "Extended to their 8th birthday", "minors under the age of six", and 4195's "standard limitations period after the child reaches the age of majority".
   - **Control:** the corrected (D) sentence.
   - Backed by the Pack item 1 amendment. Georgia pages need a `{{GA}}` / O.C.G.A. `contextUnless`.
6. **New rule `sc-medmal-repose-cited-to-545b` (warn):** `six-year[^.]{0,60}15-3-545\(B\)`.

After any pack change: `node scripts/facts/vendor.mjs rodenlaw --write` if the client vendors the pack, then `--check`.

## Before publish

1. **Required:** E1 (template essay line and the intersection pass-through; Charleston and Columbia, EN and ES).
2. **Recommended with it:**
   - W1 (page ×3 + pillar intro via `bin/fix-wd-medmal-pillar-intros.php`).
   - W2 (body + FAQ 4).
   - W3 (msgid + `es_ES.po`/`.mo`).
   - W4.
   - Re-run `bin/rebuild-charleston-medical-malpractice.php` against the draft, re-render, and replay `scratchpad/draft3644-fixture.json` (47 entries). Bump `style.css` only if CSS or JS changed. It did not.
3. **Recommended in the same batch:** fix L1 (the "more on the limits" post) or remove that link until it is fixed. Also fix L4 (birth-injury SC minors) using the interim wording.
   - Use a `bin/` patcher with exact `str_replace` and `wp_slash()`, and `bin/apply-faq-remediation.php` for the FAQs.
   - Then regenerate `content/meta.json` and run `bin/check-unslashed-post-writes.php`.
4. **Gillin** signs the #69 pending authorities (§§ 15-79-125, 15-36-100; plus Pack item 1 if you want W3's exception sentence and the L1/L2/L4 minors wording), then reviews this page. Only then set `$reviewed` in `bin/publish-charleston-medical-malpractice.php`.
5. **Separately:** L2, L3, L5 go to a Charleston med-mal linked-posts batch. L6 and the nursing-home SOL go to Gillin's packet. The Georgia sentences on 4349, 4363 and the subtypes go to the Georgia reviewer. W5 and W6 are template and data cleanups.
