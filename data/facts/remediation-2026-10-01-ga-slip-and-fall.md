# Pre-publish legal sweep: Georgia slip-and-fall settlement value guide (DRAFT, not published)

- **Page (draft; target slug returns 404 today):** `/resources/georgia-slip-and-fall-settlement-value/`
- **Source:** `data/practice-area-drafts/2026-10/ga-resources/georgia-slip-and-fall-settlement-value.json`
- **Jurisdiction:** Georgia only. Reviewer of record: Tyler Love (attorney post 3730). For Roden, Tyler Love's review (Eric Roden also) is the approval for Georgia wording.
- **Pack:** `internal-ai-scripts/law/GA.json` is **signed**. This sweep did not edit it.
  - Signed authorities the page uses: `GA 9-3-33`, `GA 51-12-33`, `GA 51-11-7`, `GA 36-33-5`, `GA 36-11-1`, `GA 50-21-26`. All six are used within their signed claims.
  - The pack has **no authority** for §§ 51-3-1, 51-3-2, 51-3-3, § 9-10-184, § 51-12-1.1, or any case (Robinson, AMC, Shepard, Perkins). Every sentence resting on those is **statute-text verified (or case law), pending Tyler**. None may be treated as pack-backed. Pack PR candidates are listed at the end. A pack PR goes through the pack's signer and never through a page edit.
  - `GA 50-21-29` (GTCA cap) is still **pending** in the pack. The draft does not mention it, and that is correct.
- **What was swept:** every field that publishes.
  - `title`, `meta_title`, `meta_description`, `key_takeaways`, `body_html` (including all six table rows) and all 7 FAQs.
  - The FAQs also become FAQPage JSON-LD.
  - The draft has **no `post_excerpt`**. `roden_schema_article()` publishes the excerpt as the Article `description` (see A3).
