# SB 68 staleness audit — live Georgia content

**Audited:** 2026-08-07
**Scope:** every published post on rodenlaw.com (`practice_area`, `resource`, `post`, `location`, `page`)
**Authority for the SB 68 mapping:** `docs/briefs/2026-08-07-georgia-sol-statute-verification.md`
(verified against the signed 19-page bill; not re-derived here)
**Mode:** read-only. Nothing was edited, on prod or in this repo.

---

## Method, and how the set was narrowed

| Step | Count |
|---|---|
| Published posts on prod (all five types) | **1,246** |
| — `post` 478 · `practice_area` 414 · `location` 211 · `resource` 78 · `page` 65 | |
| Post bodies pulled and read locally (`wp post list --fields=…,post_content`) | **1,246** |
| FAQ meta (`_roden_faqs`) cross-read from `content/meta.json` | **708** posts |
| GA-relevant universe after filtering | **569** |
| Posts mentioning a seat belt in any form | 71 |
| Posts asserting the Georgia negligent-security framework | 5 |
| Posts asserting Georgia medical-expense recovery rules | 3 |
| Posts describing how noneconomic damages are argued | 8 |

The GA-relevant universe is: posts tagged `_roden_jurisdiction` of `ga`, `GA`, `georgia-only`, or
`both` (342), **plus** untagged `post`/`page` records whose body cites Georgia or the O.C.G.A. —
blog posts carry no jurisdiction meta at all, so a tag-only filter would have missed every finding
below except two. Posts tagged `sc`/`south-carolina` and the 122 `_roden_locale=es` posts were
excluded. `wp db query` is classifier-blocked and `wp eval-file` was blocked too; everything here
came from `wp post list` / `wp post meta get`.

