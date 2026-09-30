# Georgia statute currency check, through the 2026 session (2026-09-30)

Status: complete (2026-09-30).

Scope: the three Georgia resource drafts in `data/practice-area-drafts/2026-09/ga-resources/`
(car seats, uninsured motorist, wrongful death settlement value). Earlier work rested on 2024
reproductions of the Code (FindLaw "current as of March 28, 2024"; Justia "2024 Code"). This file
checks for any 2025 or 2026 act that changes what the guides say.

This is research, not approval. Eric Roden's review is still the approval for Georgia wording on
Roden pages. Nothing here edits the drafts, the law pack, the theme or production.

## 1. SB 68 (2025): Georgia's tort reform act, read from the signed text

- **Source:** the "AS PASSED" text, LC 49 2362S, 19 pages:
  `https://www.legis.ga.gov/api/legislation/document/20252026/236944`. Fetched 2026-09-30 (HTTP 200)
  and read in full with `pdftotext`.
  - `pdftotext` flattens strikethrough and underline. Where the bill shows deleted and inserted words
    together, the struck words are identified below from context and flagged.
- **Status:** `https://www.legis.ga.gov/legislation/69756`, read through r.jina.ai on 2026-09-30.
  The Status History shows "04/21/2025 Effective Date", "04/21/2025 Act 9", and "04/21/2025 Senate Date
  Signed by Governor". **SB 68 is Act 9 of 2025, effective 2025-04-21.**
- **Applicability, Section 9(b), verbatim:** "Sections 6 and 7 of this Act shall apply only with
  respect to causes of action arising on or after the effective date of this Act, and any prior
  causes of action shall be governed by prior law. It is the intention of the General Assembly that
  all other provisions of this Act shall apply to causes of action pending on the effective date of
  this Act, unless such application would be unconstitutional."

### SB 68: every section, what it amends or creates, and when it applies

"Pending" means the section is intended to reach causes of action pending on 2025-04-21 (Section 9(b)).
"New only" means causes of action arising on or after 2025-04-21.

| SB 68 § | O.C.G.A. | Amends / creates | Subject (bill text) | Applies to | Bears on these guides? |
|---|---|---|---|---|---|
| 1 | § 9-10-184 | rewrites | Anchoring. Defines economic and noneconomic damages; noneconomic damages include "in wrongful death cases, the nonpecuniary elements of the full value of life". (b): counsel "shall not argue the worth or monetary value of noneconomic damages" and shall not mention "any specific amount or range of amounts", except under (c). (c)(1): may argue a value "only after the close of evidence", in the party's first damages argument, "rationally related to the evidence". (c)(2): the concluding argument cannot state a different value than the opening. | Pending | **WD guide, indirectly.** It classifies the nonpecuniary part of full value as noneconomic damages. It is a trial-argument rule, not a change to what is recoverable. |
| 2 | § 9-11-12(a), (e), (j) | amends | Answer timing after a motion. (j): discovery is stayed for 90 days after a motion to dismiss, or until the ruling. | Pending | No |
| 3 | § 9-11-41(a) | amends | Voluntary dismissal without a court order: the notice must be filed by "the sixtieth day following the date the opposing party serves an answer" (replacing "before the first witness is sworn"; struck text inferred from the bill layout). A dismissal is an adjudication on the merits if the plaintiff previously dismissed a federal or state action on the same claim. | Pending | No |
| 4 | new § 9-15-16 | creates | No double recovery of attorney's fees, costs or litigation expenses; a contingency agreement is not admissible to prove the fee is reasonable. | Pending | No |
| 5 | § 40-8-76.1(d) | rewrites | **Seat-belt evidence.** The text is quoted in full under § 40-8-76.1 below. | **Superseded by SB 69 § 4**: applies only to causes of action **commenced on or after 2025-04-21** | **Car-seat guide** (seat-belt paragraph and FAQ 7) |
| 6 | new §§ 51-3-50 to 51-3-57 (Article 5) | creates | Negligent security cause of action, with definitions and apportionment under § 51-12-33. | New only | No. None of the three guides discusses premises. |
| 7 | new § 51-12-1.1 | creates | **Medical special damages.** (a) "In any civil action to recover damages resulting from injury or death to a person, special damages for medical and healthcare expenses shall be recoverable only as provided in this Code section." (b) They are "limited to the reasonable value of medically necessary care, treatment, or services", as determined by the trier of fact. (c) If the plaintiff has health insurance, the evidence includes "both the amounts charged … and the amounts actually necessary to satisfy such charges", whether or not the insurance was used. (d) Letter-of-protection arrangements become discoverable. (e) Abrogates the collateral source rule "to the extent necessary". | New only | **WD guide**, through the estate's medical-expense claim under § 51-4-5(b) (WD-2), for deaths from causes of action arising on or after 2025-04-21 |
| 8 | new § 51-12-15 | creates | Bifurcation. Any party may elect by written demand: fault first, then damages. The court may reject the election only for a sexual-offense victim or where "the amount in controversy is less than $150,000.00". | Pending | No. None of the guides describes trial structure. |
| 9 | none | none | Effective date and applicability (quoted above) | n/a | n/a |