- **Read against:**
  - the research brief `data/facts/ga-slip-and-fall-research-2026-10-01.md` (claims C1–C18, do-not-state D1–D12);
  - the statute text quoted there: §§ 51-3-1/-2/-3 from FindLaw 2024; §§ 51-12-1.1, 9-10-184 and 51-3-50 to -57 from the SB 68 as-passed text;
  - the case holdings read on CourtListener 2026-10-01 (Robinson v. Kroger Co., 268 Ga. 735 (1997); American Multi-Cinema, Inc. v. Brown, 285 Ga. 442 (2009); Shepard v. Winn Dixie, 241 Ga. App. 746 (1999); Perkins v. Val D'Aosta Co., 305 Ga. App. 126 (2010)).
  - Justia was re-tried on 2026-10-01 for § 51-3-2 and still serves its bot challenge, so the §§ 51-3-1 to -3 history lines are still unread (brief § 8).
- **Engine runs:**
  - **Writer's fixture** `data/facts/ga-slip-and-fall-replay-2026-10-01.json`: **147/147** (re-run today). It passes because the engine has no rule for any class found below.
  - **This sweep's replay** `data/facts/ga-slip-and-fall-remediation-replay-2026-10-01.json`: **95/95 met.**
    - **Draft half (59 entries):**
      - the 5 required corrected strings and 6 recommended strings;
      - 23 whole corrected surfaces: KT, meta, title, 7 FAQ Q+A, and every body paragraph and table row;
      - 5 gap probes (the original erroneous strings), all silent;
      - 6 positive controls planted in corrected wording, **all fired**: `municipal-ante-litem-12-months`, `county-ante-litem-6-months`, `gtca-notice-6-months`, `joint-and-several-liability`, `comparative-negligence-wrong-statute`, `foreign-SC`.
    - **Live half (36 entries):** 17 proposed replacements, 17 current live strings (all silent) and 2 positive controls (both fired).
    - One proposed live replacement (L14) first carried an S.C. Code cite and fired `foreign-SC`. The pillar renders per state, so that cite would have been foreign on Georgia pages. The cite was dropped; that was a true positive, not a false one.
  - **FAQ gate** (`verify-faq-drafts.mjs --client roden`, corrected FAQs against the corrected body): 7 answers, 0 failures, 0 warnings.
  - **Every required finding below was caught by reading, not by a rule.**

Source key: **PAGE** = the draft JSON. **LIVE** = production database, read-only, 2026-10-01.

Status labels:
- **Required**: block publish until fixed.
- **Recommended**: fix before publish if Tyler agrees.
- **Advisory**: record only.

## Verdict

**FAIL: 5 required edits on 4 surfaces** (key takeaways, body ×2, meta description, FAQ 5). After them the page **PASSES**, subject to Tyler's answers on Q1–Q8. Q1–Q4, Q6 and Q8 cover statements that are not in the signed pack.

What the draft gets right:
- No dollar figure, average, range, multiplier or worked example anywhere (D1).
- No "full medical bills" and no collateral-source statement (D2, D3).
- No GTCA figures and no unqualified "no cap" (D4, D5).
- Nothing about what counsel may tell a jury (D6).
- No "owners must have insurance" (D7).
- No strict-liability framing (D9).
- No negligent-security elements (D10).
- No workers' comp pairing with the two-year deadline (D11).
- No SB 68 seat-belt or "SB 68 changed the 50% bar or deadlines" statement (D12). The SB 69/seat-belt class is absent.
- No SC leak.
- The two-part test in the body and FAQ 2 keeps the "because of something the owner did or controlled" element. Robinson and AMC are cited correctly (court, volume, page, year).
- § 51-12-33 and § 51-11-7 are kept as separate rules (Q5 framing).
- The ante litem periods are 6/12/12 with "presented" for counties.
- § 51-12-1.1 is limited to falls on or after April 21, 2025.

| ID | Status | Field | Class |
|---|---|---|---|
| R1 | Required | `key_takeaways` | Case-law test: second prong drops "because of something the owner did or controlled" (contradicts body and FAQ 2) |
| R2 | Required | `body_html` | Entrant status: invitee narrowed to "customer"; licensee defined as anyone not a customer (the live blog's error class) |
| R3 | Required | `body_html` | § 9-10-184 cited for more than it says |
| R4 | Required | `meta_description` | Knowledge test reduced to actual knowledge |
| R5 | Required | `faqs[4]` | "Government property" sweeps in federal property, where no earlier notice deadline applies |
| RC1 | Recommended (Q4) | `body_html` | Prior-traversal presumption missing "readily visible" limit |
| RC2 | Recommended (Q3) | `body_html` | § 51-12-1.1 "generally measured by" vs the statute's "limited to" |
| RC3 | Recommended | `body_html` (2) | Insurance as "the practical limit": unsourced absolute |
| RC4 | Recommended (Q7) | `body_html`, `faqs[5]` | "Written" notice applied to county presentment; "public property" vs a claim against the government |
| A1–A5 | Advisory | various | see below |

---

## Required edits

### R1 (Required). The key takeaways drop the second prong's causal element.

- **Holding:**
  - Robinson, 268 Ga. 735: the invitee must prove "(2) that the plaintiff lacked knowledge of the hazard despite the exercise of ordinary care **due to actions or conditions within the control of the owner/occupier**."
  - AMC, 285 Ga. 442: "lacked knowledge of the hazard **due to the defendant's actions or to conditions under the defendant's control**."
- **Why required:** the body and FAQ 2 state the test with the element; the KT box, which renders above the article, does not. The page then states the test two ways. Without the element, the second prong reads as "you didn't know about it", which is not the Georgia test.
- **Authority:** none in the pack. CASE LAW, PENDING TYLER (Q1).
- **Rule:** none (`gap-R1` silent).

| # | Field | Before | After |
|---|---|---|---|
| R1 | `key_takeaways` (sentence 2) | To recover for a fall on a business's property, Georgia courts generally require proof that the owner knew or should have known about the hazard, and that you did not know about it despite using ordinary care. | To recover for a fall on a business's property, Georgia courts generally require proof that the owner knew or should have known about the hazard, and that you did not know about it despite using ordinary care, because of something the owner did or controlled. |

### R2 (Required). The entrant-status paragraph makes "customer" the only invitee and every non-customer a licensee.

- **Statute text:**
  - § 51-3-1: an owner or occupier who "by express or implied invitation, induces or leads others to come upon his premises **for any lawful purpose**" owes ordinary care.
  - § 51-3-2(a): a licensee is a person who "(1) Is neither a customer, a servant, nor a trespasser; (2) **Does not stand in any contractual relation with the owner** of the premises; and (3) Is **permitted**, expressly or impliedly, to go on the premises **merely** for his own interests, convenience, or gratification."
- **The draft:** "A business that invites customers onto its property …" followed by "Someone on the property for their own purposes, **rather than as a customer**, is a licensee".
  - Read together, these make every non-customer a licensee. That includes a delivery driver, a contractor, a repair technician and anyone else with a business or contractual connection.
  - § 51-3-2(a)(2) excludes all of them. This is the same class as the live blog's "repair technician is a licensee" (L8 below), which the brief told the writer not to repeat (D8).
  - It also drops "permitted", which is what separates a licensee from a trespasser.
- **Why required:** a reader who came to make a delivery or do a repair is told they are owed only protection from willful or wanton injury, a far weaker duty than the one the law gives them.
- **Authority:** none in the pack. STATUTE-TEXT VERIFIED (FindLaw 2024; Justia 2025 history unread), PENDING TYLER (Q8).
- **Rule:** none (`gap-R2` silent).

| # | Field | Before | After |
|---|---|---|---|
| R2 | `body_html` (H2 "What do you have to prove…", paragraph 2, sentences 2–3) | A business that invites customers onto its property must exercise ordinary care to keep the premises and approaches safe (O.C.G.A. § 51-3-1). Someone on the property for their own purposes, rather than as a customer, is a licensee and can recover only for willful or wanton injury (O.C.G.A. § 51-3-2). | An owner or occupier who invites people onto the property for a lawful purpose, as a business invites its customers, must exercise ordinary care to keep the premises and approaches safe (O.C.G.A. § 51-3-1). Someone who is not a customer or employee, has no contractual relationship with the owner, and is permitted on the property merely for their own interests is a licensee, and can recover only for willful or wanton injury (O.C.G.A. § 51-3-2). |

The next sentences ("A trespasser is owed only the duty not to cause willful or wanton injury (O.C.G.A. § 51-3-3). Those claims are generally much harder to prove.") are correct against § 51-3-3(b) and stay as written.

### R3 (Required). § 9-10-184 is cited as the source of what Georgia law "recognizes" as recoverable.

- **Statute text:**
  - § 9-10-184 governs **argument of counsel** on noneconomic damages. Its subsection (a) defines "economic damages" and "noneconomic damages" for that section ("past and future medical expenses … loss of wages; loss of income; loss of earning capacity"; "physical or emotional pain … suffering … mental anguish … loss of enjoyment of life").
  - It does not create or recognize a right to recover any of them.
- **Why required:** the brief's rule is that § 9-10-184 is cited only for what it says (C11 uses "lists"). "Recognizes … (O.C.G.A. § 9-10-184)" makes it the source of recoverability. The fix is one verb and keeps the cite on what the section actually does.
- **Authority:** none in the pack. STATUTE-TEXT VERIFIED (SB 68 § 1 as passed; Justia 2025 history read 2026-09-30), PENDING TYLER (Q6).
- **Rule:** none.

| # | Field | Before | After |
|---|---|---|---|
| R3 | `body_html` (H2 "What damages can you recover…", paragraph 1) | Georgia law recognizes economic damages, such as medical expenses, lost wages and lost earning capacity, and noneconomic damages, such as pain, suffering, mental anguish and loss of enjoyment of life (O.C.G.A. § 9-10-184). | Georgia law lists medical expenses, lost wages and lost earning capacity among economic damages, and pain, suffering, mental anguish and loss of enjoyment of life among noneconomic damages (O.C.G.A. § 9-10-184). |

### R4 (Required). The meta description reduces the knowledge test to actual knowledge.

- "Proof the owner **knew** of the hazard" drops "or should have known". Constructive knowledge is the half of the test most fall cases turn on (the body says so: "'Should have known' is where many fall cases are won or lost").
- The meta description is the search snippet, and it contradicts the page.
- **Authority:** Robinson; AMC (CASE LAW, PENDING TYLER, Q1).
- **Rule:** none.
- The new text is 158 characters (old: 147).

| # | Field | Before | After |
|---|---|---|---|
| R4 | `meta_description` | What drives a Georgia slip and fall case's value: proof the owner knew of the hazard, your damages, your share of fault and the two-year deadline. | What drives a Georgia slip and fall case's value: proof the owner knew or should have known of the hazard, your damages, your fault and the two-year deadline. |

### R5 (Required). FAQ 5 says any "government property" carries an earlier written notice deadline.

- The Georgia ante litem statutes reach claims against a Georgia **city** (§ 36-33-5), **county** (§ 36-11-1) or the **State** (§ 50-21-26).
  - A fall at a federal building (a post office, a VA clinic) is not covered by them.
  - The federal administrative claim deadline is two years (28 U.S.C. § 2401(b); not in the pack, not researched beyond that), which is not "much sooner".
  - FAQ 6 and the body already scope the rule to city, county and State. FAQ 5 is the one surface that does not.
- "Written" is also dropped here because § 36-11-1's text says "presented", not "written". See RC4/Q7.
- **Authority:** `GA 36-33-5`, `GA 36-11-1`, `GA 50-21-26` (signed).
- **Rule:** none. The ante litem rules key on the wrong period, not on scope.

| # | Field | Before | After |
|---|---|---|---|
| R5 | `faqs[4].answer` ("How long do I have to file…", sentence 2) | If you fell on government property, written notice is due much sooner. | If you fell on Georgia city, county or State property, a notice deadline comes due much sooner. |

---

## Recommended (each mapped to a Tyler question)

### RC1 (Recommended, Q4). The prior-traversal presumption needs its "readily visible" limit.
- Perkins, 305 Ga. App. 126: the rule imputing knowledge after a prior successful traversal "applies only to cases involving a static condition that is 'readily discernible'". In Perkins itself, summary judgment for the owner was reversed on a poorly lit, unpainted curb.
- As written, "or had safely walked over before" carries the presumption to hidden fixed defects. The writer's own reviewer note flags this.

| # | Field | Before | After |
|---|---|---|---|
| RC1 | `body_html` (H2 "What if you didn't see…", paragraph 2) | For a fixed condition you could plainly see, or had safely walked over before, Georgia courts may presume you knew about it. | If a fixed condition was readily visible, and you could plainly see it or had safely walked over it before, Georgia courts may presume you knew about it. |

### RC2 (Recommended, Q3). § 51-12-1.1 says "limited to", not "generally measured by".
- § 51-12-1.1(a)–(b): medical specials are recoverable "only as provided in this Code section" and "shall be limited to the reasonable value of medically necessary care, treatment, or services". "Generally" suggests exceptions the statute does not have.
- The sentence is otherwise accurate. Its date is right for SB 68 § 9(b) ("causes of action arising on or after" 2025-04-21) if a fall's cause of action arises on the date of the fall (Q3).
- If Tyler cuts the sentence, delete it whole; the paragraph still reads.

| # | Field | Before | After |
|---|---|---|---|
| RC2 | `body_html` | For falls on or after April 21, 2025, medical expenses are generally measured by the reasonable value of medically necessary care (O.C.G.A. § 51-12-1.1). | For falls on or after April 21, 2025, medical expenses are limited to the reasonable value of medically necessary care (O.C.G.A. § 51-12-1.1). |

### RC3 (Recommended). "Insurance sets the practical limit" is an unsourced absolute.
- Insurance often caps what is collectable in practice, but not always (excess or umbrella coverage, solvent defendants). Two words fix it. The "usually what pays" sentence in "Who pays" is already hedged and stays.

| # | Field | Before | After |
|---|---|---|---|
| RC3a | `body_html` (table, last row) | `<td>Each party pays only its own share; insurance sets the practical limit</td>` | `<td>Each party pays only its own share; insurance often sets the practical limit</td>` |
| RC3b | `body_html` (H2 "How much…", paragraph 1) | and limited in practice by the insurance behind the responsible parties | and often limited in practice by the insurance behind the responsible parties |

### RC4 (Recommended, Q7). "Written" notice and "public property".
- § 36-33-5(b) requires the claim be presented "in writing" and § 50-21-26(a)(1) requires notice "in writing". § 36-11-1 says only that county claims "must be presented within 12 months". Whether county presentment must be in writing was not researched.
- The deadlines attach to a **claim against** a city, county or the State, not to where the fall happened. A fall on public property caused by a private contractor is a different claim.

| # | Field | Before | After |
|---|---|---|---|
| RC4a | `body_html` (H2 "What if you fell on city, county or State property?", sentence 1) | A fall on public property carries a written notice deadline that comes due much sooner than the lawsuit deadline. | A claim against a Georgia city, county or the State carries a notice deadline that comes due much sooner than the lawsuit deadline. |
| RC4b | `faqs[5].answer` (sentence 1) | A written notice deadline comes due much sooner than the lawsuit deadline. | A notice deadline comes due much sooner than the lawsuit deadline. |

If Tyler confirms county presentment must be in writing, keep "written" in both places and apply only the "claim against" half of RC4a.

---

## Checked and correct (statute-text verified or case law, pending Tyler unless marked signed)

| Surface | Statement | Against |
|---|---|---|
| Body, FAQ 2 | Two-part test with "because of something the owner did or controlled", cited to Robinson (268 Ga. 735 (1997)) and AMC (285 Ga. 442 (2009)) | Robinson; AMC. Court, reporter, page and year verified |
| Body | Constructive knowledge: an employee nearby who could easily have seen and removed it, or a hazard there long enough that reasonable inspection would have found it | Shepard (uncited on the page; Q2) |
| Body, FAQ 3 | Not looking down does not by itself mean you were careless | Robinson ("as a matter of law") |
| Body, FAQ 3 | A distraction the owner created or should have anticipated | Robinson (distraction doctrine) |
| Body | Trespasser owed only the duty not to cause willful or wanton injury | § 51-3-3(b) |
| Body, KT | Georgia sets no formula for pain and suffering; the jury decides it | § 9-10-184(b) ("enlightened conscience of an impartial jury") |
| Body, KT, FAQ 4 | Reduced by share of fault; nothing at 50% or more | `GA 51-12-33` **signed** |
| Body | Each responsible party pays only its own share | `GA 51-12-33` **signed** |
| Body | Separate bar if ordinary care would have avoided the consequences | `GA 51-11-7` **signed** |
| Body, KT, FAQ 5 | Two years, cited § 9-3-33; no workers' comp context | `GA 9-3-33` **signed** |
| Body, KT, FAQ 6 | City six months (§ 36-33-5); county "presented" within twelve (§ 36-11-1); State twelve, from discovery (§ 50-21-26) | `GA 36-33-5`, `GA 36-11-1`, `GA 50-21-26` **signed** |
| Body | § 51-12-1.1 limited to falls on or after April 21, 2025 | SB 68 § 9(b) (Q3 for the accrual gloss) |

## Advisory

- **A1.** "If the case goes to trial, the jury decides what it is worth." In a bench trial the judge decides. This is consistent with § 9-10-184(b) for a jury case, and low risk. No edit proposed.
- **A2.** Robinson's burden-shifting is not described: the plaintiff's proof on the second prong is not shouldered until the defendant shows the plaintiff's negligence. "Require you to show two things" matches AMC's "must plead and prove" and is fine for a consumer page.
- **A3.** No `post_excerpt` in the draft. At publish, set the excerpt to the corrected meta description (R4) so the Article `description` carries the corrected knowledge test.
- **A4.** The closing "begin preserving the evidence of notice" and FAQ 7's fee wording are firm statements, not law; not reviewed here.
- **A5.** Linked destinations carry known errors: `/practice-areas/slip-and-fall-lawyers/` (L1, L1b, L2, L15) and `/practice-areas/premises-liability-lawyers/` (L3–L5, L4b, L14). The blog post is correctly not linked. Fix the destinations before or soon after this page publishes, because the guide sends readers to them for exactly these points.

---

## Questions for Tyler (paste-ready)

Subject: 8 quick Georgia law questions: new slip-and-fall value guide

Each item quotes the draft's sentence (as corrected where marked). Reply yes, no, or with an edit.

1. **The proof standard.** The page says (body, with cites; the summary box and FAQ say the same without cites): "To recover for a fall on a business's property, Georgia courts generally require you to show two things: that the owner knew or should have known about the hazard, and that you did not know about it despite using ordinary care, because of something the owner did or controlled (Robinson v. Kroger Co., 268 Ga. 735 (1997); American Multi-Cinema, Inc. v. Brown, 285 Ga. 442 (2009))." It also says: "Georgia courts generally hold that not looking down at the moment you fell does not, by itself, mean you were careless (Robinson)." Citations and years are checked; no citator check was run. **Yes / no / edit?**

2. **Constructive knowledge.** "Georgia courts generally treat an owner as knowing about a hazard it never actually saw where an employee was nearby and could easily have seen and removed it, or where the hazard was there long enough that a reasonable inspection would have found it." It currently has no cite. **Yes / no / edit?** Should it cite Shepard v. Winn Dixie Stores, Inc., 241 Ga. App. 746 (1999), another case, or nothing?

3. **Medical expenses after SB 68.** "For falls on or after April 21, 2025, medical expenses are generally measured by the reasonable value of medically necessary care (O.C.G.A. § 51-12-1.1)." Proposed edit, to track the statute: "…medical expenses are limited to the reasonable value of medically necessary care…". **Keep / edit as proposed / cut?** Also: is "the date of the fall" right as the date the cause of action arises for SB 68's effective-date rule?

4. **Fixed conditions and prior traversal.** The page now says: "For a fixed condition you could plainly see, or had safely walked over before, Georgia courts may presume you knew about it. A distraction the owner created or should have anticipated can change that." Proposed, to add the "readily discernible" limit from Perkins v. Val D'Aosta Co., 305 Ga. App. 126 (2010): "If a fixed condition was readily visible, and you could plainly see it or had safely walked over it before, Georgia courts may presume you knew about it." **Yes / no / edit?**

5. **How the fault rules fit together.** "Your own fault can reduce or end the claim. Your recovery is reduced by your percentage of fault, and you recover nothing if you are 50% or more at fault (O.C.G.A. § 51-12-33). A separate rule bars recovery if ordinary care would have let you avoid the consequences of the owner's negligence (O.C.G.A. § 51-11-7). In fall cases, owners usually argue that you saw, or should have seen, the hazard…" **Yes / no / edit?**

6. **Damages and caps.** As corrected: "Georgia law lists medical expenses, lost wages and lost earning capacity among economic damages, and pain, suffering, mental anguish and loss of enjoyment of life among noneconomic damages (O.C.G.A. § 9-10-184)." And: "Georgia law sets no formula for pain and suffering. If the case goes to trial, the jury decides what it is worth." **Yes / no / edit?** The page says nothing about caps. May it add "and there is no cap on these damages in an ordinary fall case against a private property owner"? **Yes / no / leave out?**

7. **Public property.** "A claim against a Georgia city requires ante litem notice within six months (O.C.G.A. § 36-33-5). A claim against a county must be presented within twelve months (O.C.G.A. § 36-11-1). Notice of a claim against the State is due within twelve months of when the loss was or should have been discovered (O.C.G.A. § 50-21-26)." **Yes / no / edit?** Three follow-ups:
   - (a) Must county presentment under § 36-11-1 be in writing? The page currently calls all three a "written notice deadline". If not, "written" comes out.
   - (b) Add "Immunity rules can also limit or bar these claims"? **Yes / no.**
   - (c) Leave the Georgia Tort Claims Act cap (§ 50-21-29) off the page? **Yes / no.**

8. **Who is owed what (entrant status).** As corrected: "An owner or occupier who invites people onto the property for a lawful purpose, as a business invites its customers, must exercise ordinary care to keep the premises and approaches safe (O.C.G.A. § 51-3-1). Someone who is not a customer or employee, has no contractual relationship with the owner, and is permitted on the property merely for their own interests is a licensee, and can recover only for willful or wanton injury (O.C.G.A. § 51-3-2). A trespasser is owed only the duty not to cause willful or wanton injury (O.C.G.A. § 51-3-3)." **Yes / no / edit?**

The page does not mention the 2025 negligent security statute (§§ 51-3-50 to -57), so the earlier question about it is withdrawn for this guide; L4 below raises it for the premises page.

---

## Live pages for Tyler

All text below was read from production read-only on 2026-10-01 (`wp eval-file`, post content and post meta). Each "current" string is exact, with curly apostrophes as stored, and was checked to occur exactly once in its field.

These are corrections to propose, not edits made. A Spanish twin exists for 3606 (ES 4879) and 3620 (ES 4893); see the ES note at the end.
- **Applying them:** each fix goes through a `bin/` remediation script with exact-match `str_replace` and `wp_slash`.
- **FAQ answers:** they are also FAQPage JSON-LD, so a fix to `_roden_faqs` fixes both.
- **The `_roden_pillar_*` fields:** they carry `{market_name}` and `{state_full}` tokens, so they likely render on location and intersection pages for each state as well. Sweep the rendered pages after a fix, not only the post.

### Blog post 1844: `/blog/valid-premises-liability-claim-georgia/` (Georgia only)

| # | Field | Current (exact) | Proposed | Authority |
|---|---|---|---|---|
| L6a | `post_content` (invitee bullet) | An invitee enters a property by implied or express permission from the property’s owner. | An invitee is someone the owner or occupier invites onto the property, expressly or impliedly, for a lawful purpose (O.C.G.A. § 51-3-1). | § 51-3-1 ("by express or implied invitation … for any lawful purpose"). "Permitted, expressly or impliedly" is the **licensee** text, § 51-3-2(a)(3) |
| L6b | `_roden_faqs[1].answer` | An invitee enters by implied or express permission. | An invitee is someone the owner invites onto the property, expressly or impliedly, for a lawful purpose (O.C.G.A. § 51-3-1). | same; this FAQ is also structured data |
| L7 | `post_content` (invitee bullet) | Friends and family members may also be invitees to a property during social visits the property owner hosts. | Friends and family on a social visit are generally treated as licensees under Georgia law, not invitees. | Case law (Wren v. Harrison, 165 Ga. App. 847 (1983), located, **not read**). **Tyler's call** |
| L13 | `post_content` (invitee bullet) | Property owners owe the highest levels of care to invitees. Owners must repair known hazards, warn of hidden dangers, and search and repair unknown hazards. | Property owners owe invitees the most protective duty: ordinary care to keep the premises and approaches safe (O.C.G.A. § 51-3-1). That includes inspecting for hazards and fixing or warning of the ones the owner knows or should know about. | § 51-3-1 ("ordinary care"). "Highest levels of care" reads as a higher standard than the statute's, and "must repair" omits warning as an alternative. **New, not in the brief** |
| L8 | `post_content` (licensee bullet) | A licensee is someone who enters a property for his or her own purposes, such as a salesperson or a repair technician. | A licensee is someone who is permitted on the property merely for his or her own interests, is not a customer or employee, and has no contractual relationship with the owner (O.C.G.A. § 51-3-2(a)). | § 51-3-2(a)(1)–(3). A repair technician usually has the contractual relation (a)(2) excludes |
| L9 | `post_content` (licensee bullet) | Property owners also owe a duty of care to licensees, as they have the property owner’s permission to enter a property. A property owner must repair known dangers on a property and warn the licensee of dangers that aren’t obvious but does not have the responsibility of searching for unknown hazards. | A property owner is liable to a licensee only for willful or wanton injury (O.C.G.A. § 51-3-2(b)), and does not have to search for unknown hazards. | § 51-3-2(b). Tyler may want a clause on known hidden dangers once a licensee's presence is known (case law; not researched) |
| L10 | `post_content` (trespasser bullet) | An exception is if the trespasser is a child, in which case the property owner owes the trespasser the same duties of care as a licensee. | Children can be treated differently: Georgia keeps the attractive nuisance doctrine, which can make an owner liable to a child trespasser for certain dangerous conditions (O.C.G.A. § 51-3-3(c)). | § 51-3-3(c) preserves attractive nuisance as of 2014-01-01. It does not give child trespassers licensee status |
| L11 | `post_content` (section 3; note a non-breaking space before "Georgia") | A defendant’s negligence must have been at least a substantial factor in the plaintiff’s injuries for a valid premises liability claim in Georgia. | A defendant’s negligence must have been a proximate cause of the plaintiff’s injuries for a valid premises liability claim in Georgia. | Georgia frames causation as proximate cause. Low priority |

The post also links § 51-3-1 at Justia's **2010** code (`law.justia.com/codes/georgia/2010/…`); point it at the 2025 code when Justia is reachable. FAQ 4's two-year answer (§ 9-3-33) is correct. The post has no key takeaways field and no Spanish twin.

### Practice area 3606: `/practice-areas/slip-and-fall-lawyers/` (GA + SC)

| # | Field | Current (exact) | Proposed | Authority |
|---|---|---|---|---|
| L1 | `_roden_faqs[2].answer` ("open and obvious"; also FAQPage JSON-LD), sentences 2–3 | In Georgia, courts apply the "equal knowledge" rule — if the plaintiff had equal knowledge of the hazard, the owner may not be liable (Robinson v. Kroger Co.). However, this defense can be overcome by showing the victim was reasonably distracted, the hazard was not truly obvious, or the owner still had a duty to remedy a known danger despite its visibility. | In Georgia, courts apply the "equal knowledge" rule — if the plaintiff knew of the hazard, or should have known of it by using ordinary care, the owner may not be liable (Robinson v. Kroger Co., 268 Ga. 735 (1997)). However, not looking down at the moment of the fall does not by itself make the victim careless, and this defense can be overcome by showing the victim was reasonably distracted or the hazard was not readily visible. | Robinson (second prong; failure to look not negligence as a matter of law; distraction); Perkins ("readily discernible"). "Duty to remedy a known danger despite its visibility" was not found in any case read; dropped |
| L2 | `_roden_why_hire` (paragraph 2, sentence 1) | Georgia follows the "equal knowledge" rule — if you knew about the hazard or it was so obvious that you should have seen it, your claim may be reduced or barred. | Georgia follows the "equal knowledge" rule — if you knew about the hazard or should have seen it by using ordinary care, your claim may be barred, and any share of fault assigned to you reduces what you recover (O.C.G.A. § 51-12-33). | Robinson (bar); `GA 51-12-33` signed (reduction). Separates the two mechanisms. Low priority |
| L1b | `_roden_pillar_negligence_intro` (GA block) | In Georgia, an invitee must prove the owner had **actual or constructive knowledge** of the hazard and that the plaintiff lacked equal knowledge — the controlling test from *Robinson v. Kroger Co.*, 268 Ga. 735 (1997). | In Georgia, an invitee must prove the owner had **actual or constructive knowledge** of the hazard and that the plaintiff, despite exercising ordinary care, lacked knowledge of it because of the owner's actions or conditions under the owner's control — the test from *Robinson v. Kroger Co.*, 268 Ga. 735 (1997). | Robinson; AMC. Same prong-two omission as R1. **New, not in the brief**; likely renders on GA location pages |
| L15 | `_roden_pillar_compensation_intro` (opening clause) | No special statutory caps apply to slip-and-fall recoveries in {state_full}; | No special statutory cap applies to an ordinary slip-and-fall claim against a private owner in {state_full}, though claims against government entities can be limited; | GA: `GA 50-21-29` pending (State claims). SC: Tort Claims Act caps (SC pack; SC reviewer). Ties to Q6. **New** |

Also on 3606, for the owner rather than Tyler:
- **FAQ 8:** "Most slip and fall cases settle within 8 to 18 months" is an unsourced figure about outcomes.
- **Pillar compensation intro:** its parenthetical "(recovery barred at {comp_fault_threshold} fault under {sol_cite}'s sister apportionment statute)" renders on SC pages as an SC statute that does not exist for the 51% bar (SC's bar is case law, Nelson). Drop "under {sol_cite}'s sister apportionment statute".
- **Correct on this page:** deadlines, ante litem 6/12/12, the KT's "two fault defenses" (50% bar plus § 51-11-7), and the FAQ 7 government-property answer.

### Practice area 3620: `/practice-areas/premises-liability-lawyers/` (GA + SC)

| # | Field | Current (exact) | Proposed | Authority |
|---|---|---|---|---|
| L3 | `_roden_faqs[1].answer` ("What must I prove"; also JSON-LD), whole answer | Under Georgia law (O.C.G.A. § 51-3-1), you must prove: (1) the property owner or occupier had actual or constructive knowledge of the hazardous condition; (2) you did not have equal knowledge of the hazard; and (3) the owner failed to exercise ordinary care to either correct the hazard or warn you about it. For non-static conditions (spills, debris, temporary hazards), you must show the owner had reasonable time to discover and address the hazard before your injury occurred. | Georgia law requires owners and occupiers to exercise ordinary care to keep the premises and approaches safe for invitees (O.C.G.A. § 51-3-1). To recover for an injury from a hazard, Georgia courts generally require you to prove: (1) the owner or occupier had actual or constructive knowledge of the hazard; and (2) you lacked knowledge of it despite exercising ordinary care, because of the owner's actions or conditions under the owner's control (Robinson v. Kroger Co., 268 Ga. 735 (1997); American Multi-Cinema, Inc. v. Brown, 285 Ga. 442 (2009)). For spills, debris and other temporary hazards, constructive knowledge can be shown by an employee who was nearby and could easily have seen and removed the hazard, or by a hazard that was there long enough that a reasonable inspection would have found it. | § 51-3-1 states the duty only; the test is Robinson/AMC. "Must show reasonable time" is too narrow: Shepard gives two routes and says the plaintiff "need not show how long the hazard had been present unless the owner has demonstrated its inspection procedures" |
| L4 | `_roden_faqs[6].answer` ("What is negligent security?"; also JSON-LD), sentence 2 | To establish negligent security, you typically must show that the property had a history of similar criminal activity, the owner knew or should have known of the risk, and the owner failed to implement reasonable security measures such as lighting, cameras, security guards, or access control. | To establish negligent security, you typically must show that the owner knew or should have known of the risk of a crime like the one that happened and failed to take reasonable security measures such as lighting, cameras, security guards, or access control. In Georgia, injuries on or after April 21, 2025 are governed by a 2025 statute (O.C.G.A. §§ 51-3-50 to 51-3-57) that sets stricter, specific requirements, including limits on which prior crimes count. | SB 68 § 6 (new §§ 51-3-50 to -57; prior incidents on the premises, adjoining, or within 500 yards, with actual knowledge; particularized warning; applies to causes of action arising on or after 2025-04-21). **Spanish twin ES 4893 `_roden_faqs[7]` carries the same pre-2025 test** |
| L4b | `_roden_pillar_negligence_intro` (GA block) | in Georgia, *CVS Pharmacy, Inc. v. Carmichael*, 316 Ga. 718 (2023), confirmed the totality-of-the-circumstances test for foreseeability. | in Georgia, injuries on or after April 21, 2025 are governed by the negligent security statute (O.C.G.A. §§ 51-3-50 to 51-3-57), and earlier injuries by the case law, including *CVS Pharmacy, Inc. v. Carmichael*, 316 Ga. 718 (2023). | SB 68 § 9(b). The Carmichael citation was **not verified** in this pass; Tyler confirms. **New** |
| L5 | `_roden_faqs[4].answer` (grocery/retail), sentence 1 | Retail stores owe the highest duty of care to customers (invitees). | Retail stores owe customers (invitees) the most protective duty owed to any visitor; in Georgia, that is ordinary care to keep the premises and approaches safe (O.C.G.A. § 51-3-1). | § 51-3-1. "Highest duty of care" reads as extraordinary diligence. Low priority |
| L14 | `_roden_pillar_compensation_intro` (sentence 1) | Standard tort damages apply with no special caps in either {state_full} or its neighboring state. | Standard tort damages apply, with no special cap in an ordinary claim against a private owner in either {state_full} or its neighboring state; claims against government entities, and some claims against charities, can be limited. | **The page contradicts itself:** its own key takeaways say a South Carolina charitable-organization claim "is limited to actual damages within the Tort Claims Act caps (S.C. Code § 33-56-180)". GA side ties to Q6 and `GA 50-21-29` (pending). **New** |

Also on 3620:
- **Correct:** the KT, FAQ 3 and FAQ 7 (50% bar; two years), and the pillar's "Georgia codifies these duties at O.C.G.A. §§ 51-3-1 through 51-3-3".
- **For the owner:**
  - FAQ 3's "Many commercial properties overwrite security camera footage within 30 to 90 days" is unsourced, and 3606 says "within days".
  - The pillar compensation intro's "the assailant … must be included on the verdict form" overstates § 51-12-33(d): nonparty fault requires notice from the defendant. Tyler, low priority.

### Spanish twins
- **ES 4893** (`/es/practice-areas/premises-liability-lawyers/`) FAQ 7 repeats the pre-2025 negligent-security test (L4). Fix it in the same pass.
- **ES 4893** FAQ 0 and FAQ 5 cite § 51-3-1 for the duty only, which is correct.
- **ES 4879** (`/es/practice-areas/slip-and-fall-lawyers/`) carries no L1/L3-class sentence in its FAQs or `why_hire`.
- **Both ES pillar fields are empty.** If the template falls back to the English pillars on `/es/` pages, L1b, L4b, L14 and L15 render there too. Check a rendered `/es/` page after the fix.

### Questions for Tyler on the live pages (append to the email)

9. **Blog post on premises liability claims.** Approve L6a/L6b (invitee = invitation for a lawful purpose), L8 (licensee per § 51-3-2(a)), L9 (licensee: willful or wanton only), L10 (child trespassers: attractive nuisance, not licensee status) and L13 (invitees: ordinary care)? **Yes / no / edit each.** For L7: are social guests in a home licensees under Georgia law? **Yes / no.** And for L9, do you want a clause about known hidden dangers once a licensee's presence is known?
10. **Slip-and-fall and premises pages.** Approve the replacement "open and obvious" answer (L1), the "What must I prove" answer (L3), the two pillar sentences (L1b, L4b), and the negligent-security update (L4)? **Yes / no / edit each.** Is *CVS Pharmacy, Inc. v. Carmichael*, 316 Ga. 718 (2023) correctly cited?

---

## Counts by rule

| Rule | Findings |
|---|---|
| (none; found by reading) | 5 required edits on the draft: R1–R5 |
| (none; found by reading) | 4 recommended items (7 strings): RC1, RC2, RC3a–b, RC4a–b |
| (none; found by reading) | 17 live-page items: blog 1844 ×8, 3606 ×4, 3620 ×5 (plus owner-only notes) |
| Any pack rule | 0 findings on the draft, before or after correction; 0 on the live strings |

## False positives

None. No rule fired on any published or corrected string. The one firing in this pass (`foreign-SC` on a first draft of the L14 replacement) was a true positive on proposed text, and the proposal was changed.

## Engine blind spots (pack PR candidates; fixtures first, never a page edit)

1. **`ga-licensee-defined-as-non-customer` (error).**
   - Pattern: `licensee` within a sentence containing "(rather than|not) (as )?a customer" or "(repair technician|repairman|contractor|delivery)", or a licensee "owed/must repair".
   - Controls: R2-after, L8-after, L9-after.
2. **`ga-invitee-permission` (error).** Pattern: `invitee … (by|with) (implied or express|express or implied) permission`. Control: L6a-after.
3. **`ga-social-guest-invitee` (warning).** Pattern: `(friends|family|social (guest|visit)) … invitee`. Needs Tyler's L7 ruling first.
4. **`ga-premises-test-cited-to-51-3-1` (warning).** Pattern: "must prove" with "constructive knowledge" within the same sentence as `51-3-1` and no "Robinson|Multi-Cinema". Control: L3-after.
5. **`ga-medical-specials-full-bills` (error, post-2025 wording).** Pattern: "full (amount of your )?medical bills|what the hospital charged" in a GA context. Guards D2 on future drafts.
6. **`ga-negligent-security-pre-2025-only` (warning).** Pattern: "negligent security" with "history of similar|prior similar" and no `51-3-5\d|2025` in the surface.
7. **Pending authorities to propose for signature:** `GA 51-3-1`, `GA 51-3-2`, `GA 51-3-3`, `GA 51-12-1.1`, `GA 9-10-184` and the case-law entries (Robinson, AMC). Each needs `evidence` (Justia 2025 when it is reachable; the FindLaw and SB 68 URLs in the brief meanwhile) and `verifiedBy: null`. They go through a pack PR by the pack's signer. **This sweep did not touch the pack.**

## Before publish

1. Apply R1–R5 to the draft JSON only, plus RC1–RC4 if Tyler says yes. Then re-run:
   - `node scripts/facts/sweep-claims.mjs --client roden --fixtures <repo>/data/facts/ga-slip-and-fall-remediation-replay-2026-10-01.json --states GA` (expect 95/95);
   - the writer's fixture `ga-slip-and-fall-replay-2026-10-01.json`. After the edits, its whole-surface entries need refreshing to the new strings;
   - `verify-faq-drafts.mjs --client roden` on the corrected FAQs against the corrected body (expect 7 answers, 0 failures).
2. Send Tyler Q1–Q10. Apply his edits, set the review date only after he has read the page, and keep the "Reviewed by" line until then.
3. Set `post_excerpt` to the corrected meta description (A3).
4. After publish, render the page:
   - diff the FAQPage JSON-LD against the visible FAQs;
   - confirm the KT box and meta description match the source;
   - run `bin/check-unslashed-post-writes.php` on prod.
5. Before linking more pages to 3606 and 3620, fix the L items on them, in English and in the Spanish twin where noted.