**False positives deliberately not reported.** SB 68 does not amend O.C.G.A. § 51-12-33. Roughly
40 pages cite § 51-12-33 or the 50% bar and every one of them is still correct — none is listed
below. `/resources/georgia-statute-of-limitations/` (ID 5223) already carries an explicit,
accurate correction stating that SB 68 did not touch § 51-12-33; no change needed there. Pages
that merely describe insurers *arguing* seat-belt non-use as comparative fault (1707, 1838, 3433,
2647's comparative-fault paragraph) are now **more** accurate post-SB 68, not less, and are not
flagged. Pages presenting multiplier/per-diem as settlement-negotiation heuristics
(1651, 1653, 1663, 4807, 4808, `/locations/georgia/` FAQ) are unaffected by Section 1 and are not
flagged; 4807 correctly calls the multiplier "not a Georgia legal formula."

---

## Findings, most severe first

### 1. WRONG — "Georgia law does not allow for the seat belt defense"

- **Post ID 1759** · `post` · https://rodenlaw.com/blog/compensation-while-not-wearing-seat-belt/
- Jurisdiction: no `_roden_jurisdiction` meta; body is Georgia-only (cites Georgia seat-belt law, links a Savannah car accident lawyer)
- Last modified **2025-05-08** — 17 days after SB 68 was approved
- Spanish twin: **none**

Exact text:

> "**Georgia law does not allow for the seat belt defense.** Its seatbelt law specifically states
> that a person's failure to wear a seatbelt *"shall not be considered evidence of negligence"* and
> should not be considered by the finder of fact to determine liability and *"shall not be evidence
> used to diminish any recovery for damages"* involved in a car accident."

**Why it is stale:** SB 68 **Section 5** amends O.C.G.A. § 40-8-76.1 to make seat-belt evidence
admissible on negligence, comparative negligence, causation, assumption of risk, and apportionment.
The page quotes the pre-amendment language as current law and builds a section heading ("What is
the Seatbelt Defense?") around the proposition that the defense is unavailable in Georgia. Under
Section 9 this provision reaches **causes of action pending on 2025-04-21**, so it is wrong for
existing clients as well as new ones.

This is the highest-severity finding on the site: it is an affirmative statement of Georgia law,
in a page whose entire purpose is to answer that one question, and it tells an injured reader the
opposite of what the statute now says.

**Suggested correction (do not apply):** rewrite the "What is the Seatbelt Defense?" section to
state that Georgia *formerly* barred the seat-belt defense and that SB 68 (approved 2025-04-21)
amended § 40-8-76.1 to make non-use admissible, listing the issues on which it is admissible. Pull
the amended subsection text verbatim before drafting — do not paraphrase the old quote into a new
one. The "What is Mitigation?" section, which hedges that "some states apply this concept," should
be reconciled with the new rule rather than left standing.

---

### 2. WRONG — seat-belt non-use "can reduce your recovery by up to 5%"

- **Post ID 2647** · `post` · https://rodenlaw.com/blog/rollover-crashes-and-what-they-do-to-your-body/
- Jurisdiction: no meta; body covers Georgia and South Carolina
- Last modified **2026-03-17**
- Spanish twin: **none**

Exact text:

> "**Seatbelt defense:** In Georgia, evidence that you were not wearing a seatbelt is admissible and
> **can reduce your recovery by up to 5%** (O.C.G.A. § 40-8-76.1)."

**Why it is flagged:** the admissibility half is correct post-SB 68. The **5% cap is not in the
verified account of Section 5**, which describes the amendment as making the evidence admissible on
negligence, comparative negligence, causation, assumption of risk, and apportionment — with no
numeric ceiling on the resulting reduction. A cap of that significance would have appeared in the
section summary. This reads as an invented constraint attached to a real statutory cite, which is
worse than a stale claim: it is a specific, checkable number a reader could rely on.

It also puts the site in direct self-contradiction. Post 1759 tells readers Georgia has no seat-belt
defense; post 2647 tells them it exists and is capped at 5%. Both are live today.

**Suggested correction (do not apply):** verify § 40-8-76.1 as amended before touching this line. If
no cap exists, delete "and can reduce your recovery by up to 5%" and state that non-use is now
admissible and weighed within the ordinary § 51-12-33 apportionment, with no fixed limit. Do not
substitute a different number without reading the statute.

---

### 3. INCOMPLETE — Georgia negligent security described entirely under the old common law

SB 68 **Section 6** created a new statutory cause of action for negligent security at
O.C.G.A. §§ 51-3-51 through 51-3-56. Per Section 9 this is **prospective only** — it governs causes
of action arising on or after 2025-04-21, and prior causes remain under prior law. So the pages
below are not false; they are silent about the statute that now governs any new case, which is
exactly the reader these pages are written for.

**3a. Post ID 4221** · `practice_area` · https://rodenlaw.com/premises-liability-lawyers/inadequate-security/
· `_roden_jurisdiction=both` · no `_roden_last_reviewed` · modified 2026-03-10 · 5 FAQs · no Spanish twin

Body:

> "**Georgia:** Under O.C.G.A. § 51-3-1, property owners must exercise ordinary care to protect
> invitees from foreseeable criminal acts. Georgia courts evaluate foreseeability based on the
> *'totality of the circumstances,'* including prior similar crimes on or near the property. The
> Georgia Supreme Court has held that a property owner may be liable for criminal attacks when the
> owner had knowledge of prior criminal activity that made the attack foreseeable."

FAQ meta (`_roden_faqs`) repeats the same framework in four of five entries, e.g.:

> "What makes criminal activity 'foreseeable' for a negligent security claim?" —
> "Courts consider the **totality of circumstances**: prior crimes on the property, crime rates in
> the surrounding area, the type of business, hours of operation…"

This is the site's dedicated negligent-security page and cites § 51-3-1 and case law only.

**3b. Post ID 3620** · `practice_area` · https://rodenlaw.com/practice-areas/premises-liability-lawyers/
· `_roden_jurisdiction=both` · modified 2026-02-27 · 10 FAQs

The body is a thin stub with no legal content, but the FAQ meta carries the claim:

> "**What is negligent security?**" — "Negligent security is a subset of premises liability where a
> property owner's failure to provide adequate security measures leads to a foreseeable criminal
> act… To establish negligent security, you typically must show that the property had a history of
> similar criminal activity, the owner knew or should have known of the risk, and the owner failed
> to implement reasonable security measures…"

**Spanish twin exists and carries the same defect:** `_roden_translation_es` points to
https://rodenlaw.com/es/practice-areas/premises-liability-lawyers/ (**ID 4893**,
`_roden_last_reviewed=2026-08-03`), whose FAQ "¿Qué es la seguridad negligente?" is a faithful
translation of the same common-law-only framing. Any fix to 3620's FAQ must be mirrored there, and
per the repo's i18n rule the `es_ES.mo` implications should be checked if template strings move.

**3c. Post ID 1845** · `post` · https://rodenlaw.com/blog/atm-attack-liability/ · modified 2025-05-08 · no Spanish twin

An entire page about third-party criminal attacks on Georgia property, resting on invitee duty and
foreseeability with no statutory cite at all:

> "Inadequate security is a common basis for premises liability cases in Georgia, especially when
> property owners reasonably should have known about an unsafe condition."

**Suggested correction for 3a–3c (do not apply):** add a short block stating that for injuries
occurring on or after 2025-04-21, Georgia negligent-security claims are governed by the new
statutory cause of action created by SB 68 at §§ 51-3-51 et seq., with the prior common-law
framework continuing to govern earlier injuries. Retrieve the operative text of §§ 51-3-51 to
51-3-56 before writing — the elements, the invitee/licensee distinction, and the apportionment
cross-reference to § 51-12-33 all need to come from the statute, not from summary. The dated
carve-out is essential; without it the correction would misstate the law for pre-2025 clients.

Marginal, listed for completeness but not worth separate remediation: IDs 1844, 4217, 4219, 1650,
1695 mention "inadequate security" in a hazard list or a single clause without stating the legal
framework. They inherit whatever 4221 and 3620 say.

---

### 4. INCOMPLETE — Georgia medical-expense recovery stated as pre-SB 68 collateral source

SB 68 **Section 7** added a new section to Title 51, Chapter 12, Article 1 governing special damages
for medical and healthcare expenses — the "phantom damages" provision. Like Section 6 it is
**prospective only** (causes arising on or after 2025-04-21).

**4a. Post ID 1712** · `post` · https://rodenlaw.com/blog/letters-of-protection-for-injury-victims/
· modified **2026-07-27** · no Spanish twin

Two statements, in a page devoted to letters of protection — the instrument phantom-damages
provisions are written to address:

> "**Letters of Protection in Georgia.** Georgia has **no statute specifically governing letters of
> protection.** LOPs operate under general contract law principles."

> "**Collateral Source Rule in Georgia.** Georgia's collateral source rule (O.C.G.A. § 51-12-1)
> prevents defendants from introducing evidence that a plaintiff's bills were paid by insurance or
> other sources. This supports LOP use by **preventing the defense from arguing your 'real'
> treatment cost was lower than the billed amount.**"

The second sentence is the precise proposition a phantom-damages statute exists to override. The
comparison table lower on the page repeats it ("Collateral Source Rule — Georgia: Codified in part
(O.C.G.A. § 51-12-1); **strong protection**").

**4b. Post ID 4583** · `post` · https://rodenlaw.com/blog/how-much-is-my-car-accident-claim-worth/
· modified 2026-06-26 · no Spanish twin

> "In Georgia, the collateral source rule (O.C.G.A. § 51-12-1) generally allows you to recover the
> **full value of medical bills** even if health insurance covered a portion of them."

**Severity note.** I am reporting these as INCOMPLETE rather than WRONG because the verified section
summary establishes *that* Section 7 governs special damages for medical expenses but does not
reproduce its operative text, and I did not re-derive it. Whether it abrogates the collateral source
rule outright, changes only the admissible evidence of value, or imposes disclosure duties on LOP
arrangements determines whether 4a/4b are merely incomplete or affirmatively false. **Read the
Section 7 text before drafting either correction.** If it limits recoverable medical specials to
amounts actually paid or to reasonable value, 4b becomes WRONG for any post-2025-04-21 injury.

**Suggested correction (do not apply):** in 1712, replace "no statute specifically governing letters
of protection" with an accurate statement of what SB 68 Section 7 requires, and remove or qualify
the claim that the collateral source rule prevents the defense from disputing billed amounts. In
4583, qualify "full value of medical bills" with the post-2025-04-21 rule and its date carve-out.
Note that post 1718 already says the opposite in passing — "negotiated provider rates are typically
much lower than the full billed amount, which means the medical expenses in your case reflect more
reasonable charges" — and that framing is the one consistent with the new regime.

---

### 5. INCOMPLETE — per diem arguments described without the new anchoring constraints

- **Post ID 3493** · `post` · https://rodenlaw.com/blog/how-pain-and-suffering-is-calculated-after-an-accident-in-georgia/
- Modified 2026-06-26 · no Spanish twin

> "It is also worth noting that **Georgia courts allow per diem arguments during closing statements**,
> which some states restrict. This gives Georgia personal injury attorneys an additional tool for
> persuading juries to award fair compensation."

And in the comparison table:

> "Per Diem Method — **Common usage: Jury presentations and trial arguments** … Georgia courts:
> Accepted; per diem arguments permitted in closing statements."

**Why it is stale:** SB 68 **Section 1** revised O.C.G.A. § 9-10-184 so that counsel may argue a
monetary figure for noneconomic damages only after the close of evidence, and only within
constraints. Confining the argument to closing is now a statutory *limit*, not a Georgia advantage —
and "trial arguments" as a general usage category is too broad, since it reads to include opening
statement. The page presents the old permissive posture as a strategic edge. This provision reaches
**pending** causes of action.

**Suggested correction (do not apply):** rewrite the two passages to state that SB 68 amended
§ 9-10-184 to restrict when and how a monetary value for noneconomic damages may be argued, and
narrow the table's "Common usage" cell to closing argument only. Pull the amended § 9-10-184 text
before writing — the specific constraints on the figure need to be stated accurately or not at all.

---

## Clean results

Stated explicitly, because a clean result is a result:

- **Bifurcation (Section 8, new § 51-12-15).** **Zero** published pages mention bifurcation,
  separate trials, or phased liability/damages proceedings, in Georgia or South Carolina content.
  Nothing is stale. This is a content gap rather than an error — the $150,000 carve-out is
  potentially useful material for a Georgia litigation-process page, but nothing on the site is
  wrong today.
- **Section 2 (§ 9-11-12, answer/defenses/objections timing).** No page describes Georgia answer or
  motion deadlines. Nothing stale.
- **Section 3 (§ 9-11-41, dismissal and recommencement).** No page describes voluntary dismissal or
  the renewal window under Georgia law. The single near-match (ID 4721) says only that the two-year
  limitations period "doesn't pause while you re-file," which is unaffected. Nothing stale.
- **Section 4 (attorney's fees, court costs, litigation expenses).** No page describes Georgia
  fee-shifting or offer-of-settlement practice in terms Section 4 changed. The pages mentioning
  attorney's fees (1720, 1722) discuss insurance bad-faith penalties under § 33-4-6, which SB 68
  does not touch. Nothing stale.
- **§ 51-12-33 and the 50% bar.** Correct everywhere it appears. `/resources/georgia-statute-of-limitations/`
  already carries an explicit correction of the secondary-source confusion. No action.
- **Spanish (`/es/`) pages.** No Spanish page repeats the seat-belt error, the collateral-source
  claim, or the per diem claim. The only Spanish page carrying a flagged defect is **ID 4893**
  (negligent-security FAQ, finding 3b). Six of the seven flagged English pages have no Spanish twin
  at all.

## One adjacent defect, not SB 68

Post **3433** (`/blog/how-to-maximize-your-car-accident-compensation-in-georgia/`) attributes the
seat-belt argument to "O.C.G.A. § 40-8-76," which is the child-restraint section; the adult
seat-belt section is § 40-8-76.1. Post **1704** makes the same cite correctly for child restraints.
This is a pre-existing citation error, not SB 68 staleness, and the surrounding sentence — that
insurers will argue injuries were worsened by not wearing a seat belt — is now accurate. Worth
fixing whenever 3433 is next touched.
