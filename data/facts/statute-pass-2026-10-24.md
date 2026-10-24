# Statute verification pass — 2026-10-24

The owner approved this pass on 2026-10-24. It covers the 20 most-exposed unverified citations in
`data/facts/statute-inventory-2026-10-24.txt`, which is today's run of
`bin/inventory-statute-citations.php` against production (645 published documents). It follows the
Method, the two traps and the Watch items in `docs/statute-verification-tracker.md`.

**Read-only.** Nothing was changed on production, in the law packs or in the fixtures. Every
correction below is a proposal. The sentences are quoted as they render, taken from today's
production export (`data/content-cache/wp-export.json`, exported 2026-10-24T17:59Z). Where a link
wraps a citation, the raw HTML has tags inside the sentence. An apply script has to match the raw
`post_content` / meta string exactly (exact-match `str_replace` with `wp_slash`), not these
rendered quotes.

**Attorney status.**
- **GA pack: UNSIGNED for Roden** (`law-signoff.json`). Tyler Love is Roden's GA signer and his
  packet (`data/facts/ga-signoff-packet-2026-10-21.md`) is outstanding. Every GA correction below
  is advisory until he signs it. No GA authority can back a new claim yet.
- **SC pack:** signed by Graeham C. Gillin, Roden's SC signer.

## Summary

