# Pre-publish legal sweep: Charleston wrongful death page (post 3649, DRAFT)

- **Page:** `/wrongful-death-lawyers/charleston-sc/`. Post 3649, `practice_area`, draft, `_roden_retired` still set. Parent: the wrongful death pillar (3609). Wave 1, #10.
- **Jurisdiction:** South Carolina only. Reviewer of record: Graeham C. Gillin (SC Bar).
- **What was swept:** the rendered draft (`scratchpad/draft3649.txt`, `scratchpad/preview/draft3649.html`) and all 7 JSON-LD blocks (LegalService, Person, FAQPage, WebPage, HowTo, LocalBusiness/LegalService/LawFirm, BreadcrumbList).
  - **Page surfaces**, from `bin/rebuild-charleston-wrongful-death.php`: body, excerpt (Article `description`), meta description, key takeaways, 6 FAQs.
  - **Template blocks:**
    - hero, NAP bar, office map and `directions`
    - law box (`firm-data.php` `jurisdiction.SC`), steps and HowTo (PR #192)
    - case-types grid, the Charleston `local_context` essay
    - the wrongful death pillar's negligence and compensation intros (`bin/fix-wd-medmal-pillar-intros.php`, SC branch)
    - statewide uplink, stats, attorneys, case results, resources, both CTAs, sidebar
  - **Linked pages** were read in `data/content-cache/wp-export.json` (exported 2026-09-28 19:16 UTC: bodies, excerpts, FAQs, key takeaways).
- **Pack:** `law/SC.json` is **SIGNED**: Graeham C. Gillin, 2026-09-26, 34 authorities.
  - internal-ai-scripts PR #69 (`law/sc-wrongful-death-medmal-2026-09-28`, `1ecee68`) adds 5 `pendingAuthorities`: `SC 15-51-10`, `SC 15-51-40`, `SC 15-5-90`, `SC 15-79-125`, `SC 15-36-100`. They were read against scstatehouse.gov today and are **UNSIGNED** (`verifiedBy: null`). They are advisory: they cannot back a new claim until Gillin signs.
- **Primary text read today (scstatehouse.gov):**
  - `t15c003` (§§ 15-3-530, -535, -545)
  - `t15c051` (§§ 15-51-10 to -60)
  - `t15c032` (§§ 15-32-210, -220, -510 to -540)
  - `t42c001` (§§ 42-1-400, -410, -540)
- **Engine run:** I replayed 54 blocks through `sweep-claims.mjs --fixtures scratchpad/draft3649-fixture.json --states SC,GA` on the PR #69 branch (`1ecee68`).
  - The blocks: 41 rendered-text blocks, 6 FAQPage answers, the HowTo description and 7 steps, the LegalService description, and a positive control.
  - Result: **0 findings**. The control (a § 15-38-15 miscite) fired. Result line: 54/54.
  - `scratchpad/chswd-linked-fixture.json` (8 sentences from this page and the linked pages, plus the control) also returned 0. Every one of them is a **false negative** (see "Pack changes").
  - `scratchpad/chswd-corrected-fixture.json` (every corrected sentence below, plus the control) returned 0, 10/10.

**Verdict: FAIL. One page error (E1) blocks publish.**
- **E1:** FAQ 4 (`_roden_faqs[3]`) and its FAQPage answer, "Is there a cap on wrongful death damages?", open with "Not in an ordinary case."
  - They omit the punitive-damages cap (§ 15-32-530), which reaches the punitive damages this same page says are available.
  - They also omit the charitable-organization cap (§ 33-56-180), which reaches nonprofit hospitals and nursing homes. Those are the defendants in the medical and nursing-home deaths this page links to.
  - Both are signed authorities.
- **W1 should be fixed in the same pass.** The comparative-fault rule is stated to "you" in the law box and in the essay's closing line. On a wrongful death page the test is the fault of the person who died, not the family's.
- Everything else is hedged correctly and matches the primary text. On the three-year deadline, see answer (a).
- **Byline:** "Reviewed by Graeham C. Gillin" must not go live until he has reviewed this page **and** signed the PR #69 pending authorities.
  - `_roden_last_reviewed` is correctly unset (checked in `docs/backups/charleston-wrongful-death-before-2026-09-28.json`).
  - There is no `_roden_translation_es` on 3649, so there is no Spanish twin to hold.

FAQ numbers are 1-based as rendered: FAQ 4 is `_roden_faqs[3]`. Step numbers are likewise 1-based (step 7 is "Speak with an attorney").

Source key:
- **PAGE** means `bin/rebuild-charleston-wrongful-death.php` (post 3649 content and meta).
- **PILLAR** means wrongful death pillar 3609 meta, SC branch (`bin/fix-wd-medmal-pillar-intros.php`).
- **TEMPLATE** means the theme or `inc/firm-data.php`.
- **LINKED** means a separate published page. It does not block this publish.

---

## Answers to the four questions

### (a) "generally must be filed within three years (S.C. Code § 15-3-530)" with no start date

**It is accurate and adequately hedged. It can be made more precise, but only after the pack is amended and signed.**

- **The start date is statutory.** § 15-3-530(6) reads: "an action under Sections 15-51-10 to 15-51-60 for death by wrongful act, **the period to begin to run upon the death** of the person on account of whose death the action is brought".
  - So "three years from the date of death" is the text of the statute. It is not an accrual inference. The statewide page and the settlement-value resource already say "from the date of death".
- **But the signed `SC 15-3-530` claim does not cover it.** It reads "Three years from the date of injury to file a personal injury lawsuit".
  - The wrongful death deadline, and above all its start date, therefore rests on subsection (6), which the pack does not carry.
  - Until Gillin signs an amendment, "generally within three years" with no start date is the right wording. Leave it.
- **What to ask Gillin (add to the PR #69 sign-off packet):**
  1. **Amend `SC 15-3-530`** to add (6): "A wrongful death action must be commenced within three years, the period beginning to run on the death." Evidence: t15c003.php, read 2026-09-28.
     - Once he signs, the page may say "within three years of the death (S.C. Code § 15-3-530(6))" in the key takeaways, body, FAQ 2, step 7 and HowTo, the law box and the sidebar.
  2. **Medical-malpractice deaths.**
     - Does § 15-3-545(A) govern a wrongful death claim arising from treatment? It covers "any action … to recover damages for injury to the person arising out of any medical … treatment": three years from treatment or discovery, **not to exceed six years from the occurrence**.
     - Or does § 15-3-530(6) (three years from death) govern? And can the six-year repose bar a death claim before three years from the death have run?
     - The page's Deadlines paragraph currently applies § 15-3-530 to every death, including a malpractice death. The med-mal template and pillar (PR #192, 2026-09-28) put malpractice on § 15-3-545. See W2.
  3. **The survival action's clock.** The survival claim is the decedent's own claim. It runs under § 15-3-530(5) from the injury, or from discovery under § 15-3-535, not from the death.
     - If the person lived for some time after the injury, the survival claim can expire before the wrongful death claim does.
     - Is there any extension on the death of the claimant? I found none in chapter 3.
     - The page's step 7 hedges this ("separate claims may belong to the estate and to the family"), which is sufficient for now.
  4. **SCTCA.** For a death, is "the date the loss was or should have been discovered" (§ 15-78-110) the date of death?
  5. **Other outer limits.** Should the page mention the eight-year repose for improvements to real property (§ 15-3-640), which expressly reaches "personal injury, including a personal injury resulting in death"? My recommendation is no: it is out of scope for this page.

### (b) Law box "Comparative Fault … recover if less than 51% at fault" on a wrongful death page

**The rule belongs on the page. The framing does not.**
- The wrongful death action exists only where the act "would, if death had not ensued, have entitled the party injured to maintain an action and recover damages" (§ 15-51-10, **pending**). The claim is derivative, so the decedent's comparative fault reduces the recovery and bars it above 50%.
  - The site's own settlement-value resource says exactly this: "if the deceased was partly at fault, the recovery is reduced … and barred if the deceased was 51% or more at fault".
- The law box ("recover if less than 51% at fault") and the essay ("you can recover only if **you** are less than 51% at fault") tell the family that the test is their own fault. That is W1.
- Ask Gillin to confirm that the decedent's fault is the measure, and whether a beneficiary's own fault (for example, a parent-driver) affects that beneficiary's share. The page should say nothing about the latter.

### (c) "No cap in an ordinary case" FAQ

This is **E1**. The compensatory half is true: there is no general cap on compensatory damages in a private-defendant wrongful death case. As a standalone FAQPage answer, though, it understates the caps on two points:
- **The punitive damages cap.** § 15-32-530(A) caps punitive damages in any civil action at the greater of three times compensatory damages or $739,245 for 2026. It is higher or lifted under (B) and (C). § 15-32-540 carves out only the SCTCA and the Solicitation of Charitable Funds Act, so the cap reaches § 15-51-40 exemplary damages.
- **The charitable-organization cap.** § 33-56-180 limits claims against a 501(c)(3) to the § 15-78-120 amounts. In Charleston this is not academic: nonprofit hospitals and nursing homes are defendants in the medical and nursing-home deaths the page links to. (MUSC, a state entity, falls under the SCTCA cap the answer already states.)

### (d) Template text wrong for wrongful death

- **Law box and essay comparative fault:** W1.
- **Bottom CTA** "If you were injured in Charleston and believe another party is at fault": wrong addressee (W5).
- **Resources:** four generic SC resources (moped, golf cart, helmet, liquor liability). They are not wrong, only unrelated (W6). The helmet and moped resources state the under-21 rule correctly.
- **Case-types grid:** titles only, nothing wrong in the grid itself. All six targets are two-state sub-type pages with live errors (L2–L6).
- **Case results** (truck, product liability, premises): owner-deferred, not re-raised.
- **Essay facts:** 100 Broad St, MUSC Level I at 171 Ashley Ave, the Crosstown and the Ravenel Bridge. Confirmed in the Charleston car and truck sweeps; unchanged.
- **Directions:** "between Broad and Queen" (fixed 2026-09-26).
- **Steps and HowTo (PR #192):** clean. They are SC-only, § 15-51-20 order, "generally three years", and identical to the HowTo schema.

---

## ERROR (page; blocks publish)

### E1. FAQ 4 denies a cap that applies to the punitive damages the page offers, and omits the charity cap

- **Where it renders:** PAGE `_roden_faqs[3]`, the rendered FAQ and the **FAQPage JSON-LD** (identical text).
- **Published:** "Not in an ordinary case. Claims against a government entity are capped at $300,000 per person and $600,000 per occurrence (S.C. Code § 15-78-120), and noneconomic damages in a death caused by medical malpractice are capped (S.C. Code § 15-32-220)."
- **Corrected:** "There is no cap on the family's compensatory damages in an ordinary case, but there are important exceptions. Claims against a government entity are capped at $300,000 per person and $600,000 per occurrence (S.C. Code § 15-78-120), and claims against a charitable organization, which can include a nonprofit hospital or nursing home, are limited to the same amounts (S.C. Code § 33-56-180). Noneconomic damages in a death caused by medical malpractice are generally capped (S.C. Code § 15-32-220). Punitive damages are generally capped at the greater of three times the compensatory damages or $739,245 in 2026, a figure adjusted each year (S.C. Code § 15-32-530)."
- **Authority:** `SC 15-78-120`, `SC 33-56-180`, `SC 15-32-220` (exceptions in (E), hence "generally"), `SC 15-32-530` (all signed).
- **Rule:** none. This is a false negative; see pack item 3.
- **Severity:** error.
- **Fix path:** edit `$faqs[3]` in `bin/rebuild-charleston-wrongful-death.php` and re-run it against the draft. Build the string in single quotes with no `$` interpolation; the `$` signs in the dollar amounts are literal.

---

## WARN (page, pillar, template)

### W1. Comparative fault is stated as the family's fault, not the decedent's (medium; fix with E1)

- **Where it renders:**
  - TEMPLATE law box (`firm-data.php` `jurisdiction.SC.comp_fault_rule`, rendered by `template-intersection.php:422`).
  - TEMPLATE essay closing line (`firm-data.php:192`, `offices.charleston.local_context`; line 291 has the same wording for another office).
- **Published (law box):** "Comparative Fault — Modified — recover if less than 51% at fault (Nelson v. Concrete Supply Co., 303 S.C. 243, 399 S.E.2d 783 (1991))"
  - **Corrected:** "Modified — no recovery if the person who died was more than 50% at fault (Nelson v. Concrete Supply Co., 303 S.C. 243, 399 S.E.2d 783 (1991))"
- **Published (essay):** "Under South Carolina law, you have 3 years to file under S.C. Code § 15-3-530, and you can recover only if you are less than 51% at fault."
  - **Corrected (WD variant):** "Under South Carolina law, a wrongful death suit generally must be filed within **3 years (S.C. Code § 15-3-530)**, and the family can recover only if the person who died was **less than 51% at fault**."
- **Fix path (theme PR):**
  - Add `statute_overrides['wrongful-death-lawyers']['SC']` with `'tort' => true` and a `comp_fault_rule` in the wording above. `roden_resolve_statute()` merges the override, so this changes only the law box and the tort flag stays off.
    - `roden_pa_fault_threshold()` still finds "50%"; check any caller that expects "51%".
    - Add the new msgid to `es_ES.po` and recompile `es_ES.mo`.
  - For the essay, `roden_office_local_context_block()` already supports variants with **no fallback**. Add `local_context_wd` (and `_wd_es`) for Charleston, and pass `'wd'` from `template-intersection.php:474` when the pillar is `wrongful-death-lawyers`. Do the same in the other three practice-area templates if they render the essay.
    - **Caution:** with no fallback, every other office's wrongful death pages would render no essay until each office gets a `local_context_wd`. That is acceptable, but decide it knowingly.
  - Keep `S.C. Code § 15-3-530` without "(6)" or "of the death" until the pack amendment in (a) is signed.
- **Authority:** `Nelson v. Concrete Supply Co.` (signed); `SC 15-51-10` (**pending**, PR #69) for the derivative character. Gillin to confirm (see (b)).
- **Rule:** none. **Severity:** warn (medium).

### W2. The Deadlines paragraph applies § 15-3-530 to a malpractice death without the § 15-3-545 caveat; § 15-36-100 is omitted

- **Where it renders:** PAGE body, "Deadlines".
- **Published:** "If the death was caused by medical malpractice, a Notice of Intent and an expert affidavit must be filed before suit (S.C. Code § 15-79-125), and noneconomic damages are capped (S.C. Code § 15-32-220)."
- **Corrected:** "If the death was caused by medical malpractice, a Notice of Intent and a qualified expert's affidavit must be filed before suit (S.C. Code §§ 15-79-125, 15-36-100), the deadline may run from the treatment rather than the death, with a six-year outer limit (S.C. Code § 15-3-545), and noneconomic damages are generally capped (S.C. Code § 15-32-220)."
  - The "may" stays until Gillin answers (a)(2).
  - The pillar fix (`bin/fix-wd-medmal-pillar-intros.php`) already moved the affidavit to § 15-36-100; this keeps the page consistent with it.
- **Authority:** `SC 15-3-545`, `SC 15-32-220` (signed); `SC 15-79-125`, `SC 15-36-100` (**pending**).
- **Severity:** warn.

### W3. The key takeaways drop the SCTCA three-year extension that the body and FAQ 2 state

- **Where it renders:** PAGE `_roden_key_takeaways` (the summary box above the article).
- **Published:** "It generally must be filed within three years (S.C. Code § 15-3-530), or two years if a government entity is responsible (S.C. Code § 15-78-110)."
- **Corrected:** "It generally must be filed within three years (S.C. Code § 15-3-530), or within two years if a government entity is responsible, three if a verified claim is filed with the agency within one year (S.C. Code §§ 15-78-110, 15-78-80)."
- **Authority:** `SC 15-78-110`, `SC 15-78-80` (signed). **Severity:** low.

### W4. Punitive damages are offered without the cap or the government exclusion (FAQ 5, body, key takeaways)

- **Where it renders:** PAGE `_roden_faqs[4]` + FAQPage. The same unqualified statement is in the body "Damages" paragraph, the key takeaways and the PILLAR compensation intro. Fixing the FAQ is sufficient if E1 lands.
- **Published (FAQ 5):** "They can be, when the death was the result of recklessness, wilfulness or malice (S.C. Code § 15-51-40). They must be proved by clear and convincing evidence (S.C. Code § 15-33-135)."
- **Corrected:** "They can be, when the death was the result of recklessness, wilfulness or malice (S.C. Code § 15-51-40). They must be proved by clear and convincing evidence (S.C. Code § 15-33-135), are generally capped (S.C. Code § 15-32-530), and are not available against a government entity (S.C. Code § 15-78-120)."
- **Authority:** `SC 15-51-40` (**pending**); `SC 15-33-135`, `SC 15-32-530`, `SC 15-78-120` (signed). **Severity:** low.

### W5. The bottom CTA addresses an injured person

- **Where it renders:** TEMPLATE `template-intersection.php:701` (it already has a workers' comp branch).
- **Published:** "If you were injured in Charleston and believe another party is at fault, contact us for a free, no-obligation review."
- **Corrected (WD branch):** "If you lost a loved one in Charleston because of someone else's negligence, contact us for a free, no-obligation review."
- This is not a legal claim. It is the owner-deferred CTA class, raised here only because it is wrong for wrongful death specifically. Add the ES msgid.
- **Severity:** low.

### W6. The resources block is unrelated to wrongful death

- **Where it renders:** TEMPLATE, "South Carolina Wrongful Death Lawyers Resources": moped, golf cart, helmet and liquor-liability resources.
- None of them is wrong. The settlement-value resource (linked from the body) is the one that belongs here. Filter by practice area or pin it.
- **Severity:** low, presentation only.

### W7 (info). Claims that rest on PENDING or under-scoped authorities; Gillin's sign-off must cover them

| Claim on the page | Surfaces | Authority | Status |
|---|---|---|---|
| The responsible party is liable "just as if the injured person had lived" | body; FAQ 3; pillar negligence intro (§§ 15-51-10, 15-51-20) | `SC 15-51-10` | **pending** (PR #69) |
| Damages proportioned to each family member's loss; punitive damages for recklessness, wilfulness or malice; divided by intestacy | key takeaways; body; pillar compensation intro; FAQ 3; FAQ 5 | `SC 15-51-40` | **pending** |
| The survival action for the person's own claim | key takeaways; body ×2; pillar compensation intro; FAQ 3 | `SC 15-5-90` | **pending** |
| Notice of Intent and expert affidavit before suit | body Deadlines | `SC 15-79-125` (+ `SC 15-36-100` if W2 lands) | **pending** |
| Beneficiary order: spouse and children, then parents, then heirs | key takeaways; body; step 5 + HowTo; pillar negligence intro; FAQ 1 | `SC 15-51-20` | **signed, but its claim covers only "brought by the executor or administrator."** The order is in the statute (t15c051, read today). Amend the claim (pack item 1b). |
| Three years for wrongful death | key takeaways; body; FAQ 2; step 7 + HowTo; law box; essay; pillar negligence intro; sidebar | `SC 15-3-530` | **signed, but its claim says "from the date of injury … personal injury."** Subsection (6) (the clock starts at death) is not in the pack. Amend it (pack item 1a). |
| Comparative fault measured by the decedent (after W1) | law box; essay | `Nelson` + `SC 15-51-10` | Nelson is signed; § 15-51-10 is pending |

All other statements rest on signed authorities with `verifiedBy` set: `SC 15-78-110`, `SC 15-78-80`, `SC 15-78-120`, `SC 15-32-220`, `SC 15-33-135`, and `SC 33-56-180` and `SC 15-32-530` (after E1).

---

## Checks that PASS

| Check | Result |
|---|---|
| South Carolina only | There is no Georgia law on the page or in its 7 JSON-LD blocks. The pillar intros render their SC branch. The "Georgia & South Carolina" CTA strip, the stats and "Licensed in GA & SC" are accepted firm boilerplate. |
| § 15-51-10 / -20 / -40 paraphrases | They match t15c051 as read today, including "may add punitive damages when … reckless, wilful or malicious" and "divided … as under the intestacy rules". The pillar fix removed the damage-element list that § 15-51-40 does not contain. |
| § 15-5-90 | "Survives … brought by the estate", with no damages list. Matches the pending claim. |
| SCTCA | Two years; three with an optional verified claim within one year; $300,000 / $600,000. There is **no "notice" wording** on the page. |
| Med-mal cap | "Capped" with no figure. The pillar compensation intro renders the correct 2026 figures ($596,001 / $1,788,002). `SC 15-32-210(11)` and `(12)` include wrongful death and survival in "personal injury action", so the cap does reach a malpractice death. |
| Punitive burden | § 15-33-135 is clear and convincing. It is not miscited as the standard or the cap. |
| FAQ vs FAQPage JSON-LD | All 6 answers match the rendered text character for character. |
| Steps vs HowTo | All 7 match. |
| Excerpt / meta description / LegalService description | Marketing only, with no legal claim. |
| Statistics | None on the page apart from the firm stats block (accepted). |
| Citation format | Every cite is `S.C. Code § …`. The links go to t15c051 and t15c078. |
| JSON-LD validity | 7/7 blocks parse. |

---

## LINKED (do not block this publish)

All the sentences below that I replayed through the engine returned nothing (`scratchpad/chswd-linked-fixture.json`). They are false negatives.

### L1. Settlement-value resource: SCTCA "notice deadlines"; the "no cap" framing omits the charity cap

- **Page:** `/resources/south-carolina-wrongful-death-settlement-value/` (4861), linked from the body.
- **Published (body):** "Government-defendant claims can carry much shorter notice deadlines."
  - **Published (FAQ[4] + FAQPage):** "If a government entity is a defendant, notice deadlines can be much shorter."
  - The SCTCA has no notice requirement. The deadline is two years, three with an optional verified claim.
  - **Corrected (both):** "Claims against a government defendant generally must be filed within two years instead, or three if a verified claim is filed with the agency within one year (S.C. Code §§ 15-78-110, 15-78-80)."
  - Authority `SC 15-78-110`, `SC 15-78-80`. **Severity:** warn (the `sctca-shorter-notice-hedge` class, in words the rule misses).
- **Published (excerpt, key takeaways, body ×2, FAQ[0], FAQ[3]):** "no cap on compensatory damages in an ordinary case"; "the statutory non-economic cap applies only to medical-malpractice claims".
  - The charity cap (§ 33-56-180) is missing.
  - Low. Append once, in the body "Government defendant caps" section: "Claims against a charitable organization, which can include a nonprofit hospital or nursing home, are limited to the same amounts (S.C. Code § 33-56-180)."
- **Low:**
  - "cap is removed entirely when the defendant was driving under the influence". § 15-32-530(C)(3) is "under the influence … to the degree that the defendant's judgment is substantially impaired". Prefer "was substantially impaired by alcohol or drugs".
  - "(S.C. Code § 15-51)" is a chapter cite; prefer "§ 15-51-10 et seq."
- **Correct as published:** the punitive paragraph ($739,245 for 2026, indexed), the comparative fault of the deceased, and "3 years from the date of death".

### L2. Fatal car accident sub-type: recovery distributed "based on their dependency" (live, wrong)

- **Page:** `/wrongful-death-lawyers/fatal-car-accident/` (4099), in the case-types grid.
- **Published:** "Damages are distributed among the surviving spouse, children, and in some cases parents, based on their dependency on the deceased."
- § 15-51-40 divides the recovery in intestacy shares. Dependency plays no part.
- **Corrected:** "The recovery is divided among the spouse and children, or if there are none the parents, or if none the heirs, in the shares they would take under South Carolina's intestacy rules (S.C. Code §§ 15-51-20, 15-51-40)."
- **Authority:** `SC 15-51-20` (signed), `SC 15-51-40` (**pending**). **Severity:** warn (a misstatement on a live page).

### L3. "Full value of the deceased's life" (a Georgia measure) is stated for South Carolina on 4 sub-types

- **Pages and surfaces:**
  - `/wrongful-death-lawyers/medical-malpractice-death/` (4101): body "Damages…" and FAQ[4] + FAQPage ("Damages include the full value of the deceased's life … Georgia and South Carolina allow…").
  - `/wrongful-death-lawyers/nursing-home-wrongful-death/` (4104): body "Damages…".
  - `/wrongful-death-lawyers/drowning-swimming-pool-death/` (4105): body "Damages…" ("South Carolina's … provides similar remedies" follows the Georgia full-value sentence).
  - `/wrongful-death-lawyers/pedestrian-cyclist-fatality/` (4106): body "Under Georgia's … and South Carolina's (S.C. Code § 15-51-10 et seq.), families may recover the full value of the deceased's life…".
- **Corrected (SC half, in each):** "In South Carolina, the jury awards damages in proportion to the loss the death caused each family member, and the person's own pre-death claim is pursued separately by the estate (S.C. Code §§ 15-51-40, 15-5-90)."
  - The Georgia half goes to the Georgia reviewer.
- **Authority:** `SC 15-51-40`, `SC 15-5-90` (**pending**). **Severity:** warn.

### L4. Nursing-home sub-type FAQ implies South Carolina does not cap punitive damages

- **Page:** 4104, FAQ[2] + FAQPage.
- **Published:** "Georgia generally caps punitive damages at $250,000 (O.C.G.A. § 51-12-5.1) with exceptions, while South Carolina requires clear and convincing evidence of willful conduct."
- **Corrected (SC half):** "…while South Carolina requires clear and convincing evidence (S.C. Code § 15-33-135) and generally caps punitive damages at the greater of three times compensatory damages or $739,245 in 2026, a figure adjusted each year (S.C. Code § 15-32-530)."
- Also absent from the page: the med-mal cap reaches nursing homes (§ 15-32-210(4)); skilled nursing only, not assisted living, per (10). So does the charity cap. Both are low.
- **Authority:** `SC 15-33-135`, `SC 15-32-530`, `SC 15-32-220`, `SC 33-56-180`. **Severity:** warn.

### L5. Medical-malpractice death sub-type: no South Carolina deadline, "expert opinion"

- **Page:** 4101.
- The closing section gives only Georgia's deadline and repose. There is no SC deadline anywhere on the page.
- **Add:** "In South Carolina, a malpractice claim generally must be filed within three years of the treatment or of when the injury was or should have been discovered, and no more than six years after the treatment (S.C. Code § 15-3-545)." Adjust after Gillin answers (a)(2).
- **Published:** "…a Notice of Intent to File Suit accompanied by an expert opinion…"
  - **Corrected:** "…a Notice of Intent to File Suit, filed together with a qualified expert's affidavit (S.C. Code §§ 15-79-125, 15-36-100)…"
- "Johns Hopkins … 250,000 lives annually" is an unsourced and contested statistic. Source it or cut it.
- **Severity:** warn / low.

### L6. Workplace-fatality sub-type: owners and general contractors listed as suable third parties

- **Page:** `/wrongful-death-lawyers/workplace-fatality/` (4102).
- **Published:** "…third parties whose negligence caused or contributed to the death can be held fully liable: Property owners who maintained unsafe conditions at the worksite; General contractors responsible for overall job site safety; … Subcontractors…"
- Under §§ 42-1-400 and 42-1-410, an owner or contractor whose trade the work was is liable for compensation as the **statutory employer**. § 42-1-540 bars the personal representative's and next of kin's other remedies "as against his employer" "on account of such … death". In South Carolina, these listed defendants are often immune.
- **Corrected:** "…third parties whose negligence caused or contributed to the death can be held liable — for example, equipment manufacturers, or a property owner or contractor that was not the worker's employer or, in South Carolina, statutory employer (S.C. Code §§ 42-1-400, 42-1-410, 42-1-540)."
- **Authority:** `SC 42-1-540` (signed); §§ 42-1-400 and -410 have **no pack authority** (pack item 5).
- "OSHA investigates all workplace fatalities" is an overstatement (low).
- **Severity:** warn.

### L7. Statewide page (4816) and the government-vehicle page

- `/south-carolina-wrongful-death-lawyer/` (4816) is **clean on the classes checked**:
  - "within 3 years of the date of death, consistent with § 15-3-530" is correct under (6).
  - The PR requirement and the beneficiary order match the statute.
  - "The spouse receives one-half and the children share the other half" matches intestacy (§ 62-2-102; no pack authority).
- For Gillin (low): funeral and burial expenses as a wrongful death (not survival) element, and "not used to pay the deceased person's creditors". Both come from case law and have no pack authority.
- `/car-accident-lawyers/government-vehicle-accident/` FAQ caps residue ("against a single government entity") is still live. It is carried from the North Charleston plan, L8.

---

## Counts by rule

| Rule | Findings | Severity |
|---|---:|---|
| (engine) all SC + GA rules, 54 blocks + control | 0 | — |
| Hand: caps understated (punitive + charity) in "no cap" FAQ | 1 (FAQ + FAQPage) | **error** |
| Hand: comparative fault addressed to the family, not the decedent | 1 (law box + essay) | warn (medium) |
| Hand: malpractice-death deadline caveat; § 15-36-100 omitted | 1 | warn |
| Hand: SCTCA extension dropped in the key takeaways | 1 | low |
| Hand: punitive offered without cap / government exclusion | 1 (4 surfaces) | low |
| Hand: CTA addressee; unrelated resources | 2 | low |
| Hand: claims on pending or under-scoped authorities | 1 (7 claim groups) | info |
| Hand, LINKED: SCTCA "notice deadlines"; charity cap missing | 1 (4861) | warn |
| Hand, LINKED: distribution "by dependency" | 1 (4099) | warn |
| Hand, LINKED: GA "full value of life" measure applied to SC | 1 (4 pages, 5 surfaces) | warn |
| Hand, LINKED: SC punitive cap implied absent | 1 (4104) | warn |
| Hand, LINKED: no SC med-mal deadline; "expert opinion" | 1 (4101) | warn / low |
| Hand, LINKED: statutory-employer immunity ignored | 1 (4102) | warn |
| Hand, LINKED: statewide items for Gillin; gov-vehicle residue (carried) | 1 | low |
| **Total** | **15** (1 page error, 7 page warn/low/info, 7 linked) | |

Source split:
- **PAGE:** E1, W2, W3, W4.
- **TEMPLATE:** W1, W5, W6.
- **PILLAR:** carries W4's unqualified punitive sentence (low; no change needed once FAQ 5 carries the cap).
- **LINKED:** L1–L7.

## False positives

None. The engine raised nothing on this page. E1, W1 and every LINKED sentence are **false negatives** (confirmed 8/8 in `scratchpad/chswd-linked-fixture.json`). They go to an `internal-ai-scripts` PR, never to a content edit alone.

## Pack changes (proposed; not made)

Fixtures come first, in `law/fixtures/`. Re-run both fixture sets to 100% before merging. `scratchpad/chswd-corrected-fixture.json` holds ready-made controls; note that the first draft of my L1 correction ("there is no pre-suit notice requirement") fired `sctca-notice-phrases`, so it was reworded.

1. **Amend signed authorities, as pending amendments on PR #69 for Gillin:**
   - (a) `SC 15-3-530`: add "(6) a wrongful death action: three years, the period beginning to run on the death". Evidence: t15c003.php, 2026-09-28.
   - (b) `SC 15-51-20`: add "for the benefit of the spouse and children; if none, the parents; if none, the heirs". Evidence: t15c051.php, 2026-09-28.
2. **The questions in (a)(2)–(4) and (b)** go into the PR #69 sign-off packet: the § 15-3-545 vs (6) interplay, the survival clock, the SCTCA date of loss, and the decedent's comparative fault.
3. **New rule `sc-wd-cap-denied` (error, SC).**
   - **Positive:** E1 as published.
   - **Controls:** the E1 correction; 4861 FAQ[3] (it mentions § 15-32-530).
   - **Pattern:** `cap on (?:wrongful[- ]death )?damages[^?]{0,60}\?\s*(?:no|not in an ordinary case)\b`, with `unless` `15-32-530|punitive damages are (?:generally )?capped`.
4. **New rules:**
   - `sc-wd-full-value-of-life` (warn, SC). **Positives:** L3 (4106 sentence; 4101 FAQ[4]). **Controls:** the L3 correction, and a Georgia-only full-value sentence. **Pattern:** `(?:south carolina|s\.c\. code)[^.]{0,200}full value of (?:the )?(?:deceased|decedent)|full value of (?:the )?(?:deceased|decedent)[^.]{0,200}(?:south carolina|s\.c\.)`.
   - `sc-wd-distribution-by-dependency` (warn, SC). **Positive:** L2. **Pattern:** `(?:distributed|divided)[^.]{0,120}dependen`, with `unless` `intestac`.
5. **Extend `sctca-shorter-notice-hedge`** to "notice deadlines can be much shorter" and "can carry much shorter notice deadlines" (L1), with the existing Georgia/ante-litem `unless`.
6. **Pending authorities (`verifiedBy: null`):**
   - `SC 42-1-400` and `SC 42-1-410` (statutory employer; the owner or contractor is liable for compensation and is therefore within § 42-1-540 exclusivity). Evidence: t42c001.php, 2026-09-28. Needed for L6.
   - `SC 62-2-102` only if pages are to keep citing the one-half intestate split.

After any pack change: `node scripts/facts/vendor.mjs rodenlaw --write` if the client vendors the pack, then `--check`.

## Before publish

1. **Required:** E1. Edit `$faqs[3]` in `bin/rebuild-charleston-wrongful-death.php`.
2. **Recommended in the same pass:** W1 (theme PR: the WD `statute_overrides` entry, `local_context_wd` and the variant argument, plus ES msgids and a recompiled `.mo`), W2, W3 and W4 (script edits), and W5 (template).
3. Re-run the script against the draft, re-render, and replay `scratchpad/draft3649-fixture.json`.
   - Update the FAQ 4, FAQ 5, key takeaways and Deadlines entries.
   - The replay must stay at 0 findings with the control firing.
   - Confirm that FAQ 4 and FAQ 5 in the FAQPage JSON-LD match the rendered text.
4. **Gillin** reviews the page **and signs** PR #69's five pending authorities plus the two amendments (pack item 1). Only then set `$reviewed` in the publish script, which removes `_roden_retired` and sets `_roden_last_reviewed`.
   - Until he signs, `law/SC.json` is **signed only for its 34 authorities**. The 5 pending authorities are **UNSIGNED**.
5. **Separately, in a wrongful-death sub-types batch:** L1–L6, through `bin/apply-faq-remediation.php` for the FAQs and an exact-match `str_replace` patcher for bodies (`wp_slash`, no `$` in replacements). Then regenerate `content/meta.json` and run `bin/check-unslashed-post-writes.php`.
   - The Georgia halves of L3 and L4 go to the Georgia reviewer.
