# Pre-publish legal sweep: three Georgia resource guides (DRAFT, not published)

- **Pages (drafts; target slugs return 404 today):**
  - `/resources/georgia-car-seat-laws/`
  - `/resources/georgia-uninsured-motorist-coverage/`
  - `/resources/georgia-wrongful-death-settlement-value/`
- **Jurisdiction:** Georgia only. The author of record is Eric Roden (attorney post 3729). For Roden, Eric Roden's review is the approval for Georgia wording.
- **Pack:** `internal-ai-scripts/law/GA.json`. It is **signed**. This sweep did not edit it.
  - Signed authorities used by the pages: `GA 40-8-76`, `GA 40-8-76.1`, `GA 9-3-33`, `GA 33-7-11`, `GA 51-12-33`, `GA 40-6-270`, `GA 51-4-1`, `GA 36-33-5`, `GA 36-11-1`, `GA 50-21-26`.
  - Pending authority that touches these pages: `GA 33-34-4` (compulsory liability minimum; see UM-2).
  - No pack authority covers §§ 51-4-2 or 51-4-5.
- **What was swept:** `data/practice-area-drafts/2026-09/ga-resources/*.json`. That covers every field that publishes: `meta_title`, `meta_description`, `key_takeaways`, `body_html` (including table cells) and every FAQ (8 + 7 + 7).
  - The FAQs also become FAQPage JSON-LD. No rendered page exists yet, so render one page after publish and diff the FAQPage block against the visible FAQs.
- **Primary text read this pass:** Justia and FindLaw serve a bot challenge directly, so each page was read through the r.jina.ai reader.
  - § 40-8-76: `https://codes.findlaw.com/ga/title-40-motor-vehicles-and-traffic/ga-code-sect-40-8-76/`, "last updated March 28, 2024". Full text of (a)–(d).
  - § 33-7-11: `https://codes.findlaw.com/ga/title-33-insurance/ga-code-sect-33-7-11/`, "last updated March 28, 2024". Subsections (a)(1), (a)(1)(A), (a)(3), (b)(1)(D)(ii), (b)(2), (j).
  - § 51-4-2: `https://codes.findlaw.com/ga/title-51-torts/ga-code-sect-51-4-2/`, 2024-03-28. Subsections (a)–(f).
  - § 51-4-5: `https://codes.findlaw.com/ga/title-51-torts/ga-code-sect-51-4-5/`, 2024-03-28. Subsections (a) and (b).
  - GOHS "Child Passenger Safety" (`https://gahighwaysafety.org/child-passenger-safety/`), live on 2026-09-30. It is a state agency summary, not statute. It independently corroborates the following in 2026: under eight, "car seat or booster seat", passenger automobile/van/pickup, the taxi and public-transit exemptions, the 40-lb lap-belt rule and the 4'9" safety-belt exit.
- **Engine runs:**
  - Replay file: `data/facts/ga-resources-replay-2026-09-30.json`.
  - **Corrected set: 57/57 met.** It contains the 9 corrected strings, 31 whole corrected surfaces (body, KT, meta and every FAQ, per page) and 17 positive controls. All 17 fired:
    - `carseat-40lb-front-seat` ×5, one of them planted inside the corrected FAQ wording
    - `seat-belt-percentage-cap` ×2
    - `wrongful-death-deadline-cited-to-definitions` ×2
    - `georgia-requires-pip` ×2
    - `foreign-SC` ×2
    - `georgia-is-no-fault`
    - `comparative-negligence-wrong-statute`
    - `joint-and-several-liability`
    - `municipal-ante-litem-12-months`
  - **Gap probes: the engine is silent on all 9.** These are the 7 original erroneous sentences plus 2 variants. **Every required finding below was caught by reading, not by a rule.**
  - The writer's own fixture (`scratchpad/ga/ga-resources-fixture.json`) re-ran at 319/319.
  - **FAQ gate** (`verify-faq-drafts.mjs --client roden`, on the corrected FAQs against the corrected bodies): 22 answers checked, 0 failures, 0 warnings. The two changed answers are 385 and 308 characters.