**SB 68 does not amend any section in this check's scope other than § 40-8-76.1.** The section list
comes from the bill's own SECTION headers (1 to 10). §§ 40-8-76, 33-7-11, 51-4-2, 51-4-4, 51-4-5,
51-12-33, 9-3-33 and the ante litem sections are cross-referenced at most; none is amended. SB 68 names
§ 51-12-33 only inside new §§ 51-3-56 and 51-12-15, and only to direct apportionment under it.

## 2. SB 69 (2025): the companion act, which changes the seat-belt rule's reach

- **Status:** `https://www.legis.ga.gov/legislation/69757` (r.jina.ai, 2026-09-30). It shows "04/21/2025
  Act 10", "04/21/2025 Senate Date Signed by Governor", and "01/01/2026 Effective Date".
- **Text:** the "AS PASSED" version (SB 69/AP):
  `https://www.legis.ga.gov/api/legislation/document/20252026/238603`, fetched 2026-09-30 (HTTP 200).
  - The link was found through an archived LegiScan bill page:
    `http://web.archive.org/web/20251128170809/https://legiscan.com/GA/bill/SB69/2025`.
  - Senate Floor Amendment 1 (AM 49 0263, "ADOPTED", `…/document/20252026/238083`) is what added the
    Title 40 seat-belt section to the House substitute.
- **Sections:**
  - § 1: short title, "Georgia Courts Access and Consumer Protection Act". Source: Justia 2025 editor's note.
  - § 2: new Chapter 10 of Title 7, "Litigation Financing", §§ 7-10-1 to 7-10-11. Effective 2026-01-01.
    - Justia's 2025 page for § 7-10-1 shows a later amendment: "Ga. L. 2026, p. 548, § 23/HB 945,
      effective July 1, 2026".
  - § 3: § 9-11-26(b)(2.1). The existence and terms of a litigation financing agreement are
    discoverable. Effective on approval, for actions commenced on or after it.
  - **§ 4: § 40-8-76.1(d), revised in the same words as SB 68 § 5.**
  - **§ 5(c):** "(1) Section 4 of this Act shall become effective upon its approval by the Governor …
    (2) Section 4 of this Act shall not apply to causes of action pending on the effective date of this
    Act. Section 4 of this Act shall apply only to causes of action commenced on or after the effective
    date of this Act, and any causes of action commenced prior to the effective date of this Act shall
    be governed by prior law."
- **Which applicability rule governs.** The official Code's editor's note, reproduced on Justia's 2025
  § 40-8-76.1 page, says:
  > "Ga. L. 2025, p. 31, SB 69 was signed last, and, therefore, the applicability language relating to
  > pending causes of action shall be governed by the applicability provisions contained in Ga. L. 2025,
  > p. 31, SB 69."
- **Result:** the new seat-belt evidence rule reaches only lawsuits **commenced on or after
  2025-04-21**. Cases already pending on that date stay under the old (d), under which non-use "shall
  not be considered evidence of negligence or causation".
  - This **contradicts** the Roden SB 68 brief (`docs/briefs/2026-08-07-georgia-tort-reform-sb68.md`
    §4), which puts SB 68 § 5 among the provisions that apply to pending cases. It also bears on any
    live page that says the seat-belt change applies to pending cases.
  - **This is outside this task's three drafts.** Flag it for the owner and the pack signer.

## 3. Method for the per-section check

- **Primary route: Justia's current Georgia Code pages** (`law.justia.com/codes/georgia/2025/…`), read
  through `r.jina.ai` on 2026-09-30. Each page carries the official history line, which lists every act
  that amended the section, and the annotated Code's "Amendments" notes.
