# Remediation: the practice-area comparison table (2026-09-26)

**Surface:** theme function `roden_jurisdiction_comparison_table()`
(`wordpress/wp-content/themes/roden-law/inc/template-tags.php`, lines 3473–3529). It is
called once from `templates/template-practice-area.php:338` and renders on every pillar
whose `_roden_jurisdiction` is `both`. That is all **24 English pillars** under
`/practice-areas/` and all **23 Spanish pillars** under `/es/practice-areas/` (translated
through `languages/es_ES.po`). Subtype and intersection pages do not render it.

**Sign-off state.** GA pack: **signed** (Mark Wade, 2026-09-24). Every GA authority this
plan adds is in `pendingAuthorities[]` and needs Wade's signature before it can back a *new*
claim. SC pack: **UNSIGNED**, so it is advisory. **Every South Carolina cell below goes to
attorney Gillin before publish**, and each is marked **[Gillin]**.

**Pack PR:** blue-sky-studio/internal-ai-scripts#62 (branch `law/comparison-table-2026-09-26`).

**The sweep cannot see this table.** The cells are theme msgids, not post content or meta.
`sweep-2026-09-26.json` (run against the 2026-09-25 export on main's packs) reports 15
unrelated pre-existing findings and nothing about the table. The only automated check on
these cells is the new fixture file `law/fixtures/roden-comparison-table-2026-09-26.json`:
the cells as published are positives and every replacement below is a control (22/22).

## What renders today (read from the live site, 2026-09-26)

Every pillar has `_roden_sol_ga` / `_roden_sol_sc` set, and the value is a **bare
citation**. So the English defaults (`2 years (O.C.G.A. § 9-3-33)` / `3 years (S.C. Code
§ 15-3-530)`) never render. The Statute of Limitations row shows a section number with no
period in it:

| Pillar | Georgia cell as rendered | South Carolina cell as rendered |
|---|---|---|
| most pillars | `O.C.G.A. § 9-3-33` | `S.C. Code § 15-3-530` |
| medical-malpractice | `O.C.G.A. § 9-3-71` | `S.C. Code § 15-3-545` |
| workers-compensation | `O.C.G.A. § 34-9-82` | `S.C. Code § 42-15-40` |
| maritime-injury | `Jones Act: 3 years (46 U.S.C. § 30106)` | `Longshore Act: 1 year (33 U.S.C. § 913)` |
| boating-accident | `O.C.G.A. § 9-3-33 (state) / 3 years (admiralty)` | `S.C. Code § 15-3-530 (state) / 3 years (admiralty)` |

The other four rows are identical on every pillar, including med-mal, workers' comp and
maritime.

## Structural changes (theme; you apply)

1. **Split "Damage Cap" into two rows: "Compensatory Damages Cap" and "Punitive Damages
   Cap".** The one cell was trying to say two things, and the compensatory half is the part
   that is wrong. Separate rows keep each cell short.
2. **Build the SOL cell as "period + cite"** from `roden_resolve_statute()`, the same way the
   hero already does (`template-practice-area.php:265–300`), instead of echoing the raw meta.
   Without this, the fixes to the defaults never reach a pillar.
3. **Render per-practice variants keyed by pillar slug** (the EN and ES slugs are the same):
   `medical-malpractice-lawyers`, `nursing-home-abuse-lawyers`,
   `workers-compensation-lawyers`, `maritime-injury-lawyers`, `wrongful-death-lawyers`. The
   variants are listed below. Every other pillar takes the generic wording.
4. **Show "Minimum Auto Insurance" only on motor-vehicle pillars:** car, truck, motorcycle,
   bicycle, pedestrian, electric-scooter, e-bike. It is true everywhere, but on med-mal,
   workers' comp or dog-bite it tells the reader nothing.
5. **Source line.** The cells will now cite two cases and a constitution, so change it to:
   `Sources: Georgia and South Carolina statutes and court decisions, as cited in each row.`
6. **Spanish heading (cosmetic, not legal).** The ES h2 renders "Leyes de Abogados de
   Negligencia Médica". `$label` strips only an English "Lawyers/Attorneys" suffix, so the
   Spanish title keeps "Abogados de".

---

## Row 1: Statute of Limitations

### 1a. Georgia default, `2 years (O.C.G.A. § 9-3-33)`
- **Verdict: correct.** It does not render today (see above).
- **Authority:** pack `GA 9-3-33` (signed). § 9-3-33: "actions for injuries to the person
  shall be brought within two years after the right of action accrues".
- **Replacement:** none. Keep it as the generic cell once change 2 is in.

### 1b. South Carolina default, `3 years (S.C. Code § 15-3-530)` [Gillin]
- **Verdict: correct.** Does not render today.
- **Authority:** pack `SC 15-3-530`. § 15-3-530(5): "within three years … any injury to
  the person".
- **Replacement:** none (generic).

### 1c. As rendered: bare citation on every pillar
- **Verdict: misleading.** It is not false, but a row headed "Statute of Limitations" that
  gives no period answers nothing.
- **Fix:** change 2, plus these per-practice cells:

| Pillar | Georgia | South Carolina [Gillin] |
|---|---|---|
| generic | `2 years (O.C.G.A. § 9-3-33)` | `3 years (S.C. Code § 15-3-530)` |
| medical-malpractice | `2 years; 5-year repose (O.C.G.A. § 9-3-71)` | `3 years from treatment or discovery; 6-year repose (S.C. Code § 15-3-545)` |
| wrongful-death | `2 years (O.C.G.A. § 9-3-33)` | `3 years from the date of death (S.C. Code § 15-3-530)` |
| workers-compensation | see the workers' comp table below | see below |
| maritime-injury | suppress the table (below) | — |
| product-liability (optional) | `2 years; 10-year repose for most product claims (O.C.G.A. §§ 9-3-33, 51-1-11)` | generic |

Authorities:
- `GA 9-3-71` (signed). § 9-3-71(a): two years; (b): no action more than five years after
  the act.
- `SC 15-3-545`. § 15-3-545(A): three years from treatment or discovery, "not to exceed six
  years from date of occurrence".
- `SC 15-3-530`. § 15-3-530(6): wrongful death, "the period to begin to run upon the death".
- § 51-1-11(b)(2): ten years from first sale. Read 2026-09-26 but **not in the pack**. It is
  optional, so add it to the pack before using it.

### 1d. Maritime pillar: `Jones Act: 3 years` under Georgia, `Longshore Act: 1 year` under South Carolina
- **Verdict: false as presented.** Both are federal statutes and apply in both states:
  46 U.S.C. § 30106 (3 years for a maritime tort) and 33 U.S.C. § 913(a) (1 year for a
  Longshore claim), both read at LII on 2026-09-26. Putting one under each state tells a
  Georgia longshore worker they have three years. They have one.
- **Fix:** suppress the table on `maritime-injury-lawyers` (EN and ES). Its premise, "the
  laws governing your claim differ by state", is false for Jones Act and Longshore claims.
  Every other row is also state law those claims don't use: Jones Act fault is pure
  comparative (46 U.S.C. § 30104, incorporating 45 U.S.C. § 53), and Longshore benefits are
  no-fault. If you would rather keep it, both columns must read identically:
  `Jones Act: 3 years (46 U.S.C. § 30106); Longshore Act: 1 year (33 U.S.C. § 913)`.
- **Authority:** federal. There is no federal pack, so the primary text is named above.

---

## Row 2: Comparative Fault Rule

### 2a. Georgia, `Modified — recover if less than 50% at fault (O.C.G.A. § 51-12-33)`
- **Verdict: correct** (generic).
- **Authority:** `GA 51-12-33` (signed). § 51-12-33(g): no recovery "if the plaintiff is 50
  percent or more responsible". SB 68 (2025) did not amend it (brief 2026-08-07).
- **Replacement:** none, except on workers' comp (below).

### 2b. South Carolina, `Modified — recover if less than 51% at fault` [Gillin]
- **Verdict: acceptable but imprecise, and it cites nothing.** *Nelson* lets a plaintiff
  recover if their negligence is "not greater than" the defendant's (read on CourtListener
  2026-09-26), and compares it to "the combined negligence of all defendants". That means
  50% or less. "Less than 51%" matches for whole percentages but would let in 50.5%. It is
  not an error on 166 content pages, and no rule is proposed for it.
