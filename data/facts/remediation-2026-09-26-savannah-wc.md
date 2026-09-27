# Pre-publish legal sweep: Savannah workers' compensation page (post 3652, DRAFT)

- **Page:** `/workers-compensation-lawyers/savannah-ga/` (post 3652, `practice_area`, draft; parent: WC pillar, post 3610).
- **Jurisdiction:** Georgia only. Author and reviewer of record: Eric Roden (State Bar of Georgia). Georgia claims on this page are approved by his review of the page.
- **What was swept:** the rendered draft HTML (`scratchpad/preview/draft3652.html`) and all 7 JSON-LD blocks in it (LegalService, Person, FAQPage, WebPage, HowTo, LocalBusiness/LegalService/LawFirm, BreadcrumbList). All 7 parse.
  - **Page surfaces**, from `bin/rebuild-savannah-workers-comp.php`: body, excerpt (the "What Is a Workers' Compensation Case" block), meta description (also the LegalService `description`, `og:` and `twitter:` descriptions), key takeaways, 6 FAQs.
  - **Template blocks:** hero, NAP bar, office map and directions, the GA WC what-to-do steps and HowTo, the law box, the sidebar deadline widget, the Savannah WC essay (`inc/firm-data.php` `offices.savannah.local_context_wc`, #179), the WC pillar's "Do I Have a Case" and "Types of Compensation" intros (post 3610, GA branches as corrected by `bin/fix-wc-pillar-intros.php` pass 3), resources, the bottom CTA and the footer.
  - **Linked pages:** the six body links were checked against `content/meta.json` (all published). Two of them carry live findings (L1, L2).
- **Pack:** `law/GA.json` at `internal-ai-scripts` `origin/main` (894c315). The pack is signed. Its WC authorities:
  - signed: `GA 34-9-82`, `GA 34-9-80`, `GA 34-9-261`;
  - **UNSIGNED (pending):** `GA 34-9-11`, `GA 34-9-17`. Under rule 1 these cannot back a new claim from the pack; on this page they rest on Eric Roden's review;
  - absent: § 34-9-201 (panel of physicians), cited in the Savannah essay. See A1.
- **Engine run:**
  - 326 blocks were replayed through `sweep-claims.mjs --fixtures scratchpad/draft3652-fixture.json --law scratchpad/law-main3652/law --states GA,SC`: every rendered text line, every JSON-LD `text`/`description`/`name`, and the whole page as one block.
  - Result: **0 findings.**
  - Positive controls fired as expected: `wc-deadline-cited-to-tort-statute` (a WC deadline cited to § 9-3-33), `georgia-is-no-fault` and `wc-max-weekly-stale-figure` ($550).
  - **Pack gap:** a control reading "two years from the date of injury to file your workers' compensation claim (O.C.G.A. § 34-9-82)" produced **nothing**. The GA pack's `GA 34-9-82` claim says "There is no two-years-from-injury rule", but no rule enforces it. See the pack follow-ups.
- **Primary text:** Justia serves a bot challenge from here. §§ 34-9-11, 34-9-17, 34-9-80, 34-9-82 and 34-9-201 were read from Wayback Machine snapshots of the Justia pages on 2026-09-26:
  - `web.archive.org/web/20241111204703/https://law.justia.com/codes/georgia/title-34/chapter-9/article-1/section-34-9-11/`
  - `web.archive.org/web/20250213234232/https://law.justia.com/codes/georgia/title-34/chapter-9/article-1/section-34-9-17/`
  - `web.archive.org/web/20241103034806/https://law.justia.com/codes/georgia/title-34/chapter-9/article-3/part-1/section-34-9-80/`
  - `web.archive.org/web/20241114043705/https://law.justia.com/codes/georgia/title-34/chapter-9/article-3/part-1/section-34-9-82/`
  - `web.archive.org/web/20241007052440/https://law.justia.com/codes/georgia/title-34/chapter-9/article-6/part-1/section-34-9-201/`

**Verdict: FAIL. There is one error-level finding (E1, TEMPLATE).**
- The page's own copy (PAGE) has no error. Wherever the page's own copy states § 34-9-82, it gives all three prongs or hedges with "generally": body, FAQ 2, key takeaways, meta description, and the essay.
- The GA WC step 5 (and its HowTo schema) states a flat "1 year from the date of injury" as *the* deadline. That contradicts the page's own body and FAQ.
- There are no SC leaks and no tort leaks. The bottom CTA uses the WC branch (#177). There is no GA equivalent of the SC up-link on this page.
- There are 5 warnings on this page, 2 live findings on linked posts, and 1 authority to add.

Source key:
- **PAGE** means `bin/rebuild-savannah-workers-comp.php` or post 3652's existing meta.
- **TEMPLATE** means the theme or WC-pillar meta. A TEMPLATE fix reaches other pages too.
- **LINKED** means a live, published page linked from this draft's body.

---

## ERROR

### E1. What-to-do step 5 gives "1 year from the date of injury" as the whole § 34-9-82 rule

- **Surfaces:** step 5 (visible) and HowTo step 5 (JSON-LD, which stands alone in search).
- **Source:** TEMPLATE.
  - The `$filing_deadline` msgid `'%1$s year from the date of injury (%2$s)'` is at `inc/template-tags.php:1651`, fed by `statute_overrides.workers-compensation-lawyers.GA.statute_years = 1` in `inc/firm-data.php`.
  - This reaches every GA WC page that renders the steps.
- **Published:** "Reporting the injury to your employer is not the same as filing a claim. File with the State Board of Workers' Compensation (form WC-14) — 1 year from the date of injury (O.C.G.A. § 34-9-82)."
- **Corrected:** "Reporting the injury to your employer is not the same as filing a claim. File with the State Board of Workers' Compensation (form WC-14) — generally within 1 year of the injury, or longer if your employer has paid for treatment or weekly benefits (O.C.G.A. § 34-9-82)."
  - **Implementation:** add a translatable `statute_detail` field to the GA override, and use it here when it is set. The SC override can leave it empty, since its step reads correctly.
  - The comparison table already carries a translated msgid for the same rule: "1 year from injury, extended by employer-paid treatment or benefits (O.C.G.A. § 34-9-82)" (`es_ES.po:3927`). Reuse it if a terser form is wanted.
  - Any new msgid needs its ES translation and a recompiled `es_ES.mo`.
- **Authority:** `GA 34-9-82` (signed). Its claim is "One year from the date of injury, or one year from the last employer-furnished remedial treatment, or two years from the last payment of weekly benefits."
  - Primary text, (a): "barred unless a claim therefor is filed within one year after injury, except that if payment of weekly benefits has been made or remedial treatment has been furnished by the employer … within one year after the date of the last remedial treatment … or within two years after the date of the last payment of weekly benefits."
- **Rule:** none (see the pack follow-ups).
- **Why it is an error, not a style point:** the flat figure is the one surface that stands alone in structured data. It tells a worker whose first year has passed, but who is still receiving employer-paid treatment or weekly checks, that the claim is gone.
  - The same page's body and FAQ 2 say otherwise, so the page contradicts itself (rule 5).

---

## WARN

### W1. The law box and sidebar show "1 year" / "1 yr" with no qualifier

- **Surfaces:** the law box "Deadline to File a Claim: 1 year (O.C.G.A. § 34-9-82)" (`templates/template-intersection.php:396`) and the sidebar "Georgia Filing Deadline: 1 yr" (`template-intersection.php:778`). Both TEMPLATE, from the same `statute_years = 1`.
- **Published (law box):** "1 year (O.C.G.A. § 34-9-82)"
- **Corrected (law box):** "1 year from injury, extended by employer-paid treatment or benefits (O.C.G.A. § 34-9-82)" (the existing translated msgid).
- **Published (sidebar):** "1 yr … O.C.G.A. § 34-9-82"
- **Corrected (sidebar):** keep the "1 yr" badge, and add one line under the cite: "Longer if your employer paid for treatment or weekly benefits."
- **Authority:** `GA 34-9-82` (signed).
- **Rule:** none. This is a warning, not an error, because these are compact labels next to a body that states the full rule. Fix them in the same change as E1, since they read from the same data.

### W2. "Last reviewed: July 31, 2026" certifies copy that did not exist on 07-31

- **Surfaces:** the byline under the "What Is…" block ("Reviewed by Eric Roden, Founding Partner, CEO at Roden Law · Last reviewed: July 31, 2026") and the WebPage JSON-LD (`lastReviewed: 2026-07-31`, `reviewedBy` Eric Roden).
- **Source:** PAGE. This is post 3652's pre-rebuild `_roden_last_reviewed`. The rebuild script correctly never sets it, but it also does not clear it. This is the same defect found on Charleston WC (W6 there).
- **Action:** do not publish with this stamp. When Eric Roden reviews the page, set `_roden_last_reviewed` to his review date. If the page is published before his word, delete the key first.
- **Related, PAGE, not published:** the script's docblock says publishing follows "Graeham C. Gillin's sign-off". For this Georgia-only page, the sign-off is Eric Roden's. Correct the comment so the next reader does not route the page to the wrong reviewer.

### W3. The 30-day notice is the outer limit; the statute says "immediately"

- **Surfaces:** body "Two deadlines, not one", KT, FAQ 2, meta description / LegalService `description` (PAGE); step 1 and HowTo, the law box and the sidebar (TEMPLATE).
- **Issue:** § 34-9-80 requires notice "immediately on the occurrence of any accident or as soon thereafter as practicable". Until notice is given, the employee "shall not be entitled to any physician's fees nor to any compensation which may have accrued … prior to the giving of such notice".
  - The 30 days is the bar, and it carries exceptions: incapacity, fraud or deceit, the employer's knowledge, or a reasonable excuse with no prejudice.
  - Every surface is consistent with the signed `GA 34-9-80` claim ("within 30 days"), so this is not an error.
  - Step 1 says "can bar", which is accurate given the exceptions. The sidebar says "usually ends", which is also fine.
- **Published (body):** "You must give your employer notice of the injury within 30 days (O.C.G.A. § 34-9-80)."
- **Corrected (body):** "Give your employer notice of the injury right away, and no later than 30 days after it happens (O.C.G.A. § 34-9-80)."
- **Published (FAQ 2, first sentence):** "You must notify your employer within 30 days (O.C.G.A. § 34-9-80)."
- **Corrected (FAQ 2):** "Notify your employer right away, and no later than 30 days after the injury (O.C.G.A. § 34-9-80)."
- **Optional:** the KT and the meta description can stay as they are. "Within 30 days" is true, and space is tight.
- **Note on step 1 ("Notify a supervisor or HR in writing"):** this is sound advice, but it is not a legal requirement. Under § 34-9-80, in-person notice within 30 days is enough, and writing is required only if no in-person notice was given. No change is needed, because the sentence is advice.
- **Authority:** `GA 34-9-80` (signed). At the next re-sign, suggest amending its `claim` to mention "immediately / as soon as practicable" and the exceptions.
- **Rule:** none.

### W4. Third-party examples do not mention co-employee and statutory-employer immunity

- **Surfaces:**
  - step 7 and HowTo ("a negligent driver, a contractor on site, or a defective machine's manufacturer"), TEMPLATE;
  - the pillar "Do I Have a Case" block ("a property owner where you were injured"), TEMPLATE, shared text outside the `{{GA}}` branch.
- **Issue:** § 34-9-11(a) preserves actions against third-party tortfeasors "other than an employee of the same employer", or a person who provides the employee's WC benefits under contract.
  - A contractor above the employer on the job can be a statutory employer (§ 34-9-8), and so immune. VERIFY: I have not read § 34-9-8's primary text here.
  - "May recover" hedges step 7. The pillar block states "remain available" flat.
- **Published (pillar):** "Third-party tort claims against someone other than your employer remain available (e.g., a defective machine manufacturer, a negligent driver who hits you at work, a property owner where you were injured) and can be pursued in parallel with the workers’ comp claim."
- **Corrected (pillar, GA branch):** "Third-party tort claims against someone other than your employer or a co-worker remain available (e.g., a defective machine manufacturer, a negligent driver who hits you at work, or a separate company on the job site) and can be pursued in parallel with the workers’ comp claim."
- **Authority:** pending `GA 34-9-11` (the co-employee exclusion is in its text). Add § 34-9-8 as pending if the statutory-employer wording is adopted.
- **Rule:** none. Low severity. This is the GA counterpart of Charleston W7. One shared sentence can carry both states' fixes if it is moved into the `{{GA}}`/`{{SC}}` branches.

### W5. Panel of physicians: the essay cites § 34-9-201, which is not in the pack; "must post a panel" leaves out the MCO option

- **Surfaces:** the Savannah WC essay (TEMPLATE, `inc/firm-data.php:92`) cites § 34-9-201. The body "Choosing your doctor", KT, FAQ 3 (PAGE), and steps 2–3 (TEMPLATE) state the panel rule uncited.
- **Wording against the text:** all of it is correct.
  - § 34-9-201(b)(1) requires a panel of at least six physicians.
  - Under (c), the employer shall post the Panel of Physicians or Managed Care Organization Procedures.
  - Under (d), the selection requirements do not apply in an emergency. This supports "except in an emergency" in step 2.
  - Under (f), if the employer fails to provide the procedures, the employee "may select any physician … at the expense of the employer". This supports step 3.
  - "Generally" covers the MCO alternative in (b)(2), so no rewrite is needed.
- **Action:** see A1. The claims rest on Eric Roden's review until the authority is signed.

---

## LIVE FINDINGS ON LINKED PAGES (do not block this draft; they are live now)

### L1. ERROR: "Employees usually have 10 days to make a report"

- **Page:** `/blog/workers-compensation-claim-process-georgia/`, linked from this draft's body as "how the Georgia claim process works". Surface: `_roden_faqs[0].answer`, so it is also published in FAQPage structured data.
- **Published:** "Report the injury to your employer right away and follow your company's internal reporting procedure. Employees usually have 10 days to make a report, but doing it immediately protects the claim far better than waiting does."
- **Corrected:** "Report the injury to your employer right away and follow your company's internal reporting procedure. Georgia law requires notice within 30 days of the accident (O.C.G.A. § 34-9-80), but reporting immediately protects the claim far better than waiting does."
- **Authority:** `GA 34-9-80` (signed).
- **Rule:** none. Proposed `ga-wc-notice-wrong-days` below.
- **Fix path:** `bin/apply-faq-remediation.php`, then sweep that post's body for the same claim *class*. The body is not in `content/meta.json`.
- **Same FAQ block, VERIFY:** `_roden_faqs[1]` says the Employer's First Report is due within 10 days once the worker misses "three or more days". I could not confirm this against State Board Rule 61 from here. It is not the worker's obligation, but it is a statement of law. Confirm it or cut it.

### L2. WARN: flat "one year from the date of the accident" in two linked posts' FAQs

- **Pages and surfaces:**
  - `/blog/workers-compensation-claim-process-georgia/` `_roden_faqs[4]`
  - `/blog/appealing-a-denied-workers-compensation-claim/` `_roden_faqs[2]`
- **Published (both):** "Georgia allows one year from the date of the accident to file a workers' compensation claim (O.C.G.A. § 34-9-82)."
- **Corrected:** "Georgia generally allows one year from the date of the accident to file a workers' compensation claim, longer if your employer has paid for treatment or weekly benefits (O.C.G.A. § 34-9-82)."
- **Authority:** `GA 34-9-82` (signed). This is the same claim class as E1.

---

## AUTHORITY TO ADD (pack PR, `verifiedBy: null`)

### A1. `GA 34-9-201`, panel of physicians

```json
{ "id": "GA 34-9-201", "cite": "O.C.G.A. § 34-9-201", "subject": "workers' compensation choice of physician",
  "claim": "The employer furnishes medical care through a posted Panel of Physicians (at least six, including an orthopedic surgeon, no more than two industrial clinics; the employee may make one change within the panel without Board approval) or through certified Managed Care Organization procedures, and must post the panel or MCO procedures prominently. The selection requirements do not apply in an emergency. If the employer fails to provide a selection procedure, the employee may select any physician at the employer's expense.",
  "quantities": ["six", "6"],
  "evidence": "Read 2026-09-26, Wayback snapshot web.archive.org/web/20241007052440/https://law.justia.com/codes/georgia/title-34/chapter-9/article-6/part-1/section-34-9-201/ — (b)(1), (b)(2), (c), (d), (f). law.justia.com served a bot challenge; confirm against the current Code before signing.",
  "verifiedAt": "2026-09-26", "verifiedBy": null }
```

**Pending authorities cited on this page (checked against the primary text; the wording is correct; they rest on Eric Roden's review):**
- **`GA 34-9-11`:** "generally your exclusive remedy against your employer: no lawsuit and no pain-and-suffering or punitive damages from the employer" matches (a), which excludes "all other rights and remedies … at common law or otherwise". "Generally" covers the written-agreement proviso.
  - Suggest adding the co-employee exclusion to the pending `claim` (see W4).
- **`GA 34-9-17`:** "Benefits can be barred for an employee's willful misconduct or for intoxication" matches (a) and (b). The burden is on the party claiming the forfeiture, (c), and the page makes no contrary statement.

## PACK FOLLOW-UPS (proposed rules; fixtures first, then the narrowest `unless`)

1. **`ga-wc-two-years-from-injury`** (error).
   - Assert: a WC claim deadline of `two years|2 years` measured from `injury|accident`, in a `workers'? comp` context.
   - `unless`: `last (?:payment|weekly)|weekly benefits|personal injury|lawsuit|tort|9-3-33`.
   - Controls: this page's body and FAQ 2 sentences (must pass), and the Darien essay's "half the two-year window" contrast (must pass). The failing control used in this sweep must fire.
2. **`ga-wc-notice-wrong-days`** (error).
   - Assert: notify/report the employer within `\d+ days` other than 30, in a WC context.
   - `unless`: `First Report|WC-1|employer (?:must|shall) (?:file|submit)`, so the employer-report sentence in L1 is not caught.
   - L1's first sentence is the positive fixture.
3. Optional, **`ga-wc-flat-one-year`** (warn): flat `1 year|one year` + § 34-9-82 with no `generally|extended|last (?:remedial|payment)|treatment|weekly benefits` in the sentence. This one is noisier than the other two. Add it only if the fixture set stays at 100% on the current GA WC surfaces.

---

## Same claim class elsewhere (TEMPLATE, not rendered on this page)

- **Darien WC essay** (`inc/firm-data.php:144`, `offices.darien.local_context_wc`): "the deadline is one year from the date of injury under O.C.G.A. § 34-9-82 — half the two-year window…". Flat. Adopt the Savannah essay's wording ("generally … extended by employer-furnished treatment or weekly benefit payments") before a Darien WC page is built.
- **Generated key takeaways** (`inc/template-tags.php:2523`, single-state statutory branch): uses the same flat `'%1$s year from the date of injury (%2$s)'` msgid as E1. It renders on any WC page with no `_roden_key_takeaways`. The E1 fix should cover it.
- **Two-state key takeaways** (`inc/template-tags.php:2558`): "%1$s years from the date of injury in Georgia" renders "1 years" and is flat. It belongs to the pillar or sub-type pages, not this one.

## Checked and clean (no finding)

- **§ 34-9-82, three prongs:** stated correctly in the body, FAQ 2 (visible and FAQPage JSON-LD, character-identical) and the essay ("generally one year … extended by employer-furnished treatment or weekly benefit payments"). KT and meta description use "generally within one year". Flat forms appear only in E1/W1.
  - There is no "two years" anywhere except the correct last-weekly-payment prong.
- **30-day notice:** consistent on all 8 surfaces (see W3 for the "immediately" nuance).
- **State Board / WC-14:** "not filed in court. It goes on form WC-14 to the State Board" is consistent with § 34-9-82(c) (filed with the board). "Telling your supervisor is not the same as filing a claim" is correct.
- **Weekly maximum:** no dollar figure anywhere. "Capped at a maximum set by statute and adjusted periodically (O.C.G.A. § 34-9-261) … confirmed with the State Board" and the pillar's "weekly maximum … adjusted periodically" match the signed `GA 34-9-261` claim. § 34-9-265 is gone (pass 3 applied).
  - Info: the pillar's "TTD at 2/3 of average weekly wage" has no quantity in `GA 34-9-261`. Add "two-thirds" to that authority at the next re-sign.
- **Exclusive remedy:** hedged ("generally", "usually") on every surface: body, KT, FAQs 4 and 6, and the pillar `{{GA}}` branch, which now cites § 34-9-11 instead of "§ 34-9-1 et seq.". FAQ 6's "a separate claim against a third party … can include them" is hedged ("can").
- **Willful misconduct / intoxication:** body and FAQ 5 match § 34-9-17(a)–(b). The law box "No-fault — benefits do not depend on proving employer negligence" is correct.
- **Port / federal pointer:** "covered by federal law instead of, or in addition to, Georgia workers’ compensation" is accurate as a pointer, since coverage can be concurrent. The federal-authority question is out of scope.
- **Garden City Terminal** and **the Port of Savannah** are named correctly. The Memorial Health University Medical Center (Waters Avenue) Level I claim is consistent with prior Savannah sweeps.
- **No SC law:** no S.C. Code cite, no 90 days, no Form 50, no Commission. The pillar blocks rendered their `{{GA}}` branches. SC appears only in global chrome (the header strap, footer, nav and disclaimer).
- **No tort rules:** no § 9-3-33, § 51-12-33, 50%/49%/51% bar, comparative fault, or "pain and suffering from the employer" claim. "Negligent" appears only for third parties. The bottom CTA is the WC branch ("hurt on the job … workers’ compensation claim and any third-party claim").
- **Surface agreement:** the FAQPage JSON-LD matches the visible FAQs, and the HowTo matches the visible steps.
- **Info, not legal:** the "Local Workers' Compensation Lawyers Resources" block lists moped, helmet and the Georgia tort-SOL resource. The SOL resource's own FAQ handles WC correctly ("one year, not two … can reset"), so it is not tort leakage. It is still an off-topic selection.

## Counts by rule

| Rule | Findings |
|---|---|
| (engine) any pack rule | 0 (326 blocks; 3 positive controls fired) |
| hand: incomplete § 34-9-82 (flat one year) | 1 error (E1), 1 warn (W1), 1 live warn (L2, 2 posts) |
| hand: wrong WC notice period | 1 live error (L1) |
| hand: review attribution | 1 warn (W2) |
| hand: incomplete § 34-9-80 | 1 warn (W3) |
| hand: third-party scope | 1 warn (W4) |
| hand: pack authority missing | 1 warn (W5) / A1 |

By source:
- **PAGE:** W2, W3 (body, FAQ 2).
- **TEMPLATE:** E1, W1, W3 (steps, law box, sidebar), W4, W5 (essay cite).
- **LINKED:** L1, L2.

## False positives

None. The engine produced no findings. The proposed rules need this page's correct § 34-9-82 sentences and the Darien contrast sentence as fixture controls before they land.