- **Is Justia current through the 2026 session? Evidence it is:**
  - It carries 2025 acts: § 40-8-76.1 (SB 68, SB 69), § 9-10-184 (SB 68), new § 51-12-1.1 (SB 68),
    § 51-4-2 (HB 327 of 2025), and new § 33-7-16 (SB 121 of 2025; the Chapter 7 index reads "§§ 33-7-1
    — 33-7-16").
  - It carries at least one 2026 act: § 7-10-1 shows "Ga. L. 2026, p. 548, § 23/HB 945, effective July 1,
    2026".
  - So a history line that ends before 2025 on this site is evidence that no 2025 or 2026 act amended the
    section. **It is not proof.** A 2026 act with a delayed effective date may not be merged yet (see
    HB 1344 below).
- **Second route: the General Assembly's full-text search for the 2025–2026 session**
  (`https://www.legis.ga.gov/search?k=<term>&s=1033`, rendered through r.jina.ai's browser engine).
  - Hits were narrowed to bills that were signed.
  - Signed bills that could touch these guides were opened and read.
  - Searching a bare Code number such as "51-4-2" tokenizes loosely and returns noise, so topic phrases
    were searched as well.
- Where a quoted history line ends in an old act, that is the text **as current on Justia on
  2026-09-30**.

## 4. Section by section

Legend: **CONFIRMED CURRENT** means the history line shows no 2025/2026 act, the operative text matches
what the drafts rely on, and the 2025–2026 bill search found no enacted amendment. **CHANGED** means an
act in 2025 or 2026 amended it. **COULD NOT CONFIRM** means what it says.

### Car seats

| Section | Latest amendment (history line, Justia 2025) | Draft text vs current text | Status |
|---|---|---|---|
| **§ 40-8-76** | "Ga. L. 2011, p. 253, § 1/SB 88" (last entry). No 2025 or 2026 act. | Matches. (b)(1): "under eight years of age"; (b)(1)(A) 40 lb lap belt (i)/(ii) including "Not including the driver's seat"; (b)(1)(B) rear seat, and front seat if none is appropriate or all "are occupied by other children" (no age qualifier, as CS-1 corrected); (b)(1)(C) installed and used "in accordance with the manufacturer's directions"; (b)(1)(D) physician's written statement and "over 4 feet and 9 inches"; (b)(2) "not more than $50.00" first and "not more than $100.00" second or later, "No court shall impose any additional fees or surcharges"; (c) "shall not constitute negligence per se nor contributory negligence per se" and not "the basis for cancellation of coverage or increase in insurance rates". Source: `https://law.justia.com/codes/georgia/2025/title-40/chapter-8/article-1/part-4/section-40-8-76/` | **CONFIRMED CURRENT** |
| **§ 40-8-76.1** | "Ga. L. 2025, p. 19, § 5/SB 68, effective April 21, 2025; Ga. L. 2025, p. 31, § 4/SB 69, effective April 21, 2025." | See below. The draft's substance is right, but it omits the SB 69 applicability limit. | **CHANGED (2025)**. The draft reflects it, but only in part. |

§ 40-8-76.1(d), current text (Justia 2025, `…/part-4/section-40-8-76-1/`):
> "(1) The failure of an occupant of a motor vehicle to wear a seat safety belt in any seat of a motor
> vehicle which has a seat safety belt or belts may be considered in any civil action as evidence
> admissible on the issues of negligence, comparative negligence, causation, assumption of risk, or
> apportionment of fault or for any other purpose and may be evidence used to diminish any recovery for
> damages arising out of the ownership, maintenance, occupancy, or operation of a motor vehicle; provided,
> however, that this paragraph shall not prevent a court from determining the admissibility of such
> evidence pursuant to Code Section 24-4-403 or any other statutory or common law rule of evidence.
> (2) … shall not be any basis for a cancellation of insurance coverage or an increase in insurance rate."

- **Draft (body and FAQ 7):** "Following SB 68, approved in April 2025, O.C.G.A. § 40-8-76.1(d) permits
  seat belt non-use to be admitted on negligence, comparative negligence, causation, assumption of risk
  and apportionment, and it may diminish recovery. There is no percentage cap on that reduction."
- **Accurate as far as it goes.** The (d)(1) list matches, "may diminish" matches, and there is no cap
  in the text.
- **What it omits:**
  - The rule applies only to lawsuits **commenced on or after 2025-04-21** (SB 69 § 5(c)(2), which
    governs per the Code's editor's note).
  - The court keeps its power to exclude the evidence under § 24-4-403.
- **Not changed:** (e)(3) (minors eight and older must be belted; driver fined up to $25) and (e)(2)
  (up to $15).

### Uninsured motorist coverage

| Section | Latest amendment | Draft text vs current text | Status |
|---|---|---|---|
| **§ 33-7-11** | "Ga. L. 2019, p. 337, § 1-38/SB 132; Ga. L. 2021, p. 431, § 2/HB 714; Ga. L. 2022, p. 352, § 33/HB 1428." No 2025 or 2026 act in the history. | (a)(1): no policy issued "unless it contains an endorsement or provisions undertaking to pay the insured damages … sustained from the owner or operator of an uninsured motor vehicle". (a)(1)(A): not less than $25,000 / $50,000 / $25,000. **(a)(1)(B): UM limits equal the policy's liability limits unless "the insured may affirmatively choose uninsured motorist limits in an amount less than the limits of liability"**. (a)(3): not applicable "where any insured named in the policy shall reject the coverage in writing". (b)(1)(D)(ii)(I): **added-on (excess) is the default**; (II) the insured "may reject the coverage … and select in writing" reduced-by. (b)(2): "actual physical contact" or corroboration "by an eyewitness to the occurrence other than the claimant". (j): bad-faith penalty "not more than 25 percent of the recovery or $25,000.00, whichever is greater". All match what UM-1, UM-3 and UM-4 rely on. Source: `https://law.justia.com/codes/georgia/2025/title-33/chapter-7/section-33-7-11/` | **CONFIRMED CURRENT** through the 2026 session. HB 1344 (2026), whose caption names "uninsured motorists", was read and does not amend § 33-7-11 (see § 5). |
| **§ 33-7-16 (new, 2025)** | "SB 121, Act 287 (2025), effective 2025-05-14", from the SB 121 AS PASSED text, `https://www.legis.ga.gov/api/legislation/document/20252026/238598`, and status `https://www.legis.ga.gov/legislation/70041` | A driver **convicted of DUI** must carry at least $50,000 / $100,000 / $50,000 in liability coverage; after a second conviction, $100,000 / $300,000 / $100,000; for three years. (d): "in lieu of the minimum motor vehicle liability insurance coverage required under Code Section 33-7-11." Applies to convictions on or after 2025-05-14. | **NEW (2025).** Not mentioned in the UM draft. Advisory; see § 6. |
| **§ 33-34-4** | "Code 1981, § 33-34-4, enacted by Ga. L. 1991, p. 1608, § 1.12." Never amended. | The owner must carry liability insurance "equivalent to that required as evidence of security … under Chapter 9 of Title 40". Source: `…/2025/title-33/chapter-34/section-33-34-4/` | **CONFIRMED CURRENT** |
| **§ 40-9-37** | "Ga. L. 2000, p. 1516, § 3" (last entry) | (a): policy limits "not less than the amounts specified in subparagraph (a)(1)(A) of Code Section 33-7-11." Source: `…/2025/title-40/chapter-9/article-2/section-40-9-37/` | **CONFIRMED CURRENT** |
| **§ 33-24-41.1** | "Ga. L. 2019, p. 386, § 49/SB 133; Ga. L. 2020, p. 493, § 33/SB 429" | Not stated in the drafts (UM-A2 left it out). Source: `…/2025/title-33/chapter-24/article-1/section-33-24-41-1/` | **CONFIRMED CURRENT** (history only; no text relied on) |

**The liability minimum chain, which affects email question 7.** § 33-34-4 requires the insurance, and
§ 40-9-37(a) sets its limits by pointing to "the amounts specified in subparagraph (a)(1)(A) of Code
Section 33-7-11". The 2025 General Assembly itself called it "the minimum motor vehicle liability
insurance coverage required under Code Section 33-7-11" (§ 33-7-16(d)). **So "$25,000 / $50,000 /
$25,000 … under O.C.G.A. § 33-7-11" is a defensible short cite, not an error.** The most precise form is
"O.C.G.A. §§ 33-34-4 and 40-9-37, which adopt the amounts in § 33-7-11(a)(1)(A)". This softens UM-2:
the question to ask is which cite to prefer, not how to fix a wrong one.

### Wrongful death

| Section | Latest amendment | Draft text vs current text | Status |
|---|---|---|---|
| **§ 51-4-2** | "Ga. L. 2022, p. 207, § 7/HB 620; Ga. L. 2024, p. 1052, § 6(37)/SB 448, effective July 1, 2024; **Ga. L. 2025, p. 806, § 32/HB 327, effective July 1, 2025**." | The amendment note reads: "The 2025 amendment, effective July 1, 2025, added ', provided that such child born out of wedlock had rights of inheritance from or through the child's deceased parent under Code Section 53-2-3' at the end of subsection (f)." (a) "full value of the life of the decedent, as shown by the evidence", and (d)(2) the spouse's "no less than one-third", are unchanged. Source: `…/2025/title-51/chapter-4/section-51-4-2/` | **CHANGED (2025), in (f) only.** The drafts say nothing about who may recover or about children born out of wedlock, so no draft text is affected. The 2024 FindLaw text the earlier research read is stale on (f). |
| **§ 51-4-4** | "Ga. L. 2022, p. 669, § 1/SB 543." | Not stated in the drafts | **CONFIRMED CURRENT** |
| **§ 51-4-5** | "Ga. L. 1985, p. 1253, § 3" (last entry) | (b): "the personal representative of the deceased person shall be entitled to recover for the funeral, medical, and other necessary expenses resulting from the injury and death of the deceased person." Unchanged. **However,** for causes of action arising on or after 2025-04-21, the *medical* part is now measured under new § 51-12-1.1 (SB 68 § 7): "reasonable value of medically necessary care", with evidence of both the amounts charged and the amounts actually paid. Source: `…/2025/title-51/chapter-4/section-51-4-5/` | **CONFIRMED CURRENT** (the text). Affected by § 51-12-1.1 for new claims. |
| **§ 9-2-41** | "Ga. L. 1952, p. 224, § 1" (last entry) | Survival: a cause of action "shall survive to the personal representative of the deceased plaintiff". Not stated in the drafts. Source: `…/2025/title-9/chapter-2/article-3/section-9-2-41/` | **CONFIRMED CURRENT** |
| **§ 9-10-184** (new text, SB 68 § 1) | "Ga. L. 1960, p. 174, § 1; Ga. L. 2025, p. 19, § 1/SB 68, effective April 21, 2025." | Anchoring limits. See § 1. The WD draft does not discuss argument at trial. | **CHANGED (2025)**. No draft text affected. |
| **§ 51-12-1.1** (new, SB 68 § 7) | "enacted by Ga. L. 2025, p. 19, § 7/SB 68, effective April 21, 2025." Causes of action arising on or after that date. | See § 1. | **NEW (2025)**. It bears on WD-2's estate medical-expense sentence (see § 6). |

### Fault and deadlines

| Section | Latest amendment | Draft text vs current text | Status |
|---|---|---|---|
| **§ 51-12-33** | "Ga. L. 2005, p. 1, § 12/SB 3; Ga. L. 2022, p. 802, § 1/HB 961." | (g): "the plaintiff shall not be entitled to receive any damages if the plaintiff is 50 percent or more responsible". (a): reduced by the plaintiff's percentage of fault. SB 68 only cross-references it. Source: `…/2025/title-51/chapter-12/article-2/section-51-12-33/` | **CONFIRMED CURRENT** |
| **§ 51-11-7** | Last entry "Code 1933, § 105-603". No act since the 1933 codification. | "If the plaintiff by ordinary care could have avoided the consequences to himself caused by the defendant's negligence, he is not entitled to recover." Source: `…/2025/title-51/chapter-11/article-1/section-51-11-7/` | **CONFIRMED CURRENT** |
| **§ 9-3-33** | "Ga. L. 1964, p. 763, § 1; Ga. L. 2015, p. 675, § 2-1/SB 8." | "Except as otherwise provided in this article, actions for injuries to the person shall be brought within two years after the right of action accrues…". Loss of consortium: four years. Source: `…/2025/title-9/chapter-3/article-2/section-9-3-33/` | **CONFIRMED CURRENT** |
| **§ 9-3-90** | "Ga. L. 1984, p. 580, § 1; Ga. L. 2015, p. 385, § 4-15/HB 252; Ga. L. 2015, p. 675, § 2-3/SB 8; Ga. L. 2015, p. 689, § 3/HB 17." | (b): "Except as otherwise provided in Code Section 9-3-33.1, individuals who are less than 18 years of age when a cause of action accrues shall be entitled to the same time after he or she reaches the age of 18 years to bring an action as is prescribed for other persons." Source: `…/2025/title-9/chapter-3/article-5/section-9-3-90/` | **CONFIRMED CURRENT** |
| **§ 9-3-99** | "Ga. L. 2005, p. 88, § 2/HB 172; Ga. L. 2015, p. 675, § 2-4/SB 8; Ga. L. 2015, p. 689, § 4/HB 17." | Not stated in the drafts | **CONFIRMED CURRENT** (history) |

### Ante litem notice

| Section | Latest amendment | Text | Status |
|---|---|---|---|
| **§ 36-33-5** (city) | "Ga. L. 1956, p. 183, § 1; Ga. L. 2014, p. 125, § 1/HB 135." | (b): "Within six months of the happening of the event upon which a claim against a municipal corporation is predicated…". Source: `…/2025/title-36/provisions-applicable-to-municipal-corporations-only/chapter-33/section-36-33-5/` | **CONFIRMED CURRENT** |
| **§ 36-11-1** (county) | Last entry "Code 1933, § 23-1602". No act since. | "All claims against counties must be presented within 12 months after they accrue or become payable…". Source: `…/2025/title-36/provisions-applicable-to-counties-only/chapter-11/section-36-11-1/` | **CONFIRMED CURRENT** |
| **§ 50-21-26** (State) | "Ga. L. 2000, p. 1589, § 3" (last entry) | (a)(1): notice "in writing within 12 months of the date the loss was discovered or should have been discovered". Source: `…/2025/title-50/chapter-21/article-2/section-50-21-26/` | **CONFIRMED CURRENT** |

### Hit and run

| Section | Latest amendment | Text | Status |
|---|---|---|---|
| **§ 40-6-270** | "Ga. L. 1991, p. 1608, § 2.1; Ga. L. 2008, p. 1164, § 1/SB 529." | (a): the driver "shall immediately stop … and forthwith return to the scene … and shall" give information and render aid. Source: `…/2025/title-40/chapter-6/article-12/section-40-6-270/` | **CONFIRMED CURRENT** |

## 5. The 2026 regular session: acts checked

- **HB 1344 (2026), "Georgia Insurance Affordability and Claims Integrity Act". Act 635, signed
  2026-05-12, effective 2027-01-01.**
  - Status: `https://www.legis.ga.gov/legislation/73286`.
  - Text: "HB 1344/AP", "AS PASSED HOUSE AND SENATE",
    `https://www.legis.ga.gov/api/legislation/document/20252026/249047`, fetched 2026-09-30. The link was
    found through billsponsor.com, used only as a lead.
  - Its caption lists "uninsured motorists", so it was read section by section.
  - **It does not amend § 33-7-11, § 33-34-4 or § 40-9-37.** The AP text contains no "33-7-11". "Uninsured"
    appears only in the purpose clause.
  - Motor-vehicle pieces:
    - § 10-1 revises § 40-2-137(e): notice of insurance coverage and lapses (registration enforcement).
    - § 8-1 repeals § 33-24-53: solicitation or sale of accident information.
    - § 12-1 adds § 33-7-6(g): rental home marketplace guarantees.
  - § 16-1(a): "This Act shall become effective on January 1, 2027, and shall apply to all applicable
    policies … issued … or renewed … on or after such date."
  - Justia's § 33-7-6 is already split into "[Effective until January 1, 2027]" and a later version. That
    is consistent with HB 1344 § 12-1 and shows Justia merges delayed-effective 2026 acts. § 33-7-11
    carries no such split.
  - **No change to anything the UM guide says.**
- **HB 945 (2026):** amends § 7-10-1 (litigation financing definitions), effective 2026-07-01, per
  Justia's history. Not relevant to the guides. Recorded because it shows Justia carries 2026 acts.
- **HB 1160 (2026), "Civil practice; tolling of limitations; provide for surviving relatives in wrongful
  death actions".**
  - Status: `https://www.legis.ga.gov/legislation/72732`. The last action is "02/19/2026 House Committee
    Favorably Reported By Substitute", with no floor vote.
  - **Not enacted.** 2026 was the second year of the 2025–2026 biennium, so it died with the session.
  - The WD guide's deadline wording is unaffected.
- **Other signed 2025–2026 bills whose full text mentions "33-7-11":**
  - HB 296 (2025, driver's license format) and HB 410 (2025, Department of Insurance efficiency). Neither
    appears in § 33-7-11's history line, so these are cross-references.
  - SB 503 (2026, Act 516, rental home marketplace guarantees). Title 33 Chapter 7 property insurance,
    not UM.
- **Search limits:** the legis.ga.gov search tokenizes hyphenated Code numbers and multi-word phrases,
  returning hundreds of unrelated bills. A search for "40-8-76" returned nothing at all. **The search is
  a lead finder, not a negative proof.** The negative evidence for each section is its Justia history
  line.

## 6. New law the guides should mention or avoid contradicting

1. **Car-seat guide: seat-belt paragraph (body) and FAQ 7. SB 69 limits the new rule to suits filed on or
   after 2025-04-21.**
   - As drafted (body): "Seat belts follow a separate section. Following SB 68, approved in April 2025,
     O.C.G.A. § 40-8-76.1(d) permits seat belt non-use to be admitted on negligence, comparative
     negligence, causation, assumption of risk and apportionment, and it may diminish recovery. There is
     no percentage cap on that reduction."
   - Suggested (body): "Seat belts follow a separate section. For lawsuits filed on or after April 21,
     2025, O.C.G.A. § 40-8-76.1(d), as amended that year, allows seat belt non-use to be considered as
     evidence on negligence, comparative negligence, causation, assumption of risk and apportionment of
     fault, and it may diminish recovery. The statute sets no percentage cap on that reduction, and the
     court can still exclude the evidence under the rules of evidence."
   - As drafted (FAQ 7): "It can. Following SB 68, O.C.G.A. § 40-8-76.1(d) permits seat belt non-use to be
     admitted on negligence, comparative negligence, causation, assumption of risk and apportionment, and
     it may diminish recovery. There is no percentage cap on that reduction. Talk to a lawyer before
     answering an adjuster's questions about restraints."
   - Suggested (FAQ 7): "It can. For lawsuits filed on or after April 21, 2025, O.C.G.A. § 40-8-76.1(d)
     allows seat belt non-use to be admitted on negligence, comparative negligence, causation, assumption
     of risk and apportionment, and it may diminish recovery. There is no percentage cap on that
     reduction. Talk to a lawyer before answering an adjuster's questions about restraints."
   - **Authority:** SB 69 § 4 and § 5(c)(2) (Act 10, 2025), and the Code editor's note on § 40-8-76.1. The
     pack authority `GA 40-8-76.1` is **signed** but its claim ("Following SB 68 (approved 2025-04-21),
     subsection (d) permits…") has no applicability limit.
     - "Filed" glosses the statute's "commenced". A civil action is commenced by filing the complaint
       (§ 9-11-3, **not read this pass**), so Eric confirms the gloss.
     - This is a **NEW claim** beyond the signed pack. Proposed pending authority for a pack PR: `cite`
       "Ga. L. 2025, p. 31, § 5(c)(2) (SB 69)"; `claim` "The 2025 revision of § 40-8-76.1(d) applies only to
       causes of action commenced on or after April 21, 2025; earlier-commenced actions are governed by
       prior law."; `quantities` []; `evidence` the SB 69/AP URL above; `verifiedBy` null.
   - **Is this required before Eric sees the draft?** Recommended, not blocking. What is published is true
     for any suit filed today. The omission matters only to a reader whose suit was already pending on
     2025-04-21.
2. **WD guide: WD-2's estate expense sentence now has a 2025 overlay for medical expenses.**
   - Proposed WD-2 (not yet in the draft): "A separate claim by the estate's personal representative can
     recover funeral, medical and other necessary expenses resulting from the injury and death (O.C.G.A.
     § 51-4-5)."
   - **It stays true as written.** § 51-4-5(b) is unchanged.
   - Do **not** add "the full medical bills" or "what the hospital charged". For causes of action arising
     on or after 2025-04-21, § 51-12-1.1(b) limits medical special damages to "the reasonable value of
     medically necessary care, treatment, or services". Under (c), when there is health insurance, the
     jury hears both the amounts charged and the amounts actually necessary to satisfy them.
   - Optional sentence, only if Eric wants it: "For deaths after April 21, 2025, medical expenses are
     measured by the reasonable value of medically necessary care (O.C.G.A. § 51-12-1.1)."
     - It paraphrases (b) only and does not characterize (c). The repo's SB 68 brief forbids
       characterizing Section 7 beyond its subject, and this stays inside that.
     - Strictly, the rule applies to causes of action *arising* on or after 2025-04-21. For a death case,
       whether that runs from the injury or the death is an Eric question, so the sentence says "deaths
       after" only if he agrees.
3. **WD guide: "what drives value" can lean on § 9-10-184(a)(2).**
   - The 2025 text defines noneconomic damages to include "in wrongful death cases, the nonpecuniary
     elements of the full value of life".
   - That is statutory support for full value having both economic and nonpecuniary parts, which is what
     the table's "Show the life beyond a paycheck" row implies.
   - **Avoid** any sentence about what a lawyer can say to a jury about a dollar figure. § 9-10-184(b)–(c)
     now restricts this, and it applies to pending cases. The draft has no such sentence; keep it that way.
4. **UM guide: § 33-7-16 (SB 121, 2025) sets higher liability minimums for drivers convicted of DUI.**
   - The draft's "Personal auto policies must carry at least $25,000 per person and $50,000 per accident
     for bodily injury, and $25,000 for property damage" is still the general rule.
   - Recommend no change. Optional qualifier: "Drivers convicted of DUI must carry higher limits for three
     years (O.C.G.A. § 33-7-16)." That would be a NEW claim, so Eric decides.
5. **Nothing in SB 68 or SB 69 changes** § 51-12-33 (50% bar, reduction), § 9-3-33 (two years), § 9-3-90,
   the ante litem periods, § 40-8-76, § 33-7-11 or § 40-6-270. The guides need no SB 68 caveat on those
   statements.

## 7. Changes to the Eric email questions

| # | Planned question | Change | Why |
|---|---|---|---|
| 1 | Car-seat rules in § 40-8-76 | **Keep; add a line** saying the text was checked current through the 2026 session (history ends 2011; SB 88) | Moves the question from "is this still the law" to "do you approve the wording" |
| 2 | "car seat or booster seat" gloss | Keep | Unchanged |
| 3 | Installation bullet ((b)(1)(C)) | Keep | Text confirmed current |
| 4 | Minor's filing deadline | **Reword.** Quote § 9-3-90(b), current: a minor has "the same time after he or she reaches the age of 18 years". Ask two things: (a) may the page say the child's own claim generally runs two years from the 18th birthday; (b) should it say the parent's claim for the child's medical expenses is not tolled (case law, not read). Note the § 9-3-33.1 carve-out and § 9-3-73 for med mal. | Gives him the text to approve instead of an open question |
| 5 | "must include UM unless a named insured rejects it in writing" | Keep; add that (a)(1) and (a)(3) are unchanged since 2022 and that HB 1344 (2026) does not touch § 33-7-11 | Currency settled |
| 6 | Hit-and-run physical contact or eyewitness | Keep | (b)(2) confirmed current |
| 7 | Cite the liability minimums to § 33-34-4, not § 33-7-11 | **Reword.** "The draft cites § 33-7-11 for $25k/$50k/$25k. The requirement is § 33-34-4, and § 40-9-37(a) takes the amounts from § 33-7-11(a)(1)(A). The 2025 act (§ 33-7-16(d)) itself calls it 'the minimum … coverage required under Code Section 33-7-11'. Keep the short cite, or use 'O.C.G.A. §§ 33-34-4 and 40-9-37'?" | The current cite is defensible, not wrong. The question is preference. |
| 8 | Add the estate expense claim (§ 51-4-5) | **Keep; add a sub-question**: whether to mention § 51-12-1.1 (reasonable value of medically necessary care, for causes of action arising on or after 2025-04-21) | SB 68 § 7 bears on the medical part |
| 9 | Decedent's comparative fault and the softened sentence | Keep | § 51-12-33 unchanged since 2022; SB 68 does not amend it |
| 10 | "Lawsuit must be filed within two years" | Keep; note HB 1160 (2026, WD tolling for surviving relatives) did not pass | Removes a possible "did something change?" |
| 11 | Decedent-perspective framing of "full value" | Keep; cite § 9-10-184(a)(2) ("the nonpecuniary elements of the full value of life") as statutory context | New 2025 statutory language on point |
| Currency | §§ 40-8-76, 33-7-11, 51-4-2, 51-4-5 | **Replace** with a statement plus one narrow question. Statement: all four were checked against the current Code's history lines; only § 51-4-2(f) changed (HB 327, 2025, children born out of wedlock), and nothing the guides say is affected. Question: "Do you agree the 2025 seat-belt evidence rule reaches only suits filed on or after 2025-04-21 (SB 69 § 5(c)(2))?" | The open currency question is answered. The real new question is SB 69. |
| **New** | Seat-belt applicability | **Add** (see the row above). Include the suggested body and FAQ 7 wording from § 6.1. | New finding |

## 8. Fix in the drafts before Eric sees them

Nothing below is **required** in the sense of a false statement now published. Every draft statement
checked is true under current law. Items in priority order:

1. **Car-seat, body and FAQ 7.** Add "For lawsuits filed on or after April 21, 2025" (§ 6.1). Recommended.
   It is an omission, not an error, and it rests on a NEW claim that needs Eric plus a pending pack
   authority.
2. **Car-seat, body and FAQ 7.** "Following SB 68" names one of two acts. Either drop the bill name or
   make it "as amended in 2025". Advisory.
3. **UM-2 in `remediation-2026-09-30-ga-resources.md`** should be downgraded from "cited to the wrong
   section" to "citation preference" (§ 4, liability minimum chain). The six surfaces need no edit before
   Eric.
4. **`ga-statute-research-2026-09-30.md`, the § 51-4-2 row** reads from the 2024 FindLaw text. (f) now
   carries the § 53-2-3 inheritance condition (HB 327, 2025). No draft uses (f).

## 9. Outside the three drafts, found by this check (for the owner)

- **A prior conclusion in this repo is wrong.** `data/facts/remediation-2026-09-29-ga-statewide.md`
  (item (b), page 6318 body and faq3) says: "No start-date caveat is needed. SB 68 Section 9 limits only
  Sections 6 and 7 to new causes of action, and the seat-belt amendment (Section 5) reaches pending ones
  (repo brief)."
  - SB 69 § 5(c)(2) says the opposite for the identical amendment, and the Code editor's note says SB 69
    governs.
  - The live GA statewide page 6318 therefore carries the same omission as the car-seat draft.
- **`docs/briefs/2026-08-07-georgia-tort-reform-sb68.md` §4** lists Section 5 (seat belts) with the
  provisions that reach pending cases. Its Section 9 quote is correct for SB 68 alone but superseded for
  § 40-8-76.1 by SB 69. Its "SB 69 — verify or omit" note can now point here.
- **GA pack `GA 40-8-76.1` (signed).** The claim needs an applicability qualifier. That is a pack PR for
  the pack's signer, fixtures first. It is not a page edit and not a rule change.

## 10. Could not confirm

- **The official free O.C.G.A. (LexisNexis public access)** was not read; it is JavaScript-only. Every
  history line here comes from Justia's reproduction of the annotated Code.
  - Justia demonstrably carries 2025 acts and at least two 2026 acts (HB 945, and HB 1344's delayed
    § 33-7-6 version). **That Justia has merged every 2026 act is strong evidence, not certainty.**
- **No 2025 or 2026 special session** was checked.
- **§ 9-11-3** (when an action is "commenced") was not read. It supports the "filed" gloss in § 6.1, so
  Eric confirms it.
- **The SB 68 § 3 (voluntary dismissal) struck text** is inferred from the flattened PDF. It is irrelevant
  to the guides.
- **Case-law points the statutes do not settle** (all still for Eric):
  - whether the parent's claim for a minor's medical expenses is tolled;
  - how comparative fault applies to a decedent;
  - the decedent-perspective measure of full value;
  - whether § 51-12-1.1 "arising" runs from the injury or the death.

*Research only. Nothing in this file edits the drafts, the GA pack, the theme or production. Eric Roden's
review remains the approval for Georgia wording on Roden pages.*