- **Authority:** `Nelson v. Concrete Supply Co.` (pack, SC).
- **Replacement:** `Modified — recover if 50% or less at fault (Nelson v. Concrete Supply Co., 1991)`

### 2c. Wrong on specific pillars
- **workers-compensation: false.** Workers' comp does not reduce benefits by the worker's
  share of fault. Only willful misconduct or intoxication bars a claim. See the workers'
  comp table.
- **maritime-injury: false.** Suppress the table (1d).
- **boating-accident: [VERIFY — attorney].** On navigable waters, federal maritime law (pure
  comparative fault) may displace both state rules. That is case law I have not verified.
  I propose no change until Wade and Gillin rule on it.

---

## Row 3: "Damage Cap". Split into two rows (change 1)

### 3a. Georgia, `No cap on compensatory damages; punitive capped at $250,000 in most cases (O.C.G.A. § 51-12-5.1)`

**Compensatory half. Verdict: false as unqualified. It is true only against private defendants.**
- Claims against the State are capped at $1 million per person and $3 million per occurrence
  (O.C.G.A. § 50-21-29(b)(1)).
- Motor-vehicle claims against a city or county are limited to the immunity waiver of
  $500,000 / $700,000 (§ 36-92-2).
- **Medical malpractice: correct.** § 51-13-1's $350,000 cap is still printed in the Code,
  but *Atlanta Oculoplastic Surgery v. Nestlehutt*, 286 Ga. 731 (2010), affirmed the
  judgment declaring it unconstitutional (right to jury trial).