- **Currency caveat (all rows):** every statute text read here is the publisher's 2024 reproduction.
  - The pack records SB 68 (approved 2025-04-21) as amending § 40-8-76.1(d). Nothing read here shows whether any 2025–2026 act touched §§ 40-8-76, 33-7-11, 51-4-2 or 51-4-5.
  - Eric should confirm currency on each row he signs, especially § 40-8-76(c), which answers a whole FAQ.

Source key: **PAGE** means the draft's source JSON. Nothing in this sweep is TEMPLATE or LIVE.

Status labels:
- **Required** means block publish until fixed.
- **Recommended** means fix before publish if Eric agrees.
- **Advisory** means record only.
- **Statute-text verified, pending Eric** means the wording matches the statute text read here, but the claim is not in the signed pack. Eric Roden's review is the approval.

## Verdicts

| Page | Verdict | Required | Recommended / Eric | Advisory |
|---|---|---|---|---|
| Car seat laws | **FAIL** (6 edits, 4 surfaces) | CS-1 | CS-2 | CS-A1…A6 |
| Uninsured motorist | **FAIL** (2 edits, 2 surfaces) | UM-1 | UM-2, UM-3, UM-4 | UM-A1…A4 |
| Wrongful death settlement value | **FAIL** (1 edit, body) | WD-1 | WD-2, WD-3, WD-4 | WD-A1…A3 |

After the required edits, all three pages **PASS**, subject to Eric's review. The car-seat page also needs his confirmation of the statute-text-verified statements listed in its `needs_reviewer_note`, and that confirmation is still pending.

Checked across all three pages:
- **SC leaks:** none. There is no S.C. Code cite, no "South Carolina", and no 51% or three-year figure.
- **Settlement-value numbers:** none on any page. The only dollar figures are the fines on the car-seat page ($50/$100) and the insurance minimums on the UM page ($25,000/$50,000).
- **Stacking and UM rejection:** neither appears; "stack", "reject" and "waive" never occur. The UM page's problem is the reverse: it implies UM is opt-in (UM-1).
- **Who may sue for wrongful death:** the WD page never names a plaintiff. The only related wording is the generic "families" (WD-4).

---

## Car seat laws: `/resources/georgia-car-seat-laws/`

### CS-1 (Required). The rear-seat exception is narrowed to "other children under eight", and the physician-statement exception is omitted.

- **Statute text, § 40-8-76:**
  - (b)(1)(B): "If the vehicle has no rear seating position appropriate for correctly restraining a child or all appropriate rear seating positions are occupied by **other children**, any such child may be properly restrained in a front seat."
    - The statute has no age qualifier on "other children". The page adds "under eight" four times. The research file also says only "other children".
  - (b)(1)(D): "The provisions of this paragraph shall not apply when the child's parent or guardian either obtains a **physician's written statement** that a physical or medical condition of the child prevents placing or restraining him or her in the manner required by this paragraph."
    - The page says "only if" and "three exits and exceptions" and never mentions this exception.
- **Why required:** "under eight" makes the front-seat exception narrower than the law. A parent whose rear seats are filled by an older child is told the child cannot ride in front, when the statute allows it. Separately, "only if" is false where a physician's statement applies.
- **Authority:** `GA 40-8-76` (signed: "the front-seat exception turns on rear-seat availability and carries no weight condition"). The corrected wording stays within the signed claim. The medical exception and the removal of "under eight" are **statute-text verified, pending Eric** (FindLaw 2024-03-28).
- **Rule:** none. Gap probes `gap-CS-1a/c/e/f` pass silently.