| | Count |
|---|---:|
| Sections in scope | 20 (6 SC, 14 GA) |
| Read against primary text | **20** (0 unreadable) |
| Correct as the site states them | **10**: GA 51-12-1.1, GA 9-10-184, GA 9-3-90, GA 34-9-11.1, GA 51-1-29.5 (as cited), SC 38-59-40, SC 38-59-20, SC 56-5-6160, SC 56-5-1290, SC 15-78-60 |
| Wrong or mis-cited on at least one page | **10**: GA 34-9-17, GA 34-9-200, GA 34-9-200.1, GA 9-3-73, GA 51-4-5, GA 40-6-294, GA 31-8-1, GA 4-8-20, GA 24-7-702, GA 9-11-67.1 |
| Repealed or renumbered | 0 |
| Live errors (one per sentence, table row or FAQ answer) | **66 on 34 documents**, plus 1 optional imprecision (E39, 4363). Of the 66, 44 sit next to an in-scope citation; 22 were found only by the claim-class sweeps (other sections' cells in two-state tables, uncited forms) |
| Supporting sections read in the same pass | GA 40-6-291, 34-9-261, 4-8-21, 4-8-27, 31-8-100, 31-8-108, 31-7-1; SC 42-9-60, 41-1-80, 42-15-60, 15-32-230, 15-3-530, 38-59-30, 56-5-1260, 56-5-1270, 56-5-1280 |

**The worst finding.** Post 1690 (`/blog/does-worker-compensation-cover-employee-negligence/`) gives
South Carolina a workers'-compensation rule that does not exist, and states it in five places: a
body subsection, two table cells, an OSHA paragraph, FAQ 3 and the key takeaways. The rule is that
the Commission "may reduce (but not necessarily eliminate)" benefits for a wilful safety-rule
violation, cited to S.C. Code § 42-9-60. That section has two sentences. They bar compensation for
intoxication or a wilful intention to injure or kill oneself or another, and they put the burden of
proof on the party raising the defense. Nothing in it reduces benefits and nothing in it mentions
safety rules. The SC workers'-comp pillar (3610) and post 1684 state the law correctly. This is the
second time a pass has found an invented legal standard (the first was pass 3's three-foot rule),
and the claim reaches three of the four claim surfaces (body, FAQ and its structured data, key takeaways; the excerpt is clean).

**Second worst.** The Georgia ER sub-type page (4197, `/medical-malpractice-lawyers/emergency-room-negligence/`)
says Georgia "does not lower the fundamental duty of competent care" in an emergency.
O.C.G.A. § 51-1-29.5(c) requires clear and convincing evidence of gross negligence for
emergency-department, obstetrical-unit and post-ED surgical-suite care. The sentence carries no
citation, so the citation inventory could not find it.

**A blind spot in the inventory itself.** See "The inventory under-counts FAQ citations" at the
end. It explains why `GA 34-9-17` shows 8 pages in the inventory but appears on 9, and why
`GA 9-3-90`, `SC 38-59-20` and `GA 9-11-67.1` each appear on one more page than the inventory says.

## Sources and how they were reached

- **South Carolina:** scstatehouse.gov chapter pages, fetched directly on 2026-10-24 (HTTP 200).
  t38c059, t56c005 (712 KB; curl reads all of it), t15c078, t42c009, t41c001, t42c015, t15c032 and
  t15c003. Every section was read with its HISTORY line.
- **Georgia:** codes.findlaw.com and law.justia.com both served a bot-verification page to direct
  requests today (FindLaw returned 403; Justia returned a "Just a moment…" challenge). One attempt
  to read FindLaw through a reader proxy was refused by this session's permission classifier, and
  nothing further was tried against either site. Instead the GA sections were read from **Internet
  Archive snapshots of the codes.findlaw.com pages**: the latest CDX capture for each page, fetched
  with the `id_` flag so the archived text comes back unmodified. Two sections had no FindLaw
  capture and were read from archived **law.justia.com** pages. **SB 68 (2025)** was read from the
  as-passed bill text on legis.ga.gov (`/api/legislation/document/20252026/236944`, HTTP 200).
  No identifying header was sent anywhere, and no source asked for one.
- **GA currency caveat.** Every FindLaw page read today says "Current as of March 28, 2024" (one
  says January 1, 2024). FindLaw prints no HISTORY line. As a result:
  - Changes from the 2024 session after March, and from the 2025 and 2026 sessions, are **not
    excluded** for the GA sections, except where noted. SB 68 was read in full; it amends only
    §§ 9-10-184, 9-11-12, 9-11-41, 40-8-76.1, a new Chapter 15 section, the negligent-security
    article, and new § 51-12-1.1.
  - The § 9-11-67.1 history line (from Justia) shows a 2024 amendment.
  - None of the errors below depends on a recent amendment. Each one contradicts text that has
    stood since 2013 or earlier (§ 34-9-200's 400-week limit dates to 2013).
  - Tyler Love should still confirm currency against the current official Code before he signs.

## Per statute

### 1. GA 51-12-1.1 — medical special damages (8 pages) — **correct**

- **Primary text:** SB 68 § 7, as passed (legis.ga.gov document 236944), read 2026-10-24.
  Applicability is in SB 68 § 9(b): "Sections 6 and 7 … apply only with respect to causes of
  action arising on or after the effective date". The effective date is the Governor's approval,
  2025-04-21, per the bill status recorded in `data/facts/ga-statute-currency-2026-09-30.md`.
  - (a) Medical and healthcare specials are recoverable "only as provided in this Code section".
  - (b) They are limited to "the reasonable value of medically necessary care, treatment, or
    services", determined by the trier of fact.
  - (c) If the plaintiff has any public or private health insurance (including a governmental
    workers' comp program), the evidence includes both the amounts charged and "the amounts
    actually necessary to satisfy such charges", "regardless of whether the health insurance has
    been used".
  - (d) Under a letter of protection or similar arrangement, the following are relevant and
    discoverable: the LOP, itemized and coded charges, any sale of the receivable (the buyer and
    the price), and whether and by whom the claimant was referred.
  - (e) The collateral source rule is abrogated "to the extent necessary".
  - (f) Either side may challenge reasonableness and necessity.
- **What the site says** (body, FAQ and key takeaways on 1656, 1676, 1706, 1712, 2398, 3433,
  3493, 4584):
  - The rule applies to injuries or claims arising on or after 2025-04-21.
  - Damages are limited to the reasonable value of necessary care.
  - The jury may hear both the billed amount and what insurance would pay, even if the insurance
    was not used.
  - The LOP, itemized bills, a factoring sale and its price, and the referral source are
    discoverable ((d)(3), (d)(4) cited correctly on 1712).
  - The collateral source rule is partly abrogated.
- **Verdict: correct.** Every quantity and condition matches. 2398 FAQ 4 says the defense can see
  "any lien or letter-of-protection arrangement". (d) reaches "any other arrangement" for payment
  from the recovery, so this is a fair reading.

### 2. GA 34-9-17 — willful misconduct and intoxication (8 pages in the inventory; 9 in fact) — **wrong on 4 pages**

- **Primary text:**
  - Source: codes.findlaw.com/ga/title-34-labor-and-industrial-relations/ga-code-sect-34-9-17.html
    via web.archive.org/web/20251016040643id_/…, "Current as of March 28, 2024", read 2026-10-24.
  - (a) No compensation for injury or death "due to the employee's willful misconduct, including
    intentionally self-inflicted injury, or growing out of his or her attempt to injure another, or
    for the willful failure or refusal to use a safety appliance or perform a duty required by
    statute."
  - (b) No compensation for injury or death "due to intoxication by alcohol or being under the
    influence of marijuana or a controlled substance", except as lawfully prescribed and taken:
    - (1) blood alcohol of 0.08 g or more within three hours, by chemical analysis of blood,
      urine, breath or another bodily substance, creates a rebuttable presumption of causation;
    - (2) any amount of marijuana or a controlled substance within eight hours creates a
      rebuttable presumption;
    - (3) an unjustified refusal of a test performed as § 34-9-415 provides creates a rebuttable
      presumption.
  - (c) Apart from the presumptions, the burden is on the party claiming the exemption.
  - Nothing in the section concerns retaliation or discharge.
- **What the site says:**
  - 1650 (aggressor), 1697 FAQ 3, 1761 and 3652: correct.
  - 1684: GA safety-appliance bar, correct.
  - 1662: calls it Georgia's "anti-retaliation statute".
  - 1690: says the presumption requires a drug-free workplace policy and policy-set test windows,
    that alcohol must be proven the proximate cause, and cites intoxication to (a).
  - 1693: says intoxication "at the time" is enough.
  - 1695 and 1693 FAQ 4: say intoxication and self-harm are "the only exceptions".
- **Verdict: wrong on 1662, 1690, 1693 and 1695.** Errors E1 to E10 below.

### 3. SC 38-59-40 — attorney's fees on an insurer's refusal to pay (7 pages) — **correct**

- **Primary text:** scstatehouse.gov/code/t38c059.php, read 2026-10-24.
  - (1) The insurer refuses to pay a covered claim "within ninety days after a demand has been
    made by the holder of the policy", and the trial judge finds the refusal "without reasonable
    cause or in bad faith". The insurer then owes reasonable attorneys' fees, set by the trial
    judge, which "may not exceed one-third of the amount of the judgment".
  - (2) Appellate fees.
  - (3) The Tyger River doctrine is unaffected.
  - (4) Federal cases.
  - HISTORY: recodified 1987 Act No. 155; amended 1989, 1999. No repeal.
- **What the site says** (1679, 1719, 1720, 1722, 1724, 1744, 4585): fees after a 90-day demand,
  capped at one-third of the judgment, available against the policyholder's own insurer only.
  Nichols and Tyger River are attributed to case law.
- **Verdict: correct**, including the first-party limit, which follows from "the holder of the
  policy".

### 4. SC 56-5-6160 — conviction evidence in civil actions (7 pages) — **correct (one imprecision)**

- **Primary text:** t56c005, read 2026-10-24. "No evidence of conviction of any person for any
  violation of this chapter shall be admissible in any court in any civil action." HISTORY: 1962
  Code § 46-686; 1949 (46) 466.
- **What the site says** (1679, 1740, 1790, 1831, 2586, 3239, 3386): a traffic conviction is
  inadmissible in a South Carolina civil case, and a guilty plea can still come in as an admission
  (cited to Samuel v. Mouzon).
- **Verdict: correct.** **Imprecision:** 1679, 1790 and 2586 FAQ 2 bind the *ticket* or
  *citation* to the statute ("the ticket itself is not admissible … S.C. Code § 56-5-6160"). The
  section speaks only of evidence of a *conviction* under Chapter 5. No change is proposed.
  - **For Gillin:** the guilty-plea carve-out rests on Samuel v. Mouzon, which was not read here.
    On its face the statute bars "evidence of conviction" without exception.

### 5. GA 34-9-200.1 — catastrophic injury; rehabilitation (7 pages) — **wrong on 2 pages, mis-cited on 1**

- **Primary text:**
  - Source: codes.findlaw.com …/ga-code-sect-34-9-200-1.html via
    web.archive.org/web/20250501003324id_/…, current as of 2024-03-28, read 2026-10-24.
  - (a) "In the event of a catastrophic injury, the employer shall furnish … reasonable and
    necessary rehabilitation services" (a supplier must be appointed within 48 hours, or the board
    appoints one).
  - (c) An unreasonable refusal of rehabilitation can suspend or reduce compensation.
  - (g) "Catastrophic injury" means:
    - (1) spinal cord injury with severe paralysis of an arm, a leg or the trunk;
    - (2) amputation of an arm, a hand, a foot or a leg, involving effective loss of use;
    - (3) severe brain or closed head injury (A–F);
    - (4) second- or third-degree burns over 25 percent of the body, or third-degree burns to 5
      percent or more of the face or hands;
    - (5) total or industrial blindness;
    - (6)(A) any other injury that prevents the employee from performing prior work "and any work
      available in substantial numbers within the national economy". A rebuttable presumption of
      non-catastrophic applies for up to 130 weeks if the worker is released with restrictions.
    - (6)(B) At Social Security retirement age, a rebuttable presumption arises that the injury is
      no longer catastrophic.
  - The section says nothing about income-benefit duration. That is § 34-9-261 (read today: TTD
    runs 400 weeks, or for a catastrophic injury until a change in condition for the better).
- **What the site says:**
  - 1682, 1684, 1702 and 1761: correct.
  - 1693: the list omits (g)(6). It is an example list, so this is an imprecision.
  - 1666: binds "lifetime income benefits" and, in the key takeaways, the State Board's
    administration of benefits to this section.
  - 1677: "defines" catastrophic with a closed list that omits (g)(6) and narrows (2) and (4).
- **Verdict: mis-cited on 1666 and wrong on 1677.** Errors E11 to E16.

### 6. GA 9-3-73 — medical malpractice disabilities and repose (6 pages) — **wrong on 3 pages**

- **Primary text:**
  - Source: codes.findlaw.com/ga/title-9-civil-practice/ga-code-sect-9-3-73/ via
    web.archive.org/web/20260730050635id_/…, current as of 2024-03-28, read 2026-10-24.
  - (b) Minors who have reached five are subject to the ordinary malpractice periods. "A minor who
    has not attained the age of five years shall have two years from the date of such minor's
    fifth birthday" (that is, until the seventh birthday).
  - (c) In no event may an action be brought for a minor injured before age five "after the tenth
    birthday", or for a minor injured at five or older "after five years from the date on which
    the negligent or wrongful act or omission occurred". Incompetents are cut off at five years.
  - (d) (b) is a statute of limitations; (c) is a statute of repose.
  - (e) Foreign objects are governed by § 9-3-72.
- **What the site says:**
  - 1676 table, 1696 table, 1704 and 5223: correct.
  - 1676 (body and FAQ 3) and 1696 FAQ 2: give a child under five "until the tenth birthday". That
    is the repose, not the filing deadline.
  - 4195 (body and FAQ 0): "minors generally have until their seventh birthday … subject to the
    5-year statute of repose". Under (c)(2) the repose for a child injured before five is the
    tenth birthday, not five years. And a child injured at five or older gets no seventh-birthday
    rule at all.
- **Verdict: wrong on 1676, 1696 and 4195.** Errors E17 to E21.

### 7. GA 34-9-200 — medical benefits (6 pages) — **wrong on 1 page, misquoted on 2**

- **Primary text:**
  - Source: codes.findlaw.com …/ga-code-sect-34-9-200/ via
    web.archive.org/web/20250327020225id_/…, current as of 2024-03-28, read 2026-10-24.
  - (a)(1) For injuries on or before 2013-06-30, and for catastrophic injuries under
    § 34-9-200.1(g): the employer furnishes "such medical, surgical, and hospital care and other
    treatment, items, and services which are prescribed by a licensed physician", which the board
    judges "reasonably required".
  - (a)(2) For injuries on or after 2013-07-01 that are not catastrophic: the same duty, "for a
    maximum period of 400 weeks from the date of injury".
  - (a)(3) Prosthetic, spinal-cord-stimulator, intrathecal-pump and DME maintenance and replacement
    are exempt from the 400 weeks if originally furnished within them.
  - (b) Change of physician by board order. (c) Examinations. (d) Emergency care.
- **What the site says:**
  - 1682, 1697 and 1702: the 400-week rule, correct.
  - 1677 (body, table, FAQ 1, FAQ 3 and key takeaways): "Medical benefits have no specific time
    limit" in Georgia, "for the life of the claim".
  - 1674: quotes the statute as "all medical, surgical, hospital, and other treatment". Those words
    are not in it.
  - 1752: quotes "the employee entitled thereto medical …"; the statute says "the employee entitled
    to benefits under this chapter such medical …".
  - Class sweep (uncited): 5354's comparison table says GA medical benefits are "not governed by
    these week limits".
- **Verdict: wrong on 1677 (and 5354, uncited); misquoted on 1674 and 1752.** Errors E22 to E30.
  The SC 42-15-60 cross-check (read today) found one more error in the 1674 table (E31).

### 8. GA 51-4-5 — estate administrator's action; funeral and medical expenses (5 pages) — **mis-cited on 1 page**

- **Primary text:** codes.findlaw.com/ga/title-51-torts/ga-code-sect-51-4-5.html via
  web.archive.org/web/20250321064849id_/…, current as of 2024-03-28, read 2026-10-24.
  - (a) Where no one may sue under § 51-4-2 or § 51-4-4, the administrator or executor sues and
    holds the recovery for the next of kin; the measure is the full value of the life.
  - (b) Where death results from a crime or from criminal or other negligence, the personal
    representative recovers "funeral, medical, and other necessary expenses resulting from the
    injury and death".
  - The section contains **no limitation period**. For causes of action arising on or after
    2025-04-21, the medical part of (b) is measured under § 51-12-1.1 (SB 68 § 7).
- **What the site says:**
  - 1649: the order of who may sue. Correct.
  - 1831, 3493 and 6331: the estate's expense claim. Correct.
  - 4360: "2 years for wrongful death claims (O.C.G.A. § 51-4-5)".
- **Verdict: mis-cited on 4360.** E32. The class sweep found the same deadline cited to the
  medical-malpractice section on 1823 (E33).

### 9. GA 9-3-90 — tolling for minors and incompetents (5 pages in the inventory; 6 in fact) — **correct**

- **Primary text:** codes.findlaw.com …/ga-code-sect-9-3-90/ via
  web.archive.org/web/20250616162247id_/…, current as of 2024-03-28, read 2026-10-24.
  - (a) Persons legally incompetent because of intellectual disability or mental illness when the
    action accrues get the same time after the disability is removed.
  - (b) "Except as otherwise provided in Code Section 9-3-33.1", persons under 18 when the action
    accrues get "the same time after he or she reaches the age of 18 years".
  - (c) Imprisonment transition.
- **What the site says** (1704, 1840, 4116 FAQ 4 — invisible to the inventory — 4362, 5223, 6329):
  minors are tolled until 18, so a two-year claim runs to the 20th birthday; incompetency tolls
  until the disability is removed; there is a § 9-3-33.1 exception (5223).
- **Verdict: correct.**
  - **For Tyler:** 1840 says the incompetency tolling "can apply to victims who suffer traumatic
    brain injuries". (a) requires incompetence "because of intellectual disability or mental
    illness" at accrual. Whether an injury-caused TBI qualifies is a question of case law.

### 10. GA 51-1-29.5 — emergency care: gross negligence, clear and convincing (5 pages) — **correct as cited; four class errors elsewhere**

- **Primary text:** codes.findlaw.com/ga/title-51-torts/ga-code-sect-51-1-29-5.html via
  web.archive.org/web/20250908130459id_/…, "Current as of January 01, 2024", read 2026-10-24.
  - (c) Covers a health care liability claim "arising out of the provision of emergency medical
    care in a hospital emergency department or obstetrical unit or in a surgical suite immediately
    following the evaluation or treatment of a patient in a hospital emergency department". No
    physician or health care provider is liable unless gross negligence is proven "by clear and
    convincing evidence".
  - (a)(5) "Emergency medical care" excludes care after the patient is stabilized.
  - (d) Jury instructions on the emergency circumstances.
- **What the site says** (1676, 1696, 5128, 5145, and the ES twin 5141): all correct about
  Georgia, including the stabilization limit (1676).
- **Class sweep (cited and uncited):**
  - 4197 says Georgia does not lower the duty (E34).
  - The South Carolina half of the comparison is wrong on 5145 and 5128/5141. Those pages say
    South Carolina applies "ordinary negligence" to ER care, but S.C. Code § 15-32-230 (read
    today; pack `SC 15-32-230`, signed) protects physicians in a genuine emergency unless they
    were grossly negligent (E35 to E37).
  - 1696, 4197, 4349 and 4363 state § 15-32-230 correctly.
- **Verdict: correct on the GA citation; four live errors in the claim class.**

### 11. GA 9-10-184 — arguing noneconomic damages (5 pages) — **correct**

- **Primary text:** SB 68 § 1, as passed, read 2026-10-24. It applies to pending cases (SB 68
  § 9(b), "all other provisions … shall apply to causes of action pending").
  - (a) Defines economic and noneconomic damages.
  - (b) Counsel may not argue the worth of noneconomic damages, the measure being "the
    enlightened conscience of an impartial jury".
  - (c)(1) Counsel may argue it only "after the close of evidence and at the time of such party's
    first opportunity to argue the issue of damages", "rationally related to the evidence", and
    without "reference to objects or values having no rational connection to the facts proved".
  - (c)(2) The concluding argument may not change the figure.
- **What the site says** (1651, 1676, 3433, 3493, 4584): "only in closing argument, only if
  rationally related to the evidence", "even in pending cases", and the "enlightened conscience"
  measure.
- **Verdict: correct.** 3493 paraphrases (c)(1) word for word.

### 12. SC 38-59-20 — improper claim practices (5 pages in the inventory; 6 in fact) — **correct**

- **Primary text:** t38c059, read 2026-10-24.
  - Eight listed acts by an insurer, "if committed without just cause and performed with such
    frequency as to indicate a general business practice". Third-party liability claims are
    expressly included in (2) to (8).
  - Enforcement is by the director after notice and hearing (§ 38-59-30, read today).
  - HISTORY: recodified 1987 Act No. 155.
- **What the site says** (1719, 1720, 1722, 1724, 1744, 4585): the practices listed, third-party
  claims covered, enforced by the Department of Insurance, and no private claim (Kleckley).
- **Verdict: correct.** The no-private-claim point rests on case law. The statute's
  regulator-only enforcement (§ 38-59-30) is consistent with it.

### 13. SC 56-5-1290 — crash reports not evidence (5 pages) — **correct**

- **Primary text:** t56c005, read 2026-10-24. "None of the reports required by Sections 56-5-1260
  to 56-5-1280 may be evidence of the negligence or due care of either party at the trial of any
  action at law to recover damages". Officers may refer to them to refresh their recollection.
  HISTORY: 1952 (47) 1853; 1998 Act No. 350.
  - § 56-5-1270, read today, includes the investigating officer's written report. So the TR-310
    is within § 56-5-1290 (4590).
- **What the site says** (1679, 1740, 1758, 3553, 4590): a crash report is not evidence of fault
  or negligence at trial, and an officer may use it to refresh memory.
- **Verdict: correct.**

### 14. SC 15-78-60 — exceptions to the Tort Claims Act waiver (5 pages) — **correct**

- **Primary text:** t15c078, read 2026-10-24.
  - (4) adoption or enforcement of law.
  - (5) discretion.
  - (12) licensing, except gross negligence.
  - (15) signs, signals and guardrails, unless not corrected within a reasonable time after
    "actual or constructive notice"; "not liable for the design of highways"; third-party defects
    with the same notice rule.
  - (25) supervision and custody, except gross negligence.
  - HISTORY through 2005 Act No. 137. No repeal.
- **What the site says** (1756, 3553, 4337, 4344, 4358): highway design is immune; signs and
  signals are actionable after notice ("knew or should have known"); discretionary acts are
  immune; carriage permitting falls under (4) and (12); gross negligence decides (25).
- **Verdict: correct.**
  - **Note (not in scope):** 4344 says Tort Claims Act claims "must be filed within two years
    (S.C. Code § 15-78-110)" and drops the three-year period after a verified claim. That is
    incomplete against the signed pack authority `SC 15-78-110`. Fix it with the next § 15-78-110
    re-check.

### 15. GA 24-7-702 — expert testimony (5 pages) — **one misstatement**

- **Primary text:** codes.findlaw.com/ga/title-24-evidence/ga-code-sect-24-7-702/ via
  web.archive.org/web/20250615182649id_/…, current as of 2024-03-28, read 2026-10-24.
  - (b) An expert may testify if the knowledge will help the trier of fact, and the testimony rests
    on sufficient facts or data, is the product of reliable principles and methods, and reliably
    applies them.
  - (c) In professional malpractice the expert must be licensed, and in medical malpractice must
    have actively practised or taught the specialty "for at least three of the last five years"
    and be a member of the same profession (MD/DO crossover allowed).
  - (d) Pretrial hearing.
  - (f) Courts may draw on Daubert, Joiner and Kumho.
  - (g) Not strictly applied in workers' compensation.
- **What the site says** (1647, 1705, 1718, 1758, 4363): Georgia follows Daubert or a modified
  Daubert, with sufficient facts and reliable methods.
  - 1718's key takeaways say "Georgia requires expert testimony under O.C.G.A. § 24-7-702". The
    section governs admissibility; it does not require expert testimony.
  - 4363's table says "Same or similar specialty". This is imprecise: the text requires the same
    profession and three of the last five years in the specialty.
- **Verdict: one error (E38)**, plus one imprecision with an optional fix (E39).

### 16. GA 40-6-294 — bicycle lane position (5 pages) — **mis-cited on 5 pages**

- **Primary text:** codes.findlaw.com/ga/title-40-motor-vehicles-and-traffic/ga-code-sect-40-6-294/
  via web.archive.org/web/20260420205302id_/…, current as of 2024-03-28, read 2026-10-24.
  - (a) Defines hazards to safe cycling.
  - (b) Ride as near the right side as practicable, except when turning left, avoiding hazards, the
    lane is too narrow to share safely, travelling at traffic speed, passing, or not turning right
    from a right-turn-only lane.
  - (c) No more than two abreast.
  - (d) and (e) Mandatory bike paths.
  - (f) Ride with traffic in a bike lane.
  - **It does not grant cyclists the rights of vehicle drivers.** That is **§ 40-6-291(a)** (read
    today): "The provisions of this chapter that apply to vehicles, but not exclusively to motor
    vehicles, shall apply to bicycles".
- **What the site says:**
  - 4087 (body): full-lane use when the lane is too narrow. Correct.
  - 4087 FAQ 0, 4171, 4172 (body and FAQ 3), 4173 (body and FAQ 2) and 4178 cite § 40-6-294 for
    "the same rights and duties as motor vehicle operators", for right of way at intersections,
    and for drivers having to yield to cyclists.
- **Verdict: mis-cited on 5 pages.** Errors E40 to E46. Swap in § 40-6-291 for the rights clause.

### 17. GA 31-8-1 — Hospital Care for the Indigent Program (5 pages) — **mis-cited on 5 pages**

- **Primary text:** codes.findlaw.com/ga/title-31-health/ga-code-sect-31-8-1/ via
  web.archive.org/web/20250324065610id_/…, current as of 2024-03-28, read 2026-10-24.
  - § 31-8-1 establishes "a Hospital Care for the Indigent Program to be administered by the
    Department of Community Health" to help counties buy hospital care for people who cannot pay.
  - Read today in support:
    - § 31-8-100 (the short title, "Bill of Rights for Residents of Long-term Care Facilities").
    - § 31-8-108 (care "adequate and appropriate", "with reasonable care and skill", "in compliance
      with applicable laws and regulations"; residents may refuse medications).
    - § 31-7-1 (Chapter 7 definitions. "Institution" includes a building "classified by the
      department … as either a hospital, nursing home, assisted living community, or personal care
      home").
  - There is no "Georgia Long-Term Care Facility Licensing Act" in what was read. Nursing-home
    regulation is Chapter 7; the residents' bill of rights is Article 4 of Chapter 8.
- **What the site says:** 4163, 4164, 4165 and 4170 call "§ 31-8-1 et seq." the "Georgia
  Long-Term Care Facility Licensing Act" or "licensing requirements" with staffing and medication
  standards. 4166 says it "provides a regulatory framework for nursing home accountability".
- **Verdict: mis-cited on 4163, 4164, 4165 and 4170; imprecise on 4166.** Errors E47 to E51. The
  class sweep found E52 (4168, assisted living).

### 18. GA 4-8-20 — Responsible Dog Ownership Law (5 pages) — **substantive errors on 3 pages**

- **Primary text:** codes.findlaw.com/ga/title-4-animals/ga-code-sect-4-8-20.html via
  web.archive.org/web/20240529120551id_/…, current as of 2024-03-28, read 2026-10-24.
  - § 4-8-20 is the short title only ("Responsible Dog Ownership Law").
  - Read today in support: § 4-8-21 (definitions) and § 4-8-27 (registration requirements).
  - § 4-8-21(a)(2), "dangerous dog":
    - (A) causes a substantial puncture of skin without serious injury (a nip, scratch or abrasion
      is not enough);
    - (B) aggressively attacks so as to cause a reasonable belief of an imminent threat of serious
      injury "although no such injury occurs";
    - (C) kills a pet animal while off the owner's property (working dogs excepted).
  - § 4-8-21(a)(6), "vicious dog": inflicts serious injury on a person, or causes serious injury
    from reasonable attempts to escape. "Serious injury" includes death ((a)(5)).
  - § 4-8-21(b): no classification if the injured person was trespassing, abusing the dog or
    committing a Chapter 5 Title 16 offense.
  - § 4-8-27(b), dangerous dog: secure enclosure and warning signs.
  - § 4-8-27(c), vicious dog: enclosure, signs, microchip, and "liability insurance in the amount
    of at least $50,000.00".
- **What the site says:**
  - 4115, 4118 and 4119 FAQ 1: correct in general terms.
  - 4117: insurance for both classes.
  - 4119: defines "dangerous" with a "potentially dangerous" tier that is not in § 4-8-21, adds
    "without provocation" to "vicious", and requires $50,000 insurance "or a surety bond" for
    *dangerous* dogs.
  - 4120: "aggressive behavior toward other animals is a factor".
- **Verdict: wrong on 4117, 4119 and 4120.** Errors E53 to E57.
  - **For Tyler:** 4119's "kept muzzled and leashed when off the owner's property" and its
    euthanasia sentence rest on sections not read today (§§ 4-8-28 to 4-8-30).

### 19. GA 34-9-11.1 — third-party actions; subrogation lien (5 pages) — **correct**

- **Primary text:** law.justia.com/codes/georgia/title-34/chapter-9/article-1/section-34-9-11-1/
  (2023 edition) via web.archive.org/web/20241213155305id_/…, read 2026-10-24. No FindLaw capture
  exists for this page.
  - (b) The lien is limited to "disability benefits, death benefits, and medical expenses paid",
    "only recoverable if the injured employee has been fully and completely compensated".
  - (c) If the employee has not sued within one year after the date of injury, the employer or
    insurer may sue.
  - (d) A reasonable fee for the employee's attorney, apportioned if the carrier has its own
    counsel.
- **What the site says** (1650, 1706, 1711, 1782, 4113): matches (b), (c) and (d).
- **Verdict: correct.**

### 20. GA 9-11-67.1 — pre-answer motor-vehicle settlement offers (5 pages in the inventory; 6 in fact) — **one error**

- **Primary text:** law.justia.com/codes/georgia/title-9/chapter-11/article-8/section-9-11-67-1/
  via web.archive.org/web/20241006050631id_/…, read 2026-10-24.
  - **History line:** "Amended by 2024 Ga. Laws 415, § 1, eff. 4/22/2024, app. to any offers to
    settle … made on or after 4/22/2024". 2021 Ga. Laws 203; 2013 Ga. Laws 271.
  - (b) From accrual until the answer, an attorney-prepared offer must be in writing, with these
    material terms:
    - acceptance not less than 30 days from receipt;
    - the amount;
    - the releasees;
    - full or limited release with an itemization;
    - the claims released;
    - payment not less than 40 days from receipt;
    - a sworn insurance-disclosure statement (waivable).
  - (b)(2) The offer must enclose the medical records needed to evaluate the claim.
  - (g) Certified mail or overnight delivery, referencing the section.
  - (i) Safe harbor if the recipient accepts and pays the lesser of the demand or the limits.
    (i)(3): no safe harbor for later offers after non-compliance with a (b) offer.
  - (j) Product liability excluded.
  - The FindLaw capture (current to 2024-03-28) is the pre-2024 text and was not relied on.
- **What the site says** (1656, 1719 — invisible to the inventory — 1720, 1722, 1724, 1744): 30
  days to accept and 40 to pay, the material terms, enclosed records, motor-vehicle and
  attorney-prepared only. 1722 adds "as amended by SB 83, effective July 1, 2024".
- **Verdict: one error.** The 2024 amendment took effect **2024-04-22**, not July 1 (E58).
  Everything else matches.

## Errors: published sentence, correction, authority

Fields:
- `body` = `post_content`
- `FAQ n` = the nth entry (0-based) of `_roden_faqs`, which also renders as FAQPage structured data
- `KT` = `_roden_key_takeaways`

"Authority" names the pack id where one exists (pending = unsigned; GA = advisory until Tyler signs).
Otherwise it names the section read today, with its URL above; those are candidates for a pack PR.

### GA 34-9-17 (workers' comp defenses) — Tyler Love

**E1. 1662** `/blog/what-to-do-if-your-workers-compensation-claim-is-denied/`, body
- Published: "If your employer retaliates against you for filing a workers' compensation claim, we can protect your rights under Georgia's anti-retaliation statute (O.C.G.A. § 34-9-17) or South Carolina's corresponding protections."
- Corrected: "If your employer retaliates against you for filing a workers' compensation claim in South Carolina, we can protect your rights under S.C. Code § 41-1-80, which bars an employer from discharging or demoting an employee for a good-faith claim; in Georgia, O.C.G.A. § 34-9-17 is not a retaliation statute, and a worker's options depend on the facts."
- Authority: GA 34-9-17 (pending) for what § 34-9-17 says; SC 41-1-80 (read today, not in pack).
- **Attorney:** Tyler, on what Georgia offers; post 1697 FAQ 3 says Georgia has none (Evans v. Bibb Co.).

**E2. 1662**, FAQ 3
- Published: "No. Both Georgia (O.C.G.A. § 34-9-17) and South Carolina have anti-retaliation protections for workers who file compensation claims. If your employer retaliates against you for filing a claim, you may have additional legal remedies available."
- Corrected: "In South Carolina, no: S.C. Code § 41-1-80 bars an employer from discharging or demoting an employee for instituting a workers' compensation proceeding in good faith, with lost wages and reinstatement as remedies and a one-year deadline. Georgia's O.C.G.A. § 34-9-17 is not an anti-retaliation law; it sets the grounds for denying compensation. Talk to a lawyer about the facts of a Georgia firing."
- Authority: as E1. **Attorney:** Tyler (GA), Gillin (SC § 41-1-80 summary).

**E3. 1690** `/blog/does-worker-compensation-cover-employee-negligence/`, body (subheading)
- Published: "Intoxication Defense (O.C.G.A. § 34-9-17(a))"
- Corrected: "Intoxication Defense (O.C.G.A. § 34-9-17(b))"
- Authority: GA 34-9-17 (pending).

**E4. 1690**, body (bullet list under "Key points about Georgia's intoxication defense")
- Published bullets:
  - "The employer must have a drug-free workplace policy in place"
  - "The test must be conducted within the time frames specified by the policy"
  - "Alcohol intoxication must be proven to be the proximate cause of the injury"
- Corrected bullets:
  - "The presumption rests on a chemical test of blood, urine, breath or another bodily substance"
  - "The statute sets the windows: alcohol at 0.08 or more within three hours of the accident, or any marijuana or controlled substance within eight hours"
  - "The intoxication must have caused the injury, but a qualifying test result shifts that question to you through a rebuttable presumption"
- Authority: GA 34-9-17 (pending), (b)(1) to (3).

**E5. 1690**, FAQ 2
- Published: "The employer must have a drug-free workplace policy in place, and the test must follow proper protocols."
- Corrected: "The presumption applies to any amount of marijuana or a controlled substance found within eight hours of the accident, or alcohol at 0.08 or more within three hours, shown by a chemical test of blood, urine, breath or another bodily substance."
- Authority: GA 34-9-17 (pending).

**E6. 1693** `/blog/am-i-eligible-for-workers-compensation/`, body (list item)
- Published: "Intoxication defense: If the employer proves you were intoxicated at the time of the injury, benefits can be denied (O.C.G.A. § 34-9-17)"
- Corrected: "Intoxication defense: If the employer proves the injury was caused by intoxication, benefits can be denied; a blood alcohol level of 0.08 or more within three hours, or any marijuana or controlled substance within eight hours, creates a rebuttable presumption that it was (O.C.G.A. § 34-9-17(b))"
- Authority: GA 34-9-17 (pending). The attorney's 2026-10-20 revision note on that entry asks for the causation element.

**E7. 1693**, FAQ 4 (uncited form)
- Published: "The only exceptions are injuries caused by intoxication (which both Georgia and South Carolina recognize as grounds for denial) or intentional self-harm."
- Corrected: "The exceptions are narrow: injuries caused by intoxication or by a willful intent to injure yourself or someone else, which both Georgia and South Carolina recognize as grounds for denial, and in Georgia other willful misconduct, such as a willful refusal to use a required safety appliance."
- Authority: GA 34-9-17 (pending); SC 42-9-60 (signed).

**E8. 1695** `/blog/should-i-file-a-personal-injury-or-a-workers-compensation-claim/`, body
- Published: "The only exceptions are intoxication (O.C.G.A. § 34-9-17; S.C. Code § 42-9-60) and intentional self-harm."
- Corrected: "The exceptions are narrow: intoxication and a willful intent to injure yourself or another bar benefits in both states (O.C.G.A. § 34-9-17; S.C. Code § 42-9-60), and Georgia also bars benefits for other willful misconduct, including a willful refusal to use a safety appliance."
- Authority: GA 34-9-17 (pending); SC 42-9-60 (signed).
- **Attorney:** Tyler, on whether the preceding sentence ("ignored a safety rule — you are still eligible") also needs a Georgia qualifier.

### SC 42-9-60, as published on 1690 (the invented safety-rule reduction) — Graeham C. Gillin

These sit on the GA 34-9-17 page's comparison and were found by the claim-class sweep. Authority
for all of them is **SC 42-9-60 (signed)**: "No compensation shall be payable if the injury or
death was occasioned by the intoxication of the employee or by the wilful intention of the employee
to injure or kill himself or another", with the burden on the party claiming it (t42c009, read
2026-10-24; HISTORY: 2007 Act No. 111).

**E9. 1690**, body: the subsection "Willful Violation of Safety Rules (S.C. Code § 42-9-60)" and
the SC intoxication paragraph before it.
- Published:
  - "Similar to Georgia, if the employer has a substance abuse policy and the employee tests positive post-accident, a presumption may apply."
  - "South Carolina specifically addresses safety rule violations. Under S.C. Code § 42-9-60, if an employee's injury is caused by their willful failure to use a safety device or obey a safety rule required by statute or deliberately adopted by the employer, the Workers' Compensation Commission may reduce (but not necessarily eliminate) the employee's compensation."
  - The "Important: … The employer must prove: …" list that follows.
- Corrected:
  - "Unlike Georgia's, § 42-9-60 creates no presumption: the employer must prove that intoxication caused the injury."
  - "South Carolina's statute has no safety-rule defense. Section 42-9-60 bars compensation only for intoxication or a wilful intention to injure or kill oneself or another, and it does not reduce benefits for a safety-rule violation."
  - Delete the "Important" list. It describes the elements of a defense the statute does not contain.
- **Rule 6:** this is a subsection rewrite, not a sentence swap. 1690 is outside its 90-day window
  (ledger: last tracked change 2022-04-07). It still needs the owner's call on scope.
- **Attorney:** Gillin, to confirm that no other SC provision or regulation reduces benefits for a
  safety-rule violation.

**E10. 1690**, body table, two SC cells, plus the OSHA paragraph, FAQ 3 and the key takeaways
- Published (table): "Willful misconduct | Full denial (O.C.G.A. § 34-9-17) | Reduction of benefits (S.C. Code § 42-9-60)"
  - Corrected SC cell: "Denial only for a wilful intention to injure or kill oneself or another (S.C. Code § 42-9-60)"
- Published (table): "Safety rule violation | Must be willful, not negligent | May reduce (not eliminate) benefits if willful"
  - Corrected cells: GA "Willful failure or refusal to use a safety appliance bars benefits (O.C.G.A. § 34-9-17(a))" | SC "Not a defense (S.C. Code § 42-9-60)"
- Published (body): "Only a willful violation of a specific employer safety rule may reduce benefits in South Carolina — and even then, it does not eliminate them."
  - Corrected: "In Georgia, only a willful refusal to use a safety appliance or perform a statutory duty bars benefits (O.C.G.A. § 34-9-17(a)); South Carolina's act has no safety-rule defense (S.C. Code § 42-9-60)."
- Published (FAQ 3, Q "Can South Carolina reduce my benefits for violating a safety rule?"): "Yes, but only for a willful violation. Under S.C. Code § 42-9-60, if you deliberately failed to use a safety device or obey a specific safety rule, the Workers' Compensation Commission may reduce (not eliminate) your compensation. The employer must prove the rule existed, you knew about it, you deliberately chose not to follow it, and the violation caused the injury. Simple forgetfulness or …"
  - Corrected: "No. S.C. Code § 42-9-60 bars compensation only when the injury was caused by intoxication or by a wilful intention to injure or kill yourself or another, and the employer bears the burden of proving it. The statute contains no reduction for a safety-rule violation."
- Published (KT): "South Carolina may reduce benefits for willful safety rule violations but cannot eliminate them."
  - Corrected: "South Carolina's act has no safety-rule defense (S.C. Code § 42-9-60)."
- The FAQ answer renders into FAQPage structured data. Patch it with `bin/apply-faq-remediation.php`.

### GA 34-9-200.1 (catastrophic injury) — Tyler Love

**E11. 1666** `/blog/the-role-of-vocational-rehabilitation-in-workers-compensation-cases/`, body
- Published: "Under O.C.G.A. § 34-9-200.1 , workers with catastrophic injuries (such as spinal cord injuries , traumatic brain injuries , amputations, or severe burns) are entitled to lifetime income benefits and typically receive more extensive vocational rehabilitation services."
- Corrected: "Under O.C.G.A. § 34-9-200.1, the employer must furnish rehabilitation services to a worker with a catastrophic injury (such as spinal cord injuries, traumatic brain injuries, amputations, or severe burns), and a catastrophic injury lifts the 400-week limit on income benefits (O.C.G.A. § 34-9-261)."
- Authority: § 34-9-200.1(a), (g) and GA 34-9-261 (pack; read today).

**E12. 1666**, body table
- Published: "Catastrophic injury provision | O.C.G.A. § 34-9-200.1 (lifetime benefits)"
- Corrected: "Catastrophic injury provision | O.C.G.A. § 34-9-200.1 (rehabilitation; no 400-week cap on income benefits, § 34-9-261)"

**E13. 1666**, FAQ 2
- Published: "… Georgia recognizes a catastrophic injury designation under O.C.G.A. § 34-9-200.1 that provides lifetime benefits."
- Corrected: "… Georgia recognizes a catastrophic injury designation under O.C.G.A. § 34-9-200.1 that requires rehabilitation services and lifts the 400-week cap on income benefits (O.C.G.A. § 34-9-261)."

**E14. 1666**, KT
- Published: "Georgia administers benefits through the State Board of Workers' Compensation under O.C.G.A. § 34-9-200.1, while South Carolina uses the Workers' Compensation Commission under Title 42."
- Corrected: "Georgia administers benefits through the State Board of Workers' Compensation and requires rehabilitation services for catastrophic injuries (O.C.G.A. § 34-9-200.1), while South Carolina uses the Workers' Compensation Commission under Title 42."

**E15. 1677** `/blog/when-does-workers-compensation-stop-paying/`, body
- Published: "Duration: PTD benefits continue for the lifetime of the injured worker for catastrophic injuries — defined as spinal cord injuries causing paralysis, amputation of major limbs, severe traumatic brain injury , severe burns to more than 25% of the body, or total blindness (O.C.G.A. § 34-9-200.1)"
- Corrected: "Duration: for catastrophic injuries, income benefits are not cut off at 400 weeks and continue until the worker's condition changes for the better (O.C.G.A. § 34-9-261). Catastrophic injuries include spinal cord injuries with severe paralysis, amputation of an arm, hand, foot or leg, severe brain injuries, second- or third-degree burns over 25% of the body or third-degree burns to 5% of the face or hands, total or industrial blindness, and any injury that keeps you from your prior work and any work available in substantial numbers in the national economy (O.C.G.A. § 34-9-200.1(g))"
- Authority: § 34-9-200.1(g); GA 34-9-261.

**E16. 1677**, FAQ 3
- Published: "In Georgia, catastrophic injuries — spinal cord injuries causing paralysis, amputation of major limbs, severe brain injury, severe burns, or total blindness — qualify for lifetime benefits (O.C.G.A. § 34-9-200.1)."
- Corrected: "In Georgia, catastrophic injuries — including severe paralysis, amputation of an arm, hand, foot or leg, severe brain injury, severe burns, total or industrial blindness, and any injury that keeps you from your prior work and any other work available in substantial numbers — are not subject to the 400-week cap (O.C.G.A. §§ 34-9-200.1, 34-9-261)."
- *(Same FAQ also carries E25.)* Optional, on 1693: add "or an injury that keeps you from any work" to the parenthetical list (imprecision, not counted).

### GA 9-3-73 (malpractice: minors) — Tyler Love

Authority for all of these: GA 9-3-71 (pack). Its claim already reads "Minors under five have until
two years after their fifth birthday, with repose at age ten (§ 9-3-73)". The section text was read
today.

**E17. 1676** `/blog/medical-malpractice-limits-georgia/`, body
- Published: "A child under five at the time of the malpractice has until the tenth birthday (O.C.G.A. § 9-3-73)."
- Corrected: "A child under five at the time of the malpractice has two years from the fifth birthday to sue, and in no event after the tenth birthday (O.C.G.A. § 9-3-73)."

**E18. 1676**, FAQ 3
- Published: "Children under five at the time of the malpractice have until their tenth birthday (O.C.G.A. § 9-3-73)."
- Corrected: "Children under five at the time of the malpractice have until two years after their fifth birthday, and never after their tenth (O.C.G.A. § 9-3-73)."

**E19. 1696** `/blog/what-if-i-suspect-medical-malpractice/`, FAQ 2
- Published: "A five-year statute of repose applies to everything except foreign-object cases and children injured before age five, who have until their tenth birthday (O.C.G.A. § 9-3-73)."
- Corrected: "A five-year statute of repose applies to everything except foreign-object cases and children injured before age five, who must sue within two years after their fifth birthday and never after their tenth (O.C.G.A. § 9-3-73)."

**E20. 4195** `/medical-malpractice-lawyers/birth-injury/`, body
- Published: "In Georgia, minors generally have until their seventh birthday to file a medical malpractice claim, subject to the 5-year statute of repose (O.C.G.A. § 9-3-73)."
- Corrected: "In Georgia, a child injured before age five has until the seventh birthday to file a medical malpractice claim, and in no event after the tenth birthday (O.C.G.A. § 9-3-73)."

**E21. 4195**, FAQ 0
- Published: "In Georgia, minors generally have until their seventh birthday to file a medical malpractice claim (O.C.G.A. § 9-3-73), subject to the 5-year statute of repose."
- Corrected: "In Georgia, a child injured before age five has until the seventh birthday to file a medical malpractice claim, and in no event after the tenth birthday (O.C.G.A. § 9-3-73)."

### GA 34-9-200 (medical benefits) — Tyler Love; SC halves Graeham C. Gillin

Authority: § 34-9-200(a)(1)–(2), read today (not in pack; candidate). The SC halves use SC 42-15-60,
read today (tracker-verified, pass 4).

**E22. 1677**, body
- Published: "Georgia: Medical benefits have no specific time limit. The employer/insurer must provide all reasonable and necessary medical treatment for the life of the claim (O.C.G.A. § 34-9-200)."
- Corrected: "Georgia: For injuries on or after July 1, 2013, medical benefits last up to 400 weeks from the date of injury unless the injury is catastrophic, in which case they have no time limit (O.C.G.A. § 34-9-200)."

**E23. 1677**, body table
- Published: "Medical benefits | No time limit | No time limit"
- Corrected: "Medical benefits | 400 weeks from injury; no limit if catastrophic or injured before July 1, 2013 (O.C.G.A. § 34-9-200) | While the Commission finds treatment will lessen disability; can end after a settlement or a one-year gap in treatment (S.C. Code § 42-15-60)"
- These are the cells post 1682 already uses.

**E24. 1677**, FAQ 1
- Published: "In both Georgia and South Carolina, medical benefits have no specific time limit ."
- Corrected: "Medical benefits outlast wage benefits but are not unlimited: in Georgia they last up to 400 weeks from the injury unless the injury is catastrophic (O.C.G.A. § 34-9-200), and in South Carolina they continue while the Commission finds treatment will lessen the disability (S.C. Code § 42-15-60)."

**E25. 1677**, FAQ 3 (final sentence) and KT
- Published (both): "Medical benefits have no time limit in either state."
- Corrected (both): "Georgia medical benefits last up to 400 weeks from the injury unless the injury is catastrophic (O.C.G.A. § 34-9-200); South Carolina's continue while the Commission finds treatment will lessen the disability (S.C. Code § 42-15-60)."
- (Two surfaces, counted as two errors.)

**E26. 1677**, body (SC sentence next to E22)
- Published: "There is no automatic cutoff date."
- Corrected: "Treatment can end one year after a settlement on the Commission's permanent-disability form is paid in full, or after a lapse of more than a year in authorized treatment (S.C. Code § 42-15-60(B))."
- **Attorney:** Gillin.

**E27. 5354** `/resources/georgia-vs-south-carolina-workers-compensation/`, body table (uncited form)
- Published: "Medical benefits | not governed by these week limits |" — the SC cell is missing and the row runs into the next heading.
- Corrected GA cell: "up to 400 weeks from injury unless catastrophic (O.C.G.A. § 34-9-200)". The SC cell needs restoring from the page's source.
- **Rule 6:** 5354 is inside its window (doNotTouchBefore 2026-11-23). This is a one-cell legal
  correction and is allowed. If restoring the broken row needs more than the cell, leave the rest
  to the owner.

**E28. 1674** `/blog/does-workers-compensation-cover-prescriptions/`, body
- Published: "Georgia's workers' compensation system is governed by O.C.G.A. § 34-9-200, which requires employers to provide "all medical, surgical, hospital, and other treatment" that is reasonably necessary for the work-related injury."
- Corrected: "Georgia's workers' compensation system is governed by O.C.G.A. § 34-9-200, which requires employers to furnish the "medical, surgical, and hospital care and other treatment, items, and services which are prescribed by a licensed physician" and reasonably required for the work injury — for injuries on or after July 1, 2013, for up to 400 weeks unless the injury is catastrophic."

**E29. 1752** `/blog/workers-comp-medical-coverage/`, body
- Published: "Under Georgia law (O.C.G.A. § 34-9-200), employers must furnish "the employee entitled thereto medical, surgical, and hospital care and other treatment, items, and services which are prescribed by a licensed physician.""
- Corrected: "Under Georgia law (O.C.G.A. § 34-9-200), employers must furnish "the employee entitled to benefits under this chapter such medical, surgical, and hospital care and other treatment, items, and services which are prescribed by a licensed physician," for up to 400 weeks from injury for non-catastrophic injuries on or after July 1, 2013."

**E30. 1674**, FAQ 0
- Published: "Both Georgia (O.C.G.A. § 34-9-200) and South Carolina (S.C. Code § 42-15-60) require employers to provide all necessary medical treatment, including prescriptions."
- Corrected: "Both Georgia (O.C.G.A. § 34-9-200) and South Carolina (S.C. Code § 42-15-60) require employers to provide necessary medical treatment, including prescriptions; in Georgia that duty lasts up to 400 weeks from the injury unless the injury is catastrophic."

**E31. 1674**, body table (two-state cross-check)
- Published: "Physician selection | Employer panel (O.C.G.A. § 34-9-201) | Employee choice"
- Corrected SC cell: "Employer may furnish the attending physician (S.C. Code § 42-15-60)"
- § 42-15-60(A): "the employer, at his own option, may continue to furnish … and the employee
  shall accept, an attending physician". Post 1752 already says the SC employer "initially selects
  the treating physician".
- **Attorney:** Gillin.

### GA 51-4-5 and the wrongful-death deadline class — Tyler Love

Authority: GA 9-3-33 (pack). E32 and E33 are citation swaps; each page's other GA wrongful-death
sentences already cite § 9-3-33.

**E32. 4360** `/blog/summer-dui-accidents-charleston-memorial-day-labor-day/`, body
- Published: "Georgia — 2 years from the date of the accident for personal injury claims (O.C.G.A. § 9-3-33) and 2 years for wrongful death claims (O.C.G.A. § 51-4-5)"
- Corrected: "Georgia — 2 years from the date of the accident for personal injury claims and 2 years from the date of death for wrongful death claims (O.C.G.A. § 9-3-33)"

**E33. 1823** `/blog/driving-tips-around-trucks/`, body (class sweep)
- Published: "For wrongful death claims , the deadline is also 2 years from the date of death (O.C.G.A. § 9-3-71)."
- Corrected: "For wrongful death claims, the deadline is also 2 years from the date of death (O.C.G.A. § 9-3-33)."
- § 9-3-71 is the medical-malpractice period. 1676's use of it is correct because 1676 is a
  malpractice page.

### Emergency-care standard (GA 51-1-29.5 class; SC 15-32-230) — Tyler Love (GA), Graeham C. Gillin (SC)

**E34. 4197** `/medical-malpractice-lawyers/emergency-room-negligence/`, body (uncited)
- Published: "Georgia law considers the emergency circumstances but does not lower the fundamental duty of competent care."
- Corrected: "In Georgia, a claim arising from emergency medical care in a hospital emergency department or obstetrical unit, or in a surgical suite immediately after emergency-department care, requires clear and convincing evidence of gross negligence (O.C.G.A. § 51-1-29.5)."
- Authority: § 51-1-29.5(c), read today (candidate).

**E35. 5145** `/blog/medical-malpractice-examples/`, body
- Published: "South Carolina holds ER care to ordinary negligence, so the same facts can qualify more readily there."
- Corrected: "South Carolina's rule is narrower: it protects only physicians, and only for a genuine emergency while the patient is unstable and in the emergency department or an obstetrical or surgical suite, where the physician is liable only if grossly negligent (S.C. Code § 15-32-230)."
- Authority: SC 15-32-230 (signed).
- **Rule 6:** 5145 is inside its window (doNotTouchBefore 2026-12-08). A one-sentence legal
  correction is allowed.

**E36. 5128** `/blog/can-you-sue-hospital-negligence/`, body table, SC cell
- Published: "ER-care standard | Gross negligence, clear and convincing (O.C.G.A. § 51-1-29.5) | Ordinary standard of care"
- Corrected SC cell: "Ordinary standard for the hospital; gross negligence for a physician in a genuine emergency while the patient is unstable (S.C. Code § 15-32-230)"
- Authority: SC 15-32-230 (signed; the pack notes "it says nothing about hospitals").
- **Rule 6:** 5128 is waiting until 2026-12-08. This is a one-cell correction.

**E37. 5141** `/es/blog/can-you-sue-hospital-negligence/` (ES twin), body table, SC cell
- Published: "Estándar en sala de emergencias | Negligencia grave, evidencia clara y convincente (O.C.G.A. § 51-1-29.5) | Estándar de cuidado ordinario"
- Corrected SC cell: "Estándar ordinario para el hospital; negligencia grave para el médico en una emergencia genuina mientras el paciente está inestable (S.C. Code § 15-32-230)"
- The wording needs a Spanish review. The window passed on 2026-10-22.

### GA 24-7-702 — Tyler Love

**E38. 1718** `/blog/continuing-post-accident-medical-treatment/`, KT
- Published: "Georgia requires expert testimony under O.C.G.A. § 24-7-702."
- Corrected: "Georgia tests expert testimony for reliability under O.C.G.A. § 24-7-702."
- Authority: § 24-7-702(b), read today.

**E39. 4363** `/blog/emergency-room-errors-charleston-misdiagnosis-malpractice/`, body table, GA cell (optional; imprecision)
- Published: "Same or similar specialty (O.C.G.A. Section 24-7-702)"
- Corrected: "Same profession, with active practice or teaching in the specialty for 3 of the last 5 years (O.C.G.A. Section 24-7-702(c))"

### GA 40-6-294 → § 40-6-291 (cyclist rights) — Tyler Love

Authority: § 40-6-291(a), read today (candidate). Each of these is a citation swap, plus the
narrowest wording change where the sentence binds a rule § 40-6-291 does not state.

**E40. 4087** `/practice-areas/bicycle-accident-lawyers/`, FAQ 0
- Published: "Georgia law (O.C.G.A. § 40-6-294) and South Carolina law grant bicyclists the same rights and duties as motor vehicle operators."
- Corrected: "Georgia law (O.C.G.A. § 40-6-291) and South Carolina law grant bicyclists the same rights and duties as other vehicle operators."

**E41. 4171** `/bicycle-accident-lawyers/dooring-accident/`, body
- Published: "Additionally, Georgia's bicycle-specific protections under O.C.G.A. § 40-6-294 grant cyclists the same rights and duties as vehicle drivers, meaning they have a right to use the roadway without being endangered by negligently opened doors."
- Corrected: replace "O.C.G.A. § 40-6-294" with "O.C.G.A. § 40-6-291". The rest stands.

**E42. 4172** `/bicycle-accident-lawyers/right-hook-left-cross-collision/`, body
- Published: "Georgia: Under O.C.G.A. § 40-6-294 , cyclists have the same rights and duties as drivers of motor vehicles."
- Corrected: "Georgia: Under O.C.G.A. § 40-6-291, the traffic rules for vehicles apply to cyclists."

**E43. 4172**, FAQ 3
- Published: "Both Georgia (O.C.G.A. § 40-6-294) and South Carolina (S.C. Code § 56-5-3435) grant cyclists the same rights and duties as motor vehicle drivers."
- Corrected: replace "§ 40-6-294" with "§ 40-6-291".
- The SC citation was verified in pass 3 for the passing distance, not for equal rights. Gillin
  should look at it on the next SC re-check.

**E44. 4173** `/bicycle-accident-lawyers/intersection-bicycle-accident/`, body
- Published: "Georgia: O.C.G.A. § 40-6-294 provides cyclists the same rights as vehicle drivers at intersections."
- Corrected: "Georgia: O.C.G.A. § 40-6-291 applies the vehicle traffic rules, including those at intersections, to cyclists."

**E45. 4173**, FAQ 2
- Published: "Under Georgia law (O.C.G.A. § 40-6-294) and South Carolina law (S.C. Code § 56-5-3435), cyclists may use the full lane, have the right of way when traveling with a green signal, and must be yielded to by turning vehicles."
- Corrected: "Georgia applies its vehicle traffic rules to cyclists (O.C.G.A. § 40-6-291) and lets a cyclist leave the right edge when the lane is too narrow to share safely (O.C.G.A. § 40-6-294(b)); in both states cyclists have the right of way when traveling with a green signal and must be yielded to by turning vehicles."
- The SC citation is left for Gillin, as in E43.

**E46. 4178** `/bicycle-accident-lawyers/bicycle-vs-truck-accident/`, body
- Published: "Georgia: O.C.G.A. § 40-6-294 grants cyclists the same rights as motor vehicles."
- Corrected: "Georgia: O.C.G.A. § 40-6-291 applies the vehicle traffic rules to cyclists."

### GA 31-8-1 (nursing-home statutes) — Tyler Love

Authority: §§ 31-7-1, 31-8-100 and 31-8-108, read today (candidates).

**E47. 4163** `/nursing-home-abuse-lawyers/physical-abuse-nursing-home/`, body
- Published: "Georgia: The O.C.G.A. § 31-8-1 et seq. (Georgia Long-Term Care Facility Licensing Act) establishes licensing standards and a resident bill of rights."
- Corrected: "Georgia: Nursing homes are regulated as institutions under O.C.G.A. § 31-7-1 et seq., and the Bill of Rights for Residents of Long-term Care Facilities (O.C.G.A. § 31-8-100 et seq.) entitles residents to care provided "with reasonable care and skill" (O.C.G.A. § 31-8-108)."

**E48. 4164** `/nursing-home-abuse-lawyers/nursing-home-neglect/`, body
- Published: "Georgia's nursing home licensing requirements under O.C.G.A. § 31-8-1 et seq. mandate minimum standards of care and staffing."
- Corrected: "Georgia regulates nursing homes under O.C.G.A. § 31-7-1 et seq., and its residents' bill of rights requires care that is "adequate and appropriate" and provided "with reasonable care and skill" (O.C.G.A. § 31-8-108)."
- **Attorney:** Tyler, on the staffing standard (rules under Chapter 7, not read).

**E49. 4165** `/nursing-home-abuse-lawyers/medication-error-nursing-home/`, body
- Published: "Georgia: O.C.G.A. § 31-8-1 et seq. requires licensed facilities to maintain proper medication administration procedures and qualified nursing staff."
- Corrected: "Georgia: residents of long-term care facilities are entitled to care provided "with reasonable care and skill" and "in compliance with applicable laws and regulations," and may refuse medications (O.C.G.A. § 31-8-108)."
- **Attorney:** Tyler, on medication-administration rules (not read).

**E50. 4170** `/nursing-home-abuse-lawyers/bedsore-pressure-ulcer/`, body
- Published: "Georgia's nursing home regulations under O.C.G.A. § 31-8-1 et seq. and South Carolina's health facility licensing under S.C. Code § 44-7-110 et seq. incorporate these federal standards and impose additional state requirements for resident care quality."
- Corrected: replace "O.C.G.A. § 31-8-1 et seq." with "O.C.G.A. § 31-7-1 et seq.".
- **Attorney:** Tyler, on the "incorporate these federal standards" claim (not read).
  `SC 44-7-110` is unverified.

**E51. 4166** `/nursing-home-abuse-lawyers/sexual-abuse-elderly/`, body (imprecision)
- Published: "Additionally, O.C.G.A. § 31-8-1 et seq. provides a regulatory framework for nursing home accountability."
- Corrected: "Additionally, Georgia's Bill of Rights for Residents of Long-term Care Facilities (O.C.G.A. § 31-8-100 et seq.) sets the standard of care residents are owed."

**E52. 4168** `/nursing-home-abuse-lawyers/assisted-living-abuse/`, body and FAQ 1 (class sweep)
- Published (body): "Georgia categorizes ALFs as "personal care homes" and requires licensing by the Georgia Department of Community Health."
- Corrected: "Georgia classifies assisted living communities and personal care homes as separate kinds of institution (O.C.G.A. § 31-7-1(4)) and requires licensing by the Georgia Department of Community Health."
- FAQ 1 ("Georgia regulates assisted living facilities — called "personal care homes" — under
  O.C.G.A. § 31-7-1 et seq."): change "called "personal care homes"" to "assisted living
  communities and personal care homes".
- **Attorney:** Tyler.

### GA 4-8-20 (dog classifications) — Tyler Love

Authority: §§ 4-8-21 and 4-8-27, read today (candidates).

**E53. 4117** `/dog-bite-lawyers/dog-attack-jogger-cyclist/`, body
- Published: "Georgia's Responsible Dog Ownership Law ( O.C.G.A. § 4-8-20 et seq. ) requires owners of classified "dangerous dogs" and "vicious dogs" to maintain proper enclosures, use leashes, and carry liability insurance."
- Corrected: "Georgia's Responsible Dog Ownership Law (O.C.G.A. § 4-8-20 et seq.) requires owners of classified "dangerous" and "vicious" dogs to keep a secure enclosure and post warning signs, and requires the owner of a vicious dog to carry at least $50,000 in liability insurance (O.C.G.A. § 4-8-27)."
- The leash clause is dropped pending Tyler (§§ 4-8-28 to 4-8-30 not read).

**E54. 4119** `/dog-bite-lawyers/dangerous-breed-attack/`, body (definition bullet)
- Published: "Dangerous dog: A dog that causes a substantial puncture wound, aggressively attacks in a manner that causes injury, or has been classified as potentially dangerous and exhibits continued dangerous behavior"
- Corrected: "Dangerous dog: A dog that causes a substantial puncture of a person's skin without serious injury, aggressively attacks in a way that makes a person reasonably believe it posed an imminent threat of serious injury even though no injury occurs, or kills a pet animal while off its owner's property (O.C.G.A. § 4-8-21(a)(2))"

**E55. 4119**, body (definition bullet)
- Published: "Vicious dog: A dog that inflicts serious injury on a human or kills a human, without provocation"
- Corrected: "Vicious dog: A dog that inflicts serious injury on a person, or causes serious injury to a person trying reasonably to escape its attack (O.C.G.A. § 4-8-21(a)(6))"

**E56. 4119**, body
- Published: "Owners of classified dangerous dogs must maintain a proper enclosure, post warning signs, maintain $50,000 in liability insurance or a surety bond, and keep the dog muzzled and leashed when off the owner's property."
- Corrected: "Owners of classified dangerous and vicious dogs must keep a secure enclosure and post warning signs; the owner of a vicious dog must also have the dog microchipped and carry at least $50,000 in liability insurance (O.C.G.A. § 4-8-27)."
- **Attorney:** Tyler, on whether to restore a muzzle/leash sentence from § 4-8-28 or § 4-8-29.

**E57. 4120** `/dog-bite-lawyers/dog-on-dog-attack/`, body (two sentences)
- Published: "Georgia's Responsible Dog Ownership Law ( O.C.G.A. § 4-8-20 et seq. ) also applies, as aggressive behavior toward other animals is a factor in classifying a dog as "dangerous.""
  - Corrected: "Georgia's Responsible Dog Ownership Law (O.C.G.A. § 4-8-20 et seq.) also applies: a dog that kills a pet animal while off its owner's property can be classified as "dangerous" (O.C.G.A. § 4-8-21(a)(2)(C))."
- Published: "… may result in the attacking dog being classified as dangerous under O.C.G.A. § 4-8-20 or local ordinances."
  - Corrected: replace "§ 4-8-20" with "§ 4-8-21".

### GA 9-11-67.1 — Tyler Love

**E58. 1722** `/blog/demand-letters-in-personal-injury-cases/`, body
- Published: "In a Georgia motor-vehicle case, a demand prepared with a lawyer's help is a pre-suit offer under O.C.G.A. § 9-11-67.1 (as amended by SB 83, effective July 1, 2024)."
- Corrected: "In a Georgia motor-vehicle case, a demand prepared with a lawyer's help is a pre-suit offer under O.C.G.A. § 9-11-67.1 (as amended in 2024, for offers made on or after April 22, 2024)."
- Authority: the § 9-11-67.1 history line, "2024 Ga. Laws 415, § 1, eff. 4/22/2024".
- **Attorney:** Tyler, to confirm the bill number. "SB 83" is not on the page read; the
  effective date is.

### Error count by section and class

| Section (rule that caught it) | Errors | Pages |
|---|---:|---|
| GA 34-9-17 (cited) | 8 (E1–E8) | 1662, 1690, 1693, 1695 |
| SC 42-9-60 invented safety-rule reduction (class sweep) | 8 (E9: 3 statements; E10: 5 surfaces) | 1690 |
| GA 34-9-200.1 (cited) | 6 (E11–E16) | 1666, 1677 |
| GA 9-3-73 (cited) | 5 (E17–E21) | 1676, 1696, 4195 |
| GA 34-9-200 (cited and class) | 11 (E22–E31; E25 on two surfaces) | 1674, 1677, 1752, 5354 |
| GA wrongful-death deadline cited to a non-limitations section (cited and class) | 2 (E32–E33) | 4360, 1823 |
| Emergency-care standard (class) | 4 (E34–E37) | 4197, 5145, 5128, 5141 |
| GA 24-7-702 (cited) | 1 (+1 optional) (E38–E39) | 1718, 4363 |
| GA 40-6-294 mis-cite (cited) | 7 (E40–E46) | 4087, 4171, 4172, 4173, 4178 |
| GA 31-8-1 mis-cite (cited and class) | 7 (E47–E52; E52 on two surfaces) | 4163, 4164, 4165, 4166, 4170, 4168 |
| GA 4-8-20 et seq. (cited) | 6 (E53–E57; E57 two sentences) | 4117, 4119, 4120 |
| GA 9-11-67.1 effective date (cited) | 1 (E58) | 1722 |
| **Total** | **66** (+1 optional) | **34 documents** |

### False positives

None. The automated sweep engine was not run in this pass, so no rule fired. Every finding above
came from reading a text window around the citation, then sweeping the claim class by hand.

The two-state-table trap was checked on every two-column table. It produced no false positive this
time. It did produce two real errors, which were in the *other* state's column:
- E31: the SC physician-selection cell on 1674.
- E36/E37: the SC ER-standard cell on 5128 and its Spanish twin 5141.

## Needs an attorney

**Tyler Love (GA)**
- GA pack is UNSIGNED for Roden, so every GA correction is advisory.
- E1/E2: Georgia's position on retaliation.
- E8: the "ignored a safety rule" sentence.
- E48–E50: Chapter 7 rules not read.
- E52: assisted living.
- E53/E56: §§ 4-8-28 to 4-8-30.
- E58: bill number.
- The GA currency caveat: FindLaw text is current to 2024-03-28; confirm against the current
  official Code.
- 9-3-90: the TBI sentence on 1840.

**Graeham C. Gillin (SC)**
- E9/E10: confirm SC has no safety-rule reduction anywhere.
- E26: the 1677 SC medical-benefits sentence.
- E31: physician selection under § 42-15-60.
- E35–E37: wording on § 15-32-230.
- § 56-5-6160: the guilty-plea carve-out rests on Samuel v. Mouzon.
- E43/E45: § 56-5-3435 cited for equal rights.
- E2: the § 41-1-80 summary.

## Pack PR candidates (do not edit here; route through the packs repo)

These are authorities read today that the packs lack. Each would carry `evidence` set to the URL
read and `verifiedBy: null` until the attorney signs.
- **GA:** 34-9-200 (400-week rule), 34-9-200.1(g) (catastrophic definition), 9-3-73,
  51-1-29.5, 40-6-291, 4-8-21, 4-8-27, 31-8-108, 9-11-67.1 (2024 history), 51-12-1.1, 9-10-184,
  24-7-702.
- **SC:** 41-1-80 and 38-59-40.
- **Rule candidates** (for the packs repo, with fixture control sentences first):
  - SC "reduce … benefits … safety rule" bound to § 42-9-60 → error.
  - GA "medical benefits … no time limit / for life" in a workers'-comp context without
    "catastrophic" → error.
  - "§ 40-6-294" with "same rights" → error.
  - "§ 31-8-1" with "licens" → error.
- No existing pack authority was found wrong. `GA 9-3-71`'s minors clause, pending `GA 34-9-17`,
  `GA 51-4-5`, `GA 9-3-90`, and signed `SC 42-9-60` and `SC 15-32-230` all match the text read
  today.

## The inventory under-counts FAQ citations

`bin/inventory-statute-citations.php` serialises `_roden_faqs` with `wp_json_encode()` and then
runs its citation regex over the JSON. `wp_json_encode` escapes non-ASCII by default, so every "§"
in an FAQ becomes `§`. The regex expects `§`, `&sect;` or "Section" between "O.C.G.A." and the
number, so **any FAQ citation written with "§" is invisible to the inventory.**

Re-running the same regex over today's export:
- With FAQs JSON-escaped, the way the inventory does it: **379 statutes / 2,303 page-citations**.
  This matches the inventory exactly.
- With FAQs unescaped: 393 / 2,588.
- With HTML also stripped (a tag or `&nbsp;` between "O.C.G.A." and "§" also defeats the regex):
  **393 statutes / 2,607 page-citations**.

So the inventory misses **304 page-citations and 14 statutes**, almost all of them in FAQ answers.
FAQ answers are also FAQPage structured data. This is the "a sweep that cannot see a field reports
zero" failure from `CLAUDE.md`, inside the tool built to prevent it.

The fix is one argument: `wp_json_encode( $faqs, JSON_UNESCAPED_UNICODE )`, or `html_entity_decode`
plus `wp_strip_all_tags` on each surface before matching. It is not applied here, because this pass
writes only its two records. On the corrected basis, today's coverage is 137 / 393 statutes and
2,217 / 2,607 page-citations (85.0%). The statutes the inventory cannot see, all unverified:
- GA 52-7-8.2 (2), GA 34-9-2.1, GA 52-7-14, GA 25-2-40
- SC 50-21-145 (2), SC 62-3-804, SC 42-15-80, SC 42-1-415, SC 50-21-130, SC 50-21-114,
  SC 56-5-6420, SC 42-17-60

(The other two of the 14, SC 50-26-30 and GA 40-6-352, are already verified.)