- **Authorities:** `GA 50-21-29`, `GA 36-92-2`, `Atlanta Oculoplastic Surgery v. Nestlehutt`
  (all in GA `pendingAuthorities`, awaiting Wade).
- **Replacement, "Compensatory Damages Cap" row:**
  - generic: `No cap, except some claims against government (e.g., O.C.G.A. § 50-21-29)`
  - medical-malpractice: `No cap; Georgia's med-mal cap was struck down (Atlanta Oculoplastic Surgery v. Nestlehutt, 2010)`
  - workers-compensation: see the workers' comp table.

**Punitive half. Verdict: correct on most pillars, misleading on product-liability.**
- § 51-12-5.1(g) caps punitive damages at $250,000. But (e) removes the cap for product
  liability (75% of the award goes to the state), and (f) removes it for specific intent to
  harm or impairment. On the product-liability pillar, "capped at $250,000 in most cases"
  states the exception as the rule.
- **Authority:** `GA 51-12-5.1` (GA `pendingAuthorities`, awaiting Wade).
- **Replacement, "Punitive Damages Cap" row, one generic cell that is also correct on
  product-liability, so no variant is needed:**
  `$250,000 in most cases; no cap for product liability, intent to harm, or impairment (O.C.G.A. § 51-12-5.1)`
- **wrongful-death: [VERIFY — attorney].** Whether punitive damages are recoverable in the
  Georgia wrongful-death claim itself (as opposed to the estate's claim) is case law I have
  not verified. The generic cell is not false, so no change is proposed.

### 3b. South Carolina, `No cap on compensatory damages; punitive damages capped at the greater of 3x compensatory damages or $500,000, with exceptions (S.C. Code § 15-32-530)` [Gillin]

**Compensatory half. Verdict: false as unqualified, and false outright on med-mal and nursing-home.**
- § 15-32-220 caps non-economic damages in medical malpractice. For 2026 the limits are
  **$596,001 per provider or institution and $1,788,002 in aggregate** (RFA memo 2026-02-03,
  published in the S.C. State Register Vol. 50 No. 2, 2026-02-27, p. 15). The exceptions are
  gross negligence, wilful or reckless conduct, fraud, and altered records.
- **§ 15-32-210(4) defines "health care institution" to include a nursing home**, so the cap
  reaches the nursing-home pillar too.
- § 15-78-120 caps claims against governmental entities ($300,000 / $600,000).
- **§ 33-56-180 caps claims against 501(c)(3) charities at the same Tort Claims Act limits.**
  That covers nonprofit hospitals and nursing homes. The 2026-09-03 brief's line "does not
  cap compensatory damages … outside medical malpractice" misses this and the government cap.
- **Authorities:** `SC 15-32-220` (corrected in PR #62: the aggregate was `$1,788,003`, now
  `$1,788,002`), `SC 15-78-120`, `SC 33-56-180` (new).
- **Replacement, "Compensatory Damages Cap" row:**
  - generic: `No general cap; capped in medical malpractice and against government or charities (S.C. Code §§ 15-32-220, 15-78-120, 33-56-180)`
  - medical-malpractice: `Non-economic damages capped at $596,001 per provider, $1,788,002 total (2026; adjusted yearly), with exceptions (S.C. Code § 15-32-220)`
  - nursing-home-abuse: `Non-economic damages capped in malpractice claims ($596,001 per facility, 2026) and against nonprofit facilities (S.C. Code §§ 15-32-220, 33-56-180)`.
    **[Gillin]:** which nursing-home claims count as "medical malpractice" rather than
    ordinary negligence or abuse is a legal call. The "in malpractice claims" wording
    leaves room for it.
  - workers-compensation: see the workers' comp table.

**Punitive half. Verdict: false as a statement of the current cap. This is the PR #151 wording.**
- § 15-32-530(D) indexes the (A) figure to CPI every year, effective on publication in the
  State Register. RFA's 2026 memo sets it at **$739,245**, published 2026-02-27 (Register
  Vol. 50 No. 2, p. 15). "$500,000" is the 2011 base, and it understates today's cap by
  about $239,000. The four-times-or-$2,000,000 tier in (B) is not indexed. The
  `docs/briefs/2026-09-03-sc-punitive-damages-cap.md` allowlist quotes (A)–(C) and omits (D).