| # | Field | Before | After |
|---|---|---|---|
| CS-1a | `key_takeaways` | A child under eight may ride in front only if the vehicle has no appropriate rear seat, or every appropriate rear seat is taken by other children under eight. | A child under eight may ride in front only if the vehicle has no appropriate rear seat, or every appropriate rear seat is taken by other children; a physician's written statement about a medical condition is a separate exception. |
| CS-1b | `body_html` | `<p>The statute has three exits and exceptions that parents ask about most:</p>` | `<p>The statute has four exits and exceptions that parents ask about most:</p>` |
| CS-1c | `body_html` | `<li><strong>Front seat:</strong> a child under eight may ride in front only if the vehicle has no appropriate rear seating position, or every appropriate rear position is occupied by other children under eight.</li>` | `<li><strong>Front seat:</strong> a child under eight may ride in front only if the vehicle has no appropriate rear seating position, or every appropriate rear position is occupied by other children.</li>` |
| CS-1d | `body_html` (insert after the Lap belt `<li>`) | `<li><strong>Lap belt:</strong> … being used by other children.</li>` | the same `<li>`, then a new line `<li><strong>Medical:</strong> these requirements do not apply when the child's parent or guardian obtains a physician's written statement that a physical or medical condition of the child prevents restraining the child in the way the law requires.</li>` |
| CS-1e | `body_html` (H2 "Can a child sit in the front seat…") | A child under eight may sit in the front seat in Georgia only if the vehicle has no appropriate rear seating position for the child, or every appropriate rear position is already occupied by other children under eight (O.C.G.A. § 40-8-76). | A child under eight may sit in the front seat in Georgia only if the vehicle has no appropriate rear seating position for the child, or every appropriate rear position is already occupied by other children (O.C.G.A. § 40-8-76). A physician's written statement about the child's medical condition is a separate exception. |
| CS-1f | `faqs[2].answer` ("Can a child sit in the front seat in Georgia?") | A child under eight may sit in front only if the vehicle has no appropriate rear seating position, or every appropriate rear position is occupied by other children under eight (O.C.G.A. § 40-8-76). The front-seat exception carries no weight condition. The 40-pound provision belongs to the lap-belt rule. | A child under eight may sit in front only if the vehicle has no appropriate rear seating position, or every appropriate rear position is occupied by other children (O.C.G.A. § 40-8-76). A physician's written statement about the child's medical condition is a separate exception. The front-seat exception carries no weight condition; the 40-pound provision belongs to the lap-belt rule. |

CS-1d is written as a whole-`<li>` replacement, so `str_replace` stays exact-match. The full `before` and `after` strings are in the replay file's `fix-CS-1d` entry and in `scratchpad/rem/changes.json`.

### CS-2 (Recommended, Eric). The installation requirement is omitted.

- § 40-8-76(b)(1)(C): "A driver shall not be deemed to be complying … unless any child passenger restraining system … is installed and being used in accordance with the manufacturer's directions."
- The page treats installation only as guidance. This is optional. A bullet would be accurate: "**Installation:** a driver is not complying unless the seat is installed and used according to the manufacturer's directions."

### Checked and correct against statute text (statute-text verified, pending Eric)

| Page statement | § 40-8-76 text |
|---|---|
| Under eight; appropriate, federally approved restraint; rear seat | (b)(1): "child under eight years of age … child passenger restraining system appropriate for such child's height and weight and approved by the United States Department of Transportation under … FMVSS 213"; (b)(1)(B) "in a rear seat" |
| Passenger cars, vans and pickups; taxis and public transit excluded | (b)(1): "passenger automobile, van, or pickup truck, other than a taxicab … or a public transit vehicle" |
| Over 4'9" → safety belt | (b)(1)(D): "If the parent or guardian can show the child's height is over 4 feet and 9 inches, such child shall be restrained in a safety belt as required in Code Section 40-8-76.1" |
| 40 lb lap belt conditions | (b)(1)(A)(i)–(ii), matched exactly, including "not including the driver's seat" |
| Up to $50 first, up to $100 later; no added fees or surcharges | (b)(2): "fine of not more than $50.00 … second or subsequent conviction … not more than $100.00. No court shall impose any additional fees or surcharges" |
| (c): not negligence per se or contributory negligence per se; no cancellation or rate increase | (c): matched word for word. The page's cite "§ 40-8-76(c)" is the correct subsection. |
| "such as a car seat or booster seat" | The statute says "child passenger restraining system". GOHS (2026) says "child passenger safety seat or booster seat", which supports the gloss. The README's open point can close on Eric's nod. |
| Seat-belt paragraph and FAQ on § 40-8-76.1(d) | Matches the signed `GA 40-8-76.1` claim verbatim |
| Two years under § 9-3-33 | Matches signed `GA 9-3-33` |

### Advisory

- **CS-A1 (currency).** FindLaw's text is dated 2024-03-28. GOHS in 2026 corroborates the core rule but not (b)(2) or (c). Confirm that neither was amended in 2025–2026.
- **CS-A2 ((c) scope).** (c) removes negligence *per se*. It does **not** make a violation inadmissible, unlike the pre-SB 68 § 40-8-76.1(d). The page's "Georgia limits what a car seat violation can do" is accurate. Never let a later edit turn it into "cannot be used against your claim".
- **CS-A3 (points).** § 40-8-76 states no points, and the page states none. Keep it that way. A points figure would come from § 40-5-57, which was not read.
- **CS-A4 (minors' deadline).** "Special rules can change how a child's deadline is counted" is true and vague. Do not name a tolling rule (§ 9-3-90) without Eric. The parent's own claim for the child's medical expenses can run on a different clock.
- **CS-A5 (unsourced generalizations, labelled).** Several statements are labelled "safety guidance, not law" and are acceptable as labelled: the stage table's guidance column, the fit check, "a belt-positioning booster is designed to work with a lap-and-shoulder belt" and the airbag advice. "Many websites say a child must weigh 40 pounds…" is an unsourced generalization, but it describes the known error class, so keep it.
- **CS-A6 (cannibalization).** `/blog/georgia-car-seat-law-overview/` (post 1874) is live. Sweep it for the same "other children under eight" and missing-medical-exception class before deciding on a 301.

---

## Uninsured motorist coverage: `/resources/georgia-uninsured-motorist-coverage/`

### UM-1 (Required). The answer to "Is uninsured motorist coverage required in Georgia?" frames UM as opt-in.

- **Published:** "Georgia requires insurers to offer uninsured motorist coverage … Whether you carry it depends on **what was purchased** on your policy."
- **Signed claim, `GA 33-7-11`:** "…uninsured motorist coverage must be offered." The first sentence matches it. The second sentence is not in the claim, and the statute contradicts it:
  - § 33-7-11(a)(1): "No automobile liability policy … shall be issued or delivered in this state … **unless it contains an endorsement** or provisions undertaking to pay the insured damages … sustained from the owner or operator of an uninsured motor vehicle."
  - (a)(3): "The coverage required under paragraph (1) … shall not be applicable where any insured named in the policy shall **reject the coverage in writing**."
- **Why required:** UM is in the policy by default and comes out only by written rejection. A reader told it "depends on what was purchased" may assume they never bought it and stop looking. The KT's "depends on what your policy includes" is neutral and is **not** changed.
- **Authority:** `GA 33-7-11` (signed). The corrected wording asserts nothing beyond "must be offered".
- **Rule:** none. Gap probes `gap-UM-1a/b` pass silently.

| # | Field | Before | After |
|---|---|---|---|
| UM-1a | `body_html` (H2 "Is uninsured motorist coverage required in Georgia?") | Whether you carry it depends on what was purchased on your policy, so the reliable answer for your situation is printed on your declarations page, the summary sheet that lists each coverage and its limits. | Whether your policy includes it, and at what limits, is printed on your declarations page, the summary sheet that lists each coverage and its limits. |
| UM-1b | `faqs[0].answer` | Georgia requires insurers to offer uninsured motorist coverage, under O.C.G.A. § 33-7-11. Whether you carry it depends on what was purchased on your policy. Check the declarations page, the summary sheet listing each coverage and its limits, or ask your agent for a complete copy of your policy. | Georgia requires insurers to offer uninsured motorist coverage, under O.C.G.A. § 33-7-11. Whether your policy includes it, and at what limits, is shown on your declarations page, the summary sheet listing each coverage and its limits. If you cannot find it, ask your agent for a complete copy of your policy. |

### UM-2 (Recommended; a pack question for the GA pack's signer and Eric). The liability minimums are cited to § 33-7-11.

- **Surfaces (six):**
  - `key_takeaways`: "The same section sets Georgia's minimum personal auto liability limits…"
  - `body_html`: the second paragraph under the first H2, and the "too small" paragraph
  - Table rows "Bodily injury liability" and "Property damage liability"
  - `faqs[1]` and `faqs[3]`
- **Text:** § 33-7-11(a)(1)(A) sets the **UM** endorsement limits: "within limits … which at the option of the insured shall be … Not less than $25,000.00 … $50,000.00 … $25,000.00".
  - The pack's own pending `GA 33-34-4` records that the liability minimum is the § 33-34-4 → § 40-9-37 chain, "not § 33-7-11 alone (which governs uninsured-motorist coverage)".
- **Why not required:** the signed `GA 33-7-11` claim backs the page's attribution and the quantities are right. **Never weaken or override a signed claim from a page.**
- **Route:** signing `GA 33-34-4` and amending the `GA 33-7-11` claim is a pack PR. After that, re-cite these six surfaces to "O.C.G.A. § 33-34-4". The KT's "The same section sets" should become "Georgia's minimum personal auto liability limits are…".

### UM-3 (Recommended, statute-text verified, pending Eric). Answer the lead question fully.

- The accurate answer to "is UM required in Georgia" is that a policy must include it unless a named insured rejects it in writing.
- Proposed sentence after UM-1a and UM-1b: "A Georgia auto policy must include UM coverage unless a named insured rejects it in writing (O.C.G.A. § 33-7-11)."
- § 33-7-11(a)(1) and (a)(3) were read 2026-09-30 (FindLaw, 2024-03-28).
- It needs a pack authority because it is a NEW claim. Proposed pending entry:
  - `claim`: "Every auto liability policy must contain UM coverage unless a named insured rejects it in writing ((a)(1), (a)(3))."
  - `quantities`: []
  - `evidence`: the FindLaw URL above
  - `verifiedBy`: null
- Stacking and the added-on/reduced-by election ((b)(1)(D)(ii)) remain out, as instructed.

### UM-4 (Recommended, Eric). Hit-and-run conditions are statutory, not only a matter of the policy.

- § 33-7-11(b)(2): for an unknown driver, "actual physical contact shall have occurred … Such physical contact shall not be required if the description … is corroborated by an eyewitness … other than the claimant."
- The page's "depends on your policy and the facts" is hedged, not false. Better: "depends on your policy, the facts of the crash and conditions Georgia law sets for claims against an unknown driver." Naming the physical-contact / eyewitness rule is statute-text verified, pending Eric.

### Advisory

- **UM-A1.** "Georgia is an at-fault state", "PIP … Not required in Georgia" and "MedPay … Optional" carry no authority. They are the negations of pack rules (`georgia-is-no-fault`, `georgia-requires-pip`) and match the live statewide page. These are unsourced generalizations; accept them as written.
- **UM-A2.** "A signed release can affect your other claims" is hedged and true. The Georgia limited-release statute (§ 33-24-41.1) was not read. Leave it unstated.
- **UM-A3.** "A UM claim has its own procedural steps" is hedged. § 33-7-11(d) service on the UM carrier was not read this pass. Leave it unstated.
- **UM-A4 (engine gap, found by a control that missed).** "…and every driver must carry personal injury protection (PIP) coverage", without "Georgia requires", does **not** trip `georgia-requires-pip`. This is not on the page. Recorded in the replay's `gaps` as `gap-pip-noverb`; a pack PR should widen the rule, fixtures first.
- Checked correct: `GA 51-12-33` (50% bar, reduction), `GA 9-3-33` (two years) and `GA 40-6-270` (stop, identify, render aid; no penalty stated) all match their signed claims. No stacking and no rejection language anywhere.

---

## Wrongful death settlement value: `/resources/georgia-wrongful-death-settlement-value/`

### WD-1 (Required). The "worth" sentence makes the full-value claim the whole of a death case.

- **Published** (`body_html`, H2 "How much is a wrongful death settlement worth in Georgia?"): "A Georgia wrongful death settlement **is worth** what the evidence can prove about the full value of the life lost…"
- **Statute text:**
  - § 51-4-5(b): "When death of a human being results from a crime or from criminal or other negligence, **the personal representative** of the deceased person shall be entitled to recover for the **funeral, medical, and other necessary expenses** resulting from the injury and death of the deceased person."
  - § 51-4-2(a): the spouse or children "may recover … the full value of the life of the decedent, as shown by the evidence."
- **Why required:** a settlement of a Georgia death case commonly resolves both the full-value claim and the estate's expense claim. Saying the settlement "is worth" the full value alone tells the family that funeral and medical bills are not recoverable, or are already inside that figure. They are a separate claim belonging to a different party.
- The fix scopes the sentence to the wrongful death claim. It uses only the signed `GA 51-4-1` term and asserts nothing about the estate claim.
- **Authority:** `GA 51-4-1` (signed; "full value of the life of the decedent"). **Rule:** none. Gap probe `gap-WD-1` passes silently.

| # | Field | Before | After |
|---|---|---|---|
| WD-1 | `body_html` | A Georgia wrongful death settlement is worth what the evidence can prove about the full value of the life lost, reduced by any fault of the person who died and limited in practice by the insurance and assets available to pay it. | A Georgia wrongful death claim is measured by what the evidence can prove about the full value of the life lost, reduced by any fault of the person who died and limited in practice by the insurance and assets available to pay it. |

The KT and `faqs[0]` / `faqs[1]` say "Georgia measures the recovery by the 'full value…'". In context that is the wrongful death recovery. It is left as is, but becomes fully accurate only with WD-2.

### WD-2 (Strongly recommended, statute-text verified, pending Eric). Name the estate's expense claim.

- Insert after WD-1: "A separate claim by the estate's personal representative can recover funeral, medical and other necessary expenses resulting from the injury and death (O.C.G.A. § 51-4-5)."
- This is § 51-4-5(b) nearly verbatim (FindLaw 2024-03-28; the research file cites Justia 2024).
- It names the **personal representative**, the only plaintiff the text supports for these expenses. It does not say who brings the full-value claim.
- It needs a pack authority (NEW claim). Proposed pending entry `GA 51-4-5`:
  - `claim`: "(b) The personal representative recovers funeral, medical and other necessary expenses resulting from the injury and death. (a) If no one may sue under §§ 51-4-2 or 51-4-4, the administrator or executor sues for the full value of the life, for the next of kin."
  - `quantities`: []
  - `verifiedBy`: null
- **Do not add** the estate's pain-and-suffering (survival) claim, § 9-2-41. It was not read.

### WD-3 (Recommended, Eric). Decedent's fault: the page uses an inconsistent standard and overstates it once.

- The writer declined § 51-11-7 because its signed claim speaks of "the plaintiff". Yet the page applies `GA 51-12-33`, whose signed claim also says "the plaintiff's share", to "the person who died" on five surfaces: the KT, the body H2 paragraph, the table row, `faqs[2]` and the meta description.
- Applying the decedent's comparative fault is standard Georgia practice. **Eric should confirm it** rather than the page resting on a signed claim that does not say it.
- One sentence is absolute: "In a wrongful death case, the fault that counts on the family's side is the fault of the person who died." A beneficiary's own fault can also matter, for example a parent who was driving.
  - Proposed: "In a wrongful death case, the fault of the person who died counts against the recovery."

### WD-4 (Recommended). "Families" as the ones who file.

- **Surfaces:** `key_takeaways` ("Families generally have two years to file a wrongful death lawsuit"), `body_html` (the same phrase), `faqs[3]` (the same phrase).
- This is not a standing claim, but it reads as "the family files". §§ 51-4-2 and 51-4-5(a) give the claim in order to the spouse, then the children (then the parents under § 51-4-4, which was not read), then the administrator or executor for the next of kin.
- A neutral form avoids implying who sues: "A Georgia wrongful death lawsuit generally must be filed within two years, under O.C.G.A. § 9-3-33."
- Do not add a "who can file" section without Eric. § 51-4-4 has not been read.

### Advisory

- **WD-A1.** Some evidence named for "full value" is framed from the family's side: "the care and support they gave their family" and "Show the life beyond a paycheck". Georgia measures full value from the decedent's perspective, which is case law and was not read. This is not false as evidence, but Eric should confirm the framing.
- **WD-A2.** "Written notice comes due much sooner." Six months for a city is much sooner. Twelve months for a county or the State is only "sooner". A cleaner wording is "sooner, and much sooner for a city".
- **WD-A3.** "Generally" in the two-year sentence covers accrual at death and tolling, neither of which is stated. That is fine as written.
- Checked correct:
  - `GA 51-4-1`: defines the term; contains no limitation period.
  - `GA 9-3-33`: two years.
  - `GA 51-12-33`: joint and several liability abolished in 2005; each defendant pays its own share.
  - `GA 36-33-5`, `GA 36-11-1`, `GA 50-21-26`: 6 / 12 / 12 months.
- No dollar figures, averages or ranges anywhere. "No reliable average" is a method statement, not a figure.

---

## Counts by rule

| Rule | Findings |
|---|---|
| (none; found by reading) | 9 required edits: CS-1a–f, UM-1a–b, WD-1 |
| (none; found by reading) | 10 recommended items: CS-2, UM-2, UM-3, UM-4, WD-2, WD-3, WD-4, plus the Eric confirmations in CS-A1/CS-A4 and WD-A1 |
| Any pack rule | 0 findings on the drafts, before or after correction |

## False positives

None. No rule fired on any surface of any page.

## Engine blind spots (pack PR candidates; fixtures first, never a page edit)

1. `ga-carseat-front-seat-age-qualifier` (error): "occupied by other children under (eight|8)" near `40-8-76|front seat`. Control: the corrected CS-1c.
2. `ga-carseat-no-medical-exception` (warning): "only if" front-seat sentence with no "physician" within the surface. This is likely too noisy; consider a warning only.
3. `ga-um-opt-in` (error): "(depends on|whether you) … (purchased|bought|chose)" near `uninsured motorist|UM`. Control: the corrected UM-1b.
4. `georgia-requires-pip`: widen to "(every|all) drivers? must carry … (PIP|personal injury protection)" in a Georgia context. Control: `gap-pip-noverb` becomes a positive.
5. `GA 33-7-11` claim: amend so it does not carry the liability minimum. Sign `GA 33-34-4` (UM-2).

## Before publish

- Apply the 9 required edits to the draft JSON only. Then re-run:
  - `sweep-claims.mjs --fixtures data/facts/ga-resources-replay-2026-09-30.json --states GA` (expect 57/57)
  - the writer's 319-entry fixture
  - `verify-faq-drafts.mjs --client roden`
- Eric Roden reviews the statute-text-verified statements. For car seat: the `needs_reviewer_note` list plus CS-1's medical exception and "other children". For UM: UM-3 and UM-4 if adopted. For WD: WD-2, WD-3 and WD-4. He also confirms currency (2025–2026 amendments) for §§ 40-8-76, 33-7-11, 51-4-2 and 51-4-5.
- After publish, render each page. Diff the FAQPage JSON-LD against the visible FAQs, and confirm the KT box and the meta description match the source.