- **Authority:** `SC 15-32-530` (claim corrected in PR #62).
- **Rule that caught it:** `sc-punitive-floor-unindexed` (new, error).
- **Replacement, "Punitive Damages Cap" row:**
  `Greater of 3x compensatory or $739,245 (2026; adjusted yearly), with exceptions (S.C. Code § 15-32-530)`
  - **Maintenance:** RFA publishes a new figure every February. Update this cell and the med-mal
    variant each year, or drop the figure and say `…or an inflation-adjusted floor ($500,000 in 2011)`.

---

## Row 4: Minimum Auto Insurance

### 4a. Georgia, `25/50/25 liability coverage required`
- **Verdict: correct, uncited.**
- **Authority:** O.C.G.A. § 33-34-4 requires liability insurance equivalent to the Chapter 9
  of Title 40 security. § 40-9-37(a) sets that at no less than § 33-7-11(a)(1)(A):
  $25,000 / $50,000 / $25,000. The pack's signed `GA 33-7-11` gets the numbers right, but
  § 33-7-11 is the uninsured-motorist section. `GA 33-34-4` is added to
  `pendingAuthorities` as the correct source for the liability minimum.
- **Replacement:** `25/50/25 liability coverage required (O.C.G.A. § 33-34-4)`. Motor-vehicle
  pillars only (change 4).

### 4b. South Carolina, `25/50/25 liability coverage required` [Gillin]
- **Verdict: correct, uncited.**
- **Authority:** `SC 38-77-140`. § 38-77-140(A)(1)–(3): $25,000 / $50,000 / $25,000.
- **Replacement:** `25/50/25 liability coverage required (S.C. Code § 38-77-140)`. Motor-vehicle
  pillars only.

---

## Row 5: Filing Court

### 5a. Georgia, `Superior Court (claims over $15,000)`
- **Verdict: false.** It turns the magistrate court's ceiling into a floor on superior court,
  and it leaves out state court.
  - § 15-10-2(5): magistrate court hears civil claims up to $15,000.
  - § 15-6-8: superior courts hold original jurisdiction of "all causes … granted to them by
    the Constitution and laws", with no minimum.
  - § 15-7-4(a)(2): state courts try "civil actions without regard to the amount in
    controversy", concurrently with superior court. Most tort suits can be filed in either.
- **Authorities:** `GA 15-10-2`, `GA 15-6-8`, `GA 15-7-4` (GA `pendingAuthorities`).
- **Rule that caught it:** `ga-superior-court-dollar-floor` (new, error).
- **Replacement:** `Superior or State Court, any amount; Magistrate Court up to $15,000 (O.C.G.A. § 15-10-2)`

### 5b. South Carolina, `Circuit Court (claims over $7,500)` [Gillin]
- **Verdict: false.** Same shape of error.
  - § 22-3-10 gives magistrates **concurrent** civil jurisdiction up to $7,500.
  - S.C. Const. art. V, § 11 makes the circuit court "a general trial court with original
    jurisdiction in civil and criminal cases", with no minimum.
- **Authorities:** `SC 22-3-10` (now verified), `S.C. Const. art. V, § 11` (new).
- **Rule that caught it:** `sc-circuit-court-dollar-floor` (new, error).
- **Replacement:** `Circuit Court (Common Pleas), any amount; Magistrate Court up to $7,500 (S.C. Code § 22-3-10)`

### 5c. Wrong on specific pillars
- **workers-compensation: false.** Comp claims are filed with the State Board of Workers'
  Compensation (§ 34-9-82(c)) and the S.C. Workers' Compensation Commission (§ 42-15-40),
  not in a court. See the table below.
- **maritime: false.** Suppress the table.

---

## Workers' compensation pillar: render its own rows

Every tort row is wrong or meaningless here. Recommended rows, with row labels changed:

| Row label | Georgia | South Carolina [Gillin] |
|---|---|---|
| Claim Deadline | `1 year from injury, extended by employer-paid treatment or benefits (O.C.G.A. § 34-9-82)` | `2 years from the accident (S.C. Code § 42-15-40)` |
| Notice to Employer | `Within 30 days (O.C.G.A. § 34-9-80)` | `Within 90 days (S.C. Code § 42-15-20)` |
| Fault | `Not a factor, except willful misconduct or intoxication (O.C.G.A. § 34-9-17)` | `Not a factor, except intoxication or intent to injure (S.C. Code § 42-9-60)` |
| Damages | `No pain-and-suffering damages; weekly benefits capped by statute (O.C.G.A. §§ 34-9-11, 34-9-261)` | `No pain-and-suffering damages; weekly benefits capped at the state average weekly wage (S.C. Code §§ 42-1-540, 42-9-10)` |
| Punitive Damages | `Not available against the employer (O.C.G.A. § 34-9-11)` | `Not available against the employer (S.C. Code § 42-1-540)` |
| Where to File | `State Board of Workers' Compensation (O.C.G.A. § 34-9-82(c))` | `S.C. Workers' Compensation Commission (S.C. Code § 42-15-40)` |

Authorities (primary text read 2026-09-26):
- `GA 34-9-82`, `GA 34-9-80`, `GA 34-9-261` (signed). The GA weekly figure is left out on
  purpose, per the pack's stale-figure rule.
- `GA 34-9-11`, `GA 34-9-17` (pending).
- `SC 42-15-40`, `SC 42-15-20`, `SC 42-1-540`, `SC 42-9-60`, `SC 42-9-10`.
- "Not a factor" is a structural reading of both Acts (compensability has no fault element).
  The pack marks it for the attorneys to confirm.

---

## Same claim class elsewhere: `sc-punitive-floor-unindexed`, 34 findings on 26 pages

The Damage Cap cell is not the only place this claim is published. With PR #62's packs, the
2026-09-25 export has **34 error findings on 26 pages** stating the SC cap as "the greater of
three times compensatory damages or $500,000" with no indexing. **12 of them are FAQ
answers, which also publish as FAQPage schema.** I read every excerpt and all 34 are true
positives.

Pages where the claim appears in both the body and an FAQ answer:

| Page | Doc | Surfaces |
|---|---|---|
| /blog/first-steps-in-a-medical-malpractice-case/ | 1646 | body, faqs[5] |
| /blog/how-do-i-know-if-i-have-a-personal-injury-case/ | 1673 | body, faqs[5] |
| /blog/how-pain-and-suffering-is-calculated-after-an-accident-in-south-carolina/ | 3440 | body, faqs[4] |
| /car-accident-lawyers/drunk-driver-accident/ | 4048 | body, faqs[2] |
| /boating-accident-lawyers/boating-under-influence/ | 4144 | body, faqs[1] |
| /golf-cart-accident-lawyers/golf-cart-dui/ | 4189 | body, faqs[1] |
| /blog/medical-malpractice-limits-south-carolina/ | 4562 | body, faqs[0] |
| /resources/south-carolina-truck-accident-settlement-value/ | 4806 | body, faqs[4] |
| /resources/south-carolina-car-accident-settlement-value/ | 4809 | body, faqs[4] |

Pages where it appears in the body only:

| Page | Doc |
|---|---|
| /blog/truck-accident-reconstruction/ | 1647 |
| /blog/5-benefits-of-hiring-a-truck-accident-attorney-in-2023/ | 1669 |
| /blog/can-someone-sue-me-for-a-car-accident/ | 1675 |
| /blog/tips-for-choosing-a-motor-vehicle-accident-attorney/ | 1681 |
| /blog/what-is-the-role-of-a-personal-injury-lawyer-in-a-case/ | 1683 |
| /blog/driving-record-and-injury-claim/ | 1703 |
| /blog/car-insurance-claim-denial-tactics/ | 1719 |
| /blog/demand-letters-in-personal-injury-cases/ | 1722 |
| /blog/truck-accident-liability/ | 1810 |
| /blog/rollover-crashes-and-what-they-do-to-your-body/ | 2647 |
| /burn-injury-lawyers/defective-product-burn/ | 4154 |
| /blog/charleston-medical-malpractice-hospital-claim-south-carolina/ | 4349 |
| /blog/summer-dui-accidents-charleston-memorial-day-labor-day/ | 4360 |
| /blog/how-to-maximize-your-car-accident-compensation-in-south-carolina/ | 4534 |
| /blog/average-personal-injury-settlement-amounts/ | 4584 |
| /blog/what-to-do-after-car-accident-south-carolina/ | 4590 |

**Correction pattern** [Gillin]. Keep each page's own voice, and keep "$500,000" if the page
wants the statutory text, but always pair it with the index and the current figure.
Post 1663 already does this and is the model:

> … at the greater of three times the compensatory damages or $500,000, a floor indexed for
> inflation each year ($739,245 in 2026).

Table cells (1681, 1683, 1703, 1719, 1722) take the short form:
`Greater of 3x compensatory or $739,245 (2026; adjusted yearly)`.

These are **not in this plan's scope to write**. They need one batch through
`bin/apply-faq-remediation.php` (FAQs) and the body patcher, with exact-match `str_replace` +
`wp_slash`. Until they are fixed, any freshness or backfill publish that touches these pages
will block on this rule.

---

## Counts by rule

| Rule | Where | Findings | Status |
|---|---|---|---|
| `ga-superior-court-dollar-floor` (new) | table, Filing Court GA, 47 pillars | 1 cell | replacement above |
| `sc-circuit-court-dollar-floor` (new) | table, Filing Court SC, 47 pillars | 1 cell | replacement above [Gillin] |
| `sc-punitive-floor-unindexed` (new) | table, Damage Cap SC, 47 pillars | 1 cell | replacement above [Gillin] |
| `sc-punitive-floor-unindexed` (new) | content, 26 pages | 34 (12 FAQ) | listed above, not applied |
| no rule: unqualified "no cap on compensatory" | table GA + SC | 2 cells | replacement above |
| no rule: practice-blind cells (WC, maritime, med-mal, nursing-home) | table | 4 pillars | variants above |
| no rule: bare-cite SOL | table, all pillars | 1 row | change 2 |
| pre-existing, unrelated (`hands-free-repealed-section` 6, `sctca-mandatory-notice` 4, `municipal-ante-litem-12-months` 3, `county-ante-litem-6-months` 2) | content | 15 | untouched; see `sweep-2026-09-26.json` |

## False positives

**None.** All 34 content hits of the new rule were read and are true positives.

One fixture changed meaning. `roden-tier1-2026-08-26.json` `ctrl-2` asserted that the
unindexed "$500,000" sentence is correct. That audit missed § 15-32-530(D). In PR #62 it is
now a positive with a `_note`, and `ctrl-2b` holds the corrected sentence. This corrects the
fixture's premise. It does not loosen a rule.

## Not verified, or needs an attorney

- **GA primary text came from Wayback snapshots.** FindLaw and Justia returned a bot challenge
  on 2026-09-26. The FindLaw snapshots are "current as of March 28, 2024"; the Justia ones
  are the 2022–2024 editions. Every pack evidence string names its snapshot. Confirm against
  the current Code before Wade signs.
- *Nestlehutt* was read through CourtListener search highlights (holding language and
  "Judgment affirmed"), not a full-text read.
- [VERIFY — attorney] Boating on navigable waters: does maritime law's pure comparative fault
  displace the state rules?
- [VERIFY — attorney] GA wrongful death: are punitive damages recoverable in the wrongful-death
  claim itself?
- [VERIFY — attorney] SC nursing-home SOL: does § 15-3-545 reach nursing-home claims? It
  defines providers by cross-reference to Title 38, ch. 79, art. 5, which I did not read.
- [Gillin] Every SC cell, the SC nursing-home "malpractice" line, and whether
  `sc-punitive-floor-unindexed` should stay at error (it blocks 26 pages) or go to warn until
  the batch lands.
- Follow-up: after PR #62 merges, run `node scripts/facts/vendor.mjs gal --write` on
  Georgia Auto Law `main` and commit. Its vendored GA.json drifts until then.
